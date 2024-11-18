@php
use Carbon\Carbon;

// Hàm ẩn thông tin nhạy cảm (sđt và email)
if (!function_exists('hideSensitiveData')) {
function hideSensitiveData($content) {
// Ẩn email
$content = preg_replace_callback('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', function ($matches) {
$email = $matches[0];
$emailParts = explode('@', $email);
$hiddenEmail = substr($emailParts[0], 0, 3) . '***@' . $emailParts[1];
return $hiddenEmail;
}, $content);

// Ẩn số điện thoại (10 chữ số)
$content = preg_replace('/(\d{4})([\.\-\s]?\d{3})[\.\-\s]?\d{3}/', '$1******', $content);

return $content;
}
}
@endphp
<div id="rate-reviews-list">
    @foreach($comments as $cmt)
    @php
    $time = Carbon::parse($cmt->created_at);
    $now = Carbon::now();
    // Áp dụng hàm để ẩn thông tin nhạy cảm
    $filteredContent = hideSensitiveData($cmt->content);
    @endphp
    <div class="review-row cmt-{{ $cmt->id }}" id="cmt-{{ $cmt->id }}">
        <div data-id="{{ $cmt->id }}" id="review-item-{{ $cmt->id }}" class="view-comments-item level-{{ $level ?? 1 }}" data-fname="{{ $cmt->name }}">
            <div class="bg-comments level-{{ $level ?? 1 }}">
                <div class="img-member-thumb">{{ strtoupper(mb_substr($cmt->name, 0, 1, 'UTF-8')) }}</div>
                <div class="name-member">{{ $cmt->name }} @if(!empty($cmt->user_id)) <b class="qtv">Quản trị viên</b> @endif
                    <span>
                        @if ($time->diffInMinutes($now) < 60)
                            {{ $time->diffInMinutes($now) }} phút trước
                            @elseif ($time->diffInHours($now) < 24)
                                {{ $time->diffInHours($now) }} giờ trước
                                @else
                                Ngày {{ $time->format('d-m-Y') }} lúc {{ $time->format('H:i') }}
                                @endif
                                </span>
                </div>
                <div class="star-rated" title="5 sao"><i class="i-star"></i></div>
                <div class="content-comments">{!! $filteredContent !!}</div>
                <div class="relate-comment">
                    <div class="comment-replay-like">
                        <span class="reply-btn" data-comment-id="{{ $cmt->id }}" title="trả lời comments"><i class="fa-solid fa-reply"></i> Trả lời</span>
                        <div class="relate-com-item like-comment"><i class="far fa-thumbs-up"></i> Thích</div>
                    </div>
                </div>
            </div>
            <form class="reply-form" method="post" data-comment-id="{{ $cmt->id }}">
                <input type="hidden" id="reply-cmt-parent" name="parent_id" value="{{ $cmt->id }}">
                <div class="input-account-form cmt-reply">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="infor-cmt">
                            <i class="fa-solid fa-reply"></i> Đang trả lời: <strong>{{ $cmt->name }}</strong>
                        </div>
                        <div class="close-cmt"><i class="fa-solid fa-xmark"></i></div>
                    </div>
                    <div class="cmt-content-form">
                        <textarea title="Nhập nội dung bình luận / nhận xét" name="reply-cmt-content" id="reply-cmt-content" placeholder="Nhập câu hỏi / bình luận / nhận xét tại đây..." class="info-form-comment reply-cmt-content"></textarea>
                        <span class="rpl-content-err" id="rpl-content-err" style="color: red;"></span>
                    </div>
                    <div id="review-info">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Họ và tên:</label>
                                    <input type="text" name="reply-cmt-name" id="reply-cmt-name" class="form-control reply-cmt-name" value="{{ old('name', $user->name ?? '') }}" placeholder="Nhập tên của bạn">
                                    <span class="rpl-name-err" id="rpl-name-err" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="text" name="reply-cmt-email" id="reply-cmt-email" class="form-control reply-cmt-email" value="{{ old('email', $user->email ?? '') }}" placeholder="Địa chỉ email - không bắt buộc">
                                    <span class="rpl-email-err" id="rpl-email-err" style="color: red;"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-row-reverse">
                        <button type="button" class="submit-reply" data-comment-id="{{ $cmt->id }}"><i class="fa-regular fa-paper-plane"></i></button>
                    </div>
                </div>
            </form>
            <div id="res-reply">
                @if(!empty($sendCmt))
                @include('cntt.home.partials.res-reply', ['sendCmt' => $sendCmt])
                @endif
            </div>
        </div>

        {{-- Gọi đệ quy cho các bình luận con --}}
        @if ($cmt->cmtChild->isNotEmpty())
        <div class="child-replies">
            @include('cntt.home.partials.comment', ['comments' => $cmt->cmtChild, 'level' => ($level ?? 1) + 1])
        </div>
        @endif
    </div>
    @endforeach
</div>