@if($pending->count() == 0)
    <div class="alert alert-primary"> Belum ada pesanan </div>
@endif
@role('waiter')
<a href="{{ route('menus.index') }}" class="btn btn-primary mb-3">
    <span class="tf-icons bx bx-clipboard"></span> Pesan Lagi
</a>
@endrole
@foreach($pending as $order)
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
                        <span class="tf-icons bx bx-time text-warning"></span>
                        <h6 class="text-warning text-capitalize ms-2">{{ $order->status }}</h6>
                    </div>
                </div>
                <div class="card-body border-bottom">
                    @include('components.detail-order')
                </div>
                <div class="card-footer">
                    @role('waiter')
                    <a href="{{ route('orders.cancel', $order->id) }}" class="btn btn-danger mb-3">
                        <span class="tf-icons bx bx-x-circle"></span> Batalkan Pesanan
                    </a>
                    @endrole
                    @role('kitchen')
                    <a href="{{ route('orders.process', $order->id) }}" class="btn btn-primary mb-3">
                        <span class="tf-icons bx bx-cookie"></span> Proses
                    </a>
                    @endrole
                </div>
            </div>
        </div>
    </div>
@endforeach
{{$pending->links()}}
