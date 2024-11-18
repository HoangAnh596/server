<li class="{{ in_array($category->id, old('subCategory', $selectedCategories ?? [])) ? 'selected' : '' }}">
    <input type="checkbox" name="subCategory[]" value="{{ $category->id }}"
        {{ in_array($category->id, old('subCategory', $selectedCategories ?? [])) ? 'checked' : '' }}>
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