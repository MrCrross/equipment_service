<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'users_view',
            'users_view-delete',
            'users_edit',
            'equipment_brands_edit',
            'equipment_brands_view',
            'equipment_brands_view-delete',
            'equipment_models_view',
            'equipment_models_view-delete',
            'equipment_models_edit',
            'equipment_fields_view',
            'equipment_fields_view-delete',
            'equipment_fields_edit',
            'equipment_view',
            'equipment_view-delete',
            'equipment_edit',
            'equipment_orders_view',
            'equipment_orders_view-delete',
            'equipment_orders_my_edit',
            'equipment_orders_edit',
            'equipment_orders_create',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $roles = [
            [
                'name' => 'root',
                'user_name' => 'Администратор сервиса',
            ],
            [
                'name' => 'client',
                'user_name' => 'Клиент сервиса',
            ],
            [
                'name' => 'master',
                'user_name' => 'Мастер сервиса',
            ],
        ];
        // role => permissions
        $rolesPermissions = [
            'root' => Permission::pluck('id','id')->all(),
            'client' => Permission::whereIn(
                'name',
                [
                    'equipment_orders_create'
                ]
            )
                ->pluck('id','id'),
            'master' => Permission::whereIn(
                'name',
                [
                    'equipment_orders_my_edit',
                    'equipment_orders_create',
                ]
            )
                ->pluck('id','id'),
        ];
        $rolesIDs = [];
        foreach ($roles as $role) {
            $newRole = Role::create($role);
            $rolesIDs[$role['name']] = $newRole->id;
            $newRole->syncPermissions($rolesPermissions[$role['name']]);
        }

        $users = [
            [
                'name' => 'Администратор сервиса',
                'phone' => '+7(964)659-19-53',
                'login' => 'root',
                'password' => Hash::make('qweqwe123'),
                'email' => 'admin@equipment_service.com',
                'email_verified_at' => Carbon::now()->toDateTimeString(),
            ],
            [
                'name' => 'Мастер сервиса',
                'phone' => '+7(964)659-19-53',
                'login' => 'master',
                'password' => Hash::make('qweqwe123'),
                'email' => 'stanislon1@gmail.com',
                'email_verified_at' => Carbon::now()->toDateTimeString(),
            ],
            [
                'name' => 'Сотников Станислав Геннадьевич',
                'phone' => '+7(964)659-19-53',
                'login' => 'client',
                'password' => Hash::make('qweqwe123'),
                'email' => 'crrrya@yandex.ru',
                'email_verified_at' => Carbon::now()->toDateTimeString(),
            ],
        ];
        // login => role id
        $usersRoles = [
            'root' => $rolesIDs['root'],
            'client' => $rolesIDs['client'],
            'master' => $rolesIDs['master'],
        ];

        foreach ($users as $user) {
            $newUser = User::create($user);
            $newUser->assignRole($usersRoles[$user['login']]);
        }
    }
}
