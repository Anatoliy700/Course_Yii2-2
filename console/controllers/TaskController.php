<?php

namespace console\controllers;


use common\models\tables\Users;
use yii\console\Controller;
use yii\db\ActiveQuery;
use yii\helpers\Console;

class TaskController extends Controller
{
    public function actionDeadline($pause = 1) {
        $users = Users::find()
            ->joinWith([
                'tasks' => function ($query) {
                    /* @var $query ActiveQuery */
                    $query->andWhere(['and', 'tasks.date > now()', 'tasks.date < adddate(now(), INTERVAL 1 DAY)']);
                }
            ])
            ->all();
        
        Console::startProgress(1, count($users));
        $i = 1;
        foreach ($users as $user) {
            \Yii::$app->mailer
                ->compose('task/deadline', ['user' => $user])
                ->setFrom([\Yii::$app->params['adminEmail'] => 'Admin'])
                ->setTo($user->email)
                ->setSubject('Задачи на завтра')
                ->send();
            
            Console::updateProgress($i++, count($users));
            sleep($pause);
        }
        Console::endProgress(0);
    }
}