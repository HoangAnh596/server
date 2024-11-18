<!-- resources/views/category/partials/category_add.blade.php -->
<option value="{{ $category->id }}" data-slug="{{ $category->slug }}" data-level="{{ $level }}" {{ (int) old('cate_id', $selectedCategory ?? '') == $category->id ? 'selected' : '' }}>
    {{ str_repeat('--| ', $level * 1) }}{{ $category->name }}
</option>
@if ($category->children)
    @foreach ($category->children as $child)
        @include('admin.news.partials.category_add', ['category' => $child, 'level' => $level + 1])
    @endforeach
@endif