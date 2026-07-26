<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gateway;
use Illuminate\Http\Request;

class GatewaySettingController extends Controller
{
    public function index()
    {
        $gateways = Gateway::query()->orderByDesc('is_active')->orderBy('id')->get();
        return view('admin.pages.setting.gateways.index', compact('gateways'));
    }

    public function edit(Gateway $gateway)
    {
        $drivers = config('gateways.drivers', []);
        $meta = $drivers[$gateway->driver]['fields'] ?? [];
        $title = trans($drivers[$gateway->driver]['title'] ?? 'general.gateways_setting');

        $values = $gateway->config ?? [];

        return view('admin.pages.setting.gateways.edit', compact('gateway', 'meta', 'values', 'title'));
    }

    public function update(Request $request, Gateway $gateway)
    {
        $drivers = config('gateways.drivers', []);
        $meta = $drivers[$gateway->driver]['fields'] ?? [];

        $rules = [
            'is_active' => ['nullable', 'boolean'],
        ];

        foreach ($meta as $fieldKey => $fieldMeta) {
            $fieldRules = [];
            $fieldRules[] = !empty($fieldMeta['required']) ? 'required' : 'nullable';
            $fieldRules[] = 'string';
            $fieldRules[] = 'max:500';
            $rules["config.$fieldKey"] = $fieldRules;
        }

        $validated = $request->validate($rules);

        $gateway->update([
            'is_active' => (bool) $request->boolean('is_active'),
            'config' => $validated['config'] ?? [],
        ]);

        return back()->with('success', __('general.saved_successfully'));
    }

    public function toggle(Gateway $gateway)
    {
        $gateway->update(['is_active' => !$gateway->is_active]);
        return back()->with('success', __('general.saved_successfully'));
    }
}
