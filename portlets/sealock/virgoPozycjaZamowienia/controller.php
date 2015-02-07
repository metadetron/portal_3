<?php
/**
* Module Pozycja zamówienia
* @package Sealock
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace sealock;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoZamowienie'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoTowar'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoWydanie'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoPozycjaZamowienia {

		 private  $pzm_id = null;
		 private  $pzm_ilosc = null;

		 private  $pzm_cena_netto = null;

		 private  $pzm_cena_brutto = null;

		 private  $pzm_zmw_id = null;
		 private  $pzm_twr_id = null;
		 private  $pzm_wdn_id = null;

		 private   $pzm_date_created = null;
		 private   $pzm_usr_created_id = null;
		 private   $pzm_date_modified = null;
		 private   $pzm_usr_modified_id = null;
		 private   $pzm_virgo_title = null;
		
		 private   $internalLog = null;		
				
		 private  function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		public function isDeletedVirgo() {
			return $this->pzm_virgo_deleted;
		}

		static public function createGuiAware() {
			$ret = new virgoPozycjaZamowienia();
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
        	$this->pzm_id = null;
		    $this->pzm_date_created = null;
		    $this->pzm_usr_created_id = null;
		    $this->pzm_date_modified = null;
		    $this->pzm_usr_modified_id = null;
		    $this->pzm_virgo_title = null;
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
			return $this->pzm_id;
		}

		function getIlosc() {
			return $this->pzm_ilosc;
		}
		
		 private  function setIlosc($val) {
			$this->pzm_ilosc = $val;
		}
		function getCenaNetto() {
			return $this->pzm_cena_netto;
		}
		
		 private  function setCenaNetto($val) {
			$this->pzm_cena_netto = $val;
		}
		function getCenaBrutto() {
			return $this->pzm_cena_brutto;
		}
		
		 private  function setCenaBrutto($val) {
			$this->pzm_cena_brutto = $val;
		}

		function getZamowienieId() {
			return $this->pzm_zmw_id;
		}
		
		 private  function setZamowienieId($val) {
			$this->pzm_zmw_id = $val;
		}
		function getTowarId() {
			return $this->pzm_twr_id;
		}
		
		 private  function setTowarId($val) {
			$this->pzm_twr_id = $val;
		}
		function getWydanieId() {
			return $this->pzm_wdn_id;
		}
		
		 private  function setWydanieId($val) {
			$this->pzm_wdn_id = $val;
		}

		function getDateCreated() {
			return $this->pzm_date_created;
		}
		function getUsrCreatedId() {
			return $this->pzm_usr_created_id;
		}
		function getDateModified() {
			return $this->pzm_date_modified;
		}
		function getUsrModifiedId() {
			return $this->pzm_usr_modified_id;
		}


		function getZmwId() {
			return $this->getZamowienieId();
		}
		
		 private  function setZmwId($val) {
			$this->setZamowienieId($val);
		}
		function getTwrId() {
			return $this->getTowarId();
		}
		
		 private  function setTwrId($val) {
			$this->setTowarId($val);
		}
		function getWdnId() {
			return $this->getWydanieId();
		}
		
		 private  function setWdnId($val) {
			$this->setWydanieId($val);
		}

		function loadRecordFromRequest($rowId) {
			$this->pzm_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('pzm_ilosc_' . $this->pzm_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->pzm_ilosc = null;
		} else {
			$this->pzm_ilosc = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('pzm_cenaNetto_' . $this->pzm_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->pzm_cena_netto = null;
		} else {
			$this->pzm_cena_netto = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('pzm_cenaBrutto_' . $this->pzm_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->pzm_cena_brutto = null;
		} else {
			$this->pzm_cena_brutto = $tmpValue;
		}
	}
			$this->pzm_zmw_id = strval(R('pzm_zamowienie_' . $this->pzm_id));
			$this->pzm_twr_id = strval(R('pzm_towar_' . $this->pzm_id));
			$this->pzm_wdn_id = strval(R('pzm_wydanie_' . $this->pzm_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('pzm_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaPozycjaZamowienia = array();	
			$criteriaFieldPozycjaZamowienia = array();	
			$isNullPozycjaZamowienia = R('virgo_search_ilosc_is_null');
			
			$criteriaFieldPozycjaZamowienia["is_null"] = 0;
			if ($isNullPozycjaZamowienia == "not_null") {
				$criteriaFieldPozycjaZamowienia["is_null"] = 1;
			} elseif ($isNullPozycjaZamowienia == "null") {
				$criteriaFieldPozycjaZamowienia["is_null"] = 2;
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
			$criteriaFieldPozycjaZamowienia["value"] = $dataTypeCriteria;
//			}
			$criteriaPozycjaZamowienia["ilosc"] = $criteriaFieldPozycjaZamowienia;
			$criteriaFieldPozycjaZamowienia = array();	
			$isNullPozycjaZamowienia = R('virgo_search_cenaNetto_is_null');
			
			$criteriaFieldPozycjaZamowienia["is_null"] = 0;
			if ($isNullPozycjaZamowienia == "not_null") {
				$criteriaFieldPozycjaZamowienia["is_null"] = 1;
			} elseif ($isNullPozycjaZamowienia == "null") {
				$criteriaFieldPozycjaZamowienia["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_cenaNetto_from');
		if (!is_numeric($dataTypeCriteria["from"])) {
			$dataTypeCriteria["from"] = null;
		}
		$dataTypeCriteria["to"] = R('virgo_search_cenaNetto_to');
		if (!is_numeric($dataTypeCriteria["to"])) {
			$dataTypeCriteria["to"] = null;
		}

//			if ($isSet) {
			$criteriaFieldPozycjaZamowienia["value"] = $dataTypeCriteria;
//			}
			$criteriaPozycjaZamowienia["cena_netto"] = $criteriaFieldPozycjaZamowienia;
			$criteriaFieldPozycjaZamowienia = array();	
			$isNullPozycjaZamowienia = R('virgo_search_cenaBrutto_is_null');
			
			$criteriaFieldPozycjaZamowienia["is_null"] = 0;
			if ($isNullPozycjaZamowienia == "not_null") {
				$criteriaFieldPozycjaZamowienia["is_null"] = 1;
			} elseif ($isNullPozycjaZamowienia == "null") {
				$criteriaFieldPozycjaZamowienia["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_cenaBrutto_from');
		if (!is_numeric($dataTypeCriteria["from"])) {
			$dataTypeCriteria["from"] = null;
		}
		$dataTypeCriteria["to"] = R('virgo_search_cenaBrutto_to');
		if (!is_numeric($dataTypeCriteria["to"])) {
			$dataTypeCriteria["to"] = null;
		}

//			if ($isSet) {
			$criteriaFieldPozycjaZamowienia["value"] = $dataTypeCriteria;
//			}
			$criteriaPozycjaZamowienia["cena_brutto"] = $criteriaFieldPozycjaZamowienia;
			$criteriaParent = array();	
			$isNull = R('virgo_search_zamowienie_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_zamowienie', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaPozycjaZamowienia["zamowienie"] = $criteriaParent;
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
			$criteriaPozycjaZamowienia["towar"] = $criteriaParent;
			$criteriaParent = array();	
			$isNull = R('virgo_search_wydanie_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_wydanie', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaPozycjaZamowienia["wydanie"] = $criteriaParent;
			self::setCriteria($criteriaPozycjaZamowienia);
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
			$tableFilter = R('virgo_filter_cena_netto');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterCenaNetto', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterCenaNetto', null);
			}
			$tableFilter = R('virgo_filter_cena_brutto');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterCenaBrutto', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterCenaBrutto', null);
			}
			$parentFilter = R('virgo_filter_zamowienie');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterZamowienie', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterZamowienie', null);
			}
			$parentFilter = R('virgo_filter_title_zamowienie');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleZamowienie', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleZamowienie', null);
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
			$parentFilter = R('virgo_filter_wydanie');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterWydanie', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterWydanie', null);
			}
			$parentFilter = R('virgo_filter_title_wydanie');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleWydanie', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleWydanie', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClausePozycjaZamowienia = ' 1 = 1 ';
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
				$eventColumn = "pzm_" . P('event_column');
				$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_zamowienie');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_pozycje_zamowien.pzm_zmw_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_pozycje_zamowien.pzm_zmw_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_towar');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_pozycje_zamowien.pzm_twr_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_pozycje_zamowien.pzm_twr_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_wydanie');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_pozycje_zamowien.pzm_wdn_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_pozycje_zamowien.pzm_wdn_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaPozycjaZamowienia = self::getCriteria();
			if (isset($criteriaPozycjaZamowienia["ilosc"])) {
				$fieldCriteriaIlosc = $criteriaPozycjaZamowienia["ilosc"];
				if ($fieldCriteriaIlosc["is_null"] == 1) {
$filter = $filter . ' AND slk_pozycje_zamowien.pzm_ilosc IS NOT NULL ';
				} elseif ($fieldCriteriaIlosc["is_null"] == 2) {
$filter = $filter . ' AND slk_pozycje_zamowien.pzm_ilosc IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaIlosc["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_pozycje_zamowien.pzm_ilosc >= ? ";
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_pozycje_zamowien.pzm_ilosc <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPozycjaZamowienia["cena_netto"])) {
				$fieldCriteriaCenaNetto = $criteriaPozycjaZamowienia["cena_netto"];
				if ($fieldCriteriaCenaNetto["is_null"] == 1) {
$filter = $filter . ' AND slk_pozycje_zamowien.pzm_cena_netto IS NOT NULL ';
				} elseif ($fieldCriteriaCenaNetto["is_null"] == 2) {
$filter = $filter . ' AND slk_pozycje_zamowien.pzm_cena_netto IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaCenaNetto["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_pozycje_zamowien.pzm_cena_netto >= ? ";
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_pozycje_zamowien.pzm_cena_netto <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPozycjaZamowienia["cena_brutto"])) {
				$fieldCriteriaCenaBrutto = $criteriaPozycjaZamowienia["cena_brutto"];
				if ($fieldCriteriaCenaBrutto["is_null"] == 1) {
$filter = $filter . ' AND slk_pozycje_zamowien.pzm_cena_brutto IS NOT NULL ';
				} elseif ($fieldCriteriaCenaBrutto["is_null"] == 2) {
$filter = $filter . ' AND slk_pozycje_zamowien.pzm_cena_brutto IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaCenaBrutto["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_pozycje_zamowien.pzm_cena_brutto >= ? ";
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_pozycje_zamowien.pzm_cena_brutto <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPozycjaZamowienia["zamowienie"])) {
				$parentCriteria = $criteriaPozycjaZamowienia["zamowienie"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pzm_zmw_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_pozycje_zamowien.pzm_zmw_id IN (SELECT zmw_id FROM slk_zamowienia WHERE zmw_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPozycjaZamowienia["towar"])) {
				$parentCriteria = $criteriaPozycjaZamowienia["towar"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pzm_twr_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_pozycje_zamowien.pzm_twr_id IN (SELECT twr_id FROM slk_towary WHERE twr_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPozycjaZamowienia["wydanie"])) {
				$parentCriteria = $criteriaPozycjaZamowienia["wydanie"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pzm_wdn_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_pozycje_zamowien.pzm_wdn_id IN (SELECT wdn_id FROM slk_wydania WHERE wdn_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterIlosc', null);
				if (S($tableFilter)) {
					$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND pzm_ilosc LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterCenaNetto', null);
				if (S($tableFilter)) {
					$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND pzm_cena_netto LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterCenaBrutto', null);
				if (S($tableFilter)) {
					$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND pzm_cena_brutto LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterZamowienie', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND pzm_zmw_id IS NULL ";
					} else {
						$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND pzm_zmw_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleZamowienie', null);
				if (S($parentFilter)) {
					$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND slk_zamowienia_parent.zmw_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterTowar', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND pzm_twr_id IS NULL ";
					} else {
						$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND pzm_twr_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleTowar', null);
				if (S($parentFilter)) {
					$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND slk_towary_parent.twr_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterWydanie', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND pzm_wdn_id IS NULL ";
					} else {
						$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND pzm_wdn_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleWydanie', null);
				if (S($parentFilter)) {
					$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND slk_wydania_parent.wdn_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClausePozycjaZamowienia;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClausePozycjaZamowienia = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT slk_pozycje_zamowien.pzm_id, slk_pozycje_zamowien.pzm_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_ilosc', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_ilosc pzm_ilosc";
			} else {
				if ($defaultOrderColumn == "pzm_ilosc") {
					$orderColumnNotDisplayed = " slk_pozycje_zamowien.pzm_ilosc ";
				}
			}
			if (P('show_table_cena_netto', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_cena_netto pzm_cena_netto";
			} else {
				if ($defaultOrderColumn == "pzm_cena_netto") {
					$orderColumnNotDisplayed = " slk_pozycje_zamowien.pzm_cena_netto ";
				}
			}
			if (P('show_table_cena_brutto', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_cena_brutto pzm_cena_brutto";
			} else {
				if ($defaultOrderColumn == "pzm_cena_brutto") {
					$orderColumnNotDisplayed = " slk_pozycje_zamowien.pzm_cena_brutto ";
				}
			}
			if (class_exists('sealock\virgoZamowienie') && P('show_table_zamowienie', "1") != "0") { // */ && !in_array("zmw", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_zmw_id as pzm_zmw_id ";
				$queryString = $queryString . ", slk_zamowienia_parent.zmw_virgo_title as `zamowienie` ";
			} else {
				if ($defaultOrderColumn == "zamowienie") {
					$orderColumnNotDisplayed = " slk_zamowienia_parent.zmw_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoTowar') && P('show_table_towar', "1") != "0") { // */ && !in_array("twr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_twr_id as pzm_twr_id ";
				$queryString = $queryString . ", slk_towary_parent.twr_virgo_title as `towar` ";
			} else {
				if ($defaultOrderColumn == "towar") {
					$orderColumnNotDisplayed = " slk_towary_parent.twr_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoWydanie') && P('show_table_wydanie', "1") != "0") { // */ && !in_array("wdn", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_wdn_id as pzm_wdn_id ";
				$queryString = $queryString . ", slk_wydania_parent.wdn_virgo_title as `wydanie` ";
			} else {
				if ($defaultOrderColumn == "wydanie") {
					$orderColumnNotDisplayed = " slk_wydania_parent.wdn_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_pozycje_zamowien ";
			if (class_exists('sealock\virgoZamowienie')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_zamowienia AS slk_zamowienia_parent ON (slk_pozycje_zamowien.pzm_zmw_id = slk_zamowienia_parent.zmw_id) ";
			}
			if (class_exists('sealock\virgoTowar')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_towary AS slk_towary_parent ON (slk_pozycje_zamowien.pzm_twr_id = slk_towary_parent.twr_id) ";
			}
			if (class_exists('sealock\virgoWydanie')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_wydania AS slk_wydania_parent ON (slk_pozycje_zamowien.pzm_wdn_id = slk_wydania_parent.wdn_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClausePozycjaZamowienia, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClausePozycjaZamowienia,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM slk_pozycje_zamowien"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " pzm_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " pzm_usr_created_id = ? ";
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
				. "\n FROM slk_pozycje_zamowien"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as slk_pozycje_zamowien ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as slk_pozycje_zamowien ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, pzm_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " pzm_usr_created_id = ? ";
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
				$query = "SELECT COUNT(pzm_id) cnt FROM pozycje_zamowien";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as pozycje_zamowien ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as pozycje_zamowien ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoPozycjaZamowienia();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM slk_pozycje_zamowien WHERE pzm_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->pzm_id = $row['pzm_id'];
$this->pzm_ilosc = $row['pzm_ilosc'];
$this->pzm_cena_netto = $row['pzm_cena_netto'];
$this->pzm_cena_brutto = $row['pzm_cena_brutto'];
						$this->pzm_zmw_id = $row['pzm_zmw_id'];
						$this->pzm_twr_id = $row['pzm_twr_id'];
						$this->pzm_wdn_id = $row['pzm_wdn_id'];
						if ($fetchUsernames) {
							if ($row['pzm_date_created']) {
								if ($row['pzm_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['pzm_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['pzm_date_modified']) {
								if ($row['pzm_usr_modified_id'] == $row['pzm_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['pzm_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['pzm_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->pzm_date_created = $row['pzm_date_created'];
						$this->pzm_usr_created_id = $fetchUsernames ? $createdBy : $row['pzm_usr_created_id'];
						$this->pzm_date_modified = $row['pzm_date_modified'];
						$this->pzm_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['pzm_usr_modified_id'];
						$this->pzm_virgo_title = $row['pzm_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE slk_pozycje_zamowien SET pzm_usr_created_id = {$userId} WHERE pzm_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->pzm_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoPozycjaZamowienia::selectAllAsObjectsStatic('pzm_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->pzm_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->pzm_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('pzm_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_pzm = new virgoPozycjaZamowienia();
				$tmp_pzm->load((int)$lookup_id);
				return $tmp_pzm->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoPozycjaZamowienia');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" pzm_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoPozycjaZamowienia', "10");
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
				$query = $query . " pzm_id as id, pzm_virgo_title as title ";
			}
			$query = $query . " FROM slk_pozycje_zamowien ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoPozycjaZamowienia', 'sealock') == "1") {
				$privateCondition = " pzm_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY pzm_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resPozycjaZamowienia = array();
				foreach ($rows as $row) {
					$resPozycjaZamowienia[$row['id']] = $row['title'];
				}
				return $resPozycjaZamowienia;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticPozycjaZamowienia = new virgoPozycjaZamowienia();
			return $staticPozycjaZamowienia->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getZamowienieStatic($parentId) {
			return virgoZamowienie::getById($parentId);
		}
		
		function getZamowienie() {
			return virgoPozycjaZamowienia::getZamowienieStatic($this->pzm_zmw_id);
		}
		static function getTowarStatic($parentId) {
			return virgoTowar::getById($parentId);
		}
		
		function getTowar() {
			return virgoPozycjaZamowienia::getTowarStatic($this->pzm_twr_id);
		}
		static function getWydanieStatic($parentId) {
			return virgoWydanie::getById($parentId);
		}
		
		function getWydanie() {
			return virgoPozycjaZamowienia::getWydanieStatic($this->pzm_wdn_id);
		}


		function validateObject($virgoOld) {
			if (
(is_null($this->getIlosc()) || trim($this->getIlosc()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'ILOSC');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_cena_netto_obligatory', "0") == "1") {
				if (
(is_null($this->getCenaNetto()) || trim($this->getCenaNetto()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'CENA_NETTO');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_cena_brutto_obligatory', "0") == "1") {
				if (
(is_null($this->getCenaBrutto()) || trim($this->getCenaBrutto()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'CENA_BRUTTO');
				}			
			}
				if (is_null($this->pzm_zmw_id) || trim($this->pzm_zmw_id) == "") {
					if (R('create_pzm_zamowienie_' . $this->pzm_id) == "1") { 
						$parent = new virgoZamowienie();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->pzm_zmw_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'ZAMOWIENIE', '');
					}
			}			
				if (is_null($this->pzm_twr_id) || trim($this->pzm_twr_id) == "") {
					if (R('create_pzm_towar_' . $this->pzm_id) == "1") { 
						$parent = new virgoTowar();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->pzm_twr_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'TOWAR', '');
					}
			}			
				if (is_null($this->pzm_wdn_id) || trim($this->pzm_wdn_id) == "") {
					if (R('create_pzm_wydanie_' . $this->pzm_id) == "1") { 
						$parent = new virgoWydanie();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->pzm_wdn_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'WYDANIE', '');
					}
			}			
 			if (!is_null($this->pzm_ilosc) && trim($this->pzm_ilosc) != "") {
				if (!is_numeric($this->pzm_ilosc)) {
					return T('INCORRECT_NUMBER', 'ILOSC', $this->pzm_ilosc);
				}
			}
			if (!is_null($this->pzm_cena_netto) && trim($this->pzm_cena_netto) != "") {
				if (!is_numeric($this->pzm_cena_netto)) {
					return T('INCORRECT_NUMBER', 'CENA_NETTO', $this->pzm_cena_netto);
				}
			}
			if (!is_null($this->pzm_cena_brutto) && trim($this->pzm_cena_brutto) != "") {
				if (!is_numeric($this->pzm_cena_brutto)) {
					return T('INCORRECT_NUMBER', 'CENA_BRUTTO', $this->pzm_cena_brutto);
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  slk_history_pozycje_zamowien WHERE pzm_id = " . $this->getId();
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
				$colNames = $colNames . ", pzm_ilosc";
				$values = $values . ", " . (is_null($objectToStore->getIlosc()) ? "null" : "'" . QE($objectToStore->getIlosc()) . "'");
				$colNames = $colNames . ", pzm_cena_netto";
				$values = $values . ", " . (is_null($objectToStore->getCenaNetto()) ? "null" : "'" . QE($objectToStore->getCenaNetto()) . "'");
				$colNames = $colNames . ", pzm_cena_brutto";
				$values = $values . ", " . (is_null($objectToStore->getCenaBrutto()) ? "null" : "'" . QE($objectToStore->getCenaBrutto()) . "'");
				$colNames = $colNames . ", pzm_zmw_id";
				$values = $values . ", " . (is_null($objectToStore->getZmwId()) || $objectToStore->getZmwId() == "" ? "null" : $objectToStore->getZmwId());
				$colNames = $colNames . ", pzm_twr_id";
				$values = $values . ", " . (is_null($objectToStore->getTwrId()) || $objectToStore->getTwrId() == "" ? "null" : $objectToStore->getTwrId());
				$colNames = $colNames . ", pzm_wdn_id";
				$values = $values . ", " . (is_null($objectToStore->getWdnId()) || $objectToStore->getWdnId() == "" ? "null" : $objectToStore->getWdnId());
				$query = "INSERT INTO slk_history_pozycje_zamowien (revision, ip, username, user_id, timestamp, pzm_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
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
				$colNames = $colNames . ", pzm_ilosc";
				$values = $values . ", " . (is_null($objectToStore->getIlosc()) ? "null" : "'" . QE($objectToStore->getIlosc()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getCenaNetto() != $objectToStore->getCenaNetto()) {
				if (is_null($objectToStore->getCenaNetto())) {
					$nullifiedProperties = $nullifiedProperties . "cena_netto,";
				} else {
				$colNames = $colNames . ", pzm_cena_netto";
				$values = $values . ", " . (is_null($objectToStore->getCenaNetto()) ? "null" : "'" . QE($objectToStore->getCenaNetto()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getCenaBrutto() != $objectToStore->getCenaBrutto()) {
				if (is_null($objectToStore->getCenaBrutto())) {
					$nullifiedProperties = $nullifiedProperties . "cena_brutto,";
				} else {
				$colNames = $colNames . ", pzm_cena_brutto";
				$values = $values . ", " . (is_null($objectToStore->getCenaBrutto()) ? "null" : "'" . QE($objectToStore->getCenaBrutto()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getZmwId() != $objectToStore->getZmwId() && ($virgoOld->getZmwId() != 0 || $objectToStore->getZmwId() != ""))) { 
				$colNames = $colNames . ", pzm_zmw_id";
				$values = $values . ", " . (is_null($objectToStore->getZmwId()) ? "null" : ($objectToStore->getZmwId() == "" ? "0" : $objectToStore->getZmwId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getTwrId() != $objectToStore->getTwrId() && ($virgoOld->getTwrId() != 0 || $objectToStore->getTwrId() != ""))) { 
				$colNames = $colNames . ", pzm_twr_id";
				$values = $values . ", " . (is_null($objectToStore->getTwrId()) ? "null" : ($objectToStore->getTwrId() == "" ? "0" : $objectToStore->getTwrId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getWdnId() != $objectToStore->getWdnId() && ($virgoOld->getWdnId() != 0 || $objectToStore->getWdnId() != ""))) { 
				$colNames = $colNames . ", pzm_wdn_id";
				$values = $values . ", " . (is_null($objectToStore->getWdnId()) ? "null" : ($objectToStore->getWdnId() == "" ? "0" : $objectToStore->getWdnId()));
			}
			$query = "INSERT INTO slk_history_pozycje_zamowien (revision, ip, username, user_id, timestamp, pzm_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM slk_pozycje_zamowien");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'pzm_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE slk_pozycje_zamowien ADD COLUMN (pzm_virgo_title VARCHAR(255));";
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
			if (isset($this->pzm_id) && $this->pzm_id != "") {
				$query = "UPDATE slk_pozycje_zamowien SET ";
			if (isset($this->pzm_ilosc)) {
				$query .= " pzm_ilosc = ? ,";
				$types .= "d";
				$values[] = number_format($this->pzm_ilosc, 2, '.', '');
			} else {
				$query .= " pzm_ilosc = NULL ,";				
			}
			if (isset($this->pzm_cena_netto)) {
				$query .= " pzm_cena_netto = ? ,";
				$types .= "d";
				$values[] = number_format($this->pzm_cena_netto, 2, '.', '');
			} else {
				$query .= " pzm_cena_netto = NULL ,";				
			}
			if (isset($this->pzm_cena_brutto)) {
				$query .= " pzm_cena_brutto = ? ,";
				$types .= "d";
				$values[] = number_format($this->pzm_cena_brutto, 2, '.', '');
			} else {
				$query .= " pzm_cena_brutto = NULL ,";				
			}
				if (isset($this->pzm_zmw_id) && trim($this->pzm_zmw_id) != "") {
					$query = $query . " pzm_zmw_id = ? , ";
					$types = $types . "i";
					$values[] = $this->pzm_zmw_id;
				} else {
					$query = $query . " pzm_zmw_id = NULL, ";
				}
				if (isset($this->pzm_twr_id) && trim($this->pzm_twr_id) != "") {
					$query = $query . " pzm_twr_id = ? , ";
					$types = $types . "i";
					$values[] = $this->pzm_twr_id;
				} else {
					$query = $query . " pzm_twr_id = NULL, ";
				}
				if (isset($this->pzm_wdn_id) && trim($this->pzm_wdn_id) != "") {
					$query = $query . " pzm_wdn_id = ? , ";
					$types = $types . "i";
					$values[] = $this->pzm_wdn_id;
				} else {
					$query = $query . " pzm_wdn_id = NULL, ";
				}
				$query = $query . " pzm_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " pzm_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->pzm_date_modified;

				$query = $query . " pzm_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->pzm_usr_modified_id;

				$query = $query . " WHERE pzm_id = ? ";
				$types = $types . "i";
				$values[] = $this->pzm_id;
			} else {
				$query = "INSERT INTO slk_pozycje_zamowien ( ";
			$query = $query . " pzm_ilosc, ";
			$query = $query . " pzm_cena_netto, ";
			$query = $query . " pzm_cena_brutto, ";
				$query = $query . " pzm_zmw_id, ";
				$query = $query . " pzm_twr_id, ";
				$query = $query . " pzm_wdn_id, ";
				$query = $query . " pzm_virgo_title, pzm_date_created, pzm_usr_created_id) VALUES ( ";
			if (isset($this->pzm_ilosc)) {
				$query .= " ? ,";
				$types .= "d";
				$values[] = $this->pzm_ilosc;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pzm_cena_netto)) {
				$query .= " ? ,";
				$types .= "d";
				$values[] = $this->pzm_cena_netto;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pzm_cena_brutto)) {
				$query .= " ? ,";
				$types .= "d";
				$values[] = $this->pzm_cena_brutto;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->pzm_zmw_id) && trim($this->pzm_zmw_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->pzm_zmw_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->pzm_twr_id) && trim($this->pzm_twr_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->pzm_twr_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->pzm_wdn_id) && trim($this->pzm_wdn_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->pzm_wdn_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->pzm_date_created;
				$values[] = $this->pzm_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->pzm_id) || $this->pzm_id == "") {
					$this->pzm_id = QID();
				}
				if ($log) {
					L("pozycja zam\u00F3wienia stored successfully", "id = {$this->pzm_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->pzm_id) {
				$virgoOld = new virgoPozycjaZamowienia($this->pzm_id);
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
					if ($this->pzm_id) {			
						$this->pzm_date_modified = date("Y-m-d H:i:s");
						$this->pzm_usr_modified_id = $userId;
					} else {
						$this->pzm_date_created = date("Y-m-d H:i:s");
						$this->pzm_usr_created_id = $userId;
					}
					$this->pzm_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "pozycja zam\u00F3wienia" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "pozycja zam\u00F3wienia" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM slk_pozycje_zamowien WHERE pzm_id = {$this->pzm_id}";
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
			$tmp = new virgoPozycjaZamowienia();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT pzm_id as id FROM slk_pozycje_zamowien";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'pzm_order_column')) {
				$orderBy = " ORDER BY pzm_order_column ASC ";
			} 
			if (property_exists($this, 'pzm_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY pzm_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoPozycjaZamowienia();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoPozycjaZamowienia($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE slk_pozycje_zamowien SET pzm_virgo_title = '$title' WHERE pzm_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoPozycjaZamowienia();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" pzm_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['pzm_id'];
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
			virgoPozycjaZamowienia::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoPozycjaZamowienia::setSessionValue('Sealock_PozycjaZamowienia-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoPozycjaZamowienia::getSessionValue('Sealock_PozycjaZamowienia-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoPozycjaZamowienia::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoPozycjaZamowienia::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoPozycjaZamowienia::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoPozycjaZamowienia::getSessionValue('GLOBAL', $name, $default);
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
			$context['pzm_id'] = $id;
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
			$context['pzm_id'] = null;
			virgoPozycjaZamowienia::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoPozycjaZamowienia::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoPozycjaZamowienia::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoPozycjaZamowienia::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoPozycjaZamowienia::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoPozycjaZamowienia::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoPozycjaZamowienia::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoPozycjaZamowienia::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoPozycjaZamowienia::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoPozycjaZamowienia::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoPozycjaZamowienia::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoPozycjaZamowienia::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoPozycjaZamowienia::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoPozycjaZamowienia::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoPozycjaZamowienia::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoPozycjaZamowienia::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoPozycjaZamowienia::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "pzm_id";
			}
			return virgoPozycjaZamowienia::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoPozycjaZamowienia::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoPozycjaZamowienia::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoPozycjaZamowienia::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoPozycjaZamowienia::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoPozycjaZamowienia::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoPozycjaZamowienia::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoPozycjaZamowienia::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoPozycjaZamowienia::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoPozycjaZamowienia::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoPozycjaZamowienia::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoPozycjaZamowienia::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoPozycjaZamowienia::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->pzm_id) {
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
						L(T('STORED_CORRECTLY', 'POZYCJA_ZAMOWIENIA'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'ilość', $this->pzm_ilosc);
						$fieldValues = $fieldValues . T($fieldValue, 'cena netto', $this->pzm_cena_netto);
						$fieldValues = $fieldValues . T($fieldValue, 'cena brutto', $this->pzm_cena_brutto);
						$parentZamowienie = new virgoZamowienie();
						$fieldValues = $fieldValues . T($fieldValue, 'zam\u00F3wienie', $parentZamowienie->lookup($this->pzm_zmw_id));
						$parentTowar = new virgoTowar();
						$fieldValues = $fieldValues . T($fieldValue, 'towar', $parentTowar->lookup($this->pzm_twr_id));
						$parentWydanie = new virgoWydanie();
						$fieldValues = $fieldValues . T($fieldValue, 'wydanie', $parentWydanie->lookup($this->pzm_wdn_id));
						$username = '';
						if ($this->pzm_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->pzm_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->pzm_date_created);
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
			$instance = new virgoPozycjaZamowienia();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoPozycjaZamowienia'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			$instance = new virgoPozycjaZamowienia();
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
			$tmpId = intval(R('pzm_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoPozycjaZamowienia::getContextId();
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
			$this->pzm_id = null;
			$this->pzm_date_created = null;
			$this->pzm_usr_created_id = null;
			$this->pzm_date_modified = null;
			$this->pzm_usr_modified_id = null;
			$this->pzm_virgo_title = null;
			
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

		static function portletActionShowForZamowienie() {
			$parentId = R('zmw_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoZamowienie($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
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
		static function portletActionShowForWydanie() {
			$parentId = R('wdn_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoWydanie($parentId);
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
//			$ret = new virgoPozycjaZamowienia();
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
				$instance = new virgoPozycjaZamowienia();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoPozycjaZamowienia::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'POZYCJA_ZAMOWIENIA'), '', 'INFO');
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
				$resultPozycjaZamowienia = new virgoPozycjaZamowienia();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultPozycjaZamowienia->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultPozycjaZamowienia->load($idToEditInt);
					} else {
						$resultPozycjaZamowienia->pzm_id = 0;
					}
				}
				$results[] = $resultPozycjaZamowienia;
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
				$result = new virgoPozycjaZamowienia();
				$result->loadFromRequest($idToStore);
				if ($result->pzm_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->pzm_id == 0) {
						$result->pzm_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->pzm_id)) {
							$result->pzm_id = 0;
						}
						$idsToCorrect[$result->pzm_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'POZYCJE_ZAMOWIEN'), '', 'INFO');
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
			$resultPozycjaZamowienia = new virgoPozycjaZamowienia();
			foreach ($idsToDelete as $idToDelete) {
				$resultPozycjaZamowienia->load((int)trim($idToDelete));
				$res = $resultPozycjaZamowienia->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'POZYCJE_ZAMOWIEN'), '', 'INFO');			
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
		$ret = $this->pzm_ilosc;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoPozycjaZamowienia');
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
				$query = "UPDATE slk_pozycje_zamowien SET pzm_virgo_title = ? WHERE pzm_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT pzm_id AS id FROM slk_pozycje_zamowien ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoPozycjaZamowienia($row['id']);
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
				$class2prefix["sealock\\virgoZamowienie"] = "zmw";
				$class2prefix2 = array();
				$class2prefix2["sealock\\virgoStatusZamowienia"] = "szm";
				$class2prefix2["sealock\\virgoOdbiorca"] = "odb";
				$class2parentPrefix["sealock\\virgoZamowienie"] = $class2prefix2;
				$class2prefix["sealock\\virgoTowar"] = "twr";
				$class2prefix2 = array();
				$class2prefix2["sealock\\virgoGrupaTowaru"] = "gtw";
				$class2prefix2["sealock\\virgoJednostka"] = "jdn";
				$class2parentPrefix["sealock\\virgoTowar"] = $class2prefix2;
				$class2prefix["sealock\\virgoWydanie"] = "wdn";
				$class2prefix2 = array();
				$class2prefix2["sealock\\virgoProdukt"] = "prd";
				$class2parentPrefix["sealock\\virgoWydanie"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'slk_pozycje_zamowien.pzm_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'slk_pozycje_zamowien.pzm_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'slk_pozycje_zamowien.pzm_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM slk_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'slk_pozycje_zamowien.pzm_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoPozycjaZamowienia!', '', 'ERROR');
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
			$pdf->SetTitle('Pozycje zamówień report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('POZYCJE_ZAMOWIEN');
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
			if (P('show_pdf_cena_netto', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_cena_brutto', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_zamowienie', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_towar', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_wydanie', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultPozycjaZamowienia = new virgoPozycjaZamowienia();
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
			if (P('show_pdf_cena_netto', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Cena netto');
				$minWidth['cena netto'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['cena netto']) {
						$minWidth['cena netto'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_cena_brutto', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Cena brutto');
				$minWidth['cena brutto'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['cena brutto']) {
						$minWidth['cena brutto'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_zamowienie', "1") == "1") {
				$minWidth['zam\u00F3wienie $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'zam\u00F3wienie $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['zam\u00F3wienie $relation.name']) {
						$minWidth['zam\u00F3wienie $relation.name'] = min($tmpLen, $maxWidth);
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
			if (P('show_pdf_wydanie', "1") == "1") {
				$minWidth['wydanie $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'wydanie $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['wydanie $relation.name']) {
						$minWidth['wydanie $relation.name'] = min($tmpLen, $maxWidth);
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
			$whereClausePozycjaZamowienia = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaPozycjaZamowienia = $resultPozycjaZamowienia->getCriteria();
			$fieldCriteriaIlosc = $criteriaPozycjaZamowienia["ilosc"];
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
			$fieldCriteriaCenaNetto = $criteriaPozycjaZamowienia["cena_netto"];
			if ($fieldCriteriaCenaNetto["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Cena netto', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaCenaNetto["value"];
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
					$pdf->MultiCell(60, 100, 'Cena netto', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaCenaBrutto = $criteriaPozycjaZamowienia["cena_brutto"];
			if ($fieldCriteriaCenaBrutto["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Cena brutto', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaCenaBrutto["value"];
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
					$pdf->MultiCell(60, 100, 'Cena brutto', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaPozycjaZamowienia["zamowienie"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Zamówienie', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoZamowienie::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Zamówienie', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaPozycjaZamowienia["towar"];
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
			$parentCriteria = $criteriaPozycjaZamowienia["wydanie"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Wydanie', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoWydanie::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Wydanie', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_zamowienie');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_pozycje_zamowien.pzm_zmw_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_pozycje_zamowien.pzm_zmw_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_towar');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_pozycje_zamowien.pzm_twr_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_pozycje_zamowien.pzm_twr_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_wydanie');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_pozycje_zamowien.pzm_wdn_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_pozycje_zamowien.pzm_wdn_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaPozycjaZamowienia = self::getCriteria();
			if (isset($criteriaPozycjaZamowienia["ilosc"])) {
				$fieldCriteriaIlosc = $criteriaPozycjaZamowienia["ilosc"];
				if ($fieldCriteriaIlosc["is_null"] == 1) {
$filter = $filter . ' AND slk_pozycje_zamowien.pzm_ilosc IS NOT NULL ';
				} elseif ($fieldCriteriaIlosc["is_null"] == 2) {
$filter = $filter . ' AND slk_pozycje_zamowien.pzm_ilosc IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaIlosc["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_pozycje_zamowien.pzm_ilosc >= ? ";
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_pozycje_zamowien.pzm_ilosc <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPozycjaZamowienia["cena_netto"])) {
				$fieldCriteriaCenaNetto = $criteriaPozycjaZamowienia["cena_netto"];
				if ($fieldCriteriaCenaNetto["is_null"] == 1) {
$filter = $filter . ' AND slk_pozycje_zamowien.pzm_cena_netto IS NOT NULL ';
				} elseif ($fieldCriteriaCenaNetto["is_null"] == 2) {
$filter = $filter . ' AND slk_pozycje_zamowien.pzm_cena_netto IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaCenaNetto["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_pozycje_zamowien.pzm_cena_netto >= ? ";
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_pozycje_zamowien.pzm_cena_netto <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPozycjaZamowienia["cena_brutto"])) {
				$fieldCriteriaCenaBrutto = $criteriaPozycjaZamowienia["cena_brutto"];
				if ($fieldCriteriaCenaBrutto["is_null"] == 1) {
$filter = $filter . ' AND slk_pozycje_zamowien.pzm_cena_brutto IS NOT NULL ';
				} elseif ($fieldCriteriaCenaBrutto["is_null"] == 2) {
$filter = $filter . ' AND slk_pozycje_zamowien.pzm_cena_brutto IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaCenaBrutto["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_pozycje_zamowien.pzm_cena_brutto >= ? ";
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_pozycje_zamowien.pzm_cena_brutto <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPozycjaZamowienia["zamowienie"])) {
				$parentCriteria = $criteriaPozycjaZamowienia["zamowienie"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pzm_zmw_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_pozycje_zamowien.pzm_zmw_id IN (SELECT zmw_id FROM slk_zamowienia WHERE zmw_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPozycjaZamowienia["towar"])) {
				$parentCriteria = $criteriaPozycjaZamowienia["towar"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pzm_twr_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_pozycje_zamowien.pzm_twr_id IN (SELECT twr_id FROM slk_towary WHERE twr_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPozycjaZamowienia["wydanie"])) {
				$parentCriteria = $criteriaPozycjaZamowienia["wydanie"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pzm_wdn_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_pozycje_zamowien.pzm_wdn_id IN (SELECT wdn_id FROM slk_wydania WHERE wdn_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT slk_pozycje_zamowien.pzm_id, slk_pozycje_zamowien.pzm_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_ilosc', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_ilosc pzm_ilosc";
			} else {
				if ($defaultOrderColumn == "pzm_ilosc") {
					$orderColumnNotDisplayed = " slk_pozycje_zamowien.pzm_ilosc ";
				}
			}
			if (P('show_pdf_cena_netto', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_cena_netto pzm_cena_netto";
			} else {
				if ($defaultOrderColumn == "pzm_cena_netto") {
					$orderColumnNotDisplayed = " slk_pozycje_zamowien.pzm_cena_netto ";
				}
			}
			if (P('show_pdf_cena_brutto', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_cena_brutto pzm_cena_brutto";
			} else {
				if ($defaultOrderColumn == "pzm_cena_brutto") {
					$orderColumnNotDisplayed = " slk_pozycje_zamowien.pzm_cena_brutto ";
				}
			}
			if (class_exists('sealock\virgoZamowienie') && P('show_pdf_zamowienie', "1") != "0") { // */ && !in_array("zmw", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_zmw_id as pzm_zmw_id ";
				$queryString = $queryString . ", slk_zamowienia_parent.zmw_virgo_title as `zamowienie` ";
			} else {
				if ($defaultOrderColumn == "zamowienie") {
					$orderColumnNotDisplayed = " slk_zamowienia_parent.zmw_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoTowar') && P('show_pdf_towar', "1") != "0") { // */ && !in_array("twr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_twr_id as pzm_twr_id ";
				$queryString = $queryString . ", slk_towary_parent.twr_virgo_title as `towar` ";
			} else {
				if ($defaultOrderColumn == "towar") {
					$orderColumnNotDisplayed = " slk_towary_parent.twr_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoWydanie') && P('show_pdf_wydanie', "1") != "0") { // */ && !in_array("wdn", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_wdn_id as pzm_wdn_id ";
				$queryString = $queryString . ", slk_wydania_parent.wdn_virgo_title as `wydanie` ";
			} else {
				if ($defaultOrderColumn == "wydanie") {
					$orderColumnNotDisplayed = " slk_wydania_parent.wdn_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_pozycje_zamowien ";
			if (class_exists('sealock\virgoZamowienie')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_zamowienia AS slk_zamowienia_parent ON (slk_pozycje_zamowien.pzm_zmw_id = slk_zamowienia_parent.zmw_id) ";
			}
			if (class_exists('sealock\virgoTowar')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_towary AS slk_towary_parent ON (slk_pozycje_zamowien.pzm_twr_id = slk_towary_parent.twr_id) ";
			}
			if (class_exists('sealock\virgoWydanie')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_wydania AS slk_wydania_parent ON (slk_pozycje_zamowien.pzm_wdn_id = slk_wydania_parent.wdn_id) ";
			}

		$resultsPozycjaZamowienia = $resultPozycjaZamowienia->select(
			'', 
			'all', 
			$resultPozycjaZamowienia->getOrderColumn(), 
			$resultPozycjaZamowienia->getOrderMode(), 
			$whereClausePozycjaZamowienia,
			$queryString);
		
		foreach ($resultsPozycjaZamowienia as $resultPozycjaZamowienia) {

			if (P('show_pdf_ilosc', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPozycjaZamowienia['pzm_ilosc'])) + 6;
				if ($tmpLen > $minWidth['ilo\u015B\u0107']) {
					$minWidth['ilo\u015B\u0107'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_cena_netto', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPozycjaZamowienia['pzm_cena_netto'])) + 6;
				if ($tmpLen > $minWidth['cena netto']) {
					$minWidth['cena netto'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_cena_brutto', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPozycjaZamowienia['pzm_cena_brutto'])) + 6;
				if ($tmpLen > $minWidth['cena brutto']) {
					$minWidth['cena brutto'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_zamowienie', "1") == "1") {
			$parentValue = trim(virgoZamowienie::lookup($resultPozycjaZamowienia['pzmzmw__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['zam\u00F3wienie $relation.name']) {
					$minWidth['zam\u00F3wienie $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_towar', "1") == "1") {
			$parentValue = trim(virgoTowar::lookup($resultPozycjaZamowienia['pzmtwr__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['towar $relation.name']) {
					$minWidth['towar $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_wydanie', "1") == "1") {
			$parentValue = trim(virgoWydanie::lookup($resultPozycjaZamowienia['pzmwdn__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['wydanie $relation.name']) {
					$minWidth['wydanie $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaPozycjaZamowienia = $resultPozycjaZamowienia->getCriteria();
		if (is_null($criteriaPozycjaZamowienia) || sizeof($criteriaPozycjaZamowienia) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																																									if (P('show_pdf_ilosc', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['ilo\u015B\u0107'], $colHeight, T('ILOSC'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_cena_netto', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['cena netto'], $colHeight, T('CENA_NETTO'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_cena_brutto', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['cena brutto'], $colHeight, T('CENA_BRUTTO'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_zamowienie', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['zam\u00F3wienie $relation.name'], $colHeight, T('ZAMOWIENIE') . ' ' . T(''), 'T', 'C', 0, 0); 
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
			if (P('show_pdf_wydanie', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['wydanie $relation.name'], $colHeight, T('WYDANIE') . ' ' . T(''), 'T', 'C', 0, 0); 
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
		foreach ($resultsPozycjaZamowienia as $resultPozycjaZamowienia) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_ilosc', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['ilo\u015B\u0107'], $colHeight, '' . number_format($resultPozycjaZamowienia['pzm_ilosc'], 2, ',', ' '), 'T', 'R', 0, 0);
				if (P('show_pdf_ilosc', "1") == "2") {
										if (!is_null($resultPozycjaZamowienia['pzm_ilosc'])) {
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
										if (!is_null($resultPozycjaZamowienia['pzm_ilosc'])) {
						$tmpSum = (float)$sums["ilosc"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPozycjaZamowienia['pzm_ilosc'];
						}
						$sums["ilosc"] = $tmpSum;
					}
				}
				if (P('show_pdf_ilosc', "1") == "4") {
										if (!is_null($resultPozycjaZamowienia['pzm_ilosc'])) {
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
							$tmpSum = $tmpSum + $resultPozycjaZamowienia['pzm_ilosc'];
						}
						$avgSums["ilosc"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_cena_netto', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['cena netto'], $colHeight, '' . number_format($resultPozycjaZamowienia['pzm_cena_netto'], 2, ',', ' '), 'T', 'R', 0, 0);
				if (P('show_pdf_cena_netto', "1") == "2") {
										if (!is_null($resultPozycjaZamowienia['pzm_cena_netto'])) {
						$tmpCount = (float)$counts["cena_netto"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["cena_netto"] = $tmpCount;
					}
				}
				if (P('show_pdf_cena_netto', "1") == "3") {
										if (!is_null($resultPozycjaZamowienia['pzm_cena_netto'])) {
						$tmpSum = (float)$sums["cena_netto"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPozycjaZamowienia['pzm_cena_netto'];
						}
						$sums["cena_netto"] = $tmpSum;
					}
				}
				if (P('show_pdf_cena_netto', "1") == "4") {
										if (!is_null($resultPozycjaZamowienia['pzm_cena_netto'])) {
						$tmpCount = (float)$avgCounts["cena_netto"];
						$tmpSum = (float)$avgSums["cena_netto"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["cena_netto"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPozycjaZamowienia['pzm_cena_netto'];
						}
						$avgSums["cena_netto"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_cena_brutto', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['cena brutto'], $colHeight, '' . number_format($resultPozycjaZamowienia['pzm_cena_brutto'], 2, ',', ' '), 'T', 'R', 0, 0);
				if (P('show_pdf_cena_brutto', "1") == "2") {
										if (!is_null($resultPozycjaZamowienia['pzm_cena_brutto'])) {
						$tmpCount = (float)$counts["cena_brutto"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["cena_brutto"] = $tmpCount;
					}
				}
				if (P('show_pdf_cena_brutto', "1") == "3") {
										if (!is_null($resultPozycjaZamowienia['pzm_cena_brutto'])) {
						$tmpSum = (float)$sums["cena_brutto"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPozycjaZamowienia['pzm_cena_brutto'];
						}
						$sums["cena_brutto"] = $tmpSum;
					}
				}
				if (P('show_pdf_cena_brutto', "1") == "4") {
										if (!is_null($resultPozycjaZamowienia['pzm_cena_brutto'])) {
						$tmpCount = (float)$avgCounts["cena_brutto"];
						$tmpSum = (float)$avgSums["cena_brutto"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["cena_brutto"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPozycjaZamowienia['pzm_cena_brutto'];
						}
						$avgSums["cena_brutto"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_zamowienie', "1") == "1") {
			$parentValue = virgoZamowienie::lookup($resultPozycjaZamowienia['pzm_zmw_id']);
			$tmpLn = $pdf->MultiCell($minWidth['zam\u00F3wienie $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_towar', "1") == "1") {
			$parentValue = virgoTowar::lookup($resultPozycjaZamowienia['pzm_twr_id']);
			$tmpLn = $pdf->MultiCell($minWidth['towar $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_wydanie', "1") == "1") {
			$parentValue = virgoWydanie::lookup($resultPozycjaZamowienia['pzm_wdn_id']);
			$tmpLn = $pdf->MultiCell($minWidth['wydanie $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
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
			if (P('show_pdf_cena_netto', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['cena netto'];
				if (P('show_pdf_cena_netto', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["cena_netto"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_cena_brutto', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['cena brutto'];
				if (P('show_pdf_cena_brutto', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["cena_brutto"];
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
			if (P('show_pdf_cena_netto', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['cena netto'];
				if (P('show_pdf_cena_netto', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["cena_netto"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_cena_brutto', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['cena brutto'];
				if (P('show_pdf_cena_brutto', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["cena_brutto"], 2, ',', ' ');
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
			if (P('show_pdf_cena_netto', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['cena netto'];
				if (P('show_pdf_cena_netto', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["cena_netto"] == 0 ? "-" : $avgSums["cena_netto"] / $avgCounts["cena_netto"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_cena_brutto', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['cena brutto'];
				if (P('show_pdf_cena_brutto', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["cena_brutto"] == 0 ? "-" : $avgSums["cena_brutto"] / $avgCounts["cena_brutto"]);
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
				$reportTitle = T('POZYCJE_ZAMOWIEN');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultPozycjaZamowienia = new virgoPozycjaZamowienia();
			$whereClausePozycjaZamowienia = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_ilosc', "1") != "0") {
					$data = $data . $stringDelimeter .'Ilość' . $stringDelimeter . $separator;
				}
				if (P('show_export_cena_netto', "1") != "0") {
					$data = $data . $stringDelimeter .'Cena netto' . $stringDelimeter . $separator;
				}
				if (P('show_export_cena_brutto', "1") != "0") {
					$data = $data . $stringDelimeter .'Cena brutto' . $stringDelimeter . $separator;
				}
				if (P('show_export_zamowienie', "1") != "0") {
					$data = $data . $stringDelimeter . 'Zamówienie ' . $stringDelimeter . $separator;
				}
				if (P('show_export_towar', "1") != "0") {
					$data = $data . $stringDelimeter . 'Towar ' . $stringDelimeter . $separator;
				}
				if (P('show_export_wydanie', "1") != "0") {
					$data = $data . $stringDelimeter . 'Wydanie ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_pozycje_zamowien.pzm_id, slk_pozycje_zamowien.pzm_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_ilosc', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_ilosc pzm_ilosc";
			} else {
				if ($defaultOrderColumn == "pzm_ilosc") {
					$orderColumnNotDisplayed = " slk_pozycje_zamowien.pzm_ilosc ";
				}
			}
			if (P('show_export_cena_netto', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_cena_netto pzm_cena_netto";
			} else {
				if ($defaultOrderColumn == "pzm_cena_netto") {
					$orderColumnNotDisplayed = " slk_pozycje_zamowien.pzm_cena_netto ";
				}
			}
			if (P('show_export_cena_brutto', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_cena_brutto pzm_cena_brutto";
			} else {
				if ($defaultOrderColumn == "pzm_cena_brutto") {
					$orderColumnNotDisplayed = " slk_pozycje_zamowien.pzm_cena_brutto ";
				}
			}
			if (class_exists('sealock\virgoZamowienie') && P('show_export_zamowienie', "1") != "0") { // */ && !in_array("zmw", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_zmw_id as pzm_zmw_id ";
				$queryString = $queryString . ", slk_zamowienia_parent.zmw_virgo_title as `zamowienie` ";
			} else {
				if ($defaultOrderColumn == "zamowienie") {
					$orderColumnNotDisplayed = " slk_zamowienia_parent.zmw_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoTowar') && P('show_export_towar', "1") != "0") { // */ && !in_array("twr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_twr_id as pzm_twr_id ";
				$queryString = $queryString . ", slk_towary_parent.twr_virgo_title as `towar` ";
			} else {
				if ($defaultOrderColumn == "towar") {
					$orderColumnNotDisplayed = " slk_towary_parent.twr_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoWydanie') && P('show_export_wydanie', "1") != "0") { // */ && !in_array("wdn", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_wdn_id as pzm_wdn_id ";
				$queryString = $queryString . ", slk_wydania_parent.wdn_virgo_title as `wydanie` ";
			} else {
				if ($defaultOrderColumn == "wydanie") {
					$orderColumnNotDisplayed = " slk_wydania_parent.wdn_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_pozycje_zamowien ";
			if (class_exists('sealock\virgoZamowienie')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_zamowienia AS slk_zamowienia_parent ON (slk_pozycje_zamowien.pzm_zmw_id = slk_zamowienia_parent.zmw_id) ";
			}
			if (class_exists('sealock\virgoTowar')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_towary AS slk_towary_parent ON (slk_pozycje_zamowien.pzm_twr_id = slk_towary_parent.twr_id) ";
			}
			if (class_exists('sealock\virgoWydanie')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_wydania AS slk_wydania_parent ON (slk_pozycje_zamowien.pzm_wdn_id = slk_wydania_parent.wdn_id) ";
			}

			$resultsPozycjaZamowienia = $resultPozycjaZamowienia->select(
				'', 
				'all', 
				$resultPozycjaZamowienia->getOrderColumn(), 
				$resultPozycjaZamowienia->getOrderMode(), 
				$whereClausePozycjaZamowienia,
				$queryString);
			foreach ($resultsPozycjaZamowienia as $resultPozycjaZamowienia) {
				if (P('show_export_ilosc', "1") != "0") {
			$data = $data . $resultPozycjaZamowienia['pzm_ilosc'] . $separator;
				}
				if (P('show_export_cena_netto', "1") != "0") {
			$data = $data . $resultPozycjaZamowienia['pzm_cena_netto'] . $separator;
				}
				if (P('show_export_cena_brutto', "1") != "0") {
			$data = $data . $resultPozycjaZamowienia['pzm_cena_brutto'] . $separator;
				}
				if (P('show_export_zamowienie', "1") != "0") {
					$parentValue = virgoZamowienie::lookup($resultPozycjaZamowienia['pzm_zmw_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_towar', "1") != "0") {
					$parentValue = virgoTowar::lookup($resultPozycjaZamowienia['pzm_twr_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_wydanie', "1") != "0") {
					$parentValue = virgoWydanie::lookup($resultPozycjaZamowienia['pzm_wdn_id']);
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
				$reportTitle = T('POZYCJE_ZAMOWIEN');
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
			$resultPozycjaZamowienia = new virgoPozycjaZamowienia();
			$whereClausePozycjaZamowienia = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . ' AND ' . $parentContextInfo['condition'];
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
				if (P('show_export_cena_netto', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Cena netto');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_cena_brutto', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Cena brutto');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_zamowienie', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Zamówienie ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoZamowienie::getVirgoList();
					$formulaZamowienie = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaZamowienie != "") {
							$formulaZamowienie = $formulaZamowienie . ',';
						}
						$formulaZamowienie = $formulaZamowienie . $key;
					}
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
				if (P('show_export_wydanie', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Wydanie ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoWydanie::getVirgoList();
					$formulaWydanie = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaWydanie != "") {
							$formulaWydanie = $formulaWydanie . ',';
						}
						$formulaWydanie = $formulaWydanie . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_pozycje_zamowien.pzm_id, slk_pozycje_zamowien.pzm_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_ilosc', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_ilosc pzm_ilosc";
			} else {
				if ($defaultOrderColumn == "pzm_ilosc") {
					$orderColumnNotDisplayed = " slk_pozycje_zamowien.pzm_ilosc ";
				}
			}
			if (P('show_export_cena_netto', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_cena_netto pzm_cena_netto";
			} else {
				if ($defaultOrderColumn == "pzm_cena_netto") {
					$orderColumnNotDisplayed = " slk_pozycje_zamowien.pzm_cena_netto ";
				}
			}
			if (P('show_export_cena_brutto', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_cena_brutto pzm_cena_brutto";
			} else {
				if ($defaultOrderColumn == "pzm_cena_brutto") {
					$orderColumnNotDisplayed = " slk_pozycje_zamowien.pzm_cena_brutto ";
				}
			}
			if (class_exists('sealock\virgoZamowienie') && P('show_export_zamowienie', "1") != "0") { // */ && !in_array("zmw", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_zmw_id as pzm_zmw_id ";
				$queryString = $queryString . ", slk_zamowienia_parent.zmw_virgo_title as `zamowienie` ";
			} else {
				if ($defaultOrderColumn == "zamowienie") {
					$orderColumnNotDisplayed = " slk_zamowienia_parent.zmw_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoTowar') && P('show_export_towar', "1") != "0") { // */ && !in_array("twr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_twr_id as pzm_twr_id ";
				$queryString = $queryString . ", slk_towary_parent.twr_virgo_title as `towar` ";
			} else {
				if ($defaultOrderColumn == "towar") {
					$orderColumnNotDisplayed = " slk_towary_parent.twr_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoWydanie') && P('show_export_wydanie', "1") != "0") { // */ && !in_array("wdn", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_zamowien.pzm_wdn_id as pzm_wdn_id ";
				$queryString = $queryString . ", slk_wydania_parent.wdn_virgo_title as `wydanie` ";
			} else {
				if ($defaultOrderColumn == "wydanie") {
					$orderColumnNotDisplayed = " slk_wydania_parent.wdn_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_pozycje_zamowien ";
			if (class_exists('sealock\virgoZamowienie')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_zamowienia AS slk_zamowienia_parent ON (slk_pozycje_zamowien.pzm_zmw_id = slk_zamowienia_parent.zmw_id) ";
			}
			if (class_exists('sealock\virgoTowar')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_towary AS slk_towary_parent ON (slk_pozycje_zamowien.pzm_twr_id = slk_towary_parent.twr_id) ";
			}
			if (class_exists('sealock\virgoWydanie')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_wydania AS slk_wydania_parent ON (slk_pozycje_zamowien.pzm_wdn_id = slk_wydania_parent.wdn_id) ";
			}

			$resultsPozycjaZamowienia = $resultPozycjaZamowienia->select(
				'', 
				'all', 
				$resultPozycjaZamowienia->getOrderColumn(), 
				$resultPozycjaZamowienia->getOrderMode(), 
				$whereClausePozycjaZamowienia,
				$queryString);
			$index = 1;
			foreach ($resultsPozycjaZamowienia as $resultPozycjaZamowienia) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultPozycjaZamowienia['pzm_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_ilosc', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPozycjaZamowienia['pzm_ilosc'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_cena_netto', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPozycjaZamowienia['pzm_cena_netto'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_cena_brutto', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPozycjaZamowienia['pzm_cena_brutto'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_zamowienie', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoZamowienie::lookup($resultPozycjaZamowienia['pzm_zmw_id']);
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
					$objValidation->setFormula1('"' . $formulaZamowienie . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
				if (P('show_export_towar', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoTowar::lookup($resultPozycjaZamowienia['pzm_twr_id']);
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
				if (P('show_export_wydanie', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoWydanie::lookup($resultPozycjaZamowienia['pzm_wdn_id']);
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
					$objValidation->setFormula1('"' . $formulaWydanie . '"');
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
					$propertyColumnHash['ilo\u015B\u0107'] = 'pzm_ilosc';
					$propertyColumnHash['ilosc'] = 'pzm_ilosc';
					$propertyColumnHash['cena netto'] = 'pzm_cena_netto';
					$propertyColumnHash['cena_netto'] = 'pzm_cena_netto';
					$propertyColumnHash['cena brutto'] = 'pzm_cena_brutto';
					$propertyColumnHash['cena_brutto'] = 'pzm_cena_brutto';
					$propertyClassHash['zam\u00F3wienie'] = 'Zamowienie';
					$propertyClassHash['zamowienie'] = 'Zamowienie';
					$propertyColumnHash['zam\u00F3wienie'] = 'pzm_zmw_id';
					$propertyColumnHash['zamowienie'] = 'pzm_zmw_id';
					$propertyClassHash['towar'] = 'Towar';
					$propertyClassHash['towar'] = 'Towar';
					$propertyColumnHash['towar'] = 'pzm_twr_id';
					$propertyColumnHash['towar'] = 'pzm_twr_id';
					$propertyClassHash['wydanie'] = 'Wydanie';
					$propertyClassHash['wydanie'] = 'Wydanie';
					$propertyColumnHash['wydanie'] = 'pzm_wdn_id';
					$propertyColumnHash['wydanie'] = 'pzm_wdn_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importPozycjaZamowienia = new virgoPozycjaZamowienia();
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
										L(T('PROPERTY_NOT_FOUND', T('POZYCJA_ZAMOWIENIA'), $columns[$index]), '', 'ERROR');
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
										$importPozycjaZamowienia->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_zamowienie');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoZamowienie::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoZamowienie::token2Id($tmpToken);
	}
	$importPozycjaZamowienia->setZmwId($defaultValue);
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
	$importPozycjaZamowienia->setTwrId($defaultValue);
}
$defaultValue = P('import_default_value_wydanie');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoWydanie::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoWydanie::token2Id($tmpToken);
	}
	$importPozycjaZamowienia->setWdnId($defaultValue);
}
							$errorMessage = $importPozycjaZamowienia->store();
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
		




		static function portletActionVirgoSetZamowienie() {
			$this->loadFromDB();
			$parentId = R('pzm_Zamowienie_id_' . $_SESSION['current_portlet_object_id']);
			$this->setZmwId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetTowar() {
			$this->loadFromDB();
			$parentId = R('pzm_Towar_id_' . $_SESSION['current_portlet_object_id']);
			$this->setTwrId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetWydanie() {
			$this->loadFromDB();
			$parentId = R('pzm_Wydanie_id_' . $_SESSION['current_portlet_object_id']);
			$this->setWdnId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}

		static function portletActionAddZamowienie() {
			self::setDisplayMode("ADD_NEW_PARENT_ZAMOWIENIE");
		}

		static function portletActionStoreNewZamowienie() {
			$id = -1;
			if (virgoZamowienie::portletActionStore(true, $id) == -1) {
				self::setDisplayMode("ADD_NEW_PARENT_ZAMOWIENIE");
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			} else {
				$tmpId = self::loadIdFromRequest();
				$_POST['pzm_zamowienie_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
				self::portletActionBackFromParent();
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
				$_POST['pzm_towar_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
				self::portletActionBackFromParent();
			}
		}
		static function portletActionAddWydanie() {
			self::setDisplayMode("ADD_NEW_PARENT_WYDANIE");
		}

		static function portletActionStoreNewWydanie() {
			$id = -1;
			if (virgoWydanie::portletActionStore(true, $id) == -1) {
				self::setDisplayMode("ADD_NEW_PARENT_WYDANIE");
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			} else {
				$tmpId = self::loadIdFromRequest();
				$_POST['pzm_wydanie_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
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
CREATE TABLE IF NOT EXISTS `slk_pozycje_zamowien` (
  `pzm_id` bigint(20) unsigned NOT NULL auto_increment,
  `pzm_virgo_state` varchar(50) default NULL,
  `pzm_virgo_title` varchar(255) default NULL,
	`pzm_zmw_id` int(11) default NULL,
	`pzm_twr_id` int(11) default NULL,
	`pzm_wdn_id` int(11) default NULL,
  `pzm_ilosc` decimal(10,2),  
  `pzm_cena_netto` decimal(10,2),  
  `pzm_cena_brutto` decimal(10,2),  
  `pzm_date_created` datetime NOT NULL,
  `pzm_date_modified` datetime default NULL,
  `pzm_usr_created_id` int(11) NOT NULL,
  `pzm_usr_modified_id` int(11) default NULL,
  KEY `pzm_zmw_fk` (`pzm_zmw_id`),
  KEY `pzm_twr_fk` (`pzm_twr_id`),
  KEY `pzm_wdn_fk` (`pzm_wdn_id`),
  PRIMARY KEY  (`pzm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/pozycja_zamowienia.sql 
INSERT INTO `slk_pozycje_zamowien` (`pzm_virgo_title`, `pzm_ilosc`, `pzm_cena_netto`, `pzm_cena_brutto`) 
VALUES (title, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably slk_pozycje_zamowien table already exists.", '', 'FATAL');
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
			return "pzm";
		}
		
		static function getPlural() {
			return "pozycje_zamowien";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoZamowienie";
			$ret[] = "virgoTowar";
			$ret[] = "virgoWydanie";
			return $ret;
		}

		static function getChildren() {
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'slk_pozycje_zamowien'));
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
			$virgoVersion = virgoPozycjaZamowienia::getVirgoVersion();
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
	
	

