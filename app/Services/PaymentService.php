<?php

namespace App\Services;

use App\Http\Requests\PaymentAddRequest;
use App\Models\Payment;

interface PaymentService
{
    function addPayment(PaymentAddRequest $request): Payment;
    function addStokeUrl(int $paymentId, string $cash): Payment;
    function getRefund(int $amuntPaid, int $cash);
}
