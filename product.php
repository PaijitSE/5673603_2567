<!DOCTYPE html>
<?php
session_start();
require_once('script/Myscript.php');
$db_handle = new myDBControl();

if (isset($_SESSION["flag"])) {
    if ($_SESSION["flag"] == '2') {
        $id    = $_SESSION["id"];
        $fname  = $_SESSION["fname"];
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('คุณไม่ได้เป็นเจ้าหน้าที่ !!!!');";
        echo "window.location = 'login.php';";
        echo "</script>";
    }
} else {
    echo "<script type='text/javascript'>";
    echo "alert('คุณไม่มีสิทธิ์เข้าทำงาน !!!!');";
    echo "window.location = 'login.php';";
    echo "</script>";
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
    <title>การจัดการข้อมูลสมาชิก (Member Management) </title>
    <link rel="stylesheet" href="css/myStyle.css">
    <link rel="stylesheet" href="css/adminStyle.css">
</head>

<body>
    <div class="adminHeader">
        <div class="headLeft">
            <img src="img/logo.png">
            <div class="title">
                <h4>SE-Store System</h4>
                <p>: ส่วนงานเจ้าหน้าที่</p>
            </div>
        </div>
        <div class="headRight">
            <p>สวัสดี, คุณเจ้าหน้าที่ <b><?php echo $fname; ?></b></p>
            <ul class="menubar">
                <li><b><a href="member.php">สมาชิก</a></b></li>
                <li> | </li>
                <li><b><a href="employee.php">พนักงาน</a></b></li>
                <li> | </li>
                <li><b><a href="product.php">สินค้า</a></b></li>
                <li> | </li>
                <li><b><a href="saleReport.php">รายงานการขาย</a></b></li>
                <li> | </li>
                <li><b><a href="login.php">ออกจากระบบ</a></b></li>
            </ul>
        </div>
    </div>

    <div class="main">
        <div class="topic">
            <h3>จัดการข้อมูลสินค้า</h3>
            <button onclick="insertClick();">เพิ่มสินค้าใหม่</button>
        </div>

        <div class="work">
            <table class="memberTable">
                <tr>
                    <th>รหัสสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>ประเภทสินค้า</th>
                    <th>ราคาต่อหน่วย</th>
                    <th>จำนวนในคลัง</th>
                    <th>ดำเนินการ</th>
                </tr>
                <?php $data = $db_handle->Textquery("SELECT * FROM ALLPRODUCT");
                if (!empty($data)) {
                    foreach ($data as $key => $value) {
                        $mid = $data[$key]['Product_id']; ?>
                        <tr>
                            <td><?php echo $data[$key]['Product_id']; ?></td>
                            <td><?php echo $data[$key]['Product_name']; ?></td>
                            <td><?php echo $data[$key]['New_type']; ?></td>
                            <td><?php echo $data[$key]['Product_price']; ?></td>
                            <td><?php echo $data[$key]['Product_count']; ?></td>
                            <td><button class="b1" id="edit[<?php echo $key; ?>]" onclick="editClick(<?php echo $key; ?>);"
                                    pid="<?php echo $data[$key]['Product_id']; ?>"
                                    pname="<?php echo $data[$key]['Product_name']; ?>"
                                    ptype="<?php echo $data[$key]['Product_type']; ?>"
                                    pprice="<?php echo $data[$key]['Product_price']; ?>"
                                    pcount="<?php echo $data[$key]['Product_count']; ?>"
                                    punit="<?php echo $data[$key]['Product_unit']; ?>"
                                    pcost="<?php echo $data[$key]['Product_cost']; ?>"
                                    plow="<?php echo $data[$key]['Product_low']; ?>"
                                    phigh="<?php echo $data[$key]['Product_high']; ?>"
                                    pdetail="<?php echo $data[$key]['Product_detail']; ?>"
                                    img="<?php echo $data[$key]['Product_picture']; ?>">
                                    แก้ไข</button>
                                <button class="b2" onclick="return confirm('กรุณายืนยันการลบข้อมูล ? ** ห้ามลบข้อมูลเดิม! **')"><a href="productProcess.php?st=D&pid=<?php echo $data[$key]['Product_id']; ?>">ลบข้อมูล</a></button>
                            </td>
                        </tr>
                <?php }
                } else {
                    echo "<script type='text/javascript'>";
                    echo "alert('ไม่พบข้อมูลสินค้าในปัจจุบัน...');";
                    echo "</script>";
                } ?>
            </table>
        </div>
    </div>

    <!-- พื้นที่ Modal -->
    <form action="productProcess.php" method="post" enctype="multipart/form-data">
        <div id="info1" class="info_member">
            <div class="info_detail product">
                <h4 id="topicName">เพิ่มรายการสินค้าใหม่</h4>
                <div class="infoLeft">
                    <input type="text" id="st" name="st" hidden>
                    <div class="row">
                        <div class="col-4"><label>รหัสสินค้า</label></div>
                        <div class="col-4"><input type="text" id="pid" name="pid" maxlength="3"></div>
                    </div>
                    <div class="row">
                        <div class="col-4"><label>ชื่อสินค้า</label></div>
                        <div class="col-8"><input type="text" id="pname" name="pname"></div>
                    </div>
                    <div class="row">
                        <div class="col-4"><label>ประเภทสินค้า</label></div>
                        <div class="col-8"><input type="text" id="ptype" name="ptype"></div>
                    </div>
                    <div class="row">
                        <div class="col-4"><label>ราคาต้นทุน</label></div>
                        <div class="col-4"><input type="number" id="pcost" name="pcost"></div>
                    </div>
                    <div class="row">
                        <div class="col-4"><label>ราคาขาย</label></div>
                        <div class="col-4"><input type="number" id="pprice" name="pprice"></div>
                    </div>
                    <div class="row">
                        <div class="col-4"><label>จำนวนในคลัง</label></div>
                        <div class="col-4"><input type="number" id="pcount" name="pcount"></div>
                    </div>
                    <div class="row">
                        <div class="col-4"><label>หน่วยนับ</label></div>
                        <div class="col-4"><input type="text" id="punit" name="punit" maxlength="13"></div>
                    </div>
                    <div class="row">
                        <div class="col-4"><label>จำนวนต่ำสุด</label></div>
                        <div class="col-4"><input type="number" id="plow" name="plow"></div>
                    </div>
                    <div class="row">
                        <div class="col-4"><label>จำนวนสูงสุด</label></div>
                        <div class="col-4"><input type="number" id="phigh" name="phigh"></div>
                    </div>
                    <div class="row">
                        <div class="col-4"><label>รายละเอียด</label></div>
                        <div class="col-8"><textarea rows="5" id="pdetail" name="pdetail">-</textarea></div>
                    </div>

                </div>
                <div class="infoRight">
                    <p>รูปสินค้า</p>
                    <p><img src="img/wait3.png" id="myImg"></p>
                    <p><input type="file" id="productImg" name="productImg" Class="btImg" accept="image/jpeg" onchange="imgSelected(this);"></p>
                    <!-- <p><button class="btImg">อัปโหลดรูป</button></p> -->
                    <button class="btInsert" type="submit">บันทึกข้อมูล</button>
                    <button class="btCancel" type="reset" onclick="cancelClick();">ยกเลิก</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        function insertClick() {
            document.getElementById("info1").style.display = "flex";
            document.getElementById("topicName").innerText = "เพิ่มรายการสินค้าใหม่";
            document.getElementById("st").value = 'A';
            document.getElementById("pid").value = '';
            document.getElementById("pname").value = '';
            document.getElementById("ptype").value = '';
            document.getElementById("pprice").value = '';
            document.getElementById("pcount").value = '';
            document.getElementById("punit").value = '-';
            document.getElementById("pcost").value = '-';
            document.getElementById("plow").value = '-';
            document.getElementById("phigh").value = '-';
            document.getElementById("pdetail").value = '-';
            document.getElementById("myImg").src = 'img/wait3.png';
            document.getElementById("pid").removeAttribute("readonly");
            document.getElementById("productImg").setAttribute("required", true);
        }

        function cancelClick() {
            document.getElementById("info1").style.display = "none";
        }

        function editClick(k) {
            var data = document.getElementById("edit[" + k + "]");
            document.getElementById("info1").style.display = "flex";
            document.getElementById("topicName").innerText = "ปรับปรุงรายการสินค้า";
            document.getElementById("st").value = 'V';
            document.getElementById("pid").value = data.getAttribute("pid");
            document.getElementById("pname").value = data.getAttribute("pname");
            document.getElementById("ptype").value = data.getAttribute("ptype");
            document.getElementById("pprice").value = data.getAttribute("pprice");
            document.getElementById("pcount").value = data.getAttribute("pcount");
            document.getElementById("punit").value = data.getAttribute("punit");
            document.getElementById("pcost").value = data.getAttribute("pcost");
            document.getElementById("plow").value = data.getAttribute("plow");
            document.getElementById("phigh").value = data.getAttribute("phigh");
            document.getElementById("pdetail").value = data.getAttribute("pdetail");
            document.getElementById("productImg").removeAttribute("required");

            //สำหรับตรวจสอบรูป
            var img = new Image();
            img.src = data.getAttribute("img");
            img.onload = () => {
                document.getElementById("myImg").src = data.getAttribute("img");
            };
            img.onerror = () => {
                document.getElementById("myImg").src = 'img/wait3.png';
            }
        }

        function imgSelected(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById("myImg").src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</body>

</html>