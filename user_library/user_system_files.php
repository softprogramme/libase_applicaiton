<?php
ob_start();
session_start();

error_reporting(1); /// turn off all types of errors

//// backend admin library files
require_once 'admin_section/common_function.php';
require_once 'admin_section/library/constants.php';
require_once 'admin_section/library/db_connection.php';
require_once 'admin_section/library/common_lib.php';
require_once 'admin_section/library/admin_user_lib.php';
require_once 'admin_section/library/manage_register_students.php';
require_once 'admin_section/library/manage_category_records.php';
require_once 'admin_section/library/manage_books_records.php';

/// front end user library
require_once 'manage_books_section.php';
require_once 'manage_student_records.php';
require_once 'common_function_lib.php';
///

$admin = new adminUser();