<?php
use yii\helpers\Html;
use app\models\Feed;
?>

<div class="container-fluid feed_panel">
	<div class="header">
		<?= date('D, d M Y H:i:s', strtotime($feed->date_posted)) ?>
		<div class="fb-like" data-href="<?= $feed['link'] ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
	</div>
	<div class="content">
		<div class="row">
			<a href="<?= $feed['link'] ?>" target="_blank"><h4><?= $feed->title ?></h4></a>
		</div>
		
		<div class="row">
		<?php if(!empty($feed->image_link)){ ?>
			<div class="col-md-5">
				<img class="img img-responsive feed_image" src="<?= $feed->image_link ?>" />
			</div>
			<div class="col-md-7">
			<?php }else{ ?>
			<div class="col-md-12">
		<?php } ?>
				<div class="article">
					<p class="feed_description" ondblclick="tooltip()">
						<?= $feed->description ?>
					</p>
					<div class="data_bar">
						<div class="rating">
							<span class="glyphicon glyphicon-star"></span>
							<span class="glyphicon glyphicon-star"></span>
							<span class="glyphicon glyphicon-star"></span>
							<span class="glyphicon glyphicon-star empty"></span>
							<span class="glyphicon glyphicon-star empty"></span>
						</div>
						<div class="views">
							<span class="glyphicon glyphicon-eye-open"></span>
							<span class="view_count"><?= $feed->num_views ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

<script>
	
	$(document).ready(function(){
		$('[data-toggle="popover"]').popover();
	});
	
	function tooltip(){
		var span = document.createElement("span");
		var sel = window.getSelection();
		if (sel.rangeCount) {
			var range = sel.getRangeAt(0).cloneRange();
			range.surroundContents(span);
		}
		span.setAttribute("data-toggle", "popover");
		span.setAttribute("data-html", "true");
		
		var result = search(sel.toString());
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
            url: '<?php echo \Yii::$app->getUrlManager()->createUrl('feed/ajaxsearch') ?>',
			type: 'POST',
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
	
</script>