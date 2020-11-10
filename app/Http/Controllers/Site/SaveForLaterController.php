<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class SaveForLaterController extends Controller
{


    public function switchToCart($id)
    {
        $item = Cart::instance('saveForLater')->get($id);
        Cart::instance('saveForLater')->remove($id);
        $duplicates = Cart::instance('inCart')->search(function($cartItem , $rowId) use ($item){
            return $cartItem->id === $item->id ;
        });
        if($duplicates->isNotEmpty()){
            return redirect()->route('cart.index')->with(['success'=>'Item is already in your Cart']);
        }
        Cart::instance('inCart')->add($item->id,$item->name,$item->qty,$item->price,[$item->options])->associate('App\Models\Product');
        return redirect()->route('cart.index')->with(['success'=>'Item has been moved to Cart']);

    }

    public function destroy($id)
    {
        Cart::instance('saveForLater')->remove($id);
        return back()->with(['success'=>'Item has been removed']);
    }
}
