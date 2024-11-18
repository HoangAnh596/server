<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionFormRequest;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $catePermission = Permission::where('parent_id', 0)
            ->with('permissionsChild')
            ->get();

        return view('admin.permission.index', compact('catePermission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $catePermission = Permission::where('parent_id', 0)->get();

        return view('admin.permission.add', compact('catePermission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionFormRequest $request)
    {
        $this->insertOrUpdate($request);

        return redirect(route('permissions.index'))->with(['message' => 'Tạo mới Permission thành công']);
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
        $permission = Permission::findOrFail($id);
        $permissionsParent = Permission::where('parent_id', 0)->get();

        return view('admin.permission.edit', compact('permission', 'permissionsParent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return back()->with(['message' => "Cập nhật Permission thành công !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        
        $childPermissions = $permission->where('parent_id', $permission->id)->get();
        // Xóa tất cả các quyền con (nếu có)
        foreach ($childPermissions as $child) {
            // Xóa quan hệ vai trò của các quyền con
            $child->roles()->detach();
            // Xóa quyền con
            $child->delete();
        }
        // Xóa tất cả các quan hệ vai trò của người dùng trong bảng permission_role
        $permission->roles()->detach();

        // Xóa
        $permission->delete();

        return redirect()->back()->with(['message' => 'Xóa tài khoản thành công']);
    }

    public function insertOrUpdate(Request $request, $id = '')
    {
        $permission = empty($id) ? new Permission() : Permission::findOrFail($id);

        $permission->fill($request->all());

        $permission->parent_id = $request->parent_id == 0 ? 0 : $request->parent_id;

        $permission->save();
    }
}
