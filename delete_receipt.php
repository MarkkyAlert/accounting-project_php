<?php
session_start();
include('config.php');

if (isset($_REQUEST['reference'])) {
    $reference = $_REQUEST['reference'];

    $delete_stmt = $db->prepare("DELETE FROM receipts WHERE reference = :reference");
    $delete_stmt->bindParam(':reference', $reference);
    $delete_stmt->execute();

    if ($delete_stmt) {
        header('location: show_receipt.php');
    }
    else {
        $_SESSION['err_del'] = "ลบรายการไม่สำเร็จ";
    }
}