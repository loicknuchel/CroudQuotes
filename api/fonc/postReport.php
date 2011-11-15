<?php
// API : quote.php:POST?key={key}&quoteid={quoteid}&report=1[&cause={cause}]
function apiQuoteReport(&$usr, $params, $server_path){
	return apiReport($usr, $params, $server_path, 'quote');
}

// API : comment.php:POST?key={key}&commentid={commentid}&report=1[&cause={cause}]
function apiCommentReport(&$usr, $params, $server_path){
	return apiReport($usr, $params, $server_path, 'comment');
}

// private
function apiReport(&$usr, $params, $server_path, $type){
	$rel = isset($server_path) ? $server_path : '../../../';
	include_once $rel.'services/post.php';
	include_once $rel.'utils/secureVars.php';
	include_once 'utils/extra_data.php';
	
	saveExtraDatas($usr, $params);
	if($type == 'comment'){$id = safe_int(isset($params["commentid"]) ? $params["commentid"] : null);}
	else if($type == 'quote'){$id = safe_int(isset($params["quoteid"]) ? $params["quoteid"] : null);}
	else{return createErrorJson($usr, 400);}
	$cause = safe_string(isset($params["cause"]) ? $params["cause"] : null);
	
	if($id != null){
		$deleted = 0;
		if($type == 'comment'){$ret = postCommentReport($usr, $id, $cause, $deleted);}
		else if($type == 'quote'){$ret = postQuoteReport($usr, $id, $cause, $deleted);}
		else{$ret = 400;}
		
		if($deleted == 1){$action = 'deleted';}
		else{$action = 'none';}
		
		return createErrorJson($usr, $ret, ',"response":{"action":"'.$action.'"}');
	} else{ return createErrorJson($usr, 400); } // paramètres incorrects
}

?>