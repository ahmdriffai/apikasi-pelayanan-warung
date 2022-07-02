<?php

namespace Tests\Feature\Services;

use App\Helper\Media;
use App\Http\Requests\MenuAddRequest;
use App\Http\Requests\MenuUpdateRequest;
use App\Models\Category;
use App\Models\Menu;
use App\Services\MenuService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class MenuServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker, Media;

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
            'image_path' => null,

        ]);
    }

    public function test_list_menu()
    {
        Menu::factory(20)->create();

        $list = $this->menuService->list('', 10);

        self::assertSame(10, $list->count());

        Menu::factory()->create(['name' => 'test']);

        $search = $this->menuService->list('test');

        self::assertSame(1, $search->count());

    }

    public function test_update_menu()
    {
        $menu = Menu::factory()->create();

        $category = Category::factory()->create();

        $request = new MenuUpdateRequest([
            'name' => 'name updated',
            'price' => 0,
            'description' => 'description updated',
            'category_id' => $category->id
        ]);

        $this->assertDatabaseCount('menus', 1);

        $result = $this->menuService->update($request, $menu->id);

        $this->assertDatabaseCount('menus', 1);
        $this->assertDatabaseHas('menus', [
            'name' => 'name updated',
            'price' => 0,
            'description' => 'description updated',
            'category_id' => $category->id
        ]);
    }

    public function test_delete_menu_without_file()
    {
        $menu = Menu::factory()->create();

        $this->assertDatabaseCount('menus', 1);

        $this->menuService->delete($menu->id);

        $this->assertDatabaseCount('menus', 0);
    }

    public function test_delete_menu_with_file() {
        $file = UploadedFile::fake()->create('file.pdf');
        $uploads = $this->uploads($file, 'test/');
        $menu = Menu::factory()->create(['image_path' => public_path('storage/'. $uploads['filePath'])]);

        self::assertFileExists($menu->image_path);
        $this->assertDatabaseCount('menus', 1);

        $this->menuService->delete($menu->id);

        $this->assertDatabaseCount('menus', 0);
        self::assertFileDoesNotExist($menu->image_path);
    }

    public function test_add_image_url()
    {
        $payment = Menu::factory()->create(['image_url' => null]);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $result = $this->menuService->addImage($payment->id, $file);

        $this->assertDatabaseHas('menus', [
           'image_url' => $result->image_url,
           'image_path' => $result->image_path,
        ]);

        self::assertNotNull($result->image_url);

        self::assertFileExists($result->image_path);

        @unlink($result->image_path);
    }

}
