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
			<a id= "<?= $feed->id ?>_link" href="<?= $feed['link'] ?>" target="_blank"><h4><?= $feed->title ?></h4></a>
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
						<div id="<?= $feed->id ?>_rating" class="rating">
							<?php 
								for($i=1; $i<6; $i++){ ?>
									<span id="<?= $feed->id ?>_<?= $i ?>_star" class="glyphicon glyphicon-star <?= ($i > $feed->rating)?'empty':'' ?>"></span>
								<?php }
							?>
							<span id="<?= $feed->id ?>_rating_message"></span>
						</div>
						<div class="views">
							<span class="glyphicon glyphicon-eye-open"></span>
							<span id="<?= $feed->id ?>_num_views" class="view_count"><?= $feed->num_views ?></span>
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