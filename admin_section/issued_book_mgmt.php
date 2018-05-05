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
                <h1 class="main_heading">Issue of Book Detail</h1><br><br>
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
                    <?php if( $issue_type === 'RN' ) { ?>
                    <div class="form_row">
                        <div class="form_label">Old Issue Date :</div>
                        <div class="form_field">
                            <input type="text" name="issued_date" value="<?php echo $book_detail['issued_date']; ?>" readonly="" />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Returned Date :</div>
                        <div class="form_field">
                            <input type="text" name="return_date" value="<?php echo $book_detail['returned_date']; ?>" readonly="" />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Old Due Date :</div>
                        <div class="form_field">
                            <input type="text" name="return_date" value="<?php echo $book_detail['due_date']; ?>" readonly="" />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Renew Date :</div>
                        <div class="form_field">
                            <input type="text" name="renew_date" value="<?php echo date('Y-m-d'); ?>" readonly="" />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Due Date :</div>
                        <div class="form_field">
                            <input type="text" name="rewnew_due_date" value="<?php echo date('Y-m-d', strtotime("+15 days")); ?>" readonly="" />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <?php } else { ?>
                        <div class="form_row">
                            <div class="form_label">Issue Date :</div>
                            <div class="form_field">
                                <input type="text" name="issued_date" value="<?php echo date('Y-m-d'); ?>" readonly="" />
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="form_row">
                            <div class="form_label">Due Date :</div>
                            <div class="form_field">
                                <input type="text" name="return_date" value="<?php echo date('Y-m-d', strtotime("+15 days")); ?>" readonly="" />
                            </div>
                            <div class="clear"></div>
                        </div>
                    <?php } ?>
                    <div class="form_row">
                        <div class="form_label">Book Status :</div>
                        <div class="form_field">
                            <b>Available</b>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Status :</div>
                        <div class="form_field">
                            <select name="issue_status" required="">
                                <option value="IS">Issued Book</option>
                                <option value="CL">Cancel</option>
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label"></div>
                        <div class="form_field">
                            <input type="submit" name="btn_submit" value="Submit Request" />
                            <input type="hidden" name="book_id" value="<?php echo $book_id; ?>" />
                            <input type="hidden" name="book_status" value="<?php echo $issue_type; ?>" />
                            <input type="hidden" name="student_id" value="<?php echo $student_id; ?>" />
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