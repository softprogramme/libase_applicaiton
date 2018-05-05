<?php

class categoryRecords extends commonLib {
    
    function __construct() {
        parent::__construct();
    }
    
    function category_records_submit($edit_id=0) {
        $cate_name = $this->posts('cate_name');
        
        $submit_status = '';
        
        if( $edit_id == 0 ) {
            $submit_status = 'add';
            $sql = "INSERT INTO `book_category` (`category_name`) VALUES ('{$cate_name}')";
        } else {
            $submit_status = 'edit';
            $sql = "UPDATE `book_category` SET `category_name` = '{$cate_name}' WHERE `id` = '{$edit_id}'";
        }
        
        $this->query_exe($sql);
        
        return $submit_status;
    }
    
    function view_category_records() {
        $results = $this->query_exe( "SELECT * FROM book_category ORDER BY id DESC" );
        $file_rows = '';
        $i = 1;
        
        if( $results->num_rows > 0 ) {
            while( $rows = $results->fetch_assoc() ) {
                $dlete_link = 'add_category_record_submit.php?category_id='.$rows['id'];
                $file_rows .= '<tr>
                            <td>'.$i.'</td>
                            <td>'.$rows['category_name'].'</td>
                            <td><div align="center">'
                            . '<a href="#javascript" onclick="confirm_delete(\''.$dlete_link.'\')">Delete</a> | '
                            . '<a href="category_management.php?cate_id='.$rows['id'].'">Edit</a></div></td>';
                
                $file_rows .= '</tr>';

                $i++;
            }  
        } else {
            $file_rows = '<tr><td colspan="3"><strong>NO CATEGRORY RECORDS HAS FOUND</strong></td></tr>';
        }
        return $file_rows;
    }
    
    function delete_category_records($id) {
        
        $this->query_exe( "DELETE FROM book_category WHERE id = '{$id}'" );
        
        return '<div class="success_msg"><br>Category record has deleted successfully!</div>';
    }
    
    //// get file record row
    function get_category_record_row($id) {
        $sql = $this->query_exe("SELECT * FROM book_category WHERE id = '{$id}' ORDER BY id DESC LIMIT 1");
        $row = mysqli_fetch_assoc( $sql );
        
        return $row;
    }
}