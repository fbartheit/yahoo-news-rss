<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class StatsController extends Controller {
    
    public function actionIndex(){
        $content = file_get_contents("http://62:8f3cbb3dc4769a0f7491613732af8634@fagamecenter.com/index.php?r=StatsFeed");
        
        $decoded = json_decode($content);     

        $this->createStatsTempTable();
        try{
            $sql = "INSERT INTO statistics_temp (game_id, votes_sum, votes_count, open_count, rating) VALUES ";
            foreach($decoded->project_stats as $d){
                $rating = 0;
                if($d->votes->votesNumber != 0) {
                    $rating = $d->votes->sum / $d->votes->votesNumber;
                }
                $sql .= "(" . $d->gameId . ", " . $d->votes->sum . ", " . $d->votes->votesNumber . ", " . $d->openCount . ", " . $rating . "), ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= ";";
            
            Yii::$app->db->createCommand($sql)->execute();
            
            $sql1 = "DROP TABLE IF EXISTS statistics";
            $sql2 = "RENAME TABLE statistics_temp TO statistics";
            
            Yii::$app->db->createCommand($sql1)->execute();
            Yii::$app->db->createCommand($sql2)->execute();
        } catch(Exception $e){
            error_log("Database::insertStatsTable: ". $e->getMessage());
            return "Database::insertStatsTable: ". $e->getMessage();
        }
    }

    public function createStatsTempTable() {
        try {
            $sql = "DROP TABLE IF EXISTS `statistics_temp`;
                    CREATE TABLE `statistics_temp` (
                      `game_id` int(11) NOT NULL,
                      `votes_sum` int(11) NOT NULL,
                      `votes_count` int(11) NOT NULL,
                      `open_count` int(11) NOT NULL,
                      `rating` int(11) NOT NULL,
                      PRIMARY KEY (`game_id`),
                      KEY `fk_votes_games1` (`game_id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
            
            Yii::$app->db->createCommand($sql)->execute();
            return "OK";
        } catch (Exception $e) {
            error_log("Database::createStatsTempTable: " . $e->getMessage());
            return "Database::createStatsTempTable: " . $e->getMessage();
        }
    }
    
}