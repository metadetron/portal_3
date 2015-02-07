<?php
/**
* Module Portal
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
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletParameter'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletLocation'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoPortal {

		 var  $prt_id = null;
		 var  $prt_name = null;

		 var  $prt_url = null;

		 var  $prt_identifier = null;

		 var  $prt_path = null;

		 var  $prt_tolerant_access_policy = null;

		 var  $prt_user_class_namespace = null;

		 var  $prt_user_class_name = null;

		 var  $prt_tmp_id = null;

		 var   $_pageIdsToAddArray = null;
		 var   $_pageIdsToDeleteArray = null;
		 var   $prt_date_created = null;
		 var   $prt_usr_created_id = null;
		 var   $prt_date_modified = null;
		 var   $prt_usr_modified_id = null;
		 var   $prt_virgo_title = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoPortal();
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
        	$this->prt_id = null;
		    $this->prt_date_created = null;
		    $this->prt_usr_created_id = null;
		    $this->prt_date_modified = null;
		    $this->prt_usr_modified_id = null;
		    $this->prt_virgo_title = null;
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
			return $this->prt_id;
		}

		function getName() {
			return $this->prt_name;
		}
		
		 function setName($val) {
			$this->prt_name = $val;
		}
		function getUrl() {
			return $this->prt_url;
		}
		
		 function setUrl($val) {
			$this->prt_url = $val;
		}
		function getIdentifier() {
			return $this->prt_identifier;
		}
		
		 function setIdentifier($val) {
			$this->prt_identifier = $val;
		}
		function getPath() {
			return $this->prt_path;
		}
		
		 function setPath($val) {
			$this->prt_path = $val;
		}
		function getTolerantAccessPolicy() {
			return $this->prt_tolerant_access_policy;
		}
		
		 function setTolerantAccessPolicy($val) {
			$this->prt_tolerant_access_policy = $val;
		}
		function getUserClassNamespace() {
			return $this->prt_user_class_namespace;
		}
		
		 function setUserClassNamespace($val) {
			$this->prt_user_class_namespace = $val;
		}
		function getUserClassName() {
			return $this->prt_user_class_name;
		}
		
		 function setUserClassName($val) {
			$this->prt_user_class_name = $val;
		}

		function getTemplateId() {
			return $this->prt_tmp_id;
		}
		
		 function setTemplateId($val) {
			$this->prt_tmp_id = $val;
		}

		function getDateCreated() {
			return $this->prt_date_created;
		}
		function getUsrCreatedId() {
			return $this->prt_usr_created_id;
		}
		function getDateModified() {
			return $this->prt_date_modified;
		}
		function getUsrModifiedId() {
			return $this->prt_usr_modified_id;
		}


		function getTmpId() {
			return $this->getTemplateId();
		}
		
		 function setTmpId($val) {
			$this->setTemplateId($val);
		}

		function loadRecordFromRequest($rowId) {
			$this->prt_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('prt_name_' . $this->prt_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->prt_name = null;
		} else {
			$this->prt_name = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('prt_url_' . $this->prt_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->prt_url = null;
		} else {
			$this->prt_url = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('prt_identifier_' . $this->prt_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->prt_identifier = null;
		} else {
			$this->prt_identifier = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('prt_path_' . $this->prt_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->prt_path = null;
		} else {
			$this->prt_path = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('prt_tolerantAccessPolicy_' . $this->prt_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->prt_tolerant_access_policy = null;
		} else {
			$this->prt_tolerant_access_policy = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('prt_userClassNamespace_' . $this->prt_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->prt_user_class_namespace = null;
		} else {
			$this->prt_user_class_namespace = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('prt_userClassName_' . $this->prt_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->prt_user_class_name = null;
		} else {
			$this->prt_user_class_name = $tmpValue;
		}
	}
			$this->prt_tmp_id = strval(R('prt_template_' . $this->prt_id));
			$tmp_ids = R('prt_portletLocation_' . $this->prt_id, null); 			if (is_null($tmp_ids)) {
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
				$rowId = R('prt_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaPortal = array();	
			$criteriaFieldPortal = array();	
			$isNullPortal = R('virgo_search_name_is_null');
			
			$criteriaFieldPortal["is_null"] = 0;
			if ($isNullPortal == "not_null") {
				$criteriaFieldPortal["is_null"] = 1;
			} elseif ($isNullPortal == "null") {
				$criteriaFieldPortal["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_name');

//			if ($isSet) {
			$criteriaFieldPortal["value"] = $dataTypeCriteria;
//			}
			$criteriaPortal["name"] = $criteriaFieldPortal;
			$criteriaFieldPortal = array();	
			$isNullPortal = R('virgo_search_url_is_null');
			
			$criteriaFieldPortal["is_null"] = 0;
			if ($isNullPortal == "not_null") {
				$criteriaFieldPortal["is_null"] = 1;
			} elseif ($isNullPortal == "null") {
				$criteriaFieldPortal["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_url');

//			if ($isSet) {
			$criteriaFieldPortal["value"] = $dataTypeCriteria;
//			}
			$criteriaPortal["url"] = $criteriaFieldPortal;
			$criteriaFieldPortal = array();	
			$isNullPortal = R('virgo_search_identifier_is_null');
			
			$criteriaFieldPortal["is_null"] = 0;
			if ($isNullPortal == "not_null") {
				$criteriaFieldPortal["is_null"] = 1;
			} elseif ($isNullPortal == "null") {
				$criteriaFieldPortal["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_identifier');

//			if ($isSet) {
			$criteriaFieldPortal["value"] = $dataTypeCriteria;
//			}
			$criteriaPortal["identifier"] = $criteriaFieldPortal;
			$criteriaFieldPortal = array();	
			$isNullPortal = R('virgo_search_path_is_null');
			
			$criteriaFieldPortal["is_null"] = 0;
			if ($isNullPortal == "not_null") {
				$criteriaFieldPortal["is_null"] = 1;
			} elseif ($isNullPortal == "null") {
				$criteriaFieldPortal["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_path');

//			if ($isSet) {
			$criteriaFieldPortal["value"] = $dataTypeCriteria;
//			}
			$criteriaPortal["path"] = $criteriaFieldPortal;
			$criteriaFieldPortal = array();	
			$isNullPortal = R('virgo_search_tolerantAccessPolicy_is_null');
			
			$criteriaFieldPortal["is_null"] = 0;
			if ($isNullPortal == "not_null") {
				$criteriaFieldPortal["is_null"] = 1;
			} elseif ($isNullPortal == "null") {
				$criteriaFieldPortal["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_tolerantAccessPolicy');

//			if ($isSet) {
			$criteriaFieldPortal["value"] = $dataTypeCriteria;
//			}
			$criteriaPortal["tolerant_access_policy"] = $criteriaFieldPortal;
			$criteriaFieldPortal = array();	
			$isNullPortal = R('virgo_search_userClassNamespace_is_null');
			
			$criteriaFieldPortal["is_null"] = 0;
			if ($isNullPortal == "not_null") {
				$criteriaFieldPortal["is_null"] = 1;
			} elseif ($isNullPortal == "null") {
				$criteriaFieldPortal["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_userClassNamespace');

//			if ($isSet) {
			$criteriaFieldPortal["value"] = $dataTypeCriteria;
//			}
			$criteriaPortal["user_class_namespace"] = $criteriaFieldPortal;
			$criteriaFieldPortal = array();	
			$isNullPortal = R('virgo_search_userClassName_is_null');
			
			$criteriaFieldPortal["is_null"] = 0;
			if ($isNullPortal == "not_null") {
				$criteriaFieldPortal["is_null"] = 1;
			} elseif ($isNullPortal == "null") {
				$criteriaFieldPortal["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_userClassName');

//			if ($isSet) {
			$criteriaFieldPortal["value"] = $dataTypeCriteria;
//			}
			$criteriaPortal["user_class_name"] = $criteriaFieldPortal;
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
			$criteriaPortal["template"] = $criteriaParent;
			$parent = R('virgo_search_page', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
				$criteriaPortal["page"] = $criteriaParent;
			}
			self::setCriteria($criteriaPortal);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_name');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterName', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterName', null);
			}
			$tableFilter = R('virgo_filter_url');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterUrl', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterUrl', null);
			}
			$tableFilter = R('virgo_filter_identifier');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterIdentifier', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterIdentifier', null);
			}
			$tableFilter = R('virgo_filter_path');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterPath', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterPath', null);
			}
			$tableFilter = R('virgo_filter_tolerant_access_policy');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterTolerantAccessPolicy', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTolerantAccessPolicy', null);
			}
			$tableFilter = R('virgo_filter_user_class_namespace');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterUserClassNamespace', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterUserClassNamespace', null);
			}
			$tableFilter = R('virgo_filter_user_class_name');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterUserClassName', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterUserClassName', null);
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
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClausePortal = ' 1 = 1 ';
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
				$eventColumn = "prt_" . P('event_column');
				$whereClausePortal = $whereClausePortal . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePortal = $whereClausePortal . ' AND ' . $parentContextInfo['condition'];
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
					$inCondition = " prt_portals.prt_tmp_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portals.prt_tmp_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortal = $whereClausePortal . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaPortal = self::getCriteria();
			if (isset($criteriaPortal["name"])) {
				$fieldCriteriaName = $criteriaPortal["name"];
				if ($fieldCriteriaName["is_null"] == 1) {
$filter = $filter . ' AND prt_portals.prt_name IS NOT NULL ';
				} elseif ($fieldCriteriaName["is_null"] == 2) {
$filter = $filter . ' AND prt_portals.prt_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portals.prt_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortal["url"])) {
				$fieldCriteriaUrl = $criteriaPortal["url"];
				if ($fieldCriteriaUrl["is_null"] == 1) {
$filter = $filter . ' AND prt_portals.prt_url IS NOT NULL ';
				} elseif ($fieldCriteriaUrl["is_null"] == 2) {
$filter = $filter . ' AND prt_portals.prt_url IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaUrl["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portals.prt_url like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortal["identifier"])) {
				$fieldCriteriaIdentifier = $criteriaPortal["identifier"];
				if ($fieldCriteriaIdentifier["is_null"] == 1) {
$filter = $filter . ' AND prt_portals.prt_identifier IS NOT NULL ';
				} elseif ($fieldCriteriaIdentifier["is_null"] == 2) {
$filter = $filter . ' AND prt_portals.prt_identifier IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaIdentifier["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portals.prt_identifier like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortal["path"])) {
				$fieldCriteriaPath = $criteriaPortal["path"];
				if ($fieldCriteriaPath["is_null"] == 1) {
$filter = $filter . ' AND prt_portals.prt_path IS NOT NULL ';
				} elseif ($fieldCriteriaPath["is_null"] == 2) {
$filter = $filter . ' AND prt_portals.prt_path IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaPath["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portals.prt_path like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortal["tolerant_access_policy"])) {
				$fieldCriteriaTolerantAccessPolicy = $criteriaPortal["tolerant_access_policy"];
				if ($fieldCriteriaTolerantAccessPolicy["is_null"] == 1) {
$filter = $filter . ' AND prt_portals.prt_tolerant_access_policy IS NOT NULL ';
				} elseif ($fieldCriteriaTolerantAccessPolicy["is_null"] == 2) {
$filter = $filter . ' AND prt_portals.prt_tolerant_access_policy IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaTolerantAccessPolicy["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_portals.prt_tolerant_access_policy = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaPortal["user_class_namespace"])) {
				$fieldCriteriaUserClassNamespace = $criteriaPortal["user_class_namespace"];
				if ($fieldCriteriaUserClassNamespace["is_null"] == 1) {
$filter = $filter . ' AND prt_portals.prt_user_class_namespace IS NOT NULL ';
				} elseif ($fieldCriteriaUserClassNamespace["is_null"] == 2) {
$filter = $filter . ' AND prt_portals.prt_user_class_namespace IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaUserClassNamespace["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portals.prt_user_class_namespace like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortal["user_class_name"])) {
				$fieldCriteriaUserClassName = $criteriaPortal["user_class_name"];
				if ($fieldCriteriaUserClassName["is_null"] == 1) {
$filter = $filter . ' AND prt_portals.prt_user_class_name IS NOT NULL ';
				} elseif ($fieldCriteriaUserClassName["is_null"] == 2) {
$filter = $filter . ' AND prt_portals.prt_user_class_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaUserClassName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portals.prt_user_class_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortal["template"])) {
				$parentCriteria = $criteriaPortal["template"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND prt_tmp_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portals.prt_tmp_id IN (SELECT tmp_id FROM prt_templates WHERE tmp_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPortal["page"])) {
				$parentCriteria = $criteriaPortal["page"];
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$filter = $filter . " AND prt_portals.prt_id IN (SELECT second_parent.plc_prt_id FROM prt_portlet_locations AS second_parent WHERE second_parent.plc_pge_id IN (" . implode(", ", $parentIds) . ")) ";
				}
			}
			$whereClausePortal = $whereClausePortal . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClausePortal = $whereClausePortal . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClausePortal = $whereClausePortal . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterName', null);
				if (S($tableFilter)) {
					$whereClausePortal = $whereClausePortal . " AND prt_name LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterUrl', null);
				if (S($tableFilter)) {
					$whereClausePortal = $whereClausePortal . " AND prt_url LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterIdentifier', null);
				if (S($tableFilter)) {
					$whereClausePortal = $whereClausePortal . " AND prt_identifier LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterPath', null);
				if (S($tableFilter)) {
					$whereClausePortal = $whereClausePortal . " AND prt_path LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterTolerantAccessPolicy', null);
				if (S($tableFilter)) {
					$whereClausePortal = $whereClausePortal . " AND prt_tolerant_access_policy LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterUserClassNamespace', null);
				if (S($tableFilter)) {
					$whereClausePortal = $whereClausePortal . " AND prt_user_class_namespace LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterUserClassName', null);
				if (S($tableFilter)) {
					$whereClausePortal = $whereClausePortal . " AND prt_user_class_name LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTemplate', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePortal = $whereClausePortal . " AND prt_tmp_id IS NULL ";
					} else {
						$whereClausePortal = $whereClausePortal . " AND prt_tmp_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleTemplate', null);
				if (S($parentFilter)) {
					$whereClausePortal = $whereClausePortal . " AND prt_templates_parent.tmp_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClausePortal;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClausePortal = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_portals.prt_id, prt_portals.prt_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_name', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_name prt_name";
			} else {
				if ($defaultOrderColumn == "prt_name") {
					$orderColumnNotDisplayed = " prt_portals.prt_name ";
				}
			}
			if (P('show_table_url', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_url prt_url";
			} else {
				if ($defaultOrderColumn == "prt_url") {
					$orderColumnNotDisplayed = " prt_portals.prt_url ";
				}
			}
			if (P('show_table_identifier', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_identifier prt_identifier";
			} else {
				if ($defaultOrderColumn == "prt_identifier") {
					$orderColumnNotDisplayed = " prt_portals.prt_identifier ";
				}
			}
			if (P('show_table_path', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_path prt_path";
			} else {
				if ($defaultOrderColumn == "prt_path") {
					$orderColumnNotDisplayed = " prt_portals.prt_path ";
				}
			}
			if (P('show_table_tolerant_access_policy', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_tolerant_access_policy prt_tolerant_access_policy";
			} else {
				if ($defaultOrderColumn == "prt_tolerant_access_policy") {
					$orderColumnNotDisplayed = " prt_portals.prt_tolerant_access_policy ";
				}
			}
			if (P('show_table_user_class_namespace', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_user_class_namespace prt_user_class_namespace";
			} else {
				if ($defaultOrderColumn == "prt_user_class_namespace") {
					$orderColumnNotDisplayed = " prt_portals.prt_user_class_namespace ";
				}
			}
			if (P('show_table_user_class_name', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_user_class_name prt_user_class_name";
			} else {
				if ($defaultOrderColumn == "prt_user_class_name") {
					$orderColumnNotDisplayed = " prt_portals.prt_user_class_name ";
				}
			}
			if (class_exists('portal\virgoTemplate') && P('show_table_template', "1") != "0") { // */ && !in_array("tmp", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portals.prt_tmp_id as prt_tmp_id ";
				$queryString = $queryString . ", prt_templates_parent.tmp_virgo_title as `template` ";
			} else {
				if ($defaultOrderColumn == "template") {
					$orderColumnNotDisplayed = " prt_templates_parent.tmp_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portals ";
			if (class_exists('portal\virgoTemplate')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_templates AS prt_templates_parent ON (prt_portals.prt_tmp_id = prt_templates_parent.tmp_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClausePortal = $whereClausePortal . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClausePortal, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClausePortal,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_portals"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " prt_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " prt_usr_created_id = ? ";
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
				. "\n FROM prt_portals"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_portals ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_portals ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, prt_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " prt_usr_created_id = ? ";
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
				$query = "SELECT COUNT(prt_id) cnt FROM portals";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as portals ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as portals ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoPortal();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_portals WHERE prt_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->prt_id = $row['prt_id'];
$this->prt_name = $row['prt_name'];
$this->prt_url = $row['prt_url'];
$this->prt_identifier = $row['prt_identifier'];
$this->prt_path = $row['prt_path'];
$this->prt_tolerant_access_policy = $row['prt_tolerant_access_policy'];
$this->prt_user_class_namespace = $row['prt_user_class_namespace'];
$this->prt_user_class_name = $row['prt_user_class_name'];
						$this->prt_tmp_id = $row['prt_tmp_id'];
						if ($fetchUsernames) {
							if ($row['prt_date_created']) {
								if ($row['prt_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['prt_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['prt_date_modified']) {
								if ($row['prt_usr_modified_id'] == $row['prt_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['prt_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['prt_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->prt_date_created = $row['prt_date_created'];
						$this->prt_usr_created_id = $fetchUsernames ? $createdBy : $row['prt_usr_created_id'];
						$this->prt_date_modified = $row['prt_date_modified'];
						$this->prt_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['prt_usr_modified_id'];
						$this->prt_virgo_title = $row['prt_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_portals SET prt_usr_created_id = {$userId} WHERE prt_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->prt_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoPortal::selectAllAsObjectsStatic('prt_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->prt_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->prt_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('prt_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_prt = new virgoPortal();
				$tmp_prt->load((int)$lookup_id);
				return $tmp_prt->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoPortal');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" prt_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoPortal', "10");
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
				$query = $query . " prt_id as id, prt_virgo_title as title ";
			}
			$query = $query . " FROM prt_portals ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoPortal', 'portal') == "1") {
				$privateCondition = " prt_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY prt_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resPortal = array();
				foreach ($rows as $row) {
					$resPortal[$row['id']] = $row['title'];
				}
				return $resPortal;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticPortal = new virgoPortal();
			return $staticPortal->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getTemplateStatic($parentId) {
			return virgoTemplate::getById($parentId);
		}
		
		function getTemplate() {
			return virgoPortal::getTemplateStatic($this->prt_tmp_id);
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
			$resultsPage = virgoPage::selectAll('pge_prt_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPage as $resultPage) {
				$tmpPage = virgoPage::getById($resultPage['pge_id']); 
				array_push($resPage, $tmpPage);
			}
			return $resPage;
		}

		function getPages($orderBy = '', $extraWhere = null) {
			return virgoPortal::getPagesStatic($this->getId(), $orderBy, $extraWhere);
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
			$resultsPortletParameter = virgoPortletParameter::selectAll('ppr_prt_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPortletParameter as $resultPortletParameter) {
				$tmpPortletParameter = virgoPortletParameter::getById($resultPortletParameter['ppr_id']); 
				array_push($resPortletParameter, $tmpPortletParameter);
			}
			return $resPortletParameter;
		}

		function getPortletParameters($orderBy = '', $extraWhere = null) {
			return virgoPortal::getPortletParametersStatic($this->getId(), $orderBy, $extraWhere);
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
			$resultsPortletLocation = virgoPortletLocation::selectAll('plc_prt_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPortletLocation as $resultPortletLocation) {
				$tmpPortletLocation = virgoPortletLocation::getById($resultPortletLocation['plc_id']); 
				array_push($resPortletLocation, $tmpPortletLocation);
			}
			return $resPortletLocation;
		}

		function getPortletLocations($orderBy = '', $extraWhere = null) {
			return virgoPortal::getPortletLocationsStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
			if (
(is_null($this->getName()) || trim($this->getName()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'NAME');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_url_obligatory', "0") == "1") {
				if (
(is_null($this->getUrl()) || trim($this->getUrl()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'URL');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_identifier_obligatory', "0") == "1") {
				if (
(is_null($this->getIdentifier()) || trim($this->getIdentifier()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'IDENTIFIER');
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
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_tolerant_access_policy_obligatory', "0") == "1") {
				if (
(is_null($this->getTolerantAccessPolicy()) || trim($this->getTolerantAccessPolicy()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'TOLERANT_ACCESS_POLICY');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_user_class_namespace_obligatory', "0") == "1") {
				if (
(is_null($this->getUserClassNamespace()) || trim($this->getUserClassNamespace()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'USER_CLASS_NAMESPACE');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_user_class_name_obligatory', "0") == "1") {
				if (
(is_null($this->getUserClassName()) || trim($this->getUserClassName()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'USER_CLASS_NAME');
				}			
			}
			$tmpMode = (is_null($this->getId()) ? "create" : "form");
			if (P('show_'.$tmpMode.'_template_obligatory', "0") == "1") {
				if (is_null($this->prt_tmp_id) || trim($this->prt_tmp_id) == "") {
					if (R('create_prt_template_' . $this->prt_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'TEMPLATE', '');
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_portals WHERE prt_id = " . $this->getId();
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
				$colNames = $colNames . ", prt_name";
				$values = $values . ", " . (is_null($objectToStore->getName()) ? "null" : "'" . QE($objectToStore->getName()) . "'");
				$colNames = $colNames . ", prt_url";
				$values = $values . ", " . (is_null($objectToStore->getUrl()) ? "null" : "'" . QE($objectToStore->getUrl()) . "'");
				$colNames = $colNames . ", prt_identifier";
				$values = $values . ", " . (is_null($objectToStore->getIdentifier()) ? "null" : "'" . QE($objectToStore->getIdentifier()) . "'");
				$colNames = $colNames . ", prt_path";
				$values = $values . ", " . (is_null($objectToStore->getPath()) ? "null" : "'" . QE($objectToStore->getPath()) . "'");
				$colNames = $colNames . ", prt_tolerant_access_policy";
				$values = $values . ", " . (is_null($objectToStore->getTolerantAccessPolicy()) ? "null" : "'" . QE($objectToStore->getTolerantAccessPolicy()) . "'");
				$colNames = $colNames . ", prt_user_class_namespace";
				$values = $values . ", " . (is_null($objectToStore->getUserClassNamespace()) ? "null" : "'" . QE($objectToStore->getUserClassNamespace()) . "'");
				$colNames = $colNames . ", prt_user_class_name";
				$values = $values . ", " . (is_null($objectToStore->getUserClassName()) ? "null" : "'" . QE($objectToStore->getUserClassName()) . "'");
				$colNames = $colNames . ", prt_tmp_id";
				$values = $values . ", " . (is_null($objectToStore->getTmpId()) || $objectToStore->getTmpId() == "" ? "null" : $objectToStore->getTmpId());
				$query = "INSERT INTO prt_history_portals (revision, ip, username, user_id, timestamp, prt_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getName() != $objectToStore->getName()) {
				if (is_null($objectToStore->getName())) {
					$nullifiedProperties = $nullifiedProperties . "name,";
				} else {
				$colNames = $colNames . ", prt_name";
				$values = $values . ", " . (is_null($objectToStore->getName()) ? "null" : "'" . QE($objectToStore->getName()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getUrl() != $objectToStore->getUrl()) {
				if (is_null($objectToStore->getUrl())) {
					$nullifiedProperties = $nullifiedProperties . "url,";
				} else {
				$colNames = $colNames . ", prt_url";
				$values = $values . ", " . (is_null($objectToStore->getUrl()) ? "null" : "'" . QE($objectToStore->getUrl()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getIdentifier() != $objectToStore->getIdentifier()) {
				if (is_null($objectToStore->getIdentifier())) {
					$nullifiedProperties = $nullifiedProperties . "identifier,";
				} else {
				$colNames = $colNames . ", prt_identifier";
				$values = $values . ", " . (is_null($objectToStore->getIdentifier()) ? "null" : "'" . QE($objectToStore->getIdentifier()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getPath() != $objectToStore->getPath()) {
				if (is_null($objectToStore->getPath())) {
					$nullifiedProperties = $nullifiedProperties . "path,";
				} else {
				$colNames = $colNames . ", prt_path";
				$values = $values . ", " . (is_null($objectToStore->getPath()) ? "null" : "'" . QE($objectToStore->getPath()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getTolerantAccessPolicy() != $objectToStore->getTolerantAccessPolicy()) {
				if (is_null($objectToStore->getTolerantAccessPolicy())) {
					$nullifiedProperties = $nullifiedProperties . "tolerant_access_policy,";
				} else {
				$colNames = $colNames . ", prt_tolerant_access_policy";
				$values = $values . ", " . (is_null($objectToStore->getTolerantAccessPolicy()) ? "null" : "'" . QE($objectToStore->getTolerantAccessPolicy()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getUserClassNamespace() != $objectToStore->getUserClassNamespace()) {
				if (is_null($objectToStore->getUserClassNamespace())) {
					$nullifiedProperties = $nullifiedProperties . "user_class_namespace,";
				} else {
				$colNames = $colNames . ", prt_user_class_namespace";
				$values = $values . ", " . (is_null($objectToStore->getUserClassNamespace()) ? "null" : "'" . QE($objectToStore->getUserClassNamespace()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getUserClassName() != $objectToStore->getUserClassName()) {
				if (is_null($objectToStore->getUserClassName())) {
					$nullifiedProperties = $nullifiedProperties . "user_class_name,";
				} else {
				$colNames = $colNames . ", prt_user_class_name";
				$values = $values . ", " . (is_null($objectToStore->getUserClassName()) ? "null" : "'" . QE($objectToStore->getUserClassName()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getTmpId() != $objectToStore->getTmpId() && ($virgoOld->getTmpId() != 0 || $objectToStore->getTmpId() != ""))) { 
				$colNames = $colNames . ", prt_tmp_id";
				$values = $values . ", " . (is_null($objectToStore->getTmpId()) ? "null" : ($objectToStore->getTmpId() == "" ? "0" : $objectToStore->getTmpId()));
			}
			$query = "INSERT INTO prt_history_portals (revision, ip, username, user_id, timestamp, prt_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_portals");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'prt_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_portals ADD COLUMN (prt_virgo_title VARCHAR(255));";
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
			if (isset($this->prt_id) && $this->prt_id != "") {
				$query = "UPDATE prt_portals SET ";
			if (isset($this->prt_name)) {
				$query .= " prt_name = ? ,";
				$types .= "s";
				$values[] = $this->prt_name;
			} else {
				$query .= " prt_name = NULL ,";				
			}
			if (isset($this->prt_url)) {
				$query .= " prt_url = ? ,";
				$types .= "s";
				$values[] = $this->prt_url;
			} else {
				$query .= " prt_url = NULL ,";				
			}
			if (isset($this->prt_identifier)) {
				$query .= " prt_identifier = ? ,";
				$types .= "s";
				$values[] = $this->prt_identifier;
			} else {
				$query .= " prt_identifier = NULL ,";				
			}
			if (isset($this->prt_path)) {
				$query .= " prt_path = ? ,";
				$types .= "s";
				$values[] = $this->prt_path;
			} else {
				$query .= " prt_path = NULL ,";				
			}
			if (isset($this->prt_tolerant_access_policy)) {
				$query .= " prt_tolerant_access_policy = ? ,";
				$types .= "s";
				$values[] = $this->prt_tolerant_access_policy;
			} else {
				$query .= " prt_tolerant_access_policy = NULL ,";				
			}
			if (isset($this->prt_user_class_namespace)) {
				$query .= " prt_user_class_namespace = ? ,";
				$types .= "s";
				$values[] = $this->prt_user_class_namespace;
			} else {
				$query .= " prt_user_class_namespace = NULL ,";				
			}
			if (isset($this->prt_user_class_name)) {
				$query .= " prt_user_class_name = ? ,";
				$types .= "s";
				$values[] = $this->prt_user_class_name;
			} else {
				$query .= " prt_user_class_name = NULL ,";				
			}
				if (isset($this->prt_tmp_id) && trim($this->prt_tmp_id) != "") {
					$query = $query . " prt_tmp_id = ? , ";
					$types = $types . "i";
					$values[] = $this->prt_tmp_id;
				} else {
					$query = $query . " prt_tmp_id = NULL, ";
				}
				$query = $query . " prt_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " prt_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->prt_date_modified;

				$query = $query . " prt_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->prt_usr_modified_id;

				$query = $query . " WHERE prt_id = ? ";
				$types = $types . "i";
				$values[] = $this->prt_id;
			} else {
				$query = "INSERT INTO prt_portals ( ";
			$query = $query . " prt_name, ";
			$query = $query . " prt_url, ";
			$query = $query . " prt_identifier, ";
			$query = $query . " prt_path, ";
			$query = $query . " prt_tolerant_access_policy, ";
			$query = $query . " prt_user_class_namespace, ";
			$query = $query . " prt_user_class_name, ";
				$query = $query . " prt_tmp_id, ";
				$query = $query . " prt_virgo_title, prt_date_created, prt_usr_created_id) VALUES ( ";
			if (isset($this->prt_name)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prt_name;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prt_url)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prt_url;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prt_identifier)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prt_identifier;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prt_path)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prt_path;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prt_tolerant_access_policy)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prt_tolerant_access_policy;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prt_user_class_namespace)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prt_user_class_namespace;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prt_user_class_name)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prt_user_class_name;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->prt_tmp_id) && trim($this->prt_tmp_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->prt_tmp_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->prt_date_created;
				$values[] = $this->prt_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->prt_id) || $this->prt_id == "") {
					$this->prt_id = QID();
				}
				if ($log) {
					L("portal stored successfully", "id = {$this->prt_id}", "TRACE");
				}
				return true;
			}
		}
		

		static function addPageStatic($thisId, $id) {
			$query = " SELECT COUNT(plc_id) AS cnt FROM prt_portlet_locations WHERE plc_prt_id = {$thisId} AND plc_pge_id = {$id} ";
			$res = Q1($query);
			if ($res == 0) {
				$newPortletLocation = new virgoPortletLocation();
				$newPortletLocation->setPageId($id);
				$newPortletLocation->setPortalId($thisId);
				return $newPortletLocation->store();
			}			
			return "";
		}
		
		function addPage($id) {
			return virgoPortal::addPageStatic($this->getId(), $id);
		}
		
		static function removePageStatic($thisId, $id) {
			$query = " SELECT plc_id AS id FROM prt_portlet_locations WHERE plc_prt_id = {$thisId} AND plc_pge_id = {$id} ";
			$res = QR($query);
			foreach ($res as $re) {
				$newPortletLocation = new virgoPortletLocation($re['id']);
				return $newPortletLocation->delete();
			}			
			return "";
		}
		
		function removePage($id) {
			return virgoPortal::removePageStatic($this->getId(), $id);
		}
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->prt_id) {
				$virgoOld = new virgoPortal($this->prt_id);
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
					if ($this->prt_id) {			
						$this->prt_date_modified = date("Y-m-d H:i:s");
						$this->prt_usr_modified_id = $userId;
					} else {
						$this->prt_date_created = date("Y-m-d H:i:s");
						$this->prt_usr_created_id = $userId;
					}
					$this->prt_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "portal" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "portal" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM prt_portals WHERE prt_id = {$this->prt_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			$list = $this->getPages();
			if (sizeof($list) > 0) {
				$name = $this->getVirgoTitle();
				if (!is_null($name) && trim($name) != "") {
					$name = "'" . $name . "' ";
				}
				return T('CANT_DELETE_PARENT', 'PORTAL', 'PAGE', $name);
			}
			$list = $this->getPortletParameters();
			if (sizeof($list) > 0) {
				foreach ($list as $childRecord) {
					$childRecord->delete();
				}
			}
			$list = $this->getPortletLocations();
			if (sizeof($list) > 0) {
				$name = $this->getVirgoTitle();
				if (!is_null($name) && trim($name) != "") {
					$name = "'" . $name . "' ";
				}
				return T('CANT_DELETE_PARENT', 'PORTAL', 'PORTLET_LOCATION', $name);
			}
			self::removeFromContext();
			$this->parentDelete();
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoPortal();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT prt_id as id FROM prt_portals";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'prt_order_column')) {
				$orderBy = " ORDER BY prt_order_column ASC ";
			} 
			if (property_exists($this, 'prt_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY prt_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoPortal();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoPortal($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_portals SET prt_virgo_title = '$title' WHERE prt_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getByNameStatic($token) {
			$tmpStatic = new virgoPortal();
			$tmpId = $tmpStatic->getIdByName($token);
			$tmpStatic->load($tmpId);
			return $tmpStatic;
		}
		
		static function getIdByNameStatic($token) {
			$tmpStatic = new virgoPortal();
			return $tmpStatic->getIdByName($token);
		}
		
		function getIdByName($token) {
			$res = $this->selectAll(" prt_name = ?", "", "s", array($token));
			foreach ($res as $r) {
				return $r['prt_id'];
			}
			return null;
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoPortal();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" prt_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['prt_id'];
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
			virgoPortal::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoPortal::setSessionValue('Portal_Portal-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoPortal::getSessionValue('Portal_Portal-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoPortal::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoPortal::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoPortal::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoPortal::getSessionValue('GLOBAL', $name, $default);
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
			$context['prt_id'] = $id;
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
			$context['prt_id'] = null;
			virgoPortal::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoPortal::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoPortal::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoPortal::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoPortal::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoPortal::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoPortal::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoPortal::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoPortal::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoPortal::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoPortal::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoPortal::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoPortal::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoPortal::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoPortal::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoPortal::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoPortal::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "prt_id";
			}
			return virgoPortal::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoPortal::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoPortal::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoPortal::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoPortal::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoPortal::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoPortal::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoPortal::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoPortal::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoPortal::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoPortal::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoPortal::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoPortal::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->prt_id) {
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
						L(T('STORED_CORRECTLY', 'PORTAL'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'name', $this->prt_name);
						$fieldValues = $fieldValues . T($fieldValue, 'url', $this->prt_url);
						$fieldValues = $fieldValues . T($fieldValue, 'identifier', $this->prt_identifier);
						$fieldValues = $fieldValues . T($fieldValue, 'path', $this->prt_path);
						$fieldValues = $fieldValues . T($fieldValue, 'tolerant access policy', $this->prt_tolerant_access_policy);
						$fieldValues = $fieldValues . T($fieldValue, 'user class namespace', $this->prt_user_class_namespace);
						$fieldValues = $fieldValues . T($fieldValue, 'user class name', $this->prt_user_class_name);
						$parentTemplate = new virgoTemplate();
						$fieldValues = $fieldValues . T($fieldValue, 'template', $parentTemplate->lookup($this->prt_tmp_id));
						$username = '';
						if ($this->prt_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->prt_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->prt_date_created);
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
			$instance = new virgoPortal();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			if (false) { //$componentParams->get('show_form_pages') == "1") {
				$tmpPage = new virgoPage();
				$deletePage = R('DELETE');
				if (sizeof($deletePage) > 0) {
					$tmpPage->multipleDelete($deletePage);
				}
				$resIds = $tmpPage->select(null, 'all', null, null, ' pge_prt_id = ' . $instance->getId(), ' SELECT pge_id FROM prt_pages ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->pge_id;
//					JRequest::setVar('pge_portal_' . $resId->pge_id, $this->getId());
				} 
//				JRequest::setVar('pge_portal_', $instance->getId());
				$tmpPage->setRecordSet($resIdsString);
				if (!$tmpPage->portletActionStoreSelected()) {
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
				$resIds = $tmpPortletParameter->select(null, 'all', null, null, ' ppr_prt_id = ' . $instance->getId(), ' SELECT ppr_id FROM prt_portlet_parameters ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->ppr_id;
//					JRequest::setVar('ppr_portal_' . $resId->ppr_id, $this->getId());
				} 
//				JRequest::setVar('ppr_portal_', $instance->getId());
				$tmpPortletParameter->setRecordSet($resIdsString);
				if (!$tmpPortletParameter->portletActionStoreSelected()) {
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
			$tmpId = intval(R('prt_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoPortal::getContextId();
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
			$this->prt_id = null;
			$this->prt_date_created = null;
			$this->prt_usr_created_id = null;
			$this->prt_date_modified = null;
			$this->prt_usr_modified_id = null;
			$this->prt_virgo_title = null;
			
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


		static function portletActionAdd() {
			$portletObject = self::getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("add")) {
			self::removeFromContext();
			self::setDisplayMode("CREATE");
//			$ret = new virgoPortal();
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
				$instance = new virgoPortal();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoPortal::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'PORTAL'), '', 'INFO');
					return 0;
					
				} else {
					L($res, '', 'ERROR');
					return -1;
				}
			}
		}
		
		
		static function portletActionVirgoSetTolerantAccessPolicyTrue() {
			$this->loadFromDB();
			$this->setTolerantAccessPolicy(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetTolerantAccessPolicyFalse() {
			$this->loadFromDB();
			$this->setTolerantAccessPolicy(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isTolerantAccessPolicy() {
			return $this->getTolerantAccessPolicy() == 1;
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
				$resultPortal = new virgoPortal();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultPortal->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultPortal->load($idToEditInt);
					} else {
						$resultPortal->prt_id = 0;
					}
				}
				$results[] = $resultPortal;
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
				$result = new virgoPortal();
				$result->loadFromRequest($idToStore);
				if ($result->prt_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->prt_id == 0) {
						$result->prt_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->prt_id)) {
							$result->prt_id = 0;
						}
						$idsToCorrect[$result->prt_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'PORTALS'), '', 'INFO');
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
			$resultPortal = new virgoPortal();
			foreach ($idsToDelete as $idToDelete) {
				$resultPortal->load((int)trim($idToDelete));
				$res = $resultPortal->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'PORTALS'), '', 'INFO');			
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
		$ret = $this->prt_name;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoPortal');
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
				$query = "UPDATE prt_portals SET prt_virgo_title = ? WHERE prt_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT prt_id AS id FROM prt_portals ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoPortal($row['id']);
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
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'prt_portals.prt_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_portals.prt_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_portals.prt_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_portals.prt_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoPortal!', '', 'ERROR');
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
			$pdf->SetTitle('Portals report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('PORTALS');
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
			if (P('show_pdf_name', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_url', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_identifier', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_path', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_tolerant_access_policy', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_user_class_namespace', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_user_class_name', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_template', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultPortal = new virgoPortal();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_name', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Name');
				$minWidth['name'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['name']) {
						$minWidth['name'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_url', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Url');
				$minWidth['url'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['url']) {
						$minWidth['url'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_identifier', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Identifier');
				$minWidth['identifier'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['identifier']) {
						$minWidth['identifier'] = min($tmpLen, $maxWidth);
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
			if (P('show_pdf_tolerant_access_policy', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Tolerant access policy');
				$minWidth['tolerant access policy'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['tolerant access policy']) {
						$minWidth['tolerant access policy'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_user_class_namespace', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'User class namespace');
				$minWidth['user class namespace'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['user class namespace']) {
						$minWidth['user class namespace'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_user_class_name', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'User class name');
				$minWidth['user class name'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['user class name']) {
						$minWidth['user class name'] = min($tmpLen, $maxWidth);
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
			$pdf->SetFont($font, '', $fontSize);
			$pdf->AliasNbPages();
			$orientation = P('pdf_page_orientation', 'P');
			$pdf->AddPage($orientation);
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 4);
			$pdf->MultiCell(0, 1, $reportTitle, '', 'C', 0, 0);
			$pdf->Ln();
			$whereClausePortal = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClausePortal = $whereClausePortal . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaPortal = $resultPortal->getCriteria();
			$fieldCriteriaName = $criteriaPortal["name"];
			if ($fieldCriteriaName["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Name', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaName["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Name', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaUrl = $criteriaPortal["url"];
			if ($fieldCriteriaUrl["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Url', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaUrl["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Url', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaIdentifier = $criteriaPortal["identifier"];
			if ($fieldCriteriaIdentifier["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Identifier', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaIdentifier["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Identifier', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaPath = $criteriaPortal["path"];
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
			$fieldCriteriaTolerantAccessPolicy = $criteriaPortal["tolerant_access_policy"];
			if ($fieldCriteriaTolerantAccessPolicy["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Tolerant access policy', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaTolerantAccessPolicy["value"];
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
					$pdf->MultiCell(60, 100, 'Tolerant access policy', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaUserClassNamespace = $criteriaPortal["user_class_namespace"];
			if ($fieldCriteriaUserClassNamespace["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'User class namespace', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaUserClassNamespace["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'User class namespace', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaUserClassName = $criteriaPortal["user_class_name"];
			if ($fieldCriteriaUserClassName["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'User class name', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaUserClassName["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'User class name', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaPortal["template"];
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
					$inCondition = " prt_portals.prt_tmp_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portals.prt_tmp_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortal = $whereClausePortal . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaPortal = self::getCriteria();
			if (isset($criteriaPortal["name"])) {
				$fieldCriteriaName = $criteriaPortal["name"];
				if ($fieldCriteriaName["is_null"] == 1) {
$filter = $filter . ' AND prt_portals.prt_name IS NOT NULL ';
				} elseif ($fieldCriteriaName["is_null"] == 2) {
$filter = $filter . ' AND prt_portals.prt_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portals.prt_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortal["url"])) {
				$fieldCriteriaUrl = $criteriaPortal["url"];
				if ($fieldCriteriaUrl["is_null"] == 1) {
$filter = $filter . ' AND prt_portals.prt_url IS NOT NULL ';
				} elseif ($fieldCriteriaUrl["is_null"] == 2) {
$filter = $filter . ' AND prt_portals.prt_url IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaUrl["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portals.prt_url like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortal["identifier"])) {
				$fieldCriteriaIdentifier = $criteriaPortal["identifier"];
				if ($fieldCriteriaIdentifier["is_null"] == 1) {
$filter = $filter . ' AND prt_portals.prt_identifier IS NOT NULL ';
				} elseif ($fieldCriteriaIdentifier["is_null"] == 2) {
$filter = $filter . ' AND prt_portals.prt_identifier IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaIdentifier["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portals.prt_identifier like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortal["path"])) {
				$fieldCriteriaPath = $criteriaPortal["path"];
				if ($fieldCriteriaPath["is_null"] == 1) {
$filter = $filter . ' AND prt_portals.prt_path IS NOT NULL ';
				} elseif ($fieldCriteriaPath["is_null"] == 2) {
$filter = $filter . ' AND prt_portals.prt_path IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaPath["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portals.prt_path like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortal["tolerant_access_policy"])) {
				$fieldCriteriaTolerantAccessPolicy = $criteriaPortal["tolerant_access_policy"];
				if ($fieldCriteriaTolerantAccessPolicy["is_null"] == 1) {
$filter = $filter . ' AND prt_portals.prt_tolerant_access_policy IS NOT NULL ';
				} elseif ($fieldCriteriaTolerantAccessPolicy["is_null"] == 2) {
$filter = $filter . ' AND prt_portals.prt_tolerant_access_policy IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaTolerantAccessPolicy["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_portals.prt_tolerant_access_policy = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaPortal["user_class_namespace"])) {
				$fieldCriteriaUserClassNamespace = $criteriaPortal["user_class_namespace"];
				if ($fieldCriteriaUserClassNamespace["is_null"] == 1) {
$filter = $filter . ' AND prt_portals.prt_user_class_namespace IS NOT NULL ';
				} elseif ($fieldCriteriaUserClassNamespace["is_null"] == 2) {
$filter = $filter . ' AND prt_portals.prt_user_class_namespace IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaUserClassNamespace["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portals.prt_user_class_namespace like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortal["user_class_name"])) {
				$fieldCriteriaUserClassName = $criteriaPortal["user_class_name"];
				if ($fieldCriteriaUserClassName["is_null"] == 1) {
$filter = $filter . ' AND prt_portals.prt_user_class_name IS NOT NULL ';
				} elseif ($fieldCriteriaUserClassName["is_null"] == 2) {
$filter = $filter . ' AND prt_portals.prt_user_class_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaUserClassName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portals.prt_user_class_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortal["template"])) {
				$parentCriteria = $criteriaPortal["template"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND prt_tmp_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portals.prt_tmp_id IN (SELECT tmp_id FROM prt_templates WHERE tmp_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPortal["page"])) {
				$parentCriteria = $criteriaPortal["page"];
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$filter = $filter . " AND prt_portals.prt_id IN (SELECT second_parent.plc_prt_id FROM prt_portlet_locations AS second_parent WHERE second_parent.plc_pge_id IN (" . implode(", ", $parentIds) . ")) ";
				}
			}
			$whereClausePortal = $whereClausePortal . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClausePortal = $whereClausePortal . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_portals.prt_id, prt_portals.prt_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_name', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_name prt_name";
			} else {
				if ($defaultOrderColumn == "prt_name") {
					$orderColumnNotDisplayed = " prt_portals.prt_name ";
				}
			}
			if (P('show_pdf_url', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_url prt_url";
			} else {
				if ($defaultOrderColumn == "prt_url") {
					$orderColumnNotDisplayed = " prt_portals.prt_url ";
				}
			}
			if (P('show_pdf_identifier', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_identifier prt_identifier";
			} else {
				if ($defaultOrderColumn == "prt_identifier") {
					$orderColumnNotDisplayed = " prt_portals.prt_identifier ";
				}
			}
			if (P('show_pdf_path', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_path prt_path";
			} else {
				if ($defaultOrderColumn == "prt_path") {
					$orderColumnNotDisplayed = " prt_portals.prt_path ";
				}
			}
			if (P('show_pdf_tolerant_access_policy', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_tolerant_access_policy prt_tolerant_access_policy";
			} else {
				if ($defaultOrderColumn == "prt_tolerant_access_policy") {
					$orderColumnNotDisplayed = " prt_portals.prt_tolerant_access_policy ";
				}
			}
			if (P('show_pdf_user_class_namespace', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_user_class_namespace prt_user_class_namespace";
			} else {
				if ($defaultOrderColumn == "prt_user_class_namespace") {
					$orderColumnNotDisplayed = " prt_portals.prt_user_class_namespace ";
				}
			}
			if (P('show_pdf_user_class_name', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_user_class_name prt_user_class_name";
			} else {
				if ($defaultOrderColumn == "prt_user_class_name") {
					$orderColumnNotDisplayed = " prt_portals.prt_user_class_name ";
				}
			}
			if (class_exists('portal\virgoTemplate') && P('show_pdf_template', "1") != "0") { // */ && !in_array("tmp", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portals.prt_tmp_id as prt_tmp_id ";
				$queryString = $queryString . ", prt_templates_parent.tmp_virgo_title as `template` ";
			} else {
				if ($defaultOrderColumn == "template") {
					$orderColumnNotDisplayed = " prt_templates_parent.tmp_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portals ";
			if (class_exists('portal\virgoTemplate')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_templates AS prt_templates_parent ON (prt_portals.prt_tmp_id = prt_templates_parent.tmp_id) ";
			}

		$resultsPortal = $resultPortal->select(
			'', 
			'all', 
			$resultPortal->getOrderColumn(), 
			$resultPortal->getOrderMode(), 
			$whereClausePortal,
			$queryString);
		
		foreach ($resultsPortal as $resultPortal) {

			if (P('show_pdf_name', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortal['prt_name'])) + 6;
				if ($tmpLen > $minWidth['name']) {
					$minWidth['name'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_url', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortal['prt_url'])) + 6;
				if ($tmpLen > $minWidth['url']) {
					$minWidth['url'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_identifier', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortal['prt_identifier'])) + 6;
				if ($tmpLen > $minWidth['identifier']) {
					$minWidth['identifier'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_path', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortal['prt_path'])) + 6;
				if ($tmpLen > $minWidth['path']) {
					$minWidth['path'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_tolerant_access_policy', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortal['prt_tolerant_access_policy'])) + 6;
				if ($tmpLen > $minWidth['tolerant access policy']) {
					$minWidth['tolerant access policy'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_user_class_namespace', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortal['prt_user_class_namespace'])) + 6;
				if ($tmpLen > $minWidth['user class namespace']) {
					$minWidth['user class namespace'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_user_class_name', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortal['prt_user_class_name'])) + 6;
				if ($tmpLen > $minWidth['user class name']) {
					$minWidth['user class name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_template', "1") == "1") {
			$parentValue = trim(virgoTemplate::lookup($resultPortal['prttmp__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['template $relation.name']) {
					$minWidth['template $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaPortal = $resultPortal->getCriteria();
		if (is_null($criteriaPortal) || sizeof($criteriaPortal) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																							if (P('show_pdf_name', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['name'], $colHeight, T('NAME'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_url', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['url'], $colHeight, T('URL'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_identifier', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['identifier'], $colHeight, T('IDENTIFIER'), 'T', 'C', 0, 0);
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
			if (P('show_pdf_tolerant_access_policy', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['tolerant access policy'], $colHeight, T('TOLERANT_ACCESS_POLICY'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_user_class_namespace', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['user class namespace'], $colHeight, T('USER_CLASS_NAMESPACE'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_user_class_name', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['user class name'], $colHeight, T('USER_CLASS_NAME'), 'T', 'C', 0, 0);
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
		foreach ($resultsPortal as $resultPortal) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_name', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['name'], $colHeight, '' . $resultPortal['prt_name'], 'T', 'L', 0, 0);
				if (P('show_pdf_name', "1") == "2") {
										if (!is_null($resultPortal['prt_name'])) {
						$tmpCount = (float)$counts["name"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["name"] = $tmpCount;
					}
				}
				if (P('show_pdf_name', "1") == "3") {
										if (!is_null($resultPortal['prt_name'])) {
						$tmpSum = (float)$sums["name"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortal['prt_name'];
						}
						$sums["name"] = $tmpSum;
					}
				}
				if (P('show_pdf_name', "1") == "4") {
										if (!is_null($resultPortal['prt_name'])) {
						$tmpCount = (float)$avgCounts["name"];
						$tmpSum = (float)$avgSums["name"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["name"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortal['prt_name'];
						}
						$avgSums["name"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_url', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['url'], $colHeight, '' . $resultPortal['prt_url'], 'T', 'L', 0, 0);
				if (P('show_pdf_url', "1") == "2") {
										if (!is_null($resultPortal['prt_url'])) {
						$tmpCount = (float)$counts["url"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["url"] = $tmpCount;
					}
				}
				if (P('show_pdf_url', "1") == "3") {
										if (!is_null($resultPortal['prt_url'])) {
						$tmpSum = (float)$sums["url"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortal['prt_url'];
						}
						$sums["url"] = $tmpSum;
					}
				}
				if (P('show_pdf_url', "1") == "4") {
										if (!is_null($resultPortal['prt_url'])) {
						$tmpCount = (float)$avgCounts["url"];
						$tmpSum = (float)$avgSums["url"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["url"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortal['prt_url'];
						}
						$avgSums["url"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_identifier', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['identifier'], $colHeight, '' . $resultPortal['prt_identifier'], 'T', 'L', 0, 0);
				if (P('show_pdf_identifier', "1") == "2") {
										if (!is_null($resultPortal['prt_identifier'])) {
						$tmpCount = (float)$counts["identifier"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["identifier"] = $tmpCount;
					}
				}
				if (P('show_pdf_identifier', "1") == "3") {
										if (!is_null($resultPortal['prt_identifier'])) {
						$tmpSum = (float)$sums["identifier"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortal['prt_identifier'];
						}
						$sums["identifier"] = $tmpSum;
					}
				}
				if (P('show_pdf_identifier', "1") == "4") {
										if (!is_null($resultPortal['prt_identifier'])) {
						$tmpCount = (float)$avgCounts["identifier"];
						$tmpSum = (float)$avgSums["identifier"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["identifier"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortal['prt_identifier'];
						}
						$avgSums["identifier"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_path', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['path'], $colHeight, '' . $resultPortal['prt_path'], 'T', 'L', 0, 0);
				if (P('show_pdf_path', "1") == "2") {
										if (!is_null($resultPortal['prt_path'])) {
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
										if (!is_null($resultPortal['prt_path'])) {
						$tmpSum = (float)$sums["path"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortal['prt_path'];
						}
						$sums["path"] = $tmpSum;
					}
				}
				if (P('show_pdf_path', "1") == "4") {
										if (!is_null($resultPortal['prt_path'])) {
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
							$tmpSum = $tmpSum + $resultPortal['prt_path'];
						}
						$avgSums["path"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_tolerant_access_policy', "0") != "0") {
			$renderCriteria = "";
			switch ($resultPortal['prt_tolerant_access_policy']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['tolerant access policy'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_tolerant_access_policy', "1") == "2") {
										if (!is_null($resultPortal['prt_tolerant_access_policy'])) {
						$tmpCount = (float)$counts["tolerant_access_policy"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["tolerant_access_policy"] = $tmpCount;
					}
				}
				if (P('show_pdf_tolerant_access_policy', "1") == "3") {
										if (!is_null($resultPortal['prt_tolerant_access_policy'])) {
						$tmpSum = (float)$sums["tolerant_access_policy"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortal['prt_tolerant_access_policy'];
						}
						$sums["tolerant_access_policy"] = $tmpSum;
					}
				}
				if (P('show_pdf_tolerant_access_policy', "1") == "4") {
										if (!is_null($resultPortal['prt_tolerant_access_policy'])) {
						$tmpCount = (float)$avgCounts["tolerant_access_policy"];
						$tmpSum = (float)$avgSums["tolerant_access_policy"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["tolerant_access_policy"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortal['prt_tolerant_access_policy'];
						}
						$avgSums["tolerant_access_policy"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_user_class_namespace', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['user class namespace'], $colHeight, '' . $resultPortal['prt_user_class_namespace'], 'T', 'L', 0, 0);
				if (P('show_pdf_user_class_namespace', "1") == "2") {
										if (!is_null($resultPortal['prt_user_class_namespace'])) {
						$tmpCount = (float)$counts["user_class_namespace"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["user_class_namespace"] = $tmpCount;
					}
				}
				if (P('show_pdf_user_class_namespace', "1") == "3") {
										if (!is_null($resultPortal['prt_user_class_namespace'])) {
						$tmpSum = (float)$sums["user_class_namespace"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortal['prt_user_class_namespace'];
						}
						$sums["user_class_namespace"] = $tmpSum;
					}
				}
				if (P('show_pdf_user_class_namespace', "1") == "4") {
										if (!is_null($resultPortal['prt_user_class_namespace'])) {
						$tmpCount = (float)$avgCounts["user_class_namespace"];
						$tmpSum = (float)$avgSums["user_class_namespace"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["user_class_namespace"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortal['prt_user_class_namespace'];
						}
						$avgSums["user_class_namespace"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_user_class_name', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['user class name'], $colHeight, '' . $resultPortal['prt_user_class_name'], 'T', 'L', 0, 0);
				if (P('show_pdf_user_class_name', "1") == "2") {
										if (!is_null($resultPortal['prt_user_class_name'])) {
						$tmpCount = (float)$counts["user_class_name"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["user_class_name"] = $tmpCount;
					}
				}
				if (P('show_pdf_user_class_name', "1") == "3") {
										if (!is_null($resultPortal['prt_user_class_name'])) {
						$tmpSum = (float)$sums["user_class_name"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortal['prt_user_class_name'];
						}
						$sums["user_class_name"] = $tmpSum;
					}
				}
				if (P('show_pdf_user_class_name', "1") == "4") {
										if (!is_null($resultPortal['prt_user_class_name'])) {
						$tmpCount = (float)$avgCounts["user_class_name"];
						$tmpSum = (float)$avgSums["user_class_name"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["user_class_name"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortal['prt_user_class_name'];
						}
						$avgSums["user_class_name"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_template', "1") == "1") {
			$parentValue = virgoTemplate::lookup($resultPortal['prt_tmp_id']);
			$tmpLn = $pdf->MultiCell($minWidth['template $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
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
			if (P('show_pdf_name', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['name'];
				if (P('show_pdf_name', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["name"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_url', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['url'];
				if (P('show_pdf_url', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["url"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_identifier', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['identifier'];
				if (P('show_pdf_identifier', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["identifier"];
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
			if (P('show_pdf_tolerant_access_policy', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['tolerant access policy'];
				if (P('show_pdf_tolerant_access_policy', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["tolerant_access_policy"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_user_class_namespace', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['user class namespace'];
				if (P('show_pdf_user_class_namespace', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["user_class_namespace"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_user_class_name', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['user class name'];
				if (P('show_pdf_user_class_name', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["user_class_name"];
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
			if (P('show_pdf_name', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['name'];
				if (P('show_pdf_name', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["name"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_url', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['url'];
				if (P('show_pdf_url', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["url"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_identifier', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['identifier'];
				if (P('show_pdf_identifier', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["identifier"], 2, ',', ' ');
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
			if (P('show_pdf_tolerant_access_policy', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['tolerant access policy'];
				if (P('show_pdf_tolerant_access_policy', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["tolerant_access_policy"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_user_class_namespace', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['user class namespace'];
				if (P('show_pdf_user_class_namespace', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["user_class_namespace"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_user_class_name', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['user class name'];
				if (P('show_pdf_user_class_name', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["user_class_name"], 2, ',', ' ');
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
			if (P('show_pdf_name', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['name'];
				if (P('show_pdf_name', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["name"] == 0 ? "-" : $avgSums["name"] / $avgCounts["name"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_url', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['url'];
				if (P('show_pdf_url', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["url"] == 0 ? "-" : $avgSums["url"] / $avgCounts["url"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_identifier', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['identifier'];
				if (P('show_pdf_identifier', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["identifier"] == 0 ? "-" : $avgSums["identifier"] / $avgCounts["identifier"]);
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
			if (P('show_pdf_tolerant_access_policy', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['tolerant access policy'];
				if (P('show_pdf_tolerant_access_policy', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["tolerant_access_policy"] == 0 ? "-" : $avgSums["tolerant_access_policy"] / $avgCounts["tolerant_access_policy"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_user_class_namespace', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['user class namespace'];
				if (P('show_pdf_user_class_namespace', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["user_class_namespace"] == 0 ? "-" : $avgSums["user_class_namespace"] / $avgCounts["user_class_namespace"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_user_class_name', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['user class name'];
				if (P('show_pdf_user_class_name', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["user_class_name"] == 0 ? "-" : $avgSums["user_class_name"] / $avgCounts["user_class_name"]);
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
				$reportTitle = T('PORTALS');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultPortal = new virgoPortal();
			$whereClausePortal = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePortal = $whereClausePortal . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_name', "1") != "0") {
					$data = $data . $stringDelimeter .'Name' . $stringDelimeter . $separator;
				}
				if (P('show_export_url', "1") != "0") {
					$data = $data . $stringDelimeter .'Url' . $stringDelimeter . $separator;
				}
				if (P('show_export_identifier', "1") != "0") {
					$data = $data . $stringDelimeter .'Identifier' . $stringDelimeter . $separator;
				}
				if (P('show_export_path', "1") != "0") {
					$data = $data . $stringDelimeter .'Path' . $stringDelimeter . $separator;
				}
				if (P('show_export_tolerant_access_policy', "1") != "0") {
					$data = $data . $stringDelimeter .'Tolerant access policy' . $stringDelimeter . $separator;
				}
				if (P('show_export_user_class_namespace', "1") != "0") {
					$data = $data . $stringDelimeter .'User class namespace' . $stringDelimeter . $separator;
				}
				if (P('show_export_user_class_name', "1") != "0") {
					$data = $data . $stringDelimeter .'User class name' . $stringDelimeter . $separator;
				}
				if (P('show_export_template', "1") != "0") {
					$data = $data . $stringDelimeter . 'Template ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_portals.prt_id, prt_portals.prt_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_name', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_name prt_name";
			} else {
				if ($defaultOrderColumn == "prt_name") {
					$orderColumnNotDisplayed = " prt_portals.prt_name ";
				}
			}
			if (P('show_export_url', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_url prt_url";
			} else {
				if ($defaultOrderColumn == "prt_url") {
					$orderColumnNotDisplayed = " prt_portals.prt_url ";
				}
			}
			if (P('show_export_identifier', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_identifier prt_identifier";
			} else {
				if ($defaultOrderColumn == "prt_identifier") {
					$orderColumnNotDisplayed = " prt_portals.prt_identifier ";
				}
			}
			if (P('show_export_path', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_path prt_path";
			} else {
				if ($defaultOrderColumn == "prt_path") {
					$orderColumnNotDisplayed = " prt_portals.prt_path ";
				}
			}
			if (P('show_export_tolerant_access_policy', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_tolerant_access_policy prt_tolerant_access_policy";
			} else {
				if ($defaultOrderColumn == "prt_tolerant_access_policy") {
					$orderColumnNotDisplayed = " prt_portals.prt_tolerant_access_policy ";
				}
			}
			if (P('show_export_user_class_namespace', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_user_class_namespace prt_user_class_namespace";
			} else {
				if ($defaultOrderColumn == "prt_user_class_namespace") {
					$orderColumnNotDisplayed = " prt_portals.prt_user_class_namespace ";
				}
			}
			if (P('show_export_user_class_name', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_user_class_name prt_user_class_name";
			} else {
				if ($defaultOrderColumn == "prt_user_class_name") {
					$orderColumnNotDisplayed = " prt_portals.prt_user_class_name ";
				}
			}
			if (class_exists('portal\virgoTemplate') && P('show_export_template', "1") != "0") { // */ && !in_array("tmp", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portals.prt_tmp_id as prt_tmp_id ";
				$queryString = $queryString . ", prt_templates_parent.tmp_virgo_title as `template` ";
			} else {
				if ($defaultOrderColumn == "template") {
					$orderColumnNotDisplayed = " prt_templates_parent.tmp_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portals ";
			if (class_exists('portal\virgoTemplate')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_templates AS prt_templates_parent ON (prt_portals.prt_tmp_id = prt_templates_parent.tmp_id) ";
			}

			$resultsPortal = $resultPortal->select(
				'', 
				'all', 
				$resultPortal->getOrderColumn(), 
				$resultPortal->getOrderMode(), 
				$whereClausePortal,
				$queryString);
			foreach ($resultsPortal as $resultPortal) {
				if (P('show_export_name', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPortal['prt_name'] . $stringDelimeter . $separator;
				}
				if (P('show_export_url', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPortal['prt_url'] . $stringDelimeter . $separator;
				}
				if (P('show_export_identifier', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPortal['prt_identifier'] . $stringDelimeter . $separator;
				}
				if (P('show_export_path', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPortal['prt_path'] . $stringDelimeter . $separator;
				}
				if (P('show_export_tolerant_access_policy', "1") != "0") {
			$data = $data . $resultPortal['prt_tolerant_access_policy'] . $separator;
				}
				if (P('show_export_user_class_namespace', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPortal['prt_user_class_namespace'] . $stringDelimeter . $separator;
				}
				if (P('show_export_user_class_name', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPortal['prt_user_class_name'] . $stringDelimeter . $separator;
				}
				if (P('show_export_template', "1") != "0") {
					$parentValue = virgoTemplate::lookup($resultPortal['prt_tmp_id']);
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
				$reportTitle = T('PORTALS');
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
			$resultPortal = new virgoPortal();
			$whereClausePortal = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePortal = $whereClausePortal . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_name', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Name');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_url', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Url');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_identifier', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Identifier');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_path', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Path');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_tolerant_access_policy', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Tolerant access policy');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_user_class_namespace', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'User class namespace');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_user_class_name', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'User class name');
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
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_portals.prt_id, prt_portals.prt_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_name', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_name prt_name";
			} else {
				if ($defaultOrderColumn == "prt_name") {
					$orderColumnNotDisplayed = " prt_portals.prt_name ";
				}
			}
			if (P('show_export_url', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_url prt_url";
			} else {
				if ($defaultOrderColumn == "prt_url") {
					$orderColumnNotDisplayed = " prt_portals.prt_url ";
				}
			}
			if (P('show_export_identifier', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_identifier prt_identifier";
			} else {
				if ($defaultOrderColumn == "prt_identifier") {
					$orderColumnNotDisplayed = " prt_portals.prt_identifier ";
				}
			}
			if (P('show_export_path', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_path prt_path";
			} else {
				if ($defaultOrderColumn == "prt_path") {
					$orderColumnNotDisplayed = " prt_portals.prt_path ";
				}
			}
			if (P('show_export_tolerant_access_policy', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_tolerant_access_policy prt_tolerant_access_policy";
			} else {
				if ($defaultOrderColumn == "prt_tolerant_access_policy") {
					$orderColumnNotDisplayed = " prt_portals.prt_tolerant_access_policy ";
				}
			}
			if (P('show_export_user_class_namespace', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_user_class_namespace prt_user_class_namespace";
			} else {
				if ($defaultOrderColumn == "prt_user_class_namespace") {
					$orderColumnNotDisplayed = " prt_portals.prt_user_class_namespace ";
				}
			}
			if (P('show_export_user_class_name', "1") != "0") {
				$queryString = $queryString . ", prt_portals.prt_user_class_name prt_user_class_name";
			} else {
				if ($defaultOrderColumn == "prt_user_class_name") {
					$orderColumnNotDisplayed = " prt_portals.prt_user_class_name ";
				}
			}
			if (class_exists('portal\virgoTemplate') && P('show_export_template', "1") != "0") { // */ && !in_array("tmp", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portals.prt_tmp_id as prt_tmp_id ";
				$queryString = $queryString . ", prt_templates_parent.tmp_virgo_title as `template` ";
			} else {
				if ($defaultOrderColumn == "template") {
					$orderColumnNotDisplayed = " prt_templates_parent.tmp_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portals ";
			if (class_exists('portal\virgoTemplate')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_templates AS prt_templates_parent ON (prt_portals.prt_tmp_id = prt_templates_parent.tmp_id) ";
			}

			$resultsPortal = $resultPortal->select(
				'', 
				'all', 
				$resultPortal->getOrderColumn(), 
				$resultPortal->getOrderMode(), 
				$whereClausePortal,
				$queryString);
			$index = 1;
			foreach ($resultsPortal as $resultPortal) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultPortal['prt_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_name', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortal['prt_name'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_url', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortal['prt_url'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_identifier', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortal['prt_identifier'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_path', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortal['prt_path'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_tolerant_access_policy', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortal['prt_tolerant_access_policy'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_user_class_namespace', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortal['prt_user_class_namespace'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_user_class_name', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortal['prt_user_class_name'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_template', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoTemplate::lookup($resultPortal['prt_tmp_id']);
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
					$propertyColumnHash['name'] = 'prt_name';
					$propertyColumnHash['name'] = 'prt_name';
					$propertyColumnHash['url'] = 'prt_url';
					$propertyColumnHash['url'] = 'prt_url';
					$propertyColumnHash['identifier'] = 'prt_identifier';
					$propertyColumnHash['identifier'] = 'prt_identifier';
					$propertyColumnHash['path'] = 'prt_path';
					$propertyColumnHash['path'] = 'prt_path';
					$propertyColumnHash['tolerant access policy'] = 'prt_tolerant_access_policy';
					$propertyColumnHash['tolerant_access_policy'] = 'prt_tolerant_access_policy';
					$propertyColumnHash['user class namespace'] = 'prt_user_class_namespace';
					$propertyColumnHash['user_class_namespace'] = 'prt_user_class_namespace';
					$propertyColumnHash['user class name'] = 'prt_user_class_name';
					$propertyColumnHash['user_class_name'] = 'prt_user_class_name';
					$propertyClassHash['template'] = 'Template';
					$propertyClassHash['template'] = 'Template';
					$propertyColumnHash['template'] = 'prt_tmp_id';
					$propertyColumnHash['template'] = 'prt_tmp_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importPortal = new virgoPortal();
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
										L(T('PROPERTY_NOT_FOUND', T('PORTAL'), $columns[$index]), '', 'ERROR');
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
										$importPortal->$fieldName = $value;
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
	$importPortal->setTmpId($defaultValue);
}
							$errorMessage = $importPortal->store();
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
				$newPortletLocation->setPrtId($idToDelete);
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
		static function portletActionAddSelectedToNMRecordPortletObject() {
			$portletObjectId = R('plc_portletObject_');
			$idsToDeleteString = R('ids');
			$idsToDelete = split(",", $idsToDeleteString);
			foreach ($idsToDelete as $idToDelete) {
				$newPortletLocation = new virgoPortletLocation();
				$newPortletLocation->setPrtId($idToDelete);
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


		static function portletActionVirgoSetTemplate() {
			$this->loadFromDB();
			$parentId = R('prt_Template_id_' . $_SESSION['current_portlet_object_id']);
			$this->setTmpId($parentId);
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
		static function getCurrentPortal() {
			$path = R('portal_page_path');
			$portalName = R('virgo_portal');
			$portalCondition = (isset($portalName) ? " AND prt_identifier = ? " : " AND prt_identifier IS NULL ");
			$portalConditionType = (isset($portalName) ? "s" : "");
			$portalConditionValue = (isset($portalName) ? array($portalName) : array());
			$url = virgoPage::getServerUrl();
			$query = <<<SQL
SELECT
	prt_id
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
			$ret = QP1($query, "ss".$portalConditionType.$pathType, array_merge(array($url, ""), $portalConditionValue, $pathValue));
			if (isset($ret)) {
				return new virgoPortal($ret);
			}
			return null;
		}

		static function getParameterValue($name, $default = null, $insert = true) {
			$prtId = virgoPortal::getCurrentPortal()->getId();
			$query = <<<SQL
SELECT
	ppr_value
FROM
	prt_portlet_parameters
WHERE 
	ppr_prt_id = ?
	AND ppr_name = ?
SQL;
			$ret = QP1($query, "is", array($prtId, $name));
			if (is_null($ret) && isset($default) && $insert) {
				$par = new virgoPortletParameter();
				$par->setName($name);
				$par->setValue($default);
				$par->setPrtId($prtId);
				LE($par->store());
				$ret = $default;
			}
			return $ret;
		}
		
		static function setParameterValue($name, $value) {
			$prtId = virgoPortal::getCurrentPortal()->getId();
			$query = " SELECT ppr_id FROM prt_portlet_parameters WHERE ppr_prt_id = ? AND ppr_name = ?";
			$rows = QPR($query, "is", array($prtId, $name));
			if (count($rows) == 0) {
				$par = new virgoPortletParameter();
				$par->setName($name);
				$par->setPrtId($prtId);
			} else {
				$row = $rows[0];
				$par = new virgoPortletParameter($row['ppr_id']);
			}
			$par->setValue($value);
			LE($par->store());
		}

		function getPortalUrl() {
			$path = "/" . $this->getPath();
			if ($path == "/") {
				$path = "";
			}
			$identifier = "/" . $this->getIdentifier();
			if ($identifier == "/") {
				$identifier = "";
			}
			$path = $path . $identifier;
			return $path;
		}		


		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `prt_portals` (
  `prt_id` bigint(20) unsigned NOT NULL auto_increment,
  `prt_virgo_state` varchar(50) default NULL,
  `prt_virgo_title` varchar(255) default NULL,
	`prt_tmp_id` int(11) default NULL,
  `prt_name` varchar(255), 
  `prt_url` varchar(255), 
  `prt_identifier` varchar(255), 
  `prt_path` varchar(255), 
  `prt_tolerant_access_policy` boolean,  
  `prt_user_class_namespace` varchar(255), 
  `prt_user_class_name` varchar(255), 
  `prt_date_created` datetime NOT NULL,
  `prt_date_modified` datetime default NULL,
  `prt_usr_created_id` int(11) NOT NULL,
  `prt_usr_modified_id` int(11) default NULL,
  KEY `prt_tmp_fk` (`prt_tmp_id`),
  PRIMARY KEY  (`prt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/portal.sql 
INSERT INTO `prt_portals` (`prt_virgo_title`, `prt_name`, `prt_url`, `prt_identifier`, `prt_path`, `prt_tolerant_access_policy`, `prt_user_class_namespace`, `prt_user_class_name`) 
VALUES (title, some_value, some_value, some_value, some_value, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_portals table already exists.", '', 'FATAL');
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
			return "prt";
		}
		
		static function getPlural() {
			return "portals";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoTemplate";
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoPage";
			$ret[] = "virgoPortletParameter";
			$ret[] = "virgoPortletLocation";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_portals'));
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
			$virgoVersion = virgoPortal::getVirgoVersion();
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
	
	

