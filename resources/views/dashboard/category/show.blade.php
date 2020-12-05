@extends('dashboard.master')

@section('content')
<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            Categoría: <strong>{{ $category->title }}</strong>
        </h4>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="title">Título</label>
            <input readonly class="form-control" type="text" name="title" id="title" value="{{ $category->title }}">
        </div>
        <div class="form-group">
            <label for="url_clean">Url limpia</label>
            <input readonly class="form-control" type="text" name="url_clean" id="url_clean" value="{{ $category->url_clean }}">
        </div>
    </div>
</div>

@endsection