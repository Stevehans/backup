<?php
<<<<<<< HEAD
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
include '/etc/freepbx.conf';
include __DIR__.'/../Handlers/Status.php';
$server = IoServer::factory(
  new HttpServer(
      new WsServer(
          new FreePBX\modules\Backup\Handlers\Status()
      )
  ),
  9999
  );

$server->run();
=======
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
use Hhxsv5\SSE\SSE;
use Hhxsv5\SSE\Update;
$freepbx = FreePBX::Create();
(new SSE())->start(new Update(function()use($freepbx){
    $msgs = $freepbx->Backup->getAll('monolog');
    $last = $freepbx->Backup->getConfig('lastlog');
    $last = !empty($last)?$last:0;
    $newMsgs = [];
    $lastInArray = key( array_slice($msgs, -1, 1, true ));
    if($last == $lastInArray){
        return json_encode(['final' => true]);
    }
    foreach($msgs as $key => $value){
        if($key > $last){
            $newMsgs[$key] = $value;
            $last = $key;
        }
    }
    $last = $freepbx->Backup->setConfig('lastlog',$last);
    if (!empty($newMsgs)) {
        return json_encode($newMsgs);
    }
    return false;//return false if no new messages
}), 'message');
>>>>>>> development/15.0
