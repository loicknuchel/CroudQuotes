<?php
function apiGetQuoteList(&$usr, $params, $server_path, $order){
	$rel = isset($server_path) ? $server_path : '../../../';
	include_once $rel.'services/get.php';
	include_once $rel.'utils/json.php';
	include_once $rel.'utils/secureVars.php';
	include_once 'utils/extra_data.php';
	
	saveExtraDatas($usr, $params);
	$p = safe_int(isset($params["p"]) ? $params["p"] : '1');
	$selections = isset($params["selections"]) ? $params["selections"] : null;
	if($order == 'category'){$cat = safe_string(isset($params["cat"]) ? $params["cat"] : null);}
	else if($order == 'selection'){$sel = safe_string(isset($params["sel"]) ? $params["sel"] : null);}
	
	if($order == 'top' || $order == 'topcomment' || $order == 'lastactivity'  || $order == 'lasts'){$pages = getTotalPages($usr);}
	else if($order == 'category'){$pages = getCategoryTotalPages($usr, $cat);}
	else if($order == 'selection'){$pages = getSelectionTotalPages($usr, $sel);}
	if($p == null){$p = '1'; }
	else if($p > $pages){$p = $pages;}
	
	if($order == 'top'){$quoteList_result = getTopQuotes($usr, $p);}
	else if($order == 'topcomment'){$quoteList_result = getTopCommentQuotes($usr, $p);}
	else if($order == 'lasts'){$quoteList_result = getLastsQuotes($usr, $p);}
	else if($order == 'lastactivity'){$quoteList_result = getLastActivityQuotes($usr, $p);}
	else if($order == 'category'){$quoteList_result = getCategoryQuotes($usr, $cat, $p);}
	else if($order == 'selection'){$quoteList_result = getSelectionQuotes($usr, $sel, $p);}
	else{$quoteList_result = null;}
	
	if($quoteList_result != null){
		if($order == 'category'){
			if(is_numeric($cat)){ $cat_id = $cat; $cat = getCategoryName($usr, $cat_id); }
			else{ $cat_id = getCategoryId($usr, $cat); }
			return createListQuoteJson($usr, $quoteList_result, $p, $pages, Array('selections'=>($selections == 1)), ',"category_id":'.$cat_id.',"category_name":"'.$cat.'"');
		}
		else if($order == 'selection'){
			if(is_numeric($sel)){ $sel_id = $sel; $sel = getSelectionName($usr, $sel_id); }
			else{ $sel_id = getSelectionId($usr, $sel); }
			return createListQuoteJson($usr, $quoteList_result, $p, $pages, Array('selections'=>($selections == 1)), ',"selection_id":'.$sel_id.',"selection_name":"'.$sel.'"');
		}
		else{
			return createListQuoteJson($usr, $quoteList_result, $p, $pages, Array('selections'=>($selections == 1)));
		}
	} else{ return createErrorJson($usr, 404); } // pas de résultats
}

// API : quote_list.php:GET?key={key}&list=top[&p={no_quote_page}]
function apiGetQuoteListByTop(&$usr, $params, $server_path){
	return apiGetQuoteList($usr, $params, $server_path, 'top');
}

// API : quote_list.php:GET?key={key}&list=topcomment[&p={no_quote_page}]
function apiGetQuoteListByTopComment(&$usr, $params, $server_path){
	return apiGetQuoteList($usr, $params, $server_path, 'topcomment');
}

// API : quote_list.php:GET?key={key}&list=lastcomment[&p={no_quote_page}]
function apiGetQuoteListByLastComment(&$usr, $params, $server_path){
	return apiGetQuoteList($usr, $params, $server_path, 'lastactivity');
}

// API : quote_list.php:GET?key={key}&list=lasts[&p={no_quote_page}]
function apiGetQuoteListByLasts(&$usr, $params, $server_path){
	return apiGetQuoteList($usr, $params, $server_path, 'lasts');
}

// API : quote_list.php:GET?key={key}&list=category&cat={category_id|category_name}[&p={no_quote_page}]
function apiGetQuoteListByCategory(&$usr, $params, $server_path){
	return apiGetQuoteList($usr, $params, $server_path, 'category');
}

// API : quote_list.php:GET?key={key}&list=selection&sel={selection_id|selection_name}[&p={no_quote_page}]
function apiGetQuoteListBySelection($usr, $params, $server_path){
	return apiGetQuoteList($usr, $params, $server_path, 'selection');
}

// API : quote_list.php:GET?key={key}&list=custom&quoteids={id1/id2/id3}
function apiGetQuoteListByCustom(&$usr, $params, $server_path){
	$rel = isset($server_path) ? $server_path : '../../../';
	include_once $rel.'services/get.php';
	include_once $rel.'utils/json.php';
	include_once $rel.'utils/secureVars.php';
	
	$usr['noheaders'] = safe_int(isset($params["noheaders"]) ? $params["noheaders"] : null);
	$quoteids = safe_string(isset($params["quoteids"]) ? $params["quoteids"] : null);
	$selections = isset($params["selections"]) ? $params["selections"] : null;
	
	$ind = 0;
	$tabid = null;
	foreach(explode('/', $quoteids) as $key => $value){
		if(is_numeric($value)){
			$tabid[$ind] = safe_int($value);
			$ind++;
		}
	}
	
	$quoteList_result = getCustomQuoteList($usr, $tabid);
	if($quoteList_result != null){
		return createListQuoteJson($usr, $quoteList_result, '1', '1', Array('selections'=>($selections == 1)));
	} else{ return createErrorJson($usr, 404); } // pas de résultats
}

// API : quote_list.php:GET?key={key}&list=author&auth={author_name}[&p={no_quote_page}]
// TODO : gérer un id author ?
function apiGetQuoteListByAuthor(&$usr, $params, $server_path){
	$rel = isset($server_path) ? $server_path : '../../../';
	include_once $rel.'services/get.php';
	include_once $rel.'utils/json.php';
	include_once $rel.'utils/secureVars.php';
	
	$usr['noheaders'] = safe_int(isset($params["noheaders"]) ? $params["noheaders"] : null);
	$auth = safe_string(isset($params["auth"]) ? $params["auth"] : null);
	$p = safe_int(isset($params["p"]) ? $params["p"] : '1');
	$selections = isset($params["selections"]) ? $params["selections"] : null;
	
	$pages = getAuthorTotalPages($usr, $auth);
	if($p == null){$p = '1'; }
	else if($p > $pages){$p = $pages;}
	
	$quoteList_result = getAuthorQuotes($usr, $auth, $p);
	if($quoteList_result != null){
		return createListQuoteJson($usr, $quoteList_result, $p, $pages, Array('selections'=>($selections == 1)));
	} else{ return createErrorJson($usr, 404); } // pas de résultats
}
?>