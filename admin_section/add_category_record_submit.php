<?php
require_once 'library/admin_system_files.php';
error_reporting(1);

$category_id = $admin->posts('category_id');
$categoryID  = $admin->gets('category_id');

$cate = new categoryRecords();

if( !empty($categoryID) ) {
    $ret_msg = $cate->delete_category_records( $categoryID ); /// delete category records from db
    header('Location:category_management.php?msg='.$ret_msg);
} else {
    if( !empty($category_id) ) {
    $cate->category_records_submit( $category_id );    //// submit form to edit category name in db
    header('Location:category_management.php?msg=Category Record has updated successfully!');
} else {
    $cate->category_records_submit( 0 );    //// submit form to add category name in db
    header('Location:category_management.php?msg=Category Record has saved successfully!');
}
}
