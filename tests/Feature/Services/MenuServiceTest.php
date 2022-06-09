<?php

namespace Tests\Feature\Services;

use App\Http\Requests\MenuAddRequest;
use App\Models\Category;
use App\Models\Menu;
use App\Services\MenuService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MenuServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private MenuService $menuService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->menuService = $this->app->make(MenuService::class);
    }


    public function test_example()
    {
        self::assertTrue(true);
    }

    public function test_add_menu_success()
    {
        $category = Category::factory()->create(['name' => 'Makanan']);

        $request = new MenuAddRequest([
            'name' => 'nasgor',
            'price' => 2000,
            'description' => 'desc',
            'category_id' => $category->id,
        ]);

        $imagePath = '/storage/image/test.jpg';

        $this->menuService->addMenu($request, $imagePath);

        $menu = Menu::first();


        self::assertSame($menu->category->name, $category->name);

        $this->assertDatabaseCount('categories', 1);

        $this->assertDatabaseHas('menus', [
           'name' => 'nasgor',
           'price' => 2000,
           'description' => 'desc',
            'category_id' => $category->id
        ]);
    }


}
