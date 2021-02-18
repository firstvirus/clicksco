<?php

namespace app\modules\clicksco\models;

//use Yii;
use linslin\yii2\curl;

/**
 * This is the model class for table "{{%clicksco_proxy}}".
 *
 * @property int $id
 * @property string $ip
 * @property int|null $port
 * @property int|null $type
 * @property string|null $login
 * @property string|null $pass
 * @property int|null $work
 */
class Proxy extends \yii\db\ActiveRecord
{
    // Service for check IP
    static $TARGET = 'check-host.net/ip';

    // Proxy types
    static $TYPES = [
        '1' => 'HTML',
        '4' => 'SOCKS4',
        '5' => 'SOCKS5',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%clicksco_proxy}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ip', 'port'], 'required'],
            [['ip'], 'ip', 'ipv6' => false],
            ['port', 'integer', 'min' => 0, 'max' => 65535],
            [['type', 'work', 'errors'], 'integer'],
            ['needlogin', 'boolean'],
            [['login', 'pass'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'ip'        => 'Ip',
            'port'      => 'Port',
            'type'      => 'Type',
            'needlogin' => 'Need authenticate',
            'login'     => 'Login',
            'pass'      => 'Pass',
            'work'      => 'Work',
            'errors'    => 'Errors'
        ];
    }

    public function getProxyList() {
        return self::findAll();
    }

    public function checkProxy() {
        //Init cURL
        if (!class_exists('\\linslin\\yii2\\curl\\Curl')) {
            throw new Exception('linslin\\yii2\\curl\\Curl is needed.');
        }
        $curl = new curl\Curl();

        // Setting options of cURL with proxy
        $this->setProxyToCurl($curl);
        // Sending request to check-host.net/ip
        $curl->post(self::$TARGET);

        // If error, then increment errors counter
        if (!empty($curl->errorCode)) { 
            $this->errors++;
            $this->save();
        }

        return $curl->errorText;
    }

    public function setProxyToCurl($curl) {
        $curl->setOption(CURLOPT_PROXY, $this->ip);
        $curl->setOption(CURLOPT_PROXYPORT, $this->port);
        switch ($this->type) {
            case 4:
                $curl->setOption(CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
                break;
            case 5:
                $curl->setOption(CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
                break;
            default:
                $curl->setOption(CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
                break;
        }
    }

}
