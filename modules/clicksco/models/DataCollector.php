<?php

namespace app\modules\clicksco\models;

use yii\base\Model;
use app\modules\clicksco\models\{ Proxy, Options };
use linslin\yii2\curl;

/**
 * @author Virus
 */
class DataCollector extends Model {
    public static function getPage($link) {
        if (!class_exists('\\linslin\\yii2\\curl\\Curl')) {
            throw new Exception('linslin\\yii2\\curl\\Curl is needed.');
        }

        $curl = new curl\Curl();

        $curl->setOption(CURLOPT_HTTPHEADER, [
            'accept: text/html',
            'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36'
        ]);
        
        $response = $curl->get($link);
        if ($curl->errorCode === null) {
            $option = Options::findOne(['key' => 'last_file']);
            $filename = time() . '.html';
            $option->value = $filename;
            $option->save();

            return file_put_contents('temp/' . $filename, $response);
        } else {
            return $curl->errorCode . '|' . $curl->errorText;
        }
    }

}
