const { default: Axios } = require("axios");
const { forEach } = require("lodash");
const vm = new Vue({
    el: '#articulos_talla_admin',
    data() {
        return {
            articulos: [],
            message: '',
            articuloscant: 0,
            talla: {
                id: "",
                talla: "",
                stock: "",
                estado: "",
            },
            newtalla: {
                id: "",
                talla: "",
                stock: "",
                estado: "",
            },
            componentKey: 0,
            iddelete: '',
            success: '',
            message: '',
            tallasArticulo: '',

        };
    },
    created() {
        Axios.get('/admin/articulostalla/get').then(response => {
            vm.articulos = response.data.articulos
            vm.articuloscant = response.data.articuloscant
        })
    },
    methods: {
        obtener: () => {
            Axios.get('/admin/articulostalla/get').then(response => {
                vm.articulos = response.data.articulos
                vm.articuloscant = response.data.articuloscant
                vm.componentKey++
            })
        },
        modificarshow: (datos) => {
            vm.talla.id = datos.idArticuloTalla
            vm.talla.talla = datos.nombreTalla
            vm.talla.stock = datos.stockArticulo
            console.log(vm.talla)
            $('#editEmployeeModal').modal('show')
        },

        modificar: (datos) => {
            $('#editEmployeeModal').modal('hide')
            Axios.post(`/admin/articulostalla/edit`, {
                    idArticulo: datos.id,
                    stockArticulo: datos.stock,
                })
                .then(function(response) {
                    vm.obtener()
                    vm.success = response.data.success
                    vm.message = response.data.message
                })
                .catch(function(error) {
                    vm.obtener()
                });
        },
        añadirShow: (articulo) => {
            vm.newtalla.id = articulo.idArticulo
            vm.newtalla.talla = ''
            vm.newtalla.stock = ''
            vm.newtalla.estado = ''
            axios.patch(`/admin/articulostalla/obtain/${articulo.idArticulo}`, {
                    category: articulo.categoriaArticulo
                })
                .then(function(response) {
                    vm.tallasArticulo = response.data.talla
                })
                .catch(function(error) {
                    console.log(error);
                });
            $('#addEmployeeModal').modal('show')
        },

        añadir: (tallanew) => {
            $('#addEmployeeModal').modal('hide')
            Axios.post(`/admin/articulostalla/store`, {
                    idArticulo: tallanew.id,
                    tallaArticulo: tallanew.talla,
                    stockArticulo: tallanew.stock
                })
                .then(function(response) {
                    vm.success = response.data.success
                    vm.message = response.data.message
                    vm.obtener()
                })
                .catch(function(error) {
                    vm.obtener()
                });
        },

        deleteShow: (dato) => {
            vm.talla.id = dato.idArticuloTalla
            $('#deleteEmployeeModal').modal('show')
        },
        eliminar: (dato) => {
            $('#deleteEmployeeModal').modal('hide')
            Axios.post(`/admin/articulostalla/destroy/${dato}`)
                .then(function(response) {
                    console.log(response)
                    vm.obtener()
                    vm.success = response.data.success
                    vm.message = response.data.message
                })
                .catch(function(error) {
                    vm.obtener()
                });
        }
    }
})