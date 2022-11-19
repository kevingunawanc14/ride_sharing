<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>University Ride Sharing</title>
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

    <!-- Sign up -->
    <div class="container-fluid sign_up ">
        <div class="row ">
            <div class="col-12 col-sm-4 text-center formSignUp mt-5" data-aos="fade-down">
                <p class="m-2 text-start fw-semibold">Hello,</p>
                <h1 class="m-2 display-2 text-start fw-semibold">Sign Up!</h1>


                <div class="form-floating m-3">
                    <input type="email" class="form-control" id="username" placeholder="name@example.com">
                    <label for="floatingInput">Username</label>
                </div>



                <div class="form-floating m-3">
                    <input type="password" class="form-control" id="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>

                <!-- <div class="form m-3 mt-4" data-aos="fade-down">
                    <select class="form-select pilihanStatus" aria-label="Default select example">
                        <option selected>Status</option>
                        <option value="1">User</option>
                        <option value="2">Driver</option>
                    </select>
                </div> -->


                <button type="button" class="btn btn-success rounded-circle btn-lg buttonRide" onclick="next1()"><i class="fa-solid fa-arrow-right"></i></button>


                <div class="mt-5" data-aos="flip-left">
                    <img src="assets/iconRideSharing.png" class="logo" alt="">
                </div>

                <div class="mt-3">
                    <p>Already have an account ? <a href="login.php" class="cool-link">Login</a></p>
                </div>

            </div>
            <div class="col-12 col-sm-8 slide d-none d-sm-block">
                <div class="bgLogin1"></div>
                <div class="bgLogin2"></div>
                <div class="bgLogin3"></div>
            </div>
        </div>
    </div>



    <!-- Link CDN Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Link CDN AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        var counter = 0

        var DataAkun = new FormData();


        $('body').on('change', '.pilihanStatus', function() {
            var pil = $(this).val();

            if (pil == "1" && counter == 0) {
                let formKapasitas =
                    `
                    <div class="form formKapasitas m-3 mt-4" data-aos="fade-down">
                            <select class="form-select kapasitas" aria-label="Default select example">
                                <option  selected>Kapasitas Kendaraan</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>

                        </div> 

                    `
                $(".formStatus").after(formKapasitas);
                counter += 1
            } else {
                $(".formKapasitas").remove();
            }



        });


        function next1() {


            let username = document.getElementById("username").value
            let password = document.getElementById("password").value

            DataAkun.append("username", username);
            DataAkun.append("password", password);



            let dataUmum =
                `
                <p class="m-2 text-start fw-semibold">Hello,</p>
                <h1 class="m-2 display-2 text-start fw-semibold">Sign Up!</h1>

                <div class="form-floating m-3" data-aos="fade-down">
                    <input type="number" class="form-control" id="umur" placeholder="umur">
                    <label for="umur">Umur</label>
                </div>

                <div class="form-floating m-3" data-aos="fade-down">
                    <input type="text" class="form-control" id="alamat" placeholder="alamat">
                    <label for="alamat">Alamat</label>
                </div>

                <button type="button" class="btn btn-success rounded-circle btn-lg buttonRide" onclick="next2()"><i class="fa-solid fa-arrow-right"></i></button>


                <div class="mt-5" data-aos="flip-left">
                    <img src="assets/iconRideSharing.png" class="logo" alt="">
                </div>

                <div class="mt-3">
                    <p>Already have an account ? <a href="login.php">Login</a></p>
                </div>
            `
            $(".formSignUp").html(dataUmum);

            // Display the values
            // for (const value of DataAkun.values()) {
            //     console.log(value);
            // }

        }

        function next2() {

            let umur = document.getElementById("umur").value
            let alamat = document.getElementById("alamat").value

            DataAkun.append("umur", umur);
            DataAkun.append("alamat", alamat);

            let dataDetail =
                `
                <p class="m-2 text-start fw-semibold">Hello,</p>
                <h1 class="m-2 display-2 text-start fw-semibold">Sign Up!</h1>

                <div class="form m-3 mt-4 formStatus" data-aos="fade-down">
                    <select class="form-select pilihanStatus" aria-label="Default select example">
                        <option  selected>Status</option>
                        <option value="0" >User</option>
                        <option value="1" >Driver</option>
                    </select>
                </div>

                


                <button type="button" class="btn btn-success rounded-circle btn-lg buttonRide mt-4" onclick="createAccount()"><i class="fa-solid fa-arrow-right"></i></button>


                <div class="mt-5" data-aos="flip-left">
                    <img src="assets/iconRideSharing.png" class="logo" alt="">
                </div>

                <div class="mt-3">
                    <p>Already have an account ? <a href="login.php">Login</a></p>
                </div>
            `
            $(".formSignUp").html(dataDetail);


            // Display the values
            for (const value of DataAkun.values()) {
                console.log(value);
            }

        }

        function createAccount() {

            let status = $('.pilihanStatus').find(":selected").val();


            if (status == "1") {
                let kapasitas = $('.kapasitas').find(":selected").val();
                DataAkun.append("status", status);
                DataAkun.append("kapasitas", kapasitas);
            } else {
                DataAkun.append("status", status);
                DataAkun.append("kapasitas", 0);
            }

            // console.log(DataAkun)

            // Display the values
            // for (const value of DataAkun.values()) {
            //     console.log(value);
            // }

            const xmlHttp = new XMLHttpRequest();
            xmlHttp.onload = function() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {


                    $(".formSignUp").attr('style', 'margin-top: 40vh !important');
                    $(".formSignUp").html("<span class='loader'></span>");

                    setTimeout(() => {
                        if (this.responseText == "Pembuatan Akun Berhasil") {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Pembuatan Akun Berhasil',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                timer: 3000
                            })
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Pembuatan Akun Gagal',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                timer: 3000
                            })
                        }
                    }, 1000)



                    setTimeout(() => {
                        if (this.responseText == "Pembuatan Akun Berhasil") {
                            // Swal.fire({
                            //     position: 'center',
                            //     icon: 'success',
                            //     title: 'Pembuatan Akun Berhasil',
                            //     showConfirmButton: false,
                            //     allowOutsideClick: false,
                            //     timer: 3000
                            // })
                            window.location.href = "http://localhost/ride_sharing/login.php";
                        } else {
                            // Swal.fire({
                            //     position: 'center',
                            //     icon: 'error',
                            //     title: 'Pembuatan Akun Gagal',
                            //     showConfirmButton: false,
                            //     allowOutsideClick: false,
                            //     timer: 3000
                            // })
                            window.location.href = "http://localhost/ride_sharing/sign_up.php";

                        }


                    }, 4000)



                } else {
                    alert("Error!");
                }
            }
            xmlHttp.open("POST", "request/sign_up_ajax.php");
            xmlHttp.send(DataAkun);





        }







        $(function() {
            AOS.init({
                duration: 1200,
                once: true
            });
        });

        $(document).ready(function() {
            $('.slide').slick({
                infinite: true,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 2000
                // swipe: false
            });
        });
    </script>





    <!-- Link CDN JS Slick Carousel -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <!-- Link CDN Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <!-- Link CDN sweetalert  -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>