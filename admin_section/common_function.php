<?php

    function _numb($amount, $digit=2) {
        return 'Rs. ' . number_format($amount, $digit);
    }

    function main_menu_list() {
        $menuList = '<li><a href="'.ADMIN_LINK.'admin_home.php">Home</a></li>'
                . '<li><a href="'.ADMIN_LINK.'books_management.php">Books Management</a></li>'
                . '<li><a href="'.ADMIN_LINK.'registered_student_list.php">Student Accounts</a></li>'
                . '<li><a href="'.ADMIN_LINK.'book_request_issued_mgmt.php">Issue of Books</a></li>'
                . '<li><a href="'.ADMIN_LINK.'book_renewal_request_mgmt.php">Renewel of Books</a></li>'
                . '<li><a href="'.ADMIN_LINK.'book_returned_mgmt_list.php">Returning Books</a></li>'
                . '<li><a href="'.ADMIN_LINK.'report_result_page.php">Reports</a></li>'
                . '<li><a href="'.ADMIN_LINK.'admin_logout.php">Logout</a></li>';

        return $menuList;
    }

    function user_menu_list() {
        $menuList = '<li><a href="user_home_page.php">Home</a></li>'
                . '<li><a href="user_file_records.php">Show File Record</a></li>'
                . '<li><a href="logout.php">Logout</a></li>';

        return $menuList;
    }
    
    function book_left_links() {
        
    }
    
    function print_array($ar='') {
        echo '<pre>';
        print_r($ar);
        echo '</pre>';
        exit;
    }
    
    function page_left_menu() {
        $left_menu = '<ul class="left_menu_settings">
                        <li><a href="'.ADMIN_LINK.'category_management.php">Manage Book Category</a></li>
                        <li><a href="'.ADMIN_LINK.'add_book_management.php">Add Book</a></li>
                        <li><a href="'.ADMIN_LINK.'books_management.php">Managed Books</a></li>
                        <li><a href="'.ADMIN_LINK.'book_request_issued_mgmt.php">Issue of Book</a></li>
                        <li><a href="'.ADMIN_LINK.'book_renewal_request_mgmt.php">Renewal of Books</a></li>
                        <li><a href="'.ADMIN_LINK.'book_returned_mgmt_list.php">Returning Books</a></li>
                        <li><a href="'.ADMIN_LINK.'book_returned_mgmt_finelist.php">Fine Students</a></li>
                        <li><a href="'.ADMIN_LINK.'report_result_page.php">Reports</a></li>
                        <li><a href="'.ADMIN_LINK.'admin_logout.php">Logout</a></li>
                    </ul>';
        
        return $left_menu;
    }
    
    function check_value($field_value, $detault_value='') {
        if( !empty($field_value) ) {
            return $field_value;
        } else {
            return $detault_value;
        }
    }
    
    function set_book_issue_status($status='PN') {
        switch ($status) {
            case 'IS':
                $issue_status = 'Issued';
                break;
            case 'PN':
                $issue_status = 'Pending';
                break;
            case 'CL':
                $issue_status = 'Canceld';
                break;
            case 'RT':
                $issue_status = 'Returned';
                break;
            default :
                $issue_status = 'Pending';
                break;
        }
        return $issue_status;
    }
    
    function book_issue_status($status='PN') {
        
        if( $status != 'CL' ) {
            return '<div class="success_msg1">'.set_book_issue_status($status).'</div>';
        } else {
            return '<div class="cancel_msg">Canceld</div>';
        }
    }
    
    function v_dump($array=[]) {
        echo '<pre>';
        print_r( $array );
        echo '<br><br>';
        var_dump( $array );
        echo '</pre>';
        exit;
    }
    
    function d_format($date='0000-00-00') {
        return date('F j, Y', strtotime($date));
    }
    
    function option_selected($option1='', $option2='') {
        return ( $option1 == $option2 ? 'selected' : '' ) ;
    }
    
    /*
     * set book status list
     */
    function set_book_status_list($book_status='') {
        $status_list = array(
            'IS' => 'Issued Book',
            'RT' => 'Returned Book',
            'RN' => 'Renew Book',
            'PN' => 'Pending Request',
            'CL' => 'Cacel Request',
            'NT' => 'Not Returned',
        );
        
        $status_options = '';
        
        foreach( $status_list as $status_id => $status_label )  {
            $status_options .= '<option value="'.$status_id.'" '.option_selected($status_id, $book_status).'>'.$status_label.'</option>';
        }
        
        return $status_options;
    }