<?php
session_start();
include('config.php');



if (isset($_REQUEST['reference'])) {
    $reference = $_REQUEST['reference'];

    $select_stmt = $db->prepare("SELECT * FROM receipts INNER JOIN course ON receipts.course_id = course.course_id INNER JOIN users ON receipts.user_id = users.user_id WHERE reference = :reference");
    $select_stmt->bindParam(':reference', $reference);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['reference'] = $reference;
    $_SESSION['course_id'] = $row['course'];
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['price'] = $row['price'];
    $_SESSION['amount'] = $row['amount'];
    $_SESSION['total_price'] = $row['total_price'];
    $_SESSION['company'] = $row['company'];
    $_SESSION['company_address'] = $row['company_address'];
    $_SESSION['company_phone'] = $row['company_phone'];
    $_SESSION['company_tax'] = $row['company_tax'];
    $_SESSION['date'] = $row['date'];
    $_SESSION['firstname'] = $row['firstname'];
    $_SESSION['lastname'] = $row['lastname'];
    $_SESSION['address'] = $row['address'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['phone'] = $row['phone'];

    header('location: edit_receipt.php');

}