<?php
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>pages</title>
	</head>
	<body>
<script type="text/javascript">
	function slugMe(title) {
		return title.toLowerCase().replace(/^\s+|\s+$/g, "").replace(/[_|\s]+/g, "-").replace(/[^a-z0-9-]+/g, "").replace(/[-]+/g, "-").replace(/^-+|-+$/g, "");
	}
</script>	
<style type="text/css">
form, table, input, textarea, fieldset {
	font-size: 11px;
}
form, table, input, fieldset {
	font-family: Verdana;
}
textarea {
	font-family: Courier;
}
form {
	background-color: LightGoldenRodYellow;
	color: Black;
	padding: 10px;
	margin: 5px;
	border: 2px outset BurlyWood;
}
tr.spacer {
    background-color: Wheat;
    font-weight: bold;
}
th {
	background-color: White;
}
ul {
	list-style: none;
	margin: 0px;
	padding: 0px;
}
ul li {
	color: Grey;
	border-left: 1px solid LightGrey;
}
.newPage {
	border: 1px solid beige;
	background-color: lightGoldenrodYellow;
}
.checkbox {
	margin: 0px;
}
table.perm, div.perm {
	font-size: 6px;
	display: inline;
}
table.perm input, table.perm tr, table.perm td {
	padding: 0px;
	margin: 0px;
}
table.perm td.neutral {
	background-color: LightGrey;
}
table.perm td.allowed {
	background-color: LightGreen;
}
table.perm td.blocked {
	background-color: Red;
}
</style>
<form method="post" action="#?prtId=<?php echo $_GET['prtId'] ?>">
<?php
//	require_once(dirname(__FILE__).'/../../classes/DatabaseHandler/DatabaseHandler.php');
	$databaseHandler = new DatabaseHandler();
	
	$templates = array();
	$result = $databaseHandler->query(" SELECT tmp_id, tmp_name FROM prt_templates ");
	echo QER();
	while($row = mysqli_fetch_row($result)) {
		$templates[$row[0]] = $row[1];
	}	
	
	$roles = array();
	$result = $databaseHandler->query(" SELECT rle_id, rle_name FROM prt_roles WHERE IFNULL(rle_virgo_deleted, 0) = 0 ");
	echo QER();
	while($row = mysqli_fetch_row($result)) {
		$roles[$row[0]] = $row[1];
	}	

	function zapiszZmianyCol($id, $formVal, $column, $val) {
		global $databaseHandler; 
		if ($formVal != $val) {
			$query = " UPDATE prt_pages SET pge_{$column} = '" . $formVal . "' WHERE pge_id = $id ";
			$databaseHandler->query($query);
			echo QER() == "" ? "" : QER() . " " . $query;
		}
	}
	
	function zapiszNowego($parentId) {
		global $databaseHandler;
		if (trim($_POST["new_title_{$parentId}"]) != "" && trim($_POST["new_alias_{$parentId}"]) != "") {
			$query = "
SELECT 
  IFNULL(parent.pge_path, ?) AS path, 
  MAX(IFNULL(child.pge_order, 0)) + 10 AS `order`
FROM 
  prt_pages child
  LEFT OUTER JOIN prt_pages parent ON child.pge_pge_id = parent.pge_id
WHERE 
  parent.pge_id " . (isset($parentId) ? " = {$parentId} " : " IS NULL ") . "
GROUP BY 
  IFNULL(parent.pge_path, ?)
			";
			$result = $databaseHandler->queryPrepared($query, false, "ss", array("", ""));
			echo QER() == "" ? "" : QER() . " " . $query;
			if (count($result) > 0) {
				$order = $result[0]['order'];
				$path = $result[0]['path'] . "/" . trim($_POST["new_alias_{$parentId}"]);
			} else {
				$order = 10;
				$path = "/" . trim($_POST["new_alias_{$parentId}"]);
			}
			$query = "INSERT INTO prt_pages (pge_virgo_title, pge_title, pge_alias, pge_default, pge_order, pge_path, pge_tmp_id, pge_pge_id, pge_prt_id) SELECT ?, ?, ?, " /*. ($_POST['new_default_' . $paretnId] == "on" ? "1" : "0")*/ . " 0, {$order}, ?, " . (isset($_POST["new_tmp_id_{$parentId}"]) && trim($_POST["new_tmp_id_{$parentId}"]) != "" ? $_POST["new_tmp_id_{$parentId}"] : "NULL") . ", " . (isset($parentId) ? $parentId : "NULL") . ", prt_id FROM prt_portals WHERE prt_id = {$_GET['prtId']}";
			$databaseHandler->queryPrepared($query, false, "ssss", array("(" . trim($_POST["new_title_{$parentId}"]) . ")", trim($_POST["new_title_{$parentId}"]), trim($_POST["new_alias_{$parentId}"]), $path));
			echo QER() == "" ? "" : QER() . " " . $query;
			unset($_POST["new_title_{$parentId}"]);
			unset($_POST["new_alias_{$parentId}"]);
			unset($_POST["new_tmp_id_{$parentId}"]);
		}
	}
	
	function zapiszPozwolenie($id, $action, $roles) {
		global $databaseHandler;
		foreach ($roles as $roleId => $name) {
			$checkNull = false;
			$query = " SELECT prm_{$action} FROM prt_permissions WHERE prm_rle_id = {$roleId} AND prm_pge_id = {$id} ";
			$result = $databaseHandler->query($query);
			echo QER() == "" ? "" : QER() . " " . $query;
			$row = mysqli_fetch_row($result);
			$query = null;
			if ($_POST["{$action}_{$roleId}_{$id}"] == "NULL") {
				if ($row) {	
					if (isset($row[0])) {
						$query = " UPDATE prt_permissions SET prm_{$action} = NULL WHERE prm_rle_id = {$roleId} AND prm_pge_id = {$id} ";
						$checkNull = true;
					}
				}
			} else {
				$val = $_POST["{$action}_{$roleId}_{$id}"];
				if (!$row) {
					$query = " INSERT INTO prt_permissions (prm_{$action}, prm_rle_id, prm_pge_id) VALUES ({$val}, {$roleId}, {$id}) ";
				} else {
					if ($row[0] != $val) {
						$query = " UPDATE prt_permissions SET prm_{$action} = {$val} WHERE prm_rle_id = {$roleId} AND prm_pge_id = {$id} ";
					}
				}
			}
			if (isset($query)) {
				$databaseHandler->query($query);
				echo QER() == "" ? "" : QER() . " " . $query;
				if ($checkNull) {
					$query = " DELETE FROM prt_permissions WHERE prm_view IS NULL AND prm_edit IS NULL AND prm_configure IS NULL AND prm_rle_id = {$roleId} AND prm_pge_id = {$id} ";
					$databaseHandler->query($query);
					echo QER() == "" ? "" : QER() . " " . $query;
				}
			}
		}
	}
		
	function zapiszZmiany($row, $roles) {
		global $databaseHandler;
		if ($_POST["delete_{$row[0]}"] == "on") {
			$query = " DELETE FROM prt_pages WHERE pge_id = {$row[0]} ";
			$databaseHandler->query($query);
			echo QER() == "" ? "" : QER() . " " . $query;
		} else {
			zapiszZmianyCol($row[0], trim($_POST["title_{$row[0]}"]), 'title', $row[1]);
			zapiszZmianyCol($row[0], trim($_POST["alias_{$row[0]}"]), 'alias', $row[2]);
			zapiszZmianyCol($row[0], $_POST["default_{$row[0]}"] == "on" ? 1 : 0, 'default', $row[3]);
			zapiszZmianyCol($row[0], $_POST["tmp_id_{$row[0]}"], 'tmp_id', $row[4]);
			zapiszNowego($row[0]);
			zapiszPozwolenie($row[0], 'view', $roles);
			zapiszPozwolenie($row[0], 'edit', $roles);
		}
	}
	
	function isa($roleId, $pageId, $action) {
		global $databaseHandler;
		$query = " SELECT prm_{$action} FROM prt_permissions WHERE prm_rle_id = {$roleId} AND prm_pge_id = {$pageId} ";
		$result = $databaseHandler->query($query);
		echo QER() == "" ? "" : QER() . " " . $query;
		if ($result) {
			return mysqli_fetch_row($result);
		} else {
			return null;
		}
	}
		
	function perm($roleId, $pageId, $action, $value) {
		$row = isa($roleId, $pageId, $action);
		if ($row) {
			if (is_null($row[0])) {
				return !isset($value);
			} else {
				if (!isset($value)) {
					return false;
				} else {
					return $row[0] == $value;
				}
			}
			
		} else {
			return !isset($value);
		}
	}
	
	$action = $_POST['action'];
	if (isset($action)) {
		switch ($action) {
			case 'pages':
				$query = "
SELECT 
  pge_id, pge_title, pge_alias, pge_default, pge_tmp_id
FROM 
  prt_pages
WHERE 
  pge_prt_id = {$_GET['prtId']} 
";
				$result = $databaseHandler->query($query);
				while($row = mysqli_fetch_row($result)) {
					zapiszZmiany($row, $roles);
				}
				zapiszNowego(NULL);
				$query = NULL;
				break;
		}
		if (isset($query)) {
			$databaseHandler->query($query);
			echo QER();
		}
		echo "<div onclick='this.style.display=\"none\";' style='border: 2px solid red; color: red; font-weight: bold; background-color: yellow; padding: 5px; margin: 0px 0px 5px 0px;'>Action executed - " . date("Y-m-d H:i:s") . "</div>";
	}

	if (isset($_POST['page_id'])) {
		if (isset($_POST['root_id'])) {
			$query = " UPDATE prt_pages SET pge_pge_id = " . $_POST['root_id'] . " WHERE pge_id = " . $_POST['page_id'];
		} else {
			$query = " UPDATE prt_pages SET pge_pge_id = NULL WHERE pge_id = " . $_POST['page_id'];
		}
		$databaseHandler->query($query);
		echo QER();
	}
		
	function renderPage($pageId = NULL, $level = 0, $templates, $roles) {
		global $databaseHandler;
		$query = "
SELECT 
  pge_id, pge_title, pge_alias, pge_default, pge_tmp_id
FROM 
  prt_pages
WHERE 
  pge_pge_id " . (isset($pageId) ? " = {$pageId} " : " IS NULL ") . "
  AND pge_prt_id = {$_GET['prtId']} 
ORDER BY 
  pge_order
";
		$result = $databaseHandler->query($query);
		if ($result) {
?>
		<ul class="tree" style="margin: 0px 0px 0px <?php echo $level * 15 ?>px">
<?php
			while($row = mysqli_fetch_row($result)) {
?>
			<li>
				<input type="checkbox" name="delete_<?php echo $row[0] ?>"/>
				<input type="radio" name="root_id" value="<?php echo $row[0] ?>"/>
				<input type="text" name="title_<?php echo $row[0] ?>" value="<?php echo $row[1] ?>" onchange="document.getElementById('alias_<?php echo $row[0] ?>').value=slugMe(this.value);"/>
				<input type="text" name="alias_<?php echo $row[0] ?>" id="alias_<?php echo $row[0] ?>" value="<?php echo $row[2] ?>"/>
				<input type="submit" title="Move under selected" value="^" onclick="this.form.page_id.value='<?php echo $row[0] ?>';"/>
				<input type="checkbox" name="default_<?php echo $row[0] ?>" <?php echo $row[3] == 1 ? " checked='checked' " : "" ?>/>
				<select name="tmp_id_<?php echo $row[0] ?>">
					<option value=""></option>
<?php
				foreach ($templates as $id => $name) {
?>				
					<option value="<?php echo $id ?>" <?php echo $id == $row[4] ? " selected='selected' " : "" ?>><?php echo $name ?></option>	
<?php
				}
?>					
				</select>
<?php
				foreach ($roles as $id => $name) {
?>
					<div class="perm">
						<table class="perm" cellpadding="0" cellspacing="0">
							<tr>
								<td colspan="3">
									<?php echo $name ?>
								</td>
							</tr>
							<tr>
								<td>view</td>
								<td class="<?php echo perm($id, $row[0], 'view', NULL) ? 'neutral' : '' ?>"><input type="radio" name="view_<?php echo $id ?>_<?php echo $row[0] ?>" value="NULL" <?php echo perm($id, $row[0], 'view', NULL) ? " checked='checked' " : "" ?>/></td>
								<td class="<?php echo perm($id, $row[0], 'view', 1) ? 'allowed' : '' ?>"><input type="radio" name="view_<?php echo $id ?>_<?php echo $row[0] ?>" value="1" <?php echo perm($id, $row[0], 'view', 1) ? " checked='checked' " : "" ?>/></td>
								<td class="<?php echo perm($id, $row[0], 'view', 0) ? 'blocked' : '' ?>"><input type="radio" name="view_<?php echo $id ?>_<?php echo $row[0] ?>" value="0" <?php echo perm($id, $row[0], 'view', 0) ? " checked='checked' " : "" ?>/></td>
							</tr>
							<tr>
								<td>edit</td>
								<td class="<?php echo perm($id, $row[0], 'edit', NULL) ? 'neutral' : '' ?>"><input type="radio" name="edit_<?php echo $id ?>_<?php echo $row[0] ?>" value="NULL" <?php echo perm($id, $row[0], 'edit', NULL) ? " checked='checked' " : "" ?>/></td>
								<td class="<?php echo perm($id, $row[0], 'edit', 1) ? 'allowed' : '' ?>"><input type="radio" name="edit_<?php echo $id ?>_<?php echo $row[0] ?>" value="1" <?php echo perm($id, $row[0], 'edit', 1) ? " checked='checked' " : "" ?>/></td>
								<td class="<?php echo perm($id, $row[0], 'edit', 0) ? 'blocked' : '' ?>"><input type="radio" name="edit_<?php echo $id ?>_<?php echo $row[0] ?>" value="0" <?php echo perm($id, $row[0], 'edit', 0) ? " checked='checked' " : "" ?>/></td>
							</tr>
						</table>
					</div>
<?php
				}
?>				
			</li>
<?php
				renderPage($row[0], (isset($level) ? $level + 1 : 1 ), $templates, $roles);
			}
?>
			<li>
				<input class="newPage" type="text" name="new_title_<?php echo $pageId ?>" value="<?php echo $_POST['new_title_' . $pageId] ?>" onchange="document.getElementById('new_alias_<?php echo $pageId ?>').value=slugMe(this.value);"/>
				<input class="newPage" type="text" name="new_alias_<?php echo $pageId ?>" id="new_alias_<?php echo $pageId ?>" value="<?php echo $_POST['new_alias_' . $pageId] ?>"/>
<?php /*				<input class="newPage" type="checkbox" name="new_default_<?php echo $pageId ?>" <?php echo $_POST['new_default_' . $pageId] == "on" ? " checked='checked' " : "" ?>/> */ ?>
				<select class="newPage" name="new_tmp_id_<?php echo $pageId ?>">
					<option value=""></option>
<?php
				foreach ($templates as $id => $name) {
?>				
					<option value="<?php echo $id ?>" <?php echo $id == $_POST['new_tmp_id_' . $pageId] ? " selected='selected' " : "" ?>><?php echo $name ?></option>	
<?php
				}
?>					
				</select>
			</li>
		</ul>
<?php		
			mysqli_free_result($result);
		}
	}
	
	renderPage(null, 0, $templates, $roles);
?>
	<input type="hidden" value="pages" name="action"/>
	<input type="hidden" value="" name="page_id"/>
	<input type="submit" value="Store" onclick="document.body.style.cursor = 'wait';"/>
</form>
	</body>
</html>


