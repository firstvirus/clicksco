<?php

namespace app\modules\clicksco\models;

use app\modules\clicksco\models\{ Proxy, Options };
use linslin\yii2\curl;

/**
 * @author Virus
 */
class DataCollector extends Model {
    
    // TODO: Need optimize this shit
    public function getPage($link) {
        // Using the method of partial sequential enumeration, we find a valid
        // proxy
        $withProxy = Options::find()->
                                where(['key' => 'use_proxy'])->
                                asArray()->
                                one();
        if ($withProxy['value'] == '1') {
            // Search id of last used proxy
            $lastProxy = $option = Options::find()->
                                                where(['key' => 'last_proxy'])->
                                                one();

            // Search proxies which id more then id last used proxy
            $proxies = Proxy::find()->
                                where('id >= ' . $option->value)->
                                all();
            foreach ($proxies as $proxy) {
                $result = $proxy->checkProxy();
                // If found working proxy then break cycle
                if (empty($result)) {
                    $option->value = $proxy->id;
                    $option->save();
                    break;
                }
            }
            // If not found working proxy, then repeat search from begin proxy
            // list to id of last used proxy
            if (!empty($result)) {
                $proxies = Proxy::find()->
                                    where('id < ' . $lastProxy->value)->
                                    all();
                foreach ($proxies as $proxy) {
                    $result = $proxy->checkProxy();
                    if (empty($result)) {
                        $option->value = $proxy->id;
                        $option->save();
                        break;
                    }
                }
                if (!empty($result)) { return "Can't found working proxy.\nPlease check proxy list."; }
            }
        }

        // Getting page
        if (!class_exists('\\linslin\\yii2\\curl\\Curl')) {
            throw new Exception('linslin\\yii2\\curl\\Curl is needed.');
        }

        $curl = new curl\Curl();
        if ($withProxy['value'] == '1') {
            $proxy->setProxyToCurl($curl);
        }
        return $curl->get($link);
    }
}
