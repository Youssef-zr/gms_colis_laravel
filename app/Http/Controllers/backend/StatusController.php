<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "status";
        $statuses = Status::all();

        return view("backend.views.statuses.index", compact('title', "statuses"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Nouveau statut";

        return view("backend.views.statuses.create", compact("title"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, ['libelle' => 'required|string|unique:status,libelle']);

        $new = new status();
        $new->fill($data)->save();

        return redirect_with_flash("msgSuccess", "statut ajouté avec succès", "statuses");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\status  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        $title = "editer statut";

        return view("backend.views.statuses.update", compact("title", "status"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, status $status)
    {
        $data = $this->validate($request, ['libelle' => 'required|string|unique:status,libelle,' . $status->id]);
        $status->fill($data)->save();

        return redirect_with_flash("msgSuccess", "statut mis à jour avec succès", "statuses");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        $status->delete();

        return redirect_with_flash("msgSuccess", "statut supprimer avec succès", "statuses");
    }
}
