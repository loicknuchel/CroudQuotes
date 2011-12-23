<?php

function apiNewSelection(&$usr, $params, $server_path){
	$rel = isset($server_path) ? $server_path : '../../../';
	include_once $rel.'globals/env.php';
	include_once $rel.'services/get.php';
	include_once $rel.'services/post.php';
	include_once $rel.'utils/json.php';
	include_once $rel.'utils/secureVars.php';
	include_once 'utils/extra_data.php';
	
	$env = setEnv();
	
	saveExtraDatas($usr, $params);
	$quoteids = safe_string(isset($params["quoteids"]) ? $params["quoteids"] : null);
	$sel = string_max_lenght( safe_string(isset($params["sel"]) ? $params["sel"] : null), $env['selectionMaxSize'] );
	$pass = safe_string(isset($params["pass"]) ? $params["pass"] : null);
	
	$tabquoteids = idsToTab($quoteids);
	
	if($sel == null || $sel == ''){
		$sel_id = null;
		$newid = getSelectionLastId($usr) + 1;
		$sel = "selection_".$newid;
	}
	else{
		$sel_id = getSelectionId($usr, $sel);
	}
	
	if($tabquoteids != null && $sel_id == null && postSelection($usr, $sel, $pass, $sel_id) == 200){
		$ret = postSelectionQuotes($usr, $tabquoteids, $sel_id);
		if($ret == 200){
			return createPostSelectionJson($usr, $sel_id, $sel);
		}
		else{
			return createErrorJson($usr, $ret);
		}
	} else{ return createErrorJson($usr, 400); } // paramètres incorrects
}

function apiAddToSelection(&$usr, $params, $server_path){
	$rel = isset($server_path) ? $server_path : '../../../';
	include_once $rel.'globals/env.php';
	include_once $rel.'services/get.php';
	include_once $rel.'services/post.php';
	include_once $rel.'utils/json.php';
	include_once $rel.'utils/secureVars.php';
	include_once 'utils/extra_data.php';
	
	$env = setEnv();
	
	saveExtraDatas($usr, $params);
	$sel = string_max_lenght( safe_string(isset($params["sel"]) ? $params["sel"] : null), $env['selectionMaxSize'] );
	$addids = safe_string(isset($params["addids"]) ? $params["addids"] : null);
	$pass = safe_string(isset($params["pass"]) ? $params["pass"] : null);
	
	$tabquoteids = idsToTab($addids);
	if(is_numeric($sel)) {
		$sel_id = safe_int($sel);
	} else {
		$sel_id = getSelectionId($usr, $sel);
	}
	
	if($sel_id != null && $tabquoteids != null && $pass != null){
		$ret = postAddToSelection($usr, $sel_id, $tabquoteids,$pass);
		return createErrorJson($usr, $ret);
	} else{ return createErrorJson($usr, 400); } // paramètres incorrects
}

function apiRemToSelection(&$usr, $params, $server_path){
	$rel = isset($server_path) ? $server_path : '../../../';
	include_once $rel.'globals/env.php';
	include_once $rel.'services/get.php';
	include_once $rel.'services/post.php';
	include_once $rel.'utils/json.php';
	include_once $rel.'utils/secureVars.php';
	include_once 'utils/extra_data.php';
	
	$env = setEnv();
	
	saveExtraDatas($usr, $params);
	$sel = string_max_lenght( safe_string(isset($params["sel"]) ? $params["sel"] : null), $env['selectionMaxSize'] );
	$remids = safe_int(isset($params["remids"]) ? $params["remids"] : null);
	$pass = safe_string(isset($params["pass"]) ? $params["pass"] : null);
	
	$tabquoteids = idsToTab($remids);
	if(is_numeric($sel)) {
		$sel_id = safe_int($sel);
	} else {
		$sel_id = getSelectionId($usr, $sel);
	}
	
	if($sel_id != null && $tabquoteids != null && $pass != null){
		$ret = postRemToSelection($usr, $sel_id, $tabquoteids, $pass);
		return createErrorJson($usr, $ret);
	} else{ return createErrorJson($usr, 400); } // paramètres incorrects
}

// private
function idsToTab($quoteids){
	$ind = 0;
	$tabquoteids = null;
	foreach(explode('/', $quoteids) as $key => $value){
		if(is_numeric($value)){
			$tabquoteids[$ind] = safe_int($value);
			$ind++;
		}
	}
	
	return $tabquoteids;
}
?>