<?php

namespace App\Http\Controllers\api;

use Validator;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class ProductController extends BaseAPIController
{
    //
    public  function  index()
    {
    //     $products=Product::all();

    //    return (ProductResource::collection($products));
    $products=Product::paginate(3);
    return($products);
    }

    public function store(Request $request){
        if(!auth()->user()->can('create-products'))
            return $this->sendError('Unauthorized');

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price'=>'required|numeric',
            'categories' => "nullable|array",
            'categories.*' => "required|exists:categories,id",
            'brand_id'=>'required|numeric|exists:brands,id',
            "image"=>[request()->id>0?"nullable":"required","image","max:51120"]]);


            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $bath = "";

            if ($request->hasFile('image'))
                $bath = $request->file('image')->store('products');

                $product = Product::create(
                 [
                    'name' => $request->name,
                    'user_id'=>auth()->id(),
                    'desc' => $request->description,
                    'image' => $bath,
                    'brand_id' => $request->brand_id,
                    'price' => $request->price,
                    'status' => isset($request->status)
                ]);
                $product->categories()->sync($request->categories);
               // $product = Product::create($input);
                return $this->sendResponse(new ProductResource($product));





        }
}
