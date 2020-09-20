<?php


namespace app\controllers;


use app\models\Edge;
use app\models\Vertex;
use app\services\GraphService;
use Yii;
use yii\db\Query;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\web\HttpException;

class GraphController extends ActiveController
{
    public $modelClass = 'app\models\Graph';

    /**
     * Получение всех вершин и ребер графа
     * @param $id
     * @return array
     * @throws HttpException
     */
    public function actionAllVertexesAndEdges($id)
    {
        if (empty($id))
            throw new HttpException(500, 'Graph id is not defined');

        $edges = Edge::find()->where(['graph_id' => $id])->asArray()->all();
        $vertexes = Vertex::find()->where(['graph_id' => $id])->asArray()->all();

        return [
            'vertexes' => $vertexes,
            'edges' => $edges
        ];
    }

    /**
     * Удаление всех вершин и ребер графа
     * @param $id
     * @return array
     * @throws HttpException
     */
    public function actionClean($id)
    {
        if (empty($id))
            throw new HttpException(500, 'Graph id is not defined');

        Edge::deleteAll(['graph_id' => $id]);
        Vertex::deleteAll(['graph_id' => $id]);

        return ['success' => 1];
    }

    /**
     * Обновление вершин графа
     * @param $id
     * @return array
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdateVertexes($id)
    {
        if (empty($id))
            throw new HttpException(500, 'Graph id is not defined');

        $params = Yii::$app->getRequest()->getBodyParams();
        $newVertexes = $params['vertexes'];
        if (empty($newVertexes))
            throw new HttpException(500, 'Vertexes are not defined');

        $oldVertexes = Vertex::find()->where(['graph_id' => $id])->all();
        $vertexes = [];
        foreach ($oldVertexes as $vertex) {
            $vertexes[$vertex->id] = $vertex;
        }
        foreach ($newVertexes as $vertex) {
            $vertexes[$vertex['id']]->name = $vertex['name'];
            $vertexes[$vertex['id']]->x = $vertex['x'];
            $vertexes[$vertex['id']]->y = $vertex['y'];
            $vertexes[$vertex['id']]->color = $vertex['color'] ?? $vertex['fill'];
            if (!$vertexes[$vertex['id']]->save())
                return ['success' => 0, 'vertex_id' => $vertex['id'], 'errors' => $vertexes[$vertex['id']]->getErrors()];
        }

        return ['success' => 1];
    }
}