<!DOCTYPE html>
<?php
session_start();
require_once('script/Myscript.php');
$db_handle = new myDBControl();

if (isset($_SESSION["flag"])) {
    if ($_SESSION["flag"] == '3') {
        $id    = $_SESSION["id"];
        $fname  = $_SESSION["fname"];
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('คุณไม่ได้เป็นผู้บริหาร !!!!');";
        echo "window.location = 'login.php';";
        echo "</script>";
    }
} else {
    echo "<script type='text/javascript'>";
    echo "alert('คุณไม่มีสิทธิ์เข้าดูรายงาน !!!!');";
    echo "window.location = 'login.php';";
    echo "</script>";
}
$date = '';
$tsearch = '';
if (isset($_GET['date']) && $_GET['date'] != '') {
    $date = $_GET['date'];
    $tsearch = "WHERE (Order_date LIKE '%$date')";
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>รายงานการขายสินค้า (Sale Report) </title>
    <link rel="stylesheet" href="css/myStyle.css">
    <link rel="stylesheet" href="css/adminStyle.css">
    <link rel="stylesheet" href="css/masterStyle.css">
</head>

<body>
    <div class="adminHeader master">
        <div class="headLeft">
            <img src="img/logo.png">
            <div class="title">
                <h4>SE-Store System</h4>
                <p>: ส่วนงานผู้บริหาร</p>
            </div>
        </div>
        <div class="headRight">
            <p>สวัสดี, คุณผู้บริหาร : <b><?php echo $fname; ?></b></p>
            <ul class="menubar">
                <li><b><a href="saleReport.php">รายงานการขายสินค้า</a></b></li>
                <li> | </li>
                <li><b><a href="purchaseReport.php">รายงานการซื้อเข้าคลัง</a></b></li>
                <li> | </li>
                <li><b><a href="login.php">ออกจากระบบ</a></b></li>
            </ul>
        </div>
    </div>

    <div class="main">
        <div class="reportHead">
            <div class="company">
                <img src="img/logo.png"><label>บริษัท SE-Store จำกัด</label>
                <p>รายงานการสั่งซื้อเข้าคลังสินค้า <?php if ($date != '') {
                                                        echo ": ประจำเดือน " . $date;
                                                    } ?></p>
            </div>
        </div>

        <div class="area">
            <table class="saleTable">
                <thead>
                    <tr>
                        <th>เลขที่ใบส่งของ</th>
                        <th>วันที่ใบส่งของ</th>
                        <th>ชื่อผู้ค้า</th>
                        <th>จำนวนซื้อ</th>
                        <th>รวมเงิน</th>
                        <th>รวมสุทธิ</th>
                    </tr>
                </thead>
                <?php
                $total = 0;
                $flag = 0;
                $data = $db_handle->Textquery("SELECT * FROM ORDERS " . $tsearch . " ORDER BY RIGHT(Order_date,4) DESC, SUBSTR(Order_date,4,2) DESC, LEFT(Order_date,2) DESC");
                if (!empty($data)) {
                    foreach ($data as $key => $value) { ?>
                        <tr>
                            <td><button onclick="invPrint(this);"><?php echo $data[$key]['Order_no']; ?></button></td>
                            <td><?php echo $data[$key]['Order_date']; ?></td>
                            <td>x</td>
                            <td>x</td>
                            <td>x</td>
                            <td>x</td>
                            </td>
                        </tr>
                <?php
                        $total = $total + 0.00;
                    }
                } else {
                    $flag = 1;
                } ?>
            </table>
            <?php
            if ($flag == 1) { ?>

                <div class="notFound">
                    <p>ไม่พบข้อมูลรายการสั่งซื้อเข้าคลังสินค้าในวันดังกล่าว !</p>
                </div>
            <?php } ?>
        </div>
        <div class="footer">
            <div class="search">
                เลือกเดือน/ปี
                <input type="text" name="date" id="date" placeholder="mm/yyyy">
                <button onclick="dateClick();">ค้นหา</button>
            </div>
            <div class="sum">
                ยอดขายรวมทั้งสิ้น <input type="text" value="<?php echo number_format($total, 2); ?>" readonly> บาท
            </div>
        </div>
    </div>
    <script>
        function dateClick() {
            Tdate = document.getElementById('date').value;
            window.location = 'purchaseReport.php?date=' + Tdate;
        }

        function invPrint(e) {
            var Oid = e.innerText;
            alert('เตรียมพิมพ์ใบส่งของเลขที่ ' + Oid);
            // window.location = 'orders.php?Oid=' + Oid;
        }
    </script>
</body>

</html>