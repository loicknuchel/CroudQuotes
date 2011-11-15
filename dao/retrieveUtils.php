<?php
	
	function format_date($champ){
		return "DATE_FORMAT(".$champ.", '%d/%m/%Y|%H:%i:%s') as post_date, UNIX_TIMESTAMP(".$champ.") as post_timestamp";
	}
	
	function getSingleData($usr, $req, $name, $dbConnexion = 1){
		if($dbConnexion == 1){dbConnect();}
		
		$res = query($req, $usr);
		if($res == null || mysql_num_rows($res) == 0){
			$data = null;
		}
		else{
			$ret = mysql_fetch_array($res, MYSQL_ASSOC);
			$data = $ret[$name];
		}
		
		unset($req);
		unset($res);
		unset($ret);
		if($dbConnexion == 1){dbDisconnect();}
		return $data;
	}
	
	function getUniqueDataRow($req, $usr){
		dbConnect();
		
		$res = query($req, $usr);
		if($res == null || mysql_num_rows($res) == 0){
			$ret = null;
		}
		else{
			$ret = mysql_fetch_array($res, MYSQL_ASSOC);
		}
		
		unset($req);
		dbDisconnect();
		return $ret;
	}
	
	function getMultipleDataRows($req, $usr){
		dbConnect();
		
		$res = query($req, $usr);
		if($res == null || mysql_num_rows($res) == 0){
			$res = null;
		}
		
		unset($req);
		dbDisconnect();
		return $res;
	}
	
	function retrieveCountPages($usr, $req, $page_size){
		$env = setEnv();
		dbConnect();
		
		$res = query($req, $usr);
		$ret = mysql_fetch_array($res, MYSQL_ASSOC);
		$tmp = $ret['pages'] / $page_size;
		$pages = ceil($tmp);
		if($pages == 0){$pages = 1;}
		
		unset($req);
		dbDisconnect();
		return $pages;
	}
?>