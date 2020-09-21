$(document).ready(function() {
    if(document.querySelector('.col_fil')){
        $('#tabla_filtro').DataTable({

            responsive: true,
            "paging": false,
            "language":{
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }

            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    message: 'PDF de tabla.'
                },
                {
                    extend: 'excelHtml5',
                    customize: function ( xlsx ){
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        // jQuery selector to add a border
                        //$('row c[r*="11"]', sheet).attr( 's', '25' );
                    },
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimir'
                },


            ],

            "order": [[ 2, "desc" ]]
        });
    }else{
        $('#tabla_filtro').DataTable({

            responsive: true,
            "paging": false,
            "language":{
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }

            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    message: 'PDF de tabla.'
                },
                {
                  extend: 'excelHtml5',
                  customize: function ( xlsx ){
                      var sheet = xlsx.xl.worksheets['sheet1.xml'];

                      // jQuery selector to add a border
                      //$('row c[r*="11"]', sheet).attr( 's', '25' );
                  },
                  exportOptions: {
                      columns: [ 0, 1, 2, 3, 4, 5, 6]
                  }
                },
                {
                    extend: 'print',
                    text: 'Imprimir'
                }

            ]
        });
    }

});
