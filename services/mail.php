<?php
	include_once $rel.'utils/mail.php';
	
	function send_new_comment_mails($usr, $quoteid, $publisher, $comment){
		$mails = retrieveNewCommentSuiviMail($usr, $quoteid);
		$quote = retrieveQuote($usr, $quoteid);
		
		$sender_name = 'Mon Programme 2012 : suivi des commentaires';
		$sender_mail = 'noreply@lkws.fr';
		$subject = 'Suivi de la proposition #'.$quoteid.' : Nouveau commentaire';
		$content = '
		<div>
			Vous suivez les commentaires de la proposition #'.$quoteid.' :<br/>
			<span style="padding: 15px; font-style: italic; line-height: 30px;">"'.$quote['quote'].'"</span>
		</div>
		<div>
			Un nouveau commentaire a été laissé par '.$publisher.' :<br/>
			<span>'.nl2br($comment).'</span>
		</div>
		
		<div style="margin-top: 20px;">
			Vous pouvez réagir à son commentaire <a href="http://monprogramme2012.lkws.fr/?q='.$quoteid.'">ici</a>.
		</div>
		<div>
			Pour vous désinscrire de ce suivi et ne plus reçevoir ces messages, <a href="http://dev.lkws.fr/croudquotes/api/1.0/suivi.php?key=aff83ccf08f1dd28ee330b0b07de4f3b985a81d4&mail=DEST_MAIL&quoteid='.$quoteid.'&newcomments=0&meth=post">cliquez ici</a>.
		</div>
';
		
		while ($mails != null && $dest_mail = mysql_fetch_array($mails, MYSQL_ASSOC)) {
			send_mail($sender_name, $sender_mail, $dest_mail['mail'], $subject, str_replace('DEST_MAIL', $dest_mail['mail'], $content));
		}
	}
?>