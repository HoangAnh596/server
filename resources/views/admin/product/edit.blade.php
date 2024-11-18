@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Chỉnh sửa sản phẩm</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Sản phẩm</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if (!empty($product))
            <input type="hidden" name="id" value="{{ $product->id }}">
            <input type="hidden" name="image_ids" value="{{ $product->image_ids }}">
            @endif
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('product.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm " type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                </div>
            </div>
            <div class="card-body border-top p-9">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#info-tab" type="button" role="tab">
                            <i class="bi bi-info-circle-fill"></i>
                            Cấu hình sản phẩm
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#wallet-tab" type="button" role="tab">
                            <i class="bi bi-wallet2"></i>
                            Cấu hình SEO
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="info-tab" role="tabpanel">
                        @include("admin.product.shared.edit-config")
                    </div>
                    <div class="tab-pane fade" id="wallet-tab" role="tabpanel">
                        @include("admin.product.shared.edit-seo")
                    </div>
                </div>
            </div>
            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm " type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
            </div>
        </form>
        @can('product-delete')
        <form id="deleteForm-{{ $product->id }}" action="{{ route('product.destroy', ['id' => $product->id]) }}" method="post" class="deleteForm">
            @csrf
            @method('Delete')
            <button class="btn btn-danger btn-sm" type="button" value="Delete" onclick="confirmDelete('{{ $product->id }}')" style="float: right; margin: 0 5px">
                <i class="fa-solid fa-eraser"></i> Xóa
            </button>
        </form>
        @endcan
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
    let timeout = null;

    // Hàm chung để kiểm tra độ dài của text input
    function delayedValidate(fieldId, warningId, minLength, maxLength) {
        clearTimeout(timeout); // Xóa timeout cũ nếu có, để đặt lại thời gian chờ

        // Đặt một timeout mới, sẽ thực thi sau 2 giây (2000ms)
        timeout = setTimeout(function() {
            validateLength(fieldId, warningId, minLength, maxLength);
        }, 2000);
    }

    function validateLength(fieldId, warningId, minLength, maxLength) {
        const fieldValue = document.getElementById(fieldId).value;
        const warning = document.getElementById(warningId);
        const fieldLength = fieldValue.length;

        if (fieldLength >= minLength && fieldLength <= maxLength) {
            warning.textContent = ''; // Không hiển thị cảnh báo nếu hợp lệ
        } else {
            warning.textContent = `Độ dài hiện tại: ${fieldLength}. Vui lòng nhập từ ${minLength} đến ${maxLength} ký tự để tối ưu hóa chuẩn SEO.`;
        }
    }
    
    document.getElementById('name').addEventListener('input', function() {
        // Xóa bộ đếm thời gian trước đó nếu có
        clearTimeout(timeout);

        // Thiết lập lại bộ đếm thời gian để gọi API sau 2 giây nếu không có sự thay đổi
        timeout = setTimeout(function() {
            checkDuplicate();
        }, 2000);
    });

    function checkDuplicate() {
        const name = document.getElementById('name').value;
        // Xóa thông báo lỗi trước đó
        document.getElementById('name-error').innerText = "";

        $.ajax({
            url: " {{ route('products.checkName') }} ",
            type: 'POST',
            data: {
                name: name,
                id: '{{ $product->id }}',
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                if (data.name_exists) {
                    document.getElementById('name-error').innerText = 'Tên đã tồn tại';
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    function checkCodeDuplicate() {
        const code = document.getElementById('code').value;
        // Xóa thông báo lỗi trước đó
        document.getElementById('code-error').innerText = "";

        $.ajax({
            url: " {{ route('products.checkCode') }} ",
            type: 'POST',
            data: {
                code: code,
                id: '{{ $product->id }}',
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                if (data.code_exists) {
                    document.getElementById('code-error').innerText = 'Tên đã tồn tại';
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    function validatePrice() {
        const priceField = document.getElementById('price');
        const priceError = document.getElementById('priceError');
        const value = priceField.value;

        if (!/^\d*\.?\d*$/.test(value)) {
            priceError.textContent = 'Vui lòng chỉ nhập số nguyên hoặc số thực.';
            priceField.value = value.replace(/[^0-9.]/g, '');
        } else {
            priceError.textContent = '';
        }
    }

    function validateDiscount() {
        const discountField = document.getElementById('discount');
        const discountError = document.getElementById('discountError');
        const value = discountField.value;

        // Kiểm tra nếu không phải là số nguyên hoặc nằm ngoài khoảng 0-100
        if (!/^\d+$/.test(value) || parseInt(value) > 100) {
            discountError.textContent = 'Vui lòng chỉ nhập số nguyên từ 0 đến 100.';
            
            // Loại bỏ ký tự không hợp lệ và giới hạn giá trị từ 0-100
            discountField.value = value.replace(/[^0-9]/g, ''); // Chỉ cho phép số nguyên
            
            if (parseInt(discountField.value) > 100) {
                discountField.value = 100; // Giới hạn tối đa là 100
            }
        } else {
            discountError.textContent = '';
        }
    }

    $(document).ready(function() {
        // Xử lý sản phẩm liên quan select2
        $('.related_pro').select2({
            placeholder: 'select',
            allowClear: true,
        });
        $("#related_pro").select2({
            ajax: {
                url: "{{ route('products.tim-kiem') }}",
                type: "POST",
                delay: 250,
                dataType: 'json',
                data: function(params) {
                    return {
                        name: params.term,
                        _token: "{{ csrf_token() }}",
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.name,
                            }
                        })
                    }
                }
            },
        });

        $('#searchTags').select2({
            placeholder: "Nhập tên thẻ tags",
            tags: true,
            ajax: {
                url: "{{ route('products.searchTags') }}",
                type: "POST",
                delay: 250,
                dataType: 'json',
                data: function(params) {
                    return {
                        name: params.term,
                        _token: "{{ csrf_token() }}",
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.name,
                            }
                        })
                    };
                },
                cache: true
            },
            createTag: function(params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                return {
                    id: term,
                    text: term,
                    newTag: true
                }
            }
        }).on('select2:select', function(e) {
            var data = e.params.data;
            if (data.newTag) {
                $.ajax({
                    url: "{{ route('product-tags.store') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        name: data.text,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        var newOption = new Option(response.name, response.id, false, true);
                        // Kiểm tra nếu id đã tồn tại trong select2, không thêm lại
                        if ($('#searchTags').find("option[value='" + response.id + "']").length) {
                            $('#searchTags').val(response.id).trigger('change');
                        } else {
                            $('#searchTags').append(newOption).trigger('change');
                        }
                    }
                });
            }
        });

        $('#current_url').val(window.location.href);

         // Xử lý sự kiện khi ảnh được chọn từ trình quản lý file
         $('#lfm-prImages').on('click', function() {
            var dataPreview = $(this).data('preview');
            window.open('/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
            window.SetUrl = function (items) {
                var imagePath = items.map(function (item) {
                    return item.url;
                }).join(',');

                addImageToTable(imagePath);
            };
        });

        if ($('.productImgTable tbody').is(':empty')) {
            console.log("Tbody is empty");
        } else {
            console.log("Tbody is not empty");
        }
        // Function to add image to the table
        function addImageToTable(imagePath) {
            let title = $('#title_pr_images').val() || $('#name').val();
            let alt = $('#alt_pr_images').val() || $('#name').val();
            let stt_img = 999; //chỉ cho nhập số và lớn hoặc bằng 1

            let newRow = `<tr>
                            <td>
                                <input type="hidden" name="image[]" value="${imagePath}">
                                <img src="${imagePath}" class="img-fluid" alt="${imagePath}" width="50%">
                            </td>
                            <td><input type="hidden" name="title[]" value="${title}">${title}</td> 
                            <td><input type="hidden" name="alt[]" value="${alt}">${alt}</td>
                            <td class="text-center">
                                <input type="hidden" name="main_img[]" value="0">
                                <input type="checkbox" class="main_img_checkbox" style="width: 50px; text-align: center;">
                            </td>
                            <td class="text-center">
                                <input type="number" name="stt_img[]" style="width: 50px;text-align: center;" value="${stt_img}" min="1">
                            </td>
                            <td class="text-center"><a href="javascript:void(0);" class="btn-sm delete-filter">Xóa</a></td>
                        </tr>`;
            $('table#dataTable tbody').append(newRow);
            // thay đổi checkbox main_img
            $('.main_img_checkbox').last().change(function() {
                let hiddenInput = $(this).prev('input[type="hidden"]');
                hiddenInput.val($(this).is(':checked') ? '1' : '0');
            });

            // Xử lý khi ấn vào nút xóa
            $('table#dataTable').on('click', '.delete-filter', function(e) {
                e.preventDefault();
                $(this).closest('tr').remove();
            });
        }
        // Reset các data cũ về ban đầu
        function resetInputs() {
                $('#prImages').val('');
                $('#title_pr_images').val('');
                $('#alt_pr_images').val('');
            }

        $('.btn-destroy').on('click', function(e) {
            e.preventDefault();

            var id = $(this).data('id'); // Lấy ID từ thuộc tính data-id
            var url = $(this).attr('href'); // Lấy URL từ href

            confirmDeleteImg(id, url); // Gọi hàm confirmDelete
        });

        function confirmDeleteImg(id, url) {
            toastr.warning(`
                <div>Bạn chắc chắn muốn xóa chứ?</div>
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
                        toastr.remove(); // Xóa thông báo toastr

                        // Thực hiện xóa đối tượng bằng AJAX
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(result) {
                                // Xóa hàng khỏi bảng nếu xóa thành công
                                $('a[data-id="' + id + '"]').closest('tr').remove();
                            },
                            error: function(xhr) {
                                alert('Có lỗi xảy ra, vui lòng thử lại.');
                            }
                        });
                    });

                    document.getElementById('cancelButton').addEventListener('click', function() {
                        toastr.remove(); // Xóa thông báo toastr khi nhấn nút "Hủy"
                    });
                }
            });
        }

        $('.check-stt').change(function() {
            var idMenu = $(this).data('id');
            var sttMenu = $(this).val();

            $.ajax({
                url: '{{ route("product-images.checkStt") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: idMenu,
                    stt_img: sttMenu,
                },
                success: function(response) {
                    if (response.success) {
                        alert('Trạng thái được cập nhật thành công.');
                    } else {
                        alert('Không thể cập nhật trạng thái.');
                    }
                },
                error: function() {
                    alert('Lỗi cập nhật trạng thái.');
                }
            });
        });

        $('.check-main').change(function() {
            var cateId = $(this).data('id');
            var value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("products.isCheckImg") }}',
                method: 'POST',
                data: {
                    id: cateId,
                    main_img: value,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.success) {
                        alert('Trạng thái được cập nhật thành công.');
                    } else {
                        alert('Không thể cập nhật trạng thái.');
                    }
                },
                error: function() {
                    alert('Lỗi cập nhật trạng thái.');
                }
            });
        });

        document.getElementById('lfm-file').addEventListener('click', function () {
            window.open('/laravel-filemanager?type=Files', 'FileManager', 'width=900,height=600');
            window.SetUrl = function (items) {
                var file_path = items[0].url;
                document.getElementById('thumbnail-file').value = file_path;
                document.getElementById('file-name').textContent = items[0].name;
            };
        });
    });

    function confirmDelete(id) {
        toastr.warning(`
        <div>Các bình luận, ảnh con thuộc sản phẩm này sẽ bị xóa. Bạn muốn xóa chứ?</div>
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
                // Xử lý khi người dùng nhấn "Xóa"
                document.getElementById('confirmButton').addEventListener('click', function() {
                    toastr.clear(); // Xóa thông báo toastr
                    document.getElementById('deleteForm-' + id).submit(); // Gửi form để xóa
                });

                // Xử lý khi người dùng nhấn "Hủy"
                document.getElementById('cancelButton').addEventListener('click', function() {
                    toastr.remove(); // Xóa thông báo toastr khi nhấn nút "Hủy"
                });
            }
        });
    }
</script>

@endsection