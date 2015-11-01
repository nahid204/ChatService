<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of chat_service_db
 *
 * @author rajin
 */
class ChatServiceDB {
    //put your code here
    private $host ="localhost";
    private $port = 3306;
    private $db ="chat_service";
    private $user = "root";
    private $password = "rajin";
    
    private $mysqli;
    function __construct() {
       $this->mysqli = $mysqli = new mysqli($this->host, $this->user,$this->password, $this->db, $this->port);
   }

   function __destruct() {
       
   }
   
   public function getUserInfo($id)
   {
       $stmt = $this->mysqli
               ->prepare(" SELECT user_id, email, first_name, last_name FROM user WHERE user_id=(?)");
       $stmt->bind_param('i', $id);
       $stmt->execute();
       
       $result = $stmt->get_result();
       $row = $result->fetch_assoc();
       $stmt->close();
       return $row;
   }
   
   public function getUserInfoJSON($id)
   {
       $data = $this->getUserInfo($id);
       return json_encode($data);
   }

      public function getUserId($email, $password)
   {
       $stmt = $this->mysqli
               ->prepare(" SELECT user_id FROM user WHERE email =(?) AND user_password=(?)");
       $stmt->bind_param('ss', $email, $password);
       $stmt->execute();
       
       $result = $stmt->get_result();
       $row = $result->fetch_assoc();
       $stmt->close();
       return $row['user_id'];
   }

   public function getAllUsers($excluding_user_id)
   {
       $stmt = $this->mysqli
               ->prepare(" SELECT user_id, email, first_name, last_name FROM user WHERE user_id <>(?)");
       $stmt->bind_param('i', $excluding_user_id);
       $stmt->execute();
       
       $result = $stmt->get_result();
       $row = $result->fetch_assoc();
       
       $result_array = array();
       while($row)
       {
           array_push($result_array, $row);
           $row = $result->fetch_assoc();
       }
       
       $stmt->close();
       
       
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
       $stmt = $this->mysqli
               ->prepare(" SELECT message_id, sender_id AS sender_user_id"
                       . ", message, epoch  FROM message "
                       . "WHERE (sender_id = (?) AND receiver_id =(?)) "
                       . "OR (sender_id = (?) AND receiver_id =(?)) "
                       . "ORDER BY epoch ASC;");
       $stmt->bind_param('iiii', $user_id_a, $user_id_b, $user_id_b, $user_id_a);
       $stmt->execute();
       
       $result = $stmt->get_result();
       $row = $result->fetch_assoc();
       
       $result_array = array();
       while($row)
       {
           array_push($result_array, $row);
           $row = $result->fetch_assoc();
       }
       
       $stmt->close();
       
       
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
       $stmt = $this->mysqli
               ->prepare("INSERT INTO user(email, user_password, first_name, last_name) "
                       . "VALUES ((?), (?), (?) ,(?));");
       $stmt->bind_param('ssss', $email, $password, $first_name, $last_name);
       
       $status = $stmt->execute();
       $insert_id = $this->mysqli->insert_id;
       $stmt->close();
               
       return $insert_id;
   }
   
   public function sendMessage($sender_id, $receiver_id, $message) {
       $stmt = $this->mysqli
               ->prepare("INSERT INTO message(epoch, sender_id, receiver_id, message) "
                       . "VALUES (UNIX_TIMESTAMP(), (?), (?) ,(?));");
       $stmt->bind_param('iis', $sender_id, $receiver_id, $message);
       
       $status = $stmt->execute();
       $insert_id = $this->mysqli->insert_id;
       $stmt->close();
       
       return $insert_id;
   }
}



?>