<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="name" class="form-label">Tên tài khoản <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
            <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $user->name ?? '') }}" oninput="checkDuplicate()">
            <span id="name-error" style="color: red;"></span>
        </div>
    </div>
    @if(empty($user->slug))
    <div class="col-6">
        <div class="form-group">
            <label for="slug" class="form-label">URL tài khoản <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
            <input type="text" id="slug" class="form-control" name="slug" value="{{ old('slug', $user->slug ?? '') }}" oninput="checkDuplicate()">
            <span id="slug-error" style="color: red;"></span>
        </div>
    </div>
    @else
    <div class="col-6">
        <div class="form-group">
            <label class="form-label">URL tài khoản</label>
            <input type="text" class="form-control" value="{{ old('slug', $user->slug ?? '') }}" disabled>
        </div>
    </div>
    @endif
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="">Email tài khoản <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
            <input type="text" name="email" class="form-control" id="exampleInputEmail" value="{{ old('email', $user->email ?? '') }}">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="">Vai trò <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
            <select name="role_id[]" class="form-control select2_init" multiple>
                <option value=""></option>
                @foreach($roles as $role)
                <option {{ $user->roles->contains('id', $role->id) ? 'selected' : ''}} value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row mt-3 mb-3">
    <div class="col-2">
        <div class="input-group">
            <input id="thumbnail" class="form-control" type="hidden" name="filepath" value="{{ old('image', $user->image ?? '') }}">
            <span class="input-group-btn">
                <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-outline-dark hiddenButton">
                    <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện
                </button>
            </span>
        </div>
        <div id="holder">
            <img id="out_img" src="{{ \App\Http\Helpers\Helper::getPath($user->image) }}">
        </div>
    </div>
    <div class="col-3 d-flex flex-row align-items-center" style="height: 38px;">(Kích thước đề nghị 234 x 234 px)</div>
</div>
<div class="form-row">
    <div class="col-6">
        <div class="mb-3">
            <label for="title_img" class="form-label">Thẻ Title<i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
            <input type="text" id="title_img" class="form-control" name="title_img" value="{{ old('title_img', $user->title_img ?? '') }}">
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="alt_img" class="form-label">Thẻ Alt<i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
            <input type="text" id="alt_img" class="form-control" name="alt_img" value="{{ old('alt_img', $user->alt_img ?? '') }}">
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col">
        <label for="example-textarea" class="form-label">Mô tả chi tiết <i class="fa-solid fa-circle-info" style="color: red;"></i></label>
        <textarea class="form-control" id="my-editor" name="content">{{ old('content', $user->content ?? '') }}</textarea>
        @error('content')
        <span class="font-italic text-danger ">{{ $message }}</span>
        @enderror
    </div>
</div>