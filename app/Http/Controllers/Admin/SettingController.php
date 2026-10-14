<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->pluck('value', 'key');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        foreach ($data as $key => $value) {
            if ($value && ($key === 'google_site_verification' || $key === 'bing_site_verification')) {
                if (preg_match('/content=[\'"]([^\'"]+)[\'"]/i', $value, $matches)) {
                    $value = $matches[1];
                }
            }
            SiteSetting::set($key, $value ? trim($value) : $value);
        }

        return back()->with('success', 'Pengaturan website berhasil diperbarui!');
    }
}
