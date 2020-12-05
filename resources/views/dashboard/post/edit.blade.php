@extends('dashboard.master')

@section('content')

@include('dashboard.partials.validation-error')

<a class="btn btn-success btn-sm float-right mb-5" href="{{ route('post.create') }}">
    <i class="fa fa-plus"></i>
</a>

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            Post: <strong>{{ $post->title }}</strong>
        </h4>
    </div>
    <div class="card-body">
        <form action="{{ route("post.update",$post->id) }}" method="POST">
            @method('PUT')
            @include('dashboard.post._form')
        </form>
    </div>
</div>


<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            Carga de imágenes para <strong>{{ $post->title }}</strong>
        </h4>
        <div class="card-category">
            Aquí podrás cargar más imágenes para este post
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route("post.image",$post) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col">
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="col">
                    <button class="btn btn-primary"><i class="fa fa-upload"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            Imágenes para <strong>{{ $post->title }}</strong>
        </h4>
        <div class="card-category">
            Todas las imágenes para <strong>{{ $post->title }}</strong>
        </div>
    </div>
    <div class="card-body">
        <div class="row mt-3">
            @foreach($post->images as $image)
                <div class="col-3">
                    <img class="w-100" src="{{ $image->getImageUrl() }}">
                    <a href="{{ route("post.image-download",$image->id) }}"
                        class="float-left btn btn-success btn-sm mt-1"><i class="fa fa-download"></i></a>

                    <form action="{{ route("post.image-delete",$image->id) }}" method="POST">
                        @method("DELETE")
                        @csrf
                        <button class="float-right btn btn-danger btn-sm mt-1" type="submit"><i class="fa fa-trash"></i></button>
                    </form>

                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection