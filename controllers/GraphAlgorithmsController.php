<?php


namespace app\controllers;


use app\models\Edge;
use app\models\Vertex;
use app\services\GraphService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;

class GraphAlgorithmsController extends Controller
{
    private $graphService;

    public function __construct($id, $module, GraphService $graphService, $config = [])
    {
        $this->graphService = $graphService;
        parent::__construct($id, $module, $config);
    }

    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'verbFilter' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'shortest-path' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Поиск кратчайшего пути между 2 вершинами
     * @return array|int
     * @throws HttpException
     */
    public function actionShortestPath()
    {
        $graphId = \Yii::$app->request->get('graphId', null);
        $startVertexId = \Yii::$app->request->get('startVertexId', null);
        $endVertexId = \Yii::$app->request->get('endVertexId', null);

        if (empty($graphId) || empty($startVertexId) || empty($endVertexId))
            throw new HttpException(500, 'Wrong or not enough data');

        $this->graphService->edges = Edge::find()->where(['graph_id' => $graphId])->all();
        $this->graphService->vertexes = Vertex::find()->where(['graph_id' => $graphId])->all();

        return $this->graphService->algorithmDijkstra($startVertexId, $endVertexId);
    }
}