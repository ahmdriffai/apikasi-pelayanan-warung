@extends('layouts.template')

@section('content')
    <a href="{{ route('menus.index') }}" class="btn btn-primary mb-3">
        <span class="tf-icons bx bx-arrow-back"></span>Kembali
    </a>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl-10">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                </div>
                <div class="card-body">
                    {!! Form::open(array('route' => 'orders.store','method'=>'POST')) !!}

                    <div class="mb-3">
                        <label class="form-label" for="basic-default-email">Nama Pelanggan <span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            {!! Form::text('customer_name', null, array('placeholder' => 'Nama Pelanggan','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Meja  <span class="text-danger">*</span></label>
                        <select name="table_id" class="form-control">
                            <option value="">Pilih Meja</option>
                            @foreach($tables as $table)
                            <option value="{{ $table->id }}">{{ $table->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="basic-default-email">Catatan</label>
                        <div class="input-group input-group-merge">
                            {!! Form::textarea('note', null, [
                                'class' => 'form-control',
                                'rows' => 3
                            ]) !!}
                        </div>
                        <div class="form-text"> *Kosongkan jika tidak ada catatan </div>
                    </div>

                    @include('components.detail-order')

                    <button type="submit" class="btn btn-primary mt-3">Pesan</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>



@endsection
