<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ride</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <!-- CSS -->
  <link rel="stylesheet" href="style.css">
  <!-- Link Icon -->
  <link rel="icon" type="image/x-icon" href="assets/iconRideSharing.png">
</head>

<body>

  <nav class="navbar navbar-expand bg-light">
    <div class="container-fluid">
      <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
        <div>
          <ul class="navbar-nav">
            <li class="nav-item mx-3">
              <a class="nav-link text-center" href="ride.html"><i class="fa-solid fa-car-side"></i></a>
              <p class="fs-6">Ride</p>

            </li>
            <li class="nav-item mx-3">
              <a class="nav-link text-center" href="profile.html"><i class="fa-regular fa-id-card"></i></a>
              <p class="fs-6">Profile</p>

            </li>
            <li class="nav-item mx-3">
              <a class="nav-link text-center" href="money.html"><i class="fa-solid fa-wallet"></i></a>
              <p class="fs-6">Money</p>

            </li>
            <li class="nav-item mx-3">
              <a class="nav-link text-center" href="history.html"><i class="fa-solid fa-receipt"></i></a>
              <p class="fs-6">History</p>


            </li>

          </ul>
        </div>

      </div>
    </div>
  </nav>



  <div id="map"></div>

  <div class="container text-center mt-3">
    <div class="row">
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-map-pin"></i></span>
        <input type="text" class="form-control" placeholder="Lokasi anda" aria-label="Username" aria-describedby="basic-addon1">
      </div>
    </div>
    <div class="row">
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-location-dot"></i></span>
        <input type="text" class="form-control" placeholder="Lokasi Tujuan" aria-label="Username" aria-describedby="basic-addon1">
      </div>
    </div>
    <div class="row">
      <div class="col">
        <button type="button" class="btn btn-success" onclick="">Konfirmasi Penjemputan</button>
      </div>
    </div>
  </div>





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
  </script>

  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtqtqs7izeIE4pjxFrtUi-4ymAMStRilY&map_ids=93eb27799b5c0810&callback=initMap"></script> -->

  <!-- api key AIzaSyDtqtqs7izeIE4pjxFrtUi-4ymAMStRilY -->
  <!-- map id 93eb27799b5c0810  -->

  <!-- Link CDN Fontawesome -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js" integrity="sha512-naukR7I+Nk6gp7p5TMA4ycgfxaZBJ7MO5iC3Fp6ySQyKFHOGfpkSZkYVWV5R7u7cfAicxanwYQ5D1e17EfJcMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- Link CDN Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>


</body>

</html>