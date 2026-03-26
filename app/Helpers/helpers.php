<?php


if (!function_exists('getRouterValue')) {
    function getRouterValue()
    {

        if (config('app.env') === 'production') {

            $__getRoutingValue = '/cork/laravel/vertical-light-menu/';

        }
        else if (config('app.env') === 'pre_production') {

            $__getRoutingValue = '/cork/laravel_cork_4/vertical-light-menu/';

        }
        else {

            $__getRoutingValue = '/';

        }


        // if (config('app.env') === 'production') {

        //     $__getRoutingValue = '/cork/laravel/vertical-light-menu/';

        // } else {

        //     $__getRoutingValue = '/';

        // }


        return $__getRoutingValue;

    }
}

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        $setting = \App\Models\Setting::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}