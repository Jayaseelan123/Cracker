<?php

namespace App\Http\Controllers;

use App\Models\TermsSection;
use Illuminate\Http\Request;

class TermsSectionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'title_en'     => 'required|string|max:255',
            'title_ta'     => 'nullable|string|max:255',
            'content_en'   => 'required|string',
            'content_ta'   => 'nullable|string',
            'section_type' => 'required|in:terms,privacy',
            'is_active'    => 'nullable|boolean',
        ]);

        $data['is_active']  = $request->boolean('is_active', true);
        $data['sort_order'] = TermsSection::where('section_type', $data['section_type'])->max('sort_order') + 1;

        TermsSection::create($data);

        $tab = $data['section_type'] === 'terms' ? 'terms' : 'privacy';
        return redirect()->route('admin.settings', ['tab' => $tab])
            ->with('success', 'Section added successfully.');
    }

    public function update(Request $request, TermsSection $termsSection)
    {
        $data = $request->validate([
            'title_en'   => 'required|string|max:255',
            'title_ta'   => 'nullable|string|max:255',
            'content_en' => 'required|string',
            'content_ta' => 'nullable|string',
            'is_active'  => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $termsSection->update($data);

        $tab = $termsSection->section_type === 'terms' ? 'terms' : 'privacy';
        return redirect()->route('admin.settings', ['tab' => $tab])
            ->with('success', 'Section updated successfully.');
    }

    public function destroy(TermsSection $termsSection)
    {
        $tab = $termsSection->section_type === 'terms' ? 'terms' : 'privacy';
        $termsSection->delete();
        return redirect()->route('admin.settings', ['tab' => $tab])
            ->with('success', 'Section deleted.');
    }

    /**
     * AJAX: Reorder sections.
     * Body: {"order": [5, 2, 7]}
     */
    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array']);
        foreach ($request->order as $index => $id) {
            TermsSection::where('id', $id)->update(['sort_order' => $index]);
        }
        return response()->json(['success' => true]);
    }
}
