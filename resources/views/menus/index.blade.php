@extends('layouts.template')

@section('content')
    <div class="row mb-3">
        <div class="col-md-5">
            {!! Form::open(array('route' => 'menus.search','method'=>'GET')) !!}
            <div class="input-group input-group-merge">
                <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>

                {!! Form::text('key', null, array('placeholder' => 'Search...','class' => 'form-control')) !!}

                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    @role('admin')
    @include('menus.list-admin')
    @endrole

    @role('waiter')
    @include('menus.list-waiter')
    @endrole
@endsection

