<?php
session_start();
include('config.php');

if (isset($_POST['submit'])) {
    $price = (int)$_POST['price'];
    $amount = (int)$_POST['amount'];
    $date = $_POST['date'];
    $course_id = $_POST['course'];
    $total_price = $price * $amount;
    $month_id = substr($date, 5, 2);


    if ($month_id == "01") {
        $month_id = 1;
    } else if ($month_id == "02") {
        $month_id = 2;
    } else if ($month_id == "03") {
        $month_id = 3;
    } else if ($month_id == "04") {
        $month_id = 4;
    } else if ($month_id == "05") {
        $month_id = 5;
    } else if ($month_id == "06") {
        $month_id = 6;
    } else if ($month_id == "07") {
        $month_id = 7;
    } else if ($month_id == "08") {
        $month_id = 8;
    } else if ($month_id == "09") {
        $month_id = 9;
    } else if ($month_id == "10") {
        $month_id = 10;
    } else if ($month_id == "11") {
        $month_id = 11;
    } else if ($month_id == "12") {
        $month_id = 12;
    }

    if (empty($price) || empty($amount) || empty($date)) {
        $_SESSION['err_fill'] = "กรุณากรอกข้อมูลให้ครบถ้วน";
        header('location: receive_form.php');
    } else {

        $insert_stmt = $db->prepare("INSERT INTO receives(course_id, price, total_price, amount, date, month_id) VALUES (:course_id, :price, :total_price, :amount, :date, :month_id)");
        $insert_stmt->bindParam(':course_id', $course_id);
        $insert_stmt->bindParam(':price', $price);
        $insert_stmt->bindParam(':total_price', $total_price);
        $insert_stmt->bindParam(':amount', $amount);
        $insert_stmt->bindParam(':date', $date);
        $insert_stmt->bindParam(':month_id', $month_id);
        $insert_stmt->execute();

        if (!$insert_stmt) {
            $_SESSION['err_receive'] = "นำเข้าข้อมูลไม่สำเร็จ";
            header('location: receive_form.php');
        } else {
            $date = date("d-m-Y", strtotime($date));
                        $day = substr($date, 0, 2);
                        $year = substr($date, 6);
                        $month = substr($date, 3, 2);
                        if ($month == "01") {
                            $month = "ม.ค.";
                        } else if ($month == "02") {
                            $month = "ก.พ.";
                        } else if ($month == "03") {
                            $month = "มี.ค.";
                        } else if ($month == "04") {
                            $month = "เม.ย.";
                        } else if ($month == "05") {
                            $month = "พ.ค.";
                        } else if ($month == "06") {
                            $month = "มิ.ย.";
                        } else if ($month == "07") {
                            $month = "ก.ค.";
                        } else if ($month == "08") {
                            $month = "ส.ค.";
                        } else if ($month == "09") {
                            $month = "ก.ย.";
                        } else if ($month == "10") {
                            $month = "ต.ค.";
                        } else if ($month == "11") {
                            $month = "พ.ย.";
                        } else if ($month == "12") {
                            $month = "ธ.ค.";
                        }
            define('LINE_API', "https://notify-api.line.me/api/notify");
            function notify_message($message, $token)
            {
                $queryData = array('message' => $message);
                $queryData = http_build_query($queryData, '', '&');
                $headerOptions = array(
                    'http' => array(
                        'method' => 'POST',
                        'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                            . "Authorization: Bearer " . $token . "\r\n"
                            . "Content-Length: " . strlen($queryData) . "\r\n",
                        'content' => $queryData
                    ),
                );
                $context = stream_context_create($headerOptions);
                $result = file_get_contents(LINE_API, FALSE, $context);
                $res = json_decode($result);
                return $res;
            }
            $token = "HxkFwynKvGJsiw1F0vfkeidgBJMDQGQXqPK8LS7qFy9"; //ใส่Token ที่copy เอาไว้
            $str = "ยอดขาย " . $day . " " . $month . " " . $year . " รวม: " . $total_price . " บาท"; //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร

            $res = notify_message($str, $token);
            print_r($res);
            
            $select_stmt = $db->prepare("SELECT SUM(total_price) AS income FROM receives WHERE month_id = :month_id;");
            $select_stmt->bindParam(':month_id', $month_id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            $update_stmt = $db->prepare("UPDATE months SET income = :income WHERE month_id = :month_id");
            $update_stmt->bindParam(':income', $row['income']);
            $update_stmt->bindParam(':month_id', $month_id);
            $update_stmt->execute();

            if ($update_stmt) {
                header('location: index.php');
            } else {
                $_SESSION['err_receive'] = "นำเข้าข้อมูลไม่สำเร็จ";
            }
        }
    }
}
