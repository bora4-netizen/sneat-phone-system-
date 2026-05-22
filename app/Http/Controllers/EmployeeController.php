<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
  function __construct()
  {
      $this->middleware('auth');
      $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
      $this->middleware('permission:user-create', ['only' => ['create','store']]);
      $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
      $this->middleware('permission:user-password-edit', ['only' => ['editPassword', 'updatePassword']]);
      $this->middleware('permission:user-delete', ['only' => ['destroy']]);
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
      $users = User::get();
      return view('employees.index', ['users' => $users]);
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
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($lang, $id)
    {
        $user = User::with('employee')->findOrfail($id);
        $roles = Role::pluck('name', 'id');
        return view('employees.edit-profile', [
          'user' => $user,
          'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $lang, string $id)
    {
        $user = User::findOrfail($id);
        $request->validate([
            'position' => 'required',
            'name' => 'required',
            'latin_name' => 'required',
            'phone' => 'required',
            'gender' => 'required|in:1,2,3',
        ]);

        $employee = [
            'name' => $request->name ?? '',
            'latin_name' => $request->latin_name ?? '',
            'id_card_no' => $request->id_card_no ?? '',
            'phone' => $request->phone ?? '',
            'email' => $request->email ?? '',
            'gender' => $request->gender,
            'dob' => $request->dob,
            'birth_place' => $request->birth_place,
            'address' => $request->address,
            'status' => $request->status,
            'start_working_date' => $request->start_working_date,
        ];
        if($user->can('role-edit')){
            $employee['position_id'] = $request->position;
        }

        if ($image = $request->file('profile')) {
          $destinationPath = 'images/profile/';
          $formattedNumber = str_pad($user->id, 5, '0', STR_PAD_LEFT);
          $filename = $image->getClientOriginalName();
          $profileImage = $formattedNumber. "_" .md5($filename . time()) . "." . $image->getClientOriginalExtension();
          $image->move($destinationPath, $profileImage);
          $employee['profile'] = $profileImage;
      }
        $user->employee()->update($employee);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->position);

        return redirect()->route('users.index', withLang());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $lang, $id)
    {
        $request->validate([
            'confirm' => 'required',
        ]);
        // Find the User by ID
        // $user = User::findOrFail($id);

        // Delete the associated Employee
        // $user->employee()->destroy($id);

        // Optionally, you can also delete the User itself
        User::destroy($id);
        return redirect()->route('users.index', withLang())->with('success', 'Branch soft deleted successfully');
    }

    public function editPassword($id)
    {
        $user = User::with('employee')->findOrfail($id);
        return view('employees.edit-password', [
          'user' => $user
        ]);
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'new_password' => 'required|confirmed',
        ]);
        $user = User::findOrfail($id);
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->route('users.edit.password', withLang(['id' => $user->id]))->with('success', 'Password updated successfully');
    }
}
