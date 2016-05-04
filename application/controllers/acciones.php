<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../css/bootstrap.css" rel="stylesheet">
<link href="../../css/font-awesome.css" rel="stylesheet" type="text/css"> 
<link href="../../css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../js/jquery-1.11.0.min.js" ></script>
<link rel="icon" href=".././favicon.jpg" type="image/jpg">
<?php

class Acciones extends CI_Controller{
	

    function __construct()
    {
        parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('Model_inventario');
		
		
    }
	
	function index(){
		$data['infos']=$this->Model_inventario->listar();
		$data['productos']=$this->Model_inventario->listar_inventario();
		$codigo="";
		$nombre="";
		$unidad_medida="";
		$descripcion="";
		$estado="";
		$data['codigo']=$codigo;
		$data['nombre']=$nombre;
		$data['estado']=$estado;
		$data['descripcion']=$descripcion;
		$data['unidad_medida']=$unidad_medida;
		
		$this->load->view('inventario',$data);
	}

	function accion(){
		$accion = $this->input->post('accion');
		$buscar = $this->input->post('buscar');
		if( $buscar == 'buscar' ){
		   $this->buscar();
		}
		if( $accion == 'insertar' ){
		   $this->insertar();
		}
		else{
		    if( $accion == 'modificar' ){
		   		$this->modificar();
			}else{
				if( $accion == 'eliminar' ){
					$this->eliminar();
				}
			}
		}
	}
	function insertar(){
		$codigo_producto = $this->input->post("codigo_producto");
		//echo($codigo_producto);
        $nombre_producto = $this->input->post("nombre_producto");
        $unidad_medida = $this->input->post("unidad_medida");
        $descripcion = $this->input->post("descripcion_producto");
        $estado = $this->input->post("estado_producto");
        $sql="SELECT COUNT(*) as producto FROM productos WHERE codigo ='$codigo_producto';";
	 	$result=mysql_query($sql);
	 	
	 	while ($fila = mysql_fetch_assoc($result)) {
		    $producto=$fila['producto'];
		}
		if($producto>0){
			$this->index();
			echo "<div class='alert alert-warning alert-dismissable' id='aviso'>Este c&oacute;digo ya est&aacute; registrado.</div>";
		} else {
			$query = $this->db->query("INSERT INTO productos
						            (codigo,
						             nombre,
						             unidad_medida,
						             descripcion,
						            estado)
						VALUES ('$codigo_producto',
						        '$nombre_producto',
						        '$unidad_medida',
						        '$descripcion',
						        '$estado');");

	        $query = $this->db->query("INSERT INTO inventarios
							            (codigo_producto,
							            cantidad_producto)
							VALUES ('$codigo_producto',
							        '0');");
			if ($query){
				$this->index();
				echo "<div class='alert alert-success alert-dismissable' id='aviso'>Nuevo producto registrado.</div>";
				
			}
		}
    }

    function buscar(){
		$codigo_producto = $this->input->post("codigo_producto");
    	$sql="SELECT *, COUNT(*) as producto FROM productos WHERE codigo ='$codigo_producto';";
	 	$result=mysql_query($sql);
	 	while ($fila = mysql_fetch_assoc($result)) {
	 		$cantidad=$fila['producto'];
		    $codigo=$fila['codigo'];
		    $nombre=$fila['nombre'];
		    $estado=$fila['estado'];
		    $descripcion=$fila['descripcion'];
		    $unidad_medida=$fila['unidad_medida'];

			$data['infos']=$this->Model_inventario->listar();
			$data['productos']=$this->Model_inventario->listar_inventario();

			if ($cantidad>0){
				$data['codigo']=$codigo;
				$data['nombre']=$nombre;
				$data['estado']=$estado;
				$data['descripcion']=$descripcion;
				$data['unidad_medida']=$unidad_medida;
				$this->load->view('inventario',$data);
				echo "<script> $(document).ready(function(){
					event.preventDefault();
					$('#codigo_producto').removeAttr('disabled');
					$('#nombre_producto').removeAttr('disabled');
					$('#unidad_medida').removeAttr('disabled');
					$('#descripcion_producto').removeAttr('disabled');
					$('#estado_producto').removeAttr('disabled');
					$('#acciones').removeAttr('hidden');

					});</script>";
			} else{
				$this->index();
				echo "<div class='alert alert-warning alert-dismissable' id='aviso'>No existe este producto.</div>";
				echo "<script> $(document).ready(function(){
						event.preventDefault();
						$('#buscar').css('display', 'block');
						$('#codigo_producto').removeAttr('disabled');
						$('#acciones').removeAttr('hidden');
				});</script>";
			}
		}
	}


	function modificar(){
		$codigo_producto = $this->input->post("codigo_producto");
        $nombre_producto = $this->input->post("nombre_producto");
        $unidad_medida = $this->input->post("unidad_medida");
        $descripcion = $this->input->post("descripcion_producto");
        $estado = $this->input->post("estado_producto");
		$query = $this->db->query("UPDATE productos SET
						            nombre='$nombre_producto',
						             unidad_medida='$unidad_medida',
						             descripcion='$descripcion',
						            estado='$estado'
									WHERE codigo='$codigo_producto';");
	        
		if ($query){
			$this->index();
			echo "<div class='alert alert-success alert-dismissable' id='aviso'>Producto actualizado.</div>";
			

		}else{
			$this->index();
		}
		
        
	}
	function eliminar(){
		$codigo_producto = $this->input->post("codigo_producto");
		$sql="SELECT COUNT(*) as producto FROM productos WHERE codigo ='$codigo_producto';";
	 	$result=mysql_query($sql);
	 	while ($fila = mysql_fetch_assoc($result)) {
		    $cantidad=$fila['producto'];
			if ($cantidad>0){
				$query = $this->db->query("DELETE FROM inventarios WHERE codigo_producto = '$codigo_producto';");
	        	$query2 = $this->db->query("DELETE FROM movimientos_inventarios WHERE codigo_producto = '$codigo_producto';");
	      	  	$query3 = $this->db->query("DELETE FROM productos WHERE codigo = '$codigo_producto';");
				$this->index();
				echo "<div class='alert alert-warning alert-dismissable' id='msj'>Producto Eliminado.</div>";
				echo "<script> $(document).ready(function(){
						event.preventDefault();
							$('#msj').fadeOut('9000');
				});</script>";
			}else {
				$this->index();
					echo "<div class='alert alert-warning alert-dismissable' id='msj'>No existe este producto.</div>";
					echo "<script> $(document).ready(function(){
							event.preventDefault();
								$('#msj').fadeOut('16000');
								$('#codigo_producto').removeAttr('disabled');
								$('#acciones').removeAttr('hidden');
					});</script>";
			}				
		}	
	}
	function listar(){
        $this->load->model('Model_inventario');
		$data['info']=$this->Model_inventario->listar();
		$this->load->view('inventario',$data);
	}

	function insertar_movimiento(){
		$codigo_producto = $this->input->post("codigo_producto");
		$tipo_movimiento = $this->input->post("tipo_movimiento");
		$cantidad_producto = $this->input->post("cantidad_producto");
		$fecha = date('Y-m-d', strtotime($this->input->post("fecha_movimiento")));
		$sql="SELECT cantidad_producto FROM inventarios WHERE codigo_producto = '$codigo_producto';";
	 	$result=mysql_query($sql);
	 	while ($fila = mysql_fetch_assoc($result)) {
		    $cantidad=$fila['cantidad_producto'];
		}
		if (($tipo_movimiento=='Entrada') && ($cantidad>=0)) {
			$this->db->query("INSERT INTO movimientos_inventarios
						            (tipo_movimiento,
						            codigo_producto,
						            cantidad_producto,
						            fecha_movimiento)
						VALUES ('$tipo_movimiento',
								'$codigo_producto',
								'$cantidad_producto',
						        '$fecha');");
			$this->db->query("UPDATE inventarios SET cantidad_producto = cantidad_producto + '$cantidad_producto' WHERE codigo_producto = '$codigo_producto';");

		} else {
			if (($tipo_movimiento=='Salida') && ($cantidad>$cantidad_producto)) {
				$this->db->query("INSERT INTO movimientos_inventarios
							            (tipo_movimiento,
							            codigo_producto,
							            cantidad_producto,
							            fecha_movimiento)
							VALUES ('$tipo_movimiento',
									'$codigo_producto',
									'$cantidad_producto',
							        '$fecha');");
				$this->db->query("UPDATE inventarios SET cantidad_producto = cantidad_producto - '$cantidad_producto' WHERE codigo_producto = '$codigo_producto';");
			}else{
				echo "<div class='alert alert-warning alert-dismissable' id='aviso'>No hay suficientes existencias de este producto</div>";
				echo "<script> $(document).ready(function(){
						event.preventDefault();
						$('#aviso').hide('slow','9000');
					});</script>";
			}
		}
			$this->index();
	}

}
?>