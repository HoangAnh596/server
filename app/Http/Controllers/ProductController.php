<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFormRequest;
use App\Models\Attributes;
use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;
use App\Models\ProductImages;
use App\Models\ProductTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // Tìm kiếm theo tên, mã code, danh mục sản phẩm
        $keyword = $request->keyword;
        $categoryId = $request->cate;
        $categoryIds = [];
        if (!empty($categoryId)) {
            $category = Category::where('id', $categoryId)->with('children')->first();
            $categoryIds = $category->getAllChildrenIds();
            array_unshift($categoryIds, $category->id); // Thêm ID danh mục chính vào danh sách
        }

        $products = Product::where(function ($query) use ($keyword) {
            $query->where('name', 'like', "%" . $keyword . "%")
                  ->orWhere('code', 'like', "%" . $keyword . "%")
                  ->orWhere('slug', 'like', "%" . $keyword . "%");
        })->when(!empty($categoryIds), function ($query) use ($categoryIds) {
            $query->whereHas('category', function ($q) use ($categoryIds) {
                $q->whereIn('category_id', $categoryIds);
            });
            $query->orWhere(function ($query) use ($categoryIds) {
                foreach ($categoryIds as $categoryId) {
                    $query->orWhereJsonContains('subCategory', (string)$categoryId);
                }
            });
        });

        $products = $products->with('category')->latest()->paginate(config('common.default_page_size'))->appends($request->except('page'));

        $categories = Category::where('parent_id', 0)
            ->with('children')
            ->get();

        return view('admin.product.index', compact('products', 'keyword', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id', 0)
            ->with('children')
            ->get();

        return view('admin.product.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductFormRequest $request)
    {
        $this->insertOrUpdate($request);

        return redirect(route('product.index'))->with(['message' => 'Tạo mới sản phẩm thành công']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $categories = Category::with('children')->where('parent_id', 0)->get();
        // Lấy ra sản phẩm liên quan
        $pro = Product::findOrFail($id);
        
        $images = $pro->getProductImages();
        $relatedProducts = $pro->getRelatedProducts();
        $productTags = $pro->getProductTags();
        
        return view('admin.product.edit', compact('product', 'categories', 'images' ,'relatedProducts', 'productTags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return back()->with(['message' => "Cập nhật sản phẩm thành công!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        // Chuyển đổi image_ids thành mảng (giả sử chúng là chuỗi JSON)
        $imageIds = json_decode($product->image_ids, true); // Hoặc explode(',', $product->image_ids) nếu là chuỗi phân tách bởi dấu phẩy

        // Xóa các ảnh trong bảng product_images
        if (is_array($imageIds)) {
            ProductImages::whereIn('id', $imageIds)->delete();
        }
        // Xóa comment
        Comment::where('product_id', $id)->delete();

        // Xóa sản phẩm
        $product->delete();

        return redirect(route('product.index'))->with(['message' => 'Xóa sản phẩm thành công']);
    }

    public function insertOrUpdate(ProductFormRequest $request, $id = '')
    {
        $product = empty($id) ? new Product() : Product::findOrFail($id);

        if(!empty($request['subCategory'])) {
            $request->merge(['subCategory' => $request->subCategory]);
        }
        if(!empty($request['related_pro'])) {
            $request['related_pro'] = json_encode($request->related_pro);
        }

        if(!empty($request['tag_ids'])) {
            $inputArray = $request->tag_ids;
            $numericArray = array_filter($inputArray, function($value) {
                return is_numeric($value);
            });
            
            // Chuyển mảng thành các giá trị số (không bắt buộc, nếu cần thiết)
            $numericArray = array_map('strval', $numericArray);
            
            // Đặt lại các khóa của mảng
            $numericArray = array_values($numericArray);
            $request['tag_ids'] = json_encode($numericArray);
        }

        $product->fill($request->all());

        $product->title_seo = (isset($request->title_seo)) ? $request->title_seo : $request->name;
        $product->keyword_seo = (isset($request->keyword_seo)) ? $request->keyword_seo : $request->name;
        $product->des_seo = (isset($request->des_seo)) ? $request->des_seo : $request->name;
        $product->user_id = Auth::id();

        // Thêm mới images con vào bảng Product_Images 
        $images = $request->input('image', []);
        $main_imgs = $request->input('main_img', []);
        $titles = $request->input('title', []);
        $alts = $request->input('alt', []);
        $stt_imgs = $request->input('stt_img', []);

        $idPrImage = [];

        for ($i = 0; $i < count($images); $i++) {
            // Tách lấy phần path từ URL
            $imagePath = parse_url($images[$i], PHP_URL_PATH);

            // Xóa dấu gạch chéo đầu tiên nếu cần thiết
            if (strpos($imagePath, '/') === 0) {
                $imagePath = substr($imagePath, 1);
            }

            $productImage = ProductImages::create([
                'title' => $titles[$i] ?? $request->name,
                'alt' => $alts[$i] ?? $request->name,
                'main_img' => $main_imgs[$i],
                'image' => $imagePath,
                'stt_img' => $stt_imgs[$i] ?? 999,
            ]);
            $idPrImage[] = $productImage->id;
        }
        if (!empty($idPrImage)) {
            // Kiểm tra nếu image_ids đã có dữ liệu thì merge, nếu không thì khởi tạo mới
            if (!empty($product->image_ids)) {
                $existingImageIds = json_decode($product->image_ids, true);
                $mergedImageIds = array_merge($existingImageIds, array_map('strval', $idPrImage));
                $product->image_ids = json_encode($mergedImageIds);
            } else {
                $product->image_ids = json_encode(array_map('strval', $idPrImage));
            }
        }

        $product->save();
        $product->category()->sync($request->category);
    }

    public function checkName(Request $request)
    {
        $name = $request->input('name');
        $slug = $request->input('slug');
        $id = $request->get('id');

        // Check if name exists, excluding the current product id
        // Kiểm tra xem tên có tồn tại không, ngoại trừ id danh mục hiện tại
        $nameExists = Product::where('name', $name)
            ->where('id', '!=', $id)
            ->exists();
        $slugExists = Category::where('slug', $slug)->exists() || Product::where('slug', $slug)->exists();

        return response()->json([
            'name_exists' => $nameExists,
            'slug_exists' => $slugExists
        ]);
    }

    public function checkCode(Request $request)
    {
        $code = $request->input('code');
        $id = $request->get('id');

        $codeExists = Product::where('code', $code)
            ->where('id', '!=', $id)
            ->exists();
        
        return response()->json([
            'code_exists' => $codeExists,
        ]);
    }

    public function search(Request $request)
    {
        $related_pro = [];
        if ($search = $request->name) {
            $related_pro = Product::where('name', 'LIKE', "%$search%")->get();
        }
        return response()->json($related_pro);
    }

    public function searchTags(Request $request)
    {
        $query = [];
        if ($search = $request->name) {
            $query = ProductTag::where('name', 'LIKE', "%$search%")->get();
        }
        return response()->json($query);
    }

    public function isCheckbox(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->is_outstand = $request->is_outstand;
        $product->save();

        return response()->json(['success' => true]);
    }
}
