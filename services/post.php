<?php
	include_once $rel.'dao/persist.php';
	include_once $rel.'dao/persistUtils.php';
	include_once $rel.'dao/retrieve.php';
	include_once $rel.'services/mail.php';
	include_once $rel.'utils/getVars.php';
	include_once $rel.'utils/convertVars.php';
	include_once $rel.'globals/env.php';
	include_once $rel.'globals/conventions.php';
	
	function postQuote($usr, $quote, $src, $ctx, $expl, $auth, $pub, $pubinfo, $mail, $site, $cat, &$quoteid){
		if(is_numeric($cat)){ $cat_id = $cat; }
		else{ $cat_id = retrieveCategoryId($usr, $cat); }
		return persistQuote($usr, iptoint(getIp()), $quote, $src, $ctx, $expl, $auth, $pub, $pubinfo, $mail, $site, $cat_id, $quoteid);
	}
	
	function postCategory($usr, $name, &$categoryid){
		return persistCategory($usr, iptoint(getIp()), $name, $categoryid);
	}
	
	function postQuoteCategory($usr, $quoteid, $cat, $value, &$newcategoryid){
		if(is_numeric($cat)){ $cat_id = $cat; }
		else{ $cat_id = retrieveCategoryId($usr, $cat); }
		return persistQuoteCategory($usr, iptoint(getIp()), $quoteid, $cat_id, $value, $newcategoryid);
	}
	
	function postSelection($usr, $sel, &$sel_id){
		return persistSelection($usr, iptoint(getIp()), $sel, $sel_id);
	}
	
	function postSelectionQuotes($usr, $tabquoteids, $sel_id){
		return persistSelectionQuotes($usr, $tabquoteids, $sel_id);
	}
	
	function postComment($usr, $elt_type, $elt_id, $publisher, $mail, $site, $comment, &$commentid){
		if($elt_type == 'quote'){
			$ret = persistQuoteComment($usr, iptoint(getIp()), $elt_id, $publisher, $mail, $site, $comment, $commentid);
			if($ret == 200){
				send_new_comment_mails($usr, $elt_id, $publisher, $comment);
			}
		}
		else if(isCommentType($elt_type)){
			$ret = persistComment($usr, iptoint(getIp()), commentTypeToCode($elt_type), $elt_id, $publisher, $mail, $site, $comment, $commentid);
		}
		else{
			persistFatalErrorLog($usr, "post.php : postComment() : not found elt_type ($elt_type).", true);
			return null;
		}
		return $ret;
	}
	
	function postSuivi($usr, $mail, $quoteid, $actions){
		return persistSuivi($usr, iptoint(getIp()), $mail, $quoteid, $actions, getTimestamp());
	}
	
	function postQuoteUpVote($usr, $quoteid){
		return persistVote($usr, iptoint(getIp()), "quote", $quoteid, "up");
	}
	
	function postQuoteDownVote($usr, $quoteid){
		return persistVote($usr, iptoint(getIp()), "quote", $quoteid, "down");
	}
	
	function postCommentUpVote($usr, $quoteid){
		return persistVote($usr, iptoint(getIp()), "comment", $quoteid, "up");
	}
	
	function postCommentDownVote($usr, $quoteid){
		return persistVote($usr, iptoint(getIp()), "comment", $quoteid, "down");
	}
	
	function postQuoteReport($usr, $quoteid, $cause = null, &$deleted){
		return persistReport($usr, iptoint(getIp()), "quote", $quoteid, $cause, $deleted);
	}
	
	function postCommentReport($usr, $quoteid, $cause = null, &$deleted){
		return persistReport($usr, iptoint(getIp()), "comment", $quoteid, $cause, $deleted);
	}
	
	function postApiLogs($usr, $user_agent, $call, &$logid){
		return persistApiLogs($usr, iptoint(getIp()), $user_agent, $call, $logid);
	}
	
	function postCreateKeyCptCount($usr){
		return persistCreateKeyCpt($usr, getTimestamp());
	}
	
	function postResetKeyCpt($usr){
		return persistResetKeyCpt($usr, getTimestamp());
	}
	
	function postIncKeyCpt($usr){
		return persistIncKeyCpt($usr);
	}
	
?>