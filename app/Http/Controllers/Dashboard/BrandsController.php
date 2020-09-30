<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Traits\BrandTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandsController extends Controller
{
    use BrandTrait;

    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('dashboard.brands.create');
    }

    public function store(BrandRequest $request)
    {
        try {

            $this->checkStatus($request);

            $fileName = '';
            if ($request->has('photo')) {
                $fileName = uploadImage('brands', $request->photo);
            }
            $brand = Brand::create($request->except('_token', 'photo'));
            $brand->photo = $fileName;
            $brand->save();
            return redirect()->route('admin.brands')->with(['success' => __('admin/messages.brandCreated')]);

        } catch (\Exception $ex) {
            return redirect()->route('admin.brands')->with(['error' => __('admin/messages.error')]);
        }
    }

    public function edit($id)
    {

            $brands = Brand::find($id);
           $this->checkExists($brands);
            return view('dashboard.brands.edit',compact('brands'));



    }

    public function update(BrandRequest $request ,$id)
    {
        try{
            $brands = Brand::find($id);
            $this->checkExists($brands);
            DB::beginTransaction();
            $this->checkStatus($request);
            if ($request->has('photo')) {
                $fileName = uploadImage('brands', $request->photo);
                Brand::where('id',$id)->update([
                    'photo' => $fileName
                ]);
            }
            $brands->update($request ->except('_token','id','photo'));
            DB::commit();
            return redirect()->route('admin.brands')->with(['success' => __('admin/messages.success')]);
        }catch (\Exception $ex){
            DB::rollback();
            return redirect()->route('admin.brands')->with(['error' => __('admin/messages.error')]);

        }

    }

    public function delete($id)
    {
        try{
            $brand = Brand::find($id);
            $this->checkExists($brand);

            $brand->translations()->delete();
            $brand->delete();
            return redirect()->route('admin.brands')->with(['success' => __('admin/messages.deleted')]);

        }Catch(\Exception $ex){
            return redirect()->route('admin.brands')->with(['error' => __('admin/messages.error')]);

        }

    }
}
