<?php

use yii\db\Migration;

/**
 * Class m200917_145414_add_main_graph
 */
class m200917_145414_add_main_graph extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert("graphs", ['name' => 'Main']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete("graphs",['name' => 'Main']);

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200917_145414_add_main_graph cannot be reverted.\n";

        return false;
    }
    */
}
