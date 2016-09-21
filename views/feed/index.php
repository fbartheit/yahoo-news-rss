<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Y-news - Home';
?>
<div class="page-title">
	<h1><?= Html::encode($pageTitle) ?></h1>
</div>
<div class="container-fluid">
	<?php $i=0;
	foreach($feeds as $feed){
		if($i % 2 === 0){ ?>
			<div class="row">
		<?php } ?>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="panel" style="width: 95%; float: <?= ($i % 2 === 0)?'left':'right' ?>;";>
						<?= Html::encode("{$feed->title} ({$feed->link})") ?>
					</div>
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
