<?php
require_once 'library/admin_system_files.php';

?>
<!DOCTYPE HTML>
<html>
<head>
<title><?php echo SYSTEM_TITLE; ?></title>
<link type="text/css" rel="stylesheet" href="style_file.css" />
</head>
<body>
    <div class="main_block">
        <div class="main_header"><?php echo SYSTEM_TITLE; ?></div>
        <div class="main_menu">
            <ul><?php echo main_menu_list();  /// function in common_function.php file ?></ul>
        </div>
        <div class="body_content"><br>
            <h1 class="main_heading">Welcome To <?php echo $_SESSION['login_full_name']. ' in ' . SYSTEM_TITLE; ?></h1><br><br>
            <div id="return_msg"></div>
        </div>
        <?php require_once('main_bottom_footer.php'); ?>
    </div>
</body>
</html>