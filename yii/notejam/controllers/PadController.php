<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Pad;

class PadController extends Controller
{
    public $layout = 'app';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['get', 'post'],
                    'edit' => ['get', 'post'],
                    'delete' => ['get', 'post'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $pad = new Pad();

        if ($pad->load(Yii::$app->request->post()) && $pad->validate()) {
            Yii::$app->user->identity->link('pads', $pad);
            Yii::$app->session->setFlash(
                'success', 'Pad is successfully created.'
            );
            return $this->redirect('note/list');
        }
        return $this->render('create', [
            'model' => $pad,
        ]);
    }

    public function actionEdit()
    {
        $pad = $this->getPad(Yii::$app->request->get('id'));

        if ($pad->load(Yii::$app->request->post()) && $pad->validate()) {
            $pad->save();
            Yii::$app->session->setFlash(
                'success', 'Pad is successfully updated.'
            );
            return $this->redirect('note/list');
        }
        return $this->render('edit', [
            'model' => $pad,
        ]);
    }

    public function actionDelete()
    {
        $pad = $this->getPad(Yii::$app->request->get('id'));

        if (Yii::$app->request->getIsPost()) {
            $pad->delete();
            Yii::$app->session->setFlash(
                'success', 'Pad is successfully deleted.'
            );
            return $this->redirect('note/list');
        }
        return $this->render('delete', [
            'model' => $pad,
        ]);
    }

    /**
     * Get pad or raise 404
     *
     * @return app\models\Pad
     */
    private function getPad($id)
    {
        $user = Yii::$app->user->identity;
        $pad = $user->getPads()->where(['id' => $id])->one();
        if (!$pad) {
            throw new \yii\web\HttpException(404, 'Not Found');
        }
        return $pad;
    }
}


