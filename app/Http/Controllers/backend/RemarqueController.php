<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Remarque;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RemarqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Remarques";
        $remarques = Remarque::all();

        return view("backend.views.remarques.index", compact("title", "remarques"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Nouvelle remarque";

        return view("backend.views.remarques.create", compact("title"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, ['libelle' => "required|string|unique:remarques,libelle"]);
        
        $new = new Remarque();
        $new->fill($data)->save();

        return redirect_with_flash("msgSuccess", "remarque ajoutée avec succès", "remarques");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Remarque  $remarque
     * @return \Illuminate\Http\Response
     */
    public function show(Remarque $remarque)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Remarque  $remarque
     * @return \Illuminate\Http\Response
     */
    public function edit(Remarque $remarque)
    {
        $title = "editer remarque";

        return view("backend.views.remarques.update", compact("title", "remarque"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Remarque  $remarque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Remarque $remarque)
    {
        $rule =['required','string' , Rule::unique("remarques","libelle")->ignore($remarque->id_remarques,"id_remarques")];
        $data = $this->validate($request, ['libelle' =>$rule]) ;
        $remarque->fill($data)->save();

        return redirect_with_flash("msgSuccess", "remarque mise à jour avec succès", "remarques");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Remarque  $remarque
     * @return \Illuminate\Http\Response
     */
    public function destroy(Remarque $remarque)
    {
        $remarque->delete();

        return redirect_with_flash("msgSuccess", "remarque supprimée avec succès", "remarques");
    }
}
