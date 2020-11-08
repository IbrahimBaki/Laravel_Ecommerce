<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index()
    {
        $products = Product::with('images')->get();
        $parentCats = Category::parent()->get();
        $childCats = Category::child()->get();
        return view('site.products',compact('products','parentCats','childCats'));
    }

    public function show($slug)
    {
        $products = Product::with('images')->get();
        $product = Product::with('images')->where('slug',$slug)->firstOrFail();
        $catId = [];
        $optId = [];
        $attId = [];
        foreach($product->options as $options){
            array_push($optId,$options->id);
            array_push($attId,$options->attribute_id);
        }
        $options = Option::find($optId);
        $attributes = Attribute::find($attId);
        //return $options;

        foreach($product->categories as $category){
            array_push($catId,$category->pivot->category_id);
        }
        $categories = Category::find($catId);
        return view('site.product_details',compact('product','categories','products','options','attributes'));
    }

    public function ProductsOfCat($slug){

        $category = Category::with('products')->where('slug',$slug)->firstOrFail();
        $parentCats = Category::parent()->get();
        $childCats = Category::child()->get();
        //return $category;
        return view('site.products_of_category',compact('category','parentCats','childCats'));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
