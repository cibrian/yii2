<?php
namespace frontend\controllers;

use Unsplash;
use Yii;
use frontend\models\UnsplashSearchForm;
use common\models\Collection;
use common\models\CollectionPhoto;
use common\models\LoginForm;
use common\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Collection controller
 */
class CollectionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'show', 'remove', 'photo', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'remove' => ['post'],
                    'update' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
            $this->enableCsrfValidation = false;
            return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    public function actionIndex()
    {

       $user = Yii::$app->user->identity;

       return $this->render('index', [
            'user' => $user,
        ]);

    }


    public function actionShow($id)
    {

        $collection = Collection::find()->where(['id' => $id])->one();
        return $this->render('show', [
            'collection' => $collection,
        ]);

    }


    public function actionRemove()
    {

        $request = Yii::$app->request;

        $collectionId = $request->post('collection_id');
        $photoId = $request->post('photo_id');

        $collectionPhoto = CollectionPhoto::find()
            ->where(['collection_id'=>$collectionId])
            ->andwhere(['photo_id'=>$photoId])
            ->one();

        if ($collectionPhoto) {
            $collectionPhoto->delete();
        }


        return \Yii::createObject([
            'class' => 'yii\web\Response',
            'format' => \yii\web\Response::FORMAT_JSON,
            'data' => [
                'success' => true,
            ],
        ]);

    }

    /**
     * Add/Remove image to/from Collection
     *
     * @return string
     */
    public function actionPhoto()
    {
        $request = Yii::$app->request;
        $collectionId = $request->post('collection_id');
        $photoId = $request->post('photo_id');
        $photoPath = $request->post('photo_path');
        $collectionPhoto = CollectionPhoto::find()
            ->where(['collection_id'=>$collectionId])
            ->andwhere(['photo_id'=>$photoId])
            ->one();

        if ($collectionPhoto) {
            $collectionPhoto->delete();
        } else{
            $collectionPhoto = new CollectionPhoto();
            $collectionPhoto->collection_id = $collectionId;
            $collectionPhoto->photo_id = $photoId;
            $collectionPhoto->photo_path = $photoPath;
            $collectionPhoto->save();
        }

        $user = Yii::$app->user->identity;

        $u = User::find($user->id)->with('collections.photos')->one();

        $collections = [];
        foreach ($u->collections as $collection) {
            $photos=[];
            foreach ($collection->photos as $photo) {
                $photos[] = $photo->photo_id;
            }
            $collections[] = [
                'id' => $collection->id,
                'name' => $collection->name,
                'photos' => $photos
            ];
        }

        return \Yii::createObject([
            'class' => 'yii\web\Response',
            'format' => \yii\web\Response::FORMAT_JSON,
            'data' => [
                'collections' => $collections,
            ],
        ]);
    }

     /**
     * Add/Remove image to/from Collection
     *
     * @return string
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $name = $request->post('Collection')['name'];

        $collectionPhoto = Collection::find()
            ->where(['id'=>$id])
            ->one();

        $collectionPhoto->name = $name;
        $collectionPhoto->save();

        $this->redirect(array('collection/index'));

    }

}
