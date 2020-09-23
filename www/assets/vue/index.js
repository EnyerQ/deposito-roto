var app = new Vue({
    el: '#app',
    data: {
        datos: [],
        primerNombre: 'Charlie',
        segundoNombre: 'Matias'
    },
    methods: {
        listar: function (api) {
            axios.get(api).then(response => {
                this.datos = response.data;
                console.log(this.primerNombre)
                console.log(this.segundoNombre)
            });
        },

        mostrar: function (usuario, email) {
            alert(`${usuario} el mail es: ${email}`)
        }
    },
});