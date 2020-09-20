<?php

namespace app\models;

class Edge extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'edges';
    }

    public function rules()
    {
        return [
            [['graph_id', 'start_vertex_id', 'end_vertex_id', 'weight'], 'required'],
            ['is_oriented','safe']
        ];
    }
}