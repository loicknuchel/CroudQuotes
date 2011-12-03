<?phpfunction ressourceTypeToCode($type){	if($type == 'page'){return 1;}	else if($type == 'quote'){return 2;}	else if($type == 'comment'){return 3;}	else if($type == 'site'){return 4;}	else if($type == 'event'){return 5;}	else{return null;}}function codeToRessourceType($code){	if($code == 1){return 'page';}	else if($code == 2){return 'quote';}	else if($code == 3){return 'comment';}	else if($code == 4){return 'site';}	else if($code == 5){return 'event';}	else{return null;}}function isRessourceType($type){	return ressourceTypeToCode($type) != null;}function actionTocode($action){	if($action == 'follow'){return 1;}	else if($action == 'unfollow'){return 2;}	else{return null;}}function isAction($action){	return actionTocode($action) != null;}function genreToCode($genre){	if($genre == 'Mr'){return 1;}	else if($genre == 'Mme'){return 2;}	else{return null;}}function codeToGenre($code){	if($code == 1){return 'Mr';}	else if($code == 2){return 'Mme';}	else{return null;}}function isGenre($genre){	return genreToCode($genre) != null;}function avisToCode($avis){	if($avis == 'pour'){return 1;}	else if($avis == 'contre'){return 2;}	else{return 0;}}function codeToAvis($code){	if($code == 1){return 'pour';}	else if($code == 2){return 'contre';}	else{return null;}}function isAvis($avis){	return avisToCode($avis) != null;}?>