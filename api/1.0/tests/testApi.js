$(function(){
	var base_url = 'http://lkws.fr/croudquotes/server/api/1.0/';
	var key = '3e6e97b719e2e92bcbd1587b00c4385b0ede8203';
	
	/*
		PROBLEMES :
			- vérification des jsons pour les GET : la post_date change quand je réinitialise la bdd
	*/
	
/**********************************************************************************************************************/
/* GET QUOTES */
{
	// quote.php:GET?key={key}&quoteid={quoteid}[&p={no_comment_page}][&nocomment=1]
	$("#test1 .launch").click(function(event){
		var id = '#test1';
		var url = base_url+'quote.php?quoteid=3&key='+key+'';
		$(id+" .result").html('debut');
		$.get(url, function(data){
			$(id+" .result").html('result...<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200 
				&& obj['response']['id'] == 3 
				&& obj['response']['quote'] == "On ne mélange pas les torchons avec les servlet ! Un poin c est tout." 
				&& obj['response']['source'] == '' 
				&& obj['response']['context'] == "Cette ciation a été utilisée lors de l'anniversaire du JUG au concours de SFEIR. Elle n'a malheureusement pas gagné." 
				&& obj['response']['explanation'] == "Pour ceux qui n'auraient pas compris, c'est un détournement du proverbe très connu avec des mots similaires en informatique..." 
				&& obj['response']['author'] == "tim" 
				&& obj['response']['publisher'] == '' 
				&& obj['response']['site'] == '' 
				&& obj['response']['category'] == "loic quotes" 
				&& obj['response']['category_id'] == 1 
				&& obj['response']['up'] == 3 
				&& obj['response']['down'] == 1 
				&& obj['response']['total_comments'] == 7 
				&& obj['response']['comments'][0]['id'] == 1 
				&& obj['response']['comments'][0]['publisher'] == 'hank' 
				&& obj['response']['comments'][0]['reported'] == 1 
				&& obj['response']['comments'][1]['id'] == 2 
				&& obj['response']['comments'][2]['id'] == 4 
				&& obj['response']['comments'][3]['id'] == 6 
				&& obj['response']['nbcomments'] == 7 
				&& obj['response']['current_comment_page'] == 1 
			){
				$(id+" .result").html('ok retrieve quote ( '+url+' ) FIN');
			}
			else{
				$(id+" .result").html('<b>fail retrieve quote ( '+url+' )</b><br/>'+data+'<br/>FIN');
			}
		});
		return false;
	});
	
	// quote.php:GET?key={key}&quoteid={quoteid}[&p={no_comment_page}][&nocomment=1]
	$("#test2 .launch").click(function(event){
		var id = '#test2';
		var url = base_url+'quote.php?quoteid=3&nocomment=1&key='+key+'';
		$(id+" .result").html('debut');
		$.get(url, function(data){
			$(id+" .result").html('result...<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200 
				&& obj['response']['id'] == 3 
				&& obj['response']['quote'] == "On ne mélange pas les torchons avec les servlet ! Un poin c est tout." 
				&& obj['response']['source'] == '' 
				&& obj['response']['context'] == "Cette ciation a été utilisée lors de l'anniversaire du JUG au concours de SFEIR. Elle n'a malheureusement pas gagné." 
				&& obj['response']['explanation'] == "Pour ceux qui n'auraient pas compris, c'est un détournement du proverbe très connu avec des mots similaires en informatique..." 
				&& obj['response']['author'] == "tim" 
				&& obj['response']['publisher'] == '' 
				&& obj['response']['site'] == '' 
				&& obj['response']['category'] == "loic quotes" 
				&& obj['response']['category_id'] == 1 
				&& obj['response']['up'] == 3 
				&& obj['response']['down'] == 1 
				&& obj['response']['total_comments'] == 7 
				&& typeof obj['response']['comments'] == "undefined" 
				&& typeof obj['response']['nbcomments'] == "undefined" 
				&& typeof obj['response']['current_comment_page'] == "undefined" 
			){
				$(id+" .result").html('ok retrieve quote ( '+url+' ) FIN');
			}
			else{
				$(id+" .result").html('<b>fail retrieve quote ( '+url+' )</b><br/>'+data+'<br/>FIN');
			}
		});
		return false;
	});
	
	// quote.php:GET?key={key}&quoteid=random[&p={no_comment_page}][&nocomment=1]
	$("#test3 .launch").click(function(event){
		var id = '#test3';
		var url = base_url+'quote.php?quoteid=random&key='+key+'';
		$(id+" .result").html('debut');
		$.get(url, function(data){
			$(id+" .result").html('result...<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200 
				&& typeof obj['response']['id'] != "undefined" 
				&& typeof obj['response']['quote'] != "undefined" 
				&& typeof obj['response']['source'] != "undefined" 
				&& typeof obj['response']['context'] != "undefined" 
				&& typeof obj['response']['explanation'] != "undefined" 
				&& typeof obj['response']['author'] != "undefined" 
				&& typeof obj['response']['publisher'] != "undefined" 
				&& typeof obj['response']['site'] != "undefined" 
				&& typeof obj['response']['category'] != "undefined" 
				&& typeof obj['response']['category_id'] != "undefined" 
				&& typeof obj['response']['up'] != "undefined" 
				&& typeof obj['response']['down'] != "undefined" 
				&& typeof obj['response']['total_comments'] != "undefined" 
			){
				$(id+" .result").html('ok retrieve quote ( '+url+' ) FIN');
			}
			else{
				$(id+" .result").html('<b>fail retrieve quote ( '+url+' )</b><br/>'+data+'<br/>FIN');
			}
		});
		return false;
	});
}

/**********************************************************************************************************************/
/* GET LIST QUOTES */
{
	// quote_list.php:GET?key={key}&list=top[&p={no_quote_page}]
	$("#test4 .launch").click(function(event){
		var id = '#test4';
		var url = base_url+'quote_list.php?list=top&key='+key+'';
		$(id+" .result").html('debut');
		$.get(url, function(data){
			$(id+" .result").html('result...<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200 
				&& typeof obj['response']['quotes'][0]['id'] != "undefined" 
				&& typeof obj['response']['quotes'][9]['quote'] != "undefined" 
				&& obj['response']['nbquotes'] == 10 
				&& obj['response']['size_quote_page'] == 10 
				&& obj['response']['current_quote_page'] == 1 
				&& obj['response']['total_quote_pages'] == 2 
			){
				$(id+" .result").html('ok retrieve top quotes ( '+url+' ) FIN');
			}
			else{
				$(id+" .result").html('<b>fail retrieve top quotes ( '+url+' )</b><br/>'+data+'<br/>FIN');
			}
		});
		return false;
	});
	
	// quote_list.php:GET?key={key}&list=top[&p={no_quote_page}]
	$("#test5 .launch").click(function(event){
		var id = '#test5';
		var url = base_url+'quote_list.php?list=top&p=2&key='+key+'';
		$(id+" .result").html('debut');
		$.get(url, function(data){
			$(id+" .result").html('result...<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200 
				&& typeof obj['response']['quotes'][0]['id'] != "undefined" 
				&& typeof obj['response']['quotes'][3]['quote'] != "undefined" 
				&& obj['response']['nbquotes'] >= 4 
				&& obj['response']['size_quote_page'] == 10 
				&& obj['response']['current_quote_page'] == 2 
				&& obj['response']['total_quote_pages'] == 2 
			){
				$(id+" .result").html('ok retrieve top quotes p2 ( '+url+' ) FIN');
			}
			else{
				$(id+" .result").html('<b>fail retrieve top quotes p2 ( '+url+' )</b><br/>'+data+'<br/>FIN');
			}
		});
		return false;
	});
	
	// quote_list.php:GET?key={key}&list=lasts[&p={no_quote_page}]
	$("#test6 .launch").click(function(event){
		var id = '#test6';
		var url = base_url+'quote_list.php?list=lasts&key='+key+'';
		$(id+" .result").html('debut');
		$.get(url, function(data){
			$(id+" .result").html('result...<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200 
				&& typeof obj['response']['quotes'][0]['id'] != "undefined" 
				&& typeof obj['response']['quotes'][9]['quote'] != "undefined" 
				&& obj['response']['nbquotes'] == 10 
				&& obj['response']['size_quote_page'] == 10 
				&& obj['response']['current_quote_page'] == 1 
				&& obj['response']['total_quote_pages'] == 2 
			){
				$(id+" .result").html('ok retrieve lasts quotes ( '+url+' ) FIN');
			}
			else{
				$(id+" .result").html('<b>fail retrieve lasts quotes ( '+url+' )</b><br/>'+data+'<br/>FIN');
			}
		});
		return false;
	});
}

/**********************************************************************************************************************/
/* POST QUOTE */
{
	var quote = new Array();
	quote['quote'] = "my new quote";
	quote['src'] = "Audrey stroppa";
	quote['expl'] = "aàcçeéêëèiîïoôuù ,?;.:/!§%*µ$£¤^¨<>~#\{([])}-|`_@ \ &'\"";
	quote['pub'] = "lolo";
	quote['mail'] = "lolo@mail.com";
	
	// quote.php:POST?key={key}&quote={quote}[&src={source}][&ctx={context}][&expl={explanation}][&auth={author}][&pub={publisher}][&mail={mail}][&site={site}][&cat={category_id|category_name}]
	$("#test7 .launch").click(function(event){
		var id = '#test7';
		var url = base_url+'quote.php';
		$(id+" .result").html('debut');
		$.post(url, { quote: quote['quote'], src: quote['src'], expl: quote['expl'], pub: quote['pub'], mail: quote['mail'], key: key },
		function(data) {
			$(id+" .result").html('result...<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200){
				$(id+" .result").html('quote '+obj['response']['id']+' ajoutée');
				
				quote['id'] = obj['response']['id'];
				var geturl = base_url+'quote.php?quoteid='+quote['id']+'&key='+key+'';
				$.get(geturl, function(getdata){
					$(id+" .result").html($(id+" .result").html() + ' / ');
					var getobj = jQuery.parseJSON(getdata);
					if(getobj['status']['code'] == 200 && getobj['response']['quote'] == quote['quote'] && getobj['response']['source'] == quote['src'] && getobj['response']['explanation'] == quote['expl'] && getobj['response']['publisher'] == quote['pub']){
						$(id+" .result").html($(id+" .result").html() + 'retireve ok ( '+geturl+' ) FIN');
						quote['up'] = getobj['response']['up'];
					}
					else{
						$(id+" .result").html($(id+" .result").html() + '<b>retireve fail ( '+geturl+' )</b><br/>'+getdata+'<br/>FIN');
					}
				});
			}
			else{
				$(id+" .result").html('<b>échec ajout quote ('+obj['status']['code']+')</b><br/>'+data+'<br/>FIN');
			}
		});
		return false;
	});
	
	// quote.php:POST?key={key}&quoteid={quoteid}&vote={'up'|'down'}
	$("#test8 .launch").click(function(event){
		var id = '#test8';
		var url = base_url+'quote.php';
		$(id+" .result").html('debut');
		$.post(url, { quoteid: quote['id'], vote: 'up', key: key },
		function(data) {
			$(id+" .result").html('result...<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200){
				$(id+" .result").html('ok vote');
				quote['up'] = quote['up'] + 1;
				var geturl = base_url+'quote.php?quoteid='+quote['id']+'&key='+key+'';
				$.get(geturl, function(getdata){
					$(id+" .result").html($(id+" .result").html() + ' / ');
					var getobj = jQuery.parseJSON(getdata);
					if(getobj['status']['code'] == 200 && getobj['response']['up'] == quote['up']){
						$(id+" .result").html($(id+" .result").html() + 'retireve ok ( '+geturl+' ) FIN');
					}
					else{
						$(id+" .result").html($(id+" .result").html() + '<b>retireve fail ( '+geturl+' )</b><br/>'+getdata+'<br/>FIN');
					}
				});
			}
			else{
				$(id+" .result").html('<b>échec vote quote ('+obj['status']['code']+')</b><br/>'+data+'<br/>FIN');
			}
		});
	});
	
	// quote.php:POST?key={key}&quoteid={quoteid}&vote={'up'|'down'}
	$("#test9 .launch").click(function(event){
		var id = '#test9';
		var url = base_url+'quote.php';
		$(id+" .result").html('debut');
		$.post(url, { quoteid: quote['id'], vote: 'up', key: key },
		function(data) {
			$(id+" .result").html('result...<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 406){
				$(id+" .result").html('ok 2ième vote interdit FIN');
			}
			else{
				$(id+" .result").html('<b>échec 2ième vote interdit ('+obj['status']['code']+')</b><br/>'+data+'<br/>FIN');
			}
		});
	});
	
	// quote.php:POST?key={key}&quoteid={quoteid}&report=1[&cause={cause}]
	$("#test10 .launch").click(function(event){
		var id = '#test10';
		var url = base_url+'quote.php';
		$(id+" .result").html('debut');
		$.post(url, { quoteid: quote['id'], report: '1', cause: 'test report é', key: key },
		function(data) {
			$(id+" .result").html('result...<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200){
				$(id+" .result").html('ok report');
				var geturl = base_url+'quote.php?quoteid='+quote['id']+'&key='+key+'';
				$.get(geturl, function(getdata){
					$(id+" .result").html($(id+" .result").html() + ' / ');
					var getobj = jQuery.parseJSON(getdata);
					if(getobj['status']['code'] == 404){
						$(id+" .result").html($(id+" .result").html() + 'deleted ok ( '+geturl+' ) FIN');
					}
					else{
						$(id+" .result").html($(id+" .result").html() + '<b>deleted fail ( '+geturl+' )</b><br/>'+getdata+'<br/>FIN');
					}
				});
			}
			else{
				$(id+" .result").html('<b>échec report quote ('+obj['status']['code']+')</b><br/>'+data+'<br/>FIN');
			}
		});
	});
}

/**********************************************************************************************************************/
/* POST COMMENT */
{
	var quote2 = new Array();
	quote2['comment'] = new Array();
	quote2['quote'] = "my new quote for comments";
	quote2['pub'] = "loïc Knuchel";
	quote2['mail'] = "loic@mail.com";
	quote2['comment']['pub'] = "toto";
	quote2['comment']['comment'] = "Le premier commentaire de toto. Génial !";
	quote2['comment']['mail'] = "toto@mail.com";
	quote2['comment']['site'] = "http://lkws.fr/croudquotes/client/4/quote.php";
	quote2['comment']['reportcause'] = "c'est juste un test...";
	
	// quote.php:POST?key={key}&quote={quote}[&src={source}][&ctx={context}][&expl={explanation}][&auth={author}][&pub={publisher}][&mail={mail}][&site={site}][&cat={category_id|category_name}]
	$("#test11 .launch").click(function(event){
		var id = '#test11';
		var url = base_url+'quote.php';
		$(id+" .result").html('debut');
		$.post(url, { quote: quote2['quote'], pub: quote2['pub'], mail: quote2['mail'], key: key },
		function(data) {
			$(id+" .result").html('result...<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200){
				$(id+" .result").html('quote '+obj['response']['id']+' ajoutée');
				
				quote2['id'] = obj['response']['id'];
				var geturl = base_url+'quote.php?quoteid='+quote2['id']+'&key='+key+'';
				$.get(geturl, function(getdata){
					$(id+" .result").html($(id+" .result").html() + ' / ');
					var getobj = jQuery.parseJSON(getdata);
					if(getobj['status']['code'] == 200 
						&& getobj['response']['id'] == quote2['id'] 
						&& getobj['response']['quote'] == quote2['quote'] 
						&& getobj['response']['source'] == '' 
						&& getobj['response']['context'] == '' 
						&& getobj['response']['explanation'] == '' 
						&& getobj['response']['author'] == '' 
						&& getobj['response']['publisher'] == quote2['pub'] 
						&& getobj['response']['site'] == '' 
						&& getobj['response']['category'] == '' 
						&& getobj['response']['category_id'] == '' 
						&& getobj['response']['up'] == 0 
						&& getobj['response']['down'] == 0 
						&& getobj['response']['total_comments'] == 0 
						&& getobj['response']['nbcomments'] == 0 
						&& getobj['response']['size_comment_page'] == 20 
						&& getobj['response']['current_comment_page'] == 1 
						&& getobj['response']['total_comment_pages'] == 1 
					){
							$(id+" .result").html($(id+" .result").html() + 'retireve ok ( '+geturl+' ) FIN');
							quote2['comments'] = getobj['response']['comments'];
					}
					else{
						$(id+" .result").html($(id+" .result").html() + '<b>retireve fail ( '+geturl+' )</b><br/>'+getdata+'<br/>FIN');
					}
				});
			}
			else{
				$(id+" .result").html('<b>échec ajout quote ('+obj['status']['code']+')</b><br/>'+data+'<br/>FIN');
			}
		});
		return false;
	});
	
	// comment.php:POST?key={key}&quoteid={quoteid}&pub={publisher}&comment={comment}[&mail={mail}][&site={site}]
	$("#test12 .launch").click(function(event){
		var id = '#test12';
		var url = base_url+'comment.php';
		$(id+" .result").html('debut');
		$.post(url, { quoteid: quote2['id'], pub: quote2['comment']['pub'], comment: quote2['comment']['comment'], mail: quote2['comment']['mail'], site: quote2['comment']['site'], key: key },
		function(data) {
			$(id+" .result").html('result...<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200){
				$(id+" .result").html('comment '+obj['response']['id']+' ajouté');
				
				quote2['comment']['id'] = obj['response']['id'];
				quote2['comments'] = quote2['comments'] + 1;
				var geturl = base_url+'quote.php?quoteid='+quote2['id']+'&key='+key+'';
				$.get(geturl, function(getdata){
					$(id+" .result").html($(id+" .result").html() + ' / ');
					var getobj = jQuery.parseJSON(getdata);
					if(getobj['status']['code'] == 200 
						&& getobj['response']['id'] == quote2['id'] 
						&& getobj['response']['quote'] == quote2['quote'] 
						&& getobj['response']['source'] == '' 
						&& getobj['response']['context'] == '' 
						&& getobj['response']['explanation'] == '' 
						&& getobj['response']['author'] == '' 
						&& getobj['response']['publisher'] == quote2['pub'] 
						&& getobj['response']['site'] == '' 
						&& getobj['response']['category'] == '' 
						&& getobj['response']['category_id'] == '' 
						&& getobj['response']['up'] == 0 
						&& getobj['response']['down'] == 0 
						&& getobj['response']['total_comments'] == quote2['comments'] 
						&& getobj['response']['comments'][0]['id'] == quote2['comment']['id'] 
						&& getobj['response']['comments'][0]['publisher'] == quote2['comment']['pub'] 
						&& getobj['response']['comments'][0]['site'] == quote2['comment']['site'] 
						&& getobj['response']['comments'][0]['comment'] == quote2['comment']['comment'] 
						&& getobj['response']['comments'][0]['up'] == 0 
						&& getobj['response']['comments'][0]['down'] == 0 
						&& getobj['response']['comments'][0]['reported'] == 0 
						&& getobj['response']['nbcomments'] == quote2['comments'] 
						&& getobj['response']['size_comment_page'] == 20 
						&& getobj['response']['current_comment_page'] == 1 
						&& getobj['response']['total_comment_pages'] == 1 
					){
							$(id+" .result").html($(id+" .result").html() + 'retireve ok ( '+geturl+' ) FIN');
							quote2['comment']['down'] = getobj['response']['comments'][0]['down'];
					}
					else{
						$(id+" .result").html($(id+" .result").html() + '<b>retireve fail ( '+geturl+' )</b><br/>'+getdata+'<br/>FIN');
					}
				});
			}
			else{
				$("#test11 .result").html('<b>échec ajout comment ('+obj['status']['code']+')</b><br/>'+data+'<br/>FIN');
			}
		});
		return false;
	});
	
	// comment.php:POST?key={key}&commentid={commentid}&vote={'up'|'down'}
	$("#test13 .launch").click(function(event){
		var id = '#test13';
		var url = base_url+'comment.php';
		$(id+" .result").html('debut');
		$.post(url, { commentid: quote2['comment']['id'], vote: 'down', key: key },
		function(data) {
			$(id+" .result").html('result...<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200){
				$(id+" .result").html('ok vote');
				
				quote2['comment']['down'] = quote2['comment']['down'] + 1;
				var geturl = base_url+'quote.php?quoteid='+quote2['id']+'&key='+key+'';
				$.get(geturl, function(getdata){
					$(id+" .result").html($(id+" .result").html() + ' / ');
					var getobj = jQuery.parseJSON(getdata);
					if(getobj['status']['code'] == 200 
						&& getobj['response']['id'] == quote2['id'] 
						&& getobj['response']['quote'] == quote2['quote'] 
						&& getobj['response']['source'] == '' 
						&& getobj['response']['context'] == '' 
						&& getobj['response']['explanation'] == '' 
						&& getobj['response']['author'] == '' 
						&& getobj['response']['publisher'] == quote2['pub'] 
						&& getobj['response']['site'] == '' 
						&& getobj['response']['category'] == '' 
						&& getobj['response']['category_id'] == '' 
						&& getobj['response']['up'] == 0 
						&& getobj['response']['down'] == 0 
						&& getobj['response']['total_comments'] == quote2['comments'] 
						&& getobj['response']['comments'][0]['id'] == quote2['comment']['id'] 
						&& getobj['response']['comments'][0]['publisher'] == quote2['comment']['pub'] 
						&& getobj['response']['comments'][0]['site'] == quote2['comment']['site'] 
						&& getobj['response']['comments'][0]['comment'] == quote2['comment']['comment'] 
						&& getobj['response']['comments'][0]['up'] == 0 
						&& getobj['response']['comments'][0]['down'] == quote2['comment']['down'] 
						&& getobj['response']['comments'][0]['reported'] == 0 
						&& getobj['response']['nbcomments'] == quote2['comments'] 
						&& getobj['response']['size_comment_page'] == 20 
						&& getobj['response']['current_comment_page'] == 1 
						&& getobj['response']['total_comment_pages'] == 1 
					){
							$(id+" .result").html($(id+" .result").html() + 'retireve ok ( '+geturl+' ) FIN');
					}
					else{
						$(id+" .result").html($(id+" .result").html() + '<b>retireve fail ( '+geturl+' )</b><br/>'+getdata+'<br/>FIN');
					}
				});
			}
			else{
				$("#test11 .result").html('<b>échec vote on comment ('+obj['status']['code']+')</b><br/>'+data+'<br/>FIN');
			}
		});
		return false;
	});
	
	// comment.php:POST?key={key}&commentid={commentid}&report=1[&cause={cause}] 
	$("#test14 .launch").click(function(event){
		var id = '#test14';
		var url = base_url+'comment.php';
		$(id+" .result").html('debut');
		$.post(url, { commentid: quote2['comment']['id'], report: '1', cause: quote2['comment']['reportcause'], key: key },
		function(data) {
			$(id+" .result").html('result...<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200){
				$(id+" .result").html('ok report');
				
				var geturl = base_url+'quote.php?quoteid='+quote2['id']+'&key='+key+'';
				$.get(geturl, function(getdata){
					$(id+" .result").html($(id+" .result").html() + ' / ');
					var getobj = jQuery.parseJSON(getdata);
					if(getobj['status']['code'] == 200 
						&& getobj['response']['id'] == quote2['id'] 
						&& getobj['response']['quote'] == quote2['quote'] 
						&& getobj['response']['source'] == '' 
						&& getobj['response']['context'] == '' 
						&& getobj['response']['explanation'] == '' 
						&& getobj['response']['author'] == '' 
						&& getobj['response']['publisher'] == quote2['pub'] 
						&& getobj['response']['site'] == '' 
						&& getobj['response']['category'] == '' 
						&& getobj['response']['category_id'] == '' 
						&& getobj['response']['up'] == 0 
						&& getobj['response']['down'] == 0 
						&& getobj['response']['total_comments'] == quote2['comments'] 
						&& getobj['response']['comments'][0]['id'] == quote2['comment']['id'] 
						&& getobj['response']['comments'][0]['publisher'] == quote2['comment']['pub'] 
						&& getobj['response']['comments'][0]['site'] == quote2['comment']['site'] 
						&& getobj['response']['comments'][0]['comment'] != quote2['comment']['comment'] 
						&& getobj['response']['comments'][0]['up'] == 0 
						&& getobj['response']['comments'][0]['down'] == quote2['comment']['down'] 
						&& getobj['response']['comments'][0]['reported'] == 1 
						&& getobj['response']['nbcomments'] == quote2['comments'] 
						&& getobj['response']['size_comment_page'] == 20 
						&& getobj['response']['current_comment_page'] == 1 
						&& getobj['response']['total_comment_pages'] == 1 
					){
							$(id+" .result").html($(id+" .result").html() + 'retireve ok ( '+geturl+' ) FIN');
					}
					else{
						$(id+" .result").html($(id+" .result").html() + '<b>retireve fail ( '+geturl+' )</b><br/>'+getdata+'<br/>FIN');
					}
				});
			}
			else{
				$(id+" .result").html('<b>échec report comment ('+obj['status']['code']+')</b><br/>'+data+'<br/>FIN');
			}
		});
		return false;
	});

}

/**********************************************************************************************************************/
/* POST CATEGORY */
{
	var category = new Array();
	// category['name'] = "Nouvelle catégorie";
	category['name'] = "newcat";
	
	var quote3 = new Array();
	quote3['quote'] = "Quote avec une catégorie";
	quote3['pub'] = "trazan !";
	quote3['cat'] = category['name'];
	quote3['mail'] = "trazan@mail.com";
	
	var quote4 = new Array();
	quote4['quote'] = "Quote sans catégorie";
	quote4['pub'] = "Youpiiii";
	
	// category.php:GET?key={key}[&p={no_category_page}]
	$("#test15 .launch").click(function(event){
		var id = '#test15';
		var url = base_url+'category.php?key='+key+'';
		$(id+" .result").html('debut');
		$.get(url, function(data){
			$(id+" .result").html('result...<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200 
				&& obj['response']['categories'][0]['id'] == 4 
				&& obj['response']['categories'][0]['name'] == 'autres' 
				&& obj['response']['categories'][1]['id'] == 3 
				&& obj['response']['categories'][1]['name'] == 'geek' 
				&& obj['response']['categories'][2]['id'] == 1 
				&& obj['response']['categories'][2]['name'] == 'loic quotes' 
				&& obj['response']['categories'][3]['id'] == 2 
				&& obj['response']['categories'][3]['name'] == 'vdm' 
				&& obj['response']['nbcategories'] == 4 
				&& obj['response']['size_category_page'] == 20 
				&& obj['response']['current_category_page'] == 1 
				&& obj['response']['total_category_pages'] == 1 
			){
				$(id+" .result").html('ok retrieve categories ( '+url+' ) FIN');
			}
			else{
				$(id+" .result").html('<b>fail retrieve categories ( '+url+' )</b><br/>'+data+'<br/>FIN');
			}
		});
		return false;
	});
	
	// category.php:POST?key={key}&cat={category_name}
	$("#test16 .launch").click(function(event){
		var id = '#test16';
		var url = base_url+'category.php';
		$(id+" .result").html('debut');
		$.post(url, { cat: category['name'], key: key },
		function(data) {
			$(id+" .result").html('result...<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200){
				$(id+" .result").html('ok catégorie '+obj['response']['id']+' ajoutée');
				
				category['id'] = obj['response']['id'];
				var geturl = base_url+'category.php?key='+key+'';
				$.get(geturl, function(getdata){
					$(id+" .result").html($(id+" .result").html() + ' / ');
					var getobj = jQuery.parseJSON(getdata);
					if(getobj['status']['code'] == 200 
						&& getobj['response']['categories'][0]['id'] == 4 
						&& getobj['response']['categories'][0]['name'] == 'autres' 
						&& getobj['response']['categories'][1]['id'] == 3 
						&& getobj['response']['categories'][1]['name'] == 'geek' 
						&& getobj['response']['categories'][2]['id'] == 1 
						&& getobj['response']['categories'][2]['name'] == 'loic quotes' 
						&& getobj['response']['categories'][3]['id'] == 5 
						&& getobj['response']['categories'][3]['name'] == category['name'] 
						&& getobj['response']['categories'][4]['id'] == 2 
						&& getobj['response']['categories'][4]['name'] == 'vdm' 
						&& getobj['response']['nbcategories'] == 5 
						&& getobj['response']['size_category_page'] == 20 
						&& getobj['response']['current_category_page'] == 1 
						&& getobj['response']['total_category_pages'] == 1 
					){
						$(id+" .result").html($(id+" .result").html() + 'retireve ok ( '+geturl+' ) FIN');
					}
					else{
						$(id+" .result").html($(id+" .result").html() + '<b>retireve fail ( '+geturl+' )</b><br/>'+getdata+'<br/>FIN');
					}
				});
			}
			else{
				$(id+" .result").html('<b>échec ajout catégorie ('+obj['status']['code']+')</b><br/>'+data+'<br/>FIN');
			}
		});
		return false;
	});
	
	// quote.php:POST?key={key}&quote={quote}[&src={source}][&ctx={context}][&expl={explanation}][&auth={author}][&pub={publisher}][&mail={mail}][&site={site}][&cat={category_id|category_name}]
	$("#test17 .launch").click(function(event){
		var id = '#test17';
		var url = base_url+'quote.php';
		$(id+" .result").html('debut');
		$.post(url, { quote: quote3['quote'], pub: quote3['pub'], cat: quote3['cat'], mail: quote['mail'], key: key },
		function(data) {
			$(id+" .result").html('result...<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200){
				$(id+" .result").html('quote '+obj['response']['id']+' ajoutée');
				
				quote3['id'] = obj['response']['id'];
				var geturl = base_url+'quote.php?quoteid='+quote3['id']+'&key='+key+'';
				$.get(geturl, function(getdata){
					$(id+" .result").html($(id+" .result").html() + ' / ');
					var getobj = jQuery.parseJSON(getdata);
					if(getobj['status']['code'] == 200 
						&& getobj['response']['quote'] == quote3['quote']
						&& getobj['response']['publisher'] == quote3['pub']
						&& getobj['response']['category'] == category['name']
						&& getobj['response']['category_id'] == category['id']
					){
						$(id+" .result").html($(id+" .result").html() + 'retireve ok ( '+geturl+' ) FIN');
					}
					else{
						$(id+" .result").html($(id+" .result").html() + '<b>retireve fail ( '+geturl+' )</b><br/>'+getdata+'<br/>FIN');
					}
				});
			}
			else{
				$(id+" .result").html('<b>échec ajout quote ('+obj['status']['code']+')</b><br/>'+data+'<br/>FIN');
			}
		});
		return false;
	});
	
	// quote_list.php:GET?key={key}&list=category&cat={category_id|category_name}[&p={no_quote_page}]
	$("#test18 .launch").click(function(event){
		var id = '#test18';
		var url = base_url+'quote_list.php?list=category&cat='+category['name']+'&key='+key+'';
		$(id+" .result").html('debut');
		$.get(url, function(data){
			$(id+" .result").html('result... ( '+url+' )<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200 
				&& obj['response']['quotes'][0]['id'] == quote3['id'] 
				&& obj['response']['quotes'][0]['quote'] == quote3['quote'] 
				&& obj['response']['quotes'][0]['category'] == category['name'] 
				&& obj['response']['quotes'][0]['category_id'] == category['id'] 
				&& obj['response']['nbquotes'] == 1 
				&& obj['response']['size_quote_page'] == 10 
				&& obj['response']['current_quote_page'] == 1 
				&& obj['response']['total_quote_pages'] == 1 
			){
				$(id+" .result").html('ok retrieve category quotes ( '+url+' ) FIN');
			}
			else{
				$(id+" .result").html('<b>fail retrieve category quotes ( '+url+' )</b><br/>'+data+'<br/>FIN');
			}
		});
		return false;
	});
	
	// quote.php:POST?key={key}&quote={quote}[&src={source}][&ctx={context}][&expl={explanation}][&auth={author}][&pub={publisher}][&mail={mail}][&site={site}][&cat={category_id|category_name}]
	$("#test19 .launch").click(function(event){
		var id = '#test19';
		var url = base_url+'quote.php';
		$(id+" .result").html('debut');
		$.post(url, { quote: quote4['quote'], pub: quote4['pub'], mail: quote['mail'], key: key },
		function(data) {
			$(id+" .result").html('result...<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200){
				$(id+" .result").html('quote '+obj['response']['id']+' ajoutée');
				
				quote4['id'] = obj['response']['id'];
				var geturl = base_url+'quote.php?quoteid='+quote4['id']+'&key='+key+'';
				$.get(geturl, function(getdata){
					$(id+" .result").html($(id+" .result").html() + ' / ');
					var getobj = jQuery.parseJSON(getdata);
					if(getobj['status']['code'] == 200 
						&& getobj['response']['quote'] == quote4['quote']
						&& getobj['response']['publisher'] == quote4['pub']
					){
						$(id+" .result").html($(id+" .result").html() + 'retireve ok ( '+geturl+' ) FIN');
					}
					else{
						$(id+" .result").html($(id+" .result").html() + '<b>retireve fail ( '+geturl+' )</b><br/>'+getdata+'<br/>FIN');
					}
				});
			}
			else{
				$(id+" .result").html('<b>échec ajout quote ('+obj['status']['code']+')</b><br/>'+data+'<br/>FIN');
			}
		});
		return false;
	});
	
	// quote.php:POST?key={key}&quoteid={quoteid}&cat={category_id|category_name}
	$("#test20 .launch").click(function(event){
		var id = '#test20';
		var url = base_url+'quote.php';
		$(id+" .result").html('debut');
		$.post(url, { quoteid: quote4['id'], cat: category['id'], key: key },
		function(data) {
			$(id+" .result").html('result... ( '+url+' )<br/>'+data);
			var obj = jQuery.parseJSON(data);
			if(obj['status']['code'] == 200){
				$(id+" .result").html('ok submit category');
				
				quote4['cat'] = obj['response']['category']['name'];
				quote4['cat_id'] = obj['response']['category']['id'];
				var geturl = base_url+'quote.php?quoteid='+quote4['id']+'&key='+key+'';
				$.get(geturl, function(getdata){
					$(id+" .result").html($(id+" .result").html() + ' / ');
					var getobj = jQuery.parseJSON(getdata);
					if(getobj['status']['code'] == 200 
						&& getobj['response']['quote'] == quote4['quote']
						&& getobj['response']['publisher'] == quote4['pub']
						&& getobj['response']['category'] == quote4['cat']
						&& getobj['response']['category_id'] == quote4['cat_id']
					){
						$(id+" .result").html($(id+" .result").html() + 'retireve ok ( '+geturl+' ) FIN');
					}
					else{
						$(id+" .result").html($(id+" .result").html() + '<b>retireve fail ( '+geturl+' )</b><br/>'+getdata+'<br/>FIN');
					}
				});
			}
			else{
				$(id+" .result").html('<b>échec ajout catégorie ('+obj['status']['code']+')</b><br/>'+data+'<br/>FIN');
			}
		});
		return false;
	});
	
}
	
	
	
	
});
