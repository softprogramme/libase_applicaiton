<?php

class adminUser extends commonLib {
    public $return_mesg = '';
    public $home_page_file = '';
    
    function __construct() {
        parent::__construct();
    }
    
    function login_verify_section() {
        $user = $this->posts('login_username');
        $pass = $this->posts('login_password');
        $cmb_type = $this->posts('cmb_type');
        
        if( $cmb_type === 'AD' ) {
            $table_name = 'admin_users';
            $column_id  = 'user_id';
            $this->home_page_file = 'admin_home.php';
        } else {
            $table_name = 'userdetails';
            $column_id  = 'user_id';
            $this->home_page_file = 'user_home_page.php';
        }
        
        $query = "SELECT * FROM $table_name WHERE user_name = '{$user}' AND login_password = '{$pass}' ORDER BY user_id DESC LIMIT 1"; //echo $query; exit;
        
        $sql = $this->query_exe($query);
        $row = mysqli_fetch_assoc( $sql );
        
        if( count($row) > 0 ) {
            $_SESSION['login_id']        = $row[$column_id];
            $_SESSION['login_full_name'] = $row['name'];
            $this->return_mesg = '';
            
        } else {
            $_SESSION['login_id']        = '';
            $_SESSION['login_full_name'] = '';
            $this->return_mesg = 'Plz Enter the Correct Username / Password';
        }
        
    }
}