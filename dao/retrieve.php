<?php
	include_once $rel.'dao/connectDb.php';
	include_once $rel.'dao/mysqlUtils.php';
	include_once $rel.'dao/retrieveUtils.php';
	include_once $rel.'dao/persistUtils.php';
	include_once $rel.'globals/env.php';
	include_once $rel.'globals/conventions.php';
	
	function retrieveQuote($usr, $quoteid){
		return retrieveUniqueQuote($usr, "AND q.id=".$quoteid."");
	}
	
	function retrieveRandomQuote($usr){
		return retrieveUniqueQuote($usr, "ORDER BY RAND()");
	}
	
	// private 
	function retrieveUniqueQuote($usr, $select){
		$dbVars = setDbVars(getStatus());
		$req = "SELECT q.id, ".format_date('q.`post_date`').", q.quote, q.origin_quote, q.source, q.context, q.explanation, q.origin_explanation, q.author, q.publisher, q.publisher_info, q.site, c.name as category, q.category as category_id, q.vote_up, q.vote_down, q.comments, q.signatures 
		FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."quote` q LEFT OUTER JOIN `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."category` c on q.category=c.id AND q.service_id=c.service_id
		WHERE q.service_id=".$usr['noService']." AND quote_state=0
		".$select."
		LIMIT 1;";
		return getUniqueDataRow($req, $usr);
	}
	
	function retrieveQuoteRephrase($usr, $quoteid){
		$dbVars = setDbVars(getStatus());
		$env = setEnv();
		
		/*
		SELECT q.`post_date`, q.`publisher`, q.`site`, q.`content` AS quote, e.`content` AS expl
		FROM cq1_4_history q
			LEFT OUTER JOIN cq1_4_history e ON q.service_id=e.service_id AND q.elt_type=e.elt_type AND q.elt_id=e.elt_id
		WHERE q.`service_id`=1 AND q.`elt_type`=2 AND q.`elt_id`=1 AND q.`elt_field`=20 AND e.`elt_field`=21
		*/
		$req = "SELECT ".format_date('q.`post_date`').", q.`publisher`, q.`site`, q.`content` AS quote, e.`content` AS explanation
		FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."history` q 
			LEFT OUTER JOIN `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."history` e ON q.service_id=e.service_id AND q.elt_type=e.elt_type AND q.elt_id=e.elt_id AND q.post_date=e.post_date AND e.`elt_field`=21
		WHERE q.`service_id`=".$usr['noService']." AND q.`elt_type`=2 AND q.`elt_id`=".$quoteid." AND q.`elt_field`=20
		ORDER BY post_timestamp DESC;";
		return getMultipleDataRows($req, $usr);
	}
	
	function retrieveTopQuotes($usr, $page){
		return retrieveMultipleQuotes($usr, $page, "ORDER BY q.vote_up-q.vote_down DESC, q.comments DESC, q.vote_up DESC, post_timestamp DESC");
	}
	
	function retrieveTopCommentQuotes($usr, $page){
		return retrieveMultipleQuotes($usr, $page, "ORDER BY q.comments DESC, q.vote_up-q.vote_down DESC, q.vote_up DESC, post_timestamp DESC");
	}
	
	function retrieveLastsQuotes($usr, $page){
		return retrieveMultipleQuotes($usr, $page, "ORDER BY post_timestamp DESC");
	}
	
	function retrieveLastActivityQuotes($usr, $page){
		return retrieveMultipleQuotes($usr, $page, "ORDER BY q.last_activity DESC, q.comments DESC, q.vote_up-q.vote_down DESC, q.vote_up DESC, post_timestamp DESC");
	}
	
	function retrieveCustomQuoteList($usr, $tabid){
		$ids = null;
		foreach($tabid as $key => $value){
			if($key == 0){$ids = 'q.id='.$value.'';}
			else{ $ids .= ' OR q.id='.$value.'';}
		}
		
		return retrieveMultipleQuotes($usr, -1, "AND (".$ids.") ORDER BY q.vote_up-q.vote_down DESC, post_timestamp DESC, q.id DESC;");
	}
	
	function retrieveCategoryQuotes($usr, $cat_id, $page){
		return retrieveMultipleQuotes($usr, $page, "AND q.category='".$cat_id."' ORDER BY q.vote_up-q.vote_down DESC, post_timestamp DESC");
	}
	
	function retrieveSelectionQuotes($usr, $sel_id, $page){
		$dbVars = setDbVars(getStatus());
		return retrieveMultipleQuotes($usr, $page, "AND sq.selection_id='".$sel_id."' ORDER BY q.vote_up-q.vote_down DESC, post_timestamp DESC" , "LEFT OUTER JOIN `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."selection_quote` sq on q.id=sq.quote_id AND q.service_id=sq.service_id");
	}
	
	function retrieveAuthorQuotes($usr, $auth, $page){
		return retrieveMultipleQuotes($usr, $page, "AND q.author='".$auth."' ORDER BY q.vote_up-q.vote_down DESC, post_timestamp DESC");
	}
	
	// private
	function retrieveMultipleQuotes($usr, $page, $select, $join = ""){
		$dbVars = setDbVars(getStatus());
		$env = setEnv();
		
		$req = "SELECT q.id, ".format_date('q.`post_date`').", q.quote, q.origin_quote, q.source, q.context, q.explanation, q.origin_explanation, q.author, q.publisher, q.publisher_info, q.site, c.name as category, q.category as category_id, q.vote_up, q.vote_down, q.comments, q.signatures 
		FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."quote` q LEFT OUTER JOIN `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."category` c on q.category=c.id AND q.service_id=c.service_id ".$join."
		WHERE q.quote_state=0 AND q.service_id=".$usr['noService']." ".$select."";
		if($page != -1){$req .= " LIMIT ".($page-1)*$env['quotePageSize'].", ".$env['quotePageSize'].";";}
		
		return getMultipleDataRows($req, $usr);
	}
		
	function retrieveComments($usr, $i_type, $elt_id, $page, $textForReportedComments){
		$dbVars = setDbVars(getStatus());
		$env = setEnv();
		
		$req = "SELECT `id`, ".format_date('`post_date`').", `avis`, `publisher`, `site`, IF(`comment_state` = 0, `comment`, '".$textForReportedComments."') AS `comment`, `vote_up`, `vote_down`, IF(`comment_state` = 0, 0, 1) AS `reported`
		FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."comment` 
		WHERE service_id=".$usr['noService']." AND `elt_type`=".$i_type." AND `elt_id`=".$elt_id."
		ORDER BY `post_timestamp` 
		LIMIT ".($page-1)*$env['commentPageSize'].", ".$env['commentPageSize'].";";
		return getMultipleDataRows($req, $usr);
	}
	
	function retrieveCategories($usr, $page){
		$dbVars = setDbVars(getStatus());
		$env = setEnv();
		
		$req = "SELECT `id`, ".format_date('`post_date`').", `name`
		FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."category` 
		WHERE service_id=".$usr['noService']."
		ORDER BY `name` 
		LIMIT ".($page-1)*$env['categoryPageSize'].", ".$env['categoryPageSize'].";";
		
		return getMultipleDataRows($req, $usr);
	}
	
	function retrieveSelections($usr, $page){
		$dbVars = setDbVars(getStatus());
		$env = setEnv();
		
		$req = "SELECT DISTINCT s.`id`, ".format_date('s.`post_date`').", s.`name`
		FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."selection` s
			INNER JOIN `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."selection_quote` sq ON s.id=sq.selection_id AND s.service_id=sq.service_id
			INNER JOIN `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."quote` q ON sq.quote_id=q.id AND s.service_id=q.service_id
		WHERE q.quote_state=0 AND s.service_id=".$usr['noService']."
		ORDER BY s.`name` 
		LIMIT ".($page-1)*$env['selectionPageSize'].", ".$env['selectionPageSize'].";";
		
		return getMultipleDataRows($req, $usr);
	}
	
	function retrieveSuiviByMail($usr, $mail){
		$dbVars = setDbVars(getStatus());
		
		$req = "SELECT elt_type, elt_id FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."suivi` WHERE service_id=".$usr['noService']." AND mail='".$mail."' AND actif=1 ORDER BY elt_type, elt_id;";
		return getMultipleDataRows($req, $usr);
	}
	
	function retrieveSuiviForRessource($usr, $elt_type, $elt_id){
		$dbVars = setDbVars(getStatus());
		
		$req = "SELECT mail, name, info, ".format_date('`post_date`')." FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."suivi` WHERE service_id=".$usr['noService']." AND elt_type='".ressourceTypeToCode($elt_type)."' AND elt_id='".$elt_id."' AND actif=1 ORDER BY post_timestamp;";
		return getMultipleDataRows($req, $usr);
	}
		
	function retrievePetition($usr, $type, $elt_id, $page){
		$dbVars = setDbVars(getStatus());
		$env = setEnv();
		
		$req = "SELECT `sign_no`, ".format_date('`post_date`').", `genre`, `prenom`, `nom`, `site`, `age`, `profession`, `code_postal`, `message`
		FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."petition` 
		WHERE `service_id`=".$usr['noService']." AND `elt_type`=".$type." AND `elt_id`=".$elt_id." AND `etat`=2
		ORDER BY `sign_no` DESC 
		LIMIT ".($page-1)*$env['petitionPageSize'].", ".$env['petitionPageSize'].";";
		
		return getMultipleDataRows($req, $usr);
	}
	
	function retrieveTotalPages($usr){
		$dbVars = setDbVars(getStatus());
		$env = setEnv();
		
		$req = "SELECT count(*) as pages FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."quote` WHERE quote_state=0 AND service_id=".$usr['noService'].";";
		return retrieveCountPages($usr, $req, $env['quotePageSize']);
	}
	
	function retrieveCategoryTotalPages($usr, $cat_id){
		$dbVars = setDbVars(getStatus());
		$env = setEnv();
		
		$req = "SELECT count(*) as pages FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."quote` WHERE quote_state=0 AND service_id=".$usr['noService']." AND category='".$cat_id."';";
		return retrieveCountPages($usr, $req, $env['quotePageSize']);
	}
	
	function retrieveSelectionTotalPages($usr, $sel_id){
		$dbVars = setDbVars(getStatus());
		$env = setEnv();
		
		$req = "SELECT count(*) as pages 
		FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."selection_quote` sq LEFT OUTER JOIN `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."quote` q ON sq.quote_id=q.id AND sq.service_id=q.service_id
		WHERE q.quote_state=0 AND sq.service_id=".$usr['noService']." AND sq.selection_id='".$sel_id."';";
		return retrieveCountPages($usr, $req, $env['quotePageSize']);
	}
	
	function retrieveAuthorTotalPages($usr, $auth){
		$dbVars = setDbVars(getStatus());
		$env = setEnv();
		
		$req = "SELECT count(*) as pages FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."quote` WHERE quote_state=0 AND service_id=".$usr['noService']." AND author='".$auth."';";
		return retrieveCountPages($usr, $req, $env['quotePageSize']);
	}
	
	function retrieveTotalCommentPages($usr, $type, $elt_id){
		$dbVars = setDbVars(getStatus());
		$env = setEnv();
		
		$req = "SELECT count(*) as pages FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."comment` WHERE service_id=".$usr['noService']." AND elt_type=".$type." AND elt_id=".$elt_id.";";
		return retrieveCountPages($usr, $req, $env['commentPageSize']);
	}
	
	function retrieveTotalPetitionPages($usr, $type, $elt_id){
		$dbVars = setDbVars(getStatus());
		$env = setEnv();
		
		$req = "SELECT count(*) as pages FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."petition` WHERE service_id=".$usr['noService']." AND elt_type=".$type." AND elt_id=".$elt_id." AND etat=2;";
		return retrieveCountPages($usr, $req, $env['petitionPageSize']);
	}
	
	function retrieveTotalCategoriesPages($usr){
		$dbVars = setDbVars(getStatus());
		$env = setEnv();
		
		$req = "SELECT count(*) as pages FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."category` WHERE service_id=".$usr['noService'].";";
		return retrieveCountPages($usr, $req, $env['categoryPageSize']);
	}
	
	function retrieveTotalSelectionsPages($usr){
		$dbVars = setDbVars(getStatus());
		$env = setEnv();
		
		$req = "SELECT count(*) as pages FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."selection` WHERE service_id=".$usr['noService'].";";
		return retrieveCountPages($usr, $req, $env['selectionPageSize']);
	}
	
	function retrieveKeyCptCount($usr){
		$dbVars = setDbVars(getStatus());
		
		$req = "SELECT `last_reset`, `cpt`, `max_cpt`, `reset_time` FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."key_cpt` WHERE `key`='".$usr['key']."' LIMIT 1;";
		return getUniqueDataRow($req, $usr);
	}
	
	function retrieveCategoryId($usr, $category_name){
		$dbVars = setDbVars(getStatus());
		
		$req = "SELECT id FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."category` WHERE service_id=".$usr['noService']." AND name='".$category_name."' LIMIT 1;";
		return getSingleData($usr, $req, 'id');
	}
	
	function retrieveCategoryName($usr, $category_id){
		$dbVars = setDbVars(getStatus());
		
		$req = "SELECT name FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."category` WHERE service_id=".$usr['noService']." AND id='".$category_id."' LIMIT 1;";
		return getSingleData($usr, $req, 'name');
	}
	
	function retrieveSelectionId($usr, $sel){
		$dbVars = setDbVars(getStatus());
		
		$req = "SELECT id FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."selection` WHERE service_id=".$usr['noService']." AND name='".$sel."' LIMIT 1;";
		return getSingleData($usr, $req, 'id');
	}
	
	function retrieveSelectionName($usr, $sel_id){
		$dbVars = setDbVars(getStatus());
		
		$req = "SELECT name FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."selection` WHERE service_id=".$usr['noService']." AND id='".$sel_id."' LIMIT 1;";
		return getSingleData($usr, $req, 'name');
	}
	
	function retrieveNewId($usr, $tableName){
		$dbVars = setDbVars(getStatus());
		$fieldName = str_replace("newCQ", "id", $tableName);
		$req = "SELECT `".$fieldName."` FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."id_increment` WHERE `service_id`='".$usr['noService']."';";
		$newId = getSingleData($usr, $req, $fieldName, 0);
		
		if($newId == null){ // s'il n'y a pas d'enregistrement pour le service
			$req = "INSERT INTO `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."id_increment` (`service_id`) VALUES ('".$usr['noService']."');";
			query($req, $usr);
			$newId = 0;
		}
		
		$newId = $newId+1;
		$req = "UPDATE `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."id_increment` SET `".$fieldName."`=".$newId." WHERE `service_id`='".$usr['noService']."';";
		query($req, $usr);
		return $newId;
	}
	
	function retrieveLastId($usr, $tableName){
		$dbVars = setDbVars(getStatus());
		$fieldName = str_replace("newCQ", "id", $tableName);
		
		$req = "SELECT `".$fieldName."` FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."id_increment` WHERE service_id=".$usr['noService'].";";
		return getSingleData($usr, $req, $fieldName);
	}
	
	function retireveIsCorrectDbVersion($usr){
		$dbVars = setDbVars(getStatus());
		dbConnect();
		
		$env = setEnv();
		$ret = false;
		
		$req = "SELECT version FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."bdd_info` LIMIT 1;";
		$res = getSingleData($usr, $req, 'version', 0);
		if($res == $env['BDDversion']){
			$ret = true;
		}
		
		unset($req);
		dbDisconnect();
		return $ret;
	}
	
	
?>
