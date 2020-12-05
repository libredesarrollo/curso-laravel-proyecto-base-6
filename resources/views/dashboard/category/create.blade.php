@extends('dashboard.master')

@section('content')

@include('dashboard.partials.validation-error')

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            Crear una categoría
        </h4>
    </div>
    <div class="card-body">
        <form action="{{ route("category.store") }}" method="POST">
            @include('dashboard.category._form')
        </form>
    </div>
</div>
@endsection