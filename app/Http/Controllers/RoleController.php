<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $user;
    private $permission;
    public function __construct(User $user, Permission $permission)
    {
        $this->user = $user;
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        
        $userQuery = Role::where(function($query) use ($keyword) {
            $query->where('name', 'like', "%" . Helper::escape_like($keyword) . "%")
                    ->orWhere('display_name', 'like', "%" . Helper::escape_like($keyword) . "%");
        });

        $roles = $userQuery->latest()->paginate(config('common.default_page_size'))->appends($request->except('page'));

        

        return view('admin.role.index', compact('roles', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissionsParent = $this->permission->where('parent_id', 0)->get();

        return view('admin.role.add', compact('permissionsParent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = new Role();

        $role->fill($request->all());

        $role->save();
        $role->permissions()->attach($request->permission_id);
        return redirect()->route('roles.index')->with(['message' => 'Tạo mới thành công']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissionsParent = $this->permission->where('parent_id', 0)->get();
        $permissionsChecked = $role->permissions;

        return view('admin.role.edit', compact('role', 'permissionsParent', 'permissionsChecked'));
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
        $role = Role::findOrFail($id);

        $role->fill($request->all());

        $role->save();
        $role->permissions()->sync($request->permission_id);

        return back()->with(['message' => 'Cập nhật thành công']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        // Xóa tất cả các quan hệ vai trò của người dùng trong bảng permission_role
        $role->permissions()->detach();
        // Xóa tất cả các quan hệ vai trò của người dùng trong bảng role_user
        $role->users()->detach();

        // Xóa người dùng
        $role->delete();

        return redirect()->back()->with(['message' => 'Xóa tài khoản thành công']);
    }

    public function createPermission()
    {
        // $permissionsParent = $this->permission->where('parent_id', 0)->get();

        return view('admin.permission.add');
    }

    public function storePermission()
    {
        
    }
}
