@extends('layouts.template')


@section('content')
    <a href="{{ route('users.index') }}" class="btn btn-primary mb-3">
        <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Kembali
    </a>
    <!-- Basic Layout -->
    {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
    <div class="row">
        <div class="col-xl-10">
            <div class="card mb-4">
                <div class="card-body">
                    @include('components.detail-order')
                    <div class="mb-3 mt-5">
                        <label class="form-label" for="basic-default-email">Uang Tunai <span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">Rp.</span>
                            {!! Form::text('email', null, array('placeholder' => '50000','class' => 'form-control')) !!}
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Bayar</button>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@endsection


