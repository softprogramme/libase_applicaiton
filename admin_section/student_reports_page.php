<?php
require_once 'library/admin_system_files.php';
$rs = new manageRgisterStudents();   /// rs: register studenst class object
$student_name = $rs->posts('student_name');
$reg_no       = $rs->posts('reg_no');

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
            <h1 class="main_heading">Student Search</h1><br>
            <div class="search_block"><br>
                <form name="search_form" class="set_search_form" method="post" action="">
                    <div class="set_field_cols">
                        <label>Student Name :</label>
                        <input type="text" class="input_field" name="student_name" value="<?php echo $student_name; ?>" />
                    </div>
                    <div class="set_field_cols">
                        <label>Reg # :</label>
                        <input type="text" class="input_field" value="<?php echo $reg_no; ?>" name="reg_no" />
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
                        <th>Full Name</th>
                        <th>Contact No.</th>
                        <th>Email Address</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Zip Code</th>
                        <th>Reg #</th>
                        <th><div align="center">Req. Books</div></th>
                        <th><div align="center">Reg. Date</div></th>
                        <th><center>Action</center></th>
                    </tr>
                    <?php echo $rs->get_register_students_list($student_name, $reg_no); ?>
                </table>
            </div>
        </div>
        <?php require_once('main_bottom_footer.php'); ?>
    </div>
</body>
</html>