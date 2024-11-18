<?php

namespace App\Http\Controllers;

use App\Models\ProductTag;
use Illuminate\Http\Request;

class ProductTagController extends Controller
{
    public function store(Request $request)
    {
        // Thêm các quy tắc validate
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:product_tag,name',
                'regex:/^[a-zA-Z0-9].*[a-zA-Z0-9]$/'
            ],
        ], [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên đã tồn tại.',
            'name.regex' => 'Tên không được chứa ký tự đặc biệt ở đầu hoặc cuối.',
        ]);

        $productTag = ProductTag::create([
            'name' => $validatedData['name'],
        ]);
        return response()->json($productTag);
    }
}
