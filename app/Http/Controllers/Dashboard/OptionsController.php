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
        $options = Option::select('id','product_id','attribute_id','price')->paginate(PAGINATION_COUNT);
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
            return redirect()->route('admin.options')->with(['success'=>'Saved Successfully']);
        }catch (\Exception $ex){
            DB::rollback();
            return redirect()->route('admin.options')->with(['error' => 'somthing wrong']);
        }

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
