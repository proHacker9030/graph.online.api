<?php

use yii\db\Migration;

/**
 * Class m200917_144536_add_graph_table
 */
class m200917_144536_add_graph_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('graphs', [
            'id' =>  $this->primaryKey(),
            'name' =>  $this->string(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('graphs');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200917_144536_add_graph_table cannot be reverted.\n";

        return false;
    }
    */
}
