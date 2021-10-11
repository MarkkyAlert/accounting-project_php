<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include('config.php');
if (!isset($_SESSION['is_logged_in'])) {
    header('location: login.php');
}
if (isset($_REQUEST['delete_id'])) {
    $receive_id = $_REQUEST['delete_id'];

    $select_stmt = $db->prepare("SELECT * FROM receives WHERE receive_id = :receive_id");
    $select_stmt->bindParam(':receive_id', $receive_id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    $total_price = $row['total_price'];
    $month_id = substr($row['date'], 5, 2);


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

    $delete_stmt = $db->prepare("DELETE FROM receives WHERE receive_id = :receive_id");
    $delete_stmt->bindParam(':receive_id', $receive_id);
    $delete_stmt->execute();

    $select_stmt = $db->prepare("SELECT * FROM months WHERE month_id = :month_id");
    $select_stmt->bindParam(':month_id', $month_id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    $income = $row['income'] - $total_price;


    $update_stmt = $db->prepare("UPDATE months SET income = :income WHERE month_id = :month_id");
    $update_stmt->bindParam(':income', $income);
    $update_stmt->bindParam(':month_id', $month_id);
    $update_stmt->execute();


    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="img/png" href="shop.png">
    <title>หน้าแรก</title>
</head>

<body>
    <!-- Navbar -->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <!-- Container wrapper -->
        <div class="container">
            <!-- Toggle button -->
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Navbar brand -->
                <a class="navbar-brand mt-2 mt-lg-0" href="index.php">
                    <img src="shop.png" style="width: 30px;">
                    MARKPRUET
                </a>
            </div>

            <!-- Right elements -->
            <div class="d-flex align-items-center">
                <a class="me-4 link-custom" href="account_menu.php">
                    <img src="accounts.png" alt="" style="width: 25px;"> บัญชี
                </a>
                <!-- Icon -->
                <a class=" me-4 link-custom" href="receipt_menu.php">
                    <img src="bill.png" style="width: 25px;"> ใบเสร็จ
                </a>

                <a class=" me-4 link-custom" href="certificate.php">
                    <img src="medal.png" style="width: 25px;"> Certificate
                </a>

                <a class=" me-4 link-custom" href="logout.php">
                    <img src="logout.png" style="width: 25px;"> ออกจากระบบ
                </a>
                <!-- Avatar -->

            </div>
            <!-- Right elements -->
        </div>

        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->

    <div class="container">

        <h2 class="text-center mt-5 mb-5">บัญชีรายรับทั้งหมด</h2>

        <?php
        $select_stmt = $db->prepare("SELECT * FROM receives INNER JOIN course ON receives.course_id = course.course_id ORDER BY receive_id DESC");
        $select_stmt->execute();
        ?>

        <div class="row">
            <?php foreach ($select_stmt as $row) { ?>
                <div class="col-md-3 mb-5">
                    <div class="card border border-info shadow-5 mb-3">
                        <?php
                        $date = date("d-m-Y", strtotime($row['date']));
                        $day = substr($date, 0, 2);
                        $year = substr($date, 6);
                        $month = substr($date, 3, 2);
                        if ($month == "01") {
                            $month = "Jan";
                        } else if ($month == "02") {
                            $month = "Feb";
                        } else if ($month == "03") {
                            $month = "Mar";
                        } else if ($month == "04") {
                            $month = "Apr";
                        } else if ($month == "05") {
                            $month = "May";
                        } else if ($month == "06") {
                            $month = "Jun";
                        } else if ($month == "07") {
                            $month = "Jul";
                        } else if ($month == "08") {
                            $month = "Aug";
                        } else if ($month == "09") {
                            $month = "Sep";
                        } else if ($month == "10") {
                            $month = "Oct";
                        } else if ($month == "11") {
                            $month = "Nov";
                        } else if ($month == "12") {
                            $month = "Dec";
                        }
                        ?>
                        <h5 class="card-header text-center"><?php echo $day . " " . $month . " " . $year; ?></h5>
                        <div class="card-body">

                            <p class="card-text"><b>คอร์ส</b> <?php echo $row['course_name']; ?></p>
                            <p class="card-text"><b>ราคาต่อคอร์ส</b> <?php echo $row['price'] . " ฿"; ?></p>
                            <p class="card-text"><b>จำนวน</b> <?php echo $row['amount']; ?></p>
                            <p class="card-text"><b>รวม</b> <b class="text-danger"><?php echo number_format($row['total_price']) . " ฿"; ?></b></p>

                        </div>
                        <div class="modal fade" id="exampleModal<?php echo $row['receive_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Alert</h5>
                                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">คุณต้องการลบรายการนี้หรือไม่</div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-mdb-dismiss="modal">
                                            No
                                        </button>
                                        <a href="?delete_id=<?php echo $row['receive_id']; ?>" class="btn btn-info">Yes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="" class="btn btn-danger" data-mdb-toggle="modal" data-mdb-target="#exampleModal<?php echo $row['receive_id']; ?>">ลบ</a>
                    </div>

                </div>
            <?php } ?>

        </div>

    </div>
    <!-- Button trigger modal -->


    <!-- Modal -->


    <footer class="bg-dark text-center text-white mt-5">
        <!-- Grid container -->
        <div class="container p-4 pb-0">
            <!-- Section: Social media -->
            <section class="mb-4">
                <!-- Facebook -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-facebook-f"></i></a>

                <!-- Twitter -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-twitter"></i></a>

                <!-- Google -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-google"></i></a>

                <!-- Instagram -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-instagram"></i></a>

                <!-- Linkedin -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-linkedin-in"></i></a>

                <!-- Github -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-github"></i></a>
            </section>
            <!-- Section: Social media -->
        </div>
        <!-- Grid container -->

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2021 Copyright:
            <a class="text-white" href="index.html">MARKPRUET</a>
        </div>
        <!-- Copyright -->
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
    
</body>

</html>