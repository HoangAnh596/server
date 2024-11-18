<?php

namespace App\Http\Controllers;

use App\Http\Requests\SliderFormRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyWord = $request->input('keyword');
        $sliders = Slider::where('name', 'like', "%$keyWord%")
            ->latest()
            ->paginate(config('common.default_page_size'));

        return view('admin.slider.index', compact('sliders', 'keyWord'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderFormRequest $request)
    {
        $this->insertOrUpdate($request);

        return redirect(route('sliders.index'))->with(['message' => 'Tạo mới thành công']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);

        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SliderFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return back()->with(['message' => "Cập nhật thành công slider !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Slider::findOrFail($id)->delete();

        return redirect('admin/sliders')->with(['message' => 'Xóa slider thành công']);
    }

    public function insertOrUpdate(Request $request, $id = '')
    {
        $slider = empty($id) ? new Slider() : Slider::findOrFail($id);

        $slider->fill($request->all());

        $path = parse_url($request->filepath, PHP_URL_PATH);
        // Xóa dấu gạch chéo đầu tiên nếu cần thiết
        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }

        $slider->image = $path;
        $slider->stt_slider = (isset($request->stt_slider)) ? $request->stt_slider : 999;
        $slider->user_id = Auth::id();

        $slider->save();
    }

    public function checkStt(Request $request)
    {
        $sttSlider = $request->input('stt');
        if (!empty($sttSlider)) {
            $request->validate([
                'stt' => 'integer|min:0',
            ], [
                'stt.min' => 'Số sao phải lớn hơn hoặc bằng 0.',
                'stt.integer' => 'Giá trị phải là số nguyên.',
            ]);
        }
        $id = $request->get('id');
        $slider = Slider::findOrFail($id);
        $slider->stt_slider = (isset($sttSlider)) ? $sttSlider : 999;
        $slider->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật Slider thành công']);
    }

    public function isCheckbox(Request $request)
    {
        $slider = Slider::findOrFail($request->id);
        $slider->is_public = $request->is_public;
        $slider->save();

        return response()->json(['success' => true]);
    }
}
