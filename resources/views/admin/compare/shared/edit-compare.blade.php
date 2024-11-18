<div class="text-dark">
    <div class="row">
        <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Giá trị so sánh :<div class="warningMenu">*</div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="text" name="key_word" id="keyword" class="form-control" value="{{ old('key_word', $compare->key_word ?? '') }}">
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
            <button class="btn btn-primary" id="edit-compare">Thêm giá trị</button>
        </div>
    </div>
    <div class="row">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="compares-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-sm-1">No.</th>
                            <th class="col-sm-6 text-center">Tên giá trị so sánh</th>
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
                            <td>
                                <a href="{{ asset('/admin/compares/' . $item->id) }}" class="btn-sm btn-destroy" data-id="{{ $item->id }}">Xóa</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>