<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\OptionRequest;
use App\Models\Attribute;
use App\Models\Option;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OptionsController extends Controller
{
    public function index()
    {
        $options = Option::select('id','product_id','attribute_id','price')->paginate(10);
        return view('dashboard.options.index',compact('options'));

    }

    public function create()
    {
        $data = [
            'products' => Product::active()->select('id')->get(),
            'attributes'   => Attribute::select('id')->get(),
        ];

        return view('dashboard.options.create',compact('data'));
    }

    public function store(OptionRequest $request)
    {
        try{
            DB::beginTransaction();
            $option = Option::create([
                'attribute_id' => $request->attribute,
                'product_id' => $request->product,
                'price' => $request->price,
            ]);
            $option->name = $request->name;
            $option->save();
            DB::commit();
            return redirect()->route('admin.options.create')->with(['success'=>'Saved Successfully']);
        }catch (\Exception $ex){
            DB::rollback();
            return redirect()->route('admin.options')->with(['error' => 'somthing wrong']);
        }

    }

    public function edit($id)
    {
        $data = [
            'products' => Product::active()->select('id')->get(),
            'attributes'   => Attribute::select('id')->get(),
        ];

        $option = Option::find($id);
        if(!isset($option))
            return redirect()->route('admin.options')->with(['error'=>'unknown option']);

        return view('dashboard.options.edit',compact('data','option'));

    }

    public function update(OptionRequest $request , $id)
    {

        $option = Option::find($id);
        if(!isset($option))
            return redirect()->route('admin.options')->with(['error'=>'unknown option']);

        $option->update([
           // $request->except('_token')
            'name'=>$request->name,
            'price'=>$request->price,
            'product_id'=>$request->product,
            'attribute_id'=>$request->attribute,
        ]);
        $option->name = $request->name;
        $option->save();

        return redirect()->route('admin.options')->with(['success'=>'Updated Successfully']);

    }

    public function delete()
    {

    }
}
