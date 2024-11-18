<!-- resources/views/category/partials/category_add.blade.php -->
<option value="{{ $category->id }}" data-level="{{ $level }}" {{ $category->id == $selected ? 'selected' : '' }}>
    {{ $prefix }}{{ $category->name }}
</option>
@if ($category->children)
    @foreach ($category->children as $child)
        @include('admin.question.partials.category_edit', ['category' => $child, 'level' => $level + 1, 'prefix' => $prefix . '|---', 'selected' => $selected])
    @endforeach
@endif