<?phpfunction apiGetMailSuivi(&$usr, $params, $server_path){	$rel = isset($server_path) ? $server_path : '../../../';	include_once $rel.'globals/env.php';	include_once $rel.'services/get.php';	include_once $rel.'utils/json.php';	include_once $rel.'utils/secureVars.php';	include_once 'utils/extra_data.php';		$env = setEnv();		saveExtraDatas($usr, $params);	$mail = string_max_lenght( safe_string(isset($params["mail"]) ? $params["mail"] : null), $env['mailMaxSize'] );		$suivi_result = getMailSuivi($usr, $mail);		if($suivi_result != null){		return createMailSuiviJson($usr, $mail, $suivi_result);	} else{ return createErrorJson($usr, 404); } // pas de résultats}function apiGetRessourceSuivi(&$usr, $params, $server_path){	$rel = isset($server_path) ? $server_path : '../../../';	include_once $rel.'globals/env.php';	include_once $rel.'services/get.php';	include_once $rel.'utils/json.php';	include_once $rel.'utils/secureVars.php';	include_once 'utils/extra_data.php';		$env = setEnv();		saveExtraDatas($usr, $params);	$elt_type = safe_string(isset($params["type"]) ? $params["type"] : null);	$elt_id = safe_int(isset($params["id"]) ? $params["id"] : null);		$suivi_result = getRessourceSuivi($usr, $elt_type, $elt_id);		if($suivi_result != null){		return createSuiviForRessourceJson($usr, $elt_type, $elt_id, $suivi_result);	} else{ return createErrorJson($usr, 404); } // pas de résultats}?>