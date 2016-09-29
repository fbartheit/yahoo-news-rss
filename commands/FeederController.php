<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\Feed;
use app\models\FeedType;

class FeederController extends Controller {
 
    public function actionIndex() {
        $feedCategories = FeedType::find()->all();       
        $this->retrieveFeeds($feedCategories);
    }
    
    public function retrieveFeeds($feedCategories){
        $feeds = [];
        $datetime = $this->getLastFeedDate();
        
        foreach($feedCategories as $cat){
            $content = file_get_contents($cat->link);
            $item = simplexml_load_string($content);
            foreach($item->channel->item as $entry){
                // title, description, link, pubDate, source, guid
                $entryDate = date('Y-m-d H:i:s', strtotime($entry->pubDate));
                if($entryDate > $datetime){
                    $feed = new Feed();
                    $feed->title = $entry->title;
                    $feed->description = $entry->description;
                    $feed->image_link = '';
                    
                    $matches = [];
                    preg_match('/src="(.*?)"/', $feed->description, $matches);
                    try{
                        $feed->image_link = $matches[1];
                        $pos = strpos($feed->description, "</a>");
                        $temp = substr($feed->description, $pos);
                        $feed->description = strip_tags($temp);
                    } catch(\yii\base\ErrorException $e){
                        //echo "nema slike";
                    }
                    
                    $feed->link = $entry->link;
                    $feed->date_posted = $entryDate;
                    $feed->type_id = $cat->id;
                                        
                    $feed->save(false);
                }
            }
        }
        Yii::$app->cache->flush();
    }
    
    public function getLastFeedDate(){
        $data = 0;
        $data = Feed::find()
            ->orderBy(['date_posted' => SORT_DESC])
            ->one();
        if($data) return $data->date_posted;
        return $data;
    }
}