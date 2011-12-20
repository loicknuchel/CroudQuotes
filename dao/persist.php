<?php	include_once $rel.'dao/connectDb.php';	include_once $rel.'dao/mysqlUtils.php';	include_once $rel.'dao/retrieveUtils.php';	include_once $rel.'globals/env.php';		function persistQuote($usr, $int_ip, $quote, $src, $ctx, $expl, $auth, $pub, $pubinfo, $mail, $site, $cat_id, &$quoteid){		$dbVars = setDbVars(getStatus());		dbConnect();				$newId = retrieveNewId($usr, 'newCQ_quote');		$req = "INSERT INTO `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."quote` (`service_id`, `id`, `post_ip`, `quote`, `origin_quote`, `source`, `context`, `explanation`, `origin_explanation`, `author`, `publisher`, `publisher_info`, `mail`, `site`, `category`, `last_activity`) VALUES 		('".$usr['noService']."','".$newId."','".$int_ip."','".$quote."','".$quote."', ".nullSafe($src).", ".nullSafe($ctx).", ".nullSafe($expl).", ".nullSafe($expl).", ".nullSafe($auth).", ".nullSafe($pub).", ".nullSafe($pubinfo).", ".nullSafe($mail).", ".nullSafe($site).", ".nullSafe($cat_id).",NULL);";		$res = query($req, $usr);		if($res == true){$quoteid = $newId;}		else{$quoteid = null;}				if($res == true){			persistHistoryValue($usr, $int_ip, 2, $newId, 20, $pub, $mail, $site, $quote);			if($expl != null){				persistHistoryValue($usr, $int_ip, 2, $newId, 21, $pub, $mail, $site, $expl);			}			if($cat_id != null){				$res = realPersistQuoteCategory($usr, $int_ip, $quoteid, $cat_id, 5, $newcategoryid);			}		}				unset($req);		dbDisconnect();		if($res == true){ return 200; }		else{ return 403; }	}		function persistRephraseQuote($usr, $int_ip, $quoteid, $quote, $expl, $pub, $mail, $site){		$dbVars = setDbVars(getStatus());		dbConnect();				$ret1 = persistHistoryValue($usr, $int_ip, 2, $quoteid, 20, $pub, $mail, $site, $quote);		if($expl != null){			$ret2 = persistHistoryValue($usr, $int_ip, 2, $quoteid, 21, $pub, $mail, $site, $expl);		}		else {$ret2 = true;}				if($ret1 == true && $ret2 == true){			$req = "UPDATE `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."quote` SET `quote`=".nullSafe($quote).", `explanation`=".nullSafe($expl).", `last_activity`=null WHERE `service_id`='".$usr['noService']."' AND id=".$quoteid.";";			$res = query($req, $usr);		}		else{$res = false;}				unset($req);		dbDisconnect();		if($res == true){ return 200; }		else{ return 403; }	}		function persistCategory($usr, $int_ip, $name, &$categoryid){		$dbVars = setDbVars(getStatus());		dbConnect();				$newId = retrieveNewId($usr, 'newCQ_category');		$req = "INSERT INTO `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."category` (`service_id`, `id`, `post_ip`, `name`) VALUES ('".$usr['noService']."','".$newId."','".$int_ip."','".$name."');";		$res = query($req, $usr);		if($res == true){$categoryid = $newId;}		else{$categoryid = null;}				unset($req);		dbDisconnect();		if($res == true){ return 200; }		else{ return 403; }	}		function persistQuoteCategory($usr, $int_ip, $quoteid, $categoryid, $value, &$newcategoryid){		dbConnect();				$res = realPersistQuoteCategory($usr, $int_ip, $quoteid, $categoryid, $value, $newcategoryid);				unset($req);		dbDisconnect();		if($res == true){ return 200; }		else{ return 403; }	}		// private	function realPersistQuoteCategory($usr, $int_ip, $quoteid, $categoryid, $value, &$newcategoryid){		$dbVars = setDbVars(getStatus());		$req = "INSERT INTO `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."category_quote` (`service_id`, `post_ip`, `quote_id`, `category_id`, `value`) VALUES ('".$usr['noService']."','".$int_ip."','".$quoteid."','".$categoryid."','".$value."');";		$res = query($req, $usr);		if($res != true){			$req = "UPDATE `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."category_quote` SET `category_id`='".$categoryid."' WHERE `service_id`='".$usr['noService']."' AND `post_ip`='".$int_ip."' AND `quote_id`='".$quoteid."';";			$res = query($req, $usr);		}				$req = "SELECT category_id FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."category_quote` WHERE `service_id`='".$usr['noService']."' AND quote_id='".$quoteid."' GROUP BY category_id ORDER BY sum(`value`) DESC, category_id LIMIT 1;";		$res = query($req, $usr);		if($res == null || mysql_num_rows($res) == 0){ $newcategoryid = null; }		else{			$ret = mysql_fetch_array($res, MYSQL_ASSOC);			$newcategoryid = $ret['category_id'];			$req = "UPDATE `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."quote` SET category=".$newcategoryid." WHERE `service_id`='".$usr['noService']."' AND id='".$quoteid."';";			$res = query($req, $usr);		}				return $res;	}		// private	function persistHistoryValue($usr, $int_ip, $elt_type, $elt_id, $elt_field, $pub, $mail, $site, $content, $connect = false){		$dbVars = setDbVars(getStatus());		if($connect == true){dbConnect();}				$req = "INSERT INTO `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."history` (`service_id`, `elt_type`, `elt_id`, `elt_field`, `post_ip`, `publisher`, `mail`, `site`, `content`) VALUES		('".$usr['noService']."','".$elt_type."','".$elt_id."','".$elt_field."','".$int_ip."',".nullSafe($pub).",".nullSafe($mail).",".nullSafe($site).",".nullSafe($content).");";		$res = query($req, $usr);				unset($req);		if($connect == true){dbDisconnect();}		return $res;	}		function persistQuoteComment($usr, $int_ip, $quoteid, $i_avis, $publisher, $mail, $site, $comment, &$commentid){		$dbVars = setDbVars(getStatus());		dbConnect();				$req = "SELECT post_ip FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."quote` WHERE `service_id`='".$usr['noService']."' AND id=".$quoteid." AND quote_state=0;"; // verification que la quote demandée existe vraiment !		$res = query($req, $usr);		if(mysql_num_rows($res) == 1){			$ret = persistComment($usr, $int_ip, 'quote', $quoteid, $i_avis, $publisher, $mail, $site, $comment, $commentid, false);						if($ret == 200){				$res = true;				$req = "UPDATE `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."quote` SET comments=comments+1, `last_activity`=null WHERE `service_id`='".$usr['noService']."' AND id=".$quoteid.";";				$res = query($req, $usr);			}			else{				$res = false;			}		}		else{			return 404;		}				unset($req);		dbDisconnect();		if($res == true){ return 200; }		else{ return 403; }	}		function persistComment($usr, $int_ip, $elt_type, $elt_id, $i_avis, $publisher, $mail, $site, $comment, &$commentid, $connect = true){		$dbVars = setDbVars(getStatus());		if($connect == true){dbConnect();}				$newId = retrieveNewId($usr, 'newCQ_comment');		$req = "INSERT INTO `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."comment` (`service_id`, `id`, `post_ip`, `elt_type`, `elt_id`, `avis`, `publisher`, `mail`, `site`, `comment`) VALUES 		('".$usr['noService']."','".$newId."','".$int_ip."','".ressourceTypeToCode($elt_type)."','".$elt_id."','".$i_avis."','".$publisher."',".nullSafe($mail).",".nullSafe($site).",'".$comment."');";		$res = query($req, $usr);		if($res == true){$commentid = $newId;}		else{$commentid = null;}				unset($req);		if($connect == true){dbDisconnect();}		if($res == true){ return 200; }		else{ return 403; }	}		function persistVote($usr, $int_ip, $type, $id, $vote){		$dbVars = setDbVars(getStatus());		dbConnect();				if($type == "quote"){			$voted_table = "`".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."quote`";			$report_table_state_col = 'quote_state';		}		else if($type == "comment"){			$voted_table = "`".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."comment`";			$report_table_state_col = 'comment_state';		}		else{			return 400;		}		$elt_type = ressourceTypeToCode($type);				if($vote == "down"){$vote = 0;}		else if($vote == "up"){$vote = 1;}		else{return 400;}				$req = "SELECT post_ip FROM ".$voted_table." WHERE `service_id`='".$usr['noService']."' AND id=".$id." AND ".$report_table_state_col."=0;"; // vérification que le quote ou le comment existe !		$res = query($req, $usr);		if(mysql_num_rows($res) == 1){			$req = "INSERT INTO `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."vote` (`service_id`, `post_ip`, `elt_type`, `elt_id`, `vote`)VALUES ('".$usr['noService']."','".$int_ip."','".$elt_type."','".$id."','".$vote."');";			$res = query($req, $usr);			if($res == true){				if($vote == 0){					$req = "UPDATE ".$voted_table." SET vote_down=vote_down+1 WHERE `service_id`='".$usr['noService']."' AND id=".$id.";";				}				else{					$req = "UPDATE ".$voted_table." SET vote_up=vote_up+1 WHERE `service_id`='".$usr['noService']."' AND id=".$id.";";				}				$res = query($req, $usr);			}			else{				return 406;			}		}		else{			return 404;		}				unset($req);		dbDisconnect();		if($res == true){ return 200; }		else{ return 403; }	}		function persistReport($usr, $int_ip, $type, $id, $cause = null, &$deleted){		$dbVars = setDbVars(getStatus());		$env = setEnv();		dbConnect();				if($type == "quote"){			$reported_table = "`".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."quote`";			$report_table_state_col = 'quote_state';		}		else if($type == "comment"){			$reported_table = "`".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."comment`";			$report_table_state_col = 'comment_state';		}		else{			return 400;		}		$elt_type = ressourceTypeToCode($type);				$req = "SELECT post_ip FROM ".$reported_table." WHERE `service_id`='".$usr['noService']."' AND id=".$id." AND ".$report_table_state_col."=0;"; // vérification que le quote ou le comment existe !		$res = query($req, $usr);		if(mysql_num_rows($res) == 1){			$req = "INSERT INTO `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."reported` (`service_id`, `post_ip`, `elt_type`, `elt_id`, `cause`)VALUES ('".$usr['noService']."','".$int_ip."','".$elt_type."','".$id."',".nullSafe($cause).");";			$res = query($req, $usr);			if($res == true){				$req = "SELECT reported FROM ".$reported_table." WHERE `service_id`='".$usr['noService']."' AND id=".$id." LIMIT 1;";				$nb_report = getSingleData($usr, $req, 'reported', 0);								if($nb_report >= $env['nbReportBeforeDelete'] - 1){					$deleted = 1;					$req = "UPDATE ".$reported_table." SET reported=reported+1, ".$report_table_state_col."=1 WHERE `service_id`='".$usr['noService']."' AND id=".$id.";";				}				else{					$deleted = 0;					$req = "UPDATE ".$reported_table." SET reported=reported+1 WHERE `service_id`='".$usr['noService']."' AND id=".$id.";";				}				$res = query($req, $usr);			}			else{				return 406;			}		}		else{			return 404;		}				unset($req);		dbDisconnect();		if($res == true){ return 200; }		else{ return 403; }	}		function persistSelection($usr, $int_ip, $sel, &$sel_id){		$dbVars = setDbVars(getStatus());		dbConnect();				$newId = retrieveNewId($usr, 'newCQ_selection');		$req = "INSERT INTO `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."selection` (`service_id`, `id`, `post_ip`, `name`)VALUES ('".$usr['noService']."','".$newId."','".$int_ip."','".$sel."');";		$res = query($req, $usr);		if($res == true){$sel_id = $newId;}		else{$sel_id = null;}				unset($req);		dbDisconnect();		if($res == true){ return 200; }		else{ return 403; }	}		function persistSelectionQuotes($usr, $tabquoteids, $sel_id){		$dbVars = setDbVars(getStatus());		dbConnect();				foreach($tabquoteids as $key => $value){			$req = "INSERT INTO `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."selection_quote` (`service_id`, `quote_id`, `selection_id`)VALUES ('".$usr['noService']."','".$value."','".$sel_id."');";			$res = query($req, $usr);			/*if($res != true){ // si l'ajout d'une quote dans une sélection échoue, on supprime toute la sélection ????				$req = "DELETE FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."selection_quote` WHERE `service_id`='".$usr['noService']."' AND selection_id=".$sel_id."";				query($req, $usr);				$req = "DELETE FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."selection` WHERE `service_id`='".$usr['noService']."' AND id=".$sel_id."";				query($req, $usr);				$res = false;				break;			}*/		}				unset($req);		dbDisconnect();		return 200;	}		function persistSuivi($usr, $int_ip, $mail, $name, $info, $type, $id, $actions){		$dbVars = setDbVars(getStatus());		dbConnect();				$elt_type = ressourceTypeToCode($type);		if($elt_type == null){return 400;}				$req = "INSERT INTO `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."suivi` (`service_id`, `post_ip`, `elt_type`, `elt_id`, `mail`, `name`, `info`, `actif`)VALUES ('".$usr['noService']."','".$int_ip."','".$elt_type."','".$id."','".$mail."',".nullSafe($name).",".nullSafe($info).",'".actionTocode($actions['action'])."');";		$res = query($req, $usr);		if($res != true){			$req = "UPDATE `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."suivi` SET `info`=".nullSafe($info).", `name`=".nullSafe($name).", `actif`='".actionTocode($actions['action'])."', `post_ip`='".$int_ip."', `post_date`=NULL WHERE `service_id`='".$usr['noService']."' AND `elt_type`='".$elt_type."' AND `elt_id`='".$id."' AND `mail`='".$mail."';";			$res = query($req, $usr);		}				unset($req);		dbDisconnect();		if($res == true){ return 200; }		else{ return 403; }	}		function persistSignPetition($usr, $int_ip, $type, $id, $mail, $prenom, $nom, $genre, $i_age, $site, $profession, $zipcode, $message, $confirmCode){		$dbVars = setDbVars(getStatus());		dbConnect();				$elt_type = ressourceTypeToCode($type);		if($elt_type == null){return 400;}				$req = "SELECT sign_no FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."petition` WHERE `service_id`=".$usr['noService']." AND `elt_type`=".$elt_type." AND `elt_id`=".$id." AND `mail`='".$mail."' LIMIT 1;";		$sign_present = getSingleData($usr, $req, 'sign_no', 0);		if($sign_present == null){ // si la signature n'est pas déjà présente			if($type == 'quote'){				$req = "SELECT id FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."quote` WHERE `service_id`=".$usr['noService']." AND `id`=".$id.";";				$quote_present = getSingleData($usr, $req, 'id', 0);			}						if($type != 'quote' || $quote_present != null){				$req = "SELECT sign_no FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."petition` WHERE `service_id`=".$usr['noService']." AND `elt_type`=".$elt_type." AND `elt_id`=".$id." ORDER BY `sign_no` DESC LIMIT 1;";				$sign_no = getSingleData($usr, $req, 'sign_no', 0);				if($sign_no == null){$sign_no = 0;}				$sign_no++;								$req = "INSERT INTO `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."petition` (`service_id`, `sign_no`, `post_ip`, `elt_type`, `elt_id`, `genre`, `prenom`, `nom`, `mail`, `site`, `age`, `profession`, `code_postal`, `message`, `validation_key`)VALUES ('".$usr['noService']."','".$sign_no."','".$int_ip."','".$elt_type."','".$id."',".nullSafe(genreToCode($genre)).",'".$prenom."','".$nom."','".$mail."',".nullSafe($site).",".nullSafe($i_age).",".nullSafe($profession).",".nullSafe($zipcode).",".nullSafe($message).",'".$confirmCode."');";				$res = query($req, $usr);				if($res == true){ $ret = 200; }				else{ $ret = 403; }			}			else{				$ret = 404;			}		}		else{			$ret = 406;		}				unset($req);		dbDisconnect();		return $ret;	}		function persistValidPetition($usr, $confirmCode){		$dbVars = setDbVars(getStatus());				$req = "SELECT id, elt_type, elt_id, etat FROM `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."petition` WHERE `service_id`='".$usr['noService']."' AND `validation_key`='".$confirmCode."' LIMIT 1;";		$row = getUniqueDataRow($req, $usr);				dbConnect();				if($row != null && $row['etat'] == 1){			$req = "UPDATE `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."petition` SET `etat`=2 WHERE `service_id`='".$usr['noService']."' AND `id`=".$row['id'].";";			$res = query($req, $usr);						if($res == true && $row['elt_type'] == 2){				$req = "UPDATE `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."quote` SET signatures=signatures+1 WHERE `service_id`='".$usr['noService']."' AND id=".$row['elt_id'].";";				$res = query($req, $usr);			}		}		else{			$res = false;		}				unset($req);		dbDisconnect();		if($res == true){ return 200; }		else if($row['etat'] != 1) { return 406; }		else{ return 403; }	}		function persistApiLogs($usr, $int_ip, $user_agent, $call, &$logid){		$dbVars = setDbVars(getStatus());		dbConnect();				$req = "INSERT INTO `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."api_log` (`service_id`, `call_ip`, `call_key`, `call_user_agent`, `call`)VALUES ('".$usr['noService']."','".$int_ip."','".$usr['key']."','".$user_agent."','".$call."');";		$args['persistLog'] = false;		$args['displayReq'] = false;		$res = query($req, $usr, $args);		if($res == true){$logid = mysql_insert_id();}		else{$logid = null;}				unset($req);		dbDisconnect();		if($res == true){ return 200; }		else{ return 403; }	}		function persistCreateKeyCpt($usr, $type, $timestamp){		$dbVars = setDbVars(getStatus());		$env = setEnv();		dbConnect();				$req = "INSERT INTO `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."key_cpt` (`service_id`, `no`, `type`, `key`, `last_reset`, `max_cpt`, `reset_time`)		VALUES ('".$usr['noService']."',null,'".$type."','".$usr['key']."','".$timestamp."','".$env['allowedReqPerTime']."','".$env['reqResetTime']."');";		$args['persistLog'] = false;		$args['displayReq'] = false;		$res = query($req, $usr, $args);				unset($req);		dbDisconnect();		if($res == true){ return 200; }		else{ return 403; }	}		function persistResetKeyCpt($usr, $timestamp){		$dbVars = setDbVars(getStatus());		dbConnect();				$req = "UPDATE `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."key_cpt` SET `last_reset`='".$timestamp."', `cpt`='1' WHERE `key`='".$usr['key']."';";		$args['persistLog'] = false;		$args['displayReq'] = false;		$res = query($req, $usr, $args);				unset($req);		dbDisconnect();		if($res == true){ return 200; }		else{ return 403; }	}		function persistIncKeyCpt($usr){		$dbVars = setDbVars(getStatus());		dbConnect();				$req = "UPDATE `".$dbVars['DbName']."`.`".$dbVars['DbPrefix']."key_cpt` SET `cpt`=`cpt`+1 WHERE `key`='".$usr['key']."';";		$args['persistLog'] = false;		$args['displayReq'] = false;		$res = query($req, $usr, $args);				unset($req);		dbDisconnect();		if($res == true){ return 200; }		else{ return 403; }	}	?>