<?php

class myDBControl
{
    /*กำหนดตัวแปรเกี่ยวกับการติดต่อฐานข้อมูล*/
    private $host = "localhost";
    private $user = "x";
    private $password = "x";
    private $database = "SEStoreDB_5673603";
    private $conn;

    /*ฟังก์ชันหลัก สำหรับกำหนดค่าเริ่มต้นก่อนใช้งาน*/
    function __construct()
    {
        $this->conn = $this->connectDB();
    }

    /*ฟังก์ชัน สำหรับติดต่อฐานข้อมูล*/
    function connectDB()
    {
        $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        return $conn;
    }

    /*ฟังก์ชัน สำหรับสืบค้นข้อมูล รับประโยคคำสั่งผ่าน $query*/
    function Textquery($query)
    {
        $result = mysqli_query($this->conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $resultset[] = $row;
        }
        /* ส่งผลลัพธ์กลับ */
        if (!empty($resultset)) {
            return $resultset;
        }
    }

    /*ฟังก์ชัน สำหรับประมวลผลคำสั่ง INSERT UPDATE DELETE */
    function Execquery($query)
    {
        mysqli_query($this->conn, $query) or die($this->error);
        return true;
    }
}
