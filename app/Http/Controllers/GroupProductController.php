<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Group;
use App\Models\GroupProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupProductController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->pro_id;
        $product = Product::findOrFail($id);
        $imgProduct = $product->getMainImage();
        
        $cateIds = $product->category->pluck('id')->toArray();

        // Lấy danh mục đầu tiên trong các danh mục gắn với sản phẩm
        $category = Category::find($cateIds[0]);
        // Tìm các id danh mục cha
        $selectedCateIds = $category->getAllParentIds();
        
        $groupSelected = [];
        if (!empty($product->group_ids)) {
            // Chuyển đổi JSON thành mảng
            $groupIds = json_decode($product->group_ids, true);
            // Lấy các bản ghi từ bảng Group có id nằm trong groupIds
            $groupSelected = Group::select('id', 'name', 'parent_id', 'cate_id', 'is_type')
                ->whereIn('id', $groupIds)->get();
        }
        // Nhóm sản phẩm
        $allGroups = Group::with('products')
            ->select('id', 'name', 'parent_id', 'cate_id', 'is_type')
            ->where(function ($query) use ($selectedCateIds, $product) {
                $query->whereIn('cate_id', $selectedCateIds)
                    ->orWhere(function ($query) use ($product) {
                        $query->where('cate_id', 0)
                            ->where('parent_id', $product->id);
                    });
            })->get();
        
        // Truy vấn groupProduct với điều kiện cate_id = 0 và parent_id là id của sản phẩm
        $groupProducts = Group::with('products')
            ->select('id', 'name', 'parent_id', 'cate_id')
            ->where('cate_id', 0)
            ->where('parent_id', $product->id)
            ->get();
        
        $allProducts = Product::all();

        return view('admin.groupPro.add', compact(
            'product', 'imgProduct', 'allGroups',
            'selectedCateIds', 'allProducts',
            'groupSelected', 'groupProducts'
        ));
    }

    public function checkPrice(Request $request) {}

    public function checkQuantity(Request $request) {
        $groupId = $request->input('group_id');
        $productId = $request->input('product_id');
        $quantityGroupPr = $request->input('quantity');

        try {
            if (!empty($quantityGroupPr)) {
                $request->validate([
                    'quantity' => 'integer|min:0'
                ]);
            }

            // Tìm và cập nhật sản phẩm được chọn
            $groupProduct = GroupProduct::where('group_id', $groupId)
                ->where('product_id', $productId)
                ->first();

            if ($groupProduct) {
                $groupProduct->quantity = (isset($quantityGroupPr)) ? $quantityGroupPr : 99;
                $groupProduct->save();

                return response()->json(['success' => true, 'message' => 'Cập nhật trạng thái thành công.']);
            }

            return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi: ' . $e->getMessage()]);
        }
    }

    public function isChecked(Request $request)
    {
        $groupId = $request->input('group_id');
        $productId = $request->input('product_id');
        $isType = $request->input('is_type');
        $isChecked = $request->input('is_checked');

        try {
            // Nếu là radio (isType == 0), cập nhật toàn bộ trong group về is_checked = 0
            if ($isType == 0) {
                GroupProduct::where('group_id', $groupId)->update(['is_checked' => 0]);
            }

            // Tìm và cập nhật sản phẩm được chọn
            $groupProduct = GroupProduct::where('group_id', $groupId)
                ->where('product_id', $productId)
                ->first();

            if ($groupProduct) {
                $groupProduct->is_checked = $isChecked;
                $groupProduct->save();

                return response()->json(['success' => true, 'message' => 'Cập nhật trạng thái thành công.']);
            }

            return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi: ' . $e->getMessage()]);
        }
    }
}
