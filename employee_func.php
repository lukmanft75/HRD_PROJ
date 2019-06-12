<?php
	function get_valid_code($code){
		global $db;
		if($code != ""){
			$employee_id = $db->fetch_single_data("employees","id",["code" => $code]);
			if($employee_id > 0){
				$suffix = (substr($code,-2) * 1) + 1;
				$code = substr($code,0,-2).substr("00",0,2-strlen($suffix)).$suffix;
				return get_valid_code($code);
			} else {
				return $code;
			}
		} else{
			return "";
		}
	}
?>