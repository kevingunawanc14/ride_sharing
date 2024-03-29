<?php
require_once 'includes/connect.php';

//sql check status user / driver
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


    <div class="container-fluid text-center">
        <div class="row">
            <div class="col-8">
                <div id="map" class="mapLoading text-center"></div>
            </div>
            <div class="col-4">
                <div style="max-height: 500px;" class="overflow-auto" id="debugView">
                    <p class="fs-2 text">View Request</p>
                </div>
            </div>
        </div>
    </div>

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

    <p id="hasilPermutasi" style="display: none;">titip hasil disini</p>

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

        // global scope data map update
        var mapUpdate = [];

        // var detail
        var biayaInsert, lokasiAsalInsert, LokasiTujuanInsert

        // global scope array permutasi
        var permutasiStart = []
        var permutasiStartDriver = []
        var permutasiEnd = []
        var permutasiEndDriver = []

        // global scope counter update buat fungsi insertDataPermutasi()
        var counterUpdate = 0
        var index = 0
        var index_2 = 0
        var hasil = 0
        var hasilLama = 0
        var arrJarakTerdekat = []
        var arrJarakTerdekatTujuan = []
        var counterCoba = 0

        // global scope variabel buat fungsi insertDataUpdateLive()
        var dataUpdateLive = []

        // global scope varibael buat fungsi updatePosisiDriverBasic()
        var statusGantiFungsiDireksi = false

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

        // saat window di load ambil lokasi user
        window.onload = function getLocation() {

            if (navigator.geolocation) {
                // run fungsi showPosition()
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }


        }

        // ambil lokasi user saat ini
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

        // view detail perjalanan
        function viewLokasiTujuan() {

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

                    // set zoom map modal 
                    map1.setZoom(18);

                    $(".lokasiTujuan p").eq(0).html("Lokasi Asal &nbsp;&nbsp;&nbsp;&nbsp;: " + response.routes[0].legs[0].start_address)
                    $(".lokasiTujuan p").eq(1).html("Lokasi Tujuan : " + response.routes[0].legs[0].end_address)

                    $(".lokasiTujuan p").eq(2).html("Jarak &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: " + response.routes[0].legs[0].distance.text)

                    jarak = response.routes[0].legs[0].distance.value

                    biaya = 0

                    // rumus biaya
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

        // cek saldo  
        function cekSaldo(biaya) {

            let biayaPerjalanan = biaya

            let DataBiaya = new FormData();
            DataBiaya.append("biaya", biayaPerjalanan);

            const xmlHttp = new XMLHttpRequest();
            xmlHttp.onload = function() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

                    data = JSON.parse(this.responseText);

                    if (data[0]["status"] == "true") {
                        // lanjut saldo masih ada
                    } else {

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

        // insert posisi user ke database
        function insertPosisiUserSaatIni() {

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

            return "check2";

        }

        // view driver sekitar
        function viewDriverSekitar() {

            const xmlHttp = new XMLHttpRequest();
            xmlHttp.onload = function() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

                    data = JSON.parse(this.responseText);

                    const directionsService = new google.maps.DirectionsService();
                    const directionsRenderer = new google.maps.DirectionsRenderer();


                    var statusDekat = false;

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

                                if (response.routes[0].legs[0].distance.value < 3500) {
                                    statusDekat = true
                                } else {
                                    statusDekat = false
                                }

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

                                            if (response.routes[0].legs[0].distance.value < 3500) {
                                                statusDekat = true
                                            } else {
                                                statusDekat = false
                                            }

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

                                                });

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

                } else {
                    alert("Error!");
                }
            }
            xmlHttp.open("POST", "request/view_driver_sekitar_ajax.php");
            xmlHttp.send();

        }

        // cek status user sudah dijemput atau belum
        function cekStatusUser() {

            $.ajax({
                url: "request/cek_status_user_ajax.php",
                cache: false,
                success: function(response) {
                    data = JSON.parse(response);

                    if (data[0]['status'] != '0') {

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

        }

        // get all data lokasi dari database
        function getDataUpdatePosisiDriver() {

            const xmlHttp = new XMLHttpRequest();
            xmlHttp.onload = function() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

                    data = JSON.parse(this.responseText);
                    // console.log(data)
                    permutasiStartDriver.push((data[0]['lokasiStartDriver']))

                    for (let i = 1; i < data.length; i++) {
                        // push semua data lokasi berangkat dan tujuan user
                        permutasiStart.push(data[i]['lokasiStartUser'])
                        permutasiEnd.push(data[i]['lokasiEndUser'])

                    }   

                    // for (let i = 0; i < data.length; i++) {
                    //     // push semua data lokasi berangkat dan tujuan user
                    //     $("#debugView").append("<p> Lokasi berangkat user-user lainnya:"+  data[i] +" </p>")


                    // }
                    // for (let i = 0; i < data.length; i++) {
                    //     // push semua data lokasi berangkat dan tujuan user
                    //     $("#debugView").append("<p> Lokasi tujuan user-user lainnya:"+  data[i] +" </p>")


                    // }

                    permutasiStart = permutator(permutasiStart)

                    permutasiEnd = permutator(permutasiEnd)

                    console.log("ekspetasi semua kemungkinan lokasi berangkat user", permutasiStart)

                    console.log("ekspetasi semua kemungkinan lokasi tujuan user ", permutasiEnd)


                    $("#debugView").append("<p> Ekspetasi semua kemungkinan lokasi berangkat user: </p>")

                    for (let i = 0; i < permutasiStart.length; i++) {
                        // push semua data lokasi berangkat dan tujuan user
                        $("#debugView").append("<p class='fs-6'>  ke- " + parseInt(i) + " " + permutasiStart[i] + "</p>")


                    }

                    $("#debugView").append("<p> Ekspetasi semua kemungkinan lokasi tujuan user: ke</p>")

                    for (let i = 0; i < permutasiEnd.length; i++) {
                        // push semua data lokasi berangkat dan tujuan user
                        $("#debugView").append("<p class='fs-6'> ke - " + parseInt(i) + " " + permutasiEnd[i] + "</p>")


                    }

                } else {
                    alert("Error!");
                }
            }
            xmlHttp.open("POST", "request/update_posisi_driver_ajax.php");
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

        // insert data permutasi
        function insertDataPermutasi(index) {

            hasil = 0
            console.log(arrJarakTerdekat, arrJarakTerdekatTujuan)

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

                    // console.log(arrJarakTerdekat)
                    permutasiEndDriver.push(arrJarakTerdekat[arrJarakTerdekat.length - 1])

                    // console.log("test masuk sini atau tidak")
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

                if (index_2 == permutasiEnd.length) {

                    getArrLokasiTerdekatTujuan(permutasiEnd[index - 1], getHasil)

                    insertDataUpdateLive()
                    console.log(arrJarakTerdekat, arrJarakTerdekatTujuan)
                    // console.log("ini sudah berakhir ekspetasi done semua")

                    index_2 += 1

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
                console.log("ekspetasi cetak ini saja")

                updatePosisiDriverBasic(counterUpdate)
                counterUpdate += 1;


            }

            // console.log("\n")
        }

        function getArrLokasiTerdekat(data, hasilBaru) {

            if (hasilBaru < hasilLama || counterCoba == 0) {
                for (let i = 0; i < data.length; i++) {
                    arrJarakTerdekat[i] = data[i]
                }

                hasilLama = hasilBaru
                counterCoba += 1
            }


        }

        function getArrLokasiTerdekatTujuan(data, hasilBaru) {

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

                    $("#debugView").append("<p> Hasil response lokasi asal,lokasi tujuan,jarak " + response.routes[0].legs[0].end_address+" "+
                        response.routes[0].legs[0].start_address +" value jaraknya "+  "<b>"+ response.routes[0].legs[0].distance.value +  "<b>" +" "+i+"</p>")

                    console.log(response)
                    hasil += parseInt(response.routes[0].legs[0].distance.value)

                    document.getElementById("hasilPermutasi").innerText = hasil


                })
                .catch((e) => window.alert("Directions request failed due to " + status))

            // console.log("ini arr check isi ?",arrCoba)
            console.log("ini index array sekarang", index)
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

                    $("#debugView").append("<p> hasil response lokasi asal,lokasi tujuan,jarak " + response.routes[0].legs[0].end_address+
                        response.routes[0].legs[0].start_address + "<b>"+response.routes[0].legs[0].distance.value+ "<b>" + index +" "+ i + "</p>")

                    hasil += parseInt(response.routes[0].legs[0].distance.value)

                    document.getElementById("hasilPermutasi").innerText = hasil

                })
                .catch((e) => window.alert("Directions request failed due to " + status))

            console.log("ini index array sekarang", index_2)
        }

        // insert data hasil permutasi ke database
        function insertDataUpdateLive() {

            // push lokasi terdekat berangkat
            for (let i = 0; i < arrJarakTerdekat.length; i++) {
                dataUpdateLive.push(arrJarakTerdekat[i])
            }

            // push lokasi terdekat tujuan
            for (let i = 0; i < arrJarakTerdekatTujuan.length; i++) {
                dataUpdateLive.push(arrJarakTerdekatTujuan[i])
            }

            // console.log("ekspetasi data kegabung antara arrJarakTerdekat dengan arrJarakTerdekatTujuan", dataUpdateLive)

            var DataMapLiveUpdate = new FormData();
            var json_arr = JSON.stringify(dataUpdateLive);

            DataMapLiveUpdate.append('dataLokasiStart', permutasiStartDriver[0]);
            DataMapLiveUpdate.append('dataLokasiTujuan', json_arr);

            const xmlHttp = new XMLHttpRequest();
            xmlHttp.onload = function() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {

                    console.log("ekspetasi jumlah data 1 untuk lokasi berangkat lalu ekspetasi jumlah data banyak x untuk lokasi tujuan, ekspetasi di database terisi banyak x data", this.responseText)
                    $("#debugView").append("<p> hasil rute terbaik " + this.responseText + "</p>")
                } else {
                    alert("Error!");
                }
            }
            xmlHttp.open("POST", "request/insert_data_live_update_ajax.php");
            xmlHttp.send(DataMapLiveUpdate);

        }

        // mengupdate posisi driver dari urutan hasil permutasi yang ada di database
        function updatePosisiDriverBasic(counter) {

            // reset router
            initMap()

            // reset marker
            for (i = 0; i < gmarkers.length; i++) {
                gmarkers[i].setMap(null);
            }

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


                    if (statusGantiFungsiDireksi == false) {
                        direksi_1(data[0]["lokasiUpdate"])
                    } else {
                        console.log("waktunya ganti marker posisi originnya menjadi dari posisi user")
                        direksi_2(data[0]["lokasiUpdate"])
                    }

                    if (data[0]["lokasiUpdate"] == document.getElementById("start").value) {
                        statusGantiFungsiDireksi = true
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Driver Sudah Di Depan Lokasi Anda',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            timer: 2500
                        })
                    }

                    if (data[0]["lokasiUpdate"] == document.getElementById("end").value) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Anda Sudah Sampai Tujuan',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            timer: 2500
                        })
                    }

                    // if data origin sudah sama dengan destination maka live update selanjutnya origin nya diganti destinationnya 
                    // alert pengemudi sudah dekat 





                } else {
                    alert("Error!");
                }
            }
            xmlHttp.open("POST", "request/update_live_update_ajax.php");
            xmlHttp.send(dataCounter);

        }

        function direksi_1(data) {
            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer();

            // set option suppresMarker true biar tidak kecetak marker yang default

            var options = {
                suppressMarkers: true,
            }

            directionsRenderer.setOptions(options)
            directionsRenderer.setMap(map1);

            // console.log("test xx", data)
            directionsService
                .route({
                    origin: {
                        query: data,
                    },
                    destination: {
                        query: document.getElementById("start").value,
                    },
                    travelMode: google.maps.TravelMode.DRIVING,
                })
                .then((response) => {
                    directionsRenderer.setDirections(response);

                    markerDriver(response.routes[0].legs[0].start_location.lat(), response.routes[0].legs[0].start_location.lng())
                    markerUser(response.routes[0].legs[0].end_location.lat(), response.routes[0].legs[0].end_location.lng(), response.routes[0].legs[0].end_address)

                })
                .catch((e) => {});
        }

        function direksi_2(data) {
            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer();

            // set option suppresMarker true biar tidak kecetak marker yang default

            var options = {
                suppressMarkers: true,
            }

            directionsRenderer.setOptions(options)
            directionsRenderer.setMap(map1);

            // console.log("test xx", data)
            directionsService
                .route({
                    origin: {
                        query: data,
                    },
                    destination: {
                        query: document.getElementById("end").value,
                    },
                    travelMode: google.maps.TravelMode.DRIVING,
                })
                .then((response) => {
                    directionsRenderer.setDirections(response);

                    console.log("ini adalah response check", response)
                    markerDriver(response.routes[0].legs[0].start_location.lat(), response.routes[0].legs[0].start_location.lng())
                    markerTujuanUser(response.routes[0].legs[0].end_location.lat(), response.routes[0].legs[0].end_location.lng(), response.routes[0].legs[0].end_address)

                })
                .catch((e) => {});
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


        function markerDriver(lat, lng) {
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
                title: "Posisi Driver",
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
                title: street,
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

            // view driver sekitar secara live 
            setTimeout(function() {
                viewDriverSekitar();
            }, 5000);

            // cek user sudah dijemput atau belum
            setTimeout(function() {
                cekStatusUser();
                getDataUpdatePosisiDriver();
            }, 7000);


            setInterval(function() {
                insertDataPermutasi(index);
                index += 1
            }, 10000)

        }

        // cancel search driver
        function cancelSearchDriver() {

            if (confirm("Pencarian Driver Akan Di Batalkan")) {

                $("#searchButton").css("display", "inline-block");
                $("#cancelButton").css("display", "none");
                $("#detailData").css("display", "none");

                // reset isi form tujuan
                document.getElementById("end").value = ""

                // form bar di activkan
                $('#end').removeAttr('readonly', 'readonly');


                // delete posisi user biar gak numpuk
                deletePosisiUserSaatIni()

                // stop interval update map
                // clearInterval(interval);

                // remove marker
                for (i = 0; i < gmarkers.length; i++) {
                    gmarkers[i].setMap(null);
                }

                // get posisi
                if (navigator.geolocation) {
                    // run fungsi showPosition()
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    alert("Geolocation is not supported by this browser.");
                }

            } else {
                console.log("lanjut")
            }
        }

        // delete posisi user di search live database
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

        // saat windows reload delete search live user tersebut
        if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
            deletePosisiUserSaatIni();
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