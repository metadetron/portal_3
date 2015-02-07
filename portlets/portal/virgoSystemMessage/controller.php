<?php
/**
* Module System message
* @package Portal
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace portal;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoLogLevel'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoSystemMessage {

		 var  $sms_id = null;
		 var  $sms_timestamp = null;

		 var  $sms_message = null;

		 var  $sms_details = null;

		 var  $sms_ip = null;

		 var  $sms_deleted_user_name = null;

		 var  $sms_url = null;

		 var  $sms_stack_trace = null;

		 var  $sms_usr_id = null;
		 var  $sms_llv_id = null;
		 var  $sms_exc_id = null;

		 var   $sms_date_created = null;
		 var   $sms_usr_created_id = null;
		 var   $sms_date_modified = null;
		 var   $sms_usr_modified_id = null;
		 var   $sms_virgo_title = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoSystemMessage();
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
        	$this->sms_id = null;
		    $this->sms_date_created = null;
		    $this->sms_usr_created_id = null;
		    $this->sms_date_modified = null;
		    $this->sms_usr_modified_id = null;
		    $this->sms_virgo_title = null;
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
			return $this->sms_id;
		}

		function getTimestamp() {
			return $this->sms_timestamp;
		}
		
		 function setTimestamp($val) {
			$this->sms_timestamp = $val;
		}
		function getMessage() {
			return $this->sms_message;
		}
		
		 function setMessage($val) {
			$this->sms_message = $val;
		}
		function getDetails() {
			return $this->sms_details;
		}
		
		 function setDetails($val) {
			$this->sms_details = $val;
		}
		function getIp() {
			return $this->sms_ip;
		}
		
		 function setIp($val) {
			$this->sms_ip = $val;
		}
		function getDeletedUserName() {
			return $this->sms_deleted_user_name;
		}
		
		 function setDeletedUserName($val) {
			$this->sms_deleted_user_name = $val;
		}
		function getUrl() {
			return $this->sms_url;
		}
		
		 function setUrl($val) {
			$this->sms_url = $val;
		}
		function getStackTrace() {
			return $this->sms_stack_trace;
		}
		
		 function setStackTrace($val) {
			$this->sms_stack_trace = $val;
		}

		function getUserId() {
			return $this->sms_usr_id;
		}
		
		 function setUserId($val) {
			$this->sms_usr_id = $val;
		}
		function getLogLevelId() {
			return $this->sms_llv_id;
		}
		
		 function setLogLevelId($val) {
			$this->sms_llv_id = $val;
		}
		function getExecutionId() {
			return $this->sms_exc_id;
		}
		
		 function setExecutionId($val) {
			$this->sms_exc_id = $val;
		}

		function getDateCreated() {
			return $this->sms_date_created;
		}
		function getUsrCreatedId() {
			return $this->sms_usr_created_id;
		}
		function getDateModified() {
			return $this->sms_date_modified;
		}
		function getUsrModifiedId() {
			return $this->sms_usr_modified_id;
		}


		function getUsrId() {
			return $this->getUserId();
		}
		
		 function setUsrId($val) {
			$this->setUserId($val);
		}
		function getLlvId() {
			return $this->getLogLevelId();
		}
		
		 function setLlvId($val) {
			$this->setLogLevelId($val);
		}
		function getExcId() {
			return $this->getExecutionId();
		}
		
		 function setExcId($val) {
			$this->setExecutionId($val);
		}

		function getDetailsSnippet($wordCount) {
			if (is_null($this->getDetails()) || trim($this->getDetails()) == "") {
				return "";
			}
		  	return implode( 
			    '', 
		    	array_slice( 
		      		preg_split(
			        	'/([\s,\.;\?\!]+)/', 
		        		$this->getDetails(), 
		        		$wordCount*2+1, 
		        		PREG_SPLIT_DELIM_CAPTURE
		      		),
		      		0,
		      		$wordCount*2-1
		    	)
		  	)."...";
		}
		function getStackTraceSnippet($wordCount) {
			if (is_null($this->getStackTrace()) || trim($this->getStackTrace()) == "") {
				return "";
			}
		  	return implode( 
			    '', 
		    	array_slice( 
		      		preg_split(
			        	'/([\s,\.;\?\!]+)/', 
		        		$this->getStackTrace(), 
		        		$wordCount*2+1, 
		        		PREG_SPLIT_DELIM_CAPTURE
		      		),
		      		0,
		      		$wordCount*2-1
		    	)
		  	)."...";
		}
		function loadRecordFromRequest($rowId) {
			$this->sms_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('sms_timestamp_' . $this->sms_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->sms_timestamp = null;
		} else {
			$this->sms_timestamp = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('sms_message_' . $this->sms_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->sms_message = null;
		} else {
			$this->sms_message = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('sms_details_' . $this->sms_id);
	if (!is_null($tmpValue)) {
		if ($tmpValue == "") {
			$this->sms_details = null;
		} else {
			$this->sms_details = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('sms_ip_' . $this->sms_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->sms_ip = null;
		} else {
			$this->sms_ip = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('sms_deletedUserName_' . $this->sms_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->sms_deleted_user_name = null;
		} else {
			$this->sms_deleted_user_name = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('sms_url_' . $this->sms_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->sms_url = null;
		} else {
			$this->sms_url = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('sms_stackTrace_' . $this->sms_id);
	if (!is_null($tmpValue)) {
		if ($tmpValue == "") {
			$this->sms_stack_trace = null;
		} else {
			$this->sms_stack_trace = $tmpValue;
		}
	}
			$this->sms_usr_id = strval(R('sms_user_' . $this->sms_id));
			$this->sms_llv_id = strval(R('sms_logLevel_' . $this->sms_id));
			$this->sms_exc_id = strval(R('sms_execution_' . $this->sms_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('sms_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaSystemMessage = array();	
			$criteriaFieldSystemMessage = array();	
			$isNullSystemMessage = R('virgo_search_timestamp_is_null');
			
			$criteriaFieldSystemMessage["is_null"] = 0;
			if ($isNullSystemMessage == "not_null") {
				$criteriaFieldSystemMessage["is_null"] = 1;
			} elseif ($isNullSystemMessage == "null") {
				$criteriaFieldSystemMessage["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_timestamp_from');
		$dataTypeCriteria["to"] = R('virgo_search_timestamp_to');

//			if ($isSet) {
			$criteriaFieldSystemMessage["value"] = $dataTypeCriteria;
//			}
			$criteriaSystemMessage["timestamp"] = $criteriaFieldSystemMessage;
			$criteriaFieldSystemMessage = array();	
			$isNullSystemMessage = R('virgo_search_message_is_null');
			
			$criteriaFieldSystemMessage["is_null"] = 0;
			if ($isNullSystemMessage == "not_null") {
				$criteriaFieldSystemMessage["is_null"] = 1;
			} elseif ($isNullSystemMessage == "null") {
				$criteriaFieldSystemMessage["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_message');

//			if ($isSet) {
			$criteriaFieldSystemMessage["value"] = $dataTypeCriteria;
//			}
			$criteriaSystemMessage["message"] = $criteriaFieldSystemMessage;
			$criteriaFieldSystemMessage = array();	
			$isNullSystemMessage = R('virgo_search_details_is_null');
			
			$criteriaFieldSystemMessage["is_null"] = 0;
			if ($isNullSystemMessage == "not_null") {
				$criteriaFieldSystemMessage["is_null"] = 1;
			} elseif ($isNullSystemMessage == "null") {
				$criteriaFieldSystemMessage["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_details');

//			if ($isSet) {
			$criteriaFieldSystemMessage["value"] = $dataTypeCriteria;
//			}
			$criteriaSystemMessage["details"] = $criteriaFieldSystemMessage;
			$criteriaFieldSystemMessage = array();	
			$isNullSystemMessage = R('virgo_search_ip_is_null');
			
			$criteriaFieldSystemMessage["is_null"] = 0;
			if ($isNullSystemMessage == "not_null") {
				$criteriaFieldSystemMessage["is_null"] = 1;
			} elseif ($isNullSystemMessage == "null") {
				$criteriaFieldSystemMessage["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_ip');

//			if ($isSet) {
			$criteriaFieldSystemMessage["value"] = $dataTypeCriteria;
//			}
			$criteriaSystemMessage["ip"] = $criteriaFieldSystemMessage;
			$criteriaFieldSystemMessage = array();	
			$isNullSystemMessage = R('virgo_search_deletedUserName_is_null');
			
			$criteriaFieldSystemMessage["is_null"] = 0;
			if ($isNullSystemMessage == "not_null") {
				$criteriaFieldSystemMessage["is_null"] = 1;
			} elseif ($isNullSystemMessage == "null") {
				$criteriaFieldSystemMessage["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_deletedUserName');

//			if ($isSet) {
			$criteriaFieldSystemMessage["value"] = $dataTypeCriteria;
//			}
			$criteriaSystemMessage["deleted_user_name"] = $criteriaFieldSystemMessage;
			$criteriaFieldSystemMessage = array();	
			$isNullSystemMessage = R('virgo_search_url_is_null');
			
			$criteriaFieldSystemMessage["is_null"] = 0;
			if ($isNullSystemMessage == "not_null") {
				$criteriaFieldSystemMessage["is_null"] = 1;
			} elseif ($isNullSystemMessage == "null") {
				$criteriaFieldSystemMessage["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_url');

//			if ($isSet) {
			$criteriaFieldSystemMessage["value"] = $dataTypeCriteria;
//			}
			$criteriaSystemMessage["url"] = $criteriaFieldSystemMessage;
			$criteriaFieldSystemMessage = array();	
			$isNullSystemMessage = R('virgo_search_stackTrace_is_null');
			
			$criteriaFieldSystemMessage["is_null"] = 0;
			if ($isNullSystemMessage == "not_null") {
				$criteriaFieldSystemMessage["is_null"] = 1;
			} elseif ($isNullSystemMessage == "null") {
				$criteriaFieldSystemMessage["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_stackTrace');

//			if ($isSet) {
			$criteriaFieldSystemMessage["value"] = $dataTypeCriteria;
//			}
			$criteriaSystemMessage["stack_trace"] = $criteriaFieldSystemMessage;
			$criteriaParent = array();	
			$isNull = R('virgo_search_user_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_user', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaSystemMessage["user"] = $criteriaParent;
			$criteriaParent = array();	
			$isNull = R('virgo_search_logLevel_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_logLevel', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
			}
			$criteriaSystemMessage["log_level"] = $criteriaParent;
			$criteriaParent = array();	
			$isNull = R('virgo_search_execution_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_execution', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaSystemMessage["execution"] = $criteriaParent;
			self::setCriteria($criteriaSystemMessage);
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
			$tableFilter = R('virgo_filter_message');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterMessage', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterMessage', null);
			}
			$tableFilter = R('virgo_filter_details');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterDetails', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterDetails', null);
			}
			$tableFilter = R('virgo_filter_ip');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterIp', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterIp', null);
			}
			$tableFilter = R('virgo_filter_deleted_user_name');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterDeletedUserName', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterDeletedUserName', null);
			}
			$tableFilter = R('virgo_filter_url');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterUrl', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterUrl', null);
			}
			$tableFilter = R('virgo_filter_stack_trace');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterStackTrace', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterStackTrace', null);
			}
			$parentFilter = R('virgo_filter_user');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterUser', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterUser', null);
			}
			$parentFilter = R('virgo_filter_title_user');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleUser', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleUser', null);
			}
			$parentFilter = R('virgo_filter_log_level');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterLogLevel', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterLogLevel', null);
			}
			$parentFilter = R('virgo_filter_title_log_level');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleLogLevel', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleLogLevel', null);
			}
			$parentFilter = R('virgo_filter_execution');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterExecution', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterExecution', null);
			}
			$parentFilter = R('virgo_filter_title_execution');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleExecution', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleExecution', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseSystemMessage = ' 1 = 1 ';
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
				$eventColumn = "sms_" . P('event_column');
				$whereClauseSystemMessage = $whereClauseSystemMessage . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseSystemMessage = $whereClauseSystemMessage . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_user');
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
					$inCondition = " prt_system_messages.sms_usr_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_system_messages.sms_usr_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseSystemMessage = $whereClauseSystemMessage . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_log_level');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_system_messages.sms_llv_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_system_messages.sms_llv_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseSystemMessage = $whereClauseSystemMessage . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_execution');
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
					$inCondition = " prt_system_messages.sms_exc_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_system_messages.sms_exc_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseSystemMessage = $whereClauseSystemMessage . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaSystemMessage = self::getCriteria();
			if (isset($criteriaSystemMessage["timestamp"])) {
				$fieldCriteriaTimestamp = $criteriaSystemMessage["timestamp"];
				if ($fieldCriteriaTimestamp["is_null"] == 1) {
$filter = $filter . ' AND prt_system_messages.sms_timestamp IS NOT NULL ';
				} elseif ($fieldCriteriaTimestamp["is_null"] == 2) {
$filter = $filter . ' AND prt_system_messages.sms_timestamp IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaTimestamp["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND prt_system_messages.sms_timestamp >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_system_messages.sms_timestamp <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaSystemMessage["message"])) {
				$fieldCriteriaMessage = $criteriaSystemMessage["message"];
				if ($fieldCriteriaMessage["is_null"] == 1) {
$filter = $filter . ' AND prt_system_messages.sms_message IS NOT NULL ';
				} elseif ($fieldCriteriaMessage["is_null"] == 2) {
$filter = $filter . ' AND prt_system_messages.sms_message IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaMessage["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_system_messages.sms_message like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaSystemMessage["details"])) {
				$fieldCriteriaDetails = $criteriaSystemMessage["details"];
				if ($fieldCriteriaDetails["is_null"] == 1) {
$filter = $filter . ' AND prt_system_messages.sms_details IS NOT NULL ';
				} elseif ($fieldCriteriaDetails["is_null"] == 2) {
$filter = $filter . ' AND prt_system_messages.sms_details IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDetails["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_system_messages.sms_details like ? ";
				$types .= "s";
				$values[] = $condition;				
			}
				}
			}
			if (isset($criteriaSystemMessage["ip"])) {
				$fieldCriteriaIp = $criteriaSystemMessage["ip"];
				if ($fieldCriteriaIp["is_null"] == 1) {
$filter = $filter . ' AND prt_system_messages.sms_ip IS NOT NULL ';
				} elseif ($fieldCriteriaIp["is_null"] == 2) {
$filter = $filter . ' AND prt_system_messages.sms_ip IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaIp["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_system_messages.sms_ip like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaSystemMessage["deleted_user_name"])) {
				$fieldCriteriaDeletedUserName = $criteriaSystemMessage["deleted_user_name"];
				if ($fieldCriteriaDeletedUserName["is_null"] == 1) {
$filter = $filter . ' AND prt_system_messages.sms_deleted_user_name IS NOT NULL ';
				} elseif ($fieldCriteriaDeletedUserName["is_null"] == 2) {
$filter = $filter . ' AND prt_system_messages.sms_deleted_user_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDeletedUserName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_system_messages.sms_deleted_user_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaSystemMessage["url"])) {
				$fieldCriteriaUrl = $criteriaSystemMessage["url"];
				if ($fieldCriteriaUrl["is_null"] == 1) {
$filter = $filter . ' AND prt_system_messages.sms_url IS NOT NULL ';
				} elseif ($fieldCriteriaUrl["is_null"] == 2) {
$filter = $filter . ' AND prt_system_messages.sms_url IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaUrl["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_system_messages.sms_url like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaSystemMessage["stack_trace"])) {
				$fieldCriteriaStackTrace = $criteriaSystemMessage["stack_trace"];
				if ($fieldCriteriaStackTrace["is_null"] == 1) {
$filter = $filter . ' AND prt_system_messages.sms_stack_trace IS NOT NULL ';
				} elseif ($fieldCriteriaStackTrace["is_null"] == 2) {
$filter = $filter . ' AND prt_system_messages.sms_stack_trace IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaStackTrace["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_system_messages.sms_stack_trace like ? ";
				$types .= "s";
				$values[] = $condition;				
			}
				}
			}
			if (isset($criteriaSystemMessage["user"])) {
				$parentCriteria = $criteriaSystemMessage["user"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND sms_usr_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_system_messages.sms_usr_id IN (SELECT usr_id FROM prt_users WHERE usr_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaSystemMessage["log_level"])) {
				$parentCriteria = $criteriaSystemMessage["log_level"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND sms_llv_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND prt_system_messages.sms_llv_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			if (isset($criteriaSystemMessage["execution"])) {
				$parentCriteria = $criteriaSystemMessage["execution"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND sms_exc_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_system_messages.sms_exc_id IN (SELECT exc_id FROM prt_executions WHERE exc_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseSystemMessage = $whereClauseSystemMessage . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseSystemMessage = $whereClauseSystemMessage . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseSystemMessage = $whereClauseSystemMessage . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterTimestamp', null);
				if (S($tableFilter)) {
					$whereClauseSystemMessage = $whereClauseSystemMessage . " AND sms_timestamp LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterMessage', null);
				if (S($tableFilter)) {
					$whereClauseSystemMessage = $whereClauseSystemMessage . " AND sms_message LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterDetails', null);
				if (S($tableFilter)) {
					$whereClauseSystemMessage = $whereClauseSystemMessage . " AND sms_details LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterIp', null);
				if (S($tableFilter)) {
					$whereClauseSystemMessage = $whereClauseSystemMessage . " AND sms_ip LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterDeletedUserName', null);
				if (S($tableFilter)) {
					$whereClauseSystemMessage = $whereClauseSystemMessage . " AND sms_deleted_user_name LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterUrl', null);
				if (S($tableFilter)) {
					$whereClauseSystemMessage = $whereClauseSystemMessage . " AND sms_url LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterStackTrace', null);
				if (S($tableFilter)) {
					$whereClauseSystemMessage = $whereClauseSystemMessage . " AND sms_stack_trace LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterUser', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseSystemMessage = $whereClauseSystemMessage . " AND sms_usr_id IS NULL ";
					} else {
						$whereClauseSystemMessage = $whereClauseSystemMessage . " AND sms_usr_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleUser', null);
				if (S($parentFilter)) {
					$whereClauseSystemMessage = $whereClauseSystemMessage . " AND prt_users_parent.usr_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterLogLevel', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseSystemMessage = $whereClauseSystemMessage . " AND sms_llv_id IS NULL ";
					} else {
						$whereClauseSystemMessage = $whereClauseSystemMessage . " AND sms_llv_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleLogLevel', null);
				if (S($parentFilter)) {
					$whereClauseSystemMessage = $whereClauseSystemMessage . " AND prt_log_levels_parent.llv_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterExecution', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseSystemMessage = $whereClauseSystemMessage . " AND sms_exc_id IS NULL ";
					} else {
						$whereClauseSystemMessage = $whereClauseSystemMessage . " AND sms_exc_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleExecution', null);
				if (S($parentFilter)) {
					$whereClauseSystemMessage = $whereClauseSystemMessage . " AND prt_executions_parent.exc_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClauseSystemMessage;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseSystemMessage = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_system_messages.sms_id, prt_system_messages.sms_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_timestamp', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_timestamp sms_timestamp";
			} else {
				if ($defaultOrderColumn == "sms_timestamp") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_timestamp ";
				}
			}
			if (P('show_table_message', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_message sms_message";
			} else {
				if ($defaultOrderColumn == "sms_message") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_message ";
				}
			}
			if (P('show_table_details', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_details sms_details";
			} else {
				if ($defaultOrderColumn == "sms_details") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_details ";
				}
			}
			if (P('show_table_ip', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_ip sms_ip";
			} else {
				if ($defaultOrderColumn == "sms_ip") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_ip ";
				}
			}
			if (P('show_table_deleted_user_name', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_deleted_user_name sms_deleted_user_name";
			} else {
				if ($defaultOrderColumn == "sms_deleted_user_name") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_deleted_user_name ";
				}
			}
			if (P('show_table_url', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_url sms_url";
			} else {
				if ($defaultOrderColumn == "sms_url") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_url ";
				}
			}
			if (P('show_table_stack_trace', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_stack_trace sms_stack_trace";
			} else {
				if ($defaultOrderColumn == "sms_stack_trace") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_stack_trace ";
				}
			}
			if (class_exists('portal\virgoUser') && P('show_table_user', "1") != "0") { // */ && !in_array("usr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_system_messages.sms_usr_id as sms_usr_id ";
				$queryString = $queryString . ", prt_users_parent.usr_virgo_title as `user` ";
			} else {
				if ($defaultOrderColumn == "user") {
					$orderColumnNotDisplayed = " prt_users_parent.usr_virgo_title ";
				}
			}
			if (class_exists('portal\virgoLogLevel') && P('show_table_log_level', "1") != "0") { // */ && !in_array("llv", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_system_messages.sms_llv_id as sms_llv_id ";
				$queryString = $queryString . ", prt_log_levels_parent.llv_virgo_title as `log_level` ";
			} else {
				if ($defaultOrderColumn == "log_level") {
					$orderColumnNotDisplayed = " prt_log_levels_parent.llv_virgo_title ";
				}
			}
			if (class_exists('portal\virgoExecution') && P('show_table_execution', "1") != "0") { // */ && !in_array("exc", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_system_messages.sms_exc_id as sms_exc_id ";
				$queryString = $queryString . ", prt_executions_parent.exc_virgo_title as `execution` ";
			} else {
				if ($defaultOrderColumn == "execution") {
					$orderColumnNotDisplayed = " prt_executions_parent.exc_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_system_messages ";
			if (class_exists('portal\virgoUser')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_users AS prt_users_parent ON (prt_system_messages.sms_usr_id = prt_users_parent.usr_id) ";
			}
			if (class_exists('portal\virgoLogLevel')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_log_levels AS prt_log_levels_parent ON (prt_system_messages.sms_llv_id = prt_log_levels_parent.llv_id) ";
			}
			if (class_exists('portal\virgoExecution')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_executions AS prt_executions_parent ON (prt_system_messages.sms_exc_id = prt_executions_parent.exc_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseSystemMessage = $whereClauseSystemMessage . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseSystemMessage, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseSystemMessage,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_system_messages"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " sms_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " sms_usr_created_id = ? ";
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
				. "\n FROM prt_system_messages"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_system_messages ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_system_messages ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, sms_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " sms_usr_created_id = ? ";
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
				$query = "SELECT COUNT(sms_id) cnt FROM system_messages";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as system_messages ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as system_messages ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoSystemMessage();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_system_messages WHERE sms_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->sms_id = $row['sms_id'];
$this->sms_timestamp = $row['sms_timestamp'];
$this->sms_message = $row['sms_message'];
$this->sms_details = $row['sms_details'];
$this->sms_ip = $row['sms_ip'];
$this->sms_deleted_user_name = $row['sms_deleted_user_name'];
$this->sms_url = $row['sms_url'];
$this->sms_stack_trace = $row['sms_stack_trace'];
						$this->sms_usr_id = $row['sms_usr_id'];
						$this->sms_llv_id = $row['sms_llv_id'];
						$this->sms_exc_id = $row['sms_exc_id'];
						if ($fetchUsernames) {
							if ($row['sms_date_created']) {
								if ($row['sms_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['sms_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['sms_date_modified']) {
								if ($row['sms_usr_modified_id'] == $row['sms_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['sms_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['sms_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->sms_date_created = $row['sms_date_created'];
						$this->sms_usr_created_id = $fetchUsernames ? $createdBy : $row['sms_usr_created_id'];
						$this->sms_date_modified = $row['sms_date_modified'];
						$this->sms_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['sms_usr_modified_id'];
						$this->sms_virgo_title = $row['sms_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_system_messages SET sms_usr_created_id = {$userId} WHERE sms_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->sms_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoSystemMessage::selectAllAsObjectsStatic('sms_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->sms_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->sms_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('sms_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_sms = new virgoSystemMessage();
				$tmp_sms->load((int)$lookup_id);
				return $tmp_sms->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoSystemMessage');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" sms_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoSystemMessage', "10");
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
				$query = $query . " sms_id as id, sms_virgo_title as title ";
			}
			$query = $query . " FROM prt_system_messages ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoSystemMessage', 'portal') == "1") {
				$privateCondition = " sms_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY sms_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resSystemMessage = array();
				foreach ($rows as $row) {
					$resSystemMessage[$row['id']] = $row['title'];
				}
				return $resSystemMessage;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticSystemMessage = new virgoSystemMessage();
			return $staticSystemMessage->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getUserStatic($parentId) {
			return virgoUser::getById($parentId);
		}
		
		function getUser() {
			return virgoSystemMessage::getUserStatic($this->sms_usr_id);
		}
		static function getLogLevelStatic($parentId) {
			return virgoLogLevel::getById($parentId);
		}
		
		function getLogLevel() {
			return virgoSystemMessage::getLogLevelStatic($this->sms_llv_id);
		}
		static function getExecutionStatic($parentId) {
			return virgoExecution::getById($parentId);
		}
		
		function getExecution() {
			return virgoSystemMessage::getExecutionStatic($this->sms_exc_id);
		}


		function validateObject($virgoOld) {
			if (
(is_null($this->getTimestamp()) || trim($this->getTimestamp()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'TIMESTAMP');
			}			
			if (
(is_null($this->getMessage()) || trim($this->getMessage()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'MESSAGE');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_details_obligatory', "0") == "1") {
				if (
(is_null($this->getDetails()) || trim($this->getDetails()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'DETAILS');
				}			
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
			if (P('show_'.$tmpMode.'_deleted_user_name_obligatory', "0") == "1") {
				if (
(is_null($this->getDeletedUserName()) || trim($this->getDeletedUserName()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'DELETED_USER_NAME');
				}			
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
			if (P('show_'.$tmpMode.'_stack_trace_obligatory', "0") == "1") {
				if (
(is_null($this->getStackTrace()) || trim($this->getStackTrace()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'STACK_TRACE');
				}			
			}
			$tmpMode = (is_null($this->getId()) ? "create" : "form");
			if (P('show_'.$tmpMode.'_user_obligatory', "0") == "1") {
				if (is_null($this->sms_usr_id) || trim($this->sms_usr_id) == "") {
					if (R('create_sms_user_' . $this->sms_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'USER', '');
					}
				}
			}			
				if (is_null($this->sms_llv_id) || trim($this->sms_llv_id) == "") {
					if (R('create_sms_logLevel_' . $this->sms_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'LOG_LEVEL', '');
					}
			}			
			$tmpMode = (is_null($this->getId()) ? "create" : "form");
			if (P('show_'.$tmpMode.'_execution_obligatory', "0") == "1") {
				if (is_null($this->sms_exc_id) || trim($this->sms_exc_id) == "") {
					if (R('create_sms_execution_' . $this->sms_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'EXECUTION', '');
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_system_messages WHERE sms_id = " . $this->getId();
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
				$colNames = $colNames . ", sms_timestamp";
				$values = $values . ", " . (is_null($objectToStore->getTimestamp()) ? "null" : "'" . QE($objectToStore->getTimestamp()) . "'");
				$colNames = $colNames . ", sms_message";
				$values = $values . ", " . (is_null($objectToStore->getMessage()) ? "null" : "'" . QE($objectToStore->getMessage()) . "'");
				$colNames = $colNames . ", sms_details";
				$values = $values . ", " . (is_null($objectToStore->getDetails()) ? "null" : "'" . QE($objectToStore->getDetails()) . "'");
				$colNames = $colNames . ", sms_ip";
				$values = $values . ", " . (is_null($objectToStore->getIp()) ? "null" : "'" . QE($objectToStore->getIp()) . "'");
				$colNames = $colNames . ", sms_deleted_user_name";
				$values = $values . ", " . (is_null($objectToStore->getDeletedUserName()) ? "null" : "'" . QE($objectToStore->getDeletedUserName()) . "'");
				$colNames = $colNames . ", sms_url";
				$values = $values . ", " . (is_null($objectToStore->getUrl()) ? "null" : "'" . QE($objectToStore->getUrl()) . "'");
				$colNames = $colNames . ", sms_stack_trace";
				$values = $values . ", " . (is_null($objectToStore->getStackTrace()) ? "null" : "'" . QE($objectToStore->getStackTrace()) . "'");
				$colNames = $colNames . ", sms_usr_id";
				$values = $values . ", " . (is_null($objectToStore->getUsrId()) || $objectToStore->getUsrId() == "" ? "null" : $objectToStore->getUsrId());
				$colNames = $colNames . ", sms_llv_id";
				$values = $values . ", " . (is_null($objectToStore->getLlvId()) || $objectToStore->getLlvId() == "" ? "null" : $objectToStore->getLlvId());
				$colNames = $colNames . ", sms_exc_id";
				$values = $values . ", " . (is_null($objectToStore->getExcId()) || $objectToStore->getExcId() == "" ? "null" : $objectToStore->getExcId());
				$query = "INSERT INTO prt_history_system_messages (revision, ip, username, user_id, timestamp, sms_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
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
				$colNames = $colNames . ", sms_timestamp";
				$values = $values . ", " . (is_null($objectToStore->getTimestamp()) ? "null" : "'" . QE($objectToStore->getTimestamp()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getMessage() != $objectToStore->getMessage()) {
				if (is_null($objectToStore->getMessage())) {
					$nullifiedProperties = $nullifiedProperties . "message,";
				} else {
				$colNames = $colNames . ", sms_message";
				$values = $values . ", " . (is_null($objectToStore->getMessage()) ? "null" : "'" . QE($objectToStore->getMessage()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getDetails() != $objectToStore->getDetails()) {
				if (is_null($objectToStore->getDetails())) {
					$nullifiedProperties = $nullifiedProperties . "details,";
				} else {
				$colNames = $colNames . ", sms_details";
				$values = $values . ", " . (is_null($objectToStore->getDetails()) ? "null" : "'" . QE($objectToStore->getDetails()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getIp() != $objectToStore->getIp()) {
				if (is_null($objectToStore->getIp())) {
					$nullifiedProperties = $nullifiedProperties . "ip,";
				} else {
				$colNames = $colNames . ", sms_ip";
				$values = $values . ", " . (is_null($objectToStore->getIp()) ? "null" : "'" . QE($objectToStore->getIp()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getDeletedUserName() != $objectToStore->getDeletedUserName()) {
				if (is_null($objectToStore->getDeletedUserName())) {
					$nullifiedProperties = $nullifiedProperties . "deleted_user_name,";
				} else {
				$colNames = $colNames . ", sms_deleted_user_name";
				$values = $values . ", " . (is_null($objectToStore->getDeletedUserName()) ? "null" : "'" . QE($objectToStore->getDeletedUserName()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getUrl() != $objectToStore->getUrl()) {
				if (is_null($objectToStore->getUrl())) {
					$nullifiedProperties = $nullifiedProperties . "url,";
				} else {
				$colNames = $colNames . ", sms_url";
				$values = $values . ", " . (is_null($objectToStore->getUrl()) ? "null" : "'" . QE($objectToStore->getUrl()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getStackTrace() != $objectToStore->getStackTrace()) {
				if (is_null($objectToStore->getStackTrace())) {
					$nullifiedProperties = $nullifiedProperties . "stack_trace,";
				} else {
				$colNames = $colNames . ", sms_stack_trace";
				$values = $values . ", " . (is_null($objectToStore->getStackTrace()) ? "null" : "'" . QE($objectToStore->getStackTrace()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getUsrId() != $objectToStore->getUsrId() && ($virgoOld->getUsrId() != 0 || $objectToStore->getUsrId() != ""))) { 
				$colNames = $colNames . ", sms_usr_id";
				$values = $values . ", " . (is_null($objectToStore->getUsrId()) ? "null" : ($objectToStore->getUsrId() == "" ? "0" : $objectToStore->getUsrId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getLlvId() != $objectToStore->getLlvId() && ($virgoOld->getLlvId() != 0 || $objectToStore->getLlvId() != ""))) { 
				$colNames = $colNames . ", sms_llv_id";
				$values = $values . ", " . (is_null($objectToStore->getLlvId()) ? "null" : ($objectToStore->getLlvId() == "" ? "0" : $objectToStore->getLlvId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getExcId() != $objectToStore->getExcId() && ($virgoOld->getExcId() != 0 || $objectToStore->getExcId() != ""))) { 
				$colNames = $colNames . ", sms_exc_id";
				$values = $values . ", " . (is_null($objectToStore->getExcId()) ? "null" : ($objectToStore->getExcId() == "" ? "0" : $objectToStore->getExcId()));
			}
			$query = "INSERT INTO prt_history_system_messages (revision, ip, username, user_id, timestamp, sms_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_system_messages");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'sms_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_system_messages ADD COLUMN (sms_virgo_title VARCHAR(255));";
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
			if (isset($this->sms_id) && $this->sms_id != "") {
				$query = "UPDATE prt_system_messages SET ";
			if (isset($this->sms_timestamp)) {
				$query .= " sms_timestamp = ? ,";
				$types .= "s";
				$values[] = $this->sms_timestamp;
			} else {
				$query .= " sms_timestamp = NULL ,";				
			}
			if (isset($this->sms_message)) {
				$query .= " sms_message = ? ,";
				$types .= "s";
				$values[] = $this->sms_message;
			} else {
				$query .= " sms_message = NULL ,";				
			}
			if (isset($this->sms_details)) {
				$query .= " sms_details = ? ,";
				$types .= "s";
				$values[] = $this->sms_details;
			} else {
				$query .= " sms_details = NULL ,";				
			}
			if (isset($this->sms_ip)) {
				$query .= " sms_ip = ? ,";
				$types .= "s";
				$values[] = $this->sms_ip;
			} else {
				$query .= " sms_ip = NULL ,";				
			}
			if (isset($this->sms_deleted_user_name)) {
				$query .= " sms_deleted_user_name = ? ,";
				$types .= "s";
				$values[] = $this->sms_deleted_user_name;
			} else {
				$query .= " sms_deleted_user_name = NULL ,";				
			}
			if (isset($this->sms_url)) {
				$query .= " sms_url = ? ,";
				$types .= "s";
				$values[] = $this->sms_url;
			} else {
				$query .= " sms_url = NULL ,";				
			}
			if (isset($this->sms_stack_trace)) {
				$query .= " sms_stack_trace = ? ,";
				$types .= "s";
				$values[] = $this->sms_stack_trace;
			} else {
				$query .= " sms_stack_trace = NULL ,";				
			}
				if (isset($this->sms_usr_id) && trim($this->sms_usr_id) != "") {
					$query = $query . " sms_usr_id = ? , ";
					$types = $types . "i";
					$values[] = $this->sms_usr_id;
				} else {
					$query = $query . " sms_usr_id = NULL, ";
				}
				if (isset($this->sms_llv_id) && trim($this->sms_llv_id) != "") {
					$query = $query . " sms_llv_id = ? , ";
					$types = $types . "i";
					$values[] = $this->sms_llv_id;
				} else {
					$query = $query . " sms_llv_id = NULL, ";
				}
				if (isset($this->sms_exc_id) && trim($this->sms_exc_id) != "") {
					$query = $query . " sms_exc_id = ? , ";
					$types = $types . "i";
					$values[] = $this->sms_exc_id;
				} else {
					$query = $query . " sms_exc_id = NULL, ";
				}
				$query = $query . " sms_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " sms_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->sms_date_modified;

				$query = $query . " sms_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->sms_usr_modified_id;

				$query = $query . " WHERE sms_id = ? ";
				$types = $types . "i";
				$values[] = $this->sms_id;
			} else {
				$query = "INSERT INTO prt_system_messages ( ";
			$query = $query . " sms_timestamp, ";
			$query = $query . " sms_message, ";
			$query = $query . " sms_details, ";
			$query = $query . " sms_ip, ";
			$query = $query . " sms_deleted_user_name, ";
			$query = $query . " sms_url, ";
			$query = $query . " sms_stack_trace, ";
				$query = $query . " sms_usr_id, ";
				$query = $query . " sms_llv_id, ";
				$query = $query . " sms_exc_id, ";
				$query = $query . " sms_virgo_title, sms_date_created, sms_usr_created_id) VALUES ( ";
			if (isset($this->sms_timestamp)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->sms_timestamp;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->sms_message)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->sms_message;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->sms_details)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->sms_details;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->sms_ip)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->sms_ip;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->sms_deleted_user_name)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->sms_deleted_user_name;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->sms_url)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->sms_url;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->sms_stack_trace)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->sms_stack_trace;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->sms_usr_id) && trim($this->sms_usr_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->sms_usr_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->sms_llv_id) && trim($this->sms_llv_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->sms_llv_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->sms_exc_id) && trim($this->sms_exc_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->sms_exc_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->sms_date_created;
				$values[] = $this->sms_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->sms_id) || $this->sms_id == "") {
					$this->sms_id = QID();
				}
				if ($log) {
					L("system message stored successfully", "id = {$this->sms_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->sms_id) {
				$virgoOld = new virgoSystemMessage($this->sms_id);
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
					if ($this->sms_id) {			
						$this->sms_date_modified = date("Y-m-d H:i:s");
						$this->sms_usr_modified_id = $userId;
					} else {
						$this->sms_date_created = date("Y-m-d H:i:s");
						$this->sms_usr_created_id = $userId;
					}
					$this->sms_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "system message" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "system message" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM prt_system_messages WHERE sms_id = {$this->sms_id}";
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
			$tmp = new virgoSystemMessage();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT sms_id as id FROM prt_system_messages";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'sms_order_column')) {
				$orderBy = " ORDER BY sms_order_column ASC ";
			} 
			if (property_exists($this, 'sms_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY sms_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoSystemMessage();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoSystemMessage($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_system_messages SET sms_virgo_title = '$title' WHERE sms_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoSystemMessage();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" sms_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['sms_id'];
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
			virgoSystemMessage::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoSystemMessage::setSessionValue('Portal_SystemMessage-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoSystemMessage::getSessionValue('Portal_SystemMessage-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoSystemMessage::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoSystemMessage::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoSystemMessage::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoSystemMessage::getSessionValue('GLOBAL', $name, $default);
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
			$context['sms_id'] = $id;
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
			$context['sms_id'] = null;
			virgoSystemMessage::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoSystemMessage::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoSystemMessage::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoSystemMessage::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoSystemMessage::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoSystemMessage::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoSystemMessage::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoSystemMessage::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoSystemMessage::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoSystemMessage::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoSystemMessage::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoSystemMessage::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoSystemMessage::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoSystemMessage::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoSystemMessage::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoSystemMessage::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoSystemMessage::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "sms_id";
			}
			return virgoSystemMessage::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoSystemMessage::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoSystemMessage::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoSystemMessage::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoSystemMessage::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoSystemMessage::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoSystemMessage::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoSystemMessage::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoSystemMessage::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoSystemMessage::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoSystemMessage::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoSystemMessage::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoSystemMessage::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->sms_id) {
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
						L(T('STORED_CORRECTLY', 'SYSTEM_MESSAGE'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'timestamp', $this->sms_timestamp);
						$fieldValues = $fieldValues . T($fieldValue, 'message', $this->sms_message);
						$fieldValues = $fieldValues . T($fieldValue, 'details', $this->sms_details);
						$fieldValues = $fieldValues . T($fieldValue, 'ip', $this->sms_ip);
						$fieldValues = $fieldValues . T($fieldValue, 'deleted user name', $this->sms_deleted_user_name);
						$fieldValues = $fieldValues . T($fieldValue, 'url', $this->sms_url);
						$fieldValues = $fieldValues . T($fieldValue, 'stack trace', $this->sms_stack_trace);
						$parentUser = new virgoUser();
						$fieldValues = $fieldValues . T($fieldValue, 'user', $parentUser->lookup($this->sms_usr_id));
						$parentLogLevel = new virgoLogLevel();
						$fieldValues = $fieldValues . T($fieldValue, 'log level', $parentLogLevel->lookup($this->sms_llv_id));
						$parentExecution = new virgoExecution();
						$fieldValues = $fieldValues . T($fieldValue, 'execution', $parentExecution->lookup($this->sms_exc_id));
						$username = '';
						if ($this->sms_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->sms_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->sms_date_created);
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
			$instance = new virgoSystemMessage();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoSystemMessage'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			$tmpId = intval(R('sms_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoSystemMessage::getContextId();
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
			$this->sms_id = null;
			$this->sms_date_created = null;
			$this->sms_usr_created_id = null;
			$this->sms_date_modified = null;
			$this->sms_usr_modified_id = null;
			$this->sms_virgo_title = null;
			
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

		static function portletActionShowForUser() {
			$parentId = R('usr_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoUser($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
			return 0;
		}
		static function portletActionShowForLogLevel() {
			$parentId = R('llv_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoLogLevel($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
			return 0;
		}
		static function portletActionShowForExecution() {
			$parentId = R('exc_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoExecution($parentId);
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
//			$ret = new virgoSystemMessage();
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
				$instance = new virgoSystemMessage();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoSystemMessage::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'SYSTEM_MESSAGE'), '', 'INFO');
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
				$resultSystemMessage = new virgoSystemMessage();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultSystemMessage->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultSystemMessage->load($idToEditInt);
					} else {
						$resultSystemMessage->sms_id = 0;
					}
				}
				$results[] = $resultSystemMessage;
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
				$result = new virgoSystemMessage();
				$result->loadFromRequest($idToStore);
				if ($result->sms_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->sms_id == 0) {
						$result->sms_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->sms_id)) {
							$result->sms_id = 0;
						}
						$idsToCorrect[$result->sms_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'SYSTEM_MESSAGES'), '', 'INFO');
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
			$resultSystemMessage = new virgoSystemMessage();
			foreach ($idsToDelete as $idToDelete) {
				$resultSystemMessage->load((int)trim($idToDelete));
				$res = $resultSystemMessage->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'SYSTEM_MESSAGES'), '', 'INFO');			
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
		$ret = $this->sms_message;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoSystemMessage');
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
				$query = "UPDATE prt_system_messages SET sms_virgo_title = ? WHERE sms_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT sms_id AS id FROM prt_system_messages ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoSystemMessage($row['id']);
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
				$class2prefix["portal\\virgoUser"] = "usr";
				$class2prefix2 = array();
				$class2prefix2["portal\\virgoPage"] = "pge";
				$class2parentPrefix["portal\\virgoUser"] = $class2prefix2;
				$class2prefix["portal\\virgoLogLevel"] = "llv";
				$class2prefix2 = array();
				$class2parentPrefix["portal\\virgoLogLevel"] = $class2prefix2;
				$class2prefix["portal\\virgoExecution"] = "exc";
				$class2prefix2 = array();
				$class2prefix2["portal\\virgoProcess"] = "prc";
				$class2parentPrefix["portal\\virgoExecution"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'prt_system_messages.sms_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_system_messages.sms_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_system_messages.sms_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_system_messages.sms_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoSystemMessage!', '', 'ERROR');
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
			$pdf->SetTitle('System messages report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('SYSTEM_MESSAGES');
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
			if (P('show_pdf_message', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_details', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_ip', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_deleted_user_name', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_url', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_stack_trace', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_user', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_log_level', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_execution', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultSystemMessage = new virgoSystemMessage();
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
			if (P('show_pdf_message', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Message');
				$minWidth['message'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['message']) {
						$minWidth['message'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_details', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Details');
				$minWidth['details'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['details']) {
						$minWidth['details'] = min($tmpLen, $maxWidth);
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
			if (P('show_pdf_deleted_user_name', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Deleted user name');
				$minWidth['deleted user name'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['deleted user name']) {
						$minWidth['deleted user name'] = min($tmpLen, $maxWidth);
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
			if (P('show_pdf_stack_trace', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Stack trace');
				$minWidth['stack trace'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['stack trace']) {
						$minWidth['stack trace'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_user', "1") == "1") {
				$minWidth['user $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'user $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['user $relation.name']) {
						$minWidth['user $relation.name'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_log_level', "1") == "1") {
				$minWidth['log level $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'log level $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['log level $relation.name']) {
						$minWidth['log level $relation.name'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_execution', "1") == "1") {
				$minWidth['execution $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'execution $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['execution $relation.name']) {
						$minWidth['execution $relation.name'] = min($tmpLen, $maxWidth);
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
			$whereClauseSystemMessage = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseSystemMessage = $whereClauseSystemMessage . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaSystemMessage = $resultSystemMessage->getCriteria();
			$fieldCriteriaTimestamp = $criteriaSystemMessage["timestamp"];
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
			$fieldCriteriaMessage = $criteriaSystemMessage["message"];
			if ($fieldCriteriaMessage["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Message', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaMessage["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Message', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaDetails = $criteriaSystemMessage["details"];
			if ($fieldCriteriaDetails["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Details', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaDetails["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Details', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaIp = $criteriaSystemMessage["ip"];
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
			$fieldCriteriaDeletedUserName = $criteriaSystemMessage["deleted_user_name"];
			if ($fieldCriteriaDeletedUserName["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Deleted user name', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaDeletedUserName["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Deleted user name', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaUrl = $criteriaSystemMessage["url"];
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
			$fieldCriteriaStackTrace = $criteriaSystemMessage["stack_trace"];
			if ($fieldCriteriaStackTrace["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Stack trace', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaStackTrace["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Stack trace', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaSystemMessage["user"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'User', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoUser::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'User', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaSystemMessage["log_level"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Log level', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoLogLevel::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Log level', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaSystemMessage["execution"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Execution', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoExecution::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Execution', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_user');
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
					$inCondition = " prt_system_messages.sms_usr_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_system_messages.sms_usr_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseSystemMessage = $whereClauseSystemMessage . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_log_level');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_system_messages.sms_llv_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_system_messages.sms_llv_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseSystemMessage = $whereClauseSystemMessage . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_execution');
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
					$inCondition = " prt_system_messages.sms_exc_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_system_messages.sms_exc_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseSystemMessage = $whereClauseSystemMessage . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaSystemMessage = self::getCriteria();
			if (isset($criteriaSystemMessage["timestamp"])) {
				$fieldCriteriaTimestamp = $criteriaSystemMessage["timestamp"];
				if ($fieldCriteriaTimestamp["is_null"] == 1) {
$filter = $filter . ' AND prt_system_messages.sms_timestamp IS NOT NULL ';
				} elseif ($fieldCriteriaTimestamp["is_null"] == 2) {
$filter = $filter . ' AND prt_system_messages.sms_timestamp IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaTimestamp["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND prt_system_messages.sms_timestamp >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_system_messages.sms_timestamp <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaSystemMessage["message"])) {
				$fieldCriteriaMessage = $criteriaSystemMessage["message"];
				if ($fieldCriteriaMessage["is_null"] == 1) {
$filter = $filter . ' AND prt_system_messages.sms_message IS NOT NULL ';
				} elseif ($fieldCriteriaMessage["is_null"] == 2) {
$filter = $filter . ' AND prt_system_messages.sms_message IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaMessage["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_system_messages.sms_message like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaSystemMessage["details"])) {
				$fieldCriteriaDetails = $criteriaSystemMessage["details"];
				if ($fieldCriteriaDetails["is_null"] == 1) {
$filter = $filter . ' AND prt_system_messages.sms_details IS NOT NULL ';
				} elseif ($fieldCriteriaDetails["is_null"] == 2) {
$filter = $filter . ' AND prt_system_messages.sms_details IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDetails["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_system_messages.sms_details like ? ";
				$types .= "s";
				$values[] = $condition;				
			}
				}
			}
			if (isset($criteriaSystemMessage["ip"])) {
				$fieldCriteriaIp = $criteriaSystemMessage["ip"];
				if ($fieldCriteriaIp["is_null"] == 1) {
$filter = $filter . ' AND prt_system_messages.sms_ip IS NOT NULL ';
				} elseif ($fieldCriteriaIp["is_null"] == 2) {
$filter = $filter . ' AND prt_system_messages.sms_ip IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaIp["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_system_messages.sms_ip like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaSystemMessage["deleted_user_name"])) {
				$fieldCriteriaDeletedUserName = $criteriaSystemMessage["deleted_user_name"];
				if ($fieldCriteriaDeletedUserName["is_null"] == 1) {
$filter = $filter . ' AND prt_system_messages.sms_deleted_user_name IS NOT NULL ';
				} elseif ($fieldCriteriaDeletedUserName["is_null"] == 2) {
$filter = $filter . ' AND prt_system_messages.sms_deleted_user_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDeletedUserName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_system_messages.sms_deleted_user_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaSystemMessage["url"])) {
				$fieldCriteriaUrl = $criteriaSystemMessage["url"];
				if ($fieldCriteriaUrl["is_null"] == 1) {
$filter = $filter . ' AND prt_system_messages.sms_url IS NOT NULL ';
				} elseif ($fieldCriteriaUrl["is_null"] == 2) {
$filter = $filter . ' AND prt_system_messages.sms_url IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaUrl["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_system_messages.sms_url like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaSystemMessage["stack_trace"])) {
				$fieldCriteriaStackTrace = $criteriaSystemMessage["stack_trace"];
				if ($fieldCriteriaStackTrace["is_null"] == 1) {
$filter = $filter . ' AND prt_system_messages.sms_stack_trace IS NOT NULL ';
				} elseif ($fieldCriteriaStackTrace["is_null"] == 2) {
$filter = $filter . ' AND prt_system_messages.sms_stack_trace IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaStackTrace["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_system_messages.sms_stack_trace like ? ";
				$types .= "s";
				$values[] = $condition;				
			}
				}
			}
			if (isset($criteriaSystemMessage["user"])) {
				$parentCriteria = $criteriaSystemMessage["user"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND sms_usr_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_system_messages.sms_usr_id IN (SELECT usr_id FROM prt_users WHERE usr_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaSystemMessage["log_level"])) {
				$parentCriteria = $criteriaSystemMessage["log_level"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND sms_llv_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND prt_system_messages.sms_llv_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			if (isset($criteriaSystemMessage["execution"])) {
				$parentCriteria = $criteriaSystemMessage["execution"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND sms_exc_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_system_messages.sms_exc_id IN (SELECT exc_id FROM prt_executions WHERE exc_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseSystemMessage = $whereClauseSystemMessage . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseSystemMessage = $whereClauseSystemMessage . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_system_messages.sms_id, prt_system_messages.sms_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_timestamp', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_timestamp sms_timestamp";
			} else {
				if ($defaultOrderColumn == "sms_timestamp") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_timestamp ";
				}
			}
			if (P('show_pdf_message', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_message sms_message";
			} else {
				if ($defaultOrderColumn == "sms_message") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_message ";
				}
			}
			if (P('show_pdf_details', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_details sms_details";
			} else {
				if ($defaultOrderColumn == "sms_details") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_details ";
				}
			}
			if (P('show_pdf_ip', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_ip sms_ip";
			} else {
				if ($defaultOrderColumn == "sms_ip") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_ip ";
				}
			}
			if (P('show_pdf_deleted_user_name', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_deleted_user_name sms_deleted_user_name";
			} else {
				if ($defaultOrderColumn == "sms_deleted_user_name") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_deleted_user_name ";
				}
			}
			if (P('show_pdf_url', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_url sms_url";
			} else {
				if ($defaultOrderColumn == "sms_url") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_url ";
				}
			}
			if (P('show_pdf_stack_trace', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_stack_trace sms_stack_trace";
			} else {
				if ($defaultOrderColumn == "sms_stack_trace") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_stack_trace ";
				}
			}
			if (class_exists('portal\virgoUser') && P('show_pdf_user', "1") != "0") { // */ && !in_array("usr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_system_messages.sms_usr_id as sms_usr_id ";
				$queryString = $queryString . ", prt_users_parent.usr_virgo_title as `user` ";
			} else {
				if ($defaultOrderColumn == "user") {
					$orderColumnNotDisplayed = " prt_users_parent.usr_virgo_title ";
				}
			}
			if (class_exists('portal\virgoLogLevel') && P('show_pdf_log_level', "1") != "0") { // */ && !in_array("llv", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_system_messages.sms_llv_id as sms_llv_id ";
				$queryString = $queryString . ", prt_log_levels_parent.llv_virgo_title as `log_level` ";
			} else {
				if ($defaultOrderColumn == "log_level") {
					$orderColumnNotDisplayed = " prt_log_levels_parent.llv_virgo_title ";
				}
			}
			if (class_exists('portal\virgoExecution') && P('show_pdf_execution', "1") != "0") { // */ && !in_array("exc", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_system_messages.sms_exc_id as sms_exc_id ";
				$queryString = $queryString . ", prt_executions_parent.exc_virgo_title as `execution` ";
			} else {
				if ($defaultOrderColumn == "execution") {
					$orderColumnNotDisplayed = " prt_executions_parent.exc_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_system_messages ";
			if (class_exists('portal\virgoUser')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_users AS prt_users_parent ON (prt_system_messages.sms_usr_id = prt_users_parent.usr_id) ";
			}
			if (class_exists('portal\virgoLogLevel')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_log_levels AS prt_log_levels_parent ON (prt_system_messages.sms_llv_id = prt_log_levels_parent.llv_id) ";
			}
			if (class_exists('portal\virgoExecution')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_executions AS prt_executions_parent ON (prt_system_messages.sms_exc_id = prt_executions_parent.exc_id) ";
			}

		$resultsSystemMessage = $resultSystemMessage->select(
			'', 
			'all', 
			$resultSystemMessage->getOrderColumn(), 
			$resultSystemMessage->getOrderMode(), 
			$whereClauseSystemMessage,
			$queryString);
		
		foreach ($resultsSystemMessage as $resultSystemMessage) {

			if (P('show_pdf_timestamp', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultSystemMessage['sms_timestamp'])) + 6;
				if ($tmpLen > $minWidth['timestamp']) {
					$minWidth['timestamp'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_message', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultSystemMessage['sms_message'])) + 6;
				if ($tmpLen > $minWidth['message']) {
					$minWidth['message'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_details', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultSystemMessage['sms_details'])) + 6;
				if ($tmpLen > $minWidth['details']) {
					$minWidth['details'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_ip', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultSystemMessage['sms_ip'])) + 6;
				if ($tmpLen > $minWidth['ip']) {
					$minWidth['ip'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_deleted_user_name', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultSystemMessage['sms_deleted_user_name'])) + 6;
				if ($tmpLen > $minWidth['deleted user name']) {
					$minWidth['deleted user name'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_url', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultSystemMessage['sms_url'])) + 6;
				if ($tmpLen > $minWidth['url']) {
					$minWidth['url'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_stack_trace', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultSystemMessage['sms_stack_trace'])) + 6;
				if ($tmpLen > $minWidth['stack trace']) {
					$minWidth['stack trace'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_user', "1") == "1") {
			$parentValue = trim(virgoUser::lookup($resultSystemMessage['smsusr__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['user $relation.name']) {
					$minWidth['user $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_log_level', "1") == "1") {
			$parentValue = trim(virgoLogLevel::lookup($resultSystemMessage['smsllv__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['log level $relation.name']) {
					$minWidth['log level $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_execution', "1") == "1") {
			$parentValue = trim(virgoExecution::lookup($resultSystemMessage['smsexc__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['execution $relation.name']) {
					$minWidth['execution $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaSystemMessage = $resultSystemMessage->getCriteria();
		if (is_null($criteriaSystemMessage) || sizeof($criteriaSystemMessage) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																																																	if (P('show_pdf_execution', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['execution $relation.name'], $colHeight, T('EXECUTION') . ' ' . T(''), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_timestamp', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['timestamp'], $colHeight, T('TIMESTAMP'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_message', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['message'], $colHeight, T('MESSAGE'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_details', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['details'], $colHeight, T('DETAILS'), 'T', 'C', 0, 0);
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
			if (P('show_pdf_deleted_user_name', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['deleted user name'], $colHeight, T('DELETED_USER_NAME'), 'T', 'C', 0, 0);
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
			if (P('show_pdf_stack_trace', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['stack trace'], $colHeight, T('STACK_TRACE'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_user', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['user $relation.name'], $colHeight, T('USER') . ' ' . T(''), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_log_level', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['log level $relation.name'], $colHeight, T('LOG_LEVEL') . ' ' . T(''), 'T', 'C', 0, 0); 
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
		foreach ($resultsSystemMessage as $resultSystemMessage) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_execution', "1") == "1") {
			$parentValue = virgoExecution::lookup($resultSystemMessage['sms_exc_id']);
			$tmpLn = $pdf->MultiCell($minWidth['execution $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_timestamp', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['timestamp'], $colHeight, '' . $resultSystemMessage['sms_timestamp'], 'T', 'L', 0, 0);
				if (P('show_pdf_timestamp', "1") == "2") {
										if (!is_null($resultSystemMessage['sms_timestamp'])) {
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
										if (!is_null($resultSystemMessage['sms_timestamp'])) {
						$tmpSum = (float)$sums["timestamp"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultSystemMessage['sms_timestamp'];
						}
						$sums["timestamp"] = $tmpSum;
					}
				}
				if (P('show_pdf_timestamp', "1") == "4") {
										if (!is_null($resultSystemMessage['sms_timestamp'])) {
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
							$tmpSum = $tmpSum + $resultSystemMessage['sms_timestamp'];
						}
						$avgSums["timestamp"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_message', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['message'], $colHeight, '' . $resultSystemMessage['sms_message'], 'T', 'L', 0, 0);
				if (P('show_pdf_message', "1") == "2") {
										if (!is_null($resultSystemMessage['sms_message'])) {
						$tmpCount = (float)$counts["message"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["message"] = $tmpCount;
					}
				}
				if (P('show_pdf_message', "1") == "3") {
										if (!is_null($resultSystemMessage['sms_message'])) {
						$tmpSum = (float)$sums["message"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultSystemMessage['sms_message'];
						}
						$sums["message"] = $tmpSum;
					}
				}
				if (P('show_pdf_message', "1") == "4") {
										if (!is_null($resultSystemMessage['sms_message'])) {
						$tmpCount = (float)$avgCounts["message"];
						$tmpSum = (float)$avgSums["message"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["message"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultSystemMessage['sms_message'];
						}
						$avgSums["message"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_details', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['details'], $colHeight, '' . $resultSystemMessage['sms_details'], 'T', 'L', 0, 0);
				if (P('show_pdf_details', "1") == "2") {
										if (!is_null($resultSystemMessage['sms_details'])) {
						$tmpCount = (float)$counts["details"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["details"] = $tmpCount;
					}
				}
				if (P('show_pdf_details', "1") == "3") {
										if (!is_null($resultSystemMessage['sms_details'])) {
						$tmpSum = (float)$sums["details"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultSystemMessage['sms_details'];
						}
						$sums["details"] = $tmpSum;
					}
				}
				if (P('show_pdf_details', "1") == "4") {
										if (!is_null($resultSystemMessage['sms_details'])) {
						$tmpCount = (float)$avgCounts["details"];
						$tmpSum = (float)$avgSums["details"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["details"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultSystemMessage['sms_details'];
						}
						$avgSums["details"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_ip', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['ip'], $colHeight, '' . $resultSystemMessage['sms_ip'], 'T', 'L', 0, 0);
				if (P('show_pdf_ip', "1") == "2") {
										if (!is_null($resultSystemMessage['sms_ip'])) {
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
										if (!is_null($resultSystemMessage['sms_ip'])) {
						$tmpSum = (float)$sums["ip"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultSystemMessage['sms_ip'];
						}
						$sums["ip"] = $tmpSum;
					}
				}
				if (P('show_pdf_ip', "1") == "4") {
										if (!is_null($resultSystemMessage['sms_ip'])) {
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
							$tmpSum = $tmpSum + $resultSystemMessage['sms_ip'];
						}
						$avgSums["ip"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_deleted_user_name', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['deleted user name'], $colHeight, '' . $resultSystemMessage['sms_deleted_user_name'], 'T', 'L', 0, 0);
				if (P('show_pdf_deleted_user_name', "1") == "2") {
										if (!is_null($resultSystemMessage['sms_deleted_user_name'])) {
						$tmpCount = (float)$counts["deleted_user_name"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["deleted_user_name"] = $tmpCount;
					}
				}
				if (P('show_pdf_deleted_user_name', "1") == "3") {
										if (!is_null($resultSystemMessage['sms_deleted_user_name'])) {
						$tmpSum = (float)$sums["deleted_user_name"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultSystemMessage['sms_deleted_user_name'];
						}
						$sums["deleted_user_name"] = $tmpSum;
					}
				}
				if (P('show_pdf_deleted_user_name', "1") == "4") {
										if (!is_null($resultSystemMessage['sms_deleted_user_name'])) {
						$tmpCount = (float)$avgCounts["deleted_user_name"];
						$tmpSum = (float)$avgSums["deleted_user_name"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["deleted_user_name"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultSystemMessage['sms_deleted_user_name'];
						}
						$avgSums["deleted_user_name"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_url', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['url'], $colHeight, '' . $resultSystemMessage['sms_url'], 'T', 'L', 0, 0);
				if (P('show_pdf_url', "1") == "2") {
										if (!is_null($resultSystemMessage['sms_url'])) {
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
										if (!is_null($resultSystemMessage['sms_url'])) {
						$tmpSum = (float)$sums["url"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultSystemMessage['sms_url'];
						}
						$sums["url"] = $tmpSum;
					}
				}
				if (P('show_pdf_url', "1") == "4") {
										if (!is_null($resultSystemMessage['sms_url'])) {
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
							$tmpSum = $tmpSum + $resultSystemMessage['sms_url'];
						}
						$avgSums["url"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_stack_trace', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['stack trace'], $colHeight, '' . $resultSystemMessage['sms_stack_trace'], 'T', 'L', 0, 0);
				if (P('show_pdf_stack_trace', "1") == "2") {
										if (!is_null($resultSystemMessage['sms_stack_trace'])) {
						$tmpCount = (float)$counts["stack_trace"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["stack_trace"] = $tmpCount;
					}
				}
				if (P('show_pdf_stack_trace', "1") == "3") {
										if (!is_null($resultSystemMessage['sms_stack_trace'])) {
						$tmpSum = (float)$sums["stack_trace"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultSystemMessage['sms_stack_trace'];
						}
						$sums["stack_trace"] = $tmpSum;
					}
				}
				if (P('show_pdf_stack_trace', "1") == "4") {
										if (!is_null($resultSystemMessage['sms_stack_trace'])) {
						$tmpCount = (float)$avgCounts["stack_trace"];
						$tmpSum = (float)$avgSums["stack_trace"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["stack_trace"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultSystemMessage['sms_stack_trace'];
						}
						$avgSums["stack_trace"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_user', "1") == "1") {
			$parentValue = virgoUser::lookup($resultSystemMessage['sms_usr_id']);
			$tmpLn = $pdf->MultiCell($minWidth['user $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_log_level', "1") == "1") {
			$parentValue = virgoLogLevel::lookup($resultSystemMessage['sms_llv_id']);
			$tmpLn = $pdf->MultiCell($minWidth['log level $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
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
			if (P('show_pdf_message', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['message'];
				if (P('show_pdf_message', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["message"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_details', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['details'];
				if (P('show_pdf_details', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["details"];
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
			if (P('show_pdf_deleted_user_name', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['deleted user name'];
				if (P('show_pdf_deleted_user_name', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["deleted_user_name"];
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
			if (P('show_pdf_stack_trace', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['stack trace'];
				if (P('show_pdf_stack_trace', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["stack_trace"];
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
			if (P('show_pdf_message', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['message'];
				if (P('show_pdf_message', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["message"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_details', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['details'];
				if (P('show_pdf_details', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["details"], 2, ',', ' ');
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
			if (P('show_pdf_deleted_user_name', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['deleted user name'];
				if (P('show_pdf_deleted_user_name', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["deleted_user_name"], 2, ',', ' ');
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
			if (P('show_pdf_stack_trace', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['stack trace'];
				if (P('show_pdf_stack_trace', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["stack_trace"], 2, ',', ' ');
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
			if (P('show_pdf_message', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['message'];
				if (P('show_pdf_message', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["message"] == 0 ? "-" : $avgSums["message"] / $avgCounts["message"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_details', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['details'];
				if (P('show_pdf_details', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["details"] == 0 ? "-" : $avgSums["details"] / $avgCounts["details"]);
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
			if (P('show_pdf_deleted_user_name', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['deleted user name'];
				if (P('show_pdf_deleted_user_name', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["deleted_user_name"] == 0 ? "-" : $avgSums["deleted_user_name"] / $avgCounts["deleted_user_name"]);
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
			if (P('show_pdf_stack_trace', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['stack trace'];
				if (P('show_pdf_stack_trace', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["stack_trace"] == 0 ? "-" : $avgSums["stack_trace"] / $avgCounts["stack_trace"]);
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
				$reportTitle = T('SYSTEM_MESSAGES');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultSystemMessage = new virgoSystemMessage();
			$whereClauseSystemMessage = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseSystemMessage = $whereClauseSystemMessage . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_timestamp', "1") != "0") {
					$data = $data . $stringDelimeter .'Timestamp' . $stringDelimeter . $separator;
				}
				if (P('show_export_message', "1") != "0") {
					$data = $data . $stringDelimeter .'Message' . $stringDelimeter . $separator;
				}
				if (P('show_export_details', "1") != "0") {
					$data = $data . $stringDelimeter .'Details' . $stringDelimeter . $separator;
				}
				if (P('show_export_ip', "1") != "0") {
					$data = $data . $stringDelimeter .'Ip' . $stringDelimeter . $separator;
				}
				if (P('show_export_deleted_user_name', "1") != "0") {
					$data = $data . $stringDelimeter .'Deleted user name' . $stringDelimeter . $separator;
				}
				if (P('show_export_url', "1") != "0") {
					$data = $data . $stringDelimeter .'Url' . $stringDelimeter . $separator;
				}
				if (P('show_export_stack_trace', "1") != "0") {
					$data = $data . $stringDelimeter .'Stack trace' . $stringDelimeter . $separator;
				}
				if (P('show_export_user', "1") != "0") {
					$data = $data . $stringDelimeter . 'User ' . $stringDelimeter . $separator;
				}
				if (P('show_export_log_level', "1") != "0") {
					$data = $data . $stringDelimeter . 'Log level ' . $stringDelimeter . $separator;
				}
				if (P('show_export_execution', "1") != "0") {
					$data = $data . $stringDelimeter . 'Execution ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_system_messages.sms_id, prt_system_messages.sms_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_timestamp', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_timestamp sms_timestamp";
			} else {
				if ($defaultOrderColumn == "sms_timestamp") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_timestamp ";
				}
			}
			if (P('show_export_message', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_message sms_message";
			} else {
				if ($defaultOrderColumn == "sms_message") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_message ";
				}
			}
			if (P('show_export_details', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_details sms_details";
			} else {
				if ($defaultOrderColumn == "sms_details") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_details ";
				}
			}
			if (P('show_export_ip', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_ip sms_ip";
			} else {
				if ($defaultOrderColumn == "sms_ip") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_ip ";
				}
			}
			if (P('show_export_deleted_user_name', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_deleted_user_name sms_deleted_user_name";
			} else {
				if ($defaultOrderColumn == "sms_deleted_user_name") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_deleted_user_name ";
				}
			}
			if (P('show_export_url', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_url sms_url";
			} else {
				if ($defaultOrderColumn == "sms_url") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_url ";
				}
			}
			if (P('show_export_stack_trace', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_stack_trace sms_stack_trace";
			} else {
				if ($defaultOrderColumn == "sms_stack_trace") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_stack_trace ";
				}
			}
			if (class_exists('portal\virgoUser') && P('show_export_user', "1") != "0") { // */ && !in_array("usr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_system_messages.sms_usr_id as sms_usr_id ";
				$queryString = $queryString . ", prt_users_parent.usr_virgo_title as `user` ";
			} else {
				if ($defaultOrderColumn == "user") {
					$orderColumnNotDisplayed = " prt_users_parent.usr_virgo_title ";
				}
			}
			if (class_exists('portal\virgoLogLevel') && P('show_export_log_level', "1") != "0") { // */ && !in_array("llv", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_system_messages.sms_llv_id as sms_llv_id ";
				$queryString = $queryString . ", prt_log_levels_parent.llv_virgo_title as `log_level` ";
			} else {
				if ($defaultOrderColumn == "log_level") {
					$orderColumnNotDisplayed = " prt_log_levels_parent.llv_virgo_title ";
				}
			}
			if (class_exists('portal\virgoExecution') && P('show_export_execution', "1") != "0") { // */ && !in_array("exc", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_system_messages.sms_exc_id as sms_exc_id ";
				$queryString = $queryString . ", prt_executions_parent.exc_virgo_title as `execution` ";
			} else {
				if ($defaultOrderColumn == "execution") {
					$orderColumnNotDisplayed = " prt_executions_parent.exc_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_system_messages ";
			if (class_exists('portal\virgoUser')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_users AS prt_users_parent ON (prt_system_messages.sms_usr_id = prt_users_parent.usr_id) ";
			}
			if (class_exists('portal\virgoLogLevel')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_log_levels AS prt_log_levels_parent ON (prt_system_messages.sms_llv_id = prt_log_levels_parent.llv_id) ";
			}
			if (class_exists('portal\virgoExecution')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_executions AS prt_executions_parent ON (prt_system_messages.sms_exc_id = prt_executions_parent.exc_id) ";
			}

			$resultsSystemMessage = $resultSystemMessage->select(
				'', 
				'all', 
				$resultSystemMessage->getOrderColumn(), 
				$resultSystemMessage->getOrderMode(), 
				$whereClauseSystemMessage,
				$queryString);
			foreach ($resultsSystemMessage as $resultSystemMessage) {
				if (P('show_export_timestamp', "1") != "0") {
			$data = $data . $resultSystemMessage['sms_timestamp'] . $separator;
				}
				if (P('show_export_message', "1") != "0") {
			$data = $data . $stringDelimeter . $resultSystemMessage['sms_message'] . $stringDelimeter . $separator;
				}
				if (P('show_export_details', "1") != "0") {
			$data = $data . $stringDelimeter . $resultSystemMessage['sms_details'] . $stringDelimeter . $separator;
				}
				if (P('show_export_ip', "1") != "0") {
			$data = $data . $stringDelimeter . $resultSystemMessage['sms_ip'] . $stringDelimeter . $separator;
				}
				if (P('show_export_deleted_user_name', "1") != "0") {
			$data = $data . $stringDelimeter . $resultSystemMessage['sms_deleted_user_name'] . $stringDelimeter . $separator;
				}
				if (P('show_export_url', "1") != "0") {
			$data = $data . $stringDelimeter . $resultSystemMessage['sms_url'] . $stringDelimeter . $separator;
				}
				if (P('show_export_stack_trace', "1") != "0") {
			$data = $data . $stringDelimeter . $resultSystemMessage['sms_stack_trace'] . $stringDelimeter . $separator;
				}
				if (P('show_export_user', "1") != "0") {
					$parentValue = virgoUser::lookup($resultSystemMessage['sms_usr_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_log_level', "1") != "0") {
					$parentValue = virgoLogLevel::lookup($resultSystemMessage['sms_llv_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_execution', "1") != "0") {
					$parentValue = virgoExecution::lookup($resultSystemMessage['sms_exc_id']);
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
				$reportTitle = T('SYSTEM_MESSAGES');
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
			$resultSystemMessage = new virgoSystemMessage();
			$whereClauseSystemMessage = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseSystemMessage = $whereClauseSystemMessage . ' AND ' . $parentContextInfo['condition'];
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
				if (P('show_export_message', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Message');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_details', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Details');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_ip', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Ip');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_deleted_user_name', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Deleted user name');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_url', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Url');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_stack_trace', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Stack trace');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_user', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'User ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoUser::getVirgoList();
					$formulaUser = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaUser != "") {
							$formulaUser = $formulaUser . ',';
						}
						$formulaUser = $formulaUser . $key;
					}
				}
				if (P('show_export_log_level', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Log level ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoLogLevel::getVirgoList();
					$formulaLogLevel = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaLogLevel != "") {
							$formulaLogLevel = $formulaLogLevel . ',';
						}
						$formulaLogLevel = $formulaLogLevel . $key;
					}
				}
				if (P('show_export_execution', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Execution ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoExecution::getVirgoList();
					$formulaExecution = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaExecution != "") {
							$formulaExecution = $formulaExecution . ',';
						}
						$formulaExecution = $formulaExecution . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_system_messages.sms_id, prt_system_messages.sms_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_timestamp', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_timestamp sms_timestamp";
			} else {
				if ($defaultOrderColumn == "sms_timestamp") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_timestamp ";
				}
			}
			if (P('show_export_message', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_message sms_message";
			} else {
				if ($defaultOrderColumn == "sms_message") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_message ";
				}
			}
			if (P('show_export_details', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_details sms_details";
			} else {
				if ($defaultOrderColumn == "sms_details") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_details ";
				}
			}
			if (P('show_export_ip', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_ip sms_ip";
			} else {
				if ($defaultOrderColumn == "sms_ip") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_ip ";
				}
			}
			if (P('show_export_deleted_user_name', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_deleted_user_name sms_deleted_user_name";
			} else {
				if ($defaultOrderColumn == "sms_deleted_user_name") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_deleted_user_name ";
				}
			}
			if (P('show_export_url', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_url sms_url";
			} else {
				if ($defaultOrderColumn == "sms_url") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_url ";
				}
			}
			if (P('show_export_stack_trace', "1") != "0") {
				$queryString = $queryString . ", prt_system_messages.sms_stack_trace sms_stack_trace";
			} else {
				if ($defaultOrderColumn == "sms_stack_trace") {
					$orderColumnNotDisplayed = " prt_system_messages.sms_stack_trace ";
				}
			}
			if (class_exists('portal\virgoUser') && P('show_export_user', "1") != "0") { // */ && !in_array("usr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_system_messages.sms_usr_id as sms_usr_id ";
				$queryString = $queryString . ", prt_users_parent.usr_virgo_title as `user` ";
			} else {
				if ($defaultOrderColumn == "user") {
					$orderColumnNotDisplayed = " prt_users_parent.usr_virgo_title ";
				}
			}
			if (class_exists('portal\virgoLogLevel') && P('show_export_log_level', "1") != "0") { // */ && !in_array("llv", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_system_messages.sms_llv_id as sms_llv_id ";
				$queryString = $queryString . ", prt_log_levels_parent.llv_virgo_title as `log_level` ";
			} else {
				if ($defaultOrderColumn == "log_level") {
					$orderColumnNotDisplayed = " prt_log_levels_parent.llv_virgo_title ";
				}
			}
			if (class_exists('portal\virgoExecution') && P('show_export_execution', "1") != "0") { // */ && !in_array("exc", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_system_messages.sms_exc_id as sms_exc_id ";
				$queryString = $queryString . ", prt_executions_parent.exc_virgo_title as `execution` ";
			} else {
				if ($defaultOrderColumn == "execution") {
					$orderColumnNotDisplayed = " prt_executions_parent.exc_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_system_messages ";
			if (class_exists('portal\virgoUser')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_users AS prt_users_parent ON (prt_system_messages.sms_usr_id = prt_users_parent.usr_id) ";
			}
			if (class_exists('portal\virgoLogLevel')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_log_levels AS prt_log_levels_parent ON (prt_system_messages.sms_llv_id = prt_log_levels_parent.llv_id) ";
			}
			if (class_exists('portal\virgoExecution')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_executions AS prt_executions_parent ON (prt_system_messages.sms_exc_id = prt_executions_parent.exc_id) ";
			}

			$resultsSystemMessage = $resultSystemMessage->select(
				'', 
				'all', 
				$resultSystemMessage->getOrderColumn(), 
				$resultSystemMessage->getOrderMode(), 
				$whereClauseSystemMessage,
				$queryString);
			$index = 1;
			foreach ($resultsSystemMessage as $resultSystemMessage) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultSystemMessage['sms_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_timestamp', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultSystemMessage['sms_timestamp'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_message', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultSystemMessage['sms_message'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_details', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultSystemMessage['sms_details'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_ip', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultSystemMessage['sms_ip'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_deleted_user_name', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultSystemMessage['sms_deleted_user_name'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_url', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultSystemMessage['sms_url'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_stack_trace', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultSystemMessage['sms_stack_trace'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_user', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoUser::lookup($resultSystemMessage['sms_usr_id']);
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
					$objValidation->setFormula1('"' . $formulaUser . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
				if (P('show_export_log_level', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoLogLevel::lookup($resultSystemMessage['sms_llv_id']);
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
					$objValidation->setFormula1('"' . $formulaLogLevel . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
				if (P('show_export_execution', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoExecution::lookup($resultSystemMessage['sms_exc_id']);
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
					$objValidation->setFormula1('"' . $formulaExecution . '"');
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
					$propertyColumnHash['timestamp'] = 'sms_timestamp';
					$propertyColumnHash['timestamp'] = 'sms_timestamp';
					$propertyColumnHash['message'] = 'sms_message';
					$propertyColumnHash['message'] = 'sms_message';
					$propertyColumnHash['details'] = 'sms_details';
					$propertyColumnHash['details'] = 'sms_details';
					$propertyColumnHash['ip'] = 'sms_ip';
					$propertyColumnHash['ip'] = 'sms_ip';
					$propertyColumnHash['deleted user name'] = 'sms_deleted_user_name';
					$propertyColumnHash['deleted_user_name'] = 'sms_deleted_user_name';
					$propertyColumnHash['url'] = 'sms_url';
					$propertyColumnHash['url'] = 'sms_url';
					$propertyColumnHash['stack trace'] = 'sms_stack_trace';
					$propertyColumnHash['stack_trace'] = 'sms_stack_trace';
					$propertyClassHash['user'] = 'User';
					$propertyClassHash['user'] = 'User';
					$propertyColumnHash['user'] = 'sms_usr_id';
					$propertyColumnHash['user'] = 'sms_usr_id';
					$propertyClassHash['log level'] = 'LogLevel';
					$propertyClassHash['log_level'] = 'LogLevel';
					$propertyColumnHash['log level'] = 'sms_llv_id';
					$propertyColumnHash['log_level'] = 'sms_llv_id';
					$propertyClassHash['execution'] = 'Execution';
					$propertyClassHash['execution'] = 'Execution';
					$propertyColumnHash['execution'] = 'sms_exc_id';
					$propertyColumnHash['execution'] = 'sms_exc_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importSystemMessage = new virgoSystemMessage();
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
										L(T('PROPERTY_NOT_FOUND', T('SYSTEM_MESSAGE'), $columns[$index]), '', 'ERROR');
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
										$importSystemMessage->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_user');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoUser::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoUser::token2Id($tmpToken);
	}
	$importSystemMessage->setUsrId($defaultValue);
}
$defaultValue = P('import_default_value_log_level');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoLogLevel::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoLogLevel::token2Id($tmpToken);
	}
	$importSystemMessage->setLlvId($defaultValue);
}
$defaultValue = P('import_default_value_execution');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoExecution::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoExecution::token2Id($tmpToken);
	}
	$importSystemMessage->setExcId($defaultValue);
}
							$errorMessage = $importSystemMessage->store();
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
		

		static function portletActionVirgoChangeLogLevel() {
			$instance = new virgoSystemMessage();
			$instance->loadFromDB();
			self::portletActionSelect(true, $instance->getId());
			$parentId = R('virgo_parent_id');
			$parent = virgoLogLevel::getById($parentId);
			$title = $parent->getVirgoTitle();
			if (!is_null($title) && trim($title) != "") {
				$instance->setLlvId($parentId);
				$errorMessage = $instance->store();
				if ($errorMessage == "") {
					L(T('PARENT_SET', T('LOG_LEVEL'), $title), '', 'INFO');
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

		static function portletActionVirgoSetUser() {
			$this->loadFromDB();
			$parentId = R('sms_User_id_' . $_SESSION['current_portlet_object_id']);
			$this->setUsrId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetLogLevel() {
			$this->loadFromDB();
			$parentId = R('sms_LogLevel_id_' . $_SESSION['current_portlet_object_id']);
			$this->setLlvId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetExecution() {
			$this->loadFromDB();
			$parentId = R('sms_Execution_id_' . $_SESSION['current_portlet_object_id']);
			$this->setExcId($parentId);
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
		static function write($message, $details = null, $level = 'INFO') {
			require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoChannelLevel'.DIRECTORY_SEPARATOR.'controller.php');
			$logLevel = virgoLogLevel::getByNameStatic($level);
			foreach ($logLevel->getChannelLevels() as $channelLevel) {
				$className = $channelLevel->getLogChannel()->getHandlerClassName();
				$file = PORTAL_PATH . '/classes/LogHandlers/' . $className . '.php';
				if (file_exists($file)) {
					require_once($file);
					if (class_exists($className)) {
						if (method_exists($className, 'write')) {
							$class = new $className();
							$class->write($logLevel, $message, $details);
						} else {
							echo "LOG SYSTEM FAILED: Method not found: " . $className . '->write()';
						}
					} else {
						echo "LOG SYSTEM FAILED: Class not found: " . $className;
					}
				} else {
					echo "LOG SYSTEM FAILED: File not found: " . $file;
				}
				
			}
		}
		
		static function getRealIp() {
		  if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
			return $_SERVER['HTTP_CLIENT_IP']; // share internet
		  } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			return $_SERVER['HTTP_X_FORWARDED_FOR']; // pass from proxy
		  } else {
			return $_SERVER['REMOTE_ADDR'];
		  }
		}		
		
		static function getRealUrl() {
			$pageURL = 'http';
			if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
			if ($_SERVER["SERVER_PORT"] != "80") {
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
			} else {
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			}
			return $pageURL;
		}
		
		static function storeInDB($logLevelId, $message, $details, $logStackTrace = false) {
			$systemMessage = new virgoSystemMessage();
			$systemMessage->setTimestamp(date("Y-m-d H:i:s"));
			$systemMessage->setLogLevelId($logLevelId);
			$systemMessage->setMessage($message);
			$systemMessage->setDetails($details);
			if ($logStackTrace) {
				ob_start();
				debug_print_backtrace();
				$systemMessage->setStackTrace(ob_get_clean());
			}
			$systemMessage->setIp(virgoSystemMessage::getRealIp());
			$systemMessage->setUrl(virgoSystemMessage::getRealUrl());
			$user = virgoUser::getUser();
			$systemMessage->setUserId($user->getId());
			$ret = $systemMessage->store(false);
			if ($ret != "") {
				echo "LOG SYSTEM FAILED: " . $ret;
			}
		}
		
		function  portletActionClearLog() {
			$query = " DELETE FROM prt_system_messages ";
			Q($query);
			return 0;
		}

		function portletActionStatistics() {
			$this->setDisplayMode("STATISTICS");
		}

		function portletActionDeleteMonths() {
			$monthsToDelete = R('virgo_month_to_delete');
			foreach ($monthsToDelete as $monthToDelete) {
				$query = "DELETE FROM prt_system_messages WHERE sms_timestamp LIKE '{$monthToDelete}%'";
				Q($query);
			}
			L('Entries deleted', '', 'INFO');
		}

		static function getStatisticSelect() {
			return <<<SQL
SELECT 
	SUBSTR(sms_timestamp, 1, 7) AS month, 
	COUNT(*) cnt
FROM 
	prt_system_messages
GROUP BY 
	SUBSTR(sms_timestamp, 1, 7)
ORDER BY 
	SUBSTR(sms_timestamp, 1, 7)
SQL;
		}


		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `prt_system_messages` (
  `sms_id` bigint(20) unsigned NOT NULL auto_increment,
  `sms_virgo_state` varchar(50) default NULL,
  `sms_virgo_title` varchar(255) default NULL,
	`sms_usr_id` int(11) default NULL,
	`sms_llv_id` int(11) default NULL,
	`sms_exc_id` int(11) default NULL,
  `sms_timestamp` datetime, 
  `sms_message` varchar(255), 
  `sms_details` longtext, 
  `sms_ip` varchar(255), 
  `sms_deleted_user_name` varchar(255), 
  `sms_url` varchar(255), 
  `sms_stack_trace` longtext, 
  `sms_date_created` datetime NOT NULL,
  `sms_date_modified` datetime default NULL,
  `sms_usr_created_id` int(11) NOT NULL,
  `sms_usr_modified_id` int(11) default NULL,
  KEY `sms_usr_fk` (`sms_usr_id`),
  KEY `sms_llv_fk` (`sms_llv_id`),
  KEY `sms_exc_fk` (`sms_exc_id`),
  PRIMARY KEY  (`sms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/system_message.sql 
INSERT INTO `prt_system_messages` (`sms_virgo_title`, `sms_timestamp`, `sms_message`, `sms_details`, `sms_ip`, `sms_deleted_user_name`, `sms_url`, `sms_stack_trace`) 
VALUES (title, some_value, some_value, some_value, some_value, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_system_messages table already exists.", '', 'FATAL');
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
			return "sms";
		}
		
		static function getPlural() {
			return "system_messages";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoUser";
			$ret[] = "virgoLogLevel";
			$ret[] = "virgoExecution";
			return $ret;
		}

		static function getChildren() {
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_system_messages'));
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
			$virgoVersion = virgoSystemMessage::getVirgoVersion();
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
	
	

