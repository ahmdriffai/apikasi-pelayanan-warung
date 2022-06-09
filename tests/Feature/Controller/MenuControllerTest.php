<?php

namespace Tests\Feature\Controller;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class MenuControllerTest extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;

    public function test_store_menu_success()
    {
        $category = Category::factory()->create();
        $response = $this->post('/menus', [
            'name' => 'test',
            'price' => 2000,
            'description' => 'desc',
            'image' => UploadedFile::fake()->image('test.jpg'),
            'category_id' => $category->id,
        ]);

        $this->assertDatabaseHas('menus', [
            'name' => 'test', 'price' => 2000, 'description' => 'desc'
        ]);

        $menu = Menu::first();


        self::assertNotNull($menu->image_url);

        @unlink($menu->image_url);

    }
}
