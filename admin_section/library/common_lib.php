<?php

class commonLib extends dbConnect {
        
    function __construct() {
        parent::__construct();
        
        //$this->check_login();
    }
    
    function posts($field_name='') {
        return $_POST[$field_name];
    }
    
    function gets($field_name='') {
        $getField = ( isset($_GET[$field_name]) ? $_GET[$field_name] : '' );
  
        return $getField;
    }
    
    function optSelected($opt1='', $opt2='') {
        $selcted = ( $opt1 == $opt2 ? 'selected' : '' );
  
        return $selcted;
    }
    
    function check_login() {
        $page_name = explode('/', $_SERVER['PHP_SELF']);
        
        if( empty($_SESSION['login_id']) && $page_name[2] != 'login_page.php' ) {
            header('Location:login_page.php');
        }
    }
    
    function check_value($field='', $empty_value='NA') {
        if( !empty($field) ) {
            return $field;
        } else {
            return $empty_value;
        }
    }
}