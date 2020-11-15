@extends('layouts.app')

@section('content')
    <div class="row show">
        <div class="form-data">
            @if (\Session::has('updated'))
            <div class="alert alert-success">{!! \Session::get('updated') !!}</div>
            @endif
            <img class="cat_image" src="{{ secure_asset($micropost->image_path)}}">
            <br>
            @if (Auth::id() === $micropost->user_id)
                {!! Form::open(['route' => ['microposts.update', $micropost->id], 'method' => 'PUT']) !!}   
                    <div class="form-group" style="width: 50%; margin-top:20px;">
                        {!! Form::label('search_tag', '検索タグを更新') !!}
                        {!! Form::text('search_tag', null,['class' => 'form-control']) !!}    
                    </div>
                    {!! Form::submit('Update', ['class' => 'btn btn-warning']) !!}
                {!! Form::close() !!}
            @endif
    </div> 
@endsection