<?php
require_once 'user_library/user_system_files.php';
error_reporting(1);

$student_id = $admin->posts('student_id');

$std = new manageStudent();


if( !empty($student_id) ) {
    $std->student_records_submit( $student_id );    //// submit form to edit student record in db
    header('Location:edit_student_profile.php?msg=Student Profile has updated successfully!');
} else {
    $std->student_records_submit( 0 );    //// submit form to add student records in db
    header('Location:manage_student_account.php?msg=Welcome To E - Library Management System!');
}
