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
    <div class="main_login_block">
        <h1 class="login_heading"><?php echo SYSTEM_TITLE; ?></h1>
        <?php
            if( isset($_GET['msg']) && !empty($_GET['msg']) ) {
                echo '<div class="error_msg">'.$_GET['msg'].'</div>';
            }
            ?>
        <form name="login_form" method="post" action="login_verify.php">
        <div class="login_page">            
            <div class="login_box_heading">Login</div>
            <div class="field_block">
                <div class="login_row">
                <div class="login_label">Username:</div>
                <div class="login_field"><input type="text" required="" placeholder="Enter username" name="login_username" /></div>
                <div class="clear"></div>
                </div>
                <div class="login_row">
                    <div class="login_label">Password:</div>
                    <div class="login_field"><input type="password" placeholder="Enter password" required="" name="login_password" /></div>
                    <div class="clear"></div>
                </div>
                <div class="login_row">
                    <div class="login_label">User Type:</div>
                    <div class="login_field">
                        <select name="cmb_type">
                            <option value="AD">Admin</option>
                            <option value="US">User</option>
                        </select>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="login_row">
                    <div class="login_label">&nbsp;</div>
                    <div class="login_field login_button">
                        <input type="submit" name="btn_submit" value="Submit" />
                        <input type="reset" name="btn_reset" value="Reset" />
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
            <div class="login_links set_links">
                <a href="index.php">< Back</a> |
                <a href="register_page.php">Register</a>
            </div>            
        </form>
    </div>
</body>
</html>