<?php
/**
* Module Log level
* @package Portal
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace portal;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoSystemMessage'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoChannelLevel'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoLogLevel {

		 var  $llv_id = null;
		 var  $llv_name = null;

		 var  $llv_description = null;

		 var  $llv_display_order = null;

		 var  $llv_log_stack_trace = null;


		 var   $_logChannelIdsToAddArray = null;
		 var   $_logChannelIdsToDeleteArray = null;
		 var   $llv_date_created = null;
		 var   $llv_usr_created_id = null;
		 var   $llv_date_modified = null;
		 var   $llv_usr_modified_id = null;
		 var   $llv_virgo_title = null;
		 var   $llv_virgo_deleted = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoLogLevel();
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
        	$this->llv_id = null;
		    $this->llv_date_created = null;
		    $this->llv_usr_created_id = null;
		    $this->llv_date_modified = null;
		    $this->llv_usr_modified_id = null;
		    $this->llv_virgo_title = null;
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
			return $this->llv_id;
		}

		function getName() {
			return $this->llv_name;
		}
		
		 function setName($val) {
			$this->llv_name = $val;
		}
		function getDescription() {
			return $this->llv_description;
		}
		
		 function setDescription($val) {
			$this->llv_description = $val;
		}
		function getDisplayOrder() {
			return $this->llv_display_order;
		}
		
		 function setDisplayOrder($val) {
			$this->llv_display_order = $val;
		}
		function getLogStackTrace() {
			return $this->llv_log_stack_trace;
		}
		
		 function setLogStackTrace($val) {
			$this->llv_log_stack_trace = $val;
		}


		function getDateCreated() {
			return $this->llv_date_created;
		}
		function getUsrCreatedId() {
			return $this->llv_usr_created_id;
		}
		function getDateModified() {
			return $this->llv_date_modified;
		}
		function getUsrModifiedId() {
			return $this->llv_usr_modified_id;
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
			$this->llv_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('llv_name_' . $this->llv_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->llv_name = null;
		} else {
			$this->llv_name = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('llv_description_' . $this->llv_id);
	if (!is_null($tmpValue)) {
		if ($tmpValue == "") {
			$this->llv_description = null;
		} else {
			$this->llv_description = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('llv_displayOrder_' . $this->llv_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->llv_display_order = null;
		} else {
			$this->llv_display_order = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('llv_logStackTrace_' . $this->llv_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->llv_log_stack_trace = null;
		} else {
			$this->llv_log_stack_trace = $tmpValue;
		}
	}

			$tmp_ids = R('llv_channelLevel_' . $this->llv_id, null); 			if (is_null($tmp_ids)) {
				$tmp_ids = array();
			}
			if (is_array($tmp_ids)) { 
				$this->_logChannelIdsToAddArray = $tmp_ids;
				$this->_logChannelIdsToDeleteArray = array();
				$currentConnections = $this->getChannelLevels();
				foreach ($currentConnections as $currentConnection) {
					if (in_array($currentConnection->getLogChannelId(), $tmp_ids)) {
						foreach($this->_logChannelIdsToAddArray as $key => $value) {
							if ($value == $currentConnection->getLogChannelId()) {
								unset($this->_logChannelIdsToAddArray[$key]);
							}
						}
						$this->_logChannelIdsToAddArray = array_values($this->_logChannelIdsToAddArray);
					} else {
						$this->_logChannelIdsToDeleteArray[] = $currentConnection->getLogChannelId();
					}
				}
			}
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('llv_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaLogLevel = array();	
			$criteriaFieldLogLevel = array();	
			$isNullLogLevel = R('virgo_search_name_is_null');
			
			$criteriaFieldLogLevel["is_null"] = 0;
			if ($isNullLogLevel == "not_null") {
				$criteriaFieldLogLevel["is_null"] = 1;
			} elseif ($isNullLogLevel == "null") {
				$criteriaFieldLogLevel["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_name');

//			if ($isSet) {
			$criteriaFieldLogLevel["value"] = $dataTypeCriteria;
//			}
			$criteriaLogLevel["name"] = $criteriaFieldLogLevel;
			$criteriaFieldLogLevel = array();	
			$isNullLogLevel = R('virgo_search_description_is_null');
			
			$criteriaFieldLogLevel["is_null"] = 0;
			if ($isNullLogLevel == "not_null") {
				$criteriaFieldLogLevel["is_null"] = 1;
			} elseif ($isNullLogLevel == "null") {
				$criteriaFieldLogLevel["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_description');

//			if ($isSet) {
			$criteriaFieldLogLevel["value"] = $dataTypeCriteria;
//			}
			$criteriaLogLevel["description"] = $criteriaFieldLogLevel;
			$criteriaFieldLogLevel = array();	
			$isNullLogLevel = R('virgo_search_displayOrder_is_null');
			
			$criteriaFieldLogLevel["is_null"] = 0;
			if ($isNullLogLevel == "not_null") {
				$criteriaFieldLogLevel["is_null"] = 1;
			} elseif ($isNullLogLevel == "null") {
				$criteriaFieldLogLevel["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_displayOrder_from');
		$dataTypeCriteria["to"] = R('virgo_search_displayOrder_to');

//			if ($isSet) {
			$criteriaFieldLogLevel["value"] = $dataTypeCriteria;
//			}
			$criteriaLogLevel["display_order"] = $criteriaFieldLogLevel;
			$criteriaFieldLogLevel = array();	
			$isNullLogLevel = R('virgo_search_logStackTrace_is_null');
			
			$criteriaFieldLogLevel["is_null"] = 0;
			if ($isNullLogLevel == "not_null") {
				$criteriaFieldLogLevel["is_null"] = 1;
			} elseif ($isNullLogLevel == "null") {
				$criteriaFieldLogLevel["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_logStackTrace');

//			if ($isSet) {
			$criteriaFieldLogLevel["value"] = $dataTypeCriteria;
//			}
			$criteriaLogLevel["log_stack_trace"] = $criteriaFieldLogLevel;
			$parent = R('virgo_search_logChannel', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
				$criteriaLogLevel["log_channel"] = $criteriaParent;
			}
			self::setCriteria($criteriaLogLevel);
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
			$tableFilter = R('virgo_filter_description');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterDescription', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterDescription', null);
			}
			$tableFilter = R('virgo_filter_display_order');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterDisplayOrder', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterDisplayOrder', null);
			}
			$tableFilter = R('virgo_filter_log_stack_trace');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterLogStackTrace', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterLogStackTrace', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseLogLevel = ' 1 = 1 ';
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
				$eventColumn = "llv_" . P('event_column');
				$whereClauseLogLevel = $whereClauseLogLevel . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseLogLevel = $whereClauseLogLevel . ' AND ' . $parentContextInfo['condition'];
			}
			$filter = "";
			$criteriaLogLevel = self::getCriteria();
			if (isset($criteriaLogLevel["name"])) {
				$fieldCriteriaName = $criteriaLogLevel["name"];
				if ($fieldCriteriaName["is_null"] == 1) {
$filter = $filter . ' AND prt_log_levels.llv_name IS NOT NULL ';
				} elseif ($fieldCriteriaName["is_null"] == 2) {
$filter = $filter . ' AND prt_log_levels.llv_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_log_levels.llv_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaLogLevel["description"])) {
				$fieldCriteriaDescription = $criteriaLogLevel["description"];
				if ($fieldCriteriaDescription["is_null"] == 1) {
$filter = $filter . ' AND prt_log_levels.llv_description IS NOT NULL ';
				} elseif ($fieldCriteriaDescription["is_null"] == 2) {
$filter = $filter . ' AND prt_log_levels.llv_description IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDescription["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_log_levels.llv_description like ? ";
				$types .= "s";
				$values[] = $condition;				
			}
				}
			}
			if (isset($criteriaLogLevel["display_order"])) {
				$fieldCriteriaDisplayOrder = $criteriaLogLevel["display_order"];
				if ($fieldCriteriaDisplayOrder["is_null"] == 1) {
$filter = $filter . ' AND prt_log_levels.llv_display_order IS NOT NULL ';
				} elseif ($fieldCriteriaDisplayOrder["is_null"] == 2) {
$filter = $filter . ' AND prt_log_levels.llv_display_order IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDisplayOrder["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_log_levels.llv_display_order = ? ";
				} else {
					$filter = $filter . " AND prt_log_levels.llv_display_order >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_log_levels.llv_display_order <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaLogLevel["log_stack_trace"])) {
				$fieldCriteriaLogStackTrace = $criteriaLogLevel["log_stack_trace"];
				if ($fieldCriteriaLogStackTrace["is_null"] == 1) {
$filter = $filter . ' AND prt_log_levels.llv_log_stack_trace IS NOT NULL ';
				} elseif ($fieldCriteriaLogStackTrace["is_null"] == 2) {
$filter = $filter . ' AND prt_log_levels.llv_log_stack_trace IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaLogStackTrace["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_log_levels.llv_log_stack_trace = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaLogLevel["log_channel"])) {
				$parentCriteria = $criteriaLogLevel["log_channel"];
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$filter = $filter . " AND prt_log_levels.llv_id IN (SELECT second_parent.clv_llv_id FROM prt_channel_levels AS second_parent WHERE second_parent.clv_lch_id IN (" . implode(", ", $parentIds) . ")) ";
				}
			}
			$whereClauseLogLevel = $whereClauseLogLevel . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseLogLevel = $whereClauseLogLevel . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseLogLevel = $whereClauseLogLevel . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterName', null);
				if (S($tableFilter)) {
					$whereClauseLogLevel = $whereClauseLogLevel . " AND llv_name LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterDescription', null);
				if (S($tableFilter)) {
					$whereClauseLogLevel = $whereClauseLogLevel . " AND llv_description LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterDisplayOrder', null);
				if (S($tableFilter)) {
					$whereClauseLogLevel = $whereClauseLogLevel . " AND llv_display_order LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterLogStackTrace', null);
				if (S($tableFilter)) {
					$whereClauseLogLevel = $whereClauseLogLevel . " AND llv_log_stack_trace LIKE '%{$tableFilter}%' ";
				}
			}
			return $whereClauseLogLevel;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseLogLevel = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_log_levels.llv_id, prt_log_levels.llv_virgo_title ";
			$queryString = $queryString . " ,prt_log_levels.llv_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column', 'llv_display_order');
			$orderColumnNotDisplayed = "";
			if (P('show_table_name', "1") != "0") {
				$queryString = $queryString . ", prt_log_levels.llv_name llv_name";
			} else {
				if ($defaultOrderColumn == "llv_name") {
					$orderColumnNotDisplayed = " prt_log_levels.llv_name ";
				}
			}
			if (P('show_table_description', "1") != "0") {
				$queryString = $queryString . ", prt_log_levels.llv_description llv_description";
			} else {
				if ($defaultOrderColumn == "llv_description") {
					$orderColumnNotDisplayed = " prt_log_levels.llv_description ";
				}
			}
			if (P('show_table_display_order', "1") != "0") {
				$queryString = $queryString . ", prt_log_levels.llv_display_order llv_display_order";
			} else {
				if ($defaultOrderColumn == "llv_display_order") {
					$orderColumnNotDisplayed = " prt_log_levels.llv_display_order ";
				}
			}
			if (P('show_table_log_stack_trace', "1") != "0") {
				$queryString = $queryString . ", prt_log_levels.llv_log_stack_trace llv_log_stack_trace";
			} else {
				if ($defaultOrderColumn == "llv_log_stack_trace") {
					$orderColumnNotDisplayed = " prt_log_levels.llv_log_stack_trace ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_log_levels ";

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseLogLevel = $whereClauseLogLevel . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseLogLevel, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseLogLevel,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_log_levels"
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
				. "\n FROM prt_log_levels"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_log_levels ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_log_levels ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, llv_id $orderMode";
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
				$query = "SELECT COUNT(llv_id) cnt FROM log_levels";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as log_levels ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as log_levels ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoLogLevel();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_log_levels WHERE llv_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->llv_id = $row['llv_id'];
$this->llv_name = $row['llv_name'];
$this->llv_description = $row['llv_description'];
$this->llv_display_order = $row['llv_display_order'];
$this->llv_log_stack_trace = $row['llv_log_stack_trace'];
						if ($fetchUsernames) {
							if ($row['llv_date_created']) {
								if ($row['llv_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['llv_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['llv_date_modified']) {
								if ($row['llv_usr_modified_id'] == $row['llv_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['llv_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['llv_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->llv_date_created = $row['llv_date_created'];
						$this->llv_usr_created_id = $fetchUsernames ? $createdBy : $row['llv_usr_created_id'];
						$this->llv_date_modified = $row['llv_date_modified'];
						$this->llv_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['llv_usr_modified_id'];
						$this->llv_virgo_title = $row['llv_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_log_levels SET llv_usr_created_id = {$userId} WHERE llv_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->llv_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoLogLevel::selectAllAsObjectsStatic('llv_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->llv_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->llv_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('llv_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_llv = new virgoLogLevel();
				$tmp_llv->load((int)$lookup_id);
				return $tmp_llv->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoLogLevel');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" llv_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoLogLevel', "10");
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
				$query = $query . " llv_id as id, llv_virgo_title as title ";
			}
			$query = $query . " FROM prt_log_levels ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			$query = $query . $tmpQuery;
			$query = $query . " AND (llv_virgo_deleted IS NULL OR llv_virgo_deleted = 0) ";
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY llv_display_order ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resLogLevel = array();
				foreach ($rows as $row) {
					$resLogLevel[$row['id']] = $row['title'];
				}
				return $resLogLevel;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticLogLevel = new virgoLogLevel();
			return $staticLogLevel->getVirgoList($where, $sizeOnly, $hash);
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
			$resultsSystemMessage = virgoSystemMessage::selectAll('sms_llv_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsSystemMessage as $resultSystemMessage) {
				$tmpSystemMessage = virgoSystemMessage::getById($resultSystemMessage['sms_id']); 
				array_push($resSystemMessage, $tmpSystemMessage);
			}
			return $resSystemMessage;
		}

		function getSystemMessages($orderBy = '', $extraWhere = null) {
			return virgoLogLevel::getSystemMessagesStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getChannelLevelsStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resChannelLevel = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoChannelLevel'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resChannelLevel;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resChannelLevel;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsChannelLevel = virgoChannelLevel::selectAll('clv_llv_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsChannelLevel as $resultChannelLevel) {
				$tmpChannelLevel = virgoChannelLevel::getById($resultChannelLevel['clv_id']); 
				array_push($resChannelLevel, $tmpChannelLevel);
			}
			return $resChannelLevel;
		}

		function getChannelLevels($orderBy = '', $extraWhere = null) {
			return virgoLogLevel::getChannelLevelsStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
			if (
(is_null($this->getName()) || trim($this->getName()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'NAME');
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
			if (P('show_'.$tmpMode.'_display_order_obligatory', "0") == "1") {
				if (
(is_null($this->getDisplayOrder()) || trim($this->getDisplayOrder()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'DISPLAY_ORDER');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_log_stack_trace_obligatory', "0") == "1") {
				if (
(is_null($this->getLogStackTrace()) || trim($this->getLogStackTrace()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'LOG_STACK_TRACE');
				}			
			}
 			if (!is_null($this->llv_display_order) && trim($this->llv_display_order) != "") {
				if (!is_numeric($this->llv_display_order)) {
					return T('INCORRECT_NUMBER', 'DISPLAY_ORDER', $this->llv_display_order);
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_log_levels WHERE llv_id = " . $this->getId();
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
				$colNames = $colNames . ", llv_name";
				$values = $values . ", " . (is_null($objectToStore->getName()) ? "null" : "'" . QE($objectToStore->getName()) . "'");
				$colNames = $colNames . ", llv_description";
				$values = $values . ", " . (is_null($objectToStore->getDescription()) ? "null" : "'" . QE($objectToStore->getDescription()) . "'");
				$colNames = $colNames . ", llv_display_order";
				$values = $values . ", " . (is_null($objectToStore->getDisplayOrder()) ? "null" : "'" . QE($objectToStore->getDisplayOrder()) . "'");
				$colNames = $colNames . ", llv_log_stack_trace";
				$values = $values . ", " . (is_null($objectToStore->getLogStackTrace()) ? "null" : "'" . QE($objectToStore->getLogStackTrace()) . "'");
				$query = "INSERT INTO prt_history_log_levels (revision, ip, username, user_id, timestamp, llv_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
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
				$colNames = $colNames . ", llv_name";
				$values = $values . ", " . (is_null($objectToStore->getName()) ? "null" : "'" . QE($objectToStore->getName()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getDescription() != $objectToStore->getDescription()) {
				if (is_null($objectToStore->getDescription())) {
					$nullifiedProperties = $nullifiedProperties . "description,";
				} else {
				$colNames = $colNames . ", llv_description";
				$values = $values . ", " . (is_null($objectToStore->getDescription()) ? "null" : "'" . QE($objectToStore->getDescription()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getDisplayOrder() != $objectToStore->getDisplayOrder()) {
				if (is_null($objectToStore->getDisplayOrder())) {
					$nullifiedProperties = $nullifiedProperties . "display_order,";
				} else {
				$colNames = $colNames . ", llv_display_order";
				$values = $values . ", " . (is_null($objectToStore->getDisplayOrder()) ? "null" : "'" . QE($objectToStore->getDisplayOrder()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getLogStackTrace() != $objectToStore->getLogStackTrace()) {
				if (is_null($objectToStore->getLogStackTrace())) {
					$nullifiedProperties = $nullifiedProperties . "log_stack_trace,";
				} else {
				$colNames = $colNames . ", llv_log_stack_trace";
				$values = $values . ", " . (is_null($objectToStore->getLogStackTrace()) ? "null" : "'" . QE($objectToStore->getLogStackTrace()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			$query = "INSERT INTO prt_history_log_levels (revision, ip, username, user_id, timestamp, llv_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_log_levels");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'llv_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_log_levels ADD COLUMN (llv_virgo_title VARCHAR(255));";
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
			if (isset($this->llv_id) && $this->llv_id != "") {
				$query = "UPDATE prt_log_levels SET ";
			if (isset($this->llv_name)) {
				$query .= " llv_name = ? ,";
				$types .= "s";
				$values[] = $this->llv_name;
			} else {
				$query .= " llv_name = NULL ,";				
			}
			if (isset($this->llv_description)) {
				$query .= " llv_description = ? ,";
				$types .= "s";
				$values[] = $this->llv_description;
			} else {
				$query .= " llv_description = NULL ,";				
			}
			if (isset($this->llv_display_order)) {
				$query .= " llv_display_order = ? ,";
				$types .= "i";
				$values[] = $this->llv_display_order;
			} else {
				$query .= " llv_display_order = NULL ,";				
			}
			if (isset($this->llv_log_stack_trace)) {
				$query .= " llv_log_stack_trace = ? ,";
				$types .= "s";
				$values[] = $this->llv_log_stack_trace;
			} else {
				$query .= " llv_log_stack_trace = NULL ,";				
			}
				if (isset($this->llv_virgo_deleted)) {
					$query = $query . " llv_virgo_deleted = ? , ";
					$types = $types . "i";
					$values[] = $this->llv_virgo_deleted;
				} else {
					$query = $query . " llv_virgo_deleted = NULL , ";
				}
				$query = $query . " llv_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " llv_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->llv_date_modified;

				$query = $query . " llv_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->llv_usr_modified_id;

				$query = $query . " WHERE llv_id = ? ";
				$types = $types . "i";
				$values[] = $this->llv_id;
			} else {
				$query = "INSERT INTO prt_log_levels ( ";
			$query = $query . " llv_name, ";
			$query = $query . " llv_description, ";
			$query = $query . " llv_display_order, ";
			$query = $query . " llv_log_stack_trace, ";
				$query = $query . " llv_virgo_title, llv_date_created, llv_usr_created_id) VALUES ( ";
			if (isset($this->llv_name)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->llv_name;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->llv_description)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->llv_description;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->llv_display_order)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->llv_display_order;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->llv_log_stack_trace)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->llv_log_stack_trace;
			} else {
				$query .= " NULL ,";				
			}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->llv_date_created;
				$values[] = $this->llv_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->llv_id) || $this->llv_id == "") {
					$this->llv_id = QID();
				}
				if ($log) {
					L("log level stored successfully", "id = {$this->llv_id}", "TRACE");
				}
				return true;
			}
		}
		

		static function addLogChannelStatic($thisId, $id) {
			$query = " SELECT COUNT(clv_id) AS cnt FROM prt_channel_levels WHERE clv_llv_id = {$thisId} AND clv_lch_id = {$id} ";
			$res = Q1($query);
			if ($res == 0) {
				$newChannelLevel = new virgoChannelLevel();
				$newChannelLevel->setLogChannelId($id);
				$newChannelLevel->setLogLevelId($thisId);
				return $newChannelLevel->store();
			}			
			return "";
		}
		
		function addLogChannel($id) {
			return virgoLogLevel::addLogChannelStatic($this->getId(), $id);
		}
		
		static function removeLogChannelStatic($thisId, $id) {
			$query = " SELECT clv_id AS id FROM prt_channel_levels WHERE clv_llv_id = {$thisId} AND clv_lch_id = {$id} ";
			$res = QR($query);
			foreach ($res as $re) {
				$newChannelLevel = new virgoChannelLevel($re['id']);
				return $newChannelLevel->delete();
			}			
			return "";
		}
		
		function removeLogChannel($id) {
			return virgoLogLevel::removeLogChannelStatic($this->getId(), $id);
		}
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->llv_id) {
				$virgoOld = new virgoLogLevel($this->llv_id);
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
					if ($this->llv_id) {			
						$this->llv_date_modified = date("Y-m-d H:i:s");
						$this->llv_usr_modified_id = $userId;
					} else {
						$this->llv_date_created = date("Y-m-d H:i:s");
						$this->llv_usr_created_id = $userId;
					}
					$this->llv_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "log level" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "log level" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
						}
					}
					if (!is_null($this->_logChannelIdsToAddArray)) {
						foreach ($this->_logChannelIdsToAddArray as $logChannelId) {
							$ret = $this->addLogChannel((int)$logChannelId);
							if ($ret != "") {
								L($ret, '', 'ERROR');
							}
						}
					}
					if (!is_null($this->_logChannelIdsToDeleteArray)) {
						foreach ($this->_logChannelIdsToDeleteArray as $logChannelId) {
							$ret = $this->removeLogChannel((int)$logChannelId);
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
			$query = "DELETE FROM prt_log_levels WHERE llv_id = {$this->llv_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			self::removeFromContext();
			$this->llv_virgo_deleted = true;
			$this->llv_date_modified = date("Y-m-d H:i:s");
			$userId = virgoUser::getUserId();
			$this->llv_usr_modified_id = $userId;
			$this->parentStore(true);
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoLogLevel();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT llv_id as id FROM prt_log_levels";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'llv_order_column')) {
				$orderBy = " ORDER BY llv_order_column ASC ";
			} 
			if (property_exists($this, 'llv_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY llv_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoLogLevel();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoLogLevel($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_log_levels SET llv_virgo_title = '$title' WHERE llv_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getByNameStatic($token) {
			$tmpStatic = new virgoLogLevel();
			$tmpId = $tmpStatic->getIdByName($token);
			$tmpStatic->load($tmpId);
			return $tmpStatic;
		}
		
		static function getIdByNameStatic($token) {
			$tmpStatic = new virgoLogLevel();
			return $tmpStatic->getIdByName($token);
		}
		
		function getIdByName($token) {
			$res = $this->selectAll(" llv_name = ?", "", "s", array($token));
			foreach ($res as $r) {
				return $r['llv_id'];
			}
			return null;
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoLogLevel();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" llv_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['llv_id'];
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
			virgoLogLevel::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoLogLevel::setSessionValue('Portal_LogLevel-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoLogLevel::getSessionValue('Portal_LogLevel-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoLogLevel::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoLogLevel::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoLogLevel::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoLogLevel::getSessionValue('GLOBAL', $name, $default);
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
			$context['llv_id'] = $id;
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
			$context['llv_id'] = null;
			virgoLogLevel::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoLogLevel::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoLogLevel::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoLogLevel::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoLogLevel::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoLogLevel::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoLogLevel::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoLogLevel::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoLogLevel::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoLogLevel::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoLogLevel::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoLogLevel::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoLogLevel::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoLogLevel::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoLogLevel::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoLogLevel::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoLogLevel::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column', 'llv_display_order');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "llv_id";
			}
			return virgoLogLevel::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoLogLevel::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoLogLevel::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoLogLevel::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoLogLevel::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoLogLevel::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoLogLevel::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoLogLevel::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoLogLevel::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoLogLevel::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoLogLevel::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoLogLevel::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoLogLevel::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->llv_id) {
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
						L(T('STORED_CORRECTLY', 'LOG_LEVEL'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'name', $this->llv_name);
						$fieldValues = $fieldValues . T($fieldValue, 'description', $this->llv_description);
						$fieldValues = $fieldValues . T($fieldValue, 'display order', $this->llv_display_order);
						$fieldValues = $fieldValues . T($fieldValue, 'log stack trace', $this->llv_log_stack_trace);
						$username = '';
						if ($this->llv_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->llv_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->llv_date_created);
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
			$instance = new virgoLogLevel();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoLogLevel'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
				$resIds = $tmpSystemMessage->select(null, 'all', null, null, ' sms_llv_id = ' . $instance->getId(), ' SELECT sms_id FROM prt_system_messages ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->sms_id;
//					JRequest::setVar('sms_log_level_' . $resId->sms_id, $this->getId());
				} 
//				JRequest::setVar('sms_log_level_', $instance->getId());
				$tmpSystemMessage->setRecordSet($resIdsString);
				if (!$tmpSystemMessage->portletActionStoreSelected()) {
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
			$tmpId = intval(R('llv_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoLogLevel::getContextId();
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
			$this->llv_id = null;
			$this->llv_date_created = null;
			$this->llv_usr_created_id = null;
			$this->llv_date_modified = null;
			$this->llv_usr_modified_id = null;
			$this->llv_virgo_title = null;
			$this->llv_virgo_deleted = null;
			
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
//			$ret = new virgoLogLevel();
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
				$instance = new virgoLogLevel();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoLogLevel::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'LOG_LEVEL'), '', 'INFO');
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
			$objectToSwapWith = new virgoLogLevel($idToSwapWith);
			$val1 = $this->getDisplayOrder();
			$val2 = $objectToSwapWith->getDisplayOrder();
			if (is_null($val1)) {
				$val1 = 1;
			}
			if (is_null($val2)) {
				$val2 = 1;
			}
			if ($val1 == $val2) {
				$val1 = $val2 + 1;
			}
			$objectToSwapWith->setDisplayOrder($val1);
			$this->setDisplayOrder($val2);
			$objectToSwapWith->store(false);
			$this->store(false);
			$this->putInContext();
			return 0;
		}
		
		static function portletActionVirgoDown() {
			$this->loadFromDB();
			$idToSwapWith = R('virgo_swap_down_with_' . $this->getId());
			$objectToSwapWith = new virgoLogLevel($idToSwapWith);
			$val1 = $this->getDisplayOrder();
			$val2 = $objectToSwapWith->getDisplayOrder();
			if (is_null($val1)) {
				$val1 = 1;
			}
			if (is_null($val2)) {
				$val2 = 1;
			}
			if ($val1 == $val2) {
				$val1 = $val2 - 1;
			}
			$objectToSwapWith->setDisplayOrder($val1);
			$this->setDisplayOrder($val2);
			$objectToSwapWith->store(false);
			$this->store(false);
			$this->putInContext();
			return 0;
		}
		
		static function portletActionVirgoSetLogStackTraceTrue() {
			$this->loadFromDB();
			$this->setLogStackTrace(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetLogStackTraceFalse() {
			$this->loadFromDB();
			$this->setLogStackTrace(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isLogStackTrace() {
			return $this->getLogStackTrace() == 1;
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
				$resultLogLevel = new virgoLogLevel();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultLogLevel->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultLogLevel->load($idToEditInt);
					} else {
						$resultLogLevel->llv_id = 0;
					}
				}
				$results[] = $resultLogLevel;
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
				$result = new virgoLogLevel();
				$result->loadFromRequest($idToStore);
				if ($result->llv_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->llv_id == 0) {
						$result->llv_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->llv_id)) {
							$result->llv_id = 0;
						}
						$idsToCorrect[$result->llv_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'LOG_LEVELS'), '', 'INFO');
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
			$resultLogLevel = new virgoLogLevel();
			foreach ($idsToDelete as $idToDelete) {
				$resultLogLevel->load((int)trim($idToDelete));
				$res = $resultLogLevel->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'LOG_LEVELS'), '', 'INFO');			
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
		$ret = $this->llv_name;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoLogLevel');
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
				$query = "UPDATE prt_log_levels SET llv_virgo_title = ? WHERE llv_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT llv_id AS id FROM prt_log_levels ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoLogLevel($row['id']);
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
						$parentInfo['condition'] = 'prt_log_levels.llv_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_log_levels.llv_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_log_levels.llv_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_log_levels.llv_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoLogLevel!', '', 'ERROR');
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
			$pdf->SetTitle('Log levels report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('LOG_LEVELS');
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
			if (P('show_pdf_description', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_display_order', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_log_stack_trace', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultLogLevel = new virgoLogLevel();
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
			if (P('show_pdf_display_order', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Display order');
				$minWidth['display order'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['display order']) {
						$minWidth['display order'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_log_stack_trace', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Log stack trace');
				$minWidth['log stack trace'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['log stack trace']) {
						$minWidth['log stack trace'] = min($tmpLen, $maxWidth);
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
			$whereClauseLogLevel = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseLogLevel = $whereClauseLogLevel . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaLogLevel = $resultLogLevel->getCriteria();
			$fieldCriteriaName = $criteriaLogLevel["name"];
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
			$fieldCriteriaDescription = $criteriaLogLevel["description"];
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
			$fieldCriteriaDisplayOrder = $criteriaLogLevel["display_order"];
			if ($fieldCriteriaDisplayOrder["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Display order', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaDisplayOrder["value"];
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
					$pdf->MultiCell(60, 100, 'Display order', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaLogStackTrace = $criteriaLogLevel["log_stack_trace"];
			if ($fieldCriteriaLogStackTrace["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Log stack trace', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaLogStackTrace["value"];
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
					$pdf->MultiCell(60, 100, 'Log stack trace', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$filter = "";
			$criteriaLogLevel = self::getCriteria();
			if (isset($criteriaLogLevel["name"])) {
				$fieldCriteriaName = $criteriaLogLevel["name"];
				if ($fieldCriteriaName["is_null"] == 1) {
$filter = $filter . ' AND prt_log_levels.llv_name IS NOT NULL ';
				} elseif ($fieldCriteriaName["is_null"] == 2) {
$filter = $filter . ' AND prt_log_levels.llv_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_log_levels.llv_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaLogLevel["description"])) {
				$fieldCriteriaDescription = $criteriaLogLevel["description"];
				if ($fieldCriteriaDescription["is_null"] == 1) {
$filter = $filter . ' AND prt_log_levels.llv_description IS NOT NULL ';
				} elseif ($fieldCriteriaDescription["is_null"] == 2) {
$filter = $filter . ' AND prt_log_levels.llv_description IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDescription["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_log_levels.llv_description like ? ";
				$types .= "s";
				$values[] = $condition;				
			}
				}
			}
			if (isset($criteriaLogLevel["display_order"])) {
				$fieldCriteriaDisplayOrder = $criteriaLogLevel["display_order"];
				if ($fieldCriteriaDisplayOrder["is_null"] == 1) {
$filter = $filter . ' AND prt_log_levels.llv_display_order IS NOT NULL ';
				} elseif ($fieldCriteriaDisplayOrder["is_null"] == 2) {
$filter = $filter . ' AND prt_log_levels.llv_display_order IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDisplayOrder["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_log_levels.llv_display_order = ? ";
				} else {
					$filter = $filter . " AND prt_log_levels.llv_display_order >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_log_levels.llv_display_order <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaLogLevel["log_stack_trace"])) {
				$fieldCriteriaLogStackTrace = $criteriaLogLevel["log_stack_trace"];
				if ($fieldCriteriaLogStackTrace["is_null"] == 1) {
$filter = $filter . ' AND prt_log_levels.llv_log_stack_trace IS NOT NULL ';
				} elseif ($fieldCriteriaLogStackTrace["is_null"] == 2) {
$filter = $filter . ' AND prt_log_levels.llv_log_stack_trace IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaLogStackTrace["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_log_levels.llv_log_stack_trace = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaLogLevel["log_channel"])) {
				$parentCriteria = $criteriaLogLevel["log_channel"];
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$filter = $filter . " AND prt_log_levels.llv_id IN (SELECT second_parent.clv_llv_id FROM prt_channel_levels AS second_parent WHERE second_parent.clv_lch_id IN (" . implode(", ", $parentIds) . ")) ";
				}
			}
			$whereClauseLogLevel = $whereClauseLogLevel . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseLogLevel = $whereClauseLogLevel . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_log_levels.llv_id, prt_log_levels.llv_virgo_title ";
			$queryString = $queryString . " ,prt_log_levels.llv_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column', 'llv_display_order');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_name', "1") != "0") {
				$queryString = $queryString . ", prt_log_levels.llv_name llv_name";
			} else {
				if ($defaultOrderColumn == "llv_name") {
					$orderColumnNotDisplayed = " prt_log_levels.llv_name ";
				}
			}
			if (P('show_pdf_description', "1") != "0") {
				$queryString = $queryString . ", prt_log_levels.llv_description llv_description";
			} else {
				if ($defaultOrderColumn == "llv_description") {
					$orderColumnNotDisplayed = " prt_log_levels.llv_description ";
				}
			}
			if (P('show_pdf_display_order', "1") != "0") {
				$queryString = $queryString . ", prt_log_levels.llv_display_order llv_display_order";
			} else {
				if ($defaultOrderColumn == "llv_display_order") {
					$orderColumnNotDisplayed = " prt_log_levels.llv_display_order ";
				}
			}
			if (P('show_pdf_log_stack_trace', "1") != "0") {
				$queryString = $queryString . ", prt_log_levels.llv_log_stack_trace llv_log_stack_trace";
			} else {
				if ($defaultOrderColumn == "llv_log_stack_trace") {
					$orderColumnNotDisplayed = " prt_log_levels.llv_log_stack_trace ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_log_levels ";

		$resultsLogLevel = $resultLogLevel->select(
			'', 
			'all', 
			$resultLogLevel->getOrderColumn(), 
			$resultLogLevel->getOrderMode(), 
			$whereClauseLogLevel,
			$queryString);
		
		foreach ($resultsLogLevel as $resultLogLevel) {

			if (P('show_pdf_name', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultLogLevel['llv_name'])) + 6;
				if ($tmpLen > $minWidth['name']) {
					$minWidth['name'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_description', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultLogLevel['llv_description'])) + 6;
				if ($tmpLen > $minWidth['description']) {
					$minWidth['description'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_display_order', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultLogLevel['llv_display_order'])) + 6;
				if ($tmpLen > $minWidth['display order']) {
					$minWidth['display order'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_log_stack_trace', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultLogLevel['llv_log_stack_trace'])) + 6;
				if ($tmpLen > $minWidth['log stack trace']) {
					$minWidth['log stack trace'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaLogLevel = $resultLogLevel->getCriteria();
		if (is_null($criteriaLogLevel) || sizeof($criteriaLogLevel) == 0 || $countTmp == 0) {
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
			if (P('show_pdf_description', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['description'], $colHeight, T('DESCRIPTION'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_display_order', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['display order'], $colHeight, T('DISPLAY_ORDER'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_log_stack_trace', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['log stack trace'], $colHeight, T('LOG_STACK_TRACE'), 'T', 'C', 0, 0);
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
		foreach ($resultsLogLevel as $resultLogLevel) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_name', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['name'], $colHeight, '' . $resultLogLevel['llv_name'], 'T', 'L', 0, 0);
				if (P('show_pdf_name', "1") == "2") {
										if (!is_null($resultLogLevel['llv_name'])) {
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
										if (!is_null($resultLogLevel['llv_name'])) {
						$tmpSum = (float)$sums["name"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLogLevel['llv_name'];
						}
						$sums["name"] = $tmpSum;
					}
				}
				if (P('show_pdf_name', "1") == "4") {
										if (!is_null($resultLogLevel['llv_name'])) {
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
							$tmpSum = $tmpSum + $resultLogLevel['llv_name'];
						}
						$avgSums["name"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_description', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['description'], $colHeight, '' . $resultLogLevel['llv_description'], 'T', 'L', 0, 0);
				if (P('show_pdf_description', "1") == "2") {
										if (!is_null($resultLogLevel['llv_description'])) {
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
										if (!is_null($resultLogLevel['llv_description'])) {
						$tmpSum = (float)$sums["description"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLogLevel['llv_description'];
						}
						$sums["description"] = $tmpSum;
					}
				}
				if (P('show_pdf_description', "1") == "4") {
										if (!is_null($resultLogLevel['llv_description'])) {
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
							$tmpSum = $tmpSum + $resultLogLevel['llv_description'];
						}
						$avgSums["description"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_display_order', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['display order'], $colHeight, '' . $resultLogLevel['llv_display_order'], 'T', 'R', 0, 0);
				if (P('show_pdf_display_order', "1") == "2") {
										if (!is_null($resultLogLevel['llv_display_order'])) {
						$tmpCount = (float)$counts["display_order"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["display_order"] = $tmpCount;
					}
				}
				if (P('show_pdf_display_order', "1") == "3") {
										if (!is_null($resultLogLevel['llv_display_order'])) {
						$tmpSum = (float)$sums["display_order"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLogLevel['llv_display_order'];
						}
						$sums["display_order"] = $tmpSum;
					}
				}
				if (P('show_pdf_display_order', "1") == "4") {
										if (!is_null($resultLogLevel['llv_display_order'])) {
						$tmpCount = (float)$avgCounts["display_order"];
						$tmpSum = (float)$avgSums["display_order"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["display_order"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLogLevel['llv_display_order'];
						}
						$avgSums["display_order"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_log_stack_trace', "0") != "0") {
			$renderCriteria = "";
			switch ($resultLogLevel['llv_log_stack_trace']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['log stack trace'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_log_stack_trace', "1") == "2") {
										if (!is_null($resultLogLevel['llv_log_stack_trace'])) {
						$tmpCount = (float)$counts["log_stack_trace"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["log_stack_trace"] = $tmpCount;
					}
				}
				if (P('show_pdf_log_stack_trace', "1") == "3") {
										if (!is_null($resultLogLevel['llv_log_stack_trace'])) {
						$tmpSum = (float)$sums["log_stack_trace"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLogLevel['llv_log_stack_trace'];
						}
						$sums["log_stack_trace"] = $tmpSum;
					}
				}
				if (P('show_pdf_log_stack_trace', "1") == "4") {
										if (!is_null($resultLogLevel['llv_log_stack_trace'])) {
						$tmpCount = (float)$avgCounts["log_stack_trace"];
						$tmpSum = (float)$avgSums["log_stack_trace"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["log_stack_trace"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLogLevel['llv_log_stack_trace'];
						}
						$avgSums["log_stack_trace"] = $tmpSum;
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
			if (P('show_pdf_display_order', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['display order'];
				if (P('show_pdf_display_order', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["display_order"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_log_stack_trace', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['log stack trace'];
				if (P('show_pdf_log_stack_trace', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["log_stack_trace"];
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
			if (P('show_pdf_display_order', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['display order'];
				if (P('show_pdf_display_order', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["display_order"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_log_stack_trace', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['log stack trace'];
				if (P('show_pdf_log_stack_trace', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["log_stack_trace"], 2, ',', ' ');
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
			if (P('show_pdf_display_order', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['display order'];
				if (P('show_pdf_display_order', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["display_order"] == 0 ? "-" : $avgSums["display_order"] / $avgCounts["display_order"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_log_stack_trace', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['log stack trace'];
				if (P('show_pdf_log_stack_trace', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["log_stack_trace"] == 0 ? "-" : $avgSums["log_stack_trace"] / $avgCounts["log_stack_trace"]);
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
				$reportTitle = T('LOG_LEVELS');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultLogLevel = new virgoLogLevel();
			$whereClauseLogLevel = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseLogLevel = $whereClauseLogLevel . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_name', "1") != "0") {
					$data = $data . $stringDelimeter .'Name' . $stringDelimeter . $separator;
				}
				if (P('show_export_description', "1") != "0") {
					$data = $data . $stringDelimeter .'Description' . $stringDelimeter . $separator;
				}
				if (P('show_export_display_order', "1") != "0") {
					$data = $data . $stringDelimeter .'Display order' . $stringDelimeter . $separator;
				}
				if (P('show_export_log_stack_trace', "1") != "0") {
					$data = $data . $stringDelimeter .'Log stack trace' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_log_levels.llv_id, prt_log_levels.llv_virgo_title ";
			$queryString = $queryString . " ,prt_log_levels.llv_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column', 'llv_display_order');
			$orderColumnNotDisplayed = "";
			if (P('show_export_name', "1") != "0") {
				$queryString = $queryString . ", prt_log_levels.llv_name llv_name";
			} else {
				if ($defaultOrderColumn == "llv_name") {
					$orderColumnNotDisplayed = " prt_log_levels.llv_name ";
				}
			}
			if (P('show_export_description', "1") != "0") {
				$queryString = $queryString . ", prt_log_levels.llv_description llv_description";
			} else {
				if ($defaultOrderColumn == "llv_description") {
					$orderColumnNotDisplayed = " prt_log_levels.llv_description ";
				}
			}
			if (P('show_export_display_order', "1") != "0") {
				$queryString = $queryString . ", prt_log_levels.llv_display_order llv_display_order";
			} else {
				if ($defaultOrderColumn == "llv_display_order") {
					$orderColumnNotDisplayed = " prt_log_levels.llv_display_order ";
				}
			}
			if (P('show_export_log_stack_trace', "1") != "0") {
				$queryString = $queryString . ", prt_log_levels.llv_log_stack_trace llv_log_stack_trace";
			} else {
				if ($defaultOrderColumn == "llv_log_stack_trace") {
					$orderColumnNotDisplayed = " prt_log_levels.llv_log_stack_trace ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_log_levels ";

			$resultsLogLevel = $resultLogLevel->select(
				'', 
				'all', 
				$resultLogLevel->getOrderColumn(), 
				$resultLogLevel->getOrderMode(), 
				$whereClauseLogLevel,
				$queryString);
			foreach ($resultsLogLevel as $resultLogLevel) {
				if (P('show_export_name', "1") != "0") {
			$data = $data . $stringDelimeter . $resultLogLevel['llv_name'] . $stringDelimeter . $separator;
				}
				if (P('show_export_description', "1") != "0") {
			$data = $data . $stringDelimeter . $resultLogLevel['llv_description'] . $stringDelimeter . $separator;
				}
				if (P('show_export_display_order', "1") != "0") {
			$data = $data . $resultLogLevel['llv_display_order'] . $separator;
				}
				if (P('show_export_log_stack_trace', "1") != "0") {
			$data = $data . $resultLogLevel['llv_log_stack_trace'] . $separator;
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
				$reportTitle = T('LOG_LEVELS');
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
			$resultLogLevel = new virgoLogLevel();
			$whereClauseLogLevel = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseLogLevel = $whereClauseLogLevel . ' AND ' . $parentContextInfo['condition'];
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
				if (P('show_export_description', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Description');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_display_order', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Display order');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_log_stack_trace', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Log stack trace');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_log_levels.llv_id, prt_log_levels.llv_virgo_title ";
			$queryString = $queryString . " ,prt_log_levels.llv_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column', 'llv_display_order');
			$orderColumnNotDisplayed = "";
			if (P('show_export_name', "1") != "0") {
				$queryString = $queryString . ", prt_log_levels.llv_name llv_name";
			} else {
				if ($defaultOrderColumn == "llv_name") {
					$orderColumnNotDisplayed = " prt_log_levels.llv_name ";
				}
			}
			if (P('show_export_description', "1") != "0") {
				$queryString = $queryString . ", prt_log_levels.llv_description llv_description";
			} else {
				if ($defaultOrderColumn == "llv_description") {
					$orderColumnNotDisplayed = " prt_log_levels.llv_description ";
				}
			}
			if (P('show_export_display_order', "1") != "0") {
				$queryString = $queryString . ", prt_log_levels.llv_display_order llv_display_order";
			} else {
				if ($defaultOrderColumn == "llv_display_order") {
					$orderColumnNotDisplayed = " prt_log_levels.llv_display_order ";
				}
			}
			if (P('show_export_log_stack_trace', "1") != "0") {
				$queryString = $queryString . ", prt_log_levels.llv_log_stack_trace llv_log_stack_trace";
			} else {
				if ($defaultOrderColumn == "llv_log_stack_trace") {
					$orderColumnNotDisplayed = " prt_log_levels.llv_log_stack_trace ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_log_levels ";

			$resultsLogLevel = $resultLogLevel->select(
				'', 
				'all', 
				$resultLogLevel->getOrderColumn(), 
				$resultLogLevel->getOrderMode(), 
				$whereClauseLogLevel,
				$queryString);
			$index = 1;
			foreach ($resultsLogLevel as $resultLogLevel) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultLogLevel['llv_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_name', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultLogLevel['llv_name'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_description', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultLogLevel['llv_description'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_display_order', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultLogLevel['llv_display_order'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_log_stack_trace', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultLogLevel['llv_log_stack_trace'], \PHPExcel_Cell_DataType::TYPE_STRING);
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
					$propertyColumnHash['name'] = 'llv_name';
					$propertyColumnHash['name'] = 'llv_name';
					$propertyColumnHash['description'] = 'llv_description';
					$propertyColumnHash['description'] = 'llv_description';
					$propertyColumnHash['display order'] = 'llv_display_order';
					$propertyColumnHash['display_order'] = 'llv_display_order';
					$propertyColumnHash['log stack trace'] = 'llv_log_stack_trace';
					$propertyColumnHash['log_stack_trace'] = 'llv_log_stack_trace';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importLogLevel = new virgoLogLevel();
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
										L(T('PROPERTY_NOT_FOUND', T('LOG_LEVEL'), $columns[$index]), '', 'ERROR');
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
										$importLogLevel->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
							$errorMessage = $importLogLevel->store();
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


		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `prt_log_levels` (
  `llv_id` bigint(20) unsigned NOT NULL auto_increment,
  `llv_virgo_state` varchar(50) default NULL,
  `llv_virgo_title` varchar(255) default NULL,
  `llv_virgo_deleted` boolean,
  `llv_name` varchar(255), 
  `llv_description` longtext, 
  `llv_display_order` integer,  
  `llv_log_stack_trace` boolean,  
  `llv_date_created` datetime NOT NULL,
  `llv_date_modified` datetime default NULL,
  `llv_usr_created_id` int(11) NOT NULL,
  `llv_usr_modified_id` int(11) default NULL,
  PRIMARY KEY  (`llv_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/log_level.sql 
INSERT INTO `prt_log_levels` (`llv_virgo_title`, `llv_name`, `llv_description`, `llv_display_order`, `llv_log_stack_trace`) 
VALUES (title, some_value, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_log_levels table already exists.", '', 'FATAL');
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
			return "llv";
		}
		
		static function getPlural() {
			return "log_levels";
		}
		
		static function isDictionary() {
			return true;
		}

		static function getParents() {
			$ret = array();
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoSystemMessage";
			$ret[] = "virgoChannelLevel";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_log_levels'));
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
			$virgoVersion = virgoLogLevel::getVirgoVersion();
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
	
	

