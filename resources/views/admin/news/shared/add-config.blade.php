<div class="text-dark">
    <div class="form-row">
        <div class="col">
            <div class="mb-3">
                <label for="name" class="form-label">Tên bài viết <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" oninput="checkDuplicate()">
                <span id="name-error" style="color: red;"></span>
            </div>
            <div class="mb-3">
                <label for="slug" class="form-label">Url bài viết <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                <input type="text" id="slug" class="form-control" name="slug" value="{{ old('slug') }}" oninput="checkDuplicate()">
                <span id="slug-error" style="color: red;"></span>
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Mô tả ngắn <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                <textarea name="desc" id="desc" rows="5" class="form-control">{{ old('desc') }}</textarea>
                <span id="desc-error" style="color: red;"></span>
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="">Danh mục bài viết <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                <select name="cate_id" id="new_categories" class="form-control" size="13" style="width: 100%;">
                    <option value="">Chọn danh mục</option>
                    @foreach($categories as $category)
                    @include('admin.news.partials.category_add', ['category' => $category, 'level' => 0, 'selected' => old('parent_id', $category->parent_id)])
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
        <div class="col-3 d-flex flex-row align-items-center" style="height: 38px;">(Kích thước đề nghị 500 x 340 px) <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="">Tiêu đề ảnh: </label>
                <input type="text" name="title_img" class="form-control" value="{{ old('title_img') }}">
                @error('title_img')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="">Alt ảnh: </label>
                <input type="text" name="alt_img" class="form-control" value="{{ old('alt_img') }}">
                @error('alt_img')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <label for="example-textarea" class="form-label">Description <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
            <textarea id="my-editor" name="content" class="form-control">{{ old('content') }}</textarea>
        </div>
    </div>
</div>