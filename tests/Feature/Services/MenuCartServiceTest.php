<?php

namespace Tests\Feature\Services;

use App\Exceptions\InvariantException;
use App\Http\Requests\MenuCartAddRequest;
use App\Models\Menu;
use App\Models\MenuCart;
use App\Models\User;
use App\Services\MenuCartService;
use Database\Seeders\CreateUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MenuCartServiceTest extends TestCase
{
    use RefreshDatabase;

    private MenuCartService $menuCartService;

    protected function setUp(): void
    {
        parent::setUp();
//        $this->artisan('db:seed', ['--class' => CreateUserSeeder::class]);

        $this->menuCartService = $this->app->make(MenuCartService::class);
    }


    public function test_example()
    {
       self::assertTrue(true);
    }

    public function test_add_menu_cart_with_empty_menu()
    {
        $user = User::factory()->create();
        $menu = Menu::factory()->create();
        $request = new MenuCartAddRequest([
            'menu_id' => $menu->id,
            'quantity' => 1,
        ]);

        $this->menuCartService->addMenuCart($request, $user);

        $this->assertDatabaseCount('menu_carts', 1);

        $this->assertDatabaseHas('menu_carts', [
           'menu_id' => $menu->id,
           'user_id' => $user->id,
           'quantity' => 1
        ]);

    }

    public function test_add_menu_cart_with_exist_menu()
    {
        $user = User::factory()->create();
        $menu = Menu::factory()->create();

        MenuCart::factory()->create([
            'menu_id' => $menu->id,
            'user_id' => $user->id,
            'quantity' => 1,
        ]);

        $request = new MenuCartAddRequest([
            'menu_id' => $menu->id,
            'quantity' => 1,
        ]);

        $this->assertDatabaseCount('menu_carts', 1);

        $this->menuCartService->addMenuCart($request, $user);

        $this->assertDatabaseCount('menu_carts', 1);

        $this->assertDatabaseHas('menu_carts', [
            'menu_id' => $menu->id,
            'user_id' => $user->id,
            'quantity' => 2
        ]);

        $request = new MenuCartAddRequest([
            'menu_id' => $menu->id,
            'quantity' => 2,
        ]);

        $this->menuCartService->addMenuCart($request, $user);

        $this->assertDatabaseCount('menu_carts', 1);
        $this->assertDatabaseHas('menu_carts', [
            'quantity' => 4
        ]);
    }

    public function test_add_menu_cart_with_empty_user()
    {
        $this->expectException(InvariantException::class);
        $menu = Menu::factory()->create();

        $request = new MenuCartAddRequest([
            'menu_id' => $menu->id,
            'quantity' => 1,
        ]);

        $this->menuCartService->addMenuCart($request, null);

        $this->assertDatabaseCount('menu_carts', 0);
    }

    public function test_delete_menu_cart_with_quantity_than_more_one()
    {
        $menuCart = MenuCart::factory()->create(['quantity' => 2]);

        $this->menuCartService->deleteMenuCart($menuCart->id);

        $this->assertDatabaseCount('menu_carts', 1);
        $this->assertDatabaseHas('menu_carts',[
           'quantity' => 1
        ]);
    }

    public function test_delete_menu_cart_with_quantity_is_one()
    {
        $menuCart = MenuCart::factory()->create(['quantity' => 1]);

        $this->assertDatabaseCount('menu_carts', 1);

        $this->menuCartService->deleteMenuCart($menuCart->id);

        $this->assertDatabaseCount('menu_carts', 0);

    }


}
