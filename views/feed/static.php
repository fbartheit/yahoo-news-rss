<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\models\StaticPage;

$this->title = $staticPage->static_page_title;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-title">
	<h1><?= Html::encode($this->title) ?></h1>
</div>
<div class="panel">
    <?= $staticPage->static_page_content ?>
</div>
