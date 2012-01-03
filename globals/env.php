<?phpfunction getStatus(){	return "LOCAL";										// TODO : mettre LOCAL, DEV ou PROD															<= ICI}function setEnv(){	$env = "";		$env['BDDversion'] = '1.4';		// changer aussi dans croudquotes/private_datas/env-db.php		$env['displaySQLreq'] = false; // affiche toutes les requêtes effectuées en base de données (et qui ne sont pas des logs)	$env['displaySQLlogreq'] = false; // affiche toutes les requêtes effectuées en base de données (y compris les logs)		$env['logAPIreq'] = true; // active le log de tous les appels à l'API	//$env['logSQLupdatereq'] = false; // active le log de toutes les requêtes effectuées en base de données et qui ne sont pas des SELECT : A FAIRE !	$env['logSQLreq'] = false; // active le log de toutes les requêtes effectuées en base de données y compris les SELECT		$env['quotePageSize'] = 10;	$env['commentPageSize'] = 20;	$env['categoryPageSize'] = 20;	$env['selectionPageSize'] = 20;	$env['petitionPageSize'] = 40;		$env['quoteMaxSize'] = 140;	$env['commentMaxSize'] = 4096;	$env['sourceMaxSize'] = 256;	$env['contextMaxSize'] = 1024;	$env['explanationMaxSize'] = 2048;	$env['authorMaxSize'] = 30;	$env['publisherMaxSize'] = 30;	$env['publisherInfoMaxSize'] = 1024;	$env['mailMaxSize'] = 40;	$env['siteMaxSize'] = 256;	$env['categoryMaxSize'] = 20;	$env['selectionMaxSize'] = 20;	$env['tagMaxSize'] = 20;		$env['prenomMaxSize'] = 15;	$env['nomMaxSize'] = 15;	$env['professionMaxSize'] = 56;	$env['zipcodeMaxSize'] = 5;	$env['messageMaxSize'] = 256;		$env['allowedReqPerTime'] = 40;	$env['reqResetTime'] = 60; // en secondes		$env['nbReportBeforeDelete'] = 3;		return $env;}function getApiUrl($status){	if($status == "LOCAL"){		return 'http://localhost/lkws_croudquotes/api/1.0/';	}	else if($status == "DEV"){		return 'http://dev.lkws.fr/lkws_croudquotes/api/1.0/';	}	else if($status == "PROD"){		return 'http://croudquotes.lkws.fr/api/1.0/';	}	else{		return null;	}}?>