<?php

    ob_start();

    session_start();
    session_destroy();
    
    header('Location:login_user.php?msg=Logout successfully!');