<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->rolesAndPermissions();
        $this->testUsers();
    }

    private function rolesAndPermissions(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => Role::Admin]);
        Role::create(['name' => Role::User]);
    }

    private function testUsers(): void
    {
        $admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);
        $admin->assignRole(Role::Admin);

        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@user.com',
        ]);
        $user->assignRole(Role::User);
    }
}
