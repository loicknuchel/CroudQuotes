<?phpfunction setEnv(){	$env = "";		$env['BDDversion'] = 'bdd_1_2'; // version 1.2		$env['displaySQLreq'] = false; // affiche toutes les requêtes effectuées en base de données (et qui ne sont pas des logs)	$env['displaySQLlogreq'] = false; // affiche toutes les requêtes effectuées en base de données (y compris les logs)		$env['logAPIreq'] = true; // active le log de tous les appels à l'API	//$env['logSQLupdatereq'] = false; // active le log de toutes les requêtes effectuées en base de données et qui ne sont pas des SELECT : A FAIRE !	$env['logSQLreq'] = false; // active le log de toutes les requêtes effectuées en base de données y compris les SELECT		$env['quotePageSize'] = 10;	$env['commentPageSize'] = 20;	$env['categoryPageSize'] = 1000; // pour que l'on voit toujours toutes les catégories sans faire un while sur les pages...	$env['selectionPageSize'] = 20;		$env['quoteMaxSize'] = 140;	$env['commentMaxSize'] = 2048;	$env['sourceMaxSize'] = 256;	$env['contextMaxSize'] = 1024;	$env['explanationMaxSize'] = 2048;	$env['authorMaxSize'] = 56;	$env['publisherMaxSize'] = 56;	$env['publisherInfoMaxSize'] = 1024;	$env['mailMaxSize'] = 140;	$env['siteMaxSize'] = 256;	$env['categoryMaxSize'] = 56;	$env['selectionMaxSize'] = 56;	$env['tagMaxSize'] = 56;		$env['allowedReqPerTime'] = 40;	$env['reqResetTime'] = 60; // en secondes		$env['nbReportBeforeDelete'] = 3;		return $env;}?>