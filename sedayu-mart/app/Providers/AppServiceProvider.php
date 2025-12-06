<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Share admin WhatsApp number across all user views
        View::composer('user.*', function ($view) {
            $adminPhoneRaw = User::where('role', 'admin')->value('nomor_telepon');
            $adminWhatsapp = null;

            if ($adminPhoneRaw) {
                $digits = preg_replace('/\D+/', '', $adminPhoneRaw);
                if (str_starts_with($digits, '0')) {
                    $digits = '62' . substr($digits, 1);
                } elseif (! str_starts_with($digits, '62')) {
                    $digits = '62' . $digits;
                }
                $adminWhatsapp = $digits;
            }

            $view->with('adminWhatsapp', $adminWhatsapp);
        });
    }
}
