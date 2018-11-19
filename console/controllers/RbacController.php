<?php

namespace console\controllers;


use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit() {
        $auth = \Yii::$app->authManager;
        
        $accessAdmin = $auth->createPermission('accessAdmin');
        $auth->add($accessAdmin);
        
        $createTask = $auth->createPermission('createTask');
        $auth->add($createTask);
        
        $updateTask = $auth->createPermission('updateTask');
        $auth->add($updateTask);
        
        $deleteTask = $auth->createPermission('deleteTask');
        $auth->add($deleteTask);
        
        $auth->addChild($accessAdmin, $createTask);
        $auth->addChild($accessAdmin, $updateTask);
        $auth->addChild($accessAdmin, $deleteTask);
       
        
        $productManager = $auth->createRole('productManager');
        $auth->add($productManager);
        $auth->addChild($productManager, $createTask);
        
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $accessAdmin);
        $auth->addChild($admin, $productManager);
        
        $auth->assign($admin, 1);
        $auth->assign($productManager, 2);
    }
}