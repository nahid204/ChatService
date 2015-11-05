<?php


include 'util.php';
include 'chat_service_db_pdo.php';
header('Content-Type: application/json');
$entityBody = file_get_contents('php://input');

//$entityBody='{ 
//    "sender_user_id": 1, 
//    "receiver_user_id": 2, 
//    "message" : "Example text" 
//}';

$message_info = JSONUtil::getArray($entityBody);

$db = new ChatServiceDB();
$insert_id =$db->sendMessage($message_info['sender_user_id'], $message_info['receiver_user_id'], $message_info['message']);

if($insert_id != NULL)
{
    $response = array("success_code" => 200, "success_title"=> "Message Sent"
        , "success_message"=>"Message was sent successfully");
    $json_response = json_encode($response);
    echo $json_response;
}
else
{
    echo Error::getDataBaseError();
}
?>