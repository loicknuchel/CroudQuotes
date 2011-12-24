<?phpfunction apiGetQuoteById(&$usr, $params, $server_path){	$rel = isset($server_path) ? $server_path : '../../../';	include_once $rel.'globals/env.php';	include_once $rel.'services/get.php';	include_once $rel.'utils/json.php';	include_once $rel.'utils/secureVars.php';	include_once 'utils/extra_data.php';		saveExtraDatas($usr, $params);	$quoteid = safe_int(isset($params["quoteid"]) ? $params["quoteid"] : null);	$pc = safe_int(isset($params["pc"]) ? $params["pc"] : null);	$pp = isset($params["pp"]) ? ($params["pp"] == 'all' ? $params["pp"] : safe_int($params["p"])) : null;	$rephrase = isset($params["rephrase"]) ? $params["rephrase"] : null;	$nocomment = isset($params["nocomment"]) ? $params["nocomment"] : null;	$nopetition = isset($params["nopetition"]) ? $params["nopetition"] : null;		if($quoteid != null){		$quote_result = getQuote($usr, $quoteid);		return agregateQuote($usr, $quote_result, $pc, $pp, $rephrase, $nocomment, $nopetition);	} else{ return createErrorJson($usr, 400); } // paramètres incorrects}function apiGetQuoteByRandom(&$usr, $params, $server_path){	$rel = isset($server_path) ? $server_path : '../../../';	include_once $rel.'globals/env.php';	include_once $rel.'services/get.php';	include_once $rel.'utils/json.php';	include_once $rel.'utils/secureVars.php';		$usr['noheaders'] = safe_int(isset($params["noheaders"]) ? $params["noheaders"] : null);	$pc = safe_int(isset($params["pc"]) ? $params["pc"] : null);	$pp = isset($params["pp"]) ? ($params["pp"] == 'all' ? $params["pp"] : safe_int($params["p"])) : null;	$rephrase = isset($params["rephrase"]) ? $params["rephrase"] : null;	$nocomment = isset($params["nocomment"]) ? $params["nocomment"] : null;	$nopetition = isset($params["nopetition"]) ? $params["nopetition"] : null;		$quote_result = getRandomQuote($usr);	return agregateQuote($usr, $quote_result, $pc, $pp, $rephrase, $nocomment, $nopetition);}// private function agregateQuote($usr, $quote_result, $pc, $pp, $rephrase, $nocomment, $nopetition){	if($quote_result != null){		$put_comment = false;		$comments_result = null;		$comment_pages = 0;		$put_petition = false;		$petition_result = null;		$petition_pages = 0;		$put_rephrase = false;		$rephrase_result = null;				if($rephrase == 1){			$put_rephrase = true;			$rephrase_result = getQuoteRephrase($usr, $quote_result['id']);		}		if($nocomment != 1){			$put_comment = true;			$comment_pages = getTotalCommentPages($usr, 'quote', $quote_result['id']);			if($pc == null || $pc > $comment_pages){$pc = $comment_pages;}			$comments_result = getComments($usr, 'quote', $quote_result['id'], $pc, utf8_decode('Ce commentaire a été modéré.'));		}		if($nopetition != 1){			$put_petition = true;			if($pp == 'all'){ $petition_pages = 1; }			else{				$petition_pages = getTotalPetitionPages($usr, 'quote', $quote_result['id']);				if($pp == null){$pp = 1;}				else if($pp > $petition_pages){$pp = $petition_pages;}			}			$petition_result = getPetition($usr, 'quote', $quote_result['id'], $pp);		}				return createQuoteJson($usr, $quote_result, $rephrase_result, $put_rephrase, $comments_result, $pc, $comment_pages, $put_comment, $petition_result, $pp, $petition_pages, $put_petition);			} else{ return createErrorJson($usr, 404); } // pas de résultats}?>