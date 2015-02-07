<?php
	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	if (preg_match("/.*.metadetron.com/i", $_SERVER["SERVER_NAME"])) {
	    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	} 
	ini_set('display_errors', 1);

	use portal\virgoRole;
	use portal\virgoPage;
	use portal\virgoUser;
	use portal\virgoPortletObject;

//	setlocale(LC_ALL, '$messages.LOCALE');
//	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php');
	$componentParams = null; //&JComponentHelper::getParams('com_prt_user');
	$underConstruction = false; //$componentParams->get('under_construction');
	$underConstructionAllowedUser = ''; //$componentParams->get('under_construction_allowed_user');
	$context = array();

	if (false) { //$underConstruction == "1" && (is_null($user) || ($user->username != "metaadmin" && $user->username != $underConstructionAllowedUser))) {
?>
		<div style="color: #FF6666; font-size: 2em; margin: 100px; text-align: center;">
			Komponent w trakcie przebudowy.
		</div>
<?php
	} else {
		if (false) { //$underConstruction == "1" && !is_null($user) && ($user->username == "metaadmin" || $user->username == $underConstructionAllowedUser)) {
?>
		<div style="background-color: #FFFF00; border: 1px dashed; color: #111111; font-family: monospace; font-size: 1.2em; font-weight: bold; margin: 0; padding: 2px; text-align: center;">
			Komponent w trakcie przebudowy.
		</div>
<?php
		}
?>
<?php
?>
<?php
?>
<?php
	$live_site = "localhost";
	if (false) { //$componentParams->get('css_usage') == "virgo" || $componentParams->get('css_usage') == "") {
?>
<link rel="stylesheet" href="<?php echo $live_site ?>/components/com_prt_user/portal.css" type="text/css" /> 
<?php
	}
?>
<?php
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'prt_usr.css')) {
?>
<link rel="stylesheet" href="<?php echo $_SESSION['portal_url'] ?>/portlets/portal/virgoUser/prt_usr.css" type="text/css" /> 
<?php
	}
?>
<style>

td#component {
    background-color: inherit !important;
    border: inherit !important;
    color: inherit !important;
    padding: inherit !important;
    text-shadow: inherit !important;
    font-size: inherit !important;
  }
</style>
<div class="virgo_container_portal virgo_container_entity_user" style="border: none;">
	<div class="virgo_scrollable">
<?php
			}
		$tablePrefixes = array();
//		$classNames = array();
		$etityNames = array();		
		$parents = array();
		$tablePrefixes["user"] = "usr";
//		$classNames["user"] = "virgoUser";
		$entityNames["user"] = "User";
		$tmpParents = array();
		$tmpParents[] = "page";
		$parents["user"] = $tmpParents;
		$tablePrefixes["role"] = "rle";
//		$classNames["role"] = "virgoRole";
		$entityNames["role"] = "Role";
		$tmpParents = array();
		$tmpParents[] = "page";
		$parents["role"] = $tmpParents;
		$tablePrefixes["user_role"] = "url";
//		$classNames["user_role"] = "virgoUserRole";
		$entityNames["user_role"] = "UserRole";
		$tmpParents = array();
		$tmpParents[] = "role";
		$tmpParents[] = "user";
		$parents["user_role"] = $tmpParents;
		$tablePrefixes["page"] = "pge";
//		$classNames["page"] = "virgoPage";
		$entityNames["page"] = "Page";
		$tmpParents = array();
		$tmpParents[] = "template";
		$tmpParents[] = "page";
		$tmpParents[] = "portal";
		$parents["page"] = $tmpParents;
		$tablePrefixes["permission"] = "prm";
//		$classNames["permission"] = "virgoPermission";
		$entityNames["permission"] = "Permission";
		$tmpParents = array();
		$tmpParents[] = "role";
		$tmpParents[] = "page";
		$tmpParents[] = "portlet_object";
		$parents["permission"] = $tmpParents;
		$tablePrefixes["template"] = "tmp";
//		$classNames["template"] = "virgoTemplate";
		$entityNames["template"] = "Template";
		$tmpParents = array();
		$parents["template"] = $tmpParents;
		$tablePrefixes["portlet_definition"] = "pdf";
//		$classNames["portlet_definition"] = "virgoPortletDefinition";
		$entityNames["portlet_definition"] = "PortletDefinition";
		$tmpParents = array();
		$parents["portlet_definition"] = $tmpParents;
		$tablePrefixes["portlet_object"] = "pob";
//		$classNames["portlet_object"] = "virgoPortletObject";
		$entityNames["portlet_object"] = "PortletObject";
		$tmpParents = array();
		$tmpParents[] = "portlet_definition";
		$tmpParents[] = "portlet_object";
		$parents["portlet_object"] = $tmpParents;
		$tablePrefixes["portlet_location"] = "plc";
//		$classNames["portlet_location"] = "virgoPortletLocation";
		$entityNames["portlet_location"] = "PortletLocation";
		$tmpParents = array();
		$tmpParents[] = "page";
		$tmpParents[] = "portlet_object";
		$tmpParents[] = "portal";
		$parents["portlet_location"] = $tmpParents;
		$tablePrefixes["html_content"] = "hcn";
//		$classNames["html_content"] = "virgoHtmlContent";
		$entityNames["html_content"] = "HtmlContent";
		$tmpParents = array();
		$tmpParents[] = "portlet_object";
		$tmpParents[] = "language";
		$parents["html_content"] = $tmpParents;
		$tablePrefixes["language"] = "lng";
//		$classNames["language"] = "virgoLanguage";
		$entityNames["language"] = "Language";
		$tmpParents = array();
		$parents["language"] = $tmpParents;
		$tablePrefixes["translation"] = "trn";
//		$classNames["translation"] = "virgoTranslation";
		$entityNames["translation"] = "Translation";
		$tmpParents = array();
		$tmpParents[] = "language";
		$parents["translation"] = $tmpParents;
		$tablePrefixes["log_level"] = "llv";
//		$classNames["log_level"] = "virgoLogLevel";
		$entityNames["log_level"] = "LogLevel";
		$tmpParents = array();
		$parents["log_level"] = $tmpParents;
		$tablePrefixes["log_channel"] = "lch";
//		$classNames["log_channel"] = "virgoLogChannel";
		$entityNames["log_channel"] = "LogChannel";
		$tmpParents = array();
		$parents["log_channel"] = $tmpParents;
		$tablePrefixes["system_message"] = "sms";
//		$classNames["system_message"] = "virgoSystemMessage";
		$entityNames["system_message"] = "SystemMessage";
		$tmpParents = array();
		$tmpParents[] = "user";
		$tmpParents[] = "log_level";
		$tmpParents[] = "execution";
		$parents["system_message"] = $tmpParents;
		$tablePrefixes["channel_level"] = "clv";
//		$classNames["channel_level"] = "virgoChannelLevel";
		$entityNames["channel_level"] = "ChannelLevel";
		$tmpParents = array();
		$tmpParents[] = "log_level";
		$tmpParents[] = "log_channel";
		$parents["channel_level"] = $tmpParents;
		$tablePrefixes["portlet_parameter"] = "ppr";
//		$classNames["portlet_parameter"] = "virgoPortletParameter";
		$entityNames["portlet_parameter"] = "PortletParameter";
		$tmpParents = array();
		$tmpParents[] = "portlet_object";
		$tmpParents[] = "portlet_definition";
		$tmpParents[] = "portal";
		$tmpParents[] = "template";
		$parents["portlet_parameter"] = $tmpParents;
		$tablePrefixes["portal"] = "prt";
//		$classNames["portal"] = "virgoPortal";
		$entityNames["portal"] = "Portal";
		$tmpParents = array();
		$tmpParents[] = "template";
		$parents["portal"] = $tmpParents;
		$tablePrefixes["process"] = "prc";
//		$classNames["process"] = "virgoProcess";
		$entityNames["process"] = "Process";
		$tmpParents = array();
		$parents["process"] = $tmpParents;
		$tablePrefixes["execution"] = "exc";
//		$classNames["execution"] = "virgoExecution";
		$entityNames["execution"] = "Execution";
		$tmpParents = array();
		$tmpParents[] = "process";
		$parents["execution"] = $tmpParents;
		$tablePrefixes["element"] = "elm";
//		$classNames["element"] = "virgoElement";
		$entityNames["element"] = "Element";
		$tmpParents = array();
		$tmpParents[] = "execution";
		$parents["element"] = $tmpParents;
		$tablePrefixes["execution_parameter"] = "epr";
//		$classNames["execution_parameter"] = "virgoExecutionParameter";
		$entityNames["execution_parameter"] = "ExecutionParameter";
		$tmpParents = array();
		$tmpParents[] = "execution";
		$parents["execution_parameter"] = $tmpParents;
		$tablePrefixes["unique_visit"] = "uvs";
//		$classNames["unique_visit"] = "virgoUniqueVisit";
		$entityNames["unique_visit"] = "UniqueVisit";
		$tmpParents = array();
		$parents["unique_visit"] = $tmpParents;
		$ancestors = array();
		$ancestors["portal"] = "TRUE";
		$ancestors["template"] = "TRUE";
		$ancestors["page"] = "TRUE";
		$contextId = null;		
			$resultUser = virgoUser::createGuiAware();
			$contextId = $resultUser->getContextId();
			if (isset($contextId)) {
				if (virgoUser::getDisplayMode() != "CREATE" || R('portlet_action') == "Duplicate") {
					$resultUser->load($contextId);
				}
			}
?>
<?php
			if (false) { //$componentParams->get('show_project_name') == "1") {
?>
		<div id="virgo_project">
<?php
  $parentMenu = null; //$menu->getItem($menuItem->parent);
?>
			portal: <?php echo is_null($parentMenu) ? $mainframe->getPageTitle() : $parentMenu->name . " -> " . $mainframe->getPageTitle() ?>
			<span id="virgo_project_version">
				1.5 
			</span>
<!--




-->
<span 
	title="header=[<?php echo JText::_('VERSIONS') ?>]cssheader=[tooltip_header]cssbody=[tooltip_body]body=
[
0.1.2 -
Minor features added
<br>
0.1.1 -
Binary bool added
<br>
0.1.0 -
<b>
beta
</b>
<br>
]">0.1.2</span>
			<span class="virgo_connected_as">
<?php
				if (is_null($user->username)) {
?>
<?php echo T('NOT_LOGGED_IN') ?><?php
				} else {
?>
<?php echo T('LOGGED_IN_AS') ?>					<span class="virgo_username"><?php echo $user->username ?></span>.
<?php
				}
?>
			</span>
		</div>
<?php
			}
	$masterPobId = P('master_entity_pob_id');
	if (isset($masterPobId)) {
		$portletObject = new virgoPortletObject($masterPobId);
		$className = $portletObject->getPortletDefinition()->getAlias();
		if ($className == "virgoUser") {
			$masterObject = new $className();
			$tmpId = $masterObject->getRemoteContextId($masterPobId);
			if (isset($tmpId)) {
				$resultUser = new virgoUser($tmpId);
				virgoUser::setDisplayMode("FORM");
			} else {
				$resultUser = new virgoUser();
				virgoUser::setDisplayMode("CREATE");
			}
		}
	} else {
		if (P('form_only', "0") == "5") {
			if (is_null($resultUser->getId())) { 
				if (P('only_private_records', "0") == "1") {
					$allPrivateRecords = $resultUser->selectAll();
					if (sizeof($allPrivateRecords) > 0) {
						$resultUser = new virgoUser($allPrivateRecords[0]['usr_id']);
						$resultUser->putInContext(false);
					} else {
						$resultUser = new virgoUser();
					}
				} else {
					$customSQL = P('custom_sql_condition');
					if (isset($customSQL) && trim($customSQL) != '') {
						$currentUser = virgoUser::getUser();
						$currentPage = virgoPage::getCurrentPage();
						eval("\$customSQL = \"$customSQL\";");
						$records = $resultUser->selectAll($customSQL);
						if (sizeof($records) > 0) {
							$resultUser = new virgoUser($records[0]['usr_id']);
							$resultUser->putInContext(false);
						} else {
							$resultUser = new virgoUser();
						}
					} else {
						$resultUser = new virgoUser();
					}
				}
			}
		} elseif (P('form_only', "0") == "6") {
			$resultUser = new virgoUser(virgoUser::getUserId());
			$resultUser->putInContext(false);
		}
	}
?>
<?php
		if (isset($includeError) && $includeError == 1) {
			$resultUser = new virgoUser();
		}
?>
<?php
	$userDisplayMode = virgoUser::getDisplayMode();
//	if ($userDisplayMode == "" || $userDisplayMode == "TABLE") {
//		$resultUser = $resultUser->portletActionForm();
//	}
?>
		<div class="form">
<?php
		$parentContextInfos = $resultUser->getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
//			$whereClauseUser = $whereClauseUser . ' AND ' . $parentContextInfo['condition'];
			if (isset($parentContextInfo['value'])) {
?>		
			<table class="db_context_record">
				<tr>
					<td class="db_context_label">
						<?php echo $parentContextInfo['name'] ?>
					</td>
					<td class="db_context_value">
						<?php echo $parentContextInfo['value'] ?>
					</td>
				</tr>
			</table>
<?php
			}
		}
		if (P('filter_entity_pob_id', '') == '' && P('filter_mode', '0') == '0') {
?>		
<?php
		$criteriaUser = $resultUser->getCriteria();
		$countTmp = 0;
		if (isset($criteriaUser["username"])) {
			$fieldCriteriaUsername = $criteriaUser["username"];
			if ($fieldCriteriaUsername["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaUsername["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaUser["password"])) {
			$fieldCriteriaPassword = $criteriaUser["password"];
			if ($fieldCriteriaPassword["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaPassword["value"];
				$renderCriteria = "";
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaUser["email"])) {
			$fieldCriteriaEmail = $criteriaUser["email"];
			if ($fieldCriteriaEmail["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaEmail["value"];
				$renderCriteria = "";
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaUser["first_name"])) {
			$fieldCriteriaFirstName = $criteriaUser["first_name"];
			if ($fieldCriteriaFirstName["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaFirstName["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaUser["last_name"])) {
			$fieldCriteriaLastName = $criteriaUser["last_name"];
			if ($fieldCriteriaLastName["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaLastName["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaUser["session_id"])) {
			$fieldCriteriaSessionId = $criteriaUser["session_id"];
			if ($fieldCriteriaSessionId["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaSessionId["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaUser["ip"])) {
			$fieldCriteriaIp = $criteriaUser["ip"];
			if ($fieldCriteriaIp["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaIp["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaUser["logged_in"])) {
			$fieldCriteriaLoggedIn = $criteriaUser["logged_in"];
			if ($fieldCriteriaLoggedIn["is_null"] != 0) {
				$countTmp = $countTmp + 1;
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
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaUser["last_successful_login"])) {
			$fieldCriteriaLastSuccessfulLogin = $criteriaUser["last_successful_login"];
			if ($fieldCriteriaLastSuccessfulLogin["is_null"] != 0) {
				$countTmp = $countTmp + 1;
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
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaUser["last_failed_login"])) {
			$fieldCriteriaLastFailedLogin = $criteriaUser["last_failed_login"];
			if ($fieldCriteriaLastFailedLogin["is_null"] != 0) {
				$countTmp = $countTmp + 1;
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
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaUser["last_logout"])) {
			$fieldCriteriaLastLogout = $criteriaUser["last_logout"];
			if ($fieldCriteriaLastLogout["is_null"] != 0) {
				$countTmp = $countTmp + 1;
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
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaUser["user_agent"])) {
			$fieldCriteriaUserAgent = $criteriaUser["user_agent"];
			if ($fieldCriteriaUserAgent["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaUserAgent["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaUser["token"])) {
			$fieldCriteriaToken = $criteriaUser["token"];
			if ($fieldCriteriaToken["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaToken["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaUser["unidentified"])) {
			$fieldCriteriaUnidentified = $criteriaUser["unidentified"];
			if ($fieldCriteriaUnidentified["is_null"] != 0) {
				$countTmp = $countTmp + 1;
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
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaUser["confirmed"])) {
			$fieldCriteriaConfirmed = $criteriaUser["confirmed"];
			if ($fieldCriteriaConfirmed["is_null"] != 0) {
				$countTmp = $countTmp + 1;
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
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaUser["accepted"])) {
			$fieldCriteriaAccepted = $criteriaUser["accepted"];
			if ($fieldCriteriaAccepted["is_null"] != 0) {
				$countTmp = $countTmp + 1;
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
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaUser["page"])) {
			$parentCriteria = $criteriaUser["page"];
			if ($parentCriteria["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				if (isset($parentCriteria["value"]) && $parentCriteria["value"] != "") {
					$parentValue = $parentCriteria["value"];
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaUser["role"])) {
			$countTmp = $countTmp + 1;
		}
		if (is_null($criteriaUser) || sizeof($criteriaUser) == 0 || $countTmp == 0) {
		} else {
?>
			<input type="hidden" name="virgo_filter_column"/>
			<table class="db_criteria_record">
				<tr>
					<td colspan="3" class="db_criteria_message"><?php echo T('SEARCH_CRITERIA') ?></td>
				</tr>
<?php
			if (isset($criteriaUser["username"])) {
				$fieldCriteriaUsername = $criteriaUser["username"];
				if ($fieldCriteriaUsername["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Username') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaUsername["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaUsername["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='username';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaUsername["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Username') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='username';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaUser["password"])) {
				$fieldCriteriaPassword = $criteriaUser["password"];
				if ($fieldCriteriaPassword["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Password') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaPassword["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaPassword["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='password';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaPassword["value"];
					$renderCriteria = "";
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Password') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='password';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaUser["email"])) {
				$fieldCriteriaEmail = $criteriaUser["email"];
				if ($fieldCriteriaEmail["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Email') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaEmail["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaEmail["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='email';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaEmail["value"];
					$renderCriteria = "";
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Email') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='email';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaUser["first_name"])) {
				$fieldCriteriaFirstName = $criteriaUser["first_name"];
				if ($fieldCriteriaFirstName["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('First name') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaFirstName["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaFirstName["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='first_name';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaFirstName["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('First name') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='first_name';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaUser["last_name"])) {
				$fieldCriteriaLastName = $criteriaUser["last_name"];
				if ($fieldCriteriaLastName["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Last name') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaLastName["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaLastName["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='last_name';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaLastName["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Last name') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='last_name';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaUser["session_id"])) {
				$fieldCriteriaSessionId = $criteriaUser["session_id"];
				if ($fieldCriteriaSessionId["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Session id') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaSessionId["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaSessionId["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='session_id';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaSessionId["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Session id') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='session_id';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaUser["ip"])) {
				$fieldCriteriaIp = $criteriaUser["ip"];
				if ($fieldCriteriaIp["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Ip') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaIp["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaIp["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='ip';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaIp["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Ip') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='ip';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaUser["logged_in"])) {
				$fieldCriteriaLoggedIn = $criteriaUser["logged_in"];
				if ($fieldCriteriaLoggedIn["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Logged in') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaLoggedIn["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaLoggedIn["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='logged_in';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
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
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Logged in') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='logged_in';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaUser["last_successful_login"])) {
				$fieldCriteriaLastSuccessfulLogin = $criteriaUser["last_successful_login"];
				if ($fieldCriteriaLastSuccessfulLogin["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Last successful login') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaLastSuccessfulLogin["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaLastSuccessfulLogin["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='last_successful_login';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
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
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Last successful login') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='last_successful_login';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaUser["last_failed_login"])) {
				$fieldCriteriaLastFailedLogin = $criteriaUser["last_failed_login"];
				if ($fieldCriteriaLastFailedLogin["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Last failed login') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaLastFailedLogin["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaLastFailedLogin["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='last_failed_login';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
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
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Last failed login') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='last_failed_login';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaUser["last_logout"])) {
				$fieldCriteriaLastLogout = $criteriaUser["last_logout"];
				if ($fieldCriteriaLastLogout["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Last logout') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaLastLogout["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaLastLogout["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='last_logout';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
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
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Last logout') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='last_logout';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaUser["user_agent"])) {
				$fieldCriteriaUserAgent = $criteriaUser["user_agent"];
				if ($fieldCriteriaUserAgent["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('User agent') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaUserAgent["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaUserAgent["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='user_agent';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaUserAgent["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('User agent') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='user_agent';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaUser["token"])) {
				$fieldCriteriaToken = $criteriaUser["token"];
				if ($fieldCriteriaToken["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Token') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaToken["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaToken["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='token';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaToken["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Token') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='token';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaUser["unidentified"])) {
				$fieldCriteriaUnidentified = $criteriaUser["unidentified"];
				if ($fieldCriteriaUnidentified["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Unidentified') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaUnidentified["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaUnidentified["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='unidentified';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
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
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Unidentified') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='unidentified';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaUser["confirmed"])) {
				$fieldCriteriaConfirmed = $criteriaUser["confirmed"];
				if ($fieldCriteriaConfirmed["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Confirmed') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaConfirmed["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaConfirmed["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='confirmed';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
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
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Confirmed') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='confirmed';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaUser["accepted"])) {
				$fieldCriteriaAccepted = $criteriaUser["accepted"];
				if ($fieldCriteriaAccepted["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Accepted') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaAccepted["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaAccepted["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='accepted';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
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
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Accepted') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='accepted';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaUser["page"])) {
				$parentCriteria = $criteriaUser["page"];
				if ($parentCriteria["is_null"] == 1) {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Page') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo T('EMPTY_VALUE') ?>				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='page';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
			} else {
					$renderCriteria = $parentCriteria["value"];
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('page') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='page';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
		if (isset($criteriaUser["role"])) {
			$parentIds = $criteriaUser["role"];
		}
		if (isset($parentIds) && isset($parentIds['ids'])) {
			$selectedIds = $parentIds['ids'];
			$renderCriteria = "";
			foreach ($selectedIds as $id) {
				$obj = new portal\virgoRole($id['id']);
				$renderCriteria = ($renderCriteria == "" ? "" : $renderCriteria . ", ") . $obj->getVirgoTitle();
			}
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Roles') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='role';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
		}
?>
			</table>
<?php
		}
?>
<?php
		}
?>
<?php
PROFILE('token');
	if (isset($resultUser)) {
		$tmpId = is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
?>
<?php
	if ($userDisplayMode != "TABLE") {
		$tmpAction = R('portlet_action');
		if (
			$tmpAction == "Store" 
			|| $tmpAction == "Apply"
			|| $tmpAction == "StoreAndClear"
			|| $tmpAction == "BackFromParent"
		) {
			$invokedPortletId = R('invoked_portlet_object_id');
			if (is_null($invokedPortletId) || trim($invokedPortletId) == "") {
				$invokedPortletId = R('legacy_invoked_portlet_object_id');
			}
			$pob = $resultUser->getMyPortletObject();
			$reloadFromRequest = $pob->getPortletSessionValue('reload_from_request', '0');
			if (isset($invokedPortletId) && $invokedPortletId == $_SESSION['current_portlet_object_id'] && isset($reloadFromRequest) && $reloadFromRequest == "1") { 
				$pob->setPortletSessionValue('reload_from_request', '0');
				$resultUser->loadFromRequest();
			} else {
				if (P('form_only', "0") == "1" && isset($contextId)) {
					if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
						require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'create_store_message.php');
						$userDisplayMode = "-empty-";
					}
				}
			}
		}
	}
if (!$resultUser->hideContentDueToNoParentSelected()) {
	$formsInTable = (P('forms_rendering', "false") == "true");
	if (!$formsInTable) {
		$floatingFields = (P('forms_rendering', "false") == "float" || P('forms_rendering', "false") == "float-grid");
		$floatingGridFields = (P('forms_rendering', "false") == "float-grid");
	}
/* MILESTONE 1.1 Form */
	$tabIndex = 1;
	$parentAjaxRendered = "0";
	if ($userDisplayMode == "FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_user") {
			  if (check.value == 'T') {
				  return "<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>";
			  }
		  }
        }
  }
</script>
	<div class="form_edit">
			<fieldset class="form">
				<legend>
<?php echo T('USER') ?>:</legend>
<?php
	if (!$formsInTable) {
?>
				<ul <?php echo $floatingGridFields ? "class='float_grid_fields'" : "" ?>>
<?php
	} else {
?>
				<table>
<?php
	}
?>
<?php
	$editForm = P('edit_form', "virgo_default");
	if (is_null($editForm) || trim($editForm) == "" || $editForm == "virgo_default") {
?>
																																																						<?php
	if (P('show_form_username', "1") == "1" || P('show_form_username', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  obligatory   username varchar" 
						for="usr_username_<?php echo $resultUser->getId() ?>"
					>* <?php echo T('USERNAME') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_username', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getUsername(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="username" name="usr_username_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getUsername(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="usr_username_<?php echo $resultUser->getId() ?>" 
							name="usr_username_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getUsername(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_USERNAME');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_username_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_password', "1") == "1" || P('show_form_password', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_password_obligatory', "0") == "1" ? " obligatory " : "" ?>   password password" 
						for="usr_password_<?php echo $resultUser->getId() ?>"
					> <?php echo P('show_form_password_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('PASSWORD') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_password', "1") == "2") {
?>
<?php
	if (!is_null($resultUser->getPassword())) {
?>
		<?php echo T('PRESENT') ?>
<?php
	}
?>
<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input type="password"
							class="inputbox " 
							id="usr_password_<?php echo $resultUser->getId() ?>" 
							name="usr_password_<?php echo $resultUser->getId() ?>"
							size="15" 
							maxlength="14"
							value="<?php echo $resultUser->getPassword() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_PASSWORD');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						/>
<label align="right" for="usr_password2_<?php echo $resultUser->getId() ?>" nowrap class="fieldlabel " style="float: none;">						
<?php echo T('REPEAT') . ' ' . T('PASSWORD') ?>
</label>						
						<input type="password"
							class="inputbox " 
							id="usr_password2_<?php echo $resultUser->getId() ?>" 
							name="usr_password2_<?php echo $resultUser->getId() ?>"
							size="15" 
							maxlength="14"
							value="<?php echo $resultUser->getPassword() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
						/>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_password_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_email', "1") == "1" || P('show_form_email', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_email_obligatory', "0") == "1" ? " obligatory " : "" ?>   email email" 
						for="usr_email_<?php echo $resultUser->getId() ?>"
					> <?php echo P('show_form_email_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('EMAIL') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_email', "1") == "2") {
?>
<?php
	$email = htmlentities($resultUser->getEmail(), ENT_QUOTES, "UTF-8");
?>
<a class="inputbox readonly" href="mailto:<?php echo $email ?>" target="_blank">
	<?php echo $email ?>
</a>

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_email_obligatory', "0") == "1" ? " obligatory " : "" ?>   short   medium " 
							type="text"
							id="usr_email_<?php echo $resultUser->getId() ?>" 
							name="usr_email_<?php echo $resultUser->getId() ?>"
							size="50" 
							value="<?php echo htmlentities($resultUser->getEmail(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_EMAIL');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_email_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_first_name', "1") == "1" || P('show_form_first_name', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_first_name_obligatory', "0") == "1" ? " obligatory " : "" ?>   first_name varchar" 
						for="usr_firstName_<?php echo $resultUser->getId() ?>"
					> <?php echo P('show_form_first_name_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('FIRST_NAME') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_first_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getFirstName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="firstName" name="usr_firstName_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getFirstName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_first_name_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_firstName_<?php echo $resultUser->getId() ?>" 
							name="usr_firstName_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getFirstName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_FIRST_NAME');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_firstName_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_last_name', "1") == "1" || P('show_form_last_name', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_last_name_obligatory', "0") == "1" ? " obligatory " : "" ?>   last_name varchar" 
						for="usr_lastName_<?php echo $resultUser->getId() ?>"
					> <?php echo P('show_form_last_name_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LAST_NAME') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_last_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getLastName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastName" name="usr_lastName_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getLastName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_last_name_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_lastName_<?php echo $resultUser->getId() ?>" 
							name="usr_lastName_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getLastName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_LAST_NAME');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_lastName_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_session_id', "1") == "1" || P('show_form_session_id', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_session_id_obligatory', "0") == "1" ? " obligatory " : "" ?>   session_id varchar" 
						for="usr_sessionId_<?php echo $resultUser->getId() ?>"
					> <?php echo P('show_form_session_id_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('SESSION_ID') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_session_id', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getSessionId(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="sessionId" name="usr_sessionId_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getSessionId(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_session_id_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_sessionId_<?php echo $resultUser->getId() ?>" 
							name="usr_sessionId_<?php echo $resultUser->getId() ?>"
							maxlength="32"
							size="32" 
							value="<?php echo htmlentities($resultUser->getSessionId(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_SESSION_ID');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_sessionId_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_ip', "1") == "1" || P('show_form_ip', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_ip_obligatory', "0") == "1" ? " obligatory " : "" ?>   ip varchar" 
						for="usr_ip_<?php echo $resultUser->getId() ?>"
					> <?php echo P('show_form_ip_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('IP') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_ip', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getIp(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="ip" name="usr_ip_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getIp(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_ip_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_ip_<?php echo $resultUser->getId() ?>" 
							name="usr_ip_<?php echo $resultUser->getId() ?>"
							maxlength="15"
							size="15" 
							value="<?php echo htmlentities($resultUser->getIp(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_IP');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_ip_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_logged_in', "1") == "1" || P('show_form_logged_in', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_logged_in_obligatory', "0") == "1" ? " obligatory " : "" ?>   logged_in bool" 
						for="usr_loggedIn_<?php echo $resultUser->getId() ?>"
					> <?php echo P('show_form_logged_in_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LOGGED_IN') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_logged_in', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="loggedIn"
>
<?php
	if (is_null($resultUser->getLoggedIn()) || $resultUser->getLoggedIn() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultUser->getLoggedIn() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultUser->getLoggedIn() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<select class="inputbox" id="usr_loggedIn_<?php echo $resultUser->getId() ?>" name="usr_loggedIn_<?php echo $resultUser->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_LOGGED_IN');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultUser->getLoggedIn() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultUser->getLoggedIn() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultUser->getLoggedIn()) || $resultUser->getLoggedIn() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_loggedIn_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_last_successful_login', "1") == "1" || P('show_form_last_successful_login', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_last_successful_login_obligatory', "0") == "1" ? " obligatory " : "" ?>   last_successful_login datetime" 
						for="usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>"
					> <?php echo P('show_form_last_successful_login_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LAST_SUCCESSFUL_LOGIN') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_last_successful_login', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getLastSuccessfulLogin(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastSuccessfulLogin" name="usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getLastSuccessfulLogin(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<?php
	$locale = setlocale(LC_ALL,"0");
	if (isset($locale) && trim($locale) != "") {
		$lang = substr($locale, 0, 2);
	} else {
		$lang = "en";
	}
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
	if (!defined('JS_INCLUDED_TIMEPICKER')) {
		define('JS_INCLUDED_TIMEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQuery.timepicker/jquery-ui-timepicker-addon.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = $resultUser->getLastSuccessfulLogin();
?>
						<input class="inputbox" id="usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>" name="usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>'] = function () {
  $("#usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_last_failed_login', "1") == "1" || P('show_form_last_failed_login', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_last_failed_login_obligatory', "0") == "1" ? " obligatory " : "" ?>   last_failed_login datetime" 
						for="usr_lastFailedLogin_<?php echo $resultUser->getId() ?>"
					> <?php echo P('show_form_last_failed_login_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LAST_FAILED_LOGIN') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_last_failed_login', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getLastFailedLogin(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastFailedLogin" name="usr_lastFailedLogin_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getLastFailedLogin(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<?php
	$locale = setlocale(LC_ALL,"0");
	if (isset($locale) && trim($locale) != "") {
		$lang = substr($locale, 0, 2);
	} else {
		$lang = "en";
	}
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
	if (!defined('JS_INCLUDED_TIMEPICKER')) {
		define('JS_INCLUDED_TIMEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQuery.timepicker/jquery-ui-timepicker-addon.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = $resultUser->getLastFailedLogin();
?>
						<input class="inputbox" id="usr_lastFailedLogin_<?php echo $resultUser->getId() ?>" name="usr_lastFailedLogin_<?php echo $resultUser->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastFailedLogin_<?php echo $resultUser->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastFailedLogin_<?php echo $resultUser->getId() ?>'] = function () {
  $("#usr_lastFailedLogin_<?php echo $resultUser->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_last_logout', "1") == "1" || P('show_form_last_logout', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_last_logout_obligatory', "0") == "1" ? " obligatory " : "" ?>   last_logout datetime" 
						for="usr_lastLogout_<?php echo $resultUser->getId() ?>"
					> <?php echo P('show_form_last_logout_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LAST_LOGOUT') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_last_logout', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getLastLogout(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastLogout" name="usr_lastLogout_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getLastLogout(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<?php
	$locale = setlocale(LC_ALL,"0");
	if (isset($locale) && trim($locale) != "") {
		$lang = substr($locale, 0, 2);
	} else {
		$lang = "en";
	}
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
	if (!defined('JS_INCLUDED_TIMEPICKER')) {
		define('JS_INCLUDED_TIMEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQuery.timepicker/jquery-ui-timepicker-addon.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = $resultUser->getLastLogout();
?>
						<input class="inputbox" id="usr_lastLogout_<?php echo $resultUser->getId() ?>" name="usr_lastLogout_<?php echo $resultUser->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastLogout_<?php echo $resultUser->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastLogout_<?php echo $resultUser->getId() ?>'] = function () {
  $("#usr_lastLogout_<?php echo $resultUser->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_user_agent', "1") == "1" || P('show_form_user_agent', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_user_agent_obligatory', "0") == "1" ? " obligatory " : "" ?>   user_agent varchar" 
						for="usr_userAgent_<?php echo $resultUser->getId() ?>"
					> <?php echo P('show_form_user_agent_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('USER_AGENT') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_user_agent', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getUserAgent(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="userAgent" name="usr_userAgent_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getUserAgent(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_user_agent_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_userAgent_<?php echo $resultUser->getId() ?>" 
							name="usr_userAgent_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getUserAgent(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_USER_AGENT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_userAgent_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_token', "1") == "1" || P('show_form_token', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_token_obligatory', "0") == "1" ? " obligatory " : "" ?>   token varchar" 
						for="usr_token_<?php echo $resultUser->getId() ?>"
					> <?php echo P('show_form_token_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('TOKEN') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_token', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getToken(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="token" name="usr_token_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getToken(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_token_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_token_<?php echo $resultUser->getId() ?>" 
							name="usr_token_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getToken(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_TOKEN');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_token_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_unidentified', "1") == "1" || P('show_form_unidentified', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_unidentified_obligatory', "0") == "1" ? " obligatory " : "" ?>   unidentified bool" 
						for="usr_unidentified_<?php echo $resultUser->getId() ?>"
					> <?php echo P('show_form_unidentified_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('UNIDENTIFIED') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_unidentified', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="unidentified"
>
<?php
	if (is_null($resultUser->getUnidentified()) || $resultUser->getUnidentified() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultUser->getUnidentified() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultUser->getUnidentified() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<select class="inputbox" id="usr_unidentified_<?php echo $resultUser->getId() ?>" name="usr_unidentified_<?php echo $resultUser->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_UNIDENTIFIED');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultUser->getUnidentified() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultUser->getUnidentified() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultUser->getUnidentified()) || $resultUser->getUnidentified() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_unidentified_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_confirmed', "1") == "1" || P('show_form_confirmed', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_confirmed_obligatory', "0") == "1" ? " obligatory " : "" ?>   confirmed bool" 
						for="usr_confirmed_<?php echo $resultUser->getId() ?>"
					> <?php echo P('show_form_confirmed_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CONFIRMED') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_confirmed', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="confirmed"
>
<?php
	if (is_null($resultUser->getConfirmed()) || $resultUser->getConfirmed() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultUser->getConfirmed() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultUser->getConfirmed() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<select class="inputbox" id="usr_confirmed_<?php echo $resultUser->getId() ?>" name="usr_confirmed_<?php echo $resultUser->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_CONFIRMED');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultUser->getConfirmed() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultUser->getConfirmed() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultUser->getConfirmed()) || $resultUser->getConfirmed() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_confirmed_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_accepted', "1") == "1" || P('show_form_accepted', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_accepted_obligatory', "0") == "1" ? " obligatory " : "" ?>   accepted bool" 
						for="usr_accepted_<?php echo $resultUser->getId() ?>"
					> <?php echo P('show_form_accepted_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('ACCEPTED') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_accepted', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="accepted"
>
<?php
	if (is_null($resultUser->getAccepted()) || $resultUser->getAccepted() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultUser->getAccepted() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultUser->getAccepted() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<select class="inputbox" id="usr_accepted_<?php echo $resultUser->getId() ?>" name="usr_accepted_<?php echo $resultUser->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_ACCEPTED');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultUser->getAccepted() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultUser->getAccepted() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultUser->getAccepted()) || $resultUser->getAccepted() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_accepted_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (class_exists('portal\virgoPage') && ((P('show_form_page', "1") == "1" || P('show_form_page', "1") == "2" || P('show_form_page', "1") == "3") && !isset($context["pge"]))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_form_page_obligatory') == "1" ? " obligatory " : "" ?> " for="usr_page_<?php echo isset($resultUser->usr_id) ? $resultUser->usr_id : '' ?>">
<?php echo P('show_form_page_obligatory') == "1" ? " * " : "" ?>
<?php echo T('PAGE') ?> <?php echo T('') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
<?php
//		$limit_page = $componentParams->get('limit_to_page');
		$limit_page = null;
		$tmpId = portal\virgoUser::getParentInContext("portal\\virgoPage");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_page', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultUser->usr_pge__id = $tmpId;
//			}
			if (!is_null($resultUser->getPgeId())) {
				$parentId = $resultUser->getPgeId();
				$parentValue = portal\virgoPage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="usr_page_<?php echo $resultUser->getId() ?>" name="usr_page_<?php echo $resultUser->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_USER_PAGE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_page) && trim($limit_page) != "") {
		$whereList = $whereList . " pge_id ";
		if (trim($limit_page) == "page_title") {
			$limit_page = "SELECT pge_id FROM prt_pages WHERE pge_" . $limit_page . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_page = \"$limit_page\";");
		$whereList = $whereList . " IN (" . $limit_page . ") ";
	}						
	$parentCount = portal\virgoPage::getVirgoListSize($whereList);
	$showAjaxusr = P('show_form_page', "1") == "3" || $parentCount > 100;
	if (!$showAjaxusr) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_page_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="usr_page_<?php echo !is_null($resultUser->getId()) ? $resultUser->getId() : '' ?>" 
							name="usr_page_<?php echo !is_null($resultUser->getId()) ? $resultUser->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_page) || trim($limit_page) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPage = portal\virgoPage::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPage)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultUser->getPgeId()) && $id == $resultUser->getPgeId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultUser->getPgeId();
				$parentPage = new portal\virgoPage();
				$parentValue = $parentPage->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="usr_page_<?php echo $resultUser->getId() ?>" name="usr_page_<?php echo $resultUser->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="usr_page_dropdown_<?php echo $resultUser->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#usr_page_dropdown_<?php echo $resultUser->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Page",
			virgo_field_name: "page",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#usr_page_<?php echo $resultUser->getId() ?>').val(ui.item.value);
				  	$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').val(ui.item.label);
				  	$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#usr_page_<?php echo $resultUser->getId() ?>').val('');
				$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
?>
<?php
	if (isset($context["pge"])) {
		$parentValue = $context["pge"];
	} else {
		$parentValue = $resultUser->usr_pge_id;
	}
	
?>
				<input type="hidden" id="usr_page_<?php echo $resultUser->usr_id ?>" name="usr_page_<?php echo $resultUser->usr_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>

<?php
	if (class_exists('portal\virgoUserRole') && P('show_form_user_roles', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel userRole" for="usr_userRole_<?php echo $resultUser->getId() ?>[]">
User roles 
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
			$parentRole = new portal\virgoRole();
			$whereList = "";
			$resultsRole = $parentRole->getVirgoList($whereList);
			$currentConnections = $resultUser->getUserRoles();
			$currentIds = array();
			foreach ($currentConnections as $currentConnection) {
				$currentIds[] = $currentConnection->getRoleId();
			}
?>
<?php
	$inputMethod = P('n_m_children_input_user_role_', "select");
	if (is_null($inputMethod) || trim($inputMethod) == "") {
		$inputMethod = "select";
	}
	if ($inputMethod == "select") {
?>
						<select 
							class="inputbox" 
							id="usr_userRole_<?php echo $resultUser->usr_id ?>[]" 
							name="usr_userRole_<?php echo $resultUser->usr_id ?>[]" 
							multiple 
							size=<?php echo sizeof($resultsRole) > 10 ? 10 : sizeof($resultsRole) ?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
						>
<?php
			while (list($id, $label) = each($resultsRole)) {
?>
							<option 
								value="<?php echo $id ?>"
								<?php echo in_array($id, $currentIds) ? "selected" : "" ?> 
							><?php echo $label ?></option>
<?php
			}
?>
						</select>
<?php
	} elseif ($inputMethod == "checkbox") {
?>
						<ul>
<?php
			reset($resultsRole);
			while (list($id, $label) = each($resultsRole)) {
?>
							<li class="parent_selection">
								<input 
									type="checkbox"
									class="inputbox checkbox"
									id="usr_userRole_<?php echo $resultUser->usr_id ?>[]" 
									name="usr_userRole_<?php echo $resultUser->usr_id ?>[]" 
									value="<?php echo $id ?>"
									<?php echo in_array($id, $currentIds) ? "checked" : "" ?>
								>
								<span class="multilabel"><?php echo $label ?></span>
							</li>
<?php
			}
?>
						</ul>
<?php
	} 
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
?>
					<input 
						type="hidden" 
						id="usr_userRole_<?php echo $resultUser->usr_id ?>" 
						name="usr_userRole_<?php echo $resultUser->usr_id ?>" 
						value="VIRGO_DONT_DELETE_N_M_CHILDREN"
					/>


<?php					
	}
?>
<?php
	if (class_exists('portal\virgoSystemMessage') && P('show_form_system_messages', '1') == "1") {
?>
<?php
	} else {
	}
?>

<?php
	} elseif ($editForm == "virgo_entity") {
?>
<?php
	}
?>
<?php
	if (!$formsInTable) {
?>
				</ul>
<?php
	} else {
?>
				</table>
<?php
	}
?>
<?php 
	if (false) { //$componentParams->get('show_form_system_messages') == "1") {
?>
		<script type="text/javascript">
			function checkAll(value) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (chcks[i].name.match("^DELETE_\d*")) {
						chcks[i].checked = value;
					}
				}
			}
		</script>

<?php
//	$componentParamsSystemMessage = &JComponentHelper::getParams('com_prt_system_message');
?>
		<table class="data_table" cellpadding="0" cellspacing="0">
			<tr class="data_table_header">
				<td>
					
				</td>
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_timestamp') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Timestamp
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_message') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Message
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_details') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Details
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_ip') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Ip
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_deleted_user_name') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Deleted user name
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_url') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Url
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_stack_trace') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Stack trace
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_log_level') == "1" && ($masterComponentName != "log_level" || is_null($contextId))) {
?>
				<td align="center" nowrap>Log level </td>
<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_execution') == "1" && ($masterComponentName != "execution" || is_null($contextId))) {
?>
				<td align="center" nowrap>Execution </td>
<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$tmpSystemMessage = new portal\virgoSystemMessage();
				$resultsSystemMessage = $tmpSystemMessage->selectAll(' sms_usr_id = ' . $resultUser->usr_id);
				$idsToCorrect = $tmpSystemMessage->getInvalidRecords();
				$index = 0;
				foreach ($resultsSystemMessage as $resultSystemMessage) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultSystemMessage->sms_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultSystemMessage->sms_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultSystemMessage->sms_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultSystemMessage->sms_id) ? 0 : $resultSystemMessage->sms_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultSystemMessage->sms_id;
		$resultSystemMessage = new virgoSystemMessage;
		$resultSystemMessage->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_timestamp') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 0;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
<?php
	$locale = setlocale(LC_ALL,"0");
	if (isset($locale) && trim($locale) != "") {
		$lang = substr($locale, 0, 2);
	} else {
		$lang = "en";
	}
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
	if (!defined('JS_INCLUDED_TIMEPICKER')) {
		define('JS_INCLUDED_TIMEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQuery.timepicker/jquery-ui-timepicker-addon.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = $resultSystemMessage->getTimestamp();
?>
						<input class="inputbox" id="sms_timestamp_<?php echo $resultSystemMessage->getId() ?>" name="sms_timestamp_<?php echo $resultSystemMessage->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['sms_timestamp_<?php echo $resultSystemMessage->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['sms_timestamp_<?php echo $resultSystemMessage->getId() ?>'] = function () {
  $("#sms_timestamp_<?php echo $resultSystemMessage->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="timestamp_<?php echo $resultUser->usr_id ?>" 
							name="timestamp_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_timestamp, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_message') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 1;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="sms_message_<?php echo $resultSystemMessage->getId() ?>" 
							name="sms_message_<?php echo $resultSystemMessage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultSystemMessage->getMessage(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_MESSAGE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#sms_message_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="message_<?php echo $resultUser->usr_id ?>" 
							name="message_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_message, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_details') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 2;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
<textarea 
	class="inputbox details" 
	id="sms_details_<?php echo $resultSystemMessage->getId() ?>" 
	name="sms_details_<?php echo $resultSystemMessage->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_DETAILS');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultSystemMessage->getDetails(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#sms_details_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="details_<?php echo $resultUser->usr_id ?>" 
							name="details_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_details, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_ip') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 3;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_ip_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="sms_ip_<?php echo $resultSystemMessage->getId() ?>" 
							name="sms_ip_<?php echo $resultSystemMessage->getId() ?>"
							maxlength="15"
							size="15" 
							value="<?php echo htmlentities($resultSystemMessage->getIp(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_IP');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#sms_ip_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="ip_<?php echo $resultUser->usr_id ?>" 
							name="ip_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_ip, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_deleted_user_name') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 4;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_deleted_user_name_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>" 
							name="sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultSystemMessage->getDeletedUserName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_DELETED_USER_NAME');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="deletedUserName_<?php echo $resultUser->usr_id ?>" 
							name="deletedUserName_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_deleted_user_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_url') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 5;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_url_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="sms_url_<?php echo $resultSystemMessage->getId() ?>" 
							name="sms_url_<?php echo $resultSystemMessage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultSystemMessage->getUrl(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_URL');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#sms_url_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="url_<?php echo $resultUser->usr_id ?>" 
							name="url_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_url, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_stack_trace') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 6;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
<textarea 
	class="inputbox stack_trace" 
	id="sms_stackTrace_<?php echo $resultSystemMessage->getId() ?>" 
	name="sms_stackTrace_<?php echo $resultSystemMessage->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_STACK_TRACE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultSystemMessage->getStackTrace(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#sms_stackTrace_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="stackTrace_<?php echo $resultUser->usr_id ?>" 
							name="stackTrace_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_stack_trace, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_log_level') == "1" && ($masterComponentName != "log_level" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsSystemMessage) * 7;
?>
<?php
//		$limit_log_level = $componentParams->get('limit_to_log_level');
		$limit_log_level = null;
		$tmpId = portal\virgoUser::getParentInContext("portal\\virgoLogLevel");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_log_level', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultSystemMessage->sms_llv__id = $tmpId;
//			}
			if (!is_null($resultSystemMessage->getLlvId())) {
				$parentId = $resultSystemMessage->getLlvId();
				$parentValue = portal\virgoLogLevel::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="sms_logLevel_<?php echo $resultSystemMessage->getId() ?>" name="sms_logLevel_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_SYSTEM_MESSAGE_LOG_LEVEL');
?>
<?php
	$whereList = "";
	if (!is_null($limit_log_level) && trim($limit_log_level) != "") {
		$whereList = $whereList . " llv_id ";
		if (trim($limit_log_level) == "page_title") {
			$limit_log_level = "SELECT llv_id FROM prt_log_levels WHERE llv_" . $limit_log_level . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_log_level = \"$limit_log_level\";");
		$whereList = $whereList . " IN (" . $limit_log_level . ") ";
	}						
	$parentCount = portal\virgoLogLevel::getVirgoListSize($whereList);
	$showAjaxsms = P('show_form_log_level', "1") == "3" || $parentCount > 100;
	if (!$showAjaxsms) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="sms_logLevel_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
							name="sms_logLevel_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_log_level) || trim($limit_log_level) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsLogLevel = portal\virgoLogLevel::getVirgoList($whereList);
			while(list($id, $label)=each($resultsLogLevel)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultSystemMessage->getLlvId()) && $id == $resultSystemMessage->getLlvId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultSystemMessage->getLlvId();
				$parentLogLevel = new portal\virgoLogLevel();
				$parentValue = $parentLogLevel->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="sms_log_level_<?php echo $resultSystemMessage->getId() ?>" name="sms_logLevel_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "LogLevel",
			virgo_field_name: "log_level",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#sms_log_level_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.value);
				  	$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				  	$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#sms_log_level_<?php echo $resultSystemMessage->getId() ?>').val('');
				$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_log_level_dropdown_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_execution') == "1" && ($masterComponentName != "execution" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsSystemMessage) * 8;
?>
<?php
//		$limit_execution = $componentParams->get('limit_to_execution');
		$limit_execution = null;
		$tmpId = portal\virgoUser::getParentInContext("portal\\virgoExecution");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_execution', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultSystemMessage->sms_exc__id = $tmpId;
//			}
			if (!is_null($resultSystemMessage->getExcId())) {
				$parentId = $resultSystemMessage->getExcId();
				$parentValue = portal\virgoExecution::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="sms_execution_<?php echo $resultSystemMessage->getId() ?>" name="sms_execution_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_SYSTEM_MESSAGE_EXECUTION');
?>
<?php
	$whereList = "";
	if (!is_null($limit_execution) && trim($limit_execution) != "") {
		$whereList = $whereList . " exc_id ";
		if (trim($limit_execution) == "page_title") {
			$limit_execution = "SELECT exc_id FROM prt_executions WHERE exc_" . $limit_execution . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_execution = \"$limit_execution\";");
		$whereList = $whereList . " IN (" . $limit_execution . ") ";
	}						
	$parentCount = portal\virgoExecution::getVirgoListSize($whereList);
	$showAjaxsms = P('show_form_execution', "1") == "3" || $parentCount > 100;
	if (!$showAjaxsms) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_execution_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="sms_execution_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
							name="sms_execution_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_execution) || trim($limit_execution) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsExecution = portal\virgoExecution::getVirgoList($whereList);
			while(list($id, $label)=each($resultsExecution)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultSystemMessage->getExcId()) && $id == $resultSystemMessage->getExcId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultSystemMessage->getExcId();
				$parentExecution = new portal\virgoExecution();
				$parentValue = $parentExecution->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="sms_execution_<?php echo $resultSystemMessage->getId() ?>" name="sms_execution_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Execution",
			virgo_field_name: "execution",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#sms_execution_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.value);
				  	$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				  	$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#sms_execution_<?php echo $resultSystemMessage->getId() ?>').val('');
				$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_execution_dropdown_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
				<td>
<?php
	if (!is_null($errorMessage)) {
?>
					<div class="error">
						<?php echo $errorMessage ?>
					</div>
<?php
	}
?>
				</td>
				<td nowrap class="actions" align="right">
				</td>
			</tr>

<?php
				}
				$resultSystemMessage = array();
?>		
			<tr id="virgo_tr_id_<?php echo $resultSystemMessage->sms_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultSystemMessage->sms_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultSystemMessage->sms_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultSystemMessage->sms_id) ? 0 : $resultSystemMessage->sms_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultSystemMessage->sms_id;
		$resultSystemMessage = new virgoSystemMessage;
		$resultSystemMessage->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_timestamp') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 0;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
<?php
	$locale = setlocale(LC_ALL,"0");
	if (isset($locale) && trim($locale) != "") {
		$lang = substr($locale, 0, 2);
	} else {
		$lang = "en";
	}
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
	if (!defined('JS_INCLUDED_TIMEPICKER')) {
		define('JS_INCLUDED_TIMEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQuery.timepicker/jquery-ui-timepicker-addon.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = $resultSystemMessage->getTimestamp();
?>
						<input class="inputbox" id="sms_timestamp_<?php echo $resultSystemMessage->getId() ?>" name="sms_timestamp_<?php echo $resultSystemMessage->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['sms_timestamp_<?php echo $resultSystemMessage->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['sms_timestamp_<?php echo $resultSystemMessage->getId() ?>'] = function () {
  $("#sms_timestamp_<?php echo $resultSystemMessage->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="timestamp_<?php echo $resultUser->usr_id ?>" 
							name="timestamp_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_timestamp, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_message') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 1;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="sms_message_<?php echo $resultSystemMessage->getId() ?>" 
							name="sms_message_<?php echo $resultSystemMessage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultSystemMessage->getMessage(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_MESSAGE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#sms_message_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="message_<?php echo $resultUser->usr_id ?>" 
							name="message_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_message, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_details') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 2;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
<textarea 
	class="inputbox details" 
	id="sms_details_<?php echo $resultSystemMessage->getId() ?>" 
	name="sms_details_<?php echo $resultSystemMessage->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_DETAILS');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultSystemMessage->getDetails(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#sms_details_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="details_<?php echo $resultUser->usr_id ?>" 
							name="details_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_details, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_ip') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 3;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_ip_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="sms_ip_<?php echo $resultSystemMessage->getId() ?>" 
							name="sms_ip_<?php echo $resultSystemMessage->getId() ?>"
							maxlength="15"
							size="15" 
							value="<?php echo htmlentities($resultSystemMessage->getIp(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_IP');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#sms_ip_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="ip_<?php echo $resultUser->usr_id ?>" 
							name="ip_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_ip, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_deleted_user_name') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 4;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_deleted_user_name_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>" 
							name="sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultSystemMessage->getDeletedUserName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_DELETED_USER_NAME');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="deletedUserName_<?php echo $resultUser->usr_id ?>" 
							name="deletedUserName_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_deleted_user_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_url') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 5;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_url_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="sms_url_<?php echo $resultSystemMessage->getId() ?>" 
							name="sms_url_<?php echo $resultSystemMessage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultSystemMessage->getUrl(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_URL');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#sms_url_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="url_<?php echo $resultUser->usr_id ?>" 
							name="url_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_url, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_stack_trace') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 6;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
<textarea 
	class="inputbox stack_trace" 
	id="sms_stackTrace_<?php echo $resultSystemMessage->getId() ?>" 
	name="sms_stackTrace_<?php echo $resultSystemMessage->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_STACK_TRACE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultSystemMessage->getStackTrace(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#sms_stackTrace_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="stackTrace_<?php echo $resultUser->usr_id ?>" 
							name="stackTrace_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_stack_trace, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_log_level') == "1" && ($masterComponentName != "log_level" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsSystemMessage) * 7;
?>
<?php
//		$limit_log_level = $componentParams->get('limit_to_log_level');
		$limit_log_level = null;
		$tmpId = portal\virgoUser::getParentInContext("portal\\virgoLogLevel");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_log_level', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultSystemMessage->sms_llv__id = $tmpId;
//			}
			if (!is_null($resultSystemMessage->getLlvId())) {
				$parentId = $resultSystemMessage->getLlvId();
				$parentValue = portal\virgoLogLevel::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="sms_logLevel_<?php echo $resultSystemMessage->getId() ?>" name="sms_logLevel_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_SYSTEM_MESSAGE_LOG_LEVEL');
?>
<?php
	$whereList = "";
	if (!is_null($limit_log_level) && trim($limit_log_level) != "") {
		$whereList = $whereList . " llv_id ";
		if (trim($limit_log_level) == "page_title") {
			$limit_log_level = "SELECT llv_id FROM prt_log_levels WHERE llv_" . $limit_log_level . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_log_level = \"$limit_log_level\";");
		$whereList = $whereList . " IN (" . $limit_log_level . ") ";
	}						
	$parentCount = portal\virgoLogLevel::getVirgoListSize($whereList);
	$showAjaxsms = P('show_form_log_level', "1") == "3" || $parentCount > 100;
	if (!$showAjaxsms) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="sms_logLevel_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
							name="sms_logLevel_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_log_level) || trim($limit_log_level) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsLogLevel = portal\virgoLogLevel::getVirgoList($whereList);
			while(list($id, $label)=each($resultsLogLevel)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultSystemMessage->getLlvId()) && $id == $resultSystemMessage->getLlvId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultSystemMessage->getLlvId();
				$parentLogLevel = new portal\virgoLogLevel();
				$parentValue = $parentLogLevel->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="sms_log_level_<?php echo $resultSystemMessage->getId() ?>" name="sms_logLevel_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "LogLevel",
			virgo_field_name: "log_level",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#sms_log_level_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.value);
				  	$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				  	$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#sms_log_level_<?php echo $resultSystemMessage->getId() ?>').val('');
				$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_log_level_dropdown_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_execution') == "1" && ($masterComponentName != "execution" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsSystemMessage) * 8;
?>
<?php
//		$limit_execution = $componentParams->get('limit_to_execution');
		$limit_execution = null;
		$tmpId = portal\virgoUser::getParentInContext("portal\\virgoExecution");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_execution', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultSystemMessage->sms_exc__id = $tmpId;
//			}
			if (!is_null($resultSystemMessage->getExcId())) {
				$parentId = $resultSystemMessage->getExcId();
				$parentValue = portal\virgoExecution::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="sms_execution_<?php echo $resultSystemMessage->getId() ?>" name="sms_execution_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_SYSTEM_MESSAGE_EXECUTION');
?>
<?php
	$whereList = "";
	if (!is_null($limit_execution) && trim($limit_execution) != "") {
		$whereList = $whereList . " exc_id ";
		if (trim($limit_execution) == "page_title") {
			$limit_execution = "SELECT exc_id FROM prt_executions WHERE exc_" . $limit_execution . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_execution = \"$limit_execution\";");
		$whereList = $whereList . " IN (" . $limit_execution . ") ";
	}						
	$parentCount = portal\virgoExecution::getVirgoListSize($whereList);
	$showAjaxsms = P('show_form_execution', "1") == "3" || $parentCount > 100;
	if (!$showAjaxsms) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_execution_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="sms_execution_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
							name="sms_execution_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_execution) || trim($limit_execution) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsExecution = portal\virgoExecution::getVirgoList($whereList);
			while(list($id, $label)=each($resultsExecution)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultSystemMessage->getExcId()) && $id == $resultSystemMessage->getExcId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultSystemMessage->getExcId();
				$parentExecution = new portal\virgoExecution();
				$parentValue = $parentExecution->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="sms_execution_<?php echo $resultSystemMessage->getId() ?>" name="sms_execution_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Execution",
			virgo_field_name: "execution",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#sms_execution_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.value);
				  	$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				  	$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#sms_execution_<?php echo $resultSystemMessage->getId() ?>').val('');
				$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_execution_dropdown_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
				<td>
<?php
	if (!is_null($errorMessage)) {
?>
					<div class="error">
						<?php echo $errorMessage ?>
					</div>
<?php
	}
?>
				</td>
				<td nowrap class="actions" align="right">
				</td>
			</tr>

			</table>
<?php
				$tmpSystemMessage->setInvalidRecords(null);
?>
<?php
	}
?>
			</fieldset>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultUser->getDateCreated()) {
		if ($resultUser->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultUser->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultUser->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultUser->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultUser->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultUser->getDateModified()) {
		if ($resultUser->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultUser->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultUser->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultUser->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultUser->getDateModified() ?>"	>
				</li>
<?php
	}
	if ($showFieldset == 1) {
?>
		</ul>
</fieldset>
<?php
	}
}
?>

				<div class="buttons form-actions">
						<input type="text" name="usr_id_<?php echo $this->getId() ?>" id="usr_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

						<input type="hidden" name="virgo_changed" value="N">
 <div class="button_wrapper button_wrapper_store inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Store';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('STORE') ?>"
						/><div class="button_right"></div></div><?php						
	if (!isset($masterPobId) && P('form_only', "0") != "1" && P('form_only', "0") != "5" && P('form_only', "0") != "6") {
?>
 <div class="button_wrapper button_wrapper_storeandclear inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='StoreAndClear';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('STORE_AND_CLEAR') ?>"
						/><div class="button_right"></div></div> <div class="button_wrapper button_wrapper_apply inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Apply';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('APPLY') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>
<?php
			if ($this->canExecute("delete")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Delete')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_delete inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("USER"), "\\'".rawurlencode($resultUser->getVirgoTitle())."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DELETE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
?>
<?php						
	if (!isset($masterPobId) && P('form_only') != "1" && P('form_only') != "5") {
?>
 <div class="button_wrapper button_wrapper_close inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								if (!(this.form.virgo_changed.value == 'T')) {
								} else {
									var alertText = '<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>';
									if (alertText.charAt(alertText.length-1)=='?') {
										if (!confirm(alertText)) return false;
									} else {
										alert(alertText); return false;
									}
								}
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Close';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>
				</div>
<script type="text/javascript" language="JavaScript">
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['usr_username_<?php echo $resultUser->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.2 Create */
	} elseif ($userDisplayMode == "CREATE") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_user") {
			  if (check.value == 'T') {
				  return "<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>";
			  }
		  }
        }
  }
</script>
	<div class="form_edit">
			<fieldset class="form">
				<legend>
<?php echo T('USER') ?>:</legend>
<?php
	if (!$formsInTable) {
?>
				<ul>
<?php
	} else {
?>
				<table>
<?php
	}
?>
<?php
	$createForm = P('create_form', "virgo_default");
	if (is_null($createForm) || trim($createForm) == "" || $createForm == "virgo_default") {
?>
<?php
		if (isset($resultUser->usr_id)) {
			$resultUser->usr_id = null;
		}
		$parentAjaxRendered = "0";
?>
<?php
	$tmpAction = R('portlet_action');
	if ($tmpAction != "Store" && $tmpAction != "Apply" && $tmpAction != "StoreAndClear" && $tmpAction != "BackFromParent") {

$defaultValue = P('create_default_value_page');
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
	$resultUser->setPgeId($defaultValue);
}
	}
?>
																																																						<?php
	if (P('show_create_username', "1") == "1" || P('show_create_username', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  obligatory " for="usr_username_<?php echo $resultUser->getId() ?>">
* <?php echo T('USERNAME') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "username") {
				$resultUser->setUsername($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_username', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getUsername(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="username" name="usr_username_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getUsername(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="usr_username_<?php echo $resultUser->getId() ?>" 
							name="usr_username_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getUsername(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_USERNAME');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_username_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_password', "1") == "1" || P('show_create_password', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_password_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_password_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_password_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('PASSWORD') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "password") {
				$resultUser->setPassword($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_password', "1") == "2") {
?>
<?php
	if (!is_null($resultUser->getPassword())) {
?>
		<?php echo T('PRESENT') ?>
<?php
	}
?>
<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input type="password"
							class="inputbox " 
							id="usr_password_<?php echo $resultUser->getId() ?>" 
							name="usr_password_<?php echo $resultUser->getId() ?>"
							size="15" 
							maxlength="14"
							value="<?php echo $resultUser->getPassword() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_PASSWORD');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						/>
<label align="right" for="usr_password2_<?php echo $resultUser->getId() ?>" nowrap class="fieldlabel " style="float: none;">						
<?php echo T('REPEAT') . ' ' . T('PASSWORD') ?>
</label>						
						<input type="password"
							class="inputbox " 
							id="usr_password2_<?php echo $resultUser->getId() ?>" 
							name="usr_password2_<?php echo $resultUser->getId() ?>"
							size="15" 
							maxlength="14"
							value="<?php echo $resultUser->getPassword() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
						/>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_password_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_email', "1") == "1" || P('show_create_email', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_email_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_email_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_email_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('EMAIL') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "email") {
				$resultUser->setEmail($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_email', "1") == "2") {
?>
<?php
	$email = htmlentities($resultUser->getEmail(), ENT_QUOTES, "UTF-8");
?>
<a class="inputbox readonly" href="mailto:<?php echo $email ?>" target="_blank">
	<?php echo $email ?>
</a>

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_email_obligatory', "0") == "1" ? " obligatory " : "" ?>   short   medium " 
							type="text"
							id="usr_email_<?php echo $resultUser->getId() ?>" 
							name="usr_email_<?php echo $resultUser->getId() ?>"
							size="50" 
							value="<?php echo htmlentities($resultUser->getEmail(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_EMAIL');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_email_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_first_name', "1") == "1" || P('show_create_first_name', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_first_name_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_firstName_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_first_name_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('FIRST_NAME') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "first_name") {
				$resultUser->setFirstName($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_first_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getFirstName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="firstName" name="usr_firstName_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getFirstName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_first_name_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_firstName_<?php echo $resultUser->getId() ?>" 
							name="usr_firstName_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getFirstName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_FIRST_NAME');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_firstName_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_last_name', "1") == "1" || P('show_create_last_name', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_last_name_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_lastName_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_last_name_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LAST_NAME') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "last_name") {
				$resultUser->setLastName($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_last_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getLastName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastName" name="usr_lastName_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getLastName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_last_name_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_lastName_<?php echo $resultUser->getId() ?>" 
							name="usr_lastName_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getLastName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_LAST_NAME');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_lastName_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_session_id', "1") == "1" || P('show_create_session_id', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_session_id_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_sessionId_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_session_id_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('SESSION_ID') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "session_id") {
				$resultUser->setSessionId($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_session_id', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getSessionId(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="sessionId" name="usr_sessionId_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getSessionId(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_session_id_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_sessionId_<?php echo $resultUser->getId() ?>" 
							name="usr_sessionId_<?php echo $resultUser->getId() ?>"
							maxlength="32"
							size="32" 
							value="<?php echo htmlentities($resultUser->getSessionId(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_SESSION_ID');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_sessionId_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_ip', "1") == "1" || P('show_create_ip', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_ip_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_ip_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_ip_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('IP') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "ip") {
				$resultUser->setIp($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_ip', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getIp(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="ip" name="usr_ip_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getIp(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_ip_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_ip_<?php echo $resultUser->getId() ?>" 
							name="usr_ip_<?php echo $resultUser->getId() ?>"
							maxlength="15"
							size="15" 
							value="<?php echo htmlentities($resultUser->getIp(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_IP');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_ip_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_logged_in', "1") == "1" || P('show_create_logged_in', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_logged_in_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_loggedIn_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_logged_in_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LOGGED_IN') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "logged_in") {
				$resultUser->setLoggedIn($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_logged_in', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="loggedIn"
>
<?php
	if (is_null($resultUser->getLoggedIn()) || $resultUser->getLoggedIn() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultUser->getLoggedIn() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultUser->getLoggedIn() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<select class="inputbox" id="usr_loggedIn_<?php echo $resultUser->getId() ?>" name="usr_loggedIn_<?php echo $resultUser->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_LOGGED_IN');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultUser->getLoggedIn() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultUser->getLoggedIn() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultUser->getLoggedIn()) || $resultUser->getLoggedIn() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_loggedIn_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_last_successful_login', "1") == "1" || P('show_create_last_successful_login', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_last_successful_login_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_last_successful_login_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LAST_SUCCESSFUL_LOGIN') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "last_successful_login") {
				$resultUser->setLastSuccessfulLogin($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_last_successful_login', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getLastSuccessfulLogin(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastSuccessfulLogin" name="usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getLastSuccessfulLogin(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<?php
	$locale = setlocale(LC_ALL,"0");
	if (isset($locale) && trim($locale) != "") {
		$lang = substr($locale, 0, 2);
	} else {
		$lang = "en";
	}
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
	if (!defined('JS_INCLUDED_TIMEPICKER')) {
		define('JS_INCLUDED_TIMEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQuery.timepicker/jquery-ui-timepicker-addon.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = $resultUser->getLastSuccessfulLogin();
?>
						<input class="inputbox" id="usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>" name="usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>'] = function () {
  $("#usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_last_failed_login', "1") == "1" || P('show_create_last_failed_login', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_last_failed_login_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_lastFailedLogin_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_last_failed_login_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LAST_FAILED_LOGIN') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "last_failed_login") {
				$resultUser->setLastFailedLogin($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_last_failed_login', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getLastFailedLogin(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastFailedLogin" name="usr_lastFailedLogin_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getLastFailedLogin(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<?php
	$locale = setlocale(LC_ALL,"0");
	if (isset($locale) && trim($locale) != "") {
		$lang = substr($locale, 0, 2);
	} else {
		$lang = "en";
	}
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
	if (!defined('JS_INCLUDED_TIMEPICKER')) {
		define('JS_INCLUDED_TIMEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQuery.timepicker/jquery-ui-timepicker-addon.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = $resultUser->getLastFailedLogin();
?>
						<input class="inputbox" id="usr_lastFailedLogin_<?php echo $resultUser->getId() ?>" name="usr_lastFailedLogin_<?php echo $resultUser->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastFailedLogin_<?php echo $resultUser->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastFailedLogin_<?php echo $resultUser->getId() ?>'] = function () {
  $("#usr_lastFailedLogin_<?php echo $resultUser->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_last_logout', "1") == "1" || P('show_create_last_logout', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_last_logout_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_lastLogout_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_last_logout_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LAST_LOGOUT') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "last_logout") {
				$resultUser->setLastLogout($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_last_logout', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getLastLogout(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastLogout" name="usr_lastLogout_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getLastLogout(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<?php
	$locale = setlocale(LC_ALL,"0");
	if (isset($locale) && trim($locale) != "") {
		$lang = substr($locale, 0, 2);
	} else {
		$lang = "en";
	}
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
	if (!defined('JS_INCLUDED_TIMEPICKER')) {
		define('JS_INCLUDED_TIMEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQuery.timepicker/jquery-ui-timepicker-addon.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = $resultUser->getLastLogout();
?>
						<input class="inputbox" id="usr_lastLogout_<?php echo $resultUser->getId() ?>" name="usr_lastLogout_<?php echo $resultUser->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastLogout_<?php echo $resultUser->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastLogout_<?php echo $resultUser->getId() ?>'] = function () {
  $("#usr_lastLogout_<?php echo $resultUser->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_user_agent', "1") == "1" || P('show_create_user_agent', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_user_agent_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_userAgent_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_user_agent_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('USER_AGENT') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "user_agent") {
				$resultUser->setUserAgent($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_user_agent', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getUserAgent(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="userAgent" name="usr_userAgent_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getUserAgent(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_user_agent_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_userAgent_<?php echo $resultUser->getId() ?>" 
							name="usr_userAgent_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getUserAgent(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_USER_AGENT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_userAgent_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_token', "1") == "1" || P('show_create_token', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_token_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_token_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_token_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('TOKEN') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "token") {
				$resultUser->setToken($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_token', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getToken(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="token" name="usr_token_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getToken(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_token_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_token_<?php echo $resultUser->getId() ?>" 
							name="usr_token_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getToken(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_TOKEN');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_token_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_unidentified', "1") == "1" || P('show_create_unidentified', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_unidentified_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_unidentified_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_unidentified_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('UNIDENTIFIED') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "unidentified") {
				$resultUser->setUnidentified($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_unidentified', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="unidentified"
>
<?php
	if (is_null($resultUser->getUnidentified()) || $resultUser->getUnidentified() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultUser->getUnidentified() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultUser->getUnidentified() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<select class="inputbox" id="usr_unidentified_<?php echo $resultUser->getId() ?>" name="usr_unidentified_<?php echo $resultUser->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_UNIDENTIFIED');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultUser->getUnidentified() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultUser->getUnidentified() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultUser->getUnidentified()) || $resultUser->getUnidentified() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_unidentified_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_confirmed', "1") == "1" || P('show_create_confirmed', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_confirmed_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_confirmed_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_confirmed_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CONFIRMED') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "confirmed") {
				$resultUser->setConfirmed($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_confirmed', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="confirmed"
>
<?php
	if (is_null($resultUser->getConfirmed()) || $resultUser->getConfirmed() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultUser->getConfirmed() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultUser->getConfirmed() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<select class="inputbox" id="usr_confirmed_<?php echo $resultUser->getId() ?>" name="usr_confirmed_<?php echo $resultUser->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_CONFIRMED');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultUser->getConfirmed() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultUser->getConfirmed() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultUser->getConfirmed()) || $resultUser->getConfirmed() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_confirmed_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_accepted', "1") == "1" || P('show_create_accepted', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_accepted_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_accepted_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_accepted_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('ACCEPTED') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "accepted") {
				$resultUser->setAccepted($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_accepted', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="accepted"
>
<?php
	if (is_null($resultUser->getAccepted()) || $resultUser->getAccepted() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultUser->getAccepted() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultUser->getAccepted() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<select class="inputbox" id="usr_accepted_<?php echo $resultUser->getId() ?>" name="usr_accepted_<?php echo $resultUser->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_ACCEPTED');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultUser->getAccepted() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultUser->getAccepted() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultUser->getAccepted()) || $resultUser->getAccepted() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_accepted_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (class_exists('portal\virgoPage') && ((P('show_create_page', "1") == "1" || P('show_create_page', "1") == "2" || P('show_create_page', "1") == "3") && !isset($context["pge"]))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_create_page_obligatory') == "1" ? " obligatory " : "" ?> " for="usr_page_<?php echo isset($resultUser->usr_id) ? $resultUser->usr_id : '' ?>">
<?php echo P('show_create_page_obligatory') == "1" ? " * " : "" ?>
<?php echo T('PAGE') ?> <?php echo T('') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
<?php
//		$limit_page = $componentParams->get('limit_to_page');
		$limit_page = null;
		$tmpId = portal\virgoUser::getParentInContext("portal\\virgoPage");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_page', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultUser->usr_pge__id = $tmpId;
//			}
			if (!is_null($resultUser->getPgeId())) {
				$parentId = $resultUser->getPgeId();
				$parentValue = portal\virgoPage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="usr_page_<?php echo $resultUser->getId() ?>" name="usr_page_<?php echo $resultUser->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_USER_PAGE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_page) && trim($limit_page) != "") {
		$whereList = $whereList . " pge_id ";
		if (trim($limit_page) == "page_title") {
			$limit_page = "SELECT pge_id FROM prt_pages WHERE pge_" . $limit_page . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_page = \"$limit_page\";");
		$whereList = $whereList . " IN (" . $limit_page . ") ";
	}						
	$parentCount = portal\virgoPage::getVirgoListSize($whereList);
	$showAjaxusr = P('show_create_page', "1") == "3" || $parentCount > 100;
	if (!$showAjaxusr) {
?>
    						<select 
							class="inputbox  <?php echo P('show_create_page_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="usr_page_<?php echo !is_null($resultUser->getId()) ? $resultUser->getId() : '' ?>" 
							name="usr_page_<?php echo !is_null($resultUser->getId()) ? $resultUser->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_page) || trim($limit_page) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPage = portal\virgoPage::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPage)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultUser->getPgeId()) && $id == $resultUser->getPgeId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultUser->getPgeId();
				$parentPage = new portal\virgoPage();
				$parentValue = $parentPage->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="usr_page_<?php echo $resultUser->getId() ?>" name="usr_page_<?php echo $resultUser->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="usr_page_dropdown_<?php echo $resultUser->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#usr_page_dropdown_<?php echo $resultUser->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Page",
			virgo_field_name: "page",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#usr_page_<?php echo $resultUser->getId() ?>').val(ui.item.value);
				  	$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').val(ui.item.label);
				  	$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#usr_page_<?php echo $resultUser->getId() ?>').val('');
				$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
?>
<?php
	if (isset($context["pge"])) {
		$parentValue = $context["pge"];
	} else {
		$parentValue = $resultUser->usr_pge_id;
	}
	
?>
				<input type="hidden" id="usr_page_<?php echo $resultUser->usr_id ?>" name="usr_page_<?php echo $resultUser->usr_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>

<?php
	if (class_exists('portal\virgoUserRole') && P('show_create_user_roles', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel userRole" for="usr_userRole_<?php echo $resultUser->getId() ?>[]">
User roles 
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
			$parentRole = new portal\virgoRole();
			$whereList = "";
			$resultsRole = $parentRole->getVirgoList($whereList);
			$currentConnections = $resultUser->getUserRoles();
			$currentIds = array();
			foreach ($currentConnections as $currentConnection) {
				$currentIds[] = $currentConnection->getRoleId();
			}
			$defaultParents = PN('create_default_values_roles');
			$currentIds = array_merge($currentIds, $defaultParents);
?>
<?php
	$inputMethod = P('n_m_children_input_user_role_', "select");
	if (is_null($inputMethod) || trim($inputMethod) == "") {
		$inputMethod = "select";
	}
	if ($inputMethod == "select") {
?>
						<select 
							class="inputbox" 
							id="usr_userRole_<?php echo $resultUser->usr_id ?>[]" 
							name="usr_userRole_<?php echo $resultUser->usr_id ?>[]" 
							multiple 
							size=<?php echo sizeof($resultsRole) > 10 ? 10 : sizeof($resultsRole) ?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
						>
<?php
			while (list($id, $label) = each($resultsRole)) {
?>
							<option 
								value="<?php echo $id ?>"
								<?php echo in_array($id, $currentIds) ? "selected" : "" ?> 
							><?php echo $label ?></option>
<?php
			}
?>
						</select>
<?php
	} elseif ($inputMethod == "checkbox") {
?>
						<ul>
<?php
			reset($resultsRole);
			while (list($id, $label) = each($resultsRole)) {
?>
							<li class="parent_selection">
								<input 
									type="checkbox"
									class="inputbox checkbox"
									id="usr_userRole_<?php echo $resultUser->usr_id ?>[]" 
									name="usr_userRole_<?php echo $resultUser->usr_id ?>[]" 
									value="<?php echo $id ?>"
									<?php echo in_array($id, $currentIds) ? "checked" : "" ?>
								>
								<span class="multilabel"><?php echo $label ?></span>
							</li>
<?php
			}
?>
						</ul>
<?php
	} 
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
	$defaultParents = PN('create_default_values_roles');
	foreach ($defaultParents as $defaultParent) {
?>
		<input type="hidden" name="usr_userRole_[]" value="<?php echo $defaultParent ?>"/>
<?php	
	}
	}
?>
<?php
	if (class_exists('portal\virgoSystemMessage') && P('show_create_system_messages', '1') == "1") {
?>
<?php
	} else {
	}
?>


<?php
	} elseif ($createForm == "virgo_entity") {
?>
<?php
		if (isset($resultUser->usr_id)) {
			$resultUser->usr_id = null;
		}
		$parentAjaxRendered = "0";
?>
<?php
	$tmpAction = R('portlet_action');
	if ($tmpAction != "Store" && $tmpAction != "Apply" && $tmpAction != "StoreAndClear" && $tmpAction != "BackFromParent") {

$defaultValue = P('create_default_value_page');
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
	$resultUser->setPgeId($defaultValue);
}
	}
?>
																																																						<?php
	if (P('show_create_username', "1") == "1" || P('show_create_username', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  obligatory " for="usr_username_<?php echo $resultUser->getId() ?>">
* <?php echo T('USERNAME') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "username") {
				$resultUser->setUsername($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_username', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getUsername(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="username" name="usr_username_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getUsername(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="usr_username_<?php echo $resultUser->getId() ?>" 
							name="usr_username_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getUsername(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_USERNAME');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_username_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_password', "1") == "1" || P('show_create_password', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_password_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_password_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_password_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('PASSWORD') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "password") {
				$resultUser->setPassword($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_password', "1") == "2") {
?>
<?php
	if (!is_null($resultUser->getPassword())) {
?>
		<?php echo T('PRESENT') ?>
<?php
	}
?>
<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input type="password"
							class="inputbox " 
							id="usr_password_<?php echo $resultUser->getId() ?>" 
							name="usr_password_<?php echo $resultUser->getId() ?>"
							size="15" 
							maxlength="14"
							value="<?php echo $resultUser->getPassword() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_PASSWORD');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						/>
<label align="right" for="usr_password2_<?php echo $resultUser->getId() ?>" nowrap class="fieldlabel " style="float: none;">						
<?php echo T('REPEAT') . ' ' . T('PASSWORD') ?>
</label>						
						<input type="password"
							class="inputbox " 
							id="usr_password2_<?php echo $resultUser->getId() ?>" 
							name="usr_password2_<?php echo $resultUser->getId() ?>"
							size="15" 
							maxlength="14"
							value="<?php echo $resultUser->getPassword() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
						/>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_password_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_email', "1") == "1" || P('show_create_email', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_email_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_email_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_email_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('EMAIL') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "email") {
				$resultUser->setEmail($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_email', "1") == "2") {
?>
<?php
	$email = htmlentities($resultUser->getEmail(), ENT_QUOTES, "UTF-8");
?>
<a class="inputbox readonly" href="mailto:<?php echo $email ?>" target="_blank">
	<?php echo $email ?>
</a>

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_email_obligatory', "0") == "1" ? " obligatory " : "" ?>   short   medium " 
							type="text"
							id="usr_email_<?php echo $resultUser->getId() ?>" 
							name="usr_email_<?php echo $resultUser->getId() ?>"
							size="50" 
							value="<?php echo htmlentities($resultUser->getEmail(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_EMAIL');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_email_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_first_name', "1") == "1" || P('show_create_first_name', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_first_name_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_firstName_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_first_name_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('FIRST_NAME') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "first_name") {
				$resultUser->setFirstName($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_first_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getFirstName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="firstName" name="usr_firstName_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getFirstName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_first_name_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_firstName_<?php echo $resultUser->getId() ?>" 
							name="usr_firstName_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getFirstName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_FIRST_NAME');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_firstName_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_last_name', "1") == "1" || P('show_create_last_name', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_last_name_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_lastName_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_last_name_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LAST_NAME') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "last_name") {
				$resultUser->setLastName($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_last_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getLastName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastName" name="usr_lastName_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getLastName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_last_name_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_lastName_<?php echo $resultUser->getId() ?>" 
							name="usr_lastName_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getLastName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_LAST_NAME');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_lastName_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_session_id', "1") == "1" || P('show_create_session_id', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_session_id_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_sessionId_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_session_id_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('SESSION_ID') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "session_id") {
				$resultUser->setSessionId($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_session_id', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getSessionId(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="sessionId" name="usr_sessionId_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getSessionId(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_session_id_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_sessionId_<?php echo $resultUser->getId() ?>" 
							name="usr_sessionId_<?php echo $resultUser->getId() ?>"
							maxlength="32"
							size="32" 
							value="<?php echo htmlentities($resultUser->getSessionId(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_SESSION_ID');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_sessionId_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_ip', "1") == "1" || P('show_create_ip', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_ip_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_ip_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_ip_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('IP') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "ip") {
				$resultUser->setIp($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_ip', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getIp(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="ip" name="usr_ip_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getIp(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_ip_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_ip_<?php echo $resultUser->getId() ?>" 
							name="usr_ip_<?php echo $resultUser->getId() ?>"
							maxlength="15"
							size="15" 
							value="<?php echo htmlentities($resultUser->getIp(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_IP');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_ip_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_logged_in', "1") == "1" || P('show_create_logged_in', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_logged_in_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_loggedIn_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_logged_in_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LOGGED_IN') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "logged_in") {
				$resultUser->setLoggedIn($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_logged_in', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="loggedIn"
>
<?php
	if (is_null($resultUser->getLoggedIn()) || $resultUser->getLoggedIn() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultUser->getLoggedIn() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultUser->getLoggedIn() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<select class="inputbox" id="usr_loggedIn_<?php echo $resultUser->getId() ?>" name="usr_loggedIn_<?php echo $resultUser->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_LOGGED_IN');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultUser->getLoggedIn() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultUser->getLoggedIn() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultUser->getLoggedIn()) || $resultUser->getLoggedIn() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_loggedIn_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_last_successful_login', "1") == "1" || P('show_create_last_successful_login', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_last_successful_login_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_last_successful_login_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LAST_SUCCESSFUL_LOGIN') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "last_successful_login") {
				$resultUser->setLastSuccessfulLogin($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_last_successful_login', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getLastSuccessfulLogin(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastSuccessfulLogin" name="usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getLastSuccessfulLogin(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<?php
	$locale = setlocale(LC_ALL,"0");
	if (isset($locale) && trim($locale) != "") {
		$lang = substr($locale, 0, 2);
	} else {
		$lang = "en";
	}
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
	if (!defined('JS_INCLUDED_TIMEPICKER')) {
		define('JS_INCLUDED_TIMEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQuery.timepicker/jquery-ui-timepicker-addon.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = $resultUser->getLastSuccessfulLogin();
?>
						<input class="inputbox" id="usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>" name="usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>'] = function () {
  $("#usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_last_failed_login', "1") == "1" || P('show_create_last_failed_login', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_last_failed_login_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_lastFailedLogin_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_last_failed_login_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LAST_FAILED_LOGIN') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "last_failed_login") {
				$resultUser->setLastFailedLogin($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_last_failed_login', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getLastFailedLogin(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastFailedLogin" name="usr_lastFailedLogin_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getLastFailedLogin(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<?php
	$locale = setlocale(LC_ALL,"0");
	if (isset($locale) && trim($locale) != "") {
		$lang = substr($locale, 0, 2);
	} else {
		$lang = "en";
	}
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
	if (!defined('JS_INCLUDED_TIMEPICKER')) {
		define('JS_INCLUDED_TIMEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQuery.timepicker/jquery-ui-timepicker-addon.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = $resultUser->getLastFailedLogin();
?>
						<input class="inputbox" id="usr_lastFailedLogin_<?php echo $resultUser->getId() ?>" name="usr_lastFailedLogin_<?php echo $resultUser->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastFailedLogin_<?php echo $resultUser->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastFailedLogin_<?php echo $resultUser->getId() ?>'] = function () {
  $("#usr_lastFailedLogin_<?php echo $resultUser->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_last_logout', "1") == "1" || P('show_create_last_logout', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_last_logout_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_lastLogout_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_last_logout_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LAST_LOGOUT') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "last_logout") {
				$resultUser->setLastLogout($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_last_logout', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getLastLogout(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastLogout" name="usr_lastLogout_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getLastLogout(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<?php
	$locale = setlocale(LC_ALL,"0");
	if (isset($locale) && trim($locale) != "") {
		$lang = substr($locale, 0, 2);
	} else {
		$lang = "en";
	}
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
	if (!defined('JS_INCLUDED_TIMEPICKER')) {
		define('JS_INCLUDED_TIMEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQuery.timepicker/jquery-ui-timepicker-addon.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = $resultUser->getLastLogout();
?>
						<input class="inputbox" id="usr_lastLogout_<?php echo $resultUser->getId() ?>" name="usr_lastLogout_<?php echo $resultUser->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastLogout_<?php echo $resultUser->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastLogout_<?php echo $resultUser->getId() ?>'] = function () {
  $("#usr_lastLogout_<?php echo $resultUser->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_user_agent', "1") == "1" || P('show_create_user_agent', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_user_agent_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_userAgent_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_user_agent_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('USER_AGENT') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "user_agent") {
				$resultUser->setUserAgent($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_user_agent', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getUserAgent(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="userAgent" name="usr_userAgent_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getUserAgent(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_user_agent_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_userAgent_<?php echo $resultUser->getId() ?>" 
							name="usr_userAgent_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getUserAgent(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_USER_AGENT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_userAgent_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_token', "1") == "1" || P('show_create_token', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_token_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_token_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_token_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('TOKEN') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "token") {
				$resultUser->setToken($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_token', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getToken(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="token" name="usr_token_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getToken(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_token_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_token_<?php echo $resultUser->getId() ?>" 
							name="usr_token_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getToken(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_TOKEN');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_token_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_unidentified', "1") == "1" || P('show_create_unidentified', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_unidentified_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_unidentified_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_unidentified_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('UNIDENTIFIED') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "unidentified") {
				$resultUser->setUnidentified($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_unidentified', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="unidentified"
>
<?php
	if (is_null($resultUser->getUnidentified()) || $resultUser->getUnidentified() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultUser->getUnidentified() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultUser->getUnidentified() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<select class="inputbox" id="usr_unidentified_<?php echo $resultUser->getId() ?>" name="usr_unidentified_<?php echo $resultUser->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_UNIDENTIFIED');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultUser->getUnidentified() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultUser->getUnidentified() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultUser->getUnidentified()) || $resultUser->getUnidentified() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_unidentified_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_confirmed', "1") == "1" || P('show_create_confirmed', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_confirmed_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_confirmed_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_confirmed_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CONFIRMED') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "confirmed") {
				$resultUser->setConfirmed($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_confirmed', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="confirmed"
>
<?php
	if (is_null($resultUser->getConfirmed()) || $resultUser->getConfirmed() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultUser->getConfirmed() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultUser->getConfirmed() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<select class="inputbox" id="usr_confirmed_<?php echo $resultUser->getId() ?>" name="usr_confirmed_<?php echo $resultUser->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_CONFIRMED');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultUser->getConfirmed() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultUser->getConfirmed() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultUser->getConfirmed()) || $resultUser->getConfirmed() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_confirmed_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_accepted', "1") == "1" || P('show_create_accepted', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_accepted_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="usr_accepted_<?php echo $resultUser->getId() ?>">
 <?php echo P('show_create_accepted_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('ACCEPTED') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "accepted") {
				$resultUser->setAccepted($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_accepted', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="accepted"
>
<?php
	if (is_null($resultUser->getAccepted()) || $resultUser->getAccepted() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultUser->getAccepted() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultUser->getAccepted() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<select class="inputbox" id="usr_accepted_<?php echo $resultUser->getId() ?>" name="usr_accepted_<?php echo $resultUser->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_ACCEPTED');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultUser->getAccepted() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultUser->getAccepted() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultUser->getAccepted()) || $resultUser->getAccepted() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_accepted_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (class_exists('portal\virgoPage') && ((P('show_create_page', "1") == "1" || P('show_create_page', "1") == "2" || P('show_create_page', "1") == "3") && !isset($context["pge"]))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_create_page_obligatory') == "1" ? " obligatory " : "" ?> " for="usr_page_<?php echo isset($resultUser->usr_id) ? $resultUser->usr_id : '' ?>">
<?php echo P('show_create_page_obligatory') == "1" ? " * " : "" ?>
<?php echo T('PAGE') ?> <?php echo T('') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
<?php
//		$limit_page = $componentParams->get('limit_to_page');
		$limit_page = null;
		$tmpId = portal\virgoUser::getParentInContext("portal\\virgoPage");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_page', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultUser->usr_pge__id = $tmpId;
//			}
			if (!is_null($resultUser->getPgeId())) {
				$parentId = $resultUser->getPgeId();
				$parentValue = portal\virgoPage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="usr_page_<?php echo $resultUser->getId() ?>" name="usr_page_<?php echo $resultUser->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_USER_PAGE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_page) && trim($limit_page) != "") {
		$whereList = $whereList . " pge_id ";
		if (trim($limit_page) == "page_title") {
			$limit_page = "SELECT pge_id FROM prt_pages WHERE pge_" . $limit_page . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_page = \"$limit_page\";");
		$whereList = $whereList . " IN (" . $limit_page . ") ";
	}						
	$parentCount = portal\virgoPage::getVirgoListSize($whereList);
	$showAjaxusr = P('show_create_page', "1") == "3" || $parentCount > 100;
	if (!$showAjaxusr) {
?>
    						<select 
							class="inputbox  <?php echo P('show_create_page_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="usr_page_<?php echo !is_null($resultUser->getId()) ? $resultUser->getId() : '' ?>" 
							name="usr_page_<?php echo !is_null($resultUser->getId()) ? $resultUser->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_page) || trim($limit_page) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPage = portal\virgoPage::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPage)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultUser->getPgeId()) && $id == $resultUser->getPgeId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultUser->getPgeId();
				$parentPage = new portal\virgoPage();
				$parentValue = $parentPage->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="usr_page_<?php echo $resultUser->getId() ?>" name="usr_page_<?php echo $resultUser->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="usr_page_dropdown_<?php echo $resultUser->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#usr_page_dropdown_<?php echo $resultUser->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Page",
			virgo_field_name: "page",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#usr_page_<?php echo $resultUser->getId() ?>').val(ui.item.value);
				  	$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').val(ui.item.label);
				  	$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#usr_page_<?php echo $resultUser->getId() ?>').val('');
				$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
?>
<?php
	if (isset($context["pge"])) {
		$parentValue = $context["pge"];
	} else {
		$parentValue = $resultUser->usr_pge_id;
	}
	
?>
				<input type="hidden" id="usr_page_<?php echo $resultUser->usr_id ?>" name="usr_page_<?php echo $resultUser->usr_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>

<?php
	if (class_exists('portal\virgoUserRole') && P('show_create_user_roles', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel userRole" for="usr_userRole_<?php echo $resultUser->getId() ?>[]">
User roles 
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
			$parentRole = new portal\virgoRole();
			$whereList = "";
			$resultsRole = $parentRole->getVirgoList($whereList);
			$currentConnections = $resultUser->getUserRoles();
			$currentIds = array();
			foreach ($currentConnections as $currentConnection) {
				$currentIds[] = $currentConnection->getRoleId();
			}
			$defaultParents = PN('create_default_values_roles');
			$currentIds = array_merge($currentIds, $defaultParents);
?>
<?php
	$inputMethod = P('n_m_children_input_user_role_', "select");
	if (is_null($inputMethod) || trim($inputMethod) == "") {
		$inputMethod = "select";
	}
	if ($inputMethod == "select") {
?>
						<select 
							class="inputbox" 
							id="usr_userRole_<?php echo $resultUser->usr_id ?>[]" 
							name="usr_userRole_<?php echo $resultUser->usr_id ?>[]" 
							multiple 
							size=<?php echo sizeof($resultsRole) > 10 ? 10 : sizeof($resultsRole) ?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
						>
<?php
			while (list($id, $label) = each($resultsRole)) {
?>
							<option 
								value="<?php echo $id ?>"
								<?php echo in_array($id, $currentIds) ? "selected" : "" ?> 
							><?php echo $label ?></option>
<?php
			}
?>
						</select>
<?php
	} elseif ($inputMethod == "checkbox") {
?>
						<ul>
<?php
			reset($resultsRole);
			while (list($id, $label) = each($resultsRole)) {
?>
							<li class="parent_selection">
								<input 
									type="checkbox"
									class="inputbox checkbox"
									id="usr_userRole_<?php echo $resultUser->usr_id ?>[]" 
									name="usr_userRole_<?php echo $resultUser->usr_id ?>[]" 
									value="<?php echo $id ?>"
									<?php echo in_array($id, $currentIds) ? "checked" : "" ?>
								>
								<span class="multilabel"><?php echo $label ?></span>
							</li>
<?php
			}
?>
						</ul>
<?php
	} 
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
	$defaultParents = PN('create_default_values_roles');
	foreach ($defaultParents as $defaultParent) {
?>
		<input type="hidden" name="usr_userRole_[]" value="<?php echo $defaultParent ?>"/>
<?php	
	}
	}
?>
<?php
	if (class_exists('portal\virgoSystemMessage') && P('show_create_system_messages', '1') == "1") {
?>
<?php
	} else {
	}
?>


<?php
	}
?>
<?php
	if (!$formsInTable) {
?>
				</ul>
<?php
	} else {
?>
				</table>
<?php
	}
?>
			</fieldset>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultUser->getDateCreated()) {
		if ($resultUser->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultUser->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultUser->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultUser->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultUser->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultUser->getDateModified()) {
		if ($resultUser->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultUser->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultUser->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultUser->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultUser->getDateModified() ?>"	>
				</li>
<?php
	}
	if ($showFieldset == 1) {
?>
		</ul>
</fieldset>
<?php
	}
}
?>

				<div class="buttons form-actions">
						<input type="text" name="usr_id_<?php echo $this->getId() ?>" id="usr_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

						<input type="hidden" name="virgo_changed" value="N">
<?php
	$actions = virgoRole::getExtraActions('IC');
	if (isset($actions) && count($actions) > 0) {
		foreach ($actions as $action) {
?>

<?php
	$buttonRendered = false;
	if ($this->canExecute($action)) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_<?php echo $action ?> inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='<?php echo $action ?>';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($action) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php						
		}
	} else {
?>
 <div class="button_wrapper button_wrapper_store inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Store';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('STORE') ?>"
						/><div class="button_right"></div></div><?php						
		if ((!isset($masterPobId) || trim($masterPobId) == "") && P('form_only', "0") != "1" && P('form_only') != "5") {
?>
 <div class="button_wrapper button_wrapper_storeandclear inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='StoreAndClear';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('STORE_AND_CLEAR') ?>"
						/><div class="button_right"></div></div><?php 
	if ($this->canExecute("Form")) {
?>
 <div class="button_wrapper button_wrapper_apply inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Apply';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('APPLY') ?>"
						/><div class="button_right"></div></div><?php 
	}
?>
 <div class="button_wrapper button_wrapper_close inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								if (!(this.form.virgo_changed.value == 'T')) {
								} else {
									var alertText = '<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>';
									if (alertText.charAt(alertText.length-1)=='?') {
										if (!confirm(alertText)) return false;
									} else {
										alert(alertText); return false;
									}
								}
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Close';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
		}
		$actions = virgoRole::getExtraActions('EC');
		foreach ($actions as $action) {
?>

<?php
	$buttonRendered = false;
	if ($this->canExecute($action)) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_<?php echo $action ?> inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='<?php echo $action ?>';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($action) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php						
		}
	}
?>

				</div>
<script type="text/javascript" language="JavaScript">
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['usr_username_<?php echo $resultUser->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.3 Search */
	} elseif ($userDisplayMode == "SEARCH") {
?>
	<div class="form_edit form_search">
			<fieldset class="form">
				<legend>
<?php echo T('USER') ?>:</legend>
				<ul>
<?php
	$criteriaUser = $resultUser->getCriteria();
?>
<?php
	if (P('show_search_username', "1") == "1") {

		if (isset($criteriaUser["username"])) {
			$fieldCriteriaUsername = $criteriaUser["username"];
			$dataTypeCriteria = $fieldCriteriaUsername["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('USERNAME') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_username" 
							name="virgo_search_username"
							style="border: yellow 1 solid;" 
							maxlength="255"
							size="50" 
							value="<?php echo isset($dataTypeCriteria["default"]) ? htmlentities($dataTypeCriteria["default"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_username_is_null" 
				name="virgo_search_username_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaUsername) && $fieldCriteriaUsername["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaUsername) && $fieldCriteriaUsername["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaUsername) && $fieldCriteriaUsername["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_password', "1") == "1") {

		if (isset($criteriaUser["password"])) {
			$fieldCriteriaPassword = $criteriaUser["password"];
			$dataTypeCriteria = $fieldCriteriaPassword["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('PASSWORD') ?>
		</label>
		<span align="left" nowrap>
		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_password_is_null" 
				name="virgo_search_password_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaPassword) && $fieldCriteriaPassword["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaPassword) && $fieldCriteriaPassword["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaPassword) && $fieldCriteriaPassword["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_email', "1") == "1") {

		if (isset($criteriaUser["email"])) {
			$fieldCriteriaEmail = $criteriaUser["email"];
			$dataTypeCriteria = $fieldCriteriaEmail["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('EMAIL') ?>
		</label>
		<span align="left" nowrap>
		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_email_is_null" 
				name="virgo_search_email_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaEmail) && $fieldCriteriaEmail["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaEmail) && $fieldCriteriaEmail["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaEmail) && $fieldCriteriaEmail["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_first_name', "1") == "1") {

		if (isset($criteriaUser["first_name"])) {
			$fieldCriteriaFirstName = $criteriaUser["first_name"];
			$dataTypeCriteria = $fieldCriteriaFirstName["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('FIRST_NAME') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_firstName" 
							name="virgo_search_firstName"
							style="border: yellow 1 solid;" 
							maxlength="255"
							size="50" 
							value="<?php echo isset($dataTypeCriteria["default"]) ? htmlentities($dataTypeCriteria["default"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_firstName_is_null" 
				name="virgo_search_firstName_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaFirstName) && $fieldCriteriaFirstName["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaFirstName) && $fieldCriteriaFirstName["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaFirstName) && $fieldCriteriaFirstName["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_last_name', "1") == "1") {

		if (isset($criteriaUser["last_name"])) {
			$fieldCriteriaLastName = $criteriaUser["last_name"];
			$dataTypeCriteria = $fieldCriteriaLastName["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('LAST_NAME') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_lastName" 
							name="virgo_search_lastName"
							style="border: yellow 1 solid;" 
							maxlength="255"
							size="50" 
							value="<?php echo isset($dataTypeCriteria["default"]) ? htmlentities($dataTypeCriteria["default"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_lastName_is_null" 
				name="virgo_search_lastName_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaLastName) && $fieldCriteriaLastName["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaLastName) && $fieldCriteriaLastName["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaLastName) && $fieldCriteriaLastName["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_session_id', "1") == "1") {

		if (isset($criteriaUser["session_id"])) {
			$fieldCriteriaSessionId = $criteriaUser["session_id"];
			$dataTypeCriteria = $fieldCriteriaSessionId["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('SESSION_ID') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_sessionId" 
							name="virgo_search_sessionId"
							style="border: yellow 1 solid;" 
							maxlength="32"
							size="32" 
							value="<?php echo isset($dataTypeCriteria["default"]) ? htmlentities($dataTypeCriteria["default"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_sessionId_is_null" 
				name="virgo_search_sessionId_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaSessionId) && $fieldCriteriaSessionId["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaSessionId) && $fieldCriteriaSessionId["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaSessionId) && $fieldCriteriaSessionId["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_ip', "1") == "1") {

		if (isset($criteriaUser["ip"])) {
			$fieldCriteriaIp = $criteriaUser["ip"];
			$dataTypeCriteria = $fieldCriteriaIp["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('IP') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_ip" 
							name="virgo_search_ip"
							style="border: yellow 1 solid;" 
							maxlength="15"
							size="15" 
							value="<?php echo isset($dataTypeCriteria["default"]) ? htmlentities($dataTypeCriteria["default"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_ip_is_null" 
				name="virgo_search_ip_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaIp) && $fieldCriteriaIp["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaIp) && $fieldCriteriaIp["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaIp) && $fieldCriteriaIp["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_logged_in', "1") == "1") {

		if (isset($criteriaUser["logged_in"])) {
			$fieldCriteriaLoggedIn = $criteriaUser["logged_in"];
			$dataTypeCriteria = $fieldCriteriaLoggedIn["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('LOGGED_IN') ?>
		</label>
		<span align="left" nowrap>
<select id="virgo_search_loggedIn" name="virgo_search_loggedIn">
	<option value="" <?php echo !isset($dataTypeCriteria) ? "selected='selected'" : "" ?>></option>
	<option value="1" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] === 0 ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_loggedIn_is_null" 
				name="virgo_search_loggedIn_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaLoggedIn) && $fieldCriteriaLoggedIn["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaLoggedIn) && $fieldCriteriaLoggedIn["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaLoggedIn) && $fieldCriteriaLoggedIn["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_last_successful_login', "1") == "1") {

		if (isset($criteriaUser["last_successful_login"])) {
			$fieldCriteriaLastSuccessfulLogin = $criteriaUser["last_successful_login"];
			$dataTypeCriteria = $fieldCriteriaLastSuccessfulLogin["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('LAST_SUCCESSFUL_LOGIN') ?>
		</label>
		<span align="left" nowrap>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/js/jquery-ui-1.8.21.custom.min.js"></script>
<link href="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = isset($dataTypeCriteria["from"]) ? $dataTypeCriteria["from"] : "";
?>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_lastSuccessfulLogin_from" 
							name="virgo_search_lastSuccessfulLogin_from" 
							size="20" 
							value="<?php echo $tmp_date ?>" 
						>
<script type="text/javascript">
$(function(){ 
  $("#virgo_search_lastSuccessfulLogin_from").datepicker({dateFormat: "yy-mm-dd"});
});
</script>
						&nbsp;-&nbsp;
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = isset($dataTypeCriteria["to"]) ? $dataTypeCriteria["to"] : "";
?>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_lastSuccessfulLogin_to" 
							name="virgo_search_lastSuccessfulLogin_to" 
							size="20" 
							value="<?php echo $tmp_date ?>" 
						>
<script type="text/javascript">
$(function(){ 
  $("#virgo_search_lastSuccessfulLogin_to").datepicker({dateFormat: "yy-mm-dd"});
});
</script>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_lastSuccessfulLogin_is_null" 
				name="virgo_search_lastSuccessfulLogin_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaLastSuccessfulLogin) && $fieldCriteriaLastSuccessfulLogin["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaLastSuccessfulLogin) && $fieldCriteriaLastSuccessfulLogin["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaLastSuccessfulLogin) && $fieldCriteriaLastSuccessfulLogin["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_last_failed_login', "1") == "1") {

		if (isset($criteriaUser["last_failed_login"])) {
			$fieldCriteriaLastFailedLogin = $criteriaUser["last_failed_login"];
			$dataTypeCriteria = $fieldCriteriaLastFailedLogin["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('LAST_FAILED_LOGIN') ?>
		</label>
		<span align="left" nowrap>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = isset($dataTypeCriteria["from"]) ? $dataTypeCriteria["from"] : "";
?>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_lastFailedLogin_from" 
							name="virgo_search_lastFailedLogin_from" 
							size="20" 
							value="<?php echo $tmp_date ?>" 
						>
<script type="text/javascript">
$(function(){ 
  $("#virgo_search_lastFailedLogin_from").datepicker({dateFormat: "yy-mm-dd"});
});
</script>
						&nbsp;-&nbsp;
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = isset($dataTypeCriteria["to"]) ? $dataTypeCriteria["to"] : "";
?>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_lastFailedLogin_to" 
							name="virgo_search_lastFailedLogin_to" 
							size="20" 
							value="<?php echo $tmp_date ?>" 
						>
<script type="text/javascript">
$(function(){ 
  $("#virgo_search_lastFailedLogin_to").datepicker({dateFormat: "yy-mm-dd"});
});
</script>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_lastFailedLogin_is_null" 
				name="virgo_search_lastFailedLogin_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaLastFailedLogin) && $fieldCriteriaLastFailedLogin["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaLastFailedLogin) && $fieldCriteriaLastFailedLogin["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaLastFailedLogin) && $fieldCriteriaLastFailedLogin["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_last_logout', "1") == "1") {

		if (isset($criteriaUser["last_logout"])) {
			$fieldCriteriaLastLogout = $criteriaUser["last_logout"];
			$dataTypeCriteria = $fieldCriteriaLastLogout["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('LAST_LOGOUT') ?>
		</label>
		<span align="left" nowrap>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = isset($dataTypeCriteria["from"]) ? $dataTypeCriteria["from"] : "";
?>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_lastLogout_from" 
							name="virgo_search_lastLogout_from" 
							size="20" 
							value="<?php echo $tmp_date ?>" 
						>
<script type="text/javascript">
$(function(){ 
  $("#virgo_search_lastLogout_from").datepicker({dateFormat: "yy-mm-dd"});
});
</script>
						&nbsp;-&nbsp;
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = isset($dataTypeCriteria["to"]) ? $dataTypeCriteria["to"] : "";
?>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_lastLogout_to" 
							name="virgo_search_lastLogout_to" 
							size="20" 
							value="<?php echo $tmp_date ?>" 
						>
<script type="text/javascript">
$(function(){ 
  $("#virgo_search_lastLogout_to").datepicker({dateFormat: "yy-mm-dd"});
});
</script>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_lastLogout_is_null" 
				name="virgo_search_lastLogout_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaLastLogout) && $fieldCriteriaLastLogout["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaLastLogout) && $fieldCriteriaLastLogout["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaLastLogout) && $fieldCriteriaLastLogout["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_user_agent', "1") == "1") {

		if (isset($criteriaUser["user_agent"])) {
			$fieldCriteriaUserAgent = $criteriaUser["user_agent"];
			$dataTypeCriteria = $fieldCriteriaUserAgent["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('USER_AGENT') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_userAgent" 
							name="virgo_search_userAgent"
							style="border: yellow 1 solid;" 
							maxlength="255"
							size="50" 
							value="<?php echo isset($dataTypeCriteria["default"]) ? htmlentities($dataTypeCriteria["default"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_userAgent_is_null" 
				name="virgo_search_userAgent_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaUserAgent) && $fieldCriteriaUserAgent["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaUserAgent) && $fieldCriteriaUserAgent["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaUserAgent) && $fieldCriteriaUserAgent["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_token', "1") == "1") {

		if (isset($criteriaUser["token"])) {
			$fieldCriteriaToken = $criteriaUser["token"];
			$dataTypeCriteria = $fieldCriteriaToken["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('TOKEN') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_token" 
							name="virgo_search_token"
							style="border: yellow 1 solid;" 
							maxlength="255"
							size="50" 
							value="<?php echo isset($dataTypeCriteria["default"]) ? htmlentities($dataTypeCriteria["default"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_token_is_null" 
				name="virgo_search_token_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaToken) && $fieldCriteriaToken["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaToken) && $fieldCriteriaToken["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaToken) && $fieldCriteriaToken["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_unidentified', "1") == "1") {

		if (isset($criteriaUser["unidentified"])) {
			$fieldCriteriaUnidentified = $criteriaUser["unidentified"];
			$dataTypeCriteria = $fieldCriteriaUnidentified["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('UNIDENTIFIED') ?>
		</label>
		<span align="left" nowrap>
<select id="virgo_search_unidentified" name="virgo_search_unidentified">
	<option value="" <?php echo !isset($dataTypeCriteria) ? "selected='selected'" : "" ?>></option>
	<option value="1" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] === 0 ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_unidentified_is_null" 
				name="virgo_search_unidentified_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaUnidentified) && $fieldCriteriaUnidentified["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaUnidentified) && $fieldCriteriaUnidentified["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaUnidentified) && $fieldCriteriaUnidentified["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_confirmed', "1") == "1") {

		if (isset($criteriaUser["confirmed"])) {
			$fieldCriteriaConfirmed = $criteriaUser["confirmed"];
			$dataTypeCriteria = $fieldCriteriaConfirmed["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('CONFIRMED') ?>
		</label>
		<span align="left" nowrap>
<select id="virgo_search_confirmed" name="virgo_search_confirmed">
	<option value="" <?php echo !isset($dataTypeCriteria) ? "selected='selected'" : "" ?>></option>
	<option value="1" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] === 0 ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_confirmed_is_null" 
				name="virgo_search_confirmed_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaConfirmed) && $fieldCriteriaConfirmed["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaConfirmed) && $fieldCriteriaConfirmed["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaConfirmed) && $fieldCriteriaConfirmed["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_accepted', "1") == "1") {

		if (isset($criteriaUser["accepted"])) {
			$fieldCriteriaAccepted = $criteriaUser["accepted"];
			$dataTypeCriteria = $fieldCriteriaAccepted["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('ACCEPTED') ?>
		</label>
		<span align="left" nowrap>
<select id="virgo_search_accepted" name="virgo_search_accepted">
	<option value="" <?php echo !isset($dataTypeCriteria) ? "selected='selected'" : "" ?>></option>
	<option value="1" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] === 0 ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_accepted_is_null" 
				name="virgo_search_accepted_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaAccepted) && $fieldCriteriaAccepted["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaAccepted) && $fieldCriteriaAccepted["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaAccepted) && $fieldCriteriaAccepted["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	$context = null; //$session->get('GLOBAL-VIRGO_CONTEXT_usuniete');
?>	
<?php
	if (P('show_search_page', '1') == "1") {
		if (isset($criteriaUser["page"])) {
			$fieldCriteriaPage = $criteriaUser["page"];
		}
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
	
				<label align="right" nowrap class="fieldlabel"
					<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>				
				><?php echo T('PAGE') ?> <?php echo T('') ?></label>
<?php
	$value = isset($fieldCriteriaPage["value"]) ? $fieldCriteriaPage["value"] : null;
?>
    <input type="text" class="inputbox " id="virgo_search_page" name="virgo_search_page" value="<?php echo $value ?>">
</span>
<?php
	if (P('empty_values_search', '0') == "1") {
?>
					<span align="left" nowrap>
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_accepted_is_null" 
				name="virgo_search_accepted_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaPage) && $fieldCriteriaPage["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaPage) && $fieldCriteriaPage["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaPage) && $fieldCriteriaPage["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>						
					</span>
<?php
	}
?>
				</li>
<?php
	}
?>
<?php
	if (P('show_search_user_roles') == "1") {
		if (isset($criteriaUser["role"])) {
			$parentIds = $criteriaUser["role"];
		}
		if (isset($parentIds) && isset($parentIds['ids'])) {
			$selectedIds = $parentIds['ids'];
		}
?>
				<li
					style="vertical-align: top;
					<?php echo (!$formsInTable && $floatingFields) ? "display: inline-block; float: left;" : '' ?>
					"
				>
					<label align="right" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>				
					>Roles</label>
<?php
		$ids = virgoRole::selectAllAsIdsStatic();
		if (count($ids) < 50) {
			$idAndName = "virgo_search_role[]";
?>
					<select class="inputbox " multiple='multiple' id="<?php echo $idAndName ?>" name="<?php echo $idAndName ?>">
<?php
			foreach ($ids as $id) {
				$obj = new virgoRole($id['id']);
?>
					<option value="<?php echo $obj->getId() ?>"
<?php
						echo (isset($selectedIds) && is_array($selectedIds) && in_array($obj->getId(), $selectedIds) ? "selected='selected'" : "");
?>
					><?php echo $obj->getVirgoTitle() ?></option>
<?php
			}
?>
					</select>
<?php
		} else {
?>
			Too many rows: <?php echo count($ids) ?> 
<?php
		}
?>
				</li>
<?php
	}
?>
<?php
	if (P('show_search_system_messages') == "1") {
?>
<?php
	$record = new portal\virgoUser();
	$recordId = is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->usr_id;
	$record->load($recordId);
	$subrecordsSystemMessages = $record->getSystemMessages();
	$sizeSystemMessages = count($subrecordsSystemMessages);
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
					<label align="right" valign="top" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
					>
						System messages
					</label>
<?php
	if ($sizeSystemMessages == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsSystemMessages as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeSystemMessages) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
				</li>
<?php
	}
?>
<?php
	unset($criteriaUser);
?>
				</ul>
			</fieldset>
				<div class="buttons form-actions">
						<input type="text" name="usr_id_<?php echo $this->getId() ?>" id="usr_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

 <div class="button_wrapper button_wrapper_search inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Search';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('SEARCH') ?>"
						/><div class="button_right"></div></div> <div class="button_wrapper button_wrapper_clear inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Clear';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLEAR') ?>"
						/><div class="button_right"></div></div><?php						
	if (P('form_only', "0") != "2") {
?> <div class="button_wrapper button_wrapper_close inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Close';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>
				</div>
	</div>
<?php
/* MILESTONE 1.4 View */
	} elseif ($userDisplayMode == "VIEW") {
?>
	<div class="form_view">
<?php
	$editForm = P('view_form', "virgo_default");
	if (is_null($editForm) || trim($editForm) == "" || $editForm == "virgo_default") {
?>
			<fieldset class="form">
				<legend>
<?php echo T('USER') ?>:</legend>
<?php
	if (!$formsInTable) {
?>
				<ul>
<?php
	} else {
?>
				<dl class="dl-horizontal">
<?php
	}
?>
																																																						<?php
	if (P('show_view_username', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="username"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('USERNAME') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getUsername(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="username" name="usr_username_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getUsername(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_password', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="password"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('PASSWORD') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
<?php
	if (!is_null($resultUser->getPassword())) {
?>
		<?php echo T('PRESENT') ?>
<?php
	}
?>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_email', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="email"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('EMAIL') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
<?php
	$email = htmlentities($resultUser->getEmail(), ENT_QUOTES, "UTF-8");
?>
<a class="inputbox readonly" href="mailto:<?php echo $email ?>" target="_blank">
	<?php echo $email ?>
</a>

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_first_name', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="first_name"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('FIRST_NAME') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getFirstName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="firstName" name="usr_firstName_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getFirstName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_last_name', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="last_name"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('LAST_NAME') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getLastName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastName" name="usr_lastName_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getLastName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_session_id', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="session_id"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('SESSION_ID') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getSessionId(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="sessionId" name="usr_sessionId_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getSessionId(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_ip', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="ip"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('IP') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getIp(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="ip" name="usr_ip_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getIp(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_logged_in', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="logged_in"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('LOGGED_IN') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>


<span 
	class="inputbox readonly" 
	id="loggedIn"
>
<?php
	if (is_null($resultUser->getLoggedIn()) || $resultUser->getLoggedIn() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultUser->getLoggedIn() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultUser->getLoggedIn() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_last_successful_login', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="last_successful_login"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('LAST_SUCCESSFUL_LOGIN') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getLastSuccessfulLogin(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastSuccessfulLogin" name="usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getLastSuccessfulLogin(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_last_failed_login', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="last_failed_login"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('LAST_FAILED_LOGIN') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getLastFailedLogin(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastFailedLogin" name="usr_lastFailedLogin_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getLastFailedLogin(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_last_logout', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="last_logout"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('LAST_LOGOUT') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getLastLogout(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastLogout" name="usr_lastLogout_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getLastLogout(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_user_agent', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="user_agent"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('USER_AGENT') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getUserAgent(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="userAgent" name="usr_userAgent_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getUserAgent(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_token', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="token"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('TOKEN') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultUser->getToken(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="token" name="usr_token_<?php echo $resultUser->getId() ?>" value="<?php echo htmlentities($resultUser->getToken(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_unidentified', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="unidentified"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('UNIDENTIFIED') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>


<span 
	class="inputbox readonly" 
	id="unidentified"
>
<?php
	if (is_null($resultUser->getUnidentified()) || $resultUser->getUnidentified() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultUser->getUnidentified() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultUser->getUnidentified() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_confirmed', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="confirmed"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('CONFIRMED') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>


<span 
	class="inputbox readonly" 
	id="confirmed"
>
<?php
	if (is_null($resultUser->getConfirmed()) || $resultUser->getConfirmed() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultUser->getConfirmed() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultUser->getConfirmed() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_accepted', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="accepted"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('ACCEPTED') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>


<span 
	class="inputbox readonly" 
	id="accepted"
>
<?php
	if (is_null($resultUser->getAccepted()) || $resultUser->getAccepted() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultUser->getAccepted() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultUser->getAccepted() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPage') && P('show_view_page', '1') == "1") { // && (isset($masterComponentName) && $masterComponentName != "page" || is_null($contextId))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="page"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">Page </span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
<?php
			$tmpId = null;
			if (!is_null($context) && isset($context['pge_id'])) {
				$tmpId = $context['pge_id'];
			}
			$readOnly = "";
			if ($resultUser->getId() == 0) {
// przesuac do createforgui				$resultUser->usr_pge__id = $tmpId;
			}
			$parentId = $resultUser->getPageId();
			$parentValue = portal\virgoPage::lookup($parentId);
				
?>
					<input
						type="hidden"
						id="usr_page_<?php echo isset($resultUser->usr_id) ? $resultUser->usr_id : '' ?>" 
						name="usr_page_<?php echo isset($resultUser->usr_id) ? $resultUser->usr_id : '' ?>" 						
						value="<?php echo $parentId ?>"
					/>
					<span class="inputbox readonly"><?php echo $parentValue ?></span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoUserRole') && P('show_view_user_roles', '0') == "1") {
?>
<?php
	$record = new portal\virgoUser();
	$recordId = is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->usr_id;
	$record->load($recordId);
	$subrecordsUserRoles = $record->getUserRoles();
	$sizeUserRoles = count($subrecordsUserRoles);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="user"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
						User roles 
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span class="inputbox readonly">
<?php
	if ($sizeUserRoles == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsUserRoles as $subrecord) {
			$subrecordIndex++;
			$parentRole = new portal\virgoRole($subrecord->getRleId());
			echo htmlentities($parentRole->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeUserRoles) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoSystemMessage') && P('show_view_system_messages', '0') == "1") {
?>
<?php
	$record = new portal\virgoUser();
	$recordId = is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->usr_id;
	$record->load($recordId);
	$subrecordsSystemMessages = $record->getSystemMessages();
	$sizeSystemMessages = count($subrecordsSystemMessages);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="user"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
						System messages 
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span class="inputbox readonly">
<?php
	if ($sizeSystemMessages == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsSystemMessages as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeSystemMessages) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	}
?>

<?php
	if (!$formsInTable) {
?>
				</ul>
<?php
	} else {
?>
				</dl>
<?php
	}
?>
			</fieldset>
<?php
	} elseif ($editForm == "virgo_entity") {
?>
			<fieldset class="form">
				<legend>
<?php echo T('USER') ?>:</legend>
				<ul>
				</ul>
			</fieldset>
<?php
	}
?>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultUser->getDateCreated()) {
		if ($resultUser->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultUser->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultUser->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultUser->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultUser->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultUser->getDateModified()) {
		if ($resultUser->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultUser->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultUser->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultUser->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultUser->getDateModified() ?>"	>
				</li>
<?php
	}
	if ($showFieldset == 1) {
?>
		</ul>
</fieldset>
<?php
	}
}
?>

				<div class="buttons form-actions">
						<input type="text" name="usr_id_<?php echo $this->getId() ?>" id="usr_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

<?php
			if ($this->canExecute("form")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Form')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_form inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Form';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('EDIT') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
?>
<?php
			}
?>
<?php
			if ($this->canExecute("delete")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Delete')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_delete inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("USER"), "\\'".$resultUser->getVirgoTitle()."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DELETE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
?>
<?php						
	if (P('form_only') != "1" && P('form_only') != "7") {
?>
 <div class="button_wrapper button_wrapper_close inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Close';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>

				</div>
	</div>
<?php
/* MILESTONE 1.5 Table */
	} elseif ($userDisplayMode == "TABLE") {
PROFILE('TABLE');
		if (P('form_only') == "3") {
?>
<?php
	$selectedMonth = $this->getPortletSessionValue('selected_month', date("m"));
	$selectedYear = $this->getPortletSessionValue('selected_year', date("Y"));

	$tmpDay = getdate(mktime(0, 0, 0, $selectedMonth, 1, $selectedYear));
	$firstDay = $tmpDay;
	$lastDay = getdate(strtotime($tmpDay["year"] . "-" .  (((int)$tmpDay["mon"])+1) . "-" . (((int)$tmpDay["mday"])-1)));
	$eventColumn = "usr_" . P('event_column');

	$resultCount = -1;
	$filterApplied = false;
	$resultUser->setShowPage(1); 
	$resultUser->setShowRows('all'); 	
	$resultsUser = $resultUser->getTableData($resultCount, $filterApplied);
	$events = array();
	foreach ($resultsUser as $resultUser) {
		if (isset($resultUser[$eventColumn]) && isset($events[substr($resultUser[$eventColumn], 0, 10)])) {
			$eventsInDay = $events[substr($resultUser[$eventColumn], 0, 10)];
		} else {
			$eventsInDay = array();
		}
		$eventObject = new virgoUser($resultUser['usr_id']);
		$eventsInDay[] = $eventObject;
		$events[substr($resultUser[$eventColumn], 0, 10)] = $eventsInDay;
	}
?>
<style type="text/css">
table.virgo_calendar_month {
	margin: 10px;
}

tr.virgo_calendar_week {
}

td.virgo_calendar_day, td.virgo_calendar_day:hover {
	border:1px solid #CCCCCC;
	font-size:20px;
	height:120px;
	padding:5px 0px;
	text-align:center;
	vertical-align:top;
	width:150px;
	color: black;
}

td.virgo_calendar_header {
	font-size:22px;
	padding: 0px 0px 10px 0px;
}

td.virgo_calendar_day {
	background-color: #FFFFFF;
}

td.virgo_calendar_day:hover {
	background-color: #FFFACD;
}

td.virgo_calendar_sunday:hover {
	background-color: #FFFACD;
	color: red !important;
}

td.virgo_calendar_day_empty {
	background: inherit;
	border: none;
}

td.virgo_calendar_sunday, td.virgo_calendar_holiday {
	color: red !important;
}
td.virgo_calendar_holiday div.holiday_name {
	font-size: 10px;
}

span.virgo_calendar_event, span.virgo_calendar_event:hover {
	font-size: 9px;
	cursor: pointer;
}

span.virgo_calendar_event_action, span.virgo_calendar_event_action:hover {
	border:1px dotted #999999;
	color:#999999;
	cursor:pointer;
	font-size:7px;
	margin:0 1px;
	padding:0 1px;
}

span.virgo_calendar_event:hover, span.virgo_calendar_event_action:hover {
	color: blue;
}

div.virgo_calendar_day_number {
}

td.virgo_calendar_weekday {
}

td.virgo_calendar_sunday {
	color: red;
}

td.virgo_calendar_today {
	background-color: #FFEEEE;
	border: 2px solid red;
}
td.virgo_calendar_today:hover {
	border: 2px solid grey;
}
td.virgo_calendar_day input.btn {
  background-color: khaki;
  background-image: none;
  border: medium none;
  border-radius: 0 0 0 0;
  color: blue;
  text-shadow: none;
  display: block !important;
  font-family: Comic Sans MS;
  font-size: 10px;
  line-height: 10px;
  margin-top: 1px;
  padding: 3px;
  width: 100%;
}
td.virgo_calendar_day div.inlineBlock {
  display: block !important;
}
td.virgo_calendar_day {
  cursor: default !important;
}
td.virgo_calendar_day div.virgo_calendar_day_number input.btn {
  display: inline;
  width: inherit;
  background-color: transparent;
  font-size: 20px;
  color: inherit;
  font-family: inherit;
  margin: auto;
  padding: 0px;
  box-shadow: none;
}
td.virgo_calendar_day div {
  text-align: center;
}
</style>
		<input
			type="hidden"
			id="<?php echo $eventColumn ?>_0" 
			name="<?php echo $eventColumn ?>_0"
			value=""
		>
		<table class='virgo_calendar_month' cellspacing="0" cellpadding="0">
			<tr>
<?php
	$tmpMonthDateTime = strtotime($selectedYear . "-" . $selectedMonth . "-01");
	$tmpMonthDateString = strftime("%B", $tmpMonthDateTime);
?>
				<td colspan="7" align="center" class='virgo_calendar_header'><?php echo $tmpMonthDateString . " " . $selectedYear?></td>
			<tr>
			<tr class='virgo_calendar_weekdays'>
<?php
	$tmpMonthDateTime = strtotime("2010-07-26");
	for ($weekDay = 0; $weekDay <7; $weekDay++) {
		$tmpWeekDateString = strftime("%A", $tmpMonthDateTime + $weekDay * 24 * 60 * 60);
?>
				<td align="center" class='virgo_calendar_weekday <?php echo $weekDay == 6 ? "virgo_calendar_sunday" : "" ?>'><?php echo $tmpWeekDateString ?></td>
<?php
	}
?>			
			</tr>
			<tr class='virgo_calendar_week'>
				<input type='hidden' name='virgo_selected_day' value=''/>
				<input type='hidden' name='usr_id_<?php echo $this->getId() ?>' value=''/>
<?php
	$tmpWeekDay = 1;
	$safety = 0;
	if ($tmpDay["wday"] > 0) {
		while ($tmpWeekDay != ((int)$tmpDay["wday"]) && $safety < 8) {
			echo "<td class='virgo_calendar_day_empty'></td>";
			$tmpWeekDay = $tmpWeekDay + 1;
			$safety = $safety + 1;
		}
	} else {
		for ($tmp=0; $tmp<6;$tmp++) {
			echo "<td class='virgo_calendar_day_empty'></td>";
		}
	}
	$safety = 0;
	while (((int)$tmpDay["mon"]) == ((int)$selectedMonth) && $safety < 31) {
		$tmpStringDay = $tmpDay["year"] . "-" . (str_pad($tmpDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($tmpDay["mday"], 2, "0", STR_PAD_LEFT));
		echo "<td class='virgo_calendar_day " . (((int)$tmpDay["wday"]) == 0 ? "virgo_calendar_sunday" : "") . " " . ($tmpStringDay == date("Y-m-d") ? "virgo_calendar_today" : "") . "'>";
		echo "<div class='virgo_calendar_day_number' >";		
		if ($this->canExecute("Add")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Add')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_add inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Add';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');
this.form.virgo_selected_day.value='<?php echo $tmpStringDay ?>';
 								form.target = '';
							" 
							value="<?php echo T($tmpDay['mday']) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
		} else {
		echo $tmpDay["mday"];			
		}
		echo "</div>";
		if (isset($events[$tmpStringDay])) {
			$eventsInDay = $events[$tmpStringDay];
			foreach ($eventsInDay as $resultUser) {
?>
<?php
PROFILE('token');
	if (isset($resultUser)) {
		$tmpId = is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('View')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_view inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='View';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($resultUser->getVirgoTitle()) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php				
//				echo "<span class='virgo_calendar_event' onclick='var form=document.getElementById(\"portlet_form_".$this->getId()."\");form.portlet_action.value=\"View\";form.usr_id_".$this->getId().".value=\"".$eventInDay->getId()."\";form.submit();'>" . $eventInDay->getVirgoTitle() . "</span>";
			}
		}
		echo "</td>";
		if (((int)$tmpDay["wday"]) == 0) {
			echo "</tr><tr class='virgo_calendar_week'>";
		}
		$tmpDay = getdate(strtotime($tmpDay["year"] . "-" .  $tmpDay["mon"] . "-" . (((int)$tmpDay["mday"])+1)));
		$safety = $safety + 1;
	}
?>
			</tr>
			<tr class="data_table_header">
								<td nowrap="nowrap" width="100%" align="center" colspan="7">
									<?php AB('PreviousYear', '&lArr;') ?>
									<?php AB('PreviousMonth', '&larr;') ?>
									<?php AB('CurrentMonth', T('CURRENT_MONTH')) ?>
									<select name="virgo_cal_selected_month" onChange="this.form.portlet_action.value='SetMonth';<?php echo JSFS() ?>" class="inputbox">
<?php
	for ($month = 1; $month <13; $month++) {
		$tmpMonthDateTime = strtotime("1970-" . $month . "-01");
		$tmpMonthDateString = strftime("%B", $tmpMonthDateTime);
?>
										<option value="<?php echo $month ?>" <?php echo $month == $selectedMonth ? "selected='selected'" : "" ?>><?php echo $tmpMonthDateString ?></option>
<?php
	}
?>
									</select>
									<select name="virgo_cal_selected_year" onChange="this.form.portlet_action.value='SetYear';<?php echo JSFS() ?>" class="inputbox">
<?php
	/* 
		The last date/time that is working on 32-Bit machines:
		19.01.2038 03:14:07 ( =2147480047 )
	*/
	for ($tmpYear = 1970; $tmpYear < 2037; $tmpYear++) {
?>
										<option value="<?php echo $tmpYear ?>" <?php echo $tmpYear == $selectedYear ? "selected='selected'" : "" ?>><?php echo $tmpYear ?></option>
<?php
	}
?>
									</select>
									<?php AB('NextMonth', '&rarr;') ?>
									<?php AB('NextYear', '&rArr;') ?>
								</td>
			</tr>
		</table>
<?php
?>
<?php
		} else {
?>
<?php
PROFILE('table_01');
?>
		<script type="text/javascript">
			var userChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == userChildrenDivOpen) {
					div.style.display = 'none';
					userChildrenDivOpen = '';
				} else {
					if (userChildrenDivOpen != '') {
						document.getElementById(userChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					userChildrenDivOpen = clickedDivId;
				}
			}
			
			function copyIds(form, pobId) {
				var chcks = document.getElementsByTagName("input");
				var ids = form.ids;
				ids.value = '';
				var firstOne = 1;
				for (i=0;i<chcks.length;i++) {
					if (isOurCheckbox(chcks[i].name, pobId)) {
						if (chcks[i].checked == 1) {
							if (firstOne == 1) {
								firstOne = 0;
							} else {
								ids.value = ids.value + ",";
							}
							ids.value = ids.value + chcks[i].name.substring(chcks[i].name.lastIndexOf("_")+1);
						}
					}
				}
			}
			
			function isOurCheckbox(name, pobId) {
				return name.match("^DELETE_" + pobId + "_\d*");
			}
			
			function nothingSelected(form, pobId) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (isOurCheckbox(chcks[i].name, pobId)) {
						if (chcks[i].checked == 1) {
							return false;
						}
					}
				}
				return true;
			}
			
			function checkAll(value, pobId) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (isOurCheckbox(chcks[i].name, pobId)) {
						chcks[i].checked = value;
					}
				}
			}
			
			if (typeof portletCurrentTab === 'undefined') {
				var portletCurrentTab = new Array();
				function showOperations(tab, pobId) {
					var div = document.getElementById("operations_" + portletCurrentTab[pobId] + "_" + pobId);
					var span = document.getElementById("control_" + portletCurrentTab[pobId] + "_" + pobId);
					div.style.display = 'none';
					span.className = 'operations_tab';
					portletCurrentTab[pobId] = tab;
					div = document.getElementById("operations_" + portletCurrentTab[pobId] + "_" + pobId);
					span = document.getElementById("control_" + portletCurrentTab[pobId] + "_" + pobId);
					div.style.display = 'block';
					span.className = 'operations_tab_current';
				}
				function changeDisplay(id) {
					var div = document.getElementById(id);
					div.style.display = div.style.display == "none" ? "inline-block" : "none";
				}
			}
			portletCurrentTab[<?php echo $this->getId() ?>] = "basic";
			
		</script>
<?php		
PROFILE('table_01');
PROFILE('table_02');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoRole'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoRole'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoLogLevel'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoLogLevel'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'controller.php');
			$showPage = $resultUser->getShowPage(); 
			$showRows = $resultUser->getShowRows(); 
?>
						<input type="text" name="usr_id_<?php echo $this->getId() ?>" id="usr_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

		<input type="hidden" name="virgo_parent_id" id="virgo_parent_id"/>
<?php
			$actionOnRowClick = P('action_on_row_click', 'Select');
			if ($actionOnRowClick == "Custom") {
				$actionOnRowClick = P('action_on_row_click_custom', 'Select');
			}
			$actionOnRowDoubleClick = P('action_on_row_double_click', 'View');
			if ($actionOnRowDoubleClick == "Custom") {
				$actionOnRowDoubleClick = P('action_on_row_click_custom', 'View');
			}
			$hint = TE('HINT_USER');
			if (isset($hint)) {
?>
				<p><br/><?php echo $hint ?><br/><br/></p>
<?php
			}

?>
<?php echo P('master_mode', "0") == "1" ? "<div class='well sidebar-nav'>" : "" ?>
		<table class="data_table table table-striped table-hover table-condensed <?php echo P('form_only') == "4" ? "chessboard" : "" ?> <?php echo P('master_mode', "0") == "1" ? "nav nav-list" : "" ?>" cellpadding="0" cellspacing="<?php echo P('form_only') == "4"  ? "5" : "0" ?>" border="0">
<?php
			if (P('master_mode', "0") == "1") {
?>			
				<tr><td colspan="99" class="nav-header"><?php echo T('Users') ?></td></tr>
<?php
			}
?>			
<?php
PROFILE('table_02');
PROFILE('main select');
			$virgoOrderColumn = $resultUser->getOrderColumn();
			$virgoOrderMode = $resultUser->getOrderMode();
			$resultCount = -1;
			$filterApplied = false;
			$resultsUser = $resultUser->getTableData($resultCount, $filterApplied);
PROFILE('main select');
PROFILE('table_03');

			if (P('form_only') != "4") {
?>		
			<tr class="data_table_header">
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
			if ($this->canExecute("delete")) {
?>
			<th rowspan="2">
			</th>
<?php
			}
?>
																																																						<?php
	if (!isset($parentsInContext)) {
		$parentsInContext = array();
		$parentPobIds = PN('parent_entity_pob_id');
		foreach ($parentPobIds as $parentPobId) {
			$portletObject = new portal\virgoPortletObject($parentPobId);
			$className = $portletObject->getPortletDefinition()->getNamespace().'\\'.$portletObject->getPortletDefinition()->getAlias();
			$tmp2Id = $className::getRemoteContextId($parentPobId);
			if (isset($tmp2Id)) {
				$parentsInContext[$className] = $tmp2Id;
			}
		}
	}
?>
<?php
	if (P('show_table_username', "1") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultUser->getOrderColumn(); 
	$om = $resultUser->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'usr_username');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('USERNAME') ?>							<?php echo ($oc == "usr_username" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoUser::getLocalSessionValue('VirgoFilterUsername', null);
?>
						<input
							name="virgo_filter_username"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_password', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultUser->getOrderColumn(); 
	$om = $resultUser->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'usr_password');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('PASSWORD') ?>							<?php echo ($oc == "usr_password" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoUser::getLocalSessionValue('VirgoFilterPassword', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_email', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultUser->getOrderColumn(); 
	$om = $resultUser->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'usr_email');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('EMAIL') ?>							<?php echo ($oc == "usr_email" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoUser::getLocalSessionValue('VirgoFilterEmail', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_first_name', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultUser->getOrderColumn(); 
	$om = $resultUser->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'usr_first_name');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('FIRST_NAME') ?>							<?php echo ($oc == "usr_first_name" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoUser::getLocalSessionValue('VirgoFilterFirstName', null);
?>
						<input
							name="virgo_filter_first_name"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_last_name', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultUser->getOrderColumn(); 
	$om = $resultUser->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'usr_last_name');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('LAST_NAME') ?>							<?php echo ($oc == "usr_last_name" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoUser::getLocalSessionValue('VirgoFilterLastName', null);
?>
						<input
							name="virgo_filter_last_name"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_session_id', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultUser->getOrderColumn(); 
	$om = $resultUser->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'usr_session_id');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('SESSION_ID') ?>							<?php echo ($oc == "usr_session_id" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoUser::getLocalSessionValue('VirgoFilterSessionId', null);
?>
						<input
							name="virgo_filter_session_id"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_ip', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultUser->getOrderColumn(); 
	$om = $resultUser->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'usr_ip');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('IP') ?>							<?php echo ($oc == "usr_ip" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoUser::getLocalSessionValue('VirgoFilterIp', null);
?>
						<input
							name="virgo_filter_ip"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_logged_in', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultUser->getOrderColumn(); 
	$om = $resultUser->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'usr_logged_in');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('LOGGED_IN') ?>							<?php echo ($oc == "usr_logged_in" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoUser::getLocalSessionValue('VirgoFilterLoggedIn', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_last_successful_login', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultUser->getOrderColumn(); 
	$om = $resultUser->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'usr_last_successful_login');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('LAST_SUCCESSFUL_LOGIN') ?>							<?php echo ($oc == "usr_last_successful_login" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoUser::getLocalSessionValue('VirgoFilterLastSuccessfulLogin', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_last_failed_login', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultUser->getOrderColumn(); 
	$om = $resultUser->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'usr_last_failed_login');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('LAST_FAILED_LOGIN') ?>							<?php echo ($oc == "usr_last_failed_login" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoUser::getLocalSessionValue('VirgoFilterLastFailedLogin', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_last_logout', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultUser->getOrderColumn(); 
	$om = $resultUser->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'usr_last_logout');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('LAST_LOGOUT') ?>							<?php echo ($oc == "usr_last_logout" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoUser::getLocalSessionValue('VirgoFilterLastLogout', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_user_agent', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultUser->getOrderColumn(); 
	$om = $resultUser->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'usr_user_agent');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('USER_AGENT') ?>							<?php echo ($oc == "usr_user_agent" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoUser::getLocalSessionValue('VirgoFilterUserAgent', null);
?>
						<input
							name="virgo_filter_user_agent"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_token', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultUser->getOrderColumn(); 
	$om = $resultUser->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'usr_token');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('TOKEN') ?>							<?php echo ($oc == "usr_token" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoUser::getLocalSessionValue('VirgoFilterToken', null);
?>
						<input
							name="virgo_filter_token"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_unidentified', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultUser->getOrderColumn(); 
	$om = $resultUser->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'usr_unidentified');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('UNIDENTIFIED') ?>							<?php echo ($oc == "usr_unidentified" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoUser::getLocalSessionValue('VirgoFilterUnidentified', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_confirmed', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultUser->getOrderColumn(); 
	$om = $resultUser->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'usr_confirmed');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('CONFIRMED') ?>							<?php echo ($oc == "usr_confirmed" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoUser::getLocalSessionValue('VirgoFilterConfirmed', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_accepted', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultUser->getOrderColumn(); 
	$om = $resultUser->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'usr_accepted');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('ACCEPTED') ?>							<?php echo ($oc == "usr_accepted" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoUser::getLocalSessionValue('VirgoFilterAccepted', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php') && P('show_table_page', "1") != "0"  && !isset($parentsInContext['portal\\virgoPage'])  ) {
	if (P('show_table_page', "1") == "2") {
		$tmpLookupPage = virgoPage::getVirgoListStatic();
?>
<input name='usr_Page_id_<?php echo $this->getId() ?>' id='usr_Page_id_<?php echo $this->getId() ?>' type="hidden"/>
<?php		
	}
?>
				<th align="center" valign="middle" rowspan=" 2"><!-- bylo: nowrap -->
<?php
	$oc = $resultUser->getOrderColumn(); 
	$om = $resultUser->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder';
	_pSF(form, 'virgo_order_column', 'page');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('PAGE') ?>&nbsp;
<?php echo T('') ?>							<?php echo ($oc == "page" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$parentsCount = virgoPage::getVirgoListStatic('', true);
		if ($parentsCount < 51) {
			$parents = virgoPage::getVirgoListStatic();
			$parentFilter = virgoUser::getLocalSessionValue('VirgoFilterPage', null);
?>
						<select 
							name="virgo_filter_page"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
						>
							<option value=""></option>
							<option value="empty" <?php echo $parentFilter == "empty" ? " selected='selected' " : "" ?>>(empty)</option>
<?php
			foreach ($parents as $key => $value) {
?>							
							<option value="<?php echo $key ?>" <?php echo $parentFilter == $key ? " selected='selected' " : "" ?>><?php echo $value ?></option>
<?php
			}
?>							
						</select>
<?php		
		} else {
			$parentFilter = virgoUser::getLocalSessionValue('VirgoFilterTitlePage', null);
?>
						<input
							name="virgo_filter_title_page"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $parentFilter ?>"
						/>
<?php			
		}
	}
?>

				</th>
			
<?php
	}
?>
<?php
	if (class_exists('portal\virgoUserRole') && P('show_table_user_roles', '0') == "1") {
?>
				<th align="center" valign="middle" rowspan=" 2"><!-- bylo: nowrap -->
						<span style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('USER') ?>&nbsp;
<?php echo T('') ?>							<?php echo ($oc == "user" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
				</th>			
<?php
	}
?>
<?php
	if (class_exists('portal\virgoSystemMessage') && P('show_table_system_messages', '0') == "1") {
?>
<?php
	}
?>
				<th rowspan="2"></th>
			</tr>
			<tr class="data_table_header">
																																																																				
			</tr>

<?php
			}
			if ($resultCount != 0) {
				if (((int)$showRows) * (((int)$showPage)-1) == $resultCount ) {
					$showPage = ((int)$showPage)-1;
					$resultUser->setShowPage($showPage);
				}
				$index = 0;
PROFILE('table_04');
PROFILE('rows rendering');
				$contextRowIdInTable = null;
				$firstRowId = null;
				foreach ($resultsUser as $resultUser) {
					$index = $index + 1;
?>
<?php
$fileNameToInclude = PORTAL_PATH . "/portlets/portal/virgoUser/modules/renderTableRow_{$_SESSION['current_portlet_object_id']}.php";
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
	$fileNameToInclude = PORTAL_PATH . "/portlets/portal/modules/renderTableRow.php";
} 
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
?>
<?php
			if (P('form_only') != "4" || (P('chessboard_width') != 0 && $index % P('chessboard_width') == 1)) {
				if (is_null($firstRowId)) {
					$firstRowId = $resultUser['usr_id'];
				}
				$displayClass = ' displayClass ';
				$tmpContextId = virgoUser::getContextId();
				if (is_null($tmpContextId)) {
					$forceContextOnFirstRow = P('force_context_on_first_row', "1");
					if ($forceContextOnFirstRow == "1") {
						virgoUser::setContextId($resultUser['usr_id'], false);
						$tmpContextId = $resultUser['usr_id'];
					}
				}
				if (isset($tmpContextId) && $resultUser['usr_id'] == $tmpContextId) {
					if (P('form_only') != "4") {
						$contextClass = ' contextClass ';
					} else {
						$contextClass = '';
					}
					$contextRowIdInTable = $tmpContextId;
				} else {
					$contextClass = '';
				}
?>
			<tr 
				id="<?php echo $this->getId() ?>_<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : "" ?>" 
				class="<?php echo (P('form_only') == "4" ? "data_table_chessboard" : ($index % 2 == 0 ? "data_table_even" : "data_table_odd")) ?> <?php echo $contextClass ?>
 <? echo $displayClass ?> 
			" 
			>
<?php
			} 
?>
<?php
			if (P('form_only') == "4") {
				$width = P('chessboard_cell_width');
				$height = P('chessboard_cell_height');
				if ($width != "0") {
					$styleWidth = " width: " . $width . "px; ";
				}
				if ($height != "0") {
					$styleHeight = " height: " . $height . "px; ";
				}
				$style = "";
				if (!is_null($styleWidth) || !is_null($styleHeight)) {
					$style = " style='" . $styleWidth . $styleHeight . "' ";
				}
?>
				<td 
					class="chessboard" 
					valign="top" 
					<?php echo $style ?>
				>
<?php
			if (P('form_only') == "4") {
?>
					<ul> 
<?php
			}
?>
<?php
$showSelectAll = FALSE;
			if ($this->canExecute("delete")) {
$showSelectAll = TRUE;
?>
<?php
			if (P('form_only') != "4") {
?>
			<td>
<?php
			} else {
?>
			<li>
<?php
			}
?>
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultUser['usr_id'] ?>">
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>
<?php
			}
?>
<?php
if (! $showSelectAll) {
			if ($this->canExecute("delete")) {
?>
<?php
			if (P('form_only') != "4") {
?>
			<td>
<?php
			} else {
?>
			<li>
<?php
			}
?>
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultUser['usr_id'] ?>">
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>
<?php
			}
}
?>
<?php
PROFILE('username');
	if (P('show_table_username', "1") == "1") {
PROFILE('render_data_table_username');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="username">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_username'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_username');
	}
PROFILE('username');
?>
<?php
PROFILE('password');
	if (P('show_table_password', "0") == "1") {
PROFILE('render_data_table_password');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="password">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_password'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_password');
	}
PROFILE('password');
?>
<?php
PROFILE('email');
	if (P('show_table_email', "0") == "1") {
PROFILE('render_data_table_email');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="email">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php
		$email = htmlentities($resultUser['usr_email'], ENT_QUOTES, "UTF-8");
?>
		<a href="mailto:<?php echo $email ?>" target="_blank">
			<?php echo $email ?>
		</a>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_email');
	}
PROFILE('email');
?>
<?php
PROFILE('first name');
	if (P('show_table_first_name', "0") == "1") {
PROFILE('render_data_table_first_name');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="first_name">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_first_name'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_first_name');
	}
PROFILE('first name');
?>
<?php
PROFILE('last name');
	if (P('show_table_last_name', "0") == "1") {
PROFILE('render_data_table_last_name');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="last_name">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_last_name'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_last_name');
	}
PROFILE('last name');
?>
<?php
PROFILE('session id');
	if (P('show_table_session_id', "0") == "1") {
PROFILE('render_data_table_session_id');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="session_id">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_session_id'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_session_id');
	}
PROFILE('session id');
?>
<?php
PROFILE('ip');
	if (P('show_table_ip', "0") == "1") {
PROFILE('render_data_table_ip');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="ip">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_ip'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_ip');
	}
PROFILE('ip');
?>
<?php
PROFILE('logged in');
	if (P('show_table_logged_in', "0") == "1") {
PROFILE('render_data_table_logged_in');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="logged_in">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php
	$canEditBoolean = ($this->canEdit() && P('show_form_logged_in', "1") == "1");
	if ($resultUser['usr_logged_in'] == 2 || is_null($resultUser['usr_logged_in'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_logged_in_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo is_null($resultUser['usr_logged_in']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_logged_in_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetLoggedInTrue';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetLoggedInFalse';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultUser['usr_logged_in'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_logged_in_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_logged_in_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetLoggedInFalse';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultUser['usr_logged_in'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_logged_in_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_logged_in_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetLoggedInTrue';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_logged_in');
	}
PROFILE('logged in');
?>
<?php
PROFILE('last successful login');
	if (P('show_table_last_successful_login', "0") == "1") {
PROFILE('render_data_table_last_successful_login');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="last_successful_login">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_last_successful_login'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_last_successful_login');
	}
PROFILE('last successful login');
?>
<?php
PROFILE('last failed login');
	if (P('show_table_last_failed_login', "0") == "1") {
PROFILE('render_data_table_last_failed_login');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="last_failed_login">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_last_failed_login'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_last_failed_login');
	}
PROFILE('last failed login');
?>
<?php
PROFILE('last logout');
	if (P('show_table_last_logout', "0") == "1") {
PROFILE('render_data_table_last_logout');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="last_logout">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_last_logout'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_last_logout');
	}
PROFILE('last logout');
?>
<?php
PROFILE('user agent');
	if (P('show_table_user_agent', "0") == "1") {
PROFILE('render_data_table_user_agent');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="user_agent">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_user_agent'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_user_agent');
	}
PROFILE('user agent');
?>
<?php
PROFILE('token');
	if (P('show_table_token', "0") == "1") {
PROFILE('render_data_table_token');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="token">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_token'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_token');
	}
PROFILE('token');
?>
<?php
PROFILE('unidentified');
	if (P('show_table_unidentified', "0") == "1") {
PROFILE('render_data_table_unidentified');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="unidentified">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php
	$canEditBoolean = ($this->canEdit() && P('show_form_unidentified', "1") == "1");
	if ($resultUser['usr_unidentified'] == 2 || is_null($resultUser['usr_unidentified'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_unidentified_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo is_null($resultUser['usr_unidentified']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_unidentified_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetUnidentifiedTrue';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetUnidentifiedFalse';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultUser['usr_unidentified'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_unidentified_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_unidentified_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetUnidentifiedFalse';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultUser['usr_unidentified'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_unidentified_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_unidentified_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetUnidentifiedTrue';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_unidentified');
	}
PROFILE('unidentified');
?>
<?php
PROFILE('confirmed');
	if (P('show_table_confirmed', "0") == "1") {
PROFILE('render_data_table_confirmed');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="confirmed">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php
	$canEditBoolean = ($this->canEdit() && P('show_form_confirmed', "1") == "1");
	if ($resultUser['usr_confirmed'] == 2 || is_null($resultUser['usr_confirmed'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_confirmed_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo is_null($resultUser['usr_confirmed']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_confirmed_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetConfirmedTrue';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetConfirmedFalse';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultUser['usr_confirmed'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_confirmed_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_confirmed_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetConfirmedFalse';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultUser['usr_confirmed'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_confirmed_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_confirmed_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetConfirmedTrue';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_confirmed');
	}
PROFILE('confirmed');
?>
<?php
PROFILE('accepted');
	if (P('show_table_accepted', "0") == "1") {
PROFILE('render_data_table_accepted');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="accepted">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php
	$canEditBoolean = ($this->canEdit() && P('show_form_accepted', "1") == "1");
	if ($resultUser['usr_accepted'] == 2 || is_null($resultUser['usr_accepted'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_accepted_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo is_null($resultUser['usr_accepted']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_accepted_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetAcceptedTrue';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetAcceptedFalse';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultUser['usr_accepted'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_accepted_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_accepted_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetAcceptedFalse';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultUser['usr_accepted'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_accepted_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_accepted_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetAcceptedTrue';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_accepted');
	}
PROFILE('accepted');
?>
<?php
	if (class_exists('portal\virgoPage') && P('show_table_page', "1") != "0"  && !isset($parentsInContext["portal\\virgoPage"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_page', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="page">
<?php
			} 
?>
    <span 
    	class="<?php echo $displayClass ?>"
    >
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php 
	if (P('show_table_page', "1") == "1") {
		if (isset($resultUser['page'])) {
			echo $resultUser['page'];
		}
	} else {
//		echo $resultUser['usr_pge_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetPage';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
	_pSF(form, 'usr_Page_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
		">
			<option></option>
<?php
		foreach ($tmpLookupPage as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultUser['usr_pge_id'] ? " selected " : "" ?>><?php echo $label ?></option>
<?php			
		}
?>
		</select>
<?php
	}
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
    </span>
<?php
			if (P('form_only') != "4") {
?>
				</td>    
<?php
			} else {
?>
				</li>    
<?php
			}
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoUserRole') && P('show_table_user_roles', '0') == "1") {
?>
<td>
<?php
	$record = new portal\virgoUser();
	$recordId = is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->usr_id;
	$record->load($recordId);
	$subrecordsUserRoles = $record->getUserRoles();
	$sizeUserRoles = count($subrecordsUserRoles);
?>
<?php
	if ($sizeUserRoles == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsUserRoles as $subrecord) {
			$subrecordIndex++;
			$parentRole = new portal\virgoRole($subrecord->getRleId());
			echo htmlentities($parentRole->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeUserRoles) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
</td>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoSystemMessage') && P('show_table_system_messages', '0') == "1") {
?>
<?php
	}
?>
<?php
PROFILE('extra data');
?>
<?php
PROFILE('extra data');
?>
<?php
			if (P('form_only') != "4") {
?>
				<td nowrap class="actions" align="left">
<?php
			} else {
?>
				<li>
<?php
			}
?>

<?php
PROFILE('token');
	if (isset($resultUser)) {
		$tmpId = is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
?>
<?php
	if (P('master_mode', "0") == "0") {
			if ($this->canExecute("view")) {
?>
<?php						
		if (P('show_details_method') != "1") {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('View')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_view inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='View';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('VIEW') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
		}
?>
<?php
			}
		if ($this->canEdit()) {
?>
<?php
			if ($this->canExecute("form")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Form')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_form inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Form';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('EDIT') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
?>
<?php
			}
?>
<?php
			if ($this->canExecute("delete")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Delete')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_delete inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("USER"), "\\'".rawurlencode($resultUser['usr_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DELETE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
?>
<?php 
		} 	} 
		if ($this->canEdit()) {
?>
<?php
	if (P('enable_record_duplication', "0") == "1") {
			if ($this->canExecute("add")) {
?> <div class="button_wrapper button_wrapper_duplicate inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Duplicate';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DUPLICATE') ?>"
						/><div class="button_right"></div></div><?php			
	}
?>
<?php
			}
?>
<?php
			$actions = virgoRole::getExtraActions('ER');
			foreach ($actions as $action) {
?>

<?php
	$buttonRendered = false;
	if ($this->canExecute($action)) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_<?php echo $action ?> inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='<?php echo $action ?>';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($action) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php						
			}
		} ?>
<?php
			if (P('form_only') != "4") {
?>
				</td>
<?php
			} else {
?>
				</li>
<?php
			}
?>
<?php
			if (P('form_only') == "4") {
?>
					</ul> 
<?php
			}
?>

				</td>
<?php
			} else {
?>
<?php
			if (P('form_only') == "4") {
?>
					<ul> 
<?php
			}
?>
<?php
$showSelectAll = FALSE;
			if ($this->canExecute("delete")) {
$showSelectAll = TRUE;
?>
<?php
			if (P('form_only') != "4") {
?>
			<td>
<?php
			} else {
?>
			<li>
<?php
			}
?>
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultUser['usr_id'] ?>">
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>
<?php
			}
?>
<?php
if (! $showSelectAll) {
			if ($this->canExecute("delete")) {
?>
<?php
			if (P('form_only') != "4") {
?>
			<td>
<?php
			} else {
?>
			<li>
<?php
			}
?>
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultUser['usr_id'] ?>">
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>
<?php
			}
}
?>
<?php
PROFILE('username');
	if (P('show_table_username', "1") == "1") {
PROFILE('render_data_table_username');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="username">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_username'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_username');
	}
PROFILE('username');
?>
<?php
PROFILE('password');
	if (P('show_table_password', "0") == "1") {
PROFILE('render_data_table_password');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="password">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_password'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_password');
	}
PROFILE('password');
?>
<?php
PROFILE('email');
	if (P('show_table_email', "0") == "1") {
PROFILE('render_data_table_email');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="email">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php
		$email = htmlentities($resultUser['usr_email'], ENT_QUOTES, "UTF-8");
?>
		<a href="mailto:<?php echo $email ?>" target="_blank">
			<?php echo $email ?>
		</a>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_email');
	}
PROFILE('email');
?>
<?php
PROFILE('first name');
	if (P('show_table_first_name', "0") == "1") {
PROFILE('render_data_table_first_name');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="first_name">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_first_name'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_first_name');
	}
PROFILE('first name');
?>
<?php
PROFILE('last name');
	if (P('show_table_last_name', "0") == "1") {
PROFILE('render_data_table_last_name');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="last_name">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_last_name'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_last_name');
	}
PROFILE('last name');
?>
<?php
PROFILE('session id');
	if (P('show_table_session_id', "0") == "1") {
PROFILE('render_data_table_session_id');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="session_id">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_session_id'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_session_id');
	}
PROFILE('session id');
?>
<?php
PROFILE('ip');
	if (P('show_table_ip', "0") == "1") {
PROFILE('render_data_table_ip');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="ip">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_ip'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_ip');
	}
PROFILE('ip');
?>
<?php
PROFILE('logged in');
	if (P('show_table_logged_in', "0") == "1") {
PROFILE('render_data_table_logged_in');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="logged_in">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php
	$canEditBoolean = ($this->canEdit() && P('show_form_logged_in', "1") == "1");
	if ($resultUser['usr_logged_in'] == 2 || is_null($resultUser['usr_logged_in'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_logged_in_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo is_null($resultUser['usr_logged_in']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_logged_in_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetLoggedInTrue';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetLoggedInFalse';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultUser['usr_logged_in'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_logged_in_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_logged_in_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetLoggedInFalse';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultUser['usr_logged_in'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_logged_in_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_logged_in_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetLoggedInTrue';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_logged_in');
	}
PROFILE('logged in');
?>
<?php
PROFILE('last successful login');
	if (P('show_table_last_successful_login', "0") == "1") {
PROFILE('render_data_table_last_successful_login');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="last_successful_login">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_last_successful_login'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_last_successful_login');
	}
PROFILE('last successful login');
?>
<?php
PROFILE('last failed login');
	if (P('show_table_last_failed_login', "0") == "1") {
PROFILE('render_data_table_last_failed_login');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="last_failed_login">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_last_failed_login'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_last_failed_login');
	}
PROFILE('last failed login');
?>
<?php
PROFILE('last logout');
	if (P('show_table_last_logout', "0") == "1") {
PROFILE('render_data_table_last_logout');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="last_logout">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_last_logout'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_last_logout');
	}
PROFILE('last logout');
?>
<?php
PROFILE('user agent');
	if (P('show_table_user_agent', "0") == "1") {
PROFILE('render_data_table_user_agent');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="user_agent">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_user_agent'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_user_agent');
	}
PROFILE('user agent');
?>
<?php
PROFILE('token');
	if (P('show_table_token', "0") == "1") {
PROFILE('render_data_table_token');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="token">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultUser['usr_token'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_token');
	}
PROFILE('token');
?>
<?php
PROFILE('unidentified');
	if (P('show_table_unidentified', "0") == "1") {
PROFILE('render_data_table_unidentified');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="unidentified">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php
	$canEditBoolean = ($this->canEdit() && P('show_form_unidentified', "1") == "1");
	if ($resultUser['usr_unidentified'] == 2 || is_null($resultUser['usr_unidentified'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_unidentified_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo is_null($resultUser['usr_unidentified']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_unidentified_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetUnidentifiedTrue';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetUnidentifiedFalse';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultUser['usr_unidentified'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_unidentified_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_unidentified_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetUnidentifiedFalse';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultUser['usr_unidentified'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_unidentified_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_unidentified_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetUnidentifiedTrue';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_unidentified');
	}
PROFILE('unidentified');
?>
<?php
PROFILE('confirmed');
	if (P('show_table_confirmed', "0") == "1") {
PROFILE('render_data_table_confirmed');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="confirmed">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php
	$canEditBoolean = ($this->canEdit() && P('show_form_confirmed', "1") == "1");
	if ($resultUser['usr_confirmed'] == 2 || is_null($resultUser['usr_confirmed'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_confirmed_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo is_null($resultUser['usr_confirmed']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_confirmed_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetConfirmedTrue';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetConfirmedFalse';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultUser['usr_confirmed'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_confirmed_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_confirmed_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetConfirmedFalse';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultUser['usr_confirmed'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_confirmed_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_confirmed_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetConfirmedTrue';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_confirmed');
	}
PROFILE('confirmed');
?>
<?php
PROFILE('accepted');
	if (P('show_table_accepted', "0") == "1") {
PROFILE('render_data_table_accepted');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="accepted">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php
	$canEditBoolean = ($this->canEdit() && P('show_form_accepted', "1") == "1");
	if ($resultUser['usr_accepted'] == 2 || is_null($resultUser['usr_accepted'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_accepted_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo is_null($resultUser['usr_accepted']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_accepted_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetAcceptedTrue';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetAcceptedFalse';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultUser['usr_accepted'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_accepted_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_accepted_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetAcceptedFalse';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultUser['usr_accepted'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_accepted_<?php echo $resultUser['usr_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_accepted_<?php echo $resultUser['usr_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetAcceptedTrue';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_accepted');
	}
PROFILE('accepted');
?>
<?php
	if (class_exists('portal\virgoPage') && P('show_table_page', "1") != "0"  && !isset($parentsInContext["portal\\virgoPage"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_page', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="page">
<?php
			} 
?>
    <span 
    	class="<?php echo $displayClass ?>"
    >
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.usr_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultUser['usr_id']) ? $resultUser['usr_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php 
	if (P('show_table_page', "1") == "1") {
		if (isset($resultUser['page'])) {
			echo $resultUser['page'];
		}
	} else {
//		echo $resultUser['usr_pge_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetPage';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo $resultUser['usr_id'] ?>');
	_pSF(form, 'usr_Page_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
		">
			<option></option>
<?php
		foreach ($tmpLookupPage as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultUser['usr_pge_id'] ? " selected " : "" ?>><?php echo $label ?></option>
<?php			
		}
?>
		</select>
<?php
	}
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
    </span>
<?php
			if (P('form_only') != "4") {
?>
				</td>    
<?php
			} else {
?>
				</li>    
<?php
			}
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoUserRole') && P('show_table_user_roles', '0') == "1") {
?>
<td>
<?php
	$record = new portal\virgoUser();
	$recordId = is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->usr_id;
	$record->load($recordId);
	$subrecordsUserRoles = $record->getUserRoles();
	$sizeUserRoles = count($subrecordsUserRoles);
?>
<?php
	if ($sizeUserRoles == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsUserRoles as $subrecord) {
			$subrecordIndex++;
			$parentRole = new portal\virgoRole($subrecord->getRleId());
			echo htmlentities($parentRole->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeUserRoles) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
</td>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoSystemMessage') && P('show_table_system_messages', '0') == "1") {
?>
<?php
	}
?>
<?php
PROFILE('extra data');
?>
<?php
PROFILE('extra data');
?>
<?php
			if (P('form_only') != "4") {
?>
				<td nowrap class="actions" align="left">
<?php
			} else {
?>
				<li>
<?php
			}
?>

<?php
PROFILE('token');
	if (isset($resultUser)) {
		$tmpId = is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
?>
<?php
	if (P('master_mode', "0") == "0") {
			if ($this->canExecute("view")) {
?>
<?php						
		if (P('show_details_method') != "1") {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('View')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_view inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='View';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('VIEW') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
		}
?>
<?php
			}
		if ($this->canEdit()) {
?>
<?php
			if ($this->canExecute("form")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Form')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_form inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Form';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('EDIT') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
?>
<?php
			}
?>
<?php
			if ($this->canExecute("delete")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Delete')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_delete inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("USER"), "\\'".rawurlencode($resultUser['usr_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DELETE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
?>
<?php 
		} 	} 
		if ($this->canEdit()) {
?>
<?php
	if (P('enable_record_duplication', "0") == "1") {
			if ($this->canExecute("add")) {
?> <div class="button_wrapper button_wrapper_duplicate inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Duplicate';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DUPLICATE') ?>"
						/><div class="button_right"></div></div><?php			
	}
?>
<?php
			}
?>
<?php
			$actions = virgoRole::getExtraActions('ER');
			foreach ($actions as $action) {
?>

<?php
	$buttonRendered = false;
	if ($this->canExecute($action)) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_<?php echo $action ?> inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='<?php echo $action ?>';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($action) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php						
			}
		} ?>
<?php
			if (P('form_only') != "4") {
?>
				</td>
<?php
			} else {
?>
				</li>
<?php
			}
?>
<?php
			if (P('form_only') == "4") {
?>
					</ul> 
<?php
			}
?>

<?php
			}
?>
<?php
			if (P('form_only') != "4" || (P('chessboard_width') != 0 && $index % P('chessboard_width') == 0)) {
?>
			</tr>
<?php
			} 
?>

<?php
} else {
	include($fileNameToInclude);
}
?>
<?php
				}
	if (is_null($contextRowIdInTable)) {
		$forceContextOnFirstRow = P('force_context_on_first_row', "1");
		if ($forceContextOnFirstRow == "1") {
			virgoUser::setContextId($firstRowId, false);
			if (P('form_only') != "4") {
?>
<script type="text/javascript">
		$('form#portlet_form_<?php echo $this->getId() ?> table.data_table tr#<?php echo $this->getId() ?>_<?php echo $firstRowId ?>').addClass("contextClass");
</script>
<?php
			}
		}
	}				
				unset($resultUser);
				unset($resultsUser);
				if (isset($contextIdOwn) && trim($contextIdOwn) != "") {
					if ($contextIdConfirmed == false) {
						$tmpUser = new virgoUser();
						$tmpCount = $tmpUser->getAllRecordCount(' usr_id = ' . $contextIdOwn);
						if ($tmpCount == 0) {
							virgoUser::clearRemoteContextId($tabModeEditMenu);
						}
					}
				}
PROFILE('rows rendering');
?>			
<?php
PROFILE('table_05');
				if ($showRows == 'all') {
					$pageCount = 1;
				} else {
					$pageCount = (int)($resultCount / $showRows) + 1;
					if ($resultCount % $showRows == 0) {
						$pageCount = $pageCount - 1;
					}
				}
PROFILE('table_05');
PROFILE('table_06_1');
?>
<?php
	if (P('master_mode', "0") != "1") {
?>
<?php
		if (P('default_page_size', "20") != 'all' || P('available_page_sizes', "5,10,20,50,all") != "all") {
?>
			<tr class="table_footer">
				<td colspan="99" nowrap="nowrap">
						<table cellspacing="0" cellpadding="0" width="100%">
							<tr class="table_footer">
<?php
$showSelectAll = FALSE;
			if ($this->canExecute("form")) {
$showSelectAll = TRUE;
?>
								<td nowrap="nowrap" width="33%" align="left" class="select_all">
<?php echo T('SELECT_ALL') ?>									<input type="checkbox" class="checkbox" onclick="checkAll(this.checked, <?php echo $this->getId() ?>)">
								</td>
<?php
			}
?>
<?php
if (! $showSelectAll) {
			if ($this->canExecute("delete")) {
?>
<?php echo T('SELECT_ALL') ?>								<td nowrap="nowrap" width="33%" align="left" class="select_all">
									<input type="checkbox" class="checkbox" onclick="checkAll(this.checked, <?php echo $this->getId() ?>)">
								</td>
<?php
			}
}
?>
								<td nowrap="nowrap" width="34%" align="center" class="select_page">
									<input class="button_paging<?php echo ($showPage == 1 ? '_disabled' : '') ?>" src="<?php echo $_SESSION['portal_url'] ?>/media/icons/go-first.png" type="image" value="&#x21E4" onClick="this.form.action='';this.form.target='';this.form.virgo_show_page.value='1'; this.form.portlet_action.value='ChangePaging'; <?php echo JSFS() ?>" <?php echo ($showPage == 1 ? 'disabled="disabled"' : '') ?><?php echo ($showPage > 1 ? ' onmousedown="this.className=\'button_paging_pressed\'" onmouseup="this.className=\'button_paging\'" onmouseout="this.className=\'button_paging\'"' : '') ?>>
									<input class="button_paging<?php echo ($showPage == 1 ? '_disabled' : '') ?>" src="<?php echo $_SESSION['portal_url'] ?>/media/icons/go-previous.png" type="image" value="&#x2190" onClick="this.form.action='';this.form.target='';this.form.virgo_show_page.value='<?php echo ($showPage - 1) ?>'; this.form.portlet_action.value='ChangePaging'; <?php echo JSFS() ?>" <?php echo ($showPage == 1 ? 'disabled="disabled"' : '') ?><?php echo ($showPage > 1 ? ' onmousedown="this.className=\'button_paging_pressed\'" onmouseup="this.className=\'button_paging\'" onmouseout="this.className=\'button_paging\'"' : '') ?>>
<?php echo T('PAGE') ?><?php
PROFILE('table_06_1');
PROFILE('table_06_2');
	if ($pageCount > 100) {
?>
		<input class="inputbox" size="5" value="<?php echo $showPage ?>" name="showPageGui" onChange="this.form.action='';this.form.target='';this.form.virgo_show_page.value=this.value; this.form.portlet_action.value='ChangePaging'; <?php echo JSFS() ?>">
<?php
	} else {
?>
									<select class="inputbox" name="showPageGui" onChange="this.form.action='';this.form.target='';this.form.virgo_show_page.value=this.value; this.form.portlet_action.value='ChangePaging'; <?php echo JSFS() ?>">
<?php
				$tmpPageIndex = 1;
				while ($tmpPageIndex <= $pageCount) {
		
?>
										<option value="<?php echo ($tmpPageIndex) ?>" <?php echo ($tmpPageIndex == $showPage ? "selected='selected'" : "") ?>><?php echo ($tmpPageIndex) ?></option>
<?php
					$tmpPageIndex = $tmpPageIndex + 1;
				}
?>
									</select>
<?php
	}
?>
<?php echo T('OF') ?>									<?php echo ($pageCount) ?>
									<input type="hidden" name="virgo_show_page" value="<?php echo ($showPage) ?>">
									<input class="button_paging<?php echo ($showPage == $pageCount ? '_disabled' : '') ?>" src="<?php echo $_SESSION['portal_url'] ?>/media/icons/go-next.png" type="image" value="&#x2192" onClick="this.form.action='';this.form.target='';this.form.virgo_show_page.value='<?php echo ($showPage + 1) ?>'; this.form.portlet_action.value='ChangePaging'; <?php echo JSFS() ?>" <?php echo ($showPage == $pageCount ? 'disabled="disabled"' : '') ?><?php echo ($showPage > 1 ? ' onmousedown="this.className=\'button_paging_pressed\'" onmouseup="this.className=\'button_paging\'" onmouseout="this.className=\'button_paging\'"' : '') ?>>
									<input class="button_paging<?php echo ($showPage == $pageCount ? '_disabled' : '') ?>" src="<?php echo $_SESSION['portal_url'] ?>/media/icons/go-last.png" type="image" value="&#x21E5" onClick="this.form.action='';this.form.target='';this.form.virgo_show_page.value='<?php echo ($pageCount) ?>'; this.form.portlet_action.value='ChangePaging'; <?php echo JSFS() ?>" <?php echo ($showPage == $pageCount ? 'disabled="disabled"' : '') ?><?php echo ($showPage > 1 ? ' onmousedown="this.className=\'button_paging_pressed\'" onmouseup="this.className=\'button_paging\'" onmouseout="this.className=\'button_paging\'"' : '') ?>>
								</td>
								<td width="33%" nowrap="nowrap" align="right" class="show_rows"><?php echo T('SHOW_ROWS') ?> (<?php echo $resultCount ?>):&nbsp;<select class="inputbox" name="virgo_show_rows" onChange="this.form.action='';this.form.target='';this.form.virgo_show_page.value='1'; this.form.portlet_action.value='ChangePaging';
<?php echo JSFS() ?>									
">
<?php
										$paramValue = P('available_page_sizes', "5,10,20,50,all");
										$pageSizes = preg_split("/,/", $paramValue);
										foreach ($pageSizes as $pageSize) {
?>
										<option value="<?php echo $pageSize ?>" <?php echo ($showRows == $pageSize ? "selected='selected'" : "") ?>><?php echo ($pageSize == 'all' ? T('ALL')
 : $pageSize) ?></option>
<?php											
										}
?>
									</select>
								</td>
							</tr>
						</table>
				</td>
			</tr>
<?php
		}
?>
<?php
	}
PROFILE('table_06_2');
PROFILE('table_07');
?>
<?php
			} else {
?>
				<tr>
					<td colspan="99">
						<div class="message"><?php echo ($filterApplied ? T('NO_RESULTS')
 : T('NO_DATA_TO_SHOW')
) ?></div>
					</td>
				</tr>
<?php
			}
?>
		</table>
<?php echo P('master_mode', "0") == "1" ? "</div>" : "" ?>		
<script type='text/javascript'>
	var timer = null;
	var clicks<?php echo $this->getId() ?> = 0;
	var clicked<?php echo $this->getId() ?> = null;
$(document).ready(function() {
    $('form#portlet_form_<?php echo $this->getId() ?> table.data_table td.selectable')
    .on('click', function(e){
    	clicked<?php echo $this->getId() ?> = $(this);
        clicks<?php echo $this->getId() ?> = clicks<?php echo $this->getId() ?> + 1;
        if(clicks<?php echo $this->getId() ?> === 1) {
            var rowId = $(this).parent().attr('id');
	    var virgoId = rowId.substring(rowId.indexOf("_")+1);
            timer = setTimeout(function() {
            	clicked<?php echo $this->getId() ?>.css('cursor','progress');
<?php
		$ajax = $this->getAjax();;
		if ($actionOnRowClick == "Select" && isset($ajax) && $ajax) {
			$page = virgoPage::getCurrentPage();
?>
		$.getJSON('<?php echo $page->getUrl() ?>?portlet_action=SelectJson&usr_id_<?php echo $this->getId() ?>=' + virgoId + '&invoked_portlet_object_id=<?php echo $this->getId() ?>&virgo_action_mode_json=T&_virgo_ajax=1', function(data) {
<?php
			if (P('form_only') != "4") {
?>
			$('form#portlet_form_<?php echo $this->getId() ?> table.data_table tr.contextClass').removeClass("contextClass");
<?php
			}			
			$childrenToSubmit = array();
			$childrenToSubmit[$this->getId()] = prepareChildrenToSubmit($this->getId());
			$childrenToSubmitJSString = str_replace("\"", "'", json_encode($childrenToSubmit/*, JSON_FORCE_OBJECT*/));					
?>			
			var childrenToSubmit = <?php echo $childrenToSubmitJSString ?>;
			var pobId = <?php echo $this->getId() ?>;
		    	if (childrenToSubmit.hasOwnProperty(pobId)) {
			    	var currentChildrenToSubmit = childrenToSubmit[pobId];
			    	if (typeof(currentChildrenToSubmit) !== 'undefined') {
				    	if (/* mode == "Submit" && */ Object.keys(currentChildrenToSubmit).length > 0) {
							for (var child in currentChildrenToSubmit) {
							    if (currentChildrenToSubmit.hasOwnProperty(child)) {
							    	jsfs(child, "Submit", currentChildrenToSubmit[child]);
							   }
							}
				    	}
				    }
				}
<?php
		if (P('form_only') != "4") {
?>
		if (data) {
			$('form#portlet_form_<?php echo $this->getId() ?> table.data_table tr#' + rowId).addClass("contextClass");
		}
<?php
		}
?>		
		clicked<?php echo $this->getId() ?>.css('cursor','pointer');        
		});
<?php
		} else {
?>
		var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
		form.portlet_action.value='<?php echo $actionOnRowClick ?>'; 
		form.usr_id_<?php echo $this->getId() ?>.value=virgoId; 
		form.target = ''; 
<?php
			if (is_null($ajax) || (isset($ajax) && !$ajax)) {
?>					
		form.submit();
<?php
			} else {
?>					
		<?php echo JSFS(null, "Submit", true, array()) ?>
<?php
			}
		}
?>					
                clicks<?php echo $this->getId() ?> = 0;
            }, 300);
        } else {
            clearTimeout(timer);
            var rowId = $(this).parent().attr('id');            
	    var virgoId = rowId.substring(rowId.indexOf("_")+1);
		var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
		form.portlet_action.value='<?php echo $actionOnRowDoubleClick ?>'; 
		form.usr_id_<?php echo $this->getId() ?>.value=virgoId; 
		form.target = ''; 
<?php
	global $ajax;
	if (is_null($ajax) || (isset($ajax) && !$ajax)) {
?>					
		form.submit();
<?php
	} else {
?>					
		<?php echo JSFS() ?>
<?php
	}
?>					
            clicks<?php echo $this->getId() ?> = 0;
        }
    })
    .on('dblclick', function(e){
        e.preventDefault();
    });
});
</script>		
<?php
PROFILE('table_07');
PROFILE('table_08');
?>
<?php
	$showBasic = false;
	$showImport = false;
	$showSelected = false;
	$anythingRendered = false;
?>
		<span class="operations_tabs"><span id="table_operations" style="text-align: center;" class="table_footer_buttons"<?php echo P('form_only') == "4" ? " style='background-color: #FFFFFF;'" : "" ?>>
					<span id="control_basic_<?php echo $this->getId() ?>" class="operations_tab_current" onclick="showOperations('basic', <?php echo $this->getId() ?>);"><?php echo T('OPERATIONS_BASIC') ?></span>
					<span id="control_import_<?php echo $this->getId() ?>" class="operations_tab" onclick="showOperations('import', <?php echo $this->getId() ?>);"><?php echo T('OPERATIONS_IMPORT') ?></span>
					<span id="control_selected_<?php echo $this->getId() ?>" class="operations_tab" onclick="showOperations('selected', <?php echo $this->getId() ?>);"><?php echo T('OPERATIONS_SELECTED') ?></span>
					<div id="operations_basic_<?php echo $this->getId() ?>" class="operations">
		</span>
<?php
PROFILE('TABLE_ACTIONS_ADD');
			if ($this->canExecute("add")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Add')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_add inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Add';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('ADD') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
PROFILE('TABLE_ACTIONS_ADD');
PROFILE('TABLE_ACTIONS_SEARCH');
			if ($this->canExecute("SearchForm")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('SearchForm')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_searchform inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='SearchForm';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('SEARCH') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
PROFILE('TABLE_ACTIONS_SEARCH');
?>
<?php
PROFILE('TABLE_ACTIONS_REPORT');
			if ($this->canExecute("report")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Report')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_report inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="button" 
							onclick="
								var form = document.getElementById('portlet_form_download_<?php echo $this->getId() ?>');
								var children = form.getElementsByTagName('input');
								var found = 0;
								for(var i = 0; i< children.length;i++) {
								  if (children[i].getAttribute('name') == 'usr_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'usr_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Report';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
								form.submit();
								return false;
							" 
							value="<?php echo T('REPORT') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
PROFILE('TABLE_ACTIONS_REPORT');
PROFILE('TABLE_ACTIONS_EXPORT');
			if ($this->canExecute("export")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Export')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_export inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="button" 
							onclick="
								var form = document.getElementById('portlet_form_download_<?php echo $this->getId() ?>');
								var children = form.getElementsByTagName('input');
								var found = 0;
								for(var i = 0; i< children.length;i++) {
								  if (children[i].getAttribute('name') == 'usr_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'usr_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Export';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
								form.submit();
								return false;
							" 
							value="<?php echo T('CSV') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
PROFILE('TABLE_ACTIONS_EXPORT_WUT?');
			if ($this->canExecute("add")) {
			if ($this->canExecute("form")) {
			if ($this->canExecute("delete")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Offline')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_offline inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="button" 
							onclick="
								var form = document.getElementById('portlet_form_download_<?php echo $this->getId() ?>');
								var children = form.getElementsByTagName('input');
								var found = 0;
								for(var i = 0; i< children.length;i++) {
								  if (children[i].getAttribute('name') == 'usr_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'usr_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Offline';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
								form.submit();
								return false;
							" 
							value="<?php echo T('EXCEL') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
			}
			}
PROFILE('TABLE_ACTIONS_EXPORT_WUT?');
?>
<?php
	if (true) { //$user->username == "metaadmin" && $user->get( 'gid' ) == 25) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('UpdateTitle')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_updatetitle inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='UpdateTitle';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('UPDATE_TITLE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
	}
			$actions = virgoRole::getExtraActions('ET');
PROFILE('TABLE_ACTIONS_ET');
			foreach ($actions as $action) {
?>

<?php
	$buttonRendered = false;
	if ($this->canExecute($action)) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_<?php echo $action ?> inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								if (!nothingSelected(this.form, <?php echo $this->getId() ?>)) {
								} else {
									var alertText = '<?php echo T('NOTHING_SELECTED') ?>';
									if (alertText.charAt(alertText.length-1)=='?') {
										if (!confirm(alertText)) return false;
									} else {
										alert(alertText); return false;
									}
								}
								var form = this.form;
								form.action = '';
								form.portlet_action.value='<?php echo $action ?>';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');
copyIds(form, <?php echo $this->getId() ?>);
 								form.target = '';
							" 
							value="<?php echo T($action) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php						
			}
PROFILE('TABLE_ACTIONS_ET');
?>
					</div>
					<div id="operations_import_<?php echo $this->getId() ?>" style="display: none;" class="operations">
<?php
			if ($this->canExecute("upload")) {
?>
			<input type="file" name="virgo_upload_file">
<?php
PROFILE('TABLE_ACTIONS_UPLOAD');
				$separatorString = ","; //$componentParams->get('import_separator');
				if ($separatorString == "") {
?>
			<input name="field_separator_in_import" size="1"
<?php
					$sessionSeparator = virgoUser::getImportFieldSeparator();
					if (!is_null($sessionSeparator)) {
?>
						value="<?php $sessionSeparator ?>"
<?php
					}
?>
			>
<?php
				} else {
					$separators = preg_split("/X/", $separatorString);
					if (sizeof($separators) == 1) {
?>
			<input type="hidden" name="field_separator_in_import" value="<?php echo $separators[0] ?>">
<?php
					} else {
?>
			<select name="field_separator_in_import">
<?php
						$sessionSeparator = virgoUser::getImportFieldSeparator();
						foreach ($separators as $separator) {
?>
				<option value="<?php echo $separator ?>" 
<?php
							if ($sessionSeparator == $separator) {
?>
					selected="selected"
<?php
							}
?>
				><?php echo $separator ?></option>
<?php
						}
?>
			</select>
<?php						
					}
				}
PROFILE('TABLE_ACTIONS_UPLOAD');				
PROFILE('TABLE_ACTIONS_RESZTA');
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Upload')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_upload inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Upload';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('UPLOAD') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
	if ($buttonRendered) {
		$showImport = true;
	}
			}
?>
					</div>
<?php
	if (!$showImport) {
?>
<script type="text/javascript">
	document.getElementById('control_import_<?php echo $this->getId() ?>').style.display='none';
</script>
<?php
	}
?>
					<div id="operations_selected_<?php echo $this->getId() ?>" style="display: none;"  class="operations">
			<input type="hidden" name="ids" value="">
<?php
			if ($this->canExecute("edit")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('EditSelected')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_editselected inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								if (!nothingSelected(this.form, <?php echo $this->getId() ?>)) {
								} else {
									var alertText = '<?php echo T('NOTHING_SELECTED') ?>';
									if (alertText.charAt(alertText.length-1)=='?') {
										if (!confirm(alertText)) return false;
									} else {
										alert(alertText); return false;
									}
								}
								var form = this.form;
								form.action = '';
								form.portlet_action.value='EditSelected';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');
copyIds(form, <?php echo $this->getId() ?>);
 								form.target = '';
							" 
							value="<?php echo T('EDIT_SELECTED') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
	if ($buttonRendered) {
		$showSelected = true;
	}
			}
			if ($this->canExecute("delete")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('DeleteSelected')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_deleteselected inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								if (!nothingSelected(this.form, <?php echo $this->getId() ?>)) {
									if (!confirm(decodeURIComponent('<?php echo T('ARE_YOU_SURE_YOU_WANT_REMOVE', T('USERS'), "") ?>'))) return false;
								} else {
									var alertText = '<?php echo T('NOTHING_SELECTED') ?>';
									if (alertText.charAt(alertText.length-1)=='?') {
										if (!confirm(alertText)) return false;
									} else {
										alert(alertText); return false;
									}
								}
								var form = this.form;
								form.action = '';
								form.portlet_action.value='DeleteSelected';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');
copyIds(form, <?php echo $this->getId() ?>);
 								form.target = '';
							" 
							value="<?php echo T('DELETE_SELECTED') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
	if ($buttonRendered) {
		$showSelected = true;
	}
			}
?>





					</div>
		</span>
<?php
	if (!$showSelected) {
?>
<script type="text/javascript">
	document.getElementById('control_selected_<?php echo $this->getId() ?>').style.display='none';
</script>
<?php
	}
?>
<?php
	if (!$showImport && !$showSelected) {
?>
<script type="text/javascript">
	document.getElementById('control_basic_<?php echo $this->getId() ?>').style.display='none';
</script>
<?php
	}
	if (!$anythingRendered) {
?>
<script type="text/javascript">
	document.getElementById('operations_basic_<?php echo $this->getId() ?>').style.display='none';
</script>
<?php		
	}
PROFILE('TABLE_ACTIONS_RESZTA');
?>

<?php
PROFILE('table_08');
?>
<?php
		}
PROFILE('TABLE');
/* MILESTONE 1.6 TableForm */
	} elseif ($userDisplayMode == "TABLE_FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_user") {
			  if (check.value == 'T') {
				  return "<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>";
			  }
		  }
        }
  }
</script>
		<script type="text/javascript">
			var userChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == userChildrenDivOpen) {
					div.style.display = 'none';
					userChildrenDivOpen = '';
				} else {
					if (userChildrenDivOpen != '') {
						document.getElementById(userChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					userChildrenDivOpen = clickedDivId;
				}
			}
			
			function copyIds(form) {
				var chcks = document.getElementsByTagName("input");
				var ids = form.ids;
				var firstOne = 1;
				for (i=0;i<chcks.length;i++) {
					if (chcks[i].name.match("^DELETE_\d*")) {
						if (chcks[i].checked == 1) {
							if (firstOne == 1) {
								firstOne = 0;
							} else {
								ids.value = ids.value + ",";
							}
							ids.value = ids.value + chcks[i].name.substring(7);
						}
					}
				}
				form.submit();
			}
			
			function nothingSelected(form) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (chcks[i].name.match("^DELETE_\d*")) {
						if (chcks[i].checked == 1) {
							return false;
						}
					}
				}
				return true;
			}
			
			function checkAll(value) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (chcks[i].name.match("^DELETE_\d*")) {
						chcks[i].checked = value;
					}
				}
			}
		</script>

	<form method="post" style="display: inline;" action="" id="virgo_form_user" name="virgo_form_user" enctype="multipart/form-data">
						<input type="text" name="usr_id_<?php echo $this->getId() ?>" id="usr_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

		<table class="data_table" cellpadding="0" cellspacing="0">
			<tr class="data_table_header">
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
	if (P('show_table_username', "1") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Username
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_password', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Password
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_email', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Email
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_first_name', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							First name
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_last_name', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Last name
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_session_id', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Session id
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_ip', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Ip
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_logged_in', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Logged in
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_last_successful_login', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Last successful login
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_last_failed_login', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Last failed login
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_last_logout', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Last logout
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_user_agent', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							User agent
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_token', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Token
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_unidentified', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Unidentified
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_confirmed', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Confirmed
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_accepted', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Accepted
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_page', "1") == "1" /* && ($masterComponentName != "page" || is_null($contextId)) */) {
?>
				<td align="center" nowrap>Page </td>
<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$resultsUser = $resultUser->getRecordsToEdit();
				$idsToCorrect = $resultUser->getInvalidRecords();
				$index = 0;
PROFILE('rows rendering');
				foreach ($resultsUser as $resultUser) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultUser->usr_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
<?php
	if ($resultUser->usr_id == 0 && R('virgo_validate_new', "N") == "N") {
?>
		style="display: none;"
<?php
	}
?>
			>
<?php
PROFILE('username');
	if (P('show_table_username', "1") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 0;
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="usr_username_<?php echo $resultUser->getId() ?>" 
							name="usr_username_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getUsername(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_USERNAME');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_username_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('username');
	} else {
?> 
						<input
							type="hidden"
							id="username_<?php echo $resultUser->usr_id ?>" 
							name="username_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_username, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('password');
	if (P('show_table_password', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 1;
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input type="password"
							class="inputbox " 
							id="usr_password_<?php echo $resultUser->getId() ?>" 
							name="usr_password_<?php echo $resultUser->getId() ?>"
							size="15" 
							maxlength="14"
							value="<?php echo $resultUser->getPassword() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_PASSWORD');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						/>
<label align="right" for="usr_password2_<?php echo $resultUser->getId() ?>" nowrap class="fieldlabel " style="float: none;">						
<?php echo T('REPEAT') . ' ' . T('PASSWORD') ?>
</label>						
						<input type="password"
							class="inputbox " 
							id="usr_password2_<?php echo $resultUser->getId() ?>" 
							name="usr_password2_<?php echo $resultUser->getId() ?>"
							size="15" 
							maxlength="14"
							value="<?php echo $resultUser->getPassword() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
						/>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_password_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
PROFILE('password');
	} else {
?> 
						<input
							type="hidden"
							id="password_<?php echo $resultUser->usr_id ?>" 
							name="password_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_password, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('email');
	if (P('show_table_email', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 2;
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_email_obligatory', "0") == "1" ? " obligatory " : "" ?>   short   medium " 
							type="text"
							id="usr_email_<?php echo $resultUser->getId() ?>" 
							name="usr_email_<?php echo $resultUser->getId() ?>"
							size="50" 
							value="<?php echo htmlentities($resultUser->getEmail(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_EMAIL');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_email_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('email');
	} else {
?> 
						<input
							type="hidden"
							id="email_<?php echo $resultUser->usr_id ?>" 
							name="email_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_email, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('first name');
	if (P('show_table_first_name', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 3;
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_first_name_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_firstName_<?php echo $resultUser->getId() ?>" 
							name="usr_firstName_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getFirstName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_FIRST_NAME');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_firstName_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('first name');
	} else {
?> 
						<input
							type="hidden"
							id="firstName_<?php echo $resultUser->usr_id ?>" 
							name="firstName_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_first_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('last name');
	if (P('show_table_last_name', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 4;
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_last_name_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_lastName_<?php echo $resultUser->getId() ?>" 
							name="usr_lastName_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getLastName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_LAST_NAME');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_lastName_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('last name');
	} else {
?> 
						<input
							type="hidden"
							id="lastName_<?php echo $resultUser->usr_id ?>" 
							name="lastName_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_last_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('session id');
	if (P('show_table_session_id', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 5;
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_session_id_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_sessionId_<?php echo $resultUser->getId() ?>" 
							name="usr_sessionId_<?php echo $resultUser->getId() ?>"
							maxlength="32"
							size="32" 
							value="<?php echo htmlentities($resultUser->getSessionId(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_SESSION_ID');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_sessionId_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('session id');
	} else {
?> 
						<input
							type="hidden"
							id="sessionId_<?php echo $resultUser->usr_id ?>" 
							name="sessionId_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_session_id, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('ip');
	if (P('show_table_ip', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 6;
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_ip_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_ip_<?php echo $resultUser->getId() ?>" 
							name="usr_ip_<?php echo $resultUser->getId() ?>"
							maxlength="15"
							size="15" 
							value="<?php echo htmlentities($resultUser->getIp(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_IP');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_ip_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('ip');
	} else {
?> 
						<input
							type="hidden"
							id="ip_<?php echo $resultUser->usr_id ?>" 
							name="ip_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_ip, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('logged in');
	if (P('show_table_logged_in', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 7;
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<select class="inputbox" id="usr_loggedIn_<?php echo $resultUser->getId() ?>" name="usr_loggedIn_<?php echo $resultUser->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_LOGGED_IN');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultUser->getLoggedIn() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultUser->getLoggedIn() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultUser->getLoggedIn()) || $resultUser->getLoggedIn() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_loggedIn_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
PROFILE('logged in');
	} else {
?> 
						<input
							type="hidden"
							id="loggedIn_<?php echo $resultUser->usr_id ?>" 
							name="loggedIn_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_logged_in, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('last successful login');
	if (P('show_table_last_successful_login', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 8;
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<?php
	$locale = setlocale(LC_ALL,"0");
	if (isset($locale) && trim($locale) != "") {
		$lang = substr($locale, 0, 2);
	} else {
		$lang = "en";
	}
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
	if (!defined('JS_INCLUDED_TIMEPICKER')) {
		define('JS_INCLUDED_TIMEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQuery.timepicker/jquery-ui-timepicker-addon.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = $resultUser->getLastSuccessfulLogin();
?>
						<input class="inputbox" id="usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>" name="usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>'] = function () {
  $("#usr_lastSuccessfulLogin_<?php echo $resultUser->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


</td>
<?php
PROFILE('last successful login');
	} else {
?> 
						<input
							type="hidden"
							id="lastSuccessfulLogin_<?php echo $resultUser->usr_id ?>" 
							name="lastSuccessfulLogin_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_last_successful_login, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('last failed login');
	if (P('show_table_last_failed_login', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 9;
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<?php
	$locale = setlocale(LC_ALL,"0");
	if (isset($locale) && trim($locale) != "") {
		$lang = substr($locale, 0, 2);
	} else {
		$lang = "en";
	}
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
	if (!defined('JS_INCLUDED_TIMEPICKER')) {
		define('JS_INCLUDED_TIMEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQuery.timepicker/jquery-ui-timepicker-addon.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = $resultUser->getLastFailedLogin();
?>
						<input class="inputbox" id="usr_lastFailedLogin_<?php echo $resultUser->getId() ?>" name="usr_lastFailedLogin_<?php echo $resultUser->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastFailedLogin_<?php echo $resultUser->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastFailedLogin_<?php echo $resultUser->getId() ?>'] = function () {
  $("#usr_lastFailedLogin_<?php echo $resultUser->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


</td>
<?php
PROFILE('last failed login');
	} else {
?> 
						<input
							type="hidden"
							id="lastFailedLogin_<?php echo $resultUser->usr_id ?>" 
							name="lastFailedLogin_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_last_failed_login, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('last logout');
	if (P('show_table_last_logout', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 10;
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<?php
	$locale = setlocale(LC_ALL,"0");
	if (isset($locale) && trim($locale) != "") {
		$lang = substr($locale, 0, 2);
	} else {
		$lang = "en";
	}
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
	if (!defined('JS_INCLUDED_TIMEPICKER')) {
		define('JS_INCLUDED_TIMEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQuery.timepicker/jquery-ui-timepicker-addon.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = $resultUser->getLastLogout();
?>
						<input class="inputbox" id="usr_lastLogout_<?php echo $resultUser->getId() ?>" name="usr_lastLogout_<?php echo $resultUser->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastLogout_<?php echo $resultUser->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['usr_lastLogout_<?php echo $resultUser->getId() ?>'] = function () {
  $("#usr_lastLogout_<?php echo $resultUser->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


</td>
<?php
PROFILE('last logout');
	} else {
?> 
						<input
							type="hidden"
							id="lastLogout_<?php echo $resultUser->usr_id ?>" 
							name="lastLogout_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_last_logout, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('user agent');
	if (P('show_table_user_agent', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 11;
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_user_agent_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_userAgent_<?php echo $resultUser->getId() ?>" 
							name="usr_userAgent_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getUserAgent(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_USER_AGENT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_userAgent_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('user agent');
	} else {
?> 
						<input
							type="hidden"
							id="userAgent_<?php echo $resultUser->usr_id ?>" 
							name="userAgent_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_user_agent, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('token');
	if (P('show_table_token', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 12;
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_token_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="usr_token_<?php echo $resultUser->getId() ?>" 
							name="usr_token_<?php echo $resultUser->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultUser->getToken(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_TOKEN');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_token_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('token');
	} else {
?> 
						<input
							type="hidden"
							id="token_<?php echo $resultUser->usr_id ?>" 
							name="token_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_token, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('unidentified');
	if (P('show_table_unidentified', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 13;
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<select class="inputbox" id="usr_unidentified_<?php echo $resultUser->getId() ?>" name="usr_unidentified_<?php echo $resultUser->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_UNIDENTIFIED');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultUser->getUnidentified() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultUser->getUnidentified() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultUser->getUnidentified()) || $resultUser->getUnidentified() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_unidentified_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
PROFILE('unidentified');
	} else {
?> 
						<input
							type="hidden"
							id="unidentified_<?php echo $resultUser->usr_id ?>" 
							name="unidentified_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_unidentified, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('confirmed');
	if (P('show_table_confirmed', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 14;
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<select class="inputbox" id="usr_confirmed_<?php echo $resultUser->getId() ?>" name="usr_confirmed_<?php echo $resultUser->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_CONFIRMED');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultUser->getConfirmed() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultUser->getConfirmed() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultUser->getConfirmed()) || $resultUser->getConfirmed() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_confirmed_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
PROFILE('confirmed');
	} else {
?> 
						<input
							type="hidden"
							id="confirmed_<?php echo $resultUser->usr_id ?>" 
							name="confirmed_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_confirmed, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('accepted');
	if (P('show_table_accepted', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsUser) * 15;
?>
<?php
	if (!isset($resultUser)) {
		$resultUser = new portal\virgoUser();
	}
?>
<select class="inputbox" id="usr_accepted_<?php echo $resultUser->getId() ?>" name="usr_accepted_<?php echo $resultUser->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_USER_ACCEPTED');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultUser->getAccepted() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultUser->getAccepted() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultUser->getAccepted()) || $resultUser->getAccepted() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_accepted_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
PROFILE('accepted');
	} else {
?> 
						<input
							type="hidden"
							id="accepted_<?php echo $resultUser->usr_id ?>" 
							name="accepted_<?php echo $resultUser->usr_id ?>"
							value="<?php echo htmlentities($resultUser->usr_accepted, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('extra data');
?>
<?php
PROFILE('extra data');
?>
<?php
	if (P('show_table_page', "1") == "1"/* && ($masterComponentName != "page" || is_null($contextId)) */) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsUser) * 16;
?>
<?php
//		$limit_page = $componentParams->get('limit_to_page');
		$limit_page = null;
		$tmpId = portal\virgoUser::getParentInContext("portal\\virgoPage");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_page', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultUser->usr_pge__id = $tmpId;
//			}
			if (!is_null($resultUser->getPgeId())) {
				$parentId = $resultUser->getPgeId();
				$parentValue = portal\virgoPage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="usr_page_<?php echo $resultUser->getId() ?>" name="usr_page_<?php echo $resultUser->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_USER_PAGE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_page) && trim($limit_page) != "") {
		$whereList = $whereList . " pge_id ";
		if (trim($limit_page) == "page_title") {
			$limit_page = "SELECT pge_id FROM prt_pages WHERE pge_" . $limit_page . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_page = \"$limit_page\";");
		$whereList = $whereList . " IN (" . $limit_page . ") ";
	}						
	$parentCount = portal\virgoPage::getVirgoListSize($whereList);
	$showAjaxusr = P('show_form_page', "1") == "3" || $parentCount > 100;
	if (!$showAjaxusr) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_page_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="usr_page_<?php echo !is_null($resultUser->getId()) ? $resultUser->getId() : '' ?>" 
							name="usr_page_<?php echo !is_null($resultUser->getId()) ? $resultUser->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_page) || trim($limit_page) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPage = portal\virgoPage::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPage)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultUser->getPgeId()) && $id == $resultUser->getPgeId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultUser->getPgeId();
				$parentPage = new portal\virgoPage();
				$parentValue = $parentPage->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="usr_page_<?php echo $resultUser->getId() ?>" name="usr_page_<?php echo $resultUser->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="usr_page_dropdown_<?php echo $resultUser->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#usr_page_dropdown_<?php echo $resultUser->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Page",
			virgo_field_name: "page",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#usr_page_<?php echo $resultUser->getId() ?>').val(ui.item.value);
				  	$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').val(ui.item.label);
				  	$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#usr_page_<?php echo $resultUser->getId() ?>').val('');
				$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#usr_page_dropdown_<?php echo $resultUser->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	if (isset($context["pge"])) {
		$parentValue = $context["pge"];
	} else {
		$parentValue = $resultUser->usr_pge_id;
	}
	
?>
				<input type="hidden" id="usr_page_<?php echo $resultUser->usr_id ?>" name="usr_page_<?php echo $resultUser->usr_id ?>" value="<?php echo $parentValue ?>">
<?php
	} 
?>
				<td>
<?php
	if (isset($idsToCorrect[$resultUser->usr_id])) {
		$errorMessage = $idsToCorrect[$resultUser->usr_id];
?>
					<div class="error">
						<?php echo $errorMessage ?>
					</div>
<?php
	}
?>
				</td>
				<td nowrap class="actions" align="right">

				</td>
			</tr>

<?php
				}
PROFILE('rows rendering');
?>		
				<tr>
					<td colspan="99" align="center">
						<input type="hidden" name="virgo_changed" value="N">
						<input type="hidden" name="virgo_validate_new" value="<?php echo R('virgo_validate_new', "N") ?>">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('StoreSelected')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_storeselected inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='StoreSelected';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('STORE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>

<?php
			if ($this->canExecute("add")) {
?>						
						<div id="add_button" class="button_wrapper" style="display: <?php echo R('virgo_validate_new', "N") == "N" ? 'inline-block' : 'none' ?>" ><input type="button" class="button" value="<?php echo T('ADD') ?>" onclick="this.form.virgo_validate_new.value='Y'; document.getElementById('virgo_tr_id_0').style.display='table-row'; document.getElementById('remove_button').style.display='inline-block'; document.getElementById('add_button').style.display='none';" onmousedown="this.className='button_pressed'" onmouseup="this.className='button'" onmouseout="this.className='button'"><div class="button_right"></div></div>
						<div id="remove_button" class="button_wrapper" style="display: <?php echo R('virgo_validate_new', "N") == "N" ? 'none' : 'inline-block' ?>" ><input type="button" class="button" value="<?php echo T('REMOVE') ?>" onclick="this.form.virgo_validate_new.value='N'; document.getElementById('virgo_tr_id_0').style.display='none'; document.getElementById('add_button').style.display='inline-block'; document.getElementById('remove_button').style.display='none';" onmousedown="this.className='button_pressed'" onmouseup="this.className='button'" onmouseout="this.className='button'"><div class="button_right"></div></div>
<?php
			}
?>						
 <div class="button_wrapper button_wrapper_close inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Close';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div>					</td>
				</tr>
		</table>
	</form>
<?php
	} else {
		$virgoShowReturn = true;
?>
		<div class="<?php echo $userDisplayMode ?>">
<?php
?>
			<div class="buttons form-actions">
<?php
				if ($virgoShowReturn) {
?>
 <div class="button_wrapper button_wrapper_close inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Close';
	_pSF(form, 'usr_id_<?php echo $this->getId() ?>', '<?php echo isset($resultUser) ? (is_array($resultUser) ? $resultUser['usr_id'] : $resultUser->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php
				}
?>
			</div>
		</div>
<?php
	}
} 
?>


		</div>
	</div>
</div>
<div style="display: none; background-color:#FFFFFF; border:1px solid #000000; font-size:10px; margin:10px 0; padding:10px;"; id="extraFilesInfo_prt_user" style="font-size: 12px; " onclick="document.getElementById('extraFilesInfo_prt_user').style.display='none';">
<table><tr><td valign="top">
<table collspacing="2" collpadding="1">
	<tr>
		<td colspan="2">
			<b>Web:</b>
		</td>
	</tr>
</table>
</td>
<td valign="top">
<table>
	<tr>
		<td colspan="2">
			<b>Bean:</b>
		</td>
	</tr>
<?php
	$infos = virgoUser::getExtraFilesInfo();
	foreach ($infos as $fileName => $date) {
?>
	<tr>
		<td align="right">
			<?php echo $fileName ?>
		</td>
		<td align="left">
			<?php echo $date ?>
		</td>
	</tr>
<?php
	}
?>
</table>
</td></tr></table>
</div>
<?php 
		if ($underConstruction == "1" && !is_null($user) && $user->username == "admin") {
?>
		<div style="background-color: #FFFF00; border: 1px dashed; color: #111111; font-family: monospace; font-size: 1.2em; font-weight: bold; margin: 0; padding: 2px; text-align: center;">
			Komponent w trakcie przebudowy.
		</div>
<?php
	}
?>


