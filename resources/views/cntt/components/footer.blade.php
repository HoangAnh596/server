<!-- Start Footer -->
<footer class="ft-black" id="tempaltemo_footer">
    <div class="container">
        <div class="row">
            <?php $count = 0 ?>
            @foreach ($globalFooters as $val)
            <?php $count++;
            $count ?>
            @if($count == 1)
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="page-footer">{{ $val->name }}</div>
                <ul class="list-unstyled footer-link">
                    @foreach ($val->children as $child)
                    <li>
                        <a class="text-decoration-none ft-link" @if($child->is_click == 1) href="{{ asset($child->url) }}" @else href="javascript:void(0)" @endif target="@if($child->is_tab == 1) _blank @endif">
                            {{ $child->name }} <br> 0123456789
                        </a>
                    </li>
                    @endforeach
                    <li class="mt-3 page-footer">Kết nối với chúng tôi</li>
                    <li class="mt-2 mb-3">
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
                    </li>
                </ul>
            </div>
            @else
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="page-footer">{{ $val->name }}</div>
                <ul class="list-unstyled footer-link">
                    @foreach ($val->children as $child)
                    <li><a class="text-decoration-none ft-link" @if($child->is_click == 1) href="{{ asset($child->url) }}" @else href="javascript:void(0)" @endif target="@if($child->is_tab == 1) _blank @endif">{{ $child->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endif
            @endforeach
        </div>
        <hr>
        <div class="d-flex justify-content-center">
            <p class="page-footer">WEBSITE CÙNG NVIDIA.VN</p>
        </div>
    </div>
    <a href="#top" class="back-to-top" id="top-link" aria-label="Go to top"><i class="fa-solid fa-circle-chevron-up"></i></a>
</footer>
<div class="global-footer-container">
    <hr>
    <div class="global-footer" id="globalFooter">
        <div class="global-footer__copyright text-center">© 2024 NVIDIAVN.VN - Địa chỉ: NTT03, Line1, Thống Nhất Complex, 82 Nguyễn Tuân, Thanh Xuân, Hà Nội. Điện thoại: 0962.052.874</div>
    </div>
</div>
<!-- End Footer -->