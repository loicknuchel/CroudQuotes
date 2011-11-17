<?phpfunction apiUpdateSuivi(&$usr, $params, $server_path){	$rel = isset($server_path) ? $server_path : '../../../';	include_once $rel.'globals/env.php';	include_once $rel.'globals/conventions.php';	include_once $rel.'services/post.php';	include_once $rel.'utils/json.php';	include_once $rel.'utils/secureVars.php';	include_once 'utils/extra_data.php';		$env = setEnv();		saveExtraDatas($usr, $params);	$mail = string_max_lenght( safe_string(isset($params["mail"]) ? $params["mail"] : null), $env['mailMaxSize'] );	$type = safe_string(isset($params["type"]) ? $params["type"] : null);	$id = safe_int(isset($params["id"]) ? $params["id"] : null);		$actions = null;	$actions['action'] = isset($params["action"]) ? $params["action"] : null;		if($mail != null && isRessourceType($type) && $id != null && isAction($actions['action'])){		$ret = postSuivi($usr, $mail, $type, $id, $actions);		return createErrorJson($usr, $ret);	} else{ return createErrorJson($usr, 400); } // paramètres incorrects}?>