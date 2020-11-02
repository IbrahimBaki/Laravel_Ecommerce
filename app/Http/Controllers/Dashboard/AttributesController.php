<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributesController extends Controller
{
    public function index()
    {
        $attributes = Attribute::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('dashboard.attributes.create');
    }

    public function store(AttributeRequest $request)
    {
        try {



            $attributes = Attribute::create([]);


            $attributes->name = $request->name;
            $attributes->save();
            return redirect()->route('admin.attributes')->with(['success' => __('admin/messages.brandCreated')]);

        } catch (\Exception $ex) {
            return redirect()->route('admin.attributes')->with(['error' => __('admin/messages.error')]);
        }
    }

    public function edit($id)
    {

        $attributes = Attribute::find($id);
        if(!$attributes)
            return redirect()->route('admin.attributes')->with(['error' => __('admin/messages.error')]);

            return view('dashboard.attributes.edit',compact('attributes'));
    }

    public function update(AttributeRequest $request ,$id)
    {
        try{
            $attributes = Attribute::find($id);
            if(!$attributes)
                return redirect()->route('admin.attributes')->with(['error' => __('admin/messages.error')]);
            DB::beginTransaction();
            $attributes->update([
                'name' => $request->name,
            ]);
            DB::commit();
            return redirect()->route('admin.attributes')->with(['success' => __('admin/messages.success')]);
        }catch (\Exception $ex){
            DB::rollback();
            return redirect()->route('admin.attributes')->with(['error' => __('admin/messages.error')]);

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
