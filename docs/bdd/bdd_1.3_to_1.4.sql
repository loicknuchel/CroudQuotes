

INSERT INTO `CQ1_4_bdd_info` 		(`version`) VALUES ('1.4');
INSERT INTO `CQ1_4_service` 		(SELECT `id`, `name`, `code`, `nbUsedKey`, `nbUsedAdminKey` FROM `CQ1_3_service`);
INSERT INTO `CQ1_4_id_increment` 	(SELECT `service_id`, `id_category`, `id_quote`, `id_comment`, `id_selection` FROM `CQ1_3_id_increment`);
INSERT INTO `CQ1_4_category` 		(SELECT `service_id`, `id`, `post_ip`, `post_date`, `name` FROM `CQ1_3_category`);
INSERT INTO `CQ1_4_quote` 			(SELECT `service_id`, `id`, `post_ip`, `post_date`, `quote`, `source`, `context`, `explanation`, `author`, `publisher`, `publisher_info`, `mail`, `site`, `category`, `vote_up`, `vote_down`, `comments`, `signatures`, `reported`, `quote_state` FROM `CQ1_3_quote`);
INSERT INTO `CQ1_4_comment` 		(SELECT `service_id`, `id`, `post_ip`, `post_date`, `elt_type`, `elt_id`, `avis`, `publisher`, `mail`, `site`, `comment`, `vote_up`, `vote_down`, `reported`, `comment_state` FROM `CQ1_3_comment`);
INSERT INTO `CQ1_4_history` 		(SELECT `service_id`, `elt_type`, `elt_id`, `history_field`, `create_date`, `content` FROM `CQ1_3_history`);
INSERT INTO `CQ1_4_selection` 		(SELECT `service_id`, `id`, `post_ip`, `post_date`, `name` FROM `CQ1_3_selection`);
INSERT INTO `CQ1_4_vote` 			(SELECT `service_id`, `id`, `post_ip`, `post_date`, `elt_type`, `elt_id`, `vote` FROM `CQ1_3_vote`);
INSERT INTO `CQ1_4_reported` 		(SELECT `service_id`, `id`, `post_ip`, `post_date`, `elt_type`, `elt_id`, `cause` FROM `CQ1_3_reported`);
INSERT INTO `CQ1_4_category_quote` 	(SELECT `service_id`, `post_ip`, `post_date`, `quote_id`, `category_id`, `value` FROM `CQ1_3_category_quote`);
INSERT INTO `CQ1_4_selection_quote` (SELECT `service_id`, `quote_id`, `selection_id` FROM `CQ1_3_selection_quote`);
INSERT INTO `CQ1_4_suivi` 			(SELECT `service_id`, `id`, `post_ip`, `post_date`, `elt_type`, `elt_id`, `mail`, null, null, `actif` FROM `CQ1_3_suivi`);
INSERT INTO `CQ1_4_api_log` 		(SELECT `service_id`, `id`, `call_ip`, `call_key`, `call_user_agent`, `call_date`, `call` FROM `CQ1_3_api_log`);
INSERT INTO `CQ1_4_sqlreq_log` 		(SELECT `service_id`, `id`, `api_log_id`, `request_date`, `request` FROM `CQ1_3_sqlreq_log`);
INSERT INTO `CQ1_4_app_log` 		(SELECT `service_id`, `id`, `log_date`, `msg` FROM `CQ1_3_app_log`);
INSERT INTO `CQ1_4_key_cpt` 		(SELECT `service_id`, `no`, `type`, `create_date`, `key`, `last_reset`, `cpt`, `max_cpt`, `reset_time`, `commentaire` FROM `CQ1_3_key_cpt`);

