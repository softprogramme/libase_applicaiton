<?php
require_once 'library/admin_system_files.php';
$cate_id = $admin->gets('cate_id');
$cate = new categoryRecords();

if( !empty($cate_id) ) {
    $row = $cate->get_category_record_row( $cate_id );
    $category_name = $row['category_name'];
    $category_id = $cate_id;
} else {
    $category_name = '';
    $category_id = '';
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title><?php echo SYSTEM_TITLE; ?></title>
<link type="text/css" rel="stylesheet" href="style_file.css" />
<script type="text/javascript" src="js_files/common_functions.js"></script>
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
                <h1 class="main_heading">Manage Book Category</h1>          
                <div id="return_msg"></div>
                <h2 class="set_sub_heading">Add Book Category</h2><br>
            <?php
                if( isset($_GET['msg']) && !empty($_GET['msg']) ) {
                    echo '<div class="success_msg">'.$_GET['msg'].'</div>';
                }
            ?>
                <form method="post" name="file_record_form" action="<?php echo htmlspecialchars('add_category_record_submit.php'); ?>">
                    <div class="form_row">
                        <div class="form_label">Category Name</div>
                        <div class="form_field">
                            <input type="text" name="cate_name" value="<?php echo $category_name; ?>" required="">
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">&nbsp;</div>
                        <div class="form_field">
                            <input type="submit" name="btn_submit" value="Submit" />
                            <input type="hidden" value="<?php echo $category_id; ?>" name="category_id" />
                        </div>
                        <div class="clear"></div><br>
                    </div>
                </form>
                <br>
                <h2 class="set_sub_heading">Manage Book Categories</h2><br>
                <div class="books_block">
                    <table class="record_view_table">
                        <tr>
                            <th>Sr#</th>
                            <th>Category Name</th>
                            <th><div align="center">Action</div></th>
                        </tr>
                        <?php echo $cate->view_category_records(); ?>
                    </table>
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