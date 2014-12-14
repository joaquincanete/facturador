<?php

/**
 * That function  copies all elements from associative array to object, as object properties with same names
 * Usefull when you need to copy many properties
 *
 * @param link $obj
 * @param link $argsArr
 */
function RunnerApply (&$obj, &$argsArr)
{	
	foreach ($argsArr as $key=>$var)
		setObjectProperty($obj,$key,$argsArr[$key]);
}

include_once(getabspath("classes/files.php"));
/**
 *  Define constants of name page 
 *
 * @var constants
 */
define('PAGE_LIST',"list");
define('PAGE_ADD',"add");
define('PAGE_EDIT',"edit");
define('PAGE_VIEW',"view");
define('PAGE_MENU',"menu");
define('PAGE_LOGIN',"login");
define('PAGE_REGISTER',"register");
define('PAGE_REMIND',"remind");
define('PAGE_CHANGEPASS',"changepwd");
define('PAGE_SEARCH',"search");
define('PAGE_REPORT',"report");
define('PAGE_CHART',"chart");
define('PAGE_PRINT',"print");
define('PAGE_RPRINT',"rprint");
define('PAGE_EXPORT',"export");
define('PAGE_IMPORT',"import");
define('PAGE_ADMIN_MEMBERS',"admin_members");
define('PAGE_ADMIN_RIGHTS',"admin_rights");

/**
 * Abstract base class for all pages. Contains main functionality
 */
class RunnerPage
{
	/**
      * Id on page.
      *
      * @var integer
	  * @intellisense
      */
	var $id = 1;
	/**
      * Use calendar or not
      *
      * @var bool
	  * @intellisense
      */
	var $calendar = false;
	/**
      * Use timepicker or not
      *
      * @var bool
	  * @intellisense
      */
	var $timepicker = false;
	/**
      * Use iBox or not
      *
      * @var bool
	  * @intellisense
      */
	var $useIbox = false;
	/**
      * Use tool tips or not
      *
      * @var bool
	  * @intellisense
      */
	var $isUseToolTips = false;
	/**
	 * If use Ajax Suggest js file or not
	 *
	 * @var bool
	  * @intellisense
	 */
	var $isUseAjaxSuggest = true;
	/**
      * Type of page
      *
      * @var string
	  * @intellisense
      */
	var $pageType = "";
	/**
      * Mode of page
      *
      * @var integer
	  * @intellisense
      */
	var $mode = 0;
	/**
 	  * If use display loading or not
	  *
	  * @var bool
	  * @intellisense
	  */
	var $isDisplayLoading = false;
	/**
      * Original table name
      *
      * @var string
	  * @intellisense
      */
	var $strOriginalTableName = "";
	/**
	 * String caption of table
	 *
	 * @var string
     * @intellisense
	 */
	var $strCaption = "";
	/**
      * Short table name
      *
      * @var string
	  * @intellisense
      */
	var $shortTableName = '';
	/**
      * Prefix for session variable
      *
      * @var integer
	  * @intellisense
      */
	var $sessionPrefix = "";
	/**
      * Name of current table
      *
      * @var string
	  * @intellisense
      */	
	var $tName = "";
	/**
      * Connect to database
      *
      * @var string
	  * @intellisense
      */
	var $conn = "";
	/**
      * Array of order index in table
      *
      * @var array()
	  * @intellisense
      */
	var $gOrderIndexes = array();
	/**
      * String of OrderBy for query
      *
      * @var string
	  * @intellisense
      */
	var $gstrOrderBy = "";
	/**
      * Page size
      *
      * @var integer
	  * @intellisense
      */
	var $gPageSize = 0;
	/**
      * Instance of class Xtempl
      *
      * @var object
	  * @intellisense
      * @objtype{XTempl}
      */
	var $xt = null;
	/**
	 * Instance of SearchClause class
	 *
	 * @var object
     * @intellisense
	 * @objtype{SearchClause}
	 */
	var $searchClauseObj = null;
	/**
      * Need use search clause object or not 
      *
      * @var boolean
	  * @intellisense
      */
	var $needSearchClauseObj = true;
	
	var $flyId = 1;
	/**
	 *	The list of including js files 
	 */	  
	var $includes_js = array();
	/**
	 *	The list of including js files 
	 */
	var $includes_jsreq = array();
	/**
	 *	The list of including css files
	 */
	var $includes_css = array();
	/**
	 *	The list of including css files wich have IE extension
	 */
	var $includes_cssIE = array();	
	/**
	 *	Locale tunes
	 */
	var $locale_info = array();
	/**
	 * Id of record
	 *
	 * @var integer
	 */
	var $recId = 0;
	/**
	 * Google maps default settings
	 *
	 * @var array
	 */
	var $googleMapCfg = array();
	/**
	 * Array of permissions for pages
	 *
	 * @var array
	 */
	var $permis = array();
	/**
	 * If use group scurity or not
	 *
	 * @var bool
	 */
	var $isGroupSecurity = true;
	/**
	 * Use or not debug mode for js
	 *
	 * @var bool
	 */
	var $debugJSMode = false;
	/**
	 * Use mode ajax for simple listPage
	 *
	 * @var boolean
	 */
	var $listAjax = false;
	/**
	 * Array of body begin, end code and body attributs
	 *
	 * @var array
	 */
	var $body = array('begin' => '', 'end'=> '');
	
	/**
	 * Master table name
	 *
	 * @var string
	 */
	var $masterTable = "";
	/**
	 * If use Details Preview js file or not
	 *
	 * @var bool
	 */
	var $useDetailsPreview = false;
	/**
	 * Array of all details tables data
	 *
	 * @var array
	 */	
	var $allDetailsTablesArr = array();
	/**
	 * Array of java script settings for page
	 *
	 * @var array
	 */	
	var $jsSettings = array();
	/**
	 * Array of controls HTML map
	 *
	 * @var array
	 */	
	var $controlsHTMLMap = array();
	/**
	 * Array of controls map
	 *
	 * @var array
	 */	
	var $controlsMap = array();
	/**
	 * Array of field settings for use it in javascript settings
	 *
	 * @var array
	 */	
	var $settingsMap = array();
	/**
	 * Is add page show as inlineAdd or not
	 *
	 * @var array
	 */
	var $pageAddLikeInline = false;
	/**
	 * Is edit page show as inlineEdit or not
	 *
	 * @var array
	 */ 
	var $pageEditLikeInline = false;
	/**
	 * Array of tabs and sections for add page
	 *
	 * @var array
	 */	
	var $arrAddTabs = array();
	/**
	 * Use Tabs and Setctions on add page or not
	 *
	 * @var boolean
	 */
	var $useTabsOnAdd = false;
	/**
	 * Array of tabs and sections for edit page
	 *
	 * @var array
	 */	
	var $arrEditTabs = array();
	/**
	 * Use Tabs and Setctions on edit page or not
	 *
	 * @var boolean
	 */
	var $useTabsOnEdit = false;
	/**
	 * Array of tabs and sections for edit page
	 *
	 * @var array
	 */	
	var $arrViewTabs = array();
	/**
	 * Use Tabs and Setctions on edit page or not
	 *
	 * @var boolean
	 */
	var $useTabsOnView = false;
	/**
	 * Array of records per page for list and report without group fields
	 *
	 * @var array
	 */	
	var $arrRecsPerPage = array();
	/**
	 * Array of groups per page for report with group fields
	 *
	 * @var array
	 */	
	var $arrGroupsPerPage = array();
	/**
	 * Use group fields on report page or not
	 *
	 * @var boolean
	 */
	var $reportGroupFields = false;
	/**
	 * Number of page size
	 *
	 * @var integer
	 */
	var $pageSize = 0;
	/**
	 * Type of table - list, report or chart
	 *
	 * @var string
	 */
	var $isTableType = "";
	/**
	 * Events object for the current table
	 *
	 * @var object
	 */	
	var $eventsObject;
	/**
	 * Detail keys by master table
	 *
	 * @var array
	 */
	var $detailKeysByM = array();
	/**
	 * Is captcha ok after submit or not
	 *
	 * @var boolean
	 */
	var $isCaptchaOk = true;
	/**
	 * Captcha ID
	 *
	 * @var string
	 */
	var $captchaId = "";
	/**
	 * Locking object
	 *
	 * @var object
	 */
	var $lockingObj = null;
	/**
	 * Is use Video player or not
	 *
	 * @var boolean
	 */
	var $isUseVideo = false;
	/**
	 * Is use Audio player or not
	 *
	 * @var boolean
	 */
	var $isUseAudio = false;
	/**
	 * Is show add page like popUp or not
	 *
	 * @var boolean
	 */
	var $showAddInPopup = false;
	/**
	 * Is show edit page like popUp or not
	 *
	 * @var boolean
	 */
	var $showEditInPopup = false;
	/**
	 * Is show view page like popUp or not
	 *
	 * @var boolean
	 */
	var $showViewInPopup = false;
	/**
	 * Is columns will be resizable or not
	 *
	 * @var boolean
	 */
	var $isResizeColumns = false;
	/**
	 * Is use CKeditor or not
	 *
	 * @var boolean
	 */
	var $isUseCK = false;
	/**
	 * Is display detail data on page or not
	 *
	 * @var boolean
	 */
	var $isShowDetailTables = false;
	/**
	*	arrays of files to process after adding or editing a record
	*/
    var $filesToSave = array();
	var $filesToMove = array();
	var $filesToDelete = array();
	/**
	 * Master keys by detail table
	 *
	 * @var array
	 */
	var $masterKeysByD = array();
	/**
	 * Indicator is permissions dynamic
	 *
	 * @var bool
	 */
	var $isDynamicPerm = false;
	/**
	 * If nedd add web report or not
	 *
	 * @var bool
	 */
	var $isAddWebRep = true;
	/**
	 * Indicator, is used section 508 
	 *
	 * @var bool
	 */
	var $is508 = false;	
	
	/**
	 * Number of rows
	 *
	 * @var integer
	 */
	var $numRowsFromSQL = 0;	
	/**
	 * Index of my page
	 *
	 * @var integer
	 */
	var $myPage = 0;
	var $recordsOnPage = 0;
	/**
	 * Number of records per row list
	 *
	 * @var integer
	 */
	var $recsPerRowList = 0;
	var $colsOnPage = 1;
	/**
	 * Number of founed rows
	 *
	 * @var bool
	 */
	var $rowsFound = false;
	
	/**
	  * Constructor, set initial params
	  *
	  * @param array $params
	  */
	var $deleteMessage = '';
	/**
	 * Number of maximum pages
	 *
	 * @var integer
	 */
	var $maxPages = 1;
	/**
	 * Name of the templete file
	 *
	 * @var string
	 */
	var $templatefile = "";
	/**
	 * Array of menu nodes
	 *
	 * @var array
	 */	
	var $menuNodes = array();

	function RunnerPage(&$params)
	{
		global $locale_info, $cCharset, $page_layouts;
		
		// copy properties to object
		RunnerApply($this, $params);
		
		//set google map configuration
		$this->googleMapCfg = array('markerAsLinkToView'=>true, 'isUseMainMaps'=>false, 'isUseFieldsMaps'=> false, 'isUseGoogleMap'=>false, 'APIcode'=>GetGlobalData("apiGoogleMapsCode",""), 'mainMapIds'=>array(), 'fieldMapsIds'=>array(), 'mapsData'=>array());
		
				$this->debugJSMode = false;
		
		if($this->flyId < $this->id+1)
			$this->flyId = $this->id+1;
		
		// get permissions 
		if ($this->tName)
		{
			$this->permis[$this->tName]= $this->getPermissions();
			$this->eventsObject = &getEventObject($this->tName);
		}
		
		if(!$this->sessionPrefix)
			$this->sessionPrefix = $this->tName;
		
		$this->setSessionVariables();
		
		//	get locking object
		$this->lockingObj = GetLockingObject($this->tName);
		$this->is508 = isEnableSection508();
		
		$this->isUseVideo = GetTableData($this->tName, ".isUseVideo", false);
		$this->isUseAudio = GetTableData($this->tName, ".isUseAudio", false);
		$this->strCaption = GetTableCaption(GoodFieldName($this->tName));
		$this->isTableType = GetTableData($this->tName,".isTableType","");
		$this->isAddWebRep = GetGlobalData("isAddWebRep",false);
		//	get details keys by master table
		$this->detailKeysByM = GetDetailKeysByMasterTable($this->masterTable, $this->tName);
		$this->isDynamicPerm = GetGlobalData("isDynamicPerm",false);
		$this->shortTableName = GetTableData($this->tName, ".shortTableName",'');
		$this->showAddInPopup = GetTableData($this->tName, ".showAddInPopup", false);
		$this->showEditInPopup = GetTableData($this->tName, ".showEditInPopup", false);
		$this->showViewInPopup = GetTableData($this->tName, ".showViewInPopup", false);
		$this->isResizeColumns = GetTableData($this->tName,".isResizeColumns",false);
		$this->isUseAjaxSuggest = GetTableData($this->tName, ".isUseAjaxSuggest", false);
		$this->useDetailsPreview = GetTableData($this->tName,".useDetailsPreview",false);
		$this->isShowDetailTables = displayDetailsOn($this->tName,$this->pageType);
		//	get all details table for current table
		$this->allDetailsTablesArr = GetDetailTablesArr($this->tName);
		
		//	set template file
		$this->setTemplateFile();
		
		//	init jsSettings
		$this->jsSettings["tableSettings"][$this->tName] = array();
		$this->jsSettings["tableSettings"][$this->tName]['fieldSettings'] = array();
		
		$this->settingsMap["globalSettings"] = array();
		$this->settingsMap["globalSettings"]["ext"] = "php";
		$this->settingsMap["globalSettings"]["charSet"] = $cCharset;
		$this->settingsMap["globalSettings"]["debugMode"] = $this->debugJSMode;
		$this->settingsMap["globalSettings"]["googleMapsApiCode"] = $this->googleMapCfg['APIcode'];
		$this->settingsMap["globalSettings"]["shortTNames"][$this->tName] = $this->shortTableName;
		
		//isMobile 
		$this->settingsMap["globalSettings"]["isMobile"] = isMobile();
		
		// s508 must be in global settings
		$this->settingsMap['globalSettings']['s508'] = $this->is508;
		
		$this->settingsMap["globalSettings"]["locale"]["dateFormat"] = $locale_info["LOCALE_IDATE"];
		$this->settingsMap["globalSettings"]["locale"]["startWeekDay"] = $locale_info["LOCALE_IFIRSTDAYOFWEEK"];
		$this->settingsMap["globalSettings"]["locale"]["dateDelimiter"] = $locale_info["LOCALE_SDATE"];
		
		$this->settingsMap["tableSettings"] = array();
		$this->settingsMap["tableSettings"]["useIbox"] = array("default"=>false,"jsName"=>"isUseIbox");
		$this->settingsMap['tableSettings']['hasEvents'] = array("default"=>false,"jsName"=>"hasEvents");
		$this->settingsMap["tableSettings"]["listIcons"] = array("default"=>false,"jsName"=>"listIcons");
		$this->settingsMap["tableSettings"]["strCaption"] = array("default"=>"","jsName"=>"strCaption");
		$this->settingsMap["tableSettings"]["isUseAudio"] = array("default"=>false,"jsName"=>"isUseAudio");
		$this->settingsMap["tableSettings"]["isUseVideo"] = array("default"=>false,"jsName"=>"isUseVideo");
		$this->settingsMap['tableSettings']['isVerLayout'] = array("default"=>false,"jsName"=>"isVertLayout");
		$this->settingsMap["tableSettings"]["rowHighlite"] = array("default"=>false,"jsName"=>"isUseHighlite");
		$this->settingsMap["tableSettings"]["isUseToolTips"] = array("default"=>false,"jsName"=>"isUseToolTips");
		$this->settingsMap['tableSettings']['recsPerRowList'] = array("default"=>1,"jsName"=>"recsPerRowList");
		$this->settingsMap["tableSettings"]["showAddInPopup"] = array("default"=>false, "jsName"=>"showAddInPopup");
		$this->settingsMap["tableSettings"]["showEditInPopup"] = array("default"=>false,"jsName"=>"showEditInPopup");
		$this->settingsMap["tableSettings"]["showViewInPopup"] = array("default"=>false,"jsName"=>"showViewInPopup");
		$this->settingsMap["tableSettings"]["isResizeColumns"] = array("default"=>false,"jsName"=>"isUseResize");
		$this->settingsMap["tableSettings"]["isUseAjaxSuggest"] = array("default"=>true,"jsName"=>"ajaxSuggest");
		$this->settingsMap["tableSettings"]["useDetailsPreview"] = array("default"=>false,"jsName"=>"isUseDP");
		$this->settingsMap['tableSettings']['isUsebuttonHandlers'] = array("default"=>false,"jsName"=>"isUseButtons");
		
		if ($this->pageType == PAGE_REGISTER || $this->pageType == PAGE_CHANGEPASS)
			$layout = GetPageLayout('', $this->pageType);
		else 
			$layout = GetPageLayout($this->shortTableName, $this->pageType);
		if($layout)
		{
			$rtl = $this->xt->getReadingOrder() == 'RTL' ? 'RTL' : '';
			$this->jsSettings['tableSettings'][$this->tName]['pageCSS'] = "styles/".$layout->style.'/style'.$rtl;
			$this->jsSettings['tableSettings'][$this->tName]['pageLayout'] = "pagestyles/".$layout->name.$rtl;
			$this->jsSettings['tableSettings'][$this->tName]['pageSkinStyle'] = $layout->style." page-".$layout->name;
		}
		
		$this->settingsMap["fieldSettings"]["UseTimestamp"] = array("default"=>false,"jsName"=>"isUseTimeStamp");
		$this->settingsMap["fieldSettings"]["strName"] = array("default"=>"","jsName"=>"strName");
		$this->settingsMap["fieldSettings"]["ShowTime"] = array("default"=>false,"jsName"=>"showTime");
		$this->settingsMap["fieldSettings"]["EditFormat"] = array("default"=>"","jsName"=>"editFormat");
		$this->settingsMap["fieldSettings"]["DateEditType"] = array("default"=>EDIT_DATE_SIMPLE,"jsName"=>"dateEditType");
		$this->settingsMap["fieldSettings"]["RTEType"] = array("default"=>"","jsName"=>"RTEType");
		$this->settingsMap["fieldSettings"]["ViewFormat"] = array("default"=>"","jsName"=>"viewFormat");
		$this->settingsMap["fieldSettings"]["validateAs"] = array("default"=>null,"jsName"=>"validation");
		$this->settingsMap["fieldSettings"]["LastYearFactor"] = array("default"=>10,"jsName"=>"lastYear");
		$this->settingsMap["fieldSettings"]["InitialYearFactor"] = array("default"=>100,"jsName"=>"initialYear");
		
		$this->jsSettings["tableSettings"][$this->tName]["strCaption"] = $this->strCaption;
		$this->jsSettings["tableSettings"][$this->tName]["pageMode"] = $this->mode;
		
		if ($this->listAjax)
			$this->jsSettings['tableSettings'][$this->tName]['pageMode'] = LIST_AJAX;
		
		if($this->lockingObj)
			$this->jsSettings['tableSettings'][$this->tName]['locking'] = true;
		
		//If current table has detail tables
		if(count($this->allDetailsTablesArr))
		{
			if($this->pageType==PAGE_LIST)
				$this->jsSettings['tableSettings'][$this->tName]['detailTables'] = array();
			
			$this->jsSettings['tableSettings'][$this->tName]['isShowDetails'] = $this->isShowDetailTables;
			
			for($i = 0; $i < count($this->allDetailsTablesArr); $i ++) 
			{
				$this->settingsMap["globalSettings"]['shortTNames'][$this->allDetailsTablesArr[$i]['dDataSourceTable']] = $this->allDetailsTablesArr[$i]['dShortTable'];
				if($this->pageType==PAGE_LIST){
					$this->jsSettings['tableSettings'][$this->tName]['detailTables'][$this->allDetailsTablesArr[$i]['dDataSourceTable']] = 
						array(
							'dispChildCount' => $this->allDetailsTablesArr[$i]['dispChildCount'], 
							'hideChild' => $this->allDetailsTablesArr[$i]['hideChild'],
							'listShowType'=>$this->allDetailsTablesArr[$i]['previewOnList'],
							'addShowType'=>$this->allDetailsTablesArr[$i]['previewOnAdd'],
							'editShowType'=>$this->allDetailsTablesArr[$i]['previewOnEdit'],
							'viewShowType'=>$this->allDetailsTablesArr[$i]['previewOnView']				  
						);
					if($this->allDetailsTablesArr[$i]['previewOnList'] == DP_POPUP)
						$this->jsSettings['tableSettings'][$this->tName]['isUsePopUp'] = true;
					// field names of master keys of current table for passed details table name
					$this->masterKeysByD[$i] = GetMasterKeysByDetailTable($this->allDetailsTablesArr[$i]['dDataSourceTable'], $this->tName);		
				}
			}
			
			if(($this->pageType==PAGE_ADD || $this->pageType==PAGE_EDIT) && $this->isShowDetailTables)
				$this->controlsMap["dControlsMap"] = array();
		}
		$this->controlsMap["video"] = array();
		$this->controlsMap['toolTips'] = array();
		$this->addLookupSettings();
		
		if($this->mode!=LIST_DETAILS)
		{
			$this->controlsMap["controls"] = array();
			if(!$this->pageAddLikeInline && !$this->pageEditLikeInline)
			{
				$this->controlsMap["search"] = array();
				$this->controlsMap["search"]["searchBlocks"] = array();
				$this->controlsMap["search"]["panelSearchFields"] = GetTableData($this->tName,".panelSearchFields",array());
				$this->controlsMap["search"]["allSearchFields"] = GetTableData($this->tName, '.allSearchFields', array());
					
				if($this->pageType!=PAGE_SEARCH)
					$this->controlsMap["search"]["submitPageType"] = $this->pageType;
				else
				{
					if(postvalue("rname")){
						$this->controlsMap["search"]["submitPageType"] = "dreport";
						$this->controlsMap["search"]["baseParams"]["rname"] = postvalue("rname");
						if($_SESSION["crossLink"])
						{
							if(substr($_SESSION["crossLink"],0,1)=="&")
								$_SESSION["crossLink"]=substr($_SESSION["crossLink"],1);
							$alink=explode("&",$_SESSION["crossLink"]);
							foreach($alink as $param)
							{
								$arrtmp=explode("=",$param);
								$this->controlsMap["search"]["baseParams"][$arrtmp[0]] = $arrtmp[1];
							}
						}
					}elseif(postvalue("cname")){
						$this->controlsMap["search"]["submitPageType"] = "dchart";
						$this->controlsMap["search"]["baseParams"]["cname"] = postvalue("cname");
					}else{
						$this->controlsMap["search"]["submitPageType"] = $this->isTableType;
					}
				}
			}
		}
		
		$this->calendar = $this->calendar || GetTableData($this->tName, ".isUseCalendarForSearch", false);	
		$this->timepicker = $this->timepicker || GetTableData($this->tName, ".isUseTimeForSearch", false);
		$this->isUseToolTips = $this->isUseToolTips || GetTableData($this->tName, ".isUseToolTips", false); 
		
		$this->googleMapCfg["APIcode"] = "";
		if($this->xt)
			$this->xt->assign("pagetitle", $this->getPageTitle());
	}	
	/**
	 * Set template file if it empty
	 */
	function setTemplateFile()
	{
		if(!$this->templatefile)
		{
			$this->templatefile	= $this->shortTableName."_".$this->pageType.".htm";
		}
		$this->xt->set_template($this->templatefile);
	}
	/**
	 * Get menu nodes if use menu on page
	 */	
	function getMenuNodes()
	{
		if(!count($this->menuNodes))
		{
			global $menuNodesObject;
			$menuNodesObject = &$this;
			require(getabspath("include/menunodes.php"));
		}
	}
	/**
	 * Check is use menu on page
	 */
	function isUseMenu()
	{
		$menuBricks = array('vmenu', 'vmenu_mobile', 'hmenu', 'quickjump');
		if($this->xt->isExistBricks($menuBricks))
		{
			return true;
		}
		return false;
	}
	
	/**
	 * Check is need to show menu
	 */
	function isShowMenu()
	{
		if(!$this->isUseMenu() && $this->pageType!=PAGE_MENU)
			return false;
			
		$this->getMenuNodes();
		$allowedMenuItems = 0;
		for($i=0;$i<count($this->menuNodes);$i++)
		{
			if($this->menuNodes[$i]["linkType"] == "Internal")
			{
				if($this->isUserHaveTablePerm($this->menuNodes[$i]["table"], $this->menuNodes[$i]["pageType"]))
					$allowedMenuItems++;
			}
		}
		if($this->isDynamicPerm && IsAdmin()) 
			$allowedMenuItems++;
		if($this->isAddWebRep) 
			$allowedMenuItems++;
		if($allowedMenuItems > 1)
			return true;
		return false;
	}
	
	/**
	 * Check if user have permission for link
	 * @param {string} table name
	 * @param {string} page type
	 * @return {boolean}
	 */
	function isUserHaveTablePerm($tName, $pageType)
	{
		if($pageType == "WebReports")
			return true;
		if(!strlen($tName))
			return false;
		$type = $this->getPermisType($pageType);
		$strPerm = GetUserPermissions($tName);	
		if(strpos($strPerm,$type)!==false)
			return true;
		else
			return false;
	}
	/**
	 * Get type of permission
	 * @return {string}
	 */
	function getPermisType($pageType)
	{
		$type = '';
		if ($pageType == "List" || $pageType == "Search" || $pageType == "Report" || $pageType == "Chart")
			$type = "S";
		elseif ($pageType == "Add")
			$type = "A";
		elseif ($pageType == "Edit")
			$type = "E";
		elseif ($pageType == "Print")
			$type = "P";
		return $type;
	}
	
	/**
	 * Get redirect location for menu page
	 * @return {string}
	 */
	function getRedirectForMenuPage() 
	{
		if($this->isShowMenu())
			return '';
		
		$redirect = '';
		for($i=0;$i<count($this->menuNodes);$i++)
		{
			if($this->menuNodes[$i]["linkType"] == "Internal")
			{
				if($this->isUserHaveTablePerm($this->menuNodes[$i]["table"], $this->menuNodes[$i]["pageType"]))
				{	
					$type = $this->getPermisType($this->menuNodes[$i]['pageType']);
					if($type == "A")
						$redirect = "add";
					elseif($this->menuNodes[$i]["pageType"] == "List" && $type == "S")
						$redirect = "list";
					elseif($this->menuNodes[$i]["pageType"] == "Report" && $type == "S")
						$redirect = "report";
					elseif($this->menuNodes[$i]["pageType"] == "Chart" && $type == "S")
						$redirect = "chart";	
					$redirect = GetTableURL($this->menuNodes[$i]["table"]).'_'.$redirect.".php";	
				}	
			}
		}
		if($this->isDynamicPerm && IsAdmin()) 
			$redirect = "admin_rights_list.php";
			
		if($this->isAddWebRep) 
			$redirect = "webreport.php";
		
		return $redirect;
	}
	
	function getPageTitle()
	{
		switch($this->pageType)
		{
			case PAGE_MENU:
				return "";
			case PAGE_LOGIN:
				return "Conectar";
			case PAGE_REGISTER:
				return "Registrar";
			case PAGE_REMIND:
				return "Recordador de contrase�a";
			case PAGE_CHANGEPASS:
				return "Cambiar contrase�a";
			case PAGE_SEARCH:
				return $this->strCaption.': '."B�squeda avanzada";
			case PAGE_EXPORT:
				return "Exportar";
			case PAGE_IMPORT:
				return "Importar";
			default:
				return $this->strCaption;
		}
	}
	/**
	 * Clear session kyes
	 */
	function clearSessionKeys() 
	{
		if($this->pageType == PAGE_LIST && !count($_POST) && (!count($_GET) || count($_GET) == 1 && isset($_GET["menuItemId"]) || isset($_GET["mastertable"]))) 
		{
			$sess_unset = array();
			foreach($_SESSION as $key => $value)
				if(substr($key, 0, strlen($this->tName) + 1) == $this->tName."_" && strpos(substr($key, strlen($this->tName) + 1), "_") === false)
					$sess_unset[]= $key;
			
			foreach($sess_unset as $key)
				unset($_SESSION[$key]);
		}
	}
	/**
	 * Set session variables
	 */	
	function setSessionVariables() 
	{
		//clear session keys
		$this->clearSessionKeys();
		
		// Process master table value
		if($this->masterTable!="")
			$_SESSION[$this->sessionPrefix."_mastertable"] = $this->masterTable;
		else
			$this->masterTable = $_SESSION[$this->sessionPrefix."_mastertable"];
			
		// SearchClause class stuff
		$allSearchFields = GetTableData($this->tName, '.allSearchFields', array());
		if($this->needSearchClauseObj && !$this->searchClauseObj)
		{
			if (isset($_SESSION[$this->sessionPrefix.'_advsearch']))
				$this->searchClauseObj = unserialize($_SESSION[$this->sessionPrefix.'_advsearch']);
			else{
				$params = array();
				$params['tName'] = $this->tName;
				$params['searchFieldsArr'] = $allSearchFields;
				$params['sessionPrefix'] = $this->sessionPrefix;
				$params['panelSearchFields'] = GetTableData($this->tName,".panelSearchFields",array());
				$params['googleLikeFields'] = GetTableData($this->tName,".googleLikeFields",array());
				$this->searchClauseObj = new SearchClause($params);
			}
		}
		
		//set session page size
		if(@$_REQUEST["pagesize"]) 
		{
			$_SESSION[$this->sessionPrefix."_pagesize"] = @$_REQUEST["pagesize"];
			$_SESSION[$this->sessionPrefix."_pagenumber"] = 1;
		}
		//set page size
		$this->pageSize = (integer) $_SESSION[$this->sessionPrefix."_pagesize"];
	}
	/**
	 * Add lookup settings to settings map
	 * Use on list and add pages
	 */
	function addLookupSettings()
	{
		$this->settingsMap["fieldSettings"]["CategoryControl"] = array("default"=>"","jsName"=>"categoryField");
		$this->settingsMap["fieldSettings"]["DependentLookups"] = array("default"=>array(),"jsName"=>"depLookups");
		$this->settingsMap["fieldSettings"]["LCType"] = array("default"=>LCT_DROPDOWN,"jsName"=>"lcType");
		$this->settingsMap["fieldSettings"]["LookupTable"] = array("default"=>"","jsName"=>"lookupTable");
		$this->settingsMap["fieldSettings"]["SelectSize"] = array("default"=>1,"jsName"=>"selectSize");
		$this->settingsMap["fieldSettings"]["LinkField"] = array("default"=>"","jsName"=>"linkField");
		$this->settingsMap["fieldSettings"]["DisplayField"] = array("default"=>"","jsName"=>"dispField");
		$this->settingsMap["fieldSettings"]["freeInput"] = array("default"=>false,"jsName"=>"freeInput");
		$this->settingsMap["fieldSettings"]["autoCompleteFieldsAdd"] = array("default"=>array(),"jsName"=>"autoCompleteFieldsAdd");
		$this->settingsMap["fieldSettings"]["autoCompleteFieldsEdit"] = array("default"=>array(),"jsName"=>"autoCompleteFieldsEdit");
	}
	
	/**
	 * Fill global settings
	 */
	function fillGlobalSettings()
	{
		$this->jsSettings["global"] = array();
		foreach($this->settingsMap["globalSettings"] as $key => $val)
			$this->jsSettings["global"][$key] = $val;
		// start augment id from this value	
		$this->jsSettings["global"]['idStartFrom'] = $this->flyId;	
	}
	
	/**
	 * Fill table settings
	 */
	function fillTableSettings() 
	{
		foreach($this->settingsMap["tableSettings"] as $key => $val)
		{
			if($key!="useIbox" && $this->pageType!=PAGE_SEARCH || $key=="useIbox" && $this->pageType!=PAGE_SEARCH || $this->pageType==PAGE_SEARCH && $key!="useIbox")
			{
				$tData = GetTableData($this->tName,".".$key,$val['default']);
				
				$isDefault = false;
				if(is_array($tData))
					$isDefault = !count($tData);
				else if(!is_array($val['default']))
					$isDefault = ($tData == $val['default']);
				
				if(!$isDefault)
					$this->jsSettings['tableSettings'][$this->tName][$val['jsName']] = $tData;
			}		
		}	
	}
		
	/**
	 * Fill field settings for current table 
	 */
	function fillFieldSettings()
	{
//		$arrFields = $this->getFieldsByPageType();
		$arrFields = GetFieldsList($this->tName);
		foreach($arrFields as $fName)
		{
			if(!array_key_exists($fName,$this->jsSettings['tableSettings'][$this->tName]['fieldSettings']))
				$this->jsSettings['tableSettings'][$this->tName]['fieldSettings'][$fName] = array();
			
			$matchDK = false;	
			if($this->matchWithDetailKeys($fName))
				$matchDK = true;
				
			foreach($this->settingsMap["fieldSettings"] as $key => $val)
			{
				$fData = GetFieldData($this->tName,$fName,$key,$val['default']);
				
				if($key != "validateAs")
				{
					if($key == "EditFormat")
					{
						if($matchDK)
							$fData = EDIT_FORMAT_READONLY;
					}
					elseif($key == "RTEType")
					{
						if(UseRTEBasic($fName))
							$fData = "RTE";
						elseif(UseRTEFCK($fName)){
							$fData = "RTECK";
							if(!$this->isUseCK)
								$this->isUseCK = true;
							$this->jsSettings['tableSettings'][$this->tName]['fieldSettings'][$fName]['nWidth'] = GetNCols($fName);
							$this->jsSettings['tableSettings'][$this->tName]['fieldSettings'][$fName]['nHeight'] = GetNRows($fName);		
						}	
						elseif(UseRTEInnova($fName))
							$fData = "RTEINNOVA";	
					}
					elseif($key == "autoCompleteFieldsAdd")
					{
						$fData = GetFieldData($this->tName,$fName,"autoCompleteFields",$val['default']);
					}
					elseif($key == "autoCompleteFieldsEdit")
					{
						if(GetFieldData($this->tName, $fName, 'autoCompleteFieldsOnEdit', false))
							$fData = GetFieldData($this->tName,$fName,"autoCompleteFields",$val['default']);
						else
							$fData = array();
					}
					
					$isDefault = false;
					if(is_array($fData))
						$isDefault = !count($fData);
					else if(!is_array($val['default']))
						$isDefault = ($fData === $val['default']);
									
					if(!$isDefault && !$matchDK)
						$this->jsSettings['tableSettings'][$this->tName]['fieldSettings'][$fName][$val['jsName']] = $fData;
					else if($matchDK && ($key == "EditFormat" || $key == "strName"))						
						$this->jsSettings['tableSettings'][$this->tName]['fieldSettings'][$fName][$val['jsName']] = $fData;
				}
				elseif(!$matchDK)
					$this->fillValidation($fData,$val,$this->jsSettings['tableSettings'][$this->tName]['fieldSettings'][$fName]);
			}
			
			$this->jsSettings['tableSettings'][$this->tName]['isUseCK'] = $this->isUseCK;
			
			if (!empty($this->googleMapCfg) and $this->googleMapCfg['isUseGoogleMap']){
				$this->jsSettings['tableSettings'][$this->tName]['isUseGoogleMap'] = true;
				$this->jsSettings['tableSettings'][$this->tName]['googleMapCfg']=$this->googleMapCfg;	
			}
	
			if(GetLookupTable($fName, $this->tName))
				$this->jsSettings['global']['shortTNames'][GetLookupTable($fName, $this->tName)] = GetTableURL(GetLookupTable($fName, $this->tName));
				
			if(GetEditFormat($fName)=='Time')
				$this->fillTimePickSettings($fName);
		}
		
		if($this->pageType==PAGE_REGISTER)
			$this->addConfirmToFieldSettings();
	}
	/**
	 * Match field with details keys
	 * return boolean true or false
	 */
	function matchWithDetailKeys($fName)
	{
		$match = false;
		if($this->detailKeysByM)
		{
			for($j=0;$j<count($this->detailKeysByM);$j++)
			{
				if($this->detailKeysByM[$j]==$fName)
				{
					$match=true;
					break;
				}
			}
		}
		return $match;
	}		
	/**
	 * Fill preload array for js settings
	 * Use on Add, Edit, Register pages and for search fields only
	 *
	 * @param string $fName - field name
	 * @param string $fval - value of field
	 * @return false or array of preload data
	 */
	function fillPreload($fName,$value)
	{
		$preload = false;
		if(!$this->matchWithDetailKeys($fName) && UseCategory($fName, $this->tName))
		{
			if($this->pageType == PAGE_ADD || $this->pageType == PAGE_EDIT || $this->pageType == PAGE_REGISTER)
				$preload = $this->getPreloadArr($fName, $value);
			else
				$preload = $this->getSearchPreloadArr($fName, $value);
		}
		return $preload;
	}
	
	function hasDependField($fName)
	{
		if((GetEditFormat($fName) != EDIT_FORMAT_LOOKUP_WIZARD || GetEditFormat($fName) != EDIT_FORMAT_RADIO) && !UseCategory($fName))
			return false;
		
		return CategoryControl($fName,$this->tName);	
	}
	/**
	 * Return JS for preload dependent ctrl 
	 *
	 * @param string $fName - field name
	 * @param string $fval - value of field
	 * @return array
	 */
	function getPreloadArr($fName,$value)
	{
		// category control field
		$strCategoryControl = $this->hasDependField($fName);
		
		if($strCategoryControl === false)
			return false;
		
		// Is field appear or not
		$fieldAppear=true;
		if($this->pageType == PAGE_ADD)
		{
			if(!AppearOnInlineAdd($fName))
				$fieldAppear=($this->mode!=ADD_INLINE);
			elseif(!AppearOnAddPage($fName))
				$fieldAppear=($this->mode==ADD_INLINE);
			
			// Is category control appear or not
			if($this->mode==ADD_INLINE)
			{
				if(AppearOnInlineAdd($strCategoryControl))
					$categoryFieldAppear=true;
				else
					$categoryFieldAppear=false;
			}
			else{
					if(AppearOnAddPage($strCategoryControl))
						$categoryFieldAppear=true;
					else
						$categoryFieldAppear=false;
				}	
		}	
		elseif($this->pageType == PAGE_EDIT)
		{
			if(!AppearOnInlineEdit($fName))
				$fieldAppear=($this->mode!=EDIT_INLINE);
			elseif(!AppearOnEditPage($fName))
				$fieldAppear=($this->mode==EDIT_INLINE);
			$categoryFieldAppear=true;	
		}
		else{
				if($strCategoryControl)
					$categoryFieldAppear=true;
				else
					$categoryFieldAppear=false;
			}
		
		if(!$fieldAppear)
			return false;
			
		if (GetFieldData($this->tName, $fName, 'freeInput', false)){
			$output = array(0=>@$value[$fName], 1=>@$value[$fName]);
		}else{
			$output = loadSelectContent($fName,@$value[$strCategoryControl],$categoryFieldAppear,@$value[$fName]);
		}
			
		
		$valF = "";
		if(count($value))
			$valF = $value[$fName];
		if($this->pageType==PAGE_EDIT)
		{	
			if(SelectSize($fName) == 1 && LookupControlType($fName)!=LCT_CBLIST)
				$fVal = $valF;
			else
				$fVal = splitvalues($valF);
		}
		else
			$fVal = $valF;
		
		return array('vals'=> $output, "fVal"=>$fVal);
	}	
	
	/**
	 * Common assign for diferent mode on list page
	 * Branch classes add to this method its individualy code
	 */
	function commonAssign() 
	{
		$this->xt->displayBrickHidden("searchpanel");
		if (isMobile())
		{
			$this->xt->displayBrickHidden("vmenu");
			$this->xt->displayBrickHidden("backbutton");
			$this->xt->displayBrickHidden("search");
			$this->xt->displayBrickHidden("fulltext_mobile");
		}
	}
	
	/**
	 * Return name of parent field
	 *
	 * @param string $fName
	 * @return string
	 */
	function getParentCtrlName($fName) {
		return CategoryControl($fName, $this->tName); 
	}
	
	/**
	 * Return parent value for dependent ctrl
	 * Used value of first parent field
	 *
	 * @param string $fName
	 * @return string
	 */
	function getParentVal($fName)
	{		
		$categoryFieldParams = $this->searchClauseObj->getSearchCtrlParams($this->getParentCtrlName($fName));
		if (count($categoryFieldParams))
			return $categoryFieldParams[0]['value1'];
		else
			return false;	
	}
	
	/**
	 * Return JS for preload dependent ctrl for search fields
	 *
	 * @param string $fName - field name
	 * @param string $fval - value of field
	 * @return array
	 */
	function getSearchPreloadArr($fName, $fval)
	{
		// if no parent in project settings
		if (GetEditFormat($fName) != EDIT_FORMAT_LOOKUP_WIZARD && !UseCategory($fName, $this->tName))
			return false;
		
		// if parent exist in settings
		$parentFieldName = CategoryControl($fName, $this->tName);
		$parentVal = $this->getParentVal($fName);
		$doFilter = true;
		// if no filter f parent doesn't exist or it's value is empty
		if ($parentVal===false || $parentVal==='')
			$doFilter = false;
			
		$output = loadSelectContent($fName, $parentVal, $doFilter, $fval[$fName]);

		return array('vals'=> $output, "fVal"=>$fval[$fName]);	
	}
	
	/**
	 * Add confirm field to field settings
	 * Use for register page only
	 */	
	function addConfirmToFieldSettings()
	{
		$arrSetVals = array();
		$arrSetVals['strName'] = 'confirm';
		$arrSetVals['EditFormat'] = 'Password';
		$arrSetVals['validation']['validationArr'][] = 'IsRequired';
		$this->jsSettings['tableSettings'][$this->tName]['fieldSettings']['confirm'] = $arrSetVals;
	}
	
	/**
	 * Add captcha field to field settings
	 * Use for register page only
	 */	
	function addCaptchaToFieldSettings()
	{
		$arrSetVals = array();
		$arrSetVals['strName'] = 'captcha';
		$arrSetVals['EditFormat'] = 'Text Field';
		$arrSetVals['validation']['validationArr'][] = 'IsRequired';
		$this->jsSettings['tableSettings'][$this->tName]['fieldSettings']['captcha'] = $arrSetVals;
	}

	/**
	 * Fill validation for current field
	 */
	function fillValidation($fData,$val,&$arrSetVals)
	{
		if(count($fData))
		{
			$arrSetVals[$val['jsName']]["validationArr"] = $fData['basicValidate'];
			if(array_key_exists("regExp",$fData))
				$arrSetVals[$val['jsName']]["regExp"] = $fData["regExp"];
		}
	}
	
	/**
	 * Get array of fields by current page type
	 * return array - of fields
	 */
	function getFieldsByPageType()
	{
		$useInline = false;
		if($this->pageType == PAGE_EDIT)
		{
			if($this->pageEditLikeInline)
			{
				$useInline = true;
				$allfields = GetTableData($this->tName, ".inlineEditFields", array());
			}else	
				$allfields = GetTableData($this->tName, ".editFields", array());
		}
		else if($this->pageType == PAGE_ADD)
		{
			if($this->pageAddLikeInline)
			{	
				$useInline = true;
				$allfields = GetTableData($this->tName, ".inlineAddFields", array());
			}else
				$allfields = GetTableData($this->tName, ".addFields", array());
		}
		else if($this->pageType == PAGE_LIST)
		{
			$allfields = GetTableData($this->tName, ".listFields", array());
		}
		else
			$allfields = GetFieldsList($this->tName);
		$arrFields = array();
		foreach($allfields as $fName)
		{
			if($useInline)
				$app = AppearOnCurrentPage($fName,$this->pageType,true);
			else
				$app = AppearOnCurrentPage($fName,$this->pageType);
			if($app === 'break')
				break;
			elseif(!$app)
				continue;
			$arrFields[] = $fName;
		}	
		return $arrFields;	
	}
	
	/**
	 * Fill all settings for current table 
	 */
	function fillSettings()
	{
		$this->fillGlobalSettings();
		$this->fillTableSettings();
		$this->fillFieldSettings();	
	}
	
	/**
	 * Fill tool tips for current table fields
	 * @param $fName - filed name
	 */
	function fillFieldToolTips($fName){
		$toolTipText = GetFieldToolTip($this->tName, $fName);
		if (strlen($toolTipText)){ 
			$this->controlsMap['toolTips'][$fName] = $toolTipText;
		}
	}
	
	/**
	 * Fill controls map 
	 * For add, edit, search pages - controls
	 * 
	 * @param $arr - array of settings for one control
	 * @param $addSet - add additional settings to control
	 * @intellisense
	 */		
	function fillControlsMap($arr,$addSet = false,$fName="")
	{
		if(!$addSet)
		{
			foreach($arr as $key=>$val)
				$this->controlsMap[$key][] = $val;
		}
		else{
				foreach($arr as $key=>$val)
				{
					foreach($val as $vkey=>$vval)
					{
						if(!$fName)
							$this->controlsMap[$key][count($this->controlsMap[$key])-1][$vkey] = $vval;
						else{
								for($i=0;$i<count($this->controlsMap[$key]);$i++)
								{
									if($this->controlsMap[$key][$i]['fieldName']==$fName)
									{
										$this->controlsMap[$key][$i][$vkey] = $vval;
										break;
									}	
								}		
							}		
					}	
				}	
			}		
	}
	
	/**
	 * Fill field settings for current table 
	 */	
	function fillControlsHtmlMap()
	{
		$this->controlsHTMLMap[$this->tName] = array();
		$this->controlsHTMLMap[$this->tName][$this->pageType] = array();
		$this->controlsHTMLMap[$this->tName][$this->pageType][$this->id] = array();
		
		$this->controlsMap['gMaps'] = $this->googleMapCfg;
		if($this->searchClauseObj)
			$this->controlsMap["search"]["usedSrch"] = $this->searchClauseObj->isUsedSrch();
			
		foreach($this->controlsMap as $key=>$val)
			$this->controlsHTMLMap[$this->tName][$this->pageType][$this->id][$key] = $val;
	}
	
	/**
	 * Fill jsSettings and controlsHTMLMap arrays for current table 
	 */	
	function fillSetCntrlMaps()
	{
		$this->fillSettings();
		$this->fillControlsHTMLMap();
	}
	
	
	/**
	 * Fill arrays of names tab group and section to controlsHTMLMap for current table
	 */		
	function fillCntrlTabGroups()
	{
		$arrTabs = $this->getArrTabs();
		$this->controlsMap['tabs'] = array();
		$this->controlsMap['sections'] = array();
		
		if(!$arrTabs)
			return false;
		
		$beginGroup = false;
		$tabGroupName = "";
		
		for($i=0;$i<count($arrTabs);$i++)
		{
			$tabC = $arrTabs[$i];//current tab
			$tabN = (($i+1)<count($arrTabs) ? $arrTabs[$i+1] : false);//next tab
			if(!$tabC['nType'])
			{
				if(!$beginGroup)
				{
					$beginGroup = true;
					$tabGroupName = $tabC['tabId'];
				}
				
				if($beginGroup)
				{
					if(!$tabN || $tabN['nType'] || $tabN['tabGroup']!=$tabC['tabGroup'])
					{
						//fill array of tabs with name of tab groups
						$tabsAndFields = array();
						for($j=0;$j<count($arrTabs);$j++)
						{
							if($arrTabs[$j]['tabGroup'] == $tabC['tabGroup'])
							{
								$tabsAndFields[$arrTabs[$j]['tabId']] = array();
								for($f=0;$f<count($arrTabs[$j]['arrFields']);$f++)
									$tabsAndFields[$arrTabs[$j]['tabId']][] = $arrTabs[$j]['arrFields'][$f];
							}
						}
						$this->controlsMap['tabs']['tabGroup_'.$tabGroupName] = $tabsAndFields;
						$beginGroup = false;
					}	
				}
			}
			else{
					//fill array of sections with name sections
					$this->controlsMap['sections']['section_'.$tabC['tabId']] = array();
					for($f=0;$f<count($arrTabs[$i]['arrFields']);$f++)
						$this->controlsMap['sections']['section_'.$tabC['tabId']][] = $arrTabs[$i]['arrFields'][$f];
				}
		}	
	}
		
	/**
	 * Check are fields appaer in tabs for current page or not
	 * return boolean
	 */	
	function isAppearOnTabs($fName)
	{
		$match = false;
		$arrTabs = $this->getArrTabs();
		if(!$arrTabs)
			return $match;
		foreach($arrTabs as $tab=>$val){
			if(in_array($fName, $val['arrFields'])){
				$match = true;
				break;
			}
		}
		return $match;	
	}
	/**
	 * Get array of tabs in accordance with page type
	 * return boolean
	 */	
	function getArrTabs()
	{
		if($this->pageType == PAGE_EDIT)	
			return $this->arrEditTabs;
		elseif($this->pageType == PAGE_ADD)	
			return $this->arrAddTabs;
		elseif($this->pageType == PAGE_VIEW)	
			return $this->arrViewTabs;
		else
			return false;
	}
	
	/**
	 * Fill timepicker settings for current field
	 */		
	function fillTimePickSettings($field,$value="")
	{
		$timeAttrs = GetFieldData($this->tName,$field,"FormatTimeAttrs",array());	
		if(count($timeAttrs) && $timeAttrs["useTimePicker"])
		{
			$convention = $timeAttrs["hours"];
			$locAmPm = getLacaleAmPmForTimePicker($convention, true);
			$tpVal = getValForTimePicker(GetFieldType($field),$value,$locAmPm['locale']);
			
			$range = array();
			if($convention==24)
			{
				for($h = 0;$h < $convention;$h ++)
					$range[]= $h;
			}
			else
			{
				for($h = 1;$h <= $convention;$h ++)
					$range[] = $h;
			}
			
			$minutes = array();
			for($m = 0; $m < 60; $m += $timeAttrs["minutes"])
				$minutes[] = $m;
			
			//settings		
			$timePickSet = array('convention'=>$convention,
								 'range'=>$range,		
								 'apm'=>array($locAmPm['am'],$locAmPm['pm']),		
								 'rangeMin'=>$minutes,		
								 'locale'=>$locAmPm['locale'],
								 'showSec'=>$timeAttrs["showSeconds"]);
			
			if(count($tpVal['dbtime'])>0)
				$timePickSet['hover'] = array('0'=>$tpVal['dbtime'][3],'1'=>$tpVal['dbtime'][4],'2'=>$tpVal['dbtime'][5]);
			
			if(!array_key_exists($field,$this->jsSettings['tableSettings'][$this->tName]['fieldSettings']))	
			{
				$this->jsSettings['tableSettings'][$this->tName]['fieldSettings'][$field] = array();
				$this->jsSettings['tableSettings'][$this->tName]['fieldSettings'][$field]['timePick'] = $timePickSet;
			}
			elseif(!array_key_exists("timePick",$this->jsSettings['tableSettings'][$this->tName]['fieldSettings'][$field]))
				$this->jsSettings['tableSettings'][$this->tName]['fieldSettings'][$field]['timePick'] = $timePickSet;
			
			$this->fillControlsMap(array('controls'=>array('open'=>($tpVal['val'] ? true : false))),true,$field);
		}	
	}
		
	/**
	 * Assign body end
	 */	
	function assignBodyEnd(&$params) 
	{
	
		$this->fillSetCntrlMaps();
		echo "<script>
			window.controlsMap = ".my_json_encode($this->controlsHTMLMap).";
			window.settings = ".my_json_encode($this->jsSettings)."; 
			</script>\r\n";
				echo "<script language=\"JavaScript\" src=\"include/runnerJS/RunnerAll.js\"></script>\r\n";
		echo "<script>".$this->PrepareJS()."</script>";
	}
		
	/**
	 * Generates new id, same as flyId on front-end
	 *
	 * @return int
	 */
	function genId()
	{
		$this->flyId++;
		$this->recId = $this->flyId;
		return $this->flyId;
	}
	
	/**
	  * Get page type
	  */
	function getPageType()
	{
		return $this->pageType;
	}

	/**
	  * Add js files for page
	  */	
	function AddJSFileNoExt($file)
	{
		$this->includes_js[]=$file;
	}

	function AddJSFile($file,$req1="",$req2="",$req3="")
	{
		$file.=".js";
		$this->includes_js[] = $file;
		if($req1!="")
			$this->includes_jsreq[$file] = array($req1.".js");
		if($req2!="")
			$this->includes_jsreq[$file][] = $req2.".js";
		if($req3!="")
			$this->includes_jsreq[$file][] = $req3.".js";
	}
	
	/**
	  * Grab all js files
	  */
	function grabAllJsFiles()
	{
		$jsFiles = array();
		foreach($this->includes_js as $file)
		{
			$jsFiles[$file] = array();
			if(array_key_exists($file,$this->includes_jsreq))
				$jsFiles[$file] = $this->includes_jsreq[$file];
		}
		$this->includes_js = array();
		$this->includes_jsreq = array();
		return $jsFiles;
	}
	
	/**
	  * Grab all css files
	  */
	function copyAllJsFiles($jsFiles)
	{
		foreach($jsFiles as $file=>$reqFiles)
		{
			$this->includes_js[] = $file;	
			
			if(array_key_exists($file,$this->includes_jsreq)){	
				foreach($reqFiles as $rFile){
					if(array_key_exists($rFile,$this->includes_jsreq[$file]))
						continue;
					$this->includes_jsreq[$file][] = $rFile;
				}
			}else
				$this->includes_jsreq[$file] = $reqFiles;
		}	
	}
	
	/**
	  * Add css files for page
	  */	
	function AddCSSFile($file)
	{
		$this->includes_css[] = $file;
	}
	
	/**
	  * Add css files (which have an IE extension) for page
	  * 
	  * @param {string} path to css file
	  */	
	function AddCSSIEFile($file)
	{
		$this->includes_cssIE[] = $file;
	}	
	
	/**
	  * Grab all css files
	  */
	function grabAllCssFiles()
	{
		$cssFiles = $this->includes_css;
		$this->includes_css = array();
		return $cssFiles;
	}
	/**
	  * Copy all css files
	  */
	function copyAllCssFiles($cssFiles)
	{
		foreach($cssFiles as $file)
			$this->AddCSSFile($file);
	}
	
	/**
	  * Load js and css files
	  */	
	function LoadJS_CSS()
	{
		
		$this->includes_js = array_unique($this->includes_js);
		$this->includes_css = array_unique($this->includes_css);
		$this->includes_cssIE = array_unique($this->includes_cssIE);
		$out = "";
		if (count($this->includes_css)){
			$out .= "\r\nRunner.util.ScriptLoader.loadCSS([";
			foreach($this->includes_css as $file)
			{
				$out.="'".$file."', ";
			}
			$out = substr($out, 0, strlen($out)-2);
			$out .= "]);\r\n";
		}
		if (count($this->includes_cssIE)){
			$out .= "Runner.util.ScriptLoader.loadCSS([";
			foreach($this->includes_cssIE as $file)
			{
				$out.="'".$file."', ";
			}
			$out = substr($out, 0, strlen($out)-2);
			$out .= "], true);\r\n";
		}
		
		foreach($this->includes_js as $file)
		{
			$out .= "Runner.util.ScriptLoader.addJS(['".$file."']";
			if(array_key_exists($file,$this->includes_jsreq))
			{
				foreach($this->includes_jsreq[$file] as $req)
					$out.=",'".$req."'";
			}
			$out.=");\r\n";
		}
		$out.= " Runner.util.ScriptLoader.load();";
		return $out;
	}
		
	/**
	  * Set languge params for page
	  */	
	function setLangParams()
	{
	}
	
	/**
	  * Add general js or css files for pages
	  */
	function addCommonJs() 
	{
		if ($this->googleMapCfg['isUseGoogleMap'] && !postvalue("onFly")){
		//	$this->body["begin"].= '<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key='.$this->googleMapCfg['APIcode'].'" type="text/javascript"></script>';
		}
		
		if ($this->debugJSMode === true)
		{		
			$this->AddJSFile("include/runnerJS/ControlConstants");
			$this->AddJSFile("include/runnerJS/RunnerEvent");
			$this->AddJSFile("include/runnerJS/Validate","include/runnerJS/RunnerEvent");
			$this->AddJSFile("include/runnerJS/ControlManager","include/runnerJS/Validate");
			$this->AddJSFile("include/runnerJS/button", "include/runnerJS/ControlManager");	
			$this->AddJSFile("include/runnerJS/Control", "include/runnerJS/ControlManager");
			$this->AddJSFile("include/runnerJS/ReadOnly", "include/runnerJS/Control");				
			$this->AddJSFile("include/runnerJS/TextAreaControl", "include/runnerJS/Control");
			$this->AddJSFile("include/runnerJS/TextFieldControl", "include/runnerJS/Control");
			$this->AddJSFile("include/runnerJS/TimeFieldControl", "include/runnerJS/Control");
			$this->AddJSFile("include/runnerJS/RteControl", "include/runnerJS/Control");
			$this->AddJSFile("include/runnerJS/FileControl", "include/runnerJS/Control");
			$this->AddJSFile("include/runnerJS/DateFieldControl", "include/runnerJS/Control");
			$this->AddJSFile("include/runnerJS/LookupWizard", "include/runnerJS/Control");
			$this->AddJSFile("include/runnerJS/RadioControl", "include/runnerJS/LookupWizard");
			$this->AddJSFile("include/runnerJS/DropDown", "include/runnerJS/LookupWizard");
			$this->AddJSFile("include/runnerJS/CheckBox", "include/runnerJS/LookupWizard");
			$this->AddJSFile("include/runnerJS/TextFieldLookup", "include/runnerJS/LookupWizard");
			$this->AddJSFile("include/runnerJS/EditBoxLookup", "include/runnerJS/TextFieldLookup");
			$this->AddJSFile("include/runnerJS/ListPageLookup", "include/runnerJS/TextFieldLookup");
			$this->AddJSFile("include/runnerJS/InlineEdit");			
						
			$this->AddJSFile("include/runnerJS/pages/PageConstants", "include/runnerJS/ListPageLookup");	
			$this->AddJSFile("include/runnerJS/pages/RunnerDefaults", "include/runnerJS/pages/PageConstants");	
			$this->AddJSFile("include/runnerJS/pages/PageManager", "include/runnerJS/pages/RunnerDefaults");
			$this->AddJSFile("include/runnerJS/pages/PageSettings", "include/runnerJS/pages/PageManager");
			$this->AddJSFile("include/runnerJS/DetPreview", "include/runnerJS/pages/PageSettings");			
			$this->AddJSFile("include/runnerJS/pages/RunnerPage", "include/runnerJS/pages/PageSettings");
			$this->AddJSFile("include/runnerJS/pages/SearchPage", "include/runnerJS/pages/RunnerPage");
			$this->AddJSFile("include/runnerJS/pages/ViewPage", "include/runnerJS/pages/RunnerPage");
			$this->AddJSFile("include/runnerJS/pages/EditorPage", "include/runnerJS/pages/RunnerPage");
			$this->AddJSFile("include/runnerJS/pages/AddPageFly", "include/runnerJS/pages/AddPage");
			$this->AddJSFile("include/runnerJS/pages/AddPage", "include/runnerJS/pages/EditorPage");
			$this->AddJSFile("include/runnerJS/pages/EditPage", "include/runnerJS/pages/EditorPage");
			
			$this->AddJSFile("include/runnerJS/pages/DataPageWithSearch", "include/runnerJS/pages/RunnerPage");
			$this->AddJSFile("include/runnerJS/pages/ListPageCommon", "include/runnerJS/pages/DataPageWithSearch");
			$this->AddJSFile("include/runnerJS/pages/ListPageFly", "include/runnerJS/pages/ListPageCommon");
			$this->AddJSFile("include/runnerJS/pages/ListPage", "include/runnerJS/pages/ListPageCommon", "include/runnerJS/DetPreview");
			if (isMobile()) {
				$this->AddJSFile("include/runnerJS/pages/ListPageMobile", "include/runnerJS/pages/ListPage");
				$this->AddJSFile("include/runnerJS/pages/ReportPageMobile", "include/runnerJS/pages/ListPageMobile");
				$this->AddJSFile("include/runnerJS/pages/ChartPageMobile", "include/runnerJS/pages/ListPageMobile");
			}
			else {
				$this->AddJSFile("include/runnerJS/pages/ReportPage", "include/runnerJS/pages/DataPageWithSearch");
				$this->AddJSFile("include/runnerJS/pages/ChartPage", "include/runnerJS/pages/DataPageWithSearch");
			}
			$this->AddJSFile("include/runnerJS/pages/ListPageAjax", "include/runnerJS/pages/ListPage");
			$this->AddJSFile("include/runnerJS/pages/ListPageDP", "include/runnerJS/pages/ListPage");
			
			$this->AddJSFile("include/runnerJS/pages/CheckboxesPage", "include/runnerJS/pages/ListPage");
			$this->AddJSFile("include/runnerJS/pages/MembersPage", "include/runnerJS/pages/CheckboxesPage");
			$this->AddJSFile("include/runnerJS/pages/RightsPage", "include/runnerJS/pages/CheckboxesPage");
			$this->AddJSFile("include/runnerJS/pages/ExportPage", "include/runnerJS/pages/RunnerPage");
			$this->AddJSFile("include/runnerJS/pages/ImportPage", "include/runnerJS/pages/RunnerPage");
			$this->AddJSFile("include/runnerJS/pages/RegisterPage", "include/runnerJS/pages/RunnerPage");
			
			$this->AddJSFile("include/runnerJS/SearchForm");
			$this->AddJSFile("include/runnerJS/SearchFormWithUI", "include/runnerJS/SearchForm");
			$this->AddJSFile("include/runnerJS/SearchController", "include/runnerJS/SearchFormWithUI");
			$this->AddJSFile("include/runnerJS/RunnerForm");
			
			$this->AddJSFile("include/runnerJS/RunnerBricks");
			$this->AddJSFile("include/runnerJS/RunnerMenu");
			if($this->lockingObj)
				$this->AddJSFile("include/runnerJS/RunnerLocking");
			if($this->is508)
				$this->AddJSFile("include/runnerJS/RunnerSection508");	
			
			$this->AddJSFile("include/yui/yahoo");
			$this->AddJSFile("include/yui/cookie", "include/yui/yahoo");					
			$this->AddJSFile("include/yui/dom", "include/yui/cookie");		
			$this->AddJSFile("include/yui/event", "include/yui/dom");
			$this->AddJSFile("include/yui/element", "include/yui/event");
			$this->AddJSFile("include/yui/tabview", "include/yui/element");
			$this->AddJSFile("include/yui/datasource", "include/yui/element");		
			$this->AddJSFile("include/yui/dragdrop", "include/yui/datasource");
			$this->AddJSFile("include/yui/animation", "include/yui/dragdrop");
			$this->AddJSFile("include/yui/connection", "include/yui/animation");
			$this->AddJSFile("include/yui/container", "include/yui/connection");
			$this->AddJSFile("include/yui/datatable", "include/yui/dragdrop");
			$this->AddJSFile("include/yui/json", "include/yui/datatable");
			$this->AddJSFile("include/yui/resize", "include/yui/json");	
			
			if($this->calendar)
				$this->AddJSFile("include/yui/calendar", "include/yui/event", "include/yui/container");
			
			//if($this->pageType == PAGE_EDIT && $this->useTabsOnEdit || $this->pageType == PAGE_ADD && $this->useTabsOnAdd || $this->pageType == PAGE_VIEW && $this->useTabsOnView)
			//$this->AddCSSFile("include/redefineStyle");
				
			if (GetTableData($this->tName, ".addPageEvents", false) && $this->mode != LIST_DETAILS){
				$this->AddJSFile("include/runnerJS/events/pageevents_".$this->shortTableName, "include/runnerJS/pages/PageSettings", "include/runnerJS/button");
			}
			
				}
		else 	
		{			
			if (GetTableData($this->tName, ".addPageEvents", false) && $this->mode != LIST_DETAILS){
				$this->AddJSFile("include/runnerJS/events/pageevents_".$this->shortTableName, "include/runnerJS/RunnerControls", "include/runnerJS/RunnerPages");
			}
		
			//$this->AddCSSFile("include/redefineStyle");
		}
		//$this->AddJSFile("include/customlabels");
	
		if ($this->isUseAjaxSuggest)
			$this->AddJSFile("include/ajaxsuggest");	
		elseif(count($this->allDetailsTablesArr))
		{
			for($i = 0; $i < count($this->allDetailsTablesArr); $i ++) 
			{
				if($this->allDetailsTablesArr[$i]['previewOnList'] == DP_POPUP)
					$this->AddJSFile("include/ajaxsuggest");	
					break;
			}		
		}
		
		if($this->timepicker)
		{
			$this->AddJSFile("include/ui");
			$this->AddJSFile("include/jquery.utils","include/ui");
			$this->AddJSFile("include/ui.dropslide","include/jquery.utils");
			$this->AddJSFile("include/jquery.timepickr","include/ui.dropslide");
		}
		
		if ($this->isUseToolTips){
			if (isMobile())
				$this->AddJSFile("include/dimensions.mobile");
			else 
				$this->AddJSFile("include/dimensions");
		}
		
		if($this->useIbox)
			$this->AddJSFile("include/ibox");
		
		if($this->isUseCK)
			$this->addJSFile("plugins/ckeditor/ckeditor");
		
		if($this->isUseVideo)
			$this->addJSFile("include/video/flowplayer-3.2.3.min");
			
		if($this->isUseAudio)
			$this->AddJSFile("include/runnerJS/ymp");
		
//		if($this->pageType == PAGE_EDIT && $this->useTabsOnEdit || $this->pageType == PAGE_ADD && $this->useTabsOnAdd || $this->pageType == PAGE_VIEW && $this->useTabsOnView)
//			$this->AddCSSFile("include/redefineStyle");
	}
	
	/**
	  * Prepare js code
	  */
	function PrepareJs()
	{				
		return $js = $this->LoadJS_CSS();
	}
	
	function addButtonHandlers()
	{	
		if (!GetTableData($this->tName, ".isUsebuttonHandlers", false)){
			return false;
		}
		if ($this->debugJSMode === true)
		{
			$this->AddJSFile("include/runnerJS/events/pageevents_".$this->shortTableName, "include/runnerJS/pages/PageSettings");
		}
		else 
		{
			$this->AddJSFile("include/runnerJS/events/pageevents_".$this->shortTableName, "include/runnerJS/RunnerControls", "include/runnerJS/RunnerPages");
		}
		return true;
	}
	
	function setGoogleMapsParams($fieldsArr) 
	{
		$this->googleMapCfg['isUseMainMaps'] = GetTableData($this->tName, ".isUseMainMaps", false);
		$this->googleMapCfg['isUseFieldsMaps'] = GetTableData($this->tName, ".isUseFieldsMaps", false);
		if ($this->googleMapCfg['isUseFieldsMaps'])
		foreach($fieldsArr as $f)
		{
			if ($f['viewFormat'] == FORMAT_MAP)
			{				
				$this->googleMapCfg['fieldsAsMap'][$f['fName']] = array();
				$fieldMap = GetFieldData($this->tName, $f['fName'], "mapData", array());
				
				$this->googleMapCfg['fieldsAsMap'][$f['fName']]['width'] = $fieldMap['width'] ? $fieldMap['width'] : 0;
				$this->googleMapCfg['fieldsAsMap'][$f['fName']]['height'] = $fieldMap['height'] ? $fieldMap['height'] : 0;
				$this->googleMapCfg['fieldsAsMap'][$f['fName']]['addressField'] = $fieldMap['address'];
				$this->googleMapCfg['fieldsAsMap'][$f['fName']]['latField'] = $fieldMap['lat'];
				$this->googleMapCfg['fieldsAsMap'][$f['fName']]['lngField'] = $fieldMap['lng'];
				if (isset($fieldMap['zoom'])){
					$this->googleMapCfg['fieldsAsMap'][$f['fName']]['zoom'] = $fieldMap['zoom'];
				}
			}
		}		
		$this->googleMapCfg['isUseGoogleMap'] = $this->googleMapCfg['isUseMainMaps'] || $this->googleMapCfg['isUseFieldsMaps'] || $this->mapsExists();
	}
	
	function addBigGoogleMapMarkers(&$data, $viewLink = '') 
	{		
		foreach ($this->googleMapCfg['mainMapIds'] as $mapId)
		{				
			$latF = $this->googleMapCfg['mapsData'][$mapId]['latField'];
			$lngF = $this->googleMapCfg['mapsData'][$mapId]['lngField'];	
			$addressF = $this->googleMapCfg['mapsData'][$mapId]['addressField'];
			$descF = $this->googleMapCfg['mapsData'][$mapId]['descField'];
			
			$markerArr = array();
			$markerArr['lat'] = $data[$latF] ? $data[$latF] : '';
			$markerArr['lng'] = $data[$lngF] ? $data[$lngF] : '';
			$markerArr['address'] = $data[$addressF] ? $data[$addressF] : '';
			$markerArr['desc'] = $data[$descF] ? $data[$descF] : $markerArr['address'];
			$markerArr['link'] = $viewLink;
			$markerArr['recId'] = $this->recId;
			
			$this->googleMapCfg['mapsData'][$mapId]['markers'][] = $markerArr;
		}
	}
	// call addGoogleMapData before call  proccessRecordValue!!!
	function addGoogleMapData($fName, &$data, $viewLink = '') 
	{
		$fieldMap = GetFieldData($this->tName, $fName, "mapData", array());
		
		$mapData['mapFieldValue'] = $data[$fName];
		$address = $data[$fieldMap['address']] ? $data[$fieldMap['address']] : "";
		$lat = $data[$fieldMap['lat']] ? $data[$fieldMap['lat']] : '';
		$lng = $data[$fieldMap['lng']] ? $data[$fieldMap['lng']] : '';
		$desc = $data[$fieldMap['desc']] ? $data[$fieldMap['desc']] : $address;
		if (isset($fieldMap['zoom'])){
			$zoom = $fieldMap['zoom'];
		}else{
			$zoom = '';
		}
		  
		$mapData['fName'] = $fName;
		$mapData['zoom'] = $zoom;
		$mapData['type'] = 'FIELD_MAP';
		$mapData['markers'][] = array('address'=> $address, 'lat'=>$lat, 'lng'=>$lng, 'link'=>$viewLink, 'desc'=>$desc, 'recId'=>$this->recId);
		
		$this->googleMapCfg['mapsData']['littleMap_'.GoodFieldName($fName).'_'.$this->recId] = $mapData;
		$this->googleMapCfg['fieldMapsIds'][] = 'littleMap_'.GoodFieldName($fName).'_'.$this->recId;
		
		return $this->googleMapCfg['mapsData']['littleMap_'.GoodFieldName($fName).'_'.$this->recId];
	}
	
	function initGmaps()
	{
		if ($this->googleMapCfg['isUseGoogleMap'])
		{	
			foreach ($this->googleMapCfg['mainMapIds'] as $mapId)
			{
				if ($this->googleMapCfg['mapsData'][$mapId]['showCenterLink'] === 1)
				{
					$this->googleMapCfg['centerLinkText'] = $this->googleMapCfg['mapsData'][$mapId]['centerLinkText'];
					break;
				}
			}
			$this->googleMapCfg['id'] = $this->id;
			//$this->AddJSFile("include/json");
			$this->AddJSFile("include/runnerJS/gmap");
			if (!$this->googleMapCfg['APIcode'])
			{
				$this->googleMapCfg['APIcode'] = '';	
			}
			$this->controlsMap['gMaps'] = &$this->googleMapCfg;	
			//$this->AddJSFileNoExt('http://maps.google.com/maps?file=api&v=2&sensor=true&key='.$this->googleMapCfg['APIcode']);
		}
	}
	
	function addCenterLink(&$value, $fName)
	{
		if ($this->googleMapCfg['isUseMainMaps'])
		{
			foreach ($this->googleMapCfg['mainMapIds'] as $mapId)
			{
				// if no center link than continue;
				if ($this->googleMapCfg['mapsData'][$mapId]['addressField'] != $fName || !$this->googleMapCfg['mapsData'][$mapId]['showCenterLink'])
					continue;
				
				// if use user defined link if prop = 1 or use value if prop = 2				
				if($this->googleMapCfg['mapsData'][$mapId]['showCenterLink'] === 1)
					$value = $this->googleMapCfg['mapsData'][$mapId]['centerLinkText'];					
				
				return '<a href="#" type="centerOnMarker'.$this->id.'" recId="'.$this->recId.'">'.$value.'</a>';				
			}
		}
		return $value;
	}
	
	/**
	 * Get permissions for pages
	 */
	function getPermissions($tName = "") 
	{
		$resArr = array();
		
		if(!$this->isGroupSecurity) 
		{
			$resArr["add"]= true;
			$resArr["delete"]= true;
			$resArr["edit"]= true;
			$resArr["search"]= true;
			$resArr["export"]= true;
			$resArr["import"]= true;
		}
		else
		{
			if(!$tName)
				$tName = $this->tName;
			$strPerm = GetUserPermissions($tName);
			
			$resArr["add"]=(strpos($strPerm, "A") !== false);
			$resArr["delete"]=(strpos($strPerm, "D") !== false);
			$resArr["edit"]=(strpos($strPerm, "E") !== false);
			$resArr["search"]=(strpos($strPerm, "S") !== false);
			$resArr["export"]=(strpos($strPerm, "P") !== false);
			$resArr["import"]=(strpos($strPerm, "I") !== false);
		}
		return $resArr;
	}
		
	/**
	 * Check is event exists on current page
	 * @param {string} - event name
	 */
	function eventExists($name)
	{
		if(!$this->eventsObject)
			return false;
		return $this->eventsObject->exists($name);
	}
	
	/**
	 * Check is captcha exists on current page
	 *
	 */	
	function captchaExists()
	{
		if(!$this->eventsObject)
			return false;
		return $this->eventsObject->existsCAPTCHA($this->pageType);
	}
	
	/**
	 * Check is googlemaps exists on current page
	 *
	 */	
	function mapsExists()
	{
		if(!$this->eventsObject)
			return false;
		return $this->eventsObject->existsMap($this->pageType);
	}
	
//	move this functions to viewpage or editpage class when they will be created
	function getNextPrevRecordKeys(&$data,$securityMode,&$next,&$prev)
	{
		global $conn;
		$next=array();
		$prev=array();
	
		if(@$_SESSION[$this->sessionPrefix."_noNextPrev"])
			return;
		$prevExpr = "";
		$nextExpr = "";
		$where_next="";
		$where_prev="";
		$order_next="";
		$order_prev="";
		$arrFieldForSort=array();
		$arrHowFieldSort=array();
		$query = GetQueryObject($this->tName);
		$where = $_SESSION[$this->sessionPrefix."_where"];
		if(!strlen($where))
			$where = SecuritySQL($securityMode);
		$having = $_SESSION[$this->sessionPrefix."_having"];
		$orderindexes = GetTableData($this->tName,".orderindexes",array());
		$strOrderBy = GetTableData($this->tName,".strOrderBy",'');

	// calc indexes of the key fields
		$keyIndexes = array();
		$tKeys = GetTableKeys($this->tName);
		foreach($tKeys as $k)
		{
			$ki = GetFieldIndex($k,$this->tName);
			if($ki)
				$keyIndexes[]=$ki;
		}
		if(!count($keyIndexes))
		{
			$_SESSION[$this->sessionPrefix."_noNextPrev"] = 1;
			return;
		}
		
	// get current ordering info
		if(@$_SESSION[$this->sessionPrefix."_arrFieldForSort"] && @$_SESSION[$this->sessionPrefix."_arrHowFieldSort"])
		{
			$arrFieldForSort=$_SESSION[$this->sessionPrefix."_arrFieldForSort"];
			$arrHowFieldSort=$_SESSION[$this->sessionPrefix."_arrHowFieldSort"];
		}
		else
		{
		//	get default order
			if(count($orderindexes))
			{
				for($i=0;$i<count($orderindexes);$i++)
				{
					$arrFieldForSort[]=$orderindexes[$i][0];
					$arrHowFieldSort[]=$orderindexes[$i][1];
				}
			}
			elseif($strOrderBy!='')
			{
				$_SESSION[$this->sessionPrefix."_noNextPrev"] = 1;
				return;
			}
			// add key fields
			for($i=0;$i<count($keyIndexes);$i++)
			{
				if(array_search($keyIndexes[$i],$arrFieldForSort) === false)
				{
					$arrFieldForSort[]=$keyIndexes[$i];
					$arrHowFieldSort[]="ASC";
				}
			}
			$_SESSION[$this->sessionPrefix."_arrFieldForSort"]=$arrFieldForSort;
			$_SESSION[$this->sessionPrefix."_arrHowFieldSort"]=$arrHowFieldSort;
		}
		if(!count($arrFieldForSort))
		{
			$_SESSION[$this->sessionPrefix."_noNextPrev"] = 1;
			return;
		}
		//	make  next & prev ORDER BY strings
		for($i=0; $i<count($arrFieldForSort); $i++)
		{
			if(!GetFieldByIndex($arrFieldForSort[$i],$this->tName))
				continue;
			if($order_next == "")
			{
				$order_next = " ORDER BY ";
				$order_prev = " ORDER BY ";
			}
			else
			{
				$order_next .= ",";
				$order_prev .= ",";
			}
			$order_next .= $arrFieldForSort[$i]." ".$arrHowFieldSort[$i];
			$order_prev .= $arrFieldForSort[$i]." ".($arrHowFieldSort[$i]=="DESC" ? "ASC" : "DESC");
		}

		// make next & prev where expressions
		
		$tail="";
		for($i=0;$i<count($arrFieldForSort);$i++)
		{
			$fieldName=GetFieldByIndex($arrFieldForSort[$i],$this->tName);
			if(!$fieldName)
				continue;
			if(!$query->HasGroupBy())
				$fullName = GetFullFieldName($fieldName,$this->tName);
			else
				$fullName = $fieldName;
			$asc = ($arrHowFieldSort[$i]=="ASC");
			if(!is_null($data[$fieldName]))
			{
			//	current field value is not null
				$value=make_db_value($fieldName,$data[$fieldName],"","",$this->tName);
				$nextop = ($asc ? ">" : "<");
				$prevop = ($asc ? "<" : ">");
				$nextExpr = $fullName.$nextop.$value;
				$prevExpr = $fullName.$prevop.$value;
				if($nextop=="<")
					$nextExpr .= " or ".$fullName." IS NULL";
				else
					$prevExpr .= " or ".$fullName." IS NULL";
				if($i<count($arrFieldForSort)-1)
				{
					$nextExpr .= " or ".$fullName."=".$value;
					$prevExpr .= " or ".$fullName."=".$value;
				}
			}
			else
			{
			//	current field value is null
				if($asc)
					$nextExpr = $fullName." IS NOT NULL";
				else
					$prevExpr = $fullName." IS NOT NULL";
				
				if($i<count($arrFieldForSort)-1)
				{
					if($nextExpr != "")
						$nextExpr.=" or ";
					$nextExpr .= $fullName." IS NULL";
					if($prevExpr != "")
						$prevExpr.=" or ";
					$prevExpr .= $fullName." IS NULL";
				}
			}
			if($nextExpr == "")
				$nextExpr = " 1=0 ";
			if($prevExpr == "")
				$prevExpr = " 1=0 ";
			
			// append expression to where clause
			if($i>0)
			{
				$where_next .= " AND ";
				$where_prev .= " AND ";
			}
			$where_next .= "(".$nextExpr;
			$where_prev .= "(".$prevExpr;
			
			$tail .=")";
		}
		$where_next =$where_next.$tail;
		$where_prev =$where_prev.$tail;

		if($where_next=="" or $order_next=="" or $where_prev=="" or $order_prev=="")
		{
			$_SESSION[$this->sessionPrefix."_noNextPrev"] = 1;
			return;
		}
//		make the resulting query
		if($query === null)
			return;
		
		if(!$query->HasGroupBy())
		{
			$oWhere = $query->Where();
			$where = whereAdd($where,$oWhere->toSql($query));
			$where_next = whereAdd($where_next,$where);
			$where_prev = whereAdd($where_prev,$where);
			$query->ReplaceFieldsWithDummies(GetBinaryFieldsIndices($this->tName));
			$sql_next = $query->toSql($where_next, $order_next);
			$sql_prev = $query->toSql($where_prev, $order_prev);
		}
		else
		{
			$oWhere = $query->Where();
			$oHaving = $query->Having();
			$where = whereAdd($where,$oWhere->toSql($query));
			$having = whereAdd($having,$oHaving->toSql($query));
			$query->ReplaceFieldsWithDummies(GetBinaryFieldsIndices($this->tName));
			$sql = "select * from (".$query->toSql($where, "", $having).") prevnextquery";
			$sql_next = $sql." WHERE ".$where_next.$order_next;
			$sql_prev = $sql." WHERE ".$where_prev.$order_prev;
		}

		//	add record count options
		
				$res_next=db_query($sql_next,$conn);		
		if($res_next)
		{
			if($row_next=db_fetch_array($res_next))
			{
				foreach($tKeys as $i=>$k)
				{
					$next[$i+1] = $row_next[$k];
				}
			}
			db_closequery($res_next);
		}
		$res_prev=db_query($sql_prev,$conn);	
		if($row_prev=db_fetch_array($res_prev))
		{
			foreach($tKeys as $i=>$k)
			{
				$prev[$i+1] = $row_prev[$k];
			}
		}
		db_closequery($res_prev);
	}

	function doCaptchaCode()
	{
		global $globalEvents;
		
		if((!isset($_SESSION[$this->tName."_count_captcha"])) or ($_SESSION[$this->tName."_count_captcha"]>4)) 
			$_SESSION[$this->tName."_count_captcha"]=0;
				
		if(($this->pageType==PAGE_EDIT && @$_POST["a"]=="edited") || ($this->pageType==PAGE_ADD && @$_POST["a"]=="added") || ($this->pageType==PAGE_REGISTER && @$_POST["btnSubmit"] == "Register"))
			$sbmPage = true;
		else
			$sbmPage = false;
			
		if(($_SESSION[$this->tName."_count_captcha"]==0) or ($_SESSION[$this->tName."_count_captcha"]>4))
		{
			if($sbmPage)
			{	
				if(@strtolower(postvalue("value_captcha_".$this->id))!=strtolower(@$_SESSION["captcha"]))
				{
					if($this->pageType == PAGE_REGISTER)
					{
						$this->captchaId = $globalEvents->captchas[$this->pageType]['strName'];
						$globalEvents->callCAPTCHA($this);
					}
					else{
							$this->captchaId = $this->eventsObject->captchas[$this->pageType]['strName'];
							$this->eventsObject->callCAPTCHA($this);
						}
					$this->isCaptchaOk = false;
				}
				else
					$this->isCaptchaOk = true;
			}
			else{
					if($this->pageType == PAGE_REGISTER)
					{
						$this->captchaId = $globalEvents->captchas[$this->pageType]['strName'];
						$globalEvents->callCAPTCHA($this);
					}
					else{
							$this->captchaId = $this->eventsObject->captchas[$this->pageType]['strName'];
							$this->eventsObject->callCAPTCHA($this);
						}	
				}
			
			//create control and settings for captcha field, if it show on page 
			$controls = array('controls'=>array());
			$controls['controls']['ctrlInd'] = 0;
			$controls['controls']['id'] = $this->id;
			$controls['controls']['fieldName'] = 'captcha';
			$controls['controls']['mode'] = $this->pageType;
			$this->fillControlsMap($controls);
			$this->addCaptchaToFieldSettings();
		}
		elseif($sbmPage) 
			$this->isCaptchaOk = true;	
	}
	
	function createCaptcha($params)
	{	
		$captchaHTML = '<div class="captcha_block">
			<object width="210" height="65" data="securitycode.swf?ext=php" type="application/x-shockwave-flash">
				<param value="securitycode.swf?ext=php" name="movie"/>
				<param value="opaque" name="wmode"/>
				<a href="http://www.macromedia.com/go/getflashplayer"><img alt="Download Flash" src=""/></a>
			</object>
				<div style="white-space: nowrap;">'."Teclea el codigo que ves debajo".':</div>
			<span id="edit'.$this->id.'_captcha_0">
				<input type="text" value="" name="value_captcha_'.$this->id.'" style="" id="value_captcha_'.$this->id.'"/>
				<font color="red">*</font>
			</span>';
		
		if(isset($this->isCaptchaOk) && !$this->isCaptchaOk)
			$captchaHTML .= '<div class="error">'."Codigo de seguridad no v�lido".'</div>';
			
		echo $captchaHTML.'</div>';
	}
	
	function createPerPage()
	{
		$rpp = "";
		if($this->isTableType == "report" && $this->reportGroupFields)
		{
			$rpp.= "<select onChange=\"javascript: document.location='".htmlspecialchars(rawurlencode($this->shortTableName))."_report.php?pagesize='+this.options[this.selectedIndex].value;\">";
			for($i=0;$i<count($this->arrGroupsPerPage);$i++)
			{			
				if($this->arrGroupsPerPage[$i]!=-1)
					$rpp.= "<option value=\"".$this->arrGroupsPerPage[$i]."\" ".($this->pageSize == $this->arrGroupsPerPage[$i] ? "selected" : "").">".$this->arrGroupsPerPage[$i]."</option>";
				else	
					$rpp.= "<option value=\"-1\" ".($this->pageSize == $this->arrGroupsPerPage[$i] ? "selected" : "").">"."Mostrar todo"."</option>";
			}	
		}	
		else{
				if($this->isTableType == "report")
					$rpp.= "<select onChange=\"javascript: document.location='".htmlspecialchars(rawurlencode($this->shortTableName))."_report.php?pagesize='+this.options[this.selectedIndex].value;\">";
				else
					$rpp.= "<select id=\"recordspp".$this->id."\">";
				
				for($i=0;$i<count($this->arrRecsPerPage);$i++)
				{
					if($this->arrRecsPerPage[$i]!=-1)
						$rpp.= "<option value=\"".$this->arrRecsPerPage[$i]."\" ".($this->pageSize == $this->arrRecsPerPage[$i] ? "selected" : "").">".$this->arrRecsPerPage[$i]."</option>";
					else
						$rpp.= "<option value=\"-1\" ".($this->pageSize == $this->arrRecsPerPage[$i] ? "selected" : "").">"."Mostrar todo"."</option>";
				}
			}
		$rpp.="</select>";
		
		if($this->isTableType == "report" && $this->reportGroupFields)
			$this->xt->assign("grpsPerPage",$rpp);
		else
			$this->xt->assign("recsPerPage",$rpp);
	}
	
	function ProcessFiles()
	{
		foreach($this->filesToDelete as $f)
		{
			$f->Delete();
		}
		foreach($this->filesToMove as $f)
		{
			$f->Move();
		}
		foreach($this->filesToSave as $f)
		{
			$f->Save();
		}
	}
	
	/**
	 * Use for count details recs number, if subQueryes not supported, or keys have different types
	 *
	 * @param integer $i
	 * @param array $detailid
	 */
	function countDetailsRecsNoSubQ($dInd, &$detailid) 
	{
		global $tables_data;
        global $masterTablesData;
        global $detailsTablesData;
		global $allDetailsTablesArr;
		$dDataSourceTable = $this->allDetailsTablesArr[$dInd]['dDataSourceTable'];
 		$gQuery = GetTableData($dDataSourceTable, '.sqlquery', null);
				
		$dObjHaving = $gQuery->Having();
		$dSqlHaving = $dObjHaving->toSql($gQuery);		
		$dSqlGroupBy = $gQuery->GroupByToSql();
				
		$dSqlHead = $this->allDetailsTablesArr[$dInd]['sqlHead'];
		$dSqlFrom = $this->allDetailsTablesArr[$dInd]['sqlFrom'];
		$dSqlWhere = $this->allDetailsTablesArr[$dInd]['sqlWhere'];
		//$sqlTail = $detailTableInfo['sqlTail'];
			
		$detailKeys = GetDetailKeysByMasterTable($this->tName, $dDataSourceTable);
		
		$securityClause = SecuritySQL("Search", $dDataSourceTable);
		
		// add where 
		if(strlen($securityClause))
			$dSqlWhere = whereAdd($dSqlWhere, $securityClause);
			
		$masterwhere = "";
		foreach($this->masterKeysByD[$dInd] as $idx => $val) 
		{
			if($masterwhere)
			{
				$masterwhere.= " and ";
			}
			$mastervalue = make_db_value($detailKeys[$idx],$detailid[$idx],"","",$this->allDetailsTablesArr[$dInd]["dDataSourceTable"]);
			if($mastervalue=="null")
				$masterwhere.= GetFullFieldName($detailKeys[$idx], $dDataSourceTable)." is NULL ";
			else
				$masterwhere.= GetFullFieldName($detailKeys[$idx], $dDataSourceTable)."=".$mastervalue;
		}
		return gSQLRowCount_int($dSqlHead, $dSqlFrom, $dSqlWhere, $dSqlGroupBy, $dSqlHaving, $masterwhere,"");	
		
	}
	
	/**
	 * Calcs pagination info
	 *
	 */
	function buildPagination() 
	{
		//	hide colunm headers if needed
		$this->recordsOnPage = $this->numRowsFromSQL -($this->myPage - 1) * $this->pageSize;
		if($this->recordsOnPage > $this->pageSize && $this->pageSize!=-1)
			$this->recordsOnPage = $this->pageSize;
		
		$this->colsOnPage = $this->recsPerRowList;
		if($this->colsOnPage > $this->recordsOnPage)
			$this->colsOnPage = $this->recordsOnPage;
		if($this->colsOnPage < 1)
			$this->colsOnPage = 1;
			
		//	 Pagination:
		if((! $this->numRowsFromSQL) && ($this->deleteMessage == ''))
		{
			$this->rowsFound = false;
			$message = ($this->is508 == true ? "<a name=\"skipdata\"></a>" : "")."No se hallaron registros";
			$message= "<span name=\"notfound_message".$this->id."\">".$message."</span>";
			$this->xt->assign("message",$message);
			$this->xt->assign("message_block",true);
		} 
		else{
				$this->rowsFound = true;
				$maxRecords = $this->numRowsFromSQL;
				
				$this->xt->assign("message_block",false);
				if($this->listAjax){
					$this->xt->assign("message_block",true);
					$this->xt->displayBrickHidden("message");
				}
				else if ($this->deleteMessage != ''){
					$this->xt->assign("message_block",true);
				}
				
				$this->xt->assign("records_found", $this->numRowsFromSQL);
				if($this->pageSize && $this->pageSize!=-1)
					$this->maxPages = ceil($maxRecords / $this->pageSize);
				if($this->myPage > $this->maxPages)
					$this->myPage = $this->maxPages;
				if($this->myPage < 1)
					$this->myPage = 1;
				$this->jsSettings["tableSettings"][$this->tName]['maxPages'] = $this->maxPages;
				$this->maxRecs = $this->pageSize;
				$this->xt->assign("page", $this->myPage);
				$this->xt->assign("maxpages", $this->maxPages);
				
				$this->xt->assign("pagination_block", false);
				
				//	write pagination
				if($this->maxPages > 1) 
				{
					$this->xt->assign("pagination_block", true);
					$pagination = "<table rows='1' cols='1' align='center' width='auto' border='0' name='paginationTable".$this->id."'>";
					$pagination.= "<tr valign='center'><td align='center'>";
					$counterstart = $this->myPage - 9;
					if($this->myPage % 10)
						$counterstart = $this->myPage -($this->myPage % 10) + 1;
					$counterend = $counterstart + 9;
					if($counterend > $this->maxPages)
						$counterend = $this->maxPages;
					if($counterstart != 1) 
					{
						$pagination.= $this->getPaginationLink(1,"Primero")."&nbsp;:&nbsp;";
						$pagination.= $this->getPaginationLink($counterstart - 1,"Anterior")."&nbsp;";
					}
					$pagination.= "<b>[</b>";
					for($counter = $counterstart; $counter <= $counterend; $counter ++) 
					{
						if($counter != $this->myPage)
							$pagination.= "&nbsp;".$this->getPaginationLink($counter,$counter,true);
						else
							$pagination.= "&nbsp;<b>".$counter."</b>";
					}
					$pagination.= "&nbsp;<b>]</b>";
					if($counterend != $this->maxPages) 
					{
						$pagination.= "&nbsp;".$this->getPaginationLink($counterend + 1,"Siguiente")."&nbsp;:&nbsp;";
						$pagination.= "&nbsp;".$this->getPaginationLink($this->maxPages,"�ltimo");
					}
					$pagination.= "</td></tr></table>";
					$this->xt->assign("pagination", $pagination);
				}elseif($this->listAjax){
					$this->xt->assign("pagination_block", true);
					$this->xt->displayBrickHidden("pagination");
				}
			}
	}
	/**
	 * Get pagination link for build pagination block
	 *
	 * @return string
	 */
	function getPaginationLink($pageNum,$linkText,$cls=false)
	{
		return '<a href="#" pageNum="'.$pageNum.'" '.($cls ? 'class="pag_n"' : '').' style="TEXT-DECORATION: none;">'.$linkText.'</a>';
	}
	
	
	/**
	 * Check is current table is admin table
	 *
	 * @return bool
	 */
	function isAdminTable()
	{
		if($this->tName)
			return $this->tName === 'admin_rights' || $this->tName === 'admin_members' || $this->tName === 'admin_users';
		else
			return false;
	}
	
	/**
	 * isSimpleFormNeeded
	 * Check is simple html form needed on add and edit page
	 * @return {bool}
	 */
	function isHTMLFormNeeded()
	{
				return false;
	}
}

$menuNodesObject = null;
?>
