<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $roles = [
            ['name' => 'super-admin', 'title' => 'Super Admin', 'description' => 'Super Admin'],
            ['name' => 'admin', 'title' => 'Admin', 'description' => 'Admin'],
            ['name' => 'user', 'title' => 'User', 'description' => 'User'],
        ];
        $roles_all = Role::all();
        foreach ($roles as $role) {
            $role_exist = $roles_all->where('name', $role['name'])->first();
            if (!$role_exist) {
                Role::create($role);
            }
        }

        $permissions = [
            ['name' => 'create-user', 'title' => 'Create User', 'description' => 'Create User'],
            ['name' => 'edit-user', 'title' => 'Edit User', 'description' => 'Edit User'],
            ['name' => 'delete-user', 'title' => 'Delete User', 'description' => 'Delete User'],

            ['name' => 'create-role', 'title' => 'Create Role', 'description' => 'Create Role'],
            ['name' => 'edit-role', 'title' => 'Edit Role', 'description' => 'Edit Role'],
            ['name' => 'delete-role', 'title' => 'Delete Role', 'description' => 'Delete Role'],

            ['name' => 'create-permission', 'title' => 'Create Permission', 'description' => 'Create Permission'],
            ['name' => 'edit-permission', 'title' => 'Edit Permission', 'description' => 'Edit Permission'],
            ['name' => 'delete-permission', 'title' => 'Delete Permission', 'description' => 'Delete Permission'],

            ['name' => 'create-event', 'title' => 'Create Event', 'description' => 'Create Event'],
            ['name' => 'edit-event', 'title' => 'Edit Event', 'description' => 'Edit Event'],
            ['name' => 'delete-event', 'title' => 'Delete Event', 'description' => 'Delete Event']
        ];
        $permissions_all = Permission::all();
        foreach ($permissions as $permission) {
            $permission_exist = $permissions_all->where('name', $permission['name'])->first();
            if (!$permission_exist) {
                Permission::create($permission);
            }
        }

        $user_super_admin = User::where('email', 'fzhunio91@hotmail.com')->first();
        if (!$user_super_admin) {
            $user_super_admin = User::create([
                'name' => 'fernando zhunio',
                'email' => 'fzhunio91@hotmail.com',
                'is_student' => false,
                'birthday' => Carbon::parse('1991/08/01')->format('Y-m-d H:i:s'),
                'password' => bcrypt('fernando1991'),
            ]);
        }
        $user_super_admin->assignRole('super-admin');
        // \App\Models\Event::factory(50)->create();
    }
}
