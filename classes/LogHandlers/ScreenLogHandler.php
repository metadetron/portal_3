<?php
	class ScreenLogHandler {
		function write($logLevel, $message, $details) {
			$newMsg = array($logLevel->getName(), $message, $details);
			$this->addToQueue($newMsg);
		}
		
		function getSuffix() {
			if (isset($_SESSION['current_portlet_object_id'])) {
				return "_" . $_SESSION['current_portlet_object_id'];
			}
			return "";
		}
		
		function getQueue() {
			$queue = null;
			$suffix = $this->getSuffix();
			if (isset($_SESSION['current_portlet_object_id'])) {
				$suffix = "_" . $_SESSION['current_portlet_object_id'];
			}
			if (isset($_SESSION['virgo_msg_queue' . $suffix])) {
				$queue = $_SESSION['virgo_msg_queue' . $suffix];
			} else {
				$queue = array();
			}
			return $queue;
		}
		
		function storeQueue($queue) {
			$suffix = $this->getSuffix();
			$_SESSION['virgo_msg_queue' . $suffix] = $queue;
		}
		
		function addToQueue($newMsg) {
			$queue = $this->getQueue();
			$queue[] = $newMsg;
			$this->storeQueue($queue);
		}
	}
?>
