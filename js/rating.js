$("span[id$='_star']").click(function(e){
	var parts = $(this).attr('id').split('_');
	var feed_id = parts[0];
	var rating = parts[1];
	//alert('id:' + feed_id + ', rating: ' +rating);
	// check from cookie if the article was already rated from this user
	$.ajax({
		url: './index.php?r=feed/rate-article',
		data: {
			id : feed_id,
			rating: rating
		},
		success: function(data){
			var jsonData = JSON.parse(data);
			if(jsonData.result == "OK"){
				styleRatingBar(feed_id, rating);
				$("#"+feed_id+"_rating_message").empty().html("Thanks for voting!");
			}else{
				if(jsonData.message == "NOK"){
					$("#"+feed_id+"_rating_message").empty().html("An error occured.");
				}else{
					$("#"+feed_id+"_rating_message").empty().html("You already rated this article.");
				}
			}
		}
	});
});

function styleRatingBar(id, rating){
	for(var i=1; i<6; i++){
		var el = $('#'+id+'_'+i+'_star');
		if(i <= rating){
			el.removeClass('empty');
		}else{
			el.addClass('empty');
		}
	}
}

// hover try
/*$("span[id$='_star']").mouseover(function(){
	if(window.rating_over === true || window.rating_over === undefined || window.rating_over === null){
		var parts = $(this).attr('id').split('_');
		var feed_id = parts[0];
		var rating = parts[1];
	
		window.rating_over = false;
		$(this).parent().mouseout(function(){
			styleRatingBar(feed_id, rating);
			window.rating_over = true;
		});
	}
	styleRatingBar(feed_id, rating);
});*/