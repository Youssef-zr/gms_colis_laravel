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
        // -----------------------------------------
        // "developpeur" role
        // -----------------------------------------
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

        // -----------------------------------------
        // "admin" role
        // -----------------------------------------
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

        $roleExpediteur = Role::create(['name' => 'expediteur']);
        $roleExpediteur->syncPermissions($expiditeurPermission);

        foreach ($ExpediteursUsers as $expediteur) {

            $newExpediteur = new User();
            $newExpediteur->fill($expediteur)->save();
            $newExpediteur->assignRole([$roleExpediteur->id]);
        }

        // -----------------------------------------
        //    "livreurs" role
        // -----------------------------------------
        $LivreursUsers = [
            [
                'name' => 'jamal',
                'email' => 'livreur1@app.com',
                'phone' => '0600000023',
                'password' => bcrypt('123456'),
                "status" => 'activé',
                "role_name" => 'livreur',

            ],
            [
                'name' => 'tarek',
                'email' => 'livreur2@app.com',
                'phone' => '0700000078',
                'password' => bcrypt('123456'),
                "status" => 'activé',
                "role_name" => 'livreur',

            ],
        ];

        $LivreursPermissions = [
            // "tableau_bord_index",
        ];

        $roleLivreur = Role::create(['name' => 'livreur']);
        $roleLivreur->syncPermissions($LivreursPermissions);

        foreach ($LivreursUsers as $livreur) {

            $newLivreur = new User();
            $newLivreur->fill($livreur)->save();
            $newLivreur->assignRole([$roleLivreur->id]);
        }

    }
}
