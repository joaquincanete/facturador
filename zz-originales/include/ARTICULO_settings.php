<?php
$tdataARTICULO=array();
	$tdataARTICULO[".NumberOfChars"]=80; 
	$tdataARTICULO[".ShortName"]="ARTICULO";
	$tdataARTICULO[".OwnerID"]="";
	$tdataARTICULO[".OriginalTable"]="ARTICULO";


	
//	field labels
$fieldLabelsARTICULO = array();
if(mlang_getcurrentlang()=="Spanish")
{
	$fieldLabelsARTICULO["Spanish"]=array();
	$fieldToolTipsARTICULO["Spanish"]=array();
	$fieldLabelsARTICULO["Spanish"]["CODART"] = "COD. INTERNO";
	$fieldToolTipsARTICULO["Spanish"]["CODART"] = "";
	$fieldLabelsARTICULO["Spanish"]["DESART"] = "DESCRIPCION";
	$fieldToolTipsARTICULO["Spanish"]["DESART"] = "";
	$fieldLabelsARTICULO["Spanish"]["STOCK"] = "STOCK";
	$fieldToolTipsARTICULO["Spanish"]["STOCK"] = "";
	$fieldLabelsARTICULO["Spanish"]["PVENTA_1"] = "PRECIO  1";
	$fieldToolTipsARTICULO["Spanish"]["PVENTA_1"] = "";
	$fieldLabelsARTICULO["Spanish"]["PVENTA_2"] = "PRECIO  2";
	$fieldToolTipsARTICULO["Spanish"]["PVENTA_2"] = "";
	$fieldLabelsARTICULO["Spanish"]["PVENTA_3"] = "PRECIO 3";
	$fieldToolTipsARTICULO["Spanish"]["PVENTA_3"] = "";
	$fieldLabelsARTICULO["Spanish"]["CBARRA"] = "COD. BARRA";
	$fieldToolTipsARTICULO["Spanish"]["CBARRA"] = "";
	$fieldLabelsARTICULO["Spanish"][""] = "";
	$fieldToolTipsARTICULO["Spanish"][""] = "";
	$fieldLabelsARTICULO["Spanish"][""] = "ARTICULO";
	$fieldToolTipsARTICULO["Spanish"][""] = "";
	$fieldLabelsARTICULO["Spanish"][""] = "";
	$fieldToolTipsARTICULO["Spanish"][""] = "";
	$fieldLabelsARTICULO["Spanish"][""] = "ARTICULO";
	$fieldToolTipsARTICULO["Spanish"][""] = "";
	if (count($fieldToolTipsARTICULO["Spanish"])){
		$tdataARTICULO[".isUseToolTips"]=true;
	}
}


	
	$tdataARTICULO[".NCSearch"]=true;

	

$tdataARTICULO[".shortTableName"] = "ARTICULO";
$tdataARTICULO[".nSecOptions"] = 0;
$tdataARTICULO[".recsPerRowList"] = 1;	
$tdataARTICULO[".tableGroupBy"] = "0";
$tdataARTICULO[".mainTableOwnerID"] = "";
$tdataARTICULO[".moveNext"] = 1;




$tdataARTICULO[".showAddInPopup"] = false;

$tdataARTICULO[".showEditInPopup"] = false;

$tdataARTICULO[".showViewInPopup"] = false;


$tdataARTICULO[".fieldsForRegister"] = array();

$tdataARTICULO[".listAjax"] = false;

	$tdataARTICULO[".audit"] = false;

	$tdataARTICULO[".locking"] = false;
	
$tdataARTICULO[".listIcons"] = true;

$tdataARTICULO[".exportTo"] = true;

$tdataARTICULO[".printFriendly"] = true;


$tdataARTICULO[".showSimpleSearchOptions"] = false;

$tdataARTICULO[".showSearchPanel"] = true;


if (isMobile()){
$tdataARTICULO[".isUseAjaxSuggest"] = false;
}else {
$tdataARTICULO[".isUseAjaxSuggest"] = true;
}

$tdataARTICULO[".rowHighlite"] = true;


// button handlers file names

$tdataARTICULO[".addPageEvents"] = false;

$tdataARTICULO[".arrKeyFields"][] = "CODART";
$tdataARTICULO[".arrKeyFields"][] = "DESART";
$tdataARTICULO[".arrKeyFields"][] = "STOCK";

// use datepicker for search panel
$tdataARTICULO[".isUseCalendarForSearch"] = false;

// use timepicker for search panel
$tdataARTICULO[".isUseTimeForSearch"] = false;

$tdataARTICULO[".isUseiBox"] = false;



	



$tdataARTICULO[".isUseInlineJs"] = $tdataARTICULO[".isUseInlineAdd"] || $tdataARTICULO[".isUseInlineEdit"];

$tdataARTICULO[".allSearchFields"] = array();

$tdataARTICULO[".globSearchFields"][] = "CODART";
// do in this way, because combine functions array_unique and array_merge returns array with keys like 1,2, 4 etc
if (!in_array("CODART", $tdataARTICULO[".allSearchFields"]))
{
	$tdataARTICULO[".allSearchFields"][] = "CODART";	
}
$tdataARTICULO[".globSearchFields"][] = "CBARRA";
// do in this way, because combine functions array_unique and array_merge returns array with keys like 1,2, 4 etc
if (!in_array("CBARRA", $tdataARTICULO[".allSearchFields"]))
{
	$tdataARTICULO[".allSearchFields"][] = "CBARRA";	
}
$tdataARTICULO[".globSearchFields"][] = "DESART";
// do in this way, because combine functions array_unique and array_merge returns array with keys like 1,2, 4 etc
if (!in_array("DESART", $tdataARTICULO[".allSearchFields"]))
{
	$tdataARTICULO[".allSearchFields"][] = "DESART";	
}


$tdataARTICULO[".googleLikeFields"][] = "PVENTA_1";
$tdataARTICULO[".googleLikeFields"][] = "CODART";
$tdataARTICULO[".googleLikeFields"][] = "PVENTA_2";
$tdataARTICULO[".googleLikeFields"][] = "CBARRA";
$tdataARTICULO[".googleLikeFields"][] = "PVENTA_3";
$tdataARTICULO[".googleLikeFields"][] = "DESART";
$tdataARTICULO[".googleLikeFields"][] = "STOCK";

$tdataARTICULO[".panelSearchFields"][] = "CODART";
// do in this way, because combine functions array_unique and array_merge returns array with keys like 1,2, 4 etc
if (!in_array("CODART", $tdataARTICULO[".allSearchFields"])) 
{
	$tdataARTICULO[".allSearchFields"][] = "CODART";	
}
$tdataARTICULO[".panelSearchFields"][] = "DESART";
// do in this way, because combine functions array_unique and array_merge returns array with keys like 1,2, 4 etc
if (!in_array("DESART", $tdataARTICULO[".allSearchFields"])) 
{
	$tdataARTICULO[".allSearchFields"][] = "DESART";	
}
$tdataARTICULO[".panelSearchFields"][] = "STOCK";
// do in this way, because combine functions array_unique and array_merge returns array with keys like 1,2, 4 etc
if (!in_array("STOCK", $tdataARTICULO[".allSearchFields"])) 
{
	$tdataARTICULO[".allSearchFields"][] = "STOCK";	
}


$tdataARTICULO[".advSearchFields"][] = "PVENTA_1";
// do in this way, because combine functions array_unique and array_merge returns array with keys like 1,2, 4 etc
if (!in_array("PVENTA_1", $tdataARTICULO[".allSearchFields"])) 
{
	$tdataARTICULO[".allSearchFields"][] = "PVENTA_1";	
}
$tdataARTICULO[".advSearchFields"][] = "CODART";
// do in this way, because combine functions array_unique and array_merge returns array with keys like 1,2, 4 etc
if (!in_array("CODART", $tdataARTICULO[".allSearchFields"])) 
{
	$tdataARTICULO[".allSearchFields"][] = "CODART";	
}
$tdataARTICULO[".advSearchFields"][] = "PVENTA_2";
// do in this way, because combine functions array_unique and array_merge returns array with keys like 1,2, 4 etc
if (!in_array("PVENTA_2", $tdataARTICULO[".allSearchFields"])) 
{
	$tdataARTICULO[".allSearchFields"][] = "PVENTA_2";	
}
$tdataARTICULO[".advSearchFields"][] = "CBARRA";
// do in this way, because combine functions array_unique and array_merge returns array with keys like 1,2, 4 etc
if (!in_array("CBARRA", $tdataARTICULO[".allSearchFields"])) 
{
	$tdataARTICULO[".allSearchFields"][] = "CBARRA";	
}
$tdataARTICULO[".advSearchFields"][] = "PVENTA_3";
// do in this way, because combine functions array_unique and array_merge returns array with keys like 1,2, 4 etc
if (!in_array("PVENTA_3", $tdataARTICULO[".allSearchFields"])) 
{
	$tdataARTICULO[".allSearchFields"][] = "PVENTA_3";	
}
$tdataARTICULO[".advSearchFields"][] = "DESART";
// do in this way, because combine functions array_unique and array_merge returns array with keys like 1,2, 4 etc
if (!in_array("DESART", $tdataARTICULO[".allSearchFields"])) 
{
	$tdataARTICULO[".allSearchFields"][] = "DESART";	
}
$tdataARTICULO[".advSearchFields"][] = "STOCK";
// do in this way, because combine functions array_unique and array_merge returns array with keys like 1,2, 4 etc
if (!in_array("STOCK", $tdataARTICULO[".allSearchFields"])) 
{
	$tdataARTICULO[".allSearchFields"][] = "STOCK";	
}

$tdataARTICULO[".isTableType"] = "list";


	



// Access doesn't support subqueries from the same table as main
$tdataARTICULO[".subQueriesSupAccess"] = true;


$tdataARTICULO[".noRecordsFirstPage"] = true;



$tdataARTICULO[".pageSize"] = 20;

$gstrOrderBy = "";
if(strlen($gstrOrderBy) && strtolower(substr($gstrOrderBy,0,8))!="order by")
	$gstrOrderBy = "order by ".$gstrOrderBy;
$tdataARTICULO[".strOrderBy"] = $gstrOrderBy;
	
$tdataARTICULO[".orderindexes"] = array();

$tdataARTICULO[".sqlHead"] = "SELECT CODART,  CBARRA,  DESART,  PVENTA_1,  PVENTA_2,  PVENTA_3,  STOCK";
$tdataARTICULO[".sqlFrom"] = "FROM ARTICULO";
$tdataARTICULO[".sqlWhereExpr"] = "";
$tdataARTICULO[".sqlTail"] = "";




//fill array of records per page for list and report without group fields
$arrRPP = array();
$arrRPP[] = 10;
$arrRPP[] = 20;
$arrRPP[] = 30;
$arrRPP[] = 50;
$arrRPP[] = 100;
$arrRPP[] = 500;
$arrRPP[] = -1;
$tdataARTICULO[".arrRecsPerPage"] = $arrRPP;

//fill array of groups per page for report with group fields
$arrGPP = array();
$arrGPP[] = 1;
$arrGPP[] = 3;
$arrGPP[] = 5;
$arrGPP[] = 10;
$arrGPP[] = 50;
$arrGPP[] = 100;
$arrGPP[] = -1;
$tdataARTICULO[".arrGroupsPerPage"] = $arrGPP;

	$tableKeys = array();
	$tableKeys[] = "CODART";
	$tableKeys[] = "DESART";
	$tableKeys[] = "STOCK";
	$tdataARTICULO[".Keys"] = $tableKeys;

$tdataARTICULO[".listFields"] = array();
$tdataARTICULO[".listFields"][] = "CODART";
$tdataARTICULO[".listFields"][] = "CBARRA";
$tdataARTICULO[".listFields"][] = "DESART";
$tdataARTICULO[".listFields"][] = "PVENTA_1";
$tdataARTICULO[".listFields"][] = "PVENTA_2";
$tdataARTICULO[".listFields"][] = "PVENTA_3";
$tdataARTICULO[".listFields"][] = "STOCK";

$tdataARTICULO[".addFields"] = array();

$tdataARTICULO[".inlineAddFields"] = array();

$tdataARTICULO[".editFields"] = array();

$tdataARTICULO[".inlineEditFields"] = array();

	
//	CODART
	$fdata = array();
	$fdata["strName"] = "CODART";
	$fdata["ownerTable"] = "ARTICULO";
	$fdata["Label"]="COD. INTERNO"; 
	
		
		
	$fdata["FieldType"]= 200;
	
		
			$fdata["UseiBox"] = false;
	
	$fdata["EditFormat"]= "Text field";
	$fdata["ViewFormat"]= "";
	
		
		
		
		
		$fdata["NeedEncode"]=true;
	
	$fdata["GoodName"]= "CODART";
	
		$fdata["FullName"]= "CODART";
	
		
		
		
		
		
				$fdata["Index"]= 1;
				$fdata["EditParams"]="";
			$fdata["EditParams"].= " maxlength=15";
		
		$fdata["bListPage"]=true; 
	
		
		
		
		
		
		$fdata["bAdvancedSearch"]=true; 
	
		$fdata["bPrinterPage"]=true; 
	
		$fdata["bExportPage"]=true; 
	
	//Begin validation
	$fdata["validateAs"] = array();
		
		//End validation
	
				$fdata["FieldPermissions"]=true;
	
		
				
		
		
		
			$tdataARTICULO["CODART"]=$fdata;
//	CBARRA
	$fdata = array();
	$fdata["strName"] = "CBARRA";
	$fdata["ownerTable"] = "ARTICULO";
	$fdata["Label"]="COD. BARRA"; 
	
		
		
	$fdata["FieldType"]= 200;
	
		
			$fdata["UseiBox"] = false;
	
	$fdata["EditFormat"]= "Text field";
	$fdata["ViewFormat"]= "";
	
		
		
		
		
		$fdata["NeedEncode"]=true;
	
	$fdata["GoodName"]= "CBARRA";
	
		$fdata["FullName"]= "CBARRA";
	
		
		
		
		
		
				$fdata["Index"]= 2;
				$fdata["EditParams"]="";
			
		$fdata["bListPage"]=true; 
	
		
		
		
		
		
		$fdata["bAdvancedSearch"]=true; 
	
		$fdata["bPrinterPage"]=true; 
	
		$fdata["bExportPage"]=true; 
	
	//Begin validation
	$fdata["validateAs"] = array();
		
		//End validation
	
				$fdata["FieldPermissions"]=true;
	
		
				
		
		
		
			$tdataARTICULO["CBARRA"]=$fdata;
//	DESART
	$fdata = array();
	$fdata["strName"] = "DESART";
	$fdata["ownerTable"] = "ARTICULO";
	$fdata["Label"]="DESCRIPCION"; 
	
		
		
	$fdata["FieldType"]= 200;
	
		
			$fdata["UseiBox"] = false;
	
	$fdata["EditFormat"]= "Text field";
	$fdata["ViewFormat"]= "";
	
		
		
		
		
		$fdata["NeedEncode"]=true;
	
	$fdata["GoodName"]= "DESART";
	
		$fdata["FullName"]= "DESART";
	
		
		
		
		
		
				$fdata["Index"]= 3;
				$fdata["EditParams"]="";
			$fdata["EditParams"].= " maxlength=40";
		
		$fdata["bListPage"]=true; 
	
		
		
		
		
		
		$fdata["bAdvancedSearch"]=true; 
	
		$fdata["bPrinterPage"]=true; 
	
		$fdata["bExportPage"]=true; 
	
	//Begin validation
	$fdata["validateAs"] = array();
		
		//End validation
	
				$fdata["FieldPermissions"]=true;
	
		
				
		
		
		
			$tdataARTICULO["DESART"]=$fdata;
//	PVENTA_1
	$fdata = array();
	$fdata["strName"] = "PVENTA_1";
	$fdata["ownerTable"] = "ARTICULO";
	$fdata["Label"]="PRECIO  1"; 
	
		
		
	$fdata["FieldType"]= 5;
	
		
			$fdata["UseiBox"] = false;
	
	$fdata["EditFormat"]= "Text field";
	$fdata["ViewFormat"]= "Number";
	
		
		
		
		$fdata["DecimalDigits"] = 2;
	
		$fdata["NeedEncode"]=true;
	
	$fdata["GoodName"]= "PVENTA_1";
	
		$fdata["FullName"]= "PVENTA_1";
	
		
		
		
		
		
				$fdata["Index"]= 4;
				$fdata["EditParams"]="";
			
		$fdata["bListPage"]=true; 
	
		
		
		
		
		
		
		$fdata["bPrinterPage"]=true; 
	
		$fdata["bExportPage"]=true; 
	
	//Begin validation
	$fdata["validateAs"] = array();
				$fdata["validateAs"]["basicValidate"][] = getJsValidatorName("Number");	
						
		//End validation
	
				$fdata["FieldPermissions"]=true;
	
		
				
		
		
		
			$tdataARTICULO["PVENTA_1"]=$fdata;
//	PVENTA_2
	$fdata = array();
	$fdata["strName"] = "PVENTA_2";
	$fdata["ownerTable"] = "ARTICULO";
	$fdata["Label"]="PRECIO  2"; 
	
		
		
	$fdata["FieldType"]= 5;
	
		
			$fdata["UseiBox"] = false;
	
	$fdata["EditFormat"]= "Text field";
	$fdata["ViewFormat"]= "Number";
	
		
		
		
		$fdata["DecimalDigits"] = 2;
	
		$fdata["NeedEncode"]=true;
	
	$fdata["GoodName"]= "PVENTA_2";
	
		$fdata["FullName"]= "PVENTA_2";
	
		
		
		
		
		
				$fdata["Index"]= 5;
				$fdata["EditParams"]="";
			
		$fdata["bListPage"]=true; 
	
		
		
		
		
		
		
		$fdata["bPrinterPage"]=true; 
	
		$fdata["bExportPage"]=true; 
	
	//Begin validation
	$fdata["validateAs"] = array();
				$fdata["validateAs"]["basicValidate"][] = getJsValidatorName("Number");	
						
		//End validation
	
				$fdata["FieldPermissions"]=true;
	
		
				
		
		
		
			$tdataARTICULO["PVENTA_2"]=$fdata;
//	PVENTA_3
	$fdata = array();
	$fdata["strName"] = "PVENTA_3";
	$fdata["ownerTable"] = "ARTICULO";
	$fdata["Label"]="PRECIO 3"; 
	
		
		
	$fdata["FieldType"]= 5;
	
		
			$fdata["UseiBox"] = false;
	
	$fdata["EditFormat"]= "Text field";
	$fdata["ViewFormat"]= "Number";
	
		
		
		
		$fdata["DecimalDigits"] = 2;
	
		$fdata["NeedEncode"]=true;
	
	$fdata["GoodName"]= "PVENTA_3";
	
		$fdata["FullName"]= "PVENTA_3";
	
		
		
		
		
		
				$fdata["Index"]= 6;
				$fdata["EditParams"]="";
			
		$fdata["bListPage"]=true; 
	
		
		
		
		
		
		
		$fdata["bPrinterPage"]=true; 
	
		$fdata["bExportPage"]=true; 
	
	//Begin validation
	$fdata["validateAs"] = array();
				$fdata["validateAs"]["basicValidate"][] = getJsValidatorName("Number");	
						
		//End validation
	
				$fdata["FieldPermissions"]=true;
	
		
				
		
		
		
			$tdataARTICULO["PVENTA_3"]=$fdata;
//	STOCK
	$fdata = array();
	$fdata["strName"] = "STOCK";
	$fdata["ownerTable"] = "ARTICULO";
	$fdata["Label"]="STOCK"; 
	
		
		
	$fdata["FieldType"]= 5;
	
		
			$fdata["UseiBox"] = false;
	
	$fdata["EditFormat"]= "Text field";
	$fdata["ViewFormat"]= "Number";
	
		
		
		
		$fdata["DecimalDigits"] = 2;
	
		$fdata["NeedEncode"]=true;
	
	$fdata["GoodName"]= "STOCK";
	
		$fdata["FullName"]= "STOCK";
	
		
		
		
		
		
				$fdata["Index"]= 7;
				$fdata["EditParams"]="";
			
		$fdata["bListPage"]=true; 
	
		
		
		
		
		
		
		$fdata["bPrinterPage"]=true; 
	
		$fdata["bExportPage"]=true; 
	
	//Begin validation
	$fdata["validateAs"] = array();
				$fdata["validateAs"]["basicValidate"][] = getJsValidatorName("Number");	
						
		//End validation
	
				$fdata["FieldPermissions"]=true;
	
		
				
		
		
		
			$tdataARTICULO["STOCK"]=$fdata;


	
$tables_data["ARTICULO"]=&$tdataARTICULO;
$field_labels["ARTICULO"] = &$fieldLabelsARTICULO;
$fieldToolTips["ARTICULO"] = &$fieldToolTipsARTICULO;

// -----------------start  prepare master-details data arrays ------------------------------//
// tables which are detail tables for current table (master)
$detailsTablesData["ARTICULO"] = array();

	
// tables which are master tables for current table (detail)
$masterTablesData["ARTICULO"] = array();

// -----------------end  prepare master-details data arrays ------------------------------//

require_once(getabspath("classes/sql.php"));










function createSqlQuery_ARTICULO()
{
$proto0=array();
$proto0["m_strHead"] = "SELECT";
$proto0["m_strFieldList"] = "CODART,  CBARRA,  DESART,  PVENTA_1,  PVENTA_2,  PVENTA_3,  STOCK";
$proto0["m_strFrom"] = "FROM ARTICULO";
$proto0["m_strWhere"] = "";
$proto0["m_strOrderBy"] = "";
$proto0["m_strTail"] = "";
$proto1=array();
$proto1["m_sql"] = "";
$proto1["m_uniontype"] = "SQLL_UNKNOWN";
	$obj = new SQLNonParsed(array(
	"m_sql" => ""
));

$proto1["m_column"]=$obj;
$proto1["m_contained"] = array();
$proto1["m_strCase"] = "";
$proto1["m_havingmode"] = "0";
$proto1["m_inBrackets"] = "0";
$proto1["m_useAlias"] = "0";
$obj = new SQLLogicalExpr($proto1);

$proto0["m_where"] = $obj;
$proto3=array();
$proto3["m_sql"] = "";
$proto3["m_uniontype"] = "SQLL_UNKNOWN";
	$obj = new SQLNonParsed(array(
	"m_sql" => ""
));

$proto3["m_column"]=$obj;
$proto3["m_contained"] = array();
$proto3["m_strCase"] = "";
$proto3["m_havingmode"] = "0";
$proto3["m_inBrackets"] = "0";
$proto3["m_useAlias"] = "0";
$obj = new SQLLogicalExpr($proto3);

$proto0["m_having"] = $obj;
$proto0["m_fieldlist"] = array();
						$proto5=array();
			$obj = new SQLField(array(
	"m_strName" => "CODART",
	"m_strTable" => "ARTICULO"
));

$proto5["m_expr"]=$obj;
$proto5["m_alias"] = "";
$obj = new SQLFieldListItem($proto5);

$proto0["m_fieldlist"][]=$obj;
						$proto7=array();
			$obj = new SQLField(array(
	"m_strName" => "CBARRA",
	"m_strTable" => "ARTICULO"
));

$proto7["m_expr"]=$obj;
$proto7["m_alias"] = "";
$obj = new SQLFieldListItem($proto7);

$proto0["m_fieldlist"][]=$obj;
						$proto9=array();
			$obj = new SQLField(array(
	"m_strName" => "DESART",
	"m_strTable" => "ARTICULO"
));

$proto9["m_expr"]=$obj;
$proto9["m_alias"] = "";
$obj = new SQLFieldListItem($proto9);

$proto0["m_fieldlist"][]=$obj;
						$proto11=array();
			$obj = new SQLField(array(
	"m_strName" => "PVENTA_1",
	"m_strTable" => "ARTICULO"
));

$proto11["m_expr"]=$obj;
$proto11["m_alias"] = "";
$obj = new SQLFieldListItem($proto11);

$proto0["m_fieldlist"][]=$obj;
						$proto13=array();
			$obj = new SQLField(array(
	"m_strName" => "PVENTA_2",
	"m_strTable" => "ARTICULO"
));

$proto13["m_expr"]=$obj;
$proto13["m_alias"] = "";
$obj = new SQLFieldListItem($proto13);

$proto0["m_fieldlist"][]=$obj;
						$proto15=array();
			$obj = new SQLField(array(
	"m_strName" => "PVENTA_3",
	"m_strTable" => "ARTICULO"
));

$proto15["m_expr"]=$obj;
$proto15["m_alias"] = "";
$obj = new SQLFieldListItem($proto15);

$proto0["m_fieldlist"][]=$obj;
						$proto17=array();
			$obj = new SQLField(array(
	"m_strName" => "STOCK",
	"m_strTable" => "ARTICULO"
));

$proto17["m_expr"]=$obj;
$proto17["m_alias"] = "";
$obj = new SQLFieldListItem($proto17);

$proto0["m_fieldlist"][]=$obj;
$proto0["m_fromlist"] = array();
												$proto19=array();
$proto19["m_link"] = "SQLL_MAIN";
			$proto20=array();
$proto20["m_strName"] = "ARTICULO";
$proto20["m_columns"] = array();
$proto20["m_columns"][] = "MARCA";
$proto20["m_columns"][] = "CODART";
$proto20["m_columns"][] = "CBARRA";
$proto20["m_columns"][] = "DESART";
$proto20["m_columns"][] = "COMBUS";
$proto20["m_columns"][] = "FAMILIA";
$proto20["m_columns"][] = "NSUBF";
$proto20["m_columns"][] = "UNIDAD";
$proto20["m_columns"][] = "UNICOMP";
$proto20["m_columns"][] = "COEFICIENT";
$proto20["m_columns"][] = "STOCK";
$proto20["m_columns"][] = "MINIMO";
$proto20["m_columns"][] = "EXP_UN";
$proto20["m_columns"][] = "CPROV";
$proto20["m_columns"][] = "NOMPROV";
$proto20["m_columns"][] = "COSTO";
$proto20["m_columns"][] = "COSTIVA";
$proto20["m_columns"][] = "UTIL_1";
$proto20["m_columns"][] = "UTIL_2";
$proto20["m_columns"][] = "UTIL_3";
$proto20["m_columns"][] = "UTIL_4";
$proto20["m_columns"][] = "PVENTA_1";
$proto20["m_columns"][] = "PVENTA_2";
$proto20["m_columns"][] = "PVENTA_3";
$proto20["m_columns"][] = "PVENTA_4";
$proto20["m_columns"][] = "TASA";
$proto20["m_columns"][] = "SNI";
$proto20["m_columns"][] = "BONIF_11";
$proto20["m_columns"][] = "BONIF_12";
$proto20["m_columns"][] = "BONIF_21";
$proto20["m_columns"][] = "BONIF_22";
$proto20["m_columns"][] = "BONIF_31";
$proto20["m_columns"][] = "BONIF_32";
$proto20["m_columns"][] = "BONIF_41";
$proto20["m_columns"][] = "BONIF_42";
$proto20["m_columns"][] = "IMP_INT";
$proto20["m_columns"][] = "IMPUESTOS";
$proto20["m_columns"][] = "EN_DOLARES";
$proto20["m_columns"][] = "ULT_PRC";
$proto20["m_columns"][] = "NAC_IMP";
$proto20["m_columns"][] = "NDESPACHO";
$proto20["m_columns"][] = "ADUANA";
$proto20["m_columns"][] = "ORIGEN";
$proto20["m_columns"][] = "CUENTA";
$proto20["m_columns"][] = "CODSPROV";
$proto20["m_columns"][] = "INVENTARIO";
$obj = new SQLTable($proto20);

$proto19["m_table"] = $obj;
$proto19["m_alias"] = "";
$proto21=array();
$proto21["m_sql"] = "";
$proto21["m_uniontype"] = "SQLL_UNKNOWN";
	$obj = new SQLNonParsed(array(
	"m_sql" => ""
));

$proto21["m_column"]=$obj;
$proto21["m_contained"] = array();
$proto21["m_strCase"] = "";
$proto21["m_havingmode"] = "0";
$proto21["m_inBrackets"] = "0";
$proto21["m_useAlias"] = "0";
$obj = new SQLLogicalExpr($proto21);

$proto19["m_joinon"] = $obj;
$obj = new SQLFromListItem($proto19);

$proto0["m_fromlist"][]=$obj;
$proto0["m_groupby"] = array();
$proto0["m_orderby"] = array();
$obj = new SQLQuery($proto0);

return $obj;
}
$queryData_ARTICULO = createSqlQuery_ARTICULO();
$tdataARTICULO[".sqlquery"] = $queryData_ARTICULO;



$tableEvents["ARTICULO"] = new eventsBase;
$tdataARTICULO[".hasEvents"] = false;

?>
