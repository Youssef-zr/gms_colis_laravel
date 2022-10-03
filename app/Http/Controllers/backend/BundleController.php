<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\bandel\crudBandleRequest;
use App\Http\Requests\users\crudUserRequest;
use App\Models\Bundel;
use App\Models\City;
use App\Models\Note;
use App\Models\Status;
use App\User;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "colis";
        $bundels = Bundel::with(["expediteur:id,name", "livreur:id,name"])->get();

        return view("backend.views.bundels.index", compact("title", "bundels"));
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
        //
    }
}
