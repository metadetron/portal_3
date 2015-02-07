<?php
/**
* Module User
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
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoSystemMessage'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoUser {

		 var  $usr_id = null;
		 var  $usr_username = null;

		 var  $usr_password = null;

		 var  $usr_email = null;

		 var  $usr_first_name = null;

		 var  $usr_last_name = null;

		 var  $usr_session_id = null;

		 var  $usr_ip = null;

		 var  $usr_logged_in = null;

		 var  $usr_last_successful_login = null;

		 var  $usr_last_failed_login = null;

		 var  $usr_last_logout = null;

		 var  $usr_user_agent = null;

		 var  $usr_token = null;

		 var  $usr_unidentified = null;

		 var  $usr_confirmed = null;

		 var  $usr_accepted = null;

		 var  $usr_pge_id = null;

		 var   $_roleIdsToAddArray = null;
		 var   $_roleIdsToDeleteArray = null;
		 var   $usr_date_created = null;
		 var   $usr_usr_created_id = null;
		 var   $usr_date_modified = null;
		 var   $usr_usr_modified_id = null;
		 var   $usr_virgo_title = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		public function isDeletedVirgo() {
			return $this->usr_virgo_deleted;
		}

		static public function createGuiAware() {
			$ret = new virgoUser();
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
        	$this->usr_id = null;
		    $this->usr_date_created = null;
		    $this->usr_usr_created_id = null;
		    $this->usr_date_modified = null;
		    $this->usr_usr_modified_id = null;
		    $this->usr_virgo_title = null;
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
			return $this->usr_id;
		}

		function getUsername() {
			return $this->usr_username;
		}
		
		 function setUsername($val) {
			$this->usr_username = $val;
		}
		function getPassword() {
			return $this->usr_password;
		}
		
		 function setPassword($val) {
			$this->usr_password = $val;
		}
		function getEmail() {
			return $this->usr_email;
		}
		
		 function setEmail($val) {
			$this->usr_email = $val;
		}
		function getFirstName() {
			return $this->usr_first_name;
		}
		
		 function setFirstName($val) {
			$this->usr_first_name = $val;
		}
		function getLastName() {
			return $this->usr_last_name;
		}
		
		 function setLastName($val) {
			$this->usr_last_name = $val;
		}
		function getSessionId() {
			return $this->usr_session_id;
		}
		
		 function setSessionId($val) {
			$this->usr_session_id = $val;
		}
		function getIp() {
			return $this->usr_ip;
		}
		
		 function setIp($val) {
			$this->usr_ip = $val;
		}
		function getLoggedIn() {
			return $this->usr_logged_in;
		}
		
		 function setLoggedIn($val) {
			$this->usr_logged_in = $val;
		}
		function getLastSuccessfulLogin() {
			return $this->usr_last_successful_login;
		}
		
		 function setLastSuccessfulLogin($val) {
			$this->usr_last_successful_login = $val;
		}
		function getLastFailedLogin() {
			return $this->usr_last_failed_login;
		}
		
		 function setLastFailedLogin($val) {
			$this->usr_last_failed_login = $val;
		}
		function getLastLogout() {
			return $this->usr_last_logout;
		}
		
		 function setLastLogout($val) {
			$this->usr_last_logout = $val;
		}
		function getUserAgent() {
			return $this->usr_user_agent;
		}
		
		 function setUserAgent($val) {
			$this->usr_user_agent = $val;
		}
		function getToken() {
			return $this->usr_token;
		}
		
		 function setToken($val) {
			$this->usr_token = $val;
		}
		function getUnidentified() {
			return $this->usr_unidentified;
		}
		
		 function setUnidentified($val) {
			$this->usr_unidentified = $val;
		}
		function getConfirmed() {
			return $this->usr_confirmed;
		}
		
		 function setConfirmed($val) {
			$this->usr_confirmed = $val;
		}
		function getAccepted() {
			return $this->usr_accepted;
		}
		
		 function setAccepted($val) {
			$this->usr_accepted = $val;
		}

		function getPageId() {
			return $this->usr_pge_id;
		}
		
		 function setPageId($val) {
			$this->usr_pge_id = $val;
		}

		function getDateCreated() {
			return $this->usr_date_created;
		}
		function getUsrCreatedId() {
			return $this->usr_usr_created_id;
		}
		function getDateModified() {
			return $this->usr_date_modified;
		}
		function getUsrModifiedId() {
			return $this->usr_usr_modified_id;
		}


		function getPgeId() {
			return $this->getPageId();
		}
		
		 function setPgeId($val) {
			$this->setPageId($val);
		}

		function loadRecordFromRequest($rowId) {
			$this->usr_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('usr_username_' . $this->usr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->usr_username = null;
		} else {
			$this->usr_username = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('usr_password_' . $this->usr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->usr_password = null;
		} else {
			$this->usr_password = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('usr_email_' . $this->usr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->usr_email = null;
		} else {
			$this->usr_email = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('usr_firstName_' . $this->usr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->usr_first_name = null;
		} else {
			$this->usr_first_name = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('usr_lastName_' . $this->usr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->usr_last_name = null;
		} else {
			$this->usr_last_name = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('usr_sessionId_' . $this->usr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->usr_session_id = null;
		} else {
			$this->usr_session_id = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('usr_ip_' . $this->usr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->usr_ip = null;
		} else {
			$this->usr_ip = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('usr_loggedIn_' . $this->usr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->usr_logged_in = null;
		} else {
			$this->usr_logged_in = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('usr_lastSuccessfulLogin_' . $this->usr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->usr_last_successful_login = null;
		} else {
			$this->usr_last_successful_login = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('usr_lastFailedLogin_' . $this->usr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->usr_last_failed_login = null;
		} else {
			$this->usr_last_failed_login = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('usr_lastLogout_' . $this->usr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->usr_last_logout = null;
		} else {
			$this->usr_last_logout = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('usr_userAgent_' . $this->usr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->usr_user_agent = null;
		} else {
			$this->usr_user_agent = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('usr_token_' . $this->usr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->usr_token = null;
		} else {
			$this->usr_token = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('usr_unidentified_' . $this->usr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->usr_unidentified = null;
		} else {
			$this->usr_unidentified = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('usr_confirmed_' . $this->usr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->usr_confirmed = null;
		} else {
			$this->usr_confirmed = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('usr_accepted_' . $this->usr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->usr_accepted = null;
		} else {
			$this->usr_accepted = $tmpValue;
		}
	}

			$this->usr_pge_id = strval(R('usr_page_' . $this->usr_id));
			$tmp_ids = R('usr_userRole_' . $this->usr_id, null); 			if (is_null($tmp_ids)) {
				$tmp_ids = array();
			}
			if (is_array($tmp_ids)) { 
				$this->_roleIdsToAddArray = $tmp_ids;
				$this->_roleIdsToDeleteArray = array();
				$currentConnections = $this->getUserRoles();
				foreach ($currentConnections as $currentConnection) {
					if (in_array($currentConnection->getRoleId(), $tmp_ids)) {
						foreach($this->_roleIdsToAddArray as $key => $value) {
							if ($value == $currentConnection->getRoleId()) {
								unset($this->_roleIdsToAddArray[$key]);
							}
						}
						$this->_roleIdsToAddArray = array_values($this->_roleIdsToAddArray);
					} else {
						$this->_roleIdsToDeleteArray[] = $currentConnection->getRoleId();
					}
				}
			}
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('usr_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaUser = array();	
			$criteriaFieldUser = array();	
			$isNullUser = R('virgo_search_username_is_null');
			
			$criteriaFieldUser["is_null"] = 0;
			if ($isNullUser == "not_null") {
				$criteriaFieldUser["is_null"] = 1;
			} elseif ($isNullUser == "null") {
				$criteriaFieldUser["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_username');

//			if ($isSet) {
			$criteriaFieldUser["value"] = $dataTypeCriteria;
//			}
			$criteriaUser["username"] = $criteriaFieldUser;
			$criteriaFieldUser = array();	
			$isNullUser = R('virgo_search_password_is_null');
			
			$criteriaFieldUser["is_null"] = 0;
			if ($isNullUser == "not_null") {
				$criteriaFieldUser["is_null"] = 1;
			} elseif ($isNullUser == "null") {
				$criteriaFieldUser["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
//			if ($isSet) {
			$criteriaFieldUser["value"] = $dataTypeCriteria;
//			}
			$criteriaUser["password"] = $criteriaFieldUser;
			$criteriaFieldUser = array();	
			$isNullUser = R('virgo_search_email_is_null');
			
			$criteriaFieldUser["is_null"] = 0;
			if ($isNullUser == "not_null") {
				$criteriaFieldUser["is_null"] = 1;
			} elseif ($isNullUser == "null") {
				$criteriaFieldUser["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_email');

//			if ($isSet) {
			$criteriaFieldUser["value"] = $dataTypeCriteria;
//			}
			$criteriaUser["email"] = $criteriaFieldUser;
			$criteriaFieldUser = array();	
			$isNullUser = R('virgo_search_firstName_is_null');
			
			$criteriaFieldUser["is_null"] = 0;
			if ($isNullUser == "not_null") {
				$criteriaFieldUser["is_null"] = 1;
			} elseif ($isNullUser == "null") {
				$criteriaFieldUser["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_firstName');

//			if ($isSet) {
			$criteriaFieldUser["value"] = $dataTypeCriteria;
//			}
			$criteriaUser["first_name"] = $criteriaFieldUser;
			$criteriaFieldUser = array();	
			$isNullUser = R('virgo_search_lastName_is_null');
			
			$criteriaFieldUser["is_null"] = 0;
			if ($isNullUser == "not_null") {
				$criteriaFieldUser["is_null"] = 1;
			} elseif ($isNullUser == "null") {
				$criteriaFieldUser["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_lastName');

//			if ($isSet) {
			$criteriaFieldUser["value"] = $dataTypeCriteria;
//			}
			$criteriaUser["last_name"] = $criteriaFieldUser;
			$criteriaFieldUser = array();	
			$isNullUser = R('virgo_search_sessionId_is_null');
			
			$criteriaFieldUser["is_null"] = 0;
			if ($isNullUser == "not_null") {
				$criteriaFieldUser["is_null"] = 1;
			} elseif ($isNullUser == "null") {
				$criteriaFieldUser["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_sessionId');

//			if ($isSet) {
			$criteriaFieldUser["value"] = $dataTypeCriteria;
//			}
			$criteriaUser["session_id"] = $criteriaFieldUser;
			$criteriaFieldUser = array();	
			$isNullUser = R('virgo_search_ip_is_null');
			
			$criteriaFieldUser["is_null"] = 0;
			if ($isNullUser == "not_null") {
				$criteriaFieldUser["is_null"] = 1;
			} elseif ($isNullUser == "null") {
				$criteriaFieldUser["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_ip');

//			if ($isSet) {
			$criteriaFieldUser["value"] = $dataTypeCriteria;
//			}
			$criteriaUser["ip"] = $criteriaFieldUser;
			$criteriaFieldUser = array();	
			$isNullUser = R('virgo_search_loggedIn_is_null');
			
			$criteriaFieldUser["is_null"] = 0;
			if ($isNullUser == "not_null") {
				$criteriaFieldUser["is_null"] = 1;
			} elseif ($isNullUser == "null") {
				$criteriaFieldUser["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_loggedIn');

//			if ($isSet) {
			$criteriaFieldUser["value"] = $dataTypeCriteria;
//			}
			$criteriaUser["logged_in"] = $criteriaFieldUser;
			$criteriaFieldUser = array();	
			$isNullUser = R('virgo_search_lastSuccessfulLogin_is_null');
			
			$criteriaFieldUser["is_null"] = 0;
			if ($isNullUser == "not_null") {
				$criteriaFieldUser["is_null"] = 1;
			} elseif ($isNullUser == "null") {
				$criteriaFieldUser["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_lastSuccessfulLogin_from');
		$dataTypeCriteria["to"] = R('virgo_search_lastSuccessfulLogin_to');

//			if ($isSet) {
			$criteriaFieldUser["value"] = $dataTypeCriteria;
//			}
			$criteriaUser["last_successful_login"] = $criteriaFieldUser;
			$criteriaFieldUser = array();	
			$isNullUser = R('virgo_search_lastFailedLogin_is_null');
			
			$criteriaFieldUser["is_null"] = 0;
			if ($isNullUser == "not_null") {
				$criteriaFieldUser["is_null"] = 1;
			} elseif ($isNullUser == "null") {
				$criteriaFieldUser["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_lastFailedLogin_from');
		$dataTypeCriteria["to"] = R('virgo_search_lastFailedLogin_to');

//			if ($isSet) {
			$criteriaFieldUser["value"] = $dataTypeCriteria;
//			}
			$criteriaUser["last_failed_login"] = $criteriaFieldUser;
			$criteriaFieldUser = array();	
			$isNullUser = R('virgo_search_lastLogout_is_null');
			
			$criteriaFieldUser["is_null"] = 0;
			if ($isNullUser == "not_null") {
				$criteriaFieldUser["is_null"] = 1;
			} elseif ($isNullUser == "null") {
				$criteriaFieldUser["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_lastLogout_from');
		$dataTypeCriteria["to"] = R('virgo_search_lastLogout_to');

//			if ($isSet) {
			$criteriaFieldUser["value"] = $dataTypeCriteria;
//			}
			$criteriaUser["last_logout"] = $criteriaFieldUser;
			$criteriaFieldUser = array();	
			$isNullUser = R('virgo_search_userAgent_is_null');
			
			$criteriaFieldUser["is_null"] = 0;
			if ($isNullUser == "not_null") {
				$criteriaFieldUser["is_null"] = 1;
			} elseif ($isNullUser == "null") {
				$criteriaFieldUser["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_userAgent');

//			if ($isSet) {
			$criteriaFieldUser["value"] = $dataTypeCriteria;
//			}
			$criteriaUser["user_agent"] = $criteriaFieldUser;
			$criteriaFieldUser = array();	
			$isNullUser = R('virgo_search_token_is_null');
			
			$criteriaFieldUser["is_null"] = 0;
			if ($isNullUser == "not_null") {
				$criteriaFieldUser["is_null"] = 1;
			} elseif ($isNullUser == "null") {
				$criteriaFieldUser["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_token');

//			if ($isSet) {
			$criteriaFieldUser["value"] = $dataTypeCriteria;
//			}
			$criteriaUser["token"] = $criteriaFieldUser;
			$criteriaFieldUser = array();	
			$isNullUser = R('virgo_search_unidentified_is_null');
			
			$criteriaFieldUser["is_null"] = 0;
			if ($isNullUser == "not_null") {
				$criteriaFieldUser["is_null"] = 1;
			} elseif ($isNullUser == "null") {
				$criteriaFieldUser["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_unidentified');

//			if ($isSet) {
			$criteriaFieldUser["value"] = $dataTypeCriteria;
//			}
			$criteriaUser["unidentified"] = $criteriaFieldUser;
			$criteriaFieldUser = array();	
			$isNullUser = R('virgo_search_confirmed_is_null');
			
			$criteriaFieldUser["is_null"] = 0;
			if ($isNullUser == "not_null") {
				$criteriaFieldUser["is_null"] = 1;
			} elseif ($isNullUser == "null") {
				$criteriaFieldUser["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_confirmed');

//			if ($isSet) {
			$criteriaFieldUser["value"] = $dataTypeCriteria;
//			}
			$criteriaUser["confirmed"] = $criteriaFieldUser;
			$criteriaFieldUser = array();	
			$isNullUser = R('virgo_search_accepted_is_null');
			
			$criteriaFieldUser["is_null"] = 0;
			if ($isNullUser == "not_null") {
				$criteriaFieldUser["is_null"] = 1;
			} elseif ($isNullUser == "null") {
				$criteriaFieldUser["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_accepted');

//			if ($isSet) {
			$criteriaFieldUser["value"] = $dataTypeCriteria;
//			}
			$criteriaUser["accepted"] = $criteriaFieldUser;
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
			$criteriaUser["page"] = $criteriaParent;
			$parent = R('virgo_search_role', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
				$criteriaUser["role"] = $criteriaParent;
			}
			self::setCriteria($criteriaUser);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_username');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterUsername', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterUsername', null);
			}
			$tableFilter = R('virgo_filter_password');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterPassword', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterPassword', null);
			}
			$tableFilter = R('virgo_filter_email');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterEmail', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterEmail', null);
			}
			$tableFilter = R('virgo_filter_first_name');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterFirstName', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterFirstName', null);
			}
			$tableFilter = R('virgo_filter_last_name');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterLastName', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterLastName', null);
			}
			$tableFilter = R('virgo_filter_session_id');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterSessionId', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterSessionId', null);
			}
			$tableFilter = R('virgo_filter_ip');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterIp', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterIp', null);
			}
			$tableFilter = R('virgo_filter_logged_in');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterLoggedIn', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterLoggedIn', null);
			}
			$tableFilter = R('virgo_filter_last_successful_login');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterLastSuccessfulLogin', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterLastSuccessfulLogin', null);
			}
			$tableFilter = R('virgo_filter_last_failed_login');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterLastFailedLogin', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterLastFailedLogin', null);
			}
			$tableFilter = R('virgo_filter_last_logout');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterLastLogout', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterLastLogout', null);
			}
			$tableFilter = R('virgo_filter_user_agent');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterUserAgent', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterUserAgent', null);
			}
			$tableFilter = R('virgo_filter_token');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterToken', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterToken', null);
			}
			$tableFilter = R('virgo_filter_unidentified');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterUnidentified', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterUnidentified', null);
			}
			$tableFilter = R('virgo_filter_confirmed');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterConfirmed', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterConfirmed', null);
			}
			$tableFilter = R('virgo_filter_accepted');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterAccepted', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterAccepted', null);
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
			$whereClauseUser = ' 1 = 1 ';
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
				$eventColumn = "usr_" . P('event_column');
				$whereClauseUser = $whereClauseUser . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseUser = $whereClauseUser . ' AND ' . $parentContextInfo['condition'];
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
					$inCondition = " prt_users.usr_pge_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_users.usr_pge_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseUser = $whereClauseUser . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaUser = self::getCriteria();
			if (isset($criteriaUser["username"])) {
				$fieldCriteriaUsername = $criteriaUser["username"];
				if ($fieldCriteriaUsername["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_username IS NOT NULL ';
				} elseif ($fieldCriteriaUsername["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_username IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaUsername["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_users.usr_username like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUser["password"])) {
				$fieldCriteriaPassword = $criteriaUser["password"];
				if ($fieldCriteriaPassword["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_password IS NOT NULL ';
				} elseif ($fieldCriteriaPassword["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_password IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaPassword["value"];
				}
			}
			if (isset($criteriaUser["email"])) {
				$fieldCriteriaEmail = $criteriaUser["email"];
				if ($fieldCriteriaEmail["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_email IS NOT NULL ';
				} elseif ($fieldCriteriaEmail["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_email IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaEmail["value"];
				}
			}
			if (isset($criteriaUser["first_name"])) {
				$fieldCriteriaFirstName = $criteriaUser["first_name"];
				if ($fieldCriteriaFirstName["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_first_name IS NOT NULL ';
				} elseif ($fieldCriteriaFirstName["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_first_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaFirstName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_users.usr_first_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUser["last_name"])) {
				$fieldCriteriaLastName = $criteriaUser["last_name"];
				if ($fieldCriteriaLastName["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_last_name IS NOT NULL ';
				} elseif ($fieldCriteriaLastName["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_last_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaLastName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_users.usr_last_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUser["session_id"])) {
				$fieldCriteriaSessionId = $criteriaUser["session_id"];
				if ($fieldCriteriaSessionId["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_session_id IS NOT NULL ';
				} elseif ($fieldCriteriaSessionId["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_session_id IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaSessionId["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_users.usr_session_id like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUser["ip"])) {
				$fieldCriteriaIp = $criteriaUser["ip"];
				if ($fieldCriteriaIp["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_ip IS NOT NULL ';
				} elseif ($fieldCriteriaIp["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_ip IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaIp["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_users.usr_ip like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUser["logged_in"])) {
				$fieldCriteriaLoggedIn = $criteriaUser["logged_in"];
				if ($fieldCriteriaLoggedIn["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_logged_in IS NOT NULL ';
				} elseif ($fieldCriteriaLoggedIn["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_logged_in IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaLoggedIn["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_users.usr_logged_in = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaUser["last_successful_login"])) {
				$fieldCriteriaLastSuccessfulLogin = $criteriaUser["last_successful_login"];
				if ($fieldCriteriaLastSuccessfulLogin["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_last_successful_login IS NOT NULL ';
				} elseif ($fieldCriteriaLastSuccessfulLogin["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_last_successful_login IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaLastSuccessfulLogin["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND prt_users.usr_last_successful_login >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_users.usr_last_successful_login <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaUser["last_failed_login"])) {
				$fieldCriteriaLastFailedLogin = $criteriaUser["last_failed_login"];
				if ($fieldCriteriaLastFailedLogin["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_last_failed_login IS NOT NULL ';
				} elseif ($fieldCriteriaLastFailedLogin["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_last_failed_login IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaLastFailedLogin["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND prt_users.usr_last_failed_login >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_users.usr_last_failed_login <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaUser["last_logout"])) {
				$fieldCriteriaLastLogout = $criteriaUser["last_logout"];
				if ($fieldCriteriaLastLogout["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_last_logout IS NOT NULL ';
				} elseif ($fieldCriteriaLastLogout["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_last_logout IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaLastLogout["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND prt_users.usr_last_logout >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_users.usr_last_logout <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaUser["user_agent"])) {
				$fieldCriteriaUserAgent = $criteriaUser["user_agent"];
				if ($fieldCriteriaUserAgent["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_user_agent IS NOT NULL ';
				} elseif ($fieldCriteriaUserAgent["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_user_agent IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaUserAgent["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_users.usr_user_agent like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUser["token"])) {
				$fieldCriteriaToken = $criteriaUser["token"];
				if ($fieldCriteriaToken["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_token IS NOT NULL ';
				} elseif ($fieldCriteriaToken["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_token IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaToken["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_users.usr_token like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUser["unidentified"])) {
				$fieldCriteriaUnidentified = $criteriaUser["unidentified"];
				if ($fieldCriteriaUnidentified["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_unidentified IS NOT NULL ';
				} elseif ($fieldCriteriaUnidentified["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_unidentified IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaUnidentified["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_users.usr_unidentified = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaUser["confirmed"])) {
				$fieldCriteriaConfirmed = $criteriaUser["confirmed"];
				if ($fieldCriteriaConfirmed["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_confirmed IS NOT NULL ';
				} elseif ($fieldCriteriaConfirmed["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_confirmed IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaConfirmed["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_users.usr_confirmed = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaUser["accepted"])) {
				$fieldCriteriaAccepted = $criteriaUser["accepted"];
				if ($fieldCriteriaAccepted["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_accepted IS NOT NULL ';
				} elseif ($fieldCriteriaAccepted["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_accepted IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaAccepted["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_users.usr_accepted = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaUser["page"])) {
				$parentCriteria = $criteriaUser["page"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND usr_pge_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_users.usr_pge_id IN (SELECT pge_id FROM prt_pages WHERE pge_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaUser["role"])) {
				$parentCriteria = $criteriaUser["role"];
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$filter = $filter . " AND prt_users.usr_id IN (SELECT second_parent.url_usr_id FROM prt_user_roles AS second_parent WHERE second_parent.url_rle_id IN (" . implode(", ", $parentIds) . ")) ";
				}
			}
			$whereClauseUser = $whereClauseUser . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseUser = $whereClauseUser . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseUser = $whereClauseUser . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterUsername', null);
				if (S($tableFilter)) {
					$whereClauseUser = $whereClauseUser . " AND usr_username LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterPassword', null);
				if (S($tableFilter)) {
					$whereClauseUser = $whereClauseUser . " AND usr_password LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterEmail', null);
				if (S($tableFilter)) {
					$whereClauseUser = $whereClauseUser . " AND usr_email LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterFirstName', null);
				if (S($tableFilter)) {
					$whereClauseUser = $whereClauseUser . " AND usr_first_name LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterLastName', null);
				if (S($tableFilter)) {
					$whereClauseUser = $whereClauseUser . " AND usr_last_name LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterSessionId', null);
				if (S($tableFilter)) {
					$whereClauseUser = $whereClauseUser . " AND usr_session_id LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterIp', null);
				if (S($tableFilter)) {
					$whereClauseUser = $whereClauseUser . " AND usr_ip LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterLoggedIn', null);
				if (S($tableFilter)) {
					$whereClauseUser = $whereClauseUser . " AND usr_logged_in LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterLastSuccessfulLogin', null);
				if (S($tableFilter)) {
					$whereClauseUser = $whereClauseUser . " AND usr_last_successful_login LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterLastFailedLogin', null);
				if (S($tableFilter)) {
					$whereClauseUser = $whereClauseUser . " AND usr_last_failed_login LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterLastLogout', null);
				if (S($tableFilter)) {
					$whereClauseUser = $whereClauseUser . " AND usr_last_logout LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterUserAgent', null);
				if (S($tableFilter)) {
					$whereClauseUser = $whereClauseUser . " AND usr_user_agent LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterToken', null);
				if (S($tableFilter)) {
					$whereClauseUser = $whereClauseUser . " AND usr_token LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterUnidentified', null);
				if (S($tableFilter)) {
					$whereClauseUser = $whereClauseUser . " AND usr_unidentified LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterConfirmed', null);
				if (S($tableFilter)) {
					$whereClauseUser = $whereClauseUser . " AND usr_confirmed LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterAccepted', null);
				if (S($tableFilter)) {
					$whereClauseUser = $whereClauseUser . " AND usr_accepted LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterPage', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseUser = $whereClauseUser . " AND usr_pge_id IS NULL ";
					} else {
						$whereClauseUser = $whereClauseUser . " AND usr_pge_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitlePage', null);
				if (S($parentFilter)) {
					$whereClauseUser = $whereClauseUser . " AND prt_pages_parent.pge_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClauseUser;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseUser = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_users.usr_id, prt_users.usr_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_username', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_username usr_username";
			} else {
				if ($defaultOrderColumn == "usr_username") {
					$orderColumnNotDisplayed = " prt_users.usr_username ";
				}
			}
			if (P('show_table_password', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_password usr_password";
			} else {
				if ($defaultOrderColumn == "usr_password") {
					$orderColumnNotDisplayed = " prt_users.usr_password ";
				}
			}
			if (P('show_table_email', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_email usr_email";
			} else {
				if ($defaultOrderColumn == "usr_email") {
					$orderColumnNotDisplayed = " prt_users.usr_email ";
				}
			}
			if (P('show_table_first_name', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_first_name usr_first_name";
			} else {
				if ($defaultOrderColumn == "usr_first_name") {
					$orderColumnNotDisplayed = " prt_users.usr_first_name ";
				}
			}
			if (P('show_table_last_name', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_last_name usr_last_name";
			} else {
				if ($defaultOrderColumn == "usr_last_name") {
					$orderColumnNotDisplayed = " prt_users.usr_last_name ";
				}
			}
			if (P('show_table_session_id', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_session_id usr_session_id";
			} else {
				if ($defaultOrderColumn == "usr_session_id") {
					$orderColumnNotDisplayed = " prt_users.usr_session_id ";
				}
			}
			if (P('show_table_ip', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_ip usr_ip";
			} else {
				if ($defaultOrderColumn == "usr_ip") {
					$orderColumnNotDisplayed = " prt_users.usr_ip ";
				}
			}
			if (P('show_table_logged_in', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_logged_in usr_logged_in";
			} else {
				if ($defaultOrderColumn == "usr_logged_in") {
					$orderColumnNotDisplayed = " prt_users.usr_logged_in ";
				}
			}
			if (P('show_table_last_successful_login', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_last_successful_login usr_last_successful_login";
			} else {
				if ($defaultOrderColumn == "usr_last_successful_login") {
					$orderColumnNotDisplayed = " prt_users.usr_last_successful_login ";
				}
			}
			if (P('show_table_last_failed_login', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_last_failed_login usr_last_failed_login";
			} else {
				if ($defaultOrderColumn == "usr_last_failed_login") {
					$orderColumnNotDisplayed = " prt_users.usr_last_failed_login ";
				}
			}
			if (P('show_table_last_logout', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_last_logout usr_last_logout";
			} else {
				if ($defaultOrderColumn == "usr_last_logout") {
					$orderColumnNotDisplayed = " prt_users.usr_last_logout ";
				}
			}
			if (P('show_table_user_agent', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_user_agent usr_user_agent";
			} else {
				if ($defaultOrderColumn == "usr_user_agent") {
					$orderColumnNotDisplayed = " prt_users.usr_user_agent ";
				}
			}
			if (P('show_table_token', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_token usr_token";
			} else {
				if ($defaultOrderColumn == "usr_token") {
					$orderColumnNotDisplayed = " prt_users.usr_token ";
				}
			}
			if (P('show_table_unidentified', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_unidentified usr_unidentified";
			} else {
				if ($defaultOrderColumn == "usr_unidentified") {
					$orderColumnNotDisplayed = " prt_users.usr_unidentified ";
				}
			}
			if (P('show_table_confirmed', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_confirmed usr_confirmed";
			} else {
				if ($defaultOrderColumn == "usr_confirmed") {
					$orderColumnNotDisplayed = " prt_users.usr_confirmed ";
				}
			}
			if (P('show_table_accepted', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_accepted usr_accepted";
			} else {
				if ($defaultOrderColumn == "usr_accepted") {
					$orderColumnNotDisplayed = " prt_users.usr_accepted ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_table_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_users.usr_pge_id as usr_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_users ";
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_users.usr_pge_id = prt_pages_parent.pge_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseUser = $whereClauseUser . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseUser, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseUser,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_users"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " usr_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " usr_usr_created_id = ? ";
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
				. "\n FROM prt_users"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_users ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_users ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, usr_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " usr_usr_created_id = ? ";
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
				$query = "SELECT COUNT(usr_id) cnt FROM users";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as users ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as users ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoUser();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_users WHERE usr_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->usr_id = $row['usr_id'];
$this->usr_username = $row['usr_username'];
$this->usr_password = $row['usr_password'];
$this->usr_email = $row['usr_email'];
$this->usr_first_name = $row['usr_first_name'];
$this->usr_last_name = $row['usr_last_name'];
$this->usr_session_id = $row['usr_session_id'];
$this->usr_ip = $row['usr_ip'];
$this->usr_logged_in = $row['usr_logged_in'];
$this->usr_last_successful_login = $row['usr_last_successful_login'];
$this->usr_last_failed_login = $row['usr_last_failed_login'];
$this->usr_last_logout = $row['usr_last_logout'];
$this->usr_user_agent = $row['usr_user_agent'];
$this->usr_token = $row['usr_token'];
$this->usr_unidentified = $row['usr_unidentified'];
$this->usr_confirmed = $row['usr_confirmed'];
$this->usr_accepted = $row['usr_accepted'];
						$this->usr_pge_id = $row['usr_pge_id'];
						if ($fetchUsernames) {
							if ($row['usr_date_created']) {
								if ($row['usr_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['usr_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['usr_date_modified']) {
								if ($row['usr_usr_modified_id'] == $row['usr_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['usr_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['usr_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->usr_date_created = $row['usr_date_created'];
						$this->usr_usr_created_id = $fetchUsernames ? $createdBy : $row['usr_usr_created_id'];
						$this->usr_date_modified = $row['usr_date_modified'];
						$this->usr_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['usr_usr_modified_id'];
						$this->usr_virgo_title = $row['usr_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_users SET usr_usr_created_id = {$userId} WHERE usr_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->usr_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoUser::selectAllAsObjectsStatic('usr_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->usr_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->usr_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('usr_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_usr = new virgoUser();
				$tmp_usr->load((int)$lookup_id);
				return $tmp_usr->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoUser');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" usr_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoUser', "10");
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
				$query = $query . " usr_id as id, usr_virgo_title as title ";
			}
			$query = $query . " FROM prt_users ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoUser', 'portal') == "1") {
				$privateCondition = " usr_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY usr_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resUser = array();
				foreach ($rows as $row) {
					$resUser[$row['id']] = $row['title'];
				}
				return $resUser;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticUser = new virgoUser();
			return $staticUser->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getPageStatic($parentId) {
			return virgoPage::getById($parentId);
		}
		
		function getPage() {
			return virgoUser::getPageStatic($this->usr_pge_id);
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
			$instance = new virgoUserRole();
			$resultsUserRole = $instance->selectAll('url_usr_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsUserRole as $resultUserRole) {
				$tmpUserRole = virgoUserRole::getById($resultUserRole['url_id']); 
				array_push($resUserRole, $tmpUserRole);
			}
			return $resUserRole;
		}

		function getUserRoles($orderBy = '', $extraWhere = null) {
			return virgoUser::getUserRolesStatic($this->getId(), $orderBy, $extraWhere);
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
			$instance = new virgoSystemMessage();
			$resultsSystemMessage = $instance->selectAll('sms_usr_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsSystemMessage as $resultSystemMessage) {
				$tmpSystemMessage = virgoSystemMessage::getById($resultSystemMessage['sms_id']); 
				array_push($resSystemMessage, $tmpSystemMessage);
			}
			return $resSystemMessage;
		}

		function getSystemMessages($orderBy = '', $extraWhere = null) {
			return virgoUser::getSystemMessagesStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
			if (
(is_null($this->getUsername()) || trim($this->getUsername()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'USERNAME');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_password_obligatory', "0") == "1") {
				if (
(is_null($this->getPassword()) || trim($this->getPassword()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'PASSWORD');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_email_obligatory', "0") == "1") {
				if (
(is_null($this->getEmail()) || trim($this->getEmail()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'EMAIL');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_first_name_obligatory', "0") == "1") {
				if (
(is_null($this->getFirstName()) || trim($this->getFirstName()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'FIRST_NAME');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_last_name_obligatory', "0") == "1") {
				if (
(is_null($this->getLastName()) || trim($this->getLastName()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'LAST_NAME');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_session_id_obligatory', "0") == "1") {
				if (
(is_null($this->getSessionId()) || trim($this->getSessionId()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'SESSION_ID');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_ip_obligatory', "0") == "1") {
				if (
(is_null($this->getIp()) || trim($this->getIp()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'IP');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_logged_in_obligatory', "0") == "1") {
				if (
(is_null($this->getLoggedIn()) || trim($this->getLoggedIn()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'LOGGED_IN');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_last_successful_login_obligatory', "0") == "1") {
				if (
(is_null($this->getLastSuccessfulLogin()) || trim($this->getLastSuccessfulLogin()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'LAST_SUCCESSFUL_LOGIN');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_last_failed_login_obligatory', "0") == "1") {
				if (
(is_null($this->getLastFailedLogin()) || trim($this->getLastFailedLogin()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'LAST_FAILED_LOGIN');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_last_logout_obligatory', "0") == "1") {
				if (
(is_null($this->getLastLogout()) || trim($this->getLastLogout()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'LAST_LOGOUT');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_user_agent_obligatory', "0") == "1") {
				if (
(is_null($this->getUserAgent()) || trim($this->getUserAgent()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'USER_AGENT');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_token_obligatory', "0") == "1") {
				if (
(is_null($this->getToken()) || trim($this->getToken()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'TOKEN');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_unidentified_obligatory', "0") == "1") {
				if (
(is_null($this->getUnidentified()) || trim($this->getUnidentified()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'UNIDENTIFIED');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_confirmed_obligatory', "0") == "1") {
				if (
(is_null($this->getConfirmed()) || trim($this->getConfirmed()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'CONFIRMED');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_accepted_obligatory', "0") == "1") {
				if (
(is_null($this->getAccepted()) || trim($this->getAccepted()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'ACCEPTED');
				}			
			}
			$tmpMode = (is_null($this->getId()) ? "create" : "form");
			if (P('show_'.$tmpMode.'_page_obligatory', "0") == "1") {
				if (is_null($this->usr_pge_id) || trim($this->usr_pge_id) == "") {
					if (R('create_usr_page_' . $this->usr_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'PAGE', '');
					}
				}
			}			
 	$encryptPassword = false;
	if (!isset($virgoOld)) {
		$encryptPassword = true;
	} else {
		if ($virgoOld->usr_password != $this->usr_password) {
			$encryptPassword = true;
		}
	}
	if ($encryptPassword) {
		$encrypted = virgoUser::encryptString($this->usr_password);
		$this->usr_password = $encrypted;
		$tmpValue = R('usr_password2_' . $this->usr_id);
		$tmpValue = virgoUser::encryptString($tmpValue);
		if ($this->usr_password != $tmpValue) {
			return "Hasła podane w obu polach różnią się od siebie.";
		}
	}
		$types = "";
		$values = array();
		$skipUniquenessCheck = false;
		$uniqnessWhere = " 1 = 1 ";
		if (!is_null($this->usr_id) && $this->usr_id != 0) {
			$uniqnessWhere = " usr_id != " . $this->usr_id . " ";			
		}
 		if (!$skipUniquenessCheck) {
 			if (!$skipUniquenessCheck) {
			$uniqnessWhere = $uniqnessWhere . ' AND UPPER(usr_username) = UPPER(?) ';
			$types .= "s";
			$values[] = $this->usr_username;
			}
 		}	
 		if (!$skipUniquenessCheck) {	
			$query = " SELECT COUNT(*) FROM prt_users ";
			$query = $query . " WHERE " . $uniqnessWhere;
			$result = QPL($query, $types, $values);
			if ($result[0] > 0) {
				$valeus = array();
				$colNames = array();
				$colNames[] = T('USERNAME');
				$values[] = $this->usr_username; 
				return T('UNIQNESS_FAILED', 'USER', implode(', ', $colNames), implode(', ', $values));
			}
		}
			if (!is_null($this->getEmail()) && trim($this->getEmail()) != "") {
				if (preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/', strtoupper($this->getEmail())) == 0) {
					return T('FIELD_MUST_BE_EMAIL', 'EMAIL');
				}
			}
			return "";
		}

				
		function beforeStore($virgoOld) {
		}		
		
		function afterStore($virgoOld) {
			if (is_null($virgoOld)) {
				$this->changeOwnershipAndStore($this->getId());
				$userRoles = $this->getUserRoles();
				$to = $this->getEmail();
				if (S($to)) {
					foreach ($userRoles as $userRole) {
						$roleName = $userRole->getRole()->getName();
						$mailSubject = PP('WELCOME_MAIL_SUBJECT_' . $roleName);
						if (S($mailSubject)) {
							$mailContent = PP('WELCOME_MAIL_CONTENT_' . $roleName);
							$mailContent = E($mailContent, array('username' => $this->getUsername(), 'password' => R('usr_password_')), true, null, false);
							if (S($mailContent)) {
								M($to, $mailSubject, $mailContent, false);
							}
						}
					}
				}
			}
		}
		
		function beforeDelete() {
		$query = " UPDATE prt_system_messages SET sms_deleted_user_name = '{$this->getUsername()}', sms_usr_id = NULL WHERE sms_usr_id = {$this->getId()} ";
		$result = Q($query);
		if (!$result) {
			L(mysqli_error(), $query, 'ERROR');
		}
		}

		function afterDelete() {
			return "";
		}
		
		function getCurrentRevision() {
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_users WHERE usr_id = " . $this->getId();
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
				$colNames = $colNames . ", usr_username";
				$values = $values . ", " . (is_null($objectToStore->getUsername()) ? "null" : "'" . QE($objectToStore->getUsername()) . "'");
				$colNames = $colNames . ", usr_password";
				$values = $values . ", " . (is_null($objectToStore->getPassword()) ? "null" : "'" . QE($objectToStore->getPassword()) . "'");
				$colNames = $colNames . ", usr_email";
				$values = $values . ", " . (is_null($objectToStore->getEmail()) ? "null" : "'" . QE($objectToStore->getEmail()) . "'");
				$colNames = $colNames . ", usr_first_name";
				$values = $values . ", " . (is_null($objectToStore->getFirstName()) ? "null" : "'" . QE($objectToStore->getFirstName()) . "'");
				$colNames = $colNames . ", usr_last_name";
				$values = $values . ", " . (is_null($objectToStore->getLastName()) ? "null" : "'" . QE($objectToStore->getLastName()) . "'");
				$colNames = $colNames . ", usr_session_id";
				$values = $values . ", " . (is_null($objectToStore->getSessionId()) ? "null" : "'" . QE($objectToStore->getSessionId()) . "'");
				$colNames = $colNames . ", usr_ip";
				$values = $values . ", " . (is_null($objectToStore->getIp()) ? "null" : "'" . QE($objectToStore->getIp()) . "'");
				$colNames = $colNames . ", usr_logged_in";
				$values = $values . ", " . (is_null($objectToStore->getLoggedIn()) ? "null" : "'" . QE($objectToStore->getLoggedIn()) . "'");
				$colNames = $colNames . ", usr_last_successful_login";
				$values = $values . ", " . (is_null($objectToStore->getLastSuccessfulLogin()) ? "null" : "'" . QE($objectToStore->getLastSuccessfulLogin()) . "'");
				$colNames = $colNames . ", usr_last_failed_login";
				$values = $values . ", " . (is_null($objectToStore->getLastFailedLogin()) ? "null" : "'" . QE($objectToStore->getLastFailedLogin()) . "'");
				$colNames = $colNames . ", usr_last_logout";
				$values = $values . ", " . (is_null($objectToStore->getLastLogout()) ? "null" : "'" . QE($objectToStore->getLastLogout()) . "'");
				$colNames = $colNames . ", usr_user_agent";
				$values = $values . ", " . (is_null($objectToStore->getUserAgent()) ? "null" : "'" . QE($objectToStore->getUserAgent()) . "'");
				$colNames = $colNames . ", usr_token";
				$values = $values . ", " . (is_null($objectToStore->getToken()) ? "null" : "'" . QE($objectToStore->getToken()) . "'");
				$colNames = $colNames . ", usr_unidentified";
				$values = $values . ", " . (is_null($objectToStore->getUnidentified()) ? "null" : "'" . QE($objectToStore->getUnidentified()) . "'");
				$colNames = $colNames . ", usr_confirmed";
				$values = $values . ", " . (is_null($objectToStore->getConfirmed()) ? "null" : "'" . QE($objectToStore->getConfirmed()) . "'");
				$colNames = $colNames . ", usr_accepted";
				$values = $values . ", " . (is_null($objectToStore->getAccepted()) ? "null" : "'" . QE($objectToStore->getAccepted()) . "'");
				$colNames = $colNames . ", usr_pge_id";
				$values = $values . ", " . (is_null($objectToStore->getPgeId()) || $objectToStore->getPgeId() == "" ? "null" : $objectToStore->getPgeId());
				$query = "INSERT INTO prt_history_users (revision, ip, username, user_id, timestamp, usr_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getUsername() != $objectToStore->getUsername()) {
				if (is_null($objectToStore->getUsername())) {
					$nullifiedProperties = $nullifiedProperties . "username,";
				} else {
				$colNames = $colNames . ", usr_username";
				$values = $values . ", " . (is_null($objectToStore->getUsername()) ? "null" : "'" . QE($objectToStore->getUsername()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getPassword() != $objectToStore->getPassword()) {
				if (is_null($objectToStore->getPassword())) {
					$nullifiedProperties = $nullifiedProperties . "password,";
				} else {
				$colNames = $colNames . ", usr_password";
				$values = $values . ", " . (is_null($objectToStore->getPassword()) ? "null" : "'" . QE($objectToStore->getPassword()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getEmail() != $objectToStore->getEmail()) {
				if (is_null($objectToStore->getEmail())) {
					$nullifiedProperties = $nullifiedProperties . "email,";
				} else {
				$colNames = $colNames . ", usr_email";
				$values = $values . ", " . (is_null($objectToStore->getEmail()) ? "null" : "'" . QE($objectToStore->getEmail()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getFirstName() != $objectToStore->getFirstName()) {
				if (is_null($objectToStore->getFirstName())) {
					$nullifiedProperties = $nullifiedProperties . "first_name,";
				} else {
				$colNames = $colNames . ", usr_first_name";
				$values = $values . ", " . (is_null($objectToStore->getFirstName()) ? "null" : "'" . QE($objectToStore->getFirstName()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getLastName() != $objectToStore->getLastName()) {
				if (is_null($objectToStore->getLastName())) {
					$nullifiedProperties = $nullifiedProperties . "last_name,";
				} else {
				$colNames = $colNames . ", usr_last_name";
				$values = $values . ", " . (is_null($objectToStore->getLastName()) ? "null" : "'" . QE($objectToStore->getLastName()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getSessionId() != $objectToStore->getSessionId()) {
				if (is_null($objectToStore->getSessionId())) {
					$nullifiedProperties = $nullifiedProperties . "session_id,";
				} else {
				$colNames = $colNames . ", usr_session_id";
				$values = $values . ", " . (is_null($objectToStore->getSessionId()) ? "null" : "'" . QE($objectToStore->getSessionId()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getIp() != $objectToStore->getIp()) {
				if (is_null($objectToStore->getIp())) {
					$nullifiedProperties = $nullifiedProperties . "ip,";
				} else {
				$colNames = $colNames . ", usr_ip";
				$values = $values . ", " . (is_null($objectToStore->getIp()) ? "null" : "'" . QE($objectToStore->getIp()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getLoggedIn() != $objectToStore->getLoggedIn()) {
				if (is_null($objectToStore->getLoggedIn())) {
					$nullifiedProperties = $nullifiedProperties . "logged_in,";
				} else {
				$colNames = $colNames . ", usr_logged_in";
				$values = $values . ", " . (is_null($objectToStore->getLoggedIn()) ? "null" : "'" . QE($objectToStore->getLoggedIn()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getLastSuccessfulLogin() != $objectToStore->getLastSuccessfulLogin()) {
				if (is_null($objectToStore->getLastSuccessfulLogin())) {
					$nullifiedProperties = $nullifiedProperties . "last_successful_login,";
				} else {
				$colNames = $colNames . ", usr_last_successful_login";
				$values = $values . ", " . (is_null($objectToStore->getLastSuccessfulLogin()) ? "null" : "'" . QE($objectToStore->getLastSuccessfulLogin()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getLastFailedLogin() != $objectToStore->getLastFailedLogin()) {
				if (is_null($objectToStore->getLastFailedLogin())) {
					$nullifiedProperties = $nullifiedProperties . "last_failed_login,";
				} else {
				$colNames = $colNames . ", usr_last_failed_login";
				$values = $values . ", " . (is_null($objectToStore->getLastFailedLogin()) ? "null" : "'" . QE($objectToStore->getLastFailedLogin()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getLastLogout() != $objectToStore->getLastLogout()) {
				if (is_null($objectToStore->getLastLogout())) {
					$nullifiedProperties = $nullifiedProperties . "last_logout,";
				} else {
				$colNames = $colNames . ", usr_last_logout";
				$values = $values . ", " . (is_null($objectToStore->getLastLogout()) ? "null" : "'" . QE($objectToStore->getLastLogout()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getUserAgent() != $objectToStore->getUserAgent()) {
				if (is_null($objectToStore->getUserAgent())) {
					$nullifiedProperties = $nullifiedProperties . "user_agent,";
				} else {
				$colNames = $colNames . ", usr_user_agent";
				$values = $values . ", " . (is_null($objectToStore->getUserAgent()) ? "null" : "'" . QE($objectToStore->getUserAgent()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getToken() != $objectToStore->getToken()) {
				if (is_null($objectToStore->getToken())) {
					$nullifiedProperties = $nullifiedProperties . "token,";
				} else {
				$colNames = $colNames . ", usr_token";
				$values = $values . ", " . (is_null($objectToStore->getToken()) ? "null" : "'" . QE($objectToStore->getToken()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getUnidentified() != $objectToStore->getUnidentified()) {
				if (is_null($objectToStore->getUnidentified())) {
					$nullifiedProperties = $nullifiedProperties . "unidentified,";
				} else {
				$colNames = $colNames . ", usr_unidentified";
				$values = $values . ", " . (is_null($objectToStore->getUnidentified()) ? "null" : "'" . QE($objectToStore->getUnidentified()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getConfirmed() != $objectToStore->getConfirmed()) {
				if (is_null($objectToStore->getConfirmed())) {
					$nullifiedProperties = $nullifiedProperties . "confirmed,";
				} else {
				$colNames = $colNames . ", usr_confirmed";
				$values = $values . ", " . (is_null($objectToStore->getConfirmed()) ? "null" : "'" . QE($objectToStore->getConfirmed()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getAccepted() != $objectToStore->getAccepted()) {
				if (is_null($objectToStore->getAccepted())) {
					$nullifiedProperties = $nullifiedProperties . "accepted,";
				} else {
				$colNames = $colNames . ", usr_accepted";
				$values = $values . ", " . (is_null($objectToStore->getAccepted()) ? "null" : "'" . QE($objectToStore->getAccepted()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getPgeId() != $objectToStore->getPgeId() && ($virgoOld->getPgeId() != 0 || $objectToStore->getPgeId() != ""))) { 
				$colNames = $colNames . ", usr_pge_id";
				$values = $values . ", " . (is_null($objectToStore->getPgeId()) ? "null" : ($objectToStore->getPgeId() == "" ? "0" : $objectToStore->getPgeId()));
			}
			$query = "INSERT INTO prt_history_users (revision, ip, username, user_id, timestamp, usr_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_users");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'usr_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_users ADD COLUMN (usr_virgo_title VARCHAR(255));";
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
			if (isset($this->usr_id) && $this->usr_id != "") {
				$query = "UPDATE prt_users SET ";
			if (isset($this->usr_username)) {
				$query .= " usr_username = ? ,";
				$types .= "s";
				$values[] = $this->usr_username;
			} else {
				$query .= " usr_username = NULL ,";				
			}
			if (isset($this->usr_password)) {
				$query .= " usr_password = ? ,";
				$types .= "s";
				$values[] = $this->usr_password;
			} else {
				$query .= " usr_password = NULL ,";				
			}
			if (isset($this->usr_email)) {
				$query .= " usr_email = ? ,";
				$types .= "s";
				$values[] = $this->usr_email;
			} else {
				$query .= " usr_email = NULL ,";				
			}
			if (isset($this->usr_first_name)) {
				$query .= " usr_first_name = ? ,";
				$types .= "s";
				$values[] = $this->usr_first_name;
			} else {
				$query .= " usr_first_name = NULL ,";				
			}
			if (isset($this->usr_last_name)) {
				$query .= " usr_last_name = ? ,";
				$types .= "s";
				$values[] = $this->usr_last_name;
			} else {
				$query .= " usr_last_name = NULL ,";				
			}
			if (isset($this->usr_session_id)) {
				$query .= " usr_session_id = ? ,";
				$types .= "s";
				$values[] = $this->usr_session_id;
			} else {
				$query .= " usr_session_id = NULL ,";				
			}
			if (isset($this->usr_ip)) {
				$query .= " usr_ip = ? ,";
				$types .= "s";
				$values[] = $this->usr_ip;
			} else {
				$query .= " usr_ip = NULL ,";				
			}
			if (isset($this->usr_logged_in)) {
				$query .= " usr_logged_in = ? ,";
				$types .= "s";
				$values[] = $this->usr_logged_in;
			} else {
				$query .= " usr_logged_in = NULL ,";				
			}
			if (isset($this->usr_last_successful_login)) {
				$query .= " usr_last_successful_login = ? ,";
				$types .= "s";
				$values[] = $this->usr_last_successful_login;
			} else {
				$query .= " usr_last_successful_login = NULL ,";				
			}
			if (isset($this->usr_last_failed_login)) {
				$query .= " usr_last_failed_login = ? ,";
				$types .= "s";
				$values[] = $this->usr_last_failed_login;
			} else {
				$query .= " usr_last_failed_login = NULL ,";				
			}
			if (isset($this->usr_last_logout)) {
				$query .= " usr_last_logout = ? ,";
				$types .= "s";
				$values[] = $this->usr_last_logout;
			} else {
				$query .= " usr_last_logout = NULL ,";				
			}
			if (isset($this->usr_user_agent)) {
				$query .= " usr_user_agent = ? ,";
				$types .= "s";
				$values[] = $this->usr_user_agent;
			} else {
				$query .= " usr_user_agent = NULL ,";				
			}
			if (isset($this->usr_token)) {
				$query .= " usr_token = ? ,";
				$types .= "s";
				$values[] = $this->usr_token;
			} else {
				$query .= " usr_token = NULL ,";				
			}
			if (isset($this->usr_unidentified)) {
				$query .= " usr_unidentified = ? ,";
				$types .= "s";
				$values[] = $this->usr_unidentified;
			} else {
				$query .= " usr_unidentified = NULL ,";				
			}
			if (isset($this->usr_confirmed)) {
				$query .= " usr_confirmed = ? ,";
				$types .= "s";
				$values[] = $this->usr_confirmed;
			} else {
				$query .= " usr_confirmed = NULL ,";				
			}
			if (isset($this->usr_accepted)) {
				$query .= " usr_accepted = ? ,";
				$types .= "s";
				$values[] = $this->usr_accepted;
			} else {
				$query .= " usr_accepted = NULL ,";				
			}
				if (isset($this->usr_pge_id) && trim($this->usr_pge_id) != "") {
					$query = $query . " usr_pge_id = ? , ";
					$types = $types . "i";
					$values[] = $this->usr_pge_id;
				} else {
					$query = $query . " usr_pge_id = NULL, ";
				}
				$query = $query . " usr_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " usr_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->usr_date_modified;

				$query = $query . " usr_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->usr_usr_modified_id;

				$query = $query . " WHERE usr_id = ? ";
				$types = $types . "i";
				$values[] = $this->usr_id;
			} else {
				$query = "INSERT INTO prt_users ( ";
			$query = $query . " usr_username, ";
			$query = $query . " usr_password, ";
			$query = $query . " usr_email, ";
			$query = $query . " usr_first_name, ";
			$query = $query . " usr_last_name, ";
			$query = $query . " usr_session_id, ";
			$query = $query . " usr_ip, ";
			$query = $query . " usr_logged_in, ";
			$query = $query . " usr_last_successful_login, ";
			$query = $query . " usr_last_failed_login, ";
			$query = $query . " usr_last_logout, ";
			$query = $query . " usr_user_agent, ";
			$query = $query . " usr_token, ";
			$query = $query . " usr_unidentified, ";
			$query = $query . " usr_confirmed, ";
			$query = $query . " usr_accepted, ";
				$query = $query . " usr_pge_id, ";
				$query = $query . " usr_virgo_title, usr_date_created, usr_usr_created_id) VALUES ( ";
			if (isset($this->usr_username)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->usr_username;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->usr_password)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->usr_password;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->usr_email)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->usr_email;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->usr_first_name)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->usr_first_name;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->usr_last_name)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->usr_last_name;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->usr_session_id)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->usr_session_id;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->usr_ip)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->usr_ip;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->usr_logged_in)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->usr_logged_in;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->usr_last_successful_login)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->usr_last_successful_login;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->usr_last_failed_login)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->usr_last_failed_login;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->usr_last_logout)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->usr_last_logout;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->usr_user_agent)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->usr_user_agent;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->usr_token)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->usr_token;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->usr_unidentified)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->usr_unidentified;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->usr_confirmed)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->usr_confirmed;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->usr_accepted)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->usr_accepted;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->usr_pge_id) && trim($this->usr_pge_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->usr_pge_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->usr_date_created;
				$values[] = $this->usr_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->usr_id) || $this->usr_id == "") {
					$this->usr_id = QID();
				}
				if ($log) {
					L("user stored successfully", "id = {$this->usr_id}", "TRACE");
				}
				return true;
			}
		}
		

		static function addRoleStatic($thisId, $id) {
			$query = " SELECT COUNT(url_id) AS cnt FROM prt_user_roles WHERE url_usr_id = {$thisId} AND url_rle_id = {$id} ";
			$res = Q1($query);
			if ($res == 0) {
				$newUserRole = new virgoUserRole();
				$newUserRole->setRoleId($id);
				$newUserRole->setUserId($thisId);
				return $newUserRole->store();
			}			
			return "";
		}
		
		function addRole($id) {
			return virgoUser::addRoleStatic($this->getId(), $id);
		}
		
		static function removeRoleStatic($thisId, $id) {
			$query = " SELECT url_id AS id FROM prt_user_roles WHERE url_usr_id = {$thisId} AND url_rle_id = {$id} ";
			$res = QR($query);
			foreach ($res as $re) {
				$newUserRole = new virgoUserRole($re['id']);
				return $newUserRole->delete();
			}			
			return "";
		}
		
		function removeRole($id) {
			return virgoUser::removeRoleStatic($this->getId(), $id);
		}
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->usr_id) {
				$virgoOld = new virgoUser($this->usr_id);
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
					if ($this->usr_id) {			
						$this->usr_date_modified = date("Y-m-d H:i:s");
						$this->usr_usr_modified_id = $userId;
					} else {
						$this->usr_date_created = date("Y-m-d H:i:s");
						$this->usr_usr_created_id = $userId;
					}
					$this->usr_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "user" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "user" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
						}
					}
					if (!is_null($this->_roleIdsToAddArray)) {
						foreach ($this->_roleIdsToAddArray as $roleId) {
							$ret = $this->addRole((int)$roleId);
							if ($ret != "") {
								L($ret, '', 'ERROR');
							}
						}
					}
					if (!is_null($this->_roleIdsToDeleteArray)) {
						foreach ($this->_roleIdsToDeleteArray as $roleId) {
							$ret = $this->removeRole((int)$roleId);
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
			$query = "DELETE FROM prt_users WHERE usr_id = {$this->usr_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			$list = $this->getUserRoles();
			if (sizeof($list) > 0) {
				foreach ($list as $childRecord) {
					$childRecord->delete();
				}
			}
			$list = $this->getSystemMessages();
			if (sizeof($list) > 0) {
				$name = $this->getVirgoTitle();
				if (!is_null($name) && trim($name) != "") {
					$name = "'" . $name . "' ";
				}
				return T('CANT_DELETE_PARENT', 'USER', 'SYSTEM_MESSAGE', $name);
			}
			self::removeFromContext();
			$this->parentDelete();
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoUser();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT usr_id as id FROM prt_users";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'usr_order_column')) {
				$orderBy = " ORDER BY usr_order_column ASC ";
			} 
			if (property_exists($this, 'usr_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY usr_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoUser();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoUser($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_users SET usr_virgo_title = '$title' WHERE usr_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getByTokenStatic($token) {
			$tmpStatic = new virgoUser();
			$tmpId = $tmpStatic->getIdByToken($token);
			$tmpStatic->load($tmpId);
			return $tmpStatic;
		}
		
		static function getIdByTokenStatic($token) {
			$tmpStatic = new virgoUser();
			return $tmpStatic->getIdByToken($token);
		}
		
		function getIdByToken($token) {
			$res = $this->selectAll(" usr_token = ?", "", "s", array($token));
			foreach ($res as $r) {
				return $r['usr_id'];
			}
			return null;
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoUser();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" usr_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['usr_id'];
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
			virgoUser::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoUser::setSessionValue('Portal_User-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoUser::getSessionValue('Portal_User-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoUser::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoUser::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoUser::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoUser::getSessionValue('GLOBAL', $name, $default);
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
			$context['usr_id'] = $id;
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
			$context['usr_id'] = null;
			virgoUser::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoUser::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoUser::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoUser::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoUser::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoUser::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoUser::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoUser::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoUser::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoUser::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoUser::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoUser::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoUser::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoUser::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoUser::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoUser::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoUser::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "usr_id";
			}
			return virgoUser::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoUser::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoUser::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoUser::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoUser::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoUser::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoUser::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoUser::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoUser::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoUser::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoUser::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoUser::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoUser::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->usr_id) {
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
						L(T('STORED_CORRECTLY', 'USER'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'username', $this->usr_username);
						$fieldValues = $fieldValues . T($fieldValue, 'password', $this->usr_password);
						$fieldValues = $fieldValues . T($fieldValue, 'email', $this->usr_email);
						$fieldValues = $fieldValues . T($fieldValue, 'first name', $this->usr_first_name);
						$fieldValues = $fieldValues . T($fieldValue, 'last name', $this->usr_last_name);
						$fieldValues = $fieldValues . T($fieldValue, 'session id', $this->usr_session_id);
						$fieldValues = $fieldValues . T($fieldValue, 'ip', $this->usr_ip);
						$fieldValues = $fieldValues . T($fieldValue, 'logged in', $this->usr_logged_in);
						$fieldValues = $fieldValues . T($fieldValue, 'last successful login', $this->usr_last_successful_login);
						$fieldValues = $fieldValues . T($fieldValue, 'last failed login', $this->usr_last_failed_login);
						$fieldValues = $fieldValues . T($fieldValue, 'last logout', $this->usr_last_logout);
						$fieldValues = $fieldValues . T($fieldValue, 'user agent', $this->usr_user_agent);
						$fieldValues = $fieldValues . T($fieldValue, 'token', $this->usr_token);
						$fieldValues = $fieldValues . T($fieldValue, 'unidentified', $this->usr_unidentified);
						$fieldValues = $fieldValues . T($fieldValue, 'confirmed', $this->usr_confirmed);
						$fieldValues = $fieldValues . T($fieldValue, 'accepted', $this->usr_accepted);
						$parentPage = new virgoPage();
						$fieldValues = $fieldValues . T($fieldValue, 'page', $parentPage->lookup($this->usr_pge_id));
						$username = '';
						if ($this->usr_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->usr_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->usr_date_created);
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
			$instance = new virgoUser();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
				$resIds = $tmpSystemMessage->select(null, 'all', null, null, ' sms_usr_id = ' . $instance->getId(), ' SELECT sms_id FROM prt_system_messages ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->sms_id;
//					JRequest::setVar('sms_user_' . $resId->sms_id, $this->getId());
				} 
//				JRequest::setVar('sms_user_', $instance->getId());
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
			$tmpId = intval(R('usr_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoUser::getContextId();
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
			$this->usr_id = null;
			$this->usr_date_created = null;
			$this->usr_usr_created_id = null;
			$this->usr_date_modified = null;
			$this->usr_usr_modified_id = null;
			$this->usr_virgo_title = null;
			
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
//			$ret = new virgoUser();
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
				$instance = new virgoUser();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoUser::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'USER'), '', 'INFO');
					return 0;
					
				} else {
					L($res, '', 'ERROR');
					return -1;
				}
			}
		}
		
		
		static function portletActionVirgoSetLoggedInTrue() {
			$this->loadFromDB();
			$this->setLoggedIn(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetLoggedInFalse() {
			$this->loadFromDB();
			$this->setLoggedIn(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isLoggedIn() {
			return $this->getLoggedIn() == 1;
		}
		static function portletActionVirgoSetUnidentifiedTrue() {
			$this->loadFromDB();
			$this->setUnidentified(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetUnidentifiedFalse() {
			$this->loadFromDB();
			$this->setUnidentified(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isUnidentified() {
			return $this->getUnidentified() == 1;
		}
		static function portletActionVirgoSetConfirmedTrue() {
			$this->loadFromDB();
			$this->setConfirmed(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetConfirmedFalse() {
			$this->loadFromDB();
			$this->setConfirmed(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isConfirmed() {
			return $this->getConfirmed() == 1;
		}
		static function portletActionVirgoSetAcceptedTrue() {
			$this->loadFromDB();
			$this->setAccepted(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetAcceptedFalse() {
			$this->loadFromDB();
			$this->setAccepted(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isAccepted() {
			return $this->getAccepted() == 1;
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
				$resultUser = new virgoUser();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultUser->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultUser->load($idToEditInt);
					} else {
						$resultUser->usr_id = 0;
					}
				}
				$results[] = $resultUser;
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
				$result = new virgoUser();
				$result->loadFromRequest($idToStore);
				if ($result->usr_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->usr_id == 0) {
						$result->usr_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->usr_id)) {
							$result->usr_id = 0;
						}
						$idsToCorrect[$result->usr_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'USERS'), '', 'INFO');
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
			$resultUser = new virgoUser();
			foreach ($idsToDelete as $idToDelete) {
				$resultUser->load((int)trim($idToDelete));
				$res = $resultUser->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'USERS'), '', 'INFO');			
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
		$ret = $this->usr_username;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoUser');
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
    			$ret["beforeDelete/user.php"] = "<b>2012-10-24</b> <span style='font-size: 0.78em;'>23:08:03</span>";
    			$ret["afterStore/user.php"] = "<b>2013-10-11</b> <span style='font-size: 0.78em;'>13:03:49</span>";
    			$ret["beforeStore/user.php"] = "<b>2012-07-17</b> <span style='font-size: 0.78em;'>08:52:10</span>";
			return $ret;
		}
		
		function updateTitle() {
			$val = $this->getVirgoTitle(); 
			if (!is_null($val) && trim($val) != "") {
				$query = "UPDATE prt_users SET usr_virgo_title = ? WHERE usr_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT usr_id AS id FROM prt_users ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoUser($row['id']);
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
						$parentInfo['condition'] = 'prt_users.usr_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_users.usr_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_users.usr_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_users.usr_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoUser!', '', 'ERROR');
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
			$pdf->SetTitle('Users report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('USERS');
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
			if (P('show_pdf_username', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_password', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_email', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_first_name', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_last_name', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_session_id', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_ip', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_logged_in', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_last_successful_login', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_last_failed_login', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_last_logout', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_user_agent', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_token', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_unidentified', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_confirmed', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_accepted', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_page', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultUser = new virgoUser();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_username', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Username');
				$minWidth['username'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['username']) {
						$minWidth['username'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_password', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Password');
				$minWidth['password'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['password']) {
						$minWidth['password'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_email', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Email');
				$minWidth['email'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['email']) {
						$minWidth['email'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_first_name', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'First name');
				$minWidth['first name'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['first name']) {
						$minWidth['first name'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_last_name', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Last name');
				$minWidth['last name'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['last name']) {
						$minWidth['last name'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_session_id', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Session id');
				$minWidth['session id'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['session id']) {
						$minWidth['session id'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_ip', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Ip');
				$minWidth['ip'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['ip']) {
						$minWidth['ip'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_logged_in', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Logged in');
				$minWidth['logged in'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['logged in']) {
						$minWidth['logged in'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_last_successful_login', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Last successful login');
				$minWidth['last successful login'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['last successful login']) {
						$minWidth['last successful login'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_last_failed_login', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Last failed login');
				$minWidth['last failed login'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['last failed login']) {
						$minWidth['last failed login'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_last_logout', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Last logout');
				$minWidth['last logout'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['last logout']) {
						$minWidth['last logout'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_user_agent', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'User agent');
				$minWidth['user agent'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['user agent']) {
						$minWidth['user agent'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_token', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Token');
				$minWidth['token'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['token']) {
						$minWidth['token'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_unidentified', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Unidentified');
				$minWidth['unidentified'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['unidentified']) {
						$minWidth['unidentified'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_confirmed', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Confirmed');
				$minWidth['confirmed'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['confirmed']) {
						$minWidth['confirmed'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_accepted', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Accepted');
				$minWidth['accepted'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['accepted']) {
						$minWidth['accepted'] = min($tmpLen, $maxWidth);
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
			$whereClauseUser = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseUser = $whereClauseUser . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaUser = $resultUser->getCriteria();
			$fieldCriteriaUsername = $criteriaUser["username"];
			if ($fieldCriteriaUsername["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Username', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaUsername["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Username', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaPassword = $criteriaUser["password"];
			if ($fieldCriteriaPassword["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Password', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaPassword["value"];
				$renderCriteria = "";
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Password', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaEmail = $criteriaUser["email"];
			if ($fieldCriteriaEmail["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Email', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaEmail["value"];
				$renderCriteria = "";
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Email', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaFirstName = $criteriaUser["first_name"];
			if ($fieldCriteriaFirstName["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'First name', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaFirstName["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'First name', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaLastName = $criteriaUser["last_name"];
			if ($fieldCriteriaLastName["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Last name', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaLastName["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Last name', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaSessionId = $criteriaUser["session_id"];
			if ($fieldCriteriaSessionId["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Session id', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaSessionId["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Session id', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaIp = $criteriaUser["ip"];
			if ($fieldCriteriaIp["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Ip', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaIp["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Ip', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaLoggedIn = $criteriaUser["logged_in"];
			if ($fieldCriteriaLoggedIn["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Logged in', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaLoggedIn["value"];
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
					$pdf->MultiCell(60, 100, 'Logged in', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaLastSuccessfulLogin = $criteriaUser["last_successful_login"];
			if ($fieldCriteriaLastSuccessfulLogin["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Last successful login', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaLastSuccessfulLogin["value"];
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
					$pdf->MultiCell(60, 100, 'Last successful login', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaLastFailedLogin = $criteriaUser["last_failed_login"];
			if ($fieldCriteriaLastFailedLogin["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Last failed login', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaLastFailedLogin["value"];
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
					$pdf->MultiCell(60, 100, 'Last failed login', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaLastLogout = $criteriaUser["last_logout"];
			if ($fieldCriteriaLastLogout["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Last logout', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaLastLogout["value"];
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
					$pdf->MultiCell(60, 100, 'Last logout', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaUserAgent = $criteriaUser["user_agent"];
			if ($fieldCriteriaUserAgent["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'User agent', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaUserAgent["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'User agent', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaToken = $criteriaUser["token"];
			if ($fieldCriteriaToken["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Token', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaToken["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Token', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaUnidentified = $criteriaUser["unidentified"];
			if ($fieldCriteriaUnidentified["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Unidentified', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaUnidentified["value"];
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
					$pdf->MultiCell(60, 100, 'Unidentified', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaConfirmed = $criteriaUser["confirmed"];
			if ($fieldCriteriaConfirmed["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Confirmed', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaConfirmed["value"];
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
					$pdf->MultiCell(60, 100, 'Confirmed', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaAccepted = $criteriaUser["accepted"];
			if ($fieldCriteriaAccepted["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Accepted', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaAccepted["value"];
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
					$pdf->MultiCell(60, 100, 'Accepted', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaUser["page"];
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
					$inCondition = " prt_users.usr_pge_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_users.usr_pge_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseUser = $whereClauseUser . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaUser = self::getCriteria();
			if (isset($criteriaUser["username"])) {
				$fieldCriteriaUsername = $criteriaUser["username"];
				if ($fieldCriteriaUsername["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_username IS NOT NULL ';
				} elseif ($fieldCriteriaUsername["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_username IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaUsername["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_users.usr_username like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUser["password"])) {
				$fieldCriteriaPassword = $criteriaUser["password"];
				if ($fieldCriteriaPassword["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_password IS NOT NULL ';
				} elseif ($fieldCriteriaPassword["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_password IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaPassword["value"];
				}
			}
			if (isset($criteriaUser["email"])) {
				$fieldCriteriaEmail = $criteriaUser["email"];
				if ($fieldCriteriaEmail["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_email IS NOT NULL ';
				} elseif ($fieldCriteriaEmail["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_email IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaEmail["value"];
				}
			}
			if (isset($criteriaUser["first_name"])) {
				$fieldCriteriaFirstName = $criteriaUser["first_name"];
				if ($fieldCriteriaFirstName["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_first_name IS NOT NULL ';
				} elseif ($fieldCriteriaFirstName["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_first_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaFirstName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_users.usr_first_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUser["last_name"])) {
				$fieldCriteriaLastName = $criteriaUser["last_name"];
				if ($fieldCriteriaLastName["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_last_name IS NOT NULL ';
				} elseif ($fieldCriteriaLastName["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_last_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaLastName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_users.usr_last_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUser["session_id"])) {
				$fieldCriteriaSessionId = $criteriaUser["session_id"];
				if ($fieldCriteriaSessionId["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_session_id IS NOT NULL ';
				} elseif ($fieldCriteriaSessionId["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_session_id IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaSessionId["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_users.usr_session_id like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUser["ip"])) {
				$fieldCriteriaIp = $criteriaUser["ip"];
				if ($fieldCriteriaIp["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_ip IS NOT NULL ';
				} elseif ($fieldCriteriaIp["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_ip IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaIp["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_users.usr_ip like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUser["logged_in"])) {
				$fieldCriteriaLoggedIn = $criteriaUser["logged_in"];
				if ($fieldCriteriaLoggedIn["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_logged_in IS NOT NULL ';
				} elseif ($fieldCriteriaLoggedIn["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_logged_in IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaLoggedIn["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_users.usr_logged_in = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaUser["last_successful_login"])) {
				$fieldCriteriaLastSuccessfulLogin = $criteriaUser["last_successful_login"];
				if ($fieldCriteriaLastSuccessfulLogin["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_last_successful_login IS NOT NULL ';
				} elseif ($fieldCriteriaLastSuccessfulLogin["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_last_successful_login IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaLastSuccessfulLogin["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND prt_users.usr_last_successful_login >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_users.usr_last_successful_login <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaUser["last_failed_login"])) {
				$fieldCriteriaLastFailedLogin = $criteriaUser["last_failed_login"];
				if ($fieldCriteriaLastFailedLogin["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_last_failed_login IS NOT NULL ';
				} elseif ($fieldCriteriaLastFailedLogin["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_last_failed_login IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaLastFailedLogin["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND prt_users.usr_last_failed_login >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_users.usr_last_failed_login <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaUser["last_logout"])) {
				$fieldCriteriaLastLogout = $criteriaUser["last_logout"];
				if ($fieldCriteriaLastLogout["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_last_logout IS NOT NULL ';
				} elseif ($fieldCriteriaLastLogout["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_last_logout IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaLastLogout["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND prt_users.usr_last_logout >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_users.usr_last_logout <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaUser["user_agent"])) {
				$fieldCriteriaUserAgent = $criteriaUser["user_agent"];
				if ($fieldCriteriaUserAgent["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_user_agent IS NOT NULL ';
				} elseif ($fieldCriteriaUserAgent["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_user_agent IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaUserAgent["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_users.usr_user_agent like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUser["token"])) {
				$fieldCriteriaToken = $criteriaUser["token"];
				if ($fieldCriteriaToken["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_token IS NOT NULL ';
				} elseif ($fieldCriteriaToken["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_token IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaToken["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_users.usr_token like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaUser["unidentified"])) {
				$fieldCriteriaUnidentified = $criteriaUser["unidentified"];
				if ($fieldCriteriaUnidentified["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_unidentified IS NOT NULL ';
				} elseif ($fieldCriteriaUnidentified["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_unidentified IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaUnidentified["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_users.usr_unidentified = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaUser["confirmed"])) {
				$fieldCriteriaConfirmed = $criteriaUser["confirmed"];
				if ($fieldCriteriaConfirmed["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_confirmed IS NOT NULL ';
				} elseif ($fieldCriteriaConfirmed["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_confirmed IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaConfirmed["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_users.usr_confirmed = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaUser["accepted"])) {
				$fieldCriteriaAccepted = $criteriaUser["accepted"];
				if ($fieldCriteriaAccepted["is_null"] == 1) {
$filter = $filter . ' AND prt_users.usr_accepted IS NOT NULL ';
				} elseif ($fieldCriteriaAccepted["is_null"] == 2) {
$filter = $filter . ' AND prt_users.usr_accepted IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaAccepted["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_users.usr_accepted = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaUser["page"])) {
				$parentCriteria = $criteriaUser["page"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND usr_pge_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_users.usr_pge_id IN (SELECT pge_id FROM prt_pages WHERE pge_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaUser["role"])) {
				$parentCriteria = $criteriaUser["role"];
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$filter = $filter . " AND prt_users.usr_id IN (SELECT second_parent.url_usr_id FROM prt_user_roles AS second_parent WHERE second_parent.url_rle_id IN (" . implode(", ", $parentIds) . ")) ";
				}
			}
			$whereClauseUser = $whereClauseUser . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseUser = $whereClauseUser . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_users.usr_id, prt_users.usr_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_username', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_username usr_username";
			} else {
				if ($defaultOrderColumn == "usr_username") {
					$orderColumnNotDisplayed = " prt_users.usr_username ";
				}
			}
			if (P('show_pdf_password', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_password usr_password";
			} else {
				if ($defaultOrderColumn == "usr_password") {
					$orderColumnNotDisplayed = " prt_users.usr_password ";
				}
			}
			if (P('show_pdf_email', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_email usr_email";
			} else {
				if ($defaultOrderColumn == "usr_email") {
					$orderColumnNotDisplayed = " prt_users.usr_email ";
				}
			}
			if (P('show_pdf_first_name', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_first_name usr_first_name";
			} else {
				if ($defaultOrderColumn == "usr_first_name") {
					$orderColumnNotDisplayed = " prt_users.usr_first_name ";
				}
			}
			if (P('show_pdf_last_name', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_last_name usr_last_name";
			} else {
				if ($defaultOrderColumn == "usr_last_name") {
					$orderColumnNotDisplayed = " prt_users.usr_last_name ";
				}
			}
			if (P('show_pdf_session_id', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_session_id usr_session_id";
			} else {
				if ($defaultOrderColumn == "usr_session_id") {
					$orderColumnNotDisplayed = " prt_users.usr_session_id ";
				}
			}
			if (P('show_pdf_ip', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_ip usr_ip";
			} else {
				if ($defaultOrderColumn == "usr_ip") {
					$orderColumnNotDisplayed = " prt_users.usr_ip ";
				}
			}
			if (P('show_pdf_logged_in', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_logged_in usr_logged_in";
			} else {
				if ($defaultOrderColumn == "usr_logged_in") {
					$orderColumnNotDisplayed = " prt_users.usr_logged_in ";
				}
			}
			if (P('show_pdf_last_successful_login', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_last_successful_login usr_last_successful_login";
			} else {
				if ($defaultOrderColumn == "usr_last_successful_login") {
					$orderColumnNotDisplayed = " prt_users.usr_last_successful_login ";
				}
			}
			if (P('show_pdf_last_failed_login', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_last_failed_login usr_last_failed_login";
			} else {
				if ($defaultOrderColumn == "usr_last_failed_login") {
					$orderColumnNotDisplayed = " prt_users.usr_last_failed_login ";
				}
			}
			if (P('show_pdf_last_logout', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_last_logout usr_last_logout";
			} else {
				if ($defaultOrderColumn == "usr_last_logout") {
					$orderColumnNotDisplayed = " prt_users.usr_last_logout ";
				}
			}
			if (P('show_pdf_user_agent', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_user_agent usr_user_agent";
			} else {
				if ($defaultOrderColumn == "usr_user_agent") {
					$orderColumnNotDisplayed = " prt_users.usr_user_agent ";
				}
			}
			if (P('show_pdf_token', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_token usr_token";
			} else {
				if ($defaultOrderColumn == "usr_token") {
					$orderColumnNotDisplayed = " prt_users.usr_token ";
				}
			}
			if (P('show_pdf_unidentified', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_unidentified usr_unidentified";
			} else {
				if ($defaultOrderColumn == "usr_unidentified") {
					$orderColumnNotDisplayed = " prt_users.usr_unidentified ";
				}
			}
			if (P('show_pdf_confirmed', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_confirmed usr_confirmed";
			} else {
				if ($defaultOrderColumn == "usr_confirmed") {
					$orderColumnNotDisplayed = " prt_users.usr_confirmed ";
				}
			}
			if (P('show_pdf_accepted', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_accepted usr_accepted";
			} else {
				if ($defaultOrderColumn == "usr_accepted") {
					$orderColumnNotDisplayed = " prt_users.usr_accepted ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_pdf_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_users.usr_pge_id as usr_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_users ";
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_users.usr_pge_id = prt_pages_parent.pge_id) ";
			}

		$resultsUser = $resultUser->select(
			'', 
			'all', 
			$resultUser->getOrderColumn(), 
			$resultUser->getOrderMode(), 
			$whereClauseUser,
			$queryString);
		
		foreach ($resultsUser as $resultUser) {

			if (P('show_pdf_username', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUser['usr_username'])) + 6;
				if ($tmpLen > $minWidth['username']) {
					$minWidth['username'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_password', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUser['usr_password'])) + 6;
				if ($tmpLen > $minWidth['password']) {
					$minWidth['password'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_email', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUser['usr_email'])) + 6;
				if ($tmpLen > $minWidth['email']) {
					$minWidth['email'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_first_name', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUser['usr_first_name'])) + 6;
				if ($tmpLen > $minWidth['first name']) {
					$minWidth['first name'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_last_name', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUser['usr_last_name'])) + 6;
				if ($tmpLen > $minWidth['last name']) {
					$minWidth['last name'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_session_id', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUser['usr_session_id'])) + 6;
				if ($tmpLen > $minWidth['session id']) {
					$minWidth['session id'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_ip', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUser['usr_ip'])) + 6;
				if ($tmpLen > $minWidth['ip']) {
					$minWidth['ip'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_logged_in', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUser['usr_logged_in'])) + 6;
				if ($tmpLen > $minWidth['logged in']) {
					$minWidth['logged in'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_last_successful_login', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUser['usr_last_successful_login'])) + 6;
				if ($tmpLen > $minWidth['last successful login']) {
					$minWidth['last successful login'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_last_failed_login', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUser['usr_last_failed_login'])) + 6;
				if ($tmpLen > $minWidth['last failed login']) {
					$minWidth['last failed login'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_last_logout', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUser['usr_last_logout'])) + 6;
				if ($tmpLen > $minWidth['last logout']) {
					$minWidth['last logout'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_user_agent', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUser['usr_user_agent'])) + 6;
				if ($tmpLen > $minWidth['user agent']) {
					$minWidth['user agent'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_token', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUser['usr_token'])) + 6;
				if ($tmpLen > $minWidth['token']) {
					$minWidth['token'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_unidentified', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUser['usr_unidentified'])) + 6;
				if ($tmpLen > $minWidth['unidentified']) {
					$minWidth['unidentified'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_confirmed', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUser['usr_confirmed'])) + 6;
				if ($tmpLen > $minWidth['confirmed']) {
					$minWidth['confirmed'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_accepted', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultUser['usr_accepted'])) + 6;
				if ($tmpLen > $minWidth['accepted']) {
					$minWidth['accepted'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_page', "1") == "1") {
			$parentValue = trim(virgoPage::lookup($resultUser['usrpge__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['page $relation.name']) {
					$minWidth['page $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaUser = $resultUser->getCriteria();
		if (is_null($criteriaUser) || sizeof($criteriaUser) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																																									if (P('show_pdf_username', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['username'], $colHeight, T('USERNAME'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_password', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['password'], $colHeight, T('PASSWORD'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_email', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['email'], $colHeight, T('EMAIL'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_first_name', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['first name'], $colHeight, T('FIRST_NAME'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_last_name', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['last name'], $colHeight, T('LAST_NAME'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_session_id', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['session id'], $colHeight, T('SESSION_ID'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_ip', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['ip'], $colHeight, T('IP'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_logged_in', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['logged in'], $colHeight, T('LOGGED_IN'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_last_successful_login', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['last successful login'], $colHeight, T('LAST_SUCCESSFUL_LOGIN'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_last_failed_login', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['last failed login'], $colHeight, T('LAST_FAILED_LOGIN'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_last_logout', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['last logout'], $colHeight, T('LAST_LOGOUT'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_user_agent', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['user agent'], $colHeight, T('USER_AGENT'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_token', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['token'], $colHeight, T('TOKEN'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_unidentified', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['unidentified'], $colHeight, T('UNIDENTIFIED'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_confirmed', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['confirmed'], $colHeight, T('CONFIRMED'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_accepted', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['accepted'], $colHeight, T('ACCEPTED'), 'T', 'C', 0, 0);
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
		foreach ($resultsUser as $resultUser) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_username', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['username'], $colHeight, '' . $resultUser['usr_username'], 'T', 'L', 0, 0);
				if (P('show_pdf_username', "1") == "2") {
										if (!is_null($resultUser['usr_username'])) {
						$tmpCount = (float)$counts["username"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["username"] = $tmpCount;
					}
				}
				if (P('show_pdf_username', "1") == "3") {
										if (!is_null($resultUser['usr_username'])) {
						$tmpSum = (float)$sums["username"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_username'];
						}
						$sums["username"] = $tmpSum;
					}
				}
				if (P('show_pdf_username', "1") == "4") {
										if (!is_null($resultUser['usr_username'])) {
						$tmpCount = (float)$avgCounts["username"];
						$tmpSum = (float)$avgSums["username"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["username"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_username'];
						}
						$avgSums["username"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_password', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['password'], $colHeight, '' . $resultUser['usr_password'], 'T', 'L', 0, 0);
				if (P('show_pdf_password', "1") == "2") {
										if (!is_null($resultUser['usr_password'])) {
						$tmpCount = (float)$counts["password"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["password"] = $tmpCount;
					}
				}
				if (P('show_pdf_password', "1") == "3") {
										if (!is_null($resultUser['usr_password'])) {
						$tmpSum = (float)$sums["password"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_password'];
						}
						$sums["password"] = $tmpSum;
					}
				}
				if (P('show_pdf_password', "1") == "4") {
										if (!is_null($resultUser['usr_password'])) {
						$tmpCount = (float)$avgCounts["password"];
						$tmpSum = (float)$avgSums["password"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["password"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_password'];
						}
						$avgSums["password"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_email', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['email'], $colHeight, '' . $resultUser['usr_email'], 'T', 'L', 0, 0);
				if (P('show_pdf_email', "1") == "2") {
										if (!is_null($resultUser['usr_email'])) {
						$tmpCount = (float)$counts["email"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["email"] = $tmpCount;
					}
				}
				if (P('show_pdf_email', "1") == "3") {
										if (!is_null($resultUser['usr_email'])) {
						$tmpSum = (float)$sums["email"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_email'];
						}
						$sums["email"] = $tmpSum;
					}
				}
				if (P('show_pdf_email', "1") == "4") {
										if (!is_null($resultUser['usr_email'])) {
						$tmpCount = (float)$avgCounts["email"];
						$tmpSum = (float)$avgSums["email"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["email"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_email'];
						}
						$avgSums["email"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_first_name', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['first name'], $colHeight, '' . $resultUser['usr_first_name'], 'T', 'L', 0, 0);
				if (P('show_pdf_first_name', "1") == "2") {
										if (!is_null($resultUser['usr_first_name'])) {
						$tmpCount = (float)$counts["first_name"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["first_name"] = $tmpCount;
					}
				}
				if (P('show_pdf_first_name', "1") == "3") {
										if (!is_null($resultUser['usr_first_name'])) {
						$tmpSum = (float)$sums["first_name"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_first_name'];
						}
						$sums["first_name"] = $tmpSum;
					}
				}
				if (P('show_pdf_first_name', "1") == "4") {
										if (!is_null($resultUser['usr_first_name'])) {
						$tmpCount = (float)$avgCounts["first_name"];
						$tmpSum = (float)$avgSums["first_name"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["first_name"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_first_name'];
						}
						$avgSums["first_name"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_last_name', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['last name'], $colHeight, '' . $resultUser['usr_last_name'], 'T', 'L', 0, 0);
				if (P('show_pdf_last_name', "1") == "2") {
										if (!is_null($resultUser['usr_last_name'])) {
						$tmpCount = (float)$counts["last_name"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["last_name"] = $tmpCount;
					}
				}
				if (P('show_pdf_last_name', "1") == "3") {
										if (!is_null($resultUser['usr_last_name'])) {
						$tmpSum = (float)$sums["last_name"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_last_name'];
						}
						$sums["last_name"] = $tmpSum;
					}
				}
				if (P('show_pdf_last_name', "1") == "4") {
										if (!is_null($resultUser['usr_last_name'])) {
						$tmpCount = (float)$avgCounts["last_name"];
						$tmpSum = (float)$avgSums["last_name"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["last_name"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_last_name'];
						}
						$avgSums["last_name"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_session_id', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['session id'], $colHeight, '' . $resultUser['usr_session_id'], 'T', 'L', 0, 0);
				if (P('show_pdf_session_id', "1") == "2") {
										if (!is_null($resultUser['usr_session_id'])) {
						$tmpCount = (float)$counts["session_id"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["session_id"] = $tmpCount;
					}
				}
				if (P('show_pdf_session_id', "1") == "3") {
										if (!is_null($resultUser['usr_session_id'])) {
						$tmpSum = (float)$sums["session_id"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_session_id'];
						}
						$sums["session_id"] = $tmpSum;
					}
				}
				if (P('show_pdf_session_id', "1") == "4") {
										if (!is_null($resultUser['usr_session_id'])) {
						$tmpCount = (float)$avgCounts["session_id"];
						$tmpSum = (float)$avgSums["session_id"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["session_id"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_session_id'];
						}
						$avgSums["session_id"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_ip', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['ip'], $colHeight, '' . $resultUser['usr_ip'], 'T', 'L', 0, 0);
				if (P('show_pdf_ip', "1") == "2") {
										if (!is_null($resultUser['usr_ip'])) {
						$tmpCount = (float)$counts["ip"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["ip"] = $tmpCount;
					}
				}
				if (P('show_pdf_ip', "1") == "3") {
										if (!is_null($resultUser['usr_ip'])) {
						$tmpSum = (float)$sums["ip"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_ip'];
						}
						$sums["ip"] = $tmpSum;
					}
				}
				if (P('show_pdf_ip', "1") == "4") {
										if (!is_null($resultUser['usr_ip'])) {
						$tmpCount = (float)$avgCounts["ip"];
						$tmpSum = (float)$avgSums["ip"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["ip"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_ip'];
						}
						$avgSums["ip"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_logged_in', "0") != "0") {
			$renderCriteria = "";
			switch ($resultUser['usr_logged_in']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['logged in'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_logged_in', "1") == "2") {
										if (!is_null($resultUser['usr_logged_in'])) {
						$tmpCount = (float)$counts["logged_in"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["logged_in"] = $tmpCount;
					}
				}
				if (P('show_pdf_logged_in', "1") == "3") {
										if (!is_null($resultUser['usr_logged_in'])) {
						$tmpSum = (float)$sums["logged_in"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_logged_in'];
						}
						$sums["logged_in"] = $tmpSum;
					}
				}
				if (P('show_pdf_logged_in', "1") == "4") {
										if (!is_null($resultUser['usr_logged_in'])) {
						$tmpCount = (float)$avgCounts["logged_in"];
						$tmpSum = (float)$avgSums["logged_in"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["logged_in"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_logged_in'];
						}
						$avgSums["logged_in"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_last_successful_login', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['last successful login'], $colHeight, '' . $resultUser['usr_last_successful_login'], 'T', 'L', 0, 0);
				if (P('show_pdf_last_successful_login', "1") == "2") {
										if (!is_null($resultUser['usr_last_successful_login'])) {
						$tmpCount = (float)$counts["last_successful_login"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["last_successful_login"] = $tmpCount;
					}
				}
				if (P('show_pdf_last_successful_login', "1") == "3") {
										if (!is_null($resultUser['usr_last_successful_login'])) {
						$tmpSum = (float)$sums["last_successful_login"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_last_successful_login'];
						}
						$sums["last_successful_login"] = $tmpSum;
					}
				}
				if (P('show_pdf_last_successful_login', "1") == "4") {
										if (!is_null($resultUser['usr_last_successful_login'])) {
						$tmpCount = (float)$avgCounts["last_successful_login"];
						$tmpSum = (float)$avgSums["last_successful_login"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["last_successful_login"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_last_successful_login'];
						}
						$avgSums["last_successful_login"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_last_failed_login', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['last failed login'], $colHeight, '' . $resultUser['usr_last_failed_login'], 'T', 'L', 0, 0);
				if (P('show_pdf_last_failed_login', "1") == "2") {
										if (!is_null($resultUser['usr_last_failed_login'])) {
						$tmpCount = (float)$counts["last_failed_login"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["last_failed_login"] = $tmpCount;
					}
				}
				if (P('show_pdf_last_failed_login', "1") == "3") {
										if (!is_null($resultUser['usr_last_failed_login'])) {
						$tmpSum = (float)$sums["last_failed_login"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_last_failed_login'];
						}
						$sums["last_failed_login"] = $tmpSum;
					}
				}
				if (P('show_pdf_last_failed_login', "1") == "4") {
										if (!is_null($resultUser['usr_last_failed_login'])) {
						$tmpCount = (float)$avgCounts["last_failed_login"];
						$tmpSum = (float)$avgSums["last_failed_login"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["last_failed_login"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_last_failed_login'];
						}
						$avgSums["last_failed_login"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_last_logout', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['last logout'], $colHeight, '' . $resultUser['usr_last_logout'], 'T', 'L', 0, 0);
				if (P('show_pdf_last_logout', "1") == "2") {
										if (!is_null($resultUser['usr_last_logout'])) {
						$tmpCount = (float)$counts["last_logout"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["last_logout"] = $tmpCount;
					}
				}
				if (P('show_pdf_last_logout', "1") == "3") {
										if (!is_null($resultUser['usr_last_logout'])) {
						$tmpSum = (float)$sums["last_logout"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_last_logout'];
						}
						$sums["last_logout"] = $tmpSum;
					}
				}
				if (P('show_pdf_last_logout', "1") == "4") {
										if (!is_null($resultUser['usr_last_logout'])) {
						$tmpCount = (float)$avgCounts["last_logout"];
						$tmpSum = (float)$avgSums["last_logout"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["last_logout"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_last_logout'];
						}
						$avgSums["last_logout"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_user_agent', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['user agent'], $colHeight, '' . $resultUser['usr_user_agent'], 'T', 'L', 0, 0);
				if (P('show_pdf_user_agent', "1") == "2") {
										if (!is_null($resultUser['usr_user_agent'])) {
						$tmpCount = (float)$counts["user_agent"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["user_agent"] = $tmpCount;
					}
				}
				if (P('show_pdf_user_agent', "1") == "3") {
										if (!is_null($resultUser['usr_user_agent'])) {
						$tmpSum = (float)$sums["user_agent"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_user_agent'];
						}
						$sums["user_agent"] = $tmpSum;
					}
				}
				if (P('show_pdf_user_agent', "1") == "4") {
										if (!is_null($resultUser['usr_user_agent'])) {
						$tmpCount = (float)$avgCounts["user_agent"];
						$tmpSum = (float)$avgSums["user_agent"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["user_agent"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_user_agent'];
						}
						$avgSums["user_agent"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_token', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['token'], $colHeight, '' . $resultUser['usr_token'], 'T', 'L', 0, 0);
				if (P('show_pdf_token', "1") == "2") {
										if (!is_null($resultUser['usr_token'])) {
						$tmpCount = (float)$counts["token"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["token"] = $tmpCount;
					}
				}
				if (P('show_pdf_token', "1") == "3") {
										if (!is_null($resultUser['usr_token'])) {
						$tmpSum = (float)$sums["token"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_token'];
						}
						$sums["token"] = $tmpSum;
					}
				}
				if (P('show_pdf_token', "1") == "4") {
										if (!is_null($resultUser['usr_token'])) {
						$tmpCount = (float)$avgCounts["token"];
						$tmpSum = (float)$avgSums["token"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["token"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_token'];
						}
						$avgSums["token"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_unidentified', "0") != "0") {
			$renderCriteria = "";
			switch ($resultUser['usr_unidentified']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['unidentified'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_unidentified', "1") == "2") {
										if (!is_null($resultUser['usr_unidentified'])) {
						$tmpCount = (float)$counts["unidentified"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["unidentified"] = $tmpCount;
					}
				}
				if (P('show_pdf_unidentified', "1") == "3") {
										if (!is_null($resultUser['usr_unidentified'])) {
						$tmpSum = (float)$sums["unidentified"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_unidentified'];
						}
						$sums["unidentified"] = $tmpSum;
					}
				}
				if (P('show_pdf_unidentified', "1") == "4") {
										if (!is_null($resultUser['usr_unidentified'])) {
						$tmpCount = (float)$avgCounts["unidentified"];
						$tmpSum = (float)$avgSums["unidentified"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["unidentified"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_unidentified'];
						}
						$avgSums["unidentified"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_confirmed', "0") != "0") {
			$renderCriteria = "";
			switch ($resultUser['usr_confirmed']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['confirmed'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_confirmed', "1") == "2") {
										if (!is_null($resultUser['usr_confirmed'])) {
						$tmpCount = (float)$counts["confirmed"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["confirmed"] = $tmpCount;
					}
				}
				if (P('show_pdf_confirmed', "1") == "3") {
										if (!is_null($resultUser['usr_confirmed'])) {
						$tmpSum = (float)$sums["confirmed"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_confirmed'];
						}
						$sums["confirmed"] = $tmpSum;
					}
				}
				if (P('show_pdf_confirmed', "1") == "4") {
										if (!is_null($resultUser['usr_confirmed'])) {
						$tmpCount = (float)$avgCounts["confirmed"];
						$tmpSum = (float)$avgSums["confirmed"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["confirmed"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_confirmed'];
						}
						$avgSums["confirmed"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_accepted', "0") != "0") {
			$renderCriteria = "";
			switch ($resultUser['usr_accepted']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['accepted'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_accepted', "1") == "2") {
										if (!is_null($resultUser['usr_accepted'])) {
						$tmpCount = (float)$counts["accepted"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["accepted"] = $tmpCount;
					}
				}
				if (P('show_pdf_accepted', "1") == "3") {
										if (!is_null($resultUser['usr_accepted'])) {
						$tmpSum = (float)$sums["accepted"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_accepted'];
						}
						$sums["accepted"] = $tmpSum;
					}
				}
				if (P('show_pdf_accepted', "1") == "4") {
										if (!is_null($resultUser['usr_accepted'])) {
						$tmpCount = (float)$avgCounts["accepted"];
						$tmpSum = (float)$avgSums["accepted"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["accepted"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultUser['usr_accepted'];
						}
						$avgSums["accepted"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_page', "1") == "1") {
			$parentValue = virgoPage::lookup($resultUser['usr_pge_id']);
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
			if (P('show_pdf_username', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['username'];
				if (P('show_pdf_username', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["username"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_password', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['password'];
				if (P('show_pdf_password', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["password"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_email', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['email'];
				if (P('show_pdf_email', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["email"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_first_name', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['first name'];
				if (P('show_pdf_first_name', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["first_name"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_last_name', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['last name'];
				if (P('show_pdf_last_name', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["last_name"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_session_id', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['session id'];
				if (P('show_pdf_session_id', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["session_id"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_ip', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['ip'];
				if (P('show_pdf_ip', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["ip"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_logged_in', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['logged in'];
				if (P('show_pdf_logged_in', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["logged_in"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_last_successful_login', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['last successful login'];
				if (P('show_pdf_last_successful_login', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["last_successful_login"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_last_failed_login', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['last failed login'];
				if (P('show_pdf_last_failed_login', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["last_failed_login"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_last_logout', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['last logout'];
				if (P('show_pdf_last_logout', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["last_logout"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_user_agent', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['user agent'];
				if (P('show_pdf_user_agent', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["user_agent"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_token', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['token'];
				if (P('show_pdf_token', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["token"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_unidentified', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['unidentified'];
				if (P('show_pdf_unidentified', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["unidentified"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_confirmed', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['confirmed'];
				if (P('show_pdf_confirmed', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["confirmed"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_accepted', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['accepted'];
				if (P('show_pdf_accepted', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["accepted"];
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
			if (P('show_pdf_username', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['username'];
				if (P('show_pdf_username', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["username"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_password', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['password'];
				if (P('show_pdf_password', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["password"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_email', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['email'];
				if (P('show_pdf_email', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["email"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_first_name', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['first name'];
				if (P('show_pdf_first_name', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["first_name"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_last_name', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['last name'];
				if (P('show_pdf_last_name', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["last_name"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_session_id', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['session id'];
				if (P('show_pdf_session_id', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["session_id"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_ip', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['ip'];
				if (P('show_pdf_ip', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["ip"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_logged_in', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['logged in'];
				if (P('show_pdf_logged_in', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["logged_in"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_last_successful_login', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['last successful login'];
				if (P('show_pdf_last_successful_login', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["last_successful_login"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_last_failed_login', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['last failed login'];
				if (P('show_pdf_last_failed_login', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["last_failed_login"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_last_logout', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['last logout'];
				if (P('show_pdf_last_logout', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["last_logout"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_user_agent', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['user agent'];
				if (P('show_pdf_user_agent', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["user_agent"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_token', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['token'];
				if (P('show_pdf_token', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["token"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_unidentified', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['unidentified'];
				if (P('show_pdf_unidentified', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["unidentified"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_confirmed', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['confirmed'];
				if (P('show_pdf_confirmed', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["confirmed"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_accepted', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['accepted'];
				if (P('show_pdf_accepted', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["accepted"], 2, ',', ' ');
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
			if (P('show_pdf_username', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['username'];
				if (P('show_pdf_username', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["username"] == 0 ? "-" : $avgSums["username"] / $avgCounts["username"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_password', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['password'];
				if (P('show_pdf_password', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["password"] == 0 ? "-" : $avgSums["password"] / $avgCounts["password"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_email', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['email'];
				if (P('show_pdf_email', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["email"] == 0 ? "-" : $avgSums["email"] / $avgCounts["email"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_first_name', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['first name'];
				if (P('show_pdf_first_name', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["first_name"] == 0 ? "-" : $avgSums["first_name"] / $avgCounts["first_name"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_last_name', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['last name'];
				if (P('show_pdf_last_name', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["last_name"] == 0 ? "-" : $avgSums["last_name"] / $avgCounts["last_name"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_session_id', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['session id'];
				if (P('show_pdf_session_id', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["session_id"] == 0 ? "-" : $avgSums["session_id"] / $avgCounts["session_id"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_ip', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['ip'];
				if (P('show_pdf_ip', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["ip"] == 0 ? "-" : $avgSums["ip"] / $avgCounts["ip"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_logged_in', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['logged in'];
				if (P('show_pdf_logged_in', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["logged_in"] == 0 ? "-" : $avgSums["logged_in"] / $avgCounts["logged_in"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_last_successful_login', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['last successful login'];
				if (P('show_pdf_last_successful_login', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["last_successful_login"] == 0 ? "-" : $avgSums["last_successful_login"] / $avgCounts["last_successful_login"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_last_failed_login', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['last failed login'];
				if (P('show_pdf_last_failed_login', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["last_failed_login"] == 0 ? "-" : $avgSums["last_failed_login"] / $avgCounts["last_failed_login"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_last_logout', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['last logout'];
				if (P('show_pdf_last_logout', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["last_logout"] == 0 ? "-" : $avgSums["last_logout"] / $avgCounts["last_logout"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_user_agent', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['user agent'];
				if (P('show_pdf_user_agent', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["user_agent"] == 0 ? "-" : $avgSums["user_agent"] / $avgCounts["user_agent"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_token', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['token'];
				if (P('show_pdf_token', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["token"] == 0 ? "-" : $avgSums["token"] / $avgCounts["token"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_unidentified', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['unidentified'];
				if (P('show_pdf_unidentified', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["unidentified"] == 0 ? "-" : $avgSums["unidentified"] / $avgCounts["unidentified"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_confirmed', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['confirmed'];
				if (P('show_pdf_confirmed', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["confirmed"] == 0 ? "-" : $avgSums["confirmed"] / $avgCounts["confirmed"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_accepted', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['accepted'];
				if (P('show_pdf_accepted', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["accepted"] == 0 ? "-" : $avgSums["accepted"] / $avgCounts["accepted"]);
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
				$reportTitle = T('USERS');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultUser = new virgoUser();
			$whereClauseUser = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseUser = $whereClauseUser . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_username', "1") != "0") {
					$data = $data . $stringDelimeter .'Username' . $stringDelimeter . $separator;
				}
				if (P('show_export_password', "0") != "0") {
					$data = $data . $stringDelimeter .'Password' . $stringDelimeter . $separator;
				}
				if (P('show_export_email', "0") != "0") {
					$data = $data . $stringDelimeter .'Email' . $stringDelimeter . $separator;
				}
				if (P('show_export_first_name', "0") != "0") {
					$data = $data . $stringDelimeter .'First name' . $stringDelimeter . $separator;
				}
				if (P('show_export_last_name', "0") != "0") {
					$data = $data . $stringDelimeter .'Last name' . $stringDelimeter . $separator;
				}
				if (P('show_export_session_id', "0") != "0") {
					$data = $data . $stringDelimeter .'Session id' . $stringDelimeter . $separator;
				}
				if (P('show_export_ip', "0") != "0") {
					$data = $data . $stringDelimeter .'Ip' . $stringDelimeter . $separator;
				}
				if (P('show_export_logged_in', "0") != "0") {
					$data = $data . $stringDelimeter .'Logged in' . $stringDelimeter . $separator;
				}
				if (P('show_export_last_successful_login', "0") != "0") {
					$data = $data . $stringDelimeter .'Last successful login' . $stringDelimeter . $separator;
				}
				if (P('show_export_last_failed_login', "0") != "0") {
					$data = $data . $stringDelimeter .'Last failed login' . $stringDelimeter . $separator;
				}
				if (P('show_export_last_logout', "0") != "0") {
					$data = $data . $stringDelimeter .'Last logout' . $stringDelimeter . $separator;
				}
				if (P('show_export_user_agent', "0") != "0") {
					$data = $data . $stringDelimeter .'User agent' . $stringDelimeter . $separator;
				}
				if (P('show_export_token', "0") != "0") {
					$data = $data . $stringDelimeter .'Token' . $stringDelimeter . $separator;
				}
				if (P('show_export_unidentified', "0") != "0") {
					$data = $data . $stringDelimeter .'Unidentified' . $stringDelimeter . $separator;
				}
				if (P('show_export_confirmed', "0") != "0") {
					$data = $data . $stringDelimeter .'Confirmed' . $stringDelimeter . $separator;
				}
				if (P('show_export_accepted', "0") != "0") {
					$data = $data . $stringDelimeter .'Accepted' . $stringDelimeter . $separator;
				}
				if (P('show_export_page', "1") != "0") {
					$data = $data . $stringDelimeter . 'Page ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_users.usr_id, prt_users.usr_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_username', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_username usr_username";
			} else {
				if ($defaultOrderColumn == "usr_username") {
					$orderColumnNotDisplayed = " prt_users.usr_username ";
				}
			}
			if (P('show_export_password', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_password usr_password";
			} else {
				if ($defaultOrderColumn == "usr_password") {
					$orderColumnNotDisplayed = " prt_users.usr_password ";
				}
			}
			if (P('show_export_email', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_email usr_email";
			} else {
				if ($defaultOrderColumn == "usr_email") {
					$orderColumnNotDisplayed = " prt_users.usr_email ";
				}
			}
			if (P('show_export_first_name', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_first_name usr_first_name";
			} else {
				if ($defaultOrderColumn == "usr_first_name") {
					$orderColumnNotDisplayed = " prt_users.usr_first_name ";
				}
			}
			if (P('show_export_last_name', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_last_name usr_last_name";
			} else {
				if ($defaultOrderColumn == "usr_last_name") {
					$orderColumnNotDisplayed = " prt_users.usr_last_name ";
				}
			}
			if (P('show_export_session_id', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_session_id usr_session_id";
			} else {
				if ($defaultOrderColumn == "usr_session_id") {
					$orderColumnNotDisplayed = " prt_users.usr_session_id ";
				}
			}
			if (P('show_export_ip', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_ip usr_ip";
			} else {
				if ($defaultOrderColumn == "usr_ip") {
					$orderColumnNotDisplayed = " prt_users.usr_ip ";
				}
			}
			if (P('show_export_logged_in', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_logged_in usr_logged_in";
			} else {
				if ($defaultOrderColumn == "usr_logged_in") {
					$orderColumnNotDisplayed = " prt_users.usr_logged_in ";
				}
			}
			if (P('show_export_last_successful_login', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_last_successful_login usr_last_successful_login";
			} else {
				if ($defaultOrderColumn == "usr_last_successful_login") {
					$orderColumnNotDisplayed = " prt_users.usr_last_successful_login ";
				}
			}
			if (P('show_export_last_failed_login', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_last_failed_login usr_last_failed_login";
			} else {
				if ($defaultOrderColumn == "usr_last_failed_login") {
					$orderColumnNotDisplayed = " prt_users.usr_last_failed_login ";
				}
			}
			if (P('show_export_last_logout', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_last_logout usr_last_logout";
			} else {
				if ($defaultOrderColumn == "usr_last_logout") {
					$orderColumnNotDisplayed = " prt_users.usr_last_logout ";
				}
			}
			if (P('show_export_user_agent', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_user_agent usr_user_agent";
			} else {
				if ($defaultOrderColumn == "usr_user_agent") {
					$orderColumnNotDisplayed = " prt_users.usr_user_agent ";
				}
			}
			if (P('show_export_token', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_token usr_token";
			} else {
				if ($defaultOrderColumn == "usr_token") {
					$orderColumnNotDisplayed = " prt_users.usr_token ";
				}
			}
			if (P('show_export_unidentified', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_unidentified usr_unidentified";
			} else {
				if ($defaultOrderColumn == "usr_unidentified") {
					$orderColumnNotDisplayed = " prt_users.usr_unidentified ";
				}
			}
			if (P('show_export_confirmed', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_confirmed usr_confirmed";
			} else {
				if ($defaultOrderColumn == "usr_confirmed") {
					$orderColumnNotDisplayed = " prt_users.usr_confirmed ";
				}
			}
			if (P('show_export_accepted', "0") != "0") {
				$queryString = $queryString . ", prt_users.usr_accepted usr_accepted";
			} else {
				if ($defaultOrderColumn == "usr_accepted") {
					$orderColumnNotDisplayed = " prt_users.usr_accepted ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_export_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_users.usr_pge_id as usr_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_users ";
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_users.usr_pge_id = prt_pages_parent.pge_id) ";
			}

			$resultsUser = $resultUser->select(
				'', 
				'all', 
				$resultUser->getOrderColumn(), 
				$resultUser->getOrderMode(), 
				$whereClauseUser,
				$queryString);
			foreach ($resultsUser as $resultUser) {
				if (P('show_export_username', "1") != "0") {
			$data = $data . $stringDelimeter . $resultUser['usr_username'] . $stringDelimeter . $separator;
				}
				if (P('show_export_password', "0") != "0") {
			$data = $data . $resultUser['usr_password'] . $separator;
				}
				if (P('show_export_email', "0") != "0") {
			$data = $data . $resultUser['usr_email'] . $separator;
				}
				if (P('show_export_first_name', "0") != "0") {
			$data = $data . $stringDelimeter . $resultUser['usr_first_name'] . $stringDelimeter . $separator;
				}
				if (P('show_export_last_name', "0") != "0") {
			$data = $data . $stringDelimeter . $resultUser['usr_last_name'] . $stringDelimeter . $separator;
				}
				if (P('show_export_session_id', "0") != "0") {
			$data = $data . $stringDelimeter . $resultUser['usr_session_id'] . $stringDelimeter . $separator;
				}
				if (P('show_export_ip', "0") != "0") {
			$data = $data . $stringDelimeter . $resultUser['usr_ip'] . $stringDelimeter . $separator;
				}
				if (P('show_export_logged_in', "0") != "0") {
			$data = $data . $resultUser['usr_logged_in'] . $separator;
				}
				if (P('show_export_last_successful_login', "0") != "0") {
			$data = $data . $resultUser['usr_last_successful_login'] . $separator;
				}
				if (P('show_export_last_failed_login', "0") != "0") {
			$data = $data . $resultUser['usr_last_failed_login'] . $separator;
				}
				if (P('show_export_last_logout', "0") != "0") {
			$data = $data . $resultUser['usr_last_logout'] . $separator;
				}
				if (P('show_export_user_agent', "0") != "0") {
			$data = $data . $stringDelimeter . $resultUser['usr_user_agent'] . $stringDelimeter . $separator;
				}
				if (P('show_export_token', "0") != "0") {
			$data = $data . $stringDelimeter . $resultUser['usr_token'] . $stringDelimeter . $separator;
				}
				if (P('show_export_unidentified', "0") != "0") {
			$data = $data . $resultUser['usr_unidentified'] . $separator;
				}
				if (P('show_export_confirmed', "0") != "0") {
			$data = $data . $resultUser['usr_confirmed'] . $separator;
				}
				if (P('show_export_accepted', "0") != "0") {
			$data = $data . $resultUser['usr_accepted'] . $separator;
				}
				if (P('show_export_page', "1") != "0") {
					$parentValue = virgoPage::lookup($resultUser['usr_pge_id']);
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
				$reportTitle = T('USERS');
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
			$resultUser = new virgoUser();
			$whereClauseUser = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseUser = $whereClauseUser . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_username', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Username');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_password', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Password');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_email', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Email');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_first_name', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'First name');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_last_name', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Last name');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_session_id', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Session id');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_ip', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Ip');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_logged_in', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Logged in');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_last_successful_login', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Last successful login');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_last_failed_login', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Last failed login');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_last_logout', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Last logout');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_user_agent', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'User agent');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_token', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Token');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_unidentified', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Unidentified');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_confirmed', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Confirmed');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_accepted', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Accepted');
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
			$queryString = " SELECT prt_users.usr_id, prt_users.usr_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_username', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_username usr_username";
			} else {
				if ($defaultOrderColumn == "usr_username") {
					$orderColumnNotDisplayed = " prt_users.usr_username ";
				}
			}
			if (P('show_export_password', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_password usr_password";
			} else {
				if ($defaultOrderColumn == "usr_password") {
					$orderColumnNotDisplayed = " prt_users.usr_password ";
				}
			}
			if (P('show_export_email', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_email usr_email";
			} else {
				if ($defaultOrderColumn == "usr_email") {
					$orderColumnNotDisplayed = " prt_users.usr_email ";
				}
			}
			if (P('show_export_first_name', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_first_name usr_first_name";
			} else {
				if ($defaultOrderColumn == "usr_first_name") {
					$orderColumnNotDisplayed = " prt_users.usr_first_name ";
				}
			}
			if (P('show_export_last_name', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_last_name usr_last_name";
			} else {
				if ($defaultOrderColumn == "usr_last_name") {
					$orderColumnNotDisplayed = " prt_users.usr_last_name ";
				}
			}
			if (P('show_export_session_id', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_session_id usr_session_id";
			} else {
				if ($defaultOrderColumn == "usr_session_id") {
					$orderColumnNotDisplayed = " prt_users.usr_session_id ";
				}
			}
			if (P('show_export_ip', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_ip usr_ip";
			} else {
				if ($defaultOrderColumn == "usr_ip") {
					$orderColumnNotDisplayed = " prt_users.usr_ip ";
				}
			}
			if (P('show_export_logged_in', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_logged_in usr_logged_in";
			} else {
				if ($defaultOrderColumn == "usr_logged_in") {
					$orderColumnNotDisplayed = " prt_users.usr_logged_in ";
				}
			}
			if (P('show_export_last_successful_login', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_last_successful_login usr_last_successful_login";
			} else {
				if ($defaultOrderColumn == "usr_last_successful_login") {
					$orderColumnNotDisplayed = " prt_users.usr_last_successful_login ";
				}
			}
			if (P('show_export_last_failed_login', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_last_failed_login usr_last_failed_login";
			} else {
				if ($defaultOrderColumn == "usr_last_failed_login") {
					$orderColumnNotDisplayed = " prt_users.usr_last_failed_login ";
				}
			}
			if (P('show_export_last_logout', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_last_logout usr_last_logout";
			} else {
				if ($defaultOrderColumn == "usr_last_logout") {
					$orderColumnNotDisplayed = " prt_users.usr_last_logout ";
				}
			}
			if (P('show_export_user_agent', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_user_agent usr_user_agent";
			} else {
				if ($defaultOrderColumn == "usr_user_agent") {
					$orderColumnNotDisplayed = " prt_users.usr_user_agent ";
				}
			}
			if (P('show_export_token', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_token usr_token";
			} else {
				if ($defaultOrderColumn == "usr_token") {
					$orderColumnNotDisplayed = " prt_users.usr_token ";
				}
			}
			if (P('show_export_unidentified', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_unidentified usr_unidentified";
			} else {
				if ($defaultOrderColumn == "usr_unidentified") {
					$orderColumnNotDisplayed = " prt_users.usr_unidentified ";
				}
			}
			if (P('show_export_confirmed', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_confirmed usr_confirmed";
			} else {
				if ($defaultOrderColumn == "usr_confirmed") {
					$orderColumnNotDisplayed = " prt_users.usr_confirmed ";
				}
			}
			if (P('show_export_accepted', "1") != "0") {
				$queryString = $queryString . ", prt_users.usr_accepted usr_accepted";
			} else {
				if ($defaultOrderColumn == "usr_accepted") {
					$orderColumnNotDisplayed = " prt_users.usr_accepted ";
				}
			}
			if (class_exists('portal\virgoPage') && P('show_export_page', "1") != "0") { // */ && !in_array("pge", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_users.usr_pge_id as usr_pge_id ";
				$queryString = $queryString . ", prt_pages_parent.pge_virgo_title as `page` ";
			} else {
				if ($defaultOrderColumn == "page") {
					$orderColumnNotDisplayed = " prt_pages_parent.pge_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_users ";
			if (class_exists('portal\virgoPage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_pages AS prt_pages_parent ON (prt_users.usr_pge_id = prt_pages_parent.pge_id) ";
			}

			$resultsUser = $resultUser->select(
				'', 
				'all', 
				$resultUser->getOrderColumn(), 
				$resultUser->getOrderMode(), 
				$whereClauseUser,
				$queryString);
			$index = 1;
			foreach ($resultsUser as $resultUser) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultUser['usr_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_username', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUser['usr_username'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_password', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUser['usr_password'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_email', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUser['usr_email'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_first_name', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUser['usr_first_name'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_last_name', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUser['usr_last_name'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_session_id', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUser['usr_session_id'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_ip', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUser['usr_ip'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_logged_in', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUser['usr_logged_in'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_last_successful_login', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUser['usr_last_successful_login'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_last_failed_login', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUser['usr_last_failed_login'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_last_logout', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUser['usr_last_logout'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_user_agent', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUser['usr_user_agent'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_token', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUser['usr_token'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_unidentified', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUser['usr_unidentified'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_confirmed', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUser['usr_confirmed'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_accepted', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultUser['usr_accepted'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_page', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoPage::lookup($resultUser['usr_pge_id']);
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
					$propertyColumnHash['username'] = 'usr_username';
					$propertyColumnHash['username'] = 'usr_username';
					$propertyColumnHash['password'] = 'usr_password';
					$propertyColumnHash['password'] = 'usr_password';
					$propertyColumnHash['email'] = 'usr_email';
					$propertyColumnHash['email'] = 'usr_email';
					$propertyColumnHash['first name'] = 'usr_first_name';
					$propertyColumnHash['first_name'] = 'usr_first_name';
					$propertyColumnHash['last name'] = 'usr_last_name';
					$propertyColumnHash['last_name'] = 'usr_last_name';
					$propertyColumnHash['session id'] = 'usr_session_id';
					$propertyColumnHash['session_id'] = 'usr_session_id';
					$propertyColumnHash['ip'] = 'usr_ip';
					$propertyColumnHash['ip'] = 'usr_ip';
					$propertyColumnHash['logged in'] = 'usr_logged_in';
					$propertyColumnHash['logged_in'] = 'usr_logged_in';
					$propertyColumnHash['last successful login'] = 'usr_last_successful_login';
					$propertyColumnHash['last_successful_login'] = 'usr_last_successful_login';
					$propertyColumnHash['last failed login'] = 'usr_last_failed_login';
					$propertyColumnHash['last_failed_login'] = 'usr_last_failed_login';
					$propertyColumnHash['last logout'] = 'usr_last_logout';
					$propertyColumnHash['last_logout'] = 'usr_last_logout';
					$propertyColumnHash['user agent'] = 'usr_user_agent';
					$propertyColumnHash['user_agent'] = 'usr_user_agent';
					$propertyColumnHash['token'] = 'usr_token';
					$propertyColumnHash['token'] = 'usr_token';
					$propertyColumnHash['unidentified'] = 'usr_unidentified';
					$propertyColumnHash['unidentified'] = 'usr_unidentified';
					$propertyColumnHash['confirmed'] = 'usr_confirmed';
					$propertyColumnHash['confirmed'] = 'usr_confirmed';
					$propertyColumnHash['accepted'] = 'usr_accepted';
					$propertyColumnHash['accepted'] = 'usr_accepted';
					$propertyClassHash['page'] = 'Page';
					$propertyClassHash['page'] = 'Page';
					$propertyColumnHash['page'] = 'usr_pge_id';
					$propertyColumnHash['page'] = 'usr_pge_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importUser = new virgoUser();
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
										L(T('PROPERTY_NOT_FOUND', T('USER'), $columns[$index]), '', 'ERROR');
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
										$importUser->$fieldName = $value;
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
	$importUser->setPgeId($defaultValue);
}
							$errorMessage = $importUser->store();
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
		



		static function portletActionPreviousYear() {
			$pob = self::getMyPortletObject();
			$selectedYear = $pob->getPortletSessionValue('selected_year', date("Y"));
			$pob->setPortletSessionValue('selected_year', $selectedYear-1);
		}

		static function portletActionPreviousMonth() {
			$pob = self::getMyPortletObject();
			$selectedMonth = $pob->getPortletSessionValue('selected_month', date("m"));
			$selectedMonth = $selectedMonth - 1;
			if ($selectedMonth == 0) {
				$selectedMonth = 12;
				$pob->portletActionPreviousYear();
			}
			$pob->setPortletSessionValue('selected_month', $selectedMonth);
		}

		static function portletActionNextYear() {
			$pob = self::getMyPortletObject();
			$selectedYear = $pob->getPortletSessionValue('selected_year', date("Y"));
			$pob->setPortletSessionValue('selected_year', $selectedYear+1);
		}

		static function portletActionNextMonth() {			
			$pob = self::getMyPortletObject();
			$selectedMonth = $pob->getPortletSessionValue('selected_month', date("m"));
			$selectedMonth = $selectedMonth + 1;
			if ($selectedMonth == 13) {
				$selectedMonth = 1;
				$pob->portletActionNextYear();
			}
			$pob->setPortletSessionValue('selected_month', $selectedMonth);
		}

		static function portletActionCurrentMonth() {
			$pob = self::getMyPortletObject();
			$pob->setPortletSessionValue('selected_month', date("m"));
			$pob->setPortletSessionValue('selected_year', date("Y"));
		}

		static function portletActionSetMonth() {
			$pob = self::getMyPortletObject();
			$selectedMonth = R('virgo_cal_selected_month');
			$pob->setPortletSessionValue('selected_month', $selectedMonth);
		}

		static function portletActionSetYear() {
			$pob = self::getMyPortletObject();
			$selectedYear = R('virgo_cal_selected_year');
			$pob->setPortletSessionValue('selected_year', $selectedYear);
		}

		static function portletActionVirgoSetPage() {
			$this->loadFromDB();
			$parentId = R('usr_Page_id_' . $_SESSION['current_portlet_object_id']);
			$this->setPgeId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}


		
		function addRoleByName($roleName) {
			return virgoRole::grantRoleToUserId($roleName, $this->getId());
		}
		
		static function generatePassword($length, $digitsOnly = false) {
			$chars = "1234567890" . ($digitsOnly ? "" : "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");
			$i = 0;
			$password = "";
			while ($i < $length) {
				$password .= $chars[mt_rand(0,strlen($chars)-1)];
				$i++;
			}
			return $password;
		}

		function setNewPassword($password) {
			$_POST['usr_password2_' . $this->getId()] = $password;
			$retPass = $password;
			$this->setPassword($password);
			LE($this->store());			
		}

		function generateNewPassword($passwordLength) {
			$password = virgoUser::generatePassword($passwordLength);
			$this->setNewPassword($password);
			return $password;
		}
		
		static function create($username, $roleName = null, $password = null, $passwordLength = null, $objectToPosess = null, $email = null) {
			$retPass = null;
			$user = new virgoUser();
			$user->setUsername($username);
			if (is_null($password)) {
				$password = virgoUser::generatePassword($passwordLength);
			}
			$_POST['usr_password2_'] = $password;
			$retPass = $password;
			$user->setPassword($password);
			if (isset($email)) {
				$user->setEmail($email);
			}
			$confirmationRequired = PP('CONFIRMATION_REQUIRED', '0');
			if (!$confirmationRequired) {
				$user->setConfirmed(true);
				$user->setAccepted(true);
			}
			$ret = $user->store();
			if ($ret != "") {
				L($ret, '', 'ERROR');
			} else {
				if (isset($objectToPosess)) {
					$objectToPosess->changeOwnershipAndStore($user->getId());
				}
				if (isset($roleName)) {
					$user->addRoleByName($roleName);
				}
				$page = virgoPage::getCurrentPage();
				$portal = $page->getPortal();
				$P = array('username' => $username, 'password' => $password, 'portal' => $portal->getName());
				$subject = E('CONFIRMATION_MAIL_SUBJECT', $P, true, 'Potwierdzenie założenia konta');
				if ($confirmationRequired) {
					$url = "http";
					if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
						$url .= "s";
					}
					$url .= "://" . $_SERVER["SERVER_NAME"];
					$confirmationPageId = PP('CONFIRMATION_PAGE_ID');
					if (isset($confirmationPageId)) {
						$confirmationPage = new virgoPage($confirmationPageId);
					} else {
						$confirmationPage = $page;
					}
					$url .= $confirmationPage->getUrl();
					$url = "{$url}?t=" . virgoUser::encryptString($user->getId());
					$P['url'] = $url;
					$_SESSION['confirmation_email_address'] = $email;
					$confirmationText = "Żeby potwierdzić chęć założenia konta kliknij ten link: {$url}\n\n";
				} else {
					$confirmationText = "";
				}
				$text = E('CONFIRMATION_MAIL_TEXT', $P, true, "Witaj {$username}!\n\nDziękujemy za założenie konta w naszym serwisie '{$portal->getName()}'.\n\nDane do logowania:\n\nNazwa użytkownika: {$username}\nHasło: {$password}\n\n{$confirmationText}Pozdrawiamy,\nzałoga portalu {$portal->getName()}");
				M($email, $subject, $text);					
				return $retPass;
			}
		}
		
		function hasRoleName($roleName) {
			$role = virgoRole::getByNameStatic($roleName);
			return virgoRole::userHasRoleObject($this->getId(), $role);
		}
		
		static function getUserByUsername($username) {
			$ret = virgoUser::selectAllAsObjectsStatic(" usr_username = '{$username}' ");
			if (sizeof($ret) == 0) {
				return null;
			}
			return $ret[0];
		}

		static function getUserId() {
			if (!isset($_SESSION['user_id'])) {
				virgoUser::getUser();
			}
			return $_SESSION['user_id'];
		}
		
		static function getUser() {
			global $customUserObject, $userClassName;
			if (!isset($_SESSION['user_id'])) {
				$query = virgoUser::getAnonymousUserQueryString();
				$userId = Q1($query);
				$_SESSION['user_id'] = $userId;				
				unset($_SESSION['current_role_id']);
				virgoUser::getCurrentRole($userId);
				if (I('UniqueVisit', 'portal', 'virgo', false)) {
					virgoUniqueVisit::logVisit();
				}
			} else {
				$userId = $_SESSION['user_id'];
			}
//			if (!isset($_REQUEST['virgo_last_interaction_stored'])) {
				if (isset($_SESSION['last_interaction_timestamp'])) {
					$last = $_SESSION['last_interaction_timestamp'];
					$current = time();
					$maxIddleTime = $_SESSION['current_role_session_duration'];
					if ($current - $last > $maxIddleTime) {
						virgoUser::logout(true, $userId);
					}
				}
				$_SESSION['last_interaction_timestamp'] = time();
//				$_REQUEST['virgo_last_interaction_stored'] = "yes";
//			}
			if (isset($customUserObject)) {
				return new $userClassName($userId);
			} else {
				return new virgoUser($userId);
			}
		} 	
		
		static function setCurrentRole($rleId, $duration = null) {
			if (!isset($rleId)) {
				unset($_SESSION['current_role_id']);
				virgoUser::getCurrentRole();
			} else {
				$_SESSION['current_role_id'] = $rleId;
				if (is_null($duration) || trim($duration) == "") {
					$role = new virgoRole($rleId);
					$duration = $role->getSessionDuration();
					if (is_null($duration) || trim($duration) == "") {
						$duration = 36000;
					}
				}
				$_SESSION['current_role_session_duration'] = $duration;
				$_SESSION['cache'] = array();
			}
		}
		
		static function getCurrentRole($usrId = null) {
			$ret = null;
			if (!isset($_SESSION['current_role_id'])) {
				if (is_null($usrId)) {
					$usrId = virgoUser::getUserId();
				}
				$rows = QR("SELECT url_rle_id, rle_session_duration FROM prt_user_roles, prt_roles WHERE url_usr_id = {$usrId} AND rle_id = url_rle_id ");
				foreach ($rows as $row) {
					$ret = $row['url_rle_id'];
					if (isset($ret)) {
						virgoUser::setCurrentRole($ret, $row['rle_session_duration']);
						if (virgoPage::getCurrentPage()->canView()) {
							break;
						}
					}
				}
			} else {
				$ret = $_SESSION['current_role_id'];
			}
			return $ret;
		}
		
												static function authenticate($username, $password) {
			$encrypted = virgoUser::encryptString($password);
			$query = virgoUser::getAuthenticationQueryString();
			$userId = null;
			$rows = QPR($query, "ss", array($username, $encrypted));
			foreach ($rows as $row) {
				$userId = $row['usr_id'];
				$confirmationRequired = PP('CONFIRMATION_REQUIRED', '0');
				if ($confirmationRequired == '1') {
					$userConfirmed = $row['usr_confirmed'];
					if ($userConfirmed != 1) {
						return -1;
					}
				}
				$acceptanceRequired = PP('ACCTEPTANCE_REQUIRED', '0');
				if ($acceptanceRequired == '1') {
					$userAccepted = $row['usr_accepted'];
					if ($userAccepted != 1) {
						return -2;
					}
				}
			}
			if (isset($userId)) {
				return $userId; 
			} else {
				return 0;
			}
		}
		
		static function login($username, $password) {
			$ret = virgoUser::authenticate($username, $password);
			if ($ret > 0) {
				$_SESSION['user_id'] = $ret;
				virgoUser::setCurrentRole(null, null);
				virgoUser::afterLogin($ret);
				return 0;
			}
			switch ($ret) {
				case 0:
					L(T('LOGIN_INCORRECT'), '', 'ERROR');
					return 0;
				case -1: 
					L(T('USER_NOT_CONFIRMED'), '', 'ERROR');
					return 0;
				case -2:
					L(T('USER_NOT_ACCEPTED'), '', 'ERROR');
					return 0;
			}
		}
		
		static function logout($forced = false, $usrId = null) {
			virgoUser::beforeLogout($usrId);
			$_SESSION = array();
			if (ini_get("session.use_cookies")) {
			    $params = session_get_cookie_params();
			    setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			    );
			}
			session_destroy();
			session_start();			
			if (!$forced) {
				L(T('LOGOUT_SUCCESFUL'), '', 'INFO');
			} else {
				L('Your session expired due to inactivity time. Please log in again.', '', 'ERROR');
			}
			unset($_SESSION['user_id']);
			if (PP('PRESERVE_PAGE_ON_LOGIN', '1') == '0') {
				virgoPage::redirectDefault();
			} else {
				if (!virgoPage::redirectUrl(null, true)) {
					virgoPage::redirectDefault();
				}
			}
		}
		
		static function getSessionDuration($currentRole = null) {
			if (is_null($currentRole)) {
				$currentRoleId = virgoUser::getCurrentRole();
				$currentRole = new virgoRole($currentRoleId);
			}
			$duration = $currentRole->getSessionDuration();
			if (isset($duration)) {
				return $duration;
			} else {
				return 36000;
			}
		}		

		static function encryptString($string) {
			global $virgoConfig;
			if (isset($virgoConfig[VIRGO_PORTAL_INSTANCE]['salt1'])) {
				$salt1 = $virgoConfig[VIRGO_PORTAL_INSTANCE]['salt1'];
			} else {
				$salt1 = "Lokfdsjh8f fdjsahfa8";
			}
			if (isset($virgoConfig[VIRGO_PORTAL_INSTANCE]['salt2'])) {
				$salt2 = $virgoConfig[VIRGO_PORTAL_INSTANCE]['salt2'];
			} else {
				$salt2 = "fasfa77 7b78fsadfhd hfhdhsafduasydfyfr7877[1";
			}
			return hash('sha256', $salt1 . $string . $salt2);
		}
		
		static function getAnonymousUserQueryString() {
				return <<<SQL
SELECT 
	usr_id 
FROM 
	prt_users
WHERE 
	usr_unidentified = 1
SQL;
		}
		
		static function getAuthenticationQueryString() {
				return <<<SQL
SELECT 
	usr_id, usr_confirmed, usr_accepted
FROM 
	prt_users
WHERE 
	usr_username = ?
	AND usr_password = ?
SQL;
		}
				
		static function afterLogin($userId) {
			global $customUserObject;
			if (isset($customUserObject)) {
				return $customUserObject->afterLogin($userId);
			}
			
			$user = virgoUser::getUser();
			if (virgoUser::getVirgoTableType() == "BASE TABLE") {
				$user->setSessionId(session_id());
				$user->setIp($_SERVER['REMOTE_ADDR']);
				$user->setLoggedIn(1);
				$user->setLastSuccessfulLogin(date("Y-m-d H:i:s"));
				$user->setUserAgent($_SERVER['HTTP_USER_AGENT']);
				$user->store();
			}
			$page = $user->getPage();
			if (!is_null($page->getId())) {
				$page->redirect();
			}
			foreach ($user->getUserRoles() as $userRole) {
				$page = $userRole->getRole()->getPage();
				if (!is_null($page->getId())) {
					$page->redirect();
				}
			}
			if (PP('PRESERVE_PAGE_ON_LOGIN', '1') == '0') {
				virgoPage::redirectDefault();
			}
		}				
		
		static function beforeLogout($usrId = null) {
			global $customUserObject;
			if (isset($customUserObject)) {
				return $customUserObject->beforeLogout();
			}
			if (virgoUser::getVirgoTableType() == "BASE TABLE") {
				if (isset($usrId)) {
					$user = new virgoUser($usrId);
				} else {
					$user = virgoUser::getUser();
				}
				$user->setLoggedIn(0);
				$user->setLastLogout(date("Y-m-d H:i:s"));
				$user->store();
			}
		}

		static function confirmUser($token) {
			$query = virgoUser::getToConfirm();
			$rows = QR($query);
			$token = R('t');
			$ok = false;
			foreach ($rows as $row) {
				if (virgoUser::encryptString($row['usr_id']) == $token) {
					$user = new virgoUser($row['usr_id']);
					$user->setConfirmed(1);
					$user->store();
					$ok = true;
					break;
				}
			}
			return $ok;
		}

		function sendMail($mailParamName) {
			$email = $this->getEmail();
			if (S($email)) {
				return MP($email, $mailParamName);
			} else {
				L('Email not found, userId = ' . $this->getId(), null, 'ERROR');
				return false;
			}
		}


		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `prt_users` (
  `usr_id` bigint(20) unsigned NOT NULL auto_increment,
  `usr_virgo_state` varchar(50) default NULL,
  `usr_virgo_title` varchar(255) default NULL,
	`usr_pge_id` int(11) default NULL,
  `usr_username` varchar(255), 
  `usr_password` varchar(2000), 
  `usr_email` varchar(255), 
  `usr_first_name` varchar(255), 
  `usr_last_name` varchar(255), 
  `usr_session_id` varchar(255), 
  `usr_ip` varchar(255), 
  `usr_logged_in` boolean,  
  `usr_last_successful_login` datetime, 
  `usr_last_failed_login` datetime, 
  `usr_last_logout` datetime, 
  `usr_user_agent` varchar(255), 
  `usr_token` varchar(255), 
  `usr_unidentified` boolean,  
  `usr_confirmed` boolean,  
  `usr_accepted` boolean,  
  `usr_date_created` datetime NOT NULL,
  `usr_date_modified` datetime default NULL,
  `usr_usr_created_id` int(11) NOT NULL,
  `usr_usr_modified_id` int(11) default NULL,
  KEY `usr_pge_fk` (`usr_pge_id`),
  PRIMARY KEY  (`usr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/user.sql 
INSERT INTO `prt_users` (`usr_virgo_title`, `usr_username`, `usr_password`, `usr_email`, `usr_first_name`, `usr_last_name`, `usr_session_id`, `usr_ip`, `usr_logged_in`, `usr_last_successful_login`, `usr_last_failed_login`, `usr_last_logout`, `usr_user_agent`, `usr_token`, `usr_unidentified`, `usr_confirmed`, `usr_accepted`) 
VALUES (title, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_users table already exists.", '', 'FATAL');
				L("Error ocurred, please contact site Administrator.", '', 'ERROR');
 				return false;
 			}
 			return true;
 		}


		static function onInstall($pobId, $title) {
		}

		static function getIdByKeyUsername($username) {
			$query = " SELECT usr_id FROM prt_users WHERE 1 ";
			$query .= " AND usr_username = '{$username}' ";
			$rows = QR($query);
			foreach ($rows as $row) {
				return $row['usr_id'];
			}
			return null;
		}

		static function getByKeyUsername($username) {
			$id = self::getIdByKeyUsername($username);
			$ret = new virgoUser();
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
			return "usr";
		}
		
		static function getPlural() {
			return "users";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoPage";
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoUserRole";
			$ret[] = "virgoSystemMessage";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_users'));
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
			$virgoVersion = virgoUser::getVirgoVersion();
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
	
	
