<?php
@ini_set("display_errors","1");
@ini_set("display_startup_errors","1");

include("include/dbcommon.php");
include("classes/searchclause.php");

add_nocache_headers();

include("include/ARTICULO_variables.php");

if(!@$_SESSION["UserID"])
{ 
	$_SESSION["MyURL"]=$_SERVER["SCRIPT_NAME"]."?".$_SERVER["QUERY_STRING"];
	header("Location: login.php?message=expired"); 
	return;
}
if(!CheckSecurity(@$_SESSION["_".$strTableName."_OwnerID"],"Export"))
{
	echo "<p>"."No tiene permiso para acceder a esta tabla"."<a href=\"login.php\">"."Regresar a la página de conexión"."</a></p>";
	return;
}

$layout = new TLayout("print","BoldOrange","MobileOrange");
$layout->blocks["center"] = array();
$layout->containers["grid"] = array();

$layout->containers["grid"][] = array("name"=>"printgrid","block"=>"grid_block","substyle"=>1);


$layout->skins["grid"] = "empty";
$layout->blocks["center"][] = "grid";$layout->blocks["top"] = array();
$layout->skins["master"] = "empty";
$layout->blocks["top"][] = "master";
$layout->skins["pdf"] = "empty";
$layout->blocks["top"][] = "pdf";$page_layouts["ARTICULO_print"] = $layout;


include('include/xtempl.php');
include('classes/runnerpage.php');

$xt = new Xtempl();
$id = postvalue("id") != "" ? postvalue("id") : 1;
$all = postvalue("all");
$pageName = "print.php";

//array of params for classes
$params = array("id" => $id,
				"tName" => $strTableName,
				"pageType" => PAGE_PRINT);
$params["xt"] = &$xt;
			
$pageObject = new RunnerPage($params);

// add button events if exist
$pageObject->addButtonHandlers();

// Modify query: remove blob fields from fieldlist.
// Blob fields on a print page are shown using imager.php (for example).
// They don't need to be selected from DB in print.php itself.
if(!postvalue("pdf"))
	$gQuery->ReplaceFieldsWithDummies(GetBinaryFieldsIndices());

//	Before Process event
if($eventObj->exists("BeforeProcessPrint"))
	$eventObj->BeforeProcessPrint($conn);

$strWhereClause="";
$strHavingClause="";
$strSearchCriteria="and";

$selected_recs=array();
if (@$_REQUEST["a"]!="") 
{
	$sWhere = "1=0";	
	
//	process selection
	if (@$_REQUEST["mdelete"])
	{
		foreach(@$_REQUEST["mdelete"] as $ind)
		{
			$keys=array();
			$keys["CODART"]=refine($_REQUEST["mdelete1"][mdeleteIndex($ind)]);
			$keys["DESART"]=refine($_REQUEST["mdelete2"][mdeleteIndex($ind)]);
			$keys["STOCK"]=refine($_REQUEST["mdelete3"][mdeleteIndex($ind)]);
			$selected_recs[]=$keys;
		}
	}
	elseif(@$_REQUEST["selection"])
	{
		foreach(@$_REQUEST["selection"] as $keyblock)
		{
			$arr=explode("&",refine($keyblock));
			if(count($arr)<3)
				continue;
			$keys=array();
			$keys["CODART"]=urldecode($arr[0]);
			$keys["DESART"]=urldecode($arr[1]);
			$keys["STOCK"]=urldecode($arr[2]);
			$selected_recs[]=$keys;
		}
	}

	foreach($selected_recs as $keys)
	{
		$sWhere = $sWhere . " or ";
		$sWhere.=KeyWhere($keys);
	}
	$strSQL = gSQLWhere($sWhere);
	$strWhereClause=$sWhere;
}
else
{
	$strWhereClause=@$_SESSION[$strTableName."_where"];
	$strHavingClause=@$_SESSION[$strTableName."_having"];
	$strSearchCriteria=@$_SESSION[$strTableName."_criteria"];
	$strSQL = gSQLWhere($strWhereClause, $strHavingClause, $strSearchCriteria);
}
if(postvalue("pdf"))
	$strWhereClause = @$_SESSION[$strTableName."_pdfwhere"];

$_SESSION[$strTableName."_pdfwhere"] = $strWhereClause;


$strOrderBy=$_SESSION[$strTableName."_order"];
if(!$strOrderBy)
	$strOrderBy=$gstrOrderBy;
$strSQL.=" ".trim($strOrderBy);

$strSQLbak = $strSQL;
if($eventObj->exists("BeforeQueryPrint"))
	$eventObj->BeforeQueryPrint($strSQL,$strWhereClause,$strOrderBy);

//	Rebuild SQL if needed

if($strSQL!=$strSQLbak)
{
//	changed $strSQL - old style	
	$numrows=GetRowCount($strSQL);
}
else
{
	$strSQL = gSQLWhere($strWhereClause, $strHavingClause, $strSearchCriteria);
	$strSQL.=" ".trim($strOrderBy);
	
	$rowcount=false;
	if($eventObj->exists("ListGetRowCount"))
	{
		$masterKeysReq=array();
		for($i = 0; $i < count($pageObject->detailKeysByM); $i ++)
			$masterKeysReq[]=$_SESSION[$strTableName."_masterkey".($i + 1)];
			$rowcount=$eventObj->ListGetRowCount($pageObject->searchClauseObj,$_SESSION[$strTableName."_mastertable"],$masterKeysReq,$selected_recs);
	}
	if($rowcount!==false)
		$numrows=$rowcount;
	else
	{
		$numrows = gSQLRowCount($strWhereClause, $strHavingClause, $strSearchCriteria);
	}
}

LogInfo($strSQL);

$mypage=(integer)$_SESSION[$strTableName."_pagenumber"];
if(!$mypage)
	$mypage=1;

//	page size
$PageSize=(integer)$_SESSION[$strTableName."_pagesize"];
if(!$PageSize)
	$PageSize = GetTableData($strTableName,".pageSize",0);

if($PageSize<0)
	$all = 1;	
	
$recno = 1;
$records = 0;	
$maxpages = 1;
$pageindex = 1;
$pageno=1;

if(!$all)
{	
	if($numrows)
	{
		$maxRecords = $numrows;
		$maxpages = ceil($maxRecords/$PageSize);
					
		if($mypage > $maxpages)
			$mypage = $maxpages;
		
		if($mypage < 1) 
			$mypage = 1;
		
		$maxrecs = $PageSize;
	}
	$listarray = false;
	if($eventObj->exists("ListQuery"))
		$listarray = $eventObj->ListQuery($pageObject->searchClauseObj,$_SESSION[$strTableName."_arrFieldForSort"],$_SESSION[$strTableName."_arrHowFieldSort"],$_SESSION[$strTableName."_mastertable"],$masterKeysReq,$selected_recs,$PageSize,$mypage);
	if($listarray!==false)
		$rs = $listarray;
	else
	{
			$rs = db_query($strSQL,$conn);
		db_pageseek($rs,$PageSize,$mypage);
	}
	
	//	hide colunm headers if needed
	$recordsonpage = $numrows-($mypage-1)*$PageSize;
	if($recordsonpage>$PageSize)
		$recordsonpage = $PageSize;
		
	$xt->assign("page_number",true);
	$xt->assign("maxpages",$maxpages);
	$xt->assign("pageno",$mypage);
}
else
{
	$listarray = false;
	if($eventObj->exists("ListQuery"))
		$listarray=$eventObj->ListQuery($pageObject->searchClauseObj,$_SESSION[$strTableName."_arrFieldForSort"],$_SESSION[$strTableName."_arrHowFieldSort"],$_SESSION[$strTableName."_mastertable"],$masterKeysReq,$selected_recs,$PageSize,$mypage);
	if($listarray!==false)
		$rs = $listarray;
	else
		$rs = db_query($strSQL,$conn);
	$recordsonpage = $numrows;
	$maxpages = ceil($recordsonpage/30);
	$xt->assign("page_number",true);
	$xt->assign("maxpages",$maxpages);
}


$fieldsArr = array();
$arr = array();
$arr['fName'] = "CODART";
$arr['viewFormat'] = ViewFormat("CODART", $strTableName);
$fieldsArr[] = $arr;
$arr = array();
$arr['fName'] = "CBARRA";
$arr['viewFormat'] = ViewFormat("CBARRA", $strTableName);
$fieldsArr[] = $arr;
$arr = array();
$arr['fName'] = "DESART";
$arr['viewFormat'] = ViewFormat("DESART", $strTableName);
$fieldsArr[] = $arr;
$arr = array();
$arr['fName'] = "PVENTA_1";
$arr['viewFormat'] = ViewFormat("PVENTA_1", $strTableName);
$fieldsArr[] = $arr;
$arr = array();
$arr['fName'] = "PVENTA_2";
$arr['viewFormat'] = ViewFormat("PVENTA_2", $strTableName);
$fieldsArr[] = $arr;
$arr = array();
$arr['fName'] = "PVENTA_3";
$arr['viewFormat'] = ViewFormat("PVENTA_3", $strTableName);
$fieldsArr[] = $arr;
$arr = array();
$arr['fName'] = "STOCK";
$arr['viewFormat'] = ViewFormat("STOCK", $strTableName);
$fieldsArr[] = $arr;
$pageObject->setGoogleMapsParams($fieldsArr);

$colsonpage=1;
if($colsonpage>$recordsonpage)
	$colsonpage=$recordsonpage;
if($colsonpage<1)
	$colsonpage=1;


//	fill $rowinfo array
	$pages = array();
	$rowinfo = array();
	$rowinfo["data"] = array();
	if($eventObj->exists("ListFetchArray"))
		$data = $eventObj->ListFetchArray($rs);
	else
		$data = db_fetch_array($rs);

	while($data)
	{
		if($eventObj->exists("BeforeProcessRowPrint"))
		{
			if(!$eventObj->BeforeProcessRowPrint($data))
			{
				if($eventObj->exists("ListFetchArray"))
					$data = $eventObj->ListFetchArray($rs);
				else
					$data = db_fetch_array($rs);
				continue;
			}
		}
		break;
	}
	
	while($data && ($all || $recno<=$PageSize))
	{
		$row = array();
		$row["grid_record"] = array();
		$row["grid_record"]["data"] = array();
		for($col=1;$data && ($all || $recno<=$PageSize) && $col<=1;$col++)
		{
			$record = array();
			$recno++;
			$records++;
			$keylink="";
			$keylink.="&key1=".htmlspecialchars(rawurlencode(@$data["CODART"]));
			$keylink.="&key2=".htmlspecialchars(rawurlencode(@$data["DESART"]));
			$keylink.="&key3=".htmlspecialchars(rawurlencode(@$data["STOCK"]));


//	CODART - 
			$value="";
				$value = ProcessLargeText(GetData($data,"CODART", ""),"field=CODART".$keylink,"",MODE_PRINT);
			$record["CODART_value"]=$value;

//	CBARRA - 
			$value="";
				$value = ProcessLargeText(GetData($data,"CBARRA", ""),"field=CBARRA".$keylink,"",MODE_PRINT);
			$record["CBARRA_value"]=$value;

//	DESART - 
			$value="";
				$value = ProcessLargeText(GetData($data,"DESART", ""),"field=DESART".$keylink,"",MODE_PRINT);
			$record["DESART_value"]=$value;

//	PVENTA_1 - Number
			$value="";
				$value = ProcessLargeText(GetData($data,"PVENTA_1", "Number"),"field=PVENTA%5F1".$keylink,"",MODE_PRINT);
			$record["PVENTA_1_value"]=$value;

//	PVENTA_2 - Number
			$value="";
				$value = ProcessLargeText(GetData($data,"PVENTA_2", "Number"),"field=PVENTA%5F2".$keylink,"",MODE_PRINT);
			$record["PVENTA_2_value"]=$value;

//	PVENTA_3 - Number
			$value="";
				$value = ProcessLargeText(GetData($data,"PVENTA_3", "Number"),"field=PVENTA%5F3".$keylink,"",MODE_PRINT);
			$record["PVENTA_3_value"]=$value;

//	STOCK - Number
			$value="";
				$value = ProcessLargeText(GetData($data,"STOCK", "Number"),"field=STOCK".$keylink,"",MODE_PRINT);
			$record["STOCK_value"]=$value;
			if($col<$colsonpage)
				$record["endrecord_block"]=true;
			$record["grid_recordheader"]=true;
			$record["grid_vrecord"]=true;
			
			if($eventObj->exists("BeforeMoveNextPrint"))
				$eventObj->BeforeMoveNextPrint($data,$row,$record);
				
			$row["grid_record"]["data"][]=$record;
			
			if($eventObj->exists("ListFetchArray"))
				$data = $eventObj->ListFetchArray($rs);
			else
				$data = db_fetch_array($rs);
				
			while($data)
			{
				if($eventObj->exists("BeforeProcessRowPrint"))
				{
					if(!$eventObj->BeforeProcessRowPrint($data))
					{
						if($eventObj->exists("ListFetchArray"))
							$data = $eventObj->ListFetchArray($rs);
						else
							$data = db_fetch_array($rs);
						continue;
					}
				}
				break;
			}
		}
		if($col<=$colsonpage)
		{
			$row["grid_record"]["data"][count($row["grid_record"]["data"])-1]["endrecord_block"]=false;
		}
		$row["grid_rowspace"]=true;
		$row["grid_recordspace"] = array("data"=>array());
		for($i=0;$i<$colsonpage*2-1;$i++)
			$row["grid_recordspace"]["data"][]=true;
		
		$rowinfo["data"][]=$row;
		
		if($all && $records>=30)
		{
			$page=array("grid_row" =>$rowinfo);
			$page["pageno"]=$pageindex;
			$pageindex++;
			$pages[] = $page;
			$records=0;
			$rowinfo=array();
		}
		
	}
	if(count($rowinfo))
	{
		$page=array("grid_row" =>$rowinfo);
		if($all)
			$page["pageno"]=$pageindex;
		$pages[] = $page;
	}
	
	for($i=0;$i<count($pages);$i++)
	{
	 	if($i<count($pages)-1)
			$pages[$i]["begin"]="<div name=page class=printpage>";
		else
		    $pages[$i]["begin"]="<div name=page>";
			
		$pages[$i]["end"]="</div>";
	}

	$page = array();
	$page["data"] = &$pages;
	$xt->assignbyref("page",$page);

	

$strSQL = $_SESSION[$strTableName."_sql"];

$isPdfView = false;
$hasEvents = false;
if (GetTableData($strTableName, ".isUsebuttonHandlers", false) || $isPdfView || $hasEvents)
{
	$pageObject->body["begin"] .="<script type=\"text/javascript\" src=\"include/loadfirst.js\"></script>\r\n";
		$pageObject->body["begin"] .= "<script type=\"text/javascript\" src=\"include/lang/".getLangFileName(mlang_getcurrentlang()).".js\"></script>";
	
	$pageObject->fillSetCntrlMaps();
	$pageObject->body['end'] .= '<script>';
	$pageObject->body['end'] .= "window.controlsMap = ".my_json_encode($pageObject->controlsHTMLMap).";";
	$pageObject->body['end'] .= "window.settings = ".my_json_encode($pageObject->jsSettings).";";
	$pageObject->body['end'] .= '</script>';
		$pageObject->body["end"] .= "<script language=\"JavaScript\" src=\"include/runnerJS/RunnerAll.js\"></script>\r\n";
	$pageObject->addCommonJs();
}


if (GetTableData($strTableName, ".isUsebuttonHandlers", false) || $isPdfView || $hasEvents)
	$pageObject->body["end"] .= "<script>".$pageObject->PrepareJS()."</script>";

$xt->assignbyref("body",$pageObject->body);
$xt->assign("grid_block",true);

$xt->assign("CODART_fieldheadercolumn",true);
$xt->assign("CODART_fieldheader",true);
$xt->assign("CODART_fieldcolumn",true);
$xt->assign("CODART_fieldfootercolumn",true);
$xt->assign("CBARRA_fieldheadercolumn",true);
$xt->assign("CBARRA_fieldheader",true);
$xt->assign("CBARRA_fieldcolumn",true);
$xt->assign("CBARRA_fieldfootercolumn",true);
$xt->assign("DESART_fieldheadercolumn",true);
$xt->assign("DESART_fieldheader",true);
$xt->assign("DESART_fieldcolumn",true);
$xt->assign("DESART_fieldfootercolumn",true);
$xt->assign("PVENTA_1_fieldheadercolumn",true);
$xt->assign("PVENTA_1_fieldheader",true);
$xt->assign("PVENTA_1_fieldcolumn",true);
$xt->assign("PVENTA_1_fieldfootercolumn",true);
$xt->assign("PVENTA_2_fieldheadercolumn",true);
$xt->assign("PVENTA_2_fieldheader",true);
$xt->assign("PVENTA_2_fieldcolumn",true);
$xt->assign("PVENTA_2_fieldfootercolumn",true);
$xt->assign("PVENTA_3_fieldheadercolumn",true);
$xt->assign("PVENTA_3_fieldheader",true);
$xt->assign("PVENTA_3_fieldcolumn",true);
$xt->assign("PVENTA_3_fieldfootercolumn",true);
$xt->assign("STOCK_fieldheadercolumn",true);
$xt->assign("STOCK_fieldheader",true);
$xt->assign("STOCK_fieldcolumn",true);
$xt->assign("STOCK_fieldfootercolumn",true);

	$record_header=array("data"=>array());
	$record_footer=array("data"=>array());
	for($i=0;$i<$colsonpage;$i++)
	{
		$rheader=array();
		$rfooter=array();
		if($i<$colsonpage-1)
		{
			$rheader["endrecordheader_block"]=true;
			$rfooter["endrecordheader_block"]=true;
		}
		$record_header["data"][]=$rheader;
		$record_footer["data"][]=$rfooter;
	}
	$xt->assignbyref("record_header",$record_header);
	$xt->assignbyref("record_footer",$record_footer);
	$xt->assign("grid_header",true);
	$xt->assign("grid_footer",true);

if($eventObj->exists("BeforeShowPrint"))
	$eventObj->BeforeShowPrint($xt,$pageObject->templatefile);

if(!postvalue("pdf"))
	$xt->display($pageObject->templatefile);
else
{
	$xt->load_template($pageObject->templatefile);
	$page = $xt->fetch_loaded();
	$pagewidth=postvalue("width")*1.05;
	$pageheight=postvalue("height")*1.05;
	$landscape=false;
		if($pagewidth>$pageheight)
		{
			$landscape=true;
			if($pagewidth/$pageheight<297/210)
				$pagewidth = 297/210*$pageheight;
		}
		else
		{
			if($pagewidth/$pageheight<210/297)
				$pagewidth = 210/297*$pageheight;
		}
}

?>
