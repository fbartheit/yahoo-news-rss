<?php

namespace app\widgets;

use yii\base\Widget;
use app\models\Feed;
use yii\helpers\Html;
class FeedWidget extends Widget
{

    public $feed;
	
	
    
    public function init()
    {
        parent::init();
        
        
        
    }
    public function run()
    {
        return $this->render('index', ['feed' => $this->feed]);
    }
}
