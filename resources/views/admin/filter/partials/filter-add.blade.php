<option value="{{ $category->id }}" {{ (int) old('cate_id', $selected) === (int) $category->id ? 'selected' : '' }}>
    {{ str_repeat($prefix, $level) }} {{ $category->name }}
</option>
@if($category->children)
    @foreach($category->children as $child)
        @include('admin.filter.partials.filter-add', [
            'category' => $child, 
            'level' => $level + 1, 
            'prefix' => $prefix,
            'selected' => $selected
        ])
    @endforeach
@endif