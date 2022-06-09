<?php

namespace App\Services;

use App\Http\Requests\PaymentAddRequest;
use App\Models\Payment;

interface PaymentService
{
    function addPayment(PaymentAddRequest $request): int;
}
