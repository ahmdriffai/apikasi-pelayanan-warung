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
                    @include('components.detail-order')
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
@endforeach
