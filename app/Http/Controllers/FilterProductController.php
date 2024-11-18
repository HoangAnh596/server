<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Filter;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterProductController extends Controller
{
    public function create(Request $request)
    {
        $id = $request->pro_id;
        $products = Product::findOrFail($id);
        
        // Lấy ra ID của các categories
        $categoryIds = $products->category()->pluck('categories.id')->toArray();
        
        // Kiểm tra nếu mảng không rỗng và lấy giá trị đầu tiên
        $categories = Category::with('children')->where('parent_id', 0)->get();
        if(!empty($categoryIds)) {
            $idCate = (int)$categoryIds[0];

            // Lấy ra id của parent_id = 0 
            $filterIds = Category::findOrFail($idCate)->topLevelParent()->id;
            $cate = Category::findOrFail($filterIds);
            $filterCate = $cate->getFilterCates();
            // Lấy ra các bản ghi trong bảng filters_products có product_id = $request->pro_id
            $filterProducts = DB::table('filters_products')
                ->where('product_id', $id)
                ->get();
            
            return view('admin.filterPro.create',compact('idCate', 'categories', 'products', 'filterCate', 'filterProducts'));
        }
        
        return view('admin.filterPro.create',compact('products'));
    }

    public function store(Request $request)
    {
        $this->insertOrUpdate($request);

        return redirect()->back()->with(['message' => 'Thay đổi thành công']);
    }

    public function insertOrUpdate(Request $request, $id = '')
    {
        $filter = empty($id) ? new Filter() : Filter::findOrFail($id);

        $arr = $request->all();
        function flatArray($array) {
            $result = [];
        
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    // Nếu giá trị là một mảng, gọi đệ quy để xử lý mảng con
                    $result = array_merge($result, flatArray($value));
                } elseif (is_numeric($value)) {
                    // Nếu giá trị không phải là mảng và là số, thêm vào mảng kết quả
                    $result[] = $value;
                }
            }
        
            return $result;
        }
        // Bỏ qua các giá trị không liên quan
        $filteredArr = array_filter($arr, function($key) {
            return !in_array($key, ['_token', '_method', 'product_id']);
        }, ARRAY_FILTER_USE_KEY);

        $filter_new = flatArray($filteredArr);
        $productId = $request->product_id;
         // Xóa các bản ghi trong bảng product_categories có product_id = id cũ
        DB::table('filters_products')->where('product_id', $productId)->delete();

        foreach ($filter_new as $val) {
            $filter = Filter::findOrFail($val);
            $filter->product()->attach($productId);
        }
    }
}
