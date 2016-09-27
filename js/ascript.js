$("a[id$=_link]").click(function(e){
	var link = $(this).attr('id').split('_');
	var id = link[0];

	$.ajax({
		url:'./index.php?r=feed/update-views',
		data: {
			id: id
		},
		success: function(data) {
			var tmp = $("#"+id+"_num_views");
			var num = parseInt(tmp.text());
			tmp.text(num+1);
			
    }
	});
});
