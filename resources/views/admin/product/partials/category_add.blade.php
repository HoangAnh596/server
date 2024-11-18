<option value="{{ $category->id }}" data-level="{{ $level }}">
    {{ str_repeat('--| ', $level * 1) }}{{ $category->name }}
</option>
@if ($category->children)
    @foreach ($category->children as $child)
        @include('admin.product.partials.category_add', ['category' => $child, 'level' => $level + 1])
    @endforeach
@endif