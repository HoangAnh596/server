@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Thêm mới Permission</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Permission</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="uploadImageFormCateNew" action="{{ route('permissions.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm" id="submit" type="submitCateNew"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                    <!-- <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button> -->
                </div>
            </div>
            <div class="card-body border-top p-9">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Tên Permission <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                            <span id="name-error" style="color: red;"></span>
                        </div>
                        <div class="form-group">
                            <label for="">Tên Permission hiển thị màn hình <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                            <input type="text" name="display_name" id="display_name" class="form-control" value="{{ old('display_name') }}">
                            <span id="displayName-error" style="color: red;"></span>
                        </div>
                        <div class="form-group">
                            <label for="">Mã Code Permission <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                            <input type="text" name="key_code" id="key_code" class="form-control" value="{{ old('key_code') }}">
                            <span id="keyCode-error" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Chọn Permission cha <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                            <select name="parent_id" id="parent_id" class="form-control" size="12">
                                <option value="0">Chọn Permission cha</option>
                                @foreach($catePermission as $item)
                                <option value="{{ $item->id }}">{{ $item->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm" id="submit" type="submitCateNew"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
            </div>
        </form>
    </div>
</div>

@endsection