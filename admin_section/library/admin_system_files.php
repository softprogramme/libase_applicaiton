<?php
ob_start();
session_start();

error_reporting(1); /// turn off all types of errors

require_once 'common_function.php';
require_once 'library/constants.php';
require_once 'library/db_connection.php';
require_once 'library/common_lib.php';
require_once 'library/admin_user_lib.php';
require_once 'library/manage_category_records.php';
require_once 'library/manage_books_records.php';
require_once 'library/manage_register_students.php';
require_once 'library/manage_book_reports.php';

$admin = new adminUser();