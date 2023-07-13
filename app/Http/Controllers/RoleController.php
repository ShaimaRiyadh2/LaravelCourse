<?php

namespace App\Http\Controllers;


//use App\Models\Role;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\RoleController;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:access-roles',['only'=>['index']]);
        $this->middleware('permission:create-roles',['only'=>['create','store']]);
        $this->middleware('permission:update-roles',['only'=>['edit','store']]);
        $this->middleware('permission:delete-roles',['only'=>['destroy']]);


    }
    public function index()
    {
        $roles=Role::all();
        return view('roles.index',compact('roles'));
    }
    public function create()
    {
        $groups=Permission::select('group')->distinct()->get();
        return view('roles.create', compact('groups'));
    }


    public function store(Request $request)
    {
        $request->validate([
            // 'name'->'required|unique:roles,name'.$request
            "name"=>"required|unique:roles,name,".$request->id,
        ]);
        //return dd($request);

        $role = Role::UpdateOrCreate(
            ["id" => $request->id],
            [
                'name' => $request->name,

            ]);

            $role->syncPermissions($request->permissions);
        if ($request->id > 0)
            toastr()->success('Updated successfully');
        else
            toastr()->success('Added successfully');
        return redirect(route('roles.index'));
    }
    public function edit(Role $role)
    {
        $groups=Permission::select('group')->distinct()->get();
        return view('roles.create', compact('groups', 'role'));
    }
    public function destroy(Role $role)
    {

        $role->delete();
        toastr()->success("Deleted successfully");
        return redirect(route(('roles.index')));
    }
}
