<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralProductRequest;
use App\Http\Requests\ImageProductRequest;
use App\Http\Requests\PriceProductRequest;
use App\Http\Requests\StockProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Tag;
use App\Traits\ProductTrait;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    use ProductTrait;

    public function index()
    {
        $products = Product::select('id','slug','price','created_at')->paginate(10);
        return view('dashboard.products.index',compact('products'));


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
        //try {
            $product = Product::find($request->id);
            $product->update($request->except('id','_token'));
            $id = $request->id;
            return view('dashboard.products.images.create',compact('id','product'))->with(['success'=>__('admin/messages.created')]);

//        }catch(\Exception $ex){
//            return redirect()->back()->with(['error'=>__('admin.messages.error')]);
//        }

    }


    public function addImages($id)
    {
        // Delete disk images not found in db
//        foreach($images as $image){
//            $db_image = $image->photo;
//            foreach (Storage::disk('products')->allFiles() as $img){
//                $st_img =
//                if($st_img != $db_image){
//                    Storage::disk('products')->delete($st_img);
//                }else{
//                    return true;
//                }
//            }
//    }
        return view('dashboard.products.images.create',compact('id'));
    }

//save Image to folder
    public function saveImagesToFolder(Request $request)
    {
        $file = $request->file('dzfile');
        $fileName = uploadImage('products',$file);

        return response()->json([
            'name' => $fileName,
            'original_name'=> $file->getClientOriginalName(),
        ]);
    }

    public function saveImagesToDB(ImageProductRequest $request)
    {

//        try{
            //save dropzone images to db
            if($request->has('document') && count($request->document) > 0 ){
                foreach($request->document as $image){
                    Image::create([
                        'imageable_id'=>$request->product_id,
                        'imageable_type'=>'App\Models\Products',
                        'photo'=>$image,
                    ]);
                }
            }

            return redirect()->route('admin.options.create')->with(['success'=>'تم التحديث بنجاح']);

//        }catch (\Exception $ex){
//            return redirect()->route('admin.products')->with(['error'=>'هناك خطأ ما']);
//        }

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

    public function editImage($id)
    {
        $product = Product::find($id);
        $this->checkExists($product);
        return view('dashboard.products.images.create', compact('product','id'));
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

    public function destroy($id)
    {
        $currentImage = Image::findOrFail($id);

        //validation to make sure that none can delete images except the person who upload them
        if($currentImage->created_by != Auth::user()->id){ // created_by is founded in db
            abort('403','You are not allowed to delete this Images');
        }

        $images = $currentImage->images();
        foreach ($currentImage->images as $image){
            unlink(public_path($image->file_path)); // file_path is the directory of an images
        }
        $currentImage->images()->delete();
        $currentImage->delete();

        return redirect()->back();
    }

    public function imgDelete($id)
    {
        $image = Image::find($id);
        $this->checkExists($image);
        Storage::disk('products')->delete($image->photo);
        $image->delete();
        return view('admin.products');



    }
}
