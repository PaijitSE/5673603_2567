<?php
require_once('script/Myscript.php');
$db_handle = new myDBControl();

$st = $_REQUEST["st"];
if ($st == 'A') {
    $eid        = $_POST["eid"];
    $pname      = $_POST["pname"];
    $fname      = $_POST["fname"];
    $lname      = $_POST["lname"];
    $posid      = $_POST["posid"];
    $code1      = $_POST["code1"];
    $code2      = $_POST["code2"];
    $bank       = $_POST["bank"];
    $salary     = $_POST["salary"];
    $un         = $_POST["un"];
    $pw         = $_POST["pw"];
    $img        = "img/Employee/" . $eid . ".jpg";

    //สร้างแหล่งที่จะ upload file เข้าไปเก็บ
    if (isset($_FILES['staffImg'])) {
        //คัดลอกไฟล์ไปเก็บที่เว็บเซริ์ฟเวอร์ => Host
        move_uploaded_file($_FILES['staffImg']['tmp_name'], $img);
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('ไม่พบ Image file " . $_FILES['staffImg']['name'] . "');";
        echo "</script>";
    }

    /* จบจัดการรูปภาพ*/

    $tcheck     = "SELECT * FROM EMPLOYEE WHERE (Emp_id = '$cid' AND Emp_UN = '$un' AND Emp_PW = '$pw')";
    echo $tcheck;

    $check  = $db_handle->Textquery($tcheck);

    if (empty($check)) {
        $tquery = "INSERT INTO EMPLOYEE VALUES ('$un','$pw','$eid','$pname','$fname','$lname','$posid','$code1','$code2','$bank','$salary','$img')";
        echo $tquery;
        $insData    = $db_handle->Execquery($tquery);
        echo "<script type='text/javascript'>";
        echo "alert('เจ้าหน้าที่รหัส " . $cid . " ได้ถูกบันทึกข้อมูลแล้ว');";
        echo "window.location = 'employee.php';";
        echo "</script>";
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('พบข้อมูลซ้ำซ้อน กรุณาตรวจสอบ');";
        echo "window.history.back();";
        echo "</script>";
    }
}

if ($st == 'D') {
    $cid        = $_GET["eid"];
    $img = "img/Employee/" . $eid . ".jpg";

    if (substr($eid, 0, 2) != 'E00') {
        unlink($img); //ลบไฟล์เดิมก่อน    
    }

    $tquery = "DELETE FROM EMPLOYEE WHERE (Emp_id = '$eid') AND (Emp_id NOT LIKE 'E00%')";
    $delData    = $db_handle->Execquery($tquery);
    echo "<script type='text/javascript'>";
    echo "alert('เจ้าหน้าที่รหัส " . $eid . " ได้ถูกลบข้อมูลแล้ว');";
    echo "window.location = 'employee.php';";
    echo "</script>";
}

if ($st == 'V') {
    $eid        = $_POST["eid"];
    $pname      = $_POST["pname"];
    $fname      = $_POST["fname"];
    $lname      = $_POST["lname"];
    $posid      = $_POST["posid"];
    $code1      = $_POST["code1"];
    $code2      = $_POST["code2"];
    $bank       = $_POST["bank"];
    $salary     = $_POST["salary"];
    $un         = $_POST["un"];
    $pw         = $_POST["pw"];
    $img        = "img/Employee/" . $eid . ".jpg";

    $tquery = "UPDATE EMPLOYEE SET 
        Emp_prename     = '$pname', 
        Emp_firstname   = '$fname', 
        Emp_lastname    = '$lname', 
        Emp_pos_id      = '$posid', 
        Emp_code1       = '$code1', 
        Emp_code2        = '$code2', 
        Emp_bank        = '$bank', 
        Emp_salary      = '$salary'
    WHERE (Emp_id = '$eid') ";
    $UpData    = $db_handle->Execquery($tquery);

    // Update รูปภาพ
    unlink($img); //ลบไฟล์เดิมก่อน    
    move_uploaded_file($_FILES['staffImg']['tmp_name'], $img);

    echo "<script type='text/javascript'>";
    echo "alert('เจ้าหน้าที่รหัส " . $eid . " ได้ถูกปรับปรุงข้อมูลแล้ว');";
    echo "window.location = 'employee.php';";
    echo "</script>";
}


//echo $cid.' '.$pname.' '.$fname;
/* ข้อมูลรูปภาพ object ที่ถูกส่งมา*/
// echo  'name=' . $_FILES['memberImg']['name'] . "<br>";
// echo  'temp_name=' . $_FILES['memberImg']['temp_name'] . "<br>";
// echo  'size=' . $_FILES['memberImg']['size'] . "<br>";
// echo  'error=' . $_FILES['memberImg']['error'] . "<br>";

// ตรวจสอบความซ้ำซ้อนของไฟล์รูป
// if (file_exists(http://www.example.com/images/$filename)) {
//     echo "The file exists";
// } else {
//     echo "The file does not exist";
// }