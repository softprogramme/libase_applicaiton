<?php

class manageRgisterStudents extends commonLib {
    
    function __construct() {
        parent::__construct();
    }
    
    //// get register students list
    function get_register_students_list($student_name='', $regno='') {
        $sql = "SELECT * FROM `tbl_student` WHERE 1 = 1";
        
        if( !empty($student_name) ) {
            $sql .= " AND `full_name` LIKE '%{$student_name}%'";
        }
        if( !empty($regno) ) {
            $sql .= " AND `registration_number` LIKE '%{$regno}%'";
        }
        $sql .= " ORDER BY id DESC";
        
        $results = $this->query_exe($sql);
        $i = 1;
        $student_list = '';
        
        if( $results->num_rows > 0 ) {
            while( $rows = $results->fetch_assoc() ) {
                $total_req_books = $this->total_request_books($rows['id']);
                $student_detail = SYSTEM_LINK . 'admin_section/view_reg_student_profile.php/?student_id='.$rows['id'];
                if( $total_req_books > 0 ) {
                    $req_books_link = SYSTEM_LINK . 'admin_section/student_total_book_request_list.php/?student_id=' . $rows['id'];
                } else {
                    $req_books_link = '#';
                }
                $student_list .= '<tr>
                                    <td>'.$i.'</td>
                                    <td>'.$rows['full_name'].'</td>
                                    <td>'.$rows['contact_number'].'</td>
                                    <td>'.$rows['email_address'].'</td>
                                    <td>'.$rows['city'].'</td>
                                    <td>'.$rows['country'].'</td>
                                    <td>'.$rows['zip_code'].'</td>
                                    <td>'.$rows['registration_number'].'</td>
                                    <td><div align="center"><a href="'.$req_books_link.'">View ('.$total_req_books.')</a></div></td>
                                    <td><div align="center">'.$rows['add_date'].'</div></td>
                                    <td><div align="center"><a href="'.$student_detail.'">Details</a></div></td>
                                </tr>';
                $i++;
            }
        } else {
           $student_list .= '<tr><th colspan="11">NO Regisger Student Records Found</th></tr>'; 
        }
        
        return $student_list;
    }
    
    function total_request_books($student_id=0) {
        $results = $this->query_exe("SELECT * FROM `request_book` WHERE `student_id` = '{$student_id}'");
        
        return $results->num_rows;
    }
    
    //// select single student row from db
    function get_student_records_row($student_id=0) {
        $sql = $this->query_exe("SELECT * FROM `tbl_student` WHERE id = '{$student_id}' ORDER BY id DESC LIMIT 1");
        $row = mysqli_fetch_assoc( $sql );
        
        return $row;
    }
}