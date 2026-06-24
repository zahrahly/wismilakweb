<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        \Illuminate\Support\Facades\Blade::directive('roleLabel', function ($expression) {
            return "<?php echo ({$expression} === 'customer' || strtolower({$expression}) === 'customer') ? 'Cigar Member' : ucfirst({$expression}); ?>";
        });
    }
}
