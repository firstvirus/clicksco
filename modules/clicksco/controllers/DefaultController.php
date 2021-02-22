<?php

namespace app\modules\clicksco\controllers;

use yii\web\Controller;
use app\modules\clicksco\models\{ DataCollector, Options, Proxy };
//use linslin\yii2\curl;

/**
 * Default controller for the `clicksco` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

//        $curl = new curl\Curl();

        $proxy = new Proxy();
        if ($proxy->load(\Yii::$app->request->post())) {
            $page = DataCollector::getPage('https://www.coupons.com/coupon-codes/stores/', $proxy->ip, $proxy->port);
        }

        return $this->render('index', ['page' => $page, 'proxy' => $proxy]);
    }

    public function actionParseGroup() {
        $option = Options::findOne(['key', 'last_file']);
        $file = file_get_contents($option->value);
        $pattern = '/https:\/\/www\.coupons\.com\/coupon-codes\/stores\/[a-z]/';
        preg_match_all($pattern, $file, $keys);
        $keys = array_unique($keys);
        $keys = $keys[0];
        $pattern = '/https:\/\/www\.coupons\.com\/coupon-codes\/stores\/0\-9/';
        preg_match_all($pattern, $file, $lost);
        $keys[] = $lost[0][0];
        echo '<pre>';
        print_r($keys);
        echo '</pre>';
    }
}
