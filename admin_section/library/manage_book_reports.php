<?php

class bookReports extends commonLib {
    public $student;
    public $books;
    function __construct() {
        parent::__construct();
        $this->student = new manageRgisterStudents();
        $this->books = new booksRecords();
    }
    
   function book_reports_list($book_category='', $book_status='') {
        
        $sql = "SELECT * FROM request_book WHERE 1 = 1";
        
        if( !empty($book_status) ) {
            $sql .= " AND book_status = '{$book_status}'";
        }
        
        if( !empty($book_category) ) {
            $sql .= " AND book_id IN (SELECT id FROM tbl_book WHERE category_id = '{$book_category}')";
        }
        
        $sql .= " ORDER BY request_date DESC"; //echo $sql; exit;
        
        $results = $this->query_exe( $sql );
        $view_rows = '';
        $i = 1;
        
        if( $results->num_rows > 0 ) {
            while( $rows = $results->fetch_assoc() ) {
                $books_row = $this->books->get_book_record_row( $rows['book_id'] );
                $student_row = $this->student->get_student_records_row( $rows['student_id'] );
                $category_name = $this->books->get_book_category_name( $books_row['category_id'] );
                
                $book_detail_link = ADMIN_LINK . 'returned_book_detail.php?book_id='.$rows['book_id'].'&student_id='.$rows['student_id'].'&issue_type='.$rows['book_status'];
                $book_title = $books_row['book_code'] . ' - ' . $books_row['book_title'];
                
                $view_rows .= '<tr>
                                <td>'.$i.'</td>
                                <td><a href="'.ADMIN_LINK.'view_book_detail.php?book_id='.$rows['book_id'].'">'.$book_title.'</a></td>
                                <td>'.$category_name.'</td>
                                <td><a href="'.ADMIN_LINK.'view_reg_student_profile.php/?student_id='.$student_row['id'].'">'.$student_row['full_name'].'</a></td>
                                <td>'.book_issue_status($rows['book_status']).'</td>
                                <td><a href="'.$book_detail_link.'">View Details</a></td>
                            </tr>';

                $i++;
            }  
        } else {
            $view_rows = '<tr><td colspan="7"><strong>NO BOOK RECORDS HAS FOUND</strong></td></tr>';
        }
        return $view_rows;
    }
}