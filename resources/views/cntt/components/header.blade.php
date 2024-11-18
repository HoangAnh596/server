
    @php
    $agent = new Jenssegers\Agent\Agent();
    @endphp
    <!-- Header -->

    <!-- Modal -->
    <div class="modal fade bg-search" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="container">
            <div class="modal-dialog modal-lg modal-search" role="document">
                <form method="GET" action="{{ route('home.search') }}" class="modal-content modal-body border-0 p-0">
                    <div class="input-group">
                        <div class="form-group">
                            <select name="cate" class="form-control border search-cate">
                                <option value="prod">Tất cả sản phẩm</option>
                                <option value="news">Tất cả bài viết</option>
                                @if(isset($searchCate))
                                @foreach($searchCate as $category)
                                @php
                                $optionValue = $category->source . '_' . $category->id;
                                $isSelected = \Request::get('cate') == $optionValue ? "selected" : "";
                                @endphp
                                <option value="{{ $optionValue }}" {{ $isSelected }}>
                                    @if($category->source == 'prod')
                                    {{ $category->name }}--Sản phẩm
                                    @elseif($category->source == 'news')
                                    {{ $category->name }}--Bài viết
                                    @endif
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <input type="text" class="form-control" id="inputModalSearch" name="keyword" placeholder="Bạn cần tìm gì?">
                        <button type="submit" class="input-group-text bg-gr text-light">
                            <i class="fa fa-fw fa-search text-white"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Close Header -->
