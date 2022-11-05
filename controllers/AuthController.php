<?php

namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

class AuthController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function () {
                    return $this->redirect('/');
                },
                'rules' => [
                    // [
                    //     'allow' => true,
                    //     'roles' => ['@']
                    // ]
                    [
                        'actions' => ['index', 'view', 'accept', 'fail'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['create', 'owner', 'submit', 'complete', 'cancelt', 'cancelr'],
                        'allow' => true,
                        'roles' => ['@'],
                        //'matchCallback' => fn () => !Yii::$app->user->identity->is_executor,
                    ]
                ]
            ]
        ];
    }
}