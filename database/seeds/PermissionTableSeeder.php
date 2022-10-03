<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            // dashboard stats
            "tableau_bord_index",
            
            // sites
            // "sites_index",
            // "liste_sites",
            // "ajouter_site",
            // "editer_site",
            // "supprimer_site",
            
            // users
            "utilisateurs_index",
            "liste_utilisateurs",
            "nouveau_utilisateur",
            "editer_utilisateur",
            "supprimer_utilisateur",

            // roles permissions
            "autorisations_index",
            "liste_rôles",
            "nouveau_rôle",
            "editer_rôle",
            "afficher_rôle",
            "supprimer_rôle",
            "nouvelle_autorisation",

            // // parameters
            // "show_site_parameters",

            // // notifications
            // "show_notifications",

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
