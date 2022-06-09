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
                    <img src="{{ $menu->image_url }}" class="img-fluid rounded-1 me-2" width="80px" height="80px">
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
            <strong> {{ $menu->pivot->where('order_id', $order->id)->sum('quantity') }} item</strong>
        </li>
        <li class="d-flex justify-content-between align-items-center px-3 mt-3">
            <strong> Jumlah Bayar </strong>
            <strong> Rp. {{ number_format($jumlahBayar) }}</strong>
        </li>
    </ul>
</div>
