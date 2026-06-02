<?php

namespace App\Http\Controllers;

use App\Models\DeliveryZone;
use Illuminate\Http\Request;

class DeliveryZoneController extends Controller
{
    public function index()
    {
        $zones = DeliveryZone::orderBy('sort_order')->get();
        return view('admin.settings.delivery_zones', compact('zones'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'state_name'       => 'required|string|max:100',
            'all_cities'       => 'nullable|boolean',
            'cities'           => 'nullable|array',
            'cities.*'         => 'string|max:100',
            'min_order_amount' => 'required|numeric|min:0',
            'packing_charges'  => 'required|numeric|min:0',
            'is_active'        => 'nullable|boolean',
        ]);

        $data['all_cities'] = $request->boolean('all_cities');
        $data['is_active']  = $request->boolean('is_active', true);
        $data['cities']     = $data['all_cities'] ? null : ($data['cities'] ?? []);
        $data['sort_order'] = DeliveryZone::max('sort_order') + 1;

        DeliveryZone::create($data);

        return redirect()->route('admin.settings', ['tab' => 'delivery'])
            ->with('success', 'Delivery zone added.');
    }

    public function update(Request $request, DeliveryZone $deliveryZone)
    {
        $data = $request->validate([
            'state_name'       => 'required|string|max:100',
            'all_cities'       => 'nullable|boolean',
            'cities'           => 'nullable|array',
            'cities.*'         => 'string|max:100',
            'min_order_amount' => 'required|numeric|min:0',
            'packing_charges'  => 'required|numeric|min:0',
            'is_active'        => 'nullable|boolean',
        ]);

        $data['all_cities'] = $request->boolean('all_cities');
        $data['is_active']  = $request->boolean('is_active', true);
        $data['cities']     = $data['all_cities'] ? null : ($data['cities'] ?? []);

        $deliveryZone->update($data);

        return redirect()->route('admin.settings', ['tab' => 'delivery'])
            ->with('success', 'Delivery zone updated.');
    }

    public function destroy(DeliveryZone $deliveryZone)
    {
        $deliveryZone->delete();
        return redirect()->route('admin.settings', ['tab' => 'delivery'])
            ->with('success', 'Delivery zone deleted.');
    }

    /**
     * AJAX: Reorder zones via drag-and-drop.
     * Expects JSON body: {"order": [3, 1, 2]} (array of IDs in new order)
     */
    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array']);
        foreach ($request->order as $index => $id) {
            DeliveryZone::where('id', $id)->update(['sort_order' => $index]);
        }
        return response()->json(['success' => true]);
    }

    /**
     * AJAX: Toggle active status.
     */
    public function toggle(DeliveryZone $deliveryZone)
    {
        $deliveryZone->update(['is_active' => !$deliveryZone->is_active]);
        return response()->json(['is_active' => $deliveryZone->is_active]);
    }
}
