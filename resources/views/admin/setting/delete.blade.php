@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Dọn dẹp hình ảnh website</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Setting</a></li>
                <li class="breadcrumb-item active">Cleanup</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->
    <div class="card-body" style="padding: 0;">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th></th>
                    <th class="col-sm-2 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Dọn dẹp ảnh danh mục sản phẩm</td>
                    <td class="action text-center">
                        <button type="submit" class="btn btn-info btn-sm" onclick="confirmDelete(event, 'categories')"><i class="fa-solid fa-eraser"></i> Clean</button>
                    </td>
                </tr>
                <tr>
                    <td>Dọn dẹp ảnh sản phẩm</td>
                    <td class="action text-center">
                        <button type="submit" class="btn btn-info btn-sm" onclick="confirmDelete(event, 'products')"><i class="fa-solid fa-eraser"></i> Clean</button>
                    </td>
                </tr>
                <tr>
                    <td>Dọn dẹp ảnh bài viết</td>
                    <td class="action text-center">
                        <button type="submit" class="btn btn-info btn-sm" onclick="confirmDelete(event, 'news')"><i class="fa-solid fa-eraser"></i> Clean</button>
                    </td>
                </tr>
                <tr>
                    <td>Dọn dẹp tất cả ảnh không dùng tới ở website</td>
                    <td class="action text-center">
                        <button type="submit" class="btn btn-info btn-sm" onclick="confirmDelete(event, 'all')"><i class="fa-solid fa-eraser"></i> Clean</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('css')
<style>
    .toast-top-center>div {
        width: 400px !important;
    }
</style>
@endsection
@section('js')
<script>
    function confirmDelete(event, type) {
        // Ngăn chặn hành động mặc định của button
        event.preventDefault();

        // Hiển thị thông báo toastr với nút xác nhận và hủy
        toastr.warning(`
        <div>Bạn chắc chắn muốn dọn dẹp các mục ${type}?</div>
        <div style="margin-top: 15px;">
            <button type="button" id="confirmButton" class="btn btn-danger btn-sm" style="margin-right: 10px;">Xóa</button>
            <button type="button" id="cancelButton" class="btn btn-secondary btn-sm">Hủy</button>
        </div>
    `, 'Cảnh báo', {
            closeButton: false,
            timeOut: 0, // Vô hiệu hóa tự động loại bỏ
            extendedTimeOut: 0,
            tapToDismiss: false,
            positionClass: "toast-top-center",
            onShown: function() {
                document.getElementById('confirmButton').addEventListener('click', function() {
                    // Gọi AJAX tới backend để thực hiện xóa
                    axios.post('{{ route("setting.cleanup") }}', { type: type })
                        .then(function(response) {
                            toastr.remove();
                            toastr.success(response.data.message);
                        })
                        .catch(function(error) {
                            toastr.error('Có lỗi xảy ra khi xóa ảnh.');
                        });
                });

                document.getElementById('cancelButton').addEventListener('click', function() {
                    toastr.remove();
                });
            }
        });
    }
</script>
@endsection