<?php

namespace App\Services;

use App\Http\Requests\OrderAddRequest;
use App\Models\Order;

interface OrderService
{
    function addOrder(OrderAddRequest $request): Order;
    function done(int $id) : Order;
    function process(int $id) : Order;
    function paid(int $id): Order;
    function cancel(int $id): Order;
}
