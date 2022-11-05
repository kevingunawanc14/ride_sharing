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
  <!-- Link Animated Style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>

  <style>
    /* warna icon font-awesome */
    .fa-car-side {
      color: black;
    }
  </style>

  <div id="map" class="mapLoading text-center"></div>

  <div class="container formRide text-center mt-3" data-aos="fade-down">
    <div class="row">
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-map-pin"></i></span>
        <input id="start" type="text" class="form-control" placeholder="Lokasi Anda" aria-describedby="basic-addon1" data-lokasi="3" readonly>
      </div>
    </div>
    <div class="row">
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-location-dot"></i></span>
        <input id="end" type="text" class="form-control" placeholder="Lokasi Tujuan" aria-describedby="basic-addon1">
      </div>
    </div>
    <div class="row">
      <div class="col">
        <button id="searchButton" type="button" class="btn btn-success animate__animated animate__pulse animate__infinite	infinite" onclick="searchDriver()"><i class="fa-solid fa-magnifying-glass"></i> Search</button>

        <button id="cancelButton" type="button" class="btn btn-danger animate__animated animate__pulse animate__infinite	infinite" style="display: none;" onclick="cancelSearchDriver()"><i class="fa-solid fa-xmark"></i> Cancel</button>

      </div>
    </div>
    <div id="detailData" class="row mt-3" style="display: none;">

      <div class="col-12 col-sm-6 my-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Lokasi Tujuan
        </button>

      </div>

      <div class="col-12 col-sm-6 my-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">
          List Driver
        </button>
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



  <!-- Modal Lokasi Tujuan -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Lokasi Tujuan</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="padding: 0;">
          <div id="map2">

          </div>
          <div class="container text-start">
            <div class="row">
              <div class="col lokasiTujuan">
                  <p>Lokasi Asal :</p>
                  <p>Lokasi Tujuan :</p>
                  <p>Jarak :</p>
                  <p>Biaya :</p>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal List Driver -->
  <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">List Driver</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="card mt-3">
            <h5 class="card-header">Featured</h5>
            <div class="card-body">
              <h5 class="card-title">Special title treatment</h5>
              <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
          </div>
          <div class="card mt-3">
            <h5 class="card-header">Featured</h5>
            <div class="card-body">
              <h5 class="card-title">Special title treatment</h5>
              <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
          </div>
          <div class="card mt-3">
            <h5 class="card-header">Featured</h5>
            <div class="card-body">
              <h5 class="card-title">Special title treatment</h5>
              <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Link CDN Jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <!-- Link CDN AOS -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>


  <!-- Link API Google -->
  <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwBBeg0pfj-FAVt_Q298ElrXKz0MO1Gg8&callback=initMap">
  </script>

  <!-- Link CDN JS Slick Carousel -->
  <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

  <!-- api key AIzaSyCwBBeg0pfj-FAVt_Q298ElrXKz0MO1Gg8 -->
  <!-- map id 93eb27799b5c0810  -->



  <script>
    // global scope variabel map
    var map1, map2

    // init map
    function initMap() {

      var options = {
        center: {
          lat: -7.3399815207700065,
          lng: 112.73688888681441
        },
        disableDefaultUI: true,
        mapId: '93eb27799b5c0810'
      }

      map1 = new google.maps.Map(document.getElementById('map'), options);
      // map2 = new google.maps.Map(document.getElementById('map2'), options);

    }

    // script saat window di load ambil lokasi user
    window.onload = function getLocation() {
      if (navigator.geolocation) {
        // run fungsi showPosition()
        navigator.geolocation.getCurrentPosition(showPosition);
      } else {
        alert("Geolocation is not supported by this browser.");
      }
    }

    // untuk ambil lokasi user saat ini
    function showPosition(position) {
      var lat = position.coords.latitude;
      var lng = position.coords.longitude;


      console.log(lat, lng, "x")
      // console.log(typeof(lat))

      //isi value form nya dengan lat,lng yang didapat dari geolocation yang nanti buat displit
      $("input").eq(0).val(lat + "," + lng, );

      // Geocoding
      const geocoder = new google.maps.Geocoder();
      const infowindow = new google.maps.InfoWindow();

      const input = document.getElementById("start").value;
      const latlngStr = input.split(",", 2);

      console.log(latlngStr)

      const latlng = {
        lat: parseFloat(latlngStr[0]),
        lng: parseFloat(latlngStr[1]),
      };

      geocoder
        .geocode({
          location: latlng
        })
        .then((response) => {
          if (response.results[0]) {
            map1.setZoom(18);

            const marker = new google.maps.Marker({
              position: latlng,
              map: map1,
            });
            // resultnya berupa banyak array ini coba ke 1 karena akurat
            infowindow.setContent(response.results[1].formatted_address);
            infowindow.open(map1, marker);


            // cetak di form nya 
            $("input").eq(0).val(response.results[1].address_components[0].short_name + "," + response.results[1].address_components[1].short_name);

            const dataLokasi = document.querySelector("#start");
            dataLokasi.dataset.lokasi = lat + "" + lng;


            map1.setCenter(new google.maps.LatLng(lat, lng));
          } else {
            window.alert("No results found");
          }
        })
        .catch((e) => window.alert("Geocoder failed due to: " + e));


    }



    // search driver
    function searchDriver() {
      if ($("#end").val() == "") {
        alert("Alamat Tujuan Masih Kosong")
        return
      }

      $("#searchButton").css("display", "none");
      $("#cancelButton").css("display", "inline-block");
      $("#detailData").css("display", "flex");


      viewLokasiTujuan();


    }

    // cancel search driver
    function cancelSearchDriver() {



      if (confirm("Pencarian Driver Akan Di Batalkan")) {

        $("#searchButton").css("display", "inline-block");
        $("#cancelButton").css("display", "none");
        $("#detailData").css("display", "none");
        return;

      } else {
        console.log("lanjut")

      }


    }

    function viewLokasiTujuan() {
      // alert("jalankan api direction")

      const directionsService = new google.maps.DirectionsService();
      const directionsRenderer = new google.maps.DirectionsRenderer();

      var options = {
        center: {
          lat: -7.3399815207700065,
          lng: 112.73688888681441
        },
        disableDefaultUI: true,
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: false,
        rotateControl: false,
        fullscreenControl: false,
        mapId: '93eb27799b5c0810'
      }

      map2 = new google.maps.Map(document.getElementById('map2'), options);


      directionsRenderer.setMap(map2);

      directionsService
        .route({
          origin: {
            query: document.getElementById("start").value,
          },
          destination: {
            query: document.getElementById("end").value,
          },
          travelMode: google.maps.TravelMode.DRIVING,
        })
        .then((response) => {
          directionsRenderer.setDirections(response);

          // gak jalan
          map2.setZoom(18);

          // $(".lokasiTujuan p")[0]

          console.log(response)

          console.log(response.request.destination)

          console.log(response.request.destination.query)



        })
        .catch((e) =>

          {
            window.alert("Directions request failed due to " + e)

            alert("su asu alamt e ra onok")

            $("#searchButton").css("display", "inline-block");
            $("#cancelButton").css("display", "none");
            $("#detailData").css("display", "none");
            return;
          }




        );











    }

















    
    // window.initMap = initMap;



    // aos initiate
    $(function() {
      AOS.init({
        duration: 1200,
        once: true
      });
    });
  </script>





  <!-- Link CDN Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>


</body>

</html>