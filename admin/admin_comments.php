<?php
	$server_link = '../';
	$rel = $server_link;
	$page = './admin_comments.php';
	include_once $server_link.'dao/connectDb.php';
	include_once $server_link.'dao/mysqlUtils.php';
	include_once $server_link.'filtres/filtre.php';
	include_once $server_link.'private_datas/filtre_fonc.php';
	include_once $server_link.'globals/conventions.php';
	include_once $server_link.'utils/convertVars.php';
	
	$usr = null;
	$usr['adminkey'] = isset($_GET['adminkey']) ? $_GET['adminkey'] : null;
	filtreAdmin($usr); // exit if incorrect
	
	$dbVars = setDbVars();
	dbConnect();
	
	if(isset($_GET['unreport']) && is_numeric($_GET['unreport'])){
		$id = (int) $_GET['unreport'];
		$req = "UPDATE `".$dbVars['name']."`.`newCQ_comment` SET comment_state=0 WHERE service_id=".$usr['noService']." AND id=".$id.";";
		$res = query($req, $usr);
		if($res == true){
			$html = '<tr><td>comment '.$id.' unreported !</td><td><a href="'.$page.'?adminkey='.$usr['adminkey'].'">ok</a></td>
			</tr><tr><td>action : '.$req.'</td></tr><tr><td>Undo action : UPDATE `'.$dbVars['name'].'`.`newCQ_comment` SET comment_state=1 WHERE service_id='.$usr['noService'].' AND id='.$id.';</td></tr>';
		}
		else{
			$html = '<tr><td>fail unreport comment '.$id.' !!!!!!!</td><td><a href="'.$page.'?adminkey='.$usr['adminkey'].'">ok</a></td><td>'.$req.'</td></tr>';
		}
		
	}
	else if(isset($_GET['delete']) && is_numeric($_GET['delete'])){
		$id = (int) $_GET['delete'];
		$req = "UPDATE `".$dbVars['name']."`.`newCQ_comment` SET comment_state=2 WHERE service_id=".$usr['noService']." AND id=".$id.";";
		$res = query($req, $usr);
		if($res == true){
			$html = '<tr><td>comment '.$id.' deleted !</td><td><a href="'.$page.'?adminkey='.$usr['adminkey'].'">ok</a></td>
			</tr><tr><td>action : '.$req.'</td></tr><tr><td>Undo action : UPDATE `'.$dbVars['name'].'`.`newCQ_comment` SET comment_state=1 WHERE service_id='.$usr['noService'].' AND id='.$id.';</td></tr>';
		}
		else{
			$html = '<tr><td>fail delete comment '.$id.' !!!!!!!</td><td><a href="'.$page.'?adminkey='.$usr['adminkey'].'">ok</a></td><td>'.$req.'</td></tr>';
		}
	}
	else if(isset($_GET['causes']) && is_numeric($_GET['causes'])){
		$id = (int) $_GET['causes'];
		$title = 'causes for comment '.$id.'';
		$req = "SELECT * FROM `".$dbVars['name']."`.`newCQ_reported_comment` WHERE service_id=".$usr['noService']." AND comment_id=".$id.";";
		$res = query($req, $usr);
		if($res != null && mysql_num_rows($res) != 0){
			$html = '<tr>
				<th>id</th>
				<th>ip</th>
				<th>date</th>
				<th>cause</th>
				<td><a href="'.$page.'?adminkey='.$usr['adminkey'].'">retour</a></td>
			</tr>';
			while($ret = mysql_fetch_array($res, MYSQL_ASSOC)){
				$html .= '<tr>
					<td>'.$ret['id'].'</td>
					<td>'.inttoip($ret['post_ip']).'</td>
					<td>'.$ret['post_date'].'</td>
					<td>'.utf8_encode($ret['cause']).'</td>
				</tr>';
			}
		}
		else{
			$html = '<tr><td>ERREUR : pas de report pour le comment '.$id.' !!!</td></tr>';
		}
	}
	else{
		if(isset($_GET['show_deleted']) && $_GET['show_deleted'] == 1){
			$title = "DELETED comments :";
			$req = "SELECT * FROM `".$dbVars['name']."`.`newCQ_comment` WHERE service_id=".$usr['noService']." AND comment_state=2;";
		}
		else{
			$req = "SELECT * FROM `".$dbVars['name']."`.`newCQ_comment` WHERE service_id=".$usr['noService']." AND comment_state=1;";
		}
		
		$res = query($req, $usr);
		if($res != null && mysql_num_rows($res) != 0){
			$html = "<tr>
				<th>id</th>
				<th>elt_type</th>
				<th>elt_id</th>
				<th>pub</th>
				<th>mail</th>
				<th>site</th>
				<th>comment</th>
				<th>up</th>
				<th>down</th>
				<th>reported</th>
			</tr>";
			while($ret = mysql_fetch_array($res, MYSQL_ASSOC)){
				$html .= '<tr>
					<td>'.$ret['id'].'</td>
					<td>'.codeToCommentType($ret['elt_type']).'</td>
					<td>'.$ret['elt_id'].'</td>
					<td>'.utf8_encode($ret['publisher']).'</td>
					<td>'.utf8_encode($ret['mail']).'</td>
					<td>'.utf8_encode($ret['site']).'</td>
					<td>'.utf8_encode($ret['comment']).'</td>
					<td>'.$ret['vote_up'].'</td>
					<td>'.$ret['vote_down'].'</td>
					<td>'.$ret['reported'].'</td>
					<td> <a href="'.$page.'?adminkey='.$usr['adminkey'].'&causes='.$ret['id'].'">causes</a> </td>
					<td> <a href="'.$page.'?adminkey='.$usr['adminkey'].'&unreport='.$ret['id'].'">unreport</a> </td>
					<td> <a href="'.$page.'?adminkey='.$usr['adminkey'].'&delete='.$ret['id'].'">delete</a> </td>
				</tr>';
			}
			
			if(isset($_GET['show_deleted']) && $_GET['show_deleted'] == 1){
				$html .= '<tr><td></td><td><a href="'.$page.'?adminkey='.$usr['adminkey'].'">retour</a></td></tr>';
			}
			else{
				$html .= '<tr><td></td><td colspan="2"><a href="'.$page.'?adminkey='.$usr['adminkey'].'&show_deleted=1">show deleted</a></td></tr>';
			}
		}
		else{
			$html = '<tr><td>Pas de comments à modérer</td></tr>';
			if(isset($_GET['show_deleted']) && $_GET['show_deleted'] == 1){
				$html .= '<tr><td><a href="'.$page.'?adminkey='.$usr['adminkey'].'">retour</a></td></tr>';
			}
			else{
				$html .= '<tr><td colspan="2"><a href="'.$page.'?adminkey='.$usr['adminkey'].'&show_deleted=1">show deleted</a></td></tr>';
			}
		}
	}
	
	unset($req);
	dbDisconnect();
?>
<!doctype html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title>Reported comments</title>
	<meta name="description" content="">
	<meta name="author" content="">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
	td, th{
		border:solid 1px black;
		text-align: center;
	}
	table{
		border-collapse:collapse;
	}
	</style>
</head>
<body>
	<?php
		echo 'Service : '.$usr['noService'].'. '.getServiceName($usr['noService']).'<br/>';
		if(isset($title)){echo '<h1>'.$title.'</h1>';}
		echo '<table>'.$html.'</table>';
	?>
	<a href="./?adminkey=<?php echo $_GET['adminkey']; ?>"><= retour index</a>
</body>
</html>