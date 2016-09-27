$("span[id$='_star']").click(function(e){
	var parts = $(this).attr('id').split('_');
	var feed_id = parts[0];
	var rating = parts[1];
	alert('id:' + feed_id + ', rating: ' +rating);
});