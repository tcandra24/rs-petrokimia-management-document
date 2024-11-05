<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name'      => 'Administrator',
            'email'     => 'admin@gmail.com',
            'password'  => bcrypt('mismis'),
            'type'  => 'director',
        ]);

        $user->markEmailAsVerified();

        //get all permissions
        $permissions = Permission::all();

        //get role admin
        $role = Role::where('name', 'admin')->first();

        //assign permission to role
        $role->syncPermissions($permissions);

        //assign role to user
        $user->assignRole($role);

        // --------------------------

        // $user1 = User::create([
        //     'name'      => 'Tito Candra',
        //     'email'     => 'tito@gmail.com',
        //     'password'  => bcrypt('mismis'),
        //     'type'  => 'general',
        // ]);

        // $user1->markEmailAsVerified();

        // //get all permissions
        // $permissions1 = Permission::all();

        // //get role admin
        // $role1 = Role::where('name', 'admin')->first();

        // //assign permission to role
        // $role1->syncPermissions($permissions1);

        // //assign role to user
        // $user1->assignRole($role1);

        // // --------------------------

        // $user2 = User::create([
        //     'name'      => 'hidayat',
        //     'email'     => 'hidayat@gmail.com',
        //     'password'  => bcrypt('mismis'),
        //     'type'  => 'assistant',
        // ]);

        // $user2->markEmailAsVerified();

        // //get all permissions
        // $permissions2 = Permission::all();

        // //get role admin
        // $role2 = Role::where('name', 'admin')->first();

        // //assign permission to role
        // $role2->syncPermissions($permissions2);

        // //assign role to user
        // $user2->assignRole($role2);

        // // --------------------------

        // $user3 = User::create([
        //     'name'      => 'direktur',
        //     'email'     => 'direktur@gmail.com',
        //     'password'  => bcrypt('mismis'),
        //     'type'  => 'director',
        // ]);

        // $user3->markEmailAsVerified();

        // //get all permissions
        // $permissions3 = Permission::all();

        // //get role admin
        // $role3 = Role::where('name', 'admin')->first();

        // //assign permission to role
        // $role3->syncPermissions($permissions3);

        // //assign role to user
        // $user3->assignRole($role3);
    }
}
