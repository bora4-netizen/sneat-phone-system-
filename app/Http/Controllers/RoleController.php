<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $roles = Role::orderBy('id','DESC')->paginate(20);
        return view('roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create(): View
    // {
    //     $permission = Permission::get();
    //     return view('roles.create',compact('permission'));
    // }

    public function create(): View
{
    $permission = Permission::get()->groupBy(function ($perm) {
        return explode('-', $perm->name)[0]; // e.g. "role", "user", "product"
    });
    return view('roles.create', compact('permission'));
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index', withLang())
                        ->with('success','Role created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lang, $id): View
    {
        $role = Role::findOrfail($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return view('roles.show',compact('role','rolePermissions'));
    }

   /**
 * Show the form for editing the specified resource.
 *
 * @param int $id
 * @return \Illuminate\View\View
 */
public function edit($lang, $id): View
{
    $role = Role::findOrFail($id);

    $permission = Permission::all()->groupBy(function ($item) {
        return explode('-', $item->name)[0];
    });

    $rolePermissions = DB::table('role_has_permissions')
        ->where('role_id', $id)
        ->pluck('permission_id')
        ->toArray();

    return view('roles.edit', compact(
        'role',
        'permission',
        'rolePermissions'
    ));
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,string $lang, string $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => ['required', Rule::unique('roles', 'name')->ignore($id)],
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index', withLang())
                        ->with('success','Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function destroy($lang, $role)
{
    $role = \Spatie\Permission\Models\Role::findOrFail($role);
    
    $role->delete();
    
    return redirect()->route('roles.index', withLang())
                     ->with('success', 'Role deleted successfully.');
}
}
