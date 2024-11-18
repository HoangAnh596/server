@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Chỉnh sửa thông tin icon</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Icon</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="iconsForm" action="{{ route('contact-icons.update', $icon->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if (!empty($icon))
            <input type="hidden" name="id" value="{{ $icon->id }}">
            @endif
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('contact-icons.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm " type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                </div>
            </div>
            <div class="text-dark card-body border-top">
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Tiêu đề icon :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $icon->name ?? '') }}">
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Địa chỉ đường dẫn :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="url" id="url" class="form-control" value="{{ old('url', $icon->url ?? '') }}">
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Ảnh icon:<div class="warningMenu">*</div>
                    </div>
                    <div class="col-2">
                        <div class="input-group">
                            <input id="thumbnail" class="form-control" type="hidden" name="filepath" value="{{ old('image', $icon->image ?? '') }}">
                            <span class="input-group-btn">
                                <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-outline-dark hiddenButton">
                                    <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện
                                </button>
                            </span>
                        </div>
                        <div id="holder">
                            <img id="out_img" src="{{ \App\Http\Helpers\Helper::getPath($icon->image) }}">
                        </div>
                    </div>
                    <div class="col-4 d-flex flex-row align-items-center" style="height: 38px;">(Kích thước đề nghị 40 x 40 px) <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Animation :</div>
                    <div class="col-2 d-flex align-items-center">
                        <select class="form-control" aria-label="Default" name="animation">
                            <option value="1"
                                @if(!empty($icon) && $icon->animation == 1) selected @endif>
                                Có
                            </option>
                            <option value="0"
                                @if(!empty($icon) && $icon->animation == 0) selected @endif>
                                Không
                            </option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Hiển thị :</div>
                    <div class="col-2 d-flex align-items-center">
                        <select class="form-control" aria-label="Default" name="is_public">
                            <option value="1"
                                @if(!empty($icon) && $icon->is_public == 1) selected @endif>
                                Hiển thị
                            </option>
                            <option value="0"
                                @if(!empty($icon) && $icon->is_public == 0) selected @endif>
                                Ẩn
                            </option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Thứ tự hiển thị :</div>
                    <div class="col-1">
                        <input type="number" class="form-control" style="width:80px" name="stt" value="{{ old('stt', $icon->stt ?? '') }}">
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