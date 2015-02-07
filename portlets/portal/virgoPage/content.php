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
//	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'controller.php');
//	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php');
//	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php');
	$componentParams = null; //&JComponentHelper::getParams('com_prt_page');
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
<link rel="stylesheet" href="<?php echo $live_site ?>/components/com_prt_page/portal.css" type="text/css" /> 
<?php
	}
?>
<?php
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'prt_pge.css')) {
?>
<link rel="stylesheet" href="<?php echo $_SESSION['portal_url'] ?>/portlets/portal/virgoPage/prt_pge.css" type="text/css" /> 
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
<div class="virgo_container_portal virgo_container_entity_page" style="border: none;">
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
			$resultPage = virgoPage::createGuiAware();
			$contextId = $resultPage->getContextId();
			if (isset($contextId)) {
				if (virgoPage::getDisplayMode() != "CREATE" || R('portlet_action') == "Duplicate") {
					$resultPage->load($contextId);
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
		if ($className == "virgoPage") {
			$masterObject = new $className();
			$tmpId = $masterObject->getRemoteContextId($masterPobId);
			if (isset($tmpId)) {
				$resultPage = new virgoPage($tmpId);
				virgoPage::setDisplayMode("FORM");
			} else {
				$resultPage = new virgoPage();
				virgoPage::setDisplayMode("CREATE");
			}
		}
	} else {
		if (P('form_only', "0") == "5") {
			if (is_null($resultPage->getId())) { 
				if (P('only_private_records', "0") == "1") {
					$allPrivateRecords = $resultPage->selectAll();
					if (sizeof($allPrivateRecords) > 0) {
						$resultPage = new virgoPage($allPrivateRecords[0]['pge_id']);
						$resultPage->putInContext(false);
					} else {
						$resultPage = new virgoPage();
					}
				} else {
					$customSQL = P('custom_sql_condition');
					if (isset($customSQL) && trim($customSQL) != '') {
						$currentUser = virgoUser::getUser();
						$currentPage = virgoPage::getCurrentPage();
						eval("\$customSQL = \"$customSQL\";");
						$records = $resultPage->selectAll($customSQL);
						if (sizeof($records) > 0) {
							$resultPage = new virgoPage($records[0]['pge_id']);
							$resultPage->putInContext(false);
						} else {
							$resultPage = new virgoPage();
						}
					} else {
						$resultPage = new virgoPage();
					}
				}
			}
		} elseif (P('form_only', "0") == "6") {
			$resultPage = new virgoPage(virgoUser::getUserId());
			$resultPage->putInContext(false);
		}
	}
?>
<?php
		if (isset($includeError) && $includeError == 1) {
			$resultPage = new virgoPage();
		}
?>
<?php
	$pageDisplayMode = virgoPage::getDisplayMode();
//	if ($pageDisplayMode == "" || $pageDisplayMode == "TABLE") {
//		$resultPage = $resultPage->portletActionForm();
//	}
?>
		<div class="form">
<?php
		$parentContextInfos = $resultPage->getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
//			$whereClausePage = $whereClausePage . ' AND ' . $parentContextInfo['condition'];
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
		$criteriaPage = $resultPage->getCriteria();
		$countTmp = 0;
		if (isset($criteriaPage["title"])) {
			$fieldCriteriaTitle = $criteriaPage["title"];
			if ($fieldCriteriaTitle["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaTitle["value"];
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
		if (isset($criteriaPage["alias"])) {
			$fieldCriteriaAlias = $criteriaPage["alias"];
			if ($fieldCriteriaAlias["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaAlias["value"];
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
		if (isset($criteriaPage["default"])) {
			$fieldCriteriaDefault = $criteriaPage["default"];
			if ($fieldCriteriaDefault["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaDefault["value"];
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
		if (isset($criteriaPage["order"])) {
			$fieldCriteriaOrder = $criteriaPage["order"];
			if ($fieldCriteriaOrder["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaOrder["value"];
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
		if (isset($criteriaPage["path"])) {
			$fieldCriteriaPath = $criteriaPage["path"];
			if ($fieldCriteriaPath["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaPath["value"];
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
		if (isset($criteriaPage["template"])) {
			$parentCriteria = $criteriaPage["template"];
			if ($parentCriteria["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				if (isset($parentCriteria["value"]) && $parentCriteria["value"] != "") {
					$parentValue = $parentCriteria["value"];
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPage["page"])) {
			$parentCriteria = $criteriaPage["page"];
			if ($parentCriteria["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				if (isset($parentCriteria["value"]) && $parentCriteria["value"] != "") {
					$parentValue = $parentCriteria["value"];
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPage["portal"])) {
			$parentCriteria = $criteriaPage["portal"];
			if ($parentCriteria["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				if (isset($parentCriteria["value"]) && $parentCriteria["value"] != "") {
					$parentValue = $parentCriteria["value"];
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPage["portlet_object"])) {
			$countTmp = $countTmp + 1;
		}
		if (is_null($criteriaPage) || sizeof($criteriaPage) == 0 || $countTmp == 0) {
		} else {
?>
			<input type="hidden" name="virgo_filter_column"/>
			<table class="db_criteria_record">
				<tr>
					<td colspan="3" class="db_criteria_message"><?php echo T('SEARCH_CRITERIA') ?></td>
				</tr>
<?php
			if (isset($criteriaPage["title"])) {
				$fieldCriteriaTitle = $criteriaPage["title"];
				if ($fieldCriteriaTitle["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Title') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaTitle["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaTitle["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='title';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaTitle["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Title') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='title';
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
			if (isset($criteriaPage["alias"])) {
				$fieldCriteriaAlias = $criteriaPage["alias"];
				if ($fieldCriteriaAlias["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Alias') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaAlias["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaAlias["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='alias';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaAlias["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Alias') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='alias';
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
			if (isset($criteriaPage["default"])) {
				$fieldCriteriaDefault = $criteriaPage["default"];
				if ($fieldCriteriaDefault["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Default') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaDefault["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaDefault["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='default';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaDefault["value"];
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
					<?php echo T('Default') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='default';
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
			if (isset($criteriaPage["order"])) {
				$fieldCriteriaOrder = $criteriaPage["order"];
				if ($fieldCriteriaOrder["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Order') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaOrder["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaOrder["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='order';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaOrder["value"];
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
					<?php echo T('Order') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='order';
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
			if (isset($criteriaPage["path"])) {
				$fieldCriteriaPath = $criteriaPage["path"];
				if ($fieldCriteriaPath["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Path') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaPath["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaPath["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='path';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaPath["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Path') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='path';
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
			if (isset($criteriaPage["template"])) {
				$parentCriteria = $criteriaPage["template"];
				if ($parentCriteria["is_null"] == 1) {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Template') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo T('EMPTY_VALUE') ?>				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='template';
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
					<?php echo T('template') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='template';
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
			if (isset($criteriaPage["page"])) {
				$parentCriteria = $criteriaPage["page"];
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
			if (isset($criteriaPage["portal"])) {
				$parentCriteria = $criteriaPage["portal"];
				if ($parentCriteria["is_null"] == 1) {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Portal') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo T('EMPTY_VALUE') ?>				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='portal';
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
					<?php echo T('portal') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='portal';
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
		if (isset($criteriaPage["portlet_object"])) {
			$parentIds = $criteriaPage["portlet_object"];
		}
		if (isset($parentIds) && isset($parentIds['ids'])) {
			$selectedIds = $parentIds['ids'];
			$renderCriteria = "";
			foreach ($selectedIds as $id) {
				$obj = new portal\virgoPortletObject($id['id']);
				$renderCriteria = ($renderCriteria == "" ? "" : $renderCriteria . ", ") . $obj->getVirgoTitle();
			}
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Portlet objects') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='portlet_object';
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
	if (isset($resultPage)) {
		$tmpId = is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
?>
<?php
	if ($pageDisplayMode != "TABLE") {
		$tmpAction = R('portlet_action');
		if (
			$tmpAction == "Store" 
			|| $tmpAction == "Apply"
			|| $tmpAction == "StoreAndClear"
			|| $tmpAction == "BackFromParent"
			|| $tmpAction == "StoreNewPortal"
		) {
			$invokedPortletId = R('invoked_portlet_object_id');
			if (is_null($invokedPortletId) || trim($invokedPortletId) == "") {
				$invokedPortletId = R('legacy_invoked_portlet_object_id');
			}
			$pob = $resultPage->getMyPortletObject();
			$reloadFromRequest = $pob->getPortletSessionValue('reload_from_request', '0');
			if (isset($invokedPortletId) && $invokedPortletId == $_SESSION['current_portlet_object_id'] && isset($reloadFromRequest) && $reloadFromRequest == "1") { 
				$pob->setPortletSessionValue('reload_from_request', '0');
				$resultPage->loadFromRequest();
			} else {
				if (P('form_only', "0") == "1" && isset($contextId)) {
					if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
						require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'create_store_message.php');
						$pageDisplayMode = "-empty-";
					}
				}
			}
		}
	}
if (!$resultPage->hideContentDueToNoParentSelected()) {
	$formsInTable = (P('forms_rendering', "false") == "true");
	if (!$formsInTable) {
		$floatingFields = (P('forms_rendering', "false") == "float" || P('forms_rendering', "false") == "float-grid");
		$floatingGridFields = (P('forms_rendering', "false") == "float-grid");
	}
/* MILESTONE 1.1 Form */
	$tabIndex = 1;
	$parentAjaxRendered = "0";
	if ($pageDisplayMode == "FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_page") {
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
<?php echo T('PAGE') ?>:</legend>
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
	if (P('show_form_title', "1") == "1" || P('show_form_title', "1") == "2") {
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
						class="fieldlabel  obligatory   title varchar" 
						for="pge_title_<?php echo $resultPage->getId() ?>"
					>* <?php echo T('TITLE') ?>
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
	if (P('show_form_title', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPage->getTitle(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="title" name="pge_title_<?php echo $resultPage->getId() ?>" value="<?php echo htmlentities($resultPage->getTitle(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pge_title_<?php echo $resultPage->getId() ?>" 
							name="pge_title_<?php echo $resultPage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPage->getTitle(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_TITLE');
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
$('#pge_title_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (P('show_form_alias', "1") == "1" || P('show_form_alias', "1") == "2") {
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
						class="fieldlabel  obligatory   alias varchar" 
						for="pge_alias_<?php echo $resultPage->getId() ?>"
					>* <?php echo T('ALIAS') ?>
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
	if (P('show_form_alias', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPage->getAlias(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="alias" name="pge_alias_<?php echo $resultPage->getId() ?>" value="<?php echo htmlentities($resultPage->getAlias(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pge_alias_<?php echo $resultPage->getId() ?>" 
							name="pge_alias_<?php echo $resultPage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPage->getAlias(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_ALIAS');
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
$('#pge_alias_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (P('show_form_default', "1") == "1" || P('show_form_default', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_default_obligatory', "0") == "1" ? " obligatory " : "" ?>   default bool" 
						for="pge_default_<?php echo $resultPage->getId() ?>"
					> <?php echo P('show_form_default_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('DEFAULT') ?>
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
	if (P('show_form_default', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="default"
>
<?php
	if (is_null($resultPage->pge_default) || $resultPage->pge_default == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultPage->pge_default == 1) {
		$booleanValue = T("YES");
	} elseif ($resultPage->pge_default === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
<select class="inputbox" id="pge_default_<?php echo $resultPage->getId() ?>" name="pge_default_<?php echo $resultPage->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_DEFAULT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPage->getDefault() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPage->getDefault() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPage->getDefault()) || $resultPage->getDefault() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pge_default_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (P('show_form_order', "1") == "1" || P('show_form_order', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_order_obligatory', "0") == "1" ? " obligatory " : "" ?>   order integer" 
						for="pge_order_<?php echo $resultPage->getId() ?>"
					> <?php echo P('show_form_order_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('ORDER') ?>
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
	if (P('show_form_order', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPage->getOrder(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="order" name="pge_order_<?php echo $resultPage->getId() ?>" value="<?php echo htmlentities($resultPage->getOrder(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_order_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pge_order_<?php echo $resultPage->getId() ?>" 
							name="pge_order_<?php echo $resultPage->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPage->getOrder(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_ORDER');
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
$('#pge_order_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (P('show_form_path', "1") == "1" || P('show_form_path', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_path_obligatory', "0") == "1" ? " obligatory " : "" ?>   path varchar" 
						for="pge_path_<?php echo $resultPage->getId() ?>"
					> <?php echo P('show_form_path_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('PATH') ?>
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
	if (P('show_form_path', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPage->getPath(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="path" name="pge_path_<?php echo $resultPage->getId() ?>" value="<?php echo htmlentities($resultPage->getPath(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_path_obligatory', "0") == "1" ? " obligatory " : "" ?>   long  " 
							type="text"
							id="pge_path_<?php echo $resultPage->getId() ?>" 
							name="pge_path_<?php echo $resultPage->getId() ?>"
							maxlength="2000"
							size="50" 
							value="<?php echo htmlentities($resultPage->getPath(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_PATH');
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
$('#pge_path_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (class_exists('portal\virgoTemplate') && ((P('show_form_template', "1") == "1" || P('show_form_template', "1") == "2" || P('show_form_template', "1") == "3") && !isset($context["tmp"]))) {
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
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_form_template_obligatory') == "1" ? " obligatory " : "" ?> " for="pge_template_<?php echo isset($resultPage->pge_id) ? $resultPage->pge_id : '' ?>">
<?php echo P('show_form_template_obligatory') == "1" ? " * " : "" ?>
<?php echo T('TEMPLATE') ?> <?php echo T('') ?>
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
//		$limit_template = $componentParams->get('limit_to_template');
		$limit_template = null;
		$tmpId = portal\virgoPage::getParentInContext("portal\\virgoTemplate");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_template', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_tmp__id = $tmpId;
//			}
			if (!is_null($resultPage->getTmpId())) {
				$parentId = $resultPage->getTmpId();
				$parentValue = portal\virgoTemplate::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_template_<?php echo $resultPage->getId() ?>" name="pge_template_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<script type="text/javascript">
var arrayTemplate2Portal = new Array();

<?php
	$query = " SELECT DISTINCT prt_tmp_id AS parent_id FROM prt_portals "; // plus ograniczenia skonfigurowane
	$rows = QR($query);
	$rowsParent = $rows;
	foreach ($rowsParent as $rowParent) {
		if (!is_null($rowParent['parent_id'])) {
?>
	var arrayTemplate<?php echo $rowParent['parent_id'] ?>= new Array();	
<?php
			$query = " SELECT prt_id AS id, prt_virgo_title AS value FROM prt_portals WHERE prt_tmp_id = " . $rowParent['parent_id']; // plus ograniczenia skonfigurowane
	$rows = QR($query);
			foreach ($rows as $row) {
?>
	arrayTemplate<?php echo $rowParent['parent_id'] ?>['<?php echo $row["id"] ?>'] = '<?php echo $row["value"] ?>';	
<?php
			}
?>
	arrayTemplate2Portal[<?php echo $rowParent['parent_id'] ?>] = arrayTemplate<?php echo $rowParent['parent_id'] ?>;
		
<?php
		}
	}
?>

function addOptionPortal(select, optionText, optionValue, selectedValue) {
	var newOption = document.createElement('option');
	newOption.text = optionText;
	newOption.value = optionValue;
	if (optionValue == selectedValue) {
		newOption.selected = true;
	}
	try {
		select.add(newOption, null);
	} catch (ex) {
		select.add(newOption);
	}
}

function displayArrayPortal(select, arrayToShow, selectedValue) {
	select.length = 0;
	addOptionPortal(select, '', '', selectedValue);
	for (var id in arrayToShow){ 
		addOptionPortal(select, arrayToShow[id], id, selectedValue);
	} 
}

function updatePortal(parentId, childrenListId, selectedValue) {
	// alert('test: ' + parentId + ' '  + childrenListId);
	var childrenList = document.getElementById(childrenListId);
	if (childrenList.tagName.toUpperCase() == "SELECT") {
		if (childrenList) {
			var arrayToShow = arrayTemplate2Portal[parentId];
			displayArrayPortal(childrenList, arrayToShow, selectedValue);
		}
	}
}
</script>
<?php
	$hint = TE('HINT_PAGE_TEMPLATE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_template) && trim($limit_template) != "") {
		$whereList = $whereList . " tmp_id ";
		if (trim($limit_template) == "page_title") {
			$limit_template = "SELECT tmp_id FROM prt_templates WHERE tmp_" . $limit_template . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_template = \"$limit_template\";");
		$whereList = $whereList . " IN (" . $limit_template . ") ";
	}						
	$parentCount = portal\virgoTemplate::getVirgoListSize($whereList);
	$showAjaxpge = P('show_form_template', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_template_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="pge_template_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_template_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
<?php
	if (P('show_form_portal', "1") == "1") {
?>
								updatePortal(this.options[this.selectedIndex].value, 'pge_portal_<?php echo $resultPage->getId() ?>', <?php echo is_null($resultPage->getPortalId()) ? "null" : $resultPage->getPrtId() ?>);
<?php
	}
?>
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
			if (is_null($limit_template) || trim($limit_template) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsTemplate = portal\virgoTemplate::getVirgoList($whereList);
			while(list($id, $label)=each($resultsTemplate)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPage->getTmpId()) && $id == $resultPage->getTmpId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getTmpId();
				$parentTemplate = new portal\virgoTemplate();
				$parentValue = $parentTemplate->lookup($parentId);
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
	<input type="hidden" id="pge_template_<?php echo $resultPage->getId() ?>" name="pge_template_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="pge_template_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_template_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Template",
			virgo_field_name: "template",
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
					$('#pge_template_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_template_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (isset($context["tmp"])) {
		$parentValue = $context["tmp"];
	} else {
		$parentValue = $resultPage->pge_tmp_id;
	}
	
?>
				<input type="hidden" id="pge_template_<?php echo $resultPage->pge_id ?>" name="pge_template_<?php echo $resultPage->pge_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPage') && ((P('show_form_page', "1") == "1" || P('show_form_page', "1") == "2" || P('show_form_page', "1") == "3"))) {
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
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_form_page_obligatory') == "1" ? " obligatory " : "" ?> " for="pge_page_<?php echo isset($resultPage->pge_id) ? $resultPage->pge_id : '' ?>">
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
		$readOnly = "";
		if (isset($tmpId) || P('show_form_page', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_pge__id = $tmpId;
//			}
			if (!is_null($resultPage->getPgeId())) {
				$parentId = $resultPage->getPgeId();
				$parentValue = portal\virgoPage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_page_<?php echo $resultPage->getId() ?>" name="pge_page_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PAGE_PAGE');
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
	$showAjaxpge = P('show_form_page', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_page_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="pge_page_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_page_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
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
				echo (!is_null($resultPage->getPgeId()) && $id == $resultPage->getPgeId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getPgeId();
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
	<input type="hidden" id="pge_page_<?php echo $resultPage->getId() ?>" name="pge_page_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="pge_page_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_page_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
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
					$('#pge_page_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_page_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
		$parentValue = $resultPage->pge_pge_id;
	}
	
?>
				<input type="hidden" id="pge_page_<?php echo $resultPage->pge_id ?>" name="pge_page_<?php echo $resultPage->pge_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortal') && ((P('show_form_portal', "1") == "1" || P('show_form_portal', "1") == "2" || P('show_form_portal', "1") == "3") && !isset($context["prt"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="pge_portal_<?php echo isset($resultPage->pge_id) ? $resultPage->pge_id : '' ?>">
 *
<?php echo T('PORTAL') ?> <?php echo T('') ?>
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
//		$limit_portal = $componentParams->get('limit_to_portal');
		$limit_portal = null;
		$tmpId = portal\virgoPage::getParentInContext("portal\\virgoPortal");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portal', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_prt__id = $tmpId;
//			}
			if (!is_null($resultPage->getPrtId())) {
				$parentId = $resultPage->getPrtId();
				$parentValue = portal\virgoPortal::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_portal_<?php echo $resultPage->getId() ?>" name="pge_portal_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PAGE_PORTAL');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portal) && trim($limit_portal) != "") {
		$whereList = $whereList . " prt_id ";
		if (trim($limit_portal) == "page_title") {
			$limit_portal = "SELECT prt_id FROM prt_portals WHERE prt_" . $limit_portal . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portal = \"$limit_portal\";");
		$whereList = $whereList . " IN (" . $limit_portal . ") ";
	}						
	$parentCount = portal\virgoPortal::getVirgoListSize($whereList);
	$showAjaxpge = P('show_form_portal', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pge_portal_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_portal_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
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
			if (is_null($limit_portal) || trim($limit_portal) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortal = portal\virgoPortal::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortal)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPage->getPrtId()) && $id == $resultPage->getPrtId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getPrtId();
				$parentPortal = new portal\virgoPortal();
				$parentValue = $parentPortal->lookup($parentId);
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
	<input type="hidden" id="pge_portal_<?php echo $resultPage->getId() ?>" name="pge_portal_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pge_portal_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_portal_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Portal",
			virgo_field_name: "portal",
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
					$('#pge_portal_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_portal_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="form">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddPortal')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addportal inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddPortal';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (isset($context["prt"])) {
		$parentValue = $context["prt"];
	} else {
		$parentValue = $resultPage->pge_prt_id;
	}
	
?>
				<input type="hidden" id="pge_portal_<?php echo $resultPage->pge_id ?>" name="pge_portal_<?php echo $resultPage->pge_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortal') && P('show_form_template', "1") == "1" && ((P('show_form_portal', "1") == "1" || P('show_form_portal', "1") == "2" || P('show_form_portal', "1") == "3") && !isset($context["prt"]))) {
?>
<script type="text/javascript">
<?php
	$tmpListId = null;
	$tmpListId = $resultPage->pge_tmp_id;
	if (!is_null($tmpListId)) {
?>
	updatePortal(<?php echo $tmpListId ?>, 'pge_portal_<?php echo $resultPage->pge_id ?>', <?php echo isset($resultPage->pge_prt_id) ? $resultPage->pge_prt_id : 'null' ?>); 
<?php
	}
?>
</script>
<?php
	}
?>

<?php
	if (class_exists('portal\virgoPermission') && P('show_form_permissions', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoPortletLocation') && P('show_form_portlet_locations', '1') == "1") {
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
					<label nowrap class="fieldlabel portletLocation" for="pge_portletLocation_<?php echo $resultPage->getId() ?>[]">
Portlet locations 
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
			$parentPortletObject = new portal\virgoPortletObject();
			$whereList = "";
			$resultsPortletObject = $parentPortletObject->getVirgoList($whereList);
			$currentConnections = $resultPage->getPortletLocations();
			$currentIds = array();
			foreach ($currentConnections as $currentConnection) {
				$currentIds[] = $currentConnection->getPortletObjectId();
			}
?>
<?php
	$inputMethod = P('n_m_children_input_portlet_location_', "select");
	if (is_null($inputMethod) || trim($inputMethod) == "") {
		$inputMethod = "select";
	}
	if ($inputMethod == "select") {
?>
						<select 
							class="inputbox" 
							id="pge_portletLocation_<?php echo $resultPage->pge_id ?>[]" 
							name="pge_portletLocation_<?php echo $resultPage->pge_id ?>[]" 
							multiple 
							size=<?php echo sizeof($resultsPortletObject) > 10 ? 10 : sizeof($resultsPortletObject) ?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
						>
<?php
			while (list($id, $label) = each($resultsPortletObject)) {
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
			reset($resultsPortletObject);
			while (list($id, $label) = each($resultsPortletObject)) {
?>
							<li class="parent_selection">
								<input 
									type="checkbox"
									class="inputbox checkbox"
									id="pge_portletLocation_<?php echo $resultPage->pge_id ?>[]" 
									name="pge_portletLocation_<?php echo $resultPage->pge_id ?>[]" 
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
						id="pge_portletLocation_<?php echo $resultPage->pge_id ?>" 
						name="pge_portletLocation_<?php echo $resultPage->pge_id ?>" 
						value="VIRGO_DONT_DELETE_N_M_CHILDREN"
					/>


<?php					
	}
?>
<?php
	if (class_exists('portal\virgoPage') && P('show_form_pages', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoUser') && P('show_form_users', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoRole') && P('show_form_roles', '1') == "1") {
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
	if (false) { //$componentParams->get('show_form_permissions') == "1") {
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
//	$componentParamsPermission = &JComponentHelper::getParams('com_prt_permission');
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
	if (false) { //$componentParamsPermission->get('show_table_view') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							View
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_edit') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Edit
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_configure') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Configure
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_action') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Action
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_execute') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Execute
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_role') == "1" && ($masterComponentName != "role" || is_null($contextId))) {
?>
				<td align="center" nowrap>Role </td>
<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_portlet_object') == "1" && ($masterComponentName != "portlet_object" || is_null($contextId))) {
?>
				<td align="center" nowrap>Portlet object </td>
<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$tmpPermission = new portal\virgoPermission();
				$resultsPermission = $tmpPermission->selectAll(' prm_pge_id = ' . $resultPage->pge_id);
				$idsToCorrect = $tmpPermission->getInvalidRecords();
				$index = 0;
				foreach ($resultsPermission as $resultPermission) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultPermission->prm_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultPermission->prm_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultPermission->prm_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultPermission->prm_id) ? 0 : $resultPermission->prm_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultPermission->prm_id;
		$resultPermission = new virgoPermission;
		$resultPermission->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsPermission->get('show_table_view') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 0;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
<select class="inputbox" id="prm_view_<?php echo $resultPermission->getId() ?>" name="prm_view_<?php echo $resultPermission->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_VIEW');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPermission->getView() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPermission->getView() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPermission->getView()) || $resultPermission->getView() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prm_view_<?php echo $resultPermission->getId() ?>').qtip({position: {
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
							id="view_<?php echo $resultPage->pge_id ?>" 
							name="view_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_view, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_edit') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 1;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
<select class="inputbox" id="prm_edit_<?php echo $resultPermission->getId() ?>" name="prm_edit_<?php echo $resultPermission->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_EDIT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPermission->getEdit() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPermission->getEdit() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPermission->getEdit()) || $resultPermission->getEdit() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prm_edit_<?php echo $resultPermission->getId() ?>').qtip({position: {
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
							id="edit_<?php echo $resultPage->pge_id ?>" 
							name="edit_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_edit, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_configure') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 2;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
<select class="inputbox" id="prm_configure_<?php echo $resultPermission->getId() ?>" name="prm_configure_<?php echo $resultPermission->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_CONFIGURE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPermission->getConfigure() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPermission->getConfigure() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPermission->getConfigure()) || $resultPermission->getConfigure() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prm_configure_<?php echo $resultPermission->getId() ?>').qtip({position: {
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
							id="configure_<?php echo $resultPage->pge_id ?>" 
							name="configure_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_configure, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_action') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 3;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_action_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prm_action_<?php echo $resultPermission->getId() ?>" 
							name="prm_action_<?php echo $resultPermission->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPermission->getAction(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_ACTION');
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
$('#prm_action_<?php echo $resultPermission->getId() ?>').qtip({position: {
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
							id="action_<?php echo $resultPage->pge_id ?>" 
							name="action_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_action, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_execute') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 4;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
<select class="inputbox" id="prm_execute_<?php echo $resultPermission->getId() ?>" name="prm_execute_<?php echo $resultPermission->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_EXECUTE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPermission->getExecute() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPermission->getExecute() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPermission->getExecute()) || $resultPermission->getExecute() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prm_execute_<?php echo $resultPermission->getId() ?>').qtip({position: {
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
							id="execute_<?php echo $resultPage->pge_id ?>" 
							name="execute_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_execute, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_role') == "1" && ($masterComponentName != "role" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPermission) * 5;
?>
<?php
//		$limit_role = $componentParams->get('limit_to_role');
		$limit_role = null;
		$tmpId = portal\virgoPage::getParentInContext("portal\\virgoRole");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_role', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPermission->prm_rle__id = $tmpId;
//			}
			if (!is_null($resultPermission->getRleId())) {
				$parentId = $resultPermission->getRleId();
				$parentValue = portal\virgoRole::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="prm_role_<?php echo $resultPermission->getId() ?>" name="prm_role_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PERMISSION_ROLE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_role) && trim($limit_role) != "") {
		$whereList = $whereList . " rle_id ";
		if (trim($limit_role) == "page_title") {
			$limit_role = "SELECT rle_id FROM prt_roles WHERE rle_" . $limit_role . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_role = \"$limit_role\";");
		$whereList = $whereList . " IN (" . $limit_role . ") ";
	}						
	$parentCount = portal\virgoRole::getVirgoListSize($whereList);
	$showAjaxprm = P('show_form_role', "1") == "3" || $parentCount > 100;
	if (!$showAjaxprm) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="prm_role_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
							name="prm_role_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
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
			if (is_null($limit_role) || trim($limit_role) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsRole = portal\virgoRole::getVirgoList($whereList);
			while(list($id, $label)=each($resultsRole)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPermission->getRleId()) && $id == $resultPermission->getRleId() ? "selected='selected'" : "");
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
				$parentId = $resultPermission->getRleId();
				$parentRole = new portal\virgoRole();
				$parentValue = $parentRole->lookup($parentId);
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
	<input type="hidden" id="prm_role_<?php echo $resultPermission->getId() ?>" name="prm_role_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="prm_role_dropdown_<?php echo $resultPermission->getId() ?>" 
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
        $( "#prm_role_dropdown_<?php echo $resultPermission->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Role",
			virgo_field_name: "role",
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
					$('#prm_role_<?php echo $resultPermission->getId() ?>').val(ui.item.value);
				  	$('#prm_role_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				  	$('#prm_role_dropdown_<?php echo $resultPermission->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#prm_role_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#prm_role_<?php echo $resultPermission->getId() ?>').val('');
				$('#prm_role_dropdown_<?php echo $resultPermission->getId() ?>').removeClass("locked");		
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
$('#pge_role_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (false) { //$componentParamsPermission->get('show_table_portlet_object') == "1" && ($masterComponentName != "portlet_object" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPermission) * 6;
?>
<?php
//		$limit_portlet_object = $componentParams->get('limit_to_portlet_object');
		$limit_portlet_object = null;
		$tmpId = portal\virgoPage::getParentInContext("portal\\virgoPortletObject");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portlet_object', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPermission->prm_pob__id = $tmpId;
//			}
			if (!is_null($resultPermission->getPobId())) {
				$parentId = $resultPermission->getPobId();
				$parentValue = portal\virgoPortletObject::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="prm_portletObject_<?php echo $resultPermission->getId() ?>" name="prm_portletObject_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PERMISSION_PORTLET_OBJECT');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portlet_object) && trim($limit_portlet_object) != "") {
		$whereList = $whereList . " pob_id ";
		if (trim($limit_portlet_object) == "page_title") {
			$limit_portlet_object = "SELECT pob_id FROM prt_portlet_objects WHERE pob_" . $limit_portlet_object . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portlet_object = \"$limit_portlet_object\";");
		$whereList = $whereList . " IN (" . $limit_portlet_object . ") ";
	}						
	$parentCount = portal\virgoPortletObject::getVirgoListSize($whereList);
	$showAjaxprm = P('show_form_portlet_object', "1") == "3" || $parentCount > 100;
	if (!$showAjaxprm) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_portlet_object_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="prm_portletObject_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
							name="prm_portletObject_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
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
			if (is_null($limit_portlet_object) || trim($limit_portlet_object) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortletObject = portal\virgoPortletObject::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortletObject)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPermission->getPobId()) && $id == $resultPermission->getPobId() ? "selected='selected'" : "");
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
				$parentId = $resultPermission->getPobId();
				$parentPortletObject = new portal\virgoPortletObject();
				$parentValue = $parentPortletObject->lookup($parentId);
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
	<input type="hidden" id="prm_portlet_object_<?php echo $resultPermission->getId() ?>" name="prm_portletObject_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="prm_portlet_object_dropdown_<?php echo $resultPermission->getId() ?>" 
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
        $( "#prm_portlet_object_dropdown_<?php echo $resultPermission->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "PortletObject",
			virgo_field_name: "portlet_object",
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
					$('#prm_portlet_object_<?php echo $resultPermission->getId() ?>').val(ui.item.value);
				  	$('#prm_portlet_object_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				  	$('#prm_portlet_object_dropdown_<?php echo $resultPermission->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#prm_portlet_object_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#prm_portlet_object_<?php echo $resultPermission->getId() ?>').val('');
				$('#prm_portlet_object_dropdown_<?php echo $resultPermission->getId() ?>').removeClass("locked");		
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
$('#pge_portlet_object_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
				$resultPermission = array();
?>		
			<tr id="virgo_tr_id_<?php echo $resultPermission->prm_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultPermission->prm_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultPermission->prm_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultPermission->prm_id) ? 0 : $resultPermission->prm_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultPermission->prm_id;
		$resultPermission = new virgoPermission;
		$resultPermission->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsPermission->get('show_table_view') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 0;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
<select class="inputbox" id="prm_view_<?php echo $resultPermission->getId() ?>" name="prm_view_<?php echo $resultPermission->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_VIEW');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPermission->getView() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPermission->getView() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPermission->getView()) || $resultPermission->getView() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prm_view_<?php echo $resultPermission->getId() ?>').qtip({position: {
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
							id="view_<?php echo $resultPage->pge_id ?>" 
							name="view_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_view, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_edit') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 1;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
<select class="inputbox" id="prm_edit_<?php echo $resultPermission->getId() ?>" name="prm_edit_<?php echo $resultPermission->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_EDIT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPermission->getEdit() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPermission->getEdit() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPermission->getEdit()) || $resultPermission->getEdit() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prm_edit_<?php echo $resultPermission->getId() ?>').qtip({position: {
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
							id="edit_<?php echo $resultPage->pge_id ?>" 
							name="edit_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_edit, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_configure') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 2;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
<select class="inputbox" id="prm_configure_<?php echo $resultPermission->getId() ?>" name="prm_configure_<?php echo $resultPermission->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_CONFIGURE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPermission->getConfigure() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPermission->getConfigure() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPermission->getConfigure()) || $resultPermission->getConfigure() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prm_configure_<?php echo $resultPermission->getId() ?>').qtip({position: {
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
							id="configure_<?php echo $resultPage->pge_id ?>" 
							name="configure_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_configure, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_action') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 3;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_action_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prm_action_<?php echo $resultPermission->getId() ?>" 
							name="prm_action_<?php echo $resultPermission->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPermission->getAction(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_ACTION');
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
$('#prm_action_<?php echo $resultPermission->getId() ?>').qtip({position: {
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
							id="action_<?php echo $resultPage->pge_id ?>" 
							name="action_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_action, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_execute') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 4;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
<select class="inputbox" id="prm_execute_<?php echo $resultPermission->getId() ?>" name="prm_execute_<?php echo $resultPermission->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_EXECUTE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPermission->getExecute() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPermission->getExecute() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPermission->getExecute()) || $resultPermission->getExecute() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prm_execute_<?php echo $resultPermission->getId() ?>').qtip({position: {
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
							id="execute_<?php echo $resultPage->pge_id ?>" 
							name="execute_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_execute, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_role') == "1" && ($masterComponentName != "role" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPermission) * 5;
?>
<?php
//		$limit_role = $componentParams->get('limit_to_role');
		$limit_role = null;
		$tmpId = portal\virgoPage::getParentInContext("portal\\virgoRole");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_role', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPermission->prm_rle__id = $tmpId;
//			}
			if (!is_null($resultPermission->getRleId())) {
				$parentId = $resultPermission->getRleId();
				$parentValue = portal\virgoRole::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="prm_role_<?php echo $resultPermission->getId() ?>" name="prm_role_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PERMISSION_ROLE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_role) && trim($limit_role) != "") {
		$whereList = $whereList . " rle_id ";
		if (trim($limit_role) == "page_title") {
			$limit_role = "SELECT rle_id FROM prt_roles WHERE rle_" . $limit_role . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_role = \"$limit_role\";");
		$whereList = $whereList . " IN (" . $limit_role . ") ";
	}						
	$parentCount = portal\virgoRole::getVirgoListSize($whereList);
	$showAjaxprm = P('show_form_role', "1") == "3" || $parentCount > 100;
	if (!$showAjaxprm) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="prm_role_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
							name="prm_role_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
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
			if (is_null($limit_role) || trim($limit_role) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsRole = portal\virgoRole::getVirgoList($whereList);
			while(list($id, $label)=each($resultsRole)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPermission->getRleId()) && $id == $resultPermission->getRleId() ? "selected='selected'" : "");
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
				$parentId = $resultPermission->getRleId();
				$parentRole = new portal\virgoRole();
				$parentValue = $parentRole->lookup($parentId);
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
	<input type="hidden" id="prm_role_<?php echo $resultPermission->getId() ?>" name="prm_role_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="prm_role_dropdown_<?php echo $resultPermission->getId() ?>" 
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
        $( "#prm_role_dropdown_<?php echo $resultPermission->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Role",
			virgo_field_name: "role",
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
					$('#prm_role_<?php echo $resultPermission->getId() ?>').val(ui.item.value);
				  	$('#prm_role_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				  	$('#prm_role_dropdown_<?php echo $resultPermission->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#prm_role_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#prm_role_<?php echo $resultPermission->getId() ?>').val('');
				$('#prm_role_dropdown_<?php echo $resultPermission->getId() ?>').removeClass("locked");		
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
$('#pge_role_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (false) { //$componentParamsPermission->get('show_table_portlet_object') == "1" && ($masterComponentName != "portlet_object" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPermission) * 6;
?>
<?php
//		$limit_portlet_object = $componentParams->get('limit_to_portlet_object');
		$limit_portlet_object = null;
		$tmpId = portal\virgoPage::getParentInContext("portal\\virgoPortletObject");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portlet_object', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPermission->prm_pob__id = $tmpId;
//			}
			if (!is_null($resultPermission->getPobId())) {
				$parentId = $resultPermission->getPobId();
				$parentValue = portal\virgoPortletObject::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="prm_portletObject_<?php echo $resultPermission->getId() ?>" name="prm_portletObject_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PERMISSION_PORTLET_OBJECT');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portlet_object) && trim($limit_portlet_object) != "") {
		$whereList = $whereList . " pob_id ";
		if (trim($limit_portlet_object) == "page_title") {
			$limit_portlet_object = "SELECT pob_id FROM prt_portlet_objects WHERE pob_" . $limit_portlet_object . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portlet_object = \"$limit_portlet_object\";");
		$whereList = $whereList . " IN (" . $limit_portlet_object . ") ";
	}						
	$parentCount = portal\virgoPortletObject::getVirgoListSize($whereList);
	$showAjaxprm = P('show_form_portlet_object', "1") == "3" || $parentCount > 100;
	if (!$showAjaxprm) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_portlet_object_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="prm_portletObject_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
							name="prm_portletObject_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
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
			if (is_null($limit_portlet_object) || trim($limit_portlet_object) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortletObject = portal\virgoPortletObject::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortletObject)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPermission->getPobId()) && $id == $resultPermission->getPobId() ? "selected='selected'" : "");
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
				$parentId = $resultPermission->getPobId();
				$parentPortletObject = new portal\virgoPortletObject();
				$parentValue = $parentPortletObject->lookup($parentId);
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
	<input type="hidden" id="prm_portlet_object_<?php echo $resultPermission->getId() ?>" name="prm_portletObject_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="prm_portlet_object_dropdown_<?php echo $resultPermission->getId() ?>" 
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
        $( "#prm_portlet_object_dropdown_<?php echo $resultPermission->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "PortletObject",
			virgo_field_name: "portlet_object",
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
					$('#prm_portlet_object_<?php echo $resultPermission->getId() ?>').val(ui.item.value);
				  	$('#prm_portlet_object_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				  	$('#prm_portlet_object_dropdown_<?php echo $resultPermission->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#prm_portlet_object_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#prm_portlet_object_<?php echo $resultPermission->getId() ?>').val('');
				$('#prm_portlet_object_dropdown_<?php echo $resultPermission->getId() ?>').removeClass("locked");		
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
$('#pge_portlet_object_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
				$tmpPermission->setInvalidRecords(null);
?>
<?php
	}
?>
<?php 
	if (false) { //$componentParams->get('show_form_pages') == "1") {
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
//	$componentParamsPage = &JComponentHelper::getParams('com_prt_page');
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_template/prt_template_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_page/prt_page_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portal/prt_portal_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_template/prt_template_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_page/prt_page_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portal/prt_portal_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_template/prt_template_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_page/prt_page_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portal/prt_portal_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_template/prt_template_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_page/prt_page_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portal/prt_portal_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_template/prt_template_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_page/prt_page_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portal/prt_portal_class.php");
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
	if (false) { //$componentParamsPage->get('show_table_title') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Title
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_alias') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Alias
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_default') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Default
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_order') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Order
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_path') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Path
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_template') == "1" && ($masterComponentName != "template" || is_null($contextId))) {
?>
				<td align="center" nowrap>Template </td>
<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_portal') == "1" && ($masterComponentName != "portal" || is_null($contextId))) {
?>
				<td align="center" nowrap>Portal </td>
<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$tmpPage = new portal\virgoPage();
				$resultsPage = $tmpPage->selectAll(' pge_pge_id = ' . $resultPage->pge_id);
				$idsToCorrect = $tmpPage->getInvalidRecords();
				$index = 0;
				foreach ($resultsPage as $resultPage) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultPage->pge_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultPage->pge_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultPage->pge_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultPage->pge_id) ? 0 : $resultPage->pge_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultPage->pge_id;
		$resultPage = new virgoPage;
		$resultPage->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsPage->get('show_table_title') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 0;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pge_title_<?php echo $resultPage->getId() ?>" 
							name="pge_title_<?php echo $resultPage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPage->getTitle(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_TITLE');
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
$('#pge_title_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="title_<?php echo $resultPage->pge_id ?>" 
							name="title_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_title, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_alias') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 1;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pge_alias_<?php echo $resultPage->getId() ?>" 
							name="pge_alias_<?php echo $resultPage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPage->getAlias(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_ALIAS');
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
$('#pge_alias_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="alias_<?php echo $resultPage->pge_id ?>" 
							name="alias_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_alias, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_default') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 2;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
<select class="inputbox" id="pge_default_<?php echo $resultPage->getId() ?>" name="pge_default_<?php echo $resultPage->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_DEFAULT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPage->getDefault() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPage->getDefault() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPage->getDefault()) || $resultPage->getDefault() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pge_default_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="default_<?php echo $resultPage->pge_id ?>" 
							name="default_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_default, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_order') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 3;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_order_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pge_order_<?php echo $resultPage->getId() ?>" 
							name="pge_order_<?php echo $resultPage->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPage->getOrder(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_ORDER');
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
$('#pge_order_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="order_<?php echo $resultPage->pge_id ?>" 
							name="order_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_order, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_path') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 4;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_path_obligatory', "0") == "1" ? " obligatory " : "" ?>   long  " 
							type="text"
							id="pge_path_<?php echo $resultPage->getId() ?>" 
							name="pge_path_<?php echo $resultPage->getId() ?>"
							maxlength="2000"
							size="50" 
							value="<?php echo htmlentities($resultPage->getPath(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_PATH');
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
$('#pge_path_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="path_<?php echo $resultPage->pge_id ?>" 
							name="path_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_path, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_template') == "1" && ($masterComponentName != "template" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPage) * 5;
?>
<?php
//		$limit_template = $componentParams->get('limit_to_template');
		$limit_template = null;
		$tmpId = portal\virgoPage::getParentInContext("portal\\virgoTemplate");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_template', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_tmp__id = $tmpId;
//			}
			if (!is_null($resultPage->getTmpId())) {
				$parentId = $resultPage->getTmpId();
				$parentValue = portal\virgoTemplate::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_template_<?php echo $resultPage->getId() ?>" name="pge_template_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<script type="text/javascript">
var arrayTemplate2Portal = new Array();

<?php
	$query = " SELECT DISTINCT prt_tmp_id AS parent_id FROM prt_portals "; // plus ograniczenia skonfigurowane
	$rows = QR($query);
	$rowsParent = $rows;
	foreach ($rowsParent as $rowParent) {
		if (!is_null($rowParent['parent_id'])) {
?>
	var arrayTemplate<?php echo $rowParent['parent_id'] ?>= new Array();	
<?php
			$query = " SELECT prt_id AS id, prt_virgo_title AS value FROM prt_portals WHERE prt_tmp_id = " . $rowParent['parent_id']; // plus ograniczenia skonfigurowane
	$rows = QR($query);
			foreach ($rows as $row) {
?>
	arrayTemplate<?php echo $rowParent['parent_id'] ?>['<?php echo $row["id"] ?>'] = '<?php echo $row["value"] ?>';	
<?php
			}
?>
	arrayTemplate2Portal[<?php echo $rowParent['parent_id'] ?>] = arrayTemplate<?php echo $rowParent['parent_id'] ?>;
		
<?php
		}
	}
?>

function addOptionPortal(select, optionText, optionValue, selectedValue) {
	var newOption = document.createElement('option');
	newOption.text = optionText;
	newOption.value = optionValue;
	if (optionValue == selectedValue) {
		newOption.selected = true;
	}
	try {
		select.add(newOption, null);
	} catch (ex) {
		select.add(newOption);
	}
}

function displayArrayPortal(select, arrayToShow, selectedValue) {
	select.length = 0;
	addOptionPortal(select, '', '', selectedValue);
	for (var id in arrayToShow){ 
		addOptionPortal(select, arrayToShow[id], id, selectedValue);
	} 
}

function updatePortal(parentId, childrenListId, selectedValue) {
	// alert('test: ' + parentId + ' '  + childrenListId);
	var childrenList = document.getElementById(childrenListId);
	if (childrenList.tagName.toUpperCase() == "SELECT") {
		if (childrenList) {
			var arrayToShow = arrayTemplate2Portal[parentId];
			displayArrayPortal(childrenList, arrayToShow, selectedValue);
		}
	}
}
</script>
<?php
	$hint = TE('HINT_PAGE_TEMPLATE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_template) && trim($limit_template) != "") {
		$whereList = $whereList . " tmp_id ";
		if (trim($limit_template) == "page_title") {
			$limit_template = "SELECT tmp_id FROM prt_templates WHERE tmp_" . $limit_template . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_template = \"$limit_template\";");
		$whereList = $whereList . " IN (" . $limit_template . ") ";
	}						
	$parentCount = portal\virgoTemplate::getVirgoListSize($whereList);
	$showAjaxpge = P('show_form_template', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_template_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="pge_template_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_template_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
<?php
	if (P('show_form_portal', "1") == "1") {
?>
								updatePortal(this.options[this.selectedIndex].value, 'pge_portal_<?php echo $resultPage->getId() ?>', <?php echo is_null($resultPage->getPortalId()) ? "null" : $resultPage->getPrtId() ?>);
<?php
	}
?>
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
			if (is_null($limit_template) || trim($limit_template) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsTemplate = portal\virgoTemplate::getVirgoList($whereList);
			while(list($id, $label)=each($resultsTemplate)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPage->getTmpId()) && $id == $resultPage->getTmpId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getTmpId();
				$parentTemplate = new portal\virgoTemplate();
				$parentValue = $parentTemplate->lookup($parentId);
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
	<input type="hidden" id="pge_template_<?php echo $resultPage->getId() ?>" name="pge_template_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="pge_template_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_template_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Template",
			virgo_field_name: "template",
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
					$('#pge_template_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_template_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (false) { //$componentParamsPage->get('show_table_portal') == "1" && ($masterComponentName != "portal" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPage) * 6;
?>
<?php
//		$limit_portal = $componentParams->get('limit_to_portal');
		$limit_portal = null;
		$tmpId = portal\virgoPage::getParentInContext("portal\\virgoPortal");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portal', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_prt__id = $tmpId;
//			}
			if (!is_null($resultPage->getPrtId())) {
				$parentId = $resultPage->getPrtId();
				$parentValue = portal\virgoPortal::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_portal_<?php echo $resultPage->getId() ?>" name="pge_portal_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PAGE_PORTAL');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portal) && trim($limit_portal) != "") {
		$whereList = $whereList . " prt_id ";
		if (trim($limit_portal) == "page_title") {
			$limit_portal = "SELECT prt_id FROM prt_portals WHERE prt_" . $limit_portal . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portal = \"$limit_portal\";");
		$whereList = $whereList . " IN (" . $limit_portal . ") ";
	}						
	$parentCount = portal\virgoPortal::getVirgoListSize($whereList);
	$showAjaxpge = P('show_form_portal', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pge_portal_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_portal_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
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
			if (is_null($limit_portal) || trim($limit_portal) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortal = portal\virgoPortal::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortal)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPage->getPrtId()) && $id == $resultPage->getPrtId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getPrtId();
				$parentPortal = new portal\virgoPortal();
				$parentValue = $parentPortal->lookup($parentId);
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
	<input type="hidden" id="pge_portal_<?php echo $resultPage->getId() ?>" name="pge_portal_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pge_portal_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_portal_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Portal",
			virgo_field_name: "portal",
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
					$('#pge_portal_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_portal_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="form">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddPortal')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addportal inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddPortal';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
				$resultPage = array();
?>		
			<tr id="virgo_tr_id_<?php echo $resultPage->pge_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultPage->pge_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultPage->pge_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultPage->pge_id) ? 0 : $resultPage->pge_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultPage->pge_id;
		$resultPage = new virgoPage;
		$resultPage->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsPage->get('show_table_title') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 0;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pge_title_<?php echo $resultPage->getId() ?>" 
							name="pge_title_<?php echo $resultPage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPage->getTitle(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_TITLE');
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
$('#pge_title_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="title_<?php echo $resultPage->pge_id ?>" 
							name="title_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_title, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_alias') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 1;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pge_alias_<?php echo $resultPage->getId() ?>" 
							name="pge_alias_<?php echo $resultPage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPage->getAlias(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_ALIAS');
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
$('#pge_alias_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="alias_<?php echo $resultPage->pge_id ?>" 
							name="alias_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_alias, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_default') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 2;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
<select class="inputbox" id="pge_default_<?php echo $resultPage->getId() ?>" name="pge_default_<?php echo $resultPage->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_DEFAULT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPage->getDefault() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPage->getDefault() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPage->getDefault()) || $resultPage->getDefault() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pge_default_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="default_<?php echo $resultPage->pge_id ?>" 
							name="default_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_default, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_order') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 3;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_order_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pge_order_<?php echo $resultPage->getId() ?>" 
							name="pge_order_<?php echo $resultPage->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPage->getOrder(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_ORDER');
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
$('#pge_order_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="order_<?php echo $resultPage->pge_id ?>" 
							name="order_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_order, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_path') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 4;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_path_obligatory', "0") == "1" ? " obligatory " : "" ?>   long  " 
							type="text"
							id="pge_path_<?php echo $resultPage->getId() ?>" 
							name="pge_path_<?php echo $resultPage->getId() ?>"
							maxlength="2000"
							size="50" 
							value="<?php echo htmlentities($resultPage->getPath(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_PATH');
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
$('#pge_path_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="path_<?php echo $resultPage->pge_id ?>" 
							name="path_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_path, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_template') == "1" && ($masterComponentName != "template" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPage) * 5;
?>
<?php
//		$limit_template = $componentParams->get('limit_to_template');
		$limit_template = null;
		$tmpId = portal\virgoPage::getParentInContext("portal\\virgoTemplate");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_template', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_tmp__id = $tmpId;
//			}
			if (!is_null($resultPage->getTmpId())) {
				$parentId = $resultPage->getTmpId();
				$parentValue = portal\virgoTemplate::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_template_<?php echo $resultPage->getId() ?>" name="pge_template_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<script type="text/javascript">
var arrayTemplate2Portal = new Array();

<?php
	$query = " SELECT DISTINCT prt_tmp_id AS parent_id FROM prt_portals "; // plus ograniczenia skonfigurowane
	$rows = QR($query);
	$rowsParent = $rows;
	foreach ($rowsParent as $rowParent) {
		if (!is_null($rowParent['parent_id'])) {
?>
	var arrayTemplate<?php echo $rowParent['parent_id'] ?>= new Array();	
<?php
			$query = " SELECT prt_id AS id, prt_virgo_title AS value FROM prt_portals WHERE prt_tmp_id = " . $rowParent['parent_id']; // plus ograniczenia skonfigurowane
	$rows = QR($query);
			foreach ($rows as $row) {
?>
	arrayTemplate<?php echo $rowParent['parent_id'] ?>['<?php echo $row["id"] ?>'] = '<?php echo $row["value"] ?>';	
<?php
			}
?>
	arrayTemplate2Portal[<?php echo $rowParent['parent_id'] ?>] = arrayTemplate<?php echo $rowParent['parent_id'] ?>;
		
<?php
		}
	}
?>

function addOptionPortal(select, optionText, optionValue, selectedValue) {
	var newOption = document.createElement('option');
	newOption.text = optionText;
	newOption.value = optionValue;
	if (optionValue == selectedValue) {
		newOption.selected = true;
	}
	try {
		select.add(newOption, null);
	} catch (ex) {
		select.add(newOption);
	}
}

function displayArrayPortal(select, arrayToShow, selectedValue) {
	select.length = 0;
	addOptionPortal(select, '', '', selectedValue);
	for (var id in arrayToShow){ 
		addOptionPortal(select, arrayToShow[id], id, selectedValue);
	} 
}

function updatePortal(parentId, childrenListId, selectedValue) {
	// alert('test: ' + parentId + ' '  + childrenListId);
	var childrenList = document.getElementById(childrenListId);
	if (childrenList.tagName.toUpperCase() == "SELECT") {
		if (childrenList) {
			var arrayToShow = arrayTemplate2Portal[parentId];
			displayArrayPortal(childrenList, arrayToShow, selectedValue);
		}
	}
}
</script>
<?php
	$hint = TE('HINT_PAGE_TEMPLATE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_template) && trim($limit_template) != "") {
		$whereList = $whereList . " tmp_id ";
		if (trim($limit_template) == "page_title") {
			$limit_template = "SELECT tmp_id FROM prt_templates WHERE tmp_" . $limit_template . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_template = \"$limit_template\";");
		$whereList = $whereList . " IN (" . $limit_template . ") ";
	}						
	$parentCount = portal\virgoTemplate::getVirgoListSize($whereList);
	$showAjaxpge = P('show_form_template', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_template_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="pge_template_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_template_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
<?php
	if (P('show_form_portal', "1") == "1") {
?>
								updatePortal(this.options[this.selectedIndex].value, 'pge_portal_<?php echo $resultPage->getId() ?>', <?php echo is_null($resultPage->getPortalId()) ? "null" : $resultPage->getPrtId() ?>);
<?php
	}
?>
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
			if (is_null($limit_template) || trim($limit_template) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsTemplate = portal\virgoTemplate::getVirgoList($whereList);
			while(list($id, $label)=each($resultsTemplate)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPage->getTmpId()) && $id == $resultPage->getTmpId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getTmpId();
				$parentTemplate = new portal\virgoTemplate();
				$parentValue = $parentTemplate->lookup($parentId);
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
	<input type="hidden" id="pge_template_<?php echo $resultPage->getId() ?>" name="pge_template_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="pge_template_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_template_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Template",
			virgo_field_name: "template",
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
					$('#pge_template_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_template_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (false) { //$componentParamsPage->get('show_table_portal') == "1" && ($masterComponentName != "portal" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPage) * 6;
?>
<?php
//		$limit_portal = $componentParams->get('limit_to_portal');
		$limit_portal = null;
		$tmpId = portal\virgoPage::getParentInContext("portal\\virgoPortal");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portal', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_prt__id = $tmpId;
//			}
			if (!is_null($resultPage->getPrtId())) {
				$parentId = $resultPage->getPrtId();
				$parentValue = portal\virgoPortal::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_portal_<?php echo $resultPage->getId() ?>" name="pge_portal_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PAGE_PORTAL');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portal) && trim($limit_portal) != "") {
		$whereList = $whereList . " prt_id ";
		if (trim($limit_portal) == "page_title") {
			$limit_portal = "SELECT prt_id FROM prt_portals WHERE prt_" . $limit_portal . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portal = \"$limit_portal\";");
		$whereList = $whereList . " IN (" . $limit_portal . ") ";
	}						
	$parentCount = portal\virgoPortal::getVirgoListSize($whereList);
	$showAjaxpge = P('show_form_portal', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pge_portal_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_portal_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
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
			if (is_null($limit_portal) || trim($limit_portal) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortal = portal\virgoPortal::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortal)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPage->getPrtId()) && $id == $resultPage->getPrtId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getPrtId();
				$parentPortal = new portal\virgoPortal();
				$parentValue = $parentPortal->lookup($parentId);
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
	<input type="hidden" id="pge_portal_<?php echo $resultPage->getId() ?>" name="pge_portal_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pge_portal_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_portal_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Portal",
			virgo_field_name: "portal",
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
					$('#pge_portal_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_portal_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="form">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddPortal')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addportal inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddPortal';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
				$tmpPage->setInvalidRecords(null);
?>
<?php
	}
?>
<?php 
	if (false) { //$componentParams->get('show_form_users') == "1") {
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
//	$componentParamsUser = &JComponentHelper::getParams('com_prt_user');
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_page/prt_page_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_page/prt_page_class.php");
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
	if (false) { //$componentParamsUser->get('show_table_username') == "1") {
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
	if (false) { //$componentParamsUser->get('show_table_password') == "1") {
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
	if (false) { //$componentParamsUser->get('show_table_email') == "1") {
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
	if (false) { //$componentParamsUser->get('show_table_first_name') == "1") {
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
	if (false) { //$componentParamsUser->get('show_table_last_name') == "1") {
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
	if (false) { //$componentParamsUser->get('show_table_session_id') == "1") {
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
	if (false) { //$componentParamsUser->get('show_table_ip') == "1") {
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
	if (false) { //$componentParamsUser->get('show_table_logged_in') == "1") {
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
	if (false) { //$componentParamsUser->get('show_table_last_successful_login') == "1") {
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
	if (false) { //$componentParamsUser->get('show_table_last_failed_login') == "1") {
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
	if (false) { //$componentParamsUser->get('show_table_last_logout') == "1") {
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
	if (false) { //$componentParamsUser->get('show_table_user_agent') == "1") {
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
	if (false) { //$componentParamsUser->get('show_table_token') == "1") {
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
	if (false) { //$componentParamsUser->get('show_table_unidentified') == "1") {
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
	if (false) { //$componentParamsUser->get('show_table_confirmed') == "1") {
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
	if (false) { //$componentParamsUser->get('show_table_accepted') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Accepted
						</span>
				</td>

<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$tmpUser = new portal\virgoUser();
				$resultsUser = $tmpUser->selectAll(' usr_pge_id = ' . $resultPage->pge_id);
				$idsToCorrect = $tmpUser->getInvalidRecords();
				$index = 0;
				foreach ($resultsUser as $resultUser) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultUser->usr_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultUser->usr_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultUser->usr_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultUser->usr_id) ? 0 : $resultUser->usr_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultUser->usr_id;
		$resultUser = new virgoUser;
		$resultUser->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsUser->get('show_table_username') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 0;
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
	} else {
?> 
						<input
							type="hidden"
							id="username_<?php echo $resultPage->pge_id ?>" 
							name="username_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_username, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_password') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 1;
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
	} else {
?> 
						<input
							type="hidden"
							id="password_<?php echo $resultPage->pge_id ?>" 
							name="password_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_password, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_email') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 2;
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
	} else {
?> 
						<input
							type="hidden"
							id="email_<?php echo $resultPage->pge_id ?>" 
							name="email_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_email, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_first_name') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 3;
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
	} else {
?> 
						<input
							type="hidden"
							id="firstName_<?php echo $resultPage->pge_id ?>" 
							name="firstName_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_first_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_last_name') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 4;
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
	} else {
?> 
						<input
							type="hidden"
							id="lastName_<?php echo $resultPage->pge_id ?>" 
							name="lastName_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_last_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_session_id') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 5;
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
	} else {
?> 
						<input
							type="hidden"
							id="sessionId_<?php echo $resultPage->pge_id ?>" 
							name="sessionId_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_session_id, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_ip') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 6;
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
	} else {
?> 
						<input
							type="hidden"
							id="ip_<?php echo $resultPage->pge_id ?>" 
							name="ip_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_ip, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_logged_in') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 7;
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
	} else {
?> 
						<input
							type="hidden"
							id="loggedIn_<?php echo $resultPage->pge_id ?>" 
							name="loggedIn_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_logged_in, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_last_successful_login') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 8;
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
	} else {
?> 
						<input
							type="hidden"
							id="lastSuccessfulLogin_<?php echo $resultPage->pge_id ?>" 
							name="lastSuccessfulLogin_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_last_successful_login, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_last_failed_login') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 9;
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
	} else {
?> 
						<input
							type="hidden"
							id="lastFailedLogin_<?php echo $resultPage->pge_id ?>" 
							name="lastFailedLogin_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_last_failed_login, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_last_logout') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 10;
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
	} else {
?> 
						<input
							type="hidden"
							id="lastLogout_<?php echo $resultPage->pge_id ?>" 
							name="lastLogout_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_last_logout, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_user_agent') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 11;
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
	} else {
?> 
						<input
							type="hidden"
							id="userAgent_<?php echo $resultPage->pge_id ?>" 
							name="userAgent_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_user_agent, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_token') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 12;
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
	} else {
?> 
						<input
							type="hidden"
							id="token_<?php echo $resultPage->pge_id ?>" 
							name="token_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_token, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_unidentified') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 13;
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
	} else {
?> 
						<input
							type="hidden"
							id="unidentified_<?php echo $resultPage->pge_id ?>" 
							name="unidentified_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_unidentified, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_confirmed') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 14;
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
	} else {
?> 
						<input
							type="hidden"
							id="confirmed_<?php echo $resultPage->pge_id ?>" 
							name="confirmed_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_confirmed, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_accepted') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 15;
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
	} else {
?> 
						<input
							type="hidden"
							id="accepted_<?php echo $resultPage->pge_id ?>" 
							name="accepted_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_accepted, ENT_QUOTES, "UTF-8") ?>"
						>

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
				$resultUser = array();
?>		
			<tr id="virgo_tr_id_<?php echo $resultUser->usr_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultUser->usr_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultUser->usr_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultUser->usr_id) ? 0 : $resultUser->usr_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultUser->usr_id;
		$resultUser = new virgoUser;
		$resultUser->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsUser->get('show_table_username') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 0;
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
	} else {
?> 
						<input
							type="hidden"
							id="username_<?php echo $resultPage->pge_id ?>" 
							name="username_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_username, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_password') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 1;
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
	} else {
?> 
						<input
							type="hidden"
							id="password_<?php echo $resultPage->pge_id ?>" 
							name="password_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_password, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_email') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 2;
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
	} else {
?> 
						<input
							type="hidden"
							id="email_<?php echo $resultPage->pge_id ?>" 
							name="email_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_email, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_first_name') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 3;
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
	} else {
?> 
						<input
							type="hidden"
							id="firstName_<?php echo $resultPage->pge_id ?>" 
							name="firstName_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_first_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_last_name') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 4;
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
	} else {
?> 
						<input
							type="hidden"
							id="lastName_<?php echo $resultPage->pge_id ?>" 
							name="lastName_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_last_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_session_id') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 5;
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
	} else {
?> 
						<input
							type="hidden"
							id="sessionId_<?php echo $resultPage->pge_id ?>" 
							name="sessionId_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_session_id, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_ip') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 6;
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
	} else {
?> 
						<input
							type="hidden"
							id="ip_<?php echo $resultPage->pge_id ?>" 
							name="ip_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_ip, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_logged_in') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 7;
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
	} else {
?> 
						<input
							type="hidden"
							id="loggedIn_<?php echo $resultPage->pge_id ?>" 
							name="loggedIn_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_logged_in, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_last_successful_login') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 8;
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
	} else {
?> 
						<input
							type="hidden"
							id="lastSuccessfulLogin_<?php echo $resultPage->pge_id ?>" 
							name="lastSuccessfulLogin_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_last_successful_login, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_last_failed_login') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 9;
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
	} else {
?> 
						<input
							type="hidden"
							id="lastFailedLogin_<?php echo $resultPage->pge_id ?>" 
							name="lastFailedLogin_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_last_failed_login, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_last_logout') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 10;
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
	} else {
?> 
						<input
							type="hidden"
							id="lastLogout_<?php echo $resultPage->pge_id ?>" 
							name="lastLogout_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_last_logout, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_user_agent') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 11;
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
	} else {
?> 
						<input
							type="hidden"
							id="userAgent_<?php echo $resultPage->pge_id ?>" 
							name="userAgent_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_user_agent, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_token') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 12;
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
	} else {
?> 
						<input
							type="hidden"
							id="token_<?php echo $resultPage->pge_id ?>" 
							name="token_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_token, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_unidentified') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 13;
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
	} else {
?> 
						<input
							type="hidden"
							id="unidentified_<?php echo $resultPage->pge_id ?>" 
							name="unidentified_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_unidentified, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_confirmed') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 14;
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
	} else {
?> 
						<input
							type="hidden"
							id="confirmed_<?php echo $resultPage->pge_id ?>" 
							name="confirmed_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_confirmed, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsUser->get('show_table_accepted') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 15;
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
	} else {
?> 
						<input
							type="hidden"
							id="accepted_<?php echo $resultPage->pge_id ?>" 
							name="accepted_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_accepted, ENT_QUOTES, "UTF-8") ?>"
						>

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
				$tmpUser->setInvalidRecords(null);
?>
<?php
	}
?>
			</fieldset>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultPage->getDateCreated()) {
		if ($resultPage->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultPage->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultPage->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultPage->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultPage->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultPage->getDateModified()) {
		if ($resultPage->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultPage->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultPage->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultPage->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultPage->getDateModified() ?>"	>
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
						<input type="text" name="pge_id_<?php echo $this->getId() ?>" id="pge_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');
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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("PAGE"), "\\'".rawurlencode($resultPage->getVirgoTitle())."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>
				</div>
<script type="text/javascript" language="JavaScript">
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['pge_title_<?php echo $resultPage->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.2 Create */
	} elseif ($pageDisplayMode == "CREATE") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_page") {
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
<?php echo T('PAGE') ?>:</legend>
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
		if (isset($resultPage->pge_id)) {
			$resultPage->pge_id = null;
		}
		$parentAjaxRendered = "0";
?>
<?php
	$tmpAction = R('portlet_action');
	if ($tmpAction != "Store" && $tmpAction != "Apply" && $tmpAction != "StoreAndClear" && $tmpAction != "BackFromParent") {

$defaultValue = P('create_default_value_template');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoTemplate::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoTemplate::token2Id($tmpToken);
	}
	$resultPage->setTmpId($defaultValue);
}
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
	$resultPage->setPgeId($defaultValue);
}
$defaultValue = P('create_default_value_portal');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoPortal::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoPortal::token2Id($tmpToken);
	}
	$resultPage->setPrtId($defaultValue);
}
	}
?>
																																																										<?php
	if (P('show_create_title', "1") == "1" || P('show_create_title', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="pge_title_<?php echo $resultPage->getId() ?>">
* <?php echo T('TITLE') ?>
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
			if (P('event_column') == "title") {
				$resultPage->setTitle($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_title', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPage->getTitle(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="title" name="pge_title_<?php echo $resultPage->getId() ?>" value="<?php echo htmlentities($resultPage->getTitle(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pge_title_<?php echo $resultPage->getId() ?>" 
							name="pge_title_<?php echo $resultPage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPage->getTitle(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_TITLE');
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
$('#pge_title_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (P('show_create_alias', "1") == "1" || P('show_create_alias', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="pge_alias_<?php echo $resultPage->getId() ?>">
* <?php echo T('ALIAS') ?>
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
			if (P('event_column') == "alias") {
				$resultPage->setAlias($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_alias', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPage->getAlias(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="alias" name="pge_alias_<?php echo $resultPage->getId() ?>" value="<?php echo htmlentities($resultPage->getAlias(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pge_alias_<?php echo $resultPage->getId() ?>" 
							name="pge_alias_<?php echo $resultPage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPage->getAlias(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_ALIAS');
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
$('#pge_alias_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (P('show_create_default', "1") == "1" || P('show_create_default', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_default_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pge_default_<?php echo $resultPage->getId() ?>">
 <?php echo P('show_create_default_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('DEFAULT') ?>
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
			if (P('event_column') == "default") {
				$resultPage->setDefault($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_default', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="default"
>
<?php
	if (is_null($resultPage->pge_default) || $resultPage->pge_default == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultPage->pge_default == 1) {
		$booleanValue = T("YES");
	} elseif ($resultPage->pge_default === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
<select class="inputbox" id="pge_default_<?php echo $resultPage->getId() ?>" name="pge_default_<?php echo $resultPage->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_DEFAULT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPage->getDefault() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPage->getDefault() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPage->getDefault()) || $resultPage->getDefault() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pge_default_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (P('show_create_order', "1") == "1" || P('show_create_order', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_order_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pge_order_<?php echo $resultPage->getId() ?>">
 <?php echo P('show_create_order_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('ORDER') ?>
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
			if (P('event_column') == "order") {
				$resultPage->setOrder($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_order', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPage->getOrder(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="order" name="pge_order_<?php echo $resultPage->getId() ?>" value="<?php echo htmlentities($resultPage->getOrder(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_order_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pge_order_<?php echo $resultPage->getId() ?>" 
							name="pge_order_<?php echo $resultPage->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPage->getOrder(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_ORDER');
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
$('#pge_order_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (P('show_create_path', "1") == "1" || P('show_create_path', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_path_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pge_path_<?php echo $resultPage->getId() ?>">
 <?php echo P('show_create_path_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('PATH') ?>
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
			if (P('event_column') == "path") {
				$resultPage->setPath($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_path', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPage->getPath(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="path" name="pge_path_<?php echo $resultPage->getId() ?>" value="<?php echo htmlentities($resultPage->getPath(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_path_obligatory', "0") == "1" ? " obligatory " : "" ?>   long  " 
							type="text"
							id="pge_path_<?php echo $resultPage->getId() ?>" 
							name="pge_path_<?php echo $resultPage->getId() ?>"
							maxlength="2000"
							size="50" 
							value="<?php echo htmlentities($resultPage->getPath(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_PATH');
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
$('#pge_path_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (class_exists('portal\virgoTemplate') && ((P('show_create_template', "1") == "1" || P('show_create_template', "1") == "2" || P('show_create_template', "1") == "3") && !isset($context["tmp"]))) {
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
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_create_template_obligatory') == "1" ? " obligatory " : "" ?> " for="pge_template_<?php echo isset($resultPage->pge_id) ? $resultPage->pge_id : '' ?>">
<?php echo P('show_create_template_obligatory') == "1" ? " * " : "" ?>
<?php echo T('TEMPLATE') ?> <?php echo T('') ?>
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
//		$limit_template = $componentParams->get('limit_to_template');
		$limit_template = null;
		$tmpId = portal\virgoPage::getParentInContext("portal\\virgoTemplate");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_template', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_tmp__id = $tmpId;
//			}
			if (!is_null($resultPage->getTmpId())) {
				$parentId = $resultPage->getTmpId();
				$parentValue = portal\virgoTemplate::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_template_<?php echo $resultPage->getId() ?>" name="pge_template_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<script type="text/javascript">
var arrayTemplate2Portal = new Array();

<?php
	$query = " SELECT DISTINCT prt_tmp_id AS parent_id FROM prt_portals "; // plus ograniczenia skonfigurowane
	$rows = QR($query);
	$rowsParent = $rows;
	foreach ($rowsParent as $rowParent) {
		if (!is_null($rowParent['parent_id'])) {
?>
	var arrayTemplate<?php echo $rowParent['parent_id'] ?>= new Array();	
<?php
			$query = " SELECT prt_id AS id, prt_virgo_title AS value FROM prt_portals WHERE prt_tmp_id = " . $rowParent['parent_id']; // plus ograniczenia skonfigurowane
	$rows = QR($query);
			foreach ($rows as $row) {
?>
	arrayTemplate<?php echo $rowParent['parent_id'] ?>['<?php echo $row["id"] ?>'] = '<?php echo $row["value"] ?>';	
<?php
			}
?>
	arrayTemplate2Portal[<?php echo $rowParent['parent_id'] ?>] = arrayTemplate<?php echo $rowParent['parent_id'] ?>;
		
<?php
		}
	}
?>

function addOptionPortal(select, optionText, optionValue, selectedValue) {
	var newOption = document.createElement('option');
	newOption.text = optionText;
	newOption.value = optionValue;
	if (optionValue == selectedValue) {
		newOption.selected = true;
	}
	try {
		select.add(newOption, null);
	} catch (ex) {
		select.add(newOption);
	}
}

function displayArrayPortal(select, arrayToShow, selectedValue) {
	select.length = 0;
	addOptionPortal(select, '', '', selectedValue);
	for (var id in arrayToShow){ 
		addOptionPortal(select, arrayToShow[id], id, selectedValue);
	} 
}

function updatePortal(parentId, childrenListId, selectedValue) {
	// alert('test: ' + parentId + ' '  + childrenListId);
	var childrenList = document.getElementById(childrenListId);
	if (childrenList.tagName.toUpperCase() == "SELECT") {
		if (childrenList) {
			var arrayToShow = arrayTemplate2Portal[parentId];
			displayArrayPortal(childrenList, arrayToShow, selectedValue);
		}
	}
}
</script>
<?php
	$hint = TE('HINT_PAGE_TEMPLATE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_template) && trim($limit_template) != "") {
		$whereList = $whereList . " tmp_id ";
		if (trim($limit_template) == "page_title") {
			$limit_template = "SELECT tmp_id FROM prt_templates WHERE tmp_" . $limit_template . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_template = \"$limit_template\";");
		$whereList = $whereList . " IN (" . $limit_template . ") ";
	}						
	$parentCount = portal\virgoTemplate::getVirgoListSize($whereList);
	$showAjaxpge = P('show_create_template', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  <?php echo P('show_create_template_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="pge_template_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_template_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
<?php
	if (P('show_create_portal', "1") == "1") {
?>
								updatePortal(this.options[this.selectedIndex].value, 'pge_portal_<?php echo $resultPage->getId() ?>', <?php echo is_null($resultPage->getPortalId()) ? "null" : $resultPage->getPrtId() ?>);
<?php
	}
?>
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
			if (is_null($limit_template) || trim($limit_template) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsTemplate = portal\virgoTemplate::getVirgoList($whereList);
			while(list($id, $label)=each($resultsTemplate)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPage->getTmpId()) && $id == $resultPage->getTmpId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getTmpId();
				$parentTemplate = new portal\virgoTemplate();
				$parentValue = $parentTemplate->lookup($parentId);
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
	<input type="hidden" id="pge_template_<?php echo $resultPage->getId() ?>" name="pge_template_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="pge_template_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_template_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Template",
			virgo_field_name: "template",
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
					$('#pge_template_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_template_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (isset($context["tmp"])) {
		$parentValue = $context["tmp"];
	} else {
		$parentValue = $resultPage->pge_tmp_id;
	}
	
?>
				<input type="hidden" id="pge_template_<?php echo $resultPage->pge_id ?>" name="pge_template_<?php echo $resultPage->pge_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPage') && ((P('show_create_page', "1") == "1" || P('show_create_page', "1") == "2" || P('show_create_page', "1") == "3"))) {
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
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_create_page_obligatory') == "1" ? " obligatory " : "" ?> " for="pge_page_<?php echo isset($resultPage->pge_id) ? $resultPage->pge_id : '' ?>">
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
		$readOnly = "";
		if (isset($tmpId) || P('show_create_page', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_pge__id = $tmpId;
//			}
			if (!is_null($resultPage->getPgeId())) {
				$parentId = $resultPage->getPgeId();
				$parentValue = portal\virgoPage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_page_<?php echo $resultPage->getId() ?>" name="pge_page_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PAGE_PAGE');
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
	$showAjaxpge = P('show_create_page', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  <?php echo P('show_create_page_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="pge_page_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_page_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
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
				echo (!is_null($resultPage->getPgeId()) && $id == $resultPage->getPgeId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getPgeId();
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
	<input type="hidden" id="pge_page_<?php echo $resultPage->getId() ?>" name="pge_page_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="pge_page_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_page_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
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
					$('#pge_page_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_page_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
		$parentValue = $resultPage->pge_pge_id;
	}
	
?>
				<input type="hidden" id="pge_page_<?php echo $resultPage->pge_id ?>" name="pge_page_<?php echo $resultPage->pge_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortal') && ((P('show_create_portal', "1") == "1" || P('show_create_portal', "1") == "2" || P('show_create_portal', "1") == "3") && !isset($context["prt"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="pge_portal_<?php echo isset($resultPage->pge_id) ? $resultPage->pge_id : '' ?>">
 *
<?php echo T('PORTAL') ?> <?php echo T('') ?>
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
//		$limit_portal = $componentParams->get('limit_to_portal');
		$limit_portal = null;
		$tmpId = portal\virgoPage::getParentInContext("portal\\virgoPortal");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_portal', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_prt__id = $tmpId;
//			}
			if (!is_null($resultPage->getPrtId())) {
				$parentId = $resultPage->getPrtId();
				$parentValue = portal\virgoPortal::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_portal_<?php echo $resultPage->getId() ?>" name="pge_portal_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PAGE_PORTAL');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portal) && trim($limit_portal) != "") {
		$whereList = $whereList . " prt_id ";
		if (trim($limit_portal) == "page_title") {
			$limit_portal = "SELECT prt_id FROM prt_portals WHERE prt_" . $limit_portal . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portal = \"$limit_portal\";");
		$whereList = $whereList . " IN (" . $limit_portal . ") ";
	}						
	$parentCount = portal\virgoPortal::getVirgoListSize($whereList);
	$showAjaxpge = P('show_create_portal', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pge_portal_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_portal_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
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
			if (is_null($limit_portal) || trim($limit_portal) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortal = portal\virgoPortal::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortal)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPage->getPrtId()) && $id == $resultPage->getPrtId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getPrtId();
				$parentPortal = new portal\virgoPortal();
				$parentValue = $parentPortal->lookup($parentId);
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
	<input type="hidden" id="pge_portal_<?php echo $resultPage->getId() ?>" name="pge_portal_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pge_portal_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_portal_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Portal",
			virgo_field_name: "portal",
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
					$('#pge_portal_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_portal_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="create">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddPortal')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addportal inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddPortal';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (isset($context["prt"])) {
		$parentValue = $context["prt"];
	} else {
		$parentValue = $resultPage->pge_prt_id;
	}
	
?>
				<input type="hidden" id="pge_portal_<?php echo $resultPage->pge_id ?>" name="pge_portal_<?php echo $resultPage->pge_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>

<?php
	if (class_exists('portal\virgoPermission') && P('show_create_permissions', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoPortletLocation') && P('show_create_portlet_locations', '1') == "1") {
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
					<label nowrap class="fieldlabel portletLocation" for="pge_portletLocation_<?php echo $resultPage->getId() ?>[]">
Portlet locations 
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
			$parentPortletObject = new portal\virgoPortletObject();
			$whereList = "";
			$resultsPortletObject = $parentPortletObject->getVirgoList($whereList);
			$currentConnections = $resultPage->getPortletLocations();
			$currentIds = array();
			foreach ($currentConnections as $currentConnection) {
				$currentIds[] = $currentConnection->getPortletObjectId();
			}
			$defaultParents = PN('create_default_values_portlet_objects');
			$currentIds = array_merge($currentIds, $defaultParents);
?>
<?php
	$inputMethod = P('n_m_children_input_portlet_location_', "select");
	if (is_null($inputMethod) || trim($inputMethod) == "") {
		$inputMethod = "select";
	}
	if ($inputMethod == "select") {
?>
						<select 
							class="inputbox" 
							id="pge_portletLocation_<?php echo $resultPage->pge_id ?>[]" 
							name="pge_portletLocation_<?php echo $resultPage->pge_id ?>[]" 
							multiple 
							size=<?php echo sizeof($resultsPortletObject) > 10 ? 10 : sizeof($resultsPortletObject) ?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
						>
<?php
			while (list($id, $label) = each($resultsPortletObject)) {
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
			reset($resultsPortletObject);
			while (list($id, $label) = each($resultsPortletObject)) {
?>
							<li class="parent_selection">
								<input 
									type="checkbox"
									class="inputbox checkbox"
									id="pge_portletLocation_<?php echo $resultPage->pge_id ?>[]" 
									name="pge_portletLocation_<?php echo $resultPage->pge_id ?>[]" 
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
	$defaultParents = PN('create_default_values_portlet_objects');
	foreach ($defaultParents as $defaultParent) {
?>
		<input type="hidden" name="pge_portletLocation_[]" value="<?php echo $defaultParent ?>"/>
<?php	
	}
	}
?>
<?php
	if (class_exists('portal\virgoPage') && P('show_create_pages', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoUser') && P('show_create_users', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoRole') && P('show_create_roles', '1') == "1") {
?>
<?php
	} else {
	}
?>


<?php
	} elseif ($createForm == "virgo_entity") {
?>
<?php
		if (isset($resultPage->pge_id)) {
			$resultPage->pge_id = null;
		}
		$parentAjaxRendered = "0";
?>
<?php
	$tmpAction = R('portlet_action');
	if ($tmpAction != "Store" && $tmpAction != "Apply" && $tmpAction != "StoreAndClear" && $tmpAction != "BackFromParent") {

$defaultValue = P('create_default_value_template');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoTemplate::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoTemplate::token2Id($tmpToken);
	}
	$resultPage->setTmpId($defaultValue);
}
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
	$resultPage->setPgeId($defaultValue);
}
$defaultValue = P('create_default_value_portal');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoPortal::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoPortal::token2Id($tmpToken);
	}
	$resultPage->setPrtId($defaultValue);
}
	}
?>
																																																										<?php
	if (P('show_create_title', "1") == "1" || P('show_create_title', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="pge_title_<?php echo $resultPage->getId() ?>">
* <?php echo T('TITLE') ?>
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
			if (P('event_column') == "title") {
				$resultPage->setTitle($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_title', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPage->getTitle(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="title" name="pge_title_<?php echo $resultPage->getId() ?>" value="<?php echo htmlentities($resultPage->getTitle(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pge_title_<?php echo $resultPage->getId() ?>" 
							name="pge_title_<?php echo $resultPage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPage->getTitle(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_TITLE');
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
$('#pge_title_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (P('show_create_alias', "1") == "1" || P('show_create_alias', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="pge_alias_<?php echo $resultPage->getId() ?>">
* <?php echo T('ALIAS') ?>
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
			if (P('event_column') == "alias") {
				$resultPage->setAlias($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_alias', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPage->getAlias(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="alias" name="pge_alias_<?php echo $resultPage->getId() ?>" value="<?php echo htmlentities($resultPage->getAlias(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pge_alias_<?php echo $resultPage->getId() ?>" 
							name="pge_alias_<?php echo $resultPage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPage->getAlias(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_ALIAS');
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
$('#pge_alias_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (P('show_create_default', "1") == "1" || P('show_create_default', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_default_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pge_default_<?php echo $resultPage->getId() ?>">
 <?php echo P('show_create_default_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('DEFAULT') ?>
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
			if (P('event_column') == "default") {
				$resultPage->setDefault($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_default', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="default"
>
<?php
	if (is_null($resultPage->pge_default) || $resultPage->pge_default == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultPage->pge_default == 1) {
		$booleanValue = T("YES");
	} elseif ($resultPage->pge_default === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
<select class="inputbox" id="pge_default_<?php echo $resultPage->getId() ?>" name="pge_default_<?php echo $resultPage->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_DEFAULT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPage->getDefault() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPage->getDefault() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPage->getDefault()) || $resultPage->getDefault() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pge_default_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (P('show_create_order', "1") == "1" || P('show_create_order', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_order_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pge_order_<?php echo $resultPage->getId() ?>">
 <?php echo P('show_create_order_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('ORDER') ?>
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
			if (P('event_column') == "order") {
				$resultPage->setOrder($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_order', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPage->getOrder(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="order" name="pge_order_<?php echo $resultPage->getId() ?>" value="<?php echo htmlentities($resultPage->getOrder(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_order_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pge_order_<?php echo $resultPage->getId() ?>" 
							name="pge_order_<?php echo $resultPage->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPage->getOrder(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_ORDER');
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
$('#pge_order_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (P('show_create_path', "1") == "1" || P('show_create_path', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_path_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pge_path_<?php echo $resultPage->getId() ?>">
 <?php echo P('show_create_path_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('PATH') ?>
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
			if (P('event_column') == "path") {
				$resultPage->setPath($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_path', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPage->getPath(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="path" name="pge_path_<?php echo $resultPage->getId() ?>" value="<?php echo htmlentities($resultPage->getPath(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_path_obligatory', "0") == "1" ? " obligatory " : "" ?>   long  " 
							type="text"
							id="pge_path_<?php echo $resultPage->getId() ?>" 
							name="pge_path_<?php echo $resultPage->getId() ?>"
							maxlength="2000"
							size="50" 
							value="<?php echo htmlentities($resultPage->getPath(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_PATH');
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
$('#pge_path_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (class_exists('portal\virgoTemplate') && ((P('show_create_template', "1") == "1" || P('show_create_template', "1") == "2" || P('show_create_template', "1") == "3") && !isset($context["tmp"]))) {
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
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_create_template_obligatory') == "1" ? " obligatory " : "" ?> " for="pge_template_<?php echo isset($resultPage->pge_id) ? $resultPage->pge_id : '' ?>">
<?php echo P('show_create_template_obligatory') == "1" ? " * " : "" ?>
<?php echo T('TEMPLATE') ?> <?php echo T('') ?>
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
//		$limit_template = $componentParams->get('limit_to_template');
		$limit_template = null;
		$tmpId = portal\virgoPage::getParentInContext("portal\\virgoTemplate");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_template', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_tmp__id = $tmpId;
//			}
			if (!is_null($resultPage->getTmpId())) {
				$parentId = $resultPage->getTmpId();
				$parentValue = portal\virgoTemplate::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_template_<?php echo $resultPage->getId() ?>" name="pge_template_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<script type="text/javascript">
var arrayTemplate2Portal = new Array();

<?php
	$query = " SELECT DISTINCT prt_tmp_id AS parent_id FROM prt_portals "; // plus ograniczenia skonfigurowane
	$rows = QR($query);
	$rowsParent = $rows;
	foreach ($rowsParent as $rowParent) {
		if (!is_null($rowParent['parent_id'])) {
?>
	var arrayTemplate<?php echo $rowParent['parent_id'] ?>= new Array();	
<?php
			$query = " SELECT prt_id AS id, prt_virgo_title AS value FROM prt_portals WHERE prt_tmp_id = " . $rowParent['parent_id']; // plus ograniczenia skonfigurowane
	$rows = QR($query);
			foreach ($rows as $row) {
?>
	arrayTemplate<?php echo $rowParent['parent_id'] ?>['<?php echo $row["id"] ?>'] = '<?php echo $row["value"] ?>';	
<?php
			}
?>
	arrayTemplate2Portal[<?php echo $rowParent['parent_id'] ?>] = arrayTemplate<?php echo $rowParent['parent_id'] ?>;
		
<?php
		}
	}
?>

function addOptionPortal(select, optionText, optionValue, selectedValue) {
	var newOption = document.createElement('option');
	newOption.text = optionText;
	newOption.value = optionValue;
	if (optionValue == selectedValue) {
		newOption.selected = true;
	}
	try {
		select.add(newOption, null);
	} catch (ex) {
		select.add(newOption);
	}
}

function displayArrayPortal(select, arrayToShow, selectedValue) {
	select.length = 0;
	addOptionPortal(select, '', '', selectedValue);
	for (var id in arrayToShow){ 
		addOptionPortal(select, arrayToShow[id], id, selectedValue);
	} 
}

function updatePortal(parentId, childrenListId, selectedValue) {
	// alert('test: ' + parentId + ' '  + childrenListId);
	var childrenList = document.getElementById(childrenListId);
	if (childrenList.tagName.toUpperCase() == "SELECT") {
		if (childrenList) {
			var arrayToShow = arrayTemplate2Portal[parentId];
			displayArrayPortal(childrenList, arrayToShow, selectedValue);
		}
	}
}
</script>
<?php
	$hint = TE('HINT_PAGE_TEMPLATE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_template) && trim($limit_template) != "") {
		$whereList = $whereList . " tmp_id ";
		if (trim($limit_template) == "page_title") {
			$limit_template = "SELECT tmp_id FROM prt_templates WHERE tmp_" . $limit_template . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_template = \"$limit_template\";");
		$whereList = $whereList . " IN (" . $limit_template . ") ";
	}						
	$parentCount = portal\virgoTemplate::getVirgoListSize($whereList);
	$showAjaxpge = P('show_create_template', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  <?php echo P('show_create_template_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="pge_template_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_template_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
<?php
	if (P('show_create_portal', "1") == "1") {
?>
								updatePortal(this.options[this.selectedIndex].value, 'pge_portal_<?php echo $resultPage->getId() ?>', <?php echo is_null($resultPage->getPortalId()) ? "null" : $resultPage->getPrtId() ?>);
<?php
	}
?>
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
			if (is_null($limit_template) || trim($limit_template) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsTemplate = portal\virgoTemplate::getVirgoList($whereList);
			while(list($id, $label)=each($resultsTemplate)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPage->getTmpId()) && $id == $resultPage->getTmpId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getTmpId();
				$parentTemplate = new portal\virgoTemplate();
				$parentValue = $parentTemplate->lookup($parentId);
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
	<input type="hidden" id="pge_template_<?php echo $resultPage->getId() ?>" name="pge_template_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="pge_template_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_template_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Template",
			virgo_field_name: "template",
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
					$('#pge_template_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_template_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (isset($context["tmp"])) {
		$parentValue = $context["tmp"];
	} else {
		$parentValue = $resultPage->pge_tmp_id;
	}
	
?>
				<input type="hidden" id="pge_template_<?php echo $resultPage->pge_id ?>" name="pge_template_<?php echo $resultPage->pge_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPage') && ((P('show_create_page', "1") == "1" || P('show_create_page', "1") == "2" || P('show_create_page', "1") == "3"))) {
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
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_create_page_obligatory') == "1" ? " obligatory " : "" ?> " for="pge_page_<?php echo isset($resultPage->pge_id) ? $resultPage->pge_id : '' ?>">
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
		$readOnly = "";
		if (isset($tmpId) || P('show_create_page', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_pge__id = $tmpId;
//			}
			if (!is_null($resultPage->getPgeId())) {
				$parentId = $resultPage->getPgeId();
				$parentValue = portal\virgoPage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_page_<?php echo $resultPage->getId() ?>" name="pge_page_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PAGE_PAGE');
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
	$showAjaxpge = P('show_create_page', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  <?php echo P('show_create_page_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="pge_page_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_page_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
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
				echo (!is_null($resultPage->getPgeId()) && $id == $resultPage->getPgeId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getPgeId();
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
	<input type="hidden" id="pge_page_<?php echo $resultPage->getId() ?>" name="pge_page_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="pge_page_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_page_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
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
					$('#pge_page_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_page_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
		$parentValue = $resultPage->pge_pge_id;
	}
	
?>
				<input type="hidden" id="pge_page_<?php echo $resultPage->pge_id ?>" name="pge_page_<?php echo $resultPage->pge_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortal') && ((P('show_create_portal', "1") == "1" || P('show_create_portal', "1") == "2" || P('show_create_portal', "1") == "3") && !isset($context["prt"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="pge_portal_<?php echo isset($resultPage->pge_id) ? $resultPage->pge_id : '' ?>">
 *
<?php echo T('PORTAL') ?> <?php echo T('') ?>
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
//		$limit_portal = $componentParams->get('limit_to_portal');
		$limit_portal = null;
		$tmpId = portal\virgoPage::getParentInContext("portal\\virgoPortal");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_portal', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_prt__id = $tmpId;
//			}
			if (!is_null($resultPage->getPrtId())) {
				$parentId = $resultPage->getPrtId();
				$parentValue = portal\virgoPortal::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_portal_<?php echo $resultPage->getId() ?>" name="pge_portal_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PAGE_PORTAL');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portal) && trim($limit_portal) != "") {
		$whereList = $whereList . " prt_id ";
		if (trim($limit_portal) == "page_title") {
			$limit_portal = "SELECT prt_id FROM prt_portals WHERE prt_" . $limit_portal . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portal = \"$limit_portal\";");
		$whereList = $whereList . " IN (" . $limit_portal . ") ";
	}						
	$parentCount = portal\virgoPortal::getVirgoListSize($whereList);
	$showAjaxpge = P('show_create_portal', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pge_portal_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_portal_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
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
			if (is_null($limit_portal) || trim($limit_portal) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortal = portal\virgoPortal::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortal)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPage->getPrtId()) && $id == $resultPage->getPrtId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getPrtId();
				$parentPortal = new portal\virgoPortal();
				$parentValue = $parentPortal->lookup($parentId);
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
	<input type="hidden" id="pge_portal_<?php echo $resultPage->getId() ?>" name="pge_portal_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pge_portal_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_portal_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Portal",
			virgo_field_name: "portal",
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
					$('#pge_portal_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_portal_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="create">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddPortal')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addportal inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddPortal';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (isset($context["prt"])) {
		$parentValue = $context["prt"];
	} else {
		$parentValue = $resultPage->pge_prt_id;
	}
	
?>
				<input type="hidden" id="pge_portal_<?php echo $resultPage->pge_id ?>" name="pge_portal_<?php echo $resultPage->pge_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>

<?php
	if (class_exists('portal\virgoPermission') && P('show_create_permissions', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoPortletLocation') && P('show_create_portlet_locations', '1') == "1") {
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
					<label nowrap class="fieldlabel portletLocation" for="pge_portletLocation_<?php echo $resultPage->getId() ?>[]">
Portlet locations 
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
			$parentPortletObject = new portal\virgoPortletObject();
			$whereList = "";
			$resultsPortletObject = $parentPortletObject->getVirgoList($whereList);
			$currentConnections = $resultPage->getPortletLocations();
			$currentIds = array();
			foreach ($currentConnections as $currentConnection) {
				$currentIds[] = $currentConnection->getPortletObjectId();
			}
			$defaultParents = PN('create_default_values_portlet_objects');
			$currentIds = array_merge($currentIds, $defaultParents);
?>
<?php
	$inputMethod = P('n_m_children_input_portlet_location_', "select");
	if (is_null($inputMethod) || trim($inputMethod) == "") {
		$inputMethod = "select";
	}
	if ($inputMethod == "select") {
?>
						<select 
							class="inputbox" 
							id="pge_portletLocation_<?php echo $resultPage->pge_id ?>[]" 
							name="pge_portletLocation_<?php echo $resultPage->pge_id ?>[]" 
							multiple 
							size=<?php echo sizeof($resultsPortletObject) > 10 ? 10 : sizeof($resultsPortletObject) ?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
						>
<?php
			while (list($id, $label) = each($resultsPortletObject)) {
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
			reset($resultsPortletObject);
			while (list($id, $label) = each($resultsPortletObject)) {
?>
							<li class="parent_selection">
								<input 
									type="checkbox"
									class="inputbox checkbox"
									id="pge_portletLocation_<?php echo $resultPage->pge_id ?>[]" 
									name="pge_portletLocation_<?php echo $resultPage->pge_id ?>[]" 
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
	$defaultParents = PN('create_default_values_portlet_objects');
	foreach ($defaultParents as $defaultParent) {
?>
		<input type="hidden" name="pge_portletLocation_[]" value="<?php echo $defaultParent ?>"/>
<?php	
	}
	}
?>
<?php
	if (class_exists('portal\virgoPage') && P('show_create_pages', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoUser') && P('show_create_users', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoRole') && P('show_create_roles', '1') == "1") {
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
	if ($resultPage->getDateCreated()) {
		if ($resultPage->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultPage->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultPage->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultPage->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultPage->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultPage->getDateModified()) {
		if ($resultPage->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultPage->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultPage->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultPage->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultPage->getDateModified() ?>"	>
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
						<input type="text" name="pge_id_<?php echo $this->getId() ?>" id="pge_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['pge_title_<?php echo $resultPage->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.3 Search */
	} elseif ($pageDisplayMode == "SEARCH") {
?>
	<div class="form_edit form_search">
			<fieldset class="form">
				<legend>
<?php echo T('PAGE') ?>:</legend>
				<ul>
<?php
	$criteriaPage = $resultPage->getCriteria();
?>
<?php
	if (P('show_search_title', "1") == "1") {

		if (isset($criteriaPage["title"])) {
			$fieldCriteriaTitle = $criteriaPage["title"];
			$dataTypeCriteria = $fieldCriteriaTitle["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('TITLE') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_title" 
							name="virgo_search_title"
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
				id="virgo_search_title_is_null" 
				name="virgo_search_title_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaTitle) && $fieldCriteriaTitle["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaTitle) && $fieldCriteriaTitle["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaTitle) && $fieldCriteriaTitle["is_null"] == 2) {
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
	if (P('show_search_alias', "1") == "1") {

		if (isset($criteriaPage["alias"])) {
			$fieldCriteriaAlias = $criteriaPage["alias"];
			$dataTypeCriteria = $fieldCriteriaAlias["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('ALIAS') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_alias" 
							name="virgo_search_alias"
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
				id="virgo_search_alias_is_null" 
				name="virgo_search_alias_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaAlias) && $fieldCriteriaAlias["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaAlias) && $fieldCriteriaAlias["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaAlias) && $fieldCriteriaAlias["is_null"] == 2) {
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
	if (P('show_search_default', "1") == "1") {

		if (isset($criteriaPage["default"])) {
			$fieldCriteriaDefault = $criteriaPage["default"];
			$dataTypeCriteria = $fieldCriteriaDefault["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('DEFAULT') ?>
		</label>
		<span align="left" nowrap>
<select id="virgo_search_default" name="virgo_search_default">
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
				id="virgo_search_default_is_null" 
				name="virgo_search_default_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaDefault) && $fieldCriteriaDefault["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaDefault) && $fieldCriteriaDefault["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaDefault) && $fieldCriteriaDefault["is_null"] == 2) {
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
	if (P('show_search_order', "1") == "1") {

		if (isset($criteriaPage["order"])) {
			$fieldCriteriaOrder = $criteriaPage["order"];
			$dataTypeCriteria = $fieldCriteriaOrder["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('ORDER') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_order_from" 
							name="virgo_search_order_from"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["from"]) ? htmlentities($dataTypeCriteria["from"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>
						&nbsp;-&nbsp;
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_order_to" 
							name="virgo_search_order_to"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["to"]) ? htmlentities($dataTypeCriteria["to"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_order_is_null" 
				name="virgo_search_order_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaOrder) && $fieldCriteriaOrder["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaOrder) && $fieldCriteriaOrder["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaOrder) && $fieldCriteriaOrder["is_null"] == 2) {
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
	if (P('show_search_path', "1") == "1") {

		if (isset($criteriaPage["path"])) {
			$fieldCriteriaPath = $criteriaPage["path"];
			$dataTypeCriteria = $fieldCriteriaPath["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('PATH') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_path" 
							name="virgo_search_path"
							style="border: yellow 1 solid;" 
							maxlength="2000"
							size="50" 
							value="<?php echo isset($dataTypeCriteria["default"]) ? htmlentities($dataTypeCriteria["default"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_path_is_null" 
				name="virgo_search_path_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaPath) && $fieldCriteriaPath["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaPath) && $fieldCriteriaPath["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaPath) && $fieldCriteriaPath["is_null"] == 2) {
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
	if (P('show_search_template', '1') == "1") {
		if (isset($criteriaPage["template"])) {
			$fieldCriteriaTemplate = $criteriaPage["template"];
		}
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
	
				<label align="right" nowrap class="fieldlabel"
					<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>				
				><?php echo T('TEMPLATE') ?> <?php echo T('') ?></label>
<?php
	$value = isset($fieldCriteriaTemplate["value"]) ? $fieldCriteriaTemplate["value"] : null;
?>
    <input type="text" class="inputbox " id="virgo_search_template" name="virgo_search_template" value="<?php echo $value ?>">
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
		if (isset($fieldCriteriaTemplate) && $fieldCriteriaTemplate["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaTemplate) && $fieldCriteriaTemplate["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaTemplate) && $fieldCriteriaTemplate["is_null"] == 2) {
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
	if (P('show_search_page', '1') == "1") {
		if (isset($criteriaPage["page"])) {
			$fieldCriteriaPage = $criteriaPage["page"];
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
	if (P('show_search_portal', '1') == "1") {
		if (isset($criteriaPage["portal"])) {
			$fieldCriteriaPortal = $criteriaPage["portal"];
		}
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
	
				<label align="right" nowrap class="fieldlabel"
					<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>				
				><?php echo T('PORTAL') ?> <?php echo T('') ?></label>
<?php
	$value = isset($fieldCriteriaPortal["value"]) ? $fieldCriteriaPortal["value"] : null;
?>
    <input type="text" class="inputbox " id="virgo_search_portal" name="virgo_search_portal" value="<?php echo $value ?>">
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
		if (isset($fieldCriteriaPortal) && $fieldCriteriaPortal["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaPortal) && $fieldCriteriaPortal["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaPortal) && $fieldCriteriaPortal["is_null"] == 2) {
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
	if (P('show_search_permissions') == "1") {
?>
<?php
	$record = new portal\virgoPage();
	$recordId = is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->pge_id;
	$record->load($recordId);
	$subrecordsPermissions = $record->getPermissions();
	$sizePermissions = count($subrecordsPermissions);
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
					<label align="right" valign="top" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
					>
						Permissions
					</label>
<?php
	if ($sizePermissions == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPermissions as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePermissions) {
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
	if (P('show_search_portlet_locations') == "1") {
		if (isset($criteriaPage["portlet_object"])) {
			$parentIds = $criteriaPage["portlet_object"];
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
					>Portlet objects</label>
<?php
		$ids = virgoPortletObject::selectAllAsIdsStatic();
		if (count($ids) < 50) {
			$idAndName = "virgo_search_portletObject[]";
?>
					<select class="inputbox " multiple='multiple' id="<?php echo $idAndName ?>" name="<?php echo $idAndName ?>">
<?php
			foreach ($ids as $id) {
				$obj = new virgoPortletObject($id['id']);
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
	if (P('show_search_pages') == "1") {
?>
<?php
	$record = new portal\virgoPage();
	$recordId = is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->pge_id;
	$record->load($recordId);
	$subrecordsPages = $record->getPages();
	$sizePages = count($subrecordsPages);
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
					<label align="right" valign="top" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
					>
						Pages
					</label>
<?php
	if ($sizePages == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPages as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePages) {
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
	if (P('show_search_users') == "1") {
?>
<?php
	$record = new portal\virgoPage();
	$recordId = is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->pge_id;
	$record->load($recordId);
	$subrecordsUsers = $record->getUsers();
	$sizeUsers = count($subrecordsUsers);
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
					<label align="right" valign="top" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
					>
						Users
					</label>
<?php
	if ($sizeUsers == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsUsers as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeUsers) {
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
	if (P('show_search_roles') == "1") {
?>
<?php
	$record = new portal\virgoPage();
	$recordId = is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->pge_id;
	$record->load($recordId);
	$subrecordsRoles = $record->getRoles();
	$sizeRoles = count($subrecordsRoles);
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
					<label align="right" valign="top" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
					>
						Roles
					</label>
<?php
	if ($sizeRoles == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsRoles as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeRoles) {
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
	unset($criteriaPage);
?>
				</ul>
			</fieldset>
				<div class="buttons form-actions">
						<input type="text" name="pge_id_<?php echo $this->getId() ?>" id="pge_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

 <div class="button_wrapper button_wrapper_search inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Search';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
	} elseif ($pageDisplayMode == "VIEW") {
?>
	<div class="form_view">
<?php
	$editForm = P('view_form', "virgo_default");
	if (is_null($editForm) || trim($editForm) == "" || $editForm == "virgo_default") {
?>
			<fieldset class="form">
				<legend>
<?php echo T('PAGE') ?>:</legend>
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
	if (P('show_view_title', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="title"
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
<?php echo T('TITLE') ?>
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
							<?php echo htmlentities($resultPage->getTitle(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="title" name="pge_title_<?php echo $resultPage->getId() ?>" value="<?php echo htmlentities($resultPage->getTitle(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_alias', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="alias"
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
<?php echo T('ALIAS') ?>
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
							<?php echo htmlentities($resultPage->getAlias(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="alias" name="pge_alias_<?php echo $resultPage->getId() ?>" value="<?php echo htmlentities($resultPage->getAlias(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_default', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="default"
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
<?php echo T('DEFAULT') ?>
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
	id="default"
>
<?php
	if (is_null($resultPage->pge_default) || $resultPage->pge_default == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultPage->pge_default == 1) {
		$booleanValue = T("YES");
	} elseif ($resultPage->pge_default === "0") {
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
	if (P('show_view_order', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="order"
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
<?php echo T('ORDER') ?>
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
							<?php echo htmlentities($resultPage->getOrder(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="order" name="pge_order_<?php echo $resultPage->getId() ?>" value="<?php echo htmlentities($resultPage->getOrder(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_path', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="path"
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
<?php echo T('PATH') ?>
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
							<?php echo htmlentities($resultPage->getPath(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="path" name="pge_path_<?php echo $resultPage->getId() ?>" value="<?php echo htmlentities($resultPage->getPath(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (class_exists('portal\virgoTemplate') && P('show_view_template', '1') == "1") { // && (isset($masterComponentName) && $masterComponentName != "template" || is_null($contextId))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="template"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">Template </span>
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
			if (!is_null($context) && isset($context['tmp_id'])) {
				$tmpId = $context['tmp_id'];
			}
			$readOnly = "";
			if ($resultPage->getId() == 0) {
// przesuac do createforgui				$resultPage->pge_tmp__id = $tmpId;
			}
			$parentId = $resultPage->getTemplateId();
			$parentValue = portal\virgoTemplate::lookup($parentId);
				
?>
					<input
						type="hidden"
						id="pge_template_<?php echo isset($resultPage->pge_id) ? $resultPage->pge_id : '' ?>" 
						name="pge_template_<?php echo isset($resultPage->pge_id) ? $resultPage->pge_id : '' ?>" 						
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
			if ($resultPage->getId() == 0) {
// przesuac do createforgui				$resultPage->pge_pge__id = $tmpId;
			}
			$parentId = $resultPage->getPageId();
			$parentValue = portal\virgoPage::lookup($parentId);
				
?>
					<input
						type="hidden"
						id="pge_page_<?php echo isset($resultPage->pge_id) ? $resultPage->pge_id : '' ?>" 
						name="pge_page_<?php echo isset($resultPage->pge_id) ? $resultPage->pge_id : '' ?>" 						
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
	if (class_exists('portal\virgoPortal') && P('show_view_portal', '1') == "1") { // && (isset($masterComponentName) && $masterComponentName != "portal" || is_null($contextId))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="portal"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">Portal </span>
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
			if (!is_null($context) && isset($context['prt_id'])) {
				$tmpId = $context['prt_id'];
			}
			$readOnly = "";
			if ($resultPage->getId() == 0) {
// przesuac do createforgui				$resultPage->pge_prt__id = $tmpId;
			}
			$parentId = $resultPage->getPortalId();
			$parentValue = portal\virgoPortal::lookup($parentId);
				
?>
					<input
						type="hidden"
						id="pge_portal_<?php echo isset($resultPage->pge_id) ? $resultPage->pge_id : '' ?>" 
						name="pge_portal_<?php echo isset($resultPage->pge_id) ? $resultPage->pge_id : '' ?>" 						
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
	if (class_exists('portal\virgoPermission') && P('show_view_permissions', '0') == "1") {
?>
<?php
	$record = new portal\virgoPage();
	$recordId = is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->pge_id;
	$record->load($recordId);
	$subrecordsPermissions = $record->getPermissions();
	$sizePermissions = count($subrecordsPermissions);
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
					<span align="right" nowrap class="fieldlabel">
						Permissions 
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
	if ($sizePermissions == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPermissions as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePermissions) {
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
	if (class_exists('portal\virgoPortletLocation') && P('show_view_portlet_locations', '0') == "1") {
?>
<?php
	$record = new portal\virgoPage();
	$recordId = is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->pge_id;
	$record->load($recordId);
	$subrecordsPortletLocations = $record->getPortletLocations();
	$sizePortletLocations = count($subrecordsPortletLocations);
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
					<span align="right" nowrap class="fieldlabel">
						Portlet locations 
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
	if ($sizePortletLocations == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPortletLocations as $subrecord) {
			$subrecordIndex++;
			$parentPortletObject = new portal\virgoPortletObject($subrecord->getPobId());
			echo htmlentities($parentPortletObject->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePortletLocations) {
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
	if (class_exists('portal\virgoPage') && P('show_view_pages', '0') == "1") {
?>
<?php
	$record = new portal\virgoPage();
	$recordId = is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->pge_id;
	$record->load($recordId);
	$subrecordsPages = $record->getPages();
	$sizePages = count($subrecordsPages);
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
					<span align="right" nowrap class="fieldlabel">
						Pages 
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
	if ($sizePages == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPages as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePages) {
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
	if (class_exists('portal\virgoUser') && P('show_view_users', '0') == "1") {
?>
<?php
	$record = new portal\virgoPage();
	$recordId = is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->pge_id;
	$record->load($recordId);
	$subrecordsUsers = $record->getUsers();
	$sizeUsers = count($subrecordsUsers);
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
					<span align="right" nowrap class="fieldlabel">
						Users 
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
	if ($sizeUsers == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsUsers as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeUsers) {
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
	if (class_exists('portal\virgoRole') && P('show_view_roles', '0') == "1") {
?>
<?php
	$record = new portal\virgoPage();
	$recordId = is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->pge_id;
	$record->load($recordId);
	$subrecordsRoles = $record->getRoles();
	$sizeRoles = count($subrecordsRoles);
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
					<span align="right" nowrap class="fieldlabel">
						Roles 
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
	if ($sizeRoles == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsRoles as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeRoles) {
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
<?php echo T('PAGE') ?>:</legend>
				<ul>
				</ul>
			</fieldset>
<?php
	}
?>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultPage->getDateCreated()) {
		if ($resultPage->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultPage->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultPage->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultPage->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultPage->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultPage->getDateModified()) {
		if ($resultPage->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultPage->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultPage->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultPage->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultPage->getDateModified() ?>"	>
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
						<input type="text" name="pge_id_<?php echo $this->getId() ?>" id="pge_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("PAGE"), "\\'".$resultPage->getVirgoTitle()."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
	} elseif ($pageDisplayMode == "TABLE") {
PROFILE('TABLE');
		if (P('form_only') == "3") {
?>
<?php
	$selectedMonth = $this->getPortletSessionValue('selected_month', date("m"));
	$selectedYear = $this->getPortletSessionValue('selected_year', date("Y"));

	$tmpDay = getdate(mktime(0, 0, 0, $selectedMonth, 1, $selectedYear));
	$firstDay = $tmpDay;
	$lastDay = getdate(strtotime($tmpDay["year"] . "-" .  (((int)$tmpDay["mon"])+1) . "-" . (((int)$tmpDay["mday"])-1)));
	$eventColumn = "pge_" . P('event_column');

	$resultCount = -1;
	$filterApplied = false;
	$resultPage->setShowPage(1); 
	$resultPage->setShowRows('all'); 	
	$resultsPage = $resultPage->getTableData($resultCount, $filterApplied);
	$events = array();
	foreach ($resultsPage as $resultPage) {
		if (isset($resultPage[$eventColumn]) && isset($events[substr($resultPage[$eventColumn], 0, 10)])) {
			$eventsInDay = $events[substr($resultPage[$eventColumn], 0, 10)];
		} else {
			$eventsInDay = array();
		}
		$eventObject = new virgoPage($resultPage['pge_id']);
		$eventsInDay[] = $eventObject;
		$events[substr($resultPage[$eventColumn], 0, 10)] = $eventsInDay;
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
				<input type='hidden' name='pge_id_<?php echo $this->getId() ?>' value=''/>
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');
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
			foreach ($eventsInDay as $resultPage) {
?>
<?php
PROFILE('token');
	if (isset($resultPage)) {
		$tmpId = is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId();
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($resultPage->getVirgoTitle()) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php				
//				echo "<span class='virgo_calendar_event' onclick='var form=document.getElementById(\"portlet_form_".$this->getId()."\");form.portlet_action.value=\"View\";form.pge_id_".$this->getId().".value=\"".$eventInDay->getId()."\";form.submit();'>" . $eventInDay->getVirgoTitle() . "</span>";
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
			var pageChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == pageChildrenDivOpen) {
					div.style.display = 'none';
					pageChildrenDivOpen = '';
				} else {
					if (pageChildrenDivOpen != '') {
						document.getElementById(pageChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					pageChildrenDivOpen = clickedDivId;
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
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php');
			$showPage = $resultPage->getShowPage(); 
			$showRows = $resultPage->getShowRows(); 
?>
						<input type="text" name="pge_id_<?php echo $this->getId() ?>" id="pge_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
				<tr><td colspan="99" class="nav-header"><?php echo T('Pages') ?></td></tr>
<?php
			}
?>			
<?php
PROFILE('table_02');
PROFILE('main select');
			$virgoOrderColumn = $resultPage->getOrderColumn();
			$virgoOrderMode = $resultPage->getOrderMode();
			$resultCount = -1;
			$filterApplied = false;
			$resultsPage = $resultPage->getTableData($resultCount, $filterApplied);
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
	if (P('show_table_title', "1") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultPage->getOrderColumn(); 
	$om = $resultPage->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'pge_title');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('TITLE') ?>							<?php echo ($oc == "pge_title" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoPage::getLocalSessionValue('VirgoFilterTitle', null);
?>
						<input
							name="virgo_filter_title"
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
	if (P('show_table_alias', "1") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultPage->getOrderColumn(); 
	$om = $resultPage->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'pge_alias');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('ALIAS') ?>							<?php echo ($oc == "pge_alias" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoPage::getLocalSessionValue('VirgoFilterAlias', null);
?>
						<input
							name="virgo_filter_alias"
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
	if (P('show_table_default', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultPage->getOrderColumn(); 
	$om = $resultPage->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'pge_default');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('DEFAULT') ?>							<?php echo ($oc == "pge_default" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoPage::getLocalSessionValue('VirgoFilterDefault', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_order', "0") == "1") {
?>
				<th align="right" valign="middle" rowspan="2" style="text-align: right;">
<?php
	$oc = $resultPage->getOrderColumn(); 
	$om = $resultPage->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'pge_order');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('ORDER') ?>							<?php echo ($oc == "pge_order" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoPage::getLocalSessionValue('VirgoFilterOrder', null);
?>
						<input
							name="virgo_filter_order"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
							style="margin-left: auto; width: 40px; text-align: right;"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_path', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultPage->getOrderColumn(); 
	$om = $resultPage->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'pge_path');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('PATH') ?>							<?php echo ($oc == "pge_path" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoPage::getLocalSessionValue('VirgoFilterPath', null);
?>
						<input
							name="virgo_filter_path"
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
if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'controller.php') && P('show_table_template', "1") != "0"  && !isset($parentsInContext['portal\\virgoTemplate'])  ) {
	if (P('show_table_template', "1") == "2") {
		$tmpLookupTemplate = virgoTemplate::getVirgoListStatic();
?>
<input name='pge_Template_id_<?php echo $this->getId() ?>' id='pge_Template_id_<?php echo $this->getId() ?>' type="hidden"/>
<?php		
	}
?>
				<th align="center" valign="middle" rowspan=" 2"><!-- bylo: nowrap -->
<?php
	$oc = $resultPage->getOrderColumn(); 
	$om = $resultPage->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder';
	_pSF(form, 'virgo_order_column', 'template');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('TEMPLATE') ?>&nbsp;
<?php echo T('') ?>							<?php echo ($oc == "template" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$parentsCount = virgoTemplate::getVirgoListStatic('', true);
		if ($parentsCount < 51) {
			$parents = virgoTemplate::getVirgoListStatic();
			$parentFilter = virgoPage::getLocalSessionValue('VirgoFilterTemplate', null);
?>
						<select 
							name="virgo_filter_template"
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
			$parentFilter = virgoPage::getLocalSessionValue('VirgoFilterTitleTemplate', null);
?>
						<input
							name="virgo_filter_title_template"
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
if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php') && P('show_table_page', "1") != "0"  && !isset($parentsInContext['portal\\virgoPage'])  ) {
	if (P('show_table_page', "1") == "2") {
		$tmpLookupPage = virgoPage::getVirgoListStatic();
?>
<input name='pge_Page_id_<?php echo $this->getId() ?>' id='pge_Page_id_<?php echo $this->getId() ?>' type="hidden"/>
<?php		
	}
?>
				<th align="center" valign="middle" rowspan=" 2"><!-- bylo: nowrap -->
<?php
	$oc = $resultPage->getOrderColumn(); 
	$om = $resultPage->getOrderMode();
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
			$parentFilter = virgoPage::getLocalSessionValue('VirgoFilterPage', null);
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
			$parentFilter = virgoPage::getLocalSessionValue('VirgoFilterTitlePage', null);
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
if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php') && P('show_table_portal', "1") != "0"  && !isset($parentsInContext['portal\\virgoPortal'])  ) {
	if (P('show_table_portal', "1") == "2") {
		$tmpLookupPortal = virgoPortal::getVirgoListStatic();
?>
<input name='pge_Portal_id_<?php echo $this->getId() ?>' id='pge_Portal_id_<?php echo $this->getId() ?>' type="hidden"/>
<?php		
	}
?>
				<th align="center" valign="middle" rowspan=" 2"><!-- bylo: nowrap -->
<?php
	$oc = $resultPage->getOrderColumn(); 
	$om = $resultPage->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder';
	_pSF(form, 'virgo_order_column', 'portal');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('PORTAL') ?>&nbsp;
<?php echo T('') ?>							<?php echo ($oc == "portal" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$parentsCount = virgoPortal::getVirgoListStatic('', true);
		if ($parentsCount < 51) {
			$parents = virgoPortal::getVirgoListStatic();
			$parentFilter = virgoPage::getLocalSessionValue('VirgoFilterPortal', null);
?>
						<select 
							name="virgo_filter_portal"
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
			$parentFilter = virgoPage::getLocalSessionValue('VirgoFilterTitlePortal', null);
?>
						<input
							name="virgo_filter_title_portal"
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
	if (class_exists('portal\virgoPermission') && P('show_table_permissions', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortletLocation') && P('show_table_portlet_locations', '0') == "1") {
?>
				<th align="center" valign="middle" rowspan=" 2"><!-- bylo: nowrap -->
						<span style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('PAGE') ?>&nbsp;
<?php echo T('') ?>							<?php echo ($oc == "page" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
				</th>			
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPage') && P('show_table_pages', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoUser') && P('show_table_users', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoRole') && P('show_table_roles', '0') == "1") {
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
					$resultPage->setShowPage($showPage);
				}
				$index = 0;
PROFILE('table_04');
PROFILE('rows rendering');
				$contextRowIdInTable = null;
				$firstRowId = null;
				foreach ($resultsPage as $resultPage) {
					$index = $index + 1;
?>
<?php
$fileNameToInclude = PORTAL_PATH . "/portlets/portal/virgoPage/modules/renderTableRow_{$_SESSION['current_portlet_object_id']}.php";
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
	$fileNameToInclude = PORTAL_PATH . "/portlets/portal/modules/renderTableRow.php";
} 
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
?>
<?php
			if (P('form_only') != "4" || (P('chessboard_width') != 0 && $index % P('chessboard_width') == 1)) {
				if (is_null($firstRowId)) {
					$firstRowId = $resultPage['pge_id'];
				}
				$displayClass = ' displayClass ';
				$tmpContextId = virgoPage::getContextId();
				if (is_null($tmpContextId)) {
					$forceContextOnFirstRow = P('force_context_on_first_row', "1");
					if ($forceContextOnFirstRow == "1") {
						virgoPage::setContextId($resultPage['pge_id'], false);
						$tmpContextId = $resultPage['pge_id'];
					}
				}
				if (isset($tmpContextId) && $resultPage['pge_id'] == $tmpContextId) {
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
				id="<?php echo $this->getId() ?>_<?php echo isset($resultPage['pge_id']) ? $resultPage['pge_id'] : "" ?>" 
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
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultPage['pge_id'] ?>">
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
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultPage['pge_id'] ?>">
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
PROFILE('title');
	if (P('show_table_title', "1") == "1") {
PROFILE('render_data_table_title');
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
			<li class="title">
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
					form.pge_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPage['pge_id']) ? $resultPage['pge_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultPage['pge_title'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_title');
	}
PROFILE('title');
?>
<?php
PROFILE('alias');
	if (P('show_table_alias', "1") == "1") {
PROFILE('render_data_table_alias');
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
			<li class="alias">
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
					form.pge_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPage['pge_id']) ? $resultPage['pge_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultPage['pge_alias'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_alias');
	}
PROFILE('alias');
?>
<?php
PROFILE('default');
	if (P('show_table_default', "0") == "1") {
PROFILE('render_data_table_default');
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
			<li class="default">
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
					form.pge_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPage['pge_id']) ? $resultPage['pge_id'] : '' ?>'; 
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
	$canEditBoolean = ($this->canEdit() && P('show_form_default', "1") == "1");
	if ($resultPage['pge_default'] == 2 || is_null($resultPage['pge_default'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_default_<?php echo $resultPage['pge_id'] ?>'); return false;"><?php echo is_null($resultPage['pge_default']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_default_<?php echo $resultPage['pge_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetDefaultTrue';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo $resultPage['pge_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetDefaultFalse';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo $resultPage['pge_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultPage['pge_default'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_default_<?php echo $resultPage['pge_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_default_<?php echo $resultPage['pge_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetDefaultFalse';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo $resultPage['pge_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultPage['pge_default'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_default_<?php echo $resultPage['pge_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_default_<?php echo $resultPage['pge_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetDefaultTrue';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo $resultPage['pge_id'] ?>');
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
PROFILE('render_data_table_default');
	}
PROFILE('default');
?>
<?php
PROFILE('order');
	if (P('show_table_order', "0") == "1") {
PROFILE('render_data_table_order');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="right" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: right;"
			>
<?php
			} else {
?>
			<li class="order">
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
					form.pge_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPage['pge_id']) ? $resultPage['pge_id'] : '' ?>'; 
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
		<span style="white-space: nowrap;" class="<?php echo 'displayClass' ?>">
			<?php echo 
				$resultPage['pge_order'] 
			?>
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
PROFILE('render_data_table_order');
	}
PROFILE('order');
?>
<?php
PROFILE('path');
	if (P('show_table_path', "0") == "1") {
PROFILE('render_data_table_path');
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
			<li class="path">
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
					form.pge_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPage['pge_id']) ? $resultPage['pge_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultPage['pge_path'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_path');
	}
PROFILE('path');
?>
<?php
	if (class_exists('portal\virgoTemplate') && P('show_table_template', "1") != "0"  && !isset($parentsInContext["portal\\virgoTemplate"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_template', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="template">
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
					form.pge_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPage['pge_id']) ? $resultPage['pge_id'] : '' ?>'; 
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
	if (P('show_table_template', "1") == "1") {
		if (isset($resultPage['template'])) {
			echo $resultPage['template'];
		}
	} else {
//		echo $resultPage['pge_tmp_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetTemplate';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo $resultPage['pge_id'] ?>');
	_pSF(form, 'pge_Template_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
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
		foreach ($tmpLookupTemplate as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultPage['pge_tmp_id'] ? " selected " : "" ?>><?php echo $label ?></option>
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
					form.pge_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPage['pge_id']) ? $resultPage['pge_id'] : '' ?>'; 
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
		if (isset($resultPage['page'])) {
			echo $resultPage['page'];
		}
	} else {
//		echo $resultPage['pge_pge_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetPage';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo $resultPage['pge_id'] ?>');
	_pSF(form, 'pge_Page_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
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
			<option value="<?php echo $value ?>" <?php echo $value == $resultPage['pge_pge_id'] ? " selected " : "" ?>><?php echo $label ?></option>
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
	if (class_exists('portal\virgoPortal') && P('show_table_portal', "1") != "0"  && !isset($parentsInContext["portal\\virgoPortal"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_portal', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="portal">
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
					form.pge_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPage['pge_id']) ? $resultPage['pge_id'] : '' ?>'; 
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
	if (P('show_table_portal', "1") == "1") {
		if (isset($resultPage['portal'])) {
			echo $resultPage['portal'];
		}
	} else {
//		echo $resultPage['pge_prt_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetPortal';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo $resultPage['pge_id'] ?>');
	_pSF(form, 'pge_Portal_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
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
<?php
		foreach ($tmpLookupPortal as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultPage['pge_prt_id'] ? " selected " : "" ?>><?php echo $label ?></option>
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
	if (class_exists('portal\virgoPermission') && P('show_table_permissions', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortletLocation') && P('show_table_portlet_locations', '0') == "1") {
?>
<td>
<?php
	$record = new portal\virgoPage();
	$recordId = is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->pge_id;
	$record->load($recordId);
	$subrecordsPortletLocations = $record->getPortletLocations();
	$sizePortletLocations = count($subrecordsPortletLocations);
?>
<?php
	if ($sizePortletLocations == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPortletLocations as $subrecord) {
			$subrecordIndex++;
			$parentPortletObject = new portal\virgoPortletObject($subrecord->getPobId());
			echo htmlentities($parentPortletObject->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePortletLocations) {
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
	if (class_exists('portal\virgoPage') && P('show_table_pages', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoUser') && P('show_table_users', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoRole') && P('show_table_roles', '0') == "1") {
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
	if (isset($resultPage)) {
		$tmpId = is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId();
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("PAGE"), "\\'".rawurlencode($resultPage['pge_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
			if ($this->canExecute("form")) {
	if ($virgoOrderColumn == "pge_order") {
?>	
<input type="hidden" name="virgo_swap_down_with_<?php echo $resultPage['pge_id'] ?>" id="virgo_swap_down_with_<?php echo $resultPage['pge_id'] ?>" value="">
<td>
<?php
		if (isset($virgoPreviousId)) {
?>
<input type="hidden" name="virgo_swap_up_with_<?php echo $resultPage['pge_id'] ?>" value="<?php echo $virgoPreviousId ?>">
<script type="text/javascript">
var f = document.getElementById("virgo_swap_down_with_<?php echo $virgoPreviousId ?>");
f.value = <?php echo $resultPage['pge_id'] ?>;
f = document.getElementById("arrow_down_<?php echo $virgoPreviousId ?>");
f.style.display = 'block';
</script>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('VirgoUp')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_virgoup inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='VirgoUp';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('↑') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
		}
?>
</td>
<td>
<div id="arrow_down_<?php echo $resultPage['pge_id'] ?>" style="display: none;">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('VirgoDown')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_virgodown inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='VirgoDown';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('↓') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</div>
</td>
<?php		
		$virgoPreviousId = $resultPage['pge_id'];
	}
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultPage['pge_id'] ?>">
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
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultPage['pge_id'] ?>">
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
PROFILE('title');
	if (P('show_table_title', "1") == "1") {
PROFILE('render_data_table_title');
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
			<li class="title">
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
					form.pge_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPage['pge_id']) ? $resultPage['pge_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultPage['pge_title'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_title');
	}
PROFILE('title');
?>
<?php
PROFILE('alias');
	if (P('show_table_alias', "1") == "1") {
PROFILE('render_data_table_alias');
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
			<li class="alias">
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
					form.pge_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPage['pge_id']) ? $resultPage['pge_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultPage['pge_alias'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_alias');
	}
PROFILE('alias');
?>
<?php
PROFILE('default');
	if (P('show_table_default', "0") == "1") {
PROFILE('render_data_table_default');
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
			<li class="default">
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
					form.pge_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPage['pge_id']) ? $resultPage['pge_id'] : '' ?>'; 
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
	$canEditBoolean = ($this->canEdit() && P('show_form_default', "1") == "1");
	if ($resultPage['pge_default'] == 2 || is_null($resultPage['pge_default'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_default_<?php echo $resultPage['pge_id'] ?>'); return false;"><?php echo is_null($resultPage['pge_default']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_default_<?php echo $resultPage['pge_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetDefaultTrue';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo $resultPage['pge_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetDefaultFalse';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo $resultPage['pge_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultPage['pge_default'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_default_<?php echo $resultPage['pge_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_default_<?php echo $resultPage['pge_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetDefaultFalse';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo $resultPage['pge_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultPage['pge_default'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_default_<?php echo $resultPage['pge_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_default_<?php echo $resultPage['pge_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetDefaultTrue';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo $resultPage['pge_id'] ?>');
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
PROFILE('render_data_table_default');
	}
PROFILE('default');
?>
<?php
PROFILE('order');
	if (P('show_table_order', "0") == "1") {
PROFILE('render_data_table_order');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="right" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: right;"
			>
<?php
			} else {
?>
			<li class="order">
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
					form.pge_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPage['pge_id']) ? $resultPage['pge_id'] : '' ?>'; 
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
		<span style="white-space: nowrap;" class="<?php echo 'displayClass' ?>">
			<?php echo 
				$resultPage['pge_order'] 
			?>
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
PROFILE('render_data_table_order');
	}
PROFILE('order');
?>
<?php
PROFILE('path');
	if (P('show_table_path', "0") == "1") {
PROFILE('render_data_table_path');
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
			<li class="path">
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
					form.pge_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPage['pge_id']) ? $resultPage['pge_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultPage['pge_path'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_path');
	}
PROFILE('path');
?>
<?php
	if (class_exists('portal\virgoTemplate') && P('show_table_template', "1") != "0"  && !isset($parentsInContext["portal\\virgoTemplate"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_template', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="template">
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
					form.pge_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPage['pge_id']) ? $resultPage['pge_id'] : '' ?>'; 
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
	if (P('show_table_template', "1") == "1") {
		if (isset($resultPage['template'])) {
			echo $resultPage['template'];
		}
	} else {
//		echo $resultPage['pge_tmp_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetTemplate';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo $resultPage['pge_id'] ?>');
	_pSF(form, 'pge_Template_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
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
		foreach ($tmpLookupTemplate as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultPage['pge_tmp_id'] ? " selected " : "" ?>><?php echo $label ?></option>
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
					form.pge_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPage['pge_id']) ? $resultPage['pge_id'] : '' ?>'; 
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
		if (isset($resultPage['page'])) {
			echo $resultPage['page'];
		}
	} else {
//		echo $resultPage['pge_pge_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetPage';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo $resultPage['pge_id'] ?>');
	_pSF(form, 'pge_Page_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
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
			<option value="<?php echo $value ?>" <?php echo $value == $resultPage['pge_pge_id'] ? " selected " : "" ?>><?php echo $label ?></option>
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
	if (class_exists('portal\virgoPortal') && P('show_table_portal', "1") != "0"  && !isset($parentsInContext["portal\\virgoPortal"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_portal', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="portal">
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
					form.pge_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPage['pge_id']) ? $resultPage['pge_id'] : '' ?>'; 
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
	if (P('show_table_portal', "1") == "1") {
		if (isset($resultPage['portal'])) {
			echo $resultPage['portal'];
		}
	} else {
//		echo $resultPage['pge_prt_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetPortal';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo $resultPage['pge_id'] ?>');
	_pSF(form, 'pge_Portal_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
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
<?php
		foreach ($tmpLookupPortal as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultPage['pge_prt_id'] ? " selected " : "" ?>><?php echo $label ?></option>
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
	if (class_exists('portal\virgoPermission') && P('show_table_permissions', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortletLocation') && P('show_table_portlet_locations', '0') == "1") {
?>
<td>
<?php
	$record = new portal\virgoPage();
	$recordId = is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->pge_id;
	$record->load($recordId);
	$subrecordsPortletLocations = $record->getPortletLocations();
	$sizePortletLocations = count($subrecordsPortletLocations);
?>
<?php
	if ($sizePortletLocations == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPortletLocations as $subrecord) {
			$subrecordIndex++;
			$parentPortletObject = new portal\virgoPortletObject($subrecord->getPobId());
			echo htmlentities($parentPortletObject->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePortletLocations) {
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
	if (class_exists('portal\virgoPage') && P('show_table_pages', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoUser') && P('show_table_users', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoRole') && P('show_table_roles', '0') == "1") {
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
	if (isset($resultPage)) {
		$tmpId = is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId();
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("PAGE"), "\\'".rawurlencode($resultPage['pge_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
			if ($this->canExecute("form")) {
	if ($virgoOrderColumn == "pge_order") {
?>	
<input type="hidden" name="virgo_swap_down_with_<?php echo $resultPage['pge_id'] ?>" id="virgo_swap_down_with_<?php echo $resultPage['pge_id'] ?>" value="">
<td>
<?php
		if (isset($virgoPreviousId)) {
?>
<input type="hidden" name="virgo_swap_up_with_<?php echo $resultPage['pge_id'] ?>" value="<?php echo $virgoPreviousId ?>">
<script type="text/javascript">
var f = document.getElementById("virgo_swap_down_with_<?php echo $virgoPreviousId ?>");
f.value = <?php echo $resultPage['pge_id'] ?>;
f = document.getElementById("arrow_down_<?php echo $virgoPreviousId ?>");
f.style.display = 'block';
</script>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('VirgoUp')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_virgoup inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='VirgoUp';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('↑') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
		}
?>
</td>
<td>
<div id="arrow_down_<?php echo $resultPage['pge_id'] ?>" style="display: none;">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('VirgoDown')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_virgodown inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='VirgoDown';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('↓') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</div>
</td>
<?php		
		$virgoPreviousId = $resultPage['pge_id'];
	}
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
			virgoPage::setContextId($firstRowId, false);
			if (P('form_only') != "4") {
?>
<script type="text/javascript">
		$('form#portlet_form_<?php echo $this->getId() ?> table.data_table tr#<?php echo $this->getId() ?>_<?php echo $firstRowId ?>').addClass("contextClass");
</script>
<?php
			}
		}
	}				
				unset($resultPage);
				unset($resultsPage);
				if (isset($contextIdOwn) && trim($contextIdOwn) != "") {
					if ($contextIdConfirmed == false) {
						$tmpPage = new virgoPage();
						$tmpCount = $tmpPage->getAllRecordCount(' pge_id = ' . $contextIdOwn);
						if ($tmpCount == 0) {
							virgoPage::clearRemoteContextId($tabModeEditMenu);
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
		$.getJSON('<?php echo $page->getUrl() ?>?portlet_action=SelectJson&pge_id_<?php echo $this->getId() ?>=' + virgoId + '&invoked_portlet_object_id=<?php echo $this->getId() ?>&virgo_action_mode_json=T&_virgo_ajax=1', function(data) {
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
		form.pge_id_<?php echo $this->getId() ?>.value=virgoId; 
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
		form.pge_id_<?php echo $this->getId() ?>.value=virgoId; 
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'pge_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'pge_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Report';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'pge_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'pge_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Export';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'pge_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'pge_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Offline';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');
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
					$sessionSeparator = virgoPage::getImportFieldSeparator();
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
						$sessionSeparator = virgoPage::getImportFieldSeparator();
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');
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
									if (!confirm(decodeURIComponent('<?php echo T('ARE_YOU_SURE_YOU_WANT_REMOVE', T('PAGES'), "") ?>'))) return false;
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');
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
	} elseif ($pageDisplayMode == "TABLE_FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_page") {
			  if (check.value == 'T') {
				  return "<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>";
			  }
		  }
        }
  }
</script>
		<script type="text/javascript">
			var pageChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == pageChildrenDivOpen) {
					div.style.display = 'none';
					pageChildrenDivOpen = '';
				} else {
					if (pageChildrenDivOpen != '') {
						document.getElementById(pageChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					pageChildrenDivOpen = clickedDivId;
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

	<form method="post" style="display: inline;" action="" id="virgo_form_page" name="virgo_form_page" enctype="multipart/form-data">
						<input type="text" name="pge_id_<?php echo $this->getId() ?>" id="pge_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

		<table class="data_table" cellpadding="0" cellspacing="0">
			<tr class="data_table_header">
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
	if (P('show_table_title', "1") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Title
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_alias', "1") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Alias
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_default', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Default
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_order', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Order
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_path', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Path
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_template', "1") == "1" /* && ($masterComponentName != "template" || is_null($contextId)) */) {
?>
				<td align="center" nowrap>Template </td>
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
<?php
	if (P('show_table_portal', "1") == "1" /* && ($masterComponentName != "portal" || is_null($contextId)) */) {
?>
				<td align="center" nowrap>Portal </td>
<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$resultsPage = $resultPage->getRecordsToEdit();
				$idsToCorrect = $resultPage->getInvalidRecords();
				$index = 0;
PROFILE('rows rendering');
				foreach ($resultsPage as $resultPage) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultPage->pge_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
<?php
	if ($resultPage->pge_id == 0 && R('virgo_validate_new', "N") == "N") {
?>
		style="display: none;"
<?php
	}
?>
			>
<?php
PROFILE('title');
	if (P('show_table_title', "1") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 0;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pge_title_<?php echo $resultPage->getId() ?>" 
							name="pge_title_<?php echo $resultPage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPage->getTitle(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_TITLE');
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
$('#pge_title_<?php echo $resultPage->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('title');
	} else {
?> 
						<input
							type="hidden"
							id="title_<?php echo $resultPage->pge_id ?>" 
							name="title_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_title, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('alias');
	if (P('show_table_alias', "1") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 1;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pge_alias_<?php echo $resultPage->getId() ?>" 
							name="pge_alias_<?php echo $resultPage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPage->getAlias(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_ALIAS');
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
$('#pge_alias_<?php echo $resultPage->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('alias');
	} else {
?> 
						<input
							type="hidden"
							id="alias_<?php echo $resultPage->pge_id ?>" 
							name="alias_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_alias, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('default');
	if (P('show_table_default', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 2;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
<select class="inputbox" id="pge_default_<?php echo $resultPage->getId() ?>" name="pge_default_<?php echo $resultPage->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_DEFAULT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPage->getDefault() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPage->getDefault() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPage->getDefault()) || $resultPage->getDefault() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pge_default_<?php echo $resultPage->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
PROFILE('default');
	} else {
?> 
						<input
							type="hidden"
							id="default_<?php echo $resultPage->pge_id ?>" 
							name="default_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_default, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('order');
	if (P('show_table_order', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 3;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_order_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pge_order_<?php echo $resultPage->getId() ?>" 
							name="pge_order_<?php echo $resultPage->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPage->getOrder(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_ORDER');
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
$('#pge_order_<?php echo $resultPage->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('order');
	} else {
?> 
						<input
							type="hidden"
							id="order_<?php echo $resultPage->pge_id ?>" 
							name="order_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_order, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('path');
	if (P('show_table_path', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPage) * 4;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_path_obligatory', "0") == "1" ? " obligatory " : "" ?>   long  " 
							type="text"
							id="pge_path_<?php echo $resultPage->getId() ?>" 
							name="pge_path_<?php echo $resultPage->getId() ?>"
							maxlength="2000"
							size="50" 
							value="<?php echo htmlentities($resultPage->getPath(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_PATH');
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
$('#pge_path_<?php echo $resultPage->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('path');
	} else {
?> 
						<input
							type="hidden"
							id="path_<?php echo $resultPage->pge_id ?>" 
							name="path_<?php echo $resultPage->pge_id ?>"
							value="<?php echo htmlentities($resultPage->pge_path, ENT_QUOTES, "UTF-8") ?>"
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
	if (P('show_table_template', "1") == "1"/* && ($masterComponentName != "template" || is_null($contextId)) */) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPage) * 5;
?>
<?php
//		$limit_template = $componentParams->get('limit_to_template');
		$limit_template = null;
		$tmpId = portal\virgoPage::getParentInContext("portal\\virgoTemplate");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_template', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_tmp__id = $tmpId;
//			}
			if (!is_null($resultPage->getTmpId())) {
				$parentId = $resultPage->getTmpId();
				$parentValue = portal\virgoTemplate::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_template_<?php echo $resultPage->getId() ?>" name="pge_template_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<script type="text/javascript">
var arrayTemplate2Portal = new Array();

<?php
	$query = " SELECT DISTINCT prt_tmp_id AS parent_id FROM prt_portals "; // plus ograniczenia skonfigurowane
	$rows = QR($query);
	$rowsParent = $rows;
	foreach ($rowsParent as $rowParent) {
		if (!is_null($rowParent['parent_id'])) {
?>
	var arrayTemplate<?php echo $rowParent['parent_id'] ?>= new Array();	
<?php
			$query = " SELECT prt_id AS id, prt_virgo_title AS value FROM prt_portals WHERE prt_tmp_id = " . $rowParent['parent_id']; // plus ograniczenia skonfigurowane
	$rows = QR($query);
			foreach ($rows as $row) {
?>
	arrayTemplate<?php echo $rowParent['parent_id'] ?>['<?php echo $row["id"] ?>'] = '<?php echo $row["value"] ?>';	
<?php
			}
?>
	arrayTemplate2Portal[<?php echo $rowParent['parent_id'] ?>] = arrayTemplate<?php echo $rowParent['parent_id'] ?>;
		
<?php
		}
	}
?>

function addOptionPortal(select, optionText, optionValue, selectedValue) {
	var newOption = document.createElement('option');
	newOption.text = optionText;
	newOption.value = optionValue;
	if (optionValue == selectedValue) {
		newOption.selected = true;
	}
	try {
		select.add(newOption, null);
	} catch (ex) {
		select.add(newOption);
	}
}

function displayArrayPortal(select, arrayToShow, selectedValue) {
	select.length = 0;
	addOptionPortal(select, '', '', selectedValue);
	for (var id in arrayToShow){ 
		addOptionPortal(select, arrayToShow[id], id, selectedValue);
	} 
}

function updatePortal(parentId, childrenListId, selectedValue) {
	// alert('test: ' + parentId + ' '  + childrenListId);
	var childrenList = document.getElementById(childrenListId);
	if (childrenList.tagName.toUpperCase() == "SELECT") {
		if (childrenList) {
			var arrayToShow = arrayTemplate2Portal[parentId];
			displayArrayPortal(childrenList, arrayToShow, selectedValue);
		}
	}
}
</script>
<?php
	$hint = TE('HINT_PAGE_TEMPLATE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_template) && trim($limit_template) != "") {
		$whereList = $whereList . " tmp_id ";
		if (trim($limit_template) == "page_title") {
			$limit_template = "SELECT tmp_id FROM prt_templates WHERE tmp_" . $limit_template . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_template = \"$limit_template\";");
		$whereList = $whereList . " IN (" . $limit_template . ") ";
	}						
	$parentCount = portal\virgoTemplate::getVirgoListSize($whereList);
	$showAjaxpge = P('show_form_template', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_template_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="pge_template_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_template_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
<?php
	if (P('show_form_portal', "1") == "1") {
?>
								updatePortal(this.options[this.selectedIndex].value, 'pge_portal_<?php echo $resultPage->getId() ?>', <?php echo is_null($resultPage->getPortalId()) ? "null" : $resultPage->getPrtId() ?>);
<?php
	}
?>
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
			if (is_null($limit_template) || trim($limit_template) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsTemplate = portal\virgoTemplate::getVirgoList($whereList);
			while(list($id, $label)=each($resultsTemplate)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPage->getTmpId()) && $id == $resultPage->getTmpId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getTmpId();
				$parentTemplate = new portal\virgoTemplate();
				$parentValue = $parentTemplate->lookup($parentId);
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
	<input type="hidden" id="pge_template_<?php echo $resultPage->getId() ?>" name="pge_template_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="pge_template_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_template_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Template",
			virgo_field_name: "template",
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
					$('#pge_template_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_template_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (isset($context["tmp"])) {
		$parentValue = $context["tmp"];
	} else {
		$parentValue = $resultPage->pge_tmp_id;
	}
	
?>
				<input type="hidden" id="pge_template_<?php echo $resultPage->pge_id ?>" name="pge_template_<?php echo $resultPage->pge_id ?>" value="<?php echo $parentValue ?>">
<?php
	} 
?>
<?php
	if (P('show_table_page', "1") == "1"/* && ($masterComponentName != "page" || is_null($contextId)) */) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPage) * 6;
?>
<?php
//		$limit_page = $componentParams->get('limit_to_page');
		$limit_page = null;
		$readOnly = "";
		if (isset($tmpId) || P('show_form_page', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_pge__id = $tmpId;
//			}
			if (!is_null($resultPage->getPgeId())) {
				$parentId = $resultPage->getPgeId();
				$parentValue = portal\virgoPage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_page_<?php echo $resultPage->getId() ?>" name="pge_page_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PAGE_PAGE');
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
	$showAjaxpge = P('show_form_page', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_page_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="pge_page_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_page_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
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
				echo (!is_null($resultPage->getPgeId()) && $id == $resultPage->getPgeId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getPgeId();
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
	<input type="hidden" id="pge_page_<?php echo $resultPage->getId() ?>" name="pge_page_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="pge_page_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_page_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
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
					$('#pge_page_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_page_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
		$parentValue = $resultPage->pge_pge_id;
	}
	
?>
				<input type="hidden" id="pge_page_<?php echo $resultPage->pge_id ?>" name="pge_page_<?php echo $resultPage->pge_id ?>" value="<?php echo $parentValue ?>">
<?php
	} 
?>
<?php
	if (P('show_table_portal', "1") == "1"/* && ($masterComponentName != "portal" || is_null($contextId)) */) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPage) * 7;
?>
<?php
//		$limit_portal = $componentParams->get('limit_to_portal');
		$limit_portal = null;
		$tmpId = portal\virgoPage::getParentInContext("portal\\virgoPortal");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portal', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_prt__id = $tmpId;
//			}
			if (!is_null($resultPage->getPrtId())) {
				$parentId = $resultPage->getPrtId();
				$parentValue = portal\virgoPortal::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_portal_<?php echo $resultPage->getId() ?>" name="pge_portal_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PAGE_PORTAL');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portal) && trim($limit_portal) != "") {
		$whereList = $whereList . " prt_id ";
		if (trim($limit_portal) == "page_title") {
			$limit_portal = "SELECT prt_id FROM prt_portals WHERE prt_" . $limit_portal . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portal = \"$limit_portal\";");
		$whereList = $whereList . " IN (" . $limit_portal . ") ";
	}						
	$parentCount = portal\virgoPortal::getVirgoListSize($whereList);
	$showAjaxpge = P('show_form_portal', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pge_portal_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_portal_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
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
			if (is_null($limit_portal) || trim($limit_portal) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortal = portal\virgoPortal::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortal)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPage->getPrtId()) && $id == $resultPage->getPrtId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getPrtId();
				$parentPortal = new portal\virgoPortal();
				$parentValue = $parentPortal->lookup($parentId);
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
	<input type="hidden" id="pge_portal_<?php echo $resultPage->getId() ?>" name="pge_portal_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pge_portal_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_portal_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Portal",
			virgo_field_name: "portal",
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
					$('#pge_portal_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_portal_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="form">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddPortal')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addportal inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddPortal';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (isset($context["prt"])) {
		$parentValue = $context["prt"];
	} else {
		$parentValue = $resultPage->pge_prt_id;
	}
	
?>
				<input type="hidden" id="pge_portal_<?php echo $resultPage->pge_id ?>" name="pge_portal_<?php echo $resultPage->pge_id ?>" value="<?php echo $parentValue ?>">
<?php
	} 
?>
				<td>
<?php
	if (isset($idsToCorrect[$resultPage->pge_id])) {
		$errorMessage = $idsToCorrect[$resultPage->pge_id];
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div>					</td>
				</tr>
		</table>
	</form>
<?php
	} elseif ($pageDisplayMode == "ADD_NEW_PARENT_PORTAL") {
		$resultPortal = portal\virgoPortal::createGuiAware();
		$resultPortal->loadFromRequest();
?>
<fieldset>
	<label>Dodaj nowy rekord Portal</label>
<?php
	if (P('show_create_name', "1") == "1" || P('show_create_name', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="prt_name_<?php echo $resultPortal->getId() ?>">
* <?php echo T('NAME') ?>
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
			if (P('event_column') == "name") {
				$resultPage->setName($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPage->getName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="name" name="prt_name_<?php echo $resultPortal->getId() ?>" value="<?php echo htmlentities($resultPage->getName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="prt_name_<?php echo $resultPortal->getId() ?>" 
							name="prt_name_<?php echo $resultPortal->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortal->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_NAME');
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
$('#prt_name_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
	if (P('show_create_url', "1") == "1" || P('show_create_url', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_url_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prt_url_<?php echo $resultPortal->getId() ?>">
 <?php echo P('show_create_url_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('URL') ?>
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
			if (P('event_column') == "url") {
				$resultPage->setUrl($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_url', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPage->getUrl(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="url" name="prt_url_<?php echo $resultPortal->getId() ?>" value="<?php echo htmlentities($resultPage->getUrl(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_url_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prt_url_<?php echo $resultPortal->getId() ?>" 
							name="prt_url_<?php echo $resultPortal->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortal->getUrl(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_URL');
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
$('#prt_url_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
	if (P('show_create_identifier', "1") == "1" || P('show_create_identifier', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_identifier_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prt_identifier_<?php echo $resultPortal->getId() ?>">
 <?php echo P('show_create_identifier_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('IDENTIFIER') ?>
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
			if (P('event_column') == "identifier") {
				$resultPage->setIdentifier($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_identifier', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPage->getIdentifier(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="identifier" name="prt_identifier_<?php echo $resultPortal->getId() ?>" value="<?php echo htmlentities($resultPage->getIdentifier(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_identifier_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prt_identifier_<?php echo $resultPortal->getId() ?>" 
							name="prt_identifier_<?php echo $resultPortal->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortal->getIdentifier(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_IDENTIFIER');
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
$('#prt_identifier_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
	if (P('show_create_path', "1") == "1" || P('show_create_path', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_path_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prt_path_<?php echo $resultPortal->getId() ?>">
 <?php echo P('show_create_path_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('PATH') ?>
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
			if (P('event_column') == "path") {
				$resultPage->setPath($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_path', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPage->getPath(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="path" name="prt_path_<?php echo $resultPortal->getId() ?>" value="<?php echo htmlentities($resultPage->getPath(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_path_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prt_path_<?php echo $resultPortal->getId() ?>" 
							name="prt_path_<?php echo $resultPortal->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortal->getPath(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_PATH');
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
$('#prt_path_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
	if (P('show_create_tolerant_access_policy', "1") == "1" || P('show_create_tolerant_access_policy', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_tolerant_access_policy_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prt_tolerantAccessPolicy_<?php echo $resultPortal->getId() ?>">
 <?php echo P('show_create_tolerant_access_policy_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('TOLERANT_ACCESS_POLICY') ?>
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
			if (P('event_column') == "tolerant_access_policy") {
				$resultPage->setTolerantAccessPolicy($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_tolerant_access_policy', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="tolerantAccessPolicy"
>
<?php
	if (is_null($resultPage->pge_tolerant_access_policy) || $resultPage->pge_tolerant_access_policy == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultPage->pge_tolerant_access_policy == 1) {
		$booleanValue = T("YES");
	} elseif ($resultPage->pge_tolerant_access_policy === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
<select class="inputbox" id="prt_tolerantAccessPolicy_<?php echo $resultPortal->getId() ?>" name="prt_tolerantAccessPolicy_<?php echo $resultPortal->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_TOLERANT_ACCESS_POLICY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortal->getTolerantAccessPolicy() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortal->getTolerantAccessPolicy() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortal->getTolerantAccessPolicy()) || $resultPortal->getTolerantAccessPolicy() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prt_tolerantAccessPolicy_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
	if (P('show_create_user_class_namespace', "1") == "1" || P('show_create_user_class_namespace', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_user_class_namespace_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prt_userClassNamespace_<?php echo $resultPortal->getId() ?>">
 <?php echo P('show_create_user_class_namespace_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('USER_CLASS_NAMESPACE') ?>
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
			if (P('event_column') == "user_class_namespace") {
				$resultPage->setUserClassNamespace($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_user_class_namespace', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPage->getUserClassNamespace(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="userClassNamespace" name="prt_userClassNamespace_<?php echo $resultPortal->getId() ?>" value="<?php echo htmlentities($resultPage->getUserClassNamespace(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_user_class_namespace_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prt_userClassNamespace_<?php echo $resultPortal->getId() ?>" 
							name="prt_userClassNamespace_<?php echo $resultPortal->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortal->getUserClassNamespace(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_USER_CLASS_NAMESPACE');
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
$('#prt_userClassNamespace_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
	if (P('show_create_user_class_name', "1") == "1" || P('show_create_user_class_name', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_user_class_name_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prt_userClassName_<?php echo $resultPortal->getId() ?>">
 <?php echo P('show_create_user_class_name_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('USER_CLASS_NAME') ?>
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
			if (P('event_column') == "user_class_name") {
				$resultPage->setUserClassName($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_user_class_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPage->getUserClassName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="userClassName" name="prt_userClassName_<?php echo $resultPortal->getId() ?>" value="<?php echo htmlentities($resultPage->getUserClassName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_user_class_name_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prt_userClassName_<?php echo $resultPortal->getId() ?>" 
							name="prt_userClassName_<?php echo $resultPortal->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortal->getUserClassName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_USER_CLASS_NAME');
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
$('#prt_userClassName_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
	if (class_exists('portal\virgoTemplate') && ((P('show_create_template', "1") == "1" || P('show_create_template', "1") == "2" || P('show_create_template', "1") == "3") && !isset($context["tmp"]))) {
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
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_create_template_obligatory') == "1" ? " obligatory " : "" ?> " for="prt_template_<?php echo isset($resultPortal->prt_id) ? $resultPortal->prt_id : '' ?>">
<?php echo P('show_create_template_obligatory') == "1" ? " * " : "" ?>
<?php echo T('TEMPLATE') ?> <?php echo T('') ?>
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
//		$limit_template = $componentParams->get('limit_to_template');
		$limit_template = null;
		$tmpId = portal\virgoPage::getParentInContext("portal\\virgoTemplate");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_template', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortal->prt_tmp__id = $tmpId;
//			}
			if (!is_null($resultPortal->getTmpId())) {
				$parentId = $resultPortal->getTmpId();
				$parentValue = portal\virgoTemplate::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="prt_template_<?php echo $resultPortal->getId() ?>" name="prt_template_<?php echo $resultPortal->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PORTAL_TEMPLATE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_template) && trim($limit_template) != "") {
		$whereList = $whereList . " tmp_id ";
		if (trim($limit_template) == "page_title") {
			$limit_template = "SELECT tmp_id FROM prt_templates WHERE tmp_" . $limit_template . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_template = \"$limit_template\";");
		$whereList = $whereList . " IN (" . $limit_template . ") ";
	}						
	$parentCount = portal\virgoTemplate::getVirgoListSize($whereList);
	$showAjaxprt = P('show_create_template', "1") == "3" || $parentCount > 100;
	if (!$showAjaxprt) {
?>
    						<select 
							class="inputbox  <?php echo P('show_create_template_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="prt_template_<?php echo !is_null($resultPortal->getId()) ? $resultPortal->getId() : '' ?>" 
							name="prt_template_<?php echo !is_null($resultPortal->getId()) ? $resultPortal->getId() : '' ?>" 
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
			if (is_null($limit_template) || trim($limit_template) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsTemplate = portal\virgoTemplate::getVirgoList($whereList);
			while(list($id, $label)=each($resultsTemplate)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPortal->getTmpId()) && $id == $resultPortal->getTmpId() ? "selected='selected'" : "");
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
				$parentId = $resultPortal->getTmpId();
				$parentTemplate = new portal\virgoTemplate();
				$parentValue = $parentTemplate->lookup($parentId);
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
	<input type="hidden" id="prt_template_<?php echo $resultPortal->getId() ?>" name="prt_template_<?php echo $resultPortal->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="prt_template_dropdown_<?php echo $resultPortal->getId() ?>" 
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
        $( "#prt_template_dropdown_<?php echo $resultPortal->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Template",
			virgo_field_name: "template",
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
					$('#prt_template_<?php echo $resultPortal->getId() ?>').val(ui.item.value);
				  	$('#prt_template_dropdown_<?php echo $resultPortal->getId() ?>').val(ui.item.label);
				  	$('#prt_template_dropdown_<?php echo $resultPortal->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#prt_template_dropdown_<?php echo $resultPortal->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#prt_template_<?php echo $resultPortal->getId() ?>').val('');
				$('#prt_template_dropdown_<?php echo $resultPortal->getId() ?>').removeClass("locked");		
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
$('#pge_template_dropdown_<?php echo $resultPage->getId() ?>').qtip({position: {
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
	if (isset($context["tmp"])) {
		$parentValue = $context["tmp"];
	} else {
		$parentValue = $resultPage->pge_tmp_id;
	}
	
?>
				<input type="hidden" id="pge_template_<?php echo $resultPage->pge_id ?>" name="pge_template_<?php echo $resultPage->pge_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<input type="hidden" name="calling_view" value="<?php echo R('calling_view') ?>">
</fieldset>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('StoreNewPortal')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_storenewportal inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='StoreNewPortal';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('STORE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
 <div class="button_wrapper button_wrapper_backfromparent inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='BackFromParent';
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php
	$pobId = $_SESSION['current_portlet_object_id'];
	$childId = R('pge_id_' . $pobId);
?>
<input 
	type="hidden" 
	name="pge_id_<?php echo $pobId ?>" 
	value="<?php echo $childId ?>"
/>
<input 
	type="hidden" 
	name="pge_title_<?php echo $childId ?>" 
	value="<?php echo R('pge_title_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pge_alias_<?php echo $childId ?>" 
	value="<?php echo R('pge_alias_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pge_default_<?php echo $childId ?>" 
	value="<?php echo R('pge_default_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pge_order_<?php echo $childId ?>" 
	value="<?php echo R('pge_order_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pge_path_<?php echo $childId ?>" 
	value="<?php echo R('pge_path_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pge_template_<?php echo $childId ?>" 
	value="<?php echo R('pge_template_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pge_page_<?php echo $childId ?>" 
	value="<?php echo R('pge_page_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pge_portal_<?php echo $childId ?>" 
	value="<?php echo R('pge_portal_' . $childId) ?>"
/>
<?php		
	} else {
		$virgoShowReturn = true;
?>
		<div class="<?php echo $pageDisplayMode ?>">
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
	_pSF(form, 'pge_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPage) ? (is_array($resultPage) ? $resultPage['pge_id'] : $resultPage->getId()) : '' ?>');

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
<div style="display: none; background-color:#FFFFFF; border:1px solid #000000; font-size:10px; margin:10px 0; padding:10px;"; id="extraFilesInfo_prt_page" style="font-size: 12px; " onclick="document.getElementById('extraFilesInfo_prt_page').style.display='none';">
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
	$infos = virgoPage::getExtraFilesInfo();
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

