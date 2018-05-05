<?php
require_once 'library/admin_system_files.php';

session_destroy();

header('Location:login_page.php?msg=Logout Successfully!');