<?php


/**
 * SearchControl builder for search panel on list
 *
 */
class PanelSearchControl extends SearchControl 
{
	// attrs only for search panel
	function getCtrlParamsArr($fName, $recId, $fieldNum=0, $value, $renderHidden = false, $isCached=true) 
	{
		$control = parent::getCtrlParamsArr($fName, $recId, $fieldNum, $value, $renderHidden, $isCached) ;
		
		$control["params"]["additionalCtrlParams"]['skipDependencies'] = true;
		$control["params"]["additionalCtrlParams"]["style"] = 'width: 115px;';
		
		$ctrlsMap = array('controls'=>array());
		$ctrlsMap['controls']["skipDependencies"] = true;
		$ctrlsMap['controls']["style"] = 'width: 115px;';
		$this->pageObj->fillControlsMap($ctrlsMap,true);
		
		return $control;
	}
	
	function simpleSearchFieldCombo($fNamesArr, $selOpt) 
	{
		$options = "";
		if (sizeof(GetTableData($this->tName,".googleLikeFields",array())) != 0)
			$options = '<option value="" >'."Cualquier campo".'</option>';
		
		foreach($fNamesArr as $fName)
		{
			$fLabel = GetFieldLabel(GoodFieldName($this->tName), GoodFieldName($fName));
			$options .= '<option value="'.$fName.'" '.($selOpt == $fName ? 'selected' : '').'>'.$fLabel.'</option>';
		}
		return $options;
	}
	
	function getCtrlSearchTypeOptions($fName, $selOpt, $not) 
	{	
		$options = parent::getCtrlSearchTypeOptions($fName, $selOpt, $not) ;
		if (strlen($fName))
			$fType = GetEditFormat($fName, $this->tName);
		else 
			$fType = EDIT_FORMAT_TEXT_FIELD;
				
		if ($fType == EDIT_FORMAT_DATE || $fType == EDIT_FORMAT_TIME)
		{
			$options.="<option value=\"NOT Equals\" ".(($selOpt=="Equals" && $not)?"selected":"").">"."No es igual"."</option>";
			$options.="<option value=\"NOT More than\" ".(($selOpt=="More than" && $not)?"selected":"").">"."No mayor que"."</option>";
			$options.="<option value=\"NOT Less than\" ".(($selOpt=="Less than" && $not)?"selected":"").">"."No menor que"."</option>";
			$options.="<option value=\"NOT Between\" ".(($selOpt=="Between" && $not)?"selected":"").">"."No está entre"."</option>";
			$options.="<option value=\"NOT Empty\" ".(($selOpt=="Empty" && $not)?"selected":"").">"."No está vacío"."</option>";
		}
		elseif ($fType == EDIT_FORMAT_LOOKUP_WIZARD)
		{
			if (Multiselect($fName, $this->tName))
				$options.="<OPTION value=\"NOT Contains\" ".(($selOpt=="Contains" && $not)?"selected":"").">"."No contiene"."</option>";
			else
				$options.="<OPTION value=\"NOT Equals\" ".(($selOpt=="Equals" && $not)?"selected":"").">"."No es igual"."</option>";
		}
		elseif ($fType == EDIT_FORMAT_TEXT_FIELD || $fType == EDIT_FORMAT_TEXT_AREA || $fType == EDIT_FORMAT_PASSWORD 
				 || $fType == EDIT_FORMAT_HIDDEN || $fType == EDIT_FORMAT_READONLY)
		{
			$options.="<option value=\"NOT Contains\" ".(($selOpt=="Contains" && $not)?"selected":"").">"."No contiene"."</option>";
			$options.="<option value=\"NOT Equals\" ".(($selOpt=="Equals" && $not)?"selected":"").">"."No es igual"."</option>";
			$options.="<option value=\"NOT Starts with\" ".(($selOpt=="Starts with" && $not)?"selected":"").">"."No empieza por"."</option>";
			$options.="<option value=\"NOT More than\" ".(($selOpt=="More than" && $not)?"selected":"").">"."No mayor que"."</option>";
			$options.="<option value=\"NOT Less than\" ".(($selOpt=="Less than" && $not)?"selected":"").">"."No menor que"."</option>";
			$options.="<option value=\"NOT Between\" ".(($selOpt=="Between" && $not)?"selected":"").">"."No está entre"."</option>";
			$options.="<option value=\"NOT Empty\" ".(($selOpt=="Empty" && $not)?"selected":"").">"."No está vacío"."</option>";
		}
		else
			$options.="<option value=\"NOT Equals\" ".(($selOpt=="Equals" && $not)?"selected":"").">"."No es igual"."</option>";
		
		return $options;
	}
}
?>