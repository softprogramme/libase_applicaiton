<?php
require_once 'library/admin_system_files.php';
$rs = new manageRgisterStudents();   /// rs: register studenst class object
$book = new booksRecords();
$reports = new bookReports();
$book_cate   = $book->posts('book_category');
$book_status = $book->posts('book_status');

?>
<!DOCTYPE HTML>
<html>
<head>
<title><?php echo SYSTEM_TITLE; ?></title>
<link type="text/css" rel="stylesheet" href="style_file.css" />
</head>
<body>
    <div class="main_block">
        <?php require_once('main_topheader.php'); ?>
        
        <div class="body_content">
            <div class="set_search_links">
                <a href="<?php echo ADMIN_LINK; ?>report_result_page.php">Book Search | </a>
                <a href="<?php echo ADMIN_LINK; ?>student_reports_page.php">Student Search</a>
            </div><br>
            <h1 class="main_heading">Book Search</h1><br>
            <div class="search_block"><br>
                <form name="search_form" class="set_search_form" method="post" action="">
                    <div class="set_field_cols">
                        <label>Book Category :</label>
                        <select name="book_category">
                            <option value="">Select Book Category</option> 
                            <?php
                                echo $book->get_category_options_list($book_cate);
                            ?>
                        </select>
                    </div>
                    <div class="set_field_cols">
                        <label>Book Status :</label>
                        <select name="book_status">
                                <option value="">Select Book Status</option>
                                <?php
                                    echo set_book_status_list($book_status); /// common_function
                                ?>
                        </select>
                    </div>
                    <div class="clear"></div><br><br>
                    <div class=""><input type="submit" name="btn_submit" class="btn_style" value="Search Result" /></div>
                </form>
            </div>
            <div id="return_msg"></div><br>
            <div class="table_block">
                <table class="record_view_table">
                    <tr>
                        <th>Sr#</th>
                        <th>Book Name</th>
                        <th>Book Category</th>
                        <th>Student Name</th>
                        <th>Book Status</th>
                        <th><center>Action</center></th>
                    </tr>
                    <?php echo $reports->book_reports_list($book_cate, $book_status); ?>
                </table>
            </div>
        </div>
        <?php require_once('main_bottom_footer.php'); ?>
    </div>
</body>
</html>