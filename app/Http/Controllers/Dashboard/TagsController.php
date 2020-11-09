<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagsRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagsController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('id', 'DESC')->paginate(10);
        return view('dashboard.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('dashboard.tags.create');
    }

    public function store(TagsRequest $request)
    {
        try {
            DB::beginTransaction();
            Tag::create($request->except('_token'));
            DB::commit();
            return redirect()->route('admin.tags')->with(['success' => __('admin/messages.created')]);
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.tags')->with(['error' => __('admin/messages.error')]);

        }


    }

    public function edit($id)
    {
        $tags = Tag::find($id);
        if (!$tags)
            return redirect()->route('admin.tags')->with(['error' => __('admin/messages.error')]);
        return view('dashboard.tags.edit', compact('tags'));

    }

    public function update(TagsRequest $request, $id)
    {
        $tags = Tag::find($id);
        if (!$tags)
            return redirect()->route('admin.tags')->with(['error' => __('admin/messages.error')]);

        $tags->update(['slug'=>$request->slug]);
        $tags->name = $request->name;
        $tags->save();
        return redirect()->route('admin.tags')->with(['success' => __('admin/messages.success')]);

    }

    public function delete($id)
    {
        $tags = Tag::find($id);
        if (!$tags)
            return redirect()->route('admin.tags')->with(['error' => __('admin/messages.error')]);
        $tags->delete();
        return redirect()->route('admin.tags')->with(['success' => __('admin/messages.deleted')]);
    }

}
