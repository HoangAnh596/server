@section('css')
<link rel="stylesheet" href="{{ asset('cntt/css/blog.css') }}">
<link rel="stylesheet" href="{{asset('cntt/css/content.css')}}">
@endsection

@extends('cntt.layouts.app')
@section('content')
<div class="pt-44">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '»';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ asset('/blogs') }}">Blogs</a></li>
                @foreach ($allParents as $parent)
                <li class="breadcrumb-item"><a href="{{ asset('/blogs/' . $parent->slug) }}">{{ $parent->name }}</a></li>
                @endforeach
                <li class="breadcrumb-item"><a href="{{ asset('/blogs/' . $titleCate->slug) }}">{{ $titleCate->name }}</a></li>
                <li class="breadcrumb-item">{{ $newArt->name }}</li>
            </ol>
        </nav>
    </div>
</div>
<section id="news-list">
    <div class="container">
        <div class="row mt-3 mb-3">
            <div class="col-lg-8">
                <div class="news-body">
                    <h1>{{ $newArt->name }}</h1>
                    <div class="author_meta mb-3">
                        <span class="entry-date">{{ $newArt->created_at->format('F d, Y') }}</span>
                        <span class="meta-sep">by</span>
                        <span class="author vcard">
                            @if(!empty($newArt->user))
                            <a class="url fn n" href="{{ asset('/blogs/author/' . $newArt->user->slug) }}" title="Author {{ $newArt->user->name }}">{{ $newArt->user->name }}</a>
                            @else Unknown
                            @endif
                        </span>
                        @if(!empty($newArt->view_count))
                        <span class="view-count"><i class="fa-solid fa-eye"></i> {{ $newArt->view_count }}</span>
                        @endif
                    </div>
                    <div id="chi-tiet">
                        {!! $newArt->content !!}
                    </div>
                </div>
                <!-- Bình luận -->
                <div class="wrap-tab-comments mt-4" id="comment-box">
                    <div class="comment-write" id="rate-box">
                        <h3>Bình luận bài viết!</h3>
                        <div class="form-comment">
                            <form id="rate-form" method="post">
                                <input type="hidden" id="idUser" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" id="idNew" name="new_id" value="{{ $newArt->id }}">
                                <input type="hidden" id="slugNew" name="slugNew" value="{{ $newArt->slug }}">
                                <input type="hidden" id="parent_id" name="parent_id">
                                <div class="input-account-form cmt-content-form">
                                    <textarea title="Nhập nội dung bình luận / nhận xét" name="content" id="comment-content" placeholder="Nhập câu hỏi / bình luận / nhận xét tại đây..." class="info-form-comment"></textarea>
                                    <span id="content-error" style="color: red;"></span>
                                    <span>
                                        Bạn đang băn khoăn cần tư vấn? Vui lòng để lại số điện thoại hoặc lời nhắn, nhân viên Nvidiavn.vn sẽ liên hệ trả lời bạn sớm nhất.
                                    </span>
                                </div>
                                <div class="input-account-form mt-2" id="review-info-pad">
                                    <div id="review-info" style="display: none">
                                        <p>Cung cấp thông tin cá nhân</p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Họ và tên:</label>
                                                    <input type="text" name="name" id="comment-name" class="form-control" value="{{ old('name') }}" placeholder="Nhập tên của bạn">
                                                    <span id="name-error" style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email:</label>
                                                    <input type="text" name="email" id="comment-email" class="form-control" value="{{ old('email') }}" placeholder="Địa chỉ email - không bắt buộc">
                                                    <span id="email-error" style="color: red;"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rate-stars-row">
                                        <span class="form-item-title">Đánh giá:</span>
                                        <div class="prod-rate">
                                            <fieldset class="rating">
                                                <input type="radio" class="rate-poin-rdo" data-point="1" id="star1" name="rating" value="1">
                                                <label class="full" for="star1" title="Thất vọng: cho 1 sao">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                    </svg>
                                                </label>
                                                <input type="radio" class="rate-poin-rdo" data-point="2" id="star2" name="rating" value="2">
                                                <label class="full" for="star2" title="Trung bình: cho 2 sao">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                    </svg>
                                                </label>
                                                <input type="radio" class="rate-poin-rdo" data-point="3" id="star3" name="rating" value="3">
                                                <label class="full" for="star3" title="Bình thường: cho 3 sao">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                    </svg>
                                                </label>
                                                <input type="radio" class="rate-poin-rdo" data-point="4" id="star4" name="rating" value="4">
                                                <label class="full" for="star4" title="Hài lòng: cho 4 sao">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                    </svg>
                                                </label>
                                                <input type="radio" class="rate-poin-rdo" data-point="5" id="star5" name="rating" value="5">
                                                <label class="full" for="star5" title="Rất hài lòng: cho 5 sao">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                    </svg>
                                                </label>
                                            </fieldset>
                                            <div class="rate-stars">
                                                <input type="hidden" id="rate-record" name="rate-record" value="0">
                                                <input type="text" id="rate-point" name="rate-point" style="position: absolute; left: -2000px" title="Bạn cho sản phẩm này bao nhiêu ★">
                                            </div>
                                        </div>
                                    </div>
                                    <p class="p-close"><button id="send-comment" class="link-close">Gửi bình luận</button></p>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="rate-reviews" class="box-view-comments">
                        <span class="countcomments">Có {{ $totalCommentsCount }} bình luận:</span>
                        <div id="rate-reviews-list">
                            @if(!empty($sendCmt))
                            @include('cntt.home.blogs.partials.cmt', ['sendCmt' => $sendCmt])
                            @endif
                        </div>
                        @include('cntt.home.blogs.partials.comment', ['comments' => $comments, 'user' => $user])
                        <nav class="d-flex justify-content-center mt-2 paginate-cmt">
                            {{ $comments->links() }}
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!--  -->
                <div class="head-blog bgeee mb-3">
                    <span>Chuyên mục chính</span>
                </div>
                <ul class="news_cate_hot">
                    @foreach($cateMenu as $val)
                    <li>
                        <a href="{{ asset('blogs/'.$val->slug) }}"><span style="font-weight: bold;">✓</span> {{ $val->name }}</a>
                    </li>
                    @endforeach
                </ul>
                @if(!$sameCate->isEmpty())
                <!-- Bài viết cùng danh mục -->
                <div class="head-blog bgeee mb-3">
                    <span>Bài viết cùng danh mục</span>
                </div>
                <div class="hot-news">
                    @foreach($sameCate as $val)
                    <div class="media">
                        <div class="media-left img-border">
                            <a href="{{ asset('blogs/'.$val->slug) }}">
                                <img loading="lazy" width="146" height="99" src="{{ asset(str_replace('bai-viet/', 'bai-viet/small/', $val->image)) }}" data-src="{{ asset(str_replace('bai-viet/', 'bai-viet/small/', $val->image)) }}" srcset="{{ asset(str_replace('bai-viet/', 'bai-viet/small/', $val->image)) }}" alt="{{ $val->alt_img }}" title="{{ $val->title_img }}">
                            </a>
                        </div>
                        <div class="media-right">
                            <a href="{{ asset('blogs/'.$val->slug) }}">{{ $val->name }}</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                <!-- Sản phẩm liên quan -->
                @if(!empty($relatedPro))
                <div class="head-blog bgeee mb-3">
                    <span>Sản phẩm liên quan</span>
                </div>
                <div class="related-products">
                    @foreach($relatedPro as $value)
                    <div class="media-products">
                        <div class="media-left img-border">
                            <a href="{{ asset('/'.$value->slug) }}">
                                @if($value->main_image)
                                <img class="thumb ls-is-cached lazyloaded" data-src="{{ asset($value->main_image->image) }}"
                                    alt="{{ $value->main_image->alt }}" title="{{ $value->main_image->title }}" src="{{ asset($value->main_image->image) }}">
                                @else
                                <img class="thumb ls-is-cached lazyloaded"
                                    data-src="{{ asset('storage/images/image-coming-soon.jpg') }}" alt="Image Coming Soon" title="Image Coming Soon"
                                    src="{{ asset('storage/images/image-coming-soon.jpg') }}">
                                @endif
                            </a>
                        </div>
                        <div class="media-right">
                            <a href="{{ asset('/'.$value->slug) }}">{{ $value->name }}</a>
                            <span class="new-price">Liên hệ</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const tocLinks = document.querySelectorAll('#chi-tiet a[href^="#"]');

        tocLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // Ngăn chặn hành động cuộn mặc định

                const targetId = this.getAttribute('href').substring(1); // Lấy id của mục tiêu
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    // Tính toán vị trí của phần tử so với top của trang
                    const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
                    // Offset để cuộn lên trên một chút (giả sử là 50px)
                    const offsetPosition = elementPosition - 50;

                    // Cuộn đến vị trí đã tính toán
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });


    // Chức năng comments
    $(document).ready(function() {
        function bindCommentFormEvents() {
            document.querySelectorAll('.rate-poin-rdo').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    let value = this.value;

                    // Reset fill for all stars
                    document.querySelectorAll('.rating label svg').forEach(function(star) {
                        star.style.fill = '#ddd';
                    });

                    // Fill stars up to the selected one
                    for (let i = 1; i <= value; i++) {
                        document.querySelector('#star' + i + ' ~ label svg').style.fill = '#ffc107';
                    }
                });
            });

            $('.reply-btn').on('click', function(e) {
                e.preventDefault();
                let commentId = $(this).data('comment-id');

                // Kiểm tra phần tử có được tìm thấy không
                let targetForm = $(`.reply-form[data-comment-id="${commentId}"]`);
                // Kiểm tra nếu form đang ẩn, thì hiển thị và ẩn tất cả các form khác
                if (targetForm.is(':hidden')) {
                    $('.reply-form').hide(); // Ẩn tất cả các form khác
                    targetForm.show(); // Hiển thị form tương ứng với comment ID
                } else {
                    // Nếu form đang hiển thị, thì ẩn nó đi
                    targetForm.hide();
                }
            });

            // Xử lý khi nhấn nút close-cmt
            $('.close-cmt').on('click', function() {
                // Tìm form reply gần nhất và ẩn nó
                $(this).closest('.reply-form').hide();
            });

            // Khi nhấn nút gửi bình luận trong form trả lời
            $(document).on('click', '.submit-reply', function(e) {
                e.preventDefault();
                var isValid = true;

                // Lấy form hiện tại
                var form = $(this).closest('form');

                // Lấy giá trị của các trường trong form hiện tại
                var replyCmtContent = form.find('.reply-cmt-content').val().trim();
                var replyCmtName = form.find('.reply-cmt-name').val().trim();
                var replyCmtEmail = form.find('.reply-cmt-email').val().trim();

                // Xóa các thông báo lỗi cũ
                form.find('.rpl-name-err').text('');
                form.find('.rpl-email-err').text('');
                form.find('.rpl-content-err').text('');
                form.find('.reply-cmt-content').css('border-color', '');
                form.find('.reply-cmt-name').css('border-color', '');
                form.find('.reply-cmt-email').css('border-color', '');

                // Kiểm tra trường reply-cmt-content
                if (replyCmtContent === '') {
                    form.find('.rpl-content-err').text('Nội dung bình luận / nhận xét không được để trống.');
                    form.find('.reply-cmt-content').css('border-color', 'red').focus();
                    isValid = false;
                }

                // Kiểm tra trường reply-cmt-name
                if (replyCmtName === '') {
                    form.find('.rpl-name-err').text('Họ và tên không được để trống.');
                    form.find('.reply-cmt-name').css('border-color', 'red').focus();
                    isValid = false;
                }

                // Kiểm tra trường reply-cmt-email
                if (replyCmtEmail === '') {
                    form.find('.rpl-email-err').text('Email không được để trống.');
                    form.find('.reply-cmt-email').css('border-color', 'red').focus();
                    isValid = false;
                } else if (!validateEmail(replyCmtEmail)) {
                    form.find('.rpl-email-err').text('Email không đúng định dạng.');
                    form.find('.reply-cmt-email').css('border-color', 'red').focus();
                    isValid = false;
                }

                // Nếu không có lỗi, gọi AJAX để lưu bình luận
                if (isValid) {
                    $.ajax({
                        url: '{{ route("cmtNews.replyCmt") }}', // Sử dụng URL từ Laravel route
                        method: 'POST',
                        data: {
                            new_id: $('#idNew').val(),
                            slugNew: $('#slugNew').val(),
                            user_id: $('#idUser').val(),
                            parent_id: form.find('#reply-cmt-parent').val(),
                            content: replyCmtContent,
                            name: replyCmtName,
                            email: replyCmtEmail,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                // Xóa các giá trị của form sau khi gửi thành công
                                form.find('.reply-cmt-content').val('');
                                form.find('.reply-cmt-name').val('');
                                form.find('.reply-cmt-email').val('');
                                form.find('#reply-cmt-parent').val('');

                                // Chèn phần bình luận trả lời ngay phía dưới form trả lời
                                form.after(response.comment_html);

                                // Cập nhật số lượng bình luận
                                var countElement = $('.countcomments');
                                var currentCount = parseInt(countElement.text().match(/\d+/)[0]); // Lấy số lượng bình luận hiện tại
                                countElement.text('Có ' + (currentCount + 1) + ' bình luận:'); // Cập nhật số lượng bình luận
                                form.hide(); // Ẩn form đã gửi thành công
                                toastr.success('Cập nhật thành công! Vui lòng đợi phản hồi từ Admin', 'Thành công', {
                                    progressBar: true,
                                    closeButton: true,
                                    timeOut: 10000
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error('Đã xảy ra lỗi khi gửi bình luận.', 'Lỗi', {
                                progressBar: true,
                                closeButton: true,
                                timeOut: 5000
                            });
                        }
                    });
                }
            });

            // Hàm kiểm tra định dạng email
            function validateEmail(email) {
                var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            $('#send-comment').on('click', function(event) {
                event.preventDefault(); // Ngăn chặn form submit

                var isValid = true;

                // Lấy giá trị của các trường
                var cmtContent = $('#comment-content').val().trim();
                var cmtName = $('#comment-name').val().trim();
                var cmtEmail = $('#comment-email').val().trim();
                var cmtRate = $('input[name="rating"]:checked').val();

                // Xóa các thông báo lỗi cũ
                $('#name-error').text('');
                $('#email-error').text('');
                $('#content-error').text('');
                $('#comment-content').css('border-color', '');
                $('#comment-name').css('border-color', '');
                $('#comment-email').css('border-color', '');

                // Kiểm tra trường comment-content
                if (cmtContent === '') {
                    $('#content-error').text('Nội dung bình luận / nhận xét không được để trống.');
                    $('#comment-content').css('border-color', 'red').focus();
                    isValid = false;
                }

                // Kiểm tra trường comment-name
                if (cmtName === '') {
                    $('#name-error').text('Họ và tên không được để trống.');
                    $('#comment-name').css('border-color', 'red').focus();
                    isValid = false;
                }

                // Kiểm tra trường comment-email
                if (cmtEmail === '') {
                    $('#email-error').text('Email không được để trống.');
                    $('#comment-email').css('border-color', 'red').focus();
                    isValid = false;
                } else if (!validateEmail(cmtEmail)) {
                    $('#email-error').text('Email không đúng định dạng.');
                    $('#comment-email').css('border-color', 'red').focus();
                    isValid = false;
                }

                $('#review-info').show();
                // Nếu không có lỗi, gọi AJAX để lưu bình luận
                if (isValid) {
                    // Disable nút gửi để ngăn chặn việc nhấn nhiều lần
                    $('#send-comment').prop('disabled', true);
                    $.ajax({
                        url: '{{ route("cmtNews.sendCmt") }}', // Sử dụng URL từ Laravel route
                        method: 'POST',
                        data: {
                            new_id: $('#idNew').val(),
                            user_id: $('#idUser').val(),
                            slugNew: $('#slugNew').val(),
                            parent_id: 0,
                            content: cmtContent,
                            name: cmtName,
                            email: cmtEmail,
                            star: cmtRate,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                // Xóa các giá trị của form sau khi gửi thành công
                                $('#rate-reviews-list').prepend(response.comment_html);

                                // Cập nhật số lượng bình luận
                                var countElement = $('.countcomments');
                                var currentCount = parseInt(countElement.text().match(/\d+/)[0]); // Lấy số lượng bình luận hiện tại
                                countElement.text('Có ' + (currentCount + 1) + ' bình luận:'); // Cập nhật số lượng bình luận

                                $('#rate-form')[0].reset();
                                $('#review-info').hide();
                                $('#send-comment').prop('disabled', false);
                                toastr.success('Cập nhật thành công! Vui lòng đợi phản hồi từ Admin', 'Thành công', {
                                    progressBar: true,
                                    closeButton: true,
                                    timeOut: 10000
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error('Đã xảy ra lỗi khi gửi bình luận.', 'Lỗi', {
                                progressBar: true,
                                closeButton: true,
                                timeOut: 5000
                            });
                            $('#send-comment').prop('disabled', false);
                        }
                    });
                }
            });
        }
        // Phân trang bình luận
        function addPaginationListeners() {
            const paginationLinks = document.querySelectorAll('.paginate-cmt a');

            paginationLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.href;

                    fetch(url)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('app').innerHTML = html;
                            // Cuộn đến rate-reviews với một khoảng offset
                            var commentBox = document.getElementById('rate-reviews');
                            var offset = -50; // Điều chỉnh khoảng lệch để đảm bảo hiển thị tốt
                            var commentBoxPosition = commentBox.getBoundingClientRect().top + window.pageYOffset + offset;

                            // Cuộn đến vị trí đã điều chỉnh
                            window.scrollTo({
                                top: commentBoxPosition,
                                behavior: 'smooth'
                            });
                            // Gọi các sự kiện ban đầu
                            addPaginationListeners();
                            bindCommentFormEvents(); // Lắng nghe sự kiện cho form bình luận
                        })
                        .catch(error => console.error('Error loading page:', error));
                });
            });
        }
        // Gọi các sự kiện ban đầu
        addPaginationListeners();
        bindCommentFormEvents(); // Lắng nghe sự kiện cho form bình luận
    });
</script>
@endsection