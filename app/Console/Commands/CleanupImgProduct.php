<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\ProductImages;

class CleanupImgProduct extends Command
{
    protected $signature = 'cleanup:product-img';
    protected $description = 'Xóa ảnh không được sử dụng trong nội dung CKEditor';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Lấy tất cả sản phẩm có nội dung CKEditor
        $products = Product::all();

        // Mảng để lưu trữ tất cả các đường dẫn ảnh đang được sử dụng
        $usedImages = [];
        $usedFilepaths = [];

        foreach ($products as $product) {
            // Trích xuất URL ảnh từ nội dung
            preg_match_all('/<img.*?src=["\'](.*?)["\']/', $product->content, $matches);

            // Thêm tất cả URL ảnh tìm thấy vào mảng ảnh đang được sử dụng
            if (!empty($matches[1])) {
                foreach ($matches[1] as $url) {
                    // Chuyển URL thành đường dẫn tương đối
                    $relativePath = str_replace(url('storage'), 'storage', $url);
                    $usedImages[] = $relativePath;
                }
            }

            $imageIds = $product->image_ids; // Lấy danh sách image_ids từ mỗi sản phẩm
            // Nếu image_ids không phải là mảng, chuyển đổi thành mảng rỗng
            if (is_string($imageIds)) {
                // Nếu là chuỗi, chuyển đổi nó thành mảng bằng cách phân tách
                $imageIds = json_decode($imageIds, true) ?: [];
            } elseif (!is_array($imageIds)) {
                // Nếu không phải là chuỗi và cũng không phải là mảng, chuyển đổi thành mảng rỗng
                $imageIds = [];
            }
            if (!empty($imageIds)) {
                // Lấy các ảnh từ bảng product_images theo image_ids
                $existingImages = ProductImages::whereIn('id', $imageIds)->pluck('image')->toArray();
    
                // Thêm các đường dẫn ảnh từ bảng product_images vào mảng usedImages
                foreach ($existingImages as $imagePath) {
                    // Chuyển đường dẫn ảnh thành đường dẫn tương đối
                    $relativePath = str_replace(url('storage'), 'storage', $imagePath);
                    $usedImages[] = $relativePath;
                }
            }

            // Lấy danh sách filepath từ mỗi sản phẩm
            if (!empty($product->filepath)) {
                // Chuyển đường dẫn ảnh thành đường dẫn tương đối
                $relativeImagePath = str_replace(url('storage'), 'storage', $product->filepath);
                $usedFilepaths[] = $relativeImagePath;
            }
        }

        // Lấy tất cả các ảnh trong thư mục lưu trữ
        $allImages = Storage::disk('san_pham_images')->allFiles();
        $allFilepath = Storage::disk('san_pham_filepath')->allFiles();

        // Mảng để lưu trữ các tên ảnh đã được sử dụng mà không xét đến kích thước
        $baseFilenames = [];
        $baseFilepath = [];

        foreach ($usedImages as $imageUrl) {
            // Tách lấy tên tệp từ URL
            $filename = basename($imageUrl); // lấy ra tên tệp như "card.jpg"
            $baseFilenames[] = $filename;
        }

        foreach ($allImages as $image) {
            // Lấy tên cơ bản của ảnh hiện tại trong thư mục
            $currentFilename = basename($image);

            // Kiểm tra xem tên tệp hiện tại có trong danh sách tên ảnh đang sử dụng không
            if (!in_array($currentFilename, $baseFilenames)) {
                // Nếu tên tệp không được sử dụng, xóa nó
                Storage::disk('san_pham_images')->delete($image);
                $this->info("Đã xóa ảnh không sử dụng: $image");
            }
        }

        // Xử lý file
        foreach ($usedFilepaths as $filepath) {
            $filename = basename($filepath);
            $baseFilepath[] = $filename;
        }

        foreach ($allFilepath as $file) {
            $currentFilename = basename($file);
            // $this->info("Đang kiểm tra file: $currentFilename");
            if (!in_array($currentFilename, $baseFilepath)) {
                // $this->info("File này không nằm trong danh sách đang sử dụng: $currentFilename");
                Storage::disk('san_pham_filepath')->delete($file);
                $this->info("Đã xóa file không sử dụng: $file");
            }
        }

        $this->info('Hoàn thành việc xóa ảnh và file không sử dụng!');
    }
}
