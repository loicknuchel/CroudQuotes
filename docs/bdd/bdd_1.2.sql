
/*
	TODO :
	- créer une table petition
	- créer une table user, accepted_mail ou autre...
	- dans la table newCQ_api_log, ajouter une colonne methode et une colonne params
*/

DROP TABLE IF EXISTS `newCQ_history`;
DROP TABLE IF EXISTS `newCQ_key_cpt`;
DROP TABLE IF EXISTS `newCQ_app_log`;
DROP TABLE IF EXISTS `newCQ_sqlreq_log`;
DROP TABLE IF EXISTS `newCQ_api_log`;
DROP TABLE IF EXISTS `newCQ_suivi`;
DROP TABLE IF EXISTS `newCQ_selection_quote`;
DROP TABLE IF EXISTS `newCQ_category_quote`;
DROP TABLE IF EXISTS `newCQ_reported`;
DROP TABLE IF EXISTS `newCQ_vote`;
DROP TABLE IF EXISTS `newCQ_selection`;
DROP TABLE IF EXISTS `newCQ_comment`;
DROP TABLE IF EXISTS `newCQ_quote`;
DROP TABLE IF EXISTS `newCQ_category`;
DROP TABLE IF EXISTS `newCQ_id_increment`;
DROP TABLE IF EXISTS `newCQ_service`;
DROP TABLE IF EXISTS `newCQ_info`;

CREATE TABLE `newCQ_info` (
	`bdd_1_2` INT NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `newCQ_service` (
	`id` INT NOT NULL,
	`name` VARCHAR(256) NOT NULL,
	`code` VARCHAR(256) NOT NULL,
	`nbUsedKey` INT NOT NULL default 1,
	`nbUsedAdminKey` INT NOT NULL default 1,
	PRIMARY KEY (`id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `newCQ_id_increment` (
	`service_id` INT NOT NULL,
	`id_category` INT NOT NULL default 0,
	`id_quote` INT NOT NULL default 0,
	`id_comment` INT NOT NULL default 0,
	`id_selection` INT NOT NULL default 0
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `newCQ_id_increment` ADD CONSTRAINT FK_id_increment_service_id FOREIGN KEY (`service_id`) REFERENCES `newCQ_service`(`id`);

CREATE TABLE `newCQ_category` (
	`service_id` INT NOT NULL,
	`id` INT NOT NULL,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`name` VARCHAR(256) NOT NULL,
	PRIMARY KEY (`service_id`, `id`),
	UNIQUE (`service_id`, `name`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `newCQ_category` ADD CONSTRAINT FK_category_service_id FOREIGN KEY (`service_id`) REFERENCES `newCQ_service`(`id`);

CREATE TABLE `newCQ_quote` (
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
	`reported` INT NOT NULL default 0,
	`quote_state` INT NOT NULL default 0 COMMENT '0:public, 1:reported, 2:deleted',
	PRIMARY KEY (`service_id`, `id`),
	KEY (`category`),
	KEY (`post_date`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `newCQ_quote` ADD CONSTRAINT FK_quote_service_id FOREIGN KEY (`service_id`) REFERENCES `newCQ_service`(`id`);
ALTER TABLE `newCQ_quote` ADD CONSTRAINT FK_quote_category FOREIGN KEY (`category`) REFERENCES `newCQ_category`(`id`);

CREATE TABLE `newCQ_comment` (
	`service_id` INT NOT NULL,
	`id` INT NOT NULL,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`elt_type` INT NOT NULL COMMENT '1:page, 2:quote, 3:comment',
	`elt_id` INT NOT NULL,
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
ALTER TABLE `newCQ_comment` ADD CONSTRAINT FK_comment_service_id FOREIGN KEY (`service_id`) REFERENCES `newCQ_service`(`id`);
-- TRIGGER : quand on ajoute un commentaire, on incrémente `comments` dans la table quote

CREATE TABLE `newCQ_selection` (
	`service_id` INT NOT NULL,
	`id` INT NOT NULL,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`name` VARCHAR(256) NOT NULL,
	PRIMARY KEY (`service_id`, `id`),
	UNIQUE (`service_id`, `name`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `newCQ_selection` ADD CONSTRAINT FK_selection_service_id FOREIGN KEY (`service_id`) REFERENCES `newCQ_service`(`id`);

/* ajoute des votes aux quotes */
CREATE TABLE `newCQ_vote` (
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
ALTER TABLE `newCQ_vote` ADD CONSTRAINT FK_vote_service_id FOREIGN KEY (`service_id`) REFERENCES `newCQ_service`(`id`);
-- TRIGGER : quand on ajoute un vote, on incrémente `vote_up` ou `vote_down` dans la table quote ou comment

/* ajoute des signalements aux quotes */
CREATE TABLE `newCQ_reported` (
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
ALTER TABLE `newCQ_reported` ADD CONSTRAINT FK_reported_service_id FOREIGN KEY (`service_id`) REFERENCES `newCQ_service`(`id`);
-- TRIGGER : quand on ajoute un signalement, on incrémente `reported` dans la table quote ou comment

/* lie les quotes avec les categories */
CREATE TABLE `newCQ_category_quote` (
	`service_id` INT NOT NULL,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`quote_id` INT NOT NULL,
	`category_id` INT NOT NULL,
	`value` INT default 1,
	PRIMARY KEY (`service_id`, `post_ip`, `quote_id`, `category_id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `newCQ_category_quote` ADD CONSTRAINT FK_category_quote_service_id FOREIGN KEY (`service_id`) REFERENCES `newCQ_service`(`id`);
ALTER TABLE `newCQ_category_quote` ADD CONSTRAINT FK_category_quote_id FOREIGN KEY (`quote_id`) REFERENCES `newCQ_quotes`(`id`);
ALTER TABLE `newCQ_category_quote` ADD CONSTRAINT FK_category_category_id FOREIGN KEY (`category_id`) REFERENCES `newCQ_category`(`id`);

/* lie les sélections avec les quotes */
CREATE TABLE `newCQ_selection_quote` (
	`service_id` INT NOT NULL,
	`quote_id` INT NOT NULL,
	`selection_id` INT NOT NULL,
	PRIMARY KEY (`service_id`, `quote_id`, `selection_id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `newCQ_selection_quote` ADD CONSTRAINT FK_selection_quote_service_id FOREIGN KEY (`service_id`) REFERENCES `newCQ_service`(`id`);
ALTER TABLE `newCQ_selection_quote` ADD CONSTRAINT FK_selection_quote_id FOREIGN KEY (`quote_id`) REFERENCES `newCQ_quotes`(`id`);
ALTER TABLE `newCQ_selection_quote` ADD CONSTRAINT FK_selection_selection_id FOREIGN KEY (`selection_id`) REFERENCES `newCQ_selection`(`id`);

/* lie une adresse mail à un élément pour le suivre */
CREATE TABLE `newCQ_suivi` (
	`service_id` INT NOT NULL,
	`id` INT NOT NULL AUTO_INCREMENT,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`elt_type` INT NOT NULL COMMENT '1:page, 2:quote, 3:comment, 4:site',
	`elt_id` INT NOT NULL,
	`mail` VARCHAR(256) default NULL,
	`actif` INT NOT NULL default 0 COMMENT '1:suivi, 2:non suivi',
	PRIMARY KEY (`service_id`, `elt_type`, `elt_id`, `mail`),
	KEY (`id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `newCQ_suivi` ADD CONSTRAINT FK_suivi_service_id FOREIGN KEY (`service_id`) REFERENCES `newCQ_service`(`id`);

/* log les appels à l'API */
CREATE TABLE `newCQ_api_log` (
	`service_id` INT NOT NULL,
	`id` INT NOT NULL AUTO_INCREMENT,
	`call_ip` INT NOT NULL,
	`call_key` VARCHAR(40) NOT NULL,
	`call_user_agent` VARCHAR(256) NOT NULL,
	`call_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`call` TEXT,
	PRIMARY KEY (`service_id`, `id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `newCQ_api_log` ADD CONSTRAINT FK_api_log_service_id FOREIGN KEY (`service_id`) REFERENCES `newCQ_service`(`id`);

/* log les requêtes effectuées en base ! */
CREATE TABLE `newCQ_sqlreq_log` (
	`service_id` INT NOT NULL,
	`id` INT NOT NULL AUTO_INCREMENT,
	`api_log_id` INT NOT NULL,
	`request_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`request` TEXT,
	PRIMARY KEY (`id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `newCQ_sqlreq_log` ADD CONSTRAINT FK_sqlreq_log_service_id FOREIGN KEY (`service_id`) REFERENCES `newCQ_service`(`id`);
ALTER TABLE `newCQ_sqlreq_log` ADD CONSTRAINT FK_sqlreq_log_call_id FOREIGN KEY (`api_log_id`) REFERENCES `newCQ_api_log`(`id`);

/* logs de l'application */
CREATE TABLE `newCQ_app_log` (
	`service_id` INT NOT NULL,
	`id` INT NOT NULL AUTO_INCREMENT,
	`log_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`msg` TEXT,
	PRIMARY KEY (`id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `newCQ_app_log` ADD CONSTRAINT FK_app_log_service_id FOREIGN KEY (`service_id`) REFERENCES `newCQ_service`(`id`);

/* controle la fréquence d'accès des clés. Indépendant des services... */
CREATE TABLE `newCQ_key_cpt` (
	`service_id` INT default NULL,
	`no` INT default NULL,
	`type` VARCHAR(5) default NULL,
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

/* gère l'historique de modification de certains camps */
CREATE TABLE `newCQ_history` (
	`service_id` INT NOT NULL,
	`elt_type` INT NOT NULL COMMENT '1:page, 2:quote, 3:comment',
	`elt_id` INT NOT NULL,
	`history_field` INT NOT NULL COMMENT '10:quote.quote, 11:quote.source, 12:quote.context, 13:quote.explanation, 14:quote.author, 20:comment.comment',
	`create_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`content` TEXT,
	PRIMARY KEY (`service_id`, `elt_type`, `elt_id`, `history_field`, `create_date`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `newCQ_history` ADD CONSTRAINT FK_history_service_id FOREIGN KEY (`service_id`) REFERENCES `newCQ_service`(`id`);










