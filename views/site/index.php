<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Y-news - Home';
?>
<div class="page-title">
	<h1><?= Html::encode($this->title) ?></h1>
</div>
<div>
	<ul>
		<?php foreach($feeds as $feed): ?>
			<li>
				<?= Html::encode("{$feed->title} ({$feed->link})") ?>
			</li>
		<?php endforeach; ?>
	</ul>
</div>


<?= LinkPager::widget(['pagination' => $pagination]); ?>
