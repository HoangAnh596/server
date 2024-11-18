<!-- Start Footer -->
<footer class="ft-black" id="tempaltemo_footer">
    <div class="container">
        <div class="row">
            @foreach ($globalFooters as $val)
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="page-footer">{{ $val->name }}</div>
                <ul class="list-unstyled footer-link">
                    @foreach ($val->children as $child)
                    <li><a class="text-decoration-none ft-link" @if($child->is_click == 1) href="{{ asset($child->url) }}" @else href="javascript:void(0)" @endif target="@if($child->is_tab == 1) _blank @endif">{{ $child->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endforeach
            <div class="page-footer__subscribe">
                <div class="subscribe-container">
                    <div class="center-content">
                        <div class="subscribe-logo">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="48" height="36" viewBox="0 0 48 36">
                                <image id="icon_mail_copy" data-name="icon mail copy" width="48" height="36" xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAkCAMAAAD4m0k4AAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAABnlBMVEWHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgCHwgAAAADqIFB3AAAAiHRSTlMAPqKqqKucL9zD8v383e77xqnO2fBFYfRSbfUDDgIPDF6QUA0SWJMIQI4qAQQznT8XHW7k6DEKadYFCUq3z1kGMqPt6XokK4fz55glwVQLX828VR6L4PeUNT2h/td9FUmv+tIWdtukcdCsTmU0md9/iY8HWr60TYLl2kOt+DoaE0djybDCPJ8umjQepgAAAAFiS0dEiRxhJswAAAAJcEhZcwAACxIAAAsSAdLdfvwAAAAHdElNRQfgChgTJSW4Gs96AAABYklEQVQ4y2NgZGJmIRqwsrEzcHSQBDgZuDo6uHmIBNwdHbwMfB38AoKsRAEWIZ4OYaAGEVEGIoGYOFgDlwSxGiSlKNAgLYNXqaycLKoGeQVFJWXc6lVU1STUUTRodHTwaGppY1euo6vX0SGii6JBXwQYKcJiBtjUGxoZAyVNTFE0mJlbgOJRUN8SXbmVtQ1IxtbOHi2UHBydgOLOLq6o6t3cPYDCnl7eWIJVTABklI+vH5Jn/QOAQvyBQdjjITgkFCgdFh4BUx8ZFQ0UiImNwxlx8QmJQBVJ5slg/SmpQI5UWiS+mFZJzwC5KxOYvLLAnhXItiKQNHJyQb7Myy9wBoVBoRbhtFRUXALLLaVlqFGJK/F5l1eAlFemBONJfKigqpq/hqkWQxhP8q5T9a1nIEUDdjCqYVBpEGkgVkMjRAN/E2szUYA5A1QYg4t7bqIATzSouE8lrUJpYWhtI6XKym0HAEPUyge2kF93AAAAAElFTkSuQmCC"></image>
                            </svg>
                        </div>
                        <div class="subscribe-text">
                            <span>ĐĂNG KÝ NHẬN TIN KHUYẾN MÃI</span>
                        </div>
                        <div class="button">
                            <div class="nv-button btn-content" style="padding: 0px;">
                                <a href="javascript:void(0)" class="btn-content btncta link-btn btn-manual brand-green regular-btn">
                                    <div class="" id="sub-btn-font">
                                        ĐĂNG KÝ
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-footer__social">
                <div class="page-footer__social__label">Follow NVIDIAVN.VN </div>
                <a href="{{ $globalSetting->facebook }}" class="page-footer__social__link" target="_blank" alt="Theo dõi trên facebook của Nvidiavn.vn" title="Nvidiavn.vn Facebook">
                    <i class="fa-brands fa-facebook"></i>
                </a>
                <a href="{{ $globalSetting->twitter }}" class="page-footer__social__link" target="_blank" alt="Theo dõi trên twitter của Nvidiavn.vn" title="Nvidiavn.vn Twitter">
                    <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="{{ $globalSetting->youtube }}" class="page-footer__social__link" target="_blank" alt="Theo dõi trên youtube của Nvidiavn.vn" title="Nvidiavn.vn Youtube">
                    <i class="fa-brands fa-youtube"></i>
                </a>
                <a href="{{ $globalSetting->tiktok }}" class="page-footer__social__link" target="_blank" alt="Theo dõi trên tiktok của Nvidiavn.vn" title="Nvidiavn.vn Tiktok">
                    <i class="fa-brands fa-tiktok"></i>
                </a>
                <a href="{{ $globalSetting->pinterest }}" class="page-footer__social__link" target="_blank" alt="Theo dõi trên pinterest của Nvidiavn.vn" title="Nvidiavn.vn Pinterest">
                    <i class="fa-brands fa-pinterest"></i>
                </a>
            </div>
        </div>
    </div>
    <a href="#top" class="back-to-top" id="top-link" aria-label="Go to top"><i class="fa-solid fa-circle-chevron-up"></i></a>
</footer>
<div class="global-footer-container container">
    <div class="global-footer" id="globalFooter">
        <ul class="global-footer__links text-center">
            @foreach ($ft_bottom as $ft)
            <li>
                <a href="{{ asset($ft->url) }}" target="_blank">{{ $ft->name}}</a>
            </li>
            @endforeach
        </ul>
        <div class="global-footer__copyright text-center">© 2024 NVIDIAVN.VN - Địa chỉ: NTT03, Line1, Thống Nhất Complex, 82 Nguyễn Tuân, Thanh Xuân, Hà Nội. Điện thoại: 0962.052.874</div>
    </div>
</div>
<!-- End Footer -->