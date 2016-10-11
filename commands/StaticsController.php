<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class StaticsController extends Controller {
 
    public function actionIndex() {
        $link_string = 'http://fagamecenter.com/index.php?r=staticPagesFeed&projectId=62&apiKey=8f3cbb3dc4769a0f7491613732af8634';
        
		$content = file_get_contents($link_string);
		echo $content;
    }
   
}