<?php
	class FileLogHandler {
		function write($logLevel, $message, $details) {
			I('SystemMessage');
			$myFile = "application.log";
			$fh = fopen($myFile, 'a') or die("can't open file");
			$ip = virgoSystemMessage::getRealIp();
			$url = virgoSystemMessage::getRealUrl();
			$user = virgoUser::getUser();
			fwrite($fh, date("Y-m-d H:i:s") . " [" . $user->getUsername() . " (" . $ip . ") " . $url . "]: " . $message . "\n");
			if (isset($details)) {
				fwrite($fh, $details);
			}
			fclose($fh);
		}
	}
?>
