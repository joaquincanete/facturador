<?php 
@ini_set("display_errors","1");
@ini_set("display_startup_errors","1");

include("include/dbcommon.php");
add_nocache_headers();

include("include/ARTICULO_variables.php");
include("classes/searchcontrol.php");
include("classes/advancedsearchcontrol.php");
include("classes/panelsearchcontrol.php");
include("classes/searchclause.php");

$sessionPrefix = $strTableName;

//Basic includes js files
$includes="";
// predefined fields num
$predefFieldNum = 0;

$chrt_array=array();
$rpt_array=array();

//	check if logged in
if( (!@$_SESSION["UserID"] || !CheckSecurity(@$_SESSION["_".$strTableName."_OwnerID"],"Search") && !@$chrt_array['status'] && !@$rpt_array['status'])
|| (@$rpt_array['status'] == "private" && @$rpt_array['owner'] != @$_SESSION["UserID"])
|| (@$chrt_array['status'] == "private" && @$chrt_array['owner'] != @$_SESSION["UserID"]) )
{ 
	$_SESSION["MyURL"]=$_SERVER["SCRIPT_NAME"]."?".$_SERVER["QUERY_STRING"];
	header("Location: login.php?message=expired"); 
	return;
}

$layout = new TLayout("search2","BoldOrange","MobileOrange");
$layout->blocks["top"] = array();
$layout->containers["search"] = array();

$layout->containers["search"][] = array("name"=>"srchheader","block"=>"","substyle"=>2);


$layout->containers["search"][] = array("name"=>"srchconditions","block"=>"conditions_block","substyle"=>1);


$layout->containers["search"][] = array("name"=>"wrapper","block"=>"","substyle"=>1);


$layout->containers["fields"] = array();

$layout->containers["fields"][] = array("name"=>"srchfields","block"=>"","substyle"=>1);


$layout->containers["fields"][] = array("name"=>"srchbuttons","block"=>"","substyle"=>2);


$layout->skins["fields"] = "fields";

$layout->skins["search"] = "1";
$layout->blocks["top"][] = "search";$page_layouts["ARTICULO_search"] = $layout;


include('include/xtempl.php');
include('classes/runnerpage.php');
$xt = new Xtempl();

// id that used to add to controls names
if(postvalue("id"))
	$id = postvalue("id");
else
	$id = 1;
	
// for usual page show proccess
$mode = SEARCH_SIMPLE;
$templatefile = "ARTICULO_search.htm";

// for ajax query, used when page buffers new control
if(postvalue("mode")=="inlineLoadCtrl"){
	$mode = SEARCH_LOAD_CONTROL;
}	
	

$calendar = false;

////////////////////// time picker
$timepicker = false;

$params = array();
$params["id"] = $id;
$params["mode"] = $mode;
$params["calendar"] = $calendar;
$params["timepicker"] = $timepicker;
$params['xt'] = &$xt;
$params['templatefile'] = $templatefile;
$params['shortTableName'] = 'ARTICULO';
$params['origTName'] = $strOriginalTableName;
$params['sessionPrefix'] = $sessionPrefix;
$params['tName'] = $strTableName;
$params['includes_js'] = $includes_js;
$params['includes_jsreq'] = $includes_jsreq;
$params['includes_css'] = $includes_css;
$params['locale_info'] = $locale_info;
$params['pageType'] = PAGE_SEARCH;

//PAGE_SEARCH,$id,$calendar

$pageObject = new RunnerPage($params);

// create reusable searchControl builder instance
$searchControllerId = (postvalue('searchControllerId') ? postvalue('searchControllerId') : $pageObject->id);

//	Before Process event
if($eventObj->exists("BeforeProcessSearch"))
	$eventObj->BeforeProcessSearch($conn);

// add constants and files for simple view
if ($mode==SEARCH_SIMPLE)
{
	$searchControlBuilder = new AdvancedSearchControl($searchControllerId, $strTableName, $pageObject->searchClauseObj, $pageObject);

	// add button events if exist
	$pageObject->addButtonHandlers();

	$includes .="<script language=\"JavaScript\" src=\"include/loadfirst.js\"></script>\r\n";
	//$includes.="<script language=\"JavaScript\" src=\"include/customlabels.js\"></script>\r\n";
		$includes.="<script type=\"text/javascript\" src=\"include/lang/".getLangFileName(mlang_getcurrentlang()).".js\"></script>";	

	// if not simple, this div already exist on page
	if (!isMobile())
		$includes.="<div id=\"search_suggest\" class=\"search_suggest\"></div>";	

	// search panel radio button assign
	$searchRadio = $searchControlBuilder->getSearchRadio();
	$xt->assign_section("all_checkbox_label", $searchRadio['all_checkbox_label'][0], $searchRadio['all_checkbox_label'][1]);
	$xt->assign_section("any_checkbox_label", $searchRadio['any_checkbox_label'][0], $searchRadio['any_checkbox_label'][1]);
	$xt->assignbyref("all_checkbox",$searchRadio['all_checkbox']);
	$xt->assignbyref("any_checkbox",$searchRadio['any_checkbox']);
		
	// search fields data
	
	if(GetLookupTable("PVENTA_1", $strTableName))
		$pageObject->settingsMap["globalSettings"]['shortTNames'][GetLookupTable("PVENTA_1", $strTableName)] = GetTableURL(GetLookupTable("PVENTA_1", $strTableName));
	
	$pageObject->fillFieldToolTips("PVENTA_1");	
		
	$srchFields = $pageObject->searchClauseObj->getSearchCtrlParams("PVENTA_1");
	$firstFieldParams = array();
	if (count($srchFields))
	{
		$firstFieldParams = $srchFields[0];
	}
	else
	{
		$firstFieldParams['fName'] = "PVENTA_1";
		$firstFieldParams['eType'] = '';
		$firstFieldParams['value1'] = '';
		$firstFieldParams['opt'] = '';
		$firstFieldParams['value2'] = '';
		$firstFieldParams['not'] = false;
	}
	// create control	
	$ctrlBlockArr = $searchControlBuilder->buildSearchCtrlBlockArr($id, $firstFieldParams['fName'], 0, $firstFieldParams['opt'], $firstFieldParams['not'], false, $firstFieldParams['value1'], $firstFieldParams['value2']);	
		
	if(isEnableSection508())
		$xt->assign_section("PVENTA_1_label","<label for=\"".GetInputElementId("PVENTA_1", $id)."\">","</label>");
	else 
		$xt->assign("PVENTA_1_label", true);
	
	$xt->assign("PVENTA_1_fieldblock", true);		
	$xt->assignbyref("PVENTA_1_editcontrol", $ctrlBlockArr['searchcontrol']);					
	$xt->assign("PVENTA_1_notbox", $ctrlBlockArr['notbox']);		
	// create second control, if need it		
	$xt->assignbyref("PVENTA_1_editcontrol1", $ctrlBlockArr['searchcontrol1']);		
	// create search type select
	$xt->assign("searchtype_PVENTA_1", $ctrlBlockArr['searchtype']);	
	$isFieldNeedSecCtrl = $searchControlBuilder->isNeedSecondCtrl("PVENTA_1");
	$ctrlInd = 0;
	if ($isFieldNeedSecCtrl) 
	{				
		$pageObject->controlsMap["search"]["searchBlocks"][] = array('fName'=>"PVENTA_1", 'recId'=>$id, 'ctrlsMap'=>array(0=>$ctrlInd, 1=>($ctrlInd+1)));
		$ctrlInd+=2;
	}
	else
	{	
		$pageObject->controlsMap["search"]["searchBlocks"][] = array('fName'=>"PVENTA_1", 'recId'=>$id, 'ctrlsMap'=>array(0=>$ctrlInd));			
		$ctrlInd++;
	}
	// search fields data
	
	if(GetLookupTable("CODART", $strTableName))
		$pageObject->settingsMap["globalSettings"]['shortTNames'][GetLookupTable("CODART", $strTableName)] = GetTableURL(GetLookupTable("CODART", $strTableName));
	
	$pageObject->fillFieldToolTips("CODART");	
		
	$srchFields = $pageObject->searchClauseObj->getSearchCtrlParams("CODART");
	$firstFieldParams = array();
	if (count($srchFields))
	{
		$firstFieldParams = $srchFields[0];
	}
	else
	{
		$firstFieldParams['fName'] = "CODART";
		$firstFieldParams['eType'] = '';
		$firstFieldParams['value1'] = '';
		$firstFieldParams['opt'] = '';
		$firstFieldParams['value2'] = '';
		$firstFieldParams['not'] = false;
	}
	// create control	
	$ctrlBlockArr = $searchControlBuilder->buildSearchCtrlBlockArr($id, $firstFieldParams['fName'], 0, $firstFieldParams['opt'], $firstFieldParams['not'], false, $firstFieldParams['value1'], $firstFieldParams['value2']);	
		
	if(isEnableSection508())
		$xt->assign_section("CODART_label","<label for=\"".GetInputElementId("CODART", $id)."\">","</label>");
	else 
		$xt->assign("CODART_label", true);
	
	$xt->assign("CODART_fieldblock", true);		
	$xt->assignbyref("CODART_editcontrol", $ctrlBlockArr['searchcontrol']);					
	$xt->assign("CODART_notbox", $ctrlBlockArr['notbox']);		
	// create second control, if need it		
	$xt->assignbyref("CODART_editcontrol1", $ctrlBlockArr['searchcontrol1']);		
	// create search type select
	$xt->assign("searchtype_CODART", $ctrlBlockArr['searchtype']);	
	$isFieldNeedSecCtrl = $searchControlBuilder->isNeedSecondCtrl("CODART");
	$ctrlInd = 0;
	if ($isFieldNeedSecCtrl) 
	{				
		$pageObject->controlsMap["search"]["searchBlocks"][] = array('fName'=>"CODART", 'recId'=>$id, 'ctrlsMap'=>array(0=>$ctrlInd, 1=>($ctrlInd+1)));
		$ctrlInd+=2;
	}
	else
	{	
		$pageObject->controlsMap["search"]["searchBlocks"][] = array('fName'=>"CODART", 'recId'=>$id, 'ctrlsMap'=>array(0=>$ctrlInd));			
		$ctrlInd++;
	}
	// search fields data
	
	if(GetLookupTable("PVENTA_2", $strTableName))
		$pageObject->settingsMap["globalSettings"]['shortTNames'][GetLookupTable("PVENTA_2", $strTableName)] = GetTableURL(GetLookupTable("PVENTA_2", $strTableName));
	
	$pageObject->fillFieldToolTips("PVENTA_2");	
		
	$srchFields = $pageObject->searchClauseObj->getSearchCtrlParams("PVENTA_2");
	$firstFieldParams = array();
	if (count($srchFields))
	{
		$firstFieldParams = $srchFields[0];
	}
	else
	{
		$firstFieldParams['fName'] = "PVENTA_2";
		$firstFieldParams['eType'] = '';
		$firstFieldParams['value1'] = '';
		$firstFieldParams['opt'] = '';
		$firstFieldParams['value2'] = '';
		$firstFieldParams['not'] = false;
	}
	// create control	
	$ctrlBlockArr = $searchControlBuilder->buildSearchCtrlBlockArr($id, $firstFieldParams['fName'], 0, $firstFieldParams['opt'], $firstFieldParams['not'], false, $firstFieldParams['value1'], $firstFieldParams['value2']);	
		
	if(isEnableSection508())
		$xt->assign_section("PVENTA_2_label","<label for=\"".GetInputElementId("PVENTA_2", $id)."\">","</label>");
	else 
		$xt->assign("PVENTA_2_label", true);
	
	$xt->assign("PVENTA_2_fieldblock", true);		
	$xt->assignbyref("PVENTA_2_editcontrol", $ctrlBlockArr['searchcontrol']);					
	$xt->assign("PVENTA_2_notbox", $ctrlBlockArr['notbox']);		
	// create second control, if need it		
	$xt->assignbyref("PVENTA_2_editcontrol1", $ctrlBlockArr['searchcontrol1']);		
	// create search type select
	$xt->assign("searchtype_PVENTA_2", $ctrlBlockArr['searchtype']);	
	$isFieldNeedSecCtrl = $searchControlBuilder->isNeedSecondCtrl("PVENTA_2");
	$ctrlInd = 0;
	if ($isFieldNeedSecCtrl) 
	{				
		$pageObject->controlsMap["search"]["searchBlocks"][] = array('fName'=>"PVENTA_2", 'recId'=>$id, 'ctrlsMap'=>array(0=>$ctrlInd, 1=>($ctrlInd+1)));
		$ctrlInd+=2;
	}
	else
	{	
		$pageObject->controlsMap["search"]["searchBlocks"][] = array('fName'=>"PVENTA_2", 'recId'=>$id, 'ctrlsMap'=>array(0=>$ctrlInd));			
		$ctrlInd++;
	}
	// search fields data
	
	if(GetLookupTable("CBARRA", $strTableName))
		$pageObject->settingsMap["globalSettings"]['shortTNames'][GetLookupTable("CBARRA", $strTableName)] = GetTableURL(GetLookupTable("CBARRA", $strTableName));
	
	$pageObject->fillFieldToolTips("CBARRA");	
		
	$srchFields = $pageObject->searchClauseObj->getSearchCtrlParams("CBARRA");
	$firstFieldParams = array();
	if (count($srchFields))
	{
		$firstFieldParams = $srchFields[0];
	}
	else
	{
		$firstFieldParams['fName'] = "CBARRA";
		$firstFieldParams['eType'] = '';
		$firstFieldParams['value1'] = '';
		$firstFieldParams['opt'] = '';
		$firstFieldParams['value2'] = '';
		$firstFieldParams['not'] = false;
	}
	// create control	
	$ctrlBlockArr = $searchControlBuilder->buildSearchCtrlBlockArr($id, $firstFieldParams['fName'], 0, $firstFieldParams['opt'], $firstFieldParams['not'], false, $firstFieldParams['value1'], $firstFieldParams['value2']);	
		
	if(isEnableSection508())
		$xt->assign_section("CBARRA_label","<label for=\"".GetInputElementId("CBARRA", $id)."\">","</label>");
	else 
		$xt->assign("CBARRA_label", true);
	
	$xt->assign("CBARRA_fieldblock", true);		
	$xt->assignbyref("CBARRA_editcontrol", $ctrlBlockArr['searchcontrol']);					
	$xt->assign("CBARRA_notbox", $ctrlBlockArr['notbox']);		
	// create second control, if need it		
	$xt->assignbyref("CBARRA_editcontrol1", $ctrlBlockArr['searchcontrol1']);		
	// create search type select
	$xt->assign("searchtype_CBARRA", $ctrlBlockArr['searchtype']);	
	$isFieldNeedSecCtrl = $searchControlBuilder->isNeedSecondCtrl("CBARRA");
	$ctrlInd = 0;
	if ($isFieldNeedSecCtrl) 
	{				
		$pageObject->controlsMap["search"]["searchBlocks"][] = array('fName'=>"CBARRA", 'recId'=>$id, 'ctrlsMap'=>array(0=>$ctrlInd, 1=>($ctrlInd+1)));
		$ctrlInd+=2;
	}
	else
	{	
		$pageObject->controlsMap["search"]["searchBlocks"][] = array('fName'=>"CBARRA", 'recId'=>$id, 'ctrlsMap'=>array(0=>$ctrlInd));			
		$ctrlInd++;
	}
	// search fields data
	
	if(GetLookupTable("PVENTA_3", $strTableName))
		$pageObject->settingsMap["globalSettings"]['shortTNames'][GetLookupTable("PVENTA_3", $strTableName)] = GetTableURL(GetLookupTable("PVENTA_3", $strTableName));
	
	$pageObject->fillFieldToolTips("PVENTA_3");	
		
	$srchFields = $pageObject->searchClauseObj->getSearchCtrlParams("PVENTA_3");
	$firstFieldParams = array();
	if (count($srchFields))
	{
		$firstFieldParams = $srchFields[0];
	}
	else
	{
		$firstFieldParams['fName'] = "PVENTA_3";
		$firstFieldParams['eType'] = '';
		$firstFieldParams['value1'] = '';
		$firstFieldParams['opt'] = '';
		$firstFieldParams['value2'] = '';
		$firstFieldParams['not'] = false;
	}
	// create control	
	$ctrlBlockArr = $searchControlBuilder->buildSearchCtrlBlockArr($id, $firstFieldParams['fName'], 0, $firstFieldParams['opt'], $firstFieldParams['not'], false, $firstFieldParams['value1'], $firstFieldParams['value2']);	
		
	if(isEnableSection508())
		$xt->assign_section("PVENTA_3_label","<label for=\"".GetInputElementId("PVENTA_3", $id)."\">","</label>");
	else 
		$xt->assign("PVENTA_3_label", true);
	
	$xt->assign("PVENTA_3_fieldblock", true);		
	$xt->assignbyref("PVENTA_3_editcontrol", $ctrlBlockArr['searchcontrol']);					
	$xt->assign("PVENTA_3_notbox", $ctrlBlockArr['notbox']);		
	// create second control, if need it		
	$xt->assignbyref("PVENTA_3_editcontrol1", $ctrlBlockArr['searchcontrol1']);		
	// create search type select
	$xt->assign("searchtype_PVENTA_3", $ctrlBlockArr['searchtype']);	
	$isFieldNeedSecCtrl = $searchControlBuilder->isNeedSecondCtrl("PVENTA_3");
	$ctrlInd = 0;
	if ($isFieldNeedSecCtrl) 
	{				
		$pageObject->controlsMap["search"]["searchBlocks"][] = array('fName'=>"PVENTA_3", 'recId'=>$id, 'ctrlsMap'=>array(0=>$ctrlInd, 1=>($ctrlInd+1)));
		$ctrlInd+=2;
	}
	else
	{	
		$pageObject->controlsMap["search"]["searchBlocks"][] = array('fName'=>"PVENTA_3", 'recId'=>$id, 'ctrlsMap'=>array(0=>$ctrlInd));			
		$ctrlInd++;
	}
	// search fields data
	
	if(GetLookupTable("DESART", $strTableName))
		$pageObject->settingsMap["globalSettings"]['shortTNames'][GetLookupTable("DESART", $strTableName)] = GetTableURL(GetLookupTable("DESART", $strTableName));
	
	$pageObject->fillFieldToolTips("DESART");	
		
	$srchFields = $pageObject->searchClauseObj->getSearchCtrlParams("DESART");
	$firstFieldParams = array();
	if (count($srchFields))
	{
		$firstFieldParams = $srchFields[0];
	}
	else
	{
		$firstFieldParams['fName'] = "DESART";
		$firstFieldParams['eType'] = '';
		$firstFieldParams['value1'] = '';
		$firstFieldParams['opt'] = '';
		$firstFieldParams['value2'] = '';
		$firstFieldParams['not'] = false;
	}
	// create control	
	$ctrlBlockArr = $searchControlBuilder->buildSearchCtrlBlockArr($id, $firstFieldParams['fName'], 0, $firstFieldParams['opt'], $firstFieldParams['not'], false, $firstFieldParams['value1'], $firstFieldParams['value2']);	
		
	if(isEnableSection508())
		$xt->assign_section("DESART_label","<label for=\"".GetInputElementId("DESART", $id)."\">","</label>");
	else 
		$xt->assign("DESART_label", true);
	
	$xt->assign("DESART_fieldblock", true);		
	$xt->assignbyref("DESART_editcontrol", $ctrlBlockArr['searchcontrol']);					
	$xt->assign("DESART_notbox", $ctrlBlockArr['notbox']);		
	// create second control, if need it		
	$xt->assignbyref("DESART_editcontrol1", $ctrlBlockArr['searchcontrol1']);		
	// create search type select
	$xt->assign("searchtype_DESART", $ctrlBlockArr['searchtype']);	
	$isFieldNeedSecCtrl = $searchControlBuilder->isNeedSecondCtrl("DESART");
	$ctrlInd = 0;
	if ($isFieldNeedSecCtrl) 
	{				
		$pageObject->controlsMap["search"]["searchBlocks"][] = array('fName'=>"DESART", 'recId'=>$id, 'ctrlsMap'=>array(0=>$ctrlInd, 1=>($ctrlInd+1)));
		$ctrlInd+=2;
	}
	else
	{	
		$pageObject->controlsMap["search"]["searchBlocks"][] = array('fName'=>"DESART", 'recId'=>$id, 'ctrlsMap'=>array(0=>$ctrlInd));			
		$ctrlInd++;
	}
	// search fields data
	
	if(GetLookupTable("STOCK", $strTableName))
		$pageObject->settingsMap["globalSettings"]['shortTNames'][GetLookupTable("STOCK", $strTableName)] = GetTableURL(GetLookupTable("STOCK", $strTableName));
	
	$pageObject->fillFieldToolTips("STOCK");	
		
	$srchFields = $pageObject->searchClauseObj->getSearchCtrlParams("STOCK");
	$firstFieldParams = array();
	if (count($srchFields))
	{
		$firstFieldParams = $srchFields[0];
	}
	else
	{
		$firstFieldParams['fName'] = "STOCK";
		$firstFieldParams['eType'] = '';
		$firstFieldParams['value1'] = '';
		$firstFieldParams['opt'] = '';
		$firstFieldParams['value2'] = '';
		$firstFieldParams['not'] = false;
	}
	// create control	
	$ctrlBlockArr = $searchControlBuilder->buildSearchCtrlBlockArr($id, $firstFieldParams['fName'], 0, $firstFieldParams['opt'], $firstFieldParams['not'], false, $firstFieldParams['value1'], $firstFieldParams['value2']);	
		
	if(isEnableSection508())
		$xt->assign_section("STOCK_label","<label for=\"".GetInputElementId("STOCK", $id)."\">","</label>");
	else 
		$xt->assign("STOCK_label", true);
	
	$xt->assign("STOCK_fieldblock", true);		
	$xt->assignbyref("STOCK_editcontrol", $ctrlBlockArr['searchcontrol']);					
	$xt->assign("STOCK_notbox", $ctrlBlockArr['notbox']);		
	// create second control, if need it		
	$xt->assignbyref("STOCK_editcontrol1", $ctrlBlockArr['searchcontrol1']);		
	// create search type select
	$xt->assign("searchtype_STOCK", $ctrlBlockArr['searchtype']);	
	$isFieldNeedSecCtrl = $searchControlBuilder->isNeedSecondCtrl("STOCK");
	$ctrlInd = 0;
	if ($isFieldNeedSecCtrl) 
	{				
		$pageObject->controlsMap["search"]["searchBlocks"][] = array('fName'=>"STOCK", 'recId'=>$id, 'ctrlsMap'=>array(0=>$ctrlInd, 1=>($ctrlInd+1)));
		$ctrlInd+=2;
	}
	else
	{	
		$pageObject->controlsMap["search"]["searchBlocks"][] = array('fName'=>"STOCK", 'recId'=>$id, 'ctrlsMap'=>array(0=>$ctrlInd));			
		$ctrlInd++;
	}
	
	//--------------------------------------------------------
	
	$pageObject->body["begin"] .= $includes;

	$pageObject->addCommonJs();
		
	$xt->assignbyref("body",$pageObject->body);
	
	$xt->assign("contents_block", true);
	
	$xt->assign("conditions_block",true);
	$xt->assign("search_button",true);
	$xt->assign("reset_button",true);
	$xt->assign("back_button",true);
	
	
	$xt->assign("searchbutton_attrs","id=\"searchButton".$id."\"");
	$xt->assign("resetbutton_attrs","id=\"resetButton".$id."\"");		
	$xt->assign("backbutton_attrs","id=\"backButton".$id."\"");
	

	// for crosse report 
	
	if (postvalue('axis_x')!=''){
		$xtCrosseElem = "<input type=\"hidden\" id=\"select_group_x\" value=\"".postvalue('axis_x')."\">
						<input type=\"hidden\" id=\"select_group_y\" value=\"".postvalue('axis_y')."\">
						<input type=\"hidden\" id=\"select_data\" value=\"".postvalue('field')."\">
						<input type=\"hidden\" id=\"group_func_hidden\" value=\"".postvalue('group_func')."\">
						";
		$xt->assign("CrossElem",$xtCrosseElem);
	}
	// for crosse report
	if($eventObj->exists("BeforeShowSearch"))
		$eventObj->BeforeShowSearch($xt,$templatefile);
	// load controls for first page loading	
	
	
	$pageObject->fillSetCntrlMaps();
	
	$pageObject->body['end'] .= '<script>';
	$pageObject->body['end'] .= "window.controlsMap = ".my_json_encode($pageObject->controlsHTMLMap).";";
	$pageObject->body['end'] .= "window.settings = ".my_json_encode($pageObject->jsSettings).";";
	$pageObject->body['end'] .= '</script>';
		$pageObject->body['end'] .= "<script language=\"JavaScript\" src=\"include/runnerJS/RunnerAll.js\"></script>\r\n";
	$pageObject->body["end"] .= "<script>".$pageObject->PrepareJs()."</script>";	
	
	$xt->assignbyref("body",$pageObject->body);
	$xt->display($templatefile);
	exit();	
}
else if($mode==SEARCH_LOAD_CONTROL)
{	

	$searchControlBuilder = new PanelSearchControl($searchControllerId, $strTableName, $pageObject->searchClauseObj, $pageObject);
	$ctrlField = postvalue('ctrlField');	
	$ctrlBlockArr = $searchControlBuilder->buildSearchCtrlBlockArr($id, $ctrlField, 0, '', false, true, '', '');	
	
	// build array for encode
	$resArr = array();
	$resArr['control1'] = trim($xt->call_func($ctrlBlockArr['searchcontrol']));
	$resArr['control2'] = trim($xt->call_func($ctrlBlockArr['searchcontrol1']));
	$resArr['comboHtml'] = trim($ctrlBlockArr['searchtype']);
	$resArr['delButt'] = trim($ctrlBlockArr['delCtrlButt']);
	$resArr['delButtId'] =  trim($searchControlBuilder->getDelButtonId($ctrlField, $id));
	$resArr['divInd'] = trim($id);	
	$resArr['fLabel'] = GetFieldLabel(GoodFieldName($strTableName),GoodFieldName($ctrlField));
	$resArr['ctrlMap'] = $pageObject->controlsMap['controls'];
	
	if (postvalue('isNeedSettings') == 'true')
	{
		$pageObject->fillSettings();
		$resArr['settings'] = $pageObject->jsSettings;
	}
		
	// return JSON
	echo my_json_encode($resArr);
	exit();
}
	

?>
