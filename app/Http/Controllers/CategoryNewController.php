<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryNewFormRequest;
use App\Models\CategoryNew;
use App\Models\News;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryNewController extends Controller
{
    public function index(Request $request)
    {
        $cateNew = CategoryNew::where('parent_id', 0)
            ->with('children')
            ->get();

        return view('admin.cateNew.index', compact('cateNew'));
    }

    public function isCheckbox(Request $request)
    {
        $category = CategoryNew::find($request->id);
        if ($category) {
            $field = $request->field;
            $value = $request->value;
            // Kiểm tra xem trường có tồn tại trong bảng user không
            if (in_array($field, ['is_menu', 'is_public'])) {
                $category->$field = $value;

                $category->save();
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Field does not exist.']);
            }
        }
        return response()->json(['success' => false]);
    }

    public function checkName(Request $request)
    {
        $name = $request->input('name');
        $slug = $request->input('slug');
        $id = $request->get('id');

        // Check if name exists, excluding the current category id
        // Kiểm tra xem tên có tồn tại không, ngoại trừ id danh mục hiện tại
        $nameExists = CategoryNew::where('name', $name)
            ->where('id', '!=', $id)
            ->exists();
        $slugExists = CategoryNew::where('slug', $slug)->exists() || News::where('slug', $slug)->exists();

        return response()->json([
            'name_exists' => $nameExists,
            'slug_exists' => $slugExists
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cateNewParents = CategoryNew::where('parent_id', 0)
            ->with('children')
            ->get();
        
        return view('admin.cateNew.create', compact('cateNewParents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryNewFormRequest $request)
    {
        $this->insertOrUpdate($request);

        return redirect(route('cateNews.index'))->with(['message' => 'Tạo mới danh mục bài viết thành công']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = CategoryNew::findOrFail($id);
        $categories = CategoryNew::with('children')->where('parent_id', 0)->get();
        // Lấy ra sản phẩm liên quan
        if (!empty($category->related_pro)) {
            $relatedPro = $category->getRelatedPro();

            return view('admin.cateNew.edit', compact('category', 'categories', 'relatedPro'));
        }
        
        return view('admin.cateNew.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryNewFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return back()->with(['message' => "Cập nhật danh mục bài viết thành công !"]);
    }

    public function insertOrUpdate(Request $request, $id = '')
    {
        $category = empty($id) ? new CategoryNew() : CategoryNew::findOrFail($id);

        if (!empty($request['related_pro'])) {
            $request['related_pro'] = json_encode($request->related_pro);
        }

        $category->fill($request->all());
        $category->stt_new = (isset($request->stt_new)) ? $request->stt_new : 999;
        $category->title_seo = (isset($request->title_seo)) ? $request->title_seo : $request->name;
        $category->keyword_seo = (isset($request->keyword_seo)) ? $request->keyword_seo : $request->name;
        $category->des_seo = (isset($request->des_seo)) ? $request->des_seo : $request->name;
        $category->user_id = Auth::id();

        $category->save();
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = CategoryNew::where('id', $id)->with('children')->first();
        $childIds = $category->getAllChildrenIds();
        $allCategoryIds = array_merge([$id], $childIds);
        News::whereIn('cate_id', $allCategoryIds)->delete();
        CategoryNew::whereIn('id', $allCategoryIds)->delete();

        return redirect(route('cateNews.index'))->with(['message' => 'Xóa thành công !']);
    }

    public function search(Request $request)
    {
        $related_pro = [];
        if ($search = $request->name) {
            $related_pro = Product::where('name', 'LIKE', "%$search%")->get();
        }
        return response()->json($related_pro);
    }

    public function checkStt(Request $request){
        $sttNew = $request->input('stt_new');
        if (!empty($sttNew)) {
            $request->validate([
                'stt_new' => 'integer|min:0'
            ]);
        }
        $id = $request->get('id');
        $category = CategoryNew::findOrFail($id);
        $category->stt_new = (isset($sttNew)) ? $sttNew : 999;
        $category->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật STT danh mục bài viết thành công.']);
    }
}
