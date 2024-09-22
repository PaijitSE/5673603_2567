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
            <h3>จัดการข้อมูลสมาชิก</h3>
            <button onclick="insertClick();">เพิ่มสมาชิกใหม่</button>
        </div>

        <div class="work">
            <table class="memberTable">
                <tr>
                    <th>รหัสสมาชิก</th>
                    <th>ชื่อ-สกุล</th>
                    <th>วันเดือนปีเกิด</th>
                    <th>เบอร์โทรศัพท์</th>
                    <th>ดำเนินการ</th>
                </tr>
                <?php $data = $db_handle->Textquery("SELECT * FROM MEMBER");
                if (!empty($data)) {
                    foreach ($data as $key => $value) {
                        $mid = $data[$key]['Cust_id']; ?>
                        <tr>
                            <td><?php echo $data[$key]['Cust_id']; ?></td>
                            <td><?php echo $data[$key]['New_name']; ?></td>
                            <td><?php echo $data[$key]['Cust_birth']; ?></td>
                            <td><?php echo $data[$key]['Cust_tel']; ?></td>
                            <td><button class="b1" id="edit[<?php echo $key; ?>]" onclick="editClick(<?php echo $key; ?>);"
                                    cid="<?php echo $data[$key]['Cust_id']; ?>"
                                    pname="<?php echo $data[$key]['Cust_prename']; ?>"
                                    fname="<?php echo $data[$key]['Cust_firstname']; ?>"
                                    lname="<?php echo $data[$key]['Cust_lastname']; ?>"
                                    level="<?php echo $data[$key]['Cust_level']; ?>"
                                    tel="<?php echo $data[$key]['Cust_tel']; ?>"
                                    bdate="<?php echo $data[$key]['Cust_birth']; ?>"
                                    address="<?php echo $data[$key]['Cust_address']; ?>"
                                    un="<?php echo $data[$key]['Cust_UN']; ?>"
                                    pw="<?php echo $data[$key]['Cust_PW']; ?>"
                                    img="<?php echo $data[$key]['Cust_picture']; ?>">
                                    แก้ไข</button>
                                <button class="b2" onclick="return confirm('กรุณายืนยันการลบข้อมูล ? ** ห้ามลบข้อมูลเดิม! **')"><a href="memberProcess.php?st=D&cid=<?php echo $data[$key]['Cust_id']; ?>">ลบข้อมูล</a></button>
                            </td>
                        </tr>
                <?php }
                } else {
                    echo "<script type='text/javascript'>";
                    echo "alert('ไม่พบสมาชิกในปัจจุบัน...');";
                    echo "</script>";
                } ?>
            </table>
        </div>
    </div>

    <!-- พื้นที่ Modal -->
    <form action="memberProcess.php" method="post" enctype="multipart/form-data">
        <div id="info1" class="info_member">
            <div class="info_detail member">
                <h4 id="topicName">เพิ่มข้อมูลสมาชิกใหม่</h4>
                <div class="infoLeft">
                    <input type="text" id="st" name="st" hidden>
                    <div class="row">
                        <div class="col-3"><label>รหัสสมาชิก</label></div>
                        <div class="col-4"><input type="text" id="cid" name="cid" maxlength="5"></div>
                    </div>
                    <div class="row">
                        <div class="col-3"><label>คำนำหน้าชื่อ</label></div>
                        <div class="col-8"><input type="text" id="pname" name="pname"></div>
                    </div>
                    <div class="row">
                        <div class="col-3"><label>ชื่อ-นามสกุล</label></div>
                        <div class="col-4"><input type="text" id="fname" name="fname"></div>
                        <div class="col-4"><input type="text" id="lname" name="lname"></div>
                    </div>
                    <div class="row">
                        <div class="col-3"><label>ระดับสมาชิก</label></div>
                        <div class="col-8"><input type="text" id="level" name="level" maxlength="3"></div>
                    </div>
                    <div class="row">
                        <div class="col-3"><label>ที่อยู่</label></div>
                        <div class="col-8"><textarea rows="5" id="address" name="address">*****</textarea></div>
                    </div>
                    <div class="row">
                        <div class="col-3"><label>วันเดือนปีเกิด</label></div>
                        <div class="col-4"><input type="text" id="bdate" name="bdate"></div>
                    </div>
                    <div class="row">
                        <div class="col-3"><label>เบอร์โทรศัพท์</label></div>
                        <div class="col-4"><input type="text" id="tel" name="tel"></div>
                    </div>
                    <div class="row">
                        <div class="col-3"><label>User Name</label></div>
                        <div class="col-4"><input type="text" id="un" name="un" maxlength="5"></div>
                    </div>
                    <div class="row">
                        <div class="col-3"><label>Password</label></div>
                        <div class="col-4"><input type="text" id="pw" name="pw" maxlength="6"></div>
                    </div>


                </div>
                <div class="infoRight">
                    <p>รูปสมาชิก</p>
                    <p><img src="img/wait1.png" id="myImg"></p>
                    <p><input type="file" id="memberImg" name="memberImg" Class="btImg" accept="image/jpeg" onchange="imgSelected(this);"></p>
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
            document.getElementById("topicName").innerText = "เพิ่มข้อมูลสมาชิกใหม่";
            document.getElementById("st").value = 'A';
            document.getElementById("cid").value = '';
            document.getElementById("pname").value = '';
            document.getElementById("fname").value = '';
            document.getElementById("lname").value = '';
            document.getElementById("level").value = '';
            document.getElementById("address").value = '-';
            document.getElementById("bdate").value = '';
            document.getElementById("tel").value = '';
            document.getElementById("un").value = '';
            document.getElementById("pw").value = '';
            document.getElementById("myImg").src = 'img/wait1.png';
            document.getElementById("cid").removeAttribute("readonly");
            document.getElementById("un").removeAttribute("readonly");
            document.getElementById("pw").removeAttribute("readonly");
            document.getElementById("memberImg").setAttribute("required", true);
        }

        function cancelClick() {
            document.getElementById("info1").style.display = "none";
        }

        function editClick(k) {
            var data = document.getElementById("edit[" + k + "]");
            document.getElementById("info1").style.display = "flex";
            document.getElementById("topicName").innerText = "แก้ไขข้อมูลสมาชิก";
            document.getElementById("st").value = 'V';
            document.getElementById("cid").value = data.getAttribute("cid");
            document.getElementById("pname").value = data.getAttribute("pname");
            document.getElementById("fname").value = data.getAttribute("fname");
            document.getElementById("lname").value = data.getAttribute("lname");
            document.getElementById("level").value = data.getAttribute("level");
            document.getElementById("address").value = data.getAttribute("address");
            document.getElementById("bdate").value = data.getAttribute("bdate");
            document.getElementById("tel").value = data.getAttribute("tel");
            document.getElementById("un").value = data.getAttribute("un");
            document.getElementById("pw").value = data.getAttribute("pw");
            document.getElementById("myImg").src = data.getAttribute("img");
            document.getElementById("cid").setAttribute("readonly", false);
            document.getElementById("un").setAttribute("readonly", false);
            document.getElementById("pw").setAttribute("readonly", false);
            document.getElementById("memberImg").removeAttribute("required");

            //สำหรับตรวจสอบรูป
            var img = new Image();
            img.src = data.getAttribute("img");
            img.onload = () => {
                document.getElementById("myImg").src = data.getAttribute("img");
            };
            img.onerror = () => {
                document.getElementById("myImg").src = 'img/wait1.png';
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