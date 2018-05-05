<?php

class manageStudent extends commonLib {
    
    function __construct() {
        parent::__construct();
    }
    
    function student_records_submit($edit_id=0) {
        $full_name    = $this->posts('full_name');
        $register_no  = $this->posts('register_no');
        $contact_no   = $this->posts('contact_no');
        $email_address = $this->posts('email_address');
        $login_pass   = $this->posts('login_pass');
        $city_name    = $this->posts('city_name');
        $zip_code     = $this->posts('zip_code');
        $country_name = $this->posts('country_name');
        $full_address = $this->posts('full_address');
        $toDate       = date('Y-m-d');
        
        ///// check already register student
        $sql = $this->query_exe("SELECT * FROM `tbl_student` WHERE email_address = '{$email_address}' OR registration_number = '{$register_no}' ORDER BY id DESC LIMIT 1");
        $row = mysqli_fetch_assoc( $sql );
        
        $submit_status = '';
        
        if( $edit_id == 0 ) {
            if( !empty($row['full_name']) ) {
                header('Location:login_user.php?msg=This email address or registration number has already registered here!'); exit;
            }
        
            $submit_status = 'add';
            $sql = "INSERT INTO `tbl_student` (`full_name`, `contact_number`, `email_address`, `city`, `country`, `zip_code`, `full_address`, `registration_number`, `login_password`, `add_date`) VALUES ('{$full_name}', '{$contact_no}', '{$email_address}', '{$city_name}', '{$country_name}', '{$zip_code}', '{$full_address}', '{$register_no}', '{$login_pass}', '{$toDate}')";
            $this->query_exe($sql);
            $student_id = $this->conn->insert_id;
            
            $_SESSION['student_id'] = $student_id;
            $_SESSION['student_full_name'] = $full_name;
            
            
        } else {
            $submit_status = 'edit';
            $sql = "UPDATE `tbl_student` SET `full_name` = '{$full_name}', `contact_number` = '{$contact_no}', `email_address` = '{$email_address}', `city` = '{$city_name}', `country` = '{$country_name}', `zip_code` = '{$zip_code}', `full_address` = '{$full_address}', `registration_number` = '{$register_no}', `login_password` = '{$login_pass}' WHERE `id` = '{$edit_id}'";
            $this->query_exe($sql);
        }
        
        return $submit_status;
    }
    
    function verify_student_login() {
        $login_email = $this->posts('login_email');
        $login_pass  = $this->posts('login_pass');
        $book_id  = $_REQUEST['book_id'];
        
        $sql = $this->query_exe("SELECT * FROM `tbl_student` WHERE email_address = '{$login_email}' AND login_password = '{$login_pass}' ORDER BY id DESC LIMIT 1");
        $row = mysqli_fetch_assoc( $sql );
        
         if( !empty($row['full_name']) ) {
            $_SESSION['student_id']        = $row['id'];
            $_SESSION['student_full_name'] = $row['full_name'];
            
            if( !empty($book_id) ) {
                header('Location:view_user_book_details.php/?book_id='.$book_id.'&req_sent=sent'); exit;
            } else {
                header('Location:manage_student_account.php?msg='); exit;
            }              
         } else {
              header('Location:login_user.php?book_id='.$book_id.'&msg=Plz enterd the correct login Email or password!'); exit;
         }
    }
    
    function check_login_session() {
        if( empty($_SESSION['student_id']) ) {
            header('Location:login_user.php?msg=Plz login to view this page!'); exit;
        }
    }
    
    
    //// select single student row from db
    function get_student_record_row() {
        $sql = $this->query_exe("SELECT * FROM `tbl_student` WHERE id = '{$_SESSION['student_id']}' ORDER BY id DESC LIMIT 1");
        $row = mysqli_fetch_assoc( $sql );
        
        return $row;
    }
}