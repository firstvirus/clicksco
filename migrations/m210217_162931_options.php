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
            '[[id]]'    => $this->primaryKey(),
            '[[key]]'   => $this->string()->notNull(),
            '[[value]]' => $this->string(),
        ]);

        $this->insert('{{%clicksco_options}}',[
            '[[key]]'   => 'step',
            '[[value]]' => '0',
        ]);

        $this->insert('{{%clicksco_options}}',[
            '[[key]]'   => 'use_proxy',
            '[[value]]' => '0',
        ]);

        $this->insert('{{%clicksco_options}}',[
            '[[key]]'   => 'last_proxy',
            '[[value]]' => '0',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clicksco_options}}');

        return true;
    }

}
