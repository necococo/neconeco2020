<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <title>NecoNeco</title>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/main.css') }}" media="all">
        <link rel="icon" type="image/png" href="https://hige-oji-s3-bucket.s3.amazonaws.com/neconeco2020/favicon/apple-touch-icon.png"">
        <link rel="apple-touch-icon" href="https://hige-oji-s3-bucket.s3.amazonaws.com/neconeco2020/favicon/apple-touch-icon.png" sizes="180x180">
        <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>-->
        
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>-->
        <!--<script src="https://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        
    </head>
    
    <body>
    
        <!--console networkにエラーがある場合は表示-->
        <!--<?php ini_set('display_errors',1); ?>-->
        
        @include('commons.navbar')
        
        
            
        <div class="container">
            @include('commons.error_messages')
            @yield('content')
        
        </div>
       
        <!--歩く猫-->
        <div class="loop_wrap_reverse">
            <p><img class="cat_walk" style="position: relative;cursor: pointer;" src="https://hige-oji-s3-bucket.s3.amazonaws.com/neconeco2020/favicon/cat_walk2_small_reverse.gif"></p>
        </div>
        
        <footer>
            <div class="">
             © 2020 Copyright KM
            </div>
        </footer>
            
        <!--右クリック禁止-->

        <!--<script>document.oncontextmenu = function () {return false;}</script>-->

        
        <!--javascript offの時の表示-->
        <noscript><p>このサイトではJavaScriptを使用しています</p></noscript>
        

        <!--ドロップダウンを押した時に他のボタンのアクティブクラスを取り除く-->
        <script src="{{ secure_asset("js/navbar_action.js") }}" ></script>
        
        <!--JSで猫を歩かせるコード　重そうなのでCSSにした-->
        <!--<script>-->
        <!--    let cat_walks = document.getElementsByClassName("cat_walk");-->
            
        <!--    for(let i = 0; i < cat_walks.length; i++){-->
        <!--       cat_walks[i].addEventListener("click",() => {-->
        <!--            let start = Date.now();-->
        <!--            let timer = setInterval(function() {-->
        <!--            let timePassed = Date.now() - start;-->
        <!--            cat_walks[i].style.left = timePassed / 5 + 'px';-->
        <!--            if (timePassed > 5000) clearInterval(timer);}, 20);-->
        <!--        })-->
        <!--     };-->
              
        <!--</script>-->

        <script src="{{ secure_asset("js/navbar_action.js") }}" ></script>     

    </body>
    
</html>