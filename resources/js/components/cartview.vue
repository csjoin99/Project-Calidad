<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Example Component</div>

          <div class="card-body">I'm an example component.</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
    data() {
        return {
        items: [],
        item: { id: "", descripcion: "" },
        };
    },
    created() {
        
    },
    methods: {
        agregar() {
        const newdato = this.dato;
        this.datos.push(newdato);
        console.log(this.datos);
        },
    },
    };
</script>
