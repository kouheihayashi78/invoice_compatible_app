<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        // Inertia::shareを使うと、すべてのInertiaページで使えるグローバルデータを設定できる（つまりsuccessを使える）
        Inertia::share([
            // Vue側で、「props.success」として受け取れる
            'success' => function () {
                return session()->get('success');
            },
            'successDel' => function () {
                return session()->get('successDel');
            }
        ]);
    }
}
