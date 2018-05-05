<?php
require_once 'library/admin_system_files.php';

$txt_file_id = $admin->posts('txt_file_id');

if( !empty($txt_file_id) ) {
    $admin->file_records_submit( $txt_file_id );    //// submit form to save user info into db
    header('Location:received_file_records.php?mesg=File Record has updated successfully!');
} else {
    $admin->file_records_submit( 0 );    //// submit form to save user info into db
    header('Location:add_file_records.php?msg=File Record has saved successfully!');
}