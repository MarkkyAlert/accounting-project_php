<?php
include('config.php');
session_start();
include('config.php');
if (!isset($_SESSION['is_logged_in'])) {
    header('location: login.php');
}
if (isset($_POST['submit'])) {

    $date = $_POST['date'];
    if (empty($date)) {
        $_SESSION['empty'] = "กรุณากรอกวันที่";
        header('location: show_receipt.php');
    }
    $select_stmt2 = $db->prepare("SELECT * FROM receipts WHERE date = :date");
    $select_stmt2->bindParam(':date', $date);
    $select_stmt2->execute();
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
    <link rel="shortcut icon" type="img/png" href="shop.png">
    <link rel="stylesheet" href="style.css">
    <title>รายการใบเสร็จ</title>
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

        <h2 class="text-center mt-5 mb-5">รายการใบเสร็จ</h2>
        <?php if (isset($_SESSION['err_del'])) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['err_del']; ?>
            </div>
        <?php endif; ?>

        <?php
        $select_stmt = $db->prepare("SELECT receipt_id, date, reference, company, total_price FROM receipts ORDER BY receipt_id DESC");
        $select_stmt->execute();

        ?>
        <form class="row row-cols-lg-auto g-3 align-items-center" method="post" action="">
            <div class="col-12">
                <label class="visually-hidden" for="inlineFormInputGroupUsername">date</label>
                <div class="input-group">

                    <input type="date" value="<?php echo date("Y-m-d"); ?>" name="date" max="<?php echo date("Y-m-d"); ?>" class="form-control" id="inlineFormInputGroupUsername" placeholder="Username" />
                </div>
            </div>





            <div class="col-12">
                <button type="submit" name="submit" class="btn btn-info">ค้นหา</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">วันที่</th>
                        <th scope="col">เลขที่เอกสาร</th>
                        <th scope="col">บริษัท</th>
                        <th scope="col">ยอดเงิน</th>
                        <th scope="col">ตัวเลือก</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($select_stmt2 as $row) { ?>
                        <tr>
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
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <a href="delete_receipt.php?reference=<?php echo $row['reference']; ?>" class="btn btn-info">Yes</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <th scope="row"><?php echo $day . " " . $month . " " . $year; ?></th>
                            <td><?php echo $row['reference']; ?></td>
                            <td><?php echo $row['company']; ?></td>
                            <td><?php echo number_format($row['total_price']); ?></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-mdb-toggle="dropdown" aria-expanded="false">
                                        ตัวเลือก
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" target="_blank" href="download.php?reference=<?php echo $row['reference']; ?>">ดาวน์โหลด</a></li>
                                        <li><a class="dropdown-item" href="edit_receipt_db.php?reference=<?php echo $row['reference']; ?>">แก้ไข</a></li>
                                        <li><a class="dropdown-item" data-mdb-toggle="modal" data-mdb-target="#exampleModal" href="">ลบ</a></li>


                                    </ul>
                                </div>
                            </td>

                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>



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
<?php
if (isset($_SESSION['err_del'])) {
    unset($_SESSION['err_del']);
}
?>