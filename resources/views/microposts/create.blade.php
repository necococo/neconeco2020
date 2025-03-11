@extends('layouts.app')

@section('content')

<div class="row">
    
    <aside class="col-xs-4 col-md-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $user->name }}</h3>
                @if(Auth::id() == $user->id)
                    <a href="{{ route('users.edit', ['id' => $user->id]) }}">Edit</a>
                @endif
            </div>
            <div class="panel-body">
                <img class="media-object img-rounded img-responsive" src="{{ Gravatar::src($user->email, 50) }}" alt="">
            </div>
        </div>
    </aside>
    
    <div class="col-xs-8 col-md-10">
        <ul class="nav nav-tabs nav-justified">
            @if (Auth::id() == $user->id)
                <li role="presentation" class="{{ Request::is('microposts/create') ? 'active' : '' }}"><a style="text-align:left;" href="{{ route('microposts.create') }}">New Post <span class="badge"></span></a></li>
            @endif
            <!--<li><a style="text-align:left;" href="{{ route('users.show', ['id' => $user->id]) }}">Photos <span class="badge">{{ $count_microposts }}</span></a></li>-->
            <li role="presentation" class="{{ Request::is('users/' . $user->id) ? 'active' : '' }}"><a style="text-align:left;" href="{{ route('users.show', ['id' => $user->id]) }}">Photos <span class="badge">{{ $count_microposts }}</span></a></li>
            <li role="presentation" class="{{ Request::is('users/*/followings') ? 'active' : '' }}"><a style="text-align:left;" href="{{ route('users.followings', ['id' => $user->id]) }}">Followings <span class="badge">{{ $count_followings }}</span></a></li>
            <li role="presentation" class="{{ Request::is('users/*/followers') ? 'active' : '' }}"><a style="text-align:left;" href="{{ route('users.followers', ['id' => $user->id]) }}">Followers <span class="badge">{{ $count_followers }}</span></a></li>
            <li role="presentation" class="{{ Request::is('users/*/favoritings') ? 'active' : '' }}"><a style="text-align:left;" href="{{ route('users.favoritings', ['id' => $user->id]) }}">Favo_Photos <span class="badge">{{ $count_favoritings }}</span></a></li>
        </ul>
    </div> 
</div>

@if (Auth::id() == $user->id)
    <div class="row">
        <div class="panel-heading">
            <hr>
            
            <h4 class="panel-title">Upload data</h4>
            <P>位置情報を許可すると場所も共有されます。許可しなくても使えます。</P>
            <hr>
            <div class="panel-body">
                
                
                <div class="form-data">
                    <br>
                    {!! Form::open(['route' => ['microposts.store'], 'method' => 'POST', 'files' => true]) !!}
                        {!! Form::label('file', '猫の画像を選択（5MB以下, AIによる猫判定あり）') !!}
                        {!! Form::file('file', null, ['class' => 'form-control']) !!}  
                        <br> 
                        <div class="form-group">
                            {!! Form::label('search_tag', '検索タグ(複数可)') !!}
                            {!! Form::text('search_tag', null, ['class' => 'form-control-sm']) !!}    
                        </div>
                        {!! Form::hidden('lat', null, ['id' => 'lat']) !!}   
                        {!! Form::hidden('lng', null, ['id' => 'lng']) !!} 
                        
                        <p><span class="bold">現在位置   　</span><span id="location"></span>（精度:半径 <span id="accuracy"></span> m）</p>
                        
                        <p id="error_message"></p>
                        <!--マップ-->
                        <div id="map"></div>
                        
                    {!! Form::submit('Upload', ['class' => 'btn btn-warning', 'id' => 'button']) !!}
                 <hr>
                </div>    
            </div>
        </div>   
    </div>
   
    <script src="{{ secure_asset('/js/gmap/create_map.js') }}"></script>
    <script src="{{ secure_asset('js/validate_file.js') }}"></script>
@endif
<script src="https://maps.googleapis.com/maps/api/js?key={{config('services.gmap-api')}}&callback=initMap"  defer></script>


@endsection