<?php

namespace app\commands;
use Yii;

use yii\console\Controller;

class FeedController extends Controller {
 
    
  
    
    
    public function actionIndex() {
        $content = file_get_contents("http://62:8f3cbb3dc4769a0f7491613732af8634@fagamecenter.com/index.php?r=feed");
        
      $decode = json_decode($content);
        
      $this->createGamesTempTable();
        
      //  print_r($decode);
      
      $temp = "insert into games_temp (game_id, game_name, game_instruction, game_description, 
              game_dimension_width, game_dimension_height, game_technology, game_video_preview, game_facebook_share_url, 
              game_keywords, game_swf_url, game_image_1, game_image_2, game_screenshot_1, game_screenshot_2, 
              game_screenshot_3, game_screenshot_4, game_hits, game_publisher_id, game_publisher_name, game_tags, game_categories) values ";
        
       foreach ($decode->project_games as $pg){
            
            $categories = $pg->game_categories;
            $tags =  $pg->game_tags;
            $varC = '';
            $varT = '';
            foreach($categories as $c){
                $varC .= $c->category_name . ',';
            }
            
            foreach ($tags as $t){
                $varT .= $t->tag_name . ',';
            }
           // $pg->hits=null;
            $pg->game_title = addslashes($pg->game_title);
            $pg->game_instruction = addslashes($pg->game_instruction);
            $pg->game_description = addslashes($pg->game_description);
            $temp .= '(' . $pg->game_id . ', "' . $pg->game_title . '", "' . $pg->game_instruction . '", "' . $pg->game_description
                    . '", ' . $pg->game_dimension_width . ', ' . $pg->game_dimension_height . ', "' . $pg->technology_name . '", "' . $pg->game_video_preview
                    . '", "' . $pg->game_facebook_share_url . '", "' . $pg->game_keywords . '", "' . $pg->game_serve_url . '", "' . $pg->game_images->i1 
                    . '", "' . $pg->game_images->i2 . '", "' .  $pg->game_screenshots->s1 . '", "' . $pg->game_screenshots->s2
                    . '", "' . $pg->game_screenshots->s3 . '", "' . $pg->game_screenshots->s4 . '", ' . 0 . ', ' . $pg->publisher_id
                    . ', "' . $pg->publisher_name . '", "' . $varT . '", "' . $varC . '"), '; 
        
        }
        $temp = substr($temp, 0, -2);
      //  echo $temp;
        
        
        Yii::$app->db->createCommand($temp)->execute();
        $sql1 = "DROP TABLE IF EXISTS games";
        $sql2 = "RENAME TABLE games_temp TO games";
        Yii::$app->db->createCommand($sql1)->query();
        Yii::$app->db->createCommand($sql2)->query();
        
         
    }
       
    
       public function createGamesTempTable() {
            try {
             $sql = "
             DROP TABLE IF EXISTS `games_temp`;
            CREATE TABLE `games_temp` (
              `game_id` int(11) NOT NULL,
              `game_name` varchar(45) COLLATE utf8_bin NOT NULL,
              `game_instruction` varchar(256) COLLATE utf8_bin DEFAULT NULL,
              `game_description` varchar(256) COLLATE utf8_bin NOT NULL,
              `game_dimension_width` int(11) NOT NULL,
              `game_dimension_height` int(11) NOT NULL,
              `game_technology` varchar(45) COLLATE utf8_bin NOT NULL,
              `game_video_preview` varchar(256) COLLATE utf8_bin DEFAULT NULL,
              `game_facebook_share_url` varchar(2048) COLLATE utf8_bin DEFAULT NULL,
              `game_keywords` varchar(256) COLLATE utf8_bin NOT NULL,
              `game_swf_url` varchar(256) COLLATE utf8_bin NOT NULL,
              `game_image_1` varchar(256) COLLATE utf8_bin NOT NULL,
              `game_image_2` varchar(256) COLLATE utf8_bin DEFAULT NULL,
              `game_screenshot_1` varchar(256) COLLATE utf8_bin NOT NULL,
              `game_screenshot_2` varchar(256) COLLATE utf8_bin DEFAULT NULL,
              `game_screenshot_3` varchar(256) COLLATE utf8_bin DEFAULT NULL,
              `game_screenshot_4` varchar(256) COLLATE utf8_bin DEFAULT NULL,
              `game_hits` int(11) NOT NULL,
              `game_publisher_id` int(11) NOT NULL,
              `game_publisher_name` varchar(256) COLLATE utf8_bin NOT NULL,
              `game_tags` varchar(512) COLLATE utf8_bin DEFAULT NULL,
              `game_categories` varchar(512) COLLATE utf8_bin DEFAULT NULL,
              PRIMARY KEY (`game_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
             ";
             Yii::$app->db->createCommand($sql)->execute();
             return "OK";
            } catch (Exception $e) {
             error_log("Database::createGamesTempTable: " . $e->getMessage());
             return "Database::createGamesTempTable: " . $e->getMessage();
            }
        }
  
       /* $sql1 = "DROP TABLE IF EXISTS games";
         $sql2 = "RENAME TABLE games_temp TO games";
   Yii::app()->db->createCommand($sql1)->query();
   Yii::app()->db->createCommand($sql2)->query();*/
}

?>