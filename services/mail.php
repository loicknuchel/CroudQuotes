<?php
	include_once $rel.'utils/mail.php';
	include_once $rel.'globals/env.php';
	include_once $rel.'private_datas/env-db.php';
	
	function send_mail_notification($usr, $elt_type, $elt_id, $postInfo){
		
		$sender_mail = 'noreply@lkws.fr';
		
		if($elt_type == 'quote'){ // a l'ajout d'un nouveau commentaire sur une citation
			$quote = retrieveQuote($usr, $elt_id);
			
			$sender_name = 'Mon Programme 2012 : suivi des commentaires';
			$subject = 'Suivi de la proposition #'.$elt_id.' : Nouveau commentaire';
			$content = '
			<div>
				Vous suivez les commentaires de la proposition #'.$elt_id.' :<br/>
				<span style="padding: 15px; font-style: italic; line-height: 30px;">"'.$quote['quote'].'"</span>
			</div>
			<div>
				Un nouveau commentaire a été laissé par '.$postInfo['publisher'].' :<br/>
				<span>'.nl2br($postInfo['comment']).'</span>
			</div>
			
			<div style="margin-top: 20px;">
				Vous pouvez réagir à son commentaire <a href="http://monprogramme2012.lkws.fr/?q='.$elt_id.'">ici</a>.
			</div>
			<div>
				Pour vous désinscrire de ce suivi et ne plus reçevoir ces messages, <a href="'.getApiUrl(getStatus()).'suivi.php?key='.$usr['key'].'&mail=DEST_MAIL&quoteid='.$elt_id.'&newcomments=0&meth=post">cliquez ici</a>.
			</div>
			';
		}
		else if($elt_type == 'page'){ // a l'ajout d'un nouveau commentaire sur une page
			$sender_name = '';
			$subject = '';
			$content = '';
		}
		else if($elt_type == 'site'){ // a l'ajout d'une nouvelle citation
			$sender_name = 'Mon Programme 2012 : suivi des propositions';
			$subject = 'Suivi deu site MonProgramme2012 : Nouvelle proposition';
			$content = '
			Une nouvelle proposition viens d\'être publié par '.$postInfo['publisher'].' :<br/>
			<br/>
			'.$postInfo['quote'].'<br/>
			<br/>
			Vous pouvez réagir à cette proposition <a href="http://monprogramme2012.lkws.fr/?q='.$postInfo['quoteid'].'">ici</a>.<br/>
			<br/>
			';
		}
		
		
		if(getStatus() == "DEV" || getStatus() == "PROD"){
			$mails = retrieveSuiviForRessource($usr, $elt_type, $elt_id);
			while ($mails != null && $dest_mail = mysql_fetch_array($mails, MYSQL_ASSOC)) {
				send_mail($sender_name, $sender_mail, $dest_mail['mail'], $subject, str_replace('DEST_MAIL', $dest_mail['mail'], $content));
			}
		}
	}
	
	function send_petition_confirm($usr, $elt_type, $elt_id, $mail_dest, $confirmCode){
		
		$sender_name = "Mon programme 2012 : petition";
		$sender_mail = 'noreply@lkws.fr';
		$subject = 'Confirmation de la signature de la petition.';
		
		if($elt_type == 'quote'){ // a l'ajout d'un nouveau commentaire sur une citation
			$quote = retrieveQuote($usr, $elt_id);
			$content = 'Bonjour,<br/>
			Vous venez de signer la pétition pour soutenir <a href="http://monprogramme2012.lkws.fr/?q='.$elt_id.'">la proposition #'.$elt_id.'</a> du site Mon Programme 2012 :<br/>
			<span style="padding: 15px; font-style: italic; line-height: 30px;">"'.$quote['quote'].'"</span><br/>
			<br/>
			Ce mail vous est adessé pour confirmer votre signature. Si vous n\'avez pas sollicité cette signature, vous pouvez simplement supprimer ce mail.<br/>
			Si vous souhaitez manifester votre soutien à cette proposition en signant la pétition, <a href="'.getApiUrl(getStatus()).'petition.php?key='.$usr['key'].'&confirm='.$confirmCode.'&meth=post">cliquez ici</a>.<br/>
			<br/>
			En vous remerciant pour votre soutien.<br/>';
		}
		else if($elt_type == 'site'){
			$content = 'Bonjour,<br/>
			Vous venez de signer la pétition pour soutenir le site <a href="http://monprogramme2012.lkws.fr/?q='.$elt_id.'">Mon Programme 2012</a>.<br/>
			<br/>
			Ce mail vous est adessé pour confirmer votre signature. Si vous n\'avez pas sollicité cette signature, vous pouvez simplement supprimer ce mail.<br/>
			Si vous souhaitez manifester votre soutien à ce site en signant la pétition, <a href="'.getApiUrl(getStatus()).'petition.php?key='.$usr['key'].'&confirm='.$confirmCode.'&meth=post">cliquez ici</a>.<br/>
			<br/>
			En vous remerciant pour votre soutien.<br/>';
		}
		else{
			return;
		}
		
		if(getStatus() == "DEV" || getStatus() == "PROD"){
			send_mail($sender_name, $sender_mail, $mail_dest, $subject, $content);
		}
		return;
	}
	
	
	
?>