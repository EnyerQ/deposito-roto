<div class="col-md-6">
    <label for="origenMovimiento">Seleccionar el origen:</label>
    <select name="origenMovimiento" id="origenMovimiento" class="form-control" required>
        <option value=""></option>
        <?php foreach ($origenes as $origen) {?>
        <option value="<?php echo $origen->id ?>"><?php echo $origen->nombre ?></option>
        <?php }?>
    </select>
</div>

<div class="col-md-6">
    <label for="destinoMovimiento">Seleccionar el destino:</label>
    <select name="destinoMovimiento" id="destinoMovimiento" class="form-control" required>
        <option value=""></option>
        <?php foreach ($destinos as $destino) {?>
        <option value="<?php echo $destino->id ?>"><?php echo $destino->nombre ?></option>
        <?php }?>
    </select>
</div>

<div class="col-md-6">
    <label for="remitoMovimiento">Ingresar el remito o referencia:</label>
    <input type="text" class="form-control" id="remitoMovimiento" name="remitoMovimiento">
</div>

<div class="col-md-6">
    <label for="ordenMovimiento">Ingresar el ticket o orden de compra:</label>
    <input type="text" class="form-control" id="ordenMovimiento" name="ordenMovimiento" required>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="estadoEquipoMovimiento">Seleccionar estado de equipos:</label>

        <select name="estadoEquipoMovimiento" id="estadoEquipoMovimiento" class="form-control" required="required">
            <option value=""></option>
            <?php
foreach ($subEstados as $estado) {?>
            <option <?php echo isset($movimiento) && $movimiento->id_sub_estado == $estado['id']
    ? 'selected' : '' ?> value="<?php echo $estado['id'] ?>">
                <?php echo ($estado['nombre']); ?>
            </option><?php }?>
        </select>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="progresoMovimiento">Seleccionar estado del movimiento</label>

        <select name="progresoMovimiento" id="progresoMovimiento" class="form-control" required="required">
            <?php
$progre = new libreria\ORM\EtORM();
$progresos = $progre->ejecutar("sp_progreso_movimiento");
foreach ($progresos as $progreso) {?>
            <option <?php echo isset($entrada) && $entrada->progreso == $progreso['id']
    ? 'selected' : '' ?> value="<?php echo $progreso['id'] ?>">
                <?php echo ($progreso['Nombre']); ?>
            </option><?php }?>
        </select>
    </div>
</div>

<?php if ($tipo == 6 || $tipo == 7) {?>

<div class="col-md-6">
    <label for="categoria">Seleccionar categoria:</label>
    <select name="categoria" id="categoria" ng-model="categoria" class="form-control" required>
        <option value=""></option>
        <?php foreach ($categorias as $categoria) {?>
        <option value="<?php echo $categoria->id ?>">
            <?php echo $categoria->codigo . '|' . $categoria->nombre ?></option>
        <?php }?>
    </select>
</div>
<div class="col-md-6">
    <label for="modelo">Seleccione modelo:</label>
    <select name="modelo" id="modelo" class="form-control" required>
        <option value=""></option>
    </select>
</div>
<div class="col-md-12">
    <hr>
</div>

<?php }?>

<div class="col-md-12">
    <label for="comentarioMovimiento">Comentarios:</label>
    <textarea name="comentarioMovimiento" id="comentarioMovimiento" rows="5" class="form-control"></textarea>
</div>



<script>
//Verificamos cambios en el valor del origen.
$("#origenMovimiento").on('change', function() {
    //Cargamos input de apoyo.
    $("#origen").val($("#origenMovimiento").val());
    //Mostramos u ocultamos el boton de series.
    mostrarBtnSeries();
});

//Creamo la función que nos permite recargar el selector de modelos.
function cargarModelos() {
    //definimos el llamado ajax.
    $.ajax({
        url: "<?php url('consulta/modelos') ?>",
        type: 'GET',
        data: {
            'idCategoria': $("#categoria").val(),
        },
        success(respuesta) {
            console.log(respuesta);
            $("#modelo").html(respuesta);
        }
    });
}

//Verificamos que el selector de categoria cambia.
$("#categoria").on('change', function() {
    console.log($("#categoria").val());
    cargarModelos();
});
</script>