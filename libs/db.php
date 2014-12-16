<?php

function conectar_bd($dsn, $usr="", $pass=""){
	$conn = odbc_connect($dsn, $usr, $pass);
	return $conn;
}

function cerrar_bd($conn){
	odbc_close($conn);
}

function ejecutar_select_sql($sql, $conn){
	$rs = odbc_exec($conn, $sql );
	if($rs) {
		$rows = array();
		while ( $row = odbc_fetch_array($rs) ) { array_push($rows, $row); }
		return $rows;
	} else {
		return false;
	}
	
}

function ejecutar_sql($sql, $conn){
	$rs = odbc_exec($conn, $sql );
	
	return $rs;
}

?>