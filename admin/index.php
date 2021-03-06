<?php
	$links = null;
	if(isset($_GET['adminkey'])){
		$rel = '../';
		include_once $rel.'private_datas/filtre_fonc.php';
		include_once $rel.'globals/conventions.php';
		
		$id = isAdminKeyValid($_GET['adminkey']);
		if($id != null){ 
			/* 
			adminkey test   : '02fe37cdf3cc8a13cc7d4b4b5fc7bf8de18a8302';
			adminkey mp2012 : '993c7205f72832485d584cf4ab5e8c13e6fb959e';
			adminkey ps12   : '19fe89e3154c97d3a407b0526ebbe405bd7f669c';
			adminkey dev    : '2ac11d311674494438d7cd99af95e0dd54e2fb77';
			adminkey demo   : '2ab0e7845e3d1c0c87bd7a8bc1151948d0131deb';
			*/
			$links = 'Service : '.$id.'. '.getServiceName($id).'<br/>
			<br/>
			Accéder à la <a href="generate.php?adminkey='.$_GET['adminkey'].'">génération de clés</a><br/>
			Accéder à la <a href="admin_key.php?adminkey='.$_GET['adminkey'].'">gestion des clés</a><br/>
			Accéder à l\'<a href="admin_quotes.php?adminkey='.$_GET['adminkey'].'">administration des citations</a><br/>
			Accéder à l\'<a href="admin_comments.php?adminkey='.$_GET['adminkey'].'">administration des commentaires</a><br/>
			Accéder à la <a href="create_req.php?adminkey='.$_GET['adminkey'].'">création de requêtes</a><br/>
			Accéder aux <a href="stats.php?adminkey='.$_GET['adminkey'].'">statistiques</a><br/>';
		}
	}
?>
<!doctype html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title>Admin</title>
	<meta name="description" content="">
	<meta name="author" content="">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	Entrez votre clé :<br/>
	<form method="GET">
		<input type="text" name="adminkey" value="<?php echo isset($_GET['adminkey']) ? $_GET['adminkey'] : null; ?>" style="width: 300px" />
		<input type="submit" value="Accéder à l'admin" />
	</form>
	<?php echo $links; ?>
</body>
</html>