@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Thêm mới nhóm sản phẩm</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Nhóm sản phẩm</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="groupsForm" action="{{ route('groups.update', ['id' => $group->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if (!empty($group))
            <input type="hidden" name="id" value="{{ $group->id }}">
            @endif
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('groups.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm " type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                </div>
            </div>
            <div class="text-dark card-body border-top">
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Tên nhóm :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $group->name ?? '') }}">
                            <span id="name-error" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Danh mục :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <select name="cate_id" id="cate_id" class="form-control" size="12" style="width: 100%;">
                                @foreach($categories as $val)
                                    @include('admin.groups.partials.category_option', ['category' => $val, 'level' => 0, 'prefix' => '|---', 'selected' => $group->cate_id])
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Sản phẩm :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-8">
                        <select name="product_id[]" class="form-control select2_init" multiple>
                            <option value=""></option>
                            <!-- Hiển thị các sản phẩm đã chọn trước đó -->
                            @foreach($group->products as $product)
                                <option value="{{ $product->id }}" selected>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                            <!-- Hiển thị các sản phẩm chưa được chọn -->
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Hiển thị :</div>
                    <div class="col-2 d-flex align-items-center">
                        <select class="form-control" aria-label="Default" name="is_type">
                            <option value="0"
                                @if(!empty($group) && $group->is_type == 0) selected @endif>
                                Option
                            </option>
                            <option value="1"
                                @if(!empty($group) && $group->is_type == 1) selected @endif>
                                Select
                            </option>
                        </select>
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

@section('js')
<script>
    $('.select2_init').select2({
        placeholder: 'Chọn sản phẩm',
        allowClear: true,
    });
</script>
@endsection