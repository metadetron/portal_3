<?php
/**
* Module Unique visit
* @package Portal
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace portal;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	

	class virgoUniqueVisit {

		 var  $uvs_id = null;
		 var  $uvs_timestamp = null;

		 var  $uvs_ip = null;

		 var  $uvs_platform = null;

		 var  $uvs_browser = null;

		 var  $uvs_version = null;

		 var  $uvs_referer = null;

		 var  $uvs_country = null;


		 var   $uvs_date_created = null;
		 var   $uvs_usr_created_id = null;
		 var   $uvs_date_modified = null;
		 var   $uvs_usr_modified_id = null;
		 var   $uvs_virgo_title = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoUniqueVisit();
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
        	$this->uvs_id = null;
		    $this->uvs_date_created = null;
		    $this->uvs_usr_created_id = null;
		    $this->uvs_date_modified = null;
		    $this->uvs_usr_modified_id = null;
		    $this->uvs_virgo_title = null;
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
			return $this->uvs_id;
		}

		function getTimestamp() {
			return $this->uvs_timestamp;
		}
		
		 function setTimestamp($val) {
			$this->uvs_timestamp = $val;
		}
		function getIp() {
			return $this->uvs_ip;
		}
		
		 function setIp($val) {
			$this->uvs_ip = $val;
		}
		function getPlatform() {
			return $this->uvs_platform;
		}
		
		 function setPlatform($val) {
			$this->uvs_platform = $val;
		}
		function getBrowser() {
			return $this->uvs_browser;
		}
		
		 function setBrowser($val) {
			$this->uvs_browser = $val;
		}
		function getVersion() {
			return $this->uvs_version;
		}
		
		 function setVersion($val) {
			$this->uvs_version = $val;
		}
		function getReferer() {
			return $this->uvs_referer;
		}
		
		 function setReferer($val) {
			$this->uvs_referer = $val;
		}
		function getCountry() {
			return $this->uvs_country;
		}
		
		 function setCountry($val) {
			$this->uvs_country = $val;
		}


		function getDateCreated() {
			return $this->uvs_date_created;
		}
		function getUsrCreatedId() {
			return $this->uvs_usr_created_id;
		}
		function getDateModified() {
			return $this->uvs_date_modified;
		}
		function getUsrModifiedId() {
			return $this->uvs_usr_modified_id;
		}



		function loadRecordFromRequest($rowId) {
			$this->uvs_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('uvs_timestamp_' . $this->uvs_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->uvs_timestamp = null;
		} else {
			$this->uvs_timestamp = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('uvs_ip_' . $this->uvs_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->uvs_ip = null;
		} else {
			$this->uvs_ip = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('uvs_platform_' . $this->uvs_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->uvs_platform = null;
		} else {
			$this->uvs_platform = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('uvs_browser_' . $this->uvs_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->uvs_browser = null;
		} else {
			$this->uvs_browser = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('uvs_version_' . $this->uvs_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->uvs_version = null;
		} else {
			$this->uvs_version = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('uvs_referer_' . $this->uvs_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->uvs_referer = null;
		} else {
			$this->uvs_referer = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('uvs_country_' . $this->uvs_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->uvs_country = null;
		} else {
			$this->uvs_country = $tmpValue;
		}
	}
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('uvs_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaUniqueVisit = array();	
			$criteriaFieldUniqueVisit = array();	
			$isNullUniqueVisit = R('virgo_search_timestamp_is_null');
			
			$criteriaFieldUniqueVisit["is_null"] = 0;
			if ($isNullUniqueVisit == "not_null") {
				$criteriaFieldUniqueVisit["is_null"] = 1;
			} elseif ($isNullUniqueVisit == "null") {
				$criteriaFieldUniqueVisit["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_timestamp_from');
		$dataTypeCriteria["to"] = R('virgo_search_timestamp_to');

//			if ($isSet) {
			$criteriaFieldUniqueVisit["value"] = $dataTypeCriteria;
//			}
			$criteriaUniqueVisit["timestamp"] = $criteriaFieldUniqueVisit;
			$criteriaFieldUniqueVisit = array();	
			$isNullUniqueVisit = R('virgo_search_ip_is_null');
			
			$criteriaFieldUniqueVisit["is_null"] = 0;
			if ($isNullUniqueVisit == "not_null") {
				$criteriaFieldUniqueVisit["is_null"] = 1;
			} elseif ($isNullUniqueVisit == "null") {
				$criteriaFieldUniqueVisit["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_ip');

//			if ($isSet) {
			$criteriaFieldUniqueVisit["value"] = $dataTypeCriteria;
//			}
			$criteriaUniqueVisit["ip"] = $criteriaFieldUniqueVisit;
			$criteriaFieldUniqueVisit = array();	
			$isNullUniqueVisit = R('virgo_search_platform_is_null');
			
			$criteriaFieldUniqueVisit["is_null"] = 0;
			if ($isNullUniqueVisit == "not_null") {
				$criteriaFieldUniqueVisit["is_null"] = 1;
			} elseif ($isNullUniqueVisit == "null") {
				$criteriaFieldUniqueVisit["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_platform');

//			if ($isSet) {
			$criteriaFieldUniqueVisit["value"] = $dataTypeCriteria;
//			}
			$criteriaUniqueVisit["platform"] = $criteriaFieldUniqueVisit;
			$criteriaFieldUniqueVisit = array();	
			$isNullUniqueVisit = R('virgo_search_browser_is_null');
			
			$criteriaFieldUniqueVisit["is_null"] = 0;
			if ($isNullUniqueVisit == "not_null") {
				$criteriaFieldUniqueVisit["is_null"] = 1;
			} elseif ($isNullUniqueVisit == "null") {
				$criteriaFieldUniqueVisit["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_browser');

//			if ($isSet) {
			$criteriaFieldUniqueVisit["value"] = $dataTypeCriteria;
//			}
			$criteriaUniqueVisit["browser"] = $criteriaFieldUniqueVisit;
			$criteriaFieldUniqueVisit = array();	
			$isNullUniqueVisit = R('virgo_search_version_is_null');
			
			$criteriaFieldUniqueVisit["is_null"] = 0;
			if ($isNullUniqueVisit == "not_null") {
				$criteriaFieldUniqueVisit["is_null"] = 1;
			} elseif ($isNullUniqueVisit == "null") {
				$criteriaFieldUniqueVisit["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_version');

//			if ($isSet) {
			$criteriaFieldUniqueVisit["value"] = $dataTypeCriteria;
//			}
			$criteriaUniqueVisit["version"] = $criteriaFieldUniqueVisit;
			$criteriaFieldUniqueVisit = array();	
			$isNullUniqueVisit = R('virgo_search_referer_is_null');
			
			$criteriaFieldUniqueVisit["is_null"] = 0;
			if ($isNullUniqueVisit == "not_null") {
				$criteriaFieldUniqueVisit["is_null"] = 1;
			} elseif ($isNullUniqueVisit == "null") {
				$criteriaFieldUniqueVisit["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_referer');

//			if ($isSet) {
			$criteriaFieldUniqueVisit["value"] = $dataTypeCriteria;
//			}
			$criteriaUniqueVisit["referer"] = $criteriaFieldUniqueVisit;
			$criteriaFieldUniqueVisit = array();	
			$isNullUniqueVisit = R('virgo_search_country_is_null');
			
			$criteriaFieldUniqueVisit["is_null"] = 0;
			if ($isNullUniqueVisit == "not_null") {
				$criteriaFieldUniqueVisit["is_null"] = 1;
			} elseif ($isNullUniqueVisit == "null") {
				$criteriaFieldUniqueVisit["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_country');

//			if ($isSet) {
			$criteriaFieldUniqueVisit["value"] = $dataTypeCriteria;
//			}
			$criteriaUniqueVisit["country"] = $criteriaFieldUniqueVisit;
			self::setCriteria($criteriaUniqueVisit);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_timestamp');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterTimestamp', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTimestamp', null);
			}
			$tableFilter = R('virgo_filter_ip');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterIp', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterIp', null);
			}
			$tableFilter = R('virgo_filter_platform');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterPlatform', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterPlatform', null);
			}
			$tableFilter = R('virgo_filter_browser');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterBrowser', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterBrowser', null);
			}
			$tableFilter = R('virgo_filter_version');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterVersion', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterVersion', null);
			}
			$tableFilter = R('virgo_filter_referer');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterReferer', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterReferer', null);
			}
			$tableFilter = R('virgo_filter_country');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterCountry', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterCountry', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseUniqueVisit = ' 1 = 1 ';
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
				$eventColumn = "uvs_" . P('event_column');
				$whereClauseUniqueVisit = $whereClauseUniqueVisit . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseUniqueVisit = $whereClauseUniqueVisit . ' AND ' . $parentContextInfo['condition'];
			}
			$filter = "";
			$criteriaUniqueVisit = self::getCriteria();
			if (isset($criteriaUniqueVisit["timestamp"])) {
				$fieldCriteriaTimestamp = $criteriaUniqueVisit["timestamp"];
				if ($fieldCriteriaTimestamp["is_null"] == 1) {
$filter = $filter . ' AND prt_unique_visits.uvs_timestamp IS NOT NULL ';
				} elseif ($fieldCriteriaTimestamp["is_null"] == 2) {
$filter = $filter . ' AND prt_unique_visits.uvs_timestamp IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaTimestamp["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND prt_unique_visits.uvs_timestamp >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_unique_visits.uvs_timestamp <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaUniqueVisit["ip"])) {
				$fieldCriteriaIp = $criteriaUniqueVisit["ip"];
				if ($fieldCriteriaIp["is_null"] == 1) {
$filter = $filter . ' AND prt_unique_visits.uvs_ip IS NOT NULL ';
				} elseif ($fieldCriteriaIp["is_null"] == 2) {
$filter = $filter . ' AND prt_unique_visits.uvs_ip IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaIp["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_unique_visits.uvs_ip like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUniqueVisit["platform"])) {
				$fieldCriteriaPlatform = $criteriaUniqueVisit["platform"];
				if ($fieldCriteriaPlatform["is_null"] == 1) {
$filter = $filter . ' AND prt_unique_visits.uvs_platform IS NOT NULL ';
				} elseif ($fieldCriteriaPlatform["is_null"] == 2) {
$filter = $filter . ' AND prt_unique_visits.uvs_platform IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaPlatform["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_unique_visits.uvs_platform like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUniqueVisit["browser"])) {
				$fieldCriteriaBrowser = $criteriaUniqueVisit["browser"];
				if ($fieldCriteriaBrowser["is_null"] == 1) {
$filter = $filter . ' AND prt_unique_visits.uvs_browser IS NOT NULL ';
				} elseif ($fieldCriteriaBrowser["is_null"] == 2) {
$filter = $filter . ' AND prt_unique_visits.uvs_browser IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaBrowser["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_unique_visits.uvs_browser like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUniqueVisit["version"])) {
				$fieldCriteriaVersion = $criteriaUniqueVisit["version"];
				if ($fieldCriteriaVersion["is_null"] == 1) {
$filter = $filter . ' AND prt_unique_visits.uvs_version IS NOT NULL ';
				} elseif ($fieldCriteriaVersion["is_null"] == 2) {
$filter = $filter . ' AND prt_unique_visits.uvs_version IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaVersion["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_unique_visits.uvs_version like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUniqueVisit["referer"])) {
				$fieldCriteriaReferer = $criteriaUniqueVisit["referer"];
				if ($fieldCriteriaReferer["is_null"] == 1) {
$filter = $filter . ' AND prt_unique_visits.uvs_referer IS NOT NULL ';
				} elseif ($fieldCriteriaReferer["is_null"] == 2) {
$filter = $filter . ' AND prt_unique_visits.uvs_referer IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaReferer["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_unique_visits.uvs_referer like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUniqueVisit["country"])) {
				$fieldCriteriaCountry = $criteriaUniqueVisit["country"];
				if ($fieldCriteriaCountry["is_null"] == 1) {
$filter = $filter . ' AND prt_unique_visits.uvs_country IS NOT NULL ';
				} elseif ($fieldCriteriaCountry["is_null"] == 2) {
$filter = $filter . ' AND prt_unique_visits.uvs_country IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaCountry["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_unique_visits.uvs_country like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			$whereClauseUniqueVisit = $whereClauseUniqueVisit . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseUniqueVisit = $whereClauseUniqueVisit . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseUniqueVisit = $whereClauseUniqueVisit . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterTimestamp', null);
				if (S($tableFilter)) {
					$whereClauseUniqueVisit = $whereClauseUniqueVisit . " AND uvs_timestamp LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterIp', null);
				if (S($tableFilter)) {
					$whereClauseUniqueVisit = $whereClauseUniqueVisit . " AND uvs_ip LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterPlatform', null);
				if (S($tableFilter)) {
					$whereClauseUniqueVisit = $whereClauseUniqueVisit . " AND uvs_platform LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterBrowser', null);
				if (S($tableFilter)) {
					$whereClauseUniqueVisit = $whereClauseUniqueVisit . " AND uvs_browser LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterVersion', null);
				if (S($tableFilter)) {
					$whereClauseUniqueVisit = $whereClauseUniqueVisit . " AND uvs_version LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterReferer', null);
				if (S($tableFilter)) {
					$whereClauseUniqueVisit = $whereClauseUniqueVisit . " AND uvs_referer LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterCountry', null);
				if (S($tableFilter)) {
					$whereClauseUniqueVisit = $whereClauseUniqueVisit . " AND uvs_country LIKE '%{$tableFilter}%' ";
				}
			}
			return $whereClauseUniqueVisit;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseUniqueVisit = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_unique_visits.uvs_id, prt_unique_visits.uvs_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_timestamp', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_timestamp uvs_timestamp";
			} else {
				if ($defaultOrderColumn == "uvs_timestamp") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_timestamp ";
				}
			}
			if (P('show_table_ip', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_ip uvs_ip";
			} else {
				if ($defaultOrderColumn == "uvs_ip") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_ip ";
				}
			}
			if (P('show_table_platform', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_platform uvs_platform";
			} else {
				if ($defaultOrderColumn == "uvs_platform") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_platform ";
				}
			}
			if (P('show_table_browser', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_browser uvs_browser";
			} else {
				if ($defaultOrderColumn == "uvs_browser") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_browser ";
				}
			}
			if (P('show_table_version', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_version uvs_version";
			} else {
				if ($defaultOrderColumn == "uvs_version") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_version ";
				}
			}
			if (P('show_table_referer', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_referer uvs_referer";
			} else {
				if ($defaultOrderColumn == "uvs_referer") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_referer ";
				}
			}
			if (P('show_table_country', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_country uvs_country";
			} else {
				if ($defaultOrderColumn == "uvs_country") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_country ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_unique_visits ";

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseUniqueVisit = $whereClauseUniqueVisit . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseUniqueVisit, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseUniqueVisit,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_unique_visits"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " uvs_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " uvs_usr_created_id = ? ";
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
				. "\n FROM prt_unique_visits"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_unique_visits ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_unique_visits ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, uvs_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " uvs_usr_created_id = ? ";
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
				$query = "SELECT COUNT(uvs_id) cnt FROM unique_visits";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as unique_visits ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as unique_visits ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoUniqueVisit();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_unique_visits WHERE uvs_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->uvs_id = $row['uvs_id'];
$this->uvs_timestamp = $row['uvs_timestamp'];
$this->uvs_ip = $row['uvs_ip'];
$this->uvs_platform = $row['uvs_platform'];
$this->uvs_browser = $row['uvs_browser'];
$this->uvs_version = $row['uvs_version'];
$this->uvs_referer = $row['uvs_referer'];
$this->uvs_country = $row['uvs_country'];
						if ($fetchUsernames) {
							if ($row['uvs_date_created']) {
								if ($row['uvs_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['uvs_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['uvs_date_modified']) {
								if ($row['uvs_usr_modified_id'] == $row['uvs_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['uvs_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['uvs_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->uvs_date_created = $row['uvs_date_created'];
						$this->uvs_usr_created_id = $fetchUsernames ? $createdBy : $row['uvs_usr_created_id'];
						$this->uvs_date_modified = $row['uvs_date_modified'];
						$this->uvs_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['uvs_usr_modified_id'];
						$this->uvs_virgo_title = $row['uvs_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_unique_visits SET uvs_usr_created_id = {$userId} WHERE uvs_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->uvs_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoUniqueVisit::selectAllAsObjectsStatic('uvs_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->uvs_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->uvs_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('uvs_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_uvs = new virgoUniqueVisit();
				$tmp_uvs->load((int)$lookup_id);
				return $tmp_uvs->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoUniqueVisit');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" uvs_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoUniqueVisit', "10");
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
				$query = $query . " uvs_id as id, uvs_virgo_title as title ";
			}
			$query = $query . " FROM prt_unique_visits ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoUniqueVisit', 'portal') == "1") {
				$privateCondition = " uvs_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY uvs_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resUniqueVisit = array();
				foreach ($rows as $row) {
					$resUniqueVisit[$row['id']] = $row['title'];
				}
				return $resUniqueVisit;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticUniqueVisit = new virgoUniqueVisit();
			return $staticUniqueVisit->getVirgoList($where, $sizeOnly, $hash);
		}
		


		function validateObject($virgoOld) {
			if (
(is_null($this->getTimestamp()) || trim($this->getTimestamp()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'TIMESTAMP');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_ip_obligatory', "0") == "1") {
				if (
(is_null($this->getIp()) || trim($this->getIp()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'IP');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_platform_obligatory', "0") == "1") {
				if (
(is_null($this->getPlatform()) || trim($this->getPlatform()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'PLATFORM');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_browser_obligatory', "0") == "1") {
				if (
(is_null($this->getBrowser()) || trim($this->getBrowser()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'BROWSER');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_version_obligatory', "0") == "1") {
				if (
(is_null($this->getVersion()) || trim($this->getVersion()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'VERSION');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_referer_obligatory', "0") == "1") {
				if (
(is_null($this->getReferer()) || trim($this->getReferer()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'REFERER');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_country_obligatory', "0") == "1") {
				if (
(is_null($this->getCountry()) || trim($this->getCountry()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'COUNTRY');
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_unique_visits WHERE uvs_id = " . $this->getId();
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
				$colNames = $colNames . ", uvs_timestamp";
				$values = $values . ", " . (is_null($objectToStore->getTimestamp()) ? "null" : "'" . QE($objectToStore->getTimestamp()) . "'");
				$colNames = $colNames . ", uvs_ip";
				$values = $values . ", " . (is_null($objectToStore->getIp()) ? "null" : "'" . QE($objectToStore->getIp()) . "'");
				$colNames = $colNames . ", uvs_platform";
				$values = $values . ", " . (is_null($objectToStore->getPlatform()) ? "null" : "'" . QE($objectToStore->getPlatform()) . "'");
				$colNames = $colNames . ", uvs_browser";
				$values = $values . ", " . (is_null($objectToStore->getBrowser()) ? "null" : "'" . QE($objectToStore->getBrowser()) . "'");
				$colNames = $colNames . ", uvs_version";
				$values = $values . ", " . (is_null($objectToStore->getVersion()) ? "null" : "'" . QE($objectToStore->getVersion()) . "'");
				$colNames = $colNames . ", uvs_referer";
				$values = $values . ", " . (is_null($objectToStore->getReferer()) ? "null" : "'" . QE($objectToStore->getReferer()) . "'");
				$colNames = $colNames . ", uvs_country";
				$values = $values . ", " . (is_null($objectToStore->getCountry()) ? "null" : "'" . QE($objectToStore->getCountry()) . "'");
				$query = "INSERT INTO prt_history_unique_visits (revision, ip, username, user_id, timestamp, uvs_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getTimestamp() != $objectToStore->getTimestamp()) {
				if (is_null($objectToStore->getTimestamp())) {
					$nullifiedProperties = $nullifiedProperties . "timestamp,";
				} else {
				$colNames = $colNames . ", uvs_timestamp";
				$values = $values . ", " . (is_null($objectToStore->getTimestamp()) ? "null" : "'" . QE($objectToStore->getTimestamp()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getIp() != $objectToStore->getIp()) {
				if (is_null($objectToStore->getIp())) {
					$nullifiedProperties = $nullifiedProperties . "ip,";
				} else {
				$colNames = $colNames . ", uvs_ip";
				$values = $values . ", " . (is_null($objectToStore->getIp()) ? "null" : "'" . QE($objectToStore->getIp()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getPlatform() != $objectToStore->getPlatform()) {
				if (is_null($objectToStore->getPlatform())) {
					$nullifiedProperties = $nullifiedProperties . "platform,";
				} else {
				$colNames = $colNames . ", uvs_platform";
				$values = $values . ", " . (is_null($objectToStore->getPlatform()) ? "null" : "'" . QE($objectToStore->getPlatform()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getBrowser() != $objectToStore->getBrowser()) {
				if (is_null($objectToStore->getBrowser())) {
					$nullifiedProperties = $nullifiedProperties . "browser,";
				} else {
				$colNames = $colNames . ", uvs_browser";
				$values = $values . ", " . (is_null($objectToStore->getBrowser()) ? "null" : "'" . QE($objectToStore->getBrowser()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getVersion() != $objectToStore->getVersion()) {
				if (is_null($objectToStore->getVersion())) {
					$nullifiedProperties = $nullifiedProperties . "version,";
				} else {
				$colNames = $colNames . ", uvs_version";
				$values = $values . ", " . (is_null($objectToStore->getVersion()) ? "null" : "'" . QE($objectToStore->getVersion()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getReferer() != $objectToStore->getReferer()) {
				if (is_null($objectToStore->getReferer())) {
					$nullifiedProperties = $nullifiedProperties . "referer,";
				} else {
				$colNames = $colNames . ", uvs_referer";
				$values = $values . ", " . (is_null($objectToStore->getReferer()) ? "null" : "'" . QE($objectToStore->getReferer()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getCountry() != $objectToStore->getCountry()) {
				if (is_null($objectToStore->getCountry())) {
					$nullifiedProperties = $nullifiedProperties . "country,";
				} else {
				$colNames = $colNames . ", uvs_country";
				$values = $values . ", " . (is_null($objectToStore->getCountry()) ? "null" : "'" . QE($objectToStore->getCountry()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			$query = "INSERT INTO prt_history_unique_visits (revision, ip, username, user_id, timestamp, uvs_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_unique_visits");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'uvs_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_unique_visits ADD COLUMN (uvs_virgo_title VARCHAR(255));";
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
			if (isset($this->uvs_id) && $this->uvs_id != "") {
				$query = "UPDATE prt_unique_visits SET ";
			if (isset($this->uvs_timestamp)) {
				$query .= " uvs_timestamp = ? ,";
				$types .= "s";
				$values[] = $this->uvs_timestamp;
			} else {
				$query .= " uvs_timestamp = NULL ,";				
			}
			if (isset($this->uvs_ip)) {
				$query .= " uvs_ip = ? ,";
				$types .= "s";
				$values[] = $this->uvs_ip;
			} else {
				$query .= " uvs_ip = NULL ,";				
			}
			if (isset($this->uvs_platform)) {
				$query .= " uvs_platform = ? ,";
				$types .= "s";
				$values[] = $this->uvs_platform;
			} else {
				$query .= " uvs_platform = NULL ,";				
			}
			if (isset($this->uvs_browser)) {
				$query .= " uvs_browser = ? ,";
				$types .= "s";
				$values[] = $this->uvs_browser;
			} else {
				$query .= " uvs_browser = NULL ,";				
			}
			if (isset($this->uvs_version)) {
				$query .= " uvs_version = ? ,";
				$types .= "s";
				$values[] = $this->uvs_version;
			} else {
				$query .= " uvs_version = NULL ,";				
			}
			if (isset($this->uvs_referer)) {
				$query .= " uvs_referer = ? ,";
				$types .= "s";
				$values[] = $this->uvs_referer;
			} else {
				$query .= " uvs_referer = NULL ,";				
			}
			if (isset($this->uvs_country)) {
				$query .= " uvs_country = ? ,";
				$types .= "s";
				$values[] = $this->uvs_country;
			} else {
				$query .= " uvs_country = NULL ,";				
			}
				$query = $query . " uvs_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " uvs_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->uvs_date_modified;

				$query = $query . " uvs_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->uvs_usr_modified_id;

				$query = $query . " WHERE uvs_id = ? ";
				$types = $types . "i";
				$values[] = $this->uvs_id;
			} else {
				$query = "INSERT INTO prt_unique_visits ( ";
			$query = $query . " uvs_timestamp, ";
			$query = $query . " uvs_ip, ";
			$query = $query . " uvs_platform, ";
			$query = $query . " uvs_browser, ";
			$query = $query . " uvs_version, ";
			$query = $query . " uvs_referer, ";
			$query = $query . " uvs_country, ";
				$query = $query . " uvs_virgo_title, uvs_date_created, uvs_usr_created_id) VALUES ( ";
			if (isset($this->uvs_timestamp)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->uvs_timestamp;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->uvs_ip)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->uvs_ip;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->uvs_platform)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->uvs_platform;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->uvs_browser)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->uvs_browser;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->uvs_version)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->uvs_version;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->uvs_referer)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->uvs_referer;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->uvs_country)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->uvs_country;
			} else {
				$query .= " NULL ,";				
			}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->uvs_date_created;
				$values[] = $this->uvs_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->uvs_id) || $this->uvs_id == "") {
					$this->uvs_id = QID();
				}
				if ($log) {
					L("unique visit stored successfully", "id = {$this->uvs_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->uvs_id) {
				$virgoOld = new virgoUniqueVisit($this->uvs_id);
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
					if ($this->uvs_id) {			
						$this->uvs_date_modified = date("Y-m-d H:i:s");
						$this->uvs_usr_modified_id = $userId;
					} else {
						$this->uvs_date_created = date("Y-m-d H:i:s");
						$this->uvs_usr_created_id = $userId;
					}
					$this->uvs_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "unique visit" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "unique visit" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM prt_unique_visits WHERE uvs_id = {$this->uvs_id}";
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
			$tmp = new virgoUniqueVisit();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT uvs_id as id FROM prt_unique_visits";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'uvs_order_column')) {
				$orderBy = " ORDER BY uvs_order_column ASC ";
			} 
			if (property_exists($this, 'uvs_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY uvs_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoUniqueVisit();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoUniqueVisit($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_unique_visits SET uvs_virgo_title = '$title' WHERE uvs_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoUniqueVisit();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" uvs_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['uvs_id'];
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
			virgoUniqueVisit::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoUniqueVisit::setSessionValue('Portal_UniqueVisit-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoUniqueVisit::getSessionValue('Portal_UniqueVisit-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoUniqueVisit::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoUniqueVisit::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoUniqueVisit::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoUniqueVisit::getSessionValue('GLOBAL', $name, $default);
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
			$context['uvs_id'] = $id;
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
			$context['uvs_id'] = null;
			virgoUniqueVisit::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoUniqueVisit::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoUniqueVisit::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoUniqueVisit::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoUniqueVisit::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoUniqueVisit::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoUniqueVisit::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoUniqueVisit::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoUniqueVisit::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoUniqueVisit::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoUniqueVisit::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoUniqueVisit::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoUniqueVisit::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoUniqueVisit::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoUniqueVisit::setRemoteSessionValue('ContextId', $contextId, $menuItem);
		}		

		static function getCustomDisplayMode() {
			$result = null;
			if (P("chart_mode", "0") == "1") {
				$result = "CHART";
			}

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
				return virgoUniqueVisit::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoUniqueVisit::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "uvs_id";
			}
			return virgoUniqueVisit::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoUniqueVisit::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoUniqueVisit::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoUniqueVisit::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoUniqueVisit::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoUniqueVisit::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoUniqueVisit::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoUniqueVisit::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoUniqueVisit::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoUniqueVisit::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoUniqueVisit::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoUniqueVisit::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoUniqueVisit::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->uvs_id) {
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
						L(T('STORED_CORRECTLY', 'UNIQUE_VISIT'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'timestamp', $this->uvs_timestamp);
						$fieldValues = $fieldValues . T($fieldValue, 'ip', $this->uvs_ip);
						$fieldValues = $fieldValues . T($fieldValue, 'platform', $this->uvs_platform);
						$fieldValues = $fieldValues . T($fieldValue, 'browser', $this->uvs_browser);
						$fieldValues = $fieldValues . T($fieldValue, 'version', $this->uvs_version);
						$fieldValues = $fieldValues . T($fieldValue, 'referer', $this->uvs_referer);
						$fieldValues = $fieldValues . T($fieldValue, 'country', $this->uvs_country);
						$username = '';
						if ($this->uvs_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->uvs_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->uvs_date_created);
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
			$instance = new virgoUniqueVisit();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUniqueVisit'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			$tmpId = intval(R('uvs_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoUniqueVisit::getContextId();
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
			$this->uvs_id = null;
			$this->uvs_date_created = null;
			$this->uvs_usr_created_id = null;
			$this->uvs_date_modified = null;
			$this->uvs_usr_modified_id = null;
			$this->uvs_virgo_title = null;
			
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



		static function portletActionAdd() {
			$portletObject = self::getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("add")) {
			self::removeFromContext();
			self::setDisplayMode("CREATE");
//			$ret = new virgoUniqueVisit();
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
				$instance = new virgoUniqueVisit();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoUniqueVisit::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'UNIQUE_VISIT'), '', 'INFO');
					return 0;
					
				} else {
					L($res, '', 'ERROR');
					return -1;
				}
			}
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
				$resultUniqueVisit = new virgoUniqueVisit();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultUniqueVisit->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultUniqueVisit->load($idToEditInt);
					} else {
						$resultUniqueVisit->uvs_id = 0;
					}
				}
				$results[] = $resultUniqueVisit;
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
				$result = new virgoUniqueVisit();
				$result->loadFromRequest($idToStore);
				if ($result->uvs_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->uvs_id == 0) {
						$result->uvs_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->uvs_id)) {
							$result->uvs_id = 0;
						}
						$idsToCorrect[$result->uvs_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'UNIQUE_VISITS'), '', 'INFO');
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
			$resultUniqueVisit = new virgoUniqueVisit();
			foreach ($idsToDelete as $idToDelete) {
				$resultUniqueVisit->load((int)trim($idToDelete));
				$res = $resultUniqueVisit->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'UNIQUE_VISITS'), '', 'INFO');			
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
		$ret = $this->uvs_ip;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoUniqueVisit');
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
    			$ret["customDisplayMode/unique_visit.php"] = "<b>2013-09-09</b> <span style='font-size: 0.78em;'>11:15:04</span>";
			return $ret;
		}
		
		function updateTitle() {
			$val = $this->getVirgoTitle(); 
			if (!is_null($val) && trim($val) != "") {
				$query = "UPDATE prt_unique_visits SET uvs_virgo_title = ? WHERE uvs_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT uvs_id AS id FROM prt_unique_visits ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoUniqueVisit($row['id']);
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
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'prt_unique_visits.uvs_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_unique_visits.uvs_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_unique_visits.uvs_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_unique_visits.uvs_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoUniqueVisit!', '', 'ERROR');
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
			$pdf->SetTitle('Unique visits report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('UNIQUE_VISITS');
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
			if (P('show_pdf_timestamp', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_ip', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_platform', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_browser', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_version', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_referer', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_country', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultUniqueVisit = new virgoUniqueVisit();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_timestamp', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Timestamp');
				$minWidth['timestamp'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['timestamp']) {
						$minWidth['timestamp'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_ip', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Ip');
				$minWidth['ip'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['ip']) {
						$minWidth['ip'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_platform', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Platform');
				$minWidth['platform'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['platform']) {
						$minWidth['platform'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_browser', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Browser');
				$minWidth['browser'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['browser']) {
						$minWidth['browser'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_version', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Version');
				$minWidth['version'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['version']) {
						$minWidth['version'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_referer', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Referer');
				$minWidth['referer'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['referer']) {
						$minWidth['referer'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_country', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Country');
				$minWidth['country'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['country']) {
						$minWidth['country'] = min($tmpLen, $maxWidth);
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
			$whereClauseUniqueVisit = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseUniqueVisit = $whereClauseUniqueVisit . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaUniqueVisit = $resultUniqueVisit->getCriteria();
			$fieldCriteriaTimestamp = $criteriaUniqueVisit["timestamp"];
			if ($fieldCriteriaTimestamp["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Timestamp', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaTimestamp["value"];
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
					$pdf->MultiCell(60, 100, 'Timestamp', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaIp = $criteriaUniqueVisit["ip"];
			if ($fieldCriteriaIp["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Ip', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaIp["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Ip', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaPlatform = $criteriaUniqueVisit["platform"];
			if ($fieldCriteriaPlatform["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Platform', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaPlatform["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Platform', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaBrowser = $criteriaUniqueVisit["browser"];
			if ($fieldCriteriaBrowser["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Browser', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaBrowser["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Browser', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaVersion = $criteriaUniqueVisit["version"];
			if ($fieldCriteriaVersion["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Version', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaVersion["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Version', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaReferer = $criteriaUniqueVisit["referer"];
			if ($fieldCriteriaReferer["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Referer', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaReferer["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Referer', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaCountry = $criteriaUniqueVisit["country"];
			if ($fieldCriteriaCountry["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Country', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaCountry["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Country', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$filter = "";
			$criteriaUniqueVisit = self::getCriteria();
			if (isset($criteriaUniqueVisit["timestamp"])) {
				$fieldCriteriaTimestamp = $criteriaUniqueVisit["timestamp"];
				if ($fieldCriteriaTimestamp["is_null"] == 1) {
$filter = $filter . ' AND prt_unique_visits.uvs_timestamp IS NOT NULL ';
				} elseif ($fieldCriteriaTimestamp["is_null"] == 2) {
$filter = $filter . ' AND prt_unique_visits.uvs_timestamp IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaTimestamp["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND prt_unique_visits.uvs_timestamp >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_unique_visits.uvs_timestamp <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaUniqueVisit["ip"])) {
				$fieldCriteriaIp = $criteriaUniqueVisit["ip"];
				if ($fieldCriteriaIp["is_null"] == 1) {
$filter = $filter . ' AND prt_unique_visits.uvs_ip IS NOT NULL ';
				} elseif ($fieldCriteriaIp["is_null"] == 2) {
$filter = $filter . ' AND prt_unique_visits.uvs_ip IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaIp["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_unique_visits.uvs_ip like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUniqueVisit["platform"])) {
				$fieldCriteriaPlatform = $criteriaUniqueVisit["platform"];
				if ($fieldCriteriaPlatform["is_null"] == 1) {
$filter = $filter . ' AND prt_unique_visits.uvs_platform IS NOT NULL ';
				} elseif ($fieldCriteriaPlatform["is_null"] == 2) {
$filter = $filter . ' AND prt_unique_visits.uvs_platform IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaPlatform["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_unique_visits.uvs_platform like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUniqueVisit["browser"])) {
				$fieldCriteriaBrowser = $criteriaUniqueVisit["browser"];
				if ($fieldCriteriaBrowser["is_null"] == 1) {
$filter = $filter . ' AND prt_unique_visits.uvs_browser IS NOT NULL ';
				} elseif ($fieldCriteriaBrowser["is_null"] == 2) {
$filter = $filter . ' AND prt_unique_visits.uvs_browser IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaBrowser["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_unique_visits.uvs_browser like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUniqueVisit["version"])) {
				$fieldCriteriaVersion = $criteriaUniqueVisit["version"];
				if ($fieldCriteriaVersion["is_null"] == 1) {
$filter = $filter . ' AND prt_unique_visits.uvs_version IS NOT NULL ';
				} elseif ($fieldCriteriaVersion["is_null"] == 2) {
$filter = $filter . ' AND prt_unique_visits.uvs_version IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaVersion["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_unique_visits.uvs_version like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUniqueVisit["referer"])) {
				$fieldCriteriaReferer = $criteriaUniqueVisit["referer"];
				if ($fieldCriteriaReferer["is_null"] == 1) {
$filter = $filter . ' AND prt_unique_visits.uvs_referer IS NOT NULL ';
				} elseif ($fieldCriteriaReferer["is_null"] == 2) {
$filter = $filter . ' AND prt_unique_visits.uvs_referer IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaReferer["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_unique_visits.uvs_referer like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUniqueVisit["country"])) {
				$fieldCriteriaCountry = $criteriaUniqueVisit["country"];
				if ($fieldCriteriaCountry["is_null"] == 1) {
$filter = $filter . ' AND prt_unique_visits.uvs_country IS NOT NULL ';
				} elseif ($fieldCriteriaCountry["is_null"] == 2) {
$filter = $filter . ' AND prt_unique_visits.uvs_country IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaCountry["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_unique_visits.uvs_country like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			$whereClauseUniqueVisit = $whereClauseUniqueVisit . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseUniqueVisit = $whereClauseUniqueVisit . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_unique_visits.uvs_id, prt_unique_visits.uvs_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_timestamp', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_timestamp uvs_timestamp";
			} else {
				if ($defaultOrderColumn == "uvs_timestamp") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_timestamp ";
				}
			}
			if (P('show_pdf_ip', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_ip uvs_ip";
			} else {
				if ($defaultOrderColumn == "uvs_ip") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_ip ";
				}
			}
			if (P('show_pdf_platform', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_platform uvs_platform";
			} else {
				if ($defaultOrderColumn == "uvs_platform") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_platform ";
				}
			}
			if (P('show_pdf_browser', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_browser uvs_browser";
			} else {
				if ($defaultOrderColumn == "uvs_browser") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_browser ";
				}
			}
			if (P('show_pdf_version', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_version uvs_version";
			} else {
				if ($defaultOrderColumn == "uvs_version") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_version ";
				}
			}
			if (P('show_pdf_referer', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_referer uvs_referer";
			} else {
				if ($defaultOrderColumn == "uvs_referer") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_referer ";
				}
			}
			if (P('show_pdf_country', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_country uvs_country";
			} else {
				if ($defaultOrderColumn == "uvs_country") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_country ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_unique_visits ";

		$resultsUniqueVisit = $resultUniqueVisit->select(
			'', 
			'all', 
			$resultUniqueVisit->getOrderColumn(), 
			$resultUniqueVisit->getOrderMode(), 
			$whereClauseUniqueVisit,
			$queryString);
		
		foreach ($resultsUniqueVisit as $resultUniqueVisit) {

			if (P('show_pdf_timestamp', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUniqueVisit['uvs_timestamp'])) + 6;
				if ($tmpLen > $minWidth['timestamp']) {
					$minWidth['timestamp'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_ip', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUniqueVisit['uvs_ip'])) + 6;
				if ($tmpLen > $minWidth['ip']) {
					$minWidth['ip'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_platform', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUniqueVisit['uvs_platform'])) + 6;
				if ($tmpLen > $minWidth['platform']) {
					$minWidth['platform'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_browser', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUniqueVisit['uvs_browser'])) + 6;
				if ($tmpLen > $minWidth['browser']) {
					$minWidth['browser'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_version', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUniqueVisit['uvs_version'])) + 6;
				if ($tmpLen > $minWidth['version']) {
					$minWidth['version'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_referer', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUniqueVisit['uvs_referer'])) + 6;
				if ($tmpLen > $minWidth['referer']) {
					$minWidth['referer'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_country', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUniqueVisit['uvs_country'])) + 6;
				if ($tmpLen > $minWidth['country']) {
					$minWidth['country'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaUniqueVisit = $resultUniqueVisit->getCriteria();
		if (is_null($criteriaUniqueVisit) || sizeof($criteriaUniqueVisit) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																										if (P('show_pdf_timestamp', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['timestamp'], $colHeight, T('TIMESTAMP'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_ip', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['ip'], $colHeight, T('IP'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_platform', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['platform'], $colHeight, T('PLATFORM'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_browser', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['browser'], $colHeight, T('BROWSER'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_version', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['version'], $colHeight, T('VERSION'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_referer', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['referer'], $colHeight, T('REFERER'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_country', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['country'], $colHeight, T('COUNTRY'), 'T', 'C', 0, 0);
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
		foreach ($resultsUniqueVisit as $resultUniqueVisit) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_timestamp', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['timestamp'], $colHeight, '' . $resultUniqueVisit['uvs_timestamp'], 'T', 'L', 0, 0);
				if (P('show_pdf_timestamp', "1") == "2") {
										if (!is_null($resultUniqueVisit['uvs_timestamp'])) {
						$tmpCount = (float)$counts["timestamp"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["timestamp"] = $tmpCount;
					}
				}
				if (P('show_pdf_timestamp', "1") == "3") {
										if (!is_null($resultUniqueVisit['uvs_timestamp'])) {
						$tmpSum = (float)$sums["timestamp"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUniqueVisit['uvs_timestamp'];
						}
						$sums["timestamp"] = $tmpSum;
					}
				}
				if (P('show_pdf_timestamp', "1") == "4") {
										if (!is_null($resultUniqueVisit['uvs_timestamp'])) {
						$tmpCount = (float)$avgCounts["timestamp"];
						$tmpSum = (float)$avgSums["timestamp"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["timestamp"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUniqueVisit['uvs_timestamp'];
						}
						$avgSums["timestamp"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_ip', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['ip'], $colHeight, '' . $resultUniqueVisit['uvs_ip'], 'T', 'L', 0, 0);
				if (P('show_pdf_ip', "1") == "2") {
										if (!is_null($resultUniqueVisit['uvs_ip'])) {
						$tmpCount = (float)$counts["ip"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["ip"] = $tmpCount;
					}
				}
				if (P('show_pdf_ip', "1") == "3") {
										if (!is_null($resultUniqueVisit['uvs_ip'])) {
						$tmpSum = (float)$sums["ip"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUniqueVisit['uvs_ip'];
						}
						$sums["ip"] = $tmpSum;
					}
				}
				if (P('show_pdf_ip', "1") == "4") {
										if (!is_null($resultUniqueVisit['uvs_ip'])) {
						$tmpCount = (float)$avgCounts["ip"];
						$tmpSum = (float)$avgSums["ip"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["ip"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUniqueVisit['uvs_ip'];
						}
						$avgSums["ip"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_platform', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['platform'], $colHeight, '' . $resultUniqueVisit['uvs_platform'], 'T', 'L', 0, 0);
				if (P('show_pdf_platform', "1") == "2") {
										if (!is_null($resultUniqueVisit['uvs_platform'])) {
						$tmpCount = (float)$counts["platform"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["platform"] = $tmpCount;
					}
				}
				if (P('show_pdf_platform', "1") == "3") {
										if (!is_null($resultUniqueVisit['uvs_platform'])) {
						$tmpSum = (float)$sums["platform"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUniqueVisit['uvs_platform'];
						}
						$sums["platform"] = $tmpSum;
					}
				}
				if (P('show_pdf_platform', "1") == "4") {
										if (!is_null($resultUniqueVisit['uvs_platform'])) {
						$tmpCount = (float)$avgCounts["platform"];
						$tmpSum = (float)$avgSums["platform"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["platform"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUniqueVisit['uvs_platform'];
						}
						$avgSums["platform"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_browser', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['browser'], $colHeight, '' . $resultUniqueVisit['uvs_browser'], 'T', 'L', 0, 0);
				if (P('show_pdf_browser', "1") == "2") {
										if (!is_null($resultUniqueVisit['uvs_browser'])) {
						$tmpCount = (float)$counts["browser"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["browser"] = $tmpCount;
					}
				}
				if (P('show_pdf_browser', "1") == "3") {
										if (!is_null($resultUniqueVisit['uvs_browser'])) {
						$tmpSum = (float)$sums["browser"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUniqueVisit['uvs_browser'];
						}
						$sums["browser"] = $tmpSum;
					}
				}
				if (P('show_pdf_browser', "1") == "4") {
										if (!is_null($resultUniqueVisit['uvs_browser'])) {
						$tmpCount = (float)$avgCounts["browser"];
						$tmpSum = (float)$avgSums["browser"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["browser"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUniqueVisit['uvs_browser'];
						}
						$avgSums["browser"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_version', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['version'], $colHeight, '' . $resultUniqueVisit['uvs_version'], 'T', 'L', 0, 0);
				if (P('show_pdf_version', "1") == "2") {
										if (!is_null($resultUniqueVisit['uvs_version'])) {
						$tmpCount = (float)$counts["version"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["version"] = $tmpCount;
					}
				}
				if (P('show_pdf_version', "1") == "3") {
										if (!is_null($resultUniqueVisit['uvs_version'])) {
						$tmpSum = (float)$sums["version"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUniqueVisit['uvs_version'];
						}
						$sums["version"] = $tmpSum;
					}
				}
				if (P('show_pdf_version', "1") == "4") {
										if (!is_null($resultUniqueVisit['uvs_version'])) {
						$tmpCount = (float)$avgCounts["version"];
						$tmpSum = (float)$avgSums["version"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["version"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUniqueVisit['uvs_version'];
						}
						$avgSums["version"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_referer', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['referer'], $colHeight, '' . $resultUniqueVisit['uvs_referer'], 'T', 'L', 0, 0);
				if (P('show_pdf_referer', "1") == "2") {
										if (!is_null($resultUniqueVisit['uvs_referer'])) {
						$tmpCount = (float)$counts["referer"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["referer"] = $tmpCount;
					}
				}
				if (P('show_pdf_referer', "1") == "3") {
										if (!is_null($resultUniqueVisit['uvs_referer'])) {
						$tmpSum = (float)$sums["referer"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUniqueVisit['uvs_referer'];
						}
						$sums["referer"] = $tmpSum;
					}
				}
				if (P('show_pdf_referer', "1") == "4") {
										if (!is_null($resultUniqueVisit['uvs_referer'])) {
						$tmpCount = (float)$avgCounts["referer"];
						$tmpSum = (float)$avgSums["referer"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["referer"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUniqueVisit['uvs_referer'];
						}
						$avgSums["referer"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_country', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['country'], $colHeight, '' . $resultUniqueVisit['uvs_country'], 'T', 'L', 0, 0);
				if (P('show_pdf_country', "1") == "2") {
										if (!is_null($resultUniqueVisit['uvs_country'])) {
						$tmpCount = (float)$counts["country"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["country"] = $tmpCount;
					}
				}
				if (P('show_pdf_country', "1") == "3") {
										if (!is_null($resultUniqueVisit['uvs_country'])) {
						$tmpSum = (float)$sums["country"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUniqueVisit['uvs_country'];
						}
						$sums["country"] = $tmpSum;
					}
				}
				if (P('show_pdf_country', "1") == "4") {
										if (!is_null($resultUniqueVisit['uvs_country'])) {
						$tmpCount = (float)$avgCounts["country"];
						$tmpSum = (float)$avgSums["country"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["country"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUniqueVisit['uvs_country'];
						}
						$avgSums["country"] = $tmpSum;
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
			if (P('show_pdf_timestamp', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['timestamp'];
				if (P('show_pdf_timestamp', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["timestamp"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_ip', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['ip'];
				if (P('show_pdf_ip', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["ip"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_platform', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['platform'];
				if (P('show_pdf_platform', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["platform"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_browser', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['browser'];
				if (P('show_pdf_browser', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["browser"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_version', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['version'];
				if (P('show_pdf_version', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["version"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_referer', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['referer'];
				if (P('show_pdf_referer', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["referer"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_country', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['country'];
				if (P('show_pdf_country', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["country"];
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
			if (P('show_pdf_timestamp', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['timestamp'];
				if (P('show_pdf_timestamp', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["timestamp"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_ip', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['ip'];
				if (P('show_pdf_ip', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["ip"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_platform', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['platform'];
				if (P('show_pdf_platform', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["platform"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_browser', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['browser'];
				if (P('show_pdf_browser', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["browser"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_version', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['version'];
				if (P('show_pdf_version', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["version"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_referer', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['referer'];
				if (P('show_pdf_referer', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["referer"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_country', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['country'];
				if (P('show_pdf_country', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["country"], 2, ',', ' ');
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
			if (P('show_pdf_timestamp', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['timestamp'];
				if (P('show_pdf_timestamp', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["timestamp"] == 0 ? "-" : $avgSums["timestamp"] / $avgCounts["timestamp"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_ip', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['ip'];
				if (P('show_pdf_ip', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["ip"] == 0 ? "-" : $avgSums["ip"] / $avgCounts["ip"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_platform', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['platform'];
				if (P('show_pdf_platform', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["platform"] == 0 ? "-" : $avgSums["platform"] / $avgCounts["platform"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_browser', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['browser'];
				if (P('show_pdf_browser', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["browser"] == 0 ? "-" : $avgSums["browser"] / $avgCounts["browser"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_version', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['version'];
				if (P('show_pdf_version', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["version"] == 0 ? "-" : $avgSums["version"] / $avgCounts["version"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_referer', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['referer'];
				if (P('show_pdf_referer', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["referer"] == 0 ? "-" : $avgSums["referer"] / $avgCounts["referer"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_country', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['country'];
				if (P('show_pdf_country', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["country"] == 0 ? "-" : $avgSums["country"] / $avgCounts["country"]);
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
				$reportTitle = T('UNIQUE_VISITS');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultUniqueVisit = new virgoUniqueVisit();
			$whereClauseUniqueVisit = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseUniqueVisit = $whereClauseUniqueVisit . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_timestamp', "1") != "0") {
					$data = $data . $stringDelimeter .'Timestamp' . $stringDelimeter . $separator;
				}
				if (P('show_export_ip', "1") != "0") {
					$data = $data . $stringDelimeter .'Ip' . $stringDelimeter . $separator;
				}
				if (P('show_export_platform', "1") != "0") {
					$data = $data . $stringDelimeter .'Platform' . $stringDelimeter . $separator;
				}
				if (P('show_export_browser', "1") != "0") {
					$data = $data . $stringDelimeter .'Browser' . $stringDelimeter . $separator;
				}
				if (P('show_export_version', "1") != "0") {
					$data = $data . $stringDelimeter .'Version' . $stringDelimeter . $separator;
				}
				if (P('show_export_referer', "1") != "0") {
					$data = $data . $stringDelimeter .'Referer' . $stringDelimeter . $separator;
				}
				if (P('show_export_country', "1") != "0") {
					$data = $data . $stringDelimeter .'Country' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_unique_visits.uvs_id, prt_unique_visits.uvs_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_timestamp', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_timestamp uvs_timestamp";
			} else {
				if ($defaultOrderColumn == "uvs_timestamp") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_timestamp ";
				}
			}
			if (P('show_export_ip', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_ip uvs_ip";
			} else {
				if ($defaultOrderColumn == "uvs_ip") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_ip ";
				}
			}
			if (P('show_export_platform', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_platform uvs_platform";
			} else {
				if ($defaultOrderColumn == "uvs_platform") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_platform ";
				}
			}
			if (P('show_export_browser', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_browser uvs_browser";
			} else {
				if ($defaultOrderColumn == "uvs_browser") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_browser ";
				}
			}
			if (P('show_export_version', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_version uvs_version";
			} else {
				if ($defaultOrderColumn == "uvs_version") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_version ";
				}
			}
			if (P('show_export_referer', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_referer uvs_referer";
			} else {
				if ($defaultOrderColumn == "uvs_referer") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_referer ";
				}
			}
			if (P('show_export_country', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_country uvs_country";
			} else {
				if ($defaultOrderColumn == "uvs_country") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_country ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_unique_visits ";

			$resultsUniqueVisit = $resultUniqueVisit->select(
				'', 
				'all', 
				$resultUniqueVisit->getOrderColumn(), 
				$resultUniqueVisit->getOrderMode(), 
				$whereClauseUniqueVisit,
				$queryString);
			foreach ($resultsUniqueVisit as $resultUniqueVisit) {
				if (P('show_export_timestamp', "1") != "0") {
			$data = $data . $resultUniqueVisit['uvs_timestamp'] . $separator;
				}
				if (P('show_export_ip', "1") != "0") {
			$data = $data . $stringDelimeter . $resultUniqueVisit['uvs_ip'] . $stringDelimeter . $separator;
				}
				if (P('show_export_platform', "1") != "0") {
			$data = $data . $stringDelimeter . $resultUniqueVisit['uvs_platform'] . $stringDelimeter . $separator;
				}
				if (P('show_export_browser', "1") != "0") {
			$data = $data . $stringDelimeter . $resultUniqueVisit['uvs_browser'] . $stringDelimeter . $separator;
				}
				if (P('show_export_version', "1") != "0") {
			$data = $data . $stringDelimeter . $resultUniqueVisit['uvs_version'] . $stringDelimeter . $separator;
				}
				if (P('show_export_referer', "1") != "0") {
			$data = $data . $stringDelimeter . $resultUniqueVisit['uvs_referer'] . $stringDelimeter . $separator;
				}
				if (P('show_export_country', "1") != "0") {
			$data = $data . $stringDelimeter . $resultUniqueVisit['uvs_country'] . $stringDelimeter . $separator;
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
				$reportTitle = T('UNIQUE_VISITS');
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
			$resultUniqueVisit = new virgoUniqueVisit();
			$whereClauseUniqueVisit = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseUniqueVisit = $whereClauseUniqueVisit . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_timestamp', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Timestamp');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_ip', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Ip');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_platform', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Platform');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_browser', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Browser');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_version', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Version');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_referer', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Referer');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_country', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Country');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_unique_visits.uvs_id, prt_unique_visits.uvs_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_timestamp', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_timestamp uvs_timestamp";
			} else {
				if ($defaultOrderColumn == "uvs_timestamp") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_timestamp ";
				}
			}
			if (P('show_export_ip', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_ip uvs_ip";
			} else {
				if ($defaultOrderColumn == "uvs_ip") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_ip ";
				}
			}
			if (P('show_export_platform', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_platform uvs_platform";
			} else {
				if ($defaultOrderColumn == "uvs_platform") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_platform ";
				}
			}
			if (P('show_export_browser', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_browser uvs_browser";
			} else {
				if ($defaultOrderColumn == "uvs_browser") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_browser ";
				}
			}
			if (P('show_export_version', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_version uvs_version";
			} else {
				if ($defaultOrderColumn == "uvs_version") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_version ";
				}
			}
			if (P('show_export_referer', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_referer uvs_referer";
			} else {
				if ($defaultOrderColumn == "uvs_referer") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_referer ";
				}
			}
			if (P('show_export_country', "1") != "0") {
				$queryString = $queryString . ", prt_unique_visits.uvs_country uvs_country";
			} else {
				if ($defaultOrderColumn == "uvs_country") {
					$orderColumnNotDisplayed = " prt_unique_visits.uvs_country ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_unique_visits ";

			$resultsUniqueVisit = $resultUniqueVisit->select(
				'', 
				'all', 
				$resultUniqueVisit->getOrderColumn(), 
				$resultUniqueVisit->getOrderMode(), 
				$whereClauseUniqueVisit,
				$queryString);
			$index = 1;
			foreach ($resultsUniqueVisit as $resultUniqueVisit) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultUniqueVisit['uvs_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_timestamp', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUniqueVisit['uvs_timestamp'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_ip', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUniqueVisit['uvs_ip'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_platform', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUniqueVisit['uvs_platform'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_browser', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUniqueVisit['uvs_browser'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_version', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUniqueVisit['uvs_version'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_referer', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUniqueVisit['uvs_referer'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_country', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUniqueVisit['uvs_country'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
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
					$propertyColumnHash['timestamp'] = 'uvs_timestamp';
					$propertyColumnHash['timestamp'] = 'uvs_timestamp';
					$propertyColumnHash['ip'] = 'uvs_ip';
					$propertyColumnHash['ip'] = 'uvs_ip';
					$propertyColumnHash['platform'] = 'uvs_platform';
					$propertyColumnHash['platform'] = 'uvs_platform';
					$propertyColumnHash['browser'] = 'uvs_browser';
					$propertyColumnHash['browser'] = 'uvs_browser';
					$propertyColumnHash['version'] = 'uvs_version';
					$propertyColumnHash['version'] = 'uvs_version';
					$propertyColumnHash['referer'] = 'uvs_referer';
					$propertyColumnHash['referer'] = 'uvs_referer';
					$propertyColumnHash['country'] = 'uvs_country';
					$propertyColumnHash['country'] = 'uvs_country';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importUniqueVisit = new virgoUniqueVisit();
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
										L(T('PROPERTY_NOT_FOUND', T('UNIQUE_VISIT'), $columns[$index]), '', 'ERROR');
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
										$importUniqueVisit->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
							$errorMessage = $importUniqueVisit->store();
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
		



		static function portletActionPreviousYear() {
			$pob = self::getMyPortletObject();
			$selectedYear = $pob->getPortletSessionValue('selected_year', date("Y"));
			$pob->setPortletSessionValue('selected_year', $selectedYear-1);
		}

		static function portletActionPreviousMonth() {
			$pob = self::getMyPortletObject();
			$selectedMonth = $pob->getPortletSessionValue('selected_month', date("m"));
			$selectedMonth = $selectedMonth - 1;
			if ($selectedMonth == 0) {
				$selectedMonth = 12;
				$pob->portletActionPreviousYear();
			}
			$pob->setPortletSessionValue('selected_month', $selectedMonth);
		}

		static function portletActionNextYear() {
			$pob = self::getMyPortletObject();
			$selectedYear = $pob->getPortletSessionValue('selected_year', date("Y"));
			$pob->setPortletSessionValue('selected_year', $selectedYear+1);
		}

		static function portletActionNextMonth() {			
			$pob = self::getMyPortletObject();
			$selectedMonth = $pob->getPortletSessionValue('selected_month', date("m"));
			$selectedMonth = $selectedMonth + 1;
			if ($selectedMonth == 13) {
				$selectedMonth = 1;
				$pob->portletActionNextYear();
			}
			$pob->setPortletSessionValue('selected_month', $selectedMonth);
		}

		static function portletActionCurrentMonth() {
			$pob = self::getMyPortletObject();
			$pob->setPortletSessionValue('selected_month', date("m"));
			$pob->setPortletSessionValue('selected_year', date("Y"));
		}

		static function portletActionSetMonth() {
			$pob = self::getMyPortletObject();
			$selectedMonth = R('virgo_cal_selected_month');
			$pob->setPortletSessionValue('selected_month', $selectedMonth);
		}

		static function portletActionSetYear() {
			$pob = self::getMyPortletObject();
			$selectedYear = R('virgo_cal_selected_year');
			$pob->setPortletSessionValue('selected_year', $selectedYear);
		}



		static function portletActionBackFromParent() {
			$calligView = strtoupper(R('calling_view'));
			self::setDisplayMode($calligView);
			$pob = self::getMyPortletObject();
			$pob->setPortletSessionValue('reload_from_request', '1');				
		}
		static function parse_user_agent( $u_agent = null ) { 
		    if(is_null($u_agent) && isset($_SERVER['HTTP_USER_AGENT'])) $u_agent = $_SERVER['HTTP_USER_AGENT'];
		    $empty = array(
		        'platform' => null,
		        'browser'  => null,
		        'version'  => null,
		    );
		    $data = $empty;
		    if(!$u_agent) return $data;
		    if( preg_match('/\((.*?)\)/im', $u_agent, $parent_matches) ) {
		        preg_match_all('/(?P<platform>Android|CrOS|iPhone|iPad|Linux|Macintosh|Windows(\ Phone\ OS)?|Silk|linux-gnu|BlackBerry|PlayBook|Nintendo\ (WiiU?|3DS)|Xbox)
		            (?:\ [^;]*)?
		            (?:;|$)/imx', $parent_matches[1], $result, PREG_PATTERN_ORDER);
		        $priority = array('Android', 'Xbox');
		        $result['platform'] = array_unique($result['platform']);
		        if( count($result['platform']) > 1 ) {
		            if( $keys = array_intersect($priority, $result['platform']) ) {
		                $data['platform'] = reset($keys);
		            }else{
		                $data['platform'] = $result['platform'][0];
		            }
		        }elseif(isset($result['platform'][0])){
		            $data['platform'] = $result['platform'][0];
		        }
		    }
		    if( $data['platform'] == 'linux-gnu' ) { $data['platform'] = 'Linux'; }
		    if( $data['platform'] == 'CrOS' ) { $data['platform'] = 'Chrome OS'; }
		    preg_match_all('%(?P<browser>Camino|Kindle(\ Fire\ Build)?|Firefox|Safari|MSIE|AppleWebKit|Chrome|IEMobile|Opera|OPR|Silk|Lynx|Version|Wget|curl|NintendoBrowser|PLAYSTATION\ (\d|Vita)+)
		            (?:;?)
		            (?:(?:[/ ])(?P<version>[0-9A-Z.]+)|/(?:[A-Z]*))%ix', 
		    $u_agent, $result, PREG_PATTERN_ORDER);
		    $key = 0;
		    if (!isset($result['browser'][0]) || !isset($result['version'][0])) {
		        return $empty;
		    }
		    $data['browser'] = $result['browser'][0];
		    $data['version'] = $result['version'][0];
		    if( $key = array_search( 'Playstation Vita', $result['browser'] ) !== false ) {
		        $data['platform'] = 'PlayStation Vita';
		        $data['browser'] = 'Browser';
		    }elseif( ($key = array_search( 'Kindle Fire Build', $result['browser'] )) !== false || ($key = array_search( 'Silk', $result['browser'] )) !== false ) {
		        $data['browser']  = $result['browser'][$key] == 'Silk' ? 'Silk' : 'Kindle';
		        $data['platform'] = 'Kindle Fire';
		        if( !($data['version'] = $result['version'][$key]) || !is_numeric($data['version'][0]) ) {
		            $data['version'] = $result['version'][array_search( 'Version', $result['browser'] )];
		        }
		    }elseif( ($key = array_search( 'NintendoBrowser', $result['browser'] )) !== false || $data['platform'] == 'Nintendo 3DS' ) {
		        $data['browser']  = 'NintendoBrowser';
		        $data['version']  = $result['version'][$key];
		    }elseif( ($key = array_search( 'Kindle', $result['browser'] )) !== false ) {
		        $data['browser']  = $result['browser'][$key];
		        $data['platform'] = 'Kindle';
		        $data['version']  = $result['version'][$key];
		    }elseif( ($key = array_search( 'OPR', $result['browser'] )) !== false || ($key = array_search( 'Opera', $result['browser'] )) !== false ) {
		        $data['browser'] = 'Opera';
		        $data['version'] = $result['version'][$key];
		        if( ($key = array_search( 'Version', $result['browser'] )) !== false ) { $data['version'] = $result['version'][$key]; }
		    }elseif( $result['browser'][0] == 'AppleWebKit' ) {
		        if( ( $data['platform'] == 'Android' && !($key = 0) ) || $key = array_search( 'Chrome', $result['browser'] ) ) {
		            $data['browser'] = 'Chrome';
		            if( ($vkey = array_search( 'Version', $result['browser'] )) !== false ) { $key = $vkey; }
		        }elseif( $data['platform'] == 'BlackBerry' || $data['platform'] == 'PlayBook' ) {
		            $data['browser'] = 'BlackBerry Browser';
		            if( ($vkey = array_search( 'Version', $result['browser'] )) !== false ) { $key = $vkey; }
		        }elseif( $key = array_search( 'Safari', $result['browser'] ) ) {
		            $data['browser'] = 'Safari';
		            if( ($vkey = array_search( 'Version', $result['browser'] )) !== false ) { $key = $vkey; }
		        }		        
		        $data['version'] = $result['version'][$key];
		    }elseif( $result['browser'][0] == 'MSIE' ){
		        if( $key = array_search( 'IEMobile', $result['browser'] ) ) {
		            $data['browser'] = 'IEMobile';
		        }else{
		            $data['browser'] = 'MSIE';
		            $key = 0;
		        }
		        $data['version'] = $result['version'][$key];
		    }elseif( $key = array_search( 'PLAYSTATION 3', $result['browser'] ) !== false ) {
		        $data['platform'] = 'PlayStation 3';
		        $data['browser']  = 'NetFront';
		    }
		    return $data;
		}

		static function logVisit() {
			if (PP('COLLECT_VISIT_STATS', '1') == '1') {
				if (is_null(R('virgo_cron_tick')) || R('virgo_cron_tick') != 'true') {
					$visit = new virgoUniqueVisit();
					$visit->setTimestamp(date("Y-m-d H:i:s"));
					I('SystemMessage');
					$visit->setIp(virgoSystemMessage::getRealIp());
					$data = self::parse_user_agent();
					if (is_null($data)) {
				    	$data = array('platform' => null, 'browser'  => null, 'version'  => null);
					}
					$visit->setPlatform(isset($data['platform']) ? $data['platform'] : null);
					$visit->setBrowser(isset($data['browser']) ? $data['browser'] : null);
					$visit->setVersion(isset($data['version']) ? $data['version'] : null);
					$visit->setReferer(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null);
					$visit->store();
				}
			}
		}

		static function updateCountries() {
			$visits = self::selectAllAsObjectsStatic(' uvs_country IS NULL ');
			foreach ($visits as $visit) {
				$country = file_get_contents('http://api.hostip.info/country.php?ip=' . $visit->getIp());
				if (isset($country) && trim($country) != "") {
					$visit->setCountry($country);
					LE($visit->store());
				}
			}
		}

		function portletActionUpdateCountries() {
			self::updateCountries();
		}

		function portletActionChange() {
			self::setLocalSessionValue("date_from", R('from'));
			self::setLocalSessionValue("date_to", R('to'));
			self::setLocalSessionValue("length", R('length'));
			self::setLocalSessionValue("chart_type", R('chart_type'));
		}

		static function getChartRows($chartType) {
			$from = self::getLocalSessionValue("date_from", null);
			$to = self::getLocalSessionValue("date_to", null);
			$length = self::getLocalSessionValue("length", 7);
			if ($chartType == "GeoChart") {
				$query = self::getGeoChartSQL($from, $to);
			} elseif ($chartType == "ColumnChart") {
				$query = self::getChartSQL($from, $to, $length);
			} elseif ($chartType == "BarChart") {
				$query = self::getBarChartSQL($from, $to, $length);
			} else {
				L("Wrong chart type: {$chartType}", '', 'ERROR');
				return null;
			}
			
			return QR($query);
		}

		static function getChartSQL($from, $to, $length) {
			$fromCond = S($from) ? " AND uvs_timestamp >= '{$from} 00:00:00' " : "";
			$toCond = S($to) ? " AND uvs_timestamp <= '{$to} 23:59:59' " : "";
			return <<<SQL
SELECT SUBSTR(uvs_timestamp, 1, {$length}) AS label, COUNT(*) AS value
FROM prt_unique_visits
WHERE 1
{$fromCond}
{$toCond}
GROUP BY SUBSTR(uvs_timestamp, 1, {$length})
ORDER BY SUBSTR(uvs_timestamp, 1, {$length})
SQL;
		}

		static function getGeoChartSQL($from, $to) {
			$fromCond = S($from) ? " AND uvs_timestamp >= '{$from} 00:00:00' " : "";
			$toCond = S($to) ? " AND uvs_timestamp <= '{$to} 23:59:59' " : "";
			return <<<SQL
SELECT uvs_country AS label, COUNT(*) AS value
FROM prt_unique_visits
WHERE uvs_country IS NOT NULL
{$fromCond}
{$toCond}
GROUP BY uvs_country
SQL;
		}

		static function getBarChartSQL($from, $to) {
			$fromCond = S($from) ? " AND uvs_timestamp >= '{$from} 00:00:00' " : "";
			$toCond = S($to) ? " AND uvs_timestamp <= '{$to} 23:59:59' " : "";			
			$currentUrl = str_replace('www.', '', $_SERVER["SERVER_NAME"]);
			return <<<SQL
SELECT SUBSTRING(SUBSTRING(uvs_referer, locate('/', uvs_referer,1)+2), 1, locate('/', CONCAT(SUBSTRING(uvs_referer, locate('/', uvs_referer,1)+2), '/'))-1) AS label, COUNT(*) AS value
FROM prt_unique_visits
WHERE uvs_referer IS NOT NULL 
AND LTRIM(RTRIM(uvs_referer)) <> ''
AND SUBSTRING(SUBSTRING(uvs_referer, locate('/', uvs_referer,1)+2), 1, locate('/', CONCAT(SUBSTRING(uvs_referer, locate('/', uvs_referer,1)+2), '/'))-1) NOT LIKE '%{$currentUrl}'
{$fromCond}
{$toCond}
GROUP BY SUBSTRING(SUBSTRING(uvs_referer, locate('/', uvs_referer,1)+2), 1, locate('/', CONCAT(SUBSTRING(uvs_referer, locate('/', uvs_referer,1)+2), '/'))-1)
ORDER BY COUNT(*) DESC
SQL;
		}



		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `prt_unique_visits` (
  `uvs_id` bigint(20) unsigned NOT NULL auto_increment,
  `uvs_virgo_state` varchar(50) default NULL,
  `uvs_virgo_title` varchar(255) default NULL,
  `uvs_timestamp` datetime, 
  `uvs_ip` varchar(255), 
  `uvs_platform` varchar(255), 
  `uvs_browser` varchar(255), 
  `uvs_version` varchar(255), 
  `uvs_referer` varchar(255), 
  `uvs_country` varchar(255), 
  `uvs_date_created` datetime NOT NULL,
  `uvs_date_modified` datetime default NULL,
  `uvs_usr_created_id` int(11) NOT NULL,
  `uvs_usr_modified_id` int(11) default NULL,
  PRIMARY KEY  (`uvs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/unique_visit.sql 
INSERT INTO `prt_unique_visits` (`uvs_virgo_title`, `uvs_timestamp`, `uvs_ip`, `uvs_platform`, `uvs_browser`, `uvs_version`, `uvs_referer`, `uvs_country`) 
VALUES (title, some_value, some_value, some_value, some_value, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_unique_visits table already exists.", '', 'FATAL');
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
			return "uvs";
		}
		
		static function getPlural() {
			return "unique_visits";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			return $ret;
		}

		static function getChildren() {
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_unique_visits'));
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
			$virgoVersion = virgoUniqueVisit::getVirgoVersion();
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
	
	
