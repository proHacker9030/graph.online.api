<?php

use yii\db\Migration;

/**
 * Class m200917_151353_add_vertexes_table
 */
class m200917_151353_add_vertexes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('vertexes', [
            'id' =>  $this->primaryKey(),
            'graph_id' => $this->integer(11)->notNull(),
            'name' =>  $this->string(255)->notNull(),
            'x' => $this->double()->notNull(),
            'y' => $this->double()->notNull(),
            'color' => $this->string(20)
        ]);


        $this->addForeignKey(
            'fk-graphs-graph_id',
            'vertexes',
            'graph_id',
            'graphs',
            'id',
            'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-graphs-graph_id',
            'vertexes');

        $this->dropTable('vertexes');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200917_151353_add_vertexes_table cannot be reverted.\n";

        return false;
    }
    */
}
