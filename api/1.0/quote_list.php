<?php	$rel = '../../';	include_once '../fonc/getQuoteList.php';	include_once $rel.'filtres/filtre.php';	include_once $rel.'utils/json.php';	include_once $rel.'utils/secureVars.php';		if(isset($_GET['key'])){		$usr = null;		$usr['key'] = safe_string(isset($_GET["key"]) ? $_GET["key"] : null);		filtre($usr); // exit if incorrect				if(isset($_GET['list']) && $_GET['list'] == 'top'){			echo apiGetQuoteListByTop($usr, $_GET, $rel);		}		else if(isset($_GET['list']) && $_GET['list'] == 'topcomment'){			echo apiGetQuoteListByTopComment($usr, $_GET, $rel);		}		else if(isset($_GET['list']) && $_GET['list'] == 'lastactivity'){			echo apiGetQuoteListByLastComment($usr, $_GET, $rel);		}		else if(isset($_GET['list']) && $_GET['list'] == 'lasts'){			echo apiGetQuoteListByLasts($usr, $_GET, $rel);		}		else if(isset($_GET['list']) && $_GET['list'] == 'custom'){			echo apiGetQuoteListByCustom($usr, $_GET, $rel);		}		else if(isset($_GET['list']) && $_GET['list'] == 'author' && isset($_GET['auth'])){			echo 'print quoteList author';		}		else if(isset($_GET['list']) && $_GET['list'] == 'publisher' && isset($_GET['pub'])){			echo 'print quoteList publisher';		}		else if(isset($_GET['list']) && $_GET['list'] == 'category' && isset($_GET['cat'])){			echo apiGetQuoteListByCategory($usr, $_GET, $rel);		}		else if(isset($_GET['list']) && $_GET['list'] == 'selection' && isset($_GET['sel'])){			echo apiGetQuoteListBySelection($usr, $_GET, $rel);		}		else if(isset($_GET['list']) && $_GET['list'] == 'tag' && isset($_GET['tag'])){			echo 'print quoteList tag';		}		else{			echo createErrorJson($usr, 400); // paramètres incorrects		}	}	else{		echo createErrorJson(null, 401); // clé de connexion incorrecte	}	?>