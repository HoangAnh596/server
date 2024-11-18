<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryFormRequest;
use App\Models\FilterCate;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $categoryParents = Category::where('parent_id', 0)
            ->with('children')
            ->get();
        
        $categoryParents->each(function ($category) {
            if ($category->filter_ids) {
                $filterIds = json_decode($category->filter_ids); // Nếu filter_ids là JSON
                $filters = FilterCate::whereIn('id', $filterIds)->select('id', 'name')->get();
                $category->filter_names = $filters;
            }
        });

        return view('admin.category.index', compact('categoryParents'));
    }

    public function isCheckbox(Request $request)
    {
        $category = Category::find($request->id);
        if ($category) {
            $field = $request->field;
            $value = $request->value;
            // Kiểm tra xem trường có tồn tại trong bảng user không
            if (in_array($field, ['is_serve', 'is_parent', 'is_menu', 'is_outstand', 'is_public'])) {
                $category->$field = $value;

                $category->save();
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Không tồn tại.']);
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
        $nameExists = Category::where('name', $name)
            ->where('id', '!=', $id)
            ->exists();
        $slugExists = Category::where('slug', $slug)->exists() || Product::where('slug', $slug)->exists();

        return response()->json([
            'name_exists' => $nameExists,
            'slug_exists' => $slugExists,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryParents = Category::where('parent_id', 0)
            ->with('children')
            ->get();

        return view('admin.category.create', compact('categoryParents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryFormRequest $request)
    {
        $this->insertOrUpdate($request);

        return redirect(route('categories.index'))->with(['message' => 'Tạo mới thành công']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::where('id', $id)->with('children')->first();

        return view('admin.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::with('children')->where('parent_id', 0)->get();

        return view('admin.category.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return back()->with(['message' => "Cập nhật danh mục thành công !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Lấy tất cả các sản phẩm có chứa danh mục trong trường sub
        $products = Product::whereJsonContains('subCategory', $id)->get();

        foreach ($products as $product) {
            // Lấy danh sách sub hiện tại
            $sub = $product->subCategory;

            // Loại bỏ ID danh mục khỏi danh sách sub
            $updatedSub = array_filter($sub, function ($value) use ($id) {
                return $value != $id;
            });

            // Cập nhật lại trường sub với danh sách mới
            $product->subCategory = array_values($updatedSub); // Sử dụng array_values để đánh chỉ mục lại cho mảng
            $product->save();
        }
        Category::findOrFail($id)->delete();

        return redirect(route('categories.index'))->with(['message' => 'Xóa thành công danh mục sản phẩm!']);
    }

    public function insertOrUpdate(CategoryFormRequest $request, $id = '')
    {
        $category = empty($id) ? new Category() : Category::findOrFail($id);

        $category->fill($request->all());
        $path = parse_url($request->filepath, PHP_URL_PATH);
        // Xóa dấu gạch chéo đầu tiên nếu cần thiết
        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }

        $category->image = $path;

        $category->title_img = (isset($request->title_img)) ? $request->title_img : $request->name;
        $category->alt_img = (isset($request->alt_img)) ? $request->alt_img : $request->name;
        $category->title_seo = (isset($request->title_seo)) ? $request->title_seo : $request->name;
        $category->keyword_seo = (isset($request->keyword_seo)) ? $request->keyword_seo : $request->name;
        $category->des_seo = (isset($request->des_seo)) ? $request->des_seo : $request->name;
        $category->stt_cate = (isset($request->stt_cate)) ? $request->stt_cate : 999;
        $category->user_id = Auth::id();

        $category->save();
    }

    // Nhân bản
    public function duplicateCategory($id)
    {
        Category::findOrFail($id)->cloneCategory($id);

        return redirect()->back()->with('message', 'Danh mục đã được nhân bản thành công!');
    }

    public function checkStt(Request $request)
    {
        $sttCate = $request->input('stt_cate');
        if (!empty($sttCate)) {
            $request->validate([
                'stt_cate' => 'integer|min:0'
            ]);
        }
        $id = $request->get('id');
        $category = Category::findOrFail($id);
        $category->stt_cate = (isset($sttCate)) ? $sttCate : 999;
        $category->save();

        return response()->json(['success' => true, 'message' => 'STT updated successfully.']);
    }

    public function getSlugs()
    {
        $slugs = Category::pluck('slug')->toArray();
        return response()->json($slugs);
    }
}
