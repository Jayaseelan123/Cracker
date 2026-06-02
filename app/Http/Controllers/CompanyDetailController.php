<?php

namespace App\Http\Controllers;

use App\Models\CompanyDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyDetailController extends Controller
{
    /**
     * Show the Company Settings form (single-record pattern).
     */
    public function edit()
    {
        // Always get or create the single company record (id=1)
        $company = CompanyDetail::firstOrCreate(['id' => 1]);
        return view('admin.company_details.edit', compact('company'));
    }

    /**
     * Save / update company details.
     */
    public function update(Request $request)
    {
        $request->validate([
            'company_name'    => 'required|string|max:255',
            'address'         => 'required|string|max:1000',
            'contact_number'  => 'required|string|max:20',
            'whatsapp_number' => 'required|string|max:20',
            'logo'            => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'bank_ac_no'      => 'nullable|string|max:50',
            'bank_ac_name'    => 'nullable|string|max:255',
            'bank_ac_type'    => 'nullable|string|max:50',
            'bank_name'       => 'nullable|string|max:255',
            'bank_ifsc'       => 'nullable|string|max:20',
        ]);

        $company = CompanyDetail::firstOrCreate(['id' => 1]);

        $data = $request->only([
            'company_name', 'address', 'contact_number', 'whatsapp_number',
            'bank_ac_no', 'bank_ac_name', 'bank_ac_type', 'bank_name', 'bank_ifsc',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $uploadDir = public_path('images/company');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            // Delete old logo
            if ($company->logo && file_exists(public_path($company->logo))) {
                @unlink(public_path($company->logo));
            }
            
            $file = $request->file('logo');
            $filename = time() . '_logo.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $data['logo'] = 'images/company/' . $filename;
        }

        $company->update($data);

        return redirect()->route('admin.company.edit')
            ->with('success', 'Company details updated successfully!');
    }
}
