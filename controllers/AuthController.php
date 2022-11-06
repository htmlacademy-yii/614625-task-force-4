<?php

namespace app\controllers;

use Yii;
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
                    [
                        'actions' => ['index', 'view', 'accept', 'fail'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['create', 'submit', 'complete', 'cancelt', 'cancelr'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => fn () => Yii::$app->user->identity->is_customer,
                    ]
                ]
            ]
        ];
    }
}