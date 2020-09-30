<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\CategoryTrait;
use DB;
use Illuminate\Support\Facades\App;

class categoriesController extends Controller
{
    use CategoryTrait;

    public function index()
    {

        $categories = Category::with('parentId')->paginate(PAGINATION_COUNT);
        return view('dashboard.categories.index', compact('categories'));


    }

    public function create()
    {
        try {

            $categories = Category::orderBy('id', 'DESC')->get();
            return view('dashboard.categories.create', compact('categories'));


        } catch (\Exception $ex) {
            return redirect()->route('admin.dashboard');
        }

    }

    public function store(MainCategoryRequest $request)
    {


//        try {

//            DB::beginTransaction();
            $this->checkStatus($request);
            if ($request->type == 1) //main category
            {
                $request->request->add(['parent_id' => null]);
            }

           $cat = Category::create($request->except('_token'));

//            DB::commit();
       $id = $cat->id;

            return redirect('/ar/admin/categories/edit/'.$id)->with(['success' => __('admin/messages.created')]);


//        } catch (\Exception $ex) {
//            DB::rollback();
//            return redirect()->route('admin.categories')->with(['error' => __('admin.messages.error')]);
//        }

    }

    public function edit($id)
    {


        $category = Category::orderBy('id', 'DESC')->find($id);
        $this->checkExists($category);
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('dashboard.categories.edit', compact('category', 'categories'));


    }

    public function update(MainCategoryRequest $request, $id)
    {
        try {

            DB::beginTransaction();
            $this->checkStatus($request);
            $category = Category::find($id);
            $this->checkExists($category);
            if ($request->type == 1) //main category
            {
                $request->request->add(['parent_id' => null ]);

            }
            $category->update($request->all());
            $category->name = $request->name;
            $category->save();
            DB::commit();
            return redirect()->route('admin.categories')->with(['success' => __('admin/messages.success')]);

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.categories')->with(['error' => __('admin/messages.error')]);
        }
    }

    public function delete($id)
    {
        try {

            $category = Category::find($id);
            $this->checkExists($category);
            $category->delete();
            return redirect()->route('admin.categories')->with(['success' => __('admin/messages.deleted')]);

        } catch (\Exception $ex) {
            return redirect()->route('admin.categories')->with(['error' => __('admin/messages.error')]);
        }

    }
}
