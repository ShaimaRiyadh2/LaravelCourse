<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

class BrandController extends Controller
{

    public function __construct()
{
    $this->middleware('permission:access-brands',['only'=>['index']]);
    $this->middleware('permission:create-brands',['only'=>['create','store']]);
    $this->middleware('permission:update-brands',['only'=>['edit','update']]);
    $this->middleware('permission:delete-brands',['only'=>['destroy']]);


}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $brands=Brand::all();
        $brands=Brand::whereExists(function ($query){
            $query->select(DB::raw(1))
            ->from('products')
            ->whereColumn('brands.id','products.brand_id');
        })->paginate(20);
        return view('brands.index',compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {//return view('brands.create');
        if ($request->hasFile('image')) {
           // $img = $request->file('bookcover');


        $path=$request->file('image')->store('brands');}
        Brand::create(
            ['name'=>$request->name,
            'image'=>$path

        ]);
        toastr()->success("Added successfully");
            return redirect(route(('brands.index')));
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('brands.edit',compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        //
    }
}
