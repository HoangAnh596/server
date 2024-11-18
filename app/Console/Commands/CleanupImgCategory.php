<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupImgCategory extends Command
{
    protected $signature = 'cleanup:category-img';
    protected $description = 'Xóa ảnh không được sử dụng trong nội dung CKEditor';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Lấy tất cả bài viết có nội dung CKEditor
        $categoriesItems  = Category::all();

        // Mảng để lưu trữ tất cả các đường dẫn ảnh đang được sử dụng
        $usedImages = [];

        foreach ($categoriesItems  as $cates) {
            // Trích xuất URL ảnh từ nội dung
            preg_match_all('/<img.*?src=["\'](.*?)["\']/', $cates->content, $matches);

            // Thêm tất cả URL ảnh tìm thấy vào mảng ảnh đang được sử dụng
            if (!empty($matches[1])) {
                foreach ($matches[1] as $url) {
                    // Chuyển URL thành đường dẫn tương đối
                    $relativePath = str_replace(url('storage'), 'storage', $url);
                    $usedImages[] = $relativePath;
                }
            }

            // Lấy đường dẫn ảnh từ trường image của bảng category
            if (!empty($cates->image)) {
                // Chuyển đường dẫn ảnh thành đường dẫn tương đối
                $relativeImagePath = str_replace(url('storage'), 'storage', $cates->image);
                $usedImages[] = $relativeImagePath;
            }
        }

        // Lấy tất cả các ảnh trong thư mục lưu trữ
        $allImages = Storage::disk('danh_muc_images')->allFiles();

        // Mảng để lưu trữ các tên ảnh đã được sử dụng mà không xét đến kích thước
        $baseFilenames = [];

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
                Storage::disk('danh_muc_images')->delete($image);
                $this->info("Đã xóa ảnh không sử dụng: $image");
            }
        }

        $this->info('Hoàn thành việc xóa ảnh không sử dụng!');
    }
}
