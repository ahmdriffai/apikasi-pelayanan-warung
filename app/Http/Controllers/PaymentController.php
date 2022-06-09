<?php

namespace App\Http\Controllers;

use App\Exceptions\InvariantException;
use App\Http\Requests\PaymentAddRequest;
use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private PaymentService $paymentService;

    /**
     * @param PaymentService $paymentService
     */
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }


    public function index() {
        return 'index';
    }

    public function create(int $orderId) {
        $title = 'Pembayaran Pesanan';
        $order = Order::find($orderId);
        return view('payments.create', compact('orderId', 'title', 'order'));
    }

    public function store(PaymentAddRequest $request) {
        try {
            $cash = $request->input('cash');
            $payment = $this->paymentService->addPayment($request);
            $this->paymentService->addStokeUrl($payment->id, $cash);
            $refund = $this->paymentService->getRefund($payment->amount_paid, $cash);
            return redirect()->back()->with(['success', 'Berhasil membayar pesanan', 'refund' => $refund, 'cash' => $request->input('cash')]);
        }catch (InvariantException $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
