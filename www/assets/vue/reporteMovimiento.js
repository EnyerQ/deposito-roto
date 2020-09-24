var app = new Vue({
    el: '#app',
    data: {
        datos: [],
        registros: [],
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

        crearConsulta: () => {
            axios.post('/reporte/registros', {
              
                    fecha_inicio : '2020-01-01',
                    fecha_fin: '2020-02-01'
                
            }).then(response => {
                this.registros = response.data
                console.log(response)
            }).catch(error => {
                console.log(error)
            })

        }


    },

    created: function () {
        this.listar('/reporte/selectores');
    }
});
