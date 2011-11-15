<?php

function send_mail($sender_name, $sender_mail, $dest_mail, $subject, $content){
	//declare our assets 
	/*
	$name = stripcslashes($_POST['name']);
	$emailAddr = stripcslashes($_POST['email']);
	$comment = stripcslashes($_POST['message']);
	$subject = stripcslashes($_POST['subject']).' '.stripcslashes($_POST['title']);	
	$contactMessage =  
		"Message:
		$comment 

		Name: $name
		E-mail: $emailAddr

		Sending IP:$_SERVER[REMOTE_ADDR]
		Sending Script: $_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]";*/
		
	//send the email 
	$headers ='From: "'.$sender_name.'"<'.$sender_mail.'>'.'\n';
	$headers .='Reply-To: '.$sender_mail.''.'\n';
	//$headers .='Content-Type: text; charset="utf-8"'.'\n';
	$headers .='Content-Type: text/html; charset="utf-8"'.'\n';
	$headers .='Content-Transfer-Encoding: 8bit'; 
	
	if(mail($dest_mail, $subject, $content, $headers)){
		return 'success';
	}
	else{
		return 'fail';
	}
}

?>