<?php
require_once 'user_library/user_system_files.php';
$mb = new manageBooks();

$book_id = $admin->gets('book_id');
$issue_type = $admin->gets('issue_type');
$student_id = $admin->gets('student_id');
$request_book_id = $admin->posts('request_book_id');

$row = $mb->bookrecords->get_book_record_row( $book_id );
$book_detail = $mb->bookrecords->get_renewal_book_detail( $book_id, $student_id, $issue_type );
$std = new manageStudent();  //// mb: managed books
$stdrow = $std->get_student_record_row();

$fine_amount = $book_detail['fine_amount'];

if( isset($request_book_id) && !empty($request_book_id) ) {
    $return_msg = $mb->bookrecords->update_student_fine_amount( $request_book_id, 'paid' );
}

?>
<!DOCTYPE HTML>
<html>
<head>
<title><?php echo SYSTEM_TITLE; ?></title>
<link type="text/css" rel="stylesheet" href="admin_section/style_file.css" />
<link type="text/css" rel="stylesheet" href="main_site_style.css" />
<script type="text/javascript" src="admin_section/js_files/common_functions.js"></script>
</head>
<body>
    <div class="main_block">
        <div class="main_header"><?php echo SYSTEM_TITLE; ?></div>
        <div class="main_menu">
            <ul><?php echo main_header_menu();  /// function in common_function_lib.php file ?></ul>
        </div>
        
        <div class="body_content">
            <div class="page_mgmt">
                <div class="page_left_col">
                    <ul class="left_menu_settings">
                        <?php echo student_left_menu();  /// function in common_function_lib.php file ?>
                    </ul>                    
                </div>
                <div class="page_right_col"> 
           <form name="book_fine_form" method="post" action="">
            <div class="form_block">
                <h1 class="main_heading">Book Detail</h1><br><br>
                <?php
                    if( isset($return_msg) && !empty($return_msg) ) {
                        echo '<div class="success_msg">Your fine has paid successfully!</div><br>';
                    }
                ?>
                <div>
                    <div class="form_row">
                        <div class="form_label">Book Category :</div>
                        <div class="form_field">
                            <?php echo $mb->bookrecords->get_book_category_name($row['category_id']); ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Book Code :</div>
                        <div class="form_field">
                            <?php echo $row['book_code']; ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Book Title :</div>
                        <div class="form_field">
                            <?php echo $row['book_code'] . ' - ' . $row['book_title']; ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Student Name :</div>
                        <div class="form_field">
                            <?php echo check_value($stdrow['full_name'], 'NA'); ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Student Reg. # :</div>
                        <div class="form_field">
                            <?php echo check_value($stdrow['registration_number'], 'NA'); ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Old Issue Date :</div>
                        <div class="form_field">
                            <?php echo $book_detail['issued_date']; ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Returned Date :</div>
                        <div class="form_field red_msg">
                            <?php echo $book_detail['returned_date']; ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Old Due Date :</div>
                        <div class="form_field red_msg">
                            <?php echo $book_detail['due_date']; ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Renew Request Date :</div>
                        <div class="form_field">
                            <?php echo $book_detail['renewal_req_date']; ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Renew Date :</div>
                        <div class="form_field">
                            <?php echo $book_detail['renewal_date']; ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Renew Due Date :</div>
                        <div class="form_field">
                            <?php echo $book_detail['renewal_due_date']; ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Renew Return Date :</div>
                        <div class="form_field">
                            <?php echo $book_detail['renewal_return_date']; ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Book Status :</div>
                        <div class="form_field">
                            <b><?php echo set_book_issue_status($book_detail['book_status']); ?></b>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Fine Amount :</div>
                        <div class="form_field red_msg">
                            Rs. <?php echo $fine_amount; ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label"></div>
                        <div class="form_field">
                            <?php if( !empty($book_detail['fine_paid']) || !empty($return_msg) ) { ?>
                            <b class="success_msg2">Fine has paid!</b>
                            <?php } else { ?>
                            <input type="submit" name="btn_submit" value="Paid Rs. <?php echo $fine_amount; ?> Fine">
                            <?php } ?>
                            <input type="hidden" name="request_book_id" value="<?php echo $book_detail['id']; ?>" />
                            <input type="hidden" name="set_fine_amount" value="<?php echo $fine_amount; ?>" required="" />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <br><br>
                  </div>
                <br>
            </div>
               </form>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php require_once('admin_section/main_bottom_footer.php'); ?>
    </div>
</body>
</html>