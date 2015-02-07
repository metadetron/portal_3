<?php
/**
* Module Rodzaj dokumentu
* @package Sealock
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace sealock;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoGrupaDokumentow'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoDokumentKsiegowy'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoRodzajDokumentu {

		 private  $rdk_id = null;
		 private  $rdk_nazwa = null;

		 private  $rdk_symbol = null;

		 private  $rdk_zwiekszajacy = null;

		 private  $rdk_wlasny = null;

		 private  $rdk_wewnetrzny = null;

		 private  $rdk_korekta = null;

		 private  $rdk_zastepczy = null;

		 private  $rdk_ostatni_numer = null;

		 private  $rdk_numeracja_rok = null;

		 private  $rdk_gdk_id = null;

		 private   $rdk_date_created = null;
		 private   $rdk_usr_created_id = null;
		 private   $rdk_date_modified = null;
		 private   $rdk_usr_modified_id = null;
		 private   $rdk_virgo_title = null;
		
		 private   $internalLog = null;		
				
		 private  function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		public function isDeletedVirgo() {
			return $this->rdk_virgo_deleted;
		}

		static public function createGuiAware() {
			$ret = new virgoRodzajDokumentu();
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
        	$this->rdk_id = null;
		    $this->rdk_date_created = null;
		    $this->rdk_usr_created_id = null;
		    $this->rdk_date_modified = null;
		    $this->rdk_usr_modified_id = null;
		    $this->rdk_virgo_title = null;
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
			return $this->rdk_id;
		}

		function getNazwa() {
			return $this->rdk_nazwa;
		}
		
		 private  function setNazwa($val) {
			$this->rdk_nazwa = $val;
		}
		function getSymbol() {
			return $this->rdk_symbol;
		}
		
		 private  function setSymbol($val) {
			$this->rdk_symbol = $val;
		}
		function getZwiekszajacy() {
			return $this->rdk_zwiekszajacy;
		}
		
		 private  function setZwiekszajacy($val) {
			$this->rdk_zwiekszajacy = $val;
		}
		function getWlasny() {
			return $this->rdk_wlasny;
		}
		
		 private  function setWlasny($val) {
			$this->rdk_wlasny = $val;
		}
		function getWewnetrzny() {
			return $this->rdk_wewnetrzny;
		}
		
		 private  function setWewnetrzny($val) {
			$this->rdk_wewnetrzny = $val;
		}
		function getKorekta() {
			return $this->rdk_korekta;
		}
		
		 private  function setKorekta($val) {
			$this->rdk_korekta = $val;
		}
		function getZastepczy() {
			return $this->rdk_zastepczy;
		}
		
		 private  function setZastepczy($val) {
			$this->rdk_zastepczy = $val;
		}
		function getOstatniNumer() {
			return $this->rdk_ostatni_numer;
		}
		
		 private  function setOstatniNumer($val) {
			$this->rdk_ostatni_numer = $val;
		}
		function getNumeracjaRok() {
			return $this->rdk_numeracja_rok;
		}
		
		 private  function setNumeracjaRok($val) {
			$this->rdk_numeracja_rok = $val;
		}

		function getGrupaDokumentowId() {
			return $this->rdk_gdk_id;
		}
		
		 private  function setGrupaDokumentowId($val) {
			$this->rdk_gdk_id = $val;
		}

		function getDateCreated() {
			return $this->rdk_date_created;
		}
		function getUsrCreatedId() {
			return $this->rdk_usr_created_id;
		}
		function getDateModified() {
			return $this->rdk_date_modified;
		}
		function getUsrModifiedId() {
			return $this->rdk_usr_modified_id;
		}


		function getGdkId() {
			return $this->getGrupaDokumentowId();
		}
		
		 private  function setGdkId($val) {
			$this->setGrupaDokumentowId($val);
		}

		function loadRecordFromRequest($rowId) {
			$this->rdk_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('rdk_nazwa_' . $this->rdk_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->rdk_nazwa = null;
		} else {
			$this->rdk_nazwa = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('rdk_symbol_' . $this->rdk_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->rdk_symbol = null;
		} else {
			$this->rdk_symbol = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('rdk_zwiekszajacy_' . $this->rdk_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->rdk_zwiekszajacy = null;
		} else {
			$this->rdk_zwiekszajacy = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('rdk_wlasny_' . $this->rdk_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->rdk_wlasny = null;
		} else {
			$this->rdk_wlasny = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('rdk_wewnetrzny_' . $this->rdk_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->rdk_wewnetrzny = null;
		} else {
			$this->rdk_wewnetrzny = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('rdk_korekta_' . $this->rdk_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->rdk_korekta = null;
		} else {
			$this->rdk_korekta = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('rdk_zastepczy_' . $this->rdk_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->rdk_zastepczy = null;
		} else {
			$this->rdk_zastepczy = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('rdk_ostatniNumer_' . $this->rdk_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->rdk_ostatni_numer = null;
		} else {
			$this->rdk_ostatni_numer = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('rdk_numeracjaRok_' . $this->rdk_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->rdk_numeracja_rok = null;
		} else {
			$this->rdk_numeracja_rok = $tmpValue;
		}
	}
			$this->rdk_gdk_id = strval(R('rdk_grupaDokumentow_' . $this->rdk_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('rdk_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaRodzajDokumentu = array();	
			$criteriaFieldRodzajDokumentu = array();	
			$isNullRodzajDokumentu = R('virgo_search_nazwa_is_null');
			
			$criteriaFieldRodzajDokumentu["is_null"] = 0;
			if ($isNullRodzajDokumentu == "not_null") {
				$criteriaFieldRodzajDokumentu["is_null"] = 1;
			} elseif ($isNullRodzajDokumentu == "null") {
				$criteriaFieldRodzajDokumentu["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_nazwa');

//			if ($isSet) {
			$criteriaFieldRodzajDokumentu["value"] = $dataTypeCriteria;
//			}
			$criteriaRodzajDokumentu["nazwa"] = $criteriaFieldRodzajDokumentu;
			$criteriaFieldRodzajDokumentu = array();	
			$isNullRodzajDokumentu = R('virgo_search_symbol_is_null');
			
			$criteriaFieldRodzajDokumentu["is_null"] = 0;
			if ($isNullRodzajDokumentu == "not_null") {
				$criteriaFieldRodzajDokumentu["is_null"] = 1;
			} elseif ($isNullRodzajDokumentu == "null") {
				$criteriaFieldRodzajDokumentu["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_symbol');

//			if ($isSet) {
			$criteriaFieldRodzajDokumentu["value"] = $dataTypeCriteria;
//			}
			$criteriaRodzajDokumentu["symbol"] = $criteriaFieldRodzajDokumentu;
			$criteriaFieldRodzajDokumentu = array();	
			$isNullRodzajDokumentu = R('virgo_search_zwiekszajacy_is_null');
			
			$criteriaFieldRodzajDokumentu["is_null"] = 0;
			if ($isNullRodzajDokumentu == "not_null") {
				$criteriaFieldRodzajDokumentu["is_null"] = 1;
			} elseif ($isNullRodzajDokumentu == "null") {
				$criteriaFieldRodzajDokumentu["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_zwiekszajacy');

//			if ($isSet) {
			$criteriaFieldRodzajDokumentu["value"] = $dataTypeCriteria;
//			}
			$criteriaRodzajDokumentu["zwiekszajacy"] = $criteriaFieldRodzajDokumentu;
			$criteriaFieldRodzajDokumentu = array();	
			$isNullRodzajDokumentu = R('virgo_search_wlasny_is_null');
			
			$criteriaFieldRodzajDokumentu["is_null"] = 0;
			if ($isNullRodzajDokumentu == "not_null") {
				$criteriaFieldRodzajDokumentu["is_null"] = 1;
			} elseif ($isNullRodzajDokumentu == "null") {
				$criteriaFieldRodzajDokumentu["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_wlasny');

//			if ($isSet) {
			$criteriaFieldRodzajDokumentu["value"] = $dataTypeCriteria;
//			}
			$criteriaRodzajDokumentu["wlasny"] = $criteriaFieldRodzajDokumentu;
			$criteriaFieldRodzajDokumentu = array();	
			$isNullRodzajDokumentu = R('virgo_search_wewnetrzny_is_null');
			
			$criteriaFieldRodzajDokumentu["is_null"] = 0;
			if ($isNullRodzajDokumentu == "not_null") {
				$criteriaFieldRodzajDokumentu["is_null"] = 1;
			} elseif ($isNullRodzajDokumentu == "null") {
				$criteriaFieldRodzajDokumentu["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_wewnetrzny');

//			if ($isSet) {
			$criteriaFieldRodzajDokumentu["value"] = $dataTypeCriteria;
//			}
			$criteriaRodzajDokumentu["wewnetrzny"] = $criteriaFieldRodzajDokumentu;
			$criteriaFieldRodzajDokumentu = array();	
			$isNullRodzajDokumentu = R('virgo_search_korekta_is_null');
			
			$criteriaFieldRodzajDokumentu["is_null"] = 0;
			if ($isNullRodzajDokumentu == "not_null") {
				$criteriaFieldRodzajDokumentu["is_null"] = 1;
			} elseif ($isNullRodzajDokumentu == "null") {
				$criteriaFieldRodzajDokumentu["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_korekta');

//			if ($isSet) {
			$criteriaFieldRodzajDokumentu["value"] = $dataTypeCriteria;
//			}
			$criteriaRodzajDokumentu["korekta"] = $criteriaFieldRodzajDokumentu;
			$criteriaFieldRodzajDokumentu = array();	
			$isNullRodzajDokumentu = R('virgo_search_zastepczy_is_null');
			
			$criteriaFieldRodzajDokumentu["is_null"] = 0;
			if ($isNullRodzajDokumentu == "not_null") {
				$criteriaFieldRodzajDokumentu["is_null"] = 1;
			} elseif ($isNullRodzajDokumentu == "null") {
				$criteriaFieldRodzajDokumentu["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_zastepczy');

//			if ($isSet) {
			$criteriaFieldRodzajDokumentu["value"] = $dataTypeCriteria;
//			}
			$criteriaRodzajDokumentu["zastepczy"] = $criteriaFieldRodzajDokumentu;
			$criteriaFieldRodzajDokumentu = array();	
			$isNullRodzajDokumentu = R('virgo_search_ostatniNumer_is_null');
			
			$criteriaFieldRodzajDokumentu["is_null"] = 0;
			if ($isNullRodzajDokumentu == "not_null") {
				$criteriaFieldRodzajDokumentu["is_null"] = 1;
			} elseif ($isNullRodzajDokumentu == "null") {
				$criteriaFieldRodzajDokumentu["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_ostatniNumer_from');
		$dataTypeCriteria["to"] = R('virgo_search_ostatniNumer_to');

//			if ($isSet) {
			$criteriaFieldRodzajDokumentu["value"] = $dataTypeCriteria;
//			}
			$criteriaRodzajDokumentu["ostatni_numer"] = $criteriaFieldRodzajDokumentu;
			$criteriaFieldRodzajDokumentu = array();	
			$isNullRodzajDokumentu = R('virgo_search_numeracjaRok_is_null');
			
			$criteriaFieldRodzajDokumentu["is_null"] = 0;
			if ($isNullRodzajDokumentu == "not_null") {
				$criteriaFieldRodzajDokumentu["is_null"] = 1;
			} elseif ($isNullRodzajDokumentu == "null") {
				$criteriaFieldRodzajDokumentu["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_numeracjaRok_from');
		$dataTypeCriteria["to"] = R('virgo_search_numeracjaRok_to');

//			if ($isSet) {
			$criteriaFieldRodzajDokumentu["value"] = $dataTypeCriteria;
//			}
			$criteriaRodzajDokumentu["numeracja_rok"] = $criteriaFieldRodzajDokumentu;
			$criteriaParent = array();	
			$isNull = R('virgo_search_grupaDokumentow_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_grupaDokumentow', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
			}
			$criteriaRodzajDokumentu["grupa_dokumentow"] = $criteriaParent;
			self::setCriteria($criteriaRodzajDokumentu);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_nazwa');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterNazwa', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterNazwa', null);
			}
			$tableFilter = R('virgo_filter_symbol');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterSymbol', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterSymbol', null);
			}
			$tableFilter = R('virgo_filter_zwiekszajacy');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterZwiekszajacy', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterZwiekszajacy', null);
			}
			$tableFilter = R('virgo_filter_wlasny');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterWlasny', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterWlasny', null);
			}
			$tableFilter = R('virgo_filter_wewnetrzny');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterWewnetrzny', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterWewnetrzny', null);
			}
			$tableFilter = R('virgo_filter_korekta');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterKorekta', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterKorekta', null);
			}
			$tableFilter = R('virgo_filter_zastepczy');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterZastepczy', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterZastepczy', null);
			}
			$tableFilter = R('virgo_filter_ostatni_numer');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterOstatniNumer', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterOstatniNumer', null);
			}
			$tableFilter = R('virgo_filter_numeracja_rok');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterNumeracjaRok', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterNumeracjaRok', null);
			}
			$parentFilter = R('virgo_filter_grupa_dokumentow');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterGrupaDokumentow', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterGrupaDokumentow', null);
			}
			$parentFilter = R('virgo_filter_title_grupa_dokumentow');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleGrupaDokumentow', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleGrupaDokumentow', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseRodzajDokumentu = ' 1 = 1 ';
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
				$eventColumn = "rdk_" . P('event_column');
				$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_grupa_dokumentow');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_rodzaje_dokumentow.rdk_gdk_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_rodzaje_dokumentow.rdk_gdk_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaRodzajDokumentu = self::getCriteria();
			if (isset($criteriaRodzajDokumentu["nazwa"])) {
				$fieldCriteriaNazwa = $criteriaRodzajDokumentu["nazwa"];
				if ($fieldCriteriaNazwa["is_null"] == 1) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_nazwa IS NOT NULL ';
				} elseif ($fieldCriteriaNazwa["is_null"] == 2) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_nazwa IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaNazwa["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_nazwa like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaRodzajDokumentu["symbol"])) {
				$fieldCriteriaSymbol = $criteriaRodzajDokumentu["symbol"];
				if ($fieldCriteriaSymbol["is_null"] == 1) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_symbol IS NOT NULL ';
				} elseif ($fieldCriteriaSymbol["is_null"] == 2) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_symbol IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaSymbol["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_symbol like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaRodzajDokumentu["zwiekszajacy"])) {
				$fieldCriteriaZwiekszajacy = $criteriaRodzajDokumentu["zwiekszajacy"];
				if ($fieldCriteriaZwiekszajacy["is_null"] == 1) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_zwiekszajacy IS NOT NULL ';
				} elseif ($fieldCriteriaZwiekszajacy["is_null"] == 2) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_zwiekszajacy IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaZwiekszajacy["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_zwiekszajacy = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaRodzajDokumentu["wlasny"])) {
				$fieldCriteriaWlasny = $criteriaRodzajDokumentu["wlasny"];
				if ($fieldCriteriaWlasny["is_null"] == 1) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_wlasny IS NOT NULL ';
				} elseif ($fieldCriteriaWlasny["is_null"] == 2) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_wlasny IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaWlasny["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_wlasny = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaRodzajDokumentu["wewnetrzny"])) {
				$fieldCriteriaWewnetrzny = $criteriaRodzajDokumentu["wewnetrzny"];
				if ($fieldCriteriaWewnetrzny["is_null"] == 1) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_wewnetrzny IS NOT NULL ';
				} elseif ($fieldCriteriaWewnetrzny["is_null"] == 2) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_wewnetrzny IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaWewnetrzny["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_wewnetrzny = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaRodzajDokumentu["korekta"])) {
				$fieldCriteriaKorekta = $criteriaRodzajDokumentu["korekta"];
				if ($fieldCriteriaKorekta["is_null"] == 1) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_korekta IS NOT NULL ';
				} elseif ($fieldCriteriaKorekta["is_null"] == 2) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_korekta IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaKorekta["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_korekta = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaRodzajDokumentu["zastepczy"])) {
				$fieldCriteriaZastepczy = $criteriaRodzajDokumentu["zastepczy"];
				if ($fieldCriteriaZastepczy["is_null"] == 1) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_zastepczy IS NOT NULL ';
				} elseif ($fieldCriteriaZastepczy["is_null"] == 2) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_zastepczy IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaZastepczy["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_zastepczy = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaRodzajDokumentu["ostatni_numer"])) {
				$fieldCriteriaOstatniNumer = $criteriaRodzajDokumentu["ostatni_numer"];
				if ($fieldCriteriaOstatniNumer["is_null"] == 1) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_ostatni_numer IS NOT NULL ';
				} elseif ($fieldCriteriaOstatniNumer["is_null"] == 2) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_ostatni_numer IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaOstatniNumer["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_ostatni_numer = ? ";
				} else {
					$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_ostatni_numer >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_ostatni_numer <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaRodzajDokumentu["numeracja_rok"])) {
				$fieldCriteriaNumeracjaRok = $criteriaRodzajDokumentu["numeracja_rok"];
				if ($fieldCriteriaNumeracjaRok["is_null"] == 1) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_numeracja_rok IS NOT NULL ';
				} elseif ($fieldCriteriaNumeracjaRok["is_null"] == 2) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_numeracja_rok IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaNumeracjaRok["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_numeracja_rok = ? ";
				} else {
					$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_numeracja_rok >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_numeracja_rok <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaRodzajDokumentu["grupa_dokumentow"])) {
				$parentCriteria = $criteriaRodzajDokumentu["grupa_dokumentow"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND rdk_gdk_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_gdk_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterNazwa', null);
				if (S($tableFilter)) {
					$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " AND rdk_nazwa LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterSymbol', null);
				if (S($tableFilter)) {
					$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " AND rdk_symbol LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterZwiekszajacy', null);
				if (S($tableFilter)) {
					$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " AND rdk_zwiekszajacy LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterWlasny', null);
				if (S($tableFilter)) {
					$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " AND rdk_wlasny LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterWewnetrzny', null);
				if (S($tableFilter)) {
					$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " AND rdk_wewnetrzny LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterKorekta', null);
				if (S($tableFilter)) {
					$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " AND rdk_korekta LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterZastepczy', null);
				if (S($tableFilter)) {
					$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " AND rdk_zastepczy LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterOstatniNumer', null);
				if (S($tableFilter)) {
					$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " AND rdk_ostatni_numer LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterNumeracjaRok', null);
				if (S($tableFilter)) {
					$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " AND rdk_numeracja_rok LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterGrupaDokumentow', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " AND rdk_gdk_id IS NULL ";
					} else {
						$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " AND rdk_gdk_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleGrupaDokumentow', null);
				if (S($parentFilter)) {
					$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " AND slk_grupy_dokumentow_parent.gdk_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClauseRodzajDokumentu;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseRodzajDokumentu = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT slk_rodzaje_dokumentow.rdk_id, slk_rodzaje_dokumentow.rdk_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_nazwa', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_nazwa rdk_nazwa";
			} else {
				if ($defaultOrderColumn == "rdk_nazwa") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_nazwa ";
				}
			}
			if (P('show_table_symbol', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_symbol rdk_symbol";
			} else {
				if ($defaultOrderColumn == "rdk_symbol") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_symbol ";
				}
			}
			if (P('show_table_zwiekszajacy', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_zwiekszajacy rdk_zwiekszajacy";
			} else {
				if ($defaultOrderColumn == "rdk_zwiekszajacy") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_zwiekszajacy ";
				}
			}
			if (P('show_table_wlasny', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_wlasny rdk_wlasny";
			} else {
				if ($defaultOrderColumn == "rdk_wlasny") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_wlasny ";
				}
			}
			if (P('show_table_wewnetrzny', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_wewnetrzny rdk_wewnetrzny";
			} else {
				if ($defaultOrderColumn == "rdk_wewnetrzny") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_wewnetrzny ";
				}
			}
			if (P('show_table_korekta', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_korekta rdk_korekta";
			} else {
				if ($defaultOrderColumn == "rdk_korekta") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_korekta ";
				}
			}
			if (P('show_table_zastepczy', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_zastepczy rdk_zastepczy";
			} else {
				if ($defaultOrderColumn == "rdk_zastepczy") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_zastepczy ";
				}
			}
			if (P('show_table_ostatni_numer', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_ostatni_numer rdk_ostatni_numer";
			} else {
				if ($defaultOrderColumn == "rdk_ostatni_numer") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_ostatni_numer ";
				}
			}
			if (P('show_table_numeracja_rok', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_numeracja_rok rdk_numeracja_rok";
			} else {
				if ($defaultOrderColumn == "rdk_numeracja_rok") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_numeracja_rok ";
				}
			}
			if (class_exists('sealock\virgoGrupaDokumentow') && P('show_table_grupa_dokumentow', "1") != "0") { // */ && !in_array("gdk", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_gdk_id as rdk_gdk_id ";
				$queryString = $queryString . ", slk_grupy_dokumentow_parent.gdk_virgo_title as `grupa_dokumentow` ";
			} else {
				if ($defaultOrderColumn == "grupa_dokumentow") {
					$orderColumnNotDisplayed = " slk_grupy_dokumentow_parent.gdk_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_rodzaje_dokumentow ";
			if (class_exists('sealock\virgoGrupaDokumentow')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_grupy_dokumentow AS slk_grupy_dokumentow_parent ON (slk_rodzaje_dokumentow.rdk_gdk_id = slk_grupy_dokumentow_parent.gdk_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseRodzajDokumentu, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseRodzajDokumentu,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM slk_rodzaje_dokumentow"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " rdk_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " rdk_usr_created_id = ? ";
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
				. "\n FROM slk_rodzaje_dokumentow"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as slk_rodzaje_dokumentow ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as slk_rodzaje_dokumentow ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, rdk_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " rdk_usr_created_id = ? ";
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
				$query = "SELECT COUNT(rdk_id) cnt FROM rodzaje_dokumentow";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as rodzaje_dokumentow ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as rodzaje_dokumentow ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoRodzajDokumentu();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM slk_rodzaje_dokumentow WHERE rdk_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->rdk_id = $row['rdk_id'];
$this->rdk_nazwa = $row['rdk_nazwa'];
$this->rdk_symbol = $row['rdk_symbol'];
$this->rdk_zwiekszajacy = $row['rdk_zwiekszajacy'];
$this->rdk_wlasny = $row['rdk_wlasny'];
$this->rdk_wewnetrzny = $row['rdk_wewnetrzny'];
$this->rdk_korekta = $row['rdk_korekta'];
$this->rdk_zastepczy = $row['rdk_zastepczy'];
$this->rdk_ostatni_numer = $row['rdk_ostatni_numer'];
$this->rdk_numeracja_rok = $row['rdk_numeracja_rok'];
						$this->rdk_gdk_id = $row['rdk_gdk_id'];
						if ($fetchUsernames) {
							if ($row['rdk_date_created']) {
								if ($row['rdk_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['rdk_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['rdk_date_modified']) {
								if ($row['rdk_usr_modified_id'] == $row['rdk_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['rdk_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['rdk_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->rdk_date_created = $row['rdk_date_created'];
						$this->rdk_usr_created_id = $fetchUsernames ? $createdBy : $row['rdk_usr_created_id'];
						$this->rdk_date_modified = $row['rdk_date_modified'];
						$this->rdk_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['rdk_usr_modified_id'];
						$this->rdk_virgo_title = $row['rdk_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE slk_rodzaje_dokumentow SET rdk_usr_created_id = {$userId} WHERE rdk_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->rdk_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoRodzajDokumentu::selectAllAsObjectsStatic('rdk_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->rdk_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->rdk_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('rdk_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_rdk = new virgoRodzajDokumentu();
				$tmp_rdk->load((int)$lookup_id);
				return $tmp_rdk->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoRodzajDokumentu');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" rdk_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoRodzajDokumentu', "10");
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
				$query = $query . " rdk_id as id, rdk_virgo_title as title ";
			}
			$query = $query . " FROM slk_rodzaje_dokumentow ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoRodzajDokumentu', 'sealock') == "1") {
				$privateCondition = " rdk_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY rdk_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resRodzajDokumentu = array();
				foreach ($rows as $row) {
					$resRodzajDokumentu[$row['id']] = $row['title'];
				}
				return $resRodzajDokumentu;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticRodzajDokumentu = new virgoRodzajDokumentu();
			return $staticRodzajDokumentu->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getGrupaDokumentowStatic($parentId) {
			return virgoGrupaDokumentow::getById($parentId);
		}
		
		function getGrupaDokumentow() {
			return virgoRodzajDokumentu::getGrupaDokumentowStatic($this->rdk_gdk_id);
		}

		static function getDokumentyKsiegoweStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resDokumentKsiegowy = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoDokumentKsiegowy'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resDokumentKsiegowy;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resDokumentKsiegowy;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsDokumentKsiegowy = virgoDokumentKsiegowy::selectAll('dks_rdk_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsDokumentKsiegowy as $resultDokumentKsiegowy) {
				$tmpDokumentKsiegowy = virgoDokumentKsiegowy::getById($resultDokumentKsiegowy['dks_id']); 
				array_push($resDokumentKsiegowy, $tmpDokumentKsiegowy);
			}
			return $resDokumentKsiegowy;
		}

		function getDokumentyKsiegowe($orderBy = '', $extraWhere = null) {
			return virgoRodzajDokumentu::getDokumentyKsiegoweStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_nazwa_obligatory', "0") == "1") {
				if (
(is_null($this->getNazwa()) || trim($this->getNazwa()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'NAZWA');
				}			
			}
			if (
(is_null($this->getSymbol()) || trim($this->getSymbol()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'SYMBOL');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_zwiekszajacy_obligatory', "0") == "1") {
				if (
(is_null($this->getZwiekszajacy()) || trim($this->getZwiekszajacy()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'ZWIEKSZAJACY');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_wlasny_obligatory', "0") == "1") {
				if (
(is_null($this->getWlasny()) || trim($this->getWlasny()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'WLASNY');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_wewnetrzny_obligatory', "0") == "1") {
				if (
(is_null($this->getWewnetrzny()) || trim($this->getWewnetrzny()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'WEWNETRZNY');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_korekta_obligatory', "0") == "1") {
				if (
(is_null($this->getKorekta()) || trim($this->getKorekta()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'KOREKTA');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_zastepczy_obligatory', "0") == "1") {
				if (
(is_null($this->getZastepczy()) || trim($this->getZastepczy()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'ZASTEPCZY');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_ostatni_numer_obligatory', "0") == "1") {
				if (
(is_null($this->getOstatniNumer()) || trim($this->getOstatniNumer()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'OSTATNI_NUMER');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_numeracja_rok_obligatory', "0") == "1") {
				if (
(is_null($this->getNumeracjaRok()) || trim($this->getNumeracjaRok()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'NUMERACJA_ROK');
				}			
			}
				if (is_null($this->rdk_gdk_id) || trim($this->rdk_gdk_id) == "") {
					if (R('create_rdk_grupaDokumentow_' . $this->rdk_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'GRUPA_DOKUMENTOW', '');
					}
			}			
 			if (!is_null($this->rdk_ostatni_numer) && trim($this->rdk_ostatni_numer) != "") {
				if (!is_numeric($this->rdk_ostatni_numer)) {
					return T('INCORRECT_NUMBER', 'OSTATNI_NUMER', $this->rdk_ostatni_numer);
				}
			}
			if (!is_null($this->rdk_numeracja_rok) && trim($this->rdk_numeracja_rok) != "") {
				if (!is_numeric($this->rdk_numeracja_rok)) {
					return T('INCORRECT_NUMBER', 'NUMERACJA_ROK', $this->rdk_numeracja_rok);
				}
			}
		$types = "";
		$values = array();
		$skipUniquenessCheck = false;
		$uniqnessWhere = " 1 = 1 ";
		if (!is_null($this->rdk_id) && $this->rdk_id != 0) {
			$uniqnessWhere = " rdk_id != " . $this->rdk_id . " ";			
		}
 		if (!$skipUniquenessCheck) {
 			if (!$skipUniquenessCheck) {
			$uniqnessWhere = $uniqnessWhere . ' AND UPPER(rdk_symbol) = UPPER(?) ';
			$types .= "s";
			$values[] = $this->rdk_symbol;
			}
 		}	
 		if (!$skipUniquenessCheck) {	
			$query = " SELECT COUNT(*) FROM slk_rodzaje_dokumentow ";
			$query = $query . " WHERE " . $uniqnessWhere;
			$result = QPL($query, $types, $values);
			if ($result[0] > 0) {
				$valeus = array();
				$colNames = array();
				$colNames[] = T('SYMBOL');
				$values[] = $this->rdk_symbol; 
				return T('UNIQNESS_FAILED', 'RODZAJ_DOKUMENTU', implode(', ', $colNames), implode(', ', $values));
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  slk_history_rodzaje_dokumentow WHERE rdk_id = " . $this->getId();
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
				$colNames = $colNames . ", rdk_nazwa";
				$values = $values . ", " . (is_null($objectToStore->getNazwa()) ? "null" : "'" . QE($objectToStore->getNazwa()) . "'");
				$colNames = $colNames . ", rdk_symbol";
				$values = $values . ", " . (is_null($objectToStore->getSymbol()) ? "null" : "'" . QE($objectToStore->getSymbol()) . "'");
				$colNames = $colNames . ", rdk_zwiekszajacy";
				$values = $values . ", " . (is_null($objectToStore->getZwiekszajacy()) ? "null" : "'" . QE($objectToStore->getZwiekszajacy()) . "'");
				$colNames = $colNames . ", rdk_wlasny";
				$values = $values . ", " . (is_null($objectToStore->getWlasny()) ? "null" : "'" . QE($objectToStore->getWlasny()) . "'");
				$colNames = $colNames . ", rdk_wewnetrzny";
				$values = $values . ", " . (is_null($objectToStore->getWewnetrzny()) ? "null" : "'" . QE($objectToStore->getWewnetrzny()) . "'");
				$colNames = $colNames . ", rdk_korekta";
				$values = $values . ", " . (is_null($objectToStore->getKorekta()) ? "null" : "'" . QE($objectToStore->getKorekta()) . "'");
				$colNames = $colNames . ", rdk_zastepczy";
				$values = $values . ", " . (is_null($objectToStore->getZastepczy()) ? "null" : "'" . QE($objectToStore->getZastepczy()) . "'");
				$colNames = $colNames . ", rdk_ostatni_numer";
				$values = $values . ", " . (is_null($objectToStore->getOstatniNumer()) ? "null" : "'" . QE($objectToStore->getOstatniNumer()) . "'");
				$colNames = $colNames . ", rdk_numeracja_rok";
				$values = $values . ", " . (is_null($objectToStore->getNumeracjaRok()) ? "null" : "'" . QE($objectToStore->getNumeracjaRok()) . "'");
				$colNames = $colNames . ", rdk_gdk_id";
				$values = $values . ", " . (is_null($objectToStore->getGdkId()) || $objectToStore->getGdkId() == "" ? "null" : $objectToStore->getGdkId());
				$query = "INSERT INTO slk_history_rodzaje_dokumentow (revision, ip, username, user_id, timestamp, rdk_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getNazwa() != $objectToStore->getNazwa()) {
				if (is_null($objectToStore->getNazwa())) {
					$nullifiedProperties = $nullifiedProperties . "nazwa,";
				} else {
				$colNames = $colNames . ", rdk_nazwa";
				$values = $values . ", " . (is_null($objectToStore->getNazwa()) ? "null" : "'" . QE($objectToStore->getNazwa()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getSymbol() != $objectToStore->getSymbol()) {
				if (is_null($objectToStore->getSymbol())) {
					$nullifiedProperties = $nullifiedProperties . "symbol,";
				} else {
				$colNames = $colNames . ", rdk_symbol";
				$values = $values . ", " . (is_null($objectToStore->getSymbol()) ? "null" : "'" . QE($objectToStore->getSymbol()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getZwiekszajacy() != $objectToStore->getZwiekszajacy()) {
				if (is_null($objectToStore->getZwiekszajacy())) {
					$nullifiedProperties = $nullifiedProperties . "zwiekszajacy,";
				} else {
				$colNames = $colNames . ", rdk_zwiekszajacy";
				$values = $values . ", " . (is_null($objectToStore->getZwiekszajacy()) ? "null" : "'" . QE($objectToStore->getZwiekszajacy()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getWlasny() != $objectToStore->getWlasny()) {
				if (is_null($objectToStore->getWlasny())) {
					$nullifiedProperties = $nullifiedProperties . "wlasny,";
				} else {
				$colNames = $colNames . ", rdk_wlasny";
				$values = $values . ", " . (is_null($objectToStore->getWlasny()) ? "null" : "'" . QE($objectToStore->getWlasny()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getWewnetrzny() != $objectToStore->getWewnetrzny()) {
				if (is_null($objectToStore->getWewnetrzny())) {
					$nullifiedProperties = $nullifiedProperties . "wewnetrzny,";
				} else {
				$colNames = $colNames . ", rdk_wewnetrzny";
				$values = $values . ", " . (is_null($objectToStore->getWewnetrzny()) ? "null" : "'" . QE($objectToStore->getWewnetrzny()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getKorekta() != $objectToStore->getKorekta()) {
				if (is_null($objectToStore->getKorekta())) {
					$nullifiedProperties = $nullifiedProperties . "korekta,";
				} else {
				$colNames = $colNames . ", rdk_korekta";
				$values = $values . ", " . (is_null($objectToStore->getKorekta()) ? "null" : "'" . QE($objectToStore->getKorekta()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getZastepczy() != $objectToStore->getZastepczy()) {
				if (is_null($objectToStore->getZastepczy())) {
					$nullifiedProperties = $nullifiedProperties . "zastepczy,";
				} else {
				$colNames = $colNames . ", rdk_zastepczy";
				$values = $values . ", " . (is_null($objectToStore->getZastepczy()) ? "null" : "'" . QE($objectToStore->getZastepczy()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getOstatniNumer() != $objectToStore->getOstatniNumer()) {
				if (is_null($objectToStore->getOstatniNumer())) {
					$nullifiedProperties = $nullifiedProperties . "ostatni_numer,";
				} else {
				$colNames = $colNames . ", rdk_ostatni_numer";
				$values = $values . ", " . (is_null($objectToStore->getOstatniNumer()) ? "null" : "'" . QE($objectToStore->getOstatniNumer()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getNumeracjaRok() != $objectToStore->getNumeracjaRok()) {
				if (is_null($objectToStore->getNumeracjaRok())) {
					$nullifiedProperties = $nullifiedProperties . "numeracja_rok,";
				} else {
				$colNames = $colNames . ", rdk_numeracja_rok";
				$values = $values . ", " . (is_null($objectToStore->getNumeracjaRok()) ? "null" : "'" . QE($objectToStore->getNumeracjaRok()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getGdkId() != $objectToStore->getGdkId() && ($virgoOld->getGdkId() != 0 || $objectToStore->getGdkId() != ""))) { 
				$colNames = $colNames . ", rdk_gdk_id";
				$values = $values . ", " . (is_null($objectToStore->getGdkId()) ? "null" : ($objectToStore->getGdkId() == "" ? "0" : $objectToStore->getGdkId()));
			}
			$query = "INSERT INTO slk_history_rodzaje_dokumentow (revision, ip, username, user_id, timestamp, rdk_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM slk_rodzaje_dokumentow");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'rdk_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE slk_rodzaje_dokumentow ADD COLUMN (rdk_virgo_title VARCHAR(255));";
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
			if (isset($this->rdk_id) && $this->rdk_id != "") {
				$query = "UPDATE slk_rodzaje_dokumentow SET ";
			if (isset($this->rdk_nazwa)) {
				$query .= " rdk_nazwa = ? ,";
				$types .= "s";
				$values[] = $this->rdk_nazwa;
			} else {
				$query .= " rdk_nazwa = NULL ,";				
			}
			if (isset($this->rdk_symbol)) {
				$query .= " rdk_symbol = ? ,";
				$types .= "s";
				$values[] = $this->rdk_symbol;
			} else {
				$query .= " rdk_symbol = NULL ,";				
			}
			if (isset($this->rdk_zwiekszajacy)) {
				$query .= " rdk_zwiekszajacy = ? ,";
				$types .= "s";
				$values[] = $this->rdk_zwiekszajacy;
			} else {
				$query .= " rdk_zwiekszajacy = NULL ,";				
			}
			if (isset($this->rdk_wlasny)) {
				$query .= " rdk_wlasny = ? ,";
				$types .= "s";
				$values[] = $this->rdk_wlasny;
			} else {
				$query .= " rdk_wlasny = NULL ,";				
			}
			if (isset($this->rdk_wewnetrzny)) {
				$query .= " rdk_wewnetrzny = ? ,";
				$types .= "s";
				$values[] = $this->rdk_wewnetrzny;
			} else {
				$query .= " rdk_wewnetrzny = NULL ,";				
			}
			if (isset($this->rdk_korekta)) {
				$query .= " rdk_korekta = ? ,";
				$types .= "s";
				$values[] = $this->rdk_korekta;
			} else {
				$query .= " rdk_korekta = NULL ,";				
			}
			if (isset($this->rdk_zastepczy)) {
				$query .= " rdk_zastepczy = ? ,";
				$types .= "s";
				$values[] = $this->rdk_zastepczy;
			} else {
				$query .= " rdk_zastepczy = NULL ,";				
			}
			if (isset($this->rdk_ostatni_numer)) {
				$query .= " rdk_ostatni_numer = ? ,";
				$types .= "i";
				$values[] = $this->rdk_ostatni_numer;
			} else {
				$query .= " rdk_ostatni_numer = NULL ,";				
			}
			if (isset($this->rdk_numeracja_rok)) {
				$query .= " rdk_numeracja_rok = ? ,";
				$types .= "i";
				$values[] = $this->rdk_numeracja_rok;
			} else {
				$query .= " rdk_numeracja_rok = NULL ,";				
			}
				if (isset($this->rdk_gdk_id) && trim($this->rdk_gdk_id) != "") {
					$query = $query . " rdk_gdk_id = ? , ";
					$types = $types . "i";
					$values[] = $this->rdk_gdk_id;
				} else {
					$query = $query . " rdk_gdk_id = NULL, ";
				}
				$query = $query . " rdk_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " rdk_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->rdk_date_modified;

				$query = $query . " rdk_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->rdk_usr_modified_id;

				$query = $query . " WHERE rdk_id = ? ";
				$types = $types . "i";
				$values[] = $this->rdk_id;
			} else {
				$query = "INSERT INTO slk_rodzaje_dokumentow ( ";
			$query = $query . " rdk_nazwa, ";
			$query = $query . " rdk_symbol, ";
			$query = $query . " rdk_zwiekszajacy, ";
			$query = $query . " rdk_wlasny, ";
			$query = $query . " rdk_wewnetrzny, ";
			$query = $query . " rdk_korekta, ";
			$query = $query . " rdk_zastepczy, ";
			$query = $query . " rdk_ostatni_numer, ";
			$query = $query . " rdk_numeracja_rok, ";
				$query = $query . " rdk_gdk_id, ";
				$query = $query . " rdk_virgo_title, rdk_date_created, rdk_usr_created_id) VALUES ( ";
			if (isset($this->rdk_nazwa)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->rdk_nazwa;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->rdk_symbol)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->rdk_symbol;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->rdk_zwiekszajacy)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->rdk_zwiekszajacy;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->rdk_wlasny)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->rdk_wlasny;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->rdk_wewnetrzny)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->rdk_wewnetrzny;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->rdk_korekta)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->rdk_korekta;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->rdk_zastepczy)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->rdk_zastepczy;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->rdk_ostatni_numer)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->rdk_ostatni_numer;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->rdk_numeracja_rok)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->rdk_numeracja_rok;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->rdk_gdk_id) && trim($this->rdk_gdk_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->rdk_gdk_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->rdk_date_created;
				$values[] = $this->rdk_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->rdk_id) || $this->rdk_id == "") {
					$this->rdk_id = QID();
				}
				if ($log) {
					L("rodzaj dokumentu stored successfully", "id = {$this->rdk_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->rdk_id) {
				$virgoOld = new virgoRodzajDokumentu($this->rdk_id);
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
					if ($this->rdk_id) {			
						$this->rdk_date_modified = date("Y-m-d H:i:s");
						$this->rdk_usr_modified_id = $userId;
					} else {
						$this->rdk_date_created = date("Y-m-d H:i:s");
						$this->rdk_usr_created_id = $userId;
					}
					$this->rdk_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "rodzaj dokumentu" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "rodzaj dokumentu" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM slk_rodzaje_dokumentow WHERE rdk_id = {$this->rdk_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			$list = $this->getDokumentyKsiegowe();
			if (sizeof($list) > 0) {
				$name = $this->getVirgoTitle();
				if (!is_null($name) && trim($name) != "") {
					$name = "'" . $name . "' ";
				}
				return T('CANT_DELETE_PARENT', 'RODZAJ_DOKUMENTU', 'DOKUMENT_KSIEGOWY', $name);
			}
			self::removeFromContext();
			$this->parentDelete();
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoRodzajDokumentu();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT rdk_id as id FROM slk_rodzaje_dokumentow";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'rdk_order_column')) {
				$orderBy = " ORDER BY rdk_order_column ASC ";
			} 
			if (property_exists($this, 'rdk_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY rdk_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoRodzajDokumentu();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoRodzajDokumentu($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE slk_rodzaje_dokumentow SET rdk_virgo_title = '$title' WHERE rdk_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getByNazwaStatic($token) {
			$tmpStatic = new virgoRodzajDokumentu();
			$tmpId = $tmpStatic->getIdByNazwa($token);
			$tmpStatic->load($tmpId);
			return $tmpStatic;
		}
		
		static function getIdByNazwaStatic($token) {
			$tmpStatic = new virgoRodzajDokumentu();
			return $tmpStatic->getIdByNazwa($token);
		}
		
		function getIdByNazwa($token) {
			$res = $this->selectAll(" rdk_nazwa = ?", "", "s", array($token));
			foreach ($res as $r) {
				return $r['rdk_id'];
			}
			return null;
		}
		static function getBySymbolStatic($token) {
			$tmpStatic = new virgoRodzajDokumentu();
			$tmpId = $tmpStatic->getIdBySymbol($token);
			$tmpStatic->load($tmpId);
			return $tmpStatic;
		}
		
		static function getIdBySymbolStatic($token) {
			$tmpStatic = new virgoRodzajDokumentu();
			return $tmpStatic->getIdBySymbol($token);
		}
		
		function getIdBySymbol($token) {
			$res = $this->selectAll(" rdk_symbol = ?", "", "s", array($token));
			foreach ($res as $r) {
				return $r['rdk_id'];
			}
			return null;
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoRodzajDokumentu();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" rdk_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['rdk_id'];
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
			virgoRodzajDokumentu::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoRodzajDokumentu::setSessionValue('Sealock_RodzajDokumentu-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoRodzajDokumentu::getSessionValue('Sealock_RodzajDokumentu-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoRodzajDokumentu::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoRodzajDokumentu::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoRodzajDokumentu::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoRodzajDokumentu::getSessionValue('GLOBAL', $name, $default);
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
			$context['rdk_id'] = $id;
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
			$context['rdk_id'] = null;
			virgoRodzajDokumentu::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoRodzajDokumentu::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoRodzajDokumentu::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoRodzajDokumentu::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoRodzajDokumentu::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoRodzajDokumentu::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoRodzajDokumentu::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoRodzajDokumentu::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoRodzajDokumentu::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoRodzajDokumentu::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoRodzajDokumentu::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoRodzajDokumentu::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoRodzajDokumentu::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoRodzajDokumentu::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoRodzajDokumentu::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoRodzajDokumentu::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoRodzajDokumentu::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "rdk_id";
			}
			return virgoRodzajDokumentu::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoRodzajDokumentu::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoRodzajDokumentu::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoRodzajDokumentu::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoRodzajDokumentu::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoRodzajDokumentu::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoRodzajDokumentu::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoRodzajDokumentu::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoRodzajDokumentu::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoRodzajDokumentu::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoRodzajDokumentu::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoRodzajDokumentu::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoRodzajDokumentu::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->rdk_id) {
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
						L(T('STORED_CORRECTLY', 'RODZAJ_DOKUMENTU'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'nazwa', $this->rdk_nazwa);
						$fieldValues = $fieldValues . T($fieldValue, 'symbol', $this->rdk_symbol);
						$fieldValues = $fieldValues . T($fieldValue, 'zwiększający', $this->rdk_zwiekszajacy);
						$fieldValues = $fieldValues . T($fieldValue, 'własny', $this->rdk_wlasny);
						$fieldValues = $fieldValues . T($fieldValue, 'wewnętrzny', $this->rdk_wewnetrzny);
						$fieldValues = $fieldValues . T($fieldValue, 'korekta', $this->rdk_korekta);
						$fieldValues = $fieldValues . T($fieldValue, 'zastępczy', $this->rdk_zastepczy);
						$fieldValues = $fieldValues . T($fieldValue, 'ostatni numer', $this->rdk_ostatni_numer);
						$fieldValues = $fieldValues . T($fieldValue, 'numeracja rok', $this->rdk_numeracja_rok);
						$parentGrupaDokumentow = new virgoGrupaDokumentow();
						$fieldValues = $fieldValues . T($fieldValue, 'grupa dokument\u00F3w', $parentGrupaDokumentow->lookup($this->rdk_gdk_id));
						$username = '';
						if ($this->rdk_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->rdk_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->rdk_date_created);
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
			$instance = new virgoRodzajDokumentu();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoRodzajDokumentu'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			if (false) { //$componentParams->get('show_form_dokumenty_ksiegowe') == "1") {
				$tmpDokumentKsiegowy = new virgoDokumentKsiegowy();
				$deleteDokumentKsiegowy = R('DELETE');
				if (sizeof($deleteDokumentKsiegowy) > 0) {
					virgoDokumentKsiegowy::multipleDelete($deleteDokumentKsiegowy);
				}
				$resIds = $tmpDokumentKsiegowy->select(null, 'all', null, null, ' dks_rdk_id = ' . $instance->getId(), ' SELECT dks_id FROM slk_dokumenty_ksiegowe ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->dks_id;
//					JRequest::setVar('dks_rodzaj_dokumentu_' . $resId->dks_id, $this->getId());
				} 
//				JRequest::setVar('dks_rodzaj_dokumentu_', $instance->getId());
				$tmpDokumentKsiegowy->setRecordSet($resIdsString);
				if (!$tmpDokumentKsiegowy->portletActionStoreSelected()) {
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
			$instance = new virgoRodzajDokumentu();
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
			$tmpId = intval(R('rdk_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoRodzajDokumentu::getContextId();
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
			$this->rdk_id = null;
			$this->rdk_date_created = null;
			$this->rdk_usr_created_id = null;
			$this->rdk_date_modified = null;
			$this->rdk_usr_modified_id = null;
			$this->rdk_virgo_title = null;
			
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

		static function portletActionShowForGrupaDokumentow() {
			$parentId = R('gdk_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoGrupaDokumentow($parentId);
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
//			$ret = new virgoRodzajDokumentu();
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
				$instance = new virgoRodzajDokumentu();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoRodzajDokumentu::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'RODZAJ_DOKUMENTU'), '', 'INFO');
					return 0;
					
				} else {
					L($res, '', 'ERROR');
					return -1;
				}
			}
		}
		
		
		static function portletActionVirgoSetZwiekszajacyTrue() {
			$instance = new virgoRodzajDokumentu();
			$instance->loadFromDB();
			$instance->setZwiekszajacy(1);
			$ret = $instance->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetZwiekszajacyFalse() {
			$instance = new virgoRodzajDokumentu();
			$instance->loadFromDB();
			$instance->setZwiekszajacy(0);
			$ret = $instance->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isZwiekszajacy() {
			return $this->getZwiekszajacy() == 1;
		}
		static function portletActionVirgoSetWlasnyTrue() {
			$instance = new virgoRodzajDokumentu();
			$instance->loadFromDB();
			$instance->setWlasny(1);
			$ret = $instance->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetWlasnyFalse() {
			$instance = new virgoRodzajDokumentu();
			$instance->loadFromDB();
			$instance->setWlasny(0);
			$ret = $instance->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isWlasny() {
			return $this->getWlasny() == 1;
		}
		static function portletActionVirgoSetWewnetrznyTrue() {
			$instance = new virgoRodzajDokumentu();
			$instance->loadFromDB();
			$instance->setWewnetrzny(1);
			$ret = $instance->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetWewnetrznyFalse() {
			$instance = new virgoRodzajDokumentu();
			$instance->loadFromDB();
			$instance->setWewnetrzny(0);
			$ret = $instance->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isWewnetrzny() {
			return $this->getWewnetrzny() == 1;
		}
		static function portletActionVirgoSetKorektaTrue() {
			$instance = new virgoRodzajDokumentu();
			$instance->loadFromDB();
			$instance->setKorekta(1);
			$ret = $instance->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetKorektaFalse() {
			$instance = new virgoRodzajDokumentu();
			$instance->loadFromDB();
			$instance->setKorekta(0);
			$ret = $instance->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isKorekta() {
			return $this->getKorekta() == 1;
		}
		static function portletActionVirgoSetZastepczyTrue() {
			$instance = new virgoRodzajDokumentu();
			$instance->loadFromDB();
			$instance->setZastepczy(1);
			$ret = $instance->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetZastepczyFalse() {
			$instance = new virgoRodzajDokumentu();
			$instance->loadFromDB();
			$instance->setZastepczy(0);
			$ret = $instance->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isZastepczy() {
			return $this->getZastepczy() == 1;
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
				$resultRodzajDokumentu = new virgoRodzajDokumentu();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultRodzajDokumentu->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultRodzajDokumentu->load($idToEditInt);
					} else {
						$resultRodzajDokumentu->rdk_id = 0;
					}
				}
				$results[] = $resultRodzajDokumentu;
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
				$result = new virgoRodzajDokumentu();
				$result->loadFromRequest($idToStore);
				if ($result->rdk_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->rdk_id == 0) {
						$result->rdk_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->rdk_id)) {
							$result->rdk_id = 0;
						}
						$idsToCorrect[$result->rdk_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'RODZAJE_DOKUMENTOW'), '', 'INFO');
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
			$resultRodzajDokumentu = new virgoRodzajDokumentu();
			foreach ($idsToDelete as $idToDelete) {
				$resultRodzajDokumentu->load((int)trim($idToDelete));
				$res = $resultRodzajDokumentu->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'RODZAJE_DOKUMENTOW'), '', 'INFO');			
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
		$ret = $this->rdk_nazwa;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoRodzajDokumentu');
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
				$query = "UPDATE slk_rodzaje_dokumentow SET rdk_virgo_title = ? WHERE rdk_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT rdk_id AS id FROM slk_rodzaje_dokumentow ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoRodzajDokumentu($row['id']);
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
				$class2prefix["sealock\\virgoGrupaDokumentow"] = "gdk";
				$class2prefix2 = array();
				$class2parentPrefix["sealock\\virgoGrupaDokumentow"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'slk_rodzaje_dokumentow.rdk_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'slk_rodzaje_dokumentow.rdk_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'slk_rodzaje_dokumentow.rdk_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM slk_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'slk_rodzaje_dokumentow.rdk_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoRodzajDokumentu!', '', 'ERROR');
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
			$pdf->SetTitle('Rodzaje dokumentów report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('RODZAJE_DOKUMENTOW');
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
			if (P('show_pdf_nazwa', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_symbol', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_zwiekszajacy', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_wlasny', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_wewnetrzny', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_korekta', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_zastepczy', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_ostatni_numer', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_numeracja_rok', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_grupa_dokumentow', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultRodzajDokumentu = new virgoRodzajDokumentu();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_nazwa', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Nazwa');
				$minWidth['nazwa'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['nazwa']) {
						$minWidth['nazwa'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_symbol', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Symbol');
				$minWidth['symbol'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['symbol']) {
						$minWidth['symbol'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_zwiekszajacy', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Zwiększający');
				$minWidth['zwi\u0119kszaj\u0105cy'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['zwi\u0119kszaj\u0105cy']) {
						$minWidth['zwi\u0119kszaj\u0105cy'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_wlasny', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Własny');
				$minWidth['w\u0142asny'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['w\u0142asny']) {
						$minWidth['w\u0142asny'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_wewnetrzny', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Wewnętrzny');
				$minWidth['wewn\u0119trzny'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['wewn\u0119trzny']) {
						$minWidth['wewn\u0119trzny'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_korekta', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Korekta');
				$minWidth['korekta'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['korekta']) {
						$minWidth['korekta'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_zastepczy', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Zastępczy');
				$minWidth['zast\u0119pczy'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['zast\u0119pczy']) {
						$minWidth['zast\u0119pczy'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_ostatni_numer', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Ostatni numer');
				$minWidth['ostatni numer'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['ostatni numer']) {
						$minWidth['ostatni numer'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_numeracja_rok', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Numeracja rok');
				$minWidth['numeracja rok'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['numeracja rok']) {
						$minWidth['numeracja rok'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_grupa_dokumentow', "1") == "1") {
				$minWidth['grupa dokument\u00F3w $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'grupa dokument\u00F3w $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['grupa dokument\u00F3w $relation.name']) {
						$minWidth['grupa dokument\u00F3w $relation.name'] = min($tmpLen, $maxWidth);
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
			$whereClauseRodzajDokumentu = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaRodzajDokumentu = $resultRodzajDokumentu->getCriteria();
			$fieldCriteriaNazwa = $criteriaRodzajDokumentu["nazwa"];
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
			$fieldCriteriaSymbol = $criteriaRodzajDokumentu["symbol"];
			if ($fieldCriteriaSymbol["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Symbol', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaSymbol["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Symbol', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaZwiekszajacy = $criteriaRodzajDokumentu["zwiekszajacy"];
			if ($fieldCriteriaZwiekszajacy["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Zwiększający', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaZwiekszajacy["value"];
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
					$pdf->MultiCell(60, 100, 'Zwiększający', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaWlasny = $criteriaRodzajDokumentu["wlasny"];
			if ($fieldCriteriaWlasny["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Własny', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaWlasny["value"];
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
					$pdf->MultiCell(60, 100, 'Własny', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaWewnetrzny = $criteriaRodzajDokumentu["wewnetrzny"];
			if ($fieldCriteriaWewnetrzny["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Wewnętrzny', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaWewnetrzny["value"];
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
					$pdf->MultiCell(60, 100, 'Wewnętrzny', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaKorekta = $criteriaRodzajDokumentu["korekta"];
			if ($fieldCriteriaKorekta["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Korekta', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaKorekta["value"];
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
					$pdf->MultiCell(60, 100, 'Korekta', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaZastepczy = $criteriaRodzajDokumentu["zastepczy"];
			if ($fieldCriteriaZastepczy["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Zastępczy', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaZastepczy["value"];
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
					$pdf->MultiCell(60, 100, 'Zastępczy', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaOstatniNumer = $criteriaRodzajDokumentu["ostatni_numer"];
			if ($fieldCriteriaOstatniNumer["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Ostatni numer', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaOstatniNumer["value"];
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
					$pdf->MultiCell(60, 100, 'Ostatni numer', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaNumeracjaRok = $criteriaRodzajDokumentu["numeracja_rok"];
			if ($fieldCriteriaNumeracjaRok["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Numeracja rok', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaNumeracjaRok["value"];
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
					$pdf->MultiCell(60, 100, 'Numeracja rok', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaRodzajDokumentu["grupa_dokumentow"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Grupa dokumentów', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoGrupaDokumentow::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Grupa dokumentów', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_grupa_dokumentow');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_rodzaje_dokumentow.rdk_gdk_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_rodzaje_dokumentow.rdk_gdk_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaRodzajDokumentu = self::getCriteria();
			if (isset($criteriaRodzajDokumentu["nazwa"])) {
				$fieldCriteriaNazwa = $criteriaRodzajDokumentu["nazwa"];
				if ($fieldCriteriaNazwa["is_null"] == 1) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_nazwa IS NOT NULL ';
				} elseif ($fieldCriteriaNazwa["is_null"] == 2) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_nazwa IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaNazwa["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_nazwa like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaRodzajDokumentu["symbol"])) {
				$fieldCriteriaSymbol = $criteriaRodzajDokumentu["symbol"];
				if ($fieldCriteriaSymbol["is_null"] == 1) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_symbol IS NOT NULL ';
				} elseif ($fieldCriteriaSymbol["is_null"] == 2) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_symbol IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaSymbol["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_symbol like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaRodzajDokumentu["zwiekszajacy"])) {
				$fieldCriteriaZwiekszajacy = $criteriaRodzajDokumentu["zwiekszajacy"];
				if ($fieldCriteriaZwiekszajacy["is_null"] == 1) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_zwiekszajacy IS NOT NULL ';
				} elseif ($fieldCriteriaZwiekszajacy["is_null"] == 2) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_zwiekszajacy IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaZwiekszajacy["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_zwiekszajacy = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaRodzajDokumentu["wlasny"])) {
				$fieldCriteriaWlasny = $criteriaRodzajDokumentu["wlasny"];
				if ($fieldCriteriaWlasny["is_null"] == 1) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_wlasny IS NOT NULL ';
				} elseif ($fieldCriteriaWlasny["is_null"] == 2) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_wlasny IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaWlasny["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_wlasny = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaRodzajDokumentu["wewnetrzny"])) {
				$fieldCriteriaWewnetrzny = $criteriaRodzajDokumentu["wewnetrzny"];
				if ($fieldCriteriaWewnetrzny["is_null"] == 1) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_wewnetrzny IS NOT NULL ';
				} elseif ($fieldCriteriaWewnetrzny["is_null"] == 2) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_wewnetrzny IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaWewnetrzny["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_wewnetrzny = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaRodzajDokumentu["korekta"])) {
				$fieldCriteriaKorekta = $criteriaRodzajDokumentu["korekta"];
				if ($fieldCriteriaKorekta["is_null"] == 1) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_korekta IS NOT NULL ';
				} elseif ($fieldCriteriaKorekta["is_null"] == 2) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_korekta IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaKorekta["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_korekta = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaRodzajDokumentu["zastepczy"])) {
				$fieldCriteriaZastepczy = $criteriaRodzajDokumentu["zastepczy"];
				if ($fieldCriteriaZastepczy["is_null"] == 1) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_zastepczy IS NOT NULL ';
				} elseif ($fieldCriteriaZastepczy["is_null"] == 2) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_zastepczy IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaZastepczy["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_zastepczy = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaRodzajDokumentu["ostatni_numer"])) {
				$fieldCriteriaOstatniNumer = $criteriaRodzajDokumentu["ostatni_numer"];
				if ($fieldCriteriaOstatniNumer["is_null"] == 1) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_ostatni_numer IS NOT NULL ';
				} elseif ($fieldCriteriaOstatniNumer["is_null"] == 2) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_ostatni_numer IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaOstatniNumer["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_ostatni_numer = ? ";
				} else {
					$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_ostatni_numer >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_ostatni_numer <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaRodzajDokumentu["numeracja_rok"])) {
				$fieldCriteriaNumeracjaRok = $criteriaRodzajDokumentu["numeracja_rok"];
				if ($fieldCriteriaNumeracjaRok["is_null"] == 1) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_numeracja_rok IS NOT NULL ';
				} elseif ($fieldCriteriaNumeracjaRok["is_null"] == 2) {
$filter = $filter . ' AND slk_rodzaje_dokumentow.rdk_numeracja_rok IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaNumeracjaRok["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_numeracja_rok = ? ";
				} else {
					$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_numeracja_rok >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_numeracja_rok <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaRodzajDokumentu["grupa_dokumentow"])) {
				$parentCriteria = $criteriaRodzajDokumentu["grupa_dokumentow"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND rdk_gdk_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND slk_rodzaje_dokumentow.rdk_gdk_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT slk_rodzaje_dokumentow.rdk_id, slk_rodzaje_dokumentow.rdk_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_nazwa', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_nazwa rdk_nazwa";
			} else {
				if ($defaultOrderColumn == "rdk_nazwa") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_nazwa ";
				}
			}
			if (P('show_pdf_symbol', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_symbol rdk_symbol";
			} else {
				if ($defaultOrderColumn == "rdk_symbol") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_symbol ";
				}
			}
			if (P('show_pdf_zwiekszajacy', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_zwiekszajacy rdk_zwiekszajacy";
			} else {
				if ($defaultOrderColumn == "rdk_zwiekszajacy") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_zwiekszajacy ";
				}
			}
			if (P('show_pdf_wlasny', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_wlasny rdk_wlasny";
			} else {
				if ($defaultOrderColumn == "rdk_wlasny") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_wlasny ";
				}
			}
			if (P('show_pdf_wewnetrzny', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_wewnetrzny rdk_wewnetrzny";
			} else {
				if ($defaultOrderColumn == "rdk_wewnetrzny") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_wewnetrzny ";
				}
			}
			if (P('show_pdf_korekta', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_korekta rdk_korekta";
			} else {
				if ($defaultOrderColumn == "rdk_korekta") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_korekta ";
				}
			}
			if (P('show_pdf_zastepczy', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_zastepczy rdk_zastepczy";
			} else {
				if ($defaultOrderColumn == "rdk_zastepczy") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_zastepczy ";
				}
			}
			if (P('show_pdf_ostatni_numer', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_ostatni_numer rdk_ostatni_numer";
			} else {
				if ($defaultOrderColumn == "rdk_ostatni_numer") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_ostatni_numer ";
				}
			}
			if (P('show_pdf_numeracja_rok', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_numeracja_rok rdk_numeracja_rok";
			} else {
				if ($defaultOrderColumn == "rdk_numeracja_rok") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_numeracja_rok ";
				}
			}
			if (class_exists('sealock\virgoGrupaDokumentow') && P('show_pdf_grupa_dokumentow', "1") != "0") { // */ && !in_array("gdk", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_gdk_id as rdk_gdk_id ";
				$queryString = $queryString . ", slk_grupy_dokumentow_parent.gdk_virgo_title as `grupa_dokumentow` ";
			} else {
				if ($defaultOrderColumn == "grupa_dokumentow") {
					$orderColumnNotDisplayed = " slk_grupy_dokumentow_parent.gdk_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_rodzaje_dokumentow ";
			if (class_exists('sealock\virgoGrupaDokumentow')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_grupy_dokumentow AS slk_grupy_dokumentow_parent ON (slk_rodzaje_dokumentow.rdk_gdk_id = slk_grupy_dokumentow_parent.gdk_id) ";
			}

		$resultsRodzajDokumentu = $resultRodzajDokumentu->select(
			'', 
			'all', 
			$resultRodzajDokumentu->getOrderColumn(), 
			$resultRodzajDokumentu->getOrderMode(), 
			$whereClauseRodzajDokumentu,
			$queryString);
		
		foreach ($resultsRodzajDokumentu as $resultRodzajDokumentu) {

			if (P('show_pdf_nazwa', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultRodzajDokumentu['rdk_nazwa'])) + 6;
				if ($tmpLen > $minWidth['nazwa']) {
					$minWidth['nazwa'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_symbol', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultRodzajDokumentu['rdk_symbol'])) + 6;
				if ($tmpLen > $minWidth['symbol']) {
					$minWidth['symbol'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_zwiekszajacy', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultRodzajDokumentu['rdk_zwiekszajacy'])) + 6;
				if ($tmpLen > $minWidth['zwi\u0119kszaj\u0105cy']) {
					$minWidth['zwi\u0119kszaj\u0105cy'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_wlasny', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultRodzajDokumentu['rdk_wlasny'])) + 6;
				if ($tmpLen > $minWidth['w\u0142asny']) {
					$minWidth['w\u0142asny'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_wewnetrzny', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultRodzajDokumentu['rdk_wewnetrzny'])) + 6;
				if ($tmpLen > $minWidth['wewn\u0119trzny']) {
					$minWidth['wewn\u0119trzny'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_korekta', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultRodzajDokumentu['rdk_korekta'])) + 6;
				if ($tmpLen > $minWidth['korekta']) {
					$minWidth['korekta'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_zastepczy', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultRodzajDokumentu['rdk_zastepczy'])) + 6;
				if ($tmpLen > $minWidth['zast\u0119pczy']) {
					$minWidth['zast\u0119pczy'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_ostatni_numer', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultRodzajDokumentu['rdk_ostatni_numer'])) + 6;
				if ($tmpLen > $minWidth['ostatni numer']) {
					$minWidth['ostatni numer'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_numeracja_rok', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultRodzajDokumentu['rdk_numeracja_rok'])) + 6;
				if ($tmpLen > $minWidth['numeracja rok']) {
					$minWidth['numeracja rok'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_grupa_dokumentow', "1") == "1") {
			$parentValue = trim(virgoGrupaDokumentow::lookup($resultRodzajDokumentu['rdkgdk__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['grupa dokument\u00F3w $relation.name']) {
					$minWidth['grupa dokument\u00F3w $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaRodzajDokumentu = $resultRodzajDokumentu->getCriteria();
		if (is_null($criteriaRodzajDokumentu) || sizeof($criteriaRodzajDokumentu) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																											if (P('show_pdf_nazwa', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['nazwa'], $colHeight, T('NAZWA'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_symbol', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['symbol'], $colHeight, T('SYMBOL'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_zwiekszajacy', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['zwi\u0119kszaj\u0105cy'], $colHeight, T('ZWIEKSZAJACY'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_wlasny', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['w\u0142asny'], $colHeight, T('WLASNY'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_wewnetrzny', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['wewn\u0119trzny'], $colHeight, T('WEWNETRZNY'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_korekta', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['korekta'], $colHeight, T('KOREKTA'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_zastepczy', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['zast\u0119pczy'], $colHeight, T('ZASTEPCZY'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_ostatni_numer', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['ostatni numer'], $colHeight, T('OSTATNI_NUMER'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_numeracja_rok', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['numeracja rok'], $colHeight, T('NUMERACJA_ROK'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_grupa_dokumentow', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['grupa dokument\u00F3w $relation.name'], $colHeight, T('GRUPA_DOKUMENTOW') . ' ' . T(''), 'T', 'C', 0, 0); 
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
		foreach ($resultsRodzajDokumentu as $resultRodzajDokumentu) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_nazwa', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['nazwa'], $colHeight, '' . $resultRodzajDokumentu['rdk_nazwa'], 'T', 'L', 0, 0);
				if (P('show_pdf_nazwa', "1") == "2") {
										if (!is_null($resultRodzajDokumentu['rdk_nazwa'])) {
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
										if (!is_null($resultRodzajDokumentu['rdk_nazwa'])) {
						$tmpSum = (float)$sums["nazwa"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRodzajDokumentu['rdk_nazwa'];
						}
						$sums["nazwa"] = $tmpSum;
					}
				}
				if (P('show_pdf_nazwa', "1") == "4") {
										if (!is_null($resultRodzajDokumentu['rdk_nazwa'])) {
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
							$tmpSum = $tmpSum + $resultRodzajDokumentu['rdk_nazwa'];
						}
						$avgSums["nazwa"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_symbol', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['symbol'], $colHeight, '' . $resultRodzajDokumentu['rdk_symbol'], 'T', 'L', 0, 0);
				if (P('show_pdf_symbol', "1") == "2") {
										if (!is_null($resultRodzajDokumentu['rdk_symbol'])) {
						$tmpCount = (float)$counts["symbol"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["symbol"] = $tmpCount;
					}
				}
				if (P('show_pdf_symbol', "1") == "3") {
										if (!is_null($resultRodzajDokumentu['rdk_symbol'])) {
						$tmpSum = (float)$sums["symbol"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRodzajDokumentu['rdk_symbol'];
						}
						$sums["symbol"] = $tmpSum;
					}
				}
				if (P('show_pdf_symbol', "1") == "4") {
										if (!is_null($resultRodzajDokumentu['rdk_symbol'])) {
						$tmpCount = (float)$avgCounts["symbol"];
						$tmpSum = (float)$avgSums["symbol"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["symbol"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRodzajDokumentu['rdk_symbol'];
						}
						$avgSums["symbol"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_zwiekszajacy', "0") != "0") {
			$renderCriteria = "";
			switch ($resultRodzajDokumentu['rdk_zwiekszajacy']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['zwi\u0119kszaj\u0105cy'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_zwiekszajacy', "1") == "2") {
										if (!is_null($resultRodzajDokumentu['rdk_zwiekszajacy'])) {
						$tmpCount = (float)$counts["zwiekszajacy"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["zwiekszajacy"] = $tmpCount;
					}
				}
				if (P('show_pdf_zwiekszajacy', "1") == "3") {
										if (!is_null($resultRodzajDokumentu['rdk_zwiekszajacy'])) {
						$tmpSum = (float)$sums["zwiekszajacy"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRodzajDokumentu['rdk_zwiekszajacy'];
						}
						$sums["zwiekszajacy"] = $tmpSum;
					}
				}
				if (P('show_pdf_zwiekszajacy', "1") == "4") {
										if (!is_null($resultRodzajDokumentu['rdk_zwiekszajacy'])) {
						$tmpCount = (float)$avgCounts["zwiekszajacy"];
						$tmpSum = (float)$avgSums["zwiekszajacy"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["zwiekszajacy"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRodzajDokumentu['rdk_zwiekszajacy'];
						}
						$avgSums["zwiekszajacy"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_wlasny', "0") != "0") {
			$renderCriteria = "";
			switch ($resultRodzajDokumentu['rdk_wlasny']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['w\u0142asny'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_wlasny', "1") == "2") {
										if (!is_null($resultRodzajDokumentu['rdk_wlasny'])) {
						$tmpCount = (float)$counts["wlasny"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["wlasny"] = $tmpCount;
					}
				}
				if (P('show_pdf_wlasny', "1") == "3") {
										if (!is_null($resultRodzajDokumentu['rdk_wlasny'])) {
						$tmpSum = (float)$sums["wlasny"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRodzajDokumentu['rdk_wlasny'];
						}
						$sums["wlasny"] = $tmpSum;
					}
				}
				if (P('show_pdf_wlasny', "1") == "4") {
										if (!is_null($resultRodzajDokumentu['rdk_wlasny'])) {
						$tmpCount = (float)$avgCounts["wlasny"];
						$tmpSum = (float)$avgSums["wlasny"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["wlasny"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRodzajDokumentu['rdk_wlasny'];
						}
						$avgSums["wlasny"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_wewnetrzny', "0") != "0") {
			$renderCriteria = "";
			switch ($resultRodzajDokumentu['rdk_wewnetrzny']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['wewn\u0119trzny'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_wewnetrzny', "1") == "2") {
										if (!is_null($resultRodzajDokumentu['rdk_wewnetrzny'])) {
						$tmpCount = (float)$counts["wewnetrzny"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["wewnetrzny"] = $tmpCount;
					}
				}
				if (P('show_pdf_wewnetrzny', "1") == "3") {
										if (!is_null($resultRodzajDokumentu['rdk_wewnetrzny'])) {
						$tmpSum = (float)$sums["wewnetrzny"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRodzajDokumentu['rdk_wewnetrzny'];
						}
						$sums["wewnetrzny"] = $tmpSum;
					}
				}
				if (P('show_pdf_wewnetrzny', "1") == "4") {
										if (!is_null($resultRodzajDokumentu['rdk_wewnetrzny'])) {
						$tmpCount = (float)$avgCounts["wewnetrzny"];
						$tmpSum = (float)$avgSums["wewnetrzny"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["wewnetrzny"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRodzajDokumentu['rdk_wewnetrzny'];
						}
						$avgSums["wewnetrzny"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_korekta', "0") != "0") {
			$renderCriteria = "";
			switch ($resultRodzajDokumentu['rdk_korekta']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['korekta'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_korekta', "1") == "2") {
										if (!is_null($resultRodzajDokumentu['rdk_korekta'])) {
						$tmpCount = (float)$counts["korekta"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["korekta"] = $tmpCount;
					}
				}
				if (P('show_pdf_korekta', "1") == "3") {
										if (!is_null($resultRodzajDokumentu['rdk_korekta'])) {
						$tmpSum = (float)$sums["korekta"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRodzajDokumentu['rdk_korekta'];
						}
						$sums["korekta"] = $tmpSum;
					}
				}
				if (P('show_pdf_korekta', "1") == "4") {
										if (!is_null($resultRodzajDokumentu['rdk_korekta'])) {
						$tmpCount = (float)$avgCounts["korekta"];
						$tmpSum = (float)$avgSums["korekta"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["korekta"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRodzajDokumentu['rdk_korekta'];
						}
						$avgSums["korekta"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_zastepczy', "0") != "0") {
			$renderCriteria = "";
			switch ($resultRodzajDokumentu['rdk_zastepczy']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['zast\u0119pczy'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_zastepczy', "1") == "2") {
										if (!is_null($resultRodzajDokumentu['rdk_zastepczy'])) {
						$tmpCount = (float)$counts["zastepczy"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["zastepczy"] = $tmpCount;
					}
				}
				if (P('show_pdf_zastepczy', "1") == "3") {
										if (!is_null($resultRodzajDokumentu['rdk_zastepczy'])) {
						$tmpSum = (float)$sums["zastepczy"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRodzajDokumentu['rdk_zastepczy'];
						}
						$sums["zastepczy"] = $tmpSum;
					}
				}
				if (P('show_pdf_zastepczy', "1") == "4") {
										if (!is_null($resultRodzajDokumentu['rdk_zastepczy'])) {
						$tmpCount = (float)$avgCounts["zastepczy"];
						$tmpSum = (float)$avgSums["zastepczy"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["zastepczy"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRodzajDokumentu['rdk_zastepczy'];
						}
						$avgSums["zastepczy"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_ostatni_numer', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['ostatni numer'], $colHeight, '' . $resultRodzajDokumentu['rdk_ostatni_numer'], 'T', 'R', 0, 0);
				if (P('show_pdf_ostatni_numer', "1") == "2") {
										if (!is_null($resultRodzajDokumentu['rdk_ostatni_numer'])) {
						$tmpCount = (float)$counts["ostatni_numer"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["ostatni_numer"] = $tmpCount;
					}
				}
				if (P('show_pdf_ostatni_numer', "1") == "3") {
										if (!is_null($resultRodzajDokumentu['rdk_ostatni_numer'])) {
						$tmpSum = (float)$sums["ostatni_numer"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRodzajDokumentu['rdk_ostatni_numer'];
						}
						$sums["ostatni_numer"] = $tmpSum;
					}
				}
				if (P('show_pdf_ostatni_numer', "1") == "4") {
										if (!is_null($resultRodzajDokumentu['rdk_ostatni_numer'])) {
						$tmpCount = (float)$avgCounts["ostatni_numer"];
						$tmpSum = (float)$avgSums["ostatni_numer"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["ostatni_numer"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRodzajDokumentu['rdk_ostatni_numer'];
						}
						$avgSums["ostatni_numer"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_numeracja_rok', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['numeracja rok'], $colHeight, '' . $resultRodzajDokumentu['rdk_numeracja_rok'], 'T', 'R', 0, 0);
				if (P('show_pdf_numeracja_rok', "1") == "2") {
										if (!is_null($resultRodzajDokumentu['rdk_numeracja_rok'])) {
						$tmpCount = (float)$counts["numeracja_rok"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["numeracja_rok"] = $tmpCount;
					}
				}
				if (P('show_pdf_numeracja_rok', "1") == "3") {
										if (!is_null($resultRodzajDokumentu['rdk_numeracja_rok'])) {
						$tmpSum = (float)$sums["numeracja_rok"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRodzajDokumentu['rdk_numeracja_rok'];
						}
						$sums["numeracja_rok"] = $tmpSum;
					}
				}
				if (P('show_pdf_numeracja_rok', "1") == "4") {
										if (!is_null($resultRodzajDokumentu['rdk_numeracja_rok'])) {
						$tmpCount = (float)$avgCounts["numeracja_rok"];
						$tmpSum = (float)$avgSums["numeracja_rok"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["numeracja_rok"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultRodzajDokumentu['rdk_numeracja_rok'];
						}
						$avgSums["numeracja_rok"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_grupa_dokumentow', "1") == "1") {
			$parentValue = virgoGrupaDokumentow::lookup($resultRodzajDokumentu['rdk_gdk_id']);
			$tmpLn = $pdf->MultiCell($minWidth['grupa dokument\u00F3w $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
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
			if (P('show_pdf_nazwa', "0") != "0") {
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
			if (P('show_pdf_symbol', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['symbol'];
				if (P('show_pdf_symbol', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["symbol"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_zwiekszajacy', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['zwi\u0119kszaj\u0105cy'];
				if (P('show_pdf_zwiekszajacy', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["zwiekszajacy"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_wlasny', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['w\u0142asny'];
				if (P('show_pdf_wlasny', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["wlasny"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_wewnetrzny', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['wewn\u0119trzny'];
				if (P('show_pdf_wewnetrzny', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["wewnetrzny"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_korekta', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['korekta'];
				if (P('show_pdf_korekta', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["korekta"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_zastepczy', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['zast\u0119pczy'];
				if (P('show_pdf_zastepczy', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["zastepczy"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_ostatni_numer', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['ostatni numer'];
				if (P('show_pdf_ostatni_numer', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["ostatni_numer"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_numeracja_rok', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['numeracja rok'];
				if (P('show_pdf_numeracja_rok', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["numeracja_rok"];
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
			if (P('show_pdf_nazwa', "0") != "0") {
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
			if (P('show_pdf_symbol', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['symbol'];
				if (P('show_pdf_symbol', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["symbol"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_zwiekszajacy', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['zwi\u0119kszaj\u0105cy'];
				if (P('show_pdf_zwiekszajacy', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["zwiekszajacy"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_wlasny', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['w\u0142asny'];
				if (P('show_pdf_wlasny', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["wlasny"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_wewnetrzny', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['wewn\u0119trzny'];
				if (P('show_pdf_wewnetrzny', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["wewnetrzny"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_korekta', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['korekta'];
				if (P('show_pdf_korekta', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["korekta"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_zastepczy', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['zast\u0119pczy'];
				if (P('show_pdf_zastepczy', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["zastepczy"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_ostatni_numer', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['ostatni numer'];
				if (P('show_pdf_ostatni_numer', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["ostatni_numer"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_numeracja_rok', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['numeracja rok'];
				if (P('show_pdf_numeracja_rok', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["numeracja_rok"], 2, ',', ' ');
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
			if (P('show_pdf_nazwa', "0") != "0") {
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
			if (P('show_pdf_symbol', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['symbol'];
				if (P('show_pdf_symbol', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["symbol"] == 0 ? "-" : $avgSums["symbol"] / $avgCounts["symbol"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_zwiekszajacy', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['zwi\u0119kszaj\u0105cy'];
				if (P('show_pdf_zwiekszajacy', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["zwiekszajacy"] == 0 ? "-" : $avgSums["zwiekszajacy"] / $avgCounts["zwiekszajacy"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_wlasny', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['w\u0142asny'];
				if (P('show_pdf_wlasny', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["wlasny"] == 0 ? "-" : $avgSums["wlasny"] / $avgCounts["wlasny"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_wewnetrzny', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['wewn\u0119trzny'];
				if (P('show_pdf_wewnetrzny', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["wewnetrzny"] == 0 ? "-" : $avgSums["wewnetrzny"] / $avgCounts["wewnetrzny"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_korekta', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['korekta'];
				if (P('show_pdf_korekta', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["korekta"] == 0 ? "-" : $avgSums["korekta"] / $avgCounts["korekta"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_zastepczy', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['zast\u0119pczy'];
				if (P('show_pdf_zastepczy', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["zastepczy"] == 0 ? "-" : $avgSums["zastepczy"] / $avgCounts["zastepczy"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_ostatni_numer', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['ostatni numer'];
				if (P('show_pdf_ostatni_numer', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["ostatni_numer"] == 0 ? "-" : $avgSums["ostatni_numer"] / $avgCounts["ostatni_numer"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_numeracja_rok', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['numeracja rok'];
				if (P('show_pdf_numeracja_rok', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["numeracja_rok"] == 0 ? "-" : $avgSums["numeracja_rok"] / $avgCounts["numeracja_rok"]);
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
				$reportTitle = T('RODZAJE_DOKUMENTOW');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultRodzajDokumentu = new virgoRodzajDokumentu();
			$whereClauseRodzajDokumentu = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_nazwa', "1") != "0") {
					$data = $data . $stringDelimeter .'Nazwa' . $stringDelimeter . $separator;
				}
				if (P('show_export_symbol', "1") != "0") {
					$data = $data . $stringDelimeter .'Symbol' . $stringDelimeter . $separator;
				}
				if (P('show_export_zwiekszajacy', "1") != "0") {
					$data = $data . $stringDelimeter .'Zwiększający' . $stringDelimeter . $separator;
				}
				if (P('show_export_wlasny', "1") != "0") {
					$data = $data . $stringDelimeter .'Własny' . $stringDelimeter . $separator;
				}
				if (P('show_export_wewnetrzny', "1") != "0") {
					$data = $data . $stringDelimeter .'Wewnętrzny' . $stringDelimeter . $separator;
				}
				if (P('show_export_korekta', "1") != "0") {
					$data = $data . $stringDelimeter .'Korekta' . $stringDelimeter . $separator;
				}
				if (P('show_export_zastepczy', "1") != "0") {
					$data = $data . $stringDelimeter .'Zastępczy' . $stringDelimeter . $separator;
				}
				if (P('show_export_ostatni_numer', "1") != "0") {
					$data = $data . $stringDelimeter .'Ostatni numer' . $stringDelimeter . $separator;
				}
				if (P('show_export_numeracja_rok', "1") != "0") {
					$data = $data . $stringDelimeter .'Numeracja rok' . $stringDelimeter . $separator;
				}
				if (P('show_export_grupa_dokumentow', "1") != "0") {
					$data = $data . $stringDelimeter . 'Grupa dokumentów ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_rodzaje_dokumentow.rdk_id, slk_rodzaje_dokumentow.rdk_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_nazwa', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_nazwa rdk_nazwa";
			} else {
				if ($defaultOrderColumn == "rdk_nazwa") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_nazwa ";
				}
			}
			if (P('show_export_symbol', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_symbol rdk_symbol";
			} else {
				if ($defaultOrderColumn == "rdk_symbol") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_symbol ";
				}
			}
			if (P('show_export_zwiekszajacy', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_zwiekszajacy rdk_zwiekszajacy";
			} else {
				if ($defaultOrderColumn == "rdk_zwiekszajacy") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_zwiekszajacy ";
				}
			}
			if (P('show_export_wlasny', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_wlasny rdk_wlasny";
			} else {
				if ($defaultOrderColumn == "rdk_wlasny") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_wlasny ";
				}
			}
			if (P('show_export_wewnetrzny', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_wewnetrzny rdk_wewnetrzny";
			} else {
				if ($defaultOrderColumn == "rdk_wewnetrzny") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_wewnetrzny ";
				}
			}
			if (P('show_export_korekta', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_korekta rdk_korekta";
			} else {
				if ($defaultOrderColumn == "rdk_korekta") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_korekta ";
				}
			}
			if (P('show_export_zastepczy', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_zastepczy rdk_zastepczy";
			} else {
				if ($defaultOrderColumn == "rdk_zastepczy") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_zastepczy ";
				}
			}
			if (P('show_export_ostatni_numer', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_ostatni_numer rdk_ostatni_numer";
			} else {
				if ($defaultOrderColumn == "rdk_ostatni_numer") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_ostatni_numer ";
				}
			}
			if (P('show_export_numeracja_rok', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_numeracja_rok rdk_numeracja_rok";
			} else {
				if ($defaultOrderColumn == "rdk_numeracja_rok") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_numeracja_rok ";
				}
			}
			if (class_exists('sealock\virgoGrupaDokumentow') && P('show_export_grupa_dokumentow', "1") != "0") { // */ && !in_array("gdk", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_gdk_id as rdk_gdk_id ";
				$queryString = $queryString . ", slk_grupy_dokumentow_parent.gdk_virgo_title as `grupa_dokumentow` ";
			} else {
				if ($defaultOrderColumn == "grupa_dokumentow") {
					$orderColumnNotDisplayed = " slk_grupy_dokumentow_parent.gdk_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_rodzaje_dokumentow ";
			if (class_exists('sealock\virgoGrupaDokumentow')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_grupy_dokumentow AS slk_grupy_dokumentow_parent ON (slk_rodzaje_dokumentow.rdk_gdk_id = slk_grupy_dokumentow_parent.gdk_id) ";
			}

			$resultsRodzajDokumentu = $resultRodzajDokumentu->select(
				'', 
				'all', 
				$resultRodzajDokumentu->getOrderColumn(), 
				$resultRodzajDokumentu->getOrderMode(), 
				$whereClauseRodzajDokumentu,
				$queryString);
			foreach ($resultsRodzajDokumentu as $resultRodzajDokumentu) {
				if (P('show_export_nazwa', "1") != "0") {
			$data = $data . $stringDelimeter . $resultRodzajDokumentu['rdk_nazwa'] . $stringDelimeter . $separator;
				}
				if (P('show_export_symbol', "1") != "0") {
			$data = $data . $stringDelimeter . $resultRodzajDokumentu['rdk_symbol'] . $stringDelimeter . $separator;
				}
				if (P('show_export_zwiekszajacy', "1") != "0") {
			$data = $data . $resultRodzajDokumentu['rdk_zwiekszajacy'] . $separator;
				}
				if (P('show_export_wlasny', "1") != "0") {
			$data = $data . $resultRodzajDokumentu['rdk_wlasny'] . $separator;
				}
				if (P('show_export_wewnetrzny', "1") != "0") {
			$data = $data . $resultRodzajDokumentu['rdk_wewnetrzny'] . $separator;
				}
				if (P('show_export_korekta', "1") != "0") {
			$data = $data . $resultRodzajDokumentu['rdk_korekta'] . $separator;
				}
				if (P('show_export_zastepczy', "1") != "0") {
			$data = $data . $resultRodzajDokumentu['rdk_zastepczy'] . $separator;
				}
				if (P('show_export_ostatni_numer', "1") != "0") {
			$data = $data . $resultRodzajDokumentu['rdk_ostatni_numer'] . $separator;
				}
				if (P('show_export_numeracja_rok', "1") != "0") {
			$data = $data . $resultRodzajDokumentu['rdk_numeracja_rok'] . $separator;
				}
				if (P('show_export_grupa_dokumentow', "1") != "0") {
					$parentValue = virgoGrupaDokumentow::lookup($resultRodzajDokumentu['rdk_gdk_id']);
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
				$reportTitle = T('RODZAJE_DOKUMENTOW');
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
			$resultRodzajDokumentu = new virgoRodzajDokumentu();
			$whereClauseRodzajDokumentu = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_nazwa', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Nazwa');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_symbol', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Symbol');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_zwiekszajacy', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Zwiększający');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_wlasny', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Własny');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_wewnetrzny', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Wewnętrzny');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_korekta', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Korekta');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_zastepczy', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Zastępczy');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_ostatni_numer', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Ostatni numer');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_numeracja_rok', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Numeracja rok');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_grupa_dokumentow', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Grupa dokumentów ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoGrupaDokumentow::getVirgoList();
					$formulaGrupaDokumentow = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaGrupaDokumentow != "") {
							$formulaGrupaDokumentow = $formulaGrupaDokumentow . ',';
						}
						$formulaGrupaDokumentow = $formulaGrupaDokumentow . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_rodzaje_dokumentow.rdk_id, slk_rodzaje_dokumentow.rdk_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_nazwa', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_nazwa rdk_nazwa";
			} else {
				if ($defaultOrderColumn == "rdk_nazwa") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_nazwa ";
				}
			}
			if (P('show_export_symbol', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_symbol rdk_symbol";
			} else {
				if ($defaultOrderColumn == "rdk_symbol") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_symbol ";
				}
			}
			if (P('show_export_zwiekszajacy', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_zwiekszajacy rdk_zwiekszajacy";
			} else {
				if ($defaultOrderColumn == "rdk_zwiekszajacy") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_zwiekszajacy ";
				}
			}
			if (P('show_export_wlasny', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_wlasny rdk_wlasny";
			} else {
				if ($defaultOrderColumn == "rdk_wlasny") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_wlasny ";
				}
			}
			if (P('show_export_wewnetrzny', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_wewnetrzny rdk_wewnetrzny";
			} else {
				if ($defaultOrderColumn == "rdk_wewnetrzny") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_wewnetrzny ";
				}
			}
			if (P('show_export_korekta', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_korekta rdk_korekta";
			} else {
				if ($defaultOrderColumn == "rdk_korekta") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_korekta ";
				}
			}
			if (P('show_export_zastepczy', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_zastepczy rdk_zastepczy";
			} else {
				if ($defaultOrderColumn == "rdk_zastepczy") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_zastepczy ";
				}
			}
			if (P('show_export_ostatni_numer', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_ostatni_numer rdk_ostatni_numer";
			} else {
				if ($defaultOrderColumn == "rdk_ostatni_numer") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_ostatni_numer ";
				}
			}
			if (P('show_export_numeracja_rok', "1") != "0") {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_numeracja_rok rdk_numeracja_rok";
			} else {
				if ($defaultOrderColumn == "rdk_numeracja_rok") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow.rdk_numeracja_rok ";
				}
			}
			if (class_exists('sealock\virgoGrupaDokumentow') && P('show_export_grupa_dokumentow', "1") != "0") { // */ && !in_array("gdk", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_rodzaje_dokumentow.rdk_gdk_id as rdk_gdk_id ";
				$queryString = $queryString . ", slk_grupy_dokumentow_parent.gdk_virgo_title as `grupa_dokumentow` ";
			} else {
				if ($defaultOrderColumn == "grupa_dokumentow") {
					$orderColumnNotDisplayed = " slk_grupy_dokumentow_parent.gdk_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_rodzaje_dokumentow ";
			if (class_exists('sealock\virgoGrupaDokumentow')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_grupy_dokumentow AS slk_grupy_dokumentow_parent ON (slk_rodzaje_dokumentow.rdk_gdk_id = slk_grupy_dokumentow_parent.gdk_id) ";
			}

			$resultsRodzajDokumentu = $resultRodzajDokumentu->select(
				'', 
				'all', 
				$resultRodzajDokumentu->getOrderColumn(), 
				$resultRodzajDokumentu->getOrderMode(), 
				$whereClauseRodzajDokumentu,
				$queryString);
			$index = 1;
			foreach ($resultsRodzajDokumentu as $resultRodzajDokumentu) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultRodzajDokumentu['rdk_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_nazwa', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultRodzajDokumentu['rdk_nazwa'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_symbol', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultRodzajDokumentu['rdk_symbol'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_zwiekszajacy', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultRodzajDokumentu['rdk_zwiekszajacy'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_wlasny', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultRodzajDokumentu['rdk_wlasny'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_wewnetrzny', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultRodzajDokumentu['rdk_wewnetrzny'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_korekta', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultRodzajDokumentu['rdk_korekta'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_zastepczy', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultRodzajDokumentu['rdk_zastepczy'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_ostatni_numer', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultRodzajDokumentu['rdk_ostatni_numer'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_numeracja_rok', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultRodzajDokumentu['rdk_numeracja_rok'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_grupa_dokumentow', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoGrupaDokumentow::lookup($resultRodzajDokumentu['rdk_gdk_id']);
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
					$objValidation->setFormula1('"' . $formulaGrupaDokumentow . '"');
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
					$propertyColumnHash['nazwa'] = 'rdk_nazwa';
					$propertyColumnHash['nazwa'] = 'rdk_nazwa';
					$propertyColumnHash['symbol'] = 'rdk_symbol';
					$propertyColumnHash['symbol'] = 'rdk_symbol';
					$propertyColumnHash['zwi\u0119kszaj\u0105cy'] = 'rdk_zwiekszajacy';
					$propertyColumnHash['zwiekszajacy'] = 'rdk_zwiekszajacy';
					$propertyColumnHash['w\u0142asny'] = 'rdk_wlasny';
					$propertyColumnHash['wlasny'] = 'rdk_wlasny';
					$propertyColumnHash['wewn\u0119trzny'] = 'rdk_wewnetrzny';
					$propertyColumnHash['wewnetrzny'] = 'rdk_wewnetrzny';
					$propertyColumnHash['korekta'] = 'rdk_korekta';
					$propertyColumnHash['korekta'] = 'rdk_korekta';
					$propertyColumnHash['zast\u0119pczy'] = 'rdk_zastepczy';
					$propertyColumnHash['zastepczy'] = 'rdk_zastepczy';
					$propertyColumnHash['ostatni numer'] = 'rdk_ostatni_numer';
					$propertyColumnHash['ostatni_numer'] = 'rdk_ostatni_numer';
					$propertyColumnHash['numeracja rok'] = 'rdk_numeracja_rok';
					$propertyColumnHash['numeracja_rok'] = 'rdk_numeracja_rok';
					$propertyClassHash['grupa dokument\u00F3w'] = 'GrupaDokumentow';
					$propertyClassHash['grupa_dokumentow'] = 'GrupaDokumentow';
					$propertyColumnHash['grupa dokument\u00F3w'] = 'rdk_gdk_id';
					$propertyColumnHash['grupa_dokumentow'] = 'rdk_gdk_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importRodzajDokumentu = new virgoRodzajDokumentu();
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
										L(T('PROPERTY_NOT_FOUND', T('RODZAJ_DOKUMENTU'), $columns[$index]), '', 'ERROR');
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
										$importRodzajDokumentu->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_grupa_dokumentow');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoGrupaDokumentow::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoGrupaDokumentow::token2Id($tmpToken);
	}
	$importRodzajDokumentu->setGdkId($defaultValue);
}
							$errorMessage = $importRodzajDokumentu->store();
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
		

		static function portletActionVirgoChangeGrupaDokumentow() {
			$instance = new virgoRodzajDokumentu();
			$instance->loadFromDB();
			self::portletActionSelect(true, $instance->getId());
			$parentId = R('virgo_parent_id');
			$parent = virgoGrupaDokumentow::getById($parentId);
			$title = $parent->getVirgoTitle();
			if (!is_null($title) && trim($title) != "") {
				$instance->setGdkId($parentId);
				$errorMessage = $instance->store();
				if ($errorMessage == "") {
					L(T('PARENT_SET', T('GRUPA_DOKUMENTOW'), $title), '', 'INFO');
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



		static function portletActionVirgoSetGrupaDokumentow() {
			$this->loadFromDB();
			$parentId = R('rdk_GrupaDokumentow_id_' . $_SESSION['current_portlet_object_id']);
			$this->setGdkId($parentId);
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

			private function returnError($text) {
				return array($text);
			}

			public function ustawNastepnyNumer(virgoDokumentKsiegowy $dokumentKsiegowy) {

				if (is_null($dokumentKsiegowy)) {
					return $this->returnError("Brak dokumentu");
				}

				if (!is_null($dokumentKsiegowy->getId()) && $dokumentKsiegowy->getId() != "") {
					return $this->returnError("Dokument jest już zapisany");
				}

				if (!is_null($dokumentKsiegowy->getNumer())) {
					return $this->returnError("Dokument już ma numer");
				}

				$dataWystawienia = $dokumentKsiegowy->getDataWystawienia();

				if (is_null($dataWystawienia)) {
					return $this->returnError("Dokument nie ma daty wystawienia");
				}

				$rokWystawienia = date('Y', strtotime($dataWystawienia));

				if (is_null($rokWystawienia)) {
					return $this->returnError("Brak roku wystawienia");
				}

				$numeracjaRok = $this->getNumeracjaRok();
				if (!S($numeracjaRok)) {
					$this->setNumeracjaRok($rokWystawienia);
					$numeracjaRok = $this->getNumeracjaRok();
				}

				if ($numeracjaRok > $rokWystawienia) {
					return $this->returnError("Nie można wygenerować numeru dokumentu na rok {$rokWystawienia}, ponieważ aktualnym rokiem numeracji jest {$numeracjaRok}.");
				}

				if ($numeracjaRok < $rokWystawienia) {
					$this->setNumeracjaRok($rokWystawienia);
					$this->setOstatniNumer(0);
				}

				if (is_null($this->getOstatniNumer())) {
					$this->setOstatniNumer(0);					
				}

				$this->setOstatniNumer($this->getOstatniNumer() + 1);
				$error = $this->store();
				if ($error != "") {
					return $error;
				}

				$format = PP('DOCUMENT_NUMBER_FORMAT');
				$nowyNumer = sprintf($format, $this->getSymbol(), $this->getOstatniNumer(), $this->getNumeracjaRok());
				return $nowyNumer;
			}




		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `slk_rodzaje_dokumentow` (
  `rdk_id` bigint(20) unsigned NOT NULL auto_increment,
  `rdk_virgo_state` varchar(50) default NULL,
  `rdk_virgo_title` varchar(255) default NULL,
	`rdk_gdk_id` int(11) default NULL,
  `rdk_nazwa` varchar(255), 
  `rdk_symbol` varchar(255), 
  `rdk_zwiekszajacy` boolean,  
  `rdk_wlasny` boolean,  
  `rdk_wewnetrzny` boolean,  
  `rdk_korekta` boolean,  
  `rdk_zastepczy` boolean,  
  `rdk_ostatni_numer` integer,  
  `rdk_numeracja_rok` integer,  
  `rdk_date_created` datetime NOT NULL,
  `rdk_date_modified` datetime default NULL,
  `rdk_usr_created_id` int(11) NOT NULL,
  `rdk_usr_modified_id` int(11) default NULL,
  KEY `rdk_gdk_fk` (`rdk_gdk_id`),
  PRIMARY KEY  (`rdk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/rodzaj_dokumentu.sql 
INSERT INTO `slk_rodzaje_dokumentow` (`rdk_virgo_title`, `rdk_nazwa`, `rdk_symbol`, `rdk_zwiekszajacy`, `rdk_wlasny`, `rdk_wewnetrzny`, `rdk_korekta`, `rdk_zastepczy`, `rdk_ostatni_numer`, `rdk_numeracja_rok`) 
VALUES (title, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably slk_rodzaje_dokumentow table already exists.", '', 'FATAL');
				L("Error ocurred, please contact site Administrator.", '', 'ERROR');
 				return false;
 			}
 			return true;
 		}


		static function onInstall($pobId, $title) {
		}

		static function getIdByKeySymbol($symbol) {
			$query = " SELECT rdk_id FROM slk_rodzaje_dokumentow WHERE 1 ";
			$query .= " AND rdk_symbol = '{$symbol}' ";
			$rows = QR($query);
			foreach ($rows as $row) {
				return $row['rdk_id'];
			}
			return null;
		}

		static function getByKeySymbol($symbol) {
			$id = self::getIdByKeySymbol($symbol);
			$ret = new virgoRodzajDokumentu();
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
			return "rdk";
		}
		
		static function getPlural() {
			return "rodzaje_dokumentow";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoGrupaDokumentow";
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoDokumentKsiegowy";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'slk_rodzaje_dokumentow'));
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
			$virgoVersion = virgoRodzajDokumentu::getVirgoVersion();
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
	
	

