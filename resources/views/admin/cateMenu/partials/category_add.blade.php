<!-- resources/views/category/partials/category_add.blade.php -->
<option value="{{ $category->id }}" data-level="{{ $level }}">
    {{ $prefix }}{{ $category->name }}
</option>
@if ($category->children)
    @foreach ($category->children as $child)
        @include('admin.cateMenu.partials.category_add', ['category' => $child, 'level' => $level + 1, 'prefix' => $prefix . '|---'])
    @endforeach
@endif