
    <div class="review-row cmt" id="cmt">
        <div data-id="" id="review-item" class="view-comments-item level-{{ $level ?? 1 }}" data-fname="{{ $sendCmt->name }}">
            <div class="img-member-thumb">{{ strtoupper(mb_substr($sendCmt->name, 0, 1, 'UTF-8')) }}</div>
            <div class="name-member">{{ $sendCmt->name }}</div>
            <div class="content-comments">{!! $sendCmt->content !!}</div>
        </div>
    </div>