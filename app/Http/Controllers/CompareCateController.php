<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Compare;
use App\Models\CompareCate;
use Illuminate\Http\Request;

class CompareCateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $compareId = $request->cate;
        $compare = CompareCate::where(function ($query) use ($keyword) {
            $query->where('name', 'like', "%" . $keyword . "%");
        })->when($compareId, function ($query) use ($compareId) {
            $query->where('cate_id',$compareId);
        });
    
        $compare = $compare->latest()->paginate(config('common.default_page_size'))->appends($request->except('page'));
        $categories = Category::where('parent_id',0)->get();

        return view('admin.compare.index', compact('compare', 'keyword', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $idCate = $request->cate_id;
        $categories = Category::with('children')->where('parent_id', 0)->get();

        return view('admin.compare.create', compact('idCate', 'categories'));
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

        return redirect(route('categories.index'))->with(['message' => 'Tạo mới bộ lọc thành công']);
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
        $compare = CompareCate::findOrFail($id);
        // Lấy danh sách các bản ghi liên quan và sắp xếp theo created_at mới nhất
        $items = $compare->valueCompares()->orderBy('created_at', 'desc')->get();
        
        $categories = Category::with('children')->where('parent_id', 0)->get();

        return view('admin.compare.edit', compact('categories', 'compare', 'items'));
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

        return back()->with(['message' => "Danh mục đã cập nhật thành công !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $compare = CompareCate::findOrFail($id);
            // $compareId = $compare->id;
            dd($compare);
            $compare->delete();
            
            return response()->json(['success' => 'Xóa thành công']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Có lỗi xảy ra, vui lòng thử lại.'], 500);
        }
    }
    public function destroyCate($id)
    {
        try {
            $compare = CompareCate::findOrFail($id); // $compare->id = 4
            // $compare->delete();
            // Cập nhật trường `compare_ids` trong bảng `categories`
            $compareId = $compare->id;
            // Cập nhật trường `compare_ids` trong bảng `categories`
            Category::query()->each(function ($category) use ($compareId) {
                // Kiểm tra nếu trường `compare_ids` có giá trị không
                if ($category->compare_ids) {
                    // Chuyển đổi giá trị `compare_ids` từ JSON sang mảng
                    $compareIds = json_decode($category->compare_ids, true);

                    // Kiểm tra nếu decode thành công và là mảng
                    if (is_array($compareIds)) {
                        // Loại bỏ giá trị `compareId` từ mảng
                        $compareIds = array_filter($compareIds, function ($id) use ($compareId) {
                            return $id != $compareId;
                        });

                        // Cập nhật lại giá trị `compare_ids`
                        $category->compare_ids = json_encode(array_values($compareIds));
                        $category->save();
                    }
                }
            });

            // Xóa bản ghi trong bảng Compare có trường compare_cate_id = $compareId
            Compare::where('compare_cate_id', $compareId)->delete();
            // CompareProduct::where('compare_cate_id', $compareId)->delete();

            return response()->json(['success' => 'Xóa thành công']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Có lỗi xảy ra, vui lòng thử lại.'], 500);
        }
    }

    public function insertOrUpdate(Request $request, $id = '')
    {
        $compare = empty($id) ? new CompareCate() : CompareCate::findOrFail($id);
        
        $compare->fill($request->all());
        $compare->stt_compare = (isset($request->stt_compare)) ? $request->stt_compare : 999;
        $parentId = Category::find($request->cate_id)->topLevelParent();
        $idCategory = $parentId->id;
        $compare->cate_id = $idCategory;

        $compare->save();
        
        $compareIds = [];
        
        if (!empty($compare->id)) {
            $compareIds[] = $compare->id;
            // Tìm danh mục cụ thể
            $checkCate = Category::where('id', $idCategory);
            $checkCompareCate = $checkCate->value('compare_ids');
            $cate = Category::findOrFail($idCategory);
            // Danh mục chưa có compare_ids tồn tại
            if (empty($checkCompareCate)) {
                $cate->update([
                    $cate['compare_ids'] = json_encode(array_map('strval', $compareIds)),
                ]);
            }
            if (!empty($checkCompareCate)) {
                $arr_current = $checkCompareCate;
                // Danh mục đã tồn tại compare_ids
                $arr_new = $compareIds;
                $arr = array_unique(array_merge(json_decode($arr_current), array_map('strval', $arr_new)));
                $cate->update([
                    $cate->compare_ids = json_encode($arr),
                ]);
            }
        }

        $data = $request->only(['key_word']);

        if (!empty($compare->id) && !empty($request->key_word)) {
            // Lặp qua các phần tử key_word và lưu vào bảng compare
            foreach ($data['key_word'] as $key_word) {
                Compare::create([
                    'compare_cate_id' => $compare->id,
                    'key_word' => $key_word
                ]);
            }
        }
    }

    public function checkName(Request $request)
    {
        $name = $request->input('name');
        $id = $request->get('id');

        // Kiểm tra xem tên có tồn tại không, ngoại trừ id danh mục hiện tại
        $nameExists = CompareCate::where('name', $name)
            ->where('id', '!=', $id)
            ->exists();
        
        return response()->json([
            'name_exists' => $nameExists,
        ]);
    }

    public function isCheckbox(Request $request)
    {
        $compare = CompareCate::findOrFail($request->id);
        $compare->is_public = $request->is_public;
        $compare->save();

        return response()->json(['success' => true]);
    }

    public function checkStt(Request $request){
        $sttCompare = $request->input('stt_compare');
        if (!empty($sttCompare)) {
            $request->validate([
                'stt_compare' => 'integer|min:0'
            ]);
        }
        $id = $request->get('id');
        $compare = CompareCate::findOrFail($id);
        $compare->stt_compare = (isset($sttCompare)) ? $sttCompare : 999;
        $compare->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật Stt thành công.']);
    }
}
