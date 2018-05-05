<?php
require_once 'user_library/user_system_files.php';
error_reporting(1);

$std = new manageStudent();


$std->verify_student_login();   //// if login email and password is correct it student goes to student account pag else on login page
