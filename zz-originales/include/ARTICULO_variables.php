<?php
$strTableName="ARTICULO";
$_SESSION["OwnerID"] = $_SESSION["_".$strTableName."_OwnerID"];

$strOriginalTableName="ARTICULO";

$gstrOrderBy="";
if(strlen($gstrOrderBy) && strtolower(substr($gstrOrderBy,0,8))!="order by")
	$gstrOrderBy="order by ".$gstrOrderBy;

$g_orderindexes=array();
$gsqlHead="SELECT CODART,  CBARRA,  DESART,  PVENTA_1,  PVENTA_2,  PVENTA_3,  STOCK";
$gsqlFrom="FROM ARTICULO";
$gsqlWhereExpr="";
$gsqlTail="";

include_once(getabspath("include/ARTICULO_settings.php"));

// alias for 'SQLQuery' object
$gQuery = &$queryData_ARTICULO;
$eventObj = &$tableEvents["ARTICULO"];

$reportCaseSensitiveGroupFields = false;

$gstrSQL = gSQLWhere("");


?>