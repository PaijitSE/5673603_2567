<?php
require_once('script/Myscript.php');
$db_handle = new myDBControl();

$st = $_REQUEST["st"];
if ($st == 'A') {
    $pid        = $_POST["pid"];
    $pname      = $_POST["pname"];
    $type       = $_POST["ptype"];
    $price      = $_POST["pprice"];
    $count      = $_POST["pcount"];
    $unit       = $_POST["punit"];
    $cost       = $_POST["pcost"];
    $low        = $_POST["plow"];
    $high       = $_POST["phigh"];
    $detail     = $_POST["pdetail"];
    $img        = "img/Product/" . $pid . ".jpg";

    //สร้างแหล่งที่จะ upload file เข้าไปเก็บ
    if (isset($_FILES['productImg'])) {
        //คัดลอกไฟล์ไปเก็บที่เว็บเซริ์ฟเวอร์ => Host
        move_uploaded_file($_FILES['productImg']['tmp_name'], $img);
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('ไม่พบ Image file " . $_FILES['productImg']['name'] . "');";
        echo "</script>";
    }

    /* จบจัดการรูปภาพ*/

    $tcheck     = "SELECT * FROM PRODUCT WHERE (Product_id = '$pid')";
    echo $tcheck;

    $check  = $db_handle->Textquery($tcheck);

    if (empty($check)) {
        $tquery = "INSERT INTO PRODUCT VALUES ('$pid','$pname','$type','$unit',$cost,$price,$count,$low,$high,'$img','$detail','1')";
        echo $tquery;
        $insData    = $db_handle->Execquery($tquery);
        echo "<script type='text/javascript'>";
        echo "alert('สินค้ารหัส " . $pid . " ได้ถูกบันทึกข้อมูลแล้ว');";
        echo "window.location = 'product.php';";
        echo "</script>";
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('พบข้อมูลซ้ำซ้อน กรุณาตรวจสอบ');";
        echo "window.history.back();";
        echo "</script>";
    }
}

if ($st == 'D') {
    $pid        = $_GET["pid"];
    $img = "img/Product/" . $pid . ".jpg";

    if (substr($pid, 0, 2) != 'S0') {
        unlink($img); //ลบไฟล์เดิมก่อน    
    }

    $tquery = "DELETE FROM PRODUCT WHERE (Product_id = '$pid') AND (Product_id NOT LIKE 'S%')";
    $delData    = $db_handle->Execquery($tquery);
    echo "<script type='text/javascript'>";
    echo "alert('สินค้ารหัส " . $pid . " ได้ถูกลบข้อมูลแล้ว');";
    echo "window.location = 'product.php';";
    echo "</script>";
}

if ($st == 'V') {
    $pid        = $_POST["pid"];
    $pname      = $_POST["pname"];
    $type       = $_POST["ptype"];
    $price      = $_POST["pprice"];
    $count      = $_POST["pcount"];
    $unit       = $_POST["punit"];
    $cost       = $_POST["pcost"];
    $low        = $_POST["plow"];
    $high       = $_POST["phigh"];
    $detail     = $_POST["pdetail"];
    $img        = "img/Product/" . $pid . ".jpg";

    $tquery = "UPDATE PRODUCT SET 
        Product_name    = '$pname', 
        Product_type    = '$type', 
        Product_price   = '$price', 
        Product_cost    = '$cost', 
        Product_count   = '$count', 
        Product_low     = '$low', 
        Product_high    = '$high', 
        Product_unit    = '$unit',
        Product_detail  = '$detail'
    WHERE (Product_id = '$pid') ";
    $UpData    = $db_handle->Execquery($tquery);

    // Update รูปภาพ
    unlink($img); //ลบไฟล์เดิมก่อน    
    move_uploaded_file($_FILES['productImg']['tmp_name'], $img);

    echo "<script type='text/javascript'>";
    echo "alert('สินค้ารหัส " . $pid . " ได้ถูกปรับปรุงข้อมูลแล้ว');";
    echo "window.location = 'product.php';";
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