<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactIconFormRequest;
use App\Models\ContactIcon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactIconController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyWord = $request->input('keyword');
        $icons = ContactIcon::where('name', 'like', "%$keyWord%")
            ->latest()
            ->paginate(config('common.default_page_size'));

        return view('admin.contactIcon.index', compact('icons', 'keyWord'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.contactIcon.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactIconFormRequest $request)
    {
        try {
            $this->insertOrUpdate($request);
            // Lưu thông báo thành công vào session
            return redirect(route('contact-icons.index'))->with('success', 'Cập nhật thành công!');
        } catch (\Exception $e) {
            // Có lỗi xảy ra
            // Lưu thông báo lỗi vào session
            return redirect(route('contact-icons.create'))->with('error', 'Cập nhật thất bại!');
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
        $icon = ContactIcon::findOrFail($id);

        return view('admin.contactIcon.edit', compact('icon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContactIconFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return back()->with(['message' => "Cập nhật thành công Icon !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ContactIcon::findOrFail($id)->delete();

        return redirect('admin/contact-icons')->with(['message' => 'Xóa thành công']);
    }

    public function insertOrUpdate(ContactIconFormRequest $request, $id = '')
    {
        $icon = empty($id) ? new ContactIcon() : ContactIcon::findOrFail($id);

        $icon->fill($request->all());

        $path = parse_url($request->filepath, PHP_URL_PATH);
        // Xóa dấu gạch chéo đầu tiên nếu cần thiết
        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }

        $icon->image = $path;
        $icon->stt = (isset($request->stt)) ? $request->stt : 999;
        $icon->user_id = Auth::id();
        // dd($icon);
        $icon->save();
    }

    public function checkStt(Request $request){
        $sttIcon = $request->input('stt');
        if (!empty($sttIcon)) {
            $request->validate([
                'stt' => 'integer|min:0'
            ]);
        }
        $id = $request->get('id');
        $icon = ContactIcon::findOrFail($id);
        $icon->stt = (isset($sttIcon)) ? $sttIcon : 999;
        $icon->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật stt thành công.']);
    }

    public function isCheckbox(Request $request)
    {
        $icon = ContactIcon::findOrFail($request->id);

        if ($icon) {
            $field = $request->field;
            $value = $request->value;
            // Kiểm tra xem trường có tồn tại trong bảng user không
            if (in_array($field, ['animation', 'is_public'])) {
                $icon->$field = $value;

                $icon->save();
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Không tồn tại.']);
            }
        }
        return response()->json(['success' => false]);
    }
}
