@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Danh sách bộ lọc</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Bộ lọc</a></li>
                <li class="breadcrumb-item active">Danh sách</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <form class="d-sm-inline-block form-inline mr-auto my-2 my-md-0 ">
                <div class="input-group">
                    <div class="form-group">
                        <input type="search" class="form-control" placeholder="Tìm kiếm tên bộ lọc" aria-label="Search" name="keyword" value="{{ $keyword }}">
                    </div>
                    <div class="form-group">
                        <select name="cate" class="form-control">
                            <option value="">Danh mục bộ lọc</option>
                            @if(isset($categories))
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ \Request::get('cate') == $category->id ? "selected ='selected'" : "" }}> {{ $category->name }} </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"> <i class="fas fa-search fa-sm"></i> </button>
                    </div>
                </div>
            </form>
            <div>
                @can('filter-add')
                <a href="{{ route('filter.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-plus"></i> Thêm mới bộ lọc</a>
                @endcan
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="">No.</th>
                        <th class="col-sm-2 text-center">Tên bộ lọc</th>
                        <th class="col-sm-3 text-center">Tên danh mục sản phẩm</th>
                        <th class="col-sm-1 text-center">Đầu tiên</th>
                        <th class="col-sm-1 text-center">Đặc biệt</th>
                        <th class="col-sm-1 text-center">Số thứ tự</th>
                        <th class="col-sm-1 text-center">Ẩn/Hiện</th>
                        <th class="col-sm-2 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if($filter->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center">Không có bản ghi nào phù hợp !...</td>
                    </tr>
                    @else
                    @foreach ($filter as $val)
                    <tr>
                        <td>{{ (($filter->currentPage()-1)*config('common.default_page_size')) + $loop->iteration }}</td>
                        <td>{{ $val->name }}</td>
                        <td class="text-center">
                            {{ $val->category->name }}
                        </td>
                        <td class="text-center">
                            <input type="checkbox" class="active-checkbox" data-id="{{ $val->id }}" data-field="top_filter" {{ ($val->top_filter == 1) ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input type="checkbox" class="active-checkbox" data-id="{{ $val->id }}" data-field="special" {{ ($val->special == 1) ? 'checked' : '' }}>
                        </td>
                        <td>
                            <input type="text" class="form-control check-stt" name="stt_filter" data-id="{{ $val->id }}" style="text-align: center;" value="{{ old('stt_filter', $val->stt_filter) }}">
                        </td>
                        <td class="text-center">
                            <input type="checkbox" class="active-checkbox" data-id="{{ $val->id }}" data-field="is_public" {{ ($val->is_public == 1) ? 'checked' : '' }}>
                        </td>
                        <td class="action">
                            @can('filter-edit')
                            <a href="{{ asset('admin/filters/'.$val->id.'/edit') }}">Chỉnh sửa</a> |
                            @endcan
                            <a href="{{ asset('admin/filters') }}">Xóa cache</a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <nav class="float-right">
                {{ $filter->links() }}
            </nav>
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
            var field = $(this).data('field');
            var value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("filters.isCheckbox") }}',
                method: 'POST',
                data: {
                    id: cateId,
                    field: field,
                    value: value
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

        $('.check-stt').change(function() {
            var idFilter = $(this).data('id');
            var sttFilter = $(this).val();

            $.ajax({
                url: '{{ route("filters.checkStt") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: idFilter,
                    stt_filter: sttFilter,
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Thứ tự được cập nhật thành công.', 'Thành công', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    } else {
                        toastr.error('Không thể cập nhật thứ tự.', 'Lỗi', {
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