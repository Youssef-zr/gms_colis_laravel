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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
        $livreurs = User::where('roles_name', 3)->pluck('name', "id")->toArray();
        $statuts = Statut::pluck('libelle', "id_statut")->toArray();
        $expediteurs = Expediteur::pluck('nom', "id_Expediteur")->toArray();
        $villes = Ville::pluck('libelle', "id_ville")->toArray();

        $query = Colis::with(["expediteur:id_Expediteur,nom", "livreur:id,name", "ville:id_ville,libelle", "statut"])
            ->orderBy('date', "desc");

        $limit = isset(request()->limit) ? request()->limit : $limit;
        $limit = intval($limit);
        $colisData = $query->paginate($limit);

        return view("backend.views.colis.index",
            compact("title", "colisData",
                "statuts", "livreurs",
                "expediteurs", "villes")
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Nouveau colis";
        $expediteurs = Expediteur::pluck('nom', "id_Expediteur")->toArray();
        $statuts = Statut::pluck('libelle', "id_statut")->toArray();
        $villes = Ville::pluck('libelle', "id_ville")->toArray();
        $remarques = Remarque::pluck('libelle', "id_remarques")->toArray();

        return view("backend.views.colis.create",
            compact("title", 'expediteurs',
                "statuts", "remarques", "villes")
        );
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
        $id_expediteur = $request->id_Expediteur;

        $data['numero_suvi'] = $request->numero_suvi ?? $this->generate_numero_suivi($id_expediteur);
        $new = new Colis();
        $new->fill($data)->save();

        $this->updateColisSignatureReceipt($request, $new->id);
        $this->compressedImage("recu", $new->id_colis, "assets/dist/storage/colis/recu");

        return redirect_with_flash("msgSuccess", "colis créé avec succès", "colis");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Colis  $colis
     * @return \Illuminate\Http\Response
     */
    public function show($id_colis)
    {
        $colis = Colis::with(['expediteur', 'livreur', 'ville', 'statut', "remarque"])->find($id_colis);

        $signature = "empty";
        $signature_path = "assets/dist/storage/colis/signature/" . $colis->id_colis . ".png";
        if (File::exists(public_path($signature_path))) {
            $signature = $signature_path;
        }

        $recu = "empty";
        $recu_path = "assets/dist/storage/colis/recu/" . $colis->id_colis . ".png";
        if (File::exists(public_path($recu_path))) {
            $recu = $recu_path;
        }

        return response()->json(["colis" => $colis, "signature" => $signature, "recu" => $recu], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Colis  $colis
     * @return \Illuminate\Http\Response
     */

    public function edit(Colis $coli)
    {
        $colis = $coli;

        $title = "Editer colis";
        $expediteurs = Expediteur::pluck('nom', "id_Expediteur")->toArray();
        $statuts = Statut::pluck('libelle', "id_statut")->toArray();
        $villes = Ville::pluck('libelle', "id_ville")->toArray();
        $remarques = Remarque::pluck('libelle', "id_remarques")->toArray();

        return view("backend.views.colis.update",
            compact("title", 'expediteurs',
                "statuts", "remarques",
                "villes", "colis")
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Colis  $colis
     * @return \Illuminate\Http\Response
     */
    public function update(crudColisRequest $request, Colis $coli)
    {
        $colis = $coli;
        $data = $request->all();
        $colis->fill($data)->save();

        $this->updateColisSignatureReceipt($request, $colis->id_colis);
        $this->compressedImage("recu", $colis->id_colis . ".png", "assets/dist/storage/colis/recu");

        return redirect_with_flash("msgSuccess", "colis mis à jour avec succès", "colis");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Colis  $coli
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
            foreach ($colis as $_colis) {

                $findColis = Colis::find($_colis);
                if ($findColis != null) {
                    $data['date'] != null ? $findColis->date = $data['date'] : null;
                    $data['id_utilisateur'] != null ? $findColis->id_utilisateur = $data['id_utilisateur'] : null;
                    $data['id_statut'] != null ? $findColis->id_statut = $data['id_statut'] : null;

                    $findColis->save();
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

    // update colis signature - recu
    public function updateColisSignatureReceipt($request, $id)
    {
        $colis = Colis::find($id);

        // create signatures folder in public directory
        if ($request->has('signature') and $request->signature != null) {
            $storagePathSignature = 'assets/dist/storage/colis/signature/';
            $customName = $colis->id_colis;

            $signatureInformation = UploadFiles::updateFileBase64($request->signature, $storagePathSignature, $colis->id_colis . ".png", $customName);
            $colis->fill(['signature' => $signatureInformation['path']])->save();
        }

        // create recu folder in public directory
        // if ($request->hasFile("recu")) {
        //     $storagePathRecu = 'assets/dist/storage/colis/recu';
        //     $customName = $colis->id_colis;

        //     $recuInformation = UploadFiles::updateFile($request->recu, $storagePathRecu, $colis->id_colis . ".png", null, $customName);
        //     $colis->fill(['recu' => $recuInformation['file_path']])->save();
        // }
    }

    // search colis
    public function search(SearchRequest $request)
    {

        $query = Colis::where('id_colis', "!=", null);

        // statut
        if ($request->status != "") {
            $query->where('id_statut', $request->status);
        }

        // expediteur
        if ($request->expediteur != "") {
            $query->where('id_Expediteur', $request->expediteur);
        }
        // livreur
        if ($request->livreur != "") {
            $query->where('id_utilisateur', $request->livreur);
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
        if ($request->numero_suivi != "") {
            $query->where('numero_suvi', "like", $request->numero_suivi);
        }

        // numero de commande
        if ($request->numero_commande != "") {
            $query->where('numero_commande', "like", $request->numero_commande);
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
        $livreurs = User::where('roles_name', 3)->pluck('name', "id")->toArray();
        $statuts = Statut::pluck('libelle', "id_statut")->toArray();
        $expediteurs = Expediteur::pluck('nom', "id_Expediteur")->toArray();
        $villes = Ville::pluck('libelle', "id_ville")->toArray();

        $colisData = $query->with(["expediteur:id_Expediteur,nom", "livreur:id,name"])->get();

        $searchMode = "true";

        return view("backend.views.colis.index",
            compact("title", "searchMode",
                "colisData", "statuts",
                "livreurs", "expediteurs", "villes")
        );
    }

    // ginerate numero_suivi
    public function generate_numero_suivi($id_expediteur)
    {
        $expediteur = Expediteur::select("Nom")->find($id_expediteur);
        $name = substr($expediteur->Nom, 0, 3);

        $lastColis = Colis::select("numero_suvi")
            ->where("id_expediteur", $id_expediteur)
            ->where("numero_suvi", "like", $name . "%")
            ->orderBy('id_colis', "desc")
            ->first();

        $lastNumeroSuivi = intVal(substr($lastColis->numero_suvi, 3));
        $lastNbLength = Str::length($lastNumeroSuivi);

        $numberOfZero = 9 - $lastNbLength;
        $newNbZero = str_repeat('0', $numberOfZero);

        $newSuivi = $name . $newNbZero . ($lastNumeroSuivi + 1);

        return $newSuivi;
    }
}
