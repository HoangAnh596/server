<div class="contact-icon">
    <ul>
        @foreach ($contactIconGlobal as $icon)
        <li>
            <a class="{{ $icon->animation == 1 ? 'animation-icon' : '' }}" href="{{ asset($icon->url) }}" rel="nofollow" target="_blank">
                <img width="40" height="40" loading="lazy" data-src="{{ asset($icon->image) }}" src="{{ asset($icon->image) }}" srcset="{{ asset($icon->image) }}" alt="{{ $icon->name }}" title="{{ $icon->name }}">
            </a>
        </li>
        @endforeach
    </ul>
</div>