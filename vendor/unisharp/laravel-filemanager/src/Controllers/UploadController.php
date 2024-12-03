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
        // Lấy đường dẫn gốc của storage
        $storagePath = storage_path('app/public');

        // Tính đường dẫn tương đối so với storage
        $relativePath = str_replace($storagePath, '', dirname($originalPath));
        // Gán lại `$baseDirectory` cho phù hợp với cả local và server
        $baseDirectory = $storagePath . $relativePath;
        $relativePath = str_replace('\\', '/', $relativePath);
        if (file_exists($originalPath)) {
            $sizes = [
                'small' => 240,
                'medium' => 320,
                'large' => 460,
                'w_560' => 560,
                'w_640' => 640,
            ];
            // Kiểm tra thư mục chứa ảnh
            switch ($relativePath) {
                case "/images":
                    // Xử lý cho thư mục images
                    break;
                case "/images/danh-muc":
                    // Xử lý cho thư mục danh-muc
                    break;
                case "/images/san-pham":
                    // Xử lý cho thư mục san-pham
                    break;
                case "/images/bai-viet":
                    // Xử lý cho thư mục bai-viet
                    break;
                default:
                    $sizes = []; // Nếu thư mục không thuộc các thư mục trên
                    break;
            }

            // Phần xử lý resize ảnh không cần thay đổi
            $pathInfo = pathinfo($originalPath);
            $filename = $pathInfo['filename'];
            $extension = $pathInfo['extension'];

            foreach ($sizes as $size => $width) {
                $sizeDirectory = $baseDirectory . '/' . $size;
                if (!File::exists($sizeDirectory)) {
                    File::makeDirectory($sizeDirectory, 0755, true);
                }
        
                $image = Image::make($originalPath)->sharpen(10);
                $image->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
        
                $sizePath = $sizeDirectory . '/' . $filename . '.' . $extension;
                $image->save($sizePath, 100);
            }
        }
    }
}
