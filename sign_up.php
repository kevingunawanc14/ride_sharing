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
</head>

<body>

    <!-- Login -->
    <div class="container-fluid login ">
        <div class="row ">
            <div class="col-12 col-sm-4 text-center formLogin mt-5" data-aos="fade-down">
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

                <div class="form-floating m-3">
                    <input type="password" class="form-control" id="password" placeholder="Password">
                    <label for="password">Umur</label>
                </div>

                <div class="form-floating m-3">
                    <input type="password" class="form-control" id="password" placeholder="Password">
                    <label for="password">Alamat</label>
                </div>

                <div class="form m-3">
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Status</option>
                        <option value="1">User</option>
                        <option value="2">Driver</option>
                    </select>
                </div>

                <div class="form m-3">
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Tipe Kendaraan</option>
                        <option value="1">Mobil</option>
                        <option value="2">Motor</option>
                    </select>

                </div>


                <button type="button" class="btn btn-success buttonRide mb-4" onclick="login()">Create Account</button>

                <div class="mt-5" data-aos="flip-left">
                    <img src="assets/iconRideSharing.png" class="logo" alt="">
                </div>

                <div class="mt-3">
                    <p>Already have an account ? <a href="login.php">Login</a></p>
                </div>

            </div>
            <div class="col-12 col-sm-8 bgLogin">

            </div>
        </div>
    </div>







    <!-- Link CDN Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Link CDN AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        function responsiveLoginPage(x) {
            if (x.matches) { // If media query matches
                document.getElementsByClassName("bgLogin")[0].style.visibility = 'hidden';

            } else {
                document.getElementsByClassName("bgLogin")[0].style.visibility = 'visible|hidden';

            }
        }

        var x = window.matchMedia("(max-width: 700px)")
        responsiveLoginPage(x) // Call listener function at run time
        x.addListener(responsiveLoginPage) // Attach listener function on state changes


        function login() {

            let username = document.getElementById("username").value
            let password = document.getElementById("password").value


            let DataAkun = new FormData();
            DataAkun.append("username", username);
            DataAkun.append("password", password);




            const xmlHttp = new XMLHttpRequest();
            xmlHttp.onload = function() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                    alert(this.responseText)
                    window.location.href = "http://localhost/ride_sharing/ride.php";

                } else {
                    alert("Error!");
                }
            }
            xmlHttp.open("POST", "request/login_ajax.php");
            xmlHttp.send(DataAkun);

        }
    </script>






    <script>
        $(function() {
            AOS.init({
                duration: 1200,
                once: true
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>


</body>

</html>