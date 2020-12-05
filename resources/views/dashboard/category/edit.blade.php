@extends('dashboard.master')

@section('content')

@include('dashboard.partials.validation-error')

<a class="btn btn-success btn-sm float-right mb-5" href="{{ route('category.create') }}">
    <i class="fa fa-plus"></i>
</a>

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            Categoría: <strong>{{ $category->title }}</strong>
        </h4>
    </div>
    <div class="card-body">
        <form action="{{ route("category.update",$category->id) }}" method="POST">
            @method('PUT')
            @include('dashboard.category._form')
        </form>
    </div>
</div>

@endsection