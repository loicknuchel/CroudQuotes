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
		$dbVars = setDbVars();
		$req = "SELECT q.id, ".format_date('q.`post_date`').", q.quote, q.source, q.context, q.explanation, q.author, q.publisher, q.publisher_info, q.site, c.name as category, q.category as category_id, q.vote_up, q.vote_down, q.comments 
		FROM `".$dbVars['name']."`.`newCQ_quote` q LEFT OUTER JOIN `".$dbVars['name']."`.`newCQ_category` c on q.category=c.id AND q.service_id=c.service_id
		WHERE q.service_id=".$usr['noService']." AND quote_state=0
		".$select."
		LIMIT 1;";
		return getUniqueDataRow($req, $usr);
	}
	
	function retrieveTopQuotes($usr, $page){
		return retrieveMultipleQuotes($usr, $page, "ORDER BY q.vote_up-q.vote_down DESC, q.comments DESC, q.vote_up DESC, q.post_date DESC");
	}
	
	function retrieveTopCommentQuotes($usr, $page){
		return retrieveMultipleQuotes($usr, $page, "ORDER BY q.comments DESC, q.vote_up-q.vote_down DESC, q.vote_up DESC, q.post_date DESC");
	}
	
	function retrieveLastsQuotes($usr, $page){
		return retrieveMultipleQuotes($usr, $page, "ORDER BY q.post_date DESC");
	}
	
	function retrieveCustomQuoteList($usr, $tabid){
		$ids = null;
		foreach($tabid as $key => $value){
			if($key == 0){$ids = 'q.id='.$value.'';}
			else{ $ids .= ' OR q.id='.$value.'';}
		}
		
		return retrieveMultipleQuotes($usr, -1, "AND (".$ids.") ORDER BY q.post_date DESC, q.id DESC;");
	}
	
	function retrieveCategoryQuotes($usr, $cat_id, $page){
		return retrieveMultipleQuotes($usr, $page, "AND q.category='".$cat_id."' ORDER BY q.post_date DESC");
	}
	
	function retrieveSelectionQuotes($usr, $sel_id, $page){
		$dbVars = setDbVars();
		return retrieveMultipleQuotes($usr, $page, "AND sq.selection_id='".$sel_id."' ORDER BY q.post_date DESC" , "LEFT OUTER JOIN `".$dbVars['name']."`.`newCQ_selection_quote` sq on q.id=sq.quote_id AND q.service_id=sq.service_id");
	}
	
	function retrieveAuthorQuotes($usr, $auth, $page){
		return retrieveMultipleQuotes($usr, $page, "AND q.author='".$auth."' ORDER BY q.post_date DESC");
	}
	
	// private
	function retrieveMultipleQuotes($usr, $page, $select, $join = ""){
		$dbVars = setDbVars();
		$env = setEnv();
		
		$req = "SELECT q.id, ".format_date('q.`post_date`').", q.quote, q.source, q.context, q.explanation, q.author, q.publisher, q.publisher_info, q.site, c.name as category, q.category as category_id, q.vote_up, q.vote_down, q.comments 
		FROM `".$dbVars['name']."`.`newCQ_quote` q LEFT OUTER JOIN `".$dbVars['name']."`.`newCQ_category` c on q.category=c.id AND q.service_id=c.service_id ".$join."
		WHERE q.quote_state=0 AND q.service_id=".$usr['noService']." ".$select."";
		if($page != -1){$req .= " LIMIT ".($page-1)*$env['quotePageSize'].", ".$env['quotePageSize'].";";}
		
		return getMultipleDataRows($req, $usr);
	}
	
	/*function retrieveLastCommentQuotes($usr, $page){
		$dbVars = setDbVars();
		$env = setEnv();
		
		$req = "SELECT q.id, ".format_date('q.`post_date`').", q.quote, q.source, q.context, q.explanation, q.author, q.publisher, q.publisher_info, q.site, c.name as category, q.category as category_id, q.vote_up, q.vote_down, q.comments 
		FROM `".$dbVars['name']."`.`newCQ_quote` q 
			LEFT OUTER JOIN `".$dbVars['name']."`.`newCQ_category` c on q.category=c.id AND q.service_id=c.service_id
		WHERE q.quote_state=0 AND q.service_id=".$usr['noService']."
		ORDER BY q.comments DESC, q.vote_up-q.vote_down DESC, q.vote_up DESC, q.post_date DESC 
		LIMIT ".($page-1)*$env['quotePageSize'].", ".$env['quotePageSize'].";";
		
		return getMultipleDataRows($req, $usr);
	}*/
		
	function retrieveComments($usr, $elt_type, $elt_id, $page, $textForReportedComments){
		$dbVars = setDbVars();
		$env = setEnv();
		
		$req = "SELECT `id`, ".format_date('`post_date`').", `publisher`, `site`, IF(`comment_state` = 0, `comment`, '".$textForReportedComments."') AS `comment`, `vote_up`, `vote_down`, IF(`comment_state` = 0, 0, 1) AS `reported`
		FROM `".$dbVars['name']."`.`newCQ_comment` 
		WHERE service_id=".$usr['noService']." AND `elt_type`=".$elt_type." AND `elt_id`=".$elt_id."
		ORDER BY `post_date` 
		LIMIT ".($page-1)*$env['commentPageSize'].", ".$env['commentPageSize'].";";
		
		return getMultipleDataRows($req, $usr);
	}
	
	function retrieveCategories($usr, $page){
		$dbVars = setDbVars();
		$env = setEnv();
		
		$req = "SELECT `id`, ".format_date('`post_date`').", `name`
		FROM `".$dbVars['name']."`.`newCQ_category` 
		WHERE service_id=".$usr['noService']."
		ORDER BY `name` 
		LIMIT ".($page-1)*$env['categoryPageSize'].", ".$env['categoryPageSize'].";";
		
		return getMultipleDataRows($req, $usr);
	}
	
	function retrieveSelections($usr, $page){
		$dbVars = setDbVars();
		$env = setEnv();
		
		$req = "SELECT DISTINCT s.`id`, ".format_date('s.`post_date`').", s.`name`
		FROM `".$dbVars['name']."`.`newCQ_selection` s
			INNER JOIN `".$dbVars['name']."`.`newCQ_selection_quote` sq ON s.id=sq.selection_id AND s.service_id=sq.service_id
			INNER JOIN `".$dbVars['name']."`.`newCQ_quote` q ON sq.quote_id=q.id AND s.service_id=q.service_id
		WHERE q.quote_state=0 AND s.service_id=".$usr['noService']."
		ORDER BY s.`name` 
		LIMIT ".($page-1)*$env['selectionPageSize'].", ".$env['selectionPageSize'].";";
		
		return getMultipleDataRows($req, $usr);
	}
	
	function retrieveEltSuivi($usr, $mail){
		$dbVars = setDbVars();
		
		$req = "SELECT elt_type, elt_id FROM `".$dbVars['name']."`.`newCQ_suivi` WHERE service_id=".$usr['noService']." AND mail='".$mail."' AND actif=1 ORDER BY elt_type, elt_id;";
		return getMultipleDataRows($req, $usr);
	}
	
	function retrieveMailForEltUpdate($usr, $elt_type, $elt_id){
		$dbVars = setDbVars();
		
		$req = "SELECT mail FROM `".$dbVars['name']."`.`newCQ_suivi` WHERE service_id=".$usr['noService']." AND elt_type=".ressourceTypeToCode($elt_type)." AND elt_id='".$elt_id."' AND actif=1;";
		return getMultipleDataRows($req, $usr);
	}
	
	function retrieveTotalPages($usr){
		$dbVars = setDbVars();
		$env = setEnv();
		
		$req = "SELECT count(*) as pages FROM `".$dbVars['name']."`.`newCQ_quote` WHERE quote_state=0 AND service_id=".$usr['noService'].";";
		return retrieveCountPages($usr, $req, $env['quotePageSize']);
	}
	
	function retrieveCategoryTotalPages($usr, $cat_id){
		$dbVars = setDbVars();
		$env = setEnv();
		
		$req = "SELECT count(*) as pages FROM `".$dbVars['name']."`.`newCQ_quote` WHERE quote_state=0 AND service_id=".$usr['noService']." AND category='".$cat_id."';";
		return retrieveCountPages($usr, $req, $env['quotePageSize']);
	}
	
	function retrieveSelectionTotalPages($usr, $sel_id){
		$dbVars = setDbVars();
		$env = setEnv();
		
		$req = "SELECT count(*) as pages 
		FROM `".$dbVars['name']."`.`newCQ_selection_quote` sq LEFT OUTER JOIN `".$dbVars['name']."`.`newCQ_quote` q ON sq.quote_id=q.id AND sq.service_id=q.service_id
		WHERE q.quote_state=0 AND sq.service_id=".$usr['noService']." AND sq.selection_id='".$sel_id."';";
		return retrieveCountPages($usr, $req, $env['quotePageSize']);
	}
	
	function retrieveAuthorTotalPages($usr, $auth){
		$dbVars = setDbVars();
		$env = setEnv();
		
		$req = "SELECT count(*) as pages FROM `".$dbVars['name']."`.`newCQ_quote` WHERE quote_state=0 AND service_id=".$usr['noService']." AND author='".$auth."';";
		return retrieveCountPages($usr, $req, $env['quotePageSize']);
	}
	
	function retrieveTotalCommentPages($usr, $elt_type, $elt_id){
		$dbVars = setDbVars();
		$env = setEnv();
		
		$req = "SELECT count(*) as pages FROM `".$dbVars['name']."`.`newCQ_comment` WHERE service_id=".$usr['noService']." AND elt_type=".$elt_type." AND elt_id=".$elt_id.";";
		return retrieveCountPages($usr, $req, $env['commentPageSize']);
	}
	
	function retrieveTotalCategoriesPages($usr){
		$dbVars = setDbVars();
		$env = setEnv();
		
		$req = "SELECT count(*) as pages FROM `".$dbVars['name']."`.`newCQ_category` WHERE service_id=".$usr['noService'].";";
		return retrieveCountPages($usr, $req, $env['categoryPageSize']);
	}
	
	function retrieveTotalSelectionsPages($usr){
		$dbVars = setDbVars();
		$env = setEnv();
		
		$req = "SELECT count(*) as pages FROM `".$dbVars['name']."`.`newCQ_selection` WHERE service_id=".$usr['noService'].";";
		return retrieveCountPages($usr, $req, $env['selectionPageSize']);
	}
	
	function retrieveKeyCptCount($usr){
		$dbVars = setDbVars();
		
		$req = "SELECT `last_reset`, `cpt`, `max_cpt`, `reset_time` FROM `".$dbVars['name']."`.`newCQ_key_cpt` WHERE `key`='".$usr['key']."' LIMIT 1;";
		return getUniqueDataRow($req, $usr);
	}
	
	function retrieveCategoryId($usr, $category_name){
		$dbVars = setDbVars();
		
		$req = "SELECT id FROM `".$dbVars['name']."`.`newCQ_category` WHERE service_id=".$usr['noService']." AND name='".$category_name."' LIMIT 1;";
		return getSingleData($usr, $req, 'id');
	}
	
	function retrieveCategoryName($usr, $category_id){
		$dbVars = setDbVars();
		
		$req = "SELECT name FROM `".$dbVars['name']."`.`newCQ_category` WHERE service_id=".$usr['noService']." AND id='".$category_id."' LIMIT 1;";
		return getSingleData($usr, $req, 'name');
	}
	
	function retrieveSelectionId($usr, $sel){
		$dbVars = setDbVars();
		
		$req = "SELECT id FROM `".$dbVars['name']."`.`newCQ_selection` WHERE service_id=".$usr['noService']." AND name='".$sel."' LIMIT 1;";
		return getSingleData($usr, $req, 'id');
	}
	
	function retrieveSelectionName($usr, $sel_id){
		$dbVars = setDbVars();
		
		$req = "SELECT name FROM `".$dbVars['name']."`.`newCQ_selection` WHERE service_id=".$usr['noService']." AND id='".$sel_id."' LIMIT 1;";
		return getSingleData($usr, $req, 'name');
	}
	
	function retrieveNewId($usr, $tableName){
		$dbVars = setDbVars();
		$fieldName = str_replace("newCQ", "id", $tableName);
		$req = "SELECT `".$fieldName."` FROM `".$dbVars['name']."`.`newCQ_id_increment` WHERE `service_id`='".$usr['noService']."';";
		$newId = getSingleData($usr, $req, $fieldName, 0);
		
		if($newId == null){
			persistFatalErrorLog($usr, "retrieve.php : retrieveNewId() : newId not found => Probably wrong tableName : ($tableName)."); // Ne dois jamais entrer ici !!!
			return null;
		}
		else{
			$newId = $newId+1;
			$req = "UPDATE `".$dbVars['name']."`.`newCQ_id_increment` SET `".$fieldName."`=".$newId.";";
			query($req, $usr);
			return $newId;
		}
	}
	
	function retrieveLastId($usr, $tableName){
		$dbVars = setDbVars();
		$fieldName = str_replace("newCQ", "id", $tableName);
		
		$req = "SELECT `".$fieldName."` FROM `".$dbVars['name']."`.`newCQ_id_increment` WHERE service_id=".$usr['noService'].";";
		return getSingleData($usr, $req, $fieldName);
	}
	
	function retireveIsCorrectDbVersion($usr){
		$dbVars = setDbVars();
		dbConnect();
		
		$env = setEnv();
		
		$req = "SELECT ".$env['BDDversion']." FROM `".$dbVars['name']."`.`newCQ_info` LIMIT 1;";
		$res = getSingleData($usr, $req, $env['BDDversion'], 0);
		if($res == null){
			$req = "INSERT INTO `".$dbVars['name']."`.`newCQ_info` (`".$env['BDDversion']."`) VALUES ('1');";
			$res = query($req, $usr);
		}
		else{
			$res = true;
		}
		
		unset($req);
		dbDisconnect();
		if($res == true){return true;}
		else{return false;}
	}
	
	
?>
