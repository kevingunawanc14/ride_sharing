<?php
require_once 'includes/connect.php';

// echo $_SESSION['username'];

if (!isset($_SESSION['username'])) {
  echo '<script>window.location.href = "http://localhost/ride_sharing/login.php";</script>';
}




?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>University Ride Sharing - Ride</title>
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

  

  <div id="map"  ></div>

  <div class="container formRide text-center mt-3" data-aos="fade-down">
    <div class="row">
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-map-pin"></i></span>
        <input type="text" class="form-control" placeholder="Lokasi Anda" aria-describedby="basic-addon1">
      </div>
    </div>
    <div class="row">
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-location-dot"></i></span>
        <input type="text" class="form-control" placeholder="Lokasi Tujuan" aria-describedby="basic-addon1">
      </div>
    </div>
    <div class="row">
      <div class="col">
        <button type="button" class="btn btn-success" onclick="">Go</button>
      </div>
    </div>
  </div>


  <nav class="navbar navbar-expand bg-light fixed-bottom">
    <div class="container-fluid">
      <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
        <div>
          <ul class="navbar-nav">
            <li class="nav-item mx-3">
              <a class="nav-link text-center" href="ride.php"><i class="fa-solid fa-car-side"></i></a>
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
  <!-- Link CDN AOS -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>


  <!-- Link API Google -->
  <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtqtqs7izeIE4pjxFrtUi-4ymAMStRilY&callback=initMap">
  </script>

  <!-- -7.3399815207700065, 112.73688888681441 -->

  <script>
    function initMap() {
      var options = {
        center: {
          lat: -7.3399815207700065,
          lng: 112.73688888681441
        },
        zoom: 15,
        mapId: '93eb27799b5c0810'
      }

      map = new google.maps.Map(document.getElementById('map'), options);


      // -7.338842024281197, 112.73508906488934
      const marker = new google.maps.Marker({
        position: {
          lat: -7.338842024281197,
          lng: 112.73508906488934
        },
        map: map
      })

      // -7.338656165590891, 112.73703446286774
      const marker1 = new google.maps.Marker({
        position: {
          lat: -7.338656165590891,
          lng: 112.73703446286774
        },
        map: map
      })

      // -7.340493497163957, 112.73477295388967
      const marker2 = new google.maps.Marker({
        position: {
          lat: -7.340493497163957,
          lng: 112.73477295388967
        },
        content: "test",
        map: map
      })

      // -7.341459618489882, 112.73909444950196
      const markerDriver = new google.maps.Marker({
        position: {
          lat: -7.341459618489882,
          lng: 112.73909444950196
        },
        map: map,
        icon: {
          url: "https://cdn-icons-png.flaticon.com/512/5451/5451714.png",
          scaledSize: new google.maps.Size(38, 31)
        }
      })

      const detailWindow = new google.maps.InfoWindow({
        content: `<p>Nama Driver</p>`
      })

      markerDriver.addListener("click", () => {
        detailWindow.open(map, markerDriver);
      })

    }

    $(function() {
      AOS.init({
        duration: 1200,
        once: true
      });
    });
  </script>

  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtqtqs7izeIE4pjxFrtUi-4ymAMStRilY&map_ids=93eb27799b5c0810&callback=initMap"></script> -->

  <!-- api key AIzaSyDtqtqs7izeIE4pjxFrtUi-4ymAMStRilY -->
  <!-- map id 93eb27799b5c0810  -->


  <!-- Link CDN JS Slick Carousel -->
  <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

  <!-- Link CDN Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>


</body>

</html>