<?php

namespace App\Http\Controllers;

use App\Mail\PriceRequestMail;
use App\Models\Infor;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyWord = $request->input('keyword');
        $isStatus = $request->input('status');
        // Tạo query cơ bản
        $quotes = Quote::query();

        // Nếu $keyWord là số, tìm kiếm theo id chính xác
        if (is_numeric($keyWord)) {
            $quotes->where('id', $keyWord);
        } else {
            // Tìm kiếm theo name nếu $keyWord là chuỗi
            $quotes->where('name', 'like', "%" . $keyWord . "%");
        }

        // Áp dụng lọc theo trạng thái công khai nếu có giá trị
        if ($isStatus !== null) {
            $quotes->where('status', $isStatus);
        }

        // Thêm sắp xếp và phân trang
        $quotes = $quotes->latest()->paginate(config('common.default_page_size'));

        return view('admin.quote.index', compact('quotes', 'keyWord', 'isStatus'));
    }

    public function isCheckbox(Request $request)
    {
        $quote = Quote::findOrFail($request->id);

        if ($request->status == 1) {
            $quote->user_id = Auth::id();
        } else {
            $quote->user_id = 0;
        }
        $quote->status = $request->status;
        $quote->save();

        return response()->json(['success' => true]);
    }

    // Báo giá gửi mail
    public function sendRequest(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|min:8',
            'code' => 'required'
        ]);
        // Gửi mail
        try {
            $emails = Infor::where('send_price', 1)->pluck('gmail');
            $customerEmail = $request->email;
            // Mail::to('hoanganhhn596@gmail.com')->send(new PriceRequestMail($request->all()));
            if(!empty($emails)){
                foreach ($emails as $email) {
                    Mail::to($email)
                        ->cc($customerEmail) // Thêm địa chỉ email khách hàng vào CC
                        ->send(new PriceRequestMail($request->all()));
                }
        
            }
            // Lưu báo giá vào bảng quotes
            Quote::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'gmail' => $request->email,
                'product' => $request->code,
                'quantity' => $request->amount,
                'purpose' => $request->purpose
            ]);

            return response()->json(['success' => 'Yêu cầu báo giá đã được gửi thành công.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Đã xảy ra lỗi trong quá trình gửi yêu cầu.'], 500);
        }
    }
}
