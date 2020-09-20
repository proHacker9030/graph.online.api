<?php

namespace app\models;


use yii\db\Query;

class Vertex extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'vertexes';
    }

    public function rules()
    {
        return [
            [['graph_id', 'x', 'y', 'name'], 'required'],
            ['color', 'safe']
        ];
    }


    public function beforeDelete()
    {
        // удаляем все ребра примыкающие к этой вершине
        Edge::deleteAll(['or', 'start_vertex_id=' . $this->id, 'end_vertex_id=' . $this->id]);
        return parent::beforeDelete();
    }
}