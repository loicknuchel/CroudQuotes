<?php// API : quote.php:GET?key={key}&quoteid={quoteid}[&p={no_comment_page}][&nocomment=1]function apiGetQuoteById(&$usr, $params, $server_path){	$rel = isset($server_path) ? $server_path : '../../../';	include_once $rel.'globals/env.php';	include_once $rel.'services/get.php';	include_once $rel.'utils/json.php';	include_once $rel.'utils/secureVars.php';	include_once 'utils/extra_data.php';		saveExtraDatas($usr, $params);	$quoteid = safe_int(isset($params["quoteid"]) ? $params["quoteid"] : null);	$p = safe_int(isset($params["p"]) ? $params["p"] : null);	$nocomment = isset($params["nocomment"]) ? $params["nocomment"] : null;		if($quoteid != null){		$quote_result = getQuote($usr, $quoteid);		if($quote_result != null){			if($nocomment == 1){				return createQuoteJson($usr, $quote_result);			}			else{				$pages = getTotalCommentPages($usr, 'quote', $quote_result['id']);				if($p == null || $p > $pages){$p = $pages;}				$comments_result = getComments($usr, 'quote', $quote_result['id'], $p, utf8_decode('Ce commentaire a été modéré.'));				return createQuoteCommentsJson($usr, $quote_result, $comments_result, $p, $pages);			}		} else{ return createErrorJson($usr, 404); } // pas de résultats	} else{ return createErrorJson($usr, 400); } // paramètres incorrects}// API : quote.php:GET?key={key}&quoteid=random[&p={no_comment_page}][&nocomment=1][&noheaders=1]function apiGetQuoteByRandom(&$usr, $params, $server_path){	$rel = isset($server_path) ? $server_path : '../../../';	include_once $rel.'globals/env.php';	include_once $rel.'services/get.php';	include_once $rel.'utils/json.php';	include_once $rel.'utils/secureVars.php';		$usr['noheaders'] = safe_int(isset($params["noheaders"]) ? $params["noheaders"] : null);	$p = safe_int(isset($params["p"]) ? $params["p"] : null);	$nocomment = isset($params["nocomment"]) ? $params["nocomment"] : null;		$quote_result = getRandomQuote($usr);	if($quote_result != null){		if($nocomment == 1){			return createQuoteJson($usr, $quote_result);		}		else{			$pages = getTotalCommentPages($usr, 'quote', $quote_result['id']);				if($p == null || $p > $pages){$p = $pages;}			$comments_result = getComments($usr, 'quote', $quote_result['id'], $p, utf8_decode('Ce commentaire a été modéré.'));			return createQuoteCommentsJson($usr, $quote_result, $comments_result, $p, $pages);		}	} else{ return createErrorJson($usr, 404); } // pas de résultats}?>