<?php
	$config_public = array(
		"empresa_nombre" => "Nombre de la Empresa",
		"developed_by" => "<a href='http://panuweb.com'>PanuWeb</a>",
	);

	$config = array(
	);

	$config = array_merge($config, $config_public);

	// Si lo cargamos desde ajax imprime la configuracion pública
	if($_POST["ajax"]){
		echo json_encode($config_public);
	}
?>