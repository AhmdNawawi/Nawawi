<?php


session_start();


include 'helper/koneksi.php';

if (!isset($_SESSION['biodata'])) {
    header("Location: regis1.php");
    exit();
}

function sanitize($input) {
    global $mysqli;
    return mysqli_real_escape_string($mysqli, htmlspecialchars(trim($input)));
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email tidak valid.";
    } elseif (strlen($password) < 8) {
        $error = "Password harus minimal 8 karakter.";
    } else {
        mysqli_autocommit($mysqli, FALSE);

        try {
            // Insert into user table first
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $role = "pengguna";
            $email = sanitize($email);
        
            $query = "INSERT INTO tb_user (email, password, role) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($mysqli, $query);
            mysqli_stmt_bind_param($stmt, "sss", $email, $hashed_password, $role);
            $result = mysqli_stmt_execute($stmt);
            
            if (!$result) {
                throw new Exception("Error inserting into user: " . mysqli_error($mysqli));
            }
            
            $id_user = mysqli_insert_id($mysqli);
        
            // Then insert into pengguna table
            $nama = sanitize($_SESSION['biodata']['nama_lengkap']);
            $kabupaten = sanitize($_SESSION['biodata']['kabupaten']);
            $no_hp = sanitize($_SESSION['biodata']['nomor_hp']);
            $alamat = sanitize($_SESSION['biodata']['alamat']);
            $jenis_kelamin = sanitize($_SESSION['biodata']['jenis_kelamin']);
            
        
            $query = "INSERT INTO tb_pengguna (nama, kabupaten, no_hp, alamat, jenis_kelamin, id_user) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($mysqli, $query);
            mysqli_stmt_bind_param($stmt, "sssssi", $nama, $kabupaten, $no_hp, $alamat, $jenis_kelamin, $id_user);
            $result = mysqli_stmt_execute($stmt);
            
            if (!$result) {
                throw new Exception("Error inserting into pengguna: " . mysqli_error($mysqli));
            }
        
            mysqli_commit($mysqli);
            
            unset($_SESSION['biodata']);
            header("Location: index.php");
            exit();
        } catch (Exception $e) {
            mysqli_rollback($mysqli);
            $error = "Terjadi kesalahan saat mendaftar: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/lg_dinsos.png">
    <!-- Author Meta -->
    <meta name="author" content="codepixer">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>BANSOS - Registrasi</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600|Roboto:400,400i,500" rel="stylesheet">
    <!--
            CSS
            ============================================= -->
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/hexagons.min.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/main.css">
    
    <style>
        .register-form {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: #f8f9fa;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .register-form h2 {
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }
        .logo-img {
        max-width: 40px;
        height: auto;
        margin-right: 15px;
        }

        #logo {
            display: flex;
            align-items: center;
        }

        #logo h2 {
            margin-bottom: 0;
            font-size: 1.5rem;
        }
        .password-container {
            position: relative;
        }
        
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 70%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- start header Area -->
    <header id="header">
        <div class="container main-menu">
            <div class="row align-items-center justify-content-between d-flex">
                <div id="logo">
                    <img src="img/lg_dinsos.png" alt="Logo Dinsos" class="logo-img">
                    <h2>Dinas Sosial Provinsi <br> Kalimantan Selatan</h2>
                </div>
            </div>
        </div>
    </header>

    <section class="home-banner-area">
        <div class="container">
            <div class="row fullscreen d-flex align-items-center justify-content-center">
                <div class="col-lg-6">
                    <div class="register-form">
                        <h2>Registrasi</h2>
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email"  class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <div class="password-container">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <i class="fa fa-eye-slash toggle-password" onclick="togglePassword()"></i>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var toggleIcon = document.querySelector(".toggle-password");
            
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            }
        }
    </script>

    <!-- JavaScript files (unchanged) -->
    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
     crossorigin="anonymous"></script>
    <script src="js/tilt.jquery.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
    <script src="js/easing.min.js"></script>
    <script src="js/hoverIntent.js"></script>
    <script src="js/superfish.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/owl-carousel-thumb.min.js"></script>
    <script src="js/hexagons.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/mail-script.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
