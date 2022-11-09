<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\paiement\crudPaiementRequest;
use App\Models\Colis;
use App\Models\Expediteur;
use App\Models\Lpaiment;
use App\Models\Paiement;
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
    public function index()
    {
        $title = "paiments";
        $livreurs = User::where('status', "activé")->where('roles_name', 3)->pluck('name', "id")->toArray();
        $expediteurs = Expediteur::where('nom', "not like", "%vide%")->pluck('nom', "id")->toArray();
        $paiements = Paiement::select("id", "date", "montant", "id_livreur", "id_expediteur")->with('livreur:id,name', "expediteur:id,nom")->get();

        return view("backend.views.paiements.index", compact('title', 'paiements',"livreurs","expediteurs"));
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
        $expediteurs = Expediteur::where('nom', "not like", "%vide%")->pluck('nom', "id")->toArray();

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

        $file = $request->recu_paiment;
        if ($request->hasFile("recu_paiment") and $file != null) {
            $fileBase64 = UploadFiles::fileTo64bit($file);
            $newPaiement->fill(['recu_paiment' => $fileBase64])->save();
        }

        $totalAmount = 0;
        $colis = $request->colis;

        foreach ($colis as $colis_id) {

            $colisInfo = Colis::where('id', $colis_id)->first();
            $colisInfo->fill(['paye' => "1", "id_statut" => 9])->save();

            $newLpaiement = new Lpaiment();
            $newLpaiement->id_paiement = $newPaiement->id;
            $newLpaiement->id_colis = $colisInfo->id;
            $newLpaiement->save();

            $totalAmount += intval($colisInfo->montant);
        }

        $newPaiement->fill(["montant" => $totalAmount])->save();

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
        $title = "editer paiment - " . $paiement->id;
        $livreurs = User::where('roles_name', 3)->pluck('name', "id")->toArray();
        $expediteurs = Expediteur::where('nom', "not like", "%vide%")->pluck('nom', "id")->toArray();

        $id_paiement = $paiement->id;
        $LpaiementColis = Lpaiment::where('id_paiement', $id_paiement)->pluck('id_colis')->toArray();
        $paiementColis = Colis::whereIn('id', $LpaiementColis)->get();

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

        $lPayement = Lpaiment::where('id_paiement', $paiement->id)->get();
        $lPaiementsColisId = $lPayement->pluck('id_colis')->toArray();

        if ($lPaiementsColisId != []) {
            $old_colis = Colis::whereIn("id", $lPaiementsColisId)->get();
            foreach ($old_colis as $colis) {
                $colis->fill(['paye' => 0, "id_statut" => 5])->save();
                Lpaiment::where("id_colis", $colis->id)->first()->delete();
            }
        }

        if ($newColis != []) {
            foreach ($newColis as $colis_id) {
                $colis = Colis::find($colis_id);

                $colis->fill(['paye' => 1, "id_statut" => 9])->save();
                $newLpaiement = new Lpaiment();
                $newLpaiement->id_paiement = $paiement->id;
                $newLpaiement->id_colis = $colis->id;
                $newLpaiement->save();
            }
        }

        $data = Arr::except($request->all(), ['colis']);
        $newPaiementColis = Lpaiment::where('id_paiement', $paiement->id)->pluck('id_colis')->toArray();
        $totalColisMontant = Colis::whereIn('id', $newPaiementColis)->pluck('montant')->toArray();

        $newCollection = new Collection($totalColisMontant);
        $data['montant'] = $newCollection->sum();

        $file = $request->recu_paiment;
        if ($request->hasFile("recu_paiment") and $file != null) {
            $fileBase64 = UploadFiles::fileTo64bit($file);
            $data['recu_paiment'] = $fileBase64;
        }

        $paiement->fill($data)->save();

        return redirect_with_flash("msgSuccess", "paiement mis à jour avec succès", "paiements");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // get colis not payed for selected ( expediteur and livreur)
    public function getBundelsNotPaid()
    {
        $data = request()->all();
        $expediteur = $data['expediteur'];
        $livreur = $data['livreur'];

        if ($expediteur != null and $livreur != null) {

            $bundels = Colis::where("id_statut", 5)
                ->where('id_livreur', $livreur)
                ->where('id_expediteur', $expediteur)
                ->where('paye', 0)
                ->with('ville:id,libelle')
                ->get();

            return response()->json($bundels);
        }
    }

    // search colis
    // public function search(Request $request)
    // {

    //     dd($request->all());

    //     $query = Paiement::where('id', "!=", "");


    //     // expediteur
    //     if ($request->expediteur != "") {
    //         $query->where('id_expediteur', $request->expediteur);
    //     }
    //     // livreur
    //     if ($request->deliveryMan != "") {
    //         $query->where('id_livreur', $request->deliveryMan);
    //     }

    //     // date du | date au
    //     $from = $request->start_date;
    //     $to = $request->end_date;
    //     if ($from != "" and $to == "") {
    //         $query->where('date', ">=", $from);
    //     } else if ($from != "" and $to != "") {
    //         $query->whereBetween('date', [$from, $to]);
    //     } else if ($from == "" and $to != "") {
    //         $query->where('date', "<=", $to);
    //     }

    //     // numero suivi
    //     if ($request->tracking_number != "") {
    //         $query->where('numero_suivi', "like", $request->tracking_number);
    //     }

    //     // numero de commande
    //     if ($request->order_number != "") {
    //         $query->where('numero_commande', "like", $request->order_number);
    //     }

    //     // nom de destinataire
    //     if ($request->name != "") {
    //         $query->where('nom_destinataire', "like", $request->name);
    //     }

    //     // adresse de destinataire
    //     if ($request->adress != "") {
    //         $query->where('adresse_destinataire', "like", "%" . $request->adress . "%");
    //     }

    //     // adresse de destinataire
    //     if ($request->city != "") {
    //         $query->where('id_ville', "=", $request->city);
    //     }

    //     $title = "resultat de la recherche";
    //     $livreurs = User::where('status', "activé")->where('roles_name', 3)->pluck('name', "id")->toArray();
    //     $statuts = Statut::pluck('libelle', "id")->toArray();
    //     $expediteurs = Expediteur::whereHas('colis')->pluck('nom', "id")->toArray();
    //     $villes = Ville::pluck('libelle', "id")->toArray();

    //     $segments = request()->segments();
    //     $query = $query->with(["expediteur:id,nom", "livreur:id,name"]);
    //     if (isset($segments[2]) and $segments[2] == "archived") {
    //         $query->onlyTrashed();
    //     }

    //     $colisData = $query->paginate(50);

    //     $searchMode = "true";

    //     return view("backend.views.colis.index", compact("title", "searchMode", "colisData", "statuts", "livreurs", "expediteurs", "villes"));
    // }
}
