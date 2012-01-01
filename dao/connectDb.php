<?php
	include_once $rel.'globals/env.php';
	include_once $rel.'private_datas/env-db.php';

	function dbConnect(){
		// on se connecte à MySQL
		$dbVars = setDbVars(getStatus());
		$db = mysql_connect($dbVars['host'], $dbVars['username'], $dbVars['password']);
		
		if(!$db){
			echo 'false';
			exit;
		}
		else{
			// on selectionne la base
			if(!mysql_select_db($dbVars['DbName'],$db)){
				echo '<h1>Erreur de selection de la base</h1>';
				exit;
			}
			
			// vérifie si on est bien connecté !!!
			/*$res = mysql_query('SELECT USER() as usr, CURRENT_USER() as cur_usr;');
			$ret = mysql_fetch_array($res, MYSQL_ASSOC);
			echo 'USER() : '.$ret['usr'].', CURRENT_USER() : '.$ret['cur_usr'].'<br/>';*/
		}
		
		return $db;
	}

	function dbDisconnect(){
		mysql_close();
	}
?>
