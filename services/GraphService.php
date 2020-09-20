<?php

namespace app\services;

use app\models\Edge;
use function PHPSTORM_META\map;
use yii\helpers\ArrayHelper;

class GraphService
{
    /**
     *  массив верщин
     */
    public $vertexes;

    /**
     *  массив ребер
     */
    public $edges;

    /**
     * Поиск кратчайшего пути алгоритмом Дейкстры
     * @param integer $source
     * @param integer $target
     * @return array|int
     */
    public function algorithmDijkstra($source, $target)
    {
        $visited = []; // массив для запоминания посещенных вершин
        $distance = []; //массив расстояний до каждой вершины (массив меток)
        $n = count($this->vertexes);
        $vertexes = ArrayHelper::toArray($this->vertexes);
        $ids =  ArrayHelper::getColumn($vertexes,'id');
        $startVertexId = min($ids);
        $matrix = $this->getMatrix($n, $startVertexId);// матрица смежности
        $path = []; // путь
        $prev = []; //массив предшествующих вершин в пути
        for ($i = $startVertexId; $i < $startVertexId + $n; $i++) {
            $visited[$i] = false;
            $distance[$i] = PHP_INT_MAX;
            $prev[$i] = -1;
        }

        $distance[$source] = 0;
        $current_top = $startVertexId;
        $min = 0;
        for ($i = $startVertexId; $i < $startVertexId + $n - 1; $i++) {
            $min = PHP_INT_MAX;
            for ($j = $startVertexId; $j < $startVertexId + $n; $j++) {
                if (!$visited[$j] && $distance[$j] < $min) {
                    $min = $distance[$j];
                    $current_top = $j;
                }
            }
            $visited[$current_top] = true;
            for ($k = $startVertexId; $k < $startVertexId + $n; $k++) {
                if (!$visited[$k] && $matrix[$current_top][$k] != 0 && ($distance[$current_top] + $matrix[$current_top][$k]) < $distance[$k]) {
                    $distance[$k] = $distance[$current_top] + $matrix[$current_top][$k];
                    $prev[$k] = $current_top;
                }
            }
        }

        $result = array();

        if ($distance[$target] != PHP_INT_MAX && $distance[$target] != 0) {
            $result['distance'] = $distance[$target];
        } else {
            return 0;
        }

        $i = $target;
        $pathLength = 1;
        while ($i != $source) {
            $pathLength++;
            $i = $prev[$i];
        }

        $j = 1;
        $i = $target;
        while ($i != $source) {
            $path[$pathLength - $j] = $i;
            $i = $prev[$i];
            $j++;
        }

        $path[0] = $source;

        $result['path'] = $path;
        $result['pathlen'] = $pathLength;

        return $result;
    }



    /**
     * Получение матрицы смежности
     * @param integer $n
     * @return array
     */
    public function getMatrix($n, $startVertexId) {
        $matrix = [];
        for ($i = $startVertexId; $i < $startVertexId + $n; $i++) {
            $matrix[$i] = [];
            for ($j = $startVertexId; $j < $startVertexId + $n; $j++) {
                $matrix[$i][$j] = 0;
            }
        }

        /** @var Edge $edge */
        foreach ($this->edges as $edge) {
            $matrix[$edge->start_vertex_id][$edge->end_vertex_id] = $edge->weight;
        }
        return $matrix;
    }
}