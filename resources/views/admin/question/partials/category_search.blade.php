<option value="{{ $category->id }}" {{ \Request::get('cate') == $category->id ? "selected='selected'" : "" }}>
    {{ str_repeat('---| ', $level) . ' ' . $category->name }}
</option>
@if ($category->children->count() > 0)
    @foreach ($category->children as $child)
        @include('admin.question.partials.category_search', ['category' => $child, 'level' => $level + 1])
    @endforeach
@endif
