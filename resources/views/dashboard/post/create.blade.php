@extends('dashboard.master')

@section('content')

@include('dashboard.partials.validation-error')


<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            Crear un super post
        </h4>
    </div>
    <div class="card-body">
        <form action="{{ route("post.store") }}" method="POST">
            @include('dashboard.post._form')
        </form>
    </div>
</div>
@endsection