<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:access-users',['only'=>['index']]);
        $this->middleware('permission:create-users',['only'=>['create','store']]);
        $this->middleware('permission:update-users',['only'=>['edit','store']]);
        $this->middleware('permission:delete-users',['only'=>['destroy']]);


    }
    public function export()
    {
        return Excel::download((new UsersExport)->forstatus(1)->forYear(2021), 'users.xlsx');
    }

    public function import(Request $request )
    {
        $path='';
        if($request->hasFile('file')){
            $path=$request->file('file')->store('imports');
        }
        if($path != '')
        try{
            Excel::import(new UsersImport, 'storage/'.$path);

        toastr()->success('Users Added successfully');}
        catch(Exception $ex){

            toastr()->error($ex->getMessage());}


        return redirect(route('users.index'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::paginate(25);
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles=Role::all();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'roles' => ['required'],
            'phone' => ['required', 'string', 'max:15'],
            //'password'=>['required', 'string', 'min:6'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->id],
           // 'image'=>['required','image','max:51120'],
            "image"=>[request()->id>0?"nullable":"required","image","max:51120"],
            "password"=>[request()->id>0?"nullable":"required","string", "min:6"],

        ]);

        $path="";
        if($request->id>0)//update
            $user=User::findOrFail($request->id);

        if($request->id>0)//update
        {
            $path=$user->image;//old image


        }
        if ($request->hasFile('image'))
        $path = $request->file('image')->store('users');

       //change path and store file





        $user = User::updateOrCreate(
            [
                'id' => $request->id,

            ]
            , [
                'name' => $request->name,
                'email' => $request->email,
                'image' => $path,//??

                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'status' => isset($request->status)
        ]);

        $user->assignRole($request->roles);
        if ($request->id > 0)
            toastr()->success('Updated successfully');
        else
            toastr()->success('Added successfully');
        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles=Role::all();

        return view('users.create',compact('roles','user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {

        Storage::delete($user->image);

        foreach($user->roles as $role)
        $user->removeRole($role);

        $user->delete();
        toastr()->success("Deleted successfully");
        return redirect(route(('users.index')));
    }
}
