<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use App\Http\Requests\BottomFormRequest;
use App\Models\Bottom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BottomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyWord = $request->input('keyword');
        $bottoms = Bottom::where('name', 'like', "%" . Helper::escape_like($keyWord) . "%")
            ->latest()
            ->paginate(config('common.default_page_size'));

        return view('admin.bottom.index', compact('bottoms', 'keyWord'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.bottom.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BottomFormRequest $request)
    {
        $this->insertOrUpdate($request);

        return redirect(route('bottoms.index'))->with(['message' => 'Tạo mới thành công']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bottom = Bottom::findOrFail($id);

        return view('admin.bottom.edit', compact('bottom'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BottomFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return back()->with(['message' => "Cập nhật thành công hotline !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Bottom::findOrFail($id)->delete();

        return redirect('admin/bottoms')->with(['message' => 'Xóa thành công']);
    }

    public function insertOrUpdate(Request $request, $id = '')
    {
        $infor = empty($id) ? new Bottom() : Bottom::findOrFail($id);

        $infor->fill($request->all());
        
        $infor->stt = (isset($request->stt)) ? $request->stt : 999;
        $infor->user_id = Auth::id();

        $infor->save();
    }

    public function checkStt(Request $request){
        $sttInfor = $request->input('stt');
        if (!empty($sttInfor)) {
            $request->validate([
                'stt' => 'integer|min:0'
            ]);
        }
        $id = $request->get('id');
        $infor = Bottom::findOrFail($id);
        $infor->stt = (isset($sttInfor)) ? $sttInfor : 999;
        $infor->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật stt thành công.']);
    }

    public function isCheckbox(Request $request)
    {
        $infor = Bottom::findOrFail($request->id);
        $infor->is_public = $request->is_public;
        $infor->save();

        return response()->json(['success' => true]);
    }
}
