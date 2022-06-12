<?php

namespace Tests\Feature\Services;

use App\Http\Requests\CategoryAddRequest;
use App\Services\CategoryService;
use FontLib\Table\Type\os2;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    private CategoryService $categoryService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->categoryService = $this->app->make(CategoryService::class);
    }


    public function test_provider()
    {
        self::assertTrue(true);
    }

    public function test_add_category_succes()
    {
        $request = new CategoryAddRequest(['name' => 'Makanan']);

        $this->categoryService->addCategory($request);

        $this->assertDatabaseCount('categories', 1);
        $this->assertDatabaseHas('categories', [
           'name' => 'Makanan'
        ]);

    }


}
