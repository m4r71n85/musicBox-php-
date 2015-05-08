<?php

class AccountController extends BaseController{
    private $db;
    public function onInit() {
        $this->db = new AccountModel();
    }
    public function register(){
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
            
            $isRegistered = $this->db->register($username, $password);
            if($isRegistered){
                $this->redirect("books", "index");
                $this->addInfoMessage("Registration successful");
            } else {
                $this->addErrorMessage("Register failed");
            }
        }
        
        $this->renderView(__FUNCTION__);
    }
    
    public function login() {
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
            $isLoggedIn = $this->db->login($username, $password);
            if($isLoggedIn){
                $this->addInfoMessage("Login successful!");
                $this->redirect("books", "index");
            }
            else {
                $this->addErrorMessage("Login error!");
                $this->redirect("account", "login");
            }
        }
        
        $this->renderView(__FUNCTION__);
    }
    
    public function logout() {
        
    }
    
    
}