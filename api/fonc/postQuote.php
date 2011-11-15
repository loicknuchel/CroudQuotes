<?php

// API : quote.php:POST?key={key}&quote={quote}[&src={source}][&ctx={context}][&expl={explanation}][&auth={author}][&pub={publisher}][&pubinfo={publisher_infos}][&mail={mail}][&site={site}][&cat={category_id|category_name}]
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

?>