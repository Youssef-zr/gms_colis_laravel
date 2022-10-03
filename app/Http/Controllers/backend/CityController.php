<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "villes";
        $cities = City::all();

        return view("backend.views.cities.index", compact("title", "cities"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Nouvelle ville";

        return view("backend.views.cities.create", compact('title'));
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
        $new = new City();
        $new->fill($data)->save();

        return redirect_with_flash("msgSuccess", "ville ajoutée avec succès", "cities");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        $title = "Editer ville";

        return view("backend.views.cities.update", compact("title", "city"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $data = $this->validate($request, ['libelle' => 'required|string|max:50|unique:villes,libelle,' . $city->id]);
        $city->fill($data)->save();

        return redirect_with_flash("msgSuccess", "ville editer avec succès", "cities");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();

        return redirect_with_flash("msgSuccess", "ville supprimée avec succès", "cities");
    }
}
