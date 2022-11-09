<?php

use App\Models\Colis;
use App\Models\Lpaiment;
use App\Models\Ville;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Auth routes list
Auth::routes(
    [
        'register' => false, // Registration Routes...
        'reset' => false, // Password Reset Routes...
        'verify' => false, // Email Verification Routes...
    ]
);

Route::post('/login', ['uses' => 'Auth\LoginController@login', 'middleware' => 'CheckUserStatus']);

// site Routes frontEnd
// Route::group(["middleware" => ['web'], 'namespace' => 'frontEnd'], function () {
//     Route::get('/', 'FrontController@home');
//     Route::get('/contact', 'FrontController@contact');
//     Route::post('/contact', 'FrontController@sendMail')->name('frontend.sendMail');
// });

// Dashboard Routes BackEnd
Route::group(['prefix' => "admin", "middleware" => ['auth'], 'namespace' => 'backend'], function () {

    // dashboard routes
    Route::get('/', 'DashboardController@welcome');
    route::get('/logout', "DashboardController@logout");

    // villes rotes
    Route::resource('/villes', "VilleController");

    // statuts rotes
    Route::resource('/statuts', "StatutController");

    // expediteurs rotes
    Route::resource('/expediteurs', "ExpediteurController");

    // remarques rotes
    Route::resource('/remarques', "RemarqueController");

    // colis rotes
    Route::resource('/colis', "ColisController");
    Route::get("/search/colis","ColisController@search")->name('colis.search');
    Route::patch('/colisUpdateDelivery', "ColisController@updateColisDelivery")->name('staff.updateDelivery');

    // paiemenst routes
    Route::resource('/paiements', "PaiementController");
    Route::get('/paiement/rechercher', "PaiementController@search")->name('paiements.search');

    // get bundels not payed for selected (expediteur and livreur)
    Route::get('/colis-statut/paiement', "PaiementController@getBundelsNotPaid")->name('payments.colis_not_paid');

    // users resource
    Route::resource('/users', "UserController");
    Route::get('user/profile', "UserController@editProfile")->name('user.edit_profile');
    Route::patch('user/updateProfile/{user}', "UserController@updateProfile")->name('user.update_profile');
    Route::patch('user/changePassword/{user}', "UserController@updatePassword")->name('user.change_password');

    // roles resource
    Route::resource('/roles', "RoleController");
    Route::get('/permission/create', "RoleController@newPermission");
    Route::post('/permission/store', 'RoleController@createPermission')->name('permission.store');

});

// -----------------------------
// just to testing some features
// -----------------------------

// Route::get('/test/{id}', function () {
//     // $file = Facture::findOrFail(3);

//     // return response()->make(file_get_contents(public_path($file->chemin)), 200, [
//     //     'Content-Type' => 'application/pdf',
//     //     'Content-Disposition' => 'inline; filename="' . $file->nom_fichier . '"',
//     // ]);
//     $calendar = Planning::where('IDClient', request()->id)->first();
//     $title = "calendar";
//     return view('backend.views.plannings.index', compact("calendar", "title"));

// });

Route::get('/test', function () {

    $payment = Lpaiment::where('id_paiement', 2)->pluck('id_colis')->toArray();

    $bundelsAmount = Colis::whereIn("id", $payment)->pluck('montant')->toArray();
    $collection = new Collection($bundelsAmount);

    dd($collection->sum());

    $old = [1, 5, 15, 28, 63];
    $new = [1, 18, 15, 63, 47, 11];

    $updatedAndRemoved = array_diff($old, $new);
    $inserted = array_diff($new, $old);

    dd($updatedAndRemoved, $inserted);

    $path = public_path("assets/dist/js/cities.json");
    $cities = json_decode(file_get_contents($path), true);

    foreach ($cities['cities'] as $city) {
        $new = new Ville();
        $new->libelle = $city["city"];
        $new->save();
    }
});
