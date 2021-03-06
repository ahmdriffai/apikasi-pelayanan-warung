<?php

namespace Tests\Feature\Services;

use App\Http\Requests\EmployeeAddRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Employee;
use App\Models\User;
use App\Services\EmployeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EmployeeServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private EmployeeService $employeeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->employeeService = $this->app->make(EmployeeService::class);
    }


    public function test_example()
    {
        self::assertTrue(true);
    }

    public function test_add_employee_success()
    {
        Role::create(['name' => 'admin']);
        $request = new EmployeeAddRequest([
            'name' => 'wondo',
            'telp' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'email' => $this->faker->email(),
            'roles' => ['admin'],
        ]);

        $result = $this->employeeService->addEmployee($request);

        $this->assertDatabaseCount( 'users', 1);
        $this->assertDatabaseCount('employees', 1);
        $this->assertDatabaseHas('employees', [
            'name' => 'wondo',
        ]);
        $this->assertDatabaseHas('users', [
            'name' => 'wondo'
        ]);

        $user = User::find($result->id);

        self::assertSame($user->employee->id, $result->id);

        self::assertTrue(Hash::check($result->password,$user->password));

        self::assertNotSame($user->password, $result->password);
        self::assertSame($user->name, $result->employee->name);

    }

    public function test_add_image_success()
    {
        $employee = Employee::factory()->create(['image_url' => null]);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $result = $this->employeeService->addImageUrl($file, $employee->id);

        $this->assertDatabaseHas('employees', [
            'image_url' => $result->image_url,
            'image_path' => $result->image_path,
        ]);

        self::assertNotNull($result->image_url);

        self::assertFileExists($result->image_path);

        @unlink($result->image_path);
    }

    public function test_update_employee_without_user_success()
    {
        $employee = Employee::factory()->create();
        Role::create(['name' => 'admin']);

        $request = new EmployeeUpdateRequest([
            'name' => 'test',
            'telp' => '08xx',
            'address' => 'test',
            'roles' => 'admin',
        ]);

        $result = $this->employeeService->updateEmployee($request, $employee->id);

        self::assertNotSame($employee->name, $result->name);
        self::assertNotSame($employee->telp, $result->telp);
        self::assertNotSame($employee->address, $result->address);
        self::assertNull($result->user_id);
    }

    public function test_update_employee_with_user_success()
    {
        $user = User::factory()->create(['email' => 'test@test.test']);
        $employee = Employee::factory()->create(['user_id' => $user->id]);
        Role::create(['name' => 'admin']);

        $request = new EmployeeUpdateRequest([
            'name' => 'test',
            'telp' => '08xx',
            'address' => 'test',
            'roles' => 'admin',
        ]);

        $result = $this->employeeService->updateEmployee($request, $employee->id);

        $this->assertDatabaseCount('employees' , 1);

        self::assertNotSame($employee->name, $result->name);
        self::assertNotSame($employee->telp, $result->telp);
        self::assertNotSame($employee->address, $result->address);

        $this->assertDatabaseCount('users' , 1);
    }


}
