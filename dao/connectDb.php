<?php
	include_once $rel.'private_datas/env-db.php';

	function dbConnect(){
		// on se connecte à MySQL
		$dbVars = setDbVars();
		$db = mysql_connect($dbVars['host'], $dbVars['username'], $dbVars['password']);
		
		if(!$db){
			echo 'false';
			exit;
		}
		else{
			// on selectionne la base
			if(!mysql_select_db($dbVars['name'],$db)){
				echo '<h1>Erreur de selection de la base</h1>';
				exit;
			}	
		}
		
		return $db;
	}

	function dbDisconnect(){
		mysql_close();
	}
?>
