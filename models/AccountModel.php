<?php

class AccountModel extends BaseModel{
    
    public function register($username, $password){
        $statement = self::$db->prepare("SELECT COUNT(id) as userExists FROM Users WHERE username = ?");
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();
        if($result['userExists']){
            return false;
        }
        
        $hash_pass = password_hash($password, PASSWORD_BCRYPT);
        $registerStatement = self::$db->prepare("INSERT INTO Users (username, pass_hash) VALUES (?, ?)");
        
        $registerStatement->bind_param("ss", $username, $hash_pass);
        $registerStatement->execute();
        
        $this->login($username, $password);
    }
    
    public function login($username, $password) {
        $statement = self::$db->prepare("SELECT id, username, pass_hash FROM Users WHERE username = ?");
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement->get_result()->fetch_assoc();
        
        if(password_verify($password, $result['pass_hash'] )){
            unset($result['pass_hash']);
            return $result;
        }
        
        return false;
    }
}