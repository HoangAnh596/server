<div class="text-dark">
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Tên bộ lọc :<div class="warningMenu">*</div>
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
        <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Tên tìm kiếm url :<div class="warningMenu">*</div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" oninput="checkDuplicate()">
                <span id="slug-error" style="color: red;"></span>
            </div>
        </div>
        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center">Danh mục sản phẩm :</div>
        <div class="col-6">
            <div class="form-group">
                <select name="cate_id" id="cate_id" class="form-control" size="12" style="width: 100%;">
                    <option value="" style="display: none;"></option>
                    @foreach($categories as $val)
                    @include('admin.filter.partials.filter-add', ['category' => $val, 'level' => 0, 'prefix' => '|---', 'selected' => old('cate_id', $idCate)])
                    @endforeach
                </select>
            </div>
        </div>
        <div style="height: 38px; color: red; margin-left: 20px;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
    <div class="row mt-3 mb-3">
        <div class="col-2 d-flex flex-row-reverse">Hiển thị :</div>
        <div class="col-1">
            <select class="form-select" aria-label="Default" name="is_public">
                <option value="1">Có</option>
                <option value="0">Không</option>
            </select>
        </div>
        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
    <div class="row mt-3 mb-3">
        <div class="col-2 d-flex flex-row-reverse align-items-center">Thứ tự hiển thị :</div>
        <div class="col-1">
            <input type="number" style="width:60px" name="stt_filter">
        </div>
        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
</div>