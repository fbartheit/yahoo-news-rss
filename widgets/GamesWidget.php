<?php

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class GamesWidget extends Widget
{

    public $game;
	    
    public function init()
    {
        parent::init();
    }
    
    public function run()
    {
        return $this->render('games-index', ['game' => $this->game]);
    }
}