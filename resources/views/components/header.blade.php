@php
use Carbon\Carbon;

$totalComments = $commentGlobal->count() + $cmtNewGlobal->count();
@endphp
@auth
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sẵn sàng rời đi ?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Chọn "Đăng xuất" bên dưới nếu bạn sẵn sàng kết thúc phiên hiện tại của mình.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="{{ route('logoutUser') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Đăng xuất
                </a>
                <form id="logout-form" action="{{ route('logoutUser') }}" method="get" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Nvidiavn <sup>.vn</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Pages Categories Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('categories.index') }}" data-toggle="collapse" data-target="#collapseCategories" aria-expanded="true" aria-controls="collapseNews">
                <i class="fa-solid fa-layer-group"></i>
                <span>Danh mục sản phẩm</span>
            </a>
            <div id="collapseCategories" class="collapse" aria-labelledby="headingCategories" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('categories.index') }}">Danh sách danh mục</a>
                    @can('category-add')
                    <a class="collapse-item" href="{{ route('categories.create') }}">Thêm mới danh mục</a>
                    @endcan
                    <a class="collapse-item" href="{{ route('filter.index') }}">Danh sách bộ lọc</a>
                    <a class="collapse-item" href="{{ route('compares.index') }}">Danh sách so sánh</a>
                    <a class="collapse-item" href="{{ route('groups.index') }}">Danh sách nhóm</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Pages Products Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('product.index') }}" data-toggle="collapse" data-target="#collapseProducts" aria-expanded="true" aria-controls="collapseProducts">
                <i class="fa-solid fa-paw"></i>
                <span>Sản phẩm</span>
            </a>
            <div id="collapseProducts" class="collapse" aria-labelledby="headingProducts" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('product.index') }}">Danh sách sản phẩm</a>
                    @can('product-add')
                    <a class="collapse-item" href="{{ route('product.create') }}">Thêm mới sản phẩm</a>
                    @endcan
                    <a class="collapse-item" href="{{ route('questions.index') }}">Danh sách câu hỏi</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Pages Category News Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('cateNews.index') }}" data-toggle="collapse" data-target="#collapseCateNews" aria-expanded="true" aria-controls="collapseCateNews">
                <i class="fa-solid fa-newspaper"></i>
                <span>Quản lý bài viết</span>
            </a>
            <div id="collapseCateNews" class="collapse" aria-labelledby="headingCateNews" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('cateNews.index') }}">Danh mục bài viết</a>
                    @can('cateNew-add')
                    <a class="collapse-item" href="{{ route('cateNews.create') }}">Thêm danh mục bài viết</a>
                    @endcan
                    <a class="collapse-item" href="{{ route('news.index') }}">Danh sách bài viết</a>
                    @can('new-add')
                    <a class="collapse-item" href="{{ route('news.create') }}">Thêm mới bài viết</a>
                    @endcan
                </div>
            </div>
        </li>

        <!-- Nav Item - Pages Hotline -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('quotes.index') }}" data-toggle="collapse" data-target="#collapseInfors" aria-expanded="true" aria-controls="collapseInfors">
                <i class="fa-solid fa-phone-volume"></i>
                <span>QL báo giá, liên hệ</span>
            </a>
            <div id="collapseInfors" class="collapse" aria-labelledby="headingInfors" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('quotes.index') }}">Danh sách báo giá</a>
                    <a class="collapse-item" href="{{ route('infors.index') }}">Danh sách liên hệ</a>
                    @can('hotline-add')
                    <a class="collapse-item" href="{{ route('infors.create') }}">Thêm mới liên hệ</a>
                    @endcan
                </div>
            </div>
        </li>

        <!-- Nav Item - Pages Comments -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('comments.index') }}" data-toggle="collapse" data-target="#collapseComments" aria-expanded="true" aria-controls="collapseComments">
                <i class="fa-regular fa-comment"></i>
                <span>QL bình luận</span>
            </a>
            <div id="collapseComments" class="collapse" aria-labelledby="headingInfors" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('comments.index') }}">Bình luận sản phẩm</a>
                    <a class="collapse-item" href="{{ route('cmtNews.index') }}">Bình luận bài viết</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Pages Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('cateMenu.index') }}" data-toggle="collapse" data-target="#collapseMenus" aria-expanded="true" aria-controls="collapseMenus">
                <i class="fa-solid fa-list-check"></i>
                <span>Quản lý chung</span>
            </a>
            <div id="collapseMenus" class="collapse" aria-labelledby="headingMenus" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('cateMenu.index') }}">Danh sách Menu</a>
                    @can('menu-add')
                    <a class="collapse-item" href="{{ route('cateMenu.create') }}">Thêm mới Menu</a>
                    @endcan
                    <a class="collapse-item" href="{{ route('sliders.index') }}">Danh sách Slider</a>
                    @can('slider-add')
                    <a class="collapse-item" href="{{ route('sliders.create') }}">Thêm mới Slider</a>
                    @endcan
                    <a class="collapse-item" href="{{ route('cateFooter.index') }}">Danh sách Footer</a>
                    @can('footer-add')
                    <a class="collapse-item" href="{{ route('cateFooter.create') }}">Thêm mới Footer</a>
                    @endcan
                    <a class="collapse-item" href="{{ route('bottoms.index') }}">Danh sách chân trang</a>
                    @can('bottom-add')
                    <a class="collapse-item" href="{{ route('bottoms.create') }}">Thêm mới chân trang</a>
                    @endcan
                </div>
            </div>
        </li>

        <!-- Nav Item - Pages Permissions -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('users.index') }}" data-toggle="collapse" data-target="#collapsePermissions" aria-expanded="true" aria-controls="collapsePermissions">
                <i class="fa-solid fa-users"></i>
                <span>Phân quyền tài khoản</span>
            </a>
            <div id="collapsePermissions" class="collapse" aria-labelledby="headingPermissions" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('users.index') }}">Danh sách tài khoản</a>
                    @can('user-add')
                    <a class="collapse-item" href="{{ route('users.create') }}">Thêm mới tài khoản</a>
                    @endcan
                    <a class="collapse-item" href="{{ route('roles.index') }}">Danh sách vai trò</a>
                    @can('role-add')
                    <a class="collapse-item" href="{{ route('roles.create') }}">Thêm mới vai trò</a>
                    @endcan
                    <a class="collapse-item" href="{{ route('permissions.index') }}">Danh sách Permission</a>
                    @can('permission-add')
                    <a class="collapse-item" href="{{ route('permissions.create') }}">Thêm mới Permission</a>
                    @endcan
                </div>
            </div>
        </li>

        <!-- Nav Item - Pages Config -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('contact-icons.index') }}" data-toggle="collapse" data-target="#collapseConfig" aria-expanded="true" aria-controls="collapseConfig">
                <i class="fa-solid fa-gears"></i>
                <span>Cấu hình website</span>
            </a>
            <div id="collapseConfig" class="collapse" aria-labelledby="headingConfig" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('setting-edit')
                    <a class="collapse-item" href="{{ route('setting.edit', ['id' => 1]) }}">Cấu hình SEO</a>
                    @endcan
                    <a class="collapse-item" href="{{ route('header-tags.index') }}">Danh sách thẻ tiếp thị</a>
                    @can('header-tags-add')
                    <a class="collapse-item" href="{{ route('header-tags.create') }}">Thêm mới thẻ tiếp thị</a>
                    @endcan
                    <a class="collapse-item" href="{{ route('contact-icons.index') }}">Danh sách icon</a>
                    @can('contact-icon-add')
                    <a class="collapse-item" href="{{ route('contact-icons.create') }}">Thêm mới icon</a>
                    @endcan
                    <a class="collapse-item" href="{{ route('setting.images') }}">Dọn dẹp hình ảnh</a>
                </div>
            </div>
        </li>
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto notification">
                    <!-- Nav Item - Alerts -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-fw"></i>
                            <!-- Counter - Alerts -->
                            <span class="badge badge-danger badge-counter"></span>
                        </a>
                    </li>
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="commentsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa-solid fa-comment"></i>
                            <!-- Counter - Alerts -->
                            <span class="badge badge-danger badge-counter">{{ $totalComments }}</span>
                        </a>
                        @if($totalComments != 0)
                        <!-- Dropdown - Thông tin comments -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="quotesDropdown">
                            <h5 class="dropdown-item">Bình luận chưa trả lời</h5>
                            <div class="dropdown-divider"></div>
                            @if($commentGlobal->count())
                            <a class="dropdown-item" href="{{ url('admin/comments?is_reply=0') }}">
                                Có <strong>{{ $commentGlobal->count() }}</strong> bình luận sản phẩm
                            </a>
                            @endif
                            @if($cmtNewGlobal->count())
                            <a class="dropdown-item" href="{{ url('admin/cmtNews?is_reply=0') }}">
                                Có <strong>{{ $cmtNewGlobal->count() }}</strong> bình luận bài viết
                            </a>
                            @endif
                        </div>
                        @endif
                    </li>
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="quotesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                            <!-- Counter - Alerts -->
                            <span class="badge badge-danger badge-counter">@if($quoteGlobal->count()) {{ $quoteGlobal->count() }} @endif</span>
                        </a>
                        <!-- Dropdown - Thông tin báo giá -->
                        @if($quoteGlobal->count())
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in scroll-noti" aria-labelledby="quotesDropdown">
                            <h5 class="dropdown-item">Chưa báo giá</h5>
                            <div class="dropdown-divider"></div>
                            @foreach($quoteGlobal as $quote)
                            @php
                            $time = Carbon::parse($quote->created_at);
                            $now = Carbon::now();
                            @endphp
                            <a class="dropdown-item" href="{{ url('admin/quotes?keyword=' . $quote->id) }}">
                                Báo giá cho sản phẩm <strong>{{ $quote->product }}</strong>
                                <br>
                                <span>
                                    @if ($time->diffInMinutes($now) < 60)
                                        {{ $time->diffInMinutes($now) }} phút trước
                                    @elseif ($time->diffInHours($now) < 24)
                                        {{ $time->diffInHours($now) }} giờ trước
                                    @elseif ($time->diffInDays($now) < 7)
                                        {{ $time->diffInDays($now) }} ngày trước
                                    @elseif ($time->diffInWeeks($now) < 4)
                                        {{ $time->diffInWeeks($now) }} tuần trước
                                    @elseif ($time->diffInMonths($now) < 12)
                                        {{ $time->diffInMonths($now) }} tháng trước
                                    @else
                                        {{ $time->format('H:i') }} {{ $time->format('d-m-Y') }}
                                    @endif
                                </span>
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                            <img class="img-profile rounded-circle" src="{{ asset(Auth::user()->image) }}">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('users.edit', ['id' => Auth::id()]) }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Thông tin tài khoản
                            </a>
                            @can('setting-edit')
                            <a class="dropdown-item" href="{{ route('setting.edit', ['id' => 1]) }}">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Cài đặt
                            </a>
                            @endcan
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Nhật ký hoạt động
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Đăng xuất
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            @endauth