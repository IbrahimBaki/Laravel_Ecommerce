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
        $items =   Cart::add($request->id,$request->name,$request->num_product,$request->price,[$request->options])->associate('App\Models\Product');
       // return $items;
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
        Cart::remove($id);

        return back()->with(['success'=>'Item has been removed']);
    }
}
