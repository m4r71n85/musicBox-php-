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
        $statement = self::$db->prepare("INSERT INTO Users (username, pass_hash) VALUES (?, ?)");
        
        $statement->bind_param("ss", $username, $hash_pass);
        $statement->execute();
        return $statement->affected_rows > 0;
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