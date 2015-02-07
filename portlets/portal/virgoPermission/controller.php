<?php
/**
* Module Permission
* @package Portal
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace portal;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoRole'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoPermission {

		 var  $prm_id = null;
		 var  $prm_view = null;

		 var  $prm_edit = null;

		 var  $prm_configure = null;

		 var  $prm_action = null;

		 var  $prm_execute = null;

		 var  $prm_rle_id = null;
		 var  $prm_pge_id = null;
		 var  $prm_pob_id = null;

		 var   $prm_date_created = null;
		 var   $prm_usr_created_id = null;
		 var   $prm_date_modified = null;
		 var   $prm_usr_modified_id = null;
		 var   $prm_virgo_title = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoPermission();
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
        	$this->prm_id = null;
		    $this->prm_date_created = null;
		    $this->prm_usr_created_id = null;
		    $this->prm_date_modified = null;
		    $this->prm_usr_modified_id = null;
		    $this->prm_virgo_title = null;
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
			return $this->prm_id;
		}

		function getView() {
			return $this->prm_view;
		}
		
		 function setView($val) {
			$this->prm_view = $val;
		}
		function getEdit() {
			return $this->prm_edit;
		}
		
		 function setEdit($val) {
			$this->prm_edit = $val;
		}
		function getConfigure() {
			return $this->prm_configure;
		}
		
		 function setConfigure($val) {
			$this->prm_configure = $val;
		}
		function getAction() {
			return $this->prm_action;
		}
		
		 function setAction($val) {
			$this->prm_action = $val;
		}
		function getExecute() {
			return $this->prm_execute;
		}
		
		 function setExecute($val) {
			$this->prm_execute = $val;
		}

		function getRoleId() {
			return $this->prm_rle_id;
		}
		
		 function setRoleId($val) {
			$this->prm_rle_id = $val;
		}
		function getPageId() {
			return $this->prm_pge_id;
		}
		
		 function setPageId($val) {
			$this->prm_pge_id = $val;
		}
		function getPortletObjectId() {
			return $this->prm_pob_id;
		}
		
		 function setPortletObjectId($val) {
			$this->prm_pob_id = $val;
		}

		function getDateCreated() {
			return $this->prm_date_created;
		}
		function getUsrCreatedId() {
			return $this->prm_usr_created_id;
		}
		function getDateModified() {
			return $this->prm_date_modified;
		}
		function getUsrModifiedId() {
			return $this->prm_usr_modified_id;
		}


		function getRleId() {
			return $this->getRoleId();
		}
		
		 function setRleId($val) {
			$this->setRoleId($val);
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

		function loadRecordFromRequest($rowId) {
			$this->prm_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('prm_view_' . $this->prm_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->prm_view = null;
		} else {
			$this->prm_view = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('prm_edit_' . $this->prm_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->prm_edit = null;
		} else {
			$this->prm_edit = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('prm_configure_' . $this->prm_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->prm_configure = null;
		} else {
			$this->prm_configure = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('prm_action_' . $this->prm_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->prm_action = null;
		} else {
			$this->prm_action = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('prm_execute_' . $this->prm_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->prm_execute = null;
		} else {
			$this->prm_execute = $tmpValue;
		}
	}

			$this->prm_rle_id = strval(R('prm_role_' . $this->prm_id));
			$this->prm_pge_id = strval(R('prm_page_' . $this->prm_id));
			$this->prm_pob_id = strval(R('prm_portletObject_' . $this->prm_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('prm_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaPermission = array();	
			$criteriaFieldPermission = array();	
			$isNullPermission = R('virgo_search_view_is_null');
			
			$criteriaFieldPermission["is_null"] = 0;
			if ($isNullPermission == "not_null") {
				$criteriaFieldPermission["is_null"] = 1;
			} elseif ($isNullPermission == "null") {
				$criteriaFieldPermission["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_view');

//			if ($isSet) {
			$criteriaFieldPermission["value"] = $dataTypeCriteria;
//			}
			$criteriaPermission["view"] = $criteriaFieldPermission;
			$criteriaFieldPermission = array();	
			$isNullPermission = R('virgo_search_edit_is_null');
			
			$criteriaFieldPermission["is_null"] = 0;
			if ($isNullPermission == "not_null") {
				$criteriaFieldPermission["is_null"] = 1;
			} elseif ($isNullPermission == "null") {
				$criteriaFieldPermission["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_edit');

//			if ($isSet) {
			$criteriaFieldPermission["value"] = $dataTypeCriteria;
//			}
			$criteriaPermission["edit"] = $criteriaFieldPermission;
			$criteriaFieldPermission = array();	
			$isNullPermission = R('virgo_search_configure_is_null');
			
			$criteriaFieldPermission["is_null"] = 0;
			if ($isNullPermission == "not_null") {
				$criteriaFieldPermission["is_null"] = 1;
			} elseif ($isNullPermission == "null") {
				$criteriaFieldPermission["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_configure');

//			if ($isSet) {
			$criteriaFieldPermission["value"] = $dataTypeCriteria;
//			}
			$criteriaPermission["configure"] = $criteriaFieldPermission;
			$criteriaFieldPermission = array();	
			$isNullPermission = R('virgo_search_action_is_null');
			
			$criteriaFieldPermission["is_null"] = 0;
			if ($isNullPermission == "not_null") {
				$criteriaFieldPermission["is_null"] = 1;
			} elseif ($isNullPermission == "null") {
				$criteriaFieldPermission["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_action');

//			if ($isSet) {
			$criteriaFieldPermission["value"] = $dataTypeCriteria;
//			}
			$criteriaPermission["action"] = $criteriaFieldPermission;
			$criteriaFieldPermission = array();	
			$isNullPermission = R('virgo_search_execute_is_null');
			
			$criteriaFieldPermission["is_null"] = 0;
			if ($isNullPermission == "not_null") {
				$criteriaFieldPermission["is_null"] = 1;
			} elseif ($isNullPermission == "null") {
				$criteriaFieldPermission["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_execute');

//			if ($isSet) {
			$criteriaFieldPermission["value"] = $dataTypeCriteria;
//			}
			$criteriaPermission["execute"] = $criteriaFieldPermission;
			$criteriaParent = array();	
			$isNull = R('virgo_search_role_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_role', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
			}
			$criteriaPermission["role"] = $criteriaParent;
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
			$criteriaPermission["page"] = $criteriaParent;
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
			$criteriaPermission["portlet_object"] = $criteriaParent;
			self::setCriteria($criteriaPermission);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_view');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterView', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterView', null);
			}
			$tableFilter = R('virgo_filter_edit');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterEdit', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterEdit', null);
			}
			$tableFilter = R('virgo_filter_configure');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterConfigure', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterConfigure', null);
			}
			$tableFilter = R('virgo_filter_action');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterAction', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterAction', null);
			}
			$tableFilter = R('virgo_filter_execute');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterExecute', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterExecute', null);
			}
			$parentFilter = R('virgo_filter_role');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterRole', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterRole', null);
			}
			$parentFilter = R('virgo_filter_title_role');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleRole', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleRole', null);
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
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClausePermission = ' 1 = 1 ';
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
				$eventColumn = "prm_" . P('event_column');
				$whereClausePermission = $whereClausePermission . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePermission = $whereClausePermission . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_role');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_permissions.prm_rle_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_permissions.prm_rle_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePermission = $whereClausePermission . " AND ({$inCondition} {$nullCondition} )";
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
					$inCondition = " prt_permissions.prm_pge_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_permissions.prm_pge_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePermission = $whereClausePermission . " AND ({$inCondition} {$nullCondition} )";
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
					$inCondition = " prt_permissions.prm_pob_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_permissions.prm_pob_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePermission = $whereClausePermission . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaPermission = self::getCriteria();
			if (isset($criteriaPermission["view"])) {
				$fieldCriteriaView = $criteriaPermission["view"];
				if ($fieldCriteriaView["is_null"] == 1) {
$filter = $filter . ' AND prt_permissions.prm_view IS NOT NULL ';
				} elseif ($fieldCriteriaView["is_null"] == 2) {
$filter = $filter . ' AND prt_permissions.prm_view IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaView["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_permissions.prm_view = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaPermission["edit"])) {
				$fieldCriteriaEdit = $criteriaPermission["edit"];
				if ($fieldCriteriaEdit["is_null"] == 1) {
$filter = $filter . ' AND prt_permissions.prm_edit IS NOT NULL ';
				} elseif ($fieldCriteriaEdit["is_null"] == 2) {
$filter = $filter . ' AND prt_permissions.prm_edit IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaEdit["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_permissions.prm_edit = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaPermission["configure"])) {
				$fieldCriteriaConfigure = $criteriaPermission["configure"];
				if ($fieldCriteriaConfigure["is_null"] == 1) {
$filter = $filter . ' AND prt_permissions.prm_configure IS NOT NULL ';
				} elseif ($fieldCriteriaConfigure["is_null"] == 2) {
$filter = $filter . ' AND prt_permissions.prm_configure IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaConfigure["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_permissions.prm_configure = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaPermission["action"])) {
				$fieldCriteriaAction = $criteriaPermission["action"];
				if ($fieldCriteriaAction["is_null"] == 1) {
$filter = $filter . ' AND prt_permissions.prm_action IS NOT NULL ';
				} elseif ($fieldCriteriaAction["is_null"] == 2) {
$filter = $filter . ' AND prt_permissions.prm_action IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaAction["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_permissions.prm_action like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPermission["execute"])) {
				$fieldCriteriaExecute = $criteriaPermission["execute"];
				if ($fieldCriteriaExecute["is_null"] == 1) {
$filter = $filter . ' AND prt_permissions.prm_execute IS NOT NULL ';
				} elseif ($fieldCriteriaExecute["is_null"] == 2) {
$filter = $filter . ' AND prt_permissions.prm_execute IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaExecute["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_permissions.prm_execute = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaPermission["role"])) {
				$parentCriteria = $criteriaPermission["role"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND prm_rle_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND prt_permissions.prm_rle_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			if (isset($criteriaPermission["page"])) {
				$parentCriteria = $criteriaPermission["page"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND prm_pge_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_permissions.prm_pge_id IN (SELECT pge_id FROM prt_pages WHERE pge_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPermission["portlet_object"])) {
				$parentCriteria = $criteriaPermission["portlet_object"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND prm_pob_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_permissions.prm_pob_id IN (SELECT pob_id FROM prt_portlet_objects WHERE pob_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClausePermission = $whereClausePermission . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClausePermission = $whereClausePermission . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClausePermission = $whereClausePermission . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterView', null);
				if (S($tableFilter)) {
					$whereClausePermission = $whereClausePermission . " AND prm_view LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterEdit', null);
				if (S($tableFilter)) {
					$whereClausePermission = $whereClausePermission . " AND prm_edit LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterConfigure', null);
				if (S($tableFilter)) {
					$whereClausePermission = $whereClausePermission . " AND prm_configure LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterAction', null);
				if (S($tableFilter)) {
					$whereClausePermission = $whereClausePermission . " AND prm_action LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterExecute', null);
				if (S($tableFilter)) {
					$whereClausePermission = $whereClausePermission . " AND prm_execute LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterRole', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePermission = $whereClausePermission . " AND prm_rle_id IS NULL ";
					} else {
						$whereClausePermission = $whereClausePermission . " AND prm_rle_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleRole', null);
				if (S($parentFilter)) {
					$whereClausePermission = $whereClausePermission . " AND prt_roles_parent.rle_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterPage', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePermission = $whereClausePermission . " AND prm_pge_id IS NULL ";
					} else {
						$whereClausePermission = $whereClausePermission . " AND prm_pge_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitlePage', null);
				if (S($parentFilter)) {
					$whereClausePermission = $whereClausePermission . " AND prt_pages_parent.pge_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterPortletObject', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePermission = $whereClausePermission . " AND prm_pob_id IS NULL ";
					} else {
						$whereClausePermission = $whereClausePermission . " AND prm_pob_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitlePortletObject', null);
				if (S($parentFilter)) {
					$whereClausePermission = $whereClausePermission . " AND prt_portlet_objects_parent.pob_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClausePermission;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClausePermission = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_permissions.prm_id, prt_permissions.prm_virgo_title ";
			$defaultOrderColumn = P('default_sort_column', 'prm_order');
			$orderColumnNotDisplayed = "";
			if (P('show_table_view', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_view prm_view";
			} else {
				if ($defaultOrderColumn == "prm_view") {
					$orderColumnNotDisplayed = " prt_permissions.prm_view ";
				}
			}
			if (P('show_table_edit', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_edit prm_edit";
			} else {
				if ($defaultOrderColumn == "prm_edit") {
					$orderColumnNotDisplayed = " prt_permissions.prm_edit ";
				}
			}
			if (P('show_table_configure', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_configure prm_configure";
			} else {
				if ($defaultOrderColumn == "prm_configure") {
					$orderColumnNotDisplayed = " prt_permissions.prm_configure ";
				}
			}
			if (P('show_table_action', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_action prm_action";
			} else {
				if ($defaultOrderColumn == "prm_action") {
					$orderColumnNotDisplayed = " prt_permissions.prm_action ";
				}
			}
			if (P('show_table_execute', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_execute prm_execute";
			} else {
				if ($defaultOrderColumn == "prm_execute") {
					$orderColumnNotDisplayed = " prt_permissions.prm_execute ";
				}
			}
			if (class_exists('portal\virgoRole') && P('show_table_role', "1") != "0") { // */ && !in_array("rle", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_permissions.prm_rle_id as prm_rle_id ";
				$queryString = $queryString . ", prt_roles_parent.rle_virgo_title as `role` ";
			} else {
				if ($defaultOrderColumn == "role") {
					$orderColumnNotDisplayed = " prt_roles_parent.rle_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_table_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_permissions.prm_pge_id as prm_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_table_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_permissions.prm_pob_id as prm_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_permissions ";
			if (class_exists('portal\virgoRole')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_roles AS prt_roles_parent ON (prt_permissions.prm_rle_id = prt_roles_parent.rle_id) ";
			}
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_permissions.prm_pge_id = prt_pages_parent.pge_id) ";
			}
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_permissions.prm_pob_id = prt_portlet_objects_parent.pob_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClausePermission = $whereClausePermission . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClausePermission, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClausePermission,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_permissions"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " prm_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " prm_usr_created_id = ? ";
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
				. "\n FROM prt_permissions"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_permissions ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_permissions ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, prm_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " prm_usr_created_id = ? ";
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
				$query = "SELECT COUNT(prm_id) cnt FROM permissions";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as permissions ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as permissions ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoPermission();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_permissions WHERE prm_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->prm_id = $row['prm_id'];
$this->prm_view = $row['prm_view'];
$this->prm_edit = $row['prm_edit'];
$this->prm_configure = $row['prm_configure'];
$this->prm_action = $row['prm_action'];
$this->prm_execute = $row['prm_execute'];
						$this->prm_rle_id = $row['prm_rle_id'];
						$this->prm_pge_id = $row['prm_pge_id'];
						$this->prm_pob_id = $row['prm_pob_id'];
						if ($fetchUsernames) {
							if ($row['prm_date_created']) {
								if ($row['prm_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['prm_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['prm_date_modified']) {
								if ($row['prm_usr_modified_id'] == $row['prm_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['prm_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['prm_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->prm_date_created = $row['prm_date_created'];
						$this->prm_usr_created_id = $fetchUsernames ? $createdBy : $row['prm_usr_created_id'];
						$this->prm_date_modified = $row['prm_date_modified'];
						$this->prm_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['prm_usr_modified_id'];
						$this->prm_virgo_title = $row['prm_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_permissions SET prm_usr_created_id = {$userId} WHERE prm_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->prm_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoPermission::selectAllAsObjectsStatic('prm_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->prm_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->prm_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('prm_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_prm = new virgoPermission();
				$tmp_prm->load((int)$lookup_id);
				return $tmp_prm->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoPermission');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" prm_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoPermission', "10");
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
				$query = $query . " prm_id as id, prm_virgo_title as title ";
			}
			$query = $query . " FROM prt_permissions ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoPermission', 'portal') == "1") {
				$privateCondition = " prm_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY prm_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resPermission = array();
				foreach ($rows as $row) {
					$resPermission[$row['id']] = $row['title'];
				}
				return $resPermission;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticPermission = new virgoPermission();
			return $staticPermission->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getRoleStatic($parentId) {
			return virgoRole::getById($parentId);
		}
		
		function getRole() {
			return virgoPermission::getRoleStatic($this->prm_rle_id);
		}
		static function getPageStatic($parentId) {
			return virgoPage::getById($parentId);
		}
		
		function getPage() {
			return virgoPermission::getPageStatic($this->prm_pge_id);
		}
		static function getPortletObjectStatic($parentId) {
			return virgoPortletObject::getById($parentId);
		}
		
		function getPortletObject() {
			return virgoPermission::getPortletObjectStatic($this->prm_pob_id);
		}


		function validateObject($virgoOld) {
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_view_obligatory', "0") == "1") {
				if (
(is_null($this->getView()) || trim($this->getView()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'VIEW');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_edit_obligatory', "0") == "1") {
				if (
(is_null($this->getEdit()) || trim($this->getEdit()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'EDIT');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_configure_obligatory', "0") == "1") {
				if (
(is_null($this->getConfigure()) || trim($this->getConfigure()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'CONFIGURE');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_action_obligatory', "0") == "1") {
				if (
(is_null($this->getAction()) || trim($this->getAction()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'ACTION');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_execute_obligatory', "0") == "1") {
				if (
(is_null($this->getExecute()) || trim($this->getExecute()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'EXECUTE');
				}			
			}
				if (is_null($this->prm_rle_id) || trim($this->prm_rle_id) == "") {
					if (R('create_prm_role_' . $this->prm_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'ROLE', '');
					}
			}			
			$tmpMode = (is_null($this->getId()) ? "create" : "form");
			if (P('show_'.$tmpMode.'_page_obligatory', "0") == "1") {
				if (is_null($this->prm_pge_id) || trim($this->prm_pge_id) == "") {
					if (R('create_prm_page_' . $this->prm_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'PAGE', '');
					}
				}
			}			
			$tmpMode = (is_null($this->getId()) ? "create" : "form");
			if (P('show_'.$tmpMode.'_portlet_object_obligatory', "0") == "1") {
				if (is_null($this->prm_pob_id) || trim($this->prm_pob_id) == "") {
					if (R('create_prm_portletObject_' . $this->prm_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'PORTLET_OBJECT', '');
					}
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_permissions WHERE prm_id = " . $this->getId();
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
				$colNames = $colNames . ", prm_view";
				$values = $values . ", " . (is_null($objectToStore->getView()) ? "null" : "'" . QE($objectToStore->getView()) . "'");
				$colNames = $colNames . ", prm_edit";
				$values = $values . ", " . (is_null($objectToStore->getEdit()) ? "null" : "'" . QE($objectToStore->getEdit()) . "'");
				$colNames = $colNames . ", prm_configure";
				$values = $values . ", " . (is_null($objectToStore->getConfigure()) ? "null" : "'" . QE($objectToStore->getConfigure()) . "'");
				$colNames = $colNames . ", prm_action";
				$values = $values . ", " . (is_null($objectToStore->getAction()) ? "null" : "'" . QE($objectToStore->getAction()) . "'");
				$colNames = $colNames . ", prm_execute";
				$values = $values . ", " . (is_null($objectToStore->getExecute()) ? "null" : "'" . QE($objectToStore->getExecute()) . "'");
				$colNames = $colNames . ", prm_rle_id";
				$values = $values . ", " . (is_null($objectToStore->getRleId()) || $objectToStore->getRleId() == "" ? "null" : $objectToStore->getRleId());
				$colNames = $colNames . ", prm_pge_id";
				$values = $values . ", " . (is_null($objectToStore->getPgeId()) || $objectToStore->getPgeId() == "" ? "null" : $objectToStore->getPgeId());
				$colNames = $colNames . ", prm_pob_id";
				$values = $values . ", " . (is_null($objectToStore->getPobId()) || $objectToStore->getPobId() == "" ? "null" : $objectToStore->getPobId());
				$query = "INSERT INTO prt_history_permissions (revision, ip, username, user_id, timestamp, prm_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getView() != $objectToStore->getView()) {
				if (is_null($objectToStore->getView())) {
					$nullifiedProperties = $nullifiedProperties . "view,";
				} else {
				$colNames = $colNames . ", prm_view";
				$values = $values . ", " . (is_null($objectToStore->getView()) ? "null" : "'" . QE($objectToStore->getView()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getEdit() != $objectToStore->getEdit()) {
				if (is_null($objectToStore->getEdit())) {
					$nullifiedProperties = $nullifiedProperties . "edit,";
				} else {
				$colNames = $colNames . ", prm_edit";
				$values = $values . ", " . (is_null($objectToStore->getEdit()) ? "null" : "'" . QE($objectToStore->getEdit()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getConfigure() != $objectToStore->getConfigure()) {
				if (is_null($objectToStore->getConfigure())) {
					$nullifiedProperties = $nullifiedProperties . "configure,";
				} else {
				$colNames = $colNames . ", prm_configure";
				$values = $values . ", " . (is_null($objectToStore->getConfigure()) ? "null" : "'" . QE($objectToStore->getConfigure()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getAction() != $objectToStore->getAction()) {
				if (is_null($objectToStore->getAction())) {
					$nullifiedProperties = $nullifiedProperties . "action,";
				} else {
				$colNames = $colNames . ", prm_action";
				$values = $values . ", " . (is_null($objectToStore->getAction()) ? "null" : "'" . QE($objectToStore->getAction()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getExecute() != $objectToStore->getExecute()) {
				if (is_null($objectToStore->getExecute())) {
					$nullifiedProperties = $nullifiedProperties . "execute,";
				} else {
				$colNames = $colNames . ", prm_execute";
				$values = $values . ", " . (is_null($objectToStore->getExecute()) ? "null" : "'" . QE($objectToStore->getExecute()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getRleId() != $objectToStore->getRleId() && ($virgoOld->getRleId() != 0 || $objectToStore->getRleId() != ""))) { 
				$colNames = $colNames . ", prm_rle_id";
				$values = $values . ", " . (is_null($objectToStore->getRleId()) ? "null" : ($objectToStore->getRleId() == "" ? "0" : $objectToStore->getRleId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getPgeId() != $objectToStore->getPgeId() && ($virgoOld->getPgeId() != 0 || $objectToStore->getPgeId() != ""))) { 
				$colNames = $colNames . ", prm_pge_id";
				$values = $values . ", " . (is_null($objectToStore->getPgeId()) ? "null" : ($objectToStore->getPgeId() == "" ? "0" : $objectToStore->getPgeId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getPobId() != $objectToStore->getPobId() && ($virgoOld->getPobId() != 0 || $objectToStore->getPobId() != ""))) { 
				$colNames = $colNames . ", prm_pob_id";
				$values = $values . ", " . (is_null($objectToStore->getPobId()) ? "null" : ($objectToStore->getPobId() == "" ? "0" : $objectToStore->getPobId()));
			}
			$query = "INSERT INTO prt_history_permissions (revision, ip, username, user_id, timestamp, prm_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_permissions");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'prm_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_permissions ADD COLUMN (prm_virgo_title VARCHAR(255));";
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
			if (isset($this->prm_id) && $this->prm_id != "") {
				$query = "UPDATE prt_permissions SET ";
			if (isset($this->prm_view)) {
				$query .= " prm_view = ? ,";
				$types .= "s";
				$values[] = $this->prm_view;
			} else {
				$query .= " prm_view = NULL ,";				
			}
			if (isset($this->prm_edit)) {
				$query .= " prm_edit = ? ,";
				$types .= "s";
				$values[] = $this->prm_edit;
			} else {
				$query .= " prm_edit = NULL ,";				
			}
			if (isset($this->prm_configure)) {
				$query .= " prm_configure = ? ,";
				$types .= "s";
				$values[] = $this->prm_configure;
			} else {
				$query .= " prm_configure = NULL ,";				
			}
			if (isset($this->prm_action)) {
				$query .= " prm_action = ? ,";
				$types .= "s";
				$values[] = $this->prm_action;
			} else {
				$query .= " prm_action = NULL ,";				
			}
			if (isset($this->prm_execute)) {
				$query .= " prm_execute = ? ,";
				$types .= "s";
				$values[] = $this->prm_execute;
			} else {
				$query .= " prm_execute = NULL ,";				
			}
				if (isset($this->prm_rle_id) && trim($this->prm_rle_id) != "") {
					$query = $query . " prm_rle_id = ? , ";
					$types = $types . "i";
					$values[] = $this->prm_rle_id;
				} else {
					$query = $query . " prm_rle_id = NULL, ";
				}
				if (isset($this->prm_pge_id) && trim($this->prm_pge_id) != "") {
					$query = $query . " prm_pge_id = ? , ";
					$types = $types . "i";
					$values[] = $this->prm_pge_id;
				} else {
					$query = $query . " prm_pge_id = NULL, ";
				}
				if (isset($this->prm_pob_id) && trim($this->prm_pob_id) != "") {
					$query = $query . " prm_pob_id = ? , ";
					$types = $types . "i";
					$values[] = $this->prm_pob_id;
				} else {
					$query = $query . " prm_pob_id = NULL, ";
				}
				$query = $query . " prm_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " prm_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->prm_date_modified;

				$query = $query . " prm_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->prm_usr_modified_id;

				$query = $query . " WHERE prm_id = ? ";
				$types = $types . "i";
				$values[] = $this->prm_id;
			} else {
				$query = "INSERT INTO prt_permissions ( ";
			$query = $query . " prm_view, ";
			$query = $query . " prm_edit, ";
			$query = $query . " prm_configure, ";
			$query = $query . " prm_action, ";
			$query = $query . " prm_execute, ";
				$query = $query . " prm_rle_id, ";
				$query = $query . " prm_pge_id, ";
				$query = $query . " prm_pob_id, ";
				$query = $query . " prm_virgo_title, prm_date_created, prm_usr_created_id) VALUES ( ";
			if (isset($this->prm_view)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prm_view;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prm_edit)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prm_edit;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prm_configure)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prm_configure;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prm_action)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prm_action;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prm_execute)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prm_execute;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->prm_rle_id) && trim($this->prm_rle_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->prm_rle_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->prm_pge_id) && trim($this->prm_pge_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->prm_pge_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->prm_pob_id) && trim($this->prm_pob_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->prm_pob_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->prm_date_created;
				$values[] = $this->prm_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->prm_id) || $this->prm_id == "") {
					$this->prm_id = QID();
				}
				if ($log) {
					L("permission stored successfully", "id = {$this->prm_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->prm_id) {
				$virgoOld = new virgoPermission($this->prm_id);
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
					if ($this->prm_id) {			
						$this->prm_date_modified = date("Y-m-d H:i:s");
						$this->prm_usr_modified_id = $userId;
					} else {
						$this->prm_date_created = date("Y-m-d H:i:s");
						$this->prm_usr_created_id = $userId;
					}
					$this->prm_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "permission" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "permission" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM prt_permissions WHERE prm_id = {$this->prm_id}";
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
			$tmp = new virgoPermission();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT prm_id as id FROM prt_permissions";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'prm_order_column')) {
				$orderBy = " ORDER BY prm_order_column ASC ";
			} 
			if (property_exists($this, 'prm_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY prm_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoPermission();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoPermission($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_permissions SET prm_virgo_title = '$title' WHERE prm_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoPermission();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" prm_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['prm_id'];
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
			virgoPermission::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoPermission::setSessionValue('Portal_Permission-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoPermission::getSessionValue('Portal_Permission-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoPermission::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoPermission::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoPermission::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoPermission::getSessionValue('GLOBAL', $name, $default);
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
			$context['prm_id'] = $id;
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
			$context['prm_id'] = null;
			virgoPermission::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoPermission::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoPermission::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoPermission::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoPermission::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoPermission::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoPermission::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoPermission::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoPermission::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoPermission::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoPermission::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoPermission::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoPermission::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoPermission::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoPermission::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoPermission::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoPermission::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "prm_id";
			}
			return virgoPermission::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoPermission::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoPermission::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoPermission::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoPermission::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoPermission::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoPermission::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoPermission::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoPermission::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoPermission::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoPermission::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoPermission::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoPermission::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->prm_id) {
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
						L(T('STORED_CORRECTLY', 'PERMISSION'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'view', $this->prm_view);
						$fieldValues = $fieldValues . T($fieldValue, 'edit', $this->prm_edit);
						$fieldValues = $fieldValues . T($fieldValue, 'configure', $this->prm_configure);
						$fieldValues = $fieldValues . T($fieldValue, 'action', $this->prm_action);
						$fieldValues = $fieldValues . T($fieldValue, 'execute', $this->prm_execute);
						$parentRole = new virgoRole();
						$fieldValues = $fieldValues . T($fieldValue, 'role', $parentRole->lookup($this->prm_rle_id));
						$parentPage = new virgoPage();
						$fieldValues = $fieldValues . T($fieldValue, 'page', $parentPage->lookup($this->prm_pge_id));
						$parentPortletObject = new virgoPortletObject();
						$fieldValues = $fieldValues . T($fieldValue, 'portlet object', $parentPortletObject->lookup($this->prm_pob_id));
						$username = '';
						if ($this->prm_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->prm_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->prm_date_created);
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
			$instance = new virgoPermission();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPermission'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			$tmpId = intval(R('prm_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoPermission::getContextId();
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
			$this->prm_id = null;
			$this->prm_date_created = null;
			$this->prm_usr_created_id = null;
			$this->prm_date_modified = null;
			$this->prm_usr_modified_id = null;
			$this->prm_virgo_title = null;
			
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

		static function portletActionShowForRole() {
			$parentId = R('rle_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoRole($parentId);
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
//			$ret = new virgoPermission();
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
				$instance = new virgoPermission();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoPermission::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'PERMISSION'), '', 'INFO');
					return 0;
					
				} else {
					L($res, '', 'ERROR');
					return -1;
				}
			}
		}
		
		
		static function portletActionVirgoSetViewTrue() {
			$this->loadFromDB();
			$this->setView(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetViewFalse() {
			$this->loadFromDB();
			$this->setView(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isView() {
			return $this->getView() == 1;
		}
		static function portletActionVirgoSetEditTrue() {
			$this->loadFromDB();
			$this->setEdit(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetEditFalse() {
			$this->loadFromDB();
			$this->setEdit(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isEdit() {
			return $this->getEdit() == 1;
		}
		static function portletActionVirgoSetConfigureTrue() {
			$this->loadFromDB();
			$this->setConfigure(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetConfigureFalse() {
			$this->loadFromDB();
			$this->setConfigure(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isConfigure() {
			return $this->getConfigure() == 1;
		}
		static function portletActionVirgoSetExecuteTrue() {
			$this->loadFromDB();
			$this->setExecute(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetExecuteFalse() {
			$this->loadFromDB();
			$this->setExecute(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isExecute() {
			return $this->getExecute() == 1;
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
				$resultPermission = new virgoPermission();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultPermission->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultPermission->load($idToEditInt);
					} else {
						$resultPermission->prm_id = 0;
					}
				}
				$results[] = $resultPermission;
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
				$result = new virgoPermission();
				$result->loadFromRequest($idToStore);
				if ($result->prm_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->prm_id == 0) {
						$result->prm_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->prm_id)) {
							$result->prm_id = 0;
						}
						$idsToCorrect[$result->prm_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'PERMISSIONS'), '', 'INFO');
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
			$resultPermission = new virgoPermission();
			foreach ($idsToDelete as $idToDelete) {
				$resultPermission->load((int)trim($idToDelete));
				$res = $resultPermission->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'PERMISSIONS'), '', 'INFO');			
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
		$ret = $this->prm_action;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoPermission');
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
				$query = "UPDATE prt_permissions SET prm_virgo_title = ? WHERE prm_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT prm_id AS id FROM prt_permissions ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoPermission($row['id']);
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
				$class2prefix["portal\\virgoRole"] = "rle";
				$class2prefix2 = array();
				$class2prefix2["portal\\virgoPage"] = "pge";
				$class2parentPrefix["portal\\virgoRole"] = $class2prefix2;
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
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'prt_permissions.prm_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_permissions.prm_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_permissions.prm_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_permissions.prm_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoPermission!', '', 'ERROR');
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
			$pdf->SetTitle('Permissions report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('PERMISSIONS');
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
			if (P('show_pdf_view', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_edit', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_configure', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_action', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_execute', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_role', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_page', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_portlet_object', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultPermission = new virgoPermission();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_view', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'View');
				$minWidth['view'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['view']) {
						$minWidth['view'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_edit', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Edit');
				$minWidth['edit'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['edit']) {
						$minWidth['edit'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_configure', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Configure');
				$minWidth['configure'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['configure']) {
						$minWidth['configure'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_action', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Action');
				$minWidth['action'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['action']) {
						$minWidth['action'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_execute', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Execute');
				$minWidth['execute'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['execute']) {
						$minWidth['execute'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_role', "1") == "1") {
				$minWidth['role $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'role $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['role $relation.name']) {
						$minWidth['role $relation.name'] = min($tmpLen, $maxWidth);
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
			$pdf->SetFont($font, '', $fontSize);
			$pdf->AliasNbPages();
			$orientation = P('pdf_page_orientation', 'P');
			$pdf->AddPage($orientation);
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 4);
			$pdf->MultiCell(0, 1, $reportTitle, '', 'C', 0, 0);
			$pdf->Ln();
			$whereClausePermission = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClausePermission = $whereClausePermission . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaPermission = $resultPermission->getCriteria();
			$fieldCriteriaView = $criteriaPermission["view"];
			if ($fieldCriteriaView["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'View', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaView["value"];
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
					$pdf->MultiCell(60, 100, 'View', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaEdit = $criteriaPermission["edit"];
			if ($fieldCriteriaEdit["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Edit', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaEdit["value"];
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
					$pdf->MultiCell(60, 100, 'Edit', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaConfigure = $criteriaPermission["configure"];
			if ($fieldCriteriaConfigure["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Configure', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaConfigure["value"];
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
					$pdf->MultiCell(60, 100, 'Configure', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaAction = $criteriaPermission["action"];
			if ($fieldCriteriaAction["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Action', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaAction["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Action', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaExecute = $criteriaPermission["execute"];
			if ($fieldCriteriaExecute["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Execute', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaExecute["value"];
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
					$pdf->MultiCell(60, 100, 'Execute', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaPermission["role"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Role', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoRole::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Role', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaPermission["page"];
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
			$parentCriteria = $criteriaPermission["portlet_object"];
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
			$limit = P('limit_to_role');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_permissions.prm_rle_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_permissions.prm_rle_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePermission = $whereClausePermission . " AND ({$inCondition} {$nullCondition} )";
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
					$inCondition = " prt_permissions.prm_pge_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_permissions.prm_pge_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePermission = $whereClausePermission . " AND ({$inCondition} {$nullCondition} )";
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
					$inCondition = " prt_permissions.prm_pob_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_permissions.prm_pob_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePermission = $whereClausePermission . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaPermission = self::getCriteria();
			if (isset($criteriaPermission["view"])) {
				$fieldCriteriaView = $criteriaPermission["view"];
				if ($fieldCriteriaView["is_null"] == 1) {
$filter = $filter . ' AND prt_permissions.prm_view IS NOT NULL ';
				} elseif ($fieldCriteriaView["is_null"] == 2) {
$filter = $filter . ' AND prt_permissions.prm_view IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaView["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_permissions.prm_view = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaPermission["edit"])) {
				$fieldCriteriaEdit = $criteriaPermission["edit"];
				if ($fieldCriteriaEdit["is_null"] == 1) {
$filter = $filter . ' AND prt_permissions.prm_edit IS NOT NULL ';
				} elseif ($fieldCriteriaEdit["is_null"] == 2) {
$filter = $filter . ' AND prt_permissions.prm_edit IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaEdit["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_permissions.prm_edit = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaPermission["configure"])) {
				$fieldCriteriaConfigure = $criteriaPermission["configure"];
				if ($fieldCriteriaConfigure["is_null"] == 1) {
$filter = $filter . ' AND prt_permissions.prm_configure IS NOT NULL ';
				} elseif ($fieldCriteriaConfigure["is_null"] == 2) {
$filter = $filter . ' AND prt_permissions.prm_configure IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaConfigure["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_permissions.prm_configure = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaPermission["action"])) {
				$fieldCriteriaAction = $criteriaPermission["action"];
				if ($fieldCriteriaAction["is_null"] == 1) {
$filter = $filter . ' AND prt_permissions.prm_action IS NOT NULL ';
				} elseif ($fieldCriteriaAction["is_null"] == 2) {
$filter = $filter . ' AND prt_permissions.prm_action IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaAction["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_permissions.prm_action like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPermission["execute"])) {
				$fieldCriteriaExecute = $criteriaPermission["execute"];
				if ($fieldCriteriaExecute["is_null"] == 1) {
$filter = $filter . ' AND prt_permissions.prm_execute IS NOT NULL ';
				} elseif ($fieldCriteriaExecute["is_null"] == 2) {
$filter = $filter . ' AND prt_permissions.prm_execute IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaExecute["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_permissions.prm_execute = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaPermission["role"])) {
				$parentCriteria = $criteriaPermission["role"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND prm_rle_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND prt_permissions.prm_rle_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			if (isset($criteriaPermission["page"])) {
				$parentCriteria = $criteriaPermission["page"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND prm_pge_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_permissions.prm_pge_id IN (SELECT pge_id FROM prt_pages WHERE pge_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPermission["portlet_object"])) {
				$parentCriteria = $criteriaPermission["portlet_object"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND prm_pob_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_permissions.prm_pob_id IN (SELECT pob_id FROM prt_portlet_objects WHERE pob_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClausePermission = $whereClausePermission . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClausePermission = $whereClausePermission . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_permissions.prm_id, prt_permissions.prm_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_view', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_view prm_view";
			} else {
				if ($defaultOrderColumn == "prm_view") {
					$orderColumnNotDisplayed = " prt_permissions.prm_view ";
				}
			}
			if (P('show_pdf_edit', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_edit prm_edit";
			} else {
				if ($defaultOrderColumn == "prm_edit") {
					$orderColumnNotDisplayed = " prt_permissions.prm_edit ";
				}
			}
			if (P('show_pdf_configure', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_configure prm_configure";
			} else {
				if ($defaultOrderColumn == "prm_configure") {
					$orderColumnNotDisplayed = " prt_permissions.prm_configure ";
				}
			}
			if (P('show_pdf_action', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_action prm_action";
			} else {
				if ($defaultOrderColumn == "prm_action") {
					$orderColumnNotDisplayed = " prt_permissions.prm_action ";
				}
			}
			if (P('show_pdf_execute', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_execute prm_execute";
			} else {
				if ($defaultOrderColumn == "prm_execute") {
					$orderColumnNotDisplayed = " prt_permissions.prm_execute ";
				}
			}
			if (class_exists('portal\virgoRole') && P('show_pdf_role', "1") != "0") { // */ && !in_array("rle", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_permissions.prm_rle_id as prm_rle_id ";
				$queryString = $queryString . ", prt_roles_parent.rle_virgo_title as `role` ";
			} else {
				if ($defaultOrderColumn == "role") {
					$orderColumnNotDisplayed = " prt_roles_parent.rle_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_pdf_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_permissions.prm_pge_id as prm_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_pdf_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_permissions.prm_pob_id as prm_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_permissions ";
			if (class_exists('portal\virgoRole')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_roles AS prt_roles_parent ON (prt_permissions.prm_rle_id = prt_roles_parent.rle_id) ";
			}
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_permissions.prm_pge_id = prt_pages_parent.pge_id) ";
			}
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_permissions.prm_pob_id = prt_portlet_objects_parent.pob_id) ";
			}

		$resultsPermission = $resultPermission->select(
			'', 
			'all', 
			$resultPermission->getOrderColumn(), 
			$resultPermission->getOrderMode(), 
			$whereClausePermission,
			$queryString);
		
		foreach ($resultsPermission as $resultPermission) {

			if (P('show_pdf_view', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPermission['prm_view'])) + 6;
				if ($tmpLen > $minWidth['view']) {
					$minWidth['view'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_edit', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPermission['prm_edit'])) + 6;
				if ($tmpLen > $minWidth['edit']) {
					$minWidth['edit'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_configure', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPermission['prm_configure'])) + 6;
				if ($tmpLen > $minWidth['configure']) {
					$minWidth['configure'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_action', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPermission['prm_action'])) + 6;
				if ($tmpLen > $minWidth['action']) {
					$minWidth['action'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_execute', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPermission['prm_execute'])) + 6;
				if ($tmpLen > $minWidth['execute']) {
					$minWidth['execute'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_role', "1") == "1") {
			$parentValue = trim(virgoRole::lookup($resultPermission['prmrle__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['role $relation.name']) {
					$minWidth['role $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_page', "1") == "1") {
			$parentValue = trim(virgoPage::lookup($resultPermission['prmpge__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['page $relation.name']) {
					$minWidth['page $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_portlet_object', "1") == "1") {
			$parentValue = trim(virgoPortletObject::lookup($resultPermission['prmpob__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['portlet object $relation.name']) {
					$minWidth['portlet object $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaPermission = $resultPermission->getCriteria();
		if (is_null($criteriaPermission) || sizeof($criteriaPermission) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																																													if (P('show_pdf_role', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['role $relation.name'], $colHeight, T('ROLE') . ' ' . T(''), 'T', 'C', 0, 0); 
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
			if (P('show_pdf_portlet_object', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['portlet object $relation.name'], $colHeight, T('PORTLET_OBJECT') . ' ' . T(''), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_view', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['view'], $colHeight, T('VIEW'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_edit', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['edit'], $colHeight, T('EDIT'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_configure', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['configure'], $colHeight, T('CONFIGURE'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_action', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['action'], $colHeight, T('ACTION'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_execute', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['execute'], $colHeight, T('EXECUTE'), 'T', 'C', 0, 0);
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
		foreach ($resultsPermission as $resultPermission) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_role', "1") == "1") {
			$parentValue = virgoRole::lookup($resultPermission['prm_rle_id']);
			$tmpLn = $pdf->MultiCell($minWidth['role $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_page', "1") == "1") {
			$parentValue = virgoPage::lookup($resultPermission['prm_pge_id']);
			$tmpLn = $pdf->MultiCell($minWidth['page $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_portlet_object', "1") == "1") {
			$parentValue = virgoPortletObject::lookup($resultPermission['prm_pob_id']);
			$tmpLn = $pdf->MultiCell($minWidth['portlet object $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_view', "0") != "0") {
			$renderCriteria = "";
			switch ($resultPermission['prm_view']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['view'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_view', "1") == "2") {
										if (!is_null($resultPermission['prm_view'])) {
						$tmpCount = (float)$counts["view"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["view"] = $tmpCount;
					}
				}
				if (P('show_pdf_view', "1") == "3") {
										if (!is_null($resultPermission['prm_view'])) {
						$tmpSum = (float)$sums["view"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPermission['prm_view'];
						}
						$sums["view"] = $tmpSum;
					}
				}
				if (P('show_pdf_view', "1") == "4") {
										if (!is_null($resultPermission['prm_view'])) {
						$tmpCount = (float)$avgCounts["view"];
						$tmpSum = (float)$avgSums["view"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["view"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPermission['prm_view'];
						}
						$avgSums["view"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_edit', "0") != "0") {
			$renderCriteria = "";
			switch ($resultPermission['prm_edit']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['edit'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_edit', "1") == "2") {
										if (!is_null($resultPermission['prm_edit'])) {
						$tmpCount = (float)$counts["edit"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["edit"] = $tmpCount;
					}
				}
				if (P('show_pdf_edit', "1") == "3") {
										if (!is_null($resultPermission['prm_edit'])) {
						$tmpSum = (float)$sums["edit"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPermission['prm_edit'];
						}
						$sums["edit"] = $tmpSum;
					}
				}
				if (P('show_pdf_edit', "1") == "4") {
										if (!is_null($resultPermission['prm_edit'])) {
						$tmpCount = (float)$avgCounts["edit"];
						$tmpSum = (float)$avgSums["edit"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["edit"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPermission['prm_edit'];
						}
						$avgSums["edit"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_configure', "0") != "0") {
			$renderCriteria = "";
			switch ($resultPermission['prm_configure']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['configure'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_configure', "1") == "2") {
										if (!is_null($resultPermission['prm_configure'])) {
						$tmpCount = (float)$counts["configure"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["configure"] = $tmpCount;
					}
				}
				if (P('show_pdf_configure', "1") == "3") {
										if (!is_null($resultPermission['prm_configure'])) {
						$tmpSum = (float)$sums["configure"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPermission['prm_configure'];
						}
						$sums["configure"] = $tmpSum;
					}
				}
				if (P('show_pdf_configure', "1") == "4") {
										if (!is_null($resultPermission['prm_configure'])) {
						$tmpCount = (float)$avgCounts["configure"];
						$tmpSum = (float)$avgSums["configure"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["configure"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPermission['prm_configure'];
						}
						$avgSums["configure"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_action', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['action'], $colHeight, '' . $resultPermission['prm_action'], 'T', 'L', 0, 0);
				if (P('show_pdf_action', "1") == "2") {
										if (!is_null($resultPermission['prm_action'])) {
						$tmpCount = (float)$counts["action"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["action"] = $tmpCount;
					}
				}
				if (P('show_pdf_action', "1") == "3") {
										if (!is_null($resultPermission['prm_action'])) {
						$tmpSum = (float)$sums["action"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPermission['prm_action'];
						}
						$sums["action"] = $tmpSum;
					}
				}
				if (P('show_pdf_action', "1") == "4") {
										if (!is_null($resultPermission['prm_action'])) {
						$tmpCount = (float)$avgCounts["action"];
						$tmpSum = (float)$avgSums["action"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["action"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPermission['prm_action'];
						}
						$avgSums["action"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_execute', "0") != "0") {
			$renderCriteria = "";
			switch ($resultPermission['prm_execute']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['execute'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_execute', "1") == "2") {
										if (!is_null($resultPermission['prm_execute'])) {
						$tmpCount = (float)$counts["execute"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["execute"] = $tmpCount;
					}
				}
				if (P('show_pdf_execute', "1") == "3") {
										if (!is_null($resultPermission['prm_execute'])) {
						$tmpSum = (float)$sums["execute"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPermission['prm_execute'];
						}
						$sums["execute"] = $tmpSum;
					}
				}
				if (P('show_pdf_execute', "1") == "4") {
										if (!is_null($resultPermission['prm_execute'])) {
						$tmpCount = (float)$avgCounts["execute"];
						$tmpSum = (float)$avgSums["execute"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["execute"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPermission['prm_execute'];
						}
						$avgSums["execute"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
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
			if (P('show_pdf_view', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['view'];
				if (P('show_pdf_view', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["view"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_edit', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['edit'];
				if (P('show_pdf_edit', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["edit"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_configure', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['configure'];
				if (P('show_pdf_configure', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["configure"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_action', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['action'];
				if (P('show_pdf_action', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["action"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_execute', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['execute'];
				if (P('show_pdf_execute', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["execute"];
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
			if (P('show_pdf_view', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['view'];
				if (P('show_pdf_view', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["view"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_edit', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['edit'];
				if (P('show_pdf_edit', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["edit"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_configure', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['configure'];
				if (P('show_pdf_configure', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["configure"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_action', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['action'];
				if (P('show_pdf_action', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["action"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_execute', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['execute'];
				if (P('show_pdf_execute', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["execute"], 2, ',', ' ');
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
			if (P('show_pdf_view', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['view'];
				if (P('show_pdf_view', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["view"] == 0 ? "-" : $avgSums["view"] / $avgCounts["view"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_edit', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['edit'];
				if (P('show_pdf_edit', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["edit"] == 0 ? "-" : $avgSums["edit"] / $avgCounts["edit"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_configure', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['configure'];
				if (P('show_pdf_configure', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["configure"] == 0 ? "-" : $avgSums["configure"] / $avgCounts["configure"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_action', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['action'];
				if (P('show_pdf_action', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["action"] == 0 ? "-" : $avgSums["action"] / $avgCounts["action"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_execute', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['execute'];
				if (P('show_pdf_execute', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["execute"] == 0 ? "-" : $avgSums["execute"] / $avgCounts["execute"]);
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
				$reportTitle = T('PERMISSIONS');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultPermission = new virgoPermission();
			$whereClausePermission = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePermission = $whereClausePermission . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_view', "1") != "0") {
					$data = $data . $stringDelimeter .'View' . $stringDelimeter . $separator;
				}
				if (P('show_export_edit', "1") != "0") {
					$data = $data . $stringDelimeter .'Edit' . $stringDelimeter . $separator;
				}
				if (P('show_export_configure', "1") != "0") {
					$data = $data . $stringDelimeter .'Configure' . $stringDelimeter . $separator;
				}
				if (P('show_export_action', "1") != "0") {
					$data = $data . $stringDelimeter .'Action' . $stringDelimeter . $separator;
				}
				if (P('show_export_execute', "1") != "0") {
					$data = $data . $stringDelimeter .'Execute' . $stringDelimeter . $separator;
				}
				if (P('show_export_role', "1") != "0") {
					$data = $data . $stringDelimeter . 'Role ' . $stringDelimeter . $separator;
				}
				if (P('show_export_page', "1") != "0") {
					$data = $data . $stringDelimeter . 'Page ' . $stringDelimeter . $separator;
				}
				if (P('show_export_portlet_object', "1") != "0") {
					$data = $data . $stringDelimeter . 'Portlet object ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_permissions.prm_id, prt_permissions.prm_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_view', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_view prm_view";
			} else {
				if ($defaultOrderColumn == "prm_view") {
					$orderColumnNotDisplayed = " prt_permissions.prm_view ";
				}
			}
			if (P('show_export_edit', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_edit prm_edit";
			} else {
				if ($defaultOrderColumn == "prm_edit") {
					$orderColumnNotDisplayed = " prt_permissions.prm_edit ";
				}
			}
			if (P('show_export_configure', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_configure prm_configure";
			} else {
				if ($defaultOrderColumn == "prm_configure") {
					$orderColumnNotDisplayed = " prt_permissions.prm_configure ";
				}
			}
			if (P('show_export_action', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_action prm_action";
			} else {
				if ($defaultOrderColumn == "prm_action") {
					$orderColumnNotDisplayed = " prt_permissions.prm_action ";
				}
			}
			if (P('show_export_execute', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_execute prm_execute";
			} else {
				if ($defaultOrderColumn == "prm_execute") {
					$orderColumnNotDisplayed = " prt_permissions.prm_execute ";
				}
			}
			if (class_exists('portal\virgoRole') && P('show_export_role', "1") != "0") { // */ && !in_array("rle", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_permissions.prm_rle_id as prm_rle_id ";
				$queryString = $queryString . ", prt_roles_parent.rle_virgo_title as `role` ";
			} else {
				if ($defaultOrderColumn == "role") {
					$orderColumnNotDisplayed = " prt_roles_parent.rle_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_export_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_permissions.prm_pge_id as prm_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_export_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_permissions.prm_pob_id as prm_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_permissions ";
			if (class_exists('portal\virgoRole')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_roles AS prt_roles_parent ON (prt_permissions.prm_rle_id = prt_roles_parent.rle_id) ";
			}
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_permissions.prm_pge_id = prt_pages_parent.pge_id) ";
			}
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_permissions.prm_pob_id = prt_portlet_objects_parent.pob_id) ";
			}

			$resultsPermission = $resultPermission->select(
				'', 
				'all', 
				$resultPermission->getOrderColumn(), 
				$resultPermission->getOrderMode(), 
				$whereClausePermission,
				$queryString);
			foreach ($resultsPermission as $resultPermission) {
				if (P('show_export_view', "1") != "0") {
			$data = $data . $resultPermission['prm_view'] . $separator;
				}
				if (P('show_export_edit', "1") != "0") {
			$data = $data . $resultPermission['prm_edit'] . $separator;
				}
				if (P('show_export_configure', "1") != "0") {
			$data = $data . $resultPermission['prm_configure'] . $separator;
				}
				if (P('show_export_action', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPermission['prm_action'] . $stringDelimeter . $separator;
				}
				if (P('show_export_execute', "1") != "0") {
			$data = $data . $resultPermission['prm_execute'] . $separator;
				}
				if (P('show_export_role', "1") != "0") {
					$parentValue = virgoRole::lookup($resultPermission['prm_rle_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_page', "1") != "0") {
					$parentValue = virgoPage::lookup($resultPermission['prm_pge_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_portlet_object', "1") != "0") {
					$parentValue = virgoPortletObject::lookup($resultPermission['prm_pob_id']);
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
				$reportTitle = T('PERMISSIONS');
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
			$resultPermission = new virgoPermission();
			$whereClausePermission = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePermission = $whereClausePermission . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_view', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'View');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_edit', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Edit');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_configure', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Configure');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_action', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Action');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_execute', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Execute');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_role', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Role ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoRole::getVirgoList();
					$formulaRole = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaRole != "") {
							$formulaRole = $formulaRole . ',';
						}
						$formulaRole = $formulaRole . $key;
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
			$queryString = " SELECT prt_permissions.prm_id, prt_permissions.prm_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_view', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_view prm_view";
			} else {
				if ($defaultOrderColumn == "prm_view") {
					$orderColumnNotDisplayed = " prt_permissions.prm_view ";
				}
			}
			if (P('show_export_edit', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_edit prm_edit";
			} else {
				if ($defaultOrderColumn == "prm_edit") {
					$orderColumnNotDisplayed = " prt_permissions.prm_edit ";
				}
			}
			if (P('show_export_configure', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_configure prm_configure";
			} else {
				if ($defaultOrderColumn == "prm_configure") {
					$orderColumnNotDisplayed = " prt_permissions.prm_configure ";
				}
			}
			if (P('show_export_action', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_action prm_action";
			} else {
				if ($defaultOrderColumn == "prm_action") {
					$orderColumnNotDisplayed = " prt_permissions.prm_action ";
				}
			}
			if (P('show_export_execute', "1") != "0") {
				$queryString = $queryString . ", prt_permissions.prm_execute prm_execute";
			} else {
				if ($defaultOrderColumn == "prm_execute") {
					$orderColumnNotDisplayed = " prt_permissions.prm_execute ";
				}
			}
			if (class_exists('portal\virgoRole') && P('show_export_role', "1") != "0") { // */ && !in_array("rle", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_permissions.prm_rle_id as prm_rle_id ";
				$queryString = $queryString . ", prt_roles_parent.rle_virgo_title as `role` ";
			} else {
				if ($defaultOrderColumn == "role") {
					$orderColumnNotDisplayed = " prt_roles_parent.rle_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_export_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_permissions.prm_pge_id as prm_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_export_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_permissions.prm_pob_id as prm_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_permissions ";
			if (class_exists('portal\virgoRole')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_roles AS prt_roles_parent ON (prt_permissions.prm_rle_id = prt_roles_parent.rle_id) ";
			}
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_permissions.prm_pge_id = prt_pages_parent.pge_id) ";
			}
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_permissions.prm_pob_id = prt_portlet_objects_parent.pob_id) ";
			}

			$resultsPermission = $resultPermission->select(
				'', 
				'all', 
				$resultPermission->getOrderColumn(), 
				$resultPermission->getOrderMode(), 
				$whereClausePermission,
				$queryString);
			$index = 1;
			foreach ($resultsPermission as $resultPermission) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultPermission['prm_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_view', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPermission['prm_view'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_edit', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPermission['prm_edit'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_configure', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPermission['prm_configure'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_action', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPermission['prm_action'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_execute', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPermission['prm_execute'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_role', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoRole::lookup($resultPermission['prm_rle_id']);
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
					$objValidation->setFormula1('"' . $formulaRole . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
				if (P('show_export_page', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoPage::lookup($resultPermission['prm_pge_id']);
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
					$parentValue = virgoPortletObject::lookup($resultPermission['prm_pob_id']);
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
					$propertyColumnHash['view'] = 'prm_view';
					$propertyColumnHash['view'] = 'prm_view';
					$propertyColumnHash['edit'] = 'prm_edit';
					$propertyColumnHash['edit'] = 'prm_edit';
					$propertyColumnHash['configure'] = 'prm_configure';
					$propertyColumnHash['configure'] = 'prm_configure';
					$propertyColumnHash['action'] = 'prm_action';
					$propertyColumnHash['action'] = 'prm_action';
					$propertyColumnHash['execute'] = 'prm_execute';
					$propertyColumnHash['execute'] = 'prm_execute';
					$propertyClassHash['role'] = 'Role';
					$propertyClassHash['role'] = 'Role';
					$propertyColumnHash['role'] = 'prm_rle_id';
					$propertyColumnHash['role'] = 'prm_rle_id';
					$propertyClassHash['page'] = 'Page';
					$propertyClassHash['page'] = 'Page';
					$propertyColumnHash['page'] = 'prm_pge_id';
					$propertyColumnHash['page'] = 'prm_pge_id';
					$propertyClassHash['portlet object'] = 'PortletObject';
					$propertyClassHash['portlet_object'] = 'PortletObject';
					$propertyColumnHash['portlet object'] = 'prm_pob_id';
					$propertyColumnHash['portlet_object'] = 'prm_pob_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importPermission = new virgoPermission();
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
										L(T('PROPERTY_NOT_FOUND', T('PERMISSION'), $columns[$index]), '', 'ERROR');
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
										$importPermission->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_role');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoRole::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoRole::token2Id($tmpToken);
	}
	$importPermission->setRleId($defaultValue);
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
	$importPermission->setPgeId($defaultValue);
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
	$importPermission->setPobId($defaultValue);
}
							$errorMessage = $importPermission->store();
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
		

		static function portletActionVirgoChangeRole() {
			$instance = new virgoPermission();
			$instance->loadFromDB();
			self::portletActionSelect(true, $instance->getId());
			$parentId = R('virgo_parent_id');
			$parent = virgoRole::getById($parentId);
			$title = $parent->getVirgoTitle();
			if (!is_null($title) && trim($title) != "") {
				$instance->setRleId($parentId);
				$errorMessage = $instance->store();
				if ($errorMessage == "") {
					L(T('PARENT_SET', T('ROLE'), $title), '', 'INFO');
					return 0;
				} else {
					L($errorMessage, '', 'ERROR');
					return -1;
				}
			} else {
				L("$messages.PARENT_NOT_FOUND", '', 'ERROR');
				return -1;
			}
		}



		static function portletActionVirgoSetRole() {
			$this->loadFromDB();
			$parentId = R('prm_Role_id_' . $_SESSION['current_portlet_object_id']);
			$this->setRleId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetPage() {
			$this->loadFromDB();
			$parentId = R('prm_Page_id_' . $_SESSION['current_portlet_object_id']);
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
			$parentId = R('prm_PortletObject_id_' . $_SESSION['current_portlet_object_id']);
			$this->setPobId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
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
CREATE TABLE IF NOT EXISTS `prt_permissions` (
  `prm_id` bigint(20) unsigned NOT NULL auto_increment,
  `prm_virgo_state` varchar(50) default NULL,
  `prm_virgo_title` varchar(255) default NULL,
	`prm_rle_id` int(11) default NULL,
	`prm_pge_id` int(11) default NULL,
	`prm_pob_id` int(11) default NULL,
  `prm_view` boolean,  
  `prm_edit` boolean,  
  `prm_configure` boolean,  
  `prm_action` varchar(255), 
  `prm_execute` boolean,  
  `prm_date_created` datetime NOT NULL,
  `prm_date_modified` datetime default NULL,
  `prm_usr_created_id` int(11) NOT NULL,
  `prm_usr_modified_id` int(11) default NULL,
  KEY `prm_rle_fk` (`prm_rle_id`),
  KEY `prm_pge_fk` (`prm_pge_id`),
  KEY `prm_pob_fk` (`prm_pob_id`),
  PRIMARY KEY  (`prm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/permission.sql 
INSERT INTO `prt_permissions` (`prm_virgo_title`, `prm_view`, `prm_edit`, `prm_configure`, `prm_action`, `prm_execute`) 
VALUES (title, some_value, some_value, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_permissions table already exists.", '', 'FATAL');
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
			return "prm";
		}
		
		static function getPlural() {
			return "permissions";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoRole";
			$ret[] = "virgoPage";
			$ret[] = "virgoPortletObject";
			return $ret;
		}

		static function getChildren() {
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_permissions'));
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
			$virgoVersion = virgoPermission::getVirgoVersion();
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
	
	

