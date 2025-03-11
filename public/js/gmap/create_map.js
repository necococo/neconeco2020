// function handlePermission() {
// // window.onload = function() {
//   window.navigator.permissions.query({name:'geolocation'}).then(function(result) {
//     if (result.state == 'granted') {
//       var res = window.confirm("位置情報の取得を許可しますか？");
//       // console.log(res);
//       return res;
      
//       // geoBtn.style.display = 'inline';
//     } else if (result.state == 'prompt') {
//       var res = true;
//       // console.log(res);
//       return res;
      
//       // geolocationのコンファームが自動で出るはずなのでtrueを返して自動コンファームの判定にゆだねる
//       // geoBtn.style.display = 'none';
//       // navigator.geolocation.getCurrentPosition(revealPosition,positionDenied,geoSettings);
//     } else if (result.state == 'denied') {
//       var res = window.confirm("位置情報の取得を許可しますか？");
//       // console.log(res);
//       return res;
      
//       // geoBtn.style.display = 'inline';
//     }
//     // result.onchange = function() {
//     //   report(result.state);
//     // }
//   });
// }

// function report(state) {
//   console.log('Permission ' + state);
// }





function initMap() { 
  // window.navigatorオブジェクトの取得  
    // var remind = handlePermission();
    // console.log(remind);
    if (window.navigator.geolocation) {  
            // 位置情報の取得  
            const pos_options={                         
                enableHighAccuracy: true,   // 高精度を要求する?->true 
                timeout: 10000,             // 最大待ち時間（ミリ秒）  
                maximumAge: 0               // キャッシュ有効期間（ミリ秒）  
            }; 
            
            window.navigator.geolocation.getCurrentPosition(  
                successCallback,            // 取得完了時のコールバック  
                failureCallback,            // 取得失敗時のコールバック  
                pos_options                 // オプションパラメータ  
            );  
    }else {  
      window.alert("本ブラウザではGeolocationが使えません");
    }
      
} 
// 取得成功時の処理  
function successCallback(position) {  
    let lat = position.coords.latitude;  
    let lng = position.coords.longitude;  
    let accuracy = position.coords.accuracy
    //htmlに取得した値をとりあえず表示
    document.getElementById("location").innerHTML = `緯度:${lat}、経度:${lng}`;
    document.getElementById("accuracy").innerHTML = accuracy;
    // //getしたlat lng 値をform hidden の　value にセット
    document.getElementById("lat").value = lat;
    document.getElementById("lng").value = lng;
    // $('#location').text(`緯度:${lat}、経度:${lng}`);
    // $('#accuracy').text(accuracy);
    
    // $('#lat').val(lat);
    // $('#lng').val(lng);  
    
    let map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: lat, lng: lng },
      zoom: 10,
    });
    let marker=new google.maps.Marker({position: {lat:lat, lng: lng}, map: map,});
}

// 取得失敗時の処理  
function failureCallback(error) {  
    var err_msg = "";
    switch(error.code)
    {
      case 1:
        err_msg = "位置情報の利用が許可されていません";
        break;
      case 2:
        err_msg = "デバイスの位置が判定できません";
        break;
      case 3:
        err_msg = "タイムアウトしました";
        break;
    }
      window.alert(err_msg);
      //デバッグ用→　document.getElementById("show_result").innerHTML = error.message;
}  


