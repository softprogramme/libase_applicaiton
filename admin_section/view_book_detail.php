<?php
require_once 'library/admin_system_files.php';
$book_id = $admin->gets('book_id');
$book = new booksRecords();
$row = $book->get_book_record_row( $book_id );
$book_cover = $book->book_cover_img( $row['book_cover'] );

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
                        <div class="form_label">Book File :</div>
                        <div class="form_field">
                            <a href="uploads/book_file/<?php echo $row['book_file']; ?>" class="pageLink" target="_blank">Download Book</a>
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
                    <br><br>
                  </div>
                <br>
            </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php require_once('main_bottom_footer.php'); ?>
    </div>
</body>
</html>