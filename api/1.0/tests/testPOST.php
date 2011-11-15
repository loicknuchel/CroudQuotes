<?php
	$json = '{"GET":{';
	$cpt = 0;
	foreach($_GET as $key => $value){
		if($cpt != 0){$json .= ',';}
		$json .= '"'.$key.'":"'.$value.'"';
		$cpt++;
	}
	$json .= '},"POST":{';
	$cpt = 0;
	foreach($_POST as $key => $value){
		if($cpt != 0){$json .= ',';}
		$json .= '"'.$key.'":"'.$value.'"';
		$cpt++;
	}
	$json .= '}}';
	
	echo $json;
?>