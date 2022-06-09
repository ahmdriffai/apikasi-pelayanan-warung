@if($done->count() == 0)
    <div class="alert alert-primary"> Belum ada pesanan </div>
@endif
@foreach($done as $order)
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4 shadow">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-stretch justify-content-center">
                        <span class="tf-icons bx bx-user"></span>
                        <span class="ms-2">{{ $order->customer_name }}</span>
                        <h5 class="text-primary ms-3 fw-normal">(Meja {{ $order->table->number }})</h5>
                    </div>
                    <div class="d-flex align-items-stretch justify-content-center">
                        <span class="tf-icons bx bx-check-circle text-success"></span>
                        <h6 class="text-success text-capitalize ms-2">{{ $order->status }}</h6>
                    </div>
                </div>
                <div class="card-body border-bottom">
                    <div class="col-lg-12 mb-4 mb-xl-0 mb-3">
                        <label class="form-label" for="basic-default-fullname">Detail Pesanan</label>
                        <ul class="list-group">
                            @php
                                $jumlahBayar = 0;
                            @endphp
                            @foreach($order->menus as $menu)
                                @php
                                    $jumlah = $menu->pivot->quantity * $menu->price;
                                    $jumlahBayar += $jumlah;
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <img src="{{ $menu->imageUrl }}" class="img-fluid rounded-1 me-2" width="80px" height="80px">
                                        <div class="">
                                            {{ $menu->name }}
                                            <br>
                                            x {{ $menu->pivot->quantity }}
                                        </div>
                                    </div>
                                    Rp. {{ number_format($menu->price) }}
                                </li>
                            @endforeach
                            <li class="list-group-item d-flex flex-column justify-content-between align-items-stretch">
                                <strong>Catatan : </strong>
                                <p class="text-primary">
                                    {{ $order->note }}
                                </p>
                            </li>
                            <li class="d-flex justify-content-between align-items-center px-3 mt-3">
                                <strong> Total Pesanan </strong>
                                <strong> {{ $menu->pivot->count('quantity') }} item</strong>
                            </li>
                            <li class="d-flex justify-content-between align-items-center px-3 mt-3">
                                <strong> Jumlah Bayar </strong>
                                <strong> Rp. {{ number_format($jumlahBayar) }}</strong>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
@endforeach
