<?php
/**
* Module Log channel
* @package Portal
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace portal;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoChannelLevel'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoLogChannel {

		 var  $lch_id = null;
		 var  $lch_name = null;

		 var  $lch_description = null;

		 var  $lch_handler_class_name = null;


		 var   $_logLevelIdsToAddArray = null;
		 var   $_logLevelIdsToDeleteArray = null;
		 var   $lch_date_created = null;
		 var   $lch_usr_created_id = null;
		 var   $lch_date_modified = null;
		 var   $lch_usr_modified_id = null;
		 var   $lch_virgo_title = null;
		 var   $lch_virgo_deleted = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoLogChannel();
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
        	$this->lch_id = null;
		    $this->lch_date_created = null;
		    $this->lch_usr_created_id = null;
		    $this->lch_date_modified = null;
		    $this->lch_usr_modified_id = null;
		    $this->lch_virgo_title = null;
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
			return $this->lch_id;
		}

		function getName() {
			return $this->lch_name;
		}
		
		 function setName($val) {
			$this->lch_name = $val;
		}
		function getDescription() {
			return $this->lch_description;
		}
		
		 function setDescription($val) {
			$this->lch_description = $val;
		}
		function getHandlerClassName() {
			return $this->lch_handler_class_name;
		}
		
		 function setHandlerClassName($val) {
			$this->lch_handler_class_name = $val;
		}


		function getDateCreated() {
			return $this->lch_date_created;
		}
		function getUsrCreatedId() {
			return $this->lch_usr_created_id;
		}
		function getDateModified() {
			return $this->lch_date_modified;
		}
		function getUsrModifiedId() {
			return $this->lch_usr_modified_id;
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
			$this->lch_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('lch_name_' . $this->lch_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->lch_name = null;
		} else {
			$this->lch_name = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('lch_description_' . $this->lch_id);
	if (!is_null($tmpValue)) {
		if ($tmpValue == "") {
			$this->lch_description = null;
		} else {
			$this->lch_description = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('lch_handlerClassName_' . $this->lch_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->lch_handler_class_name = null;
		} else {
			$this->lch_handler_class_name = $tmpValue;
		}
	}
			$tmp_ids = R('lch_channelLevel_' . $this->lch_id, null); 			if (is_null($tmp_ids)) {
				$tmp_ids = array();
			}
			if (is_array($tmp_ids)) { 
				$this->_logLevelIdsToAddArray = $tmp_ids;
				$this->_logLevelIdsToDeleteArray = array();
				$currentConnections = $this->getChannelLevels();
				foreach ($currentConnections as $currentConnection) {
					if (in_array($currentConnection->getLogLevelId(), $tmp_ids)) {
						foreach($this->_logLevelIdsToAddArray as $key => $value) {
							if ($value == $currentConnection->getLogLevelId()) {
								unset($this->_logLevelIdsToAddArray[$key]);
							}
						}
						$this->_logLevelIdsToAddArray = array_values($this->_logLevelIdsToAddArray);
					} else {
						$this->_logLevelIdsToDeleteArray[] = $currentConnection->getLogLevelId();
					}
				}
			}
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('lch_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaLogChannel = array();	
			$criteriaFieldLogChannel = array();	
			$isNullLogChannel = R('virgo_search_name_is_null');
			
			$criteriaFieldLogChannel["is_null"] = 0;
			if ($isNullLogChannel == "not_null") {
				$criteriaFieldLogChannel["is_null"] = 1;
			} elseif ($isNullLogChannel == "null") {
				$criteriaFieldLogChannel["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_name');

//			if ($isSet) {
			$criteriaFieldLogChannel["value"] = $dataTypeCriteria;
//			}
			$criteriaLogChannel["name"] = $criteriaFieldLogChannel;
			$criteriaFieldLogChannel = array();	
			$isNullLogChannel = R('virgo_search_description_is_null');
			
			$criteriaFieldLogChannel["is_null"] = 0;
			if ($isNullLogChannel == "not_null") {
				$criteriaFieldLogChannel["is_null"] = 1;
			} elseif ($isNullLogChannel == "null") {
				$criteriaFieldLogChannel["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_description');

//			if ($isSet) {
			$criteriaFieldLogChannel["value"] = $dataTypeCriteria;
//			}
			$criteriaLogChannel["description"] = $criteriaFieldLogChannel;
			$criteriaFieldLogChannel = array();	
			$isNullLogChannel = R('virgo_search_handlerClassName_is_null');
			
			$criteriaFieldLogChannel["is_null"] = 0;
			if ($isNullLogChannel == "not_null") {
				$criteriaFieldLogChannel["is_null"] = 1;
			} elseif ($isNullLogChannel == "null") {
				$criteriaFieldLogChannel["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_handlerClassName');

//			if ($isSet) {
			$criteriaFieldLogChannel["value"] = $dataTypeCriteria;
//			}
			$criteriaLogChannel["handler_class_name"] = $criteriaFieldLogChannel;
			$parent = R('virgo_search_logLevel', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
				$criteriaLogChannel["log_level"] = $criteriaParent;
			}
			self::setCriteria($criteriaLogChannel);
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
			$tableFilter = R('virgo_filter_handler_class_name');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterHandlerClassName', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterHandlerClassName', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseLogChannel = ' 1 = 1 ';
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
				$eventColumn = "lch_" . P('event_column');
				$whereClauseLogChannel = $whereClauseLogChannel . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseLogChannel = $whereClauseLogChannel . ' AND ' . $parentContextInfo['condition'];
			}
			$filter = "";
			$criteriaLogChannel = self::getCriteria();
			if (isset($criteriaLogChannel["name"])) {
				$fieldCriteriaName = $criteriaLogChannel["name"];
				if ($fieldCriteriaName["is_null"] == 1) {
$filter = $filter . ' AND prt_log_channels.lch_name IS NOT NULL ';
				} elseif ($fieldCriteriaName["is_null"] == 2) {
$filter = $filter . ' AND prt_log_channels.lch_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_log_channels.lch_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaLogChannel["description"])) {
				$fieldCriteriaDescription = $criteriaLogChannel["description"];
				if ($fieldCriteriaDescription["is_null"] == 1) {
$filter = $filter . ' AND prt_log_channels.lch_description IS NOT NULL ';
				} elseif ($fieldCriteriaDescription["is_null"] == 2) {
$filter = $filter . ' AND prt_log_channels.lch_description IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDescription["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_log_channels.lch_description like ? ";
				$types .= "s";
				$values[] = $condition;				
			}
				}
			}
			if (isset($criteriaLogChannel["handler_class_name"])) {
				$fieldCriteriaHandlerClassName = $criteriaLogChannel["handler_class_name"];
				if ($fieldCriteriaHandlerClassName["is_null"] == 1) {
$filter = $filter . ' AND prt_log_channels.lch_handler_class_name IS NOT NULL ';
				} elseif ($fieldCriteriaHandlerClassName["is_null"] == 2) {
$filter = $filter . ' AND prt_log_channels.lch_handler_class_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaHandlerClassName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_log_channels.lch_handler_class_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaLogChannel["log_level"])) {
				$parentCriteria = $criteriaLogChannel["log_level"];
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$filter = $filter . " AND prt_log_channels.lch_id IN (SELECT second_parent.clv_lch_id FROM prt_channel_levels AS second_parent WHERE second_parent.clv_llv_id IN (" . implode(", ", $parentIds) . ")) ";
				}
			}
			$whereClauseLogChannel = $whereClauseLogChannel . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseLogChannel = $whereClauseLogChannel . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseLogChannel = $whereClauseLogChannel . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterName', null);
				if (S($tableFilter)) {
					$whereClauseLogChannel = $whereClauseLogChannel . " AND lch_name LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterDescription', null);
				if (S($tableFilter)) {
					$whereClauseLogChannel = $whereClauseLogChannel . " AND lch_description LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterHandlerClassName', null);
				if (S($tableFilter)) {
					$whereClauseLogChannel = $whereClauseLogChannel . " AND lch_handler_class_name LIKE '%{$tableFilter}%' ";
				}
			}
			return $whereClauseLogChannel;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseLogChannel = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_log_channels.lch_id, prt_log_channels.lch_virgo_title ";
			$queryString = $queryString . " ,prt_log_channels.lch_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column', 'lch_display_order');
			$orderColumnNotDisplayed = "";
			if (P('show_table_name', "1") != "0") {
				$queryString = $queryString . ", prt_log_channels.lch_name lch_name";
			} else {
				if ($defaultOrderColumn == "lch_name") {
					$orderColumnNotDisplayed = " prt_log_channels.lch_name ";
				}
			}
			if (P('show_table_description', "1") != "0") {
				$queryString = $queryString . ", prt_log_channels.lch_description lch_description";
			} else {
				if ($defaultOrderColumn == "lch_description") {
					$orderColumnNotDisplayed = " prt_log_channels.lch_description ";
				}
			}
			if (P('show_table_handler_class_name', "1") != "0") {
				$queryString = $queryString . ", prt_log_channels.lch_handler_class_name lch_handler_class_name";
			} else {
				if ($defaultOrderColumn == "lch_handler_class_name") {
					$orderColumnNotDisplayed = " prt_log_channels.lch_handler_class_name ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_log_channels ";

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseLogChannel = $whereClauseLogChannel . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseLogChannel, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseLogChannel,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_log_channels"
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
				. "\n FROM prt_log_channels"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_log_channels ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_log_channels ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, lch_id $orderMode";
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
				$query = "SELECT COUNT(lch_id) cnt FROM log_channels";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as log_channels ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as log_channels ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoLogChannel();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_log_channels WHERE lch_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->lch_id = $row['lch_id'];
$this->lch_name = $row['lch_name'];
$this->lch_description = $row['lch_description'];
$this->lch_handler_class_name = $row['lch_handler_class_name'];
						if ($fetchUsernames) {
							if ($row['lch_date_created']) {
								if ($row['lch_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['lch_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['lch_date_modified']) {
								if ($row['lch_usr_modified_id'] == $row['lch_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['lch_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['lch_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->lch_date_created = $row['lch_date_created'];
						$this->lch_usr_created_id = $fetchUsernames ? $createdBy : $row['lch_usr_created_id'];
						$this->lch_date_modified = $row['lch_date_modified'];
						$this->lch_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['lch_usr_modified_id'];
						$this->lch_virgo_title = $row['lch_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_log_channels SET lch_usr_created_id = {$userId} WHERE lch_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->lch_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoLogChannel::selectAllAsObjectsStatic('lch_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->lch_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->lch_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('lch_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_lch = new virgoLogChannel();
				$tmp_lch->load((int)$lookup_id);
				return $tmp_lch->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoLogChannel');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" lch_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoLogChannel', "10");
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
				$query = $query . " lch_id as id, lch_virgo_title as title ";
			}
			$query = $query . " FROM prt_log_channels ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			$query = $query . $tmpQuery;
			$query = $query . " AND (lch_virgo_deleted IS NULL OR lch_virgo_deleted = 0) ";
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY lch_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resLogChannel = array();
				foreach ($rows as $row) {
					$resLogChannel[$row['id']] = $row['title'];
				}
				return $resLogChannel;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticLogChannel = new virgoLogChannel();
			return $staticLogChannel->getVirgoList($where, $sizeOnly, $hash);
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
			$resultsChannelLevel = virgoChannelLevel::selectAll('clv_lch_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsChannelLevel as $resultChannelLevel) {
				$tmpChannelLevel = virgoChannelLevel::getById($resultChannelLevel['clv_id']); 
				array_push($resChannelLevel, $tmpChannelLevel);
			}
			return $resChannelLevel;
		}

		function getChannelLevels($orderBy = '', $extraWhere = null) {
			return virgoLogChannel::getChannelLevelsStatic($this->getId(), $orderBy, $extraWhere);
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
			if (P('show_'.$tmpMode.'_handler_class_name_obligatory', "0") == "1") {
				if (
(is_null($this->getHandlerClassName()) || trim($this->getHandlerClassName()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'HANDLER_CLASS_NAME');
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_log_channels WHERE lch_id = " . $this->getId();
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
				$colNames = $colNames . ", lch_name";
				$values = $values . ", " . (is_null($objectToStore->getName()) ? "null" : "'" . QE($objectToStore->getName()) . "'");
				$colNames = $colNames . ", lch_description";
				$values = $values . ", " . (is_null($objectToStore->getDescription()) ? "null" : "'" . QE($objectToStore->getDescription()) . "'");
				$colNames = $colNames . ", lch_handler_class_name";
				$values = $values . ", " . (is_null($objectToStore->getHandlerClassName()) ? "null" : "'" . QE($objectToStore->getHandlerClassName()) . "'");
				$query = "INSERT INTO prt_history_log_channels (revision, ip, username, user_id, timestamp, lch_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
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
				$colNames = $colNames . ", lch_name";
				$values = $values . ", " . (is_null($objectToStore->getName()) ? "null" : "'" . QE($objectToStore->getName()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getDescription() != $objectToStore->getDescription()) {
				if (is_null($objectToStore->getDescription())) {
					$nullifiedProperties = $nullifiedProperties . "description,";
				} else {
				$colNames = $colNames . ", lch_description";
				$values = $values . ", " . (is_null($objectToStore->getDescription()) ? "null" : "'" . QE($objectToStore->getDescription()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getHandlerClassName() != $objectToStore->getHandlerClassName()) {
				if (is_null($objectToStore->getHandlerClassName())) {
					$nullifiedProperties = $nullifiedProperties . "handler_class_name,";
				} else {
				$colNames = $colNames . ", lch_handler_class_name";
				$values = $values . ", " . (is_null($objectToStore->getHandlerClassName()) ? "null" : "'" . QE($objectToStore->getHandlerClassName()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			$query = "INSERT INTO prt_history_log_channels (revision, ip, username, user_id, timestamp, lch_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_log_channels");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'lch_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_log_channels ADD COLUMN (lch_virgo_title VARCHAR(255));";
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
			if (isset($this->lch_id) && $this->lch_id != "") {
				$query = "UPDATE prt_log_channels SET ";
			if (isset($this->lch_name)) {
				$query .= " lch_name = ? ,";
				$types .= "s";
				$values[] = $this->lch_name;
			} else {
				$query .= " lch_name = NULL ,";				
			}
			if (isset($this->lch_description)) {
				$query .= " lch_description = ? ,";
				$types .= "s";
				$values[] = $this->lch_description;
			} else {
				$query .= " lch_description = NULL ,";				
			}
			if (isset($this->lch_handler_class_name)) {
				$query .= " lch_handler_class_name = ? ,";
				$types .= "s";
				$values[] = $this->lch_handler_class_name;
			} else {
				$query .= " lch_handler_class_name = NULL ,";				
			}
				if (isset($this->lch_virgo_deleted)) {
					$query = $query . " lch_virgo_deleted = ? , ";
					$types = $types . "i";
					$values[] = $this->lch_virgo_deleted;
				} else {
					$query = $query . " lch_virgo_deleted = NULL , ";
				}
				$query = $query . " lch_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " lch_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->lch_date_modified;

				$query = $query . " lch_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->lch_usr_modified_id;

				$query = $query . " WHERE lch_id = ? ";
				$types = $types . "i";
				$values[] = $this->lch_id;
			} else {
				$query = "INSERT INTO prt_log_channels ( ";
			$query = $query . " lch_name, ";
			$query = $query . " lch_description, ";
			$query = $query . " lch_handler_class_name, ";
				$query = $query . " lch_virgo_title, lch_date_created, lch_usr_created_id) VALUES ( ";
			if (isset($this->lch_name)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->lch_name;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->lch_description)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->lch_description;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->lch_handler_class_name)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->lch_handler_class_name;
			} else {
				$query .= " NULL ,";				
			}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->lch_date_created;
				$values[] = $this->lch_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->lch_id) || $this->lch_id == "") {
					$this->lch_id = QID();
				}
				if ($log) {
					L("log channel stored successfully", "id = {$this->lch_id}", "TRACE");
				}
				return true;
			}
		}
		

		static function addLogLevelStatic($thisId, $id) {
			$query = " SELECT COUNT(clv_id) AS cnt FROM prt_channel_levels WHERE clv_lch_id = {$thisId} AND clv_llv_id = {$id} ";
			$res = Q1($query);
			if ($res == 0) {
				$newChannelLevel = new virgoChannelLevel();
				$newChannelLevel->setLogLevelId($id);
				$newChannelLevel->setLogChannelId($thisId);
				return $newChannelLevel->store();
			}			
			return "";
		}
		
		function addLogLevel($id) {
			return virgoLogChannel::addLogLevelStatic($this->getId(), $id);
		}
		
		static function removeLogLevelStatic($thisId, $id) {
			$query = " SELECT clv_id AS id FROM prt_channel_levels WHERE clv_lch_id = {$thisId} AND clv_llv_id = {$id} ";
			$res = QR($query);
			foreach ($res as $re) {
				$newChannelLevel = new virgoChannelLevel($re['id']);
				return $newChannelLevel->delete();
			}			
			return "";
		}
		
		function removeLogLevel($id) {
			return virgoLogChannel::removeLogLevelStatic($this->getId(), $id);
		}
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->lch_id) {
				$virgoOld = new virgoLogChannel($this->lch_id);
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
					if ($this->lch_id) {			
						$this->lch_date_modified = date("Y-m-d H:i:s");
						$this->lch_usr_modified_id = $userId;
					} else {
						$this->lch_date_created = date("Y-m-d H:i:s");
						$this->lch_usr_created_id = $userId;
					}
					$this->lch_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "log channel" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "log channel" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
						}
					}
					if (!is_null($this->_logLevelIdsToAddArray)) {
						foreach ($this->_logLevelIdsToAddArray as $logLevelId) {
							$ret = $this->addLogLevel((int)$logLevelId);
							if ($ret != "") {
								L($ret, '', 'ERROR');
							}
						}
					}
					if (!is_null($this->_logLevelIdsToDeleteArray)) {
						foreach ($this->_logLevelIdsToDeleteArray as $logLevelId) {
							$ret = $this->removeLogLevel((int)$logLevelId);
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
			$query = "DELETE FROM prt_log_channels WHERE lch_id = {$this->lch_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			self::removeFromContext();
			$this->lch_virgo_deleted = true;
			$this->lch_date_modified = date("Y-m-d H:i:s");
			$userId = virgoUser::getUserId();
			$this->lch_usr_modified_id = $userId;
			$this->parentStore(true);
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoLogChannel();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT lch_id as id FROM prt_log_channels";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'lch_order_column')) {
				$orderBy = " ORDER BY lch_order_column ASC ";
			} 
			if (property_exists($this, 'lch_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY lch_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoLogChannel();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoLogChannel($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_log_channels SET lch_virgo_title = '$title' WHERE lch_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getByNameStatic($token) {
			$tmpStatic = new virgoLogChannel();
			$tmpId = $tmpStatic->getIdByName($token);
			$tmpStatic->load($tmpId);
			return $tmpStatic;
		}
		
		static function getIdByNameStatic($token) {
			$tmpStatic = new virgoLogChannel();
			return $tmpStatic->getIdByName($token);
		}
		
		function getIdByName($token) {
			$res = $this->selectAll(" lch_name = ?", "", "s", array($token));
			foreach ($res as $r) {
				return $r['lch_id'];
			}
			return null;
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoLogChannel();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" lch_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['lch_id'];
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
			virgoLogChannel::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoLogChannel::setSessionValue('Portal_LogChannel-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoLogChannel::getSessionValue('Portal_LogChannel-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoLogChannel::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoLogChannel::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoLogChannel::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoLogChannel::getSessionValue('GLOBAL', $name, $default);
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
			$context['lch_id'] = $id;
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
			$context['lch_id'] = null;
			virgoLogChannel::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoLogChannel::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoLogChannel::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoLogChannel::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoLogChannel::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoLogChannel::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoLogChannel::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoLogChannel::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoLogChannel::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoLogChannel::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoLogChannel::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoLogChannel::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoLogChannel::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoLogChannel::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoLogChannel::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoLogChannel::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoLogChannel::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "lch_id";
			}
			return virgoLogChannel::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoLogChannel::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoLogChannel::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoLogChannel::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoLogChannel::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoLogChannel::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoLogChannel::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoLogChannel::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoLogChannel::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoLogChannel::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoLogChannel::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoLogChannel::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoLogChannel::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->lch_id) {
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
						L(T('STORED_CORRECTLY', 'LOG_CHANNEL'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'name', $this->lch_name);
						$fieldValues = $fieldValues . T($fieldValue, 'description', $this->lch_description);
						$fieldValues = $fieldValues . T($fieldValue, 'handler class name', $this->lch_handler_class_name);
						$username = '';
						if ($this->lch_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->lch_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->lch_date_created);
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
			$instance = new virgoLogChannel();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoLogChannel'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			$tmpId = intval(R('lch_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoLogChannel::getContextId();
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
			$this->lch_id = null;
			$this->lch_date_created = null;
			$this->lch_usr_created_id = null;
			$this->lch_date_modified = null;
			$this->lch_usr_modified_id = null;
			$this->lch_virgo_title = null;
			$this->lch_virgo_deleted = null;
			
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
//			$ret = new virgoLogChannel();
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
				$instance = new virgoLogChannel();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoLogChannel::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'LOG_CHANNEL'), '', 'INFO');
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
				$resultLogChannel = new virgoLogChannel();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultLogChannel->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultLogChannel->load($idToEditInt);
					} else {
						$resultLogChannel->lch_id = 0;
					}
				}
				$results[] = $resultLogChannel;
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
				$result = new virgoLogChannel();
				$result->loadFromRequest($idToStore);
				if ($result->lch_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->lch_id == 0) {
						$result->lch_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->lch_id)) {
							$result->lch_id = 0;
						}
						$idsToCorrect[$result->lch_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'LOG_CHANNELS'), '', 'INFO');
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
			$resultLogChannel = new virgoLogChannel();
			foreach ($idsToDelete as $idToDelete) {
				$resultLogChannel->load((int)trim($idToDelete));
				$res = $resultLogChannel->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'LOG_CHANNELS'), '', 'INFO');			
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
		$ret = $this->lch_name;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoLogChannel');
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
				$query = "UPDATE prt_log_channels SET lch_virgo_title = ? WHERE lch_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT lch_id AS id FROM prt_log_channels ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoLogChannel($row['id']);
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
						$parentInfo['condition'] = 'prt_log_channels.lch_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_log_channels.lch_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_log_channels.lch_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_log_channels.lch_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoLogChannel!', '', 'ERROR');
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
			$pdf->SetTitle('Log channels report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('LOG_CHANNELS');
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
			if (P('show_pdf_handler_class_name', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultLogChannel = new virgoLogChannel();
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
			if (P('show_pdf_handler_class_name', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Handler class name');
				$minWidth['handler class name'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['handler class name']) {
						$minWidth['handler class name'] = min($tmpLen, $maxWidth);
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
			$whereClauseLogChannel = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseLogChannel = $whereClauseLogChannel . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaLogChannel = $resultLogChannel->getCriteria();
			$fieldCriteriaName = $criteriaLogChannel["name"];
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
			$fieldCriteriaDescription = $criteriaLogChannel["description"];
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
			$fieldCriteriaHandlerClassName = $criteriaLogChannel["handler_class_name"];
			if ($fieldCriteriaHandlerClassName["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Handler class name', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaHandlerClassName["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Handler class name', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$filter = "";
			$criteriaLogChannel = self::getCriteria();
			if (isset($criteriaLogChannel["name"])) {
				$fieldCriteriaName = $criteriaLogChannel["name"];
				if ($fieldCriteriaName["is_null"] == 1) {
$filter = $filter . ' AND prt_log_channels.lch_name IS NOT NULL ';
				} elseif ($fieldCriteriaName["is_null"] == 2) {
$filter = $filter . ' AND prt_log_channels.lch_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_log_channels.lch_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaLogChannel["description"])) {
				$fieldCriteriaDescription = $criteriaLogChannel["description"];
				if ($fieldCriteriaDescription["is_null"] == 1) {
$filter = $filter . ' AND prt_log_channels.lch_description IS NOT NULL ';
				} elseif ($fieldCriteriaDescription["is_null"] == 2) {
$filter = $filter . ' AND prt_log_channels.lch_description IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDescription["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_log_channels.lch_description like ? ";
				$types .= "s";
				$values[] = $condition;				
			}
				}
			}
			if (isset($criteriaLogChannel["handler_class_name"])) {
				$fieldCriteriaHandlerClassName = $criteriaLogChannel["handler_class_name"];
				if ($fieldCriteriaHandlerClassName["is_null"] == 1) {
$filter = $filter . ' AND prt_log_channels.lch_handler_class_name IS NOT NULL ';
				} elseif ($fieldCriteriaHandlerClassName["is_null"] == 2) {
$filter = $filter . ' AND prt_log_channels.lch_handler_class_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaHandlerClassName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_log_channels.lch_handler_class_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaLogChannel["log_level"])) {
				$parentCriteria = $criteriaLogChannel["log_level"];
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$filter = $filter . " AND prt_log_channels.lch_id IN (SELECT second_parent.clv_lch_id FROM prt_channel_levels AS second_parent WHERE second_parent.clv_llv_id IN (" . implode(", ", $parentIds) . ")) ";
				}
			}
			$whereClauseLogChannel = $whereClauseLogChannel . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseLogChannel = $whereClauseLogChannel . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_log_channels.lch_id, prt_log_channels.lch_virgo_title ";
			$queryString = $queryString . " ,prt_log_channels.lch_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_name', "1") != "0") {
				$queryString = $queryString . ", prt_log_channels.lch_name lch_name";
			} else {
				if ($defaultOrderColumn == "lch_name") {
					$orderColumnNotDisplayed = " prt_log_channels.lch_name ";
				}
			}
			if (P('show_pdf_description', "1") != "0") {
				$queryString = $queryString . ", prt_log_channels.lch_description lch_description";
			} else {
				if ($defaultOrderColumn == "lch_description") {
					$orderColumnNotDisplayed = " prt_log_channels.lch_description ";
				}
			}
			if (P('show_pdf_handler_class_name', "1") != "0") {
				$queryString = $queryString . ", prt_log_channels.lch_handler_class_name lch_handler_class_name";
			} else {
				if ($defaultOrderColumn == "lch_handler_class_name") {
					$orderColumnNotDisplayed = " prt_log_channels.lch_handler_class_name ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_log_channels ";

		$resultsLogChannel = $resultLogChannel->select(
			'', 
			'all', 
			$resultLogChannel->getOrderColumn(), 
			$resultLogChannel->getOrderMode(), 
			$whereClauseLogChannel,
			$queryString);
		
		foreach ($resultsLogChannel as $resultLogChannel) {

			if (P('show_pdf_name', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultLogChannel['lch_name'])) + 6;
				if ($tmpLen > $minWidth['name']) {
					$minWidth['name'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_description', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultLogChannel['lch_description'])) + 6;
				if ($tmpLen > $minWidth['description']) {
					$minWidth['description'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_handler_class_name', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultLogChannel['lch_handler_class_name'])) + 6;
				if ($tmpLen > $minWidth['handler class name']) {
					$minWidth['handler class name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaLogChannel = $resultLogChannel->getCriteria();
		if (is_null($criteriaLogChannel) || sizeof($criteriaLogChannel) == 0 || $countTmp == 0) {
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
			if (P('show_pdf_handler_class_name', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['handler class name'], $colHeight, T('HANDLER_CLASS_NAME'), 'T', 'C', 0, 0);
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
		foreach ($resultsLogChannel as $resultLogChannel) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_name', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['name'], $colHeight, '' . $resultLogChannel['lch_name'], 'T', 'L', 0, 0);
				if (P('show_pdf_name', "1") == "2") {
										if (!is_null($resultLogChannel['lch_name'])) {
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
										if (!is_null($resultLogChannel['lch_name'])) {
						$tmpSum = (float)$sums["name"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLogChannel['lch_name'];
						}
						$sums["name"] = $tmpSum;
					}
				}
				if (P('show_pdf_name', "1") == "4") {
										if (!is_null($resultLogChannel['lch_name'])) {
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
							$tmpSum = $tmpSum + $resultLogChannel['lch_name'];
						}
						$avgSums["name"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_description', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['description'], $colHeight, '' . $resultLogChannel['lch_description'], 'T', 'L', 0, 0);
				if (P('show_pdf_description', "1") == "2") {
										if (!is_null($resultLogChannel['lch_description'])) {
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
										if (!is_null($resultLogChannel['lch_description'])) {
						$tmpSum = (float)$sums["description"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLogChannel['lch_description'];
						}
						$sums["description"] = $tmpSum;
					}
				}
				if (P('show_pdf_description', "1") == "4") {
										if (!is_null($resultLogChannel['lch_description'])) {
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
							$tmpSum = $tmpSum + $resultLogChannel['lch_description'];
						}
						$avgSums["description"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_handler_class_name', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['handler class name'], $colHeight, '' . $resultLogChannel['lch_handler_class_name'], 'T', 'L', 0, 0);
				if (P('show_pdf_handler_class_name', "1") == "2") {
										if (!is_null($resultLogChannel['lch_handler_class_name'])) {
						$tmpCount = (float)$counts["handler_class_name"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["handler_class_name"] = $tmpCount;
					}
				}
				if (P('show_pdf_handler_class_name', "1") == "3") {
										if (!is_null($resultLogChannel['lch_handler_class_name'])) {
						$tmpSum = (float)$sums["handler_class_name"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLogChannel['lch_handler_class_name'];
						}
						$sums["handler_class_name"] = $tmpSum;
					}
				}
				if (P('show_pdf_handler_class_name', "1") == "4") {
										if (!is_null($resultLogChannel['lch_handler_class_name'])) {
						$tmpCount = (float)$avgCounts["handler_class_name"];
						$tmpSum = (float)$avgSums["handler_class_name"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["handler_class_name"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLogChannel['lch_handler_class_name'];
						}
						$avgSums["handler_class_name"] = $tmpSum;
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
			if (P('show_pdf_handler_class_name', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['handler class name'];
				if (P('show_pdf_handler_class_name', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["handler_class_name"];
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
			if (P('show_pdf_handler_class_name', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['handler class name'];
				if (P('show_pdf_handler_class_name', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["handler_class_name"], 2, ',', ' ');
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
			if (P('show_pdf_handler_class_name', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['handler class name'];
				if (P('show_pdf_handler_class_name', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["handler_class_name"] == 0 ? "-" : $avgSums["handler_class_name"] / $avgCounts["handler_class_name"]);
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
				$reportTitle = T('LOG_CHANNELS');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultLogChannel = new virgoLogChannel();
			$whereClauseLogChannel = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseLogChannel = $whereClauseLogChannel . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_name', "1") != "0") {
					$data = $data . $stringDelimeter .'Name' . $stringDelimeter . $separator;
				}
				if (P('show_export_description', "1") != "0") {
					$data = $data . $stringDelimeter .'Description' . $stringDelimeter . $separator;
				}
				if (P('show_export_handler_class_name', "1") != "0") {
					$data = $data . $stringDelimeter .'Handler class name' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_log_channels.lch_id, prt_log_channels.lch_virgo_title ";
			$queryString = $queryString . " ,prt_log_channels.lch_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_name', "1") != "0") {
				$queryString = $queryString . ", prt_log_channels.lch_name lch_name";
			} else {
				if ($defaultOrderColumn == "lch_name") {
					$orderColumnNotDisplayed = " prt_log_channels.lch_name ";
				}
			}
			if (P('show_export_description', "1") != "0") {
				$queryString = $queryString . ", prt_log_channels.lch_description lch_description";
			} else {
				if ($defaultOrderColumn == "lch_description") {
					$orderColumnNotDisplayed = " prt_log_channels.lch_description ";
				}
			}
			if (P('show_export_handler_class_name', "1") != "0") {
				$queryString = $queryString . ", prt_log_channels.lch_handler_class_name lch_handler_class_name";
			} else {
				if ($defaultOrderColumn == "lch_handler_class_name") {
					$orderColumnNotDisplayed = " prt_log_channels.lch_handler_class_name ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_log_channels ";

			$resultsLogChannel = $resultLogChannel->select(
				'', 
				'all', 
				$resultLogChannel->getOrderColumn(), 
				$resultLogChannel->getOrderMode(), 
				$whereClauseLogChannel,
				$queryString);
			foreach ($resultsLogChannel as $resultLogChannel) {
				if (P('show_export_name', "1") != "0") {
			$data = $data . $stringDelimeter . $resultLogChannel['lch_name'] . $stringDelimeter . $separator;
				}
				if (P('show_export_description', "1") != "0") {
			$data = $data . $stringDelimeter . $resultLogChannel['lch_description'] . $stringDelimeter . $separator;
				}
				if (P('show_export_handler_class_name', "1") != "0") {
			$data = $data . $stringDelimeter . $resultLogChannel['lch_handler_class_name'] . $stringDelimeter . $separator;
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
				$reportTitle = T('LOG_CHANNELS');
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
			$resultLogChannel = new virgoLogChannel();
			$whereClauseLogChannel = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseLogChannel = $whereClauseLogChannel . ' AND ' . $parentContextInfo['condition'];
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
				if (P('show_export_handler_class_name', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Handler class name');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_log_channels.lch_id, prt_log_channels.lch_virgo_title ";
			$queryString = $queryString . " ,prt_log_channels.lch_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_name', "1") != "0") {
				$queryString = $queryString . ", prt_log_channels.lch_name lch_name";
			} else {
				if ($defaultOrderColumn == "lch_name") {
					$orderColumnNotDisplayed = " prt_log_channels.lch_name ";
				}
			}
			if (P('show_export_description', "1") != "0") {
				$queryString = $queryString . ", prt_log_channels.lch_description lch_description";
			} else {
				if ($defaultOrderColumn == "lch_description") {
					$orderColumnNotDisplayed = " prt_log_channels.lch_description ";
				}
			}
			if (P('show_export_handler_class_name', "1") != "0") {
				$queryString = $queryString . ", prt_log_channels.lch_handler_class_name lch_handler_class_name";
			} else {
				if ($defaultOrderColumn == "lch_handler_class_name") {
					$orderColumnNotDisplayed = " prt_log_channels.lch_handler_class_name ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_log_channels ";

			$resultsLogChannel = $resultLogChannel->select(
				'', 
				'all', 
				$resultLogChannel->getOrderColumn(), 
				$resultLogChannel->getOrderMode(), 
				$whereClauseLogChannel,
				$queryString);
			$index = 1;
			foreach ($resultsLogChannel as $resultLogChannel) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultLogChannel['lch_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_name', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultLogChannel['lch_name'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_description', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultLogChannel['lch_description'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_handler_class_name', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultLogChannel['lch_handler_class_name'], \PHPExcel_Cell_DataType::TYPE_STRING);
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
					$propertyColumnHash['name'] = 'lch_name';
					$propertyColumnHash['name'] = 'lch_name';
					$propertyColumnHash['description'] = 'lch_description';
					$propertyColumnHash['description'] = 'lch_description';
					$propertyColumnHash['handler class name'] = 'lch_handler_class_name';
					$propertyColumnHash['handler_class_name'] = 'lch_handler_class_name';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importLogChannel = new virgoLogChannel();
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
										L(T('PROPERTY_NOT_FOUND', T('LOG_CHANNEL'), $columns[$index]), '', 'ERROR');
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
										$importLogChannel->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
							$errorMessage = $importLogChannel->store();
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
CREATE TABLE IF NOT EXISTS `prt_log_channels` (
  `lch_id` bigint(20) unsigned NOT NULL auto_increment,
  `lch_virgo_state` varchar(50) default NULL,
  `lch_virgo_title` varchar(255) default NULL,
  `lch_virgo_deleted` boolean,
  `lch_name` varchar(255), 
  `lch_description` longtext, 
  `lch_handler_class_name` varchar(255), 
  `lch_date_created` datetime NOT NULL,
  `lch_date_modified` datetime default NULL,
  `lch_usr_created_id` int(11) NOT NULL,
  `lch_usr_modified_id` int(11) default NULL,
  PRIMARY KEY  (`lch_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/log_channel.sql 
INSERT INTO `prt_log_channels` (`lch_virgo_title`, `lch_name`, `lch_description`, `lch_handler_class_name`) 
VALUES (title, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_log_channels table already exists.", '', 'FATAL');
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
			return "lch";
		}
		
		static function getPlural() {
			return "log_channels";
		}
		
		static function isDictionary() {
			return true;
		}

		static function getParents() {
			$ret = array();
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoChannelLevel";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_log_channels'));
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
			$virgoVersion = virgoLogChannel::getVirgoVersion();
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
	
	

