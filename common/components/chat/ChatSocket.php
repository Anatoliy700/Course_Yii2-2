<?php

namespace common\components\chat;


use common\models\tables\ChatMessages;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class ChatSocket implements MessageComponentInterface
{
    protected $clients = [];
    
    public function onOpen(ConnectionInterface $conn) {
        echo "New connection: ({$conn->resourceId})" . PHP_EOL;
        $this->clients[$this->getRoomId($conn)][] = $conn;
    }
    
    public function onClose(ConnectionInterface $conn) {
        echo "Close connection: ({$conn->resourceId})" . PHP_EOL;
    }
    
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo $e->getMessage() . PHP_EOL;
        
    }
    
    public function onMessage(ConnectionInterface $from, $msg) {
        echo 'message' . PHP_EOL;
        $model = new ChatMessages();
        parse_str($msg, $data);
        
        if ($model->load($data) && $model->save()) {
            $data['created'] = date('Y-m-d H-i-s');
            $message = json_encode($data);
            $this->sendMessage($from, $message);
        }
    }
    
    protected function getRoomId($conn) {
        return $conn->httpRequest->getUri()->getQuery();
    }
    
    protected function sendMessage(ConnectionInterface $conn, $msg) {
        foreach ($this->clients[$this->getRoomId($conn)] as $client) {
            $client->send($msg);
        }
    }
    
}