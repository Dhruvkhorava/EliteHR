<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.general', [
            'settings' => $settings,
            'catName' => 'settings',
            'title' => 'General Settings',
            'breadcrumbs' => ['Settings', 'General Settings'],
            'scrollspy' => 0,
            'simplePage' => 0,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->except('_token', '_method');

        foreach ($data as $key => $value) {
            if ($request->hasFile($key)) {
                // Delete old file if exists
                $oldSetting = Setting::where('key', $key)->first();
                if ($oldSetting && $oldSetting->value) {
                    Storage::disk('public')->delete($oldSetting->value);
                }

                $path = $request->file($key)->store('settings', 'public');
                $value = $path;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    public function pricing()
    {
        $pricingData = Setting::where('key', 'pricing_data')->value('value');
        if (!$pricingData) {
            $pricingData = json_encode([
                'plans' => config('pricing.plans', []),
                'categories' => config('pricing.categories', []),
            ]);
        }
        
        return view('admin.settings.pricing', [
            'pricingData' => $pricingData,
            'catName' => 'settings',
            'title' => 'Pricing Settings',
            'breadcrumbs' => ['Settings', 'Pricing Settings'],
            'scrollspy' => 0,
            'simplePage' => 0,
        ]);
    }

    public function updatePricing(Request $request)
    {
        $request->validate([
            'pricing_data' => 'required|json'
        ]);

        Setting::updateOrCreate(
            ['key' => 'pricing_data'],
            ['value' => $request->pricing_data]
        );

        return redirect()->back()->with('success', 'Pricing updated successfully.');
    }
}
