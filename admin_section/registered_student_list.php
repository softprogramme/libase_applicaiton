<?php
require_once 'library/admin_system_files.php';
$rs = new manageRgisterStudents();   /// rs: register studenst class object


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
        
        <div class="body_content"><br>
            <h1 class="main_heading">Register Student List</h1><br>
            <?php //echo $mesg; ?>
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
                    <?php echo $rs->get_register_students_list(); ?>
                </table>
            </div>
        </div>
        <?php require_once('main_bottom_footer.php'); ?>
    </div>
</body>
</html>