window.addEventListener("load", function(){
  function all_map() {
  　//phpでjson化したものを再度配列に
    let markerData = JSON.parse(@json($microposts));
    console.log(markerData);
    let lat= 0;
    let lng= 0;
    console.log(lat,lng);
    let maxlat = lat;//最大緯度
    let maxlng = lng;//最大経度
    let minlat = lat;//最小緯度
    let minlng = lng;//最小経度
    //東京駅を中心にした
    let location = {lat:35.681167, lng: 139.767052}; 
    let options = { zoom: 14, center: ocation, disableDoubleClickZoom: true }; 
    let map = new google.maps.Map(document.getElementById('all_map'), options);
    let markers=[];
    
    for ( let i = 0 ; i < markerData.length ; i++ ) {
      lat =  parseFloat(markerData[i]['map_lat']);      
      lng =  parseFloat(markerData[i]['map_lng']);
      // console.log("lat",lat,"lng",lng);
      // let image_path = markerData[i]['image_path'];
      // let search_tag = markerData[i]['search_tag'];
      let id = markerData[i]['id'];
      
      if(maxlat<lat){maxlat=lat}else{maxlat=maxlat}
      if(maxlng<lng){maxlng=lng}else{maxlng=maxlng}
      if(minlat>lat){minlat=lat}else{minlat=minlat}
      if(minlng>lng){minlng=lng}else{minlng=minlng}
      // let image = new google.maps.MarkerImage(image_path, new google.maps.Size(100,100), new google.maps.Point(0,0));
       
      markers[i]=new google.maps.Marker({ position: {lat:lat,lng:lng},map: map,  url: "{{ config('app.base_url') }}"+"microposts/"+id, label:""+id});
      // console.log( markers[i]);
      google.maps.event.addListener(markers[i], 'click', function() {
      window.location.href = this.url;
      });
    }    
    
    //北西端の座標を設定
    let sw = new google.maps.LatLng(maxlat,minlng);
    //東南端の座標を設定
    let ne = new google.maps.LatLng(minlat,maxlng);
    //範囲を設定
    let bounds = new google.maps.LatLngBounds(sw, ne);
    //自動調整
    map.fitBounds(bounds,5);
    
  }
});