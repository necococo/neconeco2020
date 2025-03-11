@extends('layouts.app')

@section('content')
<!--マップ表示-->
<div id="all_map"></div>
<!--使い方説明-->
<div class="text-center color-gray">マップのピンをクリックすると、そこで撮られた写真のページに飛ぶニャン</div>

<script>
  function all_map() {
  　<!--//phpでjson化したものを再度配列に-->
    let markerData = JSON.parse(@json($microposts));
    <!--console.log(markerData);-->
    let ja_maxlat = 45.5;
    let ja_maxlng = 154;
    let ja_minlat = 20;
    let ja_minlng = 122;
    
    <!--//最大緯度-->
    let maxlat = ja_maxlat;
    <!--//最大経度-->
    let maxlng = ja_maxlng;
    <!--//最小緯度-->
    let minlat = ja_minlat;
    <!--//最小経度-->
    let minlng = ja_minlng;
    
    
    <!--//東京駅を中心にしたけど-->
    let center_location = {lat:35.681167, lng: 139.767052}; 
    let options = { zoom: 10, center: center_location, disableDoubleClickZoom: true }; 
    let map = new google.maps.Map(document.getElementById('all_map'), options);
    let markers=[];
    
    for ( let i = 0 ; i < markerData.length ; i++ ) {
      let lat =  parseFloat(markerData[i]['map_lat']);      
      let lng =  parseFloat(markerData[i]['map_lng']);
      let id = markerData[i]['id'];
      
      if(maxlat<lat){maxlat=lat}else{maxlat=maxlat}
      if(maxlng<lng){maxlng=lng}else{maxlng=maxlng}
      if(minlat>lat){minlat=lat}else{minlat=minlat}
      if(minlng>lng){minlng=lng}else{minlng=minlng}

      markers[i]=new google.maps.Marker({ position: {lat:lat, lng:lng}, map:map,  url:"{{ config('services.url') }}"+"microposts/"+id, label:""+id});
      google.maps.event.addListener(markers[i], 'click', function() {
      window.location.href = this.url;
      });
    }    
    
    <!--//北西端の座標を設定-->
    let sw = new google.maps.LatLng(maxlat, minlng);
    <!--//東南端の座標を設定-->
    let ne = new google.maps.LatLng(minlat, maxlng);
    <!--//範囲を設定-->
    let bounds = new google.maps.LatLngBounds(sw, ne);
    <!--//マップサイズ自動調整-->
    map.fitBounds(bounds, 5);
    
  }

</script>

<script  src="https://maps.googleapis.com/maps/api/js?key={{config('services.gmap-api')}}&callback=all_map" defer></script>




@endsection