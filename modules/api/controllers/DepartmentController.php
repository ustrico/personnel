<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;

class DepartmentController extends ActiveController
{
    public $modelClass = 'app\models\Department';

    public static function allowedDomains()
    {
        return [
            // '*',                        // star allows all domains
            'http://localhost:8080',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [

            // For cross-domain AJAX request
            'corsFilter'  => [
                'class' => \yii\filters\Cors::className(),
                'cors'  => [
                    // restrict access to domains:
                    'Origin'                           => static::allowedDomains(),
                    'Access-Control-Request-Method'    => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Allow-Origin' => true,
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
                ],
            ],

        ]);
    }

    public function beforeAction($action)
    {
        \Yii::$app->response->headers->add('Access-Control-Allow-Headers', 'Authorization,DNT,Keep-Alive,User-Agent,X-CustomHeader,X-Requested-With,If-Modified-Since,Cache-Control,Range,Content-Type');
        return parent::beforeAction($action);
    }

}