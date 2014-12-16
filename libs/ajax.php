<?php 
	include("db.php");

	if (isset($_POST['json'])) : 
	
	$json = json_decode($_POST['json']);

	$accion = $json->accion;
	$data = array();	

	// Obtener Cliente
	if($accion == "obtener-cliente") {
		
		$conn = conectar_bd("DSN=clientes;UID=;PWD=");
			$sql = "SELECT codcli, nomcli, domcli, loccli FROM clientes WHERE codcli = '".$json->data->cliente_codcli . "';";
			$cli123 = ejecutar_select_sql($sql, $conn);
		cerrar_bd($conn);

		if($cli123){
			$data = array(
				'estado' => 'exito', #exito, error
				'accion' => 'obtener-cliente',
				'data' => array(
					'nombre' => $cli123[0]["nomcli"],
					'direccion' => $cli123[0]["domcli"] . ' - ' . $cli123[0]["loccli"],
				)
			);
		
		} else {
			$data = array(
				'estado' => 'error', #exito, error
				'accion' => 'obtener-cliente',
				'data' => "",
			);
		}




	// Obtener Lista de Clientes
	} else if($accion == "obtener-clientes") {
		
		$conn = conectar_bd("DSN=clientes;UID=;PWD=");
			$sql = "SELECT codcli, nomcli, domcli, loccli FROM clientes";
			$cli = ejecutar_select_sql($sql, $conn);
		cerrar_bd($conn);

		$cli_cant = count($cli);
		
		$clientes = array();

		for($i=0; $i < $cli_cant; $i++){
			$clientes[$cli[$i]["codcli"]] = array(
				'nombre' => $cli[$i]["nomcli"],
				'direccion' => $cli[$i]["domcli"] . ' - ' . $cli[$i]["loccli"],
			);
		}

		$data = array(
			'estado' => 'exito', #exito, error
			'accion' => 'obtener-cliente',
			'data' => $clientes,
		);
	


	// Obtener Artículo
	} else if($accion == "obtener-articulo") {
		$conn = conectar_bd("DSN=articulos;UID=;PWD=");
			$sql = "SELECT CODART, DESART, STOCK, PVENTA_1, PVENTA_2, PVENTA_3 
					FROM articulos 
					WHERE CODART = '". $json->data->articulo_codart ."'";
			$art = ejecutar_select_sql($sql, $conn);
		cerrar_bd($conn);

		$data = array(
			'estado' => 'exito', #exito, error
			'accion' => 'obtener-articulo',
			'data' => array(
				'codigo' => $art[0]["CODART"],
				'denominacion' => $art[0]["DESART"],
				'precio' => array(
					"lista1" => $art[0]["PVENTA_1"],
					"lista2" => $art[0]["PVENTA_2"],
					"lista3" => $art[0]["PVENTA_3"],
				)
			)
		);




	// Actualizar Stocks
	} else if($accion == "actualizar-stock") {
		$conn = conectar_bd("DSN=articulos;UID=;PWD=");

		foreach ($json->data->articulos as $value) {
			$sql = "UPDATE articulos 
					SET STOCK = STOCK-".$value->cantidad." 
					WHERE CODART = '".$value->codigo."';";
			$rs = ejecutar_sql($sql, $conn);
		}

		cerrar_bd($conn);

		$data = array(
			'estado' => 'exito', #exito, error
			'accion' => 'actualizar-stock',
			'data' => ""
		);
	}
	

	echo json_encode($data);



	else :
		exit ("Error: esta página no puede accederse directamente.");
	endif;
?>