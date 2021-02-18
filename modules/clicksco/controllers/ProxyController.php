<?php

namespace app\modules\clicksco\controllers;

use app\modules\clicksco\models\Proxy;

class ProxyController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $proxy = new Proxy();
        if ($proxy->load(\Yii::$app->request->post()) && $proxy->validate()) {
            $proxy->save();
            return $this->refresh();
        }
        $proxies = Proxy::find()->asArray()->all();
        return $this->render('index', [
            'proxy'   => $proxy,
            'proxies' => $proxies,
            'types'   => Proxy::$TYPES
            ]);
    }

    public function actionDelete($id) {
        Proxy::deleteAll(['id' => $id]);
        return \Yii::$app->response->redirect(\yii\helpers\Url::to('/clicksco/proxy'));
    }
    
}
