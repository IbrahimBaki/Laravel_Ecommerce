<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        return view('site.cart');
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $duplicates = Cart::instance('inCart')->search(function ($cartItem,$rowId)use($request){

            return $cartItem->id === $request->id;
        });
        if($duplicates->isNotEmpty()){
            return redirect()->route('cart.index')->with(['success'=>'Item is already in Cart']);
        }

          Cart::instance('inCart')->add($request->id,$request->name,$request->num_product,$request->price,[$request->options])->associate('App\Models\Product');
        return redirect()->route('cart.index')->with(['success'=>'Item was added to your cart']);

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        Cart::instance('inCart')->remove($id);
        return back()->with(['success'=>'Item has been removed']);
    }

    public function switchToSaveForLater($id)
    {
        $item = Cart::instance('inCart')->get($id);
        Cart::instance('inCart')->remove($id);
        $duplicates = Cart::instance('saveForLater')->search(function($cartItem,$rowId) use ($item){
           return $cartItem->id = $item->id;
        });
        if($duplicates->isNotEmpty()){
            return redirect()->route('cart.index')->with(['success'=>'Item is already saved for later']);
        }
        Cart::instance('saveForLater')->add($item->id,$item->name,$item->qty,$item->price,[$item->options])->associate('App\Models\Product');
        return redirect()->route('cart.index')->with(['success'=>'Item has been saved for later']);
    }
}
