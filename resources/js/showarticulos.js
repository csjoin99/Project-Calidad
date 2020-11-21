const { default: Axios } = require("axios");
const { forEach } = require("lodash");
const vm = new Vue({
    el: '#showarticulos',
    data() {
        return {
            articulos: [],
            categoria: 'Todos',
            cant: 0,
            componentKey: 0,
            gender: window.gender,
            init: ''
        };
    },
    created() {
        Axios.get(`/productsget/${this.gender}`)
            .then(response => {
                vm.articulos = response.data[0]
                vm.cant = response.data[1]
                vm.categoria = 'Todos'
                vm.init = 1
                console.log(response)
            })
    },
    methods: {
        filtrar: (filtro) => {
            if (!filtro) {
                vm.categoria = 'Todos'
            } else {
                vm.categoria = filtro
            }
            Axios.post(`/productsget/${vm.gender}`, {
                categoria: filtro
            }).then(response => {
                vm.articulos = response.data[0]
                vm.cant = response.data[1]
                console.log(vm.categoria)
            })
        }
    }
})