<div class="text-dark">
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line pb-3">Facebook <div class="icon-social"><i class="fa-brands fa-facebook"></i></div></div>
        <div class="col-8 pb-3">
            <input type="text" name="facebook" class="form-control" value="{{ old('facebook', $setting->facebook ?? '') }}" id="facebook">
        </div>
    </div>
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line pb-3">Twitter <div class="icon-social"><i class="fa-brands fa-twitter"></i></div></div>
        <div class="col-8 pb-3">
            <input type="text" name="twitter" class="form-control" value="{{ old('twitter', $setting->twitter ?? '') }}" id="twitter">
        </div>
    </div>
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line pb-3">Youtube <div class="icon-social"><i class="fa-brands fa-instagram"></i></div></div>
        <div class="col-8 pb-3">
            <input type="text" name="youtube" class="form-control" value="{{ old('youtube', $setting->youtube ?? '') }}" id="youtube">
        </div>
    </div>
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line pb-3"> Tiktok<div class="icon-social"><i class="fa-brands fa-tiktok"></i></div></div>
        <div class="col-8 pb-3">
            <input type="text" name="tiktok" class="form-control" value="{{ old('tiktok', $setting->tiktok ?? '') }}" id="tiktok">
        </div>
    </div>
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line pb-3"> Pinterest <div class="icon-social"><i class="fa-brands fa-pinterest"></i></div></div>
        <div class="col-8 pb-3">
            <input type="text" name="pinterest" class="form-control" value="{{ old('pinterest', $setting->pinterest ?? '') }}" id="pinterest">
        </div>
    </div>
</div>