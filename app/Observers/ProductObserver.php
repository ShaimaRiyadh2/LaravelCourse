<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Notifications\InvoicePaid;
use App\Notifications\GeneralNotification;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        ProductImage::create([

            'image'=>$product->image,
            'product_id'=>$product->id,
        ]);
        $product->categories()->sync(request()->categories);
        // auth()->user()->notify(new InvoicePaid());
        auth()->user()->notify(
            new GeneralNotification([
                'content'=>'The product '.$product->name.' was added by '.auth()->user()->name,
                'action_url'=>route('products.index'),
                'btn_text'=>'view product',
                'methods'=>['database','mail'],
                'image'=>$product->image,
            ])
            );



    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        $product->categories()->sync(request()->categories);

    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
