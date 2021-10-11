<?php
session_start();
include('config.php');
if (!isset($_SESSION['is_logged_in'])) {
    header('location: login.php');
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
    <title>เมนู</title>
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

    <div class="container login-card-custom ">

        <h2 class="text-center mt-5 mb-5">เลือกเมนู</h2>

        <div class="row p-5 card text-center">
            <div class="col-md-12">
                <a class="btn btn-lg btn-info mb-3 w-100" href="index.php">ดูบัญชีรายรับทั้งหมด</a> <br>
                <a class="btn btn-lg btn-info mb-3 w-100" href="receive_form.php">เพิ่มข้อมูลบัญชีรายรับ</a><br>
                <a class="btn btn-lg btn-info w-100" href="conclude.php">สรุปรายรับ</a>
            </div>
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
