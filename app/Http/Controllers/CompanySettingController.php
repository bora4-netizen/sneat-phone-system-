<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $company = CompanySetting::first();
      return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CompanySetting $companySetting)
    {
        $company = CompanySetting::first();
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'detail' => 'required',
            'address' => 'required',
        ]);

        $data = [
            'name' => $request->name ?? '',
            'detail' => $request->detail ?? '',
            'interest' => $request->interest ?? '',
            'phone' => $request->phone ?? '',
            'address' => $request->address ?? '',
            'default_loan_note' => $request->default_loan_note ?? '',
            'default_invoice_note' => $request->default_invoice_note ?? '',
        ];

        if ($image = $request->file('logo')) {
          $destinationPath = 'images/company/';
          $formattedNumber = str_pad($company->id, 5, '0', STR_PAD_LEFT);
          $filename = $image->getClientOriginalName();
          $profileImage = $formattedNumber. "_" .md5($filename . time()) . "." . $image->getClientOriginalExtension();
          $image->move($destinationPath, $profileImage);
          $data['logo'] = $profileImage;
        }

        $company->update($data);

        return redirect()->route('company.index', withLang());
    }
}
