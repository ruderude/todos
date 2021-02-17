@extends('layouts.app')

@section('content')

<User
    :name='@json($name)'
    :email='@json($email)'
></User>

@endsection
