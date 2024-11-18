<!-- resources/views/cateMenu/partials/category_row.blade.php -->
<tr class="parent-{{ $category->parent_id ?? '' }} {{ $level > 0 ? 'hidden nested' : '' }}">
    <td>
        @if ($category->permissionsChild->isNotEmpty())
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
        {{ $category->display_name }}
    </td>
    <td>
        {{ $category->key_code }}
    </td>
    <td class="action">
        @can('permission-edit')
        <a href="{{ asset('admin/permissions/'.$category->id.'/edit') }}">Chỉnh sửa</a> |
        @endcan
        <a href="{{ asset('admin/permissions') }}">Xóa cache</a> |
        @can('permission-delete')
        <a href="javascript:void(0);" onclick="confirmDelete('{{ $category->id }}')">Xóa</a>
        <form id="deleteForm-{{ $category->id }}" action="{{ route('permissions.destroy', ['id' => $category->id]) }}" method="post" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        @endcan
    </td>
</tr>
@if ($category->permissionsChild)
@foreach ($category->permissionsChild as $child)
@include('admin.permission.partials.children', ['category' => $child, 'level' => $level + 1])
@endforeach
@endif