<?php session_start(); ?>
<!DOCTYPE html>
<!-- พื้นที่สำหรับประกาศการใช้ Script เพื่อจัดการฐานข้อมูล -->
<?php
require_once('script/Myscript.php');
$db_handle = new myDBControl();

if (isset($_SESSION["flag"])) {
    if ($_SESSION["flag"] == '1') {
        $id    = $_SESSION["id"];
        $fname  = $_SESSION["fname"];
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('คุณไม่ได้เป็นสมาชิก !!!!');";
        echo "window.location = 'login.php';";
        echo "</script>";
    }
} else {
    echo "<script type='text/javascript'>";
    echo "alert('คุณไม่มีสิทธิ์เข้าใช้งาน !!!!');";
    echo "window.location = 'login.php';";
    echo "</script>";
}

// รับค่าตัวแปรสินค้าที่เลือก
if (isset($_GET['pid'])) {
    $Proid  = $_GET['pid'];
} else {
    $Basket_Data = $db_handle->Textquery("SELECT * FROM BASKET_DETAIL WHERE Cust_id = '$id' LIMIT 1");
    $Proid  = $Basket_Data[0]["Product_id"];
    if (empty($Basket_Data)) {
        $Proid = 'S01';
    }
    $No     = 1;
}

?>

<html lang="en">
<!-- พื้นที่สำหรับประกาศแหล่งอ้างอิง เช่น การมาตรฐาน Html, fonts, css, images เป็นต้น-->
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>การจัดการตะกร้าสินค้า (my Cart Management) </title>
    <link rel="stylesheet" href="css/myStyle.css">
    <link rel="stylesheet" href="css/memberStyle.css">
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body>
    <div class="adminHeader">
        <div class="headLeft">
            <img src="img/logo.png">
            <div class="title">
                <h4>SE-Store System</h4>
                <p>: ส่วนงานสมาชิก</p>
            </div>
        </div>
        <div class="headRight">
            <p>สวัสดี, คุณสมาชิก : <b><?php echo $fname; ?></b></p>
            <ul class="menubar">
                <li><b><a href="profile.php">ข้อมูลส่วนตัว</a></b></li>
                <li> | </li>
                <li><b><a href="cart.php">ตะกร้าสินค้า</a></b></li>
                <li> | </li>
                <li><b><a href="login.php">ออกจากระบบ</a></b></li>
            </ul>
        </div>
    </div>

    <div class="main">
        <div class="info_cart">
            <!--Zone : 1.Display Product data when selected -->
            <div class="cartLeft">
                <?php
                $data = $db_handle->Textquery("SELECT *,CONCAT(Left(Product_detail,160),'...') AS Prolist FROM PRODUCT INNER JOIN PRODUCT_TYPE ON (PRODUCT.Product_type=PRODUCT_TYPE.Type_no) WHERE Product_id= '$Proid'");
                if (!empty($data)) { ?>
                    <!-- 3.1.1 แสดงสินค้าใน กล่องพื้นที่ -->
                    <form action="#?work=A" method="post" enctype="multipart/form-data">
                        <h5>รหัสสินค้า : <?php echo $data[0]["Product_id"]; ?></h5>
                        <img src="<?php echo $data[0]["Product_picture"]; ?>">
                        <div class="cardGrid">
                            <input type="text" value="<?php echo $data[0]["Product_id"]; ?>" name="pid" hidden>
                            <input type="text" value="<?php echo $id; ?>" name="cid" hidden>
                            <p><b>ชื่อสินค้า : </b></p>
                            <p><?php echo $data[0]["Product_name"]; ?></p>
                            <p><b>ประเภทสินค้า :</b> </p>
                            <p><?php echo $data[0]["Type_name"]; ?></p>
                            <p><b>ราคาขาย : </b></p>
                            <p><?php echo $data[0]["Product_price"]; ?></p>
                            <p><b>จำนวนคงเหลือ : </b></p>
                            <p>
                                <?php echo $data[0]["Product_count"] . " " . $data[0]["Product_unit"]; ?>
                            </p>
                            <p><b>รายละเอียด : </b></p>
                            <p>
                                <?php echo $data[0]["Prolist"]; ?>
                            </p>

                            <p><b>จำนวนซื้อ : </b></p>
                            <p>
                                <input type="number" class="form-control-sm" name="Pnum" value="1" min="1" max="<?php echo $data[0]["Product_count"]; ?>">
                            </p>

                        </div>
                        <button type="submit">เก็บลงตระกร้า</button>
                    </form>
                <?php } /*end-if !empty */ ?>
            </div>

            <!-- Zone : 2.Display image -->
            <div class="cartRight">
                <div class="cartHead">
                    <h4>ตะกร้าสินค้า</h4>
                    <button onclick="window.location='index.php';">ซื้อเพิ่ม</button>
                </div>

                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="cartDetail">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>รหัส</th>
                                    <th>รายการ</th>
                                    <th>ราคา</th>
                                    <th>จำนวน</th>
                                    <th>รวมเงิน</th>
                                    <th>ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $Basket = $db_handle->Textquery("SELECT B.*, CONCAT(Left(Product_name,18),'...') AS Product_name, Product_picture FROM BASKET_DETAIL B INNER JOIN PRODUCT P ON (B.Product_id = P.Product_id) WHERE Cust_id = '$Uid'");
                                if (!empty($Basket)) {
                                    $total = 0;
                                    $count = 0;
                                    foreach ($Basket as $key => $value) {
                                        $count++;
                                        $total += ($Basket[$key]["Product_price"] * $Basket[$key]["Product_num"]);
                                ?>
                                        <tr>
                                            <td><img src="<?php echo $Basket[$key]["Product_picture"]; ?>"></td>
                                            <td><?php echo $Basket[$key]["Product_id"]; ?></td>
                                            <td><?php echo $Basket[$key]["Product_name"]; ?></td>
                                            <td><?php echo number_format($Basket[$key]["Product_price"]); ?></td>
                                            <td><?php echo $Basket[$key]["Product_num"]; ?></td>
                                            <td><?php echo number_format($Basket[$key]["Product_price"] * $Basket[$key]["Product_num"]) ?></td>
                                            <td><a href="#?work=D&Pid=<?php echo $Basket[$key]["Product_id"]; ?>" onclick="return confirm('กรุณายืนยันการลบข้อมูล ?')" role="button">X</a></td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="8" class="text-center">- No Data -</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="cartSummary">
                        <p><b>Total</b></p>
                        <p><?php echo $count; ?> หน่วย</p>
                        <p><b><?php echo number_format($total, 2); ?> บาท</b></p>
                    </div>

                    <div class="cartConfirm">
                        <label>ส่วนลด</label><input type="number" name="" value="0.00">
                        <label>ภาษีมูลค่าเพิ่ม</label><input type="number" name="" value="0.00">
                        <label>รวมทั้งสิ้น</label><input type="number" class="total" name="" value="0.00">

                        <label>บริษัทขนส่ง : </label></b>
                        <select name="Tbank">
                            <option value="1" selected>Kerry Express</option>
                            <option value="2">J&T Express</option>
                            <option value="3">Flash Express</option>
                            <option value="4">Shopee Express</option>
                            <option value="5">Thailand Post (ปณท)</option>
                        </select>

                        <label>ช่องทางชำระเงิน : </label>
                        <select name="Tpay">
                            <option value="1">ชำระเงินโอนบัญชี</option>
                            <option value="2">ชำระเงินปลายทาง</option>
                        </select>
                    </div>
                    <button type="submit"><b>ยืนยันการสั่งซื้อสินค้า</b></button>
                </form>
            </div>
        </div>
        <!--end-infocart -->
    </div>
</body>

</html>