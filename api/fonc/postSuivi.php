<?php// API : POST suivi.php?key={key}&mail={mail}&quoteid={quoteid}&newcomments={1|0}function apiUpdateSuivi(&$usr, $params, $server_path){	$rel = isset($server_path) ? $server_path : '../../../';	include_once $rel.'globals/env.php';	include_once $rel.'services/post.php';	include_once $rel.'utils/json.php';	include_once $rel.'utils/secureVars.php';	include_once 'utils/extra_data.php';		$env = setEnv();		saveExtraDatas($usr, $params);	$mail = string_max_lenght( safe_string(isset($params["mail"]) ? $params["mail"] : null), $env['mailMaxSize'] );	$quoteid = safe_int(isset($params["quoteid"]) ? $params["quoteid"] : null);		$actions = null;	$actions['newcomments'] = isset($params["newcomments"]) ? $params["newcomments"] : null;		if($mail != null && $quoteid != null && ($actions['newcomments'] == 0 || $actions['newcomments'] == 1)){		$ret = postSuivi($usr, $mail, $quoteid, $actions);		return createErrorJson($usr, $ret);	} else{ return createErrorJson($usr, 400); } // paramètres incorrects}?>