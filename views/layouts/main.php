<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Y-news',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Science', 'url' => ['/site/science']],
            ['label' => 'Tech', 'url' => ['/site/tech']],
			['label' => 'World', 'url' => ['/site/world']],
			['label' => 'Politics', 'url' => ['/site/politics']],
			['label' => 'Health', 'url' => ['/site/health']],
			['label' => 'Contact', 'url' => ['/site/contact']],
            /*Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
            )*/
        ],
    ]); ?>
	<form class="navbar-form navbar-left">
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Search" aria-describedby="basic-addon-search">
			<span class="input-group-addon" id="basic-addon-search"><span class="glyphicon glyphicon-search"></span></span>
		</div>
    </form>
    <?php
		NavBar::end();
    ?>

    <div class="container">
        <?= $content ?>
    </div>
</div>
<div class="container">
	<footer class="footer">
		<p class="footer-text">Copyright &copy; <?= date('Y') ?> by <strong>Y-news</strong> All rights reserved</p>
		
		<?php 
			echo Nav::widget([
				'options' => ['class' => 'navbar-nav navbar-right'],
				'items' => [
					['label' => 'Home', 'url' => ['/site/index']],
					['label' => 'About Us', 'url' => ['/site/about']],
					['label' => 'Contact', 'url' => ['/site/contact']],
					
					/*Yii::$app->user->isGuest ? (
						['label' => 'Login', 'url' => ['/site/login']]
					) : (
						'<li>'
						. Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
						. Html::submitButton(
							'Logout (' . Yii::$app->user->identity->username . ')',
							['class' => 'btn btn-link']
						)
						. Html::endForm()
						. '</li>'
					)*/
				],
			]); ?>
	</footer>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
