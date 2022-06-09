@extends('layouts.template')

@section('content')

    @role('admin')
    @include('menus.list-admin')
    @endrole

    @role('waiter')
    @include('menus.list-waiter')
    @endrole
@endsection

