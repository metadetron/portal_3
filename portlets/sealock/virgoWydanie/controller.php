<?php
/**
* Module Wydanie
* @package Sealock
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace sealock;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoProdukt'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoPozycjaZamowienia'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoWydanie {

		 private  $wdn_id = null;
		 private  $wdn_ilosc = null;

		 private  $wdn_prd_id = null;

		 private   $wdn_date_created = null;
		 private   $wdn_usr_created_id = null;
		 private   $wdn_date_modified = null;
		 private   $wdn_usr_modified_id = null;
		 private   $wdn_virgo_title = null;
		
		 private   $internalLog = null;		
				
		 private  function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		public function isDeletedVirgo() {
			return $this->wdn_virgo_deleted;
		}

		static public function createGuiAware() {
			$ret = new virgoWydanie();
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
        	$this->wdn_id = null;
		    $this->wdn_date_created = null;
		    $this->wdn_usr_created_id = null;
		    $this->wdn_date_modified = null;
		    $this->wdn_usr_modified_id = null;
		    $this->wdn_virgo_title = null;
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
			return $this->wdn_id;
		}

		function getIlosc() {
			return $this->wdn_ilosc;
		}
		
		 private  function setIlosc($val) {
			$this->wdn_ilosc = $val;
		}

		function getProduktId() {
			return $this->wdn_prd_id;
		}
		
		 private  function setProduktId($val) {
			$this->wdn_prd_id = $val;
		}

		function getDateCreated() {
			return $this->wdn_date_created;
		}
		function getUsrCreatedId() {
			return $this->wdn_usr_created_id;
		}
		function getDateModified() {
			return $this->wdn_date_modified;
		}
		function getUsrModifiedId() {
			return $this->wdn_usr_modified_id;
		}


		function getPrdId() {
			return $this->getProduktId();
		}
		
		 private  function setPrdId($val) {
			$this->setProduktId($val);
		}

		function loadRecordFromRequest($rowId) {
			$this->wdn_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('wdn_ilosc_' . $this->wdn_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->wdn_ilosc = null;
		} else {
			$this->wdn_ilosc = $tmpValue;
		}
	}
			$this->wdn_prd_id = strval(R('wdn_produkt_' . $this->wdn_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('wdn_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaWydanie = array();	
			$criteriaFieldWydanie = array();	
			$isNullWydanie = R('virgo_search_ilosc_is_null');
			
			$criteriaFieldWydanie["is_null"] = 0;
			if ($isNullWydanie == "not_null") {
				$criteriaFieldWydanie["is_null"] = 1;
			} elseif ($isNullWydanie == "null") {
				$criteriaFieldWydanie["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_ilosc_from');
		if (!is_numeric($dataTypeCriteria["from"])) {
			$dataTypeCriteria["from"] = null;
		}
		$dataTypeCriteria["to"] = R('virgo_search_ilosc_to');
		if (!is_numeric($dataTypeCriteria["to"])) {
			$dataTypeCriteria["to"] = null;
		}

//			if ($isSet) {
			$criteriaFieldWydanie["value"] = $dataTypeCriteria;
//			}
			$criteriaWydanie["ilosc"] = $criteriaFieldWydanie;
			$criteriaParent = array();	
			$isNull = R('virgo_search_produkt_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_produkt', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaWydanie["produkt"] = $criteriaParent;
			self::setCriteria($criteriaWydanie);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_ilosc');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterIlosc', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterIlosc', null);
			}
			$parentFilter = R('virgo_filter_produkt');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterProdukt', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterProdukt', null);
			}
			$parentFilter = R('virgo_filter_title_produkt');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleProdukt', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleProdukt', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseWydanie = ' 1 = 1 ';
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
				$eventColumn = "wdn_" . P('event_column');
				$whereClauseWydanie = $whereClauseWydanie . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseWydanie = $whereClauseWydanie . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_produkt');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_wydania.wdn_prd_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_wydania.wdn_prd_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseWydanie = $whereClauseWydanie . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaWydanie = self::getCriteria();
			if (isset($criteriaWydanie["ilosc"])) {
				$fieldCriteriaIlosc = $criteriaWydanie["ilosc"];
				if ($fieldCriteriaIlosc["is_null"] == 1) {
$filter = $filter . ' AND slk_wydania.wdn_ilosc IS NOT NULL ';
				} elseif ($fieldCriteriaIlosc["is_null"] == 2) {
$filter = $filter . ' AND slk_wydania.wdn_ilosc IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaIlosc["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_wydania.wdn_ilosc >= ? ";
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_wydania.wdn_ilosc <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaWydanie["produkt"])) {
				$parentCriteria = $criteriaWydanie["produkt"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND wdn_prd_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_wydania.wdn_prd_id IN (SELECT prd_id FROM slk_produkty WHERE prd_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseWydanie = $whereClauseWydanie . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseWydanie = $whereClauseWydanie . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseWydanie = $whereClauseWydanie . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterIlosc', null);
				if (S($tableFilter)) {
					$whereClauseWydanie = $whereClauseWydanie . " AND wdn_ilosc LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterProdukt', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseWydanie = $whereClauseWydanie . " AND wdn_prd_id IS NULL ";
					} else {
						$whereClauseWydanie = $whereClauseWydanie . " AND wdn_prd_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleProdukt', null);
				if (S($parentFilter)) {
					$whereClauseWydanie = $whereClauseWydanie . " AND slk_produkty_parent.prd_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClauseWydanie;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseWydanie = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT slk_wydania.wdn_id, slk_wydania.wdn_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_ilosc', "1") != "0") {
				$queryString = $queryString . ", slk_wydania.wdn_ilosc wdn_ilosc";
			} else {
				if ($defaultOrderColumn == "wdn_ilosc") {
					$orderColumnNotDisplayed = " slk_wydania.wdn_ilosc ";
				}
			}
			if (class_exists('sealock\virgoProdukt') && P('show_table_produkt', "1") != "0") { // */ && !in_array("prd", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_wydania.wdn_prd_id as wdn_prd_id ";
				$queryString = $queryString . ", slk_produkty_parent.prd_virgo_title as `produkt` ";
			} else {
				if ($defaultOrderColumn == "produkt") {
					$orderColumnNotDisplayed = " slk_produkty_parent.prd_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_wydania ";
			if (class_exists('sealock\virgoProdukt')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_produkty AS slk_produkty_parent ON (slk_wydania.wdn_prd_id = slk_produkty_parent.prd_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseWydanie = $whereClauseWydanie . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseWydanie, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseWydanie,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM slk_wydania"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " wdn_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " wdn_usr_created_id = ? ";
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
				. "\n FROM slk_wydania"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as slk_wydania ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as slk_wydania ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, wdn_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " wdn_usr_created_id = ? ";
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
				$query = "SELECT COUNT(wdn_id) cnt FROM wydania";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as wydania ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as wydania ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoWydanie();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM slk_wydania WHERE wdn_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->wdn_id = $row['wdn_id'];
$this->wdn_ilosc = $row['wdn_ilosc'];
						$this->wdn_prd_id = $row['wdn_prd_id'];
						if ($fetchUsernames) {
							if ($row['wdn_date_created']) {
								if ($row['wdn_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['wdn_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['wdn_date_modified']) {
								if ($row['wdn_usr_modified_id'] == $row['wdn_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['wdn_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['wdn_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->wdn_date_created = $row['wdn_date_created'];
						$this->wdn_usr_created_id = $fetchUsernames ? $createdBy : $row['wdn_usr_created_id'];
						$this->wdn_date_modified = $row['wdn_date_modified'];
						$this->wdn_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['wdn_usr_modified_id'];
						$this->wdn_virgo_title = $row['wdn_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE slk_wydania SET wdn_usr_created_id = {$userId} WHERE wdn_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->wdn_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoWydanie::selectAllAsObjectsStatic('wdn_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->wdn_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->wdn_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('wdn_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_wdn = new virgoWydanie();
				$tmp_wdn->load((int)$lookup_id);
				return $tmp_wdn->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoWydanie');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" wdn_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoWydanie', "10");
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
				$query = $query . " wdn_id as id, wdn_virgo_title as title ";
			}
			$query = $query . " FROM slk_wydania ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoWydanie', 'sealock') == "1") {
				$privateCondition = " wdn_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY wdn_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resWydanie = array();
				foreach ($rows as $row) {
					$resWydanie[$row['id']] = $row['title'];
				}
				return $resWydanie;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticWydanie = new virgoWydanie();
			return $staticWydanie->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getProduktStatic($parentId) {
			return virgoProdukt::getById($parentId);
		}
		
		function getProdukt() {
			return virgoWydanie::getProduktStatic($this->wdn_prd_id);
		}

		static function getPozycjeZamowienStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resPozycjaZamowienia = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoPozycjaZamowienia'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resPozycjaZamowienia;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resPozycjaZamowienia;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsPozycjaZamowienia = virgoPozycjaZamowienia::selectAll('pzm_wdn_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPozycjaZamowienia as $resultPozycjaZamowienia) {
				$tmpPozycjaZamowienia = virgoPozycjaZamowienia::getById($resultPozycjaZamowienia['pzm_id']); 
				array_push($resPozycjaZamowienia, $tmpPozycjaZamowienia);
			}
			return $resPozycjaZamowienia;
		}

		function getPozycjeZamowien($orderBy = '', $extraWhere = null) {
			return virgoWydanie::getPozycjeZamowienStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
			if (
(is_null($this->getIlosc()) || trim($this->getIlosc()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'ILOSC');
			}			
				if (is_null($this->wdn_prd_id) || trim($this->wdn_prd_id) == "") {
					if (R('create_wdn_produkt_' . $this->wdn_id) == "1") { 
						$parent = new virgoProdukt();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->wdn_prd_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'PRODUKT', '');
					}
			}			
 			if (!is_null($this->wdn_ilosc) && trim($this->wdn_ilosc) != "") {
				if (!is_numeric($this->wdn_ilosc)) {
					return T('INCORRECT_NUMBER', 'ILOSC', $this->wdn_ilosc);
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  slk_history_wydania WHERE wdn_id = " . $this->getId();
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
				$colNames = $colNames . ", wdn_ilosc";
				$values = $values . ", " . (is_null($objectToStore->getIlosc()) ? "null" : "'" . QE($objectToStore->getIlosc()) . "'");
				$colNames = $colNames . ", wdn_prd_id";
				$values = $values . ", " . (is_null($objectToStore->getPrdId()) || $objectToStore->getPrdId() == "" ? "null" : $objectToStore->getPrdId());
				$query = "INSERT INTO slk_history_wydania (revision, ip, username, user_id, timestamp, wdn_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getIlosc() != $objectToStore->getIlosc()) {
				if (is_null($objectToStore->getIlosc())) {
					$nullifiedProperties = $nullifiedProperties . "ilosc,";
				} else {
				$colNames = $colNames . ", wdn_ilosc";
				$values = $values . ", " . (is_null($objectToStore->getIlosc()) ? "null" : "'" . QE($objectToStore->getIlosc()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getPrdId() != $objectToStore->getPrdId() && ($virgoOld->getPrdId() != 0 || $objectToStore->getPrdId() != ""))) { 
				$colNames = $colNames . ", wdn_prd_id";
				$values = $values . ", " . (is_null($objectToStore->getPrdId()) ? "null" : ($objectToStore->getPrdId() == "" ? "0" : $objectToStore->getPrdId()));
			}
			$query = "INSERT INTO slk_history_wydania (revision, ip, username, user_id, timestamp, wdn_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM slk_wydania");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'wdn_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE slk_wydania ADD COLUMN (wdn_virgo_title VARCHAR(255));";
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
			if (isset($this->wdn_id) && $this->wdn_id != "") {
				$query = "UPDATE slk_wydania SET ";
			if (isset($this->wdn_ilosc)) {
				$query .= " wdn_ilosc = ? ,";
				$types .= "d";
				$values[] = number_format($this->wdn_ilosc, 2, '.', '');
			} else {
				$query .= " wdn_ilosc = NULL ,";				
			}
				if (isset($this->wdn_prd_id) && trim($this->wdn_prd_id) != "") {
					$query = $query . " wdn_prd_id = ? , ";
					$types = $types . "i";
					$values[] = $this->wdn_prd_id;
				} else {
					$query = $query . " wdn_prd_id = NULL, ";
				}
				$query = $query . " wdn_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " wdn_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->wdn_date_modified;

				$query = $query . " wdn_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->wdn_usr_modified_id;

				$query = $query . " WHERE wdn_id = ? ";
				$types = $types . "i";
				$values[] = $this->wdn_id;
			} else {
				$query = "INSERT INTO slk_wydania ( ";
			$query = $query . " wdn_ilosc, ";
				$query = $query . " wdn_prd_id, ";
				$query = $query . " wdn_virgo_title, wdn_date_created, wdn_usr_created_id) VALUES ( ";
			if (isset($this->wdn_ilosc)) {
				$query .= " ? ,";
				$types .= "d";
				$values[] = $this->wdn_ilosc;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->wdn_prd_id) && trim($this->wdn_prd_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->wdn_prd_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->wdn_date_created;
				$values[] = $this->wdn_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->wdn_id) || $this->wdn_id == "") {
					$this->wdn_id = QID();
				}
				if ($log) {
					L("wydanie stored successfully", "id = {$this->wdn_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->wdn_id) {
				$virgoOld = new virgoWydanie($this->wdn_id);
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
					if ($this->wdn_id) {			
						$this->wdn_date_modified = date("Y-m-d H:i:s");
						$this->wdn_usr_modified_id = $userId;
					} else {
						$this->wdn_date_created = date("Y-m-d H:i:s");
						$this->wdn_usr_created_id = $userId;
					}
					$this->wdn_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "wydanie" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "wydanie" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM slk_wydania WHERE wdn_id = {$this->wdn_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			$list = $this->getPozycjeZamowien();
			if (sizeof($list) > 0) {
				$name = $this->getVirgoTitle();
				if (!is_null($name) && trim($name) != "") {
					$name = "'" . $name . "' ";
				}
				return T('CANT_DELETE_PARENT', 'WYDANIE', 'POZYCJA_ZAMOWIENIA', $name);
			}
			self::removeFromContext();
			$this->parentDelete();
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoWydanie();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT wdn_id as id FROM slk_wydania";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'wdn_order_column')) {
				$orderBy = " ORDER BY wdn_order_column ASC ";
			} 
			if (property_exists($this, 'wdn_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY wdn_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoWydanie();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoWydanie($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE slk_wydania SET wdn_virgo_title = '$title' WHERE wdn_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoWydanie();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" wdn_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['wdn_id'];
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
			virgoWydanie::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoWydanie::setSessionValue('Sealock_Wydanie-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoWydanie::getSessionValue('Sealock_Wydanie-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoWydanie::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoWydanie::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoWydanie::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoWydanie::getSessionValue('GLOBAL', $name, $default);
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
			$context['wdn_id'] = $id;
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
			$context['wdn_id'] = null;
			virgoWydanie::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoWydanie::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoWydanie::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoWydanie::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoWydanie::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoWydanie::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoWydanie::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoWydanie::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoWydanie::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoWydanie::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoWydanie::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoWydanie::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoWydanie::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoWydanie::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoWydanie::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoWydanie::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoWydanie::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "wdn_id";
			}
			return virgoWydanie::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoWydanie::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoWydanie::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoWydanie::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoWydanie::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoWydanie::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoWydanie::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoWydanie::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoWydanie::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoWydanie::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoWydanie::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoWydanie::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoWydanie::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->wdn_id) {
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
						L(T('STORED_CORRECTLY', 'WYDANIE'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'ilość', $this->wdn_ilosc);
						$parentProdukt = new virgoProdukt();
						$fieldValues = $fieldValues . T($fieldValue, 'produkt', $parentProdukt->lookup($this->wdn_prd_id));
						$username = '';
						if ($this->wdn_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->wdn_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->wdn_date_created);
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
			$instance = new virgoWydanie();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoWydanie'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			if (false) { //$componentParams->get('show_form_pozycje_zamowien') == "1") {
				$tmpPozycjaZamowienia = new virgoPozycjaZamowienia();
				$deletePozycjaZamowienia = R('DELETE');
				if (sizeof($deletePozycjaZamowienia) > 0) {
					virgoPozycjaZamowienia::multipleDelete($deletePozycjaZamowienia);
				}
				$resIds = $tmpPozycjaZamowienia->select(null, 'all', null, null, ' pzm_wdn_id = ' . $instance->getId(), ' SELECT pzm_id FROM slk_pozycje_zamowien ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->pzm_id;
//					JRequest::setVar('pzm_wydanie_' . $resId->pzm_id, $this->getId());
				} 
//				JRequest::setVar('pzm_wydanie_', $instance->getId());
				$tmpPozycjaZamowienia->setRecordSet($resIdsString);
				if (!$tmpPozycjaZamowienia->portletActionStoreSelected()) {
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
			$instance = new virgoWydanie();
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
			$tmpId = intval(R('wdn_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoWydanie::getContextId();
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
			$this->wdn_id = null;
			$this->wdn_date_created = null;
			$this->wdn_usr_created_id = null;
			$this->wdn_date_modified = null;
			$this->wdn_usr_modified_id = null;
			$this->wdn_virgo_title = null;
			
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

		static function portletActionShowForProdukt() {
			$parentId = R('prd_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoProdukt($parentId);
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
//			$ret = new virgoWydanie();
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
				$instance = new virgoWydanie();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoWydanie::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'WYDANIE'), '', 'INFO');
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
				$resultWydanie = new virgoWydanie();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultWydanie->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultWydanie->load($idToEditInt);
					} else {
						$resultWydanie->wdn_id = 0;
					}
				}
				$results[] = $resultWydanie;
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
				$result = new virgoWydanie();
				$result->loadFromRequest($idToStore);
				if ($result->wdn_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->wdn_id == 0) {
						$result->wdn_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->wdn_id)) {
							$result->wdn_id = 0;
						}
						$idsToCorrect[$result->wdn_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'WYDANIA'), '', 'INFO');
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
			$resultWydanie = new virgoWydanie();
			foreach ($idsToDelete as $idToDelete) {
				$resultWydanie->load((int)trim($idToDelete));
				$res = $resultWydanie->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'WYDANIA'), '', 'INFO');			
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
		$ret = $this->wdn_ilosc;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoWydanie');
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
				$query = "UPDATE slk_wydania SET wdn_virgo_title = ? WHERE wdn_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT wdn_id AS id FROM slk_wydania ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoWydanie($row['id']);
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
				$class2prefix["sealock\\virgoProdukt"] = "prd";
				$class2prefix2 = array();
				$class2prefix2["sealock\\virgoTowar"] = "twr";
				$class2parentPrefix["sealock\\virgoProdukt"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'slk_wydania.wdn_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'slk_wydania.wdn_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'slk_wydania.wdn_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM slk_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'slk_wydania.wdn_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoWydanie!', '', 'ERROR');
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
			$pdf->SetTitle('Wydania report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('WYDANIA');
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
			if (P('show_pdf_ilosc', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_produkt', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultWydanie = new virgoWydanie();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_ilosc', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Ilość');
				$minWidth['ilo\u015B\u0107'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['ilo\u015B\u0107']) {
						$minWidth['ilo\u015B\u0107'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_produkt', "1") == "1") {
				$minWidth['produkt $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'produkt $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['produkt $relation.name']) {
						$minWidth['produkt $relation.name'] = min($tmpLen, $maxWidth);
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
			$whereClauseWydanie = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseWydanie = $whereClauseWydanie . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaWydanie = $resultWydanie->getCriteria();
			$fieldCriteriaIlosc = $criteriaWydanie["ilosc"];
			if ($fieldCriteriaIlosc["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Ilość', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaIlosc["value"];
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
					$pdf->MultiCell(60, 100, 'Ilość', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaWydanie["produkt"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Produkt', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoProdukt::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Produkt', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_produkt');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_wydania.wdn_prd_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_wydania.wdn_prd_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseWydanie = $whereClauseWydanie . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaWydanie = self::getCriteria();
			if (isset($criteriaWydanie["ilosc"])) {
				$fieldCriteriaIlosc = $criteriaWydanie["ilosc"];
				if ($fieldCriteriaIlosc["is_null"] == 1) {
$filter = $filter . ' AND slk_wydania.wdn_ilosc IS NOT NULL ';
				} elseif ($fieldCriteriaIlosc["is_null"] == 2) {
$filter = $filter . ' AND slk_wydania.wdn_ilosc IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaIlosc["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_wydania.wdn_ilosc >= ? ";
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_wydania.wdn_ilosc <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaWydanie["produkt"])) {
				$parentCriteria = $criteriaWydanie["produkt"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND wdn_prd_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_wydania.wdn_prd_id IN (SELECT prd_id FROM slk_produkty WHERE prd_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseWydanie = $whereClauseWydanie . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseWydanie = $whereClauseWydanie . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT slk_wydania.wdn_id, slk_wydania.wdn_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_ilosc', "1") != "0") {
				$queryString = $queryString . ", slk_wydania.wdn_ilosc wdn_ilosc";
			} else {
				if ($defaultOrderColumn == "wdn_ilosc") {
					$orderColumnNotDisplayed = " slk_wydania.wdn_ilosc ";
				}
			}
			if (class_exists('sealock\virgoProdukt') && P('show_pdf_produkt', "1") != "0") { // */ && !in_array("prd", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_wydania.wdn_prd_id as wdn_prd_id ";
				$queryString = $queryString . ", slk_produkty_parent.prd_virgo_title as `produkt` ";
			} else {
				if ($defaultOrderColumn == "produkt") {
					$orderColumnNotDisplayed = " slk_produkty_parent.prd_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_wydania ";
			if (class_exists('sealock\virgoProdukt')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_produkty AS slk_produkty_parent ON (slk_wydania.wdn_prd_id = slk_produkty_parent.prd_id) ";
			}

		$resultsWydanie = $resultWydanie->select(
			'', 
			'all', 
			$resultWydanie->getOrderColumn(), 
			$resultWydanie->getOrderMode(), 
			$whereClauseWydanie,
			$queryString);
		
		foreach ($resultsWydanie as $resultWydanie) {

			if (P('show_pdf_ilosc', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultWydanie['wdn_ilosc'])) + 6;
				if ($tmpLen > $minWidth['ilo\u015B\u0107']) {
					$minWidth['ilo\u015B\u0107'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_produkt', "1") == "1") {
			$parentValue = trim(virgoProdukt::lookup($resultWydanie['wdnprd__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['produkt $relation.name']) {
					$minWidth['produkt $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaWydanie = $resultWydanie->getCriteria();
		if (is_null($criteriaWydanie) || sizeof($criteriaWydanie) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																											if (P('show_pdf_produkt', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['produkt $relation.name'], $colHeight, T('PRODUKT') . ' ' . T(''), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_ilosc', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['ilo\u015B\u0107'], $colHeight, T('ILOSC'), 'T', 'C', 0, 0);
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
		foreach ($resultsWydanie as $resultWydanie) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_produkt', "1") == "1") {
			$parentValue = virgoProdukt::lookup($resultWydanie['wdn_prd_id']);
			$tmpLn = $pdf->MultiCell($minWidth['produkt $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_ilosc', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['ilo\u015B\u0107'], $colHeight, '' . number_format($resultWydanie['wdn_ilosc'], 2, ',', ' '), 'T', 'R', 0, 0);
				if (P('show_pdf_ilosc', "1") == "2") {
										if (!is_null($resultWydanie['wdn_ilosc'])) {
						$tmpCount = (float)$counts["ilosc"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["ilosc"] = $tmpCount;
					}
				}
				if (P('show_pdf_ilosc', "1") == "3") {
										if (!is_null($resultWydanie['wdn_ilosc'])) {
						$tmpSum = (float)$sums["ilosc"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultWydanie['wdn_ilosc'];
						}
						$sums["ilosc"] = $tmpSum;
					}
				}
				if (P('show_pdf_ilosc', "1") == "4") {
										if (!is_null($resultWydanie['wdn_ilosc'])) {
						$tmpCount = (float)$avgCounts["ilosc"];
						$tmpSum = (float)$avgSums["ilosc"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["ilosc"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultWydanie['wdn_ilosc'];
						}
						$avgSums["ilosc"] = $tmpSum;
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
			if (P('show_pdf_ilosc', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['ilo\u015B\u0107'];
				if (P('show_pdf_ilosc', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["ilosc"];
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
			if (P('show_pdf_ilosc', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['ilo\u015B\u0107'];
				if (P('show_pdf_ilosc', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["ilosc"], 2, ',', ' ');
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
			if (P('show_pdf_ilosc', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['ilo\u015B\u0107'];
				if (P('show_pdf_ilosc', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["ilosc"] == 0 ? "-" : $avgSums["ilosc"] / $avgCounts["ilosc"]);
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
				$reportTitle = T('WYDANIA');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultWydanie = new virgoWydanie();
			$whereClauseWydanie = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseWydanie = $whereClauseWydanie . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_ilosc', "1") != "0") {
					$data = $data . $stringDelimeter .'Ilość' . $stringDelimeter . $separator;
				}
				if (P('show_export_produkt', "1") != "0") {
					$data = $data . $stringDelimeter . 'Produkt ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_wydania.wdn_id, slk_wydania.wdn_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_ilosc', "1") != "0") {
				$queryString = $queryString . ", slk_wydania.wdn_ilosc wdn_ilosc";
			} else {
				if ($defaultOrderColumn == "wdn_ilosc") {
					$orderColumnNotDisplayed = " slk_wydania.wdn_ilosc ";
				}
			}
			if (class_exists('sealock\virgoProdukt') && P('show_export_produkt', "1") != "0") { // */ && !in_array("prd", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_wydania.wdn_prd_id as wdn_prd_id ";
				$queryString = $queryString . ", slk_produkty_parent.prd_virgo_title as `produkt` ";
			} else {
				if ($defaultOrderColumn == "produkt") {
					$orderColumnNotDisplayed = " slk_produkty_parent.prd_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_wydania ";
			if (class_exists('sealock\virgoProdukt')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_produkty AS slk_produkty_parent ON (slk_wydania.wdn_prd_id = slk_produkty_parent.prd_id) ";
			}

			$resultsWydanie = $resultWydanie->select(
				'', 
				'all', 
				$resultWydanie->getOrderColumn(), 
				$resultWydanie->getOrderMode(), 
				$whereClauseWydanie,
				$queryString);
			foreach ($resultsWydanie as $resultWydanie) {
				if (P('show_export_ilosc', "1") != "0") {
			$data = $data . $resultWydanie['wdn_ilosc'] . $separator;
				}
				if (P('show_export_produkt', "1") != "0") {
					$parentValue = virgoProdukt::lookup($resultWydanie['wdn_prd_id']);
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
				$reportTitle = T('WYDANIA');
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
			$resultWydanie = new virgoWydanie();
			$whereClauseWydanie = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseWydanie = $whereClauseWydanie . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_ilosc', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Ilość');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_produkt', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Produkt ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoProdukt::getVirgoList();
					$formulaProdukt = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaProdukt != "") {
							$formulaProdukt = $formulaProdukt . ',';
						}
						$formulaProdukt = $formulaProdukt . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_wydania.wdn_id, slk_wydania.wdn_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_ilosc', "1") != "0") {
				$queryString = $queryString . ", slk_wydania.wdn_ilosc wdn_ilosc";
			} else {
				if ($defaultOrderColumn == "wdn_ilosc") {
					$orderColumnNotDisplayed = " slk_wydania.wdn_ilosc ";
				}
			}
			if (class_exists('sealock\virgoProdukt') && P('show_export_produkt', "1") != "0") { // */ && !in_array("prd", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_wydania.wdn_prd_id as wdn_prd_id ";
				$queryString = $queryString . ", slk_produkty_parent.prd_virgo_title as `produkt` ";
			} else {
				if ($defaultOrderColumn == "produkt") {
					$orderColumnNotDisplayed = " slk_produkty_parent.prd_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_wydania ";
			if (class_exists('sealock\virgoProdukt')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_produkty AS slk_produkty_parent ON (slk_wydania.wdn_prd_id = slk_produkty_parent.prd_id) ";
			}

			$resultsWydanie = $resultWydanie->select(
				'', 
				'all', 
				$resultWydanie->getOrderColumn(), 
				$resultWydanie->getOrderMode(), 
				$whereClauseWydanie,
				$queryString);
			$index = 1;
			foreach ($resultsWydanie as $resultWydanie) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultWydanie['wdn_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_ilosc', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultWydanie['wdn_ilosc'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_produkt', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoProdukt::lookup($resultWydanie['wdn_prd_id']);
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
					$objValidation->setFormula1('"' . $formulaProdukt . '"');
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
					$propertyColumnHash['ilo\u015B\u0107'] = 'wdn_ilosc';
					$propertyColumnHash['ilosc'] = 'wdn_ilosc';
					$propertyClassHash['produkt'] = 'Produkt';
					$propertyClassHash['produkt'] = 'Produkt';
					$propertyColumnHash['produkt'] = 'wdn_prd_id';
					$propertyColumnHash['produkt'] = 'wdn_prd_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importWydanie = new virgoWydanie();
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
										L(T('PROPERTY_NOT_FOUND', T('WYDANIE'), $columns[$index]), '', 'ERROR');
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
										$importWydanie->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_produkt');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoProdukt::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoProdukt::token2Id($tmpToken);
	}
	$importWydanie->setPrdId($defaultValue);
}
							$errorMessage = $importWydanie->store();
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
		




		static function portletActionVirgoSetProdukt() {
			$this->loadFromDB();
			$parentId = R('wdn_Produkt_id_' . $_SESSION['current_portlet_object_id']);
			$this->setPrdId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}

		static function portletActionAddProdukt() {
			self::setDisplayMode("ADD_NEW_PARENT_PRODUKT");
		}

		static function portletActionStoreNewProdukt() {
			$id = -1;
			if (virgoProdukt::portletActionStore(true, $id) == -1) {
				self::setDisplayMode("ADD_NEW_PARENT_PRODUKT");
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			} else {
				$tmpId = self::loadIdFromRequest();
				$_POST['wdn_produkt_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
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
CREATE TABLE IF NOT EXISTS `slk_wydania` (
  `wdn_id` bigint(20) unsigned NOT NULL auto_increment,
  `wdn_virgo_state` varchar(50) default NULL,
  `wdn_virgo_title` varchar(255) default NULL,
	`wdn_prd_id` int(11) default NULL,
  `wdn_ilosc` decimal(10,2),  
  `wdn_date_created` datetime NOT NULL,
  `wdn_date_modified` datetime default NULL,
  `wdn_usr_created_id` int(11) NOT NULL,
  `wdn_usr_modified_id` int(11) default NULL,
  KEY `wdn_prd_fk` (`wdn_prd_id`),
  PRIMARY KEY  (`wdn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/wydanie.sql 
INSERT INTO `slk_wydania` (`wdn_virgo_title`, `wdn_ilosc`) 
VALUES (title, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably slk_wydania table already exists.", '', 'FATAL');
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
			return "wdn";
		}
		
		static function getPlural() {
			return "wydania";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoProdukt";
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoPozycjaZamowienia";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'slk_wydania'));
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
			$virgoVersion = virgoWydanie::getVirgoVersion();
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
	
	

