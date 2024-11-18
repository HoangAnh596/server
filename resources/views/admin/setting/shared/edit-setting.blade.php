<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="">Tiêu đề mail <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
            <input type="text" name="mail_text" class="form-control" id="exampleFirstName" value="{{ old('mail_text', $setting->mail_text ?? '') }}">
            <span id="name-error" style="color: red;"></span>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="">Email tài khoản <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
            <input type="text" name="mail_name" class="form-control" id="exampleInputEmail" value="{{ old('mail_name', $setting->mail_name ?? '') }}">
            <span id="email-error" style="color: red;"></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="">Mật khẩu ứng dụng email: <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
            <input type="password" name="mail_pass" class="form-control" id="exampleFirstName" value="{{ old('mail_pass', $setting->mail_pass ?? '') }}">
            <span id="name-error" style="color: red;"></span>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-2">
        <div class="input-group">
            <input id="thumbnail" class="form-control" type="hidden" name="filepath" value="{{ old('image', $new->image ?? '') }}">
            <span class="input-group-btn">
                <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-outline-dark hiddenButton">
                    <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện
                </button>
            </span>
        </div>
        <div id="holder"><img id="setting_img" src="{{ asset($setting->image) }}" style="height: auto !important;"></div>
    </div>
    <div class="col-3 d-flex flex-row align-items-center" style="height: 38px;">(Kích thước đề nghị 36 x 36 px) <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></div>
</div>