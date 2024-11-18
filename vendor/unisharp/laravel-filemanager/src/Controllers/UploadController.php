<?php

namespace UniSharp\LaravelFilemanager\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use UniSharp\LaravelFilemanager\Lfm;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class UploadController extends LfmController
{
    protected $errors;

    public function __construct()
    {
        parent::__construct();
        $this->errors = [];
    }

    /**
     * Upload files
     *
     * @param void
     *
     * @return JsonResponse
     */

    // UploadController trong lfm
    public function upload()
    {
        $uploaded_files = request()->file('upload');
        $error_bag = [];
        $new_filename = null;

        foreach (is_array($uploaded_files) ? $uploaded_files : [$uploaded_files] as $file) {
            try {
                // Kiểm tra MIME type của file
                $mimeType = $file->getMimeType();
                $validImageMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp']; // Các loại MIME của ảnh

                $this->lfm->validateUploadedFile($file);
                $new_filename = $this->lfm->upload($file);

                // Chỉ tạo ảnh kích thước nhỏ hơn nếu là ảnh
                // Thêm điều kiện
                if (in_array($mimeType, $validImageMimes)) {
                    $this->generateResizedImages($new_filename);
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
                array_push($error_bag, $e->getMessage());
            }
        }

        if (is_array($uploaded_files)) {
            $response = count($error_bag) > 0 ? $error_bag : parent::$success_response;
        } else { // upload via ckeditor5 expects json responses
            if (is_null($new_filename)) {
                $response = [
                    'error' => ['message' =>  $error_bag[0]]
                ];
            } else {
                $url = $this->lfm->setName($new_filename)->url();

                $response = [
                    'url' => $url,
                    'uploaded' => $url
                ];
            }
        }

        return response()->json($response);
    }
    protected function isUploadFromCkeditor()
    {
        // Kiểm tra các trường cụ thể trong request
        return request()->has('CKEditor') && request()->has('CKEditorFuncNum');
    }
    // Hàm tạo các ảnh kích thước nhỏ hơn
    protected function generateResizedImages($filename)
    {
        // Đường dẫn tới file gốc
        $originalPath = $this->lfm->setName($filename)->path('absolute');
        $baseDirectory = dirname($originalPath); // Đường dẫn tới thư mục chứa ảnh
        if (file_exists($originalPath)) {
            $sizes = [
                'small' => 240,  // Chiều rộng 240px
                'medium' => 320, // Chiều rộng 320px
                'large' => 460,  // Chiều rộng 480px
                'w_560' => 560,
                'w_640' => 640
            ];
            // Kiểm tra thư mục chứa ảnh
            switch ($baseDirectory) {
                case "C:\\xampp\\htdocs\\Project\\nvidia\\storage\\app/public\\images":
                    // Xử lý cho thư mục images
                    break;
                case "C:\\xampp\\htdocs\\Project\\nvidia\\storage\\app/public\\images\\danh-muc":
                    // Xử lý cho thư mục danh-muc
                    break;
                case "C:\\xampp\\htdocs\\Project\\nvidia\\storage\\app/public\\images\\san-pham":
                    // Xử lý cho thư mục san-pham
                    break;
                case "C:\\xampp\\htdocs\\Project\\nvidia\\storage\\app/public\\images\\bai-viet":
                    // Xử lý cho thư mục bai-viet
                    break;
                default:
                    // Xử lý cho các thư mục khác
                    $sizes = []; // Nếu thư mục không thuộc các thư mục trên
                    break;
            }

            // còn không phải thì $sizes = ơ
            // Tách tên file và phần mở rộng
            $pathInfo = pathinfo($originalPath);
            $filename = $pathInfo['filename']; // Tên file (không có phần mở rộng)
            $extension = $pathInfo['extension']; // Phần mở rộng

            foreach ($sizes as $size => $width) {
                // Tạo thư mục nếu chưa tồn tại
                $sizeDirectory = $baseDirectory . '/' . $size;
                if (!File::exists($sizeDirectory)) {
                    File::makeDirectory($sizeDirectory, 0755, true);
                }

                // Tạo đối tượng ảnh từ file gốc
                $image = Image::make($originalPath)->sharpen(10);

                // Thay đổi kích thước ảnh
                $image->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio(); // Giữ nguyên tỷ lệ
                    $constraint->upsize(); // Không phóng to hơn kích thước gốc
                });

                // Tạo đường dẫn mới cho ảnh với kích thước đã thay đổi
                $sizePath = $sizeDirectory . '/' . $filename . '.' . $extension;

                // Lưu ảnh mới vào đường dẫn vừa tạo
                $image->save($sizePath, 100);
            }
        }
    }
}
