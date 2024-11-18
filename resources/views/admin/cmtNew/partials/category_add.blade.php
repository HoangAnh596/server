<option value="{{ $category->id }}" data-level="{{ $level }}" {{ (int) old('parent_id', $selectedCategory ?? '') == $category->id ? 'selected' : '' }}>
    {{ str_repeat('--| ', $level * 1) }}{{ $category->name }}
</option>
@if ($category->children)
    @foreach ($category->children as $child)
        @include('admin.cateNew.partials.category_add', ['category' => $child, 'level' => $level + 1])
    @endforeach
@endif