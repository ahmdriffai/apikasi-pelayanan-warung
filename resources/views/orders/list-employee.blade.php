<div class="row">
    <div class="col-xl-12">
        <h6 class="text-muted">Filled Tabs</h6>
        <div class="nav-align-top mb-4">
            <ul class="nav nav-tabs nav-fill" role="tablist">
                @role('waiter|kitchen')
                <li class="nav-item">
                    <button
                        type="button"
                        class="nav-link active"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-justified-pending"
                        aria-controls="navs-justified-pending"
                        aria-selected="true"
                    >
                        <i class="tf-icons bx bx-clipboard"></i> Pesanan
                        @if($pending->count() > 0)
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">{{ $pending->count() }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item">
                    <button
                        type="button"
                        class="nav-link"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-justified-cooking"
                        aria-controls="navs-justified-cooking"
                        aria-selected="false"
                    >
                        <i class="tf-icons bx bxs-hourglass"></i> Sedang Dimasak
                        @if($cooking->count() > 0)
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">{{ $cooking->count() }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item">
                    <button
                        type="button"
                        class="nav-link"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-justified-done"
                        aria-controls="navs-justified-done"
                        aria-selected="false"
                    >
                        <i class="tf-icons bx bx-check-square"></i> Selesai
                        @if($done->count() > 0)
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">{{ $done->count() }}</span>
                        @endif
                    </button>
                </li>
                @endrole
                @role('waiter|cashier')
                <li class="nav-item">
                    <button
                        type="button"
                        class="nav-link @role('cashier') active @endrole"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-justified-not-paid"
                        aria-controls="navs-justified-not-paid"
                        aria-selected="false"
                    >
                        <i class="tf-icons bx bx-credit-card"></i> Belum Dibayar
                        @if($notPaid->count() > 0)
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">{{ $notPaid->count() }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item">
                    <button
                        type="button"
                        class="nav-link"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-justified-paid"
                        aria-controls="navs-justified-paid"
                        aria-controls="navs-justified-paid"
                        aria-selected="false"
                    >
                        <i class="tf-icons bx bxs-credit-card"></i> Terbayar
                    </button>
                </li>
                @endrole
            </ul>
            <div class="tab-content">
                @role('kitchen|waiter')
                <div class="tab-pane fade show active" id="navs-justified-pending" role="tabpanel">
                    @include('orders.pending')
                </div>
                <div class="tab-pane fade" id="navs-justified-cooking" role="tabpanel">
                    @include('orders.cooking')
                </div>
                <div class="tab-pane fade" id="navs-justified-done" role="tabpanel">
                    @include('orders.done')
                </div>
                @endrole
                <div class="tab-pane fade @role('cashier') show active @endrole" id="navs-justified-not-paid" role="tabpanel">
                    @include('orders.not-paid')
                </div>
                <div class="tab-pane fade" id="navs-justified-paid" role="tabpanel">
                    @include('orders.paid')
                </div>
            </div>
        </div>
    </div>
</div>
</div>
