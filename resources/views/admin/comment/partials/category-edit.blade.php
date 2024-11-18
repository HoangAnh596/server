<!-- partials/category-edit.blade.php -->
<option value="{{ $category->id }}" {{ (int)$category->id === (int)$selected ? 'selected' : '' }}>
    {{ str_repeat('--| ', $level) }} {{ $category->name }}
</option>
@if($category->children)
    @foreach($category->children as $child)
        @include('admin.cateNew.partials.category-edit', ['category' => $child, 'level' => $level + 1, 'selected' => $selected])
    @endforeach
@endif