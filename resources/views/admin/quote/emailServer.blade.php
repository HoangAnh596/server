<h2>Yêu cầu nhận báo giá từ sản phẩm <a href="{{ asset($data['slug']) }}">{{ $data['code'] }}</a></h2>
<h3>Thông tin người nhận báo giá</h3>
<p><strong>Họ tên:</strong> {{ $data['name'] }}</p>
<p><strong>Số điện thoại:</strong> {{ $data['phone'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Ghi chú:</strong> {{ $data['note_conf'] }}</p>
<h3>Tùy chỉnh cấu hình:</h3>
<ul>
    @foreach ($data['customize_conf'] as $conf)
        <li>{!! nl2br(e($conf)) !!}</li>
    @endforeach
</ul>
<p>Xin cảm ơn quý khách đã liên hệ nhận báo giá về sản phẩm <a href="{{ asset($data['slug']) }}">{{ $data['code'] }}</a>, chúng tôi sẽ liên hệ và gửi thông tin báo giá về sản phẩm <a href="{{ asset($data['slug']) }}">{{ $data['code'] }}</a> ngay sau ạ</p>
