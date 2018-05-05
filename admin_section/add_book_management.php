<?php
require_once 'library/admin_system_files.php';
$book_id = $admin->gets('book_id');
$book = new booksRecords();

if( !empty($book_id) ) {
    $row = $book->get_book_record_row( $book_id );
      $bookID      = $book_id;
      $category_id = $row['category_id'];
      $book_code   = $row['book_code'];
      $book_title  = $row['book_title'];
      $book_desc   = $row['book_description'];
      $book_author = $row['book_author'];
      $publish_date = $row['publish_date'];
      $file_required = '';
} else {
    $bookID      = $book_id;
    $category_id = '';
    $book_code   = rand(999, 9999);
    $book_title  = '';
    $book_desc   = '';
    $book_author   = '';
    $publish_date = date('Y-m-d');
    $file_required = 'required=""';
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
                <h1 class="main_heading">Add Book Records</h1>          
                <div id="return_msg"></div>
                <h2 class="set_sub_heading">Add Book Detail</h2><br>
            <?php
                if( isset($_GET['msg']) && !empty($_GET['msg']) ) {
                    echo '<div class="success_msg">'.$_GET['msg'].'</div>';
                }
            ?>
                <form method="post" name="file_record_form" action="add_book_record_submit.php" enctype="multipart/form-data">
                    <div class="form_row">
                        <div class="form_label">Book Category</div>
                        <div class="form_field">
                            <select name="book_category" required="">
                                <option value="">Select Book Category</option>
                                <?php
                                    echo $book->get_category_options_list($category_id);
                                ?>
                            </select></div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Book Code</div>
                        <div class="form_field">
                            <input type="text" name="book_code" value="<?php echo $book_code; ?>" required="" />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Book Title</div>
                        <div class="form_field">
                            <input type="text" name="book_title" value="<?php echo $book_title; ?>" required="" />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Author Name</div>
                        <div class="form_field">
                            <input type="text" name="book_author" value="<?php echo $book_author; ?>" required="" />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Cover Image</div>
                        <div class="form_field">
                            <input type="file" name="cover_image" />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Book File</div>
                        <div class="form_field">
                            <input type="file" name="book_file" <?php echo $file_required; ?> />
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Publish Date</div>
                        <div class="form_field"><input type="text" name="publish_date" value="<?php echo $publish_date; ?>" required="" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Book Description</div>
                        <div class="form_field">
                            <textarea name="book_desc" class="desc_box"><?php echo $book_desc; ?></textarea>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">&nbsp;</div>
                        <div class="form_field">
                            <input type="submit" name="btn_submit" value="Submit Form" />
                            <input type="hidden" value="<?php echo $bookID; ?>" name="book_id" />
                        </div>
                        <div class="clear"></div><br>
                    </div>
                </form>
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