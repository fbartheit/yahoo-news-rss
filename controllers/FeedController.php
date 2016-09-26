<?php

namespace app\controllers;

use Yii;
use app\models\FeedSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

use app\models\Feed;
use app\models\FeedType;

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
        /*$searchModel = new FeedSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
		$pageTitle = "Home";
		return $this->renderCategory($pageTitle);
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
		$key = 'category_'.$pageTitle.'_page_'.$page;
		$data = Yii::$app->cache->get($key);
		
		$data_cached = true;
		if($data === false){
			$data_cached = false;
		}
		if (!$data_cached) {
			// $data is not found in cache, calculate it from scratch
			if($pageTitle != "Home"){
				$data = Feed::find()
					->join('LEFT JOIN', 'feed_type', 'feed.type_id=feed_type.id')
					->where('feed_type.title=:type_title', array(':type_title'=>$pageTitle))
					->orderBy('feed.date_posted ASC');
			}else{
				$data = Feed::find()->orderBy('title')
					->orderBy('feed.date_posted ASC');
			}
			// store $data in cache so that it can be retrieved next time
		}

		// $data is available here
		
		$pagination = new Pagination([
			'defaultPageSize' => 6,
			'totalCount' => $data->count(),
		]);
		
		// apply pagination offsets
		if($pageTitle != "Home"){
			$feeds = $data->offset($pagination->offset)
				->limit($pagination->limit)
				->all();
		}else{
			$feeds = $data->offset($pagination->offset)
				->limit($pagination->limit)
				->all();
		}
		
		if(!$data_cached){ // cache paged data if it was calculated from scratch
			Yii::$app->cache->set($key, $data);
			//echo "data stored to key " . $key."data:";
			//var_dump($feeds);
		}
			
		return $this->render('index', [
			'feeds' => $feeds,
			'pagination' => $pagination,
			"pageTitle" => $pageTitle,
		]);
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
	
	private function dummy_feeds(){
		$feeds = array();
		
		for($i=0; $i<20; $i++){
			$feed1 = new Feed();
			$feed1->id = "$i";
			$feed1->title = "Feed $i";
			$feed1->description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nisl lacus, condimentum ut nibh sit amet, tempor pretium massa. Fusce congue porttitor dolor ultrices dictum. Proin neque dolor, malesuada ac eleifend viverra, vehicula et metus. Fusce ultrices sollicitudin mollis. Cras vulputate, dui quis blandit pretium, enim urna venenatis velit, ut dictum mauris elit ac nisl. Phasellus accumsan lorem orci, vitae vestibulum mi  tincidunt vel. Praesent interdum lacus nec nunc ullamcorper, luctus egestas elit pulvinar.";
			$feed1->date_posted = "Wed, 10 Feb 2016 00:13:20";
			$feed1->rating = 4 + $i%2;
			$feed1->num_views = "128";
			$feed1->num_rates = "45";
			$feed1["link"] = "http://www.google.com";
			$feed1->image_link = "";
			$feed1->type_id = 1 + $i%4;
			$feeds[$i] = $feed1;
		}
		return $feeds;
	}
	
}
