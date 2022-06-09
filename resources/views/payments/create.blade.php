@extends('layouts.template')

@section('content')
    <a href="{{ route('orders.index') }}" class="btn btn-primary mb-3">
        <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Kembali
    </a>
    <!-- Basic Layout -->
    {!! Form::open(array('route' => 'payments.store','method'=>'POST')) !!}
    <div class="row">
        <div class="col-xl-10">
            <div class="card mb-4">
                <div class="card-body">
                    @include('components.detail-order')
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="mb-3 mt-5">
                        <label class="form-label" for="basic-default-email">Uang Tunai <span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">Rp.</span>
                            @if($order->status != 'paid')
                                {!! Form::text('cash', null, array('placeholder' => '50000','class' => ['form-control'])) !!}
                            @else
                                {!! Form::text('null', null, array('placeholder' => 'Pesanan sudah terbayar','class' => ['form-control'], 'readonly')) !!}
                            @endif

                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" @if($order->status == 'paid') disabled @endif>
                        Bayar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

    @if($refund = Session::get('refund'))
        <div class="row">
            <div class="col-xl-10">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="alert alert-primary">
                            Pesanan Pembayaran
                        </div>
                        <div class="col-lg-12 mb-4 mb-xl-0 mb-3">
                            <label class="form-label" for="basic-default-fullname">Detail Pesanan</label>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Uang Tunai
                                    <strong>Rp. {{ number_format(Session::get('cash')) }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Kembalian
                                    <h4>Rp. {{ number_format($refund) }}</h4>
                                </li>
                            </ul>
                        </div>

                        <a href="{{ route('orders.index') }}" class="btn btn-primary my-3">
                            <span class="tf-icons bx bx-printer"></span>&nbsp; Cetak Struk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection


