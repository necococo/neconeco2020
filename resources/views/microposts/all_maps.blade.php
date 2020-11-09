@extends('layouts.app')

@section('content')

<div class="allmap"  id="map"></div>
      
<script async src="https://maps.googleapis.com/maps/api/js?key={{ getenv('GOOGLE_MAPS_KEY') }}ー&callback=initMap"></script>
<script>
window.onload=function(){
  var markerData = JSON.parse(@json($data));//phpでjson化したものを再度配列に
  // console.log(markerData);
  var lat= 0;
  var lng= 0;
  // console.log("lat",lat,"lng",lng);
  var maxlat = lat;//最大緯度
  var maxlng = lng;//最大経度
  var minlat = lat;//最小緯度
  var minlng = lng;//最小経度
  var location = {lat:35.681167, lng: 139.767052}; 
  var options = { zoom: 14, center: location, disableDoubleClickZoom: true }; 
  var map = new google.maps.Map(document.getElementById('map'), options);
  var markers=[];
  
  for ( var i = 0 ; i < markerData.length ; i++ ) {
    lat =  parseFloat(markerData[i]['map_lat']);      
    lng =  parseFloat(markerData[i]['map_long']);
    // console.log("lat",lat,"lng",lng);
    // var image_path = markerData[i]['image_path'];
    // var search_tag = markerData[i]['search_tag'];
    var id = markerData[i]['id'];
    
    if(maxlat<lat){maxlat=lat}else{maxlat=maxlat}
    if(maxlng<lng){maxlng=lng}else{maxlng=maxlng}
    if(minlat>lat){minlat=lat}else{minlat=minlat}
    if(minlng>lng){minlng=lng}else{minlng=minlng}
    // var image = new google.maps.MarkerImage(image_path, new google.maps.Size(100,100), new google.maps.Point(0,0));
     
    markers[i]=new google.maps.Marker({ position: {lat:lat,lng:lng},map: map,  url: "{{ getenv('base_url') }}"+id, label:""+id});
    // console.log( markers[i]);
    google.maps.event.addListener(markers[i], 'click', function() {
    window.location.href = this.url;
    });
  }    
  
  //北西端の座標を設定
  var sw = new google.maps.LatLng(maxlat,minlng);
  //東南端の座標を設定
  var ne = new google.maps.LatLng(minlat,maxlng);
  //範囲を設定
  var bounds = new google.maps.LatLngBounds(sw, ne);
  //自動調整
  map.fitBounds(bounds,5);
}
</script>

@endsection