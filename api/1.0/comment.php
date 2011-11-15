<?php
	$rel = '../../';
	include_once '../fonc/getComments.php';
	include_once '../fonc/postComment.php';
	include_once '../fonc/postVote.php';
	include_once '../fonc/postReport.php';
	include_once $rel.'filtres/filtre.php';
	include_once $rel.'utils/json.php';
	include_once $rel.'utils/secureVars.php';
	
	if(isset($_POST['key']) || (isset($_GET['key']) && isset($_GET['meth']) && $_GET['meth'] == "post") ){
		if(isset($_GET['meth']) && $_GET['meth'] == "post"){$par = $_GET;}
		else{$par = $_POST;}
		
		$usr = null;
		$usr['key'] = safe_string(isset($par["key"]) ? $par["key"] : null);
		filtre($usr); // exit if incorrect
		
		if( ( isset($par['quoteid']) || ( isset($par['type']) && isset($par['id']) ) ) && isset($par['pub']) && isset($par['comment'])){
			echo apiNewComment($usr, $par, $rel);
		}
		else if(isset($par['commentid']) && isset($par['vote'])){
			echo apiCommentVote($usr, $par, $rel);
		}
		else if(isset($par['commentid']) && isset($par['report']) && $par['report'] == 1){
			echo apiCommentReport($usr, $par, $rel);
		}
		else{
			echo createErrorJson($usr, 400); // paramètres incorrects
		}
	}
	else if(isset($_GET['key'])){
		$usr = null;
		$usr['key'] = safe_string(isset($_GET["key"]) ? $_GET["key"] : null);
		filtre($usr); // exit if incorrect
		
		if(isset($_GET['type']) && isset($_GET['id'])){
			echo apiGetCommentsByTypeId($usr, $_GET, $rel);
		}
		else{
			echo createErrorJson($usr, 400); // paramètres incorrects
		}
	}
	else{
		echo createErrorJson(null, 401); // clé de connexion incorrecte
	}
	
?>