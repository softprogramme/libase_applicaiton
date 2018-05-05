<?php


    function main_header_menu() {
        $menu_links = '<li><a href="'.SYSTEM_LINK.'index.php">Home</a></li>
                        <li><a href="'.SYSTEM_LINK.'student_books_management.php">Books Management</a></li>
                        <li><a href="'.SYSTEM_LINK.'manage_student_account.php">Student Account</a></li>';
        
        if( empty($_SESSION['student_id']) ) {
            $menu_links .= '<li><a href="'.SYSTEM_LINK.'register_user.php">Rgister Student</a></li>'
                           . '<li><a href="'.SYSTEM_LINK.'login_user.php">Login</a></li>';
        } else {
            $menu_links .= '<li><a href="'.SYSTEM_LINK.'logout.php">Logout</a></li>';
        }
        
        $menu_links .= '<li><form method="post" action="'.SYSTEM_LINK.'student_books_management.php" class="search_form">'
                . '<input type="text" name="search_field" required="" placeholder="Search Books" /><input type="image" src="'.SYSTEM_LINK.'img_files/search_icon.png" name="submit_button" />'
                . '</form></li>';
        

        return $menu_links;
    }

    function student_left_menu() {
        $menu_links = '<li><a href="'.SYSTEM_LINK.'manage_student_account.php" class="pageLink">Student Account</a></li>
                        <li><a href="'.SYSTEM_LINK.'edit_student_profile.php?student_id='.$_SESSION['student_id'].'">Update Profile</a></li>
                        <li><a href="'.SYSTEM_LINK.'student_book_request_list.php">Book Requests</a></li>
                        <li><a href="'.SYSTEM_LINK.'student_book_returned_mgmt.php">Returned Books</a></li>
                        <li><a href="'.SYSTEM_LINK.'student_book_renewal_mgmt.php">Renewal Books</a></li>
                        <li><a href="'.SYSTEM_LINK.'student_fine_list_mgmt.php">Fine Detail</a></li>
                        <li><a href="'.SYSTEM_LINK.'logout.php">Logout</a></li>';

        return $menu_links;
    }