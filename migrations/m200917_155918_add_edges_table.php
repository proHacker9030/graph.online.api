<?php

use yii\db\Migration;

/**
 * Class m200917_155918_add_edges_table
 */
class m200917_155918_add_edges_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('edges', [
            'id' =>  $this->primaryKey(),
            'graph_id' => $this->integer(11)->notNull(),
            'start_vertex_id' => $this->integer(11)->notNull(),
            'end_vertex_id' => $this->integer(11)->notNull(),
            'weight' => $this->float()->notNull(),
            'is_oriented' => $this->boolean()->defaultValue(false)
        ]);

        $this->addForeignKey(
            'fk-graphs-graph_id',
            'edges',
            'graph_id',
            'graphs',
            'id',
            'NO ACTION'
        );


        $this->addForeignKey(
            'fk-vertexes-start_vertex_id',
            'edges',
            'start_vertex_id',
            'vertexes',
            'id',
            'NO ACTION'
        );

        $this->addForeignKey(
            'fk-vertexes-end_vertex_id',
            'edges',
            'end_vertex_id',
            'vertexes',
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
            'edges');

        $this->dropForeignKey(
            'fk-vertexes-start_vertex_id',
            'edges');

        $this->dropForeignKey(
            'fk-vertexes-end_vertex_id',
            'edges');

        $this->dropTable('edges');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200917_155918_add_edges_table cannot be reverted.\n";

        return false;
    }
    */
}
