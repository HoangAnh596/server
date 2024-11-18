@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Thêm mới sản phẩm</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Sản phẩm</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="uploadImageProduct" action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            @if (!empty($product))
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
                            Thông tin chi tiết
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#seo-tab" type="button" role="tab">
                            <i class="bi bi-wallet2"></i>
                            Cấu hình SEO
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="info-tab" role="tabpanel">
                        @include("admin.product.shared.add-config")
                    </div>
                    <div class="tab-pane fade" id="seo-tab" role="tabpanel">
                        @include("admin.product.shared.add-seo")
                    </div>
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
<script src="{{ asset('cntt/js/slug.js') }}"></script>
<script type="text/javascript">
    let timeout = null; // Khởi tạo biến timeout

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

    document.getElementById('price').addEventListener('input', function(e) {
        const value = e.target.value;
        const priceError = document.getElementById('priceError');

        if (!/^\d*\.?\d*$/.test(value)) {
            priceError.textContent = 'Vui lòng chỉ nhập số nguyên hoặc số thực.';
            e.target.value = value.replace(/[^0-9.]/g, '');
        } else {
            priceError.textContent = '';
        }
    });

    document.getElementById('discount').addEventListener('input', function(e) {
        const value = e.target.value;
        const discountError = document.getElementById('discountError');

        if (!/^\d+$/.test(value) || parseInt(value) > 100) {
            discountError.textContent = 'Vui lòng chỉ nhập số nguyên từ 0 đến 100.';

            // Loại bỏ các ký tự không hợp lệ và giới hạn giá trị từ 0-100
            e.target.value = value.replace(/[^0-9]/g, ''); // Chỉ cho phép số
            if (parseInt(e.target.value) > 100) {
                e.target.value = 100; // Giới hạn tối đa là 100
            }
        } else {
            discountError.textContent = '';
        }
    });

    let updateSlug = true;

    document.getElementById('code').addEventListener('input', function(e) {
        const value = e.target.value;
        const codeError = document.getElementById('codeError');
        // Regex cho phép chỉ nhập số, chữ thường, chữ cái và dấu gạch ngang, không có ký tự đặc biệt ở đầu/cuối
        const regex = /^[a-zA-Z0-9]+(?:-[a-zA-Z0-9]+)*$/;

        // Kiểm tra giá trị nhập vào với regex
        if (!regex.test(value)) {
            codeError.textContent = 'Vui lòng chỉ nhập số, chữ thường, chữ cái và dấu gạch ngang. Đầu và cuối không được chứa ký tự đặc biệt.';
            clearTimeout(timeout);
        } else {
            codeError.textContent = '';
            // Xóa bộ đếm thời gian trước đó nếu người dùng tiếp tục nhập
            clearTimeout(timeout);

            // Thiết lập lại bộ đếm thời gian để gọi API sau 3 giây nếu không có sự thay đổi
            timeout = setTimeout(function() {
                // Gọi API để kiểm tra mã sản phẩm
                checkCodeAvailability(value);
            }, 2000);
        }
    });

    function checkCodeAvailability(code) {
        const codeError = document.getElementById('codeError');
        $.ajax({
            url: "{{ route('products.checkCode') }}",
            type: 'POST',
            dataType: 'json',
            data: {
                code: code,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.code_exists) {
                    document.getElementById('codeError').innerText = 'Tên đã tồn tại';
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    function validateSlug(slug) {
        // Biểu thức chính quy để kiểm tra định dạng của slug
        const regex = /^[a-z0-9]+(-[a-z0-9]+)*$/;
        return regex.test(slug);
    }

    function checkDuplicate() {
        clearTimeout(timeout);
        timeout = setTimeout(async function() {
            if (updateSlug) {
                await createSlug();
            }

            const name = document.getElementById('name').value;
            const slug = document.getElementById('slug').value;

            // Xóa thông báo lỗi trước đó
            document.getElementById('name-error').innerText = "";
            document.getElementById('slug-error').innerText = "";
            // Chỉ kiểm tra nếu slug không rỗng
            if (updateSlug && name.trim() !== "") {
                await createSlug();
            }
            // Kiểm tra định dạng slug
            if (slug.trim() === "") {
                document.getElementById('slug-error').innerText = 'Url không được để trống';
            } else if (!validateSlug(slug)) {
                document.getElementById('slug-error').innerText = 'Url không hợp lệ. Chỉ chấp nhận chữ cái thường, số và dấu gạch ngang.';
            } else {
                // Nếu slug hợp lệ, kiểm tra trùng lặp
                await $.ajax({
                    url: "{{ route('products.checkName') }}",
                    type: 'POST',
                    data: {
                        name: name,
                        slug: slug,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        if (data.name_exists) {
                            document.getElementById('name-error').innerText = 'Tên đã tồn tại';
                        }

                        if (data.slug_exists) {
                            document.getElementById('slug-error').innerText = 'Url đã tồn tại';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        }, 1000);
    }
    // Đặt updateSlug là true khi tên thay đổi
    document.getElementById('name').addEventListener('input', function() {
        updateSlug = true;
        checkDuplicate();
    });

    // Đặt updateSlug là false khi slug thay đổi
    document.getElementById('slug').addEventListener('input', function() {
        updateSlug = false;
        checkDuplicate();
    });

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

        // Xử lý phần tags
        $('#searchTags').select2({
            placeholder: "Nhập thẻ tags",
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
        // Lưu đường dẫn ảnh đã tải lên
        let uploadedImages = [];
        $('#current_url').val(window.location.href);

        // Xử lý sự kiện khi ảnh được chọn từ trình quản lý file
        $('#lfm-prImages').on('click', function() {
            var dataPreview = $(this).data('preview');
            window.open('/laravel-filemanager?type=image', 'FileManager', 'width=300,height=300');
            window.SetUrl = function(items) {
                var imagePath = items.map(function(item) {
                    return item.url;
                }).join(',');

                addImageToTable(imagePath);
            };
        });
        if ($('#productImgTable tbody').is(':empty')) {
            console.log("Tbody is empty");
        } else {
            console.log("Tbody is not empty");
        }
        // Function to add image to the table
        function addImageToTable(imagePath) {
            uploadedImages.push(imagePath); // Lưu đường dẫn ảnh vào mảng
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
                            <td><a href="javascript:void(0);" class="btn-sm delete-filter" data-image="${imagePath}">Xóa</a></td>
                        </tr>`;
            $('table#dataTable tbody').append(newRow);
            // Thay đổi checkbox 
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
        // Reset data về ban đầu
        function resetInputs() {
            $('#prImages').val('');
            $('#title_pr_images').val('');
            $('#alt_pr_images').val('');
        }

        // Xử lý sự kiện click cho nút xóa trong bảng
        $('table#dataTable').on('click', '.delete-filter', function(e) {
            e.preventDefault();
            const imageUrl = $(this).data('image'); // Lấy đường dẫn ảnh từ data attribute

            // Xóa ảnh từ server
            $.ajax({
                url: "{{ route('delete.image') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    image_url: imageUrl
                },
                success: function(response) {
                    $(this).closest('tr').remove(); // Xóa hàng khỏi bảng
                },
                error: function(response) {
                    alert("An error occurred while deleting the image.");
                }
            });
        });

        document.getElementById('lfm-file').addEventListener('click', function() {
            window.open('/laravel-filemanager?type=Files', 'FileManager', 'width=900,height=600');
            window.SetUrl = function(items) {
                var file_path = items[0].url;
                document.getElementById('thumbnail-file').value = file_path;
                document.getElementById('file-name').textContent = items[0].name;
            };
        });
    });
</script>
@endsection