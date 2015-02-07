<?php
/**
* Module Produkt
* @package Sealock
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace sealock;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoTowar'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoWydanie'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoPozycjaDokumentu'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoProdukt {

		 private  $prd_id = null;
		 private  $prd_partia_produkcyjna = null;

		 private  $prd_stan = null;

		 private  $prd_twr_id = null;

		 private   $prd_date_created = null;
		 private   $prd_usr_created_id = null;
		 private   $prd_date_modified = null;
		 private   $prd_usr_modified_id = null;
		 private   $prd_virgo_title = null;
		
		 private   $internalLog = null;		
				
		 private  function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		public function isDeletedVirgo() {
			return $this->prd_virgo_deleted;
		}

		static public function createGuiAware() {
			$ret = new virgoProdukt();
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
        	$this->prd_id = null;
		    $this->prd_date_created = null;
		    $this->prd_usr_created_id = null;
		    $this->prd_date_modified = null;
		    $this->prd_usr_modified_id = null;
		    $this->prd_virgo_title = null;
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
			return $this->prd_id;
		}

		function getPartiaProdukcyjna() {
			return $this->prd_partia_produkcyjna;
		}
		
		 private  function setPartiaProdukcyjna($val) {
			$this->prd_partia_produkcyjna = $val;
		}
		function getStan() {
			return $this->prd_stan;
		}
		
		 private  function setStan($val) {
			$this->prd_stan = $val;
		}

		function getTowarId() {
			return $this->prd_twr_id;
		}
		
		 private  function setTowarId($val) {
			$this->prd_twr_id = $val;
		}

		function getDateCreated() {
			return $this->prd_date_created;
		}
		function getUsrCreatedId() {
			return $this->prd_usr_created_id;
		}
		function getDateModified() {
			return $this->prd_date_modified;
		}
		function getUsrModifiedId() {
			return $this->prd_usr_modified_id;
		}


		function getTwrId() {
			return $this->getTowarId();
		}
		
		 private  function setTwrId($val) {
			$this->setTowarId($val);
		}

		function loadRecordFromRequest($rowId) {
			$this->prd_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('prd_partiaProdukcyjna_' . $this->prd_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->prd_partia_produkcyjna = null;
		} else {
			$this->prd_partia_produkcyjna = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('prd_stan_' . $this->prd_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->prd_stan = null;
		} else {
			$this->prd_stan = $tmpValue;
		}
	}
			$this->prd_twr_id = strval(R('prd_towar_' . $this->prd_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('prd_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaProdukt = array();	
			$criteriaFieldProdukt = array();	
			$isNullProdukt = R('virgo_search_partiaProdukcyjna_is_null');
			
			$criteriaFieldProdukt["is_null"] = 0;
			if ($isNullProdukt == "not_null") {
				$criteriaFieldProdukt["is_null"] = 1;
			} elseif ($isNullProdukt == "null") {
				$criteriaFieldProdukt["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_partiaProdukcyjna');

//			if ($isSet) {
			$criteriaFieldProdukt["value"] = $dataTypeCriteria;
//			}
			$criteriaProdukt["partia_produkcyjna"] = $criteriaFieldProdukt;
			$criteriaFieldProdukt = array();	
			$isNullProdukt = R('virgo_search_stan_is_null');
			
			$criteriaFieldProdukt["is_null"] = 0;
			if ($isNullProdukt == "not_null") {
				$criteriaFieldProdukt["is_null"] = 1;
			} elseif ($isNullProdukt == "null") {
				$criteriaFieldProdukt["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_stan_from');
		$dataTypeCriteria["to"] = R('virgo_search_stan_to');

//			if ($isSet) {
			$criteriaFieldProdukt["value"] = $dataTypeCriteria;
//			}
			$criteriaProdukt["stan"] = $criteriaFieldProdukt;
			$criteriaParent = array();	
			$isNull = R('virgo_search_towar_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_towar', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaProdukt["towar"] = $criteriaParent;
			self::setCriteria($criteriaProdukt);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_partia_produkcyjna');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterPartiaProdukcyjna', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterPartiaProdukcyjna', null);
			}
			$tableFilter = R('virgo_filter_stan');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterStan', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterStan', null);
			}
			$parentFilter = R('virgo_filter_towar');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTowar', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTowar', null);
			}
			$parentFilter = R('virgo_filter_title_towar');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleTowar', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleTowar', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseProdukt = ' 1 = 1 ';
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
				$eventColumn = "prd_" . P('event_column');
				$whereClauseProdukt = $whereClauseProdukt . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseProdukt = $whereClauseProdukt . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_towar');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_produkty.prd_twr_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_produkty.prd_twr_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseProdukt = $whereClauseProdukt . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaProdukt = self::getCriteria();
			if (isset($criteriaProdukt["partia_produkcyjna"])) {
				$fieldCriteriaPartiaProdukcyjna = $criteriaProdukt["partia_produkcyjna"];
				if ($fieldCriteriaPartiaProdukcyjna["is_null"] == 1) {
$filter = $filter . ' AND slk_produkty.prd_partia_produkcyjna IS NOT NULL ';
				} elseif ($fieldCriteriaPartiaProdukcyjna["is_null"] == 2) {
$filter = $filter . ' AND slk_produkty.prd_partia_produkcyjna IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaPartiaProdukcyjna["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_produkty.prd_partia_produkcyjna like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaProdukt["stan"])) {
				$fieldCriteriaStan = $criteriaProdukt["stan"];
				if ($fieldCriteriaStan["is_null"] == 1) {
$filter = $filter . ' AND slk_produkty.prd_stan IS NOT NULL ';
				} elseif ($fieldCriteriaStan["is_null"] == 2) {
$filter = $filter . ' AND slk_produkty.prd_stan IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaStan["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND slk_produkty.prd_stan = ? ";
				} else {
					$filter = $filter . " AND slk_produkty.prd_stan >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_produkty.prd_stan <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaProdukt["towar"])) {
				$parentCriteria = $criteriaProdukt["towar"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND prd_twr_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_produkty.prd_twr_id IN (SELECT twr_id FROM slk_towary WHERE twr_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseProdukt = $whereClauseProdukt . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseProdukt = $whereClauseProdukt . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseProdukt = $whereClauseProdukt . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterPartiaProdukcyjna', null);
				if (S($tableFilter)) {
					$whereClauseProdukt = $whereClauseProdukt . " AND prd_partia_produkcyjna LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterStan', null);
				if (S($tableFilter)) {
					$whereClauseProdukt = $whereClauseProdukt . " AND prd_stan LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTowar', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseProdukt = $whereClauseProdukt . " AND prd_twr_id IS NULL ";
					} else {
						$whereClauseProdukt = $whereClauseProdukt . " AND prd_twr_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleTowar', null);
				if (S($parentFilter)) {
					$whereClauseProdukt = $whereClauseProdukt . " AND slk_towary_parent.twr_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClauseProdukt;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseProdukt = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT slk_produkty.prd_id, slk_produkty.prd_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_partia_produkcyjna', "1") != "0") {
				$queryString = $queryString . ", slk_produkty.prd_partia_produkcyjna prd_partia_produkcyjna";
			} else {
				if ($defaultOrderColumn == "prd_partia_produkcyjna") {
					$orderColumnNotDisplayed = " slk_produkty.prd_partia_produkcyjna ";
				}
			}
			if (P('show_table_stan', "1") != "0") {
				$queryString = $queryString . ", slk_produkty.prd_stan prd_stan";
			} else {
				if ($defaultOrderColumn == "prd_stan") {
					$orderColumnNotDisplayed = " slk_produkty.prd_stan ";
				}
			}
			if (class_exists('sealock\virgoTowar') && P('show_table_towar', "1") != "0") { // */ && !in_array("twr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_produkty.prd_twr_id as prd_twr_id ";
				$queryString = $queryString . ", slk_towary_parent.twr_virgo_title as `towar` ";
			} else {
				if ($defaultOrderColumn == "towar") {
					$orderColumnNotDisplayed = " slk_towary_parent.twr_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_produkty ";
			if (class_exists('sealock\virgoTowar')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_towary AS slk_towary_parent ON (slk_produkty.prd_twr_id = slk_towary_parent.twr_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseProdukt = $whereClauseProdukt . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseProdukt, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseProdukt,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM slk_produkty"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " prd_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " prd_usr_created_id = ? ";
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
				. "\n FROM slk_produkty"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as slk_produkty ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as slk_produkty ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, prd_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " prd_usr_created_id = ? ";
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
				$query = "SELECT COUNT(prd_id) cnt FROM produkty";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as produkty ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as produkty ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoProdukt();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM slk_produkty WHERE prd_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->prd_id = $row['prd_id'];
$this->prd_partia_produkcyjna = $row['prd_partia_produkcyjna'];
$this->prd_stan = $row['prd_stan'];
						$this->prd_twr_id = $row['prd_twr_id'];
						if ($fetchUsernames) {
							if ($row['prd_date_created']) {
								if ($row['prd_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['prd_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['prd_date_modified']) {
								if ($row['prd_usr_modified_id'] == $row['prd_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['prd_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['prd_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->prd_date_created = $row['prd_date_created'];
						$this->prd_usr_created_id = $fetchUsernames ? $createdBy : $row['prd_usr_created_id'];
						$this->prd_date_modified = $row['prd_date_modified'];
						$this->prd_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['prd_usr_modified_id'];
						$this->prd_virgo_title = $row['prd_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE slk_produkty SET prd_usr_created_id = {$userId} WHERE prd_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->prd_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoProdukt::selectAllAsObjectsStatic('prd_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->prd_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->prd_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('prd_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_prd = new virgoProdukt();
				$tmp_prd->load((int)$lookup_id);
				return $tmp_prd->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoProdukt');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" prd_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoProdukt', "10");
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
				$query = $query . " prd_id as id, prd_virgo_title as title ";
			}
			$query = $query . " FROM slk_produkty ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoProdukt', 'sealock') == "1") {
				$privateCondition = " prd_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY prd_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resProdukt = array();
				foreach ($rows as $row) {
					$resProdukt[$row['id']] = $row['title'];
				}
				return $resProdukt;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticProdukt = new virgoProdukt();
			return $staticProdukt->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getTowarStatic($parentId) {
			return virgoTowar::getById($parentId);
		}
		
		function getTowar() {
			return virgoProdukt::getTowarStatic($this->prd_twr_id);
		}

		static function getWydaniaStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resWydanie = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoWydanie'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resWydanie;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resWydanie;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsWydanie = virgoWydanie::selectAll('wdn_prd_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsWydanie as $resultWydanie) {
				$tmpWydanie = virgoWydanie::getById($resultWydanie['wdn_id']); 
				array_push($resWydanie, $tmpWydanie);
			}
			return $resWydanie;
		}

		function getWydania($orderBy = '', $extraWhere = null) {
			return virgoProdukt::getWydaniaStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getPozycjeDokumentowStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resPozycjaDokumentu = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoPozycjaDokumentu'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resPozycjaDokumentu;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resPozycjaDokumentu;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsPozycjaDokumentu = virgoPozycjaDokumentu::selectAll('pdk_prd_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPozycjaDokumentu as $resultPozycjaDokumentu) {
				$tmpPozycjaDokumentu = virgoPozycjaDokumentu::getById($resultPozycjaDokumentu['pdk_id']); 
				array_push($resPozycjaDokumentu, $tmpPozycjaDokumentu);
			}
			return $resPozycjaDokumentu;
		}

		function getPozycjeDokumentow($orderBy = '', $extraWhere = null) {
			return virgoProdukt::getPozycjeDokumentowStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
			if (
(is_null($this->getPartiaProdukcyjna()) || trim($this->getPartiaProdukcyjna()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'PARTIA_PRODUKCYJNA');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_stan_obligatory', "0") == "1") {
				if (
(is_null($this->getStan()) || trim($this->getStan()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'STAN');
				}			
			}
				if (is_null($this->prd_twr_id) || trim($this->prd_twr_id) == "") {
					if (R('create_prd_towar_' . $this->prd_id) == "1") { 
						$parent = new virgoTowar();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->prd_twr_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'TOWAR', '');
					}
			}			
 			if (!is_null($this->prd_stan) && trim($this->prd_stan) != "") {
				if (!is_numeric($this->prd_stan)) {
					return T('INCORRECT_NUMBER', 'STAN', $this->prd_stan);
				}
			}
		$types = "";
		$values = array();
		$skipUniquenessCheck = false;
		$uniqnessWhere = " 1 = 1 ";
		if (!is_null($this->prd_id) && $this->prd_id != 0) {
			$uniqnessWhere = " prd_id != " . $this->prd_id . " ";			
		}
 		if (!$skipUniquenessCheck) {
 			if (!$skipUniquenessCheck) {
			$uniqnessWhere = $uniqnessWhere . ' AND UPPER(prd_partia_produkcyjna) = UPPER(?) ';
			$types .= "s";
			$values[] = $this->prd_partia_produkcyjna;
			}
 		}	
 		if (!$skipUniquenessCheck) {	
			$query = " SELECT COUNT(*) FROM slk_produkty ";
			$query = $query . " WHERE " . $uniqnessWhere;
			$result = QPL($query, $types, $values);
			if ($result[0] > 0) {
				$valeus = array();
				$colNames = array();
				$colNames[] = T('PARTIA_PRODUKCYJNA');
				$values[] = $this->prd_partia_produkcyjna; 
				return T('UNIQNESS_FAILED', 'PRODUKT', implode(', ', $colNames), implode(', ', $values));
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  slk_history_produkty WHERE prd_id = " . $this->getId();
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
				$colNames = $colNames . ", prd_partia_produkcyjna";
				$values = $values . ", " . (is_null($objectToStore->getPartiaProdukcyjna()) ? "null" : "'" . QE($objectToStore->getPartiaProdukcyjna()) . "'");
				$colNames = $colNames . ", prd_stan";
				$values = $values . ", " . (is_null($objectToStore->getStan()) ? "null" : "'" . QE($objectToStore->getStan()) . "'");
				$colNames = $colNames . ", prd_twr_id";
				$values = $values . ", " . (is_null($objectToStore->getTwrId()) || $objectToStore->getTwrId() == "" ? "null" : $objectToStore->getTwrId());
				$query = "INSERT INTO slk_history_produkty (revision, ip, username, user_id, timestamp, prd_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getPartiaProdukcyjna() != $objectToStore->getPartiaProdukcyjna()) {
				if (is_null($objectToStore->getPartiaProdukcyjna())) {
					$nullifiedProperties = $nullifiedProperties . "partia_produkcyjna,";
				} else {
				$colNames = $colNames . ", prd_partia_produkcyjna";
				$values = $values . ", " . (is_null($objectToStore->getPartiaProdukcyjna()) ? "null" : "'" . QE($objectToStore->getPartiaProdukcyjna()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getStan() != $objectToStore->getStan()) {
				if (is_null($objectToStore->getStan())) {
					$nullifiedProperties = $nullifiedProperties . "stan,";
				} else {
				$colNames = $colNames . ", prd_stan";
				$values = $values . ", " . (is_null($objectToStore->getStan()) ? "null" : "'" . QE($objectToStore->getStan()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getTwrId() != $objectToStore->getTwrId() && ($virgoOld->getTwrId() != 0 || $objectToStore->getTwrId() != ""))) { 
				$colNames = $colNames . ", prd_twr_id";
				$values = $values . ", " . (is_null($objectToStore->getTwrId()) ? "null" : ($objectToStore->getTwrId() == "" ? "0" : $objectToStore->getTwrId()));
			}
			$query = "INSERT INTO slk_history_produkty (revision, ip, username, user_id, timestamp, prd_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM slk_produkty");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'prd_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE slk_produkty ADD COLUMN (prd_virgo_title VARCHAR(255));";
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
			if (isset($this->prd_id) && $this->prd_id != "") {
				$query = "UPDATE slk_produkty SET ";
			if (isset($this->prd_partia_produkcyjna)) {
				$query .= " prd_partia_produkcyjna = ? ,";
				$types .= "s";
				$values[] = $this->prd_partia_produkcyjna;
			} else {
				$query .= " prd_partia_produkcyjna = NULL ,";				
			}
			if (isset($this->prd_stan)) {
				$query .= " prd_stan = ? ,";
				$types .= "i";
				$values[] = $this->prd_stan;
			} else {
				$query .= " prd_stan = NULL ,";				
			}
				if (isset($this->prd_twr_id) && trim($this->prd_twr_id) != "") {
					$query = $query . " prd_twr_id = ? , ";
					$types = $types . "i";
					$values[] = $this->prd_twr_id;
				} else {
					$query = $query . " prd_twr_id = NULL, ";
				}
				$query = $query . " prd_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " prd_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->prd_date_modified;

				$query = $query . " prd_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->prd_usr_modified_id;

				$query = $query . " WHERE prd_id = ? ";
				$types = $types . "i";
				$values[] = $this->prd_id;
			} else {
				$query = "INSERT INTO slk_produkty ( ";
			$query = $query . " prd_partia_produkcyjna, ";
			$query = $query . " prd_stan, ";
				$query = $query . " prd_twr_id, ";
				$query = $query . " prd_virgo_title, prd_date_created, prd_usr_created_id) VALUES ( ";
			if (isset($this->prd_partia_produkcyjna)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->prd_partia_produkcyjna;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->prd_stan)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->prd_stan;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->prd_twr_id) && trim($this->prd_twr_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->prd_twr_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->prd_date_created;
				$values[] = $this->prd_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->prd_id) || $this->prd_id == "") {
					$this->prd_id = QID();
				}
				if ($log) {
					L("produkt stored successfully", "id = {$this->prd_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->prd_id) {
				$virgoOld = new virgoProdukt($this->prd_id);
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
					if ($this->prd_id) {			
						$this->prd_date_modified = date("Y-m-d H:i:s");
						$this->prd_usr_modified_id = $userId;
					} else {
						$this->prd_date_created = date("Y-m-d H:i:s");
						$this->prd_usr_created_id = $userId;
					}
					$this->prd_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "produkt" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "produkt" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM slk_produkty WHERE prd_id = {$this->prd_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			$list = $this->getWydania();
			if (sizeof($list) > 0) {
				foreach ($list as $childRecord) {
					$childRecord->delete();
				}
			}
			$list = $this->getPozycjeDokumentow();
			if (sizeof($list) > 0) {
				$name = $this->getVirgoTitle();
				if (!is_null($name) && trim($name) != "") {
					$name = "'" . $name . "' ";
				}
				return T('CANT_DELETE_PARENT', 'PRODUKT', 'POZYCJA_DOKUMENTU', $name);
			}
			self::removeFromContext();
			$this->parentDelete();
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoProdukt();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT prd_id as id FROM slk_produkty";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'prd_order_column')) {
				$orderBy = " ORDER BY prd_order_column ASC ";
			} 
			if (property_exists($this, 'prd_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY prd_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoProdukt();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoProdukt($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE slk_produkty SET prd_virgo_title = '$title' WHERE prd_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoProdukt();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" prd_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['prd_id'];
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
			virgoProdukt::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoProdukt::setSessionValue('Sealock_Produkt-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoProdukt::getSessionValue('Sealock_Produkt-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoProdukt::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoProdukt::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoProdukt::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoProdukt::getSessionValue('GLOBAL', $name, $default);
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
			$context['prd_id'] = $id;
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
			$context['prd_id'] = null;
			virgoProdukt::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoProdukt::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoProdukt::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoProdukt::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoProdukt::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoProdukt::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoProdukt::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoProdukt::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoProdukt::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoProdukt::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoProdukt::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoProdukt::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoProdukt::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoProdukt::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoProdukt::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoProdukt::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoProdukt::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "prd_id";
			}
			return virgoProdukt::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoProdukt::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoProdukt::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoProdukt::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoProdukt::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoProdukt::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoProdukt::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoProdukt::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoProdukt::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoProdukt::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoProdukt::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoProdukt::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoProdukt::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->prd_id) {
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
						L(T('STORED_CORRECTLY', 'PRODUKT'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'partia produkcyjna', $this->prd_partia_produkcyjna);
						$fieldValues = $fieldValues . T($fieldValue, 'stan', $this->prd_stan);
						$parentTowar = new virgoTowar();
						$fieldValues = $fieldValues . T($fieldValue, 'towar', $parentTowar->lookup($this->prd_twr_id));
						$username = '';
						if ($this->prd_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->prd_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->prd_date_created);
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
			$instance = new virgoProdukt();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoProdukt'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			if (false) { //$componentParams->get('show_form_wydania') == "1") {
				$tmpWydanie = new virgoWydanie();
				$deleteWydanie = R('DELETE');
				if (sizeof($deleteWydanie) > 0) {
					virgoWydanie::multipleDelete($deleteWydanie);
				}
				$resIds = $tmpWydanie->select(null, 'all', null, null, ' wdn_prd_id = ' . $instance->getId(), ' SELECT wdn_id FROM slk_wydania ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->wdn_id;
//					JRequest::setVar('wdn_produkt_' . $resId->wdn_id, $this->getId());
				} 
//				JRequest::setVar('wdn_produkt_', $instance->getId());
				$tmpWydanie->setRecordSet($resIdsString);
				if (!$tmpWydanie->portletActionStoreSelected()) {
					$ret = -1;
					self::setDisplayMode($originalDisplayMode); 
				}
			}
			if (false) { //$componentParams->get('show_form_pozycje_dokumentow') == "1") {
				$tmpPozycjaDokumentu = new virgoPozycjaDokumentu();
				$deletePozycjaDokumentu = R('DELETE');
				if (sizeof($deletePozycjaDokumentu) > 0) {
					virgoPozycjaDokumentu::multipleDelete($deletePozycjaDokumentu);
				}
				$resIds = $tmpPozycjaDokumentu->select(null, 'all', null, null, ' pdk_prd_id = ' . $instance->getId(), ' SELECT pdk_id FROM slk_pozycje_dokumentow ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->pdk_id;
//					JRequest::setVar('pdk_produkt_' . $resId->pdk_id, $this->getId());
				} 
//				JRequest::setVar('pdk_produkt_', $instance->getId());
				$tmpPozycjaDokumentu->setRecordSet($resIdsString);
				if (!$tmpPozycjaDokumentu->portletActionStoreSelected()) {
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
			$instance = new virgoProdukt();
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
			$tmpId = intval(R('prd_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoProdukt::getContextId();
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
			$this->prd_id = null;
			$this->prd_date_created = null;
			$this->prd_usr_created_id = null;
			$this->prd_date_modified = null;
			$this->prd_usr_modified_id = null;
			$this->prd_virgo_title = null;
			
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

		static function portletActionShowForTowar() {
			$parentId = R('twr_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoTowar($parentId);
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
//			$ret = new virgoProdukt();
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
				$instance = new virgoProdukt();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoProdukt::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'PRODUKT'), '', 'INFO');
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
				$resultProdukt = new virgoProdukt();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultProdukt->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultProdukt->load($idToEditInt);
					} else {
						$resultProdukt->prd_id = 0;
					}
				}
				$results[] = $resultProdukt;
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
				$result = new virgoProdukt();
				$result->loadFromRequest($idToStore);
				if ($result->prd_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->prd_id == 0) {
						$result->prd_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->prd_id)) {
							$result->prd_id = 0;
						}
						$idsToCorrect[$result->prd_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'PRODUKTY'), '', 'INFO');
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
			$resultProdukt = new virgoProdukt();
			foreach ($idsToDelete as $idToDelete) {
				$resultProdukt->load((int)trim($idToDelete));
				$res = $resultProdukt->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'PRODUKTY'), '', 'INFO');			
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
		$ret = $this->prd_partia_produkcyjna;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoProdukt');
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
				$query = "UPDATE slk_produkty SET prd_virgo_title = ? WHERE prd_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT prd_id AS id FROM slk_produkty ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoProdukt($row['id']);
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
				$class2prefix["sealock\\virgoTowar"] = "twr";
				$class2prefix2 = array();
				$class2prefix2["sealock\\virgoGrupaTowaru"] = "gtw";
				$class2prefix2["sealock\\virgoJednostka"] = "jdn";
				$class2parentPrefix["sealock\\virgoTowar"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'slk_produkty.prd_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'slk_produkty.prd_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'slk_produkty.prd_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM slk_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'slk_produkty.prd_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoProdukt!', '', 'ERROR');
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
			$pdf->SetTitle('Produkty report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('PRODUKTY');
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
			if (P('show_pdf_partia_produkcyjna', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_stan', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_towar', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultProdukt = new virgoProdukt();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_partia_produkcyjna', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Partia produkcyjna');
				$minWidth['partia produkcyjna'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['partia produkcyjna']) {
						$minWidth['partia produkcyjna'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_stan', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Stan');
				$minWidth['stan'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['stan']) {
						$minWidth['stan'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_towar', "1") == "1") {
				$minWidth['towar $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'towar $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['towar $relation.name']) {
						$minWidth['towar $relation.name'] = min($tmpLen, $maxWidth);
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
			$whereClauseProdukt = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseProdukt = $whereClauseProdukt . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaProdukt = $resultProdukt->getCriteria();
			$fieldCriteriaPartiaProdukcyjna = $criteriaProdukt["partia_produkcyjna"];
			if ($fieldCriteriaPartiaProdukcyjna["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Partia produkcyjna', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaPartiaProdukcyjna["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Partia produkcyjna', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaStan = $criteriaProdukt["stan"];
			if ($fieldCriteriaStan["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Stan', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaStan["value"];
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
					$pdf->MultiCell(60, 100, 'Stan', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaProdukt["towar"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Towar', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoTowar::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Towar', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_towar');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_produkty.prd_twr_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_produkty.prd_twr_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseProdukt = $whereClauseProdukt . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaProdukt = self::getCriteria();
			if (isset($criteriaProdukt["partia_produkcyjna"])) {
				$fieldCriteriaPartiaProdukcyjna = $criteriaProdukt["partia_produkcyjna"];
				if ($fieldCriteriaPartiaProdukcyjna["is_null"] == 1) {
$filter = $filter . ' AND slk_produkty.prd_partia_produkcyjna IS NOT NULL ';
				} elseif ($fieldCriteriaPartiaProdukcyjna["is_null"] == 2) {
$filter = $filter . ' AND slk_produkty.prd_partia_produkcyjna IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaPartiaProdukcyjna["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_produkty.prd_partia_produkcyjna like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaProdukt["stan"])) {
				$fieldCriteriaStan = $criteriaProdukt["stan"];
				if ($fieldCriteriaStan["is_null"] == 1) {
$filter = $filter . ' AND slk_produkty.prd_stan IS NOT NULL ';
				} elseif ($fieldCriteriaStan["is_null"] == 2) {
$filter = $filter . ' AND slk_produkty.prd_stan IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaStan["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND slk_produkty.prd_stan = ? ";
				} else {
					$filter = $filter . " AND slk_produkty.prd_stan >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_produkty.prd_stan <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaProdukt["towar"])) {
				$parentCriteria = $criteriaProdukt["towar"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND prd_twr_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_produkty.prd_twr_id IN (SELECT twr_id FROM slk_towary WHERE twr_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseProdukt = $whereClauseProdukt . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseProdukt = $whereClauseProdukt . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT slk_produkty.prd_id, slk_produkty.prd_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_partia_produkcyjna', "1") != "0") {
				$queryString = $queryString . ", slk_produkty.prd_partia_produkcyjna prd_partia_produkcyjna";
			} else {
				if ($defaultOrderColumn == "prd_partia_produkcyjna") {
					$orderColumnNotDisplayed = " slk_produkty.prd_partia_produkcyjna ";
				}
			}
			if (P('show_pdf_stan', "1") != "0") {
				$queryString = $queryString . ", slk_produkty.prd_stan prd_stan";
			} else {
				if ($defaultOrderColumn == "prd_stan") {
					$orderColumnNotDisplayed = " slk_produkty.prd_stan ";
				}
			}
			if (class_exists('sealock\virgoTowar') && P('show_pdf_towar', "1") != "0") { // */ && !in_array("twr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_produkty.prd_twr_id as prd_twr_id ";
				$queryString = $queryString . ", slk_towary_parent.twr_virgo_title as `towar` ";
			} else {
				if ($defaultOrderColumn == "towar") {
					$orderColumnNotDisplayed = " slk_towary_parent.twr_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_produkty ";
			if (class_exists('sealock\virgoTowar')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_towary AS slk_towary_parent ON (slk_produkty.prd_twr_id = slk_towary_parent.twr_id) ";
			}

		$resultsProdukt = $resultProdukt->select(
			'', 
			'all', 
			$resultProdukt->getOrderColumn(), 
			$resultProdukt->getOrderMode(), 
			$whereClauseProdukt,
			$queryString);
		
		foreach ($resultsProdukt as $resultProdukt) {

			if (P('show_pdf_partia_produkcyjna', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultProdukt['prd_partia_produkcyjna'])) + 6;
				if ($tmpLen > $minWidth['partia produkcyjna']) {
					$minWidth['partia produkcyjna'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_stan', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultProdukt['prd_stan'])) + 6;
				if ($tmpLen > $minWidth['stan']) {
					$minWidth['stan'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_towar', "1") == "1") {
			$parentValue = trim(virgoTowar::lookup($resultProdukt['prdtwr__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['towar $relation.name']) {
					$minWidth['towar $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaProdukt = $resultProdukt->getCriteria();
		if (is_null($criteriaProdukt) || sizeof($criteriaProdukt) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');

																													if (P('show_pdf_partia_produkcyjna', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['partia produkcyjna'], $colHeight, T('PARTIA_PRODUKCYJNA'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_stan', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['stan'], $colHeight, T('STAN'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_towar', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['towar $relation.name'], $colHeight, T('TOWAR') . ' ' . T(''), 'T', 'C', 0, 0); 
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
		foreach ($resultsProdukt as $resultProdukt) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_partia_produkcyjna', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['partia produkcyjna'], $colHeight, '' . $resultProdukt['prd_partia_produkcyjna'], 'T', 'L', 0, 0);
				if (P('show_pdf_partia_produkcyjna', "1") == "2") {
										if (!is_null($resultProdukt['prd_partia_produkcyjna'])) {
						$tmpCount = (float)$counts["partia_produkcyjna"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["partia_produkcyjna"] = $tmpCount;
					}
				}
				if (P('show_pdf_partia_produkcyjna', "1") == "3") {
										if (!is_null($resultProdukt['prd_partia_produkcyjna'])) {
						$tmpSum = (float)$sums["partia_produkcyjna"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProdukt['prd_partia_produkcyjna'];
						}
						$sums["partia_produkcyjna"] = $tmpSum;
					}
				}
				if (P('show_pdf_partia_produkcyjna', "1") == "4") {
										if (!is_null($resultProdukt['prd_partia_produkcyjna'])) {
						$tmpCount = (float)$avgCounts["partia_produkcyjna"];
						$tmpSum = (float)$avgSums["partia_produkcyjna"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["partia_produkcyjna"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProdukt['prd_partia_produkcyjna'];
						}
						$avgSums["partia_produkcyjna"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_stan', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['stan'], $colHeight, '' . $resultProdukt['prd_stan'], 'T', 'R', 0, 0);
				if (P('show_pdf_stan', "1") == "2") {
										if (!is_null($resultProdukt['prd_stan'])) {
						$tmpCount = (float)$counts["stan"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["stan"] = $tmpCount;
					}
				}
				if (P('show_pdf_stan', "1") == "3") {
										if (!is_null($resultProdukt['prd_stan'])) {
						$tmpSum = (float)$sums["stan"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProdukt['prd_stan'];
						}
						$sums["stan"] = $tmpSum;
					}
				}
				if (P('show_pdf_stan', "1") == "4") {
										if (!is_null($resultProdukt['prd_stan'])) {
						$tmpCount = (float)$avgCounts["stan"];
						$tmpSum = (float)$avgSums["stan"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["stan"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultProdukt['prd_stan'];
						}
						$avgSums["stan"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_towar', "1") == "1") {
			$parentValue = virgoTowar::lookup($resultProdukt['prd_twr_id']);
			$tmpLn = $pdf->MultiCell($minWidth['towar $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
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
			if (P('show_pdf_partia_produkcyjna', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['partia produkcyjna'];
				if (P('show_pdf_partia_produkcyjna', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["partia_produkcyjna"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_stan', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['stan'];
				if (P('show_pdf_stan', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["stan"];
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
			if (P('show_pdf_partia_produkcyjna', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['partia produkcyjna'];
				if (P('show_pdf_partia_produkcyjna', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["partia_produkcyjna"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_stan', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['stan'];
				if (P('show_pdf_stan', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["stan"], 2, ',', ' ');
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
			if (P('show_pdf_partia_produkcyjna', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['partia produkcyjna'];
				if (P('show_pdf_partia_produkcyjna', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["partia_produkcyjna"] == 0 ? "-" : $avgSums["partia_produkcyjna"] / $avgCounts["partia_produkcyjna"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_stan', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['stan'];
				if (P('show_pdf_stan', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["stan"] == 0 ? "-" : $avgSums["stan"] / $avgCounts["stan"]);
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
				$reportTitle = T('PRODUKTY');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultProdukt = new virgoProdukt();
			$whereClauseProdukt = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseProdukt = $whereClauseProdukt . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_partia_produkcyjna', "1") != "0") {
					$data = $data . $stringDelimeter .'Partia produkcyjna' . $stringDelimeter . $separator;
				}
				if (P('show_export_stan', "1") != "0") {
					$data = $data . $stringDelimeter .'Stan' . $stringDelimeter . $separator;
				}
				if (P('show_export_towar', "1") != "0") {
					$data = $data . $stringDelimeter . 'Towar ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_produkty.prd_id, slk_produkty.prd_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_partia_produkcyjna', "1") != "0") {
				$queryString = $queryString . ", slk_produkty.prd_partia_produkcyjna prd_partia_produkcyjna";
			} else {
				if ($defaultOrderColumn == "prd_partia_produkcyjna") {
					$orderColumnNotDisplayed = " slk_produkty.prd_partia_produkcyjna ";
				}
			}
			if (P('show_export_stan', "1") != "0") {
				$queryString = $queryString . ", slk_produkty.prd_stan prd_stan";
			} else {
				if ($defaultOrderColumn == "prd_stan") {
					$orderColumnNotDisplayed = " slk_produkty.prd_stan ";
				}
			}
			if (class_exists('sealock\virgoTowar') && P('show_export_towar', "1") != "0") { // */ && !in_array("twr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_produkty.prd_twr_id as prd_twr_id ";
				$queryString = $queryString . ", slk_towary_parent.twr_virgo_title as `towar` ";
			} else {
				if ($defaultOrderColumn == "towar") {
					$orderColumnNotDisplayed = " slk_towary_parent.twr_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_produkty ";
			if (class_exists('sealock\virgoTowar')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_towary AS slk_towary_parent ON (slk_produkty.prd_twr_id = slk_towary_parent.twr_id) ";
			}

			$resultsProdukt = $resultProdukt->select(
				'', 
				'all', 
				$resultProdukt->getOrderColumn(), 
				$resultProdukt->getOrderMode(), 
				$whereClauseProdukt,
				$queryString);
			foreach ($resultsProdukt as $resultProdukt) {
				if (P('show_export_partia_produkcyjna', "1") != "0") {
			$data = $data . $stringDelimeter . $resultProdukt['prd_partia_produkcyjna'] . $stringDelimeter . $separator;
				}
				if (P('show_export_stan', "1") != "0") {
			$data = $data . $resultProdukt['prd_stan'] . $separator;
				}
				if (P('show_export_towar', "1") != "0") {
					$parentValue = virgoTowar::lookup($resultProdukt['prd_twr_id']);
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
				$reportTitle = T('PRODUKTY');
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
			$resultProdukt = new virgoProdukt();
			$whereClauseProdukt = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseProdukt = $whereClauseProdukt . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_partia_produkcyjna', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Partia produkcyjna');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_stan', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Stan');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_towar', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Towar ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoTowar::getVirgoList();
					$formulaTowar = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaTowar != "") {
							$formulaTowar = $formulaTowar . ',';
						}
						$formulaTowar = $formulaTowar . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_produkty.prd_id, slk_produkty.prd_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_partia_produkcyjna', "1") != "0") {
				$queryString = $queryString . ", slk_produkty.prd_partia_produkcyjna prd_partia_produkcyjna";
			} else {
				if ($defaultOrderColumn == "prd_partia_produkcyjna") {
					$orderColumnNotDisplayed = " slk_produkty.prd_partia_produkcyjna ";
				}
			}
			if (P('show_export_stan', "1") != "0") {
				$queryString = $queryString . ", slk_produkty.prd_stan prd_stan";
			} else {
				if ($defaultOrderColumn == "prd_stan") {
					$orderColumnNotDisplayed = " slk_produkty.prd_stan ";
				}
			}
			if (class_exists('sealock\virgoTowar') && P('show_export_towar', "1") != "0") { // */ && !in_array("twr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_produkty.prd_twr_id as prd_twr_id ";
				$queryString = $queryString . ", slk_towary_parent.twr_virgo_title as `towar` ";
			} else {
				if ($defaultOrderColumn == "towar") {
					$orderColumnNotDisplayed = " slk_towary_parent.twr_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_produkty ";
			if (class_exists('sealock\virgoTowar')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_towary AS slk_towary_parent ON (slk_produkty.prd_twr_id = slk_towary_parent.twr_id) ";
			}

			$resultsProdukt = $resultProdukt->select(
				'', 
				'all', 
				$resultProdukt->getOrderColumn(), 
				$resultProdukt->getOrderMode(), 
				$whereClauseProdukt,
				$queryString);
			$index = 1;
			foreach ($resultsProdukt as $resultProdukt) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultProdukt['prd_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_partia_produkcyjna', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultProdukt['prd_partia_produkcyjna'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_stan', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultProdukt['prd_stan'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_towar', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoTowar::lookup($resultProdukt['prd_twr_id']);
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
					$objValidation->setFormula1('"' . $formulaTowar . '"');
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
					$propertyColumnHash['partia produkcyjna'] = 'prd_partia_produkcyjna';
					$propertyColumnHash['partia_produkcyjna'] = 'prd_partia_produkcyjna';
					$propertyColumnHash['stan'] = 'prd_stan';
					$propertyColumnHash['stan'] = 'prd_stan';
					$propertyClassHash['towar'] = 'Towar';
					$propertyClassHash['towar'] = 'Towar';
					$propertyColumnHash['towar'] = 'prd_twr_id';
					$propertyColumnHash['towar'] = 'prd_twr_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importProdukt = new virgoProdukt();
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
										L(T('PROPERTY_NOT_FOUND', T('PRODUKT'), $columns[$index]), '', 'ERROR');
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
										$importProdukt->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_towar');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoTowar::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoTowar::token2Id($tmpToken);
	}
	$importProdukt->setTwrId($defaultValue);
}
							$errorMessage = $importProdukt->store();
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
		




		static function portletActionVirgoSetTowar() {
			$this->loadFromDB();
			$parentId = R('prd_Towar_id_' . $_SESSION['current_portlet_object_id']);
			$this->setTwrId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}

		static function portletActionAddTowar() {
			self::setDisplayMode("ADD_NEW_PARENT_TOWAR");
		}

		static function portletActionStoreNewTowar() {
			$id = -1;
			if (virgoTowar::portletActionStore(true, $id) == -1) {
				self::setDisplayMode("ADD_NEW_PARENT_TOWAR");
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			} else {
				$tmpId = self::loadIdFromRequest();
				$_POST['prd_towar_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
				self::portletActionBackFromParent();
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
CREATE TABLE IF NOT EXISTS `slk_produkty` (
  `prd_id` bigint(20) unsigned NOT NULL auto_increment,
  `prd_virgo_state` varchar(50) default NULL,
  `prd_virgo_title` varchar(255) default NULL,
	`prd_twr_id` int(11) default NULL,
  `prd_partia_produkcyjna` varchar(255), 
  `prd_stan` integer,  
  `prd_date_created` datetime NOT NULL,
  `prd_date_modified` datetime default NULL,
  `prd_usr_created_id` int(11) NOT NULL,
  `prd_usr_modified_id` int(11) default NULL,
  KEY `prd_twr_fk` (`prd_twr_id`),
  PRIMARY KEY  (`prd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/produkt.sql 
INSERT INTO `slk_produkty` (`prd_virgo_title`, `prd_partia_produkcyjna`, `prd_stan`) 
VALUES (title, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably slk_produkty table already exists.", '', 'FATAL');
				L("Error ocurred, please contact site Administrator.", '', 'ERROR');
 				return false;
 			}
 			return true;
 		}


		static function onInstall($pobId, $title) {
		}

		static function getIdByKeyPartiaProdukcyjna($partiaProdukcyjna) {
			$query = " SELECT prd_id FROM slk_produkty WHERE 1 ";
			$query .= " AND prd_partia_produkcyjna = '{$partiaProdukcyjna}' ";
			$rows = QR($query);
			foreach ($rows as $row) {
				return $row['prd_id'];
			}
			return null;
		}

		static function getByKeyPartiaProdukcyjna($partiaProdukcyjna) {
			$id = self::getIdByKeyPartiaProdukcyjna($partiaProdukcyjna);
			$ret = new virgoProdukt();
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
			return "prd";
		}
		
		static function getPlural() {
			return "produkty";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoTowar";
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoWydanie";
			$ret[] = "virgoPozycjaDokumentu";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'slk_produkty'));
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
			$virgoVersion = virgoProdukt::getVirgoVersion();
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
	
	

