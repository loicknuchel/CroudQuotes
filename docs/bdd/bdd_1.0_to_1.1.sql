DROP TABLE IF EXISTS `CQtest_info`;CREATE TABLE `CQtest_info` (	`bdd_1_1` INT NOT NULL) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;DROP TABLE IF EXISTS `CQtest_suivi_quote`;CREATE TABLE `CQtest_suivi_quote` (	`id` INT NOT NULL AUTO_INCREMENT,	`post_ip` INT NOT NULL,	`quote_id` INT NOT NULL,	`mail` VARCHAR(256) default NULL,	`new_comments` INT NOT NULL default 0 COMMENT '0:non suivi, 1:suivi',	PRIMARY KEY (quote_id, mail),	KEY (id)) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;ALTER TABLE CQtest_suivi_quote ADD CONSTRAINT FK_CQtest_suivi_quote_id FOREIGN KEY (quote_id) REFERENCES CQtest_quotes(id);