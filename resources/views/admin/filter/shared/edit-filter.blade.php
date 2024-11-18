<div class="text-dark">
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Giá trị lọc :<div class="warningMenu">*</div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="text" name="key_word" id="keyword" class="form-control" value="{{ old('key_word', $filter->key_word ?? '') }}">
                <span id="keyword-error" style="color: red;"></span>
                @error('keyword')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
    </div>
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center">
            <button class="btn btn-primary" id="edit-filter">Thêm giá trị</button>
        </div>
    </div>
    <div class="row">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="filters-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-sm-1">No.</th>
                            <th class="col-sm-6 text-center">Giá trị bộ lọc</th>
                            <th class="col-sm-4 text-center">Thứ tự</th>
                            <th class="col-sm-1">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="existing-items">
                        @foreach($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-center">
                                {{ $item->key_word }}
                            </td>
                            <td class="text-center">
                                <input type="text" class="check-stt" data-id="{{ $item->id }}" style="width: 50px;text-align: center;" value="{{ old('stt', $item->stt) }}">
                            </td>
                            <td>
                                <a href="{{ asset('/admin/filters/' . $item->id) }}" class="btn-sm btn-destroy" data-id="{{ $item->id }}">Xóa</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>