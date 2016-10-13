<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\StaticPage;

class StaticsController extends Controller {
 
    public function actionIndex() {
        $link_string = 'http://62:8f3cbb3dc4769a0f7491613732af8634@fagamecenter.com/index.php?r=staticPagesFeed';
        
        $content = file_get_contents($link_string);
        $items = json_decode($content);

        //echo $items->project_id;
        //echo $items->project_name;
        $sqlInsert = 'INSERT INTO static_pages_temp(`id`, `static_page_title`, `static_page_content`, `static_page_type`, `active_from_date`, `project_id`) VALUES ';

        $cnt = count($items->project_pages);
        $i = 0;
        foreach($items->project_pages as $page){
                $sp_id = $page->static_page_id;
                $sp_title = $page->static_page_title;
                $sp_type = $page->static_page_type;
                $sp_content = addslashes($page->static_page_content);
                $active_from_date = $page->active_from_date;
                $sp_project_id = $items->project_id;
                $sqlInsert .= "($sp_id, '$sp_title', '$sp_content', '$sp_type', '$active_from_date', $sp_project_id)";
                if($i< $cnt-1){
                        $sqlInsert .= ', ';
                }else{
                        $sqlInsert .= ';';
                }
                $i++;
        }
        $this->createStaticPagesTempTable();
        Yii::$app->db->createCommand($sqlInsert)->execute();

        $sql1 = "DROP TABLE IF EXISTS static_pages";
        $sql2 = "RENAME TABLE static_pages_temp TO static_pages";
        Yii::$app->db->createCommand($sql1)->query();
        Yii::$app->db->createCommand($sql2)->query();
    }

    public static function createStaticPagesTempTable() {
        try {
            $sql = "DROP TABLE IF EXISTS static_pages_temp;
                CREATE TABLE static_pages_temp (
                        id int(11) NOT NULL,
                        static_page_type varchar(255) COLLATE utf8_bin NOT NULL,
                        static_page_title varchar(255) COLLATE utf8_bin NOT NULL,
                        static_page_content text COLLATE utf8_bin NOT NULL,
                        active_from_date datetime COLLATE utf8_bin NOT NULL,
                        project_id int(11) NOT NULL,
                        PRIMARY KEY (id),
                        FOREIGN KEY (project_id)
                        REFERENCES projects(project_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
           ";
            Yii::$app->db->createCommand($sql)->query();
            return "OK";
        } catch (Exception $e) {
            error_log("Database::createGamesTempTable: " . $e->getMessage());
            return "Database::createGamesTempTable: " . $e->getMessage();
        }
    }
}