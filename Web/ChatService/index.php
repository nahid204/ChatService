<?php
include 'util.php';
include 'chat_service_db.php';
//$data ='{ 
//    "email":"info@apppartner.com", 
//    "password":"qwerty", 
//    "first_name":"John", 
//    "last_name":"Doe" 
//}';
//$json = JSONUtil::getArray($data);
//
//print_r($json);
//
//echo "\n";
//
//JSONUtil::printLastJSONStatus();


//header('Content-Type: application/json');
//$error = Error::getErrorJSON(101, "TrickorTreat", "Dafuq");
//print $error;

$db = new ChatServiceDB();
$id =$db->getUserId('info@apppartner.com', 'qwerty');
print 'user id '. $id;
$user  = $db->getUserInfoJSON(2);

print $user;


?> 
