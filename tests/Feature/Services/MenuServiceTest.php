<?php

namespace Tests\Feature\Services;

use App\Http\Requests\MenuAddRequest;
use App\Models\Category;
use App\Models\Menu;
use App\Services\MenuService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
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

        $this->menuService->addMenu($request);

        $menu = Menu::first();


        self::assertSame($menu->category->name, $category->name);

        $this->assertDatabaseCount('categories', 1);

        $this->assertDatabaseHas('menus', [
           'name' => 'nasgor',
           'price' => 2000,
           'description' => 'desc',
            'category_id' => $category->id,
            'image_url' => null,
        ]);
    }

    public function test_add_image_url()
    {
        $payment = Menu::factory()->create(['image_url' => null]);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $result = $this->menuService->addImageUrl($payment->id, $file);


        self::assertNotNull($result->image_url);

        self::assertFileExists($result->image_url);

        @unlink($result->image_url);
    }

}
