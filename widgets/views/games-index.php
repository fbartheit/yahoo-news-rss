<?php
use yii\helpers\Html;

use yii\helpers\Url;

$url = Url::to(['game/play', 'id' => $game->game_id]);
?>
<div class="container-fluid game-image">
            <a href="<?= $url ?>"><img src="http://web3.hostingcdn.com/<?= $game->game_screenshot_1 ?>" class="img img-responsive" /></a>
</div>