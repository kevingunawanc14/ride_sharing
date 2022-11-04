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
        <button type="button" class="btn btn-success animate__animated animate__pulse animate__infinite	infinite" onclick="viewUserSekitar()"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-12 col-sm-6 my-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Lokasi Tujuan
        </button>

      </div>
      <div class="col-12 col-sm-6 my-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Lokasi Driver
        </button>
      </div>
      <!-- <div class="col-12 col-sm-4 my-3">
        Button trigger modal
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Lokasi Driver
        </button>
      </div> -->

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
  <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwBBeg0pfj-FAVt_Q298ElrXKz0MO1Gg8&callback=initMap">
  </script>

  <!-- Link CDN JS Slick Carousel -->
  <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

  <!-- api key AIzaSyCwBBeg0pfj-FAVt_Q298ElrXKz0MO1Gg8 -->
  <!-- map id 93eb27799b5c0810  -->




  <script>
    function initMap() {

      // Direction 
      const directionsService = new google.maps.DirectionsService();
      const directionsRenderer = new google.maps.DirectionsRenderer();



      var options = {
        center: {
          lat: -7.3399815207700065,
          lng: 112.73688888681441
        },
        zoom: 15,
        mapId: '93eb27799b5c0810'
      }

      map = new google.maps.Map(document.getElementById('map'), options);

      //Direction  
      directionsRenderer.setMap(map);

      const onChangeHandler = function() {
        calculateAndDisplayRoute(directionsService, directionsRenderer);
      };

      document.getElementById("start").addEventListener("change", onChangeHandler);
      document.getElementById("end").addEventListener("change", onChangeHandler);

    }

    // script saat window di load ambil lokasi user
    window.onload = function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else {
        alert("Geolocation is not supported by this browser.");
      }
    }


    function showPosition(position) {
      var lat = position.coords.latitude;
      var lng = position.coords.longitude;
     

      console.log(lat, lng, "x")
      console.log(typeof(lat))

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
            map.setZoom(18);

            const marker = new google.maps.Marker({
              position: latlng,
              map: map,
            });

            infowindow.setContent(response.results[1].formatted_address);
            infowindow.open(map, marker);


            // console.log(response.results)

            // console.log(response.results[0])

            // console.log(response.results[0].geometry.location_type)

            // console.log(response.results[6])

            // console.log(response.results[0].address_components[1])

            // console.log(response.results[1].address_components[1].short_name)
            // console.log()


            $("input").eq(0).val(response.results[1].address_components[0].short_name + "," + response.results[1].address_components[1].short_name);

            const dataLokasi = document.querySelector("#start");
            dataLokasi.dataset.lokasi = lat+""+lng; 


             map.setCenter(new google.maps.LatLng(lat, lng));
          } else {
            window.alert("No results found");
          }
        })
        .catch((e) => window.alert("Geocoder failed due to: " + e));


    }


    function calculateAndDisplayRoute(directionsService, directionsRenderer) {
      
      const dataLokasi = document.querySelector("#start");


      directionsService
        .route({
          origin: {
            query: $("input").eq(0).val(),
          },
          destination: {
            query: $("input").eq(1).val(),
          },
          travelMode: google.maps.TravelMode.DRIVING,
          unitSystem: google.maps.UnitSystem.METRIC
        })
        .then((response) => {
          directionsRenderer.setDirections(response);
          console.log(response.routes[0].legs[0].distance.text)

          // console.log(response['request'])
          // console.log(JSON.stringify(response.data));
        })
        .catch((e) => window.alert("Directions request failed due to " + status));
    }


    function liveMap() {



      let DataLokasiUser = new FormData();
      DataLokasiUser.append("lokasi", $("#start").val());

      console.log($("#start").val())

      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

          $(".mapLoading").html("<span class='loader'></span>");

          $(".loader").css({
            "margin-top": "50%",
          });



          setTimeout(() => {

            console.log("aa")

          }, 3000)


        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/map_live_ajax.php");
      xmlHttp.send(DataLokasiUser);

    }

    function viewUserSekitar() {


      let lokasi_awal = $("input").eq(0).val();

      let DataLokasi = new FormData();
      DataLokasi.append("lokasi_awal", lokasi_awal);


      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

          data = JSON.parse(this.responseText);
          // terima data lokasi
          // misal 
          // awal user = petra w
          // awal driver = petra e
          // awal driver = petra q
          // ......
          // if lokasi user dicompare dengan driver2 yang ada kurang dari 500m 
          // jalano script api direction untuk cek 
          // console.log(data)
          // console.log(this.responseText)

          const directionsService = new google.maps.DirectionsService();
          const directionsRenderer = new google.maps.DirectionsRenderer();



          for (let i = 1; i < data.length; i++) {
            // console.log(data.length)
            console.log(data[0]["lokasi_berangkat"], " ini isi datanya")

            directionsService
              .route({
                origin: {
                  query: data[0]["lokasi_berangkat"],
                },
                destination: {
                  query: data[i]["lokasi_berangkat"],
                },
                travelMode: google.maps.TravelMode.DRIVING,
              })
              .then((response) => {
                directionsRenderer.setDirections(response);
                console.log(response.routes)

                const myArray = response.routes[0].legs[0].distance.text.split(" ");

                if (myArray[0] <= 1) {
                  alert("kurang dari 1 kilo")
                  console.log(response.routes[0].legs[0].distance.text)

                }

                let data = `  
                  <ol class='list-group list-group-numbered'>
                  <li class='list-group-item d-flex justify-content-between align-items-start'>
                    <div class='ms-2 me-auto'>
                      <div class='fw-bold'>Subheading</div>
                      Content for list item
                    </div>
                    <span class='badge bg-primary rounded-pill'>14</span>
                  </li>
                  <li class='list-group-item d-flex justify-content-between align-items-start'>
                    <div class='ms-2 me-auto'>
                      <div class='fw-bold'>Subheading</div>
                      Content for list item
                    </div>
                    <span class='badge bg-primary rounded-pill'>14</span>
                  </li>
                  <li class='list-group-item d-flex justify-content-between align-items-start'>
                    <div class='ms-2 me-auto'>
                      <div class='fw-bold'>Subheading</div>
                      Content for list item
                    </div>
                    <span class='badge bg-primary rounded-pill'>14</span>
                  </li>
                </ol>
                `

                $(".formRide").html(data)

              })
              .catch((e) => window.alert("Directions request failed due to " + status + "maro"));
          }







        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/user_sekitar_ajax.php");
      xmlHttp.send(DataLokasi);


    }

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