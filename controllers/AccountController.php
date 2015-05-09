<?php

class AccountController extends BaseController{
    private $db;
    public function onInit() {
        $this->db = new AccountModel();
    }
    public function register(){
        $this->anonymous();
        if($this->isPost){
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            if(strlen($username==null || strlen($username)<3)){
                $this->addErrorMessage("Username is invalid.");
                $this->renderView(__FUNCTION__);
                return;
            }
            if(strlen($password==null || strlen($password)<3)){
                $this->addErrorMessage("Password is invalid.");
                $this->renderView(__FUNCTION__);
                return;
            }
            
            $success = $this->db->register($username, $password);
            if($success){
                $userDetails = $this->db->login($username, $password);
                parent::loginUser($userDetails);
                $this->addInfoMessage("Registration and login successful");
                $this->redirect("songs", "index");
            } else {
                $this->addErrorMessage("Registration failed");
            }
        }
        
        $this->renderView(__FUNCTION__);
    }
    
    public function login() {
        $this->anonymous();
        if($this->isPost){
            $username = $_POST['username'];
            $password = $_POST['password'];
        
            if(strlen($username==null || strlen($username)<3)){
                $this->addErrorMessage("Username is invalid.");
                $this->renderView(__FUNCTION__);
                return;
            }
            if(strlen($password==null || strlen($password)<3)){
                $this->addErrorMessage("Password is invalid.");
                $this->renderView(__FUNCTION__);
                return;
            }
            $userDetails = $this->db->login($username, $password);
            if($userDetails){
                parent::loginUser($userDetails);
                $this->addInfoMessage("Login successful!");
                $this->redirect("songs");
            }
            else {
                $this->addErrorMessage("Login error!");
                $this->redirect("account", "login");
            }
        }
        
        $this->renderView(__FUNCTION__);
    }
    
    public function logout() {
        $this->authorized();
        parent::logoutUser();
        $this->addInfoMessage("Good bye!");
        $this->redirect("home");
    }
    
    
}