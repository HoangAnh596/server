<div class="review-row cmt" id="cmt">
    <div data-id="" id="review-item" class="view-comments-item level-{{ $level ?? 1 }}" data-fname="{{ $sendCmt->name }}">
        <div class="img-member-thumb">{{ strtoupper(mb_substr($sendCmt->name, 0, 1, 'UTF-8')) }}</div>
        <div class="name-member">{{ $sendCmt->name }}</div>
        <div class="star-rated" title="5 sao">
            @if($sendCmt->star !== null)
            @for ($i = 1; $i <= 5; $i++)
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16" style="color: {{ $i <= $sendCmt->star ? '#ffc107' : '#ddd' }}">
                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                </svg>
            @endfor
            @endif
        </div>
        <div class="content-comments">{!! $sendCmt->content !!}</div>
    </div>
</div>