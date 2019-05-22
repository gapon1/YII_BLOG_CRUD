<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\SingupForm;
use app\models\User;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('/auth/login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionSingup()
    {
        $model = new SingupForm();

        if (Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post());

            if ($model->singup()){
                return $this->redirect('auth/login');

            }
        }

        return $this->render('singup', [
            'model'=> $model
        ]);

    }

    public function actionTest()
    {
        $user = User::findOne(1);

        Yii::$app->user->logout();

        if(Yii::$app->user->isGuest)
        {
            echo 'Пользователь гость';
        }
        else
        {
            echo 'Пользователь Авторизован';
        }
    }
}