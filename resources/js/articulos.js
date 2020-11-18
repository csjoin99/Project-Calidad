const { default: Axios } = require("axios");
const { forEach } = require("lodash");
const vm = new Vue({
    el: '#articulosadmin',
    data() {
        return {
            init: '',
            articulos: [],
            message: '',
            cant: 0,
            pagination: {
                total: 0,
                perpage: 0,
            },
            lastpage: '',
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
            message: '',
            isActivated: '',
            pagesNumber: ''
        };
    },
    created() {
        Axios.get('/admin/articulos/get').then(response => {
            vm.cant = response.data.length
            vm.pagination = response.data.pagination
            vm.articulos = vm.pagination.data
            vm.lastpage = vm.pagination.last_page
            vm.pagesNumber = vm.checkpagesNumber()
            vm.isActivated = vm.checkisActivated()
            vm.init = 1
            console.log(vm.pagesNumber)
        })
    },
    computed: {

    },
    methods: {
        obtener: (page) => {
            Axios.get(`/admin/articulos/get?page=${page}`).then(response => {
                vm.cant = response.data.length
                vm.pagination = response.data.pagination
                vm.articulos = vm.pagination.data
                vm.lastpage = vm.pagination.last_page
                vm.pagesNumber = vm.checkpagesNumber()
                vm.isActivated = vm.checkisActivated()
                console.log(vm.pagesNumber)
                console.log(vm.pagination)
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
                    vm.obtener(vm.pagination.current_page)
                    vm.success = response.data.success
                    vm.message = response.data.message
                })
                .catch(function(error) {
                    vm.obtener(vm.pagination.current_page)
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
                    vm.obtener(vm.pagination.current_page)
                    vm.success = response.data.success
                    vm.message = response.data.message
                })
                .catch(function(error) {
                    vm.obtener(vm.pagination.current_page)
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
                    vm.obtener(vm.pagination.current_page)
                    vm.success = response.data.success
                    vm.message = response.data.message
                })
                .catch(function(error) {
                    vm.obtener(vm.pagination.current_page)
                });
        },
        imageChange: (e) => {
            let reader = new FileReader
            reader.readAsDataURL(e.target.files[0])
            reader.onload = (e) => {
                vm.tempimg = e.target.result
            }
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
            var from = vm.pagination.current_page - 3
            var to = vm.pagination.current_page + 3
            if (from < 1) {
                from = 1
            }
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