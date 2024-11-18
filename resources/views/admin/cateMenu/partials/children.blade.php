<!-- resources/views/cateMenu/partials/category_row.blade.php -->
<tr class="parent-{{ $category->parent_menu ?? '' }} {{ $level > 0 ? 'hidden nested' : '' }}">
    <td>
        @if ($category->children->isNotEmpty())
        {{ str_repeat('--', $level) }}
        <button class="toggle-children" data-id="{{ $category->id }}">
            [+]
        </button>
        @else
        <span></span>
        @endif
        {{ str_repeat('---|', $level) }} {{ $category->name }}
    </td>
    <td>
        {{ $category->url }}
    </td>
    <td>
        <input type="text" class="form-control check-stt" name="stt_menu" data-id="{{ $category->id }}" style="text-align: center;" value="{{ old('stt_menu', $category->stt_menu) }}">
    </td>
    <td class="text-center">
        <input type="checkbox" class="active-checkbox" data-id="{{ $category->id }}" data-field="is_public" {{ ($category->is_public == 1) ? 'checked' : '' }}>
    </td>
    <td class="text-center">
        <input type="checkbox" class="active-checkbox" data-id="{{ $category->id }}" data-field="is_tab" {{ ($category->is_tab == 1) ? 'checked' : '' }}>
    </td>
    <td class="text-center">
        <input type="checkbox" class="active-checkbox" data-id="{{ $category->id }}" data-field="is_click" {{ ($category->is_click == 1) ? 'checked' : '' }}>
    </td>
    <td class="action">
        @can('menu-edit')
        <a href="{{ asset('admin/cateMenu/'.$category->id.'/edit') }}">Chỉnh sửa</a> |
        @endcan
        <a href="{{ asset('admin/cateMenu/'.$category->id.'/edit') }}">Xóa cache</a>
        <!-- <a href="{{ asset('admin/cateMenu/'.$category->id) }}" >Chi tiết</a> |  -->
    </td>
</tr>
@if ($category->children)
@foreach ($category->children as $child)
@include('admin.cateMenu.partials.children', ['category' => $child, 'level' => $level + 1])
@endforeach
@endif