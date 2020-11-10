@extends('layouts.admindashboard')
@section('content')
    <div class="content-wrapper">


        <div class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Artículos</h1>
                    </div>
                </div>
            </div>
        </div>
        @if (session()->has('success_message'))
            <div class="w-100 d-flex justify-content-center">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session()->get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        @if (session()->has('failure_message'))
            <div class="w-100 d-flex justify-content-center">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session()->get('failure_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        <div class="content">
            <div class="card container-xl">
                <div class="table-responsive">
                    <div class="card-body table-wrapper">
                        <div class="table-title">
                            <div class="row">
                                <div class="w-100 d-flex justify-content-end">
                                    <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i
                                            class="fas fa-plus"></i><span> Añadir artículo</span></a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Precio</th>
                                    <th>Foto</th>
                                    <th>Género</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($articulos as $articulo)
                                    <tr>
                                        <input type="hidden" name="idArt" id="idArt" value="{{ $articulo->idArticulo }}">
                                        <td>{{ $articulo->nombreArticulo }}</td>
                                        <td>{{ $articulo->categoriaArticulo }}</td>
                                        <td>{{ $articulo->precioArticulo }}</td>
                                        @if ($articulo->photoArticulo)
                                            <td><img width="100 rem" src="{{ asset('store/' . $articulo->photoArticulo) }}"
                                                    alt="{{ $articulo->photoArticulo }}"></td>
                                        @else
                                            <td><img width="100 rem" src="{{ asset('store/no-image.jpg') }}" alt=""></td>
                                        @endif
                                        @switch($articulo->generoArticulo)
                                            @case(1)
                                            <td>Hombre</td>
                                            @break
                                            @case(2)
                                            <td>Mujer</td>
                                            @break
                                            @default
                                            <td>Unisex</td>
                                        @endswitch
                                        <td>
                                            <a href="#editEmployeeModal" class="edit mr-2" data-toggle="modal"><i
                                                    class="fas fa-pencil-alt text-warning" data-toggle="tooltip" title="Editar"
                                                    name="editbutton"></i></a>
                                            <a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i
                                                    class="fas fa-trash text-danger" data-toggle="tooltip" title="Borrar"
                                                    name="deletebutton"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <strong>No hay artículos registrados</strong>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Edit Modal HTML -->
            <div id="addEmployeeModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('admin.articulos.store') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <h4 class="modal-title">Añadir articulo</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" name="nombreArticulo" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Categoria</label>
                                    <select class="form-control" name="categoriaArticulo" id="categoriaArticulo" required>
                                        <option value="" hidden>Seleccionar</option>
                                        <option value="Jean">Jean</option>
                                        <option value="Casaca">Casaca</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Precio</label>
                                    <input type="number" min="0" step=".01" name="precioArticulo" class="form-control"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label>Género</label>
                                    <select class="form-control" name="generoArticulo" id="generoArticulo" required>
                                        <option value="" hidden>Seleccionar</option>
                                        <option value="1">Hombre</option>
                                        <option value="2">Mujer</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Foto</label>
                                    <input type="file" name="fotoArticulo" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                                <input type="submit" class="btn btn-success" value="Añadir">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Edit Modal HTML -->
            <div id="editEmployeeModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('admin.articulos.edit') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <h4 class="modal-title">Editar articulo</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="idArticulo" required>
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" name="nombreArticulo" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Categoria</label>
                                    <select class="form-control" name="categoriaArticulo" id="categoriaArticulo" required>
                                        <option value="" hidden>Seleccionar</option>
                                        <option value="Jean">Jean</option>
                                        <option value="Casaca">Casaca</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Precio</label>
                                    <input type="number" min="0" step=".01" name="precioArticulo" class="form-control"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label>Género</label>
                                    <select class="form-control" name="generoArticulo" id="generoArticulo" required>
                                        <option value="" hidden>Seleccionar</option>
                                        <option value="1">Hombre</option>
                                        <option value="2">Mujer</option>
                                        {{-- <option value="3">Unisex</option>
                                        --}}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Foto</label>
                                    <input type="file" name="fotoArticulo" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                                <input type="submit" class="btn btn-success" value="Editar">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Delete Modal HTML -->
            <div id="deleteEmployeeModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('admin.articulos.destroy') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="idArticulo" required>
                            <div class="modal-header">
                                <h4 class="modal-title">Eliminar articulo</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>Estas seguro de que deseas eliminar este articulo?</p>
                                <p class="text-warning"><small>Esta accion no se puede deshacer</small></p>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                                <input type="submit" class="btn btn-danger" value="Eliminar">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/articuloAdmin.js') }}"></script>
@endsection
