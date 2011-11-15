<?php
// API : category.php:POST?key={key}&cat={category_name}
function apiNewCategory(&$usr, $params, $server_path){
	$rel = isset($server_path) ? $server_path : '../../../';
	include_once $rel.'globals/env.php';
	include_once $rel.'services/post.php';
	include_once $rel.'utils/json.php';
	include_once $rel.'utils/secureVars.php';
	include_once 'utils/extra_data.php';
	
	$env = setEnv();
	
	saveExtraDatas($usr, $params);
	$name = string_max_lenght( safe_string(isset($params["cat"]) ? $params["cat"] : null), $env['categoryMaxSize'] );
	
	if($name != null){
		$ret = postCategory($usr, $name, $categoryid);
		if($ret == 200){
			return createInsertSuccessJson($usr, $categoryid);
		} else{ return createErrorJson($usr, $ret); }
	} else{ return createErrorJson($usr, 400); } // paramètres incorrects
}


// API : quote.php:POST?key={key}&quoteid={quoteid}&cat={category_id|category_name}
function apiNewCategoryForQuote(&$usr, $params, $server_path){
	$rel = isset($server_path) ? $server_path : '../../../';
	include_once $rel.'globals/env.php';
	include_once $rel.'services/post.php';
	include_once $rel.'utils/json.php';
	include_once $rel.'utils/secureVars.php';
	
	$env = setEnv();
	
	$usr['noheaders'] = safe_int(isset($params["noheaders"]) ? $params["noheaders"] : null);
	$quoteid = safe_int(isset($params["quoteid"]) ? $params["quoteid"] : null);
	$cat = string_max_lenght( safe_string(isset($params["cat"]) ? $params["cat"] : null), $env['categoryMaxSize'] );
	
	if($quoteid != null && $cat != null){
		$ret = postQuoteCategory($usr, $quoteid, $cat, 1, $newcategoryid);
		if($ret == 200){
			$newcategoryname = getCategoryName($usr, $newcategoryid);
			return createPostCategoryJson($usr, $newcategoryid, $newcategoryname);
		}
		else{
			return createErrorJson($usr, $ret);
		}
	} else{ return createErrorJson($usr, 400); } // paramètres incorrects
}
?>