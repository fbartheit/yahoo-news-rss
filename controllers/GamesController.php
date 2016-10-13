<?php

namespace app\controllers;

use Yii;
use app\models\Game;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\db\Query;


use yii\data\ActiveDataProvider;

/**
 * GamesController
 */
class GamesController extends Controller
{
    
    public function actionIndex(){
        
        $query = new Query;
        $query->select('game_id, game_name, game_image_1')
            ->from('games');
            
        $games_data = $query->all();
        
        $games = [];
        foreach($games_data as $gd){
            $game = new Game();
            $game->game_id = $gd['game_id'];
            $game->game_name = $gd['game_name'];
            $game->game_image_1 = $gd['game_image_1'];
            array_push($games, $game);
        }
        
        return $this->render('index', [
			'games' => $games
		]);
        
    }
    
    
    
}