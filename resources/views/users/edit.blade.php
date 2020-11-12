@extends('layouts.app')

@section('content')
<div class="col-xs-12 col-md-3 form-data">
    @if (\Session::has('user_updated'))
        <div class="alert alert-success">{!! \Session::get('user_updated') !!}</div>
    @endif
    @if(Auth::id() == $user->id)
    {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'put']) !!}
        <div class="form-group ">
        {!! Form::text('name',null,['class' => 'form-control']) !!}
        {!! Form::submit('Rename', ['class' => 'btn btn-warning']) !!}
        {!! Form::close() !!}
        </div>
        <br>
        {!! Form::model($user, ['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
        {!! Form::submit('Delete accoount !', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
    @endif
    
</div>
@endsection