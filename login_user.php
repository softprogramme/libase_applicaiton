<?php
require_once 'user_library/user_system_files.php';
$mb = new manageBooks();  //// mb: managed books
$book_id = $admin->gets('book_id');

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
                        <?php echo $mb->view_category_list(); /// common_function.php file ?>
                    </ul>                    
                </div>
                <div class="page_right_col">  
            <div class="form_block">
                <h1 class="main_heading">Login Student</h1>          
                <div id="return_msg"></div><br>
            <?php
                if( isset($_GET['msg']) && !empty($_GET['msg']) ) {
                    echo '<div class="error_msg1">'.$_GET['msg'].'</div>';
                }
            ?>
                <div class="books_block">
                    <form method="post" name="login_form" action="login_verify.php">
                    <div class="form_row">
                        <div class="form_label">Email <span class="required">*</span> :</div>
                        <div class="form_field">
                            <input type="email" name="login_email" required="" />
                        </div>
                        <div class="clear"></div>
                    </div>                        
                    <div class="form_row">
                        <div class="form_label">Password <span class="required">*</span> :</div>
                        <div class="form_field">
                            <input type="password" name="login_pass" required="" />
                            <input type="hidden" name="book_id" value="<?php echo $book_id; ?>" />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">&nbsp;</div>
                        <div class="form_field">
                            <input type="submit" name="btn_submit" value="Login" />
                        </div>
                        <div class="clear"></div><br>
                    </div>
                </form>
                </div>
            </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php require_once('admin_section/main_bottom_footer.php'); ?>
    </div>
</body>
</html>