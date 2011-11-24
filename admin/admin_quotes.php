<?php	$server_link = '../';	$rel = $server_link;	$page = './admin_quotes.php';	include_once 'delete_fonc.php';	include_once $server_link.'dao/connectDb.php';	include_once $server_link.'dao/mysqlUtils.php';	include_once $server_link.'filtres/filtre.php';	include_once $server_link.'private_datas/filtre_fonc.php';	include_once $server_link.'utils/convertVars.php';		$usr = null;	$usr['adminkey'] = isset($_GET['adminkey']) ? $_GET['adminkey'] : null;	filtreAdmin($usr); // exit if incorrect		$dbVars = setDbVars();	dbConnect();		if(isset($_GET['unreport']) && is_numeric($_GET['unreport'])){		$id = (int) $_GET['unreport'];		$req = "UPDATE `".$dbVars['name']."`.`newCQ_quote` SET quote_state=0 WHERE service_id=".$usr['noService']." AND id=".$id.";";		$res = query($req, $usr);		if($res == true){			$html = '<tr><td>quote '.$id.' unreported !</td><td><a href="'.$page.'?adminkey='.$usr['adminkey'].'">ok</a></td>			</tr><tr><td>action : '.$req.'</td></tr><tr><td>Undo action : UPDATE `'.$dbVars['name'].'`.`newCQ_quote` SET quote_state=1 WHERE service_id='.$usr['noService'].' AND id='.$id.';</td></tr>';		}		else{			$html = '<tr><td>fail unreport quote '.$id.' !!!!!!!</td><td><a href="'.$page.'?adminkey='.$usr['adminkey'].'">ok</a></td><td>'.$req.'</td></tr>';		}			}	else if(isset($_GET['delete']) && is_numeric($_GET['delete'])){		$id = (int) $_GET['delete'];		$req = "UPDATE `".$dbVars['name']."`.`newCQ_quote` SET quote_state=2 WHERE service_id=".$usr['noService']." AND id=".$id.";";		$res = query($req, $usr);		if($res == true){			$html = '<tr><td>quote '.$id.' deleted !</td><td><a href="'.$page.'?adminkey='.$usr['adminkey'].'">ok</a></td>			</tr><tr><td>action : '.$req.'</td></tr><tr><td>Undo action : UPDATE `'.$dbVars['name'].'`.`newCQ_quote` SET quote_state=1 WHERE service_id='.$usr['noService'].' AND id='.$id.';</td></tr>';		}		else{			$html = '<tr><td>fail delete quote '.$id.' !!!!!!!</td><td><a href="'.$page.'?adminkey='.$usr['adminkey'].'">ok</a></td><td>'.$req.'</td></tr>';		}	}	else if(isset($_GET['causes']) && is_numeric($_GET['causes'])){		$id = (int) $_GET['causes'];		$title = 'causes for quote '.$id.'';		$req = "SELECT * FROM `".$dbVars['name']."`.`newCQ_reported_quote` WHERE service_id=".$usr['noService']." AND quote_id=".$id.";";		$res = query($req, $usr);		if($res != null && mysql_num_rows($res) != 0){			$html = '<tr>				<th>id</th>				<th>ip</th>				<th>date</th>				<th>cause</th>				<td><a href="'.$page.'?adminkey='.$usr['adminkey'].'">retour</a></td>			</tr>';			while($ret = mysql_fetch_array($res, MYSQL_ASSOC)){				$html .= '<tr>					<td>'.$ret['id'].'</td>					<td>'.inttoip($ret['post_ip']).'</td>					<td>'.$ret['post_date'].'</td>					<td>'.utf8_encode($ret['cause']).'</td>				</tr>';			}		}		else{			$html = '<tr><td>ERREUR : pas de report pour la quote '.$id.' !!!</td></tr>';		}	}	else{		if(isset($_GET['show_deleted']) && $_GET['show_deleted'] == 1){			$title = "DELETED quotes :";			$req = "SELECT * FROM `".$dbVars['name']."`.`newCQ_quote` WHERE service_id=".$usr['noService']." AND quote_state=2;";		}		else{			$req = "SELECT * FROM `".$dbVars['name']."`.`newCQ_quote` WHERE service_id=".$usr['noService']." AND quote_state=1;";		}				$res = query($req, $usr);		if($res != null && mysql_num_rows($res) != 0){			$html = "<tr>				<th>id</th>				<th>quote</th>				<th>src</th>				<th>ctx</th>				<th>expl</th>				<th>auth</th>				<th>pub</th>				<th>mail</th>				<th>site</th>				<th>up</th>				<th>down</th>				<th>comments</th>				<th>reported</th>			</tr>";			while($ret = mysql_fetch_array($res, MYSQL_ASSOC)){				$html .= '<tr>					<td>'.$ret['id'].'</td>					<td>'.utf8_encode($ret['quote']).'</td>					<td>'.utf8_encode($ret['source']).'</td>					<td>'.utf8_encode($ret['context']).'</td>					<td>'.utf8_encode($ret['explanation']).'</td>					<td>'.utf8_encode($ret['author']).'</td>					<td>'.utf8_encode($ret['publisher']).'</td>					<td>'.utf8_encode($ret['mail']).'</td>					<td>'.utf8_encode($ret['site']).'</td>					<td>'.$ret['vote_up'].'</td>					<td>'.$ret['vote_down'].'</td>					<td>'.$ret['comments'].'</td>					<td>'.$ret['reported'].'</td>					<td> <a href="'.$page.'?adminkey='.$usr['adminkey'].'&causes='.$ret['id'].'">causes</a> </td>					<td> <a href="'.$page.'?adminkey='.$usr['adminkey'].'&unreport='.$ret['id'].'">unreport</a> </td>					<td> <a href="'.$page.'?adminkey='.$usr['adminkey'].'&delete='.$ret['id'].'">delete</a> </td>				</tr>';			}						if(isset($_GET['show_deleted']) && $_GET['show_deleted'] == 1){				$html .= '<tr><td></td><td><a href="'.$page.'?adminkey='.$usr['adminkey'].'">retour</a></td></tr>';			}			else{				$html .= '<tr><td></td><td><a href="'.$page.'?adminkey='.$usr['adminkey'].'&show_deleted=1">show deleted</a></td></tr>';			}		}		else{			$html = '<tr><td>Pas de quotes à modérer</td></tr>';			if(isset($_GET['show_deleted']) && $_GET['show_deleted'] == 1){				$html .= '<tr><td><a href="'.$page.'?adminkey='.$usr['adminkey'].'">retour</a></td></tr>';			}			else{				$html .= '<tr><td><a href="'.$page.'?adminkey='.$usr['adminkey'].'&show_deleted=1">show deleted</a></td></tr>';			}		}	}					$RealDeleteQuote = '';	if(isset($_GET['realdelete']) && is_numeric($_GET['realdelete'])){		$id = (int) $_GET['realdelete'];		$req = 'SELECT * FROM newcq_quote WHERE `service_id`='.$usr['noService'].' AND id='.$id.' LIMIT 1;';		$res = query($req, $usr);		if($res != null && mysql_num_rows($res) != 0){			$ret = mysql_fetch_array($res, MYSQL_ASSOC);			$RealDeleteQuote = "Suppression de la citation ".$id." ? 			<a href=\"".$page."?adminkey=".$usr['adminkey']."&realdeleteok=".$id."\">Oui, supprimer !</a>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;			<a href=\"".$page."?adminkey=".$usr['adminkey']."\">Non, ne pas supprimer !</a><br/>			Service: ".$ret['service_id']."<br/>			publisher: ".$ret['publisher']." / mail: ".$ret['mail']."<br/>			Content: <b>".$ret['quote']."</b><br/>			Catégorie: ".$ret['category']."<br/>			Votes: ".$ret['vote_up']." up et ".$ret['vote_down']." down<br/>			Commentaires: ".$ret['comments']."<br/>			Reported ".$ret['reported']." fois. Etat: ".$ret['quote_state']."<br/>			<br/>			Requêtes a effectuer en cas de suppression :<br/>			".realDeletQuote($usr, $id, $page, false)."			";		}		else{			$RealDeleteQuote = "La citation ".$id." n'a pas été trouvé !!!<br/>";		}	}	else if(isset($_GET['realdeleteok']) && is_numeric($_GET['realdeleteok'])){		$id = (int) $_GET['realdeleteok'];		$res = realDeletQuote($usr, $id, $page, true);		if($res != ''){			$RealDeleteComment = 'Citation no '.$id.' supprimé !!!<br/>Requêtes effectuées :<br/>'.$res.'<a href="'.$page.'?adminkey='.$usr['adminkey'].'">OK</a><br/>';		}		else{			$RealDeleteComment = "La citation ".$id." n'a pas été trouvé !!!<br/>";		}	}		unset($req);	dbDisconnect();?><!doctype html><head>	<meta charset="UTF-8">	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">		<title>Reported quotes</title>	<meta name="description" content="">	<meta name="author" content="">		<meta name="viewport" content="width=device-width, initial-scale=1.0">	<style>	td, th{		border:solid 1px black;		text-align: center;	}	table{		border-collapse:collapse;	}	</style></head><body>	<?php		echo 'Service : '.$usr['noService'].'. '.getServiceName($usr['noService']).'<br/>';		if(isset($title)){echo '<h1>'.$title.'</h1>';}		echo '<table>'.$html.'</table>		<br/>		Real delete quote : <form method="GET">			<input type="hidden" name="adminkey" value="'.$usr['adminkey'].'" />			<input type="text" name="realdelete" placeholder="Quote Id" />			<input type="submit" value="delete !" />		</form>		'.$RealDeleteQuote.'		<br/>';	?>	<a href="./?adminkey=<?php echo $_GET['adminkey']; ?>"><= retour index</a></body></html>