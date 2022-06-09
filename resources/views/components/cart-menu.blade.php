<div class="bs-toast toast show toast-placement-ex m-2 bg-white bottom-0 end-0" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000" style="width: 500px">
    <div class="toast-header">
        <i class='bx bx-cart me-2'></i>
        <div class="me-auto fw-semibold">Pesanan</div>
        {{--        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>--}}
    </div>
    <div class="toast-body">
        <div class="col-lg-12 mb-4 mb-xl-0">
            <ul class="list-group">
                @php
                    $jumlahBayar = 0;
                @endphp
                @foreach($menuCarts as $value)
                    @php
                        $jumlah = $value->quantity * $value->menu->price;
                        $jumlahBayar += $jumlah;
                    @endphp
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="{{ route('menu-carts.delete', $value->id) }}" class="btn btn-sm">
                                <i class="bx bx-trash"></i>
                            </a>
                            {{ $value->menu->name }}
                            <br>
                            x {{ $value->quantity }}
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


        <a href="{{ route('orders.create') }}" class="btn btn-info my-3">
            <span class="tf-icons bx bx-arrow-to-right"></span>&nbsp; Lanjutkan Pesanan
        </a>

    </div>
</div>
