<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\DeliveryZone;
use App\Models\TermsSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    // Default settings with their keys and defaults
    const DEFAULTS = [
        // Product Display
        'show_pricelist_home'     => '1',
        'show_pricelist_download' => '1',
        'show_product_code'       => '0',
        'show_discount_row'       => '1',
        'enable_category_filter'  => '1',
        'enable_search_filter'    => '1',
        'pdf_font_size'           => '9',
        // Website
        'website_status'          => 'active',
        'maintenance_message'     => 'We are currently under maintenance. Please check back soon.',
        'price_format'            => 'INR',
        'new_arrival_days'        => '30',
        // Print
        'printout_format'         => 'A4',
        'print_show_logo'         => '1',
        'print_custom_message'    => '',
        // Legacy
        'terms_content'           => '',
        'privacy_content'         => '',
        'products_list_pdf'       => '',
    ];

    /**
     * Show the settings page.
     */
    public function index()
    {
        $settings     = SiteSetting::getAllCached();
        $deliveryZones = DeliveryZone::orderBy('sort_order')->get();
        $termsItems   = TermsSection::where('section_type', 'terms')->orderBy('sort_order')->get();
        $privacyItems = TermsSection::where('section_type', 'privacy')->orderBy('sort_order')->get();

        return view('admin.settings.index', compact(
            'settings', 'deliveryZones', 'termsItems', 'privacyItems'
        ));
    }

    /**
     * Save general settings (product display, website, print).
     */
    public function update(Request $request)
    {
        $request->validate([
            'products_list_pdf' => 'nullable|mimes:pdf|max:10240',
            'pdf_font_size'     => 'nullable|numeric|min:6|max:20',
            'website_status'    => 'nullable|in:active,maintenance',
            'printout_format'   => 'nullable|in:A4,A5,Letter',
            'new_arrival_days'  => 'nullable|integer|min:1|max:365',
        ]);

        // Handle PDF upload
        if ($request->hasFile('products_list_pdf')) {
            $old = SiteSetting::get('products_list_pdf');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $path = $request->file('products_list_pdf')->store('pdf', 'public');
            SiteSetting::set('products_list_pdf', $path);
        }

        // Boolean toggles — unchecked checkboxes send nothing, so default to '0'
        $boolKeys = [
            'show_pricelist_home', 'show_pricelist_download',
            'show_product_code', 'show_discount_row',
            'enable_category_filter', 'enable_search_filter',
            'print_show_logo',
        ];

        $toSave = [];
        foreach ($boolKeys as $k) {
            $toSave[$k] = $request->has($k) ? '1' : '0';
        }

        // Text / select fields
        $textKeys = [
            'pdf_font_size', 'website_status', 'maintenance_message',
            'price_format', 'new_arrival_days', 'printout_format',
            'print_custom_message', 'terms_content', 'privacy_content',
        ];
        foreach ($textKeys as $k) {
            $toSave[$k] = $request->input($k, self::DEFAULTS[$k] ?? '');
        }

        SiteSetting::setMany($toSave);

        return redirect()->route('admin.settings')
            ->with('success', 'Settings saved successfully.');
    }

    /**
     * Save the combined layout from the new UI
     */
    public function saveCombined(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'settings' => 'array',
            'terms' => 'array',
            'terms.*' => 'string|nullable',
            'zones' => 'array',
            'zones.*.state_name' => 'required|string',
            'zones.*.min_order_amount' => 'required|numeric',
            'zones.*.packing_charges' => 'required|numeric',
            'zones.*.all_cities' => 'boolean',
            'zones.*.cities' => 'array|nullable',
        ]);

        // Sync Global Settings
        if ($request->has('settings')) {
            $toSave = [];
            foreach ($request->settings as $key => $val) {
                // Map boolean true/false to '1'/'0' strings for SiteSetting
                if (is_bool($val)) {
                    $toSave[$key] = $val ? '1' : '0';
                } else {
                    $toSave[$key] = (string) $val;
                }
            }
            \App\Models\SiteSetting::setMany($toSave);
        }

        // Sync Terms
        \App\Models\TermsSection::truncate();
        if ($request->has('terms')) {
            foreach ($request->terms as $index => $termText) {
                if (trim($termText)) {
                    \App\Models\TermsSection::create([
                        'title_en' => $termText,
                        'content_en' => '',
                        'section_type' => 'terms',
                        'sort_order' => $index,
                        'is_active' => true,
                    ]);
                }
            }
        }

        // Sync Delivery Zones
        \App\Models\DeliveryZone::truncate();
        if ($request->has('zones')) {
            foreach ($request->zones as $index => $zone) {
                \App\Models\DeliveryZone::create([
                    'state_name' => $zone['state_name'],
                    'cities' => $zone['cities'] ?? [],
                    'all_cities' => $zone['all_cities'] ?? false,
                    'min_order_amount' => $zone['min_order_amount'] ?? 0,
                    'packing_charges' => $zone['packing_charges'] ?? 0,
                    'sort_order' => $index,
                    'is_active' => true,
                ]);
            }
        }

        return response()->json(['success' => true]);
    }
}
