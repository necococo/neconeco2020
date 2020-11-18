@extends('layouts.app')

@section('content')
<!--後々のために分離させてあるuser.blade.phpをincludeしている-->
    @include('users.users', ['users' => $users])
@endsection
