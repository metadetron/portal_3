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
	$componentParams = null; //&JComponentHelper::getParams('com_prt_role');
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
<link rel="stylesheet" href="<?php echo $live_site ?>/components/com_prt_role/portal.css" type="text/css" /> 
<?php
	}
?>
<?php
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoRole'.DIRECTORY_SEPARATOR.'prt_rle.css')) {
?>
<link rel="stylesheet" href="<?php echo $_SESSION['portal_url'] ?>/portlets/portal/virgoRole/prt_rle.css" type="text/css" /> 
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
<div class="virgo_container_portal virgo_container_entity_role" style="border: none;">
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
			$resultRole = virgoRole::createGuiAware();
			$contextId = $resultRole->getContextId();
			if (isset($contextId)) {
				if (virgoRole::getDisplayMode() != "CREATE" || R('portlet_action') == "Duplicate") {
					$resultRole->load($contextId);
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
		if ($className == "virgoRole") {
			$masterObject = new $className();
			$tmpId = $masterObject->getRemoteContextId($masterPobId);
			if (isset($tmpId)) {
				$resultRole = new virgoRole($tmpId);
				virgoRole::setDisplayMode("FORM");
			} else {
				$resultRole = new virgoRole();
				virgoRole::setDisplayMode("CREATE");
			}
		}
	} else {
		if (P('form_only', "0") == "5") {
			if (is_null($resultRole->getId())) { 
				if (P('only_private_records', "0") == "1") {
					$allPrivateRecords = $resultRole->selectAll();
					if (sizeof($allPrivateRecords) > 0) {
						$resultRole = new virgoRole($allPrivateRecords[0]['rle_id']);
						$resultRole->putInContext(false);
					} else {
						$resultRole = new virgoRole();
					}
				} else {
					$customSQL = P('custom_sql_condition');
					if (isset($customSQL) && trim($customSQL) != '') {
						$currentUser = virgoUser::getUser();
						$currentPage = virgoPage::getCurrentPage();
						eval("\$customSQL = \"$customSQL\";");
						$records = $resultRole->selectAll($customSQL);
						if (sizeof($records) > 0) {
							$resultRole = new virgoRole($records[0]['rle_id']);
							$resultRole->putInContext(false);
						} else {
							$resultRole = new virgoRole();
						}
					} else {
						$resultRole = new virgoRole();
					}
				}
			}
		} elseif (P('form_only', "0") == "6") {
			$resultRole = new virgoRole(virgoUser::getUserId());
			$resultRole->putInContext(false);
		}
	}
?>
<?php
		if (isset($includeError) && $includeError == 1) {
			$resultRole = new virgoRole();
		}
?>
<?php
	$roleDisplayMode = virgoRole::getDisplayMode();
//	if ($roleDisplayMode == "" || $roleDisplayMode == "TABLE") {
//		$resultRole = $resultRole->portletActionForm();
//	}
?>
		<div class="form">
<?php
		$parentContextInfos = $resultRole->getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
//			$whereClauseRole = $whereClauseRole . ' AND ' . $parentContextInfo['condition'];
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
		$criteriaRole = $resultRole->getCriteria();
		$countTmp = 0;
		if (isset($criteriaRole["name"])) {
			$fieldCriteriaName = $criteriaRole["name"];
			if ($fieldCriteriaName["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaName["value"];
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
		if (isset($criteriaRole["description"])) {
			$fieldCriteriaDescription = $criteriaRole["description"];
			if ($fieldCriteriaDescription["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaDescription["value"];
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
		if (isset($criteriaRole["session_duration"])) {
			$fieldCriteriaSessionDuration = $criteriaRole["session_duration"];
			if ($fieldCriteriaSessionDuration["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaSessionDuration["value"];
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
		if (isset($criteriaRole["page"])) {
			$parentCriteria = $criteriaRole["page"];
			if ($parentCriteria["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				if (isset($parentCriteria["value"]) && $parentCriteria["value"] != "") {
					$parentValue = $parentCriteria["value"];
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaRole["user"])) {
			$countTmp = $countTmp + 1;
		}
		if (is_null($criteriaRole) || sizeof($criteriaRole) == 0 || $countTmp == 0) {
		} else {
?>
			<input type="hidden" name="virgo_filter_column"/>
			<table class="db_criteria_record">
				<tr>
					<td colspan="3" class="db_criteria_message"><?php echo T('SEARCH_CRITERIA') ?></td>
				</tr>
<?php
			if (isset($criteriaRole["name"])) {
				$fieldCriteriaName = $criteriaRole["name"];
				if ($fieldCriteriaName["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Name') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaName["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaName["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='name';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Name') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='name';
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
			if (isset($criteriaRole["description"])) {
				$fieldCriteriaDescription = $criteriaRole["description"];
				if ($fieldCriteriaDescription["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Description') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaDescription["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaDescription["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='description';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaDescription["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Description') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='description';
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
			if (isset($criteriaRole["session_duration"])) {
				$fieldCriteriaSessionDuration = $criteriaRole["session_duration"];
				if ($fieldCriteriaSessionDuration["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Session duration') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaSessionDuration["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaSessionDuration["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='session_duration';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaSessionDuration["value"];
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
					<?php echo T('Session duration') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='session_duration';
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
			if (isset($criteriaRole["page"])) {
				$parentCriteria = $criteriaRole["page"];
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
		if (isset($criteriaRole["user"])) {
			$parentIds = $criteriaRole["user"];
		}
		if (isset($parentIds) && isset($parentIds['ids'])) {
			$selectedIds = $parentIds['ids'];
			$renderCriteria = "";
			foreach ($selectedIds as $id) {
				$obj = new portal\virgoUser($id['id']);
				$renderCriteria = ($renderCriteria == "" ? "" : $renderCriteria . ", ") . $obj->getVirgoTitle();
			}
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Users') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='user';
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
	if (isset($resultRole)) {
		$tmpId = is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
?>
<?php
	if ($roleDisplayMode != "TABLE") {
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
			$pob = $resultRole->getMyPortletObject();
			$reloadFromRequest = $pob->getPortletSessionValue('reload_from_request', '0');
			if (isset($invokedPortletId) && $invokedPortletId == $_SESSION['current_portlet_object_id'] && isset($reloadFromRequest) && $reloadFromRequest == "1") { 
				$pob->setPortletSessionValue('reload_from_request', '0');
				$resultRole->loadFromRequest();
			} else {
				if (P('form_only', "0") == "1" && isset($contextId)) {
					if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoRole'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
						require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoRole'.DIRECTORY_SEPARATOR.'create_store_message.php');
						$roleDisplayMode = "-empty-";
					}
				}
			}
		}
	}
if (!$resultRole->hideContentDueToNoParentSelected()) {
	$formsInTable = (P('forms_rendering', "false") == "true");
	if (!$formsInTable) {
		$floatingFields = (P('forms_rendering', "false") == "float" || P('forms_rendering', "false") == "float-grid");
		$floatingGridFields = (P('forms_rendering', "false") == "float-grid");
	}
/* MILESTONE 1.1 Form */
	$tabIndex = 1;
	$parentAjaxRendered = "0";
	if ($roleDisplayMode == "FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_role") {
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
<?php echo T('ROLE') ?>:</legend>
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
	if (P('show_form_name', "1") == "1" || P('show_form_name', "1") == "2") {
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
						class="fieldlabel  obligatory   name varchar" 
						for="rle_name_<?php echo $resultRole->getId() ?>"
					>* <?php echo T('NAME') ?>
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
	if (P('show_form_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultRole->getName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="name" name="rle_name_<?php echo $resultRole->getId() ?>" value="<?php echo htmlentities($resultRole->getName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultRole)) {
		$resultRole = new portal\virgoRole();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="rle_name_<?php echo $resultRole->getId() ?>" 
							name="rle_name_<?php echo $resultRole->getId() ?>"
							maxlength="255"
							size="30" 
							value="<?php echo htmlentities($resultRole->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ROLE_NAME');
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
$('#rle_name_<?php echo $resultRole->getId() ?>').qtip({position: {
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
	if (P('show_form_description', "1") == "1" || P('show_form_description', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_description_obligatory', "0") == "1" ? " obligatory " : "" ?>   description text" 
						for="rle_description_<?php echo $resultRole->getId() ?>"
					> <?php echo P('show_form_description_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('DESCRIPTION') ?>
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
	if (P('show_form_description', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid; display: inline-block;" 
	class="inputbox readonly description" 
	id="description" 
><?php echo htmlentities($resultRole->rle_description, ENT_QUOTES, "UTF-8") ?></div>

<?php
	} else {
?>
<?php
	if (!isset($resultRole)) {
		$resultRole = new portal\virgoRole();
	}
?>
<textarea 
	class="inputbox description" 
	id="rle_description_<?php echo $resultRole->getId() ?>" 
	name="rle_description_<?php echo $resultRole->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ROLE_DESCRIPTION');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultRole->getDescription(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rle_description_<?php echo $resultRole->getId() ?>').qtip({position: {
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
	if (P('show_form_session_duration', "1") == "1" || P('show_form_session_duration', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_session_duration_obligatory', "0") == "1" ? " obligatory " : "" ?>   session_duration integer" 
						for="rle_sessionDuration_<?php echo $resultRole->getId() ?>"
					> <?php echo P('show_form_session_duration_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('SESSION_DURATION') ?>
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
	if (P('show_form_session_duration', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultRole->getSessionDuration(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="sessionDuration" name="rle_sessionDuration_<?php echo $resultRole->getId() ?>" value="<?php echo htmlentities($resultRole->getSessionDuration(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultRole)) {
		$resultRole = new portal\virgoRole();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_session_duration_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="rle_sessionDuration_<?php echo $resultRole->getId() ?>" 
							name="rle_sessionDuration_<?php echo $resultRole->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultRole->getSessionDuration(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ROLE_SESSION_DURATION');
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
$('#rle_sessionDuration_<?php echo $resultRole->getId() ?>').qtip({position: {
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
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_form_page_obligatory') == "1" ? " obligatory " : "" ?> " for="rle_page_<?php echo isset($resultRole->rle_id) ? $resultRole->rle_id : '' ?>">
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
		$tmpId = portal\virgoRole::getParentInContext("portal\\virgoPage");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_page', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultRole->rle_pge__id = $tmpId;
//			}
			if (!is_null($resultRole->getPgeId())) {
				$parentId = $resultRole->getPgeId();
				$parentValue = portal\virgoPage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="rle_page_<?php echo $resultRole->getId() ?>" name="rle_page_<?php echo $resultRole->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_ROLE_PAGE');
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
	$showAjaxrle = P('show_form_page', "1") == "3" || $parentCount > 100;
	if (!$showAjaxrle) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_page_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="rle_page_<?php echo !is_null($resultRole->getId()) ? $resultRole->getId() : '' ?>" 
							name="rle_page_<?php echo !is_null($resultRole->getId()) ? $resultRole->getId() : '' ?>" 
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
				echo (!is_null($resultRole->getPgeId()) && $id == $resultRole->getPgeId() ? "selected='selected'" : "");
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
				$parentId = $resultRole->getPgeId();
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
	<input type="hidden" id="rle_page_<?php echo $resultRole->getId() ?>" name="rle_page_<?php echo $resultRole->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="rle_page_dropdown_<?php echo $resultRole->getId() ?>" 
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
        $( "#rle_page_dropdown_<?php echo $resultRole->getId() ?>" ).autocomplete({
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
					$('#rle_page_<?php echo $resultRole->getId() ?>').val(ui.item.value);
				  	$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').val(ui.item.label);
				  	$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#rle_page_<?php echo $resultRole->getId() ?>').val('');
				$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').removeClass("locked");		
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
$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').qtip({position: {
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
		$parentValue = $resultRole->rle_pge_id;
	}
	
?>
				<input type="hidden" id="rle_page_<?php echo $resultRole->rle_id ?>" name="rle_page_<?php echo $resultRole->rle_id ?>" value="<?php echo $parentValue ?>">
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
					<label nowrap class="fieldlabel userRole" for="rle_userRole_<?php echo $resultRole->getId() ?>[]">
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
			$parentUser = new portal\virgoUser();
			$whereList = "";
			$resultsUser = $parentUser->getVirgoList($whereList);
			$currentConnections = $resultRole->getUserRoles();
			$currentIds = array();
			foreach ($currentConnections as $currentConnection) {
				$currentIds[] = $currentConnection->getUserId();
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
							id="rle_userRole_<?php echo $resultRole->rle_id ?>[]" 
							name="rle_userRole_<?php echo $resultRole->rle_id ?>[]" 
							multiple 
							size=<?php echo sizeof($resultsUser) > 10 ? 10 : sizeof($resultsUser) ?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
						>
<?php
			while (list($id, $label) = each($resultsUser)) {
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
			reset($resultsUser);
			while (list($id, $label) = each($resultsUser)) {
?>
							<li class="parent_selection">
								<input 
									type="checkbox"
									class="inputbox checkbox"
									id="rle_userRole_<?php echo $resultRole->rle_id ?>[]" 
									name="rle_userRole_<?php echo $resultRole->rle_id ?>[]" 
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
						id="rle_userRole_<?php echo $resultRole->rle_id ?>" 
						name="rle_userRole_<?php echo $resultRole->rle_id ?>" 
						value="VIRGO_DONT_DELETE_N_M_CHILDREN"
					/>


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
	if (false) { //$componentParamsPermission->get('show_table_page') == "1" && ($masterComponentName != "page" || is_null($contextId))) {
?>
				<td align="center" nowrap>Page </td>
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
				$resultsPermission = $tmpPermission->selectAll(' prm_rle_id = ' . $resultRole->rle_id);
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
	$tabIndex = $index + sizeof($resultsRole) * 0;
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
							id="view_<?php echo $resultRole->rle_id ?>" 
							name="view_<?php echo $resultRole->rle_id ?>"
							value="<?php echo htmlentities($resultRole->rle_view, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_edit') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRole) * 1;
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
							id="edit_<?php echo $resultRole->rle_id ?>" 
							name="edit_<?php echo $resultRole->rle_id ?>"
							value="<?php echo htmlentities($resultRole->rle_edit, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_configure') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRole) * 2;
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
							id="configure_<?php echo $resultRole->rle_id ?>" 
							name="configure_<?php echo $resultRole->rle_id ?>"
							value="<?php echo htmlentities($resultRole->rle_configure, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_action') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRole) * 3;
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
							id="action_<?php echo $resultRole->rle_id ?>" 
							name="action_<?php echo $resultRole->rle_id ?>"
							value="<?php echo htmlentities($resultRole->rle_action, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_execute') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRole) * 4;
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
							id="execute_<?php echo $resultRole->rle_id ?>" 
							name="execute_<?php echo $resultRole->rle_id ?>"
							value="<?php echo htmlentities($resultRole->rle_execute, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_page') == "1" && ($masterComponentName != "page" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPermission) * 5;
?>
<?php
//		$limit_page = $componentParams->get('limit_to_page');
		$limit_page = null;
		$tmpId = portal\virgoRole::getParentInContext("portal\\virgoPage");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_page', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPermission->prm_pge__id = $tmpId;
//			}
			if (!is_null($resultPermission->getPgeId())) {
				$parentId = $resultPermission->getPgeId();
				$parentValue = portal\virgoPage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="prm_page_<?php echo $resultPermission->getId() ?>" name="prm_page_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PERMISSION_PAGE');
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
	$showAjaxprm = P('show_form_page', "1") == "3" || $parentCount > 100;
	if (!$showAjaxprm) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_page_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="prm_page_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
							name="prm_page_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
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
				echo (!is_null($resultPermission->getPgeId()) && $id == $resultPermission->getPgeId() ? "selected='selected'" : "");
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
				$parentId = $resultPermission->getPgeId();
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
	<input type="hidden" id="prm_page_<?php echo $resultPermission->getId() ?>" name="prm_page_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="prm_page_dropdown_<?php echo $resultPermission->getId() ?>" 
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
        $( "#prm_page_dropdown_<?php echo $resultPermission->getId() ?>" ).autocomplete({
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
					$('#prm_page_<?php echo $resultPermission->getId() ?>').val(ui.item.value);
				  	$('#prm_page_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				  	$('#prm_page_dropdown_<?php echo $resultPermission->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#prm_page_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#prm_page_<?php echo $resultPermission->getId() ?>').val('');
				$('#prm_page_dropdown_<?php echo $resultPermission->getId() ?>').removeClass("locked");		
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
$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').qtip({position: {
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
		$tmpId = portal\virgoRole::getParentInContext("portal\\virgoPortletObject");
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
$('#rle_portlet_object_dropdown_<?php echo $resultRole->getId() ?>').qtip({position: {
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
	$tabIndex = $index + sizeof($resultsRole) * 0;
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
							id="view_<?php echo $resultRole->rle_id ?>" 
							name="view_<?php echo $resultRole->rle_id ?>"
							value="<?php echo htmlentities($resultRole->rle_view, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_edit') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRole) * 1;
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
							id="edit_<?php echo $resultRole->rle_id ?>" 
							name="edit_<?php echo $resultRole->rle_id ?>"
							value="<?php echo htmlentities($resultRole->rle_edit, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_configure') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRole) * 2;
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
							id="configure_<?php echo $resultRole->rle_id ?>" 
							name="configure_<?php echo $resultRole->rle_id ?>"
							value="<?php echo htmlentities($resultRole->rle_configure, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_action') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRole) * 3;
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
							id="action_<?php echo $resultRole->rle_id ?>" 
							name="action_<?php echo $resultRole->rle_id ?>"
							value="<?php echo htmlentities($resultRole->rle_action, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_execute') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRole) * 4;
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
							id="execute_<?php echo $resultRole->rle_id ?>" 
							name="execute_<?php echo $resultRole->rle_id ?>"
							value="<?php echo htmlentities($resultRole->rle_execute, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_page') == "1" && ($masterComponentName != "page" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPermission) * 5;
?>
<?php
//		$limit_page = $componentParams->get('limit_to_page');
		$limit_page = null;
		$tmpId = portal\virgoRole::getParentInContext("portal\\virgoPage");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_page', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPermission->prm_pge__id = $tmpId;
//			}
			if (!is_null($resultPermission->getPgeId())) {
				$parentId = $resultPermission->getPgeId();
				$parentValue = portal\virgoPage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="prm_page_<?php echo $resultPermission->getId() ?>" name="prm_page_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PERMISSION_PAGE');
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
	$showAjaxprm = P('show_form_page', "1") == "3" || $parentCount > 100;
	if (!$showAjaxprm) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_page_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="prm_page_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
							name="prm_page_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
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
				echo (!is_null($resultPermission->getPgeId()) && $id == $resultPermission->getPgeId() ? "selected='selected'" : "");
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
				$parentId = $resultPermission->getPgeId();
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
	<input type="hidden" id="prm_page_<?php echo $resultPermission->getId() ?>" name="prm_page_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="prm_page_dropdown_<?php echo $resultPermission->getId() ?>" 
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
        $( "#prm_page_dropdown_<?php echo $resultPermission->getId() ?>" ).autocomplete({
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
					$('#prm_page_<?php echo $resultPermission->getId() ?>').val(ui.item.value);
				  	$('#prm_page_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				  	$('#prm_page_dropdown_<?php echo $resultPermission->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#prm_page_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#prm_page_<?php echo $resultPermission->getId() ?>').val('');
				$('#prm_page_dropdown_<?php echo $resultPermission->getId() ?>').removeClass("locked");		
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
$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').qtip({position: {
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
		$tmpId = portal\virgoRole::getParentInContext("portal\\virgoPortletObject");
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
$('#rle_portlet_object_dropdown_<?php echo $resultRole->getId() ?>').qtip({position: {
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
			</fieldset>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultRole->getDateCreated()) {
		if ($resultRole->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultRole->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultRole->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultRole->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultRole->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultRole->getDateModified()) {
		if ($resultRole->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultRole->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultRole->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultRole->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultRole->getDateModified() ?>"	>
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
						<input type="text" name="rle_id_<?php echo $this->getId() ?>" id="rle_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('APPLY') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>
<?php
			if ($this->canExecute("delete")) {
	if ($resultRole->rle_virgo_deleted) {
?> <div class="button_wrapper inlineBlock"><input type="submit" disabled class="button button_disabled btn btn-mini" value="<?php echo T('DELETE') ?>"><div class="button_right button_disabled"></div></div><?php
	} else {
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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("ROLE"), "\\'".rawurlencode($resultRole->getVirgoTitle())."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DELETE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
	}
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>
				</div>
<script type="text/javascript" language="JavaScript">
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['rle_name_<?php echo $resultRole->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.2 Create */
	} elseif ($roleDisplayMode == "CREATE") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_role") {
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
<?php echo T('ROLE') ?>:</legend>
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
		if (isset($resultRole->rle_id)) {
			$resultRole->rle_id = null;
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
	$resultRole->setPgeId($defaultValue);
}
	}
?>
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
					<label nowrap class="fieldlabel  obligatory " for="rle_name_<?php echo $resultRole->getId() ?>">
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
				$resultRole->setName($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultRole->getName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="name" name="rle_name_<?php echo $resultRole->getId() ?>" value="<?php echo htmlentities($resultRole->getName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultRole)) {
		$resultRole = new portal\virgoRole();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="rle_name_<?php echo $resultRole->getId() ?>" 
							name="rle_name_<?php echo $resultRole->getId() ?>"
							maxlength="255"
							size="30" 
							value="<?php echo htmlentities($resultRole->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ROLE_NAME');
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
$('#rle_name_<?php echo $resultRole->getId() ?>').qtip({position: {
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
	if (P('show_create_description', "1") == "1" || P('show_create_description', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_description_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rle_description_<?php echo $resultRole->getId() ?>">
 <?php echo P('show_create_description_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('DESCRIPTION') ?>
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
			if (P('event_column') == "description") {
				$resultRole->setDescription($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_description', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid; display: inline-block;" 
	class="inputbox readonly description" 
	id="description" 
><?php echo htmlentities($resultRole->rle_description, ENT_QUOTES, "UTF-8") ?></div>

<?php
	} else {
?>
<?php
	if (!isset($resultRole)) {
		$resultRole = new portal\virgoRole();
	}
?>
<textarea 
	class="inputbox description" 
	id="rle_description_<?php echo $resultRole->getId() ?>" 
	name="rle_description_<?php echo $resultRole->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ROLE_DESCRIPTION');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultRole->getDescription(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rle_description_<?php echo $resultRole->getId() ?>').qtip({position: {
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
	if (P('show_create_session_duration', "1") == "1" || P('show_create_session_duration', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_session_duration_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rle_sessionDuration_<?php echo $resultRole->getId() ?>">
 <?php echo P('show_create_session_duration_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('SESSION_DURATION') ?>
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
			if (P('event_column') == "session_duration") {
				$resultRole->setSessionDuration($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_session_duration', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultRole->getSessionDuration(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="sessionDuration" name="rle_sessionDuration_<?php echo $resultRole->getId() ?>" value="<?php echo htmlentities($resultRole->getSessionDuration(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultRole)) {
		$resultRole = new portal\virgoRole();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_session_duration_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="rle_sessionDuration_<?php echo $resultRole->getId() ?>" 
							name="rle_sessionDuration_<?php echo $resultRole->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultRole->getSessionDuration(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ROLE_SESSION_DURATION');
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
$('#rle_sessionDuration_<?php echo $resultRole->getId() ?>').qtip({position: {
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
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_create_page_obligatory') == "1" ? " obligatory " : "" ?> " for="rle_page_<?php echo isset($resultRole->rle_id) ? $resultRole->rle_id : '' ?>">
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
		$tmpId = portal\virgoRole::getParentInContext("portal\\virgoPage");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_page', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultRole->rle_pge__id = $tmpId;
//			}
			if (!is_null($resultRole->getPgeId())) {
				$parentId = $resultRole->getPgeId();
				$parentValue = portal\virgoPage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="rle_page_<?php echo $resultRole->getId() ?>" name="rle_page_<?php echo $resultRole->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_ROLE_PAGE');
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
	$showAjaxrle = P('show_create_page', "1") == "3" || $parentCount > 100;
	if (!$showAjaxrle) {
?>
    						<select 
							class="inputbox  <?php echo P('show_create_page_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="rle_page_<?php echo !is_null($resultRole->getId()) ? $resultRole->getId() : '' ?>" 
							name="rle_page_<?php echo !is_null($resultRole->getId()) ? $resultRole->getId() : '' ?>" 
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
				echo (!is_null($resultRole->getPgeId()) && $id == $resultRole->getPgeId() ? "selected='selected'" : "");
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
				$parentId = $resultRole->getPgeId();
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
	<input type="hidden" id="rle_page_<?php echo $resultRole->getId() ?>" name="rle_page_<?php echo $resultRole->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="rle_page_dropdown_<?php echo $resultRole->getId() ?>" 
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
        $( "#rle_page_dropdown_<?php echo $resultRole->getId() ?>" ).autocomplete({
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
					$('#rle_page_<?php echo $resultRole->getId() ?>').val(ui.item.value);
				  	$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').val(ui.item.label);
				  	$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#rle_page_<?php echo $resultRole->getId() ?>').val('');
				$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').removeClass("locked");		
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
$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').qtip({position: {
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
		$parentValue = $resultRole->rle_pge_id;
	}
	
?>
				<input type="hidden" id="rle_page_<?php echo $resultRole->rle_id ?>" name="rle_page_<?php echo $resultRole->rle_id ?>" value="<?php echo $parentValue ?>">
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
					<label nowrap class="fieldlabel userRole" for="rle_userRole_<?php echo $resultRole->getId() ?>[]">
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
			$parentUser = new portal\virgoUser();
			$whereList = "";
			$resultsUser = $parentUser->getVirgoList($whereList);
			$currentConnections = $resultRole->getUserRoles();
			$currentIds = array();
			foreach ($currentConnections as $currentConnection) {
				$currentIds[] = $currentConnection->getUserId();
			}
			$defaultParents = PN('create_default_values_users');
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
							id="rle_userRole_<?php echo $resultRole->rle_id ?>[]" 
							name="rle_userRole_<?php echo $resultRole->rle_id ?>[]" 
							multiple 
							size=<?php echo sizeof($resultsUser) > 10 ? 10 : sizeof($resultsUser) ?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
						>
<?php
			while (list($id, $label) = each($resultsUser)) {
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
			reset($resultsUser);
			while (list($id, $label) = each($resultsUser)) {
?>
							<li class="parent_selection">
								<input 
									type="checkbox"
									class="inputbox checkbox"
									id="rle_userRole_<?php echo $resultRole->rle_id ?>[]" 
									name="rle_userRole_<?php echo $resultRole->rle_id ?>[]" 
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
	$defaultParents = PN('create_default_values_users');
	foreach ($defaultParents as $defaultParent) {
?>
		<input type="hidden" name="rle_userRole_[]" value="<?php echo $defaultParent ?>"/>
<?php	
	}
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
	} elseif ($createForm == "virgo_entity") {
?>
<?php
		if (isset($resultRole->rle_id)) {
			$resultRole->rle_id = null;
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
	$resultRole->setPgeId($defaultValue);
}
	}
?>
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
					<label nowrap class="fieldlabel  obligatory " for="rle_name_<?php echo $resultRole->getId() ?>">
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
				$resultRole->setName($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultRole->getName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="name" name="rle_name_<?php echo $resultRole->getId() ?>" value="<?php echo htmlentities($resultRole->getName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultRole)) {
		$resultRole = new portal\virgoRole();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="rle_name_<?php echo $resultRole->getId() ?>" 
							name="rle_name_<?php echo $resultRole->getId() ?>"
							maxlength="255"
							size="30" 
							value="<?php echo htmlentities($resultRole->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ROLE_NAME');
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
$('#rle_name_<?php echo $resultRole->getId() ?>').qtip({position: {
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
	if (P('show_create_description', "1") == "1" || P('show_create_description', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_description_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rle_description_<?php echo $resultRole->getId() ?>">
 <?php echo P('show_create_description_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('DESCRIPTION') ?>
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
			if (P('event_column') == "description") {
				$resultRole->setDescription($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_description', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid; display: inline-block;" 
	class="inputbox readonly description" 
	id="description" 
><?php echo htmlentities($resultRole->rle_description, ENT_QUOTES, "UTF-8") ?></div>

<?php
	} else {
?>
<?php
	if (!isset($resultRole)) {
		$resultRole = new portal\virgoRole();
	}
?>
<textarea 
	class="inputbox description" 
	id="rle_description_<?php echo $resultRole->getId() ?>" 
	name="rle_description_<?php echo $resultRole->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ROLE_DESCRIPTION');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultRole->getDescription(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rle_description_<?php echo $resultRole->getId() ?>').qtip({position: {
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
	if (P('show_create_session_duration', "1") == "1" || P('show_create_session_duration', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_session_duration_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rle_sessionDuration_<?php echo $resultRole->getId() ?>">
 <?php echo P('show_create_session_duration_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('SESSION_DURATION') ?>
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
			if (P('event_column') == "session_duration") {
				$resultRole->setSessionDuration($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_session_duration', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultRole->getSessionDuration(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="sessionDuration" name="rle_sessionDuration_<?php echo $resultRole->getId() ?>" value="<?php echo htmlentities($resultRole->getSessionDuration(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultRole)) {
		$resultRole = new portal\virgoRole();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_session_duration_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="rle_sessionDuration_<?php echo $resultRole->getId() ?>" 
							name="rle_sessionDuration_<?php echo $resultRole->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultRole->getSessionDuration(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ROLE_SESSION_DURATION');
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
$('#rle_sessionDuration_<?php echo $resultRole->getId() ?>').qtip({position: {
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
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_create_page_obligatory') == "1" ? " obligatory " : "" ?> " for="rle_page_<?php echo isset($resultRole->rle_id) ? $resultRole->rle_id : '' ?>">
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
		$tmpId = portal\virgoRole::getParentInContext("portal\\virgoPage");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_page', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultRole->rle_pge__id = $tmpId;
//			}
			if (!is_null($resultRole->getPgeId())) {
				$parentId = $resultRole->getPgeId();
				$parentValue = portal\virgoPage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="rle_page_<?php echo $resultRole->getId() ?>" name="rle_page_<?php echo $resultRole->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_ROLE_PAGE');
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
	$showAjaxrle = P('show_create_page', "1") == "3" || $parentCount > 100;
	if (!$showAjaxrle) {
?>
    						<select 
							class="inputbox  <?php echo P('show_create_page_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="rle_page_<?php echo !is_null($resultRole->getId()) ? $resultRole->getId() : '' ?>" 
							name="rle_page_<?php echo !is_null($resultRole->getId()) ? $resultRole->getId() : '' ?>" 
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
				echo (!is_null($resultRole->getPgeId()) && $id == $resultRole->getPgeId() ? "selected='selected'" : "");
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
				$parentId = $resultRole->getPgeId();
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
	<input type="hidden" id="rle_page_<?php echo $resultRole->getId() ?>" name="rle_page_<?php echo $resultRole->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="rle_page_dropdown_<?php echo $resultRole->getId() ?>" 
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
        $( "#rle_page_dropdown_<?php echo $resultRole->getId() ?>" ).autocomplete({
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
					$('#rle_page_<?php echo $resultRole->getId() ?>').val(ui.item.value);
				  	$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').val(ui.item.label);
				  	$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#rle_page_<?php echo $resultRole->getId() ?>').val('');
				$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').removeClass("locked");		
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
$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').qtip({position: {
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
		$parentValue = $resultRole->rle_pge_id;
	}
	
?>
				<input type="hidden" id="rle_page_<?php echo $resultRole->rle_id ?>" name="rle_page_<?php echo $resultRole->rle_id ?>" value="<?php echo $parentValue ?>">
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
					<label nowrap class="fieldlabel userRole" for="rle_userRole_<?php echo $resultRole->getId() ?>[]">
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
			$parentUser = new portal\virgoUser();
			$whereList = "";
			$resultsUser = $parentUser->getVirgoList($whereList);
			$currentConnections = $resultRole->getUserRoles();
			$currentIds = array();
			foreach ($currentConnections as $currentConnection) {
				$currentIds[] = $currentConnection->getUserId();
			}
			$defaultParents = PN('create_default_values_users');
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
							id="rle_userRole_<?php echo $resultRole->rle_id ?>[]" 
							name="rle_userRole_<?php echo $resultRole->rle_id ?>[]" 
							multiple 
							size=<?php echo sizeof($resultsUser) > 10 ? 10 : sizeof($resultsUser) ?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
						>
<?php
			while (list($id, $label) = each($resultsUser)) {
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
			reset($resultsUser);
			while (list($id, $label) = each($resultsUser)) {
?>
							<li class="parent_selection">
								<input 
									type="checkbox"
									class="inputbox checkbox"
									id="rle_userRole_<?php echo $resultRole->rle_id ?>[]" 
									name="rle_userRole_<?php echo $resultRole->rle_id ?>[]" 
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
	$defaultParents = PN('create_default_values_users');
	foreach ($defaultParents as $defaultParent) {
?>
		<input type="hidden" name="rle_userRole_[]" value="<?php echo $defaultParent ?>"/>
<?php	
	}
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
	if ($resultRole->getDateCreated()) {
		if ($resultRole->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultRole->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultRole->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultRole->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultRole->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultRole->getDateModified()) {
		if ($resultRole->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultRole->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultRole->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultRole->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultRole->getDateModified() ?>"	>
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
						<input type="text" name="rle_id_<?php echo $this->getId() ?>" id="rle_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['rle_name_<?php echo $resultRole->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.3 Search */
	} elseif ($roleDisplayMode == "SEARCH") {
?>
	<div class="form_edit form_search">
			<fieldset class="form">
				<legend>
<?php echo T('ROLE') ?>:</legend>
				<ul>
<?php
	$criteriaRole = $resultRole->getCriteria();
?>
<?php
	if (P('show_search_name', "1") == "1") {

		if (isset($criteriaRole["name"])) {
			$fieldCriteriaName = $criteriaRole["name"];
			$dataTypeCriteria = $fieldCriteriaName["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('NAME') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_name" 
							name="virgo_search_name"
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
				id="virgo_search_name_is_null" 
				name="virgo_search_name_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaName) && $fieldCriteriaName["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaName) && $fieldCriteriaName["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaName) && $fieldCriteriaName["is_null"] == 2) {
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
	if (P('show_search_description', "1") == "1") {

		if (isset($criteriaRole["description"])) {
			$fieldCriteriaDescription = $criteriaRole["description"];
			$dataTypeCriteria = $fieldCriteriaDescription["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('DESCRIPTION') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_description" 
							name="virgo_search_description"
							style="border: yellow 1 solid;" 
							size="50" 
							value="<?php echo isset($dataTypeCriteria["default"]) ? htmlentities($dataTypeCriteria["default"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_description_is_null" 
				name="virgo_search_description_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaDescription) && $fieldCriteriaDescription["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaDescription) && $fieldCriteriaDescription["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaDescription) && $fieldCriteriaDescription["is_null"] == 2) {
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
	if (P('show_search_session_duration', "1") == "1") {

		if (isset($criteriaRole["session_duration"])) {
			$fieldCriteriaSessionDuration = $criteriaRole["session_duration"];
			$dataTypeCriteria = $fieldCriteriaSessionDuration["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('SESSION_DURATION') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_sessionDuration_from" 
							name="virgo_search_sessionDuration_from"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["from"]) ? htmlentities($dataTypeCriteria["from"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>
						&nbsp;-&nbsp;
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_sessionDuration_to" 
							name="virgo_search_sessionDuration_to"
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
				id="virgo_search_sessionDuration_is_null" 
				name="virgo_search_sessionDuration_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaSessionDuration) && $fieldCriteriaSessionDuration["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaSessionDuration) && $fieldCriteriaSessionDuration["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaSessionDuration) && $fieldCriteriaSessionDuration["is_null"] == 2) {
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
		if (isset($criteriaRole["page"])) {
			$fieldCriteriaPage = $criteriaRole["page"];
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
		if (isset($criteriaRole["user"])) {
			$parentIds = $criteriaRole["user"];
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
					>Users</label>
<?php
		$ids = virgoUser::selectAllAsIdsStatic();
		if (count($ids) < 50) {
			$idAndName = "virgo_search_user[]";
?>
					<select class="inputbox " multiple='multiple' id="<?php echo $idAndName ?>" name="<?php echo $idAndName ?>">
<?php
			foreach ($ids as $id) {
				$obj = new virgoUser($id['id']);
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
	if (P('show_search_permissions') == "1") {
?>
<?php
	$record = new portal\virgoRole();
	$recordId = is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->rle_id;
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
	unset($criteriaRole);
?>
				</ul>
			</fieldset>
				<div class="buttons form-actions">
						<input type="text" name="rle_id_<?php echo $this->getId() ?>" id="rle_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

 <div class="button_wrapper button_wrapper_search inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Search';
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
	} elseif ($roleDisplayMode == "VIEW") {
?>
	<div class="form_view">
<?php
	$editForm = P('view_form', "virgo_default");
	if (is_null($editForm) || trim($editForm) == "" || $editForm == "virgo_default") {
?>
			<fieldset class="form">
				<legend>
<?php echo T('ROLE') ?>:</legend>
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
	if (P('show_view_name', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="name"
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
<?php echo T('NAME') ?>
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
							<?php echo htmlentities($resultRole->getName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="name" name="rle_name_<?php echo $resultRole->getId() ?>" value="<?php echo htmlentities($resultRole->getName(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_description', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="description"
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
<?php echo T('DESCRIPTION') ?>
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
<div 
	style="border: yellow 1 solid; display: inline-block;" 
	class="inputbox readonly description" 
	id="description" 
><?php echo htmlentities($resultRole->rle_description, ENT_QUOTES, "UTF-8") ?></div>

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
	if (P('show_view_session_duration', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="session_duration"
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
<?php echo T('SESSION_DURATION') ?>
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
							<?php echo htmlentities($resultRole->getSessionDuration(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="sessionDuration" name="rle_sessionDuration_<?php echo $resultRole->getId() ?>" value="<?php echo htmlentities($resultRole->getSessionDuration(), ENT_QUOTES, "UTF-8") ?>"> 

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
			if ($resultRole->getId() == 0) {
// przesuac do createforgui				$resultRole->rle_pge__id = $tmpId;
			}
			$parentId = $resultRole->getPageId();
			$parentValue = portal\virgoPage::lookup($parentId);
				
?>
					<input
						type="hidden"
						id="rle_page_<?php echo isset($resultRole->rle_id) ? $resultRole->rle_id : '' ?>" 
						name="rle_page_<?php echo isset($resultRole->rle_id) ? $resultRole->rle_id : '' ?>" 						
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
	$record = new portal\virgoRole();
	$recordId = is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->rle_id;
	$record->load($recordId);
	$subrecordsUserRoles = $record->getUserRoles();
	$sizeUserRoles = count($subrecordsUserRoles);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="role"
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
			$parentUser = new portal\virgoUser($subrecord->getUsrId());
			echo htmlentities($parentUser->getVirgoTitle(), ENT_QUOTES, "UTF-8");
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
	if (class_exists('portal\virgoPermission') && P('show_view_permissions', '0') == "1") {
?>
<?php
	$record = new portal\virgoRole();
	$recordId = is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->rle_id;
	$record->load($recordId);
	$subrecordsPermissions = $record->getPermissions();
	$sizePermissions = count($subrecordsPermissions);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="role"
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
<?php echo T('ROLE') ?>:</legend>
				<ul>
				</ul>
			</fieldset>
<?php
	}
?>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultRole->getDateCreated()) {
		if ($resultRole->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultRole->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultRole->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultRole->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultRole->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultRole->getDateModified()) {
		if ($resultRole->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultRole->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultRole->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultRole->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultRole->getDateModified() ?>"	>
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
						<input type="text" name="rle_id_<?php echo $this->getId() ?>" id="rle_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

<?php
			if ($this->canExecute("form")) {
	if ($resultRole->rle_virgo_deleted) {
?> <div class="button_wrapper inlineBlock"><input type="submit" disabled class="button button_disabled btn btn-mini" value="<?php echo T('EDIT') ?>"><div class="button_right button_disabled"></div></div><?php
	} else {
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('EDIT') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
	}
?>
<?php
			}
?>
<?php
			if ($this->canExecute("delete")) {
	if ($resultRole->rle_virgo_deleted) {
?> <div class="button_wrapper inlineBlock"><input type="submit" disabled class="button button_disabled btn btn-mini" value="<?php echo T('DELETE') ?>"><div class="button_right button_disabled"></div></div><?php
	} else {
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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("ROLE"), "\\'".$resultRole->getVirgoTitle()."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DELETE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
	}
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
	} elseif ($roleDisplayMode == "TABLE") {
PROFILE('TABLE');
		if (P('form_only') == "3") {
?>
<?php
	$selectedMonth = $this->getPortletSessionValue('selected_month', date("m"));
	$selectedYear = $this->getPortletSessionValue('selected_year', date("Y"));

	$tmpDay = getdate(mktime(0, 0, 0, $selectedMonth, 1, $selectedYear));
	$firstDay = $tmpDay;
	$lastDay = getdate(strtotime($tmpDay["year"] . "-" .  (((int)$tmpDay["mon"])+1) . "-" . (((int)$tmpDay["mday"])-1)));
	$eventColumn = "rle_" . P('event_column');

	$resultCount = -1;
	$filterApplied = false;
	$resultRole->setShowPage(1); 
	$resultRole->setShowRows('all'); 	
	$resultsRole = $resultRole->getTableData($resultCount, $filterApplied);
	$events = array();
	foreach ($resultsRole as $resultRole) {
		if (isset($resultRole[$eventColumn]) && isset($events[substr($resultRole[$eventColumn], 0, 10)])) {
			$eventsInDay = $events[substr($resultRole[$eventColumn], 0, 10)];
		} else {
			$eventsInDay = array();
		}
		$eventObject = new virgoRole($resultRole['rle_id']);
		$eventsInDay[] = $eventObject;
		$events[substr($resultRole[$eventColumn], 0, 10)] = $eventsInDay;
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
				<input type='hidden' name='rle_id_<?php echo $this->getId() ?>' value=''/>
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');
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
			foreach ($eventsInDay as $resultRole) {
?>
<?php
PROFILE('token');
	if (isset($resultRole)) {
		$tmpId = is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId();
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($resultRole->getVirgoTitle()) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php				
//				echo "<span class='virgo_calendar_event' onclick='var form=document.getElementById(\"portlet_form_".$this->getId()."\");form.portlet_action.value=\"View\";form.rle_id_".$this->getId().".value=\"".$eventInDay->getId()."\";form.submit();'>" . $eventInDay->getVirgoTitle() . "</span>";
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
			var roleChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == roleChildrenDivOpen) {
					div.style.display = 'none';
					roleChildrenDivOpen = '';
				} else {
					if (roleChildrenDivOpen != '') {
						document.getElementById(roleChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					roleChildrenDivOpen = clickedDivId;
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
			
<?php
	if (P('master_mode', "0") != "1") {
?>
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
<?php
	}
?>
			
		</script>
<?php		
PROFILE('table_01');
PROFILE('table_02');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoRole'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoRole'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoRole'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoRole'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');
			$showPage = $resultRole->getShowPage(); 
			$showRows = $resultRole->getShowRows(); 
?>
						<input type="text" name="rle_id_<?php echo $this->getId() ?>" id="rle_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
				<tr><td colspan="99" class="nav-header"><?php echo T('Roles') ?></td></tr>
<?php
			}
?>			
<?php
PROFILE('table_02');
PROFILE('main select');
			$virgoOrderColumn = $resultRole->getOrderColumn();
			$virgoOrderMode = $resultRole->getOrderMode();
			$resultCount = -1;
			$filterApplied = false;
			$resultsRole = $resultRole->getTableData($resultCount, $filterApplied);
PROFILE('main select');
PROFILE('table_03');

			if (P('form_only') != "4") {
?>		
<?php
	if (P('master_mode', "0") != "1") {
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
	if (P('show_table_name', "1") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultRole->getOrderColumn(); 
	$om = $resultRole->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'rle_name');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('NAME') ?>							<?php echo ($oc == "rle_name" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoRole::getLocalSessionValue('VirgoFilterName', null);
?>
						<input
							name="virgo_filter_name"
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
	if (P('show_table_description', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultRole->getOrderColumn(); 
	$om = $resultRole->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'rle_description');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('DESCRIPTION') ?>							<?php echo ($oc == "rle_description" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoRole::getLocalSessionValue('VirgoFilterDescription', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_session_duration', "0") == "1") {
?>
				<th align="right" valign="middle" rowspan="2" style="text-align: right;">
<?php
	$oc = $resultRole->getOrderColumn(); 
	$om = $resultRole->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'rle_session_duration');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('SESSION_DURATION') ?>							<?php echo ($oc == "rle_session_duration" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoRole::getLocalSessionValue('VirgoFilterSessionDuration', null);
?>
						<input
							name="virgo_filter_session_duration"
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
if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php') && P('show_table_page', "1") != "0"  && !isset($parentsInContext['portal\\virgoPage'])  ) {
	if (P('show_table_page', "1") == "2") {
		$tmpLookupPage = virgoPage::getVirgoListStatic();
?>
<input name='rle_Page_id_<?php echo $this->getId() ?>' id='rle_Page_id_<?php echo $this->getId() ?>' type="hidden"/>
<?php		
	}
?>
				<th align="center" valign="middle" rowspan=" 2"><!-- bylo: nowrap -->
<?php
	$oc = $resultRole->getOrderColumn(); 
	$om = $resultRole->getOrderMode();
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
			$parentFilter = virgoRole::getLocalSessionValue('VirgoFilterPage', null);
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
			$parentFilter = virgoRole::getLocalSessionValue('VirgoFilterTitlePage', null);
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
<?php echo T('ROLE') ?>&nbsp;
<?php echo T('') ?>							<?php echo ($oc == "role" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
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
				<th rowspan="2"></th>
			</tr>
			<tr class="data_table_header">
																
			</tr>

<?php
	}
?>
<?php
			}
			if ($resultCount != 0) {
				if (((int)$showRows) * (((int)$showPage)-1) == $resultCount ) {
					$showPage = ((int)$showPage)-1;
					$resultRole->setShowPage($showPage);
				}
				$index = 0;
PROFILE('table_04');
PROFILE('rows rendering');
				$contextRowIdInTable = null;
				$firstRowId = null;
				foreach ($resultsRole as $resultRole) {
					$index = $index + 1;
?>
<?php
$fileNameToInclude = PORTAL_PATH . "/portlets/portal/virgoRole/modules/renderTableRow_{$_SESSION['current_portlet_object_id']}.php";
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
	$fileNameToInclude = PORTAL_PATH . "/portlets/portal/modules/renderTableRow.php";
} 
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
?>
<?php
			if (P('form_only') != "4" || (P('chessboard_width') != 0 && $index % P('chessboard_width') == 1)) {
				if (is_null($firstRowId)) {
					$firstRowId = $resultRole['rle_id'];
				}
				$displayClass = ' displayClass ';
				$tmpContextId = virgoRole::getContextId();
				if (is_null($tmpContextId)) {
					$forceContextOnFirstRow = P('force_context_on_first_row', "1");
					if ($forceContextOnFirstRow == "1") {
						virgoRole::setContextId($resultRole['rle_id'], false);
						$tmpContextId = $resultRole['rle_id'];
					}
				}
				if (isset($tmpContextId) && $resultRole['rle_id'] == $tmpContextId) {
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
				id="<?php echo $this->getId() ?>_<?php echo isset($resultRole['rle_id']) ? $resultRole['rle_id'] : "" ?>" 
				class="<?php echo (P('form_only') == "4" ? "data_table_chessboard" : ($index % 2 == 0 ? "data_table_even" : "data_table_odd")) ?> <?php echo $contextClass ?>
 <? echo $displayClass ?> 
role_<?php echo isset($resultRole['rle_id']) ? $resultRole['rle_id'] : "" ?>
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
	if (P('master_mode', "0") != "1") {
			echo  $resultRole['rle_id'];
	}
			if (P('master_mode', "0") != "1" && !$resultRole['rle_virgo_deleted']) {
?>
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultRole['rle_id'] ?>">
<?php
			}
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
			if (P('master_mode', "0") != "1" && !$resultRole['rle_virgo_deleted']) {
?>
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultRole['rle_id'] ?>">
<?php
			}
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
PROFILE('name');
	if (P('show_table_name', "1") == "1") {
PROFILE('render_data_table_name');
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
			<li class="name">
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
					form.rle_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRole['rle_id']) ? $resultRole['rle_id'] : '' ?>'; 
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
	style="<?php echo $resultRole['rle_virgo_deleted'] ? "text-decoration: line-through;" : "" ?>"
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultRole['rle_name'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_name');
	}
PROFILE('name');
?>
<?php
PROFILE('description');
	if (P('show_table_description', "0") == "1") {
PROFILE('render_data_table_description');
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
			<li class="description">
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
					form.rle_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRole['rle_id']) ? $resultRole['rle_id'] : '' ?>'; 
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
			$len = strlen($resultRole['rle_description']);
			$shortTextSize = P('short_text_size_description', 30);
		?>
		<span 
	style="<?php echo $resultRole['rle_virgo_deleted'] ? "text-decoration: line-through;" : "" ?>"
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultRole['rle_description'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultRole['rle_description'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultRole['rle_description'], ENT_QUOTES, "UTF-8");
					if ($shortTextSize == 0) {
						echo "</pre>";
					}
				}				 
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
PROFILE('render_data_table_description');
	}
PROFILE('description');
?>
<?php
PROFILE('session duration');
	if (P('show_table_session_duration', "0") == "1") {
PROFILE('render_data_table_session_duration');
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
			<li class="session_duration">
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
					form.rle_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRole['rle_id']) ? $resultRole['rle_id'] : '' ?>'; 
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
				$resultRole['rle_session_duration'] 
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
PROFILE('render_data_table_session_duration');
	}
PROFILE('session duration');
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
	style="<?php echo $resultRole['rle_virgo_deleted'] ? "text-decoration: line-through;" : "" ?>"
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
					form.rle_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRole['rle_id']) ? $resultRole['rle_id'] : '' ?>'; 
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
		if (isset($resultRole['page'])) {
			echo $resultRole['page'];
		}
	} else {
//		echo $resultRole['rle_pge_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetPage';
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo $resultRole['rle_id'] ?>');
	_pSF(form, 'rle_Page_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
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
			<option value="<?php echo $value ?>" <?php echo $value == $resultRole['rle_pge_id'] ? " selected " : "" ?>><?php echo $label ?></option>
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
	$record = new portal\virgoRole();
	$recordId = is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->rle_id;
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
			$parentUser = new portal\virgoUser($subrecord->getUsrId());
			echo htmlentities($parentUser->getVirgoTitle(), ENT_QUOTES, "UTF-8");
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
	if (class_exists('portal\virgoPermission') && P('show_table_permissions', '0') == "1") {
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
	if (isset($resultRole)) {
		$tmpId = is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId();
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
		if ($resultRole['rle_virgo_deleted']) {
?> <div class="button_wrapper inlineBlock"><input type="submit" disabled class="button button_disabled btn btn-mini" value="<?php echo T('EDIT') ?>"><div class="button_right button_disabled"></div></div><?php
		} else {
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('EDIT') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
		}
?>
<?php
			}
?>
<?php
			if ($this->canExecute("delete")) {
		if ($resultRole['rle_virgo_deleted']) {
?> <div class="button_wrapper inlineBlock"><input type="submit" disabled class="button button_disabled btn btn-mini" value="<?php echo T('DELETE') ?>"><div class="button_right button_disabled"></div></div><?php
		} else {
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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("ROLE"), "\\'".rawurlencode($resultRole['rle_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DELETE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
		}
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
	if (P('master_mode', "0") != "1") {
			echo  $resultRole['rle_id'];
	}
			if (P('master_mode', "0") != "1" && !$resultRole['rle_virgo_deleted']) {
?>
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultRole['rle_id'] ?>">
<?php
			}
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
			if (P('master_mode', "0") != "1" && !$resultRole['rle_virgo_deleted']) {
?>
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultRole['rle_id'] ?>">
<?php
			}
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
PROFILE('name');
	if (P('show_table_name', "1") == "1") {
PROFILE('render_data_table_name');
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
			<li class="name">
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
					form.rle_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRole['rle_id']) ? $resultRole['rle_id'] : '' ?>'; 
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
	style="<?php echo $resultRole['rle_virgo_deleted'] ? "text-decoration: line-through;" : "" ?>"
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultRole['rle_name'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_name');
	}
PROFILE('name');
?>
<?php
PROFILE('description');
	if (P('show_table_description', "0") == "1") {
PROFILE('render_data_table_description');
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
			<li class="description">
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
					form.rle_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRole['rle_id']) ? $resultRole['rle_id'] : '' ?>'; 
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
			$len = strlen($resultRole['rle_description']);
			$shortTextSize = P('short_text_size_description', 30);
		?>
		<span 
	style="<?php echo $resultRole['rle_virgo_deleted'] ? "text-decoration: line-through;" : "" ?>"
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultRole['rle_description'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultRole['rle_description'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultRole['rle_description'], ENT_QUOTES, "UTF-8");
					if ($shortTextSize == 0) {
						echo "</pre>";
					}
				}				 
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
PROFILE('render_data_table_description');
	}
PROFILE('description');
?>
<?php
PROFILE('session duration');
	if (P('show_table_session_duration', "0") == "1") {
PROFILE('render_data_table_session_duration');
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
			<li class="session_duration">
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
					form.rle_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRole['rle_id']) ? $resultRole['rle_id'] : '' ?>'; 
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
				$resultRole['rle_session_duration'] 
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
PROFILE('render_data_table_session_duration');
	}
PROFILE('session duration');
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
	style="<?php echo $resultRole['rle_virgo_deleted'] ? "text-decoration: line-through;" : "" ?>"
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
					form.rle_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRole['rle_id']) ? $resultRole['rle_id'] : '' ?>'; 
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
		if (isset($resultRole['page'])) {
			echo $resultRole['page'];
		}
	} else {
//		echo $resultRole['rle_pge_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetPage';
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo $resultRole['rle_id'] ?>');
	_pSF(form, 'rle_Page_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
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
			<option value="<?php echo $value ?>" <?php echo $value == $resultRole['rle_pge_id'] ? " selected " : "" ?>><?php echo $label ?></option>
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
	$record = new portal\virgoRole();
	$recordId = is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->rle_id;
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
			$parentUser = new portal\virgoUser($subrecord->getUsrId());
			echo htmlentities($parentUser->getVirgoTitle(), ENT_QUOTES, "UTF-8");
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
	if (class_exists('portal\virgoPermission') && P('show_table_permissions', '0') == "1") {
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
	if (isset($resultRole)) {
		$tmpId = is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId();
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
		if ($resultRole['rle_virgo_deleted']) {
?> <div class="button_wrapper inlineBlock"><input type="submit" disabled class="button button_disabled btn btn-mini" value="<?php echo T('EDIT') ?>"><div class="button_right button_disabled"></div></div><?php
		} else {
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('EDIT') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
		}
?>
<?php
			}
?>
<?php
			if ($this->canExecute("delete")) {
		if ($resultRole['rle_virgo_deleted']) {
?> <div class="button_wrapper inlineBlock"><input type="submit" disabled class="button button_disabled btn btn-mini" value="<?php echo T('DELETE') ?>"><div class="button_right button_disabled"></div></div><?php
		} else {
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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("ROLE"), "\\'".rawurlencode($resultRole['rle_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DELETE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
		}
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
			virgoRole::setContextId($firstRowId, false);
			if (P('form_only') != "4") {
?>
<script type="text/javascript">
		$('form#portlet_form_<?php echo $this->getId() ?> table.data_table tr#<?php echo $this->getId() ?>_<?php echo $firstRowId ?>').addClass("contextClass");
</script>
<?php
			}
		}
	}				
				unset($resultRole);
				unset($resultsRole);
				if (isset($contextIdOwn) && trim($contextIdOwn) != "") {
					if ($contextIdConfirmed == false) {
						$tmpRole = new virgoRole();
						$tmpCount = $tmpRole->getAllRecordCount(' rle_id = ' . $contextIdOwn);
						if ($tmpCount == 0) {
							virgoRole::clearRemoteContextId($tabModeEditMenu);
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
		$.getJSON('<?php echo $page->getUrl() ?>?portlet_action=SelectJson&rle_id_<?php echo $this->getId() ?>=' + virgoId + '&invoked_portlet_object_id=<?php echo $this->getId() ?>&virgo_action_mode_json=T&_virgo_ajax=1', function(data) {
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
		form.rle_id_<?php echo $this->getId() ?>.value=virgoId; 
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
		form.rle_id_<?php echo $this->getId() ?>.value=virgoId; 
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
	if (P('master_mode', "0") != "1") {
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'rle_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'rle_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Report';
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'rle_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'rle_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Export';
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'rle_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'rle_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Offline';
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');
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
					$sessionSeparator = virgoRole::getImportFieldSeparator();
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
						$sessionSeparator = virgoRole::getImportFieldSeparator();
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');
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
									if (!confirm(decodeURIComponent('<?php echo T('ARE_YOU_SURE_YOU_WANT_REMOVE', T('ROLES'), "") ?>'))) return false;
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');
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
	}
?>
<?php
PROFILE('table_08');
?>
<?php
		}
PROFILE('TABLE');
/* MILESTONE 1.6 TableForm */
	} elseif ($roleDisplayMode == "TABLE_FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_role") {
			  if (check.value == 'T') {
				  return "<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>";
			  }
		  }
        }
  }
</script>
		<script type="text/javascript">
			var roleChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == roleChildrenDivOpen) {
					div.style.display = 'none';
					roleChildrenDivOpen = '';
				} else {
					if (roleChildrenDivOpen != '') {
						document.getElementById(roleChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					roleChildrenDivOpen = clickedDivId;
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

	<form method="post" style="display: inline;" action="" id="virgo_form_role" name="virgo_form_role" enctype="multipart/form-data">
						<input type="text" name="rle_id_<?php echo $this->getId() ?>" id="rle_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

		<table class="data_table" cellpadding="0" cellspacing="0">
			<tr class="data_table_header">
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
	if (P('show_table_name', "1") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Name
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_description', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Description
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_session_duration', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Session duration
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
				$resultsRole = $resultRole->getRecordsToEdit();
				$idsToCorrect = $resultRole->getInvalidRecords();
				$index = 0;
PROFILE('rows rendering');
				foreach ($resultsRole as $resultRole) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultRole->rle_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
<?php
	if ($resultRole->rle_id == 0 && R('virgo_validate_new', "N") == "N") {
?>
		style="display: none;"
<?php
	}
?>
			>
<?php
PROFILE('name');
	if (P('show_table_name', "1") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRole) * 0;
?>
<?php
	if (!isset($resultRole)) {
		$resultRole = new portal\virgoRole();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="rle_name_<?php echo $resultRole->getId() ?>" 
							name="rle_name_<?php echo $resultRole->getId() ?>"
							maxlength="255"
							size="30" 
							value="<?php echo htmlentities($resultRole->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ROLE_NAME');
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
$('#rle_name_<?php echo $resultRole->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('name');
	} else {
?> 
						<input
							type="hidden"
							id="name_<?php echo $resultRole->rle_id ?>" 
							name="name_<?php echo $resultRole->rle_id ?>"
							value="<?php echo htmlentities($resultRole->rle_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('description');
	if (P('show_table_description', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRole) * 1;
?>
<?php
	if (!isset($resultRole)) {
		$resultRole = new portal\virgoRole();
	}
?>
<textarea 
	class="inputbox description" 
	id="rle_description_<?php echo $resultRole->getId() ?>" 
	name="rle_description_<?php echo $resultRole->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ROLE_DESCRIPTION');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultRole->getDescription(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rle_description_<?php echo $resultRole->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




</td>
<?php
PROFILE('description');
	} else {
?> 
						<input
							type="hidden"
							id="description_<?php echo $resultRole->rle_id ?>" 
							name="description_<?php echo $resultRole->rle_id ?>"
							value="<?php echo htmlentities($resultRole->rle_description, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('session duration');
	if (P('show_table_session_duration', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRole) * 2;
?>
<?php
	if (!isset($resultRole)) {
		$resultRole = new portal\virgoRole();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_session_duration_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="rle_sessionDuration_<?php echo $resultRole->getId() ?>" 
							name="rle_sessionDuration_<?php echo $resultRole->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultRole->getSessionDuration(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ROLE_SESSION_DURATION');
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
$('#rle_sessionDuration_<?php echo $resultRole->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('session duration');
	} else {
?> 
						<input
							type="hidden"
							id="sessionDuration_<?php echo $resultRole->rle_id ?>" 
							name="sessionDuration_<?php echo $resultRole->rle_id ?>"
							value="<?php echo htmlentities($resultRole->rle_session_duration, ENT_QUOTES, "UTF-8") ?>"
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
	$tabIndex = $index + sizeof($resultsRole) * 3;
?>
<?php
//		$limit_page = $componentParams->get('limit_to_page');
		$limit_page = null;
		$tmpId = portal\virgoRole::getParentInContext("portal\\virgoPage");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_page', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultRole->rle_pge__id = $tmpId;
//			}
			if (!is_null($resultRole->getPgeId())) {
				$parentId = $resultRole->getPgeId();
				$parentValue = portal\virgoPage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="rle_page_<?php echo $resultRole->getId() ?>" name="rle_page_<?php echo $resultRole->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_ROLE_PAGE');
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
	$showAjaxrle = P('show_form_page', "1") == "3" || $parentCount > 100;
	if (!$showAjaxrle) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_page_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="rle_page_<?php echo !is_null($resultRole->getId()) ? $resultRole->getId() : '' ?>" 
							name="rle_page_<?php echo !is_null($resultRole->getId()) ? $resultRole->getId() : '' ?>" 
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
				echo (!is_null($resultRole->getPgeId()) && $id == $resultRole->getPgeId() ? "selected='selected'" : "");
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
				$parentId = $resultRole->getPgeId();
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
	<input type="hidden" id="rle_page_<?php echo $resultRole->getId() ?>" name="rle_page_<?php echo $resultRole->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="rle_page_dropdown_<?php echo $resultRole->getId() ?>" 
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
        $( "#rle_page_dropdown_<?php echo $resultRole->getId() ?>" ).autocomplete({
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
					$('#rle_page_<?php echo $resultRole->getId() ?>').val(ui.item.value);
				  	$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').val(ui.item.label);
				  	$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#rle_page_<?php echo $resultRole->getId() ?>').val('');
				$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').removeClass("locked");		
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
$('#rle_page_dropdown_<?php echo $resultRole->getId() ?>').qtip({position: {
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
		$parentValue = $resultRole->rle_pge_id;
	}
	
?>
				<input type="hidden" id="rle_page_<?php echo $resultRole->rle_id ?>" name="rle_page_<?php echo $resultRole->rle_id ?>" value="<?php echo $parentValue ?>">
<?php
	} 
?>
				<td>
<?php
	if (isset($idsToCorrect[$resultRole->rle_id])) {
		$errorMessage = $idsToCorrect[$resultRole->rle_id];
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
		<div class="<?php echo $roleDisplayMode ?>">
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
	_pSF(form, 'rle_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRole) ? (is_array($resultRole) ? $resultRole['rle_id'] : $resultRole->getId()) : '' ?>');

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
<div style="display: none; background-color:#FFFFFF; border:1px solid #000000; font-size:10px; margin:10px 0; padding:10px;"; id="extraFilesInfo_prt_role" style="font-size: 12px; " onclick="document.getElementById('extraFilesInfo_prt_role').style.display='none';">
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
	$infos = virgoRole::getExtraFilesInfo();
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

