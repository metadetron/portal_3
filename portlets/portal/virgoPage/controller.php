<?php
/**
* Module Page
* @package Portal
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace portal;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPermission'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletLocation'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoRole'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoPage {

		 var  $pge_id = null;
		 var  $pge_title = null;

		 var  $pge_alias = null;

		 var  $pge_default = null;

		 var  $pge_order = null;

		 var  $pge_path = null;

		 var  $pge_tmp_id = null;
		 var  $pge_pge_id = null;
		 var  $pge_prt_id = null;

		 var   $_portletObjectIdsToAddArray = null;
		 var   $_portletObjectIdsToDeleteArray = null;
		 var   $pge_date_created = null;
		 var   $pge_usr_created_id = null;
		 var   $pge_date_modified = null;
		 var   $pge_usr_modified_id = null;
		 var   $pge_virgo_title = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoPage();
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
        	$this->pge_id = null;
		    $this->pge_date_created = null;
		    $this->pge_usr_created_id = null;
		    $this->pge_date_modified = null;
		    $this->pge_usr_modified_id = null;
		    $this->pge_virgo_title = null;
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
			return $this->pge_id;
		}

		function getTitle() {
			return $this->pge_title;
		}
		
		 function setTitle($val) {
			$this->pge_title = $val;
		}
		function getAlias() {
			return $this->pge_alias;
		}
		
		 function setAlias($val) {
			$this->pge_alias = $val;
		}
		function getDefault() {
			return $this->pge_default;
		}
		
		 function setDefault($val) {
			$this->pge_default = $val;
		}
		function getOrder() {
			return $this->pge_order;
		}
		
		 function setOrder($val) {
			$this->pge_order = $val;
		}
		function getPath() {
			return $this->pge_path;
		}
		
		 function setPath($val) {
			$this->pge_path = $val;
		}

		function getTemplateId() {
			return $this->pge_tmp_id;
		}
		
		 function setTemplateId($val) {
			$this->pge_tmp_id = $val;
		}
		function getPageId() {
			return $this->pge_pge_id;
		}
		
		 function setPageId($val) {
			$this->pge_pge_id = $val;
		}
		function getPortalId() {
			return $this->pge_prt_id;
		}
		
		 function setPortalId($val) {
			$this->pge_prt_id = $val;
		}

		function getDateCreated() {
			return $this->pge_date_created;
		}
		function getUsrCreatedId() {
			return $this->pge_usr_created_id;
		}
		function getDateModified() {
			return $this->pge_date_modified;
		}
		function getUsrModifiedId() {
			return $this->pge_usr_modified_id;
		}


		function getTmpId() {
			return $this->getTemplateId();
		}
		
		 function setTmpId($val) {
			$this->setTemplateId($val);
		}
		function getPgeId() {
			return $this->getPageId();
		}
		
		 function setPgeId($val) {
			$this->setPageId($val);
		}
		function getPrtId() {
			return $this->getPortalId();
		}
		
		 function setPrtId($val) {
			$this->setPortalId($val);
		}

		function loadRecordFromRequest($rowId) {
			$this->pge_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('pge_title_' . $this->pge_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->pge_title = null;
		} else {
			$this->pge_title = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('pge_alias_' . $this->pge_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->pge_alias = null;
		} else {
			$this->pge_alias = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('pge_default_' . $this->pge_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->pge_default = null;
		} else {
			$this->pge_default = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('pge_order_' . $this->pge_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->pge_order = null;
		} else {
			$this->pge_order = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('pge_path_' . $this->pge_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->pge_path = null;
		} else {
			$this->pge_path = $tmpValue;
		}
	}
			$this->pge_tmp_id = strval(R('pge_template_' . $this->pge_id));
			$this->pge_pge_id = strval(R('pge_page_' . $this->pge_id));
			$this->pge_prt_id = strval(R('pge_portal_' . $this->pge_id));
			$tmp_ids = R('pge_portletLocation_' . $this->pge_id, null); 			if (is_null($tmp_ids)) {
				$tmp_ids = array();
			}
			if (is_array($tmp_ids)) { 
				$this->_portletObjectIdsToAddArray = $tmp_ids;
				$this->_portletObjectIdsToDeleteArray = array();
				$currentConnections = $this->getPortletLocations();
				foreach ($currentConnections as $currentConnection) {
					if (in_array($currentConnection->getPortletObjectId(), $tmp_ids)) {
						foreach($this->_portletObjectIdsToAddArray as $key => $value) {
							if ($value == $currentConnection->getPortletObjectId()) {
								unset($this->_portletObjectIdsToAddArray[$key]);
							}
						}
						$this->_portletObjectIdsToAddArray = array_values($this->_portletObjectIdsToAddArray);
					} else {
						$this->_portletObjectIdsToDeleteArray[] = $currentConnection->getPortletObjectId();
					}
				}
			}
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('pge_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaPage = array();	
			$criteriaFieldPage = array();	
			$isNullPage = R('virgo_search_title_is_null');
			
			$criteriaFieldPage["is_null"] = 0;
			if ($isNullPage == "not_null") {
				$criteriaFieldPage["is_null"] = 1;
			} elseif ($isNullPage == "null") {
				$criteriaFieldPage["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_title');

//			if ($isSet) {
			$criteriaFieldPage["value"] = $dataTypeCriteria;
//			}
			$criteriaPage["title"] = $criteriaFieldPage;
			$criteriaFieldPage = array();	
			$isNullPage = R('virgo_search_alias_is_null');
			
			$criteriaFieldPage["is_null"] = 0;
			if ($isNullPage == "not_null") {
				$criteriaFieldPage["is_null"] = 1;
			} elseif ($isNullPage == "null") {
				$criteriaFieldPage["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_alias');

//			if ($isSet) {
			$criteriaFieldPage["value"] = $dataTypeCriteria;
//			}
			$criteriaPage["alias"] = $criteriaFieldPage;
			$criteriaFieldPage = array();	
			$isNullPage = R('virgo_search_default_is_null');
			
			$criteriaFieldPage["is_null"] = 0;
			if ($isNullPage == "not_null") {
				$criteriaFieldPage["is_null"] = 1;
			} elseif ($isNullPage == "null") {
				$criteriaFieldPage["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_default');

//			if ($isSet) {
			$criteriaFieldPage["value"] = $dataTypeCriteria;
//			}
			$criteriaPage["default"] = $criteriaFieldPage;
			$criteriaFieldPage = array();	
			$isNullPage = R('virgo_search_order_is_null');
			
			$criteriaFieldPage["is_null"] = 0;
			if ($isNullPage == "not_null") {
				$criteriaFieldPage["is_null"] = 1;
			} elseif ($isNullPage == "null") {
				$criteriaFieldPage["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_order_from');
		$dataTypeCriteria["to"] = R('virgo_search_order_to');

//			if ($isSet) {
			$criteriaFieldPage["value"] = $dataTypeCriteria;
//			}
			$criteriaPage["order"] = $criteriaFieldPage;
			$criteriaFieldPage = array();	
			$isNullPage = R('virgo_search_path_is_null');
			
			$criteriaFieldPage["is_null"] = 0;
			if ($isNullPage == "not_null") {
				$criteriaFieldPage["is_null"] = 1;
			} elseif ($isNullPage == "null") {
				$criteriaFieldPage["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_path');

//			if ($isSet) {
			$criteriaFieldPage["value"] = $dataTypeCriteria;
//			}
			$criteriaPage["path"] = $criteriaFieldPage;
			$criteriaParent = array();	
			$isNull = R('virgo_search_template_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_template', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaPage["template"] = $criteriaParent;
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
			$criteriaPage["page"] = $criteriaParent;
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
			$criteriaPage["portal"] = $criteriaParent;
			$parent = R('virgo_search_portletObject', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
				$criteriaPage["portlet_object"] = $criteriaParent;
			}
			self::setCriteria($criteriaPage);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_title');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterTitle', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitle', null);
			}
			$tableFilter = R('virgo_filter_alias');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterAlias', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterAlias', null);
			}
			$tableFilter = R('virgo_filter_default');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterDefault', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterDefault', null);
			}
			$tableFilter = R('virgo_filter_order');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterOrder', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterOrder', null);
			}
			$tableFilter = R('virgo_filter_path');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterPath', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterPath', null);
			}
			$parentFilter = R('virgo_filter_template');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTemplate', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTemplate', null);
			}
			$parentFilter = R('virgo_filter_title_template');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleTemplate', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleTemplate', null);
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
			$whereClausePage = ' 1 = 1 ';
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
				$eventColumn = "pge_" . P('event_column');
				$whereClausePage = $whereClausePage . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePage = $whereClausePage . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_template');
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
					$inCondition = " prt_pages.pge_tmp_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_pages.pge_tmp_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePage = $whereClausePage . " AND ({$inCondition} {$nullCondition} )";
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
					$inCondition = " prt_pages.pge_pge_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_pages.pge_pge_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePage = $whereClausePage . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_portal');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_pages.pge_prt_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_pages.pge_prt_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePage = $whereClausePage . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaPage = self::getCriteria();
			if (isset($criteriaPage["title"])) {
				$fieldCriteriaTitle = $criteriaPage["title"];
				if ($fieldCriteriaTitle["is_null"] == 1) {
$filter = $filter . ' AND prt_pages.pge_title IS NOT NULL ';
				} elseif ($fieldCriteriaTitle["is_null"] == 2) {
$filter = $filter . ' AND prt_pages.pge_title IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaTitle["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_pages.pge_title like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPage["alias"])) {
				$fieldCriteriaAlias = $criteriaPage["alias"];
				if ($fieldCriteriaAlias["is_null"] == 1) {
$filter = $filter . ' AND prt_pages.pge_alias IS NOT NULL ';
				} elseif ($fieldCriteriaAlias["is_null"] == 2) {
$filter = $filter . ' AND prt_pages.pge_alias IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaAlias["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_pages.pge_alias like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPage["default"])) {
				$fieldCriteriaDefault = $criteriaPage["default"];
				if ($fieldCriteriaDefault["is_null"] == 1) {
$filter = $filter . ' AND prt_pages.pge_default IS NOT NULL ';
				} elseif ($fieldCriteriaDefault["is_null"] == 2) {
$filter = $filter . ' AND prt_pages.pge_default IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDefault["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_pages.pge_default = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaPage["order"])) {
				$fieldCriteriaOrder = $criteriaPage["order"];
				if ($fieldCriteriaOrder["is_null"] == 1) {
$filter = $filter . ' AND prt_pages.pge_order IS NOT NULL ';
				} elseif ($fieldCriteriaOrder["is_null"] == 2) {
$filter = $filter . ' AND prt_pages.pge_order IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaOrder["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_pages.pge_order = ? ";
				} else {
					$filter = $filter . " AND prt_pages.pge_order >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_pages.pge_order <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPage["path"])) {
				$fieldCriteriaPath = $criteriaPage["path"];
				if ($fieldCriteriaPath["is_null"] == 1) {
$filter = $filter . ' AND prt_pages.pge_path IS NOT NULL ';
				} elseif ($fieldCriteriaPath["is_null"] == 2) {
$filter = $filter . ' AND prt_pages.pge_path IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaPath["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_pages.pge_path like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPage["template"])) {
				$parentCriteria = $criteriaPage["template"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pge_tmp_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_pages.pge_tmp_id IN (SELECT tmp_id FROM prt_templates WHERE tmp_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPage["page"])) {
				$parentCriteria = $criteriaPage["page"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pge_pge_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_pages.pge_pge_id IN (SELECT pge_id FROM prt_pages WHERE pge_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPage["portal"])) {
				$parentCriteria = $criteriaPage["portal"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pge_prt_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_pages.pge_prt_id IN (SELECT prt_id FROM prt_portals WHERE prt_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPage["portlet_object"])) {
				$parentCriteria = $criteriaPage["portlet_object"];
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$filter = $filter . " AND prt_pages.pge_id IN (SELECT second_parent.plc_pge_id FROM prt_portlet_locations AS second_parent WHERE second_parent.plc_pob_id IN (" . implode(", ", $parentIds) . ")) ";
				}
			}
			$whereClausePage = $whereClausePage . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClausePage = $whereClausePage . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClausePage = $whereClausePage . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterTitle', null);
				if (S($tableFilter)) {
					$whereClausePage = $whereClausePage . " AND pge_title LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterAlias', null);
				if (S($tableFilter)) {
					$whereClausePage = $whereClausePage . " AND pge_alias LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterDefault', null);
				if (S($tableFilter)) {
					$whereClausePage = $whereClausePage . " AND pge_default LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterOrder', null);
				if (S($tableFilter)) {
					$whereClausePage = $whereClausePage . " AND pge_order LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterPath', null);
				if (S($tableFilter)) {
					$whereClausePage = $whereClausePage . " AND pge_path LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTemplate', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePage = $whereClausePage . " AND pge_tmp_id IS NULL ";
					} else {
						$whereClausePage = $whereClausePage . " AND pge_tmp_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleTemplate', null);
				if (S($parentFilter)) {
					$whereClausePage = $whereClausePage . " AND prt_templates_parent.tmp_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterPage', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePage = $whereClausePage . " AND pge_pge_id IS NULL ";
					} else {
						$whereClausePage = $whereClausePage . " AND pge_pge_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitlePage', null);
				if (S($parentFilter)) {
					$whereClausePage = $whereClausePage . " AND prt_pages_parent.pge_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterPortal', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePage = $whereClausePage . " AND pge_prt_id IS NULL ";
					} else {
						$whereClausePage = $whereClausePage . " AND pge_prt_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitlePortal', null);
				if (S($parentFilter)) {
					$whereClausePage = $whereClausePage . " AND prt_portals_parent.prt_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClausePage;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClausePage = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_pages.pge_id, prt_pages.pge_virgo_title ";
			$defaultOrderColumn = P('default_sort_column', 'pge_order');
			$orderColumnNotDisplayed = "";
			if (P('show_table_title', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_title pge_title";
			} else {
				if ($defaultOrderColumn == "pge_title") {
					$orderColumnNotDisplayed = " prt_pages.pge_title ";
				}
			}
			if (P('show_table_alias', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_alias pge_alias";
			} else {
				if ($defaultOrderColumn == "pge_alias") {
					$orderColumnNotDisplayed = " prt_pages.pge_alias ";
				}
			}
			if (P('show_table_default', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_default pge_default";
			} else {
				if ($defaultOrderColumn == "pge_default") {
					$orderColumnNotDisplayed = " prt_pages.pge_default ";
				}
			}
			if (P('show_table_order', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_order pge_order";
			} else {
				if ($defaultOrderColumn == "pge_order") {
					$orderColumnNotDisplayed = " prt_pages.pge_order ";
				}
			}
			if (P('show_table_path', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_path pge_path";
			} else {
				if ($defaultOrderColumn == "pge_path") {
					$orderColumnNotDisplayed = " prt_pages.pge_path ";
				}
			}
			if (class_exists('portal\virgoTemplate') && P('show_table_template', "1") != "0") { // */ && !in_array("tmp", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_pages.pge_tmp_id as pge_tmp_id ";
				$queryString = $queryString . ", prt_templates_parent.tmp_virgo_title as `template` ";
			} else {
				if ($defaultOrderColumn == "template") {
					$orderColumnNotDisplayed = " prt_templates_parent.tmp_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_table_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_pages.pge_pge_id as pge_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortal') && P('show_table_portal', "1") != "0") { // */ && !in_array("prt", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_pages.pge_prt_id as pge_prt_id ";
				$queryString = $queryString . ", prt_portals_parent.prt_virgo_title as `portal` ";
			} else {
				if ($defaultOrderColumn == "portal") {
					$orderColumnNotDisplayed = " prt_portals_parent.prt_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_pages ";
			if (class_exists('portal\virgoTemplate')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_templates AS prt_templates_parent ON (prt_pages.pge_tmp_id = prt_templates_parent.tmp_id) ";
			}
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_pages.pge_pge_id = prt_pages_parent.pge_id) ";
			}
			if (class_exists('portal\virgoPortal')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portals AS prt_portals_parent ON (prt_pages.pge_prt_id = prt_portals_parent.prt_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClausePage = $whereClausePage . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClausePage, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClausePage,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_pages"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " pge_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " pge_usr_created_id = ? ";
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
				. "\n FROM prt_pages"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_pages ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_pages ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, pge_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " pge_usr_created_id = ? ";
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
				$query = "SELECT COUNT(pge_id) cnt FROM pages";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as pages ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as pages ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoPage();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_pages WHERE pge_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->pge_id = $row['pge_id'];
$this->pge_title = $row['pge_title'];
$this->pge_alias = $row['pge_alias'];
$this->pge_default = $row['pge_default'];
$this->pge_order = $row['pge_order'];
$this->pge_path = $row['pge_path'];
						$this->pge_tmp_id = $row['pge_tmp_id'];
						$this->pge_pge_id = $row['pge_pge_id'];
						$this->pge_prt_id = $row['pge_prt_id'];
						if ($fetchUsernames) {
							if ($row['pge_date_created']) {
								if ($row['pge_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['pge_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['pge_date_modified']) {
								if ($row['pge_usr_modified_id'] == $row['pge_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['pge_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['pge_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->pge_date_created = $row['pge_date_created'];
						$this->pge_usr_created_id = $fetchUsernames ? $createdBy : $row['pge_usr_created_id'];
						$this->pge_date_modified = $row['pge_date_modified'];
						$this->pge_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['pge_usr_modified_id'];
						$this->pge_virgo_title = $row['pge_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_pages SET pge_usr_created_id = {$userId} WHERE pge_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->pge_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoPage::selectAllAsObjectsStatic('pge_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->pge_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->pge_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('pge_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_pge = new virgoPage();
				$tmp_pge->load((int)$lookup_id);
				return $tmp_pge->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoPage');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" pge_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoPage', "10");
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
				$query = $query . " pge_id as id, pge_virgo_title as title ";
			}
			$query = $query . " FROM prt_pages ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoPage', 'portal') == "1") {
				$privateCondition = " pge_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY pge_order ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resPage = array();
				foreach ($rows as $row) {
					$resPage[$row['id']] = $row['title'];
				}
				return $resPage;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticPage = new virgoPage();
			return $staticPage->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getTemplateStatic($parentId) {
			return virgoTemplate::getById($parentId);
		}
		
		function getTemplate() {
			return virgoPage::getTemplateStatic($this->pge_tmp_id);
		}
		static function getPageStatic($parentId) {
			return virgoPage::getById($parentId);
		}
		
		function getPage() {
			return virgoPage::getPageStatic($this->pge_pge_id);
		}
		static function getPortalStatic($parentId) {
			return virgoPortal::getById($parentId);
		}
		
		function getPortal() {
			return virgoPage::getPortalStatic($this->pge_prt_id);
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
			$resultsPermission = virgoPermission::selectAll('prm_pge_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPermission as $resultPermission) {
				$tmpPermission = virgoPermission::getById($resultPermission['prm_id']); 
				array_push($resPermission, $tmpPermission);
			}
			return $resPermission;
		}

		function getPermissions($orderBy = '', $extraWhere = null) {
			return virgoPage::getPermissionsStatic($this->getId(), $orderBy, $extraWhere);
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
			$resultsPortletLocation = virgoPortletLocation::selectAll('plc_pge_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPortletLocation as $resultPortletLocation) {
				$tmpPortletLocation = virgoPortletLocation::getById($resultPortletLocation['plc_id']); 
				array_push($resPortletLocation, $tmpPortletLocation);
			}
			return $resPortletLocation;
		}

		function getPortletLocations($orderBy = '', $extraWhere = null) {
			return virgoPage::getPortletLocationsStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getPagesStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resPage = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resPage;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resPage;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsPage = virgoPage::selectAll('pge_pge_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPage as $resultPage) {
				$tmpPage = virgoPage::getById($resultPage['pge_id']); 
				array_push($resPage, $tmpPage);
			}
			return $resPage;
		}

		function getPages($orderBy = '', $extraWhere = null) {
			return virgoPage::getPagesStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getUsersStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resUser = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resUser;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resUser;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsUser = virgoUser::selectAll('usr_pge_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsUser as $resultUser) {
				$tmpUser = virgoUser::getById($resultUser['usr_id']); 
				array_push($resUser, $tmpUser);
			}
			return $resUser;
		}

		function getUsers($orderBy = '', $extraWhere = null) {
			return virgoPage::getUsersStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getRolesStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resRole = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoRole'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resRole;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resRole;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsRole = virgoRole::selectAll('rle_pge_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsRole as $resultRole) {
				$tmpRole = virgoRole::getById($resultRole['rle_id']); 
				array_push($resRole, $tmpRole);
			}
			return $resRole;
		}

		function getRoles($orderBy = '', $extraWhere = null) {
			return virgoPage::getRolesStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
			if (
(is_null($this->getTitle()) || trim($this->getTitle()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'TITLE');
			}			
			if (
(is_null($this->getAlias()) || trim($this->getAlias()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'ALIAS');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_default_obligatory', "0") == "1") {
				if (
(is_null($this->getDefault()) || trim($this->getDefault()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'DEFAULT');
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
			if (P('show_'.$tmpMode.'_path_obligatory', "0") == "1") {
				if (
(is_null($this->getPath()) || trim($this->getPath()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'PATH');
				}			
			}
			$tmpMode = (is_null($this->getId()) ? "create" : "form");
			if (P('show_'.$tmpMode.'_template_obligatory', "0") == "1") {
				if (is_null($this->pge_tmp_id) || trim($this->pge_tmp_id) == "") {
					if (R('create_pge_template_' . $this->pge_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'TEMPLATE', '');
					}
				}
			}			
			$tmpMode = (is_null($this->getId()) ? "create" : "form");
			if (P('show_'.$tmpMode.'_page_obligatory', "0") == "1") {
				if (is_null($this->pge_pge_id) || trim($this->pge_pge_id) == "") {
					if (R('create_pge_page_' . $this->pge_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'PAGE', '');
					}
				}
			}			
				if (is_null($this->pge_prt_id) || trim($this->pge_prt_id) == "") {
					if (R('create_pge_portal_' . $this->pge_id) == "1") { 
						$parent = new virgoPortal();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->pge_prt_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'PORTAL', '');
					}
			}			
 			if (!is_null($this->pge_order) && trim($this->pge_order) != "") {
				if (!is_numeric($this->pge_order)) {
					return T('INCORRECT_NUMBER', 'ORDER', $this->pge_order);
				}
			}
		$types = "";
		$values = array();
		$skipUniquenessCheck = false;
		$uniqnessWhere = " 1 = 1 ";
		if (!is_null($this->pge_id) && $this->pge_id != 0) {
			$uniqnessWhere = " pge_id != " . $this->pge_id . " ";			
		}
 		if (!$skipUniquenessCheck) {
 			if (
(is_null($this->getPath()) || trim($this->getPath()) == '')
			) {
				$skipUniquenessCheck = true;
			}
			if (!$skipUniquenessCheck) {
			$uniqnessWhere = $uniqnessWhere . ' AND UPPER(pge_path) = UPPER(?) ';
			$types .= "s";
			$values[] = $this->pge_path;
			}
 		}	
 		if (!$skipUniquenessCheck) {	
			$query = " SELECT COUNT(*) FROM prt_pages ";
			$query = $query . " WHERE " . $uniqnessWhere;
			$result = QPL($query, $types, $values);
			if ($result[0] > 0) {
				$valeus = array();
				$colNames = array();
				$colNames[] = T('PATH');
				$values[] = $this->pge_path; 
				return T('UNIQNESS_FAILED', 'PAGE', implode(', ', $colNames), implode(', ', $values));
			}
		}
			return "";
		}

				
		function beforeStore($virgoOld) {
			if (!isset($virgoOld) || $virgoOld->getPageId() != $this->getPageId() || $virgoOld->getAlias() != $this->getAlias()) {
				$this->updatePath();
			}
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_pages WHERE pge_id = " . $this->getId();
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
				$colNames = $colNames . ", pge_title";
				$values = $values . ", " . (is_null($objectToStore->getTitle()) ? "null" : "'" . QE($objectToStore->getTitle()) . "'");
				$colNames = $colNames . ", pge_alias";
				$values = $values . ", " . (is_null($objectToStore->getAlias()) ? "null" : "'" . QE($objectToStore->getAlias()) . "'");
				$colNames = $colNames . ", pge_default";
				$values = $values . ", " . (is_null($objectToStore->getDefault()) ? "null" : "'" . QE($objectToStore->getDefault()) . "'");
				$colNames = $colNames . ", pge_order";
				$values = $values . ", " . (is_null($objectToStore->getOrder()) ? "null" : "'" . QE($objectToStore->getOrder()) . "'");
				$colNames = $colNames . ", pge_path";
				$values = $values . ", " . (is_null($objectToStore->getPath()) ? "null" : "'" . QE($objectToStore->getPath()) . "'");
				$colNames = $colNames . ", pge_tmp_id";
				$values = $values . ", " . (is_null($objectToStore->getTmpId()) || $objectToStore->getTmpId() == "" ? "null" : $objectToStore->getTmpId());
				$colNames = $colNames . ", pge_pge_id";
				$values = $values . ", " . (is_null($objectToStore->getPgeId()) || $objectToStore->getPgeId() == "" ? "null" : $objectToStore->getPgeId());
				$colNames = $colNames . ", pge_prt_id";
				$values = $values . ", " . (is_null($objectToStore->getPrtId()) || $objectToStore->getPrtId() == "" ? "null" : $objectToStore->getPrtId());
				$query = "INSERT INTO prt_history_pages (revision, ip, username, user_id, timestamp, pge_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getTitle() != $objectToStore->getTitle()) {
				if (is_null($objectToStore->getTitle())) {
					$nullifiedProperties = $nullifiedProperties . "title,";
				} else {
				$colNames = $colNames . ", pge_title";
				$values = $values . ", " . (is_null($objectToStore->getTitle()) ? "null" : "'" . QE($objectToStore->getTitle()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getAlias() != $objectToStore->getAlias()) {
				if (is_null($objectToStore->getAlias())) {
					$nullifiedProperties = $nullifiedProperties . "alias,";
				} else {
				$colNames = $colNames . ", pge_alias";
				$values = $values . ", " . (is_null($objectToStore->getAlias()) ? "null" : "'" . QE($objectToStore->getAlias()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getDefault() != $objectToStore->getDefault()) {
				if (is_null($objectToStore->getDefault())) {
					$nullifiedProperties = $nullifiedProperties . "default,";
				} else {
				$colNames = $colNames . ", pge_default";
				$values = $values . ", " . (is_null($objectToStore->getDefault()) ? "null" : "'" . QE($objectToStore->getDefault()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getOrder() != $objectToStore->getOrder()) {
				if (is_null($objectToStore->getOrder())) {
					$nullifiedProperties = $nullifiedProperties . "order,";
				} else {
				$colNames = $colNames . ", pge_order";
				$values = $values . ", " . (is_null($objectToStore->getOrder()) ? "null" : "'" . QE($objectToStore->getOrder()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getPath() != $objectToStore->getPath()) {
				if (is_null($objectToStore->getPath())) {
					$nullifiedProperties = $nullifiedProperties . "path,";
				} else {
				$colNames = $colNames . ", pge_path";
				$values = $values . ", " . (is_null($objectToStore->getPath()) ? "null" : "'" . QE($objectToStore->getPath()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getTmpId() != $objectToStore->getTmpId() && ($virgoOld->getTmpId() != 0 || $objectToStore->getTmpId() != ""))) { 
				$colNames = $colNames . ", pge_tmp_id";
				$values = $values . ", " . (is_null($objectToStore->getTmpId()) ? "null" : ($objectToStore->getTmpId() == "" ? "0" : $objectToStore->getTmpId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getPgeId() != $objectToStore->getPgeId() && ($virgoOld->getPgeId() != 0 || $objectToStore->getPgeId() != ""))) { 
				$colNames = $colNames . ", pge_pge_id";
				$values = $values . ", " . (is_null($objectToStore->getPgeId()) ? "null" : ($objectToStore->getPgeId() == "" ? "0" : $objectToStore->getPgeId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getPrtId() != $objectToStore->getPrtId() && ($virgoOld->getPrtId() != 0 || $objectToStore->getPrtId() != ""))) { 
				$colNames = $colNames . ", pge_prt_id";
				$values = $values . ", " . (is_null($objectToStore->getPrtId()) ? "null" : ($objectToStore->getPrtId() == "" ? "0" : $objectToStore->getPrtId()));
			}
			$query = "INSERT INTO prt_history_pages (revision, ip, username, user_id, timestamp, pge_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_pages");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'pge_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_pages ADD COLUMN (pge_virgo_title VARCHAR(255));";
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
			if (isset($this->pge_id) && $this->pge_id != "") {
				$query = "UPDATE prt_pages SET ";
			if (isset($this->pge_title)) {
				$query .= " pge_title = ? ,";
				$types .= "s";
				$values[] = $this->pge_title;
			} else {
				$query .= " pge_title = NULL ,";				
			}
			if (isset($this->pge_alias)) {
				$query .= " pge_alias = ? ,";
				$types .= "s";
				$values[] = $this->pge_alias;
			} else {
				$query .= " pge_alias = NULL ,";				
			}
			if (isset($this->pge_default)) {
				$query .= " pge_default = ? ,";
				$types .= "s";
				$values[] = $this->pge_default;
			} else {
				$query .= " pge_default = NULL ,";				
			}
			if (isset($this->pge_order)) {
				$query .= " pge_order = ? ,";
				$types .= "i";
				$values[] = $this->pge_order;
			} else {
				$query .= " pge_order = NULL ,";				
			}
			if (isset($this->pge_path)) {
				$query .= " pge_path = ? ,";
				$types .= "s";
				$values[] = $this->pge_path;
			} else {
				$query .= " pge_path = NULL ,";				
			}
				if (isset($this->pge_tmp_id) && trim($this->pge_tmp_id) != "") {
					$query = $query . " pge_tmp_id = ? , ";
					$types = $types . "i";
					$values[] = $this->pge_tmp_id;
				} else {
					$query = $query . " pge_tmp_id = NULL, ";
				}
				if (isset($this->pge_pge_id) && trim($this->pge_pge_id) != "") {
					$query = $query . " pge_pge_id = ? , ";
					$types = $types . "i";
					$values[] = $this->pge_pge_id;
				} else {
					$query = $query . " pge_pge_id = NULL, ";
				}
				if (isset($this->pge_prt_id) && trim($this->pge_prt_id) != "") {
					$query = $query . " pge_prt_id = ? , ";
					$types = $types . "i";
					$values[] = $this->pge_prt_id;
				} else {
					$query = $query . " pge_prt_id = NULL, ";
				}
				$query = $query . " pge_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " pge_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->pge_date_modified;

				$query = $query . " pge_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->pge_usr_modified_id;

				$query = $query . " WHERE pge_id = ? ";
				$types = $types . "i";
				$values[] = $this->pge_id;
			} else {
				$query = "INSERT INTO prt_pages ( ";
			$query = $query . " pge_title, ";
			$query = $query . " pge_alias, ";
			$query = $query . " pge_default, ";
			$query = $query . " pge_order, ";
			$query = $query . " pge_path, ";
				$query = $query . " pge_tmp_id, ";
				$query = $query . " pge_pge_id, ";
				$query = $query . " pge_prt_id, ";
				$query = $query . " pge_virgo_title, pge_date_created, pge_usr_created_id) VALUES ( ";
			if (isset($this->pge_title)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->pge_title;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pge_alias)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->pge_alias;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pge_default)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->pge_default;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pge_order)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->pge_order;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pge_path)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->pge_path;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->pge_tmp_id) && trim($this->pge_tmp_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->pge_tmp_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->pge_pge_id) && trim($this->pge_pge_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->pge_pge_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->pge_prt_id) && trim($this->pge_prt_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->pge_prt_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->pge_date_created;
				$values[] = $this->pge_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->pge_id) || $this->pge_id == "") {
					$this->pge_id = QID();
				}
				if ($log) {
					L("page stored successfully", "id = {$this->pge_id}", "TRACE");
				}
				return true;
			}
		}
		

		static function addPortletObjectStatic($thisId, $id) {
			$query = " SELECT COUNT(plc_id) AS cnt FROM prt_portlet_locations WHERE plc_pge_id = {$thisId} AND plc_pob_id = {$id} ";
			$res = Q1($query);
			if ($res == 0) {
				$newPortletLocation = new virgoPortletLocation();
				$newPortletLocation->setPortletObjectId($id);
				$newPortletLocation->setPageId($thisId);
				return $newPortletLocation->store();
			}			
			return "";
		}
		
		function addPortletObject($id) {
			return virgoPage::addPortletObjectStatic($this->getId(), $id);
		}
		
		static function removePortletObjectStatic($thisId, $id) {
			$query = " SELECT plc_id AS id FROM prt_portlet_locations WHERE plc_pge_id = {$thisId} AND plc_pob_id = {$id} ";
			$res = QR($query);
			foreach ($res as $re) {
				$newPortletLocation = new virgoPortletLocation($re['id']);
				return $newPortletLocation->delete();
			}			
			return "";
		}
		
		function removePortletObject($id) {
			return virgoPage::removePortletObjectStatic($this->getId(), $id);
		}
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->pge_id) {
				$virgoOld = new virgoPage($this->pge_id);
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
					if ($this->pge_id) {			
						$this->pge_date_modified = date("Y-m-d H:i:s");
						$this->pge_usr_modified_id = $userId;
					} else {
						$this->pge_date_created = date("Y-m-d H:i:s");
						$this->pge_usr_created_id = $userId;
					}
					$this->pge_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "page" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "page" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
						}
					}
					if (!is_null($this->_portletObjectIdsToAddArray)) {
						foreach ($this->_portletObjectIdsToAddArray as $portletObjectId) {
							$ret = $this->addPortletObject((int)$portletObjectId);
							if ($ret != "") {
								L($ret, '', 'ERROR');
							}
						}
					}
					if (!is_null($this->_portletObjectIdsToDeleteArray)) {
						foreach ($this->_portletObjectIdsToDeleteArray as $portletObjectId) {
							$ret = $this->removePortletObject((int)$portletObjectId);
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
			$query = "DELETE FROM prt_pages WHERE pge_id = {$this->pge_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			$list = $this->getPermissions();
			if (sizeof($list) > 0) {
				foreach ($list as $childRecord) {
					$childRecord->delete();
				}
			}
			$list = $this->getPortletLocations();
			if (sizeof($list) > 0) {
				foreach ($list as $childRecord) {
					$childRecord->delete();
				}
			}
			$list = $this->getPages();
			if (sizeof($list) > 0) {
				$name = $this->getVirgoTitle();
				if (!is_null($name) && trim($name) != "") {
					$name = "'" . $name . "' ";
				}
				return T('CANT_DELETE_PARENT', 'PAGE', 'PAGE', $name);
			}
			$list = $this->getUsers();
			if (sizeof($list) > 0) {
				$name = $this->getVirgoTitle();
				if (!is_null($name) && trim($name) != "") {
					$name = "'" . $name . "' ";
				}
				return T('CANT_DELETE_PARENT', 'PAGE', 'USER', $name);
			}
			$list = $this->getRoles();
			if (sizeof($list) > 0) {
				$name = $this->getVirgoTitle();
				if (!is_null($name) && trim($name) != "") {
					$name = "'" . $name . "' ";
				}
				return T('CANT_DELETE_PARENT', 'PAGE', 'ROLE', $name);
			}
			self::removeFromContext();
			$this->parentDelete();
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoPage();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT pge_id as id FROM prt_pages";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'pge_order_column')) {
				$orderBy = " ORDER BY pge_order_column ASC ";
			} 
			if (property_exists($this, 'pge_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY pge_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoPage();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoPage($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_pages SET pge_virgo_title = '$title' WHERE pge_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoPage();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" pge_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['pge_id'];
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
			virgoPage::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoPage::setSessionValue('Portal_Page-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoPage::getSessionValue('Portal_Page-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoPage::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoPage::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoPage::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoPage::getSessionValue('GLOBAL', $name, $default);
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
			$context['pge_id'] = $id;
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
			$context['pge_id'] = null;
			virgoPage::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoPage::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoPage::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoPage::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoPage::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoPage::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoPage::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoPage::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoPage::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoPage::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoPage::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoPage::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoPage::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoPage::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoPage::setRemoteSessionValue('ContextId', $contextId, $menuItem);
			if (!is_null($contextId)) {
				$currentItem = null; //$menu->getActive();
			}
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
				return virgoPage::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoPage::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column', 'pge_order');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "pge_id";
			}
			return virgoPage::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoPage::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoPage::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoPage::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoPage::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoPage::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoPage::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoPage::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoPage::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoPage::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoPage::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoPage::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoPage::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->pge_id) {
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
						L(T('STORED_CORRECTLY', 'PAGE'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'title', $this->pge_title);
						$fieldValues = $fieldValues . T($fieldValue, 'alias', $this->pge_alias);
						$fieldValues = $fieldValues . T($fieldValue, 'default', $this->pge_default);
						$fieldValues = $fieldValues . T($fieldValue, 'order', $this->pge_order);
						$fieldValues = $fieldValues . T($fieldValue, 'path', $this->pge_path);
						$parentTemplate = new virgoTemplate();
						$fieldValues = $fieldValues . T($fieldValue, 'template', $parentTemplate->lookup($this->pge_tmp_id));
						$parentPage = new virgoPage();
						$fieldValues = $fieldValues . T($fieldValue, 'page', $parentPage->lookup($this->pge_pge_id));
						$parentPortal = new virgoPortal();
						$fieldValues = $fieldValues . T($fieldValue, 'portal', $parentPortal->lookup($this->pge_prt_id));
						$username = '';
						if ($this->pge_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->pge_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->pge_date_created);
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
			$instance = new virgoPage();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			if (false) { //$componentParams->get('show_form_permissions') == "1") {
				$tmpPermission = new virgoPermission();
				$deletePermission = R('DELETE');
				if (sizeof($deletePermission) > 0) {
					$tmpPermission->multipleDelete($deletePermission);
				}
				$resIds = $tmpPermission->select(null, 'all', null, null, ' prm_pge_id = ' . $instance->getId(), ' SELECT prm_id FROM prt_permissions ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->prm_id;
//					JRequest::setVar('prm_page_' . $resId->prm_id, $this->getId());
				} 
//				JRequest::setVar('prm_page_', $instance->getId());
				$tmpPermission->setRecordSet($resIdsString);
				if (!$tmpPermission->portletActionStoreSelected()) {
					$ret = -1;
					self::setDisplayMode($originalDisplayMode); 
				}
			}
			if (false) { //$componentParams->get('show_form_pages') == "1") {
				$tmpPage = new virgoPage();
				$deletePage = R('DELETE');
				if (sizeof($deletePage) > 0) {
					$tmpPage->multipleDelete($deletePage);
				}
				$resIds = $tmpPage->select(null, 'all', null, null, ' pge_pge_id = ' . $instance->getId(), ' SELECT pge_id FROM prt_pages ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->pge_id;
//					JRequest::setVar('pge_page_' . $resId->pge_id, $this->getId());
				} 
//				JRequest::setVar('pge_page_', $instance->getId());
				$tmpPage->setRecordSet($resIdsString);
				if (!$tmpPage->portletActionStoreSelected()) {
					$ret = -1;
					self::setDisplayMode($originalDisplayMode); 
				}
			}
			if (false) { //$componentParams->get('show_form_users') == "1") {
				$tmpUser = new virgoUser();
				$deleteUser = R('DELETE');
				if (sizeof($deleteUser) > 0) {
					$tmpUser->multipleDelete($deleteUser);
				}
				$resIds = $tmpUser->select(null, 'all', null, null, ' usr_pge_id = ' . $instance->getId(), ' SELECT usr_id FROM prt_users ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->usr_id;
//					JRequest::setVar('usr_page_' . $resId->usr_id, $this->getId());
				} 
//				JRequest::setVar('usr_page_', $instance->getId());
				$tmpUser->setRecordSet($resIdsString);
				if (!$tmpUser->portletActionStoreSelected()) {
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
			$tmpId = intval(R('pge_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoPage::getContextId();
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
			$this->pge_id = null;
			$this->pge_date_created = null;
			$this->pge_usr_created_id = null;
			$this->pge_date_modified = null;
			$this->pge_usr_modified_id = null;
			$this->pge_virgo_title = null;
			
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

		static function portletActionShowForTemplate() {
			$parentId = R('tmp_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoTemplate($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
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


		static function portletActionAdd() {
			$portletObject = self::getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("add")) {
			self::removeFromContext();
			self::setDisplayMode("CREATE");
//			$ret = new virgoPage();
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
				$instance = new virgoPage();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoPage::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'PAGE'), '', 'INFO');
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
			$objectToSwapWith = new virgoPage($idToSwapWith);
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
			$objectToSwapWith = new virgoPage($idToSwapWith);
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
		
		static function portletActionVirgoSetDefaultTrue() {
			$this->loadFromDB();
			$this->setDefault(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetDefaultFalse() {
			$this->loadFromDB();
			$this->setDefault(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isDefault() {
			return $this->getDefault() == 1;
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
				$resultPage = new virgoPage();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultPage->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultPage->load($idToEditInt);
					} else {
						$resultPage->pge_id = 0;
					}
				}
				$results[] = $resultPage;
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
				$result = new virgoPage();
				$result->loadFromRequest($idToStore);
				if ($result->pge_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->pge_id == 0) {
						$result->pge_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->pge_id)) {
							$result->pge_id = 0;
						}
						$idsToCorrect[$result->pge_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'PAGES'), '', 'INFO');
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
			$resultPage = new virgoPage();
			foreach ($idsToDelete as $idToDelete) {
				$resultPage->load((int)trim($idToDelete));
				$res = $resultPage->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'PAGES'), '', 'INFO');			
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
		$ret = $this->pge_title;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoPage');
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
    			$ret["beforeStore/page.php"] = "<b>2012-03-21</b> <span style='font-size: 0.78em;'>23:32:46</span>";
			return $ret;
		}
		
		function updateTitle() {
			$val = $this->getVirgoTitle(); 
			if (!is_null($val) && trim($val) != "") {
				$query = "UPDATE prt_pages SET pge_virgo_title = ? WHERE pge_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT pge_id AS id FROM prt_pages ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoPage($row['id']);
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
				$class2prefix["portal\\virgoTemplate"] = "tmp";
				$class2prefix2 = array();
				$class2parentPrefix["portal\\virgoTemplate"] = $class2prefix2;
				$class2prefix["portal\\virgoPage"] = "pge";
				$class2prefix2 = array();
				$class2prefix2["portal\\virgoTemplate"] = "tmp";
				$class2prefix2["portal\\virgoPage"] = "pge";
				$class2prefix2["portal\\virgoPortal"] = "prt";
				$class2parentPrefix["portal\\virgoPage"] = $class2prefix2;
				$class2prefix["portal\\virgoPortal"] = "prt";
				$class2prefix2 = array();
				$class2prefix2["portal\\virgoTemplate"] = "tmp";
				$class2parentPrefix["portal\\virgoPortal"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'prt_pages.pge_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_pages.pge_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_pages.pge_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_pages.pge_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoPage!', '', 'ERROR');
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
			$pdf->SetTitle('Pages report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('PAGES');
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
			if (P('show_pdf_title', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_alias', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_default', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_order', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_path', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_template', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_page', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_portal', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultPage = new virgoPage();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_title', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Title');
				$minWidth['title'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['title']) {
						$minWidth['title'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_alias', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Alias');
				$minWidth['alias'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['alias']) {
						$minWidth['alias'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_default', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Default');
				$minWidth['default'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['default']) {
						$minWidth['default'] = min($tmpLen, $maxWidth);
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
			if (P('show_pdf_path', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Path');
				$minWidth['path'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['path']) {
						$minWidth['path'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_template', "1") == "1") {
				$minWidth['template $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'template $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['template $relation.name']) {
						$minWidth['template $relation.name'] = min($tmpLen, $maxWidth);
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
			$whereClausePage = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClausePage = $whereClausePage . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaPage = $resultPage->getCriteria();
			$fieldCriteriaTitle = $criteriaPage["title"];
			if ($fieldCriteriaTitle["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Title', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaTitle["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Title', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaAlias = $criteriaPage["alias"];
			if ($fieldCriteriaAlias["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Alias', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaAlias["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Alias', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaDefault = $criteriaPage["default"];
			if ($fieldCriteriaDefault["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Default', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaDefault["value"];
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
					$pdf->MultiCell(60, 100, 'Default', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaOrder = $criteriaPage["order"];
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
			$fieldCriteriaPath = $criteriaPage["path"];
			if ($fieldCriteriaPath["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Path', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaPath["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Path', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaPage["template"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Template', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoTemplate::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Template', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaPage["page"];
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
			$parentCriteria = $criteriaPage["portal"];
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
			$limit = P('limit_to_template');
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
					$inCondition = " prt_pages.pge_tmp_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_pages.pge_tmp_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePage = $whereClausePage . " AND ({$inCondition} {$nullCondition} )";
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
					$inCondition = " prt_pages.pge_pge_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_pages.pge_pge_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePage = $whereClausePage . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_portal');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_pages.pge_prt_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_pages.pge_prt_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePage = $whereClausePage . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaPage = self::getCriteria();
			if (isset($criteriaPage["title"])) {
				$fieldCriteriaTitle = $criteriaPage["title"];
				if ($fieldCriteriaTitle["is_null"] == 1) {
$filter = $filter . ' AND prt_pages.pge_title IS NOT NULL ';
				} elseif ($fieldCriteriaTitle["is_null"] == 2) {
$filter = $filter . ' AND prt_pages.pge_title IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaTitle["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_pages.pge_title like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPage["alias"])) {
				$fieldCriteriaAlias = $criteriaPage["alias"];
				if ($fieldCriteriaAlias["is_null"] == 1) {
$filter = $filter . ' AND prt_pages.pge_alias IS NOT NULL ';
				} elseif ($fieldCriteriaAlias["is_null"] == 2) {
$filter = $filter . ' AND prt_pages.pge_alias IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaAlias["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_pages.pge_alias like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPage["default"])) {
				$fieldCriteriaDefault = $criteriaPage["default"];
				if ($fieldCriteriaDefault["is_null"] == 1) {
$filter = $filter . ' AND prt_pages.pge_default IS NOT NULL ';
				} elseif ($fieldCriteriaDefault["is_null"] == 2) {
$filter = $filter . ' AND prt_pages.pge_default IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDefault["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_pages.pge_default = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaPage["order"])) {
				$fieldCriteriaOrder = $criteriaPage["order"];
				if ($fieldCriteriaOrder["is_null"] == 1) {
$filter = $filter . ' AND prt_pages.pge_order IS NOT NULL ';
				} elseif ($fieldCriteriaOrder["is_null"] == 2) {
$filter = $filter . ' AND prt_pages.pge_order IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaOrder["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_pages.pge_order = ? ";
				} else {
					$filter = $filter . " AND prt_pages.pge_order >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_pages.pge_order <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPage["path"])) {
				$fieldCriteriaPath = $criteriaPage["path"];
				if ($fieldCriteriaPath["is_null"] == 1) {
$filter = $filter . ' AND prt_pages.pge_path IS NOT NULL ';
				} elseif ($fieldCriteriaPath["is_null"] == 2) {
$filter = $filter . ' AND prt_pages.pge_path IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaPath["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_pages.pge_path like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPage["template"])) {
				$parentCriteria = $criteriaPage["template"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pge_tmp_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_pages.pge_tmp_id IN (SELECT tmp_id FROM prt_templates WHERE tmp_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPage["page"])) {
				$parentCriteria = $criteriaPage["page"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pge_pge_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_pages.pge_pge_id IN (SELECT pge_id FROM prt_pages WHERE pge_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPage["portal"])) {
				$parentCriteria = $criteriaPage["portal"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pge_prt_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_pages.pge_prt_id IN (SELECT prt_id FROM prt_portals WHERE prt_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPage["portlet_object"])) {
				$parentCriteria = $criteriaPage["portlet_object"];
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$filter = $filter . " AND prt_pages.pge_id IN (SELECT second_parent.plc_pge_id FROM prt_portlet_locations AS second_parent WHERE second_parent.plc_pob_id IN (" . implode(", ", $parentIds) . ")) ";
				}
			}
			$whereClausePage = $whereClausePage . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClausePage = $whereClausePage . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_pages.pge_id, prt_pages.pge_virgo_title ";
			$defaultOrderColumn = P('default_sort_column', 'pge_order');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_title', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_title pge_title";
			} else {
				if ($defaultOrderColumn == "pge_title") {
					$orderColumnNotDisplayed = " prt_pages.pge_title ";
				}
			}
			if (P('show_pdf_alias', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_alias pge_alias";
			} else {
				if ($defaultOrderColumn == "pge_alias") {
					$orderColumnNotDisplayed = " prt_pages.pge_alias ";
				}
			}
			if (P('show_pdf_default', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_default pge_default";
			} else {
				if ($defaultOrderColumn == "pge_default") {
					$orderColumnNotDisplayed = " prt_pages.pge_default ";
				}
			}
			if (P('show_pdf_order', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_order pge_order";
			} else {
				if ($defaultOrderColumn == "pge_order") {
					$orderColumnNotDisplayed = " prt_pages.pge_order ";
				}
			}
			if (P('show_pdf_path', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_path pge_path";
			} else {
				if ($defaultOrderColumn == "pge_path") {
					$orderColumnNotDisplayed = " prt_pages.pge_path ";
				}
			}
			if (class_exists('portal\virgoTemplate') && P('show_pdf_template', "1") != "0") { // */ && !in_array("tmp", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_pages.pge_tmp_id as pge_tmp_id ";
				$queryString = $queryString . ", prt_templates_parent.tmp_virgo_title as `template` ";
			} else {
				if ($defaultOrderColumn == "template") {
					$orderColumnNotDisplayed = " prt_templates_parent.tmp_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_pdf_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_pages.pge_pge_id as pge_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortal') && P('show_pdf_portal', "1") != "0") { // */ && !in_array("prt", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_pages.pge_prt_id as pge_prt_id ";
				$queryString = $queryString . ", prt_portals_parent.prt_virgo_title as `portal` ";
			} else {
				if ($defaultOrderColumn == "portal") {
					$orderColumnNotDisplayed = " prt_portals_parent.prt_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_pages ";
			if (class_exists('portal\virgoTemplate')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_templates AS prt_templates_parent ON (prt_pages.pge_tmp_id = prt_templates_parent.tmp_id) ";
			}
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_pages.pge_pge_id = prt_pages_parent.pge_id) ";
			}
			if (class_exists('portal\virgoPortal')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portals AS prt_portals_parent ON (prt_pages.pge_prt_id = prt_portals_parent.prt_id) ";
			}

		$resultsPage = $resultPage->select(
			'', 
			'all', 
			$resultPage->getOrderColumn(), 
			$resultPage->getOrderMode(), 
			$whereClausePage,
			$queryString);
		
		foreach ($resultsPage as $resultPage) {

			if (P('show_pdf_title', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPage['pge_title'])) + 6;
				if ($tmpLen > $minWidth['title']) {
					$minWidth['title'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_alias', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPage['pge_alias'])) + 6;
				if ($tmpLen > $minWidth['alias']) {
					$minWidth['alias'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_default', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPage['pge_default'])) + 6;
				if ($tmpLen > $minWidth['default']) {
					$minWidth['default'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_order', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPage['pge_order'])) + 6;
				if ($tmpLen > $minWidth['order']) {
					$minWidth['order'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_path', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPage['pge_path'])) + 6;
				if ($tmpLen > $minWidth['path']) {
					$minWidth['path'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_template', "1") == "1") {
			$parentValue = trim(virgoTemplate::lookup($resultPage['pgetmp__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['template $relation.name']) {
					$minWidth['template $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_page', "1") == "1") {
			$parentValue = trim(virgoPage::lookup($resultPage['pgepge__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['page $relation.name']) {
					$minWidth['page $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_portal', "1") == "1") {
			$parentValue = trim(virgoPortal::lookup($resultPage['pgeprt__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['portal $relation.name']) {
					$minWidth['portal $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaPage = $resultPage->getCriteria();
		if (is_null($criteriaPage) || sizeof($criteriaPage) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																																													if (P('show_pdf_title', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['title'], $colHeight, T('TITLE'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_alias', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['alias'], $colHeight, T('ALIAS'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_default', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['default'], $colHeight, T('DEFAULT'), 'T', 'C', 0, 0);
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
			if (P('show_pdf_path', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['path'], $colHeight, T('PATH'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_template', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['template $relation.name'], $colHeight, T('TEMPLATE') . ' ' . T(''), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_page', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['page $relation.name'], $colHeight, T('PAGE') . ' ' . T(''), 'T', 'C', 0, 0); 
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
		foreach ($resultsPage as $resultPage) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_title', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['title'], $colHeight, '' . $resultPage['pge_title'], 'T', 'L', 0, 0);
				if (P('show_pdf_title', "1") == "2") {
										if (!is_null($resultPage['pge_title'])) {
						$tmpCount = (float)$counts["title"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["title"] = $tmpCount;
					}
				}
				if (P('show_pdf_title', "1") == "3") {
										if (!is_null($resultPage['pge_title'])) {
						$tmpSum = (float)$sums["title"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPage['pge_title'];
						}
						$sums["title"] = $tmpSum;
					}
				}
				if (P('show_pdf_title', "1") == "4") {
										if (!is_null($resultPage['pge_title'])) {
						$tmpCount = (float)$avgCounts["title"];
						$tmpSum = (float)$avgSums["title"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["title"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPage['pge_title'];
						}
						$avgSums["title"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_alias', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['alias'], $colHeight, '' . $resultPage['pge_alias'], 'T', 'L', 0, 0);
				if (P('show_pdf_alias', "1") == "2") {
										if (!is_null($resultPage['pge_alias'])) {
						$tmpCount = (float)$counts["alias"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["alias"] = $tmpCount;
					}
				}
				if (P('show_pdf_alias', "1") == "3") {
										if (!is_null($resultPage['pge_alias'])) {
						$tmpSum = (float)$sums["alias"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPage['pge_alias'];
						}
						$sums["alias"] = $tmpSum;
					}
				}
				if (P('show_pdf_alias', "1") == "4") {
										if (!is_null($resultPage['pge_alias'])) {
						$tmpCount = (float)$avgCounts["alias"];
						$tmpSum = (float)$avgSums["alias"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["alias"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPage['pge_alias'];
						}
						$avgSums["alias"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_default', "0") != "0") {
			$renderCriteria = "";
			switch ($resultPage['pge_default']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['default'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_default', "1") == "2") {
										if (!is_null($resultPage['pge_default'])) {
						$tmpCount = (float)$counts["default"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["default"] = $tmpCount;
					}
				}
				if (P('show_pdf_default', "1") == "3") {
										if (!is_null($resultPage['pge_default'])) {
						$tmpSum = (float)$sums["default"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPage['pge_default'];
						}
						$sums["default"] = $tmpSum;
					}
				}
				if (P('show_pdf_default', "1") == "4") {
										if (!is_null($resultPage['pge_default'])) {
						$tmpCount = (float)$avgCounts["default"];
						$tmpSum = (float)$avgSums["default"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["default"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPage['pge_default'];
						}
						$avgSums["default"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_order', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['order'], $colHeight, '' . $resultPage['pge_order'], 'T', 'R', 0, 0);
				if (P('show_pdf_order', "1") == "2") {
										if (!is_null($resultPage['pge_order'])) {
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
										if (!is_null($resultPage['pge_order'])) {
						$tmpSum = (float)$sums["order"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPage['pge_order'];
						}
						$sums["order"] = $tmpSum;
					}
				}
				if (P('show_pdf_order', "1") == "4") {
										if (!is_null($resultPage['pge_order'])) {
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
							$tmpSum = $tmpSum + $resultPage['pge_order'];
						}
						$avgSums["order"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_path', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['path'], $colHeight, '' . $resultPage['pge_path'], 'T', 'L', 0, 0);
				if (P('show_pdf_path', "1") == "2") {
										if (!is_null($resultPage['pge_path'])) {
						$tmpCount = (float)$counts["path"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["path"] = $tmpCount;
					}
				}
				if (P('show_pdf_path', "1") == "3") {
										if (!is_null($resultPage['pge_path'])) {
						$tmpSum = (float)$sums["path"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPage['pge_path'];
						}
						$sums["path"] = $tmpSum;
					}
				}
				if (P('show_pdf_path', "1") == "4") {
										if (!is_null($resultPage['pge_path'])) {
						$tmpCount = (float)$avgCounts["path"];
						$tmpSum = (float)$avgSums["path"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["path"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPage['pge_path'];
						}
						$avgSums["path"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_template', "1") == "1") {
			$parentValue = virgoTemplate::lookup($resultPage['pge_tmp_id']);
			$tmpLn = $pdf->MultiCell($minWidth['template $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_page', "1") == "1") {
			$parentValue = virgoPage::lookup($resultPage['pge_pge_id']);
			$tmpLn = $pdf->MultiCell($minWidth['page $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_portal', "1") == "1") {
			$parentValue = virgoPortal::lookup($resultPage['pge_prt_id']);
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
			if (P('show_pdf_title', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['title'];
				if (P('show_pdf_title', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["title"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_alias', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['alias'];
				if (P('show_pdf_alias', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["alias"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_default', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['default'];
				if (P('show_pdf_default', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["default"];
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
			if (P('show_pdf_path', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['path'];
				if (P('show_pdf_path', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["path"];
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
			if (P('show_pdf_title', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['title'];
				if (P('show_pdf_title', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["title"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_alias', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['alias'];
				if (P('show_pdf_alias', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["alias"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_default', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['default'];
				if (P('show_pdf_default', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["default"], 2, ',', ' ');
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
			if (P('show_pdf_path', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['path'];
				if (P('show_pdf_path', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["path"], 2, ',', ' ');
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
			if (P('show_pdf_title', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['title'];
				if (P('show_pdf_title', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["title"] == 0 ? "-" : $avgSums["title"] / $avgCounts["title"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_alias', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['alias'];
				if (P('show_pdf_alias', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["alias"] == 0 ? "-" : $avgSums["alias"] / $avgCounts["alias"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_default', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['default'];
				if (P('show_pdf_default', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["default"] == 0 ? "-" : $avgSums["default"] / $avgCounts["default"]);
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
			if (P('show_pdf_path', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['path'];
				if (P('show_pdf_path', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["path"] == 0 ? "-" : $avgSums["path"] / $avgCounts["path"]);
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
				$reportTitle = T('PAGES');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultPage = new virgoPage();
			$whereClausePage = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePage = $whereClausePage . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_title', "1") != "0") {
					$data = $data . $stringDelimeter .'Title' . $stringDelimeter . $separator;
				}
				if (P('show_export_alias', "1") != "0") {
					$data = $data . $stringDelimeter .'Alias' . $stringDelimeter . $separator;
				}
				if (P('show_export_default', "1") != "0") {
					$data = $data . $stringDelimeter .'Default' . $stringDelimeter . $separator;
				}
				if (P('show_export_order', "1") != "0") {
					$data = $data . $stringDelimeter .'Order' . $stringDelimeter . $separator;
				}
				if (P('show_export_path', "1") != "0") {
					$data = $data . $stringDelimeter .'Path' . $stringDelimeter . $separator;
				}
				if (P('show_export_template', "1") != "0") {
					$data = $data . $stringDelimeter . 'Template ' . $stringDelimeter . $separator;
				}
				if (P('show_export_page', "1") != "0") {
					$data = $data . $stringDelimeter . 'Page ' . $stringDelimeter . $separator;
				}
				if (P('show_export_portal', "1") != "0") {
					$data = $data . $stringDelimeter . 'Portal ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_pages.pge_id, prt_pages.pge_virgo_title ";
			$defaultOrderColumn = P('default_sort_column', 'pge_order');
			$orderColumnNotDisplayed = "";
			if (P('show_export_title', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_title pge_title";
			} else {
				if ($defaultOrderColumn == "pge_title") {
					$orderColumnNotDisplayed = " prt_pages.pge_title ";
				}
			}
			if (P('show_export_alias', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_alias pge_alias";
			} else {
				if ($defaultOrderColumn == "pge_alias") {
					$orderColumnNotDisplayed = " prt_pages.pge_alias ";
				}
			}
			if (P('show_export_default', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_default pge_default";
			} else {
				if ($defaultOrderColumn == "pge_default") {
					$orderColumnNotDisplayed = " prt_pages.pge_default ";
				}
			}
			if (P('show_export_order', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_order pge_order";
			} else {
				if ($defaultOrderColumn == "pge_order") {
					$orderColumnNotDisplayed = " prt_pages.pge_order ";
				}
			}
			if (P('show_export_path', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_path pge_path";
			} else {
				if ($defaultOrderColumn == "pge_path") {
					$orderColumnNotDisplayed = " prt_pages.pge_path ";
				}
			}
			if (class_exists('portal\virgoTemplate') && P('show_export_template', "1") != "0") { // */ && !in_array("tmp", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_pages.pge_tmp_id as pge_tmp_id ";
				$queryString = $queryString . ", prt_templates_parent.tmp_virgo_title as `template` ";
			} else {
				if ($defaultOrderColumn == "template") {
					$orderColumnNotDisplayed = " prt_templates_parent.tmp_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_export_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_pages.pge_pge_id as pge_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortal') && P('show_export_portal', "1") != "0") { // */ && !in_array("prt", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_pages.pge_prt_id as pge_prt_id ";
				$queryString = $queryString . ", prt_portals_parent.prt_virgo_title as `portal` ";
			} else {
				if ($defaultOrderColumn == "portal") {
					$orderColumnNotDisplayed = " prt_portals_parent.prt_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_pages ";
			if (class_exists('portal\virgoTemplate')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_templates AS prt_templates_parent ON (prt_pages.pge_tmp_id = prt_templates_parent.tmp_id) ";
			}
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_pages.pge_pge_id = prt_pages_parent.pge_id) ";
			}
			if (class_exists('portal\virgoPortal')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portals AS prt_portals_parent ON (prt_pages.pge_prt_id = prt_portals_parent.prt_id) ";
			}

			$resultsPage = $resultPage->select(
				'', 
				'all', 
				$resultPage->getOrderColumn(), 
				$resultPage->getOrderMode(), 
				$whereClausePage,
				$queryString);
			foreach ($resultsPage as $resultPage) {
				if (P('show_export_title', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPage['pge_title'] . $stringDelimeter . $separator;
				}
				if (P('show_export_alias', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPage['pge_alias'] . $stringDelimeter . $separator;
				}
				if (P('show_export_default', "1") != "0") {
			$data = $data . $resultPage['pge_default'] . $separator;
				}
				if (P('show_export_order', "1") != "0") {
			$data = $data . $resultPage['pge_order'] . $separator;
				}
				if (P('show_export_path', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPage['pge_path'] . $stringDelimeter . $separator;
				}
				if (P('show_export_template', "1") != "0") {
					$parentValue = virgoTemplate::lookup($resultPage['pge_tmp_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_page', "1") != "0") {
					$parentValue = virgoPage::lookup($resultPage['pge_pge_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_portal', "1") != "0") {
					$parentValue = virgoPortal::lookup($resultPage['pge_prt_id']);
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
				$reportTitle = T('PAGES');
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
			$resultPage = new virgoPage();
			$whereClausePage = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePage = $whereClausePage . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_title', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Title');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_alias', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Alias');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_default', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Default');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_order', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Order');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_path', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Path');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_template', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Template ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoTemplate::getVirgoList();
					$formulaTemplate = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaTemplate != "") {
							$formulaTemplate = $formulaTemplate . ',';
						}
						$formulaTemplate = $formulaTemplate . $key;
					}
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
			$queryString = " SELECT prt_pages.pge_id, prt_pages.pge_virgo_title ";
			$defaultOrderColumn = P('default_sort_column', 'pge_order');
			$orderColumnNotDisplayed = "";
			if (P('show_export_title', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_title pge_title";
			} else {
				if ($defaultOrderColumn == "pge_title") {
					$orderColumnNotDisplayed = " prt_pages.pge_title ";
				}
			}
			if (P('show_export_alias', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_alias pge_alias";
			} else {
				if ($defaultOrderColumn == "pge_alias") {
					$orderColumnNotDisplayed = " prt_pages.pge_alias ";
				}
			}
			if (P('show_export_default', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_default pge_default";
			} else {
				if ($defaultOrderColumn == "pge_default") {
					$orderColumnNotDisplayed = " prt_pages.pge_default ";
				}
			}
			if (P('show_export_order', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_order pge_order";
			} else {
				if ($defaultOrderColumn == "pge_order") {
					$orderColumnNotDisplayed = " prt_pages.pge_order ";
				}
			}
			if (P('show_export_path', "1") != "0") {
				$queryString = $queryString . ", prt_pages.pge_path pge_path";
			} else {
				if ($defaultOrderColumn == "pge_path") {
					$orderColumnNotDisplayed = " prt_pages.pge_path ";
				}
			}
			if (class_exists('portal\virgoTemplate') && P('show_export_template', "1") != "0") { // */ && !in_array("tmp", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_pages.pge_tmp_id as pge_tmp_id ";
				$queryString = $queryString . ", prt_templates_parent.tmp_virgo_title as `template` ";
			} else {
				if ($defaultOrderColumn == "template") {
					$orderColumnNotDisplayed = " prt_templates_parent.tmp_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_export_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_pages.pge_pge_id as pge_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortal') && P('show_export_portal', "1") != "0") { // */ && !in_array("prt", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_pages.pge_prt_id as pge_prt_id ";
				$queryString = $queryString . ", prt_portals_parent.prt_virgo_title as `portal` ";
			} else {
				if ($defaultOrderColumn == "portal") {
					$orderColumnNotDisplayed = " prt_portals_parent.prt_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_pages ";
			if (class_exists('portal\virgoTemplate')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_templates AS prt_templates_parent ON (prt_pages.pge_tmp_id = prt_templates_parent.tmp_id) ";
			}
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_pages.pge_pge_id = prt_pages_parent.pge_id) ";
			}
			if (class_exists('portal\virgoPortal')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portals AS prt_portals_parent ON (prt_pages.pge_prt_id = prt_portals_parent.prt_id) ";
			}

			$resultsPage = $resultPage->select(
				'', 
				'all', 
				$resultPage->getOrderColumn(), 
				$resultPage->getOrderMode(), 
				$whereClausePage,
				$queryString);
			$index = 1;
			foreach ($resultsPage as $resultPage) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultPage['pge_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_title', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPage['pge_title'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_alias', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPage['pge_alias'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_default', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPage['pge_default'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_order', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPage['pge_order'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_path', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPage['pge_path'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_template', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoTemplate::lookup($resultPage['pge_tmp_id']);
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
					$objValidation->setFormula1('"' . $formulaTemplate . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
				if (P('show_export_page', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoPage::lookup($resultPage['pge_pge_id']);
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
				if (P('show_export_portal', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoPortal::lookup($resultPage['pge_prt_id']);
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
					$propertyColumnHash['title'] = 'pge_title';
					$propertyColumnHash['title'] = 'pge_title';
					$propertyColumnHash['alias'] = 'pge_alias';
					$propertyColumnHash['alias'] = 'pge_alias';
					$propertyColumnHash['default'] = 'pge_default';
					$propertyColumnHash['default'] = 'pge_default';
					$propertyColumnHash['order'] = 'pge_order';
					$propertyColumnHash['order'] = 'pge_order';
					$propertyColumnHash['path'] = 'pge_path';
					$propertyColumnHash['path'] = 'pge_path';
					$propertyClassHash['template'] = 'Template';
					$propertyClassHash['template'] = 'Template';
					$propertyColumnHash['template'] = 'pge_tmp_id';
					$propertyColumnHash['template'] = 'pge_tmp_id';
					$propertyClassHash['page'] = 'Page';
					$propertyClassHash['page'] = 'Page';
					$propertyColumnHash['page'] = 'pge_pge_id';
					$propertyColumnHash['page'] = 'pge_pge_id';
					$propertyClassHash['portal'] = 'Portal';
					$propertyClassHash['portal'] = 'Portal';
					$propertyColumnHash['portal'] = 'pge_prt_id';
					$propertyColumnHash['portal'] = 'pge_prt_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importPage = new virgoPage();
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
										L(T('PROPERTY_NOT_FOUND', T('PAGE'), $columns[$index]), '', 'ERROR');
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
										$importPage->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_template');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoTemplate::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoTemplate::token2Id($tmpToken);
	}
	$importPage->setTmpId($defaultValue);
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
	$importPage->setPgeId($defaultValue);
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
	$importPage->setPrtId($defaultValue);
}
							$errorMessage = $importPage->store();
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
		


		static function portletActionAddSelectedToNMRecordPortletObject() {
			$portletObjectId = R('plc_portletObject_');
			$idsToDeleteString = R('ids');
			$idsToDelete = split(",", $idsToDeleteString);
			foreach ($idsToDelete as $idToDelete) {
				$newPortletLocation = new virgoPortletLocation();
				$newPortletLocation->setPgeId($idToDelete);
				$newPortletLocation->setPobId($portletObjectId);
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
				$newPortletLocation->setPgeId($idToDelete);
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


		static function portletActionVirgoSetTemplate() {
			$this->loadFromDB();
			$parentId = R('pge_Template_id_' . $_SESSION['current_portlet_object_id']);
			$this->setTmpId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetPage() {
			$this->loadFromDB();
			$parentId = R('pge_Page_id_' . $_SESSION['current_portlet_object_id']);
			$this->setPgeId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetPortal() {
			$this->loadFromDB();
			$parentId = R('pge_Portal_id_' . $_SESSION['current_portlet_object_id']);
			$this->setPrtId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}

		static function portletActionAddPortal() {
			self::setDisplayMode("ADD_NEW_PARENT_PORTAL");
		}

		static function portletActionStoreNewPortal() {
			$id = -1;
			if (virgoPortal::portletActionStore(true, $id) == -1) {
				self::setDisplayMode("ADD_NEW_PARENT_PORTAL");
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			} else {
				$tmpId = self::loadIdFromRequest();
				$_POST['pge_portal_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
				self::portletActionBackFromParent();
			}
		}

		static function portletActionBackFromParent() {
			$calligView = strtoupper(R('calling_view'));
			self::setDisplayMode($calligView);
			$pob = self::getMyPortletObject();
			$pob->setPortletSessionValue('reload_from_request', '1');				
		}
		static function getServerUrl() {
			$url = "http";
			if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
				$url = $url . "s";
			}
			return $url . "://" . $_SERVER["SERVER_NAME"] . substr($_SERVER["SCRIPT_NAME"], 0, strrpos($_SERVER["SCRIPT_NAME"], '/', -1));
		}

		static function getDefaultPage() {
			$url = virgoPage::getServerUrl();
			$portalName = R('virgo_portal');
			$portalCondition = (isset($portalName) ? " AND prt_identifier = ? " : " AND prt_identifier IS NULL ");
			$query = <<<SQL
SELECT
	pge_id
FROM
	prt_pages, 
	prt_portals
WHERE 
	pge_default = 1
	AND prt_id = pge_prt_id
	AND ? LIKE CONCAT(prt_url, IFNULL(prt_path, ?))
	$portalCondition
SQL;
			$ret = QP1($query, isset($portalName) ? "sss" : "ss", isset($portalName) ? array($url, "", $portalName) : array($url, ""));
			if (isset($ret)) {
				return new virgoPage($ret);
			}
			$myFile = PORTAL_PATH . DIRECTORY_SEPARATOR . "log" . DIRECTORY_SEPARATOR . "database_errors.log";
			$fh = fopen($myFile, 'a') or die("can't open file");
			$ip = virgoSystemMessage::getRealIp();
			$url = virgoSystemMessage::getRealUrl();
			fwrite($fh, " - - - page not found! - - - \n");
			fwrite($fh, "From URL:\n");
			fwrite($fh, "  portal_page_path: {$path}\n");
			fwrite($fh, "  virgo_portal: {$portalName}\n");
			fwrite($fh, "- -\n");
			fwrite($fh, "Query:\n");
			fwrite($fh, $query . "\n");
			fwrite($fh, "Call details: \n");
			fwrite($fh, "Datetime: " . date("Y-m-d H:i:s") . "\n");
			fwrite($fh, "IP: " . $ip . "\n");
			fwrite($fh, "URL: " . $url . "\n");
			fwrite($fh, " - - - - - - - - - - - - - - - - - - -\n");
			fwrite($fh, "\n");
			if (isset($details)) {
				fwrite($fh, $details);
			}
			fclose($fh);
			return null;
		}

		static function getCurrentPage() {
			$cached = C('virgo_current_page', $ret);
			if ($cached) {
				return new virgoPage($ret);
			}
			$path = R('portal_page_path');
			$portalName = R('virgo_portal');
			$portalCondition = (isset($portalName) ? " AND prt_identifier = ? " : " AND prt_identifier IS NULL ");
			$portalNameType = (isset($portalName) ? "s" : "");
			$portalNameValue = (isset($portalName) ? array($portalName) : array());
			$url = virgoPage::getServerUrl();
			$escapedUrl = QE($url);
			$query = <<<SQL
SELECT
	pge_id
FROM
	prt_pages, 
	prt_portals
WHERE 
	prt_id = pge_prt_id
	AND ? LIKE CONCAT(prt_url, IFNULL(prt_path, ?))
	$portalCondition
	AND 
SQL;
			if (isset($path) && trim($path) != "") {
				$query = $query . " pge_path = ? ";
				$pathType = "s";
				$pathValue = array("/{$path}");
			} else {
				$query = $query . " pge_default = 1 ";
				$pathType = "";
				$pathValue = array();
			}
			$ret = QP1($query, "ss".$portalNameType.$pathType, array_merge(array($url, ""), $portalNameValue, $pathValue));
			if (isset($ret)) {
				CS('virgo_current_page', $ret);
				return new virgoPage($ret);
			}
			$myFile = "database_errors.log";
			$fh = fopen($myFile, 'a') or die("can't open file");
			$ip = virgoSystemMessage::getRealIp();
			$url = virgoSystemMessage::getRealUrl();
			fwrite($fh, " - - - page not found! - - - \n");
			fwrite($fh, "From URL:\n");
			fwrite($fh, "  portal_page_path: {$path}\n");
			fwrite($fh, "  virgo_portal: {$portalName}\n");
			fwrite($fh, "- -\n");
			fwrite($fh, "Query:\n");
			fwrite($fh, $query . "\n");
			fwrite($fh, "Call details: \n");
			fwrite($fh, "Datetime: " . date("Y-m-d H:i:s") . "\n");
			fwrite($fh, "IP: " . $ip . "\n");
			fwrite($fh, "URL: " . $url . "\n");
			fwrite($fh, " - - - - - - - - - - - - - - - - - - -\n");
			fwrite($fh, "\n");
			if (isset($details)) {
				fwrite($fh, $details);
			}
			fclose($fh);
			return null;
		}
		
		function getPortletsInSection($sectionName, $canEditPage = false) {
			return $this->getPortlets($canEditPage, $sectionName);
		}
		
		function getPortlets($canEditPage = false, $sectionName = null) {
			if (is_null($sectionName)) {
				$sectionNameCondition = "";	
				$sectionType = "";
				$sectionValue = array();
			} else {
				$sectionNameCondition = " AND plc_section = ? ";
				$sectionType = "s";
				$sectionValue = array($sectionName);
			}
			$query = <<<SQL
SELECT
	plc_id,
	plc_pob_id
FROM
	prt_portlet_locations
WHERE 
	(plc_pge_id = ? OR (plc_pge_id IS NULL AND plc_prt_id = ?) OR (plc_pge_id IS NULL AND plc_prt_id IS NULL))
	{$sectionNameCondition}
ORDER BY plc_order	
SQL;
			$rows = QPR($query, "ii".$sectionType, array_merge(array($this->getId(), $this->getPortal()->getId()), $sectionValue));
			$ret = array();
			require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');
			foreach ($rows as $row) {
				if ($canEditPage || virgoRole::can(null, $row['plc_pob_id'], 'view')) {
					$ret[] = new virgoPortletLocation($row['plc_id']);
				}
			}
			return $ret;
		}

		function getNotAssignedPortletLocations($sectionsInTemplate) {
			$excludeType = "";
			$excludeValue = array();
			if (count($sectionsInTemplate) > 0) {
				for ($i=0; $i<count($sectionsInTemplate); $i++) {
					$excludeValue[] = $sectionsInTemplate[$i];
					$sectionsInTemplate[$i] = "?";
					$excludeType .= "s";
				}
				$excludeSections = "AND plc_section NOT IN (" . implode(',', $sectionsInTemplate) . ")";
			} else {
				$excludeSections = "";
			}
			$query = <<<SQL
SELECT
	plc_id
FROM
	prt_portlet_locations
WHERE 
	(plc_pge_id = ? OR (plc_pge_id IS NULL AND plc_prt_id = ?) OR (plc_pge_id IS NULL AND plc_prt_id IS NULL))
	{$excludeSections}
SQL;
			$rows = QPR($query, "ii".$excludeType, array_merge(array($this->getId(), $this->getPortal()->getId()), $excludeValue));
			$ret = array();
			require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletLocation'.DIRECTORY_SEPARATOR.'controller.php');
			foreach ($rows as $row) {
				$ret[] = new virgoPortletLocation($row['plc_id']);
			}
			return $ret;
		}
		
		static function redirectUrl($url = null, $checkPermissions = false) {
			if (!isset($url)) {
				$page = virgoPage::getCurrentPage();
				if ($checkPermissions) {
					if (!$page->canView()) {
						return false;
					}
				}
				$url = $page->getUrl();
			}
			header( "Location: $url" ) ;
			exit();
		}
		
		function redirect() {
			$_REQUEST['virgo_redirect_after_action'] = $this->getUrl();
		}
		
		static function redirectDefault() {
			$page = virgoPage::getDefaultPage();
			if ($page->canView()) {
				$page->redirect();
			} 
		}
		
		static function redirectSame() {
			virgoPage::redirectUrl(null);
		}		
		
		function updatePath() {
			$parentPath = is_null($this->getPage()) ? "" : $this->getPage()->getPath();
			$this->setPath($parentPath . "/" . $this->getAlias());
			foreach ($this->getPages() as $subPage) {
				$subPage->updatePath();
				$subPage->store();
			}
		}
		
		function getUrl($includeHost = false) {
			$path = $this->getPortal()->getPortalUrl() . $this->getPath();
			if ($path == "") {
				$path = "/";
			}
			if ($includeHost) {
				$path = virgoPage::getServerUrl() . $path;
			}
			return /* $this->getPortal()->getUrl() . */ /* "/index.php?portal_page_path=" . */ /*$path == "" ? "/" :*/ $path;
		}
		
		function canView() {
			return virgoRole::can($this, null, 'view');			
		}
		
		function canEdit() {
			return virgoRole::can($this, null, 'edit');			
		}
		
		function getTitleT() {
			return T($this->getTitle());
		}

		function getPageTemplate() {
			$template = $this->getTemplate();
			if (is_null($template->getId())) {
				$template = $this->getPortal()->getTemplate();
			}
			return $template;			
		}


		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `prt_pages` (
  `pge_id` bigint(20) unsigned NOT NULL auto_increment,
  `pge_virgo_state` varchar(50) default NULL,
  `pge_virgo_title` varchar(255) default NULL,
	`pge_tmp_id` int(11) default NULL,
	`pge_pge_id` int(11) default NULL,
	`pge_prt_id` int(11) default NULL,
  `pge_title` varchar(255), 
  `pge_alias` varchar(255), 
  `pge_default` boolean,  
  `pge_order` integer,  
  `pge_path` varchar(255), 
  `pge_date_created` datetime NOT NULL,
  `pge_date_modified` datetime default NULL,
  `pge_usr_created_id` int(11) NOT NULL,
  `pge_usr_modified_id` int(11) default NULL,
  KEY `pge_tmp_fk` (`pge_tmp_id`),
  KEY `pge_pge_fk` (`pge_pge_id`),
  KEY `pge_prt_fk` (`pge_prt_id`),
  PRIMARY KEY  (`pge_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/page.sql 
INSERT INTO `prt_pages` (`pge_virgo_title`, `pge_title`, `pge_alias`, `pge_default`, `pge_order`, `pge_path`) 
VALUES (title, some_value, some_value, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_pages table already exists.", '', 'FATAL');
				L("Error ocurred, please contact site Administrator.", '', 'ERROR');
 				return false;
 			}
 			return true;
 		}


		static function onInstall($pobId, $title) {
		}

		static function getIdByKeyPath($path) {
			$query = " SELECT pge_id FROM prt_pages WHERE 1 ";
			$query .= " AND pge_path = '{$path}' ";
			$rows = QR($query);
			foreach ($rows as $row) {
				return $row['pge_id'];
			}
			return null;
		}

		static function getByKeyPath($path) {
			$id = self::getIdByKeyPath($path);
			$ret = new virgoPage();
			if (isset($id)) {
				$ret->load($id);
			}
			return $ret;
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
			return "pge";
		}
		
		static function getPlural() {
			return "pages";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoTemplate";
			$ret[] = "virgoPage";
			$ret[] = "virgoPortal";
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoPermission";
			$ret[] = "virgoPortletLocation";
			$ret[] = "virgoPage";
			$ret[] = "virgoUser";
			$ret[] = "virgoRole";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_pages'));
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
			$virgoVersion = virgoPage::getVirgoVersion();
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
	
	

