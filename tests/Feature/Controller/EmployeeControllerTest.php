<?php

namespace Tests\Feature\Controller;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;
    public function test_store_employee_success()
    {
        Role::create(['name' => 'admin']);

        $this->post('/employees', [
            'name' => 'test',
            'telp' => '08xx',
            'image' => UploadedFile::fake()->image('image.jpg'),
            'address' => 'test address',
            'email' => 'rifai0850@gmail.com',
            'roles' => ['admin'],
        ]);

        $employee = Employee::first();

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('employees', 1);
//        $this->assertDatabaseCount('jobs', 1);

        $this->assertDatabaseHas('employees', [
            'name' => 'test',
            'telp' => '08xx',
            'address' => 'test address',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'test',
        ]);
    }


}
