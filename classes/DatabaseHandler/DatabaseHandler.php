<?php
	class DatabaseHandler {
			
		var $resource = null;
		
		function getDatabaseHost() {
			global $virgoConfig;
			if (isset($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_host'])) {
				return $virgoConfig[VIRGO_PORTAL_INSTANCE]['database_host'];
			} else {
				return 'localhost';
			}
		}
		
		function getDatabasePort() {
			global $virgoConfig;
			if (isset($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_port'])) {
				return $virgoConfig[VIRGO_PORTAL_INSTANCE]['database_port'];
			} else {
				return null;
			}
		}
		
		function getDatabaseUser() {
			global $virgoConfig;
			return $virgoConfig[VIRGO_PORTAL_INSTANCE]['database_user'];
		}

		function getDatabasePassword() {
			global $virgoConfig;
			return $virgoConfig[VIRGO_PORTAL_INSTANCE]['database_password'];
		}
		
		function getDatabaseName() {
			global $virgoConfig;
			return $virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'];
		}
		
		function __construct() {
			$this->resource = mysqli_connect($this->getDatabaseHost(), $this->getDatabaseUser(), $this->getDatabasePassword(), $this->getDatabaseName(), $this->getDatabasePort());
			if (!$this->resource) {
				die("Can't connect to database: " . mysqli_error($this->resource));
			}
			mysqli_query($this->resource, "SET NAMES 'utf8'");
		}

		function isSafe($query) {
			$pos = strrpos($query, "'");
			if ($pos === false) { 			
				if (strrpos($query, '"') === false) {
					return true;
				}
			}
			echo "Nie wykonam tego zapytania!"; 
			echo "<pre>";
			var_dump(debug_backtrace(false));
			echo "</pre>";			
			return false;
		}
		
		function query($query, $script = true) {
/*			if ($script) {
				if (strtoupper(substr(trim($query), 0, 6)) != "SELECT") {
					$myFile = "db_changes_script.sql";
					$fh = fopen($myFile, 'a') or die("can't open file");
					fwrite($fh, $query . ";\n");
					fclose($fh);
				}
			} */
			if ($this->isSafe($query)) { 
				PROFILE($query);
			    $ret = mysqli_query($this->resource, $query);
				PROFILE($query);
				$_REQUEST['SQL_ERROR'] = mysqli_error($this->resource);
				return $ret;
			}
		}
		
		function queryPrepared($query, $script = false, $types = null, $values = array()) {			
			if ($script) {
				echo "<code>".$query."</code>";
			}
			if ($this->isSafe($query)) { 
				if ($stmt = $this->resource->prepare($query)) {
					if (count($values) > 0) {
						/////////////////////////////////
						// to byc moze dziala na laptopie ale do usuniecia na serwerze :-/
						$tmp = array();
	        			foreach($values as $key => $value) $tmp[$key] = &$values[$key];					
						$params = array_merge(array($types), $tmp);
						/////////////////////////////////
						//$params = array_merge(array($types), $values);
						if (call_user_func_array(array($stmt, 'bind_param'), $params) === false) {
//echo $query; echo "<br>"; echo $types;V($values);
							// TODO
						}
					}
					PROFILE($query);
					$ret = $stmt->execute();
					PROFILE($query);
					$_REQUEST['SQL_ERROR'] = $stmt->error;
					$meta = $stmt->result_metadata();
					if ($script) {
						V($meta);
					}
					if ($meta !== false) {
						$fields = $results = array();
						while ($field = $meta->fetch_field()) { 
							$var = $field->name; 
							$$var = null; 
							$fields[$var] = &$$var; 
						}
						call_user_func_array(array($stmt,'bind_result'),$fields);
						while ($stmt->fetch()) { 
							$fieldsValues = array();
							foreach ($fields as $key => $value) {
								$fieldsValues[$key] = $value;
							}
							$results[] = $fieldsValues;
						}
						$stmt->close();
						if ($script) {
							V($results);
						}
						return $results;
					}
					$stmt->close();
					return $ret;
				} else {
					$_REQUEST['SQL_ERROR'] = "Prepare returned false. " . $this->resource->error;
					return false;
				}		
			}
		}		

		function begin() {
			mysqli_autocommit($this->resource, false);
		}
		
		function commit() {
			mysqli_commit($this->resource);  
		}

		function rollback() {
			mysqli_rollback($this->resource);   
		}
		
		function escape($string) {
			return mysqli_real_escape_string($this->resource, $string);
		}
		
		function lastId() {
			return mysqli_insert_id($this->resource);
		}
		
		function error() {
			return $_REQUEST['SQL_ERROR'];
		}
		
		function backup($tableNames, $fileName) {
			$command = "mysqldump --user={$this->getDatabaseUser()} --password={$this->getDatabasePassword()} --host={$this->getDatabaseHost()} --result-file={$fileName} --compress --tables {$this->getDatabaseName()} {$tableNames}";
			return shell_exec($command);
		}
		
		function restore($fileName) {
			$command = "mysql --user={$this->getDatabaseUser()} --password={$this->getDatabasePassword()} --host={$this->getDatabaseHost()} {$this->getDatabaseName()} --execute=\"SOURCE {$fileName}\"";
			return shell_exec($command);
		}

	}
?>
