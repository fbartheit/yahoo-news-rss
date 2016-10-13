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
<div class="container-fluid panel">
	<?php $i=0;
		foreach($games as $game){
			if($i % 4 == 0){
				if($i != 0){ ?>
					</div>
					<?php
				}
				?>
				<div class="row feed_row">
			<?php } ?>
					<div class="col-md-3">
							<?= GamesWidget::widget(['game'=>$game]) ?>
					</div>
			<?php
			
			$i++;
		}
	?>

</div>

<div class="pager_holder">
<?= LinkPager::widget(['pagination' => $pagination]); ?>
</div>