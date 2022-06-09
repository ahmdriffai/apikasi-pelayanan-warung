@if($notPaid->count() == 0)
    <div class="alert alert-primary"> Belum ada pesanan </div>
@endif
@foreach($notPaid as $order)
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
                        <span class="tf-icons bx bx-card text-warning"></span>
                        <h6 class="text-warning text-capitalize ms-2">Belum Dibayar</h6>
                    </div>
                </div>
                <div class="card-body border-bottom">
                    @include('components.detail-order')
                </div>
                <div class="card-footer">
                    @role('cashier')
                    <a href="{{ route('payments.create', $order->id) }}" class="btn btn-primary mb-3">
                        <span class="tf-icons bx bx-credit-card"></span> Bayar
                    </a>
                    @endrole
                </div>
            </div>
        </div>
    </div>
@endforeach
