@extends('dashboard.master')

@section('content')

@include('dashboard.partials.validation-error')

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            Crear un usuario
        </h4>
    </div>
    <div class="card-body">
        <form action="{{ route("user.store") }}" method="POST">
            @include('dashboard.user._form',['pasw' => true])
        </form>
    </div>
</div>
@endsection