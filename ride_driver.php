<?php
require_once 'includes/connect.php';

// echo $_SESSION['username'];
$sql = 'SELECT * FROM USER WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();



if ($row['status'] != 1) {
  echo '<script>window.location.href = "http://localhost/ride_sharing/ride_user.php";</script>';
} else {
}






?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>University Ride Sharing - Ride Driver</title>
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
        <input id="start" type="text" class="form-control" placeholder="Lokasi Anda" aria-describedby="basic-addon1" readonly>
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

      <div class="col-12 col-sm-12 my-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal1">
          List User
        </button>
      </div>


      <div class="col-12 col-sm-12 my-3">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Status Order
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

  <!-- Modal Status Order -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-map-location-dot"></i> Status Order <button type="button" class="btn btn-success rounded-pill">0/0</button></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="padding: 0;">
          <div id="map2">

          </div>
          <div class="container text-start">
            <div class="row">
              <div class="col lokasiTujuan">
                <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="lokasi_berangkat" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true" onclick="gantiPilihanLokasi()">Lokasi Berangkat</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="lokasi_tujuan" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false" onclick="gantiPilihanLokasi()">Lokasi Tujuan</button>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    <!-- <p>Lokasi Berangkat Driver :</p>
                    <p>Lokasi Berangkat userx :</p>
                    <p>Lokasi Berangkat userx1 :</p>
                    <p>Lokasi Berangkat userx2 :</p> -->
                  </div>
                  <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                    <!-- <p>Lokasi Tujuan Driver :</p>
                    <p>Lokasi Tujuan usery :</p>
                    <p>Lokasi Tujuan usery1 :</p>
                    <p>Lokasi Tujuan usery2 :</p> -->
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Finish Order</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal List Driver -->
  <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel"> <i class="fa-solid fa-users"></i> List User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="listDriver" class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
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

    // global scope interval live map
    var interval

    // global scope marker
    var gmarkers = [];


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


      //isi value form nya dengan lat,lng yang didapat dari geolocation yang nanti buat displit
      $("input").eq(0).val(lat + "," + lng, );

      // Geocoding
      const geocoder = new google.maps.Geocoder();
      const infowindow = new google.maps.InfoWindow();

      const input = document.getElementById("start").value;
      const latlngStr = input.split(",", 2);


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
              icon: {
                url: "https://cdn-icons-png.flaticon.com/512/3097/3097144.png",
                scaledSize: new google.maps.Size(38, 31)
              },
              animation: google.maps.Animation.DROP
            });
            // resultnya berupa banyak array ini coba ke 1 karena akurat
            console.log(response.results)
            infowindow.setContent(response.results[1].formatted_address);
            infowindow.open(map1, marker);


            // cetak di form nya 
            $("input").eq(0).val(response.results[1].address_components[0].short_name + "," + response.results[1].address_components[1].short_name);


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
        return;
      }

      $("#searchButton").css("display", "none");
      $("#cancelButton").css("display", "inline-block");
      $("#detailData").css("display", "flex");

      // view lokasi tujuan 
      viewLokasiTujuan();

      // insert posisi user sekarang
      insertPosisiUserSaatIni()

      // view driver sekitar secara live
      interval = setInterval(function() {

        viewDriverSekitar();
        statusOrderLive();

      }, 10000);




    }

    // cancel search driver
    function cancelSearchDriver() {

      if (confirm("Pencarian Driver Akan Di Batalkan")) {

        $("#searchButton").css("display", "inline-block");
        $("#cancelButton").css("display", "none");
        $("#detailData").css("display", "none");

        // delete posisi user biar gak numpuk
        deletePosisiUserSaatIni()

        // stop interval update map
        clearInterval(interval);

        // remove marker
        for (i = 0; i < gmarkers.length; i++) {
          gmarkers[i].setMap(null);
        }

        if (navigator.geolocation) {
          // run fungsi showPosition()
          navigator.geolocation.getCurrentPosition(showPosition);
        } else {
          alert("Geolocation is not supported by this browser.");
        }


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

          // gak jalan saat didalam modal ?
          map2.setZoom(18);

          // $(".lokasiTujuan p").eq(0).html("Lokasi Asal &nbsp;&nbsp;&nbsp;&nbsp;: " + response.routes[0].legs[0].start_address)
          // $(".lokasiTujuan p").eq(1).html("Lokasi Tujuan : " + response.routes[0].legs[0].end_address)

          // $(".lokasiTujuan p").eq(2).html("Jarak &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: " + response.routes[0].legs[0].distance.text)

          // $(".lokasiTujuan p").eq(3).html("Biaya &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Rp. " + (parseInt(response.routes[0].legs[0].distance.text) * 4500))


        })
        .catch((e) =>

          {
            window.alert("Maaf lokasi tidak ditemukan ")
            window.location.reload();

          }




        );











    }

    function viewDriverSekitar() {
      // iki fungsine harus jalan terus 
      let lokasiStart = document.getElementById("start").value
      let lokasiEnd = document.getElementById("end").value


      let DataLokasiUser = new FormData();
      DataLokasiUser.append("lokasiStart", lokasiStart);
      DataLokasiUser.append("lokasiEnd", lokasiEnd);

      // console.log(DataLokasiUser)

      // Display the key/value pairs
      // for (var pair of DataLokasiUser.entries()) {
      //   console.log(pair[0] + ', ' + pair[1]);
      // }

      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

          data = JSON.parse(this.responseText);

          // reset list driver
          $("#listDriver").html("")

          // titik punya user sesuai session
          let titikStartUserSession = data[0]["lokasiStartUserIni"];
          let titikEndUserSession = data[0]["lokasiEndUserIni"];

          // console.log(titikStartUserSession+" , "+titikEndUserSession)

          const directionsService = new google.maps.DirectionsService();
          const directionsRenderer = new google.maps.DirectionsRenderer();

          console.log(data)

          for (let i = 1; i < data.length; i++) {
            directionsService
              .route({
                origin: {
                  query: titikStartUserSession,
                },
                destination: {
                  query: data[i]["lokasiStart"],
                },
                travelMode: google.maps.TravelMode.DRIVING,
              })
              .then((response) => {
                directionsRenderer.setDirections(response);

                marker = new google.maps.Marker({
                  position: {
                    lat: response.routes[0].legs[0].end_location.lat(),
                    lng: response.routes[0].legs[0].end_location.lng()
                  },
                  map: map1,
                  icon: {
                    url: "https://cdn-icons-png.flaticon.com/512/3710/3710297.png",
                    scaledSize: new google.maps.Size(38, 31)
                  },
                  animation: google.maps.Animation.DROP
                  // icon: "assets/cars.png"

                });

                // Push your newly created marker into the array:
                gmarkers.push(marker);

                // append ke list driver juga

                $("#listDriver").append('<div class="card mt-3 listDriverDetail"> <h5 class="card-header"> ' + data[i]['username'] + '</h5><div class="card-body"><p class="card-text">Jarak ' + response.routes[0].legs[0].distance.text + " dari posisi anda sekarang " + " <br> Estimasi waktu penjemputan " + response.routes[0].legs[0].duration.text + '</p> <a href="#" class="btn btn-success" ' + "onclick" + "=" + "pickUser(\"" + (data[i]['username']) + "\")" + '>' + "PICK-UP" + '</a> </div></div> ')

                // $('.listDriverDetail').attr('id', data[i]['username']);

              })
              .catch((e) => {
                console.log("error 123")
              });
          }




        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/view_user_sekitar_ajax.php");
      xmlHttp.send(DataLokasiUser);






    }

    function insertPosisiUserSaatIni() {
      // iki fungsine harus jalan terus 
      let lokasiStart = document.getElementById("start").value
      let lokasiEnd = document.getElementById("end").value


      let DataLokasiUser = new FormData();
      DataLokasiUser.append("lokasiStart", lokasiStart);
      DataLokasiUser.append("lokasiEnd", lokasiEnd);

      console.log(DataLokasiUser)



      // console.log($("#detailData").css("display"))



      // Display the key/value pairs
      // for (var pair of DataLokasiUser.entries()) {
      //   console.log(pair[0] + ', ' + pair[1]);
      // }

      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

          // alert(this.responseText + "aa")

        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/insert_posisi_user_ajax.php");
      xmlHttp.send(DataLokasiUser);

      return "check2";

    }

    function deletePosisiUserSaatIni() {
      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

          // alert(this.responseText + "deleted")

        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/delete_posisi_user_ajax.php");
      xmlHttp.send();

    }

    function pickUser(id) {

      // let id_driver = 
      let username = id


      let DataOrder = new FormData();
      DataOrder.append("username", username);
      // console.log(username)
      // console.log(id_user)

      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

          console.log(this.responseText)
          // statusOrderLive()
        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/insert_order_live_ajax.php");
      xmlHttp.send(DataOrder);

    }

    function statusOrderLive() {

      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

          // console.log(this.responseText)
          data = JSON.parse(this.responseText);
          console.log(data)
          console.log("test")

          arrayLokasi = [];

          // data ke 0 start sebagai start awal di way point
          arrayLokasi.push(data[0]['lokasiStartDriverIni'])
          // array.push(data[0]['lokasiEndDriverIni'])

          // push lo
          for (let i = 1; i < data.length; i++) {
            arrayLokasi.push(data[i]['lokasiStartUser'])
          }

          console.log(arrayLokasi)


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

          const directionsService = new google.maps.DirectionsService();
          const directionsRenderer = new google.maps.DirectionsRenderer();

          directionsRenderer.setMap(map2);


          const waypts = [];

          for (let i = 1; i < arrayLokasi.length; i++) {
            waypts.push({
              location: arrayLokasi[i],
              stopover: true,
            });
          }

          directionsService
            .route({
              origin: arrayLokasi[0],
              destination: arrayLokasi[arrayLokasi.length - 1],
              waypoints: waypts,
              optimizeWaypoints: true,
              travelMode: google.maps.TravelMode.DRIVING,
            })
            .then((response) => {
              directionsRenderer.setDirections(response);

              // const summaryPanel = document.getElementById("home-tab-pane");

              // summaryPanel.innerHTML = "";

              // // For each route, display summary information.
              // for (let i = 0; i < route.legs.length; i++) {
              //   const routeSegment = i + 1;

              //   summaryPanel.innerHTML +=
              //     "<b>Route Segment: " + routeSegment + "</b><br>";
              //   summaryPanel.innerHTML += route.legs[i].start_address + " to ";
              //   summaryPanel.innerHTML += route.legs[i].end_address + "<br>";
              //   summaryPanel.innerHTML += route.legs[i].distance.text + "<br><br>";

              // }
              console.log(route.legs[i].start_address)

            })
            .catch((e) => window.alert("Directions request failed due to " + status));



        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/view_order_live_ajax.php");
      xmlHttp.send();




    }

    function gantiPilihanLokasi() {
      console.log($('#lokasi_berangkat').attr('aria-selected'))
    }





















    window.initMap = initMap;



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