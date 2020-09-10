<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\CategoryTrait;
use DB;

class MainCategoriesController extends Controller
{
    use CategoryTrait;

    public function index($type)
    {
        if ($type === 'main_category') {
            $categories = Category::parent()->paginate(PAGINATION_COUNT);
            return view('dashboard.categories.index', compact('categories', 'type'));
        } elseif ($type === 'sub_category') {
            $categories = Category::child()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
            return view('dashboard.categories.index', compact('categories', 'type'));
        } else {
            return redirect()->route('admin.dashboard');
        }

    }

    public function create($type)
    {
        try {
            if ($type === 'main_category') {
                return view('dashboard.categories.create', compact('type'));
            }
            if ($type === 'sub_category') {
                $categories = Category::parent()->orderBy('id', 'DESC')->get();
                return view('dashboard.categories.create', compact('categories', 'type'));
            }

        } catch (\Exception $ex) {
            return redirect()->route('admin.dashboard');
        }

    }

    public function store(MainCategoryRequest $request, $type)
    {




        try {


            $this->checkStatus($request);

            if ($type === 'main_category') {
                $category = Category::create($request->except('_token'));
                $category->name = $request->name;
                $category->save();
                return redirect()->route('admin.mainCategories', compact('type'))->with(['success' => __('admin/messages.created')]);
            }
            if ($type === 'sub_category') {
                Category::create($request->except('_token'));
                return redirect()->route('admin.mainCategories', compact('type'))->with(['success' => __('admin/messages.created')]);
            }

        } catch (\Exception $ex) {
            return redirect()->route('admin.mainCategories', compact('type'))->with(['error' => __('admin.messages.error')]);
        }

    }

    public function edit($type, $id)
    {
        if ($type === 'main_category') {
            $category = Category::orderBy('id', 'DESC')->find($id);
            $this->checkExists($category);
            return view('dashboard.categories.edit', compact('category', 'type'));

        }

        if ($type === 'sub_category') {
            $category = Category::orderBy('id', 'DESC')->find($id);
            $this->checkExists($category);
            $categories = Category::parent()->orderBy('id', 'DESC')->get();
            return view('dashboard.categories.edit', compact('category', 'categories', 'type'));
        }


    }

    public function update(MainCategoryRequest $request, $type, $id)
    {
        try {
            $this->checkStatus($request);
            if ($type === 'main_category') {
                $category = Category::find($id);
                $this->checkExists($category);
                $category->update($request->all());
                return redirect()->route('admin.mainCategories', compact('type'))->with(['success' => __('admin/messages.success')]);
            }
            if ($type === 'sub_category') {
                $category = Category::find($id);
                $this->checkExists($category);
                $category->update($request->all());
                return redirect()->route('admin.mainCategories', compact('type'))->with(['success' => __('admin/messages.success')]);
            }
        } catch (\Exception $ex) {
            return redirect()->route('admin.mainCategories', compact('type'))->with(['error' => __('admin/messages.error')]);
        }
    }

    public function delete($type, $id)
    {
        try {

                $category = Category::find($id);
                $this->checkExists($category);
                $category->delete();
                return redirect()->route('admin.mainCategories',compact('type'))->with(['success' => __('admin/messages.deletedSuccess')]);

        } catch (\Exception $ex) {
            return redirect()->route('admin.mainCategories')->with(['error' => __('admin/messages.error')]);
        }

    }
}
