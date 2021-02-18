<?php

use yii\db\Migration;

/**
 * Class m210217_162931_options
 */
class m210217_162931_options extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clicksco_options}}', [
            '[[key]]'   => $this->string()->notNull(),
            '[[value]]' => $this->string(),
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
