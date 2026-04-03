<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Mail;

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
        Schema::defaultStringLength(191);

        \Illuminate\Support\Facades\View::composer('frontend.partials.pricing', function ($view) {
            $pricingData = \App\Models\Setting::where('key', 'pricing_data')->value('value');
            if ($pricingData) {
                $decoded = json_decode($pricingData, true);
                if (is_array($decoded)) {
                    $view->with('pricingPlans', $decoded['plans'] ?? []);
                    $view->with('pricingCategories', $decoded['categories'] ?? []);
                    return;
                }
            }

            $view->with('pricingPlans', config('pricing.plans', []));
            $view->with('pricingCategories', config('pricing.categories', []));
        });

        View::composer('layouts.navbar', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                
                // Get unread mails
                $unreadMails = Mail::where('receiver_id', $user->id)
                    ->where('is_read', false)
                    ->where('is_draft', false)
                    ->where('is_trashed_receiver', false)
                    ->with('sender')
                    ->latest()
                    ->take(5)
                    ->get();
                
                $unreadMailsCount = Mail::where('receiver_id', $user->id)
                    ->where('is_read', false)
                    ->where('is_draft', false)
                    ->where('is_trashed_receiver', false)
                    ->count();

                // Get unread notifications
                $unreadNotifications = $user->unreadNotifications()->take(5)->get();
                $unreadNotificationsCount = $user->unreadNotifications()->count();

                // Get birthdays today
                $todayBirthdays = \App\Models\User::whereMonth('date_of_birth', now()->month)
                    ->whereDay('date_of_birth', now()->day)
                    ->get();

                $view->with([
                    'unreadMails' => $unreadMails,
                    'unreadMailsCount' => $unreadMailsCount,
                    'unreadNotifications' => $unreadNotifications,
                    'unreadNotificationsCount' => $unreadNotificationsCount,
                    'todayBirthdays' => $todayBirthdays,
                ]);
            }
        });
    }
}
