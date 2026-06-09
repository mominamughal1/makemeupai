<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $baseUrl = rtrim(config('app.url'), '/');

        config([
            'filesystems.disks.public.url' => "{$baseUrl}/storage",
        ]);
    }
}
