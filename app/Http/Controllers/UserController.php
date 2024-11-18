<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Helpers\Helper;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $role;
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $roleId = $request->role;

        $userQuery = User::where(function ($query) use ($keyword) {
            $query->where('name', 'like', "%" . Helper::escape_like($keyword) . "%")
                ->orWhere('email', 'like', "%" . Helper::escape_like($keyword) . "%");
        });

        if ($roleId) {
            $userQuery->whereHas('roles', function ($query) use ($roleId) {
                $query->where('roles.id', $roleId); // Lọc theo ID của role
            });
        }

        $users = $userQuery->with('roles')->latest()
            ->paginate(config('common.default_page_size'))
            ->appends($request->except('page'));
        $roles = $this->role->all();

        return view('admin.users.index', compact('users', 'keyword', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->role->all();

        return view('admin.users.add', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        try {
            // Bengin transaction
            DB::beginTransaction();

            $path = parse_url($request->filepath, PHP_URL_PATH);
            // Xóa dấu gạch chéo đầu tiên nếu cần thiết
            if (strpos($path, '/') === 0) {
                $path = substr($path, 1);
            }

            $user = User::create([
                'email' => $request->email,
                'name' => $request->name,
                'slug' => $request->slug,
                'password' => Hash::make($request->password),
                'image' => $path,
                'content' => $request->content,
                'title_img' => $request->title_img ?? $request->name,
                'alt_img' => $request->alt_img ?? $request->name,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'instagram' => $request->instagram,
                'skype' => $request->skype,
                'linkedin' => $request->linkedin
            ]);

            $user->save();
            $user->roles()->attach($request->role_id);
            event(new Registered($user));

            DB::commit();

            return redirect('admin/users')->with(['message' => 'Tạo mới thành công']);
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi xảy ra
            DB::rollback();
            Log::error('Message :' . $e->getMessage() . '--- Line: ' . $e->getLine());
            // Xử lý lỗi (có thể ghi log, hiển thị thông báo lỗi, ...)
            return redirect()->back()->with(['error' => 'Đã xảy ra lỗi. Vui lòng thử lại sau.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = $this->role->all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, $id)
    {
        try {
            // Bengin transaction
            DB::beginTransaction();

            $user = User::findOrFail($id);

            $data = $request->only(['name', 'slug', 'email', 'filepath',
                'content', 'title_img', 'alt_img',
                'facebook', 'twitter', 'instagram',
                'skype', 'linkedin'
            ]);
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $path = parse_url($request->filepath, PHP_URL_PATH);
            // Xóa dấu gạch chéo đầu tiên nếu cần thiết
            if (strpos($path, '/') === 0) {
                $path = substr($path, 1);
            }
            $data['image'] = $path;

            $user->update($data);
            $user->roles()->sync($request->role_id);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // Xóa tất cả các quan hệ vai trò của người dùng trong bảng role_user
        $user->roles()->detach();

        // Xóa người dùng
        $user->delete();

        return redirect()->back()->with(['message' => 'Xóa tài khoản thành công']);
    }

    public function checkName(Request $request)
    {
        $slug = $request->input('slug');

        // Check if name exists, excluding the current category id
        // Kiểm tra xem tên có tồn tại không, ngoại trừ id danh mục hiện tại
        $slugExists = User::where('slug', $slug)->exists();
        
        return response()->json([
            'slug_exists' => $slugExists,
        ]);
    }
}
