<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupsFormRequest;
use App\Models\Category;
use App\Models\Group;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyWord = $request->input('keyword');
        $groups = Group::where('name', 'like', "%$keyWord%")
            ->latest()
            ->paginate(config('common.default_page_size'));

        return view('admin.groups.index', compact('groups', 'keyWord'));
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
        $products = Product::select('id', 'name')->get();

        return view('admin.groups.add', compact('idCate', 'categories', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupsFormRequest $request)
    {
        $this->insertOrUpdate($request);

        return redirect(route('groups.index'))->with(['message' => 'Tạo mới thành công']);
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
        $group = Group::findOrFail($id);
        $categories = Category::with('children')->where('parent_id', 0)->get();
        // Lấy danh sách sản phẩm đã chọn của group
        $selectedProductIds = $group->products->pluck('id')->toArray();

        // Lấy các sản phẩm chưa được chọn
        $products = Product::select('id', 'name')->whereNotIn('id', $selectedProductIds)->get();

        // Trả về view
        return view('admin.groups.edit', compact('group', 'categories', 'products', 'selectedProductIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroupsFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return back()->with(['message' => "Cập nhật thành công nhóm sản phẩm !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function insertOrUpdate(Request $request, $id = '')
    {
        try {
            // Bengin transaction
            DB::beginTransaction();

            $group = empty($id) ? new Group() : Group::findOrFail($id);
            $group->fill($request->all());
            $group->parent_id = 0;

            $group->save();

            // Thêm dữ liệu vào bảng `GroupProduct`
            $group->products()->sync($request->product_id);

            DB::commit();

            return back()->with(['message' => 'Cập nhật thành công']);
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi xảy ra
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--- Line: ' . $e->getLine());
            // Xử lý lỗi (có thể ghi log, hiển thị thông báo lỗi, ...)
            return redirect()->back()->with(['error' => 'Đã xảy ra lỗi. Vui lòng thử lại sau.']);
        }
    }

    public function checkStt(Request $request){
        $sttGroup = $request->input('stt');
        if (!empty($sttGroup)) {
            $request->validate([
                'stt' => 'integer|min:0'
            ]);
        }
        $id = $request->get('id');
        $group = Group::findOrFail($id);
        $group->stt = (isset($sttGroup)) ? $sttGroup : 999;
        $group->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật Stt thành công.']);
    }

    public function isCheckbox(Request $request)
    {
        $group = Group::findOrFail($request->id);
        $group->is_public = $request->is_public;
        $group->save();

        return response()->json(['success' => true]);
    }

    public function addGroup(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'groupName' => 'required|string|unique:groups,name', // Kiểm tra không được trùng với cột 'name' trong bảng 'groups'
                'idGroup' => 'required|array|min:1', // Bắt buộc phải chọn ít nhất 1 sản phẩm
            ], [
                'groupName.required' => 'Vui lòng nhập tên nhóm.',
                'groupName.unique' => 'Tên nhóm đã tồn tại, vui lòng chọn tên khác.',
                'idGroup.required' => 'Vui lòng chọn ít nhất một sản phẩm.',
                'idGroup.min' => 'Vui lòng chọn ít nhất một sản phẩm.',
            ]);
        
            // Nếu validation thất bại
            if ($validator->fails()) {
                // Bắn lỗi validation ra dưới dạng JSON
                throw new ValidationException($validator);
            }
            $proId = $request->productId;

            $addGroup = new Group;
            $product = Product::findOrFail($proId);

            $addGroup->parent_id = $proId;
            $addGroup->name = $request->groupName;
            $addGroup->cate_id = 0;
            $addGroup->created_at = now();
            $addGroup->updated_at = now();

            $addGroup->save();

            if (!empty($request['group_ids'])) {
                // Chuyển đổi mảng group_ids thành JSON
                $groupIds = $request->group_ids;
                $groupIdsOld = json_decode($product->group_ids, true); // Chuyển JSON về mảng
                if (!empty($groupIdsOld)) {
                    // Tìm các phần tử có trong $groupIdsOld nhưng không có trong $groupIds
                    $groupIdsToDelete = array_diff($groupIdsOld, $groupIds);
                    if (!empty($groupIdsToDelete)) {
                        DB::table('group_products')
                            ->whereIn('group_id', function ($query) use ($groupIdsToDelete, $proId) {
                                $query->select('id')
                                    ->from('groups')
                                    ->whereIn('id', $groupIdsToDelete)
                                    ->where('cate_id', 0)
                                    ->where('parent_id', $proId);
                            })
                            ->delete(); // Xóa các bản ghi thỏa mãn điều kiện
                        // Lặp qua từng ID và xóa
                        Group::whereIn('id', $groupIdsToDelete)
                            ->where('cate_id', 0)
                            ->where('parent_id', $proId)
                            ->delete(); // Xóa các bản ghi thỏa mãn điều kiện
                    }
                }

                $groupIds[] = $addGroup->id;
                // Chuyển mảng thành JSON và lưu vào Product
                $product->group_ids = json_encode($groupIds);
            } else {
                $groupIdsOld = json_decode($product->group_ids, true); // Chuyển JSON về mảng
                
                if (!empty($groupIdsOld)) {
                    // Lặp qua từng id và xóa ở bảng group_products
                    DB::table('group_products')
                        ->whereIn('group_id', function ($query) use ($groupIdsOld, $proId) {
                            $query->select('id')
                                ->from('groups')
                                ->whereIn('id', $groupIdsOld)
                                ->where('cate_id', 0)
                                ->where('parent_id', $proId);
                        })
                        ->delete(); // Xóa các bản ghi thỏa mãn điều kiện
                    // Lặp qua từng ID và xóa
                    Group::whereIn('id', $groupIdsOld)
                        ->where('cate_id', 0)
                        ->where('parent_id', $proId)
                        ->delete(); // Xóa các bản ghi thỏa mãn điều kiện
                }
                $product->group_ids = json_encode([$addGroup->id]);
            }

            // Lấy danh sách `group_ids` hiện tại của sản phẩm (giải mã JSON)
            // $currentGroupIds = json_decode($product->group_ids, true); // true để có mảng
            // if (!is_array($currentGroupIds)) {
            //     $currentGroupIds = []; // Nếu chưa có, khởi tạo mảng rỗng
            // }

            // // Thêm ID của nhóm mới vào mảng `group_ids`
            // $currentGroupIds[] = $group->id;

            // // Cập nhật lại `group_ids` của sản phẩm (mã hóa mảng thành JSON)
            // $product->group_ids = json_encode($currentGroupIds);
            $product->save();

            // Thêm dữ liệu vào bảng `GroupProduct`
            $addGroup->products()->sync($request->idGroup);

            
            return response()->json(['success' => 'Thêm mới nhóm thành công']);
        } catch (ValidationException $e) {
            // Bắn lỗi validation ra ngoài JS với trạng thái 422 (Unprocessable Entity)
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Có lỗi xảy ra, vui lòng thử lại.'], 500);
        }
    }

    public function refreshGroup(Request $request)
    {
        try {
            // Bengin transaction
            DB::beginTransaction();

            $proId = $request->productId;
            $product = Product::findOrFail($proId);

            // Kiểm tra và cập nhật group_ids
            if (!empty($request['group_ids'])) {
                // Chuyển đổi mảng group_ids thành JSON
                $groupIds = $request->group_ids;
                $groupIdsOld = json_decode($product->group_ids, true); // Chuyển JSON về mảng
                if (!empty($groupIdsOld)) {
                    // Tìm các phần tử có trong $groupIdsOld nhưng không có trong $groupIds
                    $groupIdsToDelete = array_diff($groupIdsOld, $groupIds);
                    if (!empty($groupIdsToDelete)) {
                        // Lặp qua từng id và xóa ở bảng group_products
                        DB::table('group_products')
                            ->whereIn('group_id', function ($query) use ($groupIdsToDelete, $proId) {
                                $query->select('id')
                                    ->from('groups')
                                    ->whereIn('id', $groupIdsToDelete)
                                    ->where('cate_id', 0)
                                    ->where('parent_id', $proId);
                            })
                            ->delete(); // Xóa các bản ghi thỏa mãn điều kiện
                        // Lặp qua từng ID và xóa
                        Group::whereIn('id', $groupIdsToDelete)
                            ->where('cate_id', 0)
                            ->where('parent_id', $proId)
                            ->delete(); // Xóa các bản ghi thỏa mãn điều kiện
                    }
                }

                // Chuyển mảng thành JSON và lưu vào Product
                $product->group_ids = json_encode($groupIds);
            } else {
                $groupIdsOld = json_decode($product->group_ids, true); // Chuyển JSON về mảng
                if (!empty($groupIdsOld)) {
                    // Lặp qua từng id và xóa ở bảng group_products
                    DB::table('group_products')
                        ->whereIn('group_id', function ($query) use ($groupIdsOld, $proId) {
                            $query->select('id')
                                ->from('groups')
                                ->whereIn('id', $groupIdsOld)
                                ->where('cate_id', 0)
                                ->where('parent_id', $proId);
                        })
                        ->delete(); // Xóa các bản ghi thỏa mãn điều kiện
                    // Lặp qua từng ID và xóa
                    Group::whereIn('id', $groupIdsOld)
                        ->where('cate_id', 0)
                        ->where('parent_id', $proId)
                        ->delete(); // Xóa các bản ghi thỏa mãn điều kiện
                }
                // Nếu không có group_ids trong request, lưu chỉ id của bản ghi mới tạo
                $product->group_ids = [];
            }

            // Lưu thay đổi vào cơ sở dữ liệu
            $product->save();

            DB::commit();

            return response()->json(['success' => 'Làm mới nhóm thành công']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Có lỗi xảy ra, vui lòng thử lại.'], 500);
        }
    }

    public function inheritGroup(Request $request)
    {
        try {
            // Bengin transaction
            DB::beginTransaction();

            $groupId = $request->groupId;
            $proId = $request->productId;
            $group = Group::findOrFail($groupId);
            $product = Product::findOrFail($proId);

            // Tạo bản ghi mới
            $newGroup = $group->replicate(); // Sao chép tất cả các thuộc tính của bản ghi hiện tại

            // Thay đổi các thuộc tính cần thiết
            $newGroup->parent_id = $proId; // Gán parent_id mới

            $newGroup->name = $group->name . ' - kế thừa';
            $newGroup->cate_id = 0; // Thay đổi cate_id

            // Lưu bản ghi mới vào cơ sở dữ liệu Group
            $newGroup->save();

            // Kiểm tra và cập nhật group_ids
            if (!empty($request['group_ids'])) {
                // Chuyển đổi mảng group_ids thành JSON
                $groupIds = $request->group_ids;
                $groupIdsOld = json_decode($product->group_ids, true); // Chuyển JSON về mảng
                if (!empty($groupIdsOld)) {
                    // Tìm các phần tử có trong $groupIdsOld nhưng không có trong $groupIds
                    $groupIdsToDelete = array_diff($groupIdsOld, $groupIds);
                    if (!empty($groupIdsToDelete)) {
                        DB::table('group_products')
                            ->whereIn('group_id', function ($query) use ($groupIdsToDelete, $proId) {
                                $query->select('id')
                                    ->from('groups')
                                    ->whereIn('id', $groupIdsToDelete)
                                    ->where('cate_id', 0)
                                    ->where('parent_id', $proId);
                            })
                            ->delete(); // Xóa các bản ghi thỏa mãn điều kiện
                        // Lặp qua từng ID và xóa
                        Group::whereIn('id', $groupIdsToDelete)
                            ->where('cate_id', 0)
                            ->where('parent_id', $proId)
                            ->delete(); // Xóa các bản ghi thỏa mãn điều kiện
                    }
                }
                // Thêm id của bản ghi Group mới tạo vào mảng group_ids
                $groupIds[] = $newGroup->id;

                // Chuyển mảng thành JSON và lưu vào Product
                $product->group_ids = json_encode($groupIds);
            } else {
                $groupIdsOld = json_decode($product->group_ids, true); // Chuyển JSON về mảng
                
                if (!empty($groupIdsOld)) {
                    // Lặp qua từng id và xóa ở bảng group_products
                    DB::table('group_products')
                        ->whereIn('group_id', function ($query) use ($groupIdsOld, $proId) {
                            $query->select('id')
                                ->from('groups')
                                ->whereIn('id', $groupIdsOld)
                                ->where('cate_id', 0)
                                ->where('parent_id', $proId);
                        })
                        ->delete(); // Xóa các bản ghi thỏa mãn điều kiện
                    // Lặp qua từng ID và xóa
                    Group::whereIn('id', $groupIdsOld)
                        ->where('cate_id', 0)
                        ->where('parent_id', $proId)
                        ->delete(); // Xóa các bản ghi thỏa mãn điều kiện
                }
                // Nếu không có group_ids trong request, lưu chỉ id của bản ghi mới tạo
                $product->group_ids = json_encode([$newGroup->id]);
            }

            // Lưu thay đổi vào cơ sở dữ liệu
            $product->save();

            // Sao chép dữ liệu trong bảng trung gian group_products
            $productIds = $group->products->pluck('id')->toArray();

            if (!empty($productIds)) {
                // Tạo bản ghi trong bảng trung gian với group_id mới
                DB::table('group_products')->insert(
                    array_map(function ($productId) use ($newGroup) {
                        return [
                            'group_id' => $newGroup->id,
                            'product_id' => $productId,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }, $productIds)
                );
            }

            DB::commit();

            return response()->json(['success' => 'Tạo nhóm kế thừa thành công']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Có lỗi xảy ra, vui lòng thử lại.'], 500);
        }
    }

    public function saveGroup(Request $request)
    {
        try {
            // Bengin transaction
            DB::beginTransaction();

            $groupId = $request->idGroup;
            $group = Group::findOrFail($groupId);

            // Sao chép dữ liệu trong bảng trung gian group_products
            $group->products()->sync($request->group_product_ids);

            DB::commit();

            return response()->json(['success' => 'Tạo nhóm kế thừa thành công']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Có lỗi xảy ra, vui lòng thử lại.'], 500);
        }
    }
}
