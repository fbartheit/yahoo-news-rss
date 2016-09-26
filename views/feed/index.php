<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\widgets\FeedWidget;

$this->title = 'Y-news - Home';
?>
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
	(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
<div class="page-title">
	<h1><?= Html::encode($pageTitle) ?></h1>
</div>
<div class="container-fluid">
	<?php $i=0;
	foreach($feeds as $feed){
		if($i % 2 === 0){ ?>
			<div class="row feed_row">
		<?php } ?>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<?= FeedWidget::widget(['feed'=>$feed]) ?>
				</div>
		<?php if($i % 2 !== 0){ ?>
			</div>
		<?php } ?>
	<?php $i++;
	} ?>
	
</div>

<div class="pager_holder">
<?= LinkPager::widget(['pagination' => $pagination]); ?>
</div>
