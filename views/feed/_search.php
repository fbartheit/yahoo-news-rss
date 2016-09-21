<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FeedSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="feed-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'date_posted') ?>

    <?= $form->field($model, 'rating') ?>

    <?php // echo $form->field($model, 'num_views') ?>

    <?php // echo $form->field($model, 'num_rates') ?>

    <?php // echo $form->field($model, 'link') ?>

    <?php // echo $form->field($model, 'image_link') ?>

    <?php // echo $form->field($model, 'type_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
