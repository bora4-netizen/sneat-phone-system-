<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Customer;
use App\Models\CustomerJob;
use App\Models\CustomerGuarantor;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
  function __construct()
  {
      $this->middleware('auth');
      $this->middleware('permission:customer-list|customer-create|customer-edit|customer-delete', ['only' => ['index','store']]);
      $this->middleware('permission:customer-create', ['only' => ['create','store']]);
      $this->middleware('permission:customer-edit', ['only' => ['edit','update']]);
      $this->middleware('permission:customer-password-edit', ['only' => ['editPassword', 'updatePassword']]);
      $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
      // $customers = Customer::get();

      $query = Customer::query();
      $selectCustomer = Customer::get();
      $parameterNames = [];
      if ($request->search) {
        $filters = $request->only(['name', 'phone', 'customer_type', 'gender' ]);

        if (!empty($filters['name'])) {
          $query->where('id', $filters['name']);
          $parameterNames['name'] = $filters['name'];
        }

        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
          $query->whereBetween('date', [$filters['from_date'], $filters['to_date']]);
          $parameterNames['from_date'] = $filters['from_date'];
          $parameterNames['to_date'] = $filters['to_date'];
        } elseif (!empty($filters['from_date'])) {
            $query->where('date', '>=', $filters['from_date']);
            $parameterNames['from_date'] = $filters['from_date'];
        } elseif (!empty($filters['to_date'])) {
            $query->where('date', '<=', $filters['to_date']);
            $parameterNames['to_date'] = $filters['to_date'];
        }

      }
      $customers = $query->orderBy('id', 'desc')->paginate(20);
      return view('customers.index', [
        'customers' => $customers,
        'selectCustomer' => $selectCustomer
      ]);
  }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::get();
        return view('customers.create', ['customers' => $customers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        $customer = new Customer();
        $customer->id_card_number = $request->id_card_number ?? '';
        $customer->name = $request->name ?? '';
        $customer->latin_name = $request->latin_name ?? '';
        $customer->gender = $request->gender;
        $customer->nationality = $request->nationality;
        $customer->family_status = $request->family_status;
        $customer->dob = $request->dob;
        $customer->house_number = $request->house_number ?? '';
        $customer->street_number = $request->street_number ?? '';
        $customer->group_number = $request->group_number ?? '';
        $customer->village = $request->village ?? '';
        $customer->district = $request->district ?? '';
        $customer->commune = $request->commune ?? '';
        $customer->province = $request->province ?? '';
        $customer->housing_ownership_type = $request->housing_ownership_type;
        $customer->phone = $request->phone;
        $customer->mobile = $request->mobile;
        $customer->facebook = $request->facebook;
        $customer->customer_type = $request->customer_type;
        $customer->profile = '';
        $customer->employee_id = auth()->user()->id ?? '';
        $customer->save();

        if ($profile = $request->file('profile')) {
          $destinationPath = 'images/profile/';
          $formattedNumber = str_pad($customer->id, 5, '0', STR_PAD_LEFT);
          $filename = $profile->getClientOriginalName();
          $customerImage = $formattedNumber. "_" .md5($filename . time()) . "." . $profile->getClientOriginalExtension();
          $profile->move($destinationPath, $customerImage);
          $customer->profile = $customerImage;
          $customer->save();
        }
        if($request->customer_type == 2){
          $customer_job = new CustomerJob();
          $customer_job->customer_id = $customer->id ?? '';
          $customer_job->name = $request->customer_company_name ?? '';
          $customer_job->latin_name = $request->customer_company_name_latin ?? '';
          $customer_job->house_number = $request->company_house_number ?? '';
          $customer_job->street_number = $request->company_street_number ?? '';
          $customer_job->group_number = $request->company_group_number ?? '';
          $customer_job->village = $request->company_village ?? '';
          $customer_job->commune = $request->company_commune ?? '';
          $customer_job->district = $request->company_district ?? '';
          $customer_job->province = $request->company_province ?? '';
          $customer_job->phone = $request->company_phone ?? '';
          $customer_job->email = $request->company_email ?? '';
          $customer_job->salary = $request->salary ?? 0;
          $customer_job->salary_date = $request->date_income ?? '';
          $customer_job->other_income = $request->other_income ?? 0;
          $customer_job->save();

          $customer_guarantor = new CustomerGuarantor();
          $customer_guarantor->customer_id = $customer->id ?? '';
          $customer_guarantor->id_card_number = $request->guarantor_id_card_number ?? '';
          $customer_guarantor->name = $request->guarantor_name ?? '';
          $customer_guarantor->gender = $request->guarantor_gender ?? '';
          $customer_guarantor->latin_name = $request->guarantor_latin_name ?? '';
          $customer_guarantor->customer_relation_type = $request->guarantor_relationship ?? '';
          $customer_guarantor->nationality = $request->guarantor_nationality ?? '';
          $customer_guarantor->family_status = $request->guarantor_status ?? '';
          $customer_guarantor->dob = $request->guarantor_dob ?? '';
          $customer_guarantor->house_number = $request->guarantor_house_number ?? '';
          $customer_guarantor->street_number = $request->guarantor_street_number ?? '';
          $customer_guarantor->group_number = $request->guarantor_group_number ?? '';
          $customer_guarantor->village = $request->guarantor_village ?? '';
          $customer_guarantor->commune = $request->guarantor_commune ?? '';
          $customer_guarantor->district = $request->guarantor_district ?? '';
          $customer_guarantor->province = $request->guarantor_province ?? '';
          $customer_guarantor->housing_ownership_type = $request->guarantor_property_owner ?? '';
          $customer_guarantor->phone = $request->guarantor_phone ?? '';
          $customer_guarantor->mobile = $request->guarantor_mobile ?? '';
          $customer_guarantor->facebook = $request->guarantor_facebook ?? '';
          $customer_guarantor->save();
        }
        return redirect()->route('customers.index', withLang());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $lang, $id)
    {
        //
        $customer = Customer::findorfail($id);

        $employee = Employee::pluck('name', 'id');

        $customerImage = $customer->getProfileImageAttribute();

        // $customer = $customer->with('name', 'gender', 'customer_type', 'nationality', 'employee_id', 'phone', 'profile', 'document')->findOrfail($customer->id);
        return view('customers.show', withLang(['customer' => $customer, 'customerimg' => $customerImage]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($lang, $id)
    {
        $customer = Customer::with(['guarantor', 'job','employee'])->findOrfail($id);
        $roles = Role::pluck('name', 'id');
        return view('customers.edit-profile', [
          'customer' => $customer,
          'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, string $lang, string $id)
    {
        $customer = Customer::findOrfail($id);

        $customer->id_card_number = $request->id_card_number ?? '';
        $customer->name = $request->name ?? '';
        $customer->latin_name = $request->latin_name ?? '';
        $customer->gender = $request->gender;
        $customer->nationality = $request->nationality;
        $customer->family_status = $request->family_status;
        $customer->dob = $request->dob;
        $customer->house_number = $request->house_number ?? '';
        $customer->street_number = $request->street_number ?? '';
        $customer->group_number = $request->group_number ?? '';
        $customer->village = $request->village ?? '';
        $customer->district = $request->district ?? '';
        $customer->commune = $request->commune ?? '';
        $customer->province = $request->province ?? '';
        $customer->housing_ownership_type = $request->housing_ownership_type;
        $customer->phone = $request->phone;
        $customer->mobile = $request->mobile;
        $customer->facebook = $request->facebook;
        $customer->customer_type = $request->customer_type;
        $customer->profile = '';
        $customer->employee_id = auth()->user()->id ?? '';
        $customer->save();

        if ($profile = $request->file('profile')) {
          $destinationPath = 'images/profile/';
          $formattedNumber = str_pad($customer->id, 5, '0', STR_PAD_LEFT);
          $filename = $profile->getClientOriginalName();
          $customerImage = $formattedNumber. "_" .md5($filename . time()) . "." . $profile->getClientOriginalExtension();
          $profile->move($destinationPath, $customerImage);
          $customer->profile = $customerImage;
          $customer->save();
        }

        if($request->customer_type == 2){
          $customerJobData = [
            'name' => $request->customer_company_name ?? '',
            'latin_name' => $request->customer_company_name_latin ?? '',
            'house_number' => $request->company_house_number ?? '',
            'street_number' => $request->company_street_number ?? '',
            'group_number' => $request->company_group_number ?? '',
            'village' => $request->company_village ?? '',
            'commune' => $request->company_commune ?? '',
            'district' => $request->company_district ?? '',
            'province' => $request->company_province ?? '',
            'phone' => $request->company_phone ?? '',
            'email' => $request->company_email ?? '',
            'salary' => $request->salary ?? 0,
            'salary_date' => $request->date_income ?? '',
            'other_income' => $request->other_income ?? 0,
          ];
          $customer->job->update($customerJobData);

          $customerGuarantorData = [
            'id_card_number' => $request->guarantor_id_card_number ?? '',
            'name' => $request->guarantor_name ?? '',
            'latin_name' => $request->guarantor_latin_name ?? '',
            'gender' => $request->guarantor_gender ?? '',
            'customer_relation_type' => $request->guarantor_relationship ?? '',
            'nationality' => $request->guarantor_nationality ?? '',
            'family_status' => $request->guarantor_status ?? '',
            'dob' => $request ->guarantor_dob ?? now(),
            'house_number' => $request->guarantor_house_number ?? '',
            'street_number' => $request->guarantor_street_number ?? '',
            'group_number' => $request->guarantor_group_number ?? '',
            'village' => $request->guarantor_village ?? '',
            'commune' => $request->guarantor_commune ?? '',
            'district' => $request->guarantor_district ?? '',
            'province' => $request->guarantor_province ?? '',
            'phone' => $request->guarantor_phone ?? '',
            'mobile' => $request->guarantor_mobile ?? '',
            'facebook' => $request->guarantor_facebook ?? '',
          ];
          $customer->guarantor->update($customerGuarantorData);
        }

        // Customer::findOrFail($id)->update($customerData);

        return redirect()->route('customers.index', withLang());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $lang, $id)
    {
        $request->validate([
            'confirm' => 'required',
        ]);

        // try {
            Customer::destroy($id);
            // dd($request);
            return redirect()->route('customers.index', withLang())->with('success', 'Customer soft deleted successfully');
        // } catch (\Exception $e) {
        //     // Log the error or handle it as needed

        //     return redirect()->back()->with('error', 'Error deleting customer: ' . $e->getMessage());
        // }
    }

    public function editPassword($id)
    {
        $customer = Customer::with('employee')->findOrfail($id);
        return view('employees.edit-password', [
          'customer' => $customer
        ]);
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'new_password' => 'required|confirmed',
        ]);
        $customer = Customer::findOrfail($id);
        $customer->password = Hash::make($request->new_password);
        $customer->save();
        return redirect()->route('customers.edit.password', withLang(['id' => $customer->id]))->with('success', 'Password updated successfully');
    }
}
