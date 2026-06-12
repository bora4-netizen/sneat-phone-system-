<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:user-profile-edit', ['only' => ['update']]);
        $this->middleware('permission:user-profile-edit|user-profile-password-edit', ['only' => ['editPassword','updatePassword']]);
    }

    public function edit()
    {
        $user = User::with('employee')->findOrfail(Auth::id());
        $roles = Role::pluck('name', 'id');
        return view('users.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function update(Request $request)
    {
        $user = User::findOrfail(Auth::id());
        $request->validate([
            'position'   => 'required',
            'name'       => 'required',
            'latin_name' => 'required',
            'phone'      => 'required',
            'gender'     => 'required|in:1,2',
            // ✅ លុប current_password និង new_password ចេញ — មិនទាក់ទង profile update
        ]);

        $employee = [
            'name'               => $request->name ?? '',
            'latin_name'         => $request->latin_name ?? '',
            'id_card_no'         => $request->id_card_no ?? '',
            'phone'              => $request->phone ?? '',
            'email'              => $request->email ?? '',
            'gender'             => $request->gender,
            'dob'                => $request->dob,
            'birth_place'        => $request->birth_place,
            'address'            => $request->address,
            'status'             => $request->status,
            'start_working_date' => $request->start_working_date,
        ];

        if ($user->can('role-edit')) {
            $employee['position_id'] = $request->position;
        }

        if ($image = $request->file('profile')) {
            $destinationPath = 'images/profile/';
            $formattedNumber = str_pad($user->id, 5, '0', STR_PAD_LEFT);
            $filename = $image->getClientOriginalName();
            $profileImage = $formattedNumber . "_" . md5($filename . time()) . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $employee['profile'] = $profileImage;
        }

        $user->employee()->update($employee);
        DB::table('model_has_roles')->where('model_id', Auth::id())->delete();
        $user->assignRole($request->position);

        return redirect()->route('users.edit.profile', withLang());
    }

    public function editPassword()
    {
        $user = User::with('employee')->findOrfail(Auth::id());
        return view('users.edit-password', [
            'user' => $user
        ]);
    }

    public function updatePassword(Request $request)
    {

    
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password'     => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrfail(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('users.edit.profile', withLang())->with('success','updatesuccessful');

      
    }
}