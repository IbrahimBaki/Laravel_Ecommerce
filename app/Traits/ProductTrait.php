<?php

namespace App\Traits;

use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;


trait ProductTrait {

    public function checkExists($category)
    {

        if (!$category)
            return redirect()->route('admin.mainCategories', compact('type'))->with(['error' => __('admin/categories.error')]);


    }

    public function checkStatus( $request)
    {
        if (!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => 1]);
    }
}
