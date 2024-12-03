<div class="text-dark">
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line pb-3">Cấu hình : <div class="warningMenu">*</div></div>
        <div class="col-8 pb-3">
            <input type="text" name="config_pr" class="form-control" value="{{old('config_pr', $product->config_pr ?? '') }}">
        </div>
        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line pb-3">CPU : <div class="warningMenu">*</div></div>
        <div class="col-8 d-flex align-items-center pb-3">
            <input type="text" name="cpu_pr" class="form-control" value="{{ old('cpu_pr', $product->cpu_pr ?? '') }}">
        </div>
        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line pb-3">RAM : <div class="warningMenu">*</div></div>
        <div class="col-8 d-flex align-items-center pb-3">
            <input type="text" name="ram_pr" class="form-control" value="{{ old('ram_pr', $product->ram_pr ?? '') }}">
        </div>
        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line pb-3">Ổ đĩa : <div class="warningMenu">*</div></div>
        <div class="col-8 d-flex align-items-center pb-3">
            <input type="text" name="hdd_pr" class="form-control" value="{{ old('hdd_pr', $product->hdd_pr ?? '') }}">
        </div>
        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
</div>