@extends('dashboard.master')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            Usuario: <strong>{{ $user->name }}</strong>
        </h4>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="surname">Apellido</label>
            <input readonly class="form-control" type="text" name="surname" id="surname" value="{{ $user->surname }}">
        </div>
    </div>
</div>

@endsection