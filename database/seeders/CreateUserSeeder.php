<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userAdmin = User::create([
            'name' => 'User Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('rahasia')
        ]);

        $userKithcen = User::create([
            'name' => 'User Dapur',
            'email' => 'dapur@gmail.com',
            'password' => bcrypt('rahasia')
        ]);

        $userWaiter = User::create([
            'name' => 'User Pelayan',
            'email' => 'pelayan@gmail.com',
            'password' => bcrypt('rahasia')
        ]);

        $userCashier = User::create([
            'name' => 'User Kasir',
            'email' => 'kasir@gmail.com',
            'password' => bcrypt('rahasia')
        ]);



        $roleAdmin = Role::create(['name' => 'admin']);
        $roleKitchen = Role::create(['name' => 'kitchen']);
        $roleCashier = Role::create(['name' => 'cashier']);
        $roleWaiter = Role::create(['name' => 'waiter']);

        $permissions = Permission::pluck('id','id')->all();

        $roleAdmin->syncPermissions($permissions);

        $userAdmin->assignRole([$roleAdmin->id]);
        $userKithcen->assignRole([$roleKitchen->id]);
        $userCashier->assignRole([$roleCashier->id]);
        $userWaiter->assignRole([$roleWaiter->id]);
    }
}
