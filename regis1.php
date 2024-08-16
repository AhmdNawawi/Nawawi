<?php

session_start();
include 'helper/koneksi.php';

function sanitize($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap = sanitize($_POST['nama_lengkap']);
    $kabupaten = sanitize($_POST['kabupaten']);
    $nomor_hp = sanitize($_POST['nomor_hp']);
    $alamat = sanitize($_POST['alamat']);
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? sanitize($_POST['jenis_kelamin']) : '';


    // Validation
    if (empty($nama_lengkap) || empty($kabupaten) || empty($nomor_hp) || empty($alamat) || empty($jenis_kelamin)) {
        $error = "Semua field harus diisi.";
    } elseif (!preg_match("/^[0-9]{10,13}$/", $nomor_hp)) {
        $error = "Format nomor telepon tidak valid.";
    } else {
        $_SESSION['biodata'] = [
            'nama_lengkap' => $nama_lengkap,
            'kabupaten' => $kabupaten,
            'nomor_hp' => $nomor_hp,
            'alamat' => $alamat,
            'jenis_kelamin' => $jenis_kelamin
            
        ];
        
        header("Location: regis2.php");
        exit();
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
    <title>BANSOS - Daftar</title>

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
            top: 50%;
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
                        <h2>Daftar</h2>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <!-- <label for="nama">Nama Lengkap</label> -->
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap"  class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <!-- <label for="kabupaten">Kabupaten</label> -->
                            <label class="form-label">Kabupaten <span class="text-danger">*</span></label>
                            <input type="text" name="kabupaten"  class="form-control" id="kabupaten" name="kabupaten" required>
                        </div>
                        <div class="form-group">
                            <!-- <label for="nomor_hp">Nomor HP</label> -->
                            <label class="form-label">Nomor HP <span class="text-danger">*</span></label>
                            <input type="text" name="nomor_hp"   class="form-control" id="nomor_hp" name="nomor_hp" required>
                        </div>
                        <div class="form-group">
                            <!-- <label for="alamat">Alamat</label> -->
                            <label class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="alamat"  id="alamat" name="alamat" rows="2" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki-laki" value="Laki-laki" required>
                                    <label class="form-check-label" for="laki-laki">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" required>
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">Lanjut</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </section>



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