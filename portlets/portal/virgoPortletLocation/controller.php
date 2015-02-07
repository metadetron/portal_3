<?php
/**
* Module Portlet location
* @package Portal
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace portal;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoPortletLocation {

		 var  $plc_id = null;
		 var  $plc_section = null;

		 var  $plc_order = null;

		 var  $plc_position = null;

		 var  $plc_pge_id = null;
		 var  $plc_pob_id = null;
		 var  $plc_prt_id = null;

		 var   $plc_date_created = null;
		 var   $plc_usr_created_id = null;
		 var   $plc_date_modified = null;
		 var   $plc_usr_modified_id = null;
		 var   $plc_virgo_title = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoPortletLocation();
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
        	$this->plc_id = null;
		    $this->plc_date_created = null;
		    $this->plc_usr_created_id = null;
		    $this->plc_date_modified = null;
		    $this->plc_usr_modified_id = null;
		    $this->plc_virgo_title = null;
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
			return $this->plc_id;
		}

		function getSection() {
			return $this->plc_section;
		}
		
		 function setSection($val) {
			$this->plc_section = $val;
		}
		function getOrder() {
			return $this->plc_order;
		}
		
		 function setOrder($val) {
			$this->plc_order = $val;
		}
		function getPosition() {
			return $this->plc_position;
		}
		
		 function setPosition($val) {
			$this->plc_position = $val;
		}

		function getPageId() {
			return $this->plc_pge_id;
		}
		
		 function setPageId($val) {
			$this->plc_pge_id = $val;
		}
		function getPortletObjectId() {
			return $this->plc_pob_id;
		}
		
		 function setPortletObjectId($val) {
			$this->plc_pob_id = $val;
		}
		function getPortalId() {
			return $this->plc_prt_id;
		}
		
		 function setPortalId($val) {
			$this->plc_prt_id = $val;
		}

		function getDateCreated() {
			return $this->plc_date_created;
		}
		function getUsrCreatedId() {
			return $this->plc_usr_created_id;
		}
		function getDateModified() {
			return $this->plc_date_modified;
		}
		function getUsrModifiedId() {
			return $this->plc_usr_modified_id;
		}


		function getPgeId() {
			return $this->getPageId();
		}
		
		 function setPgeId($val) {
			$this->setPageId($val);
		}
		function getPobId() {
			return $this->getPortletObjectId();
		}
		
		 function setPobId($val) {
			$this->setPortletObjectId($val);
		}
		function getPrtId() {
			return $this->getPortalId();
		}
		
		 function setPrtId($val) {
			$this->setPortalId($val);
		}

		function loadRecordFromRequest($rowId) {
			$this->plc_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('plc_section_' . $this->plc_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->plc_section = null;
		} else {
			$this->plc_section = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('plc_order_' . $this->plc_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->plc_order = null;
		} else {
			$this->plc_order = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('plc_position_' . $this->plc_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->plc_position = null;
		} else {
			$this->plc_position = $tmpValue;
		}
	}
			$this->plc_pge_id = strval(R('plc_page_' . $this->plc_id));
			$this->plc_pob_id = strval(R('plc_portletObject_' . $this->plc_id));
			$this->plc_prt_id = strval(R('plc_portal_' . $this->plc_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('plc_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaPortletLocation = array();	
			$criteriaFieldPortletLocation = array();	
			$isNullPortletLocation = R('virgo_search_section_is_null');
			
			$criteriaFieldPortletLocation["is_null"] = 0;
			if ($isNullPortletLocation == "not_null") {
				$criteriaFieldPortletLocation["is_null"] = 1;
			} elseif ($isNullPortletLocation == "null") {
				$criteriaFieldPortletLocation["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_section');

//			if ($isSet) {
			$criteriaFieldPortletLocation["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletLocation["section"] = $criteriaFieldPortletLocation;
			$criteriaFieldPortletLocation = array();	
			$isNullPortletLocation = R('virgo_search_order_is_null');
			
			$criteriaFieldPortletLocation["is_null"] = 0;
			if ($isNullPortletLocation == "not_null") {
				$criteriaFieldPortletLocation["is_null"] = 1;
			} elseif ($isNullPortletLocation == "null") {
				$criteriaFieldPortletLocation["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_order_from');
		$dataTypeCriteria["to"] = R('virgo_search_order_to');

//			if ($isSet) {
			$criteriaFieldPortletLocation["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletLocation["order"] = $criteriaFieldPortletLocation;
			$criteriaFieldPortletLocation = array();	
			$isNullPortletLocation = R('virgo_search_position_is_null');
			
			$criteriaFieldPortletLocation["is_null"] = 0;
			if ($isNullPortletLocation == "not_null") {
				$criteriaFieldPortletLocation["is_null"] = 1;
			} elseif ($isNullPortletLocation == "null") {
				$criteriaFieldPortletLocation["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_position_from');
		$dataTypeCriteria["to"] = R('virgo_search_position_to');

//			if ($isSet) {
			$criteriaFieldPortletLocation["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletLocation["position"] = $criteriaFieldPortletLocation;
			$criteriaParent = array();	
			$isNull = R('virgo_search_page_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_page', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaPortletLocation["page"] = $criteriaParent;
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
			$criteriaPortletLocation["portlet_object"] = $criteriaParent;
			$criteriaParent = array();	
			$isNull = R('virgo_search_portal_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_portal', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaPortletLocation["portal"] = $criteriaParent;
			self::setCriteria($criteriaPortletLocation);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_section');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterSection', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterSection', null);
			}
			$tableFilter = R('virgo_filter_order');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterOrder', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterOrder', null);
			}
			$tableFilter = R('virgo_filter_position');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterPosition', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterPosition', null);
			}
			$parentFilter = R('virgo_filter_page');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterPage', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterPage', null);
			}
			$parentFilter = R('virgo_filter_title_page');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitlePage', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitlePage', null);
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
			$parentFilter = R('virgo_filter_portal');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterPortal', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterPortal', null);
			}
			$parentFilter = R('virgo_filter_title_portal');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitlePortal', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitlePortal', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClausePortletLocation = ' 1 = 1 ';
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
				$eventColumn = "plc_" . P('event_column');
				$whereClausePortletLocation = $whereClausePortletLocation . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePortletLocation = $whereClausePortletLocation . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_page');
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
					$inCondition = " prt_portlet_locations.plc_pge_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portlet_locations.plc_pge_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortletLocation = $whereClausePortletLocation . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_portlet_object');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_portlet_locations.plc_pob_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portlet_locations.plc_pob_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortletLocation = $whereClausePortletLocation . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_portal');
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
					$inCondition = " prt_portlet_locations.plc_prt_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portlet_locations.plc_prt_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortletLocation = $whereClausePortletLocation . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaPortletLocation = self::getCriteria();
			if (isset($criteriaPortletLocation["section"])) {
				$fieldCriteriaSection = $criteriaPortletLocation["section"];
				if ($fieldCriteriaSection["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_locations.plc_section IS NOT NULL ';
				} elseif ($fieldCriteriaSection["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_locations.plc_section IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaSection["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_locations.plc_section like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortletLocation["order"])) {
				$fieldCriteriaOrder = $criteriaPortletLocation["order"];
				if ($fieldCriteriaOrder["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_locations.plc_order IS NOT NULL ';
				} elseif ($fieldCriteriaOrder["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_locations.plc_order IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaOrder["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_portlet_locations.plc_order = ? ";
				} else {
					$filter = $filter . " AND prt_portlet_locations.plc_order >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_portlet_locations.plc_order <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPortletLocation["position"])) {
				$fieldCriteriaPosition = $criteriaPortletLocation["position"];
				if ($fieldCriteriaPosition["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_locations.plc_position IS NOT NULL ';
				} elseif ($fieldCriteriaPosition["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_locations.plc_position IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaPosition["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_portlet_locations.plc_position = ? ";
				} else {
					$filter = $filter . " AND prt_portlet_locations.plc_position >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_portlet_locations.plc_position <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPortletLocation["page"])) {
				$parentCriteria = $criteriaPortletLocation["page"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND plc_pge_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portlet_locations.plc_pge_id IN (SELECT pge_id FROM prt_pages WHERE pge_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPortletLocation["portlet_object"])) {
				$parentCriteria = $criteriaPortletLocation["portlet_object"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND plc_pob_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portlet_locations.plc_pob_id IN (SELECT pob_id FROM prt_portlet_objects WHERE pob_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPortletLocation["portal"])) {
				$parentCriteria = $criteriaPortletLocation["portal"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND plc_prt_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portlet_locations.plc_prt_id IN (SELECT prt_id FROM prt_portals WHERE prt_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClausePortletLocation = $whereClausePortletLocation . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClausePortletLocation = $whereClausePortletLocation . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClausePortletLocation = $whereClausePortletLocation . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterSection', null);
				if (S($tableFilter)) {
					$whereClausePortletLocation = $whereClausePortletLocation . " AND plc_section LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterOrder', null);
				if (S($tableFilter)) {
					$whereClausePortletLocation = $whereClausePortletLocation . " AND plc_order LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterPosition', null);
				if (S($tableFilter)) {
					$whereClausePortletLocation = $whereClausePortletLocation . " AND plc_position LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterPage', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePortletLocation = $whereClausePortletLocation . " AND plc_pge_id IS NULL ";
					} else {
						$whereClausePortletLocation = $whereClausePortletLocation . " AND plc_pge_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitlePage', null);
				if (S($parentFilter)) {
					$whereClausePortletLocation = $whereClausePortletLocation . " AND prt_pages_parent.pge_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterPortletObject', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePortletLocation = $whereClausePortletLocation . " AND plc_pob_id IS NULL ";
					} else {
						$whereClausePortletLocation = $whereClausePortletLocation . " AND plc_pob_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitlePortletObject', null);
				if (S($parentFilter)) {
					$whereClausePortletLocation = $whereClausePortletLocation . " AND prt_portlet_objects_parent.pob_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterPortal', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePortletLocation = $whereClausePortletLocation . " AND plc_prt_id IS NULL ";
					} else {
						$whereClausePortletLocation = $whereClausePortletLocation . " AND plc_prt_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitlePortal', null);
				if (S($parentFilter)) {
					$whereClausePortletLocation = $whereClausePortletLocation . " AND prt_portals_parent.prt_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClausePortletLocation;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClausePortletLocation = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_portlet_locations.plc_id, prt_portlet_locations.plc_virgo_title ";
			$defaultOrderColumn = P('default_sort_column', 'plc_order');
			$orderColumnNotDisplayed = "";
			if (P('show_table_section', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_locations.plc_section plc_section";
			} else {
				if ($defaultOrderColumn == "plc_section") {
					$orderColumnNotDisplayed = " prt_portlet_locations.plc_section ";
				}
			}
			if (P('show_table_order', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_locations.plc_order plc_order";
			} else {
				if ($defaultOrderColumn == "plc_order") {
					$orderColumnNotDisplayed = " prt_portlet_locations.plc_order ";
				}
			}
			if (P('show_table_position', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_locations.plc_position plc_position";
			} else {
				if ($defaultOrderColumn == "plc_position") {
					$orderColumnNotDisplayed = " prt_portlet_locations.plc_position ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_table_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_locations.plc_pge_id as plc_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_table_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_locations.plc_pob_id as plc_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortal') && P('show_table_portal', "1") != "0") { // */ && !in_array("prt", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_locations.plc_prt_id as plc_prt_id ";
				$queryString = $queryString . ", prt_portals_parent.prt_virgo_title as `portal` ";
			} else {
				if ($defaultOrderColumn == "portal") {
					$orderColumnNotDisplayed = " prt_portals_parent.prt_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portlet_locations ";
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_portlet_locations.plc_pge_id = prt_pages_parent.pge_id) ";
			}
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_portlet_locations.plc_pob_id = prt_portlet_objects_parent.pob_id) ";
			}
			if (class_exists('portal\virgoPortal')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portals AS prt_portals_parent ON (prt_portlet_locations.plc_prt_id = prt_portals_parent.prt_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClausePortletLocation = $whereClausePortletLocation . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClausePortletLocation, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClausePortletLocation,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_portlet_locations"
			;
			$componentParams = null;
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
				. "\n FROM prt_portlet_locations"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_portlet_locations ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_portlet_locations ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, plc_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
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
				$query = "SELECT COUNT(plc_id) cnt FROM portlet_locations";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as portlet_locations ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as portlet_locations ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoPortletLocation();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_portlet_locations WHERE plc_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->plc_id = $row['plc_id'];
$this->plc_section = $row['plc_section'];
$this->plc_order = $row['plc_order'];
$this->plc_position = $row['plc_position'];
						$this->plc_pge_id = $row['plc_pge_id'];
						$this->plc_pob_id = $row['plc_pob_id'];
						$this->plc_prt_id = $row['plc_prt_id'];
						if ($fetchUsernames) {
							if ($row['plc_date_created']) {
								if ($row['plc_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['plc_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['plc_date_modified']) {
								if ($row['plc_usr_modified_id'] == $row['plc_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['plc_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['plc_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->plc_date_created = $row['plc_date_created'];
						$this->plc_usr_created_id = $fetchUsernames ? $createdBy : $row['plc_usr_created_id'];
						$this->plc_date_modified = $row['plc_date_modified'];
						$this->plc_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['plc_usr_modified_id'];
						$this->plc_virgo_title = $row['plc_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_portlet_locations SET plc_usr_created_id = {$userId} WHERE plc_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->plc_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoPortletLocation::selectAllAsObjectsStatic('plc_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->plc_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->plc_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('plc_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_plc = new virgoPortletLocation();
				$tmp_plc->load((int)$lookup_id);
				return $tmp_plc->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoPortletLocation');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" plc_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoPortletLocation', "10");
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
				$query = $query . " plc_id as id, plc_virgo_title as title ";
			}
			$query = $query . " FROM prt_portlet_locations ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY plc_order ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resPortletLocation = array();
				foreach ($rows as $row) {
					$resPortletLocation[$row['id']] = $row['title'];
				}
				return $resPortletLocation;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticPortletLocation = new virgoPortletLocation();
			return $staticPortletLocation->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getPageStatic($parentId) {
			return virgoPage::getById($parentId);
		}
		
		function getPage() {
			return virgoPortletLocation::getPageStatic($this->plc_pge_id);
		}
		static function getPortletObjectStatic($parentId) {
			return virgoPortletObject::getById($parentId);
		}
		
		function getPortletObject() {
			return virgoPortletLocation::getPortletObjectStatic($this->plc_pob_id);
		}
		static function getPortalStatic($parentId) {
			return virgoPortal::getById($parentId);
		}
		
		function getPortal() {
			return virgoPortletLocation::getPortalStatic($this->plc_prt_id);
		}


		function validateObject($virgoOld) {
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_section_obligatory', "0") == "1") {
				if (
(is_null($this->getSection()) || trim($this->getSection()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'SECTION');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_order_obligatory', "0") == "1") {
				if (
(is_null($this->getOrder()) || trim($this->getOrder()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'ORDER');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_position_obligatory', "0") == "1") {
				if (
(is_null($this->getPosition()) || trim($this->getPosition()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'POSITION');
				}			
			}
			$tmpMode = (is_null($this->getId()) ? "create" : "form");
			if (P('show_'.$tmpMode.'_page_obligatory', "0") == "1") {
				if (is_null($this->plc_pge_id) || trim($this->plc_pge_id) == "") {
					if (R('create_plc_page_' . $this->plc_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'PAGE', '');
					}
				}
			}			
				if (is_null($this->plc_pob_id) || trim($this->plc_pob_id) == "") {
					if (R('create_plc_portletObject_' . $this->plc_id) == "1") { 
						$parent = new virgoPortletObject();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->plc_pob_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'PORTLET_OBJECT', '');
					}
			}			
			$tmpMode = (is_null($this->getId()) ? "create" : "form");
			if (P('show_'.$tmpMode.'_portal_obligatory', "0") == "1") {
				if (is_null($this->plc_prt_id) || trim($this->plc_prt_id) == "") {
					if (R('create_plc_portal_' . $this->plc_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'PORTAL', '');
					}
				}
			}			
 			if (!is_null($this->plc_order) && trim($this->plc_order) != "") {
				if (!is_numeric($this->plc_order)) {
					return T('INCORRECT_NUMBER', 'ORDER', $this->plc_order);
				}
			}
			if (!is_null($this->plc_position) && trim($this->plc_position) != "") {
				if (!is_numeric($this->plc_position)) {
					return T('INCORRECT_NUMBER', 'POSITION', $this->plc_position);
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_portlet_locations WHERE plc_id = " . $this->getId();
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
				$colNames = $colNames . ", plc_section";
				$values = $values . ", " . (is_null($objectToStore->getSection()) ? "null" : "'" . QE($objectToStore->getSection()) . "'");
				$colNames = $colNames . ", plc_order";
				$values = $values . ", " . (is_null($objectToStore->getOrder()) ? "null" : "'" . QE($objectToStore->getOrder()) . "'");
				$colNames = $colNames . ", plc_position";
				$values = $values . ", " . (is_null($objectToStore->getPosition()) ? "null" : "'" . QE($objectToStore->getPosition()) . "'");
				$colNames = $colNames . ", plc_pge_id";
				$values = $values . ", " . (is_null($objectToStore->getPgeId()) || $objectToStore->getPgeId() == "" ? "null" : $objectToStore->getPgeId());
				$colNames = $colNames . ", plc_pob_id";
				$values = $values . ", " . (is_null($objectToStore->getPobId()) || $objectToStore->getPobId() == "" ? "null" : $objectToStore->getPobId());
				$colNames = $colNames . ", plc_prt_id";
				$values = $values . ", " . (is_null($objectToStore->getPrtId()) || $objectToStore->getPrtId() == "" ? "null" : $objectToStore->getPrtId());
				$query = "INSERT INTO prt_history_portlet_locations (revision, ip, username, user_id, timestamp, plc_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getSection() != $objectToStore->getSection()) {
				if (is_null($objectToStore->getSection())) {
					$nullifiedProperties = $nullifiedProperties . "section,";
				} else {
				$colNames = $colNames . ", plc_section";
				$values = $values . ", " . (is_null($objectToStore->getSection()) ? "null" : "'" . QE($objectToStore->getSection()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getOrder() != $objectToStore->getOrder()) {
				if (is_null($objectToStore->getOrder())) {
					$nullifiedProperties = $nullifiedProperties . "order,";
				} else {
				$colNames = $colNames . ", plc_order";
				$values = $values . ", " . (is_null($objectToStore->getOrder()) ? "null" : "'" . QE($objectToStore->getOrder()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getPosition() != $objectToStore->getPosition()) {
				if (is_null($objectToStore->getPosition())) {
					$nullifiedProperties = $nullifiedProperties . "position,";
				} else {
				$colNames = $colNames . ", plc_position";
				$values = $values . ", " . (is_null($objectToStore->getPosition()) ? "null" : "'" . QE($objectToStore->getPosition()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getPgeId() != $objectToStore->getPgeId() && ($virgoOld->getPgeId() != 0 || $objectToStore->getPgeId() != ""))) { 
				$colNames = $colNames . ", plc_pge_id";
				$values = $values . ", " . (is_null($objectToStore->getPgeId()) ? "null" : ($objectToStore->getPgeId() == "" ? "0" : $objectToStore->getPgeId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getPobId() != $objectToStore->getPobId() && ($virgoOld->getPobId() != 0 || $objectToStore->getPobId() != ""))) { 
				$colNames = $colNames . ", plc_pob_id";
				$values = $values . ", " . (is_null($objectToStore->getPobId()) ? "null" : ($objectToStore->getPobId() == "" ? "0" : $objectToStore->getPobId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getPrtId() != $objectToStore->getPrtId() && ($virgoOld->getPrtId() != 0 || $objectToStore->getPrtId() != ""))) { 
				$colNames = $colNames . ", plc_prt_id";
				$values = $values . ", " . (is_null($objectToStore->getPrtId()) ? "null" : ($objectToStore->getPrtId() == "" ? "0" : $objectToStore->getPrtId()));
			}
			$query = "INSERT INTO prt_history_portlet_locations (revision, ip, username, user_id, timestamp, plc_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_portlet_locations");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'plc_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_portlet_locations ADD COLUMN (plc_virgo_title VARCHAR(255));";
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
			if (isset($this->plc_id) && $this->plc_id != "") {
				$query = "UPDATE prt_portlet_locations SET ";
			if (isset($this->plc_section)) {
				$query .= " plc_section = ? ,";
				$types .= "s";
				$values[] = $this->plc_section;
			} else {
				$query .= " plc_section = NULL ,";				
			}
			if (isset($this->plc_order)) {
				$query .= " plc_order = ? ,";
				$types .= "i";
				$values[] = $this->plc_order;
			} else {
				$query .= " plc_order = NULL ,";				
			}
			if (isset($this->plc_position)) {
				$query .= " plc_position = ? ,";
				$types .= "i";
				$values[] = $this->plc_position;
			} else {
				$query .= " plc_position = NULL ,";				
			}
				if (isset($this->plc_pge_id) && trim($this->plc_pge_id) != "") {
					$query = $query . " plc_pge_id = ? , ";
					$types = $types . "i";
					$values[] = $this->plc_pge_id;
				} else {
					$query = $query . " plc_pge_id = NULL, ";
				}
				if (isset($this->plc_pob_id) && trim($this->plc_pob_id) != "") {
					$query = $query . " plc_pob_id = ? , ";
					$types = $types . "i";
					$values[] = $this->plc_pob_id;
				} else {
					$query = $query . " plc_pob_id = NULL, ";
				}
				if (isset($this->plc_prt_id) && trim($this->plc_prt_id) != "") {
					$query = $query . " plc_prt_id = ? , ";
					$types = $types . "i";
					$values[] = $this->plc_prt_id;
				} else {
					$query = $query . " plc_prt_id = NULL, ";
				}
				$query = $query . " plc_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " plc_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->plc_date_modified;

				$query = $query . " plc_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->plc_usr_modified_id;

				$query = $query . " WHERE plc_id = ? ";
				$types = $types . "i";
				$values[] = $this->plc_id;
			} else {
				$query = "INSERT INTO prt_portlet_locations ( ";
			$query = $query . " plc_section, ";
			$query = $query . " plc_order, ";
			$query = $query . " plc_position, ";
				$query = $query . " plc_pge_id, ";
				$query = $query . " plc_pob_id, ";
				$query = $query . " plc_prt_id, ";
				$query = $query . " plc_virgo_title, plc_date_created, plc_usr_created_id) VALUES ( ";
			if (isset($this->plc_section)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->plc_section;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->plc_order)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->plc_order;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->plc_position)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->plc_position;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->plc_pge_id) && trim($this->plc_pge_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->plc_pge_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->plc_pob_id) && trim($this->plc_pob_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->plc_pob_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->plc_prt_id) && trim($this->plc_prt_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->plc_prt_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->plc_date_created;
				$values[] = $this->plc_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->plc_id) || $this->plc_id == "") {
					$this->plc_id = QID();
				}
				if ($log) {
					L("portlet location stored successfully", "id = {$this->plc_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->plc_id) {
				$virgoOld = new virgoPortletLocation($this->plc_id);
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
					if ($this->plc_id) {			
						$this->plc_date_modified = date("Y-m-d H:i:s");
						$this->plc_usr_modified_id = $userId;
					} else {
						$this->plc_date_created = date("Y-m-d H:i:s");
						$this->plc_usr_created_id = $userId;
					}
					$this->plc_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "portlet location" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "portlet location" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
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
			$query = "DELETE FROM prt_portlet_locations WHERE plc_id = {$this->plc_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			self::removeFromContext();
			$this->parentDelete();
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoPortletLocation();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT plc_id as id FROM prt_portlet_locations";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'plc_order_column')) {
				$orderBy = " ORDER BY plc_order_column ASC ";
			} 
			if (property_exists($this, 'plc_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY plc_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoPortletLocation();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoPortletLocation($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_portlet_locations SET plc_virgo_title = '$title' WHERE plc_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoPortletLocation();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" plc_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['plc_id'];
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
			virgoPortletLocation::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoPortletLocation::setSessionValue('Portal_PortletLocation-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoPortletLocation::getSessionValue('Portal_PortletLocation-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoPortletLocation::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoPortletLocation::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoPortletLocation::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoPortletLocation::getSessionValue('GLOBAL', $name, $default);
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
			$context['plc_id'] = $id;
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
			$context['plc_id'] = null;
			virgoPortletLocation::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoPortletLocation::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoPortletLocation::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoPortletLocation::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoPortletLocation::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoPortletLocation::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoPortletLocation::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoPortletLocation::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoPortletLocation::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoPortletLocation::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoPortletLocation::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoPortletLocation::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoPortletLocation::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoPortletLocation::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoPortletLocation::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoPortletLocation::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoPortletLocation::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column', 'plc_order');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "plc_id";
			}
			return virgoPortletLocation::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoPortletLocation::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoPortletLocation::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoPortletLocation::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoPortletLocation::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoPortletLocation::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoPortletLocation::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoPortletLocation::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoPortletLocation::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoPortletLocation::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoPortletLocation::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoPortletLocation::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoPortletLocation::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->plc_id) {
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
						L(T('STORED_CORRECTLY', 'PORTLET_LOCATION'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'section', $this->plc_section);
						$fieldValues = $fieldValues . T($fieldValue, 'order', $this->plc_order);
						$fieldValues = $fieldValues . T($fieldValue, 'position', $this->plc_position);
						$parentPage = new virgoPage();
						$fieldValues = $fieldValues . T($fieldValue, 'page', $parentPage->lookup($this->plc_pge_id));
						$parentPortletObject = new virgoPortletObject();
						$fieldValues = $fieldValues . T($fieldValue, 'portlet object', $parentPortletObject->lookup($this->plc_pob_id));
						$parentPortal = new virgoPortal();
						$fieldValues = $fieldValues . T($fieldValue, 'portal', $parentPortal->lookup($this->plc_prt_id));
						$username = '';
						if ($this->plc_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->plc_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->plc_date_created);
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
			$instance = new virgoPortletLocation();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletLocation'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			$tmpId = intval(R('plc_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoPortletLocation::getContextId();
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
			$this->plc_id = null;
			$this->plc_date_created = null;
			$this->plc_usr_created_id = null;
			$this->plc_date_modified = null;
			$this->plc_usr_modified_id = null;
			$this->plc_virgo_title = null;
			
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

		static function portletActionShowForPage() {
			$parentId = R('pge_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoPage($parentId);
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
		static function portletActionShowForPortal() {
			$parentId = R('prt_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoPortal($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
			return 0;
		}

		function existingConnections() {
			$where = "";
			if (is_null($this->getPageId())) {
				L('Missing PageId', '', 'ERROR');
			}
			$where = $where . " plc_pge_id = {$this->getPageId()}";

			if (is_null($this->getPortletObjectId())) {
				L('Missing PortletObjectId', '', 'ERROR');
			}
			$where = $where . " AND plc_pob_id = {$this->getPortletObjectId()}";

			if (is_null($this->getPortalId())) {
				L('Missing PortalId', '', 'ERROR');
			}
			$where = $where . " AND plc_prt_id = {$this->getPortalId()}";

			return virgoPortletLocation::selectAllAsObjectsStatic($where);
		}

		function storeIfNotExists() {
			$res = $this->existingConnections();
			if (count($res) == 0) {
				LE($this->store());
				return $this;
			}
			return $res[0];
		}

		static function portletActionAdd() {
			$portletObject = self::getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("add")) {
			self::removeFromContext();
			self::setDisplayMode("CREATE");
//			$ret = new virgoPortletLocation();
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
				$instance = new virgoPortletLocation();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoPortletLocation::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'PORTLET_LOCATION'), '', 'INFO');
					return 0;
					
				} else {
					L($res, '', 'ERROR');
					return -1;
				}
			}
		}
		
		static function portletActionVirgoUp() {
			$this->loadFromDB();
			$idToSwapWith = R('virgo_swap_up_with_' . $this->getId());
			$objectToSwapWith = new virgoPortletLocation($idToSwapWith);
			$val1 = $this->getOrder();
			$val2 = $objectToSwapWith->getOrder();
			if (is_null($val1)) {
				$val1 = 1;
			}
			if (is_null($val2)) {
				$val2 = 1;
			}
			if ($val1 == $val2) {
				$val1 = $val2 + 1;
			}
			$objectToSwapWith->setOrder($val1);
			$this->setOrder($val2);
			$objectToSwapWith->store(false);
			$this->store(false);
			$this->putInContext();
			return 0;
		}
		
		static function portletActionVirgoDown() {
			$this->loadFromDB();
			$idToSwapWith = R('virgo_swap_down_with_' . $this->getId());
			$objectToSwapWith = new virgoPortletLocation($idToSwapWith);
			$val1 = $this->getOrder();
			$val2 = $objectToSwapWith->getOrder();
			if (is_null($val1)) {
				$val1 = 1;
			}
			if (is_null($val2)) {
				$val2 = 1;
			}
			if ($val1 == $val2) {
				$val1 = $val2 - 1;
			}
			$objectToSwapWith->setOrder($val1);
			$this->setOrder($val2);
			$objectToSwapWith->store(false);
			$this->store(false);
			$this->putInContext();
			return 0;
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
				$resultPortletLocation = new virgoPortletLocation();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultPortletLocation->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultPortletLocation->load($idToEditInt);
					} else {
						$resultPortletLocation->plc_id = 0;
					}
				}
				$results[] = $resultPortletLocation;
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
				$result = new virgoPortletLocation();
				$result->loadFromRequest($idToStore);
				if ($result->plc_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->plc_id == 0) {
						$result->plc_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->plc_id)) {
							$result->plc_id = 0;
						}
						$idsToCorrect[$result->plc_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'PORTLET_LOCATIONS'), '', 'INFO');
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
			$resultPortletLocation = new virgoPortletLocation();
			foreach ($idsToDelete as $idToDelete) {
				$resultPortletLocation->load((int)trim($idToDelete));
				$res = $resultPortletLocation->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'PORTLET_LOCATIONS'), '', 'INFO');			
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
		$ret = $this->plc_section;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoPortletLocation');
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
				$query = "UPDATE prt_portlet_locations SET plc_virgo_title = ? WHERE plc_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT plc_id AS id FROM prt_portlet_locations ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoPortletLocation($row['id']);
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
				$class2prefix["portal\\virgoPage"] = "pge";
				$class2prefix2 = array();
				$class2prefix2["portal\\virgoTemplate"] = "tmp";
				$class2prefix2["portal\\virgoPage"] = "pge";
				$class2prefix2["portal\\virgoPortal"] = "prt";
				$class2parentPrefix["portal\\virgoPage"] = $class2prefix2;
				$class2prefix["portal\\virgoPortletObject"] = "pob";
				$class2prefix2 = array();
				$class2prefix2["portal\\virgoPortletDefinition"] = "pdf";
				$class2prefix2["portal\\virgoPortletObject"] = "pob";
				$class2parentPrefix["portal\\virgoPortletObject"] = $class2prefix2;
				$class2prefix["portal\\virgoPortal"] = "prt";
				$class2prefix2 = array();
				$class2prefix2["portal\\virgoTemplate"] = "tmp";
				$class2parentPrefix["portal\\virgoPortal"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'prt_portlet_locations.plc_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_portlet_locations.plc_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_portlet_locations.plc_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_portlet_locations.plc_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoPortletLocation!', '', 'ERROR');
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
			$pdf->SetTitle('Portlet locations report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('PORTLET_LOCATIONS');
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
			if (P('show_pdf_section', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_order', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_position', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_page', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_portlet_object', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_portal', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultPortletLocation = new virgoPortletLocation();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_section', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Section');
				$minWidth['section'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['section']) {
						$minWidth['section'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_order', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Order');
				$minWidth['order'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['order']) {
						$minWidth['order'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_position', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Position');
				$minWidth['position'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['position']) {
						$minWidth['position'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_page', "1") == "1") {
				$minWidth['page $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'page $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['page $relation.name']) {
						$minWidth['page $relation.name'] = min($tmpLen, $maxWidth);
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
			if (P('show_pdf_portal', "1") == "1") {
				$minWidth['portal $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'portal $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['portal $relation.name']) {
						$minWidth['portal $relation.name'] = min($tmpLen, $maxWidth);
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
			$whereClausePortletLocation = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClausePortletLocation = $whereClausePortletLocation . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaPortletLocation = $resultPortletLocation->getCriteria();
			$fieldCriteriaSection = $criteriaPortletLocation["section"];
			if ($fieldCriteriaSection["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Section', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaSection["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Section', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaOrder = $criteriaPortletLocation["order"];
			if ($fieldCriteriaOrder["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Order', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaOrder["value"];
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
					$pdf->MultiCell(60, 100, 'Order', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaPosition = $criteriaPortletLocation["position"];
			if ($fieldCriteriaPosition["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Position', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaPosition["value"];
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
					$pdf->MultiCell(60, 100, 'Position', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaPortletLocation["page"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Page', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoPage::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Page', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaPortletLocation["portlet_object"];
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
			$parentCriteria = $criteriaPortletLocation["portal"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Portal', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoPortal::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Portal', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_page');
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
					$inCondition = " prt_portlet_locations.plc_pge_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portlet_locations.plc_pge_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortletLocation = $whereClausePortletLocation . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_portlet_object');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_portlet_locations.plc_pob_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portlet_locations.plc_pob_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortletLocation = $whereClausePortletLocation . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_portal');
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
					$inCondition = " prt_portlet_locations.plc_prt_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portlet_locations.plc_prt_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortletLocation = $whereClausePortletLocation . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaPortletLocation = self::getCriteria();
			if (isset($criteriaPortletLocation["section"])) {
				$fieldCriteriaSection = $criteriaPortletLocation["section"];
				if ($fieldCriteriaSection["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_locations.plc_section IS NOT NULL ';
				} elseif ($fieldCriteriaSection["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_locations.plc_section IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaSection["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_locations.plc_section like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortletLocation["order"])) {
				$fieldCriteriaOrder = $criteriaPortletLocation["order"];
				if ($fieldCriteriaOrder["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_locations.plc_order IS NOT NULL ';
				} elseif ($fieldCriteriaOrder["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_locations.plc_order IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaOrder["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_portlet_locations.plc_order = ? ";
				} else {
					$filter = $filter . " AND prt_portlet_locations.plc_order >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_portlet_locations.plc_order <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPortletLocation["position"])) {
				$fieldCriteriaPosition = $criteriaPortletLocation["position"];
				if ($fieldCriteriaPosition["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_locations.plc_position IS NOT NULL ';
				} elseif ($fieldCriteriaPosition["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_locations.plc_position IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaPosition["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_portlet_locations.plc_position = ? ";
				} else {
					$filter = $filter . " AND prt_portlet_locations.plc_position >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_portlet_locations.plc_position <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPortletLocation["page"])) {
				$parentCriteria = $criteriaPortletLocation["page"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND plc_pge_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portlet_locations.plc_pge_id IN (SELECT pge_id FROM prt_pages WHERE pge_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPortletLocation["portlet_object"])) {
				$parentCriteria = $criteriaPortletLocation["portlet_object"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND plc_pob_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portlet_locations.plc_pob_id IN (SELECT pob_id FROM prt_portlet_objects WHERE pob_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPortletLocation["portal"])) {
				$parentCriteria = $criteriaPortletLocation["portal"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND plc_prt_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portlet_locations.plc_prt_id IN (SELECT prt_id FROM prt_portals WHERE prt_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClausePortletLocation = $whereClausePortletLocation . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClausePortletLocation = $whereClausePortletLocation . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_portlet_locations.plc_id, prt_portlet_locations.plc_virgo_title ";
			$defaultOrderColumn = P('default_sort_column', 'plc_order');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_section', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_locations.plc_section plc_section";
			} else {
				if ($defaultOrderColumn == "plc_section") {
					$orderColumnNotDisplayed = " prt_portlet_locations.plc_section ";
				}
			}
			if (P('show_pdf_order', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_locations.plc_order plc_order";
			} else {
				if ($defaultOrderColumn == "plc_order") {
					$orderColumnNotDisplayed = " prt_portlet_locations.plc_order ";
				}
			}
			if (P('show_pdf_position', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_locations.plc_position plc_position";
			} else {
				if ($defaultOrderColumn == "plc_position") {
					$orderColumnNotDisplayed = " prt_portlet_locations.plc_position ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_pdf_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_locations.plc_pge_id as plc_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_pdf_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_locations.plc_pob_id as plc_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortal') && P('show_pdf_portal', "1") != "0") { // */ && !in_array("prt", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_locations.plc_prt_id as plc_prt_id ";
				$queryString = $queryString . ", prt_portals_parent.prt_virgo_title as `portal` ";
			} else {
				if ($defaultOrderColumn == "portal") {
					$orderColumnNotDisplayed = " prt_portals_parent.prt_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portlet_locations ";
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_portlet_locations.plc_pge_id = prt_pages_parent.pge_id) ";
			}
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_portlet_locations.plc_pob_id = prt_portlet_objects_parent.pob_id) ";
			}
			if (class_exists('portal\virgoPortal')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portals AS prt_portals_parent ON (prt_portlet_locations.plc_prt_id = prt_portals_parent.prt_id) ";
			}

		$resultsPortletLocation = $resultPortletLocation->select(
			'', 
			'all', 
			$resultPortletLocation->getOrderColumn(), 
			$resultPortletLocation->getOrderMode(), 
			$whereClausePortletLocation,
			$queryString);
		
		foreach ($resultsPortletLocation as $resultPortletLocation) {

			if (P('show_pdf_section', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletLocation['plc_section'])) + 6;
				if ($tmpLen > $minWidth['section']) {
					$minWidth['section'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_order', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletLocation['plc_order'])) + 6;
				if ($tmpLen > $minWidth['order']) {
					$minWidth['order'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_position', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletLocation['plc_position'])) + 6;
				if ($tmpLen > $minWidth['position']) {
					$minWidth['position'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_page', "1") == "1") {
			$parentValue = trim(virgoPage::lookup($resultPortletLocation['plcpge__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['page $relation.name']) {
					$minWidth['page $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_portlet_object', "1") == "1") {
			$parentValue = trim(virgoPortletObject::lookup($resultPortletLocation['plcpob__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['portlet object $relation.name']) {
					$minWidth['portlet object $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_portal', "1") == "1") {
			$parentValue = trim(virgoPortal::lookup($resultPortletLocation['plcprt__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['portal $relation.name']) {
					$minWidth['portal $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaPortletLocation = $resultPortletLocation->getCriteria();
		if (is_null($criteriaPortletLocation) || sizeof($criteriaPortletLocation) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																																									if (P('show_pdf_page', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['page $relation.name'], $colHeight, T('PAGE') . ' ' . T(''), 'T', 'C', 0, 0); 
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
			if (P('show_pdf_section', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['section'], $colHeight, T('SECTION'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_order', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['order'], $colHeight, T('ORDER'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_position', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['position'], $colHeight, T('POSITION'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_portal', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['portal $relation.name'], $colHeight, T('PORTAL') . ' ' . T(''), 'T', 'C', 0, 0); 
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
		foreach ($resultsPortletLocation as $resultPortletLocation) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_page', "1") == "1") {
			$parentValue = virgoPage::lookup($resultPortletLocation['plc_pge_id']);
			$tmpLn = $pdf->MultiCell($minWidth['page $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_portlet_object', "1") == "1") {
			$parentValue = virgoPortletObject::lookup($resultPortletLocation['plc_pob_id']);
			$tmpLn = $pdf->MultiCell($minWidth['portlet object $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_section', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['section'], $colHeight, '' . $resultPortletLocation['plc_section'], 'T', 'L', 0, 0);
				if (P('show_pdf_section', "1") == "2") {
										if (!is_null($resultPortletLocation['plc_section'])) {
						$tmpCount = (float)$counts["section"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["section"] = $tmpCount;
					}
				}
				if (P('show_pdf_section', "1") == "3") {
										if (!is_null($resultPortletLocation['plc_section'])) {
						$tmpSum = (float)$sums["section"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletLocation['plc_section'];
						}
						$sums["section"] = $tmpSum;
					}
				}
				if (P('show_pdf_section', "1") == "4") {
										if (!is_null($resultPortletLocation['plc_section'])) {
						$tmpCount = (float)$avgCounts["section"];
						$tmpSum = (float)$avgSums["section"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["section"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletLocation['plc_section'];
						}
						$avgSums["section"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_order', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['order'], $colHeight, '' . $resultPortletLocation['plc_order'], 'T', 'R', 0, 0);
				if (P('show_pdf_order', "1") == "2") {
										if (!is_null($resultPortletLocation['plc_order'])) {
						$tmpCount = (float)$counts["order"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["order"] = $tmpCount;
					}
				}
				if (P('show_pdf_order', "1") == "3") {
										if (!is_null($resultPortletLocation['plc_order'])) {
						$tmpSum = (float)$sums["order"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletLocation['plc_order'];
						}
						$sums["order"] = $tmpSum;
					}
				}
				if (P('show_pdf_order', "1") == "4") {
										if (!is_null($resultPortletLocation['plc_order'])) {
						$tmpCount = (float)$avgCounts["order"];
						$tmpSum = (float)$avgSums["order"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["order"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletLocation['plc_order'];
						}
						$avgSums["order"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_position', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['position'], $colHeight, '' . $resultPortletLocation['plc_position'], 'T', 'R', 0, 0);
				if (P('show_pdf_position', "1") == "2") {
										if (!is_null($resultPortletLocation['plc_position'])) {
						$tmpCount = (float)$counts["position"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["position"] = $tmpCount;
					}
				}
				if (P('show_pdf_position', "1") == "3") {
										if (!is_null($resultPortletLocation['plc_position'])) {
						$tmpSum = (float)$sums["position"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletLocation['plc_position'];
						}
						$sums["position"] = $tmpSum;
					}
				}
				if (P('show_pdf_position', "1") == "4") {
										if (!is_null($resultPortletLocation['plc_position'])) {
						$tmpCount = (float)$avgCounts["position"];
						$tmpSum = (float)$avgSums["position"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["position"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletLocation['plc_position'];
						}
						$avgSums["position"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_portal', "1") == "1") {
			$parentValue = virgoPortal::lookup($resultPortletLocation['plc_prt_id']);
			$tmpLn = $pdf->MultiCell($minWidth['portal $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
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
			if (P('show_pdf_section', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['section'];
				if (P('show_pdf_section', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["section"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_order', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['order'];
				if (P('show_pdf_order', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["order"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_position', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['position'];
				if (P('show_pdf_position', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["position"];
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
			if (P('show_pdf_section', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['section'];
				if (P('show_pdf_section', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["section"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_order', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['order'];
				if (P('show_pdf_order', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["order"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_position', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['position'];
				if (P('show_pdf_position', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["position"], 2, ',', ' ');
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
			if (P('show_pdf_section', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['section'];
				if (P('show_pdf_section', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["section"] == 0 ? "-" : $avgSums["section"] / $avgCounts["section"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_order', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['order'];
				if (P('show_pdf_order', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["order"] == 0 ? "-" : $avgSums["order"] / $avgCounts["order"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_position', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['position'];
				if (P('show_pdf_position', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["position"] == 0 ? "-" : $avgSums["position"] / $avgCounts["position"]);
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
				$reportTitle = T('PORTLET_LOCATIONS');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultPortletLocation = new virgoPortletLocation();
			$whereClausePortletLocation = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePortletLocation = $whereClausePortletLocation . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_section', "1") != "0") {
					$data = $data . $stringDelimeter .'Section' . $stringDelimeter . $separator;
				}
				if (P('show_export_order', "1") != "0") {
					$data = $data . $stringDelimeter .'Order' . $stringDelimeter . $separator;
				}
				if (P('show_export_position', "1") != "0") {
					$data = $data . $stringDelimeter .'Position' . $stringDelimeter . $separator;
				}
				if (P('show_export_page', "1") != "0") {
					$data = $data . $stringDelimeter . 'Page ' . $stringDelimeter . $separator;
				}
				if (P('show_export_portlet_object', "1") != "0") {
					$data = $data . $stringDelimeter . 'Portlet object ' . $stringDelimeter . $separator;
				}
				if (P('show_export_portal', "1") != "0") {
					$data = $data . $stringDelimeter . 'Portal ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_portlet_locations.plc_id, prt_portlet_locations.plc_virgo_title ";
			$defaultOrderColumn = P('default_sort_column', 'plc_order');
			$orderColumnNotDisplayed = "";
			if (P('show_export_section', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_locations.plc_section plc_section";
			} else {
				if ($defaultOrderColumn == "plc_section") {
					$orderColumnNotDisplayed = " prt_portlet_locations.plc_section ";
				}
			}
			if (P('show_export_order', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_locations.plc_order plc_order";
			} else {
				if ($defaultOrderColumn == "plc_order") {
					$orderColumnNotDisplayed = " prt_portlet_locations.plc_order ";
				}
			}
			if (P('show_export_position', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_locations.plc_position plc_position";
			} else {
				if ($defaultOrderColumn == "plc_position") {
					$orderColumnNotDisplayed = " prt_portlet_locations.plc_position ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_export_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_locations.plc_pge_id as plc_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_export_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_locations.plc_pob_id as plc_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortal') && P('show_export_portal', "1") != "0") { // */ && !in_array("prt", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_locations.plc_prt_id as plc_prt_id ";
				$queryString = $queryString . ", prt_portals_parent.prt_virgo_title as `portal` ";
			} else {
				if ($defaultOrderColumn == "portal") {
					$orderColumnNotDisplayed = " prt_portals_parent.prt_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portlet_locations ";
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_portlet_locations.plc_pge_id = prt_pages_parent.pge_id) ";
			}
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_portlet_locations.plc_pob_id = prt_portlet_objects_parent.pob_id) ";
			}
			if (class_exists('portal\virgoPortal')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portals AS prt_portals_parent ON (prt_portlet_locations.plc_prt_id = prt_portals_parent.prt_id) ";
			}

			$resultsPortletLocation = $resultPortletLocation->select(
				'', 
				'all', 
				$resultPortletLocation->getOrderColumn(), 
				$resultPortletLocation->getOrderMode(), 
				$whereClausePortletLocation,
				$queryString);
			foreach ($resultsPortletLocation as $resultPortletLocation) {
				if (P('show_export_section', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPortletLocation['plc_section'] . $stringDelimeter . $separator;
				}
				if (P('show_export_order', "1") != "0") {
			$data = $data . $resultPortletLocation['plc_order'] . $separator;
				}
				if (P('show_export_position', "1") != "0") {
			$data = $data . $resultPortletLocation['plc_position'] . $separator;
				}
				if (P('show_export_page', "1") != "0") {
					$parentValue = virgoPage::lookup($resultPortletLocation['plc_pge_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_portlet_object', "1") != "0") {
					$parentValue = virgoPortletObject::lookup($resultPortletLocation['plc_pob_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_portal', "1") != "0") {
					$parentValue = virgoPortal::lookup($resultPortletLocation['plc_prt_id']);
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
				$reportTitle = T('PORTLET_LOCATIONS');
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
			$resultPortletLocation = new virgoPortletLocation();
			$whereClausePortletLocation = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePortletLocation = $whereClausePortletLocation . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_section', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Section');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_order', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Order');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_position', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Position');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_page', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Page ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoPage::getVirgoList();
					$formulaPage = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaPage != "") {
							$formulaPage = $formulaPage . ',';
						}
						$formulaPage = $formulaPage . $key;
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
				if (P('show_export_portal', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Portal ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoPortal::getVirgoList();
					$formulaPortal = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaPortal != "") {
							$formulaPortal = $formulaPortal . ',';
						}
						$formulaPortal = $formulaPortal . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_portlet_locations.plc_id, prt_portlet_locations.plc_virgo_title ";
			$defaultOrderColumn = P('default_sort_column', 'plc_order');
			$orderColumnNotDisplayed = "";
			if (P('show_export_section', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_locations.plc_section plc_section";
			} else {
				if ($defaultOrderColumn == "plc_section") {
					$orderColumnNotDisplayed = " prt_portlet_locations.plc_section ";
				}
			}
			if (P('show_export_order', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_locations.plc_order plc_order";
			} else {
				if ($defaultOrderColumn == "plc_order") {
					$orderColumnNotDisplayed = " prt_portlet_locations.plc_order ";
				}
			}
			if (P('show_export_position', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_locations.plc_position plc_position";
			} else {
				if ($defaultOrderColumn == "plc_position") {
					$orderColumnNotDisplayed = " prt_portlet_locations.plc_position ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_export_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_locations.plc_pge_id as plc_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_export_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_locations.plc_pob_id as plc_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortal') && P('show_export_portal', "1") != "0") { // */ && !in_array("prt", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_locations.plc_prt_id as plc_prt_id ";
				$queryString = $queryString . ", prt_portals_parent.prt_virgo_title as `portal` ";
			} else {
				if ($defaultOrderColumn == "portal") {
					$orderColumnNotDisplayed = " prt_portals_parent.prt_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portlet_locations ";
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_portlet_locations.plc_pge_id = prt_pages_parent.pge_id) ";
			}
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_portlet_locations.plc_pob_id = prt_portlet_objects_parent.pob_id) ";
			}
			if (class_exists('portal\virgoPortal')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portals AS prt_portals_parent ON (prt_portlet_locations.plc_prt_id = prt_portals_parent.prt_id) ";
			}

			$resultsPortletLocation = $resultPortletLocation->select(
				'', 
				'all', 
				$resultPortletLocation->getOrderColumn(), 
				$resultPortletLocation->getOrderMode(), 
				$whereClausePortletLocation,
				$queryString);
			$index = 1;
			foreach ($resultsPortletLocation as $resultPortletLocation) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultPortletLocation['plc_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_section', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletLocation['plc_section'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_order', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletLocation['plc_order'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_position', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletLocation['plc_position'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_page', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoPage::lookup($resultPortletLocation['plc_pge_id']);
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
					$objValidation->setFormula1('"' . $formulaPage . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
				if (P('show_export_portlet_object', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoPortletObject::lookup($resultPortletLocation['plc_pob_id']);
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
				if (P('show_export_portal', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoPortal::lookup($resultPortletLocation['plc_prt_id']);
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
					$objValidation->setFormula1('"' . $formulaPortal . '"');
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
					$propertyColumnHash['section'] = 'plc_section';
					$propertyColumnHash['section'] = 'plc_section';
					$propertyColumnHash['order'] = 'plc_order';
					$propertyColumnHash['order'] = 'plc_order';
					$propertyColumnHash['position'] = 'plc_position';
					$propertyColumnHash['position'] = 'plc_position';
					$propertyClassHash['page'] = 'Page';
					$propertyClassHash['page'] = 'Page';
					$propertyColumnHash['page'] = 'plc_pge_id';
					$propertyColumnHash['page'] = 'plc_pge_id';
					$propertyClassHash['portlet object'] = 'PortletObject';
					$propertyClassHash['portlet_object'] = 'PortletObject';
					$propertyColumnHash['portlet object'] = 'plc_pob_id';
					$propertyColumnHash['portlet_object'] = 'plc_pob_id';
					$propertyClassHash['portal'] = 'Portal';
					$propertyClassHash['portal'] = 'Portal';
					$propertyColumnHash['portal'] = 'plc_prt_id';
					$propertyColumnHash['portal'] = 'plc_prt_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importPortletLocation = new virgoPortletLocation();
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
										L(T('PROPERTY_NOT_FOUND', T('PORTLET_LOCATION'), $columns[$index]), '', 'ERROR');
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
										$importPortletLocation->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_page');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoPage::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoPage::token2Id($tmpToken);
	}
	$importPortletLocation->setPgeId($defaultValue);
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
	$importPortletLocation->setPobId($defaultValue);
}
$defaultValue = P('import_default_value_portal');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoPortal::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoPortal::token2Id($tmpToken);
	}
	$importPortletLocation->setPrtId($defaultValue);
}
							$errorMessage = $importPortletLocation->store();
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
		




		static function portletActionVirgoSetPage() {
			$this->loadFromDB();
			$parentId = R('plc_Page_id_' . $_SESSION['current_portlet_object_id']);
			$this->setPgeId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetPortletObject() {
			$this->loadFromDB();
			$parentId = R('plc_PortletObject_id_' . $_SESSION['current_portlet_object_id']);
			$this->setPobId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetPortal() {
			$this->loadFromDB();
			$parentId = R('plc_Portal_id_' . $_SESSION['current_portlet_object_id']);
			$this->setPrtId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}

		static function portletActionAddPortletObject() {
			self::setDisplayMode("ADD_NEW_PARENT_PORTLET_OBJECT");
		}

		static function portletActionStoreNewPortletObject() {
			$id = -1;
			if (virgoPortletObject::portletActionStore(true, $id) == -1) {
				self::setDisplayMode("ADD_NEW_PARENT_PORTLET_OBJECT");
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			} else {
				$tmpId = self::loadIdFromRequest();
				$_POST['plc_portletObject_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
				self::portletActionBackFromParent();
			}
		}

		static function portletActionBackFromParent() {
			$calligView = strtoupper(R('calling_view'));
			self::setDisplayMode($calligView);
			$pob = self::getMyPortletObject();
			$pob->setPortletSessionValue('reload_from_request', '1');				
		}


		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `prt_portlet_locations` (
  `plc_id` bigint(20) unsigned NOT NULL auto_increment,
  `plc_virgo_state` varchar(50) default NULL,
  `plc_virgo_title` varchar(255) default NULL,
	`plc_pge_id` int(11) default NULL,
	`plc_pob_id` int(11) default NULL,
	`plc_prt_id` int(11) default NULL,
  `plc_section` varchar(255), 
  `plc_order` integer,  
  `plc_position` integer,  
  `plc_date_created` datetime NOT NULL,
  `plc_date_modified` datetime default NULL,
  `plc_usr_created_id` int(11) NOT NULL,
  `plc_usr_modified_id` int(11) default NULL,
  KEY `plc_pge_fk` (`plc_pge_id`),
  KEY `plc_pob_fk` (`plc_pob_id`),
  KEY `plc_prt_fk` (`plc_prt_id`),
  PRIMARY KEY  (`plc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/portlet_location.sql 
INSERT INTO `prt_portlet_locations` (`plc_virgo_title`, `plc_section`, `plc_order`, `plc_position`) 
VALUES (title, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_portlet_locations table already exists.", '', 'FATAL');
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
			return "plc";
		}
		
		static function getPlural() {
			return "portlet_locations";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoPage";
			$ret[] = "virgoPortletObject";
			$ret[] = "virgoPortal";
			return $ret;
		}

		static function getChildren() {
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_portlet_locations'));
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
			$virgoVersion = virgoPortletLocation::getVirgoVersion();
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
	
	

