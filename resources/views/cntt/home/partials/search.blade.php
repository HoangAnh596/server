@foreach($products as $product)
<div class="col-xs-6 col-s-3 col-md-4 col-sm-6 mb-custom">
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
        <a class="btn-img" href="{{ $product->slug }}">
            <img class="img-size" loading="lazy" width="214" height="160" src="{{ asset($newImagePath) }}" data-src="{{ asset($newImagePath) }}" srcset="{{ asset($newImagePath) }}" alt="{{ $mainImage->alt }}" title="{{ $mainImage->title }}">
        </a>
        @else
        <a class="btn-img" href="{{ $product->slug }}">
            <img class="img-size" loading="lazy" width="214" height="160" src="{{ asset('storage/images/image-coming-soon.jpg') }}" data-src="{{ asset('storage/images/image-coming-soon.jpg') }}" alt="Image Coming Soon" title="Image Coming Soon">
        </a>
        @endif
        <div class="card-body">
            <div class="text-dark">
                <a href="{{ $product->slug }}" class="text-decoration-none btn-link">
                    <h3>{{ $product->name }}</h3>
                </a>
            </div>
            <ul class="list-unstyled d-flex">
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
            </ul>
            <ul class="list-unstyled d-flex justify-content-between align-items-center total-review-home">
                <li class="text-muted text-right">
                    <i class="text-warning fa fa-star"></i>
                    <span>
                        @if ($product->totalCmt > 0)
                        {{ number_format($product->average_star, 1) }} ({{ $product->totalCmt }})
                        @endif
                    </span>
                </li>
                @if($product->status == 1)
                <li><span class="lien-he-price"><i class="fa-solid fa-check"></i> Còn hàng</span></li>
                @else
                <li></li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endforeach