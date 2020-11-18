// リターンキーを押しても送信されないように13番(エンターキー)を無効化
// window.onload=function() { 
function load_map() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });


//地図の表示と中心位置の緯度・経度取得

  var location = {lat:35.681167, lng: 139.767052}; 
  var options = { zoom: 14, center: location, disableDoubleClickZoom: true }; 
  var map = new google.maps.Map(document.getElementById('map'), options);
  var marker=new google.maps.Marker({position: location,map: map,});
  
   // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });

    
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
      var places = searchBox.getPlaces();

      if (places.length == 0) {
        return;
      }

      // Clear out the old markers.
      

      // For each place, get the icon, name and location.
      var bounds = new google.maps.LatLngBounds();
      places.forEach(function(place) {
        if (!place.geometry) {
          console.log("Returned place contains no geometry");
          return;
        }
        var icon = {
          url: place.icon,
          size: new google.maps.Size(71, 71),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(17, 34),
          scaledSize: new google.maps.Size(25, 25)
        };

        

        if (place.geometry.viewport) {
          // Only geocodes have viewport.
          bounds.union(place.geometry.viewport);
        } else {
          bounds.extend(place.geometry.location);
        }
      });
      map.fitBounds(bounds);
    });



  google.maps.event.addListener(map, 'center_changed', function(){
    location = map.getCenter();
    marker.setPosition(location);
    console.log(location.lat,location.lng);
  });
  
  $('form').submit(function(){
    $('[name="lat"]').val(location.lat);
    $('[name="lng"]').val(location.lng);
  });
    
  
}

