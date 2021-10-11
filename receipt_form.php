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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="img/png" href="shop.png">
    <title>ฟอร์มใบเสร็จ</title>
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

        <h2 class="text-center mt-5 mb-5">ฟอร์มใบเสร็จ</h2>
        <?php if (isset($_SESSION['err_receipt'])) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['err_receipt']; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['err_fill'])) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['err_fill']; ?>
            </div>
        <?php endif; ?>

        <form style="margin:0 auto;" class="p-5 card " method="post" action="receipt_form_db.php">
            <!-- Email input -->
            <div class="row">
                <div class="col-md-12 mb-4">
                    <select name="course" class="form-select" aria-label="Default select example">
                        <?php
                        $select_stmt = $db->prepare("SELECT * FROM course");
                        $select_stmt->execute(array("%$query%"));

                        ?>
                        <?php foreach ($select_stmt as $rows) { ?>
                            <option selected value="<?php echo $rows['course_id']; ?>"><?php echo $rows['course_name']; ?></option>
                        <?php } ?>

                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-outline mb-4">
                        <input type="text" name="price" id="form1Example1" class="form-control" />
                        <label class="form-label" for="form1Example1">ราคาต่อคอร์ส</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-outline mb-4">
                        <input type="text" name="amount" id="form1Example1" class="form-control" />
                        <label class="form-label" for="form1Example1">จำนวน</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-outline mb-4">

                        <input name="date" class="form-control" type="date" placeholder="date" value="<?php echo date("Y-m-d"); ?>" max="<?php echo date("Y-m-d"); ?>" />
                        <label class="form-label" for="form1Example1"></label>
                    </div>
                </div>
            </div>
            <?php
            $select_stmt = $db->prepare("SELECT * FROM users WHERE user_id = :user_id");
            $select_stmt->bindParam(':user_id', $_SESSION['user_id']);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-outline mb-4">
                        <input type="text" disabled name="firstname" value="<?php echo $row['firstname']; ?>" id="form1Example1" class="form-control" />
                        <label class="form-label" for="form1Example1">ชื่อ</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-outline mb-4">
                        <input type="text" disabled name="lastname" value="<?php echo $row['lastname']; ?>" id="form1Example1" class="form-control" />
                        <label class="form-label" for="form1Example1">นามสกุล</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-outline mb-4">
                        <input type="text" disabled name="email" value="<?php echo $row['email']; ?>" id="form1Example1" class="form-control" />
                        <label class="form-label" for="form1Example1">อีเมล์</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-outline mb-4">
                        <input type="text" disabled name="phone" value="<?php echo $row['phone']; ?>" id="form1Example1" class="form-control" />
                        <label class="form-label" for="form1Example1">โทรศัพท์</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-outline mb-4">
                        <textarea class="form-control" name="address" disabled id="textAreaExample" rows="4"><?php echo $row['address']; ?></textarea>
                        <label class="form-label" for="textAreaExample">ที่อยู่</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-outline mb-4">
                        <input type="text" name="company" id="form1Example1" class="form-control" />
                        <label class="form-label" for="form1Example1">บริษัท</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-outline mb-4">
                        <input type="text" name="company_address" id="form1Example1" class="form-control" />
                        <label class="form-label" for="form1Example1">ที่อยู่บริษัท</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-outline mb-4">
                        <input type="text" name="company_phone" id="form1Example1" class="form-control" />
                        <label class="form-label" for="form1Example1">โทรศัพท์</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-outline mb-4">
                        <input type="text" name="company_tax" id="form1Example1" class="form-control" />
                        <label class="form-label" for="form1Example1">เลขผู้เสียภาษี</label>
                    </div>
                </div>
            </div>


            <!-- Submit button -->
            <button type="submit" name="submit" class="btn login-btn-blue btn-block text-white">บันทึก</button>
        </form>
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
if (isset($_SESSION['err_receipt']) || isset($_SESSION['err_fill'])) {
    unset($_SESSION['err_receipt']);
    unset($_SESSION['err_fill']);
}
?>