<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // "developpeur" role
        $developer = User::create([
            'name' => 'omag dev',
            'email' => 'omag@dev.com',
            'phone' => '0600000022',
            'password' => bcrypt('nbx-de08shah^@@'),
            "status" => 'activé',
            "role_name" => 'developpeur',
        ]);

        $role = Role::create(['name' => 'developpeur']);
        $permissions = Permission::pluck('id', 'id')->toArray();
        $role->syncPermissions($permissions);
        $role->revokePermissionTo("tableau_bord_index");
        $developer->assignRole([$role->id]);

        // "admin" role
        $admin = User::create([
            'name' => 'ayoub',
            'email' => 'e.ayoub@mondialservice.ma',
            'phone' => '0600000001',
            'password' => bcrypt('123456'),
            "status" => 'activé',
            "role_name" => 'admin',
        ]);

        $role = Role::create(['name' => 'admin']);
        $permissions = Permission::pluck('id', 'id')->toArray();
        $role->syncPermissions($permissions);
        $admin->assignRole([$role->id]);

        // -----------------------------------------
        //    "expiditeur" role
        // -----------------------------------------
        $ExpediteursUsers = [
            [
                'name' => 'said',
                'email' => 'expediteur1@app.com',
                'phone' => '0600000000',
                'password' => bcrypt('123456'),
                "status" => 'activé',
                "role_name" => 'expediteur',

            ],
            [
                'name' => 'rachid',
                'email' => 'expediteur2@app.com',
                'phone' => '0700000000',
                'password' => bcrypt('123456'),
                "status" => 'activé',
                "role_name" => 'expediteur',

            ],
        ];

        $expiditeurPermission = [
            // "tableau_bord_index",
        ];

        $roleAdmin = Role::create(['name' => 'expediteur']);
        $roleAdmin->syncPermissions($expiditeurPermission);

        foreach ($ExpediteursUsers as $expediteur) {

            $newAdmin = new User();
            $newAdmin->fill($expediteur)->save();
            $newAdmin->assignRole([$roleAdmin->id]);
        }

    }
}
