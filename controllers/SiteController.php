<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\models\LoginForm;
use app\models\ContactForm;

use app\models\Feed;
use app\models\FeedType;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		$pageTitle = "Home";
		return $this->renderCategory("home", $pageTitle);
    }
	
	/**
     * Displays science page.
     *
     * @return string
     */
    public function actionScience()
    {
		$pageTitle = "Science";
        return $this->renderCategory("science", $pageTitle);
    }
	
	/**
     * Displays tech page.
     *
     * @return string
     */
    public function actionTech()
    {
        $pageTitle = "Tech";
        return $this->renderCategory("tech", $pageTitle);
    }
	
	/**
     * Displays world page.
     *
     * @return string
     */
    public function actionWorld()
    {
        $pageTitle = "World";
        return $this->renderCategory("world", $pageTitle);
    }
	
	/**
     * Displays politics page.
     *
     * @return string
     */
    public function actionPolitics()
    {
        $pageTitle = "Politics";
        return $this->renderCategory("politics", $pageTitle);
    }
	
	/**
     * Displays health page.
     *
     * @return string
     */
    public function actionHealth()
    {
        $pageTitle = "Health";
        return $this->renderCategory("health", $pageTitle);
    }
	
	/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
	 * Gets results for specific category.
	 *
	 * @return string
	 */
	private function renderCategory($categoryName, $pageTitle){
		$query = FeedType::find();
		
		$pagination = new Pagination([
			'defaultPageSize' => 2,
			'totalCount' => $query->count(),
		]);
		
		$feeds = $query->orderBy('title')
			->offset($pagination->offset)
			->limit($pagination->limit)
			->all();
			
		return $this->render('index', [
			'feeds' => $feeds,
			'pagination' => $pagination,
			"pageTitle" => $pageTitle,
		]);
	}
	

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
