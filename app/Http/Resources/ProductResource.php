<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return[
        'id'=>$this->id,
        'name'=>$this->name,
        'brand'=>new BrandResource($this->brand),//1-1
        'categories'=>CategoryResource::collection($this->categories),//m-m
        'price'=>$this->price,
        'discount'=>"50%",
        'price_after_discount'=>$this->price*(.5)



       ];

       if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors());
    }
    }
}
