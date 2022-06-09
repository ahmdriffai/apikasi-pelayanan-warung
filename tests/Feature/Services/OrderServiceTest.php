<?php

namespace Tests\Feature\Services;

use App\Exceptions\InvariantException;
use App\Http\Requests\OrderAddRequest;
use App\Models\Menu;
use App\Models\MenuCart;
use App\Models\Order;
use App\Models\Table;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;
    private OrderService $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderService = $this->app->make(OrderService::class);
    }


    public function test_example()
    {
        self::assertTrue(true);
    }

    public function test_add_order_success()
    {
        $table = Table::factory()->create();
        $menuCart = MenuCart::factory(2)->create();

        $request = new OrderAddRequest([
            'customer_name' => 'fai',
            'table_id' => $table->id,
            'note' => 'catatan',
            'menu_id' => [$menuCart[0]->menu->id, $menuCart[1]->menu->id],
            'quantity' => [1, 3]
        ]);


        $this->orderService->addOrder($request);

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('menu_orders', 2);
        $this->assertDatabaseHas('menu_orders', [
            'menu_id' => $menuCart[0]->menu->id,
            'quantity' => 1
        ]);
        $this->assertDatabaseHas('menu_orders', [
            'menu_id' => $menuCart[1]->menu->id,
            'quantity' => 3
        ]);

        $this->assertDatabaseHas('orders', [
           'customer_name' => 'fai',
           'status' => 'pending',
            'note' => 'catatan',
        ]);

        $this->assertDatabaseCount('menu_carts', 0);

    }

    public function test_order_done()
    {
        $order = Order::factory()->create();

        $this->assertDatabaseHas('orders', [
            'status' => 'pending',
        ]);

        $this->orderService->done($order->id);

        $this->assertDatabaseHas('orders', [
            'status' => 'done',
        ]);
    }

    public function test_order_process()
    {
        $order = Order::factory()->create();

        $this->assertDatabaseHas('orders', [
            'status' => 'pending',
        ]);

        $this->orderService->process($order->id);

        $this->assertDatabaseHas('orders', [
            'status' => 'process',
        ]);
    }

    public function test_order_paid()
    {
        $order = Order::factory()->create();

        $this->assertDatabaseHas('orders', [
            'status' => 'pending',
        ]);

        $this->orderService->paid($order->id);

        $this->assertDatabaseHas('orders', [
            'status' => 'paid',
        ]);
    }

    public function test_cancel_failed()
    {
        $this->expectException(InvariantException::class);
        $order = Order::factory()->create(['status' => 'process']);

        $this->orderService->cancel($order->id);


    }

    public function test_order_cancel_success()
    {
        $order = Order::factory()->create();

        $this->assertDatabaseHas('orders', [
            'status' => 'pending',
        ]);

        $this->orderService->cancel($order->id);

        $this->assertDatabaseHas('orders', [
            'status' => 'cancel',
        ]);
    }


}
