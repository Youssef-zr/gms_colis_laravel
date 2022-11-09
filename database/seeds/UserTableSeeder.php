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
        ]);

        $role = Role::create(['name' => 'developpeur']);
        $developer->fill(['roles_name' => $role->id]);
        $permissions = Permission::pluck('id', 'id')->toArray();
        $role->syncPermissions($permissions);
        $role->revokePermissionTo("tableau_bord_index");
        $developer->assignRole([$role->id])->save();

        // -----------------------------------------
        // "admin" role
        // -----------------------------------------
        $admin = User::create([
            'name' => 'ayoub',
            'email' => 'e.ayoub@mondialservice.ma',
            'phone' => '0600000001',
            'password' => bcrypt('123456'),
            "status" => 'activé',
        ]);

        $role = Role::create(['name' => 'admin']);
        $admin->fill(['roles_name' => $role->id]);
        $permissions = Permission::pluck('id', 'id')->toArray();
        $role->syncPermissions($permissions);
        $admin->assignRole([$role->id])->save();

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
            ],
            [
                'name' => 'tarek',
                'email' => 'livreur2@app.com',
                'phone' => '0700000078',
                'password' => bcrypt('123456'),
                "status" => 'activé',
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
            $newLivreur->fill(["roles_name" => $roleLivreur->id])->save();
        }
        
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
                "id_expediteur" => random_int(1,25),
            ],
            [
                'name' => 'rachid',
                'email' => 'expediteur2@app.com',
                'phone' => '0700000000',
                'password' => bcrypt('123456'),
                "status" => 'activé',
                "id_expediteur" => random_int(1,25),
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
            $newExpediteur->fill(["roles_name" => $roleExpediteur->id])->save();
        }

        

    }
}
