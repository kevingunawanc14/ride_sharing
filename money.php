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
    <title>Ride</title>
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
    <!-- Link Animate Style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>

    <style>
        /* warna icon font-awesome */
        .fa-wallet {
            color: black;
        }
    </style>

    <div class="container text-center mt-3" data-aos="fade-down">
        <div class="row">
            <h1 class="display-2 text-start fw-bolder cool-link">Pembayaran</h1>
            <div class="col mt-4">
                <div class="card">
                    <div class="card-header">
                        OVO CASH
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><sup> Rp </sup> <span id="saldoSekarang"> <?php echo $row['saldo'];  ?></span></h5>
                        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
                        <button class="btn btn-primary my-2 animate__animated animate__shakeY animate__slower animate__infinite	infinite" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class="fa-solid fa-hand-holding-dollar"></i> Isi Ulang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content ">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Masukan Isi Saldo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-saldo">
                        <div class="">
                            <input type="number" class="form-control" id="saldo">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="isiSaldoAjax()" data-bs-dismiss="modal">Isi</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Detail History -->
    <div class="container transaksi" data-aos="fade-down">
        <div class="row">
            <div class="col-12 mt-4">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#transaksi-perjalanan" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Transaksi Perjalanan</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#transaksi-isi-saldo" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Transaksi Isi Saldo</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="transaksi-perjalanan" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

                        <?php
                        //sql ambil id_user
                        $sql = 'SELECT * FROM user WHERE username = ?';
                        $checksql = $pdo->prepare($sql);
                        $checksql->execute([$_SESSION["username"]]);

                        $row = $checksql->fetch();

                        $idUser = $row['id'];


                        $sql = 'SELECT * FROM transaksi WHERE id_user = ?';
                        $checksql = $pdo->prepare($sql);
                        $checksql->execute([$idUser]);

                        while ($rowTransaksi = $checksql->fetch()) {

                            echo    "
                                    
                                <div class='row'>
                                    <div class='col mt-4'>
                                    <h3>{$rowTransaksi['tanggal']}</h3>
                                        <div class='card w-100'>
                                            <div class='card-body'>
                                                <h5 class='card-title'>Perjalanan</h5>
                                                <p class='card-text'>Kode Pemesanan {$rowTransaksi['id']} </p>
                                                <a href='#' class='btn btn-primary'>-Rp. {$rowTransaksi['biaya']} </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            ";
                        }



                        ?>




                    </div>
                    <div class="tab-pane fade" id="transaksi-isi-saldo" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">




                        <?php

                        $sql = 'SELECT * FROM user WHERE username = ?';
                        $checksql = $pdo->prepare($sql);
                        $checksql->execute([$_SESSION["username"]]);

                        $row = $checksql->fetch();

                        $idUser = $row['id'];

                        $sql = 'SELECT * FROM histori_isisaldo WHERE id_user = ?';
                        $checksql = $pdo->prepare($sql);
                        $checksql->execute([$idUser]);


                        while ($rowHistoriIsiSaldo = $checksql->fetch()) {

                            echo    "
    
                                <div class='row'>
                                    <div class='col mt-4'>
                                        <h3>{$rowHistoriIsiSaldo['tanggal']}</h3>
                                        <div class='card w-100'>
                                            <div class='card-body'>
                                                <h5 class='card-title'>Isi Saldo</h5>
                                                <p class='card-text'>Kode Pengisian {$rowHistoriIsiSaldo['id']} </p>
                                                <a href='#' class='btn btn-primary'>+Rp. {$rowHistoriIsiSaldo['jumlah_uang']} </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        ";
                        }


                        ?>




                    </div>
                </div>
            </div>
        </div>

    </div>

    <nav class="navbar navbar-expand bg-light fixed-bottom">
        <div class="container-fluid">
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <div>
                    <ul class="navbar-nav">
                        <li class="nav-item mx-3">
                            <a class="nav-link text-center" href="ride_user.php"><i class="fa-solid fa-car-side"></i></a>
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

    <!-- Link CDN sweetalert  -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function isiSaldoAjax() {

            saldoAdd = document.getElementById("saldo").value
            saldoNow = document.getElementById("saldoSekarang").textContent

            // console.log(saldoAdd,saldoNow)

            let formData = new FormData();
            formData.append("saldo", saldoAdd);
            formData.append("saldoSekarang", saldoNow);

            const xmlHttp = new XMLHttpRequest();
            xmlHttp.onload = function() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

                    let timerInterval
                    Swal.fire({
                        title: 'Dalam Proses...',
                        html: '',
                        timer: 2000,
                        allowOutsideClick: false,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            // const b = Swal.getHtmlContainer().querySelector('b')
                            // timerInterval = setInterval(() => {
                            //     b.textContent = Swal.getTimerLeft()
                            // }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log('I was closed by the timer')
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            confirmButtonColor: "#0d6efd"
                        });

                        // console.log(this.responseText)
                        data = JSON.parse(this.responseText);

                        console.log(data)

                        // replace value saldo 
                        $(".card-title").eq(0).html("<sup> Rp </sup> <span id='saldoSekarang'>" + data[0]['saldoUpdate'] + "</span>")

                        // replace value list transaksi isi saldo
                        $("#transaksi-isi-saldo").html("")

                        for (let i = 1; i < data.length; i++) {
                            console.log("aa")
                            $("#transaksi-isi-saldo").append(
                                "<div class='row'><div class='col mt-4'><h3>" + data[i]['tanggal'] + "</h3><div class='card w-100'><div class='card-body'><h5 class='card-title'>Isi Saldo</h5><p class='card-text'>Kode Pengisian " + data[i]['kode'] + "</p><a href='#' class='btn btn-primary'>+Rp. " + data[i]['jumlah_uang'] + "</a></div></div></div></div>"
                            )
                        }








                        $(".form-saldo").trigger("reset");

                    })




                } else {
                    alert("Error!");
                }
            }


            xmlHttp.open("POST", "request/isi_saldo_ajax.php");
            xmlHttp.send(formData);





        }




        $(function() {
            AOS.init({
                duration: 1200,
                once: true
            });
        });
    </script>

</html>