<?php

namespace app\controllers;

use Yii;
use app\models\Subscription;
use app\models\Author;
use yii\web\Controller;

class SubscriptionController extends Controller
{
    public function actionSubscribe()
    {
        $model = new Subscription();
        $authors = Author::find()->orderBy('full_name')->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'You have subscribed successfully.');
            return $this->refresh();
        }

        return $this->render('subscribe', [
            'model'   => $model,
            'authors' => $authors,
        ]);
    }
}
