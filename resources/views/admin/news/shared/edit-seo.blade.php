<div class="text-dark">
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line pb-3">Tiêu đề trang <div class="warningMenu">*</div></div>
        <div class="col-8 pb-3">
            <input type="text" name="title_seo" class="form-control" value="{{old('title_seo', $new->title_seo ?? '') }}" id="title_seo" onkeyup="delayedValidate('title_seo', 'titleSeoWarning', 50, 60)">
            <span class="text-danger" id="titleSeoWarning"></span>
        </div>
        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line pb-3">Thẻ từ khóa <div class="warningMenu">*</div></div>
        <div class="col-8 d-flex align-items-center pb-3">
            <input type="text" name="keyword_seo" class="form-control" value="{{ old('keyword_seo', $new->keyword_seo ?? '') }}">
        </div>
        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center vertical-line">Thẻ mô tả <div class="warningMenu">*</div></div>
        <div class="col-8">
            <textarea name="des_seo" class="form-control" id="des_seo" rows="5" onkeyup="delayedValidate('des_seo', 'desSeoWarning', 150, 160)">{{ old('des_seo', $new->des_seo ?? '') }}</textarea>
            <span class="text-danger" id="desSeoWarning"></span>
        </div>
        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
</div>