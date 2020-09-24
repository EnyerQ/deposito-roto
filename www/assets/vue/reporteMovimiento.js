var app = new Vue({
    el: '#app',
    data: {
        datos: [],
        registros: [],
        inicio: '',
        final: '',
        deposito: '',
        categoria: '',
        estado: '',
        progreso: '',
    },
    methods: {
        // Listar nos permite recuperar listados de diferentes entidades en la base
        // Invocando procedimientos almacenados.
        listar: function (api) {
            axios.get(api).then(response => {
                this.datos = response.data

            })
                .catch(error => {
                    console.log(error)
                });
        },
        //Arrow functions como propiedad NO SIRVE!!! se deben declarar como Function
        crearConsulta: function () {
            axios.post('/reporte/registros', {
              
                    fecha_inicio : this.inicio,
                    fecha_fin: this.final,
                    id_deposito: this.deposito,
                    id_categoria: this.categoria,
                    id_progreso: this.progreso,
                    id_estado: this.estado
                
            }).then(response => {
                this.registros = response.data
                console.log(this.registros)
                console.log(this.inicio)
            }).catch(error => {
                console.log(error)
            })

        }


    },

    created: function () {
        this.listar('/reporte/selectores');
    }
});
