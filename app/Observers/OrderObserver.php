<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Product;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        if($order->isDirty('status_livraison_id')){
            // email has changed
            if($order->getOriginal('status_livraison_id') == 1 && $order->status_livraison_id != 2 && $order->status_livraison_id != 6){
                $produit = $order->product;
                $produit->quantity = $produit->quantity + $order->quantity;
                $produit->save();
            }

            if($order->status_livraison_id === 1){
                $produit = $order->product;
                $produit->quantity -= $order->quantity;
                $produit->save();
            }



        }
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
