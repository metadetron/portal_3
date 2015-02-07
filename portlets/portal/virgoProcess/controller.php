<?php
/**
* Module Process
* @package Portal
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace portal;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoProcess {

		 var  $prc_id = null;
		 var  $prc_name = null;

		 var  $prc_execution_time = null;

		 var  $prc_description = null;

		 var  $prc_initiation_code = null;

		 var  $prc_execution_code = null;

		 var  $prc_closing_code = null;

		 var  $prc_portion_size = null;

		 var  $prc_active = null;

		 var  $prc_order = null;

		 var  $prc_last_session = null;

		 var  $prc_subprocess_count = null;

		 var  $prc_clear = null;


		 var   $prc_date_created = null;
		 var   $prc_usr_created_id = null;
		 var   $prc_date_modified = null;
		 var   $prc_usr_modified_id = null;
		 var   $prc_virgo_title = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoProcess();
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
        	$this->prc_id = null;
		    $this->prc_date_created = null;
		    $this->prc_usr_created_id = null;
		    $this->prc_date_modified = null;
		    $this->prc_usr_modified_id = null;
		    $this->prc_virgo_title = null;
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
			return $this->prc_id;
		}

		function getName() {
			return $this->prc_name;
		}
		
		 function setName($val) {
			$this->prc_name = $val;
		}
		function getExecutionTime() {
			return $this->prc_execution_time;
		}
		
		 function setExecutionTime($val) {
			$this->prc_execution_time = $val;
		}
		function getDescription() {
			return $this->prc_description;
		}
		
		 function setDescription($val) {
			$this->prc_description = $val;
		}
		function getInitiationCode() {
			return $this->prc_initiation_code;
		}
		
		 function setInitiationCode($val) {
			$this->prc_initiation_code = $val;
		}
		function getExecutionCode() {
			return $this->prc_execution_code;
		}
		
		 function setExecutionCode($val) {
			$this->prc_execution_code = $val;
		}
		function getClosingCode() {
			return $this->prc_closing_code;
		}
		
		 function setClosingCode($val) {
			$this->prc_closing_code = $val;
		}
		function getPortionSize() {
			return $this->prc_portion_size;
		}
		
		 function setPortionSize($val) {
			$this->prc_portion_size = $val;
		}
		function getActive() {
			return $this->prc_active;
		}
		
		 function setActive($val) {
			$this->prc_active = $val;
		}
		function getOrder() {
			return $this->prc_order;
		}
		
		 function setOrder($val) {
			$this->prc_order = $val;
		}
		function getLastSession() {
			return $this->prc_last_session;
		}
		
		 function setLastSession($val) {
			$this->prc_last_session = $val;
		}
		function getSubprocessCount() {
			return $this->prc_subprocess_count;
		}
		
		 function setSubprocessCount($val) {
			$this->prc_subprocess_count = $val;
		}
		function getClear() {
			return $this->prc_clear;
		}
		
		 function setClear($val) {
			$this->prc_clear = $val;
		}


		function getDateCreated() {
			return $this->prc_date_created;
		}
		function getUsrCreatedId() {
			return $this->prc_usr_created_id;
		}
		function getDateModified() {
			return $this->prc_date_modified;
		}
		function getUsrModifiedId() {
			return $this->prc_usr_modified_id;
		}



		function getDescriptionSnippet($wordCount) {
			if (is_null($this->getDescription()) || trim($this->getDescription()) == "") {
				return "";
			}
		  	return implode( 
			    '', 
		    	array_slice( 
		      		preg_split(
			        	'/([\s,\.;\?\!]+)/', 
		        		$this->getDescription(), 
		        		$wordCount*2+1, 
		        		PREG_SPLIT_DELIM_CAPTURE
		      		),
		      		0,
		      		$wordCount*2-1
		    	)
		  	)."...";
		}
		function loadRecordFromRequest($rowId) {
			$this->prc_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('prc_name_' . $this->prc_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->prc_name = null;
		} else {
			$this->prc_name = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('prc_executionTime_' . $this->prc_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->prc_execution_time = null;
		} else {
			$this->prc_execution_time = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('prc_description_' . $this->prc_id);
	if (!is_null($tmpValue)) {
		if ($tmpValue == "") {
			$this->prc_description = null;
		} else {
			$this->prc_description = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('prc_initiationCode_' . $this->prc_id);
	if (!is_null($tmpValue)) {
		if ($tmpValue == "") {
			$this->prc_initiation_code = null;
		} else {
			$this->prc_initiation_code = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('prc_executionCode_' . $this->prc_id);
	if (!is_null($tmpValue)) {
		if ($tmpValue == "") {
			$this->prc_execution_code = null;
		} else {
			$this->prc_execution_code = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('prc_closingCode_' . $this->prc_id);
	if (!is_null($tmpValue)) {
		if ($tmpValue == "") {
			$this->prc_closing_code = null;
		} else {
			$this->prc_closing_code = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('prc_portionSize_' . $this->prc_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->prc_portion_size = null;
		} else {
			$this->prc_portion_size = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('prc_active_' . $this->prc_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->prc_active = null;
		} else {
			$this->prc_active = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('prc_order_' . $this->prc_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->prc_order = null;
		} else {
			$this->prc_order = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('prc_lastSession_' . $this->prc_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->prc_last_session = null;
		} else {
			$this->prc_last_session = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('prc_subprocessCount_' . $this->prc_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->prc_subprocess_count = null;
		} else {
			$this->prc_subprocess_count = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('prc_clear_' . $this->prc_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->prc_clear = null;
		} else {
			$this->prc_clear = $tmpValue;
		}
	}

		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('prc_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaProcess = array();	
			$criteriaFieldProcess = array();	
			$isNullProcess = R('virgo_search_name_is_null');
			
			$criteriaFieldProcess["is_null"] = 0;
			if ($isNullProcess == "not_null") {
				$criteriaFieldProcess["is_null"] = 1;
			} elseif ($isNullProcess == "null") {
				$criteriaFieldProcess["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_name');

//			if ($isSet) {
			$criteriaFieldProcess["value"] = $dataTypeCriteria;
//			}
			$criteriaProcess["name"] = $criteriaFieldProcess;
			$criteriaFieldProcess = array();	
			$isNullProcess = R('virgo_search_executionTime_is_null');
			
			$criteriaFieldProcess["is_null"] = 0;
			if ($isNullProcess == "not_null") {
				$criteriaFieldProcess["is_null"] = 1;
			} elseif ($isNullProcess == "null") {
				$criteriaFieldProcess["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_executionTime');

//			if ($isSet) {
			$criteriaFieldProcess["value"] = $dataTypeCriteria;
//			}
			$criteriaProcess["execution_time"] = $criteriaFieldProcess;
			$criteriaFieldProcess = array();	
			$isNullProcess = R('virgo_search_description_is_null');
			
			$criteriaFieldProcess["is_null"] = 0;
			if ($isNullProcess == "not_null") {
				$criteriaFieldProcess["is_null"] = 1;
			} elseif ($isNullProcess == "null") {
				$criteriaFieldProcess["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_description');

//			if ($isSet) {
			$criteriaFieldProcess["value"] = $dataTypeCriteria;
//			}
			$criteriaProcess["description"] = $criteriaFieldProcess;
			$criteriaFieldProcess = array();	
			$isNullProcess = R('virgo_search_initiationCode_is_null');
			
			$criteriaFieldProcess["is_null"] = 0;
			if ($isNullProcess == "not_null") {
				$criteriaFieldProcess["is_null"] = 1;
			} elseif ($isNullProcess == "null") {
				$criteriaFieldProcess["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
//			if ($isSet) {
			$criteriaFieldProcess["value"] = $dataTypeCriteria;
//			}
			$criteriaProcess["initiation_code"] = $criteriaFieldProcess;
			$criteriaFieldProcess = array();	
			$isNullProcess = R('virgo_search_executionCode_is_null');
			
			$criteriaFieldProcess["is_null"] = 0;
			if ($isNullProcess == "not_null") {
				$criteriaFieldProcess["is_null"] = 1;
			} elseif ($isNullProcess == "null") {
				$criteriaFieldProcess["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
//			if ($isSet) {
			$criteriaFieldProcess["value"] = $dataTypeCriteria;
//			}
			$criteriaProcess["execution_code"] = $criteriaFieldProcess;
			$criteriaFieldProcess = array();	
			$isNullProcess = R('virgo_search_closingCode_is_null');
			
			$criteriaFieldProcess["is_null"] = 0;
			if ($isNullProcess == "not_null") {
				$criteriaFieldProcess["is_null"] = 1;
			} elseif ($isNullProcess == "null") {
				$criteriaFieldProcess["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
//			if ($isSet) {
			$criteriaFieldProcess["value"] = $dataTypeCriteria;
//			}
			$criteriaProcess["closing_code"] = $criteriaFieldProcess;
			$criteriaFieldProcess = array();	
			$isNullProcess = R('virgo_search_portionSize_is_null');
			
			$criteriaFieldProcess["is_null"] = 0;
			if ($isNullProcess == "not_null") {
				$criteriaFieldProcess["is_null"] = 1;
			} elseif ($isNullProcess == "null") {
				$criteriaFieldProcess["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_portionSize_from');
		$dataTypeCriteria["to"] = R('virgo_search_portionSize_to');

//			if ($isSet) {
			$criteriaFieldProcess["value"] = $dataTypeCriteria;
//			}
			$criteriaProcess["portion_size"] = $criteriaFieldProcess;
			$criteriaFieldProcess = array();	
			$isNullProcess = R('virgo_search_active_is_null');
			
			$criteriaFieldProcess["is_null"] = 0;
			if ($isNullProcess == "not_null") {
				$criteriaFieldProcess["is_null"] = 1;
			} elseif ($isNullProcess == "null") {
				$criteriaFieldProcess["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_active');

//			if ($isSet) {
			$criteriaFieldProcess["value"] = $dataTypeCriteria;
//			}
			$criteriaProcess["active"] = $criteriaFieldProcess;
			$criteriaFieldProcess = array();	
			$isNullProcess = R('virgo_search_order_is_null');
			
			$criteriaFieldProcess["is_null"] = 0;
			if ($isNullProcess == "not_null") {
				$criteriaFieldProcess["is_null"] = 1;
			} elseif ($isNullProcess == "null") {
				$criteriaFieldProcess["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_order_from');
		$dataTypeCriteria["to"] = R('virgo_search_order_to');

//			if ($isSet) {
			$criteriaFieldProcess["value"] = $dataTypeCriteria;
//			}
			$criteriaProcess["order"] = $criteriaFieldProcess;
			$criteriaFieldProcess = array();	
			$isNullProcess = R('virgo_search_lastSession_is_null');
			
			$criteriaFieldProcess["is_null"] = 0;
			if ($isNullProcess == "not_null") {
				$criteriaFieldProcess["is_null"] = 1;
			} elseif ($isNullProcess == "null") {
				$criteriaFieldProcess["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_lastSession');

//			if ($isSet) {
			$criteriaFieldProcess["value"] = $dataTypeCriteria;
//			}
			$criteriaProcess["last_session"] = $criteriaFieldProcess;
			$criteriaFieldProcess = array();	
			$isNullProcess = R('virgo_search_subprocessCount_is_null');
			
			$criteriaFieldProcess["is_null"] = 0;
			if ($isNullProcess == "not_null") {
				$criteriaFieldProcess["is_null"] = 1;
			} elseif ($isNullProcess == "null") {
				$criteriaFieldProcess["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_subprocessCount_from');
		$dataTypeCriteria["to"] = R('virgo_search_subprocessCount_to');

//			if ($isSet) {
			$criteriaFieldProcess["value"] = $dataTypeCriteria;
//			}
			$criteriaProcess["subprocess_count"] = $criteriaFieldProcess;
			$criteriaFieldProcess = array();	
			$isNullProcess = R('virgo_search_clear_is_null');
			
			$criteriaFieldProcess["is_null"] = 0;
			if ($isNullProcess == "not_null") {
				$criteriaFieldProcess["is_null"] = 1;
			} elseif ($isNullProcess == "null") {
				$criteriaFieldProcess["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_clear');

//			if ($isSet) {
			$criteriaFieldProcess["value"] = $dataTypeCriteria;
//			}
			$criteriaProcess["clear"] = $criteriaFieldProcess;
			self::setCriteria($criteriaProcess);
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
			$tableFilter = R('virgo_filter_execution_time');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterExecutionTime', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterExecutionTime', null);
			}
			$tableFilter = R('virgo_filter_description');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterDescription', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterDescription', null);
			}
			$tableFilter = R('virgo_filter_initiation_code');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterInitiationCode', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterInitiationCode', null);
			}
			$tableFilter = R('virgo_filter_execution_code');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterExecutionCode', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterExecutionCode', null);
			}
			$tableFilter = R('virgo_filter_closing_code');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterClosingCode', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterClosingCode', null);
			}
			$tableFilter = R('virgo_filter_portion_size');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterPortionSize', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterPortionSize', null);
			}
			$tableFilter = R('virgo_filter_active');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterActive', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterActive', null);
			}
			$tableFilter = R('virgo_filter_order');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterOrder', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterOrder', null);
			}
			$tableFilter = R('virgo_filter_last_session');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterLastSession', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterLastSession', null);
			}
			$tableFilter = R('virgo_filter_subprocess_count');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterSubprocessCount', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterSubprocessCount', null);
			}
			$tableFilter = R('virgo_filter_clear');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterClear', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterClear', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseProcess = ' 1 = 1 ';
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
				$eventColumn = "prc_" . P('event_column');
				$whereClauseProcess = $whereClauseProcess . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseProcess = $whereClauseProcess . ' AND ' . $parentContextInfo['condition'];
			}
			$filter = "";
			$criteriaProcess = self::getCriteria();
			if (isset($criteriaProcess["name"])) {
				$fieldCriteriaName = $criteriaProcess["name"];
				if ($fieldCriteriaName["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_name IS NOT NULL ';
				} elseif ($fieldCriteriaName["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_processes.prc_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaProcess["execution_time"])) {
				$fieldCriteriaExecutionTime = $criteriaProcess["execution_time"];
				if ($fieldCriteriaExecutionTime["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_execution_time IS NOT NULL ';
				} elseif ($fieldCriteriaExecutionTime["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_execution_time IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaExecutionTime["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_processes.prc_execution_time like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaProcess["description"])) {
				$fieldCriteriaDescription = $criteriaProcess["description"];
				if ($fieldCriteriaDescription["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_description IS NOT NULL ';
				} elseif ($fieldCriteriaDescription["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_description IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDescription["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_processes.prc_description like ? ";
				$types .= "s";
				$values[] = $condition;				
			}
				}
			}
			if (isset($criteriaProcess["initiation_code"])) {
				$fieldCriteriaInitiationCode = $criteriaProcess["initiation_code"];
				if ($fieldCriteriaInitiationCode["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_initiation_code IS NOT NULL ';
				} elseif ($fieldCriteriaInitiationCode["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_initiation_code IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaInitiationCode["value"];
				}
			}
			if (isset($criteriaProcess["execution_code"])) {
				$fieldCriteriaExecutionCode = $criteriaProcess["execution_code"];
				if ($fieldCriteriaExecutionCode["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_execution_code IS NOT NULL ';
				} elseif ($fieldCriteriaExecutionCode["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_execution_code IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaExecutionCode["value"];
				}
			}
			if (isset($criteriaProcess["closing_code"])) {
				$fieldCriteriaClosingCode = $criteriaProcess["closing_code"];
				if ($fieldCriteriaClosingCode["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_closing_code IS NOT NULL ';
				} elseif ($fieldCriteriaClosingCode["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_closing_code IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaClosingCode["value"];
				}
			}
			if (isset($criteriaProcess["portion_size"])) {
				$fieldCriteriaPortionSize = $criteriaProcess["portion_size"];
				if ($fieldCriteriaPortionSize["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_portion_size IS NOT NULL ';
				} elseif ($fieldCriteriaPortionSize["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_portion_size IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaPortionSize["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_processes.prc_portion_size = ? ";
				} else {
					$filter = $filter . " AND prt_processes.prc_portion_size >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_processes.prc_portion_size <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaProcess["active"])) {
				$fieldCriteriaActive = $criteriaProcess["active"];
				if ($fieldCriteriaActive["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_active IS NOT NULL ';
				} elseif ($fieldCriteriaActive["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_active IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaActive["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_processes.prc_active = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaProcess["order"])) {
				$fieldCriteriaOrder = $criteriaProcess["order"];
				if ($fieldCriteriaOrder["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_order IS NOT NULL ';
				} elseif ($fieldCriteriaOrder["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_order IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaOrder["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_processes.prc_order = ? ";
				} else {
					$filter = $filter . " AND prt_processes.prc_order >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_processes.prc_order <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaProcess["last_session"])) {
				$fieldCriteriaLastSession = $criteriaProcess["last_session"];
				if ($fieldCriteriaLastSession["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_last_session IS NOT NULL ';
				} elseif ($fieldCriteriaLastSession["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_last_session IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaLastSession["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_processes.prc_last_session like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaProcess["subprocess_count"])) {
				$fieldCriteriaSubprocessCount = $criteriaProcess["subprocess_count"];
				if ($fieldCriteriaSubprocessCount["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_subprocess_count IS NOT NULL ';
				} elseif ($fieldCriteriaSubprocessCount["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_subprocess_count IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaSubprocessCount["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_processes.prc_subprocess_count = ? ";
				} else {
					$filter = $filter . " AND prt_processes.prc_subprocess_count >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_processes.prc_subprocess_count <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaProcess["clear"])) {
				$fieldCriteriaClear = $criteriaProcess["clear"];
				if ($fieldCriteriaClear["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_clear IS NOT NULL ';
				} elseif ($fieldCriteriaClear["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_clear IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaClear["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_processes.prc_clear = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			$whereClauseProcess = $whereClauseProcess . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseProcess = $whereClauseProcess . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseProcess = $whereClauseProcess . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterName', null);
				if (S($tableFilter)) {
					$whereClauseProcess = $whereClauseProcess . " AND prc_name LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterExecutionTime', null);
				if (S($tableFilter)) {
					$whereClauseProcess = $whereClauseProcess . " AND prc_execution_time LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterDescription', null);
				if (S($tableFilter)) {
					$whereClauseProcess = $whereClauseProcess . " AND prc_description LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterInitiationCode', null);
				if (S($tableFilter)) {
					$whereClauseProcess = $whereClauseProcess . " AND prc_initiation_code LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterExecutionCode', null);
				if (S($tableFilter)) {
					$whereClauseProcess = $whereClauseProcess . " AND prc_execution_code LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterClosingCode', null);
				if (S($tableFilter)) {
					$whereClauseProcess = $whereClauseProcess . " AND prc_closing_code LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterPortionSize', null);
				if (S($tableFilter)) {
					$whereClauseProcess = $whereClauseProcess . " AND prc_portion_size LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterActive', null);
				if (S($tableFilter)) {
					$whereClauseProcess = $whereClauseProcess . " AND prc_active LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterOrder', null);
				if (S($tableFilter)) {
					$whereClauseProcess = $whereClauseProcess . " AND prc_order LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterLastSession', null);
				if (S($tableFilter)) {
					$whereClauseProcess = $whereClauseProcess . " AND prc_last_session LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterSubprocessCount', null);
				if (S($tableFilter)) {
					$whereClauseProcess = $whereClauseProcess . " AND prc_subprocess_count LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterClear', null);
				if (S($tableFilter)) {
					$whereClauseProcess = $whereClauseProcess . " AND prc_clear LIKE '%{$tableFilter}%' ";
				}
			}
			return $whereClauseProcess;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseProcess = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_processes.prc_id, prt_processes.prc_virgo_title ";
			$defaultOrderColumn = P('default_sort_column', 'prc_order');
			$orderColumnNotDisplayed = "";
			if (P('show_table_name', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_name prc_name";
			} else {
				if ($defaultOrderColumn == "prc_name") {
					$orderColumnNotDisplayed = " prt_processes.prc_name ";
				}
			}
			if (P('show_table_execution_time', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_execution_time prc_execution_time";
			} else {
				if ($defaultOrderColumn == "prc_execution_time") {
					$orderColumnNotDisplayed = " prt_processes.prc_execution_time ";
				}
			}
			if (P('show_table_description', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_description prc_description";
			} else {
				if ($defaultOrderColumn == "prc_description") {
					$orderColumnNotDisplayed = " prt_processes.prc_description ";
				}
			}
			if (P('show_table_initiation_code', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_initiation_code prc_initiation_code";
			} else {
				if ($defaultOrderColumn == "prc_initiation_code") {
					$orderColumnNotDisplayed = " prt_processes.prc_initiation_code ";
				}
			}
			if (P('show_table_execution_code', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_execution_code prc_execution_code";
			} else {
				if ($defaultOrderColumn == "prc_execution_code") {
					$orderColumnNotDisplayed = " prt_processes.prc_execution_code ";
				}
			}
			if (P('show_table_closing_code', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_closing_code prc_closing_code";
			} else {
				if ($defaultOrderColumn == "prc_closing_code") {
					$orderColumnNotDisplayed = " prt_processes.prc_closing_code ";
				}
			}
			if (P('show_table_portion_size', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_portion_size prc_portion_size";
			} else {
				if ($defaultOrderColumn == "prc_portion_size") {
					$orderColumnNotDisplayed = " prt_processes.prc_portion_size ";
				}
			}
			if (P('show_table_active', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_active prc_active";
			} else {
				if ($defaultOrderColumn == "prc_active") {
					$orderColumnNotDisplayed = " prt_processes.prc_active ";
				}
			}
			if (P('show_table_order', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_order prc_order";
			} else {
				if ($defaultOrderColumn == "prc_order") {
					$orderColumnNotDisplayed = " prt_processes.prc_order ";
				}
			}
			if (P('show_table_last_session', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_last_session prc_last_session";
			} else {
				if ($defaultOrderColumn == "prc_last_session") {
					$orderColumnNotDisplayed = " prt_processes.prc_last_session ";
				}
			}
			if (P('show_table_subprocess_count', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_subprocess_count prc_subprocess_count";
			} else {
				if ($defaultOrderColumn == "prc_subprocess_count") {
					$orderColumnNotDisplayed = " prt_processes.prc_subprocess_count ";
				}
			}
			if (P('show_table_clear', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_clear prc_clear";
			} else {
				if ($defaultOrderColumn == "prc_clear") {
					$orderColumnNotDisplayed = " prt_processes.prc_clear ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_processes ";

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseProcess = $whereClauseProcess . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseProcess, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseProcess,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_processes"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " prc_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " prc_usr_created_id = ? ";
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
				. "\n FROM prt_processes"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_processes ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_processes ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, prc_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " prc_usr_created_id = ? ";
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
				$query = "SELECT COUNT(prc_id) cnt FROM processes";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as processes ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as processes ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoProcess();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_processes WHERE prc_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->prc_id = $row['prc_id'];
$this->prc_name = $row['prc_name'];
$this->prc_execution_time = $row['prc_execution_time'];
$this->prc_description = $row['prc_description'];
$this->prc_initiation_code = $row['prc_initiation_code'];
$this->prc_execution_code = $row['prc_execution_code'];
$this->prc_closing_code = $row['prc_closing_code'];
$this->prc_portion_size = $row['prc_portion_size'];
$this->prc_active = $row['prc_active'];
$this->prc_order = $row['prc_order'];
$this->prc_last_session = $row['prc_last_session'];
$this->prc_subprocess_count = $row['prc_subprocess_count'];
$this->prc_clear = $row['prc_clear'];
						if ($fetchUsernames) {
							if ($row['prc_date_created']) {
								if ($row['prc_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['prc_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['prc_date_modified']) {
								if ($row['prc_usr_modified_id'] == $row['prc_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['prc_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['prc_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->prc_date_created = $row['prc_date_created'];
						$this->prc_usr_created_id = $fetchUsernames ? $createdBy : $row['prc_usr_created_id'];
						$this->prc_date_modified = $row['prc_date_modified'];
						$this->prc_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['prc_usr_modified_id'];
						$this->prc_virgo_title = $row['prc_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_processes SET prc_usr_created_id = {$userId} WHERE prc_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->prc_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoProcess::selectAllAsObjectsStatic('prc_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->prc_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->prc_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('prc_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_prc = new virgoProcess();
				$tmp_prc->load((int)$lookup_id);
				return $tmp_prc->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoProcess');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" prc_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoProcess', "10");
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
				$query = $query . " prc_id as id, prc_virgo_title as title ";
			}
			$query = $query . " FROM prt_processes ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoProcess', 'portal') == "1") {
				$privateCondition = " prc_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY prc_order ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resProcess = array();
				foreach ($rows as $row) {
					$resProcess[$row['id']] = $row['title'];
				}
				return $resProcess;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticProcess = new virgoProcess();
			return $staticProcess->getVirgoList($where, $sizeOnly, $hash);
		}
		

		static function getExecutionsStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resExecution = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resExecution;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resExecution;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsExecution = virgoExecution::selectAll('exc_prc_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsExecution as $resultExecution) {
				$tmpExecution = virgoExecution::getById($resultExecution['exc_id']); 
				array_push($resExecution, $tmpExecution);
			}
			return $resExecution;
		}

		function getExecutions($orderBy = '', $extraWhere = null) {
			return virgoProcess::getExecutionsStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
			if (
(is_null($this->getName()) || trim($this->getName()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'NAME');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_execution_time_obligatory', "0") == "1") {
				if (
(is_null($this->getExecutionTime()) || trim($this->getExecutionTime()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'EXECUTION_TIME');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_description_obligatory', "0") == "1") {
				if (
(is_null($this->getDescription()) || trim($this->getDescription()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'DESCRIPTION');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_initiation_code_obligatory', "0") == "1") {
				if (
(is_null($this->getInitiationCode()) || trim($this->getInitiationCode()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'INITIATION_CODE');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_execution_code_obligatory', "0") == "1") {
				if (
(is_null($this->getExecutionCode()) || trim($this->getExecutionCode()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'EXECUTION_CODE');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_closing_code_obligatory', "0") == "1") {
				if (
(is_null($this->getClosingCode()) || trim($this->getClosingCode()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'CLOSING_CODE');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_portion_size_obligatory', "0") == "1") {
				if (
(is_null($this->getPortionSize()) || trim($this->getPortionSize()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'PORTION_SIZE');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_active_obligatory', "0") == "1") {
				if (
(is_null($this->getActive()) || trim($this->getActive()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'ACTIVE');
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
			if (P('show_'.$tmpMode.'_last_session_obligatory', "0") == "1") {
				if (
(is_null($this->getLastSession()) || trim($this->getLastSession()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'LAST_SESSION');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_subprocess_count_obligatory', "0") == "1") {
				if (
(is_null($this->getSubprocessCount()) || trim($this->getSubprocessCount()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'SUBPROCESS_COUNT');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_clear_obligatory', "0") == "1") {
				if (
(is_null($this->getClear()) || trim($this->getClear()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'CLEAR');
				}			
			}
 			if (!is_null($this->prc_portion_size) && trim($this->prc_portion_size) != "") {
				if (!is_numeric($this->prc_portion_size)) {
					return T('INCORRECT_NUMBER', 'PORTION_SIZE', $this->prc_portion_size);
				}
			}
			if (!is_null($this->prc_order) && trim($this->prc_order) != "") {
				if (!is_numeric($this->prc_order)) {
					return T('INCORRECT_NUMBER', 'ORDER', $this->prc_order);
				}
			}
			if (!is_null($this->prc_subprocess_count) && trim($this->prc_subprocess_count) != "") {
				if (!is_numeric($this->prc_subprocess_count)) {
					return T('INCORRECT_NUMBER', 'SUBPROCESS_COUNT', $this->prc_subprocess_count);
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_processes WHERE prc_id = " . $this->getId();
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
				$colNames = $colNames . ", prc_name";
				$values = $values . ", " . (is_null($objectToStore->getName()) ? "null" : "'" . QE($objectToStore->getName()) . "'");
				$colNames = $colNames . ", prc_execution_time";
				$values = $values . ", " . (is_null($objectToStore->getExecutionTime()) ? "null" : "'" . QE($objectToStore->getExecutionTime()) . "'");
				$colNames = $colNames . ", prc_description";
				$values = $values . ", " . (is_null($objectToStore->getDescription()) ? "null" : "'" . QE($objectToStore->getDescription()) . "'");
				$colNames = $colNames . ", prc_initiation_code";
				$values = $values . ", " . (is_null($objectToStore->getInitiationCode()) ? "null" : "'" . QE($objectToStore->getInitiationCode()) . "'");
				$colNames = $colNames . ", prc_execution_code";
				$values = $values . ", " . (is_null($objectToStore->getExecutionCode()) ? "null" : "'" . QE($objectToStore->getExecutionCode()) . "'");
				$colNames = $colNames . ", prc_closing_code";
				$values = $values . ", " . (is_null($objectToStore->getClosingCode()) ? "null" : "'" . QE($objectToStore->getClosingCode()) . "'");
				$colNames = $colNames . ", prc_portion_size";
				$values = $values . ", " . (is_null($objectToStore->getPortionSize()) ? "null" : "'" . QE($objectToStore->getPortionSize()) . "'");
				$colNames = $colNames . ", prc_active";
				$values = $values . ", " . (is_null($objectToStore->getActive()) ? "null" : "'" . QE($objectToStore->getActive()) . "'");
				$colNames = $colNames . ", prc_order";
				$values = $values . ", " . (is_null($objectToStore->getOrder()) ? "null" : "'" . QE($objectToStore->getOrder()) . "'");
				$colNames = $colNames . ", prc_last_session";
				$values = $values . ", " . (is_null($objectToStore->getLastSession()) ? "null" : "'" . QE($objectToStore->getLastSession()) . "'");
				$colNames = $colNames . ", prc_subprocess_count";
				$values = $values . ", " . (is_null($objectToStore->getSubprocessCount()) ? "null" : "'" . QE($objectToStore->getSubprocessCount()) . "'");
				$colNames = $colNames . ", prc_clear";
				$values = $values . ", " . (is_null($objectToStore->getClear()) ? "null" : "'" . QE($objectToStore->getClear()) . "'");
				$query = "INSERT INTO prt_history_processes (revision, ip, username, user_id, timestamp, prc_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
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
				$colNames = $colNames . ", prc_name";
				$values = $values . ", " . (is_null($objectToStore->getName()) ? "null" : "'" . QE($objectToStore->getName()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getExecutionTime() != $objectToStore->getExecutionTime()) {
				if (is_null($objectToStore->getExecutionTime())) {
					$nullifiedProperties = $nullifiedProperties . "execution_time,";
				} else {
				$colNames = $colNames . ", prc_execution_time";
				$values = $values . ", " . (is_null($objectToStore->getExecutionTime()) ? "null" : "'" . QE($objectToStore->getExecutionTime()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getDescription() != $objectToStore->getDescription()) {
				if (is_null($objectToStore->getDescription())) {
					$nullifiedProperties = $nullifiedProperties . "description,";
				} else {
				$colNames = $colNames . ", prc_description";
				$values = $values . ", " . (is_null($objectToStore->getDescription()) ? "null" : "'" . QE($objectToStore->getDescription()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getInitiationCode() != $objectToStore->getInitiationCode()) {
				if (is_null($objectToStore->getInitiationCode())) {
					$nullifiedProperties = $nullifiedProperties . "initiation_code,";
				} else {
				$colNames = $colNames . ", prc_initiation_code";
				$values = $values . ", " . (is_null($objectToStore->getInitiationCode()) ? "null" : "'" . QE($objectToStore->getInitiationCode()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getExecutionCode() != $objectToStore->getExecutionCode()) {
				if (is_null($objectToStore->getExecutionCode())) {
					$nullifiedProperties = $nullifiedProperties . "execution_code,";
				} else {
				$colNames = $colNames . ", prc_execution_code";
				$values = $values . ", " . (is_null($objectToStore->getExecutionCode()) ? "null" : "'" . QE($objectToStore->getExecutionCode()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getClosingCode() != $objectToStore->getClosingCode()) {
				if (is_null($objectToStore->getClosingCode())) {
					$nullifiedProperties = $nullifiedProperties . "closing_code,";
				} else {
				$colNames = $colNames . ", prc_closing_code";
				$values = $values . ", " . (is_null($objectToStore->getClosingCode()) ? "null" : "'" . QE($objectToStore->getClosingCode()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getPortionSize() != $objectToStore->getPortionSize()) {
				if (is_null($objectToStore->getPortionSize())) {
					$nullifiedProperties = $nullifiedProperties . "portion_size,";
				} else {
				$colNames = $colNames . ", prc_portion_size";
				$values = $values . ", " . (is_null($objectToStore->getPortionSize()) ? "null" : "'" . QE($objectToStore->getPortionSize()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getActive() != $objectToStore->getActive()) {
				if (is_null($objectToStore->getActive())) {
					$nullifiedProperties = $nullifiedProperties . "active,";
				} else {
				$colNames = $colNames . ", prc_active";
				$values = $values . ", " . (is_null($objectToStore->getActive()) ? "null" : "'" . QE($objectToStore->getActive()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getOrder() != $objectToStore->getOrder()) {
				if (is_null($objectToStore->getOrder())) {
					$nullifiedProperties = $nullifiedProperties . "order,";
				} else {
				$colNames = $colNames . ", prc_order";
				$values = $values . ", " . (is_null($objectToStore->getOrder()) ? "null" : "'" . QE($objectToStore->getOrder()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getLastSession() != $objectToStore->getLastSession()) {
				if (is_null($objectToStore->getLastSession())) {
					$nullifiedProperties = $nullifiedProperties . "last_session,";
				} else {
				$colNames = $colNames . ", prc_last_session";
				$values = $values . ", " . (is_null($objectToStore->getLastSession()) ? "null" : "'" . QE($objectToStore->getLastSession()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getSubprocessCount() != $objectToStore->getSubprocessCount()) {
				if (is_null($objectToStore->getSubprocessCount())) {
					$nullifiedProperties = $nullifiedProperties . "subprocess_count,";
				} else {
				$colNames = $colNames . ", prc_subprocess_count";
				$values = $values . ", " . (is_null($objectToStore->getSubprocessCount()) ? "null" : "'" . QE($objectToStore->getSubprocessCount()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getClear() != $objectToStore->getClear()) {
				if (is_null($objectToStore->getClear())) {
					$nullifiedProperties = $nullifiedProperties . "clear,";
				} else {
				$colNames = $colNames . ", prc_clear";
				$values = $values . ", " . (is_null($objectToStore->getClear()) ? "null" : "'" . QE($objectToStore->getClear()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			$query = "INSERT INTO prt_history_processes (revision, ip, username, user_id, timestamp, prc_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_processes");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'prc_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_processes ADD COLUMN (prc_virgo_title VARCHAR(255));";
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
			if (isset($this->prc_id) && $this->prc_id != "") {
				$query = "UPDATE prt_processes SET ";
			if (isset($this->prc_name)) {
				$query .= " prc_name = ? ,";
				$types .= "s";
				$values[] = $this->prc_name;
			} else {
				$query .= " prc_name = NULL ,";				
			}
			if (isset($this->prc_execution_time)) {
				$query .= " prc_execution_time = ? ,";
				$types .= "s";
				$values[] = $this->prc_execution_time;
			} else {
				$query .= " prc_execution_time = NULL ,";				
			}
			if (isset($this->prc_description)) {
				$query .= " prc_description = ? ,";
				$types .= "s";
				$values[] = $this->prc_description;
			} else {
				$query .= " prc_description = NULL ,";				
			}
			if (isset($this->prc_initiation_code)) {
				$query .= " prc_initiation_code = ? ,";
				$types .= "s";
				$values[] = $this->prc_initiation_code;
			} else {
				$query .= " prc_initiation_code = NULL ,";				
			}
			if (isset($this->prc_execution_code)) {
				$query .= " prc_execution_code = ? ,";
				$types .= "s";
				$values[] = $this->prc_execution_code;
			} else {
				$query .= " prc_execution_code = NULL ,";				
			}
			if (isset($this->prc_closing_code)) {
				$query .= " prc_closing_code = ? ,";
				$types .= "s";
				$values[] = $this->prc_closing_code;
			} else {
				$query .= " prc_closing_code = NULL ,";				
			}
			if (isset($this->prc_portion_size)) {
				$query .= " prc_portion_size = ? ,";
				$types .= "i";
				$values[] = $this->prc_portion_size;
			} else {
				$query .= " prc_portion_size = NULL ,";				
			}
			if (isset($this->prc_active)) {
				$query .= " prc_active = ? ,";
				$types .= "s";
				$values[] = $this->prc_active;
			} else {
				$query .= " prc_active = NULL ,";				
			}
			if (isset($this->prc_order)) {
				$query .= " prc_order = ? ,";
				$types .= "i";
				$values[] = $this->prc_order;
			} else {
				$query .= " prc_order = NULL ,";				
			}
			if (isset($this->prc_last_session)) {
				$query .= " prc_last_session = ? ,";
				$types .= "s";
				$values[] = $this->prc_last_session;
			} else {
				$query .= " prc_last_session = NULL ,";				
			}
			if (isset($this->prc_subprocess_count)) {
				$query .= " prc_subprocess_count = ? ,";
				$types .= "i";
				$values[] = $this->prc_subprocess_count;
			} else {
				$query .= " prc_subprocess_count = NULL ,";				
			}
			if (isset($this->prc_clear)) {
				$query .= " prc_clear = ? ,";
				$types .= "s";
				$values[] = $this->prc_clear;
			} else {
				$query .= " prc_clear = NULL ,";				
			}
				$query = $query . " prc_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " prc_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->prc_date_modified;

				$query = $query . " prc_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->prc_usr_modified_id;

				$query = $query . " WHERE prc_id = ? ";
				$types = $types . "i";
				$values[] = $this->prc_id;
			} else {
				$query = "INSERT INTO prt_processes ( ";
			$query = $query . " prc_name, ";
			$query = $query . " prc_execution_time, ";
			$query = $query . " prc_description, ";
			$query = $query . " prc_initiation_code, ";
			$query = $query . " prc_execution_code, ";
			$query = $query . " prc_closing_code, ";
			$query = $query . " prc_portion_size, ";
			$query = $query . " prc_active, ";
			$query = $query . " prc_order, ";
			$query = $query . " prc_last_session, ";
			$query = $query . " prc_subprocess_count, ";
			$query = $query . " prc_clear, ";
				$query = $query . " prc_virgo_title, prc_date_created, prc_usr_created_id) VALUES ( ";
			if (isset($this->prc_name)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prc_name;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prc_execution_time)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prc_execution_time;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prc_description)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prc_description;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prc_initiation_code)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prc_initiation_code;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prc_execution_code)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prc_execution_code;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prc_closing_code)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prc_closing_code;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prc_portion_size)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->prc_portion_size;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prc_active)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prc_active;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prc_order)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->prc_order;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prc_last_session)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prc_last_session;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prc_subprocess_count)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->prc_subprocess_count;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prc_clear)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prc_clear;
			} else {
				$query .= " NULL ,";				
			}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->prc_date_created;
				$values[] = $this->prc_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->prc_id) || $this->prc_id == "") {
					$this->prc_id = QID();
				}
				if ($log) {
					L("process stored successfully", "id = {$this->prc_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->prc_id) {
				$virgoOld = new virgoProcess($this->prc_id);
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
					if ($this->prc_id) {			
						$this->prc_date_modified = date("Y-m-d H:i:s");
						$this->prc_usr_modified_id = $userId;
					} else {
						$this->prc_date_created = date("Y-m-d H:i:s");
						$this->prc_usr_created_id = $userId;
					}
					$this->prc_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "process" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "process" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM prt_processes WHERE prc_id = {$this->prc_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			$list = $this->getExecutions();
			if (sizeof($list) > 0) {
				$name = $this->getVirgoTitle();
				if (!is_null($name) && trim($name) != "") {
					$name = "'" . $name . "' ";
				}
				return T('CANT_DELETE_PARENT', 'PROCESS', 'EXECUTION', $name);
			}
			self::removeFromContext();
			$this->parentDelete();
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoProcess();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT prc_id as id FROM prt_processes";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'prc_order_column')) {
				$orderBy = " ORDER BY prc_order_column ASC ";
			} 
			if (property_exists($this, 'prc_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY prc_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoProcess();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoProcess($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_processes SET prc_virgo_title = '$title' WHERE prc_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getByNameStatic($token) {
			$tmpStatic = new virgoProcess();
			$tmpId = $tmpStatic->getIdByName($token);
			$tmpStatic->load($tmpId);
			return $tmpStatic;
		}
		
		static function getIdByNameStatic($token) {
			$tmpStatic = new virgoProcess();
			return $tmpStatic->getIdByName($token);
		}
		
		function getIdByName($token) {
			$res = $this->selectAll(" prc_name = ?", "", "s", array($token));
			foreach ($res as $r) {
				return $r['prc_id'];
			}
			return null;
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoProcess();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" prc_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['prc_id'];
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
			virgoProcess::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoProcess::setSessionValue('Portal_Process-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoProcess::getSessionValue('Portal_Process-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoProcess::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoProcess::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoProcess::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoProcess::getSessionValue('GLOBAL', $name, $default);
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
			$context['prc_id'] = $id;
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
			$context['prc_id'] = null;
			virgoProcess::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoProcess::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoProcess::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoProcess::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoProcess::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoProcess::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoProcess::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoProcess::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoProcess::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoProcess::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoProcess::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoProcess::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoProcess::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoProcess::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoProcess::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoProcess::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoProcess::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column', 'prc_order');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "prc_id";
			}
			return virgoProcess::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoProcess::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoProcess::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoProcess::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoProcess::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoProcess::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoProcess::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoProcess::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoProcess::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoProcess::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoProcess::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoProcess::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoProcess::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->prc_id) {
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
						L(T('STORED_CORRECTLY', 'PROCESS'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'name', $this->prc_name);
						$fieldValues = $fieldValues . T($fieldValue, 'execution time', $this->prc_execution_time);
						$fieldValues = $fieldValues . T($fieldValue, 'description', $this->prc_description);
						$fieldValues = $fieldValues . T($fieldValue, 'initiation code', $this->prc_initiation_code);
						$fieldValues = $fieldValues . T($fieldValue, 'execution code', $this->prc_execution_code);
						$fieldValues = $fieldValues . T($fieldValue, 'closing code', $this->prc_closing_code);
						$fieldValues = $fieldValues . T($fieldValue, 'portion size', $this->prc_portion_size);
						$fieldValues = $fieldValues . T($fieldValue, 'active', $this->prc_active);
						$fieldValues = $fieldValues . T($fieldValue, 'order', $this->prc_order);
						$fieldValues = $fieldValues . T($fieldValue, 'last session', $this->prc_last_session);
						$fieldValues = $fieldValues . T($fieldValue, 'subprocess count', $this->prc_subprocess_count);
						$fieldValues = $fieldValues . T($fieldValue, 'clear', $this->prc_clear);
						$username = '';
						if ($this->prc_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->prc_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->prc_date_created);
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
			$instance = new virgoProcess();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoProcess'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			if (false) { //$componentParams->get('show_form_executions') == "1") {
				$tmpExecution = new virgoExecution();
				$deleteExecution = R('DELETE');
				if (sizeof($deleteExecution) > 0) {
					$tmpExecution->multipleDelete($deleteExecution);
				}
				$resIds = $tmpExecution->select(null, 'all', null, null, ' exc_prc_id = ' . $instance->getId(), ' SELECT exc_id FROM prt_executions ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->exc_id;
//					JRequest::setVar('exc_process_' . $resId->exc_id, $this->getId());
				} 
//				JRequest::setVar('exc_process_', $instance->getId());
				$tmpExecution->setRecordSet($resIdsString);
				if (!$tmpExecution->portletActionStoreSelected()) {
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
			$tmpId = intval(R('prc_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoProcess::getContextId();
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
			$this->prc_id = null;
			$this->prc_date_created = null;
			$this->prc_usr_created_id = null;
			$this->prc_date_modified = null;
			$this->prc_usr_modified_id = null;
			$this->prc_virgo_title = null;
			
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
//			$ret = new virgoProcess();
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
				$instance = new virgoProcess();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoProcess::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'PROCESS'), '', 'INFO');
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
			$objectToSwapWith = new virgoProcess($idToSwapWith);
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
			$objectToSwapWith = new virgoProcess($idToSwapWith);
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
		
		static function portletActionVirgoSetActiveTrue() {
			$this->loadFromDB();
			$this->setActive(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetActiveFalse() {
			$this->loadFromDB();
			$this->setActive(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isActive() {
			return $this->getActive() == 1;
		}
		static function portletActionVirgoSetClearTrue() {
			$this->loadFromDB();
			$this->setClear(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetClearFalse() {
			$this->loadFromDB();
			$this->setClear(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isClear() {
			return $this->getClear() == 1;
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
				$resultProcess = new virgoProcess();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultProcess->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultProcess->load($idToEditInt);
					} else {
						$resultProcess->prc_id = 0;
					}
				}
				$results[] = $resultProcess;
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
				$result = new virgoProcess();
				$result->loadFromRequest($idToStore);
				if ($result->prc_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->prc_id == 0) {
						$result->prc_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->prc_id)) {
							$result->prc_id = 0;
						}
						$idsToCorrect[$result->prc_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'PROCESSES'), '', 'INFO');
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
			$resultProcess = new virgoProcess();
			foreach ($idsToDelete as $idToDelete) {
				$resultProcess->load((int)trim($idToDelete));
				$res = $resultProcess->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'PROCESSES'), '', 'INFO');			
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
		$ret = $this->prc_name;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoProcess');
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
				$query = "UPDATE prt_processes SET prc_virgo_title = ? WHERE prc_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT prc_id AS id FROM prt_processes ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoProcess($row['id']);
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
						$parentInfo['condition'] = 'prt_processes.prc_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_processes.prc_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_processes.prc_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_processes.prc_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoProcess!', '', 'ERROR');
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
			$pdf->SetTitle('Processes report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('PROCESSES');
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
			if (P('show_pdf_execution_time', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_description', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_initiation_code', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_execution_code', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_closing_code', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_portion_size', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_active', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_order', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_last_session', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_subprocess_count', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_clear', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultProcess = new virgoProcess();
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
			if (P('show_pdf_execution_time', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Execution time');
				$minWidth['execution time'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['execution time']) {
						$minWidth['execution time'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_description', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Description');
				$minWidth['description'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['description']) {
						$minWidth['description'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_initiation_code', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Initiation code');
				$minWidth['initiation code'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['initiation code']) {
						$minWidth['initiation code'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_execution_code', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Execution code');
				$minWidth['execution code'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['execution code']) {
						$minWidth['execution code'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_closing_code', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Closing code');
				$minWidth['closing code'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['closing code']) {
						$minWidth['closing code'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_portion_size', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Portion size');
				$minWidth['portion size'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['portion size']) {
						$minWidth['portion size'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_active', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Active');
				$minWidth['active'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['active']) {
						$minWidth['active'] = min($tmpLen, $maxWidth);
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
			if (P('show_pdf_last_session', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Last session');
				$minWidth['last session'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['last session']) {
						$minWidth['last session'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_subprocess_count', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Subprocess count');
				$minWidth['subprocess count'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['subprocess count']) {
						$minWidth['subprocess count'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_clear', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Clear');
				$minWidth['clear'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['clear']) {
						$minWidth['clear'] = min($tmpLen, $maxWidth);
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
			$whereClauseProcess = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseProcess = $whereClauseProcess . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaProcess = $resultProcess->getCriteria();
			$fieldCriteriaName = $criteriaProcess["name"];
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
			$fieldCriteriaExecutionTime = $criteriaProcess["execution_time"];
			if ($fieldCriteriaExecutionTime["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Execution time', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaExecutionTime["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Execution time', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaDescription = $criteriaProcess["description"];
			if ($fieldCriteriaDescription["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Description', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaDescription["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Description', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaInitiationCode = $criteriaProcess["initiation_code"];
			if ($fieldCriteriaInitiationCode["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Initiation code', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaInitiationCode["value"];
				$renderCriteria = "";
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Initiation code', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaExecutionCode = $criteriaProcess["execution_code"];
			if ($fieldCriteriaExecutionCode["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Execution code', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaExecutionCode["value"];
				$renderCriteria = "";
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Execution code', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaClosingCode = $criteriaProcess["closing_code"];
			if ($fieldCriteriaClosingCode["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Closing code', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaClosingCode["value"];
				$renderCriteria = "";
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Closing code', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaPortionSize = $criteriaProcess["portion_size"];
			if ($fieldCriteriaPortionSize["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Portion size', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaPortionSize["value"];
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
					$pdf->MultiCell(60, 100, 'Portion size', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaActive = $criteriaProcess["active"];
			if ($fieldCriteriaActive["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Active', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaActive["value"];
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
					$pdf->MultiCell(60, 100, 'Active', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaOrder = $criteriaProcess["order"];
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
			$fieldCriteriaLastSession = $criteriaProcess["last_session"];
			if ($fieldCriteriaLastSession["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Last session', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaLastSession["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Last session', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaSubprocessCount = $criteriaProcess["subprocess_count"];
			if ($fieldCriteriaSubprocessCount["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Subprocess count', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaSubprocessCount["value"];
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
					$pdf->MultiCell(60, 100, 'Subprocess count', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaClear = $criteriaProcess["clear"];
			if ($fieldCriteriaClear["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Clear', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaClear["value"];
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
					$pdf->MultiCell(60, 100, 'Clear', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$filter = "";
			$criteriaProcess = self::getCriteria();
			if (isset($criteriaProcess["name"])) {
				$fieldCriteriaName = $criteriaProcess["name"];
				if ($fieldCriteriaName["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_name IS NOT NULL ';
				} elseif ($fieldCriteriaName["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_processes.prc_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaProcess["execution_time"])) {
				$fieldCriteriaExecutionTime = $criteriaProcess["execution_time"];
				if ($fieldCriteriaExecutionTime["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_execution_time IS NOT NULL ';
				} elseif ($fieldCriteriaExecutionTime["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_execution_time IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaExecutionTime["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_processes.prc_execution_time like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaProcess["description"])) {
				$fieldCriteriaDescription = $criteriaProcess["description"];
				if ($fieldCriteriaDescription["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_description IS NOT NULL ';
				} elseif ($fieldCriteriaDescription["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_description IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDescription["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_processes.prc_description like ? ";
				$types .= "s";
				$values[] = $condition;				
			}
				}
			}
			if (isset($criteriaProcess["initiation_code"])) {
				$fieldCriteriaInitiationCode = $criteriaProcess["initiation_code"];
				if ($fieldCriteriaInitiationCode["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_initiation_code IS NOT NULL ';
				} elseif ($fieldCriteriaInitiationCode["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_initiation_code IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaInitiationCode["value"];
				}
			}
			if (isset($criteriaProcess["execution_code"])) {
				$fieldCriteriaExecutionCode = $criteriaProcess["execution_code"];
				if ($fieldCriteriaExecutionCode["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_execution_code IS NOT NULL ';
				} elseif ($fieldCriteriaExecutionCode["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_execution_code IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaExecutionCode["value"];
				}
			}
			if (isset($criteriaProcess["closing_code"])) {
				$fieldCriteriaClosingCode = $criteriaProcess["closing_code"];
				if ($fieldCriteriaClosingCode["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_closing_code IS NOT NULL ';
				} elseif ($fieldCriteriaClosingCode["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_closing_code IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaClosingCode["value"];
				}
			}
			if (isset($criteriaProcess["portion_size"])) {
				$fieldCriteriaPortionSize = $criteriaProcess["portion_size"];
				if ($fieldCriteriaPortionSize["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_portion_size IS NOT NULL ';
				} elseif ($fieldCriteriaPortionSize["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_portion_size IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaPortionSize["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_processes.prc_portion_size = ? ";
				} else {
					$filter = $filter . " AND prt_processes.prc_portion_size >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_processes.prc_portion_size <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaProcess["active"])) {
				$fieldCriteriaActive = $criteriaProcess["active"];
				if ($fieldCriteriaActive["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_active IS NOT NULL ';
				} elseif ($fieldCriteriaActive["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_active IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaActive["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_processes.prc_active = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaProcess["order"])) {
				$fieldCriteriaOrder = $criteriaProcess["order"];
				if ($fieldCriteriaOrder["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_order IS NOT NULL ';
				} elseif ($fieldCriteriaOrder["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_order IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaOrder["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_processes.prc_order = ? ";
				} else {
					$filter = $filter . " AND prt_processes.prc_order >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_processes.prc_order <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaProcess["last_session"])) {
				$fieldCriteriaLastSession = $criteriaProcess["last_session"];
				if ($fieldCriteriaLastSession["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_last_session IS NOT NULL ';
				} elseif ($fieldCriteriaLastSession["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_last_session IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaLastSession["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_processes.prc_last_session like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaProcess["subprocess_count"])) {
				$fieldCriteriaSubprocessCount = $criteriaProcess["subprocess_count"];
				if ($fieldCriteriaSubprocessCount["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_subprocess_count IS NOT NULL ';
				} elseif ($fieldCriteriaSubprocessCount["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_subprocess_count IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaSubprocessCount["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_processes.prc_subprocess_count = ? ";
				} else {
					$filter = $filter . " AND prt_processes.prc_subprocess_count >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_processes.prc_subprocess_count <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaProcess["clear"])) {
				$fieldCriteriaClear = $criteriaProcess["clear"];
				if ($fieldCriteriaClear["is_null"] == 1) {
$filter = $filter . ' AND prt_processes.prc_clear IS NOT NULL ';
				} elseif ($fieldCriteriaClear["is_null"] == 2) {
$filter = $filter . ' AND prt_processes.prc_clear IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaClear["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_processes.prc_clear = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			$whereClauseProcess = $whereClauseProcess . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseProcess = $whereClauseProcess . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_processes.prc_id, prt_processes.prc_virgo_title ";
			$defaultOrderColumn = P('default_sort_column', 'prc_order');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_name', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_name prc_name";
			} else {
				if ($defaultOrderColumn == "prc_name") {
					$orderColumnNotDisplayed = " prt_processes.prc_name ";
				}
			}
			if (P('show_pdf_execution_time', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_execution_time prc_execution_time";
			} else {
				if ($defaultOrderColumn == "prc_execution_time") {
					$orderColumnNotDisplayed = " prt_processes.prc_execution_time ";
				}
			}
			if (P('show_pdf_description', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_description prc_description";
			} else {
				if ($defaultOrderColumn == "prc_description") {
					$orderColumnNotDisplayed = " prt_processes.prc_description ";
				}
			}
			if (P('show_pdf_initiation_code', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_initiation_code prc_initiation_code";
			} else {
				if ($defaultOrderColumn == "prc_initiation_code") {
					$orderColumnNotDisplayed = " prt_processes.prc_initiation_code ";
				}
			}
			if (P('show_pdf_execution_code', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_execution_code prc_execution_code";
			} else {
				if ($defaultOrderColumn == "prc_execution_code") {
					$orderColumnNotDisplayed = " prt_processes.prc_execution_code ";
				}
			}
			if (P('show_pdf_closing_code', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_closing_code prc_closing_code";
			} else {
				if ($defaultOrderColumn == "prc_closing_code") {
					$orderColumnNotDisplayed = " prt_processes.prc_closing_code ";
				}
			}
			if (P('show_pdf_portion_size', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_portion_size prc_portion_size";
			} else {
				if ($defaultOrderColumn == "prc_portion_size") {
					$orderColumnNotDisplayed = " prt_processes.prc_portion_size ";
				}
			}
			if (P('show_pdf_active', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_active prc_active";
			} else {
				if ($defaultOrderColumn == "prc_active") {
					$orderColumnNotDisplayed = " prt_processes.prc_active ";
				}
			}
			if (P('show_pdf_order', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_order prc_order";
			} else {
				if ($defaultOrderColumn == "prc_order") {
					$orderColumnNotDisplayed = " prt_processes.prc_order ";
				}
			}
			if (P('show_pdf_last_session', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_last_session prc_last_session";
			} else {
				if ($defaultOrderColumn == "prc_last_session") {
					$orderColumnNotDisplayed = " prt_processes.prc_last_session ";
				}
			}
			if (P('show_pdf_subprocess_count', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_subprocess_count prc_subprocess_count";
			} else {
				if ($defaultOrderColumn == "prc_subprocess_count") {
					$orderColumnNotDisplayed = " prt_processes.prc_subprocess_count ";
				}
			}
			if (P('show_pdf_clear', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_clear prc_clear";
			} else {
				if ($defaultOrderColumn == "prc_clear") {
					$orderColumnNotDisplayed = " prt_processes.prc_clear ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_processes ";

		$resultsProcess = $resultProcess->select(
			'', 
			'all', 
			$resultProcess->getOrderColumn(), 
			$resultProcess->getOrderMode(), 
			$whereClauseProcess,
			$queryString);
		
		foreach ($resultsProcess as $resultProcess) {

			if (P('show_pdf_name', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultProcess['prc_name'])) + 6;
				if ($tmpLen > $minWidth['name']) {
					$minWidth['name'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_execution_time', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultProcess['prc_execution_time'])) + 6;
				if ($tmpLen > $minWidth['execution time']) {
					$minWidth['execution time'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_description', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultProcess['prc_description'])) + 6;
				if ($tmpLen > $minWidth['description']) {
					$minWidth['description'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_initiation_code', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultProcess['prc_initiation_code'])) + 6;
				if ($tmpLen > $minWidth['initiation code']) {
					$minWidth['initiation code'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_execution_code', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultProcess['prc_execution_code'])) + 6;
				if ($tmpLen > $minWidth['execution code']) {
					$minWidth['execution code'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_closing_code', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultProcess['prc_closing_code'])) + 6;
				if ($tmpLen > $minWidth['closing code']) {
					$minWidth['closing code'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_portion_size', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultProcess['prc_portion_size'])) + 6;
				if ($tmpLen > $minWidth['portion size']) {
					$minWidth['portion size'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_active', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultProcess['prc_active'])) + 6;
				if ($tmpLen > $minWidth['active']) {
					$minWidth['active'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_order', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultProcess['prc_order'])) + 6;
				if ($tmpLen > $minWidth['order']) {
					$minWidth['order'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_last_session', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultProcess['prc_last_session'])) + 6;
				if ($tmpLen > $minWidth['last session']) {
					$minWidth['last session'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_subprocess_count', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultProcess['prc_subprocess_count'])) + 6;
				if ($tmpLen > $minWidth['subprocess count']) {
					$minWidth['subprocess count'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_clear', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultProcess['prc_clear'])) + 6;
				if ($tmpLen > $minWidth['clear']) {
					$minWidth['clear'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaProcess = $resultProcess->getCriteria();
		if (is_null($criteriaProcess) || sizeof($criteriaProcess) == 0 || $countTmp == 0) {
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
			if (P('show_pdf_execution_time', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['execution time'], $colHeight, T('EXECUTION_TIME'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_description', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['description'], $colHeight, T('DESCRIPTION'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_initiation_code', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['initiation code'], $colHeight, T('INITIATION_CODE'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_execution_code', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['execution code'], $colHeight, T('EXECUTION_CODE'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_closing_code', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['closing code'], $colHeight, T('CLOSING_CODE'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_portion_size', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['portion size'], $colHeight, T('PORTION_SIZE'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_active', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['active'], $colHeight, T('ACTIVE'), 'T', 'C', 0, 0);
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
			if (P('show_pdf_last_session', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['last session'], $colHeight, T('LAST_SESSION'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_subprocess_count', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['subprocess count'], $colHeight, T('SUBPROCESS_COUNT'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_clear', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['clear'], $colHeight, T('CLEAR'), 'T', 'C', 0, 0);
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
		foreach ($resultsProcess as $resultProcess) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_name', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['name'], $colHeight, '' . $resultProcess['prc_name'], 'T', 'L', 0, 0);
				if (P('show_pdf_name', "1") == "2") {
										if (!is_null($resultProcess['prc_name'])) {
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
										if (!is_null($resultProcess['prc_name'])) {
						$tmpSum = (float)$sums["name"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_name'];
						}
						$sums["name"] = $tmpSum;
					}
				}
				if (P('show_pdf_name', "1") == "4") {
										if (!is_null($resultProcess['prc_name'])) {
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
							$tmpSum = $tmpSum + $resultProcess['prc_name'];
						}
						$avgSums["name"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_execution_time', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['execution time'], $colHeight, '' . $resultProcess['prc_execution_time'], 'T', 'L', 0, 0);
				if (P('show_pdf_execution_time', "1") == "2") {
										if (!is_null($resultProcess['prc_execution_time'])) {
						$tmpCount = (float)$counts["execution_time"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["execution_time"] = $tmpCount;
					}
				}
				if (P('show_pdf_execution_time', "1") == "3") {
										if (!is_null($resultProcess['prc_execution_time'])) {
						$tmpSum = (float)$sums["execution_time"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_execution_time'];
						}
						$sums["execution_time"] = $tmpSum;
					}
				}
				if (P('show_pdf_execution_time', "1") == "4") {
										if (!is_null($resultProcess['prc_execution_time'])) {
						$tmpCount = (float)$avgCounts["execution_time"];
						$tmpSum = (float)$avgSums["execution_time"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["execution_time"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_execution_time'];
						}
						$avgSums["execution_time"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_description', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['description'], $colHeight, '' . $resultProcess['prc_description'], 'T', 'L', 0, 0);
				if (P('show_pdf_description', "1") == "2") {
										if (!is_null($resultProcess['prc_description'])) {
						$tmpCount = (float)$counts["description"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["description"] = $tmpCount;
					}
				}
				if (P('show_pdf_description', "1") == "3") {
										if (!is_null($resultProcess['prc_description'])) {
						$tmpSum = (float)$sums["description"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_description'];
						}
						$sums["description"] = $tmpSum;
					}
				}
				if (P('show_pdf_description', "1") == "4") {
										if (!is_null($resultProcess['prc_description'])) {
						$tmpCount = (float)$avgCounts["description"];
						$tmpSum = (float)$avgSums["description"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["description"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_description'];
						}
						$avgSums["description"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_initiation_code', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['initiation code'], $colHeight, '' . $resultProcess['prc_initiation_code'], 'T', 'L', 0, 0);
				if (P('show_pdf_initiation_code', "1") == "2") {
										if (!is_null($resultProcess['prc_initiation_code'])) {
						$tmpCount = (float)$counts["initiation_code"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["initiation_code"] = $tmpCount;
					}
				}
				if (P('show_pdf_initiation_code', "1") == "3") {
										if (!is_null($resultProcess['prc_initiation_code'])) {
						$tmpSum = (float)$sums["initiation_code"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_initiation_code'];
						}
						$sums["initiation_code"] = $tmpSum;
					}
				}
				if (P('show_pdf_initiation_code', "1") == "4") {
										if (!is_null($resultProcess['prc_initiation_code'])) {
						$tmpCount = (float)$avgCounts["initiation_code"];
						$tmpSum = (float)$avgSums["initiation_code"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["initiation_code"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_initiation_code'];
						}
						$avgSums["initiation_code"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_execution_code', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['execution code'], $colHeight, '' . $resultProcess['prc_execution_code'], 'T', 'L', 0, 0);
				if (P('show_pdf_execution_code', "1") == "2") {
										if (!is_null($resultProcess['prc_execution_code'])) {
						$tmpCount = (float)$counts["execution_code"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["execution_code"] = $tmpCount;
					}
				}
				if (P('show_pdf_execution_code', "1") == "3") {
										if (!is_null($resultProcess['prc_execution_code'])) {
						$tmpSum = (float)$sums["execution_code"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_execution_code'];
						}
						$sums["execution_code"] = $tmpSum;
					}
				}
				if (P('show_pdf_execution_code', "1") == "4") {
										if (!is_null($resultProcess['prc_execution_code'])) {
						$tmpCount = (float)$avgCounts["execution_code"];
						$tmpSum = (float)$avgSums["execution_code"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["execution_code"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_execution_code'];
						}
						$avgSums["execution_code"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_closing_code', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['closing code'], $colHeight, '' . $resultProcess['prc_closing_code'], 'T', 'L', 0, 0);
				if (P('show_pdf_closing_code', "1") == "2") {
										if (!is_null($resultProcess['prc_closing_code'])) {
						$tmpCount = (float)$counts["closing_code"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["closing_code"] = $tmpCount;
					}
				}
				if (P('show_pdf_closing_code', "1") == "3") {
										if (!is_null($resultProcess['prc_closing_code'])) {
						$tmpSum = (float)$sums["closing_code"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_closing_code'];
						}
						$sums["closing_code"] = $tmpSum;
					}
				}
				if (P('show_pdf_closing_code', "1") == "4") {
										if (!is_null($resultProcess['prc_closing_code'])) {
						$tmpCount = (float)$avgCounts["closing_code"];
						$tmpSum = (float)$avgSums["closing_code"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["closing_code"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_closing_code'];
						}
						$avgSums["closing_code"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_portion_size', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['portion size'], $colHeight, '' . $resultProcess['prc_portion_size'], 'T', 'R', 0, 0);
				if (P('show_pdf_portion_size', "1") == "2") {
										if (!is_null($resultProcess['prc_portion_size'])) {
						$tmpCount = (float)$counts["portion_size"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["portion_size"] = $tmpCount;
					}
				}
				if (P('show_pdf_portion_size', "1") == "3") {
										if (!is_null($resultProcess['prc_portion_size'])) {
						$tmpSum = (float)$sums["portion_size"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_portion_size'];
						}
						$sums["portion_size"] = $tmpSum;
					}
				}
				if (P('show_pdf_portion_size', "1") == "4") {
										if (!is_null($resultProcess['prc_portion_size'])) {
						$tmpCount = (float)$avgCounts["portion_size"];
						$tmpSum = (float)$avgSums["portion_size"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["portion_size"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_portion_size'];
						}
						$avgSums["portion_size"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_active', "0") != "0") {
			$renderCriteria = "";
			switch ($resultProcess['prc_active']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['active'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_active', "1") == "2") {
										if (!is_null($resultProcess['prc_active'])) {
						$tmpCount = (float)$counts["active"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["active"] = $tmpCount;
					}
				}
				if (P('show_pdf_active', "1") == "3") {
										if (!is_null($resultProcess['prc_active'])) {
						$tmpSum = (float)$sums["active"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_active'];
						}
						$sums["active"] = $tmpSum;
					}
				}
				if (P('show_pdf_active', "1") == "4") {
										if (!is_null($resultProcess['prc_active'])) {
						$tmpCount = (float)$avgCounts["active"];
						$tmpSum = (float)$avgSums["active"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["active"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_active'];
						}
						$avgSums["active"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_order', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['order'], $colHeight, '' . $resultProcess['prc_order'], 'T', 'R', 0, 0);
				if (P('show_pdf_order', "1") == "2") {
										if (!is_null($resultProcess['prc_order'])) {
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
										if (!is_null($resultProcess['prc_order'])) {
						$tmpSum = (float)$sums["order"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_order'];
						}
						$sums["order"] = $tmpSum;
					}
				}
				if (P('show_pdf_order', "1") == "4") {
										if (!is_null($resultProcess['prc_order'])) {
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
							$tmpSum = $tmpSum + $resultProcess['prc_order'];
						}
						$avgSums["order"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_last_session', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['last session'], $colHeight, '' . $resultProcess['prc_last_session'], 'T', 'L', 0, 0);
				if (P('show_pdf_last_session', "1") == "2") {
										if (!is_null($resultProcess['prc_last_session'])) {
						$tmpCount = (float)$counts["last_session"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["last_session"] = $tmpCount;
					}
				}
				if (P('show_pdf_last_session', "1") == "3") {
										if (!is_null($resultProcess['prc_last_session'])) {
						$tmpSum = (float)$sums["last_session"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_last_session'];
						}
						$sums["last_session"] = $tmpSum;
					}
				}
				if (P('show_pdf_last_session', "1") == "4") {
										if (!is_null($resultProcess['prc_last_session'])) {
						$tmpCount = (float)$avgCounts["last_session"];
						$tmpSum = (float)$avgSums["last_session"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["last_session"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_last_session'];
						}
						$avgSums["last_session"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_subprocess_count', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['subprocess count'], $colHeight, '' . $resultProcess['prc_subprocess_count'], 'T', 'R', 0, 0);
				if (P('show_pdf_subprocess_count', "1") == "2") {
										if (!is_null($resultProcess['prc_subprocess_count'])) {
						$tmpCount = (float)$counts["subprocess_count"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["subprocess_count"] = $tmpCount;
					}
				}
				if (P('show_pdf_subprocess_count', "1") == "3") {
										if (!is_null($resultProcess['prc_subprocess_count'])) {
						$tmpSum = (float)$sums["subprocess_count"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_subprocess_count'];
						}
						$sums["subprocess_count"] = $tmpSum;
					}
				}
				if (P('show_pdf_subprocess_count', "1") == "4") {
										if (!is_null($resultProcess['prc_subprocess_count'])) {
						$tmpCount = (float)$avgCounts["subprocess_count"];
						$tmpSum = (float)$avgSums["subprocess_count"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["subprocess_count"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_subprocess_count'];
						}
						$avgSums["subprocess_count"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_clear', "0") != "0") {
			$renderCriteria = "";
			switch ($resultProcess['prc_clear']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['clear'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_clear', "1") == "2") {
										if (!is_null($resultProcess['prc_clear'])) {
						$tmpCount = (float)$counts["clear"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["clear"] = $tmpCount;
					}
				}
				if (P('show_pdf_clear', "1") == "3") {
										if (!is_null($resultProcess['prc_clear'])) {
						$tmpSum = (float)$sums["clear"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_clear'];
						}
						$sums["clear"] = $tmpSum;
					}
				}
				if (P('show_pdf_clear', "1") == "4") {
										if (!is_null($resultProcess['prc_clear'])) {
						$tmpCount = (float)$avgCounts["clear"];
						$tmpSum = (float)$avgSums["clear"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["clear"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProcess['prc_clear'];
						}
						$avgSums["clear"] = $tmpSum;
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
			if (P('show_pdf_execution_time', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['execution time'];
				if (P('show_pdf_execution_time', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["execution_time"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_description', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['description'];
				if (P('show_pdf_description', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["description"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_initiation_code', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['initiation code'];
				if (P('show_pdf_initiation_code', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["initiation_code"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_execution_code', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['execution code'];
				if (P('show_pdf_execution_code', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["execution_code"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_closing_code', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['closing code'];
				if (P('show_pdf_closing_code', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["closing_code"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_portion_size', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['portion size'];
				if (P('show_pdf_portion_size', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["portion_size"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_active', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['active'];
				if (P('show_pdf_active', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["active"];
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
			if (P('show_pdf_last_session', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['last session'];
				if (P('show_pdf_last_session', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["last_session"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_subprocess_count', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['subprocess count'];
				if (P('show_pdf_subprocess_count', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["subprocess_count"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_clear', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['clear'];
				if (P('show_pdf_clear', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["clear"];
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
			if (P('show_pdf_execution_time', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['execution time'];
				if (P('show_pdf_execution_time', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["execution_time"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_description', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['description'];
				if (P('show_pdf_description', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["description"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_initiation_code', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['initiation code'];
				if (P('show_pdf_initiation_code', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["initiation_code"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_execution_code', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['execution code'];
				if (P('show_pdf_execution_code', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["execution_code"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_closing_code', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['closing code'];
				if (P('show_pdf_closing_code', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["closing_code"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_portion_size', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['portion size'];
				if (P('show_pdf_portion_size', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["portion_size"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_active', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['active'];
				if (P('show_pdf_active', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["active"], 2, ',', ' ');
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
			if (P('show_pdf_last_session', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['last session'];
				if (P('show_pdf_last_session', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["last_session"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_subprocess_count', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['subprocess count'];
				if (P('show_pdf_subprocess_count', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["subprocess_count"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_clear', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['clear'];
				if (P('show_pdf_clear', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["clear"], 2, ',', ' ');
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
			if (P('show_pdf_execution_time', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['execution time'];
				if (P('show_pdf_execution_time', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["execution_time"] == 0 ? "-" : $avgSums["execution_time"] / $avgCounts["execution_time"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_description', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['description'];
				if (P('show_pdf_description', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["description"] == 0 ? "-" : $avgSums["description"] / $avgCounts["description"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_initiation_code', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['initiation code'];
				if (P('show_pdf_initiation_code', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["initiation_code"] == 0 ? "-" : $avgSums["initiation_code"] / $avgCounts["initiation_code"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_execution_code', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['execution code'];
				if (P('show_pdf_execution_code', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["execution_code"] == 0 ? "-" : $avgSums["execution_code"] / $avgCounts["execution_code"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_closing_code', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['closing code'];
				if (P('show_pdf_closing_code', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["closing_code"] == 0 ? "-" : $avgSums["closing_code"] / $avgCounts["closing_code"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_portion_size', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['portion size'];
				if (P('show_pdf_portion_size', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["portion_size"] == 0 ? "-" : $avgSums["portion_size"] / $avgCounts["portion_size"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_active', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['active'];
				if (P('show_pdf_active', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["active"] == 0 ? "-" : $avgSums["active"] / $avgCounts["active"]);
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
			if (P('show_pdf_last_session', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['last session'];
				if (P('show_pdf_last_session', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["last_session"] == 0 ? "-" : $avgSums["last_session"] / $avgCounts["last_session"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_subprocess_count', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['subprocess count'];
				if (P('show_pdf_subprocess_count', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["subprocess_count"] == 0 ? "-" : $avgSums["subprocess_count"] / $avgCounts["subprocess_count"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_clear', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['clear'];
				if (P('show_pdf_clear', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["clear"] == 0 ? "-" : $avgSums["clear"] / $avgCounts["clear"]);
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
				$reportTitle = T('PROCESSES');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultProcess = new virgoProcess();
			$whereClauseProcess = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseProcess = $whereClauseProcess . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_name', "1") != "0") {
					$data = $data . $stringDelimeter .'Name' . $stringDelimeter . $separator;
				}
				if (P('show_export_execution_time', "1") != "0") {
					$data = $data . $stringDelimeter .'Execution time' . $stringDelimeter . $separator;
				}
				if (P('show_export_description', "1") != "0") {
					$data = $data . $stringDelimeter .'Description' . $stringDelimeter . $separator;
				}
				if (P('show_export_initiation_code', "1") != "0") {
					$data = $data . $stringDelimeter .'Initiation code' . $stringDelimeter . $separator;
				}
				if (P('show_export_execution_code', "1") != "0") {
					$data = $data . $stringDelimeter .'Execution code' . $stringDelimeter . $separator;
				}
				if (P('show_export_closing_code', "1") != "0") {
					$data = $data . $stringDelimeter .'Closing code' . $stringDelimeter . $separator;
				}
				if (P('show_export_portion_size', "1") != "0") {
					$data = $data . $stringDelimeter .'Portion size' . $stringDelimeter . $separator;
				}
				if (P('show_export_active', "1") != "0") {
					$data = $data . $stringDelimeter .'Active' . $stringDelimeter . $separator;
				}
				if (P('show_export_order', "1") != "0") {
					$data = $data . $stringDelimeter .'Order' . $stringDelimeter . $separator;
				}
				if (P('show_export_last_session', "1") != "0") {
					$data = $data . $stringDelimeter .'Last session' . $stringDelimeter . $separator;
				}
				if (P('show_export_subprocess_count', "1") != "0") {
					$data = $data . $stringDelimeter .'Subprocess count' . $stringDelimeter . $separator;
				}
				if (P('show_export_clear', "1") != "0") {
					$data = $data . $stringDelimeter .'Clear' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_processes.prc_id, prt_processes.prc_virgo_title ";
			$defaultOrderColumn = P('default_sort_column', 'prc_order');
			$orderColumnNotDisplayed = "";
			if (P('show_export_name', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_name prc_name";
			} else {
				if ($defaultOrderColumn == "prc_name") {
					$orderColumnNotDisplayed = " prt_processes.prc_name ";
				}
			}
			if (P('show_export_execution_time', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_execution_time prc_execution_time";
			} else {
				if ($defaultOrderColumn == "prc_execution_time") {
					$orderColumnNotDisplayed = " prt_processes.prc_execution_time ";
				}
			}
			if (P('show_export_description', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_description prc_description";
			} else {
				if ($defaultOrderColumn == "prc_description") {
					$orderColumnNotDisplayed = " prt_processes.prc_description ";
				}
			}
			if (P('show_export_initiation_code', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_initiation_code prc_initiation_code";
			} else {
				if ($defaultOrderColumn == "prc_initiation_code") {
					$orderColumnNotDisplayed = " prt_processes.prc_initiation_code ";
				}
			}
			if (P('show_export_execution_code', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_execution_code prc_execution_code";
			} else {
				if ($defaultOrderColumn == "prc_execution_code") {
					$orderColumnNotDisplayed = " prt_processes.prc_execution_code ";
				}
			}
			if (P('show_export_closing_code', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_closing_code prc_closing_code";
			} else {
				if ($defaultOrderColumn == "prc_closing_code") {
					$orderColumnNotDisplayed = " prt_processes.prc_closing_code ";
				}
			}
			if (P('show_export_portion_size', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_portion_size prc_portion_size";
			} else {
				if ($defaultOrderColumn == "prc_portion_size") {
					$orderColumnNotDisplayed = " prt_processes.prc_portion_size ";
				}
			}
			if (P('show_export_active', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_active prc_active";
			} else {
				if ($defaultOrderColumn == "prc_active") {
					$orderColumnNotDisplayed = " prt_processes.prc_active ";
				}
			}
			if (P('show_export_order', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_order prc_order";
			} else {
				if ($defaultOrderColumn == "prc_order") {
					$orderColumnNotDisplayed = " prt_processes.prc_order ";
				}
			}
			if (P('show_export_last_session', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_last_session prc_last_session";
			} else {
				if ($defaultOrderColumn == "prc_last_session") {
					$orderColumnNotDisplayed = " prt_processes.prc_last_session ";
				}
			}
			if (P('show_export_subprocess_count', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_subprocess_count prc_subprocess_count";
			} else {
				if ($defaultOrderColumn == "prc_subprocess_count") {
					$orderColumnNotDisplayed = " prt_processes.prc_subprocess_count ";
				}
			}
			if (P('show_export_clear', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_clear prc_clear";
			} else {
				if ($defaultOrderColumn == "prc_clear") {
					$orderColumnNotDisplayed = " prt_processes.prc_clear ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_processes ";

			$resultsProcess = $resultProcess->select(
				'', 
				'all', 
				$resultProcess->getOrderColumn(), 
				$resultProcess->getOrderMode(), 
				$whereClauseProcess,
				$queryString);
			foreach ($resultsProcess as $resultProcess) {
				if (P('show_export_name', "1") != "0") {
			$data = $data . $stringDelimeter . $resultProcess['prc_name'] . $stringDelimeter . $separator;
				}
				if (P('show_export_execution_time', "1") != "0") {
			$data = $data . $stringDelimeter . $resultProcess['prc_execution_time'] . $stringDelimeter . $separator;
				}
				if (P('show_export_description', "1") != "0") {
			$data = $data . $stringDelimeter . $resultProcess['prc_description'] . $stringDelimeter . $separator;
				}
				if (P('show_export_initiation_code', "1") != "0") {
			$data = $data . $resultProcess['prc_initiation_code'] . $separator;
				}
				if (P('show_export_execution_code', "1") != "0") {
			$data = $data . $resultProcess['prc_execution_code'] . $separator;
				}
				if (P('show_export_closing_code', "1") != "0") {
			$data = $data . $resultProcess['prc_closing_code'] . $separator;
				}
				if (P('show_export_portion_size', "1") != "0") {
			$data = $data . $resultProcess['prc_portion_size'] . $separator;
				}
				if (P('show_export_active', "1") != "0") {
			$data = $data . $resultProcess['prc_active'] . $separator;
				}
				if (P('show_export_order', "1") != "0") {
			$data = $data . $resultProcess['prc_order'] . $separator;
				}
				if (P('show_export_last_session', "1") != "0") {
			$data = $data . $stringDelimeter . $resultProcess['prc_last_session'] . $stringDelimeter . $separator;
				}
				if (P('show_export_subprocess_count', "1") != "0") {
			$data = $data . $resultProcess['prc_subprocess_count'] . $separator;
				}
				if (P('show_export_clear', "1") != "0") {
			$data = $data . $resultProcess['prc_clear'] . $separator;
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
				$reportTitle = T('PROCESSES');
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
			$resultProcess = new virgoProcess();
			$whereClauseProcess = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseProcess = $whereClauseProcess . ' AND ' . $parentContextInfo['condition'];
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
				if (P('show_export_execution_time', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Execution time');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_description', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Description');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_initiation_code', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Initiation code');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_execution_code', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Execution code');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_closing_code', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Closing code');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_portion_size', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Portion size');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_active', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Active');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_order', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Order');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_last_session', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Last session');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_subprocess_count', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Subprocess count');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_clear', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Clear');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_processes.prc_id, prt_processes.prc_virgo_title ";
			$defaultOrderColumn = P('default_sort_column', 'prc_order');
			$orderColumnNotDisplayed = "";
			if (P('show_export_name', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_name prc_name";
			} else {
				if ($defaultOrderColumn == "prc_name") {
					$orderColumnNotDisplayed = " prt_processes.prc_name ";
				}
			}
			if (P('show_export_execution_time', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_execution_time prc_execution_time";
			} else {
				if ($defaultOrderColumn == "prc_execution_time") {
					$orderColumnNotDisplayed = " prt_processes.prc_execution_time ";
				}
			}
			if (P('show_export_description', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_description prc_description";
			} else {
				if ($defaultOrderColumn == "prc_description") {
					$orderColumnNotDisplayed = " prt_processes.prc_description ";
				}
			}
			if (P('show_export_initiation_code', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_initiation_code prc_initiation_code";
			} else {
				if ($defaultOrderColumn == "prc_initiation_code") {
					$orderColumnNotDisplayed = " prt_processes.prc_initiation_code ";
				}
			}
			if (P('show_export_execution_code', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_execution_code prc_execution_code";
			} else {
				if ($defaultOrderColumn == "prc_execution_code") {
					$orderColumnNotDisplayed = " prt_processes.prc_execution_code ";
				}
			}
			if (P('show_export_closing_code', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_closing_code prc_closing_code";
			} else {
				if ($defaultOrderColumn == "prc_closing_code") {
					$orderColumnNotDisplayed = " prt_processes.prc_closing_code ";
				}
			}
			if (P('show_export_portion_size', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_portion_size prc_portion_size";
			} else {
				if ($defaultOrderColumn == "prc_portion_size") {
					$orderColumnNotDisplayed = " prt_processes.prc_portion_size ";
				}
			}
			if (P('show_export_active', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_active prc_active";
			} else {
				if ($defaultOrderColumn == "prc_active") {
					$orderColumnNotDisplayed = " prt_processes.prc_active ";
				}
			}
			if (P('show_export_order', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_order prc_order";
			} else {
				if ($defaultOrderColumn == "prc_order") {
					$orderColumnNotDisplayed = " prt_processes.prc_order ";
				}
			}
			if (P('show_export_last_session', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_last_session prc_last_session";
			} else {
				if ($defaultOrderColumn == "prc_last_session") {
					$orderColumnNotDisplayed = " prt_processes.prc_last_session ";
				}
			}
			if (P('show_export_subprocess_count', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_subprocess_count prc_subprocess_count";
			} else {
				if ($defaultOrderColumn == "prc_subprocess_count") {
					$orderColumnNotDisplayed = " prt_processes.prc_subprocess_count ";
				}
			}
			if (P('show_export_clear', "1") != "0") {
				$queryString = $queryString . ", prt_processes.prc_clear prc_clear";
			} else {
				if ($defaultOrderColumn == "prc_clear") {
					$orderColumnNotDisplayed = " prt_processes.prc_clear ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_processes ";

			$resultsProcess = $resultProcess->select(
				'', 
				'all', 
				$resultProcess->getOrderColumn(), 
				$resultProcess->getOrderMode(), 
				$whereClauseProcess,
				$queryString);
			$index = 1;
			foreach ($resultsProcess as $resultProcess) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultProcess['prc_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_name', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultProcess['prc_name'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_execution_time', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultProcess['prc_execution_time'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_description', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultProcess['prc_description'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_initiation_code', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultProcess['prc_initiation_code'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_execution_code', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultProcess['prc_execution_code'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_closing_code', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultProcess['prc_closing_code'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_portion_size', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultProcess['prc_portion_size'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_active', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultProcess['prc_active'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_order', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultProcess['prc_order'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_last_session', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultProcess['prc_last_session'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_subprocess_count', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultProcess['prc_subprocess_count'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_clear', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultProcess['prc_clear'], \PHPExcel_Cell_DataType::TYPE_STRING);
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
					$propertyColumnHash['name'] = 'prc_name';
					$propertyColumnHash['name'] = 'prc_name';
					$propertyColumnHash['execution time'] = 'prc_execution_time';
					$propertyColumnHash['execution_time'] = 'prc_execution_time';
					$propertyColumnHash['description'] = 'prc_description';
					$propertyColumnHash['description'] = 'prc_description';
					$propertyColumnHash['initiation code'] = 'prc_initiation_code';
					$propertyColumnHash['initiation_code'] = 'prc_initiation_code';
					$propertyColumnHash['execution code'] = 'prc_execution_code';
					$propertyColumnHash['execution_code'] = 'prc_execution_code';
					$propertyColumnHash['closing code'] = 'prc_closing_code';
					$propertyColumnHash['closing_code'] = 'prc_closing_code';
					$propertyColumnHash['portion size'] = 'prc_portion_size';
					$propertyColumnHash['portion_size'] = 'prc_portion_size';
					$propertyColumnHash['active'] = 'prc_active';
					$propertyColumnHash['active'] = 'prc_active';
					$propertyColumnHash['order'] = 'prc_order';
					$propertyColumnHash['order'] = 'prc_order';
					$propertyColumnHash['last session'] = 'prc_last_session';
					$propertyColumnHash['last_session'] = 'prc_last_session';
					$propertyColumnHash['subprocess count'] = 'prc_subprocess_count';
					$propertyColumnHash['subprocess_count'] = 'prc_subprocess_count';
					$propertyColumnHash['clear'] = 'prc_clear';
					$propertyColumnHash['clear'] = 'prc_clear';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importProcess = new virgoProcess();
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
										L(T('PROPERTY_NOT_FOUND', T('PROCESS'), $columns[$index]), '', 'ERROR');
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
										$importProcess->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
							$errorMessage = $importProcess->store();
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
		






		static function portletActionBackFromParent() {
			$calligView = strtoupper(R('calling_view'));
			self::setDisplayMode($calligView);
			$pob = self::getMyPortletObject();
			$pob->setPortletSessionValue('reload_from_request', '1');				
		}
		static function tick() {
			$timestamp = date("Y-m-d w H:i");
			$processes = virgoProcess::selectAllAsObjectsStatic(' prc_active = 1 ORDER BY prc_order ');
			foreach ($processes as $process) {
				if (preg_match("/^" . $process->getExecutionTime() . "$/", $timestamp) == 1) {
					$process->execute();
				}
			}
		}
		
		function init() {
			$session = session_id();
			$this->setLastSession($session);
			$this->store();
			$virgoExecution = new virgoExecution();
			$virgoExecution->setPrcId($this->getId());
			$virgoExecution->setBegin(date("Y-m-d H:i:s"));
			$virgoExecution->setProgress(0);
			$excId = $this->initiationTest();
			if ($excId > 0) {
				return new virgoExecution($excId);
			}
			$virgoExecution->store();
			$excId = $virgoExecution->getId();
			if (false) {
				$prefix = " ?> ";
				$sufix = " <?php ";
			} else {
				$prefix = "";
				$sufix = "";
			}
			ob_start();
			$ret = eval($prefix . " " . $this->getInitiationCode() . " " . $sufix);
			if ('' !== $error = ob_get_clean()) {
				L($error, '', 'ERROR');
    			}			
			return $virgoExecution;
		}

		function initiationTest() {
			$query = "SELECT IFNULL(MIN(exc_id), 0) FROM prt_executions WHERE exc_prc_id = " . $this->getId() . " AND exc_begin IS NOT NULL AND exc_end IS NULL";
			$res = Q1($query);
			$excId = (int)$res;
			if ($excId > 0) {
				return $excId;
			}
			return 0;
		}

		function initiated() {
			$excId = $this->initiationTest();
			if ($excId > 0) {
				return new virgoExecution($excId);
			} else {
//				$token = $this->getLastSession();
//				$session = session_id();
//				if (is_null($token) || trim($token) == "" || $token != $session) {
					return $this->init();
//				} else {
//					return null;
//				}
			}
		}
		
		function execute() {
			$execution = $this->initiated();
			if (!is_null($execution)) {
				$execution->push();
			}
			return $execution;

//			L('Process initialization start: ' . $this->getName(), '', 'INFO');
//			$ret = eval($this->getInitiationCode());
//			L('Process initialization end: ' . $this->getName(), '', 'INFO');
		}
		
		function portletActionExecuteNow() {
			$this->portletActionSelect();
			$this->execute();
		}				

		function portletActionStoreAndExecuteNow() {
			$this->portletActionApply();
			$this->portletActionExecuteNow();
		}
		
		static function pushExecutedProcesses($virgoExecution) {
			$executingProcesses = virgoExecution::selectAllAsObjectsStatic(' exc_begin IS NOT NULL AND exc_end IS NULL AND exc_prc_id != ' . $virgoExecution->getPrcId());
			foreach ($executingProcesses as $executingProcess) {
				$executingProcess->push();
			}
		}
				


		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `prt_processes` (
  `prc_id` bigint(20) unsigned NOT NULL auto_increment,
  `prc_virgo_state` varchar(50) default NULL,
  `prc_virgo_title` varchar(255) default NULL,
  `prc_name` varchar(255), 
  `prc_execution_time` varchar(255), 
  `prc_description` longtext, 
  `prc_initiation_code` longtext, 
  `prc_execution_code` longtext, 
  `prc_closing_code` longtext, 
  `prc_portion_size` integer,  
  `prc_active` boolean,  
  `prc_order` integer,  
  `prc_last_session` varchar(255), 
  `prc_subprocess_count` integer,  
  `prc_clear` boolean,  
  `prc_date_created` datetime NOT NULL,
  `prc_date_modified` datetime default NULL,
  `prc_usr_created_id` int(11) NOT NULL,
  `prc_usr_modified_id` int(11) default NULL,
  PRIMARY KEY  (`prc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/process.sql 
INSERT INTO `prt_processes` (`prc_virgo_title`, `prc_name`, `prc_execution_time`, `prc_description`, `prc_initiation_code`, `prc_execution_code`, `prc_closing_code`, `prc_portion_size`, `prc_active`, `prc_order`, `prc_last_session`, `prc_subprocess_count`, `prc_clear`) 
VALUES (title, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_processes table already exists.", '', 'FATAL');
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
			return "prc";
		}
		
		static function getPlural() {
			return "processes";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoExecution";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_processes'));
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
			$virgoVersion = virgoProcess::getVirgoVersion();
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
	
	

