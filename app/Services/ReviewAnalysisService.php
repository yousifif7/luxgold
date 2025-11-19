<?php

namespace App\Services;

use App\Models\Review;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class ReviewAnalysisService
{
    public function analyze(int $days = null, int $top = null)
    {
        $days = $days ?? config('analysis.recent_days', 90);
        $top = $top ?? config('analysis.top_keywords', 30);

        $cacheKey = 'review_analysis_summary';
        $ttl = config('analysis.cache_ttl_minutes', 60);

        // Try cache first
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $since = now()->subDays($days);
        // Some codebases use boolean `is_approved` and `comment` field for review text.
        $query = Review::where('created_at', '>=', $since);
        if (Schema::hasColumn('reviews', 'is_approved')) {
            $query->where('is_approved', 1);
        } elseif (Schema::hasColumn('reviews', 'status')) {
            $query->where('status', 'approved');
        }

        $textField = Schema::hasColumn('reviews', 'comment') ? 'comment' : (Schema::hasColumn('reviews', 'content') ? 'content' : null);
        $select = ['id','provider_id','user_id','created_at'];
        if ($textField) $select[] = $textField;

        $reviews = $query->get($select);

        $positiveWords = array_map('strtolower', config('analysis.positive', []));
        $negativeWords = array_map('strtolower', config('analysis.negative', []));
        $flagWords = array_map('strtolower', config('analysis.flags', []));
        $stopwords = array_flip(array_map('strtolower', config('analysis.stopwords', [])));

        $counts = ['positive'=>0,'neutral'=>0,'negative'=>0];
        $freq = [];
        $flagged = [];

        foreach ($reviews as $r) {
            $text = strtolower($r->{$textField} ?? '');
            // strip punctuation
            $clean = preg_replace('/[^a-z0-9\s]/', ' ', $text);
            $words = preg_split('/\s+/', $clean, -1, PREG_SPLIT_NO_EMPTY);

            $pos = 0; $neg = 0;
            foreach ($words as $w) {
                if (isset($stopwords[$w]) || strlen($w) < 2) continue;
                // increment freq
                $freq[$w] = ($freq[$w] ?? 0) + 1;
                if (in_array($w, $positiveWords)) $pos++;
                if (in_array($w, $negativeWords)) $neg++;
            }

            $score = $pos - $neg;
            if ($score > 0) $counts['positive']++;
            elseif ($score < 0) $counts['negative']++;
            else $counts['neutral']++;

            // flags
            $matchedFlags = array_values(array_intersect($flagWords, $words));
            if (!empty($matchedFlags)) {
                $flagged[] = [
                    'id' => $r->id,
                    'provider_id' => $r->provider_id,
                    'snippet' => mb_substr($r->{$textField} ?? '', 0, 200),
                    'matched' => array_values(array_unique($matchedFlags)),
                    'created_at' => $r->created_at,
                ];
            }
        }

        arsort($freq);
        $keywords = array_slice($freq, 0, $top, true);

        $summary = [
            'counts' => $counts,
            'keywords' => $keywords,
            'flagged' => $flagged,
            'total_reviews' => $reviews->count(),
            'generated_at' => now()->toDateTimeString(),
        ];

        Cache::put($cacheKey, $summary, now()->addMinutes($ttl));

        return $summary;
    }
}
