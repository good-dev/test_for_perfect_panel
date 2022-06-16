<?php

namespace app\controllers;

use app\models\Currency;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

class ApiController extends Controller
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [

            [
                'class' => \yii\filters\ContentNegotiator::class,
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ]
            ],
            
            'authenticator' => [
                'class' => HttpBearerAuth::class,
            ],

        ]);
    }

    public function actionError()
    {
        return [
            'status' => 'error',
            'code' => 403,
            'message' => 'Forbiden',
        ];
    }

    /**
     * API version 1
     */
    public function actionV1()
    {
        $request = \Yii::$app->request;

        // Rates
        if ($request->isGet && $request->get('method') == 'rates') {

            $rates = Currency::getRates($request->get('currency'));

            return $rates;

        }

        // Convert
        else if (

            $request->isPost &&
            $request->get('method') == 'convert' &&
            !is_null($request->post('currency_from')) &&
            !is_null($request->post('currency_to')) &&
            !is_null($request->post('value'))

        ) {

            $result = Currency::convertValue(
                $request->post('currency_from'),
                $request->post('currency_to'),
                (float)$request->post('value')
            );

            if($result===false) throw new \yii\web\BadRequestHttpException;

            return $result;

        } else {

            throw new \yii\web\MethodNotAllowedHttpException;

        }
    }
}
