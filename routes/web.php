<?php

use App\Models\City;
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
Route::group(['prefix' => "dashboard", "middleware" => ['auth'], 'namespace' => 'backend'], function () {

    // dashboard routes
    Route::get('/', 'DashboardController@welcome');
    route::get('/logout', "DashboardController@logout");

    //cities rotes
    Route::resource('/cities', "CityController");

    //statuses rotes
    Route::resource('/statuses', "statusController");

    //notes rotes
    Route::resource('/notes', "NoteController");

    //notes rotes
    Route::resource('/bundels', "BundleController");
    Route::patch('/bundelsUpdateDelivery', "BundleController@updateBundleDelivery")->name('staff.updateDelivery');
    Route::get('/bundels/signature/{bundel_id}', "BundleController@getBundelSignature")->name('bundel.signature.show');
    Route::patch('/bundels/signature/{bundel_id}', "BundleController@updateBundelSignature")->name('bundel.signature.update');

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

    $path = public_path("assets/dist/js/cities.json");
    $cities = json_decode(file_get_contents($path), true);

    foreach ($cities['cities'] as $city) {
        $new = new City();
        $new->libelle = $city["city"];
        $new->save();
    }
});
