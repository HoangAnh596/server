@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- <marquee direction="right">HNA_CMS</marquee> -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Top 10 sản phẩm</h1>
        @can('product-add')
        <a href="{{ route('product.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Thêm sản phẩm</a>
        @endcan
    </div>
    <div class="row">
        @foreach($products as $item)
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ $item->name }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $item->price }}</div>
                        </div>
                        <div class="col-auto">
                            <img src="{{ asset($item->image) }}" width="120">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Top 10 tài khoản</h1>
        @can('user-add')
        <a href="{{ route('users.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Thêm tài khoản</a>
        @endcan
    </div>
    <div class="row">
        @foreach($users as $item)
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ $item->name }}</div>
                        </div>
                        <div class="col-auto">
                            <img src="{{ asset('users',$item->image) }}" width="120">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection