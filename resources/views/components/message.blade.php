@if( session('message') != null)
<li class="alert alert-success">{{ session('message') }}</li>
@endif

@if( session('success' ))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <li class="alert alert-danger">{{ $error }}</li>
    @endforeach
@endif
