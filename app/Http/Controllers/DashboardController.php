<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Client;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\Service;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function writerDashboard(): JsonResponse
    {
        $userId = Auth::id();

        $myTotalArticles = Article::where('author_id', $userId)->count();
        $publishedArticles = Article::where('author_id', $userId)
            ->where('status', 'published')
            ->count();
        $draftArticles = Article::where('author_id', $userId)
            ->where('status', 'draft')
            ->count();

        $recentArticles = Article::with('author')
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($article) use ($userId) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'status' => $article->status ?? 'draft',
                    'is_mine' => $article->author_id === $userId,
                    'author' => [
                        'name' => $article->author?->name ?? 'Unknown',
                    ],
                ];
            });

        return response()->json([
            'stats' => [
                'my_total_articles' => $myTotalArticles,
                'published_articles' => $publishedArticles,
                'draft_articles' => $draftArticles,
            ],
            'recent_articles' => $recentArticles,
        ]);
}

    public function index(): JsonResponse
    {
        $stats = [
            'services' => Service::count(),
            'clients' => Client::count(),
            'products' => Product::count(),
            'portfolios' => Portfolio::count(),
            'visitors' => Visitor::count(),
        ];

        // Monthly visitors for the current year
        $year = Carbon::now()->year;

        $visitors = Visitor::whereYear('created_at', $year)
            ->get(['created_at']);

        $monthlyCounts = array_fill(1, 12, 0);

        foreach ($visitors as $visitor) {
            $monthlyCounts[$visitor->created_at->month]++;
        }

        // Build array for all 12 months
        $monthlyVisitors = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyVisitors[] = [
                'month' => $m,
                'label' => Carbon::create()->month($m)->format('M'),
                'total' => $monthlyCounts[$m],
            ];
        }

        return response()->json([
            'stats' => $stats,
            'monthly_visitors' => $monthlyVisitors,
            'year' => $year,
        ]);
    }
}
