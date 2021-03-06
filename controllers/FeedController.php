<?php

namespace app\controllers;

use Yii;
use app\models\FeedSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

use app\models\Feed;
use app\models\StaticPage;
use app\models\FeedType;
use yii\data\ActiveDataProvider;

/**
 * FeedController implements the CRUD actions for Feed model.
 */
class FeedController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Feed models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageTitle = "Home";
        return $this->renderCategory($pageTitle);
    }
    
    /**
     * Index method.
     * @param integer $id
     * @return mixed
     */
    public function actionStatic($id){
        $staticPage = StaticPage::find()->where(['id'=>$id])->one();
        if($staticPage == null){
            return $this->render('error', [
                'name' => '404 Not found',
                'message' => '404 Page not found!'
            ]);
        }
        return $this->render('static', [
            'staticPage' => $staticPage
        ]);
    }
	
	/**
     * Displays science page.
     *
     * @return string
     */
    public function actionScience()
    {
		$pageTitle = "Science";
        return $this->renderCategory($pageTitle);
    }
	
	/**
     * Displays tech page.
     *
     * @return string
     */
    public function actionTech()
    {
        $pageTitle = "Tech";
        return $this->renderCategory($pageTitle);
    }
	
	/**
     * Displays world page.
     *
     * @return string
     */
    public function actionWorld()
    {
        $pageTitle = "World";
        return $this->renderCategory($pageTitle);
    }
	
	/**
     * Displays politics page.
     *
     * @return string
     */
    public function actionPolitics()
    {
        $pageTitle = "Politics";
        return $this->renderCategory($pageTitle);
    }
	
	/**
     * Displays health page.
     *
     * @return string
     */
    public function actionHealth()
    {
        $pageTitle = "Health";
        return $this->renderCategory($pageTitle);
    }
	
	/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * Gets results for specific category.
	 *
	 * @return string
	 */
	private function renderCategory($pageTitle){
		$page = Yii::$app->request->get('page', 1);
		$data_key = 'category_'.$pageTitle.'_page_'.$page;
		$size_key = 'category_'.$pageTitle.'_count';
		$data = Yii::$app->cache->get($data_key);
				
		$data_cached = true;
		if($data === false){
			$data_cached = false;
		}
		if(!$data_cached) {
			// $data is not found in cache, calculate it from scratch
			if($pageTitle != "Home"){
				$data = Feed::find()
					->join('LEFT JOIN', 'feed_type', 'feed.type_id=feed_type.id')
					->where('feed_type.title=:type_title', array(':type_title'=>$pageTitle))
					->orderBy(['date_posted' => SORT_DESC]);
			}else{
				$data = Feed::find()
					->orderBy(['date_posted' => SORT_DESC]);
			}
			$data_size = $data->count();
			
			// store $data in cache so that it can be retrieved next time
		}else{
			$data_size = Yii::$app->cache->get($size_key);
		}
		
		// $data is available here
		$pagination = new Pagination([
			'defaultPageSize' => 6,
			'totalCount' => $data_size,
		]);
		
		// apply pagination offsets
		/* $feeds = $data->offset($pagination->offset)
			->limit($pagination->limit)
			->all();*/
		
		if(!$data_cached){ // cache paged data if it was calculated from scratch
			$feeds = $data->offset($pagination->offset)
			->limit($pagination->limit)
			->all();
			
			Yii::$app->cache->set($data_key, $feeds);
			if(Yii::$app->cache->get($size_key) === false){
				Yii::$app->cache->set($size_key, $data_size);
			}
		}else{
			$feeds = $data;
		}
			
		return $this->render('index', [
			'feeds' => $feeds,
			'pagination' => $pagination,
			"pageTitle" => $pageTitle,
		]);
	}
	
	/**
     * Ajax rating method.
     * @param integer $id
	 * @param integer $rating
     * @return mixed
     */
    public function actionRateArticle($id, $rating)
    {
		if(isset($_COOKIE['rated_articles'])){
			// deserialize and add id, then serialise and set cookie
			$arr = unserialize($_COOKIE['rated_articles']);
		}else{
			// create new cookie and set it
			$arr = array();
		}
		if(!in_array(''.$id, $arr)){
			$model = $this->findModel($id);
			$prevAccRating = ($model->num_rates * $model->rating);
			$model->num_rates += 1;
			$newRating = ($prevAccRating + $rating) / $model->num_rates;
			$model->rating = intval($newRating);
			if($model->save()){
				$arr[] = ''.$id;
				setcookie('rated_articles', serialize($arr), 2147483647, '/');
				return '{"result":"OK", "message":"OK"}';
			}else{
				return '{"result":"NOK", "message":"NOK"}';
			}
		}else{
			return '{"result":"NOK", "message":"Already rated this article."}';
		}
    }

    /**
     * Displays a single Feed model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Feed model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Feed();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Feed model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionUpdateViews($id){
		$model = $this->findModel($id);
		$model->num_views +=1;
		
		if ($model->save()) {
			return '{\"result\":\"OK\"}';
		}else{
			return '{\"result\":\"NOK\"}';
		}
		

	}
	
    /**
     * Deletes an existing Feed model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Feed model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Feed the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Feed::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	/**
     * Search method.
     * 
     * @param string $keyword
     * @return json
     */
	public function actionAjaxsearch($keyword){
		$feeds = Feed::find()
			->andFilterWhere(['like', 'description', $keyword])
			->limit(5)
			->all();
		
		$result = [];
		foreach($feeds as $f){
			$var = '{"title":"' . $f->title . '", "link":"' . $f->link . '"}';
			array_push($result, $var);
		}

		return json_encode($result);
	}
	
	/**
	 * Search method
	 *
	 * @param string $keyword
	 * @return mixed
	 */
	public function actionSearch($keyword){
		$keyword = trim($keyword);
		$keyword = stripslashes($keyword);
		$keyword = htmlspecialchars($keyword);
		
		$data = Feed::find();
		
        $data->orFilterWhere(['like', 'title', $keyword])
            ->orFilterWhere(['like', 'description', $keyword]);

		$pagination = new Pagination([
			'defaultPageSize' => 6,
			'totalCount' => $data->count(),
		]);

		$pageTitle = "Search results for keyword: " . $keyword;
		
		$feeds = $data->offset($pagination->offset)
				->limit($pagination->limit)
				->all();
		
		return $this->render('index', [
			'feeds' => $feeds,
			'pagination' => $pagination,
			"pageTitle" => $pageTitle,
		]);

		
	}
}
