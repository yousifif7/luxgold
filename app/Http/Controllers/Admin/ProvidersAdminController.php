<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cleaner as Provider;

class ProvidersAdminController extends Controller
{
    public function index(Request $request)
    {
        // Total providers
        $totalProviders = Provider::count();

        // Top performing provider this month (payments table)
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $top = DB::table('payments')
            ->select('cleaner_id', DB::raw('SUM(amount) as revenue'))
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('cleaner_id')
            ->orderByDesc('revenue')
            ->first();

        $topProviderName = null;
        $topProviderRevenue = 0;
        $revenueTrendLabels = [];
        $revenueTrendData = [];

        if ($top) {
            $p = Provider::find($top->cleaner_id);
            $topProviderName = $p->business_name ?? $p->name ?? 'Cleaner ' . $top->cleaner_id;
            $topProviderRevenue = (float) $top->revenue;

            // revenue trend last 30 days for this provider
            $start = now()->subDays(29)->startOfDay();
            $end = now()->endOfDay();
            $rows = DB::table('payments')
                ->select(DB::raw('DATE(created_at) as day'), DB::raw('SUM(amount) as revenue'))
                ->where('Cleaner_id', $top->cleaner_id)
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('day')
                ->orderBy('day')
                ->get()
                ->pluck('revenue', 'day')
                ->toArray();

            for ($i = 29; $i >= 0; $i--) {
                $d = now()->subDays($i)->format('Y-m-d');
                $revenueTrendLabels[] = now()->subDays($i)->format('M j');
                $revenueTrendData[] = isset($rows[$d]) ? (float)$rows[$d] : 0;
            }
        }

        // Average rating across approved reviews
        $avgRating = DB::table('reviews')->where('status', 'approved')->avg('rating') ?: 0;

        // Providers by city
        $byCity = Provider::select('city', DB::raw('count(*) as cnt'))
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderByDesc('cnt')
            ->limit(10)
            ->get();

        // Providers list for the table (simple paginate)
        $providers = Provider::with(['subscription.plan'])->orderByDesc('created_at')->paginate(15);

        return view('admin.providers.index', compact(
            'providers',
            'totalProviders',
            'topProviderName',
            'topProviderRevenue',
            'revenueTrendLabels',
            'revenueTrendData',
            'avgRating',
            'byCity'
        ));
    }

    /**
     * Export providers as CSV
     */
    public function export(Request $request)
    {
        $filename = 'providers_export_' . date('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $columns = ['id','name','business_name','email','phone','city','state','zip_code','category','status','rating','revenue'];

        $callback = function() use ($columns) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            Provider::chunk(200, function($providers) use ($out, $columns) {
                foreach ($providers as $p) {
                    $row = [];
                    foreach ($columns as $c) { $row[] = $p->{$c} ?? ''; }
                    fputcsv($out, $row);
                }
            });
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
