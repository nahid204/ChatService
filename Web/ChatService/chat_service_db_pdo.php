<?php

class ChatServiceDB {
    //put your code here
    private $host ="127.10.48.2";
    private $port = 3306;
    private $db ="chat";
    private $user = "adminJEdbDTW";
    private $password = "RcuaWQFWKnMF";
    
    private $pdo;
    function __construct() {
		$connect_str = 'mysql:host='.$this->host.';dbname='.$this->db.';charset=utf8';
       $this->pdo = new PDO($connect_str, $this->user, $this->password, array(PDO::ATTR_EMULATE_PREPARES => false, 
                                                                                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
   }

   function __destruct() {
       
   }
   
   public function getUserInfo($id)
   {
		$stmt = $this->pdo->prepare("SELECT user_id, email, first_name, last_name FROM user WHERE user_id=:id");
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
       return $row;
   }
   
   public function getUserInfoJSON($id)
   {
       $data = $this->getUserInfo($id);
       return json_encode($data);
   }

      public function getUserId($email, $password)
   {
       $stmt = $this->pdo
               ->prepare(" SELECT user_id FROM user WHERE email =:email AND user_password=:pwd");
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->bindValue(':pwd', $password, PDO::PARAM_STR);
       
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
       return $row['user_id'];
   }

   public function getAllUsers($excluding_user_id)
   {
       $stmt = $this->pdo
               ->prepare(" SELECT user_id, email, first_name, last_name FROM user WHERE user_id <>:id");
       $stmt->bindValue(':id', $excluding_user_id, PDO::PARAM_INT);
       $stmt->execute();
       
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
       
       $result_array = array();
       while($row)
       {
           array_push($result_array, $row);
           $row = $stmt->fetch(PDO::FETCH_ASSOC);
       }
       
       
       
       return $result_array;
   }
   
   public function getAllUsersJSON($excluding_user_id)
   {
       $data = $this->getAllUsers($excluding_user_id);
       
       $array = array("users" => $data);
       $json = json_encode($array);
       return $json;
   }
   
   public function getAllMessages($user_id_a, $user_id_b)
   {
       $stmt = $this->pdo
               ->prepare(" SELECT message_id, sender_id AS sender_user_id"
                       . ", message, epoch  FROM message "
                       . "WHERE (sender_id = :ida AND receiver_id =:idb) "
                       . "OR (sender_id = :idb2 AND receiver_id =:ida2) "
                       . "ORDER BY epoch ASC;");
       $stmt->bindValue(':ida', $user_id_a, PDO::PARAM_STR);
		$stmt->bindValue(':idb', $user_id_b, PDO::PARAM_STR);		
		$stmt->bindValue(':idb2', $user_id_b, PDO::PARAM_STR);
		$stmt->bindValue(':ida2', $user_id_a, PDO::PARAM_STR);
		
       $stmt->execute();
       
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
       
       $result_array = array();
       while($row)
       {
           array_push($result_array, $row);
           $row = $stmt->fetch(PDO::FETCH_ASSOC);
       }
       
       
       
       return $result_array;
   }
   public function getAllMessagesJSON($user_id_a, $user_id_b)
   {
       $data = $this->getAllMessages($user_id_a, $user_id_b);
       
       $array = array("messages" => $data);
       $json = json_encode($array);
       return $json;
   }
   

   public function registerUser($email, $password, $first_name, $last_name) {
       $stmt = $this->pdo
               ->prepare("INSERT INTO user(email, user_password, first_name, last_name) "
                       . "VALUES (:email, :pwd, :first ,:last);");
       $stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->bindValue(':pwd', $password, PDO::PARAM_STR);
		$stmt->bindValue(':first', $first_name, PDO::PARAM_STR);
		$stmt->bindValue(':last', $last_name, PDO::PARAM_STR);
       
       $status = $stmt->execute();
       $insert_id = $this->pdo->lastInsertId();
               
       return $insert_id;
   }
   
   public function sendMessage($sender_id, $receiver_id, $message) {
       $stmt = $this->pdo
               ->prepare("INSERT INTO message(epoch, sender_id, receiver_id, message) "
                       . "VALUES (UNIX_TIMESTAMP(), :sid, :rid ,:msg);");
       $stmt->bindValue(':sid', $sender_id, PDO::PARAM_INT);
		$stmt->bindValue(':rid', $receiver_id, PDO::PARAM_INT);
		$stmt->bindValue(':msg', $message, PDO::PARAM_STR);
       
       $status = $stmt->execute();
       $insert_id = $this->pdo->lastInsertId();
       
       return $insert_id;
   }
   
}



?>