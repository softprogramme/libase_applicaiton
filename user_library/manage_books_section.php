<?php

class manageBooks extends commonLib {
    public $bookrecords;
    
    function __construct() {
        parent::__construct();
        
        $this->bookrecords = new booksRecords();
    }
    
    function view_books_list() {
        $category_id = $_GET['category_id'];
        $search_field = $this->posts('search_field');
        
        $books_category = '';
        
        $sql = "SELECT * FROM tbl_book WHERE 1= 1";
        
        if( $category_id > 0 ) {
            $books_category = '<div class="set_cate_title">Book Category: '.$this->bookrecords->get_book_category_name($category_id).'</div>';
            $sql .= " AND category_id = '{$category_id}'";
        }
        if( !empty($search_field) ) {
            $sql .= " AND book_title LIKE '%{$search_field}%' OR book_author LIKE '%{$search_field}%' OR book_description LIKE '%{$search_field}%'";
        }
        
        $sql .= " ORDER BY book_title ASC";
        
        $results = $this->query_exe( $sql );
        $book_list = '';
        $i = 1;
        
        if( $results->num_rows > 0 ) {
            while( $rows = $results->fetch_assoc() ) {
                $detail_link = SYSTEM_LINK.'view_user_book_details.php/?book_id='.$rows['id'];
                $image_link = 'admin_section/' . $this->bookrecords->book_cover_img($rows['book_cover']);
                $book_title = $rows['book_code'] . ' - ' . $rows['book_title'];
                
                $book_list .= '<div class="book_column">
                        <div>
                            <a href="'.$detail_link.'"><img src="'.$image_link.'" alt="'.$book_title.'" width="150" /></a>
                        </div>
                        <div class="book_title">'.$book_title.'</div>
                        <div><a href="'.$detail_link.'" class="view_details">View Details</a></div>
                    </div>';

                $i++;
            }  
        } else {
            $book_list = '<div class="set_cate_title" align="center"> :: NO PRODUCT LIST HAS FOUND! ::</div>';
        }
        return $books_category . $book_list;
    }
    
    function view_category_list() {
        $results = $this->query_exe( "SELECT * FROM book_category ORDER BY category_name ASC" );
        $file_rows = '';
        $file_rows .= '<li><a href="'.SYSTEM_LINK.'student_books_management.php" class="pageLink">Books Management</a></li>';
        $i = 1;
        
        if( $results->num_rows > 0 ) {
            while( $rows = $results->fetch_assoc() ) {
                $list_link = SYSTEM_LINK.'student_books_management.php?category_id='.$rows['id'];
                $file_rows .= '<li><a href="'.$list_link.'">'.$rows['category_name'].'</a></li>';

                $i++;
            }  
        } else {
            $file_rows = '<li>No Category Found</li>';
        }
        return $file_rows;
    }
    
    //// send book request
    function send_book_request($book_id=0, $std_id=0, $return_book='', $renew_return='') {
        //// check book record
        $sql_query = "SELECT `id` FROM `request_book` WHERE `student_id` = '{$std_id}' AND `book_id` = '{$book_id}' AND `book_status` IN ('PN', 'IS') ORDER BY `id` DESC LIMIT 1"; //echo $sql_query; exit;
        
        $sql = $this->query_exe( $sql_query );
        $row = mysqli_fetch_assoc( $sql );
        $request_date = date('Y-m-d');
        
        if( $return_book == 'RN' ) {
            $request_update = "UPDATE request_book set book_status = 'RN', renewal_req_date = '{$request_date}' WHERE student_id = '{$std_id}' AND book_id = '{$book_id}' AND book_status = 'RT'";
        } else {
            $request_update = "UPDATE request_book set book_status = 'RT'";
            if( empty($renew_return) ) {
                $request_update .= ", returned_date = '{$request_date}'";
            } else {
                $request_update .= ", renewal_return_date = '{$request_date}'";
            }            
            $request_update .= " WHERE student_id = '{$std_id}' AND book_id = '{$book_id}' AND book_status = 'IS'";
        }
        
        if( !empty($return_book) ) {
            $this->query_exe( $request_update );
        }
        if( empty($row['id']) && $return_book != 'RN' ) {
            $message = 'Book Request has sent successfully! Please check your Book Request page for details!';
            $this->query_exe( "INSERT INTO request_book (`student_id`, `book_id`, `request_date`) VALUES ('{$std_id}', '{$book_id}', '{$request_date}')" );
        } else {
            $message = 'This book requeset is already sent to the admin, plz check your accont for details!';
        }
        return $message;
    }
    
    //// get file record row
    function get_category_record_row($id) {
        $sql = $this->query_exe("SELECT * FROM book_category WHERE id = '{$id}' ORDER BY id DESC LIMIT 1");
        $row = mysqli_fetch_assoc( $sql );
        
        return $row;
    }
}