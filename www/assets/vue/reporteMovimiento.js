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

var app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data: {
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

        columnas: [
            { text: 'TIPO MOV', value: 'tipo_movimiento', class: 'orange darken-4 white--text' },
            { text: 'TICKET', value: 'ticket', class: 'orange darken-4 white--text' },
            { text: 'PEDIDO', value: 'fecha_pedido', class: 'orange darken-4 white--text' },
            { text: 'FECHA', value: 'fecha', class: 'orange darken-4 white--text' },
            { text: 'FINAL', value: 'fecha_modificacion', class: 'orange darken-4 white--text' },
            { text: 'ORIGEN', value: 'origen', class: 'orange darken-4 white--text' },
            { text: 'DESTINO', value: 'destino', class: 'orange darken-4 white--text' },
            {
                text: 'CATEGORIA', value: 'categoria',
                filter: this.nameFilter, class: 'orange darken-4 white--text'
            },
            { text: 'MODELO', value: 'modelo', class: 'orange darken-4 white--text' },
            { text: 'CANTIDAD', value: 'cantidad', class: 'orange darken-4 white--text' },
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
            })
                .catch(error => {
                    console.log(error)
                });
        },
        //Arrow functions como propiedad NO SIRVE!!! se deben declarar como Function
        crearConsulta: function () {
            axios.post('/reporte/registros', {

                fecha_inicio: this.inicio,
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

        },

    },

    created: function () {
        this.listar('/reporte/selectores');
        this.crearConsulta();
    }
});
