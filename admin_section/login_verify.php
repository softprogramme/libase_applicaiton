<?php
require_once 'library/admin_system_files.php';

$admin->login_verify_section();

$mesg = $admin->return_mesg;

if( empty($mesg) ) {
    header('Location:' . $admin->home_page_file);
} else {
    header('Location:login_page.php?msg='.$mesg);
}