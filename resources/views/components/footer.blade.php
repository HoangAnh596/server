<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.0.0/js/sb-admin-2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/js/bootstrap-select.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{ asset('cntt/ckeditor/ckeditor.js') }}"></script>

<script>
  var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Lấy token CSRF từ meta tag
  var route_prefix = "{{ asset('laravel-filemanager') }}";
  $('#lfm').filemanager('image', {
    prefix: route_prefix
  });
  $('#lfm-prImages').filemanager('image', {
    prefix: route_prefix
  });
  $('#lfm-file').filemanager('file', {
    prefix: route_prefix
  });

  var options = {
    extraPlugins: 'autogrow,filebrowser, toc',
    autoGrow_minHeight: 200,
    autoGrow_maxHeight: 400,
    autoGrow_bottomSpace: 50,
    removePlugins: 'resize',
    toolbarLocation: 'top',
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=' + csrfToken,
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=' + csrfToken,
    extraAllowedContent: 'img[srcset,sizes,alt,data-cke-saved-src]', // Giữ lại srcset và sizes
  };

  // Sử dụng CKEDITOR.on để xử lý sự kiện dialogDefinition cho tất cả editor instances
  CKEDITOR.on('dialogDefinition', function(ev) {
    var dialogName = ev.data.name;
    var dialogDefinition = ev.data.definition;

    if (dialogName === 'image') {
      var onOk = dialogDefinition.onOk;
      dialogDefinition.onOk = function(e) {
        console.log('On OK button pressed');

        onOk && onOk.apply(this, arguments);

        var dialog = this;
        var url = dialog.getValueOf('info', 'txtUrl');

        // Tách URL thành phần đường dẫn và tên tệp
        var parts = url.split('/');
        var filename = parts.pop(); // Lấy tên tệp từ URL
        var baseUrl = parts.join('/'); // Lấy phần đường dẫn còn lại

        // Tạo các phiên bản srcset với các kích thước cụ thể
        var srcset = baseUrl + '/small/' + filename + ' 240w, ' +
          baseUrl + '/medium/' + filename + ' 320w, ' +
          baseUrl + '/large/' + filename + ' 460w, ' +
          baseUrl + '/w_560/' + filename + ' 560w, ' +
          baseUrl + '/w_640/' + filename + ' 640w, ' +
          baseUrl + '/' + filename + ' 800w ';

        // Tạo thuộc tính sizes
        var sizes = '(max-width: 320px) 240px, (max-width: 400px) 320px, (max-width: 600px) 460px, (max-width: 800px) 560px, (max-width: 1200px) 640px, 800px';

        // Chuyển đổi CKEDITOR.instances thành mảng và xử lý
        Object.values(CKEDITOR.instances).forEach(function(editor) {
          editor.document.$.querySelectorAll('img').forEach(function(img) {
            if (img.getAttribute('src') === url) {
              // Lưu các thuộc tính khác để chèn lại theo thứ tự mong muốn
              var alt = img.getAttribute('alt') || '';
              var src = img.getAttribute('src');

              // Xóa các thuộc tính hiện tại để sắp xếp lại
              img.removeAttribute('style');
              img.removeAttribute('src');
              img.removeAttribute('alt');
              img.removeAttribute('srcset');
              img.removeAttribute('sizes');

              // Thêm lại thuộc tính theo thứ tự mong muốn
              img.setAttribute('srcset', srcset);
              img.setAttribute('sizes', sizes);
              img.setAttribute('src', src);
            }
          });

          // Đảm bảo nội dung của CKEditor được cập nhật sau khi thêm srcset
          editor.updateElement();
        });
      };
    }
  });

  // Khởi tạo các editor và thiết lập sự kiện
  CKEDITOR.replace('my-editor', options);
  CKEDITOR.replace('des-editor', options);

  function uploadImage() {
    const fileInput = document.getElementById('image');
    const imagePreview = document.getElementById('preview');
    console.log(fileInput, imagePreview);

    // Kiểm tra xem đã chọn tệp chưa
    if (fileInput.files && fileInput.files[0]) {
      const reader = new FileReader();

      reader.onload = function(e) {
        // Hiển thị ảnh trước khi upload
        const image = document.createElement('img');
        image.src = e.target.result;
        imagePreview.innerHTML = '';
        imagePreview.appendChild(image);
      }

      // Đọc tệp và hiển thị ảnh
      reader.readAsDataURL(fileInput.files[0]);
    } else {
      imagePreview.innerHTML = 'Vui lòng chọn một tệp ảnh.';
    }
  }

  $(".hiddenButton").click(function() {
    $('#preview').hide();
  });
  $('.hiddenImg').click(function() {
    $('#holder').hide();
  });
  $(".hiddenButton").click(function() {
    document.getElementById("holder").style.display = "";
  });
</script>