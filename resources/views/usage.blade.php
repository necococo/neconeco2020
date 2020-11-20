@extends('layouts.app')
@section('content')
<h1 style="text-align: center; margin-bottom:50px; color:#777;">NecoNeco</h1>



    
<h3 style="text-align: center; color:#777;">使い方</h3>
    
    
<div class="usage-texts">       
    <hr>
    <p>1.ユーザー名と仮のメールアドレス（現段階ではconfirmなし）とパスワードで登録できるニャン</p>
    
    <hr>
    <p>2.まずは投稿してみてくれニャン
    　ナビバーの「ユーザー名」を押して「My profile」を押して出てくる「New Post」、または直接ナビバーの「New Post」を押すニャン</p>
　  <p><img class="usage-img" src="https://hige-oji-s3-bucket.s3.amazonaws.com/neconeco2020/usage/usage-2.png"></p>
　  
    <hr>
    <p>4.位置情報の取得の可否のアラートが出るので選んで、猫の画像、検索タグを決めたらUploadボタンを押すニャン
    （位置情報を送信しない場合は、Phots Mapにピンが立たなくなるニャン）</p>
   
    
    <hr>
    <p>5.投稿したら、ナビバーのPhotos Mapで投画像の位置が地図上に表示されるニャン
    （マップのピンを押すと、そこで撮られ画像の詳細ページに飛ぶニャン）</p>
    <p><img class="usage-img" src="https://hige-oji-s3-bucket.s3.amazonaws.com/neconeco2020/usage/usage-5.png"></p>
   
    
    <hr>
    <p>6.画像がならんでいるところから一つ画像を押すと詳細ページに飛んでお気に入りやコメントができるニャン</p>
   
    
    <hr>
    <p>7.検索バー画像検索もできるニャン(半角,でつなげるとor検索になるニャン)</p>
     <hr>
    
    <div style="text-align: center; margin: 30px 0 95px 0">
    @if (!Auth::check())
        {!! link_to_route('signup.get', 'Sign up now!', null, ['class' => 'btn btn-lg btn-primary']) !!}
    @endif
    </div>
    
</div>
@endsection