<?php

	include_once $rel.'globals/env.php';
	include_once $rel.'utils/getVars.php';

// TODO : Vérifie qu'une clé est valide et retourne l'id du servie auquel elle correspond ou null sinon
function isKeyValid($key){
	return 1;
}

// TODO : Vérifie qu'une clé admin est valide et retourne l'id du servie auquel elle correspond ou null sinon
function isAdminKeyValid($key){
	return 1;
}

// TODO : retourne un tableau de services, peut être connecté à la bdd...
function getServices(){
	$services = null;
	$services['monpremierservice']['id'] = 1;
	$services['monpremierservice']['name'] = 'monpremierservice';
	$services['monpremierservice']['code'] = 'code correspondant au service'; // utilisé pour la génération de clé
	$services['monpremierservice']['nbUsedKey'] = 1;
	$services['monpremierservice']['nbUsedAdminKey'] = 1;
	return $services;
}

// return true si le chaine de caractère $service est un nom de service, false sinon
function isService($service){
	$services = getServices();
	return isset($services[$service]);
}

// retourne le nom du service correspondant à l'id, null sinon
function getServiceName($id){
	foreach(getServices() as $key => $value){
		if($value['id'] == $id){
			return $value['name'];
		}
	}
	return null;
}

// TODO : private : génère une clé utilisateur
function generateKey($service_code, $no){
	return sha1("Mettre votre sel : ".$service_code.$no);
}

// TODO : private : génère une clé admin
function generateAdminKey($service_code, $no){
	return sha1("Mettre un autre sel : ".$service_code.$no);
}

?>