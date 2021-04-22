<?php
namespace backend\controllers;

use Unsplash;
use Yii;
use common\models\CollectionPhoto;
use common\models\User;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Site controller
 */
class UnsplashController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'search' => ['post'],
                    'updateCollection' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
            $this->enableCsrfValidation = false;
            return parent::beforeAction($action);
    }


    public function actionSearch()
    {

        Unsplash\HttpClient::init([
            'applicationId' => 'f8ulmBmgZ7QYMM4Jvn_lFpAbU9-oh2whhAvaQatoSCk',
            'secret'    => 'crrX0Hwgm0siUFB6suZtTjvJ6NmkZ2eL1BW8TLkPtFA',
            'callbackUrl'   => 'https://your-application.com/oauth/callback',
            'utmSource' => 'NAME OF YOUR APPLICATION'
        ]);

        $request = Yii::$app->request;
        $user = Yii::$app->user->identity;

        $query = $request->post('UnsplashSearchForm')['query'];

        $result = Unsplash\Search::photos($query, 1, 12,'landscape')->getResults();
        $photos = [];
        foreach ($result as $photo) {
            $photos[] = [
                'id'=>$photo['id'],
                'urls'=>$photo['urls'],
            ];
        }

        // var_dump((array)$photos);
        return \Yii::createObject([
            'class' => 'yii\web\Response',
            'format' => \yii\web\Response::FORMAT_JSON,
            'data' => [
                'photos' => $photos,
                'code' => 100,
                'success' => true,
                'user' => $user,
            ],
        ]);
    }

    /**
     * Add/Remove image to/from Collection
     *
     * @return string
     */
    public function actionUpdate()
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
}
