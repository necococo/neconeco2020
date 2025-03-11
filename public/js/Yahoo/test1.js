<!DOCTYPE html>
<html>
<body style="margin:0;padding:0;">
<div id="map" style="width:100%; height:100%"></div>

<script type="text/javascript" charset="utf-8" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" charset="utf-8" src="https://map.yahooapis.jp/js/V1/jsapi?appid=(getenv('YAHOO_API_KEY"))></script>

<script type="text/javascript">
window.onload = function(){
    var ymap = new Y.Map("map");
    ymap.addControl(new Y.CenterMarkControl());
    ymap.drawMap(new Y.LatLng(35.66572, 139.73100), 17, Y.LayerSetId.NORMAL);

    $(window).bind("resize", function(e){
        ymap.updateSize();
    });
}
</script>
</body>
</html>