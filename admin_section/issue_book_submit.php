<?php
require_once 'library/admin_system_files.php';
error_reporting(1);


$book = new booksRecords();

$book_status = $book->posts('book_status');

if( !empty($book_status) && $book_status == 'RN' ) {
    $book_req = $book->renew_book_request();
} else {
    $book_req = $book->add_book_request();
}

header('Location:book_request_issued_mgmt.php?msg='.$book_req); exit;
