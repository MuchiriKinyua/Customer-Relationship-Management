<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create role
        $hodRole = Role::create(['name' => 'head of department']);

        //create permissions
        Permission::create(['name' => 'check reports']);

        //assign permission to roles
        $hodRole->givePermissionTo('check reports');

        $user = User::find(4);
        $user->assignRole('head of department');
    }

}
