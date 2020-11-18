@extends('layouts.app')

@section('content')

<!--セッションアラート　アップロードされました-->
@if (\Session::has('success'))
    <div class="alert alert-success">{!! \Session::get('success') !!}</div>
@endif

<div id="show_cat_and_show_data">
    <!--猫写真-->
    <img id="show_cat" src="{{ secure_asset($micropost->image_path)}}">
    
    <!--投稿データとボタン-->
    <div id="show_data">
        
        <div id="data">
            <p class="post-data">User name : {!! link_to_route('users.show', $micropost->user->name , ['id' => $micropost->user_id]) !!}</p>
            <p class="post-data">写真ID: {{$micropost->id}}</p>
            <p class="post-data">検索タグ: {{$micropost->search_tag}}</p> 
                @if (Auth::id() === $micropost->user_id)
                    {!! link_to_route('microposts.edit', 'タグを編集', ['id' => $micropost->id, 'class' => 'btn btn-warning']) !!}
                @endif
            
        </div>
        
        <div id="button" style="margin-top: 30px;">
            <p>この写真を</p>
            <!--削除ボタン-->
            <div>
                @if (Auth::id() === $micropost->user_id)
                    
                    {!! Form::open(['route' => ['microposts.destroy', $micropost->id], 'method' => 'delete']) !!}
                    {!! Form::submit('Delete  ', ['class' => 'btn btn-danger ']) !!}
                    {!! Form::close() !!}
                @endif
            </div>
            
            <!--お気に入りボタン-->
            <div>
                @include('favorites.favorite_button', ['micropost' => $micropost])
            </div>
        </div>
       
    </div>
</div>
<!--map-->
<div id="show_map"></div>
<!--comment panel-->
<div class="row bootstrap snippets" >
    <div class="">
        <div class="comment-wrapper">
            <div class="panel panel-info">
                    <div class="panel-heading">
                        Comment panel
                    </div>
                
                    <div id="panel-body" class="panel-body">
                        {!! Form::open(['action' => ['CommentsController@store', $micropost->id]]) !!}
                        {!! Form::textarea('comment', old('comment'), ['class' => 'form-control', 'rows' => '3', 'placeholder'=>'write a comment...']) !!}
                        {!! Form::submit('New comment', ['class' =>"btn btn-info pull-right"]) !!}
                        {!! Form::close() !!}
                    </div>
                
                    <div class="clearfix"></div>
                    <hr>
                
                    <ul id="media-list" class="media-list">
                        @if($comments)
                            @foreach($comments as $comment)
                                <li class="media">
                                    <div class="media-body">
                                        <span class="text-muted pull-right">
                                            <small class="text-muted">{{ $comment->created_at }}</small>
                                        </span>
                                        <span class="text-success">{!! link_to_route('users.show', $comment->user->name, ['id' => $comment->user_id]) !!}</span>
                                        <p>
                                            {!! nl2br(e($comment->comment)) !!}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
<!--</div>-->


<!--<script>-->
<!--window.onload = function() {-->
<!--    fetch("./getapijs.php").then(res=>{-->
<!--    console.log(res.text());-->
<!--        // CGI 実行して、結果の TEXT だけを次にパスする-->
<!--        return res.text();-->
<!--    }).then(mytext => {-->
<!--        // 受け取った javascript を EVAL で実行する。-->
<!--        console.log(text);-->
<!--        eval(mytext);-->
<!--    }).then(() => {-->
<!--        // 実行後の処理。公式サンプル HTML が &callback= でコールしていた部分-->
<!--        show_map();-->
<!--    }).catch(() =>{-->
<!--        // お好きなエラー処理をどうぞ-->
<!--        alert("fetch error");-->
<!--    });-->
<!--};-->
<!--</script> -->

<script>
function show_map() {
  let lat = parseFloat(JSON.parse(@json($json_micropost))['map_lat']);
  let lng = parseFloat(JSON.parse(@json($json_micropost))['map_lng']);
  //console.log(lat, lng);
  let id = JSON.parse(@json($json_micropost))['id'];
  let location = {lat:lat, lng: lng}; 
  let options = { zoom: 10, center: location,  disableDoubleClickZoom: true }; 
  let map = new google.maps.Map(document.getElementById('show_map'), options);
  let marker=new google.maps.Marker({position: location, map: map, label: ""+id,});
}
</script> 


<script src="https://maps.googleapis.com/maps/api/js?key={{config('services.gmap-api')}}&callback=show_map" defer></script>

@endsection