<?php

use App\Models\Expediteur;
use Illuminate\Database\Seeder;

class ExpediteursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $expediteurs = [
            ["nom" => 'ORIFLAME', "mail" => 'ORIFLAME@gms.ma'],
            ["nom" => 'IMCD', "mail" => 'IMCD@gms.ma'],
            ["nom" => 'Plantagri', "mail" => 'Plantagri@gms.ma'],
            ["nom" => 'OWN', "mail" => 'OWN@gms.ma'],
            ["nom" => 'MSS', "mail" => 'Mss@gms.ma'],
            ["nom" => 'KIDSVILLAGE', "mail" => 'KIDSVILLAGE@gms.ma'],
            ["nom" => 'GENIALMS', "mail" => 'genialms@gms.ma'],
            ["nom" => 'GENIALCAR', "mail" => 'genialcar@gms.ma'],
            ["nom" => 'EMC', "mail" => 'EMC@gms.ma'],
            ["nom" => 'GAF', "mail" => 'GAF@gms.ma'],
            ["nom" => 'FLOART', "mail" => 'FLOART@gms.ma'],
            ["nom" => 'ART_VAP', "mail" => 'ART_VAP@gms.ma'],
            ["nom" => 'MEDITEN', "mail" => 'mediten@gms.ma'],
            ["nom" => 'EDICOM', "mail" => 'EDICOM@gms.ma'],
            ["nom" => 'IRM', "mail" => 'irm@gms.ma'],
            ["nom" => 'ULTRA_GAMES', "mail" => 'ultra_games@gms.ma'],
            ["nom" => 'seg_maroc', "mail" => 'seg_maroc@gms.ma'],
            ["nom" => 'FAM', "mail" => 'fam@gms.ma'],
            ["nom" => 'YAMI_NEGOCE', "mail" => 'yami_negoce@gms.ma'],
            ["nom" => 'TOYOTA', "mail" => 'toyota@gms.ma'],
            ["nom" => 'RABAT-SHOP', "mail" => 'RABAT-SHOP@gms.ma'],
            ["nom" => 'MEGARAMA', "mail" => 'MEGARAMA@gms.ma'],
            ["nom" => 'FARMASI', "mail" => 'Farmasi@gms.ma'],
            ["nom" => 'TSWEAR', "mail" => 'TSWEAR@gms.ma'],
            ["nom" => 'TEXTILART', "mail" => 'Textilart@gms.ma'],
            ["nom" => '--vide-', "mail" => '-vide-'],
            ["nom" => '-vide--', "mail" => '-vide-'],
            ["nom" => 'CAPMAN', "mail" => 'Capman@gms.ma'],
            ["nom" => 'K.K SOURCING', "mail" => 'KKSOURSING@gms.ma'],
            ["nom" => 'MAQUILLAGI', "mail" => 'MAQUILLAGI@gms.ma'],
            ["nom" => '--vide-', "mail" => 'vide--'],
            ["nom" => 'WAFACASH', "mail" => 'WAFACASH@gms.ma'],
        ];

        foreach ($expediteurs as $expediteur) {
            $new = new Expediteur();
            $new->fill($expediteur)->save();
        }
    }
}
