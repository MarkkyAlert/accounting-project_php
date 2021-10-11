<?php
include('config.php');
session_start();

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $course_id = $_POST['course'];
    $price = $_POST['price'];
    $date = $_POST['date'];
    $user_id = $_SESSION['user_id'];
    $amount = $_POST['amount'];
    $company = $_POST['company'];
    $company_address = $_POST['company_address'];
    $company_phone = $_POST['company_phone'];
    $company_tax = $_POST['company_tax'];
    $total_price = $price * $amount;
    

    if (empty($price) || empty($date) || empty($course_id) || empty($amount)) {
        $_SESSION['err_fill'] = "กรุณากรอกข้อมูลให้ครบถ้วน";
        header('location: receipt_form.php');
    }

    else {
        $year = substr($date,0,4);
        $month = substr($date,5,2);
        $day = substr($date,8,2);

        $select_stmt = $db->prepare("SELECT receipt_id FROM receipts ORDER BY receipt_id DESC LIMIT 1");
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

        $reference = "RC-" . $year . $month . $day . $row['receipt_id'];

        $insert_stmt = $db->prepare("INSERT INTO receipts(reference, price, amount, total_price, date, course_id, user_id, company, company_address, company_phone, company_tax) VALUES (:reference, :price, :amount, :total_price, :date, :course_id, :user_id, :company, :company_address, :company_phone, :company_tax)");
        $insert_stmt->bindParam(':reference' , $reference);
        $insert_stmt->bindParam(':price', $price);
        $insert_stmt->bindParam(':amount', $amount);
        $insert_stmt->bindParam(':total_price', $total_price);
        $insert_stmt->bindParam(':date', $date);
        $insert_stmt->bindParam(':course_id', $course_id);
        $insert_stmt->bindParam(':user_id', $user_id);
        $insert_stmt->bindParam(':company', $company);
        $insert_stmt->bindParam(':company_address', $company_address);
        $insert_stmt->bindParam(':company_phone', $company_phone);
        $insert_stmt->bindParam(':company_tax', $company_tax);
        $insert_stmt->execute();

        if (!$insert_stmt) {
            $_SESSION['err_receipt'] = "นำเข้าข้อมูลไม่สำเร็จ";
            header('location: receipt_form.php');
        }
        else {
            header('location: show_receipt.php');
        }
    }

}