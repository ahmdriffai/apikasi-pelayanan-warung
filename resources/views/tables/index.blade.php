@extends('layouts.template')

@section('content')
    <div class="row">
        <div class="col-md-6">
            @include('tables.list')
        </div>
        <div class="col-md-6">
            @include('tables.create')
        </div>
    </div>
@endsection
