<?php

namespace App\Traits;

use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;


trait ProductTrait {

    public function checkExists($product)
    {

        if (!$product)
            return redirect()->route('admin.products')->with(['error' => __('admin/csategories.error')]);


    }

    public function checkStatus( $request)
    {
        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => 1]);
    }
}
