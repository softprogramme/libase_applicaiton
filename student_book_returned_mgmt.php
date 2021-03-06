<?php
require_once 'user_library/user_system_files.php';
$mb = new manageBooks();  //// mb: managed books

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Books Issues - <?php echo SYSTEM_TITLE; ?></title>
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
            <div class="form_block">
                <h1 class="main_heading">Returned Books Management</h1>          
                <div id="return_msg"></div><br>
            <?php
                if( isset($_GET['msg']) && !empty($_GET['msg']) ) {
                    echo '<div class="success_msg">'.$_GET['msg'].'</div>';
                }
            ?>
                <div class="books_block">
                    <table class="record_view_table">
                        <tr>
                            <th>Sr#</th>
                            <th>Book Title</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th width="80"><div align="center">Book Cover</div></th>
                            <th width="70"><div align="center">Req. Date</div></th>
                            <th width="70"><div align="center">Status</div></th>
                        </tr>
                        <?php echo $mb->bookrecords->student_book_request_lists('', 'RT'); ?>
                    </table>
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