<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\widgets\GamesWidget;

$this->title = 'Games';
?>
<div class="page-title">
	<h1>Games</h1>
</div>
<div class="container-fluid">
	<?php $i=0;
		foreach($games as $game){
			
			if($i % 4 === 0){ ?>
				<div class="row feed_row">
			<?php } ?>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<?= GamesWidget::widget(['game'=>$game]) ?>
					</div>
			<?php if($i % 4 !== 0){ ?>
				</div>
			<?php
				}
			$i++;
		}
	?>
	
</div>

<div class="pager_holder">
<?php //<?= LinkPager::widget(['pagination' => $pagination]); ?>
</div>
