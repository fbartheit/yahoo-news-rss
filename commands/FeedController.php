<?php

namespace app\commands;

use yii\console\Controller;

class FeedController extends Controller {
 
    public function actionIndex() {
        $content = file_get_contents("");
        echo $content;
    }
    
}

?>