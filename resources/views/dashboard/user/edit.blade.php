@extends('dashboard.master')

@section('content')

@include('dashboard.partials.validation-error')

<a class="btn btn-success btn-sm float-right mb-5" href="{{ route('user.create') }}">
    <i class="fa fa-plus"></i>
</a>

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            Usuario: <strong>{{ $user->name }}</strong>
        </h4>
    </div>
    <div class="card-body">
        <form action="{{ route("user.update",$user->id) }}" method="POST">
            @method('PUT')
            @include('dashboard.user._form',['pasw' => false])
        </form>
    </div>
</div>

@endsection