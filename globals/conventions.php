<?phpfunction ressourceTypeToCode($type){	if($type == 'page'){return 1;}	else if($type == 'quote'){return 2;}	else if($type == 'comment'){return 3;}	else if($type == 'site'){return 4;}	else if($type == 'event'){return 5;}	else{return null;}}function codeToRessourceType($code){	if($code == 1){return 'page';}	else if($code == 2){return 'quote';}	else if($code == 3){return 'comment';}	else if($code == 4){return 'site';}	else if($code == 5){return 'event';}	else{return null;}}function isRessourceType($type){	return ressourceTypeToCode($type) != null;}function actionTocode($action){	if($action == 'follow'){return 1;}	else if($action == 'unfollow'){return 2;}	else{return null;}}function isAction($action){	return actionTocode($action) != null;}?>