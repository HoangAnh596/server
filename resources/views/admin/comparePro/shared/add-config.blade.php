<div class="text-dark">
    <div class="row">
        <div class="col-3 d-flex flex-row-reverse align-items-center" style="height: 38px;">Tên sản phẩm :<div class="warningMenu">*</div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="text" id="name" class="form-control" value="{{ old('name', $products->name ?? '') }}" disabled>
                <span id="name-error" style="color: red;"></span>
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3 d-flex flex-row-reverse align-items-center">Danh mục sản phẩm chính:</div>
        <div class="col-6">
            <div class="form-group">
                <select id="cate_id" class="form-control" size="10" style="width: 600px;" disabled>
                @foreach($categories as $val)
                    @include('admin.filter.partials.filter-add', ['category' => $val, 'level' => 0, 'prefix' => '|---', 'selected' => $idCate])
                @endforeach
                </select>
            </div>
        </div>
    </div>
</div>