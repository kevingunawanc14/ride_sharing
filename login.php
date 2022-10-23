<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>University Ride Sharing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Link CDN AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Link Icon -->
    <link rel="icon" type="image/x-icon" href="assets/iconRideSharing.png">
</head>

<body>

    <!-- Login -->
    <div class="container-fluid login">
        <div class="row">
            <div class="col-12 col-sm-4 text-center formLogin" data-aos="fade-down">
                <h2 class="m-2 text-dark text-start">Welcome!</h2>

                <div class="form-floating m-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Email address</label>
                </div>



                <div class="form-floating m-3">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>


                <a href="ride.html"> <button type="button" class="btn btn-success buttonRide mb-5">Ride</button></a>

                <div class="mt-5" data-aos="flip-left">
                    <img src="assets/iconRideSharing.png" class="logo" alt="">
                </div>

            </div>
            <div class="col-12 col-sm-8 bgLogin">
                x
            </div>
        </div>
    </div>







    <!-- Link CDN Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Link CDN AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>


        function myFunction(x) {
            if (x.matches) { // If media query matches
                document.getElementsByClassName("bgLogin")[0].style.visibility = 'hidden';

            } else {
                document.getElementsByClassName("bgLogin")[0].style.visibility = 'visible|hidden';

            }
        }

        var x = window.matchMedia("(max-width: 700px)")
        myFunction(x) // Call listener function at run time
        x.addListener(myFunction) // Attach listener function on state changes

    </script>



    


    <script>
        $(function () {
            AOS.init({
                duration: 1200,
                once: true
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>


</body>

</html>