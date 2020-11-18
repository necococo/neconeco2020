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
            @include('user_follow.follow_button', ['user' => $user])
        </aside>
        <div class="col-xs-8 col-md-10">
            <ul class="nav nav-tabs nav-justified">
                @if (Auth::id() == $user->id)
                    <li role="presentation" class="{{ Request::is('microposts/create') ? 'active' : '' }}"><a style="text-align:left;" href="{{ route('microposts.create') }}">New Post <span class="badge"></span></a></li>
                @endif
                <li role="presentation" class="{{ Request::is('users/' . $user->id) ? 'active' : '' }}"><a style="text-align:left;" href="{{ route('users.show', ['id' => $user->id]) }}">Photos <span class="badge">{{ $count_microposts }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/followings') ? 'active' : '' }}"><a style="text-align:left;" href="{{ route('users.followings', ['id' => $user->id]) }}">Followings <span class="badge">{{ $count_followings }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/followers') ? 'active' : '' }}"><a style="text-align:left;" href="{{ route('users.followers', ['id' => $user->id]) }}">Followers <span class="badge">{{ $count_followers }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/favoritings') ? 'active' : '' }}"><a style="text-align:left;" href="{{ route('users.favoritings', ['id' => $user->id]) }}">Favo_Photos  <span class="badge">{{ $count_favoritings }}</span></a></li>
            </ul>
        </div>
    </div>
    <div class="row show">
          @include('users.users', ['users' => $users])
    </div>
@endsection