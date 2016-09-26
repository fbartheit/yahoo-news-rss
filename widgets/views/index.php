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
			<a href="<?= $feed['link'] ?>"><h4><?= $feed->title ?></h4></a>
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