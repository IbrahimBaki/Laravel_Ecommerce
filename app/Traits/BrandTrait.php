<?php

namespace App\Traits;

use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;


trait BrandTrait {

    public function checkExists($brand)
    {

        if(!$brand)
            return redirect()->route('admin.brands')->with(['error' => __('admin/messages.error')]);


    }

    public function checkStatus( $request)
    {
        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => 1]);
    }
}
