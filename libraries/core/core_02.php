<?php
	// 3.0.0.0

//
//									Under construction
//
//use portal\virgoLanguage as virgoLanguage;
use portal\virgoPage;
use portal\virgoPortal;
use portal\virgoUser;
use portal\virgoPortletObject;

function underConstruction() {
	$underConstructionWarning = "";
	if (isset($virgoConfig['under_construction']) && trim($virgoConfig['under_construction'] != "")) {
		if ($_SERVER['REMOTE_ADDR'] != $virgoConfig['service_ip']) {
			echo "<style type='text/css'>div.centered{color: highlight;font-family: Verdana;margin: 200px;text-align: center;}</style><div class='centered'>{$virgoConfig['under_construction']}<div style='color: grey; font-size: 9px;'>W razie pytań prosimy o kontakt: contact@metadetron.com</div></div>";
			exit();
		}
		$underConstructionWarning = "<div style='padding: 10px; text-align: center; text-decoration:blink; background-color: yellow; border: 2px solid red; font-size: 20px; font-weight: bold; color: red;'>TRYB SERWISOWY, PORTAL OFFLINE!!!</div>";
	}
	return $underConstructionWarning;
}

//
//									Error page
//
function errorPage($message) {
	$server = htmlentities($_SERVER['SERVER_NAME']);
	$version = PORTAL_VERSION . " (" . FUNCTIONS_VERSION . ")";
	$currentUrl = $server . $_SERVER["REQUEST_URI"];
	echo <<<HTML
<style type='text/css'>
body {
	background-color: khaki;
}
div.centered {
	color: red;
	font-family: Verdana;
	margin: 200px;
	text-align: center;
	background-color: aliceblue;
	border-radius: 10px 10px 10px 10px;
	box-shadow: 2px 2px 3px gray;
	padding: 20px;
	font-size: 30px;
}
table {
	font-size: 12px;
	color: #444444;
	margin-top: 20px;
}
table tr td {
	padding: 10px;
}
div.footer {
	color: grey; 
	font-size: 9px;
	border-top: 1px solid #CCCCCC;
	padding-top: 10px;
	margin-top: 10px;
}
table tr td.border {
	border-left: 1px dotted #CCCCCC;
}
table tr.tabela {
	height: 60px;
}
table span.url {
	font-family: "Courier New", Courier, monospace;
}
</style>
<div class='centered'>
	{$message}
	<table colspanning="0" colspacing="0">
		<tr>
			<td valign="top" colspan="2">
Wystąpił nieoczekiwany problem  przy próbie otwarcia strony <span class="url">{$currentUrl}</span>. Prawdopodobną przyczyną jego wystąpienia jest błędny adres wpisany do przeglądarki lub błąd wewnątrz którejś z funkcji aplikacji internetowej.
			</td>
		</tr>
		<tr>
			<td valign="top" colspan="2">
Przepraszamy za wszelkie niedogodności, które wyniknęły z powodu wystąpienia tego błędu.
			</td>
		</tr>
		<tr class="tabela">
			<td valign="middle" width="50%">
Zawsze mogą Państwo powrócić na <a href="/">stronę główną</a> aplikacji.
			</td>
			<td valign="middle" width="50%" class="border">
W razie problemów prosimy o kontakt na adres <a href="mailto:admin@metadetron.com?Subject=Błąd w aplikacji {$server}&body=Zgłaszam problem na stronie {$currentUrl}">admin@metadetron.com</a>.
			</td>
		</tr>
	</table>
	<div class="footer">Aplikacja powstała przy użyciu technologii virgo firmy METADETRON. Więcej informacji na temat tej technologii oraz samej firmy można otrzymać pod adresem <a href="http://www.metadetron.com/">www.metadetron.com</a>. Wersja portalu: {$version}</div>
</div>
HTML;
	exit();
}

//
//									ModRewrite debug
//
function modRewriteDebug() {
	if (R('htaccess_debug') == 'true') {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {
			$pageURL .= "s";
		}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		echo $pageURL . '&' . $_SERVER['QUERY_STRING'];
		exit;
	}
}

//
//									konfiguracja portletu
//
function showConfig() {
	$showConfig = R('virgo_show_config', '');
	if ($showConfig != '') {
		require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'meta'.DIRECTORY_SEPARATOR.'_'.$showConfig.DIRECTORY_SEPARATOR.'params.php');
		exit();
	}
}

//
//									security
//
function security() {
	if (isset($_REQUEST['_SESSION'])) die("Get lost Muppet! (thanks Dave)");
}

//
//									ustawienia php
//
function phpSettings() {	
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	ini_set('session.gc_maxlifetime', 36000);	
	ini_set('session.gc_probability',100);
}

//
//									locale
//
function localeSettings() {	
	$locale = \portal\virgoLanguage::getCurrentLanguageCode();
	if (isset($locale) && trim($locale) != "") {
		// locale ma byc jednak skonfigurowane jako pl_PL (podkreslenie!)
		setlocale(LC_ALL, $locale . ".utf8");
	}
}

//
//									komunikaty o bledach
//	
function errorMessages() {
	if (isset($_POST['show_system_message']) && trim($_POST['show_system_message']) != "") {
		$messages = "";
		$suffix = "";
		if ($_POST['show_system_message'] != "true") {
			$suffix = "_" . $_POST['show_system_message'];
		}
		if (isset($_SESSION['virgo_msg_queue' . $suffix])) {
			$messages = "<ul class='system_messages'>";
			$queue = $_SESSION['virgo_msg_queue' . $suffix];
			foreach ($queue as $message) {
				$messages = $messages . "<li class='system_message {$message[0]}'>";
				$messages = $messages . $message[1];
				$messages = $messages . "</li>";
			}
			$messages = $messages . "</ul>";
			unset($_SESSION['virgo_msg_queue' . $suffix]);			
			echo $messages;
		}
		exit();
	}	
}

//
//									session expiration
//	
function sessionExpiration() {
	if (isset($_GET['session_expired']) && $_GET['session_expired'] == "true") {
		virgoUser::logout(true);
	}
}

//
//									wywolanie crona
//	
function cron() {
	if (isset($_GET['virgo_cron_tick']) && trim($_GET['virgo_cron_tick']) == "true") {
		virgoPortal::setParameterValue('LAST_CRON_CALL', date("Y-m-d H:i:s"));
		$ip = $_SERVER['REMOTE_ADDR'];
		$allowedIp = PP('ALLOWED_CRON_CALLER_IP');
		if (is_null($allowedIp)) {
			echo "Parameter ALLOWED_CRON_CALLER_IP not set in portal.";
			L('Parameter ALLOWED_CRON_CALLER_IP not set in portal.', 'Client IP: ' . $ip, 'ERROR');
		} else {
			if ($allowedIp != $ip) {
				echo "$ip is not allowed to call cron.";
				L("$ip is not allowed to call cron.", 'Client IP: ' . $ip, 'ERROR');
			} else {
//				L('Cron ticked.', 'Client IP: ' . $ip, 'INFO');
				require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoProcess'.DIRECTORY_SEPARATOR.'controller.php');
				virgoProcess::tick();
			}
		}
		exit();
	}
}

//
//									virgospecific, ugly
//	
function labelMatching() {
/* To jednak do komponentu przeniesc, jako akcje zwykla 	
	Ale chyba sie nie da, bo index tylko renderuje te akcje, ktore sa POSTem wyslane*/	
	$matchingLabelsEntity = R('virgo_matching_labels_entity');
	if (!is_null($matchingLabelsEntity) && trim($matchingLabelsEntity) != "") {
		$match = R('virgo_match');
//			JRequest::checkToken('get') or die( 'Invalid Token' );
		$matchClassName = "virgo" . $matchingLabelsEntity;
		require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.R('virgo_matching_labels_namespace').DIRECTORY_SEPARATOR.$matchClassName.DIRECTORY_SEPARATOR.'controller.php');
		$parentLabels = new $matchClassName();
//		var_dump($parentLabels);
		$resultsLabels = $parentLabels->printVirgoListMatched($match, R('virgo_field_name'));
		exit();
	}
}

//
//									jaka strona
//	
function selectPage() {
	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php');
	$page = virgoPage::getCurrentPage();
	if (!isset($page)) {
 		errorPage("Page not found");
	}
	$cached = C('_virgo_portal_path', $portalPath, false);
	if ($cached) {
		$portalPath = $cached;
	} else {
		$portal = $page->getPortal();
		$portalPath = $portal->getPath();
		if ($portalPath != "") {
			$portalPath = "/" . $portalPath;
		}
		$_SESSION['portal_url'] = $portalPath; //$portal->getUrl();
		$portalPath = CS('_virgo_portal_path', $portalPath, false);
	}
	return $page;
}

function executePortletAction($pob, $portletAction, $databaseHandler) {		
		global $portletActionReturnValue;
		$_SESSION['current_portlet_object_id'] = $pob->getId();
		if (isset($portletAction) && trim($portletAction) != "") {
			$pdf = $pob->getPortletDefinition();
			$className = $pdf->getNamespace().'\\'.$pdf->getAlias();
//			if (!class_exists($className)) { NOW WITH AUTOLOADER!
//		PROFILE('preparing '.$pob->getPortletDefinition()->getAlias()."portletAction" . ucwords($portletAction).'-02-require');
//				require(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.$pdf->getNamespace().DIRECTORY_SEPARATOR.$pdf->getAlias().DIRECTORY_SEPARATOR.'controller.php');
//		PROFILE('preparing '.$pob->getPortletDefinition()->getAlias()."portletAction" . ucwords($portletAction).'-02-require');
//			}
			$class = new $className();
			$portletAction = "portletAction" . ucwords($portletAction);			
			if (method_exists($class, $portletAction)) {
				$profiler = 'executing ' . $pob->getPortletDefinition()->getAlias() . "." . $portletAction . "()";
				PROFILE($profiler);
				$databaseHandler->begin();
				$portletActionReturnValue = $class->$portletAction();
				if ($portletActionReturnValue === -1) {
					$databaseHandler->rollback();
				} else {
					$databaseHandler->commit();
				}
				PROFILE($profiler);
				L("Action {$className}->{$portletAction}() called.", '', 'TRACE');
			} else {
				L("Method {$className}->{$portletAction}() not found!", '', 'ERROR');
			}
		}
		unset($_SESSION['current_portlet_object_id']);
		PROFILE('preparing '.$pob->getPortletDefinition()->getAlias().$portletAction);
		if (isset($_REQUEST['virgo_redirect_after_action'])) {
			$url = $_REQUEST['virgo_redirect_after_action'];
			virgoPage::redirectUrl($url);					
		}
		return $portletActionReturnValue;
}

//
//									wywolanie akcji
//	to jest taka jak np. virgo_download, czyli link do wywolania tylko akcji i contentu portletu i EXIT!
function portletActionCallAjax($databaseHandler) {
	global $portletActionReturnValue;
	if (R('_virgo_ajax') == "1") {
		if (R('invoked_portlet_object_id') != "") {
			$time_start = microtime(true);
			$pobId = R('invoked_portlet_object_id');
			$pob = new virgoPortletObject($pobId);
			$pdf = $pob->getPortletDefinition();
			$portletAction = R('portlet_action');
			$portletActionReturnValue = executePortletAction($pob, $portletAction, $databaseHandler);
			if (R('virgo_action_mode_api') == 'T') {
// portlets must echo their results in their code, not here as with json...						
				exit();
			}		
			if (R('virgo_action_mode_json') == 'T') {
				echo json_encode($portletActionReturnValue);
				exit();
			}
			echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">'; 
			echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
		/* UWAGA! W tej chwili jest tak, ze zmiany w bazie dokonane w getContent i tak sie nie 
		  zakomituja! Tylko w akcji mozna zmieniac, getContent tylko do wyswietlania */
			$_SESSION['current_portlet_object_id'] = $pob->getId();
			echo $pob->getContent();
			unset($_SESSION['current_portlet_object_id']);
			profiler($time_start);
			exit();
		}
	}
}

//
//									render image
//
function renderImage($tableName, $tablePrefix, $propertyName, $id) {
	$thumbnailWidth = isset($_GET['virgo_media_width']) ? $_GET['virgo_media_width'] : null;
	$thumbnailHeight = isset($_GET['virgo_media_height']) ? $_GET['virgo_media_height'] : null;
	$shrinkOnly = (isset($_GET['virgo_image_shrink_only']) && $_GET['virgo_image_shrink_only'] == "true");
	header('Location: ' . $_SESSION['portal_url'] . "/" . getCachedImagePath($tableName, $tablePrefix, $propertyName, $id, $thumbnailWidth, $thumbnailHeight, $shrinkOnly));
}
//
//									render pdf
//
function renderPdf($tableName, $tablePrefix, $propertyName, $id) {
	$query = " SELECT {$tablePrefix}_{$propertyName} AS html FROM {$tableName} WHERE {$tablePrefix}_id = {$id} ";
	$rows = QR($query);
	if ($rows && count($rows) > 0) {
		$row = $rows[0];
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
		$pdf->writeHTML($row['html'], true, false, true, false, '');
		$pdf->Output("{$tableName}_{$propertyName}_{$id}.pdf", 'I');
		ini_set('display_errors', '1');
	}
}

//
//									render binary
//
function renderBinary($tableName, $tablePrefix, $propertyName, $id) {
	$query = " SELECT {$tablePrefix}_{$propertyName}_virgo_blob, {$tablePrefix}_{$propertyName}_virgo_file_name FROM {$tableName} WHERE {$tablePrefix}_id = {$id} ";
	$rows = QR($query);
	if ($rows && count($rows) > 0) {
		$row = $rows[0];
		$content = $row["{$tablePrefix}_{$propertyName}_virgo_blob"];
		$fileName = $row["{$tablePrefix}_{$propertyName}_virgo_file_name"];
		header('Content-Length: '.strlen($content));
		header('Content-Type: application/download');
		header('Content-transfer-encodig: binary');
		header('Content-disposition: attachment; filename="' . $fileName . '"');
		echo $content;
	}
}

//
//									renderowanie mediow
//	
function renderMedia() {
	if (isset($_GET['virgo_media']) && $_GET['virgo_media'] == "true") {
		if (isset($_GET['opacity']) && isset($_GET['base_color'])) {
			renderTransparentPNG($_GET['opacity'], $_GET['base_color']);
		}
		$id = $_GET['virgo_media_row_id'];
		if (A($id)) {
			$tableName = $_GET['virgo_media_table_name'];
			$tablePrefix = $_GET['virgo_media_table_prefix'];
			$propertyName = $_GET['virgo_media_property_name'];
			if (!isset($_GET['virgo_media_type'])) {
				renderImage($tableName, $tablePrefix, $propertyName, $id);
			} else {
				$type = $_GET['virgo_media_type'];
				$tablePrefix = QE($tablePrefix);
				$tableName = QE($tableName);
				$propertyName = QE($propertyName);
				$id = QE($id);
				if ($type == "html2pdf") {
					renderPdf($tableName, $tablePrefix, $propertyName, $id);
				} else {
					renderBinary($tableName, $tablePrefix, $propertyName, $id);
				}
			}
		}
		exit();
	}
}
//
//									upload
//	
function upload() {
	if (isset($_GET['virgo_upload']) && $_GET['virgo_upload'] == "true") {
		$fileName = time()."_".$_FILES['upload']['name'];
		$filePath =  PORTAL_PATH.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'virgo_uploads'.DIRECTORY_SEPARATOR.$fileName;
		$fileUrl =  (((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://").$_SERVER['SERVER_NAME']."/media/virgo_uploads/".rawurlencode($fileName);
		if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name'])) ) {
			$message = "No file uploaded.";
		} else if ($_FILES['upload']["size"] == 0) {
			$message = "The file is of zero length.";
		} else if (($_FILES['upload']["type"] != "image/pjpeg") AND ($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/png")) {
			$message = "The image must be in either JPG or PNG format. Please upload a JPG or PNG instead.";
		} else if (!is_uploaded_file($_FILES['upload']["tmp_name"])) {
			$message = "You may be attempting to hack our server. We're on to you; expect a knock on the door sometime soon.";
		} else {
			$message = "";
			$move = @ move_uploaded_file($_FILES['upload']['tmp_name'], $filePath);
			if(!$move) {
				$message = "Error moving uploaded file. Check the script is granted Read/Write/Modify permissions.";
			}
		}
    		$funcNum = $_GET['CKEditorFuncNum'] ;
		echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$fileUrl', '$message');</script>";
		exit;
	}
}

//
//	to jest normalny tryb index.php wywolanie akcji a potem dalej renderowanie strony
function portletActionCall($page, $databaseHandler) {
	$portletAction = R('portlet_action');
	$invokedPortletObjectId = R('invoked_portlet_object_id'); // bylo legacy_invoked_portlet_object_id
	$portletLocations = $page->getPortlets($page->canEdit());
	$pobFound = false;
	foreach ($portletLocations as $portletLocation) {
		$portletObject = $portletLocation->getPortletObject();
		if ($invokedPortletObjectId == $portletObject->getId()) {
			$realPortletAction = ucwords($portletAction);
		} else {
			$realPortletAction = "VirgoDefault";
		}
		executePortletAction($portletObject, $realPortletAction, $databaseHandler);
	}
}

//
//									parametry templatu do sesji
//
function setTemplateSessionParams($template) {
	// wersja, ze kolor template'u wazniejszy niz kolor w sesji
	if (isset($_SESSION['virgo_template_id'])) {
		if ($_SESSION['virgo_template_id'] != $template->getId()) {
			$_SESSION['virgo_main_hue'] = null;
			$_SESSION['virgo_lightness'] = null;
			$_SESSION['virgo_contrast'] = null;
			$_SESSION['virgo_saturation'] = null;
			$_SESSION['virgo_template_id'] = $template->getId();
		}
	} else {
		$_SESSION['virgo_main_hue'] = null;
		$_SESSION['virgo_lightness'] = null;
		$_SESSION['virgo_contrast'] = null;
		$_SESSION['virgo_saturation'] = null;
		$_SESSION['virgo_template_id'] = $template->getId();
	}
}

//
//									add page edit controls
//
function addPageEditControls($portal, $template, &$preout) {
					$preout = $preout . <<<EDITHTML
<div style="display: inline-block;" 
	onclick="
window.open(
	'{$_SESSION['portal_url']}/index.php?virgo_show_config=page&prtId={$portal->getId()}',
	'portlets',
	'width=1280,height=700,resizable=no,scrollbars=yes,toolbar=no,location=no,directories=no,status=no,menubar=no,copyhistory=no')
	"
>Edit</div><div style="display: inline-block;" 
	onclick="
window.open(
	'{$_SESSION['portal_url']}/index.php?virgo_show_config=template&tmpId={$template->getId()}&mode=code',
	'portlets',
	'width=1280,height=700,resizable=no,scrollbars=yes,toolbar=no,location=no,directories=no,status=no,menubar=no,copyhistory=no')
	"
>Tmpl</div><div style="display: inline-block;" 
	onclick="
window.open(
	'{$_SESSION['portal_url']}/index.php?virgo_show_config=template&tmpId={$template->getId()}&mode=css',
	'portlets',
	'width=1280,height=700,resizable=no,scrollbars=yes,toolbar=no,location=no,directories=no,status=no,menubar=no,copyhistory=no')
	"
>Css</div>
EDITHTML;
}

//
//									include edit style
//
function includeEditStyle() {
	return <<<EDITSTYLE
ul.edit_section {
	list-style: none;
	border: 1px solid #DDDDDD;
	margin: 0px;
	padding: 0px;
}
ul.edit_section:hover {
	box-shadow: 0px 0px 5px red;
}
ul.edit_section li.section_data, ul.portlet_frame li.portlet_name {
	margin: 0px;
	padding: 0px;
}
ul.edit_section li.section_data {
	background-color: #FFFFFF;
	color: #000000;
	font-family: Verdana;
}
ul.edit_section li.section_data span.section_name {
	font-weight: bold;
}
EDITSTYLE;
}

//
//									get portal identifier
//
function getPortalIdentifier($portal) {
	$portalIdentifier = $portal->getIdentifier();
	if (isset($portalIdentifier) && trim($portalIdentifier) != "") {
		$portalIdentifier = "/" . $portalIdentifier;
	} else {
		$portalIdentifier = "";
	}
	return $portalIdentifier;
}

//
//									get logout div
//
function getLogoutDiv($user, $portal) {
	$sessionDuration = virgoUser::getSessionDuration();
	$sessionExpiresText = T('SESSION_EXPIRES_IN');
	$logoutDiv = <<<JAVASCRIPT
<script type="text/javascript">
$(document).ready(function () {
		$('#logout').autoLogout({
			LogoutTime : {$sessionDuration}, 
			logout : function(element){ 
				window.location = '{$portal->getPortalUrl()}/?session_expired=true';
			},
			countingDownLook 	: "{$sessionExpiresText} {h}.",
			ShowLogoutCountdown	: 0, 
			countingDownLookShow	: "{$sessionExpiresText} {h}."
		});
});		
</script>					
JAVASCRIPT;
	$logoutDiv = ($user->getUnidentified() == 1 || PP('AUTO_LOGOUT', '1') == "0" ? '' : $logoutDiv);
	return $logoutDiv;	
}

//
//									get google fonts code
//
function getGoogleFontsCode($template) {
	$googleFonts = $template->getParameterValue('virgo_include_google_font', '0');
	if ($googleFonts == "1") {
		$fontFamily = $template->getParameterValue('virgo_font_family');
		$googleFontsCode = "<link href='http://fonts.googleapis.com/css?family=".urlencode($fontFamily)."&subset=latin,latin-ext' rel='stylesheet' type='text/css'>";
	} else {
		$googleFontsCode = "";				
	}
	return $googleFontsCode;	
}

//
//									kod strony
//	
function getHTMLTemplate($page, $template, $user, $preout, $underConstructionWarning) {
	$canEditPage = $page->canEdit();	
	if ($canEditPage) {
		if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'meta'.DIRECTORY_SEPARATOR.'_page'.DIRECTORY_SEPARATOR.'params.php')) {
			addPageEditControls($page->getPortal(), $template, $preout);
		}
		$editStyle = includeEditStyle();
	} else {
		$editStyle = '';
	} 
	$logoutDiv = getLogoutDiv($user, $page->getPortal());
	$googleFontsCode = getGoogleFontsCode($template);
	$description = PP('PORTAL_DESCRIPTION');
	$keywords = PP('PORTAL_KEYWORDS');
	$logoutDivForm = (PP('AUTO_LOGOUT', '1') == "0" ? '' : "$('#logout').autoLogout('resetTimer');");
	$out = <<<HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<!--[if lt IE 7 ]><html class="ie ie6"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html> <!--<![endif]-->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="description" content="{$description}">
		<meta name="keywords" content="{$keywords}">		
		<title>{$page->getPortal()->getName()} - {$page->getTitle()}</title>
		<script src="{$_SESSION['portal_url']}/libraries/jQuery/jquery.js" type="text/javascript"></script> 
		<script src="{$_SESSION['portal_url']}/libraries/jQueryUI/js/jquery-ui-1.8.21.custom.min.js" type="text/javascript"></script> 
    	<script src="{$_SESSION['portal_url']}/libraries/jQuery.form/jquery.form.js" type="text/javascript"></script> 
		<script src="{$_SESSION['portal_url']}/libraries/jQuery.loadmask/jquery.loadmask.min.js" type="text/javascript"></script>
		<script src="{$_SESSION['portal_url']}/libraries/jQuery.autologout/autologout.js" type="text/javascript"></script>
		<link href="{$_SESSION['portal_url']}/libraries/jQuery.loadmask/jquery.loadmask.css" rel="stylesheet" type="text/css">
		<link href="{$_SESSION['portal_url']}/libraries/jQueryUI/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
		<script src="{$_SESSION['portal_url']}/libraries/jQuery.qTip/jquery.qtip.min.js" type="text/javascript"></script>
		<link href="{$_SESSION['portal_url']}/libraries/jQuery.qTip/jquery.qtip.min.css" rel="stylesheet" type="text/css">
		<link href="{$_SESSION['portal_url']}/css/portal.css" rel="stylesheet" type="text/css">
		<link href="{$_SESSION['portal_url']}/cache/css/{$template->getCachedFileName()}.css" rel="stylesheet" type="text/css">
		<style type="text/css">
{$editStyle}
		</style>
	<script type="text/javascript">
		function getPortletForm(portletId) {
			return document.getElementById('portlet_form_' + portletId);
		}
		function submitPortletAction(action, portletId) {
			var f = getPortletForm(portletId);
			f.portlet_action.value = action;
			f.submit();
		}
		function getXMLHttpRequest() {
			var ua = navigator.userAgent.toLowerCase();
			if (!window.ActiveXObject) {
				return new XMLHttpRequest();
			} else if (ua.indexOf('msie 5') == -1) {
				return new ActiveXObject("Msxml2.XMLHTTP");
			} else {
				return new ActiveXObject("Microsoft.XMLHTTP");
			}
		}				
		var xmlhttpArray = new Array();
		function getAjaxToTarget(url, targetId) {
			elem = document.getElementById(targetId);
			elem.innerHTML = "<div style='z-index: 20; height: " + elem.offsetHeight +  "px; width: " + elem.offsetWidth +  "px; background-repeat: no-repeat; background-position: center center; position: absolute; top: 0px; left: 0px; opacity: 0.5; background-color: grey; cursor: wait;'><\/div>" + elem.innerHTML;
			xmlhttpArray[targetId] = getXMLHttpRequest();
			xmlhttpArray[targetId].onreadystatechange=function() {
				if (xmlhttpArray[targetId].readyState==4 && xmlhttpArray[targetId].status==200) {
					document.getElementById(targetId).innerHTML = xmlhttpArray[targetId].responseText;					
				}
			}
			xmlhttpArray[targetId].open("GET", url + "&timestamp=" + new Date().getTime(), true);
			xmlhttpArray[targetId].send();
		}
// portal js library
//		set form field value
		function _pSF(form, name, value) {
			for(i=0; i<form.elements.length; i++){
				if (form.elements[i].name == name) {
					form.elements[i].value = value;
					break;
				}
			}
		}
		function jsfs(pobId, mode, childrenToSubmit, noPortletUpdate, action, args) {

			if(typeof(mode)==='undefined') mode = "Submit";
			if(typeof(childrenToSubmit)==='undefined') childrenToSubmit = new Array();	
			if(typeof(noPortletUpdate)==='undefined') noPortletUpdate = false;	
			if(typeof(action)==='undefined') action = null;
			if(typeof(args)==='undefined') args = new Array();	

			var config = {data: { _virgo_ajax: '1'}};

			if (!noPortletUpdate) {
				config['target'] = '#portlet_container_' + pobId;
			}

			config['beforeSerialize'] = function () {
				if (action) {
					$('#portlet_action_' + pobId).val(action);
					for (var name in args) {
					    if (args.hasOwnProperty(name)) {
					    	$('#'+name).val(args[name]);
					   }
					}
				}
				functionsToCallBeforeSubmit = window['functionsToCallBeforeSubmit'+pobId];
				for (var f in functionsToCallBeforeSubmit){ 
				  var functionToCall = functionsToCallBeforeSubmit[f];
				  functionToCall();
				} 
				functionsToCallBeforeSubmit = new Object();
		    	$('#portlet_form_' + pobId + ' #invoked_portlet_object_id_' + pobId).val(pobId);
				return true;		
			}; // beforeSerialize

		    config['beforeSubmit'] = function() {
				$('div#loading_mask_' + pobId).mask('Loading...');
				return true;
			}; // beforeSubmit

		    config['success'] = function(responseText) {
		    	var functionsToCallAfterLoad = window['functionsToCallAfterLoad'+pobId];
				for (var f in functionsToCallAfterLoad){ 
				  var functionToCall = functionsToCallAfterLoad[f];
				  functionToCall();		  
				} 
				functionsToCallAfterLoad = new Object();
		    	$('#portlet_form_' + pobId + ' #invoked_portlet_object_id_' + pobId).val('');
				$('div#loading_mask_'+pobId).unmask();
				{$logoutDivForm}
		    	$('#portlet_action_' + pobId).val('');
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
				$('#system-messages').ajaxSubmit({ 
					target: '#system-messages-div',
					beforeSerialize:  function() {
							return true;
						},	
					success: function() {
							$('#system-messages').resetForm();
							if ($('#system-messages-div').html() != '') {
								$('#system-messages-div').fadeIn('slow');
							}
						}
					});
				$('#system-messages_'+pobId).ajaxSubmit({ 
					target: '#system-messages-div_'+pobId,
					beforeSerialize:  function() {
							return true;
						},	
					success: function() {
							$('#system-messages_'+pobId).resetForm();
							if ($('#system-messages-div_'+pobId).html() != '') {
								$('#system-messages-div_'+pobId).fadeIn('slow');
							}
						}
					});
			}; // success

			config['error'] = function(error) {
		//		console.log(error);
		    		$('#portlet_form_'+pobId+' #invoked_portlet_object_id_'+pobId).val('');
		    		$('div#loading_mask_'+pobId).unmask();
		//    		alert(error);
		    }; // error

		    if (mode == "Form") {
				$('#portlet_form_'+pobId).ajaxForm(config);
			} else {
				$('#portlet_form_'+pobId).ajaxSubmit(config);
			}
		}		
	</script>
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
	</head>
	<body id="{$page->getAlias()}">
		<noscript>
			<div style="margin: 0px 0px 10px 0px; padding: 20px; font-size: 14px; font-weight: bold; color: red; background-color: yellow; border: 2px solid red; border-radius: 0px; text-align: center;">
				Do prawidłowej pracy strona wymaga włączonej obsługi JavaScript. Proszę włączyć tę obsługę w swojej przeglądarce.
			</div>
		</noscript>
		{$googleFontsCode}
		{$underConstructionWarning}
		{$logoutDiv}
{$preout}
HTML;
	return $out;
}

//
//									get configurable
//
function getConfigurable($page, $sectionName) {
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'meta'.DIRECTORY_SEPARATOR.'_section'.DIRECTORY_SEPARATOR.'params.php')) {
		$configurable = <<<JAVASCRIPT
onclick="
	window.open(
		'{$_SESSION['portal_url']}/index.php?virgo_show_config=section&pgeId={$page->getId()}&section={$sectionName}',
		'portlets',
		'width='+screen.width+',height='+screen.height+',resizable=no,scrollbars=yes,toolbar=no,location=no,directories=no,status=no,menubar=no,copyhistory=no')
	"
JAVASCRIPT;
	} else {
		$configurable = "";
	}						
	return $configurable;	
}

//
//									session portlet content
//
function getSectionPortletContent($page, $sectionName) {
	$configurable = getConfigurable($page, $sectionName);
	$sectionPortletContent = <<<HTML
							<ul class='edit_section'>
								<li class="section_data" {$configurable}>section: <span class="section_name">{$sectionName}</span></li>
								<li>
HTML;
	return $sectionPortletContent;	
}

//
//									portlet geometry
//
function getPortletGeometry($portletObject)  {
	return <<<PORTLET_GEOMETRY
<style type='text/css'>
input.geo {
	font-size: 9px;
	border: 0px;
	height: 10px;
	width: 10px;
	line-height: 9px;
	padding: 0px;
	margin: 0px;
}
input.wide {
	width: 20px;
}
</style>
<form style='display: inline;' method='post'> <!-- bylo legacy_invoked_portlet_object_id -->
	<input 
		type='hidden' 
		name='invoked_portlet_object_id' 
		value='-1'
	>
	<input 
		type='hidden' 
		name='portlet_action' 
		value=''
	>
	<input 
		type='hidden' 
		name='pob_id_-1'
		value='{$portletObject->getId()}'
	>
	<input class='geo' type='submit' value='&uarr;' onclick='this.form.portlet_action.value="GridUp"; this.form.submit();'>
	<input class='geo' type='submit' value='&darr;' onclick='this.form.portlet_action.value="GridDown"; this.form.submit();'>
	<input class='geo' type='submit' value='&larr;' onclick='this.form.portlet_action.value="GridLeft"; this.form.submit();'>
	<input class='geo' type='submit' value='&rarr;' onclick='this.form.portlet_action.value="GridRight"; this.form.submit();'>
	<input class='geo' type='submit' value='&lsaquo;' onclick='this.form.portlet_action.value="GridHigher"; this.form.submit();'>
	<input class='geo' type='submit' value='&rsaquo;' onclick='this.form.portlet_action.value="GridLower"; this.form.submit();'>
	<input class='geo' type='submit' value='&harr;' onclick='this.form.portlet_action.value="GridWider"; this.form.submit();'>
	<input class='geo wide' type='submit' value='&rarr;&larr;' onclick='this.form.portlet_action.value="GridNarrower"; this.form.submit();'>
</form>
<span 
	id='close_icon_{$portletObject->getId()}' 
	class='system_button operations_tab'
	title='Hide portlet content'
	onclick="var form = document.getElementById('portlet_li_{$portletObject->getId()}'); 
	var closeIcon = document.getElementById('close_icon_{$portletObject->getId()}'); if (closeIcon.innerHTML == '&#8709;') { $('#portlet_ul_{$portletObject->getId()}').hide(); closeIcon.innerHTML = '+';} else {form.style.display='block'; closeIcon.innerHTML = '&#8709;';} return false;"
>&#8709;</span>
PORTLET_GEOMETRY;
}

//
//									get title configurable
//
function getTitleConfigurable($portletObject, $portletLocation, $sectionName) {
	return $configurable = <<<JAVASCRIPT
onclick="
var ul=document.getElementById('portlet_ul_{$portletObject->getId()}');
var actualWidth = ul.offsetWidth;
var actualHeight = ul.offsetHeight;
window.open(
	'{$_SESSION['portal_url']}/index.php?virgo_show_config=portlet&plcId={$portletLocation->getId()}&pobId={$portletObject->getId()}&section={$sectionName}&actualWidth='+actualWidth+'&actualHeight='+actualHeight+'',
	'portlets',
	'width='+screen.width+',height='+screen.height+',resizable=no,scrollbars=yes,toolbar=no,location=no,directories=no,status=no,menubar=no,copyhistory=no')
"
JAVASCRIPT;
}

//
//									get portlet title start
//
function getPortletTitleStart($portletObject, $positionCssUl, $nameScroll, $configurable, $portletGeometry, $liBodyStyle) {
	$portletTitle = $portletObject->getTitle();
	return "
<ul 
	class='portlet_frame' 
	id='portlet_ul_{$portletObject->getId()}'
	style='{$positionCssUl}; '
>
	<li class='portlet_name' style='{$nameScroll}'>
<style type='text/css'>
span.system_button {
		float: right; 
		font-weight: normal; 
		cursor: default; 
		border-radius: 4px 4px 4px 4px; 
		color: black; 
		font-size: 9px; 
		line-height: 13px; 
		padding: 0px 2px;
		margin: 0px 1px;
	}
</style>
{$portletGeometry}
		<span
			{$configurable}
		>{$portletTitle}&nbsp;</span>
		<span
			class='system_button operations_tab'
			title='Reload portlet content'
			onclick=\"" . JSFS($portletObject->getId(), 'Submit', true, array(), false) . "\"
		>&#x21bb;</span>
	</li>
	<li 
		id='portlet_li_{$portletObject->getId()}' 
		class='portlet_body' 
		style='{$liBodyStyle}'
	>";

}

//
//									insert grid values
//
function isGridEnabled(&$cellWidth, &$cellHeight, &$gutterWidth, &$gutterHeight, &$cellRealWidth, &$cellRealHeight, &$maxWidth, &$maxHeight, $val) {
	$maxWidth = 0;
	$maxHeight = 0;	
	if (isset($val[2]) && trim($val[2]) != "") { 
		$cellWidth = $val[3];
		$cellHeight = $val[4];
		$gutterWidth = $val[5];
		$gutterHeight = $val[6];
		$cellRealWidth = $cellWidth + $gutterWidth;
		$cellRealHeight = $cellHeight + $gutterHeight;
		return true;
	} else {
		return false;
	}
}

//
//									are tabs enabled
//
function areTabsEnabled($val, &$tabsBegin, &$tabsEnd) {
	$tabsBegin = "";
	$tabsEnd = "";
	$tabsEnabled = false;
	if (isset($val[8]) && trim($val[8]) != "") {
		if (trim($val[8]) == 'tabs="true"') {
			$tabsEnabled = true;
			$tabsBegin = '<div id="tabs" style="visibility: hidden;"><ul>';
			$tabsEnd = '</div>';
		}
	}	
	return $tabsEnabled;
}

//
//									get portlet CSS position
//
function getPortletCssPosition($portletLocation, $gridEnabled) {
	if (!$gridEnabled) {
		$position = $portletLocation->getPosition();
		switch ($position) {
			case -1: return " float: left; "; 
			case  0: return " margin-left: auto; margin-right: auto; "; 
			case  1: return " float: right; "; 
		}
	}
	return null;
}

//
//									get autorefresh code
//
function getAutorefreshCode($portletObject) {
	$autorefresh = $portletObject->getAutorefresh();
	if (isset($autorefresh) && $autorefresh > 0) {
		$timeout = $autorefresh * 1000;
		return "
			function autorefresh" . $portletObject->getId() . "() {
			" . JSFS($portletObject->getId(), 'Submit', true, array(), false) . "
			};
			setInterval(\"autorefresh" . $portletObject->getId() . "()\", {$timeout});
		";
	} else {
		return null;
	}
}

//
//									render portlet
//
function renderPortlet($portletObject, $canEditPage) {
	if ($canEditPage) {
		return true;
	}
	$renderCondition = $portletObject->getRenderCondition();
	if (!is_null($renderCondition) && trim($renderCondition) != "") {
		$render = true;
		eval($renderCondition);
		return $render;
	}
	return true;
}

//
//									system messages AJAX code
//
function getSystemMessagesAjaxCode($portletObject) {
	return <<<HTML
							<div id='system-messages-div_{$portletObject->getId()}' onclick="$('#system-messages-div_{$portletObject->getId()}').fadeOut('slow');" style='display: none; bottom: 0px; left: 10px; position: fixed; z-index: 9999;'></div>
<form method='post' id='system-messages_{$portletObject->getId()}' action='' class='system_messages_form'>
	<fieldset style="display: none;">
		<legend></legend>
		<input type='hidden' name='show_system_message' value='{$portletObject->getId()}'>
	</fieldset>
</form>
<script type='text/javascript'>
$('#system-messages_{$portletObject->getId()}').ajaxSubmit({ 
    target: '#system-messages-div_{$portletObject->getId()}',
    beforeSerialize:  function() {
			return true;
		},	
	success: function() {
			$('#system-messages_{$portletObject->getId()}').resetForm();
			if ($('#system-messages-div_{$portletObject->getId()}').html() != '') {
				$('#system-messages-div_{$portletObject->getId()}').fadeIn('slow');
			}
		}
	});
</script>
HTML;
}

//
//									system messages code
//
function getSystemMessagesCode($portletObject) {
	$messages = "";
	$suffix = "_" . $portletObject->getId();
	if (isset($_SESSION['virgo_msg_queue' . $suffix])) {
		$messages = "<ul class='system_messages'>";
		$queue = $_SESSION['virgo_msg_queue' . $suffix];
		foreach ($queue as $message) {
			$messages = $messages . "<li class='system_message {$message[0]}'>";
			$messages = $messages . $message[1];
			$messages = $messages . "</li>";
		}
		$messages = $messages . "</ul>";
		unset($_SESSION['virgo_msg_queue' . $suffix]);
		/* bylo: position: absolute; top: 0px; width: 100%; */ 								
		return <<<HTML
		<div id='system-messages-div_{$portletObject->getId()}' onclick="$('#system-messages-div_{$portletObject->getId()}').fadeOut('slow');" style="bottom: 0px; left: 10px; position: fixed; z-index: 9999;">{$messages}</div>
HTML;
	} else {
		return "";
	}

}

//
//									portlet begin code
//
function getPortletBeginCode($portletObject, $positionCssMask, $profiler) {
	return <<<HTML
<form
	id='portlet_form_download_{$portletObject->getId()}' 
	method='post' 
	enctype='multipart/form-data'
	style='display: inline;'
	action=''
>
	<fieldset style="display: none;">
		<legend></legend>
		<input type='hidden' name='portlet_action' value=''>
		<input type="hidden" name="ids" value="">
<!--		<input type='hidden' name='legacy_invoked_portlet_object_id' id='legacy_invoked_portlet_object_id_download_{$portletObject->getId()}' value='{$portletObject->getId()}'> -->
		<input type='hidden' name='invoked_portlet_object_id' id='invoked_portlet_object_id_download_{$portletObject->getId()}' value='{$portletObject->getId()}'>
	</fieldset>
</form>
<div id="loading_mask_{$portletObject->getId()}" style="{$positionCssMask}">
<form 
	id='portlet_form_{$portletObject->getId()}' 
	class='portlet' 
	style='display: inline;' 
	method='post' 
	enctype='multipart/form-data'
	action=''
>
	<fieldset style="display: none;">
		<legend></legend>
		<input type='hidden' id='portlet_action_{$portletObject->getId()}' name='portlet_action' value=''>
<!--		<input type='hidden' name='legacy_invoked_portlet_object_id' id='legacy_invoked_portlet_object_id_{$portletObject->getId()}' value='{$portletObject->getId()}'> -->
		<input type='hidden' name='invoked_portlet_object_id' id='invoked_portlet_object_id_{$portletObject->getId()}' value='{$portletObject->getId()}'>
		{$profiler}
	</fieldset>
	<div 
		class='portlet_container {$portletObject->getPortletDefinition()->getAlias()}' 
		id='portlet_container_{$portletObject->getId()}'
		style='position: relative;'
	>
HTML;
}

//
//									JavaScript Triggers
//
function getJavascriptTriggersCode($portletObject) {
	return <<<HTML
<script type='text/javascript'>
var functionsToCallBeforeSubmit{$portletObject->getId()} = new Object();
var functionsToCallAfterLoad{$portletObject->getId()} = new Object();
</script>
HTML;
}

//
//									render not assigned portlet locations
//
function renderNotAssignedPortlets($page, $sectionsInTemplate) {
	$out = "";
	if ($page->canEdit()) {
		$portletLocations = $page->getNotAssignedPortletLocations($sectionsInTemplate);
		$out = $out . "<table style='background-color: #111111; color: #111111' cellspacing='1'><tr><td style='background-color: #EEEEEE;'><strong>Portlets assigned in not existing sections:</strong></tr>";
		foreach ($portletLocations as $portletLocation) {
			$out = $out . "<tr><td style='background-color: #EEEEEE;' onclick=\"
var actualWidth = 500;
var actualHeight = 500;
window.open(
	'{$_SESSION['portal_url']}/index.php?virgo_show_config=portlet&plcId={$portletLocation->getId()}&pobId={$portletLocation->getPortletObject()->getId()}&section={$portletLocation->getSection()}&actualWidth='+actualWidth+'&actualHeight='+actualHeight+'',
	'portlets',
	'width='+screen.width+',height='+screen.height+',resizable=no,scrollbars=yes,toolbar=no,location=no,directories=no,status=no,menubar=no,copyhistory=no')
\">" . $portletLocation->getPortletObject()->getTitle() . " (" . $portletLocation->getPortletObject()->getPortletDefinition()->getName() . ") in section <strong>" . $portletLocation->getSection() . "</strong></td></tr>";
		}
		$out = $out . "</table>";
	}
	return $out;
}

//
//									onLoad Javascript code
//
function getOnloadCode($autorefreshCode) {
	return <<<ONLOAD
<script type="text/javascript">
{$autorefreshCode}
$(function() {
	$.ajaxSetup({ cache: true });
	$("#tabs").tabs();
	$("#tabs").css('visibility','visible');
//	console.log('Page rendered.');
});
</script>
ONLOAD;
}

//
//									System Messages content
//
function getSystemMessagesContent() {
	$messagesContent = "";
	$messages = "";
	if (isset($_SESSION['virgo_msg_queue'])) {
		$messagesContent = "<ul class='system_messages'>";
		$queue = $_SESSION['virgo_msg_queue'];
		foreach ($queue as $message) {
			$messagesContent = $messagesContent . "<li class='system_message {$message[0]}'>";
			$messagesContent = $messagesContent . $message[1];
			$messagesContent = $messagesContent . "</li>";
		}
		$messagesContent = $messagesContent . "</ul>";
		unset($_SESSION['virgo_msg_queue']);
		/* bylo: position: absolute; top: 0px; */ 				
		$messages = <<<HTML
		<div id='system-messages-div' onclick="$('#system-messages-div').fadeOut('slow');" style='bottom: 0px; left: 10px; position: fixed; z-index: 9999;'>{$messagesContent}</div>
HTML;
	}
	return $messages;
}

//
//
//
function showVersionCode() {
	if (isset($_REQUEST['virgo_show_version'])) {
?>
	<table cellspacing="0" style="background-color: white; padding: 5px 5px;">
		<tr style="background-color: grey; color: white;">
			<td><b>Portal version</b></td>
			<td colspan="2" <?php echo (FUNCTIONS_VERSION != PORTAL_VERSION ? 'style="color: darkred;"' : '') ?>><i><?php echo "Functions version: " . FUNCTIONS_VERSION . ", Portal version: " . PORTAL_VERSION ?></i></td>
		</tr>
<?php
		$portletDefinitions = virgoPortletDefinition::selectAllAsObjectsStatic();
		foreach ($portletDefinitions as $portletDefinition) {
			if (substr($portletDefinition->getNamespace(), 0, 1) == "_") continue;
?>
		<tr style="border-bottom: 1px solid grey;">
			<td style="border-bottom: 1px solid grey;"><b><?php echo $portletDefinition->getName() ?></b> - <?php echo $portletDefinition->getNamespace() ?></td>
<?php
			$alias = $portletDefinition->getAlias();
			I($alias, $portletDefinition->getNamespace(), '');
			if (is_callable(array($alias, "getVirgoVersion"))) {
				eval("\$structureVersion = {$alias}::getStructureVersion();");
				eval("\$compatibility = {$alias}::checkCompatibility();");
				eval("\$alias = {$alias}::getVirgoVersion();");
			} else {
				$alias = "?";
				$compatibility = -2;
				$structureVersion = null;
			}
			switch ($compatibility) {
				case 1: $color = "green"; break;
				case 0: $color = "orange"; break;
				case -1: $color = "red"; break;
				default: $color = "black"; break;
			}
?>
<td style="border-bottom: 1px solid grey;"><i><?php echo (isset($structureVersion) ? "$structureVersion" : "") ?></i></td>
			<td style="border-bottom: 1px solid grey; color: <?php echo $color ?>;"><b>Generator: <?php echo $alias ?></b></td>
		</tr>
<?php		
		}
?>
	</table>
<?php
	}	
}

//
//
//
function profiler($time_start) {
	if (isset($_REQUEST['profiler'])) {
?>
<?php echo microtime(true) ?> - <?php echo $time_start ?> = <?php echo microtime(true) - $time_start ?>
<table cellspacing="1" cellpadding="1" style="background-color: #BBB; border: 1px solid #999; font-family: Verdana; color: #000;">
<?php	
		$queryExecutionTimes = $_REQUEST['profiler'];
		asort($queryExecutionTimes);
		$queryExecutionTimes = array_reverse($queryExecutionTimes, true);
		foreach ($queryExecutionTimes as $query => $time) {
?>
	<tr style="background-color: #FFF;">
		<td valign="top"><?php echo number_format($time, 6) ?></td>
		<td align="left"><?php echo $query ?></td>
	</tr>
<?php	
		}
?>
</table>
<table cellspacing="1" cellpadding="1" style="background-color: #BBB; border: 1px solid #999; font-family: Verdana; color: #000;">
<?php	
		$requestCache = $_REQUEST['cache'];
		foreach ($requestCache as $name => $value) {
?>
	<tr style="background-color: #FFF;">
		<td valign="top"><?php echo $name ?></td>
		<td align="left"><?php echo $value ?></td>
	</tr>
<?php	
		}
?>
</table>
<?php	
	}
}

//
//									AJAX form submit code
//
function getAjaxFormSubmitCode($portletObject, $ajax) {
	if ($ajax) {	
		return "
<script type='text/javascript'>
" . JSFS($portletObject->getId(), 'Form', true, array(), false) . "
</script>
";	
	} else {
		return "";
	}
}

//
//									Trigger call
//
function renderTriggerCall($portletObject) {
	return <<<HTML
<script type='text/javascript'>
$(function() {
		for (var f in functionsToCallAfterLoad{$portletObject->getId()}){ 
		  var functionToCall = functionsToCallAfterLoad{$portletObject->getId()}[f];
		  functionToCall();		  
		} 
		functionsToCallAfterLoad{$portletObject->getId()} = new Object();
});
</script>
HTML;
}
?>