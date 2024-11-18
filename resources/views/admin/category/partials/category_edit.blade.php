<!-- partials/category-edit.blade.php -->
<option value="{{ $category->id }}" {{ $category->id == $selected ? 'selected' : '' }}>
    {{ str_repeat('--| ', $level) }} {{ $category->name }}
</option>
@if($category->children)
    @foreach($category->children as $child)
        @include('admin.category.partials.category_edit', ['category' => $child, 'level' => $level + 1, 'selected' => $selected])
    @endforeach
@endif