function success(pos){
     lat = pos.coords.latitude;
     lng = pos.coords.longitude;
     accuracy = pos.coords.accuracy;
    $('#location').text(`緯度:${lat}、経度:${lng}`);
    $('#accuracy').text(accuracy);
    //getしたlat lng 値をform hidden の　value にセット
    $('#lat').val(lat);
    $('#lng').val(lng);
}

function error(pos){
    alert('位置情報の取得に失敗しました。エラーコード：');
    $('#lat').val(null);
    $('#lng').val(null);
}

navigator.geolocation.getCurrentPosition(success, error);
    
    
    

