<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Ville;
use Illuminate\Http\Request;

class VilleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "villes";
        $villes = Ville::all();

        return view("backend.views.villes.index", compact("title", "villes"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Nouvelle ville";

        return view("backend.views.villes.create", compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, ['libelle' => 'required|string|max:50|unique:villes,libelle']);
        $new = new Ville();
        $new->fill($data)->save();

        return redirect_with_flash("msgSuccess", "ville ajoutée avec succès", "villes");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ville  $ville
     * @return \Illuminate\Http\Response
     */
    public function show(Ville $ville)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ville  $ville
     * @return \Illuminate\Http\Response
     */
    public function edit(Ville $ville)
    {
        $title = "Editer ville";

        return view("backend.views.villes.update", compact("title", "ville"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ville  $ville
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ville $ville)
    {
        $data = $this->validate($request, ['libelle' => 'required|string|max:50|unique:villes,libelle,' . $ville->id]);
        $ville->fill($data)->save();

        return redirect_with_flash("msgSuccess", "ville editer avec succès", "villes");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ville  $ville
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ville $ville)
    {
        $ville->delete();

        return redirect_with_flash("msgSuccess", "ville supprimée avec succès", "villes");
    }
}
