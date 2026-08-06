<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Visitor;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $stats = [
                'totalVisitors' => 0,
                'uniqueVisitors' => 0,
                'todayVisitors' => 0,
            ];

            try {
                $stats = [
                    'totalVisitors' => Visitor::count(),
                    'uniqueVisitors' => Visitor::distinct('ip')->count('ip'),
                    'todayVisitors' => Visitor::whereDate('created_at', today())->count(),
                ];
            } catch (Throwable $e) {
                report($e);
            }

            $view->with([
                'totalVisitors' => $stats['totalVisitors'],
                'uniqueVisitors' => $stats['uniqueVisitors'],
                'todayVisitors' => $stats['todayVisitors'],
            ]);
        });
    }
}
