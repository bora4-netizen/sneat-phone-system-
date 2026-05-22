<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Position;
use App\Models\Employee;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Rules\LowercaseWithUnderscore;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:user-create', ['only' => ['showRegistrationForm','create','register']]);
    }

    public function showRegistrationForm()
    {
        $roles = Role::pluck('name', 'id');
        return view('auth.register')->with([
            'roles' => $roles,
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:20', new LowercaseWithUnderscore, 'unique:users'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users'],
            'position' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $userInfo = Auth::user();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'] ?? $data['name'].'@example.com',
            'password' => Hash::make($data['password']),
        ]);

        // Creates the user profile
        $employee = Employee::create([
          'user_id' => $user->id,
          'name' => '',
          'latin_name' => '',
          'phone' => '',
          'position_id' => $data['position'] ?? 1
        ]);
        $user->employee()->save($employee);
        $user->assignRole($data['position']);

        // This, of course, assumes you have
        // the above relationship defined in your user model.
        return $user;
    }
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect()->route('users.edit', withLang(['id' => $user->id]));
    }
}
