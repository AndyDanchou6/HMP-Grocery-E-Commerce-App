<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getGeneralSettings()
    {
        $settings = Settings::whereIn('setting_key', ['phone', 'address', 'opening_time', 'closing_time', 'fb_page', 'map_url', 'fb_link', 'instagram_link', 'twitter_link', 'youtube_link'])->get();

        $processedSettings = [];
        foreach ($settings as $setting) {
            if (in_array($setting->setting_key, ['opening_time', 'closing_time'])) {
                $processedSettings[$setting->setting_key] = date('H:i', strtotime($setting->setting_value));
            } else {
                $processedSettings[$setting->setting_key] = $setting->setting_value;
            }
        }

        return view('settings.index', compact('processedSettings'));
    }


    public function updateGeneralSettings(Request $request)
    {
        $startTime = strtotime($request->input('opening_time'));
        $endTime = strtotime($request->input('closing_time'));

        if ($endTime <= $startTime) {
            return redirect()->back()->with('error', 'Invalid Schedule.');
        }

        $settings = [
            'phone' => $request->phone,
            'address' => $request->address,
            'fb_page' => $request->fb_page,
            'fb_link' => $request->fb_link,
            'map_url' => $request->map_url,
            'instagram_link' => $request->instagram_link,
            'twitter_link' => $request->twitter_link,
            'youtube_link' => $request->youtube_link,
            'opening_time' => date('H:i:s', strtotime($request->opening_time)),
            'closing_time' => date('H:i:s', strtotime($request->closing_time))
        ];

        foreach ($settings as $key => $value) {
            Settings::updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Settings $settings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Settings $settings)
    {
        //
    }
}
