<?php

namespace Tests\Feature\Services;

use App\Exceptions\InvariantException;
use App\Http\Requests\PaymentAddRequest;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Table;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentServiceTest extends TestCase
{
    use RefreshDatabase;
    private PaymentService $paymentService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->paymentService = $this->app->make(PaymentService::class);
    }


    public function test_example()
    {
        self::assertTrue(true);
    }

    public function test_add_payment_success()
    {
        $menu1 = Menu::factory()->create(['price' => 10000]);
        $menu2 = Menu::factory()->create(['price' => 20000]);
        $table = Table::factory()->create();

        $menu = [$menu1->id, $menu2->id];
        $order = new Order([
            'customer_name' => 'fai',
            'table_id' => $table->id,
            'status' => 'pending',
            'note' => 'catatan',
        ]);
        $order->save();

        for($i = 0; $i < 2; $i++){
            $order->menus()->attach($menu[$i],['quantity' => 1]);
        }

        $request = new PaymentAddRequest([
            'order_id' => $order->id,
            'cash' => 40000
        ]);

        $result = $this->paymentService->addPayment($request);

        self::assertEquals(10000, $this->paymentService->getRefund($result->amount_paid, $request->cash));

        $this->assertDatabaseCount('payments' , 1);

        $this->assertDatabaseHas('payments', [
           'amount_paid' => 30000,
           'date_paid' => date('Y-m-d', time())
        ]);

        $this->assertDatabaseHas('orders', [
            'status' => 'paid',
        ]);
    }

    public function test_add_payment_when_cash_less_than_amount_paid()
    {
        $this->expectException(InvariantException::class);
        $menu1 = Menu::factory()->create(['price' => 10000]);
        $menu2 = Menu::factory()->create(['price' => 20000]);
        $table = Table::factory()->create();

        $menu = [$menu1->id, $menu2->id];
        $order = new Order([
            'customer_name' => 'fai',
            'table_id' => $table->id,
            'status' => 'pending',
            'note' => 'catatan',
        ]);
        $order->save();

        for($i = 0; $i < 2; $i++){
            $order->menus()->attach($menu[$i],['quantity' => 1]);
        }

        $request = new PaymentAddRequest([
            'order_id' => $order->id,
            'cash' => 20000
        ]);

        $this->paymentService->addPayment($request);

        $this->assertDatabaseCount('payments', 0);
    }

    public function test_add_stroke_file_url()
    {
        $payment = Payment::factory()->create(['stroke_url' => null]);

        $result = $this->paymentService->addStokeUrl($payment->id, 2000);


        self::assertNotNull($result->stroke_url);

        self::assertFileExists($result->stroke_path);

        @unlink($result->stroke_url);
    }


}
