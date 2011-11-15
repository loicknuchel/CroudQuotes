<?php
	if(isset($_POST['test']) || (isset($_GET['test']) && isset($_GET['meth']) && $_GET['meth'] == "post") ){
		if(isset($_GET['meth']) && $_GET['meth'] == "post"){$par = $_GET;}
		else{$par = $_POST;}
		
		$json = '{"test":"'.$par['test'].'","methode":"'.$_SERVER['REQUEST_METHOD'].'","cond":"POST"}';
		if(isset($par['format']) && $par['format'] == 'jsonp'){
			$json = $par['callback'].'('.$json.')';
		}
		echo $json;
	}
	else if(isset($_GET['test'])){
		$json = '{"test":"'.$_GET['test'].'","methode":"'.$_SERVER['REQUEST_METHOD'].'","cond":"GET"}';
		if(isset($_GET['format']) && $_GET['format'] == 'jsonp'){
			$json = $_GET['callback'].'('.$json.')';
		}
		echo $json;
	}
	else{
		echo 'error';
	}
?>