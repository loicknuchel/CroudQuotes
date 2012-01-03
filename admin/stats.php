<?php
	$server_link = '../';
	$rel = $server_link;
	$page = './stats.php';
	include_once $server_link.'dao/connectDb.php';
	include_once $server_link.'dao/mysqlUtils.php';
	include_once $server_link.'dao/retrieve.php';
	include_once $server_link.'filtres/filtre.php';
	include_once $server_link.'private_datas/filtre_fonc.php';
	include_once $server_link.'globals/env.php';
	include_once $server_link.'utils/convertVars.php';
	
	$usr = null;
	$usr['adminkey'] = isset($_GET['adminkey']) ? $_GET['adminkey'] : exit;
	filtreAdmin($usr);
?>

<!doctype html> 
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]--> 
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]--> 
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]--> 
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]--> 
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]--> 
<head> 
	<meta charset="UTF-8"> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	
	<title>Mon Programme 2012 - Stats</title> 
	<meta name="description" content=""> 
	<meta name="author" content=""> 
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		table {
			border-collapse: collapse;
		}
		th, td {
			width: 50px;
			border: 1px solid black;
		}
		tr th:first-child {
			width: 150px;
		}
		td {
			text-align: right;
		}
		tr td:last-child {
			width: auto;
			border: none;
			background: none !important;
		}
	</style>
</head>
<body>
	<?php 
		$dbVars = setDbVars(getStatus());
		dbConnect();
		
		function generate_line($usr, $title, $base_req, $date_col, $last_cell = ''){
			$time_limit = 'TO_DAYS(NOW()) - TO_DAYS('.$date_col.') <=';
			$html = '<tr>
				<th>'.$title.'</th>
				<td>'.getSingleData($usr, $base_req, 'res', 0).'</td>
				<td>'.getSingleData($usr, $base_req.' AND '.$time_limit.' 30', 'res', 0).'</td>
				<td>'.getSingleData($usr, $base_req.' AND '.$time_limit.' 7', 'res', 0).'</td>
				<td>'.getSingleData($usr, $base_req.' AND '.$time_limit.' 1', 'res', 0).'</td>
				<td>'.$last_cell.'</td>
			</tr>';
			
			return $html;
		}
		
		function generate_interline(){
			$html = '<tr>
				<th style="background: red;"></th>
				<td style="background: red;"></td>
				<td style="background: red;"></td>
				<td style="background: red;"></td>
				<td style="background: red;"></td>
				<td></td>
			</tr>';
			return $html;
		}
		
		$service_id = isset($_GET['service_id']) ? $_GET['service_id'] : $usr['noService'];
		$formServices = '
		<form method="GET">
			<input type="hidden" name="adminkey" value="'.$_GET['adminkey'].'" />
			<select name="service_id">';
				foreach(getServices() as $service){
					$formServices .= '<option value='.$service['id']; if($service_id == $service['id']){$formServices .= ' selected="selected"';} $formServices .= '>'.$service['name'].'</option>';
				}
		$formServices .= '
			</select>
			<input type="submit" value="Changer service" />
		</form>';
		echo 'Service : '.$usr['noService'].'. '.getServiceName($usr['noService']).'<br/>';
		echo $formServices;
	?>
	<table>
		<tr>
			<th></th>
			<th>all</th>
			<th>last month</th>
			<th>last week</th>
			<th>last day</th>
			<td></td>
		</tr>
		<?php 
			echo generate_interline();
			echo generate_line($usr, 'quote', 				"SELECT count(*) as res FROM `".$dbVars['name']."`.`newCQ_quote` WHERE service_id=".$service_id." AND quote_state=0",		"post_date");
			echo generate_line($usr, 'reported quote', 		"SELECT count(*) as res FROM `".$dbVars['name']."`.`newCQ_quote` WHERE service_id=".$service_id." AND quote_state=1",		"post_date", '<a href="./reported_quotes.php?adminkey='.$usr['adminkey'].'">see them</a>');
			echo generate_line($usr, 'deleted quote', 		"SELECT count(*) as res FROM `".$dbVars['name']."`.`newCQ_quote` WHERE service_id=".$service_id." AND quote_state=2",		"post_date");
			echo generate_line($usr, 'quote votes up', 		"SELECT count(*) as res FROM `".$dbVars['name']."`.`newCQ_vote_quote` WHERE service_id=".$service_id." AND vote=1", 		"post_date");
			echo generate_line($usr, 'quote votes down',	"SELECT count(*) as res FROM `".$dbVars['name']."`.`newCQ_vote_quote` WHERE service_id=".$service_id." AND vote=0", 		"post_date");
			echo generate_line($usr, 'quote votes total',	"SELECT count(*) as res FROM `".$dbVars['name']."`.`newCQ_vote_quote` WHERE service_id=".$service_id."", 					"post_date");
			echo generate_interline();
			echo generate_line($usr, 'comment', 			"SELECT count(*) as res FROM `".$dbVars['name']."`.`newCQ_comment` WHERE service_id=".$service_id." AND comment_state=0",	"post_date");
			echo generate_line($usr, 'reported comment',	"SELECT count(*) as res FROM `".$dbVars['name']."`.`newCQ_comment` WHERE service_id=".$service_id." AND comment_state=1", 	"post_date", '<a href="./reported_comments.php?adminkey='.$usr['adminkey'].'">see them</a>');
			echo generate_line($usr, 'deleted comment', 	"SELECT count(*) as res FROM `".$dbVars['name']."`.`newCQ_comment` WHERE service_id=".$service_id." AND comment_state=2", 	"post_date");
			echo generate_line($usr, 'comment votes up', 	"SELECT count(*) as res FROM `".$dbVars['name']."`.`newCQ_vote_comment` WHERE service_id=".$service_id." AND vote=1", 		"post_date");
			echo generate_line($usr, 'comment votes down',	"SELECT count(*) as res FROM `".$dbVars['name']."`.`newCQ_vote_comment` WHERE service_id=".$service_id." AND vote=0", 		"post_date");
			echo generate_line($usr, 'comment votes total',	"SELECT count(*) as res FROM `".$dbVars['name']."`.`newCQ_vote_comment` WHERE service_id=".$service_id."", 					"post_date");
			echo generate_interline();
			echo generate_line($usr, 'selection', 			"SELECT count(*) as res FROM `".$dbVars['name']."`.`newCQ_selection` WHERE service_id=".$service_id."", 					"post_date");
			echo generate_line($usr, 'category', 			"SELECT count(*) as res FROM `".$dbVars['name']."`.`newCQ_category` WHERE service_id=".$service_id."", 						"post_date");
			echo generate_interline();
			echo generate_line($usr, 'api call', 			"SELECT count(*) as res FROM `".$dbVars['name']."`.`newCQ_api_log` WHERE service_id=".$service_id."", 						"call_date");
			echo generate_line($usr, 'unique ip', 			"SELECT count(DISTINCT call_ip) as res FROM `".$dbVars['name']."`.`newCQ_api_log` WHERE service_id=".$service_id."", 		"call_date");
			echo generate_interline();
		?>
	</table>
	<a href="./?adminkey=<?php echo $_GET['adminkey']; ?>"><= retour index</a>
	<?php 
		unset($req);
		dbDisconnect();
	?>
</body>
</html>