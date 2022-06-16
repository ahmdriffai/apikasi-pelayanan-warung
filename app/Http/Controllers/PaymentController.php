<?php

namespace App\Http\Controllers;

use App\Exceptions\InvariantException;
use App\Exports\PaymentsExport;
use App\Http\Requests\PaymentAddRequest;
use App\Models\Order;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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


    public function index(Request $request) {
        $title = 'Data Pembayaran';
        $paginate = 10;
        $data = Payment::orderBy('created_at', 'DESC')->paginate($paginate);
        return view('payments.index', compact('data', 'title'))
            ->with('i', ($request->input('page', 1) - 1) * $paginate);
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

    public function exsport() {
        return Excel::download(new PaymentsExport(), 'users.xlsx');
    }
}
