$(document).ready(function(){
		$('[data-toggle="popover"]').popover();
	});
	
function tooltip(){
    var span = document.createElement("span");
    var sel = window.getSelection();
    var text = sel.toString();
    
    if (sel.rangeCount) {
        var range = sel.getRangeAt(0).cloneRange();
        range.surroundContents(span);
    }
    span.setAttribute("data-toggle", "popover");
    span.setAttribute("data-html", "true");
    
    
    var result = search(text);
    span.setAttribute("data-content", result);
    
    $(span).popover('show');
}

$('body').click(function(e){
    $(function () {
        $('[data-toggle="popover"]').popover('hide');
     });
});
	
function search(keyword) {
    var result;
    $.ajax({
        async: false,
        url: './index.php?r=feed/ajaxsearch',
        type: 'GET',
        data: {keyword: keyword},
        success: function(data){
            result = data;
        },
        error: function(data){
            result = "No search results.";
        }
    });
    return result;
}