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
		$page = Yii::$app->request->get('page');
		$offset = 0;
		$limit = 20;
		if($page){
			$offset = --$page * 20;
		}
        return $this->getGames($offset, $limit);
    }

	public function getGames($offset, $limit){
		$cache_key = sha1("DATA".$offset.$limit);
		$size_key = sha1("SIZEGAMESYNEWS");
		
		//Yii::$app->cache->delete($cache_key);
		//Yii::$app->cache->delete($size_key);
				
		$games = Yii::$app->cache->get($cache_key);
		
		$count = Yii::$app->cache->get($size_key);
		if(!$count){
			$query = new Query;
			$query->select('game_id, game_name, game_screenshot_1')
					->from('games');
			$games_data = $query->all();
			$count = count($games_data);
			Yii::$app->cache->set($size_key, $count);
		}
		
		if(!$games){
			$query = new Query;
			$query->select('game_id, game_name, game_screenshot_1')
				->from('games')
				->offset($offset)
				->limit($limit);
			$games_data = $query->all();
			
			$games = [];
			foreach($games_data as $gd){
				$game = new Game();
				$game->game_id = $gd['game_id'];
				$game->game_name = $gd['game_name'];
				$game->game_screenshot_1 = $gd['game_screenshot_1'];
				array_push($games, $game);
			}
			
			Yii::$app->cache->set($cache_key, $games);
		}

		$pagination = new Pagination([
				'defaultPageSize' => 20,
				'totalCount' => $count
		]);

        return $this->render('index', [
			'games' => $games,
			'pagination' => $pagination
		]);
	}
    
}