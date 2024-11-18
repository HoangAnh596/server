<option value="{{ $category->id }}" data-slug="{{ $category->slug }}" {{ (int)$category->id === (int)$selected ? 'selected' : '' }}>
    {{ str_repeat('--| ', $level) }} {{ $category->name }}
</option>
@if($category->children)
    @foreach($category->children as $child)
        @include('admin.news.partials.category-edit', ['category' => $child, 'level' => $level + 1, 'selected' => $selected])
    @endforeach
@endif