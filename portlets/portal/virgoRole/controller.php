<?php
/**
* Module Role
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
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUserRole'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPermission'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoRole {

		 var  $rle_id = null;
		 var  $rle_name = null;

		 var  $rle_description = null;

		 var  $rle_session_duration = null;

		 var  $rle_pge_id = null;

		 var   $_userIdsToAddArray = null;
		 var   $_userIdsToDeleteArray = null;
		 var   $rle_date_created = null;
		 var   $rle_usr_created_id = null;
		 var   $rle_date_modified = null;
		 var   $rle_usr_modified_id = null;
		 var   $rle_virgo_title = null;
		 var   $rle_virgo_deleted = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoRole();
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
        	$this->rle_id = null;
		    $this->rle_date_created = null;
		    $this->rle_usr_created_id = null;
		    $this->rle_date_modified = null;
		    $this->rle_usr_modified_id = null;
		    $this->rle_virgo_title = null;
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
			return $this->rle_id;
		}

		function getName() {
			return $this->rle_name;
		}
		
		 function setName($val) {
			$this->rle_name = $val;
		}
		function getDescription() {
			return $this->rle_description;
		}
		
		 function setDescription($val) {
			$this->rle_description = $val;
		}
		function getSessionDuration() {
			return $this->rle_session_duration;
		}
		
		 function setSessionDuration($val) {
			$this->rle_session_duration = $val;
		}

		function getPageId() {
			return $this->rle_pge_id;
		}
		
		 function setPageId($val) {
			$this->rle_pge_id = $val;
		}

		function getDateCreated() {
			return $this->rle_date_created;
		}
		function getUsrCreatedId() {
			return $this->rle_usr_created_id;
		}
		function getDateModified() {
			return $this->rle_date_modified;
		}
		function getUsrModifiedId() {
			return $this->rle_usr_modified_id;
		}


		function getPgeId() {
			return $this->getPageId();
		}
		
		 function setPgeId($val) {
			$this->setPageId($val);
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
			$this->rle_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('rle_name_' . $this->rle_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->rle_name = null;
		} else {
			$this->rle_name = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('rle_description_' . $this->rle_id);
	if (!is_null($tmpValue)) {
		if ($tmpValue == "") {
			$this->rle_description = null;
		} else {
			$this->rle_description = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('rle_sessionDuration_' . $this->rle_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->rle_session_duration = null;
		} else {
			$this->rle_session_duration = $tmpValue;
		}
	}
			$this->rle_pge_id = strval(R('rle_page_' . $this->rle_id));
			$tmp_ids = R('rle_userRole_' . $this->rle_id, null); 			if (is_null($tmp_ids)) {
				$tmp_ids = array();
			}
			if (is_array($tmp_ids)) { 
				$this->_userIdsToAddArray = $tmp_ids;
				$this->_userIdsToDeleteArray = array();
				$currentConnections = $this->getUserRoles();
				foreach ($currentConnections as $currentConnection) {
					if (in_array($currentConnection->getUserId(), $tmp_ids)) {
						foreach($this->_userIdsToAddArray as $key => $value) {
							if ($value == $currentConnection->getUserId()) {
								unset($this->_userIdsToAddArray[$key]);
							}
						}
						$this->_userIdsToAddArray = array_values($this->_userIdsToAddArray);
					} else {
						$this->_userIdsToDeleteArray[] = $currentConnection->getUserId();
					}
				}
			}
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('rle_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaRole = array();	
			$criteriaFieldRole = array();	
			$isNullRole = R('virgo_search_name_is_null');
			
			$criteriaFieldRole["is_null"] = 0;
			if ($isNullRole == "not_null") {
				$criteriaFieldRole["is_null"] = 1;
			} elseif ($isNullRole == "null") {
				$criteriaFieldRole["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_name');

//			if ($isSet) {
			$criteriaFieldRole["value"] = $dataTypeCriteria;
//			}
			$criteriaRole["name"] = $criteriaFieldRole;
			$criteriaFieldRole = array();	
			$isNullRole = R('virgo_search_description_is_null');
			
			$criteriaFieldRole["is_null"] = 0;
			if ($isNullRole == "not_null") {
				$criteriaFieldRole["is_null"] = 1;
			} elseif ($isNullRole == "null") {
				$criteriaFieldRole["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_description');

//			if ($isSet) {
			$criteriaFieldRole["value"] = $dataTypeCriteria;
//			}
			$criteriaRole["description"] = $criteriaFieldRole;
			$criteriaFieldRole = array();	
			$isNullRole = R('virgo_search_sessionDuration_is_null');
			
			$criteriaFieldRole["is_null"] = 0;
			if ($isNullRole == "not_null") {
				$criteriaFieldRole["is_null"] = 1;
			} elseif ($isNullRole == "null") {
				$criteriaFieldRole["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_sessionDuration_from');
		$dataTypeCriteria["to"] = R('virgo_search_sessionDuration_to');

//			if ($isSet) {
			$criteriaFieldRole["value"] = $dataTypeCriteria;
//			}
			$criteriaRole["session_duration"] = $criteriaFieldRole;
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
			$criteriaRole["page"] = $criteriaParent;
			$parent = R('virgo_search_user', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
				$criteriaRole["user"] = $criteriaParent;
			}
			self::setCriteria($criteriaRole);
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
			$tableFilter = R('virgo_filter_session_duration');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterSessionDuration', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterSessionDuration', null);
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
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseRole = ' 1 = 1 ';
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
				$eventColumn = "rle_" . P('event_column');
				$whereClauseRole = $whereClauseRole . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseRole = $whereClauseRole . ' AND ' . $parentContextInfo['condition'];
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
					$inCondition = " prt_roles.rle_pge_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_roles.rle_pge_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseRole = $whereClauseRole . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaRole = self::getCriteria();
			if (isset($criteriaRole["name"])) {
				$fieldCriteriaName = $criteriaRole["name"];
				if ($fieldCriteriaName["is_null"] == 1) {
$filter = $filter . ' AND prt_roles.rle_name IS NOT NULL ';
				} elseif ($fieldCriteriaName["is_null"] == 2) {
$filter = $filter . ' AND prt_roles.rle_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_roles.rle_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaRole["description"])) {
				$fieldCriteriaDescription = $criteriaRole["description"];
				if ($fieldCriteriaDescription["is_null"] == 1) {
$filter = $filter . ' AND prt_roles.rle_description IS NOT NULL ';
				} elseif ($fieldCriteriaDescription["is_null"] == 2) {
$filter = $filter . ' AND prt_roles.rle_description IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDescription["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_roles.rle_description like ? ";
				$types .= "s";
				$values[] = $condition;				
			}
				}
			}
			if (isset($criteriaRole["session_duration"])) {
				$fieldCriteriaSessionDuration = $criteriaRole["session_duration"];
				if ($fieldCriteriaSessionDuration["is_null"] == 1) {
$filter = $filter . ' AND prt_roles.rle_session_duration IS NOT NULL ';
				} elseif ($fieldCriteriaSessionDuration["is_null"] == 2) {
$filter = $filter . ' AND prt_roles.rle_session_duration IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaSessionDuration["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_roles.rle_session_duration = ? ";
				} else {
					$filter = $filter . " AND prt_roles.rle_session_duration >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_roles.rle_session_duration <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaRole["page"])) {
				$parentCriteria = $criteriaRole["page"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND rle_pge_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_roles.rle_pge_id IN (SELECT pge_id FROM prt_pages WHERE pge_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaRole["user"])) {
				$parentCriteria = $criteriaRole["user"];
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$filter = $filter . " AND prt_roles.rle_id IN (SELECT second_parent.url_rle_id FROM prt_user_roles AS second_parent WHERE second_parent.url_usr_id IN (" . implode(", ", $parentIds) . ")) ";
				}
			}
			$whereClauseRole = $whereClauseRole . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseRole = $whereClauseRole . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseRole = $whereClauseRole . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterName', null);
				if (S($tableFilter)) {
					$whereClauseRole = $whereClauseRole . " AND rle_name LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterDescription', null);
				if (S($tableFilter)) {
					$whereClauseRole = $whereClauseRole . " AND rle_description LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterSessionDuration', null);
				if (S($tableFilter)) {
					$whereClauseRole = $whereClauseRole . " AND rle_session_duration LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterPage', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseRole = $whereClauseRole . " AND rle_pge_id IS NULL ";
					} else {
						$whereClauseRole = $whereClauseRole . " AND rle_pge_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitlePage', null);
				if (S($parentFilter)) {
					$whereClauseRole = $whereClauseRole . " AND prt_pages_parent.pge_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClauseRole;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseRole = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_roles.rle_id, prt_roles.rle_virgo_title ";
			$queryString = $queryString . " ,prt_roles.rle_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_name', "1") != "0") {
				$queryString = $queryString . ", prt_roles.rle_name rle_name";
			} else {
				if ($defaultOrderColumn == "rle_name") {
					$orderColumnNotDisplayed = " prt_roles.rle_name ";
				}
			}
			if (P('show_table_description', "1") != "0") {
				$queryString = $queryString . ", prt_roles.rle_description rle_description";
			} else {
				if ($defaultOrderColumn == "rle_description") {
					$orderColumnNotDisplayed = " prt_roles.rle_description ";
				}
			}
			if (P('show_table_session_duration', "1") != "0") {
				$queryString = $queryString . ", prt_roles.rle_session_duration rle_session_duration";
			} else {
				if ($defaultOrderColumn == "rle_session_duration") {
					$orderColumnNotDisplayed = " prt_roles.rle_session_duration ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_table_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_roles.rle_pge_id as rle_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_roles ";
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_roles.rle_pge_id = prt_pages_parent.pge_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseRole = $whereClauseRole . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseRole, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseRole,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_roles"
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
				. "\n FROM prt_roles"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_roles ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_roles ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, rle_id $orderMode";
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
				$query = "SELECT COUNT(rle_id) cnt FROM roles";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as roles ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as roles ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoRole();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_roles WHERE rle_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->rle_id = $row['rle_id'];
$this->rle_name = $row['rle_name'];
$this->rle_description = $row['rle_description'];
$this->rle_session_duration = $row['rle_session_duration'];
						$this->rle_pge_id = $row['rle_pge_id'];
						if ($fetchUsernames) {
							if ($row['rle_date_created']) {
								if ($row['rle_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['rle_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['rle_date_modified']) {
								if ($row['rle_usr_modified_id'] == $row['rle_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['rle_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['rle_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->rle_date_created = $row['rle_date_created'];
						$this->rle_usr_created_id = $fetchUsernames ? $createdBy : $row['rle_usr_created_id'];
						$this->rle_date_modified = $row['rle_date_modified'];
						$this->rle_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['rle_usr_modified_id'];
						$this->rle_virgo_title = $row['rle_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_roles SET rle_usr_created_id = {$userId} WHERE rle_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->rle_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoRole::selectAllAsObjectsStatic('rle_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->rle_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->rle_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('rle_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_rle = new virgoRole();
				$tmp_rle->load((int)$lookup_id);
				return $tmp_rle->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoRole');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" rle_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoRole', "10");
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
				$query = $query . " rle_id as id, rle_virgo_title as title ";
			}
			$query = $query . " FROM prt_roles ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			$query = $query . $tmpQuery;
			$query = $query . " AND (rle_virgo_deleted IS NULL OR rle_virgo_deleted = 0) ";
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY rle_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resRole = array();
				foreach ($rows as $row) {
					$resRole[$row['id']] = $row['title'];
				}
				return $resRole;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticRole = new virgoRole();
			return $staticRole->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getPageStatic($parentId) {
			return virgoPage::getById($parentId);
		}
		
		function getPage() {
			return virgoRole::getPageStatic($this->rle_pge_id);
		}

		static function getUserRolesStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resUserRole = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUserRole'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resUserRole;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resUserRole;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsUserRole = virgoUserRole::selectAll('url_rle_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsUserRole as $resultUserRole) {
				$tmpUserRole = virgoUserRole::getById($resultUserRole['url_id']); 
				array_push($resUserRole, $tmpUserRole);
			}
			return $resUserRole;
		}

		function getUserRoles($orderBy = '', $extraWhere = null) {
			return virgoRole::getUserRolesStatic($this->getId(), $orderBy, $extraWhere);
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
			$resultsPermission = virgoPermission::selectAll('prm_rle_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPermission as $resultPermission) {
				$tmpPermission = virgoPermission::getById($resultPermission['prm_id']); 
				array_push($resPermission, $tmpPermission);
			}
			return $resPermission;
		}

		function getPermissions($orderBy = '', $extraWhere = null) {
			return virgoRole::getPermissionsStatic($this->getId(), $orderBy, $extraWhere);
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
			if (P('show_'.$tmpMode.'_session_duration_obligatory', "0") == "1") {
				if (
(is_null($this->getSessionDuration()) || trim($this->getSessionDuration()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'SESSION_DURATION');
				}			
			}
			$tmpMode = (is_null($this->getId()) ? "create" : "form");
			if (P('show_'.$tmpMode.'_page_obligatory', "0") == "1") {
				if (is_null($this->rle_pge_id) || trim($this->rle_pge_id) == "") {
					if (R('create_rle_page_' . $this->rle_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'PAGE', '');
					}
				}
			}			
 			if (!is_null($this->rle_session_duration) && trim($this->rle_session_duration) != "") {
				if (!is_numeric($this->rle_session_duration)) {
					return T('INCORRECT_NUMBER', 'SESSION_DURATION', $this->rle_session_duration);
				}
			}
		$types = "";
		$values = array();
		$skipUniquenessCheck = false;
		$uniqnessWhere = " 1 = 1 ";
		if (!is_null($this->rle_id) && $this->rle_id != 0) {
			$uniqnessWhere = " rle_id != " . $this->rle_id . " ";			
		}
 		if (!$skipUniquenessCheck) {
 			if (!$skipUniquenessCheck) {
			$uniqnessWhere = $uniqnessWhere . ' AND UPPER(rle_name) = UPPER(?) ';
			$types .= "s";
			$values[] = $this->rle_name;
			}
 		}	
 		if (!$skipUniquenessCheck) {	
			$query = " SELECT COUNT(*) FROM prt_roles ";
			$query = $query . " WHERE " . $uniqnessWhere;
			$result = QPL($query, $types, $values);
			if ($result[0] > 0) {
				$valeus = array();
				$colNames = array();
				$colNames[] = T('NAME');
				$values[] = $this->rle_name; 
				return T('UNIQNESS_FAILED', 'ROLE', implode(', ', $colNames), implode(', ', $values));
			}
		}
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_roles WHERE rle_id = " . $this->getId();
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
				$colNames = $colNames . ", rle_name";
				$values = $values . ", " . (is_null($objectToStore->getName()) ? "null" : "'" . QE($objectToStore->getName()) . "'");
				$colNames = $colNames . ", rle_description";
				$values = $values . ", " . (is_null($objectToStore->getDescription()) ? "null" : "'" . QE($objectToStore->getDescription()) . "'");
				$colNames = $colNames . ", rle_session_duration";
				$values = $values . ", " . (is_null($objectToStore->getSessionDuration()) ? "null" : "'" . QE($objectToStore->getSessionDuration()) . "'");
				$colNames = $colNames . ", rle_pge_id";
				$values = $values . ", " . (is_null($objectToStore->getPgeId()) || $objectToStore->getPgeId() == "" ? "null" : $objectToStore->getPgeId());
				$query = "INSERT INTO prt_history_roles (revision, ip, username, user_id, timestamp, rle_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
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
				$colNames = $colNames . ", rle_name";
				$values = $values . ", " . (is_null($objectToStore->getName()) ? "null" : "'" . QE($objectToStore->getName()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getDescription() != $objectToStore->getDescription()) {
				if (is_null($objectToStore->getDescription())) {
					$nullifiedProperties = $nullifiedProperties . "description,";
				} else {
				$colNames = $colNames . ", rle_description";
				$values = $values . ", " . (is_null($objectToStore->getDescription()) ? "null" : "'" . QE($objectToStore->getDescription()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getSessionDuration() != $objectToStore->getSessionDuration()) {
				if (is_null($objectToStore->getSessionDuration())) {
					$nullifiedProperties = $nullifiedProperties . "session_duration,";
				} else {
				$colNames = $colNames . ", rle_session_duration";
				$values = $values . ", " . (is_null($objectToStore->getSessionDuration()) ? "null" : "'" . QE($objectToStore->getSessionDuration()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getPgeId() != $objectToStore->getPgeId() && ($virgoOld->getPgeId() != 0 || $objectToStore->getPgeId() != ""))) { 
				$colNames = $colNames . ", rle_pge_id";
				$values = $values . ", " . (is_null($objectToStore->getPgeId()) ? "null" : ($objectToStore->getPgeId() == "" ? "0" : $objectToStore->getPgeId()));
			}
			$query = "INSERT INTO prt_history_roles (revision, ip, username, user_id, timestamp, rle_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_roles");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'rle_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_roles ADD COLUMN (rle_virgo_title VARCHAR(255));";
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
			if (isset($this->rle_id) && $this->rle_id != "") {
				$query = "UPDATE prt_roles SET ";
			if (isset($this->rle_name)) {
				$query .= " rle_name = ? ,";
				$types .= "s";
				$values[] = $this->rle_name;
			} else {
				$query .= " rle_name = NULL ,";				
			}
			if (isset($this->rle_description)) {
				$query .= " rle_description = ? ,";
				$types .= "s";
				$values[] = $this->rle_description;
			} else {
				$query .= " rle_description = NULL ,";				
			}
			if (isset($this->rle_session_duration)) {
				$query .= " rle_session_duration = ? ,";
				$types .= "i";
				$values[] = $this->rle_session_duration;
			} else {
				$query .= " rle_session_duration = NULL ,";				
			}
				if (isset($this->rle_pge_id) && trim($this->rle_pge_id) != "") {
					$query = $query . " rle_pge_id = ? , ";
					$types = $types . "i";
					$values[] = $this->rle_pge_id;
				} else {
					$query = $query . " rle_pge_id = NULL, ";
				}
				if (isset($this->rle_virgo_deleted)) {
					$query = $query . " rle_virgo_deleted = ? , ";
					$types = $types . "i";
					$values[] = $this->rle_virgo_deleted;
				} else {
					$query = $query . " rle_virgo_deleted = NULL , ";
				}
				$query = $query . " rle_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " rle_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->rle_date_modified;

				$query = $query . " rle_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->rle_usr_modified_id;

				$query = $query . " WHERE rle_id = ? ";
				$types = $types . "i";
				$values[] = $this->rle_id;
			} else {
				$query = "INSERT INTO prt_roles ( ";
			$query = $query . " rle_name, ";
			$query = $query . " rle_description, ";
			$query = $query . " rle_session_duration, ";
				$query = $query . " rle_pge_id, ";
				$query = $query . " rle_virgo_title, rle_date_created, rle_usr_created_id) VALUES ( ";
			if (isset($this->rle_name)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->rle_name;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->rle_description)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->rle_description;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->rle_session_duration)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->rle_session_duration;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->rle_pge_id) && trim($this->rle_pge_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->rle_pge_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->rle_date_created;
				$values[] = $this->rle_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->rle_id) || $this->rle_id == "") {
					$this->rle_id = QID();
				}
				if ($log) {
					L("role stored successfully", "id = {$this->rle_id}", "TRACE");
				}
				return true;
			}
		}
		

		static function addUserStatic($thisId, $id) {
			$query = " SELECT COUNT(url_id) AS cnt FROM prt_user_roles WHERE url_rle_id = {$thisId} AND url_usr_id = {$id} ";
			$res = Q1($query);
			if ($res == 0) {
				$newUserRole = new virgoUserRole();
				$newUserRole->setUserId($id);
				$newUserRole->setRoleId($thisId);
				return $newUserRole->store();
			}			
			return "";
		}
		
		function addUser($id) {
			return virgoRole::addUserStatic($this->getId(), $id);
		}
		
		static function removeUserStatic($thisId, $id) {
			$query = " SELECT url_id AS id FROM prt_user_roles WHERE url_rle_id = {$thisId} AND url_usr_id = {$id} ";
			$res = QR($query);
			foreach ($res as $re) {
				$newUserRole = new virgoUserRole($re['id']);
				return $newUserRole->delete();
			}			
			return "";
		}
		
		function removeUser($id) {
			return virgoRole::removeUserStatic($this->getId(), $id);
		}
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->rle_id) {
				$virgoOld = new virgoRole($this->rle_id);
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
					if ($this->rle_id) {			
						$this->rle_date_modified = date("Y-m-d H:i:s");
						$this->rle_usr_modified_id = $userId;
					} else {
						$this->rle_date_created = date("Y-m-d H:i:s");
						$this->rle_usr_created_id = $userId;
					}
					$this->rle_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "role" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "role" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
						}
					}
					if (!is_null($this->_userIdsToAddArray)) {
						foreach ($this->_userIdsToAddArray as $userId) {
							$ret = $this->addUser((int)$userId);
							if ($ret != "") {
								L($ret, '', 'ERROR');
							}
						}
					}
					if (!is_null($this->_userIdsToDeleteArray)) {
						foreach ($this->_userIdsToDeleteArray as $userId) {
							$ret = $this->removeUser((int)$userId);
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
			$query = "DELETE FROM prt_roles WHERE rle_id = {$this->rle_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			self::removeFromContext();
			$this->rle_virgo_deleted = true;
			$this->rle_date_modified = date("Y-m-d H:i:s");
			$userId = virgoUser::getUserId();
			$this->rle_usr_modified_id = $userId;
			$this->parentStore(true);
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoRole();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT rle_id as id FROM prt_roles";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'rle_order_column')) {
				$orderBy = " ORDER BY rle_order_column ASC ";
			} 
			if (property_exists($this, 'rle_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY rle_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoRole();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoRole($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_roles SET rle_virgo_title = '$title' WHERE rle_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getByNameStatic($token) {
			$tmpStatic = new virgoRole();
			$tmpId = $tmpStatic->getIdByName($token);
			$tmpStatic->load($tmpId);
			return $tmpStatic;
		}
		
		static function getIdByNameStatic($token) {
			$tmpStatic = new virgoRole();
			return $tmpStatic->getIdByName($token);
		}
		
		function getIdByName($token) {
			$res = $this->selectAll(" rle_name = ?", "", "s", array($token));
			foreach ($res as $r) {
				return $r['rle_id'];
			}
			return null;
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoRole();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" rle_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['rle_id'];
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
			virgoRole::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoRole::setSessionValue('Portal_Role-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoRole::getSessionValue('Portal_Role-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoRole::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoRole::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoRole::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoRole::getSessionValue('GLOBAL', $name, $default);
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
			$context['rle_id'] = $id;
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
			$context['rle_id'] = null;
			virgoRole::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoRole::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoRole::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoRole::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoRole::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoRole::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoRole::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoRole::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoRole::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoRole::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoRole::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoRole::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoRole::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoRole::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoRole::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoRole::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoRole::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "rle_id";
			}
			return virgoRole::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoRole::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoRole::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoRole::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoRole::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoRole::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoRole::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoRole::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoRole::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoRole::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoRole::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoRole::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoRole::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->rle_id) {
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
						L(T('STORED_CORRECTLY', 'ROLE'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'name', $this->rle_name);
						$fieldValues = $fieldValues . T($fieldValue, 'description', $this->rle_description);
						$fieldValues = $fieldValues . T($fieldValue, 'session duration', $this->rle_session_duration);
						$parentPage = new virgoPage();
						$fieldValues = $fieldValues . T($fieldValue, 'page', $parentPage->lookup($this->rle_pge_id));
						$username = '';
						if ($this->rle_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->rle_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->rle_date_created);
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
			$instance = new virgoRole();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoRole'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
				$resIds = $tmpPermission->select(null, 'all', null, null, ' prm_rle_id = ' . $instance->getId(), ' SELECT prm_id FROM prt_permissions ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->prm_id;
//					JRequest::setVar('prm_role_' . $resId->prm_id, $this->getId());
				} 
//				JRequest::setVar('prm_role_', $instance->getId());
				$tmpPermission->setRecordSet($resIdsString);
				if (!$tmpPermission->portletActionStoreSelected()) {
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
			$tmpId = intval(R('rle_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoRole::getContextId();
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
			$this->rle_id = null;
			$this->rle_date_created = null;
			$this->rle_usr_created_id = null;
			$this->rle_date_modified = null;
			$this->rle_usr_modified_id = null;
			$this->rle_virgo_title = null;
			$this->rle_virgo_deleted = null;
			
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


		static function portletActionAdd() {
			$portletObject = self::getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("add")) {
			self::removeFromContext();
			self::setDisplayMode("CREATE");
//			$ret = new virgoRole();
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
				$instance = new virgoRole();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoRole::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'ROLE'), '', 'INFO');
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
				$resultRole = new virgoRole();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultRole->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultRole->load($idToEditInt);
					} else {
						$resultRole->rle_id = 0;
					}
				}
				$results[] = $resultRole;
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
				$result = new virgoRole();
				$result->loadFromRequest($idToStore);
				if ($result->rle_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->rle_id == 0) {
						$result->rle_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->rle_id)) {
							$result->rle_id = 0;
						}
						$idsToCorrect[$result->rle_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'ROLES'), '', 'INFO');
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
			$resultRole = new virgoRole();
			foreach ($idsToDelete as $idToDelete) {
				$resultRole->load((int)trim($idToDelete));
				$res = $resultRole->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'ROLES'), '', 'INFO');			
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
		$ret = $this->rle_name;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoRole');
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
				$query = "UPDATE prt_roles SET rle_virgo_title = ? WHERE rle_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT rle_id AS id FROM prt_roles ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoRole($row['id']);
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
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'prt_roles.rle_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_roles.rle_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_roles.rle_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_roles.rle_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoRole!', '', 'ERROR');
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
			$pdf->SetTitle('Roles report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('ROLES');
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
			if (P('show_pdf_session_duration', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_page', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultRole = new virgoRole();
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
			if (P('show_pdf_session_duration', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Session duration');
				$minWidth['session duration'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['session duration']) {
						$minWidth['session duration'] = min($tmpLen, $maxWidth);
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
			$pdf->SetFont($font, '', $fontSize);
			$pdf->AliasNbPages();
			$orientation = P('pdf_page_orientation', 'P');
			$pdf->AddPage($orientation);
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 4);
			$pdf->MultiCell(0, 1, $reportTitle, '', 'C', 0, 0);
			$pdf->Ln();
			$whereClauseRole = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseRole = $whereClauseRole . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaRole = $resultRole->getCriteria();
			$fieldCriteriaName = $criteriaRole["name"];
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
			$fieldCriteriaDescription = $criteriaRole["description"];
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
			$fieldCriteriaSessionDuration = $criteriaRole["session_duration"];
			if ($fieldCriteriaSessionDuration["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Session duration', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaSessionDuration["value"];
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
					$pdf->MultiCell(60, 100, 'Session duration', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaRole["page"];
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
					$inCondition = " prt_roles.rle_pge_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_roles.rle_pge_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseRole = $whereClauseRole . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaRole = self::getCriteria();
			if (isset($criteriaRole["name"])) {
				$fieldCriteriaName = $criteriaRole["name"];
				if ($fieldCriteriaName["is_null"] == 1) {
$filter = $filter . ' AND prt_roles.rle_name IS NOT NULL ';
				} elseif ($fieldCriteriaName["is_null"] == 2) {
$filter = $filter . ' AND prt_roles.rle_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_roles.rle_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaRole["description"])) {
				$fieldCriteriaDescription = $criteriaRole["description"];
				if ($fieldCriteriaDescription["is_null"] == 1) {
$filter = $filter . ' AND prt_roles.rle_description IS NOT NULL ';
				} elseif ($fieldCriteriaDescription["is_null"] == 2) {
$filter = $filter . ' AND prt_roles.rle_description IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDescription["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_roles.rle_description like ? ";
				$types .= "s";
				$values[] = $condition;				
			}
				}
			}
			if (isset($criteriaRole["session_duration"])) {
				$fieldCriteriaSessionDuration = $criteriaRole["session_duration"];
				if ($fieldCriteriaSessionDuration["is_null"] == 1) {
$filter = $filter . ' AND prt_roles.rle_session_duration IS NOT NULL ';
				} elseif ($fieldCriteriaSessionDuration["is_null"] == 2) {
$filter = $filter . ' AND prt_roles.rle_session_duration IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaSessionDuration["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_roles.rle_session_duration = ? ";
				} else {
					$filter = $filter . " AND prt_roles.rle_session_duration >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_roles.rle_session_duration <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaRole["page"])) {
				$parentCriteria = $criteriaRole["page"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND rle_pge_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_roles.rle_pge_id IN (SELECT pge_id FROM prt_pages WHERE pge_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaRole["user"])) {
				$parentCriteria = $criteriaRole["user"];
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$filter = $filter . " AND prt_roles.rle_id IN (SELECT second_parent.url_rle_id FROM prt_user_roles AS second_parent WHERE second_parent.url_usr_id IN (" . implode(", ", $parentIds) . ")) ";
				}
			}
			$whereClauseRole = $whereClauseRole . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseRole = $whereClauseRole . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_roles.rle_id, prt_roles.rle_virgo_title ";
			$queryString = $queryString . " ,prt_roles.rle_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_name', "1") != "0") {
				$queryString = $queryString . ", prt_roles.rle_name rle_name";
			} else {
				if ($defaultOrderColumn == "rle_name") {
					$orderColumnNotDisplayed = " prt_roles.rle_name ";
				}
			}
			if (P('show_pdf_description', "1") != "0") {
				$queryString = $queryString . ", prt_roles.rle_description rle_description";
			} else {
				if ($defaultOrderColumn == "rle_description") {
					$orderColumnNotDisplayed = " prt_roles.rle_description ";
				}
			}
			if (P('show_pdf_session_duration', "1") != "0") {
				$queryString = $queryString . ", prt_roles.rle_session_duration rle_session_duration";
			} else {
				if ($defaultOrderColumn == "rle_session_duration") {
					$orderColumnNotDisplayed = " prt_roles.rle_session_duration ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_pdf_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_roles.rle_pge_id as rle_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_roles ";
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_roles.rle_pge_id = prt_pages_parent.pge_id) ";
			}

		$resultsRole = $resultRole->select(
			'', 
			'all', 
			$resultRole->getOrderColumn(), 
			$resultRole->getOrderMode(), 
			$whereClauseRole,
			$queryString);
		
		foreach ($resultsRole as $resultRole) {

			if (P('show_pdf_name', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultRole['rle_name'])) + 6;
				if ($tmpLen > $minWidth['name']) {
					$minWidth['name'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_description', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultRole['rle_description'])) + 6;
				if ($tmpLen > $minWidth['description']) {
					$minWidth['description'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_session_duration', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultRole['rle_session_duration'])) + 6;
				if ($tmpLen > $minWidth['session duration']) {
					$minWidth['session duration'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_page', "1") == "1") {
			$parentValue = trim(virgoPage::lookup($resultRole['rlepge__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['page $relation.name']) {
					$minWidth['page $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaRole = $resultRole->getCriteria();
		if (is_null($criteriaRole) || sizeof($criteriaRole) == 0 || $countTmp == 0) {
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
			if (P('show_pdf_session_duration', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['session duration'], $colHeight, T('SESSION_DURATION'), 'T', 'C', 0, 0);
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
		foreach ($resultsRole as $resultRole) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_name', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['name'], $colHeight, '' . $resultRole['rle_name'], 'T', 'L', 0, 0);
				if (P('show_pdf_name', "1") == "2") {
										if (!is_null($resultRole['rle_name'])) {
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
										if (!is_null($resultRole['rle_name'])) {
						$tmpSum = (float)$sums["name"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRole['rle_name'];
						}
						$sums["name"] = $tmpSum;
					}
				}
				if (P('show_pdf_name', "1") == "4") {
										if (!is_null($resultRole['rle_name'])) {
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
							$tmpSum = $tmpSum + $resultRole['rle_name'];
						}
						$avgSums["name"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_description', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['description'], $colHeight, '' . $resultRole['rle_description'], 'T', 'L', 0, 0);
				if (P('show_pdf_description', "1") == "2") {
										if (!is_null($resultRole['rle_description'])) {
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
										if (!is_null($resultRole['rle_description'])) {
						$tmpSum = (float)$sums["description"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRole['rle_description'];
						}
						$sums["description"] = $tmpSum;
					}
				}
				if (P('show_pdf_description', "1") == "4") {
										if (!is_null($resultRole['rle_description'])) {
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
							$tmpSum = $tmpSum + $resultRole['rle_description'];
						}
						$avgSums["description"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_session_duration', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['session duration'], $colHeight, '' . $resultRole['rle_session_duration'], 'T', 'R', 0, 0);
				if (P('show_pdf_session_duration', "1") == "2") {
										if (!is_null($resultRole['rle_session_duration'])) {
						$tmpCount = (float)$counts["session_duration"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["session_duration"] = $tmpCount;
					}
				}
				if (P('show_pdf_session_duration', "1") == "3") {
										if (!is_null($resultRole['rle_session_duration'])) {
						$tmpSum = (float)$sums["session_duration"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRole['rle_session_duration'];
						}
						$sums["session_duration"] = $tmpSum;
					}
				}
				if (P('show_pdf_session_duration', "1") == "4") {
										if (!is_null($resultRole['rle_session_duration'])) {
						$tmpCount = (float)$avgCounts["session_duration"];
						$tmpSum = (float)$avgSums["session_duration"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["session_duration"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRole['rle_session_duration'];
						}
						$avgSums["session_duration"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_page', "1") == "1") {
			$parentValue = virgoPage::lookup($resultRole['rle_pge_id']);
			$tmpLn = $pdf->MultiCell($minWidth['page $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
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
			if (P('show_pdf_session_duration', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['session duration'];
				if (P('show_pdf_session_duration', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["session_duration"];
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
			if (P('show_pdf_session_duration', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['session duration'];
				if (P('show_pdf_session_duration', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["session_duration"], 2, ',', ' ');
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
			if (P('show_pdf_session_duration', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['session duration'];
				if (P('show_pdf_session_duration', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["session_duration"] == 0 ? "-" : $avgSums["session_duration"] / $avgCounts["session_duration"]);
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
				$reportTitle = T('ROLES');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultRole = new virgoRole();
			$whereClauseRole = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseRole = $whereClauseRole . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_name', "1") != "0") {
					$data = $data . $stringDelimeter .'Name' . $stringDelimeter . $separator;
				}
				if (P('show_export_description', "1") != "0") {
					$data = $data . $stringDelimeter .'Description' . $stringDelimeter . $separator;
				}
				if (P('show_export_session_duration', "1") != "0") {
					$data = $data . $stringDelimeter .'Session duration' . $stringDelimeter . $separator;
				}
				if (P('show_export_page', "1") != "0") {
					$data = $data . $stringDelimeter . 'Page ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_roles.rle_id, prt_roles.rle_virgo_title ";
			$queryString = $queryString . " ,prt_roles.rle_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_name', "1") != "0") {
				$queryString = $queryString . ", prt_roles.rle_name rle_name";
			} else {
				if ($defaultOrderColumn == "rle_name") {
					$orderColumnNotDisplayed = " prt_roles.rle_name ";
				}
			}
			if (P('show_export_description', "1") != "0") {
				$queryString = $queryString . ", prt_roles.rle_description rle_description";
			} else {
				if ($defaultOrderColumn == "rle_description") {
					$orderColumnNotDisplayed = " prt_roles.rle_description ";
				}
			}
			if (P('show_export_session_duration', "1") != "0") {
				$queryString = $queryString . ", prt_roles.rle_session_duration rle_session_duration";
			} else {
				if ($defaultOrderColumn == "rle_session_duration") {
					$orderColumnNotDisplayed = " prt_roles.rle_session_duration ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_export_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_roles.rle_pge_id as rle_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_roles ";
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_roles.rle_pge_id = prt_pages_parent.pge_id) ";
			}

			$resultsRole = $resultRole->select(
				'', 
				'all', 
				$resultRole->getOrderColumn(), 
				$resultRole->getOrderMode(), 
				$whereClauseRole,
				$queryString);
			foreach ($resultsRole as $resultRole) {
				if (P('show_export_name', "1") != "0") {
			$data = $data . $stringDelimeter . $resultRole['rle_name'] . $stringDelimeter . $separator;
				}
				if (P('show_export_description', "1") != "0") {
			$data = $data . $stringDelimeter . $resultRole['rle_description'] . $stringDelimeter . $separator;
				}
				if (P('show_export_session_duration', "1") != "0") {
			$data = $data . $resultRole['rle_session_duration'] . $separator;
				}
				if (P('show_export_page', "1") != "0") {
					$parentValue = virgoPage::lookup($resultRole['rle_pge_id']);
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
				$reportTitle = T('ROLES');
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
			$resultRole = new virgoRole();
			$whereClauseRole = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseRole = $whereClauseRole . ' AND ' . $parentContextInfo['condition'];
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
				if (P('show_export_session_duration', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Session duration');
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
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_roles.rle_id, prt_roles.rle_virgo_title ";
			$queryString = $queryString . " ,prt_roles.rle_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_name', "1") != "0") {
				$queryString = $queryString . ", prt_roles.rle_name rle_name";
			} else {
				if ($defaultOrderColumn == "rle_name") {
					$orderColumnNotDisplayed = " prt_roles.rle_name ";
				}
			}
			if (P('show_export_description', "1") != "0") {
				$queryString = $queryString . ", prt_roles.rle_description rle_description";
			} else {
				if ($defaultOrderColumn == "rle_description") {
					$orderColumnNotDisplayed = " prt_roles.rle_description ";
				}
			}
			if (P('show_export_session_duration', "1") != "0") {
				$queryString = $queryString . ", prt_roles.rle_session_duration rle_session_duration";
			} else {
				if ($defaultOrderColumn == "rle_session_duration") {
					$orderColumnNotDisplayed = " prt_roles.rle_session_duration ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_export_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_roles.rle_pge_id as rle_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_roles ";
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_roles.rle_pge_id = prt_pages_parent.pge_id) ";
			}

			$resultsRole = $resultRole->select(
				'', 
				'all', 
				$resultRole->getOrderColumn(), 
				$resultRole->getOrderMode(), 
				$whereClauseRole,
				$queryString);
			$index = 1;
			foreach ($resultsRole as $resultRole) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultRole['rle_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_name', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultRole['rle_name'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_description', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultRole['rle_description'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_session_duration', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultRole['rle_session_duration'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_page', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoPage::lookup($resultRole['rle_pge_id']);
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
					$propertyColumnHash['name'] = 'rle_name';
					$propertyColumnHash['name'] = 'rle_name';
					$propertyColumnHash['description'] = 'rle_description';
					$propertyColumnHash['description'] = 'rle_description';
					$propertyColumnHash['session duration'] = 'rle_session_duration';
					$propertyColumnHash['session_duration'] = 'rle_session_duration';
					$propertyClassHash['page'] = 'Page';
					$propertyClassHash['page'] = 'Page';
					$propertyColumnHash['page'] = 'rle_pge_id';
					$propertyColumnHash['page'] = 'rle_pge_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importRole = new virgoRole();
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
										L(T('PROPERTY_NOT_FOUND', T('ROLE'), $columns[$index]), '', 'ERROR');
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
										$importRole->$fieldName = $value;
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
	$importRole->setPgeId($defaultValue);
}
							$errorMessage = $importRole->store();
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
		


		static function portletActionAddSelectedToNMRecordUser() {
			$userId = R('url_user_');
			$idsToDeleteString = R('ids');
			$idsToDelete = split(",", $idsToDeleteString);
			foreach ($idsToDelete as $idToDelete) {
				$newUserRole = new virgoUserRole();
				$newUserRole->setRleId($idToDelete);
				$newUserRole->setUsrId($userId);
				$errorMessage = $newUserRole->store();
				if ($errorMessage != "") {
					L($errorMessage, '', 'ERROR');
					return -1;
				}

			}
			self::setDisplayMode("TABLE");
			return 0;
		}


		static function portletActionVirgoSetPage() {
			$this->loadFromDB();
			$parentId = R('rle_Page_id_' . $_SESSION['current_portlet_object_id']);
			$this->setPgeId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}


		static function can($page, $portletObjectId, $action, $actionToExecute = null) {
			$rleId = virgoUser::getCurrentRole();
			if (isset($page)) {
				$objectCondition = " prm_pge_id = ? ";				
				$portal = $page->getPortal();
				$pageType = "i";
				$pageValue = array($page->getId());
			} else {
				$pageType = "";
				$pageValue = array();				
			}
			if (isset($portletObjectId)) {
				$cache = $_SESSION['cache'];
				$cacheElementName = 'permission_' . $portletObjectId . '_' . $action . '_' . $actionToExecute;
				if (isset($cache[$cacheElementName])) {
					return $cache[$cacheElementName] == "T";
				}
				$objectCondition = " prm_pob_id = ? ";				
				$pobType = "i";
				$pobValue = array($portletObjectId);
				$currentPage = virgoPage::getCurrentPage();
				$portal = $currentPage->getPortal();
			} else {
				$pobType = "";
				$pobValue = array();				
			}
			if (isset($actionToExecute)) {
				$action = "execute";
				$actionType = "s";
				$actionValue = array($actionToExecute);
				$actionToExecuteCondition = " AND prm_action = ? ";
			} else {
				$actionToExecuteCondition = " AND prm_action IS NULL ";
				$actionType = "";
				$actionValue = array();
			}
			$query = <<<SQL
SELECT 
  prm_{$action} AS action
FROM 
  prt_permissions 
WHERE 
  prm_rle_id = ?
  AND {$objectCondition}
  {$actionToExecuteCondition}
SQL;
			$rows = QPR($query, "i".$pageType.$pobType.$actionType, array_merge(array($rleId), $pageValue, $pobValue, $actionValue));
			$can = null;
			if (count($rows) == 0) {
				$can = ($portal->getTolerantAccessPolicy() == 1);
			} else {
				$row = $rows[0];
				$perm = $row['action'];
				if (is_null($perm)) {
					$can = ($portal->getTolerantAccessPolicy() == 1);
				} else {
					$can = $perm;
				}
			}
			if (isset($portletObjectId)) {
				$cache[$cacheElementName] = ($can ? "T" : "F");
				$_SESSION['cache'] = $cache;
			}
			return $can;
		}
		
		static function canExecute($portletObjectId, $action) {
			return virgoRole::can(null, $portletObjectId, null, $action);
		}
		
		static function getVisiblePages($rootPageId = null) {
			$page = virgoPage::getCurrentPage();
			$portal = $page->getPortal();
			$rootPageCheck = (isset($rootPageId) ? " = ? " : " IS NULL ");
			$rootType = (isset($rootPageId) ? "i" : "");
			$rootValue = (isset($rootPageId) ? array($rootPageId) : array());
			$query = <<<SQL
SELECT 
	pge_id
FROM 
	prt_pages
WHERE
	pge_pge_id {$rootPageCheck}
	AND pge_prt_id = ?
ORDER BY 
	pge_order ASC
SQL;
			$rows = QPR($query, $rootType."i", array_merge($rootValue, array($portal->getId())));
			$ret = array();
			foreach ($rows as $row) {
				$page = new virgoPage($row['pge_id']);
				if (virgoRole::can($page, null, 'view')) {
					$ret[] = $page;
				}
			}
			return $ret;
		}
		
		static function grantRoleToUserId($roleName, $userId) {
			$role = virgoRole::getByNameStatic($roleName);
			return $role->grantToUserId($userId);
		}
		
		function grantToUserId($userId) {
			$userRole = new virgoUserRole();
			$userRole->setRoleId($this->getId());
			$userRole->setUserId($userId);
			return $userRole->store(false);
		}

		static function userHasRoleObject($userId, $role) {
			$userRoles = $role->getUserRoles();
			foreach ($userRoles as $userRole) {
				if ($userRole->getUser()->getId() == $userId) {
					return true;
				}
			}
			return false;
		}
		
		static function hasRoleObject($role) {
			$userId = virgoUser::getUserId();
			return virgoRole::userHasRoleObject($userId, $role);
		}
				
		static function hasRoleId($roleId) {
			$role = new virgoRole($roleId);
			return virgoRole::hasRoleObject($role);
		}

		static function hasRole($roleName) {
			$role = virgoRole::getByNameStatic($roleName);
			return virgoRole::hasRoleObject($role);
		}

		static function getExtraActions($type) {
			$pobId = $_SESSION['current_portlet_object_id'];
			$rleId = virgoUser::getCurrentRole();
			if (isset($rleId)) {
				$query = <<<SQL
SELECT prm_action action
FROM prt_permissions
WHERE prm_action LIKE ?
AND prm_execute = 1
AND prm_rle_id = ?
AND prm_pob_id = ?
SQL;
				return QPL($query, "sii", array("\_{$type}A%", $rleId, $pobId));
			}
			return array();
		}


		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `prt_roles` (
  `rle_id` bigint(20) unsigned NOT NULL auto_increment,
  `rle_virgo_state` varchar(50) default NULL,
  `rle_virgo_title` varchar(255) default NULL,
  `rle_virgo_deleted` boolean,
	`rle_pge_id` int(11) default NULL,
  `rle_name` varchar(255), 
  `rle_description` longtext, 
  `rle_session_duration` integer,  
  `rle_date_created` datetime NOT NULL,
  `rle_date_modified` datetime default NULL,
  `rle_usr_created_id` int(11) NOT NULL,
  `rle_usr_modified_id` int(11) default NULL,
  KEY `rle_pge_fk` (`rle_pge_id`),
  PRIMARY KEY  (`rle_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/role.sql 
INSERT INTO `prt_roles` (`rle_virgo_title`, `rle_name`, `rle_description`, `rle_session_duration`) 
VALUES (title, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_roles table already exists.", '', 'FATAL');
				L("Error ocurred, please contact site Administrator.", '', 'ERROR');
 				return false;
 			}
 			return true;
 		}


		static function onInstall($pobId, $title) {
		}

		static function getIdByKeyName($name) {
			$query = " SELECT rle_id FROM prt_roles WHERE 1 ";
			$query .= " AND rle_name = '{$name}' ";
			$rows = QR($query);
			foreach ($rows as $row) {
				return $row['rle_id'];
			}
			return null;
		}

		static function getByKeyName($name) {
			$id = self::getIdByKeyName($name);
			$ret = new virgoRole();
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
			return "rle";
		}
		
		static function getPlural() {
			return "roles";
		}
		
		static function isDictionary() {
			return true;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoPage";
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoUserRole";
			$ret[] = "virgoPermission";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_roles'));
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
			$virgoVersion = virgoRole::getVirgoVersion();
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
	
	

