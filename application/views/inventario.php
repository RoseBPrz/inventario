<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>Inventario</title>
	<!--Estilos usados para el sistemas de grillas y estilos personalizados -->
	<link href="././css/bootstrap.min.css" rel="stylesheet">
    <link href="././css/bootstrap.css" rel="stylesheet">
    <link href="././css/font-awesome.css" rel="stylesheet" type="text/css"> 
	<link href="././css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="././js/jquery-1.11.0.min.js" ></script>
    <link rel="icon" href="././favicon.jpg" type="image/jpg">



	<script type="text/javascript">
		$(document).ready(function(){
			$('#agregar').click(function(event){
				event.preventDefault();
				$('#codigo_producto').removeAttr("disabled");
				$('#nombre_producto').removeAttr("disabled");
				$('#unidad_medida').removeAttr("disabled");
				$('#descripcion_producto').removeAttr("disabled");
				$('#estado_producto').removeAttr("disabled");
				$('#acciones').removeAttr("hidden");

			});
			$('#modificar').click(function(event){
				event.preventDefault();
				$('#buscar').css("display", "block");
				$('#codigo_producto').removeAttr("disabled");
				$('#acciones').removeAttr("hidden");

			});
			$("#borrar").click(function(event){
				event.preventDefault();
				$('#codigo_producto').removeAttr("disabled");
				$('#acciones').removeAttr("hidden");

			});
		});
	</script>
</head>
<body>
	<div class="row" style="background-color:#1BB737;height:35px;"></div>
	<div class="container" >
	<div class="row">
		<div class="col-xs-3" id="form_producto">
			<h2>Productos</h2>
			<form role="form" action="<?php echo base_url("index.php/acciones/accion") ?>" method="post">
				
				<input type="text" class="form-control"  disabled="true" required name="codigo_producto" id="codigo_producto" placeholder="C&oacute;digo" value="<?php echo $codigo;?>">
				<button type="submit" class="btn btn-default btn-xs" style="display:none;" id="buscar" name="buscar" value="buscar" data-toggle="tooltip" title="Buscar"><i class="fa fa-search"></i></button> 
				 <br>
				<input type="text" class="form-control"  required disabled="true"  name="nombre_producto" id="nombre_producto"  placeholder="Nombre del producto" value="<?php echo $nombre;?>"><br>
				<input type="text" class="form-control"  required disabled="true"  name="unidad_medida" id="unidad_medida" placeholder="Unidad de medida" value="<?php echo $unidad_medida;?>"><br>
				<input type="text" class="form-control"  required disabled="true"  name="descripcion_producto" id="descripcion_producto" placeholder="Descripci&oacute;n" value="<?php echo $descripcion;?>"><br>
				<input type="text" class="form-control"  required disabled="true"  name="estado_producto" id="estado_producto" list="estado" placeholder="Estado" value="<?php echo $estado;?>">
					<datalist id="estado">
						<option  value="Activo">
						<option  value="Inactivo">
					</datalist>
					<br>
				<div class="col-md-12" id="acciones" hidden="true">
					<button type="submit" class="btn btn-default btn-md"   name="accion" value="insertar" data-toggle="tooltip" title="Insertar"><i class="fa fa-save"></i></button> 
					<button type="submit" class="btn btn-default btn-md"   name="accion" value="modificar" data-toggle="tooltip" title="Actualizar"><i class="fa fa-refresh"></i></button> 
					<button type="submit" class="btn btn-default btn-md"   name="accion"  value="eliminar" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash-o"></i></button> <br><br>
				</div>				
			</form>
		</div>
		<div class="col-xs-9"><br>

			<table class="table  table-striped" id="tabla_productos">
				<caption> <h2> Productos </h2></caption>
				<thead>
					<tr>
						<th>C&oacute;digo</th>
						<th>Nombre</th>
						<th>Unidad de Medida</th>
						<th>Descripcion</th>
						<th>Estado</th>
						<th><button class="btn btn-default btn-xs" id="agregar" data-toggle="tooltip" title="Registro Nuevo"><i class="fa fa-plus" style=""></i> </button><button class="btn btn-default btn-xs" id="modificar" data-toggle="tooltip" title="Actualizar Registro"> <i class="fa fa-refresh" style=""></i> </button>&nbsp;<button class="btn btn-default btn-xs" id="borrar" data-toggle="tooltip" title="Eliminar Registro"> <i class="fa fa-trash-o" style=""></i></button></th>
					</tr>
				</thead>
				<tbody><?php if ((sizeof($infos))>0) {
					foreach ($infos as $info) {
					?>
					<tr>
						<td><input type="text" class="form-control" style="width:100px;" disabled="true" name="codigo_producto" id="codigo_producto" value="<?php echo $info->codigo;?>"></td>
						<td><input type="text" class="form-control" style="width:160px;" disabled="true" name="nombre_producto" id="nombre_producto" value="<?php echo $info->nombre;?>"></td>
						<td><input type="text" class="form-control" style="width:100px;" disabled="true" name="unidad_medida" id="unidad_medida" value="<?php echo $info->unidad_medida;?>"></td>
						<td><input type="text" class="form-control" style="width:190px;" disabled="true" name="descripcion_producto" id="descripcion_producto" value="<?php echo $info->descripcion;?>"></td>
						<td><input type="text" class="form-control" style="width:90px;" disabled="true" name="estado_producto" id="estado_producto" list="estado" value="<?php echo $info->estado;?>"></td>
					</tr>
					<?php }
					}else{ ?> 
						<tr>
							<td colspan='3'>Sin Productos</td>
						</tr>
					<?php } ?>
				</tbody>	
			</table>
		</div>
	</div><br><br>	
	<div class="row">
		<div class="col-xs-3">
			<h2>Movimientos Productos</h2>
			<form role="form" action="<?php echo base_url("index.php/acciones/insertar_movimiento") ?>" method="post">
				<input type="text" class="form-control"required  name="codigo_producto" id="codigo_producto" placeholder="C&oacute;digo de Producto"><br>
				<input type="text" class="form-control" required name="tipo_movimiento" placeholder="Tipo movimiento" list="tipo"><br>
				<input type="number" class="form-control" required name="cantidad_producto" placeholder="Cantidad" min="1"><br>
				<input type="date" class="form-control" required name="fecha_mov" list="estado"  >
					<datalist id="tipo">
						<option  value="Entrada">
						<option  value="Salida">
					</datalist><br>
				<button type="submit" class="btn btn-default btn-md" name="accion" value="insertar_movimiento" data-toggle="tooltip" title="Guardar Movimiento"><i class="fa fa-save"></i></button> 
			</form>
		</div>
		<div class="col-xs-9">
			<table class="table table-striped">
				<caption> <h2> Inventario </h2></caption>
				<thead>
					<tr>
						<th>C&oacute;digo de producto </th>
						<th>Producto </th>
						<th>Cantidad</th>
					</tr>
				</thead>
				<tbody><?php if ((sizeof($productos))>0) {
						foreach ($productos as $prod) {
						?>
						<tr>
							<td><input type="text" class="form-control"  disabled="true" value="<?php echo $prod->codigo_producto;?>"></td>
							<td><input type="text" class="form-control"  disabled="true" value="<?php echo $prod->nombre;?>"></td>
							<td><input type="text" class="form-control"  disabled="true" value="<?php echo $prod->cantidad_producto;?>"></td>
						</tr>
						<?php }
						}else{ ?> 
							<tr>
								<td colspan='3'>Sin Productos</td>
							</tr>
						<?php } ?>
					</tbody>
			</table>
		</div>
	</div>		
	</div>
	<div class="row" style="background-color:#1BB737;height:35px;"></div>

</body>
</html>