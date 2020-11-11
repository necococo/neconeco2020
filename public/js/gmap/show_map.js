function show_map() {
  // var $json_micropost;
  let lat = JSON.parse(@json($json_micropost))['map_lat'];
  let lng = JSON.parse(@json($json_micropost))['map_lng'];
  // let lat = 35;
  // let lng = 140;
  console.log(lat, lng);
  let location = {lat:lat, lng: lng}; 
  let options = { zoom: 10, center: location, disableDoubleClickZoom: true }; 
  let map = new google.maps.Map(document.getElementById('show_map'), options);
  let marker=new google.maps.Marker({position: location,map: map,});
}
