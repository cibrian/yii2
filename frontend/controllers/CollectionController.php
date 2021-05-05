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

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'show', 'remove', 'photo', 'update', 'create','delete', 'download','welcome'],
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
                    'create' => ['post'],
                    'delete' => ['delete'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
            $this->enableCsrfValidation = false;
            return parent::beforeAction($action);
    }


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

       $collections = Collection::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
       $model = new Collection;

       return $this->render('index', [
            'collections' => $collections,
            'model' => $model,
        ]);

    }

    public function actionCreate()
    {
       $request = Yii::$app->request;
       $model = new Collection;
       $name = $request->post('Collection')['name'];
       $model->name = $name;
       $model->user_id =  (Yii::$app->user->identity)->id;
       $model->save();

       $this->redirect(array('collection/index'));

    }


    public function actionShow($id)
    {

        $collection = Collection::find()->where(['id' => $id])->cache(60)->one();

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

        $u = User::find()
            ->where(['id'=>$user->id])
            ->with('collections.photos')->one();

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


    public function actionDelete($id)
    {

        $collection = Collection::find()
            ->where(['id'=>$id])
            ->one();

        $collection->delete();

        $this->redirect(array('collection/index'));

    }

    public function actionDownload($id)
    {
        set_time_limit(0);
        $zipfile = dirname(__DIR__).'/files/Collection.zip';
        if (file_exists($zipfile)) {
            unlink($zipfile);
        }
        $collection = Collection::find()->where(['id' => $id])->one();
        $zip = new \ZipArchive();

        foreach ($collection->photos as $photo) {
            $filename = dirname(__DIR__)."/files/{$photo->photo_id}.jpg";
            $file = fopen($filename, 'w+');

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL            => $photo->photo_path,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FILE           => $file,
                CURLOPT_TIMEOUT        => 50,
                CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'
            ]);

            $response = curl_exec($curl);
            curl_close($curl);
            $flag = \ZipArchive::CREATE;
            if($zip->open($zipfile, $flag) === true){
                $zip->addFile($filename, "{$photo->photo_id}.jpg");
                $zip->close();
            }
            else{
                echo "Error";
            }
        }

        return Yii::$app->response->sendFile($zipfile);

    }

}
