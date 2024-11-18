<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Log;

class ContentController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'uploadImg' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($request->hasFile('uploadImg')) {
            // Lấy URL hiện tại từ request
            $current_url = $request->input('current_url');
            $file = $request->file('uploadImg');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            // Tạo tên file ban đầu
            $imageName = $originalName . '.' . $extension;
            $counter = 1;
            $imageName = $file->getClientOriginalName();
            if (strpos($current_url, 'categories') !== false) {
                $originalPath = $file->storeAs('public/images/danh-muc', $imageName);
            } elseif (strpos($current_url, 'products') !== false) {

                // Kiểm tra nếu file đã tồn tại, thêm số vào tên file
                while (Storage::exists('public/images/san-pham/' . $imageName)) {
                    $imageName = $originalName . '-' . $counter . '.' . $extension;
                    $counter++;
                }
                // Lưu file ảnh gốc
                $originalPath = $file->storeAs('public/images/san-pham', $imageName);
                // Đường dẫn tuyệt đối đến ảnh gốc
                $originalAbsolutePath = storage_path('app/' . $originalPath);
                // Đường dẫn tuyệt đối đến thư mục lưu ảnh nhỏ
                $smallPath = public_path('storage/images/san-pham/small/');
                $mediumPath = public_path('storage/images/san-pham/medium/');
                $largePath = public_path('storage/images/san-pham/large/');

                // Kiểm tra xem tệp ảnh gốc đã tồn tại chưa
                if (file_exists($originalAbsolutePath)) {
                    // Tạo ảnh nhỏ
                    $smallImage = Image::make($originalAbsolutePath)->resize(108, 77)->sharpen(10); // Tạo ảnh nhỏ
                    $mediumImage = Image::make($originalAbsolutePath)->resize(206, 206)->sharpen(10); // Tạo ảnh trung bình
                    $largeImage = Image::make($originalAbsolutePath)->resize(460, 358)->sharpen(10); // Tạo ảnh lớn
                    
                    // Kiểm tra và tạo thư mục nếu chưa tồn tại
                    if (!file_exists($smallPath)) {
                        mkdir($smallPath, 0755, true);
                    }
                    if (!file_exists($mediumPath)) {
                        mkdir($mediumPath, 0755, true);
                    }
                    if (!file_exists($largePath)) {
                        mkdir($largePath, 0755, true);
                    }

                    $smallImage->save($smallPath . $imageName, 100); // Lưu ảnh nhỏ
                    $mediumImage->save($mediumPath . $imageName, 100); // Lưu ảnh trung bình
                    $largeImage->save($largePath . $imageName, 100); // Lưu ảnh lớn
                }
            } elseif (strpos($current_url, 'cateNews') !== false) {
                $originalPath = $file->storeAs('public/images/danh-muc-tin-tuc', $imageName);
            } elseif (strpos($current_url, 'news') !== false) {
                $originalPath = $file->storeAs('public/images/tin-tuc', $imageName);
            } elseif (strpos($current_url, 'cateMenu') !== false) {
                $originalPath = $file->storeAs('public/images/menu', $imageName);
            } elseif (strpos($current_url, 'favicon') !== false) {
                $originalPath = $file->storeAs('public/images/favicon', $imageName);
            }
            $newPath = str_replace('public', 'storage', $originalPath);

            return response()->json([
                'success' => 'Cập nhật hình ảnh thành công!',
                'image_name' => $newPath
            ]);
        }

        if ($request->hasFile('pr_image_ids')) {
            // Lấy URL hiện tại từ request
            $current_url = $request->input('current_url');
            $imageName = uniqid() . '-' . $request->pr_image_ids->getClientOriginalName();

            $originalPath = $request->pr_image_ids->storeAs('public/images/san-pham/anh-chi-tiet', $imageName);
            
            $newPath = str_replace('public', 'storage', $originalPath);

            return response()->json([
                'success' => 'Tải ảnh thành công!',
                'image_name' => $newPath
            ]);
        }

        return response()->json(['error' => 'Tải ảnh lên bị lỗi!'], 500);
    }

    public function deleteImage(Request $request)
    {
        $imageUrls = $request->input('image', []);
        dd($imageUrls);
        // foreach ($imageUrls as $imageUrl) {
        //     Storage::delete($imageUrl);
        // }
    
        // return response()->json(['message' => 'Images deleted successfully.']);
        $imageDelete = $request->input('image_url');
        // // dd($imagePath);
        $imagePath = str_replace('storage', 'public', $imageDelete); // Chuyển đổi đường dẫn public thành đường dẫn storage

        if (Storage::exists($imagePath)) {
            $imageUrls = $request->input('image', []);
            foreach ($imageUrls as $imageUrl) {
                Storage::delete($imageUrl);
            }
            $smallImagePath = str_replace('/san-pham/', '/san-pham/small/', $imagePath);
            $mediumImagePath = str_replace('/san-pham/', '/san-pham/medium/', $imagePath);
            $largeImagePath = str_replace('/san-pham/', '/san-pham/large/', $imagePath);

            Storage::delete($smallImagePath);
            Storage::delete($mediumImagePath);
            Storage::delete($largeImagePath);

            return response()->json(['success' => 'Image deleted successfully.']);
        }

        return response()->json(['error' => 'Image not found.'], 404);
    }

    public function checkSlug(Request $request)
    {
        $slug = $request->input('slug');
        
        $categoryCount = DB::table('categories')->where('slug', $slug)->count();
        $productCount = DB::table('products')->where('slug', $slug)->count();

        if ($categoryCount > 0 || $productCount > 0) {
            return response()->json(['exists' => true], 200);
        }

        return response()->json(['exists' => false], 200);
    }
}
