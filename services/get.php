<?php
	include_once $rel.'dao/retrieve.php';
	include_once $rel.'dao/persistUtils.php';
	include_once $rel.'utils/getVars.php';
	include_once $rel.'utils/convertVars.php';
	include_once $rel.'globals/conventions.php';
	
	function getQuote($usr, $quoteid){
		return retrieveQuote($usr, $quoteid);
	}
	
	function getRandomQuote($usr){
		return retrieveRandomQuote($usr);
	}
	
	function getComments($usr, $elt_type, $elt_id, $page, $textForReportedComments){
		$type = ressourceTypeToCode($elt_type);
		if($type == null){
			persistFatalErrorLog($usr, "get.php : getComments() : not found elt_type ($elt_type).", true);
			return null;
		}
		return retrieveComments($usr, $type, $elt_id, $page, $textForReportedComments);
	}
	
	function getTopQuotes($usr, $page){
		return retrieveTopQuotes($usr, $page);
	}
	
	function getTopCommentQuotes($usr, $page){
		return retrieveTopCommentQuotes($usr, $page);
	}
	
	/*function getLastCommentQuotes($usr, $page){
		return retrieveLastCommentQuotes($usr, $page);
	}*/
	
	function getLastsQuotes($usr, $page){
		return retrieveLastsQuotes($usr, $page);
	}
	
	function getCustomQuoteList($usr, $tabid){
		return retrieveCustomQuoteList($usr, $tabid);
	}
	
	function getCategoryQuotes($usr, $cat, $page){
		if(is_numeric($cat)){ $cat_id = $cat; }
		else{ $cat_id = retrieveCategoryId($usr, $cat); }
		return retrieveCategoryQuotes($usr, $cat_id, $page);
	}
	
	function getSelectionQuotes($usr, $sel, $page){
		if(is_numeric($sel)){ $sel_id = $sel; }
		else{ $sel_id = retrieveSelectionId($usr, $sel); }
		return retrieveSelectionQuotes($usr, $sel_id, $page);
	}
	
	function getAuthorQuotes($usr, $auth, $page){
		return retrieveAuthorQuotes($usr, $auth, $page);
	}
	
	function getCategories($usr, $page){
		return retrieveCategories($usr, $page);
	}
	
	function getSelections($usr, $page){
		return retrieveSelections($usr, $page);
	}
	
	function getMailSuivi($usr, $mail){
		return retrieveSuiviByMail($usr, $mail);
	}
	
	function getRessourceSuivi($usr, $elt_type, $id){
		return retrieveSuiviForRessource($usr, $elt_type, $id);
	}
	
	function getPetition($usr, $elt_type, $elt_id, $page){
		$type = ressourceTypeToCode($elt_type);
		if($type == null){
			persistFatalErrorLog($usr, "get.php : getPetition() : not found elt_type ($elt_type).", true);
			return null;
		}
		return retrievePetition($usr, $type, $elt_id, $page);
	}
	
	function getTotalPages($usr){
		return retrieveTotalPages($usr);
	}
	
	function getCategoryTotalPages($usr, $cat){
		if(is_numeric($cat)){ $cat_id = $cat; }
		else{ $cat_id = retrieveCategoryId($usr, $cat); }
		return retrieveCategoryTotalPages($usr, $cat_id);
	}
	
	function getSelectionTotalPages($usr, $sel){
		if(is_numeric($sel)){ $sel_id = $sel; }
		else{ $sel_id = retrieveSelectionId($usr, $sel); }
		return retrieveSelectionTotalPages($usr, $sel_id);
	}
	
	function getAuthorTotalPages($usr, $auth){
		return retrieveAuthorTotalPages($usr, $auth);
	}
	
	function getTotalCommentPages($usr, $elt_type, $elt_id){
		$type = ressourceTypeToCode($elt_type);
		if($type == null){
			persistFatalErrorLog($usr, "get.php : getTotalCommentPages() : not found elt_type ($elt_type).", true);
			return null;
		}
		return retrieveTotalCommentPages($usr, $type, $elt_id);
	}
	
	function getTotalPetitionPages($usr, $elt_type, $elt_id){
		$type = ressourceTypeToCode($elt_type);
		if($type == null){
			persistFatalErrorLog($usr, "get.php : getTotalPetitionPages() : not found elt_type ($elt_type).", true);
			return null;
		}
		return retrieveTotalPetitionPages($usr, $type, $elt_id);
	}
	
	function getTotalCategoriesPages($usr){
		return retrieveTotalCategoriesPages($usr);
	}
	
	function getTotalSelectionsPages($usr){
		return retrieveTotalSelectionsPages($usr);
	}
	
	function getKeyCptCount($usr){
		return retrieveKeyCptCount($usr);
	}
	
	function getCategoryId($usr, $category_name){
		return retrieveCategoryId($usr, $category_name);
	}
	
	function getCategoryName($usr, $category_id){
		return retrieveCategoryName($usr, $category_id);
	}
	
	function getSelectionId($usr, $sel){
		return retrieveSelectionId($usr, $sel);
	}
	
	function getSelectionName($usr, $sel_id){
		return retrieveSelectionName($usr, $sel_id);
	}
	
	function getSelectionLastId($usr){
		return retrieveLastId($usr, 'newCQ_selection');
	}
	
	function isCorrectDbVersion($usr){
		return retireveIsCorrectDbVersion($usr);
	}
?>
