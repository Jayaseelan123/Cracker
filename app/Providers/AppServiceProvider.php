<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Use Bootstrap 5 pagination (uses our custom vendor/pagination/bootstrap-5.blade.php)
        Paginator::useBootstrapFive();

        // Inject site settings into ALL views automatically
        // This makes $siteSettings available everywhere without passing from each controller
        View::composer('*', function ($view) {
            static $settings = null;
            if ($settings === null) {
                try {
                    $settings = SiteSetting::getAllCached();
                } catch (\Exception $e) {
                    $settings = [];
                }
            }
            $view->with('siteSettings', $settings);
        });
    }
}
