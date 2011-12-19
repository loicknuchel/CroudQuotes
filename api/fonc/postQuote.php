<?php

function apiNewQuote(&$usr, $params, $server_path){
	$rel = isset($server_path) ? $server_path : '../../../';
	include_once $rel.'globals/env.php';
	include_once $rel.'services/post.php';
	include_once $rel.'utils/json.php';
	include_once $rel.'utils/secureVars.php';
	include_once 'utils/extra_data.php';
	
	$env = setEnv();
	
	saveExtraDatas($usr, $params);
	$quote   = string_max_lenght( safe_string(isset($params["quote"])   ? $params["quote"]   : null), $env['quoteMaxSize']         );
	$src     = string_max_lenght( safe_string(isset($params["src"])     ? $params["src"]     : null), $env['sourceMaxSize']        );
	$ctx     = string_max_lenght( safe_string(isset($params["ctx"])     ? $params["ctx"]     : null), $env['contextMaxSize']       );
	$expl    = string_max_lenght( safe_string(isset($params["expl"])    ? $params["expl"]    : null), $env['explanationMaxSize']   );
	$auth    = string_max_lenght( safe_string(isset($params["auth"])    ? $params["auth"]    : null), $env['authorMaxSize']        );
	$pub     = string_max_lenght( safe_string(isset($params["pub"])     ? $params["pub"]     : null), $env['publisherMaxSize']     );
	$pubinfo = string_max_lenght( safe_string(isset($params["pubinfo"]) ? $params["pubinfo"] : null), $env['publisherInfoMaxSize'] );
	$mail    = string_max_lenght( safe_string(isset($params["mail"])    ? $params["mail"]    : null), $env['mailMaxSize']          );
	$site    = string_max_lenght( safe_string(isset($params["site"])    ? $params["site"]    : null), $env['siteMaxSize']          );
	$cat     = string_max_lenght( safe_string(isset($params["cat"])     ? $params["cat"]     : null), $env['categoryMaxSize']      );
	
	if($quote != null){
		$ret = postQuote($usr, $quote, $src, $ctx, $expl, $auth, $pub, $pubinfo, $mail, $site, $cat, $quoteid);
		if($ret == 200){
			return createInsertSuccessJson($usr, $quoteid);
		}
		else{ return createErrorJson($usr, $ret); }
	} else{ return createErrorJson($usr, 400); } // paramètres incorrects
}


function apiRephraseQuote(&$usr, $params, $server_path){
	$rel = isset($server_path) ? $server_path : '../../../';
	include_once $rel.'globals/env.php';
	include_once $rel.'services/post.php';
	include_once $rel.'utils/json.php';
	include_once $rel.'utils/secureVars.php';
	include_once 'utils/extra_data.php';
	
	$env = setEnv();
	
	saveExtraDatas($usr, $params);
	$quoteid = safe_int(isset($params["quoteid"]) ? $params["quoteid"] : null);
	$quote   = string_max_lenght( safe_string(isset($params["quote"])   ? $params["quote"]   : null), $env['quoteMaxSize']         );
	$expl    = string_max_lenght( safe_string(isset($params["expl"])    ? $params["expl"]    : null), $env['explanationMaxSize']   );
	$pub     = string_max_lenght( safe_string(isset($params["pub"])     ? $params["pub"]     : null), $env['publisherMaxSize']     );
	$mail    = string_max_lenght( safe_string(isset($params["mail"])    ? $params["mail"]    : null), $env['mailMaxSize']          );
	$site    = string_max_lenght( safe_string(isset($params["site"])    ? $params["site"]    : null), $env['siteMaxSize']          );
	
	if($quote != null){
		$ret = postRephraseQuote($usr, $quoteid, $quote, $expl, $pub, $mail, $site);
		return createErrorJson($usr, $ret);
	} else{ return createErrorJson($usr, 400); } // paramètres incorrects
}

?>