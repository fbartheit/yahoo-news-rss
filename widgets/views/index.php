<?php
use yii\helpers\Html;
use app\models\Feed;
?>

<div class="container-fluid feed_panel">
	<div class="header">
		<?= $feed->date_posted ?>
	</div>
	<div class="content">
		<div class="row">
			<a href="<?= $feed['link'] ?>"><h4><?= $feed->title ?></h4></a>
		</div>
		
		<div class="row">
			<div class="col-md-5">
				<img class="img img-responsive" src="images/image_feed.png" />
			</div>
			<div class="col-md-7">
				<div class="article">
					<p class="feed_description">
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