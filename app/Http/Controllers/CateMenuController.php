<?php

namespace App\Http\Controllers;

use App\Http\Requests\CateMenuFormRequest;
use App\Models\CateMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CateMenuController extends Controller
{
    public function index() {
        $categoryParents = CateMenu::where('parent_menu', 0)
            ->with('children')
            ->orderBy('stt_menu', 'ASC')
            ->get();

        return view('admin.cateMenu.index', compact('categoryParents'));
    }

    public function create() {
        $menuParents = CateMenu::where('parent_menu', 0)
            ->with('children')
            ->get();
        
        return view('admin.cateMenu.create', compact('menuParents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CateMenuFormRequest $request)
    {
        $this->insertOrUpdate($request);

        return redirect(route('cateMenu.index'))->with(['message' => 'Tạo mới thành công']);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = CateMenu::findOrFail($id);
        $categories = CateMenu::with('children')->where('parent_menu', 0)->get();
        
        return view('admin.cateMenu.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CateMenuFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return back()->with(['message' => "Cập nhật danh mục menu thành công !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = CateMenu::where('id', $id)->with('children')->first();
        $childIds = $category->getAllChildrenIds();
        $allCategoryIds = array_merge([$id], $childIds);
        CateMenu::whereIn('id', $allCategoryIds)->delete();

        return redirect(route('cateMenu.index'))->with(['message' => 'Xóa thành công']);
    }

    public function insertOrUpdate(CateMenuFormRequest $request, $id = '')
    {
        $cateMenu = empty($id) ? new CateMenu() : CateMenu::findOrFail($id);

        $cateMenu->fill($request->all());
        if(empty($request->input('parent_menu'))){
            $cateMenu->parent_menu = $request->input('parent_menu', 0);
        }
        if(empty($request->input('is_tab'))){
            $cateMenu->is_tab = $request->input('is_tab', 0);
        }
        $cateMenu->stt_menu = (isset($request->stt_menu)) ? $request->stt_menu : 999;
        $cateMenu->user_id = Auth::id();

        $cateMenu->save();
    }

    public function checkStt(Request $request){
        $sttMenu = $request->input('stt_menu');
        if (!empty($sttMenu)) {
            $request->validate([
                'stt_menu' => 'integer|min:0'
            ]);
        }
        $id = $request->get('id');
        $category = CateMenu::findOrFail($id);
        $category->stt_menu = (isset($sttMenu)) ? $sttMenu : 999;
        $category->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật Stt thành công.']);
    }

    public function isCheckbox(Request $request)
    {
        $id = $request->get('id');
        $category = CateMenu::findOrFail($id);
        if ($category) {
            $field = $request->field;
            $value = $request->value;
            // Kiểm tra xem trường có tồn tại trong bảng user không
            if (in_array($field, ['is_public', 'is_tab', 'is_click'])) {
                $category->$field = $value;

                $category->save();
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Không tồn tại.']);
            }
        }
        return response()->json(['success' => false]);
    }
}
