@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Chỉnh sửa bộ lọc sản phẩm</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Bộ lọc</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="uploadImageForm" action="{{ route('filterPro.store') }}" method="post" enctype="multipart/form-data">
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
                <h5>Bộ lọc :</h5>
                <hr>
                @if (!empty($filterCate))
                @foreach($filterCate as $val)
                <div class="filter">
                    <div class="col" style="color: black;">{{ $val->name }} :</div>
                    <div class="col mt-3">
                        @foreach($val->valueFilters as $item)
                        @if(!empty($val))
                        <div class="form-check form-check-inline mr-3 ml-3">
                            <label class="form-check-label" for="{{ $item->id }}">
                                <input class="form-check-input" type="radio" name="{{ $val->name }}" id="{{ $item->id }}"
                                    value="{{ $item->id }}"
                                    @foreach($filterProducts as $fil)
                                        @if($item->id == $fil->filter_id) checked @endif
                                    @endforeach
                                />
                                {{ $item->key_word }}
                            </label>
                        </div>
                        @endif
                        @endforeach
                        <hr>
                    </div>
                </div>
                @endforeach
                @elseif (empty($filterCate))
                <div class="col">Chưa có danh mục bộ lọc! Ấn vào <a href="{{ asset('admin/products/'.$products->id.'/edit') }}">link</a> để thêm danh mục sản phẩm</div>
                @endif
            </div>

            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm" type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                <!-- <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button> -->
            </div>
        </form>
    </div>
</div>

@endsection