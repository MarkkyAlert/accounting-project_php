<?php
include('config.php');
session_start();

if (isset($_POST['submit'])) {
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $email = $_SESSION['email'];
    $phone = $_SESSION['phone'];
    $address = $_SESSION['address'];
    $course_id = $_POST['course'];
    $price = $_POST['price'];
    $date = $_POST['date'];
   
    $amount = $_POST['amount'];
    $company = $_POST['company'];
    $company_address = $_POST['company_address'];
    $company_phone = $_POST['company_phone'];
    $company_tax = $_POST['company_tax'];
    $reference = $_SESSION['reference'];
    $total_price = $price * $amount;
    
    

    if (empty($price) || empty($date) || empty($course_id) || empty($amount)) {
        $_SESSION['err_fill'] = "กรุณากรอกข้อมูลให้ครบถ้วน";
        header('location: receipt_form.php');
    }

    else {
        $year = substr($date,0,4);
        $month = substr($date,5,2);
        $day = substr($date,8,2);

        $update_stmt = $db->prepare("UPDATE receipts SET price = :price, amount = :amount, total_price = :total_price, date = :date, company = :company, company_address = :company_address, company_phone = :company_phone, company_tax = :company_tax WHERE reference = :reference");
        
        $update_stmt->bindParam(':price', $price);
        $update_stmt->bindParam(':amount', $amount);
        $update_stmt->bindParam(':total_price', $total_price);
        $update_stmt->bindParam(':date', $date);
        $update_stmt->bindParam(':reference', $reference);
        
        
        
        $update_stmt->bindParam(':company', $company);
        $update_stmt->bindParam(':company_address', $company_address);
        $update_stmt->bindParam(':company_phone', $company_phone);
        $update_stmt->bindParam(':company_tax', $company_tax);
        $update_stmt->execute();

        if (!$update_stmt) {
            $_SESSION['err_receipt'] = "นำเข้าข้อมูลไม่สำเร็จ";
            header('location: receipt_form.php');
        }
        else {
            header('location: show_receipt.php');
        }
    }

}