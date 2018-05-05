<?php
require_once 'library/admin_system_files.php';
$std = new manageRgisterStudents();   /// rs: register studenst class object
$student_id = $std->gets('student_id');
$stdrow = $std->get_student_records_row( $student_id );

?>
<!DOCTYPE HTML>
<html>
<head>
<title><?php echo SYSTEM_TITLE; ?></title>
<link type="text/css" rel="stylesheet" href="<?php echo SYSTEM_LINK; ?>admin_section/style_file.css" />
<script type="text/javascript" src="<?php echo SYSTEM_LINK; ?>admin_section/js_files/common_functions.js"></script>
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
            <div class="form_block">
                <h1 class="main_heading">Registered Student Profile</h1>          
                <div id="return_msg"></div><br>
            <?php
                if( isset($_GET['msg']) && !empty($_GET['msg']) ) {
                    echo '<div class="success_msg">'.$_GET['msg'].'</div><br>';
                }
            ?>
                <div class="books_block">
                    <div class="form_row">
                        <div class="form_label">Full Name :</div>
                        <div class="form_field">
                            <?php echo $stdrow['full_name']; ?>
                        </div>
                        <div class="clear"></div>
                    </div>                        
                    <div class="form_row">
                        <div class="form_label">Registration # :</div>
                        <div class="form_field">
                            <?php echo check_value($stdrow['registration_number'], 'NA'); ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Contact Number :</div>
                        <div class="form_field">
                            <?php echo check_value($stdrow['registration_number'], 'NA'); ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Email Address :</div>
                        <div class="form_field">
                            <?php echo check_value($stdrow['email_address'], 'NA'); ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Login Password :</div>
                        <div class="form_field">
                            <?php echo check_value($stdrow['login_password'], 'NA'); ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">City :</div>
                        <div class="form_field">
                            <?php echo check_value($stdrow['city'], 'NA'); ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Zip Code <span class="required">*</span> :</div>
                        <div class="form_field"><?php echo check_value($stdrow['zip_code'], 'NA'); ?></div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Country</div>
                        <div class="form_field">
                            <?php echo check_value($stdrow['country'], 'NA'); ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Full Address <span class="required">*</span> :</div>
                        <div class="form_field">
                            <?php echo check_value($stdrow['full_address'], 'NA'); ?>
                        </div>
                        <div class="clear"></div>
                    </div><br><br>
                </div>
            </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php require_once('main_bottom_footer.php'); ?>
    </div>
</body>
</html>