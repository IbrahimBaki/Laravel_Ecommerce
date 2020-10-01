<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralProductRequest;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Traits\ProductTrait;
use DB;

class ProductsController extends Controller
{
    use ProductTrait;

    public function index()
    {
        $products = Product::select('id','slug','price','created_at')->paginate(PAGINATION_COUNT);
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
        $product = Product::create([
            'brand_id'=>$request->brand_id,
            'slug'=>$request->slug,
            'is_active'=>$request->is_active,
        ]);
        // Save Translations
        $product->name = $request->name;
        $product->description = $request->name;
        $product->short_description = $request->name;
        $product->save();

        //Save Product Categories
           $product->categories()->attach($request->categories);

        //Save Product Tags
           $product->tags()->attach($request->tags);

            DB::commit();

        return redirect()->back()->with(['success' => __('admin/messages.created')]);


        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.categories')->with(['error' => __('admin.messages.error')]);
        }


    }

    public function edit($id)
    {


        $category = Category::orderBy('id', 'DESC')->find($id);
        $this->checkExists($category);
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('dashboard.categories.edit', compact('category', 'categories'));


    }

    public function update(MainCategoryRequest $request, $id)
    {
        try {

            DB::beginTransaction();
            $this->checkStatus($request);
            $category = Category::find($id);
            $this->checkExists($category);
            if ($request->type == 1) //main category
            {
                $request->request->add(['parent_id' => null]);

            }
            $category->update($request->all());
            $category->name = $request->name;
            $category->save();
            DB::commit();
            return redirect()->route('admin.categories')->with(['success' => __('admin/messages.success')]);

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.categories')->with(['error' => __('admin/messages.error')]);
        }
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
