<?php

namespace app\bootstrap;

class BeforeController extends \yii\base\Component
{
    public function init()
    {
        \Yii::$app->response->getHeaders()->add('Access-Control-Allow-Origin','*');
        parent::init();
    }
}