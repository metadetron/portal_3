<?php
	class DatabaseLogHandler {
		function write($logLevel, $message, $details) {
			$logStackTrace = false;
			portal\virgoSystemMessage::storeInDB($logLevel->getId(), QE($message), QE($details), $logLevel->getLogStackTrace() == 1);
		}
	}
?>
