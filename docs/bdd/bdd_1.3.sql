
/*
	TODO :
	- créer une table user, accepted_mail ou autre...
	- dans la table CQ1_3_api_log, ajouter une colonne methode et une colonne params
*/

DROP TABLE IF EXISTS `CQ1_3_petition`;
DROP TABLE IF EXISTS `CQ1_3_key_cpt`;
DROP TABLE IF EXISTS `CQ1_3_app_log`;
DROP TABLE IF EXISTS `CQ1_3_sqlreq_log`;
DROP TABLE IF EXISTS `CQ1_3_api_log`;
DROP TABLE IF EXISTS `CQ1_3_suivi`;
DROP TABLE IF EXISTS `CQ1_3_selection_quote`;
DROP TABLE IF EXISTS `CQ1_3_category_quote`;
DROP TABLE IF EXISTS `CQ1_3_reported`;
DROP TABLE IF EXISTS `CQ1_3_vote`;
DROP TABLE IF EXISTS `CQ1_3_selection`;
DROP TABLE IF EXISTS `CQ1_3_history`;
DROP TABLE IF EXISTS `CQ1_3_comment`;
DROP TABLE IF EXISTS `CQ1_3_quote`;
DROP TABLE IF EXISTS `CQ1_3_category`;
DROP TABLE IF EXISTS `CQ1_3_id_increment`;
DROP TABLE IF EXISTS `CQ1_3_service`;
DROP TABLE IF EXISTS `CQ1_3_bdd_info`;

CREATE TABLE `CQ1_3_bdd_info` (
	`version` VARCHAR(5) NOT NULL,
	`mise_en_service` timestamp NOT NULL default CURRENT_TIMESTAMP
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `CQ1_3_service` (
	`id` INT NOT NULL,
	`name` VARCHAR(256) NOT NULL,
	`code` VARCHAR(256) NOT NULL,
	`nbUsedKey` INT NOT NULL default 1,
	`nbUsedAdminKey` INT NOT NULL default 1,
	PRIMARY KEY (`id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `CQ1_3_id_increment` (
	`service_id` INT NOT NULL,
	`id_category` INT NOT NULL default 0,
	`id_quote` INT NOT NULL default 0,
	`id_comment` INT NOT NULL default 0,
	`id_selection` INT NOT NULL default 0
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `CQ1_3_id_increment` ADD CONSTRAINT FK_id_increment_service_id FOREIGN KEY (`service_id`) REFERENCES `CQ1_3_service`(`id`);

CREATE TABLE `CQ1_3_category` (
	`service_id` INT NOT NULL,
	`id` INT NOT NULL,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`name` VARCHAR(256) NOT NULL,
	PRIMARY KEY (`service_id`, `id`),
	UNIQUE (`service_id`, `name`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `CQ1_3_category` ADD CONSTRAINT FK_category_service_id FOREIGN KEY (`service_id`) REFERENCES `CQ1_3_service`(`id`);

CREATE TABLE `CQ1_3_quote` (
	`service_id` INT NOT NULL,
	`id` INT NOT NULL,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`quote` TEXT NOT NULL,
	`source` VARCHAR(256) default NULL,
	`context` TEXT default NULL,
	`explanation` TEXT default NULL,
	`author` VARCHAR(256) default NULL,
	`publisher` VARCHAR(256) default NULL,
	`publisher_info` TEXT default NULL,
	`mail` VARCHAR(256) default NULL,
	`site` VARCHAR(256) default NULL,
	`category` INT default NULL,
	`vote_up` INT NOT NULL default 0,
	`vote_down` INT NOT NULL default 0,
	`comments` INT NOT NULL default 0,
	`signatures` INT NOT NULL default 0,
	`reported` INT NOT NULL default 0,
	`quote_state` INT NOT NULL default 0 COMMENT '0:public, 1:reported, 2:deleted',
	PRIMARY KEY (`service_id`, `id`),
	KEY (`category`),
	KEY (`post_date`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `CQ1_3_quote` ADD CONSTRAINT FK_quote_service_id FOREIGN KEY (`service_id`) REFERENCES `CQ1_3_service`(`id`);
ALTER TABLE `CQ1_3_quote` ADD CONSTRAINT FK_quote_category FOREIGN KEY (`category`) REFERENCES `CQ1_3_category`(`id`);

CREATE TABLE `CQ1_3_comment` (
	`service_id` INT NOT NULL,
	`id` INT NOT NULL,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`elt_type` INT NOT NULL COMMENT '1:page, 2:quote, 3:comment',
	`elt_id` INT NOT NULL,
	`avis` INT NOT NULL default 0 COMMENT '0:sans avis, 1:pour, 2:contre',
	`publisher` VARCHAR(256) NOT NULL,
	`mail` VARCHAR(256) default NULL,
	`site` VARCHAR(256) default NULL,
	`comment` TEXT NOT NULL,
	`vote_up` INT NOT NULL default 0,
	`vote_down` INT NOT NULL default 0,
	`reported` INT NOT NULL default 0,
	`comment_state` INT NOT NULL default 0 COMMENT '0:public, 1:reported, 2:deleted',
	PRIMARY KEY (`service_id`, `id`),
	KEY (`post_date`),
	KEY (`elt_type`, `elt_id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `CQ1_3_comment` ADD CONSTRAINT FK_comment_service_id FOREIGN KEY (`service_id`) REFERENCES `CQ1_3_service`(`id`);

CREATE TABLE `CQ1_3_history` (
	`service_id` INT NOT NULL,
	`elt_type` INT NOT NULL COMMENT '1:page, 2:quote, 3:comment',
	`elt_id` INT NOT NULL,
	`history_field` INT NOT NULL COMMENT '10:quote.quote, 11:quote.source, 12:quote.context, 13:quote.explanation, 14:quote.author, 20:comment.comment',
	`create_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`content` TEXT,
	PRIMARY KEY (`service_id`, `elt_type`, `elt_id`, `history_field`, `create_date`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `CQ1_3_history` ADD CONSTRAINT FK_history_service_id FOREIGN KEY (`service_id`) REFERENCES `CQ1_3_service`(`id`);

CREATE TABLE `CQ1_3_selection` (
	`service_id` INT NOT NULL,
	`id` INT NOT NULL,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`name` VARCHAR(256) NOT NULL,
	PRIMARY KEY (`service_id`, `id`),
	UNIQUE (`service_id`, `name`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `CQ1_3_selection` ADD CONSTRAINT FK_selection_service_id FOREIGN KEY (`service_id`) REFERENCES `CQ1_3_service`(`id`);

/* ajoute des votes aux quotes */
CREATE TABLE `CQ1_3_vote` (
	`service_id` INT NOT NULL,
	`id` INT NOT NULL AUTO_INCREMENT,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`elt_type` INT NOT NULL COMMENT '1:page, 2:quote, 3:comment',
	`elt_id` INT NOT NULL,
	`vote` BINARY NOT NULL COMMENT '1:up, 0:down',
	PRIMARY KEY (`service_id`, `post_ip`, `elt_type`, `elt_id`, `vote`),
	KEY (`id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `CQ1_3_vote` ADD CONSTRAINT FK_vote_service_id FOREIGN KEY (`service_id`) REFERENCES `CQ1_3_service`(`id`);
-- TRIGGER : quand on ajoute un vote, on incrémente `vote_up` ou `vote_down` dans la table quote ou comment

/* ajoute des signalements aux quotes */
CREATE TABLE `CQ1_3_reported` (
	`service_id` INT NOT NULL,
	`id` INT NOT NULL AUTO_INCREMENT,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`elt_type` INT NOT NULL COMMENT '1:page, 2:quote, 3:comment',
	`elt_id` INT NOT NULL,
	`cause` VARCHAR(256) default NULL,
	PRIMARY KEY (`service_id`, `post_ip`, `elt_type`, `elt_id`),
	KEY (`id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `CQ1_3_reported` ADD CONSTRAINT FK_reported_service_id FOREIGN KEY (`service_id`) REFERENCES `CQ1_3_service`(`id`);
-- TRIGGER : quand on ajoute un signalement, on incrémente `reported` dans la table quote ou comment

/* lie les quotes avec les categories */
CREATE TABLE `CQ1_3_category_quote` (
	`service_id` INT NOT NULL,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`quote_id` INT NOT NULL,
	`category_id` INT NOT NULL,
	`value` INT default 1,
	PRIMARY KEY (`service_id`, `post_ip`, `quote_id`, `category_id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `CQ1_3_category_quote` ADD CONSTRAINT FK_category_quote_service_id FOREIGN KEY (`service_id`) REFERENCES `CQ1_3_service`(`id`);
ALTER TABLE `CQ1_3_category_quote` ADD CONSTRAINT FK_category_quote_id FOREIGN KEY (`quote_id`) REFERENCES `CQ1_3_quotes`(`id`);
ALTER TABLE `CQ1_3_category_quote` ADD CONSTRAINT FK_category_category_id FOREIGN KEY (`category_id`) REFERENCES `CQ1_3_category`(`id`);

/* lie les sélections avec les quotes */
CREATE TABLE `CQ1_3_selection_quote` (
	`service_id` INT NOT NULL,
	`quote_id` INT NOT NULL,
	`selection_id` INT NOT NULL,
	PRIMARY KEY (`service_id`, `quote_id`, `selection_id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `CQ1_3_selection_quote` ADD CONSTRAINT FK_selection_quote_service_id FOREIGN KEY (`service_id`) REFERENCES `CQ1_3_service`(`id`);
ALTER TABLE `CQ1_3_selection_quote` ADD CONSTRAINT FK_selection_quote_id FOREIGN KEY (`quote_id`) REFERENCES `CQ1_3_quotes`(`id`);
ALTER TABLE `CQ1_3_selection_quote` ADD CONSTRAINT FK_selection_selection_id FOREIGN KEY (`selection_id`) REFERENCES `CQ1_3_selection`(`id`);

/* lie une adresse mail à un élément pour le suivre */
CREATE TABLE `CQ1_3_suivi` (
	`service_id` INT NOT NULL,
	`id` INT NOT NULL AUTO_INCREMENT,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`elt_type` INT NOT NULL COMMENT '1:page, 2:quote, 3:comment, 4:site, 5:event',
	`elt_id` INT NOT NULL,
	`mail` VARCHAR(256) default NULL,
	`name` VARCHAR(256) default NULL,
	`info` VARCHAR(256) default NULL,
	`actif` INT NOT NULL default 0 COMMENT '1:suivi, 2:non suivi',
	PRIMARY KEY (`service_id`, `elt_type`, `elt_id`, `mail`),
	KEY (`id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `CQ1_3_suivi` ADD CONSTRAINT FK_suivi_service_id FOREIGN KEY (`service_id`) REFERENCES `CQ1_3_service`(`id`);

/* log les appels à l'API */
CREATE TABLE `CQ1_3_api_log` (
	`service_id` INT NOT NULL,
	`id` INT NOT NULL AUTO_INCREMENT,
	`call_ip` INT NOT NULL,
	`call_key` VARCHAR(40) NOT NULL,
	`call_user_agent` VARCHAR(256) NOT NULL,
	`call_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`call` TEXT,
	PRIMARY KEY (`service_id`, `id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `CQ1_3_api_log` ADD CONSTRAINT FK_api_log_service_id FOREIGN KEY (`service_id`) REFERENCES `CQ1_3_service`(`id`);

/* log les requêtes effectuées en base ! */
CREATE TABLE `CQ1_3_sqlreq_log` (
	`service_id` INT NOT NULL,
	`id` INT NOT NULL AUTO_INCREMENT,
	`api_log_id` INT NOT NULL,
	`request_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`request` TEXT,
	PRIMARY KEY (`id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `CQ1_3_sqlreq_log` ADD CONSTRAINT FK_sqlreq_log_service_id FOREIGN KEY (`service_id`) REFERENCES `CQ1_3_service`(`id`);
ALTER TABLE `CQ1_3_sqlreq_log` ADD CONSTRAINT FK_sqlreq_log_call_id FOREIGN KEY (`api_log_id`) REFERENCES `CQ1_3_api_log`(`id`);

/* logs de l'application */
CREATE TABLE `CQ1_3_app_log` (
	`service_id` INT NOT NULL,
	`id` INT NOT NULL AUTO_INCREMENT,
	`log_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`msg` TEXT,
	PRIMARY KEY (`id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `CQ1_3_app_log` ADD CONSTRAINT FK_app_log_service_id FOREIGN KEY (`service_id`) REFERENCES `CQ1_3_service`(`id`);

/* controle la fréquence d'accès des clés. Indépendant des services... */
CREATE TABLE `CQ1_3_key_cpt` (
	`service_id` INT default NULL,
	`no` INT default NULL,
	`type` VARCHAR(5) default NULL COMMENT 'user or admin',
	`create_date` timestamp default CURRENT_TIMESTAMP,
	`key` VARCHAR(40) NOT NULL,
	`last_reset` INT NOT NULL COMMENT 'last reset timestamp',
	`cpt` INT NOT NULL default 1,
	`max_cpt` INT NOT NULL COMMENT 'nombre de requetes entre chaque reset',
	`reset_time` INT NOT NULL COMMENT 'nombre de secondes entre chaque reset',
	`commentaire` VARCHAR(256) default NULL,
	PRIMARY KEY (`key`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;



/* **************************
	AJOUTS
************************** */


/* permet de signer pour un élément */
CREATE TABLE `CQ1_3_petition` (
	`service_id` INT NOT NULL,
	`id` INT NOT NULL AUTO_INCREMENT,
	`sign_no` INT NOT NULL,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`elt_type` INT NOT NULL COMMENT '2:quote, 4:site',
	`elt_id` INT NOT NULL,
	`genre` INT default NULL COMMENT '1:Mr, 2:Mme',
	`prenom` VARCHAR(256) NOT NULL,
	`nom` VARCHAR(256) NOT NULL,
	`mail` VARCHAR(256) NOT NULL,
	`site` VARCHAR(256) default NULL,
	`age` INT default NULL COMMENT '1:0-18, 2:18-25, 3:25-50, 4:>50',
	`profession` VARCHAR(256) default NULL,
	`code_postal` VARCHAR(10) default NULL,
	`message` VARCHAR(256) default NULL,
	`etat` INT NOT NULL default 1 COMMENT '1:non validé, 2:validé, 3:supprimé',
	`validation_key` VARCHAR(40) NOT NULL,
	PRIMARY KEY (`service_id`, `id`),
	UNIQUE (`service_id`, `elt_type`, `elt_id`, `mail`),
	KEY (`sign_no`),
	KEY (`mail`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
/* autres infos : adresse postale, ville, pays, entreprise/association, nationnalité */








