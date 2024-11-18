<?php

namespace App\Http\Controllers;

use App\Http\Requests\CateFooterFormRequest;
use App\Models\CateFooter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CateFooterController extends Controller
{
    public function index() {
        $ftParents = CateFooter::where('parent_menu', 0)
            ->with('children')
            ->orderBy('stt_menu', 'ASC')
            ->get();

        return view('admin.cateFooter.index', compact('ftParents'));
    }

    public function create() {
        $menuParents = CateFooter::where('parent_menu', 0)
            ->get();
        
        return view('admin.cateFooter.create', compact('menuParents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CateFooterFormRequest $request)
    {
        $this->insertOrUpdate($request);

        return redirect(route('cateFooter.index'))->with(['message' => 'Tạo mới thành công']);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = CateFooter::findOrFail($id);
        $categories = CateFooter::with('children')->where('parent_menu', 0)->get();
        
        return view('admin.cateFooter.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CateFooterFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return back()->with(['message' => "Cập nhật thành công danh mục footer !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = CateFooter::where('id', $id)->with('children')->first();
        $childIds = $category->getAllChildrenIds();
        $allCategoryIds = array_merge([$id], $childIds);
        CateFooter::whereIn('id', $allCategoryIds)->delete();

        return redirect(route('cateFooter.index'))->with(['message' => 'Xóa thành công']);
    }

    public function insertOrUpdate(Request $request, $id = '')
    {
        $cateFooter = empty($id) ? new CateFooter() : CateFooter::findOrFail($id);

        $cateFooter->fill($request->all());

        if(empty($request->input('parent_menu'))){
            $cateFooter->parent_menu = $request->input('parent_menu', 0);
        }
        if(empty($request->input('is_tab'))){
            $cateFooter->is_tab = $request->input('is_tab', 0);
        }

        $cateFooter->stt_menu = (isset($request->stt_menu)) ? $request->stt_menu : 999;
        $cateFooter->user_id = Auth::id();

        $cateFooter->save();
    }

    public function checkStt(Request $request){
        $sttMenu = $request->input('stt_menu');
        if (!empty($sttMenu)) {
            $request->validate([
                'stt_menu' => 'integer|min:0'
            ]);
        }
        $id = $request->get('id');
        $category = CateFooter::findOrFail($id);
        $category->stt_menu = (isset($sttMenu)) ? $sttMenu : 999;
        $category->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật Stt thành công.']);
    }

    public function isCheckbox(Request $request)
    {
        $id = $request->get('id');
        $category = CateFooter::findOrFail($id);
        if ($category) {
            $field = $request->field;
            $value = $request->value;
            // Kiểm tra xem trường có tồn tại trong bảng user không
            if (in_array($field, ['is_public', 'is_tab', 'is_click'])) {
                $category->$field = $value;

                $category->save();
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Field does not exist.']);
            }
        }
        return response()->json(['success' => false]);
    }
}
