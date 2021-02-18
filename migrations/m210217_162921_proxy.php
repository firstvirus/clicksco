<?php

use yii\db\Migration;

/**
 * Class m210217_162921_proxy
 */
class m210217_162921_proxy extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clicksco_proxy}}', [
            '[[id]]'        => $this->primaryKey(),
            '[[ip]]'        => $this->string(15)->notNull(),
            '[[port]]'      => $this->integer(5)->defaultValue('0'),
            '[[type]]'      => $this->integer()->defaultValue('1'),
            '[[needlogin]]' => $this->integer(1)->defaultValue('0'),
            '[[login]]'     => $this->string(),
            '[[pass]]'      => $this->string(),
            '[[work]]'      => $this->integer()->defaultValue('0'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clicksco_proxy}}');

        return true;
    }

}
