@extends('layouts.admindashboard')
@section('content')
    <div id="articulosadmin">
        <div :key="componentKey" class="d-none" v-bind:class="[init==1 ? 'content-wrapper d-block' : 'content-wrapper d-none']">
            <div class="content-header container">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Artículos</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="message">
                <div v-if="success" class="w-100 d-flex justify-content-center">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span v-text="message"></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div v-else class="w-100 d-flex justify-content-center">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <span v-text="message"></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="card container-xl">
                    <div class="table-responsive">
                        <div class="card-body table-wrapper">
                            <div class="table-title">
                                <div class="row">
                                    <div class="w-100 d-flex justify-content-end">
                                        <a href="#" v-on:click.prevent="añadirShow(articulo)" class="btn btn-success"
                                            data-toggle="modal"><i class="fas fa-plus"></i><span> Añadir artículo</span></a>
                                    </div>
                                </div>
                            </div>
                            <table id="myTable" class="table table-striped table-hover">
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
                                <tbody v-if="cant">
                                    <tr v-for="articulo in articulos">
                                        <td v-text="articulo.nombreArticulo"></td>
                                        <td v-text="articulo.categoriaArticulo"></td>
                                        <td v-text="articulo.precioArticulo"></td>
                                        <td>
                                            <img v-if="articulo.photoArticulo" width="100 rem"
                                                v-bind:src="articulo.photoArticulo" :alt="articulo.nombreArticulo">
                                            <img v-else width="100 rem" src="{{ asset('store/no-image.jpg') }}"
                                                :alt="articulo.nombreArticulo">
                                        </td>
                                        <td v-if="articulo.generoArticulo === 1">Hombre</td>
                                        <td v-else>Mujer</td>
                                        <td>
                                            <a href="#" v-on:click.prevent="modificarshow(articulo)" class="edit mr-2"
                                                data-toggle="modal"><i class="fas fa-pencil-alt text-warning"
                                                    data-toggle="tooltip" title="Editar" name="editbutton"></i></a>
                                            <a href="#" class="delete" v-on:click.prevent="deleteShow(articulo.idArticulo)"
                                                data-toggle="modal"><i class="fas fa-trash text-danger"
                                                    data-toggle="tooltip" title="Borrar" name="deletebutton"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="6">
                                            <strong>No hay artículos registrados</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                                <ul class="pagination">
                                  <li class="page-item" v-if="pagination.current_page >1">
                                    <a class="page-link" href="#" aria-label="Previous" v-on:click.prevent="changePage(pagination.current_page-1)">
                                      <span aria-hidden="true">&laquo;</span>
                                      <span class="sr-only">Previous</span>
                                    </a>
                                  </li>
                                  <li v-for="page in pagesNumber" v-bind:class="[page == isActivated ? 'page-item active' : 'page-item']">
                                    <a class="page-link" href="#" v-text="page" v-on:click.prevent="changePage(page)"></a>
                                  </li>
                                  <li class="page-item"  v-if="pagination.current_page < lastpage">
                                    <a class="page-link" href="#" aria-label="Next" v-on:click.prevent="changePage(pagination.current_page+1)">
                                      <span aria-hidden="true">&raquo;</span>
                                      <span class="sr-only">Next</span>
                                    </a>
                                  </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- Add Modal HTML -->
                <div id="addEmployeeModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" v-on:submit.prevent="añadir(newarticulo)" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="modal-header">
                                    <h4 class="modal-title">Añadir articulo</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" name="nombreArticulo" class="form-control"
                                            v-model="newarticulo.nombreArticulo" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Categoria</label>
                                        <select class="form-control" name="categoriaArticulo" id="categoriaArticulo"
                                            v-model="newarticulo.categoriaArticulo" required>
                                            <option value="" hidden>Seleccionar</option>
                                            <option value="Jean">Jean</option>
                                            <option value="Casaca">Casaca</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Precio</label>
                                        <input type="number" min="0" step=".01" name="precioArticulo" class="form-control"
                                            v-model="newarticulo.precioArticulo" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Género</label>
                                        <select class="form-control" name="generoArticulo" id="generoArticulo"
                                            v-model="newarticulo.generoArticulo" required>
                                            <option value="" hidden>Seleccionar</option>
                                            <option value="1">Hombre</option>
                                            <option value="2">Mujer</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Foto</label>
                                        <input type="file" name="photoArticulo" class="form-control"
                                            v-on:change="imageChange">
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
                            <form method="POST" enctype="multipart/form-data"
                                v-on:submit.prevent="modificar(articulo.idArticulo)">
                                {{ csrf_field() }}
                                <div class="modal-header">
                                    <h4 class="modal-title">Editar articulo</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" name="nombreArticulo" class="form-control"
                                            v-model="articulo.nombreArticulo" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Categoria</label>
                                        <select class="form-control" name="categoriaArticulo" id="categoriaArticulo"
                                            v-model="articulo.categoriaArticulo" required>
                                            <option value="" hidden>Seleccionar</option>
                                            <option value="Jean">Jean</option>
                                            <option value="Casaca">Casaca</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Precio</label>
                                        <input type="number" min="0" step=".01" name="precioArticulo" class="form-control"
                                            v-model="articulo.precioArticulo" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Género</label>
                                        <select class="form-control" name="generoArticulo" id="generoArticulo"
                                            v-model="articulo.generoArticulo" required>
                                            <option value="" hidden>Seleccionar</option>
                                            <option value="1">Hombre</option>
                                            <option value="2">Mujer</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Foto</label>
                                        <input type="file" name="photoArticulo" class="form-control"
                                            v-on:change="imageChange">
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
                            <form method="POST" v-on:submit.prevent="eliminar(iddelete)">
                                {{ csrf_field() }}
                                <div class="modal-header">
                                    <h4 class="modal-title">Eliminar articulo</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
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

    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/articulos.js') }}"></script>
@endsection
