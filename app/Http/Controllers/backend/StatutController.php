<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Statut;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StatutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "statut";
        $statuts = Statut::all();

        return view("backend.views.statuts.index", compact('title', "statuts"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Nouveau statut";

        return view("backend.views.statuts.create", compact("title"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'libelle' => 'required|string|unique:statut,libelle',
            'color' => 'sometimes|nullable|string',
        ];

        $data = $this->validate($request, $rules);
        $new = new Statut();
        $new->fill($data)->save();

        return redirect_with_flash("msgSuccess", "statut ajouté avec succès", "statuts");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\statut  $statut
     * @return \Illuminate\Http\Response
     */
    public function show(Statut $statut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\statut  $statut
     * @return \Illuminate\Http\Response
     */
    public function edit(Statut $statut)
    {
        $title = "editer statut";

        return view("backend.views.statuts.update", compact("title", "statut"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\statut  $statut
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Statut $statut)
    {
        $rules = [
            "libelle" => 'required', "string", Rule::unique('statut', "libelle")->ignore($statut->id_statut, "id_statut"),
            'color' => 'sometimes|nullable|string',
        ];
        $data = $this->validate($request, $rules);
        $statut->fill($data)->save();

        return redirect_with_flash("msgSuccess", "statut mis à jour avec succès", "statuts");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\statut  $statut
     * @return \Illuminate\Http\Response
     */
    public function destroy(Statut $statut)
    {
        $statut->delete();

        return redirect_with_flash("msgSuccess", "statut supprimer avec succès", "statuts");
    }
}
