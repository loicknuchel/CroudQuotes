<?phpfunction realDeleteComment($usr, $id, $page, $delete = false){	$requeteDone = '';		$req = 'SELECT * FROM newcq_comment WHERE `service_id`='.$usr['noService'].' AND id='.$id.' LIMIT 1;';	$res = query($req, $usr);	if($res != null && mysql_num_rows($res) != 0){		$commentVal = mysql_fetch_array($res, MYSQL_ASSOC);				if(codeToRessourceType($commentVal['elt_type']) == 'quote'){ // diminution du compteur de la citation			$req = "UPDATE `newCQ_quote` SET comments=comments-1 WHERE `service_id`='".$commentVal['service_id']."' AND id=".$commentVal['elt_id'].";";			if($delete == true){query($req, $usr);}			$requeteDone .= $req.'<br/>';		}		if($commentVal['vote_up'] != 0 || $commentVal['vote_down'] != 0){ // suppression des votes pour ce commentaire			$req = "DELETE FROM newCQ_vote WHERE service_id='".$commentVal['service_id']."' AND elt_type=3 AND elt_id='".$id."';";			if($delete == true){query($req, $usr);}			$requeteDone .= $req.'<br/>';		}		if($commentVal['reported'] != 0){ // suppression des signalements pour ce commentaire			$req = "DELETE FROM newcq_reported WHERE service_id='".$commentVal['service_id']."' AND elt_type=3 AND elt_id='".$id."';";			if($delete == true){query($req, $usr);}			$requeteDone .= $req.'<br/>';		}		$req = "DELETE FROM newcq_comment WHERE service_id='".$commentVal['service_id']."' AND id='".$id."';";		if($delete == true){query($req, $usr);}		$requeteDone .= $req.'<br/>';			}		return $requeteDone;}function realDeletQuote($usr, $id, $page, $delete = false){	$requeteDone = '';		$req = 'SELECT * FROM newcq_quote WHERE `service_id`='.$usr['noService'].' AND id='.$id.' LIMIT 1;';	$res = query($req, $usr);	if($res != null && mysql_num_rows($res) != 0){		$commentVal = mysql_fetch_array($res, MYSQL_ASSOC);						if($commentVal['comments'] != 0){ // suppression des commentaires pour cette citation			$req = 'SELECT id FROM newcq_comment WHERE `service_id`='.$usr['noService'].' AND elt_type=2 AND elt_id='.$id.';';			$res = query($req, $usr);			if($res == null || mysql_num_rows($res) != $commentVal['comments']){				$requeteDone = 'Incohérence dans le nombre de commentaires !!!<br/>Veuillez corriger cette erreur avant de supprimer la citation !';			}			else{				while($ret = mysql_fetch_array($res, MYSQL_ASSOC)){					$requeteDone .= realDeleteComment($usr, $ret['id'], $page, $delete);				}			}		}		if($commentVal['vote_up'] != 0 || $commentVal['vote_down'] != 0){ // suppression des votes pour cette citation			$req = "DELETE FROM newCQ_vote WHERE service_id='".$commentVal['service_id']."' AND elt_type=2 AND elt_id='".$id."';";			if($delete == true){query($req, $usr);}			$requeteDone .= $req.'<br/>';		}		if($commentVal['reported'] != 0){ // suppression des signalements pour cette citation			$req = "DELETE FROM newcq_reported WHERE service_id='".$commentVal['service_id']."' AND elt_type=2 AND elt_id='".$id."';";			if($delete == true){query($req, $usr);}			$requeteDone .= $req.'<br/>';		}				$req = "DELETE FROM newcq_suivi WHERE service_id='".$commentVal['service_id']."' AND elt_type=2 AND elt_id='".$id."';";		if($delete == true){query($req, $usr);}		$requeteDone .= $req.'<br/>';				$req = "DELETE FROM newcq_category_quote WHERE service_id='".$commentVal['service_id']."' AND quote_id='".$id."';";		if($delete == true){query($req, $usr);}		$requeteDone .= $req.'<br/>';				$req = "DELETE FROM newcq_selection_quote WHERE service_id='".$commentVal['service_id']."' AND quote_id='".$id."';";		if($delete == true){query($req, $usr);}		$requeteDone .= $req.'<br/>';				$req = "DELETE FROM newcq_quote WHERE service_id='".$commentVal['service_id']."' AND id='".$id."';";		if($delete == true){query($req, $usr);}		$requeteDone .= $req.'<br/>';			}		return $requeteDone;}?>