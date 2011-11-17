
/* nouvelles tables */
INSERT INTO `newCQ_service` (`id` ,`name`, `code`, `nbUsedKey`, `nbUsedAdminKey`) VALUES 
('1','test','test','2','1'), 
('2','dev','developpement','2','1'), 
('3','demo','demos','2','1'), 
('4','mp2012','monprogramme2012','2','1'), 
('5','ps12','themaps12','2','1');
INSERT INTO `newCQ_id_increment` (`service_id`) VALUES ('1'), ('2'), ('3'), ('4'), ('5');

/* MAJ des increment */
UPDATE `newCQ_id_increment` SET `id_category`=(SELECT `id` FROM CQtest_category ORDER BY id DESC LIMIT 1) WHERE `service_id`=1;
UPDATE `newCQ_id_increment` SET `id_category`=(SELECT `id` FROM CQmp2012_category ORDER BY id DESC LIMIT 1) WHERE `service_id`=4;
UPDATE `newCQ_id_increment` SET `id_category`=(SELECT `id` FROM CQps12_category ORDER BY id DESC LIMIT 1) WHERE `service_id`=5;
UPDATE `newCQ_id_increment` SET `id_quote`=(SELECT `id` FROM CQtest_quote ORDER BY id DESC LIMIT 1) WHERE `service_id`=1;
UPDATE `newCQ_id_increment` SET `id_quote`=(SELECT `id` FROM CQmp2012_quote ORDER BY id DESC LIMIT 1) WHERE `service_id`=4;
UPDATE `newCQ_id_increment` SET `id_quote`=(SELECT `id` FROM CQps12_quote ORDER BY id DESC LIMIT 1) WHERE `service_id`=5;
UPDATE `newCQ_id_increment` SET `id_comment`=(SELECT `id` FROM CQtest_comment ORDER BY id DESC LIMIT 1) WHERE `service_id`=1;
UPDATE `newCQ_id_increment` SET `id_comment`=(SELECT `id` FROM CQmp2012_comment ORDER BY id DESC LIMIT 1) WHERE `service_id`=4;
UPDATE `newCQ_id_increment` SET `id_comment`=(SELECT `id` FROM CQps12_comment ORDER BY id DESC LIMIT 1) WHERE `service_id`=5;
UPDATE `newCQ_id_increment` SET `id_selection`=(SELECT `id` FROM CQtest_selection ORDER BY id DESC LIMIT 1) WHERE `service_id`=1;
UPDATE `newCQ_id_increment` SET `id_selection`=(SELECT `id` FROM CQmp2012_selection ORDER BY id DESC LIMIT 1) WHERE `service_id`=4;
UPDATE `newCQ_id_increment` SET `id_selection`=(SELECT `id` FROM CQps12_selection ORDER BY id DESC LIMIT 1) WHERE `service_id`=5;


/* MAJ des données */
INSERT INTO `newCQ_category` (SELECT '1', `id`, `post_ip`, `post_date`, `name` FROM `CQtest_category`);
INSERT INTO `newCQ_category` (SELECT '4', `id`, `post_ip`, `post_date`, `name` FROM `CQmp2012_category`);
INSERT INTO `newCQ_category` (SELECT '5', `id`, `post_ip`, `post_date`, `name` FROM `CQps12_category`);

INSERT INTO `newCQ_quote` (SELECT '1', `id`, `post_ip`, `post_date`, `quote`, `source`, `context`, `explanation`, `author`, `publisher`, `publisher_info`, `mail`, `site`, `category`, `vote_up`, `vote_down`, `comments`, `reported`, `quote_state` FROM `CQtest_quote`);
INSERT INTO `newCQ_quote` (SELECT '4', `id`, `post_ip`, `post_date`, `quote`, `source`, `context`, `explanation`, `author`, `publisher`, `publisher_info`, `mail`, `site`, `category`, `vote_up`, `vote_down`, `comments`, `reported`, `quote_state` FROM `CQmp2012_quote`);
INSERT INTO `newCQ_quote` (SELECT '5', `id`, `post_ip`, `post_date`, `quote`, `source`, `context`, `explanation`, `author`, `publisher`, `publisher_info`, `mail`, `site`, `category`, `vote_up`, `vote_down`, `comments`, `reported`, `quote_state` FROM `CQps12_quote`);

INSERT INTO `newCQ_comment` (SELECT '1', `id`, `post_ip`, `post_date`, '2', `quote_id`, `publisher`, `mail`, `site`, `comment`, `vote_up`, `vote_down`, `reported`, `comment_state` FROM `CQtest_comment`);
INSERT INTO `newCQ_comment` (SELECT '4', `id`, `post_ip`, `post_date`, '2', `quote_id`, `publisher`, `mail`, `site`, `comment`, `vote_up`, `vote_down`, `reported`, `comment_state` FROM `CQmp2012_comment`);
INSERT INTO `newCQ_comment` (SELECT '5', `id`, `post_ip`, `post_date`, '2', `quote_id`, `publisher`, `mail`, `site`, `comment`, `vote_up`, `vote_down`, `reported`, `comment_state` FROM `CQps12_comment`);

INSERT INTO `newCQ_selection` (SELECT '1', `id`, `post_ip`, `post_date`, `name` FROM `CQtest_selection`);
INSERT INTO `newCQ_selection` (SELECT '4', `id`, `post_ip`, `post_date`, `name` FROM `CQmp2012_selection`);
INSERT INTO `newCQ_selection` (SELECT '5', `id`, `post_ip`, `post_date`, `name` FROM `CQps12_selection`);

INSERT INTO `newCQ_vote` (SELECT '1', `id`, `post_ip`, `post_date`, '2', `quote_id`, `vote` FROM `CQtest_vote_quote`);
INSERT INTO `newCQ_vote` (SELECT '4', `id`+(SELECT count(*) FROM `newCQ_vote`), `post_ip`, `post_date`, '2', `quote_id`, `vote` FROM `CQmp2012_vote_quote`);
INSERT INTO `newCQ_vote` (SELECT '5', `id`+(SELECT count(*) FROM `newCQ_vote`), `post_ip`, `post_date`, '2', `quote_id`, `vote` FROM `CQps12_vote_quote`);
INSERT INTO `newCQ_vote` (SELECT '1', `id`+(SELECT count(*) FROM `newCQ_vote`), `post_ip`, `post_date`, '3', `comment_id`, `vote` FROM `CQtest_vote_comment`);
INSERT INTO `newCQ_vote` (SELECT '4', `id`+(SELECT count(*) FROM `newCQ_vote`), `post_ip`, `post_date`, '3', `comment_id`, `vote` FROM `CQmp2012_vote_comment`);
INSERT INTO `newCQ_vote` (SELECT '5', `id`+(SELECT count(*) FROM `newCQ_vote`), `post_ip`, `post_date`, '3', `comment_id`, `vote` FROM `CQps12_vote_comment`);

INSERT INTO `newCQ_reported` (SELECT '1', `id`, `post_ip`, `post_date`, '2', `quote_id`, `cause` FROM `CQtest_reported_quote`);
INSERT INTO `newCQ_reported` (SELECT '4', `id`+(SELECT count(*) FROM `newCQ_reported`), `post_ip`, `post_date`, '2', `quote_id`, `cause` FROM `CQmp2012_reported_quote`);
INSERT INTO `newCQ_reported` (SELECT '5', `id`+(SELECT count(*) FROM `newCQ_reported`), `post_ip`, `post_date`, '2', `quote_id`, `cause` FROM `CQps12_reported_quote`);
INSERT INTO `newCQ_reported` (SELECT '1', `id`+(SELECT count(*) FROM `newCQ_reported`), `post_ip`, `post_date`, '3', `comment_id`, `cause` FROM `CQtest_reported_comment`);
INSERT INTO `newCQ_reported` (SELECT '4', `id`+(SELECT count(*) FROM `newCQ_reported`), `post_ip`, `post_date`, '3', `comment_id`, `cause` FROM `CQmp2012_reported_comment`);
INSERT INTO `newCQ_reported` (SELECT '5', `id`+(SELECT count(*) FROM `newCQ_reported`), `post_ip`, `post_date`, '3', `comment_id`, `cause` FROM `CQps12_reported_comment`);

INSERT INTO `newCQ_category_quote` (SELECT '1', `post_ip`, `post_date`, `quote_id`, `category_id`, `value` FROM `CQtest_category_quote`);
INSERT INTO `newCQ_category_quote` (SELECT '4', `post_ip`, `post_date`, `quote_id`, `category_id`, `value` FROM `CQmp2012_category_quote`);
INSERT INTO `newCQ_category_quote` (SELECT '5', `post_ip`, `post_date`, `quote_id`, `category_id`, `value` FROM `CQps12_category_quote`);

INSERT INTO `newCQ_selection_quote` (SELECT '1', `quote_id`, `selection_id` FROM `CQtest_selection_quote`);
INSERT INTO `newCQ_selection_quote` (SELECT '4', `quote_id`, `selection_id` FROM `CQmp2012_selection_quote`);
INSERT INTO `newCQ_selection_quote` (SELECT '5', `quote_id`, `selection_id` FROM `CQps12_selection_quote`);

INSERT INTO `newCQ_suivi` (SELECT '1', `id`, `post_ip`, null, '2', `quote_id`, `mail`, `new_comments` FROM `CQtest_suivi_quote`);
INSERT INTO `newCQ_suivi` (SELECT '4', `id`, `post_ip`, null, '2', `quote_id`, `mail`, `new_comments` FROM `CQmp2012_suivi_quote`);
INSERT INTO `newCQ_suivi` (SELECT '5', `id`, `post_ip`, null, '2', `quote_id`, `mail`, `new_comments` FROM `CQps12_suivi_quote`);

INSERT INTO `newCQ_api_log` (SELECT '1', `id`, `call_ip`, `call_key`, `call_user_agent`, `call_date`, `call` FROM `CQtest_logs_api`);
INSERT INTO `newCQ_api_log` (SELECT '4', `id`, `call_ip`, `call_key`, `call_user_agent`, `call_date`, `call` FROM `CQmp2012_logs_api`);
INSERT INTO `newCQ_api_log` (SELECT '5', `id`, `call_ip`, `call_key`, `call_user_agent`, `call_date`, `call` FROM `CQps12_logs_api`);

INSERT INTO `newCQ_sqlreq_log` (SELECT '1', `id`, `call_id`, `request_date`, `request` FROM `CQtest_logs_req`);
INSERT INTO `newCQ_sqlreq_log` (SELECT '4', `id`, `call_id`, `request_date`, `request` FROM `CQmp2012_logs_req`);
INSERT INTO `newCQ_sqlreq_log` (SELECT '5', `id`, `call_id`, `request_date`, `request` FROM `CQps12_logs_req`);

INSERT INTO `newCQ_key_cpt` (SELECT '1', NULL, 'user', '0', `key`, `last_reset`, `cpt`, `max_cpt`, `reset_time`, NULL FROM `CQtest_cpt_key`);
INSERT INTO `newCQ_key_cpt` (SELECT '4', NULL, 'user', '0', `key`, `last_reset`, `cpt`, `max_cpt`, `reset_time`, NULL FROM `CQmp2012_cpt_key`);
INSERT INTO `newCQ_key_cpt` (SELECT '5', NULL, 'user', '0', `key`, `last_reset`, `cpt`, `max_cpt`, `reset_time`, NULL FROM `CQps12_cpt_key`);


