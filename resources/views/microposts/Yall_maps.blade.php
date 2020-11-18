@extends('layouts.app')

@section('content')

<div class="allmap"  id="map"></div>

@endsection

<script>
window.onload = function() {
//スクロール禁止用関数
function no_scroll(){
//PC用
var scroll_event = 'onwheel' in document ? 'wheel' : 'onmousewheel' in document ? 'mousewheel' : 'DOMMouseScroll';
$(document).on(scroll_event,function(e){e.preventDefault();});
//SP用
$(document).on('touchmove.noScroll', function(e) {e.preventDefault();});
}
};

window.addEventListener('load', function(){
    // document.addEventListener('touchstart', {capture: true});
    var markerData = JSON.parse(@json($data));//phpでjson化したものを再度配列に
    var lat= parseFloat(0);
    var lng= parseFloat(0);
    var maxlat = lat;//最大緯度
    var maxlng = lng;//最大経度
    var minlat = lat;//最小緯度
    var minlng = lng;//最小経度
    
    var ymap = new Y.Map("map");
     //自動調整
    
    ymap.addControl( new Y.SliderZoomControl() );
    ymap.addControl( new Y.LayerSetControl() );
    ymap.addControl(new Y.SearchControl());
    ymap.setConfigure('weatherOverlay', true);
    
    var markers=[];
    for ( var i = 0 ; i < markerData.length ; i++ ) {
        lat =  parseFloat(markerData[i]['map_lat']);      
        lng =  parseFloat(markerData[i]['map_long']);
        
        if(maxlat<lat){maxlat=lat}else{maxlat=maxlat}
        if(maxlng<lng){maxlng=lng}else{maxlng=maxlng}
        if(minlat>lat){minlat=lat}else{minlat=minlat}
        if(minlng>lng){minlng=lng}else{minlng=minlng}
        
        // image_path = markerData[i]['image_path'];
        // search_tag = markerData[i]['search_tag'];
        id = markerData[i]['id'];
        console.log(id,lat, lng);
        // markers.push(new Y.Marker(new Y.LatLng(lat,lng)));
        var marker = new Y.Marker(new Y.LatLng(lat,lng));
        ymap.addFeature(marker);
    }    
    
   
        // 
        
        // 取得した地物がすべて入る地理座標矩形領域を生成します。
//         var bounds = ymap.GetBounds();
//         for (var i=0; i<markers.length; i++) {
//             bounds.Extend(markers[i].GetLatLng());
//         }
//         // 地理座標矩形領域が収まる地図を描画します。
//         ymap.DrawBounds(bounds,"geocoderls");
// });

  
     //北西端の座標を設定
         var sw = new Y.LatLng(maxlat,minlng);
         //東南端の座標を設定-->
       var ne = new Y.LatLng(minlat,maxlng);
       //範囲を設定-->
       
        console.log( getSuitedBounds(sw ,ne));
    ymap.drawBounds(new Y.LatLngBounds(sw ,ne),Y.LayerSetId.NORMAL);
   
});

</script>