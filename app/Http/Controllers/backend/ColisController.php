<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\colis\crudColisRequest;
use App\Http\Requests\colis\SearchRequest;
use App\Models\Colis;
use App\Models\Expediteur;
use App\Models\Remarque;
use App\Models\Statut;
use App\Models\Ville;
use App\Traits\UploadFiles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ColisController extends Controller
{
    use UploadFiles;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($limit = 25, $page = 1)
    {
        $title = "colis";
        $livreurs = User::where('status', "activé")->where('roles_name', 3)->pluck('name', "id")->toArray();
        $statuts = Statut::pluck('libelle', "id")->toArray();
        $expediteurs = Expediteur::where('nom', "not like", "%vide%")->pluck('nom', "id")->toArray();
        $villes = Ville::pluck('libelle', "id")->toArray();

        $segments = request()->segments();
        $query = Colis::with(["expediteur:id,nom", "livreur:id,name"]);

        $limit = isset(request()->limit) ? request()->limit : $limit;
        $limit = intval($limit);

        $colisData = $query->paginate($limit);

        
        return view("backend.views.colis.index", compact("title", "colisData", "statuts", "livreurs", "expediteurs", "villes"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Nouveau colis";
        $expediteurs = Expediteur::where("nom", "not like", "%vide%")->pluck('nom', "id")->toArray();
        $statuts = Statut::pluck('libelle', "id")->toArray();
        $villes = Ville::pluck('libelle', "id")->toArray();
        $remarques = Remarque::pluck('libelle', "id")->toArray();

        return view("backend.views.colis.create", compact("title", 'expediteurs', "statuts", "remarques", "villes"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(crudColisRequest $request)
    {
        $data = $request->all();
        $new = new Colis();
        $new->fill($data)->save();

        $this->updateColisSignatureReceipt($request, $new->id);

        return redirect_with_flash("msgSuccess", "colis créé avec succès", "colis");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Colis  $colis
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $colis = Colis::where("id", $id)->with(['expediteur', 'livreur', 'ville', 'statut', "remarque"])->first();

        return response()->json([$colis], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Colis  $coli
     * @return \Illuminate\Http\Response
     */
    public function edit(colis $coli)
    {
        $colis = $coli;
        $title = "Editer colis";
        $expediteurs = Expediteur::where("nom", "not like", "%vide%")->pluck('nom', "id")->toArray();
        $statuts = Statut::pluck('libelle', "id")->toArray();
        $villes = Ville::pluck('libelle', "id")->toArray();
        $remarques = Remarque::pluck('libelle', "id")->toArray();

        return view("backend.views.colis.update", compact("title", 'expediteurs', "statuts", "remarques", "villes", "colis"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Colis  $coli
     * @return \Illuminate\Http\Response
     */
    public function update(crudColisRequest $request, Colis $coli)
    {
        $colis = $coli;
        $data = $request->all();
        $colis->fill($data)->save();
        $this->updateColisSignatureReceipt($request, $colis->id);

        return redirect_with_flash("msgSuccess", "colis mis à jour avec succès", "colis");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bundel  $bundel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Colis $coli)
    {
        $colis = $coli;
        UploadFiles::removeFile($colis->signature);
        UploadFiles::removeFile($colis->recu);
        $colis->delete();

        return redirect_with_flash("msgSuccess", "colis supprimer avec succès", "colis");
    }

    // livreur (affectation colis -> livreur)
    public function updateColisDelivery(Request $request)
    {
        $data = Arr::except($request->all(), ['example_length', "colis"]);
        $colis = $request->colis;

        if ($colis > 0) {
            foreach ($colis as $bundel) {

                $findBundel = Colis::find($bundel);
                if ($findBundel != null) {
                    $data['date'] != null ? $findBundel->date = $data['date'] : null;
                    $data['id_livreur'] != null ? $findBundel->id_livreur = $data['id_livreur'] : null;
                    $data['id_statut'] != null ? $findBundel->id_statut = $data['id_statut'] : null;

                    $findBundel->save();
                }
            }
        }

        return redirect_with_flash("msgSuccess", "informations mises à jour avec succès", "colis");
    }

    // get colis signature receipt form
    public function getColisSignatureReceipt($colis_id)
    {
        $bundel = Colis::find($colis_id);
        if ($bundel == null) {
            return redirect_to_404_if_emty($bundel);
        }

        $title = "colis signature";

        $oldSignature = '';
        if ($bundel->signature != "" and file_exists(public_path($bundel->signature))) {
            $oldSignature = $bundel->signature;
        }

        $oldReceipt = '';
        if ($bundel->recu != "" and file_exists(public_path($bundel->recu))) {
            $oldReceipt = $bundel->recu;
        }

        return view('backend.views.colis.signature.signature-form', compact('colis_id', "title", "oldSignature", "oldReceipt"));
    }

    // update colis signature - receipt
    public function updateColisSignatureReceipt($request, $id)
    {
        $colis = Colis::find($id);

        // create signatures folder in public directory
        if ($request->has('signed') and $request->signed != null) {
            $storagePathSignature = 'assets/dist/storage/signatures/';
            $customName = 'numero_suivi-' . $colis->numero_suivi;

            $signatureInformation = UploadFiles::updateFileBase64($request->signed, $storagePathSignature, $colis->signature, $customName);
            $colis->fill(['signature' => $signatureInformation['path']])->save();
        }

        // create recu folder in public directory
        if ($request->hasFile("receipt")) {
            $storagePathRecu = 'assets/dist/storage/receipt';
            $customName = "numero_suivi-" . $colis->numero_suivi;

            $recuInformation = UploadFiles::updateFile($request->receipt, $storagePathRecu, $colis->recu, null, $customName);
            $colis->fill(['recu' => $recuInformation['file_path']])->save();
        }
    }

    // search colis
    public function search(SearchRequest $request)
    {

        $query = Colis::where('id', "!=", "");

        // statut
        if ($request->status != "") {
            $query->where('id_statut', $request->status);
        }

        // expediteur
        if ($request->expediteur != "") {
            $query->where('id_expediteur', $request->expediteur);
        }
        // livreur
        if ($request->deliveryMan != "") {
            $query->where('id_livreur', $request->deliveryMan);
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

        // numero suivi
        if ($request->tracking_number != "") {
            $query->where('numero_suivi', "like", $request->tracking_number);
        }

        // numero de commande
        if ($request->order_number != "") {
            $query->where('numero_commande', "like", $request->order_number);
        }

        // nom de destinataire
        if ($request->name != "") {
            $query->where('nom_destinataire', "like", $request->name);
        }

        // adresse de destinataire
        if ($request->adress != "") {
            $query->where('adresse_destinataire', "like", "%" . $request->adress . "%");
        }

        // adresse de destinataire
        if ($request->city != "") {
            $query->where('id_ville', "=", $request->city);
        }

        $title = "resultat de la recherche";
        $livreurs = User::where('status', "activé")->where('roles_name', 3)->pluck('name', "id")->toArray();
        $statuts = Statut::pluck('libelle', "id")->toArray();
        $expediteurs = Expediteur::whereHas('colis')->pluck('nom', "id")->toArray();
        $villes = Ville::pluck('libelle', "id")->toArray();

        $segments = request()->segments();
        $query = $query->with(["expediteur:id,nom", "livreur:id,name"]);
        if (isset($segments[2]) and $segments[2] == "archived") {
            $query->onlyTrashed();
        }

        $colisData = $query->paginate(50);

        $searchMode = "true";

        return view("backend.views.colis.index", compact("title", "searchMode", "colisData", "statuts", "livreurs", "expediteurs", "villes"));
    }
}
