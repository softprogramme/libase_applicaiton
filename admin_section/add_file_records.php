<?php
require_once 'library/admin_system_files.php';
$file_id = $admin->gets('file_id');

if( !empty($file_id) ) {
    $row = $admin->get_file_record_row( $file_id );
    $internalRec = $row['internal_receiving'];
    $dept_name   = $row['department'];
    $dept_type   = $row['dept_type'];
    $org_name    = $row['org_name'];
    $org_type    = $row['org_type'];
    $file_no     = $row['file_no'];
    $file_date   = $row['file_date'];
    $subTitle    = $row['subject'];
    $file_name   = $row['file_name'];
    $file_status = $row['status'];
} else {
    $internalRec = '';
    $dept_name   = '';
    $dept_type   = '';
    $org_name    = '';
    $org_type    = '';
    $file_no     = '';
    $file_date   = date('Y-m-d');
    $subTitle    = '';
    $file_name   = '';
    $file_status = '';
    $file_id     = '';
}

?>
<!DOCTYPE HTML>
<html>
<head>
<title><?php echo SYSTEM_TITLE; ?></title>
<link type="text/css" rel="stylesheet" href="style_file.css" />
</head>
<body>
    <div class="main_block">
        <div class="main_header"><?php echo SYSTEM_TITLE; ?></div>
        <div class="main_menu">
            <ul><?php echo main_menu_list(); ?></ul>
        </div>
        <div class="body_content"><br>
            <h1 class="main_heading">Add File Record</h1><br>
            <?php
                if( isset($_GET['msg']) && !empty($_GET['msg']) ) {
                    echo '<div class="success_msg">'.$_GET['msg'].'</div>';
                }
            ?>
            <div id="return_msg"></div>
            <div class="form_block">
                <form method="post" name="file_record_form" action="add_file_record_submit.php">
                    <div class="form_row">
                        <div class="form_label">Internal Receiving</div>
                        <div class="form_field">
                            <select name="internal_receiving" required="">
                                <option value="">Select Option</option>
                                <?php
                                    echo '<option value="DS" '.$admin->optSelected('DS', $internalRec).'>DS</option>
                                          <option value="SSS" '.$admin->optSelected('SSS', $internalRec).'>SSS</option>';
                                ?>
                            </select></div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Department</div>
                        <div class="form_field">
                            <select name="dept_name" required="">
                                <?php
                                    echo '<option value="">Select Option</option>
                                        <option value="Marketing" '.$admin->optSelected('Marketing', $dept_name).'>Marketing</option>
                                        <option value="Finance" '.$admin->optSelected('Finance', $dept_name).'>Finance</option>
                                        <option value="HR" '.$admin->optSelected('HR', $dept_name).'>HR</option>';
                                ?>                                
                            </select></div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Department Type</div>
                        <div class="form_field">
                            <select name="dept_type" required="">
                                <option value="">Select Option</option>
                                <?php
                                    echo '<option value="Chair Man" '.$admin->optSelected('Chair Man', $dept_type).'>Chair Man</option>
                                         <option value="Chief" '.$admin->optSelected('Chief', $dept_type).'>Chief</option>';
                                ?>
                                
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Organization</div>
                        <div class="form_field">
                            <select name="org_name" required="">
                                <?php
                                    echo '<option value="">Select Option</option>
                                        <option value="DPI(SE/EE)" '.$admin->optSelected('DPI(SE/EE)', $org_name).'>DPI(SE/EE)</option>
                                        <option value="CEO" '.$admin->optSelected('CEO', $org_name).'>CEO</option>
                                        <option value="DC" '.$admin->optSelected('DC', $org_name).'>DC</option>';
                                ?>                                
                            </select></div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Organization Type</div>
                        <div class="form_field">
                            <select name="org_type" required="">
                                <option value="">Select Option</option>
                                <?php
                                    echo '<option value="Gujrawala"'.$admin->optSelected('Gujrawala', $org_type).'>Gujrawala</option>
                                        <option value="BWP" '.$admin->optSelected('BWP', $org_type).'>BWP</option>
                                        <option value="Gujrat" '.$admin->optSelected('Gujrat', $org_type).'>Gujrat</option>';
                                ?>                                
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">File No#</div>
                        <div class="form_field"><input type="text" name="file_no" value="<?php echo $file_no; ?>" required="" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Date</div>
                        <div class="form_field"><input type="text" placeholder="Eg Y-m-d" value="<?php echo $file_date; ?>" name="file_date" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Subject</div>
                        <div class="form_field"><input type="text" value="<?php echo $subTitle; ?>" name="subject_title" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">File Name</div>
                        <div class="form_field"><input type="text" value="<?php echo $file_name; ?>" name="file_name" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">Status</div>
                        <div class="form_field">
                            <select name="file_status">
                                <?php
                                    echo '<option value="P" '.$admin->optSelected('P', $file_status).'>Pending</option>
                                        <option value="R" '.$admin->optSelected('R', $file_status).'>Received</option>
                                        <option value="RJ" '.$admin->optSelected('RJ', $file_status).'>Rejected</option>';
                                ?>                                
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="form_row">
                        <div class="form_label">&nbsp;</div>
                        <div class="form_field">
                            <input type="submit" name="btn_submit" value="Submit" />
                            <input type="hidden" value="<?php echo $file_id; ?>" name="txt_file_id" />
                        </div>
                        <div class="clear"></div><br>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>