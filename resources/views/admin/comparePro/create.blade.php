@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Chỉnh sửa so sánh sản phẩm</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">So sánh</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="uploadImageForm" action="{{ route('comparePro.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            @if (!empty($products))
            <input type="hidden" name="product_id" value="{{ $products->id }}">
            @endif
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('product.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm " type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                    <!-- <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button> -->
                </div>
            </div>
            <div class="card-body border-top p-9">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#info-tab" type="button" role="tab">
                            <i class="bi bi-info-circle-fill"></i>
                            Thông tin so sánh
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#wallet-tab" type="button" role="tab">
                            <i class="bi bi-wallet2"></i>
                            Giá trị so sánh
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="info-tab" role="tabpanel">
                        @include("admin.comparePro.shared.add-config")
                    </div>
                    <div class="tab-pane fade" id="wallet-tab" role="tabpanel">
                        @include("admin.comparePro.shared.add-compare")
                    </div>
                </div>
            </div>

            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm" type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                <!-- <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button> -->
            </div>
        </form>
    </div>
</div>

@endsection

@section('css')
<style>
    .table-responsive {
        height: auto;
        overflow-y: auto;
    }
    .table thead th {
        position: relative !important;
    }
    .col h4 {
        color: black; font-weight: 600;
    }
    .key-word {
        color: red;
    }
    .border-compare {
        width: 100%;
        border: 1px solid red;
    }
</style>
@endsection
@section('js')
<script>
    function autoResize(textarea) {
        // Đặt chiều cao về 1 để tính toán lại đúng chiều cao cần thiết
        textarea.style.height = 'auto';
        // Điều chỉnh chiều cao dựa trên nội dung
        textarea.style.height = (textarea.scrollHeight) + 'px';
    }
</script>
@endsection