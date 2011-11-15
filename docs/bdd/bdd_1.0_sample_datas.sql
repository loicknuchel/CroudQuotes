INSERT INTO `CQ_category` (`post_ip` ,`name`)VALUES 
('2147483647','loic quotes'),
('2147483647','vdm'),
('2147483647','geek'),
('2147483647','autres');

INSERT INTO `CQ_quote` (`post_ip` ,`comments` ,`vote_up` ,`vote_down` ,`reported` ,`quote_state` ,`category` ,`quote` ,`explanation` ,`author` ,`context`)VALUES 
('2147483647','1','0','0','0','0','1','Il est temps de travailler...','Première quote !','loic',''),
('2147483647','0','3','1','0','0','3','"Connexion à réseau non identifié (Nom du réseau: dlink)"','','georges',''),
('2147483647','7','3','1','0','0','1','On ne mélange pas les torchons avec les servlet ! Un poin c est tout.','Pour ceux qui n\'auraient pas compris, c\'est un détournement du proverbe très connu avec des mots similaires en informatique...','tim','Cette ciation a été utilisée lors de l\'anniversaire du JUG au concours de SFEIR. Elle n\'a malheureusement pas gagné.'),
('2147483647','0','0','0','1','1','2','après un an passé en Italie, je me prépare à rentrer chez moi. Il est l heure de partir et ma valise étant pleine, je décide de m asseoir dessus pour la fermer, comme dans les films. Elle a explosé, littéralement.','','fergie',''),
('2147483647','0','0','0','0','0','2','Aujourd hui, j ai pris conscience de l étendue de ma fainéantise quand, par flemme de me déplacer jusqu à la poubelle, j ai mangé mon trognon de pomme ET la tige.','','Anonyme',''),
('2147483647','0','0','0','0','0',NULL,'Biloute !','','lukas',''),
('2147483647','0','0','3','0','0','3','Quand un geek pense, il n oublie pas /* */ .','','loic',''),
('2147483647','2','0','0','0','0','2','Aujourd hui, cela fait trois mois que ma copine a ses règles. C est louche.','','fergie',''),
('2147483647','0','0','0','0','0','3','Le comble du Geek est de s inscrire sur un réseau social.','','lukas',''),
('2147483647','0','0','0','0','0','2','Un accident de barbecue m a conduit aux urgences. Pour brûlure ? Non. Pour crise de rire tellement puissante que je me suis empalé la joue avec le bâton de ma brochette','','Anonyme',''),
('2147483647','0','0','0','0','0','3','Windows, ou l art de prendre les gens pour de bêta-testeurs.','','loic',''),
('2147483647','0','0','0','0','0',NULL,'LOOOL','','lukas',''),
('2147483647','0','0','0','0','0','3','Que signifie lol? valeur absolue de zéro!','','loic',''),
('2147483647','0','0','0','0','0','1','Il était une fois','','loic',''),
('2147483647','0','0','0','0','0',NULL,'Hello','','tim','');

INSERT INTO `CQ_category_quote` (`post_ip` ,`quote_id` ,`category_id` ,`value`)VALUES 
('2147483640', '1', '1', '5'),
('2147483640', '2', '3', '5'),
('2147483640', '3', '1', '5'),
('2147483640', '4', '2', '5'),
('2147483640', '5', '2', '5'),
('2147483640', '7', '3', '5'),
('2147483640', '8', '2', '5'),
('2147483640', '9', '3', '5'),
('2147483640', '10', '2', '5'),
('2147483640', '11', '3', '5'),
('2147483640', '12', '3', '5'),
('2147483640', '13', '1', '5');

INSERT INTO `CQ_vote_quote` (`post_ip` ,`quote_id` ,`vote`)VALUES 
('2147483640', '7', '0'),
('2147483642', '2', '1'),
('2147483641', '7', '0'),
('2147483640', '3', '1'),
('2147483640', '2', '1'),
('2147483643', '3', '1'),
('2147483643', '2', '0'),
('2147483641', '2', '1'),
('2147483641', '3', '1'),
('2147483642', '3', '0'),
('2147483642', '7', '0');

INSERT INTO `CQ_reported_quote` (`post_ip` ,`quote_id`)VALUES 
('2147483640', '4');

INSERT INTO `CQ_comment` (`post_ip` ,`vote_up` ,`vote_down` ,`reported` ,`comment_state` ,`quote_id` ,`publisher` ,`mail` ,`site` ,`comment`)VALUES 
('2147483647','0','0','1','1','3','hank','hank@mail.com','','Bande de nazis :s'),
('2147483647','0','4','0','0','3','loic','loic@mail.com','http://lkws.com','Shh my firefow is sleeping...'),
('2147483647','0','1','0','0','1','luc','luc@mail.com','','How this site work ?'),
('2147483647','0','0','0','0','3','loic','loic@mail.com','','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
('2147483647','0','0','0','0','8','fergie','fergie@mail.com','','Une vraie vdm comme je les aimes.'),
('2147483647','0','1','0','0','3','marc','marc@mail.com','http://www.numerama.com','Vous vous amusez bien les gars ?'),
('2147483647','0','0','0','0','3','tim','tim@mail.com','','Stop :)'),
('2147483647','0','0','0','0','3','anonyme','anonyme@mail.com','','One comment more...'),
('2147483647','0','0','0','0','3','anonyme','anonyme@mail.com','','again...'),
('2147483647','0','0','0','0','8','anonyme','anonyme@mail.com','','Ah les femmes...');

INSERT INTO `CQ_vote_comment` (`post_ip` ,`comment_id` ,`vote`)VALUES 
('2147483640', '2', '1'),
('2147483642', '2', '1'),
('2147483640', '6', '1'),
('2147483643', '2', '1'),
('2147483640', '8', '0'),
('2147483641', '2', '1'),
('2147483642', '3', '1');

INSERT INTO `CQ_reported_comment` (`post_ip` ,`comment_id`)VALUES 
('2147483640', '1');
