<li class="{{ in_array($category->id, old('subCate', $selectedCategories ?? [])) ? 'selected' : '' }}">
    <input type="checkbox" name="subCate[]" value="{{ $category->id }}"
        {{ in_array($category->id, old('subCate', $selectedCategories ?? [])) ? 'checked' : '' }}>
    {{ str_repeat('--| ', $level ?? 0) . $category->name }}
</li>
@if ($category->children)
    @foreach ($category->children as $child)
        @include('admin.product.partials.subCategory_edit', [
            'category' => $child, 
            'selectedCategories' => $selectedCategories, 
            'level' => ($level ?? 0) + 1
        ])
    @endforeach
@endif