<?php
require_once 'user_library/user_system_files.php';

$book_id = $admin->gets('book_id');
$student_id = $_SESSION['student_id'];

$mb = new manageBooks();
$row = $mb->bookrecords->get_book_record_row( $book_id );
$borrowed_book = $mb->bookrecords->borrowed_book_detail( $student_id, $book_id, 'RT' );
$book_cover = SYSTEM_LINK.'admin_section/'.$mb->bookrecords->book_cover_img( $row['book_cover'] );


    if( empty($student_id) ) {        
        header('Location:'.SYSTEM_LINK.'login_user.php?book_id='.$book_id.'&msg=Plz enterd the correct login Email or password!'); exit;
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
                            echo student_left_menu();  // common_function_lib file
                        ?>
                    </ul>
                </div>
                <div class="page_right_col">  
            <div class="form_block">
                <h1 class="main_heading">Returned Book Detail</h1><br><br>
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
                    <div class="form_row">
                        <div class="form_label">Book Status :</div>
                        <div class="form_field">
                            <b>Retured</b>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Request Date :</div>
                        <div class="form_field">
                           <?php echo d_format( $borrowed_book['request_date'] ); /// common_function file ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Issued Date :</div>
                        <div class="form_field">
                            <?php echo d_format( $borrowed_book['issued_date'] ); /// common_function file ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Due Date :</div>
                        <div class="form_field">
                            <div class="red_msg"><?php echo d_format( $borrowed_book['due_date'] ); /// common_function file ?></div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Returned Date :</div>
                        <div class="form_field">
                            <div><b><?php echo d_format( $borrowed_book['returned_date'] ); /// common_function file ?></b></div>
                        </div>
                        <div class="clear"></div>
                    </div>
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