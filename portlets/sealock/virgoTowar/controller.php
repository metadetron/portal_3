<?php
/**
* Module Towar
* @package Sealock
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace sealock;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoGrupaTowaru'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoJednostka'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoPozycjaZamowienia'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoProdukt'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoSkladnik'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoSkladnik'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoPozycjaBilansu'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoTowar {

		 private  $twr_id = null;
		 private  $twr_kod = null;

		 private  $twr_nazwa = null;

		 private  $twr_stan_aktualny = null;

		 private  $twr_stan_minimalny = null;

		 private  $twr_produkt = null;

		 private  $twr_gtw_id = null;
		 private  $twr_jdn_id = null;

		 private   $twr_date_created = null;
		 private   $twr_usr_created_id = null;
		 private   $twr_date_modified = null;
		 private   $twr_usr_modified_id = null;
		 private   $twr_virgo_title = null;
		
		 private   $internalLog = null;		
				
		 private  function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		public function isDeletedVirgo() {
			return $this->twr_virgo_deleted;
		}

		static public function createGuiAware() {
			$ret = new virgoTowar();
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
        	$this->twr_id = null;
		    $this->twr_date_created = null;
		    $this->twr_usr_created_id = null;
		    $this->twr_date_modified = null;
		    $this->twr_usr_modified_id = null;
		    $this->twr_virgo_title = null;
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
			return $this->twr_id;
		}

		function getKod() {
			return $this->twr_kod;
		}
		
		 private  function setKod($val) {
			$this->twr_kod = $val;
		}
		function getNazwa() {
			return $this->twr_nazwa;
		}
		
		 private  function setNazwa($val) {
			$this->twr_nazwa = $val;
		}
		function getStanAktualny() {
			return $this->twr_stan_aktualny;
		}
		
		 private  function setStanAktualny($val) {
			$this->twr_stan_aktualny = $val;
		}
		function getStanMinimalny() {
			return $this->twr_stan_minimalny;
		}
		
		 private  function setStanMinimalny($val) {
			$this->twr_stan_minimalny = $val;
		}
		function getProdukt() {
			return $this->twr_produkt;
		}
		
		 private  function setProdukt($val) {
			$this->twr_produkt = $val;
		}

		function getGrupaTowaruId() {
			return $this->twr_gtw_id;
		}
		
		 private  function setGrupaTowaruId($val) {
			$this->twr_gtw_id = $val;
		}
		function getJednostkaId() {
			return $this->twr_jdn_id;
		}
		
		 private  function setJednostkaId($val) {
			$this->twr_jdn_id = $val;
		}

		function getDateCreated() {
			return $this->twr_date_created;
		}
		function getUsrCreatedId() {
			return $this->twr_usr_created_id;
		}
		function getDateModified() {
			return $this->twr_date_modified;
		}
		function getUsrModifiedId() {
			return $this->twr_usr_modified_id;
		}


		function getGtwId() {
			return $this->getGrupaTowaruId();
		}
		
		 private  function setGtwId($val) {
			$this->setGrupaTowaruId($val);
		}
		function getJdnId() {
			return $this->getJednostkaId();
		}
		
		 private  function setJdnId($val) {
			$this->setJednostkaId($val);
		}

		function loadRecordFromRequest($rowId) {
			$this->twr_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('twr_kod_' . $this->twr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->twr_kod = null;
		} else {
			$this->twr_kod = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('twr_nazwa_' . $this->twr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->twr_nazwa = null;
		} else {
			$this->twr_nazwa = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('twr_stanAktualny_' . $this->twr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->twr_stan_aktualny = null;
		} else {
			$this->twr_stan_aktualny = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('twr_stanMinimalny_' . $this->twr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->twr_stan_minimalny = null;
		} else {
			$this->twr_stan_minimalny = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('twr_produkt_' . $this->twr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->twr_produkt = null;
		} else {
			$this->twr_produkt = $tmpValue;
		}
	}

			$this->twr_gtw_id = strval(R('twr_grupaTowaru_' . $this->twr_id));
			$this->twr_jdn_id = strval(R('twr_jednostka_' . $this->twr_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('twr_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaTowar = array();	
			$criteriaFieldTowar = array();	
			$isNullTowar = R('virgo_search_kod_is_null');
			
			$criteriaFieldTowar["is_null"] = 0;
			if ($isNullTowar == "not_null") {
				$criteriaFieldTowar["is_null"] = 1;
			} elseif ($isNullTowar == "null") {
				$criteriaFieldTowar["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_kod');

//			if ($isSet) {
			$criteriaFieldTowar["value"] = $dataTypeCriteria;
//			}
			$criteriaTowar["kod"] = $criteriaFieldTowar;
			$criteriaFieldTowar = array();	
			$isNullTowar = R('virgo_search_nazwa_is_null');
			
			$criteriaFieldTowar["is_null"] = 0;
			if ($isNullTowar == "not_null") {
				$criteriaFieldTowar["is_null"] = 1;
			} elseif ($isNullTowar == "null") {
				$criteriaFieldTowar["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_nazwa');

//			if ($isSet) {
			$criteriaFieldTowar["value"] = $dataTypeCriteria;
//			}
			$criteriaTowar["nazwa"] = $criteriaFieldTowar;
			$criteriaFieldTowar = array();	
			$isNullTowar = R('virgo_search_stanAktualny_is_null');
			
			$criteriaFieldTowar["is_null"] = 0;
			if ($isNullTowar == "not_null") {
				$criteriaFieldTowar["is_null"] = 1;
			} elseif ($isNullTowar == "null") {
				$criteriaFieldTowar["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_stanAktualny_from');
		if (!is_numeric($dataTypeCriteria["from"])) {
			$dataTypeCriteria["from"] = null;
		}
		$dataTypeCriteria["to"] = R('virgo_search_stanAktualny_to');
		if (!is_numeric($dataTypeCriteria["to"])) {
			$dataTypeCriteria["to"] = null;
		}

//			if ($isSet) {
			$criteriaFieldTowar["value"] = $dataTypeCriteria;
//			}
			$criteriaTowar["stan_aktualny"] = $criteriaFieldTowar;
			$criteriaFieldTowar = array();	
			$isNullTowar = R('virgo_search_stanMinimalny_is_null');
			
			$criteriaFieldTowar["is_null"] = 0;
			if ($isNullTowar == "not_null") {
				$criteriaFieldTowar["is_null"] = 1;
			} elseif ($isNullTowar == "null") {
				$criteriaFieldTowar["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_stanMinimalny_from');
		if (!is_numeric($dataTypeCriteria["from"])) {
			$dataTypeCriteria["from"] = null;
		}
		$dataTypeCriteria["to"] = R('virgo_search_stanMinimalny_to');
		if (!is_numeric($dataTypeCriteria["to"])) {
			$dataTypeCriteria["to"] = null;
		}

//			if ($isSet) {
			$criteriaFieldTowar["value"] = $dataTypeCriteria;
//			}
			$criteriaTowar["stan_minimalny"] = $criteriaFieldTowar;
			$criteriaFieldTowar = array();	
			$isNullTowar = R('virgo_search_produkt_is_null');
			
			$criteriaFieldTowar["is_null"] = 0;
			if ($isNullTowar == "not_null") {
				$criteriaFieldTowar["is_null"] = 1;
			} elseif ($isNullTowar == "null") {
				$criteriaFieldTowar["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_produkt');

//			if ($isSet) {
			$criteriaFieldTowar["value"] = $dataTypeCriteria;
//			}
			$criteriaTowar["produkt"] = $criteriaFieldTowar;
			$criteriaParent = array();	
			$isNull = R('virgo_search_grupaTowaru_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_grupaTowaru', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
			}
			$criteriaTowar["grupa_towaru"] = $criteriaParent;
			$criteriaParent = array();	
			$isNull = R('virgo_search_jednostka_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_jednostka', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
			}
			$criteriaTowar["jednostka"] = $criteriaParent;
			self::setCriteria($criteriaTowar);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_kod');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterKod', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterKod', null);
			}
			$tableFilter = R('virgo_filter_nazwa');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterNazwa', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterNazwa', null);
			}
			$tableFilter = R('virgo_filter_stan_aktualny');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterStanAktualny', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterStanAktualny', null);
			}
			$tableFilter = R('virgo_filter_stan_minimalny');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterStanMinimalny', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterStanMinimalny', null);
			}
			$tableFilter = R('virgo_filter_produkt');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterProdukt', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterProdukt', null);
			}
			$parentFilter = R('virgo_filter_grupa_towaru');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterGrupaTowaru', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterGrupaTowaru', null);
			}
			$parentFilter = R('virgo_filter_title_grupa_towaru');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleGrupaTowaru', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleGrupaTowaru', null);
			}
			$parentFilter = R('virgo_filter_jednostka');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterJednostka', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterJednostka', null);
			}
			$parentFilter = R('virgo_filter_title_jednostka');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleJednostka', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleJednostka', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseTowar = ' 1 = 1 ';
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
				$eventColumn = "twr_" . P('event_column');
				$whereClauseTowar = $whereClauseTowar . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseTowar = $whereClauseTowar . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_grupa_towaru');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_towary.twr_gtw_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_towary.twr_gtw_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseTowar = $whereClauseTowar . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_jednostka');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_towary.twr_jdn_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_towary.twr_jdn_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseTowar = $whereClauseTowar . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaTowar = self::getCriteria();
			if (isset($criteriaTowar["kod"])) {
				$fieldCriteriaKod = $criteriaTowar["kod"];
				if ($fieldCriteriaKod["is_null"] == 1) {
$filter = $filter . ' AND slk_towary.twr_kod IS NOT NULL ';
				} elseif ($fieldCriteriaKod["is_null"] == 2) {
$filter = $filter . ' AND slk_towary.twr_kod IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaKod["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_towary.twr_kod like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaTowar["nazwa"])) {
				$fieldCriteriaNazwa = $criteriaTowar["nazwa"];
				if ($fieldCriteriaNazwa["is_null"] == 1) {
$filter = $filter . ' AND slk_towary.twr_nazwa IS NOT NULL ';
				} elseif ($fieldCriteriaNazwa["is_null"] == 2) {
$filter = $filter . ' AND slk_towary.twr_nazwa IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaNazwa["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_towary.twr_nazwa like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaTowar["stan_aktualny"])) {
				$fieldCriteriaStanAktualny = $criteriaTowar["stan_aktualny"];
				if ($fieldCriteriaStanAktualny["is_null"] == 1) {
$filter = $filter . ' AND slk_towary.twr_stan_aktualny IS NOT NULL ';
				} elseif ($fieldCriteriaStanAktualny["is_null"] == 2) {
$filter = $filter . ' AND slk_towary.twr_stan_aktualny IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaStanAktualny["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_towary.twr_stan_aktualny >= ? ";
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_towary.twr_stan_aktualny <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaTowar["stan_minimalny"])) {
				$fieldCriteriaStanMinimalny = $criteriaTowar["stan_minimalny"];
				if ($fieldCriteriaStanMinimalny["is_null"] == 1) {
$filter = $filter . ' AND slk_towary.twr_stan_minimalny IS NOT NULL ';
				} elseif ($fieldCriteriaStanMinimalny["is_null"] == 2) {
$filter = $filter . ' AND slk_towary.twr_stan_minimalny IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaStanMinimalny["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_towary.twr_stan_minimalny >= ? ";
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_towary.twr_stan_minimalny <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaTowar["produkt"])) {
				$fieldCriteriaProdukt = $criteriaTowar["produkt"];
				if ($fieldCriteriaProdukt["is_null"] == 1) {
$filter = $filter . ' AND slk_towary.twr_produkt IS NOT NULL ';
				} elseif ($fieldCriteriaProdukt["is_null"] == 2) {
$filter = $filter . ' AND slk_towary.twr_produkt IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaProdukt["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND slk_towary.twr_produkt = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaTowar["grupa_towaru"])) {
				$parentCriteria = $criteriaTowar["grupa_towaru"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND twr_gtw_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND slk_towary.twr_gtw_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			if (isset($criteriaTowar["jednostka"])) {
				$parentCriteria = $criteriaTowar["jednostka"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND twr_jdn_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND slk_towary.twr_jdn_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			$whereClauseTowar = $whereClauseTowar . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseTowar = $whereClauseTowar . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseTowar = $whereClauseTowar . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterKod', null);
				if (S($tableFilter)) {
					$whereClauseTowar = $whereClauseTowar . " AND twr_kod LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterNazwa', null);
				if (S($tableFilter)) {
					$whereClauseTowar = $whereClauseTowar . " AND twr_nazwa LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterStanAktualny', null);
				if (S($tableFilter)) {
					$whereClauseTowar = $whereClauseTowar . " AND twr_stan_aktualny LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterStanMinimalny', null);
				if (S($tableFilter)) {
					$whereClauseTowar = $whereClauseTowar . " AND twr_stan_minimalny LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterProdukt', null);
				if (S($tableFilter)) {
					$whereClauseTowar = $whereClauseTowar . " AND twr_produkt LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterGrupaTowaru', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseTowar = $whereClauseTowar . " AND twr_gtw_id IS NULL ";
					} else {
						$whereClauseTowar = $whereClauseTowar . " AND twr_gtw_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleGrupaTowaru', null);
				if (S($parentFilter)) {
					$whereClauseTowar = $whereClauseTowar . " AND slk_grupy_towarow_parent.gtw_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterJednostka', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseTowar = $whereClauseTowar . " AND twr_jdn_id IS NULL ";
					} else {
						$whereClauseTowar = $whereClauseTowar . " AND twr_jdn_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleJednostka', null);
				if (S($parentFilter)) {
					$whereClauseTowar = $whereClauseTowar . " AND slk_jednostki_parent.jdn_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClauseTowar;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseTowar = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT slk_towary.twr_id, slk_towary.twr_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_kod', "1") != "0") {
				$queryString = $queryString . ", slk_towary.twr_kod twr_kod";
			} else {
				if ($defaultOrderColumn == "twr_kod") {
					$orderColumnNotDisplayed = " slk_towary.twr_kod ";
				}
			}
			if (P('show_table_nazwa', "1") != "0") {
				$queryString = $queryString . ", slk_towary.twr_nazwa twr_nazwa";
			} else {
				if ($defaultOrderColumn == "twr_nazwa") {
					$orderColumnNotDisplayed = " slk_towary.twr_nazwa ";
				}
			}
			if (P('show_table_stan_aktualny', "0") != "0") {
				$queryString = $queryString . ", slk_towary.twr_stan_aktualny twr_stan_aktualny";
			} else {
				if ($defaultOrderColumn == "twr_stan_aktualny") {
					$orderColumnNotDisplayed = " slk_towary.twr_stan_aktualny ";
				}
			}
			if (P('show_table_stan_minimalny', "1") != "0") {
				$queryString = $queryString . ", slk_towary.twr_stan_minimalny twr_stan_minimalny";
			} else {
				if ($defaultOrderColumn == "twr_stan_minimalny") {
					$orderColumnNotDisplayed = " slk_towary.twr_stan_minimalny ";
				}
			}
			if (P('show_table_produkt', "0") != "0") {
				$queryString = $queryString . ", slk_towary.twr_produkt twr_produkt";
			} else {
				if ($defaultOrderColumn == "twr_produkt") {
					$orderColumnNotDisplayed = " slk_towary.twr_produkt ";
				}
			}
			if (class_exists('sealock\virgoGrupaTowaru') && P('show_table_grupa_towaru', "1") != "0") { // */ && !in_array("gtw", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_towary.twr_gtw_id as twr_gtw_id ";
				$queryString = $queryString . ", slk_grupy_towarow_parent.gtw_virgo_title as `grupa_towaru` ";
			} else {
				if ($defaultOrderColumn == "grupa_towaru") {
					$orderColumnNotDisplayed = " slk_grupy_towarow_parent.gtw_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoJednostka') && P('show_table_jednostka', "1") != "0") { // */ && !in_array("jdn", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_towary.twr_jdn_id as twr_jdn_id ";
				$queryString = $queryString . ", slk_jednostki_parent.jdn_virgo_title as `jednostka` ";
			} else {
				if ($defaultOrderColumn == "jednostka") {
					$orderColumnNotDisplayed = " slk_jednostki_parent.jdn_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_towary ";
			if (class_exists('sealock\virgoGrupaTowaru')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_grupy_towarow AS slk_grupy_towarow_parent ON (slk_towary.twr_gtw_id = slk_grupy_towarow_parent.gtw_id) ";
			}
			if (class_exists('sealock\virgoJednostka')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_jednostki AS slk_jednostki_parent ON (slk_towary.twr_jdn_id = slk_jednostki_parent.jdn_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseTowar = $whereClauseTowar . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseTowar, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseTowar,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM slk_towary"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " twr_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " twr_usr_created_id = ? ";
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
				. "\n FROM slk_towary"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as slk_towary ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as slk_towary ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, twr_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " twr_usr_created_id = ? ";
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
				$query = "SELECT COUNT(twr_id) cnt FROM towary";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as towary ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as towary ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoTowar();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM slk_towary WHERE twr_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->twr_id = $row['twr_id'];
$this->twr_kod = $row['twr_kod'];
$this->twr_nazwa = $row['twr_nazwa'];
$this->twr_stan_aktualny = $row['twr_stan_aktualny'];
$this->twr_stan_minimalny = $row['twr_stan_minimalny'];
$this->twr_produkt = $row['twr_produkt'];
						$this->twr_gtw_id = $row['twr_gtw_id'];
						$this->twr_jdn_id = $row['twr_jdn_id'];
						if ($fetchUsernames) {
							if ($row['twr_date_created']) {
								if ($row['twr_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['twr_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['twr_date_modified']) {
								if ($row['twr_usr_modified_id'] == $row['twr_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['twr_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['twr_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->twr_date_created = $row['twr_date_created'];
						$this->twr_usr_created_id = $fetchUsernames ? $createdBy : $row['twr_usr_created_id'];
						$this->twr_date_modified = $row['twr_date_modified'];
						$this->twr_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['twr_usr_modified_id'];
						$this->twr_virgo_title = $row['twr_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE slk_towary SET twr_usr_created_id = {$userId} WHERE twr_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->twr_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoTowar::selectAllAsObjectsStatic('twr_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->twr_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->twr_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('twr_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_twr = new virgoTowar();
				$tmp_twr->load((int)$lookup_id);
				return $tmp_twr->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoTowar');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" twr_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoTowar', "10");
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
				$query = $query . " twr_id as id, twr_virgo_title as title ";
			}
			$query = $query . " FROM slk_towary ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoTowar', 'sealock') == "1") {
				$privateCondition = " twr_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY twr_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resTowar = array();
				foreach ($rows as $row) {
					$resTowar[$row['id']] = $row['title'];
				}
				return $resTowar;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticTowar = new virgoTowar();
			return $staticTowar->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getGrupaTowaruStatic($parentId) {
			return virgoGrupaTowaru::getById($parentId);
		}
		
		function getGrupaTowaru() {
			return virgoTowar::getGrupaTowaruStatic($this->twr_gtw_id);
		}
		static function getJednostkaStatic($parentId) {
			return virgoJednostka::getById($parentId);
		}
		
		function getJednostka() {
			return virgoTowar::getJednostkaStatic($this->twr_jdn_id);
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
			$resultsPozycjaZamowienia = virgoPozycjaZamowienia::selectAll('pzm_twr_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPozycjaZamowienia as $resultPozycjaZamowienia) {
				$tmpPozycjaZamowienia = virgoPozycjaZamowienia::getById($resultPozycjaZamowienia['pzm_id']); 
				array_push($resPozycjaZamowienia, $tmpPozycjaZamowienia);
			}
			return $resPozycjaZamowienia;
		}

		function getPozycjeZamowien($orderBy = '', $extraWhere = null) {
			return virgoTowar::getPozycjeZamowienStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getProduktyStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resProdukt = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoProdukt'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resProdukt;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resProdukt;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsProdukt = virgoProdukt::selectAll('prd_twr_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsProdukt as $resultProdukt) {
				$tmpProdukt = virgoProdukt::getById($resultProdukt['prd_id']); 
				array_push($resProdukt, $tmpProdukt);
			}
			return $resProdukt;
		}

		function getProdukty($orderBy = '', $extraWhere = null) {
			return virgoTowar::getProduktyStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getSkladnikiTworzyStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resSkladnik = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoSkladnik'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resSkladnik;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resSkladnik;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsSkladnikTworzy = virgoSkladnik::selectAll('skl_twr_tworzy_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsSkladnikTworzy as $resultSkladnikTworzy) {
				$tmpSkladnikTworzy = virgoSkladnik::getById($resultSkladnikTworzy['skl_id']); 
				array_push($resSkladnik, $tmpSkladnikTworzy);
			}
			return $resSkladnik;
		}

		function getSkladnikiTworzy($orderBy = '', $extraWhere = null) {
			return virgoTowar::getSkladnikiTworzyStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getSkladnikiStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resSkladnik = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoSkladnik'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resSkladnik;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resSkladnik;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsSkladnik = virgoSkladnik::selectAll('skl_twr_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsSkladnik as $resultSkladnik) {
				$tmpSkladnik = virgoSkladnik::getById($resultSkladnik['skl_id']); 
				array_push($resSkladnik, $tmpSkladnik);
			}
			return $resSkladnik;
		}

		function getSkladniki($orderBy = '', $extraWhere = null) {
			return virgoTowar::getSkladnikiStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getPozycjaBilansusStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resPozycjaBilansu = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoPozycjaBilansu'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resPozycjaBilansu;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resPozycjaBilansu;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsPozycjaBilansu = virgoPozycjaBilansu::selectAll('pbl_twr_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPozycjaBilansu as $resultPozycjaBilansu) {
				$tmpPozycjaBilansu = virgoPozycjaBilansu::getById($resultPozycjaBilansu['pbl_id']); 
				array_push($resPozycjaBilansu, $tmpPozycjaBilansu);
			}
			return $resPozycjaBilansu;
		}

		function getPozycjaBilansus($orderBy = '', $extraWhere = null) {
			return virgoTowar::getPozycjaBilansusStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
			if (
(is_null($this->getKod()) || trim($this->getKod()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'KOD');
			}			
			if (
(is_null($this->getNazwa()) || trim($this->getNazwa()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'NAZWA');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_stan_aktualny_obligatory', "0") == "1") {
				if (
(is_null($this->getStanAktualny()) || trim($this->getStanAktualny()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'STAN_AKTUALNY');
				}			
			}
			if (
(is_null($this->getStanMinimalny()) || trim($this->getStanMinimalny()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'STAN_MINIMALNY');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_produkt_obligatory', "0") == "1") {
				if (
(is_null($this->getProdukt()) || trim($this->getProdukt()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'PRODUKT');
				}			
			}
				if (is_null($this->twr_gtw_id) || trim($this->twr_gtw_id) == "") {
					if (R('create_twr_grupaTowaru_' . $this->twr_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'GRUPA_TOWARU', '');
					}
			}			
				if (is_null($this->twr_jdn_id) || trim($this->twr_jdn_id) == "") {
					if (R('create_twr_jednostka_' . $this->twr_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'JEDNOSTKA', '');
					}
			}			
 			if (!is_null($this->twr_stan_aktualny) && trim($this->twr_stan_aktualny) != "") {
				if (!is_numeric($this->twr_stan_aktualny)) {
					return T('INCORRECT_NUMBER', 'STAN_AKTUALNY', $this->twr_stan_aktualny);
				}
			}
			if (!is_null($this->twr_stan_minimalny) && trim($this->twr_stan_minimalny) != "") {
				if (!is_numeric($this->twr_stan_minimalny)) {
					return T('INCORRECT_NUMBER', 'STAN_MINIMALNY', $this->twr_stan_minimalny);
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  slk_history_towary WHERE twr_id = " . $this->getId();
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
				$colNames = $colNames . ", twr_kod";
				$values = $values . ", " . (is_null($objectToStore->getKod()) ? "null" : "'" . QE($objectToStore->getKod()) . "'");
				$colNames = $colNames . ", twr_nazwa";
				$values = $values . ", " . (is_null($objectToStore->getNazwa()) ? "null" : "'" . QE($objectToStore->getNazwa()) . "'");
				$colNames = $colNames . ", twr_stan_aktualny";
				$values = $values . ", " . (is_null($objectToStore->getStanAktualny()) ? "null" : "'" . QE($objectToStore->getStanAktualny()) . "'");
				$colNames = $colNames . ", twr_stan_minimalny";
				$values = $values . ", " . (is_null($objectToStore->getStanMinimalny()) ? "null" : "'" . QE($objectToStore->getStanMinimalny()) . "'");
				$colNames = $colNames . ", twr_produkt";
				$values = $values . ", " . (is_null($objectToStore->getProdukt()) ? "null" : "'" . QE($objectToStore->getProdukt()) . "'");
				$colNames = $colNames . ", twr_gtw_id";
				$values = $values . ", " . (is_null($objectToStore->getGtwId()) || $objectToStore->getGtwId() == "" ? "null" : $objectToStore->getGtwId());
				$colNames = $colNames . ", twr_jdn_id";
				$values = $values . ", " . (is_null($objectToStore->getJdnId()) || $objectToStore->getJdnId() == "" ? "null" : $objectToStore->getJdnId());
				$query = "INSERT INTO slk_history_towary (revision, ip, username, user_id, timestamp, twr_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getKod() != $objectToStore->getKod()) {
				if (is_null($objectToStore->getKod())) {
					$nullifiedProperties = $nullifiedProperties . "kod,";
				} else {
				$colNames = $colNames . ", twr_kod";
				$values = $values . ", " . (is_null($objectToStore->getKod()) ? "null" : "'" . QE($objectToStore->getKod()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getNazwa() != $objectToStore->getNazwa()) {
				if (is_null($objectToStore->getNazwa())) {
					$nullifiedProperties = $nullifiedProperties . "nazwa,";
				} else {
				$colNames = $colNames . ", twr_nazwa";
				$values = $values . ", " . (is_null($objectToStore->getNazwa()) ? "null" : "'" . QE($objectToStore->getNazwa()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getStanAktualny() != $objectToStore->getStanAktualny()) {
				if (is_null($objectToStore->getStanAktualny())) {
					$nullifiedProperties = $nullifiedProperties . "stan_aktualny,";
				} else {
				$colNames = $colNames . ", twr_stan_aktualny";
				$values = $values . ", " . (is_null($objectToStore->getStanAktualny()) ? "null" : "'" . QE($objectToStore->getStanAktualny()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getStanMinimalny() != $objectToStore->getStanMinimalny()) {
				if (is_null($objectToStore->getStanMinimalny())) {
					$nullifiedProperties = $nullifiedProperties . "stan_minimalny,";
				} else {
				$colNames = $colNames . ", twr_stan_minimalny";
				$values = $values . ", " . (is_null($objectToStore->getStanMinimalny()) ? "null" : "'" . QE($objectToStore->getStanMinimalny()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getProdukt() != $objectToStore->getProdukt()) {
				if (is_null($objectToStore->getProdukt())) {
					$nullifiedProperties = $nullifiedProperties . "produkt,";
				} else {
				$colNames = $colNames . ", twr_produkt";
				$values = $values . ", " . (is_null($objectToStore->getProdukt()) ? "null" : "'" . QE($objectToStore->getProdukt()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getGtwId() != $objectToStore->getGtwId() && ($virgoOld->getGtwId() != 0 || $objectToStore->getGtwId() != ""))) { 
				$colNames = $colNames . ", twr_gtw_id";
				$values = $values . ", " . (is_null($objectToStore->getGtwId()) ? "null" : ($objectToStore->getGtwId() == "" ? "0" : $objectToStore->getGtwId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getJdnId() != $objectToStore->getJdnId() && ($virgoOld->getJdnId() != 0 || $objectToStore->getJdnId() != ""))) { 
				$colNames = $colNames . ", twr_jdn_id";
				$values = $values . ", " . (is_null($objectToStore->getJdnId()) ? "null" : ($objectToStore->getJdnId() == "" ? "0" : $objectToStore->getJdnId()));
			}
			$query = "INSERT INTO slk_history_towary (revision, ip, username, user_id, timestamp, twr_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM slk_towary");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'twr_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE slk_towary ADD COLUMN (twr_virgo_title VARCHAR(255));";
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
			if (isset($this->twr_id) && $this->twr_id != "") {
				$query = "UPDATE slk_towary SET ";
			if (isset($this->twr_kod)) {
				$query .= " twr_kod = ? ,";
				$types .= "s";
				$values[] = $this->twr_kod;
			} else {
				$query .= " twr_kod = NULL ,";				
			}
			if (isset($this->twr_nazwa)) {
				$query .= " twr_nazwa = ? ,";
				$types .= "s";
				$values[] = $this->twr_nazwa;
			} else {
				$query .= " twr_nazwa = NULL ,";				
			}
			if (isset($this->twr_stan_aktualny)) {
				$query .= " twr_stan_aktualny = ? ,";
				$types .= "d";
				$values[] = number_format($this->twr_stan_aktualny, 2, '.', '');
			} else {
				$query .= " twr_stan_aktualny = NULL ,";				
			}
			if (isset($this->twr_stan_minimalny)) {
				$query .= " twr_stan_minimalny = ? ,";
				$types .= "d";
				$values[] = number_format($this->twr_stan_minimalny, 2, '.', '');
			} else {
				$query .= " twr_stan_minimalny = NULL ,";				
			}
			if (isset($this->twr_produkt)) {
				$query .= " twr_produkt = ? ,";
				$types .= "s";
				$values[] = $this->twr_produkt;
			} else {
				$query .= " twr_produkt = NULL ,";				
			}
				if (isset($this->twr_gtw_id) && trim($this->twr_gtw_id) != "") {
					$query = $query . " twr_gtw_id = ? , ";
					$types = $types . "i";
					$values[] = $this->twr_gtw_id;
				} else {
					$query = $query . " twr_gtw_id = NULL, ";
				}
				if (isset($this->twr_jdn_id) && trim($this->twr_jdn_id) != "") {
					$query = $query . " twr_jdn_id = ? , ";
					$types = $types . "i";
					$values[] = $this->twr_jdn_id;
				} else {
					$query = $query . " twr_jdn_id = NULL, ";
				}
				$query = $query . " twr_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " twr_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->twr_date_modified;

				$query = $query . " twr_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->twr_usr_modified_id;

				$query = $query . " WHERE twr_id = ? ";
				$types = $types . "i";
				$values[] = $this->twr_id;
			} else {
				$query = "INSERT INTO slk_towary ( ";
			$query = $query . " twr_kod, ";
			$query = $query . " twr_nazwa, ";
			$query = $query . " twr_stan_aktualny, ";
			$query = $query . " twr_stan_minimalny, ";
			$query = $query . " twr_produkt, ";
				$query = $query . " twr_gtw_id, ";
				$query = $query . " twr_jdn_id, ";
				$query = $query . " twr_virgo_title, twr_date_created, twr_usr_created_id) VALUES ( ";
			if (isset($this->twr_kod)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->twr_kod;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->twr_nazwa)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->twr_nazwa;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->twr_stan_aktualny)) {
				$query .= " ? ,";
				$types .= "d";
				$values[] = $this->twr_stan_aktualny;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->twr_stan_minimalny)) {
				$query .= " ? ,";
				$types .= "d";
				$values[] = $this->twr_stan_minimalny;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->twr_produkt)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->twr_produkt;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->twr_gtw_id) && trim($this->twr_gtw_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->twr_gtw_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->twr_jdn_id) && trim($this->twr_jdn_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->twr_jdn_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->twr_date_created;
				$values[] = $this->twr_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->twr_id) || $this->twr_id == "") {
					$this->twr_id = QID();
				}
				if ($log) {
					L("towar stored successfully", "id = {$this->twr_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->twr_id) {
				$virgoOld = new virgoTowar($this->twr_id);
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
					if ($this->twr_id) {			
						$this->twr_date_modified = date("Y-m-d H:i:s");
						$this->twr_usr_modified_id = $userId;
					} else {
						$this->twr_date_created = date("Y-m-d H:i:s");
						$this->twr_usr_created_id = $userId;
					}
					$this->twr_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "towar" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "towar" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM slk_towary WHERE twr_id = {$this->twr_id}";
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
				return T('CANT_DELETE_PARENT', 'TOWAR', 'POZYCJA_ZAMOWIENIA', $name);
			}
			$list = $this->getProdukty();
			if (sizeof($list) > 0) {
				$name = $this->getVirgoTitle();
				if (!is_null($name) && trim($name) != "") {
					$name = "'" . $name . "' ";
				}
				return T('CANT_DELETE_PARENT', 'TOWAR', 'PRODUKT', $name);
			}
			$list = $this->getSkladnikiTworzy();
			if (sizeof($list) > 0) {
				foreach ($list as $childRecord) {
					$childRecord->delete();
				}
			}
			$list = $this->getSkladniki();
			if (sizeof($list) > 0) {
				$name = $this->getVirgoTitle();
				if (!is_null($name) && trim($name) != "") {
					$name = "'" . $name . "' ";
				}
				return T('CANT_DELETE_PARENT', 'TOWAR', 'SKLADNIK', $name);
			}
			$list = $this->getPozycjaBilansus();
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
			$tmp = new virgoTowar();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT twr_id as id FROM slk_towary";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'twr_order_column')) {
				$orderBy = " ORDER BY twr_order_column ASC ";
			} 
			if (property_exists($this, 'twr_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY twr_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoTowar();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoTowar($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE slk_towary SET twr_virgo_title = '$title' WHERE twr_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getByKodStatic($token) {
			$tmpStatic = new virgoTowar();
			$tmpId = $tmpStatic->getIdByKod($token);
			$tmpStatic->load($tmpId);
			return $tmpStatic;
		}
		
		static function getIdByKodStatic($token) {
			$tmpStatic = new virgoTowar();
			return $tmpStatic->getIdByKod($token);
		}
		
		function getIdByKod($token) {
			$res = $this->selectAll(" twr_kod = ?", "", "s", array($token));
			foreach ($res as $r) {
				return $r['twr_id'];
			}
			return null;
		}
		static function getByNazwaStatic($token) {
			$tmpStatic = new virgoTowar();
			$tmpId = $tmpStatic->getIdByNazwa($token);
			$tmpStatic->load($tmpId);
			return $tmpStatic;
		}
		
		static function getIdByNazwaStatic($token) {
			$tmpStatic = new virgoTowar();
			return $tmpStatic->getIdByNazwa($token);
		}
		
		function getIdByNazwa($token) {
			$res = $this->selectAll(" twr_nazwa = ?", "", "s", array($token));
			foreach ($res as $r) {
				return $r['twr_id'];
			}
			return null;
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoTowar();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" twr_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['twr_id'];
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
			virgoTowar::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoTowar::setSessionValue('Sealock_Towar-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoTowar::getSessionValue('Sealock_Towar-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoTowar::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoTowar::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoTowar::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoTowar::getSessionValue('GLOBAL', $name, $default);
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
			$context['twr_id'] = $id;
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
			$context['twr_id'] = null;
			virgoTowar::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoTowar::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoTowar::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoTowar::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoTowar::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoTowar::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoTowar::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoTowar::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoTowar::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoTowar::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoTowar::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoTowar::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoTowar::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoTowar::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoTowar::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoTowar::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoTowar::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "twr_id";
			}
			return virgoTowar::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoTowar::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoTowar::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoTowar::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoTowar::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoTowar::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoTowar::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoTowar::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoTowar::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoTowar::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoTowar::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoTowar::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoTowar::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->twr_id) {
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
						L(T('STORED_CORRECTLY', 'TOWAR'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'kod', $this->twr_kod);
						$fieldValues = $fieldValues . T($fieldValue, 'nazwa', $this->twr_nazwa);
						$fieldValues = $fieldValues . T($fieldValue, 'stan aktualny', $this->twr_stan_aktualny);
						$fieldValues = $fieldValues . T($fieldValue, 'stan minimalny', $this->twr_stan_minimalny);
						$fieldValues = $fieldValues . T($fieldValue, 'produkt', $this->twr_produkt);
						$parentGrupaTowaru = new virgoGrupaTowaru();
						$fieldValues = $fieldValues . T($fieldValue, 'grupa towaru', $parentGrupaTowaru->lookup($this->twr_gtw_id));
						$parentJednostka = new virgoJednostka();
						$fieldValues = $fieldValues . T($fieldValue, 'jednostka', $parentJednostka->lookup($this->twr_jdn_id));
						$username = '';
						if ($this->twr_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->twr_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->twr_date_created);
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
			$instance = new virgoTowar();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoTowar'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
				$resIds = $tmpPozycjaZamowienia->select(null, 'all', null, null, ' pzm_twr_id = ' . $instance->getId(), ' SELECT pzm_id FROM slk_pozycje_zamowien ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->pzm_id;
//					JRequest::setVar('pzm_towar_' . $resId->pzm_id, $this->getId());
				} 
//				JRequest::setVar('pzm_towar_', $instance->getId());
				$tmpPozycjaZamowienia->setRecordSet($resIdsString);
				if (!$tmpPozycjaZamowienia->portletActionStoreSelected()) {
					$ret = -1;
					self::setDisplayMode($originalDisplayMode); 
				}
			}
			if (false) { //$componentParams->get('show_form_produkty') == "1") {
				$tmpProdukt = new virgoProdukt();
				$deleteProdukt = R('DELETE');
				if (sizeof($deleteProdukt) > 0) {
					virgoProdukt::multipleDelete($deleteProdukt);
				}
				$resIds = $tmpProdukt->select(null, 'all', null, null, ' prd_twr_id = ' . $instance->getId(), ' SELECT prd_id FROM slk_produkty ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->prd_id;
//					JRequest::setVar('prd_towar_' . $resId->prd_id, $this->getId());
				} 
//				JRequest::setVar('prd_towar_', $instance->getId());
				$tmpProdukt->setRecordSet($resIdsString);
				if (!$tmpProdukt->portletActionStoreSelected()) {
					$ret = -1;
					self::setDisplayMode($originalDisplayMode); 
				}
			}
			if (false) { //$componentParams->get('show_form_skladnikitworzy') == "1") {
				$tmpSkladnik = new virgoSkladnik();
				$deleteSkladnik = R('DELETE');
				if (sizeof($deleteSkladnik) > 0) {
					virgoSkladnik::multipleDelete($deleteSkladnik);
				}
				$resIds = $tmpSkladnik->select(null, 'all', null, null, ' skl_twr_tworzy_id = ' . $instance->getId(), ' SELECT skl_id FROM slk_skladniki ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->skl_id;
//					JRequest::setVar('skl_towar_' . $resId->skl_id, $this->getId());
				} 
//				JRequest::setVar('skl_towar_', $instance->getId());
				$tmpSkladnik->setRecordSet($resIdsString);
				if (!$tmpSkladnik->portletActionStoreSelected()) {
					$ret = -1;
					self::setDisplayMode($originalDisplayMode); 
				}
			}
			if (false) { //$componentParams->get('show_form_skladniki') == "1") {
				$tmpSkladnik = new virgoSkladnik();
				$deleteSkladnik = R('DELETE');
				if (sizeof($deleteSkladnik) > 0) {
					virgoSkladnik::multipleDelete($deleteSkladnik);
				}
				$resIds = $tmpSkladnik->select(null, 'all', null, null, ' skl_twr_id = ' . $instance->getId(), ' SELECT skl_id FROM slk_skladniki ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->skl_id;
//					JRequest::setVar('skl_towar_' . $resId->skl_id, $this->getId());
				} 
//				JRequest::setVar('skl_towar_', $instance->getId());
				$tmpSkladnik->setRecordSet($resIdsString);
				if (!$tmpSkladnik->portletActionStoreSelected()) {
					$ret = -1;
					self::setDisplayMode($originalDisplayMode); 
				}
			}
			if (false) { //$componentParams->get('show_form_pozycja_bilansus') == "1") {
				$tmpPozycjaBilansu = new virgoPozycjaBilansu();
				$deletePozycjaBilansu = R('DELETE');
				if (sizeof($deletePozycjaBilansu) > 0) {
					virgoPozycjaBilansu::multipleDelete($deletePozycjaBilansu);
				}
				$resIds = $tmpPozycjaBilansu->select(null, 'all', null, null, ' pbl_twr_id = ' . $instance->getId(), ' SELECT pbl_id FROM slk_pozycja_bilansus ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->pbl_id;
//					JRequest::setVar('pbl_towar_' . $resId->pbl_id, $this->getId());
				} 
//				JRequest::setVar('pbl_towar_', $instance->getId());
				$tmpPozycjaBilansu->setRecordSet($resIdsString);
				if (!$tmpPozycjaBilansu->portletActionStoreSelected()) {
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
			$instance = new virgoTowar();
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
			$tmpId = intval(R('twr_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoTowar::getContextId();
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
			$this->twr_id = null;
			$this->twr_date_created = null;
			$this->twr_usr_created_id = null;
			$this->twr_date_modified = null;
			$this->twr_usr_modified_id = null;
			$this->twr_virgo_title = null;
			
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

		static function portletActionShowForGrupaTowaru() {
			$parentId = R('gtw_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoGrupaTowaru($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
			return 0;
		}
		static function portletActionShowForJednostka() {
			$parentId = R('jdn_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoJednostka($parentId);
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
//			$ret = new virgoTowar();
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
				$instance = new virgoTowar();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoTowar::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'TOWAR'), '', 'INFO');
					return 0;
					
				} else {
					L($res, '', 'ERROR');
					return -1;
				}
			}
		}
		
		
		static function portletActionVirgoSetProduktTrue() {
			$instance = new virgoTowar();
			$instance->loadFromDB();
			$instance->setProdukt(1);
			$ret = $instance->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetProduktFalse() {
			$instance = new virgoTowar();
			$instance->loadFromDB();
			$instance->setProdukt(0);
			$ret = $instance->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isProdukt() {
			return $this->getProdukt() == 1;
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
				$resultTowar = new virgoTowar();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultTowar->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultTowar->load($idToEditInt);
					} else {
						$resultTowar->twr_id = 0;
					}
				}
				$results[] = $resultTowar;
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
				$result = new virgoTowar();
				$result->loadFromRequest($idToStore);
				if ($result->twr_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->twr_id == 0) {
						$result->twr_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->twr_id)) {
							$result->twr_id = 0;
						}
						$idsToCorrect[$result->twr_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'TOWARY'), '', 'INFO');
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
			$resultTowar = new virgoTowar();
			foreach ($idsToDelete as $idToDelete) {
				$resultTowar->load((int)trim($idToDelete));
				$res = $resultTowar->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'TOWARY'), '', 'INFO');			
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
		$ret = $this->twr_nazwa;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoTowar');
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
				$query = "UPDATE slk_towary SET twr_virgo_title = ? WHERE twr_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT twr_id AS id FROM slk_towary ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoTowar($row['id']);
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
				$class2prefix["sealock\\virgoGrupaTowaru"] = "gtw";
				$class2prefix2 = array();
				$class2parentPrefix["sealock\\virgoGrupaTowaru"] = $class2prefix2;
				$class2prefix["sealock\\virgoJednostka"] = "jdn";
				$class2prefix2 = array();
				$class2parentPrefix["sealock\\virgoJednostka"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'slk_towary.twr_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'slk_towary.twr_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'slk_towary.twr_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM slk_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'slk_towary.twr_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoTowar!', '', 'ERROR');
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
			$pdf->SetTitle('Towary report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('TOWARY');
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
			if (P('show_pdf_kod', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_nazwa', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_stan_aktualny', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_stan_minimalny', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_produkt', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_grupa_towaru', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_jednostka', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultTowar = new virgoTowar();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_kod', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Kod');
				$minWidth['kod'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['kod']) {
						$minWidth['kod'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_nazwa', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Nazwa');
				$minWidth['nazwa'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['nazwa']) {
						$minWidth['nazwa'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_stan_aktualny', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Stan aktualny');
				$minWidth['stan aktualny'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['stan aktualny']) {
						$minWidth['stan aktualny'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_stan_minimalny', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Stan minimalny');
				$minWidth['stan minimalny'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['stan minimalny']) {
						$minWidth['stan minimalny'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_produkt', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Produkt');
				$minWidth['produkt'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['produkt']) {
						$minWidth['produkt'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_grupa_towaru', "1") == "1") {
				$minWidth['grupa towaru $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'grupa towaru $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['grupa towaru $relation.name']) {
						$minWidth['grupa towaru $relation.name'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_jednostka', "1") == "1") {
				$minWidth['jednostka $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'jednostka $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['jednostka $relation.name']) {
						$minWidth['jednostka $relation.name'] = min($tmpLen, $maxWidth);
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
			$whereClauseTowar = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseTowar = $whereClauseTowar . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaTowar = $resultTowar->getCriteria();
			$fieldCriteriaKod = $criteriaTowar["kod"];
			if ($fieldCriteriaKod["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Kod', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaKod["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Kod', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaNazwa = $criteriaTowar["nazwa"];
			if ($fieldCriteriaNazwa["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Nazwa', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaNazwa["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Nazwa', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaStanAktualny = $criteriaTowar["stan_aktualny"];
			if ($fieldCriteriaStanAktualny["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Stan aktualny', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaStanAktualny["value"];
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
					$pdf->MultiCell(60, 100, 'Stan aktualny', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaStanMinimalny = $criteriaTowar["stan_minimalny"];
			if ($fieldCriteriaStanMinimalny["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Stan minimalny', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaStanMinimalny["value"];
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
					$pdf->MultiCell(60, 100, 'Stan minimalny', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaProdukt = $criteriaTowar["produkt"];
			if ($fieldCriteriaProdukt["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Produkt', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaProdukt["value"];
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
					$pdf->MultiCell(60, 100, 'Produkt', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaTowar["grupa_towaru"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Grupa towaru', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoGrupaTowaru::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Grupa towaru', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaTowar["jednostka"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Jednostka', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoJednostka::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Jednostka', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_grupa_towaru');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_towary.twr_gtw_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_towary.twr_gtw_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseTowar = $whereClauseTowar . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_jednostka');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_towary.twr_jdn_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_towary.twr_jdn_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseTowar = $whereClauseTowar . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaTowar = self::getCriteria();
			if (isset($criteriaTowar["kod"])) {
				$fieldCriteriaKod = $criteriaTowar["kod"];
				if ($fieldCriteriaKod["is_null"] == 1) {
$filter = $filter . ' AND slk_towary.twr_kod IS NOT NULL ';
				} elseif ($fieldCriteriaKod["is_null"] == 2) {
$filter = $filter . ' AND slk_towary.twr_kod IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaKod["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_towary.twr_kod like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaTowar["nazwa"])) {
				$fieldCriteriaNazwa = $criteriaTowar["nazwa"];
				if ($fieldCriteriaNazwa["is_null"] == 1) {
$filter = $filter . ' AND slk_towary.twr_nazwa IS NOT NULL ';
				} elseif ($fieldCriteriaNazwa["is_null"] == 2) {
$filter = $filter . ' AND slk_towary.twr_nazwa IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaNazwa["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_towary.twr_nazwa like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaTowar["stan_aktualny"])) {
				$fieldCriteriaStanAktualny = $criteriaTowar["stan_aktualny"];
				if ($fieldCriteriaStanAktualny["is_null"] == 1) {
$filter = $filter . ' AND slk_towary.twr_stan_aktualny IS NOT NULL ';
				} elseif ($fieldCriteriaStanAktualny["is_null"] == 2) {
$filter = $filter . ' AND slk_towary.twr_stan_aktualny IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaStanAktualny["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_towary.twr_stan_aktualny >= ? ";
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_towary.twr_stan_aktualny <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaTowar["stan_minimalny"])) {
				$fieldCriteriaStanMinimalny = $criteriaTowar["stan_minimalny"];
				if ($fieldCriteriaStanMinimalny["is_null"] == 1) {
$filter = $filter . ' AND slk_towary.twr_stan_minimalny IS NOT NULL ';
				} elseif ($fieldCriteriaStanMinimalny["is_null"] == 2) {
$filter = $filter . ' AND slk_towary.twr_stan_minimalny IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaStanMinimalny["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_towary.twr_stan_minimalny >= ? ";
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_towary.twr_stan_minimalny <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaTowar["produkt"])) {
				$fieldCriteriaProdukt = $criteriaTowar["produkt"];
				if ($fieldCriteriaProdukt["is_null"] == 1) {
$filter = $filter . ' AND slk_towary.twr_produkt IS NOT NULL ';
				} elseif ($fieldCriteriaProdukt["is_null"] == 2) {
$filter = $filter . ' AND slk_towary.twr_produkt IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaProdukt["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND slk_towary.twr_produkt = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaTowar["grupa_towaru"])) {
				$parentCriteria = $criteriaTowar["grupa_towaru"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND twr_gtw_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND slk_towary.twr_gtw_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			if (isset($criteriaTowar["jednostka"])) {
				$parentCriteria = $criteriaTowar["jednostka"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND twr_jdn_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND slk_towary.twr_jdn_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			$whereClauseTowar = $whereClauseTowar . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseTowar = $whereClauseTowar . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT slk_towary.twr_id, slk_towary.twr_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_kod', "1") != "0") {
				$queryString = $queryString . ", slk_towary.twr_kod twr_kod";
			} else {
				if ($defaultOrderColumn == "twr_kod") {
					$orderColumnNotDisplayed = " slk_towary.twr_kod ";
				}
			}
			if (P('show_pdf_nazwa', "1") != "0") {
				$queryString = $queryString . ", slk_towary.twr_nazwa twr_nazwa";
			} else {
				if ($defaultOrderColumn == "twr_nazwa") {
					$orderColumnNotDisplayed = " slk_towary.twr_nazwa ";
				}
			}
			if (P('show_pdf_stan_aktualny', "0") != "0") {
				$queryString = $queryString . ", slk_towary.twr_stan_aktualny twr_stan_aktualny";
			} else {
				if ($defaultOrderColumn == "twr_stan_aktualny") {
					$orderColumnNotDisplayed = " slk_towary.twr_stan_aktualny ";
				}
			}
			if (P('show_pdf_stan_minimalny', "1") != "0") {
				$queryString = $queryString . ", slk_towary.twr_stan_minimalny twr_stan_minimalny";
			} else {
				if ($defaultOrderColumn == "twr_stan_minimalny") {
					$orderColumnNotDisplayed = " slk_towary.twr_stan_minimalny ";
				}
			}
			if (P('show_pdf_produkt', "0") != "0") {
				$queryString = $queryString . ", slk_towary.twr_produkt twr_produkt";
			} else {
				if ($defaultOrderColumn == "twr_produkt") {
					$orderColumnNotDisplayed = " slk_towary.twr_produkt ";
				}
			}
			if (class_exists('sealock\virgoGrupaTowaru') && P('show_pdf_grupa_towaru', "1") != "0") { // */ && !in_array("gtw", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_towary.twr_gtw_id as twr_gtw_id ";
				$queryString = $queryString . ", slk_grupy_towarow_parent.gtw_virgo_title as `grupa_towaru` ";
			} else {
				if ($defaultOrderColumn == "grupa_towaru") {
					$orderColumnNotDisplayed = " slk_grupy_towarow_parent.gtw_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoJednostka') && P('show_pdf_jednostka', "1") != "0") { // */ && !in_array("jdn", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_towary.twr_jdn_id as twr_jdn_id ";
				$queryString = $queryString . ", slk_jednostki_parent.jdn_virgo_title as `jednostka` ";
			} else {
				if ($defaultOrderColumn == "jednostka") {
					$orderColumnNotDisplayed = " slk_jednostki_parent.jdn_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_towary ";
			if (class_exists('sealock\virgoGrupaTowaru')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_grupy_towarow AS slk_grupy_towarow_parent ON (slk_towary.twr_gtw_id = slk_grupy_towarow_parent.gtw_id) ";
			}
			if (class_exists('sealock\virgoJednostka')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_jednostki AS slk_jednostki_parent ON (slk_towary.twr_jdn_id = slk_jednostki_parent.jdn_id) ";
			}

		$resultsTowar = $resultTowar->select(
			'', 
			'all', 
			$resultTowar->getOrderColumn(), 
			$resultTowar->getOrderMode(), 
			$whereClauseTowar,
			$queryString);
		
		foreach ($resultsTowar as $resultTowar) {

			if (P('show_pdf_kod', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultTowar['twr_kod'])) + 6;
				if ($tmpLen > $minWidth['kod']) {
					$minWidth['kod'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_nazwa', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultTowar['twr_nazwa'])) + 6;
				if ($tmpLen > $minWidth['nazwa']) {
					$minWidth['nazwa'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_stan_aktualny', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultTowar['twr_stan_aktualny'])) + 6;
				if ($tmpLen > $minWidth['stan aktualny']) {
					$minWidth['stan aktualny'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_stan_minimalny', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultTowar['twr_stan_minimalny'])) + 6;
				if ($tmpLen > $minWidth['stan minimalny']) {
					$minWidth['stan minimalny'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_produkt', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultTowar['twr_produkt'])) + 6;
				if ($tmpLen > $minWidth['produkt']) {
					$minWidth['produkt'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_grupa_towaru', "1") == "1") {
			$parentValue = trim(virgoGrupaTowaru::lookup($resultTowar['twrgtw__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['grupa towaru $relation.name']) {
					$minWidth['grupa towaru $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_jednostka', "1") == "1") {
			$parentValue = trim(virgoJednostka::lookup($resultTowar['twrjdn__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['jednostka $relation.name']) {
					$minWidth['jednostka $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaTowar = $resultTowar->getCriteria();
		if (is_null($criteriaTowar) || sizeof($criteriaTowar) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																																if (P('show_pdf_kod', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['kod'], $colHeight, T('KOD'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_nazwa', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['nazwa'], $colHeight, T('NAZWA'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_stan_aktualny', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['stan aktualny'], $colHeight, T('STAN_AKTUALNY'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_stan_minimalny', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['stan minimalny'], $colHeight, T('STAN_MINIMALNY'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_produkt', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['produkt'], $colHeight, T('PRODUKT'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_grupa_towaru', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['grupa towaru $relation.name'], $colHeight, T('GRUPA_TOWARU') . ' ' . T(''), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_jednostka', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['jednostka $relation.name'], $colHeight, T('JEDNOSTKA') . ' ' . T(''), 'T', 'C', 0, 0); 
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
		foreach ($resultsTowar as $resultTowar) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_kod', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['kod'], $colHeight, '' . $resultTowar['twr_kod'], 'T', 'L', 0, 0);
				if (P('show_pdf_kod', "1") == "2") {
										if (!is_null($resultTowar['twr_kod'])) {
						$tmpCount = (float)$counts["kod"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["kod"] = $tmpCount;
					}
				}
				if (P('show_pdf_kod', "1") == "3") {
										if (!is_null($resultTowar['twr_kod'])) {
						$tmpSum = (float)$sums["kod"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultTowar['twr_kod'];
						}
						$sums["kod"] = $tmpSum;
					}
				}
				if (P('show_pdf_kod', "1") == "4") {
										if (!is_null($resultTowar['twr_kod'])) {
						$tmpCount = (float)$avgCounts["kod"];
						$tmpSum = (float)$avgSums["kod"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["kod"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultTowar['twr_kod'];
						}
						$avgSums["kod"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_nazwa', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['nazwa'], $colHeight, '' . $resultTowar['twr_nazwa'], 'T', 'L', 0, 0);
				if (P('show_pdf_nazwa', "1") == "2") {
										if (!is_null($resultTowar['twr_nazwa'])) {
						$tmpCount = (float)$counts["nazwa"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["nazwa"] = $tmpCount;
					}
				}
				if (P('show_pdf_nazwa', "1") == "3") {
										if (!is_null($resultTowar['twr_nazwa'])) {
						$tmpSum = (float)$sums["nazwa"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultTowar['twr_nazwa'];
						}
						$sums["nazwa"] = $tmpSum;
					}
				}
				if (P('show_pdf_nazwa', "1") == "4") {
										if (!is_null($resultTowar['twr_nazwa'])) {
						$tmpCount = (float)$avgCounts["nazwa"];
						$tmpSum = (float)$avgSums["nazwa"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["nazwa"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultTowar['twr_nazwa'];
						}
						$avgSums["nazwa"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_stan_aktualny', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['stan aktualny'], $colHeight, '' . number_format($resultTowar['twr_stan_aktualny'], 2, ',', ' '), 'T', 'R', 0, 0);
				if (P('show_pdf_stan_aktualny', "1") == "2") {
										if (!is_null($resultTowar['twr_stan_aktualny'])) {
						$tmpCount = (float)$counts["stan_aktualny"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["stan_aktualny"] = $tmpCount;
					}
				}
				if (P('show_pdf_stan_aktualny', "1") == "3") {
										if (!is_null($resultTowar['twr_stan_aktualny'])) {
						$tmpSum = (float)$sums["stan_aktualny"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultTowar['twr_stan_aktualny'];
						}
						$sums["stan_aktualny"] = $tmpSum;
					}
				}
				if (P('show_pdf_stan_aktualny', "1") == "4") {
										if (!is_null($resultTowar['twr_stan_aktualny'])) {
						$tmpCount = (float)$avgCounts["stan_aktualny"];
						$tmpSum = (float)$avgSums["stan_aktualny"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["stan_aktualny"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultTowar['twr_stan_aktualny'];
						}
						$avgSums["stan_aktualny"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_stan_minimalny', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['stan minimalny'], $colHeight, '' . number_format($resultTowar['twr_stan_minimalny'], 2, ',', ' '), 'T', 'R', 0, 0);
				if (P('show_pdf_stan_minimalny', "1") == "2") {
										if (!is_null($resultTowar['twr_stan_minimalny'])) {
						$tmpCount = (float)$counts["stan_minimalny"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["stan_minimalny"] = $tmpCount;
					}
				}
				if (P('show_pdf_stan_minimalny', "1") == "3") {
										if (!is_null($resultTowar['twr_stan_minimalny'])) {
						$tmpSum = (float)$sums["stan_minimalny"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultTowar['twr_stan_minimalny'];
						}
						$sums["stan_minimalny"] = $tmpSum;
					}
				}
				if (P('show_pdf_stan_minimalny', "1") == "4") {
										if (!is_null($resultTowar['twr_stan_minimalny'])) {
						$tmpCount = (float)$avgCounts["stan_minimalny"];
						$tmpSum = (float)$avgSums["stan_minimalny"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["stan_minimalny"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultTowar['twr_stan_minimalny'];
						}
						$avgSums["stan_minimalny"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_produkt', "0") != "0") {
			$renderCriteria = "";
			switch ($resultTowar['twr_produkt']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['produkt'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_produkt', "1") == "2") {
										if (!is_null($resultTowar['twr_produkt'])) {
						$tmpCount = (float)$counts["produkt"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["produkt"] = $tmpCount;
					}
				}
				if (P('show_pdf_produkt', "1") == "3") {
										if (!is_null($resultTowar['twr_produkt'])) {
						$tmpSum = (float)$sums["produkt"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultTowar['twr_produkt'];
						}
						$sums["produkt"] = $tmpSum;
					}
				}
				if (P('show_pdf_produkt', "1") == "4") {
										if (!is_null($resultTowar['twr_produkt'])) {
						$tmpCount = (float)$avgCounts["produkt"];
						$tmpSum = (float)$avgSums["produkt"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["produkt"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultTowar['twr_produkt'];
						}
						$avgSums["produkt"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_grupa_towaru', "1") == "1") {
			$parentValue = virgoGrupaTowaru::lookup($resultTowar['twr_gtw_id']);
			$tmpLn = $pdf->MultiCell($minWidth['grupa towaru $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_jednostka', "1") == "1") {
			$parentValue = virgoJednostka::lookup($resultTowar['twr_jdn_id']);
			$tmpLn = $pdf->MultiCell($minWidth['jednostka $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
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
			if (P('show_pdf_kod', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['kod'];
				if (P('show_pdf_kod', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["kod"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_nazwa', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['nazwa'];
				if (P('show_pdf_nazwa', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["nazwa"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_stan_aktualny', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['stan aktualny'];
				if (P('show_pdf_stan_aktualny', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["stan_aktualny"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_stan_minimalny', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['stan minimalny'];
				if (P('show_pdf_stan_minimalny', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["stan_minimalny"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_produkt', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['produkt'];
				if (P('show_pdf_produkt', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["produkt"];
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
			if (P('show_pdf_kod', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['kod'];
				if (P('show_pdf_kod', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["kod"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_nazwa', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['nazwa'];
				if (P('show_pdf_nazwa', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["nazwa"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_stan_aktualny', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['stan aktualny'];
				if (P('show_pdf_stan_aktualny', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["stan_aktualny"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_stan_minimalny', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['stan minimalny'];
				if (P('show_pdf_stan_minimalny', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["stan_minimalny"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_produkt', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['produkt'];
				if (P('show_pdf_produkt', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["produkt"], 2, ',', ' ');
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
			if (P('show_pdf_kod', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['kod'];
				if (P('show_pdf_kod', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["kod"] == 0 ? "-" : $avgSums["kod"] / $avgCounts["kod"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_nazwa', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['nazwa'];
				if (P('show_pdf_nazwa', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["nazwa"] == 0 ? "-" : $avgSums["nazwa"] / $avgCounts["nazwa"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_stan_aktualny', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['stan aktualny'];
				if (P('show_pdf_stan_aktualny', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["stan_aktualny"] == 0 ? "-" : $avgSums["stan_aktualny"] / $avgCounts["stan_aktualny"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_stan_minimalny', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['stan minimalny'];
				if (P('show_pdf_stan_minimalny', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["stan_minimalny"] == 0 ? "-" : $avgSums["stan_minimalny"] / $avgCounts["stan_minimalny"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_produkt', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['produkt'];
				if (P('show_pdf_produkt', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["produkt"] == 0 ? "-" : $avgSums["produkt"] / $avgCounts["produkt"]);
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
				$reportTitle = T('TOWARY');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultTowar = new virgoTowar();
			$whereClauseTowar = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseTowar = $whereClauseTowar . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_kod', "1") != "0") {
					$data = $data . $stringDelimeter .'Kod' . $stringDelimeter . $separator;
				}
				if (P('show_export_nazwa', "1") != "0") {
					$data = $data . $stringDelimeter .'Nazwa' . $stringDelimeter . $separator;
				}
				if (P('show_export_stan_aktualny', "0") != "0") {
					$data = $data . $stringDelimeter .'Stan aktualny' . $stringDelimeter . $separator;
				}
				if (P('show_export_stan_minimalny', "1") != "0") {
					$data = $data . $stringDelimeter .'Stan minimalny' . $stringDelimeter . $separator;
				}
				if (P('show_export_produkt', "0") != "0") {
					$data = $data . $stringDelimeter .'Produkt' . $stringDelimeter . $separator;
				}
				if (P('show_export_grupa_towaru', "1") != "0") {
					$data = $data . $stringDelimeter . 'Grupa towaru ' . $stringDelimeter . $separator;
				}
				if (P('show_export_jednostka', "1") != "0") {
					$data = $data . $stringDelimeter . 'Jednostka ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_towary.twr_id, slk_towary.twr_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_kod', "1") != "0") {
				$queryString = $queryString . ", slk_towary.twr_kod twr_kod";
			} else {
				if ($defaultOrderColumn == "twr_kod") {
					$orderColumnNotDisplayed = " slk_towary.twr_kod ";
				}
			}
			if (P('show_export_nazwa', "1") != "0") {
				$queryString = $queryString . ", slk_towary.twr_nazwa twr_nazwa";
			} else {
				if ($defaultOrderColumn == "twr_nazwa") {
					$orderColumnNotDisplayed = " slk_towary.twr_nazwa ";
				}
			}
			if (P('show_export_stan_aktualny', "0") != "0") {
				$queryString = $queryString . ", slk_towary.twr_stan_aktualny twr_stan_aktualny";
			} else {
				if ($defaultOrderColumn == "twr_stan_aktualny") {
					$orderColumnNotDisplayed = " slk_towary.twr_stan_aktualny ";
				}
			}
			if (P('show_export_stan_minimalny', "1") != "0") {
				$queryString = $queryString . ", slk_towary.twr_stan_minimalny twr_stan_minimalny";
			} else {
				if ($defaultOrderColumn == "twr_stan_minimalny") {
					$orderColumnNotDisplayed = " slk_towary.twr_stan_minimalny ";
				}
			}
			if (P('show_export_produkt', "0") != "0") {
				$queryString = $queryString . ", slk_towary.twr_produkt twr_produkt";
			} else {
				if ($defaultOrderColumn == "twr_produkt") {
					$orderColumnNotDisplayed = " slk_towary.twr_produkt ";
				}
			}
			if (class_exists('sealock\virgoGrupaTowaru') && P('show_export_grupa_towaru', "1") != "0") { // */ && !in_array("gtw", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_towary.twr_gtw_id as twr_gtw_id ";
				$queryString = $queryString . ", slk_grupy_towarow_parent.gtw_virgo_title as `grupa_towaru` ";
			} else {
				if ($defaultOrderColumn == "grupa_towaru") {
					$orderColumnNotDisplayed = " slk_grupy_towarow_parent.gtw_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoJednostka') && P('show_export_jednostka', "1") != "0") { // */ && !in_array("jdn", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_towary.twr_jdn_id as twr_jdn_id ";
				$queryString = $queryString . ", slk_jednostki_parent.jdn_virgo_title as `jednostka` ";
			} else {
				if ($defaultOrderColumn == "jednostka") {
					$orderColumnNotDisplayed = " slk_jednostki_parent.jdn_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_towary ";
			if (class_exists('sealock\virgoGrupaTowaru')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_grupy_towarow AS slk_grupy_towarow_parent ON (slk_towary.twr_gtw_id = slk_grupy_towarow_parent.gtw_id) ";
			}
			if (class_exists('sealock\virgoJednostka')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_jednostki AS slk_jednostki_parent ON (slk_towary.twr_jdn_id = slk_jednostki_parent.jdn_id) ";
			}

			$resultsTowar = $resultTowar->select(
				'', 
				'all', 
				$resultTowar->getOrderColumn(), 
				$resultTowar->getOrderMode(), 
				$whereClauseTowar,
				$queryString);
			foreach ($resultsTowar as $resultTowar) {
				if (P('show_export_kod', "1") != "0") {
			$data = $data . $stringDelimeter . $resultTowar['twr_kod'] . $stringDelimeter . $separator;
				}
				if (P('show_export_nazwa', "1") != "0") {
			$data = $data . $stringDelimeter . $resultTowar['twr_nazwa'] . $stringDelimeter . $separator;
				}
				if (P('show_export_stan_aktualny', "0") != "0") {
			$data = $data . $resultTowar['twr_stan_aktualny'] . $separator;
				}
				if (P('show_export_stan_minimalny', "1") != "0") {
			$data = $data . $resultTowar['twr_stan_minimalny'] . $separator;
				}
				if (P('show_export_produkt', "0") != "0") {
			$data = $data . $resultTowar['twr_produkt'] . $separator;
				}
				if (P('show_export_grupa_towaru', "1") != "0") {
					$parentValue = virgoGrupaTowaru::lookup($resultTowar['twr_gtw_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_jednostka', "1") != "0") {
					$parentValue = virgoJednostka::lookup($resultTowar['twr_jdn_id']);
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
				$reportTitle = T('TOWARY');
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
			$resultTowar = new virgoTowar();
			$whereClauseTowar = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseTowar = $whereClauseTowar . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_kod', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Kod');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_nazwa', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Nazwa');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_stan_aktualny', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Stan aktualny');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_stan_minimalny', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Stan minimalny');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_produkt', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Produkt');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_grupa_towaru', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Grupa towaru ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoGrupaTowaru::getVirgoList();
					$formulaGrupaTowaru = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaGrupaTowaru != "") {
							$formulaGrupaTowaru = $formulaGrupaTowaru . ',';
						}
						$formulaGrupaTowaru = $formulaGrupaTowaru . $key;
					}
				}
				if (P('show_export_jednostka', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Jednostka ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoJednostka::getVirgoList();
					$formulaJednostka = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaJednostka != "") {
							$formulaJednostka = $formulaJednostka . ',';
						}
						$formulaJednostka = $formulaJednostka . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_towary.twr_id, slk_towary.twr_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_kod', "1") != "0") {
				$queryString = $queryString . ", slk_towary.twr_kod twr_kod";
			} else {
				if ($defaultOrderColumn == "twr_kod") {
					$orderColumnNotDisplayed = " slk_towary.twr_kod ";
				}
			}
			if (P('show_export_nazwa', "1") != "0") {
				$queryString = $queryString . ", slk_towary.twr_nazwa twr_nazwa";
			} else {
				if ($defaultOrderColumn == "twr_nazwa") {
					$orderColumnNotDisplayed = " slk_towary.twr_nazwa ";
				}
			}
			if (P('show_export_stan_aktualny', "1") != "0") {
				$queryString = $queryString . ", slk_towary.twr_stan_aktualny twr_stan_aktualny";
			} else {
				if ($defaultOrderColumn == "twr_stan_aktualny") {
					$orderColumnNotDisplayed = " slk_towary.twr_stan_aktualny ";
				}
			}
			if (P('show_export_stan_minimalny', "1") != "0") {
				$queryString = $queryString . ", slk_towary.twr_stan_minimalny twr_stan_minimalny";
			} else {
				if ($defaultOrderColumn == "twr_stan_minimalny") {
					$orderColumnNotDisplayed = " slk_towary.twr_stan_minimalny ";
				}
			}
			if (P('show_export_produkt', "1") != "0") {
				$queryString = $queryString . ", slk_towary.twr_produkt twr_produkt";
			} else {
				if ($defaultOrderColumn == "twr_produkt") {
					$orderColumnNotDisplayed = " slk_towary.twr_produkt ";
				}
			}
			if (class_exists('sealock\virgoGrupaTowaru') && P('show_export_grupa_towaru', "1") != "0") { // */ && !in_array("gtw", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_towary.twr_gtw_id as twr_gtw_id ";
				$queryString = $queryString . ", slk_grupy_towarow_parent.gtw_virgo_title as `grupa_towaru` ";
			} else {
				if ($defaultOrderColumn == "grupa_towaru") {
					$orderColumnNotDisplayed = " slk_grupy_towarow_parent.gtw_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoJednostka') && P('show_export_jednostka', "1") != "0") { // */ && !in_array("jdn", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_towary.twr_jdn_id as twr_jdn_id ";
				$queryString = $queryString . ", slk_jednostki_parent.jdn_virgo_title as `jednostka` ";
			} else {
				if ($defaultOrderColumn == "jednostka") {
					$orderColumnNotDisplayed = " slk_jednostki_parent.jdn_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_towary ";
			if (class_exists('sealock\virgoGrupaTowaru')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_grupy_towarow AS slk_grupy_towarow_parent ON (slk_towary.twr_gtw_id = slk_grupy_towarow_parent.gtw_id) ";
			}
			if (class_exists('sealock\virgoJednostka')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_jednostki AS slk_jednostki_parent ON (slk_towary.twr_jdn_id = slk_jednostki_parent.jdn_id) ";
			}

			$resultsTowar = $resultTowar->select(
				'', 
				'all', 
				$resultTowar->getOrderColumn(), 
				$resultTowar->getOrderMode(), 
				$whereClauseTowar,
				$queryString);
			$index = 1;
			foreach ($resultsTowar as $resultTowar) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultTowar['twr_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_kod', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultTowar['twr_kod'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_nazwa', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultTowar['twr_nazwa'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_stan_aktualny', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultTowar['twr_stan_aktualny'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_stan_minimalny', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultTowar['twr_stan_minimalny'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_produkt', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultTowar['twr_produkt'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_grupa_towaru', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoGrupaTowaru::lookup($resultTowar['twr_gtw_id']);
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
					$objValidation->setFormula1('"' . $formulaGrupaTowaru . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
				if (P('show_export_jednostka', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoJednostka::lookup($resultTowar['twr_jdn_id']);
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
					$objValidation->setFormula1('"' . $formulaJednostka . '"');
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
					$propertyColumnHash['kod'] = 'twr_kod';
					$propertyColumnHash['kod'] = 'twr_kod';
					$propertyColumnHash['nazwa'] = 'twr_nazwa';
					$propertyColumnHash['nazwa'] = 'twr_nazwa';
					$propertyColumnHash['stan aktualny'] = 'twr_stan_aktualny';
					$propertyColumnHash['stan_aktualny'] = 'twr_stan_aktualny';
					$propertyColumnHash['stan minimalny'] = 'twr_stan_minimalny';
					$propertyColumnHash['stan_minimalny'] = 'twr_stan_minimalny';
					$propertyColumnHash['produkt'] = 'twr_produkt';
					$propertyColumnHash['produkt'] = 'twr_produkt';
					$propertyClassHash['grupa towaru'] = 'GrupaTowaru';
					$propertyClassHash['grupa_towaru'] = 'GrupaTowaru';
					$propertyColumnHash['grupa towaru'] = 'twr_gtw_id';
					$propertyColumnHash['grupa_towaru'] = 'twr_gtw_id';
					$propertyClassHash['jednostka'] = 'Jednostka';
					$propertyClassHash['jednostka'] = 'Jednostka';
					$propertyColumnHash['jednostka'] = 'twr_jdn_id';
					$propertyColumnHash['jednostka'] = 'twr_jdn_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importTowar = new virgoTowar();
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
										L(T('PROPERTY_NOT_FOUND', T('TOWAR'), $columns[$index]), '', 'ERROR');
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
										$importTowar->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_grupa_towaru');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoGrupaTowaru::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoGrupaTowaru::token2Id($tmpToken);
	}
	$importTowar->setGtwId($defaultValue);
}
$defaultValue = P('import_default_value_jednostka');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoJednostka::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoJednostka::token2Id($tmpToken);
	}
	$importTowar->setJdnId($defaultValue);
}
							$errorMessage = $importTowar->store();
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
		

		static function portletActionVirgoChangeGrupaTowaru() {
			$instance = new virgoTowar();
			$instance->loadFromDB();
			self::portletActionSelect(true, $instance->getId());
			$parentId = R('virgo_parent_id');
			$parent = virgoGrupaTowaru::getById($parentId);
			$title = $parent->getVirgoTitle();
			if (!is_null($title) && trim($title) != "") {
				$instance->setGtwId($parentId);
				$errorMessage = $instance->store();
				if ($errorMessage == "") {
					L(T('PARENT_SET', T('GRUPA_TOWARU'), $title), '', 'INFO');
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
		static function portletActionVirgoChangeJednostka() {
			$instance = new virgoTowar();
			$instance->loadFromDB();
			self::portletActionSelect(true, $instance->getId());
			$parentId = R('virgo_parent_id');
			$parent = virgoJednostka::getById($parentId);
			$title = $parent->getVirgoTitle();
			if (!is_null($title) && trim($title) != "") {
				$instance->setJdnId($parentId);
				$errorMessage = $instance->store();
				if ($errorMessage == "") {
					L(T('PARENT_SET', T('JEDNOSTKA'), $title), '', 'INFO');
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



		static function portletActionVirgoSetGrupaTowaru() {
			$this->loadFromDB();
			$parentId = R('twr_GrupaTowaru_id_' . $_SESSION['current_portlet_object_id']);
			$this->setGtwId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetJednostka() {
			$this->loadFromDB();
			$parentId = R('twr_Jednostka_id_' . $_SESSION['current_portlet_object_id']);
			$this->setJdnId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}




		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `slk_towary` (
  `twr_id` bigint(20) unsigned NOT NULL auto_increment,
  `twr_virgo_state` varchar(50) default NULL,
  `twr_virgo_title` varchar(255) default NULL,
	`twr_gtw_id` int(11) default NULL,
	`twr_jdn_id` int(11) default NULL,
  `twr_kod` varchar(255), 
  `twr_nazwa` varchar(255), 
  `twr_stan_aktualny` decimal(10,2),  
  `twr_stan_minimalny` decimal(10,2),  
  `twr_produkt` boolean,  
  `twr_date_created` datetime NOT NULL,
  `twr_date_modified` datetime default NULL,
  `twr_usr_created_id` int(11) NOT NULL,
  `twr_usr_modified_id` int(11) default NULL,
  KEY `twr_gtw_fk` (`twr_gtw_id`),
  KEY `twr_jdn_fk` (`twr_jdn_id`),
  PRIMARY KEY  (`twr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/towar.sql 
INSERT INTO `slk_towary` (`twr_virgo_title`, `twr_kod`, `twr_nazwa`, `twr_stan_aktualny`, `twr_stan_minimalny`, `twr_produkt`) 
VALUES (title, some_value, some_value, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably slk_towary table already exists.", '', 'FATAL');
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
			return "twr";
		}
		
		static function getPlural() {
			return "towary";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoGrupaTowaru";
			$ret[] = "virgoJednostka";
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoPozycjaZamowienia";
			$ret[] = "virgoProdukt";
			$ret[] = "virgoSkladnik";
			$ret[] = "virgoSkladnik";
			$ret[] = "virgoPozycjaBilansu";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'slk_towary'));
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
			$virgoVersion = virgoTowar::getVirgoVersion();
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
	
	

