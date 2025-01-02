<div class="text-dark">
    <div class="row">
        <div class="col-sm-6">
            <div class="mb-3 col-xs-12">
                <label for="name" class="form-label">Tên danh mục <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $category->name ?? '') }}">
            </div>
            <div class="mb-3 col-xs-12">
                <label for="slug" class="form-label">URL danh mục <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                <input type="text" id="slug" class="form-control" name="slug" value="{{ old('slug', $category->slug ?? '') }}" disabled>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group mb-3 col-xs-12">
                <label for="parent_id">Danh mục cha:</label>
                <select id="parent_id" name="parent_id" class="form-control" size="12" style="width: 100%;">
                    <option value="0">Danh mục cha</option>
                    @foreach($categories as $cat)
                    @include('admin.category.partials.category_edit', ['category' => $cat, 'level' => 0, 'prefix' => '|---', 'selected' => old('parent_id', $category->parent_id)])
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-2">
            <div class="input-group">
                <input id="thumbnail" class="form-control" type="hidden" name="filepath" value="{{ old('image', $category->image ?? '') }}">
                <span class="input-group-btn">
                    <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-outline-dark hiddenButton">
                        <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện
                    </button>
                </span>
            </div>
            <div id="holder">
                <img id="out_img" src="{{ \App\Http\Helpers\Helper::getPath($category->image) }}" style="height: auto !important;">
            </div>
        </div>
        <div class="col-3 d-flex flex-row align-items-center" style="height: 38px;">(Kích thước đề nghị 65 x 65 px) <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="mb-3 col-xs-12">
                <label for="title_img" class="form-label">Tiêu đề ảnh:</label>
                <input type="text" id="title_img" class="form-control" name="title_img" value="{{ old('title_img', $category->title_img ?? '') }}">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3 col-xs-12">
                <label for="alt_img" class="form-label">Alt ảnh:</label>
                <input type="text" id="alt_img" class="form-control" name="alt_img" value="{{ old('alt_img', $category->alt_img ?? '') }}">
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <label for="example-textarea" class="form-label">Mô tả chi tiết <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
            <textarea class="form-control" id="my-editor" rows="10" name="content">{{ old('content', $category->content ?? '') }}</textarea>
        </div>
    </div>
    <div class="row mt-3 mb-3">
        <div class="col-2 d-flex flex-row-reverse align-items-center">Tên menu (Server) :</div>
        <div class="col-2 d-flex align-items-center">
            <select class="form-control" aria-label="Default" name="infor_server">
                <option value="1"
                    @if(!empty($category) && $category->infor_server == 1) selected @endif> Hãng server
                </option>
                <option value="2"
                    @if(!empty($category) && $category->infor_server == 2) selected @endif> Chassis server
                </option>
                <option value="3"
                    @if(!empty($category) && $category->infor_server == 3) selected @endif> Cấu hình server
                </option>
                <option value="0"
                    @if(!empty($category) && $category->infor_server == 0) selected @endif> Mặc định
                </option>
            </select>
        </div>
        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
    <div class="row mt-3 mb-3">
        <div class="col-2 d-flex flex-row-reverse align-items-center">Nổi bật :</div>
        <div class="col-2 d-flex align-items-center">
            <select class="form-control" aria-label="Default" name="is_outstand">
                <option value="1"
                    @if(!empty($category) && $category->is_outstand == 1) selected @endif> Có
                </option>
                <option value="0"
                    @if(!empty($category) && $category->is_outstand == 0) selected @endif> Không
                </option>
            </select>
        </div>
        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
    <div class="row mt-3 mb-3">
        <div class="col-2 d-flex flex-row-reverse align-items-center">Hiển thị :</div>
        <div class="col-2 d-flex align-items-center">
            <select class="form-control" aria-label="Default" name="is_public">
                <option value="1"
                    @if(!empty($category) && $category->is_public == 1) selected @endif> Có
                </option>
                <option value="0"
                    @if(!empty($category) && $category->is_public == 0) selected @endif> Không
                </option>
            </select>
        </div>
        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
    <div class="row mt-3 mb-3">
        <div class="col-2 d-flex flex-row-reverse align-items-center">Thứ tự hiển thị :</div>
        <div class="col-1">
            <input type="number" class="form-control" style="width:80px" name="stt_cate" value="{{ old('stt_cate', $category->stt_cate ?? '') }}">
        </div>
        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
</div>