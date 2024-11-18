@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Thêm mới câu hỏi @if(!is_null($idCate)) danh mục @else sản phẩm @endif</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Câu hỏi</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="questionsForm" action="{{ route('questions.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('questions.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm " type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                </div>
            </div>
            <div class="text-dark card-body border-top">
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Câu hỏi :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                            <span id="title-error" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                @if(!is_null($idCate))
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Danh mục :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <select name="cate_id" id="cate_id" class="form-control" size="10" style="width: 100%;">
                                @foreach($categories as $category)
                                @include('admin.question.partials.category_add', ['category' => $category, 'level' => 0, 'prefix' => '|---', 'selected' => old('cate_id', $idCate)])
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                @else
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Sản phẩm :</div>
                    <div class="col-8">
                        <div class="form-group">
                            <input class="form-control" value="{{ old('name', $products->name ?? '') }}" disabled>
                            @if (!empty($products))
                            <input type="hidden" name="product_id" value="{{ $products->id }}">
                            @endif
                            <span id="title-error" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                @endif
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Hiển thị :</div>
                    <div class="col-1 d-flex align-items-center">
                        <select class="form-select" aria-label="Default" name="is_public">
                            <option value="0">Không</option>
                            <option value="1">Có</option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Thứ tự hiển thị :</div>
                    <div class="col-1">
                        <input type="number" style="width:60px" name="stt" value="{{ old('stt')}}">
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Nội dung trả lời :</div>
                    <div class="col-9">
                        <textarea class="form-control" id="my-editor" rows="10" name="content">{{ old('content') }}</textarea>
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
