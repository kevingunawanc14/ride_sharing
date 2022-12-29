<?php
require_once 'includes/connect.php';

// echo $_SESSION['username'];

//sql get status user buat tau ini user atau driver
$sql = 'SELECT * FROM USER WHERE username = ?';
$checksql = $pdo->prepare($sql);
$checksql->execute([$_SESSION['username']]);

$row = $checksql->fetch();




if ($row['status'] != 0) {
  echo '<script>window.location.href = "http://localhost/ride_sharing/ride_driver.php";</script>';
} else {
}




?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>University Ride Sharing - Ride User</title>
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

        <button id="ongoingButton" type="button" class="btn btn-dark animate__animated animate__pulse animate__infinite	infinite" style="display: none;" onclick=""><i class="fa-regular fa-hourglass"></i> ONGOING</button>


      </div>
    </div>
    <div id="detailData" class="row mt-3">

      <div class="col-12 col-sm-12 my-3">
        <!-- Button trigger modal -->
        <button id="lokasiTujuanModal" type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal" style="display: none;">
          Detail Perjalan
        </button>

      </div>
      <div class="col-12 col-sm-12 my-3">
        <!-- Button trigger modal -->
        <button id="statusOrderModal" type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal2" style="display: none;">
          Status Order
        </button>
      </div>
      <!-- 
      <div class="buatStatus">
        <p class="buatStatus_1">notset</p>
      </div> -->





    </div>
  </div>

  <p id="hasilPermutasi">titip hasil disini</p>

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

  <!-- Modal Lokasi Tujuan -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-map-location-dot"></i> Detail Perjalan</h1>
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
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal List Driver -->
  <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel"> <i class="fa-solid fa-car-side"></i> List Driver</h1>
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

  <!-- Modal Status Order -->
  <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-map-location-dot"></i> Status Order <button type="button" class="btn btn-success rounded-pill">0/0</button></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="padding: 0;">
          <div id="map3">

          </div>
          <div class="container text-start">
            <div class="row">
              <div class="col lokasiTujuan">
                <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="lokasi_berangkat" data-bs-toggle="tab" data-bs-target="#lokasi_berangkat" type="button" role="tab" aria-controls="lokasi_berangkat" aria-selected="true" onclick="gantiPilihanLokasi()">Lokasi Berangkat</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="lokasi_tujuan" data-bs-toggle="tab" data-bs-target="#lokasi_tujuan" type="button" role="tab" aria-controls="lokasi_tujuan" aria-selected="false" onclick="gantiPilihanLokasi()">Lokasi Tujuan</button>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="lokasi_berangkat-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    <!-- <p>Lokasi Berangkat Driver :</p>
                    <p>Lokasi Berangkat userx :</p>
                    <p>Lokasi Berangkat userx1 :</p>
                    <p>Lokasi Berangkat userx2 :</p> -->
                  </div>
                  <div class="tab-pane fade" id="lokasi_tujuan-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
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
          <!-- <button type="button" class="btn btn-primary">Finish Order</button> -->
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
    var map1, map2, map3

    // global scope interval live map
    var interval

    // global scope marker
    var gmarkers = [];

    // global scope data map update
    var mapUpdate = [];

    // var detail
    var biayaInsert, lokasiAsalInsert, LokasiTujuanInsert

    // global scope array permutasi
    var permutasiStart = []
    var permutasiStartDriver = []

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

      // console.log(lat,lng)
      // -7.342873875818059, 112.73978016990527
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
                url: "https://cdn-icons-png.flaticon.com/512/3710/3710297.png",
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

    // cancel search driver
    function cancelSearchDriver() {

      if (confirm("Pencarian Driver Akan Di Batalkan")) {

        $("#searchButton").css("display", "inline-block");
        $("#cancelButton").css("display", "none");
        $("#detailData").css("display", "none");

        // reset isi form tujuan
        document.getElementById("end").value = ""

        // activkan form bar biar bisa isi data lagi
        $('#end').removeAttr('readonly', 'readonly');


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

          // gak jalan
          map2.setZoom(18);



          $(".lokasiTujuan p").eq(0).html("Lokasi Asal &nbsp;&nbsp;&nbsp;&nbsp;: " + response.routes[0].legs[0].start_address)
          $(".lokasiTujuan p").eq(1).html("Lokasi Tujuan : " + response.routes[0].legs[0].end_address)

          $(".lokasiTujuan p").eq(2).html("Jarak &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: " + response.routes[0].legs[0].distance.text)

          // console.log(parseInt(response.routes[0].legs[0].distance.value / 1000))
          jarak = response.routes[0].legs[0].distance.value

          biaya = 0

          if (jarak < 2000) {
            $(".lokasiTujuan p").eq(3).html("Biaya &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Rp. " + (4 * 2000))
            biaya = 4 * 2000
          } else {
            $(".lokasiTujuan p").eq(3).html("Biaya &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Rp. " + (parseInt(jarak / 1000) * 4500))

            biaya = (parseInt(jarak / 1000) * 2000)
          }

          cekSaldo(biaya)

          biayaInsert = biaya
          lokasiAsalInsert = response.routes[0].legs[0].start_address
          lokasiTujuanInsert = response.routes[0].legs[0].end_address

        })
        .catch((e) =>

          {
            // window.alert("Maaf lokasi tidak ditemukan ")
            Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Maaf lokasi tidak ditemukan',
              showConfirmButton: false,
              allowOutsideClick: false,
              timer: 1500
            })
            setTimeout(function() {
              deletePosisiUserSaatIni()
              window.location.reload();
            }, 1500);


          }




        );











    }

    function viewDriverSekitar() {

      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

          data = JSON.parse(this.responseText);


          const directionsService = new google.maps.DirectionsService();
          const directionsRenderer = new google.maps.DirectionsRenderer();

          // console.log("xxx", data)

          var statusDekat = false;

          // compare lokasi berangkat dan lokasi tujuan
          for (let i = 1; i < data.length; i++) {
            // console.log("a")
            directionsService
              .route({
                origin: {
                  query: data[0]['lokasiEndUser'],
                },
                destination: {
                  query: data[i]['lokasiEndDriver'],
                },
                travelMode: google.maps.TravelMode.DRIVING,
              })
              .then((response) => {
                // directionsRenderer.setDirections(response);

                // console.log(response)
                // console.log(response.routes[0].legs[0].distance.value)
                if (response.routes[0].legs[0].distance.value < 3500) {
                  statusDekat = true
                } else {
                  statusDekat = false
                }

                // console.log(statusDekat)

                if (statusDekat == true) {

                  directionsService
                    .route({
                      origin: {
                        query: data[0]['lokasiStartUser'],
                      },
                      destination: {
                        query: data[i]['lokasiStartDriver'],
                      },
                      travelMode: google.maps.TravelMode.DRIVING,
                    })
                    .then((response) => {
                      // directionsRenderer.setDirections(response);

                      // console.log(response)
                      // console.log(response.routes[0].legs[0].distance.value)
                      if (response.routes[0].legs[0].distance.value < 3500) {
                        statusDekat = true
                      } else {
                        statusDekat = false
                      }

                      // console.log(response.routes[0].legs[0].start_location.lng())

                      // console.log(statusDekat)

                      if (statusDekat == true) {

                        marker = new google.maps.Marker({
                          position: {
                            lat: response.routes[0].legs[0].end_location.lat(),
                            lng: response.routes[0].legs[0].end_location.lng()
                          },
                          map: map1,
                          icon: {
                            url: "https://cdn-icons-png.flaticon.com/512/3097/3097144.png",
                            scaledSize: new google.maps.Size(38, 31)
                          },
                          animation: google.maps.Animation.DROP
                          // icon: "assets/cars.png"

                        });

                        // Push your newly created marker into the array:
                        gmarkers.push(marker);

                      }





                    })
                    .catch((e) => {
                      console.log("error 123")
                    });

                }





              })
              .catch((e) => {
                console.log("error 123")
              });



          }



          // console.log(statusDekat)







        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/view_driver_sekitar_ajax.php");
      xmlHttp.send();






    }

    function insertPosisiUserSaatIni() {
      // iki fungsine harus jalan terus 
      let lokasiStart = document.getElementById("start").value
      let lokasiEnd = document.getElementById("end").value

      let DataLokasiUser = new FormData();
      DataLokasiUser.append("lokasiStart", lokasiStart);
      DataLokasiUser.append("lokasiEnd", lokasiEnd);

      // console.log(DataLokasiUser)

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

    function cekSaldo(biaya) {

      let biayaPerjalanan = biaya

      let DataBiaya = new FormData();
      DataBiaya.append("biaya", biayaPerjalanan);

      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

          data = JSON.parse(this.responseText);

          // console.log(data)

          if (data[0]["status"] == "true") {
            // console.log("lanjut karena saldo masih ada")

          } else {
            // console.log("reload alert maaf saldo anda tidak cukup untuk perjalanan ini")
            Swal.fire({
              position: 'center',
              icon: 'warning',
              title: 'Saldo Anda Kurang ' + data[0]["saldoKurang"] + ' Untuk Melakukan Perjalanan Ini Silakan Isi Saldo Terlebih Dahulu',
              showConfirmButton: false,
              allowOutsideClick: false,
              timer: 2500
            })
            setTimeout(function() {
              deletePosisiUserSaatIni()
              window.location.reload();
            }, 2500);

          }

        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/cek_biaya_ajax.php");
      xmlHttp.send(DataBiaya);

    }


    function cekStatusUser() {


      $.ajax({
        url: "request/cek_status_user_ajax.php",
        cache: false,
        success: function(response) {
          data = JSON.parse(response);
          // console.log(data)

          if (data[0]['status'] != '0') {
            // console.log("button cancel di hidden ganti ongoing")
            $("#cancelButton").css("display", "none");
            $("#ongoingButton").css("display", "inline-block");

            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Menemukan Driver',
              showConfirmButton: false,
              allowOutsideClick: false,
              timer: 1000
            })

          } else {
            // console.log("button cancel tidak dihidden / belum dipick up oleh driverxx")

            Swal.fire({
              position: 'center',
              icon: 'warning',
              title: 'Belum Menemukan Driver',
              showConfirmButton: false,
              allowOutsideClick: false,
              timer: 2500
            })

            setTimeout(function() {
              window.location.reload();
            }, 2500);


          }
        }

      });
      // const xmlHttp = new XMLHttpRequest();
      // xmlHttp.onload = function() {
      //   if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
      //     callback(xmlHttp.response, xmlHttp.status);
      //     // jadi lek misal dia belum mempunyai id driver berarti dia belum di pick up maka tombol cancel masih on tapi ketika sudah di pick up maka tombol cancel menjadi ongoing

      //     data = JSON.parse(this.responseText);
      //     // console.log(this.responseText)

      //     if (data[0]['status'] != '0') {
      //       console.log("button cancel di hidden ganti ongoing")
      //       $("#cancelButton").css("display", "none");
      //       $("#ongoingButton").css("display", "inline-block");

      //       // $("#statusOrderModal").css("display", "inline-block");
      //       status = "a";
      //       return status
      //     } else {
      //       console.log("button cancel tidak dihidden / belum dipick up oleh driverxx")
      //       status = "b";
      //       return status


      //     }



      //   } else {
      //     alert("Error!");
      //   }
      // }
      // xmlHttp.open("POST", "request/cek_status_user_ajax.php");
      // xmlHttp.send();

      // return status;



    }

    function statusOrderLive() {

      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

          // console.log(this.responseText)
          console.log(this.responseText)

          if (this.responseText == "") {
            console.log("a")
          } else {
            console.log("b")
            data = JSON.parse(this.responseText);
            console.log(data)

            arrayLokasi = [];
            $("#lokasi_berangkat-pane").html("")
            $("#lokasi_tujuan-pane").html("")

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

            map3 = new google.maps.Map(document.getElementById('map3'), options);

            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer();

            directionsRenderer.setMap(map3);


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
                console.log("xxx")
                console.log(response)
                const route = response.routes[0];


                var totalJarak = 0;
                for (let i = 0; i < route.legs.length; i++) {
                  const routeSegment = i + 1;

                  $("#lokasi_berangkat-pane").append("<p>" + "Rute Penjemputan : " + routeSegment + "</p>")
                  $("#lokasi_berangkat-pane").append("<p>" + route.legs[i].start_address + "</p>")
                  $("#lokasi_berangkat-pane").append("<p>" + route.legs[i].end_address + "</p>")
                  $("#lokasi_berangkat-pane").append("<p>" + route.legs[i].distance.text + "</p>")

                  totalJarak += route.legs[i].distance.text;
                  console.log(totalJarak)

                }


                // rename class kembali ke button lokasi berangkat yang aktif
                $("#lokasi_berangkat").attr('class', 'nav-link active');
                // document.getElementById("lokasi_berangkat").className = "nav-link active"

                // $("#lokasi_tujuan-pane").append("<p>xx</p>")



              })
              .catch((e) => window.alert("Directions request failed due to " + status));

          }


          // data = JSON.parse(this.responseText);
          // console.log(data)





        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/view_order_live_user_ajax.php");
      xmlHttp.send();




    }

    function gantiPilihanLokasi() {

      // console.log($('#lokasi_berangkat').attr('aria-selected'))

      let statusPilihanBerangkat = $('#lokasi_berangkat').attr('class');

      console.log("eee")
      console.log(statusPilihanBerangkat)


      if (statusPilihanBerangkat == "nav-link active") {
        const xmlHttp = new XMLHttpRequest();
        xmlHttp.onload = function() {
          if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

            // console.log(this.responseText)
            console.log(this.responseText)

            if (this.responseText == "") {
              console.log("a")
            } else {
              console.log("b")
              data = JSON.parse(this.responseText);
              console.log(data)

              arrayLokasi = [];
              $("#lokasi_berangkat-pane").html("")
              $("#lokasi_tujuan-pane").html("")

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

              map3 = new google.maps.Map(document.getElementById('map3'), options);

              const directionsService = new google.maps.DirectionsService();
              const directionsRenderer = new google.maps.DirectionsRenderer();

              directionsRenderer.setMap(map3);


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
                  console.log("xxx")
                  console.log(response)
                  const route = response.routes[0];


                  var totalJarak = 0;
                  for (let i = 0; i < route.legs.length; i++) {
                    const routeSegment = i + 1;

                    $("#lokasi_berangkat-pane").append("<p>" + "Rute Penjemputan : " + routeSegment + "</p>")
                    $("#lokasi_berangkat-pane").append("<p>" + route.legs[i].start_address + "</p>")
                    $("#lokasi_berangkat-pane").append("<p>" + route.legs[i].end_address + "</p>")
                    $("#lokasi_berangkat-pane").append("<p>" + route.legs[i].distance.text + "</p>")

                    totalJarak += route.legs[i].distance.text;
                    console.log(totalJarak)

                  }




                  // $("#lokasi_tujuan-pane").append("<p>xx</p>")



                })
                .catch((e) => window.alert("Directions request failed due to " + status));

            }


            // data = JSON.parse(this.responseText);
            // console.log(data)





          } else {
            alert("Error!");
          }
        }
        xmlHttp.open("POST", "request/view_order_live_user_ajax.php");
        xmlHttp.send();

      } else {
        // artine sg aktif iku kan sg lokasi tujuan
        const xmlHttp = new XMLHttpRequest();
        xmlHttp.onload = function() {
          if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

            // console.log(this.responseText)
            console.log(this.responseText)

            if (this.responseText == "") {
              console.log("a")
            } else {
              console.log("b")
              data = JSON.parse(this.responseText);
              console.log(data)

              arrayLokasi = [];
              $("#lokasi_berangkat-pane").html("")
              $("#lokasi_tujuan-pane").html("")

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

              map3 = new google.maps.Map(document.getElementById('map3'), options);

              const directionsService = new google.maps.DirectionsService();
              const directionsRenderer = new google.maps.DirectionsRenderer();

              directionsRenderer.setMap(map3);


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
                  console.log("xxx")
                  console.log(response)
                  const route = response.routes[0];


                  var totalJarak = 0;
                  for (let i = 0; i < route.legs.length; i++) {
                    const routeSegment = i + 1;

                    $("#lokasi_berangkat-pane").append("<p>" + "Rute Tujuan : " + routeSegment + "</p>")
                    $("#lokasi_berangkat-pane").append("<p>" + route.legs[i].start_address + "</p>")
                    $("#lokasi_berangkat-pane").append("<p>" + route.legs[i].end_address + "</p>")
                    $("#lokasi_berangkat-pane").append("<p>" + route.legs[i].distance.text + "</p>")

                    totalJarak += route.legs[i].distance.text;
                    console.log(totalJarak)

                  }




                  // $("#lokasi_tujuan-pane").append("<p>xx</p>")



                })
                .catch((e) => window.alert("Directions request failed due to " + status));

            }


            // data = JSON.parse(this.responseText);
            // console.log(data)





          } else {
            alert("Error!");
          }
        }
        xmlHttp.open("POST", "request/view_order_live_user_ajax.php");
        xmlHttp.send();
      }

    }

    // saat windows reload delete search live user tersebut
    if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
      deletePosisiUserSaatIni();
    }

    function updatePosisiDriverPermutasi() {
      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

          // console.log(this.responseText)
          data = JSON.parse(this.responseText);

          console.log(data)

          arrayLokasi = [];
          arrayLokasiPermutasi = [];


          // data ke 0 start sebagai start awal di way point
          arrayLokasi.push(data[0]['lokasiStartDriver'])
          // array.push(data[0]['lokasiEndDriverIni'])

          // data waypoint dipermutasi dahulu semua kemungkinannya
          for (let i = 1; i < data.length; i++) {
            arrayLokasi.push(data[i]['lokasiStartUser'])
            arrayLokasiPermutasi.push(data[i]['lokasiStartUser'])
          }

          console.log(arrayLokasiPermutasi)

          // permutator(arrayLokasi)

          // console.log(permutator(arrayLokasiPermutasi))

          getPermutasi = permutator(arrayLokasiPermutasi);

          const directionsService = new google.maps.DirectionsService();
          const directionsRenderer = new google.maps.DirectionsRenderer();

          directionsRenderer.setMap(map3);


          var waypts = [];

          // console.log("ini array lokasi", arrayLokasi)
          // console.log(arrayLokasi[0])
          // console.log("double loop")

          console.log(getPermutasi)


          for (let i = 0; i < getPermutasi.length; i++) {
            for (let j = 0; j < getPermutasi[0].length; j++) {

              // console.log("ini location yang akan di push", getPermutasi[0].length)

              // console.log("ini location yang akan di push", getPermutasi[i][j])
              // console.log("ini titik start", arrayLokasi[0])
              // console.log("ini titik destinasi", getPermutasi[i][getPermutasi[i].length - 1])

              waypts.push({
                location: getPermutasi[i][j],
                stopover: true,
              });

              directionsService
                .route({
                  origin: arrayLokasi[0],
                  destination: getPermutasi[i][getPermutasi[i].length - 1],
                  waypoints: waypts,
                  optimizeWaypoints: true,
                  travelMode: google.maps.TravelMode.DRIVING,
                })
                .then((response) => {
                  console.log(response)

                  const route = response.routes[0];

                  totalJarak = 0
                  // For each route, display summary information.
                  for (let i = 0; i < route.legs.length; i++) {

                    totalJarak += route.legs[i].distance.value()




                  }

                  console.log(totalJarak)



                })
                .catch((e) => window.alert("Directions request failed due to " + status));

            }

          }


          console.log(waypts)





        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/update_posisi_driver_ajax.php");
      xmlHttp.send();



    }

    function getDataUpdatePosisiDriver() {

      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

          data = JSON.parse(this.responseText);
          // console.log(this.responseText)
          // console.log("ini data dari sql ", data)

          // mapUpdate = data

          // console.log("ini array map update", mapUpdate)


          permutasiStartDriver.push((data[0]['lokasiStartDriver']))

          // console.log(permutator(mapUpdate))

          for (let i = 1; i < data.length; i++) {
            permutasiStart.push(data[i]['lokasiStartUser'])
          }

          // console.log(permutasiStart)

          // console.log(permutator(permutasiStart))

          permutasiStart = permutator(permutasiStart)



          // console.log(permutasiStart[0])
          // console.log(permutasiStart[0][0])


          // for (let i = 0; i < 1; i++) {
          //   for (let j = 0; j < permutasiStart[i].length - 1; j++) {

          //     // permutasiDelay(permutasiStart[i][j], permutasiStart[i][j + 1])

          //     const directionsService = new google.maps.DirectionsService();
          //     const directionsRenderer = new google.maps.DirectionsRenderer();

          //     directionsService
          //       .route({
          //         origin: {
          //           query: permutasiStart[i][j],
          //         },
          //         destination: {
          //           query: permutasiStart[i][j + 1],
          //         },
          //         travelMode: google.maps.TravelMode.DRIVING,
          //       })
          //       .then((response) => {
          //         directionsRenderer.setDirections(response);


          //         // hasil+= response.routes[0].legs[0].distance.value

          //         console.log(i, j)

          //         console.log(response)
          //         console.log(response.routes[0].legs[0].distance.value)




          //       })
          //       .catch((e) => window.alert("Directions request failed due to " + status))

          //   }
          // }



        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/update_posisi_driver_ajax.php");
      xmlHttp.send();




    }

    function permutasiDelay(origin, end) {

      const directionsService = new google.maps.DirectionsService();
      const directionsRenderer = new google.maps.DirectionsRenderer();

      // setTimeout(function() {
      directionsService
        .route({
          origin: {
            query: origin,
          },
          destination: {
            query: end,
          },
          travelMode: google.maps.TravelMode.DRIVING,
        })
        .then((response) => {
          directionsRenderer.setDirections(response);


          // hasil+= response.routes[0].legs[0].distance.value

          console.log(i, j)

          console.log(response)
          console.log(response.routes[0].legs[0].distance.value)




        })
        .catch((e) => window.alert("Directions request failed due to " + status))
      // }, 5000);

    }

    function insertDataUpdateLive() {

      // let DataMapLiveUpdate = new FormData();

      var DataMapLiveUpdate = new FormData();
      var json_arr = JSON.stringify(mapUpdate);

      console.log(mapUpdate)

      DataMapLiveUpdate.append('data', json_arr);



      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

          console.log(this.responseText)

        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/insert_data_live_update_ajax.php");
      xmlHttp.send(DataMapLiveUpdate);

    }

    function updatePosisiDriverBasic(counter) {


      var dataCounter = new FormData();

      dataCounter.append('dataCounter', counterUpdate);


      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

          if (this.responseText == "order selesai") {

            finishUpOrder();

            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Order Selesai Silakan Check History Anda ',
              showConfirmButton: false,
              allowOutsideClick: false,
              timer: 2500
            })
            setTimeout(function() {
              window.location.reload();
            }, 2500);
            return
          }


          data = JSON.parse(this.responseText);


          const directionsService = new google.maps.DirectionsService();
          const directionsRenderer = new google.maps.DirectionsRenderer();

          console.log("test xx", data)
          directionsService
            .route({
              origin: {
                query: data[0]["lokasiUpdate"],
              },
              destination: {
                query: data[0]["lokasiUpdate"],
              },
              travelMode: google.maps.TravelMode.DRIVING,
            })
            .then((response) => {
              directionsRenderer.setDirections(response);

              console.log("ini response", response)
              console.log("ini responsex", gmarkers)

              // hapus marker selain alamat lokasi user dan mobil
              for (i = 1; i < gmarkers.length; i++) {
                gmarkers[i].setMap(null);
              }

              marker = new google.maps.Marker({
                position: {
                  lat: response.routes[0].legs[0].end_location.lat(),
                  lng: response.routes[0].legs[0].end_location.lng()
                },
                map: map1,
                icon: {
                  url: "https://cdn-icons-png.flaticon.com/512/3097/3097144.png",
                  scaledSize: new google.maps.Size(38, 31)
                },
                animation: google.maps.Animation.DROP
                // icon: "assets/cars.png"

              });

              // Push your newly created marker into the array:
              gmarkers.push(marker);


            })
            .catch((e) => {});




        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/update_live_update_ajax.php");
      xmlHttp.send(dataCounter);

    }

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

    function finishUpOrder() {

      let DataPerjalanan = new FormData();
      DataPerjalanan.append("biaya", biayaInsert);
      DataPerjalanan.append("lokasiAsal", lokasiAsalInsert);
      DataPerjalanan.append("lokasiTujuan", lokasiTujuanInsert);

      console.log("aaa", biaya, lokasiAsalInsert, lokasiTujuanInsert)

      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

          console.log("xxx", this.responseText)

        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/finish_up_order_ajax.php");
      xmlHttp.send(DataPerjalanan);

    }

    function updateSaldo() {

      let DataPerjalanan = new FormData();
      DataPerjalanan.append("biaya", biayaInsert);

      console.log("yyy", biaya, lokasiAsalInsert, LokasiTujuanInsert)

      const xmlHttp = new XMLHttpRequest();
      xmlHttp.onload = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

          console.log("yyyyyxx", this.responseText())

        } else {
          alert("Error!");
        }
      }
      xmlHttp.open("POST", "request/update_saldo_ajax.php");
      xmlHttp.send(DataPerjalanan)
    }

    var index = 0
    var hasil = 0

    function insertDataPermutasi(index) {
      // data diinsert ke database tiap x detik nanti akan dipilih jarak yang minimal
      const directionsService = new google.maps.DirectionsService();
      const directionsRenderer = new google.maps.DirectionsRenderer();
      // console.log(index)

      // console.log(index)
      // console.log(permutasiStart)
      // console.log(permutasiStart.length)


      // console.log(permutasiStartDriver)

      hasil = 0
      arrCoba = []
      if (index < permutasiStart.length) {

        getHasil = document.getElementById("hasilPermutasi").innerText
        // console.log(getHasil)

        if (getHasil > 0) {
          // console.log("a")
          coba(permutasiStart[index - 1], getHasil)
        }
        // coba(hasil,permutasiStart[index])

        for (let i = -1; i < permutasiStart[index].length - 1; i++) {

          if (i == -1) {

            startOrigin = permutasiStartDriver[0]
            startDestination = permutasiStart[0][0]

          } else {
            startOrigin = permutasiStart[index][i]
            startDestination = permutasiStart[index][i + 1]
            // console.log(permutasiStart[index][i])
            // console.log(permutasiStart[index][i + 1])
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


              hasil += parseInt(response.routes[0].legs[0].distance.value)

              document.getElementById("hasilPermutasi").innerText = hasil

              // console.log("ini response",response)
              // console.log("ini nilai jaraknya", response.routes[0].legs[0].distance.value, " dari ",response.request.origin.query," menuju ",response.request.destination.query)

              // console.log(index,",",i,",",permutasiStart[index].length)

              // console.log("indexing",i)
              // if (i == permutasiStart[index].length - 2) {
              //   // console.log(index,",",i,",",permutasiStart[index].length)
              //   // coba(hasil, permutasiStart[index])
              // }
              // console.log("ini index",i)
              // console.log("ini arr check isi ?",arrCoba)


            })
            .catch((e) => window.alert("Directions request failed due to " + status))

          // console.log("ini arr check isi ?",arrCoba)

        }

      } else {
        console.log("sudah semua kemungkinan dicoba")
      }

      // console.log("ini hasil",hasil)
      // console.log("ini hasil dari tag p",document.getElementById("hasilPermutasi").innerText)
      // setTimeout(coba(permutasiStart[index]),5000)




      console.log("\n")
    }

    var arrJarakTerdekat = []
    var hasilLama = 0
    var counterCoba = 0

    function coba(data, hasilBaru) {

      if (hasilBaru < hasilLama || counterCoba == 0) {
        arrJarakTerdekat = data
        arrJarakTerdekat += ", "+hasilBaru
        hasilLama = hasilBaru
        counterCoba+=1
      }

      console.log(arrJarakTerdekat)
    }


    var counterUpdate = 0
    // search driver
    function searchDriver() {
      if ($("#end").val() == "") {
        alert("Alamat Tujuan Masih Kosong")
        return;
      }

      $("#searchButton").css("display", "none");
      $("#cancelButton").css("display", "inline-block");
      $("#lokasiTujuanModal").css("display", "inline-block");
      $('#end').attr('readonly', 'readonly');

      // view lokasi tujuan 
      viewLokasiTujuan();

      // insert posisi user sekarang disearch live
      insertPosisiUserSaatIni();

      // view driver sekitar secara live sekali saja
      setTimeout(function() {
        viewDriverSekitar();
      }, 5000);

      // cek user sudah dijemput atau belum
      setTimeout(function() {
        cekStatusUser();
        getDataUpdatePosisiDriver();
      }, 10000);


      setInterval(function() {
        insertDataPermutasi(index);
        index += 1
      }, 11000)

      // setTimeout(function() {
      //   insertDataUpdateLive();
      // }, 15000);

      // interval = setInterval(function() {

      //   updatePosisiDriverBasic(counterUpdate);
      //   // updatePosisiDriverPermutasi();
      //   counterUpdate += 1;
      // }, 17000);






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

  <!-- Link CDN sweetalert  -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>