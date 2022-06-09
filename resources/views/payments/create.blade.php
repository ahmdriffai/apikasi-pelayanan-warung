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
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-email">Email <span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            {!! Form::text('email', null, array('placeholder' => 'Email Karyawan','class' => 'form-control')) !!}
                        </div>
                        <div class="form-text">Bisa pakai huruf, angka & titik</div>
                    </div>


                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@endsection


