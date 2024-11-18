@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Chỉnh sửa thẻ tiếp thị</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Thẻ tiếp thị</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="header-tagsForm" action="{{ route('header-tags.update', $headerTag->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if (!empty($headerTag))
            <input type="hidden" name="id" value="{{ $headerTag->id }}">
            @endif
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('header-tags.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm " type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                </div>
            </div>
            <div class="text-dark card-body border-top">
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line pb-3">Tên thẻ <div class="warningMenu">*</div>
                    </div>
                    <div class="col-8 pb-3">
                        <input type="text" name="tag_name" class="form-control" value="{{ old('tag_name', $headerTag->tag_name ?? '') }}">
                        <span class="text-danger" id="titleSeoWarning"></span>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line pb-3">Trạng thái</div>
                    <div class="col-1 d-flex align-items-center pb-3">
                        <select class="form-select form-control" aria-label="Default" name="is_public">
                            <option value="0"
                                @if(!empty($headerTag) && $headerTag->is_public == 0) selected @endif>
                                Ẩn
                            </option>
                            <option value="1"
                                @if(!empty($headerTag) && $headerTag->is_public == 1) selected @endif>
                                Hiển
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line">Nội dung <div class="warningMenu">*</div>
                    </div>
                    <div class="col-8">
                        <textarea name="content" class="form-control" rows="8">{{ old('content', $headerTag->content ?? '') }}</textarea>
                        <span class="text-danger" id="desSeoWarning"></span>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
            </div>

            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm" type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
            </div>
        </form>
    </div>
</div>

@endsection