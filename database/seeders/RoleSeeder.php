<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vyčistenie cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // VYTVORENIE ROLÍ
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $winemaker = Role::create(['name' => 'winemaker']);
        $worker = Role::create(['name' => 'worker']);
        $customer = Role::create(['name' => 'customer']);
        $visitor = Role::create(['name'=> 'visitor']);

        echo "✓ Role vytvorené\n";

        // VYTVORENIE PRÁV (PERMISSIONS)
        
        // Práva pre správu používateľov
        $perms['manage_users'] = Permission::create(['name' => 'manage users', 'guard_name' => 'web']);
        $perms['view_users'] = Permission::create(['name' => 'view users']);
        $perms['create_user'] = Permission::create(['name' => 'create user']);
        $perms['edit_user'] = Permission::create(['name' => 'edit user']);
        $perms['delete_user'] = Permission::create(['name' => 'delete user']);

        // Práva pre vinohradové riadky
        $perms['create_winerow'] = Permission::create(['name' => 'create winerow']);
        $perms['edit_winerow'] = Permission::create(['name' => 'edit winerow']);
        $perms['delete_winerow'] = Permission::create(['name' => 'delete winerow']);
        $perms['view_winerow'] = Permission::create(['name' => 'view winerow']);

        // Práva pre ošetrenia
        $perms['create_treatment'] = Permission::create(['name' => 'create treatment']);
        $perms['edit_treatment'] = Permission::create(['name' => 'edit treatment']);
        $perms['delete_treatment'] = Permission::create(['name' => 'delete treatment']);
        $perms['view_treatment'] = Permission::create(['name' => 'view treatment']);

        // Práva pre sklizne
        $perms['create_harvest'] = Permission::create(['name' => 'create harvest']);
        $perms['edit_harvest'] = Permission::create(['name' => 'edit harvest']);
        $perms['delete_harvest'] = Permission::create(['name' => 'delete harvest']);
        $perms['view_harvest'] = Permission::create(['name' => 'view harvest']);

        // Práva pre vína
        $perms['create_winebatch'] = Permission::create(['name' => 'create winebatch']);
        $perms['edit_winebatch'] = Permission::create(['name' => 'edit winebatch']);
        $perms['delete_winebatch'] = Permission::create(['name' => 'delete winebatch']);
        $perms['view_winebatch'] = Permission::create(['name' => 'view winebatch']);

        // Práva pre nákupy
        $perms['create_purchase'] = Permission::create(['name' => 'create purchase']);
        $perms['edit_purchase'] = Permission::create(['name' => 'edit purchase']);
        $perms['delete_purchase'] = Permission::create(['name' => 'delete purchase']);
        $perms['view_purchase'] = Permission::create(['name' => 'view purchase']);

        echo "✓ Práva (permissions) vytvorené\n";

        // PRIDELENIE PRÁV ROLÁM

        // Admin – má všetky práva
        $admin->givePermissionTo(array_values($perms));

        // Vinár – môže spravovať svoje vinohradové riadky, ošetrenia, sklizne, vína
        $winemaker->givePermissionTo([
            $perms['view_winerow'],
            $perms['create_winerow'],
            $perms['edit_winerow'],
            $perms['delete_winerow'],
            $perms['view_treatment'],
            $perms['create_winerow'],
            $perms['edit_winerow'],
            $perms['view_harvest'],
            $perms['create_harvest'],
            $perms['view_winebatch'],
            $perms['create_winebatch'],
            $perms['edit_winebatch'],
        ]);

        // Pracovník – môže len nahlasovať ošetrenia, sklizne (len čítať)
        $worker->givePermissionTo([
            $perms['view_winerow'],
            $perms['view_treatment'],
            $perms['create_treatment'],
            $perms['view_harvest'],
            $perms['create_harvest'],
        ]);

        // Zákazník – môže len nakupovať a čítať vína
        $customer->givePermissionTo([
            $perms['view_winebatch'],
            $perms['view_purchase'],
            $perms['create_purchase'],
        ]);

        // Návštevník - prezerať ponuku, základné info vinárstva
        $visitor->givePermissionTo([
            $perms['view_winebatch'],
        ]);
        
        echo "✓ Práva pridelené rolám\n";
    }
}
