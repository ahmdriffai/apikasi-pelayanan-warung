<?php

namespace App\Services\Eloquent;

use App\Exceptions\InvariantException;
use App\Http\Requests\PaymentAddRequest;
use App\Models\Order;
use App\Models\Payment;
use App\Services\PaymentService;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

class PaymentServiceImpl implements PaymentService
{
    function addPayment(PaymentAddRequest $request): Payment
    {
        $order = Order::find($request->input('order_id'));
        $cash = $request->input('cash');

        $amountPaid = 0;

        foreach ($order->menus as $menu) {
            $jumlah = $menu->pivot->quantity * $menu->price;
            $amountPaid += $jumlah;
        }

        if ($amountPaid > $cash) {
            throw new InvariantException('Gagal membayar pesanan, uang tunai tidak mencukupi untuk membayar');
        }

        try {
            $payment = new Payment([
                'amount_paid' => $amountPaid,
                'date_paid' => now(),
            ]);

            $order->payment()->save($payment);

            $order->status = 'paid';
            $order->save();

        }catch (\Exception $exception) {
            throw new InvariantException($exception->getMessage());
        }

        return $payment;
    }


    function addStokeUrl(int $paymentId, string $cash): Payment
    {
        $payment = Payment::find($paymentId);

        $pdf = PDF::loadView('pdf.stroke', compact('payment'));

        $path = 'payment/stroke/';
        $nameFile = uniqid() . time(). '.pdf';

        Storage::disk('public')->put($path . $nameFile, $pdf->output());

        $payment->stroke_url = public_path('storage/' . $path . $nameFile);
        $payment->save();

        return $payment;
    }

    function getRefund(int $amuntPaid, int $cash)
    {
        return $cash - $amuntPaid;
    }
}
