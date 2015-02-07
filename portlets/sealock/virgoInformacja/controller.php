<?php
/**
* Module Informacja
* @package Sealock
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace sealock;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	

	class virgoInformacja {

		 private  $inf_id = null;
		 private  $inf_tytul = null;

		 private  $inf_tresc = null;

		 private  $inf_widoczna = null;


		 private   $inf_date_created = null;
		 private   $inf_usr_created_id = null;
		 private   $inf_date_modified = null;
		 private   $inf_usr_modified_id = null;
		 private   $inf_virgo_title = null;
		
		 private   $internalLog = null;		
				
		 private  function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		public function isDeletedVirgo() {
			return $this->inf_virgo_deleted;
		}

		static public function createGuiAware() {
			$ret = new virgoInformacja();
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
        	$this->inf_id = null;
		    $this->inf_date_created = null;
		    $this->inf_usr_created_id = null;
		    $this->inf_date_modified = null;
		    $this->inf_usr_modified_id = null;
		    $this->inf_virgo_title = null;
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
			return $this->inf_id;
		}

		function getTytul() {
			return $this->inf_tytul;
		}
		
		 private  function setTytul($val) {
			$this->inf_tytul = $val;
		}
		function getTresc() {
			return $this->inf_tresc;
		}
		
		 private  function setTresc($val) {
			$this->inf_tresc = $val;
		}
		function getWidoczna() {
			return $this->inf_widoczna;
		}
		
		 private  function setWidoczna($val) {
			$this->inf_widoczna = $val;
		}


		function getDateCreated() {
			return $this->inf_date_created;
		}
		function getUsrCreatedId() {
			return $this->inf_usr_created_id;
		}
		function getDateModified() {
			return $this->inf_date_modified;
		}
		function getUsrModifiedId() {
			return $this->inf_usr_modified_id;
		}



		static function getTrescPdfUrlStatic($tmpId) {
			$ret = "";
			$ret .= $_SESSION['portal_url'];
			$ret .= "?virgo_media=true";
			$ret .= "&virgo_media_type=html2pdf";
			$ret .= "&virgo_media_table_name=slk_informacje";
			$ret .= "&virgo_media_table_prefix=inf";
			$ret .= "&virgo_media_property_name=tresc";
			$ret .= "&virgo_media_row_id=" . $tmpId;
			$ret .= "&" . getTokenName($tmpId) . "=" . getTokenValue($tmpId);
			return $ret;
		}
		function getTrescPdfUrl() {
			if (!is_null($this->getId())) {
				if (!is_null($this->inf_tresc)) {
					return virgoInformacja::getTrescPdfUrlStatic($this->inf_id);
				}
			}
			return "";
		}
		function loadRecordFromRequest($rowId) {
			$this->inf_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('inf_tytul_' . $this->inf_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->inf_tytul = null;
		} else {
			$this->inf_tytul = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('inf_tresc_' . $this->inf_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->inf_tresc = null;
		} else {
			$this->inf_tresc = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('inf_widoczna_' . $this->inf_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->inf_widoczna = null;
		} else {
			$this->inf_widoczna = $tmpValue;
		}
	}

		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('inf_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaInformacja = array();	
			$criteriaFieldInformacja = array();	
			$isNullInformacja = R('virgo_search_tytul_is_null');
			
			$criteriaFieldInformacja["is_null"] = 0;
			if ($isNullInformacja == "not_null") {
				$criteriaFieldInformacja["is_null"] = 1;
			} elseif ($isNullInformacja == "null") {
				$criteriaFieldInformacja["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_tytul');

//			if ($isSet) {
			$criteriaFieldInformacja["value"] = $dataTypeCriteria;
//			}
			$criteriaInformacja["tytul"] = $criteriaFieldInformacja;
			$criteriaFieldInformacja = array();	
			$isNullInformacja = R('virgo_search_tresc_is_null');
			
			$criteriaFieldInformacja["is_null"] = 0;
			if ($isNullInformacja == "not_null") {
				$criteriaFieldInformacja["is_null"] = 1;
			} elseif ($isNullInformacja == "null") {
				$criteriaFieldInformacja["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
//			if ($isSet) {
			$criteriaFieldInformacja["value"] = $dataTypeCriteria;
//			}
			$criteriaInformacja["tresc"] = $criteriaFieldInformacja;
			$criteriaFieldInformacja = array();	
			$isNullInformacja = R('virgo_search_widoczna_is_null');
			
			$criteriaFieldInformacja["is_null"] = 0;
			if ($isNullInformacja == "not_null") {
				$criteriaFieldInformacja["is_null"] = 1;
			} elseif ($isNullInformacja == "null") {
				$criteriaFieldInformacja["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_widoczna');

//			if ($isSet) {
			$criteriaFieldInformacja["value"] = $dataTypeCriteria;
//			}
			$criteriaInformacja["widoczna"] = $criteriaFieldInformacja;
			self::setCriteria($criteriaInformacja);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_tytul');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterTytul', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTytul', null);
			}
			$tableFilter = R('virgo_filter_tresc');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterTresc', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTresc', null);
			}
			$tableFilter = R('virgo_filter_widoczna');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterWidoczna', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterWidoczna', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseInformacja = ' 1 = 1 ';
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
				$eventColumn = "inf_" . P('event_column');
				$whereClauseInformacja = $whereClauseInformacja . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseInformacja = $whereClauseInformacja . ' AND ' . $parentContextInfo['condition'];
			}
			$filter = "";
			$criteriaInformacja = self::getCriteria();
			if (isset($criteriaInformacja["tytul"])) {
				$fieldCriteriaTytul = $criteriaInformacja["tytul"];
				if ($fieldCriteriaTytul["is_null"] == 1) {
$filter = $filter . ' AND slk_informacje.inf_tytul IS NOT NULL ';
				} elseif ($fieldCriteriaTytul["is_null"] == 2) {
$filter = $filter . ' AND slk_informacje.inf_tytul IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaTytul["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_informacje.inf_tytul like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaInformacja["tresc"])) {
				$fieldCriteriaTresc = $criteriaInformacja["tresc"];
				if ($fieldCriteriaTresc["is_null"] == 1) {
$filter = $filter . ' AND slk_informacje.inf_tresc IS NOT NULL ';
				} elseif ($fieldCriteriaTresc["is_null"] == 2) {
$filter = $filter . ' AND slk_informacje.inf_tresc IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaTresc["value"];
				}
			}
			if (isset($criteriaInformacja["widoczna"])) {
				$fieldCriteriaWidoczna = $criteriaInformacja["widoczna"];
				if ($fieldCriteriaWidoczna["is_null"] == 1) {
$filter = $filter . ' AND slk_informacje.inf_widoczna IS NOT NULL ';
				} elseif ($fieldCriteriaWidoczna["is_null"] == 2) {
$filter = $filter . ' AND slk_informacje.inf_widoczna IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaWidoczna["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND slk_informacje.inf_widoczna = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			$whereClauseInformacja = $whereClauseInformacja . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseInformacja = $whereClauseInformacja . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseInformacja = $whereClauseInformacja . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterTytul', null);
				if (S($tableFilter)) {
					$whereClauseInformacja = $whereClauseInformacja . " AND inf_tytul LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterTresc', null);
				if (S($tableFilter)) {
					$whereClauseInformacja = $whereClauseInformacja . " AND inf_tresc LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterWidoczna', null);
				if (S($tableFilter)) {
					$whereClauseInformacja = $whereClauseInformacja . " AND inf_widoczna LIKE '%{$tableFilter}%' ";
				}
			}
			return $whereClauseInformacja;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseInformacja = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT slk_informacje.inf_id, slk_informacje.inf_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_tytul', "1") != "0") {
				$queryString = $queryString . ", slk_informacje.inf_tytul inf_tytul";
			} else {
				if ($defaultOrderColumn == "inf_tytul") {
					$orderColumnNotDisplayed = " slk_informacje.inf_tytul ";
				}
			}
			if (P('show_table_tresc', "1") != "0") {
				$queryString = $queryString . ", slk_informacje.inf_tresc inf_tresc";
			} else {
				if ($defaultOrderColumn == "inf_tresc") {
					$orderColumnNotDisplayed = " slk_informacje.inf_tresc ";
				}
			}
			if (P('show_table_widoczna', "1") != "0") {
				$queryString = $queryString . ", slk_informacje.inf_widoczna inf_widoczna";
			} else {
				if ($defaultOrderColumn == "inf_widoczna") {
					$orderColumnNotDisplayed = " slk_informacje.inf_widoczna ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_informacje ";

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseInformacja = $whereClauseInformacja . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseInformacja, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseInformacja,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM slk_informacje"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " inf_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " inf_usr_created_id = ? ";
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
				. "\n FROM slk_informacje"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as slk_informacje ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as slk_informacje ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, inf_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " inf_usr_created_id = ? ";
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
				$query = "SELECT COUNT(inf_id) cnt FROM informacje";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as informacje ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as informacje ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoInformacja();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM slk_informacje WHERE inf_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->inf_id = $row['inf_id'];
$this->inf_tytul = $row['inf_tytul'];
$this->inf_tresc = $row['inf_tresc'];
$this->inf_widoczna = $row['inf_widoczna'];
						if ($fetchUsernames) {
							if ($row['inf_date_created']) {
								if ($row['inf_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['inf_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['inf_date_modified']) {
								if ($row['inf_usr_modified_id'] == $row['inf_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['inf_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['inf_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->inf_date_created = $row['inf_date_created'];
						$this->inf_usr_created_id = $fetchUsernames ? $createdBy : $row['inf_usr_created_id'];
						$this->inf_date_modified = $row['inf_date_modified'];
						$this->inf_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['inf_usr_modified_id'];
						$this->inf_virgo_title = $row['inf_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE slk_informacje SET inf_usr_created_id = {$userId} WHERE inf_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->inf_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoInformacja::selectAllAsObjectsStatic('inf_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->inf_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->inf_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('inf_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_inf = new virgoInformacja();
				$tmp_inf->load((int)$lookup_id);
				return $tmp_inf->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoInformacja');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" inf_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoInformacja', "10");
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
				$query = $query . " inf_id as id, inf_virgo_title as title ";
			}
			$query = $query . " FROM slk_informacje ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoInformacja', 'sealock') == "1") {
				$privateCondition = " inf_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY inf_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resInformacja = array();
				foreach ($rows as $row) {
					$resInformacja[$row['id']] = $row['title'];
				}
				return $resInformacja;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticInformacja = new virgoInformacja();
			return $staticInformacja->getVirgoList($where, $sizeOnly, $hash);
		}
		


		function validateObject($virgoOld) {
			if (
(is_null($this->getTytul()) || trim($this->getTytul()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'TYTUL');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_tresc_obligatory', "0") == "1") {
				if (
(is_null($this->getTresc()) || trim($this->getTresc()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'TRESC');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_widoczna_obligatory', "0") == "1") {
				if (
(is_null($this->getWidoczna()) || trim($this->getWidoczna()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'WIDOCZNA');
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  slk_history_informacje WHERE inf_id = " . $this->getId();
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
				$colNames = $colNames . ", inf_tytul";
				$values = $values . ", " . (is_null($objectToStore->getTytul()) ? "null" : "'" . QE($objectToStore->getTytul()) . "'");
				$colNames = $colNames . ", inf_tresc";
				$values = $values . ", " . (is_null($objectToStore->getTresc()) ? "null" : "'" . QE($objectToStore->getTresc()) . "'");
				$colNames = $colNames . ", inf_widoczna";
				$values = $values . ", " . (is_null($objectToStore->getWidoczna()) ? "null" : "'" . QE($objectToStore->getWidoczna()) . "'");
				$query = "INSERT INTO slk_history_informacje (revision, ip, username, user_id, timestamp, inf_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getTytul() != $objectToStore->getTytul()) {
				if (is_null($objectToStore->getTytul())) {
					$nullifiedProperties = $nullifiedProperties . "tytul,";
				} else {
				$colNames = $colNames . ", inf_tytul";
				$values = $values . ", " . (is_null($objectToStore->getTytul()) ? "null" : "'" . QE($objectToStore->getTytul()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getTresc() != $objectToStore->getTresc()) {
				if (is_null($objectToStore->getTresc())) {
					$nullifiedProperties = $nullifiedProperties . "tresc,";
				} else {
				$colNames = $colNames . ", inf_tresc";
				$values = $values . ", " . (is_null($objectToStore->getTresc()) ? "null" : "'" . QE($objectToStore->getTresc()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getWidoczna() != $objectToStore->getWidoczna()) {
				if (is_null($objectToStore->getWidoczna())) {
					$nullifiedProperties = $nullifiedProperties . "widoczna,";
				} else {
				$colNames = $colNames . ", inf_widoczna";
				$values = $values . ", " . (is_null($objectToStore->getWidoczna()) ? "null" : "'" . QE($objectToStore->getWidoczna()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			$query = "INSERT INTO slk_history_informacje (revision, ip, username, user_id, timestamp, inf_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM slk_informacje");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'inf_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE slk_informacje ADD COLUMN (inf_virgo_title VARCHAR(255));";
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
			if (isset($this->inf_id) && $this->inf_id != "") {
				$query = "UPDATE slk_informacje SET ";
			if (isset($this->inf_tytul)) {
				$query .= " inf_tytul = ? ,";
				$types .= "s";
				$values[] = $this->inf_tytul;
			} else {
				$query .= " inf_tytul = NULL ,";				
			}
			if (isset($this->inf_tresc)) {
				$query .= " inf_tresc = ? ,";
				$types .= "s";
				$values[] = $this->inf_tresc;
			} else {
				$query .= " inf_tresc = NULL ,";				
			}
			if (isset($this->inf_widoczna)) {
				$query .= " inf_widoczna = ? ,";
				$types .= "s";
				$values[] = $this->inf_widoczna;
			} else {
				$query .= " inf_widoczna = NULL ,";				
			}
				$query = $query . " inf_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " inf_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->inf_date_modified;

				$query = $query . " inf_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->inf_usr_modified_id;

				$query = $query . " WHERE inf_id = ? ";
				$types = $types . "i";
				$values[] = $this->inf_id;
			} else {
				$query = "INSERT INTO slk_informacje ( ";
			$query = $query . " inf_tytul, ";
			$query = $query . " inf_tresc, ";
			$query = $query . " inf_widoczna, ";
				$query = $query . " inf_virgo_title, inf_date_created, inf_usr_created_id) VALUES ( ";
			if (isset($this->inf_tytul)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->inf_tytul;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->inf_tresc)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->inf_tresc;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->inf_widoczna)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->inf_widoczna;
			} else {
				$query .= " NULL ,";				
			}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->inf_date_created;
				$values[] = $this->inf_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->inf_id) || $this->inf_id == "") {
					$this->inf_id = QID();
				}
				if ($log) {
					L("informacja stored successfully", "id = {$this->inf_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->inf_id) {
				$virgoOld = new virgoInformacja($this->inf_id);
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
					if ($this->inf_id) {			
						$this->inf_date_modified = date("Y-m-d H:i:s");
						$this->inf_usr_modified_id = $userId;
					} else {
						$this->inf_date_created = date("Y-m-d H:i:s");
						$this->inf_usr_created_id = $userId;
					}
					$this->inf_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "informacja" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "informacja" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM slk_informacje WHERE inf_id = {$this->inf_id}";
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
			$tmp = new virgoInformacja();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT inf_id as id FROM slk_informacje";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'inf_order_column')) {
				$orderBy = " ORDER BY inf_order_column ASC ";
			} 
			if (property_exists($this, 'inf_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY inf_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoInformacja();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoInformacja($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE slk_informacje SET inf_virgo_title = '$title' WHERE inf_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoInformacja();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" inf_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['inf_id'];
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
			virgoInformacja::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoInformacja::setSessionValue('Sealock_Informacja-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoInformacja::getSessionValue('Sealock_Informacja-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoInformacja::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoInformacja::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoInformacja::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoInformacja::getSessionValue('GLOBAL', $name, $default);
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
			$context['inf_id'] = $id;
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
			$context['inf_id'] = null;
			virgoInformacja::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoInformacja::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoInformacja::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoInformacja::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoInformacja::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoInformacja::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoInformacja::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoInformacja::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoInformacja::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoInformacja::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoInformacja::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoInformacja::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoInformacja::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoInformacja::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoInformacja::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoInformacja::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoInformacja::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "inf_id";
			}
			return virgoInformacja::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoInformacja::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoInformacja::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoInformacja::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoInformacja::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoInformacja::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoInformacja::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoInformacja::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoInformacja::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoInformacja::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoInformacja::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoInformacja::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoInformacja::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->inf_id) {
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
						L(T('STORED_CORRECTLY', 'INFORMACJA'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'tytuł', $this->inf_tytul);
						$fieldValues = $fieldValues . T($fieldValue, 'treść', $this->inf_tresc);
						$fieldValues = $fieldValues . T($fieldValue, 'widoczna', $this->inf_widoczna);
						$username = '';
						if ($this->inf_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->inf_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->inf_date_created);
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
			$instance = new virgoInformacja();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoInformacja'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			$instance = new virgoInformacja();
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
			$tmpId = intval(R('inf_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoInformacja::getContextId();
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
			$this->inf_id = null;
			$this->inf_date_created = null;
			$this->inf_usr_created_id = null;
			$this->inf_date_modified = null;
			$this->inf_usr_modified_id = null;
			$this->inf_virgo_title = null;
			
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
//			$ret = new virgoInformacja();
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
				$instance = new virgoInformacja();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoInformacja::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'INFORMACJA'), '', 'INFO');
					return 0;
					
				} else {
					L($res, '', 'ERROR');
					return -1;
				}
			}
		}
		
		
		static function portletActionVirgoTrescAsPdf() {
			$instance = new virgoInformacja();
			$instance->loadFromDB();
			$instance->generateTrescAsPdf();
		}
		function generateTrescAsPdf() {
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
			$pdf->writeHTML($this->getTresc(), true, false, true, false, '');
			$pdf->Output('Informacja_Tresc_' . $this->getId() . '.pdf', 'I'); 			ini_set('display_errors', '1');
			return 0;			
		}
		static function portletActionVirgoSetWidocznaTrue() {
			$instance = new virgoInformacja();
			$instance->loadFromDB();
			$instance->setWidoczna(1);
			$ret = $instance->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetWidocznaFalse() {
			$instance = new virgoInformacja();
			$instance->loadFromDB();
			$instance->setWidoczna(0);
			$ret = $instance->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isWidoczna() {
			return $this->getWidoczna() == 1;
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
				$resultInformacja = new virgoInformacja();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultInformacja->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultInformacja->load($idToEditInt);
					} else {
						$resultInformacja->inf_id = 0;
					}
				}
				$results[] = $resultInformacja;
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
				$result = new virgoInformacja();
				$result->loadFromRequest($idToStore);
				if ($result->inf_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->inf_id == 0) {
						$result->inf_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->inf_id)) {
							$result->inf_id = 0;
						}
						$idsToCorrect[$result->inf_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'INFORMACJE'), '', 'INFO');
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
			$resultInformacja = new virgoInformacja();
			foreach ($idsToDelete as $idToDelete) {
				$resultInformacja->load((int)trim($idToDelete));
				$res = $resultInformacja->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'INFORMACJE'), '', 'INFO');			
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
		$ret = $this->inf_tytul;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoInformacja');
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
				$query = "UPDATE slk_informacje SET inf_virgo_title = ? WHERE inf_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT inf_id AS id FROM slk_informacje ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoInformacja($row['id']);
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
						$parentInfo['condition'] = 'slk_informacje.inf_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'slk_informacje.inf_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'slk_informacje.inf_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM slk_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'slk_informacje.inf_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoInformacja!', '', 'ERROR');
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
			$pdf->SetTitle('Informacje report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('INFORMACJE');
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
			if (P('show_pdf_tytul', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_tresc', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_widoczna', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultInformacja = new virgoInformacja();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_tytul', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Tytuł');
				$minWidth['tytu\u0142'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['tytu\u0142']) {
						$minWidth['tytu\u0142'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_tresc', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Treść');
				$minWidth['tre\u015B\u0107'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['tre\u015B\u0107']) {
						$minWidth['tre\u015B\u0107'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_widoczna', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Widoczna');
				$minWidth['widoczna'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['widoczna']) {
						$minWidth['widoczna'] = min($tmpLen, $maxWidth);
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
			$whereClauseInformacja = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseInformacja = $whereClauseInformacja . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaInformacja = $resultInformacja->getCriteria();
			$fieldCriteriaTytul = $criteriaInformacja["tytul"];
			if ($fieldCriteriaTytul["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Tytuł', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaTytul["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Tytuł', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaTresc = $criteriaInformacja["tresc"];
			if ($fieldCriteriaTresc["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Treść', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaTresc["value"];
				$renderCriteria = "";
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Treść', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaWidoczna = $criteriaInformacja["widoczna"];
			if ($fieldCriteriaWidoczna["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Widoczna', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaWidoczna["value"];
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
					$pdf->MultiCell(60, 100, 'Widoczna', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$filter = "";
			$criteriaInformacja = self::getCriteria();
			if (isset($criteriaInformacja["tytul"])) {
				$fieldCriteriaTytul = $criteriaInformacja["tytul"];
				if ($fieldCriteriaTytul["is_null"] == 1) {
$filter = $filter . ' AND slk_informacje.inf_tytul IS NOT NULL ';
				} elseif ($fieldCriteriaTytul["is_null"] == 2) {
$filter = $filter . ' AND slk_informacje.inf_tytul IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaTytul["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_informacje.inf_tytul like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaInformacja["tresc"])) {
				$fieldCriteriaTresc = $criteriaInformacja["tresc"];
				if ($fieldCriteriaTresc["is_null"] == 1) {
$filter = $filter . ' AND slk_informacje.inf_tresc IS NOT NULL ';
				} elseif ($fieldCriteriaTresc["is_null"] == 2) {
$filter = $filter . ' AND slk_informacje.inf_tresc IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaTresc["value"];
				}
			}
			if (isset($criteriaInformacja["widoczna"])) {
				$fieldCriteriaWidoczna = $criteriaInformacja["widoczna"];
				if ($fieldCriteriaWidoczna["is_null"] == 1) {
$filter = $filter . ' AND slk_informacje.inf_widoczna IS NOT NULL ';
				} elseif ($fieldCriteriaWidoczna["is_null"] == 2) {
$filter = $filter . ' AND slk_informacje.inf_widoczna IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaWidoczna["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND slk_informacje.inf_widoczna = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			$whereClauseInformacja = $whereClauseInformacja . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseInformacja = $whereClauseInformacja . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT slk_informacje.inf_id, slk_informacje.inf_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_tytul', "1") != "0") {
				$queryString = $queryString . ", slk_informacje.inf_tytul inf_tytul";
			} else {
				if ($defaultOrderColumn == "inf_tytul") {
					$orderColumnNotDisplayed = " slk_informacje.inf_tytul ";
				}
			}
			if (P('show_pdf_tresc', "1") != "0") {
				$queryString = $queryString . ", slk_informacje.inf_tresc inf_tresc";
			} else {
				if ($defaultOrderColumn == "inf_tresc") {
					$orderColumnNotDisplayed = " slk_informacje.inf_tresc ";
				}
			}
			if (P('show_pdf_widoczna', "1") != "0") {
				$queryString = $queryString . ", slk_informacje.inf_widoczna inf_widoczna";
			} else {
				if ($defaultOrderColumn == "inf_widoczna") {
					$orderColumnNotDisplayed = " slk_informacje.inf_widoczna ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_informacje ";

		$resultsInformacja = $resultInformacja->select(
			'', 
			'all', 
			$resultInformacja->getOrderColumn(), 
			$resultInformacja->getOrderMode(), 
			$whereClauseInformacja,
			$queryString);
		
		foreach ($resultsInformacja as $resultInformacja) {

			if (P('show_pdf_tytul', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultInformacja['inf_tytul'])) + 6;
				if ($tmpLen > $minWidth['tytu\u0142']) {
					$minWidth['tytu\u0142'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_tresc', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultInformacja['inf_tresc'])) + 6;
				if ($tmpLen > $minWidth['tre\u015B\u0107']) {
					$minWidth['tre\u015B\u0107'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_widoczna', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultInformacja['inf_widoczna'])) + 6;
				if ($tmpLen > $minWidth['widoczna']) {
					$minWidth['widoczna'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaInformacja = $resultInformacja->getCriteria();
		if (is_null($criteriaInformacja) || sizeof($criteriaInformacja) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																		if (P('show_pdf_tytul', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['tytu\u0142'], $colHeight, T('TYTUL'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_tresc', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['tre\u015B\u0107'], $colHeight, T('TRESC'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_widoczna', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['widoczna'], $colHeight, T('WIDOCZNA'), 'T', 'C', 0, 0);
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
		foreach ($resultsInformacja as $resultInformacja) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_tytul', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['tytu\u0142'], $colHeight, '' . $resultInformacja['inf_tytul'], 'T', 'L', 0, 0);
				if (P('show_pdf_tytul', "1") == "2") {
										if (!is_null($resultInformacja['inf_tytul'])) {
						$tmpCount = (float)$counts["tytul"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["tytul"] = $tmpCount;
					}
				}
				if (P('show_pdf_tytul', "1") == "3") {
										if (!is_null($resultInformacja['inf_tytul'])) {
						$tmpSum = (float)$sums["tytul"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultInformacja['inf_tytul'];
						}
						$sums["tytul"] = $tmpSum;
					}
				}
				if (P('show_pdf_tytul', "1") == "4") {
										if (!is_null($resultInformacja['inf_tytul'])) {
						$tmpCount = (float)$avgCounts["tytul"];
						$tmpSum = (float)$avgSums["tytul"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["tytul"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultInformacja['inf_tytul'];
						}
						$avgSums["tytul"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_tresc', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['tre\u015B\u0107'], $colHeight, '' . $resultInformacja['inf_tresc'], 'T', 'L', 0, 0);
				if (P('show_pdf_tresc', "1") == "2") {
										if (!is_null($resultInformacja['inf_tresc'])) {
						$tmpCount = (float)$counts["tresc"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["tresc"] = $tmpCount;
					}
				}
				if (P('show_pdf_tresc', "1") == "3") {
										if (!is_null($resultInformacja['inf_tresc'])) {
						$tmpSum = (float)$sums["tresc"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultInformacja['inf_tresc'];
						}
						$sums["tresc"] = $tmpSum;
					}
				}
				if (P('show_pdf_tresc', "1") == "4") {
										if (!is_null($resultInformacja['inf_tresc'])) {
						$tmpCount = (float)$avgCounts["tresc"];
						$tmpSum = (float)$avgSums["tresc"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["tresc"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultInformacja['inf_tresc'];
						}
						$avgSums["tresc"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_widoczna', "0") != "0") {
			$renderCriteria = "";
			switch ($resultInformacja['inf_widoczna']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['widoczna'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_widoczna', "1") == "2") {
										if (!is_null($resultInformacja['inf_widoczna'])) {
						$tmpCount = (float)$counts["widoczna"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["widoczna"] = $tmpCount;
					}
				}
				if (P('show_pdf_widoczna', "1") == "3") {
										if (!is_null($resultInformacja['inf_widoczna'])) {
						$tmpSum = (float)$sums["widoczna"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultInformacja['inf_widoczna'];
						}
						$sums["widoczna"] = $tmpSum;
					}
				}
				if (P('show_pdf_widoczna', "1") == "4") {
										if (!is_null($resultInformacja['inf_widoczna'])) {
						$tmpCount = (float)$avgCounts["widoczna"];
						$tmpSum = (float)$avgSums["widoczna"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["widoczna"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultInformacja['inf_widoczna'];
						}
						$avgSums["widoczna"] = $tmpSum;
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
			if (P('show_pdf_tytul', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['tytu\u0142'];
				if (P('show_pdf_tytul', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["tytul"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_tresc', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['tre\u015B\u0107'];
				if (P('show_pdf_tresc', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["tresc"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_widoczna', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['widoczna'];
				if (P('show_pdf_widoczna', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["widoczna"];
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
			if (P('show_pdf_tytul', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['tytu\u0142'];
				if (P('show_pdf_tytul', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["tytul"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_tresc', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['tre\u015B\u0107'];
				if (P('show_pdf_tresc', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["tresc"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_widoczna', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['widoczna'];
				if (P('show_pdf_widoczna', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["widoczna"], 2, ',', ' ');
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
			if (P('show_pdf_tytul', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['tytu\u0142'];
				if (P('show_pdf_tytul', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["tytul"] == 0 ? "-" : $avgSums["tytul"] / $avgCounts["tytul"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_tresc', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['tre\u015B\u0107'];
				if (P('show_pdf_tresc', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["tresc"] == 0 ? "-" : $avgSums["tresc"] / $avgCounts["tresc"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_widoczna', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['widoczna'];
				if (P('show_pdf_widoczna', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["widoczna"] == 0 ? "-" : $avgSums["widoczna"] / $avgCounts["widoczna"]);
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
				$reportTitle = T('INFORMACJE');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultInformacja = new virgoInformacja();
			$whereClauseInformacja = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseInformacja = $whereClauseInformacja . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_tytul', "1") != "0") {
					$data = $data . $stringDelimeter .'Tytuł' . $stringDelimeter . $separator;
				}
				if (P('show_export_tresc', "1") != "0") {
					$data = $data . $stringDelimeter .'Treść' . $stringDelimeter . $separator;
				}
				if (P('show_export_widoczna', "1") != "0") {
					$data = $data . $stringDelimeter .'Widoczna' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_informacje.inf_id, slk_informacje.inf_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_tytul', "1") != "0") {
				$queryString = $queryString . ", slk_informacje.inf_tytul inf_tytul";
			} else {
				if ($defaultOrderColumn == "inf_tytul") {
					$orderColumnNotDisplayed = " slk_informacje.inf_tytul ";
				}
			}
			if (P('show_export_tresc', "1") != "0") {
				$queryString = $queryString . ", slk_informacje.inf_tresc inf_tresc";
			} else {
				if ($defaultOrderColumn == "inf_tresc") {
					$orderColumnNotDisplayed = " slk_informacje.inf_tresc ";
				}
			}
			if (P('show_export_widoczna', "1") != "0") {
				$queryString = $queryString . ", slk_informacje.inf_widoczna inf_widoczna";
			} else {
				if ($defaultOrderColumn == "inf_widoczna") {
					$orderColumnNotDisplayed = " slk_informacje.inf_widoczna ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_informacje ";

			$resultsInformacja = $resultInformacja->select(
				'', 
				'all', 
				$resultInformacja->getOrderColumn(), 
				$resultInformacja->getOrderMode(), 
				$whereClauseInformacja,
				$queryString);
			foreach ($resultsInformacja as $resultInformacja) {
				if (P('show_export_tytul', "1") != "0") {
			$data = $data . $stringDelimeter . $resultInformacja['inf_tytul'] . $stringDelimeter . $separator;
				}
				if (P('show_export_tresc', "1") != "0") {
			$data = $data . $resultInformacja['inf_tresc'] . $separator;
				}
				if (P('show_export_widoczna', "1") != "0") {
			$data = $data . $resultInformacja['inf_widoczna'] . $separator;
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
				$reportTitle = T('INFORMACJE');
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
			$resultInformacja = new virgoInformacja();
			$whereClauseInformacja = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseInformacja = $whereClauseInformacja . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_tytul', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Tytuł');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_tresc', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Treść');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_widoczna', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Widoczna');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_informacje.inf_id, slk_informacje.inf_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_tytul', "1") != "0") {
				$queryString = $queryString . ", slk_informacje.inf_tytul inf_tytul";
			} else {
				if ($defaultOrderColumn == "inf_tytul") {
					$orderColumnNotDisplayed = " slk_informacje.inf_tytul ";
				}
			}
			if (P('show_export_tresc', "1") != "0") {
				$queryString = $queryString . ", slk_informacje.inf_tresc inf_tresc";
			} else {
				if ($defaultOrderColumn == "inf_tresc") {
					$orderColumnNotDisplayed = " slk_informacje.inf_tresc ";
				}
			}
			if (P('show_export_widoczna', "1") != "0") {
				$queryString = $queryString . ", slk_informacje.inf_widoczna inf_widoczna";
			} else {
				if ($defaultOrderColumn == "inf_widoczna") {
					$orderColumnNotDisplayed = " slk_informacje.inf_widoczna ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_informacje ";

			$resultsInformacja = $resultInformacja->select(
				'', 
				'all', 
				$resultInformacja->getOrderColumn(), 
				$resultInformacja->getOrderMode(), 
				$whereClauseInformacja,
				$queryString);
			$index = 1;
			foreach ($resultsInformacja as $resultInformacja) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultInformacja['inf_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_tytul', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultInformacja['inf_tytul'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_tresc', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultInformacja['inf_tresc'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_widoczna', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultInformacja['inf_widoczna'], \PHPExcel_Cell_DataType::TYPE_STRING);
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
					$propertyColumnHash['tytu\u0142'] = 'inf_tytul';
					$propertyColumnHash['tytul'] = 'inf_tytul';
					$propertyColumnHash['tre\u015B\u0107'] = 'inf_tresc';
					$propertyColumnHash['tresc'] = 'inf_tresc';
					$propertyColumnHash['widoczna'] = 'inf_widoczna';
					$propertyColumnHash['widoczna'] = 'inf_widoczna';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importInformacja = new virgoInformacja();
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
										L(T('PROPERTY_NOT_FOUND', T('INFORMACJA'), $columns[$index]), '', 'ERROR');
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
										$importInformacja->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
							$errorMessage = $importInformacja->store();
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
CREATE TABLE IF NOT EXISTS `slk_informacje` (
  `inf_id` bigint(20) unsigned NOT NULL auto_increment,
  `inf_virgo_state` varchar(50) default NULL,
  `inf_virgo_title` varchar(255) default NULL,
  `inf_tytul` varchar(255), 
  `inf_tresc` longtext, 
  `inf_widoczna` boolean,  
  `inf_date_created` datetime NOT NULL,
  `inf_date_modified` datetime default NULL,
  `inf_usr_created_id` int(11) NOT NULL,
  `inf_usr_modified_id` int(11) default NULL,
  PRIMARY KEY  (`inf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/informacja.sql 
INSERT INTO `slk_informacje` (`inf_virgo_title`, `inf_tytul`, `inf_tresc`, `inf_widoczna`) 
VALUES (title, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably slk_informacje table already exists.", '', 'FATAL');
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
			return "inf";
		}
		
		static function getPlural() {
			return "informacje";
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
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'slk_informacje'));
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
			$virgoVersion = virgoInformacja::getVirgoVersion();
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
	
	

