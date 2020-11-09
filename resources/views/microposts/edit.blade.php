@extends('layouts.app')

@section('content')
    <div class="row show">
        <div class="col-xs-12 col-md-3 form-data">
            @if (\Session::has('updated'))
            <div class="alert alert-success">{!! \Session::get('updated') !!}</div>
            @endif
            <img class="cat_image" src="{{ secure_asset($micropost->image_path)}}">
            <br>
            @if (Auth::id() === $micropost->user_id)
                {!! Form::open(['route' => ['microposts.update', $micropost->id], 'method' => 'PUT']) !!}   
                    <div class="form-group">
                        {!! Form::label('search_tag', '検索用タグを更新') !!}
                        {!! Form::text('search_tag', null,['class' => 'form-control']) !!}    
                    </div>
                    <br>
                    <h5>中心位置を撮影場所として更新: 任意</h5>
                    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                    <div id="map" style="width: 370px; height: 370px;"></div>
                    <br>
                    {!! Form::submit('Update', ['class' => 'btn btn-warning', 'id' => 'button']) !!}
                    {!! Form::hidden('lat') !!}
                    {!! Form::hidden('long') !!}
                {!! Form::close() !!}
            @endif
    </div> 

<script>
window.onload=function() { 
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });

//地図の表示と中心位置の緯度・経度取得
  var lati = parseFloat(@json($micropost->map_lat));
  var long = parseFloat(@json($micropost->map_long));
  // console.log('lati',lati,'long',long);
  // var location = {lat:35.681167, lng: 139.767052}; 
  var location = {lat:lati, lng:long};
  console.log("edit-locatin",location);
  var options = { zoom: 10, center: location, disableDoubleClickZoom: true }; 
  var map = new google.maps.Map(document.getElementById('map'), options);
  var marker=new google.maps.Marker({position: location, map: map,});
  
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
 }
);



google.maps.event.addListener(map, 'center_changed', function(){
    location = map.getCenter();
    marker.setPosition(location);
    console.log(location.lat,location.lng);
  });
  
  $('form').submit(function(){
    $('[name="lat"]').val(location.lat);
    $('[name="long"]').val(location.lng);
  });
}
</script>
<script async src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_KEY')}}ー&callback=initMap"></script>
@endsection