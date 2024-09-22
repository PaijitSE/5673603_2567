<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch&display=swap" rel="stylesheet">
    <title>งานตรวจสอบสิทธิ์</title>
    <link rel="stylesheet" href="css\login.css">
</head>

<body>
    <div class="main">
        <div class="sleft">
            <form action="loginProcess.php" method="post" enctype="multipart/form-data">
                <p class="htxt">ยินดีต้อนรับ</p>
                <p class="txt1">ชื่อเข้าใช้ระบบ/e-mail</p>
                <input type="text" class="itxt" name="Uname" value="E0001">
                <p class="txt1">รหัสผ่าน</p>
                <input type="password" class="itxt" name="Passwd" value="qwerty">
                <p class=" ichk"><input type="checkbox" name="" id=""> ลืมรหัสผ่าน ?</p>
                <button type="submit">Login</button>
                <p class="txt2">ต้องการสมัครสมาชิกใหม่, คลิก!</p>
            </form>
        </div>
        <div class="sright" ><img src="img/post2.jpg" alt="" onclick="window.location='index.php';"></div>
    </div>
</body>

</html>