<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Services\ReviewAnalysisService;

class AnalyzeReviews extends Command
{
    protected $signature = 'analysis:reviews {--days=} {--top=} {--no-cache}';
    protected $description = 'Run review sentiment and keyword analysis and store results in cache';

    public function handle(ReviewAnalysisService $service)
    {
        $days = $this->option('days');
        $top = $this->option('top');
        $noCache = $this->option('no-cache');

        if ($noCache) {
            Cache::forget('review_analysis_summary');
            $this->info('Cache cleared for review_analysis_summary.');
        }

        $this->info('Running review analysis...');
        $result = $service->analyze($days ? (int)$days : null, $top ? (int)$top : null);

        $this->info('Analysis complete.');
        $this->line('Total reviews analyzed: ' . ($result['total_reviews'] ?? 0));
        $this->line('Positive: ' . ($result['counts']['positive'] ?? 0));
        $this->line('Neutral: ' . ($result['counts']['neutral'] ?? 0));
        $this->line('Negative: ' . ($result['counts']['negative'] ?? 0));

        return 0;
    }
}
