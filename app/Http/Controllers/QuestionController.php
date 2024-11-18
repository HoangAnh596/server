<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionFormRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $categoryId = $request->cate;

        $questionsQuery = Question::query();
        if ($keyword) {
            $questionsQuery->where(function ($query) use ($keyword) {
                // Tìm kiếm từ khóa trong tên sản phẩm hoặc tên danh mục
                $query->whereHas('product', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%" . $keyword . "%");
                })->orWhereHas('category', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%" . $keyword . "%");
                });
            });
        }
        // Nếu có danh mục được chọn, thêm điều kiện lọc theo danh mục
        if ($categoryId) {
            $questionsQuery->where('cate_id', $categoryId);
        }
        $questions = $questionsQuery->latest()->paginate(config('common.default_page_size'))->appends($request->except('page'));
        $categories = Category::where('parent_id', 0)
        ->with('children')
        ->get();

        return view('admin.question.index', compact('questions', 'keyword', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $idCate = $request->cate_id;
        $idPro = $request->pro_id;

        $categories = Category::with('children')->where('parent_id', 0)->get();
        $products = Product::where('id', $idPro)->first();

        return view('admin.question.add', compact('idCate', 'categories', 'idPro', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionFormRequest $request)
    {
        $this->insertOrUpdate($request);

        return redirect(route('questions.index'))->with(['message' => 'Tạo mới thành công']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $categories = Category::with('children')->where('parent_id', 0)->get();
        $product = Product::where('id', $question->product_id)->first();
        
        return view('admin.question.edit', compact('question', 'categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionFormRequest $request, $id)
    {
        $this->insertOrUpdate($request, $id);

        return back()->with(['message' => "Cập nhật tin tức thành công !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Question::findOrFail($id)->delete();

        return redirect('admin/questions')->with(['message' => 'Xóa thành công']);
    }

    public function insertOrUpdate(Request $request, $id = '')
    {
        $question = empty($id) ? new Question() : Question::findOrFail($id);

        $question->fill($request->all());
        
        if(isset($request->cate_id)) {
            $question->cate_id = $request->cate_id;
            $question->product_id = 0;
        } else {
            $question->cate_id = 0;
            $question->product_id = $request->product_id;
        }

        $question->stt = (isset($request->stt)) ? $request->stt : 999;
        $question->user_id = Auth::id();
        
        $question->save();
    }

    public function checkStt(Request $request){
        $sttQuestion = $request->input('stt');
        if (!empty($sttQuestion)) {
            $request->validate([
                'stt' => 'integer|min:0'
            ]);
        }
        $id = $request->get('id');
        $question = Question::findOrFail($id);
        $question->stt = (isset($sttQuestion)) ? $sttQuestion : 999;
        $question->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật Stt thành công.']);
    }

    public function isCheckbox(Request $request)
    {
        $question = Question::findOrFail($request->id);
        $question->is_public = $request->is_public;
        $question->save();

        return response()->json(['success' => true]);
    }
}
