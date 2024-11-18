<div class="text-dark">
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="">Tên danh mục <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" oninput="checkDuplicate()">
                <span id="name-error" style="color: red;"></span>
            </div>
            <div class="form-group">
                <label for="">URL danh mục <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" oninput="checkDuplicate()">
                <span id="slug-error" style="color: red;"></span>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="">Danh mục cha: </label>
                <select name="parent_id" id="parent_id" class="form-control" size="10" style="width: 100%;">
                    <option value="0">Danh mục cha</option>
                    @foreach($categoryParents as $category)
                    @include('admin.category.partials.category_add', ['category' => $category, 'level' => 0, 'selected' => old('parent_id', $category->parent_id)])
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-2">
            <div class="input-group">
                <input id="thumbnail" class="form-control" type="hidden" name="filepath">
                <span class="input-group-btn">
                    <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-outline-dark hiddenButton">
                        <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện
                    </button>
                </span>
            </div>
            <div id="holder"><img src="{{ old('filepath') }}"></div>
        </div>
        <div class="col-3 d-flex flex-row align-items-center" style="height: 38px;">(Kích thước đề nghị 234 x 234 px) <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="">Tiêu đề ảnh: </label>
                <input type="text" name="title_img" class="form-control" value="{{ old('title_img') }}">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="">Alt ảnh: </label>
                <input type="text" name="alt_img" class="form-control" value="{{ old('alt_img') }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="example-textarea" class="form-label">Mô tả chi tiết <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
            <textarea class="form-control" id="my-editor" rows="10" name="content">{{ old('content') }}</textarea>
        </div>
    </div>
</div>