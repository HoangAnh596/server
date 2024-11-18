@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Danh sách sản phẩm</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Sản phẩm</a></li>
                <li class="breadcrumb-item active">Danh sách</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <form class="d-sm-inline-block form-inline mr-auto my-2 my-md-0 ">
                <div class="input-group sr-product">
                    <div class="form-group">
                        <input type="search" class="form-control" placeholder="Tìm kiếm tên, mã code or Url sản phẩm" aria-label="Search" name="keyword" value="{{ $keyword }}">
                    </div>
                    <div class="form-group">
                        <select name="cate" class="form-control">
                            <option value="">Chọn danh mục</option>
                            @foreach($categories as $category)
                            @include('admin.product.partials.category_search', ['category' => $category, 'level' => 0])
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"> <i class="fas fa-search fa-sm"></i> </button>
                    </div>
                </div>
            </form>
            <div>
                @can('product-add')
                <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-plus"></i> Thêm mới</a>
                @endcan
            </div>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="">No.</th>
                            <th class="col-sm-3 text-center">Tên sản phẩm</th>
                            <th class="col-sm-3 text-center">Danh mục</th>
                            <th class="col-sm-2 text-center">Mã Code</th>
                            <th class="text-center">Nổi bật</th>
                            <th class="col-sm-2 text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($products->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">Không có bản ghi nào phù hợp !...</td>
                        </tr>
                        @else
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ (($products->currentPage()-1)*config('common.default_page_size')) + $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                @foreach ($product->category as $cate)
                                {{ $cate->name }}
                                @endforeach
                            </td>
                            <td>{{ $product->code }}</td>
                            <td class="text-center">
                                <input type="checkbox" class="active-checkbox" data-id="{{ $product->id }}" data-field="is_outstand" {{ ($product->is_outstand == 1) ? 'checked' : '' }}>
                            </td>
                            <td class="action">
                                @can('product-edit')
                                <a href="{{ asset('admin/products/'.$product->id.'/edit') }}">Chỉnh sửa</a> |
                                @endcan
                                @can('filterPro-add')
                                <a href="{{ asset('admin/filter-pro/create/?pro_id=' . $product->id) }}">Thêm bộ lọc</a> |
                                @endcan
                                @can('comparePro-add')
                                <a href="{{ asset('admin/compare-pro/create/?pro_id=' . $product->id) }}">So sánh</a> |
                                @endcan
                                @can('groupPro-add')
                                @if(!empty($product->group_ids))
                                <a href="{{ asset('admin/group-product/create/?pro_id=' . $product->id) }}" style="color:red;">Nhóm</a> |
                                @else
                                <a href="{{ asset('admin/group-product/create/?pro_id=' . $product->id) }}">Nhóm</a> |
                                @endif
                                @endcan
                                @can('question-add')
                                <a href="{{ asset('admin/questions/create/?pro_id=' . $product->id) }}">Câu hỏi</a>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <nav class="float-right">
                    {{ $products->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.active-checkbox').change(function() {
            var cateId = $(this).data('id');
            var value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("products.isCheckbox") }}',
                method: 'POST',
                data: {
                    id: cateId,
                    is_outstand: value,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Trạng thái được cập nhật thành công.', 'Thành công', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    } else {
                        toastr.error('Không thể cập nhật trạng thái.', 'Lỗi', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 403) {
                        toastr.warning('Bạn không có quyền cập nhật.', 'Cảnh báo', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 3000
                        });
                        setTimeout(function() {
                            window.location.reload()
                        }, 3000);
                    } else {
                        toastr.error('Lỗi cập nhật thứ tự.', 'Lỗi', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    }
                }
            });
        });
    });
</script>
@endsection