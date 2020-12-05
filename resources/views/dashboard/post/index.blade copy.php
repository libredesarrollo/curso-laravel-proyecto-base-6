@extends('dashboard.master')

@section('content')
<!--
<x-fragment.subview/>
<x-ejemploinline></x-ejemploinline>

<x-ejemplo message="Hola mundo Post" :posts="$posts" class="container"/>

<x-ejemplo message="Hola mundo Post" :posts="$posts" class="container">
    <p>Contenido adicional</p>

    <x-slot name="title">
        <h1>Título de nuestro listado</h1>
    </x-slot>

    <x-slot name="title3">
        Subtítulo
    </x-slot>

</x-ejemplo>-->

<a class="btn btn-success mt-3 mb-3" href="{{ route('post.create') }}">
    <i class="fa fa-plus"></i>
</a>

<a class="btn btn-primary mt-3 mb-3" href="{{ route('post.export') }}">
    <i class="fa fa-file"></i>
</a>

<form action="{{ route('post.index') }}" class="mb-2">
    <div class="row">
        <div class="col-md-4">
            <select name="created_at" class="form-control">
                <option value="DESC">Descendente</option>
                <option
                    {{ request('created_at') == "ASC" ? "selected" : '' }}
                    value="ASC">Ascendente</option>
            </select>
        </div>
        <div class="col-md-6">
            <input type="text" value="{{ request('search') }}" name="search" placeholder="Buscar..."
                class="ml-1 mt-1 form-control">
        </div>

        <div class="col-md-2">
            <button type="submit" class="ml-2 btn btn-success"><i class="fa fa-search"></i></button>
        </div>

    </div>
</form>

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            Listado de Post
        </h4>
        <div class="card-category">
            Aqui encontrarás todos los post y podrás filtrarlos
        </div>
    </div>
    <div class="card-body">

        <table class="table">
            <thead class="text-primary">
                <tr>
                    <th>
                        Id
                    </th>
                    <th>
                        Título
                    </th>
                    <th>
                        Categoría
                    </th>
                    <th>
                        Posteado
                    </th>
                    <th>
                        Creación
                    </th>
                    <th>
                        Actualización
                    </th>
                    <th>
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>
                            {{ $post->id }}
                        </td>
                        <td>
                            {{ $post->title }}
                        </td>
                        <td>
                            {{ $post->category->title }}
                        </td>
                        <td>
                            {{ $post->posted }}
                        </td>
                        <td>
                            {{ $post->created_at->format('d-m-Y') }}
                        </td>
                        <td>
                            {{ $post->updated_at->format('d-m-Y') }}
                        </td>
                        <td>
                            <a href="{{ route('post.show',$post->id) }}"
                                class="btn btn-primary"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('post.edit',$post->id) }}"
                                class="btn btn-primary"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('post-comment.post',$post->id) }}"
                                class="btn btn-primary"><i class="fa fa-comment"></i></a>
                            <button data-toggle="modal" data-target="#deleteModal" data-id="{{ $post->id }}"
                                class="btn btn-danger"><i class="fa fa-trash"></i></button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="m-3">
            {{ $posts->appends(
                [
                    'created_at' => request('created_at'),
                    'search' => request('search'),
                ]
                )->links() }}
        </div>
    </div>
</div>





<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Seguro que desea borrar el registro seleccionado?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                <form id="formDelete" method="POST" action="{{ route('post.destroy',0) }}"
                    data-action="{{ route('post.destroy',0) }}">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger">Borrar</button>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function () {

        $('#deleteModal').on('show.bs.modal', function (event) {

            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            action = $('#formDelete').attr('data-action').slice(0, -1)
            action += id
            console.log(action)

            $('#formDelete').attr('action', action)

            var modal = $(this)
            modal.find('.modal-title').text('Vas a borrar el POST: ' + id)
        });
    };
</script>

@endsection