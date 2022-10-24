<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>University Ride Sharing - Login</title>
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

    <!-- Login -->
    <div class="container-fluid login ">
        <div class="row ">
            <div class="col-12 col-sm-4 text-center formLogin mt-5" data-aos="fade-down">
                <p class="m-2 text-start fw-semibold">Welcome Back,</p>
                <h1 class="m-2 display-2 text-start fw-semibold">Log In!</h1>

                <div class="form-floating m-3">
                    <input type="email" class="form-control" id="username" placeholder="name@example.com">
                    <label for="floatingInput">Username</label>
                </div>



                <div class="form-floating m-3">
                    <input type="password" class="form-control" id="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>


                <button type="button" class="btn btn-success rounded-circle btn-lg buttonRide" onclick="login()"><i class="fa-solid fa-arrow-right"></i></button>

                <div class="mt-5" data-aos="flip-left">
                    <img src="assets/iconRideSharing.png" class="logo" alt="">
                </div>

                <div class="mt-3">
                    <p>Don't have an account ? <a class="cool-link" href="sign_up.php">Sign Up</a></p>
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
        function login() {

            let username = document.getElementById("username").value
            let password = document.getElementById("password").value


            let DataAkun = new FormData();
            DataAkun.append("username", username);
            DataAkun.append("password", password);


            console.log(username, password)

            const xmlHttp = new XMLHttpRequest();
            xmlHttp.onload = function() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                    alert(this.responseText)

                    if (this.responseText == "Maaf Username / Password Anda Salah") {
                        window.location.href = "http://localhost/ride_sharing/login.php";
                    } else {
                        window.location.href = "http://localhost/ride_sharing/ride.php";
                    }


                } else {
                    alert("Error!");
                }
            }
            xmlHttp.open("POST", "request/login_ajax.php");
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


</body>

</html>