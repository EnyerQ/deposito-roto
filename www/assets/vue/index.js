var app = new Vue({
    el: '#app',
    data: {
        datos: [],
    },
    methods: {
        // Listar nos permite recuperar listados de diferentes entidades en la base
        // Invocando procedimientos almacenados.
        listar: function (api) {
            axios.get(api).then(response => {
                this.datos = response.data;
            });
        },

        mostrar: function (usuario, email) {
            alert(`${usuario} el mail es: ${email}`)
        }
    },
    created: function (){
        this.listar('/vue/listar');
    }
});