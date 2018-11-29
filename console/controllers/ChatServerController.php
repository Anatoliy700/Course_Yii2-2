<?php

namespace console\controllers;


use frontend\components\chat\ChatSocket;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use yii\console\Controller;

class ChatServerController extends Controller
{
    public function actionStart() {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new ChatSocket()
                )
            ),
            8080
        );
        \Yii::$app->db->createCommand('SET SESSION wait_timeout = 28800;')->execute();
        echo 'Star server' . PHP_EOL;
        $server->run();
        echo 'Stop server' . PHP_EOL;
    }
}