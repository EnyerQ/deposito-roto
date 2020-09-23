var url = "vue/listar";
    var app = new Vue({
        el: '#app',
        data: {
            usuarios: [],
        },
        methods: {
            listarUsuarios: function(){
                axios.get(url).then(response =>{
                    this.usuarios = response.data;
                    console.log(this.usuarios);
                });
            },
        },
        created: function() {
            this.listarUsuarios();
        }
        //Esto es un cambio
    });