<?php
require_once 'includes/connect.php';


if (!isset($_SESSION['username'])) {
    echo '<script>window.location.href = "http://localhost/ride_sharing/login.php";</script>';
}

$sql = 'SELECT * FROM USER WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();

// echo $row['username'];
// echo $row['password'];





?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>University Ride Sharing - Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Link CDN AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Link Icon -->
    <link rel="icon" type="image/x-icon" href="assets/iconRideSharing.png">
    <!-- Link CDN CSS Slick Carousel -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- Link Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oxygen:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- Link Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <style>
        /* css remove logout color */
        a {
            color: inherit;
            text-decoration: none;

        }

        a:hover {
            color: black;
        }

        /* css remove logout color */



        /* warna icon font-awesome */
        .fa-id-card {
            color: black;
        }
    </style>


    <!-- Profile -->
    <div class="container profile text-center mt-3" data-aos="fade-down">
        <div class="row">
            <h1 class="display-2 text-start fw-bolder cool-link">Profile</h1>
            <div class="col mt-4">
                <div class="row">
                    <div class="col m-3">
                        <?php

                        if ($row['status'] == 0) {

                            echo "<img src='assets/profile.png' alt='' class='rounded-circle rounded-5' width='100px'>";
                        } else {
                            echo "<img src='assets/driver.png' alt='' class='rounded-circle rounded-5' width='100px'>";
                        }

                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col m-3 text-start">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="<?php echo $row['username']   ?>" aria-label="Username" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col m-3 text-start">
                        <label for="umur" class="form-label">Umur</label>
                        <input type="text" class="form-control" id="umur" placeholder="<?php echo $row['umur']   ?>" aria-label="Umur" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col m-3 text-start">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" placeholder="<?php echo $row['alamat']   ?>" aria-label="Alamat" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col m-3 text-start">
                        <label for="status" class="form-label">Status</label>
                        <input type="text" class="form-control" id="status" placeholder="<?php


                        if ($row['status'] == 0) {

                            echo "User";
                        } else {
                            echo "Driver";
                        }




                                                                                            ?>" aria-label="Status" readonly>
                    </div>
                </div>

                <?php
                if ($row['status'] == 1) {

                    echo '<div class="row">
                           <div class="col m-3 text-start">
                             <label for="alamat" class="form-label">Kapasitas</label>
                              <input type="text" class="form-control" id="kapasitas" placeholder="'.$row['kapasitas'].'" aria-label="Status" readonly>
                            </div>
                         </div>';
                } else {
                }



                ?>

            </div>
        </div>
        <div class="row mt-5">
            <!-- <div class="col-6 mt-1">
                <button type="button" class="btn btn-primary">Edit</button>

            </div> -->
            <div class="col  text-center">
                <!-- <button type="button" class="btn btn-success ">Log Out</button> -->
                <i class="fa-solid fa-right-from-bracket"></i>
                <a class="cool-link" href="logout.php">
                    Log Out
                </a>

            </div>
        </div>
    </div>


    <nav class="navbar navbar-expand bg-light fixed-bottom">
        <div class="container-fluid">
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <div>
                    <ul class="navbar-nav">
                        <li class="nav-item mx-3">
                            <a class="nav-link text-center" href="ride_driver.php"><i class="fa-solid fa-car-side"></i></a>
                            <p class="fs-6">Ride</p>

                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link text-center" href="profile.php"><i class="fa-regular fa-id-card"></i></a>
                            <p class="fs-6">Profile</p>

                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link text-center" href="money.php"><i class="fa-solid fa-wallet"></i></a>
                            <p class="fs-6">Money</p>

                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link text-center" href="history.php"><i class="fa-solid fa-receipt"></i></a>
                            <p class="fs-6">History</p>


                        </li>

                    </ul>
                </div>

            </div>
        </div>
    </nav>



    <!-- Link CDN Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <!-- Link CDN Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js" integrity="sha512-naukR7I+Nk6gp7p5TMA4ycgfxaZBJ7MO5iC3Fp6ySQyKFHOGfpkSZkYVWV5R7u7cfAicxanwYQ5D1e17EfJcMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!-- Link CDN AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>


    <!-- Link CDN Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>


    <script>
        $(function() {
            AOS.init({
                duration: 1200,
                once: true
            });
        });
    </script>

</html>