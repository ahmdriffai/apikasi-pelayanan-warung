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
                            <option value="{{ $table->id }}">{{ $table->number }}</option>
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


                    <div class="col-lg-12 mb-4 mb-xl-0 mb-3">
                        <label class="form-label" for="basic-default-fullname">Detail Pesanan</label>
                        <ul class="list-group">
                            @php
                                $jumlahBayar = 0;
                            @endphp
                            @foreach($menuCarts as $value)
                                <input type="hidden" name="menu_id[]" value="{{ $value->menu->id }}">
                                <input type="hidden" name="quantity[]" value="{{ $value->quantity }}">
                                @php
                                    $jumlah = $value->quantity * $value->menu->price;
                                    $jumlahBayar += $jumlah;
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="{{ route('menu-carts.delete', $value->id) }}" class="btn btn-sm">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                        <img src="{{ $value->menu->image_url }}" class="img-fluid rounded-1 me-2" width="80px" height="80px">
                                        <div class="">
                                            {{ $value->menu->name }}
                                            <br>
                                            x {{ $value->quantity }}
                                        </div>
                                    </div>
                                    Rp. {{ number_format($value->menu->price) }}
                                </li>
                            @endforeach
                            <li class="d-flex justify-content-between align-items-center px-3 mt-3">
                                <strong> Total Pesanan </strong>
                                <strong> {{ $menuCarts->sum('quantity') }} item</strong>
                            </li>
                            <li class="d-flex justify-content-between align-items-center px-3 mt-3">
                                <strong> Jumlah Bayar </strong>
                                <strong> Rp. {{ number_format($jumlahBayar) }}</strong>
                            </li>
                        </ul>
                    </div>




                    <button type="submit" class="btn btn-primary mt-3">Pesan</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>



@endsection
