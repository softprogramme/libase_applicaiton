<?php
require_once 'user_library/user_system_files.php';

$book_id = $admin->gets('book_id');
$view_detail = $admin->gets('detail');
$request_sent = $admin->gets('req_sent');
$student_id = $_SESSION['student_id'];

$mb = new manageBooks();
$row = $mb->bookrecords->get_book_record_row( $book_id );
$book_cover = SYSTEM_LINK.'admin_section/'.$mb->bookrecords->book_cover_img( $row['book_cover'] );
$request_link = SYSTEM_LINK . 'view_user_book_details.php/?req_sent=sent&book_id=' . $book_id;

if( !empty($request_sent) ) {
    if( !empty($student_id) ) {
        $return_message = $mb->send_book_request( $book_id,  $student_id);
    } else {
        header('Location:'.SYSTEM_LINK.'login_user.php?book_id='.$book_id.'&msg=Plz enterd the correct login Email or password!'); exit;
    }
}

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Books Management - <?php echo SYSTEM_TITLE; ?></title>
<link type="text/css" rel="stylesheet" href="<?php echo SYSTEM_LINK; ?>admin_section/style_file.css" />
<link type="text/css" rel="stylesheet" href="<?php echo SYSTEM_LINK; ?>main_site_style.css" />
<script type="text/javascript" src="<?php echo SYSTEM_LINK; ?>admin_section/js_files/common_functions.js"></script>
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
                        <?php                         
                            echo $mb->view_category_list();
                        ?>
                    </ul>
                </div>
                <div class="page_right_col">  
            <div class="form_block">
                <h1 class="main_heading">Book Detail</h1><br><br>
                <div>
                    <?php 
                        if( !empty($request_sent) ) {
                            echo '<div class="success_msg">'.$return_message.'</div><br>';
                        }
                    ?>                
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
                        <div class="form_label">Book Author :</div>
                        <div class="form_field">
                            <?php echo check_value($row['book_author'], 'NA'); // common_function_lib file ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Cover Image :</div>
                        <div class="form_field">
                            <img src="<?php echo $book_cover; ?>" width="200" alt="<?php echo $row['book_title']; ?>" />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Publish Date :</div>
                        <div class="form_field"><?php echo $row['publish_date']; ?></div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Add Date :</div>
                        <div class="form_field"><?php echo $row['add_date']; ?></div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Book Description :</div>
                        <div class="form_field">
                            <?php echo $row['book_description']; ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <?php if( empty($view_detail) ) { ?>
                    <div class="form_row">
                        <div class="form_label">&nbsp;</div>
                        <div class="form_field">
                            <a href="<?php echo $request_link; ?>" class="btn_style">Send Request</a>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <?php } ?>
                    <br><br>
                  </div>
                <br>
            </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php require_once('admin_section/main_bottom_footer.php'); ?>
    </div>
</body>
</html>