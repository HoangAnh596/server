@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Thêm mới nhóm sản phẩm</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Nhóm sản phẩm</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="groupProFrom" action="{{ route('groupPro.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            @if (!empty($product))
            <input type="hidden" name="product_id" id="productId" value="{{ $product->id }}">
            @endif
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('product.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
            </div>
            <div class="card-body border-top p-9" style="padding-bottom: 0;">
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line">Hình ảnh</div>
                    <div class="col-8">
                        @if(!empty($imgProduct))
                        <img src="{{ \App\Http\Helpers\Helper::getPath($imgProduct->image) }}" alt="{{ $imgProduct->alt }}" title="{{ $imgProduct->title }}" style="height: 100px;">
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line">Mã sản phẩm</div>
                    <div class="col-8 d-flex align-items-center">{{ $product->code }}</div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line">Tên sản phẩm</div>
                    <div class="col-8 d-flex align-items-center">{{ $product->name }}</div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line">Nhóm sản phẩm</div>
                    <div class="col-8 d-flex align-items-center">
                        <select name="group_ids[]" id="group_ids" class="form-control select2_init" multiple>
                            <option value=""></option>
                            <!-- Hiển thị tất cả các sản phẩm -->
                            @if(!empty($groupSelected))
                            <!-- Hiển thị các nhóm đã được chọn -->
                            @foreach($groupSelected as $group)
                            <option value="{{ $group->id }}" selected>
                                {{ $group->name }}
                            </option>
                            @endforeach
                            <!-- Hiển thị các nhóm chưa được chọn -->
                            @foreach($allGroups as $group)
                            @if(!in_array($group->id, $groupSelected->pluck('id')->toArray())) <!-- Loại bỏ các nhóm đã chọn -->
                            <option value="{{ $group->id }}">
                                {{ $group->name }}
                            </option>
                            @endif
                            @endforeach
                            @else
                            <!-- Hiển thị tất cả các nhóm nếu chưa có nhóm nào được chọn -->
                            @foreach($allGroups as $group)
                            <option value="{{ $group->id }}"
                                @if(in_array($group->cate_id, $selectedCateIds) ||
                                ($group->cate_id == 0 && $group->parent_id == $product->id)) selected @endif>
                                {{ $group->name }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-2 d-flex align-items-center btn-group-prod">
                        <button class="hidden-group">Thêm nhóm</button>
                        <button class="refresh-group">Làm mới</button>
                    </div>
                </div>

                <div class="hidden-add-group">
                    <div class="row mt-3">
                        <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Tên nhóm :<div class="warningMenu">*</div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <input type="text" name="group-name" id="group-name" class="form-control" value="{{ old('group-name') }}">
                                <span id="name-error" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Sản phẩm :<div class="warningMenu">*</div>
                        </div>
                        <div class="col-8">
                            <select name="group_product_id[]" class="form-control add_select2" multiple>
                                <option value=""></option>
                                @foreach($allProducts as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                    </div>
                    <div class="mb-3 d-flex justify-content-end btn-add-complete">
                        <button class="complete-group">Hoàn tất</button>
                        <button class="close-group">Đóng</button>
                    </div>
                </div>
            </div>
            @if(!empty($groupSelected))
            @foreach($groupSelected as $key)
            <div class="card-body group-pro border-top p-9">
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line pt-2">Tên nhóm</div>
                    <div class="col-8 d-flex align-items-center pt-2" style="color: red;">
                        {{ $key->name }}
                        @if($key->cate_id != 0)
                        -- Danh mục nhóm chung
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line">Sản phẩm</div>
                    <div class="col-8 d-flex align-items-center">
                        <select name="product_id[]" class="form-control select2_product @if($key->cate_id == 0) group_product_ids @endif" multiple>
                            <option value=""></option>
                            @foreach($key->products as $item)
                            <option value="{{ $item->id }}" selected>
                                {{ $item->name }}
                            </option>
                            @endforeach
                            @foreach($allProducts as $value)
                            <option value="{{ $value->id }}">
                                {{ $value->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2 d-flex align-items-center btn-group-prod">
                        <button class="inherit-group" data-id="{{ $key->id }}">Tạo nhóm kế thừa</button>
                        @if($key->cate_id == 0)
                        <button class="save-group" data-id="{{ $key->id }}">Lưu</button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body" style="padding: 0;">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-sm-6 text-center">Tên sản phẩm</th>
                            <th class="col-sm-2 text-center">Ảnh</th>
                            <th class="col-sm-2 text-center">Mã sản phẩm</th>
                            <th class="col-sm-1 text-center">Giá list</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($key->products as $k)
                        @php
                        $mainImage = $k->getMainImage();
                        @endphp
                        <tr>
                            <td>{{ $k->name }}</td>
                            <td class="text-center" style="padding: 0.25rem;">
                                @if($mainImage)
                                <img src="{{ asset($mainImage->image) }}" alt="{{ $mainImage->title }}" alt="{{ $mainImage->alt }}" style="width: 100px;">
                                @endif
                            </td>
                            <td>{{ $k->code }}</td>
                            <td>$0</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
            @else
            @foreach($allGroups as $group)
            <div class="card-body group-pro border-top p-9">
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line pt-2">Tên nhóm</div>
                    <div class="col-8 d-flex align-items-center pt-2" style="color: red;">
                        {{ $group->name }}
                        @if($group->cate_id != 0)
                        -- Danh mục nhóm chung
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line">Sản phẩm</div>
                    <div class="col-8 d-flex align-items-center">
                        <select name="product_id[]" class="form-control select2_product" multiple>
                            <option value=""></option>
                            @foreach($group->products as $item)
                            <option value="{{ $item->id }}" selected>
                                {{ $item->name }}
                            </option>
                            @endforeach
                            @foreach($allProducts as $value)
                            <option value="{{ $value->id }}">
                                {{ $value->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2 d-flex align-items-center">
                        <button class="inherit-group" data-id="{{ $group->id }}">Tạo nhóm kế thừa</button>
                    </div>
                </div>
            </div>
            <div class="card-body" style="padding: 0;">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-sm-6 text-center">Tên sản phẩm</th>
                            <th class="col-sm-2 text-center">Ảnh</th>
                            <th class="col-sm-2 text-center">Mã sản phẩm</th>
                            <th class="col-sm-1 text-center">Giá list</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($group->products as $gr)
                        @php
                        $mainImage = $gr->getMainImage();
                        @endphp
                        <tr>
                            <td>{{ $gr->name }}</td>
                            <td class="text-center" style="padding: 0.25rem;">
                                @if($mainImage)
                                <img src="{{ asset($mainImage->image) }}" alt="{{ $mainImage->title }}" alt="{{ $mainImage->alt }}" style="width: 100px;">
                                @endif
                            </td>
                            <td>{{ $gr->code }}</td>
                            <td>$0</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
            @endif

            <div class="mt-4 pb-4 mr-4 float-right">
            </div>
        </form>
    </div>
</div>

@endsection

@section('css')
<style>
    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .row {
        display: flex;
        align-items: stretch;
    }

    .row .col-2,
    .row .col-8 {
        padding-bottom: 1rem;
    }

    .hidden-add-group .col-2,
    .hidden-add-group .col-8 {
        padding-bottom: 0;
    }

    .card-body .table {
        margin-bottom: 0;
    }
</style>
@endsection
@section('js')

<script type="text/javascript">
    $('.select2_init').select2({
        placeholder: 'Chọn sản phẩm',
        allowClear: true,
    });
    $('.add_select2').select2({
        placeholder: 'Chọn sản phẩm',
        allowClear: true,
    });
    $('.select2_product').select2({
        placeholder: 'Chọn sản phẩm',
        allowClear: true,
    });

    $(document).ready(function() {
        $('.inherit-group').click(function(e) {
            e.preventDefault();
            // Lấy giá trị từ data-id
            var idGroup = $(this).data('id');
            var productId = $('#productId').val();
            var group_ids = $('#group_ids').val();

            $.ajax({
                url: '{{ route("groups.inherit") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Thay thế với token CSRF của bạn
                    groupId: idGroup,
                    productId: productId,
                    group_ids: group_ids,
                },
                success: function(response) {
                    // Xử lý phản hồi từ server
                    window.location.reload();
                    toastr.success('Tạo nhóm kế thừa thành công.', 'Thành công', {
                        progressBar: true,
                        closeButton: true,
                        timeOut: 5000
                    });
                },
                error: function(xhr) {
                    // Xử lý lỗi không phải validation (500, etc.)
                    toastr.error('Có lỗi xảy ra, vui lòng thử lại.', 'Lỗi', {
                        progressBar: true,
                        closeButton: true,
                        timeOut: 5000
                    });
                }
            });
        });

        $('.hidden-group').click(function(e) {
            e.preventDefault();
            $('.hidden-add-group').toggle();
        });

        $('.close-group').click(function(e) {
            e.preventDefault();
            $('.hidden-add-group').hide();
        });

        $('.complete-group').click(function(e) {
            e.preventDefault();
            var productId = $('#productId').val();
            var groupName = $('#group-name').val();
            var idGroup = $('.add_select2').val();
            var group_ids = $('#group_ids').val();
            
            $.ajax({
                url: '{{ route("groups.add") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Thay thế với token CSRF của bạn
                    productId: productId,
                    groupName: groupName,
                    idGroup: idGroup,
                    group_ids: group_ids,
                },
                success: function(response) {
                    // Xử lý phản hồi từ server
                    window.location.reload();
                    toastr.success('Tạo nhóm mới thành công.', 'Thành công', {
                        progressBar: true,
                        closeButton: true,
                        timeOut: 5000
                    });
                },

                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Lấy lỗi từ response
                        var errors = xhr.responseJSON.errors;

                        // Hiển thị lỗi cho từng field dưới dạng toastr
                        if (errors.groupName) {
                            toastr.error(errors.groupName[0], 'Lỗi', {
                                progressBar: true,
                                closeButton: true,
                                timeOut: 5000
                            });
                        }

                        if (errors.idGroup) {
                            toastr.error(errors.idGroup[0], 'Lỗi', {
                                progressBar: true,
                                closeButton: true,
                                timeOut: 5000
                            });
                        }
                    } else {
                        // Xử lý lỗi không phải validation (500, etc.)
                        toastr.error('Có lỗi xảy ra, vui lòng thử lại.', 'Lỗi', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    }
                }
            });
        });

        $('.refresh-group').click(function(e) {
            e.preventDefault();
            var productId = $('#productId').val();
            var group_ids = $('#group_ids').val();

            $.ajax({
                url: '{{ route("groups.refresh") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Thay thế với token CSRF của bạn
                    productId: productId,
                    group_ids: group_ids,
                },
                success: function(response) {
                    // Xử lý phản hồi từ server
                    window.location.reload();
                    toastr.success('Làm mới nhóm thành công.', 'Thành công', {
                        progressBar: true,
                        closeButton: true,
                        timeOut: 5000
                    });
                },
                error: function(xhr) {
                    // Xử lý lỗi không phải validation (500, etc.)
                    toastr.error('Có lỗi xảy ra, vui lòng thử lại.', 'Lỗi', {
                        progressBar: true,
                        closeButton: true,
                        timeOut: 5000
                    });
                }
            });
        });

        $('.save-group').click(function(e) {
            e.preventDefault();
            // Lấy giá trị từ data-id
            var idGroup = $(this).data('id');        
            var group_product_ids = $('.group_product_ids').val();

            var uniqueGroupProductIds = Array.from(new Set(group_product_ids));
                    
            $.ajax({
                url: '{{ route("groups.save") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Thay thế với token CSRF của bạn
                    idGroup: idGroup,
                    group_product_ids: uniqueGroupProductIds,
                },
                success: function(response) {
                    // Xử lý phản hồi từ server
                    window.location.reload();
                    toastr.success('Lưu sản phẩm trong nhóm thành công.', 'Thành công', {
                        progressBar: true,
                        closeButton: true,
                        timeOut: 5000
                    });
                },
                error: function(xhr) {
                    // Xử lý lỗi không phải validation (500, etc.)
                    toastr.error('Có lỗi xảy ra, vui lòng thử lại.', 'Lỗi', {
                        progressBar: true,
                        closeButton: true,
                        timeOut: 5000
                    });
                }
            });
        });
    });
</script>
@endsection