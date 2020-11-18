const { default: Axios } = require("axios");
const { forEach } = require("lodash");
const vm = new Vue({
    el: '#articulos_talla_admin',
    data() {
        return {
            articulos: [],
            message: '',
            articuloscant: 0,
            pagination: '',
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
            isActivated: '',
            pagesNumber: '',
            lastpage: ''
        };
    },
    created() {
        Axios.get('/admin/articulostalla/get').then(response => {
            vm.articuloscant = response.data.articuloscant
            vm.pagination = response.data.pagination
            vm.articulos = vm.pagination.data
            vm.lastpage = vm.pagination.last_page
            vm.pagesNumber = vm.checkpagesNumber()
            vm.isActivated = vm.checkisActivated()
        })
    },
    methods: {
        obtener: (page) => {
            Axios.get(`/admin/articulostalla/get?page=${page}`).then(response => {
                vm.articuloscant = response.data.articuloscant
                vm.pagination = response.data.pagination
                vm.articulos = vm.pagination.data
                vm.lastpage = vm.pagination.last_page
                vm.pagesNumber = vm.checkpagesNumber()
                vm.isActivated = vm.checkisActivated()
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
                    vm.obtener(vm.pagination.current_page)
                    vm.success = response.data.success
                    vm.message = response.data.message
                })
                .catch(function(error) {
                    vm.obtener(vm.pagination.current_page)
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
                    vm.obtener(vm.pagination.current_page)
                })
                .catch(function(error) {
                    vm.obtener(vm.pagination.current_page)
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
                    vm.obtener(vm.pagination.current_page)
                    vm.success = response.data.success
                    vm.message = response.data.message
                })
                .catch(function(error) {
                    vm.obtener(vm.pagination.current_page)
                });
        },
        changePage: (page) => {
            vm.pagination.current_page = page
            vm.obtener(page)
        },
        checkisActivated: () => {
            return vm.pagination.current_page
        },
        checkpagesNumber: () => {
            if (!vm.pagination.to) {
                return []
            }
            var from = vm.pagination.current_page - 2
            if (from < 1) {
                from = 1
            }
            var to = from + 2
            if (to >= vm.lastpage) {
                to = vm.lastpage
            }
            var pagesArray = []
            while (from <= to) {
                pagesArray.push(from)
                from++
            }
            return pagesArray
        }
    }
})