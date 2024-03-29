<?php
require_once 'includes/connect.php';

$sql = 'SELECT * FROM USER WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);
$row = $checksql->fetch();


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

  <p id="hasilPermutasi" style="display: none;">titip hasil disini</p>
  <p id="statusKapasitas" style="display: none;">titip hasil status kapasitas disini</p>

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
          <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-map-location-dot"></i> Status Order <button type="button" class="btn btn-success rounded-pill"><span id="kapasitasMobil">0</span>/5</button></h1>
          <button type="button" class="btn btn-primary rounded mx-2" onclick="setCheck('back')">Back</button>
          <button type="button" class="btn btn-primary rounded mx-2" onclick="setCheck('next')">Next</button>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="padding: 0;">
          <div class="container text-start">
            <div class="row">
              <div class="col lokasiTujuan">
                <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="detailperjalananmaster" data-bs-toggle="tab" data-bs-target="#detailperjalananmaster" type="button" role="tab" aria-controls="detailperjalananmaster" aria-selected="true" onclick="">Detail Perjalanan</button>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="detailperjalananmaster-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    <!-- <p>Lokasi Berangkat Driver :</p>
                    <p>Lokasi Berangkat userx :</p>
                    <p>Lokasi Berangkat userx1 :</p>
                    <p>Lokasi Berangkat userx2 :</p> -->
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="finishOrder()">Finish Order</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal List User -->
  <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel"> <i class="fa-solid fa-users"></i> List User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="" class="modal-body">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#listUserBerdasarkanJarak" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Berdasarkan Jarak</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#listUserBerdasarkanPriorityWeight" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Berdasarkan Priority Weight</button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="listUserBerdasarkanJarak" role="tabpanel" aria-labelledby="home-tab" tabindex="0"></div>
            <div class="tab-pane fade" id="listUserBerdasarkanPriorityWeight" role="tabpanel" aria-labelledby="profile-tab" tabindex="0"></div>
          </div>
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

    // global scope arr untuk menyimpan data lokasi user 
    arrDataSemuaUser = []

    // global scoper arr manipulasi lokasi user
    var arrUserPrioritas = []
    var weight = 0

    var statusJarakBerangkat = false
    var statusJarakTujuan = false

    var arrTemp = []
    var arrTemp1 = []

    // global scope arr priority weight
    var arrPriority = []
    var arrUserBerdasarkanJarak = []

    // var array list user yang di pick up
    arrPickup = []

    // var global scope untuk fungsi permutasi
    var titikStartDriver = document.getElementById("end").innerText

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
            // console.log(response.results)
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

    // saat windows reload delete search live user tersebut
    if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
      deletePosisiUserSaatIni();
    }

    // view lokasi tujuan
    function viewLokasiTujuanDriver() {

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

          // set zoom
          map2.setZoom(18);

        })
        .catch((e) =>

          {
            window.alert("Maaf lokasi tidak ditemukan ")
            window.location.reload();
          }

        );

    }

    // insert posisi driver saat ini ke database 
    function insertPosisiDriverSaatIni() {

      let lokasiStart = document.getElementById("start").value
      let lokasiEnd = document.getElementById("end").value

      let DataLokasiUser = new FormData();
      DataLokasiUser.append("lokasiStart", lokasiStart);
      DataLokasiUser.append("lokasiEnd", lokasiEnd);

      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
          // insert berhasil
        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/insert_posisi_user_ajax.php");
      xmlHttp.send(DataLokasiUser);

    }

    // get data semua user
    function getDataSemuaUser() {

      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
          // console.log(this.responseText)
          data = JSON.parse(this.responseText);

          // console.log(data)
          arrDataSemuaUser = JSON.parse(this.responseText);

          console.log("Data semua user sekitar:", arrDataSemuaUser)

        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/view_user_sekitar_ajax.php");
      xmlHttp.send();

    }

    // view user sekitar 
    function viewUserSekitar() {
      // console.log(arrTemp.length)
      if (arrTemp.length == 0) {
        jarakBerangkatDirection()
      } else if (arrTemp1.length == 0) {
        jarakTujuanDirection()
      } else {
        // console.log(arrUserBerdasarkanJarak)
        // console.log(arrUserPrioritas)

        // check2 array duplikasi
        checkDuplicateArray()
        // 
        priorityWeight()

        // view berdasarkan array x
        viewListUserBerdasarkanJarak()
        // view berdasarkan array y
        viewListUserBerdasarkanPriority()
      }

    }

    // cek jarak
    function jarakBerangkatDirection() {

      const directionsService = new google.maps.DirectionsService();
      const directionsRenderer = new google.maps.DirectionsRenderer();

      for (let i = 1; i < arrDataSemuaUser.length; i++) {
        directionsService
          .route({
            origin: {
              query: arrDataSemuaUser[0]['lokasiEndDriverIni'],
            },
            destination: {
              query: arrDataSemuaUser[i]['lokasiEnd'],
            },
            travelMode: google.maps.TravelMode.DRIVING,
          })
          .then((response) => {

            // console.log("ini response cari data angka", response)
            // console.log("ini dari lokasi berangkat :", response.request.origin, "ke ", response.request.destination, i)

            // console.log("ekspetasi ini data berupa angka: ", response.routes[0].legs[0].distance.value)

            if (response.routes[0].legs[0].distance.value < 6000) {

              statusJarakTujuan = true

              jarak = response.routes[0].legs[0].distance.value
              waktu = response.routes[0].legs[0].duration.value
              // weight akumulasi dari lokasi tujuan driver ke lokasi tujuan driver
              weight = (jarak / 1000) + (waktu / 60)
              // console.log("weight berubah2", weight)

              // console.log(arrDataSemuaUser[i])

              arrDataSemuaUser[i]["weight"] = weight


              arrTemp.push(arrDataSemuaUser[i])
            } else {
              statusJarakTujuan = false
            }
          })
          .catch((e) => {
            console.log("error 123")
          });



      }

    }

    // cek jarak
    function jarakTujuanDirection() {

      const directionsService = new google.maps.DirectionsService();
      const directionsRenderer = new google.maps.DirectionsRenderer();

      // console.log("panjang", arrTemp.length)
      // console.log("isi", arrTemp)

      for (let i = 0; i < arrTemp.length; i++) {

        // console.log(arrDataSemuaUser[i]['lokasiStart'])
        // console.log(arrDataSemuaUser[0]['lokasiStartDriverIni'], arrTemp[i], i)

        directionsService
          .route({
            origin: {
              query: arrDataSemuaUser[0]['lokasiStartDriverIni'],
            },
            destination: {
              query: arrTemp[i]['lokasiStart'],
            },
            travelMode: google.maps.TravelMode.DRIVING,
          })
          .then((response) => {

            // console.log("ini response cari data angka", response)
            // console.log("ini dari lokasi berangkat :",response.request.origin,"ke ",response.request.destination)
            // console.log("ekspetasi ini data berupa angka: ",response.routes[0].legs[0].distance.value)

            if (response.routes[0].legs[0].distance.value < 6000) {

              statusJarakBerangkat = true


              jarak = response.routes[0].legs[0].distance.value
              waktu = response.routes[0].legs[0].duration.value
              // weight akumulasi dari lokasi tujuan driver ke lokasi tujuan driver
              weight = (jarak / 1000) + (waktu / 60)
              // console.log("weight berubah2", weight)

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

              console.log(response)
              gmarkers.push(marker);

              getWeightTujuan = arrTemp[i]["weight"]

              arrTemp[i]["weight"] = weight + getWeightTujuan

              arrTemp1.push(arrTemp[i])

              arrUserBerdasarkanJarak.push(arrTemp[i])


            } else {
              statusJarakBerangkat = false
            }






          })
          .catch((e) => {
            console.log("error 123")
          });





      }
    }

    // get data untuk priority weight
    function priorityWeight() {
      // arrPriority = arrTemp1
      arrPriority = []
      for (let i = 0; i < arrTemp1.length; i++) {
        arrPriority.push(arrTemp1[i])
      }

      bubbleSort(arrPriority)

    }

    function checkDuplicateArray() {

      // console.log(arrTemp1)
      // console.log(arrUserBerdasarkanJarak)

      bubbleSort(arrTemp1)

      // console.log(arrTemp1)

      for (let i = arrTemp1.length - 1; i > 1; i--) {
        arrTemp1.splice(i, 1);
      }

      // console.log(arrTemp1, " list arrTemp1 setelah di pop ")

      for (let i = 0; i < arrTemp1.length; i++) {
        for (let j = 0; j < arrUserBerdasarkanJarak.length; j++) {

          if (arrTemp1[i]['username'] == arrUserBerdasarkanJarak[j]['username']) {
            // console.log("xx")
            // arrTemp1[i]['username']
            // arrUserBerdasarkanJarak[j]['username']
            // arrTemp1[i]['username']
            // console.log( arrTemp1[i]['username'], " == ", arrUserBerdasarkanJarak[j]['username'])
            arrUserBerdasarkanJarak.splice(j, 1);
            // return
          }

        }
      }

      console.log(arrTemp1, " list arr lokasi user berdasarkan prioritas weight ")
      console.log(arrUserBerdasarkanJarak, " list arr lokasi user berdasarkan jarak ")

      console.log("rumus weight lokasi :  weightLokasiBerangkat = (jarak / 1000) + (waktu / 60) +  weightLokasiTujuan = (jarak / 1000) + (waktu / 60)")


    }
    // sort data priority berdasarkan weight terkecil
    function bubbleSort(items) {
      var length = items.length;
      //Number of passes
      for (var i = 0; i < length; i++) {
        //Notice that j < (length - i)
        for (var j = 0; j < (length - i - 1); j++) {
          //Compare the adjacent positions
          if (items[j]['weight'] > items[j + 1]['weight']) {
            //Swap the numbers
            var tmp = items[j]; //Temporary variable to hold the current number
            items[j] = items[j + 1]; //Replace current number with adjacent number
            items[j + 1] = tmp; //Replace adjacent number with current number
          }
        }
      }
    }

    function viewListUserBerdasarkanJarak() {

      $("#listUserBerdasarkanJarak").html("")

      for (let i = 0; i < arrUserBerdasarkanJarak.length; i++) {

        var cardUser =
          `

        <div class="card mt-3 listUserJarak"> 
          <h5 class="card-header">  username <span> weight 7 </span>  </h5>
            <div class="card-body">
              <p class="card-text"> Lokasi Berangkat: </p> 
              <p class="card-text"> Lokasi Tujuan: </p> 
              <button class="btn btn-success pickJarak">PICK-UP</button> 
            </div>
        </div>

      `
        // var get = document.getElementsByClassName("card mt-3 listUserWeight")


        $("#listUserBerdasarkanJarak").append(cardUser)

        document.getElementsByClassName("card mt-3 listUserJarak")[i].children[0].innerHTML = arrUserBerdasarkanJarak[i]['username']

        document.getElementsByClassName("card mt-3 listUserJarak")[i].children[1].children[0].innerHTML = "Lokasi Berangkat: " + arrUserBerdasarkanJarak[i]['lokasiStart']

        document.getElementsByClassName("card mt-3 listUserJarak")[i].children[1].children[1].innerHTML = "Lokasi Tujuan: " + arrUserBerdasarkanJarak[i]['lokasiEnd']

        // document.getElementsByClassName("btn btn-success pickWeight")[i].setAttribute("end", arrPriority[i]['lokasiEnd'])

        // document.getElementsByClassName("btn btn-success pickWeight")[i].setAttribute("start", arrPriority[i]['lokasiStart'])

        document.getElementsByClassName("btn btn-success pickJarak")[i].setAttribute('onclick', `pickUp("${arrUserBerdasarkanJarak[i]['lokasiStart']}","${arrUserBerdasarkanJarak[i]['lokasiEnd']}","${arrUserBerdasarkanJarak[i]['username']}")`)

        document.getElementsByClassName("btn btn-success pickJarak ")[i].setAttribute('id', `${arrUserBerdasarkanJarak[i]['username']}`)
      }


    }

    function viewListUserBerdasarkanPriority() {

      $("#listUserBerdasarkanPriorityWeight").html("")

      for (let i = 0; i < arrPriority.length; i++) {

        var cardUser =
          `

          <div class="card mt-3 listUserWeight"> 
            <h5 class="card-header">  username <span> weight 7 </span>  </h5>
              <div class="card-body">
                <p class="card-text"> Lokasi Berangkat: </p> 
                <p class="card-text"> Lokasi Tujuan: </p> 
                <button class="btn btn-success pickWeight">PICK-UP</button> 
              </div>
          </div>

        `
        // var get = document.getElementsByClassName("card mt-3 listUserWeight")


        $("#listUserBerdasarkanPriorityWeight").append(cardUser)

        document.getElementsByClassName("card mt-3 listUserWeight")[i].children[0].innerHTML = arrPriority[i]['username'] + "<span> ,weight: " + Math.round(arrPriority[i]['weight']) + "</span>"

        document.getElementsByClassName("card mt-3 listUserWeight")[i].children[1].children[0].innerHTML = "Lokasi Berangkat: " + arrPriority[i]['lokasiStart']

        document.getElementsByClassName("card mt-3 listUserWeight")[i].children[1].children[1].innerHTML = "Lokasi Tujuan: " + arrPriority[i]['lokasiEnd']

        // document.getElementsByClassName("btn btn-success pickWeight")[i].setAttribute("end", arrPriority[i]['lokasiEnd'])

        // document.getElementsByClassName("btn btn-success pickWeight")[i].setAttribute("start", arrPriority[i]['lokasiStart'])

        document.getElementsByClassName("btn btn-success pickWeight ")[i].setAttribute('onclick', `pickUp("${arrPriority[i]['lokasiStart']}","${arrPriority[i]['lokasiEnd']}","${arrPriority[i]['username']}")`)

        document.getElementsByClassName("btn btn-success pickWeight ")[i].setAttribute('id', `${arrPriority[i]['username']}`)
      }

    }


    // global scope array permutasi
    var permutasiStart = []
    var permutasiStartDriver = []
    var permutasiEnd = []
    var permutasiEndDriver = []

    var permutasiEndR = []
    var permutasiStartR = []



    // var handle
    var interval_1

    // saat button pickup diklik
    function pickUp(lokasiAsal, lokasiTujuan, name) {

      permutasiStartDriver = []

      document.getElementById(name).setAttribute('disabled', '');
      document.getElementById(name).innerText = "PICKED-UP";
      document.getElementById(name).className = "btn btn-info pickWeight";


      get = document.getElementById("kapasitasMobil").innerText

      permutasiStartDriver.push(document.getElementById("start").value)

      permutasiStartR.push(lokasiAsal)
      permutasiEndR.push(lokasiTujuan)

      console.log("permutasi end: " + permutasiEndR)
      console.log("permutasi start: " + permutasiStartR)

      permutasiStart = permutator(permutasiStartR)

      permutasiEnd = permutator(permutasiEndR)

      console.log("permutasi end: " + permutasiEnd)
      console.log("permutasi start: " + permutasiStart)

      if (get < 5) {

        interval_1 = setInterval(function() {
          insertDataPermutasi();
          index += 1

        }, 5000)


      } else {
        Swal.fire({
          position: 'center',
          icon: 'warning',
          title: 'Kapasitas Mobil Sudah Penuh',
          showConfirmButton: false,
          allowOutsideClick: false,
          timer: 2500
        })

        return
      }

      Swal.fire({
        position: 'center',
        icon: 'info',
        title: 'Mohon Menunggu Proses Pick-Up',
        showConfirmButton: false,
        allowOutsideClick: false,
        timer: 10000 * (permutasiStart.length * 2) + 1 * 5000
        // 5000+5000
      })


    }

    function cekKapasitasMobil() {

      x = 0
      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
          if (x == 0) {
            // lanjut
            return true
          } else {
            Swal.fire({
              position: 'center',
              icon: 'warning',
              title: 'Kapasitas Mobil Sudah Penuh',
              showConfirmButton: false,
              allowOutsideClick: false,
              timer: 2500
            })

            return false

          }
        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/cek_kapasitas_mobil_ajax.php");
      xmlHttp.send();
    }

    // fungsi permutasi
    function permutator(inputArr) {
      var results = [];

      function permute(arr, memo) {
        var cur,
          memo = memo || [];

        for (var i = 0; i < arr.length; i++) {
          cur = arr.splice(i, 1);
          if (arr.length === 0) {
            results.push(memo.concat(cur));
          }
          permute(arr.slice(), memo.concat(cur));
          arr.splice(i, 0, cur[0]);
        }

        return results;
      }

      return permute(inputArr);
    }

    var batasPageOrder = 0
    var counterPageOrder = 0
    var indexOrderSekarang = 0

    var masterArray = []
    var masterArrayR = []

    // global scope counter update buat fungsi insertDataPermutasi()
    var counterUpdate = 0
    var index = 0
    var index_2 = 0
    var hasil = 0
    var hasilLama = 0
    var arrJarakTerdekat = []
    var arrJarakTerdekatTujuan = []
    var counterCoba = 0

    // insert data permutasi
    function insertDataPermutasi() {
      console.log("banyaknya cara permutasi lokasi berangkat,", permutasiStart)
      console.log("banyaknya cara permutasi lokasi tujuan,", permutasiEnd)

      hasil = 0

      if (index <= permutasiStart.length) {
        // get value hasil total jarak permutasi
        getHasil = document.getElementById("hasilPermutasi").innerText

        if (index == permutasiStart.length) {

          getArrLokasiTerdekat(permutasiStart[index - 1], getHasil)

          // reset variable untuk dipakai di eksekusi fungsi tujuan
          // getHasil = -1
          document.getElementById("hasilPermutasi").innerText = "-1"
          hasilLama = 0
          counterCoba = 0


          permutasiEndDriver.push(arrJarakTerdekat[arrJarakTerdekat.length - 1])
          // console.log("array terkahir",permutasiEndDriver)

          return

        }

        if (getHasil > 0) {

          getArrLokasiTerdekat(permutasiStart[index - 1], getHasil)

        }

        for (let i = -1; i < permutasiStart[index].length - 1; i++) {

          eksekusiApiDirectionPermutasi(i)

        }

      } else if (index_2 <= permutasiEnd.length) {

        // console.log("sudah semua kemungkinan lokasi berangkat dicoba")

        getHasil = document.getElementById("hasilPermutasi").innerText

        // console.log(getHasil, " ini hasil harusnya ke reset")

        if (index_2 == permutasiEnd.length) {

          getArrLokasiTerdekatTujuan(permutasiEnd[index_2 - 1], getHasil)

          // insertDataUpdateLive()
          // console.log("ini sudah berakhir ekspetasi done semua")
          // console.log("berikut ini datanya sesuai ekspetasi atau tidak ",arrJarakTerdekat)
          // console.log("berikut ini datanya sesuai ekspetasi atau tidak ",arrJarakTerdekatTujuan)


          index_2 += 1
          batasPageOrder = 1
          return
        }

        if (getHasil > 0) {

          getArrLokasiTerdekatTujuan(permutasiEnd[index_2 - 1], getHasil)

        }

        for (let i = -1; i < permutasiEnd[index_2].length - 1; i++) {

          eksekusiApiDirectionPermutasiTujuan(i)

        }

        index_2 += 1
      } else {
        console.log("check interval")
        // console.log("ini array berangkat: ", arrJarakTerdekat)
        // console.log("ini array tujuan: ", arrJarakTerdekatTujuan)
        masterArray = []


        // finalized one way array
        masterArray.push(document.getElementById("start").value)

        for (let i = 0; i < arrJarakTerdekat.length; i++) {
          masterArray.push(arrJarakTerdekat[i])
        }
        for (let i = 0; i < arrJarakTerdekatTujuan.length; i++) {
          masterArray.push(arrJarakTerdekatTujuan[i])
        }

        console.log("ini rute terbaik: ", masterArray)
        setStatusOrder(indexOrderSekarang)

        // finalized one way array
        masterArrayR.push(document.getElementById("start").value)

        for (let i = 0; i < arrJarakTerdekat.length; i++) {
          masterArrayR.push(arrJarakTerdekat[i])
        }
        for (let i = 0; i < arrJarakTerdekatTujuan.length; i++) {
          masterArrayR.push(arrJarakTerdekatTujuan[i])
        }


        // updatePosisiDriverBasic(counterUpdate)
        // counterUpdate += 1;
        // reset 
        index = -1
        index_2 = 0
        clearInterval(interval_1);
        console.log("done")
      }



      // console.log("\n")
    }

    function getArrLokasiTerdekat(data, hasilBaru) {

      // console.log("ini data",data)

      if (hasilBaru < hasilLama || counterCoba == 0) {
        for (let i = 0; i < data.length; i++) {
          arrJarakTerdekat[i] = data[i]
        }

        hasilLama = hasilBaru
        counterCoba += 1
      }


    }

    function getArrLokasiTerdekatTujuan(data, hasilBaru) {
      console.log("ini data", data)

      if (hasilBaru < hasilLama || counterCoba == 0) {
        for (let i = 0; i < data.length; i++) {
          arrJarakTerdekatTujuan[i] = data[i]
        }

        hasilLama = hasilBaru
        counterCoba += 1
      }

    }

    function eksekusiApiDirectionPermutasi(i) {

      const directionsService = new google.maps.DirectionsService();
      const directionsRenderer = new google.maps.DirectionsRenderer();

      if (i == -1) {

        startOrigin = permutasiStartDriver[0]
        startDestination = permutasiStart[index][i + 1]

      } else {
        startOrigin = permutasiStart[index][i]
        startDestination = permutasiStart[index][i + 1]

      }

      directionsService
        .route({
          origin: {
            query: startOrigin,
          },
          destination: {
            query: startDestination,
          },
          travelMode: google.maps.TravelMode.DRIVING,
        })
        .then((response) => {
          directionsRenderer.setDirections(response);

          console.log(response)
          console.log(response.routes[0].legs[0].distance.value)

          hasil += parseInt(response.routes[0].legs[0].distance.value)

          document.getElementById("hasilPermutasi").innerText = hasil

        })
        .catch((e) => window.alert("Directions request failed due to " + status))

      // console.log("ini arr check isi ?",arrCoba)
      // console.log("ini index array sekarang", index)
    }

    function eksekusiApiDirectionPermutasiTujuan(i) {

      const directionsService = new google.maps.DirectionsService();
      const directionsRenderer = new google.maps.DirectionsRenderer();

      if (i == -1) {

        startOrigin = permutasiEndDriver[0]
        startDestination = permutasiEnd[index_2][i + 1]

      } else {
        startOrigin = permutasiEnd[index_2][i]
        startDestination = permutasiEnd[index_2][i + 1]

      }

      directionsService
        .route({
          origin: {
            query: startOrigin,
          },
          destination: {
            query: startDestination,
          },
          travelMode: google.maps.TravelMode.DRIVING,
        })
        .then((response) => {
          directionsRenderer.setDirections(response);

          console.log(response)
          console.log(response.routes[0].legs[0].distance.value)

          hasil += parseInt(response.routes[0].legs[0].distance.value)

          document.getElementById("hasilPermutasi").innerText = hasil

        })
        .catch((e) => window.alert("Directions request failed due to " + status))

      console.log("ini index array sekarang", index_2)
    }

    function setStatusOrder(indexOrder) {

      console.log(masterArray)
      // console.log(index)
      console.log(masterArray[indexOrder])
      console.log(masterArray[indexOrder + 1])

      // reset detail
      $("#detailperjalananmaster-pane").html("")

      // reset map
      initMap()

      // reset marker
      for (i = 0; i < gmarkers.length; i++) {
        gmarkers[i].setMap(null);
      }

      document.getElementById("kapasitasMobil").innerText = indexOrder

      const directionsService = new google.maps.DirectionsService();
      const directionsRenderer = new google.maps.DirectionsRenderer();

      var options = {
        suppressMarkers: true,
      }

      directionsRenderer.setOptions(options)
      directionsRenderer.setMap(map1);
      // arrJarakTerdekat
      // arrJarakTerdekatTujuan

      // direksi google map api untuk dapat detail data
      directionsService
        .route({
          origin: {
            query: masterArray[indexOrder],
          },
          destination: {
            query: masterArray[indexOrder + 1],
          },
          travelMode: google.maps.TravelMode.DRIVING,
        })
        .then((response) => {
          directionsRenderer.setDirections(response);

          // console.log("ini response", response)
          $("#detailperjalananmaster-pane").append("<p >" + "Rute:  <span id='rute'>" + parseInt(indexOrder + 1) + " </span>  </p>");
          $("#detailperjalananmaster-pane").append("<p>Lokasi Berangkat: " + `${response.request.destination.query}` + "</p>");
          $("#detailperjalananmaster-pane").append("<p>Lokasi Tujuan: " + `${response.request.destination.query}` + " </p>");
          $("#detailperjalananmaster-pane").append("<p>Intruksi: </p>");


          for (let i = 0; i < response.routes[0].legs[0].steps.length; i++) {
            // `${arrPriority[i]['username']}`
            $("#detailperjalananmaster-pane").append("<p> " + parseInt(i + 1) + "." + `${response.routes[0].legs[0].steps[i].instructions}` + "</p>");

          }

          // document.getElementById("")
          markerDriver(response.routes[0].legs[0].start_location.lat(), response.routes[0].legs[0].start_location.lng(), response.routes[0].legs[0].start_address)
          markerUser(response.routes[0].legs[0].end_location.lat(), response.routes[0].legs[0].end_location.lng(), response.routes[0].legs[0].end_address)


        })
        .catch((e) => window.alert("Directions request failed due to " + status))

    }

    // global scope arr data
    var arrData = []

    // search user
    function searchDriver() {
      // alamat tujuan kosong langsung stop
      if ($("#end").val() == "") {
        alert("Alamat Tujuan Masih Kosong")
        return;
      }

      $("#searchButton").css("display", "none");
      $("#cancelButton").css("display", "inline-block");
      $("#detailData").css("display", "flex");
      $('#end').attr('readonly', 'readonly');


      // view lokasi tujuan driver 
      // viewLokasiTujuanDriver();

      // insert posisi driver sekarang
      insertPosisiDriverSaatIni()

      // get data semua lokasi user beserta driver
      setTimeout(function() {
        getDataSemuaUser();
      }, 1000);

      setTimeout(function() {

        viewUserSekitar();

      }, 2000);

      setTimeout(function() {

        viewUserSekitar();


      }, 3000);

      setTimeout(function() {

        viewUserSekitar();

        arrTemp = []
        arrTemp1 = []
        arrDataSemuaUser = []
      }, 4000);

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

    // delete posisi user didatabase
    function deletePosisiUserSaatIni() {
      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
          // delete berhasil
        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/delete_posisi_user_ajax.php");
      xmlHttp.send();

    }

    function setCheck(status) {
      get = document.getElementById("rute").innerHTML

      // console.log(get)
      if (status == "back" && get == 1) {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Controller Tidak Bisa Back Karena Berada Pada Posisi Start',
          showConfirmButton: false,
          allowOutsideClick: false,
          timer: 2500
        })
        return

      } else if (status == "next") {
        // get=parseInt(get)+1
        // console.log(get)
        setStatusOrder(parseInt(get))
        document.getElementById("start").value = masterArray[parseInt(get)]
        document.getElementById("end").value = masterArray[parseInt(get) + 1]
        viewUserSekitarR()
      } else if (status == "back") {
        // get=parseInt(get)+1
        console.log(get)
        setStatusOrder(parseInt(get) - 2)
        document.getElementById("start").value = masterArray[parseInt(get) - 2]
        document.getElementById("end").value = masterArray[parseInt(get) + 1]
        viewUserSekitarR()
      }



    }

    window.initMap = initMap;

    // aos initiate
    $(function() {
      AOS.init({
        duration: 1200,
        once: true
      });
    });

    function markerDriver(lat, lng, street) {
      // Create an info window to share between markers.
      const infoWindow = new google.maps.InfoWindow();

      const marker = new google.maps.Marker({
        position: {
          lat: lat,
          lng: lng
        },
        map: map1,
        icon: {
          url: "https://cdn-icons-png.flaticon.com/512/3097/3097144.png",
          scaledSize: new google.maps.Size(38, 31)
        },
        title: "Posisi Driver : " + street,
        animation: google.maps.Animation.DROP
        // icon: "assets/cars.png"

      });

      marker.addListener("click", () => {
        infoWindow.close();
        infoWindow.setContent(marker.getTitle());
        infoWindow.open(marker.getMap(), marker);
      });

    }

    function markerUser(lat, lng, street) {
      // Create an info window to share between markers.
      const infoWindow = new google.maps.InfoWindow();

      const marker = new google.maps.Marker({
        position: {
          lat: lat,
          lng: lng
        },
        map: map1,
        icon: {
          url: "https://cdn-icons-png.flaticon.com/512/819/819814.png",
          scaledSize: new google.maps.Size(38, 31)
        },
        title: "Posisi User : " + street,
        animation: google.maps.Animation.DROP
        // icon: "assets/cars.png"

      });

      marker.addListener("click", () => {
        infoWindow.close();
        infoWindow.setContent(marker.getTitle());
        infoWindow.open(marker.getMap(), marker);
      });


    }

    function markerTujuanUser(lat, lng, street) {
      // Create an info window to share between markers.
      const infoWindow = new google.maps.InfoWindow();

      const marker = new google.maps.Marker({
        position: {
          lat: lat,
          lng: lng
        },
        map: map1,
        icon: {
          url: "https://cdn-icons-png.flaticon.com/512/819/819814.png",
          scaledSize: new google.maps.Size(38, 31)
        },
        title: "Lokasi Tujuan: " + street,
        animation: google.maps.Animation.DROP
        // icon: "assets/cars.png"

      });

      marker.addListener("click", () => {
        infoWindow.close();
        infoWindow.setContent(marker.getTitle());
        infoWindow.open(marker.getMap(), marker);
      });


    }

    function viewUserSekitarR() {
      console.log("View user sekitar")
      // insert posisi driver sekarang
      insertPosisiDriverSaatIni()

      // get data semua lokasi user beserta driver
      setTimeout(function() {
        getDataSemuaUser();
      }, 1000);

      setTimeout(function() {

        viewUserSekitar();

      }, 2000);

      setTimeout(function() {

        viewUserSekitar();


      }, 3000);

      setTimeout(function() {

        viewUserSekitar();

        arrTemp = []
        arrTemp1 = []
        arrDataSemuaUser = []
      }, 4000);



    }

    function finishOrder() {
      // alert anda telah memfinish order telah selesai
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Order Telah Finish',
        showConfirmButton: false,
        allowOutsideClick: false,
        timer: 2000
        // 5000+5000
      })

      setTimeout(function() {
        window.location.reload();

      }, 2000);

      // windows reloa
    }
  </script>

  <!-- Link CDN Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

  <!-- Link CDN sweetalert  -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>