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
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-84825431-1', 'auto');
  ga('send', 'pageview');

</script>

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
            ['label' => 'Home', 'url' => ['/feed/index']],
            ['label' => 'Science', 'url' => ['/feed/science']],
            ['label' => 'Tech', 'url' => ['/feed/tech']],
			['label' => 'World', 'url' => ['/feed/world']],
			['label' => 'Politics', 'url' => ['/feed/politics']],
			['label' => 'Health', 'url' => ['/feed/health']],
			['label' => 'About Us', 'url' => ['/site/about']],
			['label' => 'Contact', 'url' => ['/site/contact']],
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
	
	<div class="zigzag"></div>
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
					['label' => 'Home', 'url' => ['/feed/index']],
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
