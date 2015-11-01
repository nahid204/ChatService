<?php

include 'util.php';
include 'chat_service_db.php';
header('Content-Type: application/json');

//$entityBody = file_get_contents('php://input');


//$entityBody='{ 
//     "user_id_a": "1", 
//     "user_id_b": "2" 
//}';

//$requester = JSONUtil::getArray($entityBody);
$requester = $_GET;
$db = new ChatServiceDB();
$data = $db->getAllMessagesJSON($requester['user_id_a'], $requester['user_id_b']);
if($data != null)
{
    echo $data;
}
else {
    echo Error::getDataBaseError();
}
?>