<?php

namespace App\Http\Controllers;

use App\Models\HeaderTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HeaderTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyWord = $request->input('keyWord');
        // Khởi tạo query cho việc tìm kiếm
        $headerTag = HeaderTag::query();

        // Áp dụng tìm kiếm theo nội dung nếu có từ khóa
        if ($keyWord) {
            $headerTag->where('content', 'like', "%" . $keyWord . "%");
        }

        $headerTags = $headerTag->latest()->paginate(config('common.default_page_size'));

        return view('admin.headerTag.index', compact('headerTags', 'keyWord'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.headerTag.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->insertOrUpdate($request);

        return redirect(route('header-tags.index'))->with(['message' => 'Tạo mới thẻ tiếp thị thành công.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $headerTag = HeaderTag::findOrFail($id);
        
        return view('admin.headerTag.edit', compact('headerTag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return back()->with(['message' => "Cập nhật thành công thẻ tiếp thị !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        HeaderTag::findOrFail($id)->delete();

        return redirect('admin/header-tags')->with(['message' => 'Xóa thẻ tiếp thị thành công']);
    }

    public function insertOrUpdate(Request $request, $id = '')
    {
        $headertag = empty($id) ? new HeaderTag() : HeaderTag::findOrFail($id);

        $headertag->fill($request->all());
        $headertag->user_id = Auth::id();
        
        $headertag->save();
    }

    public function isCheckbox(Request $request)
    {
        $headerTag = HeaderTag::findOrFail($request->id);
        $headerTag->is_public = $request->is_public;
        $headerTag->save();

        return response()->json(['success' => true]);
    }
}
