<?php

namespace Tests\Feature\Services;

use App\Http\Requests\TableAddRequest;
use App\Services\TableService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TableServiceTest extends TestCase
{
    use RefreshDatabase;

    private TableService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = $this->app->make(TableService::class);

    }


    public function test_example()
    {
        self::assertTrue(true);
    }

    public function test_add_table_success()
    {
        $request = new TableAddRequest([
            'number' => 1,
        ]);

        $result = $this->service->addTable($request);

        $this->assertDatabaseCount('tables', 1);
        $this->assertDatabaseHas('tables', [
            'number' => 1,
        ]);

    }


}
