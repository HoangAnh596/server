<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingFormRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.add');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setting = Setting::findOrFail(1);
        
        return view('admin.setting.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SettingFormRequest $request, $id)
    {
        $setting = Setting::findOrFail(1);

        $path = !empty($request->filepath) 
                ? ltrim(parse_url($request->filepath, PHP_URL_PATH), '/') // Xóa dấu gạch chéo đầu tiên
                : $setting->image;

        $setting->fill($request->all());
        $setting->image = $path;
        $setting->user_id = Auth::id();
        $setting->save();

        return back()->with(['message' => 'Cập nhật hình ảnh setting thành công']);
    }

    public function images()
    {
        return view('admin.setting.delete');
    }

    public function cleanup(Request $request)
    {
        $type = $request->input('type');

        switch ($type) {
            case 'products':
                \Illuminate\Support\Facades\Artisan::call('cleanup:product-img');
                $message = 'Dọn dẹp ảnh sản phẩm thành công';
                break;
            case 'categories':
                \Illuminate\Support\Facades\Artisan::call('cleanup:category-img');
                $message = 'Dọn dẹp ảnh danh mục thành công';
                break;
            case 'news':
                \Illuminate\Support\Facades\Artisan::call('cleanup:new-img');
                $message = 'Dọn dẹp ảnh tin tức thành công';
                break;
            case 'all':
                \Illuminate\Support\Facades\Artisan::call('cleanup:product-img');
                \Illuminate\Support\Facades\Artisan::call('cleanup:category-img');
                \Illuminate\Support\Facades\Artisan::call('cleanup:new-img');
                $message = 'Dọn dẹp tất cả ảnh thành công';
                break;
            default:
                $message = 'Không hợp lệ';
                break;
        }

        return response()->json(['message' => $message]);
    }
}
