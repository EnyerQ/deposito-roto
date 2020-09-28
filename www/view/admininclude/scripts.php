<!-- jQuery -->
<script src="<?php asset('bower_components/jquery/dist/jquery.min.js') ?>"></script>

<script src="<?php asset('js/jquery-confirm.min.js')?>"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php asset('bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?php asset('bower_components/metisMenu/dist/metisMenu.min.js') ?>"></script>

<!-- Custom Theme JavaScript -->
<script src="<?php asset('dist/js/sb-admin-2.js')?>"></script>

<script src="<?php asset('js/angular.min.js')?>"></script>

<script src="<?php asset('js/controladores/DetalleController.js')?>"></script>
<script src="<?php asset('js/controladores/ConsultaController.js')?>"></script>
<script src="<?php asset('js/controladores/PerfilController.js')?>"></script>

<!-- Tablas dinamicas -->
<script src="<?php asset('vendor/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php asset('vendor/datatables-plugins/dataTables.bootstrap.min.js')?>"></script>
<script src="<?php asset('vendor/datatables-responsive/dataTables.responsive.js')?>"></script>


<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>


<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>

<!--Libresrias para graficos-->
<script src="<?php asset('vendor/raphael/raphael-min.js')?>"></script>
<script src="<?php asset('vendor/morrisjs/morris.min.js')?>"></script>


<script src="<?php asset('js/dataTable.js')?>"></script>


<script>
    function confirma(url,dato) {
        $.confirm({
            title: 'Eliminar',
            content: '¿Esta seguro que desea eliminar '+ dato +'?',
            confirmButtonClass: 'btn-danger',
            cancelButtonClass: 'btn-primary',
            confirmButton: 'Eliminar',
            cancelButton: 'Cancelar',
            confirm: function(){
                window.location.href=url;
            }
        });
    }
</script>

<script>
    function alerta(producto, disponible) {
        $.alert({
            title: '¡Atención!',
            content: '¡No se cuenta con <strong>STOCK</strong> para dicho pedido!<br>'
            + 'Del producto <strong>' + producto + '</strong> solo dispone de: <strong>' + disponible + '</strong>',
            icon: 'fa fa-warning',
            animation: 'zoom',
            closeAnimation: 'zoom',
            confirmButtonClass: 'btn-primary',
            confirmButton: 'Entendido'
        });
    }
</script>



<!--Aquí comienza las dependencias VUE-->
<script src="https://cdn.jsdelivr.net/npm/vue"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>