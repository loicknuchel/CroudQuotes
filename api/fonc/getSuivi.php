<?php// API : GET  suivi.php?key={key}&mail={mail}function apiGetSuivi(&$usr, $params, $server_path){	$rel = isset($server_path) ? $server_path : '../../../';	include_once $rel.'globals/env.php';	include_once $rel.'services/get.php';	include_once $rel.'utils/json.php';	include_once $rel.'utils/secureVars.php';	include_once 'utils/extra_data.php';		$env = setEnv();		saveExtraDatas($usr, $params);	$mail = string_max_lenght( safe_string(isset($params["mail"]) ? $params["mail"] : null), $env['mailMaxSize'] );		$suivi_result = getSuivi($usr, $mail);		if($suivi_result != null){		return createSuiviJson($usr, $mail, $suivi_result);	} else{ return createErrorJson($usr, 404); } // pas de résultats}?>