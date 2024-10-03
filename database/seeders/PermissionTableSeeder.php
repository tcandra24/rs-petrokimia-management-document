<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'dashboard.index', 'guard_name' => 'web']);

        Permission::create(['name' => 'master.divisions.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'master.divisions.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'master.divisions.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'master.divisions.destroy', 'guard_name' => 'web']);

        Permission::create(['name' => 'master.instructions.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'master.instructions.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'master.instructions.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'master.instructions.destroy', 'guard_name' => 'web']);

        Permission::create(['name' => 'transaction.memos.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'transaction.memos.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'transaction.memos.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'transaction.memos.destroy', 'guard_name' => 'web']);

        Permission::create(['name' => 'transaction.dispositions.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'transaction.dispositions.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'transaction.dispositions.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'transaction.dispositions.destroy', 'guard_name' => 'web']);

        Permission::create(['name' => 'setting.users.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'setting.users.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'setting.users.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'setting.users.destroy', 'guard_name' => 'web']);

        Permission::create(['name' => 'setting.permissions.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'setting.permissions.create', 'guard_name' => 'web']);

        Permission::create(['name' => 'setting.roles.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'setting.roles.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'setting.roles.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'setting.roles.delete', 'guard_name' => 'web']);
    }
}
