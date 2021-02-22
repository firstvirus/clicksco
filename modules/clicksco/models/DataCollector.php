<?php

namespace app\modules\clicksco\models;

use yii\base\Model;
use app\modules\clicksco\models\{ Proxy, Options };
use linslin\yii2\curl;

/**
 * @author Virus
 */
class DataCollector extends Model {
    // TODO: Need optimize this shit
    public static function getPage($link, $proxyIP, $proxyPort) {
        if (!class_exists('\\linslin\\yii2\\curl\\Curl')) {
            throw new Exception('linslin\\yii2\\curl\\Curl is needed.');
        }

        $curl = new curl\Curl();

        $curl->setOption(CURLOPT_PROXY, $proxyIP);
        $curl->setOption(CURLOPT_PROXYPORT, $proxyPort);
        $curl->setOption(CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);

        $curl->setOption(CURLOPT_HTTPHEADER, [
            'accept: text/html',
            'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36'
        ]);
        
        $response = $curl->get($link);
        if ($curl->errorCode === null) {
            //$option = new Options();
            $option = Options::findOne(['key', 'last_file']);
            echo '<pre>';
            print_r($option);
            echo '</pre>';die();
            $filename = time() . 'html';
            $option->value = $filename;
            $option->save();

            return file_put_contents('temp/' . $filename, $response);
        } else {
            return $curl->errorCode . '|' . $curl->errorText;
        }
/*
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
            $proxy->setProxyToCurl($curl);
        }
*/
        // Getting page
    }
/* 
    public static function getFile($link) {
        // Getting page
        $file = self::getPage($link);
        if ($file != 0) {
            // Generate filename and write it to options table
            $option = Options::findOne(['key', 'last_file']);
            $filename = time() . 'html';
            $option->value = $filename;
            $option->save();
            // Saving file
            file_put_contents('temp/' , $filename, $file);
        } else {
            return false;
        }
    }
*/
}
