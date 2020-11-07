<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Image;
use App\Models\Option;
use App\Models\Product;
use Illuminate\Http\Request;
use function Clue\StreamFilter\append;

class StoreController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $images = Image::all();
        return view('site.home',compact('products','images'));

    }


    public function allProducts()
    {

        $products = Product::with('images')->get();
        $parentCats = Category::parent()->get();
        $childCats = Category::child()->get();
        return view('site.products',compact('products','parentCats','childCats'));

    }



    public function productDetails($id)
    {
        $products = Product::with('images')->get();
        $product = Product::with('images')->find($id);
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

    public function ProductsOfCat($id)
    {
        $category = Category::with('products')->find($id);
        $parentCats = Category::parent()->get();
        $childCats = Category::child()->get();

        //return $category;
        return view('site.products_of_category',compact('category','parentCats','childCats'));



    }


}
