<?php

namespace Tests\Feature\Services;

use App\Http\Requests\UserAddRequest;
use App\Http\Requests\UserChangePasswordRequest;
use App\Models\Employee;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserService::class);
    }


    public function test_sample()
    {

        self::assertTrue(true);
    }

    public function test_add_user_success()
    {
        $employee = Employee::factory()->create();
        $request = new UserAddRequest([
            'employee_id' => $employee->id,
            'email' => $this->faker->email,
            'roles' => []
        ]);

        $result = $this->userService->addUser($request);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('employees', 1);

        $user = User::find($result->id);

        self::assertTrue(Hash::check($result->password, $user->password));
    }

    public function test_change_password()
    {
        $user = User::factory()->create();

        $request = new UserChangePasswordRequest([
            'old_password' => 'password',
            'new_password' => 'ganti password',
        ]);

        $result = $this->userService->changePassword($request, $user->id);

        self::assertTrue(Hash::check('ganti password' ,$result->password ));

    }


}
