<?php 

	if (isset($_POST['json'])) : 
	$json = json_decode($_POST['json']);

	$accion = $json->accion;
	$data = array();	

	if($accion == "obtener-cliente") {
		$data = array(
			'estado' => 'exito', #exito, error
			'accion' => 'obtener-cliente',
			'data' => array(
				'nombre' => "Mauricio Panuncio",
				'direccion' => "Sarmiento 1798 - San Carlos Centro",
			)
		);



	} else if($accion == "obtener-clientes") {
		$clientes = array();
		
		for($i=0; $i < 14; $i++){
			$clientes[($i+7000)] = array(
				'nombre' => "Mauricio Panuncio",
				'direccion' => "Sarmiento 1798 - San Carlos Centro",
			);
		}

		$data = array(
			'estado' => 'exito', #exito, error
			'accion' => 'obtener-cliente',
			'data' => $clientes,
		);
	


	} else if($accion == "obtener-articulo") {
		$data = array(
			'estado' => 'exito', #exito, error
			'accion' => 'obtener-articulo',
			'data' => array(
				'codigo' => "0001",
				'denominacion' => "Remera Hombre Manga Corta",
				'precio' => "135.99"
			)
		);

	}
	

	echo json_encode($data);



	else :
		exit ("Error: no se proporciono datos para procesar.");
	endif;
?>