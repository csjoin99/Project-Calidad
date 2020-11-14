const { default: Axios } = require("axios");
const { forEach } = require("lodash");
const vm = new Vue({
    el: '#articulosadmin',
    data() {
        return {
            articulos: [],
            message: '',
            cant: 0,
            articulo: {
                idArticulo: "",
                nombreArticulo: "",
                categoriaArticulo: "",
                precioArticulo: "",
                generoArticulo: "",
                photoArticulo: "",
                estadoArticulo: ""
            },
            newarticulo: {
                idArticulo: "",
                nombreArticulo: "",
                categoriaArticulo: "",
                precioArticulo: "",
                generoArticulo: "",
                photoArticulo: "",
                estadoArticulo: ""
            },
            componentKey: 0,
            tempimg: '',
            iddelete: '',
            success: '',
            message: ''
        };
    },
    created() {
        Axios.get('/admin/articulosget').then(response => {
            vm.articulos = response.data[0]
            vm.cant = response.data[1]
        })
    },
    methods: {
        obtener: () => {
            Axios.get('/admin/articulosget').then(response => {
                vm.articulos = response.data[0]
                vm.cant = response.data[1]
                vm.componentKey++
            })
        },
        modificarshow: (datos) => {
            vm.articulo.idArticulo = datos.idArticulo
            vm.articulo.nombreArticulo = datos.nombreArticulo
            vm.articulo.categoriaArticulo = datos.categoriaArticulo
            vm.articulo.generoArticulo = datos.generoArticulo
            vm.articulo.precioArticulo = datos.precioArticulo
            vm.articulo.photoArticulo = datos.photoArticulo
            vm.tempimg = ''
            $('#editEmployeeModal').modal('show')
        },
        modificar: (idarticulo) => {
            $('#editEmployeeModal').modal('hide')
            Axios.post(`/admin/articulos/edit/${idarticulo}`, {
                    nombreArticulo: vm.articulo.nombreArticulo,
                    categoriaArticulo: vm.articulo.categoriaArticulo,
                    generoArticulo: vm.articulo.generoArticulo,
                    precioArticulo: vm.articulo.precioArticulo,
                    photoArticulo: vm.tempimg
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
        añadirShow: () => {
            vm.newarticulo.idArticulo = ''
            vm.newarticulo.nombreArticulo = ''
            vm.newarticulo.categoriaArticulo = ''
            vm.newarticulo.precioArticulo = ''
            vm.newarticulo.generoArticulo = ''
            vm.newarticulo.photoArticulo = ''
            vm.newarticulo.estadoArticulo = ''
            $('#addEmployeeModal').modal('show')
        },
        añadir: () => {
            $('#addEmployeeModal').modal('hide')
            Axios.post(`/admin/articulos/store`, {
                    nombreArticulo: vm.newarticulo.nombreArticulo,
                    categoriaArticulo: vm.newarticulo.categoriaArticulo,
                    precioArticulo: vm.newarticulo.precioArticulo,
                    generoArticulo: vm.newarticulo.generoArticulo,
                    photoArticulo: vm.tempimg
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
        deleteShow: (id) => {
            vm.iddelete = id
            $('#deleteEmployeeModal').modal('show')
        },
        eliminar: (id) => {
            $('#deleteEmployeeModal').modal('hide')
            Axios.post(`/admin/articulos/destroy/${vm.iddelete}`)
                .then(function(response) {
                    vm.obtener()
                    vm.success = response.data.success
                    vm.message = response.data.message
                })
                .catch(function(error) {
                    vm.obtener()
                });
        },
        imageChange: (e) => {
            let reader = new FileReader
            reader.readAsDataURL(e.target.files[0])
            reader.onload = (e) => {
                vm.tempimg = e.target.result
            }
        }
    }
})