<?php
	class Api {	
		public function get_status($who, $what){
			$ret = array("who" => $who, "what" => $what);
			return json_encode($ret);
		
		}
		public function set_status($who, $what){
			$ret = array("who" => $who, "what" => $what);
			return json_encode($ret);
		}
	}
?>