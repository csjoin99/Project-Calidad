@extends('layouts.admindashboard')
@section('content')
    <div id='articulos_talla_admin'>
        <div :key="componentKey" class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Artículos/Talla</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div  v-if="message">
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
                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Categoría</th>
                                        <th class="w-25">Añadir talla</th>
                                    </tr>
                                </thead>
                                <tbody v-if="articuloscant">
                                    <template v-for="articulo in articulos">
                                    <tr class="clickable" data-toggle="collapse" :id="articulo.idArticulo"
                                        :data-target="'.'+articulo.idArticulo+'collapsed'" style="cursor: pointer">
                                        <td v-text="articulo.nombreArticulo"></td>
                                        <td v-text="articulo.categoriaArticulo"></td>
                                        <td>
                                            <a href="#" v-on:click.prevent="añadirShow(articulo)" class="edit mr-2 " data-toggle="modal"><i
                                                    class="fas fa-plus text-success" data-toggle="tooltip" title="Añadir"
                                                    name="addbutton" :id="articulo.idArticulo"></i></a>
                                        </td>
                                    </tr>
                                    <tr v-if="articulo.cant" :class="'collapse out budgets '+articulo.idArticulo+'collapsed'">
                                        <td colspan="3" class="p-0">
                                            <table class="table table-sm table-hover">
                                                <thead>
                                                    <th class="w-50">Talla</th>
                                                    <th class="w-25">Stock</th>
                                                    <th class="w-25">Acciones</th>
                                                </thead>
                                                <tr v-for="talla in articulo.arrayTalla" style="background-color: white">
                                                    <td v-text="talla.nombreTalla"></td>
                                                    <td v-text="talla.stockArticulo"></td>
                                                    <td>
                                                        <a href="#" class="edit mr-2"
                                                            v-on:click.prevent="modificarshow(talla)" data-toggle="modal"><i
                                                            class="fas fa-pencil-alt text-warning"
                                                            data-toggle="tooltip" title="Edit"
                                                            name="editbutton"></i></a>
                                                        <a href="#" class="delete"
                                                            v-on:click.prevent="deleteShow(talla)" data-toggle="modal"><i class="fas fa-trash text-danger"
                                                            data-toggle="tooltip" title="Delete"
                                                            name="deletebutton"></i></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr v-else :class="'collapse out budgets '+articulo.idArticulo+'collapsed'">
                                        <td colspan="2" class="text-danger"><strong>El articulo no tiene tallas</strong>
                                        </td>
                                    </tr>
                                </template>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="3">
                                            <strong>No hay artículos registrados</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Add Modal HTML -->
                <div id="addEmployeeModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" v-on:submit.prevent="añadir(newtalla)">
                                {{ csrf_field() }}
                                <div class="modal-header">
                                    <h4 class="modal-title">Añadir talla a articulo</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Añadir talla a articulo</label>
                                        <select v-model="newtalla.talla" class="form-control" name="tallaArticulo" id="tallaArticulo" required>
                                            <option value="" hidden>Seleccionar</option>
                                            <option v-for="tarticulo in tallasArticulo" :value="tarticulo.idTalla" v-text="tarticulo.nombreTalla"></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Stock inicial</label>
                                        <input v-model="newtalla.stock" type="number" class="form-control" min="0" value="0" step="1"
                                            name="stockArticulo" required>
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
                            <form method="POST" v-on:submit.prevent="modificar(talla)">
                                {{ csrf_field() }}
                                <div class="modal-header">
                                    <h4 class="modal-title">Editar</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Talla</label>
                                        <input type="text" class="form-control" min="0" step="1" name="tallaArticulo"
                                            id="tallareadonly" v-model="talla.talla" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Stock</label>
                                        <input v-model="talla.stock" type="number" class="form-control" min="0" step="1" name="stockArticulo"
                                            required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                                    <input type="submit" class="btn btn-info" value="Guardar">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Delete Modal HTML -->
                <div id="deleteEmployeeModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" v-on:submit.prevent="eliminar(talla.id)">
                                {{ csrf_field() }}
                                <div class="modal-header">
                                    <h4 class="modal-title">Eliminar talla de articulo</h4>
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
    </div>
    
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/articulo-talla.js') }}"></script>
    {{-- <script>
        const addbutton = document.getElementsByName('addbutton');
        const tallaArticulo = document.getElementById('tallaArticulo');
        const stockArticulo = document.getElementsByName('stockArticulo');
        const idArticulo = document.getElementsByName('idArticulo')
        const editbutton = document.getElementsByName('editbutton')
        const tallareadonly = document.getElementById('tallareadonly')
        const deletebutton = document.getElementsByName('deletebutton')
        for (let i = 0; i < addbutton.length; i++) {
            addbutton[i].addEventListener("click", function() {
                let id = addbutton[i].getAttribute('id')
                let row = addbutton[i].closest('tr')
                let optlenght = tallaArticulo.options.length
                axios.patch(`/admin/articulostalla/obtain/${id}`, {
                        category: row.children[1].textContent
                    })
                    .then(function(response) {
                        for (j = optlenght - 1; j >= 1; j--) {
                            tallaArticulo.options[j] = null
                        }
                        response.data.talla.forEach(element => {
                            let opt = document.createElement("option")
                            opt.value = element.idTalla
                            opt.innerHTML = element.nombreTalla
                            tallaArticulo.appendChild(opt)
                        });
                        idArticulo[0].value = response.data.id
                        console.log(response);
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            });
        }
        for (let i = 0; i < stockArticulo.length; i++) {
            stockArticulo[i].addEventListener("input", function() {
                let valtemp = stockArticulo[i].value
                /* alert(stockArticulo[i]) */
                if (valtemp < 0) {
                    stockArticulo[i].value = 0
                }
                if (String(stockArticulo[i]).indexOf(".") == -1) {
                    stockArticulo[i].value = parseFloat(valtemp).toFixed(0);
                }
            });
        }
        for (let i = 0; i < editbutton.length; i++) {
            editbutton[i].addEventListener("click", () => {
                let row = editbutton[i].closest('tr')
                idArticulo[1].value = row.children[0].value
                tallareadonly.value = row.children[1].textContent
                stockArticulo[1].value = row.children[2].textContent
            })
        }
        for (let i = 0; i < deletebutton.length; i++) {
            deletebutton[i].addEventListener("click", () => {
                let row = deletebutton[i].closest('tr')
                idArticulo[2].value = row.children[0].value
            })
        }

    </script> --}}
@endsection
