const { default: Axios } = require("axios");
const { forEach } = require("lodash");
const vm = new Vue({
    el: '#cartview',
    data() {
        return {
            items: [],
            message: '',
            cant: 0,
            totalcart: [],
            newitem: {
                rowId: "",
                id: "",
                name: "",
                qty: "",
                price: "",
                nombreTalla: "",
                categoriaArticulo: "",
                photoArticulo: ""
            },
            componentKey: 0,
            init: ''
        };
    },
    created() {
        Axios.get('/cart/get').then(response => {
            this.items = response.data[0]
            this.cant = response.data[2]
            this.totalcart = response.data[1]
            vm.init = 1
        })
    },
    methods: {
        obtener: () => {
            Axios.get('/cart/get').then(response => {
                vm.items = response.data[0]
                vm.cant = response.data[2]
                vm.totalcart = response.data[1]
                vm.componentKey += 1
            })
        },
        modificar: (item) => {
            let temp = item
            if (temp.qty < 1) {
                temp.qty = 1
            }
            Axios.patch(`/cart/${temp.rowId}`, {
                    qty: temp.qty,
                    iditem: temp.id
                })
                .then(function(response) {
                    vm.message = response.data
                    vm.obtener()
                })
                .catch(function(error) {
                    vm.obtener()
                });
        },
        agregar: (item) => {
            let temp = item
            temp.qty += 1
            vm.modificar(temp)
        },
        quitar: (item) => {
            let temp = item
            temp.qty -= 1
            vm.modificar(temp)
        },
        eliminar: (item) => {
            let temp = item
            Axios.delete(`/cart/${temp.rowId}`, {
                    id: temp.rowId
                })
                .then(function(response) {
                    vm.message = response.data
                    vm.obtener()
                })
                .catch(function(error) {
                    vm.obtener()
                });
        }
    }
})