<?php

class booksRecords extends commonLib {
    public $student;
    function __construct() {
        parent::__construct();
        $this->student = new manageRgisterStudents();
    }
    
    function book_records_submit($edit_id=0) {
        $book_category = $this->posts('book_category');
        $book_code = $this->posts('book_code');
        $book_title = $this->posts('book_title');
        $book_author = $this->posts('book_author');
        
        $publish_date = $this->posts('publish_date');
        $book_desc = str_replace( "\n", "<br>", $this->posts('book_desc') );
        $todate = date('Y-m-d');
        
        $submit_status = '';
        
        if( $edit_id == 0 ) {
            $submit_status = 'add';
            $sql = "INSERT INTO `tbl_book` (`category_id`, `book_code`, `book_title`, `book_author` , `book_description`, `publish_date`, `add_date`) VALUES ('{$book_category}', '{$book_code}', '{$book_title}', '{$book_author}', '{$book_desc}', '{$publish_date}', '{$todate}')";
            $this->query_exe($sql);
            $book_id = $this->conn->insert_id;
            
        } else {
            $submit_status = 'edit';
            $book_id = $edit_id;
            
            $sql = "UPDATE `tbl_book` SET `category_id` = '{$book_category}', `book_code` = '{$book_code}', `book_title` = '{$book_title}', `book_author` = '{$book_author}', `book_description` = '{$book_desc}', `publish_date` = '{$publish_date}' WHERE `id` = '{$edit_id}'";
            $this->query_exe($sql);
        }
        
        $this->upload_book_files($_FILES, 'cover_image', 'book_cover', $book_id);  /// upload book cover
        $this->upload_book_files($_FILES, 'book_file', 'book_file', $book_id, 'uploads/book_file/');  /// upload book file
        
        return $submit_status;
    }
    
    function upload_book_files($files, $file_field='', $tableField='', $id=0, $folder='uploads/cover_image/') {
        $fileName = $files[$file_field]['name'];
        
        if( !empty($fileName) ) {
            $book_row = $this->get_book_record_row($id);
            
            if( !empty($book_row[$tableField]) ) {
                unlink($folder.$book_row[$tableField]);
            }
            
            $rand_no = rand(99, 999);
            $file_name = $rand_no.'_'.$id.'_'.str_replace(' ', '_', $fileName);
            
            move_uploaded_file($files[$file_field]['tmp_name'], $folder.$file_name);
            
            $this->query_exe("UPDATE `tbl_book` SET $tableField = '{$file_name}' WHERE id = '{$id}'");
        }
        
    }
    
    function student_book_request_lists($view_page_type='', $view_status='', $view_type='') {
        $student_id = $_SESSION['student_id'];
        $to_date = date('Y-m-d');
        
        $sql = "SELECT *, bk.id book_id FROM tbl_book bk INNER JOIN request_book rb ON bk.id = rb.book_id WHERE 1 = 1";
        
        if( $view_type == 'fine' ) {
            $sql .= " AND rb.`returned_date` = '' AND rb.`book_status` = 'IS' AND rb.`due_date` < '{$to_date}'";
        }
        if( !empty($view_status) ) {
            $sql .= " AND rb.book_status = '{$view_status}'";
        } else {
            $sql .= " AND rb.book_status != 'RT'";
        }
        
        if( empty($view_page_type) ) {
            $sql .= " AND rb.student_id = '{$student_id}'";
        }
        $sql .= " ORDER BY rb.id DESC"; //echo $sql;
        
        $results = $this->query_exe( $sql );
        
        $view_rows = $this->book_view_content_rows( $results, $view_status, $view_type );
        
        return $view_rows;
    }
    
    function book_view_content_rows($results='', $view_status='', $view_type='') {
        $view_rows = '';
        
        $i = 1;
        if( $results->num_rows > 0 ) {
            while( $rows = $results->fetch_assoc() ) {
                $category_name = $this->get_book_category_name( $rows['category_id'] );
                $cover_img = SYSTEM_LINK . 'admin_section/' . $this->book_cover_img($rows['book_cover']);
                $book_status = book_issue_status($rows['book_status']);
                
                //$dlete_link = 'add_book_record_submit.php?book_id='.$rows['book_id'];
                $detail_link = SYSTEM_LINK . 'view_user_book_details.php?book_id='.$rows['book_id'].'&detail=details';
                //$cover_img = $this->book_cover_img($rows['book_cover']);
                $book_title = $rows['book_code'] . ' - ' . $rows['book_title'];
                
                $view_rows .= '<tr>
                                <td>'.$i.'</td>
                                <td>'.$book_title.'</td>
                                <td>'.$category_name.'</td>
                                <td>'.substr($rows['book_description'], 0, 100).'</td>
                                <td><div align="center"><img src="'.$cover_img.'" alt="'.$rows['book_title'].'" width="50" /><br>
                                    <a href="'.$detail_link.'">View Details</a></div>
                                </td>
                                <td>'.$rows['request_date'].'</td>';
                $view_rows .= '<td>'.$book_status;
                $view_rows .= $this->view_book_detail_link($rows, $view_type);
                
                $view_rows .= '</td>';
                
                if( $view_type == 'renew' ) {
                    $view_rows .= '<td><div align="center"><a href="'.SYSTEM_LINK.'view_renew_book_detail.php?book_id='.$rows['book_id'].'">Resend Request</a></div></td>';
                }
                if( $view_type == 'fine' ) {
                    $view_rows .= '<td><div align="center"><a href="'.SYSTEM_LINK.'student_fine_book_detail.php?book_id='.$rows['book_id'].'&student_id='.$rows['student_id'].'&issue_type=IS" class="cancel_msg">Fine Detail</a></div></td>';
                }
                
                if( empty($view_status) ) {
                    $view_rows .= '<td><div align="center" class="pageLink">Req. Received</div></td>';
                }
                                
                $view_rows .= '</tr>';

                $i++;
            }  
        } else {
            $view_rows .= '<tr><td colspan="8"><strong>NO BOOK RECORDS HAS FOUND</strong></td></tr>';
        }
        
        return $view_rows;
    }
    
    function view_book_detail_link($rows=[], $view_type='') {
        $view_rows = '';
        
        if( $rows['book_status'] == 'IS' ) {
            $view_rows .= '<a href="'.SYSTEM_LINK.'view_issued_book_detail.php?book_id='.$rows['book_id'].'">View Details</a>';
        } 
        else  if( $rows['book_status'] == 'RT' ) {
            if( empty($view_type) ) {
                $view_rows .= '<a href="'.SYSTEM_LINK.'view_returned_book_detail.php?book_id='.$rows['book_id'].'">View Details</a>';
            }                   
        }
        return $view_rows;
    }
    function book_issued_mgmt($view_type='', $book_status='') {
        $std_id = $this->gets('student_id');
        $student_id = ( !empty($std_id) ? $std_id : $_SESSION['student_id'] );
        
        $sql = "SELECT *, bk.id book_id FROM tbl_book bk INNER JOIN request_book rb ON bk.id = rb.book_id WHERE 1 = 1";
        
        if( !empty($book_status) ) {
            $sql .= " AND rb.book_status = '{$book_status}'";
        }
        if( empty($view_type) ) {
            $sql .= " AND rb.student_id = '{$student_id}'";
        }
        
        $sql .= " ORDER BY rb.id DESC"; //echo $sql; exit;
        
        $results = $this->query_exe( $sql );
        $view_rows = '';
        $i = 1;
        
        if( $results->num_rows > 0 ) {
            while( $rows = $results->fetch_assoc() ) {
                $category_name = $this->get_book_category_name( $rows['category_id'] );
                $cover_img = SYSTEM_LINK . 'admin_section/' . $this->book_cover_img($rows['book_cover']);
                
                //$dlete_link = 'add_book_record_submit.php?book_id='.$rows['book_id'];
                //$cover_img = $this->book_cover_img($rows['book_cover']);
                $issue_book_link = ADMIN_LINK . 'issued_book_mgmt.php?book_id='.$rows['book_id'].'&student_id='.$rows['student_id'].'&issue_type='.$book_status;
                $book_issue_label = ( $book_status === 'RN' ? 'Renew Book' : 'Issue Book' );
                $book_title = $rows['book_code'] . ' - ' . $rows['book_title'];
                
                $view_rows .= '<tr>
                                <td>'.$i.'</td>
                                <td>'.$book_title.'</td>
                                <td>'.$category_name.'</td>
                                <td><div align="center"><img src="'.$cover_img.'" alt="'.$rows['book_title'].'" width="50" /><br>
                                    <a href="'.ADMIN_LINK.'view_book_detail.php?book_id='.$rows['book_id'].'">View Details</a></div>
                                </td>
                                <td>'.$rows['request_date'].'</td>
                                <td>'.book_issue_status($rows['book_status']).'</td>
                                <td><div align="center">
                                    <a href="'.$issue_book_link.'">'.$book_issue_label.'</div>
                                </td>
                            </tr>';

                $i++;
            }  
        } else {
            $view_rows = '<tr><td colspan="7"><strong>NO BOOK RECORDS HAS FOUND</strong></td></tr>';
        }
        return $view_rows;
    }
    
    function book_fine_mgmt_list($view_type='', $book_status='') {
        $to_date = date('Y-m-d');
        $sql = "SELECT *, bk.id book_id FROM tbl_book bk INNER JOIN request_book rb ON bk.id = rb.book_id AND rb.`returned_date` = '' AND rb.`book_status` = 'IS' AND rb.`due_date` < '{$to_date}'";
        
        $sql .= " ORDER BY rb.id DESC"; //echo $sql; exit;
        
        $results = $this->query_exe( $sql );
        $view_rows = '';
        $i = 1;
        
        if( $results->num_rows > 0 ) {
            while( $rows = $results->fetch_assoc() ) {
                $cover_img = SYSTEM_LINK . 'admin_section/' . $this->book_cover_img($rows['book_cover']);
                $book_link = ADMIN_LINK . 'fine_book_detail.php?book_id='.$rows['book_id'].'&student_id='.$rows['student_id'].'&issue_type='.$rows['book_status'];
                $book_title = $rows['book_code'] . ' - ' . $rows['book_title'];
                
                $view_rows .= '<tr>
                                <td>'.$i.'</td>
                                <td>'.$book_title.'<br>
                                    <a href="'.ADMIN_LINK.'view_book_detail.php?book_id='.$rows['book_id'].'">Book Details</a></td>
                                <td>'.$rows['request_date'].'</td>
                                <td>'.$rows['issued_date'].'</td>
                                <td>'.$rows['returned_date'].'</td>
                                <td><div align="center"><img src="'.$cover_img.'" alt="'.$rows['book_title'].'" width="50" /></div>
                                </td>
                                <td>'.book_issue_status($rows['book_status']).'</td>
                                <td><div align="center">
                                    <a href="'.$book_link.'" class="cancel_msg">Apply Fine</div>
                                </td>
                            </tr>';

                $i++;
            }  
        } else {
            $view_rows = '<tr><td colspan="8"><strong>NO BOOK RECORDS HAS FOUND</strong></td></tr>';
        }
        return $view_rows;
    }
    
    function book_returned_mgmt($view_type='', $book_status='') {
        $student_id = $_SESSION['student_id'];
        $sql = "SELECT *, bk.id book_id FROM tbl_book bk INNER JOIN request_book rb ON bk.id = rb.book_id WHERE 1 = 1";
        
        if( !empty($book_status) ) {
            $sql .= " AND rb.book_status = '{$book_status}'";
        }
        if( empty($view_type) ) {
            $sql .= " AND rb.student_id = '{$student_id}'";
        }
        $sql .= " ORDER BY rb.id DESC"; //echo $sql; exit;
        
        $results = $this->query_exe( $sql );
        $view_rows = '';
        $i = 1;
        
        if( $results->num_rows > 0 ) {
            while( $rows = $results->fetch_assoc() ) {
                $cover_img = SYSTEM_LINK . 'admin_section/' . $this->book_cover_img($rows['book_cover']);
                $book_page_link = ( $book_status == 'RT' ? 'returned_book_detail.php' : 'issued_book_mgmt.php' );
                $issue_book_link = ADMIN_LINK . $book_page_link.'?book_id='.$rows['book_id'].'&student_id='.$rows['student_id'].'&issue_type='.$book_status;
                $book_title = $rows['book_code'] . ' - ' . $rows['book_title'];
                
                $view_rows .= '<tr>
                                <td>'.$i.'</td>
                                <td>'.$book_title.'<br>
                                    <a href="'.ADMIN_LINK.'view_book_detail.php?book_id='.$rows['book_id'].'">Book Details</a></td>
                                <td>'.$rows['request_date'].'</td>
                                <td>'.$rows['issued_date'].'</td>
                                <td>'.$rows['returned_date'].'</td>
                                <td><div align="center"><img src="'.$cover_img.'" alt="'.$rows['book_title'].'" width="50" /></div>
                                </td>
                                <td>'.book_issue_status($rows['book_status']).'</td>
                                <td><div align="center">
                                    <a href="'.$issue_book_link.'">View Details</div>
                                </td>
                            </tr>';

                $i++;
            }  
        } else {
            $view_rows = '<tr><td colspan="7"><strong>NO BOOK RECORDS HAS FOUND</strong></td></tr>';
        }
        return $view_rows;
    }
    
    function view_book_records() {
        $results = $this->query_exe( "SELECT * FROM tbl_book ORDER BY id DESC" );
        $view_rows = '';
        $i = 1;
        
        if( $results->num_rows > 0 ) {
            while( $rows = $results->fetch_assoc() ) {
                $category_name = $this->get_book_category_name( $rows['category_id'] );
                
                $dlete_link = 'add_book_record_submit.php?book_id='.$rows['id'];
                $cover_img = $this->book_cover_img($rows['book_cover']);
                $book_title = $rows['book_code'] . ' - ' . $rows['book_title'];
                
                $view_rows .= '<tr>
                                <td>'.$i.'</td>
                                <td>'.$book_title.'</td>
                                <td>'.$category_name.'</td>
                                <td>'.substr($rows['book_description'], 0, 100).'</td>
                                <td><div align="center"><img src="'.$cover_img.'" alt="'.$rows['book_title'].'" width="50" /><br>
                                    <a href="view_book_detail.php?book_id='.$rows['id'].'">View Details</a><br>
                                    <a href="uploads/book_file/'.$rows['book_file'].'" target="_blank">Download</a></div>
                                </td>
                                <td>'.$rows['add_date'].'</td>
                                <td><div align="center">'
                                    . '<a href="#javascript" onclick="confirm_delete(\''.$dlete_link.'\')">Delete</a> | '
                                    . '<a href="add_book_management.php?book_id='.$rows['id'].'">Edit</a></div></td>
                                </td>
                            </tr>';

                $i++;
            }  
        } else {
            $view_rows = '<tr><td colspan="7"><strong>NO BOOK RECORDS HAS FOUND</strong></td></tr>';
        }
        return $view_rows;
    }
    
    function book_cover_img($imgfile='') {
        
        if( !empty($imgfile) ) {
            $image_link = 'uploads/cover_image/'.$imgfile;
        } else {
            $image_link = 'images_files/no_image_found.jpg';
        }
        
        return $image_link;
    }
    
    function delete_book_records($id) {
        
        $book = $this->get_book_record_row($id);
        
        if( !empty($book['book_cover']) ) {
            unlink('uploads/cover_image/'.$book['book_cover']);
        }
        if( !empty($book['book_file']) ) {
            unlink('uploads/book_file/'.$book['book_file']);
        }
        
        $this->query_exe( "DELETE FROM tbl_book WHERE id = '{$id}'" );
        
        return 'Book record has deleted successfully!';
    }
    
    function update_student_fine_amount($id, $paid='') {        
        $set_fine_amount = $this->posts('set_fine_amount');
        $sql = "UPDATE `request_book` set `fine_amount` = '{$set_fine_amount}'";
        
        if( !empty($paid) ) {
            $sql .= ", `fine_paid` = 'Y'";
        }
        $sql .= " WHERE id = '{$id}'";
        
        $this->query_exe($sql);
        
        return 'Fine has added successfully!';
    }
    
    //// get file record row
    function get_category_options_list($cate_id=0) {
        $sql = $this->query_exe("SELECT * FROM book_category ORDER BY category_name ASC");
        $cate_options = '';
        
            if( $sql->num_rows > 0 ) {
                while( $rows = $sql->fetch_assoc() ) {
                    $cate_options .= '<option value="'.$rows['id'].'" '.$this->optSelected($rows['id'], $cate_id).'>'.$rows['category_name'].'</option>';
                }
            }
        
        return $cate_options;
    }
    
    //// get file record row
    function get_book_record_row($id) {
        $sql = $this->query_exe("SELECT * FROM tbl_book WHERE id = '{$id}' ORDER BY id DESC LIMIT 1");
        $row = mysqli_fetch_assoc( $sql );
        
        return $row;
    }
    
    //// get file record row
    function get_renewal_book_detail($book_id=0, $student_id=0, $book_status='') {
        $sql = $this->query_exe("SELECT * FROM request_book WHERE `book_id` = '{$book_id}' AND `student_id` = '{$student_id}' AND `book_status` = '{$book_status}' ORDER BY id DESC LIMIT 1");
        $row = mysqli_fetch_assoc( $sql );
        
        return $row;
    }
    
    //// get file record row
    function borrowed_book_detail($std_id=0, $book_id=0, $view_status='') {
        $query = "SELECT * FROM request_book WHERE `student_id` = '{$std_id}' AND book_id = '{$book_id}'";
        
        if( !empty($view_status) ) {
            $query .= "  AND book_status = '{$view_status}'";
        } else {
            $query .= "  AND book_status != 'RT'";
        }        
        
        $query .= " ORDER BY id DESC LIMIT 1";
        
        $sql = $this->query_exe( $query );
        $row = mysqli_fetch_assoc( $sql );
        
        return $row;
    }
    
    /// add the book request to issue or cancle a book
    function renew_book_request() {
        $student_id = $this->posts('student_id');
        $book_id = $this->posts('book_id');
        $renew_date = $this->posts('renew_date');
        $issue_status = $this->posts('issue_status');
        $rewnew_due_date = $this->posts('rewnew_due_date');
        
        $this->query_exe("UPDATE request_book set `renewal_date` = '{$renew_date}', `renewal_due_date` = '{$rewnew_due_date}', `book_status` = '{$issue_status}' WHERE `student_id` = '{$student_id}' AND `book_id` = '{$book_id}'");
        
        if( $issue_status === 'IS' ) {
            return 'Requested book has renewed successfully!';
        } else {
            return 'Book request has cancled due to un availability of Book!';
        }
    }
    /// add the book request to issue or cancle a book
    function add_book_request() {
        $student_id = $this->posts('student_id');
        $book_id = $this->posts('book_id');
        $issued_date = $this->posts('issued_date');
        $return_date = $this->posts('return_date');
        $issue_status = $this->posts('issue_status');
        
        $this->query_exe("UPDATE request_book set `issued_date` = '{$issued_date}', `due_date` = '{$return_date}', `book_status` = '{$issue_status}' WHERE `student_id` = '{$student_id}' AND `book_id` = '{$book_id}'");
        
        if( $issue_status === 'IS' ) {
            return 'Requested book has issued successfully!';
        } else {
            return 'Book request has cancled due to un availability of Book!';
        }
    }
    
//// get file record row
    function get_book_category_name($id) {
        $sql = $this->query_exe("SELECT category_name FROM book_category WHERE id = '{$id}' ORDER BY id DESC LIMIT 1");
        $row = mysqli_fetch_assoc( $sql );
        
        return $row['category_name'];
    }
}