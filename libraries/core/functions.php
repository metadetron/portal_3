<?php
/*
	Versioning:
	Major.Minor.Release.Build

	Major: new conception
	Minor: portal interface (functions calls to portal.virgo classes) changed
	Release: interface (some function called by index.php) changed
	Biuld: changes, but not in interface
*/
	define("FUNCTIONS_VERSION", "3.0.0.2"); // TRACE() added
//	define("FUNCTIONS_VERSION", "3.0.0.1"); // error checking from Q corrected
//	define("FUNCTIONS_VERSION", "3.0.0.0"); // first two numbers are common for virgo generator, famework (index.php and functions.php) and portal project

	define("CACHE_NULL_TOKEN", "<__virgo_NULL>");
	define("DATE_FORMAT", "Y-m-d");
	define("DATETIME_FORMAT", "Y-m-d H:i:s");

	use portal\virgoPortal;
	use portal\virgoSystemMessage;
	use portal\virgoUser;
	use portal\virgoTranslation;
	use portal\virgoPortletObject;
	use portal\virgoPortletDefinition;
	use portal\virgoPage;

	function createSymlink($dirname) {
		if (defined('APP_ROOT')) {
			if (!is_dir(APP_ROOT.DIRECTORY_SEPARATOR.$dirname)) {
				if (symlink(PORTAL_PATH.DIRECTORY_SEPARATOR.$dirname, APP_ROOT.DIRECTORY_SEPARATOR.$dirname) === false) {
//					echo PORTAL_PATH.DIRECTORY_SEPARATOR.$dirname . " -> " . APP_ROOT.DIRECTORY_SEPARATOR.$dirname;
				}
			}
		}
	}
//	createSymlink('portlets');
	createSymlink('libraries');
	createSymlink('media');
	createSymlink('css');
	$virgoConfig = parse_ini_file(PORTAL_PATH.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'portal.ini', 1);
	require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'DatabaseHandler'.DIRECTORY_SEPARATOR.'DatabaseHandler.php');
	
	function S(&$text) {
		if (isset($text)) {
			if ($text == "") {
				return false;
			}
			$text = trim($text);
			if ($text == "") {
				return false;
			}		
		} else {
			return false;
		}
		return true;
	}
	
	function R($varName, $default = null) {
		$ret = isset($_POST[$varName]) ? $_POST[$varName] : (isset($_GET[$varName]) ? $_GET[$varName] : $default);
		if (isset($ret)) {
			if (!is_array($ret)) {
				if (get_magic_quotes_gpc()) {
					/* to chyba jednak trzeba usunac stad ten strip... 
					A jednak nie, bo eskapowanie już w samej bazie robimy  */
					$ret = stripslashes($ret);
/*				} else {
					$ret = QE($ret); */
				}
			} 
		}
		return $ret;
	}
	
	function I($entity, $namespace = 'portal', $prefix = 'virgo', $showErrorIfNotExists = true) {
		if (isset($entity)) {
			$file = PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.$namespace.DIRECTORY_SEPARATOR.$prefix.$entity.DIRECTORY_SEPARATOR.'controller.php';
			if (file_exists($file)) {
				require_once($file);
				return true;
			} else {
				if ($showErrorIfNotExists) {
					L('File not found for ' . $entity, 'ERROR');
				}
				return false;
			}
		}
	}

	I('User');
	I('Translation');
	I('PortletObject');
	I('Language');
	
	function IL($library, $namespace = 'core') {
		$fileName = PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.$namespace.DIRECTORY_SEPARATOR.$library.'.php';
		if (file_exists($fileName)) {
			require_once($fileName);
			return true;
		} else {
			L("Library not installed: {$library}", '', 'ERROR');
			return false;
		}
	}

	function ET() {
		$bt =  debug_backtrace();
		if (isset($_SERVER["REQUEST_TIME_FLOAT"])) {
			$ret = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
		} else {
			$ret = microtime(true) - $_SERVER['VIRGO_REQUEST_TIME'];
		}
		echo "<div style='background-color: yellow; color: red; font-size: 10px; font-family: Arial; padding: 10px; margin: 10px; border: 1px solid red;'>FILE: ". $bt[0]['file'] . ", LINE: " . $bt[0]['line'] . ": <b>" . $ret . "</b></div>";
	}

	// jesli jest $prepared to zwraca tablice tablic jako wynik
	// a jak nie, to mysqli_result!
	function Q($query, $log = true, $prepared = false, $types = null, $values = array()) {
		global $databaseHandler;
		if (!isset($databaseHandler)) {
			$databaseHandler = new DatabaseHandler();
		}
		if ($prepared) {
			$ret = $databaseHandler->queryPrepared($query, $log, $types, $values);
		} else {
			$ret = $databaseHandler->query($query, $log);
		}
		if ($ret === false) {
				$qer = QER(); 
				$myFile = PORTAL_PATH . DIRECTORY_SEPARATOR . "log" . DIRECTORY_SEPARATOR . "database_errors.log";
				$fh = fopen($myFile, 'a') or die("can't open file");
				$ip = virgoSystemMessage::getRealIp();
				$url = virgoSystemMessage::getRealUrl();
				fwrite($fh, " - - - database error occurred! - - - \n");
				fwrite($fh, "Message: " . $qer . "\n");
				fwrite($fh, "Details:\n");
				fwrite($fh, $query . "\n");
				fwrite($fh, "Call details: \n");
				fwrite($fh, "Datetime: " . date(DATETIME_FORMAT) . "\n");
				fwrite($fh, "IP: " . $ip . "\n");
				fwrite($fh, "URL: " . $url . "\n");
				$bt =  debug_backtrace();
   				fwrite($fh, "FILE: ". $bt[0]['file'] . "\n");
   				fwrite($fh, "LINE: ". $bt[0]['line'] . "\n");
				fwrite($fh, " - - - - - - - - - - - - - - - - - - -\n");
				fwrite($fh, "\n");
				if (isset($details)) {
					fwrite($fh, $details);
				}
				fclose($fh);
		}
		return $ret;
	}
	
	function QR($query, $log = false, $showError = true, $columnName = null, $prepared = false, $types = null, $values = array()) {
		$rows = array();
		$result = Q($query, $log, $prepared, $types, $values);
		if ($result !== false) {
			
			if (is_array($result)) {
				return $result;
			}
			while ($row = mysqli_fetch_assoc($result)) {
				$rows[] = isset($columnName) ? $row[$columnName] : $row;
			}
			mysqli_free_result($result);
		} else {
			$rows = null;
		}
		return $rows;
	}

	function QPR($query, $types = null, $values = array(), $log = false, $showError = true, $columnName = null) {
		return QR($query, $log, $showError, $columnName, true, $types, $values);
	}
	
	function Q1($query, $log = false, $prepared = false, $types = null, $values = array()) {
		$result = Q($query, $log, $prepared, $types, $values);
		if ($result === false) {
			echo QER();			
		} else {
			if (is_array($result)) {
				if (count($result) > 0) {
					foreach ($result[0] as $key => $value) {
						return $value;
					}
					return $result[0];
				}
			} else {
				while ($row = mysqli_fetch_row($result)) {
					mysqli_free_result($result);
					return $row[0];
				}
			}
		}
		return null;
	}

	function QP1($query, $types = null, $values = array(), $log = false) {
		return Q1($query, $log, true, $types, $values);
	}
	
	function QE($string) {
		global $databaseHandler;
		if (!isset($databaseHandler)) {
			$databaseHandler = new DatabaseHandler();
		}
		return $databaseHandler->escape($string);
	}
	
	function QID() {
		global $databaseHandler;
		if (!isset($databaseHandler)) {
			$databaseHandler = new DatabaseHandler();
		}
		return $databaseHandler->lastId();
	}
	
	function QER() {
		global $databaseHandler;
		if (!isset($databaseHandler)) {
			$databaseHandler = new DatabaseHandler();
		}
		return $databaseHandler->error();
	}

	function QL($query, $log = false, $prepared = false, $types = null, $values = array()) {
		$ret = array();
		$result = Q($query, $log, $prepared, $types, $values);
		if ($result === false) {
			echo QER();
			return null;
		} else {
			if ($log) {
				V($result);
			}
			if (is_array($result)) {
				foreach ($result as $res) {
					foreach ($res as $key => $value) {
						$ret[] = $value;
						break;
					}
				}
			} else {
				while ($row = mysqli_fetch_row($result)) {
					$ret[] = $row[0];
				}
				mysqli_free_result($result);				
			}
		}
		return $ret;
	}	
	
	function QPL($query, $types = null, $values = array(), $log = false) {
		return QL($query, $log, true, $types, $values);
	}	

	function getTokenName($id) {
		return 't' . virgoUser::encryptString("t{$id}");
	}
	
	function getTokenValue($id) {
		return virgoUser::encryptString($id);
	}
	
	function A($id) {
		$tokenName = getTokenName($id);
		$tokenValue = R($tokenName);
//		V("id=$id $tokenName - $tokenValue");
//		if ($tokenValue != getTokenValue($id)) {
//			var_dump(debug_backtrace(false));
//		}
		return $tokenValue == getTokenValue($id);
	}
	
	function E($text, $P = array(), $stringContent = true, $default = null, $isParam = true) {
		$content = $isParam ? PP($text, $default, false) : $text;
		$content = str_replace('"', '\"', $content);
		if ($stringContent) { 
			$fix = "\"";
		} else {
			$fix = "";
		}
		eval("\$ret = {$fix}{$content}{$fix};");
		return $ret;
	}

	function DD($dateFromString, $dateToString) {
		if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
			$date1 = new DateTime($dateFromString);
			$date2 = new DateTime($dateToString);
			$interval = $date1->diff($date2);
			return $interval->days; 
		} else {
			$diffSec = strtotime($dateToString) - strtotime($dateFromString);
			return floor($diffSec/86400);
		}
	}

	function MD($date, $days, $forward = true) {
		if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
			$date1 = new DateTime($date);
			$interval = new DateInterval("P{$days}D");
			if (!$forward) {
				$interval->invert = 1;
			}
			$date1->add($interval); 
			return $date1->format(DATE_FORMAT);
		} else {
			return date('Y-m-d', strtotime($date. ' '.($forward?'+':'-').' '.$days.' days'));
		}
	}

	function N($number) {
		return number_format($number, 2, ',' , ' ');
	}

	function PDF($title = '', $headerHight = 20, $footerHeight = 20, $font = 'freeserif') {
		require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'tcpdf'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'eng.php');
		require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'tcpdf'.DIRECTORY_SEPARATOR.'tcpdf.php');
		$pdf = new FOOTEREDPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(null);
		$pdf->SetTitle($title);
		$pdf->SetSubject(null);
		$pdf->SetKeywords(null);
		$pdf->setImageScale(1.53);
//			$pdf->setHeaderData('/../../../media/liver/logo_podziekowania.jpg', 0, '', '', array(255, 255, 255), array(255, 255, 255));

		$fontBoldVariant = 'B';
		$pdf->setFooterFont(array($font, '', 8));

		$pdf->SetMargins(PDF_MARGIN_LEFT, $headerHight, PDF_MARGIN_RIGHT, $footerHeight);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin($footerHeight);
		$pdf->SetAutoPageBreak(TRUE, $footerHeight);
		$pdf->SetFont($font, '', 10);

		$pdf->AddPage();
		return $pdf;			
	}

	function getPdfColumnAlign($column, $aligns) {
		$align = "L";
		if (isset($column['type'])) {
			if (isset($aligns[$column['type']])) {
				$align = $aligns[$column['type']];
			}
		}
		return $align;
	}

	// table printing into pdf
	// column info: name, title, width, data type, function
	function PDF_T($query, $columns, $pdf) {
		$rows = QR($query);
		$pdf->SetFont('freeserif', 'B', 10);
		$aligns = array('DECIMAL' => 'R', 'INTEGER' => 'R');
		foreach ($columns as $column) {
			$pdf->Cell($column['width'], 0, $column['title'], 'B', 0, getPdfColumnAlign($column, $aligns));			
		}
		$pdf->Cell(0, 0, '', '', 1);	
		$pdf->SetFont('freeserif', '', 10);								
		$functionValues = null;
		foreach ($rows as $row) {
			foreach ($columns as $column) {
				$type = isset($column['type']) ? $column['type'] : null;
				$value = $row[$column['name']];
				if ($type == 'DECIMAL') {
					$displayValue = N($value);
				} else {
					$displayValue = $value;
				}
				$pdf->Cell($column['width'], 0, $displayValue, array('B' => array('width' => 0.1, 'color' => array(200, 200, 200))), 0, isset($aligns[$type]) ? $aligns[$type] : 'L');			
				if (isset($column['function'])) {
					if (is_null($functionValues)) {
						$functionValues = array();
					}
					$functionValue = isset($functionValues[$column['title']]) ? $functionValues[$column['title']] : 0;
					if ($column['function'] == 'COUNT') {
						$addSumRow = true;
						if (isset($value)) {
							$functionValue++;
						}
					} elseif ($column['function'] == 'SUM') {
						$addSumRow = true;
						if (isset($value)) {
							$functionValue += $value;
						}
					}
					$functionValues[$column['title']] = $functionValue;
				}
			}
			$pdf->Cell(0, 0, '', '', 1);						
		}
		if (isset($functionValues)) {
			$pdf->SetFont('freeserif', 'B', 10);
			foreach ($columns as $column) {
				if (isset($column['function'])) {
					$value = isset($functionValues[$column['title']]) ? $functionValues[$column['title']] : 0;
					if ($column['type'] == 'DECIMAL') {
						$value = N($value);
					} else {
						$value = $value;
					}					
				} else {
					$value = "";
				}
				$pdf->Cell($column['width'], 0, $value, 'T', 0, getPdfColumnAlign($column, $aligns));			
			}
			$pdf->SetFont('freeserif', '', 10);
			$pdf->Cell(0, 0, '', '', 1);						
		}
	}
	
	// $html parameter is ignored, kept just for compatibility. Now htmlity is controlled by the MAIL_HTML_CONTENT HtmlContent portlet object */
	function M($to, $subject, $content, $html = false, $attachedFileName = null, $shownFileName = null) {
		$html = false;
		$mailTemplatePobId = virgoPortletObject::getIdByTitleAndAlias('MAIL_TEMPLATE', 'html_content');
		if (isset($mailTemplatePobId)) {
			I('HtmlContent');
			$mailTemplate = virgoHtmlContent::getHtmlContent($mailTemplatePobId);
			if (S($mailTemplate)) {
				$mailTemplate = str_replace('@@subject@@', $subject, $mailTemplate);
				$mailTemplate = str_replace('@@date@@', date(DATE_FORMAT), $mailTemplate);
				$content = str_replace('@@content@@', $content, $mailTemplate);
				$html = true;
			}
		}
		require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'MailHandler'.DIRECTORY_SEPARATOR.'MailHandler.php');
		$from = PP('PORTAL_EMAIL');
		if (is_null($from) || trim($from) == "") {
			$from = "test@metadetron.com";
		}
		if (!MailHandler::send($to, $subject, $content, $from, null, true, $html, $attachedFileName, $shownFileName)) {
			L("Nie udało się wysłać maila na adres " . $to, "ERROR");
			return false;
		}
		return true;
	}

	// convinient encapsulation
	function MP($to, $paramName) {
		$subject = PP($paramName . '_SUBJECT');
		if (!S($subject)) {
			L('Portal parameter ' . $paramName . '_SUBJECT not defined!', null, 'WARN');
		}
		$content = PP($paramName . '_CONTENT');
		if (!S($content)) {
			L('Portal parameter ' . $paramName . '_CONTENT not defined!', null, 'WARN');
			if (!S($subject)) {
				L('Email not sent', null, 'ERROR');
				return;
			}
		}
		return M($to, $subject, $content, false, null, null);
	}
	
	function HREF($plcId, $action, $options, $rowId = null) {
		$plc = new virgoPortletLocation($plcId);
		$page = $plc->getPage();
		$pobId = $plc->getPobId();
		$identifier = $page->getPortal()->getPortalUrl();
		if ($identifier == "/") {
			$identifier = "";
		}				
		$ret =  
			$identifier . $page->getPath() . '?' .
			'invoked_portlet_object_id=' . $pobId . '&' .
			'portlet_action=' . $action;
		if (isset($options)) {
			foreach ($options as $key => $value) {
				$ret = $ret . '&' . $key . '=' . $value;
			}
		}
		if (isset($rowId)) {
			$ret = $ret . '&' . getTokenName($rowId) . '=' . getTokenValue($rowId);
		}
		return $ret;
	}
	/* ********* to pewnie bedzie do zmiany, jak bedzie ajax (poczatek) ********** */
	function JSF() {
		echo "var f = getPortletForm({$_SESSION['current_portlet_object_id']});";
	}
	
	function JSA($action) {
		echo "submitPortletAction('$action', {$_SESSION['current_portlet_object_id']})";
	}
	
	function JSV($name, $value) {
		echo "if (f.{$name} === undefined) {var i = document.createElement('input'); i.setAttribute('type', 'hidden'); i.setAttribute('name', '{$name}'); i.setAttribute('value', '{$value}'); f.appendChild(i);} else { f.$name.value = '$value';}";
	}
	
	function JSVA($name, $value, $action) {
		JSF();
		JSV($name, $value);
		echo "f.portlet_action.value = '$action'; f.submit()";
	}
	
	function JSVAU($name, $value, $action, $url, $invokedPortletObjectId = null, $rowId = null) {
		JSF();
		JSV($name, $value);
		if (isset($invokedPortletObjectId)) {
			JSV('invoked_portlet_object_id', $invokedPortletObjectId);
		}
		if (isset($rowId)) {
			JSV(getTokenName($rowId), getTokenValue($rowId));
		}
		echo "f.portlet_action.value = '$action'; f.action='$url'; f.submit()";
	}
	/* ********* to pewnie bedzie do zmiany, jak bedzie ajax (koniec) ********** */

	/*  */
	function prepareChildrenToSubmit($pobId, &$pobsToSkip = array(), $page = null) {
PROFILE('prepareChildrenToSubmit');		
		if (in_array($pobId, $pobsToSkip)) {
PROFILE('prepareChildrenToSubmit');		
			return null;
		}
		$pobsToSkip[] = $pobId;
		if (!isset($page)) {
			$page = virgoPage::getCurrentPage();
		}
		$query = "
SELECT plc_pob_id AS do_odswiezenia
FROM prt_portlet_locations, prt_portlet_parameters
WHERE plc_pge_id = ?
AND plc_pob_id = ppr_pob_id 
AND (ppr_value = ? OR ppr_value LIKE ? OR ppr_value LIKE ? OR ppr_value LIKE ?)
AND (ppr_name = ? OR ppr_name = ? OR ppr_name = ?)
UNION
SELECT CONVERT(ppr_value, SIGNED) AS do_odswiezenia
FROM prt_portlet_parameters
WHERE ppr_pob_id = ?
AND (ppr_name = ?)
UNION
SELECT pob_id AS do_odswiezenia 
FROM prt_portlet_objects
WHERE pob_pob_id = ?
";
		$rows = QPR($query, "isssssssisi", array(
			$page->getId(), 
			''.$pobId, 
			'%,'.$pobId, 
			$pobId.',%', 
			'%,'.$pobId.',%', 
			'parent_entity_pob_id',
			'master_entity_pob_id',
			'filter_entity_pob_id',
			$pobId, 
			'master_entity_pob_id',
			$pobId
		));
		$children = array();
		if ($rows && count($rows) > 0) {
			foreach ($rows as $row) {
				$doOdsId = $row['do_odswiezenia'];
				if (!in_array($doOdsId, $pobsToSkip)) {
					$children[$doOdsId] = prepareChildrenToSubmit($doOdsId, $pobsToSkip, $page);
				}
			}
		}
PROFILE('prepareChildrenToSubmit');		
		return $children;
	}

	function JSFS($pobId = null, $mode = "Submit", $submitChildren = true, $pobsToSkip = array(), $noPortletUpdate = false, $action = null, $args = array()) {
PROFILE('JSFS');
		if (is_null($pobId)) {
			$pobId = $_SESSION['current_portlet_object_id'];
		}
		$childrenToSubmit = array();
		if ($submitChildren) {
			$childrenToSubmit[$pobId] = prepareChildrenToSubmit($pobId);
		}
		$childrenToSubmitJSString = str_replace("\"", "'", json_encode($childrenToSubmit/*, JSON_FORCE_OBJECT*/));		
		$noPortletUpdateString = $noPortletUpdate ? "true" : "false";
		$ret = "var childrenToSubmit = " . $childrenToSubmitJSString . "; jsfs({$pobId}, '{$mode}', childrenToSubmit, {$noPortletUpdateString}, '{$action}', new Array());";
PROFILE('JSFS');
		return $ret;

	}
	
// Form - Prepares a form to be submitted via AJAX.  Submit - Immediately submits the form via AJAX	
	function JSFS_old($pobId = null, $mode = "Submit", $submitChildren = true, $pobsToSkip = array(), $noPortletUpdate = false, $action = null, $args = array()) {
		if (is_null($pobId)) {
			$pobId = $_SESSION['current_portlet_object_id'];
		}
		if (in_array($pobId, $pobsToSkip)) {
			return;
		}
/*		if ($mode == "Form" && $submitChildren) {
			$target = "div#virgo_popup"; 
			$showPopup = "$('table#popup').show();";
		} else {
		    $target = "#portlet_container_{$pobId}";
		    $showPopup = "";
		}*/
		if ($noPortletUpdate) {
			$target = "";
		} else {
			$target = "target: '#portlet_container_{$pobId}',";
		}
		if (isset($action)) {
			$actionCode = "$('#portlet_action_{$pobId}').val('{$action}');";
			if (isset($args)) {
				foreach ($args as $name => $value) {
					$actionCode .= "$('#{$name}').val('{$value}');";
				}
			}
		} else {
			$actionCode = "";			
		}
		$logoutDiv = (PP('AUTO_LOGOUT', '1') == "0" ? '' : "$('#logout').autoLogout('resetTimer');");
		$ret = <<<FORM
var config = new Array(); 
config = {
    {$target}
	data: { _virgo_ajax: '1'},
    beforeSerialize:  function() {
		{$actionCode}
		for (var f in functionsToCallBeforeSubmit{$pobId}){ 
		  var functionToCall = functionsToCallBeforeSubmit{$pobId}[f];
		  functionToCall();
		} 
		functionsToCallBeforeSubmit{$pobId} = new Object();
    	$('#portlet_form_{$pobId} #invoked_portlet_object_id_{$pobId}').val('{$pobId}');
		return true;
	},
    beforeSubmit:  function() {
		$('div#loading_mask_{$pobId}').mask('Loading...');
		return true;
	},
    success:  function(responseText) {
//    alert(responseText);
		for (var f in functionsToCallAfterLoad{$pobId}){ 
		  var functionToCall = functionsToCallAfterLoad{$pobId}[f];
		  functionToCall();		  
		} 
		functionsToCallAfterLoad{$pobId} = new Object();
    	$('#portlet_form_{$pobId} #invoked_portlet_object_id_{$pobId}').val('');
		$('div#loading_mask_{$pobId}').unmask();
		{$logoutDiv}
    	$('#portlet_action_{$pobId}').val('');
FORM;
// potem zrobic to jakims jsonem, zeby odswiezal tylko kiedy dostaje sygnal z 
// serwera (podobnym mechanizmem co komunikaty systemowe dla uzytkownika
// To jednak musi byc w "success", bo tak, to czasem dziecko sie przed rodzicem odswieza :-(
		if (/* $mode == "Submit" && */ $submitChildren) {
			$pobsToSkip[] = $pobId;
			$page = virgoPage::getCurrentPage();
			$query = "
SELECT plc_pob_id AS do_odswiezenia
FROM prt_portlet_locations, prt_portlet_parameters
WHERE plc_pge_id = ?
AND plc_pob_id = ppr_pob_id 
AND (ppr_value = ? OR ppr_value LIKE ? OR ppr_value LIKE ? OR ppr_value LIKE ?)
AND (ppr_name = 'parent_entity_pob_id' OR ppr_name = 'master_entity_pob_id' OR ppr_name = 'filter_entity_pob_id')
";
			$rows = QPR($query, "issss", array($page->getId(), ''.$pobId, '%,'.$pobId, $pobId.',%', '%,'.$pobId.',%'));
			if ($rows && count($rows) > 0) {
				foreach ($rows as $row) {
					$ret = $ret . JSFS($row['do_odswiezenia'], "Submit", true, $pobsToSkip);					
				}
			}
			$query = "
SELECT CONVERT(ppr_value, SIGNED) AS do_odswiezenia
FROM prt_portlet_parameters
WHERE ppr_pob_id = ?
AND (ppr_name = 'master_entity_pob_id')
";		
			$rows = QPR($query, "i", array($pobId));
			if ($rows && count($rows) > 0) {
				foreach ($rows as $row) {
					$ret = $ret . JSFS($row['do_odswiezenia'], "Submit", true, $pobsToSkip);					
				}
			}
			$query = "
SELECT pob_id AS do_odswiezenia 
FROM prt_portlet_objects
WHERE pob_pob_id = ?
";		
			$rows = QPR($query, "i", array($pobId));
			if ($rows && count($rows) > 0) {
				foreach ($rows as $row) {
					$ret = $ret . JSFS($row['do_odswiezenia'], "Submit", true, $pobsToSkip);					
				}
			}
		} 
		$ret = $ret . <<<FORM
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
		$('#system-messages_{$pobId}').ajaxSubmit({ 
			target: '#system-messages-div_{$pobId}',
			beforeSerialize:  function() {
					return true;
				},	
			success: function() {
					$('#system-messages_{$pobId}').resetForm();
					if ($('#system-messages-div_{$pobId}').html() != '') {
						$('#system-messages-div_{$pobId}').fadeIn('slow');
					}
				}
			});
	},
	error:  function(error) {
//		console.log(error);
    		$('#portlet_form_{$pobId} #invoked_portlet_object_id_{$pobId}').val('');
    		$('div#loading_mask_{$pobId}').unmask();
//    		alert(error);
    	} 	
};
$('#portlet_form_{$pobId}').ajax{$mode}(config);
FORM;
		return $ret;
	}

	function AB($action, $value, $prefix = null, $id = null, $extraJavascript = "", $confirmationMessage = "", $download = false) {
		if (isset($prefix)) {
			$pobId = $_SESSION['current_portlet_object_id'];
			$rowIdCode = "_pSF(form, \"{$prefix}_id_{$pobId}\", \"{$id}\"); ";
/*			$rowIdCode = <<<JAVASCRIPT
for(i=0; i<form.elements.length; i++){
	if (form.elements[i].name == "{$prefix}_id_{$_SESSION['current_portlet_object_id']}") {
		form.elements[i].value = "{$id}";
		break;
	}
}
JAVASCRIPT; */
		} else {
			$rowIdCode = "";
		}
?>		
<input type='<?php echo $download ? 'button' : 'submit' ?>' value='<?php echo $value ?>' onclick='<?php echo ($confirmationMessage != "" ? " if (!confirm(". json_encode($confirmationMessage) .")) { return false; } " : "") ?>this.form.portlet_action.value="<?php echo $action ?>"; <?php echo $rowIdCode ?> <?php echo $extraJavascript ?> <?php echo $download ? 'this.form.submit()' : '' ?>' class='button btn'>
<?php
	}

	// czy to aby na pewno jest teraz dobrze?
	function getFormValue($name, $value = null) {
		global $portletActionReturnValue;
		if ($portletActionReturnValue === 0) {
			return isset($value) ? $value : R($name); // bylo: R($name);
		}
		return R($name); // bylo: isset($value) ? $value : R($name);
	}

	function IT($name, $value = null, $size = null, $number = false) {
		$value = getFormValue($name, $value);
?>
<input 
	class="inputbox" 
	type="text" 
	name="<?php echo $name ?>" 
	id="<?php echo $name ?>" 
<?php	
		if (isset($size)) {
?>
	size="<?php echo $size ?>"
<?php	
		} elseif ($number) {
?>
	size="2"
<?php	
		}
?>
	value="<?php echo $value ?>"
<?php	
		if ($number) {
?>
	style="text-align: right;"
<?php	
		}
?>
/>
<?php		
	}
	
	function IR($name, $hash, $value) {
		$value = getFormValue($name, $value);
		if (isset($name) && is_array($hash)) {
			foreach ($hash as $val => $label) {
?>
<label class="label">
<input 
	type="radio" 
	name="<?php echo $name ?>" 
	value="<?php echo $val ?>"
	id="<?php echo $name ?>" 
<?php
		if ($val == $value) {
?>	
	checked="checked"
<?php
		}
?>	
/><?php echo $label ?></label>
<?php		
			}
		}
	}

	function IS($name, $hash, $value = null, $onchange = null, $nullable = false) {
		$value = getFormValue($name, $value);
?>
<select
	name="<?php echo $name ?>"
	class="inputbox"
	id="<?php echo $name ?>" 
<?php
		if (isset($onchange)) {
?>	
	onchange="<?php echo $onchange ?>"
<?php
		}
?>
>
<?php		
		if ($nullable) {
?>
	<option></option>
<?php			
		}
		if (isset($name) && is_array($hash)) {
			foreach ($hash as $val => $label) {
?>
<option 
	value="<?php echo $val ?>"
<?php
		if ($val == $value) {
?>	
	selected="selected"
<?php
		}
?>	
><?php echo $label ?></option>
<?php		
			}
		}
?>
</select>
<?php		
	}

	function ID($name, $value = null, $today = false) {
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
		$locale = setlocale(LC_ALL,"0");
		if (isset($locale) && trim($locale) != "") {
			$lang = substr($locale, 0, 2);
		} else {
			$lang = "en";
		}
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
		if (is_null($value)) {
			if ($today) {
				$value = date(DATE_FORMAT);
			}
		}
?>
<input 
	type="text" 
	class="inputbox" 
	style="" 
	id="<?php echo $name ?>" 
	name="<?php echo $name ?>" 
	size="10" 
	value="<?php echo $value ?>" 
	onchange="this.form.virgo_changed.value='T'"
>
<script type="text/javascript">
$(function(){ 
  $("#<?php echo $name ?>").datepicker({dateFormat: "yy-mm-dd"});
});
</script>  							
<?php		
	}

	function deleteFileFromCache($id, $tableName, $imageProperty) {
		$cacheFile = PORTAL_PATH.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR."media".DIRECTORY_SEPARATOR.$tableName.DIRECTORY_SEPARATOR.getCacheFileName($id, $imageProperty, '*', '*');
		$files = glob($cacheFile);
		if ($files) {
			array_map("unlink", $files);		
		}
	}
	
	function getCacheFileName($id, $imageProperty, $sizeX, $sizeY) {
		return "" . md5($id . "-" . $imageProperty) . "-" . $sizeX . "x" . $sizeY . ".jpg";
	}
	
	function scaleImage($src_image, $cacheFileName, $thumbnailWidth, $thumbnailHeight, $shrinkOnly = false) {
			$imageX = imagesx($src_image);
			$imageY = imagesy($src_image);				
			$factorX = isset($thumbnailWidth) ? $imageX / $thumbnailWidth : 0;
			$factorY = isset($thumbnailHeight) ? $imageY / $thumbnailHeight : 0;
			$factor = max($factorX, $factorY);
			if ($factor < 1 && $shrinkOnly) {
				imagejpeg($src_image, $cacheFileName, 100);
			} else {
				$thumbnailWidth = $imageX / $factor;
				$thumbnailHeight = $imageY / $factor;
				$dst_image = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);
				imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $thumbnailWidth, $thumbnailHeight, $imageX, $imageY);
				imagejpeg($dst_image, $cacheFileName, 100);
				imagedestroy($dst_image);
			}
	}
	
	function checkCacheDir($tableName) {
		if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR."media".DIRECTORY_SEPARATOR.$tableName)) {
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR."media")) {
				if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR."cache")) {
					mkdir(PORTAL_PATH.DIRECTORY_SEPARATOR."cache");
				}
				mkdir(PORTAL_PATH.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR."media");
			}
			mkdir(PORTAL_PATH.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR."media".DIRECTORY_SEPARATOR.$tableName);
		}
	}
	
	function getCachedImagePath($tableName, $tablePrefix, $propertyName, $id, $thumbnailWidth, $thumbnailHeight, $shrinkOnly = true) {
		checkCacheDir($tableName);
		$cacheFile = "cache".DIRECTORY_SEPARATOR."media".DIRECTORY_SEPARATOR.$tableName.DIRECTORY_SEPARATOR.getCacheFileName($id, $propertyName, $thumbnailWidth, $thumbnailHeight);
		$cacheFileName = PORTAL_PATH.DIRECTORY_SEPARATOR.$cacheFile;
		if (!file_exists($cacheFileName)) {
			$query = " SELECT {$tablePrefix}_{$propertyName}_virgo_blob FROM {$tableName} WHERE {$tablePrefix}_id = {$id} ";
			$res = Q1($query);
			$src_image = imagecreatefromstring($res);
			if (isset($thumbnailWidth) || isset($thumbnailHeight)) {
				scaleImage($src_image, $cacheFileName, $thumbnailWidth, $thumbnailHeight, $shrinkOnly);
			} else {
				$dst_image = $src_image;
				imagejpeg($dst_image, $cacheFileName, 100);
			}
			imagedestroy($src_image);
		}
		return $cacheFile;
	}
	
	function V($object, $exit = false) {
		$backTrace = debug_backtrace();
		echo "<pre>{$backTrace[0]['file']} ({$backTrace[0]['line']}):\n";
		var_dump($object);
		echo "</pre>";
		if ($exit) {
			exit();
		}
	}

	function N2C($val) {		
		return isset($val) ? $val : CACHE_NULL_TOKEN;
	}

	function C2N($val) {
		return $val === CACHE_NULL_TOKEN ? null : $val;
	}

	function C($elemName, &$value, $pobLevel = true) {
		if (!isset($_REQUEST['cache'])) {
			$_REQUEST['cache'] = array();
		}
		$cacheElemName = $elemName . '_' . ($pobLevel ? (isset($_SESSION['current_portlet_object_id']) ? $_SESSION['current_portlet_object_id'] : 'X') : '');
		if (isset($_REQUEST['cache'][$cacheElemName])) {
			$value = C2N($_REQUEST['cache'][$cacheElemName]);
			return true;
		} else {
			$value = null;
			return false;
		}
	}
	
	function CS($elemName, $value, $pobLevel = true) {
		if (!isset($_REQUEST['cache'])) {
			$_REQUEST['cache'] = array();
		}
		$cacheElemName = $elemName . '_' . ($pobLevel ? (isset($_SESSION['current_portlet_object_id']) ? $_SESSION['current_portlet_object_id'] : 'X') : '');
		$_REQUEST['cache'][$cacheElemName] = N2C($value);
		return $value;
	}

	function P($parameterName, $defaultValue = null, $alias = null, $namespace = null) {		
		if (isset($_SESSION['current_portlet_object_id'])) {
			$cached = C('p_' . $parameterName, $ret);
			if ($cached) {
				return $ret;
			}
			$ret = virgoPortletObject::getParameterValue($parameterName, $_SESSION['current_portlet_object_id'], $alias, $namespace);
			if (!isset($ret)) {
				return CS('p_' . $parameterName, PP('DEFAULT_' . $parameterName, $defaultValue, false));
			}
			return CS('p_' . $parameterName, $ret);
		}
		return $defaultValue;
	}
		
	function PD($parameterName, $pdfAlias, $defaultValue = null, $pdfNamespace = null) {
		$ret = virgoPortletDefinition::getParameterValue($parameterName, $pdfAlias, $pdfNamespace);
		if (!isset($ret)) {
			return $defaultValue;
		}
		return $ret;
	}
	
	function PN($parameterName) {
		return virgoPortletObject::getParameterValues($parameterName, $_SESSION['current_portlet_object_id']);
	}

	function PP($parameterName, $defaultValue = null, $insert = true) {
		$ret = virgoPortal::getParameterValue($parameterName, $defaultValue, $insert);
		if (!isset($ret)) {
			if (!isset($defaultValue)) {
				if ($parameterName == "PORTAL_NAME") {
					$ret = virgoPortal::getCurrentPortal()->getName();
					if (!S($ret)) {
						return $_SERVER['SERVER_NAME'];
					}
				}
			} else {
				return $defaultValue;
			}
		}
		return $ret;
	}
	
	function D($data, $saveAsFileName = 'download', $type = 'text/plain') {
		while (ob_get_level() > 0) {
			ob_end_clean();
		}
		header('Content-Type: ' . $type);
		if (headers_sent()) {
			echo 'Some data has already been output to browser';
		}
		header('Content-Disposition: attachment; filename="'.$saveAsFileName.'";');
		header('Content-Length: '.strlen($data));		
		flush();
		echo $data;
		exit();
	}
	
	function T() {
		$ret = virgoTranslation::translate(array_merge(array(true), func_get_args()));
		return $ret;
	}
	
	function TE() {
		$ret = virgoTranslation::translate(array_merge(array(false), func_get_args()));
		return $ret;
	}

	function L($message, $details = null, $level = 'INFO') {
		return virgoSystemMessage::write($message, $details, $level);
	}

	function TRACE($message) {
		return L($message, '', 'TRACE');
	}

	function DEBUG($message) {
		return L($message, '', 'DEBUG');
	}
	
	function ERROR($message) {
		return L($message, '', 'ERROR');
	}

	function LE($ret) {
		if ($ret != "") {
			return L($ret, '', 'ERROR');
		}
		return null;
	}

	function PROFILE($name) {
		if (isset($_REQUEST['profiler'])) {
			if (!isset($_REQUEST['time_start_' . $name])) {
				$_REQUEST['time_start_' . $name] = microtime(true);
			} else {
				if (isset($_REQUEST['profiler'][$name])) {
					$queryExecutionTime = $_REQUEST['profiler'][$name];
				} else {
					$queryExecutionTime = 0;
				}
				$_REQUEST['profiler'][$name] = $queryExecutionTime + (microtime(true) - ($_REQUEST['time_start_' . $name]));
				unset($_REQUEST['time_start_' . $name]);
			}
		}
	}

	function renderTransparentPNG($opacity, $baseColor) {
		checkCacheDir('_virgo_utils');
		$cacheFile = "cache".DIRECTORY_SEPARATOR."media".DIRECTORY_SEPARATOR.'_virgo_utils'.DIRECTORY_SEPARATOR.'_background_'.$opacity.'_'.$baseColor.'.png';
		$cacheFileName = PORTAL_PATH.DIRECTORY_SEPARATOR.$cacheFile;
		$color = ($baseColor == 'white' ? 255 : 0);
		$op = (100 - $opacity) * 127 / 100;
		if (!file_exists($cacheFileName)) {
			$im = imagecreate(100, 100);
			$colourBlack = imagecolorallocatealpha($im, $color, $color, $color, $op);
			imagepng($im, $cacheFileName, 0);
			imagedestroy($im);
		}
		header('Location: ' . $_SESSION['portal_url'] . "/" . $cacheFile);		
		exit();
	}

	function ST() {
		$e = new Exception;
		echo "<pre style='font-family: Courier New; font-size: 10px; line-height: 11px;'>";
		echo $e->getTraceAsString();		
		echo "</pre>";
	}
?>
