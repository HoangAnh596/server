@php
use Carbon\Carbon;
@endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h3 class="mb-2 text-gray-800">Danh sách thông tin báo giá</h3>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <form class="d-sm-inline-block form-inline mr-auto my-2 my-md-0 ">
                <div class="input-group">
                    <div class="form-group">
                        <input type="search" class="form-control form-outline" placeholder="Tìm kiếm báo giá" aria-label="Search" name="keyword" value="">
                    </div>
                    <div class="form-group">
                        <select name="status" class="form-control">
                            <option value="">Trạng thái báo giá</option>
                            <option value="0" {{ $isStatus === '0' ? 'selected' : '' }}>Chưa báo giá</option>
                            <option value="1" {{ $isStatus === '1' ? 'selected' : '' }}>Đã báo giá</option>
                        </select>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"> <i class="fas fa-search fa-sm"></i> </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-responsive quote-table">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-center">Tên KH</th>
                        @can('quote-list')
                        <th class="text-center">Số điện thoại</th>
                        <th class="text-center">Gmail báo giá</th>
                        @endcan
                        <th class="text-center">Sản phẩm</th>
                        <th class="text-center">SL</th>
                        <th class="text-center">Mục đích</th>
                        <th class="col-md-2 text-center">Đã báo giá</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if($quotes->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center">Không có bản ghi nào phù hợp !...</td>
                        </tr>
                    @else
                    @foreach ($quotes as $val)
                    @php
                        $time = Carbon::parse($val->created_at);
                        $timeUpdate = Carbon::parse($val->updated_at);
                        $now = Carbon::now();
                    @endphp
                    <tr>
                        <td>{{ (($quotes->currentPage()-1)*config('common.default_page_size')) + $loop->iteration }}</td>
                        <td>{{ $val->name }}</td>
                        @can('quote-list')
                        <td>{{ $val->phone }}</td>
                        <td>
                            {{ $val->gmail }} <br>
                            <span class="note-admin">Ngày gửi: {{ $time->format('H:i') }} {{ $time->format('d-m-Y') }}</span>
                        </td>
                        @endcan
                        <td class="text-center">{{ $val->product }}</td>
                        <td class="text-center">{{ $val->quantity }}</td>
                        <td class="text-center">@if($val->purpose == 0 ) công ty @else dự án @endif </td>
                        <td class="text-center">
                            <input type="checkbox" class="active-checkbox" data-id="{{ $val->id }}" data-field="status" {{ ($val->status == 1) ? 'checked' : '' }}>
                            <br>
                            @if($val->user)
                            {{ $val->user->name }}
                            <span class="note-admin">{{ $timeUpdate->format('H:i') }} {{ $timeUpdate->format('d-m-Y') }}</span>
                            @endif
                        </td>
                        <td class="text-center">Xóa</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <nav class="float-right">
                {{ $quotes->links() }}
            </nav>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .quote-table table td, .quote-table table th{
        padding: .75rem .25rem;
    }
</style>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('.active-checkbox').change(function() {
            var sttId = $(this).data('id');
            var value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("quotes.isCheckbox") }}',
                method: 'POST',
                data: {
                    id: sttId,
                    status: value,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Trạng thái được cập nhật thành công.', 'Thành công', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 5000); // Delay 5 giây trước khi reload trang
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