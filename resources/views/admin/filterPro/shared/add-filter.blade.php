@if (!empty($filterCate))
@foreach($filterCate as $val)
<div class="filter">
    <div class="col" style="color: black;">{{ $val->name }} :</div>
    <div class="col mt-3">
        @foreach($val->valueFilters as $item)
            @if(!empty($val))
            <div class="form-check form-check-inline mr-3 ml-3">
                <input class="form-check-input" type="radio" name="{{ $val->name }}" id="{{ $item->id }}" 
                    value="{{ $item->id }}" 
                    @foreach($filterProducts as $fil)
                    @if($item->id == $fil->filter_id) checked @endif
                    @endforeach
                    />
                <label class="form-check-label" for="">
                    {{ $item->key_word }}
                </label>
            </div>
            @endif
        @endforeach
        <hr>
    </div>
</div>
@endforeach
@elseif (empty($filterCate))
<div class="col">Chưa có bộ lọc! Ấn vào <a href="{{ asset('admin/filters/create?cate_id=' . $idCate) }}">link</a> để thêm bộ lọc</div>
@endif
