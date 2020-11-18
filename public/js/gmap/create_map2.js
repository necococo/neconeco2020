let map, infoWindow;

function initMap() {
  
  
    if (navigator.geolocation) {
      let pos_options={                         
        enableHighAccuracy: false,   // 高精度を要求しない  
        timeout: 30000,             // 最大待ち時間（ミリ秒）  
        maximumAge: 0               // キャッシュ有効期間（ミリ秒）  
      };            
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
            accuracy:position.coords.accuracy
          };
          //
          $('#location').text(`緯度:${pos.lat}、経度:${pos.lng}`);
          $('#accuracy').text(pos.accuracy);
          //getしたlat lng 値をform hidden の　value にセット
          $('#lat').val(pos.lat);
          $('#lng').val(pos.lng);
          
          map = new google.maps.Map(document.getElementById("map"), {
          center: { lat: pos.lat, lng: pos.lng },
          zoom: 10,
        });
        infoWindow = new google.maps.InfoWindow();
        infoWindow.setPosition(pos);
        infoWindow.setContent("Location found.");
        infoWindow.open(map);
        map.setCenter(pos);
        },
        () => {
          handleLocationError(true, infoWindow, map.getCenter());
        }
      );
    } else {
      // Browser doesn't support Geolocation
      handleLocationError(false, infoWindow, map.getCenter());
    }
  
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(
    browserHasGeolocation
      ? "Error: The Geolocation service failed."
      : "Error: Your browser doesn't support geolocation."
  );
  infoWindow.open(map);
}