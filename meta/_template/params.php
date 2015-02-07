<?php
if (get_magic_quotes_gpc()) {
    function strip_array($var) {
        return is_array($var)? array_map("strip_array", $var):stripslashes($var);
    }

    $_POST = strip_array($_POST);
    $_SESSION = strip_array($_SESSION);
    $_GET = strip_array($_GET);
}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>templates</title>
	</head>
	<body>
<style type="text/css">
* {
	margin: 0px; 
	padding: 0px;
}
body {
	background-color: Navy;
}
textarea {
	font-size: 11px;
	font-family: Courier New, monospace;
	color: black;
	background-color: white;
}
</style>
<?php
//	require_once(dirname(__FILE__).'/../../classes/DatabaseHandler/DatabaseHandler.php');
	$databaseHandler = new DatabaseHandler();
	
	
	if (isset($_POST['tmpId'])) {
		$tmpId = $_POST['tmpId'];
	} elseif (isset($_GET['tmpId'])) {
		$tmpId = $_GET['tmpId'];
	} else {
		echo "No template to configure.";
		exit();
	}	
	if (isset($_POST['mode'])) {
		$mode = $_POST['mode'];
	} elseif (isset($_GET['mode'])) {
		$mode = $_GET['mode'];
	} else {
		$mode = "code";
	}	
	
	$action = $_POST['action'];
	if (isset($action)) {
		switch ($action) {
			case 'html':
				$types = "s";
				$values = array($_POST['text']);
				$updateTimestamp = "";				
				if ($mode == 'css') {
					$updateTimestamp = ", tmp_date_modified = ?";
					$types .= "s";
					$values = array_merge($values, array(date("Y-m-d H:i:s")));
				} 
				$query = " UPDATE prt_templates SET tmp_{$mode} = ? {$updateTimestamp} WHERE tmp_id = {$tmpId} ";
				break;
		}
		if (isset($query)) {
			$databaseHandler->queryPrepared($query, false, $types, $values);
			echo $databaseHandler->error();
		}
		echo "<div onclick='this.style.display=\"none\";' style='border: 2px solid red; color: red; font-weight: bold; background-color: yellow; padding: 5px; margin: 0px 0px 5px 0px;'>Action executed - " . date("Y-m-d H:i:s") . "</div>";
	} else {
		$query = " SELECT tmp_{$mode} FROM prt_templates WHERE tmp_id = {$tmpId} ";
		$result = $databaseHandler->query($query);
		echo QER() == "" ? "" : QER() . " " . $query;
		$row = mysqli_fetch_row($result);	
?>		
<iframe name="result" width="1000" height="30" scrolling="no"></iframe>
<form method="post" target="result">
	<ul>
		<li><input type="submit" value="Store"/></li>
		<li><textarea name="text" rows="45" cols="178"><?php echo $row[0] ?></textarea></li>
	</ul>
	<input type="hidden" value="html" name="action"/>
	<input type="hidden" value="<?php echo $mode ?>" name="mode"/>
</form>
<?php
	}
?>
	</body>
</html>


