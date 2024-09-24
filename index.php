<!DOCTYPE html>
<html lang="en">

<?php
require_once('script/Myscript.php');
$db_handle = new myDBControl();

$tsearch = '';
if (isset($_GET['search'])) {
    $k = $_GET['search'];
    $tsearch = ' WHERE (Product_name LIKE "%' . $k . '%") OR 
    (Type_no LIKE "' . $k . '")';
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5673603 Software Construction & Evolution</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/myStyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="body">
    <!-- <h6>ส่วนที่ 1 : ธนากร</h6> -->
    <div class="section1">
        <div class="main">
            <img src="img/logo.png">
            <div class="title">
                SE-Store System
            </div>
        </div>
        <ul class="menubar">
            <li>
                <a href="index.php">หน้าหลัก</a>
            </li>
            <li> | </li>
            <li><a href="login.php">เข้าสู่ระบบ</a></li>
        </ul>
    </div>
    <!-- <h6>ส่วนที่ 2 : กันติศา & อธิศ</h6> -->
    <div class="section0">
        <div id="demo" class="carousel slide section2" data-bs-ride="carousel">
            <!-- Indicators/dots -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>
            </div>

            <!-- The slideshow/carousel -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/banner1.png" class="rounded-4" alt="" class="d-block" style="width:100%">
                </div>
                <div class="carousel-item">
                    <img src="img/banner2.png" class="rounded-4" alt="" class="d-block" style="width:100%">
                </div>
                <div class="carousel-item">
                    <img src="img/banner3.png" class="rounded-4" alt="" class="d-block" style="width:100%">
                </div>
                <div class="carousel-item">
                    <img src="img/banner4.png" class="rounded-4" alt="" class="d-block" style="width:100%">
                </div>
            </div>

            <!-- Left and right controls/icons -->
            <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
        <!-- <h6>ส่วนที่ 3 : คุณาวุฒิ</h6> -->
        <div class="section3">
            <h6>สินค้าขายดี / สินค้าแนะนำ</h6>
            <div class="productRecommend">

                <!-- ค้นหาข้อมูล และรับข้อมูล -->
                <?php
                $data = $db_handle->Textquery("SELECT * FROM PRODUCT_RECOMMEND");
                ?>

                <!-- แสดงข้อมูล -->
                <?php for ($x = 0; $x <= 4; $x++) {
                ?>
                    <div class="productBox">
                        <img src="<?php echo $data[$x]['Product_picture']; ?>">
                        <p><?php echo number_format($data[$x]['Product_price']); ?> บาท</p>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- ส่วนที่ 4 : สุทธิดา </h5> -->
        <div class="section4">
            <div class="SLeft">
                <input type="text" placeholder="ระบุคำค้น" id="keyword">
                <button name="act" onclick="searchClick()">Search</button>
            </div>
            <div class="SRight">
                <?php $Typedetail = $db_handle->Textquery("SELECT * FROM PRODUCT_TYPE;") ?>
                <select id="Stype" onchange="searchType()">
                    <?php if (empty($Typedetail)) { ?>
                        <option value="T0" selected>ไม่มีประเภทสินค้า</option>
                    <?php } else { ?>
                        <option value="T0" selected>เลือกประเภทสินค้า</option>
                        <?php foreach ($Typedetail as $key => $value) { ?>
                            <option value="<?php echo $Typedetail[$key]["Type_no"]; ?>">
                                <?php echo $Typedetail[$key]["Type_name"]; ?></option>
                    <?php }
                    } ?>
                </select>
            </div>
        </div>
        <!-- <h6>ส่วนที่ 5 : พุฒินาท</h6> -->
        <div class="section5">
            <?php
            $data = $db_handle->Textquery("SELECT * FROM ALLPRODUCT" . $tsearch);

            if (empty($data)) {
                echo "<p class='tErr'>--- ขณะนี้..ไม่พบสินค้าที่ท่านค้นหา ---</p>";
                $data = $db_handle->Textquery("SELECT * FROM ALLPRODUCT");
            } ?>
            <div class="product">

                <?php
                foreach ($data as $key => $value) {
                ?>
                    <div class="productBox boxSize_M">
                        <img class="productImg" src="<?php echo $data[$key]['Product_picture']; ?>">
                        <div class=" productTxt">
                            <h6><b>รหัสสินค้า </b><?php echo $data[$key]['Product_id']; ?></b></h6>
                            <p><b>Type : </b><?php echo $data[$key]['New_type']; ?> </b></p>
                            <p><b>Name : </b><?php echo $data[$key]['New_name']; ?>....</b></p>
                            <p><b>Price : </b><?php echo number_format($data[$key]['Product_price'], 2); ?></p>
                            <button onclick="alert('ฉันเลือกซื้อสินค้ารายการนี้....');window.location='cart.php?pid=<?php echo $data[$key]['Product_id']; ?>';">เลือกซื้อ</button>
                        </div>
                    </div>
                <?php }
                ?>
            </div>
        </div>
    </div><!-- container -->

    <script>
        function searchClick() {
            let kword = document.getElementById('keyword').value;
            window.location = 'index.php?search=' + kword;
        }

        function searchType() {
            var kword = document.getElementById('Stype').value;
            window.location = 'index.php?search=' + kword;
            //console.log('type id = '+kword);
        }
    </script>

</body>

</html>