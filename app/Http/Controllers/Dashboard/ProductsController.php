<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralProductRequest;
use App\Http\Requests\MainCategoryRequest;
use App\Http\Requests\PriceProductRequest;
use App\Http\Requests\StockProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Traits\ProductTrait;
use Illuminate\Http\Request;
use DB;

class ProductsController extends Controller
{
    use ProductTrait;

    public function index()
    {
        $products = Product::select('id','slug','price','created_at')->paginate(10);
        return view('dashboard.products.general.index',compact('products'));


    }

    public function create()
    {
        $data = [
            'brands' => Brand::active()->select('id')->get(),
            'tags'   => Tag::select('id')->get(),
            'categories'   => Category::active()->select('id')->get(),
        ];

        return view('dashboard.products.general.create',compact('data'));

    }

    public function store(GeneralProductRequest $request)
    {


       try {


            DB::beginTransaction();
        $this->checkStatus($request);
    //Save main table
        $products = Product::create([
            'brand_id'=>$request->brand_id,
            'slug'=>$request->slug,
            'is_active'=>$request->is_active,
        ]);
        // Save Translations
        $products->name = $request->name;
        $products->description = $request->description;
        $products->short_description = $request->short_description;
        $products->save();

        //Save Product Categories
           $products->categories()->attach($request->categories);

        //Save Product Tags
           $products->tags()->attach($request->tags);
            $id = $products->id;
            $product = $products;

            DB::commit();
        return redirect()->route('admin.products.price',compact('id','product'))->with(['success' => __('admin/messages.created')]);


        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.categories')->with(['error' => __('admin.messages.error')]);
        }


    }






    public function getPrice($id)
    {
        return view('dashboard.products.prices.create',compact('id'));


    }

    public function savePrice(PriceProductRequest $request)
    {
        try {
            $product = Product::find($request->id);
            $product->update($request->except('id','_token'));
            $id = $request->id;
            return view('dashboard.products.stock.create',compact('id','product'))->with(['success'=>__('admin/messages.created')]);

        }catch(\Exception $ex){
            return redirect()->back()->with(['error'=>__('admin.messages.error')]);
        }
    }




    public function getStock($id)
    {
        return view('dashboard.products.stock.create',compact('id'));
    }
    public function saveStock(StockProductRequest $request)
    {
        try {
            $product = Product::find($request->id);
            $product->update($request->except('id','_token'));
            $id = $request->id;
            return view('dashboard.products.stock.create',compact('id','product'))->with(['success'=>__('admin/messages.created')]);

        }catch(\Exception $ex){
            return redirect()->back()->with(['error'=>__('admin.messages.error')]);
        }

    }






    public function edit($id)
    {
        $product = Product::find($id);

        $this->checkExists($product);
        $data = [
            'brands' => Brand::active()->select('id')->get(),
            'tags'   => Tag::select('id')->get(),
            'categories'   => Category::active()->select('id')->get(),
        ];
        return view('dashboard.products.general.edit', compact('product', 'data'));
    }

    public function editPrice($id)
    {
        $product = Product::find($id);
        $this->checkExists($product);
        return view('dashboard.products.prices.create', compact('product','id'));
    }

    public function editStock($id)
    {
        $product = Product::find($id);
        $this->checkExists($product);
        return view('dashboard.products.stock.create', compact('product','id'));
    }

    public function update(GeneralProductRequest $request, $id)
    {
//        try {

            $product = Product::find($id);
            DB::beginTransaction();
            $this->checkStatus($request);
            //Save main table
            $product ->update([
                'brand_id'=>$request->brand_id,
                'slug'=>$request->slug,
                'is_active'=>$request->is_active,
            ]);
            // Save Translations
            $product->name = $request->name;
            $product->description = $request->description;
            $product->short_description = $request->short_description;
            $product->save();

            //Save Product Categories
            $product->categories()->sync($request->categories);

            //Save Product Tags
            $product->tags()->sync($request->tags);
            DB::commit();
            return view('dashboard.products.prices.create',compact('id','product'))->with(['success'=>__('admin/messages.created')]);


//        } catch (\Exception $ex) {
//            DB::rollback();
//            return redirect()->route('admin.products')->with(['error' => __('admin.messages.error')]);
//        }
    }

    public function delete($id)
    {
        try {

            $category = Category::find($id);
            $this->checkExists($category);
            $category->delete();
            return redirect()->route('admin.categories')->with(['success' => __('admin/messages.deleted')]);

        } catch (\Exception $ex) {
            return redirect()->route('admin.categories')->with(['error' => __('admin/messages.error')]);
        }

    }
}
