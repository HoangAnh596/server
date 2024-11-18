@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="row g-0">
        <div class="col-md-4">
            <form action="{{ route('categories.destroy', ['category' => $category->id]) }}" method="post">
                @csrf
                @method( 'Delete' )
                <input type="submit" class="btn btn-danger" value="Delete" onclick="return confirm('Do you really want to delete?')" />
            </form>

            <a href="javascript: void(0);" class="text-center d-block mb-4">
                <img src="{{ \App\Http\Helpers\Helper::getPath('categories', $category->image) }}" class="img-fluid w-75" alt="Category-img" />
            </a>
        </div>
        <div class="col-md-4">
            <h2>Thông tin danh mục: </h2>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>Tên danh mục:</b> {{ $category->name }}</li>
                <li class="list-group-item"><b>Danh mục cha:</b> @if($category->parent !=null) {{ $category->parent->name }}
                    @else No!
                    @endif
                </li>
                <li class="list-group-item"><b>Tiêu đề ảnh:</b> {{ $category->title_img }}</li>
                <li class="list-group-item"><b>Alt ảnh:</b> {{ $category->alt_img }}</li>
                <li class="list-group-item"><b>Thời gian tạo:</b> {{ $category->created_at }}</li>
                <li class="list-group-item"><b>Thời gian cập nhật:</b> {{ $category->updated_at }}</li>
            </ul>
        </div>
        <div class="col-md-4">
            <h2>Thông tin SEO:</h2>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>Tiêu đề SEO:</b> {{ $category->title_seo }}</li>
                <li class="list-group-item"><b>Từ khóa SEO:</b> {{ $category->keyword_seo }}</li>
                <li class="list-group-item"><b>Mô tả SEO:</b> {{ $category->des_seo }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection