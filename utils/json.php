<?php	include_once $rel.'globals/env.php';	include_once $rel.'globals/conventions.php';	function createErrorJson($usr, $no, $json_details = null){	$json_info = jsonInfoSection($usr);		if($no == 200){$json = '{"status":{"code":'.jsonInt('200').',"message":"Success"}'.$json_details.''.$json_info.'}';}	if($no == 400){$json = '{"status":{"code":'.jsonInt('400').',"message":"Requête invalide: erreur de paramètres."}'.$json_details.''.$json_info.'}';}	if($no == 401){$json = '{"status":{"code":'.jsonInt('401').',"message":"pas d\'autorisation d\'accès à la ressource."}'.$json_details.''.$json_info.'}';}	if($no == 402){$json = '{"status":{"code":'.jsonInt('402').',"message":"Vous avez dépassé votre quota de requêtes."}'.$json_details.''.$json_info.'}';}	if($no == 403){$json = '{"status":{"code":'.jsonInt('403').',"message":"Problème interne dans la persistance de données."}'.$json_details.''.$json_info.'}';}	if($no == 404){$json = '{"status":{"code":'.jsonInt('404').',"message":"Ressource innexistante."}'.$json_details.''.$json_info.'}';}	if($no == 405){$json = '{"status":{"code":'.jsonInt('405').',"message":"Mauvaise version de base de donnée."}'.$json_details.''.$json_info.'}';}	if($no == 406){$json = '{"status":{"code":'.jsonInt('406').',"message":"Operation non autorisée."}'.$json_details.''.$json_info.'}';}	return sendJson($usr, $json);}function createInsertSuccessJson($usr, $id){	$json = jsonSuccessSection();	$json .= '"response":{"id":'.jsonInt($id).'}'.jsonInfoSection($usr).'}';	return sendJson($usr, utf8_encode($json));}function createPostCategoryJson($usr, $newcategoryid, $newcategoryname){	$json = jsonSuccessSection();	$json .= '"response":{"category":{"id":'.jsonInt($newcategoryid).',"name":'.jsonString($newcategoryname).'}}'.jsonInfoSection($usr).'}';	return sendJson($usr, utf8_encode($json));}function createPostSelectionJson($usr, $newselectionid, $newselectionname){	$json = jsonSuccessSection();	$json .= '"response":{"selection":{"id":'.jsonInt($newselectionid).',"name":'.jsonString($newselectionname).'}}'.jsonInfoSection($usr).'}';	return sendJson($usr, utf8_encode($json));}function createQuoteJson($usr, $quote, $mysql_comments, $c_cur_page, $comment_pages, $mysql_petition, $p_cur_page, $petition_pages, $put_comments, $put_petition){	if($quote == null){		return createErrorJson($usr, 404); // pas de résultats	}		$env = setEnv();		$json = jsonSuccessSection();	$json .= '"response":{'.createQuoteSection($quote);		if($put_comments == true){		$json .= ',"comments":[';		$cpt = 0;		while ($mysql_comments != null && $comments = mysql_fetch_array($mysql_comments, MYSQL_ASSOC)) {			if($cpt != 0){$json .= ',';} $cpt++;			$json .= '{'.createCommentSection($comments).'}';		}		$json .= '],"nbcomments":'.jsonInt($cpt).',';		$json .= '"size_comment_page":'.jsonInt($env['commentPageSize']).',';		$json .= '"current_comment_page":'.jsonInt($c_cur_page).',';		$json .= '"total_comment_pages":'.jsonInt($comment_pages);	}		if($put_petition == true){		$json .= ',"signatures":[';		$cpt = 0;		while ($mysql_petition != null && $signatures = mysql_fetch_array($mysql_petition, MYSQL_ASSOC)) {			if($cpt != 0){$json .= ',';} $cpt++;			$json .= '{'.createPetitionSection($signatures).'}';		}		$json .= '],"nbsignatures":'.jsonInt($cpt).',';		$json .= '"size_petition_page":'.jsonInt($env['petitionPageSize']).',';		$json .= '"current_petition_page":'.jsonInt($p_cur_page).',';		$json .= '"total_petition_pages":'.jsonInt($petition_pages);	}		$json .= '}'.jsonInfoSection($usr).'}';		return sendJson($usr, utf8_encode($json));}function createCommentsJson($usr, $mysql_comments, $cur_page, $comment_pages){	$env = setEnv();		$json = jsonSuccessSection();	$json .= '"response":{';	$json .= '"comments":[';		$cpt = 0;	while ($mysql_comments != null && $comments = mysql_fetch_array($mysql_comments, MYSQL_ASSOC)) {		if($cpt != 0){$json .= ',';} $cpt++;		$json .= '{'.createCommentSection($comments).'}';	}		$json .= '],"nbcomments":'.jsonInt($cpt).',';	$json .= '"size_comment_page":'.jsonInt($env['commentPageSize']).',';	$json .= '"current_comment_page":'.jsonInt($cur_page).',';	$json .= '"total_comment_pages":'.jsonInt($comment_pages).'}'.jsonInfoSection($usr).'}';		return sendJson($usr, utf8_encode($json));}function createListQuoteJson($usr, $mysql_result, $cur_page, $pages, $json_details = null){	if($mysql_result == null){		return createErrorJson($usr, 404); // pas de résultats	}		$env = setEnv();	$json = jsonSuccessSection();		$json .= '"response":{"quotes":[';				$cpt = 0;		while ($mysql_result != null && $quote = mysql_fetch_array($mysql_result, MYSQL_ASSOC)) {			if($cpt != 0){$json .= ',';} $cpt++;			$json .= '{'.createQuoteSection($quote).'}';					}				$json .= '],"nbquotes":'.jsonInt($cpt).',';		$json .= '"size_quote_page":'.jsonInt($env['quotePageSize']).',';		$json .= '"current_quote_page":'.jsonInt($cur_page).',';		$json .= '"total_quote_pages":'.jsonInt($pages);		$json .= $json_details.'}';	$json .= jsonInfoSection($usr).'}';		return sendJson($usr, utf8_encode($json));}function createCategoriesJson($usr, $categories_result, $cur_page, $pages){	if($categories_result == null){		return createErrorJson($usr, 404); // pas de résultats	}		$env = setEnv();	$json = jsonSuccessSection();	$json .= '"response":{"categories":[';		$cpt = 0;	while ($categories_result != null && $category = mysql_fetch_array($categories_result, MYSQL_ASSOC)) {		if($cpt != 0){$json .= ',';} $cpt++;		$json .= '{'.createCategorySection($category).'}';			}		$json .= '],"nbcategories":'.jsonInt($cpt).',';	$json .= '"size_category_page":'.jsonInt($env['categoryPageSize']).',';	$json .= '"current_category_page":'.jsonInt($cur_page).',';	$json .= '"total_category_pages":'.jsonInt($pages).'}'.jsonInfoSection($usr).'}';		return sendJson($usr, utf8_encode($json));}function createSelectionsJson($usr, $selections_result, $cur_page, $pages){	if($selections_result == null){		return createErrorJson($usr, 404); // pas de résultats	}		$env = setEnv();	$json = jsonSuccessSection();	$json .= '"response":{"selections":[';		$cpt = 0;	while ($selections_result != null && $category = mysql_fetch_array($selections_result, MYSQL_ASSOC)) {		if($cpt != 0){$json .= ',';} $cpt++;		$json .= '{'.createSelectionSection($category).'}';	}		$json .= '],"nbselections":'.jsonInt($cpt).',';	$json .= '"size_selection_page":'.jsonInt($env['selectionPageSize']).',';	$json .= '"current_selection_page":'.jsonInt($cur_page).',';	$json .= '"total_selection_pages":'.jsonInt($pages).'}'.jsonInfoSection($usr).'}';		return sendJson($usr, utf8_encode($json));}function createMailSuiviJson($usr, $mail, $suivi_result){	$json = jsonSuccessSection();	$json .= '"response":{"mail":'.jsonString($mail).',"suivis":{';		$cpt = 0;	$current_type = 0;	while ($suivi_result != null && $suivi = mysql_fetch_array($suivi_result, MYSQL_ASSOC)) {		if($suivi['elt_type'] != $current_type){			if($current_type != 0){$json .= '],';}			$json .= '"'.codeToRessourceType($suivi['elt_type']).'":['.jsonInt($suivi['elt_id']).'';			$current_type = $suivi['elt_type'];		}		else{			$json .= ','.jsonInt($suivi['elt_id']).'';		}		$cpt++;	}	if($cpt > 0){$json .= ']';}		$json .= '},"total_suivis":'.jsonInt($cpt).'}'.jsonInfoSection($usr).'}';		return sendJson($usr, utf8_encode($json));}function createSuiviForRessourceJson($usr, $elt_type, $elt_id, $suivi_result){	$json = jsonSuccessSection();	$json .= '"response":{"elt":'.jsonString($elt_type).',"id":'.jsonInt($elt_id).',"suivi":[';		$cpt = 0;	while ($suivi_result != null && $suivi = mysql_fetch_array($suivi_result, MYSQL_ASSOC)){		if($cpt != 0){$json .= ',';} $cpt++;		$json .= '{"name":'.jsonString($suivi['name']).',"info":'.jsonString($suivi['info']).'}';	}		$json .= '],"total_suivis":'.jsonInt($cpt).'}'.jsonInfoSection($usr).'}';		return sendJson($usr, utf8_encode($json));}function createPetitionJson($usr, $elt_type, $elt_id, $petition_result, $cur_page, $pages){	$env = setEnv();	$json = jsonSuccessSection();	$json .= '"response":{"elt":'.jsonString($elt_type).',"id":'.jsonInt($elt_id).',"signatures":[';		$cpt = 0;	while ($petition_result != null && $petition = mysql_fetch_array($petition_result, MYSQL_ASSOC)){		if($cpt != 0){$json .= ',';} $cpt++;		$json .= '{'.createPetitionSection($petition).'}';	}		$json .= '],"nbsignatures":'.jsonInt($cpt).',';	$json .= '"size_petition_page":'.jsonInt($env['petitionPageSize']).',';	$json .= '"current_petition_page":'.jsonInt($cur_page).',';	$json .= '"total_petition_pages":'.jsonInt($pages).'}'.jsonInfoSection($usr).'}';		return sendJson($usr, utf8_encode($json));}function createParamsJson($usr){	$env = setEnv();	$json = jsonSuccessSection();		$json .= '"response":{';			$json .= '"textMaxSize":{';				$json .= '"quote":'.jsonInt($env['quoteMaxSize']).',';				$json .= '"comment":'.jsonInt($env['commentMaxSize']).',';				$json .= '"source":'.jsonInt($env['sourceMaxSize']).',';				$json .= '"context":'.jsonInt($env['contextMaxSize']).',';				$json .= '"explanation":'.jsonInt($env['explanationMaxSize']).',';				$json .= '"sign_message":'.jsonInt($env['messageMaxSize']).',';				$json .= '"author":'.jsonInt($env['authorMaxSize']).',';				$json .= '"prenom":'.jsonInt($env['prenomMaxSize']).',';				$json .= '"nom":'.jsonInt($env['nomMaxSize']).',';				$json .= '"publisher":'.jsonInt($env['publisherMaxSize']).',';				$json .= '"publisher_info":'.jsonInt($env['publisherInfoMaxSize']).',';				$json .= '"profession":'.jsonInt($env['professionMaxSize']).',';				$json .= '"zipcode":'.jsonInt($env['zipcodeMaxSize']).',';				$json .= '"mail":'.jsonInt($env['mailMaxSize']).',';				$json .= '"site":'.jsonInt($env['siteMaxSize']).',';				$json .= '"category":'.jsonInt($env['categoryMaxSize']).',';				$json .= '"selection":'.jsonInt($env['selectionMaxSize']).',';				$json .= '"tag":'.jsonInt($env['tagMaxSize']).'';			$json .= '}';		$json .= '}';		$json .= jsonInfoSection($usr);	$json .= '}';	return sendJson($usr, $json);}// privatefunction jsonSuccessSection(){	return '{"status":{"code":'.jsonInt('200').',"message":"Success"},';}// privatefunction jsonInfoSection($usr){	if(isset($usr['reqLeft'])){		return ',"info":{"remaining_queries":'.jsonInt($usr['reqLeft']).',"next_restart":'.jsonInt($usr['nextReset']).'}';	}	else{		return '';	}}// privatefunction createQuoteSection($quote){	$section = '"id":'.jsonInt($quote['id']).',';	$section .= '"post_timestamp":'.jsonInt($quote['post_timestamp']).',';	$section .= '"post_date":'.jsonDate($quote['post_date']).',';	$section .= '"quote":'.jsonString($quote['quote']).',';	$section .= '"source":'.jsonString($quote['source']).',';	$section .= '"context":'.jsonString($quote['context']).',';	$section .= '"explanation":'.jsonString($quote['explanation']).',';	$section .= '"author":'.jsonString($quote['author']).',';	$section .= '"publisher":'.jsonString($quote['publisher']).',';	$section .= '"publisher_info":'.jsonString($quote['publisher_info']).',';	$section .= '"site":'.jsonString($quote['site']).',';	$section .= '"category":'.jsonString($quote['category']).',';	$section .= '"category_id":'.jsonInt($quote['category_id']).',';	$section .= '"up":'.jsonInt($quote['vote_up']).',';	$section .= '"down":'.jsonInt($quote['vote_down']).',';	$section .= '"total_comments":'.jsonInt($quote['comments']).',';	$section .= '"total_signatures":'.jsonInt($quote['signatures']);	return $section;}// privatefunction createCommentSection($comment){	$section = '"id":'.jsonInt($comment['id']).',';	$section .= '"post_timestamp":'.jsonInt($comment['post_timestamp']).',';	$section .= '"post_date":'.jsonDate($comment['post_date']).',';	$section .= '"publisher":'.jsonString($comment['publisher']).',';	$section .= '"site":'.jsonString($comment['site']).',';	$section .= '"comment":'.jsonString($comment['comment']).',';	$section .= '"up":'.jsonInt($comment['vote_up']).',';	$section .= '"down":'.jsonInt($comment['vote_down']).',';	$section .= '"reported":'.jsonInt($comment['reported']);	return $section;}// privatefunction createCategorySection($category){	$section = '"id":'.jsonInt($category['id']).',';	$section .= '"post_timestamp":'.jsonInt($category['post_timestamp']).',';	$section .= '"post_date":'.jsonDate($category['post_date']).',';	$section .= '"name":'.jsonString($category['name']).'';	return $section;}// privatefunction createSelectionSection($selection){	$section = '"id":'.jsonInt($selection['id']).',';	$section .= '"post_timestamp":'.jsonInt($selection['post_timestamp']).',';	$section .= '"post_date":'.jsonDate($selection['post_date']).',';	$section .= '"name":'.jsonString($selection['name']);	return $section;}// privatefunction createPetitionSection($petition){	$section = '"no":'.jsonInt($petition['sign_no']).',';	$section .= '"post_date":'.jsonDate($petition['post_date']).',';	$section .= '"genre":'.jsonString(codeToGenre($petition['genre'])).',';	$section .= '"prenom":'.jsonString($petition['prenom']).',';	$section .= '"nom":'.jsonString($petition['nom']).',';	$section .= '"site":'.jsonString($petition['site']).',';	$section .= '"profession":'.jsonString($petition['profession']).',';	$section .= '"code_postal":'.jsonString($petition['code_postal']).',';	$section .= '"message":'.jsonString($petition['message']);	return $section;}// privatefunction sendJson($usr, $json){	if(!isset($usr['noheaders']) || $usr['noheaders'] != 1){		header('Cache-Control: no-cache, must-revalidate');		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');		header('Content-type: application/json; charset=utf-8');	}		if(isset($usr['format']) && $usr['format'] == 'jsonp'){		header('Content-type: text/javascript; charset=utf-8');		$json = $usr['callback'].'('.$json.');';	}		return $json;}// privatefunction jsonString($str){	if($str == null){return '""';}	$str = str_replace("\'", "'", $str);	$str = str_replace('\"', '"', $str);	$str = str_replace('"', '\"', $str);	$str = preg_replace("((\r\n))", '\n', $str); // IMPORTANT pour autoriser les sauts de ligne !	$str = strip_tags($str);	$str = trim($str);	return '"'.$str.'"';}// privatefunction jsonInt($int){	if(isset($int) && is_numeric($int)){		return (int) intval($int);	}	return 0;}// privatefunction jsonDate($date){	$date = str_replace("|", utf8_decode(" à "), $date);	$date = substr($date, 0, -3); // suppression des secondes	return '"'.$date.'"';}?>