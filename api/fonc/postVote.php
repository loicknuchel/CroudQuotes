<?php
// API : quote.php:POST?key={key}&quoteid={quoteid}&vote={'up'|'down'}
function apiQuoteVote(&$usr, $params, $server_path){
	return apiVote($usr, $params, $server_path, 'quote');
}

// API : comment.php:POST?key={key}&commentid={commentid}&vote={'up'|'down'}
function apiCommentVote(&$usr, $params, $server_path){
	return apiVote($usr, $params, $server_path, 'comment');
}

// private
function apiVote(&$usr, $params, $server_path, $type){
	$rel = isset($server_path) ? $server_path : '../../../';
	include_once $rel.'services/post.php';
	include_once $rel.'utils/secureVars.php';
	include_once 'utils/extra_data.php';
	
	saveExtraDatas($usr, $params);
	if($type == 'quote'){$id = safe_int(isset($params["quoteid"]) ? $params["quoteid"] : null);}
	else if($type == 'comment'){$id = safe_int(isset($params["commentid"]) ? $params["commentid"] : null);}
	else{return createErrorJson($usr, 400);}
	$vote = safe_string(isset($params["vote"]) ? $params["vote"] : null);
	
	if($id != null){
		if($type == 'quote' && $vote == "down"){ 		$ret = postQuoteDownVote($usr, $id); }
		else if($type == 'quote' && $vote == "up"){ 	$ret = postQuoteUpVote($usr, $id); }
		else if($type == 'comment' && $vote == "down"){ $ret = postCommentDownVote($usr, $id); }
		else if($type == 'comment' && $vote == "up"){ 	$ret = postCommentUpVote($usr, $id); }
		else{ $ret = 400; }
		
		return createErrorJson($usr, $ret);
	} else{ return createErrorJson($usr, 400); } // paramètres incorrects
}



?>