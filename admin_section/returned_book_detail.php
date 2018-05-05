<?php
require_once 'library/admin_system_files.php';
$book_id = $admin->gets('book_id');
$issue_type = $admin->gets('issue_type');
$student_id = $admin->gets('student_id');
$book = new booksRecords();
$row = $book->get_book_record_row( $book_id );
$book_detail = $book->get_renewal_book_detail( $book_id, $student_id, $issue_type );
$stdrow = $book->student->get_student_records_row( $student_id );

?>
<!DOCTYPE HTML>
<html>
<head>
<title><?php echo SYSTEM_TITLE; ?></title>
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_LINK; ?>style_file.css" />
<script type="text/javascript" src="<?php echo ADMIN_LINK; ?>js_files/common_functions.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo SYSTEM_LINK; ?>main_site_style.css" />
</head>
<body>
    <div class="main_block">
        <?php require_once('main_topheader.php'); ?>
        
        <div class="body_content">
            <div class="page_mgmt">
                <div class="page_left_col">
                    <?php echo page_left_menu(); /// common_function.php file ?>
                </div>
                <div class="page_right_col"> 
           <form name="book_req_form" method="post" action="<?php echo ADMIN_LINK; ?>issue_book_submit.php">
            <div class="form_block">
                <h1 class="main_heading">Book Detail</h1><br><br>
                <div>
                    <div class="form_row">
                        <div class="form_label">Book Category :</div>
                        <div class="form_field">
                            <?php echo $book->get_book_category_name($row['category_id']); ?>
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
                        <div class="form_field">
                            <b><?php echo ( $book_detail['fine_amount'] > 0 ? 'Rs. '.$book_detail['fine_amount'] : 'Not any Fine Apply' ); ?></b>
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
        <?php require_once('main_bottom_footer.php'); ?>
    </div>
</body>
</html>