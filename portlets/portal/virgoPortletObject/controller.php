<?php
/**
* Module Portlet object
* @package Portal
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace portal;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletDefinition'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletLocation'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoHtmlContent'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletParameter'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPermission'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoPortletObject {

		 var  $pob_id = null;
		 var  $pob_show_title = null;

		 var  $pob_custom_title = null;

		 var  $pob_left = null;

		 var  $pob_top = null;

		 var  $pob_width = null;

		 var  $pob_height = null;

		 var  $pob_inline = null;

		 var  $pob_ajax = null;

		 var  $pob_render_condition = null;

		 var  $pob_autorefresh = null;

		 var  $pob_pdf_id = null;
		 var  $pob_pob_id = null;

		 var   $_pageIdsToAddArray = null;
		 var   $_pageIdsToDeleteArray = null;
		 var   $pob_date_created = null;
		 var   $pob_usr_created_id = null;
		 var   $pob_date_modified = null;
		 var   $pob_usr_modified_id = null;
		 var   $pob_virgo_title = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoPortletObject();
			$parentsInContext = self::getParentsInContext();
			foreach ($parentsInContext as $className => $parentInfo) {
				if (isset($parentInfo['contextId'])) {
					$setter = "set".strtoupper($parentInfo['prefix'])."Id";
					if (method_exists($ret, $setter)) {
						call_user_func_array(array($ret, $setter), array($parentInfo['contextId']));
					}					
				}
			}
			return $ret;
		}

		public function __clone() {
        	$this->pob_id = null;
		    $this->pob_date_created = null;
		    $this->pob_usr_created_id = null;
		    $this->pob_date_modified = null;
		    $this->pob_usr_modified_id = null;
		    $this->pob_virgo_title = null;
    	}		
		
		function log($message, $level = "INFO") {
			L($message, '', $level);
		}
		
		function logFatal($message) {
			$this->log($message, "FATAL");
		}
		
		function logError($message) {
			$this->log($message, "ERROR");
		}

		function logWarn($message) {
			$this->log($message, "WARN");
		}
		
		function logInfo($message) {
			$this->log($message, "INFO");
		}
		
		function logDebug($message) {
			$this->log($message, "DEBUG");
		}
		
		function logTrace($message) {
			$this->log($message, "TRACE");
		}
		
		function isLogOn($level) {
			return false;
		}
		
		function isFatal() {
			return $this->isLogOn("FATAL");
		}
		
		function isError() {
			return $this->isLogOn("ERROR");
		}
		
		function isWarn() {
			return $this->isLogOn("WARN");
		}
		
		function isInfo() {
			return $this->isLogOn("INFO");
		}
		
		function isDebug() {
			return $this->isLogOn("DEBUG");
		}
		
		function isTrace() {
			return $this->isLogOn("TRACE");
		}
		
		function getId() {
			return $this->pob_id;
		}

		function getShowTitle() {
			return $this->pob_show_title;
		}
		
		 function setShowTitle($val) {
			$this->pob_show_title = $val;
		}
		function getCustomTitle() {
			return $this->pob_custom_title;
		}
		
		 function setCustomTitle($val) {
			$this->pob_custom_title = $val;
		}
		function getLeft() {
			return $this->pob_left;
		}
		
		 function setLeft($val) {
			$this->pob_left = $val;
		}
		function getTop() {
			return $this->pob_top;
		}
		
		 function setTop($val) {
			$this->pob_top = $val;
		}
		function getWidth() {
			return $this->pob_width;
		}
		
		 function setWidth($val) {
			$this->pob_width = $val;
		}
		function getHeight() {
			return $this->pob_height;
		}
		
		 function setHeight($val) {
			$this->pob_height = $val;
		}
		function getInline() {
			return $this->pob_inline;
		}
		
		 function setInline($val) {
			$this->pob_inline = $val;
		}
		function getAjax() {
			return $this->pob_ajax;
		}
		
		 function setAjax($val) {
			$this->pob_ajax = $val;
		}
		function getRenderCondition() {
			return $this->pob_render_condition;
		}
		
		 function setRenderCondition($val) {
			$this->pob_render_condition = $val;
		}
		function getAutorefresh() {
			return $this->pob_autorefresh;
		}
		
		 function setAutorefresh($val) {
			$this->pob_autorefresh = $val;
		}

		function getPortletDefinitionId() {
			return $this->pob_pdf_id;
		}
		
		 function setPortletDefinitionId($val) {
			$this->pob_pdf_id = $val;
		}
		function getPortletObjectId() {
			return $this->pob_pob_id;
		}
		
		 function setPortletObjectId($val) {
			$this->pob_pob_id = $val;
		}

		function getDateCreated() {
			return $this->pob_date_created;
		}
		function getUsrCreatedId() {
			return $this->pob_usr_created_id;
		}
		function getDateModified() {
			return $this->pob_date_modified;
		}
		function getUsrModifiedId() {
			return $this->pob_usr_modified_id;
		}


		function getPdfId() {
			return $this->getPortletDefinitionId();
		}
		
		 function setPdfId($val) {
			$this->setPortletDefinitionId($val);
		}
		function getPobId() {
			return $this->getPortletObjectId();
		}
		
		 function setPobId($val) {
			$this->setPortletObjectId($val);
		}

		function getRenderConditionSnippet($wordCount) {
			if (is_null($this->getRenderCondition()) || trim($this->getRenderCondition()) == "") {
				return "";
			}
		  	return implode( 
			    '', 
		    	array_slice( 
		      		preg_split(
			        	'/([\s,\.;\?\!]+)/', 
		        		$this->getRenderCondition(), 
		        		$wordCount*2+1, 
		        		PREG_SPLIT_DELIM_CAPTURE
		      		),
		      		0,
		      		$wordCount*2-1
		    	)
		  	)."...";
		}
		function loadRecordFromRequest($rowId) {
			$this->pob_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('pob_showTitle_' . $this->pob_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->pob_show_title = null;
		} else {
			$this->pob_show_title = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('pob_customTitle_' . $this->pob_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->pob_custom_title = null;
		} else {
			$this->pob_custom_title = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('pob_left_' . $this->pob_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->pob_left = null;
		} else {
			$this->pob_left = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('pob_top_' . $this->pob_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->pob_top = null;
		} else {
			$this->pob_top = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('pob_width_' . $this->pob_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->pob_width = null;
		} else {
			$this->pob_width = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('pob_height_' . $this->pob_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->pob_height = null;
		} else {
			$this->pob_height = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('pob_inline_' . $this->pob_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->pob_inline = null;
		} else {
			$this->pob_inline = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('pob_ajax_' . $this->pob_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->pob_ajax = null;
		} else {
			$this->pob_ajax = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('pob_renderCondition_' . $this->pob_id);
	if (!is_null($tmpValue)) {
		if ($tmpValue == "") {
			$this->pob_render_condition = null;
		} else {
			$this->pob_render_condition = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('pob_autorefresh_' . $this->pob_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->pob_autorefresh = null;
		} else {
			$this->pob_autorefresh = $tmpValue;
		}
	}
			$this->pob_pdf_id = strval(R('pob_portletDefinition_' . $this->pob_id));
			$this->pob_pob_id = strval(R('pob_portletObject_' . $this->pob_id));
			$tmp_ids = R('pob_portletLocation_' . $this->pob_id, null); 			if (is_null($tmp_ids)) {
				$tmp_ids = array();
			}
			if (is_array($tmp_ids)) { 
				$this->_pageIdsToAddArray = $tmp_ids;
				$this->_pageIdsToDeleteArray = array();
				$currentConnections = $this->getPortletLocations();
				foreach ($currentConnections as $currentConnection) {
					if (in_array($currentConnection->getPageId(), $tmp_ids)) {
						foreach($this->_pageIdsToAddArray as $key => $value) {
							if ($value == $currentConnection->getPageId()) {
								unset($this->_pageIdsToAddArray[$key]);
							}
						}
						$this->_pageIdsToAddArray = array_values($this->_pageIdsToAddArray);
					} else {
						$this->_pageIdsToDeleteArray[] = $currentConnection->getPageId();
					}
				}
			}
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('pob_id_' . $_SESSION['current_portlet_object_id']);
			}
			if (is_null($rowId) || trim($rowId) == "") {
				$rowId = "";
			} else {
				$rowId = intval($rowId);
				$this->load((int)$rowId);
			}
			$this->loadRecordFromRequest($rowId);
		}		

		static function loadSearchFromRequest() {
			$criteriaPortletObject = array();	
			$criteriaFieldPortletObject = array();	
			$isNullPortletObject = R('virgo_search_showTitle_is_null');
			
			$criteriaFieldPortletObject["is_null"] = 0;
			if ($isNullPortletObject == "not_null") {
				$criteriaFieldPortletObject["is_null"] = 1;
			} elseif ($isNullPortletObject == "null") {
				$criteriaFieldPortletObject["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_showTitle');

//			if ($isSet) {
			$criteriaFieldPortletObject["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletObject["show_title"] = $criteriaFieldPortletObject;
			$criteriaFieldPortletObject = array();	
			$isNullPortletObject = R('virgo_search_customTitle_is_null');
			
			$criteriaFieldPortletObject["is_null"] = 0;
			if ($isNullPortletObject == "not_null") {
				$criteriaFieldPortletObject["is_null"] = 1;
			} elseif ($isNullPortletObject == "null") {
				$criteriaFieldPortletObject["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_customTitle');

//			if ($isSet) {
			$criteriaFieldPortletObject["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletObject["custom_title"] = $criteriaFieldPortletObject;
			$criteriaFieldPortletObject = array();	
			$isNullPortletObject = R('virgo_search_left_is_null');
			
			$criteriaFieldPortletObject["is_null"] = 0;
			if ($isNullPortletObject == "not_null") {
				$criteriaFieldPortletObject["is_null"] = 1;
			} elseif ($isNullPortletObject == "null") {
				$criteriaFieldPortletObject["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_left_from');
		$dataTypeCriteria["to"] = R('virgo_search_left_to');

//			if ($isSet) {
			$criteriaFieldPortletObject["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletObject["left"] = $criteriaFieldPortletObject;
			$criteriaFieldPortletObject = array();	
			$isNullPortletObject = R('virgo_search_top_is_null');
			
			$criteriaFieldPortletObject["is_null"] = 0;
			if ($isNullPortletObject == "not_null") {
				$criteriaFieldPortletObject["is_null"] = 1;
			} elseif ($isNullPortletObject == "null") {
				$criteriaFieldPortletObject["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_top_from');
		$dataTypeCriteria["to"] = R('virgo_search_top_to');

//			if ($isSet) {
			$criteriaFieldPortletObject["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletObject["top"] = $criteriaFieldPortletObject;
			$criteriaFieldPortletObject = array();	
			$isNullPortletObject = R('virgo_search_width_is_null');
			
			$criteriaFieldPortletObject["is_null"] = 0;
			if ($isNullPortletObject == "not_null") {
				$criteriaFieldPortletObject["is_null"] = 1;
			} elseif ($isNullPortletObject == "null") {
				$criteriaFieldPortletObject["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_width_from');
		$dataTypeCriteria["to"] = R('virgo_search_width_to');

//			if ($isSet) {
			$criteriaFieldPortletObject["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletObject["width"] = $criteriaFieldPortletObject;
			$criteriaFieldPortletObject = array();	
			$isNullPortletObject = R('virgo_search_height_is_null');
			
			$criteriaFieldPortletObject["is_null"] = 0;
			if ($isNullPortletObject == "not_null") {
				$criteriaFieldPortletObject["is_null"] = 1;
			} elseif ($isNullPortletObject == "null") {
				$criteriaFieldPortletObject["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_height_from');
		$dataTypeCriteria["to"] = R('virgo_search_height_to');

//			if ($isSet) {
			$criteriaFieldPortletObject["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletObject["height"] = $criteriaFieldPortletObject;
			$criteriaFieldPortletObject = array();	
			$isNullPortletObject = R('virgo_search_inline_is_null');
			
			$criteriaFieldPortletObject["is_null"] = 0;
			if ($isNullPortletObject == "not_null") {
				$criteriaFieldPortletObject["is_null"] = 1;
			} elseif ($isNullPortletObject == "null") {
				$criteriaFieldPortletObject["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_inline');

//			if ($isSet) {
			$criteriaFieldPortletObject["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletObject["inline"] = $criteriaFieldPortletObject;
			$criteriaFieldPortletObject = array();	
			$isNullPortletObject = R('virgo_search_ajax_is_null');
			
			$criteriaFieldPortletObject["is_null"] = 0;
			if ($isNullPortletObject == "not_null") {
				$criteriaFieldPortletObject["is_null"] = 1;
			} elseif ($isNullPortletObject == "null") {
				$criteriaFieldPortletObject["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_ajax');

//			if ($isSet) {
			$criteriaFieldPortletObject["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletObject["ajax"] = $criteriaFieldPortletObject;
			$criteriaFieldPortletObject = array();	
			$isNullPortletObject = R('virgo_search_renderCondition_is_null');
			
			$criteriaFieldPortletObject["is_null"] = 0;
			if ($isNullPortletObject == "not_null") {
				$criteriaFieldPortletObject["is_null"] = 1;
			} elseif ($isNullPortletObject == "null") {
				$criteriaFieldPortletObject["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_renderCondition');

//			if ($isSet) {
			$criteriaFieldPortletObject["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletObject["render_condition"] = $criteriaFieldPortletObject;
			$criteriaFieldPortletObject = array();	
			$isNullPortletObject = R('virgo_search_autorefresh_is_null');
			
			$criteriaFieldPortletObject["is_null"] = 0;
			if ($isNullPortletObject == "not_null") {
				$criteriaFieldPortletObject["is_null"] = 1;
			} elseif ($isNullPortletObject == "null") {
				$criteriaFieldPortletObject["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_autorefresh_from');
		$dataTypeCriteria["to"] = R('virgo_search_autorefresh_to');

//			if ($isSet) {
			$criteriaFieldPortletObject["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletObject["autorefresh"] = $criteriaFieldPortletObject;
			$criteriaParent = array();	
			$isNull = R('virgo_search_portletDefinition_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_portletDefinition', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaPortletObject["portlet_definition"] = $criteriaParent;
			$criteriaParent = array();	
			$isNull = R('virgo_search_portletObject_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_portletObject', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaPortletObject["portlet_object"] = $criteriaParent;
			$parent = R('virgo_search_page', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
				$criteriaPortletObject["page"] = $criteriaParent;
			}
			self::setCriteria($criteriaPortletObject);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_show_title');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterShowTitle', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterShowTitle', null);
			}
			$tableFilter = R('virgo_filter_custom_title');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterCustomTitle', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterCustomTitle', null);
			}
			$tableFilter = R('virgo_filter_left');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterLeft', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterLeft', null);
			}
			$tableFilter = R('virgo_filter_top');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterTop', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTop', null);
			}
			$tableFilter = R('virgo_filter_width');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterWidth', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterWidth', null);
			}
			$tableFilter = R('virgo_filter_height');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterHeight', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterHeight', null);
			}
			$tableFilter = R('virgo_filter_inline');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterInline', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterInline', null);
			}
			$tableFilter = R('virgo_filter_ajax');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterAjax', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterAjax', null);
			}
			$tableFilter = R('virgo_filter_render_condition');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterRenderCondition', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterRenderCondition', null);
			}
			$tableFilter = R('virgo_filter_autorefresh');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterAutorefresh', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterAutorefresh', null);
			}
			$parentFilter = R('virgo_filter_portlet_definition');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterPortletDefinition', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterPortletDefinition', null);
			}
			$parentFilter = R('virgo_filter_title_portlet_definition');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitlePortletDefinition', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitlePortletDefinition', null);
			}
			$parentFilter = R('virgo_filter_portlet_object');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterPortletObject', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterPortletObject', null);
			}
			$parentFilter = R('virgo_filter_title_portlet_object');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitlePortletObject', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitlePortletObject', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClausePortletObject = ' 1 = 1 ';
			if (P('form_only') == "3") {
				$pob = self::getMyPortletObject();
				$selectedMonth = $pob->getPortletSessionValue('selected_month', date("m"));
				$selectedYear = $pob->getPortletSessionValue('selected_year', date("Y"));
				$daysInfo = $pob->getPortletSessionValue('days_info', array());
				$tmpDay = getdate(mktime(0, 0, 0, $selectedMonth, 1, $selectedYear));
				$firstDay = $tmpDay;
				if ((int)$tmpDay["mon"] == 12) {
					$lastDay = getdate(strtotime($tmpDay["year"]+1 . "-" .  1 . "-" . (((int)$tmpDay["mday"])-1)));
				} else {
					$lastDay = getdate(strtotime($tmpDay["year"] . "-" .  (((int)$tmpDay["mon"])+1) . "-" . (((int)$tmpDay["mday"])-1)));
				}
				$eventColumn = "pob_" . P('event_column');
				$whereClausePortletObject = $whereClausePortletObject . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePortletObject = $whereClausePortletObject . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_portlet_definition');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_portlet_objects.pob_pdf_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portlet_objects.pob_pdf_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortletObject = $whereClausePortletObject . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_portlet_object');
			if (isset($limit) && trim($limit) != '') {
				if (strrpos($limit, "empty") !== false) {
					if (strrpos($limit, "empty,") === false) {
						$toRemove = "empty";
					} else {
						$toRemove = "empty,";
					}
					$limit = str_replace($toRemove, "", $limit);
					$includeNulls = true;
					$includeIns = (isset($limit) && trim($limit) != '');
				}
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_portlet_objects.pob_pob_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portlet_objects.pob_pob_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortletObject = $whereClausePortletObject . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaPortletObject = self::getCriteria();
			if (isset($criteriaPortletObject["show_title"])) {
				$fieldCriteriaShowTitle = $criteriaPortletObject["show_title"];
				if ($fieldCriteriaShowTitle["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_show_title IS NOT NULL ';
				} elseif ($fieldCriteriaShowTitle["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_show_title IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaShowTitle["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_portlet_objects.pob_show_title = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaPortletObject["custom_title"])) {
				$fieldCriteriaCustomTitle = $criteriaPortletObject["custom_title"];
				if ($fieldCriteriaCustomTitle["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_custom_title IS NOT NULL ';
				} elseif ($fieldCriteriaCustomTitle["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_custom_title IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaCustomTitle["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_objects.pob_custom_title like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortletObject["left"])) {
				$fieldCriteriaLeft = $criteriaPortletObject["left"];
				if ($fieldCriteriaLeft["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_left IS NOT NULL ';
				} elseif ($fieldCriteriaLeft["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_left IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaLeft["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_portlet_objects.pob_left = ? ";
				} else {
					$filter = $filter . " AND prt_portlet_objects.pob_left >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_portlet_objects.pob_left <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPortletObject["top"])) {
				$fieldCriteriaTop = $criteriaPortletObject["top"];
				if ($fieldCriteriaTop["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_top IS NOT NULL ';
				} elseif ($fieldCriteriaTop["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_top IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaTop["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_portlet_objects.pob_top = ? ";
				} else {
					$filter = $filter . " AND prt_portlet_objects.pob_top >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_portlet_objects.pob_top <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPortletObject["width"])) {
				$fieldCriteriaWidth = $criteriaPortletObject["width"];
				if ($fieldCriteriaWidth["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_width IS NOT NULL ';
				} elseif ($fieldCriteriaWidth["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_width IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaWidth["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_portlet_objects.pob_width = ? ";
				} else {
					$filter = $filter . " AND prt_portlet_objects.pob_width >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_portlet_objects.pob_width <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPortletObject["height"])) {
				$fieldCriteriaHeight = $criteriaPortletObject["height"];
				if ($fieldCriteriaHeight["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_height IS NOT NULL ';
				} elseif ($fieldCriteriaHeight["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_height IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaHeight["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_portlet_objects.pob_height = ? ";
				} else {
					$filter = $filter . " AND prt_portlet_objects.pob_height >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_portlet_objects.pob_height <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPortletObject["inline"])) {
				$fieldCriteriaInline = $criteriaPortletObject["inline"];
				if ($fieldCriteriaInline["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_inline IS NOT NULL ';
				} elseif ($fieldCriteriaInline["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_inline IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaInline["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_portlet_objects.pob_inline = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaPortletObject["ajax"])) {
				$fieldCriteriaAjax = $criteriaPortletObject["ajax"];
				if ($fieldCriteriaAjax["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_ajax IS NOT NULL ';
				} elseif ($fieldCriteriaAjax["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_ajax IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaAjax["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_portlet_objects.pob_ajax = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaPortletObject["render_condition"])) {
				$fieldCriteriaRenderCondition = $criteriaPortletObject["render_condition"];
				if ($fieldCriteriaRenderCondition["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_render_condition IS NOT NULL ';
				} elseif ($fieldCriteriaRenderCondition["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_render_condition IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaRenderCondition["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_objects.pob_render_condition like ? ";
				$types .= "s";
				$values[] = $condition;				
			}
				}
			}
			if (isset($criteriaPortletObject["autorefresh"])) {
				$fieldCriteriaAutorefresh = $criteriaPortletObject["autorefresh"];
				if ($fieldCriteriaAutorefresh["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_autorefresh IS NOT NULL ';
				} elseif ($fieldCriteriaAutorefresh["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_autorefresh IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaAutorefresh["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_portlet_objects.pob_autorefresh = ? ";
				} else {
					$filter = $filter . " AND prt_portlet_objects.pob_autorefresh >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_portlet_objects.pob_autorefresh <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPortletObject["portlet_definition"])) {
				$parentCriteria = $criteriaPortletObject["portlet_definition"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pob_pdf_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portlet_objects.pob_pdf_id IN (SELECT pdf_id FROM prt_portlet_definitions WHERE pdf_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPortletObject["portlet_object"])) {
				$parentCriteria = $criteriaPortletObject["portlet_object"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pob_pob_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portlet_objects.pob_pob_id IN (SELECT pob_id FROM prt_portlet_objects WHERE pob_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPortletObject["page"])) {
				$parentCriteria = $criteriaPortletObject["page"];
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$filter = $filter . " AND prt_portlet_objects.pob_id IN (SELECT second_parent.plc_pob_id FROM prt_portlet_locations AS second_parent WHERE second_parent.plc_pge_id IN (" . implode(", ", $parentIds) . ")) ";
				}
			}
			$whereClausePortletObject = $whereClausePortletObject . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClausePortletObject = $whereClausePortletObject . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClausePortletObject = $whereClausePortletObject . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterShowTitle', null);
				if (S($tableFilter)) {
					$whereClausePortletObject = $whereClausePortletObject . " AND pob_show_title LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterCustomTitle', null);
				if (S($tableFilter)) {
					$whereClausePortletObject = $whereClausePortletObject . " AND pob_custom_title LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterLeft', null);
				if (S($tableFilter)) {
					$whereClausePortletObject = $whereClausePortletObject . " AND pob_left LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterTop', null);
				if (S($tableFilter)) {
					$whereClausePortletObject = $whereClausePortletObject . " AND pob_top LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterWidth', null);
				if (S($tableFilter)) {
					$whereClausePortletObject = $whereClausePortletObject . " AND pob_width LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterHeight', null);
				if (S($tableFilter)) {
					$whereClausePortletObject = $whereClausePortletObject . " AND pob_height LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterInline', null);
				if (S($tableFilter)) {
					$whereClausePortletObject = $whereClausePortletObject . " AND pob_inline LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterAjax', null);
				if (S($tableFilter)) {
					$whereClausePortletObject = $whereClausePortletObject . " AND pob_ajax LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterRenderCondition', null);
				if (S($tableFilter)) {
					$whereClausePortletObject = $whereClausePortletObject . " AND pob_render_condition LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterAutorefresh', null);
				if (S($tableFilter)) {
					$whereClausePortletObject = $whereClausePortletObject . " AND pob_autorefresh LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterPortletDefinition', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePortletObject = $whereClausePortletObject . " AND pob_pdf_id IS NULL ";
					} else {
						$whereClausePortletObject = $whereClausePortletObject . " AND pob_pdf_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitlePortletDefinition', null);
				if (S($parentFilter)) {
					$whereClausePortletObject = $whereClausePortletObject . " AND prt_portlet_definitions_parent.pdf_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterPortletObject', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePortletObject = $whereClausePortletObject . " AND pob_pob_id IS NULL ";
					} else {
						$whereClausePortletObject = $whereClausePortletObject . " AND pob_pob_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitlePortletObject', null);
				if (S($parentFilter)) {
					$whereClausePortletObject = $whereClausePortletObject . " AND prt_portlet_objects_parent.pob_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClausePortletObject;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClausePortletObject = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_portlet_objects.pob_id, prt_portlet_objects.pob_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_show_title', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_show_title pob_show_title";
			} else {
				if ($defaultOrderColumn == "pob_show_title") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_show_title ";
				}
			}
			if (P('show_table_custom_title', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_custom_title pob_custom_title";
			} else {
				if ($defaultOrderColumn == "pob_custom_title") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_custom_title ";
				}
			}
			if (P('show_table_left', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_left pob_left";
			} else {
				if ($defaultOrderColumn == "pob_left") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_left ";
				}
			}
			if (P('show_table_top', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_top pob_top";
			} else {
				if ($defaultOrderColumn == "pob_top") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_top ";
				}
			}
			if (P('show_table_width', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_width pob_width";
			} else {
				if ($defaultOrderColumn == "pob_width") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_width ";
				}
			}
			if (P('show_table_height', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_height pob_height";
			} else {
				if ($defaultOrderColumn == "pob_height") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_height ";
				}
			}
			if (P('show_table_inline', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_inline pob_inline";
			} else {
				if ($defaultOrderColumn == "pob_inline") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_inline ";
				}
			}
			if (P('show_table_ajax', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_ajax pob_ajax";
			} else {
				if ($defaultOrderColumn == "pob_ajax") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_ajax ";
				}
			}
			if (P('show_table_render_condition', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_render_condition pob_render_condition";
			} else {
				if ($defaultOrderColumn == "pob_render_condition") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_render_condition ";
				}
			}
			if (P('show_table_autorefresh', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_autorefresh pob_autorefresh";
			} else {
				if ($defaultOrderColumn == "pob_autorefresh") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_autorefresh ";
				}
			}
			if (class_exists('portal\virgoPortletDefinition') && P('show_table_portlet_definition', "1") != "0") { // */ && !in_array("pdf", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_objects.pob_pdf_id as pob_pdf_id ";
				$queryString = $queryString . ", prt_portlet_definitions_parent.pdf_virgo_title as `portlet_definition` ";
			} else {
				if ($defaultOrderColumn == "portlet_definition") {
					$orderColumnNotDisplayed = " prt_portlet_definitions_parent.pdf_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_table_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_objects.pob_pob_id as pob_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portlet_objects ";
			if (class_exists('portal\virgoPortletDefinition')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_definitions AS prt_portlet_definitions_parent ON (prt_portlet_objects.pob_pdf_id = prt_portlet_definitions_parent.pdf_id) ";
			}
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_portlet_objects.pob_pob_id = prt_portlet_objects_parent.pob_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClausePortletObject = $whereClausePortletObject . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClausePortletObject, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClausePortletObject,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_portlet_objects"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " pob_usr_created_id = '" . virgoUser::getUserId() . "' ";
				if ($where == '') {
					$where = $privateCondition;
				} else {
					$where = $where . " AND " . $privateCondition;
				}
			}			
			if (false) { //$componentParams->get('only_records_in_valid_range') == "1") {
				$rangeCondition = "";
           				if ($rangeCondition != "") {
					if ($where == '') {
						$where = $rangeCondition;
					} else {
						$where = $where . " AND " . $rangeCondition;
					}
				}
			}			
			if ($where != '') {
				$query = $query . " WHERE " . $where . " ";
			}
			if ($orderBy != '') {
				$query = $query . " ORDER BY  " . $orderBy . " ";
			}
			return self::internalSelect($query, null, $types, $values);
		}
		
		function select($showPage, $showRows, $orderColumn, $orderMode, $where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " pob_usr_created_id = ? ";
				if ($where == '') {
					$where = $privateCondition;
				} else {
					$where = $where . " AND " . $privateCondition;
				}
				$types .= "i";
				$values[] = virgoUser::getUserId();
			}			
			if (false) { //$componentParams->get('only_records_in_valid_range') == "1") {
				$rangeCondition = "";
           				if ($rangeCondition != "") {
					if ($where == '') {
						$where = $rangeCondition;
					} else {
						$where = $where . " AND " . $rangeCondition;
					}
				}
			}			
			if ($queryString == '') {
				$query = "SELECT * "
				. "\n FROM prt_portlet_objects"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_portlet_objects ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_portlet_objects ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, pob_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " pob_usr_created_id = ? ";
				if ($where == '') {
					$where = $privateCondition;
				} else {
					$where = $where . " AND " . $privateCondition;
				}
				$types .= "i";
				$values[] = virgoUser::getUserId();
			}
			if (false) { //$componentParams->get('only_records_in_valid_range') == "1") {
				$rangeCondition = "";
           				if ($rangeCondition != "") {
					if ($where == '') {
						$where = $rangeCondition;
					} else {
						$where = $where . " AND " . $rangeCondition;
					}
				}
			}			
			if ($queryString == '') {
				$query = "SELECT COUNT(pob_id) cnt FROM portlet_objects";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as portlet_objects ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as portlet_objects ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoPortletObject();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_portlet_objects WHERE pob_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->pob_id = $row['pob_id'];
$this->pob_show_title = $row['pob_show_title'];
$this->pob_custom_title = $row['pob_custom_title'];
$this->pob_left = $row['pob_left'];
$this->pob_top = $row['pob_top'];
$this->pob_width = $row['pob_width'];
$this->pob_height = $row['pob_height'];
$this->pob_inline = $row['pob_inline'];
$this->pob_ajax = $row['pob_ajax'];
$this->pob_render_condition = $row['pob_render_condition'];
$this->pob_autorefresh = $row['pob_autorefresh'];
						$this->pob_pdf_id = $row['pob_pdf_id'];
						$this->pob_pob_id = $row['pob_pob_id'];
						if ($fetchUsernames) {
							if ($row['pob_date_created']) {
								if ($row['pob_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['pob_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['pob_date_modified']) {
								if ($row['pob_usr_modified_id'] == $row['pob_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['pob_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['pob_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->pob_date_created = $row['pob_date_created'];
						$this->pob_usr_created_id = $fetchUsernames ? $createdBy : $row['pob_usr_created_id'];
						$this->pob_date_modified = $row['pob_date_modified'];
						$this->pob_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['pob_usr_modified_id'];
						$this->pob_virgo_title = $row['pob_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_portlet_objects SET pob_usr_created_id = {$userId} WHERE pob_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->pob_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoPortletObject::selectAllAsObjectsStatic('pob_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->pob_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->pob_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('pob_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_pob = new virgoPortletObject();
				$tmp_pob->load((int)$lookup_id);
				return $tmp_pob->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoPortletObject');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" pob_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoPortletObject', "10");
				if ($sizeOf > $maxListLabelSize) {
					echo json_encode(array(array("id" => '', "title" => T('RESULTS') . ": $sizeOf.")));
					return;
				}
				echo json_encode($resultsLabels);
			}
		}

		function printVirgoListMatched($match, $fieldName) {
$this->printVirgoListMatchedInternal($match, $fieldName);
		}
		
		static function getVirgoListSize($where = '') {
			return self::getVirgoList($where = '', true);
		}

		static function getVirgoList($where = '', $sizeOnly = false, $hash = false) {
			$query = " SELECT ";
			if ($sizeOnly) {
				$query = $query . " COUNT(*) AS CNT ";
			} else {
				$query = $query . " pob_id as id, pob_virgo_title as title ";
			}
			$query = $query . " FROM prt_portlet_objects ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoPortletObject', 'portal') == "1") {
				$privateCondition = " pob_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY pob_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resPortletObject = array();
				foreach ($rows as $row) {
					$resPortletObject[$row['id']] = $row['title'];
				}
				return $resPortletObject;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticPortletObject = new virgoPortletObject();
			return $staticPortletObject->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getPortletDefinitionStatic($parentId) {
			return virgoPortletDefinition::getById($parentId);
		}
		
		function getPortletDefinition() {
			return virgoPortletObject::getPortletDefinitionStatic($this->pob_pdf_id);
		}
		static function getPortletObjectStatic($parentId) {
			return virgoPortletObject::getById($parentId);
		}
		
		function getPortletObject() {
			return virgoPortletObject::getPortletObjectStatic($this->pob_pob_id);
		}

		static function getPortletLocationsStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resPortletLocation = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletLocation'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resPortletLocation;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resPortletLocation;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsPortletLocation = virgoPortletLocation::selectAll('plc_pob_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPortletLocation as $resultPortletLocation) {
				$tmpPortletLocation = virgoPortletLocation::getById($resultPortletLocation['plc_id']); 
				array_push($resPortletLocation, $tmpPortletLocation);
			}
			return $resPortletLocation;
		}

		function getPortletLocations($orderBy = '', $extraWhere = null) {
			return virgoPortletObject::getPortletLocationsStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getHtmlContentsStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resHtmlContent = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoHtmlContent'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resHtmlContent;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resHtmlContent;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsHtmlContent = virgoHtmlContent::selectAll('hcn_pob_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsHtmlContent as $resultHtmlContent) {
				$tmpHtmlContent = virgoHtmlContent::getById($resultHtmlContent['hcn_id']); 
				array_push($resHtmlContent, $tmpHtmlContent);
			}
			return $resHtmlContent;
		}

		function getHtmlContents($orderBy = '', $extraWhere = null) {
			return virgoPortletObject::getHtmlContentsStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getPortletParametersStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resPortletParameter = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletParameter'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resPortletParameter;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resPortletParameter;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsPortletParameter = virgoPortletParameter::selectAll('ppr_pob_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPortletParameter as $resultPortletParameter) {
				$tmpPortletParameter = virgoPortletParameter::getById($resultPortletParameter['ppr_id']); 
				array_push($resPortletParameter, $tmpPortletParameter);
			}
			return $resPortletParameter;
		}

		function getPortletParameters($orderBy = '', $extraWhere = null) {
			return virgoPortletObject::getPortletParametersStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getPermissionsStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resPermission = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPermission'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resPermission;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resPermission;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsPermission = virgoPermission::selectAll('prm_pob_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPermission as $resultPermission) {
				$tmpPermission = virgoPermission::getById($resultPermission['prm_id']); 
				array_push($resPermission, $tmpPermission);
			}
			return $resPermission;
		}

		function getPermissions($orderBy = '', $extraWhere = null) {
			return virgoPortletObject::getPermissionsStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getPortletObjectsStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resPortletObject = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resPortletObject;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resPortletObject;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsPortletObject = virgoPortletObject::selectAll('pob_pob_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPortletObject as $resultPortletObject) {
				$tmpPortletObject = virgoPortletObject::getById($resultPortletObject['pob_id']); 
				array_push($resPortletObject, $tmpPortletObject);
			}
			return $resPortletObject;
		}

		function getPortletObjects($orderBy = '', $extraWhere = null) {
			return virgoPortletObject::getPortletObjectsStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_show_title_obligatory', "0") == "1") {
				if (
(is_null($this->getShowTitle()) || trim($this->getShowTitle()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'SHOW_TITLE');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_custom_title_obligatory', "0") == "1") {
				if (
(is_null($this->getCustomTitle()) || trim($this->getCustomTitle()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'CUSTOM_TITLE');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_left_obligatory', "0") == "1") {
				if (
(is_null($this->getLeft()) || trim($this->getLeft()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'LEFT');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_top_obligatory', "0") == "1") {
				if (
(is_null($this->getTop()) || trim($this->getTop()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'TOP');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_width_obligatory', "0") == "1") {
				if (
(is_null($this->getWidth()) || trim($this->getWidth()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'WIDTH');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_height_obligatory', "0") == "1") {
				if (
(is_null($this->getHeight()) || trim($this->getHeight()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'HEIGHT');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_inline_obligatory', "0") == "1") {
				if (
(is_null($this->getInline()) || trim($this->getInline()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'INLINE');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_ajax_obligatory', "0") == "1") {
				if (
(is_null($this->getAjax()) || trim($this->getAjax()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'AJAX');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_render_condition_obligatory', "0") == "1") {
				if (
(is_null($this->getRenderCondition()) || trim($this->getRenderCondition()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'RENDER_CONDITION');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_autorefresh_obligatory', "0") == "1") {
				if (
(is_null($this->getAutorefresh()) || trim($this->getAutorefresh()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'AUTOREFRESH');
				}			
			}
				if (is_null($this->pob_pdf_id) || trim($this->pob_pdf_id) == "") {
					if (R('create_pob_portletDefinition_' . $this->pob_id) == "1") { 
						$parent = new virgoPortletDefinition();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->pob_pdf_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'PORTLET_DEFINITION', '');
					}
			}			
			$tmpMode = (is_null($this->getId()) ? "create" : "form");
			if (P('show_'.$tmpMode.'_portlet_object_obligatory', "0") == "1") {
				if (is_null($this->pob_pob_id) || trim($this->pob_pob_id) == "") {
					if (R('create_pob_portletObject_' . $this->pob_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'PORTLET_OBJECT', '');
					}
				}
			}			
 			if (!is_null($this->pob_left) && trim($this->pob_left) != "") {
				if (!is_numeric($this->pob_left)) {
					return T('INCORRECT_NUMBER', 'LEFT', $this->pob_left);
				}
			}
			if (!is_null($this->pob_top) && trim($this->pob_top) != "") {
				if (!is_numeric($this->pob_top)) {
					return T('INCORRECT_NUMBER', 'TOP', $this->pob_top);
				}
			}
			if (!is_null($this->pob_width) && trim($this->pob_width) != "") {
				if (!is_numeric($this->pob_width)) {
					return T('INCORRECT_NUMBER', 'WIDTH', $this->pob_width);
				}
			}
			if (!is_null($this->pob_height) && trim($this->pob_height) != "") {
				if (!is_numeric($this->pob_height)) {
					return T('INCORRECT_NUMBER', 'HEIGHT', $this->pob_height);
				}
			}
			if (!is_null($this->pob_autorefresh) && trim($this->pob_autorefresh) != "") {
				if (!is_numeric($this->pob_autorefresh)) {
					return T('INCORRECT_NUMBER', 'AUTOREFRESH', $this->pob_autorefresh);
				}
			}
		$types = "";
		$values = array();
		$skipUniquenessCheck = false;
			return "";
		}

				
		function beforeStore($virgoOld) {
			return "";
		}		
		
		function afterStore($virgoOld) {
			return "";
		}
		
		function beforeDelete() {
			return "";
		}

		function afterDelete() {
			return "";
		}
		
		function getCurrentRevision() {
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_portlet_objects WHERE pob_id = " . $this->getId();
	$result = QL($query);
			return $result[0];
		}
		
		function storeRecordChange($virgoOld, $user) {
			$ip = $_SERVER['REMOTE_ADDR'];
			$username = $user->getUsername();
			$user_id = $user->getId();
			$new_revision = $this->getCurrentRevision() + 1;
			if ($new_revision == 1 && !is_null($virgoOld)) {
				$colNames = "";
				$values = "";
				$objectToStore = $virgoOld;
				$colNames = $colNames . ", pob_show_title";
				$values = $values . ", " . (is_null($objectToStore->getShowTitle()) ? "null" : "'" . QE($objectToStore->getShowTitle()) . "'");
				$colNames = $colNames . ", pob_custom_title";
				$values = $values . ", " . (is_null($objectToStore->getCustomTitle()) ? "null" : "'" . QE($objectToStore->getCustomTitle()) . "'");
				$colNames = $colNames . ", pob_left";
				$values = $values . ", " . (is_null($objectToStore->getLeft()) ? "null" : "'" . QE($objectToStore->getLeft()) . "'");
				$colNames = $colNames . ", pob_top";
				$values = $values . ", " . (is_null($objectToStore->getTop()) ? "null" : "'" . QE($objectToStore->getTop()) . "'");
				$colNames = $colNames . ", pob_width";
				$values = $values . ", " . (is_null($objectToStore->getWidth()) ? "null" : "'" . QE($objectToStore->getWidth()) . "'");
				$colNames = $colNames . ", pob_height";
				$values = $values . ", " . (is_null($objectToStore->getHeight()) ? "null" : "'" . QE($objectToStore->getHeight()) . "'");
				$colNames = $colNames . ", pob_inline";
				$values = $values . ", " . (is_null($objectToStore->getInline()) ? "null" : "'" . QE($objectToStore->getInline()) . "'");
				$colNames = $colNames . ", pob_ajax";
				$values = $values . ", " . (is_null($objectToStore->getAjax()) ? "null" : "'" . QE($objectToStore->getAjax()) . "'");
				$colNames = $colNames . ", pob_render_condition";
				$values = $values . ", " . (is_null($objectToStore->getRenderCondition()) ? "null" : "'" . QE($objectToStore->getRenderCondition()) . "'");
				$colNames = $colNames . ", pob_autorefresh";
				$values = $values . ", " . (is_null($objectToStore->getAutorefresh()) ? "null" : "'" . QE($objectToStore->getAutorefresh()) . "'");
				$colNames = $colNames . ", pob_pdf_id";
				$values = $values . ", " . (is_null($objectToStore->getPdfId()) || $objectToStore->getPdfId() == "" ? "null" : $objectToStore->getPdfId());
				$colNames = $colNames . ", pob_pob_id";
				$values = $values . ", " . (is_null($objectToStore->getPobId()) || $objectToStore->getPobId() == "" ? "null" : $objectToStore->getPobId());
				$query = "INSERT INTO prt_history_portlet_objects (revision, ip, username, user_id, timestamp, pob_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getShowTitle() != $objectToStore->getShowTitle()) {
				if (is_null($objectToStore->getShowTitle())) {
					$nullifiedProperties = $nullifiedProperties . "show_title,";
				} else {
				$colNames = $colNames . ", pob_show_title";
				$values = $values . ", " . (is_null($objectToStore->getShowTitle()) ? "null" : "'" . QE($objectToStore->getShowTitle()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getCustomTitle() != $objectToStore->getCustomTitle()) {
				if (is_null($objectToStore->getCustomTitle())) {
					$nullifiedProperties = $nullifiedProperties . "custom_title,";
				} else {
				$colNames = $colNames . ", pob_custom_title";
				$values = $values . ", " . (is_null($objectToStore->getCustomTitle()) ? "null" : "'" . QE($objectToStore->getCustomTitle()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getLeft() != $objectToStore->getLeft()) {
				if (is_null($objectToStore->getLeft())) {
					$nullifiedProperties = $nullifiedProperties . "left,";
				} else {
				$colNames = $colNames . ", pob_left";
				$values = $values . ", " . (is_null($objectToStore->getLeft()) ? "null" : "'" . QE($objectToStore->getLeft()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getTop() != $objectToStore->getTop()) {
				if (is_null($objectToStore->getTop())) {
					$nullifiedProperties = $nullifiedProperties . "top,";
				} else {
				$colNames = $colNames . ", pob_top";
				$values = $values . ", " . (is_null($objectToStore->getTop()) ? "null" : "'" . QE($objectToStore->getTop()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getWidth() != $objectToStore->getWidth()) {
				if (is_null($objectToStore->getWidth())) {
					$nullifiedProperties = $nullifiedProperties . "width,";
				} else {
				$colNames = $colNames . ", pob_width";
				$values = $values . ", " . (is_null($objectToStore->getWidth()) ? "null" : "'" . QE($objectToStore->getWidth()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getHeight() != $objectToStore->getHeight()) {
				if (is_null($objectToStore->getHeight())) {
					$nullifiedProperties = $nullifiedProperties . "height,";
				} else {
				$colNames = $colNames . ", pob_height";
				$values = $values . ", " . (is_null($objectToStore->getHeight()) ? "null" : "'" . QE($objectToStore->getHeight()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getInline() != $objectToStore->getInline()) {
				if (is_null($objectToStore->getInline())) {
					$nullifiedProperties = $nullifiedProperties . "inline,";
				} else {
				$colNames = $colNames . ", pob_inline";
				$values = $values . ", " . (is_null($objectToStore->getInline()) ? "null" : "'" . QE($objectToStore->getInline()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getAjax() != $objectToStore->getAjax()) {
				if (is_null($objectToStore->getAjax())) {
					$nullifiedProperties = $nullifiedProperties . "ajax,";
				} else {
				$colNames = $colNames . ", pob_ajax";
				$values = $values . ", " . (is_null($objectToStore->getAjax()) ? "null" : "'" . QE($objectToStore->getAjax()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getRenderCondition() != $objectToStore->getRenderCondition()) {
				if (is_null($objectToStore->getRenderCondition())) {
					$nullifiedProperties = $nullifiedProperties . "render_condition,";
				} else {
				$colNames = $colNames . ", pob_render_condition";
				$values = $values . ", " . (is_null($objectToStore->getRenderCondition()) ? "null" : "'" . QE($objectToStore->getRenderCondition()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getAutorefresh() != $objectToStore->getAutorefresh()) {
				if (is_null($objectToStore->getAutorefresh())) {
					$nullifiedProperties = $nullifiedProperties . "autorefresh,";
				} else {
				$colNames = $colNames . ", pob_autorefresh";
				$values = $values . ", " . (is_null($objectToStore->getAutorefresh()) ? "null" : "'" . QE($objectToStore->getAutorefresh()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getPdfId() != $objectToStore->getPdfId() && ($virgoOld->getPdfId() != 0 || $objectToStore->getPdfId() != ""))) { 
				$colNames = $colNames . ", pob_pdf_id";
				$values = $values . ", " . (is_null($objectToStore->getPdfId()) ? "null" : ($objectToStore->getPdfId() == "" ? "0" : $objectToStore->getPdfId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getPobId() != $objectToStore->getPobId() && ($virgoOld->getPobId() != 0 || $objectToStore->getPobId() != ""))) { 
				$colNames = $colNames . ", pob_pob_id";
				$values = $values . ", " . (is_null($objectToStore->getPobId()) ? "null" : ($objectToStore->getPobId() == "" ? "0" : $objectToStore->getPobId()));
			}
			$query = "INSERT INTO prt_history_portlet_objects (revision, ip, username, user_id, timestamp, pob_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_portlet_objects");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'pob_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_portlet_objects ADD COLUMN (pob_virgo_title VARCHAR(255));";
			Q($query);
			$this->fillVirgoTitles();
		}
		
		var $_error = null;
		
		function getError() {
			return $this->_error;
		}
		
		function parentStore($updateNulls = false, $log = false) {
			$types = "";
			$values = array();
			if (isset($this->pob_id) && $this->pob_id != "") {
				$query = "UPDATE prt_portlet_objects SET ";
			if (isset($this->pob_show_title)) {
				$query .= " pob_show_title = ? ,";
				$types .= "s";
				$values[] = $this->pob_show_title;
			} else {
				$query .= " pob_show_title = NULL ,";				
			}
			if (isset($this->pob_custom_title)) {
				$query .= " pob_custom_title = ? ,";
				$types .= "s";
				$values[] = $this->pob_custom_title;
			} else {
				$query .= " pob_custom_title = NULL ,";				
			}
			if (isset($this->pob_left)) {
				$query .= " pob_left = ? ,";
				$types .= "i";
				$values[] = $this->pob_left;
			} else {
				$query .= " pob_left = NULL ,";				
			}
			if (isset($this->pob_top)) {
				$query .= " pob_top = ? ,";
				$types .= "i";
				$values[] = $this->pob_top;
			} else {
				$query .= " pob_top = NULL ,";				
			}
			if (isset($this->pob_width)) {
				$query .= " pob_width = ? ,";
				$types .= "i";
				$values[] = $this->pob_width;
			} else {
				$query .= " pob_width = NULL ,";				
			}
			if (isset($this->pob_height)) {
				$query .= " pob_height = ? ,";
				$types .= "i";
				$values[] = $this->pob_height;
			} else {
				$query .= " pob_height = NULL ,";				
			}
			if (isset($this->pob_inline)) {
				$query .= " pob_inline = ? ,";
				$types .= "s";
				$values[] = $this->pob_inline;
			} else {
				$query .= " pob_inline = NULL ,";				
			}
			if (isset($this->pob_ajax)) {
				$query .= " pob_ajax = ? ,";
				$types .= "s";
				$values[] = $this->pob_ajax;
			} else {
				$query .= " pob_ajax = NULL ,";				
			}
			if (isset($this->pob_render_condition)) {
				$query .= " pob_render_condition = ? ,";
				$types .= "s";
				$values[] = $this->pob_render_condition;
			} else {
				$query .= " pob_render_condition = NULL ,";				
			}
			if (isset($this->pob_autorefresh)) {
				$query .= " pob_autorefresh = ? ,";
				$types .= "i";
				$values[] = $this->pob_autorefresh;
			} else {
				$query .= " pob_autorefresh = NULL ,";				
			}
				if (isset($this->pob_pdf_id) && trim($this->pob_pdf_id) != "") {
					$query = $query . " pob_pdf_id = ? , ";
					$types = $types . "i";
					$values[] = $this->pob_pdf_id;
				} else {
					$query = $query . " pob_pdf_id = NULL, ";
				}
				if (isset($this->pob_pob_id) && trim($this->pob_pob_id) != "") {
					$query = $query . " pob_pob_id = ? , ";
					$types = $types . "i";
					$values[] = $this->pob_pob_id;
				} else {
					$query = $query . " pob_pob_id = NULL, ";
				}
				$query = $query . " pob_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " pob_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->pob_date_modified;

				$query = $query . " pob_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->pob_usr_modified_id;

				$query = $query . " WHERE pob_id = ? ";
				$types = $types . "i";
				$values[] = $this->pob_id;
			} else {
				$query = "INSERT INTO prt_portlet_objects ( ";
			$query = $query . " pob_show_title, ";
			$query = $query . " pob_custom_title, ";
			$query = $query . " pob_left, ";
			$query = $query . " pob_top, ";
			$query = $query . " pob_width, ";
			$query = $query . " pob_height, ";
			$query = $query . " pob_inline, ";
			$query = $query . " pob_ajax, ";
			$query = $query . " pob_render_condition, ";
			$query = $query . " pob_autorefresh, ";
				$query = $query . " pob_pdf_id, ";
				$query = $query . " pob_pob_id, ";
				$query = $query . " pob_virgo_title, pob_date_created, pob_usr_created_id) VALUES ( ";
			if (isset($this->pob_show_title)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->pob_show_title;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pob_custom_title)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->pob_custom_title;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pob_left)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->pob_left;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pob_top)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->pob_top;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pob_width)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->pob_width;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pob_height)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->pob_height;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pob_inline)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->pob_inline;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pob_ajax)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->pob_ajax;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pob_render_condition)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->pob_render_condition;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pob_autorefresh)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->pob_autorefresh;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->pob_pdf_id) && trim($this->pob_pdf_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->pob_pdf_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->pob_pob_id) && trim($this->pob_pob_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->pob_pob_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->pob_date_created;
				$values[] = $this->pob_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->pob_id) || $this->pob_id == "") {
					$this->pob_id = QID();
				}
				if ($log) {
					L("portlet object stored successfully", "id = {$this->pob_id}", "TRACE");
				}
				return true;
			}
		}
		

		static function addPageStatic($thisId, $id) {
			$query = " SELECT COUNT(plc_id) AS cnt FROM prt_portlet_locations WHERE plc_pob_id = {$thisId} AND plc_pge_id = {$id} ";
			$res = Q1($query);
			if ($res == 0) {
				$newPortletLocation = new virgoPortletLocation();
				$newPortletLocation->setPageId($id);
				$newPortletLocation->setPortletObjectId($thisId);
				return $newPortletLocation->store();
			}			
			return "";
		}
		
		function addPage($id) {
			return virgoPortletObject::addPageStatic($this->getId(), $id);
		}
		
		static function removePageStatic($thisId, $id) {
			$query = " SELECT plc_id AS id FROM prt_portlet_locations WHERE plc_pob_id = {$thisId} AND plc_pge_id = {$id} ";
			$res = QR($query);
			foreach ($res as $re) {
				$newPortletLocation = new virgoPortletLocation($re['id']);
				return $newPortletLocation->delete();
			}			
			return "";
		}
		
		function removePage($id) {
			return virgoPortletObject::removePageStatic($this->getId(), $id);
		}
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->pob_id) {
				$virgoOld = new virgoPortletObject($this->pob_id);
			}
			$validationMessageText = $this->beforeStore($virgoOld);
			if (!is_null($validationMessageText) && trim($validationMessageText) != "") {
				$this->logError('Before store failed for id = ' . $this->getId() . ": " . $validationMessageText);
				return trim($validationMessageText);				
			} else {
				$validationMessageText = $this->validateObject($virgoOld);
				if (!is_null($validationMessageText) && trim($validationMessageText) != "") {
					$this->logWarn('Validation failed for id = ' . $this->getId() . ": " . $validationMessageText);
					return trim($validationMessageText);				
				} else {
					$userId = virgoUser::getUserId();			
					if ($this->pob_id) {			
						$this->pob_date_modified = date("Y-m-d H:i:s");
						$this->pob_usr_modified_id = $userId;
					} else {
						$this->pob_date_created = date("Y-m-d H:i:s");
						$this->pob_usr_created_id = $userId;
					}
					$this->pob_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "portlet object" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "portlet object" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
						}
					}
					if (!is_null($this->_pageIdsToAddArray)) {
						foreach ($this->_pageIdsToAddArray as $pageId) {
							$ret = $this->addPage((int)$pageId);
							if ($ret != "") {
								L($ret, '', 'ERROR');
							}
						}
					}
					if (!is_null($this->_pageIdsToDeleteArray)) {
						foreach ($this->_pageIdsToDeleteArray as $pageId) {
							$ret = $this->removePage((int)$pageId);
							if ($ret != "") {
								L($ret, '', 'ERROR');
							}
						}
					}
					$ret = $this->afterStore($virgoOld);
					if (isset($ret) && $ret != "") {
						return $ret;
					}

				}
			}
			return "";
		}

		
		static function portletActionVirgoDefault() {
			$ret = 0;
			return $ret;
		}

		function parentDelete() {
			$query = "DELETE FROM prt_portlet_objects WHERE pob_id = {$this->pob_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			$list = $this->getPortletLocations();
			if (sizeof($list) > 0) {
				foreach ($list as $childRecord) {
					$childRecord->delete();
				}
			}
			$list = $this->getHtmlContents();
			if (sizeof($list) > 0) {
				foreach ($list as $childRecord) {
					$childRecord->delete();
				}
			}
			$list = $this->getPortletParameters();
			if (sizeof($list) > 0) {
				foreach ($list as $childRecord) {
					$childRecord->delete();
				}
			}
			$list = $this->getPermissions();
			if (sizeof($list) > 0) {
				foreach ($list as $childRecord) {
					$childRecord->delete();
				}
			}
			$list = $this->getPortletObjects();
			if (sizeof($list) > 0) {
				$name = $this->getVirgoTitle();
				if (!is_null($name) && trim($name) != "") {
					$name = "'" . $name . "' ";
				}
				return T('CANT_DELETE_PARENT', 'PORTLET_OBJECT', 'PORTLET_OBJECT', $name);
			}
			self::removeFromContext();
			$this->parentDelete();
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoPortletObject();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT pob_id as id FROM prt_portlet_objects";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'pob_order_column')) {
				$orderBy = " ORDER BY pob_order_column ASC ";
			} 
			if (property_exists($this, 'pob_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY pob_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoPortletObject();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoPortletObject($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_portlet_objects SET pob_virgo_title = '$title' WHERE pob_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoPortletObject();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" pob_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['pob_id'];
			}
			return null;
		}



		private static function setSessionValue($namespace, $name, $value) {
			$_SESSION[$namespace . "-" . $name] = $value;
		}

		private static function getSessionValue($namespace, $name, $default) {
			if (isset($_SESSION[$namespace . "-" . $name])) {
				return $_SESSION[$namespace . "-" . $name];
			}
			virgoPortletObject::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoPortletObject::setSessionValue('Portal_PortletObject-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoPortletObject::getSessionValue('Portal_PortletObject-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoPortletObject::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoPortletObject::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoPortletObject::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoPortletObject::getSessionValue('GLOBAL', $name, $default);
		}
		
/*		static function isDebug() {
			$session = &JFactory::getSession();
			$debug = $session->get("VIRGO_DEBUG_MODE");
			return ($debug == "ON");

		} */
		
		static function getComponentByMenuId($menu, $masteritemid) {
			$masteritem = $menu->getItem($masteritemid);
			$masterComponentName = str_replace("index.php?option=", "", $masteritem->link);
			$masterComponentName = substr($masterComponentName, 8);
			return $masterComponentName;
		}
		
		static function putInContextStatic($id, $verifyToken = true, $pobId = null) {
			$context = self::getGlobalSessionValue('VIRGO_CONTEXT_usuniete', array());
			$context['pob_id'] = $id;
			self::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
			self::setContextId($id, $verifyToken, $pobId);
			$query = "SELECT ppr_pob_id, pdf_namespace, pdf_alias FROM prt_portlet_parameters, prt_portlet_objects, prt_portlet_definitions WHERE ppr_name = ? AND pob_id = ppr_pob_id AND pdf_id = pob_pdf_id AND ppr_value = ? ";
			$rows = QPR($query, "si", array('parent_entity_pob_id', isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
			foreach ($rows as $row) {
				$className = $row['pdf_namespace'] . '\\' . $row['pdf_alias'];
	 			if (class_exists($className)) {
	 				$className::removeFromContext($row['ppr_pob_id']);
	 				$className::setShowPage(1);
	 				$className::setDisplayMode("TABLE");
	 			}
			}
		}		
		
		function putInContext($verifyToken = true, $pobId = null) {
			self::putInContextStatic($this->getId(), $verifyToken, $pobId);
		}		

		static function removeFromContext($pobId = null) {
			$context = self::getGlobalSessionValue('VIRGO_CONTEXT_usuniete', array());
			$context['pob_id'] = null;
			virgoPortletObject::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
			if (is_null($pobId)) {
				self::setContextId(null);
			} else {
				self::setRemoteContextId(null, $pobId);				
			}
			$query = "SELECT ppr_pob_id, pdf_namespace, pdf_alias FROM prt_portlet_parameters, prt_portlet_objects, prt_portlet_definitions WHERE ppr_name = ? AND pob_id = ppr_pob_id AND pdf_id = pob_pdf_id AND ppr_value = ? ";
			$rows = QPR($query, "si", array('parent_entity_pob_id', isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
			foreach ($rows as $row) {
				$className = $row['pdf_namespace'] . '\\' . $row['pdf_alias'];
	 			if (class_exists($className)) {
	 				$className::removeFromContext($row['ppr_pob_id']);
	 				$className::setShowPage(1);
	 				$className::setDisplayMode("TABLE");
	 			}
			}
		}
		
		static function portletActionRemoveFromContext() {
			$classToRemove = R('virgo_remove_class');			
			$classToRemove::removeFromContext();
			return 0;
		}

		static function setRecordSet($criteria) {
			virgoPortletObject::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoPortletObject::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoPortletObject::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoPortletObject::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoPortletObject::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoPortletObject::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoPortletObject::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoPortletObject::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoPortletObject::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoPortletObject::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoPortletObject::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoPortletObject::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoPortletObject::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoPortletObject::setRemoteSessionValue('ContextId', $contextId, $menuItem);
		}		

		static function getCustomDisplayMode() {
			$result = null;
			return $result;
		}
		
		static function getDisplayMode() {
			$ret = self::getCustomDisplayMode();
			if (isset($ret)) {
				return $ret;
			}
			$componentParams = null; 
			if (P('form_only', "0") == "1") {
				return "CREATE";
			} elseif (P('form_only', "0") == "5" || P('form_only', "0") == "6") { 				return "FORM";
			} elseif (P('form_only', "0") == "7") {
				return "VIEW";
			} else {
				$defaultMode = "";
				if (P('form_only', "0") == 2) {
					$defaultMode = 'SEARCH';
				} else {
					$defaultMode = 'TABLE';
				}
				return virgoPortletObject::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoPortletObject::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "pob_id";
			}
			return virgoPortletObject::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoPortletObject::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoPortletObject::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoPortletObject::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoPortletObject::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoPortletObject::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoPortletObject::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoPortletObject::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoPortletObject::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoPortletObject::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoPortletObject::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoPortletObject::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoPortletObject::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->pob_id) {
				$permissionToCheck = "form";
			} else {
				$permissionToCheck = "add";
				$creating = true;
			}
			$portletObject = self::getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("$permissionToCheck")) {
				$errorMessage = $this->store();
				if ($errorMessage == "") {
					if ($showOKMessage) {
						L(T('STORED_CORRECTLY', 'PORTLET_OBJECT'), '', 'INFO');
					}
					if ($closeForm) {
						self::setDisplayMode("TABLE");
					}
					$componentParams = null; 
					if ($creating && false) { //$componentParams->get('send_email') == "1") {
						$email = $componentParams->get('send_email_address');
						$subject = $componentParams->get('send_email_subject');
						$body = $componentParams->get('send_email_body');
						$fieldValue = $componentParams->get('send_email_field_value');
						$from	= $config->getValue('mailfrom');
						$fromname= $config->getValue('fromname');
						$fieldValues = '';						
						$fieldValues = $fieldValues . T($fieldValue, 'show title', $this->pob_show_title);
						$fieldValues = $fieldValues . T($fieldValue, 'custom title', $this->pob_custom_title);
						$fieldValues = $fieldValues . T($fieldValue, 'left', $this->pob_left);
						$fieldValues = $fieldValues . T($fieldValue, 'top', $this->pob_top);
						$fieldValues = $fieldValues . T($fieldValue, 'width', $this->pob_width);
						$fieldValues = $fieldValues . T($fieldValue, 'height', $this->pob_height);
						$fieldValues = $fieldValues . T($fieldValue, 'inline', $this->pob_inline);
						$fieldValues = $fieldValues . T($fieldValue, 'ajax', $this->pob_ajax);
						$fieldValues = $fieldValues . T($fieldValue, 'render condition', $this->pob_render_condition);
						$fieldValues = $fieldValues . T($fieldValue, 'autorefresh', $this->pob_autorefresh);
						$parentPortletDefinition = new virgoPortletDefinition();
						$fieldValues = $fieldValues . T($fieldValue, 'portlet definition', $parentPortletDefinition->lookup($this->pob_pdf_id));
						$parentPortletObject = new virgoPortletObject();
						$fieldValues = $fieldValues . T($fieldValue, 'portlet object', $parentPortletObject->lookup($this->pob_pob_id));
						$username = '';
						if ($this->pob_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->pob_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->pob_date_created);
						$fieldValues = $fieldValues . T($fieldValue, 'Client IP', $_SERVER[REMOTE_ADDR]);
						$body = T($body, $fieldValues);
						if (!JUtility::sendMail($from, $fromname, $email, $subject, $body)) {
							L('Email not sent', '', 'ERROR');
						}
					}
					return "";
				} else {
					if ($showError) {
						L($errorMessage, '', 'ERROR');
					}
					return $errorMessage;
				}
			} else {
				if ($showOKMessage) {
					L(T('NO_PERMISSION'), '', 'ERROR');
				}
				return T('NO_PERMISSION');
			}
		}
		
		static function portletActionStore($showOKMessage = true, &$id = null) {
			$originalDisplayMode = self::getDisplayMode();
			$instance = new virgoPortletObject();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
					$showOKMessage = false;
				}
			}
			$errorMessage = $instance->internalActionStore(R('keep_form_open', "false") != "true", $showOKMessage);
			if ($errorMessage == "" && !isset($oldId)) {
				$instance->putInContext(isset($oldId));
				$masterEntityPobId = P('master_entity_pob_id', '');
				if ($masterEntityPobId != "") {
					$instance->putInContext(false, $masterEntityPobId);
				}
			}
			$currentItem = null; //$menu->getActive();
			$ret = null;
			$componentParams = null;
			if ($errorMessage == "") { 				$ret = 0;
				if (isset($id)) {
					$id = $instance->getId();
				}
			} else {
				$ret = -1;
			}
			if (false) { //$componentParams->get('show_form_html_contents') == "1") {
				$tmpHtmlContent = new virgoHtmlContent();
				$deleteHtmlContent = R('DELETE');
				if (sizeof($deleteHtmlContent) > 0) {
					$tmpHtmlContent->multipleDelete($deleteHtmlContent);
				}
				$resIds = $tmpHtmlContent->select(null, 'all', null, null, ' hcn_pob_id = ' . $instance->getId(), ' SELECT hcn_id FROM prt_html_contents ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->hcn_id;
//					JRequest::setVar('hcn_portlet_object_' . $resId->hcn_id, $this->getId());
				} 
//				JRequest::setVar('hcn_portlet_object_', $instance->getId());
				$tmpHtmlContent->setRecordSet($resIdsString);
				if (!$tmpHtmlContent->portletActionStoreSelected()) {
					$ret = -1;
					self::setDisplayMode($originalDisplayMode); 
				}
			}
			if (false) { //$componentParams->get('show_form_portlet_parameters') == "1") {
				$tmpPortletParameter = new virgoPortletParameter();
				$deletePortletParameter = R('DELETE');
				if (sizeof($deletePortletParameter) > 0) {
					$tmpPortletParameter->multipleDelete($deletePortletParameter);
				}
				$resIds = $tmpPortletParameter->select(null, 'all', null, null, ' ppr_pob_id = ' . $instance->getId(), ' SELECT ppr_id FROM prt_portlet_parameters ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->ppr_id;
//					JRequest::setVar('ppr_portlet_object_' . $resId->ppr_id, $this->getId());
				} 
//				JRequest::setVar('ppr_portlet_object_', $instance->getId());
				$tmpPortletParameter->setRecordSet($resIdsString);
				if (!$tmpPortletParameter->portletActionStoreSelected()) {
					$ret = -1;
					self::setDisplayMode($originalDisplayMode); 
				}
			}
			if (false) { //$componentParams->get('show_form_permissions') == "1") {
				$tmpPermission = new virgoPermission();
				$deletePermission = R('DELETE');
				if (sizeof($deletePermission) > 0) {
					$tmpPermission->multipleDelete($deletePermission);
				}
				$resIds = $tmpPermission->select(null, 'all', null, null, ' prm_pob_id = ' . $instance->getId(), ' SELECT prm_id FROM prt_permissions ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->prm_id;
//					JRequest::setVar('prm_portlet_object_' . $resId->prm_id, $this->getId());
				} 
//				JRequest::setVar('prm_portlet_object_', $instance->getId());
				$tmpPermission->setRecordSet($resIdsString);
				if (!$tmpPermission->portletActionStoreSelected()) {
					$ret = -1;
					self::setDisplayMode($originalDisplayMode); 
				}
			}
			if (false) { //$componentParams->get('show_form_portlet_objects') == "1") {
				$tmpPortletObject = new virgoPortletObject();
				$deletePortletObject = R('DELETE');
				if (sizeof($deletePortletObject) > 0) {
					$tmpPortletObject->multipleDelete($deletePortletObject);
				}
				$resIds = $tmpPortletObject->select(null, 'all', null, null, ' pob_pob_id = ' . $instance->getId(), ' SELECT pob_id FROM prt_portlet_objects ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->pob_id;
//					JRequest::setVar('pob_portlet_object_' . $resId->pob_id, $this->getId());
				} 
//				JRequest::setVar('pob_portlet_object_', $instance->getId());
				$tmpPortletObject->setRecordSet($resIdsString);
				if (!$tmpPortletObject->portletActionStoreSelected()) {
					$ret = -1;
					self::setDisplayMode($originalDisplayMode); 
				}
			}
			if ($ret == -1) {
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			}
			return $ret;
		}
		
		static function portletActionStoreAndClear() {
			$originalDisplayMode = $this->getDisplayMode();
			$ret = $this->portletActionStore(true);
			if ($ret == 0) {
				self::removeFromContext();
				self::setDisplayMode($originalDisplayMode);
			}
			return $ret;
		}
		
		
		static function portletActionApply() {
			$this->loadFromRequest();
			$oldId = $this->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			$errorMessage = $this->internalActionStore(false);
			if ($errorMessage == "") {
				$this->putInContext(isset($oldId));
			}
			if ($errorMessage == "" && is_null($oldId)) {
				self::setDisplayMode("FORM");
			}
			if ($errorMessage == "") {
				return 0;
			} else {
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
				return -1;
			}
		}

		static function portletActionSelect($verifyToken = true, $pobId = null) {
			$tmpId = intval(R('pob_id_' . $_SESSION['current_portlet_object_id']));
			$oldContextId = self::getContextId();
			if (isset($oldContextId) && $oldContextId == $tmpId) {
				self::removeFromContext();
			} else {
				self::putInContextStatic($tmpId, $verifyToken, $pobId);
			}
			return 0;
		}
		

		static function portletActionSelectAndSetParent() {
			$parentPobId = R('parent_pob_id');
			$parentPortletObject = new virgoPortletObject($parentPobId);
			$className = $parentPortletObject->getPortletDefinition()->getAlias();
			if (!class_exists($className)) {
				require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.$portletObject->getPortletDefinition()->getNamespace().DIRECTORY_SEPARATOR.$portletObject->getPortletDefinition()->getAlias().DIRECTORY_SEPARATOR.'controller.php');
			}
			$class = new $className();
			$class->portletActionSelect(false, $parentPobId);
			return self::portletActionSelect(false);
		}
		
		static function portletActionSelectJson() {
			self::portletActionSelect(false);
			return virgoPortletObject::getContextId();
		}
		
		static function portletActionView() {
			self::putInContextStatic(self::loadIdFromRequest());
			self::setDisplayMode("VIEW");
			return 0;
		}
		
		static function portletActionClearView() {
			$this->setCriteria(array());
			return $this->portletActionView();
		}
		

		static function portletActionClose() {
			self::setDisplayMode("TABLE");
			return 0;
		}
		
		static function portletActionForm() {
			$tmpId = self::loadIdFromRequest();
			self::putInContextStatic($tmpId);
			if ($tmpId) {
				$permissionToCheck = "form";
			} else {
				$permissionToCheck = "add";
			}
			$portletObject = self::getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("$permissionToCheck")) {
			self::setDisplayMode("FORM");
			}
			return 0;
		}
		
		static function portletActionDuplicate() {
			self::putInContextStatic(self::loadIdFromRequest());
			$this->pob_id = null;
			$this->pob_date_created = null;
			$this->pob_usr_created_id = null;
			$this->pob_date_modified = null;
			$this->pob_usr_modified_id = null;
			$this->pob_virgo_title = null;
			
			self::setDisplayMode("CREATE");
			return 0;
		}
		
		static function portletActionShowHistory() {
			self::putInContextStatic(self::loadIdFromRequest());
			self::setDisplayMode("SHOW_HISTORY");
			return 0;
		}
		
		static function portletActionShowRevision() {
			self::setDisplayMode("SHOW_REVISION");
			return 0;
		}
		
		static function portletActionCustomMode() {
			$customMode = R('componentName');
			if (!is_null($customMode) && trim($customMode) != "") {			
				self::putInContextStatic(self::loadIdFromRequest());
				self::setDisplayMode($customMode);
			}
			return 0;
		}

		static function portletActionShowForPortletDefinition() {
			$parentId = R('pdf_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoPortletDefinition($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
			return 0;
		}
		static function portletActionShowForPortletObject() {
			$parentId = R('pob_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoPortletObject($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
			return 0;
		}


		static function portletActionAdd() {
			$portletObject = self::getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("add")) {
			self::removeFromContext();
			self::setDisplayMode("CREATE");
//			$ret = new virgoPortletObject();
//			return $ret;
			}
			return 0;
		}

		static function portletActionSearchForm() {
			self::setDisplayMode("SEARCH"); 
			self::setShowPage(1);
			return 0;
		}

		static function portletActionSearch() {
			self::loadSearchFromRequest();
			if (P('filter_mode', '0') == '0') {
				self::setDisplayMode("TABLE");
			}
			return 0;
		}
		
		static function portletActionClear() {
			$this->setCriteria(array());
			// self::setDisplayMode("TABLE");
			return 0;
		}

		static function portletActionRemoveCriterium() { 
			$column = R('virgo_filter_column');
			$criteria = self::getCriteria();
			unset($criteria[$column]);
			self::setCriteria($criteria);
			self::setDisplayMode("TABLE");
			return 0;
		}
		
		static function portletActionDelete() {
			$portletObject = self::getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("delete")) {
				$instance = new virgoPortletObject();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoPortletObject::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'PORTLET_OBJECT'), '', 'INFO');
					return 0;
					
				} else {
					L($res, '', 'ERROR');
					return -1;
				}
			}
		}
		
		
		static function portletActionVirgoSetShowTitleTrue() {
			$this->loadFromDB();
			$this->setShowTitle(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetShowTitleFalse() {
			$this->loadFromDB();
			$this->setShowTitle(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isShowTitle() {
			return $this->getShowTitle() == 1;
		}
		static function portletActionVirgoSetInlineTrue() {
			$this->loadFromDB();
			$this->setInline(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetInlineFalse() {
			$this->loadFromDB();
			$this->setInline(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isInline() {
			return $this->getInline() == 1;
		}
		static function portletActionVirgoSetAjaxTrue() {
			$this->loadFromDB();
			$this->setAjax(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetAjaxFalse() {
			$this->loadFromDB();
			$this->setAjax(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isAjax() {
			return $this->getAjax() == 1;
		}
		
		
		static function portletActionEditSelected() {
			$idsToDeleteString = R('ids');
			$idsToDeleteString = $idsToDeleteString . ",0";
			$this->setRecordSet($idsToDeleteString);
			$this->setInvalidRecords(array());
			self::setDisplayMode("TABLE_FORM");
			return 0;
		}		
		
		function getRecordsToEdit() {
			$idsToEditString = $this->getRecordSet();
			$idsToEdit = preg_split("/,/", $idsToEditString);
			$idsToCorrect = $this->getInvalidRecords();
			$results = array();
			foreach ($idsToEdit as $idToEdit) {
				$resultPortletObject = new virgoPortletObject();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultPortletObject->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultPortletObject->load($idToEditInt);
					} else {
						$resultPortletObject->pob_id = 0;
					}
				}
				$results[] = $resultPortletObject;
			}
			return $results;
		}
		
		static function portletActionStoreSelected() {
			$validateNew = R('virgo_validate_new'); 
			$idsToStoreString = $this->getRecordSet();
			$idsToStore = preg_split("/,/", $idsToStoreString);
			$results = array();
			$errors = 0;
			$idsToCorrect = array();
			foreach ($idsToStore as $idToStore) {
				$result = new virgoPortletObject();
				$result->loadFromRequest($idToStore);
				if ($result->pob_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->pob_id == 0) {
						$result->pob_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->pob_id)) {
							$result->pob_id = 0;
						}
						$idsToCorrect[$result->pob_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'PORTLET_OBJECTS'), '', 'INFO');
				}
				self::setDisplayMode("TABLE");
				return 0;
			} else {
				L(T('INVALID_RECORDS', $errors), '', 'ERROR');
				$this->setInvalidRecords($idsToCorrect);
				return -1;
			}
		}

		function multipleDelete($idsToDelete) {
			$errorOcurred = 0;
			$resultPortletObject = new virgoPortletObject();
			foreach ($idsToDelete as $idToDelete) {
				$resultPortletObject->load((int)trim($idToDelete));
				$res = $resultPortletObject->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'PORTLET_OBJECTS'), '', 'INFO');			
				self::setDisplayMode("TABLE");
				return 0;
			} else {
				return -1;
			}
		}

		function getSelectedIds($name = 'ids') {
			$idsString = R($name);
			if (trim($idsString) == "") {
				return array();
			}
			return preg_split("/,/", $idsString);			
		}
		
		static function portletActionDeleteSelected() {
			$idsToDelete = $this->getSelectedIds();
			return $this->multipleDelete($idsToDelete);
		}

		static function portletActionChangeOrder() {
			$column = R('virgo_order_column');
			$mode = R('virgo_order_mode');
			self::setOrderColumn($column);
			self::setOrderMode($mode);
			return 0;
		}
		
		static function portletActionChangePaging() {
			$showPage = R('virgo_show_page');
			if(preg_match('/^\d+$/',$showPage)) {
				if ((int)$showPage > 0) {
					self::setShowPage($showPage);
				}
			}			
			$showRows = R('virgo_show_rows');
			self::setShowRows($showRows);
			return 0;
		}
				
		function getVirgoTitleNull() {
		$ret = $this->pob_custom_title;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoPortletObject');
			if (!is_null($paramTitleSource) && trim($paramTitleSource) != "") {
				$paramTitleSource = '$ret = ' . $paramTitleSource;
				eval($paramTitleSource);
				return $ret;
			} else {
				$ret = $this->getVirgoTitleNull();
				if (is_null($ret)) return "";
				return $ret;
			}
		}
		
		function formatMessage($message, $args) {
			$index = 1;
			foreach ($args as &$value) {
				$message = str_replace("$" . $index, $value, $message);
				$index = $index + 1;
			}
			unset($value);
			return $message;
		}
		
		static function getExtraFilesInfo() {
			$ret = array();
			return $ret;
		}
		
		function updateTitle() {
			$val = $this->getVirgoTitle(); 
			if (!is_null($val) && trim($val) != "") {
				$query = "UPDATE prt_portlet_objects SET pob_virgo_title = ? WHERE pob_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT pob_id AS id FROM prt_portlet_objects ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoPortletObject($row['id']);
				$tmp->updateTitle();
			}
			L("Title updated", '', 'INFO');
			return 0;
		}
		

		function hideContentDueToNoParentSelected() {			
			$whenNoParentSelected = P("when_no_parent_selected", "E");
			if ($whenNoParentSelected == "H") {
				$parentPobIds = PN('parent_entity_pob_id');
				foreach ($parentPobIds as $parentPobId) {
					$portletObject = new virgoPortletObject($parentPobId);
					$className = $portletObject->getPortletDefinition()->getAlias();
					$masterObject = new $className();
					$tmpContextId = $masterObject->getRemoteContextId($parentPobId);
					if (isset($tmpContextId)) {
						return false;
					}
				}
;				return true;
			} else {
				return false;
			}
		}

		static function getParentsInContext() {
			if (!isset($_REQUEST['_virgo_parents_in_context_' . $_SESSION['current_portlet_object_id']])) {
				$ret = array();
				$parentPobIds = PN('parent_entity_pob_id');
				$class2prefix = array();
				$class2prefix["portal\\virgoPortletDefinition"] = "pdf";
				$class2prefix2 = array();
				$class2parentPrefix["portal\\virgoPortletDefinition"] = $class2prefix2;
				$class2prefix["portal\\virgoPortletObject"] = "pob";
				$class2prefix2 = array();
				$class2prefix2["portal\\virgoPortletDefinition"] = "pdf";
				$class2prefix2["portal\\virgoPortletObject"] = "pob";
				$class2parentPrefix["portal\\virgoPortletObject"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'prt_portlet_objects.pob_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_portlet_objects.pob_' . $parentInfo['prefix'] . '_id IS NULL';
						} elseif ($whenNoParentSelected == "A") {
							$parentInfo['condition'] = ' 1 ';
						} elseif ($whenNoParentSelected == "G") {
							$grandparentPobIds = PN('grandparent_entity_pob_id');
							foreach ($grandparentPobIds as $grandparentPobId) {
								$class2parent2 = $class2parentPrefix[$parentInfo['className']];
								$grandparentInfo = self::getEntityInfoByPobId($grandparentPobId, $class2parent2);
								if (isset($class2prefix2[$grandparentInfo['className']])) {
									if (isset($grandparentInfo['value'])) {
										$parentClassName = $parentInfo['className'];
										$tmp = new $parentClassName();
										$grandparentInfo['condition'] = 'prt_portlet_objects.pob_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_portlet_objects.pob_' . $parentInfo['prefix'] . '_id IS NULL';
							}
						} else {
							if ($whenNoParentSelected != "H") {
								L(T('PLEASE_SELECT_PARENT'), '', 'INFO');
							}
							$parentInfo['condition'] = ' 0 ';
						}
					}
					if (!$grandparentAdded) {
						$ret[$parentInfo['className']] = $parentInfo;
					}
				}
				$_REQUEST['_virgo_parents_in_context_' . $_SESSION['current_portlet_object_id']] = $ret;
			} else {
				$ret = $_REQUEST['_virgo_parents_in_context_' . $_SESSION['current_portlet_object_id']];
			}
			return $ret;
		}
		
				static function getEntityInfoByPobId($parentPobId, $class2prefix) {
			$ret = array();
			$portletObject = new virgoPortletObject($parentPobId);
			$ret['name'] = $portletObject->getPortletDefinition()->getName();
			$className = $portletObject->getPortletDefinition()->getNamespace().'\\'.$portletObject->getPortletDefinition()->getAlias();
			if (!isset($class2prefix[$className])) {
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoPortletObject!', '', 'ERROR');
				return array();
			}
			$ret['prefix'] = $class2prefix[$className];
			$ret['className'] = $className;
			$tmpContextId = $className::getRemoteContextId($parentPobId);
			$ret['contextId'] = $tmpContextId;
			if (isset($tmpContextId) && $tmpContextId != "") {
				$ret['value'] =  "" . $className::lookup($tmpContextId);
			}
			return $ret;
		}

		static function portletActionReport() {
			require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'tcpdf'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'eng.php');
			require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'tcpdf'.DIRECTORY_SEPARATOR.'tcpdf.php');
			ini_set('display_errors', '0');
			$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$user = virgoUser::getUser();
			$pdf->SetCreator(null);
			$pdf->SetTitle('Portlet objects report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('PORTLET_OBJECTS');
			}
			$pdf->setHeaderData('', 0, $reportTitle, date ("Y.m.d H:i:s"));

			$font = P('pdf_font_name', 'freeserif');
			$includeBold = P('pdf_include_bold_font', '0');
			$fontBoldVariant = ($includeBold == "0" || is_null($includeBold) || trim($includeBold) == "") ? '' : 'B';

			$pdf->setHeaderFont(array($font, '', 10));
			$pdf->setFooterFont(array($font, '', 8));

			$fontSize = (float)P('pdf_font_size', '10');
			$pdf->SetFont($font, '', $fontSize);
			$columnsNumber = 0;	
			if (P('show_pdf_show_title', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_custom_title', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_left', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_top', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_width', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_height', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_inline', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_ajax', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_render_condition', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_autorefresh', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_portlet_definition', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_portlet_object', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultPortletObject = new virgoPortletObject();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_show_title', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Show title');
				$minWidth['show title'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['show title']) {
						$minWidth['show title'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_custom_title', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Custom title');
				$minWidth['custom title'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['custom title']) {
						$minWidth['custom title'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_left', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Left');
				$minWidth['left'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['left']) {
						$minWidth['left'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_top', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Top');
				$minWidth['top'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['top']) {
						$minWidth['top'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_width', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Width');
				$minWidth['width'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['width']) {
						$minWidth['width'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_height', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Height');
				$minWidth['height'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['height']) {
						$minWidth['height'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_inline', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Inline');
				$minWidth['inline'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['inline']) {
						$minWidth['inline'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_ajax', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Ajax');
				$minWidth['ajax'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['ajax']) {
						$minWidth['ajax'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_render_condition', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Render condition');
				$minWidth['render condition'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['render condition']) {
						$minWidth['render condition'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_autorefresh', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Autorefresh');
				$minWidth['autorefresh'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['autorefresh']) {
						$minWidth['autorefresh'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_portlet_definition', "1") == "1") {
				$minWidth['portlet definition $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'portlet definition $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['portlet definition $relation.name']) {
						$minWidth['portlet definition $relation.name'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_portlet_object', "1") == "1") {
				$minWidth['portlet object $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'portlet object $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['portlet object $relation.name']) {
						$minWidth['portlet object $relation.name'] = min($tmpLen, $maxWidth);
					}
				}
			}
			$pdf->SetFont($font, '', $fontSize);
			$pdf->AliasNbPages();
			$orientation = P('pdf_page_orientation', 'P');
			$pdf->AddPage($orientation);
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 4);
			$pdf->MultiCell(0, 1, $reportTitle, '', 'C', 0, 0);
			$pdf->Ln();
			$whereClausePortletObject = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClausePortletObject = $whereClausePortletObject . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaPortletObject = $resultPortletObject->getCriteria();
			$fieldCriteriaShowTitle = $criteriaPortletObject["show_title"];
			if ($fieldCriteriaShowTitle["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Show title', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaShowTitle["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") {
				switch ($condition) {
					case 0: $renderCriteria = T("NO"); break;
					case 1: $renderCriteria = T("YES"); break;
					case 2: $renderCriteria = T("NO_DATA"); break;
				}
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Show title', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaCustomTitle = $criteriaPortletObject["custom_title"];
			if ($fieldCriteriaCustomTitle["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Custom title', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaCustomTitle["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Custom title', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaLeft = $criteriaPortletObject["left"];
			if ($fieldCriteriaLeft["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Left', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaLeft["value"];
				$renderCriteria = "";
			$conditionFrom = $dataTypeCriteria["from"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$renderCriteria = $renderCriteria . " >= " . $conditionFrom;
			}
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$renderCriteria = $renderCriteria . " =< " . $conditionTo;
			}			
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Left', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaTop = $criteriaPortletObject["top"];
			if ($fieldCriteriaTop["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Top', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaTop["value"];
				$renderCriteria = "";
			$conditionFrom = $dataTypeCriteria["from"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$renderCriteria = $renderCriteria . " >= " . $conditionFrom;
			}
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$renderCriteria = $renderCriteria . " =< " . $conditionTo;
			}			
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Top', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaWidth = $criteriaPortletObject["width"];
			if ($fieldCriteriaWidth["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Width', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaWidth["value"];
				$renderCriteria = "";
			$conditionFrom = $dataTypeCriteria["from"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$renderCriteria = $renderCriteria . " >= " . $conditionFrom;
			}
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$renderCriteria = $renderCriteria . " =< " . $conditionTo;
			}			
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Width', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaHeight = $criteriaPortletObject["height"];
			if ($fieldCriteriaHeight["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Height', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaHeight["value"];
				$renderCriteria = "";
			$conditionFrom = $dataTypeCriteria["from"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$renderCriteria = $renderCriteria . " >= " . $conditionFrom;
			}
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$renderCriteria = $renderCriteria . " =< " . $conditionTo;
			}			
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Height', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaInline = $criteriaPortletObject["inline"];
			if ($fieldCriteriaInline["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Inline', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaInline["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") {
				switch ($condition) {
					case 0: $renderCriteria = T("NO"); break;
					case 1: $renderCriteria = T("YES"); break;
					case 2: $renderCriteria = T("NO_DATA"); break;
				}
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Inline', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaAjax = $criteriaPortletObject["ajax"];
			if ($fieldCriteriaAjax["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Ajax', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaAjax["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") {
				switch ($condition) {
					case 0: $renderCriteria = T("NO"); break;
					case 1: $renderCriteria = T("YES"); break;
					case 2: $renderCriteria = T("NO_DATA"); break;
				}
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Ajax', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaRenderCondition = $criteriaPortletObject["render_condition"];
			if ($fieldCriteriaRenderCondition["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Render condition', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaRenderCondition["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Render condition', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaAutorefresh = $criteriaPortletObject["autorefresh"];
			if ($fieldCriteriaAutorefresh["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Autorefresh', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaAutorefresh["value"];
				$renderCriteria = "";
			$conditionFrom = $dataTypeCriteria["from"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$renderCriteria = $renderCriteria . " >= " . $conditionFrom;
			}
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$renderCriteria = $renderCriteria . " =< " . $conditionTo;
			}			
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Autorefresh', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaPortletObject["portlet_definition"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Portlet definition', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoPortletDefinition::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Portlet definition', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaPortletObject["portlet_object"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Portlet object', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoPortletObject::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Portlet object', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_portlet_definition');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_portlet_objects.pob_pdf_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portlet_objects.pob_pdf_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortletObject = $whereClausePortletObject . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_portlet_object');
			if (isset($limit) && trim($limit) != '') {
				if (strrpos($limit, "empty") !== false) {
					if (strrpos($limit, "empty,") === false) {
						$toRemove = "empty";
					} else {
						$toRemove = "empty,";
					}
					$limit = str_replace($toRemove, "", $limit);
					$includeNulls = true;
					$includeIns = (isset($limit) && trim($limit) != '');
				}
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_portlet_objects.pob_pob_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portlet_objects.pob_pob_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortletObject = $whereClausePortletObject . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaPortletObject = self::getCriteria();
			if (isset($criteriaPortletObject["show_title"])) {
				$fieldCriteriaShowTitle = $criteriaPortletObject["show_title"];
				if ($fieldCriteriaShowTitle["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_show_title IS NOT NULL ';
				} elseif ($fieldCriteriaShowTitle["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_show_title IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaShowTitle["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_portlet_objects.pob_show_title = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaPortletObject["custom_title"])) {
				$fieldCriteriaCustomTitle = $criteriaPortletObject["custom_title"];
				if ($fieldCriteriaCustomTitle["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_custom_title IS NOT NULL ';
				} elseif ($fieldCriteriaCustomTitle["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_custom_title IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaCustomTitle["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_objects.pob_custom_title like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortletObject["left"])) {
				$fieldCriteriaLeft = $criteriaPortletObject["left"];
				if ($fieldCriteriaLeft["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_left IS NOT NULL ';
				} elseif ($fieldCriteriaLeft["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_left IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaLeft["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_portlet_objects.pob_left = ? ";
				} else {
					$filter = $filter . " AND prt_portlet_objects.pob_left >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_portlet_objects.pob_left <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPortletObject["top"])) {
				$fieldCriteriaTop = $criteriaPortletObject["top"];
				if ($fieldCriteriaTop["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_top IS NOT NULL ';
				} elseif ($fieldCriteriaTop["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_top IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaTop["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_portlet_objects.pob_top = ? ";
				} else {
					$filter = $filter . " AND prt_portlet_objects.pob_top >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_portlet_objects.pob_top <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPortletObject["width"])) {
				$fieldCriteriaWidth = $criteriaPortletObject["width"];
				if ($fieldCriteriaWidth["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_width IS NOT NULL ';
				} elseif ($fieldCriteriaWidth["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_width IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaWidth["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_portlet_objects.pob_width = ? ";
				} else {
					$filter = $filter . " AND prt_portlet_objects.pob_width >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_portlet_objects.pob_width <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPortletObject["height"])) {
				$fieldCriteriaHeight = $criteriaPortletObject["height"];
				if ($fieldCriteriaHeight["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_height IS NOT NULL ';
				} elseif ($fieldCriteriaHeight["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_height IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaHeight["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_portlet_objects.pob_height = ? ";
				} else {
					$filter = $filter . " AND prt_portlet_objects.pob_height >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_portlet_objects.pob_height <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPortletObject["inline"])) {
				$fieldCriteriaInline = $criteriaPortletObject["inline"];
				if ($fieldCriteriaInline["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_inline IS NOT NULL ';
				} elseif ($fieldCriteriaInline["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_inline IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaInline["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_portlet_objects.pob_inline = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaPortletObject["ajax"])) {
				$fieldCriteriaAjax = $criteriaPortletObject["ajax"];
				if ($fieldCriteriaAjax["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_ajax IS NOT NULL ';
				} elseif ($fieldCriteriaAjax["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_ajax IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaAjax["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_portlet_objects.pob_ajax = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaPortletObject["render_condition"])) {
				$fieldCriteriaRenderCondition = $criteriaPortletObject["render_condition"];
				if ($fieldCriteriaRenderCondition["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_render_condition IS NOT NULL ';
				} elseif ($fieldCriteriaRenderCondition["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_render_condition IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaRenderCondition["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_objects.pob_render_condition like ? ";
				$types .= "s";
				$values[] = $condition;				
			}
				}
			}
			if (isset($criteriaPortletObject["autorefresh"])) {
				$fieldCriteriaAutorefresh = $criteriaPortletObject["autorefresh"];
				if ($fieldCriteriaAutorefresh["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_objects.pob_autorefresh IS NOT NULL ';
				} elseif ($fieldCriteriaAutorefresh["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_objects.pob_autorefresh IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaAutorefresh["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_portlet_objects.pob_autorefresh = ? ";
				} else {
					$filter = $filter . " AND prt_portlet_objects.pob_autorefresh >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_portlet_objects.pob_autorefresh <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPortletObject["portlet_definition"])) {
				$parentCriteria = $criteriaPortletObject["portlet_definition"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pob_pdf_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portlet_objects.pob_pdf_id IN (SELECT pdf_id FROM prt_portlet_definitions WHERE pdf_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPortletObject["portlet_object"])) {
				$parentCriteria = $criteriaPortletObject["portlet_object"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pob_pob_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portlet_objects.pob_pob_id IN (SELECT pob_id FROM prt_portlet_objects WHERE pob_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPortletObject["page"])) {
				$parentCriteria = $criteriaPortletObject["page"];
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$filter = $filter . " AND prt_portlet_objects.pob_id IN (SELECT second_parent.plc_pob_id FROM prt_portlet_locations AS second_parent WHERE second_parent.plc_pge_id IN (" . implode(", ", $parentIds) . ")) ";
				}
			}
			$whereClausePortletObject = $whereClausePortletObject . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClausePortletObject = $whereClausePortletObject . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_portlet_objects.pob_id, prt_portlet_objects.pob_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_show_title', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_show_title pob_show_title";
			} else {
				if ($defaultOrderColumn == "pob_show_title") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_show_title ";
				}
			}
			if (P('show_pdf_custom_title', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_custom_title pob_custom_title";
			} else {
				if ($defaultOrderColumn == "pob_custom_title") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_custom_title ";
				}
			}
			if (P('show_pdf_left', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_left pob_left";
			} else {
				if ($defaultOrderColumn == "pob_left") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_left ";
				}
			}
			if (P('show_pdf_top', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_top pob_top";
			} else {
				if ($defaultOrderColumn == "pob_top") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_top ";
				}
			}
			if (P('show_pdf_width', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_width pob_width";
			} else {
				if ($defaultOrderColumn == "pob_width") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_width ";
				}
			}
			if (P('show_pdf_height', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_height pob_height";
			} else {
				if ($defaultOrderColumn == "pob_height") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_height ";
				}
			}
			if (P('show_pdf_inline', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_inline pob_inline";
			} else {
				if ($defaultOrderColumn == "pob_inline") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_inline ";
				}
			}
			if (P('show_pdf_ajax', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_ajax pob_ajax";
			} else {
				if ($defaultOrderColumn == "pob_ajax") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_ajax ";
				}
			}
			if (P('show_pdf_render_condition', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_render_condition pob_render_condition";
			} else {
				if ($defaultOrderColumn == "pob_render_condition") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_render_condition ";
				}
			}
			if (P('show_pdf_autorefresh', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_autorefresh pob_autorefresh";
			} else {
				if ($defaultOrderColumn == "pob_autorefresh") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_autorefresh ";
				}
			}
			if (class_exists('portal\virgoPortletDefinition') && P('show_pdf_portlet_definition', "1") != "0") { // */ && !in_array("pdf", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_objects.pob_pdf_id as pob_pdf_id ";
				$queryString = $queryString . ", prt_portlet_definitions_parent.pdf_virgo_title as `portlet_definition` ";
			} else {
				if ($defaultOrderColumn == "portlet_definition") {
					$orderColumnNotDisplayed = " prt_portlet_definitions_parent.pdf_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_pdf_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_objects.pob_pob_id as pob_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portlet_objects ";
			if (class_exists('portal\virgoPortletDefinition')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_definitions AS prt_portlet_definitions_parent ON (prt_portlet_objects.pob_pdf_id = prt_portlet_definitions_parent.pdf_id) ";
			}
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_portlet_objects.pob_pob_id = prt_portlet_objects_parent.pob_id) ";
			}

		$resultsPortletObject = $resultPortletObject->select(
			'', 
			'all', 
			$resultPortletObject->getOrderColumn(), 
			$resultPortletObject->getOrderMode(), 
			$whereClausePortletObject,
			$queryString);
		
		foreach ($resultsPortletObject as $resultPortletObject) {

			if (P('show_pdf_show_title', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletObject['pob_show_title'])) + 6;
				if ($tmpLen > $minWidth['show title']) {
					$minWidth['show title'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_custom_title', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletObject['pob_custom_title'])) + 6;
				if ($tmpLen > $minWidth['custom title']) {
					$minWidth['custom title'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_left', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletObject['pob_left'])) + 6;
				if ($tmpLen > $minWidth['left']) {
					$minWidth['left'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_top', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletObject['pob_top'])) + 6;
				if ($tmpLen > $minWidth['top']) {
					$minWidth['top'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_width', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletObject['pob_width'])) + 6;
				if ($tmpLen > $minWidth['width']) {
					$minWidth['width'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_height', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletObject['pob_height'])) + 6;
				if ($tmpLen > $minWidth['height']) {
					$minWidth['height'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_inline', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletObject['pob_inline'])) + 6;
				if ($tmpLen > $minWidth['inline']) {
					$minWidth['inline'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_ajax', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletObject['pob_ajax'])) + 6;
				if ($tmpLen > $minWidth['ajax']) {
					$minWidth['ajax'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_render_condition', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletObject['pob_render_condition'])) + 6;
				if ($tmpLen > $minWidth['render condition']) {
					$minWidth['render condition'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_autorefresh', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletObject['pob_autorefresh'])) + 6;
				if ($tmpLen > $minWidth['autorefresh']) {
					$minWidth['autorefresh'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_portlet_definition', "1") == "1") {
			$parentValue = trim(virgoPortletDefinition::lookup($resultPortletObject['pobpdf__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['portlet definition $relation.name']) {
					$minWidth['portlet definition $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_portlet_object', "1") == "1") {
			$parentValue = trim(virgoPortletObject::lookup($resultPortletObject['pobpob__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['portlet object $relation.name']) {
					$minWidth['portlet object $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaPortletObject = $resultPortletObject->getCriteria();
		if (is_null($criteriaPortletObject) || sizeof($criteriaPortletObject) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																																										if (P('show_pdf_portlet_definition', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['portlet definition $relation.name'], $colHeight, T('PORTLET_DEFINITION') . ' ' . T(''), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_show_title', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['show title'], $colHeight, T('SHOW_TITLE'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_custom_title', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['custom title'], $colHeight, T('CUSTOM_TITLE'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_left', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['left'], $colHeight, T('LEFT'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_top', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['top'], $colHeight, T('TOP'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_width', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['width'], $colHeight, T('WIDTH'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_height', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['height'], $colHeight, T('HEIGHT'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_inline', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['inline'], $colHeight, T('INLINE'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_ajax', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['ajax'], $colHeight, T('AJAX'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_render_condition', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['render condition'], $colHeight, T('RENDER_CONDITION'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_autorefresh', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['autorefresh'], $colHeight, T('AUTOREFRESH'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_portlet_object', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['portlet object $relation.name'], $colHeight, T('PORTLET_OBJECT') . ' ' . T(''), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}

		for ($iTmp = 0; $iTmp < $maxLn; $iTmp++) {
			$dummyText .= " 
";
		}
		$pdf->MultiCell(4, $colHeight, $dummyText, '0', 'L', 0, 1); 
		$pdf->SetFont($font, '', $fontSize);
		$counts = array();
		$sums = array();
		$avgCounts = array();
		$avgSums = array();
		$pdf->SetDrawColor(200);
		foreach ($resultsPortletObject as $resultPortletObject) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_portlet_definition', "1") == "1") {
			$parentValue = virgoPortletDefinition::lookup($resultPortletObject['pob_pdf_id']);
			$tmpLn = $pdf->MultiCell($minWidth['portlet definition $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_show_title', "0") != "0") {
			$renderCriteria = "";
			switch ($resultPortletObject['pob_show_title']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['show title'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_show_title', "1") == "2") {
										if (!is_null($resultPortletObject['pob_show_title'])) {
						$tmpCount = (float)$counts["show_title"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["show_title"] = $tmpCount;
					}
				}
				if (P('show_pdf_show_title', "1") == "3") {
										if (!is_null($resultPortletObject['pob_show_title'])) {
						$tmpSum = (float)$sums["show_title"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_show_title'];
						}
						$sums["show_title"] = $tmpSum;
					}
				}
				if (P('show_pdf_show_title', "1") == "4") {
										if (!is_null($resultPortletObject['pob_show_title'])) {
						$tmpCount = (float)$avgCounts["show_title"];
						$tmpSum = (float)$avgSums["show_title"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["show_title"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_show_title'];
						}
						$avgSums["show_title"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_custom_title', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['custom title'], $colHeight, '' . $resultPortletObject['pob_custom_title'], 'T', 'L', 0, 0);
				if (P('show_pdf_custom_title', "1") == "2") {
										if (!is_null($resultPortletObject['pob_custom_title'])) {
						$tmpCount = (float)$counts["custom_title"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["custom_title"] = $tmpCount;
					}
				}
				if (P('show_pdf_custom_title', "1") == "3") {
										if (!is_null($resultPortletObject['pob_custom_title'])) {
						$tmpSum = (float)$sums["custom_title"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_custom_title'];
						}
						$sums["custom_title"] = $tmpSum;
					}
				}
				if (P('show_pdf_custom_title', "1") == "4") {
										if (!is_null($resultPortletObject['pob_custom_title'])) {
						$tmpCount = (float)$avgCounts["custom_title"];
						$tmpSum = (float)$avgSums["custom_title"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["custom_title"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_custom_title'];
						}
						$avgSums["custom_title"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_left', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['left'], $colHeight, '' . $resultPortletObject['pob_left'], 'T', 'R', 0, 0);
				if (P('show_pdf_left', "1") == "2") {
										if (!is_null($resultPortletObject['pob_left'])) {
						$tmpCount = (float)$counts["left"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["left"] = $tmpCount;
					}
				}
				if (P('show_pdf_left', "1") == "3") {
										if (!is_null($resultPortletObject['pob_left'])) {
						$tmpSum = (float)$sums["left"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_left'];
						}
						$sums["left"] = $tmpSum;
					}
				}
				if (P('show_pdf_left', "1") == "4") {
										if (!is_null($resultPortletObject['pob_left'])) {
						$tmpCount = (float)$avgCounts["left"];
						$tmpSum = (float)$avgSums["left"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["left"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_left'];
						}
						$avgSums["left"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_top', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['top'], $colHeight, '' . $resultPortletObject['pob_top'], 'T', 'R', 0, 0);
				if (P('show_pdf_top', "1") == "2") {
										if (!is_null($resultPortletObject['pob_top'])) {
						$tmpCount = (float)$counts["top"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["top"] = $tmpCount;
					}
				}
				if (P('show_pdf_top', "1") == "3") {
										if (!is_null($resultPortletObject['pob_top'])) {
						$tmpSum = (float)$sums["top"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_top'];
						}
						$sums["top"] = $tmpSum;
					}
				}
				if (P('show_pdf_top', "1") == "4") {
										if (!is_null($resultPortletObject['pob_top'])) {
						$tmpCount = (float)$avgCounts["top"];
						$tmpSum = (float)$avgSums["top"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["top"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_top'];
						}
						$avgSums["top"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_width', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['width'], $colHeight, '' . $resultPortletObject['pob_width'], 'T', 'R', 0, 0);
				if (P('show_pdf_width', "1") == "2") {
										if (!is_null($resultPortletObject['pob_width'])) {
						$tmpCount = (float)$counts["width"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["width"] = $tmpCount;
					}
				}
				if (P('show_pdf_width', "1") == "3") {
										if (!is_null($resultPortletObject['pob_width'])) {
						$tmpSum = (float)$sums["width"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_width'];
						}
						$sums["width"] = $tmpSum;
					}
				}
				if (P('show_pdf_width', "1") == "4") {
										if (!is_null($resultPortletObject['pob_width'])) {
						$tmpCount = (float)$avgCounts["width"];
						$tmpSum = (float)$avgSums["width"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["width"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_width'];
						}
						$avgSums["width"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_height', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['height'], $colHeight, '' . $resultPortletObject['pob_height'], 'T', 'R', 0, 0);
				if (P('show_pdf_height', "1") == "2") {
										if (!is_null($resultPortletObject['pob_height'])) {
						$tmpCount = (float)$counts["height"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["height"] = $tmpCount;
					}
				}
				if (P('show_pdf_height', "1") == "3") {
										if (!is_null($resultPortletObject['pob_height'])) {
						$tmpSum = (float)$sums["height"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_height'];
						}
						$sums["height"] = $tmpSum;
					}
				}
				if (P('show_pdf_height', "1") == "4") {
										if (!is_null($resultPortletObject['pob_height'])) {
						$tmpCount = (float)$avgCounts["height"];
						$tmpSum = (float)$avgSums["height"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["height"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_height'];
						}
						$avgSums["height"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_inline', "0") != "0") {
			$renderCriteria = "";
			switch ($resultPortletObject['pob_inline']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['inline'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_inline', "1") == "2") {
										if (!is_null($resultPortletObject['pob_inline'])) {
						$tmpCount = (float)$counts["inline"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["inline"] = $tmpCount;
					}
				}
				if (P('show_pdf_inline', "1") == "3") {
										if (!is_null($resultPortletObject['pob_inline'])) {
						$tmpSum = (float)$sums["inline"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_inline'];
						}
						$sums["inline"] = $tmpSum;
					}
				}
				if (P('show_pdf_inline', "1") == "4") {
										if (!is_null($resultPortletObject['pob_inline'])) {
						$tmpCount = (float)$avgCounts["inline"];
						$tmpSum = (float)$avgSums["inline"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["inline"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_inline'];
						}
						$avgSums["inline"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_ajax', "0") != "0") {
			$renderCriteria = "";
			switch ($resultPortletObject['pob_ajax']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['ajax'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_ajax', "1") == "2") {
										if (!is_null($resultPortletObject['pob_ajax'])) {
						$tmpCount = (float)$counts["ajax"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["ajax"] = $tmpCount;
					}
				}
				if (P('show_pdf_ajax', "1") == "3") {
										if (!is_null($resultPortletObject['pob_ajax'])) {
						$tmpSum = (float)$sums["ajax"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_ajax'];
						}
						$sums["ajax"] = $tmpSum;
					}
				}
				if (P('show_pdf_ajax', "1") == "4") {
										if (!is_null($resultPortletObject['pob_ajax'])) {
						$tmpCount = (float)$avgCounts["ajax"];
						$tmpSum = (float)$avgSums["ajax"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["ajax"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_ajax'];
						}
						$avgSums["ajax"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_render_condition', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['render condition'], $colHeight, '' . $resultPortletObject['pob_render_condition'], 'T', 'L', 0, 0);
				if (P('show_pdf_render_condition', "1") == "2") {
										if (!is_null($resultPortletObject['pob_render_condition'])) {
						$tmpCount = (float)$counts["render_condition"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["render_condition"] = $tmpCount;
					}
				}
				if (P('show_pdf_render_condition', "1") == "3") {
										if (!is_null($resultPortletObject['pob_render_condition'])) {
						$tmpSum = (float)$sums["render_condition"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_render_condition'];
						}
						$sums["render_condition"] = $tmpSum;
					}
				}
				if (P('show_pdf_render_condition', "1") == "4") {
										if (!is_null($resultPortletObject['pob_render_condition'])) {
						$tmpCount = (float)$avgCounts["render_condition"];
						$tmpSum = (float)$avgSums["render_condition"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["render_condition"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_render_condition'];
						}
						$avgSums["render_condition"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_autorefresh', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['autorefresh'], $colHeight, '' . $resultPortletObject['pob_autorefresh'], 'T', 'R', 0, 0);
				if (P('show_pdf_autorefresh', "1") == "2") {
										if (!is_null($resultPortletObject['pob_autorefresh'])) {
						$tmpCount = (float)$counts["autorefresh"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["autorefresh"] = $tmpCount;
					}
				}
				if (P('show_pdf_autorefresh', "1") == "3") {
										if (!is_null($resultPortletObject['pob_autorefresh'])) {
						$tmpSum = (float)$sums["autorefresh"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_autorefresh'];
						}
						$sums["autorefresh"] = $tmpSum;
					}
				}
				if (P('show_pdf_autorefresh', "1") == "4") {
										if (!is_null($resultPortletObject['pob_autorefresh'])) {
						$tmpCount = (float)$avgCounts["autorefresh"];
						$tmpSum = (float)$avgSums["autorefresh"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["autorefresh"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletObject['pob_autorefresh'];
						}
						$avgSums["autorefresh"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_portlet_object', "1") == "1") {
			$parentValue = virgoPortletObject::lookup($resultPortletObject['pob_pob_id']);
			$tmpLn = $pdf->MultiCell($minWidth['portlet object $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			$dummyText = "";
			for ($iTmp = 0; $iTmp < $maxLn; $iTmp++) {
				$dummyText .= " 
";
			}
			$pdf->MultiCell(4, $colHeight, $dummyText, '0', 'L', 0, 1); 
//			$pdf->Cell(1, $colHeight, '', 0, 0); //, 0, 1);
//			$pdf->ln(50); //$maxLn * ($fontSize - 1) / 2);
		}
		if (sizeof($counts) > 0) {
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			$tmpWidth = 0;
			$labelDone = false;
			if (P('show_pdf_show_title', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['show title'];
				if (P('show_pdf_show_title', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["show_title"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_custom_title', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['custom title'];
				if (P('show_pdf_custom_title', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["custom_title"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_left', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['left'];
				if (P('show_pdf_left', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["left"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_top', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['top'];
				if (P('show_pdf_top', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["top"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_width', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['width'];
				if (P('show_pdf_width', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["width"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_height', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['height'];
				if (P('show_pdf_height', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["height"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_inline', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['inline'];
				if (P('show_pdf_inline', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["inline"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_ajax', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['ajax'];
				if (P('show_pdf_ajax', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["ajax"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_render_condition', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['render condition'];
				if (P('show_pdf_render_condition', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["render_condition"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_autorefresh', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['autorefresh'];
				if (P('show_pdf_autorefresh', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["autorefresh"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
		}
		$pdf->Ln();
		if (sizeof($sums) > 0) {
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			$tmpWidth = 0;
			$labelDone = false;
			if (P('show_pdf_show_title', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['show title'];
				if (P('show_pdf_show_title', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["show_title"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_custom_title', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['custom title'];
				if (P('show_pdf_custom_title', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["custom_title"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_left', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['left'];
				if (P('show_pdf_left', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["left"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_top', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['top'];
				if (P('show_pdf_top', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["top"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_width', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['width'];
				if (P('show_pdf_width', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["width"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_height', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['height'];
				if (P('show_pdf_height', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["height"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_inline', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['inline'];
				if (P('show_pdf_inline', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["inline"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_ajax', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['ajax'];
				if (P('show_pdf_ajax', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["ajax"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_render_condition', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['render condition'];
				if (P('show_pdf_render_condition', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["render_condition"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_autorefresh', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['autorefresh'];
				if (P('show_pdf_autorefresh', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["autorefresh"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
		}
		$pdf->Ln();
		if (sizeof($avgCounts) > 0 && sizeof($avgSums) > 0) {
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			$tmpWidth = 0;
			$labelDone = false;
			if (P('show_pdf_show_title', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['show title'];
				if (P('show_pdf_show_title', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["show_title"] == 0 ? "-" : $avgSums["show_title"] / $avgCounts["show_title"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_custom_title', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['custom title'];
				if (P('show_pdf_custom_title', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["custom_title"] == 0 ? "-" : $avgSums["custom_title"] / $avgCounts["custom_title"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_left', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['left'];
				if (P('show_pdf_left', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["left"] == 0 ? "-" : $avgSums["left"] / $avgCounts["left"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_top', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['top'];
				if (P('show_pdf_top', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["top"] == 0 ? "-" : $avgSums["top"] / $avgCounts["top"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_width', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['width'];
				if (P('show_pdf_width', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["width"] == 0 ? "-" : $avgSums["width"] / $avgCounts["width"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_height', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['height'];
				if (P('show_pdf_height', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["height"] == 0 ? "-" : $avgSums["height"] / $avgCounts["height"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_inline', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['inline'];
				if (P('show_pdf_inline', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["inline"] == 0 ? "-" : $avgSums["inline"] / $avgCounts["inline"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_ajax', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['ajax'];
				if (P('show_pdf_ajax', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["ajax"] == 0 ? "-" : $avgSums["ajax"] / $avgCounts["ajax"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_render_condition', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['render condition'];
				if (P('show_pdf_render_condition', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["render_condition"] == 0 ? "-" : $avgSums["render_condition"] / $avgCounts["render_condition"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_autorefresh', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['autorefresh'];
				if (P('show_pdf_autorefresh', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["autorefresh"] == 0 ? "-" : $avgSums["autorefresh"] / $avgCounts["autorefresh"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
		}
		$pdf->Ln();
		$pdf->SetFont($font, '', $fontSize);
		$pdf->Output($reportTitle. '_' . date ("Ymd_His") . '.pdf', 'I'); 		ini_set('display_errors', '1');
		return 0;
			}
		
		static function portletActionExport() {
			$data = "";
			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('PORTLET_OBJECTS');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultPortletObject = new virgoPortletObject();
			$whereClausePortletObject = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePortletObject = $whereClausePortletObject . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_show_title', "1") != "0") {
					$data = $data . $stringDelimeter .'Show title' . $stringDelimeter . $separator;
				}
				if (P('show_export_custom_title', "1") != "0") {
					$data = $data . $stringDelimeter .'Custom title' . $stringDelimeter . $separator;
				}
				if (P('show_export_left', "1") != "0") {
					$data = $data . $stringDelimeter .'Left' . $stringDelimeter . $separator;
				}
				if (P('show_export_top', "1") != "0") {
					$data = $data . $stringDelimeter .'Top' . $stringDelimeter . $separator;
				}
				if (P('show_export_width', "1") != "0") {
					$data = $data . $stringDelimeter .'Width' . $stringDelimeter . $separator;
				}
				if (P('show_export_height', "1") != "0") {
					$data = $data . $stringDelimeter .'Height' . $stringDelimeter . $separator;
				}
				if (P('show_export_inline', "1") != "0") {
					$data = $data . $stringDelimeter .'Inline' . $stringDelimeter . $separator;
				}
				if (P('show_export_ajax', "1") != "0") {
					$data = $data . $stringDelimeter .'Ajax' . $stringDelimeter . $separator;
				}
				if (P('show_export_render_condition', "1") != "0") {
					$data = $data . $stringDelimeter .'Render condition' . $stringDelimeter . $separator;
				}
				if (P('show_export_autorefresh', "1") != "0") {
					$data = $data . $stringDelimeter .'Autorefresh' . $stringDelimeter . $separator;
				}
				if (P('show_export_portlet_definition', "1") != "0") {
					$data = $data . $stringDelimeter . 'Portlet definition ' . $stringDelimeter . $separator;
				}
				if (P('show_export_portlet_object', "1") != "0") {
					$data = $data . $stringDelimeter . 'Portlet object ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_portlet_objects.pob_id, prt_portlet_objects.pob_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_show_title', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_show_title pob_show_title";
			} else {
				if ($defaultOrderColumn == "pob_show_title") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_show_title ";
				}
			}
			if (P('show_export_custom_title', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_custom_title pob_custom_title";
			} else {
				if ($defaultOrderColumn == "pob_custom_title") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_custom_title ";
				}
			}
			if (P('show_export_left', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_left pob_left";
			} else {
				if ($defaultOrderColumn == "pob_left") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_left ";
				}
			}
			if (P('show_export_top', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_top pob_top";
			} else {
				if ($defaultOrderColumn == "pob_top") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_top ";
				}
			}
			if (P('show_export_width', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_width pob_width";
			} else {
				if ($defaultOrderColumn == "pob_width") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_width ";
				}
			}
			if (P('show_export_height', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_height pob_height";
			} else {
				if ($defaultOrderColumn == "pob_height") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_height ";
				}
			}
			if (P('show_export_inline', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_inline pob_inline";
			} else {
				if ($defaultOrderColumn == "pob_inline") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_inline ";
				}
			}
			if (P('show_export_ajax', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_ajax pob_ajax";
			} else {
				if ($defaultOrderColumn == "pob_ajax") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_ajax ";
				}
			}
			if (P('show_export_render_condition', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_render_condition pob_render_condition";
			} else {
				if ($defaultOrderColumn == "pob_render_condition") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_render_condition ";
				}
			}
			if (P('show_export_autorefresh', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_autorefresh pob_autorefresh";
			} else {
				if ($defaultOrderColumn == "pob_autorefresh") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_autorefresh ";
				}
			}
			if (class_exists('portal\virgoPortletDefinition') && P('show_export_portlet_definition', "1") != "0") { // */ && !in_array("pdf", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_objects.pob_pdf_id as pob_pdf_id ";
				$queryString = $queryString . ", prt_portlet_definitions_parent.pdf_virgo_title as `portlet_definition` ";
			} else {
				if ($defaultOrderColumn == "portlet_definition") {
					$orderColumnNotDisplayed = " prt_portlet_definitions_parent.pdf_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_export_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_objects.pob_pob_id as pob_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portlet_objects ";
			if (class_exists('portal\virgoPortletDefinition')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_definitions AS prt_portlet_definitions_parent ON (prt_portlet_objects.pob_pdf_id = prt_portlet_definitions_parent.pdf_id) ";
			}
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_portlet_objects.pob_pob_id = prt_portlet_objects_parent.pob_id) ";
			}

			$resultsPortletObject = $resultPortletObject->select(
				'', 
				'all', 
				$resultPortletObject->getOrderColumn(), 
				$resultPortletObject->getOrderMode(), 
				$whereClausePortletObject,
				$queryString);
			foreach ($resultsPortletObject as $resultPortletObject) {
				if (P('show_export_show_title', "1") != "0") {
			$data = $data . $resultPortletObject['pob_show_title'] . $separator;
				}
				if (P('show_export_custom_title', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPortletObject['pob_custom_title'] . $stringDelimeter . $separator;
				}
				if (P('show_export_left', "1") != "0") {
			$data = $data . $resultPortletObject['pob_left'] . $separator;
				}
				if (P('show_export_top', "1") != "0") {
			$data = $data . $resultPortletObject['pob_top'] . $separator;
				}
				if (P('show_export_width', "1") != "0") {
			$data = $data . $resultPortletObject['pob_width'] . $separator;
				}
				if (P('show_export_height', "1") != "0") {
			$data = $data . $resultPortletObject['pob_height'] . $separator;
				}
				if (P('show_export_inline', "1") != "0") {
			$data = $data . $resultPortletObject['pob_inline'] . $separator;
				}
				if (P('show_export_ajax', "1") != "0") {
			$data = $data . $resultPortletObject['pob_ajax'] . $separator;
				}
				if (P('show_export_render_condition', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPortletObject['pob_render_condition'] . $stringDelimeter . $separator;
				}
				if (P('show_export_autorefresh', "1") != "0") {
			$data = $data . $resultPortletObject['pob_autorefresh'] . $separator;
				}
				if (P('show_export_portlet_definition', "1") != "0") {
					$parentValue = virgoPortletDefinition::lookup($resultPortletObject['pob_pdf_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_portlet_object', "1") != "0") {
					$parentValue = virgoPortletObject::lookup($resultPortletObject['pob_pob_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				$data = $data . "\n"; 
			}
			D($data, $reportTitle, "text/csv"); 
		}
				
		static function portletActionOffline() {
			require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'PHPExcel'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'PHPExcel.php');		
			require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'PHPExcel'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'PHPExcel'.DIRECTORY_SEPARATOR.'Writer'.DIRECTORY_SEPARATOR.'Excel2007.php');		
			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('PORTLET_OBJECTS');
			}
			$objPHPExcel = new \PHPExcel();
			$objPHPExcel->getProperties()->setCreator("virgo by METADETRON");
			$objPHPExcel->getProperties()->setLastModifiedBy("");
			$objPHPExcel->getProperties()->setTitle($reportTitle);
			$objPHPExcel->getProperties()->setSubject("");
			$objPHPExcel->getProperties()->setDescription("virgo generated Excel Sheet for offline data edition");
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->getProtection()->setPassword('virgo');
			$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
			$objPHPExcel->getActiveSheet()->setTitle($reportTitle);
			$resultPortletObject = new virgoPortletObject();
			$whereClausePortletObject = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePortletObject = $whereClausePortletObject . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_show_title', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Show title');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_custom_title', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Custom title');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_left', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Left');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_top', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Top');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_width', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Width');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_height', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Height');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_inline', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Inline');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_ajax', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Ajax');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_render_condition', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Render condition');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_autorefresh', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Autorefresh');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_portlet_definition', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Portlet definition ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoPortletDefinition::getVirgoList();
					$formulaPortletDefinition = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaPortletDefinition != "") {
							$formulaPortletDefinition = $formulaPortletDefinition . ',';
						}
						$formulaPortletDefinition = $formulaPortletDefinition . $key;
					}
				}
				if (P('show_export_portlet_object', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Portlet object ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoPortletObject::getVirgoList();
					$formulaPortletObject = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaPortletObject != "") {
							$formulaPortletObject = $formulaPortletObject . ',';
						}
						$formulaPortletObject = $formulaPortletObject . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_portlet_objects.pob_id, prt_portlet_objects.pob_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_show_title', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_show_title pob_show_title";
			} else {
				if ($defaultOrderColumn == "pob_show_title") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_show_title ";
				}
			}
			if (P('show_export_custom_title', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_custom_title pob_custom_title";
			} else {
				if ($defaultOrderColumn == "pob_custom_title") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_custom_title ";
				}
			}
			if (P('show_export_left', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_left pob_left";
			} else {
				if ($defaultOrderColumn == "pob_left") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_left ";
				}
			}
			if (P('show_export_top', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_top pob_top";
			} else {
				if ($defaultOrderColumn == "pob_top") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_top ";
				}
			}
			if (P('show_export_width', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_width pob_width";
			} else {
				if ($defaultOrderColumn == "pob_width") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_width ";
				}
			}
			if (P('show_export_height', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_height pob_height";
			} else {
				if ($defaultOrderColumn == "pob_height") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_height ";
				}
			}
			if (P('show_export_inline', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_inline pob_inline";
			} else {
				if ($defaultOrderColumn == "pob_inline") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_inline ";
				}
			}
			if (P('show_export_ajax', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_ajax pob_ajax";
			} else {
				if ($defaultOrderColumn == "pob_ajax") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_ajax ";
				}
			}
			if (P('show_export_render_condition', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_render_condition pob_render_condition";
			} else {
				if ($defaultOrderColumn == "pob_render_condition") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_render_condition ";
				}
			}
			if (P('show_export_autorefresh', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_objects.pob_autorefresh pob_autorefresh";
			} else {
				if ($defaultOrderColumn == "pob_autorefresh") {
					$orderColumnNotDisplayed = " prt_portlet_objects.pob_autorefresh ";
				}
			}
			if (class_exists('portal\virgoPortletDefinition') && P('show_export_portlet_definition', "1") != "0") { // */ && !in_array("pdf", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_objects.pob_pdf_id as pob_pdf_id ";
				$queryString = $queryString . ", prt_portlet_definitions_parent.pdf_virgo_title as `portlet_definition` ";
			} else {
				if ($defaultOrderColumn == "portlet_definition") {
					$orderColumnNotDisplayed = " prt_portlet_definitions_parent.pdf_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_export_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_objects.pob_pob_id as pob_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portlet_objects ";
			if (class_exists('portal\virgoPortletDefinition')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_definitions AS prt_portlet_definitions_parent ON (prt_portlet_objects.pob_pdf_id = prt_portlet_definitions_parent.pdf_id) ";
			}
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_portlet_objects.pob_pob_id = prt_portlet_objects_parent.pob_id) ";
			}

			$resultsPortletObject = $resultPortletObject->select(
				'', 
				'all', 
				$resultPortletObject->getOrderColumn(), 
				$resultPortletObject->getOrderMode(), 
				$whereClausePortletObject,
				$queryString);
			$index = 1;
			foreach ($resultsPortletObject as $resultPortletObject) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultPortletObject['pob_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_show_title', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletObject['pob_show_title'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_custom_title', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletObject['pob_custom_title'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_left', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletObject['pob_left'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_top', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletObject['pob_top'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_width', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletObject['pob_width'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_height', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletObject['pob_height'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_inline', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletObject['pob_inline'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_ajax', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletObject['pob_ajax'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_render_condition', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletObject['pob_render_condition'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_autorefresh', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletObject['pob_autorefresh'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_portlet_definition', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoPortletDefinition::lookup($resultPortletObject['pob_pdf_id']);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, $index, $parentValue);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
					$objValidation = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->getDataValidation();
					$objValidation->setType( \PHPExcel_Cell_DataValidation::TYPE_LIST );
					$objValidation->setErrorStyle( \PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
					$objValidation->setAllowBlank(false);
					$objValidation->setShowInputMessage(true);
					$objValidation->setShowErrorMessage(true);
					$objValidation->setShowDropDown(true);
					$objValidation->setErrorTitle('Input error');
					$objValidation->setError('Value is not in list.');
					$objValidation->setPromptTitle('Pick from list');
					$objValidation->setPrompt('Please pick a value from the drop-down list.');
					$objValidation->setFormula1('"' . $formulaPortletDefinition . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
				if (P('show_export_portlet_object', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoPortletObject::lookup($resultPortletObject['pob_pob_id']);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, $index, $parentValue);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
					$objValidation = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->getDataValidation();
					$objValidation->setType( \PHPExcel_Cell_DataValidation::TYPE_LIST );
					$objValidation->setErrorStyle( \PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
					$objValidation->setAllowBlank(false);
					$objValidation->setShowInputMessage(true);
					$objValidation->setShowErrorMessage(true);
					$objValidation->setShowDropDown(true);
					$objValidation->setErrorTitle('Input error');
					$objValidation->setError('Value is not in list.');
					$objValidation->setPromptTitle('Pick from list');
					$objValidation->setPrompt('Please pick a value from the drop-down list.');
					$objValidation->setFormula1('"' . $formulaPortletObject . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
			}
		    for($i = 1; $i <= $iloscKolumn; $i++) {
		        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
		    }
		    $objPHPExcel->getActiveSheet()->calculateColumnWidths();
			$objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
			
			header('Content-Type: application/vnd.ms-excel');
			if (headers_sent()) {
				echo 'Some data has already been output to browser';
			}
			header('Content-Disposition: attachment; filename="' . $reportTitle . '.xlsx";');
//			header('Content-Length: '.strlen($data));		
			$objWriter->save("php://output");			
			exit();
		}		
		
		static function portletActionUpload() {
			$userfile = $_FILES['virgo_upload_file'];
			if ( $userfile['error'] || $userfile['size'] < 1 ) {
				L("$messages.FILE_NOT_UPLOADED", '', 'ERROR');		 
			} else {
// PATH_TXTUPL is not reliable? Lets use $config->getValue('tmp_path') instead
//				$componentParams = null;
//				$separatorString = $componentParams->get('field_separator_in_import');
				$separatorString = P('field_separator');
				if (is_null($separatorString) || $separatorString == "") {
					$separatorString = ",";
				} elseif ($separatorString == "TAB") {
					$separatorString = "\t";
				}
				$this->setImportFieldSeparator($separatorString);
				$tmp_dest = PORTAL_PATH.DIRECTORY_SEPARATOR."tmp".DIRECTORY_SEPARATOR.'tmp_upload_'.date("YmdHis").'.txt';
				$tmp_src   = $userfile['tmp_name'];
//				$user =& JFactory::getUser();
				if ( move_uploaded_file($tmp_src, $tmp_dest ) ) {
					$fh = fopen($tmp_dest, 'r');
					$firstLine = fgets($fh);
					$columns = split($separatorString, $firstLine);
					$propertyColumnHash = array();
					$propertyDateFormatHash = array();
					$propertyClassHash = array();
					$propertyColumnHash['show title'] = 'pob_show_title';
					$propertyColumnHash['show_title'] = 'pob_show_title';
					$propertyColumnHash['custom title'] = 'pob_custom_title';
					$propertyColumnHash['custom_title'] = 'pob_custom_title';
					$propertyColumnHash['left'] = 'pob_left';
					$propertyColumnHash['left'] = 'pob_left';
					$propertyColumnHash['top'] = 'pob_top';
					$propertyColumnHash['top'] = 'pob_top';
					$propertyColumnHash['width'] = 'pob_width';
					$propertyColumnHash['width'] = 'pob_width';
					$propertyColumnHash['height'] = 'pob_height';
					$propertyColumnHash['height'] = 'pob_height';
					$propertyColumnHash['inline'] = 'pob_inline';
					$propertyColumnHash['inline'] = 'pob_inline';
					$propertyColumnHash['ajax'] = 'pob_ajax';
					$propertyColumnHash['ajax'] = 'pob_ajax';
					$propertyColumnHash['render condition'] = 'pob_render_condition';
					$propertyColumnHash['render_condition'] = 'pob_render_condition';
					$propertyColumnHash['autorefresh'] = 'pob_autorefresh';
					$propertyColumnHash['autorefresh'] = 'pob_autorefresh';
					$propertyClassHash['portlet definition'] = 'PortletDefinition';
					$propertyClassHash['portlet_definition'] = 'PortletDefinition';
					$propertyColumnHash['portlet definition'] = 'pob_pdf_id';
					$propertyColumnHash['portlet_definition'] = 'pob_pdf_id';
					$propertyClassHash['portlet object'] = 'PortletObject';
					$propertyClassHash['portlet_object'] = 'PortletObject';
					$propertyColumnHash['portlet object'] = 'pob_pob_id';
					$propertyColumnHash['portlet_object'] = 'pob_pob_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importPortletObject = new virgoPortletObject();
						$line = fgets($fh);
						if (is_null($line) || trim($line) == "") {
						} else {
							$values = split($separatorString, $line);
							$index = 0;
							foreach ($values as $value) {
								$value = trim($value);
								if (isset($columns[$index]) && trim($columns[$index]) != "VIRGO_IGNORE") {
									$fieldName = $propertyColumnHash[trim($columns[$index])];
									if (substr($fieldName, strlen($fieldName) - 3) == "_id") {
										$className = 'virgo' . $propertyClassHash[trim($columns[$index])];
										$parent = new $className();
										$value = $parent->getIdByVirgoTitle($value);
									}
									if (is_null($fieldName)) {
										L(T('PROPERTY_NOT_FOUND', T('PORTLET_OBJECT'), $columns[$index]), '', 'ERROR');
										return;
									} else {
										if (isset($propertyDateFormatHash[$fieldName])) {
											$dateFormat = $propertyDateFormatHash[$fieldName];
											if (version_compare(PHP_VERSION, '5.3.0') >= 0) {												
												$dateInfo = date_parse_from_format($dateFormat, $value);
												$value = $dateInfo['day'] . '.' . $dateInfo['month'] . '.' . $dateFormat['year'];

											}
											$value = date(DATE_FORMAT, strtotime($value));
										}
										$importPortletObject->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_portlet_definition');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoPortletDefinition::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoPortletDefinition::token2Id($tmpToken);
	}
	$importPortletObject->setPdfId($defaultValue);
}
$defaultValue = P('import_default_value_portlet_object');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoPortletObject::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoPortletObject::token2Id($tmpToken);
	}
	$importPortletObject->setPobId($defaultValue);
}
							$errorMessage = $importPortletObject->store();
							if ($errorMessage != "") {
								if ($importMode == "T") {
									L($errorMessage, '', 'ERROR');
									fclose($fh);
									unset($propertyColumnHash);
									unset($propertyClassHash); 
									return -1;
								} else {
									$recordsError++;
									L('Error on import: ' . $errorMessage, '', 'WARN');
								}
							} else {
								$recordsOK++;
							}
						}
					}
					fclose($fh);
					unset($propertyColumnHash);
					unset($propertyClassHash); 
					L(T('VALUES_UPLOADED', $recordsOK, $recordsError), '', 'INFO'); 
					return 0;
				}
			}
		}
		


		static function portletActionAddSelectedToNMRecordPage() {
			$pageId = R('plc_page_');
			$idsToDeleteString = R('ids');
			$idsToDelete = split(",", $idsToDeleteString);
			foreach ($idsToDelete as $idToDelete) {
				$newPortletLocation = new virgoPortletLocation();
				$newPortletLocation->setPobId($idToDelete);
				$newPortletLocation->setPgeId($pageId);
				$errorMessage = $newPortletLocation->store();
				if ($errorMessage != "") {
					L($errorMessage, '', 'ERROR');
					return -1;
				}

			}
			self::setDisplayMode("TABLE");
			return 0;
		}
		static function portletActionAddSelectedToNMRecordPortal() {
			$portalId = R('plc_portal_');
			$idsToDeleteString = R('ids');
			$idsToDelete = split(",", $idsToDeleteString);
			foreach ($idsToDelete as $idToDelete) {
				$newPortletLocation = new virgoPortletLocation();
				$newPortletLocation->setPobId($idToDelete);
				$newPortletLocation->setPrtId($portalId);
				$errorMessage = $newPortletLocation->store();
				if ($errorMessage != "") {
					L($errorMessage, '', 'ERROR');
					return -1;
				}

			}
			self::setDisplayMode("TABLE");
			return 0;
		}


		static function portletActionVirgoSetPortletDefinition() {
			$this->loadFromDB();
			$parentId = R('pob_PortletDefinition_id_' . $_SESSION['current_portlet_object_id']);
			$this->setPdfId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetPortletObject() {
			$this->loadFromDB();
			$parentId = R('pob_PortletObject_id_' . $_SESSION['current_portlet_object_id']);
			$this->setPobId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}

		static function portletActionAddPortletDefinition() {
			self::setDisplayMode("ADD_NEW_PARENT_PORTLET_DEFINITION");
		}

		static function portletActionStoreNewPortletDefinition() {
			$id = -1;
			if (virgoPortletDefinition::portletActionStore(true, $id) == -1) {
				self::setDisplayMode("ADD_NEW_PARENT_PORTLET_DEFINITION");
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			} else {
				$tmpId = self::loadIdFromRequest();
				$_POST['pob_portletDefinition_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
				self::portletActionBackFromParent();
			}
		}

		static function portletActionBackFromParent() {
			$calligView = strtoupper(R('calling_view'));
			self::setDisplayMode($calligView);
			$pob = self::getMyPortletObject();
			$pob->setPortletSessionValue('reload_from_request', '1');				
		}

		function getContent() {
			ob_start();
			include(PORTAL_PATH . DIRECTORY_SEPARATOR . 'portlets' . DIRECTORY_SEPARATOR . $this->getPortletDefinition()->getNamespace() . DIRECTORY_SEPARATOR . $this->getPortletDefinition()->getAlias() . DIRECTORY_SEPARATOR . 'content.php');
			$out = ob_get_contents();
			ob_end_clean();
			$customCss = virgoPortletObject::getParameterValue('portlet_css', $this->getId());
			$extraCss = "";
			if (isset($customCss)) {
				$customCss = preg_replace("/\}\s/", "}\r\ndiv#portlet_container_{$this->getId()} ", $customCss);
				$resultCustomCss = preg_replace("/,/", ", div#portlet_container_{$this->getId()} ", $customCss);
				$extraCss = <<<EXTRA_CSS
<style type="text/css">
div#portlet_container_{$this->getId()} {$resultCustomCss}
</style>
EXTRA_CSS;
			}
			return $extraCss . $out;
		}
		
		function getCurrentId() {
			return is_null($this->getId()) ? $_SESSION['current_portlet_object_id'] : $this->getId();
		}		
		
		function setPortletSessionValue($name, $value) {
			self::setSessionValue('Portlet-' . $this->getCurrentId(), $name, $value);
		}
		
		function getPortletSessionValue($name, $default) {
			return self::getSessionValue('Portlet-' . $this->getCurrentId(), $name, $default);
		}

		static function getCurrentPortletSessionValue($name, $default) {
			return self::getSessionValue('Portlet-' . $_SESSION['current_portlet_object_id'], $name, $default);
		}
		
		static function getParameterValue($name, $pobId, $alias = null, $namespace = null) {
			if (isset($alias) && isset($namespace)) {
				$query = <<<SQL
SELECT 
	ppr_value
FROM 
	prt_portlet_definitions, 
	prt_portlet_parameters 
WHERE 
	ppr_name = ?
AND pdf_alias = ?
AND pdf_namespace = ?
AND pdf_id = ppr_pdf_id
SQL;
				$rows = QPR($query, "sss", array($name, $alias, $namespace));
				foreach ($rows as $row) {
					return $row['ppr_value'];
				}
				return null;
			}
			$query = <<<SQL
SELECT
	ppr_value
FROM
	prt_portlet_objects,
	prt_portlet_parameters
WHERE 
	pob_id = ?
	AND (ppr_pdf_id = pob_pdf_id OR ppr_pob_id = pob_id)
	AND ppr_name = ?
ORDER BY 
	ppr_pdf_id
SQL;
			return QP1($query, "is", array($pobId, $name));
		}
		
		static function getParameterValues($name, $pobId) {
			$query = <<<SQL
SELECT
	ppr_value
FROM
	prt_portlet_parameters
WHERE 
	ppr_pob_id = ?
	AND ppr_name = ?
SQL;
			$ret = array();
			$rows = QPR($query, "is", array($pobId, $name));
			if (count($rows) == 1 && strpos($rows[0]['ppr_value'],",") !== false) {
				$ret = explode(",", $rows[0]['ppr_value']);
			} else {
				foreach ($rows as $row) {
					$ret[] = $row['ppr_value'];
				}
			}
			return $ret;
		}
		
		function canEdit() {
			$cached = C("_can_edit", $ret);
			if ($cached) {
				return $ret;
			}
			return CS("_can_edit", virgoRole::can(null, $this->getId(), 'edit'));
		}
		
		function canView() {
			$cached = C("_can_view", $ret);
			if ($cached) {
				return $ret;
			}
			return CS("_can_view", virgoRole::can(null, $this->getId(), 'view'));
		}
		
		function canConfigure() {
			$cached = C("_can_configure", $ret);
			if ($cached) {
				return $ret;
			}
			return CS("_can_configure", virgoRole::can(null, $this->getId(), 'configure'));
		}
		
		function canExecute($action) {
			$cached = C("_can_execute_{$action}", $ret);
			if ($cached) {
				return $ret;
			}
			return CS("_can_execute_{$action}", virgoRole::canExecute($this->getId(), $action));
		}
		
		function portletActionGridDown() {
			$this->loadFromDB();
			$this->setTop(!is_null($this->getTop()) ? $this->getTop() + 1 : 1);
			$this->store();
		}
		
		function portletActionGridUp() {
			$this->loadFromDB();
			if ($this->getTop() > 0) {
				$this->setTop(!is_null($this->getTop()) ? $this->getTop() - 1 : 0);
				$this->store();
			}
		}
		
		function portletActionGridRight() {
			$this->loadFromDB();
			$this->setLeft(!is_null($this->getLeft()) ? $this->getLeft() + 1 : 1);
			$this->store();
		}
		
		function portletActionGridLeft() {
			$this->loadFromDB();
			if ($this->getLeft() > 0) {
				$this->setLeft(!is_null($this->getLeft()) ? $this->getLeft() - 1 : 0);
				$this->store();
			}
		}
		
		function portletActionGridHigher() {
			$this->loadFromDB();
			$this->setHeight(!is_null($this->getHeight()) ? $this->getHeight() + 1 : 2);
			$this->store();
		}
		
		function portletActionGridLower() {
			$this->loadFromDB();
			if ($this->getHeight() > 0) {
				$this->setHeight(!is_null($this->getHeight()) ? $this->getHeight() - 1 : 0);
				$this->store();
			}
		}
		
		function portletActionGridWider() {
			$this->loadFromDB();
			$this->setWidth(!is_null($this->getWidth()) ? $this->getWidth() + 1 : 2);
			$this->store();
		}
		
		function portletActionGridNarrower() {
			$this->loadFromDB();
			if ($this->getWidth() > 0) {
				$this->setWidth(!is_null($this->getWidth()) ? $this->getWidth() - 1 : 0);
				$this->store();
			}
		}

		function getTitle() {
			return $this->getCustomTitle() == "" ? $this->getPortletDefinition()->getName() : $this->getCustomTitle();
		}

		static function getIdByTitleAndAlias($title, $alias) {
			$query = <<<SQL
SELECT
    pob_id
FROM 
    prt_portlet_objects
    LEFT OUTER JOIN prt_portlet_definitions ON (pob_pdf_id = pdf_id)
WHERE
  pob_custom_title = ?
  AND pdf_alias = ?
SQL;
			$rows = QR($query, "ss", array($title, $alias));
			foreach ($rows as $row) {
				return $row['pob_id'];
			}
			return null;
		}


		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `prt_portlet_objects` (
  `pob_id` bigint(20) unsigned NOT NULL auto_increment,
  `pob_virgo_state` varchar(50) default NULL,
  `pob_virgo_title` varchar(255) default NULL,
	`pob_pdf_id` int(11) default NULL,
	`pob_pob_id` int(11) default NULL,
  `pob_show_title` boolean,  
  `pob_custom_title` varchar(255), 
  `pob_left` integer,  
  `pob_top` integer,  
  `pob_width` integer,  
  `pob_height` integer,  
  `pob_inline` boolean,  
  `pob_ajax` boolean,  
  `pob_render_condition` longtext, 
  `pob_autorefresh` integer,  
  `pob_date_created` datetime NOT NULL,
  `pob_date_modified` datetime default NULL,
  `pob_usr_created_id` int(11) NOT NULL,
  `pob_usr_modified_id` int(11) default NULL,
  KEY `pob_pdf_fk` (`pob_pdf_id`),
  KEY `pob_pob_fk` (`pob_pob_id`),
  PRIMARY KEY  (`pob_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/portlet_object.sql 
INSERT INTO `prt_portlet_objects` (`pob_virgo_title`, `pob_show_title`, `pob_custom_title`, `pob_left`, `pob_top`, `pob_width`, `pob_height`, `pob_inline`, `pob_ajax`, `pob_render_condition`, `pob_autorefresh`) 
VALUES (title, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_portlet_objects table already exists.", '', 'FATAL');
				L("Error ocurred, please contact site Administrator.", '', 'ERROR');
 				return false;
 			}
 			return true;
 		}


		static function onInstall($pobId, $title) {
		}


		static function token2Id($token, $extraLimit = null) {
			if (S($token)) {
				$ids = self::selectAllAsIdsStatic($extraLimit, true);
				foreach ($ids as $id) {
					if (getTokenValue($id) == $token) {
						return $id;
					}
				}
			}
			return null;
		}

		static function getMyPortletObject() {
			if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php')) {
				require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');
				$pobId = $_SESSION['current_portlet_object_id'];
				return new virgoPortletObject($pobId);
			}
			return null;
		}
		
		static function getPrefix() {
			return "pob";
		}
		
		static function getPlural() {
			return "portlet_objects";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoPortletDefinition";
			$ret[] = "virgoPortletObject";
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoPortletLocation";
			$ret[] = "virgoHtmlContent";
			$ret[] = "virgoPortletParameter";
			$ret[] = "virgoPermission";
			$ret[] = "virgoPortletObject";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_portlet_objects'));
			foreach ($rows as $row) {
				return $row['table_type'];
			}
			return "";
		}
		
		static function getStructureVersion() {
			return "1.5" . 
''
			;
		}
		
		static function getVirgoVersion() {
			return
"2.0.0.0"  
			;
		}
		
		static function checkCompatibility() {
			$virgoVersion = virgoPortletObject::getVirgoVersion();
			if ($virgoVersion == INDEX_VERSION) {
				return 1;
			}
			$virgoVersionNumber = substr($virgoVersion, 0, strpos($virgoVersion, "."));
			$portalVersionNumber = substr(INDEX_VERSION, 0, strpos(INDEX_VERSION, "."));
			if ($virgoVersionNumber == $portalVersionNumber) {
				return 0;
			}
			return -1;
		}



		static function getParentInContext($parentName) {
			$parentsInContext = self::getParentsInContext();
			if (isset($parentsInContext[$parentName])) {
				$parentInfo = $parentsInContext[$parentName];
				if (isset($parentInfo['contextId'])) {
					return $parentInfo['contextId'];
				} else {
					return null;
				}
			} else {
				return null;
			}
		}

		/****************** database selects ******************/
		
	}
	
	

