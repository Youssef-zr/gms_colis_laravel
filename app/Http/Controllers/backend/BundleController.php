<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\bundel\crudBandleRequest;
use App\Http\Requests\bundel\recuSignatureRequest;
use App\Models\Bundel;
use App\Models\City;
use App\Models\Note;
use App\Models\Status;
use App\Traits\bundelsCache;
use App\Traits\UploadFiles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BundleController extends Controller
{
    use bundelsCache, UploadFiles;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "colis";
        $livreurs = User::where('role_name', "livreur")->pluck('name', "id")->toArray();
        $statuts = Status::pluck('libelle', "id")->toArray();
        $bundelsData = bundelsCache::getBundelsCache();

        return view("backend.views.bundels.index", compact("title", "bundelsData", "statuts", "livreurs"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Nouveau colis";
        $expediteurs = User::where('role_name', "expediteur")->pluck('name', "id")->toArray();
        $statuts = Status::pluck('libelle', "id")->toArray();
        $villes = City::pluck('libelle', "id")->toArray();
        $remarques = Note::pluck('libelle', "id")->toArray();

        return view("backend.views.bundels.create", compact("title", 'expediteurs', "statuts", "remarques", "villes"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(crudBandleRequest $request)
    {
        $data = $request->all();
        $new = new Bundel();
        $new->fill($data)->save();
        bundelsCache::removeBundelsCache(true);

        return redirect_with_flash("msgSuccess", "colis créé avec succès", "bundels");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bundel  $bundel
     * @return \Illuminate\Http\Response
     */
    public function show(Bundel $bundel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bundel  $bundel
     * @return \Illuminate\Http\Response
     */
    public function edit(Bundel $bundel)
    {
        $title = "Editer colis";
        $expediteurs = User::where('role_name', "expediteur")->pluck('name', "id")->toArray();
        $statuts = Status::pluck('libelle', "id")->toArray();
        $villes = City::pluck('libelle', "id")->toArray();
        $remarques = Note::pluck('libelle', "id")->toArray();

        return view("backend.views.bundels.update", compact("title", 'expediteurs', "statuts", "remarques", "villes", "bundel"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bundel  $bundel
     * @return \Illuminate\Http\Response
     */
    public function update(crudBandleRequest $request, Bundel $bundel)
    {
        $data = $request->all();
        $bundel->fill($data)->save();
        bundelsCache::removeBundelsCache();

        return redirect_with_flash("msgSuccess", "colis mis à jour avec succès", "bundels");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bundel  $bundel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bundel $bundel)
    {
        UploadFiles::removeFile($bundel->signature);
        UploadFiles::removeFile($bundel->recu);

        $bundel->delete();
        bundelsCache::removeBundelsCache(true);

        return redirect_with_flash("msgSuccess", "colis supprimer avec succès", "bundels");
    }

    // delivery staff
    public function updateBundleDelivery(Request $request)
    {
        $data = Arr::except($request->all(), ['example_length', "colis"]);
        $bundels = $request->colis;

        if ($bundels > 0) {
            foreach ($bundels as $bundel) {
                $findBundel = Bundel::find($bundel);

                if ($findBundel != null) {
                    $data['date'] != null ? $findBundel->date = $data['date'] : null;
                    $data['id_livreur'] != null ? $findBundel->id_livreur = $data['id_livreur'] : null;
                    $data['id_statut'] != null ? $findBundel->id_statut = $data['id_statut'] : null;

                    $findBundel->save();
                }
            }
            bundelsCache::removeBundelsCache();
        }

        return redirect_with_flash("msgSuccess", "informations mises à jour avec succès", "bundels");
    }

    // get bundel signature receipt form
    public function getBundelSignatureReceipt($bundel_id)
    {
        $bundel = Bundel::find($bundel_id);
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

        return view('backend.views.bundels.signature.signature-form', compact('bundel_id', "title", "oldSignature", "oldReceipt"));
    }

    // update bundel signature - receipt
    public function updateBundelSignatureReceipt(recuSignatureRequest $request)
    {
        $bundel_id = $request->bundel_id;
        $bundel = Bundel::find($bundel_id);

        if ($request->has('signed') and $request->signed != null) {
            // create signatures folder in public directory
            $storagePathSignature = 'assets/dist/storage/signatures/';
            $signatureInformation = UploadFiles::updateFileBase64($request->signed, $storagePathSignature, $bundel->signature);
            $bundel->fill(['signature' => $signatureInformation['path']])->save();
        }

        if ($request->hasFile("receipt")) {
            // create recu folder in public directory
            $storagePathRecu = 'assets/dist/storage/receipt';
            $recuInformation = UploadFiles::updateFile($request->receipt, $storagePathRecu, $bundel->recu);
            $bundel->fill(['recu' => $recuInformation['file_path']])->save();
        }

        return redirect_with_flash("msgSuccess", "La signature a été enregistrée avec succès", "bundels/signature/" . $bundel_id);
    }
}
