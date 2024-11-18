<li class="{{ in_array($category->id, old('subCategory', $selectedSubCategories ?? [])) ? 'selected' : '' }}">
    <input type="checkbox" name="subCategory[]" value="{{ $category->id }}" {{ in_array($category->id, old('subCategory', $selectedSubCategories ?? [])) ? 'checked' : '' }}>
    {{ str_repeat('--| ', $level * 1) }}{{ $category->name }}
</li>
@if ($category->children)
    @foreach ($category->children as $child)
        @include('admin.product.partials.subCategory_add', ['category' => $child, 'level' => $level + 1])
    @endforeach
@endif