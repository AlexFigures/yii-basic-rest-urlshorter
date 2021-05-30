<?php


namespace app\modules\api\v1\controllers;


use app\modules\api\v1\models\Link;
use Yii;
use yii\helpers\Url;
use yii\rest\ActiveController;
use app\commands\GenerateShortLink;
use yii\web\ServerErrorHttpException;

class LinkController extends ActiveController
{
    public $modelClass = 'app\modules\api\v1\models\Link';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \yii\ filters\ ContentNegotiator::className(),
                'formats' => [
                    'application/json' => \yii\ web\ Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['delete'], $actions['view'], $actions['create']);

        return $actions;
    }

    public function actionView($hash)
    {
         $link = Link::findOne([
            "short_hash" => $hash
        ]);
        return [
            'full_url' => $link->full_url,
            'counter' => $link->counter
        ];
    }

    public function actionRedirect($hash)
    {
        $link = Link::findOne([
            "short_hash" => $hash
        ]);
        ++$link->counter;
        $link->save();
        $response = Yii::$app->getResponse();
        $response->setStatusCode(201);
        $this->redirect($link->full_url);

    }

    public function actionCreate()
    {
        $model = new $this->modelClass;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            $hashObject = new GenerateShortLink($model->full_url);
            $model->short_hash = $hashObject->generatedHash;
            $model->save();
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            return $this->asJson(["short_url" => Url::base(true) . '/' . $model->short_hash]);
        }

        if (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;

    }

}