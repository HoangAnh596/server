<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Http\Requests\NewFormRequest;
use App\Models\CategoryNew;
use App\Models\CmtNew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $categoryId = $request->cateNew;

        $newsQuery = News::where('name', 'like', "%" . $keyword . "%")
            ->orWhere('slug', 'like', "%" . $keyword . "%");
        // Nếu có danh mục được chọn, thêm điều kiện lọc theo danh mục
        if ($categoryId) {
            $newsQuery->where('cate_id', $categoryId);
        }
        $news = $newsQuery->latest()->paginate(config('common.default_page_size'))->appends($request->except('page'));
        $categories = CategoryNew::where('parent_id', 0)
        ->with('children')
        ->get();


        return view('admin.news.index', compact('news', 'keyword', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = CategoryNew::where('parent_id', 0)
            ->with('children')
            ->get();
        
        return view('admin.news.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewFormRequest $request)
    {
        $this->insertOrUpdate($request);

        return redirect(route('news.index'))->with(['message' => 'Tạo mới thành công']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $new = News::findOrFail($id);
        $categories = CategoryNew::with('children')->where('parent_id', 0)->get();
        
        return view('admin.news.edit', compact('new', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return back()->with(['message' => "Cập nhật tin tức thành công !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Xóa comment
        CmtNew::where('new_id', $id)->delete();

        News::findOrFail($id)->delete();

        return redirect()->route('news.index')->with(['message' => 'Xóa bài viết thành công !']);
    }

    public function insertOrUpdate(Request $request, $id = '')
    {
        $new = empty($id) ? new News() : News::findOrFail($id);

        $path = parse_url($request->filepath, PHP_URL_PATH);
        // Xóa dấu gạch chéo đầu tiên nếu cần thiết
        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }

        $new->fill($request->all());
        $new->image = $path;
        $new->title_img = (isset($request->title_img)) ? $request->title_img : $request->name;
        $new->alt_img = (isset($request->alt_img)) ? $request->alt_img : $request->name;

        $new->title_seo = (isset($request->title_seo)) ? $request->title_seo : $request->name;
        $new->keyword_seo = (isset($request->keyword_seo)) ? $request->keyword_seo : $request->name;
        $new->des_seo = (isset($request->des_seo)) ? $request->des_seo : $request->name;
        $new->user_id = Auth::id();

        $new->save();
    }

    public function isCheckbox(Request $request)
    {
        $new = News::findOrFail($request->id);
        $new->is_outstand = $request->is_outstand;
        $new->save();

        return response()->json(['success' => true]);
    }

    public function checkName(Request $request)
    {
        $name = $request->input('name');
        $slug = $request->input('slug');
        $id = $request->get('id');

        // Check if name exists, excluding the current new id
        // Kiểm tra xem tên có tồn tại không, ngoại trừ id danh mục hiện tại
        $nameExists = News::where('name', $name)
            ->where('id', '!=', $id)
            ->exists();
        $slugExists = CategoryNew::where('slug', $slug)->exists() || News::where('slug', $slug)->exists();

        return response()->json([
            'name_exists' => $nameExists,
            'slug_exists' => $slugExists
        ]);
    }
}
