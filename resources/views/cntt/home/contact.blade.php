@extends('cntt.layouts.app')
@section('content')

<div class="container pt-44 bg-white">
    <div class="text-center pt-4">
        <div class="contact-us">
            <h1>THÔNG TIN LIÊN HỆ HỢP TÁC</h1>
            <h2>CÔNG TY TNHH CÔNG NGHỆ VIỆT THÁI DƯƠNG</h2>
            <div class="detail-company">
                <p><strong><i class="fa-solid fa-location-dot"></i> Văn phòng Hà Nội:</strong> NTT03, Line 1, Thống Nhất Complex, 82 Nguyễn Tuân, Thanh Xuân, <b>Hà Nội</b>.<a title="Chỉ đường đến Nvidiavn.vn" href="https://maps.app.goo.gl/SxF2f77WJn847cZt6" target="_blank" rel="noopener noreferrer"><i class="directions"></i></a></p>
                <p><strong><i class="fa-solid fa-location-dot"></i> Văn phòng HCM:</strong> <i class="maphcm"></i> Số 31B, Đường 1, Phường An Phú, Quận 2 (Thủ Đức), <b>TP HCM</b>.<a title="Chỉ đường đến Nvidiavn.vn" href="https://maps.app.goo.gl/WW9YF3BVn5okoRfT6" target="_blank" rel="noopener noreferrer"><i class="directions"></i></a></p>
                <p><strong><i class="fa-solid fa-phone-volume"></i> Điện thoại:</strong> (024) 62592244</p>
                <p><strong><i class="fa fa-envelope" aria-hidden="true"></i> Email: </strong>kd@cnttshop.vn</p>
                <p><strong>Mã số thuế:</strong> 0101590267</p>
                <p>(Do Sở Kế hoạch và Đầu tư Thành Phố Hà Nội Cấp ngày 17/12/2004)</p>
            </div>
            <div class="des-contact">
                <strong>Công ty TNHH công nghệ Việt Thái Dương</strong> chuyên phân phối thiết bị mạng <strong>CISCO, MikroTik, Maipu, FORTINET, Allied Telesis, Teltonika, Scodeno, HPE, JUNIPER, RUCKUS, ARUBA, CAMBIUM, UNIFI...</strong> Chính hãng, giá tốt nhất thị trường.
            </div>
        </div>
        @if($contacts->has(0))
        <div class="contact-list mt-3">
            <h4>
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                <span>PHÒNG KINH DOANH</span>
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
            </h4>
            <span class="decor"></span>
        </div>
        <div class="row mt-3">
            @foreach($contacts[0] as $val) <!-- Nhóm role = 0 -->
            <div class="col-md-3">
                <div class="box-contact-list">
                    <img loading="lazy" width="284" height="284" data-src="{{ asset($val->image) }}" src="{{ asset($val->image) }}" srcset="{{ asset($val->image) }}" alt="Hình ảnh của {{ $val->name }}" title="Hình ảnh của {{ $val->name }}">
                    <div class="caption">
                        <p class="title-caption">{{ $val->desc_role }}</p>
                        <p class="name-caption"><strong>{{ $val->name }}</strong> @if(!empty($val->title)) ({{ $val->title }}) @endif</p>
                        <p>- Tel: <a href="tel:{{ $val->phone }}">{{ $val->phone }}</a></p>
                        <p>- Email: <a target="_blank" href="https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to={{ $val->gmail }}" title="Gửi mail tới: {{ $val->name }}">{{ $val->gmail }}</a></p>
                        <p>- Skype: <a href="skype:{{ $val->skype }}?chat">{{ $val->skype }}</a></p>
                        <p>- Zalo: <a href="zalo:{{ $val->phone }}?chat">{{ $val->phone }}</a></p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if($contacts->has(3))
        <div class="contact-list mt-3">
            <h4>
                <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>
                <span>PHÒNG KINH DOANH MÁY CHỦ SERVE</span>
                <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>
            </h4>
            <span class="decor"></span>
        </div>
        <div class="row mt-3">
            @foreach($contacts[3] as $val) <!-- Nhóm role = 0 -->
            <div class="col-md-3">
                <div class="box-contact-list">
                    <img loading="lazy" width="284" height="284" data-src="{{ asset($val->image) }}" src="{{ asset($val->image) }}" srcset="{{ asset($val->image) }}" alt="Hình ảnh của {{ $val->name }}" title="Hình ảnh của {{ $val->name }}">
                    <div class="caption">
                        <p class="title-caption">{{ $val->desc_role }}</p>
                        <p class="name-caption"><strong>{{ $val->name }}</strong> @if(!empty($val->title)) ({{ $val->title }}) @endif</p>
                        <p>- Tel: <a href="tel:{{ $val->phone }}">{{ $val->phone }}</a></p>
                        <p>- Email: <a target="_blank" href="https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to={{ $val->gmail }}" title="Gửi mail tới: {{ $val->name }}">{{ $val->gmail }}</a></p>
                        <p>- Skype: <a href="skype:{{ $val->skype }}?chat">{{ $val->skype }}</a></p>
                        <p>- Zalo: <a href="zalo:{{ $val->phone }}?chat">{{ $val->phone }}</a></p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if($contacts->has(2))
        <div class="contact-list mt-3">
            <h4>
                <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>
                <span>PHÒNG KINH DOANH DỰ ÁN</span>
                <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>
            </h4>
            <span class="decor"></span>
        </div>
        <div class="row mt-3">
            @foreach($contacts[2] as $val) <!-- Nhóm role = 0 -->
            <div class="col-md-3">
                <div class="box-contact-list">
                    <img loading="lazy" width="284" height="284" data-src="{{ asset($val->image) }}" src="{{ asset($val->image) }}" srcset="{{ asset($val->image) }}" alt="Hình ảnh của {{ $val->name }}" title="Hình ảnh của {{ $val->name }}">
                    <div class="caption">
                        <p class="title-caption">{{ $val->desc_role }}</p>
                        <p class="name-caption"><strong>{{ $val->name }}</strong> @if(!empty($val->title)) ({{ $val->title }}) @endif</p>
                        <p>- Tel: <a href="tel:{{ $val->phone }}">{{ $val->phone }}</a></p>
                        <p>- Email: <a target="_blank" href="https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to={{ $val->gmail }}" title="Gửi mail tới: {{ $val->name }}">{{ $val->gmail }}</a></p>
                        <p>- Skype: <a href="skype:{{ $val->skype }}?chat">{{ $val->skype }}</a></p>
                        <p>- Zalo: <a href="zalo:{{ $val->phone }}?chat">{{ $val->phone }}</a></p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if($contacts->has(1))
        <div class="contact-list mt-3">
            <h4>
                <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>
                <span>PHÒNG KỸ THUẬT</span>
                <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>
            </h4>
            <span class="decor"></span>
        </div>
        <!-- Hiển thị danh sách những người có role = 1 -->
        <div class="row mt-3">
            @foreach($contacts[1] as $val) <!-- Nhóm role = 1 -->
            <div class="col-md-3">
                <div class="box-contact-list">
                    <img loading="lazy" width="284" height="284" data-src="{{ asset($val->image) }}" src="{{ asset($val->image) }}" srcset="{{ asset($val->image) }}" alt="Hình ảnh của {{ $val->name }}" title="Hình ảnh của {{ $val->name }}">
                    <div class="caption">
                        <p class="title-caption">{{ $val->desc_role }}</p>
                        <p class="name-caption"><strong>{{ $val->name }}</strong> @if(!empty($val->title)) ({{ $val->title }}) @endif</p>
                        <p>- Tel: <a href="tel:{{ $val->phone }}">{{ $val->phone }}</a></p>
                        <p>- Email: <a target="_blank" href="https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to={{ $val->gmail }}" title="Gửi mail tới: {{ $val->name }}">{{ $val->gmail }}</a></p>
                        <p>- Skype: <a href="skype:{{ $val->skype }}?chat">{{ $val->skype }}</a></p>
                        <p>- Zalo: <a href="zalo:{{ $val->phone }}?chat">{{ $val->phone }}</a></p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if($contacts->has(4))
        <div class="contact-list mt-3">
            <h4>
                <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>
                <span>PHÒNG KẾ TOÁN</span>
                <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>
            </h4>
            <span class="decor"></span>
        </div>
        <!-- Hiển thị danh sách những người có role = 4 -->
        <div class="row mt-3">
            @foreach($contacts[4] as $val) <!-- Nhóm role = 4 -->
            <div class="col-md-3">
                <div class="box-contact-list">
                    <img loading="lazy" width="284" height="284" data-src="{{ asset($val->image) }}" src="{{ asset($val->image) }}" srcset="{{ asset($val->image) }}" alt="Hình ảnh của {{ $val->name }}" title="Hình ảnh của {{ $val->name }}">
                    <div class="caption">
                        <p class="title-caption">{{ $val->desc_role }}</p>
                        <p class="name-caption"><strong>{{ $val->name }}</strong> @if(!empty($val->title)) ({{ $val->title }}) @endif</p>
                        <p>- Tel: <a href="tel:{{ $val->phone }}">{{ $val->phone }}</a></p>
                        <p>- Email: <a target="_blank" href="https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to={{ $val->gmail }}" title="Gửi mail tới: {{ $val->name }}">{{ $val->gmail }}</a></p>
                        <p>- Skype: <a href="skype:{{ $val->skype }}?chat">{{ $val->skype }}</a></p>
                        <p>- Zalo: <a href="zalo:{{ $val->phone }}?chat">{{ $val->phone }}</a></p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

@endsection