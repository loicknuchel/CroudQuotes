
DROP TABLE IF EXISTS `CQtest_cpt_key`;
DROP TABLE IF EXISTS `CQtest_logs_req`;
DROP TABLE IF EXISTS `CQtest_logs_api`;
DROP TABLE IF EXISTS `CQtest_selection_quote`;
DROP TABLE IF EXISTS `CQtest_selection`;
DROP TABLE IF EXISTS `CQtest_reported_comment`;
DROP TABLE IF EXISTS `CQtest_reported_quote`;
DROP TABLE IF EXISTS `CQtest_vote_comment`;
DROP TABLE IF EXISTS `CQtest_vote_quote`;
DROP TABLE IF EXISTS `CQtest_comment`;
DROP TABLE IF EXISTS `CQtest_category_quote`;
DROP TABLE IF EXISTS `CQtest_quote`;
DROP TABLE IF EXISTS `CQtest_category`;

CREATE TABLE `CQtest_category` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`name` VARCHAR(256) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (name)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `CQtest_quote` (
	`id` INT NOT NULL AUTO_INCREMENT,
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
	PRIMARY KEY (id),
	KEY (category),
	KEY (post_date)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE CQtest_quote ADD CONSTRAINT FK_CQtest_quote_category FOREIGN KEY (category) REFERENCES CQtest_category(id);

CREATE TABLE `CQtest_category_quote` (
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`quote_id` INT NOT NULL,
	`category_id` INT NOT NULL,
	`value` INT default 1,
	PRIMARY KEY (post_ip,quote_id,category_id)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE CQtest_category_quote ADD CONSTRAINT FK_CQtest_category_quote_id FOREIGN KEY (quote_id) REFERENCES CQtest_quotes(id);
ALTER TABLE CQtest_category_quote ADD CONSTRAINT FK_CQtest_category_category_id FOREIGN KEY (category_id) REFERENCES CQtest_category(id);


CREATE TABLE `CQtest_comment` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`quote_id` INT NOT NULL,
	`publisher` VARCHAR(256) NOT NULL,
	`mail` VARCHAR(256) default NULL,
	`site` VARCHAR(256) default NULL,
	`comment` TEXT NOT NULL,
	`vote_up` INT NOT NULL default 0,
	`vote_down` INT NOT NULL default 0,
	`reported` INT NOT NULL default 0,
	`comment_state` INT NOT NULL default 0 COMMENT '0:public, 1:reported, 2:deleted',
	PRIMARY KEY (id),
	KEY (post_date),
	KEY (quote_id)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE CQtest_comment ADD CONSTRAINT FK_CQtest_comment_quote_id FOREIGN KEY (quote_id) REFERENCES CQtest_quotes(id) ON DELETE CASCADE;
-- TRIGGER : quand on ajoute un commentaire, on incrémente `comments` dans la table quote

CREATE TABLE `CQtest_vote_quote` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`quote_id` INT NOT NULL,
	`vote` BINARY NOT NULL COMMENT '1 => up, 0 => down',
	PRIMARY KEY (id),
	UNIQUE (post_ip,quote_id,vote),
	KEY (quote_id)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE CQtest_vote_quote ADD CONSTRAINT FK_CQtest_vote_quote_id FOREIGN KEY (quote_id) REFERENCES CQtest_quotes(id) ON DELETE CASCADE;
-- TRIGGER : quand on ajoute un vote, on incrémente `vote_up` ou `vote_down` dans la table quote

CREATE TABLE `CQtest_vote_comment` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`comment_id` INT NOT NULL,
	`vote` BINARY NOT NULL COMMENT '1 => up, 0 => down',
	PRIMARY KEY (id),
	UNIQUE (post_ip,comment_id,vote),
	KEY (comment_id)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE CQtest_vote_comment ADD CONSTRAINT FK_CQtest_vote_comment_id FOREIGN KEY (comment_id) REFERENCES CQtest_comment(id) ON DELETE CASCADE;
-- TRIGGER : quand on ajoute un vote, on incrémente `vote_up` ou `vote_down` dans la table quote

CREATE TABLE `CQtest_reported_quote` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`quote_id` INT NOT NULL,
	`cause` VARCHAR(256) default NULL,
	PRIMARY KEY (id),
	UNIQUE (post_ip,quote_id),
	KEY (quote_id)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE CQtest_reported_quote ADD CONSTRAINT FK_CQtest_reported_quote_id FOREIGN KEY (quote_id) REFERENCES CQtest_quotes(id) ON DELETE CASCADE;
-- TRIGGER : quand on ajoute un signalement, on incrémente `reported` dans la table quote

CREATE TABLE `CQtest_reported_comment` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`comment_id` INT NOT NULL,
	`cause` VARCHAR(256) default NULL,
	PRIMARY KEY (id),
	UNIQUE (post_ip,comment_id),
	KEY (comment_id)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE CQtest_reported_comment ADD CONSTRAINT FK_CQtest_reported_comment_id FOREIGN KEY (comment_id) REFERENCES CQtest_comment(id) ON DELETE CASCADE;
-- TRIGGER : quand on ajoute un signalement, on incrémente `reported` dans la table quote

CREATE TABLE `CQtest_selection` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`post_ip` INT NOT NULL,
	`post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`name` VARCHAR(256) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (name)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `CQtest_selection_quote` (
	`quote_id` INT NOT NULL,
	`selection_id` INT NOT NULL,
	PRIMARY KEY (quote_id,selection_id)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE CQtest_selection_quote ADD CONSTRAINT FK_CQtest_selection_quote_id FOREIGN KEY (quote_id) REFERENCES CQtest_quotes(id);
ALTER TABLE CQtest_selection_quote ADD CONSTRAINT FK_CQtest_selection_selection_id FOREIGN KEY (selection_id) REFERENCES CQtest_selection(id);

CREATE TABLE `CQtest_logs_api` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`call_ip` INT NOT NULL,
	`call_key` VARCHAR(40) NOT NULL,
	`call_user_agent` VARCHAR(256) NOT NULL,
	`call_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`call` TEXT,
	PRIMARY KEY (id)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `CQtest_logs_req` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`call_id` INT NOT NULL,
	`request_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	`request` TEXT,
	PRIMARY KEY (id)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE CQtest_logs_req ADD CONSTRAINT FK_CQtest_logs_req_call_id FOREIGN KEY (call_id) REFERENCES CQtest_logs_api(id);

CREATE TABLE `CQtest_cpt_key` (
	`key` VARCHAR(40) NOT NULL,
	`last_reset` INT NOT NULL COMMENT 'timestamp reseted every minute',
	`cpt` INT NOT NULL default 1,
	`max_cpt` INT NOT NULL COMMENT 'nombre de requetes entre chaque reset',
	`reset_time` INT NOT NULL COMMENT 'nombre de secondes entre chaque reset',
	PRIMARY KEY (`key`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

