<!-- resources/views/category/partials/category_add.blade.php -->
<option value="{{ $category->id }}" {{ (int) old('cate_id', $selected) === (int) $category->id ? 'selected' : '' }}>
    {{ $prefix }}{{ $category->name }}
</option>
@if ($category->children)
    @foreach ($category->children as $child)
        @include('admin.question.partials.category_add', ['category' => $child, 'level' => $level + 1, 'prefix' => $prefix . '|---', 'selected' => $selected])
    @endforeach
@endif