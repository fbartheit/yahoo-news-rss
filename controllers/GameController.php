<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use app\models\Game;
class GameController extends Controller{
    
    public function actionPlay($id)
    {
        $query = Yii::$app->db->createCommand('select game_id, '
                . 'game_name, '
                . 'game_instruction, '
                . 'game_description, '
                . 'game_dimension_width, '
                . 'game_dimension_height, '
                . 'game_technology '
                . 'from games where game_id = :id')
                ->bindValue(':id', $id)
                ->queryOne();
        
        if ($query==NULL){
            return $this->render('error', [
                'name' => "404 not found", 
                'message' => "404 PAGE NOT FOUND",
            ]);
        }
        
        $game = new Game();
        $game->game_id = $query['game_id'];
        $game->game_name = $query['game_name'];
        $game->game_instruction = $query['game_instruction'];
        $game->game_description = $query['game_description'];
        $game->game_dimension_width = $query['game_dimension_width'];
        $game->game_dimension_height = $query['game_dimension_height'];
        $game->game_technology = $query['game_technology'];
        
        
        return $this->render('game', [
            'game' => $game
        ]);
    }
    
    
}
