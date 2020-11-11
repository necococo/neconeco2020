@extends('layouts.app')

@section('content')

@if (\Session::has('success'))
    <div class="alert alert-success">{!! \Session::get('success') !!}</div>
@endif

<?php $json_micropost ?>

<div style="padding-left:0px;" class="col-xs-12 col-md-12">
<div class="container">
    <!--猫写真-->
    <img id="show_cat" class="cat_image" src="{{ secure_asset($micropost->image_path)}}">
    
    <!--投稿データ-->
    <div class="show_data">
        <p class="post-data">User name : {!! link_to_route('users.show', $micropost->user->name , ['id' => $micropost->user_id]) !!}</p>
        <p class="post-data">写真ID: {{$micropost->id}}</p>
        <p class="post-data" style="margin-bottom: 20px;">検索タグ: 
            @if (Auth::id() === $micropost->user_id)
                {!! link_to_route('microposts.edit', $micropost->search_tag, ['id' => $micropost->id, 'class' => 'btn btn-warning']) !!}
            @endif
        </p>
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
    
    
    
    

    <!--map-->
    <div id="show_map" style="width: 100%; height: 370px; margin-bottom: 30px;"></div>
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
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function show_map() {
  let lat = JSON.parse(@json($json_micropost))['map_lat'];
  let lng = JSON.parse(@json($json_micropost))['map_lng'];
  let location = {lat:lat, lng: lng}; 
  let options = { zoom: 10, center: location, disableDoubleClickZoom: true }; 
  let map = new google.maps.Map(document.getElementById('show_map'), options);
  let marker=new google.maps.Marker({position: location,map: map,});
}
</script> 

<script src="https://maps.googleapis.com/maps/api/js?key={{config('app.GOOGLE_MAPS_KEY')}}&callback=show_map" async defer></script>

@endsection