<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <title>NecoNeco</title>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/main.css') }}" media="all">
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
        <!--<script src="https://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
    </head>
    
    <body>
    
        <!--console networkにエラーがある場合は表示-->
        <?php ini_set('display_errors',1); ?>
        
        @include('commons.navbar')
        
         <div class="wrapper">
            <div class="container-fluid">
            @include('commons.error_messages')
            @yield('content')
         </div class="wrapper-end">
       
        
        <footer>
            <div class="">
             © 2020 Copyright KM
            </div>
        </footer>
            
        <!--右クリック禁止-->
        <script>document.oncontextmenu = function () {return false;}</script>
        
        <!--javascript offの時の表示-->
        <noscript><p>このサイトではJavaScriptを使用しています</p></noscript>
            
    </body>
    
</html>