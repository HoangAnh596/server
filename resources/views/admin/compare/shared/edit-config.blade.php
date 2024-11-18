<div class="text-dark">
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Tên so sánh:<div class="warningMenu">*</div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $compare->name ?? '') }}" oninput="checkDuplicate()">
                <span id="name-error" style="color: red;"></span>
            </div>
        </div>
        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center">Danh mục sản phẩm :</div>
        <div class="col-6">
            <div class="form-group">
                <select name="cate_id" id="cate_id" class="form-control" size="12" style="width: 600px;">
                    @foreach($categories as $val)
                    @include('admin.compare.partials.compare-add', ['category' => $val, 'level' => 0, 'prefix' => '|---', 'selected' => $compare->cate_id])
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
                <option value="1"
                    @if(!empty($compare) && $compare->is_public == 1) selected @endif>
                    Hiển Thị
                </option>
                <option value="0"
                    @if(!empty($compare) && $compare->is_public == 0) selected @endif>
                    Không hiển thị
                </option>
            </select>
        </div>
        <div class="d-flex align-items-center" style="height: 38px; color: red; padding-left: 50px;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
    <div class="row mt-3 mb-3">
        <div class="col-2 d-flex flex-row-reverse align-items-center">Thứ tự hiển thị :</div>
        <div class="col-1">
            <input type="number" style="width:60px" name="stt_compare" value="{{ old('stt_compare', $compare->stt_compare ?? '') }}">
        </div>
        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
</div>