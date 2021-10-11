<?php
session_start();
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
  <link rel="stylesheet" href="style.css">
  <link rel="shortcut icon" type="img/png" href="shop.png">
  <title>Sign In</title>

</head>

<body class="login-background-blue">


  <div class="flex-login-form">

    <h1 class="text-white mb-5">เข้าสู่ระบบ</h1>

    <?php if (isset($_SESSION['err_login'])) : ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $_SESSION['err_login']; ?>
      </div>
    <?php endif; ?>

    <form class="p-5 card login-card-custom" method="post" action="login_db.php">
      <!-- Email input -->
      <div class="form-outline mb-4">
        <input type="text" name="username" id="form1Example1" class="form-control" />
        <label class="form-label" for="form1Example1">อีเมล์</label>
      </div>

      <!-- Password input -->
      <div class="form-outline mb-4">
        <input type="password" name="password" id="form1Example2" class="form-control" />
        <label class="form-label" for="form1Example2">รหัสผ่าน</label>
      </div>

      <!-- 2 column grid layout for inline styling -->



      <!-- Submit button -->
      <button type="submit" name="submit" class="btn login-btn-blue btn-block text-white">เข้าสู่ระบบ</button>
    </form>
  </div>



  <!-- MDB -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
</body>

</html>
<?php
    if (isset($_SESSION['err_login'])) {
        unset($_SESSION['err_login']);
    }
?>