@extends('layouts.template')
@section('content')
<a href="{{ route('payments.exsport') }}" class="btn btn-success mb-3">
    <span class="tf-icons bx bx-printer"></span>&nbsp; Eksport Data Pesann
</a>
<div class="card py-2 px-2">
    <div class="row">
        <div class="col-md-6">
            <h5 class="card-header">Data Pesanan</h5>
        </div>
    </div>
    <div class="text-nowrap table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Nama Pelanggan</th>
                <th>Pesanan</th>
                <th>Jumlah Pesanan</th>
                <th>Tanggal Pembayaran</th>
                <th>Total</th>
                <th>Struk</th>
            </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            <tr>
                @foreach($data as $payment)
                    <td>#</td>
                    <td>{{ $payment->order->customer_name }}</td>
                    <td>{{ $payment->order->menus->pluck('name') }}</td>
                    <td>
                        @php $jumlah = 0 @endphp
                        @foreach($payment->order->menus as $menu)
                            @php $jumlah += $menu->pivot->quantity @endphp
                            {{ $jumlah }}
                        @endforeach
                    </td>
                    <td>{{ $payment->date_paid }}</td>
                    <td>
                        @php $amount = 0 @endphp
                        @foreach($payment->order->menus as $menu)
                            @php $amount += $menu->pivot->quantity * $menu->price@endphp
                        @endforeach
                        Rp. {{ number_format($amount) }}
                    </td>
                    <td>
                        <a href="{{ $payment->stroke_url }}" class="btn btn-warning mb-3">
                            <span class="tf-icons bx bx-printer"></span>
                    </td>
                @endforeach
            </tr>
            </tbody>
        </table>
        {{--        {!! $data->links() !!}--}}
    </div>
</div>
@endsection
