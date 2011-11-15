<?php
// API : selection.php:POST?key={key}&quoteids={id1/id2/id3...}[&sel={selection_name}]
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
	$sel = string_max_lenght( safe_string(isset($params["sel"]) ? $params["sel"] : null), $env['selectionMaxSize'] );
	$quoteids = safe_string(isset($params["quoteids"]) ? $params["quoteids"] : null);
	
	$ind = 0;
	$tabquoteids = null;
	foreach(explode('/', $quoteids) as $key => $value){
		if(is_numeric($value)){
			$tabquoteids[$ind] = safe_int($value);
			$ind++;
		}
	}
	
	if($sel == null || $sel == ''){
		$sel_id = null;
		$newid = getSelectionLastId($usr) + 1;
		$sel = "selection_".$newid;
	}
	else{
		$sel_id = getSelectionId($usr, $sel);
	}
	
	if($ind != 0 && $sel_id == null && postSelection($usr, $sel, $sel_id) == 200){
		$ret = postSelectionQuotes($usr, $tabquoteids, $sel_id);
		if($ret == 200){
			return createPostSelectionJson($usr, $sel_id, $sel);
		}
		else{
			return createErrorJson($usr, $ret);
		}
	} else{ return createErrorJson($usr, 400); } // paramètres incorrects
}
?>