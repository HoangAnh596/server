<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use App\Http\Requests\CommentFormRequest;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Lấy các tham số tìm kiếm từ request
        $keyword = $request->input('keyword');
        $isReply = $request->input('is_reply');

        // Khởi tạo query cho việc tìm kiếm
        $cmtQuery = Comment::query();

        // Áp dụng tìm kiếm theo nội dung nếu có từ khóa
        if ($keyword) {
            $cmtQuery->where('content', 'like', "%" . Helper::escape_like($keyword) . "%");
        }

        // Áp dụng lọc theo trạng thái công khai nếu có giá trị
        if ($isReply !== null) {
            if ($isReply == 0) {
                // Lấy các comment không có replies
                $cmtQuery->where('parent_id', 0)
                         ->whereDoesntHave('replies') // Lọc các comment không có replies
                         ->with('replies'); // Nếu bạn vẫn muốn lấy replies khi cần (mặc dù không có)
            } elseif ($isReply == 1) {
                // Lấy các comment có replies
                $cmtQuery->where('parent_id', 0)
                         ->whereHas('replies') // Lọc các comment có replies
                         ->with('replies'); // Lấy các replies cùng với comment
            }
        }

        // Lấy danh sách comment cha và các reply, đồng thời phân trang
        $comments = $cmtQuery->where('parent_id', 0)
            ->with('replies')
            ->latest()
            ->paginate(20);

        // Trả về view cùng với dữ liệu cần thiết
        return view('admin.comment.index', compact('comments', 'keyword', 'isReply'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        return view('admin.comment.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CommentFormRequest $request, $id)
    {
        $comment = Comment::findOrFail($id);

        $comment->fill($request->all());

        $comment->save();

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
        $category = Comment::where('id', $id)->with('replies')->firstOrFail();
        $cmtParentId = $category->parent_id;
        $childIds = $category->getAllChildrenIds();
        $allCategoryIds = array_merge([$id], $childIds);
        Comment::whereIn('id', $allCategoryIds)->delete();
        if (!empty($cmtParentId)) {
            $cmtParent = Comment::find($cmtParentId);
            // Nếu comment cha tồn tại và không còn replies nào khác, cập nhật is_public = 0
            if ($cmtParent && $cmtParent->replies()->count() == 0) {
                $cmtParent->is_public = 0;
                $cmtParent->save();
            }
        }

        return redirect(route('comments.index'))->with(['message' => 'Xóa thành công !']);
    }

    public function replay($id)
    {
        $comment = Comment::findOrFail($id);
        $product = Product::where('id', $comment->product_id)->first();
        $user = Auth::user();

        return view('admin.comment.replay', compact('comment', 'product', 'user'));
    }

    public function repUpdate(CommentFormRequest $request, $id)
    {
        // Lấy thông tin user đăng nhập
        $user = Auth::user();

        DB::beginTransaction();

        try {
            // Tạo bản ghi mới cho comment reply
            $replayCmt = new Comment();
            $replayCmt->parent_id = $request->id;
            $replayCmt->product_id = $request->product_id;
            $replayCmt->content = $request->content;
            $replayCmt->name = $request->name;
            $replayCmt->email = $request->email;
            $replayCmt->slugProduct = $request->slugProduct;
            $replayCmt->user_id = $user->id;
            $replayCmt->is_public = 1;

            $replayCmt->save();

            // Sau khi bản ghi mới được tạo thành công, cập nhật trạng thái is_public của comment cha
            $cmtParent = Comment::findOrFail($request->id); // Đảm bảo rằng bạn đang dùng $request->id thay vì $id
            $cmtParent->is_public = 1;
            $cmtParent->save();

            // Commit transaction
            DB::commit();

            // Chuyển hướng với thông báo thành công
            return redirect(route('comments.index'))->with(['message' => 'Trả lời bình luận thành công']);
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi xảy ra
            DB::rollback();

            // Xử lý lỗi (có thể ghi log, hiển thị thông báo lỗi, ...)
            return redirect()->back()->with(['error' => 'Đã xảy ra lỗi khi trả lời bình luận. Vui lòng thử lại sau.']);
        }
    }

    public function search(Request $request)
    {
        $product_id = [];
        if ($search = $request->name) {
            $product_id = Product::where('name', 'LIKE', "%$search%")->get();
        }
        return response()->json($product_id);
    }

    public function sendCmt(CommentFormRequest $request)
    {
        try {
            $sendCmt = new Comment();

            // Lưu các dữ liệu vào commentsendRequest
            $sendCmt->fill($request->all());

            // Lưu comment vào cơ sở dữ liệu
            $sendCmt->save();
            // Render view của bình luận mới
            $comment_html = view('cntt.home.partials.cmt', compact('sendCmt'))->render();
            // Trả về phản hồi thành công
            return response()->json([
                'success' => true,
                'comment_html' => $comment_html,
            ]);
        } catch (\Exception $e) {
            // Trả về phản hồi lỗi
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lưu bình luận.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function replyCmt(Request $request)
    {
        // Lấy thông tin user đăng nhập
        try {
            $sendCmt = new Comment();

            $sendCmt->fill($request->all());

            if (Auth::check() && Auth::user()->hasPermission('replay_comment')) {
                $sendCmt->is_public = 1;
            } else {
                $sendCmt->is_public = 0;
            }

            // Lưu comment vào cơ sở dữ liệu
            $sendCmt->save();
            // Render view của bình luận mới
            $comment_html = view('cntt.home.partials.res-reply', compact('sendCmt'))->render();
            // Trả về phản hồi thành công
            return response()->json([
                'success' => true,
                'comment_html' => $comment_html,
            ]);
        } catch (\Exception $e) {
            // Trả về phản hồi lỗi
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lưu bình luận.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function parent(Request $request)
    {
        // Kiểm tra xem product_id có tồn tại không
        if ($request->has('product_id')) {
            $cate = Comment::where('product_id', $request->product_id)
                ->where('parent_id', 0)
                ->with('replies')
                ->get();

            return response()->json($cate);
        }

        return response()->json([]);
    }

    public function isCheckbox(Request $request)
    {
        $comment = Comment::findOrFail($request->id);
        $comment->is_public = $request->is_public;
        $comment->save();

        return response()->json(['success' => true]);
    }

    public function checkStar(Request $request)
    {
        $cmtStar = $request->input('star');
        if (!empty($cmtStar)) {
            $request->validate([
                'star' => 'integer|min:0|max:5',
            ], [
                'star.max' => 'Số sao phải nhỏ hơn hoặc bằng 5.',
                'star.min' => 'Số sao phải lớn hơn hoặc bằng 0.',
                'star.integer' => 'Giá trị phải là số nguyên.',
            ]);
        }
        $id = $request->get('id');
        $comment = Comment::findOrFail($id);
        $comment->star = (isset($cmtStar)) ? $cmtStar : 1;
        $comment->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật sao comments thành công']);
    }
}
