@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Thêm mới Footer</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Footer</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="uploadImageFormCateFooter" action="{{ route('cateFooter.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('cateFooter.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm " type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                    <!-- <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button> -->
                </div>
            </div>

            <div class="text-dark card-body border-top">
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Tên :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" oninput="checkDuplicate()">
                            <span id="name-error" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Url :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="url" class="form-control" value="{{ old('url') }}">
                            <span id="url-error" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>

                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Menu cha :</div>
                    <div class="col-4">
                        <div class="form-group">
                            <select name="parent_menu" id="parent_menu" class="form-control">
                                <option value="0">Gốc</option>
                                @foreach($menuParents as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div style="height: 38px; color: red; margin-left: 20px;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Tiêu đề :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-8">
                        <textarea name="title" class="form-control" rows="3" style="width: 100%;">{{ old('title') }}</textarea>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Hiển thị :</div>
                    <div class="col-2 d-flex align-items-center">
                        <select class="form-control" aria-label="Default" name="is_public">
                            <option value="0">Không</option>
                            <option value="1">Có</option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Thứ tự hiển thị :</div>
                    <div class="col-1">
                        <input type="number" class="form-control" style="width:80px" name="stt_menu" value="{{ old('stt_menu')}}">
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse">Click :</div>
                    <div class="col-2">
                        <select class="form-control" aria-label="Default" name="is_click">
                            <option value="1">Có</option>
                            <option value="0">Không</option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Mở tab mới :</div>
                    <div class="col-1 d-flex align-items-center">
                        <input type="checkbox" name="is_tab" value="1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Mô tả:<div class="warningMenu">*</div>
                    </div>
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

@section('css')
<style>
    #input-url {
        display: none;
    }


    #url {
        width: 500px;
    }

    .ftImg {
        font-size: 12px;
    }

    .titleMenu {
        justify-content: center;
        display: flex;
        flex-direction: column;
        height: 30px;
        text-align: center;
    }

    .imgMenu {
        justify-content: center;
        display: flex;
        flex-direction: column;
        height: 80px;
        text-align: center;
    }
</style>
@endsection
@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var option1 = document.getElementById('inlineRadio1');
        var option2 = document.getElementById('inlineRadio2');
        var inputUrl = document.getElementById('input-url');

        function toggleInput() {
            if (option2.checked) {
                inputUrl.style.display = 'block';
            } else {
                inputUrl.style.display = 'none';
            }
        }

        option1.addEventListener('change', toggleInput);
        option2.addEventListener('change', toggleInput);

        // Gọi hàm toggleInput để đảm bảo trạng thái đúng khi trang được tải
        toggleInput();
    });

    $(document).ready(function() {
        // $('#current_url').val(window.location.href);
        $("#uploadBtnCateFooter").click(function(e) {
            e.preventDefault();
            let data = new FormData();
            console.log(data);
            data.append('uploadImg', $('#image')[0].files[0]);
            data.append('current_url', window.location.href);

            $.ajax({
                url: "{{ route('upload.image') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                processData: false,
                contentType: false,
                _token: "{{ csrf_token() }}",
                success: function(response) {
                    $('#thumbnail').val(response.image_name);
                    $('#preview-image').show();
                },
                error: function(response) {
                    alert("An error occurred. Please try again.");
                    console.log(response);
                }
            });
        });
    });
</script>
@endsection