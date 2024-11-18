<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompareProductController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $prodId = $request->pro_id;
        $products = Product::findOrFail($prodId);
        
        // Lấy ra ID của các categories
        $categoryIds = $products->category()->pluck('categories.id')->toArray();

        // Kiểm tra nếu mảng không rỗng và lấy giá trị đầu tiên
        $categories = Category::with('children')->where('parent_id', 0)->get();
        if (!empty($categoryIds)) {
            $idCate = (int)$categoryIds[0];

            // Lấy ra id của parent_id = 0 
            $compareIds = Category::findOrFail($idCate)->topLevelParent()->id;
            $parentCate = Category::findOrFail($compareIds);
            $compareCate = $parentCate->getCompareCates();
            // Lấy ra các bản ghi trong bảng filters_products có product_id = $request->pro_id
            $compareProducts = DB::table('compare_products')
                ->join('compare', 'compare_products.compare_id', '=', 'compare.id')
                ->select('compare_products.*', 'compare.key_word', 'compare.compare_cate_id')
                ->where('compare_products.product_id', $prodId)
                ->get()->groupBy('compare_cate_id');
            
            return view('admin.comparePro.create', compact('idCate', 'categories', 'products', 'parentCate', 'compareCate', 'compareProducts'));
        }

        return view('admin.comparePro.create', compact('products'));
    }

    public function store(Request $request)
    {
        // Lấy các dữ liệu từ request
        $productId = $request->product_id;
        $displayCompares = $request->input('display_compare');
        $valueCompares = $request->input('value_compare');
        $compareIds = $request->input('compare_id');

        // Tìm sản phẩm theo ID
        $product = Product::find($productId);

        // Lặp qua tất cả các giá trị từ form
        foreach ($compareIds as $index => $compareId) {
            $displayCompare = $displayCompares[$index] ?? '';
            $valueCompare = $valueCompares[$index] ?? '';

            // Kiểm tra xem bản ghi đã tồn tại trong bảng trung gian chưa
            $existingCompare = $product->compares()->wherePivot('compare_id', $compareId)->first();

            if ($existingCompare) {
                // Nếu tồn tại, cập nhật bản ghi
                $product->compares()->updateExistingPivot($compareId, [
                    'display_compare' => $displayCompare,
                    'value_compare' => $valueCompare,
                ]);
            } else {
                // Nếu không tồn tại, thêm mới bản ghi
                $product->compares()->attach($compareId, [
                    'display_compare' => $displayCompare,
                    'value_compare' => $valueCompare,
                ]);
            }
        }

        return redirect()->back()->with(['message' => 'Thay đổi thành công']);
    }
}
