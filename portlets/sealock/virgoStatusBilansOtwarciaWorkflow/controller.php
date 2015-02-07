<?php
/**
* Module Status bilans otwarcia workflow
* @package Sealock
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace sealock;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoStatusBilansOtwarcia'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoStatusBilansOtwarcia'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoStatusBilansOtwarciaWorkflow {

		 private  $sbw_id = null;
		 private  $sbw_sbo_next_id = null;
		 private  $sbw_sbo_prev_id = null;

		 private   $sbw_date_created = null;
		 private   $sbw_usr_created_id = null;
		 private   $sbw_date_modified = null;
		 private   $sbw_usr_modified_id = null;
		 private   $sbw_virgo_title = null;
		
		 private   $internalLog = null;		
				
		 private  function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		public function isDeletedVirgo() {
			return $this->sbw_virgo_deleted;
		}

		static public function createGuiAware() {
			$ret = new virgoStatusBilansOtwarciaWorkflow();
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
        	$this->sbw_id = null;
		    $this->sbw_date_created = null;
		    $this->sbw_usr_created_id = null;
		    $this->sbw_date_modified = null;
		    $this->sbw_usr_modified_id = null;
		    $this->sbw_virgo_title = null;
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
			return $this->sbw_id;
		}


		function getStatusBilansOtwarciaNextId() {
			return $this->sbw_sbo_next_id;
		}
		
		 private  function setStatusBilansOtwarciaNextId($val) {
			$this->sbw_sbo_next_id = $val;
		}
		function getStatusBilansOtwarciaPrevId() {
			return $this->sbw_sbo_prev_id;
		}
		
		 private  function setStatusBilansOtwarciaPrevId($val) {
			$this->sbw_sbo_prev_id = $val;
		}

		function getDateCreated() {
			return $this->sbw_date_created;
		}
		function getUsrCreatedId() {
			return $this->sbw_usr_created_id;
		}
		function getDateModified() {
			return $this->sbw_date_modified;
		}
		function getUsrModifiedId() {
			return $this->sbw_usr_modified_id;
		}


		function getSboNextId() {
			return $this->getStatusBilansOtwarciaNextId();
		}
		
		 private  function setSboNextId($val) {
			$this->setStatusBilansOtwarciaNextId($val);
		}
		function getSboPrevId() {
			return $this->getStatusBilansOtwarciaPrevId();
		}
		
		 private  function setSboPrevId($val) {
			$this->setStatusBilansOtwarciaPrevId($val);
		}

		function loadRecordFromRequest($rowId) {
			$this->sbw_id = $rowId;
			$this->sbw_sbo_next_id = strval(R('sbw_statusBilansOtwarciaNext_' . $this->sbw_id));
			$this->sbw_sbo_prev_id = strval(R('sbw_statusBilansOtwarciaPrev_' . $this->sbw_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('sbw_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaStatusBilansOtwarciaWorkflow = array();	
			$criteriaParent = array();	
			$isNull = R('virgo_search_statusBilansOtwarcianext_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_statusBilansOtwarciaNext', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
			}
			$criteriaStatusBilansOtwarciaWorkflow["status_bilans_otwarcianext"] = $criteriaParent;
			$criteriaParent = array();	
			$isNull = R('virgo_search_statusBilansOtwarciaprev_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_statusBilansOtwarciaPrev', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
			}
			$criteriaStatusBilansOtwarciaWorkflow["status_bilans_otwarciaprev"] = $criteriaParent;
			self::setCriteria($criteriaStatusBilansOtwarciaWorkflow);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$parentFilter = R('virgo_filter_status_bilans_otwarcianext');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterStatusBilansOtwarciaNext', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterStatusBilansOtwarciaNext', null);
			}
			$parentFilter = R('virgo_filter_title_status_bilans_otwarcianext');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleStatusBilansOtwarciaNext', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleStatusBilansOtwarciaNext', null);
			}
			$parentFilter = R('virgo_filter_status_bilans_otwarciaprev');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterStatusBilansOtwarciaPrev', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterStatusBilansOtwarciaPrev', null);
			}
			$parentFilter = R('virgo_filter_title_status_bilans_otwarciaprev');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleStatusBilansOtwarciaPrev', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleStatusBilansOtwarciaPrev', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseStatusBilansOtwarciaWorkflow = ' 1 = 1 ';
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
				$eventColumn = "sbw_" . P('event_column');
				$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_status_bilans_otwarcianext');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_status_bilans_otwarcia_workflows.sbw_sbo_next_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_status_bilans_otwarcia_workflows.sbw_sbo_next_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_status_bilans_otwarciaprev');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_status_bilans_otwarcia_workflows.sbw_sbo_prev_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_status_bilans_otwarcia_workflows.sbw_sbo_prev_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaStatusBilansOtwarciaWorkflow = self::getCriteria();
			if (isset($criteriaStatusBilansOtwarciaWorkflow["status_bilans_otwarcianext"])) {
				$parentCriteria = $criteriaStatusBilansOtwarciaWorkflow["status_bilans_otwarcianext"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND sbw_sbo_next_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND slk_status_bilans_otwarcia_workflows.sbw_sbo_next_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			if (isset($criteriaStatusBilansOtwarciaWorkflow["status_bilans_otwarciaprev"])) {
				$parentCriteria = $criteriaStatusBilansOtwarciaWorkflow["status_bilans_otwarciaprev"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND sbw_sbo_prev_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND slk_status_bilans_otwarcia_workflows.sbw_sbo_prev_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$parentFilter = self::getLocalSessionValue('VirgoFilterStatusBilansOtwarciaNext', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . " AND sbw_sbo_next_id IS NULL ";
					} else {
						$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . " AND sbw_sbo_next_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleStatusBilansOtwarciaNext', null);
				if (S($parentFilter)) {
					$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . " AND slk_statusy_bilans_otwarcia_parent.sbo_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterStatusBilansOtwarciaPrev', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . " AND sbw_sbo_prev_id IS NULL ";
					} else {
						$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . " AND sbw_sbo_prev_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleStatusBilansOtwarciaPrev', null);
				if (S($parentFilter)) {
					$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . " AND slk_statusy_bilans_otwarcia_parent.sbo_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClauseStatusBilansOtwarciaWorkflow;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseStatusBilansOtwarciaWorkflow = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT slk_status_bilans_otwarcia_workflows.sbw_id, slk_status_bilans_otwarcia_workflows.sbw_virgo_title ";
			$defaultOrderColumn = P('default_sort_column', 'sbw_kolejnosc_wyswietlania');
			$orderColumnNotDisplayed = "";
			if (class_exists('sealock\virgoStatusBilansOtwarcia') && P('show_table_status_bilans_otwarcianext', "1") != "0") { // */ && !in_array("sbonext", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_status_bilans_otwarcia_workflows.sbw_sbo_next_id as sbw_sbw_sbo_next_id ";
				$queryString = $queryString . ", slk_statusy_bilans_otwarcia_next.sbo_virgo_title as status_bilans_otwarcia_next ";
			} else {
				if ($defaultOrderColumn == "status_bilans_otwarcia_next") {
					$orderColumnNotDisplayed = " slk_statusy_bilans_otwarcia_next.sbo_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoStatusBilansOtwarcia') && P('show_table_status_bilans_otwarciaprev', "1") != "0") { // */ && !in_array("sboprev", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_status_bilans_otwarcia_workflows.sbw_sbo_prev_id as sbw_sbw_sbo_prev_id ";
				$queryString = $queryString . ", slk_statusy_bilans_otwarcia_prev.sbo_virgo_title as status_bilans_otwarcia_prev ";
			} else {
				if ($defaultOrderColumn == "status_bilans_otwarcia_prev") {
					$orderColumnNotDisplayed = " slk_statusy_bilans_otwarcia_prev.sbo_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_status_bilans_otwarcia_workflows ";
			if (class_exists('sealock\virgoStatusBilansOtwarcia')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_statusy_bilans_otwarcia AS slk_statusy_bilans_otwarcia_next ON (slk_status_bilans_otwarcia_workflows.sbw_sbo_next_id = slk_statusy_bilans_otwarcia_next.sbo_id) ";
			}
			if (class_exists('sealock\virgoStatusBilansOtwarcia')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_statusy_bilans_otwarcia AS slk_statusy_bilans_otwarcia_prev ON (slk_status_bilans_otwarcia_workflows.sbw_sbo_prev_id = slk_statusy_bilans_otwarcia_prev.sbo_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseStatusBilansOtwarciaWorkflow, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseStatusBilansOtwarciaWorkflow,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM slk_status_bilans_otwarcia_workflows"
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
				. "\n FROM slk_status_bilans_otwarcia_workflows"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as slk_status_bilans_otwarcia_workflows ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as slk_status_bilans_otwarcia_workflows ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, sbw_id $orderMode";
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
				$query = "SELECT COUNT(sbw_id) cnt FROM status_bilans_otwarcia_workflows";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as status_bilans_otwarcia_workflows ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as status_bilans_otwarcia_workflows ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoStatusBilansOtwarciaWorkflow();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM slk_status_bilans_otwarcia_workflows WHERE sbw_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->sbw_id = $row['sbw_id'];
						$this->sbw_sbo_next_id = $row['sbw_sbo_next_id'];
						$this->sbw_sbo_prev_id = $row['sbw_sbo_prev_id'];
						if ($fetchUsernames) {
							if ($row['sbw_date_created']) {
								if ($row['sbw_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['sbw_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['sbw_date_modified']) {
								if ($row['sbw_usr_modified_id'] == $row['sbw_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['sbw_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['sbw_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->sbw_date_created = $row['sbw_date_created'];
						$this->sbw_usr_created_id = $fetchUsernames ? $createdBy : $row['sbw_usr_created_id'];
						$this->sbw_date_modified = $row['sbw_date_modified'];
						$this->sbw_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['sbw_usr_modified_id'];
						$this->sbw_virgo_title = $row['sbw_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE slk_status_bilans_otwarcia_workflows SET sbw_usr_created_id = {$userId} WHERE sbw_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->sbw_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoStatusBilansOtwarciaWorkflow::selectAllAsObjectsStatic('sbw_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->sbw_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->sbw_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('sbw_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_sbw = new virgoStatusBilansOtwarciaWorkflow();
				$tmp_sbw->load((int)$lookup_id);
				return $tmp_sbw->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoStatusBilansOtwarciaWorkflow');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" sbw_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoStatusBilansOtwarciaWorkflow', "10");
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
				$query = $query . " sbw_id as id, sbw_virgo_title as title ";
			}
			$query = $query . " FROM slk_status_bilans_otwarcia_workflows ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY sbw_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resStatusBilansOtwarciaWorkflow = array();
				foreach ($rows as $row) {
					$resStatusBilansOtwarciaWorkflow[$row['id']] = $row['title'];
				}
				return $resStatusBilansOtwarciaWorkflow;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticStatusBilansOtwarciaWorkflow = new virgoStatusBilansOtwarciaWorkflow();
			return $staticStatusBilansOtwarciaWorkflow->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getStatusBilansOtwarciaNextStatic($parentId) {
			return virgoStatusBilansOtwarcia::getById($parentId);
		}
		
		function getStatusBilansOtwarciaNext() {
			return virgoStatusBilansOtwarciaWorkflow::getStatusBilansOtwarciaNextStatic($this->sbw_sbo_next_id);
		}
		static function getStatusBilansOtwarciaPrevStatic($parentId) {
			return virgoStatusBilansOtwarcia::getById($parentId);
		}
		
		function getStatusBilansOtwarciaPrev() {
			return virgoStatusBilansOtwarciaWorkflow::getStatusBilansOtwarciaPrevStatic($this->sbw_sbo_prev_id);
		}


		function validateObject($virgoOld) {
				if (is_null($this->sbw_sbo_next_id) || trim($this->sbw_sbo_next_id) == "") {
					if (R('create_sbw_statusBilansOtwarciaNext_' . $this->sbw_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'STATUS_BILANS_OTWARCIA', 'NEXT');
					}
			}			
				if (is_null($this->sbw_sbo_prev_id) || trim($this->sbw_sbo_prev_id) == "") {
					if (R('create_sbw_statusBilansOtwarciaPrev_' . $this->sbw_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'STATUS_BILANS_OTWARCIA', 'PREV');
					}
			}			
 		$types = "";
		$values = array();
		$skipUniquenessCheck = false;
			return "";
		}

		static function workflowTransitionAllowed($fromId, $toId) {
			$tmpCheck = new virgoStatusBilansOtwarciaWorkflow();
			$tmpCheck->setSboPrevId($fromId);
			$tmpCheck->setSboNextId($toId);
			$existingArray = $tmpCheck->existingConnections();
			return (count($existingArray) > 0);
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  slk_history_status_bilans_otwarcia_workflows WHERE sbw_id = " . $this->getId();
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
				$colNames = $colNames . ", sbw_sbo_next_id";
				$values = $values . ", " . (is_null($objectToStore->getSboNextId()) || $objectToStore->getSboNextId() == "" ? "null" : $objectToStore->getSboNextId());
				$colNames = $colNames . ", sbw_sbo_prev_id";
				$values = $values . ", " . (is_null($objectToStore->getSboPrevId()) || $objectToStore->getSboPrevId() == "" ? "null" : $objectToStore->getSboPrevId());
				$query = "INSERT INTO slk_history_status_bilans_otwarcia_workflows (revision, ip, username, user_id, timestamp, sbw_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getSboNextId() != $objectToStore->getSboNextId() && ($virgoOld->getSboNextId() != 0 || $objectToStore->getSboNextId() != ""))) { 
				$colNames = $colNames . ", sbw_sbo_next_id";
				$values = $values . ", " . (is_null($objectToStore->getSboNextId()) ? "null" : ($objectToStore->getSboNextId() == "" ? "0" : $objectToStore->getSboNextId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getSboPrevId() != $objectToStore->getSboPrevId() && ($virgoOld->getSboPrevId() != 0 || $objectToStore->getSboPrevId() != ""))) { 
				$colNames = $colNames . ", sbw_sbo_prev_id";
				$values = $values . ", " . (is_null($objectToStore->getSboPrevId()) ? "null" : ($objectToStore->getSboPrevId() == "" ? "0" : $objectToStore->getSboPrevId()));
			}
			$query = "INSERT INTO slk_history_status_bilans_otwarcia_workflows (revision, ip, username, user_id, timestamp, sbw_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM slk_status_bilans_otwarcia_workflows");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'sbw_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE slk_status_bilans_otwarcia_workflows ADD COLUMN (sbw_virgo_title VARCHAR(255));";
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
			if (isset($this->sbw_id) && $this->sbw_id != "") {
				$query = "UPDATE slk_status_bilans_otwarcia_workflows SET ";
				if (isset($this->sbw_sbo_next_id) && trim($this->sbw_sbo_next_id) != "") {
					$query = $query . " sbw_sbo_next_id = ? , ";
					$types = $types . "i";
					$values[] = $this->sbw_sbo_next_id;
				} else {
					$query = $query . " sbw_sbo_next_id = NULL, ";
				}
				if (isset($this->sbw_sbo_prev_id) && trim($this->sbw_sbo_prev_id) != "") {
					$query = $query . " sbw_sbo_prev_id = ? , ";
					$types = $types . "i";
					$values[] = $this->sbw_sbo_prev_id;
				} else {
					$query = $query . " sbw_sbo_prev_id = NULL, ";
				}
				$query = $query . " sbw_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " sbw_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->sbw_date_modified;

				$query = $query . " sbw_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->sbw_usr_modified_id;

				$query = $query . " WHERE sbw_id = ? ";
				$types = $types . "i";
				$values[] = $this->sbw_id;
			} else {
				$query = "INSERT INTO slk_status_bilans_otwarcia_workflows ( ";
				$query = $query . " sbw_sbo_next_id, ";
				$query = $query . " sbw_sbo_prev_id, ";
				$query = $query . " sbw_virgo_title, sbw_date_created, sbw_usr_created_id) VALUES ( ";
				if (isset($this->sbw_sbo_next_id) && trim($this->sbw_sbo_next_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->sbw_sbo_next_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->sbw_sbo_prev_id) && trim($this->sbw_sbo_prev_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->sbw_sbo_prev_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->sbw_date_created;
				$values[] = $this->sbw_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->sbw_id) || $this->sbw_id == "") {
					$this->sbw_id = QID();
				}
				if ($log) {
					L("status bilans otwarcia workflow stored successfully", "id = {$this->sbw_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->sbw_id) {
				$virgoOld = new virgoStatusBilansOtwarciaWorkflow($this->sbw_id);
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
					if ($this->sbw_id) {			
						$this->sbw_date_modified = date("Y-m-d H:i:s");
						$this->sbw_usr_modified_id = $userId;
					} else {
						$this->sbw_date_created = date("Y-m-d H:i:s");
						$this->sbw_usr_created_id = $userId;
					}
					$this->sbw_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "status bilans otwarcia workflow" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "status bilans otwarcia workflow" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM slk_status_bilans_otwarcia_workflows WHERE sbw_id = {$this->sbw_id}";
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
			$tmp = new virgoStatusBilansOtwarciaWorkflow();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT sbw_id as id FROM slk_status_bilans_otwarcia_workflows";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'sbw_order_column')) {
				$orderBy = " ORDER BY sbw_order_column ASC ";
			} 
			if (property_exists($this, 'sbw_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY sbw_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoStatusBilansOtwarciaWorkflow();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoStatusBilansOtwarciaWorkflow($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE slk_status_bilans_otwarcia_workflows SET sbw_virgo_title = '$title' WHERE sbw_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoStatusBilansOtwarciaWorkflow();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" sbw_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['sbw_id'];
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
			virgoStatusBilansOtwarciaWorkflow::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoStatusBilansOtwarciaWorkflow::setSessionValue('Sealock_StatusBilansOtwarciaWorkflow-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoStatusBilansOtwarciaWorkflow::getSessionValue('Sealock_StatusBilansOtwarciaWorkflow-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoStatusBilansOtwarciaWorkflow::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoStatusBilansOtwarciaWorkflow::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoStatusBilansOtwarciaWorkflow::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoStatusBilansOtwarciaWorkflow::getSessionValue('GLOBAL', $name, $default);
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
			$context['sbw_id'] = $id;
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
			$context['sbw_id'] = null;
			virgoStatusBilansOtwarciaWorkflow::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoStatusBilansOtwarciaWorkflow::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoStatusBilansOtwarciaWorkflow::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoStatusBilansOtwarciaWorkflow::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoStatusBilansOtwarciaWorkflow::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoStatusBilansOtwarciaWorkflow::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoStatusBilansOtwarciaWorkflow::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoStatusBilansOtwarciaWorkflow::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoStatusBilansOtwarciaWorkflow::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoStatusBilansOtwarciaWorkflow::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoStatusBilansOtwarciaWorkflow::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoStatusBilansOtwarciaWorkflow::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoStatusBilansOtwarciaWorkflow::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoStatusBilansOtwarciaWorkflow::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoStatusBilansOtwarciaWorkflow::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoStatusBilansOtwarciaWorkflow::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoStatusBilansOtwarciaWorkflow::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "sbw_id";
			}
			return virgoStatusBilansOtwarciaWorkflow::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoStatusBilansOtwarciaWorkflow::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoStatusBilansOtwarciaWorkflow::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoStatusBilansOtwarciaWorkflow::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoStatusBilansOtwarciaWorkflow::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoStatusBilansOtwarciaWorkflow::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoStatusBilansOtwarciaWorkflow::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoStatusBilansOtwarciaWorkflow::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoStatusBilansOtwarciaWorkflow::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoStatusBilansOtwarciaWorkflow::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoStatusBilansOtwarciaWorkflow::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoStatusBilansOtwarciaWorkflow::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoStatusBilansOtwarciaWorkflow::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->sbw_id) {
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
						L(T('STORED_CORRECTLY', 'STATUS_BILANS_OTWARCIA_WORKFLOW'), '', 'INFO');
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
						$parentStatusBilansOtwarcia = new virgoStatusBilansOtwarcia();
						$fieldValues = $fieldValues . T($fieldValue, 'status bilans otwarcia next', $parentStatusBilansOtwarcia->lookup($this->sbw_sbo_next_id));
						$parentStatusBilansOtwarcia = new virgoStatusBilansOtwarcia();
						$fieldValues = $fieldValues . T($fieldValue, 'status bilans otwarcia prev', $parentStatusBilansOtwarcia->lookup($this->sbw_sbo_prev_id));
						$username = '';
						if ($this->sbw_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->sbw_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->sbw_date_created);
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
			$instance = new virgoStatusBilansOtwarciaWorkflow();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoStatusBilansOtwarciaWorkflow'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			$instance = new virgoStatusBilansOtwarciaWorkflow();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			$errorMessage = $instance->internalActionStore(false);
			if ($errorMessage == "") {
				$instance->putInContext(isset($oldId));
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
			$tmpId = intval(R('sbw_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoStatusBilansOtwarciaWorkflow::getContextId();
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
			$this->sbw_id = null;
			$this->sbw_date_created = null;
			$this->sbw_usr_created_id = null;
			$this->sbw_date_modified = null;
			$this->sbw_usr_modified_id = null;
			$this->sbw_virgo_title = null;
			
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

		static function portletActionShowForStatusBilansOtwarciaNext() {
			$parentId = R('sbo_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoStatusBilansOtwarcia($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
			return 0;
		}
		static function portletActionShowForStatusBilansOtwarciaPrev() {
			$parentId = R('sbo_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoStatusBilansOtwarcia($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
			return 0;
		}

		function existingConnections() {
			$where = "";
			if (is_null($this->getStatusBilansOtwarciaNextId())) {
				L('Missing StatusBilansOtwarciaNextId', '', 'ERROR');
			}
			$where = $where . " sbw_sbo_next_id = {$this->getStatusBilansOtwarciaNextId()}";

			if (is_null($this->getStatusBilansOtwarciaPrevId())) {
				L('Missing StatusBilansOtwarciaPrevId', '', 'ERROR');
			}
			$where = $where . " AND sbw_sbo_prev_id = {$this->getStatusBilansOtwarciaPrevId()}";

			return virgoStatusBilansOtwarciaWorkflow::selectAllAsObjectsStatic($where);
		}

		function storeIfNotExists() {
			$res = $this->existingConnections();
			if (count($res) == 0) {
				LE($this->store());
				return $this;
			}
			return $res[0];
		}

		static function portletActionAdd() {
			$portletObject = self::getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("add")) {
			self::removeFromContext();
			self::setDisplayMode("CREATE");
//			$ret = new virgoStatusBilansOtwarciaWorkflow();
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
				$instance = new virgoStatusBilansOtwarciaWorkflow();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoStatusBilansOtwarciaWorkflow::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'STATUS_BILANS_OTWARCIA_WORKFLOW'), '', 'INFO');
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
				$resultStatusBilansOtwarciaWorkflow = new virgoStatusBilansOtwarciaWorkflow();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultStatusBilansOtwarciaWorkflow->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultStatusBilansOtwarciaWorkflow->load($idToEditInt);
					} else {
						$resultStatusBilansOtwarciaWorkflow->sbw_id = 0;
					}
				}
				$results[] = $resultStatusBilansOtwarciaWorkflow;
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
				$result = new virgoStatusBilansOtwarciaWorkflow();
				$result->loadFromRequest($idToStore);
				if ($result->sbw_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->sbw_id == 0) {
						$result->sbw_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->sbw_id)) {
							$result->sbw_id = 0;
						}
						$idsToCorrect[$result->sbw_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'STATUS_BILANS_OTWARCIA_WORKFLOWS'), '', 'INFO');
				}
				self::setDisplayMode("TABLE");
				return 0;
			} else {
				L(T('INVALID_RECORDS', $errors), '', 'ERROR');
				$this->setInvalidRecords($idsToCorrect);
				return -1;
			}
		}

		static function multipleDelete($idsToDelete) {
			$errorOcurred = 0;
			$resultStatusBilansOtwarciaWorkflow = new virgoStatusBilansOtwarciaWorkflow();
			foreach ($idsToDelete as $idToDelete) {
				$resultStatusBilansOtwarciaWorkflow->load((int)trim($idToDelete));
				$res = $resultStatusBilansOtwarciaWorkflow->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'STATUS_BILANS_OTWARCIA_WORKFLOWS'), '', 'INFO');			
				self::setDisplayMode("TABLE");
				return 0;
			} else {
				return -1;
			}
		}

		static function getSelectedIds($name = 'ids') {
			$idsString = R($name);
			if (trim($idsString) == "") {
				return array();
			}
			return preg_split("/,/", $idsString);			
		}
		
		static function portletActionDeleteSelected() {
			$idsToDelete = self::getSelectedIds();
			return self::multipleDelete($idsToDelete);
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
		$ret = $this->sbw_id;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoStatusBilansOtwarciaWorkflow');
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
				$query = "UPDATE slk_status_bilans_otwarcia_workflows SET sbw_virgo_title = ? WHERE sbw_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT sbw_id AS id FROM slk_status_bilans_otwarcia_workflows ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoStatusBilansOtwarciaWorkflow($row['id']);
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
				$class2prefix["sealock\\virgoStatusBilansOtwarcia"] = "sbo";
				$class2prefix2 = array();
				$class2parentPrefix["sealock\\virgoStatusBilansOtwarcia"] = $class2prefix2;
				$class2prefix["sealock\\virgoStatusBilansOtwarcia"] = "sbo";
				$class2prefix2 = array();
				$class2parentPrefix["sealock\\virgoStatusBilansOtwarcia"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'slk_status_bilans_otwarcia_workflows.sbw_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'slk_status_bilans_otwarcia_workflows.sbw_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'slk_status_bilans_otwarcia_workflows.sbw_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM slk_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'slk_status_bilans_otwarcia_workflows.sbw_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoStatusBilansOtwarciaWorkflow!', '', 'ERROR');
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
			$pdf->SetTitle('Status bilans otwarcia workflows report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('STATUS_BILANS_OTWARCIA_WORKFLOWS');
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
			if (P('show_pdf_status_bilans_otwarcianext', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_status_bilans_otwarciaprev', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultStatusBilansOtwarciaWorkflow = new virgoStatusBilansOtwarciaWorkflow();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_status_bilans_otwarcianext', "1") == "1") {
				$minWidth['status bilans otwarcia next'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'status bilans otwarcia next');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['status bilans otwarcia next']) {
						$minWidth['status bilans otwarcia next'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_status_bilans_otwarciaprev', "1") == "1") {
				$minWidth['status bilans otwarcia prev'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'status bilans otwarcia prev');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['status bilans otwarcia prev']) {
						$minWidth['status bilans otwarcia prev'] = min($tmpLen, $maxWidth);
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
			$whereClauseStatusBilansOtwarciaWorkflow = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaStatusBilansOtwarciaWorkflow = $resultStatusBilansOtwarciaWorkflow->getCriteria();
			$parentCriteria = $criteriaStatusBilansOtwarciaWorkflow["status_bilans_otwarcianext"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Status bilans otwarcia', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoStatusBilansOtwarcia::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Status bilans otwarcia', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaStatusBilansOtwarciaWorkflow["status_bilans_otwarciaprev"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Status bilans otwarcia', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoStatusBilansOtwarcia::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Status bilans otwarcia', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_status_bilans_otwarcianext');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_status_bilans_otwarcia_workflows.sbw_sbo_next_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_status_bilans_otwarcia_workflows.sbw_sbo_next_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_status_bilans_otwarciaprev');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_status_bilans_otwarcia_workflows.sbw_sbo_prev_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_status_bilans_otwarcia_workflows.sbw_sbo_prev_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaStatusBilansOtwarciaWorkflow = self::getCriteria();
			if (isset($criteriaStatusBilansOtwarciaWorkflow["status_bilans_otwarcianext"])) {
				$parentCriteria = $criteriaStatusBilansOtwarciaWorkflow["status_bilans_otwarcianext"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND sbw_sbo_next_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND slk_status_bilans_otwarcia_workflows.sbw_sbo_next_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			if (isset($criteriaStatusBilansOtwarciaWorkflow["status_bilans_otwarciaprev"])) {
				$parentCriteria = $criteriaStatusBilansOtwarciaWorkflow["status_bilans_otwarciaprev"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND sbw_sbo_prev_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND slk_status_bilans_otwarcia_workflows.sbw_sbo_prev_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT slk_status_bilans_otwarcia_workflows.sbw_id, slk_status_bilans_otwarcia_workflows.sbw_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (class_exists('sealock\virgoStatusBilansOtwarcia') && P('show_pdf_status_bilans_otwarcianext', "1") != "0") { // */ && !in_array("sbonext", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_status_bilans_otwarcia_workflows.sbw_sbo_next_id as sbw_sbw_sbo_next_id ";
				$queryString = $queryString . ", slk_statusy_bilans_otwarcia_next.sbo_virgo_title as status_bilans_otwarcia_next ";
			} else {
				if ($defaultOrderColumn == "status_bilans_otwarcia_next") {
					$orderColumnNotDisplayed = " slk_statusy_bilans_otwarcia_next.sbo_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoStatusBilansOtwarcia') && P('show_pdf_status_bilans_otwarciaprev', "1") != "0") { // */ && !in_array("sboprev", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_status_bilans_otwarcia_workflows.sbw_sbo_prev_id as sbw_sbw_sbo_prev_id ";
				$queryString = $queryString . ", slk_statusy_bilans_otwarcia_prev.sbo_virgo_title as status_bilans_otwarcia_prev ";
			} else {
				if ($defaultOrderColumn == "status_bilans_otwarcia_prev") {
					$orderColumnNotDisplayed = " slk_statusy_bilans_otwarcia_prev.sbo_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_status_bilans_otwarcia_workflows ";
			if (class_exists('sealock\virgoStatusBilansOtwarcia')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_statusy_bilans_otwarcia AS slk_statusy_bilans_otwarcia_next ON (slk_status_bilans_otwarcia_workflows.sbw_sbo_next_id = slk_statusy_bilans_otwarcia_next.sbo_id) ";
			}
			if (class_exists('sealock\virgoStatusBilansOtwarcia')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_statusy_bilans_otwarcia AS slk_statusy_bilans_otwarcia_prev ON (slk_status_bilans_otwarcia_workflows.sbw_sbo_prev_id = slk_statusy_bilans_otwarcia_prev.sbo_id) ";
			}

		$resultsStatusBilansOtwarciaWorkflow = $resultStatusBilansOtwarciaWorkflow->select(
			'', 
			'all', 
			$resultStatusBilansOtwarciaWorkflow->getOrderColumn(), 
			$resultStatusBilansOtwarciaWorkflow->getOrderMode(), 
			$whereClauseStatusBilansOtwarciaWorkflow,
			$queryString);
		
		foreach ($resultsStatusBilansOtwarciaWorkflow as $resultStatusBilansOtwarciaWorkflow) {
			if (P('show_pdf_status_bilans_otwarcianext', "1") == "1") {
			$parentValue = trim(virgoStatusBilansOtwarcia::lookup($resultStatusBilansOtwarciaWorkflow['sbw_sbo_next_id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['status bilans otwarcia next']) {
					$minWidth['status bilans otwarcia next'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_status_bilans_otwarciaprev', "1") == "1") {
			$parentValue = trim(virgoStatusBilansOtwarcia::lookup($resultStatusBilansOtwarciaWorkflow['sbw_sbo_prev_id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['status bilans otwarcia prev']) {
					$minWidth['status bilans otwarcia prev'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaStatusBilansOtwarciaWorkflow = $resultStatusBilansOtwarciaWorkflow->getCriteria();
		if (is_null($criteriaStatusBilansOtwarciaWorkflow) || sizeof($criteriaStatusBilansOtwarciaWorkflow) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																						if (P('show_pdf_status_bilans_otwarcianext', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['status bilans otwarcia next'], $colHeight, T('STATUS_BILANS_OTWARCIA') . ' ' . T('NEXT'), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_status_bilans_otwarciaprev', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['status bilans otwarcia prev'], $colHeight, T('STATUS_BILANS_OTWARCIA') . ' ' . T('PREV'), 'T', 'C', 0, 0); 
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
		foreach ($resultsStatusBilansOtwarciaWorkflow as $resultStatusBilansOtwarciaWorkflow) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_status_bilans_otwarcianext', "1") == "1") {
			$parentValue = virgoStatusBilansOtwarcia::lookup($resultStatusBilansOtwarciaWorkflow['sbw_sbo_next_id']);
			$tmpLn = $pdf->MultiCell($minWidth['status bilans otwarcia next'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_status_bilans_otwarciaprev', "1") == "1") {
			$parentValue = virgoStatusBilansOtwarcia::lookup($resultStatusBilansOtwarciaWorkflow['sbw_sbo_prev_id']);
			$tmpLn = $pdf->MultiCell($minWidth['status bilans otwarcia prev'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
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
		}
		$pdf->Ln();
		if (sizeof($sums) > 0) {
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			$tmpWidth = 0;
			$labelDone = false;
		}
		$pdf->Ln();
		if (sizeof($avgCounts) > 0 && sizeof($avgSums) > 0) {
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			$tmpWidth = 0;
			$labelDone = false;
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
				$reportTitle = T('STATUS_BILANS_OTWARCIA_WORKFLOWS');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultStatusBilansOtwarciaWorkflow = new virgoStatusBilansOtwarciaWorkflow();
			$whereClauseStatusBilansOtwarciaWorkflow = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_status_bilans_otwarcianext', "1") != "0") {
					$data = $data . $stringDelimeter . 'Status bilans otwarcia Next' . $stringDelimeter . $separator;
				}
				if (P('show_export_status_bilans_otwarciaprev', "1") != "0") {
					$data = $data . $stringDelimeter . 'Status bilans otwarcia Prev' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_status_bilans_otwarcia_workflows.sbw_id, slk_status_bilans_otwarcia_workflows.sbw_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (class_exists('sealock\virgoStatusBilansOtwarcia') && P('show_export_status_bilans_otwarcianext', "1") != "0") { // */ && !in_array("sbonext", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_status_bilans_otwarcia_workflows.sbw_sbo_next_id as sbw_sbw_sbo_next_id ";
				$queryString = $queryString . ", slk_statusy_bilans_otwarcia_next.sbo_virgo_title as status_bilans_otwarcia_next ";
			} else {
				if ($defaultOrderColumn == "status_bilans_otwarcia_next") {
					$orderColumnNotDisplayed = " slk_statusy_bilans_otwarcia_next.sbo_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoStatusBilansOtwarcia') && P('show_export_status_bilans_otwarciaprev', "1") != "0") { // */ && !in_array("sboprev", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_status_bilans_otwarcia_workflows.sbw_sbo_prev_id as sbw_sbw_sbo_prev_id ";
				$queryString = $queryString . ", slk_statusy_bilans_otwarcia_prev.sbo_virgo_title as status_bilans_otwarcia_prev ";
			} else {
				if ($defaultOrderColumn == "status_bilans_otwarcia_prev") {
					$orderColumnNotDisplayed = " slk_statusy_bilans_otwarcia_prev.sbo_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_status_bilans_otwarcia_workflows ";
			if (class_exists('sealock\virgoStatusBilansOtwarcia')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_statusy_bilans_otwarcia AS slk_statusy_bilans_otwarcia_next ON (slk_status_bilans_otwarcia_workflows.sbw_sbo_next_id = slk_statusy_bilans_otwarcia_next.sbo_id) ";
			}
			if (class_exists('sealock\virgoStatusBilansOtwarcia')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_statusy_bilans_otwarcia AS slk_statusy_bilans_otwarcia_prev ON (slk_status_bilans_otwarcia_workflows.sbw_sbo_prev_id = slk_statusy_bilans_otwarcia_prev.sbo_id) ";
			}

			$resultsStatusBilansOtwarciaWorkflow = $resultStatusBilansOtwarciaWorkflow->select(
				'', 
				'all', 
				$resultStatusBilansOtwarciaWorkflow->getOrderColumn(), 
				$resultStatusBilansOtwarciaWorkflow->getOrderMode(), 
				$whereClauseStatusBilansOtwarciaWorkflow,
				$queryString);
			foreach ($resultsStatusBilansOtwarciaWorkflow as $resultStatusBilansOtwarciaWorkflow) {
				if (P('show_export_status_bilans_otwarcianext', "1") != "0") {
					$parentValue = virgoStatusBilansOtwarcia::lookup($resultStatusBilansOtwarciaWorkflow['sbw_sbo_next_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_status_bilans_otwarciaprev', "1") != "0") {
					$parentValue = virgoStatusBilansOtwarcia::lookup($resultStatusBilansOtwarciaWorkflow['sbw_sbo_prev_id']);
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
				$reportTitle = T('STATUS_BILANS_OTWARCIA_WORKFLOWS');
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
			$resultStatusBilansOtwarciaWorkflow = new virgoStatusBilansOtwarciaWorkflow();
			$whereClauseStatusBilansOtwarciaWorkflow = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseStatusBilansOtwarciaWorkflow = $whereClauseStatusBilansOtwarciaWorkflow . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_status_bilans_otwarcianext', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Status bilans otwarcia Next');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoStatusBilansOtwarcia::getVirgoList();
					$formulaStatusBilansOtwarciaNext = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaStatusBilansOtwarciaNext != "") {
							$formulaStatusBilansOtwarciaNext = $formulaStatusBilansOtwarciaNext . ',';
						}
						$formulaStatusBilansOtwarciaNext = $formulaStatusBilansOtwarciaNext . $key;
					}
				}
				if (P('show_export_status_bilans_otwarciaprev', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Status bilans otwarcia Prev');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoStatusBilansOtwarcia::getVirgoList();
					$formulaStatusBilansOtwarciaPrev = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaStatusBilansOtwarciaPrev != "") {
							$formulaStatusBilansOtwarciaPrev = $formulaStatusBilansOtwarciaPrev . ',';
						}
						$formulaStatusBilansOtwarciaPrev = $formulaStatusBilansOtwarciaPrev . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_status_bilans_otwarcia_workflows.sbw_id, slk_status_bilans_otwarcia_workflows.sbw_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (class_exists('sealock\virgoStatusBilansOtwarcia') && P('show_export_status_bilans_otwarcianext', "1") != "0") { // */ && !in_array("sbonext", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_status_bilans_otwarcia_workflows.sbw_sbo_next_id as sbw_sbw_sbo_next_id ";
				$queryString = $queryString . ", slk_statusy_bilans_otwarcia_next.sbo_virgo_title as status_bilans_otwarcia_next ";
			} else {
				if ($defaultOrderColumn == "status_bilans_otwarcia_next") {
					$orderColumnNotDisplayed = " slk_statusy_bilans_otwarcia_next.sbo_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoStatusBilansOtwarcia') && P('show_export_status_bilans_otwarciaprev', "1") != "0") { // */ && !in_array("sboprev", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_status_bilans_otwarcia_workflows.sbw_sbo_prev_id as sbw_sbw_sbo_prev_id ";
				$queryString = $queryString . ", slk_statusy_bilans_otwarcia_prev.sbo_virgo_title as status_bilans_otwarcia_prev ";
			} else {
				if ($defaultOrderColumn == "status_bilans_otwarcia_prev") {
					$orderColumnNotDisplayed = " slk_statusy_bilans_otwarcia_prev.sbo_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_status_bilans_otwarcia_workflows ";
			if (class_exists('sealock\virgoStatusBilansOtwarcia')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_statusy_bilans_otwarcia AS slk_statusy_bilans_otwarcia_next ON (slk_status_bilans_otwarcia_workflows.sbw_sbo_next_id = slk_statusy_bilans_otwarcia_next.sbo_id) ";
			}
			if (class_exists('sealock\virgoStatusBilansOtwarcia')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_statusy_bilans_otwarcia AS slk_statusy_bilans_otwarcia_prev ON (slk_status_bilans_otwarcia_workflows.sbw_sbo_prev_id = slk_statusy_bilans_otwarcia_prev.sbo_id) ";
			}

			$resultsStatusBilansOtwarciaWorkflow = $resultStatusBilansOtwarciaWorkflow->select(
				'', 
				'all', 
				$resultStatusBilansOtwarciaWorkflow->getOrderColumn(), 
				$resultStatusBilansOtwarciaWorkflow->getOrderMode(), 
				$whereClauseStatusBilansOtwarciaWorkflow,
				$queryString);
			$index = 1;
			foreach ($resultsStatusBilansOtwarciaWorkflow as $resultStatusBilansOtwarciaWorkflow) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultStatusBilansOtwarciaWorkflow['sbw_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_status_bilans_otwarcianext', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoStatusBilansOtwarcia::lookup($resultStatusBilansOtwarciaWorkflow['sbw_sbo_next_id']);
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
					$objValidation->setFormula1('"' . $formulaStatusBilansOtwarciaNext . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
				if (P('show_export_status_bilans_otwarciaprev', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoStatusBilansOtwarcia::lookup($resultStatusBilansOtwarciaWorkflow['sbw_sbo_prev_id']);
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
					$objValidation->setFormula1('"' . $formulaStatusBilansOtwarciaPrev . '"');
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
					$propertyClassHash['status bilans otwarcia'] = 'StatusBilansOtwarcia';
					$propertyClassHash['status_bilans_otwarcia'] = 'StatusBilansOtwarcia';
					$propertyColumnHash['status bilans otwarcia next'] = 'sbw_sbo_next_id';
					$propertyColumnHash['status_bilans_otwarcia next'] = 'sbw_sbo_next_id';
					$propertyClassHash['status bilans otwarcia'] = 'StatusBilansOtwarcia';
					$propertyClassHash['status_bilans_otwarcia'] = 'StatusBilansOtwarcia';
					$propertyColumnHash['status bilans otwarcia prev'] = 'sbw_sbo_prev_id';
					$propertyColumnHash['status_bilans_otwarcia prev'] = 'sbw_sbo_prev_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importStatusBilansOtwarciaWorkflow = new virgoStatusBilansOtwarciaWorkflow();
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
										L(T('PROPERTY_NOT_FOUND', T('STATUS_BILANS_OTWARCIA_WORKFLOW'), $columns[$index]), '', 'ERROR');
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
										$importStatusBilansOtwarciaWorkflow->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_status_bilans_otwarcianext');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoStatusBilansOtwarcia::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoStatusBilansOtwarcia::token2Id($tmpToken);
	}
	$importStatusBilansOtwarciaWorkflow->setSboNextId($defaultValue);
}
$defaultValue = P('import_default_value_status_bilans_otwarciaprev');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoStatusBilansOtwarcia::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoStatusBilansOtwarcia::token2Id($tmpToken);
	}
	$importStatusBilansOtwarciaWorkflow->setSboPrevId($defaultValue);
}
							$errorMessage = $importStatusBilansOtwarciaWorkflow->store();
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
		

		static function portletActionVirgoChangeStatusBilansOtwarciaNext() {
			$instance = new virgoStatusBilansOtwarciaWorkflow();
			$instance->loadFromDB();
			self::portletActionSelect(true, $instance->getId());
			$parentId = R('virgo_parent_id');
			$parent = virgoStatusBilansOtwarcia::getById($parentId);
			$title = $parent->getVirgoTitle();
			if (!is_null($title) && trim($title) != "") {
				$instance->setSboNextId($parentId);
				$errorMessage = $instance->store();
				if ($errorMessage == "") {
					L(T('PARENT_SET', T('STATUS_BILANS_OTWARCIA'), $title), '', 'INFO');
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
		static function portletActionVirgoChangeStatusBilansOtwarciaPrev() {
			$instance = new virgoStatusBilansOtwarciaWorkflow();
			$instance->loadFromDB();
			self::portletActionSelect(true, $instance->getId());
			$parentId = R('virgo_parent_id');
			$parent = virgoStatusBilansOtwarcia::getById($parentId);
			$title = $parent->getVirgoTitle();
			if (!is_null($title) && trim($title) != "") {
				$instance->setSboPrevId($parentId);
				$errorMessage = $instance->store();
				if ($errorMessage == "") {
					L(T('PARENT_SET', T('STATUS_BILANS_OTWARCIA'), $title), '', 'INFO');
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



		static function portletActionVirgoSetStatusBilansOtwarciaNext() {
			$this->loadFromDB();
			$parentId = R('sbw_StatusBilansOtwarciaNext_id_' . $_SESSION['current_portlet_object_id']);
			$this->setSboNextId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetStatusBilansOtwarciaPrev() {
			$this->loadFromDB();
			$parentId = R('sbw_StatusBilansOtwarciaPrev_id_' . $_SESSION['current_portlet_object_id']);
			$this->setSboPrevId($parentId);
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
CREATE TABLE IF NOT EXISTS `slk_status_bilans_otwarcia_workflows` (
  `sbw_id` bigint(20) unsigned NOT NULL auto_increment,
  `sbw_virgo_state` varchar(50) default NULL,
  `sbw_virgo_title` varchar(255) default NULL,
	`sbw_sbo_next_id` int(11) default NULL,
	`sbw_sbo_prev_id` int(11) default NULL,
  `sbw_date_created` datetime NOT NULL,
  `sbw_date_modified` datetime default NULL,
  `sbw_usr_created_id` int(11) NOT NULL,
  `sbw_usr_modified_id` int(11) default NULL,
  KEY `sbw_sbo_next_fk` (`sbw_sbo_next_id`),
  KEY `sbw_sbo_prev_fk` (`sbw_sbo_prev_id`),
  PRIMARY KEY  (`sbw_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/status_bilans_otwarcia_workflow.sql 
INSERT INTO `slk_status_bilans_otwarcia_workflows` (`sbw_virgo_title`) 
VALUES (title);
*/
SELECT;
			if (!Q($query)) {
				L("Probably slk_status_bilans_otwarcia_workflows table already exists.", '', 'FATAL');
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
			return "sbw";
		}
		
		static function getPlural() {
			return "status_bilans_otwarcia_workflows";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoStatusBilansOtwarcia";
			$ret[] = "virgoStatusBilansOtwarcia";
			return $ret;
		}

		static function getChildren() {
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'slk_status_bilans_otwarcia_workflows'));
			foreach ($rows as $row) {
				return $row['table_type'];
			}
			return "";
		}
		
		static function getStructureVersion() {
			return "1.4" . 
''
			;
		}
		
		static function getVirgoVersion() {
			return
"2.0.0.0"  
			;
		}
		
		static function checkCompatibility() {
			$virgoVersion = virgoStatusBilansOtwarciaWorkflow::getVirgoVersion();
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
	
	

