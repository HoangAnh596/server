@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Chỉnh sửa bình luận sản phẩm</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Bình luận</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form action="{{ route('comments.update', ['id' => $comment->id]) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @if (!empty($comment))
            <input type="hidden" name="id" value="{{ $comment->id }}">
            <input type="hidden" name="product_id" value="{{ $comment->product_id }}">
            <input type="hidden" name="user_id" value="{{ $comment->user_id }}">
            <input type="hidden" name="email" value="{{ $comment->email }}">
            @endif
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('comments.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm " type="submit" id="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                </div>
            </div>
            <div class="card-body border-top p-9">
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Tác giả <div class="warningMenu">*</div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $comment->name ?? '') }}">
                            <span id="name-error" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Nội dung bình luận <div class="warningMenu">*</div>
                    </div>
                    <div class="col-9">
                        <div class="form-group">
                            <textarea class="form-control" id="my-editor" rows="10" name="content">{{ old('content', $comment->content ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
            </div>

            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm " type="submit" id="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('css')
<style>
    .toast-top-center>div {
        width: 400px !important;
    }
    .cmtContent {
        text-decoration: underline;
        color: #76b900;
        font-weight: bold;
    }
    .border-sm {
        border-color: #76b900 !important;
        padding: 0.75rem;
    }
</style>
@endsection