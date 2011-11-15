$(function(){
	var url = 'http://lkws.fr/croudquotes/server/api/1/tests/testPOST.php?p=1&toto=coucou+toi';
	
	$.post(url, { name: "John", time: "2pm" },
		function(data) {
			$('#result').html(data);
			
			var obj = jQuery.parseJSON(data);
			
			var items = [];

			  items.push('<li>GET</li>');
			  $.each(obj['GET'], function(key, val) {
				items.push('<li>'+key+' : ' + val + '</li>');
			  });

			  items.push('<li>POST</li>');
			  $.each(obj['POST'], function(key, val) {
				items.push('<li>'+key+' : ' + val + '</li>');
			  });

			  $('<ul/>', {
				'class': 'my-new-list',
				html: items.join('')
			  }).appendTo('body');
		});
});
