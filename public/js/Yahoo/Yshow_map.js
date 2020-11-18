$(function(){
  var lati = <?php echo json_encode($micropost->map_lat); ?>;
  var long = <?php echo json_encode($micropost->map_long); ?>;
  var ymap = new Y.Map("map");
  ymap.drawMap(new Y.LatLng(lati, long), 17);
  ymap.addControl(new Y.SliderZoomControlVertical());
  var marker = new Y.Marker(new Y.LatLng(lati, long));
  ymap.addFeature(marker);
  console.log(lati, long);
} );
