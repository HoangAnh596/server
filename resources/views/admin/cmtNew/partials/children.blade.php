<!-- resources/views/cateMenu/partials/category_row.blade.php -->
<tr class="parent-{{ $category->parent_id ?? '' }} {{ $level > 0 ? 'hidden nested' : '' }}">
    @if ($category->parent_id == 0)
    <td>{{ (($comments->currentPage() - 1) * $comments->perPage()) + $loop->iteration }}</td>
    <td>
        <a href="{{ asset('/blogs/' . $category->slugNew) }}" target="_blank">{!! $category->content !!}</a>
    </td>
    <td>{{ $category->name }}</td>
    @else
    <td></td>
    <td>{!! $category->content !!}</td>
    <td style="color: red;">{{ $category->name }}</td>
    @endif
    <td>
        {{ $category->email }}
    </td>
    <td class="text-center">
        <input type="checkbox" class="active-checkbox" data-id="{{ $category->id }}" data-field="is_public" {{ ($category->is_public == 1) ? 'checked' : '' }}>
    </td>
    @if ($category->user_id == null)
    <td class="text-center">
        <input type="text" class="check-star" name="star" data-id="{{ $category->id }}" style="width: 40px;text-align: center;" value="{{ old('star', $category->star) }}">
    </td>
    @else
    <td></td>
    @endif
    @if ($category->parent_id == 0)
    <td style="font-size: 14px;">
        {{ $category->created_at->format('d-m-Y H:i') }}
    </td>
    @else
    <td style="font-size: 14px; color:red;">
        {{ $category->created_at->format('d-m-Y H:i') }}
    </td>
    @endif
    <td class="text-center action">
        @can('cmtNew-edit')
        <a href="{{ asset('admin/cmtNews/'.$category->id.'/edit') }}" >Chỉnh sửa</a> |
        @endcan
        @can('cmtNew-replay')
        @if ($category->parent_id == 0 && $category->replies->isEmpty())
        <a class="btn btn-primary btn-sm" href="{{ asset('admin/cmtNews/'.$category->id.'/replay') }}" >Trả lời</a> |
        @endif
        @endcan
        @can('cmtNew-delete')
        <a href="javascript:void(0);" onclick="confirmDelete('{{ $category->id }}')">Xóa</a>
        <form id="deleteForm-{{ $category->id }}" action="{{ route('cmtNews.destroy', ['id' => $category->id]) }}" method="post" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        @endcan
    </td>
</tr>
@if ($category->replies)
@foreach ($category->replies as $child)
@include('admin.cmtNew.partials.children', ['category' => $child, 'level' => $level + 1])
@endforeach
@endif