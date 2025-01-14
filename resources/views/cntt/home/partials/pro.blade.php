@foreach($gr['products'] as $product)
<div class="col-w-5 col-xs-6 col-md-3 col-sm-6 mb-custom">
    <div class="card h-100">
        @php
        $mainImage = $product->product_images ? $product->product_images->firstWhere('main_img', 1) : null;
        @endphp

        @if($mainImage)
        @php
        $imagePath = $mainImage->image;
        $directory = dirname($imagePath);
        $filename = basename($imagePath);
        $newDirectory = $directory . '/small';
        $newImagePath = $newDirectory . '/' . $filename;
        @endphp
        <a class="btn-img" href="{{ asset($product->slug) }}">
            <img class="img-size" loading="lazy" width="232" height="174" src="{{ asset($newImagePath) }}" data-src="{{ asset($newImagePath) }}" srcset="{{ asset($newImagePath) }}" alt="{{ $mainImage->alt }}" title="{{ $mainImage->title }}">
        </a>
        @else
        <a class="btn-img" href="{{ asset($product->slug) }}">
            <img class="img-size" loading="lazy" width="232" height="174" src="{{ asset('storage/images/image-coming-soon.jpg') }}" data-src="{{ asset('storage/images/image-coming-soon.jpg') }}" alt="Image Coming Soon" title="Image Coming Soon">
        </a>
        @endif
        <div class="card-body">
            <div class="text-dark">
                <a href="{{ asset($product->slug) }}" class="text-decoration-none btn-link">
                    <h3>{{ $product->name }}</h3>
                </a>
            </div>
            <!-- @if($product->discount != 0)
            <div class="prd-sale">
                <p class="prd-sale-detail">
                    Giảm {{ $product->discount }}%
                </p>
            </div>
            @endif -->
            <div class="config-outstand mt-2 mb-2">
                @if(!empty($product->config_pr))
                <p>
                    <span>Cấu hình: {{ $product->config_pr }}</span>
                </p>
                @endif
                @if(!empty($product->cpu_pr))
                <p title="Hỗ trợ CPU">
                    <img src="{{ asset('cntt/img/cpu.png') }}"> {{ $product->cpu_pr }}
                </p>
                @endif
                @if(!empty($product->ram_pr))
                <p title="Hỗ trợ RAM">
                    <img src="{{ asset('cntt/img/ram.png') }}"> {{ $product->ram_pr }}
                </p>
                @endif
                @if(!empty($product->hdd_pr))
                <p title="Ổ đĩa">
                    <img src="{{ asset('cntt/img/hdd.png') }}"> {{ $product->hdd_pr }}
                </p>
                @endif
            </div>
            <ul class="list-unstyled d-flex justify-content-between align-items-center total-review-home">
                @if($product->price == 0)
                <li><span class="lien-he-price">Liên hệ</span></li>
                @else
                @if($product->discount != 0)
                <li>
                    <a href="{{ asset('/' . $product->slug) }}" class="text-decoration-none text-danger">
                        {{ number_format($product->price * (1 - $product->discount / 100), 0, ',', '.') }}₫
                    </a>
                </li>
                <li class="d-flex align-items-start">
                    <a href="{{ asset('/' . $product->slug) }}" class="text-decoration-none price-sale text-secondary">
                        {{ number_format($product->price, 0, ',', '.') }}₫
                    </a>
                </li>
                @else
                <li>
                    <a href="{{ asset('/' . $product->slug) }}" class="text-decoration-none text-danger">
                        {{ number_format($product->price, 0, ',', '.') }}₫
                    </a>
                </li>
                @endif
                @endif
                <li class="text-muted text-right">
                    <i class="text-warning fa fa-star"></i>
                    <span>
                        @if ($product->totalCmt > 0)
                        {{ number_format($product->average_star, 1) }} ({{ $product->totalCmt }})
                        @endif
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endforeach