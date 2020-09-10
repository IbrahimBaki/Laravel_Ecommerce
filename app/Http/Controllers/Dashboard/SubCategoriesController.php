<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\CategoryTrait;
use Illuminate\Support\Facades\DB;


class SubCategoriesController extends Controller
{
    use CategoryTrait;

    public function index()
    {
        $categories = Category::child()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);

        return view('dashboard.subcategories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::parent()->orderBy('id','DESC')->get();
        return view('dashboard.subcategories.create',compact('categories'));
    }

    public function store(SubCategoryRequest $request)
    {

        try {

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            Category::create($request->except('_token'));
            return redirect()->route('admin.subCategories')->with(['success' => __('admin/messages.created')]);



        } catch (\Exception $ex) {

            return redirect()->route('admin.subCategories')->with(['error' => __('admin.messages.error')]);
        }

    }

    public function edit($id)
    {
        $category = Category::orderBy('id', 'DESC')->find($id);
        if (!$category) {
            return redirect()->route('admin.subCategories')->with(['error' => __('admin/categories.error')]);
        }
        $categories = Category::parent()->orderBy('id','DESC')->get();
        return view('dashboard.subcategories.edit', compact('category','categories'));

    }

    public function update(SubCategoryRequest $request, $id)
    {
        try {

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category = Category::find($id);

            if (!$category)
                return redirect()->route('admin.subCategories')->with(['error' => __('admin/messages.missId')]);

            // $category->update(['slug' => $request->slug, 'name' => $request->name, 'is_active' => $request->is_active]);
            $category->update($request->all());

            return redirect()->route('admin.subCategories')->with(['success' => __('admin/messages.success')]);

        } catch (\Exception $ex) {
            return redirect()->route('admin.subCategories')->with(['error' => __('admin/messages.error')]);
        }
    }

    public function delete($id)
    {
        try {
            $category = Category::find($id);

            if (!$category)
                return redirect()->route('admin.subCategories')->with(['error' => __('admin/messages.missId')]);

            $category->delete();
            return redirect()->route('admin.subCategories')->with(['success' => __('admin/messages.deletedSuccess')]);

        } catch (\Exception $ex) {
            return redirect()->route('admin.subCategories')->with(['error' => __('admin/messages.error')]);
        }

    }
}
