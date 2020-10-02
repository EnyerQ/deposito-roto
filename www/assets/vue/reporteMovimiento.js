var hoy = new Date(),
    d = hoy.getDate(),
    m = hoy.getMonth() + 1,
    y = hoy.getFullYear(),
    fecha;

if (d < 10) {
    d = "0" + d;
};
if (m < 10) {
    m = "0" + m;
};

var fecha = y + "-" + m + "-" + d;

Vue.use(VueBlobJsonCsv.default);
var app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data: {
        loading: true,
        search: '',
        datos: [],
        registros: [],
        inicio: fecha,
        final: fecha,
        deposito: '',
        categoria: '',
        estado: '',
        progreso: '',
        buscador: '',
        exportar: ['tipo_movimiento', 'ticket', 'fecha_pedido', 'fecha', 'fecha_modificacion', 'origen', 'destino', 'modelo', 'cantidad' ],

        columnas: [
            { text: 'TIPO MOV', value: 'tipo_movimiento', class: 'blue darken-4 white--text' },
            { text: 'TICKET', value: 'ticket', class: 'blue darken-4 white--text' },
            { text: 'PEDIDO', value: 'fecha_pedido', class: 'blue darken-4 white--text' },
            { text: 'FECHA', value: 'fecha', class: 'blue darken-4 white--text' },
            { text: 'FINAL', value: 'fecha_modificacion', class: 'blue darken-4 white--text' },
            { text: 'ORIGEN', value: 'origen', class: 'blue darken-4 white--text' },
            { text: 'DESTINO', value: 'destino', class: 'blue darken-4 white--text' },
            {
                text: 'CATEGORIA', value: 'categoria',
                filter: this.nameFilter, class: 'blue darken-4 white--text'
            },
            { text: 'MODELO', value: 'modelo', class: 'blue darken-4 white--text' },
            { text: 'CANTIDAD', value: 'cantidad', class: 'blue darken-4 white--text' },
            { text: 'ACCION', value: 'id_movimiento', class: 'blue darken-4 white--text' },
        ],

    },
    methods: {
        /**
     * Filter for dessert names column.
     * @param value Value to be tested.
     * @returns {boolean}
     */
        nameFilter(value) {
            // If this filter has no value we just skip the entire filter.
            if (!this.search) {
                return true;
            }
            // Check if the current loop value (The dessert name)
            // partially contains the searched word.
            return value.toLowerCase().includes(this.search.toLowerCase());
        },
        listar: function (api) {
            
            axios.get(api).then(response => {
                this.datos = response.data
                this.loading = false
                
            })
                .catch(error => {
                    console.log(error)
                });
        },
        //Arrow functions como propiedad NO SIRVE!!! se deben declarar como Function
        crearConsulta: function () {
            this.loading = true
            axios.post('/reporte/registros', {
                
                fecha_inicio: this.inicio,
                fecha_fin: this.final,
                id_deposito: this.deposito,
                id_categoria: this.categoria,
                id_progreso: this.progreso,
                id_estado: this.estado
                
            }).then(response => {
                this.registros = response.data
                setTimeout(() => {
                    this.loading = false
                }, 3000)
                console.log(this.registros)
                console.log(this.inicio)
            }).catch(error => {
                console.log(error)
            })

        },
        //Definimos el metodo de onButtonClick
        onButtonClick: function (registro) {
            window.open('/' + registro.tipo_movimiento + '/informe/' + registro.id_movimiento, '_blank');
        }

    },

    created: function () {
        this.listar('/reporte/selectores');
        this.crearConsulta();
    }
});
