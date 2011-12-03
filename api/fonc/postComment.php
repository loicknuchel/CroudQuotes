<?php
// API : comment.php:POST?key={key}&quoteid={quoteid}&pub={publisher}&comment={comment}[&mail={mail}][&site={site}]
function apiNewComment(&$usr, $params, $server_path){
	$rel = isset($server_path) ? $server_path : '../../../';
	include_once $rel.'globals/env.php';
	include_once $rel.'globals/conventions.php';
	include_once $rel.'services/post.php';
	include_once $rel.'utils/json.php';
	include_once $rel.'utils/secureVars.php';
	include_once 'utils/extra_data.php';
	
	$env = setEnv();
	
	saveExtraDatas($usr, $params);
	$quoteid = safe_int(isset($params["quoteid"]) ? $params["quoteid"] : null);
	if($quoteid == null){
		$type = (isset($params["type"]) && isRessourceType($params["type"]))? $params["type"] : null;
		$id = safe_int(isset($params["id"]) ? $params["id"] : null);
	}
	else{$type = 'quote'; $id = $quoteid;}
	$publisher  = string_max_lenght( safe_string(isset($params["pub"])     ? $params["pub"]     : null), $env['publisherMaxSize']);
	$comment    = string_max_lenght( safe_string(isset($params["comment"]) ? $params["comment"] : null), $env['commentMaxSize']  );
	$mail       = string_max_lenght( safe_string(isset($params["mail"])    ? $params["mail"]    : null), $env['mailMaxSize']     );
	$site       = string_max_lenght( safe_string(isset($params["site"])    ? $params["site"]    : null), $env['siteMaxSize']     );
	$i_avis     = avisToCode(isset($params["avis"]) ? $params["avis"] : null);
	
	if($type != null && $id != null && $publisher != null && $comment != null){
		$ret = postComment($usr, $type, $id, $i_avis, $publisher, $mail, $site, $comment, $commentid);
		if($ret == 200){
			return createInsertSuccessJson($usr, $commentid);
		} else{ return createErrorJson($usr, $ret); }
	} else{ return createErrorJson($usr, 400); } // paramètres incorrects
}
?>