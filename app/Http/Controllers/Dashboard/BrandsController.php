<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Traits\CategoryTrait;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    use CategoryTrait;
    public function index()
    {
         $brands = Brand::orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.brands.index',compact('brands'));
    }

    public function create()
    {
        return view('dashboard.brands.create');
    }

    public function store(BrandRequest $request)
    {
        try{

            $this->checkStatus($request);

            $fileName = '';
            if($request->has('photo')){
                $fileName = uploadImage('brands',$request->photo);
            }
            $brand = Brand::create($request->except('_token','photo'));
            $brand->photo = $fileName;
            $brand ->save();
            return redirect()->route('admin.brands')->with(['success'=>__('admin/messages.brandCreated')]);

        }catch (\Exception $ex){
            return redirect()->route('admin.brands')->with(['error'=>__('admin/messages.error')]);

        }

    }
}
