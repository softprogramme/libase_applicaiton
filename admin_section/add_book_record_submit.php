<?php
require_once 'library/admin_system_files.php';
error_reporting(1);

$book_id = $admin->posts('book_id');
$bookID  = $admin->gets('book_id');

$books = new booksRecords();

if( !empty($bookID) ) {
    $ret_msg = $books->delete_book_records( $bookID ); /// delete category records from db
    header('Location:books_management.php?msg='.$ret_msg);
} else {
    if( !empty($book_id) ) {
    $books->book_records_submit( $book_id );    //// submit form to edit book record in db
    header('Location:books_management.php?msg=Book Record has updated successfully!');
} else {
    $books->book_records_submit( 0 );    //// submit form to add book records in db
    header('Location:add_book_management.php?msg=Book Record has saved successfully!');
}
}
