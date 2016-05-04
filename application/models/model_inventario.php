
<?php

class Model_inventario extends CI_Model{
	

    function __construct()
    {
        parent::__construct();
		$this->load->database();

    }	
	
	function listar(){
	 $this->db->select('*');
	 $this->db->from('productos');
	 $result=$this->db->get()->result();
	 return $result;
	}
	
	function datos_productos($codigo_producto){
	 $this->db->select('*');
	 $this->db->from('productos');
	 $this->db->where('codigo', '$codigo_producto');
	 $result=$this->db->get()->result();
	 return $result;
	}

	function listar_inventario(){
	 $this->db->select('codigo_producto, nombre, cantidad_producto');
	 $this->db->from('inventarios');
	 $this->db->join('productos', 'productos.codigo = inventarios.codigo_producto');
	 $result=$this->db->get()->result();
	 return $result;
	}

}


?>