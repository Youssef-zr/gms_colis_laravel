<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\expediteur\crudExpediteurRequest;
use App\Models\Expediteur;
use Illuminate\Http\Request;

class ExpediteurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "list expediteurs";
        $expediteurs = Expediteur::where("nom", "not like", "%vide%")->get();

        return view("backend.views.expediteurs.index", compact("title", "expediteurs"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "nouveau expediteur";
        return view("backend.views.expediteurs.create", compact("title"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(crudExpediteurRequest $request)
    {

        $new = new Expediteur();
        $new->fill($request->all())->save();

        return redirect_with_flash("msgSuccess","Expéditeurs ajoutés avec succès","expediteurs");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expediteur  $expediteur
     * @return \Illuminate\Http\Response
     */
    public function show(Expediteur $expediteur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expediteur  $expediteur
     * @return \Illuminate\Http\Response
     */
    public function edit(Expediteur $expediteur)
    {
        $title = "editer expediteur";

        return view("backend.views.expediteurs.update",compact('title',"expediteur"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expediteur  $expediteur
     * @return \Illuminate\Http\Response
     */
    public function update(crudExpediteurRequest $request, Expediteur $expediteur)
    {
        $expediteur->fill($request->all())->save();

        return redirect_with_flash("msgSuccess","expéditeur mis à jour avec succès","expediteurs");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expediteur  $expediteur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expediteur $expediteur)
    {
       $expediteur->delete();

       return redirect_with_flash('msgSuccess',"expéditeur supprimé avec succès","expediteurs");
    }
}
