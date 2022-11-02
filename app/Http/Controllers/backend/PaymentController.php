<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\crudPaymentRequest;
use App\Models\Bundel;
use App\Models\Lpaiment;
use App\Models\Payment;
use App\Traits\UploadFiles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class PaymentController extends Controller
{
    use UploadFiles;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "paiments";
        $payments = Payment::with('livreur:id,name', "expediteur:id,name")->get();

        return view("backend.views.payments.index", compact('title', 'payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "paiments";
        $livreurs = User::where('role_name', "livreur")->pluck('name', "id")->toArray();
        $expediteurs = User::where('role_name', "expediteur")->pluck('name', "id")->toArray();

        return view("backend.views.payments.create", compact('title', 'livreurs', 'expediteurs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(crudPaymentRequest $request)
    {
        $data = Arr::except($request->all(), ['colis', 'recu_paiment']);
        $newPayment = new Payment();
        $newPayment->fill($data)->save();

        $file = $request->recu_paiment;
        if ($request->hasFile("recu_paiment") and $file != null) {
            $fileBase64 = UploadFiles::fileTo64bit($file);
            $newPayment->fill(['recu_paiment' => $fileBase64])->save();
        }

        $totalAmount = 0;
        $bundels = $request->colis;

        foreach ($bundels as $bundel_id) {

            $bundeInfo = Bundel::where('id', $bundel_id)->first();
            $bundeInfo->fill(['paye' => "1","id_statut"=>9])->save();

            $newLpayment = new Lpaiment();
            $newLpayment->id_paiement = $newPayment->id;
            $newLpayment->id_colis = $bundeInfo->id;
            $newLpayment->save();

            $totalAmount += intval($bundeInfo->montant);
        }

        $newPayment->fill(["montant" => $totalAmount])->save();

        return redirect_with_flash("msgSuccess", "paiement ajouté avec succès", "payments");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        $title = "editer paiment - " . $payment->id;

        $id_payment = $payment->id;
        $LpaiementBundels = Lpaiment::where('id_paiement', $id_payment)->pluck('id_colis')->toArray();
        $paymentBundels = Bundel::whereIn('id', $LpaiementBundels)->get();

        return view("backend.views.payments.update", compact('title', "payment", "paymentBundels"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(crudPaymentRequest $request, $id_payment)
    {
        $payment = Payment::find($id_payment);

        $newBundels = $request->colis;
        $lPayement = Lpaiment::where('id_paiement', $payment->id)->get();
        $lPayementBundelsIds = $lPayement->pluck('id_colis')->toArray();

        $idBundelsToDelete = array_diff($lPayementBundelsIds, $newBundels);
        if ($idBundelsToDelete != []) {
            $bundels = Bundel::whereIn("id", $idBundelsToDelete)->get();
            foreach ($bundels as $bundel) {
                $bundel->fill(['paye' => 0,"id_statut"=>5])->save();
                Lpaiment::where("id_colis", $bundel->id)->first()->delete();
            }
        }

        $idBundelsInsert = array_diff($newBundels, $lPayementBundelsIds);

        $arr = [];
        if ($idBundelsInsert != []) {
            foreach ($idBundelsInsert as $bundel_id) {
                $bundelInfo = Bundel::find($bundel_id);
                $bundelInfo->fill(['paye' => 1,"id_statut"=>9])->save();
                dd($bundelInfo);
                $newLpayment = new Lpaiment();
                $newLpayment->id_paiement = $payment->id;
                $newLpayment->id_colis = $bundelInfo->id;
                $newLpayment->save();
            }
        }

        $data = Arr::except($request->all(), ['colis']);
        $newPaymentBundels = Lpaiment::where('id_paiement', $payment->id)->pluck('id_colis')->toArray();
        $totalBundelsAmount = Bundel::whereIn('id', $newPaymentBundels)->pluck('montant')->toArray();

        $newCollection = new Collection($totalBundelsAmount);
        $data['montant'] = $newCollection->sum();

        $file = $request->recu_paiment;
        if ($request->hasFile("recu_paiment") and $file != null) {
            $fileBase64 = UploadFiles::fileTo64bit($file);
            $data['recu_paiment'] = $fileBase64;
        }

        $payment->fill($data)->save();

        return redirect_with_flash("msgSuccess", "payment updated successfully", "payments");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // get bundels not payed for selected ( expediteur and livreur)
    public function getBundelsNotPaid()
    {
        $data = request()->all();
        $expediteur = $data['expediteur'];
        $livreur = $data['livreur'];

        if ($expediteur != null and $livreur != null) {

            $bundels = Bundel::where("id_statut", 5)
                ->where('id_livreur', $livreur)
                ->where('id_expediteur', $expediteur)
                ->where('paye', 0)
                ->with('ville:id,libelle')
                ->get();

            return response()->json($bundels);
        }
    }
}
