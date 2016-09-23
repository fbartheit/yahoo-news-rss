<?php

namespace yii\console\controllers;
use yii\console\Controller;
use yii\console\models\Feed;
use yii\console\models\FeedType;

class FeederController extends Controller {
 
    public function actionIndex() {
        
        $feedCategories = $this->getFeedCategories();
        
        $feeds = $this->retrieveFeeds($feedCategories);
        $this->rememberFeeds($feeds);
        
    }
    
    public function retrieveFeeds($feedCategories){
        $feeds = [];
        foreach($feedCategories as $cat){
            $content = file_get_contents($cat->link);
            $item = simplexml_load_string($content);
            foreach($item->channel->item as $entry){
                // title, description, link, pubDate, source, guid
                $feed = new Feed();
                $feed->title = $entry->title;
                $feed->description = $entry->description;
                $feed->link = $entry->link;
                $feed->date_posted = $entry->pubDate;
                $feed->typeId = $cat->id;
                array_push($feeds, $feed);
            }
        }
        return $feeds;
    }
    
    public function rememberFeeds($feeds){
        $conn = $this->createConnection();
        
        $values = [];
        foreach($feeds as $feed){
            $row = [$feed->title, $feed->description, $feed->date_posted, $feed->link, $feed->typeId];
            array_push($values, $row);
        }
        
        
        $conn->createCommand()->batchInsert('feed',
            ['title', 'description', 'date_posted', 'link', 'type_id'],
             $values)->execute();
             
    }
    
    public function getFeedCategories(){
        $feedCategories = [];
        $conn = $this->createConnection();
        $result = $conn->createCommand('SELECT * FROM feed_type')->queryAll();
        foreach($result as $res){
            $cat = new FeedType();
            $cat->id = $res['id'];
            $cat->title = $res['title'];
            $cat->link = $res['link'];
            array_push($feedCategories, $cat);
        }
        return $feedCategories;
    }

    public function createConnection(){
        return new \yii\db\Connection([
            'dsn' => 'mysql:host=localhost;dbname=bravo_projekat',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ]);
    }
}