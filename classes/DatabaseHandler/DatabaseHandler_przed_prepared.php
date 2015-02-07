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
		
		function query($query, $script = true) {
/*			if ($script) {
				if (strtoupper(substr(trim($query), 0, 6)) != "SELECT") {
					$myFile = "db_changes_script.sql";
					$fh = fopen($myFile, 'a') or die("can't open file");
					fwrite($fh, $query . ";\n");
					fclose($fh);
				}
			} */
			if (isset($_REQUEST['profiler'])) {
				$startTime = microtime(true);
    			$ret = mysqli_query($this->resource, $query);
				if (isset($_REQUEST['profiler'][$query])) {
					$queryExecutionTime = $_REQUEST['profiler'][$query];
				} else {
					$queryExecutionTime = 0;
				}
				$_REQUEST['profiler'][$query] = $queryExecutionTime + (microtime(true) - ($startTime));
			} else {
				$pos = strrpos($query, "'");
				if ($pos === false) { 
				    $ret = mysqli_query($this->resource, $query);
				} else {
				//  ERROR("Incompatible query. Please contact site administrator");
//V($query); exit;
//M('contact@metadetron.com', 'error', $query);
$ret = mysqli_query($this->resource, $query);
	    			//return false;
				}
			}
			$_REQUEST['SQL_ERROR'] = mysqli_error($this->resource);
			return $ret;
		}
		
		function queryPrepared($query, $script = false, $types = null, $values = array()) {			
			$pos = strrpos($query, "'");
			if ($pos === false) { 
				if ($stmt = $this->resource->prepare($query)) {
					if (count($values) > 0) {
						$params = array_merge(array($types), $values);
						if (call_user_func_array(array($stmt, 'bind_param'), $params) === false) {
							// TODO
						}
					}
					$stmt->execute();
					$_REQUEST['SQL_ERROR'] = $stmt->error;
					$meta = $stmt->result_metadata();
					$fields = $results = array();
					while ($field = $meta->fetch_field()) { 
						$var = $field->name; 
						$$var = null; 
						$fields[$var] = &$$var; 
					}
					call_user_func_array(array($stmt,'bind_result'),$fields);
					while ($stmt->fetch()) { 
						$results[] = $fields;
					}
					$stmt->close();
					return $results;
				} else {
					$_REQUEST['SQL_ERROR'] = "Prepare returned false.";
					return false;
				}		
			} else {
				// ???
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
