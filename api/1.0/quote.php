<?php
	$rel = '../../';
	include_once '../fonc/getQuote.php';
	include_once '../fonc/postQuote.php';
	include_once '../fonc/postVote.php';
	include_once '../fonc/postReport.php';
	include_once '../fonc/postCategory.php';
	include_once $rel.'filtres/filtre.php';
	include_once $rel.'utils/json.php';
	include_once $rel.'utils/secureVars.php';
	
	if(isset($_POST['key']) || (isset($_GET['key']) && isset($_GET['meth']) && $_GET['meth'] == "post") ){
		if(isset($_GET['meth']) && $_GET['meth'] == "post"){$par = $_GET;}
		else{$par = $_POST;}
		
		$usr = null;
		$usr['key'] = safe_string(isset($par["key"]) ? $par["key"] : null);
		filtre($usr); // exit if incorrect
		
		if(isset($par['quoteid']) && isset($par['quote'])){
			echo apiRephraseQuote($usr, $par, $rel);
		}
		else if(isset($par['quote'])){
			echo apiNewQuote($usr, $par, $rel);
		}
		else if(isset($par['quoteid']) && isset($par['vote'])){
			echo apiQuoteVote($usr, $par, $rel);
		}
		else if(isset($par['quoteid']) && isset($par['report']) && $par['report'] == 1){
			echo apiQuoteReport($usr, $par, $rel);
		}
		else if(isset($par['quoteid']) && isset($par['cat'])){
			echo apiNewCategoryForQuote($usr, $par, $rel);
		}
		else if(isset($par['quoteid']) && isset($par['tag'])){
			echo 'TODO : ajout tag';
		}
		else{
			echo createErrorJson($usr, 400); // paramètres incorrects
		}
	}
	else if(isset($_GET['key'])){
		$usr = null;
		$usr['key'] = safe_string(isset($_GET["key"]) ? $_GET["key"] : null);
		filtre($usr); // exit if incorrect
		
		if(isset($_GET['quoteid']) && is_numeric($_GET['quoteid'])){
			echo apiGetQuoteById($usr, $_GET, $rel);
		}
		else if(isset($_GET['quoteid']) && $_GET['quoteid'] == 'random'){
			echo apiGetQuoteByRandom($usr, $_GET, $rel);
		}
		else{
			echo createErrorJson($usr, 400); // paramètres incorrects
		}
	}
	else{
		echo createErrorJson(null, 401); // clé de connexion incorrecte
	}
	
?>