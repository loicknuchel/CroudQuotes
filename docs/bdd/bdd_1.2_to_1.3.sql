

INSERT INTO `CQ1_3_bdd_info` (`version`) VALUES ('1.3');

INSERT INTO `CQ1_3_service` 		(SELECT `id`, `name`, `code`, `nbUsedKey`, `nbUsedAdminKey` FROM `newCQ_service`);
INSERT INTO `CQ1_3_id_increment` 	(SELECT `service_id`, `id_category`, `id_quote`, `id_comment`, `id_selection` FROM `newCQ_id_increment`);
INSERT INTO `CQ1_3_category` 		(SELECT `service_id`, `id`, `post_ip`, `post_date`, `name` FROM `newCQ_category`);
INSERT INTO `CQ1_3_quote` 			(SELECT `service_id`, `id`, `post_ip`, `post_date`, `quote`, `source`, `context`, `explanation`, `author`, `publisher`, `publisher_info`, `mail`, `site`, `category`, `vote_up`, `vote_down`, `comments`, '0', `reported`, `quote_state` FROM `newCQ_quote`);
INSERT INTO `CQ1_3_comment` 		(SELECT `service_id`, `id`, `post_ip`, `post_date`, `elt_type`, `elt_id`, `publisher`, `mail`, `site`, `comment`, `vote_up`, `vote_down`, `reported`, `comment_state` FROM `newCQ_comment`);
INSERT INTO `CQ1_3_history` 		(SELECT `service_id`, `elt_type`, `elt_id`, `history_field`, `create_date`, `content` FROM `newCQ_history`);
INSERT INTO `CQ1_3_selection` 		(SELECT `service_id`, `id`, `post_ip`, `post_date`, `name` FROM `newCQ_selection`);
INSERT INTO `CQ1_3_vote` 			(SELECT `service_id`, `id`, `post_ip`, `post_date`, `elt_type`, `elt_id`, `vote` FROM `newCQ_vote`);
INSERT INTO `CQ1_3_reported` 		(SELECT `service_id`, `id`, `post_ip`, `post_date`, `elt_type`, `elt_id`, `cause` FROM `newCQ_reported`);
INSERT INTO `CQ1_3_category_quote` 	(SELECT `service_id`, `post_ip`, `post_date`, `quote_id`, `category_id`, `value` FROM `newCQ_category_quote`);
INSERT INTO `CQ1_3_selection_quote` (SELECT `service_id`, `quote_id`, `selection_id` FROM `newCQ_selection_quote`);
INSERT INTO `CQ1_3_suivi` 			(SELECT `service_id`, `id`, `post_ip`, `post_date`, `elt_type`, `elt_id`, `mail`, null, null, `actif` FROM `newCQ_suivi`);
INSERT INTO `CQ1_3_api_log` 		(SELECT `service_id`, `id`, `call_ip`, `call_key`, `call_user_agent`, `call_date`, `call` FROM `newCQ_api_log`);
INSERT INTO `CQ1_3_sqlreq_log` 		(SELECT `service_id`, `id`, `api_log_id`, `request_date`, `request` FROM `newCQ_sqlreq_log`);
INSERT INTO `CQ1_3_app_log` 		(SELECT `service_id`, `id`, `log_date`, `msg` FROM `newCQ_app_log`);
INSERT INTO `CQ1_3_key_cpt` 		(SELECT `service_id`, `no`, `type`, `create_date`, `key`, `last_reset`, `cpt`, `max_cpt`, `reset_time`, `commentaire` FROM `newCQ_key_cpt`);

