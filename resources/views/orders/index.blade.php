@extends('layouts.template')

@section('content')
    @role('admin')
        @include('orders.list-admin')
    @endrole

    @role('waiter|cashier|kitchen')
        @include('orders.list-employee')
    @endrole
@endsection
