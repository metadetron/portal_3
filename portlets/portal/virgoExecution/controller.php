<?php
/**
* Module Execution
* @package Portal
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace portal;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoProcess'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoSystemMessage'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoElement'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecutionParameter'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoExecution {

		 var  $exc_id = null;
		 var  $exc_begin = null;

		 var  $exc_progress = null;

		 var  $exc_end = null;

		 var  $exc_result = null;

		 var  $exc_statistics = null;

		 var  $exc_prc_id = null;

		 var   $exc_date_created = null;
		 var   $exc_usr_created_id = null;
		 var   $exc_date_modified = null;
		 var   $exc_usr_modified_id = null;
		 var   $exc_virgo_title = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoExecution();
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
        	$this->exc_id = null;
		    $this->exc_date_created = null;
		    $this->exc_usr_created_id = null;
		    $this->exc_date_modified = null;
		    $this->exc_usr_modified_id = null;
		    $this->exc_virgo_title = null;
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
			return $this->exc_id;
		}

		function getBegin() {
			return $this->exc_begin;
		}
		
		 function setBegin($val) {
			$this->exc_begin = $val;
		}
		function getProgress() {
			return $this->exc_progress;
		}
		
		 function setProgress($val) {
			$this->exc_progress = $val;
		}
		function getEnd() {
			return $this->exc_end;
		}
		
		 function setEnd($val) {
			$this->exc_end = $val;
		}
		function getResult() {
			return $this->exc_result;
		}
		
		 function setResult($val) {
			$this->exc_result = $val;
		}
		function getStatistics() {
			return $this->exc_statistics;
		}
		
		 function setStatistics($val) {
			$this->exc_statistics = $val;
		}

		function getProcessId() {
			return $this->exc_prc_id;
		}
		
		 function setProcessId($val) {
			$this->exc_prc_id = $val;
		}

		function getDateCreated() {
			return $this->exc_date_created;
		}
		function getUsrCreatedId() {
			return $this->exc_usr_created_id;
		}
		function getDateModified() {
			return $this->exc_date_modified;
		}
		function getUsrModifiedId() {
			return $this->exc_usr_modified_id;
		}


		function getPrcId() {
			return $this->getProcessId();
		}
		
		 function setPrcId($val) {
			$this->setProcessId($val);
		}

		static function getStatisticsPdfUrlStatic($tmpId) {
			$ret = "";
			$ret .= $_SESSION['portal_url'];
			$ret .= "?virgo_media=true";
			$ret .= "&virgo_media_type=html2pdf";
			$ret .= "&virgo_media_table_name=prt_executions";
			$ret .= "&virgo_media_table_prefix=exc";
			$ret .= "&virgo_media_property_name=statistics";
			$ret .= "&virgo_media_row_id=" . $tmpId;
			$ret .= "&" . getTokenName($tmpId) . "=" . getTokenValue($tmpId);
			return $ret;
		}
		function getStatisticsPdfUrl() {
			if (!is_null($this->getId())) {
				if (!is_null($this->exc_statistics)) {
					return virgoExecution::getStatisticsPdfUrlStatic($this->exc_id);
				}
			}
			return "";
		}
		function loadRecordFromRequest($rowId) {
			$this->exc_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('exc_begin_' . $this->exc_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->exc_begin = null;
		} else {
			$this->exc_begin = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('exc_progress_' . $this->exc_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->exc_progress = null;
		} else {
			$this->exc_progress = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('exc_end_' . $this->exc_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->exc_end = null;
		} else {
			$this->exc_end = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('exc_result_' . $this->exc_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->exc_result = null;
		} else {
			$this->exc_result = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('exc_statistics_' . $this->exc_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->exc_statistics = null;
		} else {
			$this->exc_statistics = $tmpValue;
		}
	}
			$this->exc_prc_id = strval(R('exc_process_' . $this->exc_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('exc_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaExecution = array();	
			$criteriaFieldExecution = array();	
			$isNullExecution = R('virgo_search_begin_is_null');
			
			$criteriaFieldExecution["is_null"] = 0;
			if ($isNullExecution == "not_null") {
				$criteriaFieldExecution["is_null"] = 1;
			} elseif ($isNullExecution == "null") {
				$criteriaFieldExecution["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_begin_from');
		$dataTypeCriteria["to"] = R('virgo_search_begin_to');

//			if ($isSet) {
			$criteriaFieldExecution["value"] = $dataTypeCriteria;
//			}
			$criteriaExecution["begin"] = $criteriaFieldExecution;
			$criteriaFieldExecution = array();	
			$isNullExecution = R('virgo_search_progress_is_null');
			
			$criteriaFieldExecution["is_null"] = 0;
			if ($isNullExecution == "not_null") {
				$criteriaFieldExecution["is_null"] = 1;
			} elseif ($isNullExecution == "null") {
				$criteriaFieldExecution["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_progress_from');
		$dataTypeCriteria["to"] = R('virgo_search_progress_to');

//			if ($isSet) {
			$criteriaFieldExecution["value"] = $dataTypeCriteria;
//			}
			$criteriaExecution["progress"] = $criteriaFieldExecution;
			$criteriaFieldExecution = array();	
			$isNullExecution = R('virgo_search_end_is_null');
			
			$criteriaFieldExecution["is_null"] = 0;
			if ($isNullExecution == "not_null") {
				$criteriaFieldExecution["is_null"] = 1;
			} elseif ($isNullExecution == "null") {
				$criteriaFieldExecution["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_end_from');
		$dataTypeCriteria["to"] = R('virgo_search_end_to');

//			if ($isSet) {
			$criteriaFieldExecution["value"] = $dataTypeCriteria;
//			}
			$criteriaExecution["end"] = $criteriaFieldExecution;
			$criteriaFieldExecution = array();	
			$isNullExecution = R('virgo_search_result_is_null');
			
			$criteriaFieldExecution["is_null"] = 0;
			if ($isNullExecution == "not_null") {
				$criteriaFieldExecution["is_null"] = 1;
			} elseif ($isNullExecution == "null") {
				$criteriaFieldExecution["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_result');

//			if ($isSet) {
			$criteriaFieldExecution["value"] = $dataTypeCriteria;
//			}
			$criteriaExecution["result"] = $criteriaFieldExecution;
			$criteriaFieldExecution = array();	
			$isNullExecution = R('virgo_search_statistics_is_null');
			
			$criteriaFieldExecution["is_null"] = 0;
			if ($isNullExecution == "not_null") {
				$criteriaFieldExecution["is_null"] = 1;
			} elseif ($isNullExecution == "null") {
				$criteriaFieldExecution["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
//			if ($isSet) {
			$criteriaFieldExecution["value"] = $dataTypeCriteria;
//			}
			$criteriaExecution["statistics"] = $criteriaFieldExecution;
			$criteriaParent = array();	
			$isNull = R('virgo_search_process_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_process', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaExecution["process"] = $criteriaParent;
			self::setCriteria($criteriaExecution);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_begin');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterBegin', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterBegin', null);
			}
			$tableFilter = R('virgo_filter_progress');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterProgress', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterProgress', null);
			}
			$tableFilter = R('virgo_filter_end');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterEnd', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterEnd', null);
			}
			$tableFilter = R('virgo_filter_result');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterResult', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterResult', null);
			}
			$tableFilter = R('virgo_filter_statistics');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterStatistics', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterStatistics', null);
			}
			$parentFilter = R('virgo_filter_process');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterProcess', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterProcess', null);
			}
			$parentFilter = R('virgo_filter_title_process');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleProcess', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleProcess', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseExecution = ' 1 = 1 ';
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
				$eventColumn = "exc_" . P('event_column');
				$whereClauseExecution = $whereClauseExecution . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseExecution = $whereClauseExecution . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_process');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_executions.exc_prc_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_executions.exc_prc_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseExecution = $whereClauseExecution . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaExecution = self::getCriteria();
			if (isset($criteriaExecution["begin"])) {
				$fieldCriteriaBegin = $criteriaExecution["begin"];
				if ($fieldCriteriaBegin["is_null"] == 1) {
$filter = $filter . ' AND prt_executions.exc_begin IS NOT NULL ';
				} elseif ($fieldCriteriaBegin["is_null"] == 2) {
$filter = $filter . ' AND prt_executions.exc_begin IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaBegin["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND prt_executions.exc_begin >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_executions.exc_begin <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaExecution["progress"])) {
				$fieldCriteriaProgress = $criteriaExecution["progress"];
				if ($fieldCriteriaProgress["is_null"] == 1) {
$filter = $filter . ' AND prt_executions.exc_progress IS NOT NULL ';
				} elseif ($fieldCriteriaProgress["is_null"] == 2) {
$filter = $filter . ' AND prt_executions.exc_progress IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaProgress["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_executions.exc_progress = ? ";
				} else {
					$filter = $filter . " AND prt_executions.exc_progress >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_executions.exc_progress <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaExecution["end"])) {
				$fieldCriteriaEnd = $criteriaExecution["end"];
				if ($fieldCriteriaEnd["is_null"] == 1) {
$filter = $filter . ' AND prt_executions.exc_end IS NOT NULL ';
				} elseif ($fieldCriteriaEnd["is_null"] == 2) {
$filter = $filter . ' AND prt_executions.exc_end IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaEnd["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND prt_executions.exc_end >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_executions.exc_end <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaExecution["result"])) {
				$fieldCriteriaResult = $criteriaExecution["result"];
				if ($fieldCriteriaResult["is_null"] == 1) {
$filter = $filter . ' AND prt_executions.exc_result IS NOT NULL ';
				} elseif ($fieldCriteriaResult["is_null"] == 2) {
$filter = $filter . ' AND prt_executions.exc_result IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaResult["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_executions.exc_result like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaExecution["statistics"])) {
				$fieldCriteriaStatistics = $criteriaExecution["statistics"];
				if ($fieldCriteriaStatistics["is_null"] == 1) {
$filter = $filter . ' AND prt_executions.exc_statistics IS NOT NULL ';
				} elseif ($fieldCriteriaStatistics["is_null"] == 2) {
$filter = $filter . ' AND prt_executions.exc_statistics IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaStatistics["value"];
				}
			}
			if (isset($criteriaExecution["process"])) {
				$parentCriteria = $criteriaExecution["process"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND exc_prc_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_executions.exc_prc_id IN (SELECT prc_id FROM prt_processes WHERE prc_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseExecution = $whereClauseExecution . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseExecution = $whereClauseExecution . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseExecution = $whereClauseExecution . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterBegin', null);
				if (S($tableFilter)) {
					$whereClauseExecution = $whereClauseExecution . " AND exc_begin LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterProgress', null);
				if (S($tableFilter)) {
					$whereClauseExecution = $whereClauseExecution . " AND exc_progress LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterEnd', null);
				if (S($tableFilter)) {
					$whereClauseExecution = $whereClauseExecution . " AND exc_end LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterResult', null);
				if (S($tableFilter)) {
					$whereClauseExecution = $whereClauseExecution . " AND exc_result LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterStatistics', null);
				if (S($tableFilter)) {
					$whereClauseExecution = $whereClauseExecution . " AND exc_statistics LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterProcess', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseExecution = $whereClauseExecution . " AND exc_prc_id IS NULL ";
					} else {
						$whereClauseExecution = $whereClauseExecution . " AND exc_prc_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleProcess', null);
				if (S($parentFilter)) {
					$whereClauseExecution = $whereClauseExecution . " AND prt_processes_parent.prc_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClauseExecution;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseExecution = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_executions.exc_id, prt_executions.exc_virgo_title ";
			$defaultOrderColumn = P('default_sort_column', 'exc_order');
			$orderColumnNotDisplayed = "";
			if (P('show_table_begin', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_begin exc_begin";
			} else {
				if ($defaultOrderColumn == "exc_begin") {
					$orderColumnNotDisplayed = " prt_executions.exc_begin ";
				}
			}
			if (P('show_table_progress', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_progress exc_progress";
			} else {
				if ($defaultOrderColumn == "exc_progress") {
					$orderColumnNotDisplayed = " prt_executions.exc_progress ";
				}
			}
			if (P('show_table_end', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_end exc_end";
			} else {
				if ($defaultOrderColumn == "exc_end") {
					$orderColumnNotDisplayed = " prt_executions.exc_end ";
				}
			}
			if (P('show_table_result', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_result exc_result";
			} else {
				if ($defaultOrderColumn == "exc_result") {
					$orderColumnNotDisplayed = " prt_executions.exc_result ";
				}
			}
			if (P('show_table_statistics', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_statistics exc_statistics";
			} else {
				if ($defaultOrderColumn == "exc_statistics") {
					$orderColumnNotDisplayed = " prt_executions.exc_statistics ";
				}
			}
			if (class_exists('portal\virgoProcess') && P('show_table_process', "1") != "0") { // */ && !in_array("prc", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_executions.exc_prc_id as exc_prc_id ";
				$queryString = $queryString . ", prt_processes_parent.prc_virgo_title as `process` ";
			} else {
				if ($defaultOrderColumn == "process") {
					$orderColumnNotDisplayed = " prt_processes_parent.prc_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_executions ";
			if (class_exists('portal\virgoProcess')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_processes AS prt_processes_parent ON (prt_executions.exc_prc_id = prt_processes_parent.prc_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseExecution = $whereClauseExecution . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseExecution, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseExecution,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_executions"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " exc_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " exc_usr_created_id = ? ";
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
				. "\n FROM prt_executions"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_executions ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_executions ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, exc_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " exc_usr_created_id = ? ";
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
				$query = "SELECT COUNT(exc_id) cnt FROM executions";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as executions ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as executions ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoExecution();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_executions WHERE exc_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->exc_id = $row['exc_id'];
$this->exc_begin = $row['exc_begin'];
$this->exc_progress = $row['exc_progress'];
$this->exc_end = $row['exc_end'];
$this->exc_result = $row['exc_result'];
$this->exc_statistics = $row['exc_statistics'];
						$this->exc_prc_id = $row['exc_prc_id'];
						if ($fetchUsernames) {
							if ($row['exc_date_created']) {
								if ($row['exc_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['exc_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['exc_date_modified']) {
								if ($row['exc_usr_modified_id'] == $row['exc_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['exc_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['exc_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->exc_date_created = $row['exc_date_created'];
						$this->exc_usr_created_id = $fetchUsernames ? $createdBy : $row['exc_usr_created_id'];
						$this->exc_date_modified = $row['exc_date_modified'];
						$this->exc_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['exc_usr_modified_id'];
						$this->exc_virgo_title = $row['exc_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_executions SET exc_usr_created_id = {$userId} WHERE exc_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->exc_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoExecution::selectAllAsObjectsStatic('exc_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->exc_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->exc_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('exc_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_exc = new virgoExecution();
				$tmp_exc->load((int)$lookup_id);
				return $tmp_exc->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoExecution');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" exc_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoExecution', "10");
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
				$query = $query . " exc_id as id, exc_virgo_title as title ";
			}
			$query = $query . " FROM prt_executions ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoExecution', 'portal') == "1") {
				$privateCondition = " exc_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY exc_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resExecution = array();
				foreach ($rows as $row) {
					$resExecution[$row['id']] = $row['title'];
				}
				return $resExecution;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticExecution = new virgoExecution();
			return $staticExecution->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getProcessStatic($parentId) {
			return virgoProcess::getById($parentId);
		}
		
		function getProcess() {
			return virgoExecution::getProcessStatic($this->exc_prc_id);
		}

		static function getSystemMessagesStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resSystemMessage = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoSystemMessage'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resSystemMessage;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resSystemMessage;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsSystemMessage = virgoSystemMessage::selectAll('sms_exc_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsSystemMessage as $resultSystemMessage) {
				$tmpSystemMessage = virgoSystemMessage::getById($resultSystemMessage['sms_id']); 
				array_push($resSystemMessage, $tmpSystemMessage);
			}
			return $resSystemMessage;
		}

		function getSystemMessages($orderBy = '', $extraWhere = null) {
			return virgoExecution::getSystemMessagesStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getElementsStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resElement = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoElement'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resElement;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resElement;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsElement = virgoElement::selectAll('elm_exc_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsElement as $resultElement) {
				$tmpElement = virgoElement::getById($resultElement['elm_id']); 
				array_push($resElement, $tmpElement);
			}
			return $resElement;
		}

		function getElements($orderBy = '', $extraWhere = null) {
			return virgoExecution::getElementsStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getExecutionParametersStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resExecutionParameter = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecutionParameter'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resExecutionParameter;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resExecutionParameter;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsExecutionParameter = virgoExecutionParameter::selectAll('epr_exc_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsExecutionParameter as $resultExecutionParameter) {
				$tmpExecutionParameter = virgoExecutionParameter::getById($resultExecutionParameter['epr_id']); 
				array_push($resExecutionParameter, $tmpExecutionParameter);
			}
			return $resExecutionParameter;
		}

		function getExecutionParameters($orderBy = '', $extraWhere = null) {
			return virgoExecution::getExecutionParametersStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
			if (
(is_null($this->getBegin()) || trim($this->getBegin()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'BEGIN');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_progress_obligatory', "0") == "1") {
				if (
(is_null($this->getProgress()) || trim($this->getProgress()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'PROGRESS');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_end_obligatory', "0") == "1") {
				if (
(is_null($this->getEnd()) || trim($this->getEnd()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'END');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_result_obligatory', "0") == "1") {
				if (
(is_null($this->getResult()) || trim($this->getResult()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'RESULT');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_statistics_obligatory', "0") == "1") {
				if (
(is_null($this->getStatistics()) || trim($this->getStatistics()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'STATISTICS');
				}			
			}
				if (is_null($this->exc_prc_id) || trim($this->exc_prc_id) == "") {
					if (R('create_exc_process_' . $this->exc_id) == "1") { 
						$parent = new virgoProcess();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->exc_prc_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'PROCESS', '');
					}
			}			
 			if (!is_null($this->exc_progress) && trim($this->exc_progress) != "") {
				if (!is_numeric($this->exc_progress)) {
					return T('INCORRECT_NUMBER', 'PROGRESS', $this->exc_progress);
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_executions WHERE exc_id = " . $this->getId();
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
				$colNames = $colNames . ", exc_begin";
				$values = $values . ", " . (is_null($objectToStore->getBegin()) ? "null" : "'" . QE($objectToStore->getBegin()) . "'");
				$colNames = $colNames . ", exc_progress";
				$values = $values . ", " . (is_null($objectToStore->getProgress()) ? "null" : "'" . QE($objectToStore->getProgress()) . "'");
				$colNames = $colNames . ", exc_end";
				$values = $values . ", " . (is_null($objectToStore->getEnd()) ? "null" : "'" . QE($objectToStore->getEnd()) . "'");
				$colNames = $colNames . ", exc_result";
				$values = $values . ", " . (is_null($objectToStore->getResult()) ? "null" : "'" . QE($objectToStore->getResult()) . "'");
				$colNames = $colNames . ", exc_statistics";
				$values = $values . ", " . (is_null($objectToStore->getStatistics()) ? "null" : "'" . QE($objectToStore->getStatistics()) . "'");
				$colNames = $colNames . ", exc_prc_id";
				$values = $values . ", " . (is_null($objectToStore->getPrcId()) || $objectToStore->getPrcId() == "" ? "null" : $objectToStore->getPrcId());
				$query = "INSERT INTO prt_history_executions (revision, ip, username, user_id, timestamp, exc_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getBegin() != $objectToStore->getBegin()) {
				if (is_null($objectToStore->getBegin())) {
					$nullifiedProperties = $nullifiedProperties . "begin,";
				} else {
				$colNames = $colNames . ", exc_begin";
				$values = $values . ", " . (is_null($objectToStore->getBegin()) ? "null" : "'" . QE($objectToStore->getBegin()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getProgress() != $objectToStore->getProgress()) {
				if (is_null($objectToStore->getProgress())) {
					$nullifiedProperties = $nullifiedProperties . "progress,";
				} else {
				$colNames = $colNames . ", exc_progress";
				$values = $values . ", " . (is_null($objectToStore->getProgress()) ? "null" : "'" . QE($objectToStore->getProgress()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getEnd() != $objectToStore->getEnd()) {
				if (is_null($objectToStore->getEnd())) {
					$nullifiedProperties = $nullifiedProperties . "end,";
				} else {
				$colNames = $colNames . ", exc_end";
				$values = $values . ", " . (is_null($objectToStore->getEnd()) ? "null" : "'" . QE($objectToStore->getEnd()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getResult() != $objectToStore->getResult()) {
				if (is_null($objectToStore->getResult())) {
					$nullifiedProperties = $nullifiedProperties . "result,";
				} else {
				$colNames = $colNames . ", exc_result";
				$values = $values . ", " . (is_null($objectToStore->getResult()) ? "null" : "'" . QE($objectToStore->getResult()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getStatistics() != $objectToStore->getStatistics()) {
				if (is_null($objectToStore->getStatistics())) {
					$nullifiedProperties = $nullifiedProperties . "statistics,";
				} else {
				$colNames = $colNames . ", exc_statistics";
				$values = $values . ", " . (is_null($objectToStore->getStatistics()) ? "null" : "'" . QE($objectToStore->getStatistics()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getPrcId() != $objectToStore->getPrcId() && ($virgoOld->getPrcId() != 0 || $objectToStore->getPrcId() != ""))) { 
				$colNames = $colNames . ", exc_prc_id";
				$values = $values . ", " . (is_null($objectToStore->getPrcId()) ? "null" : ($objectToStore->getPrcId() == "" ? "0" : $objectToStore->getPrcId()));
			}
			$query = "INSERT INTO prt_history_executions (revision, ip, username, user_id, timestamp, exc_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_executions");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'exc_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_executions ADD COLUMN (exc_virgo_title VARCHAR(255));";
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
			if (isset($this->exc_id) && $this->exc_id != "") {
				$query = "UPDATE prt_executions SET ";
			if (isset($this->exc_begin)) {
				$query .= " exc_begin = ? ,";
				$types .= "s";
				$values[] = $this->exc_begin;
			} else {
				$query .= " exc_begin = NULL ,";				
			}
			if (isset($this->exc_progress)) {
				$query .= " exc_progress = ? ,";
				$types .= "i";
				$values[] = $this->exc_progress;
			} else {
				$query .= " exc_progress = NULL ,";				
			}
			if (isset($this->exc_end)) {
				$query .= " exc_end = ? ,";
				$types .= "s";
				$values[] = $this->exc_end;
			} else {
				$query .= " exc_end = NULL ,";				
			}
			if (isset($this->exc_result)) {
				$query .= " exc_result = ? ,";
				$types .= "s";
				$values[] = $this->exc_result;
			} else {
				$query .= " exc_result = NULL ,";				
			}
			if (isset($this->exc_statistics)) {
				$query .= " exc_statistics = ? ,";
				$types .= "s";
				$values[] = $this->exc_statistics;
			} else {
				$query .= " exc_statistics = NULL ,";				
			}
				if (isset($this->exc_prc_id) && trim($this->exc_prc_id) != "") {
					$query = $query . " exc_prc_id = ? , ";
					$types = $types . "i";
					$values[] = $this->exc_prc_id;
				} else {
					$query = $query . " exc_prc_id = NULL, ";
				}
				$query = $query . " exc_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " exc_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->exc_date_modified;

				$query = $query . " exc_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->exc_usr_modified_id;

				$query = $query . " WHERE exc_id = ? ";
				$types = $types . "i";
				$values[] = $this->exc_id;
			} else {
				$query = "INSERT INTO prt_executions ( ";
			$query = $query . " exc_begin, ";
			$query = $query . " exc_progress, ";
			$query = $query . " exc_end, ";
			$query = $query . " exc_result, ";
			$query = $query . " exc_statistics, ";
				$query = $query . " exc_prc_id, ";
				$query = $query . " exc_virgo_title, exc_date_created, exc_usr_created_id) VALUES ( ";
			if (isset($this->exc_begin)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->exc_begin;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->exc_progress)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->exc_progress;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->exc_end)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->exc_end;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->exc_result)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->exc_result;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->exc_statistics)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->exc_statistics;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->exc_prc_id) && trim($this->exc_prc_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->exc_prc_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->exc_date_created;
				$values[] = $this->exc_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->exc_id) || $this->exc_id == "") {
					$this->exc_id = QID();
				}
				if ($log) {
					L("execution stored successfully", "id = {$this->exc_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->exc_id) {
				$virgoOld = new virgoExecution($this->exc_id);
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
					if ($this->exc_id) {			
						$this->exc_date_modified = date("Y-m-d H:i:s");
						$this->exc_usr_modified_id = $userId;
					} else {
						$this->exc_date_created = date("Y-m-d H:i:s");
						$this->exc_usr_created_id = $userId;
					}
					$this->exc_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "execution" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "execution" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM prt_executions WHERE exc_id = {$this->exc_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			$list = $this->getSystemMessages();
			if (sizeof($list) > 0) {
				foreach ($list as $childRecord) {
					$childRecord->delete();
				}
			}
			$list = $this->getElements();
			if (sizeof($list) > 0) {
				foreach ($list as $childRecord) {
					$childRecord->delete();
				}
			}
			$list = $this->getExecutionParameters();
			if (sizeof($list) > 0) {
				foreach ($list as $childRecord) {
					$childRecord->delete();
				}
			}
			self::removeFromContext();
			$this->parentDelete();
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoExecution();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT exc_id as id FROM prt_executions";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'exc_order_column')) {
				$orderBy = " ORDER BY exc_order_column ASC ";
			} 
			if (property_exists($this, 'exc_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY exc_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoExecution();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoExecution($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_executions SET exc_virgo_title = '$title' WHERE exc_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoExecution();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" exc_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['exc_id'];
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
			virgoExecution::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoExecution::setSessionValue('Portal_Execution-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoExecution::getSessionValue('Portal_Execution-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoExecution::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoExecution::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoExecution::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoExecution::getSessionValue('GLOBAL', $name, $default);
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
			$context['exc_id'] = $id;
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
			$context['exc_id'] = null;
			virgoExecution::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoExecution::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoExecution::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoExecution::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoExecution::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoExecution::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoExecution::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoExecution::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoExecution::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoExecution::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoExecution::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoExecution::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoExecution::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoExecution::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoExecution::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoExecution::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoExecution::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "exc_id";
			}
			return virgoExecution::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoExecution::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoExecution::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoExecution::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoExecution::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoExecution::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoExecution::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoExecution::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoExecution::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoExecution::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoExecution::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoExecution::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoExecution::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->exc_id) {
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
						L(T('STORED_CORRECTLY', 'EXECUTION'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'begin', $this->exc_begin);
						$fieldValues = $fieldValues . T($fieldValue, 'progress', $this->exc_progress);
						$fieldValues = $fieldValues . T($fieldValue, 'end', $this->exc_end);
						$fieldValues = $fieldValues . T($fieldValue, 'result', $this->exc_result);
						$fieldValues = $fieldValues . T($fieldValue, 'statistics', $this->exc_statistics);
						$parentProcess = new virgoProcess();
						$fieldValues = $fieldValues . T($fieldValue, 'process', $parentProcess->lookup($this->exc_prc_id));
						$username = '';
						if ($this->exc_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->exc_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->exc_date_created);
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
			$instance = new virgoExecution();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			if (false) { //$componentParams->get('show_form_system_messages') == "1") {
				$tmpSystemMessage = new virgoSystemMessage();
				$deleteSystemMessage = R('DELETE');
				if (sizeof($deleteSystemMessage) > 0) {
					$tmpSystemMessage->multipleDelete($deleteSystemMessage);
				}
				$resIds = $tmpSystemMessage->select(null, 'all', null, null, ' sms_exc_id = ' . $instance->getId(), ' SELECT sms_id FROM prt_system_messages ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->sms_id;
//					JRequest::setVar('sms_execution_' . $resId->sms_id, $this->getId());
				} 
//				JRequest::setVar('sms_execution_', $instance->getId());
				$tmpSystemMessage->setRecordSet($resIdsString);
				if (!$tmpSystemMessage->portletActionStoreSelected()) {
					$ret = -1;
					self::setDisplayMode($originalDisplayMode); 
				}
			}
			if (false) { //$componentParams->get('show_form_elements') == "1") {
				$tmpElement = new virgoElement();
				$deleteElement = R('DELETE');
				if (sizeof($deleteElement) > 0) {
					$tmpElement->multipleDelete($deleteElement);
				}
				$resIds = $tmpElement->select(null, 'all', null, null, ' elm_exc_id = ' . $instance->getId(), ' SELECT elm_id FROM prt_elements ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->elm_id;
//					JRequest::setVar('elm_execution_' . $resId->elm_id, $this->getId());
				} 
//				JRequest::setVar('elm_execution_', $instance->getId());
				$tmpElement->setRecordSet($resIdsString);
				if (!$tmpElement->portletActionStoreSelected()) {
					$ret = -1;
					self::setDisplayMode($originalDisplayMode); 
				}
			}
			if (false) { //$componentParams->get('show_form_execution_parameters') == "1") {
				$tmpExecutionParameter = new virgoExecutionParameter();
				$deleteExecutionParameter = R('DELETE');
				if (sizeof($deleteExecutionParameter) > 0) {
					$tmpExecutionParameter->multipleDelete($deleteExecutionParameter);
				}
				$resIds = $tmpExecutionParameter->select(null, 'all', null, null, ' epr_exc_id = ' . $instance->getId(), ' SELECT epr_id FROM prt_execution_parameters ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->epr_id;
//					JRequest::setVar('epr_execution_' . $resId->epr_id, $this->getId());
				} 
//				JRequest::setVar('epr_execution_', $instance->getId());
				$tmpExecutionParameter->setRecordSet($resIdsString);
				if (!$tmpExecutionParameter->portletActionStoreSelected()) {
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
			$tmpId = intval(R('exc_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoExecution::getContextId();
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
			$this->exc_id = null;
			$this->exc_date_created = null;
			$this->exc_usr_created_id = null;
			$this->exc_date_modified = null;
			$this->exc_usr_modified_id = null;
			$this->exc_virgo_title = null;
			
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

		static function portletActionShowForProcess() {
			$parentId = R('prc_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoProcess($parentId);
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
//			$ret = new virgoExecution();
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
				$instance = new virgoExecution();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoExecution::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'EXECUTION'), '', 'INFO');
					return 0;
					
				} else {
					L($res, '', 'ERROR');
					return -1;
				}
			}
		}
		
		
		static function portletActionVirgoStatisticsAsPdf() {
			$this->loadFromDB();
			$this->generateStatisticsAsPdf();
		}
		function generateStatisticsAsPdf() {
			require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'tcpdf'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'eng.php');
			require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'tcpdf'.DIRECTORY_SEPARATOR.'tcpdf.php');
			ini_set('display_errors', '0');
			$pdf = new FOOTEREDPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator(null);
			$pdf->SetTitle('');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);
			$font = 'freeserif';
			$fontBoldVariant = 'B';
			$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->SetFont($font, '', 10);
			$pdf->SetFont('freeserif', '', 13);
			$pdf->AddPage();
			$pdf->writeHTML($this->getStatistics(), true, false, true, false, '');
			$pdf->Output('Execution_Statistics_' . $this->getId() . '.pdf', 'I'); 			ini_set('display_errors', '1');
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
				$resultExecution = new virgoExecution();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultExecution->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultExecution->load($idToEditInt);
					} else {
						$resultExecution->exc_id = 0;
					}
				}
				$results[] = $resultExecution;
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
				$result = new virgoExecution();
				$result->loadFromRequest($idToStore);
				if ($result->exc_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->exc_id == 0) {
						$result->exc_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->exc_id)) {
							$result->exc_id = 0;
						}
						$idsToCorrect[$result->exc_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'EXECUTIONS'), '', 'INFO');
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
			$resultExecution = new virgoExecution();
			foreach ($idsToDelete as $idToDelete) {
				$resultExecution->load((int)trim($idToDelete));
				$res = $resultExecution->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'EXECUTIONS'), '', 'INFO');			
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
		$ret = $this->exc_result;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoExecution');
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
				$query = "UPDATE prt_executions SET exc_virgo_title = ? WHERE exc_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT exc_id AS id FROM prt_executions ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoExecution($row['id']);
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
				$class2prefix["portal\\virgoProcess"] = "prc";
				$class2prefix2 = array();
				$class2parentPrefix["portal\\virgoProcess"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'prt_executions.exc_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_executions.exc_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_executions.exc_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_executions.exc_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoExecution!', '', 'ERROR');
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
			$pdf->SetTitle('Executions report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('EXECUTIONS');
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
			if (P('show_pdf_begin', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_progress', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_end', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_result', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_statistics', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_process', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultExecution = new virgoExecution();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_begin', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Begin');
				$minWidth['begin'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['begin']) {
						$minWidth['begin'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_progress', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Progress');
				$minWidth['progress'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['progress']) {
						$minWidth['progress'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_end', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'End');
				$minWidth['end'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['end']) {
						$minWidth['end'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_result', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Result');
				$minWidth['result'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['result']) {
						$minWidth['result'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_statistics', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Statistics');
				$minWidth['statistics'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['statistics']) {
						$minWidth['statistics'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_process', "1") == "1") {
				$minWidth['process $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'process $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['process $relation.name']) {
						$minWidth['process $relation.name'] = min($tmpLen, $maxWidth);
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
			$whereClauseExecution = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseExecution = $whereClauseExecution . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaExecution = $resultExecution->getCriteria();
			$fieldCriteriaBegin = $criteriaExecution["begin"];
			if ($fieldCriteriaBegin["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Begin', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaBegin["value"];
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
					$pdf->MultiCell(60, 100, 'Begin', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaProgress = $criteriaExecution["progress"];
			if ($fieldCriteriaProgress["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Progress', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaProgress["value"];
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
					$pdf->MultiCell(60, 100, 'Progress', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaEnd = $criteriaExecution["end"];
			if ($fieldCriteriaEnd["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'End', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaEnd["value"];
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
					$pdf->MultiCell(60, 100, 'End', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaResult = $criteriaExecution["result"];
			if ($fieldCriteriaResult["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Result', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaResult["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Result', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaStatistics = $criteriaExecution["statistics"];
			if ($fieldCriteriaStatistics["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Statistics', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaStatistics["value"];
				$renderCriteria = "";
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Statistics', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaExecution["process"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Process', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoProcess::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Process', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_process');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_executions.exc_prc_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_executions.exc_prc_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseExecution = $whereClauseExecution . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaExecution = self::getCriteria();
			if (isset($criteriaExecution["begin"])) {
				$fieldCriteriaBegin = $criteriaExecution["begin"];
				if ($fieldCriteriaBegin["is_null"] == 1) {
$filter = $filter . ' AND prt_executions.exc_begin IS NOT NULL ';
				} elseif ($fieldCriteriaBegin["is_null"] == 2) {
$filter = $filter . ' AND prt_executions.exc_begin IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaBegin["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND prt_executions.exc_begin >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_executions.exc_begin <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaExecution["progress"])) {
				$fieldCriteriaProgress = $criteriaExecution["progress"];
				if ($fieldCriteriaProgress["is_null"] == 1) {
$filter = $filter . ' AND prt_executions.exc_progress IS NOT NULL ';
				} elseif ($fieldCriteriaProgress["is_null"] == 2) {
$filter = $filter . ' AND prt_executions.exc_progress IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaProgress["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_executions.exc_progress = ? ";
				} else {
					$filter = $filter . " AND prt_executions.exc_progress >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_executions.exc_progress <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaExecution["end"])) {
				$fieldCriteriaEnd = $criteriaExecution["end"];
				if ($fieldCriteriaEnd["is_null"] == 1) {
$filter = $filter . ' AND prt_executions.exc_end IS NOT NULL ';
				} elseif ($fieldCriteriaEnd["is_null"] == 2) {
$filter = $filter . ' AND prt_executions.exc_end IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaEnd["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND prt_executions.exc_end >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_executions.exc_end <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaExecution["result"])) {
				$fieldCriteriaResult = $criteriaExecution["result"];
				if ($fieldCriteriaResult["is_null"] == 1) {
$filter = $filter . ' AND prt_executions.exc_result IS NOT NULL ';
				} elseif ($fieldCriteriaResult["is_null"] == 2) {
$filter = $filter . ' AND prt_executions.exc_result IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaResult["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_executions.exc_result like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaExecution["statistics"])) {
				$fieldCriteriaStatistics = $criteriaExecution["statistics"];
				if ($fieldCriteriaStatistics["is_null"] == 1) {
$filter = $filter . ' AND prt_executions.exc_statistics IS NOT NULL ';
				} elseif ($fieldCriteriaStatistics["is_null"] == 2) {
$filter = $filter . ' AND prt_executions.exc_statistics IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaStatistics["value"];
				}
			}
			if (isset($criteriaExecution["process"])) {
				$parentCriteria = $criteriaExecution["process"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND exc_prc_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_executions.exc_prc_id IN (SELECT prc_id FROM prt_processes WHERE prc_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseExecution = $whereClauseExecution . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseExecution = $whereClauseExecution . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_executions.exc_id, prt_executions.exc_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_begin', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_begin exc_begin";
			} else {
				if ($defaultOrderColumn == "exc_begin") {
					$orderColumnNotDisplayed = " prt_executions.exc_begin ";
				}
			}
			if (P('show_pdf_progress', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_progress exc_progress";
			} else {
				if ($defaultOrderColumn == "exc_progress") {
					$orderColumnNotDisplayed = " prt_executions.exc_progress ";
				}
			}
			if (P('show_pdf_end', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_end exc_end";
			} else {
				if ($defaultOrderColumn == "exc_end") {
					$orderColumnNotDisplayed = " prt_executions.exc_end ";
				}
			}
			if (P('show_pdf_result', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_result exc_result";
			} else {
				if ($defaultOrderColumn == "exc_result") {
					$orderColumnNotDisplayed = " prt_executions.exc_result ";
				}
			}
			if (P('show_pdf_statistics', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_statistics exc_statistics";
			} else {
				if ($defaultOrderColumn == "exc_statistics") {
					$orderColumnNotDisplayed = " prt_executions.exc_statistics ";
				}
			}
			if (class_exists('portal\virgoProcess') && P('show_pdf_process', "1") != "0") { // */ && !in_array("prc", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_executions.exc_prc_id as exc_prc_id ";
				$queryString = $queryString . ", prt_processes_parent.prc_virgo_title as `process` ";
			} else {
				if ($defaultOrderColumn == "process") {
					$orderColumnNotDisplayed = " prt_processes_parent.prc_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_executions ";
			if (class_exists('portal\virgoProcess')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_processes AS prt_processes_parent ON (prt_executions.exc_prc_id = prt_processes_parent.prc_id) ";
			}

		$resultsExecution = $resultExecution->select(
			'', 
			'all', 
			$resultExecution->getOrderColumn(), 
			$resultExecution->getOrderMode(), 
			$whereClauseExecution,
			$queryString);
		
		foreach ($resultsExecution as $resultExecution) {

			if (P('show_pdf_begin', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultExecution['exc_begin'])) + 6;
				if ($tmpLen > $minWidth['begin']) {
					$minWidth['begin'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_progress', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultExecution['exc_progress'])) + 6;
				if ($tmpLen > $minWidth['progress']) {
					$minWidth['progress'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_end', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultExecution['exc_end'])) + 6;
				if ($tmpLen > $minWidth['end']) {
					$minWidth['end'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_result', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultExecution['exc_result'])) + 6;
				if ($tmpLen > $minWidth['result']) {
					$minWidth['result'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_statistics', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultExecution['exc_statistics'])) + 6;
				if ($tmpLen > $minWidth['statistics']) {
					$minWidth['statistics'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_process', "1") == "1") {
			$parentValue = trim(virgoProcess::lookup($resultExecution['excprc__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['process $relation.name']) {
					$minWidth['process $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaExecution = $resultExecution->getCriteria();
		if (is_null($criteriaExecution) || sizeof($criteriaExecution) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																			if (P('show_pdf_begin', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['begin'], $colHeight, T('BEGIN'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_progress', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['progress'], $colHeight, T('PROGRESS'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_end', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['end'], $colHeight, T('END'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_result', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['result'], $colHeight, T('RESULT'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_statistics', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['statistics'], $colHeight, T('STATISTICS'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_process', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['process $relation.name'], $colHeight, T('PROCESS') . ' ' . T(''), 'T', 'C', 0, 0); 
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
		foreach ($resultsExecution as $resultExecution) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_begin', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['begin'], $colHeight, '' . $resultExecution['exc_begin'], 'T', 'L', 0, 0);
				if (P('show_pdf_begin', "1") == "2") {
										if (!is_null($resultExecution['exc_begin'])) {
						$tmpCount = (float)$counts["begin"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["begin"] = $tmpCount;
					}
				}
				if (P('show_pdf_begin', "1") == "3") {
										if (!is_null($resultExecution['exc_begin'])) {
						$tmpSum = (float)$sums["begin"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultExecution['exc_begin'];
						}
						$sums["begin"] = $tmpSum;
					}
				}
				if (P('show_pdf_begin', "1") == "4") {
										if (!is_null($resultExecution['exc_begin'])) {
						$tmpCount = (float)$avgCounts["begin"];
						$tmpSum = (float)$avgSums["begin"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["begin"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultExecution['exc_begin'];
						}
						$avgSums["begin"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_progress', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['progress'], $colHeight, '' . $resultExecution['exc_progress'], 'T', 'R', 0, 0);
				if (P('show_pdf_progress', "1") == "2") {
										if (!is_null($resultExecution['exc_progress'])) {
						$tmpCount = (float)$counts["progress"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["progress"] = $tmpCount;
					}
				}
				if (P('show_pdf_progress', "1") == "3") {
										if (!is_null($resultExecution['exc_progress'])) {
						$tmpSum = (float)$sums["progress"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultExecution['exc_progress'];
						}
						$sums["progress"] = $tmpSum;
					}
				}
				if (P('show_pdf_progress', "1") == "4") {
										if (!is_null($resultExecution['exc_progress'])) {
						$tmpCount = (float)$avgCounts["progress"];
						$tmpSum = (float)$avgSums["progress"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["progress"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultExecution['exc_progress'];
						}
						$avgSums["progress"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_end', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['end'], $colHeight, '' . $resultExecution['exc_end'], 'T', 'L', 0, 0);
				if (P('show_pdf_end', "1") == "2") {
										if (!is_null($resultExecution['exc_end'])) {
						$tmpCount = (float)$counts["end"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["end"] = $tmpCount;
					}
				}
				if (P('show_pdf_end', "1") == "3") {
										if (!is_null($resultExecution['exc_end'])) {
						$tmpSum = (float)$sums["end"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultExecution['exc_end'];
						}
						$sums["end"] = $tmpSum;
					}
				}
				if (P('show_pdf_end', "1") == "4") {
										if (!is_null($resultExecution['exc_end'])) {
						$tmpCount = (float)$avgCounts["end"];
						$tmpSum = (float)$avgSums["end"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["end"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultExecution['exc_end'];
						}
						$avgSums["end"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_result', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['result'], $colHeight, '' . $resultExecution['exc_result'], 'T', 'L', 0, 0);
				if (P('show_pdf_result', "1") == "2") {
										if (!is_null($resultExecution['exc_result'])) {
						$tmpCount = (float)$counts["result"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["result"] = $tmpCount;
					}
				}
				if (P('show_pdf_result', "1") == "3") {
										if (!is_null($resultExecution['exc_result'])) {
						$tmpSum = (float)$sums["result"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultExecution['exc_result'];
						}
						$sums["result"] = $tmpSum;
					}
				}
				if (P('show_pdf_result', "1") == "4") {
										if (!is_null($resultExecution['exc_result'])) {
						$tmpCount = (float)$avgCounts["result"];
						$tmpSum = (float)$avgSums["result"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["result"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultExecution['exc_result'];
						}
						$avgSums["result"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_statistics', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['statistics'], $colHeight, '' . $resultExecution['exc_statistics'], 'T', 'L', 0, 0);
				if (P('show_pdf_statistics', "1") == "2") {
										if (!is_null($resultExecution['exc_statistics'])) {
						$tmpCount = (float)$counts["statistics"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["statistics"] = $tmpCount;
					}
				}
				if (P('show_pdf_statistics', "1") == "3") {
										if (!is_null($resultExecution['exc_statistics'])) {
						$tmpSum = (float)$sums["statistics"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultExecution['exc_statistics'];
						}
						$sums["statistics"] = $tmpSum;
					}
				}
				if (P('show_pdf_statistics', "1") == "4") {
										if (!is_null($resultExecution['exc_statistics'])) {
						$tmpCount = (float)$avgCounts["statistics"];
						$tmpSum = (float)$avgSums["statistics"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["statistics"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultExecution['exc_statistics'];
						}
						$avgSums["statistics"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_process', "1") == "1") {
			$parentValue = virgoProcess::lookup($resultExecution['exc_prc_id']);
			$tmpLn = $pdf->MultiCell($minWidth['process $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
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
			if (P('show_pdf_begin', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['begin'];
				if (P('show_pdf_begin', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["begin"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_progress', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['progress'];
				if (P('show_pdf_progress', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["progress"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_end', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['end'];
				if (P('show_pdf_end', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["end"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_result', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['result'];
				if (P('show_pdf_result', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["result"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_statistics', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['statistics'];
				if (P('show_pdf_statistics', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["statistics"];
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
			if (P('show_pdf_begin', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['begin'];
				if (P('show_pdf_begin', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["begin"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_progress', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['progress'];
				if (P('show_pdf_progress', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["progress"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_end', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['end'];
				if (P('show_pdf_end', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["end"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_result', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['result'];
				if (P('show_pdf_result', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["result"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_statistics', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['statistics'];
				if (P('show_pdf_statistics', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["statistics"], 2, ',', ' ');
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
			if (P('show_pdf_begin', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['begin'];
				if (P('show_pdf_begin', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["begin"] == 0 ? "-" : $avgSums["begin"] / $avgCounts["begin"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_progress', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['progress'];
				if (P('show_pdf_progress', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["progress"] == 0 ? "-" : $avgSums["progress"] / $avgCounts["progress"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_end', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['end'];
				if (P('show_pdf_end', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["end"] == 0 ? "-" : $avgSums["end"] / $avgCounts["end"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_result', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['result'];
				if (P('show_pdf_result', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["result"] == 0 ? "-" : $avgSums["result"] / $avgCounts["result"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_statistics', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['statistics'];
				if (P('show_pdf_statistics', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["statistics"] == 0 ? "-" : $avgSums["statistics"] / $avgCounts["statistics"]);
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
				$reportTitle = T('EXECUTIONS');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultExecution = new virgoExecution();
			$whereClauseExecution = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseExecution = $whereClauseExecution . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_begin', "1") != "0") {
					$data = $data . $stringDelimeter .'Begin' . $stringDelimeter . $separator;
				}
				if (P('show_export_progress', "1") != "0") {
					$data = $data . $stringDelimeter .'Progress' . $stringDelimeter . $separator;
				}
				if (P('show_export_end', "1") != "0") {
					$data = $data . $stringDelimeter .'End' . $stringDelimeter . $separator;
				}
				if (P('show_export_result', "1") != "0") {
					$data = $data . $stringDelimeter .'Result' . $stringDelimeter . $separator;
				}
				if (P('show_export_statistics', "1") != "0") {
					$data = $data . $stringDelimeter .'Statistics' . $stringDelimeter . $separator;
				}
				if (P('show_export_process', "1") != "0") {
					$data = $data . $stringDelimeter . 'Process ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_executions.exc_id, prt_executions.exc_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_begin', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_begin exc_begin";
			} else {
				if ($defaultOrderColumn == "exc_begin") {
					$orderColumnNotDisplayed = " prt_executions.exc_begin ";
				}
			}
			if (P('show_export_progress', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_progress exc_progress";
			} else {
				if ($defaultOrderColumn == "exc_progress") {
					$orderColumnNotDisplayed = " prt_executions.exc_progress ";
				}
			}
			if (P('show_export_end', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_end exc_end";
			} else {
				if ($defaultOrderColumn == "exc_end") {
					$orderColumnNotDisplayed = " prt_executions.exc_end ";
				}
			}
			if (P('show_export_result', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_result exc_result";
			} else {
				if ($defaultOrderColumn == "exc_result") {
					$orderColumnNotDisplayed = " prt_executions.exc_result ";
				}
			}
			if (P('show_export_statistics', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_statistics exc_statistics";
			} else {
				if ($defaultOrderColumn == "exc_statistics") {
					$orderColumnNotDisplayed = " prt_executions.exc_statistics ";
				}
			}
			if (class_exists('portal\virgoProcess') && P('show_export_process', "1") != "0") { // */ && !in_array("prc", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_executions.exc_prc_id as exc_prc_id ";
				$queryString = $queryString . ", prt_processes_parent.prc_virgo_title as `process` ";
			} else {
				if ($defaultOrderColumn == "process") {
					$orderColumnNotDisplayed = " prt_processes_parent.prc_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_executions ";
			if (class_exists('portal\virgoProcess')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_processes AS prt_processes_parent ON (prt_executions.exc_prc_id = prt_processes_parent.prc_id) ";
			}

			$resultsExecution = $resultExecution->select(
				'', 
				'all', 
				$resultExecution->getOrderColumn(), 
				$resultExecution->getOrderMode(), 
				$whereClauseExecution,
				$queryString);
			foreach ($resultsExecution as $resultExecution) {
				if (P('show_export_begin', "1") != "0") {
			$data = $data . $resultExecution['exc_begin'] . $separator;
				}
				if (P('show_export_progress', "1") != "0") {
			$data = $data . $resultExecution['exc_progress'] . $separator;
				}
				if (P('show_export_end', "1") != "0") {
			$data = $data . $resultExecution['exc_end'] . $separator;
				}
				if (P('show_export_result', "1") != "0") {
			$data = $data . $stringDelimeter . $resultExecution['exc_result'] . $stringDelimeter . $separator;
				}
				if (P('show_export_statistics', "1") != "0") {
			$data = $data . $resultExecution['exc_statistics'] . $separator;
				}
				if (P('show_export_process', "1") != "0") {
					$parentValue = virgoProcess::lookup($resultExecution['exc_prc_id']);
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
				$reportTitle = T('EXECUTIONS');
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
			$resultExecution = new virgoExecution();
			$whereClauseExecution = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseExecution = $whereClauseExecution . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_begin', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Begin');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_progress', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Progress');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_end', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'End');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_result', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Result');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_statistics', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Statistics');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_process', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Process ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoProcess::getVirgoList();
					$formulaProcess = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaProcess != "") {
							$formulaProcess = $formulaProcess . ',';
						}
						$formulaProcess = $formulaProcess . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_executions.exc_id, prt_executions.exc_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_begin', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_begin exc_begin";
			} else {
				if ($defaultOrderColumn == "exc_begin") {
					$orderColumnNotDisplayed = " prt_executions.exc_begin ";
				}
			}
			if (P('show_export_progress', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_progress exc_progress";
			} else {
				if ($defaultOrderColumn == "exc_progress") {
					$orderColumnNotDisplayed = " prt_executions.exc_progress ";
				}
			}
			if (P('show_export_end', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_end exc_end";
			} else {
				if ($defaultOrderColumn == "exc_end") {
					$orderColumnNotDisplayed = " prt_executions.exc_end ";
				}
			}
			if (P('show_export_result', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_result exc_result";
			} else {
				if ($defaultOrderColumn == "exc_result") {
					$orderColumnNotDisplayed = " prt_executions.exc_result ";
				}
			}
			if (P('show_export_statistics', "1") != "0") {
				$queryString = $queryString . ", prt_executions.exc_statistics exc_statistics";
			} else {
				if ($defaultOrderColumn == "exc_statistics") {
					$orderColumnNotDisplayed = " prt_executions.exc_statistics ";
				}
			}
			if (class_exists('portal\virgoProcess') && P('show_export_process', "1") != "0") { // */ && !in_array("prc", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_executions.exc_prc_id as exc_prc_id ";
				$queryString = $queryString . ", prt_processes_parent.prc_virgo_title as `process` ";
			} else {
				if ($defaultOrderColumn == "process") {
					$orderColumnNotDisplayed = " prt_processes_parent.prc_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_executions ";
			if (class_exists('portal\virgoProcess')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_processes AS prt_processes_parent ON (prt_executions.exc_prc_id = prt_processes_parent.prc_id) ";
			}

			$resultsExecution = $resultExecution->select(
				'', 
				'all', 
				$resultExecution->getOrderColumn(), 
				$resultExecution->getOrderMode(), 
				$whereClauseExecution,
				$queryString);
			$index = 1;
			foreach ($resultsExecution as $resultExecution) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultExecution['exc_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_begin', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultExecution['exc_begin'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_progress', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultExecution['exc_progress'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_end', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultExecution['exc_end'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_result', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultExecution['exc_result'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_statistics', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultExecution['exc_statistics'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_process', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoProcess::lookup($resultExecution['exc_prc_id']);
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
					$objValidation->setFormula1('"' . $formulaProcess . '"');
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
					$propertyColumnHash['begin'] = 'exc_begin';
					$propertyColumnHash['begin'] = 'exc_begin';
					$propertyColumnHash['progress'] = 'exc_progress';
					$propertyColumnHash['progress'] = 'exc_progress';
					$propertyColumnHash['end'] = 'exc_end';
					$propertyColumnHash['end'] = 'exc_end';
					$propertyColumnHash['result'] = 'exc_result';
					$propertyColumnHash['result'] = 'exc_result';
					$propertyColumnHash['statistics'] = 'exc_statistics';
					$propertyColumnHash['statistics'] = 'exc_statistics';
					$propertyClassHash['process'] = 'Process';
					$propertyClassHash['process'] = 'Process';
					$propertyColumnHash['process'] = 'exc_prc_id';
					$propertyColumnHash['process'] = 'exc_prc_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importExecution = new virgoExecution();
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
										L(T('PROPERTY_NOT_FOUND', T('EXECUTION'), $columns[$index]), '', 'ERROR');
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
										$importExecution->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_process');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoProcess::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoProcess::token2Id($tmpToken);
	}
	$importExecution->setPrcId($defaultValue);
}
							$errorMessage = $importExecution->store();
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

		static function portletActionVirgoSetProcess() {
			$this->loadFromDB();
			$parentId = R('exc_Process_id_' . $_SESSION['current_portlet_object_id']);
			$this->setPrcId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}

		static function portletActionAddProcess() {
			self::setDisplayMode("ADD_NEW_PARENT_PROCESS");
		}

		static function portletActionStoreNewProcess() {
			$id = -1;
			if (virgoProcess::portletActionStore(true, $id) == -1) {
				self::setDisplayMode("ADD_NEW_PARENT_PROCESS");
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			} else {
				$tmpId = self::loadIdFromRequest();
				$_POST['exc_process_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
				self::portletActionBackFromParent();
			}
		}

		static function portletActionBackFromParent() {
			$calligView = strtoupper(R('calling_view'));
			self::setDisplayMode($calligView);
			$pob = self::getMyPortletObject();
			$pob->setPortletSessionValue('reload_from_request', '1');				
		}
			function _($message) {
				I('SystemMessage'); 
				$systemMessage = new virgoSystemMessage();
				$systemMessage->setTimestamp(date("Y-m-d H:i:s"));
				$logLevel = virgoLogLevel::getByNameStatic('INFO');
				$systemMessage->setLogLevelId($logLevel->getId()); 
				$systemMessage->setMessage($message);
				$systemMessage->setIp(virgoSystemMessage::getRealIp());
				$systemMessage->setUrl(virgoSystemMessage::getRealUrl());
				$user = virgoUser::getUser();
				$systemMessage->setUserId($user->getId());
				$systemMessage->setExcId($this->getId());
				$systemMessage->store(false);
			}
			

			function push() {
				$process = $this->getProcess();
				$portionSize = $process->getPortionSize();
				$process->setSubprocessCount($process->getSubprocessCount() + 1);
				$process->store();
				$processedAmount = 0;
				while (is_null($portionSize) || $portionSize > $processedAmount) {
					$query = "SELECT MIN(elm_id) FROM prt_elements WHERE elm_processed IS NULL AND elm_exc_id = " . $this->getId();
					$minElmId = Q1($query);
					if (!is_null($minElmId)) {
						$element = new virgoElement((int)$minElmId);
						$element->process();
						$processedAmount = $processedAmount + 1;
					} else {
						$this->setEnd(date("Y-m-d H:i:s"));
						$this->setProgress(100);
						$virgoResult = "";
						$virgoExecution = $this;
						if (false) {
							$prefix = " ?> ";
							$sufix = " <?php ";
						} else {
							$prefix = "";
							$sufix = "";
						}
						ob_start();
						eval($prefix . " " . $this->getProcess()->getClosingCode() . " " . $sufix);
						if ('' !== $error = ob_get_clean()) {
							L($error, '', 'ERROR');
						}			
						if ($virgoResult == "") {
							$virgoResult = $this->getStatistics();
						}
						$this->setResult($virgoResult);
						$this->store();
						if ($process->getClear() == 1) {
							$query = "DELETE FROM prt_elements WHERE elm_exc_id = " . $this->getId();
							Q($query);
							$this->_("Elementy usunięto");
						}
						$process->setSubprocessCount($process->getSubprocessCount() + 1);
						$process->store();
						return;
					}
				}
				$process->setSubprocessCount($process->getSubprocessCount() + 1);
				$process->store();
			}
			
			function addParameter($name, $value) {
				$executionParameter = new virgoExecutionParameter();
				$executionParameter->setExcId($this->getId());
				$executionParameter->setName($name);
				$executionParameter->setValue($value);
				LE($executionParameter->store());
			}
			
			function getParameterValue($name, $default = null) {
				$parameters = virgoExecutionParameter::selectAllAsObjectsStatic(" epr_name = '{$name}' ");
				if (count($parameters) == 0) {
					return $default;
				} 
				$val = $parameters[0];
				return $val->getValue();
			}


		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `prt_executions` (
  `exc_id` bigint(20) unsigned NOT NULL auto_increment,
  `exc_virgo_state` varchar(50) default NULL,
  `exc_virgo_title` varchar(255) default NULL,
	`exc_prc_id` int(11) default NULL,
  `exc_begin` datetime, 
  `exc_progress` integer,  
  `exc_end` datetime, 
  `exc_result` varchar(255), 
  `exc_statistics` longtext, 
  `exc_date_created` datetime NOT NULL,
  `exc_date_modified` datetime default NULL,
  `exc_usr_created_id` int(11) NOT NULL,
  `exc_usr_modified_id` int(11) default NULL,
  KEY `exc_prc_fk` (`exc_prc_id`),
  PRIMARY KEY  (`exc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/execution.sql 
INSERT INTO `prt_executions` (`exc_virgo_title`, `exc_begin`, `exc_progress`, `exc_end`, `exc_result`, `exc_statistics`) 
VALUES (title, some_value, some_value, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_executions table already exists.", '', 'FATAL');
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
			return "exc";
		}
		
		static function getPlural() {
			return "executions";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoProcess";
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoSystemMessage";
			$ret[] = "virgoElement";
			$ret[] = "virgoExecutionParameter";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_executions'));
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
			$virgoVersion = virgoExecution::getVirgoVersion();
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
	
	

