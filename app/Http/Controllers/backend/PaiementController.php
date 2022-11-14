<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\paiement\crudPaiementRequest;
use App\Models\Colis;
use App\Models\Expediteur;
use App\Models\Lpaiment;
use App\Models\Paiement;
use App\Models\Statut;
use App\Models\Ville;
use App\Traits\UploadFiles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class PaiementController extends Controller
{
    use UploadFiles;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($limit = 25, $page = 1)
    {
        $title = "paiments";
        $livreurs = User::where('status', "activé")->where('roles_name', 3)->pluck('name', "id")->toArray();
        $expediteurs = Expediteur::pluck('nom', "id_Expediteur")->toArray();

        $query = Paiement::select("ID_paiement", "date", "montant", "id_utilisateur", "id_Expediteur");
        $query = $query->with('livreur:id,name', "expediteur:id_Expediteur,nom")->withCount("lpaiement");
        $query = $query->orderBy('ID_paiement', "desc");

        $limit = isset(request()->limit) ? request()->limit : $limit;
        $limit = intval($limit);
        $paiements = $query->paginate($limit);

        return view("backend.views.paiements.index",
            compact('title', 'paiements', "livreurs", "expediteurs")
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "paiments";
        $livreurs = User::where('roles_name', 3)->pluck('name', "id")->toArray();
        $expediteurs = Expediteur::pluck('nom', "id_Expediteur")->toArray();

        return view("backend.views.paiements.create", compact('title', 'livreurs', 'expediteurs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(crudPaiementRequest $request)
    {
        $data = Arr::except($request->all(), ['colis', 'recu_paiment']);
        $newPaiement = new Paiement();
        $newPaiement->fill($data)->save();

        $totalAmount = 0;
        $colis = $request->colis;

        if ($colis != null) {
            foreach ($colis as $colis_id) {

                $colisInfo = Colis::where('id_colis', $colis_id)->where('id_statut', 5)->first();
                
                // check colis not in lpaiement
                if ($colisInfo != null) {
                    $colisInfo->fill(['paye' => "1", "id_statut" => 9])->save();
                    $newLpaiement = new Lpaiment();
                    $newLpaiement->ID_paiement = $newPaiement->ID_paiement;
                    $newLpaiement->id_colis = $colisInfo->id_colis;
                    $newLpaiement->save();
                } else {
                    $colis = Arr::except($colis, $colis_id);
                }

            }

            // calculate total amount (montant total)
            $totalColisMontant = Colis::whereIn('id_colis', $colis)->pluck('montant')->toArray();
            $newCollection = new Collection($totalColisMontant);
            $totalAmount = $newCollection->sum();

            // save amount
            $newPaiement->fill(["montant" => $totalAmount])->save();
        }

        return redirect_with_flash("msgSuccess", "paiement ajouté avec succès", "paiements");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Paiement $paiement)
    {
        $title = "editer paiment - " . $paiement->ID_paiement;
        $livreurs = User::where('roles_name', 3)->pluck('name', "id")->toArray();
        $expediteurs = Expediteur::pluck('nom', "id_Expediteur")->toArray();

        $LpaiementColis = Lpaiment::where('ID_paiement', $paiement->ID_paiement)->pluck('id_colis')->toArray();
        $paiementColis = Colis::whereIn('id_colis', $LpaiementColis)->get();

        return view("backend.views.paiements.update", compact('title', "paiement", "paiementColis", "livreurs", "expediteurs"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(crudPaiementRequest $request, $id)
    {
        $paiement = Paiement::find($id);

        $newColis = $request->colis;

        $lPayement = Lpaiment::where('ID_paiement', $paiement->ID_paiement)->get();
        $lPaiementsColisId = $lPayement->pluck('id_colis')->toArray();

        if ($lPaiementsColisId != []) {
            $old_colis = Colis::whereIn("id_colis", $lPaiementsColisId)->get();
            foreach ($old_colis as $colis) {
                $colis->fill(['paye' => 0, "id_statut" => 5])->save();
                $old_lp_colis = Lpaiment::where("id_colis", $colis->id_colis)->first();
                if ($old_lp_colis != null) {
                    $old_lp_colis->delete();
                }
            }
        }

        if ($newColis != []) {
            foreach ($newColis as $colis_id) {
                $colis = Colis::find($colis_id);
                $colis->fill(['paye' => 1, "id_statut" => 9])->save();
                $newLpaiement = new Lpaiment();
                $newLpaiement->ID_paiement = $paiement->ID_paiement;
                $newLpaiement->id_colis = $colis->id_colis;
                $newLpaiement->save();
            }
        }

        $data = Arr::except($request->all(), ['colis']);
        $newPaiementColis = Lpaiment::where('ID_paiement', $paiement->ID_paiement)->pluck('id_colis')->toArray();
        $totalColisMontant = Colis::whereIn('id_colis', $newPaiementColis)->pluck('montant')->toArray();

        $newCollection = new Collection($totalColisMontant);
        $data['montant'] = $newCollection->sum();

        $data = Arr::except($data, ["recu_paiment"]);
        $paiement->fill($data)->save();

        $file = $request->recu_paiment;
        if ($request->hasFile("recu_paiment") and $file != null) {
            $this->compressedImage("recu_paiment", $paiement->ID_paiement . ".png", "assets/dist/storage/paiement");
        }

        return redirect_with_flash("msgSuccess", "paiement mis à jour avec succès", "paiements");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paiement $paiement)
    {
        $lpaiement = Lpaiment::where('ID_paiement', $paiement->ID_paiement)->get();
        $lPaiementsColisId = $lpaiement->pluck('id_colis')->toArray();

        if ($lPaiementsColisId != []) {
            $old_colis = Colis::whereIn("id_colis", $lPaiementsColisId)->get();
            foreach ($old_colis as $colis) {
                $colis->fill(['paye' => 0, "id_statut" => 5])->save();
                $old_lp_colis = Lpaiment::where("id_colis", $colis->id_colis)->first();
                if ($old_lp_colis != null) {
                    $old_lp_colis->delete();
                }
            }
        }
        $paiement->delete();

        return redirect_with_flash("msgSuccess", "paiement supprimé avec succès", "paiements");
    }

    // get colis not payed for selected ( expediteur and livreur)
    public function getColisNotPaid()
    {
        $data = request()->all();
        $expediteur = $data['expediteur'];
        $livreur = $data['livreur'];

        if ($expediteur != null and $livreur != null) {

            $colis = Colis::where("id_statut", 5)
                ->where('id_utilisateur', $livreur)
                ->where('id_Expediteur', $expediteur)
                ->where('paye', 0)
                ->with('ville:id_ville,libelle')
                ->get();

            return response()->json($colis);
        }
    }

    // search colis
    public function search(Request $request)
    {

        $query = Paiement::where('ID_paiement', "!=", 0);

        $numero_suivi = $request->numero_suivi;
        if ($request->has('numero_suivi') and $numero_suivi != null) {

            $colis = Colis::where('numero_suvi', "=", $numero_suivi)->first();
            $lpaiement = Lpaiment::where('id_colis', $colis->id_colis)->first();
            $query->where("ID_paiement", $lpaiement->ID_paiement);
        }

        // expediteur
        if ($request->id_expediteur != "") {
            $query->where('id_Expediteur', $request->id_expediteur);
        }

        // livreur
        if ($request->id_livreur != "") {
            $query->where('id_utilisateur', $request->id_livreur);
        }

        // date du | date au
        $from = $request->start_date;
        $to = $request->end_date;
        if ($from != "" and $to == "") {
            $query->where('date', ">=", $from);
        } else if ($from != "" and $to != "") {
            $query->whereBetween('date', [$from, $to]);
        } else if ($from == "" and $to != "") {
            $query->where('date', "<=", $to);
        }

        $paiements = $query->with(["expediteur:id_Expediteur,nom", "livreur:id,name"])
            ->withCount("lpaiement")->get();

        $title = "resultat de la recherche";
        $livreurs = User::where('roles_name', 3)->pluck('name', "id")->toArray();
        $statuts = Statut::pluck('libelle', "id_statut")->toArray();
        $expediteurs = Expediteur::pluck('nom', "id_Expediteur")->toArray();
        $villes = Ville::pluck('libelle', "id_ville")->toArray();

        $searchMode = "true";
        return view("backend.views.paiements.index",
            compact("title", "searchMode", "paiements", "statuts", "livreurs", "expediteurs")
        );
    }
}
