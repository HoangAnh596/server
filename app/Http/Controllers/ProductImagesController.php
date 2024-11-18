<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImagesController extends Controller
{
    public function destroy($id)
    {
        $image = ProductImages::findOrFail($id);
        // Tìm sản phẩm liên quan
        $product = Product::whereJsonContains('image_ids', $id)->firstOrFail();

        $imageFileName = basename($image->image);
        $smallImagePath = "public/images/san-pham/small/$imageFileName";
        $mediumImagePath = "public/images/san-pham/medium/$imageFileName";
        $largeImagePath = "public/images/san-pham/large/$imageFileName";
        Storage::delete($smallImagePath);
        Storage::delete($mediumImagePath);
        Storage::delete($largeImagePath);
        
        $imagePath = str_replace('storage/', 'public/', parse_url($image->image, PHP_URL_PATH));
        Storage::delete($imagePath);
        // Cập nhật mảng images_id trong bảng products
        if ($product) {
            // Cập nhật mảng image_ids trong bảng products
            $imagesIds = json_decode($product->image_ids, true);
            if (($key = array_search($id, $imagesIds)) !== false) {
                unset($imagesIds[$key]);
                // Cập nhật lại image_ids cho sản phẩm
                $product->image_ids = json_encode(array_values($imagesIds));
                $product->save();
            }
            
            // Xóa ảnh từ bảng ProductImages
            $image->delete();
        }

        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    }

    public function checkStt(Request $request){
        $sttImg = $request->input('stt_img');
        if (!empty($sttImg)) {
            $request->validate([
                'stt_img' => 'integer|min:0'
            ]);
        }
        $id = $request->get('id');
        $category = ProductImages::findOrFail($id);
        $category->stt_img = (isset($sttImg)) ? $sttImg : 999;
        $category->save();

        return response()->json(['success' => true, 'message' => 'STT updated successfully.']);
    }

    public function isCheckImg(Request $request)
    {
        $product = ProductImages::findOrFail($request->id);
        $product->main_img = $request->main_img;
        $product->save();

        return response()->json(['success' => true]);
    }
}
