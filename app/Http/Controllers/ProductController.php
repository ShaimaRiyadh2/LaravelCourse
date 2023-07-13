<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:access-products',['only'=>['index']]);
        $this->middleware('permission:create-products',['only'=>['create','store']]);
        $this->middleware('permission:update-products',['only'=>['edit','store']]);
        $this->middleware('permission:delete-products',['only'=>['destroy']]);


    }
    /**
     * Display a listing of the resource.
     */
    public function trash()
    {$products=Product::onlyTrashed()->paginate(20);
        $deleted=1;


        return view('products.index',compact('products','deleted'));

    }

    public function restore($id)
    {
        Product::onlyTrashed()->where('id',$id)->restore();
        toastr()->success('Restored successfully');
        return redirect(route('products.index'));


    }

    public function forceDelete($id)
    {
        Storage::delete($product->image);
        Product::onlyTrashed()->where('id',$id)->forceDelete();//or withTrashed
        toastr()->success('Deleted permanently successfully');
        return redirect(route('products.trash'));


    }




    public function index()
    {

        $products=Product::where('price','>','3')->orderBy('price','desc')->paginate(20);
        // $products=Product::all()->where('name','like','%Samsung%');//??
        // $products=Product::all()->whereNotBetween('price',[200,1000]);
        // $products=Product::all()->whereNotNull('desc');
        $deleted=0;

        return view('products.index',compact('products','deleted'));
        // $not=auth()->user()->notifications;
        // return dd($not);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::all();
        $brands=Brand::all();
        return view('products.create',compact('categories','brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //return dd($request);
        if($request->id >0){
        $product = Product::findOrFail($request->id);

    }
        $bath = "";
        if ($request->id > 0) {
            $bath = $product->image;
        }
        if ($request->hasFile('image'))
            $bath = $request->file('image')->store('products');


        $product = Product::updateOrCreate(
            [
                'id' => $request->id,

            ]
            , [
            'name' => $request->name,
            'desc' => $request->description,
            'image' => $bath,
            'brand_id' => $request->brand_id,
            'price' => $request->price,
            'status' => isset($request->status)
        ]);
        //return dd($product);

        if ($request->id > 0)
            toastr()->success('Updated successfully');
        else
            toastr()->success('Added successfully');
        return redirect(route('products.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories=Category::all();
        $brands=Brand::all();
        return view('products.create',compact('categories','brands','product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

        $product->deleted_by=auth()->id();
        $product->save();

        $product->delete();
        toastr()->success("Deleted successfully");
        return redirect(route(('products.index')));
    }
}
