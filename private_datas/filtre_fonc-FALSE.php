<?php

	include_once $rel.'globals/env.php';
	include_once $rel.'utils/getVars.php';

// Vérifie qu'une clé est valide et retourne l'id du servie auquel elle correspond ou null sinon
function isKeyValid($key){
	return ;
}

// Vérifie qu'une clé admin est valide et retourne l'id du servie auquel elle correspond ou null sinon
function isAdminKeyValid($key){
	return ;
}

// retourne un tableau de services
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
	return ;
}

// retourne le nom du service correspondant à l'id, null sinon
function getServiceName($id){
	return ;
}

// private : génère une clé utilisateur
function generateKey($service, $no){
	return ;
}

// private : génère une clé admin
function generateAdminKey($service, $no){
	return ;
}

?>